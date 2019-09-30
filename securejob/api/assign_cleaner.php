<?php 
/*
{
"function": "assign_cleaner",
"appointmentId":"1",
"cleanerId":1,
"appointmentStatus":2,
"manager_id" :1
}
*/
 
include("../config.php");
if(isset($rqst_data->function)){
    $cleanerId = isset($rqst_data->cleanerId)?($rqst_data->cleanerId):"";
	$manager_id = isset($rqst_data->manager_id)?($rqst_data->manager_id):"";
	$appointmentId = isset($rqst_data->appointmentId)?($rqst_data->appointmentId):"";
	$appointmentStatus = isset($rqst_data->appointmentStatus)?($rqst_data->appointmentStatus):"";
	
	
    //$invoice_amt = isset($rqst_data->invoice_amt)?($rqst_data->invoice_amt):"";
	$status_array = 1;
	$my_array=array();
	$msg="";
	if($appointmentId!='')
	{
		$sql = "select * from tblappointments where id = {$appointmentId}";
				//$totRows = mysql_num_rows($db->Query($sql));
        $exc=$db->Query($sql);
		$totRows = mysql_num_rows($exc);
		if($totRows==0)
		{
			$IsAvailable=0;
			$status_array = 0;
			$msg = get_msg("no_record_found")?get_msg("no_record_found"):'';
		}
		else
		{
			$result=mysql_fetch_array($exc);
			$appointment_date=$result['appointment_date'];
			$customer_name=$result['customer_name'];
			$cleaner_id=$result['cleaner_id'];
			$customer_id=$result['customer_id'];
			$app_date=date("d-m-Y",strtotime($appointment_date));
		    $ap_status='';
			//echo $customer_id;
			//exit;
			if($appointmentStatus!='')
			{
				$sel="select title from appointment_status where id=".$appointmentStatus."";
				$asres=$db->Query($sel);
				$asddrows=mysql_num_rows($asres);
				if($asddrows > 0)
				{
					$resulasr=mysql_fetch_assoc($asres);
					$ap_status=rtrim($resulasr['title']);
				}
			}
		$cleaner_name='';	
        if($cleanerId!='')
        {
			$sql = "select CONCAT(firstname,' ',lastname) as name from tblcleaners where id = {$cleanerId}";
			//echo $sql;
            //exit;			
			$cleanr=$db->Query($sql);
				$totRows = mysql_num_rows($cleanr);
            if($totRows > 0)
		    {
				$result=mysql_fetch_assoc($cleanr);
					$cleaner_name=$result['name'];
			}
		} 
        $manager_name='';
		if($manager_id!='')
        {
			$sql = "select CONCAT(firstname,' ',lastname) as name from tblmanager where id = {$manager_id}";
			//echo $sql;
            //exit;			
			$cleanr=$db->Query($sql);
				$totRows = mysql_num_rows($cleanr);
            if($totRows > 0)
		    {
				$result=mysql_fetch_assoc($cleanr);
					$manager_name=$result['name'];
			}
		} 
		
		if($cleanerId!='')
		{
			 $sql1=mysql_query("select tbl1.* from tblusertoken as tbl1 
		INNER JOIN tblcleaners as tbl2 ON tbl1.user_id=tbl2.id
		where tbl1.user_type='3' and tbl2.status=1 and tbl1.user_id=".$cleanerId."");
		$totalrows1=mysql_num_rows($sql1);
		   if($totalrows1 > 0)
		   {
			while($row1=mysql_fetch_array($sql1))
			{
				$device_type1=$row1['device_type'];
				$DeviceToken1=$row1['DeviceToken'];
				$notified_user_id=$row1['user_id'];
				$notified_user_type=$row1['user_type'];
				if($device_type1==1)
				{
					//$body="manager has been assigned appointment of ".$customer_name." and appointment at ".$appoinment_date;
					$body=$manager_name." has requested of ".$customer_name." for appointment at ".$app_date." for cleaning";
					
					$data1=array("user_id"=>$manager_id,"notified_user_id"=>$notified_user_id,"user_id_type"=>2,"notified_user_id_type"=>$notified_user_type,"notification_time"=>date("Y-m-d h:i:s"),"message"=>$body,"notification_type"=>2);
		            $db->Insert($data1,"tblnotification");
					
					
					$msg = array(
		             'body' 	=> $body,
		             'title'	=> 'Assigned Appointment from Squeegee App',
             	     'icon'	=> 'myicon',
              	     'sound' => 'mySound');
					 firebasepush($msg,$DeviceToken1);
				}
				//echo $device_type1;
				//exit;
				//echo $DeviceToken1;
				//exit;
				if($device_type1==2)
				{
					//echo "123";
					//exit;
					$body2=$manager_name." has requested of ".$customer_name." for appointment at ".$app_date." for cleaning";
					$data1=array("user_id"=>$manager_id,"notified_user_id"=>$notified_user_id,"user_id_type"=>2,"notified_user_id_type"=>$notified_user_type,"notification_time"=>date("Y-m-d h:i:s"),"message"=>$body2,"notification_type"=>2);
		            $db->Insert($data1,"tblnotification");
					$body = array();
								$body['aps'] = array('alert' => $body2, 'sound' => 'default', 'badge' => 0, 'content-available' => 1);
					iPhonePush($DeviceToken1,$body);			
				}
			}
		  }
		
		}
		if($customer_id!='')
		{
			
			$sql2=mysql_query("select tbl1.* from tblusertoken as tbl1 
		INNER JOIN tblcustomers as tbl2 ON tbl1.user_id=tbl2.id
		where tbl1.user_type='1' and tbl2.status=1 and tbl1.user_id=".$customer_id."");
		
		$totalrows2=mysql_num_rows($sql2);
		   if($totalrows2 > 0)
		   {
			while($row2=mysql_fetch_array($sql2))
			{
				$device_type2=$row2['device_type'];
				$DeviceToken2=$row2['DeviceToken'];
				$notified_user_id=$row2['user_id'];
				$notified_user_type=$row2['user_type'];
				//echo $device_type2;
				//exit;
				if($device_type2==1)
				{
					$body=$cleaner_name." has been assigned for you appointment on ".$app_date;
					
					$data1=array("user_id"=>$manager_id,"notified_user_id"=>$notified_user_id,"user_id_type"=>2,"notified_user_id_type"=>$notified_user_type,"notification_time"=>date("Y-m-d h:i:s"),"message"=>$body,"notification_type"=>2);
		            $db->Insert($data1,"tblnotification");
					
					$msg = array(
		             'body' 	=> $body,
		             'title'	=> 'Assigned Appointment from Squeegee App',
             	     'icon'	=> 'myicon',
              	     'sound' => 'mySound');
					 firebasepush($msg,$DeviceToken2);
				}
				if($device_type2==2)
				{
					$body2=$cleaner_name." has been assigned for you appointment on ".$app_date;
					
					$data1=array("user_id"=>$manager_id,"notified_user_id"=>$notified_user_id,"user_id_type"=>2,"notified_user_id_type"=>$notified_user_type,"notification_time"=>date("Y-m-d h:i:s"),"message"=>$body2,"notification_type"=>2);
		            $db->Insert($data1,"tblnotification");
					
					$body = array();
								$body['aps'] = array('alert' => $body2, 'sound' => 'default', 'badge' => 0, 'content-available' => 1);
					iPhonePush($DeviceToken2,$body);			
				}
			}
		  }
			
		}
		
        		
		//echo $cleaner_name;
        // exit;		
		$data = array('cleaner_id'=>$cleanerId,'appointment_status'=>$appointmentStatus,'modified_date'=>date('Y-m-d H:i:s'),'cleaner_name'=>$cleaner_name,'manager_id'=>$manager_id,'manager_name'=>$manager_name,'assigned_date'=>date('Y-m-d H:i:s'));
		$where ="id = {$appointmentId}";
		$db->Update($data,"tblappointments",$where);
		$my_array=array("cleaner_id"=>(int)$cleanerId,"appointment_status"=>$ap_status,"cleaner_name"=>$cleaner_name,'manager_name'=>$manager_name);
		$msg=get_msg("appointment_assign")?get_msg("appointment_assign"):'success';
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