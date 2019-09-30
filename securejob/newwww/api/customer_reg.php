<?php 
/*
{
"function":"customerReg",
"customerId":0,
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
"no_windows":2,
"no_doors":2,
"no_conservatory":4,
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
	$pass = isset($rqst_data->password)?($rqst_data->password):"";
	$password = isset($rqst_data->password)?($rqst_data->password):"";
	$phone = isset($rqst_data->phone)?($rqst_data->phone):"";
	$address1 = isset($rqst_data->address1)?($rqst_data->address1):"";
	$address2 = isset($rqst_data->address2)?($rqst_data->address2):"";
	$address3 = isset($rqst_data->address3)?($rqst_data->address3):"";
	$postCode = isset($rqst_data->postCode)?($rqst_data->postCode):"";
	$DeviceType = isset($rqst_data->deviceType)?($rqst_data->deviceType):"";
	$deviceToken = isset($rqst_data->deviceToken)?($rqst_data->deviceToken):"";
	$customerId = isset($rqst_data->customerId)?($rqst_data->customerId):"";
	$no_windows = isset($rqst_data->no_windows)?($rqst_data->no_windows):"";
	$no_doors = isset($rqst_data->no_doors)?($rqst_data->no_doors):"";
	$no_conservatory = isset($rqst_data->no_conservatory)?($rqst_data->no_conservatory):"";
	
	$status_array = 1;
	$IsAvailable=1;
	$my_array=array();
	$msg="";
	$user_auth_token = 0;
	$userType=1;
	if($customerId!=0)
	{
	$sql = "select * from tblcustomers where id = {$customerId}";
				$totRows = mysql_num_rows($db->Query($sql));
        if($totRows==0)
		{
			$IsAvailable=0;
			$status_array = 0;
			$msg = get_msg("no_record_found")?get_msg("no_record_found"):'';
		}
        else
        {
			        $password  =  	md5($password);
					$data = array('firstname'=>$firstName,'lastname'=>$lastName,'password'=>$password,'phone'=>$phone,'email'=>$emailAddress,'address_1'=>$address1,'address_2'=>$address2,'address_3'=>$address3,'postal_code'=>$postCode,'devicetype'=>$DeviceType,'customer_type'=>$customerType,'status'=>1,'modified_date'=>date('Y-m-d H:i:s'),'no_windows'=>$no_windows,'no_doors'=>$no_doors,'no_conservatory'=>$no_conservatory);
			        $where ="id = {$customerId}";
					$db->Update($data,"tblcustomers",$where);

                     $tokensql="select user_auth_token from tblusertoken where  DeviceToken ='".$deviceToken."' and user_id=".$customerId."";
					 $restoken=$db->Query($tokensql);
			         $rowstoken=mysql_num_rows($restoken);
					 $user_auth_token=base64_encode($customerId.':'.$deviceToken);
					 
					 $sqlloyalty="select id from tblloyaltypoints where customer_id=".$customerId." and IsRead=0";
					 $countres=$db->Query($sqlloyalty);
					 $rowtotalloyal=mysql_num_rows($countres);
					if($rowstoken == 0){
						
						$data = array("user_id"=>$customerId,"user_auth_token"=>$user_auth_token,'device_type'=>$DeviceType,'DeviceToken'=>$deviceToken);
						$db->Insert($data,"tblusertoken");
					}
					$status_array = 1;
					$msg=get_msg("user_updated_suc")?get_msg("user_updated_suc"):'';
					$user_obj=array('id'=>$customerId,'email'=>$emailAddress,'firstname'=>$firstName,'lastname'=>$lastName,'phone'=>$phone,'address_1'=>$address1,'address_2'=>$address2,'address_3'=>$address3,'postal_code'=>$postCode,'leads'=>0,"customer_type"=>$customerType,"user_type"=>$userType,"loyalityPoints"=>(int)$rowtotalloyal,"password"=>$pass,'no_windows'=>(int)$no_windows,'no_doors'=>(int)$no_doors,'no_conservatory'=>(int)$no_conservatory);
					 
					 
		}			
	}else {
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
					$data = array('firstname'=>$firstName,'lastname'=>$lastName,'password'=>$password,'phone'=>$phone,'email'=>$emailAddress,'address_1'=>$address1,'address_2'=>$address2,'address_3'=>$address3,'postal_code'=>$postCode,'devicetype'=>$DeviceType,'customer_type'=>$customerType,'status'=>1,'created_date'=>date('Y-m-d H:i:s'),'no_windows'=>$no_windows,'no_doors'=>$no_doors,'no_conservatory'=>$no_conservatory);
					$db->Insert($data,"tblcustomers");
					$last_id = mysql_insert_id();
					
					$msg=get_msg("success")?get_msg("success"):'success';
					$user_auth_token=base64_encode($last_id.':'.$deviceToken);
					
					$data = array("user_id"=>$last_id,"user_auth_token"=>$user_auth_token,"user_type"=>$userType,'device_type'=>$DeviceType,'DeviceToken'=>$deviceToken);
					$db->Insert($data,"tblusertoken");
					
					$sqlloyalty="select id from tblloyaltypoints where customer_id=".$last_id." and IsRead=0";
					 $countres=$db->Query($sqlloyalty);
					 $rowtotalloyal=mysql_num_rows($countres);
					
					$user_obj=array('id'=>$last_id,'email'=>$emailAddress,'firstname'=>$firstName,'lastname'=>$lastName,'phone'=>$phone,'address_1'=>$address1,'address_2'=>$address2,'address_3'=>$address3,'postal_code'=>$postCode,'leads'=>0,"customer_type"=>$customerType,"user_type"=>$userType,"loyalityPoints"=>(int)$rowtotalloyal,"password"=>$pass,'no_windows'=>(int)$no_windows,'no_doors'=>(int)$no_doors,'no_conservatory'=>(int)$no_conservatory);
					
				}                 
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