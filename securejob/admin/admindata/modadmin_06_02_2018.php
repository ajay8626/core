<?php
$act = 	$_POST["act"];
if(!in_array(1,$tes_mod)) { 
	echo "<div class='grid_12'><div class='message error'><p>You don't have permission to access this page</p></div></div>";
	die;
}
$a_id   = 	$_POST['a_id'];
$act    = 	$_POST["act"];
$a	=	$_POST['c_chk'];

// Set All Admin data here
$a_name =	addslashes($_POST["a_name"]); 
$a_lname =	addslashes($_POST["a_lname"]); 
$status = 	isset($_POST["status"])?$_POST["status"]:0;
$a_email = 	$_POST["a_email"];  

if($act == "mod"){
	if($a_name != "" && $a_id > 0){			
		$totRows = 0;
		$aName = addslashes($a_name);
		$a_email = 	$_POST["a_email"];
		$sql = "select * from tbladmin where (adminemail = '{$a_email}') and adminid  <> {$a_id}";
		$totRows = mysql_num_rows($db->Query($sql));
		if($totRows >0)
		{	
			$_SESSION['mt'] = "error";
			$_SESSION['me'] = "Email address already exists.";
			header('Location:main.php?pg=modadmin&a_id='.$a_id	);
			exit;
		}
		else
		{
			if($a_id==1)
			{
				$status=1;
			}

			$data = array('adminfname'=>stripslashes($a_name),'adminlname'=>stripslashes($a_lname), 'adminemail'=>$a_email, 'isactive'=>$status);
			$where ="adminid ={$a_id}";
			$password_1 = $_POST['pwd1'];
			$password_2 = $_POST['pwd2'];
			if(isset($password_1) && !empty($password_1) && $password_1 == $password_2 )
			{	
				$pass  = md5($password_1);
				$data = array_merge($data,array('password'=>$pass));
				$where ="adminid ={$a_id}";
			}
			
			
			$db->Update($data,"tbladmin",$where);
			
		 
			if($a_id!=1)
			{
				$sql1 = mysql_query("select * from tbladminrights where adminid = ".$a_id."");
				$where1= "admin_id  = {$a_id}";	
				$db->Delete("tbladminrights",$where1);		
				foreach ($a as $value) 
				{		
					$data1 = array('menu_id'=>$value,'admin_id'=>$a_id);
					$db->Insert($data1,"tbladminrights");
				}
			}
			$_SESSION['mt'] = "success";
			$_SESSION['me'] = "Admin Update Successfully.";
			header('Location:main.php?pg=viewadmin');
			exit;
		}
	}
	else
	{	
		$_SESSION['mt'] = "error";
		$_SESSION['me'] = "Admin Name/Password Invalid.";
		header('Location:main.php?pg=viewadmin');
		exit;
	}	
}

// Get data from db for modification 
	$a_id = $_REQUEST["a_id"];
	$sql = "select * from tbladmin where adminid = {$a_id}"; 
	$result = $db->Query($sql);
	$a_name = "";
	list($a_id,$a_name,$a_lname,$a_email, $a_pwd,  $a_status) = mysql_fetch_row($result);		
	$db->Free($result);
	$isActiveChecked = "";
	if($a_status == 1){ 
		$isActiveChecked = "checked=checked"; 
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
							<h3 class="box-title">Modify Admin User</h3>
						</div>
						<div class="error"></div>
						<form name="Admin" action="" method="post" class="validateForm" autocomplete="off">
							<input type="hidden" name="act" value="mod">
							<input type="hidden" name="a_id" value="<?php echo $a_id; ?>" >
			 <div class="box-body">
					<div class="form-group">
						<label>First Name</label><span style="color:#FF0000;">*</span>
						<input name="a_name" id="a_name" 
						class="form-control" maxlength="20" data-validation-engine="validate[required]"
						data-errormessage-value-missing="Please enter your first name" value="<?php echo stripslashes($a_name);?>">
						
					</div>
					<div class="form-group">
						<label>Last Name</label><span style="color:#FF0000;">*</span>
						<input name="a_lname" id="lname" 
						class="form-control" maxlength="20" data-validation-engine="validate[required]"
						data-errormessage-value-missing="Please enter your last name" value="<?php echo stripslashes($a_lname);?>">
						
					</div>
					<div class="form-group">
						<label>Email Address</label><span style="color:#FF0000;">*</span> 
						<input type="text" name="a_email" id="email1" maxlength="70" 
						class="form-control" data-validation-engine="validate[required,custom[email]]"
						data-errormessage-value-missing="The e-mail address you entered appears to be incorrect." 
						data-errormessage-custom-error="Example: yourscreenname@aol.com"  value="<?php echo $a_email;?>">
						
					</div>				
					<div class="form-group">
						<label>Password</label>
						<input type="password" name="pwd1" id="password" maxlength="12" class="form-control">
					</div>
					<div class="form-group">
						<label>Confirm Password </label>
						<input type="password" name="pwd2" id="rpassword" data-validation-engine="validate[equals[password]]" maxlength="12" class="form-control">
					</div>
					<?php if($a_id != ADMINID): ?>
					<div class="form-group">
						<label>Select User Rights </label><span style="color:#FF0000;">*</span>
						
							<?php 
							$sql_new = mysql_query("select * from tbladminrights where admin_id = {$a_id}");
							$rst_val = array();
							while($rst_new = mysql_fetch_array($sql_new))
							{
								$rst_val[] = $rst_new['menu_id'];
							}
							?>
							<select class="form-control" name="c_chk[]" class="mini" size="6" multiple data-validation-engine="validate[required]" data-errormessage-value-missing="Please select at least one right." style="width: 320px;" >
								<option <?php if(in_array('1',$rst_val)){ echo 'selected';} ?> value="1">Admin Management</option>
								<option <?php if(in_array('2',$rst_val)){ echo 'selected';} ?> value="2">System</option>
								<option <?php if(in_array('3',$rst_val)){ echo 'selected';} ?> value="3">User</option>
								<option <?php if(in_array('4',$rst_val)){ echo 'selected';} ?> value="4">Categories</option>
								<option <?php if(in_array('7',$rst_val)){ echo 'selected';} ?> value="7">Tags</option>
								<option <?php if(in_array('5',$rst_val)){ echo 'selected';} ?> value="5">Jobs</option>
								<option <?php if(in_array('9',$rst_val)){ echo 'selected';} ?> value="9">Services</option>
								<option <?php if(in_array('6',$rst_val)){ echo 'selected';} ?> value="6">Versions</option>
								<option <?php if(in_array('8',$rst_val)){ echo 'selected';} ?> value="8">General Message</option>
								<option <?php if(in_array('10',$rst_val)){ echo 'selected';} ?> value="10">CMS</option>
							</select>
						
					</div>
					<div class="form-group">
						 <label for="exampleInputPassword1">Status</label>
					</div>
					<div class="checkbox">
								<label><input type="checkbox" value="1" name="status" <?php echo $isActiveChecked;?> > NOTE:- Please tick this checkbox if you want to active admin account </label>
					</div>
					
					<?php endif; ?>
						<input type="hidden" value="<?php echo $a_id; ?>" name="a_id"> 
							
					</tr>
				</div>
				<div class="box-footer">
					<button type="submit"  name="submit_me"  class="btn btn-primary">Submit</button>
				</div>
			</form>
					</div>
				</div>
			</div>
	</section>
</div>
<div class="clear"></div>