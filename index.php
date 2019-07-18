<?php
require_once(__DIR__ . '/includes/autoload.php');

if(isset($_GET['page']) && isset($action[$_GET['page']])) {
	$page_name = $action[$_GET['page']];
} else {
	$page_name = 'homepage';
}
if ($user && $page_name == 'homepage') {
	// $framework->redirect('account&profile=home');
}

require_once("controller/{$page_name}.php");

$PTMPL['site_title'] = $configuration['site_name'];
$PTMPL['site_logo'] = getImage('logo-full.png', 2);
$PTMPL['site_url'] = $SETT['url'];
$PTMPL['favicon'] = 'favicon.ico';

$captcha_url = '/includes/vendor/goCaptcha/goCaptcha.php?gocache='.strtotime('now');
$PTMPL['captcha_url'] = $SETT['url'].$captcha_url;

//$PTMPL['token'] = $_SESSION['token_id'];

$PTMPL['language'] = $_COOKIE['lang'];

$PTMPL['register_link'] = cleanUrls($SETT['url'].'/?page=account&register=true');

$PTMPL['set_country'] = set_local(1, '');
$PTMPL['global_header'] = headerFooter(1);
$PTMPL['global_footer'] = headerFooter(0);


$benefits = '';
$getBenefits = getBenefits();
if ($getBenefits) {
	foreach ($getBenefits as $key => $value) {
		$benefits .= '
		<span style="cursor: pointer;" class="ben" id="list_benefit_'
			.$value['id'].'">'.$value['title'].'</span>';
	}
}
$PTMPL['show_benefits'] = $benefits;

// Show the list of available courses on the homepage
$coursesArr = getCourses();
$courses = '';
if ($coursesArr) {
	foreach ($coursesArr as $rslt) {
		$courses .= courseModuleCard($rslt);
	}
	$PTMPL['available_courses'] = $courses;
}

// Get the latest course available
$new_course = getCourses();
$course_new = array_reverse($new_course)[0];
$courses_modules = '';
$PTMPL['course_get_new'] = cleanUrls($SETT['url'].'/index.php?page=training&course=get&courseid='.$course_new['id']);
$PTMPL['course_title_new'] = $course_new['title'];
$PTMPL['course_cover_new'] = getImage($course_new['cover'], 1);
$PTMPL['course_intro_new'] = $course_new['intro'];
$PTMPL['course_benefits_new'] = fetchBenefits($course_new['id']);

$module_newArr = getModules(1, $course_new['id']);
if ($module_newArr) {
	foreach ($module_newArr  as $rslt) {
        $courses_modules .= courseModuleCard($rslt, 1, 0);
	}
	$PTMPL['course_modules_new'] = $courses_modules;
} else {
    $PTMPL['course_modules_new'] = notAvailable('Modules');	
}

// Logout url
$PTMPL['logout_url'] = cleanUrls($SETT['url'] . '/index.php?page=homepage&logout=true');

// Get a list of instructors for the new course
$instructorsArr = getInstructors($course_new['id']);

$instructor = '';
$course_instructor = '';

if ($instructorsArr) {
	foreach ($instructorsArr as $ins) {
		$instructor .= instructorCard($ins);
		$course_instructor .= instructorCard($ins, 1);
	}
	$PTMPL['instructor'] = $instructor;
	$PTMPL['course_instructor'] = $course_instructor;
} else {
	$PTMPL['instructor'] = notAvailable('Instructors');
	$PTMPL['course_instructor'] = notAvailable('Instructors');
}
// Render the page
$PTMPL['content'] = mainContent(); 

$theme = new themer('container');
echo $theme->make();

?>
