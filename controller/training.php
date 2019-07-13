<?php
function mainContent() {
	global $PTMPL, $LANG, $SETT, $configuration, $framework, $marxTime, $user;
	// Dont touch anything above this line

	$PTMPL['page_title'] = ucfirst($_GET['page']);
	$PTMPL['site_url'] = $SETT['url'];
	$PTMPL['copyrights_'] = '&copy; '. date('Y').' '.$contact_['c_line'];
	$PTMPL['site_title_'] = $configuration['site_name'];

	if ($user) {
		if (isset($_GET['course'])) {

<<<<<<< HEAD
		    $course = getCourses(1, $_GET['courseid'])[0];
    		$PTMPL['course_title'] = $course['title'];
    		$PTMPL['course_cover'] = '<p><img style="width: 250px; float: left; padding: 10px;" src="'.getImage($course['cover'], 1).'" class="image_class"></p>';
    		$PTMPL['course_cover_url'] = getImage($course['cover'], 1);
    		$PTMPL['course_intro'] = $course['intro'];
    		$moduleArr = getModules(1, $_GET['courseid']);
    		$modules = '';
    		foreach ($moduleArr as $mAr) {
    			$modules .= courseModuleCard($mAr, 1);
    		}
    		$get = cleanUrls($SETT['url'].'/index.php?page=training&course=get&courseid='.$_GET['courseid']);
    		$PTMPL['course_modules'] = $modules;
    		$PTMPL['course_get_btn_url'] = $get;
    		$PTMPL['course_toggle_descr'] = '<a href="#course_descr" class="action_toggle" data-toggle="collapse">Toggle description</a>';
    		// $PTMPL['course_'] = $course[''];
=======
			if (isset($_GET['courseid']) && $_GET['courseid'] != '' && $_GET['course'] != 'add' && $_GET['course'] != 'edit') {
			    $course = getCourses(1, $_GET['courseid'])[0];
	    		$PTMPL['course_title'] = $course['title'];
	    		$PTMPL['course_cover'] = '<p><img style="width: 250px; float: left; padding: 10px;" src="'.getImage($course['cover'], 1).'" class="image_class"></p>';
	    		$PTMPL['course_intro'] = $course['intro'];
	    		$moduleArr = getModules(1, $_GET['courseid']);
	    		$modules = '';
	    		foreach ($moduleArr as $mAr) {
	    			$modules .= courseModuleCard($mAr, 1);
	    		}
	    		$get = cleanUrls($SETT['url'].'/index.php?page=training&course=get&courseid='.$_GET['courseid']);
	    		$PTMPL['course_modules'] = $modules;
	    		$PTMPL['course_get_btn'] = '<a href="'.$get.'" class="btn btn-md btn-success"><i class="fa fa-credit-card"></i>Get Course</a>';
	    		// $PTMPL['course_'] = $course[''];
			}
>>>>>>> 1978b98bc9a2372918e7d0bde4b763b63412a6e4

    		/*if you are viewing the course details*/
			if ($_GET['course'] == 'view') {
		      $theme = new themer('training/course_info'); $account = '';
		        // $OLD_THEME = $PTMPL; $PTMPL = array();

    		/*if you are paying for the course details*/
			} elseif ($_GET['course'] == 'get') {
		      	$theme = new themer('training/course_get'); $account = '';
    			$PTMPL['raveverified'] = getImage('raveverified.png');
    			$PTMPL['course_price'] = $course['price'].' NGN';

    			/* Rave checkout variables*/
    			 // Rave API Public key
				 	$public_key = $configuration['rave_public_key'];
				 	 // Rave API Private key
					$private_key = $configuration['rave_private_key'];
					// Check if sandbox is enabled
					$ravemode = ($configuration['rave_mode'] ? 'api.ravepay.co' : 'ravesandboxapi.flutterwave.com');
					 // Currency Code
					$currency_code 	= $configuration['currency'];
					// Url to redirect to to verify rave
					$successful_url	= $SETT['url'].'/connection/raveAPI.php';
					isset($_SESSION['txref']) ? $reference = $_SESSION['txref'] : $reference = '';

				/*if you are adding or editing courses*/
			} elseif ($_GET['course'] == 'add' || $_GET['course'] == 'edit') {
		    	$theme = new themer('training/course_add_edit'); $account = '';
	    		
		    	$PTMPL['course_create_btn'] = 'Create Course';
				$PTMPL['course_create_header'] = 'Create a new course';

	    		// If you are editing this course, use the db values as value
	    		if (isset($_GET['courseid'])) {
	    			$course = getCourses(1, $_GET['courseid'])[0];
	    			if ($course) {
						$PTMPL['course_title'] = $course['title'];
						$PTMPL['introduction'] = $course['intro'];
						$PTMPL['date'] = $course['start'];
						$PTMPL['status'] = $course['status']; 
						$PTMPL['course_create_btn'] = 'Update Course';
						$PTMPL['course_create_header'] = 'Update Course: '.$course['title'];
	    			} 
	    		}

	    		// Save the profile info
				if (isset($_POST['save'])) { 
		    		$PTMPL['course_title'] = $_POST['course_title'];
					$PTMPL['introduction'] = $_POST['introduction'];
					$PTMPL['date'] = $_POST['date'];
					$PTMPL['status'] = $_POST['status']; 

					$framework->course_title = $framework->db_prepare_input($_POST['course_title']);
					$framework->introduction = $framework->db_prepare_input($_POST['introduction']);
					$framework->benefits = $framework->db_prepare_input($_POST['benefits']);
					$date = date('Y-m-d H:m:i', strtotime($framework->db_prepare_input($_POST['date'])));
					$framework->start = $date;
					$framework->status = $framework->db_prepare_input($_POST['status']);
					$framework->files = $_FILES; 

					if ($_POST['course_title'] == '') {
						$msg = errorMessage($LANG['no_empty_title']);
					} elseif ($_POST['introduction'] == '') {
						$msg = errorMessage($LANG['no_empty_intro']);
					} elseif (empty($_FILES['cover_photo'])) {
						$msg = errorMessage($LANG['no_empty_cover']);
					} else {
						// Check if images uploaded without errors
						$eck_1 = $framework->uploader($_FILES['badge'], 1, 1);
						$eck_2 = $framework->uploader($_FILES['cover_photo'], 0, 1);
						$eck_err = ' ';
						if (!isset($_GET['courseid']) && ($eck_1 !== 1 || $eck_2 !== 1)) {
							$eck_err .= $eck_1 !==1 ? ' '.$eck_1 : '';
							$eck_err .= $eck_2 !==1 ? ' '.$eck_2 : '';
							$msg = errorMessage($eck_err);
						} else {  
							// If files uploaded without errors, proceed to save.
							if (isset($_GET['courseid'])) {
								$framework->cover_photo = empty($_FILES['cover_photo']['name']) ? $course['cover'] : 
								$framework->uploader($_FILES['cover_photo'], 0);
								$framework->badge = empty($_FILES['badge']['name']) ? $course['badge'] : 
								$framework->uploader($_FILES['badge'], 0);
							} else {
								$framework->cover_photo = $framework->uploader($_FILES['cover_photo'], 0);
								$framework->badge = $framework->uploader($_FILES['badge'], 1);
							}

							// Save the input
							if ($_GET['course'] == 'add') {
								$response = $framework->courseModuleEntry(0);
								$resp = successMessage($LANG['course_added']);
							} elseif ($_GET['course'] == 'edit') {
								$framework->course_id = $framework->db_prepare_input($_GET['courseid']);
								$response = $framework->courseModuleEntry(1);
								$resp = successMessage($LANG['course_updated']);
							}
							if ($response == 1) {
								$msg = $resp;
							} else {
								$msg = infoMessage($response);
							}
						}
					}
					$PTMPL['course_message'] = $msg;
				}
			}
		} else {
	        $theme = new themer('training/home'); $account = '';
	        // $OLD_THEME = $PTMPL; $PTMPL = array();
	        $courseArr = getCourses();
	        $course = '';
	        foreach ($courseArr as $rslt) {
	        	$course .= courseModuleCard($rslt);
	        }
	        $PTMPL['course'] = $course;
		}
	} else {
		$framework->redirect();
	}
	if (isset($_GET['view'])) {
		$vloger = getVlog($_GET['view'])[0];
		$PTMPL['vlog_title'] = $vloger['title'];
		$PTMPL['vlog_photo'] = '<p><img src="'.getImage($vloger['image'], 1).'" class="image_class"></p>';
		$PTMPL['vlog_content'] = $vloger['content'];
		$video_source = $framework->determineLink($vloger['video']);
		$PTMPL['vlog_video'] = getVideo($vloger['video']);
		$PTMPL['vlog_date'] = $marxTime->timeAgo(strtotime($vloger['date']), 1);
	}

	// Dont touch anything below this line
	$render = $theme->make();
    // $PTMPL = $OLD_THEME; unset($OLD_THEME);
	return $render;
}
?>
