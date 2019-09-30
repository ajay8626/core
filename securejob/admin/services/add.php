<?php
if(!in_array(3,$tes_mod)) { 
echo "<div class='grid_12'><div class='message error'><p>You don't have permission to access this page</p></div></div>";
die;
}

$CustomerSql = mysql_query("select user_id, firstname,lastname from tbluser where status = '1' and user_type = 'Job Candidate' ORDER By `firstname`");
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
		<section class="content-header">
		  <h1>
			Services
			
		  </h1>
		  <ol class="breadcrumb">
			<li><a href="<?php echo ADMIN_URL; ?>main.php"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="<?php echo ADMIN_URL; ?>main.php?pg=viewservices"><i class="fa fa-gears"></i>Services</a></li>
			
		  </ol>
		</section>

    <!-- Main content -->
		 <section class="content">
			  <div class="row">
					<div class="col-md-6">
					  <!-- general form elements -->
					  <div class="box box-primary">
						<div class="box-header with-border">
						  <h3 class="box-title">Add Service</h3>
						</div>
						<div class="error"></div>
						<!-- /.box-header -->
						<!-- form start -->
						<form role="form" class="validateForm" name="Admin" action="main.php?pg=serviceproc" method="post" enctype="multipart/form-data">
						<input type="hidden" value="add" name="act">
						  <div class="box-body">
							<div class="form-group">
								<label for="exampleInputEmail1">Image</label>
								<input type="file" 		
								data-validation-engine="validate[funcCall[geThan[]]]" 
								data-errormessage-value-missing="Only JPG and PNG are allowed"
								name="image" id="image" class="form-control input3 mini"  >
								<span style="font-size:12px;font-weight:normal;">Recommended size is 780(height) X 780(width). </span>
							</div>
							
							<div class="form-group">
								<label>Tilte</label><span style="color:#FF0000;">*</span>
								<input type="text" name="jobname" id="jobname" class="form-control input3 mini" id="exampleInputEmail1" placeholder="Enter Service Title" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter service title" maxlength="50"  >
							</div>
							
							<div class="form-group">
								<label>Select User</label>
								<label class="pull-right"><a href="main.php?pg=adduser">New User</a></label>
								<select  name="user_id" class="form-control select"  data-validation-engine="validate[required]" data-errormessage-value-missing="Please select user"  >
								<?php while($CustomerRecord = mysql_fetch_assoc($CustomerSql)):?>
									<option value="<?php echo $CustomerRecord['user_id'];?>"><?php echo $CustomerRecord["firstname"]. " ".$CustomerRecord["lastname"]; ?></option>
								<?php endwhile; ?>
								</select>
							</div>
							
							<div class="form-group">
								<label>Description</label><span style="color:#FF0000;">*</span>
								<textarea class="form-control" style='min-height:300px;'  data-errormessage-value-missing="Please enter description" data-validation-engine="validate[required]" name="description" ></textarea>
							</div>
							
							<div class="form-group">
								<label>Instruction</label>
								<textarea class="form-control" style='min-height:100px;'  data-errormessage-value-missing="" data-validation-engine="" name="instruction" ></textarea>
							</div>
							
							<div class="form-group">
								<label for="exampleInputPassword1">Category</label><span style="color:#FF0000;">*</span>
								<?php $selectCategories = mysql_query("SELECT category.category_id, category.category_name FROM tblcategory as category WHERE category.isactive=1 order by category.category_name");
								?>				
								<select class="form-control" name="categories[]"  size="6" multiple data-validation-engine="validate[required]" data-errormessage-value-missing="Please select at least one category." style="width: 320px;" >
									<?php
									while($category = mysql_fetch_array($selectCategories)){ 
										$categoryName = $category['category_name'];	?>
										<option value="<?php echo $category['category_id']; ?>"><?php echo $categoryName; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label>Tags</label>
								<?php $selectTags = mysql_query("SELECT tag.tag_id, tag.tag_name FROM tbltag as tag WHERE tag.status=1 order by tag.tag_name");
								?>				
								<select class="form-control" name="tags[]"  size="6" multiple style="width: 320px;" >
									<?php
									while($tag = mysql_fetch_array($selectTags)){ 
										$tagName = $tag['tag_name'];	?>
										<option value="<?php echo $tag['tag_id']; ?>"><?php echo $tagName; ?></option>
									<?php } ?>
								</select>
							</div>
							
							<div class="form-group">
								<label>Price</label><span style="color:#FF0000;">*</span>
								<input type="text" name="price" id="price" class="form-control" id="exampleInputEmail1" placeholder="Enter Price" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter price" maxlength="10" >
							</div>
							
							<div class="form-group">
								<label>Weekend Day Price</label>
								<input type="text" name="weekend_day_price" id="weekend_day_price" class="form-control" id="exampleInputEmail1" placeholder="Enter Weekend Day Price" data-validation-engine="" data-errormessage-value-missing="Please enter weekend day price" maxlength="10" >
							</div>
							<div class="form-group">
								<label>Weekend Night Price</label>
								<input type="text" name="weekend_night_price" id="weekend_night_price" class="form-control" id="exampleInputEmail1" placeholder="Enter Weekend Night Price" data-validation-engine="" data-errormessage-value-missing="Please enter weekend night price" maxlength="10" >
							</div>
							<div class="form-group">
								<label>Holiday Price</label>
								<input type="text" name="holiday_price" id="holiday_price" class="form-control" id="exampleInputEmail1" placeholder="Enter Holiday Price" data-validation-engine="" data-errormessage-value-missing="Please enter holiday price" maxlength="10" >
							</div>
							
							<div class="form-group">
								<label>Days</label><span style="color:#FF0000;">*</span>
								<input type="number" maxlength='4' name="days" id="days" value="" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter days." class="form-control" min="1" max="31" />
							</div>
							<div class="form-group">
								<label>Hours</label><span style="color:#FF0000;">*</span>
								<input type="number" maxlength='4' name="hours" id="hours" value=""  data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter hours." class="form-control" min="1" max="24" />
							</div>
							
							<div class="form-group">
							  <label >Availability</label><span style="color:#FF0000;">*</span>
							  <input type="number" name="availability"  id="availability" class="form-control" maxlength="4" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter availability." min="1" max="7" >
							</div>
							<div class="form-group">
							  <label >Enter how far you are willing to travel for service</label>
							  <input type="text" name="willing_to_travel"  id="willing_to_travel" class="form-control" placeholder="Willing to travel for service" maxlength="250" data-validation-engine="" >
							</div>
							<div class="form-group">
								<label for="exampleCustomertype">Do you Drive?</label>
								<select name="do_you_drive" class="form-control"  data-validation-engine="" style="" >
									<option value="1">Yes</option>
									<option value="0">No</option>
								</select>
							</div>
							<div class="form-group">
							  <label >Nationality</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="nationality"  id="nationality" class="form-control" placeholder="Enter Nationality" maxlength="55" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter nationality" >
							</div>
							<div class="form-group">
							  <label >Languages spoken</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="languages_spoken"  id="languages_spoken" class="form-control" placeholder="Enter Languages spoken" maxlength="55" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter languages spoken" >
							</div>
							
							<div class="form-group">
							  <label >Latitude</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="latitude"  id="latitude" class="form-control" placeholder="Enter Latitude" maxlength="20" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter latitude" >
							</div>
							<div class="form-group">
							  <label>Longitude</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="longitude"  id="longitude" class="form-control" placeholder="Enter Longitude" maxlength="20" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter longitude">
							</div>
							
							<div class="form-group">
							  <label>Address 1</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="address_1"  id="address_1" class="form-control" placeholder="Enter Adress 1" maxlength="250" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter address" >
							</div>
							<div class="form-group">
							  <label for="exampleInputPassword1">Address 2</label>
							  <input type="text" name="address_2"  id="address_2" class="form-control" id="exampleInputAddress2" placeholder="Enter Adress 2" maxlength="250" >
							</div>
							<div class="form-group">
							  <label>Postal Code</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="postal_code"  id="postal_code" class="form-control" id="exampleInputPostalCode" placeholder="Enter Postal Code" maxlength="8" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter Postal Code" >
							</div>
							
							<div class="form-group">
							<label>Country</label><span style="color:#FF0000;">*</span>
							
								<select class="form-control" name="country_id"  size="" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select country name" >
								
								<?php 
									$select_query = mysql_query("SELECT * FROM tblcountries where id='230'");
									while($row = mysql_fetch_assoc($select_query)) { ?>
								
										<option selected="selected" value="<?php echo $row['id'] ?>"><?php echo $row['name']; ?></option>
									 <?php } ?>		
								</select>
							
							</div>
							
							<div class="form-group">
							<label>State</label><span style="color:#FF0000;">*</span>
							
								<select class="form-control" name="state_id" id="state_id"  size="" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select state name"  onchange="getCities(this.value)">
								<option value="">Select State</option>
								<?php 
									$select_query = mysql_query("SELECT * FROM tblstates where country_id='230'");
									while($row = mysql_fetch_assoc($select_query)) { ?>
								
										<option value="<?php echo $row['id'] ?>"><?php echo $row['name']; ?></option>
									 <?php } ?>		
								</select>
							
							</div>
							
							<div class="form-group">
								<label>City</label><span style="color:#FF0000;">*</span>
								<select class="form-control" id="city_id" name="city_id"  size="" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select city name" >
								
									<option value="">Select City</option>
										
								</select>
							</div>
							
							<div class="form-group">
							  <label for="exampleInputPassword1">Is Featured?</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" value="1" name="is_featured"  > NOTE:- Please tick this checkbox if you want to featured the service</label>
							  
							</div>
							
							<div class="form-group">
							  <label for="exampleInputPassword1">Status</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" value="1" name="status"  > NOTE:- Please tick this checkbox if you want to active the service</label>
							  
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

/* function getcity(val) {
	$("#loader").show();
	$.ajax({
	type: "POST",
	url: "<?php echo ADMIN_URL ?>phpajax/get_city.php",
	data:'state_id='+val+'&city_id=<?php echo $city_id; ?>',
	success: function(data){
		$("#loader").hide();
		$("#city-list").html(data);	}
	});
}
function getstate(val) {
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
			autoclose: true
		});
	});
</script>