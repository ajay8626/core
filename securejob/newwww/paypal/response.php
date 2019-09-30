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
    
    // echo '<pre>';
	// print_r($_POST);
	// exit;

	if($_POST['payment_status'] == 'Completed'){
        
		//Directly Pay with PayPal
		if($data['custom'] == 'pay_with_paypal'){
			//Insert Payment Details        
			$PayPalDetails = mysql_query("INSERT INTO `paypal_payments` (txnid, payment_amount, payment_status, itemid, user_id, createdtime, payment_for) VALUES (
				'".$data['txn_id']."' ,
				'".$data['payment_amount']."' ,
				'".$data['payment_status']."' ,
				'".$data['item_number']."' ,
				".$user_id." ,
				'".date("Y-m-d H:i:s")."',
				1
				)");
			
			$updateJobStatus = "UPDATE tbljobs SET status = 1 WHERE job_id = ".$data['item_number']."";
			mysql_query($updateJobStatus);
			/*Mail when user do payment for job post*/
			job_payment_by_paypal($user_id,$data['item_number'],$data['payment_amount']);

			unset($_SESSION['jobdetails']);
			unset($_SESSION['jobimages']);
			unset($_SESSION['last_id']);

			header('Location: '.SITE_URL.'postjob.php');
			exit;
			}
			
			//Add Credit (Job Post Page)
			if($data['custom'] == 'add_credits'){
				$userCreditSql = mysql_query("SELECT total_credit FROM tbluser WHERE user_id=$user_id");
				$userCreditDetails = mysql_fetch_array($userCreditSql);
				$userOldCredit = $userCreditDetails['total_credit'];
				$newUserCredit = $userOldCredit + (int)$data['payment_amount'];
		
				//Update User Credit Details
				$updateUserCreditSql = "UPDATE tbluser SET total_credit = ".$newUserCredit." WHERE user_id = ".$user_id."";
				mysql_query($updateUserCreditSql);
				/*Mail when user pay for credit*/
				add_credit($user_id,$data['payment_amount']);
		
			//Insert Payment Details        
			$PayPalDetails = mysql_query("INSERT INTO `paypal_payments` (txnid, payment_amount, payment_status, itemid, user_id, createdtime, payment_for) VALUES (
				'".$data['txn_id']."' ,
				'".$data['payment_amount']."' ,
				'".$data['payment_status']."' ,
				'".$data['item_number']."' ,
				".$user_id." ,
				'".date("Y-m-d H:i:s")."',
				2
				)");
		
				header('Location: '.SITE_URL.'publish.php');
				exit;
			}

			//Add Credit (Individual Profile Page)
			if($data['custom'] == 'add_credits_individual_profile'){
				$userCreditSql = mysql_query("SELECT total_credit FROM tbluser WHERE user_id=$user_id");
				$userCreditDetails = mysql_fetch_array($userCreditSql);
				$userOldCredit = $userCreditDetails['total_credit'];
				$newUserCredit = $userOldCredit + (int)$data['payment_amount'];
		
				//Update User Credit Details
				$updateUserCreditSql = "UPDATE tbluser SET total_credit = ".$newUserCredit." WHERE user_id = ".$user_id."";
				mysql_query($updateUserCreditSql);

				/*Mail when user pay for credit*/
				add_credit($user_id,$data['payment_amount']);
		
			//Insert Payment Details        
			$PayPalDetails = mysql_query("INSERT INTO `paypal_payments` (txnid, payment_amount, payment_status, itemid, user_id, createdtime, payment_for) VALUES (
				'".$data['txn_id']."' ,
				'".$data['payment_amount']."' ,
				'".$data['payment_status']."' ,
				'".$data['item_number']."' ,
				".$user_id." ,
				'".date("Y-m-d H:i:s")."',
				2
				)");
		
				header('Location: '.SITE_URL.'individual-profile.php');
				exit;
			}

			//Add Credit (Business Profile Page)
			if($data['custom'] == 'add_credits_business_profile'){
				$userCreditSql = mysql_query("SELECT total_credit FROM tbluser WHERE user_id=$user_id");
				$userCreditDetails = mysql_fetch_array($userCreditSql);
				$userOldCredit = $userCreditDetails['total_credit'];
				$newUserCredit = $userOldCredit + (int)$data['payment_amount'];
		
				//Update User Credit Details
				$updateUserCreditSql = "UPDATE tbluser SET total_credit = ".$newUserCredit." WHERE user_id = ".$user_id."";
				mysql_query($updateUserCreditSql);

				/*Mail when user pay for credit*/
				add_credit($user_id,$data['payment_amount']);
		
			//Insert Payment Details        
			$PayPalDetails = mysql_query("INSERT INTO `paypal_payments` (txnid, payment_amount, payment_status, itemid, user_id, createdtime, payment_for) VALUES (
				'".$data['txn_id']."' ,
				'".$data['payment_amount']."' ,
				'".$data['payment_status']."' ,
				'".$data['item_number']."' ,
				".$user_id." ,
				'".date("Y-m-d H:i:s")."',
				2
				)");
		
				header('Location: '.SITE_URL.'business-profile.php');
				exit;
			}
            
            //Course Payment (Course Detail Page)
			if($data['custom'] == 'course_payment_with_paypal'){
			
			$course_id = $data['item_number'];
            $userdetails=mysql_query("select * from tbluser where user_id='".$user_id."'");
            $rowcount1=mysql_num_rows($userdetails);   

            if($rowcount1 > 0)
            {
                $userdata=mysql_fetch_array($userdetails);
                $firstname=$userdata['firstname'];
                $lastname=$userdata['lastname'];
                //$email=$userdata['email'];
            }
            else
            {
                $firstname='';
                $lastname='';
                //$email='';
            }
			
			/* Mail after apply for course */
			apply_course($user_id, $course_id);

			//Insert Payment Details        
			$PayPalDetails = mysql_query("INSERT INTO `tbl_course_payment` (txnid, user_id, user_name, user_email, course_id, course_title, course_price, registration_time) VALUES (
                '".$data['txn_id']."' ,
				".$user_id." ,
                '".$firstname." ".$lastname."' ,
                '".$data['payer_email']."' ,
                '".$data['item_number']."' ,
                '".$data['item_name']."' ,
                '".$data['payment_amount']."' ,
                '".date("Y-m-d H:i:s")."'
				)");
		
				header('Location: '.SITE_URL.'course.php');
				exit;
			}
            
	}else{
		header('Location: payment-failed.php');
	}

	
