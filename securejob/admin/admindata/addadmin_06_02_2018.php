<?php
if(!in_array(1,$tes_mod)) { 
echo "<div class='grid_12'><div class='message error'><p>You don't have permission to access this page</p></div></div>";
die;
}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Admin</h1>
		  <ol class="breadcrumb">
			<li><a href="<?php echo ADMIN_URL; ?>main.php"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="<?php echo ADMIN_URL; ?>main.php?pg=viewadmin"><i class="fa fa-user"></i>Admin</a></li>
			
		  </ol>
	</section>
	    <!-- Main content -->
		 <section class="content">
			  <div class="row">
					<div class="col-md-6">
					  <!-- general form elements -->
						<div class="box box-primary">
							<div class="box-header with-border">
								<h3 class="box-title">Add Admin User</h3>
							</div>
						<div class="error"></div>
						
						<form name="Admin" action="main.php?pg=adminProc" method="post" class="validateForm">
			<input type="hidden" value="add" name="act">
			 <div class="box-body">
					
					<div class="form-group">
						<label>First Name</label><span style="color:#FF0000;">*</span>
						<input name="a_name" id="a_name" 
						class="form-control" maxlength="20" data-validation-engine="validate[required]"
						data-errormessage-value-missing="Please enter your first name" >
					</div>
					<div class="form-group">
						<label>Last Name</label><span style="color:#FF0000;">*</span>
						<input name="a_lname" id="lname" class="form-control" maxlength="20" data-validation-engine="validate[required]"	data-errormessage-value-missing="Please enter your last name" >
						
					</div>
					<div class="form-group">
						<label>Email Address</label><span style="color:#FF0000;">*</span> 
						
						<input type="text" name="a_email" id="email1" maxlength="70" 
						class="form-control" data-validation-engine="validate[required,custom[email]]"
						data-errormessage-value-missing="The e-mail address you entered appears to be incorrect." 
						data-errormessage-custom-error="Example: yourscreenname@aol.com" >
						
					</div>					
					<div class="form-group">
						<label>Password</label><span style="color:#FF0000;">*</span>
						<input type="password" name="pwd1" id="password" maxlength="12" data-validation-engine="validate[required]"
						data-errormessage-value-missing="Please enter password"  class="form-control">
					</div>
					<div class="form-group">
						<label>Confirm Password</label><span style="color:#FF0000;">*</span>
						<input type="password" name="pwd2" id="rpassword" maxlength="12" 
						data-validation-engine="validate[required,equals[password]]"
						data-errormessage-value-missing="Please enter confirm password" 
						data-errormessage-custom-error="The two passwords you entered did not match each other. Please try again." class="form-control">
					</div>
					<div class="form-group">
						<label>Select User Rights</label><span style="color:#FF0000;">*</span>
						
							<select class="form-control" name="c_chk[]"  size="6" multiple data-validation-engine="validate[required]" data-errormessage-value-missing="Please select at least one right." style="width: 320px;" >
								<option value="1">Admin Management</option>
								<option value="2">System</option>
								<option value="3">User</option>
								<option value="4">Categories</option>
								<option value="7">Tags</option>
								<option value="5">Jobs</option>
								<option value="9">Services</option>
								<option value="6">Versions</option>
								<option value="8">General Message</option>
								<option value="10">CMS</option>
							</select>
						
					</div>
					<div class="form-group">
						 <label for="exampleInputPassword1">Status</label>
					</div>
					<div class="checkbox">
								<label><input type="checkbox" checked value="1" name="status"> NOTE:- Please tick this checkbox if you want to active admin account </label>
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
