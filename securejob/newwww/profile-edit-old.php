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
		$piercing=$rows['piercing'];
		$sia=$rows['sia'];
		$sia_1 = $rows['sia_1'];
		$sia_2 = $rows['sia_2'];
		$sia_3 = $rows['sia_3'];
		$sia_4 = $rows['sia_4'];
		$activity=$rows['activity'];
		$health=$rows['health'];
		$bio=$rows['bio'];
		$state_id=$rows['state_id'];
		$city_id=$rows['city_id'];
		$paypal_email=$rows['paypal_email'];
		$paremedic=$rows['paremedic'];
		$date = '';
		if($birthdate != '' && $birthdate != '1970-01-01')
		{
			$date = date('d/m/Y',strtotime($birthdate));
		}
    }
	
	if(isset($_POST['submit']) && $_POST['submit']!='')
    {
	  //echo '111';
	 // exit;
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
	$language = 	isset($_REQUEST["language"])? implode(", ",$_REQUEST["language"]):'';
	$militry = 	isset($_REQUEST["militry"])?$_REQUEST["militry"]:0;
	$drive = 	isset($_REQUEST["drive"])?$_REQUEST["drive"]:0;
	$firstaid = 	isset($_REQUEST["firstaid"])?$_REQUEST["firstaid"]:0;
	$tattoos = 	isset($_REQUEST["tattoos"])?$_REQUEST["tattoos"]:0;
	$piercing = 	isset($_REQUEST["piercing"])?$_REQUEST["piercing"]:0;
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
				
			
			$data = array('firstname'=>$a_name,'lastname'=>$a_lname,'phone'=>$phone,'email'=>$a_email,'address_1'=>$address_1,'address_2'=>$address_2,'address_3'=>$address_3,'modified_date'=>date('Y-m-d H:i:s'),'bank_name'=>$bank_name,'acc_holder_name'=>$acc_holder_name,'sort_code'=>$sort_code,'acc_number'=>$acc_number,'reg_no'=>$registration_no,'reg_vat_no'=>$vat_registration_no,'company_name'=>$company_name,'city_id'=>$city_id,'state_id'=>$state_id,'birthdate'=>$birthdate,'gender'=>$gender,'height'=>$height,'build'=>$build,'nationality'=>$nationality,'language'=>$language,'militry'=>$militry,'drive'=>$drive,'firstaid'=>$firstaid,'tattoos'=>$tattoos,'piercing'=>$piercing,'sia'=>$sia,'sia_1'=>$sia_1,'sia_2'=>$sia_2,'sia_3'=>$sia_3,'sia_4'=>$sia_4,'activity'=>$activity,'health'=>$health,'bio'=>$bio,'latitude'=>$mapLat,'longitude'=>$mapLong,'paypal_email'=>$paypal_email,'paremedic'=>$paremedic);
			
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
<link href="css/jquery.fancybox.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">
<link href="fonts/font-awesome.css" rel="stylesheet">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.bxslider.js"></script>
<script type="text/javascript" src="js/menu.js"></script>
<script type="text/javascript" src="js/jquery.fancybox.js"></script>
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
    jQuery( "#datepicker" ).datepicker({dateFormat: 'dd/mm/yy', maxDate: 0});
	$('.ui-datepicker').addClass('notranslate');
	
	$("#chooseFile").change( function() {
		var reg=/(.jpg|.gif|.png)$/;
    if (!reg.test($("#chooseFile").val())) {
        alert('Invalid File Type');
        return false;
    }
    uploadFile();
		/* alert("hello");
		$.post("php_file.php", $("#form1 :input").serializeArray(), function(info) { alert(info);} ); */
	});
	
	$("#chooseFile2").change( function() {
		var reg=/(.avi|.mp4|.3gp)$/;
    if (!reg.test($("#chooseFile2").val())) {
        alert('Invalid File Type');
        return false;
    }
    uploadFile2();
		/* alert("hello");
		$.post("php_file.php", $("#form1 :input").serializeArray(), function(info) { alert(info);} ); */
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
		success:function(response){
			if(response != 0){
				//alert(response);
				//$("#uploadedImage").show();
				$("#previewvideo").html(response);
			}
		}
	});
  }
  
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
                                 <input type="file" name="profileimage"  data-validation-engine="validate[funcCall[geThan[]]]" 
							  data-errormessage-value-missing="Only JPG and PNG are allowed"  id="chooseFile">
                               </div> 
                            </div>
							<?php 
							if($profile_image!=''){
								$src=CUSTOMER_PROFILE_IMG_URL.get_image_thumbnail($profile_image); 
							?>
							<img id="uploadedImage" src="<?php echo $src; ?>" style="width:100px;height:100px;"   />
							<?php } else { ?>
							<img id="uploadedImage" src="" style="width:100px;display:none;height:100px;"   />
							<?php } ?>
						</div>

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
								<h4 class="modal-title"><?php echo $fees_row['title']; ?></h4>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								</div>
								
								<!-- Modal body -->
								<div class="modal-body">
								<?php echo $fees_row['content']; ?>
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
							         <input class="txt_lg" name="fname" id="fname" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter your first name" value="<?php echo $first_name; ?>" type="text">
								</li>
								<li>
								     <label>Last Name <em>*</em></label>
							         <input class="txt_lg" name="lname" data-validation-engine="validate[required]" maxlength="50" data-errormessage-value-missing="Please enter your last name" id="lname" value="<?php echo $lastname; ?>" type="text">
								</li>
								<li class="clr_lft">
								     <label>Address Line 1 <em>*</em></label>
							         <input class="txt_lg" name="address_1"  id="address_1" data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter address line 1" value="<?php echo $address_1; ?>" type="text">
								</li>
								<li class="clr_lft">
								     <label>Address Line 2 <em>*</em></label>
							         <input class="txt_lg" name="address_2" value="<?php echo $address_2; ?>"  id="address_2" type="text">
								</li>
								<li class="clr_lft">
								     <label>Address Line 3</label>
							         <input class="txt_lg" name="address_3"  value="<?php echo $address_3; ?>" id="address_3" type="text">
								</li>
								<li class="clr_lft">
								     <label>State<em>*</em></label>
							         <select name="state_id" id="state_id" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select state" onchange="getCities(this.value)">
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
								     <label>City <em>*</em></label>
							         <select id="city_id" name="city_id" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select city">
								        <option value="">Select City</option>
							         </select>
								</li>
								<li>
								     <label>Email <em>*</em></label>
							         <input class="txt_lg" type="text" data-validation-engine="validate[required,custom[email]]" data-errormessage-value-missing="The e-mail address you entered appears to be incorrect." value="<?php echo $user_email; ?>" name="email" id="email" data-errormessage-custom-error="Example: yourscreenname@aol.com">
									 <?php if($is_email_verify==1 || $isSocial!=0){ ?> <a class="a_vy">Verified</a> <?php } else { ?><a class="a_vy" href="emailverify.php?email=<?php  echo  $user_email;?>">Verify</a> <?php } ?>
								</li>
								<li>
								     <label>Contact No <em>*</em></label>
							         <input class="txt_lg" value="<?php echo $phone; ?>" name="phone" maxlength="12" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter your phone number" type="text">
							         <!--<a class="a_vy" href="#">Verify</a>-->
								</li>
								<li class="clr_lft mar_tp">
								     <label>Password <em>*</em></label>
							         <input class="txt_lg" name="password" type="password">
							         <!--<a class="a_cp" href="#">Change Password</a>-->
								</li>
								<li style="margin-top: -20px;">
							<label>PayPal Email (Should be Verified)<em>*</em></label>
							<input class="txt_lg" name="paypal_email" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter your paypal email" id="paypal_email" value="<?php echo $paypal_email; ?>" type="email" >
						</li>
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
							
							<ul>
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
								   <p class="vid_cli"><a href="#" data-toggle="modal" data-target="#videoMaker" id="videoMakers">Click here</a> to know how to make your profile video to attract more people and get better results</p>
                                   <?php if($profilevideo!=''){ ?>
									<a href="<?php echo CUSTOMER_PROFILE_VIDEO_URL.$profilevideo ?>" target="_blank">Profile Video</a>
									<?php } ?>
								</li>

								<li class="clr_lft">
								     <label>Date of Birth <em>*</em></label>
							         <input class="txt_lg datepicker" name="birthdate" style="width:200px;" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select Date of Birth" value="<?php echo $date;  ?>" id="datepicker" type="text">
								
								</li>
								
								<li class="clr_lft">
								     <label>Gender <em>*</em></label>
								     <div class="radio">
								        <div class="rdrow">
								        <input name="gender" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select Gender" id="rd1" class="rd_chk" type="radio" value="1" <?php if($gender==1){ ?> checked <?php } ?>>
								        <label for="rd1">Male</label>
								        </div>
								        <div class="rdrow">
								        	<input name="gender" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select Gender" id="rd2" class="rd_chk" type="radio">
								        <label for="rd2" value="2" <?php if($gender==2){ ?> checked <?php } ?>>Female</label>
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
								<?php
							
								$lang=array();
								if($language!='')
								{
									$lang=explode(",",$language);
								}
								
								
							    ?>
								<li class="clr_lft">
								    
								     <label>Languages Spoken</label>
									 <?php 
									$select_query = mysql_query("SELECT * FROM 	tbllanguage where status=1 ORDER By name ASC"); 
									$i=1;
									 while($row = mysql_fetch_assoc($select_query)) {
								     ?>
								<label class="rd_lb <?php if(in_array($row['name'],$lang)){ ?> active <?php } ?>"><input name="language[]" class="rd_chk" value="<?php echo $row['name']; ?>" type="checkbox" <?php if(in_array($row['name'],$lang)){ ?> checked <?php } ?>><?php echo $row['name']; ?></label>	 
								
								 <?php $i++; } ?>
								     <!--<label class="rd_lb"><input name="0" class="rd_chk" type="checkbox">English</label>
								     <label class="rd_lb"><input name="0" class="rd_chk" type="checkbox">Polish</label>
								     <label class="rd_lb"><input name="0" class="rd_chk" type="checkbox">French</label>
								     <label class="rd_lb"><input name="0" class="rd_chk" type="checkbox">Chinese</label>-->
								</li>
								<li class="clr_lft">
								     <label>Militry Background</label>
								     <div class="radio">
								        <div class="rdrow">
								        <input name="militry" value="1" id="rd3" <?php if($militry==1){ ?> checked <?php } ?> class="rd_chk" type="radio">
								        <label for="rd3">Yes</label>
								        </div>
								        <div class="rdrow">
								        	<input name="militry" value="2" id="rd4" <?php if($militry==2){ ?> checked <?php } ?> class="rd_chk" type="radio">
								        <label for="rd4">No</label>
								        </div>
							          </div>
								</li>
								<li class="clr_lft">
								     <label>Do you drive?</label>
								     <div class="radio">
								        <div class="rdrow">
								        <input name="drive" value="1" <?php if($drive==1){ ?> checked <?php } ?> id="rd5" class="rd_chk" type="radio">
								        <label for="rd5">Yes</label>
								        </div>
								        <div class="rdrow">
								        	<input name="drive" id="rd6" <?php if($drive==2){ ?> checked <?php } ?> value="2" class="rd_chk" type="radio">
								        <label for="rd6">No</label>
								        </div>
							          </div>
								</li>
								<li class="clr_lft">
								     <label>First aid?</label>
								     <div class="radio">
								        <div class="rdrow">
								        <input name="firstaid" value="1" <?php if($firstaid==1){ ?> checked <?php } ?> id="rd7" class="rd_chk" type="radio">
								        <label for="rd7">Yes</label>
								        </div>
								        <div class="rdrow">
								        	<input name="firstaid" id="rd8" <?php if($firstaid==2){ ?> checked <?php } ?> value="2" class="rd_chk" type="radio">
								        <label for="rd8">No</label>
								        </div>
							          </div>
								</li>
								<li class="clr_lft">
								     <label>Paremedic training?</label>
								     <div class="radio">
								        <div class="rdrow">
								        <input name="paremedic" value="1" <?php if($paremedic==1){ ?> checked <?php } ?> id="rd17" class="rd_chk" type="radio">
								        <label for="rd17">Yes</label>
								        </div>
								        <div class="rdrow">
								        	<input name="paremedic" id="rd18" <?php if($paremedic==2){ ?> checked <?php } ?> value="2" class="rd_chk" type="radio">
								        <label for="rd18">No</label>
								        </div>
							          </div>
								</li>
								<li class="clr_lft">
								     <label>Tattoos?</label>
								     <div class="radio">
								        <div class="rdrow">
								        <input name="tattoos" value="1" <?php if($tattoos==1){ ?> checked <?php } ?> id="rd9" class="rd_chk" type="radio">
								        <label for="rd9">Yes</label>
								        </div>
								        <div class="rdrow">
								        	<input name="tattoos" id="rd10" <?php if($tattoos==2){ ?> checked <?php } ?> value="2" class="rd_chk" type="radio">
								        <label for="rd10">No</label>
								        </div>
							          </div>
								</li>
								<li class="clr_lft">
									<label>Piercing?</label>
									<div class="radio">
										<div class="rdrow">
											<input name="piercing" value="1" <?php if($piercing==1){ ?> checked <?php } ?> id="rd111" class="rd_chk" type="radio">
											<label for="rd111">Yes</label>
										</div>
										<div class="rdrow">
											<input name="piercing" id="rd112" <?php if($piercing==2){ ?> checked <?php } ?> value="2" class="rd_chk" type="radio">
											<label for="rd112">No</label>
										</div>
									</div>
								</li>
								<li class="clr_lft">
								     <label>SIA Badge?</label>
								     <div class="radio">
								        <div class="rdrow">
								        <input name="sia" value="1" <?php if($sia==1){ ?> checked <?php } ?> id="rd11" class="rd_chk" type="radio" onclick="show1();">
								        <label for="rd11">Yes</label>
										</div>
								        <div class="rdrow">
								        	<input name="sia" id="rd12" <?php if($sia==2){ ?> checked <?php } ?> value="2" class="rd_chk" type="radio" onclick="show2();">
								        <label for="rd12">No</label>
								        </div>
									  </div>
								</li>
								<li id="sia_number" class="clr_lft" style="display:none">
									<label>SIA Badge Number</label>
									<div class="controls form-inline">
										<input id="txtChar" onkeypress="return isNumberKey(event)" maxlength="4"  type="text txt_lg" size="2" name="sia_1"  class="input-small" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter the correct SIA Badge Number" value="<?php echo $sia_1; ?>">
										<input id="txtChar" onkeypress="return isNumberKey(event)" maxlength="4"  type="text txt_lg" size="2" name="sia_2" class="input-small" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter the correct SIA Badge Number" value="<?php echo $sia_2; ?>">
										<input id="txtChar" onkeypress="return isNumberKey(event)" maxlength="4"  type="text txt_lg" size="2" name="sia_3" class="input-small" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter the correct SIA Badge Number" value="<?php echo $sia_3; ?>">
										<input id="txtChar" onkeypress="return isNumberKey(event)" maxlength="4"  type="text txt_lg" size="2" name="sia_4" class="input-small" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter the correct SIA Badge Number" value="<?php echo $sia_4; ?>">
									</div>
								</li>
								<li class="clr_lft">
						         	<label>Any Ailments that could impair activity to work?</label>
							        <textarea name="activity"><?php echo $activity; ?></textarea>
						        </li>
								<li class="clr_lft">
						         	<label>Any Health Issues?</label>
							        <textarea name="health"><?php echo $health; ?></textarea>
						        </li>
								<li class="clr_lft">
						         	<label>Bio</label>
							        <textarea name="bio"><?php echo $bio; ?></textarea>
						        </li>
								<!--<li class="clr_lft">
								     <label>Home far willing to travel for work? <em>*</em></label>
								     <label>Home Location <em>*</em></label>
							         <input class="txt_lg txt_cm" type="text">
							         <input type="button" class="btn_src" value="go" />
								</li>-->
								<!--<li class="clr_lft">
									<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2477.03027831211!2d-0.10748848403356334!3d51.62265451009037!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487619379d2859c7%3A0xcf88fa1283d62bf4!2s483+Green+Lanes%2C+London+N13+4BS%2C+UK!5e0!3m2!1sen!2sin!4v1520229738490" style="border:0" allowfullscreen="" height="450" frameborder="0" width="600"></iframe>
								</li>-->
								<!--<li class="clr_lft">
								     <label>Enter Distance <em>*</em></label>
							         <input class="txt_lg txt_cm" type="text">
							         <span class="in_cm">(miles)</span>
								</li>-->
							</ul>
							
							<?php } ?>
							
							<?php if($customer_type==1){ ?>
							<ul>
							    <li>
							     <label>Company Name<em>*</em></label>
							      <input class="txt_lg" name="company_name" id="company_name" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter your company name" value="<?php echo $c_name; ?>" type="text">
						        </li>
								<li class="clr_lft">
								     <label>Contact Person First Name <em>*</em></label>
							         <input class="txt_lg" name="fname" id="fname" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter your first name" value="<?php echo $first_name; ?>" type="text">
								</li>
								<li class="clr_lft">
								     <label>Contact Person Last Name <em>*</em></label>
							         <input class="txt_lg" name="lname" data-validation-engine="validate[required]" maxlength="50" data-errormessage-value-missing="Please enter your last name" id="lname" value="<?php echo $lastname; ?>" type="text">
								</li>
								<li class="clr_lft">
								     <label>Address Line 1 <em>*</em></label>
							         <input class="txt_lg" name="address_1"  id="address_1" data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter address line 1" value="<?php echo $address_1; ?>" type="text">
								</li>
								<li class="clr_lft">
								     <label>Address Line 2 <em>*</em></label>
							         <input class="txt_lg" name="address_2" value="<?php echo $address_2; ?>"  id="address_2" type="text">
								</li>
								<li class="clr_lft">
								     <label>Address Line 3</label>
							         <input class="txt_lg" name="address_3"  value="<?php echo $address_3; ?>" id="address_3" type="text">
								</li>
								<li class="clr_lft">
								     <label>State<em>*</em></label>
							         <select name="state_id" id="state_id" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select state" onchange="getCities(this.value)">
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
								     <label>City <em>*</em></label>
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
								     <label>Email <em>*</em></label>
							         <input class="txt_lg" type="text" data-validation-engine="validate[required,custom[email]]" data-errormessage-value-missing="The e-mail address you entered appears to be incorrect." value="<?php echo $user_email; ?>" name="email" id="email" data-errormessage-custom-error="Example: yourscreenname@aol.com">
							         <!--<a class="a_vy" href="#">Verify</a>-->
								</li>
								<li >
								     <label>Contact No <em>*</em></label>
							         <input class="txt_lg" value="<?php echo $phone; ?>" name="phone" maxlength="12" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter your phone number" type="text">
							         <!--<a class="a_vy" href="#">Verify</a>-->
								</li>
								<li class="clr_lft">
								     <label>Password <em>*</em></label>
							         <input class="txt_lg" name="password" type="password">
							         <!--<a class="a_cp" href="#">Change Password</a>-->
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
								   <p class="vid_cli"><a href="#" data-toggle="modal" data-target="#videoMaker" id="videoMakers">Click here</a> to know how to make your profile video to attract more people and get better results</p>
                                   <?php if($profilevideo!=''){ ?>
                            		<a href="<?php echo CUSTOMER_PROFILE_VIDEO_URL.$profilevideo ?>" target="_blank">Profile Video</a>
									<?php } ?>
								   
								</li>
							</ul>
							<?php /* ?>
							<ul class="brd_ul" style="border-bottom:none;">
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
<script>
	if(document.getElementById('rd11').checked) {
		document.getElementById('sia_number').style.display ='block';
	}
</script>
<?php include "footer.php"; ?>
<?php include('admin/inc/validation.php'); ?>
<!-- <script type="text/javascript">
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$('#uploadedImage').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}
</script> -->
</body>
</html>