<?php 
include "config.php"; 
$qry='';
$searchtxt='';
if(isset($_POST['search_txt']) && $_POST['search_txt']!='')
{
	$searchtxt=$_POST['search_txt'];
	$qry=" and (question like '%".$searchtxt."%' OR answer like '%".$searchtxt."%') ";
}

$sql=mysql_query("select * from tblfaqmaster where isactive=1 ".$qry." order by sortorder asc Limit 35");
$no=mysql_num_rows($sql);
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
<title>Frequently Asked Questions - SECURE THAT JOB</title>

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
<script type="text/javascript" src="js/ddaccordion.js"></script>
<script type="text/javascript" src="js/at-jquery.js"></script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({includedLanguages: '<?php echo LanguageList; ?>', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script>
<script type="text/javascript">
ddaccordion.init({
	headerclass: "submenuheader", 
	contentclass: "submenu ", 
	revealtype: "click", 
	mouseoverdelay: 200, 
	collapseprev: true, 
	defaultexpanded: [0],
	onemustopen: false, 
	animatedefault: false,
	persiststate: false, 
	toggleclass: ["", "openHeader"], 	
	animatespeed: "fast", 
	oninit:function(headers, expandedindices){},
	onopenclose:function(header, index, state, isuseractivated){}
})
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
<!--
<div class="header inner_header">
  <div class="container"> 
      <div class="logo"><a href="#"><img class="img-responsive" src="images/logo.png"></a></div>
      <div class="navigation"> <a href="#" class="lines-button x2"><span class="lines"></span></a>
        <div class="main_menu">
          <ul class="firstul">
           <li class="current_page_item"><a href="#">Home</a></li>
            <li><a href="#">Search jobs</a></li>
            <li><a href="#">post jobs</a>
              <ul>
                <li><a href="#">submenu1</a></li>
                <li><a href="#">submenu1</a>
                  <ul>
                    <li><a href="#">submenu1</a></li>
                    <li><a href="#">submenu1</a></li>
                    <li><a href="#">submenu1</a></li>
                    <li><a href="#">submenu1</a></li>
                    <li><a href="#">submenu1</a></li>
                  </ul>
                </li>
                <li><a href="#">submenu1</a></li>
                <li><a href="#">submenu1</a></li>
                <li><a href="#">submenu1</a></li>
                <li><a href="#">submenu1</a></li>
              </ul>
            </li>
            <li><a href="#">courses</a></li>
          </ul>
        </div>
        <div class="loginlik"><a href="#">Login/Register</a></div>
        <div class="selectdrpdwn">
        	<select>
        		<option>EN</option>
        		<option>FR</option>        		
        	</select> 
        </div>
      </div> 
  </div>
</div>-->

<div class="stj_abt_wrap stj_faq_wrap">
	<div class="container">
		<div class="row">
			
			<div class="col-xs-12 col-md-10 stj_about_inn">
				<h2>Frequently Asked Questions</h2>
				
				<div class="stj_faq_dv">
				
					<div class="faq_srch">
						<div class="faq_srch_inn">
						    <form method="post" name="faq" action="">
							<input type="text" name="search_txt" value="<?php echo $searchtxt; ?>" class="txt_faq" placeholder="Search Here your Question..." />
							<input type="submit" name="search" class="btn_faq" value="Go" />
							</form>
						</div>
					</div>
					
					<div class="faq_points">
						<div class="faq_accordian">
						<?php 
                          
						  if($no > 0)
						  {
							  while($rows=mysql_fetch_array($sql))
							  {
						?>
						   <div class="faq_accordian_inn">
								 <a headerindex="0h" class="menuitem submenuheader" href="#"><?php echo $rows['question']; ?></a>
								 <div style="display: none;" contentindex="0c" class="submenu">
								 	<?php echo $rows['answer']; ?>
								 </div>
							</div>
						
							  <?php }
						  } else {
						  ?>
						  <div><center><h3>No Faq's Available</h3></center></div>
						  <?php } ?>
							<!--
							<div class="faq_accordian_inn">
								 <a headerindex="0h" class="menuitem submenuheader" href="#">Lorem ipsum dolor sit amet, consecttetur adipiscing elit. Suspendisse</a>
								 <div style="display: none;" contentindex="0c" class="submenu">
								 	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
								 </div>
							</div>-->
							<!--<div class="faq_accordian_inn">
								 <a headerindex="0h" class="menuitem submenuheader" href="#">Lorem ipsum dolor sit amet, consecttetur adipiscing elit.</a>
								 <div style="display: none;" contentindex="0c" class="submenu">
								 	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
								 </div>
							</div>-->
							<!--<div class="faq_accordian_inn">
								 <a headerindex="0h" class="menuitem submenuheader" href="#">Lorem ipsum dolor sit amet, consecttetur adipiscing elit.</a>
								 <div style="display: none;" contentindex="0c" class="submenu">
								 	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
								 </div>
							</div>-->
							<!--<div class="faq_accordian_inn">
								 <a headerindex="0h" class="menuitem submenuheader" href="#">Lorem ipsum dolor sit amet, consecttetur adipiscing elit.</a>
								 <div style="display: none;" contentindex="0c" class="submenu">
								 	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
								 </div>
							</div>-->
							<!--<div class="faq_accordian_inn">
								 <a headerindex="0h" class="menuitem submenuheader" href="#">Lorem ipsum dolor sit amet, consecttetur adipiscing elit.</a>
								 <div style="display: none;" contentindex="0c" class="submenu">
								 	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
								 </div>
							</div>-->
							<!--<div class="faq_accordian_inn">
								 <a headerindex="0h" class="menuitem submenuheader" href="#">Lorem ipsum dolor sit amet, consecttetur adipiscing elit.</a>
								 <div style="display: none;" contentindex="0c" class="submenu">
								 	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
								 </div>
							</div>-->
							<!--<div class="faq_accordian_inn">
								 <a headerindex="0h" class="menuitem submenuheader" href="#">Lorem ipsum dolor sit amet, consecttetur adipiscing elit.</a>
								 <div style="display: none;" contentindex="0c" class="submenu">
								 	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
								 </div>
							</div>-->
							<!--<div class="faq_accordian_inn">
								 <a headerindex="0h" class="menuitem submenuheader" href="#">Lorem ipsum dolor sit amet, consecttetur adipiscing elit.</a>
								 <div style="display: none;" contentindex="0c" class="submenu">
								 	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse dapibus, enim a hendrerit consequat, ante risus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
								 </div>
							</div>-->
						</div>
					</div>
					
				</div>
				
			</div>
			<?php include "advert-section.php"; ?>
			<!--
			<div class="col-xs-12 col-md-2 stj_brc">
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
<!-- 
<div class="footer">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
       <div class="flogo"><img src="images/footerlogo.png" alt=""/></div>
      </div>
      <div class="col-md-9">
        <div class="footermenu">
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Search jobs</a></li>
            <li><a href="#">post jobs</a></li>
            <li><a href="#">courses</a></li>
            <li><a href="#">Login/Register</a></li>
            <li><a href="#">Contact Us</a></li>
          </ul>
        </div>
        <div class="copyright">(c) 2018 <a href="#">Securethatjob.com</a> | Web Development by <a href="#">MGT Design</a></div>
        <div class="social">
        	<a href="#"><i class="fa fa-facebook"></i></a>
        	<a href="#"><i class="fa fa-twitter"></i></a>
        	<a href="#"><i class="fa fa-instagram"></i></a>
        </div>
      </div>
    </div>
  </div>
</div>--> 
</body>
</html>