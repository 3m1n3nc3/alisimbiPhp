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

		$PTMPL['no_ravemode'] = $PTMPL['no_cleanurl'] = ' selected="selected"'; 
		$PTMPL['ravemode'] = $configuration['rave_mode'] ? ' selected="selected"' : ''; 
		$PTMPL['cleanurl'] = $configuration['cleanurl'] ? ' selected="selected"' : '';
	}

    $settings = $theme->make();
    // $PTMPL = $OLD_THEME; unset($OLD_THEME);
	return $settings ;
}
?>	
