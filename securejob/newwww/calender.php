<?php 
//session_start();
include 'config.php'; 
unset($_SESSION['home_name']);
unset($_SESSION['home_email']);
unset($_SESSION['home_jobtype']);
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
<title>SECURE THAT JOB</title>
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


<link href="calender_asset/fullcalendar.min.css" rel="stylesheet">
<link href="calender_asset/custom_calender.css" rel="stylesheet">
<script src='calender_asset/moment.min.js'></script>
<script src='calender_asset/fullcalendar.js'></script>


<script type="text/javascript">
jQuery(window).load(function($) {
//setcookie('googtrans', '/en/en');
//document.cookie = "googtrans=/en/en"; 
});
function googleTranslateElementInit() {
  new google.translate.TranslateElement({includedLanguages: '<?php echo LanguageList; ?>', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script>

<?php
$siteUrl = SITE_URL.'search_job_confirmed.php?job_id=';
$featurejob = mysql_query("SELECT  tbljobs.job_name AS title, tbljobs.start_date AS start, CASE WHEN 1=1 THEN '#CF2027' END AS color, CASE WHEN 1=1 THEN tbljobs.job_id END AS url FROM tbljobs LEFT JOIN tbljobcategories ON tbljobs.job_id=tbljobcategories.job_id LEFT JOIN tbljobstatus ON tbljobs.job_id=tbljobstatus.job_id LEFT JOIN  tbljobsapplied ON tbljobs.job_id=tbljobsapplied.job_id WHERE  tbljobs.status=1 AND tbljobs.job_status=2 AND tbljobs.start_date >='".date("Y-m-d h:i:s")."'AND tbljobs.payment_status=1 AND tbljobsapplied.user_id=".$_SESSION['user_id']." ");


while($featurejobArray = mysql_fetch_assoc($featurejob)){
	$featurejobArray['url'] = $siteUrl.$featurejobArray['url']."&flag=confirm";
	$json[] = $featurejobArray;
}
$json = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', json_encode($json));
//echo $json;
?>

<script>

$(document).ready(function() {

  $('#calendar').fullCalendar({
	header: {
	  left: '',
	  center: 'prev title next',
	  right: 'today',
	},
	buttonText:{
		today: 'Today',
	},
	columnHeaderFormat: 'dddd',
	themeSystem: 'standard',
	fixedWeekCount: false,
	displayEventTime: false,
	filterResourcesWithEvents: true,
	defaultDate: '2018-09-12',
	navLinks: true, 
	businessHours: false, 
	editable: false,
	eventLimit: true,
	eventLimitText: 'See more',
	events: <?php echo $json; ?>
  });

});

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
<?php include "header.php"; ?>

<!-- Calendar Start -->
<div id="calendar"></div>
<!-- Calendar End -->


<?php include "footer.php"; ?>
</body>
<script>
	$(".job-type-button").on('click', '#job-type-job', function () {
    	$("button.job-type-job").addClass('active');
		$("button.job-type-security").removeClass('active');
		$("button.job-type-job").val('1');
		$("button.job-type-security").val('0');
		$("#submit_need").css("background-color", "#CF2027");
	});

	$(".job-type-button").on('click', '#job-type-security', function () {
    	$("button.job-type-security").addClass('active');
		$("button.job-type-job").removeClass('active');
		$("button.job-type-security").val('1');
		$("button.job-type-job").val('0');
		$("#submit_need").css("background-color", "#4D5170");
	});
</script>
</html>