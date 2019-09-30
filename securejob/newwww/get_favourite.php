<?php
include "config.php";
$userid=isset($_REQUEST['userid']) ? $_REQUEST['userid'] : 0;
$loginuserid=isset($_SESSION['user_id']) ? $_SESSION['user_id'] :0;

$sql=mysql_query("select is_like from tblfavourite where favourite_by=".$loginuserid." and favourite=".$userid."");
$fetchRecord=mysql_fetch_array($sql);
$islike=$fetchRecord['is_like'];

if($islike==1)
{
	$disLike=mysql_query("Delete from  tblfavourite where favourite_by=".$loginuserid." and favourite=".$userid."");
}
else
{
	$Like=mysql_query("Insert tblfavourite SET favourite_by=".$loginuserid.",favourite=".$userid.",is_like=1,favourite_date_time='".date("Y-m-d h:i:s")."'");
}
?>