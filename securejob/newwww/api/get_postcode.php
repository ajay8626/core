<?php 
/*
{
"function": "get_postcode",
"postcode": "xyz xyz"
}
*/

include("../config.php");
if(isset($rqst_data->function)){
	$postcode = 	isset($rqst_data->postcode)?stripslashes($rqst_data->postcode):"";
	$checkpostcode=preg_replace('/\s+/', '', $postcode);;
	//echo $checkpostcode;
	//exit;
	$stringlength=strlen($checkpostcode);
	//echo $stringlength;
	if($stringlength <= 6)
	{
		//echo "he";
		$checkstring=substr($checkpostcode,0,3);
	}
	if($stringlength > 6)
	{
		//echo "hel";
		$checkstring=substr($checkpostcode,0,4);
	}
	//$checkstring=substr($checkpostcode,0,4);
	//echo $checkstring;
	//exit;
	//$sql="SELECT * FROM `tblpostcode ORDER by postcode='".$postcode."' DESC,postcode ASC";
	$sql="SELECT * FROM `tblpostcode`   ORDER by postcode like '%$checkstring%' DESC,postcode ASC"; 
	//echo $sql;
	//exit;
	$res=$db->Query($sql);
	$rows=mysql_num_rows($res);
	$my_array=array();
	$otherinfo=array();
	if ($rows > 0){
	$status_array = 1;
		//$otherinfo['postcodeList']=array();
		//$i=0;
		while($result_data = mysql_fetch_assoc($res)):
		$postcodeID=$result_data['id'];
        $dbPostCode=$result_data['postcode'];
		$my_array['postCode'][]=array("id"=>(int)$postcodeID,"postcode"=>$dbPostCode);
		
				//}
	    //$i++;	 
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