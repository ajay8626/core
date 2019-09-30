<?php 
/*
{
"function":"search_default",
"isActive":1
}
*/
include("../config.php");
include(SITE_PATH."api/class/message.php");

$authData = base64_decode($_SERVER['HTTP_AUTHENTICATE']);
$authData = explode(':',$authData);
$authUserId = $authData[0];
$authToken = $authData[1];
$totRows = 0;
if($authUserId != 0){
	$sql = "select * from tblusertoken WHERE user_id = $authUserId and user_auth_token = $authToken";
	$res = $db->Query($sql);
	$totRows = mysql_num_rows($res);
}
if(isset($rqst_data->function) && $totRows > 0 ){
	$userId = 	isset($rqst_data->userId) ? $rqst_data->userId : $authUserId;
	$isActive = 	isset($rqst_data->isActive) ? $rqst_data->isActive : 'all';
	if($isActive == 1){
		$is_active = 'active';
	}else if($isActive == 0){
		$is_active = 'inactive';
	}else{
		$is_active = 'all';
	}
	$my_array['decks'] = getDeckAllInfo($userId,$is_active);
	$my_array = (object) $my_array;
	$msg = get_msg("decklist_msg") ? get_msg("decklist_msg") : '';
	header('Content-type: application/json; charset=utf-8');
	$final_array = array('result'=>$my_array,'message'=>$msg,'status'=>1);
	echo $json= json_encode($final_array);
	
	
}else{
	$final_array = array('result'=>'','status'=>0);
	echo $json= json_encode($final_array);
}