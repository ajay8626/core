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

// Set All  data here
$a_name =	isset($_REQUEST["fname"])?$_REQUEST["fname"]:''; 
$a_lname =	isset($_REQUEST["lname"])?$_REQUEST["lname"]:''; 
//$country_id =	isset($_REQUEST["country_id"])?$_REQUEST["country_id"]:0; 
$state_id =	isset($_REQUEST["state_id"])?$_REQUEST["state_id"]:0; 
$city_id =	isset($_REQUEST["city_id"])?$_REQUEST["city_id"]:0; 
//$customer_type =	$_REQUEST["customer_type"]; 

$status = 	isset($_REQUEST["status"])?$_REQUEST["status"]:0;
$verifiedUser = 	isset($_REQUEST["verifiedUser"])?$_REQUEST["verifiedUser"]:0;
$a_email = 	isset($_REQUEST["email"])?$_REQUEST["email"]:'';  
$phone = 	isset($_REQUEST["phone"])?$_REQUEST["phone"]:'';  
$address_1 = 	isset($_REQUEST["address_1"])?$_REQUEST["address_1"]:'';  
$address_2 = 	isset($_REQUEST["address_2"])?$_REQUEST["address_2"]:'';  
$address_3 = 	isset($_REQUEST["address_3"])?$_REQUEST["address_3"]:'';  
$postal_code = 	isset($_REQUEST["postal_code"])?$_REQUEST["postal_code"]:'';

$user_type = 	isset($_REQUEST["user_type"])?$_REQUEST["user_type"]:'';  
$company_name = 	isset($_REQUEST["company_name"])?$_REQUEST["company_name"]:'';
$registration_no = 	isset($_REQUEST["registration_no"])?$_REQUEST["registration_no"]:'';  
$vat_registration_no = 	isset($_REQUEST["vat_registration_no"])?$_REQUEST["vat_registration_no"]:'';  
$bank_name = 	isset($_REQUEST["bank_name"])?$_REQUEST["bank_name"]:'';  
$acc_holder_name = 	isset($_REQUEST["acc_holder_name"])?$_REQUEST["acc_holder_name"]:''; 
$sort_code = 	isset($_REQUEST["sort_code"])?$_REQUEST["sort_code"]:'';  
$acc_number = 	isset($_REQUEST["acc_number"])?$_REQUEST["acc_number"]:'';  
$birthdate = 	isset($_REQUEST["birthdate"])&&$_REQUEST["birthdate"]!=''?$_REQUEST["birthdate"]:'';
$gender = 	isset($_REQUEST["gender"])?$_REQUEST["gender"]:0;
$height = 	isset($_REQUEST["height"])?$_REQUEST["height"]:'';
$build = 	isset($_REQUEST["build"])?$_REQUEST["build"]:'';
$nationality = 	isset($_REQUEST["nationality"])?$_REQUEST["nationality"]:0;
$language = 	isset($_REQUEST["language"])? implode(",",$_REQUEST["language"]):'';
$militry = 	isset($_REQUEST["militry"])?$_REQUEST["militry"]:0;
$drive = 	isset($_REQUEST["drive"])?$_REQUEST["drive"]:0;
$firstaid = 	isset($_REQUEST["firstaid"])?$_REQUEST["firstaid"]:0;
$tattoos = 	isset($_REQUEST["tattoos"])?$_REQUEST["tattoos"]:0;
$piercing = 	isset($_REQUEST["piercing"])?$_REQUEST["piercing"]:0;
$cscs_card = 	isset($_REQUEST["cscs_card"])?$_REQUEST["cscs_card"]:0;
$right_to_work_uk = 	isset($_REQUEST["right_to_work_uk"])?$_REQUEST["right_to_work_uk"]:0;
$willing_to_travel = 	isset($_REQUEST["willing_to_travel"])?$_REQUEST["willing_to_travel"]:0;
$uk_driving_license = 	isset($_REQUEST["uk_driving_license"])?$_REQUEST["uk_driving_license"]:0;
$sia = 	isset($_REQUEST["sia"])?$_REQUEST["sia"]:0;
$activity = 	isset($_REQUEST["activity"])?$_REQUEST["activity"]:'';
$health = 	isset($_REQUEST["health"])?$_REQUEST["health"]:0;
$bio = 	isset($_REQUEST["bio"])?$_REQUEST["bio"]:0;
$experience = 	isset($_REQUEST["experience"])?$_REQUEST["experience"]:'';
$education_credentials = 	isset($_REQUEST["education_credentials"])?$_REQUEST["education_credentials"]:'';

$address='';
if($address_1!='')
{
	$address .=$address_1.",";
}
if($address_2!='')
{
	$address .=$address_2.",";
}
if($address_3!='')
{
	$address .=$address_3.",";
}
if($state_id!='')
{
	$address .=getStateName($state_id).",";
}
if($city_id!='')
{
	$address .=getCityName($city_id).",";
}


	
 
if($birthdate!='')
{
	$birth_ex=explode("/",$birthdate);
	$birthdate=$birth_ex[2]."-".$birth_ex[1]."-".$birth_ex[0];
}
else
{
	$birthdate='1970-01-01';
}	

//$postal_code = 	isset($_REQUEST["postal_code"])?$_REQUEST["postal_code"]:'';    
//$leads = 	0;    
$device_type = 	isset($_REQUEST["device_type"])?$_REQUEST["device_type"]:'';    
	$newfilename='';
	$newFilePath='';
	$newFileURL='';
	if($_FILES['profileimage']['name']!='')
	{
		$tmpFilePath = $_FILES['profileimage']['tmp_name'];
		if ($tmpFilePath != ""){
			$path = $_FILES['profileimage']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			$randname=rand(111111,999999);
			$newfilename =$randname.".".$ext;
			$newthumbfilename = "th_".$randname.".".$ext;
			$newFilePath = CUSTOMER_PROFILE_IMG_PATH . $newfilename;
			if(move_uploaded_file($tmpFilePath, $newFilePath))
			{
				$path2=CUSTOMER_PROFILE_IMG_PATH;
				$resizeObj1 = new resize(CUSTOMER_PROFILE_IMG_PATH.$newfilename);
				$resizeObj1->resizeImage(150, 150, 'exact');
				$resizeObj1->saveImage("$path2/$newthumbfilename", 100);
			}
			
		}
	}
	
	$newfilename1='';
	$newFilePath1='';
	$newFileURL1='';
	if($_FILES['profilevideo']['name']!='')
	{
		$tmpFilePath1 = $_FILES['profilevideo']['tmp_name'];
		if ($tmpFilePath1 != ""){
			$path1 = $_FILES['profilevideo']['name'];
			$ext1 = pathinfo($path1, PATHINFO_EXTENSION);
			$randname1=rand(111111,999999);
			$newfilename1 =$randname1.".".$ext1;
			$newFilePath1 = CUSTOMER_PROFILE_VIDEO_PATH . $newfilename1;
			move_uploaded_file($tmpFilePath1, $newFilePath1);
		}
	}

// Add Section :: Add Data into database
if($act == "add"){	

	 if($a_email != ""){			
			$totRows = 0;
			$sql = "select * from tbluser where email = '{$a_email}'";
			$totRows = mysql_num_rows($db->Query($sql));
			if($totRows >0){	
				$_SESSION['mt'] = "error";
				$_SESSION['me'] = "Email Address '{$a_email}' Already Exists.";
				header('Location:main.php?pg=viewuser');
				exit;
			}
			else
			{ 
				$profile_image = '';
				if($newfilename!='')
				{
					$profile_image = $newfilename;
				}
				
				$profile_video = '';
				if($newfilename1!='')
				{
					$profile_video = $newfilename1;
				}
				
				if($address!='')
				{
					$address=substr($address,0,-1);
				}
				$latlong    =   get_lat_long($address);
				$map        =   explode(',' ,$latlong);
			    $mapLat     =   $map[0];
			    $mapLong    =   $map[1];
		
				$pass  =  	md5($_REQUEST['password']);
				$data = array('firstname'=>$a_name,'lastname'=>$a_lname,'password'=>$pass,'phone'=>$phone,'email'=>$a_email,'address_1'=>$address_1,'address_2'=>$address_2,'address_3'=>$address_3,'postal_code'=>$postal_code,'status'=>$status,'created_date'=>date('Y-m-d H:i:s'),'profile_image'=>$profile_image,'customer_type'=>$user_type,'bank_name'=>$bank_name,'acc_holder_name'=>$acc_holder_name,'sort_code'=>$sort_code,'acc_number'=>$acc_number,'reg_no'=>$registration_no,'reg_vat_no'=>$vat_registration_no,'company_name'=>$company_name,'profilevideo'=>$newfilename1,'city_id'=>$city_id,'state_id'=>$state_id,'birthdate'=>$birthdate,'gender'=>$gender,'height'=>$height,'build'=>$build,'nationality'=>$nationality,'language'=>$language,'militry'=>$militry,'drive'=>$drive,'firstaid'=>$firstaid,'tattoos'=>$tattoos,'piercing'=>$piercing,'cscs_card'=>$cscs_card,'right_to_work_uk'=>$right_to_work_uk,'willing_to_travel'=>$willing_to_travel,'uk_driving_license'=>$uk_driving_license,'sia'=>$sia,'activity'=>$activity,'health'=>$health,'bio'=>$bio,'experience'=>$experience,'education_credentials'=>$education_credentials,'latitude'=>$mapLat,'longitude'=>$mapLong);
				$db->Insert($data,"tbluser");
				
				$a_nameZ=$a_name.' '.$a_lname;
			    $last_id = mysql_insert_id();
					
				//die;
				$_SESSION['mt'] = "success";
				$_SESSION['me'] = "User '{$a_nameZ}' added successfully.";
				header('Location:main.php?pg=viewuser');
				exit;
			}                 
	}
	else{	
		$_SESSION['mt'] = "error";
		$_SESSION['me'] = "Enter Valid User Email/ID.";
		header('Location:main.php?pg=viewuser');
		exit;
	}	
}
// Modify Section :: Modify data into database
if($act == "mod"){	
	if ( ($a_id != "")  && ($a_email != "") ){
		$totRows = 0;
		$sql = "select * from tbluser where email = '{$a_email}' and user_id  <> {$a_id}";
		$totRows = mysql_num_rows($db->Query($sql));
		if($totRows < 0){	
			$_SESSION['mt'] = "error";
			$_SESSION['me'] = "Email Address '{$a_email}' Already Exists.";
			header('Location:main.php?pg=viewuser');
			exit;
		}
		else{
			
			    if($address!='')
				{
					$address=substr($address,0,-1);
				}
				
				$latlong    =   get_lat_long($address); 
				$map        =   explode(',' ,$latlong);
			    $mapLat     =   $map[0];
			    $mapLong    =   $map[1];
				
			
			$data = array(
				'firstname'=>$a_name,
				'lastname'=>$a_lname,
				'phone'=>$phone,
				'email'=>$a_email,
				'address_1'=>$address_1,
				'address_2'=>$address_2,
				'address_3'=>$address_3,
				'postal_code'=>$postal_code,
				'status'=>$status,
				'modified_date'=>date('Y-m-d H:i:s'),
				'bank_name'=>$bank_name,
				'acc_holder_name'=>$acc_holder_name,
				'sort_code'=>$sort_code,
				'acc_number'=>$acc_number,
				'reg_no'=>$registration_no,
				'reg_vat_no'=>$vat_registration_no,
				'company_name'=>$company_name,
				'city_id'=>$city_id,
				'state_id'=>$state_id,
				'birthdate'=>$birthdate,
				'gender'=>$gender,
				'height'=>$height,
				'build'=>$build,
				'nationality'=>$nationality,
				'language'=>$language,
				'militry'=>$militry,
				'drive'=>$drive,
				'firstaid'=>$firstaid,
				'tattoos'=>$tattoos,
				'piercing'=>$piercing,
				'cscs_card'=>$cscs_card,
				'right_to_work_uk'=>$right_to_work_uk,
				'willing_to_travel'=>$willing_to_travel,
				'uk_driving_license'=>$uk_driving_license,
				'activity'=>$activity,
				'health'=>$health,
				'bio'=>$bio,
				'experience'=>$experience,
				'education_credentials'=>$education_credentials,
				'latitude'=>$mapLat,
				'longitude'=>$mapLong, 
				'verified_user' => $verifiedUser
			);
			
			
			$rmavatar=isset($_REQUEST["rmavatar"])?stripslashes($_REQUEST["rmavatar"]):"0";
			$rmavatarvideo=isset($_REQUEST["rmavatarvideo"])?stripslashes($_REQUEST["rmavatarvideo"]):"0";
			$profile_image = '';
			if($rmavatar==1 || $newfilename!='')
			{
				$rmimage=isset($_REQUEST["rmimage"])?stripslashes($_REQUEST["rmimage"]):"";
				@unlink(CUSTOMER_PROFILE_IMG_PATH.$rmimage);
				@unlink(CUSTOMER_PROFILE_IMG_PATH.'th_'.$rmimage);
				$profile_image = $newfilename;
				$imageArray = array('profile_image'=>$profile_image);
				$data = array_merge($data,$imageArray);
			}
			if($rmavatarvideo==1 || $newfilename1!='')
			{
				$rmvideo=isset($_REQUEST["rmvideo"])?stripslashes($_REQUEST["rmvideo"]):"";
				@unlink(CUSTOMER_PROFILE_VIDEO_PATH.$rmvideo);
				//@unlink(CUSTOMER_PROFILE_VIDEO_PATH.'th_'.$rmvideo);
				$profilevideo = $newfilename1;
				$videoArray = array('profilevideo'=>$profilevideo);
				$data = array_merge($data,$videoArray);
			}
			
			
			if($_REQUEST['password'] != ''){
				$password  = md5($_REQUEST['password']);	
				
				$pwd = array('password'=>$password);
				$data = array_merge($data,$pwd);
			}

			if ($sia != 0 || $sia != '') {
				$sql_badge_type="select * from tbl_siabadge_type  where user_id={$a_id}";
				$fee_sql = mysql_query($sql_badge_type);
				$sql_badge_rows=mysql_num_rows($fee_sql);			
				if ($sql_badge_rows == 0) {
					foreach($sia as $badge_type){
						$data_badge= array('user_id'=>$a_id,'badge_type'=>$badge_type);
						$db->Insert($data_badge,"tbl_siabadge_type");
					}
				} else {
					$delete_sia= mysql_query("DELETE FROM `tbl_siabadge_type` WHERE `user_id` = $a_id");		
					foreach($sia as $badge_type){
						$data_badge= array('user_id'=>$a_id,'badge_type'=>$badge_type);
						$db->Insert($data_badge,"tbl_siabadge_type");
					}				
					
				}
			}
			
			$where ="user_id ={$a_id}";
		
			$db->Update($data,"tbluser",$where);	
			
			$_SESSION['mt'] = "success";
			$_SESSION['me'] = "User Updated Successfully.";
			header('Location:main.php?pg=viewuser');
			exit;
		}
	} else	{	
		$_SESSION['mt'] = "error";
		$_SESSION['me'] = "Customer Data Invalid.";
		header('Location:main.php?pg=viewuser');
		exit;
	}	
	
}		
// Delete Section :: Delete data from database
if($act == "del"){ 
	if(is_numeric($a_id) && $a_id > 0){	
		$where = "id  = {$a_id}";
		if($db->Delete("tbluser",$where)){
			$_SESSION['mt'] = "success";
			$_SESSION['me'] = "Customer user deleted successfully.";
			header('Location:main.php?pg=viewcustomer');
			exit;
		}else{
			$_SESSION['mt'] = "error";
			$_SESSION['me'] = "Error while delete admin Customer. Please try again.";
			header('Location:main.php?pg=viewcustomer');
			exit;
		}
	}

}
else{
	$_SESSION['mt'] = "error";
	$_SESSION['me'] = "Invalid ID/Name.";
	header('Location:main.php?pg=viewcustomer');
	exit;	
}	


?>
<form name="frmAction" action="main.php?pg=viewcustomer" method="post">
<input type="hidden" name="msg" value="<?php echo $msg; ?>">
<script language="javascript" type="text/javascript">
	document.frmAction.submit();
</script>
</form>