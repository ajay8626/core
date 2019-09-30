<?php
if(!in_array(3,$tes_mod)) { 
echo "<div class='grid_12'><div class='message error'><p>You don't have permission to access this page</p></div></div>";
die;
}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
		<section class="content-header">
		  <h1>
			User
			
		  </h1>
		  <ol class="breadcrumb">
			<li><a href="<?php echo ADMIN_URL; ?>main.php"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="<?php echo ADMIN_URL; ?>main.php?pg=viewuser"><i class="fa fa-users"></i>User</a></li>
			
		  </ol>
		</section>

    <!-- Main content -->
		 <section class="content">
			  <div class="row">
					<div class="col-md-6">
					  <!-- general form elements -->
					  <div class="box box-primary">
						<div class="box-header with-border">
						  <h3 class="box-title">Add User</h3>
						</div>
						<div class="error"></div>
						<!-- /.box-header -->
						<!-- form start -->
						<form role="form" class="validateForm" name="Admin" action="main.php?pg=userproc" method="post" enctype="multipart/form-data">
						<input type="hidden" value="add" name="act">
						  <div class="box-body">
						    <div class="form-group">
								<label>Are you business or personal user?</label><span style="color:#FF0000;">*</span>
								<select name="user_type" id="user_type" class="form-control"  data-validation-engine="validate[required]" data-errormessage-value-missing="Please select user type" style="width: 320px;" onchange="get_val(this.value)">
									<option value="">Select User Type</option>
									<option value="1">Business User</option>
									<option value="2">Personal User</option>
								</select>
							</div>
						  
							<div class="form-group">
							  <label>Profile Picture</label>
							  <input type="file" 		
							  data-validation-engine="validate[required,funcCall[geThan[]]]" 
							  data-errormessage-value-missing="Please Select Valid Profile Picture"
							  name="profileimage" id="profileimage" class="form-control input3 mini"  >
							  <span style="font-size:12px;font-weight:normal;">Recommended size is 780(height) X 780(width). </span>
							</div>
                               
							<div class="form-group" id="div_company_name" style="display:none;">
							  <label>Company Name</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="company_name" id="company_name" class="form-control input3 mini" placeholder="Enter First Name" maxlength="50" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter your company name" >
							</div>   
							
							<div class="form-group">
							  <label>First Name</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="fname" id="fname" class="form-control input3 mini" placeholder="Enter First Name" maxlength="50" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter your first name" >
							</div>
							<div class="form-group">
							  <label>Last Name</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="lname" id="lname"  class="form-control" placeholder="Enter Last Name" data-validation-engine="validate[required]" maxlength="50" data-errormessage-value-missing="Please enter your last name"  >
							</div>
							<div class="form-group">
							  <label>Email Address</label><span style="color:#FF0000;">*</span>
							  <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" data-validation-engine="validate[required,custom[email]]" data-errormessage-value-missing="The e-mail address you entered appears to be incorrect." maxlength="70" data-errormessage-custom-error="Example: yourscreenname@aol.com" >
							</div>
							<div class="form-group">
							  <label>Password</label><span style="color:#FF0000;">*</span>
							  <input type="password" name="password" id="password" class="form-control" placeholder="Password" maxlength="12" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter password">
							</div>
							<div class="form-group">
							  <label>Confirm Password</label><span style="color:#FF0000;">*</span>
							  <input type="password" name="rpassword" id="rpassword" class="form-control" placeholder="Confirm Password"  maxlength="12" data-validation-engine="validate[required,equals[password]]" data-errormessage-value-missing="Please enter confirm password" data-errormessage-custom-error="The two passwords you entered did not match each other. Please try again.">
							</div>
							
							<div class="form-group">
							  <label>Phone</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="phone"  id="mobile" class="form-control" placeholder="Enter Phone" maxlength="11" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter your phone number" >
							</div>
							<div class="form-group" id="div_reg_no" style="display:none;">
							  <label>Registration No</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="registration_no"  id="registration_no" class="form-control"  placeholder="Enter Registration No" maxlength="250" data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter registration no" >
							</div>
							
							<div class="form-group" id="div_reg_vat_no" style="display:none;">
							  <label>VAT Registration No</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="vat_registration_no"  id="vat_registration_no" class="form-control"  placeholder="Enter Vat Registration No" maxlength="250" data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter vat registration no" >
							</div>
							
							<div class="form-group">
							  <label>Address Line 1</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="address_1"  id="address_1" class="form-control" id="exampleInputAddress1" placeholder="Enter Address 1" maxlength="250" data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter address line 1" >
							</div>
							<div class="form-group">
							  <label>Address Line 2</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="address_2"  id="address_2" class="form-control" placeholder="Enter Address 2" maxlength="250" data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter address line 2" >
							</div>
							<div class="form-group">
							  <label>Address Line 3</label>
							  <input type="text" name="address_3"  id="address_3" class="form-control" placeholder="Enter Address 3" maxlength="250" >
							</div>
                            
                            <div class="form-group">
								<label>Postal Code</label><span style="color:#FF0000;">*</span>
								<input type="text" name="postal_code" id="postal_code" class="form-control input3 mini" placeholder="Enter Postal Code" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter postal code" maxlength="15"  >
							</div>
                            
							<div class="form-group" >
						<label>Select County</label><span style="color:#FF0000;">*</span>
						
							<select class="form-control" name="state_id" id="state_id"  size="" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select state" onchange="getCities(this.value)">
							<option value="">Select County</option>
							<?php 
								$select_query = mysql_query("SELECT * FROM tblstates where country_id='230' ORDER By 'name' ASC");
                                while($row = mysql_fetch_assoc($select_query)) { ?>
							
									<option value="<?php echo $row['id'] ?>"><?php echo $row['name']; ?></option>
								 <?php } ?>		
							</select>
						</div>
						
						<div class="form-group">
							<label>Select City</label><span style="color:#FF0000;">*</span>
							<select class="form-control" id="city_id" name="city_id"  size="" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select city" >
							
								<option value="">Select City</option>
									
							</select>
						</div>
							<?php /* ?>
							<div class="form-group">
							  <label>Bank Name</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="bank_name"  id="bank_name" class="form-control" placeholder="Enter Bank Name" maxlength="250" data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter bank name">
							</div>
							
							<div class="form-group">
							  <label>Account Holders Name</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="acc_holder_name"  id="acc_holder_name" class="form-control" placeholder="Enter Account Holders Name" maxlength="250" data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter account holders name">
							</div>
							
							<div class="form-group">
							  <label>Sort Code</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="sort_code"  id="sort_code" class="form-control" placeholder="Enter Sort Code" maxlength="250" data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter sort code">
							</div>
							
							<div class="form-group">
							  <label>Account Number</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="acc_number"  id="acc_number" class="form-control" placeholder="Enter Account Number" maxlength="250" data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter account number">
							</div>
							<?php */ ?>
							
							<div class="form-group" id="dob" style="display:none;">
							<label>Date of Birth</label>
							<input class="form-control" id="birthdate"  maxlength='50' name="birthdate" value=""  />
			                </div>
							<div class="form-group">
							  <label>Upload Profile Video</label>
							  <input type="file" name="profilevideo" id="profilevideo" class="form-control input3 mini"  >
							  
							</div>
							<div class="form-group" id="gen" style="display:none;">
							<label>Gender</label><span style="color:#FF0000;">*</span><br>
							<input type="radio" name="gender" id="male" value="1">&nbsp;Male&nbsp;
							<input type="radio" name="gender" id="female"  value="2">&nbsp;Female
			                </div>
							<div class="form-group" id="hg" style="display:none;">
							  <label>Height</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="height"  id="height" class="form-control"  maxlength="10" style="width: 200px;" size="10">
							</div>
							<div class="form-group" id="build_div" style="display:none;">
								<label>Build</label><span style="color:#FF0000;">*</span>
								<select name="build" id="build" class="form-control"   style="width: 200px;">
									<option value="">Select Build</option>
									<?php 
								$select_query = mysql_query("SELECT * FROM tblbuild where status=1 ORDER By 'name' ASC"); 
								 while($row = mysql_fetch_assoc($select_query)) {
								?>
									<option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
									<?php } ?>	
								</select>
							</div>
							<div class="form-group" id="nationality_div" style="display:none;">
								<label>Nationality</label><span style="color:#FF0000;">*</span>
								<select name="nationality" id="nationality" class="form-control"   style="width: 200px;">
									<option value="">Select Nationality</option>
									<?php 
								$select_query = mysql_query("SELECT * FROM tblnationality where status=1 ORDER By 'name' ASC"); 
								 while($row = mysql_fetch_assoc($select_query)) {
								?>
									<option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
									<?php } ?>
									
								</select>
							</div>
							<div class="form-group" id="lan_div" style="display:none;">
								<label>Languages Spoken</label><span style="color:#FF0000;">*</span>
								<br>
								<?php 
								$select_query = mysql_query("SELECT * FROM 	tbllanguage where status=1 ORDER By 'name' ASC"); 
								 while($row = mysql_fetch_assoc($select_query)) {
								?>
								<input type="checkbox" name="language[]" value="<?php echo $row['name']; ?>">&nbsp;<?php echo $row['name']; ?>
								 <?php } ?>
								<!--<input type="checkbox" name="language[]" value="polish">&nbsp;Polish
								<input type="checkbox" name="language[]" value="wellish">&nbsp;Wellish
								<input type="checkbox" name="language[]" value="french">&nbsp;French-->
							</div>
							<div class="form-group" id='militry_div' style="display:none;">
							<label>Military Background</label><span style="color:#FF0000;">*</span><br>
							<input type="radio" name="militry" value="1">&nbsp;Yes&nbsp;
							<input type="radio" name="militry"   value="2">&nbsp;No
			                </div>
							<div class="form-group" id="drive_div" style="display:none;">
							<label>Do you drive?</label><span style="color:#FF0000;">*</span><br>
							<input type="radio" name="drive" value="1">&nbsp;Yes&nbsp;
							<input type="radio" name="drive"   value="2">&nbsp;No
			                </div>
							<div class="form-group" id="firstaid_div" style="display:none;">
							<label>First aid & Paramedic training?</label><span style="color:#FF0000;">*</span><br>
							<input type="radio" name="firstaid" value="1">&nbsp;Yes&nbsp;
							<input type="radio" name="firstaid"   value="2">&nbsp;No
			                </div>
                            
							<div class="form-group" id="tattoos_div" style="display:none;">
							<label>Visible Tattoos?</label><span style="color:#FF0000;">*</span><br>
							<input type="radio" name="tattoos" value="1">&nbsp;Yes&nbsp;
							<input type="radio" name="tattoos"   value="2">&nbsp;No
			                </div>
                            <div class="form-group" id="piercing_div" style="display:none;">
							<label>Visible Piercings?</label><span style="color:#FF0000;">*</span><br>
							<input type="radio" name="piercing" value="1">&nbsp;Yes&nbsp;
							<input type="radio" name="piercing"   value="2">&nbsp;No
			                </div>
                            
                            <div class="form-group" id="right_to_work_uk_div" style="display:none;">
                                <label>Do you have right to work in UK?</label><span style="color:#FF0000;">*</span><br>
                                <input type="radio" name="right_to_work_uk" value="1">&nbsp;Yes&nbsp;
                                <input type="radio" name="right_to_work_uk" value="2">&nbsp;No
			                </div>
                            
                            <div class="form-group" id="willing_to_travel_div" style="display:none;">
                                <label>Willing to travel abroad?</label><br>
                                <input type="radio" name="willing_to_travel" value="1">&nbsp;Yes&nbsp;
                                <input type="radio" name="willing_to_travel" value="2">&nbsp;No
			                </div>
                            
                            <div class="form-group" id="uk_driving_license_div" style="display:none;">
                                <label>Do you hold full UK Driving License?</label><span style="color:#FF0000;">*</span><br>
                                <input type="radio" name="uk_driving_license" value="1">&nbsp;Yes&nbsp;
                                <input type="radio" name="uk_driving_license" value="2">&nbsp;No
			                </div>
                            
                            <div class="form-group" id="cscs_card_div" style="display:none;">
                                <label>Do you have CSCS card?</label><br>
                                <input type="radio" name="cscs_card" value="1">&nbsp;Yes&nbsp;
                                <input type="radio" name="cscs_card" value="2">&nbsp;No
			                </div>
                            
							<div class="form-group" id="sia_div" style="display:none;">
							<label>SIA Badge?</label><span style="color:#FF0000;">*</span><br>
							<input type="radio" name="sia" value="1">&nbsp;Yes&nbsp;
							<input type="radio" name="sia" value="2">&nbsp;No
			                </div>
							<div class="form-group" id="activity_div" style="display:none;">
								<label>Any Ailments that could impair activity to work? </label>
								<textarea class="form-control" style='min-height:100px;'   name="activity" ></textarea>
							</div>
							<div class="form-group" id="health_div" style="display:none;">
								<label>Any Health Issues?</label>
								<textarea class="form-control" style='min-height:100px;'   name="health" ></textarea>
							</div>
							<div class="form-group" id="bio_div" style="display:none;">
								<label>Bio</label>
								<textarea class="form-control" style='min-height:100px;'   name="bio" ></textarea>
							</div>
                            <div class="form-group" id="experience_div" style="display:none;">
								<label>Experience</label>
								<textarea class="form-control" style='min-height:100px;'   name="experience" ></textarea>
							</div>
                            <div class="form-group" id="education_credentials_div" style="display:none;">
								<label>Education and Further Credentials</label>
								<textarea class="form-control" style='min-height:100px;'   name="education_credentials" ></textarea>
							</div>
							
							<?php /*
							<div class="form-group">
						<label>Select Country</label><span style="color:#FF0000;">*</span>
						
							<select class="form-control" name="country_id" id="country_id"  size="" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select country" >
							<option value="">Select Country</option>
							<?php 
								$select_query = mysql_query("SELECT * FROM tblcountries where id='230'");
                                while($row = mysql_fetch_assoc($select_query)) { ?>
							
									<option selected="selected" value="<?php echo $row['id'] ?>"><?php echo $row['name']; ?></option>
								 <?php } ?>		
							</select>
						
						</div>
					
						<div class="form-group">
						<label>Select State</label><span style="color:#FF0000;">*</span>
						
							<select class="form-control" name="state_id" id="state_id"  size="" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select state" onchange="getCities(this.value)">
							<option value="">Select State</option>
							<?php 
								$select_query = mysql_query("SELECT * FROM tblstates where country_id='230' ORDER By 'name' ASC");
                                while($row = mysql_fetch_assoc($select_query)) { ?>
							
									<option value="<?php echo $row['id'] ?>"><?php echo $row['name']; ?></option>
								 <?php } ?>		
							</select>
						</div>
						
						<div class="form-group">
							<label>Select City</label><span style="color:#FF0000;">*</span>
							<select class="form-control" id="city_id" name="city_id"  size="" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select city" >
							
								<option value="">Select City</option>
									
							</select>
						</div>
							
							
							<div class="form-group">
							  <label>Postal Code</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="postal_code"  id="postal_code" class="form-control" placeholder="Enter Postal Code" maxlength="8" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter Postal Code" >
							</div> */ ?>
							
							
							<!--<div class="form-group">
								<label for="exampleInputPassword1">Select Device Type</label>
								<select name="device_type" class="form-control"  data-validation-engine="validate[required]" data-errormessage-value-missing="Please select Device Type" style="width: 320px;" >
									<option value="1">Android</option>
									<option value="2">Iphone</option>
								</select>
							</div>-->
							<?php /* ?>
							<div class="form-group">
								<label>Select User Type</label><span style="color:#FF0000;">*</span>
								<select name="customer_type" id="customer_type" class="form-control"  data-validation-engine="validate[required]" data-errormessage-value-missing="Please select User Type" style="width: 320px;" >
									<option value="Job Poster">Job Poster</option>
									<option value="Job Candidate">Job Candidate</option>
								</select>
							</div> <?php */ ?>
							
							<div class="form-group">
							  <label>Status</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" value="1" name="status"  > NOTE:- Please tick this checkbox if you want to display this user </label>
							  
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
function get_val(val)
{
	$('#div_company_name').hide();
	$('#div_reg_no').hide();
	$('#div_reg_vat_no').hide();
	$('#company_name').prop('disabled','disabled');
	$('#registration_no').prop('disabled','disabled');
	$('#vat_registration_no').prop('disabled','disabled');
	if(val==1)
	{
		$('#div_company_name').show();
		$('#div_reg_no').show();
		$('#div_reg_vat_no').show();
		$('#company_name').prop('disabled','');
	    $('#registration_no').prop('disabled','');
	    $('#vat_registration_no').prop('disabled','');
		$('#dob').hide();
		$('#activity_div').hide();
		$('#health_div').hide();
		$('#bio_div').hide();
		$('#experience_div').hide();
		$('#education_credentials_div').hide();
		$('#cscs_card_div').hide();
		$('#gen').hide();
		$('#hg').hide();
		$('#build_div').hide();
		$('#nationality_div').hide();
		$('#lan_div').hide();
		$('#militry_div').hide();
		$('#drive_div').hide();
		$('#firstaid_div').hide();
		$('#tattoos_div').hide();
		$('#piercing_div').hide();
		$('#right_to_work_uk_div').hide();
		$('#willing_to_travel_div').hide();
		$('#uk_driving_license_div').hide();
		$('#sia_div').hide();
	}
	if(val==2)
	{
		
		$('#dob').show();
		$('#activity_div').show();
		$('#health_div').show();
		$('#bio_div').show();
		$('#experience_div').show();
		$('#education_credentials_div').show();
		$('#cscs_card_div').show();
		$('#gen').show();
		$('#hg').show();
		$('#build_div').show();
		$('#nationality_div').show();
		$('#lan_div').show();
		$('#militry_div').show();
		$('#drive_div').show();
		$('#firstaid_div').show();
		$('#tattoos_div').show();
		$('#piercing_div').show();
		$('#right_to_work_uk_div').show();
		$('#willing_to_travel_div').show();
		$('#uk_driving_license_div').show();
		$('#sia_div').show();
	}
	
}

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

/*
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
	
	var extFile  = document.getElementById("profileimage").value;	
	if(extFile!='') {
	var ext = extFile.split('.').pop();
	var filesAllowed = ["jpg", "jpeg", "png"];
	if( (filesAllowed.indexOf(ext)) == -1)
		return "Only JPG , PNG files are allowed";
	}
}
</script>
<script src="js/select2.full.min.js"></script>
<script>
	$(function () {
    //Date picker
		$('#birthdate').datepicker({
			autoclose: true,
			format: 'dd/mm/yyyy'
		});
	});
</script> 