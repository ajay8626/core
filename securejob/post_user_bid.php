<?php
include "config.php";
$bid_amount=isset($_POST['bid_amount']) && $_POST['bid_amount']!='' ? $_POST['bid_amount']:0;
$persons=isset($_POST['persons']) && $_POST['persons']!='' ? $_POST['persons']:0;
$user_id=isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0; 
$job_id=isset($_POST['job_id']) ? $_POST['job_id'] : 0;

if($user_id!='' && $user_id!=0)
{
	$checkcount=mysql_query("select id from tbljobsapplied where job_id=".$job_id." and user_id=".$user_id."");
	
	$checkusercount=mysql_num_rows($checkcount);
	
	if ($checkusercount > 0) {
		echo 1;
		exit();
	} else {
	$Insert=mysql_query("Insert tbljobsapplied SET job_id=".$job_id.",user_id=".$user_id.",bidprice=".$bid_amount.",applied_date='".date('Y-m-d h:i:s')."',no_of_persons=".$persons."");
	/*Mail when bid is post*/
	new_bid_added($user_id,$job_id,$bid_amount);
		if($Insert)
		{
			$obj = new stjNotification;
			$obj->addBidNotification($job_id, $user_id);
			echo 2;
			exit();
		} else {
		   echo 3;
			exit();
		}
	}
} else {
  echo 3;
  exit();
}


?>