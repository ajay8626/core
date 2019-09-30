<?php
include "config.php";
$from_availability=isset($_POST['from_availability'])?$_POST['from_availability']:'';
$to_availability=isset($_POST['to_availability'])?$_POST['to_availability']:'';
$start_day_availability=isset($_POST['start_day_availability'])?$_POST['start_day_availability']:'';
$end_day_availability=isset($_POST['end_day_availability'])?$_POST['end_day_availability']:'';
$user_id=$_SESSION['user_id'];

if($user_id!='')
{
	$selectdata=mysql_query("select id from tbluser_availability where user_id=".$user_id."");
	$countrows=mysql_num_rows($selectdata);
	
	if($countrows > 0)
	{
		$getId=mysql_fetch_array($selectdata);
		$AvailabilityId=$getId['id'];
		$update=mysql_query("Update tbluser_availability SET from_time='".$from_availability."', to_time='".$to_availability."', from_day='".$start_day_availability."', to_day='".$end_day_availability."' where user_id=".$user_id."");
		if($update)
		{
			echo 1;
			exit();
		}
		else
		{
			echo 2;
			exit();
		}
	}
	else
	{
		
		$insert=mysql_query("Insert tbluser_availability SET from_time='".$from_availability."', to_time='".$to_availability."', from_day='".$start_day_availability."', to_day='".$end_day_availability."', user_id=".$user_id."");
		
		if($insert)
		{
			echo 1;
			exit();
		}
		else
		{
			echo 2;
			exit();
		}
	}
}
else
{
	echo 2;
	exit();
}
?>