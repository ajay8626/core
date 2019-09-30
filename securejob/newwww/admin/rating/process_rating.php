<?php 
if(!in_array(13,$tes_mod)) { 
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
		$sql = mysql_query("select * from tblrating where rating_id = ".$id."");
		
		list($rating_id,$rating_name,$isactive,$sortorder,$created_date) = mysql_fetch_row($sql);
		
	}
	$errMsg=array();
	if($_POST["act"] == 'add' || $_POST["act"] == 'edit')
	{
		$err = 0;
		//$name = $_REQUEST["name"];
		$rating_name=isset($_REQUEST["rating_name"])?stripslashes($_REQUEST["rating_name"]):"";	
		$status=isset($_REQUEST["isactive"])?$_REQUEST["isactive"]:0;
		$sortorder=isset($_REQUEST["sortorder"])?$_REQUEST["sortorder"]:0;
		
		
		if($rating_name=='')
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
			$sql_category = "select * from tblrating WHERE rating_name = '$name'";
					
			$res_category = $db->Query($sql_category);
			
			$totRowsCategory = mysql_num_rows($res_category);
			if($totRowsCategory > 0)
			{
				$err++;
				$_SESSION['mt'] = "error";
				$_SESSION['me'] = "Rating already exist.";
			}
		}
		
       
		
		if($_POST["act"] == 'add' && $err==0){
			
			
			
			$data =array("rating_name"=>$rating_name,'isactive'=>$status,'sortorder'=>$sortorder);
		
			if($db->Insert($data,"tblrating")){
				$lastid=$db->LastInsert("tblrating");
				$_SESSION['mt'] = "success";
				$_SESSION['me'] = "Rating added successfully.";
				header("Location: main.php?pg=viewrating");
				exit;
			}else{
				$_SESSION['mt'] = "error";
				$_SESSION['me'] = "Error while inserting data";
				header("Location: main.php?pg=viewrating");
				exit;
			}
		}
		if($_POST["act"] == 'edit' && $err==0){
			$data =array("rating_name"=>$rating_name,'isactive'=>$status,'sortorder'=>$sortorder);
			$db->Update($data,"tblrating","rating_id=".$id."");			$_SESSION['mt'] = "success";
			$_SESSION['me'] = "Rating updated successfully.";
			header("Location: main.php?pg=viewrating");
			exit;
		}	
	}
?>
<div class="content-wrapper">
<?php  echo getMsg(); ?>
    <!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Ratings</h1>
		  <ol class="breadcrumb">
			<li><a href="<?php echo ADMIN_URL; ?>main.php"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="<?php echo ADMIN_URL; ?>main.php?pg=viewrating"><i class="fa fa-tree"></i>Ratings</a></li>
			
		  </ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-6">
					  <!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Rating</h3>
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
				<label>Rating Name</label><span style="color:#FF0000;">*</span>
				<input class="form-control" id="rating_name"  maxlength='50' name="rating_name" value="<?php echo $rating_name; ?>"  data-errormessage-value-missing="Please enter rating name" data-validation-engine="validate[required]" />
			</div>
			
			
			
			
			
			<div class="form-group">
				<label>Sort Order</label><span style="color:#FF0000;">*</span>
				<?php if($sortorder == ''){ $sortorder = getSortOrderCategory('tblrating') + 1; } ?>
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
				<label><input type="checkbox" value="1" name="isactive" <?php echo $isActiveChecked;?> > NOTE:- Please tick this checkbox if you want to display this rating</label>
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
<?php
function getSortOrderCategory($tablename){
	$qry = mysql_query("SELECT max(sortorder) as sortorder FROM $tablename");
	while($row = mysql_fetch_assoc($qry)){
		$sortorder = $row['sortorder'];
	}
	return $sortorder;
}
?>