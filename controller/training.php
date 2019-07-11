<?php
function mainContent() {
	global $PTMPL, $LANG, $SETT, $configuration, $framework, $marxTime, $user; 
	// Dont touch anything above this line

	$PTMPL['page_title'] = ucfirst($_GET['page']);	 
	$PTMPL['site_url'] = $SETT['url'];

	if ($user) {
		if (isset($_GET['course'])) {
			if ($_GET['course'] == 'view' && isset($_GET['courseid']) && $_GET['courseid'] != '') {
		        $theme = new themer('training/course_info'); $account = '';
		        $OLD_THEME = $PTMPL; $PTMPL = array();
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
		} else {
	        $theme = new themer('training/home'); $account = '';
	        $OLD_THEME = $PTMPL; $PTMPL = array();
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
    $PTMPL = $OLD_THEME; unset($OLD_THEME);  
	return $render;
}
?>	
