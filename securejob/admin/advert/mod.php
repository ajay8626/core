<?php
if(!in_array(11,$tes_mod)) { 
	echo "<div class='grid_12'><div class='message error'><p>You don't have permission to access this page</p></div></div>";
	die;
}
require_once(ADMIN_PATH."inc/img_upload.php");
include_once(ADMIN_PATH."inc/functions.php");
include_once(ADMIN_PATH."inc/resize-class.php");
// Get data from db for modification 
	$a_id = $_REQUEST["id"];
	$sql = "select * from tbladvert where advert_id = {$a_id}"; 
	$result = $db->Query($sql);
	$a_name = "";
	list($advert_id,$title,$description,$image,$created_date,$status,$isfeatured,$start_date,$end_date,$link) = mysql_fetch_row($result);		
	$db->Free($result);
	$isActiveChecked = "";
	if($status == 1){ 
		$isActiveChecked = "checked=checked"; 
	}
	$isFeaturedChecked = "";
	if($isfeatured == 1){ 
		$isFeaturedChecked = "checked=checked"; 
	} 

	if($start_date!='')
	{
		$start_date=date('d/m/Y',strtotime($start_date));
	}
	if($end_date!='')
	{
		$end_date=date('d/m/Y',strtotime($end_date));
	}
	//echo 'Status'.$status;
	//echo 'Isfeatured'.$isfeatured
	
?>
<script type="text/javascript" src="js/jquery.fancybox.js"></script>
<link href="css/jquery.fancybox.css" type="text/css" rel="stylesheet" />

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
		<section class="content-header">
		  <h1>
			Advert
			
		  </h1>
		  <ol class="breadcrumb">
			<li><a href="<?php echo ADMIN_URL; ?>main.php"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="<?php echo ADMIN_URL; ?>main.php?pg=viewadvert"><i class="fa fa-suitcase"></i>Advert</a></li>
			
		  </ol>
		</section>

    <!-- Main content -->
		 <section class="content">
			  <div class="row">
					<div class="col-md-6">
					  <!-- general form elements -->
					  <div class="box box-primary">
						<div class="box-header with-border">
						  <h3 class="box-title">Modify Advert</h3>
						</div>
						<div class="error"></div>
						<!-- /.box-header -->
						<!-- form start -->
						<form role="form" class="validateForm" name="Admin" action="main.php?pg=advertproc" method="post" enctype="multipart/form-data">
						<input type="hidden" value="mod" name="act">
						<input type="hidden" value="<?php echo $a_id;?>" name="id">
						  <div class="box-body">
							<?php 
							
							if($image!=''){
								$src=ADVERT_IMG_URL.get_image_thumbnail($image);  
							?>
								<div class="form-group">
									<label for="exampleInputEmail1">Image</label>
									<a href="<?php echo $src; ?>" class="enLarge" ><img src="<?php echo $src; ?>"  width='64' width='64'/></a><br/>
									
									<input type="checkbox" name ="rmavatar" value='1' /> <input type="hidden" name="rmimage" value="<?php echo $image; ?>" /> Remove Advert Image 
								</div>
								
							<?php } ?>
							
							<div class="form-group">
								<label>Advert Image</label>
								<input type="file" 		
								data-validation-engine="validate[funcCall[geThan[]]]" 
								data-errormessage-value-missing="Only JPG and PNG are allowed"
								name="image" id="image" class="form-control input3 mini"  >
								<span style="font-size:12px;font-weight:normal;">Recommended size is 780(height) X 780(width). </span>
							</div>
							
							<div class="form-group">
								<label>Advert Title</label><span style="color:#FF0000;">*</span>
								<input type="text" name="title" id="title" class="form-control input3 mini" placeholder="Enter Advert Name" data-validation-engine="validate[required]" value="<?php echo $title; ?>" data-errormessage-value-missing="Please enter advert title" maxlength="50"  >
							</div>
							
							<div class="form-group">
								<label>Advert Link</label><span style="color:#FF0000;">*</span>
								<input type="text" name="link" id="link" class="form-control input3 mini" placeholder="Enter Advert Link"  maxlength="50" value="<?php echo $link ?>" >
							</div>
							<div class="form-group">
								<label>Start Date</label><span style="color:#FF0000;">*</span>
								<input type="text" name="start_date" id="start_date" class="form-control input3 mini" placeholder="Enter Start Date" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter start date" value="<?php echo $start_date; ?>"  >
							</div>
							
							<div class="form-group">
								<label>End Date</label><span style="color:#FF0000;">*</span>
								<input type="text" name="end_date" id="end_date" class="form-control input3 mini" placeholder="Enter End Date" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter end date" value="<?php echo $end_date?>"  >
							</div>
							
							<?php /* 
							<div class="form-group">
								<label>Advert Description</label><span style="color:#FF0000;">*</span>
								<textarea class="form-control" style='min-height:300px;'   name="description" ><?php echo $description; ?></textarea>
							</div>  */ ?>
							
							
							
							<?php /*
							<div class="form-group">
							  <label>Is Featured?</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" value="1" name="is_featured" <?php echo $isFeaturedChecked; ?>  > NOTE:- Please tick this checkbox if you want to featured the advert</label>
							  
							</div> */ ?>
							
							<div class="form-group">
							  <label>Status</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" value="1" name="status" <?php echo $isActiveChecked; ?>  > NOTE:- Please tick this checkbox if you want to display this advertisement</label>
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
		$('#start_date').datepicker({
			autoclose: true,
			format: 'dd/mm/yyyy',
			startDate: '0'
		});
		
		$('#end_date').datepicker({
			autoclose: true,
			format: 'dd/mm/yyyy',
			startDate: '0'
		});
		
	});
</script> 