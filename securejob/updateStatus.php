<?php
include "config.php";

$status=isset($_GET['status'])?$_GET['status']:0;
$job_id=isset($_GET['job_id'])?$_GET['job_id']:0;

$msg = "";
if($job_id !=0){
	$updateQry = "update tbljobs set job_status = ".$status." where job_id = ".$job_id."";
	mysql_query($updateQry); 
	$msg  = "Job Status has been updated successfully";	
}
else{
	$msg  = "Something went wrong. Please try after sometime";
}	
echo $msg;
exit;

?>