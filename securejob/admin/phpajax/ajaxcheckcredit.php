<?php 
include("../../config.php");
$value=$_REQUEST['fieldValue'];
$husertype=$_REQUEST['husertype'];

$validateId=$_REQUEST['fieldId'];
$arrayToJs = array();
 $arrayToJs[0] = $validateId;
 
 if($husertype=='Normal User' or $husertype=='Celebrity') {
	 $value=100;
 }
 
	if($value>150)
	{
		$arrayToJs[1] = false;   
	}
	else
	{
		$arrayToJs[1] = true;   
	}


echo json_encode($arrayToJs); 