<?php 
if(!in_array(2,$tes_mod)) { 
echo "<div class='grid_12'><div class='message error'><p>You don't have permission to access this page</p></div></div>";
die;
}
// Include all file Here
error_reporting(0);
require_once "../config.php";
require_once "chkadminsess.php";
//if(isset($_SERVER['HTTP_REFERER']) == ADMIN_URL."main1.php?pg=addadmin")
//{
// Set Admin ID And Action
$a_id   = 	$_REQUEST['id'];
$act    = 	$_REQUEST["act"];

// Set All Admin data here
$status = 	isset($_REQUEST["status"])&&$_REQUEST["status"]!=''?$_REQUEST["status"]:0;
$location =	isset($_REQUEST["location"])&&$_REQUEST["location"]!=''?$_REQUEST["location"]:'';
//$state =	addslashes($_REQUEST["state"]); 
  		

// Add Section :: Add Data into database
if($act == "add"){	

	 if($location != "")
	 {			
		$data = array('locationname'=>$location,'status'=>$status);
		$db->Insert($data,"tbllocation");
		//die;
		$_SESSION['mt'] = "success";
		$_SESSION['me'] = "'{$location}' added successfully.";
		header('Location:main.php?pg=viewlocation');
		exit;
	}                 
	
	else{	
			$_SESSION['mt'] = "error";
			$_SESSION['me'] = "Enter Valid Location Name.";
			header('Location:main.php?pg=viewlocation');
			exit;
	}	
}
// Modify Section :: Modify data into database
if($act == "mod")
{		
	if($location != "" && $a_id > 0)
	{			
		$data = array('locationname'=>$location,'status'=>$status);
		$where ="location_id ={$a_id}";
					
		$db->Update($data,"tbllocation",$where);
		 //$a_id = mysql_insert_id();
		
		$_SESSION['mt'] = "success";
		$_SESSION['me'] = "Location Update Successfully.";
		header('Location:main.php?pg=viewlocation');
		exit;
	}
	else
		{	
			$_SESSION['mt'] = "error";
			$_SESSION['me'] = "Invalid Details.";
			header('Location:main.php?pg=viewlocation');
			exit;
		}	
}	
	
// Delete Section :: Delete data from database
if($act == "del"){ 
$a_id = $_REQUEST["id"];
$adminid = ADMINID;
if(is_numeric($a_id) && $a_id > 0 AND $a_id != $adminid ){	
	$where = "adminid  = {$a_id} AND adminid  <> {$adminid} ";
	if($db->Delete("tbladmin",$where)){
		$_SESSION['mt'] = "success";
		$_SESSION['me'] = "Admin user deleted successfully.";
		header('Location:main.php?pg=viewlocation');
		exit;
	}else{
		$_SESSION['mt'] = "error";
		$_SESSION['me'] = "Error while delete admin user. Please try again.";
		header('Location:main.php?pg=viewlocation');
		exit;
	}
}
else{
	$_SESSION['mt'] = "error";
	$_SESSION['me'] = "Invalid ID/Name.";
	header('Location:main.php?pg=viewlocation');
	exit;	
}	
	
}
//}
?>
<form name="frmAction" action="main.php?pg=viewlocation" method="post">
<input type="hidden" name="msg" value="<?php echo $msg; ?>">
<script language="javascript" type="text/javascript">
	document.frmAction.submit();
</script>
</form>