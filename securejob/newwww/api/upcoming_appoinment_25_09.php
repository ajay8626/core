<?php
/*
{
"function": "upcoming_appoinment",
"customerId":"23",
"lastDate":"0",
"count":"10"
}
*/
include("../config.php");
if(isset($rqst_data->function)){
$customerId = isset($rqst_data->customerId)?($rqst_data->customerId):"";
$pageLimit = isset($rqst_data->count)?(int)($rqst_data->count):10;
$lastDate = isset($rqst_data->lastDate)?($rqst_data->lastDate):'';
     $LastRecords='';
    if($lastDate)
	{
		$LastRecords=" and appointment_date < '".date("Y-m-d h:i:s",strtotime($lastDate))."'";
	}

//$postcode = isset($rqst_data->postcode)?stripslashes($rqst_data->postcode):"";
	$sql="SELECT * FROM `tblappointments` where customer_id=".$customerId." and appointment_date > '".date("Y-m-d h:i:s")."' and appointment_status IN ('confirmed','pending')     $LastRecords order by appointment_date DESC LIMIT 0, $pageLimit";
	//echo $sql;
	//exit;
	$res=$db->Query($sql);
	$rows=mysql_num_rows($res);
	$my_array=array();
	if($rows > 0)
	{
		while($result=mysql_fetch_assoc($res))
		{
			$time_slot=$result['time_slot'];
			
			$time="select from_hours,from_min,to_hours,to_min from tbltimeslot where id=".$time_slot."";
			$tres=$db->Query($time);
	        $timerows=mysql_num_rows($tres);
			$timeslot='';
			if($timerows > 0)
			{
				$resultrs=mysql_fetch_assoc($tres);
				$from_hours=$resultrs['from_hours'];
				$from_min=$resultrs['from_min'];
				$to_hours=$resultrs['to_hours'];
				$to_min=$resultrs['to_min'];
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
				$timeslot=$from_hours.":".$from_min.$fromsign. " - " .$to_hours.":".$to_min.$tosign; 
			}
			$appointment_status=$result['appointment_status'];
			
			$my_array['appointmentList'][]=array("id"=>(int)$result['id'],"customer_id"=>(int)$result['customer_id'],
			"appointment_date"=>$result['appointment_date'],"time_slot"=>$timeslot,
			"no_windows"=>(int)$result['no_windows'],"no_doors"=>(int)$result['no_doors'],
			"no_conservatory"=>(int)$result['no_conservatory'],"appointment_status"=>
			$appointment_status);
			$status_array=1;
			$msg=get_msg("upcoming_appointment")?get_msg("upcoming_appointment"):'success';
			
		}
		
	}
	else
	{
		$status_array=0;
		$msg=get_msg("no_record_found")?get_msg("no_record_found"):'no_record_found';
	
	}
       header('Content-type: application/json; charset=utf-8');
	$final_array = array('result'=>$my_array,"message"=>$msg,'status'=>$status_array);
	echo $json= json_encode($final_array);
}
else{
	$final_array = array('result'=>'','status'=>0);
	echo $json= json_encode($final_array);
}
?>