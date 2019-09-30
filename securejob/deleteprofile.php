<?php
include "config.php";
include "check_user_login.php";
$customer_type=isset($_SESSION['customer_type']) ? $_SESSION['customer_type'] : 0;
$user_id=isset($_SESSION['user_id']) ? $_SESSION['user_id'] :0;

//$deleteacc="delete  from tbluser where user_id=".$user_id."";
$where = "user_id  = {$user_id}";
$anonymous='anonymous';
$password=md5('anonymous123');
$data = array('firstname'=>$anonymous,'lastname'=>$anonymous,'phone'=>$anonymous,'email'=>$anonymous,'address_1'=>$anonymous,'address_2'=>$anonymous,'address_3'=>$anonymous,'modified_date'=>date('Y-m-d H:i:s'),'bank_name'=>$anonymous,'acc_holder_name'=>$anonymous,'sort_code'=>$sort_code,'acc_number'=>$acc_number,'reg_no'=>$registration_no,'reg_vat_no'=>$anonymous,'company_name'=>$anonymous,'city_id'=>0,'state_id'=>0,'birthdate'=>'1970-01-01','gender'=>0,'height'=>0,'build'=>0,'nationality'=>$anonymous,'language'=>$anonymous,'militry'=>0,'drive'=>0,'firstaid'=>0,'tattoos'=>0,'sia'=>0,'activity'=>$anonymous,'health'=>$anonymous,'bio'=>$anonymous,'latitude'=>0,'longitude'=>0,'paypal_email'=>$anonymous,'status'=>0,'password'=>$password,'customer_type'=>0);


if($db->Update($data,"tbluser",$where)){
	session_destroy(); 
	$_SESSION['mt'] = "success";
	$_SESSION['me'] = "Your Profile has been successfully deleted from Secure That Job.";
	header("Location:index.php");
}else{
	
	$_SESSION['mt'] = "error";
	$_SESSION['me'] = "Error while delete Your Profile. Please try again.";
	
	if($customer_type==1)
	{
		header("Location:business-profile.php");
		exit();
	}
	if($customer_type==2)
	{
		header("Location:individual-profile.php");
		exit();
	}
}

?>