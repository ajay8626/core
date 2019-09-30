<?php
include "config.php"; 

$user_id=isset($_GET['user_id'])?$_GET['user_id']:0;
$job_id=isset($_GET['job_id'])?$_GET['job_id']:0;
$message=isset($_GET['message'])?$_GET['message']:"";


$datetime = date("Y-m-d H:i:s");
if($message!=""){ 

	$insertSql = mysql_query("insert into tblChat (job_id,sender_id,receiver_id,message,date_time)
								values
								(".$job_id." , ".$user_id.",0, '".$message."', '".$datetime."' )");
	
	if($insertSql){
		$obj = new stjNotification;
		$obj->insertChatNotification($job_id, $user_id);
	}
	
	/* generate HTML to load new message */
	$chats  = getChats($job_id,$user_id);
}
else{
	$chats  = "Something went wrong. Please try again after sometime";
}	
echo $chats;
exit;

?>