<?php
function mainContent() {
	global $PTMPL, $LANG, $SETT, $configuration, $framework, $marxTime, $user, $user_role; 
	// Dont touch anything above this line

	$PTMPL['page_title'] = ucfirst($_GET['page']);	 
	$PTMPL['site_url'] = $SETT['url'];

	if ($user) {

		if (isset($_GET['course'])) {
	        if ($_GET['course'] == 'view') {
		        $theme = new themer('training/course_info'); $account = '';
		        $OLD_THEME = $PTMPL; $PTMPL = array();

	        	$course = getCourses(1, $_GET['courseid'])[0];
	        	$PTMPL['course_title'] = $course['title'];
	        	$PTMPL['course_intro'] = $course['intro'];
	        	$PTMPL['course_cover'] = '<img height="150px" style="float:left;" class="m-4" src="'.getImage($course['cover'], 1).'">';
	        	$PTMPL['course_badge'] = $course['badge'];
	        	// $PTMPL['course_'] = $course[''];
	        }
		} else {
	        $theme = new themer('training/home'); $account = '';
	        $OLD_THEME = $PTMPL; $PTMPL = array();
		}
        $courseArr = getCourses();
        $course = '';
        foreach ($courseArr as $rslt) {
        	$photo = getImage($rslt['cover'], 1);
        	$view_link = cleanUrls($SETT['url'].'/index.php?page=training&course=view&courseid='.$rslt['id']);
        	$edit_link = cleanUrls($SETT['url'].'/index.php?page=training&course=edit&courseid='.$rslt['id']);
        	$intro = $framework->myTruncate($rslt['intro'], 200);
        	$course .= courseModuleCard($photo, $rslt['title'], $intro, '9 Mins', $view_link, $edit_link);
        }
        $PTMPL['course'] = $course;
        $add_link = cleanUrls($SETT['url'].'/index.php?page=training&course=add');
        $PTMPL['add_course'] = $user_role >= 3 ? '<a class="btn btn-primary" href="'.$add_link.'" id="add_course">Add New Course</a>' : '';
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
