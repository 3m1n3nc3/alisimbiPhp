<?php
function mainContent() {
    global $PTMPL, $LANG, $SETT, $configuration, $framework, $marxTime, $user, $profile, $user_role, $contact_;
    // Dont touch anything above this line

    $PTMPL['page_title'] = ucfirst($_GET['page']);
    $PTMPL['site_url'] = $SETT['url'];
    $account = '';
    $PTMPL['me'] = 'Me';
    if ($profile) { 
        $user = $profile;
        $PTMPL['me'] = ucfirst($profile['username']);
        $PTMPL['page_title'] = ucfirst($profile['username']).' Public Profile';
    }
    if ($user) {
        if ($_GET['page'] = 'account') { 
            $theme = new themer('account/profile_home');
            // $OLD_THEME = $PTMPL; $PTMPL = array();

            if (isset($_GET['profile'])) {
                if ($_GET['profile'] == 'home') { 
                    $theme = new themer('account/profile_home');
                    // $OLD_THEME = $PTMPL; $PTMPL = array();
                    // 
                }if ($_GET['profile'] == 'view') {
                    $theme = new themer('account/profile_view');
                    // $OLD_THEME = $PTMPL; $PTMPL = array();
                } elseif ($_GET['profile'] == 'update') {
                    $theme = new themer('account/profile_update');
                    // $OLD_THEME = $PTMPL; $PTMPL = array();
                    // 
                    // 
                    $modal_content = 
                    '<div class="row text-center">         
                        <div class="col mx-auto"> 
                            <div id="crop-preview" class="cropit"></div>
                            <div id="upload-photo" style="display: none;"></div> 
                        </div>  
                        <div class="container" id="action-buttons">                   
                            <div class="row">
                                <div class="col-md-12" style="padding:5%;">
                                    <label for="prof-photo" class="btn">
                                        Choose Image <i class="fa fa-photo"></i>
                                    </label>
                                    <input type="hidden" name="current_photo" value="'.$user['photo'].'">
                                    <input type="file" id="prof-photo" style="display: none;">
                                    <button class="btn btn-upload-image" style="margin-top:2%" onclick="upload_action()" disabled="disabled">
                                    Upload Photo
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mx-auto">
                            <div id="photo-message" class="text-center"></div>
                        </div>
                    </div>';

                    $PTMPL['photoModal'] = modal('photo', $modal_content);

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
            }

            $PTMPL['photo'] = getImage($user['photo'], 1);
            $PTMPL['fullname'] = $user['f_name'].' '.$user['l_name'];
            $PTMPL['firstname'] = $user['f_name'];
            $PTMPL['lastname'] = $user['l_name'];
            $PTMPL['username'] = ucfirst($user['username']);
            $PTMPL['email_add'] = $user['email'];
            $PTMPL['phone_'] = $user['phone'];

            $PTMPL['facebook'] = $user['facebook'];
            $PTMPL['twitter'] = $user['twitter'];
            $PTMPL['instagram'] = $user['instagram'];

            $PTMPL['instagram_link'] = $user['instagram'] ? '<a href="http://instagram.com/' . $user['instagram'] . '">http://instagram.com/' . $user['instagram'] . '</a>' : '';
            $PTMPL['twitter_link'] = $user['twitter'] ? '<a href="http://twitter.com/' . $user['twitter'] . '">http://instagram.com/' . $user['twitter'] . '</a>' : '';
            $PTMPL['facebook_link'] = $user['facebook'] ? '<a href="http://facebook.com/' . $user['facebook'] . '">http://facebook.com/' . $user['facebook'] . '</a>' : '';

			$social_links = '';
			$social_links .= $user['facebook'] ? '
				<tr>
					<td class="icon"><span class="icon fa fa-facebook"></span></td>
					<td class="item">Facebook</td>
					<td> <a href="http://facebook.com/' . $user['facebook'] . '">http://.com/' . $user['facebook'] . '</a></td>
				</tr>' : '';

			$social_links .= $user['facebook'] ? '
				<tr>
					<td class="icon"><span class="icon fa fa-twitter"></span></td>
					<td class="item">Twitter</td>
					<td> <a href="http://twitter.com/' . $user['twitter'] . '">http://twitter.com/' . $user['twitter'] . '</a></td>
				</tr>' : '';

			$social_links .= $user['instagram'] ? '
				<tr>
					<td class="icon"><span class="icon fa fa-instagram"></span></td>
					<td class="item">Instagram</td>
					<td> <a href="http://instagram.com/' . $user['instagram'] . '">http://instagram.com/' . $user['instagram'] . '</a></td>
				</tr>' : '';
			$PTMPL['social_links'] = $social_links;

			$PTMPL['city_'] = $user['city'];
            $PTMPL['state_'] = $user['state'];
            $PTMPL['country_'] = $user['country'];
            $PTMPL['state_select'] = $user['state'] ? '<option selected="selected" value="'.$user['state'].'">'.$user['state'].'</option>' : '<option disabled>Select your state</option>';
            $PTMPL['city_select'] = $user['city'] ? '<option selected="selected" value="'.$user['city'].'">'.$user['city'].'</option>' : '<option disabled>Select your city</option>';
            $PTMPL['about_'] = $user['about'];
            $PTMPL['update_profile'] = cleanUrls($SETT['url'].'/index.php?page=account&profile=update');

			$PTMPL['user_role'] = ucfirst($user['role']);

            // Create course and module links
            $PTMPL['add_course_link'] = secureButtons('background_green2 bordered', 'Add Course', 3, null, null);

            $PTMPL['add_module_link'] = secureButtons('background_green2 bordered', 'Add Module', 2, null, null);

            $all_courses_link = cleanUrls($SETT['url'].'/index.php?page=training');
            $PTMPL['all_courses_link'] = $all_courses_link;

            // If the user is administrative show the social inputs

            $modal_photo = 
            '<div class="row text-center">         
                <div class="col mx-auto"> 
                    <div id="photo-preview" class="cropit">
                        <img alt="Profile Photo" src="'.getImage($user['photo'], 1).'"/>
                    </div> 
                </div>   
            </div>';
            $PTMPL['photoPrevievModal'] = modal('photoPreview', $modal_photo, ucfirst($user['username']));

            $update_social = '';
            if ($user_role >= 3) {
                $update_social = '
                <div class="user-info-list card card-default p-3">
					<fieldset>
						<legend class="">Social media links</legend>
						<div class="form-group">
						<label class="hint">Facebook</label>
						<input type="text" name="facebook" class="form-control mx-2 m-1" id="facebook" value="'.$user['facebook'].'" placeholder="Facebook">
						</div>
						<div class="form-group">
						<label class="hint">Twitter</label>
						<input type="text" name="twitter" class="form-control mx-2 m-1" id="twitter" value="'.$user['twitter'].'" placeholder="Twitter">
						</div>
						<div class="form-group">
						<label class="hint">Instagram</label>
						<input type="text" name="instagram" class="form-control mx-2 m-1" id="instagram" value="'.$user['instagram'].'" placeholder="Instagram">
						</div>
					</fieldset>
				</div> ';
            }
            $PTMPL['update_social'] = $update_social;
        }  

		$courseArr = courseAccess(2);
		$course = '';
        if ($courseArr) {
            foreach ($courseArr as $rslt) {
              $course .= courseModuleCard($rslt);
            }
            $PTMPL['course'] = $course;
            $PTMPL['course_count'] = count($courseArr).' &nbsp;';

            $crnt = $courseArr[0];
            $cont_learning = cleanUrls($SETT['url'] . '/index.php?page=training&course=now_learning&courseid=' . $crnt['course_id'] . '&moduleid=' . $crnt['current_module']);

            $PTMPL['course_continue'] = '
            <div class="card-foot">
                <div class="card-action">
                    <a class="btn" href="'.$cont_learning.'">Continue learning</a>
                </div>
            </div>';       
        } else {
            $PTMPL['course'] = notAvailable('courses');
            $PTMPL['course_count'] = '0 &nbsp;';
        }
    } else {
        if (isset($_GET['process']) && $_GET['process'] == 'login') {
            // if ($user) {
            //     $framework->redirect();
            // }
            $theme = new themer('account/register'); $account = '';
            // $OLD_THEME = $PTMPL; $PTMPL = array();

            // get countries
            $countries = getLocale();
            $all_countries = '';
            foreach ($countries as $list) {
                $all_countries .= '<option value="'.$list['name'].'" id="'.$list['id'].'">'.$list['name'].'</option>';
            }
            $PTMPL['countries'] = $all_countries;
        } else {
            $framework->redirect('account&process=login&referrer='.urlencode($SETT['url'].$_SERVER['REQUEST_URI']));
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
