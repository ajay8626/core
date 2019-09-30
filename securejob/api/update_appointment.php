<?php 
/*
{
"function": "update_appointment",
"appointmentId":"1",
"customerId":1,
"appoinment_date":"2017-09-11 00:00:00",
"time_id":1,
"no_windows":2,
"no_doors":2,
"postcodeId":14,
"no_conservatory":4,
"comment":"THIS IS TESTING"
}
*/

include("../config.php");
if(isset($rqst_data->function)){
    $customerId = isset($rqst_data->customerId)?($rqst_data->customerId):"";
	$appointmentId = isset($rqst_data->appointmentId)?($rqst_data->appointmentId):"";
	
    $appoinment_date = isset($rqst_data->appoinment_date)?($rqst_data->appoinment_date):"";
    $time_id = isset($rqst_data->time_id)?($rqst_data->time_id):"";
	$no_windows = isset($rqst_data->no_windows)?($rqst_data->no_windows):"";
	$no_doors = isset($rqst_data->no_doors)?($rqst_data->no_doors):"";
	$no_conservatory = isset($rqst_data->no_conservatory)?($rqst_data->no_conservatory):"";
	$postcodeId = 	isset($rqst_data->postcodeId)?stripslashes($rqst_data->postcodeId):"";
	$comment = 	isset($rqst_data->comment)?stripslashes($rqst_data->comment):"";
	//$invoice_amt = isset($rqst_data->invoice_amt)?($rqst_data->invoice_amt):"";
	$status_array = 1;
	$my_array=array();
	$msg="";
	if($appointmentId!='')
	{
		$sql = "select * from tblappointments where id = {$appointmentId}";
				$totRows = mysql_num_rows($db->Query($sql));
        if($totRows==0)
		{
			$IsAvailable=0;
			$status_array = 0;
			$msg = get_msg("no_record_found")?get_msg("no_record_found"):'';
		}
		else
		{
			
		$timeslot='';
		if($time_id!='')
		{
		    $time="select from_hours,from_min,to_hours,to_min,time_type from tbltimeslot where id=".$time_id."";
			$tres=$db->Query($time);
	        $timerows=mysql_num_rows($tres);
			
			if($timerows > 0)
			{
				$resultrs=mysql_fetch_assoc($tres);
				$from_hours=$resultrs['from_hours'];
				$from_min=$resultrs['from_min'];
				$to_hours=$resultrs['to_hours'];
				$to_min=$resultrs['to_min'];
				$time_type=$resultrs['time_type'];
				$fromsign='AM';
				if($from_hours > 12)
				{
					$fromsign='PM';
				}
				$tosign='AM';
				if($to_hours > 12)
				{
					$tosign='PM';
				}
				$timeslot=$time_type; 
			}
		}
		$p_postcode='';
		if($postcodeId!='')
		{	  
			$postcode="select id,postcode from tblpostcode where id=".$postcodeId."";
			
			$pres=$db->Query($postcode);
			$postcoderows=mysql_num_rows($pres);
			$postcodelot='';
			
			if($postcoderows > 0)
			{
				$resulprs=mysql_fetch_assoc($pres);
				$p_id=$resulprs['id'];
				$p_postcode=$resulprs['postcode'];
			}
		}
		$customer_name='';
		if($customerId!='')
		{
			$sqladdress="select CONCAT(firstname,' ',lastname) as name from tblcustomers where id=".$customerId."";
			$ares=$db->Query($sqladdress);
			$addrows=mysql_num_rows($ares);
			if($addrows > 0)
			{
				$resulars=mysql_fetch_assoc($ares);
				$customer_name=rtrim($resulars['name']);
			}
		}
			
			
		$data = array('customer_id'=>$customerId,'appointment_date'=>date("Y-m-d h:i:s",strtotime($appoinment_date)),'time_slot'=>$time_id,'no_windows'=>$no_windows,'no_doors'=>$no_doors,'no_conservatory'=>$no_conservatory,'appointment_status'=>1,'modified_date'=>date('Y-m-d H:i:s'),"total_leads"=>1,"postcode_id"=>$postcodeId,"timeslot"=>$timeslot,"postcode"=>$p_postcode,"customer_name"=>$customer_name,"comments"=>$comment);
		$where ="id = {$appointmentId}";
		$db->Update($data,"tblappointments",$where);
		//$last_id = mysql_insert_id();
		//echo "123";
		//exit;
         //$data1=array("customer_id"=>$customerId,"appointment_id"=>$last_id,"loyaltycount"=>1);
		//$db->Insert($data1,"tblloyaltypoints");
		
		$loyaltycount=mysql_query("select loyaltycount from tblloyaltypoints where customer_id=$customerId and IsRead=0");
		$totalloyaltypoints=mysql_num_rows($loyaltycount);
		
		$my_array=array("loyaltypoints"=>(int)$totalloyaltypoints);
		
		$msg=get_msg("appointment_update")?get_msg("appointment_update"):'success';
		}
	}
	else{
		$status_array = 0;
		$msg="Please Enter Valid Appointment Id";
	}
	
//created_date
	//$my_array = array_merge($my_array, $otherinfo);
	header('Content-type: application/json; charset=utf-8');
	$final_array = array('result'=>$my_array,"message"=>$msg,'status'=>$status_array);
	echo $json= json_encode($final_array);
}else{
	$final_array = array('result'=>'','status'=>0);
	echo $json= json_encode($final_array);
}
?> 