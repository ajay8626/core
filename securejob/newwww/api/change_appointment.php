<?php 
/*
{
"function": "change_appointment",
"appointmentId":"1",
"invoice_amt":100,
"appointmentStatus":2
}
*/
 
include("../config.php");
if(isset($rqst_data->function)){
    //$cleanerId = isset($rqst_data->cleanerId)?($rqst_data->cleanerId):"";
	$appointmentId = isset($rqst_data->appointmentId)?($rqst_data->appointmentId):"";
	$appointmentStatus = isset($rqst_data->appointmentStatus)?(strtolower($rqst_data->appointmentStatus)):"";
	
	
    $invoice_amt = isset($rqst_data->invoice_amt)?($rqst_data->invoice_amt):"";
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
			
		    $ap_status='';
			$result=mysql_fetch_array($db->Query($sql));
			$customer_id=$result['customer_id'];
			$appointment_date=date("M d Y",strtotime($result['appointment_date']));
			$no_windows=$result['no_windows'];
			$no_doors=$result['no_doors'];
			$no_conservatory=$result['no_conservatory'];
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
		//echo $customer_id;
        //exit;		
        if($customer_id!='')
        {
			
				$sql2=mysql_query("select tbl1.*,tbl2.email,CONCAT(tbl2.firstname,' ',tbl2.lastname) as name from tblusertoken as tbl1 
		INNER JOIN tblcustomers as tbl2 ON tbl1.user_id=tbl2.id
		where tbl1.user_type='1' and tbl2.status=1 and tbl1.user_id=".$customer_id."");
		//echo $customer_id;
		//exit; 
		       $totalrows2=mysql_num_rows($sql2);
		  if($totalrows2 > 0)
		  {
			while($row2=mysql_fetch_array($sql2))
			{
				$device_type2=$row2['device_type'];
				$DeviceToken2=$row2['DeviceToken'];
				$notified_user_id=$row2['user_id'];
				$notified_user_type=$row2['user_type'];
				$email=$row2['email'];
				$cname=$row2['name'];
				//echo $cname;
				//exit;
				//echo $email;
				//exit;
				//echo $DeviceToken2;
				//echo '<br>';
				//echo $device_type2;
				//exit;
				$message="Your latest invoice is ready to pay."; 
				//echo $message;
                //exit;				
				if($device_type2==1)
				{
					//echo "hello123";
					//exit;
					$body=$message;
					
					//$data1=array("user_id"=>$manager_id,"notified_user_id"=>$notified_user_id,"user_id_type"=>2,"notified_user_id_type"=>$notified_user_type,"notification_time"=>date("Y-m-d h:i:s"),"message"=>$body,"notification_type"=>2);
		            //$db->Insert($data1,"tblnotification");
					
					$msg = array(
		             'body' 	=> $body,
		             'title'	=> 'Invoice from Squeegee App',
             	     'icon'	=> 'myicon',
              	     'sound' => 'mySound');
					 firebasepush($msg,$DeviceToken2);
				}
				if($device_type2==2)
				{
					//echo "hello123456";
					//exit;
					//echo $DeviceToken2;
					//exit;
					//echo 
					$body2=$message;
					//echo $DeviceToken2;
					//exit;
					//$data1=array("user_id"=>$manager_id,"notified_user_id"=>$notified_user_id,"user_id_type"=>2,"notified_user_id_type"=>$notified_user_type,"notification_time"=>date("Y-m-d h:i:s"),"message"=>$body2,"notification_type"=>2);
		            //$db->Insert($data1,"tblnotification");
					
					$body = array();
								$body['aps'] = array('alert' => $body2, 'sound' => 'default', 'badge' => 0, 'content-available' => 1);
					iPhonePush($DeviceToken2,$body);	
                   // echo "456";
                    //exit;					
				}
			}
			//echo "hello123";
			//exit;
			/*
			$message="<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>
<title>Mail</title>
</head>

<body style='margin:0; padding:0;'>

<table style='margin:0 auto; width:570px; border:2px solid #068fb2; ' border='0' cellpadding='0' cellspacing='0'>
 <thead>
  <tr>
   <th style='text-align:center; background:#fff; border-bottom:2px solid #068fb2; padding:22px 0 20px;'><img src='http://windowcleaner.mgtdemo.co.uk/api/clnr-logo.png' alt='' style='width: 150px;' /></th>
  </tr>
 </thead>
 <tbody>
  <tr>
   <td style=' font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#1e1e1e; font-size:16px; text-align:center; text-transform:uppercase; padding:32px 30px 0;'>Hello $cname,</td>
  </tr>
  <tr>
   <td style='font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#868686; font-size:16px; padding:32px 30px 0;line-height:21px;text-align:center;'>your invoice has been generated please pay for this invoice ".$appointmentId.".</td>
  </tr>
  <tr>
   <td style='font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#1e1e1e; font-size:14px; text-align:center; text-transform:uppercase; padding:32px 30px 0;'>Your Invoice Amount is &pound;".$invoice_amt." </td>
  </tr>
  <tr>
   <td style='font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#1e1e1e; font-size:14px; text-align:center; text-transform:uppercase; padding:32px 30px 0;'>Please Login in the app and pay invoice</td>
  </tr>
  <tr>
  	<td style='font-weight:bold;font-family:Arial, Helvetica, sans-serif; color:#1e1e1e; font-size:14px; text-align:center; text-transform:uppercase; padding:32px 30px 0;'>
							<a style='color:#068FB2' target='_blank'>Thank you,<br/><br/>
							SQUEEGEE APP Support Team<br/></a>
							 </td> 
  </tr>
  <tr>
  <td height='20'></td>
  </tr>
 </tbody>
</table>

</body>
</html>"; */
$window_invoice='';
$door_invoice='';
$conservatory_invoice='';
if($no_windows!=0)
{
	$window_invoice="<tr>
					<td style='font-weight: normal;padding: 10px 5px;border-top: 1px solid #dbdbdb; border-bottom: 1px solid #dbdbdb;font-size: 14px; color: #333;'>Windows</td>
					<td style='font-weight: normal; text-align: right;padding: 5px;border-top: 1px solid #dbdbdb;border-bottom: 1px solid #dbdbdb; font-size: 14px; color: #333;'>".$no_windows."</td>
				</tr>";
}
if($no_doors!=0)
{
	$door_invoice="<tr>
					<td style='font-weight: normal;padding: 10px 5px;border-top: 1px solid #dbdbdb; border-bottom: 1px solid #dbdbdb;font-size: 14px; color: #333;'>Doors</td>
					<td style='font-weight: normal; text-align: right;padding: 5px;border-top: 1px solid #dbdbdb;border-bottom: 1px solid #dbdbdb; font-size: 14px; color: #333;'>".$no_doors."</td>
				</tr>";
}
if($no_conservatory!=0)
{
	$conservatory_invoice="<tr>
					<td style='font-weight: normal;padding: 10px 5px;border-top: 1px solid #dbdbdb; border-bottom: 1px solid #dbdbdb;font-size: 14px; color: #333;'>Conservatory</td>
					<td style='font-weight: normal; text-align: right;padding: 5px;border-top: 1px solid #dbdbdb;border-bottom: 1px solid #dbdbdb; font-size: 14px; color: #333;'>".$no_conservatory."</td>
				</tr>";
}
$total=$no_windows + $no_doors + $no_conservatory;
$message="<!doctype html>
<html>
<head>
<meta charset='utf-8'>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<title>Invoice</title>
</head>

<body>

<table border='0' cellpadding='0' cellspacing='0' align='center' style='margin: 0 auto; border: 1px solid #eeeeee;background: #fff; font-family: arial; width:600px;'>
	<tr>
		<td style='padding: 15px; text-align: center;background: #eee;'><img style='max-width: 110px;' src='".SITE_URL."api/logonew1.png' alt='' /></td>
	</tr>
	
  
	<tr>
		<td style='font-size: 30px; padding: 30px 30px 15px; text-align: center;color: #000; font-weight: normal;'>&pound;$invoice_amt </td>
	</tr>
	<tr>
		<td style='font-size:20px; padding: 15px 30px 30px; text-align: center;color: #000; font-weight: normal;'>Thanks for using Window cleaner.</td>
	</tr>
	<tr>
		<td style='padding: 15px;'>
			<table border='0' cellpadding='0' cellspacing='0' style='width: 100%;'>
				<tr>
					<td style='font-weight:normal;padding: 5px;font-size: 14px; color: #333;'> $cname</td>
					<td></td>
				</tr>
				<tr>
					<td style='font-weight: normal; padding: 5px;font-size: 14px; color: #333;'>Invoice ".$appointmentId."</td>
					<td></td>
				</tr>
				<tr>
					<td style='font-weight: normal;padding: 5px 5px 10px; font-size: 14px; color: #333;'>".$appointment_date."</td>
					<td></td>
				</tr>
				".$window_invoice."
				".$door_invoice."
				".$conservatory_invoice."
				
				<tr>
					<td style='font-weight: bold;padding:10px 5px; border-bottom: 2px solid #000;font-size: 14px; color: #333;'>Total</td>
					<td style='font-weight: bold;text-align: right;padding:10px 5px;border-bottom: 2px solid #000; font-size: 14px; color: #333;'>".$total."</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style='font-size:16px; padding: 50px 30px 60px; text-align: center;color: #333; font-weight: normal;'> Window Cleaner Inc. 123 Van Ness, San Francisco 94102 </td>
	</tr>
</table>

</body>
</html>
";
//echo $message;
//exit;	
	$emailto = $email;
			$subject = "Window Cleaner Invoice";
			//echo $emailto;
			//exit;
			$chk = sendMsg($emailto, $subject, $message);
			
		   }
		   
		   
		}				
			
		$data = array('invoice_amt'=>$invoice_amt,'appointment_status'=>$appointmentStatus,'modified_date'=>date('Y-m-d H:i:s'));
		$where ="id = {$appointmentId}";
		$db->Update($data,"tblappointments",$where);
		$my_array=array("invoice_amt"=>$invoice_amt,"appointment_status"=>$ap_status);
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