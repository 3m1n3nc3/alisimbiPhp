<?php
function mainContent() {
	global $PTMPL, $LANG, $SETT, $configuration, $framework, $marxTime, $user; 
	// Dont touch anything above this line

	$PTMPL['page_title'] = ucfirst($_GET['page']);	 
	$PTMPL['site_url'] = $SETT['url'];

    // If user is logged in
    if (isset($_GET['profile'])) {
        if ($user) {
            if ($_GET['profile'] == 'home') {
                $theme = new themer('account/profile_home'); $account = '';
                $OLD_THEME = $PTMPL; $PTMPL = array();
            } elseif ($_GET['profile'] == 'update') {
                $theme = new themer('account/profile_update'); $account = '';
                $OLD_THEME = $PTMPL; $PTMPL = array();
                $PTMPL['list_country'] = getLocale(3, $user['country']);
                if (isset($_POST['save_profile'])) {
                    $framework->firstname = $_POST['fname'];
                    $framework->lastname = $_POST['lname'];
                    $framework->phone = $_POST['phone'];
                    $framework->country = $_POST['country'];
                    $framework->state = $_POST['state'];
                    $framework->city = $_POST['city'];
                    $framework->about = $_POST['about'];
                    $framework->updateProfile();
                    $framework->redirect('account&profile=home');
                }
            }
            $PTMPL['photo'] = getImage($user['photo'], 1);
            $PTMPL['fullname'] = $user['f_name'].' '.$user['l_name'];
            $PTMPL['firstname'] = $user['f_name'];
            $PTMPL['lastname'] = $user['l_name'];
            $PTMPL['email_add'] = $user['email'];
            $PTMPL['phone_'] = $user['phone'];
            $PTMPL['city_'] = $user['city'];
            $PTMPL['state_'] = $user['state'];
            $PTMPL['country_'] = $user['country'];
            $PTMPL['about_'] = $user['about'];
            $PTMPL['update_'] = cleanUrls($SETT['url'].'/index.php?page=account&profile=update');
        } else {
            $framework->redirect();
        }

    // When user is not logged in
    } elseif (isset($_GET['register']) && $_GET['register'] == 'true' && !$user) {
        $theme = new themer('account/register'); $account = '';
        $OLD_THEME = $PTMPL; $PTMPL = array();

        // get countries
        $countries = getLocale();
        $all_countries = '';
        foreach ($countries as $list) {
            $all_countries .= '<option value="'.$list['name'].'" id="'.$list['id'].'">'.$list['name'].'</option>';
        }
        $PTMPL['countries'] = $all_countries;
    } else {
        $framework->redirect('account&profile=home'); 
    }

    	// Change themer('hompage/content') to themer('yourhtmldirectory/yourfile')
        $account = $theme->make();
        $PTMPL = $OLD_THEME; unset($OLD_THEME);  
    	return $account ;
    }
?>