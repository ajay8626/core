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


	$sql_detail=mysql_query("select * from tbluser where email ='".$emailaddress."' and password ='".md5($password)."'");
	$user_detail = mysql_fetch_assoc($sql_detail);

	$user_ID = $user_detail['user_id'];
	$utype = $user_detail['customer_type'];
	$detail_row = '';

	//echo $user_detail['customer_type'];exit();
	if ($user_detail['customer_type'] == 1) {	
		//echo "1";exit();
		$customer_1 = "SELECT tusr.* FROM tbluser AS tusr WHERE tusr.email ='".$emailaddress."' AND tusr.password ='".md5($password)."' AND tusr.company_name != '' AND tusr.firstname != '' AND tusr.lastname != '' AND tusr.address_1 != '' AND tusr.postal_code != '' AND tusr.reg_no != '' AND tusr.reg_vat_no != '' AND tusr.email != '' AND tusr.phone != '' AND tusr.paypal_email != ''";
		$sql_detail=mysql_query($customer_1);
		
		$comp_certi ="select comp_certi FROM tbl_user_comp_certi WHERE user_id = '".$user_ID."'";
		$comp_certi_detail=mysql_query($comp_certi);

		$license_passport ="select license_passport FROM tbl_user_license_passport WHERE user_id = '".$user_ID."'";
		$license_passport_detail=mysql_query($license_passport);

		
		$detail_row1=mysql_num_rows($sql_detail);
		$comp_certi_detail_row=mysql_num_rows($comp_certi_detail);
		$license_passport_detail_row=mysql_num_rows($license_passport_detail);
		
	}else{
		$customer_2 = "SELECT tusr.*,tulp.license_passport FROM tbluser AS tusr LEFT JOIN tbl_user_license_passport AS tulp ON tusr.user_id = tulp.user_id LEFT JOIN tbl_user_comp_certi AS ucc ON tusr.user_id = ucc.user_id WHERE tusr.email ='".$emailaddress."' AND tusr.password='".md5($password)."' AND tusr.firstname != '' AND tusr.lastname != '' AND tusr.address_1 != '' AND tusr.postal_code != '' AND tusr.email != '' AND tusr.phone != '' AND tusr.birthdate != '' AND tusr.gender != '' AND tusr.height != '' AND tusr.build != '' AND tusr.nationality != '' AND tusr.language != '' AND tusr.militry != '' AND tusr.drive != '' AND tusr.firstaid != '' AND tusr.paremedic != '' AND tusr.tattoos != '' AND tusr.piercing != '' AND tusr.paypal_email != '' AND tusr.right_to_work_uk != '' AND tusr.willing_to_travel != '' AND tusr.sia != '' AND tusr.how_far_willing_to_travel != '' AND tusr.activity != '' AND tusr.health != '' AND tusr.bio != '' AND tusr.experience != '' AND tusr.education_credentials != '' AND tulp.license_passport != '' AND tusr.uk_driving_license != ''";
		
		$sql_detail=mysql_query($customer_2);

		$utility ="select utility FROM tbl_user_utility WHERE user_id = '".$user_ID."'";
		$utility_detail=mysql_query($utility);

		$certificate ="select certificate FROM tbl_user_certi WHERE user_id = '".$user_ID."'";
		$certificate_detail=mysql_query($certificate);

		$detail_row2=mysql_num_rows($sql_detail);
		$utility_detail_row=mysql_num_rows($utility_detail);
		$certificate_detail_row=mysql_num_rows($certificate_detail);

		//echo "<pre>";print_r($utility_detail_row);exit;
		
	}

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
		if ($utype == 2) 
		{

			if ($detail_row2 < 1 || $utility_detail_row < 1 || $certificate_detail_row < 1)
			{				
				header("Location:profile-edit.php");
				exit();
			}else{

				if ($_REQUEST['post_new_job'] == 1) {
					header("location:postjob.php");
					exit();
				}elseif(isset($_SESSION['page_name']))
				{
					header("location:".$_SESSION['page_name']."");
					exit();
				}
				elseif($_SESSION['customer_type'] == 2)
				{
					header("location:individual-profile.php");
					exit();
				}else{
					header("location:individual-profile.php");
					exit();
				}
			}
			
		}

		if($utype == 1)
		{
			
			if ($detail_row1 < 1 || $comp_certi_detail_row < 1 || $license_passport_detail_row < 1) {
				
				header("Location:profile-edit.php");
				exit();
			}else{
				if ($_REQUEST['post_new_job'] == 1) {				
					
					header("location:postjob.php");
					exit();
				}elseif(isset($_SESSION['page_name']))
				{
					header("location:".$_SESSION['page_name']."");
					exit();
				}
				elseif($_SESSION['customer_type'] == 2)
				{
					header("location:business-profile.php");
					exit();
				}else{
					header("location:business-profile.php");
					exit();
				}
			}
			
		}
		
	}
}
else
{
	//$err.='Please enter valid credentials';
}

?>