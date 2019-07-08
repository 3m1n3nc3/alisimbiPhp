<?php 
require_once(__DIR__ .'/../includes/autoload.php');
 
$status = 0;
$header = 0;
if (isset($_POST['login'])) {
	$username = $framework->db_prepare_input(mb_strtolower($_POST['username']));
	$password = hash('md5', $framework->db_prepare_input($_POST['password']));

	$user_data = $framework->userData($username, 2);

	$framework->username = $username;
	$framework->password = $password; 
	$framework->remember = $_POST['remember'] == 'on' ? 1 : 0;

	$verify_username = filter_var($username, FILTER_VALIDATE_EMAIL) && $username == $user_data['email'] ? true : ($username == $user_data['username'] ? true : false);

	if ($username == '' || $password == '') {
     	$msg = errorMessage($LANG['_user_required']);  
    } elseif (!$verify_username) {
		$msg = infoMessage($LANG['invalid_username']);
	} elseif ($framework->userData($username, 2)['password'] != $password) {
		$msg = errorMessage($LANG['invalid_password']);
	} else {
		$msg = successMessage($LANG['login_success']); 
		$status = 1;
		$framework->authenticateUser();
		$header = cleanUrls($SETT['url'].'/index.php?page=account&profile=home');
	}
} elseif (isset($_POST['register'])) {
	$username = $framework->db_prepare_input(mb_strtolower($_POST['username']));
	$password = hash('md5', $framework->db_prepare_input($_POST['password']));
	$email = $framework->db_prepare_input($_POST['email']);
	$firstname = $framework->db_prepare_input($_POST['firstname']);
	$lastname = $framework->db_prepare_input($_POST['lastname']);
	$country = $framework->db_prepare_input($_POST['country']);
	$state = $framework->db_prepare_input($_POST['state']) == 'undefined' ? '' : $framework->db_prepare_input($_POST['state']);
	$city = $framework->db_prepare_input($_POST['city']) == 'undefined' ? '' : $framework->db_prepare_input($_POST['city']);

	$framework->username = $username;
	$framework->password = $password;
	$framework->email = $email;
	$framework->firstname = $firstname;
	$framework->lastname = $lastname;
	$framework->country = $country;
	$framework->state = $state;
	$framework->city = $city;

	$user_data = $framework->userData($username, 2);

	if ($username == '' || $password == '') {
     	$msg = errorMessage($LANG['_user_required']);  
    } elseif ($firstname == '') {
     	$msg = errorMessage($LANG['_firstname_required']);  
    } elseif ($lastname == '') {
     	$msg = errorMessage($LANG['_lastname_required']);  
    } elseif ($email == '') {
     	$msg = errorMessage($LANG['_email_required']);  
    } elseif ($state == '') {
     	$msg = errorMessage($LANG['_state_required']);  
    } elseif ($city == '') {
     	$msg = errorMessage($LANG['_city_required']);  
    } elseif ($username == $user_data['username']) {
    	$msg = infoMessage($LANG['username_used']);
	} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$msg = infoMessage($LANG['email_invalid']);
	} else if ($framework->checkEmail($email, 2) == $email) {
		$msg = infoMessage($LANG['email_used']);
	} else {
		$status = 1;
		$opr = $framework->registrationCall();
		$msg = $opr == 1 ? successMessage($LANG['_reg_success']) : $opr;
		$header = cleanUrls($SETT['url'].'/index.php?page=account&profile=home');
	}
}

$data = array('message' => $msg, 'status' => $status, 'header' => $header);
echo json_encode($data, JSON_UNESCAPED_SLASHES);