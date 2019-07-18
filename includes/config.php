<?php
error_reporting(E_ALL);
/*
 * magic-quotes support, for runtime e, will cause problems if enabled so turn it off
 */
if (version_compare(PHP_VERSION, 5.3, '<') && function_exists('set_magic_quotes_runtime')) set_magic_quotes_runtime(0);


$SETT = $PTMPL = array();

/*
* set currentPage in the local scope
*/
$SETT['current_page'] = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);

/*
* The MySQL credentials
*/
define('DB_PREFIX', '');
$SETT['dbdriver'] = 'mysql';
$SETT['dbhost'] = 'localhost';
$SETT['dbuser'] = 'root';
$SETT['dbpass'] = 'idontknow1A@';
$SETT['dbname'] = 'alisimbi';

/*
* The Installation URL
* https is enforced in .HTACCESS, to use the auto protocol feature remove the .HTACCESS https enforcement
*/
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https' : 'http';
$SETT['url'] = $protocol.'://'.$_SERVER['HTTP_HOST'];

/*
* The Notifications e-mail
*/
$SETT['email'] = 'support@passengine.com';

/*
* The templates directory
*/
$SETT['template_path'] = 'templates';

$action = array(
				'welcome'					=> 'welcome',
				'news'						=> 'news',
				'account'					=> 'account',
				'training'					=> 'training'
				);

/*
* Define the cookies path
*/
define('COOKIE_PATH', preg_replace('|'.$protocol.'?://[^/]+|i', '', $SETT['url']).'/');

?>
