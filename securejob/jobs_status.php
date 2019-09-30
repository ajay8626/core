<?php
include "config.php";

$status=isset($_GET['status'])?$_GET['status']:0;
$job_id=isset($_GET['job_id'])?$_GET['job_id']:0;
$loginid=isset($_SESSION['user_id']) ? $_SESSION['user_id'] :0;
$msg = "";


if($job_id !=0){
	
	$checkrecord=mysql_query("select status_id from `tbljobstatus` where job_id = ".$job_id." and user_id=".$loginid."");
	$statuscount=mysql_num_rows($checkrecord);
	$fetchrecord=mysql_fetch_array($checkrecord);
	$status_id=$fetchrecord['status_id'];
	if($statuscount==0)
	{
	$insertQry="Insert tbljobstatus SET job_id=".$job_id.",user_id=".$loginid.",status=".$status.",created_date='".date("Y-m-d h:i:s")."'";
	mysql_query($insertQry);
	$msg  = "Job Status has been updated successfully";
	bidder_update_status($loginid, $job_id, $status);
	} else {
	 $updateQry="Update  tbljobstatus SET job_id=".$job_id.",user_id=".$loginid.",status=".$status.",created_date='".date("Y-m-d h:i:s")."' where status_id=".$status_id."";
	 mysql_query($updateQry);
	 if($status == 3){
		$msg  = "You have already updated your status.";
	 }else{
		bidder_update_status($loginid, $job_id, $status);
		$msg  = "Job Poster has not yet completed the job from his/her side. Payment will be released once Job Poster completes the job";
	 }
	 
	}

	$countBidderCheck = "SELECT id FROM tbljobsapplied WHERE job_id = ".$job_id." AND is_winner=1";
	$countBidderQue = mysql_query($countBidderCheck);
	$countBidder = mysql_num_rows($countBidderQue);

	$countStatusBidCheck = "SELECT status_id FROM tbljobstatus WHERE tbljobstatus.job_id = ".$job_id." AND tbljobstatus.status=3";
	$countStatusBiddeQue = mysql_query($countStatusBidCheck);
	$countStatusBid = mysql_num_rows($countStatusBiddeQue);

	$countForStatus =  ($countBidder - $countStatusBid);
	
	if($status == 3 && $countForStatus==0){
		$updateQry = "update tbljobs set job_status = ".$status." where job_id = ".$job_id."";
		mysql_query($updateQry);
	} 
		
}
else{
	$msg  = "Something went wrong. Please try after sometime";
}	
echo $msg;
exit;

?>