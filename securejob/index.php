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

<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' />
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
<script src="js/rTabs.js" type="text/javascript"></script>

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
			  <li><a href="javascript:void(0);" id="security" class="active">I need security</a></li>
			  <li><a href="javascript:void(0);" id="job">I need a job</a></li>
			  <li><a href="javascript:void(0);" id="training">I NEED TRAINING</a></li>
			  </ul>
		 </div>
		 <div class="search-inner">
		 	<form method="post" action="new-request.php" id="search_form">
		    <input type="text" name="home_search"  required="required"  class="txt_cnt" placeholder = "What are you looking for?">
			<button class="search-btn">Search</button>
			</form>
		 </div>
		 </div>
	 </div>
</div>
<!--banner end-->
<script type="text/javascript">
	$( document ).ready(function() {
		$( ".banner-btn ul li" ).click(function() {
    		var myid = $(".banner-btn ul li").find('a.active').attr('id');
    		if (myid  == 'job') {
    			$(".search-inner form#search_form").attr("action","jobs.php");
    		}
    		if (myid  == 'training') {
    			$(".search-inner form#search_form").attr("action","newcourse.php");
    		}
    		if (myid  == 'security') {
    			$(".search-inner form#search_form").attr("action","new-request.php");
    		}			
		});
	});
</script>




<div class="clearfix"></div>
<!--reasons-banner-->
<div class="reasons-banner">
   <div class="reasons-text">
        <h2>Reasons to join us</h2>
	</div>
<div class="tab_container tab" id="tab4">
  <div class="tab-con">
         <div class="j-tab-con">
             <div class="resons-text tab-con-item" style="background:url(images/tab1.jpg);background-size:cover;display:block;">
        <h3>BID FOR WORK FOR THE RIGHT PAY</h3>
		<p>USE OUR BIDDING SYSTEM TO GET THE PAY YOU DESERVE</p>
   </div> 
    <div class="resons-text  tab-con-item" style="background:url(images/tab2.jpg);background-size:cover;">
        <h3>FIND THE RIGHT PERSON</h3>
		<p>USE US TO FIND THE PERFECT JOB OR THE IDEAL CANDIDATE TO WORK FOR YOU</p>
   </div> 
    <div class="resons-text  tab-con-item" style="background:url(images/tab3.jpg);background-size:cover;">
        <h3>SECURE WORK LAST MINUTE</h3>
		<p>NEED SOMEONE FAST? POST WORK OR FIND A JOB WITH OUR LIVE BOOKING SYSTEM</p>
   </div> 
   <div class="resons-text  tab-con-item" style="background:url(images/tab4.jpg);background-size:cover;">
        <h3>YOUR MONEY IS SECURE & PAID FAST</h3>
		<p>ALL FUNDS ARE HELD BY PAYPAL AND RELEASED INSTANTLY ONCE WORK IS COMPLETE</p>
   </div>
   <div class="resons-text  tab-con-item" style="background:url(images/tab5.jpg);background-size:cover;">
        <h3>RATING SYSTEM TO IMPROVE YOUR REPUTATION</h3>
		<p>
OUR RATING SYSTEM ACCURATELY MONITORS PERFORMANCE SO YOU CAN PICK PEOPLE WITH A GOOD REPUTATION</p>
   </div> 
   <div class="resons-text  tab-con-item" style="background:url(images/tab6.jpg);background-size:cover;">
        <h3>ALL MEMBERS ARE VERIFIED</h3>
		<p>OUR SCREENING AND VERIFICATION PROCESS ASSURES THAT OUR MEMBERS ARE REAL AND WHO THEY SAY THEY ARE</p>
   </div> 
   <div class="resons-text  tab-con-item" style="background:url(images/tab7.jpg);background-size:cover;">
        <h3>DISPUTE RESOLUTION</h3>
		<p>OUR TEAM IS COMMITTED TO HELP RESOLVE ANY ISSUES. WE ALSO WORK WITH PAYPAL DISPUTE RESOLUTION CENTRE</p>
   </div>     
         </div>
  </div>
   
   
<div class="container reasons-box">
   <div class="reasons-list tab-nav j-tab-nav">
		<a href="javascript:void(0);" class="current icon1">
		<div class="list-item">
		     <div class="list-img">
			   
			 </div>
			 <div class="list-text">
			    <p>Bid for work at<br>the right pay</p>
			 </div>
		</div>
		</a>
		
		<a href="javascript:void(0);" class="icon2">
		<div class="list-item">
		     <div class="list-img">
			 </div>
			 <div class="list-text">
			    <p>Find the<br> right person</p>
			 </div>
		</div>
		</a>
		
		
		<a href="javascript:void(0);" class="icon3">
		<div class="list-item">
		     <div class="list-img">
			 </div>
			 <div class="list-text">
			    <p>Secure work<br> last minute</p>
			 </div>
		</div>
		</a>
		
		<a href="javascript:void(0);" class="icon4">
		<div class="list-item">
		     <div class="list-img">
			 </div>
			 <div class="list-text">
			    <p>Your money<br> is secure</p>
			 </div>
		</div>
		</a>
		
		
	<a href="javascript:void(0);" class="icon5">
		<div class="list-item">
		     <div class="list-img">
			 </div>
			 <div class="list-text">
			    <p>Rating system to<br>
                 improve your<br>
                 reputation
				 </p>
			 </div>
		</div>
		</li>
		
    <a href="javascript:void(0);" class="icon6">
		<div class="list-item">
		     <div class="list-img">
			 </div>
			 <div class="list-text">
			    <p>All members<br> are verified </p>
			 </div>
		</div>
		</a>
		
				
			<a href="javascript:void(0);" class="icon7">
		<div class="list-item">
		     <div class="list-img">
			 </div>
			 <div class="list-text">
			    <p>Dispute <br>resolutions</p>
			 </div>
		</div>
		</a>


   </div> 
   	  <a href="login.php" class="btn1">JOIN FOR FREE</a>
   </div>  
  </div> 
  
   
</div>

<!--TRAINING-->
<div class="training-course">
     <div class="container">
	      <h4>NEED A SECURITY LICENSE OR TRAINING COURSE?</h4>
		   <a href="newcourselist.php" class="btn1">FIND A COURSE</a>
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
<script type="text/javascript">
/*$(document).ready(function() {

	//When page loads...
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content

	//On Click Event
	$("ul.tabs li").click(function() {

		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active ID content
		return false;
	});

});*/
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>
<script>
$(document).ready(function(){
  $('.banner-btn ul li a').click(function(){
    $('.banner-btn ul li a').removeClass("active");
    $(this).addClass("active");
});
});
</script>
<script type="text/javascript">
            $(function() {
                $("#tab4").rTabs({
                    bind : 'hover',
                    animation : 'fadein'
                });

            })
</script>
</html>