<?php
require_once 'config.php';

$emailaddress=isset($_REQUEST['emailaddress'])?$_REQUEST['emailaddress']:'';
$password=isset($_REQUEST['password'])?$_REQUEST['password']:'';

$err='';
if($emailaddress=='')
{
  $err.='Please enter valid email address.';	
}
if($password=='')
{
  $err.='Please enter valid password.';	
}

if($emailaddress!='' && $password!='')
{
	$sql=mysql_query("select user_id,email,firstname,lastname,profile_image,status,customer_type from tbluser where email ='".$emailaddress."' and password ='".md5($password)."'");
	$noofrows=mysql_num_rows($sql);
	list($user_id,$useremail,$firstname,$lastname,$profile_image,$status,$customer_type)=mysql_fetch_row($sql);
	if($noofrows==0)
	{
		$_SESSION['mt'] = "danger";
		$_SESSION['me'] = "Invalid Email Address Or Password, Please Try Again.";
		header("Location:login.php");
		exit();
	}
	else if($status==0)
	{
		//$err.='Invalid Email Address / Password';
		$_SESSION['mt'] = "warning";
		$_SESSION['me'] = "Your account is inactive. Contact administrator to activate it.";
		header("Location:login.php");
		exit();
	}
	else
	{
		$_SESSION['user_id']=$user_id;
		$_SESSION['user_email']=$useremail;
		$_SESSION['fname']=$firstname;
		$_SESSION['lname']=$lastname;
		$_SESSION['pimage']=$profile_image;
		$_SESSION['customer_type']=$customer_type;
		
		$_SESSION['mt'] = "success";
		$_SESSION['me'] = "Login successfully.";
		$_SESSION['login_pop_up'] = 1; 
		
		$update=mysql_query("update tbluser SET last_login='".date("Y-m-d h:i:s")."' where user_id=".$user_id."");
		
		if(isset($_SESSION['page_name']))
		{
			header("location:".$_SESSION['page_name']."");
			exit();
		}
		elseif($_SESSION['customer_type'] == 2)
		{
			header("location:jobs.php");
			exit();
		}else{
			header("location:new-request.php");
			exit();
		}
	}
}
else
{
	//$err.='Please enter valid credentials';
}

?>