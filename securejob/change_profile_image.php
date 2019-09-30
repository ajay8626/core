<?php 
include "config.php";
$user_id = $_SESSION['user_id'];
$customer_type=isset($_SESSION['customer_type']) ? $_SESSION['customer_type'] : 0;

if(isset($_POST['submit']) && $_POST['submit']!='')
{
	$imageProfile = isset($_REQUEST["saveprofileimage"])?$_REQUEST["saveprofileimage"]:'';

	if($imageProfile != ""){
		$data = array('profile_image'=>$imageProfile);
		$where ="user_id ={$_SESSION['user_id']}";

		$db->Update($data,"tbluser",$where);
		$_SESSION['pu'] = "Profile Image Updated";

		if($customer_type==1)
		{
			header('Location:business-profile.php');
			exit;
		}
		if($customer_type==2)
		{
			header('Location:individual-profile.php');
			exit;
		}
	}else{
		$_SESSION['pe'] = "Please try again";
	}
	
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="theme-color" content="#cf2027">
<meta name="msapplication-navbutton-color" content="#cf2027">
<meta name="apple-mobile-web-app-status-bar-style" content="#cf2027">
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<title>Edit Profile - SECURE THAT JOB</title>

<!-- Bootstrap -->
<link href="https://fonts.googleapis.com/css?family=Fira+Sans:300,400,400i,500,600,700,800" rel="stylesheet"> 
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link href="css/jquery-ui.css" rel="stylesheet">
<link href="css/ddsmoothmenu.css" rel="stylesheet">
<link href="css/jquery.fancybox.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">
<link href="fonts/font-awesome.css" rel="stylesheet">
<link href="css/cropper.css" rel="stylesheet">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.bxslider.js"></script>
<script type="text/javascript" src="js/menu.js"></script>
<script type="text/javascript" src="js/jquery.fancybox.js"></script>
<script src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/at-jquery.js"></script>
<script type="text/javascript" src="js/cropper.min.js"></script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>


<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({includedLanguages: '<?php echo LanguageList; ?>', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script>

<?php if(isset($_SESSION['user_id'])){
	$link='login.php';
	if(isset($_SESSION['user_id']) && $_SESSION['customer_type']==1)
	{
		$profileURL = 'business-profile.php';
	}
	if(isset($_SESSION['user_id']) && $_SESSION['customer_type']==2)
	{
		$profileURL = 'individual-profile.php';
	}
}
?>

<script>
$(document).ready(function(){
	$('#back').click(function(){
		window.location.href = "<?php echo $profileURL; ?>";
	})
})
</script>

</head>
<body>
<?php include "header-inner.php"; ?>
<div class="stj_login_wrap">
	<div class="container">
		<div class="row">
			 
			<div class="login_dv">
				<div class="lg_dv_lft">
					<h2>Change Profile Image</h2>
					<ul>
						
						<?php if($_SESSION['pe'] != ''){ ?>
						<li>
							<div class="alert alert-danger fade in">
								<a href="#" class="close" data-dismiss="alert">&times;</a>
								<strong>Error!</strong> <?php echo $_SESSION['pe']; ?>.
							</div>
						</li>
						<?php 
							} 
							unset($_SESSION['pe']);
						?>
						
					   <form method="post" action="<?php echo basename($_SERVER['REQUEST_URI']); ?>">
						<li>
							<div class="stj_photo_up">
								<div class="file-upload-pi">
									<div class="file-select">   
										<!-- <div class="file-select-name" id="noFile"></div> --> 
										<div class="file-select-button" id="fileName">Upload Image</div>
										<!-- <input type="file" name="profileimage"  data-validation-engine="validate[funcCall[geThan[]]]" 
										data-errormessage-value-missing="Only JPG and PNG are allowed"  id="chooseFile"> -->
										<input type="file" name="profileimage" id="chooseFile" style="border: 1px solid #999999; padding:10px 5px; margin-top:10px; width:100%;">
										<input type="hidden" name="saveprofileimage" id="saveprofileimage">
									</div> 
								</div>
								<img id="uploadedImage" class="cropped" src="" style="border-radius: 0; margin-top:10px; display:none;"/>
							</div>
						</li>
						
						<li>
							<input type="button" name="back" id="back" value="Back" class="btn_lg change_dp_btn"/>
							<input type="submit" name="submit" value="Upload" class="btn_lg change_dp_btn"/>
						</li>
						</form>
						<li>
							
						</li>
					</ul>
					
				</div>

				<div class="lg_dv_rgt">
					
					<main class="page">
							<!-- leftbox -->
							<div class="box-2">
								<div class="result"></div>
							</div>
							
							<!-- input file -->
							<div class="box">
								<div class="options hide" style="display:none;">
									<label> Width</label>
									<input type="number" class="img-w" value="600"  name="imagedim"/>
								</div>
								<!-- save btn -->
								<br/>
								<button class="btn save hide">Crop Image</button>
								<button class="btn cancel hide">Cancel</button>
							</div>
						</main>
					
				</div>
				
				
			</div>
			
		</div>
	</div>
</div>

<!-- Script for image cropping -->
<script type="text/javascript">
let result = document.querySelector('.result'),
img_result = document.querySelector('.img-result'),
img_w = document.querySelector('.img-w'),
img_h = document.querySelector('.img-h'),
options = document.querySelector('.options'),
save = document.querySelector('.save'),
cancel = document.querySelector('.cancel'),
cropped = document.querySelector('.cropped'),
upload = document.querySelector('#chooseFile'),
cropper = '';

/* clear the file before (change) of image */
upload.addEventListener('click', (e) => {
	upload.value = null;
});

/* on change show image with crop options */
upload.addEventListener('change', (e) => {
	//$('.cropped').show();
	$("main.page").show();
  if (e.target.files.length) {
		// start file reader
    const reader = new FileReader();
    reader.onload = (e)=> {
      if(e.target.result){
			// create new image
			let img = document.createElement('img');
			img.id = 'image';
			img.src = e.target.result
			// clean result before
			result.innerHTML = '';
			// append new image
        	result.appendChild(img);
			// show save btn and options
			save.classList.remove('hide');
			cancel.classList.remove('hide');
			options.classList.remove('hide');
			// init cropper
			cropper = new Cropper(img, {
				aspectRatio: 16 / 16,
				viewMode: 2,
				zoomable: false,
				zoomOnTouch: false,	
				
			});
      }
    };
    reader.readAsDataURL(e.target.files[0]);
  }
});

/* Save on click */
save.addEventListener('click',(e)=>{
$("main.page").hide();
  e.preventDefault();
  // get result to data uri
  let imgSrc = cropper.getCroppedCanvas({
		width: img_w.value // input value
	}).toDataURL();
	
  // remove hide class of img

	// show image cropped
  cropped.src = imgSrc;
  $("#uploadedImage").show();
  $('input#saveprofileimage').val(imgSrc);

});

/* Cancel on click */
cancel.addEventListener('click',(e)=>{
	$("main.page").hide();	
	$("#uploadedImage").hide();
	$("#uploadedImage").attr("src", "");

	reset();
});

</script>
 
<?php include "footer.php"; ?>
</body>
</html>