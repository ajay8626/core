<?php
include "config.php";
include "check_user_login.php";
$job_id=isset($_REQUEST['job_id']) && $_REQUEST['job_id']!='' ? $_REQUEST['job_id'] : 0;
$user_id=isset($_SESSION['user_id']) && $_SESSION['user_id']!='' ? $_SESSION['user_id'] : 0;
$jobdetails=mysql_query("select * from tbljobs where job_id='".$job_id."'");
$rowcount=mysql_num_rows($jobdetails);
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
<link href="fonts/font-awesome.css" rel="stylesheet">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.bxslider.js"></script>
<script type="text/javascript" src="js/menu.js"></script>
<script type="text/javascript" src="js/owl.carousel.js"></script>
<script type="text/javascript" src="js/jquery.fancybox.js"></script>
<script type="text/javascript" src="js/at-jquery.js"></script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

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


	function updateStatus(job_id){
	var status = $('#status').val();
    $.ajax(
		{
			url: 'updateStatus.php?job_id='+job_id+"&status="+status,
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
				return false;
			}
			
			$('.stj_loader').hide(); //hide loading animation once data is received
			alert(data);
			
			
			
		})
		.fail(function(jqXHR, ajaxOptions, thrownError)
		{
			
			  //alert('No response from server');
		});
     }
	function selectWinner(user_id,job_id){
    $.ajax(
		{
			url: 'assignWinner.php?user_id='+user_id+"&job_id="+job_id,
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
				return false;
			}
			
			$('.stj_loader').hide(); //hide loading animation once data is received
			if(data == "Success"){
				$("#winnerText_"+user_id).html("Winner");
			}
			else{
				alert(data);
				return false;
			}
			
			
			
		})
		.fail(function(jqXHR, ajaxOptions, thrownError)
		{
			
			  //alert('No response from server');
		});
     }
</script>
</head>
<body>
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
								$totalfinalprice=0;
								$totalfinalized=0;
                                $jobappliedtotal=mysql_query("select jobapply.bidprice,jobapply.no_of_persons from tbljobsapplied as jobapply inner join tbljobs as job on jobapply.job_id = job.job_id
                        inner join tbluser as user on user.user_id = jobapply.user_id WHERE jobapply.job_id =".$job_id." and jobapply.is_winner=1 group by jobapply.user_id order by jobapply.applied_date desc");
						$jobappliedtotalcount=mysql_num_rows($jobappliedtotal);
						        if($jobappliedtotalcount > 0)
								{
									while($datatotal=mysql_fetch_array($jobappliedtotal))
									{
										$bidprice=$datatotal['bidprice'] * $datatotal['no_of_persons'];
									  $totalfinalprice=$totalfinalprice+$bidprice;	
									}
									
								}
								
								if($totalfinalprice > 0)
								{
									$totalfinalized=$totalfinalprice * $job_days * $job_hours;
								}
								
								
								$jobrows=mysql_query("select * from tbljobimages where jobid=".$job_id."");
								$jobrows2=mysql_query("select * from tbljobimages where jobid=".$job_id."");
								$jobcount=mysql_num_rows($jobrows);
								?>
								<?php 
								if($jobcount > 0)
								{
									
								?>
								<div id="sync1" class="owl-carousel">
								   <?php while($imagedata=mysql_fetch_array($jobrows)){ ?>
									<div class="item"><img src="<?php echo JOBS_IMG_URL.$imagedata['imagename'];?>" alt=""/></div>
								   <?php } ?>
									
								</div>
								<div id="sync2" class="owl-carousel">
								<?php while($imagedata1=mysql_fetch_array($jobrows2)){ ?>
									<div class="item"><img src="<?php echo JOBS_IMG_URL.$imagedata1['imagename'];?>" alt=""/></div>
									<?php } ?>
									
								</div>
								<?php } else { ?>
								<div id="sync1" class="owl-carousel">
								<div class="item"><img src="images/bd.jpg" alt=""/></div>
								</div>
								<div id="sync2" class="owl-carousel">
								<div class="item"><img src="images/bd1.jpg" alt=""/></div>
								</div>
								<?php } ?>
							</div>
							<div class="stj_bid_side_con">
								<h2><?php echo $job_name; ?></h2>
								<h5><?php if($jobcategory!=''){  echo '('.$jobcategory.')'; } ?></h5>
								<div class="stj_bid_rating">
									<label>Job Poster’s Ratings:</label>
									<ul>
										<li><img src="images/star.png" alt=""/></li>
										<li><img src="images/star.png" alt=""/></li>
										<li><img src="images/star.png" alt=""/></li>
										<li><img src="images/star.png" alt=""/></li>
										<li><img src="images/star-tr.png" alt=""/></li>
									</ul>
								</div>
								<hr>
								<h3>Amount Willing to pay</h3>
								<div class="price"><?php if($willingtopay!=0 && $willingtopay!=''){ ?>£<?php echo number_format($willingtopay,2); ?><?php } ?></div>
								<div class="price_hrs"><?php if($price){ ?>(£<?php echo $price; ?> Per Hour)<?php } ?></div>
								<h3>Final Amount</h3>
								<div class="price"><?php if($totalfinalized > 0){ ?>£<?php echo number_format($totalfinalized,2); ?> <?php } ?></div>
								<div class="bid_btn bid_btn_ed">
									<a class="bid_edit" href="edit_job.php?job_id=<?php echo $job_id; ?>">Edit</a>
									<a class="bid_delete" href="javascript:void(0);">Delete</a>
								</div>
								<div class="bid_btn">
								     <a class="finalize" href="javascript:void(0);">Finalize Bid</a>
								</div>
							</div>
							   <?php /* ?><div class="jb_status">
									<h4>Status</h4>
									<select name="status" id="status">
										<option value="1" <?php if($job_status == 1) echo "selected";?> >New Job</option>
										<option value="2" <?php if($job_status == 2) echo "selected";?>>Confirm</option>
										<option value="3" <?php if($job_status == 3) echo "selected";?>>On Going</option>
										<option value="4" <?php if($job_status == 4) echo "selected";?>>Complete</option>
									</select>
									<input type="button" value="Update" class="btn_st" onclick="javascript:return updateStatus(<?php echo $job_id;?>)"/>
								</div> <?php */ ?>
						</div>
						<div class="stj_bdt_rgt">
							<ul>
								<li>Duration: <span><?php if($job_days!=''){?> <?php echo $job_days; ?> Days <?php } ?> <?php if($job_hours!=''){ ?>(<?php echo $job_hours;?> hours per day)<?php } ?></span></li>
								<li>Start Date: <span><?php if($start_date!=''){ ?> <?php echo date('d/m/Y',strtotime($start_date)); ?> <?php } ?></span></li>
								<li>Risk Meter: <span><?php echo $risk_txt; ?></span></li>
								<li>Nearest Transport Link: <span><?php if($transport_link!=''){ ?><a href="<?php echo $transport_link; ?>" target="_blank"><?php echo $transport_link; ?></a><?php } ?></span></li>
								<li>Dress Code: <span><?php echo $dresscode; ?></span></li>
							</ul>
							<div class="stj_bdt_rgt_iframe">
								<!--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2477.03027831211!2d-0.10748848403356334!3d51.62265451009037!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487619379d2859c7%3A0xcf88fa1283d62bf4!2s483+Green+Lanes%2C+London+N13+4BS%2C+UK!5e0!3m2!1sen!2sin!4v1520229738490" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>-->
								<iframe src="https://www.google.com/maps?q=<?php echo $job_location; ?>&output=embed" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
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
							<li>Filled Positions: <span>0</span></li>
							<li>Vacant Positions: <span>0</span></li>
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
									
								</tr>
						<?php 
						
						$jobapplied=mysql_query("select user.user_id,user.firstname,user.lastname,job.job_name,jobapply.* from tbljobsapplied as jobapply inner join tbljobs as job on jobapply.job_id = job.job_id
                        inner join tbluser as user on user.user_id = jobapply.user_id WHERE jobapply.job_id =".$job_id." and jobapply.user_id!=".$user_id." group by jobapply.user_id order by jobapply.applied_date desc");
						$jobappliedcount=mysql_num_rows($jobapplied);
						  if($jobappliedcount > 0)
						  {
							while($jobapp=mysql_fetch_array($jobapplied))
							{
								$total_amount=$jobapp['bidprice'] * $jobapp['no_of_persons'] * $job_days * $job_hours;
								$selectedText= "Select";
								if($jobapp['is_winner']==1){ 
									$selectedText= "Winner";
								}
								
								  
						?>		
								<tr>
									<td><a href="javascript:void(0);"><?php echo $jobapp['firstname'];?> <?php echo $jobapp['lastname']; ?></a>
									<ul>
										   <li><img src="images/star.png" alt=""/></li>
										   <li><img src="images/star.png" alt=""/></li>
										   <li><img src="images/star.png" alt=""/></li>
										   <li><img src="images/star.png" alt=""/></li>
										   <li><img src="images/star-tr.png" alt=""/></li>
									    </ul>
									</td>
									<td><?php echo date('d/m/Y',strtotime($jobapp['applied_date'])) ?></td>
									<td>£<?php echo $jobapp['bidprice']; ?></td>
									<td><?php echo $jobapp['no_of_persons']; ?></td>
									<td>£<?php echo $total_amount; ?></td>
									<?php 
									if((isset($_GET["flag"])) && ($_GET["flag"] == "confirm")){
										echo "<td>".$selectedText."</td>";
									}
									else 
									{
									?>
									<td>
										<a href="javascript:void(0);" onclick="javascript:selectWinner(<?php echo $jobapp['user_id']; ?>, <?php echo $jobapp['job_id']; ?>)"><span id="winnerText_<?php echo $jobapp['user_id'];?>"><?php echo $selectedText;?></span></a>
									</td>
									<?php } ?>
								</tr>
						<?php
						   }
                        } 
                        ?>						
								<!--<tr>
									<td><a href="#">User 1</a></td>
									<td>01/03/2018</td>
									<td>20</td>
									<td>20</td>
									<td>15000</td>
									<td></td>
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
								<tr>
									<td><a href="#">User 1</a></td>
									<td>01/03/2018</td>
									<td>20</td>
									<td>20</td>
									<td>15000</td>
									<td></td>
									<td>
										<ul>
										   <li><img src="images/star.png" alt=""/></li>
										   <li><img src="images/star.png" alt=""/></li>
										   <li><img src="images/star.png" alt=""/></li>
										   <li><img src="images/star.png" alt=""/></li>
										   <li><img src="images/star-tr.png" alt=""/></li>
									    </ul>
									</td>
								</tr>-->
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
									<td><?php if($applieddata['is_winner']==1){ ?> Winner <?php } ?></td>
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
					
				</div>
				<div class="stj_loader" style="display:none;">Loading...</div>
			</div>
			
			<?php include "advert-section.php"; ?>
			
		</div>
	</div>
</div>
 
<?php include "footer.php"; ?>
</body>
</html>