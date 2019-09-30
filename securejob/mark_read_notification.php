<?php
include "config.php";

$notifId = isset($_GET['notifId'])?$_GET['notifId']:0;

if($notifId!='' && $notifId!=0)
{
	$updateStatus = mysql_query("UPDATE tblstjnotification SET n_status=1 WHERE id=".$notifId." ");
	if($updateStatus){
		echo 1;
		exit;
	}
} else {
  	echo 0;
  	exit();
}

?>