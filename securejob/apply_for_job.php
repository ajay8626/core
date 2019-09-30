<?php
include "config.php";

$jobId=isset($_GET['jobId'])?$_GET['jobId']:0;
$userId=isset($_GET['userId'])?$_GET['userId']:0;
$jobPrice=isset($_GET['jobPrice'])?$_GET['jobPrice']:0;

if($userId!='' && $userId!=0)
{
	$checkcount=mysql_query("select id from tbljobsapplied where job_id=".$jobId." and user_id=".$userId."");
	$checkusercount=mysql_num_rows($checkcount);
	
	if ($checkusercount > 0) {
		echo 1;
		exit();
	}else{
		$Insert = mysql_query("Insert tbljobsapplied SET job_id=".$jobId.", user_id=".$userId.", bidprice=".$jobPrice.", applied_date='".date('Y-m-d h:i:s')."', no_of_persons=1");
		/*Mail when bid is post*/
		new_bid_added($userId,$jobId,$jobPrice);
		if($Insert)
		{
			$obj = new stjNotification;
			$obj->addBidNotification($jobId, $userId);
			echo 2;
			exit();
		}else{
			echo 3;
			exit();
		}
	}
} else {
  	echo 3;
  	exit();
}

?>