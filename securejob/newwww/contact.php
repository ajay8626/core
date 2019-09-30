<?php 
include "config.php";
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
<title>Contact Us - SECURE THAT JOB</title>

<!-- Bootstrap -->
<link href="https://fonts.googleapis.com/css?family=Fira+Sans:300,400,400i,500,600,700,800" rel="stylesheet"> 
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link href="css/ddsmoothmenu.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">
<link href="fonts/font-awesome.css" rel="stylesheet">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.bxslider.js"></script>
<script type="text/javascript" src="js/menu.js"></script>
<script type="text/javascript" src="js/at-jquery.js"></script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({includedLanguages: '<?php echo LanguageList; ?>', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script>
</head>

<?php if(isset($_SESSION['user_id'])){
	$link='login.php';
	if(isset($_SESSION['user_id']) && $_SESSION['customer_type']==1)
	{
		$profileCLass = 'business-profile-class';
	}
	if(isset($_SESSION['user_id']) && $_SESSION['customer_type']==2)
	{
		$profileCLass = 'individual-profile-class';
	}
}
?>

<body class="<?php echo $profileCLass; ?>">
<?php include "header-inner.php"; ?>

<div class="stj_cnt_wrap">
	<div class="container">
		<div class="row">
			
			<div class="col-xs-12 col-md-10 stj_cnt_inn">
				<h2>contact us</h2>
				 
				<div class="stj_contact_dv">
					<div class="stj_cnt_form">
					<?php echo getMsg(); ?>
					   <form method="post" name="contact" action="contact_insert.php">
					   <input type="hidden" name="action" value="contact">
						<ul>
							<li>
								<label>First Name<em>*</em></label>
								<input type="text" name="firstname" required class="txt_cnt" />
							</li>
							<li>
								<label>Last Name<em>*</em></label>
								<input type="text" name="lastname" required class="txt_cnt" />
							</li>
							<li>
								<label>Email<em>*</em></label>
								<input type="email" name="cn_email" required class="txt_cnt" />
							</li>
							<li>
								<label>Phone</label>
								<input type="text" name="phone" class="txt_cnt" />
							</li>
							<li class="full_li">
								<label>Message</label>
								<textarea name="message" class="txtarea_cnt"></textarea>
							</li>
							<li class="full_li">
								<input type="submit" class="btn_cnt" value="Send" />
							</li>
						</ul>
						</form>
					</div>
					<div class="stj_cnt_dtl">
						<ul>
							<li class="add_l">Trojan Security (UK) Ltd<br/>483 Green Lanes, Palmers Green,<br/>London, N13 4BS</li>
							<li class="mail_l"><a href="mailto:info@trojansecurityuk.co.uk">info@trojansecurityuk.co.uk</a></li>
							<li class="phone_l"><a href="tel:02089206622">0208 920 6622</a></li>
							<li class="mob_l"><a href="tel:07947382211">07947 382 211</a></li>
						</ul>
					</div>
				</div>
				
				<div class="stj_map">
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2477.03027831211!2d-0.10748848403356334!3d51.62265451009037!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487619379d2859c7%3A0xcf88fa1283d62bf4!2s483+Green+Lanes%2C+London+N13+4BS%2C+UK!5e0!3m2!1sen!2sin!4v1520229738490" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
				</div>
				
			</div>
			<?php include "advert-section.php"; ?>
			<!--<div class="col-xs-12 col-md-2 stj_brc">
				<ul>
					<li><a href="#"><img src="images/brc1.jpg" alt=""/></a></li>
					<li><a href="#"><img src="images/brc2.jpg" alt=""/></a></li>
					<li><a href="#"><img src="images/brc3.jpg" alt=""/></a></li>
				</ul>
			</div>-->
			
		</div>
	</div>
</div>
 
<?php include "footer.php"; ?>
</body>
</html>