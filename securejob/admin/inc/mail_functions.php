<?php

/*Get the admin email address*/
function get_admin_email()
{
	$select_admin_email = mysql_query("select * from tblsystemconfiguration where title_key ='Admin Email Address' ");
	$result = mysql_fetch_array($select_admin_email);
	$admin_email = $result['title_value'];
	return $admin_email;
}

/* Email when job is created (Mail to User and Admin) */
function job_created($user_id, $job_title)
{

    /* Email to job creator */
    $user_details = mysql_query("select * from tbluser where user_id=".$user_id."");
    $result = mysql_fetch_array($user_details);
    $user_name = $result["firstname"]." ".$result["lastname"];
    $user_email = $result["email"];
    $to = $user_email;
	$subject = "Your new job created";
	
	/* Message */
    $message = '<html><body style="margin:0; padding:0;">
                <table style="margin:0 auto; width:570px; border:2px solid #CF2027; " border="0" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                <th style="text-align:center; background:#fff; border-bottom:2px solid #CF2027; padding:22px 0 20px;"><img src="'.SITE_URL.'images/logo.png" alt="" style="width:50%;"/></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                <td style=" font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:16px; padding:32px 30px 0;">Hello '.$user_name.',</td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; padding:32px 30px 0;line-height:21px;">Your Job '.$job_title.'  has been created on the website.</td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 0;"> The job name: '.$job_title.'</td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 0;"> The job will be published once the payment will be done. Ignore if already paid.</td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 30px;">Thank you,<br/>Secure That Job Team</td>
                </tr>
                </tbody>
                </table>
                </body></html>';
	
	sendMsg($to, $subject, $message);

	/*Email to admin when job is created*/
	$to_admin = get_admin_email();
	$subject_admin = "New job created";

	/* Message */
	$message_admin = '<html><body style="margin:0; padding:0;">
                    <table style="margin:0 auto; width:570px; border:2px solid #CF2027; " border="0" cellpadding="0" cellspacing="0">
                    <thead>
                    <tr>
                    <th style="text-align:center; background:#fff; border-bottom:2px solid #CF2027; padding:22px 0 20px;"><img src="'.SITE_URL.'images/logo.png" alt="" style="width:50%;"/></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                    <td style=" font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:16px; padding:32px 30px 0;">Hello Admin,</td>
                    </tr>
                    <tr>
                    <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; padding:32px 30px 0;line-height:21px;">The user '.$user_name.' has created a new job on your website.</td>
                    </tr>
                    <tr>
                    <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 0;"> The job name: '.$job_title.'</td>
                    </tr>
                    <tr>
                    <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 30px;">Thank you</td>
                    </tr>
                    </tbody>
                    </table>
                    </body></html>';
	
	sendMsg($to_admin, $subject_admin, $message_admin);

}

/* Mail when new user registerd (Mail to User and Admin) */
function new_user_registration($user_id,$user_pwd)
{
	/* Email to user */
	$user_details = mysql_query("select * from tbluser where user_id=".$user_id."");
	$result = mysql_fetch_array($user_details);
	$user_name = $result["firstname"]." ".$result["lastname"];
    $user_email = $result["email"];
    $user_password = $user_pwd;
    $to = $user_email;
	$subject = "Welcome to Secure That Job";
	$code = rand(99999,10000);
	$site_url = SITE_URL."login.php";
	/* Message */
    $message = '<html><body style="margin:0; padding:0;">
                <table style="margin:0 auto; width:570px; border:2px solid #CF2027; " border="0" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                <th style="text-align:center; background:#fff; border-bottom:2px solid #CF2027; padding:22px 0 20px;"><img src="'.SITE_URL.'images/logo.png" alt="" style="width:50%;"/></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                <td style=" font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:16px; padding:32px 30px 0;">Hello '.$user_name.',</td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; padding:32px 30px 0;line-height:21px;">Welcome to our website.</td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 0;"> Your email: '.$user_email.'</td>
                </tr>
				<tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; padding:32px 30px 0;line-height:21px;">Login here: '.$site_url.'</td>
                </tr>
				<tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 0;">Kindly click on the below link to verify your account.</td>
                </tr>
				<tr>
              <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; padding:32px 30px 0;line-height:21px;"><a href="'.SITE_URL.'emailverify.php?email='.$user_email.'&status=1" style="color:#6FB144!important;text-decoration: none; font-weight: bold;font-size: 20px;" target="_blank">
              <span style="color:#6FB144;text-decoration: none; font-weight: bold;font-size: 20px;font-family: Open Sans,sans-serif;margin:0;">Verify</span></a></td>
            </tr>
			<tr>
              <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 0;">Verification Code: '.$code.'</td>
            </tr>
                
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 30px;">Thank you,<br/>Secure That Job Team</td>
                </tr>
                </tbody>
                </table>
                </body></html>';
	sendMsg($to, $subject, $message);

	/* Email to admin */
	$to_admin = get_admin_email();
	$subject_admin = "New user registration on your site";

	/* Message */
	
	$message_admin = '<html><body style="margin:0; padding:0;">
                    <table style="margin:0 auto; width:570px; border:2px solid #CF2027; " border="0" cellpadding="0" cellspacing="0">
                    <thead>
                    <tr>
                    <th style="text-align:center; background:#fff; border-bottom:2px solid #CF2027; padding:22px 0 20px;"><img src="'.SITE_URL.'images/logo.png" alt="" style="width:50%;"/></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                    <td style=" font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:16px; padding:32px 30px 0;">Hello Admin,</td>
                    </tr>
                    <tr>
                    <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; padding:32px 30px 0;line-height:21px;">A new user has been registered on your website.<br/>See the details below:</td>
                    </tr>
                    <tr>
                    <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:0px 30px 0;"> Name: '.$user_name.'</td>
                    </tr>
                    <tr>
                    <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:0 30px 0;"> Email: '.$user_email.'</td>
                    </tr>
                    <tr>
                    <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 30px;">Thank you</td>
                    </tr>
                    </tbody>
                    </table>
                    </body></html>';
	
	sendMsg($to_admin, $subject_admin, $message_admin);

}

/* Mail when user bid on job (Mail to Bidder and Job Poster) */
function new_bid_added($user_id,$job_id,$bid_amount)
{
	/*Mail to user who bid on the job*/
	$user_details = mysql_query("select * from tbluser where user_id=".$user_id."");
	$result = mysql_fetch_array($user_details);
	$user_name = $result["firstname"]." ".$result["lastname"];
    $user_email = $result["email"];
    $user_bid_amount = $bid_amount;
    $to = $user_email;
    $job_url = SITE_URL."place-bid.php?job_id=$job_id";


    $jobname = mysql_query("SELECT tbljobs.*,tbluser.* from tbluser inner join tbljobs on tbluser.user_id = tbljobs.job_user_id where tbljobs.job_id = $job_id");
    $jobresult = mysql_fetch_array($jobname);
    $task_name = $jobresult['job_name'];

	$subject = "Your proposal: ".$task_name."";
	
	/* Message */
    $message = '<html><body style="margin:0; padding:0;">
                <table style="margin:0 auto; width:570px; border:2px solid #CF2027; " border="0" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                <th style="text-align:center; background:#fff; border-bottom:2px solid #CF2027; padding:22px 0 20px;"><img src="'.SITE_URL.'images/logo.png" alt="" style="width:50%;"/></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                <td style=" font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:16px; padding:32px 30px 0;">Hello '.$user_name.',</td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; padding:32px 30px 0;line-height:21px;">You posted a new bid for the job listing <b>'.$task_name.'</b></td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 0;"> Job Link: '.$job_url.'</td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:0 30px 0;"> Bid Value: '.$user_bid_amount.'</td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 30px;">Thank you,<br/>Secure That Job Team</td>
                </tr>
                </tbody>
                </table>
                </body></html>';
	
	sendMsg($to, $subject, $message);

	/*Mail to job poster*/
	$job_poster = mysql_query("SELECT tbljobs.*,tbluser.* from tbluser inner join tbljobs on tbluser.user_id = tbljobs.job_user_id where tbljobs.job_id = $job_id");
	
	$result_admin = mysql_fetch_array($job_poster);
	$job_poster_email = $result_admin['email'];
    $job_name = $result_admin['job_name'];
    $job_poster_name = $result_admin['firstname']." ".$result_admin['lastname'];
	$subject_job_poster = "You have received a new bid for your job listing ".$job_name."";

	/* Message */
	$message_job_poster = '<html><body style="margin:0; padding:0;">
                            <table style="margin:0 auto; width:570px; border:2px solid #CF2027; " border="0" cellpadding="0" cellspacing="0">
                            <thead>
                            <tr>
                            <th style="text-align:center; background:#fff; border-bottom:2px solid #CF2027; padding:22px 0 20px;"><img src="'.SITE_URL.'images/logo.png" alt="" style="width:50%;"/></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                            <td style="font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:16px; padding:32px 30px 0;">Hello '.$job_poster_name.',</td>
                            </tr>
                            <tr>
                            <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; padding:32px 30px 0;line-height:21px;">You have received a new bid to your job listing. <b>'.$task_name.'</b></td>
                            </tr>
                            <tr>
                            <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 0;"> See your bid details below:</td>
                            </tr>
                            <tr>
                            <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 0;"> Bidder Name: '.$user_name.'</td>
                            </tr>
                            <tr>
                            <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:0 30px 0;"> Bidder Email: '.$user_email.'</td>
                            </tr>
                            <tr>
                            <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:0 30px 0;"> Bid Value: '.$user_bid_amount.'</td>
                            </tr>
                            
                            <tr>
                            <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 30px;">Thank you,<br/>Secure That Job Team</td>
                            </tr>
                            </tbody>
                            </table>
                            </body></html>';
	
	sendMsg($job_poster_email, $subject_job_poster, $message_job_poster);
}

/*When user buy credit (Mail to User and Admin)*/
function add_credit($user_id,$new_added_credit)
{
	/* Mail to user */
	$user_details = mysql_query("select * from tbluser where user_id=".$user_id."");
	$result = mysql_fetch_array($user_details);
	$user_name = $result["firstname"]." ".$result["lastname"];
    $user_email = $result["email"];
    $added_credit = $new_added_credit;

    $job_details = mysql_query("select * from tbljobs where job_id = ".$job_id."");
    $result_job = mysql_fetch_array($job_details);
    $job_title  = $result_job['job_name'];
  
    $to = $user_email;
	$subject = "You have purchased credits successfully";
	
	/* Message */
    $message = '<html><body style="margin:0; padding:0;">
                <table style="margin:0 auto; width:570px; border:2px solid #CF2027; " border="0" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                <th style="text-align:center; background:#fff; border-bottom:2px solid #CF2027; padding:22px 0 20px;"><img src="'.SITE_URL.'images/logo.png" alt="" style="width:50%;"/></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                <td style="font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:16px; padding:32px 30px 0;">Hello '.$user_name.',</td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 0;"> You have successfully purchased the '.$added_credit.' credits.</td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 30px;">Thank you,<br/>Secure That Job Team</td>
                </tr>
                </tbody>
                </table>
                </body></html>';

	sendMsg($to, $subject, $message);

	/* Mail to admin */
	$to_admin = get_admin_email();
	$subject_admin = "You have received payment for credits puchased";

	/* Message */
	$message_admin = '<html><body style="margin:0; padding:0;">
                    <table style="margin:0 auto; width:570px; border:2px solid #CF2027; " border="0" cellpadding="0" cellspacing="0">
                    <thead>
                    <tr>
                    <th style="text-align:center; background:#fff; border-bottom:2px solid #CF2027; padding:22px 0 20px;"><img src="'.SITE_URL.'images/logo.png" alt="" style="width:50%;"/></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                    <td style="font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:16px; padding:32px 30px 0;">Hello Admin,</td>
                    </tr>
                    <tr>
                    <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 0;"> Payer Name: '.$user_name.'</td>
                    </tr>
                    <tr>
                    <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:0px 30px 0;"> Payer Email: '.$user_email.'</td>
                    </tr>
                    <tr>
                    <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:0px 30px 0;"> Credit Purchased: '.$added_credit.'</td>
                    </tr>
                    <tr>
                    <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 30px;">Thank you</td>
                    </tr>
                    </tbody>
                    </table>
                    </body></html>';

	sendMsg($to_admin, $subject_admin, $message_admin);
}

/*Mail when job poster pay for job (Mail to Poster and Admin)*/
function job_payment($user_id,$job_id,$payment)
{
    /* Mail to job poster */
    $payment_made = $payment;

    /* User Details */
	$user_details = mysql_query("select * from tbluser where user_id=".$user_id."");
	$result = mysql_fetch_array($user_details);
	$user_name = $result["firstname"]." ".$result["lastname"];
    $user_email = $result["email"];

    /* Job Details */
    $job_details = mysql_query("select * from tbljobs where job_id = ".$job_id."");
    $result_job = mysql_fetch_array($job_details);
    $job_title  = $result_job['job_name'];

    $to = $user_email;
	$subject = "You have made a payment for your job ".$job_title." ";
	
	/* Message */
    $message = '<html><body style="margin:0; padding:0;">
                <table style="margin:0 auto; width:570px; border:2px solid #CF2027; " border="0" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                <th style="text-align:center; background:#fff; border-bottom:2px solid #CF2027; padding:22px 0 20px;"><img src="'.SITE_URL.'images/logo.png" alt="" style="width:50%;"/></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                <td style="font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:16px; padding:32px 30px 0;">Hello '.$user_name.',</td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 0;"> You have made a payment for job: <b>'.$job_title.'</b></td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 0;"> Payment Made: '.$payment_made.'</td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 30px;">Thank you,<br/>Secure That Job Team</td>
                </tr>
                </tbody>
                </table>
                </body></html>';
	sendMsg($to, $subject, $message);

	/* Mail to admin */
	$to_admin = get_admin_email();
	$subject_admin = "Payment Received for Job";

	/* Message */
	$message_admin = '<html><body style="margin:0; padding:0;">
                <table style="margin:0 auto; width:570px; border:2px solid #CF2027; " border="0" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                <th style="text-align:center; background:#fff; border-bottom:2px solid #CF2027; padding:22px 0 20px;"><img src="'.SITE_URL.'images/logo.png" alt="" style="width:50%;"/></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                <td style="font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:16px; padding:32px 30px 0;">Hello Admin,</td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:30px 30px 0;">'.$user_name.' has made a payment for job <b>'.$job_title.'</b></td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:30px 30px 0;"> Payer Email: '.$user_email.'</td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:0px 30px 0;"> Payment Made: '.$payment_made.'</td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 30px;">Thank you</td>
                </tr>
                </tbody>
                </table>
                </body></html>';
	sendMsg($to_admin, $subject_admin, $message_admin);
}

/*Mail When User Do Job Payment Using Credit (Mail to User and Admin)*/
function job_payment_by_credit($user_id,$job_id,$payment)
{
	/* Mail to job poster */
    $payment_made = $payment;

    /* User Details */
	$user_details = mysql_query("select * from tbluser where user_id=".$user_id."");
	$result = mysql_fetch_array($user_details);
	$user_name = $result["firstname"]." ".$result["lastname"];
    $user_email = $result["email"];

    /* Job Details */
    $job_details = mysql_query("select * from tbljobs where job_id = ".$job_id."");
    $result_job = mysql_fetch_array($job_details);
    $job_title  = $result_job['job_name'];

    $to = $user_email;
	$subject = "You have made a payment for your job ".$job_title." ";
	
	/* Message */
    $message = '<html><body style="margin:0; padding:0;">
                <table style="margin:0 auto; width:570px; border:2px solid #CF2027; " border="0" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                <th style="text-align:center; background:#fff; border-bottom:2px solid #CF2027; padding:22px 0 20px;"><img src="'.SITE_URL.'images/logo.png" alt="" style="width:50%;"/></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                <td style="font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:16px; padding:32px 30px 0;">Hello '.$user_name.',</td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 0;"> You have made a payment for your job: <b>'.$job_title.'</b></td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 0;"> Payment Amount: £'.$payment_made.'</td>
                </tr>
                <tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:0px 30px 0;"> Payment Mode: Credits</td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 30px;">Thank you,<br/>Secure That Job Team</td>
                </tr>
                </tbody>
                </table>
                </body></html>';
	sendMsg($to, $subject, $message);

	/* Mail to admin */
	$to_admin = get_admin_email();
	$subject_admin = "Payment Received for Job ".$job_title." ";

	/* Message */
	$message_admin = '<html><body style="margin:0; padding:0;">
                <table style="margin:0 auto; width:570px; border:2px solid #CF2027; " border="0" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                <th style="text-align:center; background:#fff; border-bottom:2px solid #CF2027; padding:22px 0 20px;"><img src="'.SITE_URL.'images/logo.png" alt="" style="width:50%;"/></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                <td style="font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:16px; padding:32px 30px 0;">Hello Admin,</td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 0;">'.$user_name.' has made a payment for the job <b>'.$job_title.'</b></td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 0;"> Payer Email: '.$user_email.'</td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:0px 30px 0;"> Payment Amount: £'.$payment_made.'</td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:0px 30px 0;"> Payment Mode: Credits</td>
                </tr>
                <tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 30px;">Thank you</td>
                </tr>
                </tbody>
                </table>
                </body></html>';
	sendMsg($to_admin, $subject_admin, $message_admin);
}

/*Mail When User Do Job Payment Using PayPal*/
function job_payment_by_paypal($user_id,$job_id,$payment)
{
	/* Mail to job poster */
    $payment_made = $payment;

    /* User Details */
	$user_details = mysql_query("select * from tbluser where user_id=".$user_id."");
	$result = mysql_fetch_array($user_details);
	$user_name = $result["firstname"]." ".$result["lastname"];
    $user_email = $result["email"];

    /* Job Details */
    $job_details = mysql_query("select * from tbljobs where job_id = ".$job_id."");
    $result_job = mysql_fetch_array($job_details);
    $job_title  = $result_job['job_name'];

    $to = $user_email;
	$subject = "You have made a payment for your job ".$job_title." ";
	
	/* Message */
    $message = '<html><body style="margin:0; padding:0;">
                <table style="margin:0 auto; width:570px; border:2px solid #CF2027; " border="0" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                <th style="text-align:center; background:#fff; border-bottom:2px solid #CF2027; padding:22px 0 20px;"><img src="'.SITE_URL.'images/logo.png" alt="" style="width:50%;"/></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                <td style="font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:16px; padding:32px 30px 0;">Hello '.$user_name.',</td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 0;"> You have made a payment for your job: <b>'.$job_title.'</b></td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 0;"> Payment Amount: £'.$payment_made.'</td>
                </tr>
                <tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 0;"> Payment Mode: PayPal</td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 30px;">Thank you,<br/>Secure That Job Team</td>
                </tr>
                </tbody>
                </table>
                </body></html>';
	sendMsg($to, $subject, $message);

	/* Mail to admin */
	$to_admin = get_admin_email();
	$subject_admin = "Payment Received for Job";

	/* Message */
	$message_admin = '<html><body style="margin:0; padding:0;">
                <table style="margin:0 auto; width:570px; border:2px solid #CF2027; " border="0" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                <th style="text-align:center; background:#fff; border-bottom:2px solid #CF2027; padding:22px 0 20px;"><img src="'.SITE_URL.'images/logo.png" alt="" style="width:50%;"/></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                <td style="font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:16px; padding:32px 30px 0;">Hello Admin,</td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:0px 30px 0;">'.$user_name.' has made a payment for the job <b>'.$job_title.'</b></td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:0px 30px 0;"> Payer Email: '.$user_email.'</td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:0px 30px 0;"> Payment Amount: £'.$payment_made.'</td>
                </tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 0;"> Payment Mode: PayPal</td>
                </tr>
                <tr>
                <tr>
                <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 30px;">Thank you</td>
                </tr>
                </tbody>
                </table>
                </body></html>';
	sendMsg($to_admin, $subject_admin, $message_admin);
}

/*Mail when user selected for there bid they have post on job*/
function user_selected_for_bid($user_id,$job_id)
{
	/*User Details*/
	$user_details = mysql_query("select * from tbluser where user_id=".$user_id."");
	$result = mysql_fetch_array($user_details);
	$user_name = $result["firstname"]." ".$result["lastname"];
    $user_email = $result["email"];

    /*Job Details*/
    $job_details = mysql_query("select * from tbljobs where job_id = '".$job_id."'");
	$result_admin = mysql_fetch_array($job_details);
	$job_title	= $result_admin['job_name'];

    $to = $user_email;
    $subject = "You are selected as a winner for your bid proposal on ".$job_title." job";

    $message = '<html><body style="margin:0; padding:0;">
                <table style="margin:0 auto; width:570px; border:2px solid #CF2027; " border="0" cellpadding="0" cellspacing="0">
                 <thead>
                  <tr>
                   <th style="text-align:center; background:#fff; border-bottom:2px solid #CF2027; padding:22px 0 20px;"><img src="'.SITE_URL.'images/logo.png" alt="" style="width:50%;"/></th>
                  </tr>
                 </thead>
                 <tbody>
                  <tr>
                   <td style="font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:16px; padding:32px 30px 0;">Hello '.$user_name.',</td>
                  </tr>
                  <tr>
                   <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; padding:32px 30px 0;line-height:21px;">Your Bid is selected for job '.$job_title.'</td>
                  </tr>
                  <tr>
                   <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 30px;">Thank you,<br/>Secure That Job Team</td>
                  </tr>
                  </tbody>
                </table>
                </body></html>';

	sendMsg($to, $subject, $message);
}

/*Mail when user update their job status (Mail to Job Poster)*/
function bidder_update_status($user_id, $job_id, $status)
{   
    /* Job Status */
    $job_status = $status;
    $status_name = "";
    if($job_status == 3){
        $status_name = "In Progress";
    }
    if($job_status == 4){
        $status_name = "Completed";
    }

	/*Bidder Details*/
	$user_details = mysql_query("select * from tbluser where user_id=".$user_id."");
	$result_bidder = mysql_fetch_array($user_details);
	$user_name = $result_bidder["firstname"]." ".$result_bidder["lastname"];
    $user_email = $result_bidder["email"];

    /*Job Details*/
    $job_details = mysql_query("select * from tbljobs where job_id = '".$job_id."'");
	$result_job = mysql_fetch_array($job_details);
    $job_title	= $result_job['job_name'];
    $job_poster_id = $result_job['job_user_id'];

    /*Job Poster Details*/
    $job_poster_details = mysql_query("select * from tbluser where user_id = '".$job_poster_id."'");
    $result_job_poster = mysql_fetch_array($job_poster_details);
    $job_poster_name = $result_job_poster['firstname'].' '.$result_job_poster['lastname'];
    $job_poster_email = $result_job_poster['email'];

    $subject = "Bidder has updated the job status for job ".$job_title." ";

    $message = '<html><body style="margin:0; padding:0;">
                <table style="margin:0 auto; width:570px; border:2px solid #CF2027; " border="0" cellpadding="0" cellspacing="0">
                 <thead>
                  <tr>
                   <th style="text-align:center; background:#fff; border-bottom:2px solid #CF2027; padding:22px 0 20px;"><img src="'.SITE_URL.'images/logo.png" alt="" style="width:50%;"/></th>
                  </tr>
                 </thead>
                 <tbody>
                  <tr>
                   <td style=" font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:16px; padding:32px 30px 0;">Hello '.$user_name.',</td>
                  </tr>
                  <tr>
                   <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; padding:32px 30px 0;line-height:21px;">Bidder '.$user_name.' has updated the job status to <b>'.$status_name.'</b> for job '.$job_title.'</td>
                  </tr>
                  <tr>
                   <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 30px;">Thank you,<br/>Secure That Job Team</td>
                  </tr>
                  </tbody>
                </table>
                </body></html>';
    
    sendMsg($job_poster_email, $subject, $message);
}

/*Mail when job poster marked the job completed*/
function poster_completed_job($job_id)
{
	/*Job Details*/
    $job_details = mysql_query("select * from tbljobs where job_id = '".$job_id."'");
	$result_job = mysql_fetch_array($job_details);
    $job_title	= $result_job['job_name'];
    $job_poster_id = $result_job['job_user_id'];

    /*Job Poster Details*/
    $job_poster_details = mysql_query("select * from tbluser where user_id = '".$job_poster_id."'");
    $result_job_poster = mysql_fetch_array($job_poster_details);
    $job_poster_name = $result_job_poster['firstname'].' '.$result_job_poster['lastname'];
    $job_poster_email = $result_job_poster['email'];

    /*Job Bidders Details*/
    $user_details = mysql_query("SELECT tu.email FROM tbluser as tu inner join tbljobsapplied as ta ON tu.user_id = ta.user_id where ta.job_id=".$job_id." AND ta.is_winner=1");
    $bidder_emails = array();
    while($user_details_array = mysql_fetch_assoc($user_details)){
        $bidder_emails[] = $user_details_array['email'];
    }
    $bidder_emails_string = implode(",", $bidder_emails);

    $subject = "Job marked as completed by job poster: ".$job_title." ";
    $message = '<html><body style="margin:0; padding:0;">
                <table style="margin:0 auto; width:570px; border:2px solid #CF2027; " border="0" cellpadding="0" cellspacing="0">
                 <thead>
                  <tr>
                   <th style="text-align:center; background:#fff; border-bottom:2px solid #CF2027; padding:22px 0 20px;"><img src="'.SITE_URL.'images/logo.png" alt="" style="width:50%;"/></th>
                  </tr>
                 </thead>
                 <tbody>
                  <tr>
                   <td style=" font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:16px; padding:32px 30px 0;">Hello,</td>
                  </tr>
                  <tr>
                   <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; padding:32px 30px 0;line-height:21px;">Job poster has marked the job <b>'.$job_title.'</b> as completed and payment has been released.</td>
                  </tr>
                  <tr>
                   <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 30px;">Thank you,<br/>Secure That Job Team</td>
                  </tr>
                  </tbody>
                </table>
                </body></html>';
    
    sendMsg($bidder_emails_string, $subject, $message);
}

/*Job Invitation (Mail to the user who has been invited) */
function job_invitation($job_id,$invitee_id)
{
    /*Invitee Details*/
	$user_details = mysql_query("select * from tbluser where user_id=".$invitee_id."");
	$result_bidder = mysql_fetch_array($user_details);
	$user_name = $result_bidder["firstname"]." ".$result_bidder["lastname"];
    $user_email = $result_bidder["email"];

    /*Job Details*/
    $job_details = mysql_query("select * from tbljobs where job_id = '".$job_id."'");
	$result_job = mysql_fetch_array($job_details);
    $job_title	= $result_job['job_name'];
    $job_link = SITE_URL."place-bid.php?job_id=".$job_id;
    $job_poster_id = $result_job['job_user_id'];

    /*Job Poster Details*/
    $job_poster_details = mysql_query("select * from tbluser where user_id = '".$job_poster_id."'");
    $result_job_poster = mysql_fetch_array($job_poster_details);
    $job_poster_name = $result_job_poster['firstname'].' '.$result_job_poster['lastname'];
    $job_poster_email = $result_job_poster['email'];

    $subject = $job_poster_name." has invited you for the job ".$job_title;
    $message = '<html><body style="margin:0; padding:0;">
                <table style="margin:0 auto; width:570px; border:2px solid #CF2027; " border="0" cellpadding="0" cellspacing="0">
                 <thead>
                  <tr>
                   <th style="text-align:center; background:#fff; border-bottom:2px solid #CF2027; padding:22px 0 20px;"><img src="'.SITE_URL.'images/logo.png" alt="" style="width:50%;"/></th>
                  </tr>
                 </thead>
                 <tbody>
                  <tr>
                   <td style=" font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:16px; padding:32px 30px 0;">Hello '.$user_name.',</td>
                  </tr>
                  <tr>
                   <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; padding:32px 30px 0;line-height:21px;">'.$job_poster_name.' has invited you to bid on the job <a href="'.$job_link.'">'.$job_title.'<a></td>
                  </tr>
                  <tr>
                   <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 30px;">Thank you,<br/>Secure That Job Team</td>
                  </tr>
                  </tbody>
                </table>
                </body></html>';
    
    sendMsg($user_email, $subject, $message);
}

/*Mail when user apply for any course*/
function apply_course($user_id, $course_id)
{

    /*User Details*/
	$user_details = mysql_query("select * from tbluser where user_id=".$user_id."");
	$result_bidder = mysql_fetch_array($user_details);
	$user_name = $result_bidder["firstname"]." ".$result_bidder["lastname"];
    $user_email = $result_bidder["email"];

    /*Course Details*/
    $course_details = mysql_query("select * from tblcourse where course_id=".$course_id."");
	$result_course = mysql_fetch_array($course_details);
	$course_name = $result_course["name"];
    $course_price = $result_course["price"];
    $course_location = $result_course["course_location"];
    $course_duration = $result_course["course_days"];
    $course_start = $result_course["start_date"];

    /* For Users */
    $subject = "You have applied for course: ".$course_name." ";
    $message = '<html><body style="margin:0; padding:0;">
                <table style="margin:0 auto; width:570px; border:2px solid #CF2027; " border="0" cellpadding="0" cellspacing="0">
                 <thead>
                  <tr>
                   <th style="text-align:center; background:#fff; border-bottom:2px solid #CF2027; padding:22px 0 20px;"><img src="'.SITE_URL.'images/logo.png" alt="" style="width:50%;"/></th>
                  </tr>
                 </thead>
                 <tbody>
                  <tr>
                   <td style=" font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:16px; padding:32px 30px 0;">Hello '.$user_name.',</td>
                  </tr>
                  <tr>
                   <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; padding:32px 30px 0;line-height:21px;"><b>Course Name:</b> '.$course_name.'</td>
                  </tr>
                  <tr>
                   <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; padding:0px 30px 0;line-height:21px;"><b>Location:</b> '.$course_location.'</td>
                  </tr>
                  <tr>
                   <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; padding:0px 30px 0;line-height:21px;"><b>Price:</b> '.$course_price.'</td>
                  </tr>
                  <tr>
                   <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; padding:0px 30px 0;line-height:21px;"><b>Duration:</b> '.$course_duration.'</td>
                  </tr>
                  <tr>
                   <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; padding:0px 30px 0;line-height:21px;"><b>Start Date:</b> '.$course_start.'</td>
                  </tr>
                  <tr>
                   <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 30px;">Thank you,<br/>Secure That Job Team</td>
                  </tr>
                  </tbody>
                </table>
                </body></html>';
    
    sendMsg($user_email, $subject, $message);

    /* For Admin */
    $to_admin = get_admin_email();
    $subject_admin = "You have received the payment for the course: ".$course_name." ";
    $message_admin = '<html><body style="margin:0; padding:0;">
                <table style="margin:0 auto; width:570px; border:2px solid #CF2027; " border="0" cellpadding="0" cellspacing="0">
                 <thead>
                  <tr>
                   <th style="text-align:center; background:#fff; border-bottom:2px solid #CF2027; padding:22px 0 20px;"><img src="'.SITE_URL.'images/logo.png" alt="" style="width:50%;"/></th>
                  </tr>
                 </thead>
                 <tbody>
                  <tr>
                   <td style=" font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:16px; padding:32px 30px 0;">Hello Admin,</td>
                  </tr>
                  <tr>
                   <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; padding:32px 30px 0;line-height:21px;">'.$user_name.' has applied for the course '.$course_name.'</td>
                  </tr>
                  <tr>
                   <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; padding:32px 30px 0;line-height:21px;"><b>Location:</b> '.$course_location.'</td>
                  </tr>
                  <tr>
                   <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; padding:0px 30px 0;line-height:21px;"><b>Price:</b> '.$course_price.'</td>
                  </tr>
                  <tr>
                   <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; padding:0px 30px 0;line-height:21px;"><b>Duration:</b> '.$course_duration.'</td>
                  </tr>
                  <tr>
                   <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; padding:0px 30px 0;line-height:21px;"><b>Start Date:</b> '.$course_start.'</td>
                  </tr>
                  <tr>
                   <td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 30px;">Thank you,<br/>Secure That Job Team</td>
                  </tr>
                  </tbody>
                </table>
                </body></html>';
    
    sendMsg($to_admin, $subject_admin, $message_admin);

}

?>
