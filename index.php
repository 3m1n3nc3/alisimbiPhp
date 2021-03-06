<?php
require_once(__DIR__ . '/includes/autoload.php');

if(isset($_GET['page']) && isset($action[$_GET['page']])) {
	$page_name = $action[$_GET['page']];
} else {
	$page_name = 'homepage';
}

if (isset($_GET['logout'])) {
    $framework->sign_out();
}

require_once("controller/{$page_name}.php");

$PTMPL['site_title'] = $configuration['site_name'];
$PTMPL['site_logo'] = getImage('logo-full.png', 2);
$PTMPL['site_url'] = $SETT['url'];
$PTMPL['upload_limit'] = $configuration['upload_lim'];
$PTMPL['favicon'] = 'favicon.ico';

$captcha_url = '/includes/vendor/goCaptcha/goCaptcha.php?gocache='.strtotime('now');
$PTMPL['captcha_url'] = $SETT['url'].$captcha_url;

//$PTMPL['token'] = $_SESSION['token_id'];

$PTMPL['language'] = isset($_COOKIE['lang']) ? $_COOKIE['lang'] : '';

$PTMPL['register_link'] = cleanUrls($SETT['url'].'/index.php?page=account&register=true');
$PTMPL['forgot_link'] = cleanUrls($SETT['url'].'/index.php?page=account&password_reset=true');

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
} else {
	$benefits .= notAvailable('Benefits have been indicated for this course');
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
} else {
	$PTMPL['available_courses'] = notAvailable('Active Courses');
}

// Get the latest course available
$new_course = getCourses();
if ($new_course) {
	$course_new = array_reverse($new_course)[0];
	$courses_modules = '';
	$PTMPL['course_get_new'] = cleanUrls($SETT['url'].'/index.php?page=training&course=get&process=payment&courseid='.$course_new['id']);
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
	    $PTMPL['course_modules_new'] = notAvailable('Modules for this course');
	}

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
}

// Logout url
$PTMPL['logout_url'] = cleanUrls($SETT['url'] . '/index.php?page=homepage&logout=true');

// Login toggle
if ($user) { 
	$page = cleanUrls($SETT['url'] . '/index.php?page=account&profile=home');
	$logout = cleanUrls($SETT['url'] .'/index.php?logout=true');
	$PTMPL['login_toggle'] = '
	<a data-title="Login" data-toggle="tooltip" href="'.$page.'" title="Login">
		<div class="toggle_icon">
			<span class="fa fa-user-circle"></span>
			<span class="text">Account </span>
		</div>
	</a>
	<a data-title="Login" href="'.$logout.'" title="Logout">
		<div class="toggle_icon">
			<span class="fa fa-sign-out"></span>
			<span class="text">Logout </span>
		</div>
	</a>';
} else {
	$PTMPL['login_toggle'] = '
	<div class="toggle_icon ss-btn" data-target="login">
	    <a data-title="Login" data-toggle="tooltip" href="#" title="Login">
	        <span class="fa fa-user-circle"></span>
	    </a>
	    <span class="text">Login </span>
	</div>';
}

// Render the page
$PTMPL['content'] = mainContent();

$theme = new themer('container');
echo $theme->make();


