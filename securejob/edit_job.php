<?php 
include "config.php"; 

require_once(ADMIN_PATH."inc/img_upload.php");
include_once(ADMIN_PATH."inc/functions.php");
include_once(ADMIN_PATH."inc/resize-class.php");



$job_id=isset($_REQUEST['job_id']) ? $_REQUEST['job_id'] : ''; 
$jobdetails=mysql_query("select * from tbljobs where job_id='".$job_id."'");
$rowcount=mysql_num_rows($jobdetails);
if($rowcount == 0)
{
	echo '<script> alert("Invalid Job Id."); window.location.href="jobs.php";</script>';
}
if($job_id==0)
{
	echo '<script> alert("Invalid Job Id."); window.location.href="jobs.php";</script>';
}

if($rowcount > 0)
{
	$jobdata=mysql_fetch_array($jobdetails);
	$job_user_id=$jobdata['job_user_id'];
	$job_title=$jobdata['job_name'];
	$description=$jobdata['job_description'];
	$proposed_amount=$jobdata['price'];
	$days=$jobdata['job_days'];
	$hours=$jobdata['job_hours'];
	$start_date=date("d/m/Y",strtotime($jobdata['start_date']));
	$latitude=$jobdata['latitude'];
	$longitude=$jobdata['longitude'];
	$address1=$jobdata['address1'];
	$address2=$jobdata['address2'];
	$postalcode=$jobdata['postalcode'];
	$country_id=$jobdata['country_id'];
	$state_id=$jobdata['state_id'];
	$city_id=$jobdata['city_id'];
	$riskmeter=$jobdata['riskmeter'];
	$job_type=$jobdata['job_type'];
	$transportlink=$jobdata['transport_link'];
	$dresscode_description=$jobdata['dresscode'];
	$created_date=$jobdata['created_date'];
	$isfeatured=$jobdata['isfeatured'];
	$status=$jobdata['status'];
	$opening_position=$jobdata['opening_position'];
	$job_location=$jobdata['job_location'];
	$opening_type=$jobdata['opening_type'];
	$duration_in=$jobdata['duration_in'];
	$job_status=$jobdata['job_status'];
	$payment_status=$jobdata['payment_status'];
	$jobcategory=jobcatlist($job_id);
	$willingtopay=$price * $job_days * $opening_position * $job_hours;
	$totalhours=$job_days * $opening_position * $job_hours;
	
    $job_type_txt='';
	if(isset($job_type) && $job_type==1)
	{
		$job_type_txt='Part Time';
	}
	if(isset($job_type) && $job_type==2)
	{
		$job_type_txt='Full Time';
	}
    
    
	$risk_txt='';
	if(isset($riskmeter) && $riskmeter==1)
	{
		$risk_txt='Low';
	}
	if(isset($riskmeter) && $riskmeter==2)
	{
		$risk_txt='Medium';
	}
	if(isset($riskmeter) && $riskmeter==3)
	{
		$risk_txt='High';
	}
	if(isset($riskmeter) && $riskmeter==4)
	{
		$risk_txt='Very High';
	}
	
	$gettags=mysql_query("select tag_id from tbljobtags where job_id=".$job_id."");
	 $countrows=mysql_num_rows($gettags);
	 $tags=array();
	 if($countrows > 0)
	 {
		 while($rows=mysql_fetch_array($gettags))
		 {
			 $tags[]=$rows['tag_id'];
		 }
	 }
	 
	 $getcategories=mysql_query("select category_id from tbljobcategories where job_id=".$job_id."");
	 $countrows2=mysql_num_rows($getcategories);
	 $categories=array();
	 if($countrows2 > 0)
	 {
		 while($rows2=mysql_fetch_array($getcategories))
		 {
			 $categories[]=$rows2['category_id'];
		 }
	 }
	 
	 $getimagename=mysql_query("select imagename from tbljobimages where jobid=".$job_id."");
	 $countrows3=mysql_num_rows($getimagename);
	 //echo $countrows3;
	 //exit;
}
else
{
	$categories=array();
	$job_user_id='';
	$job_name='';
	$job_description='';
	$proposed_amount='';
	$days='';
	$hours='';
	$start_date='';
	$latitude='';
	$longitude='';
	$address1='';
	$address2='';
	$country_id='';
	$state_id='';
	$city_id='';
	$riskmeter='';
	$job_type='';
	$transportlink='';
	$dresscode_description='';
	$created_date='';
	$isfeatured='';
	$status='';
	$opening_position='';
	$job_location='';
	$opening_type='';
	$duration_in='';
	$job_status='';
	$payment_status='';
	$jobcategory='';
	$willingtopay='';
	$risk_txt='';
	$totalhours=0;
}



if(isset($_POST['submit']) && $_POST['submit']!='')
{
	$job_title=isset($_POST['job_title']) ? $_POST['job_title'] :'';
	$job_location=isset($_POST['job_location']) ? $_POST['job_location'] :'';
	$description =	isset($_REQUEST["description"])&&$_REQUEST["description"]!=''?$_REQUEST["description"]:'';
	$is_featured = 	isset($_REQUEST["is_featured"])&&$_REQUEST["is_featured"]!=''?$_REQUEST["is_featured"]:0;
	$status = 	isset($_REQUEST["status"])&&$_REQUEST["status"]!=''?$_REQUEST["status"]:1;
	$price = 	isset($_REQUEST["proposed_amount"])&&$_REQUEST["proposed_amount"]!=''?$_REQUEST["proposed_amount"]:0;
	$hours = 	isset($_REQUEST["hours"])&&$_REQUEST["hours"]!=''?$_REQUEST["hours"]:0;
	$days = 	isset($_REQUEST["days"])&&$_REQUEST["days"]!=''?$_REQUEST["days"]:0;
	$start_date = 	isset($_REQUEST["start_date"])&&$_REQUEST["start_date"]!=''?$_REQUEST["start_date"]:'';
	$riskmeter = 	isset($_REQUEST["riskmeter"])&&$_REQUEST["riskmeter"]!=''?$_REQUEST["riskmeter"]:'';
	$job_type = 	isset($_REQUEST["job_type"])&&$_REQUEST["job_type"]!=''?$_REQUEST["job_type"]:'';
	$categories = 	isset($_REQUEST["categories"])&&$_REQUEST["categories"]!=''?$_REQUEST["categories"]:'';
	$tags = 	isset($_REQUEST["tags"])&&$_REQUEST["tags"]!=''?$_REQUEST["tags"]:'';
	$transportlink = 	isset($_REQUEST["transportlink"])&&$_REQUEST["transportlink"]!=''?$_REQUEST["transportlink"]:'';
	$dresscode_description = 	isset($_REQUEST["dresscode_description"])&&$_REQUEST["dresscode_description"]!=''?$_REQUEST["dresscode_description"]:'';
	$opening_position = isset($_REQUEST["opening_position"])&&$_REQUEST["opening_position"]!=''?$_REQUEST["opening_position"]:0;
	$joblocation = isset($_REQUEST["joblocation"])&&$_REQUEST["joblocation"]!=''?$_REQUEST["joblocation"]:'';
	$openning_type = isset($_REQUEST["opening_type"])&&$_REQUEST["opening_type"]!=''?$_REQUEST["opening_type"]:0;
	$duration_in = isset($_REQUEST["duration_in"])&&$_REQUEST["duration_in"]!=''?$_REQUEST["duration_in"]:0;
	$address_1 = isset($_REQUEST["address_1"])&&$_REQUEST["address_1"]!=''?$_REQUEST["address_1"]:'';
	$address_2 = isset($_REQUEST["address_2"])&&$_REQUEST["address_2"]!=''?$_REQUEST["address_2"]:'';
	$postal_code = isset($_REQUEST["postalcode"])&&$_REQUEST["postalcode"]!=''?$_REQUEST["postalcode"]:'';

	if($address_1 != ""){
		$latLongAddress = $address_1;
	}else{
		$latLongAddress = $postal_code;
	}

	$latlong    =   get_lat_long($latLongAddress);
	$map        =   explode(',' ,$latlong);
	$latitude     =   $map[0];
	$longitude    =   $map[1];
	
	$country_id =	isset($_REQUEST["country_id"])&&$_REQUEST["country_id"]!=''?$_REQUEST["country_id"]:0;
	$state_id =	isset($_REQUEST["state_id"])&&$_REQUEST["state_id"]!=''?$_REQUEST["state_id"]:0;
	$city_id =	isset($_REQUEST["city_id"])&&$_REQUEST["city_id"]!=''?$_REQUEST["city_id"]:0;
	$job_latest_id =	isset($_REQUEST["job_update_id"])&&$_REQUEST["job_update_id"]!=''?$_REQUEST["job_update_id"]:0;
	
	if($start_date!='')
	{
		$start_ex=explode("/",$start_date);
		$start_date=$start_ex[2]."-".$start_ex[1]."-".$start_ex[0];
	}
	$newfilename='';
	$newFilePath='';
	$newFileURL='';
	
	$data = array('job_name'=>$job_title,'job_description'=>$description,'price'=>$price,'image'=>$images,'job_days'=>$days,'job_hours'=>$hours,'start_date'=>$start_date,'riskmeter'=>$riskmeter,'job_type'=>$job_type,'latitude'=>$latitude,'longitude'=>$longitude,'address1'=>$address_1,'address2'=>$address_2,'postalcode'=>$postal_code,'country_id'=>$country_id,'state_id'=>$state_id,'city_id'=>$city_id,'transport_link'=>$transportlink ,'dresscode'=>$dresscode_description,'status'=>$status,'created_date'=>date('Y-m-d H:i:s'),'isfeatured'=>$is_featured,'opening_position'=>$opening_position,'job_location'=>$job_location,'opening_type'=>$openning_type,'duration_in'=>$duration_in);
			$where =" job_id ={$job_id} ";
			$db->Update($data,"tbljobs",$where);
			
			$last_id =$job_id;
			
			$aaa = $_FILES['image']['name'][0];

			if($aaa != '')
			{
				$whereimages="jobid={$job_latest_id}";
				//$imagedelete=$db->Update($data,"tbljobimages",$whereimages);
				$imagedelete=$db->Delete("tbljobimages",$whereimages);
				$imgcount=count($_FILES['image']['name']);
				for($i=0;$i<$imgcount;$i++)
				{
					$tmpFilePath = $_FILES['image']['tmp_name'][$i];
					if ($tmpFilePath != ""){
						$path = $_FILES['image']['name'][$i];
						$ext = pathinfo($path, PATHINFO_EXTENSION);
						$randname=rand(111111,999999);
						$newfilename =$randname.".".$ext;
						$newthumbfilename = "th_".$randname.".".$ext;
						
						$newFilePath = JOBS_IMG_PATH . $newfilename;
						if(move_uploaded_file($tmpFilePath, $newFilePath))
						{
							$path2=JOBS_IMG_PATH;
							$resizeObj1 = new resize(JOBS_IMG_PATH.$newfilename);
							$resizeObj1->resizeImage(780, 780, 'exact');
							$resizeObj1->saveImage("$path2/$newthumbfilename", 100);
						}
						
					}
					
					$job_image = '';
					
					if($newfilename!='')
					{
						$job_image = $newfilename;
						$data=array("jobid"=>$last_id,"imagename"=>$job_image);
						$db->Insert($data,"tbljobimages");
					}
				}
			}
			
			
			if(!empty($categories)){
				$wherecategory="job_id={$job_latest_id}";
				//$categorydelete=$db->Update($data,"tbljobcategories",$wherecategory);
				$categorydelete=$db->Delete("tbljobcategories",$wherecategory);
				
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
			
			$_SESSION['mt'] = "success";
			$_SESSION['me'] = "'{$jobname}' added successfully.";
			header("Location:biddetails.php?job_id={$job_latest_id}");
			exit();
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
<title>Edit Job - SECURE THAT JOB</title>

<!-- Bootstrap -->
<link href="https://fonts.googleapis.com/css?family=Fira+Sans:300,400,400i,500,600,700,800" rel="stylesheet"> 
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link href="css/jquery-ui.css" rel="stylesheet">
<link href="css/ddsmoothmenu.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">
<link href="fonts/font-awesome.css" rel="stylesheet">
<link href="css/chosen.css" rel="stylesheet">
<link href="css/prism.css" rel="stylesheet">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.bxslider.js"></script>
<script type="text/javascript" src="js/menu.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/chosen.jquery.js"></script>
<script src="js/prism.js"></script>
<script type="text/javascript" src="js/at-jquery.js"></script> 
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({includedLanguages: '<?php echo LanguageList; ?>', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script>
  <script>
 jQuery( function() {
    jQuery( "#datepicker" ).datepicker({dateFormat: 'dd/mm/yy',minDate: +1});
	$('.ui-datepicker').addClass('notranslate');
  });
  </script>
 <script>
			jQuery( document ).ready(function($) {
			$(".csselect").chosen({no_results_text: "Oops, nothing found!"});
	
			});
			
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
				<h2>Edit Job Details</h2>
				<div class="jobdetail">
				<form method="post" name="addjob" enctype="multipart/form-data" class="validateForm" action="">
					<ul class="jobtab">
						<li class="active"><a href="#">Edit Details</a></li>
						<li><a href="#">&nbsp;</a></li>
					</ul>
					<div class="jobmain">
						<div class="jobleft">
						
					<ul>	
							<li>
							<label>Job Title <em>*</em></label>
							<input type="hidden" name="job_update_id" value="<?php echo $job_id; ?>">
							<input class="txt_lg" placeholder="Enter Job Title" data-validation-engine="validate[required]" name="job_title"  data-errormessage-value-missing="Please enter job title"  type="text" value="<?php echo $job_title; ?>">
						</li>				
						<li>
							<label>Job Location <em>*</em></label>
							<select name="job_location" data-validation-engine="validate[required]" data-errormessage-value-missing="Select job location" placeholder="Select Job Location">
								<option value="">Select job location</option>
								<?php 
								 $sql=mysql_query("select location_id,locationname from tbllocation where status=1 order by locationname");
								 $rows=mysql_num_rows($sql);
								 if($rows > 0)
								 {
									 while($locationdata=mysql_fetch_array($sql))
									 {
										 $selected='';
										 if($job_location==$locationdata['locationname'])
										 {
											 $selected='selected';
										 }
								 ?>
								 <option value="<?php echo $locationdata['locationname']; ?>" <?php echo $selected; ?>><?php echo $locationdata['locationname']; ?></option>
										<?php 
									 }
								 }
						        ?>
								
							</select>
						</li>	

						<li>
							<label>Address <em>*</em></label>
							<input class="txt_lg" id="autocomplete" name="address_1" placeholder="Enter Job Address" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter job address"  type="text" value="<?php echo $address1; ?>">
						</li>

						<li>
							<label>Post Code <em>*</em></label>
							<input class="txt_lg" placeholder="Enter Post Code" data-validation-engine="validate[required]" name="postalcode"  data-errormessage-value-missing="Please enter post code"  type="text" value="<?php echo $postalcode; ?>">
						</li>

						<li>
							<label>Job Category <em>*</em></label>
							<select name="categories[]"  data-validation-engine="validate[required]" data-errormessage-value-missing="Please select at least one category" id="duration_in">
								<option value="">Select Job Category</option>
								<?php 
							$sql=mysql_query("select category_id,category_name from tblcategory where isactive=1 order by category_name");
							$rows=mysql_num_rows($sql);
							if($rows > 0)
							{
								while($catdata=mysql_fetch_array($sql))
								{
									$checked='';
									if(in_array($catdata['category_id'],$categories))
									{
										$checked='selected';
									}
							?>
								<option value="<?php echo $catdata['category_id']; ?>" <?php echo $checked; ?>><?php echo $catdata['category_name']; ?></option>
								<?php } 
							}	
							?>
							</select>
						</li>

                        <li>
							<label>Job Type <em>*</em></label>
							<select name="job_type" id="job_type" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select job type">
                                <option value="">Select Job Type</option>
								<option value="1" <?php if($job_type==1){ ?> selected <?php } ?>>Part Time</option>
								<option value="2" <?php if($job_type==2){ ?> selected <?php } ?>>Full Time</option>
							</select>
						</li>    

						<li>
							<label>Opening Type <em>*</em></label>
							<div class="radio">
								<div class="rdrow">
								<input  id="rd1" class="rd_chk" value="1" <?php if($opening_type==1){ ?> checked <?php } ?> name="opening_type" checked type="radio">
								<label for="rd1">Single</label></div>
								<div class="rdrow">
									<input name="opening_type" value="2" id="rd2" <?php if($opening_type==2){ ?> checked <?php } ?> class="rd_chk" type="radio">
								<label for="rd2">Multiple</label></div>
							</div>
						</li>	
						<li>
							<label>Proposed Amount £ (per person per hour) <em>*</em></label>
							<input class="txt_lg" name="proposed_amount" style="width:200px;" placeholder="Enter Amount" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter proposed amount"  id="proposed_amount" value="<?php echo $proposed_amount; ?>" type="number">
						</li>	
							<li>
							<label>No. of Openings <em>*</em></label>
							<input class="txt_lg" name="opening_position" style="width:200px;" id="opening_position" placeholder="Enter no of vacancies" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter opening position"  type="number" value="<?php echo $opening_position; ?>">
						</li>	
						
						<li>
							<label>Duration (Days)<em>*</em></label>
							<input class="txt_lg" type="number" name="days" data-errormessage-value-missing="Please enter valid duration." data-validation-engine="validate[required]" style="width:200px;" id="days" value="<?php echo $days; ?>" placeholder="Enter Duration">
						</li>	
								<li>
							<label>No of Working hours per day <em>*</em></label>
							<input class="txt_lg" type="number" style="width:100px;" name="hours" data-errormessage-value-missing="Please enter No of Working hours per day." data-validation-engine="validate[required]" id="hours" value="<?php echo $hours; ?>">
						</li>	
							<li>
							<label>Start Date <em>*</em></label>
							<input type="text" name="start_date" style="width:200px;" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select start Date" value="<?php echo $start_date; ?>" class="txt_lg datepkr" id="datepicker" placeholder="Select Date">
						</li>	
								<li>
							<label>Job Description <em>*</em></label>
							<textarea name="description" data-errormessage-value-missing="Please enter description" data-validation-engine="validate[required]"><?php echo $description; ?></textarea>
						</li>
							<li>
							<label>Tags </label>
							<select name="tags[]" data-placeholder="Select Tags"  class="csselect txt_lg" multiple="multiple">
							 <?php 
						 $sql=mysql_query("select tag_id,tag_name from tbltag where status=1 order by tag_name");
						 $rows=mysql_num_rows($sql);
						 if($rows > 0)
						 {
							 while($catdata=mysql_fetch_array($sql))
							 {
								 $selected='';
								 if(in_array($catdata['tag_id'],$tags))
								 {
									 $selected='selected';
								 }
						 ?>
						     <option value="<?php echo $catdata['tag_id']; ?>" <?php echo $selected; ?>><?php echo $catdata['tag_name']; ?></option>
							<?php
							 }
						 }
						 ?>
							</select>
						</li>	
							<li>
							<label>Risk Meter <em>*</em></label>
							<select name="riskmeter" id="riskmeter">
								<option value="1" <?php if($riskmeter==1){ ?> selected <?php } ?>>Low</option>
								<option value="2" <?php if($riskmeter==2){ ?> selected <?php } ?>>Medium</option>
								<option value="3" <?php if($riskmeter==3){ ?> selected <?php } ?>>High</option>
								<option value="4" <?php if($riskmeter==4){ ?> selected <?php } ?>>Very High</option>
							</select>
						</li>		
							<li>
							<label>Nearest Transport Link </label>
							<input class="txt_lg" name="transportlink" id="transportlink" value="<?php echo $transportlink; ?>" type="text">
						</li>	
							<li>
							<label>Dress Code </label>
							<input class="txt_lg" name="dresscode_description" id="dresscode_description" type="text" value="<?php echo $dresscode_description; ?>">
						</li>	
							<li>
							<label>Upload Images <em>*</em></label>
							 <div class="file-upload">
							  <div class="file-select">   
								<div class="file-select-name" id="noFile"></div> 
								 <div class="file-select-button" id="fileName">Browse</div>
								<input type="file" name="image[]"   multiple id="chooseFile">
							  </div> 
							</div>
							<?php 
							if($countrows3 > 0)
							{
								while($jobimage=mysql_fetch_array($getimagename))
								{
							?>
							<img src="<?php echo JOBS_IMG_URL.$jobimage['imagename']; ?>" style="width:100px;">
					     <?php } 
						    }
						 ?>
						</li>	
							<li>
							<label>Feature Task? </label>
					 <div class="tk">
					 <input id="ckbox" type="checkbox" name="is_featured" <?php if($isfeatured==1){ ?> checked <?php } ?> id="is_featured" value="1">
					 	<label for="ckbox">By Clicking this checkbox you mark your task as featured. Extra fee is applied</label>
					 </div>
						</li>	
					</ul>
				</div>
		 		
				</div>
					<div class="nextbtn">
					<input value="Save" id="next" name="submit" class="btn_lg" type="submit">				
				</div>
				</form>
				</div>
			    
				
			</div>
			
		</div>
	</div>
</div>

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