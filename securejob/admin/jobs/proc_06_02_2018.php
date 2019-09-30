<?php 
if(!in_array(5,$tes_mod)) { 
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
$jobname =	isset($_REQUEST["jobname"])&&$_REQUEST["jobname"]!=''?$_REQUEST["jobname"]:'';
$description =	isset($_REQUEST["description"])&&$_REQUEST["description"]!=''?$_REQUEST["description"]:'';
$user_id =	isset($_REQUEST["user_id"])&&$_REQUEST["user_id"]!=''?$_REQUEST["user_id"]:0;

$is_featured = 	isset($_REQUEST["is_featured"])&&$_REQUEST["is_featured"]!=''?$_REQUEST["is_featured"]:0;
$status = 	isset($_REQUEST["status"])&&$_REQUEST["status"]!=''?$_REQUEST["status"]:0;
$price = 	isset($_REQUEST["price"])&&$_REQUEST["price"]!=''?$_REQUEST["price"]:0;
$hours = 	isset($_REQUEST["hours"])&&$_REQUEST["hours"]!=''?$_REQUEST["hours"]:0;
$days = 	isset($_REQUEST["days"])&&$_REQUEST["days"]!=''?$_REQUEST["days"]:0;
$start_date = 	isset($_REQUEST["start_date"])&&$_REQUEST["start_date"]!=''?date('Y-m-d H:i:s',strtotime($_REQUEST["start_date"])):'';
$riskmeter = 	isset($_REQUEST["riskmeter"])&&$_REQUEST["riskmeter"]!=''?$_REQUEST["riskmeter"]:'';
$categories = 	isset($_REQUEST["categories"])&&$_REQUEST["categories"]!=''?$_REQUEST["categories"]:'';
$tags = 	isset($_REQUEST["tags"])&&$_REQUEST["tags"]!=''?$_REQUEST["tags"]:'';
$latitude = 	isset($_REQUEST["latitude"])&&$_REQUEST["latitude"]!=''?$_REQUEST["latitude"]:'';
$longitude = 	isset($_REQUEST["longitude"])&&$_REQUEST["longitude"]!=''?$_REQUEST["longitude"]:'';
$address_1 = 	isset($_REQUEST["address_1"])&&$_REQUEST["address_1"]!=''?$_REQUEST["address_1"]:'';
$address_2 = 	isset($_REQUEST["address_2"])&&$_REQUEST["address_2"]!=''?$_REQUEST["address_2"]:'';
$postal_code = 	isset($_REQUEST["postal_code"])&&$_REQUEST["postal_code"]!=''?$_REQUEST["postal_code"]:'';
$country_id =	isset($_REQUEST["country_id"])&&$_REQUEST["country_id"]!=''?$_REQUEST["country_id"]:0;
$state_id =	isset($_REQUEST["state_id"])&&$_REQUEST["state_id"]!=''?$_REQUEST["state_id"]:0;
$city_id =	isset($_REQUEST["city_id"])&&$_REQUEST["city_id"]!=''?$_REQUEST["city_id"]:0;
$transportlink = 	isset($_REQUEST["transportlink"])&&$_REQUEST["transportlink"]!=''?$_REQUEST["transportlink"]:'';
$dresscode_description = 	isset($_REQUEST["dresscode_description"])&&$_REQUEST["dresscode_description"]!=''?$_REQUEST["dresscode_description"]:'';

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
		
		$newFilePath = JOBS_IMG_PATH . $newfilename;
		//$newFileURL = POST_IMG_URL . $newfilename;
		
		//Upload the file into the temp dir
		if(move_uploaded_file($tmpFilePath, $newFilePath))
		{
			$path2=JOBS_IMG_PATH;
			//$resizeObj = new resize(USER_PROFILE_IMG_PATH.$newfilename);
			//$resizeObj->resizeImage(780, 780, 'exact');
			//$resizeObj->saveImage("$path2/$newfilename", 100);
			
			$resizeObj1 = new resize(JOBS_IMG_PATH.$newfilename);
			$resizeObj1->resizeImage(150, 150, 'exact');
			$resizeObj1->saveImage("$path2/$newthumbfilename", 100);
		}
		
	}
}

// Add Section :: Add Data into database
if($act == "add"){	

	 if($jobname != "" || $price != '' || $description != ''){
			$job_image = '';
			if($newfilename!='')
			{
				$job_image = $newfilename;
			}
	
			$data = array('job_user_id'=>$user_id,'job_name'=>$jobname,'job_description'=>$description,'price'=>$price,'image'=>$job_image,'job_days'=>$days,'job_hours'=>$hours,'start_date'=>$start_date,'riskmeter'=>$riskmeter,'latitude'=>$latitude,'longitude'=>$longitude,'address1'=>$address_1,'address2'=>$address_2,'postalcode'=>$postal_code,'country_id'=>$country_id,'state_id'=>$state_id,'city_id'=>$city_id,'transport_link'=>$transportlink ,'dresscode'=>$dresscode_description,'status'=>$status,'created_date'=>date('Y-m-d H:i:s'),'isfeatured'=>$is_featured);
			
			
			
			$db->Insert($data,"tbljobs");
			
			$last_id = mysql_insert_id();
			
			if(!empty($categories)){
				foreach($categories as $cat_id){
					$data=array("job_id"=>$last_id,"category_id"=>$cat_id);
					$db->Insert($data,"tbljobcategories");	
				}
			}
			
			if(!empty($tags)){
				foreach($tags as $tag_id){
					$data=array("job_id"=>$last_id,"tag_id"=>$tag_id);
					$db->Insert($data,"tbljobtags");	
				}
			}
			
			
			//die;
			$_SESSION['mt'] = "success";
			$_SESSION['me'] = "'{$jobname}' added successfully.";
			header('Location:main.php?pg=viewjobs');
			exit;
	}
	else{	
		$_SESSION['mt'] = "error";
		$_SESSION['me'] = "Enter Valid Data.";
		header('Location:main.php?pg=viewjobs');
		exit;
	}	
}
// Modify Section :: Modify data into database
if($act == "mod"){	
	if($jobname != "" || $price != '' || $description != ''){
			
		$data = array('job_user_id'=>$user_id,'job_name'=>$jobname,'job_description'=>$description,'price'=>$price,'job_days'=>$days,'job_hours'=>$hours,'start_date'=>$start_date,'riskmeter'=>$riskmeter,'latitude'=>$latitude,'longitude'=>$longitude,'address1'=>$address_1,'address2'=>$address_2,'postalcode'=>$postal_code,'country_id'=>$country_id,'state_id'=>$state_id,'city_id'=>$city_id,'transport_link'=>$transportlink ,'dresscode'=>$dresscode_description,'status'=>$status,'created_date'=>date('Y-m-d H:i:s'),'isfeatured'=>$is_featured);
		
		
		$rmavatar=isset($_REQUEST["rmavatar"])?stripslashes($_REQUEST["rmavatar"]):"0";
		$job_image = '';
		if($rmavatar==1 || $newfilename!='')
		{
			$rmimage=isset($_REQUEST["rmimage"])?stripslashes($_REQUEST["rmimage"]):"";
			@unlink(JOBS_IMG_PATH.$rmimage);
			@unlink(JOBS_IMG_PATH.'th_'.$rmimage);
			$job_image = $newfilename;
			$imageArray = array('image'=>$job_image);
			$data = array_merge($data,$imageArray);
		}
		
		
		$where ="job_id ={$a_id}";
	
		$db->Update($data,"tbljobs",$where);	
		
		if(!empty($categories)){
			$db->Delete("tbljobcategories",$where);
			foreach($categories as $cat_id){
				$data=array("job_id"=>$a_id,"category_id"=>$cat_id);
				$db->Insert($data,"tbljobcategories");	
			}
		}
		
		if(!empty($tags)){			
			$db->Delete("tbljobtags",$where);
			foreach($tags as $tag_id){
				$data=array("job_id"=>$a_id,"tag_id"=>$tag_id);
				$db->Insert($data,"tbljobtags");	
			}
		}
		
		$_SESSION['mt'] = "success";
		$_SESSION['me'] = "Job Updated Successfully.";
		header('Location:main.php?pg=viewjobs');
		exit;
	} else	{	
		$_SESSION['mt'] = "error";
		$_SESSION['me'] = "Please enter valid data.";
		header('Location:main.php?pg=viewjobs');
		exit;
	}	
	
}
?>
<form name="frmAction" action="main.php?pg=viewcustomer" method="post">
<input type="hidden" name="msg" value="<?php echo $msg; ?>">
<script language="javascript" type="text/javascript">
	document.frmAction.submit();
</script>
</form>