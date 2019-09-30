<?php 
/*
{
"function": "add_appointment",
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
	if($customerId!='')
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
		
		
		$data = array('customer_id'=>$customerId,'appointment_date'=>date("Y-m-d h:i:s",strtotime($appoinment_date)),'time_slot'=>$time_id,'no_windows'=>$no_windows,'no_doors'=>$no_doors,'no_conservatory'=>$no_conservatory,'invoice_amt'=>$invoice_amt,'appointment_status'=>1,'created_date'=>date('Y-m-d H:i:s'),"total_leads"=>1,"postcode_id"=>$postcodeId,"timeslot"=>$timeslot,"postcode"=>$p_postcode,"customer_name"=>$customer_name,"comments"=>$comment);
		$db->Insert($data,"tblappointments");
		$last_id = mysql_insert_id();
		//echo "123";
		//exit;
         //$data1=array("customer_id"=>$customerId,"appointment_id"=>$last_id,"loyaltycount"=>1);
		//$db->Insert($data1,"tblloyaltypoints");
		
		$loyaltycount=mysql_query("select loyaltycount from tblloyaltypoints where customer_id=$customerId and IsRead=0");
		$totalloyaltypoints=mysql_num_rows($loyaltycount);
		if($totalloyaltypoints >11)
		{
			//echo "123";
			//exit;
			$data = array('IsRead'=>1);
		   $where ="customer_id = {$customerId}";
		   $db->Update($data,"tblloyaltypoints",$where);
		}
		$loyaltycount1=mysql_query("select loyaltycount from tblloyaltypoints where customer_id=$customerId and IsRead=0");
		$totalloyaltypoints1=mysql_num_rows($loyaltycount1);
		
		$sql=mysql_query("select tbl1.* from tblusertoken as tbl1 
		INNER JOIN tblmanager as tbl2 ON tbl1.user_id=tbl2.id
		where tbl1.user_type='2' and tbl2.status=1");
		$totalrows=mysql_num_rows($sql);
		if($totalrows > 0)
		{
			while($row=mysql_fetch_array($sql))
			{
				$device_type=$row['device_type'];
				$DeviceToken=$row['DeviceToken'];
				$notified_user_id=$row['user_id'];
				$notified_user_type=$row['user_type'];
				$app_date=date("d-m-Y",strtotime($appoinment_date));
				
				
				
				if($device_type==1)
				{
					$body=$customer_name." has booked an appointment for ".$app_date;
					
					$data1=array("user_id"=>$customerId,"notified_user_id"=>$notified_user_id,"user_id_type"=>1,"notified_user_id_type"=>$notified_user_type,"notification_time"=>date("Y-m-d h:i:s"),"message"=>$body,"notification_type"=>1);
		            $db->Insert($data1,"tblnotification");
					
					
					$msg = array(
		             'body' 	=> $body,
		             'title'	=> 'Booked Appointment from Squeegee App',
             	     'icon'	=> 'myicon',
              	     'sound' => 'mySound');
					 firebasepush($msg,$DeviceToken);
				}
				//echo $device_type;
				//exit;
				if($device_type==2)
				{
					$body2=$customer_name." booked an appointment for ".$app_date;
					
					$data1=array("user_id"=>$customerId,"notified_user_id"=>$notified_user_id,"user_id_type"=>1,"notified_user_id_type"=>$notified_user_type,"notification_time"=>date("Y-m-d h:i:s"),"message"=>$body2,"notification_type"=>1);
		            $db->Insert($data1,"tblnotification");
					
					
					$body = array();
								$body['aps'] = array('alert' => $body2, 'sound' => 'default', 'badge' => 0, 'content-available' => 1);
					iPhonePush($DeviceToken,$body);			
				}
			}
		}
		$my_array=array("loyaltypoints"=>(int)$totalloyaltypoints1);
		
		$msg=get_msg("appointment_insert")?get_msg("appointment_insert"):'success';
	}
	else{
		$status_array = 0;
		$msg="Please Enter Valid Customer Id";
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