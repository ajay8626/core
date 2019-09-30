<?php
include "config.php";

$request_id=isset($_REQUEST['request_id']) ? $_REQUEST['request_id'] :0;
$jobtype=isset($_REQUEST['jobtype']) ? $_REQUEST['jobtype'] :0;
$job_list=isset($_REQUEST['job_list']) ? $_REQUEST['job_list'] :0;

if($jobtype==1)
{
	$insertrequest=mysql_query("Insert `hire_candidates` SET job_id=".$job_list.",request_user_id=".$_SESSION['user_id'].",requested_user_id=".$request_id.",is_requested=1,requested_date_time='".date("Y-m-d h:i:s")."'");
	
	/* Mail to invite */
	job_invitation($job_list, $request_id);


	/*code for notification*/
	if($insertrequest)
		{
			$obj = new stjNotification;
			$obj->userInviteNotification($job_list, $_SESSION['user_id'],$request_id);
			echo 2;
			//exit();
		} else {
		   echo 3;
			//exit();
		}
	/*end code for notification*/
	
	$_SESSION['mt'] = "success";
	$_SESSION['me'] = "Request has been successfully sent to candidate.";
	header("location:new-request.php");
	exit();
}

if($jobtype==2)
{
	$_SESSION['request_user_id']=$request_id;
	header("location:add-new-job.php");
	exit();
}
?>