<?php
include "config.php";

$job_id=isset($_GET['job_id'])?$_GET['job_id']:0;
$loginid=isset($_SESSION['user_id']) ? $_SESSION['user_id'] :0;

$msg = "";
if($job_id !=0){
	
		$updateQry = "update tbljobs set job_status = 4 where job_id = ".$job_id."";
		mysql_query($updateQry); 
	 
	$msg  = "Job Status has been updated successfully";	
}
else{
	$msg  = "Something went wrong. Please try after sometime";
}	
echo $msg;
exit;

?>