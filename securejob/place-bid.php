<?php
include "config.php";
include "check_user_login.php";
$job_id=isset($_REQUEST['job_id']) && $_REQUEST['job_id']!='' ? $_REQUEST['job_id'] : 0;
$user_id=isset($_SESSION['user_id']) && $_SESSION['user_id']!='' ? $_SESSION['user_id'] : 0;
$jobdetails=mysql_query("select * from tbljobs where job_id='".$job_id."'");
$rowcount=mysql_num_rows($jobdetails);
$currentURL = 'http://'. $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

if($rowcount == 0)
{
	echo '<script> alert("Invalid Job Id."); window.location.href="jobs.php";</script>';
}
if($job_id==0)
{
	echo '<script> alert("Invalid Job Id."); window.location.href="jobs.php";</script>';
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
	$jobdata=mysql_fetch_array($jobdetails);
	$job_user_id=$jobdata['job_user_id'];
	$job_name=$jobdata['job_name'];
	$job_description=$jobdata['job_description'];
	$price=$jobdata['price'];
	$job_days=$jobdata['job_days'];
	$job_hours=$jobdata['job_hours'];
	$start_date=$jobdata['start_date'];
	$latitude=$jobdata['latitude'];
	$longitude=$jobdata['longitude'];
	$address1=$jobdata['address1'];
	$address2=$jobdata['address2'];
	$country_id=$jobdata['country_id'];
	$state_id=$jobdata['state_id'];
	$city_id=$jobdata['city_id'];
	$riskmeter=$jobdata['riskmeter'];
	$transport_link=$jobdata['transport_link'];
	$dresscode=$jobdata['dresscode'];
	$created_date=$jobdata['created_date'];
	$isfeatured=$jobdata['isfeatured'];
	$status=$jobdata['status'];
	$opening_position=$jobdata['opening_position'];
	$job_location=$jobdata['job_location'];
	$postalcode=$jobdata['postalcode'];
	$job_type=$jobdata['job_type'];
	if($job_type=1){
		$job_type_text = "Part Time";
	}elseif($job_type=2){
		$job_type_text = "Full Time";
	}
	$opening_type=$jobdata['opening_type'];
	$duration_in=$jobdata['duration_in'];
	$job_status=$jobdata['job_status'];
	$payment_status=$jobdata['payment_status'];
	$jobcategory=jobcatlist($job_id);
	$willingtopay=$price * $job_days * $opening_position * $job_hours;
	$totalhours=$job_days * $opening_position * $job_hours;
	
	$risk_txt='';
	if(isset($riskmeter) && $riskmeter==1)
	{
		$risk_txt='Low';
	}
	if(isset($riskmeter) && $riskmeter==2)
	{
		$risk_txt='Medium';
	}
	if(isset($riskmeter) && $riskmeter==3)
	{
		$risk_txt='High';
	}
	if(isset($riskmeter) && $riskmeter==4)
	{
		$risk_txt='Very High';
	}
	
}
else
{
	$job_user_id='';
	$job_name='';
	$job_description='';
	$price='';
	$job_days='';
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
	$job_location='';
	$opening_type='';
	$duration_in='';
	$job_status='';
	$payment_status='';
	$jobcategory='';
	$willingtopay='';
	$risk_txt='';
	$totalhours=0;
}

$total_persons=0;
$getfinal = mysql_query ("select bidprice as hourrate , no_of_persons as total_persons from tbljobsapplied where job_id=".$job_id." and is_winner=1");
 if(mysql_num_rows($getfinal)){
	while($result = mysql_fetch_assoc($getfinal))
	{	
		
			$total=$result['hourrate'] * $result['total_persons'] * $job_days *  $job_hours;
			$finalizeamount=$finalizeamount+$total;
			$total_persons=$total_persons+$result['total_persons'];
		
	}	
 }
 
 $vacantposition = $opening_position - $total_persons;


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
<title>Place Your Bid - SECURE THAT JOB</title>

<!-- Bootstrap -->
<link href="https://fonts.googleapis.com/css?family=Fira+Sans:300,400,400i,500,600,700,800" rel="stylesheet"> 
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link href="css/ddsmoothmenu.css" rel="stylesheet">
<link href="css/owl.carousel.css" rel="stylesheet">
<link href="css/owl.theme.css" rel="stylesheet">
<link href="css/jquery.fancybox.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<link href="fonts/font-awesome.css" rel="stylesheet">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.bxslider.js"></script>
<script type="text/javascript" src="js/menu.js"></script>
<script type="text/javascript" src="js/owl.carousel.js"></script>
<script type="text/javascript" src="js/jquery.fancybox.js"></script>
<script type="text/javascript" src="js/at-jquery.js"></script>

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

<!-- Script for Direct Apply for the Job -->
<script>
function applyForJob(jobId, userId, jobPrice){
	var sessionUser = <?php echo isset($_SESSION['user_id'])?$_SESSION['user_id']:0; ?>;
	if(sessionUser==0){
		<?php
		unset($_SESSION['page_name']);
     	$_SESSION['page_name'] = 'jobs.php';
		?>
		window.location.href = "login.php";
		return false;
	}
	var applyJob = confirm("Do you want to apply for this job?");
	var jobId = jobId;
	var userId = userId;
	var jobPrice = jobPrice;
	if (applyJob == true) {
		if(jobId != "" && userId != "" && jobPrice != "") {
			$.ajax(
				{
					url: 'add_course_rout.php',
					type: "post",
				})
			.done(function(data)
				{
					var obj = JSON.parse(data);
					if (obj.data == 0) {
						<?php
							unset($_SESSION['page_name']);
			  				$_SESSION['page_name'] = 'jobs.php';
			  			?>
					    $('#myModal').modal('show');

					} else {
						$.ajax(
						{
							url: 'apply_for_job.php?jobId='+jobId+'&userId='+userId+'&jobPrice='+jobPrice,
							type: "get",
							datatype: "html",
							beforeSend: function()
							{
								$('#preloader').show();
							}
						})
						.done(function(data)
						{
							$('#preloader').hide();
							if(data==1)
							{
								alert("You have already bid for this job.");
								window.location.reload();
							}
							if(data==2)
							{
								if(!alert("Your bid has been successfully placed.")){window.location.reload();}
							}
							if(data==3)
							{
								alert("Something went wrong. Please try again.")
								window.location.reload();
							}			
						})
						.fail(function(jqXHR, ajaxOptions, thrownError)
						{
							alert("Something went wrong. Please try again.")
							return false;
						});
					}			
				});
		}
	}
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
     
	 $('#placeyourbid').on('click', function(){
	  if($('#bid_amount').val()=='')
	  {
		  alert("Please enter your Bid Amount");
		  $('#bid_amount').focus();
		  return false;
	  }
	  else if($('#persons').val()=='')
	  {
		  alert("Please enter your Bidding For");
		  $('#persons').focus();
		  return false;
	  }
	  else if(parseInt($('#persons').val()) > parseInt($('#opp_position').val()))
	  {
		  
		  alert("You can't enter bidding for more than opening positions.");
		  $('#persons').focus();
		  return false;
	  } else {
		  $("#preloader").show();
		  $.post("post_user_bid.php",
		  {
			  bid_amount:$('#bid_amount').val(),persons:$('#persons').val(),job_id:$('#job_id').val()
		  },
		  function(data)
		  {
            if(data==1)
			{
				alert("You have already bid for this job.");
				window.location.reload();
			}
            if(data==2)
			{
				//alert("Thank you for your bids we will review it.");
				window.location.reload();
			}
            if(data==3)
			{
				alert("Something going wrong.");
				window.location.reload();
			}			
			
		  });
	  }
	  
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

<div class="container">
	<div class="modal fade" id="myModalbid" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <p>Please complete your profile to bid for this jobb.</p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-default" id="close_modalbid" data-dismiss="modal">Close</button>
        </div>
      </div>
      
      
    </div>
  </div>

</div>

<script>
	$("#close_modalbid").on("click",function(){
		<?php
		unset($_SESSION['page_name']);
		unset($_SESSION['job_id']);
		$_SESSION['page_name']="place-bid.php";
		$_SESSION['job_id']=$job_id;
		?>
		window.location="profile-edit.php";
	});
</script>

<div class="container">
	<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <p>Please complete your profile to apply for this job.</p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-default" id="close_modal" data-dismiss="modal">Close</button>
        </div>
      </div>
      
      
    </div>
  </div>

</div>

<script>
	$("#close_modal").on("click",function(){
		<?php
		unset($_SESSION['page_name']);
		unset($_SESSION['job_id']);
		$_SESSION['page_name']="place-bid.php";
		$_SESSION['job_id']=$job_id;
		?>
		window.location="profile-edit.php";
	});
</script>

<body class="<?php echo $profileCLass; ?>">
<div id="preloader" style="display:none; z-index:9999;"></div>
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
								$jobrows=mysql_query("select * from tbljobimages where jobid=".$job_id."");
								$jobrows2=mysql_query("select * from tbljobimages where jobid=".$job_id."");
								$jobcount=mysql_num_rows($jobrows);
								$imagecount=mysql_num_rows($jobrows2);
								?>
								<?php 
								if($jobcount > 0){
								?>
									<!-- Main Large Images -->
									<div id="sync1" class="owl-carousel">
										<?php while($imagedata=mysql_fetch_array($jobrows)){ ?>
											<div class="item"><img src="<?php echo JOBS_IMG_URL.$imagedata['imagename'];?>" alt=""/></div>
										<?php } ?>
									</div>
									
									<!-- Images Thumbnails (If Images are more than 1) -->
									<?php if($imagecount > 1){ ?>
										<div id="sync2" class="owl-carousel">
											<?php while($imagedata1=mysql_fetch_array($jobrows2)){ ?>
												<div class="item"><img src="<?php echo JOBS_IMG_URL.$imagedata1['imagename'];?>" alt=""/></div>
											<?php } ?>
										</div>
									<?php } ?>

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
										<li>Duration: <span><?php if($job_days!=''){?> <?php echo $job_days; ?> Days <?php } ?> <?php if($job_hours!=''){ ?>(<?php echo $job_hours;?> hours per day)<?php } ?></span></li>
										<li>Start Date: <span><?php if($start_date!=''){ ?> <?php echo date('d/m/Y',strtotime($start_date)); ?> <?php } ?></span></li>
										<?php if($job_type!=''){ ?><li>Job Type: <span><?php echo $job_type_text; ?></span></li><?php } ?>
										<?php if($dresscode!=''){ ?><li>Dress Code: <span><?php echo $dresscode; ?></span></li><?php } ?>
										<?php if($job_location!=''){ ?><li>Location: <span><?php echo $job_location; ?></span></li><?php } ?>
										<?php if($risk_txt!=''){ ?><li>Risk Meter: <span><?php echo $risk_txt; ?></span></li><?php } ?>
										<?php if($transport_link!=''){ ?><li>Nearest Transport Link: <span><a href="<?php echo $transport_link; ?>" target="_blank"><?php echo $transport_link; ?></a></span></li><?php } ?>
									</ul>
								</div>

							</div>
							<div class="stj_bid_side_con">
								<h2><?php echo $job_name; ?></h2>
								<h5><?php if($jobcategory!=''){  echo '('.$jobcategory.')'; } ?></h5>
								<div class="stj_bid_rating">
									<?php
										echo getPosterFeedback($job_id);
									?>
									<?php
									$jobIdCheck = $job_id;
									$check_visits = mysql_query("SELECT totalvisit FROM tbltotalview WHERE job_id='$jobIdCheck' ");
									$check_visit = mysql_fetch_array($check_visits);
									$totalVisits = $check_visit['totalvisit'];
									?>
									<label>Total Views: <span><?php echo $totalVisits; ?></span></label>
								</div>
								
								<hr>
								<h3>Amount Willing to pay</h3>
								<div class="price"><?php if($willingtopay!=0 && $willingtopay!=''){ ?>£<?php echo number_format($willingtopay,2); ?><?php } ?></div>
								<div class="price_hrs"><?php if($job_days!=''){ ?><?php echo $totalhours; ?> Hours <?php } ?> @ <?php if($price){ ?>£<?php echo $price; ?> Per Hour <?php } ?></div>
								<div class="bid_btn">

									<?php 
									/*check for profiel start*/
									$customer_type =  $_SESSION['customer_type'];		
									$user_email = $_SESSION['user_email'];
									$user_id = $_SESSION['user_id'];


									$user_status_query = mysql_query("select verified_user from tbluser WHERE user_id = '".$user_id."'");
									while($user_status = mysql_fetch_assoc($user_status_query)){

										$user_sts = $user_status['verified_user'];
										
									}


									if (isset($user_sts) && $user_sts == 0) {
										$user_sts = 0;
									}else{
										$user_sts = 1;
									}

									
									if ($customer_type == 1) {
											$customer_1 = "SELECT tusr.* FROM tbluser AS tusr WHERE tusr.email ='".$user_email."' AND tusr.company_name != '' AND tusr.firstname != '' AND tusr.lastname != '' AND tusr.address_1 != '' AND tusr.postal_code != '' AND tusr.reg_no != '' AND tusr.reg_vat_no != '' AND tusr.email != '' AND tusr.phone != '' AND tusr.paypal_email != ''";
											$sql_detail=mysql_query($customer_1);
											
											
											$comp_certi ="select comp_certi FROM tbl_user_comp_certi WHERE user_id = '".$user_id."'";
											$comp_certi_detail=mysql_query($comp_certi);

											$license_passport ="select license_passport FROM tbl_user_license_passport WHERE user_id = '".$user_id."'";
											$license_passport_detail=mysql_query($license_passport);

											
											$detail_row1=mysql_num_rows($sql_detail);		
											$comp_certi_detail_row=mysql_num_rows($comp_certi_detail);
											$license_passport_detail_row=mysql_num_rows($license_passport_detail);
											
										}else{
											$customer_2 = "SELECT tusr.*,tulp.license_passport FROM tbluser AS tusr LEFT JOIN tbl_user_license_passport AS tulp ON tusr.user_id = tulp.user_id LEFT JOIN tbl_user_comp_certi AS ucc ON tusr.user_id = ucc.user_id WHERE tusr.email ='".$user_email."' AND tusr.firstname != '' AND tusr.lastname != '' AND tusr.address_1 != '' AND tusr.postal_code != '' AND tusr.email != '' AND tusr.phone != '' AND tusr.birthdate != '' AND tusr.gender != '' AND tusr.height != '' AND tusr.build != '' AND tusr.nationality != '' AND tusr.language != '' AND tusr.militry != '' AND tusr.drive != '' AND tusr.firstaid != '' AND tusr.paremedic != '' AND tusr.tattoos != '' AND tusr.piercing != '' AND tusr.paypal_email != '' AND tusr.right_to_work_uk != '' AND tusr.willing_to_travel != '' AND tusr.sia != '' AND tusr.how_far_willing_to_travel != '' AND tusr.activity != '' AND tusr.health != '' AND tusr.bio != '' AND tusr.experience != '' AND tusr.education_credentials != '' AND tulp.license_passport != '' AND tusr.uk_driving_license != ''";
											
											$sql_detail=mysql_query($customer_2);

											$utility ="select utility FROM tbl_user_utility WHERE user_id = '".$user_id."'";
											$utility_detail=mysql_query($utility);

											$certificate ="select certificate FROM tbl_user_certi WHERE user_id = '".$user_id."'";
											$certificate_detail=mysql_query($certificate);

											$detail_row2=mysql_num_rows($sql_detail);
											$utility_detail_row=mysql_num_rows($utility_detail);
											$certificate_detail_row=mysql_num_rows($certificate_detail);
											
										}



										if ($customer_type == 2) 
										{
											
											if ($user_sts == 0) { ?>
												<a href="#" data-toggle="modal" data-target="#admin_call" style="font-size:14px; padding: 9px 10px;">Place your bid</a>
											<?php } else { 

												if ($detail_row2 < 1 || $utility_detail_row < 1 || $certificate_detail_row < 1)
													{ ?>
														<a href="#" data-toggle="modal" data-target="#myModalbid" style="font-size:14px; padding: 9px 10px;">Place your bid</a>
													<?php	}else{ ?>
														<a class="a_bid_pop" href="#bid_id" style="font-size:14px; padding: 9px 10px;">Place your bid</a>	
												<?php	}
												 }
										}

										if($customer_type == 1)
										{	

											if ($user_sts == 0) { ?>
												<a href="#" data-toggle="modal" data-target="#admin_call" style="font-size:14px; padding: 9px 10px;">Place your bid</a>
											<?php }else{

												if ($detail_row1 < 1 || $comp_certi_detail_row < 1 || $license_passport_detail_row < 1) { ?>
												<a href="#" data-toggle="modal" data-target="#myModalbid" style="font-size:14px; padding: 9px 10px;">Place your bid</a>
										<?php	}else{ ?>
												<a class="a_bid_pop" href="#bid_id" style="font-size:14px; padding: 9px 10px;">Place your bid</a>
											<?php }

											}	
											
											
											
										}

									/*check for profiel end */
									?>





									<!-- <a class="a_bid_pop" href="#bid_id" style="font-size:14px; padding: 9px 10px;">Place your bid</a> -->

									<?php 
									if ($user_sts == 0) { ?>

									<a class="a_pybaa" data-toggle="modal" data-target="#admin_call">Apply Now</a>
										
									<?php } else { ?>
											<a class="a_pybaa" onclick="javascript:return applyForJob(<?php echo $job_id.','.$user_id.','.$price; ?>);">Apply Now</a>
									<?php } ?>


									
								</div>
								<div style="display: none;">
									<div class="bid_pop_wrap" id="bid_id">
										<h2>Place Your Bid</h2>
										<input type="hidden" name="job_id" id="job_id" value="<?php echo $job_id; ?>">
										
								        <input type="hidden" name="opp_position" id="opp_position" value="<?php echo $vacantposition; ?>">
										<div class="bpw_inner">
											<h4>Please choose desired Bid for the job. You can submit a different bid, lower or higher than the advertised budget</h4>
											<ul>
												<li>
													<label>Your Bid Amount: <em>* £</em></label>
													<input type="number" name="bid_amount" id="bid_amount" value=""  maxlength="4" class="txt_pop" />
													<span class="sd_dtl">(Per Person Per hour)</span>
												</li>
												<li>
													<label>Bidding For: <em>*</em></label>
													<input type="number" id="persons" name="persons" maxlength="5" class="txt_pop" />
													<span class="sd_dtl">Person(s)</span>
												</li>
												<li class="algn_cntr"><p>By Clicking the submit offer button, you will commit to carrying out the job, if chosen as winner by the job listings owner, and also you agree to our <a href="#" data-toggle="modal" data-target="#termsCondition">Terms and Conditions</a></p></li>
												<li class="algn_cntr">
													<input type="submit" id="placeyourbid" value="Submit your offer" class="btn_pop" />
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div id="admin_call" class="modal fade" role="dialog">
						  <div class="modal-dialog">

						    <!-- Modal content-->
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal">&times;</button>
						        <h4 class="modal-title"></h4>
						      </div>
						      <div class="modal-body">
						        <p>You can not apply for a job as you are not Verified User.</p>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						      </div>
						    </div>

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
								<p><?php echo $address1.', '.$job_location.', '.$postalcode; ?></p>
								<div id="map"></div>
							</div>
						</div>
						<div class="stj_bid_descp social_ico">
							<h2>Description</h2>
							<p><?php echo strip_tags(abuseword($job_description)); ?></p>
							
							<h5>Share this job: </h4>
							<!-- Facebook -->
							<a href="<?php echo $currentURL; ?>" class="share facebook fa fa-facebook"></a>

							<!-- Google Plus -->
							<!-- <a href="<?php //echo $currentURL; ?>" class="share google-plus fa fa-google"></a> -->

							<!-- Twitter -->
							<a href="<?php echo $currentURL; ?>" data-text="" class="share twitter fa fa-twitter"></a>

							<!-- LinkedIn -->
							<a href="<?php echo $currentURL; ?>"  data-text=""  class="share linkedin fa fa-linkedin"></a>

						</div>
					</div>
					
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
                        inner join tbluser as user on user.user_id = jobapply.user_id WHERE jobapply.job_id =".$job_id." and jobapply.user_id!=".$user_id." group by jobapply.id order by jobapply.applied_date desc");
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
											<?php echo getUserFeedback($jobapp['user_id']); ?>
									    </ul>
									</td>
								</tr>
						<?php
						   }
                        } 
                        ?>						
								<?php 
								   $jobapplieduser=mysql_query("select user.user_id,user.firstname,user.lastname,job.job_name,jobapply.* from tbljobsapplied as jobapply inner join tbljobs as job on jobapply.job_id = job.job_id
                        inner join tbluser as user on user.user_id = jobapply.user_id WHERE jobapply.job_id =".$job_id." and jobapply.user_id=".$user_id." group by jobapply.id order by jobapply.applied_date desc");
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
											<?php echo getUserFeedback($applieddata['user_id']); ?>
									    </ul>
									</td>
								</tr>
								<?php } 
								}
								?>
							</table>
						</div>
					</div>
					
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