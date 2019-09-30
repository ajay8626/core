<?php 
if(!in_array(14,$tes_mod)) { 
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
$title =	isset($_REQUEST["title"])&&$_REQUEST["title"]!=''?$_REQUEST["title"]:'';
//$state =	addslashes($_REQUEST["state"]); 
  		

// Add Section :: Add Data into database
if($act == "add"){	

	 if($title != "")
	 {			
		$data = array('title'=>$title,'status'=>$status);
		$db->Insert($data,"tbljobstatusmaster");
		//die;
		$_SESSION['mt'] = "success";
		$_SESSION['me'] = "'{$title}' added successfully.";
		header('Location:main.php?pg=viewjobstatus');
		exit;
	}                 
	
	else{	
			$_SESSION['mt'] = "error";
			$_SESSION['me'] = "Enter Valid Job Status.";
			header('Location:main.php?pg=viewjobstatus');
			exit;
	}	
}
// Modify Section :: Modify data into database
if($act == "mod")
{		
	if($title != "" && $a_id > 0)
	{			
		$data = array('title'=>$title,'status'=>$status);
		$where ="id ={$a_id}";
					
		$db->Update($data,"tbljobstatusmaster",$where);
		 //$a_id = mysql_insert_id();
		
		$_SESSION['mt'] = "success";
		$_SESSION['me'] = "Job Status Update Successfully.";
		header('Location:main.php?pg=viewjobstatus');
		exit;
	}
	else
		{	
			$_SESSION['mt'] = "error";
			$_SESSION['me'] = "Invalid Details.";
			header('Location:main.php?pg=viewjobstatus');
			exit;
		}	
}	
	
?>
<form name="frmAction" action="main.php?pg=viewjobstatus" method="post">
<input type="hidden" name="msg" value="<?php echo $msg; ?>">
<script language="javascript" type="text/javascript">
	document.frmAction.submit();
</script>
</form>