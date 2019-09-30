<?php 
if(!in_array(7,$tes_mod)) { 
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
		$sql = mysql_query("select * from tblnationality where id = ".$id."");
		
		list($id,$name,$status,$created_date) = mysql_fetch_row($sql);
		
		$sqlsettings = mysql_query("select * from tblnationality where id=$id");
		
	}
	$errMsg=array();
	if($_POST["act"] == 'add' || $_POST["act"] == 'edit')
	{
		$err = 0;
		$name = isset($_REQUEST["name"])?$_REQUEST["name"]:'';
		$status=isset($_REQUEST["is_active"])?$_REQUEST["is_active"]:0;	
		
		
		if($name=='')
		{
			$err++;				
		}
		
		if($err>0)  
		{
			$_SESSION['mt'] = "error";
			$_SESSION['me'] = "Please fill require fields.";
		}
		
					
		if($_POST["act"] == 'add' && $err==0){
			$data =array("name"=>$name,'status'=>$status,'created_date'=>date("Y-m-d H:i:s", time()));
		
			if($db->Insert($data,"tblnationality")){
				$lastid=$db->LastInsert("tblnationality");
				$_SESSION['mt'] = "success";
				$_SESSION['me'] = "Nationality added successfully.";
				header("Location: main.php?pg=viewnationality");
				exit;
			}else{
				$_SESSION['mt'] = "error";
				$_SESSION['me'] = "Error while inserting data";
				header("Location: main.php?pg=viewnationality");
				exit;
			}
		}
		if($_POST["act"] == 'edit' && $err==0){
			
			$data =array("name"=>$name,'status'=>$status);
			$db->Update($data,"tblnationality","id=".$id."");					
			$_SESSION['mt'] = "success";
			$_SESSION['me'] = "Nationality updated successfully.";
			header("Location: main.php?pg=viewnationality");
			exit;
		}	
	}
?>

<div class="content-wrapper">
<?php  echo getMsg(); ?>
    <!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Nationality</h1>
		  <ol class="breadcrumb">
			<li><a href="<?php echo ADMIN_URL; ?>main.php"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="<?php echo ADMIN_URL; ?>main.php?pg=viewbuild"><i class="fa fa-tags"></i>Nationality</a></li>
			
		  </ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-6">
					  <!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Nationality</h3>
					</div>
				<div class="error"></div>
				<div class="box-body">
				<form class="validateForm" name="frmadminadded" method="post" action="" enctype="multipart/form-data">
			<?php 
			if ($id!=0) {
				echo '<input type="hidden" value="edit" name="act" />'; 
				echo "<input type='hidden' value='$id' name='keyid' id='keyid' />"; 
				}
			else {
				echo '<input type="hidden" value="add" name="act" />';
				}
			?>
			<div class="form-group">
				<label>Name</label><span style="color:#FF0000;">*</span>
				<input class="form-control" id="name"  maxlength='25' name="name" value="<?php echo $name; ?>"  data-errormessage-value-missing="Please enter name" data-validation-engine="validate[required]" />
			</div>
						
			<div class="form-group">
			  <label>Status</label>
			</div>
			<div class="checkbox">
				<?php
				$isActiveChecked = "";
				if($status == 1){ 
					$isActiveChecked = "checked=checked"; 
				} 
				?>
				<label><input type="checkbox" value="1" name="is_active" <?php echo $isActiveChecked;?> > NOTE:- Please tick this checkbox if you want to display this nationality</label>
			</div>				
			
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