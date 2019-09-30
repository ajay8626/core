<?php 
/*
{
"function":"customerReg",
"customerType":"Domestic",
"firstName":"newuser",
"lastName":"from mobile",
"emailAddress":"lol@gmail.com",
"password":"abc",
"phone":1,
"address1":"xyz",
"address2":"xyz",
"address3":"xyz",
"postCode":"xyz xyz",
"DeviceType":1,
"deviceToken":"deviceToken"
}

customer type= 'Domestic', 'Commercial'
*/

include("../config.php");
if(isset($rqst_data->function)){
	$customerType = isset($rqst_data->customerType)?($rqst_data->customerType):"";
	$firstName = isset($rqst_data->firstName)?($rqst_data->firstName):"";
	$lastName = isset($rqst_data->lastName)?($rqst_data->lastName):"";
	$emailAddress = isset($rqst_data->emailAddress)?($rqst_data->emailAddress):"";
	$password = isset($rqst_data->password)?($rqst_data->password):"";
	$phone = isset($rqst_data->phone)?($rqst_data->phone):"";
	$address1 = isset($rqst_data->address1)?($rqst_data->address1):"";
	$address2 = isset($rqst_data->address2)?($rqst_data->address2):"";
	$address3 = isset($rqst_data->address3)?($rqst_data->address3):"";
	$postCode = isset($rqst_data->postCode)?($rqst_data->postCode):"";
	$DeviceType = isset($rqst_data->DeviceType)?($rqst_data->DeviceType):"";
	$deviceToken = isset($rqst_data->deviceToken)?($rqst_data->deviceToken):"";
	$status_array = 1;
	$IsAvailable=1;
	$my_array=array();
	$msg="";
	$user_auth_token = 0;
	if($emailAddress != ""){			
			$totRows = 0;
			$sql = "select * from tblcustomers where email = '{$emailAddress}'";
			$totRows = mysql_num_rows($db->Query($sql));
			if($totRows >0){
				//list($user_auth_token,$id)=mysql_fetch_row($sql);				
				$msg = get_msg("already_register")?get_msg("already_register"):'already_register';
				$IsAvailable=0;
				$status_array = 0;
				//$otherinfo = array("authenicateId"=>$user_auth_token,"isAvailable"=>$IsAvailable);
			}
			else
			{ 
				$password  =  	md5($password);
				$data = array('firstname'=>$firstName,'lastname'=>$lastName,'password'=>$password,'phone'=>$phone,'email'=>$emailAddress,'address_1'=>$address1,'address_2'=>$address2,'address_3'=>$address3,'postal_code'=>$postCode,'devicetype'=>$DeviceType,'customer_type'=>$customerType,'status'=>1,'created_date'=>date('Y-m-d H:i:s'));
				$db->Insert($data,"tblcustomers");
				$last_id = mysql_insert_id();
				
				$msg=get_msg("success")?get_msg("success"):'success';
				$user_auth_token=base64_encode($last_id.':'.$deviceToken);
				
				$data = array("user_id"=>$last_id,"user_auth_token"=>$user_auth_token,"user_type"=>$userType,'device_type'=>$DeviceType,'DeviceToken'=>$deviceToken);
				$db->Insert($data,"tblusertoken");
				
				$user_obj=array('id'=>$last_id,'email'=>$emailAddress,'firstname'=>$firstName,'lastname'=>$lastName,'phone'=>$phone,'address_1'=>$address1,'address_2'=>$address2,'address_3'=>$address3,'postal_code'=>$postCode,'leads'=>0);
				
			}                 
	}
	$otherinfo = array("authenicateId"=>$user_auth_token,'user_obj'=>$user_obj,"isAvailable"=>$IsAvailable);
	
	$my_array = array_merge($my_array, $otherinfo);
	header('Content-type: application/json; charset=utf-8');
	$final_array = array('result'=>$my_array,"message"=>$msg,'status'=>$status_array);
	echo $json= json_encode($final_array);
}else{
	$final_array = array('result'=>'','status'=>0);
	echo $json= json_encode($final_array);
}
?> 