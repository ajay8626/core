<?php 
include("../../config.php");
$email=$_REQUEST['fieldValue'];
$user_id=$_REQUEST['user_id'];
$and="";
	if($user_id!='')
	{
				$and=" AND id!=$user_id";		
	}

$qry=mysql_query("SELECT email FROM user where email='$email' $and");
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
