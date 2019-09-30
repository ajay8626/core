<?php
if(!in_array(2,$tes_mod)) { 
	echo "<div class='grid_12'><div class='message error'><p>You don't have permission to access this page</p></div></div>";
	die;
}
$a_id   = 	$_POST['id'];
require_once(ADMIN_PATH."inc/img_upload.php");
include_once(ADMIN_PATH."inc/functions.php");
include_once(ADMIN_PATH."inc/resize-class.php");
// Get data from db for modification 
	$a_id = $_REQUEST["id"];
	$sql = "select * from tbllocation where location_id = {$a_id}"; 
	$result = $db->Query($sql);
	$a_name = "";
	list($location_id,$locationname,$status) = mysql_fetch_row($result);		
	$db->Free($result);
	$isActiveChecked = "";
	if($status == 1){ 
		$isActiveChecked = "checked=checked"; 
	} 
?>
<script type="text/javascript" src="js/jquery.fancybox.js"></script>
<link href="css/jquery.fancybox.css" type="text/css" rel="stylesheet" />

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
		<section class="content-header">
		  <h1>
			Locations
			
		  </h1>
		  <ol class="breadcrumb">
			<li><a href="<?php echo ADMIN_URL; ?>main.php"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="<?php echo ADMIN_URL; ?>main.php?pg=viewlocation"><i class="fa fa-location-arrow"></i>Locations</a></li>
			
		  </ol>
		</section>

    <!-- Main content -->
		 <section class="content">
			  <div class="row">
					<div class="col-md-6">
					  <!-- general form elements -->
					  <div class="box box-primary">
						<div class="box-header with-border">
						  <h3 class="box-title">Modify Location</h3>
						</div>
						<div class="error"></div>
						<!-- /.box-header -->
						<!-- form start -->
						<form role="form" class="validateForm" name="Admin" action="main.php?pg=locationproc" method="post" enctype="multipart/form-data" >
						<input type="hidden" value="mod" name="act">
					<input type="hidden" value="<?php echo $a_id;?>" name="id">
						  <div class="box-body">
												  
						<div class="form-group">
						<label>Location</label><span style="color:#FF0000;">*</span>
						<input name="location" type="text" id="location" 
						class="form-control" value="<?php echo $locationname; ?>" maxlength="55" data-validation-engine="validate[required]"
						data-errormessage-value-missing="Please enter location name" >
					   </div>
						<div class="form-group">
							  <label>Status</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" value="1" name="status" <?=$isActiveChecked?>  > NOTE:- Please tick this checkbox if you want to active location account </label>
							  
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