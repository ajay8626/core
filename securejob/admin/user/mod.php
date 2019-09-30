<?php
if(!in_array(3,$tes_mod)) { 
	echo "<div class='grid_12'><div class='message error'><p>You don't have permission to access this page</p></div></div>";
	die;
}

//echo "<pre>";print_r($_SESSION['user_id']);exit;

$a_id   = 	$_POST['id'];
require_once(ADMIN_PATH."inc/img_upload.php");
include_once(ADMIN_PATH."inc/functions.php");
include_once(ADMIN_PATH."inc/resize-class.php");
// Get data from db for modification 
	$a_id = $_REQUEST["id"];
	$sql = "select * from tbluser where user_id = {$a_id}"; 
	$result = $db->Query($sql);
	$a_name = "";
	//list($a_id,$email,$password,$firstname,$lastname,$phone,$user_type,$address_1,$address_2,$address_3,$city_id,$state_id,$country_id,$postal_code,$profile_image,$profile_video,$devicetype,$status,$created_date,$modified_date,$customer_type,$bank_name,$acc_holder_name,$sort_code,$acc_number,$reg_no,$reg_vat_no,$company_name,$birthdate,$gender,$height,$build,$nationality,$language,$militry,$drive,$firstaid,$tattoos,$sia,$activity,$health,$bio,$experience) = mysql_fetch_row($result);		
	//$db->Free($result);
	$isActiveChecked = "";
    
    //$rows = mysql_fetch_row($result);
    $rows=mysql_fetch_array($result);
    $a_id = $rows['user_id'];
    $email = $rows['email'];
    $password = $rows['password'];
    $firstname = $rows['firstname'];
    $lastname = $rows['lastname'];
    $phone = $rows['phone'];
    $user_type = $rows['user_type'];
    $address_1 = $rows['address_1'];
    $address_2 = $rows['address_2'];
    $address_3 = $rows['address_3'];
    $city_id = $rows['city_id'];
    $state_id = $rows['state_id'];
    $country_id = $rows['country_id'];
    $postal_code = $rows['postal_code'];
    $profile_image = $rows['profile_image'];
    $profile_video = $rows['profile_video'];
    $devicetype = $rows['devicetype'];
    $status = $rows['status'];
    $verifiedUser = $rows['verified_user'];
    $created_date = $rows['created_date'];
    $modified_date = $rows['modified_date'];
    $customer_type = $rows['customer_type'];
    $bank_name = $rows['bank_name'];
    $acc_holder_name = $rows['acc_holder_name'];
    $sort_code = $rows['sort_code'];
    $acc_number = $rows['acc_number'];
    $reg_no = $rows['reg_no'];
    $reg_vat_no = $rows['reg_vat_no'];
    $company_name = $rows['company_name'];
    $birthdate = $rows['birthdate'];
    $gender = $rows['gender'];
    $height = $rows['height'];
    $build = $rows['build'];
    $nationality = $rows['nationality'];
    $language = $rows['language'];
    $militry = $rows['militry'];
    $drive = $rows['drive'];
    $firstaid = $rows['firstaid'];
    $tattoos = $rows['tattoos'];
    $piercing = $rows['piercing'];
    $right_to_work_uk = $rows['right_to_work_uk'];
    $willing_to_travel = $rows['willing_to_travel'];
    $uk_driving_license = $rows['uk_driving_license'];
    $cscs_card = $rows['cscs_card'];
    $sia = $rows['sia'];
    $activity = $rows['activity'];
    $health = $rows['health'];
    $bio = $rows['bio'];
    $experience = $rows['experience'];
    $education_credentials = $rows['education_credentials'];
    
	if($status == 1){ 
		$isActiveChecked = "checked=checked"; 
    }
    
    if($verifiedUser == 1){ 
		$isVerifiedUser = "checked=checked"; 
	}


	$sql_badge_type="select * from tbl_siabadge_type  where user_id={$a_id}";
    
    $exc_badge_type=$db->Query($sql_badge_type);
    while($rows_badge_type=mysql_fetch_array($exc_badge_type)){
        $badge_type[]=$rows_badge_type['badge_type'];
    }
?>
<script type="text/javascript" src="js/jquery.fancybox.js"></script>
<link href="css/jquery.fancybox.css" type="text/css" rel="stylesheet" />

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
						  <h3 class="box-title">Modify User</h3>
						</div>
						<div class="error"></div>
						<!-- /.box-header -->
						<!-- form start -->
						<form role="form" class="validateForm" name="Admin" action="main.php?pg=userproc" method="post" enctype="multipart/form-data" >
						<input type="hidden" value="mod" name="act">
					    <input type="hidden" value="<?php echo $a_id;?>" name="id">
						  <div class="box-body">
							<div class="form-group">
								<label>Are you business or personal user?</label><span style="color:#FF0000;">*</span>
								<select name="user_type" id="user_type" class="form-control"  data-validation-engine="validate[required]" data-errormessage-value-missing="Please select user type" style="width: 320px;" disabled="disabled" >
									<option value="">Select User Type</option>
									<option value="1" <?php if($customer_type==1){ echo 'selected="selected"'; } ?>>Business User</option>
									<option value="2" <?php if($customer_type==2){ echo 'selected="selected"'; } ?>>Personal User</option>
								</select>
							</div>
							
							<?php 
							if($profile_image!=''){
							?>
								<div class="form-group">
									<label for="exampleInputEmail1">Image</label>
									<a href="<?php echo SITE_URL.'admin/user/profilepictures/'.$profile_image; ?>" class="enLarge" ><img src="<?php echo SITE_URL.'admin/user/profilepictures/'.$profile_image; ?>"  height='64' width='64'/></a><br/>
									
									<input type="checkbox" name ="rmavatar" value='1' /> <input type="hidden" name="rmimage" value="<?php echo SITE_URL.'admin/user/profilepictures/'.$profile_image; ?>" /> Remove Profile Image 
								</div>
								
							<?php } ?>
						  
							
							<div class="form-group">
							  <label for="exampleInputEmail1">Profile Picture</label>
							  <input type="file" 
							  <?php if($profile_image==''){ ?> data-validation-engine="validate[required]" 
							  data-errormessage-value-missing="Only JPG and PNG are allowed" <?php } ?>
							  name="profileimage" id="profileimage" class="form-control input3 mini" >
							  <span style="font-size:12px;font-weight:normal;">Recommended size is 780(height) X 780(width). </span>
							</div>
							<?php 
							$sty='style="display:none;"';
							if($customer_type==1)
							{ 
						      $sty='';  
						    } 
						    ?>
							<div class="form-group" id="div_company_name" <?=$sty?>>
							  <label>Company Name</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="company_name" id="company_name" value="<?php echo $company_name;?>" class="form-control input3 mini" placeholder="Enter Company Name" maxlength="50" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter your company name" >
							</div>
							<div class="form-group">
							  <label for="exampleInputEmail1">First Name</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="fname" id="fname"  value="<?php echo $firstname;?>" class="form-control input3 mini" id="exampleInputEmail1" placeholder="Enter First Name" data-validation-engine="validate[required]" maxlength="50" data-errormessage-value-missing="Please enter your first name" >
							</div>
							<div class="form-group">
							  <label for="exampleInputEmail1">Last Name</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="lname" id="lname"  value="<?php echo $lastname;?>" class="form-control" id="exampleInputEmail1" placeholder="Enter Last Name" data-validation-engine="validate[required]" maxlength="50" data-errormessage-value-missing="Please enter your last name"  >
							</div>
							<div class="form-group">
							  <label for="exampleInputEmail1">Email Address</label><span style="color:#FF0000;">*</span>
							  <input type="email" name="email" id="email" class="form-control" id="exampleInputEmail1" value="<?php echo $email;?>"  placeholder="Enter email" data-validation-engine="validate[required,custom[email]]" maxlength="70"  data-errormessage-value-missing="The e-mail address you entered appears to be incorrect." 
						data-errormessage-custom-error="Example: yourscreenname@aol.com" >
							</div>
							<div class="form-group">
							  <label for="exampleInputPassword1">Password</label><span style="color:#FF0000;">*</span>
							  <input type="password" name="password" id="password" class="form-control" id="exampleInputPassword1" placeholder="Password" maxlength="12" >
							</div>
							<!-- <div class="form-group">
							  <label for="exampleInputPassword1">Confirm Password</label><span style="color:#FF0000;">*</span>
							  <input type="password" name="rpassword" id="rpassword" class="form-control" id="exampleInputPassword1" placeholder="Confirm Password"  maxlength="12" data-validation-engine="validate[equals[password]]" data-errormessage-value-missing="Please enter confirm password" data-errormessage-custom-error="The two passwords you entered did not match each other. Please try again.">
							</div> -->
							
							<div class="form-group">
							  <label for="exampleInputPassword1">Phone</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="phone"  id="mobile" class="form-control" id="exampleInputPassword1" placeholder="Enter Phone" maxlength="11" data-validation-engine="validate[required,phone]"	 value="<?php echo $phone;?>"	data-errormessage-value-missing="Please enter your phone number" >
							</div>
							
							<div class="form-group" id="div_reg_no" <?=$sty?>>
							  <label>Registration No</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="registration_no"  id="registration_no" value="<?php echo $reg_no;?>" class="form-control" id="exampleInputAddress1" placeholder="Enter Registration No" maxlength="250" data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter registration no" >
							</div>
							
							<div class="form-group" id="div_reg_vat_no" <?=$sty?>>
							  <label>VAT Registration No</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="vat_registration_no"  id="vat_registration_no" value="<?php echo $reg_vat_no;?>" class="form-control" placeholder="Enter Registration No" maxlength="250" data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter vat registration no" >
							</div>
							
							<div class="form-group">
							  <label for="exampleInputPassword1">Address Line 1</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="address_1" id="autocomplete" value="<?php echo $address_1;?>" id="address_1" class="form-control" id="exampleInputAddress1" placeholder="Enter Address Line 1" maxlength="250" data-validation-engine="validate[required]"	data-errormessage-value-missing="Please enter address line 1" >
							</div>
							<div class="form-group">
							  <label for="exampleInputPassword1">Address Line 2</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="address_2" value="<?php echo $address_2;?>"  id="address_2" class="form-control" id="exampleInputAddress2" placeholder="Enter Address Line 2" maxlength="250" data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter address line 2" >
							</div>
							<div class="form-group">
							  <label>Address Line 3</label>
							  <input type="text" name="address_3"  id="address_3" class="form-control" placeholder="Enter Address 3" maxlength="250" value="<?php echo $address_3; ?>" >
							</div>
                            <div class="form-group">
							  <label>Postal Code</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="postal_code"  id="postal_code" class="form-control" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter postal code" placeholder="Enter Postal Code" maxlength="15" value="<?php echo $postal_code; ?>" >
							</div>
							<div class="form-group" >
						<label>Select Country</label><span style="color:#FF0000;">*</span>
						
							<select class="form-control" name="state_id" id="state_id"  size="" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select state" onchange="getCities(this.value)">
							<option value="">Select Country</option>
							<?php 
								$select_query = mysql_query("SELECT * FROM tblstates where country_id='230' ORDER By 'name' ASC");
                                while($row = mysql_fetch_assoc($select_query)) { ?>
							
									<option value="<?php echo $row['id'] ?>" <?php if($row['id']==$state_id){ ?> selected="selected" <?php } ?>><?php echo $row['name']; ?></option>
								 <?php } ?>		
							</select>
						</div>
						<div class="form-group">
							<label>Select City</label>
							<select class="form-control" id="city_id" name="city_id"  size="" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select city name" >
							
								<option value="">Select City</option>
									
							</select>
						</div>
						
						<?php /* <div class="form-group">
							<label>Select City</label><span style="color:#FF0000;">*</span>
							<select class="form-control" id="city_id" name="city_id"  size="" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select city" >
							
								<option value="">Select City</option>
								<?php 
								$select_query = mysql_query("SELECT * FROM tblcities  ORDER By 'name' ASC");
                                while($row = mysql_fetch_assoc($select_query)) { ?>
							
							<option value="<?php echo $row['id'] ?>" <?php if($row['id']==$city_id){ ?> selected="selected" <?php } ?>><?php echo $row['name']; ?></option>
								 <?php } ?>	
									
							</select>
						</div> <?php */ ?>
						    
							<?php /* ?>
							<div class="form-group">
							  <label>Bank Name</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="bank_name"  id="bank_name" value="<?php echo $bank_name;?>" class="form-control" placeholder="Enter Bank Name" maxlength="250" data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter bank name">
							</div>
							
							<div class="form-group">
							  <label>Account Holders Name</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="acc_holder_name"  id="acc_holder_name" value="<?php echo $acc_holder_name;?>" class="form-control" placeholder="Enter Account Holders Name" maxlength="250" data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter account holders name">
							</div>
							
							<div class="form-group">
							  <label>Sort Code</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="sort_code"  id="sort_code" value="<?php echo $sort_code;?>" class="form-control" placeholder="Enter Sort Code" maxlength="250" data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter sort code">
							</div>
							
							<div class="form-group">
							  <label>Account Number</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="acc_number"  id="acc_number" value="<?php echo $acc_number;?>" class="form-control" placeholder="Enter Account Number" maxlength="250" data-validation-engine="validate[required]"data-errormessage-value-missing="Please enter account number">
							</div>
							<?php */ ?>
							<?php if($customer_type==2){ ?>
							<?php
							$date = '';
							if($birthdate != '' && $birthdate != '1970-01-01')
							{
								$date = date('d/m/Y',strtotime($birthdate));
							}
							?>
							<div class="form-group" id="dob">
							<label>Date of Birth</label>
							<input class="form-control" id="birthdate"  maxlength='50' name="birthdate" value="<?php echo $date; ?>"  />
			                </div>
							<?php } ?>
							<div class="form-group">
							  <label>Upload Profile Video</label>
							  <input type="file" name="profilevideo" id="profilevideo" class="form-control input3 mini"  >
							<?php if($profile_video!=''){ ?>
                            <a href="<?php echo CUSTOMER_PROFILE_VIDEO_URL.$profile_video ?>" target="_blank">Profile Video</a>
							<br>
							<input type="checkbox" name ="rmavatarvideo" value='1' /> <input type="hidden" name="rmvideo" value="<?php echo $profile_video; ?>" /> Remove Profile Video 
							
							<?php } ?>							
							</div>
							<?php if($customer_type==2){ ?>
							<div class="form-group" id="gen">
							<label>Gender</label><span style="color:#FF0000;">*</span><br>
							<input type="radio" name="gender" <?php if($gender==1){ ?> checked <?php } ?>  id="male" value="1">&nbsp;Male&nbsp;
							<input type="radio" name="gender" <?php if($gender==2){ ?> checked <?php } ?> id="female"  value="2">&nbsp;Female
			                </div>
							<div class="form-group" id="hg">
							  <label>Height</label><span style="color:#FF0000;">*</span>
							  <input type="text" name="height"  id="height" class="form-control" value="<?php echo $height; ?>"  maxlength="10" style="width: 200px;" size="10">
							</div>
							<div class="form-group" id="build_div">
								<label>Build</label><span style="color:#FF0000;">*</span>
								<select name="build" id="build" class="form-control"   style="width: 200px;">
									<option value="">Select Build</option>
									
									<?php 
								$select_query = mysql_query("SELECT * FROM tblbuild where status=1 ORDER By 'name' ASC"); 
								 while($row = mysql_fetch_assoc($select_query)) {
								?>
									<option value="<?php echo $row['name']; ?>" <?php if($build==$row['name']){ ?> selected <?php } ?>><?php echo $row['name']; ?></option>
									<?php } ?>	
								</select>
							</div>
							<div class="form-group" id="nationality_div">
								<label>Nationality</label><span style="color:#FF0000;">*</span>
								<select name="nationality" id="nationality" class="form-control"   style="width: 200px;">
									<option value="">Select Nationality</option>
									
									<?php 
								$select_query = mysql_query("SELECT * FROM tblnationality where status=1 ORDER By 'name' ASC"); 
								 while($row = mysql_fetch_assoc($select_query)) {
								?>
									<option value="<?php echo $row['name']; ?>" <?php if($nationality==$row['name']){ ?> selected <?php } ?>><?php echo $row['name']; ?></option>
									<?php } ?>
								</select>
							</div>
							<?php
							
							$lang=array();
							if($language!='')
							{
								$lang=explode(",",$language);
							}
							?>
							<div class="form-group" id="lan_div">
								<label>Languages Spoken</label><span style="color:#FF0000;">*</span>
								<br>
								<?php 
								$select_query = mysql_query("SELECT * FROM 	tbllanguage where status=1 ORDER By 'name' ASC"); 
								 while($row = mysql_fetch_assoc($select_query)) {
								?>
								<input type="checkbox" name="language[]"  <?php if(in_array($row['name'],$lang)){ ?> checked <?php } ?> value="<?php echo $row['name']; ?>">&nbsp;<?php echo $row['name']; ?>
								 <?php } ?>
								<!--<input type="checkbox" name="language[]" <?php if(in_array("english",$lang)){ ?> checked <?php } ?> value="english">&nbsp;English
								<input type="checkbox" name="language[]" <?php if(in_array("polish",$lang)){ ?> checked <?php } ?> value="polish">&nbsp;Polish
								<input type="checkbox" name="language[]" <?php if(in_array("wellish",$lang)){ ?> checked <?php } ?> value="wellish">&nbsp;Wellish
								<input type="checkbox" name="language[]" <?php if(in_array("french",$lang)){ ?> checked <?php } ?> value="french">&nbsp;French-->
							</div>
							<div class="form-group" id='militry_div'>
							<label>Military Background</label><span style="color:#FF0000;">*</span><br>
							<input type="radio" name="militry" <?php if($militry==1){ ?> checked <?php } ?>   value="1">&nbsp;Yes&nbsp;
							<input type="radio" name="militry" <?php if($militry==2){ ?> checked <?php } ?>   value="2">&nbsp;No
			                </div>
							<div class="form-group" id="drive_div">
							<label>Do you drive?</label><span style="color:#FF0000;">*</span><br>
							<input type="radio" name="drive" <?php if($drive==1){ ?> checked <?php } ?>   value="1">&nbsp;Yes&nbsp;
							<input type="radio" name="drive" <?php if($drive==2){ ?> checked <?php } ?>  value="2">&nbsp;No
			                </div>
							<div class="form-group" id="firstaid_div">
							<label>First aid & Paramedic training?</label><span style="color:#FF0000;">*</span><br>
							<input type="radio" name="firstaid" <?php if($firstaid==1){ ?> checked <?php } ?>   value="1">&nbsp;Yes&nbsp;
							<input type="radio" name="firstaid" <?php if($firstaid==2){ ?> checked <?php } ?>   value="2">&nbsp;No
			                </div>
                            
							<div class="form-group" id="tattoos_div">
							<label>Visible Tattoos?</label><span style="color:#FF0000;">*</span><br>
							<input type="radio" name="tattoos" <?php if($tattoos==1){ ?> checked <?php } ?>   value="1">&nbsp;Yes&nbsp;
							<input type="radio" name="tattoos" <?php if($tattoos==2){ ?> checked <?php } ?>  value="2">&nbsp;No
			                </div>
                            <div class="form-group" id="piercing_div">
							<label>Visible Piercings?</label><span style="color:#FF0000;">*</span><br>
							<input type="radio" name="piercing" <?php if($piercing==1){ ?> checked <?php } ?>   value="1">&nbsp;Yes&nbsp;
							<input type="radio" name="piercing" <?php if($piercing==2){ ?> checked <?php } ?>  value="2">&nbsp;No
			                </div>
                            
                            <div class="form-group" id="right_to_work_uk_div">
							<label>Do you have right to work in UK?</label><span style="color:#FF0000;">*</span><br>
							<input type="radio" name="right_to_work_uk" <?php if($right_to_work_uk==1){ ?> checked <?php } ?>   value="1">&nbsp;Yes&nbsp;
							<input type="radio" name="right_to_work_uk" <?php if($right_to_work_uk==2){ ?> checked <?php } ?>  value="2">&nbsp;No
			                </div>
                            
                            <div class="form-group" id="willing_to_travel_div">
							<label>Willing to travel abroad?</label><br>
							<input type="radio" name="willing_to_travel" <?php if($willing_to_travel==1){ ?> checked <?php } ?>   value="1">&nbsp;Yes&nbsp;
							<input type="radio" name="willing_to_travel" <?php if($willing_to_travel==2){ ?> checked <?php } ?>  value="2">&nbsp;No
			                </div>
                            
                            <div class="form-group" id="uk_driving_license_div">
							<label>Do you hold full UK Driving License?</label><span style="color:#FF0000;">*</span><br>
							<input type="radio" name="uk_driving_license" <?php if($uk_driving_license==1){ ?> checked <?php } ?>   value="1">&nbsp;Yes&nbsp;
							<input type="radio" name="uk_driving_license" <?php if($uk_driving_license==2){ ?> checked <?php } ?>  value="2">&nbsp;No
			                </div>
                            
                            <div class="form-group" id="cscs_card_div">
							<label>Do you have CSCS card?</label><br>
							<input type="radio" name="cscs_card" <?php if($cscs_card==1){ ?> checked <?php } ?>   value="1">&nbsp;Yes&nbsp;
							<input type="radio" name="cscs_card" <?php if($cscs_card==2){ ?> checked <?php } ?>  value="2">&nbsp;No
			                </div>

			                <?php $badges=array('Cash and Valuables in Transit (CVIT)','Close Protection (CP)','Door Supervision (DS)','Public Space Surveillance (CCTV)','Security Guarding (SG)','Vehicle Immobilisation (VI)','Key Holding (KH)');?>
                            
							<div class="form-group" id="sia_div">
							<!-- <label>SIA Badge?</label><span style="color:#FF0000;">*</span><br> -->
							<!-- <input type="radio" name="sia" <?php if($sia==1){ ?> checked <?php } ?>   value="1">&nbsp;Yes&nbsp;
							<input type="radio" name="sia" <?php if($sia==2){ ?> checked <?php } ?>   value="2">&nbsp;No -->

							<label>SIA Badge Type</label><span style="color:#FF0000;">*</span><br>
							<?php foreach($badges as $badge){ ?>
							    <label><input type="checkbox" name="sia[]" <?php if(in_array($badge,$badge_type)){ ?> checked="checked" <?php } ?> value="<?php echo $badge;?>"> <?php echo $badge;?> </label>
                            <?php } ?>
			                </div>
							<div class="form-group" id="activity_div">
								<label>Any Ailments that could impair activity to work? </label>
								<textarea class="form-control" style='min-height:100px;'   name="activity" ><?php echo $activity; ?></textarea>
							</div>
							<div class="form-group" id="health_div">
								<label>Any Health Issues?</label>
								<textarea class="form-control" style='min-height:100px;'   name="health" ><?php echo $health; ?></textarea>
							</div>
							<div class="form-group" id="bio_div">
								<label>Bio</label>
								<textarea class="form-control" style='min-height:100px;'   name="bio" ><?php echo $bio; ?></textarea>
							</div>
                            <div class="form-group" id="experience_div">
								<label>Experience</label>
								<textarea class="form-control" style='min-height:100px;'   name="experience" ><?php echo $experience; ?></textarea>
							</div>
                            <div class="form-group" id="education_credentials_div">
								<label>Education and Further Credentials</label>
								<textarea class="form-control" style='min-height:100px;'   name="education_credentials" ><?php echo $education_credentials; ?></textarea>
							</div>
							<?php } ?>
							<?php /*
							<div class="form-group">
						<label>Select Country</label>
						
							<select class="form-control" name="country_id"  size="" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select country name" >
							
							<?php 
								$select_query = mysql_query("SELECT * FROM tblcountries where id='230'");
                                while($row = mysql_fetch_assoc($select_query)) { ?>
							
									<option selected="selected" value="<?php echo $row['id'] ?>"><?php echo $row['name']; ?></option>
								 <?php } ?>		
							</select>
						
						</div>
						
						<div class="form-group">
						<label>Select State</label>
						
							<select class="form-control" name="state_id" id="state_id"  size="" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select state name"  onchange="getCities(this.value)">
							
							<?php 
								$select_query = mysql_query("SELECT * FROM tblstates where country_id='230'");
                                while($row = mysql_fetch_assoc($select_query)) { ?>
							
									<option <?php if($state_id== $row['id']){ ?>selected="selected" <?php } ?> value="<?php echo $row['id'] ?>"><?php echo $row['name']; ?></option>
								 <?php } ?>		
							</select>
						
						</div>
						
						<div class="form-group">
							<label>Select City</label>
							<select class="form-control" id="city_id" name="city_id"  size="" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select city name" >
							
								<option value="">Select City</option>
									
							</select>
						</div>
							
							<div class="form-group">
							  <label for="exampleInputPassword1">Postal Code</label>
							  <input type="text" name="postal_code" value="<?php echo $postal_code;?>" id="postal_code" class="form-control" id="exampleInputPostalCode" placeholder="Enter Postal Code" maxlength="8" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter Postal Code" >
							</div> */ ?>
							<!--<div class="form-group">
								<label for="exampleInputPassword1">Select Device Type</label>
								<select name="device_type" class="form-control"  data-validation-engine="validate[required]" data-errormessage-value-missing="Please select Device Type" style="width: 320px;" >
									<option  <?php if($devicetype == 1){ echo "Selected"; } ?> value="1">Android</option>
									<option  <?php if($devicetype == 2){ echo "Selected"; } ?> value="2">Iphone</option>
								</select>
							</div>-->
							<?php /* 
							<div class="form-group">
								<label for="exampleCustomertype">Select Customer Type</label>
								<select name="customer_type" class="form-control"  data-validation-engine="validate[required]" data-errormessage-value-missing="Please select Customer Type" style="width: 320px;" >
									<option <?php if($user_type == 'Job Poster'){ echo "Selected"; } ?> value="Job Poster">Job Poster</option>
									<option <?php if($user_type == 'Job Candidate'){ echo "Selected"; } ?> value="Job Candidate">Job Candidate</option>
								</select>
							</div> */ ?>

                            <!-- Users Docmuments Start -->
                            <div class="form-group">
							    <h3>User Documents</h3>
							</div>
                            
                            <!-- Sia Badge Start -->
                            <?php 
                                if($customer_type==2){
                                $userSiaBadge=mysql_query("select * from tbl_user_siabadge where user_id=".$a_id."");
                                $siaBadgeCount=mysql_num_rows($userSiaBadge);
                                if ($siaBadgeCount > 0) { 
                                ?>
                                <div class="form-group">
                                    <label>Sia Badge</label>
                                </div>
                                <?php
                                    while($userSiaBadgeRow = mysql_fetch_assoc($userSiaBadge)) {
                                        $siaBadgeId = $userSiaBadgeRow['id'];
                                        $siaBadgeName = $userSiaBadgeRow['siabadge'];
                                        $siaBadgeUserId = $userSiaBadgeRow['user_id'];
                                        $siaBadgeMime = $userSiaBadgeRow['siabadge_mime'];
                                        $siaBadgeVerified = $userSiaBadgeRow['verified'];

                                        if($userSiaBadgeRow['siabadge'] != ""){
                                ?>
                                
                                <?php if($siaBadgeMime != 'pdf'){ ?>
                                    <div class="form-group">
                                        <span id="siaBadgeId">
                                            <a class="fancybox" rel="group" href="<?php echo CUSTOMER_SIABADGE_IMG_URL.$siaBadgeName; ?>">
                                                <img src="<?php echo CUSTOMER_SIABADGE_IMG_URL.$siaBadgeName; ?>" style="width:100px;" alt="">
                                            </a>
                                        </span>
                                    </div>
                                <?php }else{ ?>
                                    <div class="form-group">
                                        <span id="siaBadgeId">
                                            <a class="fancybox_pdf" rel="group" href="<?php echo CUSTOMER_SIABADGE_IMG_URL.$siaBadgeName; ?>">
                                                <img src="<?php echo SITE_URL; ?>/images/pdf_image.png" style="width:100px;" alt="">
                                            </a>
                                        </span>
                                    </div>
                                <?php } } } } } ?>
                                <!-- Sia Badge End -->

                                <!-- Company Certificate Start -->
                                <?php 
                                if($customer_type==1){
								$userCompanyCertiCount=0;
                                $userCompanyCerti=mysql_query("select * from tbl_user_comp_certi where user_id=".$a_id."");
                                $userCompanyCertiCount=mysql_num_rows($userCompanyCerti);
                                if ($userCompanyCertiCount > 0) { 
                                ?>
                                <div class="form-group">
                                    <label>Company Certificates</label>
                                </div>
                                <?php
                                    while($userCompanyCertiRow = mysql_fetch_assoc($userCompanyCerti)) {
                                        $companyCertiId = $userCompanyCertiRow['id'];
                                        $companyCertiName = $userCompanyCertiRow['comp_certi'];
                                        $companyCertiUserId = $userCompanyCertiRow['user_id'];
                                        $companyCertiMime = $userCompanyCertiRow['comp_certi_mime'];
                                        $companyCertiVerify = $userCompanyCertiRow['verified'];

                                        if($userCompanyCertiRow['comp_certi'] != ""){
                                ?>
                                
                                <?php if($companyCertiMime != 'pdf'){ ?>
                                    <div class="form-group">
                                        <span id="companyCertiId">
                                            <a class="fancybox" rel="group" href="<?php echo CUSTOMER_COMPANYCERTI_IMG_URL.$companyCertiName; ?>">
												<img src="<?php echo CUSTOMER_COMPANYCERTI_IMG_URL.$companyCertiName; ?>" style="width:100px;" alt="">
											</a>
                                        </span>
                                    </div>
                                <?php }else{ ?>
                                    <div class="form-group">
                                        <span id="companyCertiId">
                                            <a class="fancybox_pdf" rel="group" href="<?php echo CUSTOMER_COMPANYCERTI_IMG_URL.$companyCertiName; ?>">
												<img src="<?php echo SITE_URL; ?>/images/pdf_image.png" style="width:100px;" alt="">
											</a>
                                        </span>
                                    </div>
                                <?php } } } } } ?>
                                <!-- Company Certificate End -->

                                <!-- License/Passport Start -->
                                <?php 
                                $userLicense=mysql_query("select * from tbl_user_license_passport where user_id=".$a_id."");
                                $licenseCount=mysql_num_rows($userLicense);
                                if ($licenseCount > 0) { 
                                ?>
                                <div class="form-group">
                                    <label>Passport / Driving License</label>
                                </div>
                                <?php
                                    while($userLicenseRow = mysql_fetch_assoc($userLicense)) {
                                        $licenseId = $userLicenseRow['id'];
                                        $licenseName = $userLicenseRow['license_passport'];
                                        $licenseUserId = $userLicenseRow['user_id'];
                                        $licenseMime = $userLicenseRow['license_passport_mime'];
                                        $licenseVerify = $userLicenseRow['verified'];

                                        if($userLicenseRow['license_passport'] != ""){
                                ?>
                                
                                <?php if($licenseMime != 'pdf'){ ?>
                                    <div class="form-group">
                                        <span id="licenseId">
                                            <a class="fancybox" rel="group" href="<?php echo CUSTOMER_LICENSEPASSPORT_IMG_URL.$licenseName; ?>">
												<img src="<?php echo CUSTOMER_LICENSEPASSPORT_IMG_URL.$licenseName; ?>" style="width:100px;" alt="">
											</a>
                                        </span>
                                    </div>
                                <?php }else{ ?>
                                    <div class="form-group">
                                        <span id="licenseId">
                                            <a class="fancybox_pdf" rel="group" href="<?php echo CUSTOMER_LICENSEPASSPORT_IMG_URL.$licenseName; ?>">
												<img src="<?php echo SITE_URL; ?>/images/pdf_image.png" style="width:100px;" alt="">
											</a>
                                        </span>
                                    </div>
                                <?php } } } } ?>
                                <!-- License/Passport End -->

                                <!-- Utility Bills Start -->
								<?php 
								if($customer_type==2){
                                $userUtilityCount=0;
                                $userUtility=mysql_query("select * from tbl_user_utility where user_id=".$a_id."");
                                $userUtilityCount=mysql_num_rows($userUtility);
                                if ($userUtilityCount > 0) { 
                                ?>
                                <div class="form-group">
                                    <label>Utility Bill or Statement less than 3 months old with current address</label>
                                </div>
                                <?php
                                    while($userUtilityRow = mysql_fetch_assoc($userUtility)) {
                                        $utilityId = $userUtilityRow['id'];
                                        $utilityName = $userUtilityRow['utility'];
                                        $utilityUserId = $userUtilityRow['user_id'];
                                        $utilityMime = $userUtilityRow['utility_mime'];
                                        $utilityVerify = $userUtilityRow['verified'];

                                        if($userUtilityRow['utility'] != ""){
                                ?>
                                
                                <?php if($utilityMime != 'pdf'){ ?>
                                    <div class="form-group">
                                        <span id="utilityId">
                                            <a class="fancybox" rel="group" href="<?php echo CUSTOMER_UTILITY_IMG_URL.$utilityName; ?>">
												<img src="<?php echo CUSTOMER_UTILITY_IMG_URL.$utilityName; ?>" style="width:100px;" alt="">
											</a>
                                        </span>
                                    </div>
                                <?php }else{ ?>
                                    <div class="form-group">
                                        <span id="utilityId">
                                            <a class="fancybox_pdf" rel="group" href="<?php echo CUSTOMER_UTILITY_IMG_URL.$utilityName; ?>">
												<img src="<?php echo SITE_URL; ?>/images/pdf_image.png" style="width:100px;" alt="">
											</a>
                                        </span>
                                    </div>
                                <?php } } } } } ?>
                                <!-- Utility Bills End -->

                            <!-- Users Docmuments End -->
                            

                            <div class="form-group">
							    <label>Verify User</label>
							</div>
							<div class="checkbox">
								<label for="verifiedUser"><input id="verifiedUser" type="checkbox" value="1" name="verifiedUser" <?php echo $isVerifiedUser;?> > NOTE:- Please tick this checkbox if you would like to verfiy the user.</label>
							</div>
							
							<div class="form-group">
							  <label for="exampleInputPassword1">Status</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" value="1" name="status" <?php echo $isActiveChecked;?> > NOTE:- Please tick this checkbox if you want to display this user</label>
							  
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
	getCities(<?php echo $state_id; ?>);
	/* 
	$( document ).ready(function() {
		$('#state_id').on('change',function(){
			//$("#loader").show();
			val = $( "#state_id option:selected" ).val();
			//alert(<?php echo $city_id; ?>);
			$.ajax({
			type: "POST",
			url: "<?php echo ADMIN_URL ?>phpajax/get_city.php",
			data:'state_id='+val+'&city_id=<?php echo $city_id; ?>',
			success: function(data){
				//$("#loader").hide();
					$("#city_id").html(data);	
				}
			});
		});
	}); */
	
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
	
		var extFile  = document.getElementById("profileimage").value;
		var ext = extFile.split('.').pop();
		var filesAllowed = ["jpg", "jpeg", "png"];
		if( (filesAllowed.indexOf(ext)) == -1)
			return "Only JPG , PNG files are allowed";
	}
	
	$(document).ready(function() {
		$(".enLarge").fancybox();
	});
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

<script>
/* Verify Sia Badge */
function verifySiaBadge(userId,certiId,flag)
{
    var userId = userId;
    var certiId = certiId;
    var flag = flag;
    var confirm2Remove = confirm("Are you sure you want to mark selected document as verified document?");

    if(confirm2Remove == true){
        $.ajax({
            url:'user/ajax/verify_siabadge.php?userId='+userId+'&certiId='+certiId+'&flag='+flag,
            type:'get',
            //data: { userId : userId, certiId : certiId }
            beforeSend: function(){
                
            },
            success:function(response){
                if(response != 0 && flag == 1){
                    alert('Successfully Verified!');
                    $('#siaBadgeId').load(' #siaBadgeId');
                }else if(response != 0 && flag == 0){
                    alert('Successfully Unverified!');
                    $('#siaBadgeId').load(' #siaBadgeId');
                }else{
                    alert('Something went wrong. Please try again.');
                }
            }
        });
    }else{
        return false;
    }
}

/* Verify License/Passport */
function verifyLicense(userId,certiId,flag)
{
    var userId = userId;
    var certiId = certiId;
    var flag = flag;
    var confirm2Remove = confirm("Are you sure you want to mark selected document as verified document?");

    if(confirm2Remove == true){
        $.ajax({
            url:'user/ajax/verify_license.php?userId='+userId+'&certiId='+certiId+'&flag='+flag,
            type:'get',
            //data: { userId : userId, certiId : certiId }
            beforeSend: function(){
                
            },
            success:function(response){
                if(response != 0 && flag == 1){
                    alert('Successfully Verified!');
                    $('#licenseId').load(' #licenseId');
                }else if(response != 0 && flag == 0){
                    alert('Successfully Unverified!');
                    $('#licenseId').load(' #licenseId');
                }else{
                    alert('Something went wrong. Please try again.');
                }
            }
        });
    }else{
        return false;
    }
}

/* Verify Utility Bills */
function verifyUtility(userId,certiId,flag)
{
    var userId = userId;
    var certiId = certiId;
    var flag = flag;
    var confirm2Remove = confirm("Are you sure you want to mark selected document as verified document?");

    if(confirm2Remove == true){
        $.ajax({
            url:'user/ajax/verify_utility.php?userId='+userId+'&certiId='+certiId+'&flag='+flag,
            type:'get',
            //data: { userId : userId, certiId : certiId }
            beforeSend: function(){
                
            },
            success:function(response){
                if(response != 0 && flag == 1){
                    alert('Successfully Verified!');
                    $('#utilityId').load(' #utilityId');
                }else if(response != 0 && flag == 0){
                    alert('Successfully Unverified!');
                    $('#utilityId').load(' #utilityId');
                }else{
                    alert('Something went wrong. Please try again.');
                }
            }
        });
    }else{
        return false;
    }
}

/* Verify Company Certificates */
function verifyCompanyCerti(userId,certiId,flag)
{
    var userId = userId;
    var certiId = certiId;
    var flag = flag;
    var confirm2Remove = confirm("Are you sure you want to mark selected document as verified document?");

    if(confirm2Remove == true){
        $.ajax({
            url:'user/ajax/verify_company_certi.php?userId='+userId+'&certiId='+certiId+'&flag='+flag,
            type:'get',
            //data: { userId : userId, certiId : certiId }
            beforeSend: function(){
                
            },
            success:function(response){
                if(response != 0 && flag == 1){
                    alert('Successfully Verified!');
                    $('#companyCertiId').load(' #companyCertiId');
                }else if(response != 0 && flag == 0){
                    alert('Successfully Unverified!');
                    $('#companyCertiId').load(' #companyCertiId');
                }else{
                    alert('Something went wrong. Please try again.');
                }
            }
        });
    }else{
        return false;
    }
}
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