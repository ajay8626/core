<?php
include "config.php";
include "check_user_login.php";
$user_id=isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] :0;
$rate_count=rate_count($user_id);
$login_id=isset($_SESSION['user_id']) ? $_SESSION['user_id'] :0;
$currentURL = 'http://'. $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];


//echo "<pre>";print_r($user_id);exit;

/*for business-profile-user*/

	$jobcn="select * from tbljobs where job_user_id=".$user_id." and status=1";
	$jobexc=$db->Query($jobcn);
    $jobRows = mysql_num_rows($jobexc);
	
	$catjoin='';	
	$user_cond='';
	if(isset($user_id) && $user_id!='')
	{
		$user_cond= " and job_user_id=".$user_id."";
	}
	$searchtxt='';
	$orderby='order by tbljobs.isfeatured DESC , tbljobs.job_id desc';
	$featurejob=mysql_query("select tbljobs.* from tbljobs  LEFT JOIN tbljobcategories ON tbljobs.job_id=tbljobcategories.job_id LEFT JOIN tbljobstatus ON tbljobs.job_id=tbljobstatus.job_id where  tbljobs.status=1 and tbljobs.job_status=3  ".$catjoin." ".$user_cond." ".$searchtxt." group by tbljobs.job_id ".$orderby."");
	$frow=mysql_num_rows($featurejob);
	
	/*$completejob=mysql_query("select tbljobs.* from tbljobs  LEFT JOIN tbljobcategories ON tbljobs.job_id=tbljobcategories.job_id LEFT JOIN tbljobstatus ON tbljobs.job_id=tbljobstatus.job_id where  tbljobs.status=1 and tbljobs.job_status=4  ".$catjoin." ".$user_cond." ".$searchtxt." group by tbljobs.job_id ".$orderby."");*/
	$completejob=mysql_query("select status_id  FROM tbljobstatus WHERE user_id=".$user_id." and status=3");
	$completerow=mysql_num_rows($completejob);
	
	$reviewsSql = mysql_query("select tbljobs.* from tbljobs LEFT JOIN tbljobcategories ON tbljobs.job_id=tbljobcategories.job_id LEFT JOIN tbljobstatus ON tbljobs.job_id=tbljobstatus.job_id where tbljobs.status=1 and tbljobs.job_status=4 and tbljobstatus.status=4 and tbljobs.job_user_id=".$_SESSION['user_id']."");
	$reviewsRow = mysql_num_rows($reviewsSql);





$sql="select * from tbluser where user_id=".$user_id."";
	$exc=$db->Query($sql);
    $totRows = mysql_num_rows($exc);
	$rows=mysql_fetch_array($exc);
	$c_name=$rows['company_name'];
	$first_name=$rows['firstname'];
	$lastname=$rows['lastname'];
	$phone=$rows['phone'];
	$address_1=$rows['address_1'];
	$address_2=$rows['address_2'];
	$address_3=$rows['address_3'];
	$bank_name=$rows['bank_name'];
	$acc_holder_name=$rows['acc_holder_name'];
	$sort_code=$rows['sort_code'];
	$acc_number=$rows['acc_number'];
	$reg_no=$rows['reg_no'];
	$reg_vat_no=$rows['reg_vat_no'];
	$user_email=$rows['email'];
	$profile_image=$rows['profile_image'];
	$profilevideo=$rows['profilevideo'];
	$birthdate=$rows['birthdate'];
	$gender=$rows['gender'];
	$height=$rows['height'];
	$customer_type=$rows['customer_type'];
	$nationality=$rows['nationality'];
	$build=$rows['build'];
	$language=$rows['language'];
	$total_credit=$rows['total_credit'];
	$is_email_verify=$rows['is_email_verify'];
	$birthdate_txt='';
	$diff='';
	$userref=get_referel($login_id);
	
	if($birthdate!='' && $birthdate!='1970-01-01')
	{
		$birthdate_txt=date('d.m.Y',strtotime($birthdate));
		$today = date("Y-m-d");
		$diff = date_diff(date_create($birthdate), date_create($today));
	}
	
	if($gender==1)
	{
		$gender_txt='Male';
	}
	if($gender==2)
	{
		$gender_txt='Female';
	}
	
	$militry=$rows['militry'];
	$militry_txt='No';
	if($militry==1)
	{
		$militry_txt='Yes';
	}
	$drive=$rows['drive'];
	$drive_txt='No';
	if($drive==1)
	{
		$drive_txt='Yes';
	}
	$firstaid=$rows['firstaid'];
	$firstaid_txt='No';
	if($firstaid==1)
	{
		$firstaid_txt='Yes';
	}
	$tattoos=$rows['tattoos'];
	$tattoos_txt='No';
	if($tattoos==1)
	{
		$tattoos_txt='Yes';
	}
	$piercing=$rows['piercing'];
	$piercing_txt='No';
	if($piercing==1)
	{
		$piercing_txt='Yes';
	}
    $right_to_work_uk=$rows['right_to_work_uk'];
	$right_to_work_uk_txt='No';
	if($right_to_work_uk==1)
	{
		$right_to_work_uk_txt='Yes';
	}
    
    $willing_to_travel=$rows['willing_to_travel'];
	$willing_to_travel_txt='No';
	if($willing_to_travel==1)
	{
		$willing_to_travel_txt='Yes';
	}
    
    $uk_driving_license=$rows['uk_driving_license'];
	$uk_driving_license_txt='No';
	if($uk_driving_license==1)
	{
		$uk_driving_license_txt='Yes';
	}
    
    $cscs_card=$rows['cscs_card'];
	$cscs_card_txt='No';
	if($cscs_card==1)
	{
		$cscs_card_txt='Yes';
	}
    
	$sia=$rows['sia'];
	$sia_txt='No';
	if($sia==1)
	{
		$sia_txt='Yes';
		$sia_1=$rows['sia_1'];
		$sia_2=$rows['sia_2'];
		$sia_3=$rows['sia_3'];
		$sia_4=$rows['sia_4'];
	}
	$activity=$rows['activity'];
	$health=$rows['health'];
	$bio=$rows['bio'];
	$experience=$rows['experience'];
	$education_credentials=$rows['education_credentials'];
	$from=get_from_availability($user_id);
	$to=get_to_availability($user_id);
	$from_day=ucfirst(get_from_day_availability($user_id));
	$to_day=ucfirst(get_to_day_availability($user_id));
	$referralCode=$rows['referralCode'];
	$last_login=$rows['last_login'];
	$last_logout=$rows['last_logout'];
	$l_login = strtotime($last_login);
	$l_logout = strtotime($last_logout);

	$daysdiff=0;
	$hourdiff=0;
	$minutediff=0;
	if($last_logout!='')
	{
		$currentdateTime=date('Y-m-d h:i:s');
		
		$datetime1 = new DateTime($last_logout);
        $datetime2 = new DateTime($currentdateTime);
        $interval = $datetime1->diff($datetime2);
		$daysdiff=$interval->format('%d');
		$hourdiff=$interval->format('%h');
		$minutediff=$interval->format('%i');
		
		/* echo $interval->format('%h')." Hours ".$interval->format('%i')." Minutes";
		exit; */
	}
	
	if($address_1!='')
	{
		$address=$address_1;
	}
	if($address_1!='' && $address_2!='')
	{
		$address.=", ".$address_2;
	}
	if($address_1!='' && $address_2!='' && $address_3!='')
	{
		$address.=", ".$address_3;
	}
	$like=get_like($login_id,$user_id);
	
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
<title>Rate Card - SECURE THAT JOB</title>

<!-- Bootstrap -->
<link href="https://fonts.googleapis.com/css?family=Fira+Sans:300,400,400i,500,600,700,800" rel="stylesheet"> 
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link href="css/ddsmoothmenu.css" rel="stylesheet">
<link href="css/jquery.fancybox.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<link href="fonts/font-awesome.css" rel="stylesheet">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.bxslider.js"></script>
<script type="text/javascript" src="js/menu.js"></script>
<script type="text/javascript" src="js/jquery.fancybox.js"></script>
<script type="text/javascript" src="js/at-jquery.js"></script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({includedLanguages: '<?php echo LanguageList; ?>', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();

		$(".fancybox_pdf").fancybox({
			'frameWidth': 100,
			'frameHeight':495,
			'overlayShow':true,
			'hideOnContentClick':false,
			'type':'iframe'
		})
	});
</script>

<script>
jQuery(document).ready(function($) {
  
  $( ".fa.fa-heart-o" ).click(function() {
	  
				var userid=$( this ).attr("id");
				if(userid!='')
				{
					$.post("get_favourite.php",
					{
						userid:userid
					},
					function(data) {
					});
					
					
				}
			 $( this ).toggleClass( "like" );
            });
    /* $( ".fa-heart-o" ).click(function() {
	  
				var userid=$( this ).attr("id");
				if(userid!='')
				{
					$.post("get_favourite.php",
					{
						userid:userid
					},
					function(data) {
					});
					
					
				}
				
			$( this ).removeClass("fa fa-heart-o");	
            $( this ).addClass("fa fa-heart");
            }); */
  $('.g_vd').fancybox();
	
});
</script>
</head>
<?php if(isset($user_id)){
	$link='login.php';
	if(isset($user_id) && $customer_type==1)
	{
		$profileCLass = 'business-profile-class';
	}
	if(isset($user_id) && $customer_type==2)
	{
		$profileCLass = 'individual-profile-class';
	}
}

?>

<body class="<?php echo $profileCLass; ?>">
	<?php include "header-inner.php"; ?>
	<div class="bp_wrap ip_wrap gd_wrap">
		<div class="container">
			<div class="row">
				
				<div class="bp_dv <?php //echo $profileCLass; ?>">
					
					<div class="gd_br"></div>
					<div class="gd_profile">
						<div class="gd_prf_img">


							<?php

						    if($profile_image!=''){
									/* $src=CUSTOMER_PROFILE_IMG_URL.get_image_thumbnail($profile_image); */
									$upload_extension =  explode(".", $profile_image);
									$upload_extension = end($upload_extension);
										if ((strlen($upload_extension)==3) || (strlen($upload_extension)==4)) {
											$img=CUSTOMER_PROFILE_IMG_URL.$profile_image;
										} else {
											$img=$profile_image;
										}
										$src=$profile_image;
								?>
								<img id="uploadedImage" class="cropped" src="<?php echo $img; ?>" style="width:100px;height:100px;"   />
								<?php } else { ?>
								<img id="uploadedImage" class="cropped" src="" style="width:100px;display:none;height:100px;"   />
								<?php } ?> 
						</div>
						<div class="gd_prf_con">
							<!--<img class="sia_lg" src="images/sia.png" alt=""/>-->
							<h2><?php echo $first_name; ?> <?php echo $lastname; ?></h2>
							<br>
							<br>
							
							<?php 
							if($l_login > $l_logout){
								$difftime='ONLINE';
							}else{
								$difftime='';
							}
							if(($daysdiff!=0 || $hourdiff!=0 || $minutediff!=0) && ($l_logout > $l_login) )
							{
								
								if($daysdiff!=0 && $hourdiff!=0){
									if($daysdiff == 1){
										$difftime='Last Active '.$daysdiff.'Day ' .$hourdiff.'H'.' ago';
									}else{
										$difftime='Last Active '.$daysdiff.'Days ' .$hourdiff.'H'.' ago';
									}
								}
								if($daysdiff==0 && $hourdiff!=0 && $minutediff!=0){
									$difftime='Last Active '.$hourdiff.'H '.$minutediff.'M'.' ago';
								}
								if($daysdiff==0 && $hourdiff==0 && $minutediff!=0){
									$difftime='Last Active '.$minutediff.'M'.' ago';
								}
								
							?>
							<?php } else { 
								if(($daysdiff==0 || $hourdiff==0 || $minutediff==0) && ($l_logout > $l_login) ){
									$difftime='Last active few seconds ago';
								}
							?>
							<?php } ?>
							<p><?php echo $difftime; ?></p>
						</div>
					</div>
					
					<div class="bp_dv_dtl">
					    
					    <div class="gd_rate">
					    	<ul>
					    		<li><?php echo $rate_count; ?> Jobs Completed</li>
								<?php if($like==1){ ?>
					    		<li><i class="fa fa-heart-o like" id="<?php echo $user_id; ?>"></i></li>
								<?php } else { ?>
								<li><i class="fa fa-heart-o" id="<?php echo $user_id; ?>"></i></li>
								<?php } ?>
								<?php if($profilevideo!=''){ ?>
								<li><label>Profile Video</label>
					    		 <div class="gd_vd">
								 <?php if($profilevideo!=''){ ?>
									<!-- <a class="g_vd" href="#g_id1"><img class="prof_vid" src="images/play.png" alt=""/></a> -->
									<a class="g_vd" href="#g_id1"><img class="prof_vid" src="" alt=""/></a>
									<div>
									<?php $videoSrc = CUSTOMER_PROFILE_VIDEO_URL.$profilevideo; ?>
										<video width="700" height="450">
											<source src="<?php echo $videoSrc ?>" type="video/mp4"> Your browser does not support the video tag.
										</video> 
									</div>
					    		 <?php } ?>
					    		 </div>
								 <?php if($profilevideo!=''){ ?>
					    		 <div style="display: none;">
						            <div class="gd_pop" id="g_id1">
										<?php $videoSrc = CUSTOMER_PROFILE_VIDEO_URL.$profilevideo; ?>
										<video width="700" height="450" controls>
											<source src="<?php echo $videoSrc ?>" type="video/mp4"> Your browser does not support the video tag.
										</video>
									</div>
					             </div>
								 <?php } ?>
								</li> <?php } ?>
								<?php
									/* User Rating Individually */
									$rating_sql = "SELECT * FROM tblfeedback WHERE user_id=$user_id";
									$rating_exc = mysql_query($rating_sql);
									$rating_row_count = mysql_num_rows($rating_exc);
									$user_performance = 0;
									$user_punctuality = 0;
									$user_presentation = 0;
									$user_dresscode = 0;
									$user_attitude = 0;
									if($rating_row_count > 0){
										while($rating_rows = mysql_fetch_array($rating_exc)){
											$user_performance +=  $rating_rows['performance'];
											$user_punctuality +=  $rating_rows['punctuality'];
											$user_presentation +=  $rating_rows['presentation'];
											$user_dresscode +=  $rating_rows['dresscode'];
											$user_attitude +=  $rating_rows['attitude'];
										}
										
										echo "<li>Performance: ".(int)(($user_performance * 20)/$rating_row_count)."%</li>";
										echo "<li>Punctuality: ".(int)(($user_punctuality * 20)/$rating_row_count)."%</li>";
										echo "<li>Presentation: ".(int)(($user_presentation * 20)/$rating_row_count)."%</li>";
										echo "<li>Dress Code: ".(int)(($user_dresscode * 20)/$rating_row_count)."%</li>";
										echo "<li>Attitude: ".(int)(($user_attitude * 20)/$rating_row_count)."%</li>";
									
										/* User Rating Overall */
										$overallRating = ($user_performance/$rating_row_count) + ($user_punctuality/$rating_row_count) + ($user_presentation/$rating_row_count) + ($user_dresscode/$rating_row_count) + ($user_attitude/$rating_row_count);
										$overallRating = (($overallRating / 5) * 20);
										$starsFull = (int)($overallRating / 20);
										$starsempty = 5 - $starsFull;

										echo "<li>";
										for($i=1; $i<=$starsFull; $i++){
											echo '<i class="fas fa-star feedback-str-full"></i>';
										}
										for($i=1; $i<=$starsempty; $i++){
											echo '<i class="far fa-star feedback-str-null"></i>';
										}
										echo "</li>";
									}
								?>
							</ul>
						</div>
						

						<?php 
						if ($customer_type == 1) { ?>

							<div class="bp_dv_lftdtl">
								<div class="bp_crd">
									<div class="bp_crd_dtl">
										your total credits
										<span><?php echo $total_credit; ?></span>
									</div>

									<?php 
									if ($_SESSION['user_id'] == $user_id) { ?>
										<a class="a_bmc" href="#" data-toggle="modal" data-target="#addCredites">Buy more credits</a>
									<?php }
									?>
								</div>
						
							    <div class="bp_code">
							      <h3>Referral Code</h3>
							      <span><?php echo $referralCode ?></span>
							      <p>Share referral code with your friends and get free discount vouchers.</p>
							    </div>
							</div>
							
								
								
									<div class="gd_full_dtl">

										<ul class="bp_jobs_link">
											<li><a href="created_jobs.php">Jobs Created <span><?php echo $jobRows; ?></span></a></li>
											<li><a href="currentjobs.php">Current Jobs <span><?php echo $frow; ?></span></a></li>
											<li><a href="completeduserjobs.php">Completed Jobs <span><?php echo $completerow; ?></span></a></li>
											<li><a href="my_reviews.php">Reviews <span><?php echo $reviewsRow; ?></span></a></li>
											<?php 
											if ($_SESSION['user_id'] == $user_id) { ?>

											<li><a class="a_lk" href="#" data-toggle="modal" data-target="#addCredites"><img class="prof_icon" src="images/euro-b.png" alt=""/>Buy Credits</a></li>
											<li><a class="a_lk" href="profile-edit.php"><img class="prof_icon" src="images/edit-b.png" alt=""/>Edit Profile</a></li>
												
											<?php }
											?>
										</ul>

										<h3>Account Details</h3>
										<ul>
											<li class="add_dtl"><?php if($c_name != ''){ echo $c_name.','; }?> <?php echo $address; ?></li>
											<li class="call_dtl"><?php echo $phone; ?> <!--<a href="#">(Verify)</a>--></li>
											<li class="user_dtl"><?php echo $first_name; ?> <?php echo $lastname; ?></li>

											<?php
											if ($_SESSION['user_id'] == $user_id) { ?>

											<li class="mail_dtl"><?php echo $user_email; ?> <?php if($is_email_verify==1 || $isSocial!=0){ ?> <span class="a_vy">(Verified)</span> <?php } else { ?><a href="emailverify.php?email=<?php  echo  $user_email;?>">(Verify)</a> <?php } ?></li>
											<!-- <li class="pass_dtl"> **** <input type="password" name="old_password" id="old_password" style="display:none;" placeholder="Enter Your Old Password" value="" class="txt_lg" /> <input type="password" name="user_password" id="user_password" style="display:none;" value="" class="txt_lg" placeholder="Enter Your New Password" /><input type="password" name="confirm_password" id="confirm_password" style="display:none;" value="" class="txt_lg" placeholder="Enter Your Confirm Password" /><a  id="edit_password" href="javascript:void(0);">(Change Password)</a> 
											<input type="hidden" name="is_update_password" id="is_update_password" value="1">
											</li> -->
												
											<?php } else{ ?>
												<li class="mail_dtl"><?php echo $user_email; ?></li>
										<?php	}

											?>

											
											<?php
												//Member Since
												$todayDate = date('Y-m-d h:i:s');
												$datetime1 = new DateTime($todayDate);
												$datetime2 = new DateTime($created_date);
												$interval = $datetime1->diff($datetime2);
												$checkYear = $interval->format('%y');
												$checkMonth = $interval->format('%m');
												$checkDay = $interval->format('%d');

												if($checkYear==1 && $checkMonth==1 && $checkDay==1){
													$timeOld = $interval->format('%y Year %m Month %d Day');
												}elseif($checkYear==0 && $checkMonth==0 && $checkDay>1){
													$timeOld = $interval->format('%d Days');
												}elseif($checkYear==0 && $checkMonth>1 && $checkDay>1){
													$timeOld = $interval->format('%m Months %d Days');
												}elseif($checkYear>1 && $checkMonth>1 && $checkDay>1){
													$timeOld = $interval->format('%y Years %m Months %d Days');
												}elseif($checkYear>1 && $checkMonth<=1 && $checkDay<=1){
													$timeOld = $interval->format('%y Years %m Month %d Day');
												}elseif($checkYear<=1 && $checkMonth>1 && $checkDay>1){
													$timeOld = $interval->format('%y Year %m Months %d Days');
												}elseif($checkYear<=1 && $checkMonth>1 && $checkDay<=1){
													$timeOld = $interval->format('%y Year %m Months %d Day');
												}elseif($checkYear==0 && $checkMonth==1 && $checkDay==0){
													$timeOld = $interval->format('%m Month');
												}

											?>
											<?php if($checkYear==0 && $checkMonth==0 && $checkDay==0){ ; ?>
												
											<?php }else{ ?>
												<li class="user_dtl">Member Since: <?php echo $timeOld; ?></li>	
											<?php } ?>	
										</ul>
								</div>
							
								
							
							
					<?php	} else { ?>
							
							<div class="gd_full_dtl">
						    	<h3>Personal Details</h3>
						    	<ul>
									<?php
										
										$condQue = "SELECT a.*, b.* FROM tbljobs a, tbljobsapplied b WHERE a.job_id = b.job_id and a.job_user_id = ".$login_id." and b.user_id=".$user_id." and b.is_winner=1 ";
										$condQueExe = mysql_query($condQue);
										$numberOfRows = mysql_num_rows($condQueExe);
									if($numberOfRows > 0){
									?>
									
									<?php if($user_email!=''){ ?>
									<li><label>Email Address:</label><?php echo $user_email; ?></li>
						    		<?php } ?>
									<?php if($phone!=''){ ?>
									<li><label>Mobile No:</label><?php echo $phone; ?></li>
									<?php } ?>
									<?php if($sia_txt!='Yes'){ ?>
									<li><label>SIA No:</label><?php echo $sia_1." ".$sia_2." ".$sia_3." ".$sia_4 ; ?></li>
									<?php } ?>
									
									<?php } ?>

									<?php if($diff!=''){ ?>
									<li><label>Age:</label><?php if($diff!=''){ echo $diff->format('%y'); ?> Years <?php } ?> <?php if($diff->format('%m')!=''){ echo $diff->format('%m'); ?> Months <?php } ?></li>
									<?php } ?>
									<?php if($gender==1 || $gender==2){ ?>
						    		<li><label>Gender:</label><?php echo $gender_txt; ?></li>
						    		<?php } ?>
									<?php if($height!=''){ ?>
									<li><label>Height:</label><?php echo $height; ?> cms</li>
						    		<?php } ?>
									<?php if($build!=''){ ?>
									<li><label>Build:</label><?php echo ucfirst($build); ?></li>
						    		<?php } ?>
									<?php if($nationality!=''){ ?>
									<li><label>Nationality:</label><?php echo ucfirst($nationality); ?></li>
						    		<?php } ?>
									
									<?php 
										$saveAvailSql = mysql_query("SELECT * FROM tbluser_availability WHERE user_id=".$user_id." ORDER BY day_id ASC");
										$saveAvailSqlCount = mysql_num_rows($saveAvailSql); 
									?>
									<?php if($saveAvailSqlCount > 0){ ?>
									<li><label>Availability Status:</label></li>
									<?php while($availRow = mysql_fetch_assoc($saveAvailSql)){ ?>
									<li><?php echo ucfirst($availRow['from_day']).": ".$availRow['from_time']." - ".$availRow['to_time']  ?></li>
									<?php } ?>
									<?php } ?>
									
									<?php if($language!=''){ ?>
									<li><label>Spoken Language :</label><?php echo ucfirst($language); ?></li>
									<?php } ?>
									<?php if($militry_txt == 'Yes'){ ?>
									<li><label>Military Background?:</label><?php echo $militry_txt; ?></li>
									<?php } ?>
									<?php if($drive_txt == 'Yes'){ ?>
									<li><label>Car Driving:</label><?php echo $drive_txt; ?></li>
									<?php } ?>
									<?php if($firstaid_txt == 'Yes'){ ?>
									<li><label>First Aid & Paramedic Training:</label><?php echo $firstaid_txt; ?></li>
									<?php } ?>
									<?php if($tattoos_txt == 'Yes'){ ?>
									<li><label>Visible Tattoos:</label><?php echo $tattoos_txt; ?></li>
									<?php } ?>
									<?php if($piercing_txt == 'Yes'){ ?>
									<li><label>Visible Piercings:</label><?php echo $piercing_txt; ?></li>
									<?php } ?>
		                            <?php if($right_to_work_uk_txt == 'Yes'){ ?>
									<li><label>Do you have right to work in UK?:</label><?php echo $right_to_work_uk_txt; ?></li>
									<?php } ?>
		                            <?php if($willing_to_travel_txt == 'Yes'){ ?>
									<li><label>Willing to travel abroad?:</label><?php echo $willing_to_travel_txt; ?></li>
									<?php } ?>
		                            <?php if($uk_driving_license_txt == 'Yes'){ ?>
									<li><label>Do you hold full UK Driving License?:</label><?php echo $uk_driving_license_txt; ?></li>
									<?php } ?>
		                            <?php if($cscs_card_txt == 'Yes'){ ?>
									<li><label>Do you have CSCS card?:</label><?php echo $cscs_card_txt; ?></li>
									<?php } ?>
						    		<?php if($activity!=''){ ?>
									<li><label>Any Ailments impairing ability:</label><?php echo $activity; ?></li>
									<?php } ?>
									<?php if($health!=''){ ?>
						    		<li><label>Health Issues:</label><?php echo $health; ?></li>
						    		<?php } ?>
									<?php if($bio!=''){ ?>
									<li><label>Bio:</label><?php echo $bio; ?></li>
						    		<?php } ?>
		                            <?php if($experience!=''){ ?>
									<li><label>Experience:</label><?php echo $experience; ?></li>
						    		<?php } ?>
		                            <?php if($education_credentials!=''){ ?>
									<li><label>Education and Further Credentials:</label><?php echo $education_credentials; ?></li>
									<?php } ?>
									<!-- Certificates -->
									<?php
										$condQueC = "SELECT a.*, b.* FROM tbljobs a, tbljobsapplied b WHERE a.job_id = b.job_id and a.job_user_id = ".$login_id." and b.user_id=".$user_id." and b.is_winner=1 ";
										$condQueExeC = mysql_query($condQueC);
										$numberOfRowsC = mysql_num_rows($condQueExeC);
										if($numberOfRowsC > 0){
									?>
									<?php 
												$certiCount=0;
												if(isset($user_id) && $user_id!='') {
													$userCerties=mysql_query("select * from tbl_user_certi where user_id=".$user_id."");
													$certiCount=mysql_num_rows($userCerties);
												}		
												if ($certiCount > 0) { 							
											?>
											<li>
												Certificate:
												<div id="certiPreview">
											<?php 
											
												while($userCerti = mysql_fetch_assoc($userCerties)) {
													$certiId = $userCerti['id'];
													$certiName = $userCerti['certificate'];
													$certiUserId = $userCerti['user_id'];
													$certiMime = $userCerti['certi_mime'];

													if($userCerti['certificate'] != ""){
											?>
											<?php if($certiMime != 'pdf'){ ?>
												<a class="fancybox" rel="group" href="<?php echo CUSTOMER_CERTIFICATE_IMG_URL.$certiName; ?>">
													<img src="<?php echo CUSTOMER_CERTIFICATE_IMG_URL.$certiName; ?>" style="width:100px;" alt="">
												</a>
											<?php }else{ ?>
												<a class="fancybox_pdf" rel="group" href="<?php echo CUSTOMER_CERTIFICATE_IMG_URL.$certiName; ?>">
													<img src="images/pdf_image.png" style="width:100px;" alt="">
												</a>
											<?php } ?>
											<?php 		
													}
												}
											?>
												</div>
											</li>
											<?php } ?>
											<?php } ?>
									
								</ul>

								<!-- Social Share Profile -->
								<div class="stj_bid_descp social_ico">
									
									<h3>Share this profile: </h3>
									<!-- Facebook -->
									<a href="<?php echo $currentURL; ?>" class="share facebook fa fa-facebook"></a>

									<!-- Google Plus -->
									<!-- <a href="<?php //echo $currentURL; ?>" class="share google-plus fa fa-google"></a> -->

									<!-- Twitter -->
									<a href="<?php echo $currentURL; ?>" data-text="" class="share twitter fa fa-twitter"></a>
									
									<!-- LinkedIn -->
									<a href="<?php echo $currentURL; ?>"  data-text=""  class="share linkedin fa fa-linkedin"></a>

								</div>


						    	<div class="gd_fd_btm">
						    		<h4>Enter Information and send to hire candidate</h4>
						    		<h5>Select Job to be hired for</h5>
						    		<form method="post" name="job" id="job" action="hire.php">
									<input type="hidden" name="request_id" id="request_id" value="<?php echo $user_id; ?>">
									<div class="radio">
										<div class="rdrow">
										    <input name="jobtype" checked value="1" id="rd1" class="rd_chk" type="radio">
										    <label for="rd1">Select From existing</label>
										</div>
										<div class="rdrow">
											<input name="jobtype" id="rd2" value="2" class="rd_chk" type="radio">
										    <label for="rd2">Create New</label>
										</div>
									</div>
					    	        <select name="job_list" id="exist_job_list">
									<option value="0">Select Job</option>
									<?php 
									$joblist=mysql_query("select job_id,job_name from `tbljobs` where status=1 and job_status=1 and job_user_id=".$_SESSION['user_id']." and start_date >='".date("Y-m-d h:i:s")."'");
									$jobrows=mysql_num_rows($joblist);
									if($jobrows > 0)
									{
										while($jobs=mysql_fetch_array($joblist))
										{
									?>	
		                             <option value="<?php echo $jobs['job_id']; ?>"><?php echo $jobs['job_name']; ?></option>
		                            <?php }
									}
									?>							
												<!--<option>Select Job</option>
												<option>Select Job</option>
												<option>Select Job</option>
												<option>Select Job</option>-->
									</select>
					    	      <input value="Invite" class="btn_gd" id="btn_gd_gd" type="submit">
						    	  </form>
								</div>
									<!-- Modal Area Start (Add Credits) -->
								<div class="modal fade" id="addCredites">
									<div class="modal-dialog modal-dialog-centered">
									<div class="modal-content ">
									
										<!-- Modal Header -->
										<h2 class="modal-title modal-head-css">Add Credits</h2>
										<!-- <div class="modal-header">
										<h4 class="modal-title">Add Credit</h4>
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										</div> -->
										
										<!-- Modal body -->
										<div class="modal-body paypal_btn">
										<h6>Your credits amount: &pound;<?php echo $total_credit; ?></h6>
										<br/>

											<!-- Add Credit -->
											<form action="paypal/payments.php" method="post" id="paypal_form" target="_blank">
												<input type="hidden" name="cmd" value="_xclick" />
												<input type="hidden" name="no_note" value="1" />
												<input type="hidden" name="lc" value="UK" />
												<input type="hidden" name="currency_code" value="GBP" />
												<input type='hidden' name='rm' value='2'>
												<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
												<input type="hidden" name="first_name" value="<?php echo $firstName; ?>"  />
												<input type="hidden" name="last_name" value="<?php echo $lastName; ?>"  />
												<label for="amount" style="display:block">Deposit money by PayPal</label>
												<input type="number" class="txt_add_credit" name="amount" placeholder="Amount to deposit"  />
												<input type="hidden" name="item_name" value="<?php echo 'Credits'; ?>" / >
												<input type="hidden" name="item_number" value="<?php echo $_SESSION['last_id']; ?>" / >
												<input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>" / >
												<input type="hidden" name="custom" value="add_credits_individual_profile" / >
												<input type="submit" name="paypal" class="add_credit_btn" value="Deposit"/>
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
								
						    </div>
							<div class="bp_dv_lftdtl">
								<div class="bp_crd">
									<div class="bp_crd_dtl <?php echo $profileCLass; ?>">
										total credits
										<span><?php echo $total_credit; ?></span>
									</div>
									<?php if ($_SESSION['user_id'] == $user_id) { ?>
									<a class="a_bmc" href="#" data-toggle="modal" data-target="#addCredites">Buy more credits</a>
									<?php } ?>
									<!-- <a class="a_bmc" href="#">Buy more credits</a> -->
								</div>
							
							    <div class="bp_code">
							      <?php if($userref!=''){ ?>
								  <h3>Referral Code</h3>
							      <span><?php echo $userref; ?></span>
								  
							      <p>Share referral code with your friends and get free discount vouchers.</p>
							      <?php } ?>
								</div>
							    
							    <div class="ip_avail">
							    	<?php 
										$saveAvailSql = mysql_query("SELECT * FROM tbluser_availability WHERE user_id=".$user_id." ORDER BY day_id ASC");
										$saveAvailSqlCount = mysql_num_rows($saveAvailSql); 
									?>
									<h3>Availability</h3>
									<ul style="list-style: none;">
							    	<?php while($availRow = mysql_fetch_assoc($saveAvailSql)){ ?>
									<li><?php echo ucfirst($availRow['from_day']).": ".$availRow['from_time']." - ".$availRow['to_time']  ?></li>
									<?php } ?>
									</ul>
									
							    </div>
							    
							    <div class="ip_avail">
									<?php
									/* Check if there is atleast one entry so that title can be displayed. */
									$checkFLag = 0;
									$sqll=mysql_query("select category_id,category_name from tblcategory where isactive=1 order by category_name");
									$rowss=mysql_num_rows($sqll);
									if($rowss > 0)
									{
										while($catdataa=mysql_fetch_array($sqll))
										{
											$getratecards=get_rate_card($catdataa['category_id'], $user_id);
									 		if($getratecards!=0){
												$checkFLag += 1;
											 }
										}
									} 
									?>
									<?php if($checkFLag > 0){ ?>
										<!-- Title -->
										<h3>Rate Card</h3>
									<?php } ?>
							    	<ul>
									    <?php 
										 $sql=mysql_query("select category_id,category_name from tblcategory where isactive=1 order by category_name");
										 $rows=mysql_num_rows($sql);
								        if($rows > 0)
								        {
									      while($catdata=mysql_fetch_array($sql))
									       {
										 		$getratecard=get_rate_card($catdata['category_id'],$user_id);
										 ?>
										<?php if($getratecard!=0){ ?>
											<li><?php echo $catdata['category_name']; ?> <span>£<?php echo $getratecard; ?></span></li>
										<?php } ?>
							    		<?php
										   }
										}
										?>
							    	</ul>
								</div>
								
							</div>

						<?php

						}
						
						?>
					    
					    
						
					</div>
					
				</div>
				
			</div>
		</div>
	</div>
	<script>
	$('#rd1').click(function() {
	  if ($(this).is(':checked')) {
	    $('#exist_job_list').removeClass('hidden');
		$('#btn_gd_gd').val('Invite');
	  }
	});

	$('#rd2').click(function() {
	  if ($(this).is(':checked')) {
	    $('#exist_job_list').addClass('hidden');
		$('#btn_gd_gd').val('Create');
	  }
	});
	</script>
	<?php include "footer.php"; ?>
</body>
</html>