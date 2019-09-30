<?php
include('../config.php');
$user_id=isset($_SESSION['user_id']) ? $_SESSION['user_id'] :0 ;
// $job_id = $_SESSION['last_id'];
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

    if($data['custom'] == 'pay_with_paypal'){
	
    //Insert Payment Details        
	$PayPalDetails = mysql_query("INSERT INTO `paypal_payments` (txnid, payment_amount, payment_status, itemid, user_id, createdtime) VALUES (
		'".$data['txn_id']."' ,
		'".$data['payment_amount']."' ,
		'".$data['payment_status']."' ,
		'".$data['item_number']."' ,
		".$user_id." ,
		'".date("Y-m-d H:i:s")."'
        )");
    
    $updateJobStatus = "UPDATE tbljobs SET status = 1 WHERE job_id = ".$_SESSION['last_id']."";
	mysql_query($updateJobStatus);
	
	unset($_SESSION['jobdetails']);
 	unset($_SESSION['jobimages']);
 	unset($_SESSION['last_id']);
    header('Location: '.SITE_URL.'postjob.php');
    exit;
    }

    if($data['custom'] == 'add_credits'){
        $userCreditSql = mysql_query("SELECT total_credit FROM tbluser WHERE user_id=$user_id");
        $userCreditDetails = mysql_fetch_array($userCreditSql);
        $userOldCredit = $userCreditDetails['total_credit'];
        $newUserCredit = $userOldCredit + (int)$data['payment_amount'];

        //Update User Credit Details
        $updateUserCreditSql = "UPDATE tbluser SET total_credit = ".$newUserCredit." WHERE user_id = ".$user_id."";
        mysql_query($updateUserCreditSql);

        //Insert Payment Details        
	$PayPalDetails = mysql_query("INSERT INTO `paypal_payments` (txnid, payment_amount, payment_status, itemid, user_id, createdtime) VALUES (
		'".$data['txn_id']."' ,
		'".$data['payment_amount']."' ,
		'".$data['payment_status']."' ,
		'".$data['item_number']."' ,
		".$user_id." ,
		'".date("Y-m-d H:i:s")."'
        )");

        header('Location: '.SITE_URL.'publish.php');
        exit;
    }
