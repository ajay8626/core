<?php 
if(!in_array(2,$tes_mod)) { 
echo "<div class='grid_12'><div class='message error'><p>You don't have permission to access this page</p></div></div>";
die;
}

if (!isAdminLoggedIn())
	header("location:index.php");
else	
	$adminid=isAdminLoggedIn();

$id = isset($_GET["id"])?($_GET["id"]):0;

if((isset($_GET["id"])) && ($_GET["id"]!="")){
	$id = isset($_GET["id"])?($_GET["id"]):0;
	$sql = mysql_query("select * from tblversion where id = ".$id."");
	
	list($id,$app_version,$app_type,$app_url,$culture_code,$is_update_available,$is_approved) = mysql_fetch_row($sql);
	
} else {
	
	header("Location: main.php?pg=viewversion");
	exit;
}

	$errMsg=array();
if($_POST["act"] == 'add' || $_POST["act"] == 'edit')
{
	$err = 0;
	$is_approved=isset($_REQUEST["is_approved"])?stripslashes($_REQUEST["is_approved"]):"";
	$app_version=isset($_REQUEST["app_version"])?stripslashes($_REQUEST["app_version"]):0;
	$app_url=isset($_REQUEST["app_url"])?stripslashes($_REQUEST["app_url"]):0;
	$culture_code=isset($_REQUEST["culture_code"])?stripslashes($_REQUEST["culture_code"]):0;
	$is_update_available=isset($_REQUEST["is_update_available"])?stripslashes($_REQUEST["is_update_available"]):0;
	
	
	if($_POST["act"] == 'add' && $err==0){			
		
		header("Location: main.php?pg=viewversion");
		exit;
	}	
	if($_POST["act"] == 'edit' && $err==0){
					
		$data =array("app_version"=>$app_version,"app_url"=>$app_url,"culture_code"=>$culture_code,"is_update_available"=>$is_update_available,"is_approved"=>$is_approved);
		$db->Update($data,"tblversion"," id=".$id."");					
			
		$_SESSION['mt'] = "success";
		$_SESSION['me'] = "Version updated successfully.";
		header("Location: main.php?pg=viewversion");
		exit;	
		
	}	
}

?>



<div class="content-wrapper">
<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Version</h1>
	  <ol class="breadcrumb">
		<li><a href="<?php echo ADMIN_URL; ?>main.php"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo ADMIN_URL; ?>main.php?pg=viewversion">Version</a></li>
		
	  </ol>
	</section>

<!-- Main content -->
	 <section class="content">
		  <div class="row">
				<div class="col-md-6">
				  <!-- general form elements -->
				  <div class="box box-primary">
					<div class="box-header with-border">
					  <h3 class="box-title"><?php if ($id!=0) echo "Edit Version"; else echo "Add Version";?></h3>
					  <?php  echo getMsg(); ?>
					</div>
					<div class="error"></div>
					<!-- /.box-header -->
					<!-- form start -->
					<form role="form" class="validateForm" name="Admin"  method="post" >
					<?php 
					if ($id!=0) 
						echo '<input type="hidden" value="edit" name="act" />'; 
					else 
						echo '<input type="hidden" value="add" name="act" />';
					?>
					  <div class="box-body">
						<div class="form-group">
						  <label for="exampleInputEmail1">Type</label>
						  <?php echo $type = ($app_type==1) ? 'Android' : 'iPhone'; ?>
						</div>
						<div class="form-group">
						  <label for="exampleInputEmail1">Version</label>
						  <input type="text"  class="form-control"  maxlength='100' name="app_version"   value="<?php echo $app_version; ?>"  data-errormessage-value-missing="Please enter version" data-validation-engine="validate[required]" >
						</div>
						<div class="form-group">
						  <label for="exampleInputEmail1">URL</label>
						  <input type="text"  class="form-control"  maxlength='100' name="app_url"   value="<?php echo $app_url; ?>"  data-errormessage-value-missing="Please enter app url" data-validation-engine="validate[required]">
						</div>
						<div class="form-group">
						  <label for="exampleInputEmail1">Culture Code</label>
						  <input type="text"  class="form-control" maxlength='100' name="culture_code" value="<?php echo $culture_code; ?>" data-errormessage-value-missing="Please enter app url" data-validation-engine="validate[required]">
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Is Update Available</label>
							<select style="width: 320px;"  class="form-control" name="is_update_available" >
								<option value="0" <?php if($is_update_available=="0") { echo "selected";} ?>>No update available</option>
								<option value="1" <?php if($is_update_available=="1") { echo "selected";} ?>>No mandatory update available</option>
								<option value="2" <?php if($is_update_available=="2") { echo "selected";} ?>>Mandatory update available</option>
							</select>
						</div>
						
						<div class="form-group">
							<label for="exampleInputEmail1">Status</label>
							<select style="width: 320px;"  class="form-control" name="is_approved">
								<option value="1">Active</option>
								<option value="0" <?php if($is_approved=="0") { echo "selected";} ?>>Inactive</option>
							</select>
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

