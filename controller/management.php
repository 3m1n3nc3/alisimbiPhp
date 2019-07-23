<?php
function mainContent() {
	global $PTMPL, $LANG, $SETT, $configuration, $framework, $marxTime, $user, $user_role; 
	// Dont touch anything above this line

	if ($user_role >= 3) {
	    $theme = new themer('management/content'); $settings = '';
	    // $OLD_THEME = $PTMPL; $PTMPL = array();
	    // 
		$PTMPL['page_title'] = ucfirst($_GET['page']);	 
		$PTMPL['site_url'] = $SETT['url'];
		
		//Show user role
		$PTMPL['user_priviledge'] = ucfirst($user['role']);
		$PTMPL['hidden'] = $user_role < 4 ? ' style="display: none;"' : '';
		$PTMPL['hidden_submit'] = $user_role == 4 ? '<input type="submit" name="save_config" class="btn" value="Save Configuration">'  : '';

		if (isset($_POST['save_config'])) { 
			$PTMPL['public_k'] = $_POST['pub-key'];
			$PTMPL['private_k'] = $_POST['pvt-key'];
			$PTMPL['sitename'] = $_POST['sitename'];

			$public_key = $framework->db_prepare_input($_POST['pub-key']);
			$private_key = $framework->db_prepare_input($_POST['pvt-key']);
			$sitename = $framework->db_prepare_input($_POST['sitename']);
			$currency = $framework->db_prepare_input($_POST['currency']);
			$cleanurl = $framework->db_prepare_input($_POST['cleanurl']);
			$ravemode = $framework->db_prepare_input($_POST['ravemode']);

			$sql = sprintf("UPDATE " . TABLE_CONFIG . " SET `site_name` = '%s', `cleanurl` = '%s', `rave_public_key` = '%s',"
				. " `rave_private_key` = '%s', `rave_mode` = '%s', `currency` = '%s'", $sitename, $cleanurl, $public_key, 
				$private_key, $ravemode, $currency);
			$upd = $framework->dbProcessor($sql, 0, 1);
			$PTMPL['update_msg'] = $upd == 1 ? messageNotice('Site configuration has been updated', 1) : messageNotice($upd);
		} else {
			$PTMPL['public_k'] = $configuration['rave_public_key'];
			$PTMPL['private_k'] = $configuration['rave_private_key'];
			$PTMPL['sitename'] = $configuration['site_name'];
		}

		// Check if an Admin user exists
		$us = $framework->userData('admin');
		$PTMPL['updateadmin'] = $us['username'] ? '<input type="submit" name="update_admin" class="btn" value="Update Admin">' : '<input type="submit" name="create_admin" class="btn" value="Create Admin">';

		if (isset($_POST['create_admin']) || isset($_POST['update_admin'])) {
			$PTMPL['email'] = $_POST['email'];
			$email = $framework->db_prepare_input($_POST['email']);
			$password = hash('md5', $framework->db_prepare_input($_POST['password']));
			if ($email == '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$PTMPL['update_admin_msg'] = messageNotice('Invalid Email Address', 3);
			} elseif ($_POST['password'] == '') {
				$PTMPL['update_admin_msg'] = messageNotice('Invalid Password', 3);
			}  elseif (strlen($_POST['password']) < 9) {
				$PTMPL['update_admin_msg'] = messageNotice('Password Too Short, needs to contain at least 9 characters', 3);
			} else {
				if (isset($_POST['create_admin'])) {
					$sql = sprintf("INSERT INTO " . TABLE_USERS . " (`username`, `password`, `email`, `role`, `rating`, `token`) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')", 'admin', $password, $email, 'sudo', 5, $framework->generateToken(null, 2));
					$upd = $framework->dbProcessor($sql, 0, 1);
					$PTMPL['update_admin_msg'] = $upd == 1 ? messageNotice('Admin user has been created', 1) : messageNotice($upd);
				} elseif (isset($_POST['update_admin'])) {
					$sql = sprintf("UPDATE " . TABLE_USERS . " SET `password` = '%s', `email` = '%s', `token` = '%s'", $password, $email, $framework->generateToken(null, 2));
					$upd = $framework->dbProcessor($sql, 0, 1);
					$PTMPL['update_admin_msg'] = $upd == 1 ? messageNotice('Admin user has been updated', 1) : messageNotice($upd);
				}
			}
		}

		$PTMPL['no_ravemode'] = $PTMPL['no_cleanurl'] = ' selected="selected"'; 
		$PTMPL['ravemode'] = $configuration['rave_mode'] ? ' selected="selected"' : ''; 
		$PTMPL['cleanurl'] = $configuration['cleanurl'] ? ' selected="selected"' : '';
		$us['role'] == 'mod' ? $PTMPL['mod'] = ' selected="selected"' : $us['role'] == 'admin' ? $PTMPL['admin'] = ' selected="selected"' : $PTMPL['sudo'] = ' selected="selected"';
	}

    $settings = $theme->make();
    // $PTMPL = $OLD_THEME; unset($OLD_THEME);
	return $settings ;
}
?>	
