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

<script type="text/javascript">
jQuery(window).load(function($) {
//setcookie('googtrans', '/en/en');
//document.cookie = "googtrans=/en/en"; 
});
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
<?php include "header.php"; ?>
<div class="home_bnr">
<div class="loader"></div>
    
  <ul id="slideshow">
    	<li><img src="images/slider1.jpg" /></li>
    	<li><img src="images/slider2.jpg" /></li>
		<li><img src="images/slider3.jpg" /></li>   
  </ul>
  <div class="slogan">
        <div class="container">
			<div class="bannerleft">
				<h3>Security</h3>
				<h4>at your fingertips</h4>
				<div class="captiontext">The UK's Leading Security Supermarket</div>
				<div class="wrk">
					<ul>
					<li>Join</li>	
					<li>Search</li>	
					<li>Work</li>											
					</ul>
				</div>
         	</div> 
         	<div class="guard"><img src="images/guard.png" alt=""/></div>
			<div class="rgt_frm">
			<?php echo getMsg(); ?>
				<h3>what you are looking for?</h3>
				<form method="post" name="looking" action="contact_insert.php">
					<input type="hidden" name="action" value="home">
					<!-- <div class="radio"><input name="jobtype" id="1" checked value="1" type="radio"><label for="1">Job</label></div> -->
					<!-- <div class="radio"><input name="jobtype" id="2" value="2" type="radio"><label for="2">Security</label></div> -->
					<div class="job-type-button"><button type="button" name="job-type-job" value="1" class="btn job-type-job active" id="job-type-job">I Need a Job</button></div>
					<div class="job-type-button"><button type="button" name="job-type-security" value="0" class="btn job-type-security" id="job-type-security">I Need Security</button></div>
					<ul>
						<li>
							<input class="textbox" name="name" required type="text" value="" placeholder="Your Name">
						</li>
						<li>
							<input class="textbox" name="email" required type="email" value="" placeholder="Email Address">
						</li>
						<li>
							<input type="submit" class="submit_btn" name="submit" value="Submit" id="submit_need">
						</li>
					</ul>
				</form>
			</div>
    	</div>
    </div>
</div>
<div class="clearfix"></div>
<div class="jobwrap">
<div class="col1" style="background: url(images/stepbg.jpg) no-repeat;background-size: cover">
	<div class="secjob">
	<h2>Secure that job
works in<br>
3 simple steps</h2>
		</div>
	</div>
	<div class="col2">
		<div class="joindetail">
			<ul>
				<li>
					<div class="icnwrap"><img src="images/JOIN US.svg" alt=""/></div>
					<div class="jcnt">
						<h3>Join us</h3>
						<p>Create your profile in for free in less than 2 minutes</p>
						<a href="login.php" class="btn">Register Now</a>
					</div>
				</li>
						<li>
					<div class="icnwrap"><img src="images/SEARCH.svg" alt=""/></div>
					<div class="jcnt">
						<h3>Search</h3>
						<p>Our search filters will help you to find the best job you need</p>
						<a href="jobs.php" class="btn">Browse Jobs</a>
					</div>
				</li>
						<li>
					<div class="icnwrap"><img src="images/WORK.svg" alt=""/></div>
					<div class="jcnt">
						<h3>Work</h3>
						<p>Get connected with client. Work for client. Get Paid.</p>
						<a href="login.php" class="btn">Connect</a>
					</div>
				</li>
			</ul>
		</div>
	</div>
	
</div>
<div class="aboutwrap">
	<div class="abtleft">
		<div class="abtcnt">
			<h3>About Us</h3>
			<?php 
			$sql='select title,content from tblcmspages where page_id=9';
			$res=mysql_query($sql);
			$fetch=mysql_fetch_array($res);
			$content=$fetch['content'];
			$desc=$content;
			if(strlen($content) > 520)
			{
				
				$desc=substr($content,0,520)." ...";
			}
			?>
			<?php echo $desc; ?>

		</div>
	</div>
	<div class="abtrgt"><img src="images/sec.jpg" alt=""/></div>
</div>
<div class="joinwrap" style="background:url(images/joinwrapbg.jpg) no-repeat;">
<div class="container">
<div class="row">
<div class="text-center col-lg-10 col-lg-offset-1">
	<h2>Reasons to join us</h2>
		<?php 
		$sql='select title,content,page_id from tblcmspages where page_id=14';
		$res=mysql_query($sql);
		$fetch=mysql_fetch_array($res);
		$content=$fetch['content'];
		$desc=$content;
		$page_id=$fetch['page_id'];
		
		if(strlen($content) > 350)
		{
			$desc=substr($content,0,350)." ...";
		}
		?>
		<?php echo $desc; ?>
</div> 
<div class="text-center col-lg-10 col-lg-offset-1">
<ul class="joinlist">
	<li>
		<div class="j_icon"><img src="images/FIND THE RIGHT PERSON.svg" width="35" height="48" alt=""/></div>
		<h4>FIND THE RIGHT PERSON</h4>
	</li>
	<li>
		<div class="j_icon"><img src="images/ATTHERIGHTTIME.svg" width="35" height="48" alt=""/></div>
		<h4>AT THE RIGHT TIME</h4>
	</li>
	<li>
		<div class="j_icon"><img src="images/FINDTHERIGHTPRICE.svg" width="35" height="48" alt=""/></div>
		<h4>FIND THE RIGHT PRICE</h4>
	</li>
	<li>
		<div class="j_icon"><img src="images/RATINGSYSTEM.svg" width="35" height="48" alt=""/></div>
		<h4>RATING SYSTEM</h4>
	</li>
	<li>
		<div class="j_icon"><img src="images/GETPAIDFAST.svg" width="35" height="48" alt=""/></div>
		<h4>GET PAID FAST</h4>
	</li>
</ul>
	<div class="joinbtn"><a class="learnmore"  href="page.php?page_id=<?php echo $page_id; ?>">Learn more</a></div>
			</div>
</div>
</div> 
</div>
<div class="securewrap" style="background: url(images/moneysec.jpg) no-repeat right top">
	<div class="container">
		<div class="row">
			<div class="sec_cnt">
			<div class="col-sm-12">
				<h3>Money is secure</h3>
				<?php 
			$moneysql='select title,content,page_id from tblcmspages where page_id=13';
			$moneyres=mysql_query($moneysql);
			$moneyfetch=mysql_fetch_array($moneyres);
			$moneycontent=$moneyfetch['content'];
			$moneydesc=$moneycontent;
			$page_id=$moneyfetch['page_id'];
			
			if(strlen($moneycontent) > 210)
			{
				
				$moneydesc=substr($moneycontent,0,210)." ...";
			}
			?>
				<?php echo $moneydesc; ?>
			</div>	
			<div class="col-sm-6 subtxt">
				<h4>Insurance</h4>
				<?php 
			$inssql='select title,content,page_id from tblcmspages where page_id=8';
			$insres=mysql_query($inssql);
			$insfetch=mysql_fetch_array($insres);
			$inscontent=$insfetch['content'];
			$insdesc=$inscontent;
			$page_id=$insfetch['page_id'];
			
			if(strlen($inscontent) > 140)
			{
				
				$insdesc=substr($inscontent,0,140)." ...</p>";
			}
			?>
			    <?php echo $insdesc; ?>
				
				<a href="page.php?page_id=<?php echo $page_id; ?>" class="btn">Learn more</a>					
			</div>
			<div class="col-sm-6 subtxt">
				<h4>Disputes</h4>
				<?php 
			$dissql='select title,content,page_id from tblcmspages where page_id=6';
			$disres=mysql_query($dissql);
			$disfetch=mysql_fetch_array($disres);
			$discontent=$disfetch['content'];
			$disdesc=$discontent;
			$page_id=$disfetch['page_id'];
			
			if(strlen($discontent) > 140)
			{
				
				$disdesc=substr($discontent,0,140)."...</p>";
			}
			?>
			   	<?php echo $disdesc; ?>
				<a href="page.php?page_id=<?php echo $page_id; ?>" class="btn">Learn more</a>		
			</div>
			</div>			
		</div>
	</div>
</div>
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