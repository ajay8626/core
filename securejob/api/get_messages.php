<?php
/*
{
"function":"getMessage"
}
*/
include("../config.php");
include(SITE_PATH."api/class/message.php");
if(isset($rqst_data->function)){
	
	$sel_app_msg = "select title_key from tblgeneralmessage where is_app_msg = '1'";
	
	
	$query=mysql_query($sel_app_msg) or die(mysql_error());
	$list = array();
	while($row = mysql_fetch_assoc($query))
	{
		$list[] = $row['title_key'];
	}
	//echo '<pre>';print_r($list);
	//exit;
	$query="Select max(created_date) as maxdate from tblgeneralmessagetranslation";
	$result=mysql_query($query) or die(mysql_error());
	$rowdate = mysql_fetch_assoc($result);
	$lastMessageDate=$rowdate['maxdate'];
	
	
	$message = new Message();
	$Appmessage = $message->getlist($list);
	$msg="Message List.";
	$status_array = 1;
	$my_array = array("messageList"=>$Appmessage,"lastMessageDate"=>$lastMessageDate);
	header('Content-type: application/json;');
	$final_array = array('result'=>$my_array,'message'=>$msg,'status'=>1);
	echo $json= json_encode($final_array);
}
else{
	$final_array = array('result'=>'Invalid request passes!','status'=>0);
	echo $json= json_encode($final_array);
}
?>