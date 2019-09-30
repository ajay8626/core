<?php 
if(!in_array(8,$tes_mod)) { 
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
		$sql = mysql_query("select * from tblgeneralmessage where id = ".$id."");
		
		list($id,$title_key,$is_app_msg) = mysql_fetch_row($sql);
		
		$sqlgeneral_message = mysql_query("select * from tblgeneralmessagetranslation where general_message_id=$id");
		while($general_messagerow = mysql_fetch_array($sqlgeneral_message))
		{
			$general_messagedata[$id] = $general_messagerow['title_value'];
		}
	}
	
	$errMsg=array();
	if($_POST["act"] == 'add' || $_POST["act"] == 'edit')
	{
		$err = 0;
		$title_key = isset($_REQUEST["title_key"])?($_REQUEST["title_key"]):'';
		$is_app_msg = isset($_REQUEST["is_app_msg"])?($_REQUEST["is_app_msg"]):0;
		$general_message = $_REQUEST["general_message"]; 
	
		if($title_key=='' || $general_message=='')
		{
			$err++;	
		}
		
		if($err>0)  
		{
			$_SESSION['mt'] = "error";
			$_SESSION['me'] = "Please fill require fields.";
		}
		
		$slug=$title_key;
					
		if($_POST["act"] == 'add' && $err==0){			
			
			$data =array("title_key"=>$slug,"is_app_msg"=>$is_app_msg);
		
			if($db->Insert($data,"tblgeneralmessage")){					
				
				$last_id =$db->LastInsert("tblgeneralmessage");		
				
				$data =array("general_message_id"=>$last_id,"title_value"=>$general_message);
				$db->Insert($data,"tblgeneralmessagetranslation");
					
				$_SESSION['mt'] = "success";
				$_SESSION['me'] = "Message added successfully.";
				header("Location: main.php?pg=viewgeneralmsg");
				exit;
				
			}else{
				$_SESSION['mt'] = "error";
				$_SESSION['me'] = "Error while inserting data";
				header("Location: main.php?pg=viewgeneralmsg");
				exit;
			}
		}	
		if($_POST["act"] == 'edit' && $err==0){
						
			$data =array("title_key"=>$slug,"is_app_msg"=>$is_app_msg);
			$db->Update($data,"tblgeneralmessage"," id=".$id."");					
			$where1 = " general_message_id = {$id} ";
			$db->Delete("tblgeneralmessagetranslation",$where1);
		
									
			$data =array("general_message_id"=>$id,"title_value"=>$general_message);
			$db->Insert($data,"tblgeneralmessagetranslation");


				
			$_SESSION['mt'] = "success";
			$_SESSION['me'] = "Message updated successfully.";
			header("Location: main.php?pg=viewgeneralmsg");
			exit;

						
			
		}	
	}

?>

<script>
function generateSlug (value) { 
  // 1) convert to lowercase
  // 2) remove dashes and pluses
  // 3) replace spaces with dashes
  // 4) remove everything but alphanumeric characters and dashes
  var retuyrnval = value.replace(/-+/g, '').replace(/\s+/g, '_').replace(/[^A-Za-z0-9_]/g, '');  
  document.getElementById("title_key").value = retuyrnval;
  //return value.toLowerCase().replace(/-+/g, '').replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');
};
</script>

<div class="content-wrapper">
<?php  echo getMsg(); ?>
    <!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>General Message</h1>
		  <ol class="breadcrumb">
			<li><a href="<?php echo ADMIN_URL; ?>main.php"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="<?php echo ADMIN_URL; ?>main.php?pg=viewadmin"><i class="fa fa-comment"></i>General Message</a></li>
			
		  </ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-6">
					  <!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">General Message</h3>
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
				<label>Title Key</label><span style="color:#FF0000;">*</span>
				<input class="form-control" <?php if(isset($_REQUEST['id'])) { echo "readonly"; } ?> id="title_key"  maxlength='300' name="title_key" onkeypress="return generateSlug(this.value);" onblur="return generateSlug(this.value);"  value="<?php echo $title_key; ?>"  data-errormessage-value-missing="Please enter title key" data-validation-engine="validate[required,ajax[ajaxcheckkey]]" />
			</div>
			
			<div class="form-group">
				<label>Message</label><span style="color:#FF0000;">*</span>
				<input class="form-control"  maxlength='300' name="general_message"   value="<?php echo $general_messagedata[$id]; ?>"  data-errormessage-value-missing="Please enter message" data-validation-engine="validate[required]" />					
					
			</div>
						
			<div class="form-group">
				<label>Is App Message</label></td>
					<select style="width: 320px;" class="form-control" name="is_app_msg">
							<option value="0">No</option>
							<option value="1" <?php if($is_app_msg=="1") { echo "selected";} ?>>Yes</option>				
					</select>
				
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
