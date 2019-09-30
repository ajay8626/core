<?php 
include "config.php";
require("admin/inc/class.phpmailer.php");
$emailaddress=$_REQUEST['emailaddress'];
if(isset($_REQUEST['emailaddress'])&& $_REQUEST['emailaddress']!=''){

	$eroare=0;
	$name = $_POST['emailaddress'];
	$sql="select * from tbluser  where email='".$_POST['emailaddress']."' and status='1'"; 
	$result=$db->Query($sql);
	
	$rs = mysql_fetch_assoc($result);		
	$rows=mysql_num_rows($result);
	if($rows>0){
		$user_id = $rs["user_id"];
		$firstname	= $rs["firstname"];
		$lastname	= $rs["lastname"];
		$email	= $rs["email"];
		$pass 	= $rs["password"];
		$username = $rs["userid"];
		$newpass = rand(99999,10000);
		$newpassword = md5($newpass);
		//exit;
		// Mail Information
		$to      = $email;
		$subject = 'Forgot Password';
		$message = '
			<table style="font-family: Verdana,sans-serif; font-size: 11px;color: #374953; width: 90%; border: 3px solid #3D5C7F; border-radius: 8px;" border="0" cellspacing="0" cellpadding="0" align="center">
				<tbody>
					<tr>
						<td style="background-color: #FFFFFF; color: #fff; font-size: 27px; padding: 15px;" align="center">
							<img src="'.SITE_URL.'admin/img/logo.png"  />
						</td>
					</tr>
					<tr>
						<td style="background-color: #3d5c7f; color: #fff; font-size: 12px; font-weight: bold; padding: 0.5em 1em;" align="left">
							User Login Information:
						</td>
					</tr>
					<tr>
						<td align="left">
							<table style="width: 100%; font-family: Verdana,sans-serif; font-size: 11px; color: #374953;">
								<tbody>
									<tr style="background-color: #ebebeb; text-align: center;">
										<th style="width: 40%; padding: 0.6em 0;">Name:</th>
										<td style="background-color: #ebebeb; padding: 0.6em 0.4em;" align="left">'.$firstname.' '.$lastname.'</td>
									</tr>  
									<tr style="background-color: #ebebeb; text-align: center;">
										<th style="width: 40%; padding: 0.6em 0;">Email :</th>
										<td style="background-color: #ebebeb; padding: 0.6em 0.4em;" align="left">'.$email.'</td>
									</tr>  
									<tr style="background-color: #ebebeb; text-align: center;">
										<th style="width: 40%; padding: 0.6em 0;">Password :</th>
										<td style="background-color: #ebebeb; padding: 0.6em 0.4em;" align="left">'.$newpass.'</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>';
		
	/* 	$headers = "From: admin <".AdminEmail.">\r\n"; 
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; */
		 
		//Send Mail Function
		
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
		
		$mail->Subject = $subject;                               
		$mail->Body = $message;    
		
		$send_mail=$mail->Send(); 
		
		//$send_mail = @mail($to, $subject, $message, $headers);
		if($send_mail)
		{		
			$update =mysql_query("UPDATE tbluser SET password='$newpassword' WHERE user_id=$user_id");
			$message="An email with your password has been sent to <br/> your registered email address.";
			
			$_SESSION['mt'] = "success";
		    $_SESSION['me'] = $message;
			
		}
		else
		{
			$message="Your Request cannot be sent for now. Please try later.";
			$_SESSION['mt'] = "warning";
		    $_SESSION['me'] = $message;
		}
		
	}
	else
	{
		$message="This email address doesn't exists.<br/> Please enter valid email address to retrieve  your password.";
		$_SESSION['mt'] = "danger";
		$_SESSION['me'] = $message;
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="theme-color" content="#cf2027">
<meta name="msapplication-navbutton-color" content="#cf2027">
<meta name="apple-mobile-web-app-status-bar-style" content="#cf2027">
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<title>Forgot Password - SECURE THAT JOB</title>

<!-- Bootstrap -->
<link href="https://fonts.googleapis.com/css?family=Fira+Sans:300,400,400i,500,600,700,800" rel="stylesheet"> 
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link href="css/ddsmoothmenu.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">
<link href="fonts/font-awesome.css" rel="stylesheet">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.bxslider.js"></script>
<script type="text/javascript" src="js/menu.js"></script>
<script type="text/javascript" src="js/at-jquery.js"></script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({includedLanguages: '<?php echo LanguageList; ?>', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script>
<script>
jQuery(document).ready(function($) {	
$('.rd_lb input:radio').click(function() {
    $('.rd_lb input:radio[name='+$(this).attr('name')+']').parent().removeClass('active');
        $(this).parent().addClass('active');
});
$('#business_user').click(function() {
$('#comp_div').show();
});	
$('#personal_user').click(function() {
$('#comp_div').hide();
});	
});

function validate()
{
	if($('#business_user').is(":checked") && $('#company_name').val()=='') 
	{
	  alert("Please enter company name");
	  return false;
	}
}
</script>
</head>
<body>
<?php include "header-inner.php"; ?>
<div class="stj_login_wrap">
	<div class="container">
		<div class="row">
			 
			<div class="login_dv">
				<div class="lg_dv_lft" style="border-right:none;">
				<?php echo getMsg(); ?>
					<h2>Forgot Password</h2>
					
					<ul>
					   <form method="post" name="forgot_form" action="forgot.php">
						<li>
							<label>Email Address <em>*</em></label>
							<input type="email" name="emailaddress" required value="" class="txt_lg" />
						</li>
						
						<li>
							<a class="a_fp" href="login.php">Back to login</a>
							<input type="submit" value="Submit" class="btn_lg"/>
						</li>
						</form>
					</ul>

				</div>
				
				
			</div>
			
		</div>
	</div>
</div>
 
<?php include "footer.php"; ?>
</body>
</html>