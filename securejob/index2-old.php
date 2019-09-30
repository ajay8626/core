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
 <body>
<!--herder-->
<?php include "header2.php"; ?>
<!--herder and-->
<!--banner-->
<div class="banner-top">
     <div class="container">
		 <div class="banner-text">
		     <h1>Security at your fingertips</h1>
			 <p>The UK's Leading Security Supermarket</p>
		 </div>
		 <div class="search-box">
		 <div class="banner-btn">
		      <ul>
			  <li><a href="#">I need security</a></li>
			  <li><a href="#">I need a job</a></li>
			  <li><a href="#">I NEED TRAINING</a></li>
			  </ul>
		 </div>
		 <div class="search-inner">
		    <input type="text" name="firstname" required=""  class="txt_cnt" placeholder = "What are you looking for?">
			<button class="search-btn">Search</button>
		 </div>
		 </div>
	 </div>
</div>
<!--banner end-->

<!--reasons-banner-->
<div class="reasons-banner">
   <div class="reasons-text">
      <div class="container">
        <h2>Reasons to join us<h2>
	  </div>	
   </div> 
       <div class="container">
   <div class="resons-text">
        <h3>BID FOR WORK FOR THE RIGHT PAY</h3>
		<p>USE OUR BIDDING SYSTEM TO GET THE PAY YOU DESERVE</p>
   </div> 
   <div class="reasons-list">
       <ul>
	    <li class="icon1">
		<a href="#">
		<div class="list-item">
		     <div class="list-img">
			   
			 </div>
			 <div class="list-text">
			    <p>Bid for work at<br>the right pay</p>
			 </div>
		</div>
		</a>
		</li>
		
		 <li class="icon2">
		<a href="#">
		<div class="list-item">
		     <div class="list-img">
			 </div>
			 <div class="list-text">
			    <p>Find the<br> right person</p>
			 </div>
		</div>
		</a>
		</li>
		
		
		 <li class="icon3">
		<a href="#">
		<div class="list-item">
		     <div class="list-img">
			 </div>
			 <div class="list-text">
			    <p>Secure work<br> last minute</p>
			 </div>
		</div>
		</a>
		</li>
		
			 <li class="icon4">
		<a href="#">
		<div class="list-item">
		     <div class="list-img">
			 </div>
			 <div class="list-text">
			    <p>Your money<br> is secure</p>
			 </div>
		</div>
		</a>
		</li>
		
		
			 <li class="icon5">
		<a href="#">
		<div class="list-item">
		     <div class="list-img">
			 </div>
			 <div class="list-text">
			    <p>Rating system to
                 improve your
                 reputation
				 </p>
			 </div>
		</div>
		</a>
		</li>
		
	<li class="icon6">
		<a href="#">
		<div class="list-item">
		     <div class="list-img">
			 </div>
			 <div class="list-text">
			    <p>All members<br> are verified </p>
			 </div>
		</div>
		</a>
		</li>
		
				
	<li class="icon7">
		<a href="#">
		<div class="list-item">
		     <div class="list-img">
			 </div>
			 <div class="list-text">
			    <p>Dispute <br>resolutions</p>
			 </div>
		</div>
		</a>
		</li>
	   </ul>
   </div> 
   	  <a href="login.php" class="btn1">JOIN FOR FREE</a>
   </div>    
   
</div>


<!--TRAINING-->
<div class="training-course">
     <div class="container">
	      <h4>NEED A SECURITY LICENSE OR TRAINING COURSE?</h4>
		   <a href="course.php" class="btn1">FIND A COURSE</a>
	 </div>
</div>
<!--TRAINING and-->

<!--CATEGORIES-->
<div class="categories">
       <div class="container">
	     <div class="row">
			   <div class="categories-title">
					<h5>SECURITY CATEGORIES</h5>
			   </div>
			   <div class="categories-box">
			       <div class="col-md-12 col-sm-12">
				       <div class="categories-list">
					       <ul>
					       	 <?php 
						 $sql=mysql_query("select category_id,category_name from tblcategory where isactive=1 order by category_name");
						 $rows=mysql_num_rows($sql);
						 if($rows > 0)
						 {
							 while($catdata=mysql_fetch_array($sql))
							 {
						 ?>
						   <li><a href="javascript:void(0)"><?php echo $catdata['category_name']; ?></a></li>
						   <?php
						}
					}
					?>
						   <!-- <li><a href="#">Bailiff</a></li>
						   <li><a href="#">Cash In Transit(CVIT)</a></li>
						   <li><a href="#">CCTV Operator</a></li>
						   <li><a href="#">Close Protection</a></li>
						   <li><a href="#">Concierge</a></li>
						   <li><a href="#">Cyber Security</a></li>
                           <li><a href="#">Dog Handling</a></li>
						   <li><a href="#">Door Supervisor</a></li>
						   <li><a href="#">Security Guard</a></li>
						   <li><a href="#">Drone Flyers</a></li>
						   <li><a href="#">Fire</a></li>
						   <li><a href="#">Key Holding</a></li>
						   <li><a href="#">Locksmith</a></li> -->
						   </ul>
					   </div>
				   </div>
				     
				      
				   
			   </div>
		  </div> 
	   </div>
</div>

<!--CATEGORIES and-->




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