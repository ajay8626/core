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
		$sql = mysql_query("select * from tblcategory where category_id = ".$id."");
		
		list($id,$name,$description,$created_date,$isactive,$sortorder,$image) = mysql_fetch_row($sql);
		
	}
	$errMsg=array();
	if($_POST["act"] == 'add' || $_POST["act"] == 'edit')
	{
		$err = 0;
		$name = $_REQUEST["name"];
		$description=isset($_REQUEST["description"])?stripslashes($_REQUEST["description"]):"";	
		$status=isset($_REQUEST["isactive"])?$_REQUEST["isactive"]:0;
		$sortorder=isset($_REQUEST["sortorder"])?$_REQUEST["sortorder"]:0;
		
		
		if($name=='')
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
			$sql_category = "select * from tblcategory WHERE category_name = '$name'";
					
			$res_category = $db->Query($sql_category);
			
			$totRowsCategory = mysql_num_rows($res_category);
			if($totRowsCategory > 0)
			{
				$err++;
				$_SESSION['mt'] = "error";
				$_SESSION['me'] = "Category already exist.";
			}
		}
		
        $newfilename='';
		$newFilePath='';
		$newFileURL='';
		if($_FILES['image']['name']!='')
		{
			$tmpFilePath = $_FILES['image']['tmp_name'];
			if ($tmpFilePath != ""){
				//Setup our new file path
				$path = $_FILES['image']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				
				$randname=rand(111111,999999);
				$newfilename =$randname.".".$ext;
				$newthumbfilename = "th_".$randname.".".$ext;
				
				$newFilePath = CATEGORY_IMG_PATH . $newfilename;
				//$newFileURL = POST_IMG_URL . $newfilename;
				
				//Upload the file into the temp dir
				if(move_uploaded_file($tmpFilePath, $newFilePath))
				{
					$path2=CATEGORY_IMG_PATH;
					//$resizeObj = new resize(USER_PROFILE_IMG_PATH.$newfilename);
					//$resizeObj->resizeImage(780, 780, 'exact');
					//$resizeObj->saveImage("$path2/$newfilename", 100);
					
					$resizeObj1 = new resize(CATEGORY_IMG_PATH.$newfilename);
					$resizeObj1->resizeImage(780, 780, 'exact');
					$resizeObj1->saveImage("$path2/$newthumbfilename", 100);
				}
				
			}
		}
		
		if($_POST["act"] == 'add' && $err==0){
			
			$job_image = '';
			if($newfilename!='')
			{
				$job_image = $newfilename;
			}
			
			$data =array("category_name"=>$name,'description'=>$description,'created_date'=>date('Y-m-d H:i:s'),'isactive'=>$status,'sortorder'=>$sortorder,'image'=>$job_image);
		
			if($db->Insert($data,"tblcategory")){
				$lastid=$db->LastInsert("tblcategory");
				$_SESSION['mt'] = "success";
				$_SESSION['me'] = "Category added successfully.";
				header("Location: main.php?pg=viewcategories");
				exit;
			}else{
				$_SESSION['mt'] = "error";
				$_SESSION['me'] = "Error while inserting data";
				header("Location: main.php?pg=viewcategories");
				exit;
			}
		}
		if($_POST["act"] == 'edit' && $err==0){
			
			
			$rmavatar=isset($_REQUEST["rmavatar"])?stripslashes($_REQUEST["rmavatar"]):"0";
			$job_image = '';
			//echo $newfilename;
			//exit;
			
			
			$data =array("category_name"=>$name,'description'=>$description,'isactive'=>$status,'sortorder'=>$sortorder);
			
			if($rmavatar==1 || $newfilename!='')
			{
				$rmimage=isset($_REQUEST["rmimage"])?stripslashes($_REQUEST["rmimage"]):"";
				@unlink(CATEGORY_IMG_PATH.$rmimage);
				@unlink(CATEGORY_IMG_PATH.'th_'.$rmimage);
				$job_image = $newfilename;
				$imageArray = array('image'=>$job_image);
				$data = array_merge($data,$imageArray);
			}
			
			//echo '';
			$db->Update($data,"tblcategory"," category_id=".$id."");					
			$_SESSION['mt'] = "success";
			$_SESSION['me'] = "Category updated successfully.";
			header("Location: main.php?pg=viewcategories");
			exit;
		}	
	}
?>
<div class="content-wrapper">
<?php  echo getMsg(); ?>
    <!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Categories</h1>
		  <ol class="breadcrumb">
			<li><a href="<?php echo ADMIN_URL; ?>main.php"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="<?php echo ADMIN_URL; ?>main.php?pg=viewcategories"><i class="fa fa-tree"></i>Categories</a></li>
			
		  </ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-6">
					  <!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Category</h3>
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
				<input class="form-control" id="name"  maxlength='50' name="name" value="<?php echo $name; ?>"  data-errormessage-value-missing="Please enter name" data-validation-engine="validate[required]" />
			</div>
			<?php 
							
							if($image!=''){
								$src=CATEGORY_IMG_URL.get_image_thumbnail($image);  
							?>
								<div class="form-group">
									<label for="exampleInputEmail1">Image</label>
									<a href="<?php echo $src; ?>" class="enLarge" ><img src="<?php echo $src; ?>"  width='64' width='64'/></a><br/>
									
									<input type="checkbox" name ="rmavatar" value='1' /> <input type="hidden" name="rmimage" value="<?php echo $image; ?>" /> Remove Category Icon 
								</div>
								
							<?php } ?>
			<div class="form-group">
				<label for="exampleInputEmail1">Category Icon</label>
			<input type="file" 		
			data-validation-engine="validate[funcCall[geThan[]]]" 
			data-errormessage-value-missing="Only JPG and PNG are allowed"
			name="image" id="image" class="form-control input3 mini"  >
			<span style="font-size:12px;font-weight:normal;">Recommended size is 780(height) X 780(width). </span>
			</div>
			
			<div class="form-group">
				<label>Description</label><span style="color:#FF0000;">*</span>
				<textarea class="form-control" style='min-height:300px;'   name="description" ><?php echo $description; ?></textarea>			
					
			</div>
			
			<div class="form-group">
				<label>Sort Order</label><span style="color:#FF0000;">*</span>
				<?php if($sortorder == ''){ $sortorder = getSortOrderCategory('tblcategory') + 1; } ?>
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
				<label><input type="checkbox" value="1" name="isactive" <?php echo $isActiveChecked;?> > NOTE:- Please tick this checkbox if you want to display this category</label>
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