<?php
include "config.php";

$acc_holder_name=isset($_POST['acc_holder_name']) ? $_POST['acc_holder_name'] : "";
$bank_name=isset($_POST['bank_name']) ? $_POST['bank_name'] : "";
$acc_number=isset($_POST['acc_number']) ? $_POST['acc_number'] : "";

$user_id=$_SESSION['user_id'];
if($user_id!='')
{
$update=mysql_query("update tbluser SET bank_name='".$bank_name."',acc_holder_name='".$acc_holder_name."',acc_number='".$acc_number."' where user_id=".$user_id."");
	if($update)
	{
		echo $bank_name."~".$acc_holder_name."~".$acc_number;
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