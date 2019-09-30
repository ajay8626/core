<?php
include "config.php";
//include "check_user_login.php";
$course_id=isset($_REQUEST['course_id']) && $_REQUEST['course_id']!='' ? $_REQUEST['course_id'] : 0;
$user_id=isset($_SESSION['user_id']) && $_SESSION['user_id']!='' ? $_SESSION['user_id'] : 0;
$coursedetails=mysql_query("select * from tblcourse where course_id='".$course_id."'");
$rowcount=mysql_num_rows($coursedetails);

$userdetails=mysql_query("select * from tbluser where user_id='".$user_id."'");
$rowcount1=mysql_num_rows($userdetails);

$currentURL = 'http://'. $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

if($rowcount == 0)
{
	echo '<script> alert("Invalid Course Id."); window.location.href="course.php";</script>';
}
if($course_id==0)
{
	echo '<script> alert("Invalid Course Id."); window.location.href="course.php";</script>';
}

// gets the user IP Address
$user_ip=$_SERVER['REMOTE_ADDR'];

$check_ip = mysql_query("SELECT userip FROM tblpageview WHERE job_id='$job_id' and userip='$user_ip'");
if(mysql_num_rows($check_ip)>=1)
{
  
}
else
{
  $insertview = mysql_query("INSERT INTO tblpageview (job_id, userip) VALUES('".$job_id."', '".$user_ip."')");
  $updateview = mysql_query("UPDATE tbltotalview SET totalvisit = totalvisit+1 WHERE job_id='".$job_id."' ");
}


if($rowcount > 0)
{
	$coursedata=mysql_fetch_array($coursedetails);
	//$course_id=$coursedata['course_id'];
	$course_name=$coursedata['name'];
	$course_description=$coursedata['description'];
	$course_image=$coursedata['image'];
	$price=$coursedata['price'];
	$course_time=$coursedata['course_time'];
	$course_days=$coursedata['course_days'];
	$job_hours=$coursedata['job_hours'];
	$start_date=$coursedata['start_date'];
	$latitude=$coursedata['latitude'];
	$longitude=$coursedata['longitude'];
	$address1=$coursedata['address1'];
	$address2=$coursedata['address2'];
	$country_id=$coursedata['country_id'];
	$state_id=$coursedata['state_id'];
	$city_id=$coursedata['city_id'];
	$riskmeter=$coursedata['riskmeter'];
	$transport_link=$coursedata['transport_link'];
	$dresscode=$coursedata['dresscode'];
	$created_date=$coursedata['created_date'];
	$isfeatured=$coursedata['isfeatured'];
	$status=$coursedata['status'];
	$opening_position=$coursedata['opening_position'];
	$course_location=$coursedata['course_location'];
	$opening_type=$coursedata['opening_type'];
	$duration_in=$coursedata['duration_in'];
	$job_status=$coursedata['job_status'];
	$payment_status=$coursedata['payment_status'];
		
}
else
{
	//$course_id='';
	$job_name='';
	$course_description='';
	$course_image='';
	$price='';
	$course_time='';
	$course_days='';
	$job_hours='';
	$start_date='';
	$latitude='';
	$longitude='';
	$address1='';
	$address2='';
	$country_id='';
	$state_id='';
	$city_id='';
	$riskmeter='';
	$transport_link='';
	$dresscode='';
	$created_date='';
	$isfeatured='';
	$status='';
	$opening_position='';
	$course_location='';
	$opening_type='';
	$duration_in='';
	$job_status='';
	$payment_status='';
	$coursecategory='';
	$willingtopay='';
	$risk_txt='';
	$totalhours=0;
}

if($rowcount1 > 0)
{
	$userdata=mysql_fetch_array($userdetails);
	$firstname=$userdata['firstname'];
	$lastname=$userdata['lastname'];
	$email=$userdata['email'];
	
}
else
{
	$firstname='';
	$lastname='';
	$email='';

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
<title>Course Details - SECURE THAT JOB</title>

<!-- Bootstrap -->
<link href="https://fonts.googleapis.com/css?family=Fira+Sans:300,400,400i,500,600,700,800" rel="stylesheet"> 
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link href="css/ddsmoothmenu.css" rel="stylesheet">
<link href="css/owl.carousel.css" rel="stylesheet">
<link href="css/owl.theme.css" rel="stylesheet">
<link href="css/jquery.fancybox.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">
<link href="fonts/font-awesome.css" rel="stylesheet">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.bxslider.js"></script>
<script type="text/javascript" src="js/menu.js"></script>
<script type="text/javascript" src="js/owl.carousel.js"></script>
<script type="text/javascript" src="js/jquery.fancybox.js"></script>
<script type="text/javascript" src="js/at-jquery.js"></script>
<!-- <script src="//code.jquery.com/jquery.min.js"></script> -->
<style>
#map{
	height: 450px;
	float: left;
}
</style>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({includedLanguages: '<?php echo LanguageList; ?>', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script>

<script>
    jQuery(document).ready(function($) {
     
		$(".a_bid_pop").fancybox();
		
      var sync1 = $("#sync1");
      var sync2 = $("#sync2");
     
      sync1.owlCarousel({
        singleItem : true,
        slideSpeed : 1000,
        navigation: false,
        pagination:false,
        afterAction : syncPosition,
        responsiveRefreshRate : 200,
      });
     
      sync2.owlCarousel({
        items : 5,
        itemsDesktop      : [1199,5],
        itemsDesktopSmall     : [979,3],
        itemsTablet       : [768,3],
        itemsMobile       : [479,3],
        pagination:false,
        responsiveRefreshRate : 100,
        afterInit : function(el){
          el.find(".owl-item").eq(0).addClass("synced");
        }
      });
     
      function syncPosition(el){
        var current = this.currentItem;
        $("#sync2")
          .find(".owl-item")
          .removeClass("synced")
          .eq(current)
          .addClass("synced")
        if($("#sync2").data("owlCarousel") !== undefined){
          center(current)
        }
      }
     
      $("#sync2").on("click", ".owl-item", function(e){
        e.preventDefault();
        var number = $(this).data("owlItem");
        sync1.trigger("owl.goTo",number);
      });
     
      function center(number){
        var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
        var num = number;
        var found = false;
        for(var i in sync2visible){
          if(num === sync2visible[i]){
            var found = true;
          }
        }
     
        if(found===false){
          if(num>sync2visible[sync2visible.length-1]){
            sync2.trigger("owl.goTo", num - sync2visible.length+2)
          }else{
            if(num - 1 === -1){
              num = 0;
            }
            sync2.trigger("owl.goTo", num);
          }
        } else if(num === sync2visible[sync2visible.length-1]){
          sync2.trigger("owl.goTo", sync2visible[1])
        } else if(num === sync2visible[0]){
          sync2.trigger("owl.goTo", num-1)
        }
        
      }
     
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
<?php include "header-inner.php"; ?>
<div class="stj_abt_wrap">
	<div class="container">
		<div class="row">
			
			<div class="col-xs-12 col-md-10 stj_bid">
				<div class="stj_bid_wrap">
					
					<div class="stj_bid_top">
						<div class="stj_bdt_lft">
							<div class="stj_bid_slider">
								<?php 
								if($course_image !=''){
								?>
									<!-- Main Large Images -->
									<div id="sync1" class="owl-carousel">
										<div class="item"><img src="<?php echo COURSE_IMG_URL.$course_image;?>" alt=""/></div>
									</div>
								
								<?php 
								}else{
								?>
								
									<!-- If no Image, Dummy Image -->
									<div id="sync1" class="owl-carousel">
										<div class="item"><img src="images/bd.jpg" alt=""/></div>
									</div>

								<?php 
								} 
								?>
								
								<div class="stj_bdt_rgt stj_bdt_rgt_imp">
								<h4 class="key_details_hd">KEY DETAILS</h4>
								<ul>
									<li>Duration: <span><?php if($course_days!=''){?> <?php echo $course_days; } ?></span></li>
                                    <li>Time: <span><?php if($course_time!=''){?> <?php echo $course_time; } ?></span></li>
									<li>Start Date: <span><?php if($start_date!=''){ ?> <?php echo date('d/m/Y',strtotime($start_date)); ?> <?php } ?></span></li>
									<?php if($course_location!=''){ ?><li>Location: <span><?php echo $course_location; ?></span></li><?php } ?>
								</ul>
								</div>

							</div>
							<div class="stj_bid_side_con">
								<h2><?php echo $course_name; ?></h2>
								<hr>
								<h3>Amount Willing to pay</h3>
								<div class="price"><?php if($price!=0 && $price!=''){ ?>£<?php echo number_format($price,2); ?><?php } ?></div>
								
                                <?php if(isset($_SESSION['user_id'])) {?>
								<div class="bid_btn">
									<a class="a_bid_pop_old" href="#" data-toggle="modal" data-target="#addCredites">Apply for course</a>
								</div>
                                <?php } else { ?>
                                 <div class="bid_btn">
									<a class="" href="login.php">Apply for course</a>
								</div>   
                                <?php } ?>
                                
                            </div>
						</div>
						<!-- Modal Area Start -->
						<?php 
							$fee_sql = mysql_query("SELECT title, content FROM tblcmspages WHERE page_id=10");
							$fees_row = mysql_fetch_array($fee_sql);
						?>
						<div class="modal fade" id="termsCondition">
							<div class="modal-dialog modal-dialog-centered">
							<div class="modal-content">
							
								<!-- Modal Header -->
								<div class="modal-header">
								<h4 class="modal-title"><?php echo $fees_row['title']; ?></h4>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								</div>
								
								<!-- Modal body -->
								<div class="modal-body">
								<?php echo $fees_row['content']; ?>
								</div>
								
								<!-- Modal footer -->
								<div class="modal-footer">
								<button type="button" class="btn fees-modal-button" data-dismiss="modal">Close</button>
								</div>
								
							</div>
							</div>
						</div>
						<!-- Modal Area Ends -->
						<div class="stj_bdt_rgt">
							<div class="stj_bdt_rgt_iframe">
							<h4>Location</h4>
								<p><?php echo $course_location; ?></p>
								<div id="map"></div>
							</div>
						</div>
						<div class="stj_bid_descp social_ico">
							<h2>Description</h2>
							<p><?php echo strip_tags($course_description); ?></p>
							
							<h5>Share this course: </h4>
							<!-- Facebook -->
							<a href="<?php echo $currentURL; ?>" class="share facebook fa fa-facebook"></a>

							<!-- Google Plus -->
							<a href="<?php echo $currentURL; ?>" class="share google-plus fa fa-google"></a>

							<!-- Twitter -->
							<a href="<?php echo $currentURL; ?>" data-text="" class="share twitter fa fa-twitter"></a>

							<!-- LinkedIn -->
							<a href="<?php echo $currentURL; ?>"  data-text=""  class="share linkedin fa fa-linkedin"></a>

						</div>
					</div>
                    
                    
                    <!-- Modal Area Start (Add Credits) -->
				<?php 
					$fee_sql = mysql_query("SELECT title, content FROM tblcmspages WHERE page_id=11");
					$fees_row = mysql_fetch_array($fee_sql);
				?>
				<div class="modal fade addCredites_cls" id="addCredites">
					<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
					
						<!-- Modal Header -->
						<h2 class="modal-title">Course Payment</h2>
						<!-- <div class="modal-header">
						<h4 class="modal-title">Add Credit</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div> -->
						
						<!-- Modal body -->
						<div class="modal-body paypal_btn">
						
						<!-- Directly Pay with Credit -->
							<!-- Add Credit -->
							<form action="paypal/payments.php" method="post" id="paypal_form" target="_blank">
                                <label for="firstname" style="display:block">First Name</label>
                                <input type="text" name="firstname" value="<?php echo $firstname; ?>"  />
                                <label for="lastname" style="display:block">Last Name</label>
								<input type="text" name="lastname" value="<?php echo $lastname; ?>"  />
                                <label for="email" style="display:block">Email</label>
								<input type="text" name="email" value="<?php echo $email; ?>"  />
								<input type="hidden" name="cmd" value="_xclick" />
								<input type="hidden" name="no_note" value="1" />
								<input type="hidden" name="lc" value="UK" />
								<input type="hidden" name="currency_code" value="GBP" />
								<input type='hidden' name='rm' value='2'>
								<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
                                <input type="hidden" name="amount" value="<?php echo $price; ?>"  />
                                <input type="hidden" name="item_name" value="<?php echo $course_name; ?>" / >
								<input type="hidden" name="item_number" value="<?php echo $course_id; ?>" / >
								<input type="hidden" name="user_id" value="<?php echo $user_id ?>" / >
								<input type="hidden" name="custom" value="course_payment_with_paypal" / >
                                <br>
                                <br>
								<input type="submit" name="paypal" class="add_credit_btn" value="Pay with Paypal"/>
							</form>
						</div>
						
						<!-- Modal footer -->
						<div class="modal-footer">
						<button type="button" class="btn fees-modal-button" data-dismiss="modal">Close</button>
						</div>
						
					</div>
					</div>
				</div>
				<!-- Modal Area Ends (Add Credits) -->
                    
					
                    <?php /*
					<div class="stj_bid_btm">
						<h2>View Bidding Details Below</h2>
						<ul>
							<li>Opening Positions: <span><?php echo $opening_position; ?></span></li>
							<li>Filled Positions: <span><?php echo $total_persons; ?></span></li>
							<li>Vacant Positions: <span><?php echo $vacantposition; ?></span></li>
						</ul>
						<div class="bid_table">
							<table border="0" cellpadding="0" cellspacing="0">
								<tr>
									<th>Bidders</th>
									<th>Date</th>
									<th style="width:150px;">BidAmount<span>(Per Pr. Per Hr)</span></th>
									<th>No. Of Persons</th>
									<th>Total Amount</th>
									<th>Winner</th>
									<th></th>
								</tr>
						<?php 
						
						$jobapplied=mysql_query("select user.user_id,user.firstname,user.lastname,job.job_name,jobapply.* from tbljobsapplied as jobapply inner join tbljobs as job on jobapply.job_id = job.job_id
                        inner join tbluser as user on user.user_id = jobapply.user_id WHERE jobapply.job_id =".$job_id." and jobapply.user_id!=".$user_id." group by jobapply.user_id order by jobapply.applied_date desc");
						$jobappliedcount=mysql_num_rows($jobapplied);
						  if($jobappliedcount > 0)
						  {
							  while($jobapp=mysql_fetch_array($jobapplied))
							  {
								  $total_amount = $jobapp['bidprice'] * $jobapp['no_of_persons'] * $job_days * $job_hours;
						?>		
								<tr>
									<td><a href="javascript:void(0);"><?php echo $jobapp['firstname'];?> <?php echo $jobapp['lastname']; ?></a></td>
									<td><?php echo date('d/m/Y',strtotime($jobapp['applied_date'])) ?></td>
									<td>£<?php echo $jobapp['bidprice']; ?></td>
									<td><?php echo $jobapp['no_of_persons']; ?></td>
									<td>£<?php echo number_format($total_amount, 2); ?></td>
									<td><?php if($jobapp['is_winner']==1){ ?> <span class="winner_col">Winner</span> <?php } ?></td>
									<td>
										<ul>
										   <li><img src="images/star.png" alt=""/></li>
										   <li><img src="images/star.png" alt=""/></li>
										   <li><img src="images/star.png" alt=""/></li>
										   <li><img src="images/star.png" alt=""/></li>
										   <li><img src="images/star-tr.png" alt=""/></li>
									    </ul>
									</td>
								</tr>
						<?php
						   }
                        } 
                        ?>						
								<?php 
								   $jobapplieduser=mysql_query("select user.user_id,user.firstname,user.lastname,job.job_name,jobapply.* from tbljobsapplied as jobapply inner join tbljobs as job on jobapply.job_id = job.job_id
                        inner join tbluser as user on user.user_id = jobapply.user_id WHERE jobapply.job_id =".$job_id." and jobapply.user_id=".$user_id." group by jobapply.user_id order by jobapply.applied_date desc");
						$jobappliedusercount=mysql_num_rows($jobapplieduser);
						        if($jobappliedusercount > 0)
								{
									while($applieddata=mysql_fetch_array($jobapplieduser))
									{
										$total_amount1=$applieddata['bidprice'] * $applieddata['no_of_persons'] * $job_days * $job_hours;
								?>
								<tr>
									<td><a href="javascript:void(0);">Your bid</a></td>
									<td><?php echo date('d/m/Y',strtotime($applieddata['applied_date'])) ?></td>
									<td>£<?php echo $applieddata['bidprice']; ?></td>
									<td><?php echo $applieddata['no_of_persons']; ?></td>
									<td>£<?php echo $total_amount1; ?></td>
									<td><?php if($applieddata['is_winner']==1){ ?> <span class="winner_col">Winner</span> <?php } ?></td>
									<td>
										<ul>
										   <li><img src="images/star.png" alt=""/></li>
										   <li><img src="images/star.png" alt=""/></li>
										   <li><img src="images/star.png" alt=""/></li>
										   <li><img src="images/star.png" alt=""/></li>
										   <li><img src="images/star-tr.png" alt=""/></li>
									    </ul>
									</td>
								</tr>
								<?php } 
								}
								?>
							</table>
						</div>
					</div>
                    */ ?>
					
				</div>
			</div>
			
			<?php include "advert-section.php"; ?>
			
		</div>
	</div>
</div>
<script>

function initMap() {
  var myLatLng = {lat: <?php echo $latitude; ?>, lng: <?php echo $longitude; ?>};

  var map = new google.maps.Map(document.getElementById('map'), {
	zoom: 15,
	center: myLatLng
  });

  var marker = new google.maps.Marker({
	position: myLatLng,
	map: map,
	title: 'Job Location'
  });
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_JUu2G9vlijX1UgNTylx55U1hZQqw6QI&callback=initMap" async defer></script>
<?php include "footer.php"; ?>
</body>
</html>