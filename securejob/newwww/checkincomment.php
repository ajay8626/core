<?php
include "config.php"; 

$user_id=isset($_GET['user_id'])?$_GET['user_id']:0;
$job_id=isset($_GET['job_id'])?$_GET['job_id']:0;
$message=isset($_GET['check_comment'])?$_GET['check_comment']:"";

if($message!=""){ 
	// $insertSql = mysql_query("INSERT INTO tblschedule (job_id, user_id, date_check_in, checkin, comments_checkin) VALUES (".$job_id." , ".$user_id.", date(), 'asd', '".$message."')");

	$insertSql = mysql_query("INSERT INTO tblschedule (job_id, user_id, date_check_in, checkin, comments_checkin, check_flag) VALUES ($job_id, $user_id, NOW(), NOW(), '$message', 1 )");


	$check_comment = 'Checked In';
}
echo $check_comment;
exit;

?>