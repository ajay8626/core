<?php 
/*
{
"function": "update_cleaner",
"cleanerId":1,
"firstName":"nilesh",
"lastName":"borana",
"emailAddress":"nilesh@webtechsystem.com",
"phone":"9999999999",
"password":"123456"
}
*/

include("../config.php");
if(isset($rqst_data->function)){
    $cleanerId = isset($rqst_data->cleanerId)?($rqst_data->cleanerId):"";
	$firstname = isset($rqst_data->firstName)?($rqst_data->firstName):"";
	$lastname = isset($rqst_data->lastName)?($rqst_data->lastName):"";
	$email = isset($rqst_data->emailAddress)?($rqst_data->emailAddress):"";
	$phone = isset($rqst_data->phone)?($rqst_data->phone):"";
	$password = isset($rqst_data->password)?($rqst_data->password):"";
	//$appointmentId = isset($rqst_data->appointmentId)?($rqst_data->appointmentId):"";
	
    //$invoice_amt = isset($rqst_data->invoice_amt)?($rqst_data->invoice_amt):"";
	$status_array = 1;
	$my_array=array();
	$msg="";
	if($cleanerId!='')
	{
		$sql = "select * from tblcleaners where id = {$cleanerId}";
				$totRows = mysql_num_rows($db->Query($sql));
        if($totRows==0)
		{
			$IsAvailable=0;
			$status_array = 0;
			$msg = get_msg("no_record_found")?get_msg("no_record_found"):'';
		}
		else
		{
			//echo $phone;
			//exit;
		$data = array('firstname'=>$firstname,'lastname'=>$lastname,'phone'=>$phone,"email"=>$email,'password'=>md5($password),'modified_date'=>date('Y-m-d H:i:s'));
		$where ="id = {$cleanerId}";
		$db->Update($data,"tblcleaners",$where);
		$user_obj=array('id'=>(int)$cleanerId,'firstname'=>$firstname,'lastname'=>$lastname,'phone'=>$phone,"email"=>$email,'password'=>$password,'user_type'=>3);
		$msg=get_msg("cleaner_update")?get_msg("cleaner_update"):'success';
		}
	}
	else{
		$status_array = 0;
		$msg="Please Enter Valid Cleaner Id";
	}
	$otherinfo =array('user_obj'=>$user_obj);
//created_date
	$my_array = array_merge($my_array, $otherinfo);
	header('Content-type: application/json; charset=utf-8');
	$final_array = array('result'=>$my_array,"message"=>$msg,'status'=>$status_array);
	echo $json= json_encode($final_array);
}else{
	$final_array = array('result'=>'','status'=>0);
	echo $json= json_encode($final_array);
}
?> 