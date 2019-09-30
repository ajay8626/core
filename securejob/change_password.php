<?php
include "config.php";

$user_password=isset($_POST['user_password']) ? $_POST['user_password'] : "";
$user_id=$_SESSION['user_id'];
$old_password=isset($_POST['old_password']) ? $_POST['old_password'] : "";

if($user_id!='')
{
  $checkoldpassowrd=mysql_query("select user_id from  tbluser where password='".md5($old_password)."' and user_id=".$user_id."");
	$totalrows=mysql_num_rows($checkoldpassowrd);
	
	$update='';
	if($totalrows > 0)
	{
	$update=mysql_query("update tbluser SET password='".md5($user_password)."' where user_id=".$user_id."");
	}
	
	if($totalrows==0)
	{
		echo 3;
		exit();
	}
	else if($update)
	{
		echo 1;
		exit();
	}
	else
	{
		echo 2;
	    exit();
	}
}
else
{
	echo 2;
	exit();
}

?>