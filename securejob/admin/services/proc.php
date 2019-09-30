<?php 
if(!in_array(3,$tes_mod)) { 
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
//print_r ($_REQUEST); exit;

// Set All  data here
$jobname =	isset($_REQUEST["jobname"])?$_REQUEST["jobname"]:'';
$description =	isset($_REQUEST["description"])?$_REQUEST["description"]:'';
$instruction =	isset($_REQUEST["instruction"])?$_REQUEST["instruction"]:'';
$user_id =	isset($_REQUEST["user_id"])?$_REQUEST["user_id"]:'';

$is_featured = 	isset($_REQUEST["is_featured"])?$_REQUEST["is_featured"]:0;
$status = 	isset($_REQUEST["status"])?$_REQUEST["status"]:0;
$price = 	isset($_REQUEST["price"])?$_REQUEST["price"]:0;

$weekend_day_price = 	isset($_REQUEST["weekend_day_price"])&&$_REQUEST["weekend_day_price"]!=''?$_REQUEST["weekend_day_price"]:0;
$weekend_night_price = 	isset($_REQUEST["weekend_night_price"])&&$_REQUEST["weekend_night_price"]!=''?$_REQUEST["weekend_night_price"]:0;
$holiday_price = 	isset($_REQUEST["holiday_price"])&&$_REQUEST["holiday_price"]!=''?$_REQUEST["holiday_price"]:0;

$hours = 	isset($_REQUEST["hours"])?$_REQUEST["hours"]:0;
$days = 	isset($_REQUEST["days"])?$_REQUEST["days"]:0;
$start_date = 	isset($_REQUEST["start_date"])?date('Y-m-d H:i:s',strtotime($_REQUEST["start_date"])):'';
$riskmeter = 	isset($_REQUEST["riskmeter"])?$_REQUEST["riskmeter"]:'';
$categories = 	isset($_REQUEST["categories"])?$_REQUEST["categories"]:'';
$tags = 	isset($_REQUEST["tags"])?$_REQUEST["tags"]:'';
$availability = 	isset($_REQUEST["availability"])?$_REQUEST["availability"]:0;

$willing_to_travel = 	isset($_REQUEST["willing_to_travel"])&&$_REQUEST["willing_to_travel"]!=''?$_REQUEST["willing_to_travel"]:'';

$do_you_drive = 	isset($_REQUEST["do_you_drive"])&&$_REQUEST["do_you_drive"]!=''?$_REQUEST["do_you_drive"]:0;
$nationality = 	isset($_REQUEST["nationality"])?$_REQUEST["nationality"]:'';
$languages_spoken = 	isset($_REQUEST["languages_spoken"])?$_REQUEST["languages_spoken"]:'';

$latitude = 	isset($_REQUEST["latitude"])?$_REQUEST["latitude"]:'';
$longitude = 	isset($_REQUEST["longitude"])?$_REQUEST["longitude"]:'';
$address_1 = 	isset($_REQUEST["address_1"])?$_REQUEST["address_1"]:'';
$address_2 = 	isset($_REQUEST["address_2"])?$_REQUEST["address_2"]:'';
$postal_code = 	isset($_REQUEST["postal_code"])?$_REQUEST["postal_code"]:'';
$country_id =	isset($_REQUEST["country_id"])?$_REQUEST["country_id"]:0;
$state_id =	isset($_REQUEST["state_id"])?$_REQUEST["state_id"]:0;
$city_id =	isset($_REQUEST["city_id"])?$_REQUEST["city_id"]:0;

$transportlink = 	isset($_REQUEST["transportlink"])?$_REQUEST["transportlink"]:'';
$dresscode_description = 	isset($_REQUEST["dresscode_description"])?$_REQUEST["dresscode_description"]:'';

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
		
		$newFilePath = SERVICES_IMG_PATH . $newfilename;
		//$newFileURL = POST_IMG_URL . $newfilename;
		
		//Upload the file into the temp dir
		if(move_uploaded_file($tmpFilePath, $newFilePath))
		{
			$path2=SERVICES_IMG_PATH;
			//$resizeObj = new resize(USER_PROFILE_IMG_PATH.$newfilename);
			//$resizeObj->resizeImage(780, 780, 'exact');
			//$resizeObj->saveImage("$path2/$newfilename", 100);
			
			$resizeObj1 = new resize(SERVICES_IMG_PATH.$newfilename);
			$resizeObj1->resizeImage(150, 150, 'exact');
			$resizeObj1->saveImage("$path2/$newthumbfilename", 100);
		}
		
	}
}

// Add Section :: Add Data into database
if($act == "add"){	

	 if($jobname != "" || $price != ''){
			$job_image = '';
			if($newfilename!='')
			{
				$job_image = $newfilename;
			}
	
			$data = array('service_user_id'=>$user_id,'service_name'=>$jobname,'service_description'=>$description,'service_instruction'=>$instruction,'weekend_day_price'=>$weekend_day_price,'weekend_night_price'=>$weekend_night_price,'holiday_price'=>$holiday_price,'availability'=>$availability,'willing_to_travel'=>$willing_to_travel,'drive'=>$do_you_drive,'nationality'=>$nationality,'languages_spoken'=>$languages_spoken,'price'=>$price,'image'=>$job_image,'service_days'=>$days,'service_hours'=>$hours,'latitude'=>$latitude,'longitude'=>$longitude,'address1'=>$address_1,'address2'=>$address_2,'postalcode'=>$postal_code,'city_id'=>$city_id,'state_id'=>$state_id,'country_id'=>$country_id,'isfeatured'=>$is_featured,'isactive'=>$status,'created_date'=>date('Y-m-d H:i:s'));
			
			$db->Insert($data,"tblservices");
			
			$last_id = mysql_insert_id();
			
			if(!empty($categories)){
				foreach($categories as $cat_id){
					$data=array("service_id"=>$last_id,"category_id"=>$cat_id);
					$db->Insert($data,"tblservicescatgories");	
				}
			}
			
			if(!empty($tags)){
				foreach($tags as $tag_id){
					$data=array("service_id"=>$last_id,"tag_id"=>$tag_id);
					$db->Insert($data,"tblservicestags");	
				}
			}
			
			
			//die;
			$_SESSION['mt'] = "success";
			$_SESSION['me'] = "'{$jobname}' added successfully.";
			header('Location:main.php?pg=viewservices');
			exit;
	}
	else{	
		$_SESSION['mt'] = "error";
		$_SESSION['me'] = "Enter Valid Data.";
		header('Location:main.php?pg=viewservices');
		exit;
	}	
}
// Modify Section :: Modify data into database
if($act == "mod"){	
	if($jobname != "" || $price != '' || $description != ''){
			
		$data = array('service_user_id'=>$user_id,'service_name'=>$jobname,'service_description'=>$description,'service_instruction'=>$instruction,'price'=>$price,'weekend_day_price'=>$weekend_day_price,'weekend_night_price'=>$weekend_night_price,'holiday_price'=>$holiday_price,'service_days'=>$days,'service_hours'=>$hours,'availability'=>$availability,'willing_to_travel'=>$willing_to_travel,'drive'=>$do_you_drive,'nationality'=>$nationality,'languages_spoken'=>$languages_spoken,'latitude'=>$latitude,'longitude'=>$longitude,'address1'=>$address_1,'address2'=>$address_2,'postalcode'=>$postal_code,'city_id'=>$city_id,'state_id'=>$state_id,'country_id'=>$country_id,'isactive'=>$status,'created_date'=>date('Y-m-d H:i:s'),'isfeatured'=>$is_featured);
		
		
		$rmavatar=isset($_REQUEST["rmavatar"])?stripslashes($_REQUEST["rmavatar"]):"0";
		$job_image = '';
		if($rmavatar==1 || $newfilename!='')
		{
			$rmimage=isset($_REQUEST["rmimage"])?stripslashes($_REQUEST["rmimage"]):"";
			@unlink(SERVICES_IMG_PATH.$rmimage);
			@unlink(SERVICES_IMG_PATH.'th_'.$rmimage);
			$job_image = $newfilename;
			$imageArray = array('image'=>$job_image);
			$data = array_merge($data,$imageArray);
		}
		
		
		$where ="service_id ={$a_id}";
	
		$db->Update($data,"tblservices",$where);	
		
		if(!empty($categories)){
			$db->Delete("tblservicescatgories",$where);
			foreach($categories as $cat_id){
				$data=array("service_id"=>$a_id,"category_id"=>$cat_id);
				$db->Insert($data,"tblservicescatgories");	
			}
		}
		
		if(!empty($tags)){			
			$db->Delete("tblservicestags",$where);
			foreach($tags as $tag_id){
				$data=array("service_id"=>$a_id,"tag_id"=>$tag_id);
				$db->Insert($data,"tblservicestags");	
			}
		}
		
		$_SESSION['mt'] = "success";
		$_SESSION['me'] = "Service Updated Successfully.";
		header('Location:main.php?pg=viewservices');
		exit;
	} else	{	
		$_SESSION['mt'] = "error";
		$_SESSION['me'] = "Please enter valid data.";
		header('Location:main.php?pg=viewservices');
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