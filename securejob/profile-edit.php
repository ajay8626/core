<?php 
include "config.php"; 
include "check_user_login.php";
include_once(ADMIN_PATH."inc/resize-class.php");

$customer_type=isset($_SESSION['customer_type']) ? $_SESSION['customer_type'] : 0;
$activetitle='';
if($customer_type==1)
{
    $activetitle='Business User';
}
if($customer_type==2)
{
    $activetitle='Personal User';
}


if (isset($_POST['method'])) {	
	$new_password = $_POST['new_password'];
	$password_change = md5($new_password);
	$update_data = array('password' => $password_change);
	$where ="user_id ={$_SESSION['user_id']}";
	$update = $db->Update($update_data,"tbluser",$where);
	if ($update == true) {
		$response_data = array('status' => 1,'msg' => "Password Update Successfully!" );
		echo json_encode($response_data);
		exit();
	}else {
		$response_data = array('status' => 0,'msg' => "Password Not Update Successfully!" );
		echo json_encode($response_data);
		exit();
	}

}



if(isset($_SESSION['user_id']) && $_SESSION['user_id']!='')
{
    $sql="select tbluser.* from tbluser  where tbluser.user_id=".$_SESSION['user_id']."";
    
    $exc=$db->Query($sql);
    $totRows = mysql_num_rows($exc);
    $rows=mysql_fetch_array($exc);
    $c_name=$rows['company_name'];
    $first_name=$rows['firstname'];
    $lastname=$rows['lastname'];
    $phone=$rows['phone'];
    $address_1=$rows['address_1'];
    $address_2=$rows['address_2'];
    $address_3=$rows['address_3'];
    $post_code=$rows['postal_code'];
    $pwd = $rows['password'];
    $bank_name=$rows['bank_name'];
    $acc_holder_name=$rows['acc_holder_name'];
    $sort_code=$rows['sort_code'];
    $acc_number=$rows['acc_number'];
    $reg_no=$rows['reg_no'];
    $reg_vat_no=$rows['reg_vat_no'];
    $user_email=$rows['email'];
    $profile_image=$rows['profile_image'];
    $profilevideo=$rows['profilevideo'];
    $birthdate=$rows['birthdate'];
    $gender=$rows['gender'];
    $height=$rows['height'];
    $nationality=$rows['nationality'];
    $build=$rows['build'];
    $language=$rows['language'];
    $total_credit=$rows['total_credit'];
    $is_email_verify=$rows['is_email_verify'];
    $isSocial=$rows['isSocial'];
    $militry=$rows['militry'];
    $drive=$rows['drive'];
    $firstaid=$rows['firstaid'];
    $tattoos=$rows['tattoos'];
    $piercing=$rows['piercing'];
    $right_to_work_uk=$rows['right_to_work_uk'];
    $willing_to_travel=$rows['willing_to_travel'];
    $how_far = $rows['how_far_willing_to_travel'];
    $uk_driving_license=$rows['uk_driving_license'];
    $cscs_card=$rows['cscs_card'];
    $sia=$rows['sia'];
    $sia_1 = $rows['sia_1'];
    $sia_2 = $rows['sia_2'];
    $sia_3 = $rows['sia_3'];
    $sia_4 = $rows['sia_4'];
    $activity=$rows['activity'];
    $health=$rows['health'];
    $bio=$rows['bio'];
    $experience=$rows['experience'];
    $education_credentials=$rows['education_credentials'];
    $state_id=$rows['state_id'];
    $city_id=$rows['city_id'];
    $paypal_email=$rows['paypal_email'];
    $paremedic=$rows['paremedic'];
    //echo "SELECT * FROM tblcities WHERE state_id=".$state_id." ORDER By name ASC"; exit();
    $date = '';
    if($birthdate != '' && $birthdate != '1970-01-01')
    {
        $dob_parts=explode("-",$birthdate);
        $dobDate = $dob_parts[2];
        $dobMonth = $dob_parts[1]; 
        $dobYear = $dob_parts[0];
    }
    $sql_badge_type="select * from tbl_siabadge_type  where user_id=".$_SESSION['user_id']."";
    
    $exc_badge_type=$db->Query($sql_badge_type);
    while($rows_badge_type=mysql_fetch_array($exc_badge_type)){
        $badge_type[]=$rows_badge_type['badge_type'];
    }	
}
	
if(isset($_POST['submit']) && $_POST['submit']!='')
{
	$a_name =	isset($_REQUEST["fname"])?$_REQUEST["fname"]:''; 
	$a_lname =	isset($_REQUEST["lname"])?$_REQUEST["lname"]:''; 
	//$country_id =	isset($_REQUEST["country_id"])?$_REQUEST["country_id"]:0; 
	$state_id =	isset($_REQUEST["state_id"])?$_REQUEST["state_id"]:0; 
	$city_id =	isset($_REQUEST["city_id"])?$_REQUEST["city_id"]:0; 
	/* echo $city_id; exit; */
	//$customer_type =	$_REQUEST["customer_type"]; 

	$status = 	isset($_REQUEST["status"])?$_REQUEST["status"]:0;
	$a_email = 	isset($_REQUEST["email"])?$_REQUEST["email"]:'';  
	$phone = 	isset($_REQUEST["phone"])?$_REQUEST["phone"]:'';  
	$address_1 = 	isset($_REQUEST["address_1"])?$_REQUEST["address_1"]:'';  
	$address_2 = 	isset($_REQUEST["address_2"])?$_REQUEST["address_2"]:'';  
	$address_3 = 	isset($_REQUEST["address_3"])?$_REQUEST["address_3"]:'';
	$post_code = 	isset($_REQUEST["postcode"])?$_REQUEST["postcode"]:'';  
	$user_type = 	isset($_REQUEST["user_type"])?$_REQUEST["user_type"]:'';  
	$company_name = 	isset($_REQUEST["company_name"])?$_REQUEST["company_name"]:'';
	$registration_no = 	isset($_REQUEST["registration_no"])?$_REQUEST["registration_no"]:'';  
	$vat_registration_no = 	isset($_REQUEST["vat_registration_no"])?$_REQUEST["vat_registration_no"]:'';  
	$bank_name = 	isset($_REQUEST["bank_name"])?$_REQUEST["bank_name"]:'';  
	$acc_holder_name = 	isset($_REQUEST["acc_holder_name"])?$_REQUEST["acc_holder_name"]:''; 
	$sort_code = 	isset($_REQUEST["sort_code"])?$_REQUEST["sort_code"]:'';  
	$acc_number = 	isset($_REQUEST["acc_number"])?$_REQUEST["acc_number"]:'';  
	//$birthdate = 	isset($_REQUEST["birthdate"])&&$_REQUEST["birthdate"]!=''?$_REQUEST["birthdate"]:'';
	$dobday = isset($_REQUEST["dobday"])?$_REQUEST["dobday"]:'';
	$dobmonth = isset($_REQUEST["dobmonth"])?$_REQUEST["dobmonth"]:'';
	$dobyear = isset($_REQUEST["dobyear"])?$_REQUEST["dobyear"]:'';
	$birthdate = $dobday.'/'.$dobmonth.'/'.$dobyear;
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
	$right_to_work_uk = 	isset($_REQUEST["right_to_work_uk"])?$_REQUEST["right_to_work_uk"]:0;
	$willing_to_travel = 	isset($_REQUEST["willing_to_travel"])?$_REQUEST["willing_to_travel"]:0;
	$how_far = 	isset($_REQUEST["how_far"])?$_REQUEST["how_far"]:'';
	$uk_driving_license = 	isset($_REQUEST["uk_driving_license"])?$_REQUEST["uk_driving_license"]:0;
	$cscs_card = 	isset($_REQUEST["cscs_card"])?$_REQUEST["cscs_card"]:0;
	$badge_types = 	isset($_REQUEST["badge_type"])?$_REQUEST["badge_type"]:0;
	$sia = 	isset($_REQUEST["sia"])?$_REQUEST["sia"]:0;
	if($sia == 1){
		$sia_1 = $_REQUEST["sia_1"];
		$sia_2 = $_REQUEST["sia_2"];
		$sia_3 = $_REQUEST["sia_3"];
		$sia_4 = $_REQUEST["sia_4"];
	}else{
		$sia_1 = '';
		$sia_2 = '';
		$sia_3 = '';
		$sia_4 = '';
	}
	
	$activity = isset($_REQUEST["activity"])?$_REQUEST["activity"]:'';
	$health = isset($_REQUEST["health"])?$_REQUEST["health"]:0;
	$bio = 	isset($_REQUEST["bio"])?$_REQUEST["bio"]:0;
	$experience = 	isset($_REQUEST["experience"])?$_REQUEST["experience"]:0;
	$education_credentials = 	isset($_REQUEST["education_credentials"])?$_REQUEST["education_credentials"]:0;
	$paypal_email = isset($_REQUEST["paypal_email"])?$_REQUEST["paypal_email"]:'';

	$paremedic = isset($_REQUEST["paremedic"])?$_REQUEST["paremedic"]:0;
	
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

	if($birthdate == '--'){
		$birthdate='1970-01-01';
	}else{
		$birthdate=$birthdate;
	}

	/* Profile Image */
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
	
	/* Profile Video */
	$newfilename1='';
	$newFilePath1='';
	$newFileURL1='';
	$aaa = $_POST['saveprofileimage'];

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

	/* Upload Certificate */
	$newfilenamecerti = '';
	$newFilePathcerti = '';
	$certiFiles = array();
	$total = count($_FILES['certificate']['name']);
	for( $i=0 ; $i < $total ; $i++ ) {
		if($_FILES['certificate']['name'][$i]!='')
		{
			$tmpFilePathcerti = $_FILES['certificate']['tmp_name'][$i];
			if ($tmpFilePathcerti != ""){
				$pathcerti = $_FILES['certificate']['name'][$i];
				$extcerti = pathinfo($pathcerti, PATHINFO_EXTENSION);
				$randnamecerti=rand(111111,999999);
				$newfilenamecerti = $randnamecerti.".".$extcerti;
				$newFilePathcerti = CUSTOMER_CERTIFICATE_IMG_PATH.$newfilenamecerti;
				$certiFiles[] = $newfilenamecerti;
				move_uploaded_file($tmpFilePathcerti, $newFilePathcerti);
			}
		}
	}
	
	foreach($certiFiles as $certiFile){
		if($certiFile !=''){
			$mimeType = pathinfo($certiFile, PATHINFO_EXTENSION);
			$certiName = $certiFile;
			$userId = $_SESSION['user_id'];

			$certiData = array(
				'user_id' => $userId,
				'certificate' => $certiName,
				'certi_mime' => $mimeType
			);

			/* Insert Certi into User Certi table */
			$insertCerti = $db->Insert($certiData, 'tbl_user_certi');
		}
    }
    
    /* Upload Sia Badge */
	$newfilenameSiaBadge = '';
	$newFilePathSiaBadge = '';
	$SiaBadgeFiles = array();
	$total = count($_FILES['siabadge']['name']);
	for( $i=0 ; $i < $total ; $i++ ) {
		if($_FILES['siabadge']['name'][$i]!='')
		{
			$tmpFilePathSiaBadge = $_FILES['siabadge']['tmp_name'][$i];
			if ($tmpFilePathSiaBadge != ""){
				$pathSiaBadge = $_FILES['siabadge']['name'][$i];
				$extSiaBadge = pathinfo($pathSiaBadge, PATHINFO_EXTENSION);
				$randnameSiaBadge=rand(111111,999999);
				$newfilenameSiaBadge = $randnameSiaBadge.".".$extSiaBadge;
				$newFilePathSiaBadge = CUSTOMER_SIABADGE_IMG_PATH.$newfilenameSiaBadge;
				$SiaBadgeFiles[] = $newfilenameSiaBadge;
				move_uploaded_file($tmpFilePathSiaBadge, $newFilePathSiaBadge);
			}
		}
	}
	
	foreach($SiaBadgeFiles as $SiaBadgeFile){
		if($SiaBadgeFile !=''){
			$mimeType = pathinfo($SiaBadgeFile, PATHINFO_EXTENSION);
			$SiaBadgeName = $SiaBadgeFile;
			$userId = $_SESSION['user_id'];

			$SiaBadgeData = array(
				'user_id' => $userId,
				'siabadge' => $SiaBadgeName,
				'siabadge_mime' => $mimeType
			);

			/* Insert Sia Badge into User Sia Badge table */
			$insertSiaBadge = $db->Insert($SiaBadgeData, 'tbl_user_siabadge');
		}
    }
    

    /* Upload License/Passport */
	$newfilenameLicense = '';
	$newFilePathLicense = '';
	$LicenseFiles = array();
	$total = count($_FILES['license']['name']);
	for( $i=0 ; $i < $total ; $i++ ) {
		if($_FILES['license']['name'][$i]!='')
		{
			$tmpFilePathLicense = $_FILES['license']['tmp_name'][$i];
			if ($tmpFilePathLicense != ""){
				$pathLicense = $_FILES['license']['name'][$i];
				$extLicense = pathinfo($pathLicense, PATHINFO_EXTENSION);
				$randnameLicense=rand(111111,999999);
				$newfilenameLicense = $randnameLicense.".".$extLicense;
				$newFilePathLicense = CUSTOMER_LICENSEPASSPORT_IMG_PATH.$newfilenameLicense;
				$LicenseFiles[] = $newfilenameLicense;
				move_uploaded_file($tmpFilePathLicense, $newFilePathLicense);
			}
		}
	}
	
	foreach($LicenseFiles as $LicenseFile){
		if($LicenseFile !=''){
			$mimeType = pathinfo($LicenseFile, PATHINFO_EXTENSION);
			$LicenseName = $LicenseFile;
			$userId = $_SESSION['user_id'];

			$LicenseData = array(
				'user_id' => $userId,
				'license_passport' => $LicenseName,
				'license_passport_mime' => $mimeType
			);

			/* Insert Sia Badge into User Sia Badge table */
			$insertLicense = $db->Insert($LicenseData, 'tbl_user_license_passport');
		}
    }
    
    /* Upload Utility Documents */
	$newfilenameUtility = '';
	$newFilePathUtility = '';
	$UtilityFiles = array();
	$total = count($_FILES['utility']['name']);
	for( $i=0 ; $i < $total ; $i++ ) {
		if($_FILES['utility']['name'][$i]!='')
		{
			$tmpFilePathUtility = $_FILES['utility']['tmp_name'][$i];
			if ($tmpFilePathUtility != ""){
				$pathUtility = $_FILES['utility']['name'][$i];
				$extUtility = pathinfo($pathUtility, PATHINFO_EXTENSION);
				$randnameUtility=rand(111111,999999);
				$newfilenameUtility = $randnameUtility.".".$extUtility;
				$newFilePathUtility = CUSTOMER_UTILITY_IMG_PATH.$newfilenameUtility;
				$UtilityFiles[] = $newfilenameUtility;
				move_uploaded_file($tmpFilePathUtility, $newFilePathUtility);
			}
		}
	}
	
	foreach($UtilityFiles as $UtilityFile){
		if($UtilityFile !=''){
			$mimeType = pathinfo($UtilityFile, PATHINFO_EXTENSION);
			$UtilityName = $UtilityFile;
			$userId = $_SESSION['user_id'];

			$UtilityData = array(
				'user_id' => $userId,
				'utility' => $UtilityName,
				'utility_mime' => $mimeType
			);

			/* Insert Sia Badge into User Utility Docs table */
			$insertUtility = $db->Insert($UtilityData, 'tbl_user_utility');
		}
	}

	/* Upload Company Certificates */
	$newfilenameCompanyCerti = '';
	$newFilePathCompanyCerti = '';
	$CompanyCertiFiles = array();
	$total = count($_FILES['companycerti']['name']);
	for( $i=0 ; $i < $total ; $i++ ) {
		if($_FILES['companycerti']['name'][$i]!='')
		{
			$tmpFilePathCompanyCerti = $_FILES['companycerti']['tmp_name'][$i];
			if ($tmpFilePathCompanyCerti != ""){
				$pathCompanyCerti = $_FILES['companycerti']['name'][$i];
				$extCompanyCerti = pathinfo($pathCompanyCerti, PATHINFO_EXTENSION);
				$randnameCompanyCerti=rand(111111,999999);
				$newfilenameCompanyCerti = $randnameCompanyCerti.".".$extCompanyCerti;
				$newFilePathCompanyCerti = CUSTOMER_COMPANYCERTI_IMG_PATH.$newfilenameCompanyCerti;
				$CompanyCertiFiles[] = $newfilenameCompanyCerti;
				move_uploaded_file($tmpFilePathCompanyCerti, $newFilePathCompanyCerti);
			}
		}
	}
	
	foreach($CompanyCertiFiles as $CompanyCertiFile){
		if($CompanyCertiFile !=''){
			$mimeType = pathinfo($CompanyCertiFile, PATHINFO_EXTENSION);
			$CompanyCertiName = $CompanyCertiFile;
			$userId = $_SESSION['user_id'];

			$CompanyCertiData = array(
				'user_id' => $userId,
				'comp_certi' => $CompanyCertiName,
				'comp_certi_mime' => $mimeType
			);

			/* Insert CompanyCerti table */
			$insertCompanyCerti = $db->Insert($CompanyCertiData, 'tbl_user_comp_certi');
		}
	}

	$certiFilesSave = implode(',', $certiFiles);
	
	if($address!='')
	{
		$address=substr($address,0,-1);
	}
	
	if($address_1 != '' ){
		$latLongAdd = $address_1 . ', UK';
	}else{
		$latLongAdd = $post_code;
	}

	$latlong    =   get_lat_long($latLongAdd);
	$map        =   explode(',' ,$latlong);
	$mapLat     =   $map[0];
	$mapLong    =   $map[1];
		
	
	$data = array('firstname'=>$a_name,'postal_code'=>$post_code,'lastname'=>$a_lname,'phone'=>$phone,'address_1'=>$address_1,'address_2'=>$address_2,'address_3'=>$address_3,'modified_date'=>date('Y-m-d H:i:s'),'bank_name'=>$bank_name,'acc_holder_name'=>$acc_holder_name,'sort_code'=>$sort_code,'acc_number'=>$acc_number,'reg_no'=>$registration_no,'reg_vat_no'=>$vat_registration_no,'company_name'=>$company_name,'city_id'=>$city_id,'state_id'=>$state_id,'birthdate'=>$birthdate,'gender'=>$gender,'height'=>$height,'build'=>$build,'nationality'=>$nationality,'language'=>$language,'militry'=>$militry,'drive'=>$drive,'firstaid'=>$firstaid,'tattoos'=>$tattoos,'piercing'=>$piercing,'right_to_work_uk'=>$right_to_work_uk,'willing_to_travel'=>$willing_to_travel,'how_far_willing_to_travel'=>$how_far,'uk_driving_license'=>$uk_driving_license,'cscs_card'=>$cscs_card,'sia'=>$sia,'sia_1'=>$sia_1,'sia_2'=>$sia_2,'sia_3'=>$sia_3,'sia_4'=>$sia_4,'activity'=>$activity,'health'=>$health,'bio'=>$bio,'experience'=>$experience,'education_credentials'=>$education_credentials,'latitude'=>$mapLat,'longitude'=>$mapLong,'paypal_email'=>$paypal_email,'paremedic'=>$paremedic);
	
	if($newfilename!='')
	{
		$profile_image = $newfilename;
		/* $imageArray = array('profile_image'=>$profile_image); */
		$imageArray = array('profile_image'=>$aaa);
		$data = array_merge($data,$imageArray);
	}

	/* if($certiFilesSave!='')
	{
		$certiArray = array('user_certificate'=>$certiFilesSave);
		$data = array_merge($data,$certiArray);
	} */
	
	if($rmavatarvideo==1 || $newfilename1!='')
	{
		
		$profilevideo = $newfilename1;
		$videoArray = array('profilevideo'=>$profilevideo);
		$data = array_merge($data,$videoArray);
	}		
	$where_badge = "user_id  = {$_SESSION['user_id']}";
	$db->Delete("tbl_siabadge_type",$where_badge);
	foreach($badge_types as $badge_type){

		$data_badge= array('user_id'=>$_SESSION['user_id'],'badge_type'=>$badge_type);
		$db->Insert($data_badge,"tbl_siabadge_type");
	}
	$where ="user_id ={$_SESSION['user_id']}";

	$db->Update($data,"tbluser",$where);	
	
	$_SESSION['mt'] = "success";
	$_SESSION['me'] = "User Update Successfully.";
	$_SESSION['pu'] = "Profile Updated";
	if($customer_type==1)
	{
		if ($_SESSION['page_name'] == "manage-course.php") {
			header('Location:manage-course.php');
			exit;
		} else if($_SESSION['page_name'] == "jobs.php"){
			header('Location:jobs.php');
			exit;
		}else if($_SESSION['page_name']=='place-bid.php'){
			header('Location:place-bid.php?job_id='.$_SESSION['job_id']);
			exit;
		}else if($_SESSION['page_name']=='newcourse.php'){
			header('Location:newcourse.php?catid='.$_SESSION['catid']);
			exit;
		}else if($_SESSION['page_name']=='newcourse_details.php'){
			header('Location:newcourse_details.php?course_id='.$_SESSION['course_id']);
			exit;
		}else{
			header('Location:business-profile.php');
			exit;
		}
		
	}
	if($customer_type==2)
	{
		if ($_SESSION['page_name'] == 'jobs.php') {
			header('Location:jobs.php');
			exit;
		} else if($_SESSION['page_name']=='place-bid.php'){
			header('Location:place-bid.php?job_id='.$_SESSION['job_id']);
			exit;
		}else if($_SESSION['page_name']=='newcourse.php'){
			header('Location:newcourse.php?catid='.$_SESSION['catid']);
			exit;
		}else if($_SESSION['page_name']=='newcourse_details.php'){
			header('Location:newcourse_details.php?course_id='.$_SESSION['course_id']);
			exit;
		}else{
			header('Location:individual-profile.php');
			exit;
		}
		
		
	}

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="theme-color" content="#cf2027">
<meta name="msapplication-navbutton-color" content="#cf2027">
<meta name="apple-mobile-web-app-status-bar-style" content="#cf2027">
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<title>Edit Profile - SECURE THAT JOB</title>

<!-- Bootstrap -->
<link href="https://fonts.googleapis.com/css?family=Fira+Sans:300,400,400i,500,600,700,800" rel="stylesheet"> 
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link href="css/jquery-ui.css" rel="stylesheet">
<link href="css/ddsmoothmenu.css" rel="stylesheet">
<link href="css/jquery.fancybox.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">
<link href="fonts/font-awesome.css" rel="stylesheet">
<link href="css/cropper.css" rel="stylesheet">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.bxslider.js"></script>
<script type="text/javascript" src="js/menu.js"></script>
<script type="text/javascript" src="js/jquery.fancybox.js"></script>
<script src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/at-jquery.js"></script>
<script type="text/javascript" src="js/cropper.min.js"></script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>


<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({includedLanguages: '<?php echo LanguageList; ?>', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script> 

<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();

		$(".fancybox_pdf").fancybox({
			'frameWidth': 100,
			'frameHeight':495,
			'overlayShow':true,
			'hideOnContentClick':false,
			'type':'iframe'
		})
	});
</script>

  
<script>
 jQuery( function() {
    jQuery( "#datepicker" ).datepicker({dateFormat: 'dd/mm/yy', changeMonth: true, yearRange: "-60:+10", changeYear: true, clickInput: true, maxDate: 0});
	$('.ui-datepicker').addClass('notranslate');
	
	$("#chooseFile").change( function() {
		var reg=/(.jpg|.gif|.png||.jpeg)$/;
    if (!reg.test($("#chooseFile").val())) {
        alert('Invalid File Type');
        return false;
    }
    uploadFile();
	});
	
	$("#chooseFile2").change( function() {
		var reg=/(.avi|.mp4|.3gp)$/;
    if (!reg.test($("#chooseFile2").val())) {
        alert('Invalid File Type');
        return false;
    }
    uploadFile2();
		
	});

	$("#chooseCertificate").change( function() {
		var reg=/(.jpg|.jpeg|.pdf|.png)$/;
    if (!reg.test($("#chooseCertificate").val())) {
        return false;
    }

    uploadFile3();
		
	});


    $("#chooseSiaBadge").change( function() {
		var reg=/(.jpg|.jpeg|.pdf|.png)$/;
    if (!reg.test($("#chooseSiaBadge").val())) {
        return false;
    }

    uploadFile4();
		
	});

    $("#chooseLicense").change( function() {
		var reg=/(.jpg|.jpeg|.pdf|.png)$/;
    if (!reg.test($("#chooseLicense").val())) {
        return false;
    }

    uploadLicense();
		
	});

    $("#chooseUtility").change( function() {
		var reg=/(.jpg|.jpeg|.pdf|.png)$/;
    if (!reg.test($("#chooseUtility").val())) {
        return false;
    }

    uploadUtility();
		
	});

	$("#chooseCompanyCerti").change( function() {
		var reg=/(.jpg|.jpeg|.pdf|.png)$/;
    if (!reg.test($("#chooseCompanyCerti").val())) {
        return false;
    }

    uploadCompanyCerti();
		
	});

	$('.g_vd').fancybox();
  });

  function uploadFile()
  {
	var fd = new FormData();
	var files = $('#chooseFile')[0].files[0];

		fd.append('file',files);
		$.ajax({
			url:'php_file.php',
			type:'post',
			data:fd,
			contentType: false,
			processData: false,
			success:function(response){
				if(response != 0){
					//alert(response);
					$("#uploadedImage").show();
					$("#uploadedImage").attr("src",response);
				}
			}
		});
  }
  
  function uploadFile2()
  {
	var fd = new FormData();
	var files = $('#chooseFile2')[0].files[0];

	fd.append('file',files);
	$.ajax({
		url:'php_file_video.php',
		type:'post',
		data:fd,
		contentType: false,
		processData: false,
		beforeSend: function(){
				$('#videopreloader').show();
		},
		success:function(response){
			if(response != 0){
				$('#videopreloader').hide();
				$("#previewvideo").html(response);
			}
		}
	});
  }

  /* Upload for certificate */
  function uploadFile3()
  {
	var fd = new FormData();
	
	$.each($("#chooseCertificate")[0].files, function(i, file) {
		fd.append('file[]', file);
	});

	$.ajax({
		url:'php_file_certi.php',
		type:'post',
		data:fd,
		contentType: false,
		processData: false,
		beforeSend: function(){
				$('#uploadcertipreloader').show();
		},
		success:function(response){
			if(response != 0){
				$('#uploadcertipreloader').hide();
				$('.certiPreview').show();
				$(".certiPreview").html(response);
			}
		}
	});
  }

/* Remove certificate */
function removeCertificate(userId,certiId)
{
    var userId = userId;
    var certiId = certiId;
    var confirm2Remove = confirm("Are you sure you want to remove certificate?");

    if(confirm2Remove == true){
        $.ajax({
            url:'remove_certi.php?userId='+userId+'&certiId='+certiId,
            type:'get',
            //data: { userId : userId, certiId : certiId }
            beforeSend: function(){
                $('#rmvcertipreloader').show();
            },
            success:function(response){
                if(response != 0){
                    $('#rmvcertipreloader').hide();
                    //$('.certiPreviewData').hide();
                    $(".certiPreviewData").load(" .certiPreviewData");
                }
            }
        });
    }else{
        return false;
    }
}


/* Upload for License Passport */
function uploadLicense()
  {
	var fd = new FormData();
	
	$.each($("#chooseLicense")[0].files, function(i, file) {
		fd.append('file[]', file);
	});

	$.ajax({
		url:'php_file_license.php',
		type:'post',
		data:fd,
		contentType: false,
		processData: false,
		beforeSend: function(){
				$('#uploadcertipreloader').show();
		},
		success:function(response){
			if(response != 0){
				$('#uploadcertipreloader').hide();
				$('.licensePreview').show();
				$(".licensePreview").html(response);
			}
		}
	});
  }

  /* Remove for License Passport */
  function removeLicense(userId,certiId)
  {
	var userId = userId;
	var certiId = certiId;
	var confirm2Remove = confirm("Are you sure you want to remove document?");

	if(confirm2Remove == true){
		$.ajax({
			url:'remove_license.php?userId='+userId+'&certiId='+certiId,
			type:'get',
			//data: { userId : userId, certiId : certiId }
			beforeSend: function(){
				$('#rmvcertipreloader').show();
			},
			success:function(response){
				if(response != 0){
					$('#rmvcertipreloader').hide();
					$(".licensePreviewData").load(" .licensePreviewData");
				}
			}
		});
	}else{
		return false;
	}
 }
 

 /* Upload for SiaBadge */
 function uploadFile4()
  {
	var fd = new FormData();
	
	$.each($("#chooseSiaBadge")[0].files, function(i, file) {
		fd.append('file[]', file);
	});

	$.ajax({
		url:'php_file_siabadge.php',
		type:'post',
		data:fd,
		contentType: false,
		processData: false,
		beforeSend: function(){
				$('#uploadcertipreloader').show();
		},
		success:function(response){
			if(response != 0){
				$('#uploadcertipreloader').hide();
				$('.siaBadgePreview').show();
				$(".siaBadgePreview").html(response);
			}
		}
	});
  }

/* Remove for SiaBadge */
function removeSiaBadge(userId,certiId){
	var userId = userId;
	var certiId = certiId;
	var confirm2Remove = confirm("Are you sure you want to remove certificate?");

	if(confirm2Remove == true){
		$.ajax({
			url:'remove_siabadge.php?userId='+userId+'&certiId='+certiId,
			type:'get',
			//data: { userId : userId, certiId : certiId }
			beforeSend: function(){
				$('#rmvcertipreloader').show();
			},
			success:function(response){
				if(response != 0){
					$('#rmvcertipreloader').hide();
					//$('.certiPreviewData').hide();
					$(".siaBadgePreviewData").load(" .siaBadgePreviewData");
				}
			}
		});
	}else{
		return false;
	}
 }


/* Upload Utility Documents */
function uploadUtility()
  {
	var fd = new FormData();
	
	$.each($("#chooseUtility")[0].files, function(i, file) {
		fd.append('file[]', file);
	});

	$.ajax({
		url:'php_file_utility.php',
		type:'post',
		data:fd,
		contentType: false,
		processData: false,
		beforeSend: function(){
				$('#uploadcertipreloader').show();
		},
		success:function(response){
			if(response != 0){
				$('#uploadcertipreloader').hide();
				$('.utilityPreview').show();
				$(".utilityPreview").html(response);
			}
		}
	});
}

/* Remove Utility Documents */
function removeUtility(userId,certiId)
{
	var userId = userId;
	var certiId = certiId;
	var confirm2Remove = confirm("Are you sure you want to remove document?");

	if(confirm2Remove == true){
		$.ajax({
			url:'remove_utility.php?userId='+userId+'&certiId='+certiId,
			type:'get',
			//data: { userId : userId, certiId : certiId }
			beforeSend: function(){
				$('#rmvcertipreloader').show();
			},
			success:function(response){
				if(response != 0){
					$('#rmvcertipreloader').hide();
					$(".utilityPreviewData").load(" .utilityPreviewData");
				}
			}
		});
	}else{
		return false;
	}
}


/* Upload Company Certificate */
function uploadCompanyCerti()
  {
	var fd = new FormData();
	
	$.each($("#chooseCompanyCerti")[0].files, function(i, file) {
		fd.append('file[]', file);
	});

	$.ajax({
		url:'php_file_company_certi.php',
		type:'post',
		data:fd,
		contentType: false,
		processData: false,
		beforeSend: function(){
				$('#uploadcertipreloader').show();
		},
		success:function(response){
			if(response != 0){
				$('#uploadcertipreloader').hide();
				$('.companyCertiPreview').show();
				$(".companyCertiPreview").html(response);
			}
		}
	});
}

/* Remove Company Certificate */
function removeCompanyCerti(userId,certiId)
{
	var userId = userId;
	var certiId = certiId;
	var confirm2Remove = confirm("Are you sure you want to remove company certificate?");

	if(confirm2Remove == true){
		$.ajax({
			url:'remove_company_certi.php?userId='+userId+'&certiId='+certiId,
			type:'get',
			//data: { userId : userId, certiId : certiId }
			beforeSend: function(){
				$('#rmvcertipreloader').show();
			},
			success:function(response){
				if(response != 0){
					$('#rmvcertipreloader').hide();
					$(".companyCertiPreviewData").load(" .companyCertiPreviewData");
				}
			}
		});
	}else{
		return false;
	}
}


function removeCertificateUpload(obj)
{
    $("#uploaded_certi_"+obj).hide("");
}

function removeSiaBadgeUpload(obj)
{
    $("#uploaded_siabadge_"+obj).hide("");
}

function removeLicenseUpload(obj)
{
    $("#uploaded_license_"+obj).hide("");
}

function removeUtilityUpload(obj)
{
    $("#uploaded_utility_"+obj).hide("");
}

function removeCompanyCertiUpload(obj)
{
    $("#uploaded_company_certi_"+obj).hide("");
}

function removeProfileVideo()
{
	var confirm2Remove = confirm("Are you sure you want to remove profile video?");

	if(confirm2Remove == true){
		$.ajax({
			url:'remove_video.php',
			type:'post',
			beforeSend: function(){
				$('#rmvvideopreloader').show();
			},
			success:function(response){
				if(response != 0){
					$('#rmvvideopreloader').hide();
					$('.gd_vd_profile').hide();
					$('.remove_video').hide();
				}
			}
		});
	}else{
		return false;
	}
 }
  
  //getCities(<?php echo $state_id; ?>);
  function getCities(val) {
		$.ajax({
			type: "POST",
			url: "<?php echo ADMIN_URL ?>phpajax/get_city.php",
			data:'state_id='+val+'&city_id=<?php echo $city_id; ?>',
			beforeSend: function(){
				$('#preloader').show();
			},
			success: function(data){
				$('#preloader').hide();
				$("#city_id").html(data);	
			}
		});
	}
	
	function geThan(){
	
	var extFile  = document.getElementById("chooseFile").value;	
	if(extFile!='') {
	var ext = extFile.split('.').pop();
	var filesAllowed = ["jpg", "jpeg"];
		if( (filesAllowed.indexOf(ext)) == -1)
			return "Only JPG and JPEG files are allowed";
		}
    }

	function geThanCerti(){
        var extFile  = document.getElementById("chooseCertificate").value;	
        if(extFile!='') {
            var ext = extFile.split('.').pop();
            var filesAllowed = ["jpg", "jpeg", "png", "pdf"];
            if( (filesAllowed.indexOf(ext)) == -1){
                return "Only JPG, JPEG, PNG and PDF files are allowed";
            }
        }
    }

    function geThanSiaBadge(){
        var extFile  = document.getElementById("chooseSiaBadge").value;	
        if(extFile!='') {
            var ext = extFile.split('.').pop();
            var filesAllowed = ["jpg", "jpeg", "png", "pdf"];
            if( (filesAllowed.indexOf(ext)) == -1){
                return "Only JPG, JPEG, PNG and PDF files are allowed";
            }
        }
    }

    function geThanLicense(){
        var extFile  = document.getElementById("chooseLicense").value;	
        if(extFile!='') {
            var ext = extFile.split('.').pop();
            var filesAllowed = ["jpg", "jpeg", "png", "pdf"];
            if( (filesAllowed.indexOf(ext)) == -1){
                return "Only JPG, JPEG, PNG and PDF files are allowed";
            }
        }
    }

    function geThanUtility(){
        var extFile  = document.getElementById("chooseUtility").value;	
        if(extFile!='') {
            var ext = extFile.split('.').pop();
            var filesAllowed = ["jpg", "jpeg", "png", "pdf"];
            if( (filesAllowed.indexOf(ext)) == -1){
                return "Only JPG, JPEG, PNG and PDF files are allowed";
            }
        }
	}
	
	function geThanCompanyCerti(){
        var extFile  = document.getElementById("chooseCompanyCerti").value;	
        if(extFile!='') {
            var ext = extFile.split('.').pop();
            var filesAllowed = ["jpg", "jpeg", "png", "pdf"];
            if( (filesAllowed.indexOf(ext)) == -1){
                return "Only JPG, JPEG, PNG and PDF files are allowed";
            }
        }
    }
  
	jQuery(document).ready(function($) {	
		$('.rd_lb input:checkbox').on('click', function(){
			if($(this).is(":checked")) {
				$(this).parent().addClass("active");
			} else {
				$(this).parent().removeClass("active");
			}
    	});
	});
</script>

<script>
	function show1(){
  		document.getElementById('sia_number').style.display ='block';
	}
	function show2(){
		document.getElementById('sia_number').style.display = 'none';
	}
</script>

<script>
	function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }
</script>

</head>
<?php if(isset($_SESSION['user_id'])){
	$link='login.php';
	if(isset($_SESSION['user_id']) && $_SESSION['customer_type']==1)
	{
		$profileCLass = 'business-profile-class';
	}
	if(isset($_SESSION['user_id']) && $_SESSION['customer_type']==2)
	{
		$profileCLass = 'individual-profile-class';
	}
}
?>

<body class="<?php echo $profileCLass; ?>">
<div id="preloader" style="display:none"></div>
<?php include "header-inner.php"; ?>
<div class="stj_login_wrap stj_reg_wrap">
	<div class="container">
		<div class="row">
			
			<div class="reg_dv">
				<h2>Profile</h2>
				<div class="jobdetail">
				 <form id="form1"  method="post" name="edit-profile" enctype="multipart/form-data" class="validateForm" action="">
					<ul class="jobtab">
						<li class="active"><a href="javascript:void(0);"><?php echo $activetitle; ?></a></li>
						<li><a href="javascript:void(0);"></a></li>
					</ul>
					
					<div class="stj_pb_edit">
						
						<div class="stj_photo_up">
							<div class="file-upload">
                               	<div class="file-select">   
									<div class="file-select-name" id="noFile"></div> 
									<div class="file-select-button" id="fileName">Upload Picture</div>
									<input type="file" name="profileimage" id="chooseFile">
									<input type="hidden" name="saveprofileimage" id="saveprofileimage">
                               	</div> 
                            </div>
							 <?php 
							if($profile_image!=''){
								/* $src=CUSTOMER_PROFILE_IMG_URL.get_image_thumbnail($profile_image); */
								$upload_extension =  explode(".", $profile_image);
								$upload_extension = end($upload_extension);
									if ((strlen($upload_extension)==3) || (strlen($upload_extension)==4)) {
										$img=CUSTOMER_PROFILE_IMG_URL.$profile_image;
									} else {
										$img=$profile_image;
									}
									$src=$profile_image;
							?>
							<img id="uploadedImage" class="cropped" src="<?php echo $img; ?>" style="width:100px;height:100px;"   />
							<?php } else { ?>
							<img id="uploadedImage" class="cropped" src="" style="width:100px;display:none;height:100px;"   />
							<?php } ?> 
						</div>

						<main class="page">
							<!-- leftbox -->
							<div class="box-2">
								<div class="result"></div>
							</div>
							
							<!-- input file -->
							<div class="box">
								<div class="options hide" style="display:none;">
									<label> Width</label>
									<input type="number" class="img-w" value="600"  name="imagedim"/>
								</div>
								<!-- save btn -->
								<br/>
								<button class="btn save hide">Crop Image</button>
								<button class="btn cancel hide">Cancel</button>
							</div>
						</main>
						<br/>

						<!-- Modal Area Start -->
						<?php 
							$fee_sql = mysql_query("SELECT title, content FROM tblcmspages WHERE page_id=18");
							$fees_row = mysql_fetch_array($fee_sql);
						?>
						<div class="modal fade" id="videoMaker">
							<div class="modal-dialog modal-dialog-centered">
							<div class="modal-content">
							
								<!-- Modal Header -->
								<div class="modal-header">
								<!-- <h4 class="modal-title"><?php /* echo $fees_row['title']; */ ?></h4> -->
								<h4 class="modal-title">How to make your profile video?</h4>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								</div>
								
								<!-- Modal body -->
								<div class="modal-body">
								<?php /* echo $fees_row['content']; */ ?>
								<div align="center" class="embed-responsive embed-responsive-16by9">
									<!-- <video autoplay loop controls class="embed-responsive-item">
										<source src="<?php echo SITE_URL ?>videos/video_profile.mp4" type="video/mp4">
									</video> -->
								</div>
								</div>

								<!-- Modal footer -->
								<div class="modal-footer">
								<button type="button" class="btn fees-modal-button" data-dismiss="modal">Close</button>
								</div>
								
							</div>
							</div>
						</div>
						<!-- Modal Area Ends -->
						
						<div class="stj_pb_frm">
							<?php if($customer_type==2){ ?>
							<ul>
								<li>
								     <label>First Name <em>*</em></label>
							         <input class="txt_lg" name="fname" id="fname" data-validation-engine="validate[required,custom[onlyLetterSp]]" data-errormessage-value-missing="Please enter your first name" value="<?php echo $first_name; ?>" type="text">
								</li>
								<li>
								     <label>Last Name <em>*</em></label>
							         <input class="txt_lg" name="lname" data-validation-engine="validate[required,custom[onlyLetterSp]]" maxlength="50" data-errormessage-value-missing="Please enter your last name" id="lname" value="<?php echo $lastname; ?>" type="text">
								</li>
								<li>
								     <label>Address Line 1 <em>*</em></label>
							         <input class="txt_lg" id="autocomplete" name="address_1"  id="address_1" data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter address line 1" value="<?php echo $address_1; ?>" type="text">
								</li>
								<li>
								     <label>Address Line 2</label>
							         <input class="txt_lg" name="address_2" value="<?php echo $address_2; ?>"  id="address_2" type="text">
								</li>
								<li>
								     <label>Address Line 3</label>
							         <input class="txt_lg" name="address_3"  value="<?php echo $address_3; ?>" id="address_3" type="text">
								</li>
								<li>
								     <label>Postcode <em>*</em></label>
							         <input class="txt_lg" name="postcode" id="postcode" data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter postcode" value="<?php echo $post_code; ?>" id="postcode" type="text">
								</li>
								<li >
									 <label>County<em>*</em></label>
							         <select name="state_id" id="state_id" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select county" onchange="getCities(this.value)">
									 <option value="">Select County</option>
								     <?php 
										$select_query = mysql_query("SELECT * FROM tblstates ORDER By name ASC");
										while($row = mysql_fetch_assoc($select_query)) {
										$selected='';
										if($state_id==$row['id'])
										{
											$selected='selected';
										}
									?>
							
									<option value="<?php echo $row['id'] ?>" <?php echo $selected; ?>><?php echo $row['name']; ?></option>
								    <?php } ?>
							         </select>
								</li>
								<li>
								     <label>Town / City <em>*</em></label>
							         <select id="city_id" name="city_id" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select city">
										<option value="">Select City</option>
										<?php
											$select_query = mysql_query("SELECT * FROM tblcities WHERE state_id=".$state_id." ORDER By name ASC");
											while($row = mysql_fetch_assoc($select_query)) {
											$selected='';
											if($city_id==$row['id'])
											{
												$selected='selected';
											}
										?>
								
										<option value="<?php echo $row['id'] ?>" <?php echo $selected; ?>><?php echo $row['name']; ?></option>
										<?php } ?>
							         </select>
								</li>
								<li>
									<label>PayPal Email (Should be Verified)<em>*</em></label>
									<input class="txt_lg" name="paypal_email" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter your paypal email" id="paypal_email" value="<?php echo $paypal_email; ?>" type="email" >
								</li>
								
								<li>
								     <label>Contact No <em>*</em></label>
							         <input class="txt_lg" value="<?php echo $phone; ?>" name="phone" maxlength="12" data-validation-engine="validate[required,custom[onlyNumberSp]]" data-errormessage-value-missing="Please enter your phone number" type="tel">
								</li>
								<li>
								     <label>Email <em>*</em></label>
							         <input class="txt_lg" readonly="readonly" type="text" data-validation-engine="validate[required,custom[email]]" data-errormessage-value-missing="The e-mail address you entered appears to be incorrect." value="<?php echo $user_email; ?>" name="email" id="email" data-errormessage-custom-error="Example: yourscreenname@aol.com">
									 <?php if($is_email_verify==1 || $isSocial!=0){ ?> <a class="a_vy">Verified</a> <?php } else { ?><a class="a_vy" href="emailverify.php?email=<?php  echo  $user_email;?>">Verify</a> <?php } ?>
								</li>
                                

								<li class="mar_tp">
								     <label>Password <em>*</em></label>
							         <input class="txt_lg" name="password" type="password" value="<?php echo $pwd;?>" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter Password" readonly >
							         <a class="a_cp" href="JavaScript:Void(0);" data-toggle="modal" data-target="#changePassword">Change Password</a>
								</li>

								<div id="changePassword" class="modal fade" role="dialog">
									  <div class="modal-dialog">

									    <!-- Modal content-->
									    <div class="modal-content">
									      <div class="modal-header">
									        <button type="button" class="close" data-dismiss="modal">&times;</button>
									        <h4 class="modal-title">Re set your password</h4>
									      </div>
									      <div class="modal-body">
									        <form name="frm_change_password" action="" method="post">
												<ul>											
													<li>
													     <label>New Password <em>*</em></label>
												         <input class="txt_lg" name="new_password" id="new_password" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter your new password" value="" type="password">
													</li>

													<li>
													     <label>Re Enter Password <em>*</em></label>
												         <input class="txt_lg" name="re_enter_password" id="re_enter_password" data-validation-engine="validate[required]" data-errormessage-value-missing="Please re enter your new password" value="" type="password">
													</li>
												</ul>
											</form>
									      </div>
									      <div class="modal-footer">
									        <button type="button" class="btn btn-default" onclick="submit_pass_data();" data-dismiss="modal">Submit</button>
									      </div>
									    </div>

									  </div>
									</div>

									
									<script type="text/javascript">

										function submit_pass_data() {

										    var new_password = $("#new_password").val();
										    var re_new_password = $("#re_enter_password").val();

										    if (new_password == '' || re_new_password == '') {
										    	$('#changePassword').on('hide.bs.modal', function(e){
												    e.preventDefault();
												     e.stopImmediatePropagation();
												     return false;
												});	
										    }else{
										    	$.ajax({
										            url:"<?php echo SITE_URL.'profile-edit.php'; ?>",
										            type: "post",
										            dataType: 'json',
										           	data: {method: 'changePassword', new_password: new_password},
										            success:function(result){
										            if (result.status == 1) {
										            	alert(result.msg);
										            	location.reload();
										            }
										           }
										         });
										    }
										    									    

										    
										}										
									</script>

                                <?php 

                                //echo "<pre>";print_r();exit;
                                
                                ?>
                                
								
							</ul>
							<?php /* ?>
							<ul class="brd_ul">
								<li>
								     <label>Bank Name <em>*</em></label>
							         <input class="txt_lg" name="bank_name"  value="<?php echo $bank_name;?>" id="bank_name" maxlength="250" data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter bank name" type="text">
								</li>
								<li>
								     <label>Account Holder's Name <em>*</em></label>
							         <input class="txt_lg" name="acc_holder_name"  value="<?php echo $acc_holder_name;?>" data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter account holders name" id="acc_holder_name" type="text">
								</li>
								<li>
								     <label>Sort Code <em>*</em></label>
							         <input class="txt_lg" name="sort_code" value="<?php echo $sort_code;?>"  data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter sort code" id="sort_code" type="text">
								</li>
								<li>
								     <label>AccountNo <em>*</em></label>
							         <input class="txt_lg" name="acc_number" value="<?php echo $acc_number;?>"  maxlength="250" data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter account number" id="acc_number" type="text">
								</li>
							</ul>
							<?php */ ?>
							
							<ul class="stj_pb_frm_scul">
								<li>
									<label>Upload Profile Video </label>
							       <div class="file-upload">
                                      <div class="file-select">   
                                        <div class="file-select-name" id="noFile2"></div> 
                                         <div class="file-select-button" id="fileName2">Upload Video</div>
										<input type="file" name="profilevideo" id="chooseFile2">
                                      </div> 
								   </div>
								   <div id="previewvideo"></div>
								   <div id="videopreloader" style="display:none"><span>Uploading Video</span></div>
								   <p class="vid_cli"><a href="#" data-toggle="modal" data-target="#videoMaker" id="videoMakers">Click here</a> to know how to make your profile video to attract more people and get better results</p>

									<?php if ($profilevideo!='') { ?>

									<div class="gd_vd gd_vd_profile">
									<?php if($profilevideo!=''){ ?>
										<!-- <a class="g_vd" href="#g_id1"><img class="prof_vid" src="images/play.png" alt=""/></a> -->
										<a class="g_vd" href="#g_id1"><img class="prof_vid" src="" alt=""/></a>
										<div>
											<?php $videoSrc = CUSTOMER_PROFILE_VIDEO_URL.$profilevideo; ?>
											<video width="700" height="450">
												<source src="<?php echo $videoSrc ?>" type="video/mp4"> Your browser does not support the video tag.
											</video>
										</div>
									<?php } ?>
									</div>
									
									<div style="display: none;">
										<div class="gd_pop" id="g_id1">
											<?php $videoSrc = CUSTOMER_PROFILE_VIDEO_URL.$profilevideo; ?>
											<video width="700" height="450" controls src="<?php echo CUSTOMER_PROFILE_VIDEO_URL.$profilevideo ?>"></video>
										</div>
									</div>
									
									<!-- Remove Video Button -->
									<?php if($profilevideo!=''){ ?>
									<input type="button" name="remove_video" class="btn btn-srch-pc remove_video" value="Remove" onclick="javascript:return removeProfileVideo();">
									<div id="rmvvideopreloader" style="display:none"><span>Removing Video</span></div>
									<?php } ?>

									<?php } ?>

								</li>
								<!-- <li class="clr_lft">
								     <label>Date of Birth <em>*</em></label>
							         <input class="txt_lg datepicker" name="birthdate" style="width:200px;" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select Date of Birth" value="<?php //echo $date;  ?>" id="datepicker" type="text">
								</li> -->
								<li class="clr_lft dobClass">
									<label>Date of Birth <em>*</em></label>
									<?php dobSelect(1965, $dobDate, $dobMonth, $dobYear); ?>
								</li>
								<li class="clr_lft">
								     <label>Gender <em>*</em></label>
								     <div class="radio">
								        <div class="rdrow">
								        <input name="gender" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select Gender" id="rd1" class="rd_chk" type="radio" value="1" <?php if($gender==1){ ?> checked <?php } ?>>
								        <label for="rd1">Male</label>
								        </div>
								        <div class="rdrow">
								        	<input name="gender" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select Gender" value="2" id="rd2" class="rd_chk" type="radio" <?php if($gender==2){ ?> checked <?php } ?>>
								        <label for="rd2">Female</label>
								        </div>
							         </div>
								</li>
								<li class="clr_lft">
								     <label>Height<em>*</em></label>
							         <input class="txt_lg txt_cm heig_box" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select Height" name="height" value="<?php echo $height; ?>"  id="height" maxlength="3" type="text">
							         <span class="in_cm">(in Cms)</span>
								</li>
								<li class="clr_lft">
								     <label>Build <em>*</em></label>
							         <select name="build" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select Build"  id="build" style="width:200px;">
								        <option value="">Select Build</option>
										<?php 
										$select_query = mysql_query("SELECT * FROM tblbuild where status=1 ORDER By name ASC"); 
										 while($row = mysql_fetch_assoc($select_query)) {
										?>
											<option value="<?php echo $row['name']; ?>" <?php if($build==$row['name']){ ?> selected <?php } ?>><?php echo $row['name']; ?></option>
											<?php } ?>
							         </select>
								</li>

								<!-- Nationality -->
								<li class="clr_lft">
								     <label>Nationality <em>*</em></label>
							         <select name="nationality" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select Nationality" id="nationality" style="width:200px;">
								        <option value="">Select Nationality</option>
									<?php 
								$select_query = mysql_query("SELECT * FROM tblnationality where status=1 ORDER By name ASC"); 
								 while($row = mysql_fetch_assoc($select_query)) {
								?>
									<option value="<?php echo $row['name']; ?>"  <?php if($nationality==$row['name']){ ?> selected <?php } ?>><?php echo $row['name']; ?></option>
									<?php } ?>
							         </select>
								</li>

								<!-- Languages Spoken -->
								<?php
								$lang=array();
								if($language!='')
								{
									$lang=explode(",",$language);
								}
								
								
							    ?>
								<li class="clr_lft">
								    
								     <label>Languages Spoken <em>*</em></label>
									 <?php 
									$select_query = mysql_query("SELECT * FROM 	tbllanguage where status=1 ORDER By name ASC"); 
									$i=1;
									 while($row = mysql_fetch_assoc($select_query)) {

								     ?>
								     
								     <!-- <?php if(in_array($row['name'], $lang)){ ?>

								     		<?php echo $row['name'];?>
								     
								     <?php } ?> -->	



								<label class="rd_lb <?php if(in_array($row['name'], $lang)){ ?> active <?php } ?>">
									<input name="language[]" class="rd_chk" value="<?php echo $row['name']; ?>" type="checkbox" <?php if(in_array($row['name'],$lang)){ ?> checked <?php } ?>><?php echo $row['name']; ?>
								</label>	 
								
								 <?php $i++; } ?>
								</li>

								<li class="clr_lft">
								     <label>Military Background <em>*</em></label>
								     <div class="radio">
								        <div class="rdrow">
								        <input name="militry" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select the option" value="1" id="rd3" <?php if($militry==1){ ?> checked <?php } ?> class="rd_chk" type="radio">
								        <label for="rd3">Yes</label>
								        </div>
								        <div class="rdrow">
								        	<input name="militry" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select the option" value="2" id="rd4" <?php if($militry==2){ ?> checked <?php } ?> class="rd_chk" type="radio">
								        <label for="rd4">No</label>
								        </div>
							          </div>
								</li>
								
								<li class="clr_lft">
								     <label>Do you drive? <em>*</em></label>
								     <div class="radio">
								        <div class="rdrow">
								        <input name="drive" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select the option" value="1" <?php if($drive==1){ ?> checked <?php } ?> id="rd5" class="rd_chk" type="radio">
								        <label for="rd5">Yes</label>
								        </div>
								        <div class="rdrow">
								        	<input name="drive" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select the option" id="rd6" <?php if($drive==2){ ?> checked <?php } ?> value="2" class="rd_chk" type="radio">
								        <label for="rd6">No</label>
								        </div>
							          </div>
								</li>

								<li class="clr_lft">
									<label>Do you hold full UK Driving License? <em>*</em></label>
									<div class="radio">
										<div class="rdrow">
											<input name="uk_driving_license" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select the option" value="1" <?php if($uk_driving_license==1){ ?> checked <?php } ?> id="rd119" class="rd_chk" type="radio">
											<label for="rd119">Yes</label>
										</div>
										<div class="rdrow">
											<input name="uk_driving_license" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select the option" id="rd120" <?php if($uk_driving_license==2){ ?> checked <?php } ?> value="2" class="rd_chk" type="radio">
											<label for="rd120">No</label>
										</div>
									</div>
								</li>

								<li class="clr_lft">
								     <label>First aid? <em>*</em></label>
								     <div class="radio">
								        <div class="rdrow">
								        <input name="firstaid" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select the option" value="1" <?php if($firstaid==1){ ?> checked <?php } ?> id="rd7" class="rd_chk" type="radio">
								        <label for="rd7">Yes</label>
								        </div>
								        <div class="rdrow">
								        	<input name="firstaid" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select the option" id="rd8" <?php if($firstaid==2){ ?> checked <?php } ?> value="2" class="rd_chk" type="radio">
								        <label for="rd8">No</label>
								        </div>
							          </div>
								</li>

								<li class="clr_lft">
								     <label>Paramedic training? <em>*</em></label>
								     <div class="radio">
								        <div class="rdrow">
								        <input name="paremedic" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select the option" value="1" <?php if($paremedic==1){ ?> checked <?php } ?> id="rd17" class="rd_chk" type="radio">
								        <label for="rd17">Yes</label>
								        </div>
								        <div class="rdrow">
								        	<input name="paremedic" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select the option" id="rd18" <?php if($paremedic==2){ ?> checked <?php } ?> value="2" class="rd_chk" type="radio">
								        <label for="rd18">No</label>
								        </div>
							          </div>
								</li>

								<li class="clr_lft">
								     <label>Visible Tattoos? <em>*</em></label>
								     <div class="radio">
								        <div class="rdrow">
								        <input name="tattoos" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select the option" value="1" <?php if($tattoos==1){ ?> checked <?php } ?> id="rd9" class="rd_chk" type="radio">
								        <label for="rd9">Yes</label>
								        </div>
								        <div class="rdrow">
								        	<input name="tattoos" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select the option" id="rd10" <?php if($tattoos==2){ ?> checked <?php } ?> value="2" class="rd_chk" type="radio">
								        <label for="rd10">No</label>
								        </div>
							          </div>
								</li>

								<li class="clr_lft">
									<label>Visible Piercings? <em>*</em></label>
									<div class="radio">
										<div class="rdrow">
											<input name="piercing" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select the option" value="1" <?php if($piercing==1){ ?> checked <?php } ?> id="rd111" class="rd_chk" type="radio">
											<label for="rd111">Yes</label>
										</div>
										<div class="rdrow">
											<input name="piercing" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select the option" id="rd112" <?php if($piercing==2){ ?> checked <?php } ?> value="2" class="rd_chk" type="radio">
											<label for="rd112">No</label>
										</div>
									</div>
								</li>

                                <li class="clr_lft">
									<label>Do you have right to work in the UK? <em>*</em></label>
									<div class="radio">
										<div class="rdrow">
											<input name="right_to_work_uk" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select the option" value="1" <?php if($right_to_work_uk==1){ ?> checked <?php } ?> id="rd115" class="rd_chk" type="radio">
											<label for="rd115">Yes</label>
										</div>
										<div class="rdrow">
											<input name="right_to_work_uk" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select the option" id="rd116" <?php if($right_to_work_uk==2){ ?> checked <?php } ?> value="2" class="rd_chk" type="radio">
											<label for="rd116">No</label>
										</div>
									</div>
								</li>

                                <li class="clr_lft">
									<label>Willing to travel abroad? <em>*</em></label>
									<div class="radio">
										<div class="rdrow">
											<input name="willing_to_travel" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select the option" value="1" <?php if($willing_to_travel==1){ ?> checked <?php } ?> id="rd117" class="rd_chk" type="radio">
											<label for="rd117">Yes</label>
										</div>
										<div class="rdrow">
											<input name="willing_to_travel" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select the option" id="rd118" <?php if($willing_to_travel==2){ ?> checked <?php } ?> value="2" class="rd_chk" type="radio">
											<label for="rd118">No</label>
										</div>
									</div>
								</li>

                                <li class="clr_lft">
									<label>Do you have CSCS card? <em>*</em></label>
									<div class="radio">
										<div class="rdrow">
											<input name="cscs_card" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select the option" value="1" <?php if($cscs_card==1){ ?> checked <?php } ?> id="rd113" class="rd_chk" type="radio">
											<label for="rd113">Yes</label>
										</div>
										<div class="rdrow">
											<input name="cscs_card" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select the option" id="rd114" <?php if($cscs_card==2){ ?> checked <?php } ?> value="2" class="rd_chk" type="radio">
											<label for="rd114">No</label>
										</div>
									</div>
								</li>

								<!-- SIA BADGE -->
								<li class="clr_lft">
                                    <label>SIA Badge? <em>*</em></label>
                                    <div class="radio">
                                    <div class="rdrow">
                                    <input name="sia" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select the option" value="1" <?php if($sia==1){ ?> checked <?php } ?> id="rd11" class="rd_chk" type="radio" onclick="show1();">
                                    <label for="rd11">Yes</label>
                                    </div>
                                    <div class="rdrow">
                                        <input name="sia" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select the option" id="rd12" <?php if($sia==2){ ?> checked <?php } ?> value="2" class="rd_chk" type="radio" onclick="show2();">
                                    <label for="rd12">No</label>
                                    </div>
                                    </div>
								</li>
								<?php $badges=array('Cash and Valuables in Transit (CVIT)','Close Protection (CP)','Door Supervision (DS)','Public Space Surveillance (CCTV)','Security Guarding (SG)','Vehicle Immobilisation (VI)','Key Holding (KH)');?>
								<li id="sia_number" class="clr_lft" style="display:none">
									<label>SIA Badge Type</label>
									<?php foreach($badges as $badge){ ?>
									    <label><input type="checkbox" name="badge_type[]" <?php if(in_array($badge,$badge_type)){ ?> checked="checked" <?php } ?> value="<?php echo $badge;?>"> <?php echo $badge;?> </label>
                                    <?php } ?>
								
								
									<label>SIA Badge Number <em>*</em></label>
									<div class="controls form-inline">
										<input id="txtChar" onkeypress="return isNumberKey(event)" maxlength="4"  type="text txt_lg" size="2" name="sia_1"  class="input-small" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter the correct SIA Badge Number" value="<?php echo $sia_1; ?>">
										<input id="txtChar" onkeypress="return isNumberKey(event)" maxlength="4"  type="text txt_lg" size="2" name="sia_2" class="input-small" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter the correct SIA Badge Number" value="<?php echo $sia_2; ?>">
										<input id="txtChar" onkeypress="return isNumberKey(event)" maxlength="4"  type="text txt_lg" size="2" name="sia_3" class="input-small" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter the correct SIA Badge Number" value="<?php echo $sia_3; ?>">
										<input id="txtChar" onkeypress="return isNumberKey(event)" maxlength="4"  type="text txt_lg" size="2" name="sia_4" class="input-small" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter the correct SIA Badge Number" value="<?php echo $sia_4; ?>">
									</div>

                                    <!-- Upload Sia Badge Start -->
                                    <?php 
                                    $siaBadgeCount=0;
                                    if(isset($_SESSION['user_id']) && $_SESSION['user_id']!='') {
                                        $userSiaBadge=mysql_query("select * from tbl_user_siabadge where user_id=".$_SESSION['user_id']."");
                                        $siaBadgeCount=mysql_num_rows($userSiaBadge);
                                    }
                                    ?>
                                    <label style="margin: 8px 0;">Upload SIA Badge<em>*</em></label>
                                    <div class="file-upload">
                                        <div class="file-select">   
                                            <div class="file-select-name" id="noFile"></div> 
                                            <div class="file-select-button" id="fileName">Browse</div>
                                            <input type="file" multiple name="siabadge[]" data-validation-engine="validate[funcCall[geThanSiaBadge[]]]"  id="chooseSiaBadge">
                                        </div> 
                                    </div>
                                    <div id="uploadcertipreloader" style="display:none"><span>Uploading Sia Badge</span></div>
                                    
                                    <!-- Preview after upload -->
                                    <div id="siaBadgePreview" class="siaBadgePreview" style="display:none;">
                                        <a class="fancybox" rel="group" href="">
                                            <img src="" style="width:100px;" alt="">
                                        </a>
                                    </div>

                                    <!-- Preview of Saved Sia Badge (Database) -->
                                    <div id="siaBadgePreview" class="siaBadgePreviewData">
                                    <?php 
                                    if ($siaBadgeCount > 0) { 
                                        while($userSiaBadgeRow = mysql_fetch_assoc($userSiaBadge)) {
                                            $siaBadgeId = $userSiaBadgeRow['id'];
                                            $siaBadgeName = $userSiaBadgeRow['siabadge'];
                                            $siaBadgeUserId = $userSiaBadgeRow['user_id'];
                                            $siaBadgeMime = $userSiaBadgeRow['siabadge_mime'];

                                            if($userSiaBadgeRow['siabadge'] != ""){
                                    ?>
                                    
                                    <?php if($siaBadgeMime != 'pdf'){ ?>
                                        <span>
                                            <a class="fancybox" rel="group" href="<?php echo CUSTOMER_SIABADGE_IMG_URL.$siaBadgeName; ?>">
                                                <img src="<?php echo CUSTOMER_SIABADGE_IMG_URL.$siaBadgeName; ?>" style="width:100px;" alt="">
                                            </a>
                                            <input type="button" name="remove_certi" class="btn btn-srch-pc remove_certi" value="Remove" onclick="javascript:return removeSiaBadge(<?php echo $siaBadgeUserId ?>, <?php echo $siaBadgeId ?>);">
                                        </span>
                                    <?php }else{ ?>
                                        <span>
                                            <a class="fancybox_pdf" rel="group" href="<?php echo CUSTOMER_SIABADGE_IMG_URL.$siaBadgeName; ?>">
                                                <img src="images/pdf_image.png" style="width:100px;" alt="">
                                            </a>
                                            <input type="button" name="remove_certi" class="btn btn-srch-pc remove_certi" value="Remove" onclick="javascript:return removeSiaBadge(<?php echo $siaBadgeUserId ?>, <?php echo $siaBadgeId ?>);">
                                        </span>
                                    <?php } ?>
                                    <?php 
                                            } 
                                        }
                                    }
                                    ?>
                                    <div id="rmvcertipreloader" style="display:none"><span>Removing Sia Badge</span></div>
                                    </div>
                                    <!-- Upload Sia Badge End -->
								</li>

								<!-- How far are you willing to travel? -->
								<li class="clr_lft">
								     <label>How far are you willing to travel? <em>*</em></label>
							         <select name="how_far" id="how_far" style="width:200px;" data-validation-engine="validate[required]" >
											<option value="">Select</option>
											<option value="2" 	<?php if($how_far==2){ ?> selected <?php } ?>>2 Miles</option>
											<option value="5" 	<?php if($how_far==5){ ?> selected <?php } ?>>5 Miles</option>
											<option value="10" 	<?php if($how_far==10){ ?> selected <?php } ?>>10 Miles</option>
											<option value="15" 	<?php if($how_far==15){ ?> selected <?php } ?>>15 Miles</option>
											<option value="20" 	<?php if($how_far==20){ ?> selected <?php } ?>>20 Miles</option>
											<option value="30" 	<?php if($how_far==30){ ?> selected <?php } ?>>30 Miles</option>
											<option value="50" 	<?php if($how_far==50){ ?> selected <?php } ?>>50 Miles</option>
											<option value="75" 	<?php if($how_far==75){ ?> selected <?php } ?>>75 Miles</option>
											<option value="100" <?php if($how_far==100){ ?> selected <?php } ?>>100 Miles</option>
											<option value="125" <?php if($how_far==125){ ?> selected <?php } ?>>125 Miles</option>
											<option value="150" <?php if($how_far==150){ ?> selected <?php } ?>>150 Miles</option>
											<option value="175" <?php if($how_far==175){ ?> selected <?php } ?>>175 Miles</option>
											<option value="200" <?php if($how_far==200){ ?> selected <?php } ?>>200 Miles</option>
											<option value="500" <?php if($how_far==500){ ?> selected <?php } ?>>500 Miles</option>
							         </select>
								</li>


								<li class="clr_lft">
						         	<label>Any Ailments that could impair your ability work? <em>*</em></label>
							        <textarea name="activity" data-validation-engine="validate[required]" data-errormessage-value-missing="This field is required!" ><?php echo $activity; ?></textarea>
						        </li>
								<li class="clr_lft">
						         	<label>Any Health Issues? <em>*</em></label>
							        <textarea name="health" data-validation-engine="validate[required]" data-errormessage-value-missing="This field is required!"><?php echo $health; ?></textarea>
						        </li>
								<li class="clr_lft">
						         	<label>Bio <em>*</em></label>
							        <textarea name="bio" data-validation-engine="validate[required]" data-errormessage-value-missing="This field is required!" ><?php echo $bio; ?></textarea>
						        </li>
                                <li class="clr_lft">
						         	<label>Experience <em>*</em></label>
							        <textarea name="experience" data-validation-engine="validate[required]" data-errormessage-value-missing="This field is required!" ><?php echo $experience; ?></textarea>
						        </li>
                                <li class="clr_lft">
						         	<label>Education and Further Credentials <em>*</em></label>
							        <textarea name="education_credentials" data-validation-engine="validate[required]" data-errormessage-value-missing="This field is required!"><?php echo $education_credentials; ?></textarea>
						        </li>
								
								<!-- Upload Certificates -->
								<?php 
								$certiCount=0;
								if(isset($_SESSION['user_id']) && $_SESSION['user_id']!='') {
									$userCerties=mysql_query("select * from tbl_user_certi where user_id=".$_SESSION['user_id']."");
									$certiCount=mysql_num_rows($userCerties);
								}
								?>
								<li class="clr_lft">
									<label>Upload Certificates <em>*</em> </label>
									<div class="file-upload">
										<div class="file-select">   
											<div class="file-select-name" id="noFile"></div> 
											<div class="file-select-button" id="fileName">Browse</div>
											<input type="file" multiple name="certificate[]" 
											<?php
											if ($certiCount==0) { ?>
												data-validation-engine="validate[required,funcCall[geThanCerti[]]]"
											<?php } ?>  id="chooseCertificate">
										</div> 
									</div>
									<div id="uploadcertipreloader" style="display:none"><span>Uploading Certificate</span></div>
									
									<!-- Preview after upload -->
									<div id="certiPreview" class="certiPreview" style="display:none;">
										<a class="fancybox" rel="group" href="">
											<img src="" style="width:100px;" alt="">
										</a>
									</div>

									<!-- Preview of Saved Certificate (Database) -->
									<div id="certiPreview" class="certiPreviewData">
									<?php 
									if ($certiCount > 0) { 
										while($userCerti = mysql_fetch_assoc($userCerties)) {
											$certiId = $userCerti['id'];
											$certiName = $userCerti['certificate'];
											$certiUserId = $userCerti['user_id'];
											$certiMime = $userCerti['certi_mime'];

											if($userCerti['certificate'] != ""){
									?>
									
									<?php if($certiMime != 'pdf'){ ?>
										<span>
											<a class="fancybox" rel="group" href="<?php echo CUSTOMER_CERTIFICATE_IMG_URL.$certiName; ?>">
												<img src="<?php echo CUSTOMER_CERTIFICATE_IMG_URL.$certiName; ?>" style="width:100px;" alt="">
											</a>
											<input type="button" name="remove_certi" class="btn btn-srch-pc remove_certi" value="Remove" onclick="javascript:return removeCertificate(<?php echo $certiUserId ?>, <?php echo $certiId ?>);">
										</span>
									<?php }else{ ?>
										<span>
											<a class="fancybox_pdf" rel="group" href="<?php echo CUSTOMER_CERTIFICATE_IMG_URL.$certiName; ?>">
												<img src="images/pdf_image.png" style="width:100px;" alt="">
											</a>
											<input type="button" name="remove_certi" class="btn btn-srch-pc remove_certi" value="Remove" onclick="javascript:return removeCertificate(<?php echo $certiUserId ?>, <?php echo $certiId ?>);">
										</span>
									<?php } ?>
									<?php 
											} 
										}
									}
									?>
									<div id="rmvcertipreloader" style="display:none"><span>Removing Certificate</span></div>
									</div>
								</li>


                                <!-- Upload Passport / Driving License -->
								<?php 
								$userLicense=0;
								if(isset($_SESSION['user_id']) && $_SESSION['user_id']!='') {
									$userLicense=mysql_query("select * from tbl_user_license_passport where user_id=".$_SESSION['user_id']."");
									$userLicenseCount=mysql_num_rows($userLicense);
								}
								?>
								<li class="clr_lft">
									<label>Upload Passport / Driving License <em>*</em></label>
									<div class="file-upload">
										<div class="file-select">   
											<div class="file-select-name" id="noFile"></div> 
											<div class="file-select-button" id="fileName">Browse</div>
											<input type="file" multiple name="license[]" formnovalidate="formnovalidate" <?php if ($userLicenseCount==0) { ?>
												data-validation-engine="validate[required]"
											<?php } ?> value="" id="chooseLicense">
										</div> 
									</div>
									<div id="uploadcertipreloader" style="display:none"><span>Uploading Document</span></div>
									
									<!-- Preview after upload -->
									<div id="licensePreview" class="licensePreview" style="display:none;">
										<a class="fancybox" rel="group" href="">
											<img src="" style="width:100px;" alt="">
										</a>
									</div>

									<!-- Preview of Saved Passport/License (Database) -->
									<div id="licensePreview" class="licensePreviewData">
									<?php 
									if ($userLicenseCount > 0) { 
										while($userLicenseRow = mysql_fetch_assoc($userLicense)) {
											$licenseId = $userLicenseRow['id'];
											$licenseName = $userLicenseRow['license_passport'];
											$licenseUserId = $userLicenseRow['user_id'];
											$licenseMime = $userLicenseRow['license_passport_mime'];

											if($userLicenseRow['license_passport'] != ""){
									?>
									
									<?php if($licenseMime != 'pdf'){ ?>
										<span>
											<a class="fancybox" rel="group" href="<?php echo CUSTOMER_LICENSEPASSPORT_IMG_URL.$licenseName; ?>">
												<img src="<?php echo CUSTOMER_LICENSEPASSPORT_IMG_URL.$licenseName; ?>" style="width:100px;" alt="">
											</a>
											<input type="button" name="remove_certi" class="btn btn-srch-pc remove_certi" value="Remove" onclick="javascript:return removeLicense(<?php echo $licenseUserId ?>, <?php echo $licenseId ?>);">
										</span>
									<?php }else{ ?>
										<span>
											<a class="fancybox_pdf" rel="group" href="<?php echo CUSTOMER_LICENSEPASSPORT_IMG_URL.$licenseName; ?>">
												<img src="images/pdf_image.png" style="width:100px;" alt="">
											</a>
											<input type="button" name="remove_certi" class="btn btn-srch-pc remove_certi" value="Remove" onclick="javascript:return removeLicense(<?php echo $licenseUserId ?>, <?php echo $licenseId ?>);">
										</span>
									<?php } ?>
									<?php 
											} 
										}
									}
									?>
									<div id="rmvcertipreloader" style="display:none"><span>Removing document</span></div>
									</div>
								</li>


                                <!-- Utility Bill or Statement -->
								<?php 
								$userUtilityCount=0;
								if(isset($_SESSION['user_id']) && $_SESSION['user_id']!='') {
									$userUtility=mysql_query("select * from tbl_user_utility where user_id=".$_SESSION['user_id']."");
									$userUtilityCount=mysql_num_rows($userUtility);
								}
								?>
								<li class="clr_lft">
									<label>Utility Bill or Statement less than 3 months old with current address <em>*</em></label>
									<div class="file-upload">
										<div class="file-select">   
											<div class="file-select-name" id="noFile"></div> 
											<div class="file-select-button" id="fileName">Browse</div>
											<input type="file" multiple name="utility[]"
											<?php
											if ($userUtilityCount == 0) { ?>
												data-validation-engine="validate[required,funcCall[geThanUtility[]]]"
										<?php } ?>   id="chooseUtility">
										</div> 
									</div>
									<div id="uploadcertipreloader" style="display:none"><span>Uploading Document</span></div>
									
									<!-- Preview after upload -->
									<div id="utilityPreview" class="utilityPreview" style="display:none;">
										<a class="fancybox" rel="group" href="">
											<img src="" style="width:100px;" alt="">
										</a>
									</div>

									<!-- Preview of Saved Utility Bill or Statement (Database) -->
									<div id="utilityPreview" class="utilityPreviewData">
									<?php 
									if ($userUtilityCount > 0) { 
										while($userUtilityRow = mysql_fetch_assoc($userUtility)) {
											$utilityId = $userUtilityRow['id'];
											$utilityName = $userUtilityRow['utility'];
											$utilityUserId = $userUtilityRow['user_id'];
											$utilityMime = $userUtilityRow['utility_mime'];

											if($userUtilityRow['utility'] != ""){
									?>
									
									<?php if($utilityMime != 'pdf'){ ?>
										<span>
											<a class="fancybox" rel="group" href="<?php echo CUSTOMER_UTILITY_IMG_URL.$utilityName; ?>">
												<img src="<?php echo CUSTOMER_UTILITY_IMG_URL.$utilityName; ?>" style="width:100px;" alt="">
											</a>
											<input type="button" name="remove_certi" class="btn btn-srch-pc remove_certi" value="Remove" onclick="javascript:return removeUtility(<?php echo $utilityUserId ?>, <?php echo $utilityId ?>);">
										</span>
									<?php }else{ ?>
										<span>
											<a class="fancybox_pdf" rel="group" href="<?php echo CUSTOMER_UTILITY_IMG_URL.$utilityName; ?>">
												<img src="images/pdf_image.png" style="width:100px;" alt="">
											</a>
											<input type="button" name="remove_certi" class="btn btn-srch-pc remove_certi" value="Remove" onclick="javascript:return removeUtility(<?php echo $utilityUserId ?>, <?php echo $utilityId ?>);">
										</span>
									<?php } ?>
									<?php 
											} 
										} 
									}
									?>
									<div id="rmvcertipreloader" style="display:none"><span>Removing document</span></div>
									</div>
								</li>
								
							</ul>
							
							<?php } ?>
							
							<?php if($customer_type==1){ ?>
							<ul>
							    <li>
							     <label>Company Name<em>*</em></label>
							      <input class="txt_lg" name="company_name" id="company_name" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter your company name" value="<?php echo $c_name; ?>" type="text">
						        </li>
								<li class="clr_lft">
								     <label>First Name <em>*</em></label>
							         <input class="txt_lg" name="fname" id="fname" data-validation-engine="validate[required,custom[onlyLetterSp]]" data-errormessage-value-missing="Please enter your first name" value="<?php echo $first_name; ?>" type="text">
								</li>
								<li class="clr_lft">
								     <label>Last Name <em>*</em></label>
							         <input class="txt_lg" name="lname" data-validation-engine="validate[required,custom[onlyLetterSp]]" maxlength="50" data-errormessage-value-missing="Please enter your last name" id="lname" value="<?php echo $lastname; ?>" type="text">
								</li>
								<li class="clr_lft">
								     <label>Address Line 1 <em>*</em></label>
							         <input class="txt_lg" id="autocomplete" name="address_1"  id="address_1" data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter address line 1" value="<?php echo $address_1; ?>" type="text">
								</li>
								<li class="clr_lft">
								     <label>Address Line 2</label>
							         <input class="txt_lg" name="address_2" value="<?php echo $address_2; ?>"  id="address_2" type="text">
								</li>
								<li class="clr_lft">
								     <label>Address Line 3</label>
							         <input class="txt_lg" name="address_3"  value="<?php echo $address_3; ?>" id="address_3" type="text">
								</li>
								<li>
								     <label>Postcode <em>*</em></label>
							         <input class="txt_lg" name="postcode" id="postcode" data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter postcode" value="<?php echo $post_code; ?>" id="postcode" type="text">
								</li>
								<li class="clr_lft">
									<label>County<em>*</em></label>
								     <!-- <label>State<em>*</em></label> -->
							         <select name="state_id" id="state_id" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select county" onchange="getCities(this.value)">
								     <?php 
										$select_query = mysql_query("SELECT * FROM tblstates ORDER By name ASC");
										while($row = mysql_fetch_assoc($select_query)) { 
										$selected='';
										if($state_id==$row['id'])
										{
											$selected='selected';
										}
									?>
							
									<option value="<?php echo $row['id'] ?>" <?php echo $selected; ?>><?php echo $row['name']; ?></option>
								    <?php } ?>
							         </select>
								</li>
								<li>
									<label>Town / City <em>*</em></label>
									<select id="city_id" name="city_id" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select city">
									<option value="">Select City</option>
									<?php 
										//echo $state_id;exit();
										$select_query = mysql_query("SELECT * FROM tblcities WHERE state_id=".$state_id." ORDER By name ASC");
										while($row = mysql_fetch_assoc($select_query)) {
										$selected='';
										if($city_id==$row['id'])
										{
											$selected='selected';
										}
									?>
							
									<option value="<?php echo $row['id'] ?>" <?php echo $selected; ?>><?php echo $row['name']; ?></option>
									<?php } ?>
									</select>
								</li>
								<li>
								<label>Registration No<em>*</em></label>
								<input class="txt_lg" name="registration_no"  id="registration_no"  data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter registration no" value="<?php echo $reg_no;?>" type="text">
						        </li>
								<li>
									<label>VAT Registration No<em>*</em></label>
									<input class="txt_lg"  name="vat_registration_no" value="<?php echo $reg_vat_no;?>"  id="vat_registration_no" maxlength="12" data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter vat registration no" type="text">
								</li>
								<li>
								     <label>Email <em>*</em></label>
							         <input class="txt_lg" readonly="readonly" type="text" data-validation-engine="validate[required,custom[email]]" data-errormessage-value-missing="The e-mail address you entered appears to be incorrect." value="<?php echo $user_email; ?>" name="email" id="email" data-errormessage-custom-error="Example: yourscreenname@aol.com">
							         <!--<a class="a_vy" href="#">Verify</a>-->
								</li>



								<li class="mar_tp">
								     <label>Password <em>*</em></label>
							         <input class="txt_lg" name="password" type="password" value="<?php echo $pwd;?>" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter Password" readonly >
							         <a class="a_cp" href="JavaScript:Void(0);" data-toggle="modal" data-target="#changePassword">Change Password</a>
								</li>

								<div id="changePassword" class="modal fade" role="dialog">
									  <div class="modal-dialog">

									    <!-- Modal content-->
									    <div class="modal-content">
									      <div class="modal-header">
									        <button type="button" class="close" data-dismiss="modal">&times;</button>
									        <h4 class="modal-title">Re set your password</h4>
									      </div>
									      <div class="modal-body">
									        <form name="frm_change_password" action="" method="post">
												<ul>											
													<li>
													     <label>New Password <em>*</em></label>
												         <input class="txt_lg" name="new_password_detail" id="new_password_detail" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter your new password" value="" type="password">
													</li>

													<li>
													     <label>Re Enter Password <em>*</em></label>
												         <input class="txt_lg" name="re_enter_password_detail" id="re_enter_password_detail" data-validation-engine="validate[required]" data-errormessage-value-missing="Please re enter your new password" value="" type="password">
													</li>
												</ul>
											</form>
									      </div>
									      <div class="modal-footer">
									        <button type="button" class="btn btn-default" onclick="submit_pass_data();" data-dismiss="modal">Submit</button>
									      </div>
									    </div>

									  </div>
									</div>

									
									<script type="text/javascript">

										function submit_pass_data() {

										    var new_password = $("#new_password_detail").val();
										    var re_new_password = $("#re_enter_password_detail").val();

										    if (new_password == '' || re_new_password == '') {
										    	$('#changePassword').on('hide.bs.modal', function(e){
												    e.preventDefault();
												     e.stopImmediatePropagation();
												     return false;
												});	
										    }else{
										    	$.ajax({
										            url:"<?php echo SITE_URL.'profile-edit.php'; ?>",
										            type: "post",
										            dataType: 'json',
										           	data: {method: 'changePassword', new_password: new_password},
										            success:function(result){
										            if (result.status == 1) {
										            	alert(result.msg);
										            	location.reload();
										            }
										           }
										         });
										    }
										    									    

										    
										}										
									</script>



								<li >
								     <label>Contact No <em>*</em></label>
							         <input class="txt_lg" value="<?php echo $phone; ?>" name="phone" maxlength="12" data-validation-engine="validate[required,custom[onlyNumberSp]]" data-errormessage-value-missing="Please enter your phone number" type="tel">
							         <!--<a class="a_vy" href="#">Verify</a>-->
								</li>
                                
								<li>
									<label>PayPal Email (Should be Verified)<em>*</em></label>
									<input class="txt_lg" name="paypal_email" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter your paypal email" id="paypal_email" value="<?php echo $paypal_email; ?>" type="email" >
								</li>
								<li class="clr_lft">
									<label>Upload Profile Video </label>
							       <div class="file-upload">
                                      <div class="file-select">   
                                        <div class="file-select-name" id="noFile2"></div> 
                                         <div class="file-select-button" id="fileName2">Upload Video</div>
                                        <input type="file" name="profilevideo" id="chooseFile2">
                                      </div> 
                                   </div>
								   <div id="previewvideo"></div>
								   <div id="videopreloader" style="display:none"><span>Uploading Video</span></div>
								   <p class="vid_cli"><a href="#" data-toggle="modal" data-target="#videoMaker" id="videoMakers">Click here</a> to know how to make your profile video to attract more people and get better results</p>
								   
								   <?php if ($profilevideo!='') { ?>

								<div class="gd_vd gd_vd_profile">
								<?php if($profilevideo!=''){ ?>
									<!-- <a class="g_vd" href="#g_id1"><img class="prof_vid" src="images/play.png" alt=""/></a> -->
									<a class="g_vd" href="#g_id1"><img class="prof_vid" src="" alt=""/></a>
									<div>
									<?php $videoSrc = CUSTOMER_PROFILE_VIDEO_URL.$profilevideo; ?>
										<video width="700" height="450">
											<source src="<?php echo $videoSrc ?>" type="video/mp4"> Your browser does not support the video tag.
										</video> 
									</div>
								<?php } ?>
								</div>

								<div style="display: none;">
									<div class="gd_pop" id="g_id1">
										<?php $videoSrc = CUSTOMER_PROFILE_VIDEO_URL.$profilevideo; ?>
										<video width="700" height="450" controls src="<?php echo CUSTOMER_PROFILE_VIDEO_URL.$profilevideo ?>"></video>
									</div>
								</div>

								<!-- Remove Video Button -->
								<?php if($profilevideo!=''){ ?>
								<input type="button" name="remove_video" class="btn btn-srch-pc remove_video" value="Remove" onclick="javascript:return removeProfileVideo();">
								<div id="rmvvideopreloader" style="display:none"><span>Removing Video</span></div>
								<?php } ?>

								<?php } ?>
								</li>

                                <!-- Upload Company Certificate -->
								<?php 
								$userCompanyCertiCount=0;
								if(isset($_SESSION['user_id']) && $_SESSION['user_id']!='') {
									$userCompanyCerti=mysql_query("select * from tbl_user_comp_certi where user_id=".$_SESSION['user_id']."");
									$userCompanyCertiCount=mysql_num_rows($userCompanyCerti);
								}
								?>
								<li class="clr_lft">
									<label>Upload Company Reg Certificate <em>*</em></label>
									<div class="file-upload">
										<div class="file-select">   
											<div class="file-select-name" id="noFile"></div> 
											<div class="file-select-button" id="fileName">Browse</div>
											<input type="file" multiple name="companycerti[]" <?php if ($userCompanyCertiCount == 0) { ?>
												data-validation-engine="validate[required,funcCall[geThanCompanyCerti[]]]"
										<?php } ?>  id="chooseCompanyCerti">
										</div> 
									</div>
									<div id="uploadcertipreloader" style="display:none"><span>Uploading Document</span></div>
									
									<!-- Preview after upload -->
									<div id="companyCertiPreview" class="companyCertiPreview" style="display:none;">
										<a class="fancybox" rel="group" href="">
											<img src="" style="width:100px;" alt="">
										</a>
									</div>

									<!-- Preview of Saved Company Certificate (Database) -->
									<div id="companyCertiPreview" class="companyCertiPreviewData">
									<?php 
									if ($userCompanyCertiCount > 0) { 
										while($userCompanyCertiRow = mysql_fetch_assoc($userCompanyCerti)) {
											$companyCertiId = $userCompanyCertiRow['id'];
											$companyCertiName = $userCompanyCertiRow['comp_certi'];
											$companyCertiUserId = $userCompanyCertiRow['user_id'];
											$companyCertiMime = $userCompanyCertiRow['comp_certi_mime'];

											if($userCompanyCertiRow['comp_certi'] != ""){
									?>
									
									<?php if($companyCertiMime != 'pdf'){ ?>
										<span>
											<a class="fancybox" rel="group" href="<?php echo CUSTOMER_COMPANYCERTI_IMG_URL.$companyCertiName; ?>">
												<img src="<?php echo CUSTOMER_COMPANYCERTI_IMG_URL.$companyCertiName; ?>" style="width:100px;" alt="">
											</a>
											<input type="button" name="remove_certi" class="btn btn-srch-pc remove_certi" value="Remove" onclick="javascript:return removeCompanyCerti(<?php echo $companyCertiUserId ?>, <?php echo $companyCertiId ?>);">
										</span>
									<?php }else{ ?>
										<span>
											<a class="fancybox_pdf" rel="group" href="<?php echo CUSTOMER_COMPANYCERTI_IMG_URL.$companyCertiName; ?>">
												<img src="images/pdf_image.png" style="width:100px;" alt="">
											</a>
											<input type="button" name="remove_certi" class="btn btn-srch-pc remove_certi" value="Remove" onclick="javascript:return removeCompanyCerti(<?php echo $companyCertiUserId ?>, <?php echo $companyCertiId ?>);">
										</span>
									<?php } ?>
									<?php 
											} 
										}
									}
									?>
									<div id="rmvcertipreloader" style="display:none"><span>Removing document</span></div>
									</div>
								</li>

                                <!-- Upload Passport / Driving License --> 
								<?php 
								$userLicense=0;
								if(isset($_SESSION['user_id']) && $_SESSION['user_id']!='') {
									$userLicense=mysql_query("select * from tbl_user_license_passport where user_id=".$_SESSION['user_id']."");
									$userLicenseCount=mysql_num_rows($userLicense);
								}
								?>
								<li class="clr_lft">
									<label>Upload Passport / Driving License <em>*</em></label>
									<div class="file-upload">
										<div class="file-select">   
											<div class="file-select-name" id="noFile"></div> 
											<div class="file-select-button" id="fileName">Browse</div>
											<input type="file" multiple name="license[]" formnovalidate="formnovalidate" <?php if ($userLicenseCount==0) { ?>
												data-validation-engine="validate[required]"
											<?php } ?>  value=""  id="chooseLicense">
										</div> 
									</div>
									<div id="uploadcertipreloader" style="display:none"><span>Uploading Document</span></div>
									
									<!-- Preview after upload -->
									<div id="licensePreview" class="licensePreview" style="display:none;">
										<a class="fancybox" rel="group" href="">
											<img src="" style="width:100px;" alt="">
										</a>
									</div>

									<!-- Preview of Saved Passport/License (Database) -->
									<div id="licensePreview" class="licensePreviewData">
									<?php 
									if ($userLicenseCount > 0) { 
										while($userLicenseRow = mysql_fetch_assoc($userLicense)) {
											$licenseId = $userLicenseRow['id'];
											$licenseName = $userLicenseRow['license_passport'];
											$licenseUserId = $userLicenseRow['user_id'];
											$licenseMime = $userLicenseRow['license_passport_mime'];

											if($userLicenseRow['license_passport'] != ""){
									?>
									
									<?php if($licenseMime != 'pdf'){ ?>
										<span>
											<a class="fancybox" rel="group" href="<?php echo CUSTOMER_LICENSEPASSPORT_IMG_URL.$licenseName; ?>">
												<img src="<?php echo CUSTOMER_LICENSEPASSPORT_IMG_URL.$licenseName; ?>" style="width:100px;" alt="">
											</a>
											<input type="button" name="remove_certi" class="btn btn-srch-pc remove_certi" value="Remove" onclick="javascript:return removeLicense(<?php echo $licenseUserId ?>, <?php echo $licenseId ?>);">
										</span>
									<?php }else{ ?>
										<span>
											<a class="fancybox_pdf" rel="group" href="<?php echo CUSTOMER_LICENSEPASSPORT_IMG_URL.$licenseName; ?>">
												<img src="images/pdf_image.png" style="width:100px;" alt="">
											</a>
											<input type="button" name="remove_certi" class="btn btn-srch-pc remove_certi" value="Remove" onclick="javascript:return removeLicense(<?php echo $licenseUserId ?>, <?php echo $licenseId ?>);">
										</span>
									<?php } ?>
									<?php 
											} 
										}
									}
									?>
									<div id="rmvcertipreloader" style="display:none"><span>Removing document</span></div>
									</div>
								</li>


                                <!-- Utility Bill or Statement -->
								<?php 
								/* $userUtilityCount=0;
								if(isset($_SESSION['user_id']) && $_SESSION['user_id']!='') {
									$userUtility=mysql_query("select * from tbl_user_utility where user_id=".$_SESSION['user_id']."");
									$userUtilityCount=mysql_num_rows($userUtility);
								}
								?>
								<li class="clr_lft">
									<label>Utility Bill or Statement less than 3 months old with current address</label>
									<div class="file-upload">
										<div class="file-select">   
											<div class="file-select-name" id="noFile"></div> 
											<div class="file-select-button" id="fileName">Browse</div>
											<input type="file" multiple name="utility[]" data-validation-engine="validate[funcCall[geThanUtility[]]]"  id="chooseUtility">
										</div> 
									</div>
									<div id="uploadcertipreloader" style="display:none"><span>Uploading Document</span></div>
									
									
									<div id="utilityPreview" class="utilityPreview" style="display:none;">
										<a class="fancybox" rel="group" href="">
											<img src="" style="width:100px;" alt="">
										</a>
									</div>

									
									<div id="utilityPreview" class="utilityPreviewData">
									<?php 
									if ($userUtilityCount > 0) { 
										while($userUtilityRow = mysql_fetch_assoc($userUtility)) {
											$utilityId = $userUtilityRow['id'];
											$utilityName = $userUtilityRow['utility'];
											$utilityUserId = $userUtilityRow['user_id'];
											$utilityMime = $userUtilityRow['utility_mime'];

											if($userUtilityRow['utility'] != ""){
									?>
									
									<?php if($utilityMime != 'pdf'){ ?>
										<span>
											<a class="fancybox" rel="group" href="<?php echo CUSTOMER_UTILITY_IMG_URL.$utilityName; ?>">
												<img src="<?php echo CUSTOMER_UTILITY_IMG_URL.$utilityName; ?>" style="width:100px;" alt="">
											</a>
											<input type="button" name="remove_certi" class="btn btn-srch-pc remove_certi" value="Remove" onclick="javascript:return removeUtility(<?php echo $utilityUserId ?>, <?php echo $utilityId ?>);">
										</span>
									<?php }else{ ?>
										<span>
											<a class="fancybox_pdf" rel="group" href="<?php echo CUSTOMER_UTILITY_IMG_URL.$utilityName; ?>">
												<img src="images/pdf_image.png" style="width:100px;" alt="">
											</a>
											<input type="button" name="remove_certi" class="btn btn-srch-pc remove_certi" value="Remove" onclick="javascript:return removeUtility(<?php echo $utilityUserId ?>, <?php echo $utilityId ?>);">
										</span>
									<?php } ?>
									<?php 
											} 
										} 
									}
									?>
									<div id="rmvcertipreloader" style="display:none"><span>Removing document</span></div>
									</div>
								</li>
								<?php */ ?>

							</ul>

							<?php } ?>
							<div class="nextbtn">
				            	<input value="Save" name="submit" class="btn_lg" type="submit">				
				            </div>
							
						</div>
						
					</div>
					</form>
				</div>
			
				
			</div>
			
		</div>
	</div>
</div>
<?php
/* Queries for Modal for terms and policy */
$sqlTerms='select title,content from tblcmspages where page_id=10';
$resTerms = mysql_query($sqlTerms);
$fetchTerms = mysql_fetch_array($resTerms);
$contentTerms = $fetchTerms['content'];
$descTerms = $contentTerms;

$sqlPrivacy = 'select title,content from tblcmspages where page_id=9';
$resPrivacy = mysql_query($sqlPrivacy);
$fetchPrivacy = mysql_fetch_array($resPrivacy);
$contentPrivacy = $fetchPrivacy['content'];
$descPrivacy = $contentPrivacy;
?>

<!-- Modal for terms of conditions -->
<div class="modal fade" id="postingFees">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
		
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title"><center>Terms & Conditions</center></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			
			<!-- Modal body -->
			<div class="modal-body">
				<center><?php echo $descTerms; ?></center>
			</div>
			
			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" class="btn fees-modal-button" data-dismiss="modal">Accept</button>
			</div>
			
		</div>
	</div>
</div>

<!-- Modal for terms of privacy policy -->
<div class="modal fade" id="privacy">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
		
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title"><center>Privacy Policy</center></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			
			<!-- Modal body -->
			<div class="modal-body">
				<center><?php echo $descPrivacy; ?></center>
			</div>
			
			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" class="btn fees-modal-button" data-dismiss="modal">Close</button>
			</div>
			
		</div>
	</div>
</div>
<?php if($customer_type==2){ ?>
<script>
	if(document.getElementById('rd11').checked) {
		document.getElementById('sia_number').style.display ='block';
	}
</script>
<?php } ?>

<!-- Script for image cropping -->
<script type="text/javascript">
let result = document.querySelector('.result'),
img_result = document.querySelector('.img-result'),
img_w = document.querySelector('.img-w'),
img_h = document.querySelector('.img-h'),
options = document.querySelector('.options'),
save = document.querySelector('.save'),
cancel = document.querySelector('.cancel'),
cropped = document.querySelector('.cropped'),
upload = document.querySelector('#chooseFile'),
cropper = '';

/* clear the file before (change) of image */
upload.addEventListener('click', (e) => {
	upload.value = null;
});

/* on change show image with crop options */
upload.addEventListener('change', (e) => {
	$('.cropped').show();
	$("main.page").show();
  if (e.target.files.length) {
		// start file reader
    const reader = new FileReader();
    reader.onload = (e)=> {
      if(e.target.result){
			// create new image
			let img = document.createElement('img');
			img.id = 'image';
			img.src = e.target.result
			// clean result before
			result.innerHTML = '';
			// append new image
        	result.appendChild(img);
			// show save btn and options
			save.classList.remove('hide');
			cancel.classList.remove('hide');
			options.classList.remove('hide');
			// init cropper
			cropper = new Cropper(img, {
				aspectRatio: 16 / 16,
				viewMode: 2,
				zoomable: false,
				zoomOnTouch: false,	
				
			});
      }
    };
    reader.readAsDataURL(e.target.files[0]);
  }
});

/* Save on click */
save.addEventListener('click',(e)=>{
$("main.page").hide();
  e.preventDefault();
  // get result to data uri
  let imgSrc = cropper.getCroppedCanvas({
		width: img_w.value // input value
	}).toDataURL();
	
  // remove hide class of img

	// show image cropped
  cropped.src = imgSrc;
  $('input#saveprofileimage').val(imgSrc);
});

/* Cancel on click */
cancel.addEventListener('click',(e)=>{
	$("main.page").hide();
	<?php if($img){ ?>
		$("#uploadedImage").attr("src","<?php echo $img; ?>");
	<?php }else{ ?>
		$("#uploadedImage").hide();
	<?php } ?>
	reset();
});

</script>

<script>
      // This example displays an address form, using the autocomplete feature
      // of the Google Places API to help users fill in the information.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      var placeSearch, autocomplete;
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };

      function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});
        autocomplete.setComponentRestrictions(
            {'country': ['UK', 'pr', 'vi', 'gu', 'mp']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
      }

      function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
          document.getElementById(component).value = '';
          document.getElementById(component).disabled = false;
        }

        

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
          }
        }
      }

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
    </script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_JUu2G9vlijX1UgNTylx55U1hZQqw6QI&libraries=places&callback=initAutocomplete"
async defer></script>
<?php include "footer.php"; ?>
<?php include('admin/inc/validation.php'); ?>
</body>
</html>