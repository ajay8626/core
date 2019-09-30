<?php
if(!in_array(11,$tes_mod)) { 
echo "<div class='grid_12'><div class='message error'><p>You don't have permission to access this page</p></div></div>";
die;
}


if(isset($_REQUEST['id']) && $_REQUEST['id']!=''){ 	

	$select_query = mysql_query("SELECT `tblcoursemaster`.`start_time`,`tblcoursemaster`.`course_body_certificate`,`tblcoursemaster`.`specify_days`,`tblcoursemaster`.`image`,`tblcoursemaster`.`description`,`tblcoursemaster`.`enrollment_limit`,`tblcoursemaster`.`duration`,`tblcoursemaster`.`start_date`,`tblcoursemaster`.`course_id`,`tblcoursemaster`.`course_body`,`tblcoursemaster`.`course_title`, `tblcoursemaster`.`location`, `tblcoursemaster`.`price`,`tblcoursemaster`.`status`,`tbluser`.`firstname`,`tbluser`.`lastname`,`tblcoursecategory`.`category_name`
		FROM `tblcoursemaster`
		INNER JOIN `tbluser` ON `tblcoursemaster`.`created_by`=`tbluser`.`user_id`
		INNER JOIN tblcoursecategory ON `tblcoursemaster`.`category_id` = `tblcoursecategory`.`category_id`
		WHERE `tblcoursemaster`.`course_id`=".$_REQUEST['id']."");
	$row = mysql_fetch_assoc($select_query);
}

/*
$CustomerSql = mysql_query("select user_id, firstname,lastname from tbluser where status = '1' and user_type = 'Job Poster' ORDER By `firstname`");
*/
?>
<style type="text/css">
.poserror .datepickerformError {
	position: absolute !important;
	top: 35px !important;
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
		<section class="content-header">
		  <h1>
			Courses
			
		  </h1>
		  <ol class="breadcrumb">
			<li><a href="<?php echo ADMIN_URL; ?>main.php"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="<?php echo ADMIN_URL; ?>main.php?pg=viewcourse"><i class="fa fa-suitcase"></i>Course</a></li>
			
		  </ol>
		</section>

    <!-- Main content -->
		 <section class="content">
			  <div class="row">
					<div class="col-md-6">
					  <!-- general form elements -->
					  <div class="box box-primary">
						<div class="box-header with-border">
						  <h3 class="box-title">Course Detail</h3>
						</div>
						<div class="error"></div>
						<!-- /.box-header -->
						<!-- form start -->
						<form role="form" class="validateForm" name="Admin" action="main.php?pg=courseproc" method="post" enctype="multipart/form-data">
						<input type="hidden" value="add" name="act">
						  <div class="box-body">
							<div class="form-group">
								<label for="exampleInputEmail1">Course Title</label>
								<input type="text" name="name" id="name" class="form-control input3 mini" value="<?php echo $row['course_title']; ?>" readonly>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Course Created By</label>
								<input type="text" name="name" id="name" class="form-control input3 mini" value="<?php echo $row['firstname'].' '.$row['lastname']; ?>" readonly>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Course Body</label>
								<input type="text" name="name" id="name" class="form-control input3 mini" value="<?php echo $row['course_body']; ?>" readonly>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Course Category</label>
								<input type="text" name="name" id="name" class="form-control input3 mini" value="<?php echo $row['category_name']; ?>" readonly>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Course Start</label>
								<input type="text" name="name" id="name" class="form-control input3 mini" value="<?php echo $row['start_date'].' '.$row['start_time']; ?>" readonly>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Course Duration</label>
								<input type="text" name="name" id="name" class="form-control input3 mini" value="<?php echo $row['duration']; ?> Days" readonly>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Course Specify Days</label>
								<input type="text" name="name" id="name" class="form-control input3 mini" value="<?php echo $row['specify_days']; ?> Days" readonly>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Course Price</label>
								<input type="text" name="name" id="name" class="form-control input3 mini" value="<?php echo $row['price']; ?>" readonly>
							</div>

							<div class="form-group">
								<label for="exampleInputEmail1">Course Location</label>
								<input type="text" name="name" id="name" class="form-control input3 mini" value="<?php echo $row['location']; ?>" readonly>
							</div>

							<div class="form-group">
								<label for="exampleInputEmail1">Course Enrollment Limit</label>
								<input type="text" name="name" id="name" class="form-control input3 mini" value="<?php echo $row['enrollment_limit']; ?>" readonly>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Course Description</label>
								<textarea class="form-control" style='min-height:300px;' readonly="readonly"><?php echo $row['description']; ?></textarea>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Course Image</label>
								<?php

								$file = SITE_URL.'course/images/'.$row['image'];
								$file_headers = @get_headers($file);

								if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
								    $exists = "false";
								}
								else {
								    $exists = "true";
								}
								if ($exists == "true") { ?>
									<img class="form-control" src="<?php echo SITE_URL.'course/images/'.$row['image']; ?>" style="height: 200px;width: 200px" >
								<?php } else { ?>
									<img class="form-control" src="<?php echo SITE_URL.'course/images/default.png'; ?>" style="height: 200px;width: 200px" >
								<?php } ?>					
								
							</div>

							<div class="form-group">
								<label for="exampleInputEmail1">Course Body Certificate</label>
								<?php
								if ($row['course_body_certificate']!=null) { ?>
								<label class="form-control">
									<a href="<?php echo SITE_URL.'course/certificates/'.$row['course_body_certificate']; ?>" download>
									 	Click here for download certificate!
									 </a>
								</label>
									  
								<?php } else { ?>
									<label class="form-control">File not uploded!</label>
								<?php } ?>
													
								
							</div>
							
						  </div>
						  <!-- /.box-body -->
							
						  
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
function getCities(val) {
	$.ajax({
		type: "POST",
		url: "<?php echo ADMIN_URL ?>phpajax/get_city.php",
		data:'state_id='+val,
		success: function(data){
			$("#city_id").html(data);	
		}
	});
}
/*function getstate(val) {
	$("#loaderstate").show();
	$.ajax({
	type: "POST",
	url: "<?php echo ADMIN_URL ?>phpajax/get_state.php",
	data:'country_id='+val+'&state_id=<?php echo $state_id; ?>',
	success: function(data){
		$("#loaderstate").hide();
		$("#state-list").html(data);	}
	});
} */
function geThan(){
	
	var extFile  = document.getElementById("image").value;
	var ext = extFile.split('.').pop();
	var filesAllowed = ["jpg", "jpeg", "png"];
	if( (filesAllowed.indexOf(ext)) == -1)
		return "Only JPG , PNG files are allowed";
}
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