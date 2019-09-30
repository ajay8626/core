<?php
include "config.php";
?>
<?php
/* Getting file name */
$filename = $_FILES;

//echo "<pre>";print_r($filename);exit;

for($i=0; $i<count($_FILES['file']['name']); $i++){

	/* Location */
	$location = "admin/user/documents/".$_FILES['file']['name'][$i];
	$mimeType = pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION);
	/* Upload file */
	$data='';
	if(move_uploaded_file($_FILES['file']['tmp_name'][$i],$location)){
		?>

		<?php if($mimeType != "pdf"){ ?>
		<span id="uploaded_license_<?php echo $i;?>">
			<a class="fancybox" rel="group" href="<?php echo SITE_URL.''.$location; ?>">
				<img src="<?php echo SITE_URL.''.$location; ?>" style="width:100px;" alt="">
			</a>
			<input type="button" name="remove_certi" class="btn btn-srch-pc remove_certi" value="Remove" onclick="javascript:return removeLicenseUpload(<?php echo $i;?>);">
		</span>
		<?php }else{ ?>
			<span id="uploaded_license_<?php echo $i;?>">
			<a class="fancybox_pdf" rel="group" href="<?php echo SITE_URL.''.$location; ?>">
				<img src="images/pdf_image.png" style="width:100px;" alt="">
			</a>
			<input type="button" name="remove_certi" class="btn btn-srch-pc remove_certi" value="Remove" onclick="javascript:return removeLicenseUpload(<?php echo $i;?>);">
		</span>
		<?php } ?>


		<?PHP
	}else{
		echo 0;
	}

}

?>

