<?php
require_once(__DIR__ . '/includes/autoload.php'); 
 
if(isset($_GET['a']) && isset($action[$_GET['a']])) {
	$page_name = $action[$_GET['a']];
} else {
	$page_name = 'welcome';
} 
 
require_once("controller/{$page_name}.php");  

$PTMPL['site_title'] = $configuration['site_name']; 
$PTMPL['site_url'] = $SETT['url'];
$PTMPL['favicon'] = 'favicon.ico';

$captcha_url = '/includes/vendor/goCaptcha/goCaptcha.php?gocache='.strtotime('now');
$PTMPL['captcha_url'] = $SETT['url'].$captcha_url;

//$PTMPL['token'] = $_SESSION['token_id'];  
  
$PTMPL['language'] = $_COOKIE['lang']; 

// Render the page
$PTMPL['content'] = mainContent();   

$theme = new themer('container');
echo $theme->make();
  
?>