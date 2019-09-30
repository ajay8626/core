<?php
include "config.php"; 

$user_id=isset($_GET['user_id'])?$_GET['user_id']:0;
$job_id=isset($_GET['job_id'])?$_GET['job_id']:0;
$message=isset($_GET['check_comment'])?$_GET['check_comment']:"";

if($message!=""){ 
	$currentDate = date('Y-m-d');
	$updateQry="Update tblschedule SET checkout=NOW(), comments_checkout='$message', check_flag=2 where user_id=$user_id AND job_id=$job_id AND date_check_in='$currentDate' AND check_flag=1";
	 mysql_query($updateQry);

	$check_comment = 'Checked Out';
}
echo $check_comment;
exit;

?>