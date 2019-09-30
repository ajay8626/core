<?php 
/*
{
"function":"forgotPassword",
"username":"tomasoalbinoni0189@gmail.com"
}
*/
include("../config.php");
include(SITE_PATH."api/class/message.php");


if(isset($rqst_data->function)){
	
	$my_array = array();
	$status = 1;
	if(isset($rqst_data->username) && $rqst_data->username != ''){
		$email = $rqst_data->username;
		$qry_email = mysql_query("SELECT id,CONCAT(firstname,' ',lastname) as name, email FROM tblcustomers where email='$email'");
			$count_email = mysql_num_rows($qry_email);						
		}
		if($count_email > 0){
			while($userdata = mysql_fetch_array($qry_email)){
				$user_id = $userdata['id'];
				$name = $userdata['name'];
				$email = $userdata['email'];
			}
			$rupw = base64_encode("rupw:".$user_id);
			$reseturl = SITE_URL."api/resetpassword.php?uid=$rupw";
			$message="<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>
<title>Mail</title>
</head>

<body style='margin:0; padding:0;'>

<table style='margin:0 auto; width:570px; border:2px solid #068fb2; ' border='0' cellpadding='0' cellspacing='0'>
 <thead>
  <tr>
   <th style='text-align:center; background:#fff; border-bottom:2px solid #068fb2; padding:22px 0 20px;'><img src='http://windowcleaner.mgtdemo.co.uk/api/clnr-logo.png' alt='' style='width: 150px;' /></th>
  </tr>
 </thead>
 <tbody>
  <tr>
   <td style=' font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#1e1e1e; font-size:16px; text-align:center; text-transform:uppercase; padding:32px 30px 0;'>Hello $name,</td>
  </tr>
  <tr>
   <td style='font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:13px; padding:32px 30px 0;line-height:21px;'>Somebody recently asked you reset your SQUEEGEE account password.</td>
  </tr>
  <tr>
   <td style='font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#1e1e1e; font-size:14px; text-align:center; text-transform:uppercase; padding:32px 30px 0;'><a href='".$reseturl."' style='color:#068FB2; text-decoration:underline;' target='_blank'>[Click here to change your password.]</a></td>
  </tr>
  <tr>
  	<td style='font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#1e1e1e; font-size:14px; text-align:center; text-transform:uppercase; padding:32px 30px 0;'>
							<a style='color:#068FB2' target='_blank'>Thank you,<br/><br/>
							SQUEEGEE APP Support Team<br/></a>
							 </td> 
  </tr>
  <tr>
  <td height='20'></td>
  </tr>
 </tbody>
</table>

</body>
</html>";
			/*$message ="<html>
				<head>
					<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
					<title></title>
				</head>
				<body style='padding: 0px;'>
					<center>
						<table width='600px' cellspacing='0' cellpadding='0' style='border: 1px solid #CCCCCC'>
						<tr>
							<td style='padding: 20px; font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #4e4e4e; text-align: left;'><strong>Hi $name,</strong></td>
						</tr>
						<tr>
							<td style='padding: 20px; text-align: left; color: #4e4e4e; padding: 5px 5px 5px 20px; font-family: Arial, Helvetica, sans-serif; font-size: 12px;'>
							Somebody recently asked to reset your SQUEEGEE APP account password.
							<br>
							<br/>
							<a href='".$reseturl."' target='_blank'>[Click here to change your password]</a>
							<br>
							<br/>
							<strong>Thank you,<br/>
							SQUEEGEE APP Support Team<br/>
							</strong>                  
							</td>
						</tr>
						</table>
					</center>
			</body>
			</html>";*/
			$emailto = $email;
			$subject = "Forgotten Password Reset";
			
			$chk = sendMsg($emailto, $subject, $message);

			
			if($chk){
				$forgotPasswordMsg = get_msg("forgotPasswordMsg") ? get_msg("forgotPasswordMsg") : '';
				$my_array['requestSent'] = 1; 
				$status = 1;
			}else{
				$forgotPasswordMsg = get_msg("forgotPasswordMsgNotSend") ? get_msg("forgotPasswordMsgNotSend") : '';
				$my_array['requestSent'] = 0;
				$status = 0; 
			}
		}else{
			$forgotPasswordMsg = get_msg("forgotPasswordUserNotFound") ? get_msg("forgotPasswordUserNotFound") : '';
				$my_array['requestSent'] = 0;
				$status = 0; 
		}
		
	
	$otherinfo = array();  
	$my_array = array_merge($otherinfo,$my_array);
	header('Content-type: application/json;');
	$final_array = array('result'=>$my_array,'message'=>$forgotPasswordMsg,'status'=>$status);
	echo $json= json_encode($final_array);
}else{
	$final_array = array('result'=>'','status'=>0);
	echo $json= json_encode($final_array);
}
?>