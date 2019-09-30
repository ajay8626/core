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

if(isset($_SESSION['user_id']) && $_SESSION['user_id']!='')
{
	$sql="select * from tbluser where user_id=".$_SESSION['user_id']."";
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
	$sia=$rows['sia'];
	$activity=$rows['activity'];
	$health=$rows['health'];
	$bio=$rows['bio'];
	$state_id=$rows['state_id'];
	$city_id=$rows['city_id'];
	
	$date = '';
	if($birthdate != '' && $birthdate != '1970-01-01')
	{
		$date = date('d/m/Y',strtotime($birthdate));
	}
	
}
if(isset($_POST['submit']) && $_POST['submit']!='')
{
	$a_name =	isset($_REQUEST["fname"])?$_REQUEST["fname"]:''; 
$a_lname =	isset($_REQUEST["lname"])?$_REQUEST["lname"]:''; 
//$country_id =	isset($_REQUEST["country_id"])?$_REQUEST["country_id"]:0; 
$state_id =	isset($_REQUEST["state_id"])?$_REQUEST["state_id"]:0; 
$city_id =	isset($_REQUEST["city_id"])?$_REQUEST["city_id"]:0; 
//$customer_type =	$_REQUEST["customer_type"]; 

$status = 	isset($_REQUEST["status"])?$_REQUEST["status"]:0;
$a_email = 	isset($_REQUEST["email"])?$_REQUEST["email"]:'';  
$phone = 	isset($_REQUEST["phone"])?$_REQUEST["phone"]:'';  
$address_1 = 	isset($_REQUEST["address_1"])?$_REQUEST["address_1"]:'';  
$address_2 = 	isset($_REQUEST["address_2"])?$_REQUEST["address_2"]:'';  
$address_3 = 	isset($_REQUEST["address_3"])?$_REQUEST["address_3"]:'';  

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
$sia = 	isset($_REQUEST["sia"])?$_REQUEST["sia"]:0;
$activity = 	isset($_REQUEST["activity"])?$_REQUEST["activity"]:'';
$health = 	isset($_REQUEST["health"])?$_REQUEST["health"]:0;
$bio = 	isset($_REQUEST["bio"])?$_REQUEST["bio"]:0;

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
if($address!='')
				{
					$address=substr($address,0,-1);
				}
				
				$latlong    =   get_lat_long($address);
				$map        =   explode(',' ,$latlong);
			    $mapLat     =   $map[0];
			    $mapLong    =   $map[1];
				
			
			$data = array('firstname'=>$a_name,'lastname'=>$a_lname,'phone'=>$phone,'email'=>$a_email,'address_1'=>$address_1,'address_2'=>$address_2,'address_3'=>$address_3,'modified_date'=>date('Y-m-d H:i:s'),'bank_name'=>$bank_name,'acc_holder_name'=>$acc_holder_name,'sort_code'=>$sort_code,'acc_number'=>$acc_number,'reg_no'=>$registration_no,'reg_vat_no'=>$vat_registration_no,'company_name'=>$company_name,'city_id'=>$city_id,'state_id'=>$state_id,'birthdate'=>$birthdate,'gender'=>$gender,'height'=>$height,'build'=>$build,'nationality'=>$nationality,'language'=>$language,'militry'=>$militry,'drive'=>$drive,'firstaid'=>$firstaid,'tattoos'=>$tattoos,'sia'=>$sia,'activity'=>$activity,'health'=>$health,'bio'=>$bio,'latitude'=>$mapLat,'longitude'=>$mapLong);
			
			if($newfilename!='')
			{
				$profile_image = $newfilename;
				$imageArray = array('profile_image'=>$profile_image);
				$data = array_merge($data,$imageArray);
			}
			
			if($rmavatarvideo==1 || $newfilename1!='')
			{
				
				$profilevideo = $newfilename1;
				$videoArray = array('profilevideo'=>$profilevideo);
				$data = array_merge($data,$videoArray);
			}
			
			if($_REQUEST['password'] != ''){
				$password  =  	md5($_REQUEST['password']);	
				
				$pwd = array('password'=>$password);
				$data = array_merge($data,$pwd);
			}
			
			$where ="user_id ={$_SESSION['user_id']}";
		
			$db->Update($data,"tbluser",$where);	
			
			$_SESSION['mt'] = "success";
			$_SESSION['me'] = "User Update Successfully.";
			if($customer_type==1)
			{
			header('Location:business-profile.php');
			exit;
			}
			if($customer_type==2)
			{
			header('Location:individual-profile.php');
			exit;
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
<link href="css/responsive.css" rel="stylesheet">
<link href="fonts/font-awesome.css" rel="stylesheet">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.bxslider.js"></script>
<script type="text/javascript" src="js/menu.js"></script>
<script src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/at-jquery.js"></script> 
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({includedLanguages: '<?php echo LanguageList; ?>', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script>
  <script>
  
 jQuery( function() {
    jQuery( "#datepicker" ).datepicker({dateFormat: 'dd/mm/yy',maxDate: 0});
  } );
  getCities(<?php echo $state_id; ?>);
  function getCities(val) {
		$.ajax({
			type: "POST",
			url: "<?php echo ADMIN_URL ?>phpajax/get_city.php",
			data:'state_id='+val+'&city_id=<?php echo $city_id; ?>',
			success: function(data){
				$("#city_id").html(data);	
			}
		});
	}
	
	function geThan(){
	
	var extFile  = document.getElementById("chooseFile").value;	
	if(extFile!='') {
	var ext = extFile.split('.').pop();
	var filesAllowed = ["jpg", "jpeg", "png"];
	if( (filesAllowed.indexOf(ext)) == -1)
		return "Only JPG , PNG files are allowed";
	}
}
  </script>

</head>
<body>
<?php include "header-inner.php"; ?>

<div class="stj_login_wrap stj_reg_wrap">
	<div class="container">
		<div class="row">
			
			<div class="reg_dv">
				<h2>Edit Profile</h2>
				<div class="jobdetail">
				<form method="post" name="edit-profile" enctype="multipart/form-data" class="validateForm" action="">
					<ul class="jobtab">
						<li class="active"><a href="#"><?php echo $activetitle; ?></a></li>
						<li><a href="javascript:void(0);"></a></li>
					</ul>
					<div class="jobmain">
					
						<div class="jobleft">
						
					<ul>	
					<?php 
					if($customer_type==2)
					{
					?>
					
					        <li>
							<label>Upload Profile Picture</label>
							 <div class="file-upload">
							  <div class="file-select">   
								<div class="file-select-name" id="noFile"></div> 
								 <div class="file-select-button" id="fileName">Browse</div>
								<input type="file" name="profileimage" data-validation-engine="validate[funcCall[geThan[]]]" 
							  data-errormessage-value-missing="Only JPG and PNG are allowed" id="profileimage">
							  </div> 
  
                            </div>
							<?php 
							if($profile_image!=''){
								$src=CUSTOMER_PROFILE_IMG_URL.get_image_thumbnail($profile_image); 
							
							?>
							<img src="<?php echo $src; ?>" style="width:100px;"   />
							<?php } ?>
							
						</li>	
							<li>
							<label>First Name <em>*</em></label>
							<input class="txt_lg" name="fname" id="fname" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter your first name" value="<?php echo $first_name; ?>" type="text">
						</li>				
						<li>
							<label>Last Name <em>*</em></label>
							<input class="txt_lg" name="lname" data-validation-engine="validate[required]" maxlength="50" data-errormessage-value-missing="Please enter your last name" id="lname" value="<?php echo $lastname; ?>" type="text">
						</li>
                        <li>
							<label>Address Line 1<em>*</em></label>
							<input class="txt_lg" name="address_1"  id="address_1" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter address line 1" value="<?php echo $address_1; ?>" type="text">
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
							<label>County<em>*</em></label>
							<select name="state_id" id="state_id" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select county" onchange="getCities(this.value)">
								<option value="">Select County</option>
							<?php 
								$select_query = mysql_query("SELECT * FROM tblstates where country_id='230' ORDER By 'name' ASC");
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
							<label>City<em>*</em></label>
							<select id="city_id" name="city_id" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select city">
								<option value="">Select City</option>
							
							</select>
						</li>
		           		<li>
							<label>Email<em>*</em></label>
							<input class="txt_lg" type="email" data-validation-engine="validate[required,custom[email]]" data-errormessage-value-missing="The e-mail address you entered appears to be incorrect." value="<?php echo $user_email; ?>" name="email" id="email" data-errormessage-custom-error="Example: yourscreenname@aol.com">
						</li>
                        <li>
							<label>Contact No<em>*</em></label>
							<input class="txt_lg" value="<?php echo $phone; ?>" name="phone" maxlength="12" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter your phone number" type="text">
						</li>
                        <li>
							<label>Password</label>
							<input class="txt_lg" name="password" type="password" >
						</li>
						<li>
							<label>PayPal Email</label>
							<input class="txt_lg" name="paypal_email" id="paypal_email" value="" type="text" >
						</li>
                        <li>
							<label>Bank Name<em>*</em></label>
							<input class="txt_lg" name="bank_name"  value="<?php echo $bank_name;?>" id="bank_name" maxlength="250" data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter bank name" type="text">
						</li>
                        <li>
							<label>Account Holder's Name<em>*</em></label>
							<input class="txt_lg" name="acc_holder_name"  value="<?php echo $acc_holder_name;?>" data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter account holders name" id="acc_holder_name" type="text">
						</li>
                        <li>
							<label>Sort Code<em>*</em></label>
							<input class="txt_lg" name="sort_code" value="<?php echo $sort_code;?>"  data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter sort code" id="sort_code" type="text">
						</li>
                         <li>
							<label>AccountNo<em>*</em></label>
							<input class="txt_lg" name="acc_number" value="<?php echo $acc_number;?>"  maxlength="250" data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter account number" id="acc_number" type="text">
						</li>						
						<li>
							<label>Upload Profile Video</label>
							 <div class="file-upload">
							  <div class="file-select">   
								<div class="file-select-name" id="noFile"></div> 
								 <div class="file-select-button" id="fileName">Browse</div>
								<input type="file" name="profilevideo"    id="chooseFile">
							  </div> 
  
							</div>
							<?php if($profile_video!=''){ ?>
                            <a href="<?php echo CUSTOMER_PROFILE_VIDEO_URL.$profile_video ?>" target="_blank">Profile Video</a>
							<?php } ?>
						</li>
                        <li>
							<label>Date of Birth <em>*</em></label>
							<input type="text" name="birthdate" style="width:200px;" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select birth Date" value="<?php echo $date;  ?>" class="txt_lg datepkr"  id="datepicker">
						</li>							
							<li>
							<label>Gender <em>*</em></label>
							<div class="radio">
								<div class="rdrow">
								<input name="gender" id="rd1" value="1" <?php if($gender==1){ ?> checked <?php } ?> class="rd_chk" type="radio">
								<label for="rd1">Male</label></div>
								<div class="rdrow">
									<input name="gender" id="rd2" value="2" <?php if($gender==2){ ?> checked <?php } ?> class="rd_chk" type="radio">
								<label for="rd2">Female</label></div>
							</div>
						</li>	
						<li>
							<label>Height (in Cms)<em>*</em></label>
							<input class="txt_lg" name="height" value="<?php echo $height; ?>" style="width:200px;" id="height" maxlength="3" type="text">
						</li>	
							 <li>
							<label>Build<em>*</em></label>
							<select name="build" id="build" style="width:200px;">
							     <option value="">Select Build</option>
								<?php 
								$select_query = mysql_query("SELECT * FROM tblbuild where status=1 ORDER By 'name' ASC"); 
								 while($row = mysql_fetch_assoc($select_query)) {
								?>
									<option value="<?php echo $row['name']; ?>" <?php if($build==$row['name']){ ?> selected <?php } ?>><?php echo $row['name']; ?></option>
									<?php } ?>	
							</select>
						</li>
                        <li>
							<label>Nationality<em>*</em></label>
							<select name="nationality" id="nationality" style="width:200px;">
								<option value="">Select Nationality</option>
									<?php 
								$select_query = mysql_query("SELECT * FROM tblnationality where status=1 ORDER By 'name' ASC"); 
								 while($row = mysql_fetch_assoc($select_query)) {
								?>
									<option value="<?php echo $row['name']; ?>"  <?php if($nationality==$row['name']){ ?> selected <?php } ?>><?php echo $row['name']; ?></option>
									<?php } ?>
							</select>
						</li>
						<?php
							
							$lang=array();
							if($language!='')
							{
								$lang=explode(",",$language);
							}
							?>
						
                          <li>
							<label>Languages Spoken</label>
							<div class="tk2">
							      <?php 
								$select_query = mysql_query("SELECT * FROM 	tbllanguage where status=1 ORDER By 'name' ASC"); 
								$i=1;
								 while($row = mysql_fetch_assoc($select_query)) {
								?>
								<input type="checkbox" id="ckbox<?php echo $i?>" name="language[]" value="<?php echo $row['name']; ?>" <?php if(in_array($row['name'],$lang)){ ?> checked <?php } ?> ><label for="ckbox<?php echo $i?>"><?php echo $row['name']; ?></label>
								 <?php $i++; } ?>
								
								
							 </div>
						</li>
                         <li>
							<label>Militry Background</label>
							<div class="radio">
								<div class="rdrow">
								<input name="militry" id="rd3" value="1"  <?php if($militry==1){ ?> checked <?php } ?> class="rd_chk" type="radio">
								<label for="rd3">Yes</label></div>
								<div class="rdrow">
									<input name="militry" id="rd4" value="2" <?php if($militry==2){ ?> checked <?php } ?> class="rd_chk" type="radio">
								<label for="rd4">No</label></div>
							</div>
						</li>
                        <li>
							<label>Do you drive?</label>
							<div class="radio">
								<div class="rdrow">
								<input name="drive" id="rd5" value="1" <?php if($drive==1){ ?> checked <?php } ?> class="rd_chk" type="radio">
								<label for="rd5">Yes</label></div>
								<div class="rdrow">
									<input name="drive" id="rd6" value="2" <?php if($drive==2){ ?> checked <?php } ?> class="rd_chk" type="radio">
								<label for="rd6">No</label></div>
							</div>
						</li>
                        <li>
							<label>First aid & Paramedic training?</label>
							<div class="radio">
								<div class="rdrow">
								<input name="firstaid" id="rd7" value="1" <?php if($firstaid==1){ ?> checked <?php } ?> class="rd_chk" type="radio">
								<label for="rd7">Yes</label></div>
								<div class="rdrow">
									<input name="firstaid" id="rd8" value="2" <?php if($firstaid==2){ ?> checked <?php } ?> class="rd_chk" type="radio">
								<label for="rd8">No</label></div>
							</div>
						</li>						
						<li>
							<label>Tattoos & Piercing?</label>
							<div class="radio">
								<div class="rdrow">
								<input name="tattoos" id="rd9" value="1" <?php if($tattoos==1){ ?> checked <?php } ?> class="rd_chk" type="radio">
								<label for="rd9">Yes</label></div>
								<div class="rdrow">
									<input name="tattoos" id="rd10" value="2" <?php if($tattoos==2){ ?> checked <?php } ?> class="rd_chk" type="radio">
								<label for="rd10">No</label></div>
							</div>
						</li>	
							<li>
							<label>SIA Badge?</label>
							<div class="radio">
								<div class="rdrow">
								<input name="sia" id="rd11" value="1" <?php if($sia==1){ ?> checked <?php } ?> class="rd_chk" type="radio">
								<label for="rd11">Yes</label></div>
								<div class="rdrow">
									<input name="sia" id="rd12" value="2" <?php if($sia==2){ ?> checked <?php } ?> class="rd_chk" type="radio">
								<label for="rd12">No</label></div>
							</div>
						</li>	
								
							
								<li>
							<label>Any Ailments that could impair activity to work?</label>
							<textarea name="activity"><?php echo $activity; ?></textarea>
						</li>
									<li>
							<label>Any Health Issues?</label>
							<textarea name="health"><?php echo $health; ?></textarea>
						</li>
						 <li>
							<label>Bio</label>
							<textarea name="bio"><?php echo $bio; ?></textarea>
						</li>
						<?php } ?>
						
					<?php 
					if($customer_type==1)
					{
					?>
					<li>
							<label>Upload Profile Picture</label>
							 <div class="file-upload">
							  <div class="file-select">   
								<div class="file-select-name" id="noFile"></div> 
								 <div class="file-select-button" id="fileName">Browse</div>
								<input type="file" name="profileimage" data-validation-engine="validate[funcCall[geThan[]]]" 
							  data-errormessage-value-missing="Only JPG and PNG are allowed" id="profileimage">
							  </div> 
  
                            </div>
							<?php 
							if($profile_image!=''){
								$src=CUSTOMER_PROFILE_IMG_URL.get_image_thumbnail($profile_image); 
							
							?>
							<img src="<?php echo $src; ?>" style="width:100px;"   />
							<?php } ?>
						</li>
                            <li>
							<label>Company Name<em>*</em></label>
							<input class="txt_lg" name="company_name" id="company_name" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter your company name" value="<?php echo $c_name; ?>" type="text">
						</li>						
							<li>
							<label>First Name <em>*</em></label>
							<input class="txt_lg" name="fname" id="fname" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter your first name" value="<?php echo $first_name; ?>" type="text">
						</li>				
						<li>
							<label>Last Name <em>*</em></label>
							<input class="txt_lg" name="lname" data-validation-engine="validate[required]" maxlength="50" data-errormessage-value-missing="Please enter your last name" id="lname" value="<?php echo $lastname; ?>" type="text">
						</li>
                        <li>
							<label>Address Line 1<em>*</em></label>
							<input class="txt_lg" name="address_1"  id="address_1" data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter address line 1" value="<?php echo $address_1; ?>" type="text">
						</li>
						<li>
							<label>Address Line 2</label>
							<input class="txt_lg" name="address_2" value="<?php echo $address_2; ?>" id="address_2" type="text">
						</li>
						<li>
							<label>Address Line 3</label>
							<input class="txt_lg" name="address_3" value="<?php echo $address_3; ?>"  id="address_3" type="text">
						</li>
						<li>
							<label>County<em>*</em></label>
							<select name="state_id" id="state_id" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select county" onchange="getCities(this.value)">
								<option value="">Select County</option>
							<?php 
								$select_query = mysql_query("SELECT * FROM tblstates where country_id='230' ORDER By 'name' ASC");
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
							<label>City<em>*</em></label>
							<select id="city_id" name="city_id" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select city">
								<option value="">Select City</option>
							
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
							<label>Email<em>*</em></label>
							<input class="txt_lg" type="email" value="<?php echo $user_email; ?>" data-validation-engine="validate[required,custom[email]]" data-errormessage-value-missing="The e-mail address you entered appears to be incorrect." name="email" id="email" data-errormessage-custom-error="Example: yourscreenname@aol.com">
						</li>
                        <li>
							<label>Contact No<em>*</em></label>
							<input class="txt_lg" name="phone" maxlength="12" data-validation-engine="validate[required]" value="<?php echo $phone; ?>" data-errormessage-value-missing="Please enter your phone number" type="text">
						</li>
                        <li>
							<label>Password</label>
							<input class="txt_lg" name="password" id="password" value="" type="password" >
						</li>
						<li>
							<label>PayPal Email</label>
							<input class="txt_lg" name="paypal_email" id="paypal_email" value="" type="text" >
						</li>
						<li>
							<label>Upload Profile Video</label>
							 <div class="file-upload">
							  <div class="file-select">   
								<div class="file-select-name" id="noFile"></div> 
								 <div class="file-select-button" id="fileName">Browse</div>
								<input type="file" name="profilevideo"  id="chooseFile">
							  </div> 
  
							</div>
						</li>
						<li>
							<label>Bank Name<em>*</em></label>
							<input class="txt_lg" name="bank_name"  value="<?php echo $bank_name;?>" id="bank_name" maxlength="250" data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter bank name" type="text">
						</li>
                        <li>
							<label>Account Holder's Name<em>*</em></label>
							<input class="txt_lg" name="acc_holder_name" value="<?php echo $acc_holder_name;?>"  data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter account holders name" id="acc_holder_name" type="text">
						</li>
                        <li>
							<label>Sort Code<em>*</em></label>
							<input class="txt_lg" name="sort_code" value="<?php echo $sort_code;?>"  data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter sort code" id="sort_code" type="text">
						</li>
                         <li>
							<label>AccountNo<em>*</em></label>
							<input class="txt_lg" name="acc_number" value="<?php echo $acc_number;?>"  maxlength="250" data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter account number" id="acc_number" type="text">
						</li>
					<?php } ?>
						
					</ul>
					
					
				</div>
		 		
				</div>
					
					<div class="nextbtn">
					<input value="Save" name="submit" class="btn_lg" type="submit">				
				</div>
				</form>
				</div>
			
				
			</div>
			
		</div>
	</div>
</div>
 
<?php include "footer.php"; ?>
<?php include('admin/inc/validation.php'); ?>
</body>
</html>