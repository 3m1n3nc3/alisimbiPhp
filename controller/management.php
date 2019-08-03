<?php
function mainContent() {
	global $PTMPL, $LANG, $SETT, $configuration, $framework, $marxTime, $user, $user_role; 
	// Dont touch anything above this line

	if ($user_role == 5) {
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
			$PTMPL['upload_limit'] = $_POST['upload_limit'];

			$PTMPL['smtp_server'] = $_POST['smtp_server'];
			$PTMPL['smtp_port'] = $_POST['smtp_port'];
			$PTMPL['smtp_username'] = $_POST['smtp_username'];
			$PTMPL['smtp_password'] = $_POST['smtp_password']; 

			$public_key = $framework->db_prepare_input($_POST['pub-key']);
			$private_key = $framework->db_prepare_input($_POST['pvt-key']);
			$sitename = $framework->db_prepare_input($_POST['sitename']);
			$currency = $framework->db_prepare_input($_POST['currency']);
			$cleanurl = $framework->db_prepare_input($_POST['cleanurl']);
			$ravemode = $framework->db_prepare_input($_POST['ravemode']);
			$site_mode = $framework->db_prepare_input($_POST['sitemode']);

			$upload_limit = $framework->db_prepare_input($_POST['upload_limit']);

			$smtp_ = $framework->db_prepare_input($_POST['smtp_']);
			$smtp_server = $framework->db_prepare_input($_POST['smtp_server']);
			$smtp_port = $framework->db_prepare_input($_POST['smtp_port']);
			$smtp_secure = $framework->db_prepare_input($_POST['smtp_secure']);
			$smtp_auth = $framework->db_prepare_input($_POST['smtp_auth']);
			$smtp_username = $framework->db_prepare_input($_POST['smtp_username']);
			$smtp_password = $framework->db_prepare_input($_POST['smtp_password']);

			$sql = sprintf("UPDATE " . TABLE_CONFIG . " SET `site_name` = '%s', `cleanurl` = '%s', " 
				. "`rave_public_key` = '%s', `rave_private_key` = '%s', `rave_mode` = '%s', `currency` = '%s', "
				. "`mode` = '%s' , `upload_lim` = '%s', `smtp` = '%s', `smtp_server` = '%s', `smtp_port` = '%s', "
				. "`smtp_secure` = '%s', `smtp_auth` = '%s',"
				. " `smtp_username` = '%s', `smtp_password` = '%s'", $sitename, $cleanurl, $public_key, $private_key, 
				$ravemode, $currency, $site_mode, $upload_limit, $smtp_, $smtp_server, $smtp_port, $smtp_secure, $smtp_auth, $smtp_username, 
				$smtp_password);
			$upd = $framework->dbProcessor($sql, 0, 1);
			$PTMPL['update_msg'] = $upd == 1 ? messageNotice('Site configuration has been updated', 1) : messageNotice($upd);
		} else {
			$PTMPL['public_k'] = $configuration['rave_public_key'];
			$PTMPL['private_k'] = $configuration['rave_private_key'];
			$PTMPL['sitename'] = $configuration['site_name'];

			$PTMPL['upload_limit'] = $configuration['upload_lim'];
			
			$PTMPL['smtp_server'] = $configuration['smtp_server'];
			$PTMPL['smtp_port'] = $configuration['smtp_port'];
			$PTMPL['smtp_username'] = $configuration['smtp_username'];
			$PTMPL['smtp_password'] = $configuration['smtp_password']; 
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
		$selected = ' selected="selected"';
		$PTMPL['no_ravemode'] = $PTMPL['no_cleanurl'] = $selected; 
		$PTMPL['ravemode'] = $configuration['rave_mode'] ? $selected : ''; 
		$configuration['smtp'] ? $PTMPL['smtp_en'] = ' checked' : $PTMPL['smtp_dis'] = ' checked'; 
		$PTMPL['cleanurl'] = $configuration['cleanurl'] ? $selected : '';
		$us['role'] == 'mod' ? $PTMPL['mod'] = $selected : $us['role'] == 'admin' ? $PTMPL['admin'] = $selected : $PTMPL['sudo'] = $selected;
		$configuration['mode'] ? $PTMPL['sitemod'] = $selected : $PTMPL['no_sitemode'] = $selected;
		$configuration['smtp_auth'] ? $PTMPL['smtp_auth'] = $selected : $PTMPL['no_smtp_auth'] = $selected;
		$configuration['smtp_secure'] == 'ssl' ? $PTMPL['smtp_secure_ssl'] = $selected : $configuration['smtp_secure'] == 'tls' ? $PTMPL['smtp_secure_tls'] = $selected : $PTMPL['smtp_secure_off'] = $selected;
	} else {
		$theme = new themer('container/404'); $settings = '';
		$PTMPL['page_title'] = '404 Error';
	}

    $settings = $theme->make();
    // $PTMPL = $OLD_THEME; unset($OLD_THEME);
	return $settings ;
}
?>	
