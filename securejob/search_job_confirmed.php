<?php
include "config.php";
include "check_user_login.php";
$job_id=isset($_REQUEST['job_id']) && $_REQUEST['job_id']!='' ? $_REQUEST['job_id'] : 0;
$user_id=isset($_SESSION['user_id']) && $_SESSION['user_id']!='' ? $_SESSION['user_id'] : 0;
$confirmFlag=isset($_SESSION['flag']) && $_SESSION['flag']!='' ? $_SESSION['flag'] : 0;
$jobdetails=mysql_query("SELECT * FROM tbljobs WHERE job_id='".$job_id."'");
$rowcount=mysql_num_rows($jobdetails);
$jobstatus=getjobstatus($job_id,$user_id);

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

<script>
	function updateStatus(job_id){
	var status = $('#status').val();
	if(status!=0)
	{
		
    $.ajax(
		{
			url: 'jobs_status.php?job_id='+job_id+"&status="+status,
			type: "get",
			datatype: "html",
			beforeSend: function()
			{
				$('#preloader').show();;
			}
		})
		.done(function(data)
		{
			
			if(data.length == 0){
				$('#preloader').show();;
				return false;
			}
			
			$('#preloader').hide();;
			
			if(status==3)
			{
				alert(data);
				document.location.href="ongoingjobs.php";
				return false;
			}
			if(status==4)
			{
				
			   $('#status_dropdown').hide();
			   $('#payment_status').show();
			   $('#alert_msg').html(data);
			}

		})
		.fail(function(jqXHR, ajaxOptions, thrownError)
		{
			  //alert('No response from server');
		});
	}
	else
	{
		alert("Please Select Job Status.");
	}
  }

  function sendMessage(user_id,job_id){
		 var msg = $("#message").val();
		 if(msg == ''){
			 alert('Please type a message.');
			 return false
		 }
    $.ajax(
		{
			url: 'chatmessage.php?user_id='+user_id+"&job_id="+job_id+"&message="+msg,
			type: "get",
			datatype: "html",
			beforeSend: function()
			{
				$('.stj_loader').html("Loading...");
				$('.stj_loader').show();
			}
		})
		.done(function(data)
		{
			
			if(data.length == 0){
				$('.stj_loader').show();
				alert(data);
				return false;
			}
			
			$('.stj_loader').hide(); //hide loading animation once data is received
			$("#chatWindow").html(data);
			$("#message").val('');
			
			
			
			
			
		})
		.fail(function(jqXHR, ajaxOptions, thrownError)
		{
			
			  //alert('No response from server');
		});
     }


	 function checkInComment(user_id,job_id){
		 var msg = $("#check_comment").val();
		 if(msg == ''){
			 alert('Please enter comment.');
			 return false
		 }
    $.ajax(
		{
			url: 'checkincomment.php?user_id='+user_id+"&job_id="+job_id+"&check_comment="+msg,
			type: "get",
			datatype: "html",
			beforeSend: function()
			{
				$('.stj_loader').html("Loading...");
				$('.stj_loader').show();
			}
		})
		.done(function(data)
		{
			
			$('.stj_loader').hide(); //hide loading animation once data is received
			$("#check_comment").val('');
			$("#checkLoad").load(" #checkLoad");
			

		})
		.fail(function(jqXHR, ajaxOptions, thrownError)
		{
			
			  //alert('No response from server');
		});
     }


	 function checkOutComment(user_id,job_id){
		 var msg = $("#check_comment").val();
		 if(msg == ''){
			 alert('Please enter comment.');
			 return false
		 }
    $.ajax(
		{
			url: 'checkoutcomment.php?user_id='+user_id+"&job_id="+job_id+"&check_comment="+msg,
			type: "get",
			datatype: "html",
			beforeSend: function()
			{
				$('.stj_loader').html("Loading...");
				$('.stj_loader').show();
			}
		})
		.done(function(data)
		{
			
			$('.stj_loader').hide(); //hide loading animation once data is received
			$("#check_comment").val('');
			$("#checkLoad").load(" #checkLoad");
		
		})
		.fail(function(jqXHR, ajaxOptions, thrownError)
		{
			
			  //alert('No response from server');
		});
     }
</script>
<script>

/* Feedback to job poster by the bidder */
function feedbackPoster(rate,user_id,job_id){
	$.ajax(
		{
			url: 'ratejobposter.php?rate='+rate+'&user_id='+user_id+"&job_id="+job_id,
			type: "get",
			datatype: "html",
			beforeSend: function()
			{
				$('.stj_loader').html("Loading...");
				$('.stj_loader').show();
			}
		})
		.done(function(data)
		{

			$('.stj_loader').hide();
			$("#posterRate").load(location.href + " #posterRate>*", "");
			alert(data);

		})
		.fail(function(jqXHR, ajaxOptions, thrownError)
		{
			
			  //alert('No response from server');
		});
}

</script>
</head>
<body>
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
		//$hourrate=$result['hourrate'];
		//$total_persons=$result['total_persons'];
		
		//exit;
		//$finalizeamount=$hourrate * $total_persons *  $job_days *  $job_hours;
	}	
 }
 
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
								
								<!-- Job Details -->
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
									<!-- Get the job poster id -->
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
								
								<?php if(isset($_GET["flag"]) && ($_GET["flag"]=='confirm' || $jobstatus==3)){ ?>
								<div class="jb_status" id="status_dropdown">
									<h4>Status</h4> 
									<select name="status" id="status">
									     <option value="0">Select Job Status</option>
									     <?php if(isset($_GET["flag"]) && $_GET["flag"]=='confirm'){ ?>
										<option value="3">In Progress</option>
										 <?php } ?>
										 <?php if(isset($_GET["flag"]) && $_GET["flag"]=='ongoing'){ ?>
										<option value="4">Complete</option>
										<?php } ?>
									</select>
									<input type="button" value="Update" class="btn_st" onclick="javascript:return updateStatus(<?php echo $job_id;?>)"/>
								</div> <?php  ?>
								<?php } ?>
							</div>
							
						</div>
						<div class="stj_bdt_rgt">
							
							<?php if($winnerAvailable){ ?>
							<div class="stj_final_amt">
								
								<h3>Finalized Amount</h3>
								<span>£<?php echo number_format($finalizeamount,2); ?></span>
								  
							</div>
							<?php } ?>
							<?php
                            $dis='style="display:none;"';							
							if($jobstatus==4)
							{
								$dis='';
							}
							if(isset($_GET["flag"]) && ($_GET["flag"]=='complete')){
								$status_message = "Payment has been released.";
							}else{
								$status_message = "Job Poster has not yet completed the job from his/her side. Payment will be released once Job Poster completes the job";
							}
							?>
							<div class="stj_final_amt" id="payment_status" <?php echo $dis; ?>>
							<h3>Payment Status</h3>
							<p id="alert_msg"><?php echo $status_message; ?></p>
							</div>
							
							<?php
								if((isset($_GET["flag"])) && ( ($_GET["flag"] == "complete") ) ){
									$fullWidthClass="full_width_map";
								}else{
									$fullWidthClass="";
								}
							?>
							<div class="stj_bdt_rgt_iframe <?php echo $fullWidthClass; ?>">
								<h4>Location</h4>
								<p><?php echo $address1.', '.$job_location; ?></p>
								<div id="map"></div>
								
							</div>
						</div>
						<div class="stj_bid_descp">
							<h2>Description</h2>
							<p><?php echo strip_tags(abuseword($job_description)); ?></p>
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
								
								$total_amount=$jobapp['bidprice'] * $jobapp['no_of_persons'] * $job_days * $job_hours;
								$selectedText= "Select";
								if($jobapp['is_winner']==1){ 
									$selectedText= "<span class='winner_col'>Winner</span>";
									$selectedClass = "winner_col";
								}else{
									$selectedClass = "";
								}
								
								  
						?>		
								<tr>
									<td><a href="javascript:void(0);"><?php echo $jobapp['firstname'];?> <?php echo $jobapp['lastname']; ?></a></td>
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
						if((isset($_GET["flag"])) && ( ($_GET["flag"] == "confirm")  || ($_GET["flag"] == "ongoing") || ($_GET["flag"] == "complete") ) ){
					?>		
					<div class="clear"></div>
					<div class="stj_bid_btm stj_bid_btm_full" id="checkLoad">
						<h2>Check-in / Check-out Schedule</h2>
						<div class="bid_table" id="UserSchedule">
							<?php echo getScheduleUser($user_id, $job_id);?>
						</div>

						<!-- Check In / Check Out Start-->
						<?php 
							$currentDate = date('Y-m-d');
							$checkinSql = "SELECT id FROM tblschedule WHERE user_id=$user_id AND job_id=$job_id AND date_check_in='$currentDate' AND check_flag=1";
							$checkinSqlRun = mysql_query($checkinSql);
							$checkNum = mysql_num_rows($checkinSqlRun);
							if($checkNum > 0){
								$checkFlag = 1;
							}else{
								$checkFlag = 2;
							}
						?>
						<div class="feed_cmnt">
							<textarea placeholder="Enter Comment Here"  name="check_comment" id="check_comment"></textarea>
							<?php
							if($checkFlag == 2){?>
								<input type="button" class="btn_cmnt" onclick="javascript:checkInComment(<?php echo $user_id; ?>, <?php echo $job_id; ?>);" value="Check In" />
							<?php } ?>
							
							<?php
							if($checkFlag == 1){?>
								<input type="button" class="btn_cmnt" onclick="javascript:checkOutComment(<?php echo $user_id; ?>, <?php echo $job_id; ?>);" value="Check Out" />
							<?php } ?>

						</div>
						<!-- Check In / Check Out End-->


					</div>
					<div class="stj_chat_wrap">
						<h2>Chat Threads</h2>
						<div class="chat_dv" >
							<div id="chatWindow"><?php echo getChats($job_id,$user_id);?></div>
							<div class="chat_area">
								<textarea placeholder="Type a message"  name="message" id="message"></textarea>
								<input type="button" onclick="javascript:sendMessage(<?php echo $user_id; ?>, <?php echo $job_id; ?>)" class="btn_chat" value="send" />
							</div>
							
						</div>
					</div>
					<?php if((isset($_GET["flag"])) &&  $_GET["flag"] == "complete"  ){ ?>
						<?php getFeedbackUser($user_id, $job_id); ?>
					<?php } ?>
					
					<?php if((isset($_GET["flag"])) &&  $_GET["flag"] == "complete"  ){ ?>
						<div class="feed_wrap" id="posterRate">
							<h4>Rate Job Poster</h4>
							<div class="feed_star_rt">
								<?php
								$jobPosterSql = "SELECT job_user_id FROM tbljobs WHERE job_id=".$job_id." ";
								$jobPosterArray = mysql_query($jobPosterSql);
								$jobPoster = mysql_fetch_array($jobPosterArray);
								$jobPosterId = $jobPoster['job_user_id'];

								$starQuery = mysql_query("SELECT rating FROM tbl_job_poster_rating WHERE user_id=".$user_id." AND job_id=".$job_id." AND job_poster_id=".$jobPosterId." ");
								$starQueryArray = mysql_fetch_array($starQuery);
								$ratingFull = $starQueryArray['rating'];
								$ratingNull = 5 - $ratingFull;
								?>

								<?php
								$j = 1;
								for($i=1; $i<=$ratingFull; $i++){
									echo '<i class="fas fa-star feedback-str-poster-full" onclick="javascript: return feedbackPoster('.$j.', '.$user_id.', '.$job_id.')"></i>';
									$j++;
								}
								?>
								<?php 
								for($i=1; $i<=$ratingNull; $i++){
									echo '<i class="far fa-star feedback-str-poster-null" onclick="javascript: return feedbackPoster('.$j.', '.$user_id.', '.$job_id.')"></i>';
									$j++;
								}
								?>

							</div>
						</div>
					<?php } ?>
					
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