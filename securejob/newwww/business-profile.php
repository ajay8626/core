<?php 
include "config.php"; 

if(!isset($_SESSION['user_id']))
{
	header("Location:login.php");
	exit();
}
$c_name='';
$jobRows=0;
$first_name='';
$lastname='';
$phone='';
$address_1='';
$address_2='';
$address_3='';
$bank_name='';
$acc_holder_name='';
$sort_code='';
$acc_number='';
$reg_no='';
$reg_vat_no='';
$user_email='';
$address='';
$total_credit='';
$is_email_verify='';
$frow=0;
$completerow=0;
if(isset($_SESSION['user_id']) && $_SESSION['user_id']!='')
{
	$sql="select * from tbluser where user_id=".$_SESSION['user_id']."";
	$exc=$db->Query($sql);
    $totRows = mysql_num_rows($exc);
	$rows=mysql_fetch_array($exc);
	$c_name=$rows['company_name'];
	$first_name=$rows['firstname'];
	$lastname=$rows['lastname'];
	$created_date = $rows['created_date'];
	$phone=$rows['phone'];
	$address_1=$rows['address_1'];
	$address_2=$rows['address_2'];
	$address_3=$rows['address_3'];
	$bank_name=$rows['bank_name'];
	$acc_holder_name=$rows['acc_holder_name'];
	$sort_code=$rows['sort_code'];
	$acc_number=$rows['acc_number'];
	$profile_image=$rows['profile_image'];
	$reg_no=$rows['reg_no'];
	$reg_vat_no=$rows['reg_vat_no'];
	$user_email=$rows['email'];
	$total_credit=$rows['total_credit'];
	$password=$rows['password'];
	$is_email_verify=$rows['is_email_verify'];
	$isSocial=$rows['isSocial'];
	$referralCode=$rows['referralCode'];
	$latitude=$rows['latitude'];
	$longitude=$rows['longitude'];
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
	
	$jobcn="select * from tbljobs where job_user_id=".$_SESSION['user_id']." and status=1";
	$jobexc=$db->Query($jobcn);
    $jobRows = mysql_num_rows($jobexc);
	
	$catjoin='';	
	$user_cond='';
	if(isset($_SESSION['user_id']) && $_SESSION['user_id']!='')
	{
		$user_cond= " and job_user_id=".$_SESSION['user_id']."";
	}
	$searchtxt='';
	$orderby='order by tbljobs.isfeatured DESC , tbljobs.job_id desc';
	$featurejob=mysql_query("select tbljobs.* from tbljobs  LEFT JOIN tbljobcategories ON tbljobs.job_id=tbljobcategories.job_id LEFT JOIN tbljobstatus ON tbljobs.job_id=tbljobstatus.job_id where  tbljobs.status=1 and tbljobs.job_status=3  ".$catjoin." ".$user_cond." ".$searchtxt." group by tbljobs.job_id ".$orderby."");
	$frow=mysql_num_rows($featurejob);
	
	$completejob=mysql_query("select tbljobs.* from tbljobs  LEFT JOIN tbljobcategories ON tbljobs.job_id=tbljobcategories.job_id LEFT JOIN tbljobstatus ON tbljobs.job_id=tbljobstatus.job_id where  tbljobs.status=1 and tbljobs.job_status=4  ".$catjoin." ".$user_cond." ".$searchtxt." group by tbljobs.job_id ".$orderby."");
	$completerow=mysql_num_rows($completejob);
	
	$reviewsSql = mysql_query("select tbljobs.* from tbljobs LEFT JOIN tbljobcategories ON tbljobs.job_id=tbljobcategories.job_id LEFT JOIN tbljobstatus ON tbljobs.job_id=tbljobstatus.job_id where tbljobs.status=1 and tbljobs.job_status=4 and tbljobstatus.status=4 and tbljobs.job_user_id=".$_SESSION['user_id']."");
	$reviewsRow = mysql_num_rows($reviewsSql);
	
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
<title>Business Profile - SECURE THAT JOB</title>

<!-- Bootstrap -->
<link href="https://fonts.googleapis.com/css?family=Fira+Sans:300,400,400i,500,600,700,800" rel="stylesheet"> 
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link href="css/ddsmoothmenu.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<link href="fonts/font-awesome.css" rel="stylesheet">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.bxslider.js"></script>
<script type="text/javascript" src="js/menu.js"></script>
<script type="text/javascript" src="js/at-jquery.js"></script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({includedLanguages: '<?php echo LanguageList; ?>', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script>
<script type="text/javascript">
jQuery(document).ready(function($) {
	
		$('#edit_bank_details').click(function() {
			if($('#is_edit').val()==1)
	        {
				//alert("hello111");
			$('#edit_bank_details').html('Update Bank Details');
			$('#is_edit').val('2');
			$('#edit_acc_name').hide();
			$('#edit_bank_name').hide();
			$('#edit_acc_number').hide();
			$('#acc_holder_name').show();
			$('#bank_name').show();
			$('#acc_number').show();
			}
			else
			{
				if($('#acc_holder_name').val()=='')
				{
					alert("Please enter A/C Holder Name.");
					return false;
				}
				if($('#bank_name').val()=='')
				{
					alert("Please enter Bank Name.");
					return false;
				}
				if($('#acc_number').val()=='')
				{
					alert("Please enter Account Number.");
					return false;
				}
				
					 
					 $.post("update_bank_detail.php",
					 {
						 acc_holder_name:$('#acc_holder_name').val(),bank_name:$('#bank_name').val(),acc_number:$('#acc_number').val()
					 },
					 function(data)
					 {
						 if(data!=2)
						 {
							 
							 var str=data.split("~");
							 $('#edit_acc_name').html(str[1]);
							 $('#edit_bank_name').html(str[0]);
							 $('#edit_acc_number').html(str[2]);
							 $('#acc_holder_name').val(str[1]);
							 $('#bank_name').val(str[0]);
							 $('#acc_number').val(str[2]);
							 //alert('Your bank details has been sucessfully updated.');
						 }
						 
					 });
					 
					$('#edit_acc_name').show();
					$('#edit_bank_name').show();
					$('#edit_acc_number').show();
					$('#acc_holder_name').hide();
					$('#bank_name').hide();
					$('#acc_number').hide();
					$('#is_edit').val('1');
				
				$('#edit_bank_details').html('Edit Bank Details');
			}
		});
		
		$('#edit_password').click(function() {
			if($('#is_update_password').val()==1)
	        {
				$('#old_password').show();
				$('#edit_password').html('(Update Password)');
				$('#user_password').show();
				$('#confirm_password').show();
				$('#is_update_password').val('2');
			}
			else
			{
				if($('#old_password').val()=='')
				{
					alert("Please enter your old password.");
					$('#old_password').focus();
					return false;
				}
				
				if($('#user_password').val()=='')
				{
					alert("Please enter your new password.");
					$('#user_password').focus();
					return false;
				}
				
				if($('#confirm_password').val()=='')
				{
					alert("Please enter your confirm password.");
					$('#confirm_password').focus();
					return false;
				}
				
				if($('#user_password').val()!=$('#confirm_password').val())
				{
					alert("Your password and confirmation password do not match.");
					return false;
				}

				$.post("change_password.php",
				{
					user_password:$('#user_password').val(),old_password:$('#old_password').val(),confirm_password:$('#confirm_password').val()
				},
				function(data)
				{
						
					if(data==3)
					{
						alert("Current password is not correct, Please try again");
						$('#user_password').val('');
						$('#old_password').val('');
						$('#confirm_password').val('');
						return false;
					}
					if(data==1)
					{
						alert("Your password has been sucessfully changed.");
						$('#user_password').hide();
						$('#old_password').hide();
						$('#confirm_password').hide();
						$('#edit_password').html('(Change Password)');
						$('#is_update_password').val('1');
						$('#user_password').val('');
						$('#old_password').val('');
						$('#confirm_password').val('');
					}
					
					if(data==2)
					{
						alert("something not matched");
						$('#user_password').val('');
						$('#old_password').val('');
						$('#confirm_password').val('');
						return false;
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
<style>          
  #map { 
	height: 200px;    
	width: 750px;            
  }          
</style> 
<body class="<?php echo $profileCLass; ?>">
<?php include "header-inner.php"; ?>
<div class="bp_wrap">
	<div class="container">
		<div class="row">
			
			<div class="bp_dv">
				
				<div class="bp_dv_bnr">
				    <a class="a_logout" href="logout.php"><i class="fas fa-power-off pwr-off"></i>Logout</a>
					<div class="bp_pf_img">
					<?php if($profile_image!=''){ ?>
						<img src="<?php echo $profile_image; ?>" alt=""/>
					<?php }else { ?>
						<img src="images/proflie.jpg" alt=""/>
					<?php } ?> ?>
					<a href="change_profile_image.php" class="image-edit-profile-b"><span><i class="fa fa-pencil" aria-hidden="true"></i></span></a>
					</div>
					<h2><?php echo $c_name; ?></h2>
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
				
				<div class="bp_dv_dtl">
				
					<div class="bp_dv_lftdtl">
						<div class="bp_crd">
							<div class="bp_crd_dtl">
								your total credits
								<span><?php echo $total_credit; ?></span>
							</div>
							<a class="a_bmc" href="#" data-toggle="modal" data-target="#addCredites">Buy more credits</a>
						</div>
					
					    <div class="bp_code">
					      <h3>Referral Code</h3>
					      <span><?php echo $referralCode ?></span>
					      <p>Share referral code with your friends and get free discount vouchers.</p>
					    </div>
					</div>
					
					<div class="bp_dv_rgtdtl">
						<ul class="bp_jobs_link">
							<li><a href="created_jobs.php">Jobs Created <span><?php echo $jobRows; ?></span></a></li>
							<li><a href="currentjobs.php">Current Jobs <span><?php echo $frow; ?></span></a></li>
							<li><a href="completeduserjobs.php">Completed Jobs <span><?php echo $completerow; ?></span></a></li>
							<li><a href="my_reviews.php">Reviews <span><?php echo $reviewsRow; ?></span></a></li>
							<li><a class="a_lk" href="#" data-toggle="modal" data-target="#addCredites"><img class="prof_icon" src="images/euro-b.png" alt=""/>Buy Credits</a></li>
							<li><a class="a_lk" href="profile-edit.php"><img class="prof_icon" src="images/edit-b.png" alt=""/>Edit Profile</a></li>
						</ul>
						
						<div class="bp_jobs_dtl">
							<?php if($_SESSION['pu'] != ''){ ?>
								<div class="alert alert-success fade in">
									<a href="#" class="close" data-dismiss="alert">&times;</a>
									<strong>Success!</strong> <?php echo $_SESSION['pu']; ?>.
								</div>
							<?php 
								} 
								unset($_SESSION['pu']);
							?>
							<div class="act_dtl">
								<h3>Account Details</h3>
								<ul>
									<li class="add_dtl"><?php if($c_name != ''){ echo $c_name.','; }?> <?php echo $address; ?></li>
									<li class="call_dtl"><?php echo $phone; ?> <!--<a href="#">(Verify)</a>--></li>
									<li class="user_dtl"><?php echo $first_name; ?> <?php echo $lastname; ?></li>
									<li class="mail_dtl"><?php echo $user_email; ?> <?php if($is_email_verify==1 || $isSocial!=0){ ?> <span class="a_vy">(Verified)</span> <?php } else { ?><a href="emailverify.php?email=<?php  echo  $user_email;?>">(Verify)</a> <?php } ?></li>
									<li class="pass_dtl"> **** <input type="password" name="old_password" id="old_password" style="display:none;" placeholder="Enter Your Old Password" value="" class="txt_lg" /> <input type="password" name="user_password" id="user_password" style="display:none;" value="" class="txt_lg" placeholder="Enter Your New Password" /><input type="password" name="confirm_password" id="confirm_password" style="display:none;" value="" class="txt_lg" placeholder="Enter Your Confirm Password" /><a  id="edit_password" href="javascript:void(0);">(Change Password)</a> 
									<input type="hidden" name="is_update_password" id="is_update_password" value="1">
									</li>
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
							<?php if($latitude != "" && $longitude != ""){ ?>
							<div class="cmp_dtl" style="border-bottom:none;">
								<div class="cmp_map" id="map"></div>
							</div>
							<?php } ?>

						</div>
					</div>
					
				</div>
				
			</div>
			
		</div>
	</div>
</div>
 <script type="text/javascript">
        var map;
        
        function initMap() {                            
            var latitude = <?php echo $latitude; ?>; // YOUR LATITUDE VALUE
            var longitude = <?php echo $longitude; ?>; // YOUR LONGITUDE VALUE
            
            var myLatLng = {lat: latitude, lng: longitude};
            
            map = new google.maps.Map(document.getElementById('map'), {
              center: myLatLng,
              zoom: 14                    
            });
                    
            var marker = new google.maps.Marker({
              position: myLatLng,
              map: map,
              //title: 'Hello World'
              
              // setting latitude & longitude as title of the marker
              // title is shown when you hover over the marker
              title: latitude + ', ' + longitude 
            });            
        }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_JUu2G9vlijX1UgNTylx55U1hZQqw6QI&callback=initMap"
        async defer></script>
<?php include "footer.php"; ?>
</body>
</html>