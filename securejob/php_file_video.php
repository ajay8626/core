<?php
include "config.php";
/* Getting file name */
$filename = $_FILES['file']['name'];

/* Location */
$location = "admin/user/profilevideos/".$filename;

/* Upload file */
$data='';
if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
    echo $data='<a class="g_vd" href="#g_id1"><img src="images/play3.png" alt="" style="width: 150px;"/></a><div style="display: none;"><div class="gd_pop" id="g_id1"><embed src="'.SITE_URL.''.$location.'" allowfullscreen="true" width="700" height="450"></div></div>';
}else{
    echo 0;
}
?>

<div style="display: none;">
	<div class="gd_pop" id="g_id1">
			<embed src="<?php echo CUSTOMER_PROFILE_VIDEO_URL.$filename; ?>" allowfullscreen="true" width="700" height="450">
	</div>
</div>