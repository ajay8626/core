<?php
/*
{
"function": "appoinment_detail",
"appointmentId":"23"
}

Ismanager=0 for customer login
for manager
Ismanager=1 for complete
Ismanager=2 for in-complete,pending,confirmed
*/ 
include("../config.php");
if(isset($rqst_data->function)){
$appointmentId = isset($rqst_data->appointmentId)?($rqst_data->appointmentId):"";

    

//$postcode = isset($rqst_data->postcode)?stripslashes($rqst_data->postcode):"";
	
	if($appointmentId!='')
	{
    $sql="SELECT * FROM `tblappointments` where id=".$appointmentId."";
	
	
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
				$postcode_id=$result['postcode_id'];
				$timeslot=$result['timeslot'];
				$postcode=$result['postcode'];
				$cleaner_id=$result['cleaner_id'];
				$cleaner_name=$result['cleaner_name'];
				$comments=$result['comments'];
				/*
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
				} */
				$appointment_status=$result['appointment_status'];
			  /*
			  $p_id='';
			  $p_postcode='';
			  if($postcode_id!='')
			  {	  
				$postcode="select id,postcode from tblpostcode where id=".$postcode_id."";
				//echo $postcode;
				//exit;
				$pres=$db->Query($postcode);
				$postcoderows=mysql_num_rows($pres);
				$postcodelot='';
				
				if($postcoderows > 0)
				{
					$resulprs=mysql_fetch_assoc($pres);
					$p_id=$resulprs['id'];
					$p_postcode=$resulprs['postcode'];
				}
			  } */
				
			$ap_status='';
			if($appointment_status!='')
			{
				$sel="select title from appointment_status where id=".$appointment_status."";
				$asres=$db->Query($sel);
				$asddrows=mysql_num_rows($asres);
				if($asddrows > 0)
				{
					$resulasr=mysql_fetch_assoc($asres);
					$ap_status=rtrim($resulasr['title']);
				}
			}
			$address='';
			$customer_name='';
			if($result['customer_id']!='')
			{
				$sqladdress="select CONCAT(address_1,' ',address_2,' ',address_3) as address,CONCAT(firstname,' ',lastname) as name from tblcustomers where id=".$result['customer_id']."";
				$ares=$db->Query($sqladdress);
				$addrows=mysql_num_rows($ares);
				if($addrows > 0)
				{
					$resulars=mysql_fetch_assoc($ares);
					$address=rtrim($resulars['address']);
					$customer_name=ltrim($resulars['name']);
				}
			}
			
			
				
				$my_array['appointmentList'][]=array("id"=>(int)$result['id'],"customer_id"=>(int)$result['customer_id'],
				"appointment_date"=>$result['appointment_date'],"time_id"=>(int)$time_slot,"time_slot"=>$timeslot,"postcode_id"=>(int)$postcode_id,"post_code"=>$postcode,
				"no_windows"=>(int)$result['no_windows'],"no_doors"=>(int)$result['no_doors'],
				"no_conservatory"=>(int)$result['no_conservatory'],"appointment_status"=>
				$ap_status,"cleaner_id"=>(int)$result['cleaner_id'],"cleaner_name"=>$cleaner_name,"comment"=>$comments,"customer_name"=>$customer_name);
				$status_array=1;
				$msg=get_msg("appointment_detail")?get_msg("appointment_detail"):'success';
				
			}
			
		}
		else
		{
			$status_array=0;
			$msg=get_msg("no_record_found")?get_msg("no_record_found"):'no_record_found';
		
		}
	}
	else
	{
		$status_array = 0;
		$msg="Please Enter Valid Appointment Id";
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