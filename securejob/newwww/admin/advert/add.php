<?php
if(!in_array(12,$tes_mod)) { 
echo "<div class='grid_12'><div class='message error'><p>You don't have permission to access this page</p></div></div>";
die;
}
?>

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
						  <h3 class="box-title">Add Advert</h3>
						</div>
						<div class="error"></div>
						<!-- /.box-header -->
						<!-- form start -->
						<form role="form" class="validateForm" name="Admin" action="main.php?pg=advertproc" method="post" enctype="multipart/form-data">
						<input type="hidden" value="add" name="act">
						  <div class="box-body">
							<div class="form-group">
								<label for="exampleInputEmail1">Advert Image</label>
								<input type="file" 		
								data-validation-engine="validate[funcCall[geThan[]]]" 
								data-errormessage-value-missing="Only JPG and PNG are allowed"
								name="image" id="image" class="form-control input3 mini"  >
								<span style="font-size:12px;font-weight:normal;">Recommended size is 780(height) X 780(width). </span>
							</div>
							
							<div class="form-group">
								<label>Advert Title</label><span style="color:#FF0000;">*</span>
								<input type="text" name="title" id="title" class="form-control input3 mini" placeholder="Enter Advert Title" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter advert title" maxlength="50"  >
							</div>
							<div class="form-group">
								<label>Advert Link</label>
								<input type="text" name="link" id="link" class="form-control input3 mini" placeholder="Enter Advert Link"  maxlength="50"  >
							</div>
							<div class="form-group">
								<label>Start Date</label><span style="color:#FF0000;">*</span>
								<input type="text" name="start_date" id="start_date" class="form-control input3 mini" placeholder="Enter Start Date" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter start date" maxlength="50"  >
							</div>
							
							<div class="form-group">
								<label>End Date</label><span style="color:#FF0000;">*</span>
								<input type="text" name="end_date" id="end_date" class="form-control input3 mini" placeholder="Enter End Date" data-validation-engine="validate[required]" data-errormessage-value-missing="Please enter end date" maxlength="50"  >
							</div>
							
							<?php /* ?>
							<div class="form-group">
								<label>Advert Description</label><span style="color:#FF0000;">*</span>
								<textarea class="form-control" style='min-height:300px;'  name="description" ></textarea>
							</div> <?php */ ?>
							<?php /*
							<div class="form-group">
							  <label for="exampleInputPassword1">Is Featured?</label>
							</div>
							
							<div class="checkbox">
								<label><input type="checkbox" value="1" name="is_featured"  > NOTE:- Please tick this checkbox if you want to featured the advert</label>
							</div> */ ?>
							<div class="form-group">
							  <label for="exampleInputPassword1">Status</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" value="1" name="status" checked  > NOTE:- Please tick this checkbox if you want to display this advertisement</label>
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