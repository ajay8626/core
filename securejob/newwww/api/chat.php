<?php 
/*
{
"function":"chat",
"tag":"air"
}
*/
include("../config.php");
include(SITE_PATH."api/class/message.php");

$chatSessionId=isset($_REQUEST['ChatSessionId'])?($_REQUEST["ChatSessionId"]):0;
$sender=isset($_REQUEST['Sender'])?($_REQUEST["Sender"]):0;
$receiver=isset($_REQUEST['Receiver'])?($_REQUEST["Receiver"]):0;
$content=isset($_REQUEST['Content'])?($_REQUEST["Content"]):"";
$timeZone=isset($_REQUEST['TimeZone'])?($_REQUEST["TimeZone"]):"+05:30";
$lastAddedDate=isset($_REQUEST['LastAddedDate'])?($_REQUEST["LastAddedDate"]):"";
$Type=isset($_REQUEST['Type'])?($_REQUEST["Type"]):0;
$LocalPath=isset($_REQUEST['LocalPath'])?($_REQUEST["LocalPath"]):'';
//0-TEXT,1-IMAGE,2-AUDIO,3-VIDEO,4-THUMB}
$message=''; $isPaging=0; 
$row_createdate='';
$createdate = date('Y-m-d H:i:s');
$SenderUnreadMSG=0;
$name=array();
$ReceiverDetails=array();
$SenderDetails=array();

if($receiver){ $ReceiverDetails = get_user_details_by_userid($receiver); }
if($sender) { $SenderDetails = get_user_details_by_userid($sender); }

$name[$sender]=$SenderDetails['name'];
$name[$receiver]=$ReceiverDetails['name'];

	