<?php
include "config.php";
$from_availability=isset($_POST['from_availability'])?$_POST['from_availability']:'';
$to_availability=isset($_POST['to_availability'])?$_POST['to_availability']:'';
$user_id=$_SESSION['user_id'];

if($user_id!='')
{
	$selectdata=mysql_query("select id from tbluser_availability where user_id=".$user_id."");
	$countrows=mysql_num_rows($selectdata);
	
	if($countrows > 0)
	{
		$getId=mysql_fetch_array($selectdata);
		$AvailabilityId=$getId['id'];
		$update=mysql_query("Update tbluser_availability SET from_time='".$from_availability."',to_time='".$to_availability."' where user_id=".$user_id."");
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
		
		$insert=mysql_query("Insert tbluser_availability SET from_time='".$from_availability."',to_time='".$to_availability."',user_id=".$user_id."");
		
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