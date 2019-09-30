<?php 
/*
$myfile = fopen("../lang/celebrity_chinese.txt", "r");
echo fread($myfile,filesize("../lang/celebrity_chinese.txt"));
fclose($myfile); */

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
		$sql = mysql_query("select * from tblsystemconfiguration where config_id = ".$id."");
		
		list($id,$title_key,$title_value) = mysql_fetch_row($sql);
		
		$sqlsettings = mysql_query("select * from tblsystemconfiguration where config_id=$id");
		
	}
	$errMsg=array();
	if($_POST["act"] == 'add' || $_POST["act"] == 'edit')
	{
		$err = 0;
		$title_value = $_REQUEST["title_value"]; 
		$title_key = $_REQUEST["title_key"];
		
		if($title_value=='')
		{
			$err++;				
		}
		if($title_key=='')
		{
			$err++;				
		}
		
		if($err>0)  
		{
			$_SESSION['mt'] = "error";
			$_SESSION['me'] = "Please fill require fields.";
		}
		
					
		if($_POST["act"] == 'add' && $err==0){			
							
				$data =array("title_value"=>$title_value,"title_key"=>$title_key);
			
				if($db->Insert($data,"tblsystemconfiguration")){
					$lastid=$db->LastInsert("tblsystemconfiguration");
					
					$myfile = fopen("../lang/$title_key.txt", "w");					 					
					fwrite($myfile, $title_value);
					fclose($myfile);
					$_SESSION['mt'] = "success";
					$_SESSION['me'] = "Settings added successfully.";
					header("Location: main.php?pg=viewsystemconfig");
					exit;
					
				}else{
					$_SESSION['mt'] = "error";
					$_SESSION['me'] = "Error while inserting data";
					header("Location: main.php?pg=viewsystemconfig");
					exit;
				}
		}	
		if($_POST["act"] == 'edit' && $err==0){
			
			$data =array("title_value"=>$title_value);
			$db->Update($data,"tblsystemconfiguration"," config_id=".$id."");					
			$myfile = fopen("../lang/$title_key.txt", "w");					 					
			fwrite($myfile, $title_value);
			fclose($myfile);
			$_SESSION['mt'] = "success";
			$_SESSION['me'] = "Settings updated successfully.";
			header("Location: main.php?pg=viewsystemconfig");
			exit;
		}	
	}
?>
<?php  echo getMsg(); ?>
<?php
		if($title_key == "Base Price" || $title_key == "Featured Price"){
			$poundSign = '(&#163;)';
		}else{
			$poundSign = '';
		}
?>
<script>
function generateSlug (value) { 
  // 1) convert to lowercase
  // 2) remove dashes and pluses
  // 3) replace spaces with dashes
  // 4) remove everything but alphanumeric characters and dashes
  var retuyrnval = value.toLowerCase().replace(/-+/g, '').replace(/\s+/g, '_').replace(/[^a-z_]/g, '');  
  document.getElementById("title_key").value = retuyrnval;
  //return value.toLowerCase().replace(/-+/g, '').replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');
};
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
		<section class="content-header">
		  <h1>
			Settings
			
		  </h1>
		  <ol class="breadcrumb">
			<li><a href="<?php echo ADMIN_URL; ?>main.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?php echo ADMIN_URL; ?>main.php?pg=viewsystemconfig">Settings</a></li>
			
		  </ol>
		</section>

    <!-- Main content -->
		 <section class="content">
			  <div class="row">
					<div class="col-md-6">
					  <!-- general form elements -->
					  <div class="box box-primary">
						<div class="box-header with-border">
						  <h3 class="box-title"><?php if ($id!=0) echo "Edit Settings"; else echo "Add Settings";?></h3>
						</div>
						<div class="error"></div>
						<!-- /.box-header -->
						<!-- form start -->
						<form role="form" class="validateForm" name="Admin"  method="post" >
						<?php 
						if ($id!=0) {
							echo '<input type="hidden" value="edit" name="act" />'; 
						echo "<input type='hidden' value='$id' id='keyid' />"; }
						else { 
						echo '<input type="hidden" value="add" name="act" />'; }
						?>
						  <div class="box-body">
							<div class="form-group">
							  <label for="exampleInputEmail1">Title</label>
							  <input type="text" class="form-control"  <?php if(isset($_REQUEST['id'])) { echo "readonly"; } ?> id="title_key"  maxlength='100' name="title_key"   value="<?php echo $title_key; ?>"  data-errormessage-value-missing="Please enter Title" data-validation-engine="validate[required,ajax[ajaxsettingcheckkey]]"  id="exampleInputEmail1" placeholder="Please Enter Title" >
							</div>
							<div class="form-group">
							  <label for="exampleInputEmail1">Value <?php echo $poundSign; ?></label>
							  <input type="text" maxlength='255' name="title_value"   value="<?php echo $title_value; ?>"  data-errormessage-value-missing="Please enter value" data-validation-engine="validate[required]" class="form-control" id="exampleInputEmail1" placeholder="Please Enter Value" maxlength="55"  >
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
	
	