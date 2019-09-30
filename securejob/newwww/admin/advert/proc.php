<?php 
if(!in_array(11,$tes_mod)) { 
echo "<div class='grid_12'><div class='message error'><p>You don't have permission to access this page</p></div></div>";
die;
}
// Include all file Here
require_once(ADMIN_PATH."inc/img_upload.php");
include_once(ADMIN_PATH."inc/functions.php");
include_once(ADMIN_PATH."inc/resize-class.php");
// Set  ID And Action
$a_id   = 	$_REQUEST["id"];
$act    = 	$_REQUEST["act"];

// Set All  data here
$title =	isset($_REQUEST["title"])&&$_REQUEST["title"]!=''?$_REQUEST["title"]:'';
$description =	isset($_REQUEST["description"])&&$_REQUEST["description"]!=''?$_REQUEST["description"]:'';
$is_featured = 	isset($_REQUEST["is_featured"])&&$_REQUEST["is_featured"]!=''?$_REQUEST["is_featured"]:0;
$status = 	isset($_REQUEST["status"])&&$_REQUEST["status"]!=''?$_REQUEST["status"]:0;

$link =	isset($_REQUEST["link"])&&$_REQUEST["title"]!=''?$_REQUEST["link"]:'';
$start_date =	isset($_REQUEST["start_date"]) && $_REQUEST["start_date"]!=''?$_REQUEST["start_date"]:'';
$end_date =	isset($_REQUEST["end_date"])&&$_REQUEST["end_date"]!=''?$_REQUEST["end_date"]:'';

if($start_date!='')
{
	$start_ex=explode("/",$start_date);
	$start_date=$start_ex[2]."-".$start_ex[1]."-".$start_ex[0];
}

if($end_date!='')
{
	$end_ex=explode("/",$end_date);
	$end_date=$end_ex[2]."-".$end_ex[1]."-".$end_ex[0];
}

$newfilename='';
$newFilePath='';
$newFileURL='';
if($_FILES['image']['name']!='')
{
	$tmpFilePath = $_FILES['image']['tmp_name'];
	if ($tmpFilePath != ""){
		//Setup our new file path
		$path = $_FILES['image']['name'];
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		
		$randname=rand(111111,999999);
		$newfilename =$randname.".".$ext;
		$newthumbfilename = "th_".$randname.".".$ext;
		
		$newFilePath = ADVERT_IMG_PATH . $newfilename;
		//$newFileURL = POST_IMG_URL . $newfilename;
		
		//Upload the file into the temp dir
		if(move_uploaded_file($tmpFilePath, $newFilePath))
		{
			$path2=ADVERT_IMG_PATH;
			//$resizeObj = new resize(USER_PROFILE_IMG_PATH.$newfilename);
			//$resizeObj->resizeImage(780, 780, 'exact');
			//$resizeObj->saveImage("$path2/$newfilename", 100);
			
			$resizeObj1 = new resize(ADVERT_IMG_PATH.$newfilename);
			$resizeObj1->resizeImage(780, 780, 'exact');
			$resizeObj1->saveImage("$path2/$newthumbfilename", 100);
		}
		
	}
}

// Add Section :: Add Data into database
if($act == "add"){	

	 if($title != "" ||  $description != ''){
			$job_image = '';
			if($newfilename!='')
			{
				$job_image = $newfilename;
			}
	
			$data = array('title'=>$title,'description'=>$description,'status'=>$status,'isfeatured'=>$is_featured,'image'=>$job_image,'link'=>$link,'start_date'=>$start_date,'end_date'=>$end_date);
			
			
			
			$db->Insert($data,"tbladvert");
			
			$last_id = mysql_insert_id();
			$_SESSION['mt'] = "success";
			$_SESSION['me'] = "'{$title}' added successfully.";
			header('Location:main.php?pg=viewadvert');
			exit;
	}
	else{	
		$_SESSION['mt'] = "error";
		$_SESSION['me'] = "Enter Valid Data.";
		header('Location:main.php?pg=viewadvert');
		exit;
	}	
}
// Modify Section :: Modify data into database
if($act == "mod"){	
	if($title != ""  || $description != ''){
			
		$data = array('title'=>$title,'description'=>$description,'status'=>$status,'isfeatured'=>$is_featured,'link'=>$link,'start_date'=>$start_date,'end_date'=>$end_date);
		
		
		$rmavatar=isset($_REQUEST["rmavatar"])?stripslashes($_REQUEST["rmavatar"]):"0";
		$job_image = '';
		if($rmavatar==1 || $newfilename!='')
		{
			$rmimage=isset($_REQUEST["rmimage"])?stripslashes($_REQUEST["rmimage"]):"";
			@unlink(ADVERT_IMG_PATH.$rmimage);
			@unlink(ADVERT_IMG_PATH.'th_'.$rmimage);
			$job_image = $newfilename;
			$imageArray = array('image'=>$job_image);
			$data = array_merge($data,$imageArray);
		}
		
		
		$where ="advert_id ={$a_id}";
	
		$db->Update($data,"tbladvert",$where);	
		
		
		
		
		
		$_SESSION['mt'] = "success";
		$_SESSION['me'] = "Advert Updated Successfully.";
		header('Location:main.php?pg=viewadvert');
		exit;
	} else	{	
		$_SESSION['mt'] = "error";
		$_SESSION['me'] = "Please enter valid data.";
		header('Location:main.php?pg=viewadvert');
		exit;
	}	
	
}
?>
<form name="frmAction" action="main.php?pg=viewadvert" method="post">
<input type="hidden" name="msg" value="<?php echo $msg; ?>">
<script language="javascript" type="text/javascript">
	document.frmAction.submit();
</script>
</form>