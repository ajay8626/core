<?php
if(!in_array(5,$tes_mod)) { 
	echo "<div class='grid_12'><div class='message error'><p>You don't have permission to access this page</p></div></div>";
	die;
}
require_once(ADMIN_PATH."inc/img_upload.php");
include_once(ADMIN_PATH."inc/functions.php");
include_once(ADMIN_PATH."inc/resize-class.php");
// Get data from db for modification 
	$a_id = $_REQUEST["id"];
	$sql = "select * from tblcourse where course_id = {$a_id}"; 
	$result = $db->Query($sql);
	$a_name = "";
	list($course_id,$name,$description,$price,$image,$course_days,$course_hours,$course_time,$start_date,$latitude,$longitude,$address1,$address2,$postalcode,$country_id,$state_id,$city_id,$created_date,$isfeatured,$status,$course_location) = mysql_fetch_row($result);		
	/* echo "<pre>";
	echo $job_id."-".$job_user_id."-".$job_name."-".$job_description."-".$price."-".$image."-".$job_days."-".$job_hours."-".$start_date."-".$latitude."-".$longitude."-".$address1."-".$address2."-".$postalcode."-".$riskmeter."-".$transport_link."-".$dresscode."-".$created_date."-".$isfeatured."-".$status;
	exit; */
	$db->Free($result);
	$isActiveChecked = "";
	if($status == 1){ 
		$isActiveChecked = "checked=checked"; 
	}
	$isFeaturedChecked = "";
	if($isfeatured == 1){ 
		$isFeaturedChecked = "checked=checked"; 
	} 
	
	$sqlCategory = "select category_id from tbl_course_category where course_id = {$a_id}"; 
	$resultCats = $db->Query($sqlCategory);
	$courseCategories = array();
	while($row = mysql_fetch_assoc($resultCats)){
		$courseCategories[] = $row['category_id'];
	}
	$courseCategoriesText = implode(',',$courseCategories);
?>
<script type="text/javascript" src="js/jquery.fancybox.js"></script>
<link href="css/jquery.fancybox.css" type="text/css" rel="stylesheet" />

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
		<section class="content-header">
		  <h1>
			Courses
			
		  </h1>
		  <ol class="breadcrumb">
			<li><a href="<?php echo ADMIN_URL; ?>main.php"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="<?php echo ADMIN_URL; ?>main.php?pg=viewcourse"><i class="fa fa-suitcase"></i>Courses</a></li>
			
		  </ol>
		</section>

    <!-- Main content -->
		 <section class="content">
			  <div class="row">
					<div class="col-md-6">
					  <!-- general form elements -->
					  <div class="box box-primary">
						<div class="box-header with-border">
						  <h3 class="box-title">Modify Course</h3>
						</div>
						<div class="error"></div>
						<!-- /.box-header -->
						<!-- form start -->
						<form role="form" class="validateForm" name="Admin" action="main.php?pg=courseproc" method="post" enctype="multipart/form-data">
						<input type="hidden" value="mod" name="act">
						<input type="hidden" value="<?php echo $a_id;?>" name="id">
						  <div class="box-body">
							<?php 
							
							if($image!=''){
								$src=COURSE_IMG_URL.get_image_thumbnail($image);  
							?>
								<div class="form-group">
									<label for="exampleInputEmail1">Image</label>
									<a href="<?php echo $src; ?>" class="enLarge" ><img src="<?php echo $src; ?>"  width='64' width='64'/></a><br/>
									
									<input type="checkbox" name ="rmavatar" value='1' /> <input type="hidden" name="rmimage" value="<?php echo $image; ?>" /> Remove Course Image 
								</div>
								
							<?php } ?>
							
							<div class="form-group">
								<label>Course Image</label>
								<input type="file" 		
								data-validation-engine="validate[funcCall[geThan[]]]" 
								data-errormessage-value-missing="Only JPG and PNG are allowed"
								name="image" id="image" class="form-control input3 mini"  >
								<span style="font-size:12px;font-weight:normal;">Recommended size is 780(height) X 780(width). </span>
							</div>
							
							<div class="form-group">
								<label>Course Name</label><span style="color:#FF0000;">*</span>
								<input type="text" name="name" id="name" class="form-control input3 mini" placeholder="Enter Course Name" data-validation-engine="validate[required]" value="<?php echo $name; ?>" data-errormessage-value-missing="Please enter course name"maxlength="50"  >
							</div>
							
							
							<div class="form-group">
								<label>Description</label><span style="color:#FF0000;">*</span>
								<textarea class="form-control" style='min-height:300px;'  data-errormessage-value-missing="Please enter description" data-validation-engine="validate[required]" name="description" ><?php echo $description; ?></textarea>
							</div>
							<div class="form-group">
								<label>Price (&pound;)</label><span style="color:#FF0000;">*</span>
								<input type="text" name="price" id="price" class="form-control" placeholder="Enter Price" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter price" value="<?php echo $price; ?>" maxlength="10"  />
							</div>
							<?php /* ?>
							<div class="form-group">
								<label>Category</label><span style="color:#FF0000;">*</span>
								<?php $selectCategories = mysql_query("SELECT category.category_id, category.category_name FROM tblcoursecategory as category WHERE category.isactive=1  order by category.category_name");
								?>				
								<select class="form-control" name="categories[]"  size="6" multiple data-validation-engine="validate[required]" data-errormessage-value-missing="Please select at least one category." style="width: 320px;" >
								<option value="">Select Course Category</option>
									<?php
									while($category = mysql_fetch_array($selectCategories)){ 
										$categoryCheck = "";
										if(in_array($category['category_id'],$courseCategories))
											$categoryCheck = "selected";
										
										$categoryName = $category['category_name'];	?>
										<option value="<?php echo $category['category_id']; ?>" <?php echo $categoryCheck; ?>><?php echo $categoryName; ?></option>
									<?php } ?>
								</select>
							</div>
							<?php */ ?>
							<div class="form-group">
								<label>Course Location</label><span style="color:#FF0000;">*</span>
								<input type="text"  name="course_location" id="autocomplete" value="<?php echo $course_location;  ?>"   class="form-control" placeholder="Enter Course Location" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter course location" />
							</div>
                            
                            <div class="form-group">
								<label>Postal Code</label><span style="color:#FF0000;">*</span>
								<input type="text" name="postal_code" id="postal_code" class="form-control input3 mini" placeholder="Enter Postal Code" data-validation-engine="validate[required]" value="<?php echo $postalcode; ?>" data-errormessage-value-missing="Please enter postal code"maxlength="50"  >
							</div>
                            
                            <div class="form-group">
							  <label >Course Time</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="course_time"  id="course_time" class="form-control" placeholder="Enter Course Time" maxlength="20" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter course time" value="<?php echo $course_time;  ?>" >
							</div>
							<?php /* ?>
							<div class="form-group">
								<label>Course Hours</label><span style="color:#FF0000;">*</span>
								<input type="number" maxlength='4' name="course_hours" id="hours"   data-errormessage-value-missing="Please enter valid data." data-validation-engine="validate[required,custom[number]]" class="form-control" value="<?php echo $course_hours; ?>"  min="1" max="24" />
							</div>
							<?php */ ?>
							<div class="form-group">
								<label>Course Duration</label><span style="color:#FF0000;">*</span>
								<input type="text"  name="course_days" id="days"   data-errormessage-value-missing="Please enter valid data." data-validation-engine="validate[required]" class="form-control" value="<?php echo $course_days; ?>"  />
							</div>
							<?php
							$date = '';
							if($start_date != '')
							{
								$date = date('d/m/Y',strtotime($start_date));
							}
							?>
							<div class="form-group">
							<label>Course Start Date:</label><span style="color:#FF0000;">*</span>
							<div class="poserror" style="display:table;position: relative;margin-bottom: 30px !important">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
								<input type="text"  name="start_date" class="form-control pull-right" id="datepicker" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select start Date"  value="<?php echo $date; ?>" maxlength="10"  />
							</div>
						</div>
						     <?php /* ?>
							<div class="form-group">
							  <label >Latitude</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="latitude"  id="latitude" class="form-control" placeholder="Enter Latitude" maxlength="20" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter latitude" value="<?php echo $latitude; ?>" >
							</div>
							<div class="form-group">
							  <label>Longitude</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="longitude"  id="longitude" class="form-control" placeholder="Enter Longitude" maxlength="20" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter longitude" value="<?php echo $longitude; ?>">
							</div>
							
							<div class="form-group">
							  <label>Address 1</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="address_1"  id="address_1" class="form-control" placeholder="Enter Adress 1" maxlength="250" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter address" value="<?php echo $address1; ?>" />
							</div>
							<div class="form-group">
							  <label>Address 2</label>
							  <input type="text" name="address_2"  id="address_2" class="form-control" placeholder="Enter Adress 2" maxlength="250" value="<?php echo $address2; ?>" />
							</div>
							<div class="form-group">
							  <label>Postal Code</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="postal_code"  id="postal_code" class="form-control" placeholder="Enter Postal Code" maxlength="8" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter Postal Code" value="<?php echo $postalcode; ?>" />
							</div>
							
							<div class="form-group">
							<label>Country</label><span style="color:#FF0000;">*</span>
							
								<select class="form-control" name="country_id" id="country_id"  size="" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select country" >
								
								<?php 
									$select_query = mysql_query("SELECT * FROM tblcountries where id='230'");
									while($row = mysql_fetch_assoc($select_query)) { ?>
								
										<option selected="selected" value="<?php echo $row['id'] ?>"><?php echo $row['name']; ?></option>
									 <?php } ?>		
								</select>
							
							</div>
							
							<div class="form-group">
							<label>State</label><span style="color:#FF0000;">*</span>
							
								<select class="form-control" name="state_id" id="state_id"  size="" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select state"  onchange="getCities(this.value)">
								
								<?php 
									$select_query = mysql_query("SELECT * FROM tblstates where country_id='230'");
									while($row = mysql_fetch_assoc($select_query)) { ?>
								
										<option <?php if($state_id== $row['id']){ ?>selected="selected" <?php } ?> value="<?php echo $row['id'] ?>"><?php echo $row['name']; ?></option>
									 <?php } ?>		
								</select>
							
							</div>
							
							<div class="form-group">
								<label>City</label><span style="color:#FF0000;">*</span>
								<select class="form-control" id="city_id" name="city_id"  size="" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select city" >
								
									<option value="">Select City</option>
										<?php 
									$select_query = mysql_query("SELECT * FROM tblcities where state_id='3805'");
									while($row = mysql_fetch_assoc($select_query)) { ?>
								
										<option <?php if($state_id== $row['id']){ ?>selected="selected" <?php } ?> value="<?php echo $row['id'] ?>"><?php echo $row['name']; ?></option>
									 <?php } ?>		
								</select>
							</div>
							<?php */ ?>
							<?php /*
							<div class="form-group">
							  <label>Is Featured?</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" value="1" name="is_featured" <?php echo $isFeaturedChecked; ?>  > NOTE:- Please tick this checkbox if you want to featured the course</label>
							  
							</div> */ ?>
							
							<div class="form-group">
							  <label>Status</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" value="1" name="status" <?php echo $isActiveChecked; ?>  > NOTE:- Please tick this checkbox if you want to display this course</label>
							  
							</div>
						  </div>
						  <!-- /.box-body -->
							
						  <div class="box-footer">
							<button type="submit"  name="submit_me"  class="btn btn-primary">Submit</button>
						  </div>
						</form>
					  </div>
					</div> 
				<!-- /.col -->
			  </div>
      <!-- /.row -->
		</section>
    <!-- /.content -->
	</div>
	<script src="<?php echo ADMIN_URL; ?>ck_new/ckeditor/ckeditor.js"></script>
<script src="<?php echo ADMIN_URL; ?>ck_new/ckfinder/ckfinder.js"></script> 

<script type="text/javascript">
var editordescription = CKEDITOR.replace( 'description', {
    filebrowserBrowseUrl : 'ckfinder/ckfinder.html',
    filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?type=Images',
    filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?type=Flash',
    filebrowserUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
    filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
    filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
});
CKFinder.setupCKEditor( editordescription, '../' );
</script>
	<script>
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
	
		var extFile  = document.getElementById("image").value;
		var ext = extFile.split('.').pop();
		var filesAllowed = ["jpg", "jpeg", "png"];
		if( (filesAllowed.indexOf(ext)) == -1)
			return "Only JPG , PNG files are allowed";
	}
	
	$(document).ready(function() {
		$(".enLarge").fancybox();
	});
	</script>
	<script src="js/select2.full.min.js"></script>

	<script>
		$(function () {
			//Date picker
			$('#datepicker').datepicker({
				autoclose: true,
			    format: 'dd/mm/yyyy'
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