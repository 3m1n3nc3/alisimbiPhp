<?php
require_once(__DIR__ .'/../includes/autoload.php');
global $PTMPL, $LANG, $SETT, $user, $configuration;

$ravemode = ($configuration['rave_mode'] ? 'api.ravepay.co' : 'ravesandboxapi.flutterwave.com'); // Check if sandbox is enabled
$public_key = $configuration['rave_public_key']; // Rave API Public key
$private_key = $configuration['rave_private_key']; // Rave API Private key 

$referrer = urlencode($_SESSION['referrer']);
$url = $SETT['url'].'/index.php?page=training&course=get&process=status&courseid='.$_SESSION['course_code'].'&type=successful&%s';
$fail_url = $SETT['url'].'/index.php?page=training&course=get&process=status&courseid='.$_SESSION['course_code'].'&type=canceled&status=%s&message=%s';    

(!isset($_SESSION)) ? session_start() : $echo = ''; 
// error_reporting(0); 

    $txrefer   = $_SESSION['txref'];
    $amount    = $_SESSION['amount']; //Correct Amount from Server 
    $currency = $_SESSION['currency']; //Correct Currency from Server
	$sel_course = $_SESSION['selected_course'];
	$course_id = $_SESSION['course_code'];

    $response  = $_GET['resp'];

    if (isset($txrefer)) {  

        //Connect with Verification Server
        $query = array(
            "SECKEY" => $private_key,
            "txref" => $txrefer 
        );

        $data_string = json_encode($query); 
                
        $ch = curl_init('https://'.$ravemode.'/flwv3-pug/getpaidx/api/v2/verify');                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                              
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $response = curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        if (curl_error($ch)) {
            $error_msg = curl_error($ch); 
        }
        if(isset($error_msg)) {
            echo '<br/> Curl Error: '.$error_msg.'<br/>'; 
        }
        curl_close($ch);

        $resp = json_decode($response, true);
        $return_query = http_build_query($resp);

   //      print_r($resp);

        $paymentStatus = $resp['data']['status'];
        $chargeResponsecode = $resp['data']['chargecode'];
        $chargeAmount = $resp['data']['amount'];
        $chargeCurrency = $resp['data']['currency'];
        $message = $resp['message'];

        if ($paymentStatus == 'successful' && ($chargeResponsecode == "00") && ($chargeAmount >= $amount)  && ($chargeCurrency == $currency)) { 

            header("Location: ".sprintf($url, $return_query.'&referrer='.$referrer)); 
          // transaction was successful...
             // please check other things like whether you already gave value for this ref
          // if the email matches the customer who owns the product etc
          //Give Value and return to Success page
        } else {        
            
            //Dont Give Value and return a failure message to the payment page
            header("Location: ".sprintf($fail_url, $paymentStatus, $message.'&referrer='.$referrer));
        }
    } else {
      die('No reference supplied');
    }

?> 
 
