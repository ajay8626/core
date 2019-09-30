<?php 
include "config.php";
$email=isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
$status=isset($_REQUEST['status']) ? $_REQUEST['status'] : 0;
$verificationcode=isset($_REQUEST['verificationcode']) ? $_REQUEST['verificationcode'] : '';
$name=get_name($email);
$get_user_id=get_user_id($email);
$is_email_verify=is_email_verify($email);
$userverification_code=verification_code($email);
$get_customer_type=get_customer_type($email);
if($status==0 && $verificationcode=='')
{
	
	//echo '111';
	//exit;
$_SESSION['mt'] = "success";
$_SESSION['me'] = "Verification code sent to your registered email address. Please verify your account by clicking on verification link.";
$code = rand(99999,10000);
//$update=mysql_query("update tbluser SET verification_code=".$code." where user_id=".$get_user_id."");

        $to= $email;
		$subject = 'Email Verification';

$message_data = '<html><body style="margin:0; padding:0;">
<table style="margin:0 auto; width:570px; border:2px solid #CF2027; " border="0" cellpadding="0" cellspacing="0">
<thead>
<tr>
<th style="text-align:center; background:#fff; border-bottom:2px solid #CF2027; padding:22px 0 20px;"><img src="'.SITE_URL.'images/logo.png" alt="" style="width:50%;"/></th>
</tr>
</thead>
<tbody>
<tr>
<td style=" font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:16px; padding:32px 30px 0;">Hello '.$name.',</td>
</tr>
<tr>
<td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; padding:32px 30px 0;line-height:21px;">Kindly click on the below link to verify your account.</td>
</tr>
<tr>
<td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 0;"> <a href="'.SITE_URL.'emailverify.php?email='.$email.'&status=1" style="color:#6FB144!important;text-decoration: none; font-weight: bold;font-size: 20px;" target="_blank">
<span style="color:#6FB144;text-decoration: none; font-weight: bold;font-size: 20px;font-family: Open Sans,sans-serif;margin:0;">Verify</span></a></td>
</tr>
<tr>
<td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 0;"> Verification Code: '.$code.'</td>
</tr>
<tr>
<td style="font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; line-height:21px;padding:32px 30px 30px;">Thank you,<br/>Secure That Job Team</td>
</tr>
</tbody>
</table>
</body></html>';
		
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
		$mail->Body = $message_data;    
		
		$send_mail=$mail->Send();

        if($send_mail)
		{		
			$update=mysql_query("update tbluser SET verification_code=".$code." where user_id=".$get_user_id."");
			$message="Verification code sent to your registered email address. Please verify your account by clicking on verification link.";
			$_SESSION['mt'] = "success";
            $_SESSION['me'] = $message;
			
		}
		else
		{
			$message="Your Request cannot be sent for now. Please try later.";
            $_SESSION['mt'] = "success";
            $_SESSION['me'] = $message;			
		}

}

if($status==0 && $verificationcode!='')
{
	$message='Please verify your account by clicking on verification link.';
	$_SESSION['mt'] = "success";
    $_SESSION['me'] = $message;
}

if($is_email_verify==1)
{
	if($get_customer_type==1)
	{
		header("Location:business-profile.php");
	}
	if($get_customer_type==2)
	{
		header("Location:individual-profile.php");
	}
	//$message='Your account has been already verified.';
	//$_SESSION['mt'] = "success";
    //$_SESSION['me'] = $message;
}


if($status==1 && $is_email_verify!=1 && isset($_POST['submit']))
{
	if($verificationcode==$userverification_code)
	{
	//$message='Your account has been sucessfully verified.';
	$update=mysql_query("update tbluser SET is_email_verify=1 where user_id=".$get_user_id."");
	if($get_customer_type==1)
	{
		header("Location:business-profile.php");
	}
	if($get_customer_type==2)
	{
		header("Location:individual-profile.php");
	}
	//$_SESSION['mt'] = "success";
    //$_SESSION['me'] = $message;
	}
	else
	{
		$message='Code does not match, please try again.';
		$_SESSION['mt'] = "success";
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
<title>Email Verification - SECURE THAT JOB</title>

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
jQuery(document).ready(function($){	
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
	//alert("hello");
	if($('#business_user').is(":checked") && $('#company_name').val()=='') 
	{
	  alert("Please enter company name");
	  return false;
	}
	
	var vals=$('#customer_email').val();
	if(vals!='')
	{
		 get_check(vals);
	}
}

function get_check(vals)
{
	if(vals!='')
	{
		$.post("check_email.php",{
			emailaddress:vals
		},
		function(result)
		{
			if(result!=0)
			{
				$('.danger').remove();
				$('#customer_email').after('<span class="danger">This Email Address is already exists!. Try another email address</span>');
				//$('#customer_email').val('');
				return false;
				//alert("hello");
			}
			else
			{
				$('.danger').remove();
			}
			//alert(result);
		});
	}
	//alert(vals);
}
</script>
</head>
<body>
<?php include "header-inner.php"; ?>
<div class="stj_login_wrap">
	<div class="container">
		<div class="row">
			 
			<div class="login_dv">
				<div class="lg_dv_lft">
				<?php echo getMsg(); ?>
					<h2>Email Verification</h2>
					<ul>
					   <form method="post" name="emailverify" action="<?php echo basename($_SERVER['REQUEST_URI']); ?>">
						<li>
							<label>Verification Code <em>*</em></label>
							<input type="hidden" id="emailaddress" name="emailaddress" value="<?php echo $email; ?>">
							<input type="text" name="verificationcode" id="verificationcode" required value="" class="txt_lg" />
						</li>
						
						<li>
							<input type="submit" name="submit" value="Verify" class="btn_lg"/>
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