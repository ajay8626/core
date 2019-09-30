<?php 
error_reporting(0);
require_once '../config.php';
require("inc/class.phpmailer.php");

$admin_name=$_REQUEST['admin_name'];
if(isset($_REQUEST['admin_name'])&& $_REQUEST['admin_name']!=''){

	$eroare=0;
	$name = $_POST['admin_name'];
	$sql="select * from tbladmin  where adminemail='".$_POST['admin_name']."' and isactive='1'"; 
	$result=$db->Query($sql);
	
	$rs = mysql_fetch_assoc($result);		
	$rows=mysql_num_rows($result);
	if($rows>0){
		$adminid = $rs["adminid"];
		$adminfname	= $rs["adminfname"];
		$lname	= $rs["adminlname"];
		$email	= $rs["adminemail"];
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
							Admin Login Information:
						</td>
					</tr>
					<tr>
						<td align="left">
							<table style="width: 100%; font-family: Verdana,sans-serif; font-size: 11px; color: #374953;">
								<tbody>
									<tr style="background-color: #ebebeb; text-align: center;">
										<th style="width: 40%; padding: 0.6em 0;">Name:</th>
										<td style="background-color: #ebebeb; padding: 0.6em 0.4em;" align="left">'.$adminfname.' '.$lname.'</td>
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
			$update =mysql_query("UPDATE tbladmin SET password='$newpassword' WHERE adminid=$adminid");
			$message="An email with password has been sent to <br/> you on your email address .";
		}
		else
			$message="Your Request cannot be sent for now. Please try later.";
	}
	else
	{
		$message="This email address doesn't exists.<br/> Please enter valid email address to retrieve  your password.";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo TITLE; ?> | Log in</title>
  
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/theme.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="css/blue.css">
  <script type="text/javascript" src="js/validation.js"></script>
  <script src="js/jQuery/jquery-2.2.3.min.js"></script>
 <script src="js/bootstrap.min.js"></script>	
</head>
	<script language="JavaScript">
function Clicking(){
objForgot = document.forgot;
	if(objForgot.admin_name.value==''){
		alert("Please enter your email address");
		objForgot.admin_name.focus();
		return false;
	}
	
}
</script>
</head>
<body class="hold-transition login-page">
	<div class="login-box">
        <div class="login-logo">
			<a href="<?php echo ADMIN_URL;?>"><img  src="img/logo.png" alt=""/></a>
		</div> 
		<div class="login-box-body">
           
              <p class="login-box-msg">Forgot Password</p>
        
					<?php 
						if(isset($message)&& $message!=""){?>
								<div class="message info">
									<p>
										<?php echo $message ?>
									</p>
								</div>
						<?php	
							}
						?>
                  <form name="forgot" method="post" action="forgot.php">
                    <div class="box box-primary">
					 <div class="box-body">
                        <div class="form-group">
                           
								 <label> Email address</label>
                                <input type="text" class="form-control" name="admin_name" autofocus />
                           
                        </div>
						 <div class="row">
                           <div class="col-xs-4">
								
								<span>
									<input type="submit" class="btn btn-primary btn-block btn-flat" value="Submit" onClick="return Clicking();" />
								</span>
                                <a href="index.php" class="pull-right">Back to login</a>
                            </div>
                        </div>
						</div>
                    </div>
                    </form>
                
          
        </div>
		
    </div>
 
</body>
</html>

