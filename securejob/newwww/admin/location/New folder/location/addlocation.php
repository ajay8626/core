<?php
if(!in_array(2,$tes_mod)) { 
echo "<div class='grid_12'><div class='message error'><p>You don't have permission to access this page</p></div></div>";
die;
}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Locations</h1>
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
								<h3 class="box-title">Add Location</h3>
							</div>
						<div class="error"></div>
						
						<form name="Admin" action="main.php?pg=locationproc" method="post" class="validateForm">
			<input type="hidden" value="add" name="act">
			 <div class="box-body">
					
										
					
					
					<div class="form-group">
						<label>Location</label><span style="color:#FF0000;">*</span>
						<input name="location" type="text" id="location" 
						class="form-control" maxlength="55" data-validation-engine="validate[required]"
						data-errormessage-value-missing="Please enter location name" >
					</div>
					<div class="form-group">
							  <label>Status</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" value="1" name="status" checked="checked"  > NOTE:- Please tick this checkbox if you want to active location account </label>
							  
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
<div class="clear"></div>
