<?php 

/*
{"function":"userLogin","username":"testcustomer@gmail.com","password":"admin@123","deviceToken":"asdfadfsadf123123213","deviceType":1,"userType":1}
1=customer
2=cleaner
*/

include("../config.php");
if(isset($rqst_data->function)){
	$Username = 	isset($rqst_data->username)?stripslashes($rqst_data->username):"";
	$Password = 	isset($rqst_data->password)?stripslashes($rqst_data->password):"";
	$userType = 	isset($rqst_data->userType)?stripslashes($rqst_data->userType):"";
	$Password = md5($Password);
	$DeviceToken = 	isset($rqst_data->deviceToken)?stripslashes($rqst_data->deviceToken):"";
	$DeviceType = 	isset($rqst_data->deviceType)?stripslashes($rqst_data->deviceType):0;
	$NotificationAlert = 	isset($rqst_data->notificationAlert)?stripslashes($rqst_data->notificationAlert):1;
	$my_array=array();
	$msg='';
	$IsAvailable=1;
	$is_notification=0;
	$status_array = 1;
	$user_obj=array();
	$user_auth_token = 0;
	$user_id=0;
	$email="";
	$firstname="";
	$lastname="";
	$phone=0;
	$address_1="";
	$address_2="";
	$address_3="";
	$postal_code="";
	$leads=0;
	if($Username != "" && $Password != "" && $userType != "" ){
		if($userType == 1){
			$sql="select id,email,firstname,lastname,phone,address_1,address_2,address_3,postal_code,leads,customer_type from tblcustomers where email ='".$Username."' and password ='".$Password."' and status = '1'";
			$res=$db->Query($sql);
			$rows=mysql_num_rows($res);
			list($user_id,$email,$firstname,$lastname,$phone,$address_1,$address_2,$address_3,$postal_code,$leads,$customer_type)=mysql_fetch_row($res);
			$user_auth_token=base64_encode($user_id.':'.$DeviceToken);
		}
		if($userType == 2){
			$sql="select id,firstname,lastname,email,address_1,address_2,phone from tblcleaners where email ='".$Username."' and password ='".$Password."' and status = '1'";
			$res=$db->Query($sql);
			$rows=mysql_num_rows($res);
			list($user_id,$firstname,$lastname,$email,$address_1,$address_2,$phone)=mysql_fetch_row($res);
			$user_auth_token=base64_encode($user_id.':'.$DeviceToken);
		}
		
		
		if($rows > 0){
			$tokensql="select user_auth_token from tblusertoken where  DeviceToken ='".$DeviceToken."' and user_type=$userType";
			$restoken=$db->Query($tokensql);
			$rowstoken=mysql_num_rows($restoken);
			if($rowstoken == 0){
			//$db->Query("Delete FROM tblusertoken WHERE user_id=$user_id and user_type=$userType");
				$user_auth_token=base64_encode($user_id.':'.$DeviceToken);
				$data = array("user_id"=>$user_id,"user_auth_token"=>$user_auth_token,"user_type"=>$userType,'device_type'=>$DeviceType,'DeviceToken'=>$DeviceToken);
				$db->Insert($data,"tblusertoken");
				if($userType == 1){
					$data=array("devicetype"=>$DeviceType);
					$where ="id = {$user_id}";
					$db->Update($data,"tblcustomers",$where);
					//customer object
					$user_obj=array('id'=>(int)$user_id,'email'=>$email,'firstname'=>$firstname,'lastname'=>$lastname,'phone'=>$phone,'address_1'=>$address_1,'address_2'=>$address_2,'address_3'=>$address_3,'postal_code'=>$postal_code,'leads'=>(int)$leads,'customer_type'=>$customer_type);
				}
				if($userType == 2){
					$data=array("devicetype"=>$DeviceType);
					$where ="id = {$user_id}";
					$db->Update($data,"tblcleaners",$where);
					//cleaner object
					$user_obj=array('id'=>(int)$user_id,'firstname'=>$firstname,'lastname'=>$lastname,'email'=>$email,'address_1'=>$address_1,'address_2'=>$address_2,'phone'=>$phone);
				}
			}else{
				list($user_auth_token)=mysql_fetch_row($rowstoken);
				if($userType == 1){
					//customer object
					$user_obj=array('id'=>(int)$user_id,'email'=>$email,'firstname'=>$firstname,'lastname'=>$lastname,'phone'=>(int)$phone,'address_1'=>$address_1,'address_2'=>$address_2,'address_3'=>$address_3,'postal_code'=>$postal_code,'leads'=>(int)$leads,'customer_type'=>$customer_type);
				}else{
					//cleaner object
					$user_obj=array('id'=>(int)$user_id,'firstname'=>$firstname,'lastname'=>$lastname,'email'=>$email,'address_1'=>$address_1,'address_2'=>$address_2,'phone'=>(int)$phone);
				}
			}
			$msg=get_msg("success")?get_msg("success"):'success';	
		} else{
			$status_array = 0;
			$IsAvailable=0;
			$msg = get_msg("loginfailed")?get_msg("loginfailed"):'loginfailed';
			$my_array = array("username"=>$Username);
		}
	}else{		
		$msg = get_msg("invalid_login_details")?get_msg("invalid_login_details"):'invalid_login_details';
		$IsAvailable=0;
		$status_array = 0;
	}
	
	$otherinfo = array("authenicateId"=>$user_auth_token,'user_obj'=>$user_obj,"isAvailable"=>$IsAvailable,"isNotification"=>$is_notification);
	
	$my_array = array_merge($my_array, $otherinfo);
	header('Content-type: application/json; charset=utf-8');
	$final_array = array('result'=>$my_array,"message"=>$msg,'status'=>$status_array);
	echo $json= json_encode($final_array);
}else{
	$final_array = array('result'=>'','status'=>0);
	echo $json= json_encode($final_array);
}
?> 