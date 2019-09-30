<?php 
include "config.php"; 
include "check_user_login.php";
require_once(ADMIN_PATH."inc/img_upload.php");
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

if(isset($_POST['submit']) && $_POST['submit']!='')
{

	$ins_array = array();
	$ins_array['course_body'] =	isset($_REQUEST["course_body"])?$_REQUEST["course_body"]:'';  
	$ins_array['course_title'] =	isset($_REQUEST["course_title"])?$_REQUEST["course_title"]:'';  
	$ins_array['category_id'] =	isset($_REQUEST["category_id"])?$_REQUEST["category_id"]:'';  
	$start_date =	isset($_REQUEST["start_date"])?$_REQUEST["start_date"]:'';
	if($start_date!='')
	{
		$birth_ex=explode("/",$start_date);
		$ins_array['start_date'] = $birth_ex[2]."-".$birth_ex[1]."-".$birth_ex[0];
	}
	else
	{
		$ins_array['start_date'] ='1970-01-01';
	}  
	$ins_array['start_time'] =	isset($_REQUEST["start_time"])?$_REQUEST["start_time"]:'';

	/*end date and time*/
	$end_date =	isset($_REQUEST["end_date"])?$_REQUEST["end_date"]:'';
	if($end_date!='')
	{
		$birth_ex=explode("/",$end_date);
		$ins_array['end_date'] = $birth_ex[2]."-".$birth_ex[1]."-".$birth_ex[0];
	}
	else
	{
		$ins_array['end_date'] ='1970-01-01';
	}  
	$ins_array['end_time'] =	isset($_REQUEST["end_time"])?$_REQUEST["end_time"]:'';
	/*end date and time*/

	$ins_array['duration'] =	isset($_REQUEST["duration"])?$_REQUEST["duration"]:'';  
	$ins_array['specify_days'] =	isset($_REQUEST["specify_days"])?$_REQUEST["specify_days"]:'';  
	$ins_array['price'] =	isset($_REQUEST["price"])?$_REQUEST["price"]:'';  
	$ins_array['enrollment_limit'] =	isset($_REQUEST["enrolment_limit"])?$_REQUEST["enrolment_limit"]:'';  
	$ins_array['description'] =	isset($_REQUEST["description"])?$_REQUEST["description"]:'';  
	$ins_array['location'] =	isset($_REQUEST["location"])?$_REQUEST["location"]:'';
	$ins_array['created_date'] =	date("Y-m-d");
	$ins_array['created_by'] =	isset($_SESSION['user_id'])?$_SESSION['user_id']:'';
	$ins_array['modified_date'] =	date("Y-m-d");
	$ins_array['modified_by'] =	isset($_SESSION['user_id'])?$_SESSION['user_id']:'';
	$ins_array['status'] =	1;
	/*location data*/
	$latitude = 	isset($_REQUEST["latitude"])&&$_REQUEST["latitude"]!=''?$_REQUEST["latitude"]:'';
	$longitude = 	isset($_REQUEST["longitude"])&&$_REQUEST["longitude"]!=''?$_REQUEST["longitude"]:'';
	$postal_code = 	isset($_REQUEST["postal_code"])&&$_REQUEST["postal_code"]!=''?$_REQUEST["postal_code"]:'';

	if($course_location!='') {
	    $latlong    =   get_lat_long($_REQUEST["location"]);
	    $map        =   explode(',' ,$latlong);
	    $mapLat     =   $map[0];
	    $mapLong    =   $map[1];
	  } else {
	    $latlong    =   get_lat_long($postal_code);
	    $map        =   explode(',' ,$latlong);
	    $mapLat     =   $map[0];
	    $mapLong    =   $map[1];
	  }
	  $ins_array['latitude'] =	$mapLat;
	  $ins_array['longitude'] =	$mapLong;
	  $ins_array['postalcode'] =$postal_code;

	/*location data end*/
	//echo "<pre>";print_r($ins_array);exit;
	$db->Insert($ins_array, 'tblcoursemaster');
	$last_id = mysql_insert_id();

	/* Course Image */
    $newfilename='';
	$newFilePath='';
	$newFileURL='';
	if($_FILES['image']['name']!='')
	{
		$tmpFilePath = $_FILES['image']['tmp_name'];
		if ($tmpFilePath != ""){
			$path = $_FILES['image']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			$randname=rand(111111,999999);
			$newfilename =$randname.".".$ext;
			$newthumbfilename = "th_".$randname.".".$ext;
			$newFilePath = COURSE_NEWIMG_PATH . $newfilename;
			if(move_uploaded_file($tmpFilePath, $newFilePath))
			{
				/*$path2= COURSE_NEWIMG_PATH;
				$resizeObj1 = new resize($newFilePath);
				$resizeObj1->resizeImage(150, 150, 'exact');
				$resizeObj1->saveImage("$path2/$newthumbfilename", 100);*/
			}
		}
		if($newfilename!='')
		{
			$course_image = $newfilename;
			$data=array("image"=>$course_image);
			$where ="course_id ={$last_id}";
			$db->Update($data,"tblcoursemaster",$where);
		}
	}
	if($_FILES['certi']['name']!='')
	{
		$tmpFilePath2 = $_FILES['certi']['tmp_name'];
		if ($tmpFilePath2 != ""){
			$path = $_FILES['certi']['name'];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			$randname2=rand(111111,999999);
			$newfilename2 =$randname2.".".$ext;
			$newthumbfilename = "th_".$randname2.".".$ext;
			$newFilePath = COURSE_CERTI_IMG_PATH . $newfilename2;
			if(move_uploaded_file($tmpFilePath2, $newFilePath))
			{
				/*$path2= COURSE_CERTI_IMG_PATH;
				$resizeObj1 = new resize($newFilePath);
				$resizeObj1->resizeImage(150, 150, 'exact');
				$resizeObj1->saveImage("$path2/$newthumbfilename", 100);*/
			}
		}
		if($newfilename2!='')
		{
			$course_certi = $newfilename2;
			$data=array("course_body_certificate"=>$course_certi);
			$where ="course_id ={$last_id}";
			$db->Update($data,"tblcoursemaster",$where);
		}
	}
	header('Location:manage-course.php');
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
<title>Add Course - SECURE THAT JOB</title>

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
<link href="css/bootstrap-clockpicker.min.css" rel="stylesheet">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.bxslider.js"></script>
<script type="text/javascript" src="js/menu.js"></script>
<script type="text/javascript" src="js/jquery.fancybox.js"></script>
<script src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/at-jquery.js"></script>
<script type="text/javascript" src="js/cropper.min.js"></script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script type="text/javascript" src="js/bootstrap-clockpicker.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>


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
 	jQuery('.clockpicker').clockpicker();

    jQuery( "#datepicker" ).datepicker({dateFormat: 'dd/mm/yy', changeMonth: true, yearRange: "-60:+10", changeYear: true, clickInput: true});
	$('.ui-datepicker').addClass('notranslate');

	jQuery( "#datepicker1" ).datepicker({dateFormat: 'dd/mm/yy', changeMonth: true, yearRange: "-60:+10", changeYear: true, clickInput: true});
	$('.ui-datepicker1').addClass('notranslate');

	$("#chooseCertificate").change( function() {
		var reg=/(.jpg|.jpeg|.pdf|.png)$/;
    if (!reg.test($("#chooseCertificate").val())) {
        return false;
    }

    uploadFile3();
		
	});

    $("#chooseLicense").change( function() {
		var reg=/(.jpg|.jpeg|.pdf|.png)$/;
    if (!reg.test($("#chooseLicense").val())) {
        return false;
    }

    uploadLicense();
		
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

 /* Upload for License Passport */
function uploadLicense()
  {
	var fd = new FormData();

	/*$.each($("#chooseLicense")[0].files, function(i, file) {
		FormData.append('image', $('#chooseLicense')[0].files[0]);
	});*/
	
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
  	alert(hello);
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
				$('#uploadcertipreloaderc').show();
		},
		success:function(response){
			if(response != 0){
				$('#uploadcertipreloaderc').hide();
				$('.companyCertiPreview').show();
				$(".companyCertiPreview").html(response);
			}
		}
	});
}

/* Remove Company Certificate */
function removeCompanyCerti(userId,certiId)
{
	alert('dfd');
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

function removeLicenseUpload(obj)
{
    $("#uploaded_license_"+obj).hide("");
}

function removeCompanyCertiUpload(obj)
{
    $("#uploaded_company_certi_"+obj).hide("");
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

<div style="padding: 10px;" class="stj_job_wrap businessprf course_main">
	<div class="container">
		<h1>Create New Course</h1>
		<div class="row">
			<div class="col-xs-12 col-md-12 stj_about_inn">
				<div class="stj_abt_con min_content jobdetail">
					<form id="course_form"  method="post" name="edit-course" enctype="multipart/form-data" class="validateForm" action="">
					<div class="stj_pb_edit">
						
						<div class="stj_pb_frm">
							<?php //echo $customer_type; ?>
							
							<?php if($customer_type==1){ ?>
							<ul>
							    <li>
							     <label>Recognised Course Body<em>*</em></label>
							      <input class="txt_lg" name="course_body" id="course_body" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter course body" value="<?php echo $c_name; ?>" type="text">
						        </li>
								<li class="clr_lft">
								     <label>Course Title <em>*</em></label>
							         <input class="txt_lg" name="course_title" id="course_title" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter course title" value="<?php echo $first_name; ?>" type="text">
								</li>
								
								<li class="clr_lft">
									<div class="start_date" style="float: left;width: 50%;">
								     	<label>Course Start Date <em>*</em></label>
							         	<input class="txt_lg datepicker" name="start_date" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select Date of Birth" value="<?php //echo $date;  ?>" id="datepicker" type="text" autocomplete="off">
							         </div>
							         <div class="clockpicker" data-autoclose="true" style="float: right;width: 47%;">
							         	<label>Course Start Time <em>*</em></label>
							         	<input class="txt_lg" name="start_time" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select time" value="<?php //echo $date;  ?>" id="start_time" type="text" autocomplete="off">		         	
							         </div>
							    </li>
							   <li>

							         <div class="end_date" style="float: left;width: 50%;">
								     	<label>Course End Date <em>*</em></label>
							         	<input class="txt_lg datepicker1" name="end_date" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select Date of Birth" value="<?php //echo $date;  ?>" id="datepicker1" type="text" autocomplete="off">
							         </div>
							         <div class="clockpicker" data-autoclose="true" style="float: right;width: 47%;">
							         	<label>Course End Time <em>*</em></label>
							         	<input class="txt_lg" name="end_time" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select time" value="<?php //echo $date;  ?>" id="end_time" type="text" autocomplete="off">
							         	
							         </div>
								</li>
								<li class="clr_lft">
									<label>Category<em>*</em></label>
								     <!-- <label>State<em>*</em></label> -->
							         <select name="category_id" id="category_id" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select category">
							         	<option>---Select Category---</option>
								     <?php 
										$select_query = mysql_query("SELECT * FROM tblcategory ORDER By category_name ASC");
										while($row = mysql_fetch_assoc($select_query)) { 
										$selected='';
										if($category_id==$row['category_id'])
										{
											$selected='selected';
										}
									?>
							
									<option value="<?php echo $row['category_id'] ?>" <?php echo $selected; ?>><?php echo $row['category_name']; ?></option>
								    <?php } ?>
							         </select>
								</li>
								<li class="clr_lft">
								<label>Duration (in days)<em>*</em></label>
								<input class="txt_lg" name="duration"  id="duration"  data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter duration" value="<?php echo $reg_no;?>" type="text">
						        </li>
								<li class="clr_lft">
								     <label>Specify Days (eg. Monday - Friday) <em>*</em></label>
							         <input class="txt_lg" name="specify_days" id="specify_days" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter course title" value="<?php echo $first_name; ?>" type="text">
								</li>
								<li >
								     <label>Amount (&#163;)<em>*</em></label>
							         <input class="txt_lg" value="<?php echo $phone; ?>" name="price" maxlength="12" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter price" type="tel">
								</li>
								<li >
								     <label>Enrolment Limit <em>*</em></label>
							         <input class="txt_lg" value="<?php echo $phone; ?>" name="enrolment_limit" maxlength="12" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter limit" type="tel">
								</li>
								<li class="clr_lft">
								     <label>Description (Please add any additional details e.g. 9am - 6pm with a one hour break)<em>*</em></label>
							         <textarea name="description" id="description" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter description"></textarea>
								</li>
								<?php 
								$userLicense=0;
								if(isset($_SESSION['user_id']) && $_SESSION['user_id']!='') {
									$userLicense=mysql_query("select * from tbl_user_license_passport where user_id=".$_SESSION['user_id']."");
									$userLicenseCount=mysql_num_rows($userLicense);
								}
								?>
								<li class="clr_lft">
									<label>Image <em>*</em> </label>
									<div class="file-upload">
										<div class="file-select">   
											<div class="file-select-name" id="noFile"></div> 
											<div class="file-select-button" id="fileName">Browse</div>
											<input type="file" name="image" data-validation-engine="validate[funcCall[geThanLicense[]]]"  id="chooseLicense">
										</div> 
									</div>
									<div id="uploadcertipreloader" style="display:none"><span>Uploading Image</span></div>
									
									<!-- Preview after upload -->
									<div id="licensePreview" class="licensePreview" style="display:none;">
										<a class="fancybox" rel="group" href="">
											<img src="" style="width:100px;" alt="">
										</a>
									</div>

									<label>Location (Please enter Course Location Address)<em>*</em></label>
							         <input class="txt_lg" name="location" id="autocomplete" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter course title" value="<?php echo $location; ?>" type="text">
							    </li>
							    <li class="clr_lft">
							        <label>Postal Code <em>*</em></label>
							         <input class="txt_lg" name="postal_code" id="postal_code" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter course title" value="" type="text">
								</li>

								<?php 
								$userCompanyCertiCount=0;
								if(isset($_SESSION['user_id']) && $_SESSION['user_id']!='') {
									$userCompanyCerti=mysql_query("select * from tbl_user_comp_certi where user_id=".$_SESSION['user_id']."");
									$userCompanyCertiCount=mysql_num_rows($userCompanyCerti);
								}
								?>
								<li class="clr_lft">
									<label>Recognised Course Body Certificate<em>*</em></label>
									<div class="file-upload">
										<div class="file-select">   
											<div class="file-select-name" id="noFile"></div> 
											<div class="file-select-button" id="fileName">Browse</div>
											<input type="file" multiple name="certi" data-validation-engine="validate[funcCall[geThanCompanyCerti[]]]"  id="chooseCompanyCerti">
										</div> 
									</div>
									<div id="uploadcertipreloaderc" style="display:none"><span>Uploading Document</span></div>
									
									<!-- Preview after upload -->
									<div id="companyCertiPreview" class="companyCertiPreview" style="display:none;">
										<a class="fancybox" rel="group" href="">
											<img src="" style="width:100px;" alt="">
										</a>
									</div>
								</li>

								<li class="input_declare">
								     <label class=""><input type="checkbox" id="declaration" name="declaration" value="1" data-validation-engine="validate[required]"> I declare that I am posting a legitimate course </label>
								</li>

							</ul>

							<?php } ?>
							<div class="nextbtn">
				            	<input value="Save" name="submit" id="save" class="btn_lg save" type="submit">				
				            </div>
							
						</div>
						
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script> -->
<script type="text/javascript">
$("#save").click(function(){
	/*if (!$('#declaration').is(':checked')) {
	        alert('not checked');
	        return false;
	 }*/

	$('form[id="course_form"]').validate({
        rules: {
          course_body: 'required',
          course_title: {
          	required: true,
          	lettersonly: true
          },
          category_id: 'required',
          start_date: 'required',
          start_time: 'required',
          end_date: {
          	required: true,
          	greaterThan: "#datepicker"
          },
          end_time: 'required',
          duration: {
          	required: true,
          	number: true
          },
          specify_days: {
          	required: true,
          	lettersonly: true
          },
          price: {
          	required: true,
          	float: true,
          },
          enrolment_limit: {
          	required: true,
          	number: true
          },
          postal_code: {
          	required: true
          },
          description: 'required',
          image: 'required',
          location: 'required',
          declaration: 'required',
          certi: 'required',
          
        },
        messages: {
           declaration: {
                required: "Please tick on the declaration box!"
            }
        },
        errorPlacement: function (error, element) {
        	if(element.attr("name") == "declaration") {
			    alert(error.text());
			  }else{
			  	error.insertAfter(element);
			  }            
        },
        submitHandler: function(form) {
          form.submit();
        }
    });
});

jQuery.validator.addMethod("greaterThan", 
function(value, element, params) {

    var edt = $(params).val().split('/');
	var dateDay = parseInt(edt[0]);
    var dateMonth = parseInt(edt[1]);
    var dateYear = parseInt(edt[2]);
	var strt_date = dateYear+'-'+dateMonth+'-'+dateDay;


	var edt = value.split('/');
	var dateDay = parseInt(edt[0]);
    var dateMonth = parseInt(edt[1]);
    var dateYear = parseInt(edt[2]);
    var end_date = dateYear+'-'+dateMonth+'-'+dateDay;

	var strt_date = new Date(strt_date);
    var end_date = new Date(end_date);




    var st_date = strt_date.getTime();
    var nd_date = end_date.getTime();

    
    console.log(strt_date + " == " + end_date )
    console.log(st_date + " == " + nd_date )
    return nd_date > st_date;
},'Course end date must be greater than start date');


jQuery.validator.addMethod("lettersonly", function(value, element) {
  return this.optional(element) || /^[a-z?=.*!@#$%^&*_\-\s]+$/i.test(value);
}, "Letters only please");

jQuery.validator.addMethod("number", function(value, element) {
  return this.optional(element) || /^[0-9]+$/i.test(value);
}, "Please enter numeric values");

jQuery.validator.addMethod("float", function(value, element) {
  return this.optional( element ) || /^[+-]?\d+(\.\d+)?$/.test( value );
}, 'Please enter numeric values.');

jQuery(document).ready(function($) {	
$('.input_declare label input').on('click', function(){
if($(this).is(":checked")) {
$(this).parent().addClass("checked");
} else {
$(this).parent().removeClass("checked");
}
});	
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
<?php //include('admin/inc/validation.php'); ?>
</body>
</html>