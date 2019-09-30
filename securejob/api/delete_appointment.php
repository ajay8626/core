<?php 
/*
{
"function": "delete_appointment",
"appointmentId":"1",
"customerId":"7"
}
*/

include("../config.php");
if(isset($rqst_data->function)){
    $customerId = isset($rqst_data->customerId)?($rqst_data->customerId):"";
	$appointmentId = isset($rqst_data->appointmentId)?($rqst_data->appointmentId):"";
	
    "";
	//$invoice_amt = isset($rqst_data->invoice_amt)?($rqst_data->invoice_amt):"";
	$status_array = 1;
	$my_array=array();
	$msg="";
	if($appointmentId!='' && $customerId!='')
	{
		$sql = "select * from tblappointments where id = {$appointmentId} and customer_id={$customerId}";
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
			$app_dates=date("d-m-Y",strtotime($appointment_date));
			
			 $cancel=mysql_query("select title_value from tblsystemconfiguration where title_key='appointment_cancel_time'");
			$cancelfetch=mysql_fetch_array($cancel);
			$canceltime=$cancelfetch['title_value'];
			
			
			$beforedate=date('Y-m-d h:i:s',strtotime('+ '.$canceltime));
			$sql="select appointment_date from tblappointments where id = {$appointmentId} and customer_id={$customerId}";
			$records=mysql_query($sql);
			$fetchrecord=mysql_fetch_array($records);
			$app_date=$fetchrecord['appointment_date'];
			$current_date=date("Y-m-d h:i:s");
			//echo $app_date;
			//echo "<br>";
			//echo date("Y-m-d h:i:s");
			//echo "<br>";
			//echo $beforedate;
			//$datetime1 = new DateTime($beforedate);

            //$datetime2 = new DateTime($app_date);
			 $hourdiff = round((strtotime($app_date) - strtotime($current_date))/3600, 1);
			//exit;
			//exit;
			if($hourdiff <= 24)
			{
				$status_array = 0;
		        $msg="You cannot cancel this booking. Please call us on: 01604 779065";
			}
			else
			{
				//echo "1234";
				//exit;
		     $sql1="delete from tblappointments where id = {$appointmentId} and customer_id={$customerId}";
			 $res=mysql_query($sql1);
			 
			 $sql2="delete from tblloyaltypoints where appointment_id = {$appointmentId} and customer_id={$customerId}";
			 $res=mysql_query($sql2);
			 
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
				if($device_type==1)
				{
					$body=$customer_name." has deleted appointment on ".$app_dates;
					
					$data1=array("user_id"=>$customerId,"notified_user_id"=>$notified_user_id,"user_id_type"=>1,"notified_user_id_type"=>$notified_user_type,"notification_time"=>date("Y-m-d h:i:s"),"message"=>$body,"notification_type"=>1);
		            $db->Insert($data1,"tblnotification");
					
					$msg = array(
		             'body' 	=> $body,
		             'title'	=> 'Delete Appointment from Squeegee App',
             	     'icon'	=> 'myicon',
              	     'sound' => 'mySound');
					 firebasepush($msg,$DeviceToken);
				}
				if($device_type==2)
				{
					$body2=$customer_name." has deleted appointment on ".$app_dates;
					
					$data1=array("user_id"=>$customerId,"notified_user_id"=>$notified_user_id,"user_id_type"=>1,"notified_user_id_type"=>$notified_user_type,"notification_time"=>date("Y-m-d h:i:s"),"message"=>$body2,"notification_type"=>1);
		            $db->Insert($data1,"tblnotification");
					
					$body = array();
								$body['aps'] = array('alert' => $body2, 'sound' => 'default', 'badge' => 0, 'content-available' => 1);
					iPhonePush($DeviceToken,$body);			
				}
			}
		}
		
		if($cleaner_id!='')
		{
			 $sql1=mysql_query("select tbl1.* from tblusertoken as tbl1 
		INNER JOIN tblcleaners as tbl2 ON tbl1.user_id=tbl2.id
		where tbl1.user_type='3' and tbl2.status=1 and tbl1.user_id=".$cleaner_id."");
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
					$body=$customer_name." has a deleted appointment on ".$app_dates;
					
					$data1=array("user_id"=>$customerId,"notified_user_id"=>$notified_user_id,"user_id_type"=>1,"notified_user_id_type"=>$notified_user_type,"notification_time"=>date("Y-m-d h:i:s"),"message"=>$body,"notification_type"=>3);
		            $db->Insert($data1,"tblnotification");
					
					$msg = array(
		             'body' 	=> $body,
		             'title'	=> 'Delete Appointment from Squeegee App',
             	     'icon'	=> 'myicon',
              	     'sound' => 'mySound');
					 firebasepush($msg,$DeviceToken1);
				}
				if($device_type1==2)
				{
					$body2=$customer_name." has deleted appointment on ".$app_dates;
					$data1=array("user_id"=>$customerId,"notified_user_id"=>$notified_user_id,"user_id_type"=>1,"notified_user_id_type"=>$notified_user_type,"notification_time"=>date("Y-m-d h:i:s"),"message"=>$body2,"notification_type"=>3);
		            $db->Insert($data1,"tblnotification");
					$body = array();
								$body['aps'] = array('alert' => $body2, 'sound' => 'default', 'badge' => 0, 'content-available' => 1);
					iPhonePush($DeviceToken1,$body);			
				}
			}
		  }
		
		}
			 
			 
		//$last_id = mysql_insert_id();
		//echo "123";
		//exit;
         //$data1=array("customer_id"=>$customerId,"appointment_id"=>$last_id,"loyaltycount"=>1);
		//$db->Insert($data1,"tblloyaltypoints");
		
		$loyaltycount=mysql_query("select loyaltycount from tblloyaltypoints where customer_id=$customerId and IsRead=0");
		$totalloyaltypoints=mysql_num_rows($loyaltycount);
		
		$my_array=array("loyaltypoints"=>(int)$totalloyaltypoints);
		
		$msg=get_msg("appointment_delete")?get_msg("appointment_delete"):'success';
			}
		//echo $msg;
		//exit;
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