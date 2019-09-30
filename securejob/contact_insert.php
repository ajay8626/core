<?php
require_once 'config.php';
require("admin/inc/class.phpmailer.php");

$action=isset($_REQUEST['action'])?$_REQUEST['action']:"";

if($action=='home')
{
	    unset($_SESSION['home_name']);
		unset($_SESSION['home_email']);
		unset($_SESSION['home_jobtype']);
		$name=isset($_REQUEST['name'])?$_REQUEST['name']:""; 
		$email=isset($_REQUEST['email'])?$_REQUEST['email']:"";
		$jobtypejob=isset($_REQUEST['job-type-job'])?$_REQUEST['job-type-job']:"";
		$jobtypesecurity=isset($_REQUEST['job-type-security'])?$_REQUEST['job-type-security']:"";

		$jobtxt='';
		if($jobtypejob==1)
		{
			$jobtxt='Job';
			$jobtype=1;
		}
		if($jobtypesecurity==1)
		{
			$jobtxt='Security';
			$jobtype=2;
		}
		$_SESSION['home_name']=$name;
		$_SESSION['home_email']=$email;
	    $_SESSION['home_jobtype']=$jobtype;
		header("Location:login.php");
		exit();
        
}
if($action=='contact')
{
	$firstname=isset($_REQUEST['firstname'])?$_REQUEST['firstname']:""; 
	$lastname=isset($_REQUEST['lastname'])?$_REQUEST['lastname']:"";
	$cn_email=isset($_REQUEST['cn_email'])?$_REQUEST['cn_email']:"";
	$phone=isset($_REQUEST['phone'])?$_REQUEST['phone']:"";
	$message=isset($_REQUEST['message'])?$_REQUEST['message']:"";
	
	  $to = $cn_email;
		$subject = 'Thank you for Contact us';
		$message = '
			<table style="font-family: Verdana,sans-serif; font-size: 11px;color: #374953; width: 90%; border: 3px solid #3D5C7F; border-radius: 8px;" border="0" cellspacing="0" cellpadding="0" align="center">
				<tbody>
					<tr>
						<td style="background-color: #FFFFFF; color: #fff; font-size: 27px; padding: 15px;" align="center">
							<img src="'.SITE_URL.'images/logo.png" width="200" />
						</td>
					</tr>
					<tr>
						<td style="color: #fff; font-size: 12px; font-weight: bold; padding: 0.5em 1em;" align="left">
							Thank you for contacting us, We will get back to you as soon as we can.
						</td>
					</tr>
					<tr>
						<td style="background-color: #3d5c7f; color: #fff; font-size: 12px; font-weight: bold; padding: 0.5em 1em;" align="left">
							Contact Information:
						</td>
					</tr>
					<tr>
						<td align="left">
							<table style="width: 100%; font-family: Verdana,sans-serif; font-size: 11px; color: #374953;">
								<tbody>
									
									<tr style="background-color: #ebebeb; text-align: center;">
										<th style="width: 40%; padding: 0.6em 0;">First Name :</th>
										<td style="background-color: #ebebeb; padding: 0.6em 0.4em;" align="left">'.$firstname.'</td>
									</tr>  
									<tr style="background-color: #ebebeb; text-align: center;">
										<th style="width: 40%; padding: 0.6em 0;">Last Name :</th>
										<td style="background-color: #ebebeb; padding: 0.6em 0.4em;" align="left">'.$lastname.'</td>
									</tr> 
									<tr style="background-color: #ebebeb; text-align: center;">
										<th style="width: 40%; padding: 0.6em 0;">Email :</th>
										<td style="background-color: #ebebeb; padding: 0.6em 0.4em;" align="left">'.$cn_email.'</td>
									</tr>
									<tr style="background-color: #ebebeb; text-align: center;">
										<th style="width: 40%; padding: 0.6em 0;">Phone :</th>
										<td style="background-color: #ebebeb; padding: 0.6em 0.4em;" align="left">'.$phone.'</td>
									</tr>
									<tr style="background-color: #ebebeb; text-align: center;">
										<th style="width: 40%; padding: 0.6em 0;">Message :</th>
										<td style="background-color: #ebebeb; padding: 0.6em 0.4em;" align="left">'.$message.'</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>';

			$mail = new PHPMailer();
		$mail->IsSMTP(); 
		
		
		$mail->Host = SMTP_HOST;
		$mail->SMTPAuth = true;
		$mail->Username = SMTP_EMAIL;
		$mail->Password = SMTP_PASSWORD;

		$mail->From = SMTP_FROM_EMAIL;
		$mail->FromName =SMTP_FROM_NAME;
		$mail->IsHTML(true);
		$mail->AddAddress($to);
		$mail->AddCC(AdminEmail);
		$mail->Subject = $subject;                               
		$mail->Body = $message;    
		
		$send_mail=$mail->Send(); 
		if($send_mail)
		{
			$_SESSION['mt'] = "success";
			$_SESSION['me'] = "Thank you for contacting us, We will get back to you as soon as we can.";
			//echo $_SESSION['me'];
			//exit;
			header("Location:contact.php");
		    exit();
			
		}else
		{
			$_SESSION['mt'] = "error";
			$_SESSION['me'] = "Error while sending mail";
			header("Location:contact.php");
		    exit();
		}
}

//Feedback
if($action=='feedback')
{
	$firstname=isset($_REQUEST['firstname'])?$_REQUEST['firstname']:""; 
	$lastname=isset($_REQUEST['lastname'])?$_REQUEST['lastname']:"";
	$cn_email=isset($_REQUEST['cn_email'])?$_REQUEST['cn_email']:"";
	$phone=isset($_REQUEST['phone'])?$_REQUEST['phone']:"";
	$feedback=isset($_REQUEST['experience'])?$_REQUEST['experience']:"";
	$message=isset($_REQUEST['message'])?$_REQUEST['message']:"";
	
	  	$to = $cn_email;
		$subject = 'Thank you for your feedback.';
		$message = '
			<table style="font-family: Verdana,sans-serif; font-size: 11px;color: #374953; width: 90%; border: 3px solid #3D5C7F; border-radius: 8px;" border="0" cellspacing="0" cellpadding="0" align="center">
				<tbody>
					<tr>
						<td style="background-color: #FFFFFF; color: #fff; font-size: 27px; padding: 15px;" align="center">
							<img src="'.SITE_URL.'images/logo.png" width="200" />
						</td>
					</tr>
					<tr>
						<td style="color: #fff; font-size: 12px; font-weight: bold; padding: 0.5em 1em;" align="center">
							Thank you for your valuable feedback.
						</td>
					</tr>
					<tr>
						<td style="background-color: #3d5c7f; color: #fff; font-size: 12px; font-weight: bold; padding: 0.5em 1em;" align="left">
							Feedback:
						</td>
					</tr>
					<tr>
						<td align="left">
							<table style="width: 100%; font-family: Verdana,sans-serif; font-size: 11px; color: #374953;">
								<tbody>
									<tr style="background-color: #ebebeb; text-align: center;">
										<th style="width: 40%; padding: 0.6em 0;">Feedback :</th>
										<td style="background-color: #ebebeb; padding: 0.6em 0.4em;" align="left">'.$feedback.'</td>
									</tr>  
									<tr style="background-color: #ebebeb; text-align: center;">
										<th style="width: 40%; padding: 0.6em 0;">First Name :</th>
										<td style="background-color: #ebebeb; padding: 0.6em 0.4em;" align="left">'.$firstname.'</td>
									</tr>  
									<tr style="background-color: #ebebeb; text-align: center;">
										<th style="width: 40%; padding: 0.6em 0;">Last Name :</th>
										<td style="background-color: #ebebeb; padding: 0.6em 0.4em;" align="left">'.$lastname.'</td>
									</tr> 
									<tr style="background-color: #ebebeb; text-align: center;">
										<th style="width: 40%; padding: 0.6em 0;">Email :</th>
										<td style="background-color: #ebebeb; padding: 0.6em 0.4em;" align="left">'.$cn_email.'</td>
									</tr>
									<tr style="background-color: #ebebeb; text-align: center;">
										<th style="width: 40%; padding: 0.6em 0;">Phone :</th>
										<td style="background-color: #ebebeb; padding: 0.6em 0.4em;" align="left">'.$phone.'</td>
									</tr>
									<tr style="background-color: #ebebeb; text-align: center;">
										<th style="width: 40%; padding: 0.6em 0;">Comment :</th>
										<td style="background-color: #ebebeb; padding: 0.6em 0.4em;" align="left">'.$message.'</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>';
			//echo AdminEmail;
			//exit;
		$mail = new PHPMailer();
		$mail->IsSMTP(); 
		
		
		$mail->Host = SMTP_HOST;
		$mail->SMTPAuth = true;
		$mail->Username = SMTP_EMAIL;
		$mail->Password = SMTP_PASSWORD;

		$mail->From = SMTP_FROM_EMAIL;
		$mail->FromName =SMTP_FROM_NAME;
		$mail->IsHTML(true);
		$mail->AddAddress($to);
		$mail->AddCC(AdminEmail);
		$mail->Subject = $subject;                               
		$mail->Body = $message;    
		
		$send_mail=$mail->Send(); 
		if($send_mail)
		{
			$_SESSION['mt'] = "success";
			$_SESSION['me'] = "Thank you for your valuable feedback.";
			//echo $_SESSION['me'];
			//exit;
			header("Location:feedback.php");
		    exit();
			
		}else
		{
			$_SESSION['mt'] = "error";
			$_SESSION['me'] = "Error while sending mail";
			header("Location:feedback.php");
		    exit();
		}
}
		

?>