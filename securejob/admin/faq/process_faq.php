<?php 
if(!in_array(4,$tes_mod)) { 
	echo "<div class='grid_12'><div class='message error'><p>You don't have permission to access this page</p></div></div>";
	die;
}

require_once(ADMIN_PATH."inc/img_upload.php");
include_once(ADMIN_PATH."inc/functions.php");
include_once(ADMIN_PATH."inc/resize-class.php");

if (!isAdminLoggedIn())
	header("location:index.php");
else	
	$adminid=isAdminLoggedIn();
	
	$id = isset($_GET["id"])?($_GET["id"]):0;

	if((isset($_GET["id"])) && ($_GET["id"]!="")){
		$id = isset($_GET["id"])?($_GET["id"]):0;
		$sql = mysql_query("select * from tblfaqmaster where faq_id = ".$id."");
		
		list($id,$question,$answer,$created_date,$isactive,$sortorder) = mysql_fetch_row($sql);
		
	}
	$errMsg=array();
	if($_POST["act"] == 'add' || $_POST["act"] == 'edit')
	{
		$err = 0;
		$question = $_REQUEST["question"];
		$answer=isset($_REQUEST["answer"])?stripslashes($_REQUEST["answer"]):"";	
		$status=isset($_REQUEST["isactive"])?$_REQUEST["isactive"]:0;
		$sortorder=isset($_REQUEST["sortorder"])?$_REQUEST["sortorder"]:0;
		
		
		if($question=='')
		{
			$err++;				
		}
		
		if($err>0)  
		{
			$_SESSION['mt'] = "error";
			$_SESSION['me'] = "Please fill require fields.";
		}
		
		if($id == 0 && $err==0)
		{
			$sql_category = "select * from tblfaqmaster WHERE question = '$question'";
					
			$res_category = $db->Query($sql_category);
			
			$totRowsCategory = mysql_num_rows($res_category);
			if($totRowsCategory > 0)
			{
				$err++;
				$_SESSION['mt'] = "error";
				$_SESSION['me'] = "Question already exist.";
			}
		}
		
        
		
		if($_POST["act"] == 'add' && $err==0){
			
			
			
			$data =array("question"=>$question,'answer'=>$answer,'created_date'=>date('Y-m-d H:i:s'),'isactive'=>$status,'sortorder'=>$sortorder);
		
			if($db->Insert($data,"tblfaqmaster")){
				$lastid=$db->LastInsert("tblfaqmaster");
				$_SESSION['mt'] = "success";
				$_SESSION['me'] = "Faq added successfully.";
				header("Location: main.php?pg=viewfaq");
				exit;
			}else{
				$_SESSION['mt'] = "error";
				$_SESSION['me'] = "Error while inserting data";
				header("Location: main.php?pg=viewfaq");
				exit;
			}
		}
		if($_POST["act"] == 'edit' && $err==0){
			
			
			
			//echo $newfilename;
			//exit;
			
			
			$data =array("question"=>$question,'answer'=>$answer,'isactive'=>$status,'sortorder'=>$sortorder);
			
			
			
			//echo '';
			$db->Update($data,"tblfaqmaster","faq_id=".$id."");					
			$_SESSION['mt'] = "success";
			$_SESSION['me'] = "Faq updated successfully.";
			header("Location: main.php?pg=viewfaq");
			exit;
		}	
	}
?>
<div class="content-wrapper">
<?php  echo getMsg(); ?>
    <!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Faq's</h1>
		  <ol class="breadcrumb">
			<li><a href="<?php echo ADMIN_URL; ?>main.php"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="<?php echo ADMIN_URL; ?>main.php?pg=viewfaq"><i class="fa fa-tree"></i>Faq's</a></li>
			
		  </ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-6">
					  <!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Faq's</h3>
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
				<label>Question</label><span style="color:#FF0000;">*</span>
				<input class="form-control" id="question"  maxlength='250' name="question" value="<?php echo $question; ?>"  data-errormessage-value-missing="Please enter question" data-validation-engine="validate[required]" />
			</div>
			
			<div class="form-group">
				<label>Answer</label><span style="color:#FF0000;">*</span>
				<textarea class="form-control" style='min-height:300px;'   name="answer" ><?php echo $answer; ?></textarea>			
					
			</div>
			
			<div class="form-group">
				<label>Sort Order</label><span style="color:#FF0000;">*</span>
				<?php if($sortorder == ''){ $sortorder = getSortOrderfaq('tblfaqmaster') + 1; } ?>
				<input type="number" maxlength='4' name="sortorder" id="sortorder" value="<?php echo $sortorder; ?>"  data-errormessage-value-missing="Please enter valid number." data-validation-engine="validate[custom[number]]" class="form-control" />
			</div>
						
			<div class="form-group">
			  <label>Status</label>
			</div>
			<div class="checkbox">
				<?php
				$isActiveChecked = "";
				if($isactive == 1){ 
					$isActiveChecked = "checked=checked"; 
				} 
				?>
				<label><input type="checkbox" value="1" name="isactive" <?php echo $isActiveChecked;?> > NOTE:- Please tick this checkbox if you want to display this faq's</label>
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
<script src="<?php echo ADMIN_URL; ?>ck_new/ckeditor/ckeditor.js"></script>
<script src="<?php echo ADMIN_URL; ?>ck_new/ckfinder/ckfinder.js"></script> 

<script type="text/javascript">
var editordescription = CKEDITOR.replace( 'answer', {
    filebrowserBrowseUrl : 'ckfinder/ckfinder.html',
    filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?type=Images',
    filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?type=Flash',
    filebrowserUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
    filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
    filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
});
CKFinder.setupCKEditor( editordescription, '../' );
</script>
<?php
function getSortOrderfaq($tablename){
	$qry = mysql_query("SELECT max(sortorder) as sortorder FROM $tablename");
	while($row = mysql_fetch_assoc($qry)){
		$sortorder = $row['sortorder'];
	}
	return $sortorder;
}
?>