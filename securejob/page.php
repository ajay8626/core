<?php 
include "config.php"; 

$page_id=isset($_GET['page_id'])?$_GET['page_id'] : 0;
$sql="SELECT * FROM `tblcmspages` where is_active='active' and page_id=".$page_id."";
$exc=$db->Query($sql);
$totRows = mysql_num_rows($exc);
$data=mysql_fetch_array($exc);
$page_title=$data['title'];
$page_content=$data['content'];
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
<title><?php echo ucfirst($page_title);?> - SECURE THAT JOB</title>

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
<div class="stj_abt_wrap">
	<div class="container">
		<div class="row">
			
			<div class="col-xs-12 col-md-10 stj_about_inn">
			<?php 
			if($totRows > 0)
			{
				
			?>
			<h2><?php echo $page_title; ?></h2>
			<div class="stj_abt_con min_content">
			 <?php echo $page_content; ?>
			</div>
			<?php } else { ?>
			<center><h2>No Page Found.</h2></center>
			<?php } ?>
				<!--<h2>about us</h2>-->
				<!--<div class="stj_abt_con">
					<h3>Welcome to securethatjob.com</h3>
					<p>The only internet based recruitment and networking platform specialised for the Security Industry. You will be part of a revolutionary new approach into receiving work.Even if it’s at the last minute… Our website is improving the Security industry as a whole by bridging the gap in the market.</p>
					<hr>
					<h3>What are the problems with our Industry?</h3>
					<p>Currently we rely on generic labour agencies to dispense workers for a given job without true knowledge or specialised awareness of what is required or we rely on hundreds of companies who do not communicate or integrate their workforce in order to have a singular online marketplace to find jobs or find the right candidate for a specific security role</p>
					<hr>
					<h3>Some Facts</h3>
					<p>Did you know that manned Security in Britain generates a gross of around £6 billion annually? Internationally the Security Industry manned operations for private security spending is estimated to be $202 billion with growth of 5.5% in 2013 and growing every year. The specific needs of this industry can be the most specialised service intensive roles on the planet. So why not have a specialised website dedicated to the recruitment and job advertising needs of the Security Industry?</p>
					<hr>
					<h3>Thats where SECURETHATJOB comes in!</h3>
					<p>Our vision is to provide a specialised symbiotic website dedicated to the Security Industry. By providing an online marketplace to improve the access for people in the industry to get the best jobs available and for clients to access the best possible candidate for the job nationally. Here Employers can find you and offer work to suit your level of experience and ability. You can also search and apply for jobs at the rate you deserve quickly and efficiently.</p>
					<hr>
					<h3>FIND THE RIGHT PERSON</h3>
					<p>Search for a whole host of jobs and an array of specialised workers. Anything from Dog Handler to Close Protection, CCTV installation to Cyber Security specialists</p>
					<hr>
					<h3>AT THE RIGHT TIME</h3>
					<p>Work on the days your available at your convenience</p>
					<hr>
					<h3>FOR THE RIGHT PRICE</h3>
					<p>Get paid the rate you deserve and find workers for the right price</p>
					<hr>
					<h3>RATINGS SYSTEM</h3>
					<p>Get ratings to improve your reputation</p>
					<hr>
					<h3>GET PAID FAST</h3>
					<p>Receive secure and instant payment as soon as your job is completed The new way to create work and become established in the industry is now here and is only a click away on <a href="#">securethatjob.com</a>.</p>
					<hr>
					<h3>So, JOIN, SEARCH, WORK</h3>
					<p>Join now for FREE and be part of uniting the security sector and changing it for the better.</p>
					<div class="s_tm">The SecureThatJob.com Team</div>
				</div>-->
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