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
	$sql = "select * from tbljobs where job_id = {$a_id}"; 
	$result = $db->Query($sql);
	$a_name = "";
	list($job_id,$job_user_id,$job_name,$job_description,$price,$image,$job_days,$job_hours,$start_date,$latitude,$longitude,$address1,$address2,$postalcode,$country_id,$state_id,$city_id,$riskmeter,$transport_link,$dresscode,$created_date,$isfeatured,$status) = mysql_fetch_row($result);		
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
	
	$sqlCategory = "select category_id from tbljobcategories where job_id = {$a_id}"; 
	$resultCats = $db->Query($sqlCategory);
	$jobCategories = array();
	while($row = mysql_fetch_assoc($resultCats)){
		$jobCategories[] = $row['category_id'];
	}
	$jobCategoriesText = implode(',',$jobCategories);
	
	$sqlTag = "select tag_id from tbljobtags where job_id = {$a_id}"; 
	$resultTags = $db->Query($sqlTag);
	$jobTags = array();
	while($row = mysql_fetch_assoc($resultTags)){
		$jobTags[] = $row['tag_id'];
	}
	$jobTagsText = implode(',',$jobTags);
	
	$CustomerSql = mysql_query("select user_id, firstname,lastname from tbluser where status = '1' and user_type = 'Job Poster' ORDER By `firstname`");
?>
<script type="text/javascript" src="js/jquery.fancybox.js"></script>
<link href="css/jquery.fancybox.css" type="text/css" rel="stylesheet" />

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
		<section class="content-header">
		  <h1>
			Jobs
			
		  </h1>
		  <ol class="breadcrumb">
			<li><a href="<?php echo ADMIN_URL; ?>main.php"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="<?php echo ADMIN_URL; ?>main.php?pg=viewjobs"><i class="fa fa-suitcase"></i>Jobs</a></li>
			
		  </ol>
		</section>

    <!-- Main content -->
		 <section class="content">
			  <div class="row">
					<div class="col-md-6">
					  <!-- general form elements -->
					  <div class="box box-primary">
						<div class="box-header with-border">
						  <h3 class="box-title">Modify Job</h3>
						</div>
						<div class="error"></div>
						<!-- /.box-header -->
						<!-- form start -->
						<form role="form" class="validateForm" name="Admin" action="main.php?pg=jobproc" method="post" enctype="multipart/form-data">
						<input type="hidden" value="mod" name="act">
						<input type="hidden" value="<?php echo $a_id;?>" name="id">
						  <div class="box-body">
							<?php 
							
							if($image!=''){
								$src=JOBS_IMG_URL.get_image_thumbnail($image);  
							?>
								<div class="form-group">
									<label for="exampleInputEmail1">Image</label>
									<a href="<?php echo $src; ?>" class="enLarge" ><img src="<?php echo $src; ?>"  width='64' width='64'/></a><br/>
									
									<input type="checkbox" name ="rmavatar" value='1' /> <input type="hidden" name="rmimage" value="<?php echo $image; ?>" /> Remove Job Image 
								</div>
								
							<?php } ?>
							
							<div class="form-group">
								<label>Image</label>
								<input type="file" 		
								data-validation-engine="validate[funcCall[geThan[]]]" 
								data-errormessage-value-missing="Only JPG and PNG are allowed"
								name="image" id="image" class="form-control input3 mini"  >
								<span style="font-size:12px;font-weight:normal;">Recommended size is 780(height) X 780(width). </span>
							</div>
							
							<div class="form-group">
								<label>Tilte</label><span style="color:#FF0000;">*</span>
								<input type="text" name="jobname" id="jobname" class="form-control input3 mini" placeholder="Enter Job Title" data-validation-engine="validate[required]" value="<?php echo $job_name; ?>" data-errormessage-value-missing="Please enter job title"maxlength="50"  >
							</div>
							<div class="form-group">
								<label>Select User</label>
								<label class="pull-right"><a href="main.php?pg=adduser">New User</a></label>
								<select  name="user_id" class="form-control select"  data-validation-engine="validate[required]" data-errormessage-value-missing="Please select user"  >
								<?php while($CustomerRecord = mysql_fetch_assoc($CustomerSql)):
									$userChecked = "";
									if($CustomerRecord['user_id'] == $job_user_id)
										$userChecked = "selected";
								?>
									<option value="<?php echo $CustomerRecord['user_id'];?>" <?php echo $userChecked; ?>><?php echo $CustomerRecord["firstname"]. " ".$CustomerRecord["lastname"]; ?></option>
								<?php endwhile; ?>
								</select>
							</div>
							
							<div class="form-group">
								<label>Description</label><span style="color:#FF0000;">*</span>
								<textarea class="form-control" style='min-height:300px;'  data-errormessage-value-missing="Please enter description" data-validation-engine="validate[required]" name="description" ><?php echo $job_description; ?></textarea>
							</div>
							<div class="form-group">
								<label>Price</label><span style="color:#FF0000;">*</span>
								<input type="text" name="price" id="price" class="form-control" placeholder="Enter Price" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter price" value="<?php echo $price; ?>"maxlength="10"  />
							</div>
							<div class="form-group">
								<label>Category</label><span style="color:#FF0000;">*</span>
								<?php $selectCategories = mysql_query("SELECT category.category_id, category.category_name FROM tblcategory as category WHERE category.isactive=1  order by category.category_name");
								?>				
								<select class="form-control" name="categories[]"  size="6" multiple data-validation-engine="validate[required]" data-errormessage-value-missing="Please select at least one category." style="width: 320px;" >
									<?php
									while($category = mysql_fetch_array($selectCategories)){ 
										$categoryCheck = "";
										if(in_array($category['category_id'],$jobCategories))
											$categoryCheck = "selected";
										
										$categoryName = $category['category_name'];	?>
										<option value="<?php echo $category['category_id']; ?>" <?php echo $categoryCheck; ?>><?php echo $categoryName; ?></option>
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
										$tagCheck = "";
										if(in_array($tag['tag_id'],$jobTags))
											$tagCheck = "selected";
										
										$tagName = $tag['tag_name'];	?>
										<option value="<?php echo $tag['tag_id']; ?>" <?php echo $tagCheck; ?>><?php echo $tagName; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label>Risk Meter</label>
								<select class="form-control" name="riskmeter" >
									<option value="1" <?php if($riskmeter == 1){ echo 'selected';} ?>>Low</option>
									<option value="2" <?php if($riskmeter == 2){ echo 'selected';} ?>>Medium</option>
									<option value="3" <?php if($riskmeter == 3){ echo 'selected';} ?>>High</option>
									<option value="4" <?php if($riskmeter == 4){ echo 'selected';} ?>>Very High</option>
								</select>
							</div>
							
							<div class="form-group">
								<label>Hours</label><span style="color:#FF0000;">*</span>
								<input type="number" maxlength='4' name="hours" id="hours"   data-errormessage-value-missing="Please enter valid data." data-validation-engine="validate[required,custom[number]]" class="form-control" value="<?php echo $job_hours; ?>"  min="1" max="24" />
							</div>
							<div class="form-group">
								<label>Days</label><span style="color:#FF0000;">*</span>
								<input type="number" maxlength='4' name="days" id="days"   data-errormessage-value-missing="Please enter valid data." data-validation-engine="validate[required,custom[number]]" class="form-control" value="<?php echo $job_days; ?>"  min="1" max="31" />
							</div>
							<?php
							$date = '';
							if($start_date != '')
							{
								$date = date('m-d-Y',strtotime($start_date));
							}
							?>
							<div class="form-group">
							<label>Start Date:</label><span style="color:#FF0000;">*</span>
							<div class="input-group date">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
								<input type="text"  name="start_date" class="form-control pull-right" id="datepicker" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select start Date"  value="<?php echo $date; ?>" maxlength="10"  />
							</div>
						<!-- /.input group -->
						</div>
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
										
								</select>
							</div>
							
							<div class="form-group">
								<label>Transport Link</label>
								<input type="text" name="transportlink" id="transportlink" class="form-control" placeholder="Enter Transport Link" value="<?php echo $transport_link; ?>" maxlength="250"  />
							</div>
							<div class="form-group">
								<label>Dress Code Description</label>
								<textarea class="form-control" style='min-height:300px;' name="dresscode_description" ><?php echo $dresscode; ?></textarea>
							</div>
							
							<div class="form-group">
							  <label>Is Featured?</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" value="1" name="is_featured" <?php echo $isFeaturedChecked; ?>  > NOTE:- Please tick this checkbox if you want to featured the job</label>
							  
							</div>
							
							<div class="form-group">
							  <label>Status</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" value="1" name="status" <?php echo $isActiveChecked; ?>  > NOTE:- Please tick this checkbox if you want to active customer account </label>
							  
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
				autoclose: true
			});
		});
	</script>