<?php
include "config.php"; 

$user_id=isset($_GET['user_id'])?$_GET['user_id']:0;
$job_id=isset($_GET['job_id'])?$_GET['job_id']:0;
$rate=isset($_GET['rate'])?$_GET['rate']:"";
$column=isset($_GET['column'])?ltrim($_GET['column']):"";
$reviewer_id=isset($_SESSION['user_id'])?$_SESSION['user_id']:0;

$perfomance=0;
$punctuality=0;
$presentation=0;
$dresscode=0;
$attitude=0;
$dbcolumn='';
if($column!='' && $column==1)
{
	$perfomance=$rate;
	$dbcolumn='performance';
}
if($column!='' && $column==2)
{
	$punctuality=$rate;
	$dbcolumn='punctuality';
}
if($column!='' && $column==3)
{
	$presentation=$rate;
	$dbcolumn='presentation';
}
if($column!='' && $column==4)
{
	$dresscode=$rate;
	$dbcolumn='dresscode';
}
if($column!='' && $column==5)
{
	$attitude=$rate;
	$dbcolumn='attitude';
}

$obj = new stjNotification;
$datetime = date("Y-m-d H:i:s");


if($column!=""){

    $checkrecord=mysql_query("select id from tblfeedback where job_id=".$job_id." and user_id=".$user_id." and reviewer_id=".$reviewer_id."");
	$rows=mysql_num_rows($checkrecord);
	$FetchRecord=mysql_fetch_array($checkrecord);
	$UpdatedId=$FetchRecord['id'];
	if($rows==0)
	{
		$insertSql = mysql_query("insert into tblfeedback (job_id,user_id,reviewer_id,rating,created_date,".$dbcolumn.") values (".$job_id.",".$user_id.",".$reviewer_id.",0,'".$datetime."',".$rate.")");
		$obj->addFeedbackNotification($job_id, $user_id, $reviewer_id);
	}
	else
	{
	 	$updateSql=mysql_query("update tblfeedback SET created_date='".$datetime."',".$dbcolumn."=".$rate." where id=".$UpdatedId."");	
		$obj->addFeedbackNotification($job_id, $user_id, $reviewer_id);
	}

	$chats .= getFeedbackPopup($job_id);
}
else{
	$chats= "Something went wrong. Please try after sometime";
}	
echo $chats;
exit;
?>