<?php
/*
{
"function": "cleaner_list"
}

Ismanager=0 for customer login
for manager
Ismanager=1 for complete
Ismanager=2 for in-complete,pending,confirmed
*/ 
include("../config.php");
if(isset($rqst_data->function)){
//$customerId = isset($rqst_data->customerId)?($rqst_data->customerId):"";
$pageLimit = isset($rqst_data->count)?(int)($rqst_data->count):10;
$lastId = isset($rqst_data->lastId)?($rqst_data->lastId):'';

    /* $LastRecords='';
    if($lastDate)
	{
		$LastRecords=" and id < $lastId ";
	} */

//$postcode = isset($rqst_data->postcode)?stripslashes($rqst_data->postcode):"";
	
		$sql="SELECT * FROM `tblcleaners` where status=1 order by id DESC";
	
	
	//echo $sql;
	//exit;
	$res=$db->Query($sql);
	$rows=mysql_num_rows($res);
	$my_array=array();
	if($rows > 0)
	{
		while($result=mysql_fetch_assoc($res))
		{
			$id=$result['id'];
			$firstname=$result['firstname'];
			$lastname=$result['lastname'];
			$email=$result['email'];
			$phone=$result['phone'];
			//$time="select from_hours,from_min,to_hours,to_min from tbltimeslot where 
			
			
			
			$my_array['cleanerList'][]=array("cleaner_id"=>(int)$id,"firstname"=>$firstname,"lastname"=>$lastname,"email"=>$email,"phone"=>$phone);
			$status_array=1;
			$msg=get_msg("cleaner_list")?get_msg("cleaner_list"):'success';
			
		}
		
	}
	else
	{
		$status_array=0;
		$msg=get_msg("no_record_found")?get_msg("no_record_found"):'no_record_found';
	
	}
       header('Content-type: application/json; charset=utf-8');
	$final_array = array('result'=>$my_array,"message"=>$msg,'status'=>$status_array);
	echo $json= json_encode($final_array);
}
else{
	$final_array = array('result'=>'','status'=>0);
	echo $json= json_encode($final_array);
}
?>