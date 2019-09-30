<?php
include "config.php";
$data = json_decode(stripslashes($_POST['data']));
$user_id = $_SESSION['user_id'];
$coun = count($data);
$updatedData = array('user_id' => $user_id);
if($user_id!='')
{
	$deleteAvail = mysql_query("DELETE FROM tbluser_availability WHERE user_id=".$user_id." ");
	for($j=0; $j<$coun; $j++){
		foreach($data[$j] as $key=>$value){
			$updatedData[$key] = $value;
		}
		$db->Insert($updatedData, 'tbluser_availability');
	}
	echo "Availability updated successfully.";
	exit;
}else{
	echo "Something went wrong. Please try again.";
	exit;
}
?>