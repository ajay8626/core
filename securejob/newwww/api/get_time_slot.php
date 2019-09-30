<?php 
/*
{"function": "get_time_slot","postcode":"SWR 12F"}
*/

include("../config.php");
if(isset($rqst_data->function)){
	$postcode = isset($rqst_data->postcode)?stripslashes($rqst_data->postcode):"";
	$sql="SELECT * FROM `tblpostcode_setting` where postcode='$postcode'";
	$res=$db->Query($sql);
	$rows=mysql_num_rows($res);
	$my_array=array();
	$otherinfo=array();
	$status_array = 1;
	if ($rows > 0){
		
		$result_data = mysql_fetch_assoc($res); 
			$exps=explode(',',$result_data['timeslot']);
			$imdates=explode(',',$result_data['date']);
		
			foreach($imdates as $date){
				$dates[]=$date;
			}
			$timeslot=array();
			foreach($exps as $exp){
				$sqlt="SELECT * FROM `tbltimeslot` where id=$exp";
				$rest=$db->Query($sqlt);
				$result_datat = mysql_fetch_assoc($rest);
				$from_time=date('h:i a',strtotime($result_datat['from_hours'].':'.$result_datat['from_min']));
				$to_time=date('h:i a',strtotime($result_datat['to_hours'].':'.$result_datat['to_min']));
				$timeslot=array('from'=>$from_time,'to'=>$to_time);
				$timeslotar[]=$timeslot;
			}
			
		$otherinfo=array('dates'=>$dates,'timeslot'=>$timeslotar);
		$msg=get_msg("success")?get_msg("success"):'success';
	} else {
		$msg=get_msg("no_record_found")?get_msg("no_record_found"):'no_record_found';
	}
	$my_array = array_merge($my_array, $otherinfo);
	header('Content-type: application/json; charset=utf-8');
	$final_array = array('result'=>$my_array,"message"=>$msg,'status'=>$status_array);
	echo $json= json_encode($final_array);
}else{
	$final_array = array('result'=>'','status'=>0);
	echo $json= json_encode($final_array);
}
?> 