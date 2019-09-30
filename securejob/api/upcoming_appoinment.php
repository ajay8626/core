<?php
/*
{
"function": "upcoming_appoinment",
"customerId":"23",
"lastDate":"0",
"userRole":"1",
"Iscompleted":"1",
"count":"10"
}

old structure 

{
"function": "upcoming_appoinment",
"customerId":"23",
"lastDate":"2017-09-30 12:26:40",
"Ismanager":"2",
"count":"100"
}

Ismanager=0 for customer login
for manager
Ismanager=1 for complete
Ismanager=2 for in-complete,pending,confirmed

cleanerId for cleaner assign appointments will come
Iscompleted=1 for completed appointments
Iscompleted=0 for pending,confirmed etc appointments

userRole 
userRole=1 for customer
userRole=2 for manager
userRole=3 for cleaner
*/  
include("../config.php");
if(isset($rqst_data->function)){
$customerId = isset($rqst_data->customerId)?($rqst_data->customerId):"";
$pageLimit = isset($rqst_data->count)?(int)($rqst_data->count):10;
$lastDate = isset($rqst_data->lastDate)?($rqst_data->lastDate):'';
$userRole = isset($rqst_data->userRole)?($rqst_data->userRole):1;
//$Ismanager = isset($rqst_data->Ismanager)?($rqst_data->Ismanager):0;
//$cleanerId = isset($rqst_data->cleanerId)?($rqst_data->cleanerId):'';
$Iscompleted = isset($rqst_data->Iscompleted)?($rqst_data->Iscompleted):0;

    

//$postcode = isset($rqst_data->postcode)?stripslashes($rqst_data->postcode):"";
	/*
	if($Ismanager==1)
	{
	$sql="SELECT * FROM `tblappointments` where  appointment_status=5  $LastRecords order by appointment_date DESC LIMIT 0, $pageLimit";
	} else if($Ismanager==2){
		$sql="SELECT * FROM `tblappointments` where appointment_date > '".date("Y-m-d h:i:s")."' and appointment_status IN (1,2,3,4)   $LastRecords order by appointment_date DESC LIMIT 0, $pageLimit";
	}else {
		$sql="SELECT * FROM `tblappointments` where customer_id=".$customerId." and appointment_date > '".date("Y-m-d h:i:s")."' and appointment_status IN (1,2)   $LastRecords order by appointment_date DESC LIMIT 0, $pageLimit";
	}
	*/
	
	/*
	if($cleanerId!='' && $cleanerId!=0)
	{
		if($Iscompleted==1)
		{
			$sql="SELECT * FROM `tblappointments` where cleaner_id=".$cleanerId." AND appointment_status=5  $LastRecords order by appointment_date DESC LIMIT 0, $pageLimit";
		}
		else
		{
			$sql="SELECT * FROM `tblappointments` where cleaner_id=".$cleanerId." and appointment_date > '".date("Y-m-d h:i:s")."' and appointment_status IN (1,2,3,4)   $LastRecords order by appointment_date DESC LIMIT 0, $pageLimit";
		}
		
	}
	*/
	$LastRecords='';
    if($lastDate)
	{
		$LastRecords=" and appointment_date > '".date("Y-m-d h:i:s",strtotime($lastDate))."'";
	}
	if($userRole==1)
	{
		$sql="SELECT * FROM `tblappointments` where customer_id=".$customerId." and appointment_date >= '".date("Y-m-d h:i:s")."' and appointment_status IN (1,2)   $LastRecords order by appointment_date ASC LIMIT 0, $pageLimit";
	}
	if($userRole==2)
	{
		if($Iscompleted==1)
		{
			$sql="SELECT * FROM `tblappointments` where  appointment_status=5  $LastRecords order by appointment_date ASC LIMIT 0, $pageLimit";
		}
		else
		{
			//$sql="SELECT * FROM `tblappointments` where  appointment_status IN (1,2,3,4)   $LastRecords order by appointment_date ASC LIMIT 0, $pageLimit";
			
			$sql="SELECT * FROM `tblappointments` where  appointment_status IN (1,2,3,4) and IF(cleaner_id = 0 , appointment_date > '".date("Y-m-d h:i:s")."',customer_id!=0) $LastRecords  ORDER BY appointment_date ASC LIMIT 0, $pageLimit";
			//echo $sql;
			//exit;
			
		}
	}
	if($userRole==3)
	{
		if($Iscompleted==1)
		{
			$sql="SELECT * FROM `tblappointments` where cleaner_id=".$customerId." AND appointment_status=5  $LastRecords order by appointment_date ASC LIMIT 0, $pageLimit";
		}
		else
		{
			$sql="SELECT * FROM `tblappointments` where cleaner_id=".$customerId." and appointment_date > '".date("Y-m-d h:i:s")."' and appointment_status IN (1,2,3,4)   $LastRecords order by appointment_date ASC LIMIT 0, $pageLimit";
			
		}
	}
	
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
			if($cleaner_name=='')
			{
				$cleaner_name="";
			}
			$comments=$result['comments'];
			if($comments=='')
			{
				$comments="";
			}
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
			}
			*/
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
			$invoice_amt='';
			if($result['customer_id']!='')
			{
				$sql="select invoice_amt from tblappointments where customer_id=".$result['customer_id']." and invoice_amt!=0 and invoice_amt!='' order by id desc";
				$in=$db->Query($sql);
				$inrows=mysql_num_rows($ares);
				if($inrows > 0)
				{
					$resulars=mysql_fetch_assoc($in);
					$invoice_amt=ltrim($resulars['invoice_amt']);
					//$customer_name=ltrim($resulars['name']);
				}
			}
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
			 
			$my_array['appointmentList'][]=array("id"=>(int)$result['id'],"customer_id"=>(int)$result['customer_id'],
			"appointment_date"=>$result['appointment_date'],"time_id"=>(int)$time_slot,"time_slot"=>$timeslot,"postcode_id"=>(int)$postcode_id,"post_code"=>$postcode,
			"no_windows"=>(int)$result['no_windows'],"no_doors"=>(int)$result['no_doors'],
			"no_conservatory"=>(int)$result['no_conservatory'],"appointment_status"=>
			$ap_status,"address"=>$address,"cleaner_name"=>$cleaner_name,"cleaner_id"=>(int)$cleaner_id,"comment"=>$comments,"customer_name"=>$customer_name,"last_invoice"=>(int)$invoice_amt);
			$status_array=1;
			$msg=get_msg("upcoming_appointment")?get_msg("upcoming_appointment"):'success';
			
		}
		$rowtotalloyal=0;
		if($userRole==1)
	    {
		$sqlloyalty="select id from tblloyaltypoints where customer_id=".$customerId."  and IsRead=0";
					 $countres=$db->Query($sqlloyalty);
					 $rowtotalloyal=mysql_num_rows($countres);
		}
		$my_array['loyalityPoints']=(int)$rowtotalloyal;			 
	} 
	else
	{
		$status_array=0;
		if($userRole==1)
	    {
		$msg='No appointments available,please book an appointment';
	    } 
		if($userRole==2)
	    {
		$msg='No appointments available.';
	    }
		if($userRole==3)
	    {
		$msg='No appointment assigned to you.';
	    }
		$my_array['loyalityPoints']=0;
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