<?php
/*
{
"function":"crashReport",
"message":"xyz"
}
*/error_reporting(E_ALL);
include("../config.php");
if(isset($rqst_data->function)){
	$body = isset($rqst_data->message)?$rqst_data->message:'';
	if($body != ''){
		$crash_report = time();
		$req_dump = $body;
		$fp = fopen("crash_report/$crash_report.txt", 'w');
		fwrite($fp, $req_dump); 
		fclose($fp);
		$message = $body;
		$emailto = "komal@webtechsystem.com";
		$subject1 = "Crash Report - window cleaner";
		$headers = "From: Crash Report<crashreport@webtechsystem.com> \r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
		$chk = mail($emailto, $subject1, $message, $headers); 
		//$chk = sendMsg($emailto, $subject1, $message);
		
		header('Content-type: application/json;');
		
		if($chk){
			$msg = get_msg("success") ? get_msg("success") : '';
			$my_array = array('reportGenerated'=>1);
		}else{
		
			$msg = get_msg("error") ? get_msg("error") : '';
			$my_array =array('reportGenerated'=>0);
		}
		$my_array = (object) $my_array;
		$final_array = array('result'=>$my_array,'message'=>$msg,'status'=>1);
		echo $json= json_encode($final_array); 
	}else{
		$msg = "Please enter message";
		$status_array = 0;
		$my_array = (object) $my_array;
		$final_array = array('result'=>$my_array,'message'=>$msg,'status'=>0);
		echo $json= json_encode($final_array); 
	}
	
}else{
	$my_array = (object) array();
	$final_array = array('result'=>$my_array,'status'=>'fail');
	echo $json= json_encode($final_array);
}
?>