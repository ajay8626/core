<?php 
include "config.php"; 

require_once(ADMIN_PATH."inc/img_upload.php");
include_once(ADMIN_PATH."inc/functions.php");
include_once(ADMIN_PATH."inc/resize-class.php");

$job_title=isset($_SESSION['jobdetails']['job_title']) ? $_SESSION['jobdetails']['job_title']:'';
$job_location=isset($_SESSION['jobdetails']['job_location']) ? $_SESSION['jobdetails']['job_location']:'';
$categories=isset($_SESSION['jobdetails']['categories']) ? $_SESSION['jobdetails']['categories']:'';
$postalcode=isset($_SESSION['jobdetails']['postalcode']) ? $_SESSION['jobdetails']['postalcode']:'';
$address1=isset($_SESSION['jobdetails']['address_1']) ? $_SESSION['jobdetails']['address_1']:'';
$opening_type=isset($_SESSION['jobdetails']['opening_type']) ? $_SESSION['jobdetails']['opening_type']:'';
$proposed_amount=isset($_SESSION['jobdetails']['proposed_amount']) ? $_SESSION['jobdetails']['proposed_amount']:'';
$opening_position=isset($_SESSION['jobdetails']['opening_position']) ? $_SESSION['jobdetails']['opening_position']:'1';
$duration_in=isset($_SESSION['jobdetails']['duration_in']) ? $_SESSION['jobdetails']['duration_in']:'';
$days=isset($_SESSION['jobdetails']['days']) ? $_SESSION['jobdetails']['days']:'';
$hours=isset($_SESSION['jobdetails']['hours']) ? $_SESSION['jobdetails']['hours']:'';
$start_date=isset($_SESSION['jobdetails']['start_date']) ? $_SESSION['jobdetails']['start_date']:'';
$description=isset($_SESSION['jobdetails']['description']) ? $_SESSION['jobdetails']['description']:'';
$tags=isset($_SESSION['jobdetails']['tags']) ? $_SESSION['jobdetails']['tags']:'';
$riskmeter=isset($_SESSION['jobdetails']['riskmeter']) ? $_SESSION['jobdetails']['riskmeter']:'';
$job_type=isset($_SESSION['jobdetails']['job_type']) ? $_SESSION['jobdetails']['job_type']:'';
$transportlink=isset($_SESSION['jobdetails']['transportlink']) ? $_SESSION['jobdetails']['transportlink']:'';
$dresscode_description=isset($_SESSION['jobdetails']['dresscode_description']) ? $_SESSION['jobdetails']['dresscode_description']:'';
$is_featured=isset($_SESSION['jobdetails']['is_featured']) ? $_SESSION['jobdetails']['is_featured']:0;

$last_id=isset($_SESSION['last_id']) ? $_SESSION['last_id'] : ''; 

$readonly='';
if($opening_type=='' || $opening_type==1) {
$readonly='readonly';
}

$jobimagescount=0;
if (isset($_SESSION['last_id']) && $_SESSION['last_id']!='') {
$jobimages=mysql_query("select * from tbljobimages where jobid=".$_SESSION['last_id']."");
$jobimagescount=mysql_num_rows($jobimages);
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
<title>Add New Job - SECURE THAT JOB</title>

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
	jQuery( function(){
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
		var filesAllowed = ["jpg", "jpeg"];
		if( (filesAllowed.indexOf(ext) ) == -1){
			return "Only JPG, JPEG files are allowed";
		}
	}
}
</script>
<script>
jQuery(document).ready(function($) {
$('#rd1').click(function() {
//alert("hello");
$('#opening_position').val('1');
$('#opening_position').attr('readonly', true);
});
$('#rd2').click(function() {
$('#opening_position').attr('readonly', false);
});
});
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
				<h2>Add New Job Details</h2>
				<div class="jobdetail">
				<form method="post" name="addjob" enctype="multipart/form-data" class="validateForm" action="publish.php">
					<ul class="jobtab">
						<li class="active"><a href="#">Enter Job Details</a></li>
						<li><a href="#">Publish</a></li>
					</ul>
					<div class="jobmain">
						<div class="jobleft">
						
					<ul>	
						<li>
							<label>Job Title <em>*</em></label>
							<input type="hidden" name="last_id" value="<?php echo $last_id; ?>">
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
							<label>Postcode <em>*</em></label>
							<input class="txt_lg" placeholder="Enter Postcode" data-validation-engine="validate[required]" name="postalcode"  data-errormessage-value-missing="Please enter post code"  type="text" value="<?php echo $postalcode; ?>">
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
							<input class="txt_lg" name="opening_position" style="width:200px;" id="opening_position" placeholder="Enter no of vacancies" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter opening position"  type="number" <?php echo $readonly; ?> value="<?php echo $opening_position; ?>">
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
							<label>Risk Meter</label>
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
							<label>Upload Images </label>
							<div class="file-upload">
							  	<div class="file-select">   
									<div class="file-select-name" id="noFile"></div> 
								 	<div class="file-select-button" id="fileName">Browse</div>
									<input type="file" name="image[]" <?php if ($jobimagescount == 0) { ?>  data-validation-engine="validate[funcCall[geThan[]]]" <?php } ?> multiple id="chooseFile">
							  	</div> 
							</div>
							<?php if ($jobimagescount > 0) { 
							while($jobimage=mysql_fetch_array($jobimages)) {
							?>
							<img src="<?php echo JOBS_IMG_URL.$jobimage['imagename']; ?>" style="width:100px;">
							<?php } 
							}
							?>
						</li>

						<li>
							<label>Feature Task? </label>
					 		<div class="tk">
					 			<input id="ckbox" type="checkbox" name="is_featured" <?php if($is_featured==1){ ?> checked <?php } ?> id="is_featured" value="1">
					 			<label for="ckbox">By Clicking this checkbox you mark your task as featured. Extra fee is applied</label>
					 		</div>
						</li>

					</ul>
				</div>
		 		
				</div>
					<div class="nextbtn">
					<input value="Next" id="next" name="submit" class="btn_lg" type="submit">				
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