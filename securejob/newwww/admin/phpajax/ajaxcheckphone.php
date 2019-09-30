<?php 
include("../../config.php");
$phone=$_REQUEST['fieldValue'];
$user_id=isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';
$and="";
	if($user_id!='')
	{
				$and=" AND user_id!=$user_id";		
	}

$qry=mysql_query("SELECT phone FROM tbluser where phone='$phone' $and");
$row=mysql_num_rows($qry);
$validateId=$_REQUEST['fieldId'];


 $arrayToJs = array();
 $arrayToJs[0] = $validateId;

		if($row==0)
		{
			$arrayToJs[1] = true;                      
		
		}
		else
		{	
			$arrayToJs[1] = false;                      
			
		}
echo json_encode($arrayToJs); 
?>
