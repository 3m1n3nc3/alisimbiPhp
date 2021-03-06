<?php

// Set the defult timezone
date_default_timezone_set("Africa/Lagos");

// Set the site configuration here
// Default configuration
//$configuration = array('language' => 'default', 'site_name' => 'Passengine', 'site_phone' => '09031983482'
//	, 'twillio_phone' => '+1092292922');
// You can pass this configuration information from a database, your database should contain the default
// configuration variables
$configuration = configuration();

// Store the theme path and theme name into the CONF and TMPL
$PTMPL['template_path'] = $SETT['template_path'];
$PTMPL['template_name'] = $SETT['template_name'] = 'default';//$configuration['template'];
$PTMPL['template_url'] = $SETT['template_url'] = $SETT['template_path'].'/'.$SETT['template_name'];

// Check who is logged in right now
if (isset($_SESSION['username'])) { 
	$user = $framework->userData($_SESSION['username'], 2);
	$user_role = $framework->userRoles();
} elseif (isset($_COOKIE['username'])) {
	$user = $framework->userData($_COOKIE['username'], 2);
}

if (isset($_GET['profile']) && isset($_GET['username'])) { 
	$profile = $framework->userData($framework->db_prepare_input($_GET['username']), 2); 
}

if (isset($_GET['referrer'])) {
	$_SESSION['referrer'] = $_GET['referrer'];
	$referrer = $_GET['referrer'];
} else {
	$referrer = null;
}

$user_role = $framework->userRoles();
$contact_ = getContactInfo()[0];
