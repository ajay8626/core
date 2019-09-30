<?php 
if(!in_array(1,$tes_mod)) { 
echo "<div class='grid_12'><div class='message error'><p>You don't have permission to access this page</p></div></div>";
die;
}
// Include all file Here
error_reporting(0);
require_once "../config.php";
require_once "chkadminsess.php";
if(isset($_SERVER['HTTP_REFERER']) == ADMIN_URL."main1.php?pg=addadmin")
{
// Set Admin ID And Action
$a_id   = 	$_REQUEST['a_id'];
$act    = 	$_REQUEST["act"];

// Set All Admin data here
$a_name =	addslashes($_REQUEST["a_name"]); 
$a_lname =	addslashes($_REQUEST["a_lname"]); 
$uname =	addslashes($_REQUEST["uname"]); 
$status = 	isset($_REQUEST["status"])?$_REQUEST["status"]:0;
$a_email = 	$_REQUEST["a_email"];  

		
$a=$_POST['c_chk'];
	
 $count=count($_POST['c_chk']);
for($i=0;$i<$count;$i++)
{
	$arr[]=$a[$i];
}
  $c_chk=@implode(",",$arr);
 // exit;
 		

// Add Section :: Add Data into database
if($act == "add"){	

	 if($a_email != ""){			
			$totRows = 0;
			$sql = "select * from tbladmin where adminemail = '{$a_email}'";
			$totRows = mysql_num_rows($db->Query($sql));
			if($totRows >0){	
				$_SESSION['mt'] = "error";
				$_SESSION['me'] = "Email Address '{$a_email}' Already Exists.";
				header('Location:main.php?pg=viewadmin');
				exit;
			}
			else
			{ 
				$pass  =  	md5($_REQUEST['pwd1']);
				$data = array('adminfname'=>stripslashes($a_name),'adminlname'=>$a_lname, 'adminemail'=>$a_email, 'password'=>$pass,'isactive'=>$status);
				$db->Insert($data,"tbladmin");
			    $a_id1 = mysql_insert_id();
				foreach ($a as $value) 
				{
					$data1 = array('menu_id'=>$value,'admin_id'=>$a_id1);
					$db->Insert($data1,"tbladminrights");
				}
				$a_nameZ=stripslashes($a_name).' '.$a_lname;
				//die;
				$_SESSION['mt'] = "success";
				$_SESSION['me'] = "Admin user '{$a_nameZ}' added successfully.";
				header('Location:main.php?pg=viewadmin');
				exit;
			}                 
	}
	else{	
			$_SESSION['mt'] = "error";
			$_SESSION['me'] = "Enter Valid Admin Name/ID.";
			header('Location:main.php?pg=viewadmin');
			exit;
	}	
}
// Modify Section :: Modify data into database
if($act == "mod"){		
	if($a_name != "" && $a_id > 0){			
			$totRows = 0;
		 	$aName = addslashes($a_name);
			$admn_id = 	$_REQUEST["a_id"];
			$a_email = 	$_REQUEST["a_email"];
			
			$sql = "select * from tbladmin where ((adminemail = '{$a_email}')  and adminid  <> {$a_id}";
			$totRows = mysql_num_rows($db->Query($sql));
			if($totRows >0)
			{	
				$_SESSION['mt'] = "error";
				$_SESSION['me'] = "Email address or user name already exists.";
				header('Location:main.php?pg=modadmin&a_id='.$admn_id);
				exit;
			}
			else
			{
				$data = array('adminfname'=>stripslashes($a_name),'adminlname'=>stripslashes($a_lname), 'adminemail'=>$a_email, 'isactive'=>$status);
				$where ="adminid ={$a_id}";
				$password_1 = $_REQUEST['pwd1'];
				$password_2 = $_REQUEST['pwd2'];
				if(isset($password_1) && !empty($password_1) && $password_1==$password_2 )
				{	
					$pass  = md5($password_1);
					$data = array_merge($data,array('password'=>$pass));
					$where ="adminid ={$a_id}";
				}
				
				$db->Update($data,"tbladmin",$where);
				echo "<pre>";
				print_r($a);
				exit;
				 //$a_id = mysql_insert_id();
				 
				/* $sql1 = mysql_query("select * from tbladminrights where adminid = ".$a_id."");
				$where1= "admin_id  = {$a_id}";	
				$db->Delete("tbladminrights",$where1);		
				foreach ($a as $value) 
				{		
					$data1 = array('menu_id'=>$value,'admin_id'=>$a_id);
					$db->Insert($data1,"tbladminrights");
				} */
				$_SESSION['mt'] = "success";
				$_SESSION['me'] = "Admin Update Successfully.";
				header('Location:main.php?pg=viewadmin');
				exit;
			}
		}
		else
		{	
			$_SESSION['mt'] = "error";
			$_SESSION['me'] = "Admin Name/Password Invalid.";
			header('Location:main.php?pg=viewadmin');
			exit;
		}	
}		
// Delete Section :: Delete data from database
if($act == "del"){ 
$a_id = $_REQUEST["a_id"];
$adminid = ADMINID;
if(is_numeric($a_id) && $a_id > 0 AND $a_id != $adminid ){	
	$where = "adminid  = {$a_id} AND adminid  <> {$adminid} ";
	if($db->Delete("tbladmin",$where)){
		$_SESSION['mt'] = "success";
		$_SESSION['me'] = "Admin user deleted successfully.";
		header('Location:main.php?pg=viewadmin');
		exit;
	}else{
		$_SESSION['mt'] = "error";
		$_SESSION['me'] = "Error while delete admin user. Please try again.";
		header('Location:main.php?pg=viewadmin');
		exit;
	}
}
else{
	$_SESSION['mt'] = "error";
	$_SESSION['me'] = "Invalid ID/Name.";
	header('Location:main.php?pg=viewadmin');
	exit;	
}	
	
}
}
?>
<form name="frmAction" action="main.php?pg=viewadmin" method="post">
<input type="hidden" name="msg" value="<?php echo $msg; ?>">
<script language="javascript" type="text/javascript">
	document.frmAction.submit();
</script>
</form>