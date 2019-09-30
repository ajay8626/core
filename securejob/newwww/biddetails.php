<?php
include "config.php";
include "check_user_login.php";
$job_id=isset($_REQUEST['job_id']) && $_REQUEST['job_id']!='' ? $_REQUEST['job_id'] : 0;
$user_id=isset($_SESSION['user_id']) && $_SESSION['user_id']!='' ? $_SESSION['user_id'] : 0;
$jobdetails=mysql_query("select * from tbljobs where job_id='".$job_id."'");
$rowcount=mysql_num_rows($jobdetails);

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

if(isset($_POST["jobdelete_id"])){
	$job_id=isset($_POST['jobdelete_id']) && $_POST['jobdelete_id']!='' ? $_POST['jobdelete_id'] : 0;
	if($job_id!=0){
		$db->Delete("tbljobs"," job_id= ".$job_id." ");
		$db->Delete("tbljobimages"," jobid= ".$job_id." ");
		$db->Delete("tbljobcategories", " job_id= ".$job_id." ");
		$db->Delete("tbljobtags" , " job_id= ".$job_id."  ");	
		$db->Delete("tbljobsapplied" , " job_id= ".$job_id."  ");	
		$db->Delete("tbljobstatus" , " job_id= ".$job_id."  ");	
		$db->Delete("tbljobrating" , " job_id= ".$job_id."  ");	
		
		header("Location:postjob.php");
		exit();
	}
}

if($rowcount == 0)
{
	echo '<script> alert("Invalid Job Id."); window.location.href="jobs.php";</script>';
}
if($job_id==0)
{
	echo '<script> alert("Invalid Job Id."); window.location.href="jobs.php";</script>';
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
	$opening_type=$jobdata['opening_type'];
	$duration_in=$jobdata['duration_in'];
	$job_status=$jobdata['job_status'];
	$payment_status=$jobdata['payment_status'];
	$jobcategory=jobcatlist($job_id);
	$willingtopay=$price * $job_days * $opening_position * $job_hours;
	$totalhours=$job_days * $opening_position * $job_hours;
	
	$status_txt='';
	// if($job_status==3)
	// {
	// 	$status_txt='In-Progress';
	// }
	// if($job_status==4)
	// {
	// 	$status_txt='Completed';
	// }

	$countBidderCheck = "SELECT id FROM tbljobsapplied WHERE job_id = ".$job_id." AND is_winner=1";
	$countBidderQue = mysql_query($countBidderCheck);
	$countBidder = mysql_num_rows($countBidderQue);

	$countStatusBidCheck = "SELECT status_id FROM tbljobstatus WHERE tbljobstatus.job_id = ".$job_id." AND tbljobstatus.status=4";
	$countStatusBiddeQue = mysql_query($countStatusBidCheck);
	$countStatusBid = mysql_num_rows($countStatusBiddeQue);

	$countForStatus =  ($countBidder - $countStatusBid);

	if($countForStatus!=0)
	{
		$status_txt='In-Progress';
		$disabled_button = "disabled";
		$disabled_class = "btn disabled";
	}else{
		$status_txt='Completed';
		$disabled_button = "";
		$disabled_class = "";
	}
	
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

if($user_id!=$job_user_id)
{
	echo '<script> alert("Invalid Job Id."); window.location.href="jobs.php";</script>';
}

$total_persons=0;
$getfinal = mysql_query ("select bidprice as hourrate , no_of_persons as total_persons from tbljobsapplied where job_id=".$job_id." and is_winner=1");
 if(mysql_num_rows($getfinal)){
	while($result = mysql_fetch_assoc($getfinal))
	{	
		
			
			$total=$result['hourrate'] * $result['total_persons'] * $job_days *  $job_hours;
			$finalizeamount=$finalizeamount+$total;
			$total_persons=$total_persons+$result['total_persons'];
			//$hourrate=$result['hourrate'];
			//$total_persons=$result['total_persons'];
			
			//exit;
			//$finalizeamount=$hourrate * $total_persons *  $job_days *  $job_hours;
		
	}	
 }
 
 $vacantposition=$opening_position - $total_persons;

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
<title>Bid Details - SECURE THAT JOB</title>

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
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<style>
#map{
	height: 450px;
	float: left;
}
</style>
<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({includedLanguages: '<?php echo LanguageList; ?>', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script>
<script>
     jQuery(document).ready(function($) {
     
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

/* Job Post Status */
function jobPostStatus(job_id){
	var retVal = confirm("Are you sure you want to make the payment to the bidders?");
	if( retVal == true ){
		window.location = "<?php echo SITE_URL ?>complete-paypal-payment/start.php?job_id="+job_id;
	}else{
		return false;
	}
}

/* Update Status */
function updateStatus(job_id){
	var status = $('#status').val();
    $.ajax({
		url: 'updateStatus.php?job_id='+job_id+"&status="+status,
		type: "get",
		datatype: "html",
		beforeSend: function()
		{
			$('#preloader').show();
		}
	})
	.done(function(data)
	{
		if(data.length == 0){
			$('#preloader').show();
			return false;
		}
		
		$('#preloader').hide();
		alert(data);

	})
	.fail(function(jqXHR, ajaxOptions, thrownError){
		/* alert('No response from server'); */
	});
}

/* Select Winner */
function selectWinner(user_id,job_id){
    $.ajax({
		url: 'assignWinner.php?user_id='+user_id+"&job_id="+job_id,
		type: "get",
		datatype: "html",
		beforeSend: function()
		{
			$('#preloader').show();
		}
	})
	.done(function(data)
	{
		
		if(data.length == 0){
			$('#preloader').show();
			return false;
		}
		$('#preloader').hide();
		
		if(data == "Success"){
			$("#winnerText_"+user_id).html("Winner");
			$("#winnerText_"+user_id).addClass("winner_col");
			$("div.bid_btn.bid_btn_ed").load(location.href + " div.bid_btn.bid_btn_ed");
		}
		else{
			alert(data);
			return false;
		}
		
	})
	.fail(function(jqXHR, ajaxOptions, thrownError)
	{
		$('#preloader').hide();
		alert('No response from server');
	});
}

/* Send Messages */
function sendMessage(user_id,job_id){
	var msg = $("#message").val();
	if(msg == ''){
		alert('Please type a message.');
		return false
	}
		 
    $.ajax({
		url: 'chatmessage.php?user_id='+user_id+"&job_id="+job_id+"&message="+msg,
		type: "get",
		datatype: "html",
		beforeSend: function()
		{
			$('#preloader').show();
		}
	})
	.done(function(data){
		
		if(data.length == 0){
			$('#preloader').show();
			alert(data);
			return false;
		}
		
		$('#preloader').hide(); 
		$("#chatWindow").html(data);
		$("#message").val('');

	})
	.fail(function(jqXHR, ajaxOptions, thrownError){
		/* alert('No response from server'); */
	});
}

/* Feedback */
function feedback(column,rate,user_id,job_id){
	$.ajax({
		url: 'rateuser.php?column='+column+'&rate='+rate+'&user_id='+user_id+"&job_id="+job_id,
		type: "get",
		datatype: "html",
		beforeSend: function()
		{
			$('#preloader').show();
		}
	})
	.done(function(data){
		if(data.length == 0){
			$('#preloader').show();
			alert(data);
			return false;
		}
		
		$('#preloader').hide(); 
		$("#loadRating").html(data);
	})
	.fail(function(jqXHR, ajaxOptions, thrownError)
	{
		/* alert('No response from server'); */
	});
}

/* Feedback Popup */
function feedbackPopup(column,rate,user_id,job_id){
	$.ajax({
		url: 'rateuserpopup.php?column='+column+'&rate='+rate+'&user_id='+user_id+"&job_id="+job_id,
		type: "get",
		datatype: "html",
		beforeSend: function()
		{
			$('#preloader').show();
		}
	})
	.done(function(data){
		if(data.length == 0){
			$('#preloader').show();
			alert(data);
			return false;
		}
		
		$('#preloader').hide();
		$("#tbl_po_fee").html(data);
	})
	.fail(function(jqXHR, ajaxOptions, thrownError)
	{
		/* alert('No response from server'); */
	});
}

/* Finalize Bid */
function finalizeBid(job_id){
		
    $.ajax({
		url: 'finalizebid.php?job_id='+job_id,
		type: "get",
		datatype: "html",
		beforeSend: function()
		{
			$('#preloader').show();
		}
	})
	.done(function(data){
		
		if(data.length == 0){
			$('#preloader').show();
			alert("Something went wrong, plese try after sometime");
			return false;
		}
		
		$('#preloader').hide();
		alert(data);
		document.location.href="pending_post_job.php";
		return false;
	})
	.fail(function(jqXHR, ajaxOptions, thrownError)
	{
		/* alert('No response from server'); */
	});
}

/* Pay */	 
function pay(job_id){
		
    $.ajax({
		url: 'pay.php?job_id='+job_id,
		type: "get",
		datatype: "html",
		beforeSend: function()
		{
			$('#preloader').show();
		}
	})
	.done(function(data)
	{
		
		if(data.length == 0){
			$('#preloader').show();
			alert("Something went wrong, plese try after sometime");
			return false;
		}
		
		$('#preloader').hide();
		alert(data);
		document.location.href="confirmed_post_job.php";
		return false;
	})
	.fail(function(jqXHR, ajaxOptions, thrownError)
	{
		/* alert('No response from server'); */
	});
}

/* Confirm Delete */
function confirmDelete(){
	var s = confirm("Are you sure you want to delete this job ?");
	if(s){
		document.jobdelete.submit();
	}
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
<?php
 include "header-inner.php"; 
 
 // query to fetch no of persons and price per hour
 $winnerAvailable = False;
 $sql = mysql_query ("select COALESCE(SUM(id), 0) as total,SUM(bidprice) as hourrate , SUM(no_of_persons) as total_persons from tbljobsapplied where job_id=".$job_id." and is_winner=1");
 $hourrate=0;
 $total_persons=0;
 $finalizeamount=0;
 if(mysql_num_rows($sql)){
	$result = mysql_fetch_assoc($sql);
	if($result["total"] > 0){
		$winnerAvailable = True;
	}	
 }

 $_SESSION['winAvail'] = $winnerAvailable;
 
 $getfinal = mysql_query ("select bidprice as hourrate , no_of_persons as total_persons from tbljobsapplied where job_id=".$job_id." and is_winner=1");
 if(mysql_num_rows($getfinal)){
	while($result = mysql_fetch_assoc($getfinal))
	{	
			$total=$result['hourrate'] * $result['total_persons'] * $job_days *  $job_hours;
			$finalizeamount=$finalizeamount+$total;
			$total_persons=$total_persons+$result['total_persons'];
	}	
 }
 
?>
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
								</div>
								<hr>
								<?php if(!isset($_GET["flag"]) || ($_GET["flag"]=='pending')){ ?>
								<h3>Total Amount Willing to pay</h3>
								<div class="price"><?php if($willingtopay!=0 && $willingtopay!=''){ ?>£<?php echo number_format($willingtopay,2); ?><?php } ?></div>
								<?php } ?>
								
								<div class="price_hrs"></div>
								
								<?php if(!isset($_GET["flag"]) || ($_GET["flag"]=='pending')){ ?>
								<div class="bid_btn bid_btn_ed">
								<?php 
									if(!$winnerAvailable){
								?>
									<a class="bid_edit" href="edit_job.php?job_id=<?php echo $job_id; ?>">Edit</a>
									<form name="jobdelete" method="post">
										<input type="hidden" name="jobdelete_id" value="<?php echo $job_id;?>">
									</form >
									<a class="bid_delete" href="javascript:void(0);" onclick="javascript:return confirmDelete();">Delete</a>
									<?php } ?>
								</div>
								<?php
									if($winnerAvailable && !isset($_GET["flag"])){
								?>
								<div class="bid_btn">
								     <a class="finalize" href="javascript:void(0);" onclick="javascript:return finalizeBid(<?php echo $job_id;?>)">Finalise Bid</a>
								</div>
								<?php
									} else if($winnerAvailable && $payment_status==0) { ?>
									
									<?php
										$userDetailsSql = "SELECT firstname, lastname FROM tbluser WHERE user_id=".$user_id."";
										$userDetails = mysql_query($userDetailsSql);
										$userDetailsArr = mysql_fetch_array($userDetails);
										$firstName = $userDetailsArr['firstname'];
										$lastName = $userDetailsArr['lastname'];
									?>

									<!-- Pay with PayPal Button -->
									<form action="paypal-pay-for-job/payments.php" method="post" id="paypal_form">
										<input type="hidden" name="cmd" value="_xclick" />
										<input type="hidden" name="no_note" value="1" />
										<input type="hidden" name="lc" value="UK" />
										<input type="hidden" name="currency_code" value="GBP" />
										<input type='hidden' name='rm' value='2'>
										<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
										<input type="hidden" name="first_name" value="<?php echo $firstName; ?>"  />
										<input type="hidden" name="last_name" value="<?php echo $lastName; ?>"  />
										<input type="hidden" name="item_number" value="<?php echo $job_id; ?>" />
										<input type="hidden" name="amount" value="<?php echo $finalizeamount; ?>"  />
										<input type="hidden" name="item_name" value="<?php echo 'Payment: '.$job_name; ?>" />
										<input type="hidden" name="user_id" value="<?php echo $user_id ?>" />
										<input type="hidden" name="custom" value="paypal_pay_for_job" />
										<input type="submit" name="paypal" class="pay pay-class" value="Pay"/>
									</form>

								<?php }		
								}
								?>
							</div>
						</div>
						<div class="stj_bdt_rgt">
							<?php if($winnerAvailable){ ?>
								<div class="stj_final_amt">
									<h3>Finalised Amount</h3>
									<span>£<?php echo number_format($finalizeamount,2); ?></span>
								</div>
							<?php } ?>

							<?php if(isset($_GET["flag"]) && ($_GET["flag"]=='ongoing' || $_GET["flag"]=='complete')){ ?>
							<div class="stj_final_amt jb_status">
								<h3>Status <span class="in_prog_class"><?php echo $status_txt; ?></span></h3>
								<?php if(isset($_GET["flag"]) && $_GET["flag"]=='ongoing'){ ?>
								<!-- <input type="button" id="status" name="status" <?php //echo $disabled_button ?> value="Complete Task" class="btn_st <?php //echo $disabled_class ?>" onclick="javascript:return jobPostStatus(<?php //echo $job_id;?>)"/> -->
								<input type="button" <?php echo $disabled_button ?> class="btn_st <?php echo $disabled_class ?>" data-toggle="modal" data-target="#feedbackModal" value="Complete Task" style="margin-top:15px;"/>
								<?php } ?>
							</div>
							<?php } ?>

							<!-- Feedback Modal Before Complete Start -->
							<div id="feedbackModal" class="modal fade" role="dialog">
								<div id="feed-modal-dialog" class="modal-dialog" style="width:90%;">
									<!-- Modal content-->
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Please give feedback</h4>
										</div>
										<div id="feed-modal-body" class="modal-body">
											<div class="stj_bid_btm" style="width:100%">
												<div class="bid_table" id="tbl_po_fee">
													
													<?php echo getFeedbackPopup($job_id);?>

												</div>
											</div>
											<?php if(isset($_GET["flag"]) && ($_GET["flag"]=='ongoing' || $_GET["flag"]=='complete')){ ?>
											<div class="jb_status">
												<?php if(isset($_GET["flag"]) && $_GET["flag"]=='ongoing'){ ?>
												<input type="button" style="float:right;" id="status" name="status" <?php echo $disabled_button ?> value="Complete Task" class="btn_st <?php echo $disabled_class ?>" onclick="javascript:return jobPostStatus(<?php echo $job_id;?>)"/>
												<?php } ?>
											</div>
											<?php } ?>
										</div>
										<div class="modal-footer" style="border-top:none">
											
										</div>
									</div>
								</div>
							</div>
							<!-- Feedback Modal Before Complete End -->

							<div class="stj_bdt_rgt_iframe">
							     <h4>Location</h4>
								 <p><?php echo $address1.', '.$job_location; ?></p>
								<!-- <iframe src="https://www.google.com/maps?q=<?php //echo $address1; ?>&output=embed" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe> -->
								<div id="map"></div>
							</div>
						</div>
						<div class="stj_bid_descp">
							<h2>Description</h2>
							<p><?php echo strip_tags($job_description); ?></p>
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
                        inner join tbluser as user on user.user_id = jobapply.user_id WHERE jobapply.job_id =".$job_id." and jobapply.user_id!=".$user_id." group by jobapply.user_id order by jobapply.applied_date desc");
						$jobappliedcount=mysql_num_rows($jobapplied);
						  if($jobappliedcount > 0)
						  {
							while($jobapp=mysql_fetch_array($jobapplied))
							{
								$total_amount = $jobapp['bidprice'] * $jobapp['no_of_persons'] * $job_days * $job_hours;
								$selectedText= "Select";
							
								if($jobapp['is_winner']==1){ 
									$selectedText= "<span class='winner_col'>Winner</span>";
									$selectedClass = "winner_col";
								}else{
									$selectedClass = "";
								}
						?>		
								<tr>
									<td><a href="guard-profile.php?user_id=<?php echo $jobapp['user_id']; ?>"><?php echo $jobapp['firstname'];?> <?php echo $jobapp['lastname']; ?></a></td>
									<td><?php echo date('d/m/Y',strtotime($jobapp['applied_date'])) ?></td>
									<td>£<?php echo $jobapp['bidprice']; ?></td>
									<td><?php echo $jobapp['no_of_persons']; ?></td>
									<td>£<?php echo number_format($total_amount,2); ?></td>
									<?php 
									if((isset($_GET["flag"])) && ( ($_GET["flag"] == "confirm")  || ($_GET["flag"] == "ongoing") ) ){
										echo "<td>".$selectedText."</td>";
									}
									else 
									{
									?>
									<td>
										<a href="javascript:void(0);" onclick="javascript:selectWinner(<?php echo $jobapp['user_id']; ?>, <?php echo $jobapp['job_id']; ?>)"><span class="<?php echo $selectedClass; ?>" id="winnerText_<?php echo $jobapp['user_id'];?>"><?php echo $selectedText;?></span></a>
									</td>
									<?php } ?>

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
									<td>£<?php echo number_format($total_amount1,2); ?></td>
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
					<div class="stj_loader" style="display:none;">Loading...</div>
					<?php 
						if((isset($_GET["flag"])) && ( ($_GET["flag"] == "confirm")  || ($_GET["flag"] == "ongoing") ) ){
					?>		
					<div class="clear"></div>
					<div class="stj_bid_btm stj_bid_btm_full">
						<h2>Check-in / Check-out Schedule</h2>
						<div class="bid_table" id="UserSchedule">
							<?php echo getSchedule($job_id);?>
						</div>
						<!--<div class="feed_cmnt">
							<textarea placeholder="Enter Comment Here"  name="comment" id="comment"></textarea>
							<input type="button" class="btn_cmnt" 
							 onclick="javascript:sendMessage(<?php echo $job_id; ?>);"
							value="Check in" />
						</div>-->
					</div>
					<div class="stj_chat_wrap">
						<h2>chat threads</h2>
						<div class="chat_dv" >
							<div id="chatWindow"><?php echo getChats($job_id,$user_id);?></div>
							<div class="chat_area">
								<textarea placeholder="Type a message"  name="message" id="message"></textarea>
								<input type="button" onclick="javascript:sendMessage(<?php echo $user_id; ?>, <?php echo $job_id; ?>)" class="btn_chat" value="send" />
							</div>
							
						</div>
					</div>
					<?php 
						}
						if((isset($_GET["flag"])) && ( ($_GET["flag"] == "complete") ) ) {
							
					?>
						<div class="stj_bid_btm">
						<h2>Feedback</h2>
						<div class="bid_table">
							<table border="0" cellpadding="0" cellspacing="0" id="loadRating">
								<tr>
									<th>Provide Ratings</th>
									<th>Performance</th>
									<th>Punctuality</th>
									<th>Presentation</th>
									<th>Dress Code</th>
									<th>Attitude to work</th>
								</tr>
								<?php echo getFeedback($job_id);?>
							</table>
						</div>
						</div>
						
					<?php
					
						}
					?>
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