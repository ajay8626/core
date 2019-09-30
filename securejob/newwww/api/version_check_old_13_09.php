<?php

/*
{
"function":"checkVersion",
"version":"1.0",
"deviceType":1,
"langId":1,
"deviceToken":"asdfadfsadf123123213",
"customerId":0
}
*/
include("../config.php");
include(SITE_PATH."api/class/message.php");
if(isset($rqst_data->function)){ 
	@$version=$rqst_data->version;
	@$app_type=$rqst_data->deviceType;
	$LangId = 	isset($rqst_data->langId)?($rqst_data->langId):1;
	$DeviceType=isset($rqst_data->deviceType)?$rqst_data->deviceType:1;
	
	
	/*
		APP_NO_UPDATE_AVAILABLE = 0;
		APP_MANDATORY_UPDATE = 1;
		APP_NO_MANDATORY_UPDATE = 2;
	*/
	
	$isUpdateAvailable = 0;
	$Url = '';
	$my_array=array();
	$msg='';
	$updateMessage='';
	
	$sel="select is_update_available from tblversion where app_type='$app_type'";
	$query=mysql_query($sel) or die(mysql_error());
	while($row=mysql_fetch_assoc($query))
	{
		$isUpdateAvailable = intval($row['is_update_available']);
	}
	
	
	$sel="select app_url from tblversion where app_version > '$version' AND app_type='$app_type'";
	$query=mysql_query($sel) or die(mysql_error());
	$count=mysql_num_rows($query);
	if($count>0)
	{
		$updateMessage=get_msg("new_version_available")?get_msg("new_version_available"):'';
		$row=mysql_fetch_array($query);	
		$Url=$row['app_url'];
		
	}
	
	$currency = '';
	$sel_config = "SELECT * FROM tblsystemconfiguration where title_key in ('currency','max_no_doors','max_no_windows','max_no_conservatory')";
	$sel_config_query = mysql_query($sel_config) or die(mysql_error());
	while($row=mysql_fetch_assoc($sel_config_query)){
		if($row['title_key'] == 'currency'){
			$currency = $row['title_value'];
		}elseif($row['title_key'] == 'max_no_doors'){
			$max_no_doors=$row['title_value'];
		}elseif($row['title_key'] == 'max_no_windows'){
			$max_no_windows=$row['title_value'];
		}elseif($row['title_key'] == 'max_no_conservatory'){
			$max_no_conservatory=$row['title_value'];
		}
	}

		
	$sel="select app_type,app_url,is_approved from tblversion";
	$query=mysql_query($sel) or die(mysql_error());
	while($row=mysql_fetch_assoc($query))
	{
		if($row['app_type']==1)
		{
			$AppLinkAndorid=SITE_URL.'mobile';
			$is_approved = intval($row['is_approved']);
			
		}
		if($row['app_type']==2)
		{
			$AppLinkIOS=SITE_URL.'mobile';
			$is_approved = intval($row['is_approved']);
			
		}
	}
	$sel="select app_type,app_url,is_approved from tblversion";
	$query=mysql_query($sel) or die(mysql_error());
	while($row=mysql_fetch_assoc($query))
	{
		if($row['app_type']==1)
		{
			$AppLinkAndorid=SITE_URL.'mobile';
			$is_approved = intval($row['is_approved']);
			
		}
		if($row['app_type']==2)
		{
			$AppLinkIOS=SITE_URL.'mobile';
			$is_approved = intval($row['is_approved']);
			
		}
	}
	
	$holiday=array();
	$sel="select date from tblholidays where status='1'";
	$query=mysql_query($sel) or die(mysql_error());
	while($row=mysql_fetch_array($query))
	{
		$holiday[]=$row['date'];
	}
	
		
	$status_array = 1;
	
	$my_array = array("isUpdateAvailable"=>$isUpdateAvailable,"updateMessage"=>$updateMessage,"isApprovedApp"=>$is_approved,"currency"=>$currency,'max_no_conservatory'=>$max_no_conservatory,'max_no_doors'=>$max_no_doors,'max_no_windows'=>$max_no_windows,"Url"=>$Url,"appLinkAndorid"=>$AppLinkAndorid,"appLinkIOS"=>$AppLinkIOS,"holiday_list"=>$holiday);
	
	header('Content-type: application/json;');
	$final_array = array('result'=>$my_array,'message'=>$msg,'status'=>1);
	echo $json= json_encode($final_array);
}else{
	$final_array = array('result'=>'Invalid request passes!','status'=>0);
	echo $json= json_encode($final_array);
}
?>