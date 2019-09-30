<?php 
include("../../config.php");
$id=(int)$_REQUEST['id'];
$val=$_REQUEST['val'];

$arrayToJs = array();

if($id!=0){
	if($val==1){
		$status = 0;
		$statusText = "InActive";
	}	
	else{
		$status = 1;
		$statusText = "Active";
	}
	$data = array('status'=>$status);	
	$where ="id ={$id}";
	$db->Update($data,"tblholidays",$where);	
	$arrayToJs["msg"] = "success";
	$arrayToJs["id"] = $id;
	$arrayToJs["status"] = $status;	
	$arrayToJs["statusText"] = $statusText;	
	//$arrayTOJs["link"] = "<a href='javscript:void(0);' onclick='changeContent(".$id.",".$status.")'>".$statusText."</a>";
}			
else{
	$arrayToJs["msg"] = "error";
	
}


echo json_encode($arrayToJs); 
?>
