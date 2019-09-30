<?php 
/*
{
	"function": "get_postcode_customer",
    "postcodeId": 14
}
*/

include("../config.php");
if(isset($rqst_data->function)){
	$postcodeId = 	isset($rqst_data->postcodeId)?stripslashes($rqst_data->postcodeId):"";
	//$day = 	isset($rqst_data->day)?stripslashes(ucfirst($rqst_data->day)):"";
	//echo $day;
	//exit;
	//$key = array_search ($day, $DaysArray);
	$sql="SELECT * FROM `tblpostcode` where id=$postcodeId";
	//echo $sql;
	//exit;
	$res=$db->Query($sql);
	$rows=mysql_num_rows($res);
	$my_array=array();
	//$otherinfo=
	$status_array=0;
	if ($rows > 0){
	$status_array = 1;
		$otherinfo=array();
		$i=0;
		while($result_data = mysql_fetch_assoc($res)):
		$postcodeID=$result_data['id'];
        $dbPostCode=$result_data['postcode'];
		//$otherinfo['postcodeList'][]=array("postcode"=>$dbPostCode);
         //$otherinfo['postcode'][$postcodeID]=array("postcode"=>$dbPostCode);		
         //$sql="select timeslot"		//$otherinfo['postcode'][$result_data['postcodeid']][]=$result_data['postcodeid'];
		 $sqlDayTimeSlot = "select id,timeslot,day from tblpostcode_setting where postcodeid = ".$postcodeID."  order by day";
				$QueryRsDayTimeSlot = $db->Query($sqlDayTimeSlot);
				//$otherinfo['postcodeList']['dayList']=array();
				if(mysql_num_rows($QueryRsDayTimeSlot)){
					//$day=array();
					//$newarray=array();
					while($resultDayTimeSlots = mysql_fetch_assoc($QueryRsDayTimeSlot))	{
						//$otherinfo['postcodeList']['dayList'][$i]=array("day"=>$DaysArray[$resultDayTimeSlots['day']]); //$otherinfo['postcode'][$postcodeID][$resultDayTimeSlots['day']]=array("day"=>$resultDayTimeSlots['day']);
						//$day=array_merge($day,array("day"=>$DaysArray[$resultDayTimeSlots['day']]));
						$otherinfo['dayList']=
						$timeslotQuery = mysql_query("select id,from_hours,from_min,to_hours,to_min,time_type from tbltimeslot  where id in ( ".$resultDayTimeSlots["timeslot"].") ");	
						$timeSlots = array();
						if(mysql_num_rows($timeslotQuery)){
							//$otherinfo['postcodeList']['dayList']
							while($resultTimeSlots = mysql_fetch_assoc($timeslotQuery)){
								//$otherinfo['postcodeList']['dayList'][]=array("time"=>$resultTimeSlots['from_hours']);
								//$timeSlots = array_merge($timeSlots , array(sprintf('%02d',$resultTimeSlots['from_hours']). ':'.sprintf('%02d',$resultTimeSlots['from_min']).' - '.sprintf('%02d',$resultTimeSlots['to_hours']).':'.sprintf('%02d',$resultTimeSlots['to_min']) ) ) ;
                               $prefix='AM';
							   if($resultTimeSlots['from_hours'] > 12)
							   {
								   $prefix='PM';
							   }
							   $postfix='AM';
							   if($resultTimeSlots['to_hours'] > 12)
							   {
								   $postfix='PM';
							   }
							   $timeSlots[]=array("id"=>(int)$resultTimeSlots['id'],"time"=>$resultTimeSlots['time_type']);
								//$otherinfo['postcode'][$postcodeID][$resultDayTimeSlots['day']][$resultDayTimeSlots['day']]['timeslot'] = (array(sprintf('%02d',$resultTimeSlots['from_hours']). ':'.sprintf('%02d',$resultTimeSlots['from_min']).' - '.sprintf('%02d',$resultTimeSlots['to_hours']).':'.sprintf('%02d',$resultTimeSlots['to_min']) ) ) ;
							}
						}
						$dayWiseTimeSlotarray[$DaysArray[$resultDayTimeSlots["day"] ] ] = $timeSlots;
						//$newarray=array_merge("dayList"=>$day,"timelist"=>$timeSlots);
						//$newarray[]=array("dayList"=>$day,"timelist"=>$timeSlots);
						//$newarray[]=array("dayList"=>$day,"timelist"=>$timeSlots);
						$newarray[]=array("day"=>(int)$resultDayTimeSlots["day"],"timelist"=>$timeSlots);
						$otherinfo['dayList']=($newarray);
					}
					//$new=array("postcode"=>$dbPostCode);
					//$otherinfo['postcodeList'][]= array_merge($new,$newarray);
					$dayandTimeSlotarray[$dbPostCode] = $dayWiseTimeSlotarray;
					
				}
	    $i++;	 
		endwhile;
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