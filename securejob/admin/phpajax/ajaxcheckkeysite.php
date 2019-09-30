<?php 
include("../../config.php");
$title_key=$_REQUEST['fieldValue'];
$keyid=$_REQUEST['keyid'];
$and="";
	if($keyid!='')
	{
				$and=" AND id!=$keyid";		
	}

$qry=mysql_query("SELECT * FROM site_general_message where title_key='$title_key' $and");
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
