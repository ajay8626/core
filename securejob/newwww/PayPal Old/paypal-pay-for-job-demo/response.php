<?php
include('../config.php');
$user_id=isset($_SESSION['user_id']) ? $_SESSION['user_id'] :0 ;
	// assign posted variables to local variables
	$data['item_name']			= $_POST['item_name'];
	$data['item_number'] 		= $_POST['item_number'];
	$data['payment_status'] 	= $_POST['payment_status'];
	$data['payment_amount'] 	= $_POST['mc_gross'];
	$data['payment_currency']	= $_POST['mc_currency'];
	$data['txn_id']				= $_POST['txn_id'];
	$data['receiver_email'] 	= $_POST['receiver_email'];
	$data['payer_email'] 		= $_POST['payer_email'];
	$data['custom'] 			= $_POST['custom'];

    if($data['custom'] == 'paypal_pay_for_job'){
	
    //Insert Payment Details        
	$PayPalDetails = mysql_query("INSERT INTO `paypal_payments` (txnid, payment_amount, payment_status, itemid, user_id, createdtime) VALUES (
		'".$data['txn_id']."' ,
		'".$data['payment_amount']."' ,
		'".$data['payment_status']."' ,
		'".$data['item_number']."' ,
		".$user_id." ,
		'".date("Y-m-d H:i:s")."'
        )");
    
    $updateJobStatus = "UPDATE tbljobs SET payment_status = 1, job_status = 2, final_amount = ".$data['payment_amount']." WHERE job_id = ".$data['item_number']."";
    mysql_query($updateJobStatus);

    header('Location: '.SITE_URL.'confirmed_post_job.php');
    exit;
    }