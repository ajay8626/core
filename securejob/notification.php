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
<title>Notifications - SECURE THAT JOB</title>

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

<script>
	function markRead(notificationId){
		var notifId = notificationId;

		$.ajax({
			url: 'mark_read_notification.php?notifId='+notifId,
			type: "get",
			datatype: "html",
			beforeSend: function()
			{
				$('#preloader').show();
			}
		})
		.done(function(data){
			if(data == 1){
				$('#preloader').hide();
				$("div#notification_dv").load(location.href + " div#notification_dv");
			}else{
				$('#preloader').hide();
				alert("Something went wrong. Please try again.");
				return false;
			}
		})
		.fail(function(jqXHR, ajaxOptions, thrownError){
			$('#preloader').hide();
			alert("Something went wrong. Please try again.")
			return false;
		});
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
<div id="preloader" style="display:none; z-index:9999;"></div>
<?php include "header-inner.php"; ?>
<div class="stj_abt_wrap">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-md-10 stj_about_inn">
				<h2>Notifications</h2>
				<div class="stj_abt_con min_content">
					<div id="notification_dv">
						<?php
							$obj = new stjNotification;
							echo $obj->listAllNotifications($_SESSION['user_id']);
						?>
					</div>
				</div>				
			</div>
			<?php include "advert-section.php"; ?>
		</div>
	</div>
</div>
 
<?php include "footer.php"; ?>
</body>
</html>