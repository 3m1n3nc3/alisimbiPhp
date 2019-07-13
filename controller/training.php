<?php
function mainContent() {
	global $PTMPL, $LANG, $SETT, $configuration, $framework, $marxTime, $user;
	// Dont touch anything above this line

	$PTMPL['page_title'] = ucfirst($_GET['page']);
	$PTMPL['site_url'] = $SETT['url'];
	$PTMPL['copyrights_'] = '&copy; '. date('Y').' '.$contact_['c_line'];
	$PTMPL['site_title_'] = $configuration['site_name'];

	if ($user) {
		if (isset($_GET['course']) && isset($_GET['courseid']) && $_GET['courseid'] != '' || $_GET['course'] == 'add') {

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
			} elseif ($_GET['course'] == 'add') {
		    	$theme = new themer('training/course_add_edit'); $account = '';
					if (isset($_POST['save'])) {
						print_r($_POST);
						$framework->course_title = $framework->db_prepare_input($_POST['course_title']);
						$framework->introduction = $framework->db_prepare_input($_POST['introduction']);
						$framework->cover_photo = $framework->db_prepare_input($_POST['cover_photo']);
						$framework->badge = $framework->db_prepare_input($_POST['badge']);
						$framework->benefits = $framework->db_prepare_input($_POST['benefits']);
						$framework->date = $framework->db_prepare_input($_POST['date']);
						$framework->status = $framework->db_prepare_input($_POST['status']);
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
