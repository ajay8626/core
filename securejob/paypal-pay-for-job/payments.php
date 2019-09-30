<?php
include('../config.php');
// PayPal settings
$paypalEnviornment = 'sandbox'; //PayPal Enviornment
$paypal_email = 'main-api-user-acc@gmail.com'; //Main Email Id in which amount will be deposited.
$return_url = SITE_URL.'paypal-pay-for-job/response.php';
$cancel_url = SITE_URL.'paypal-pay-for-job/payment-cancelled.php';
$notify_url = SITE_URL.'paypal-pay-for-job/response.php';

// Include Functions
include("functions.php");

// Check if paypal request or response

	$querystring = '';
	
	// Firstly Append paypal account to querystring
	$querystring .= "?business=".urlencode($paypal_email)."&";
	
	//loop for posted values and append to querystring
	foreach($_POST as $key => $value){
		$value = urlencode(stripslashes($value));
		$querystring .= "$key=$value&";
	}
	
	// Append paypal return addresses
	$querystring .= "return=".urlencode(stripslashes($return_url))."&";
	$querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."&";
	$querystring .= "notify_url=".urlencode($notify_url);
	
	// Redirect to paypal IPN
	if($paypalEnviornment == 'sandbox'){
		header('location: https://www.sandbox.paypal.com/cgi-bin/webscr'.$querystring);
	}elseif($paypalEnviornment == 'live'){
		header('location: https://www.paypal.com/cgi-bin/webscr'.$querystring);
	}
	
	exit();
?>
