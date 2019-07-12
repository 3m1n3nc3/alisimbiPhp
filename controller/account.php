<?php
function mainContent() {
	global $PTMPL, $LANG, $SETT, $configuration, $framework, $marxTime, $user, $user_role, $contact_;
	// Dont touch anything above this line

	$PTMPL['page_title'] = ucfirst($_GET['page']);
	$PTMPL['site_url'] = $SETT['url'];
	$account = '';
    if ($user) {
        if (isset($_GET['profile'])) {
            if ($_GET['profile'] == 'home') {
                $theme = new themer('account/profile_home');
                // $OLD_THEME = $PTMPL; $PTMPL = array();
            } elseif ($_GET['profile'] == 'update') {
                $theme = new themer('account/profile_update');
                $OLD_THEME = $PTMPL; $PTMPL = array();
                $PTMPL['list_country'] = getLocale(3, $user['country']);
                if (isset($_POST['save_profile'])) {
                    $framework->firstname = $_POST['fname'];
                    $framework->lastname = $_POST['lname'];
                    $framework->phone = $_POST['phone'];
                    $framework->country = $_POST['country'];
                    $framework->state = isset($_POST['state']) ? $_POST['state'] : $user['state'];
                    $framework->city = isset($_POST['city']) ? $_POST['city'] : $user['city'];
                    $framework->about = $_POST['about'];
                    if ($user_role >= 3) {
                        $framework->facebook = $_POST['facebook'];
                        $framework->twitter = $_POST['instagram'];
                        $framework->instagram = $_POST['twitter'];
                        $framework->social = 1;
                    }
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

            $PTMPL['facebook'] = $user['facebook'];
            $PTMPL['twitter'] = $user['twitter'];
            $PTMPL['instagram'] = $user['instagram'];

            $PTMPL['instagram_link'] = $user['instagram'] ? '<a href="http://instagram.com/' . $user['instagram'] . '">http://instagram.com/' . $user['instagram'] . '</a>' : '';
            $PTMPL['twitter_link'] = $user['twitter'] ? '<a href="http://twitter.com/' . $user['twitter'] . '">http://instagram.com/' . $user['twitter'] . '</a>' : '';
            $PTMPL['facebook_link'] = $user['facebook'] ? '<a href="http://facebook.com/' . $user['facebook'] . '">http://facebook.com/' . $user['facebook'] . '</a>' : '';

            $PTMPL['city_'] = $user['city'];
            $PTMPL['state_'] = $user['state'];
            $PTMPL['country_'] = $user['country'];
            $PTMPL['state_select'] = $user['state'] ? '<option selected="selected" value="'.$user['state'].'">'.$user['state'].'</option>' : '<option disabled>Select your state</option>';
            $PTMPL['city_select'] = $user['city'] ? '<option selected="selected" value="'.$user['city'].'">'.$user['city'].'</option>' : '<option disabled>Select your city</option>';
            $PTMPL['about_'] = $user['about'];
            $PTMPL['update_'] = cleanUrls($SETT['url'].'/index.php?page=account&profile=update');

			$PTMPL['user_role'] = ucfirst($user['role']);

            // If the user is administrative show the social inputs
            $update_social = '';
            if ($user_role >= 3) {
                $update_social = '
                <div class="border rounded p-2 m-1">
                    Facebook | Twitter | Instagram
                    <hr>
                    <p class="card-text form-inline">
                        <input type="text" name="facebook" class="form-control mx-2 m-1" id="facebook" value="'.$user['facebook'].'" placeholder="Facebook">
                        <input type="text" name="twitter" class="form-control mx-2 m-1" id="twitter" value="'.$user['twitter'].'" placeholder="Twitter">
                        <input type="text" name="instagram" class="form-control mx-2 m-1" id="instagram" value="'.$user['instagram'].'" placeholder="Instagram">
                    </p>
                </div>';
            }
            $PTMPL['update_social'] = $update_social;


        // When user is not logged in
        } else {
            $framework->redirect('account&profile=home');
        }

				$courseArr = getCourses();
				$course = '';
				foreach ($courseArr as $rslt) {
                    $course .= courseModuleCard($rslt);
				}
				$PTMPL['course'] = $course;

    } else {
        if (isset($_GET['register']) && $_GET['register'] == 'true') {
            if ($user) {
                $framework->redirect();
            }
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
            $framework->redirect();
        }
    }
		$PTMPL['copyrights_'] = '&copy; '. date('Y').' '.$contact_['c_line'];
		$PTMPL['site_title_'] = $configuration['site_name'];

    	// Change themer('hompage/content') to themer('yourhtmldirectory/yourfile')
        $account = $theme->make();
        // $PTMPL = $OLD_THEME; unset($OLD_THEME);
    	return $account ;
    }
?>
