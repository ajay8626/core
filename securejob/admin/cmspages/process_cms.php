<?php 
require_once(ADMIN_PATH."inc/img_upload.php");
include_once(ADMIN_PATH."inc/functions.php");
include_once(ADMIN_PATH."inc/resize-class.php");

if (!isAdminLoggedIn())
	header("location:index.php");
else
	$adminid=isAdminLoggedIn();

$page_id = isset($_GET["id"])?($_GET["id"]):0;

if((isset($_GET["id"])) && ($_GET["id"]!="")){
	$page_id = isset($_GET["id"])?($_GET["id"]):0;
	$sql = mysql_query("select * from tblcmspages where page_id = ".$page_id."");
	list($page_id,$page_title,$slug,$content,$is_active) = mysql_fetch_row($sql);
}

$errMsg=array();
if($_POST["act"] == 'add' || $_POST["act"] == 'edit')
{	
	$page_title=isset($_REQUEST["page_title"])?stripslashes($_REQUEST["page_title"]):"";
	//$slug=isset($_REQUEST["slug"])?stripslashes(trim($_REQUEST["slug"])):"";
	$content=isset($_REQUEST["content"])?$_REQUEST["content"]:"";
	$status=isset($_REQUEST["is_active"])?stripslashes($_REQUEST["is_active"]):"";	
	
	
	if($page_title=='' && $content=='' && $slug==''){
		$err++;
	}
	$and = '';
	if($page_id!='')
	{
		$and=" AND page_id!=$page_id";		
	}
	//echo "SELECT slug FROM tblcmspages where slug='$slug' $and";
	//exit;
	$mysql_slug = mysql_query("SELECT title FROM tblcmspages where title='$page_title' $and");
	$get_slug = mysql_num_rows($mysql_slug);
			
	
	if($err>0)  
	{
		$_SESSION['mt'] = "error";
		$_SESSION['me'] = "Please fill require fields.";
	}
	
	if($get_slug > 0)
	{
		$_SESSION['mt'] = "error";
		$_SESSION['me'] = "This title has already used in another page.";
		$err++;
	}
	
	
	if($_POST["act"] == 'add' && $err==0){
		//echo '111';
		//exit;
		$data =array("title"=>$page_title,"content"=>$content,"is_active"=>$status,"slug"=>'');
		
		/*$data =array("title"=>$page_title,"slug"=>$slug,"content"=>$content,"is_active"=>$status); */
		
		if($db->Insert($data,"tblcmspages"))
		{
			$_SESSION['mt'] = "success";
			$_SESSION['me'] = "CMS Page added successfully.";
			header("Location: main.php?pg=viewcms");
			exit;
		}else{
			$_SESSION['mt'] = "error";
			$_SESSION['me'] = "Error while inserting data";
			header("Location: main.php?pg=viewcms");
			exit;
		}
	}
	
	if($_POST["act"] == 'edit' && $err==0){
						
		/*$data =array("title"=>$page_title,"slug"=>$slug,"content"=>$content,"is_active"=>$status);*/
		
		$data =array("title"=>$page_title,"content"=>$content,"is_active"=>$status,"slug"=>'');
		
		$db->Update($data,"tblcmspages"," page_id=".$page_id."");
		
		$_SESSION['mt'] = "success";
		$_SESSION['me'] = "CMS Page updated successfully.";
		header("Location: main.php?pg=viewcms");
		exit;
	}	
}
$page_id = isset($_GET["id"])?($_GET["id"]):0;
?>
<div class="content-wrapper">
<?php  echo getMsg(); ?>
    <!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>CMS</h1>
		  <ol class="breadcrumb">
			<li><a href="<?php echo ADMIN_URL; ?>main.php"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="<?php echo ADMIN_URL; ?>main.php?pg=viewcms"><i class="fa fa-folder"></i>CMS</a></li>
			
		  </ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-6">
					  <!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">CMS Page</h3>
					</div>
				<div class="error"></div>
				<div class="box-body">
				<form class="validateForm" name="frmadminadded" method="post" action="" enctype="multipart/form-data">
			<?php 
			if ($page_id!=0) {
				echo '<input type="hidden" value="edit" name="act" />'; 
				echo "<input type='hidden' value='$id' name='keyid' id='keyid' />"; 
				}
			else {
				echo '<input type="hidden" value="add" name="act" />';
				}
			?>
			
				<div class="form-group">
					<label>Title</label><span style="color:#FF0000;">*</span>
					<input name="page_title" value="<?php echo $page_title; ?>"  data-errormessage-value-missing="Please enter title" data-validation-engine="validate[required]" maxlength="50" class='form-control' onkeyup="convertToSlug(this.value);" />
				</div>
				<?php /* ?>	
				<div class="form-group">
					<label>Slug</label><span style="color:#FF0000;">*</span>
					<input name="slug" id="slug"  value="<?php echo $slug; ?>" data-errormessage-value-missing="Please enter User ID" data-validation-engine="validate[required,ajax[ajaxchecknickname]]" maxlength="50" class='form-control' onkeypress="return blockSpecialChar(event)"/>
				</div>
				<?php */ ?>
				
				<div class="form-group">
					<label>Content</label>
					<textarea class="tinymce" style='min-height:300px;'  data-errormessage-value-missing="Please enter content" data-validation-engine="validate[required]" name="content" ><?php echo $content; ?></textarea>
				</div>	
					
				<div class="form-group">
					<label>Status</label></td>
					<select style="width: 320px;" class="form-control" name="is_active">
						<option value="active">Active</option>
						<option value="inactive" <?php if($is_active=="inactive") { echo "selected";} ?>>Inactive</option>
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





<script src="<?php echo ADMIN_URL; ?>ck_new/ckeditor/ckeditor.js"></script>
<script src="<?php echo ADMIN_URL; ?>ck_new/ckfinder/ckfinder.js"></script> 

<script type="text/javascript">
var editordescription = CKEDITOR.replace( 'content', {
    filebrowserBrowseUrl : 'ckfinder/ckfinder.html',
    filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?type=Images',
    filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?type=Flash',
    filebrowserUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
    filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
    filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
});
CKFinder.setupCKEditor( editordescription, '../' );
</script>

<script type="text/javascript">
function blockSpecialChar(e){
	var k;
	document.all ? k = e.keyCode : k = e.which;
	return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 0 || k != 9 || k == 13 || k == 16 || k == 17 || (k >= 48 && k <= 57));
}
		
function convertToSlug(Text)
{
    var slug = Text.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
	$('#slug').val(slug);
}
</script>

<style>
.addimage{cursor:pointer;}
</style>