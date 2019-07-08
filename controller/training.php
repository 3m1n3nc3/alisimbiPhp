<?php
function mainContent() {
	global $PTMPL, $LANG, $SETT, $configuration, $framework, $marxTime, $user; 
	// Dont touch anything above this line

	$PTMPL['page_title'] = ucfirst($_GET['page']);	 
	$PTMPL['site_url'] = $SETT['url'];

	if ($user) {
        $theme = new themer('training/home'); $account = '';
        $OLD_THEME = $PTMPL; $PTMPL = array();
        $courseArr = getCourses();
        $course = '';
        foreach ($courseArr as $rslt) {
        	$photo = getImage($rslt['cover'], 1);
        	$intro = $framework->myTruncate($rslt['intro'], 200);
        	$course .= courseModuleCard($photo, $rslt['title'], $intro, '9 Mins', '$view', '$edit');
        }
        $PTMPL['course'] = $course;
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
