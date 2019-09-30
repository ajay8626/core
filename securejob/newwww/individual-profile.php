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
$profile_image='';
$profilevideo='';
$birthdate='';
$gender='';
$height='';
$nationality='';
$language='';
$militry='';
$drive='';
$firstaid='';
$tattoos='';
$piercing='';
$right_to_work_uk='';
$willing_to_travel='';
$uk_driving_license='';
$cscs_card='';
$sia='';
$activity='';
$health='';
$bio='';
$experience='';
$education_credentials='';
$militry_txt='';
$drive_txt='';
$firstaid_txt='';
$tattoos_txt='';
$sia_txt='';
$gender_txt='';
$birthdate_txt='';
$total_credit='';
$start = "00:00"; 
$end = "23:30";
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
	$created_date = $rows['created_date'];
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
	$nationality=$rows['nationality'];
	$build=$rows['build'];
	$language=$rows['language'];
	$total_credit=$rows['total_credit'];
	$is_email_verify=$rows['is_email_verify'];
	$isSocial=$rows['isSocial'];
	$referralCode=$rows['referralCode'];
	$birthdate_txt='';
	$latitude=$rows['latitude'];
	$longitude=$rows['longitude'];
	$paremedic=$rows['paremedic'];
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
	$militry_txt='';
	if($militry==1)
	{
		$militry_txt='Yes';
	}
	
	if($militry==2)
	{
		$militry_txt='No';
	}
	
	$drive=$rows['drive'];
	
	$drive_txt='';
	if($drive==1)
	{
		$drive_txt='Yes';
	}
	if($drive==2)
	{
		$drive_txt='No';
	}
	$firstaid=$rows['firstaid'];
	$firstaid_txt='';
	if($firstaid==1)
	{
		$firstaid_txt='Yes';
	}
	if($firstaid==2)
	{
		$firstaid_txt='No';
	}
	
	$paremedic_txt='';
	if($paremedic==1)
	{
		$paremedic_txt='Yes';
	}
	if($paremedic==2)
	{
		$paremedic_txt='No';
	}
	
	$tattoos=$rows['tattoos'];
	$tattoos_txt='';
	if($tattoos==1)
	{
		$tattoos_txt='Yes';
	}
	if($tattoos==2)
	{
		$tattoos_txt='No';
	}
    
    $piercing=$rows['piercing'];
	$piercing_txt='';
	if($piercing==1)
	{
		$piercing_txt='Yes';
	}
	if($piercing==2)
	{
		$piercing_txt='No';
	}
    
    $right_to_work_uk=$rows['right_to_work_uk'];
	$right_to_work_uk_txt='';
	if($right_to_work_uk==1)
	{
		$right_to_work_uk_txt='Yes';
	}
	if($right_to_work_uk==2)
	{
		$right_to_work_uk_txt='No';
	}
    
    $willing_to_travel=$rows['willing_to_travel'];
	$willing_to_travel_txt='';
	if($willing_to_travel==1)
	{
		$willing_to_travel_txt='Yes';
	}
	if($willing_to_travel==2)
	{
		$willing_to_travel_txt='No';
	}

	$how_far=$rows['how_far_willing_to_travel'];
	$how_far_txt = '';
	if($how_far != ''){
		$how_far_txt = $how_far.'Mile(s)';
	}
    
    $uk_driving_license=$rows['uk_driving_license'];
	$uk_driving_license_txt='';
	if($uk_driving_license==1)
	{
		$uk_driving_license_txt='Yes';
	}
	if($uk_driving_license==2)
	{
		$uk_driving_license_txt='No';
	}
    
    $cscs_card=$rows['cscs_card'];
	$cscs_card_txt='';
	if($cscs_card==1)
	{
		$cscs_card_txt='Yes';
	}
	if($cscs_card==2)
	{
		$cscs_card_txt='No';
	}
    
	$sia=$rows['sia'];
	$sia_txt='';
	if($sia==1)
	{
		$sia_txt='Yes';
	}
	if($sia==2)
	{
		$sia_txt='No';
	}
	$activity=$rows['activity'];
	$health=$rows['health'];
	$bio=$rows['bio'];
    $experience=$rows['experience'];
	$education_credentials=$rows['education_credentials'];
	
	
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
	
	$jobcn="select * from tbljobs where job_user_id=".$_SESSION['user_id']."  and status=1";
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
<title>Individual Profile - SECURE THAT JOB</title>

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
	
	
	$('#edit_rate_card').click(function() {
		if($('#is_edit_rate').val()==1)
		{
			$('#edit_rate_card').html('(Update)');				
			$('#is_edit_rate').val('2');
			$('.rate_card').show();
			$('.rate').hide();
			$('.currency_symbol').show(); 
		}
		else
		{
			var arr = {};
			$('.rate_card').each(function(){
				var ids =  $(this).attr('id');
				var value = $(this).val();
				arr[ids]=value;
				});
				
			
				$.post("update_rate.php",
				{
					cat:arr
				},
				function(data)
				{
					if(data==1)
					{
						window.location.reload();
					}
				});	
		}
	});
	
	/* Update User availability */
	$('#edit_availability').click(function() {
		if($('#is_edit_availability').val()==1)
		{
			$('#edit_availability').html('(Update Availability)');
			$('#availability').hide();
			$('#update_avail_div').show();
			$('#in_avail_1').show();
			$('#is_edit_availability').val('2');
		}
		else
		{		
			var selectDayLen = $("select.start_day_availability option[value!='']:selected").length;
			var selectFromTimeLen = $("select.from_availability option[value!='']:selected").length;
			var selectToTimeLen = $("select.to_availability option[value!='']:selected").length;
			var userId = <?php echo $_SESSION['user_id']; ?>;

			if((selectFromTimeLen == selectToTimeLen) && (selectDayLen != '')){
				var i;
				var filler = [];
				for (i = 1; i <= selectDayLen; i++) {
					var selectDay = $("select#start_day_availability_"+i+" option:selected").val();
					var dayId = $("select#start_day_availability_"+i+" option:selected").attr('data-dayid');
					var selectFromTime = $("select#from_availability_"+i+" option:selected").val();
					var selectToTime = $("select#to_availability_"+i+" option:selected").val();
					if(selectDay!='' && selectFromTime!='' && selectToTime!=''){
						filler.push({"from_day": selectDay, "from_time": selectFromTime, "to_time": selectToTime, "day_id": dayId, "user_id": userId});
					}
				}
			}else if(selectFromTimeLen > selectToTimeLen){
				alert("Please select to time.");
				return false;
			}else{
				alert("Please select from time.");
				return false;
			}
			
			/* console.log(filler); */
			
			var jsonString = JSON.stringify(filler);
			$.ajax({
				type: "POST",
				data: JSON.stringify(filler),
				data: {data : jsonString}, 
				url: "update_availability.php",
				beforeSend: function() {
					$('#preloader').show();
				},
				success: function(data)
				{
					$('#preloader').hide();
					if(data)
					{
						if(!alert(data)){window.location.reload();}
					}
				}
			});

			return false;
		}
	
	});

	$('#edit_personal_details').click(function() {
		if($('#is_updated_personal').val()==1)
		{
			$('#dob').hide();
			$('#date_of_birth').show();
			$('#gen').hide();
			$('#gender_txt').show();
			$('#hgt').hide();
			$('#height').show();
			$('#bld').hide();
			$('#build').show();
			$('#nty').hide();
			$('#nationality').show();
			$('#lng_spoke').hide();
			$('#lng').show();
			$('#mlt_bgd').hide();
			$('#militry_bgd').show();
			$('#drv').hide();
			$('#drive_rd').show();
			$('#fap').hide();
			$('#fad_rd').show();
			$('#tat').hide();
			$('#prcing').hide();
			$('#rgt_wrk').hide();
			$('#wlng_trvl').hide();
			$('#uk_drving_lcns').hide();
			$('#cscs_crd').hide();
			$('#tat_rd').show();
			$('#prcing_rd').show();
			$('#rgt_wrk_rd').show();
			$('#wlng_trvl_rd').show();
			$('#uk_drving_lcns_rd').show();
			$('#cscs_crd_rd').show();
			$('#sia_badge').hide();
			$('#sia_badge_rd').show();
			$('#act').hide();
			$('#activity').show();
			$('#hel').hide();
			$('#health').show();
			$('#bio_txt').hide();
			$('#bio').show();
			$('#experience').show();
			$('#education_credentials').show();
			$('#is_updated_personal').val('2');
			$('#edit_personal_details').html('Update Personal Details');
			
		}
		else
		{
			$('#dob').show();
			$('#date_of_birth').hide();
			$('#gen').show();
			$('#gender_txt').hide();
			$('#hgt').show();
			$('#height').hide();
			$('#bld').show();
			$('#build').hide();
			$('#nty').show();
			$('#nationality').hide();
			$('#lng_spoke').show();
			$('#lng').hide();
			$('#mlt_bgd').show();
			$('#militry_bgd').hide();
			$('#drv').show();
			$('#drive_rd').hide();
			$('#fap').show();
			$('#fad_rd').hide();
			$('#tat').show();
			$('#prcing').show();
			$('#rgt_wrk').show();
			$('#wlng_trvl').show();
			$('#uk_drving_lcns').show();
			$('#cscs_crd').show();
			$('#tat_rd').hide();
			$('#prcing_rd').hide();
			$('#rgt_wrk_rd').hide();
			$('#wlng_trvl_rd').hide();
			$('#uk_drving_lcns_rd').hide();
			$('#cscs_crd_rd').hide();
			$('#sia_badge').show();
			$('#sia_badge_rd').hide();
			$('#act').show();
			$('#activity').hide();
			$('#hel').show();
			$('#health').hide();
			$('#bio_txt').show();
			$('#bio').hide();
			$('#experience').hide();
			$('#education_credentials').hide();
			$('#is_updated_personal').val('1');
			$('#edit_personal_details').html('Edit Personal Details');
		}
	});

	/* On select update 'How far are you willing to travel' */
	$( "#how_far" ).change(function() {
		
		var howFarValue = $( "#how_far" ).val();
		$.ajax({
			type: 'GET',
			url: 'update_how_far.php?howFar='+howFarValue,
			datatype: "html",
		})
		.success(function(data){
			//$('span.succ_upda').html(data);
			location.reload(true);
		})
		.fail(function(jqXHR, ajaxOptions, thrownError){
			alert('No response from server');
		});

	});
	
});
</script>

<script>
	jQuery(document).ready(function($) {
		$('.g_vd_prof_indi').fancybox();
	});
</script>

<!-- Add button to add availbility -->
<script>
	$(document).on('click', '#add_avail_div', function(){
		var divNum = $(this).attr("data-divnum");
		var remDiv = divNum-1;
		$('#in_avail_'+divNum).show();
		$('.add_avail_div_'+remDiv).hide();
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
  #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
      }  
</style>  
<body class="<?php echo $profileCLass; ?>">
<div id="preloader" style="display:none"></div>
<?php include "header-inner.php"; ?>
<div class="bp_wrap ip_wrap">
	<div class="container">
		<div class="row">
			
			<div class="bp_dv">
				
				
				<div class="ip_profile">
					<div class="ip_prf_lft">
					    <?php if($profile_image!=''){ ?>
						<img src="<?php echo $profile_image; ?>" alt=""/>
						<?php } else { ?>
						<img src="images/proflie.jpg" alt=""/>
						<?php } ?>
						<a href="change_profile_image.php" class="image-edit-profile-p"><span><i class="fa fa-pencil" aria-hidden="true"></i></span></a>
						
						<div class="bp_dv_dtl bp_dv_dtl_ind">
				
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
					    
					    <div class="ip_avail">
							<h3>Availability <a href="javascript:void(0);" id="edit_availability">(Change Availability)</a></h3>
							<div id="avail_select">
								<?php 
								$availSql = mysql_query("SELECT * FROM tbluser_availability WHERE user_id=".$_SESSION['user_id']." ORDER BY day_id ASC");
								$availSqlCount = mysql_num_rows($availSql);
								?>
								<input type="hidden" name="is_edit_availability" id="is_edit_availability" value="1">
								<?php if($availSqlCount == 0){ ?>
									<p id="availability">Please set your Availability</p>
								<?php } else {?>
								<p id="availability">
									<?php while($availRow = mysql_fetch_assoc($availSql)){ ?>
									<?php echo "<span class='availability_set'>" ?>
									<?php echo ucfirst($availRow['from_day']); ?> <?php echo $availRow['from_time']; ?> - <?php echo $availRow['to_time']; ?>
									<?php echo "</span>" ?>
									<?php } ?>
								</p>
								<?php }?>
								<div id="update_avail_div" style="display:none;">
									<?php 
									
									$dayIdAvailSql = mysql_query("SELECT day_id FROM tbluser_availability WHERE user_id=".$_SESSION['user_id']." ORDER BY day_id ASC ");
									$dayId = array();
									while($checkDayId = mysql_fetch_assoc($dayIdAvailSql)){
										$dayId[] = $checkDayId['day_id'];
									}
									$lastDayId = end($dayId);

									for($i=1; $i<=7; $i++){

										$saveAvailSql = mysql_query("SELECT * FROM tbluser_availability WHERE user_id=".$_SESSION['user_id']." AND day_id=".$i." ");
										$saveAvailSqlCount = mysql_num_rows($saveAvailSql);
										/* if($saveAvailSqlCount == 0){
											$displayFlag = 'style="display:none"';
										}else{
											$displayFlag = '';
										} */
										$availRow = mysql_fetch_assoc($saveAvailSql);
										$availDay = $availRow['day_id'];
										$availFromTime = $availRow['from_time'];
										$availToTime = $availRow['to_time'];

										echo '<div id="in_avail_'.$i.'" '.$displayFlag.'>';
										$startDay = 'start_day_availability';
										$endDay = 'end_day_availability';
										$day = 0;
										$selectId = 'day_availability';
										echo dayDropdown($startDay, $day, $i, $i);

										$tStart = strtotime($start);
										$tEnd = strtotime($end);
										$tNow = $tStart;
										echo '<select name="from_availability_'.$i.'" class="from_availability" id="from_availability_'.$i.'" placeholder="From">';
										echo '<option value="">From</option>';
										while($tNow <= $tEnd){
											echo '<option value="'.date("H:i",$tNow).'" '.(($availFromTime == date("H:i",$tNow))?'selected="selected"':"").'>'.date("H:i",$tNow).'</option>';
											$tNow = strtotime('+30 minutes',$tNow);
										}
										echo '</select>';
										
										$tStart = strtotime($start);
										$tEnd = strtotime($end);
										$tNow = $tStart;
										echo '<select name="to_availability_'.$i.'" class="to_availability" id="to_availability_'.$i.'" placeholder="From">';
										echo '<option value="">To</option>';
										while($tNow <= $tEnd){
											echo '<option value="'.date("H:i",$tNow).'" '.(($availToTime == date("H:i",$tNow))?'selected="selected"':"").'>'.date("H:i",$tNow).'</option>';
											$tNow = strtotime('+30 minutes',$tNow);
										}
										echo '</select>';

										/* $divNum = (int)($i+1);
										if(isset($availDay)){
											if($i == $lastDayId){
												echo '<button class="btn btn-sm add_avail_div_'.$i.'" id="add_avail_div" data-divnum="'.$divNum.'">Add</button>';
											}
										}else{
											if($i != 7){
												echo '<button class="btn btn-sm add_avail_div_'.$i.'" id="add_avail_div" data-divnum="'.$divNum.'">Add</button>';
											}
										} */
										
										echo '</div>';
										
									}
									?>
								</div>
							</div>
					    </div>
					    
					    <div class="ip_avail">
					    	<h3>Rate Card <span>per person per hour</span> <a href="javascript:void(0);" id="edit_rate_card">(Edit)</a></h3>
					    	<ul>
							<input type="hidden" name="is_edit_rate" id="is_edit_rate" value="1">
						<?php 
						 $sql=mysql_query("select category_id,category_name from tblcategory where isactive=1 order by category_name");
						 $rows=mysql_num_rows($sql);
						 if($rows > 0)
						 {
							 while($catdata=mysql_fetch_array($sql))
							 {
								 
								 $getratecard=get_rate_card($catdata['category_id'],$_SESSION['user_id']);
								 
								 
						 ?>
						         <li><?php echo $catdata['category_name']; ?> <span class="rate">£<?php echo $getratecard; ?></span>
								 <input type="text" name="category_rate[<?php echo $catdata['category_id']; ?>]" size="3" id="<?php echo $catdata['category_id']; ?>" style="display:none;float:right;" maxlength="4" value="<?php echo $getratecard; ?>" class="txt_lg rate_card" /><span class="currency_symbol" style="display:none;">£</span></li>
					    		
							 <?php }
						 }
                         ?>						 
					    	</ul>
					    </div>
					</div>
					</div>
					</div>
					<div class="ip_prf_rgt">
						<div class="ip_pr_hdr">
							<h2><?php echo $first_name; ?> <?php echo $lastname; ?><br/><span>Individual</span></h2>
							<a class="a_lot" href="logout.php"><i class="fas fa-power-off pwr-off"></i>Logout</a>
						</div>
						<div class="ip_pr_info">
							<?php if($_SESSION['pu'] != ''){ ?>
							<div class="alert alert-success fade in">
								<a href="#" class="close" data-dismiss="alert">&times;</a>
								<strong>Success!</strong> <?php echo $_SESSION['pu']; ?>.
							</div>
							<?php 
								} 
								unset($_SESSION['pu']);
							?>
							<ul>
							   <li class="add_dtl"><?php echo $address; ?></li>
							   <li class="call_dtl"><?php echo $phone; ?> <!--<a href="#">(Verify)</a>--></li>
							   <li class="mail_dtl"><?php echo $user_email; ?> <?php if($is_email_verify==1 || $isSocial!=0){ ?> <span class="a_vy">(Verified)</span> <?php } else { ?><span class="a_vy"><a href="emailverify.php?email=<?php  echo  $user_email;?>">(Verify)</a> </span><?php } ?></li>
							   <li class="pass_dtl"> **** <input type="password" name="old_password" id="old_password" style="display:none;" placeholder="Enter Your Old Password" value="" class="txt_lg" /> <input type="password" name="user_password" id="user_password" style="display:none;" value="" class="txt_lg" placeholder="Enter Your New Password" /><input type="password" name="confirm_password" id="confirm_password" style="display:none;" value="" class="txt_lg" placeholder="Enter Your Confirm Password" /><a id="edit_password" href="javascript:void(0);">(Change Password)</a>
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
									<?php if($checkYear==0 && $checkMonth==0 && $checkDay==0){ ;?>
										
									<?php }else{ ?>
										<li class="user_dtl">Member Since: <?php echo $timeOld; ?></li>	
									<?php } ?>	
						   </ul>
						</div>

						<!-- Modal Area Start (Add Credits) -->
						<div class="modal fade" id="addCredites">
							<div class="modal-dialog modal-dialog-centered">
							<div class="modal-content ">
							
								<!-- Modal Header -->
								<h2 class="modal-title modal-head-css">Add Credits</h2>
								
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

						<div class="ip_pr_links">
						    <ul class="bp_jobs_link">
						    	<li><a href="created_jobs.php">Jobs Created <span><?php echo $jobRows; ?></span></a></li>
								<li><a href="currentjobs.php">Current Jobs <span><?php echo $frow; ?></span></a></li>
								<li><a href="completeduserjobs.php">Completed Jobs <span><?php echo $completerow; ?></span></a></li>
								<li><a href="my_reviews.php">Reviews <span><?php echo $reviewsRow; ?></span></a></li>
						    	<li><a class="a_lk" href="#" data-toggle="modal" data-target="#addCredites"><img class="prof_icon" src="images/euro-p.png" alt="">Buy Credits</a></li>
						    	<li><a class="a_lk" href="profile-edit.php"><img class="prof_icon" src="images/edit-p.png" alt="">Edit Profile</a></li>
						    </ul>
						</div>
						
						<div class="bp_dv_dtl bp_dv_dtl_ind">
				
					
					
					<div class="bp_dv_rgtdtl">
						<div class="bp_jobs_dtl">
							<div class="bank_dtl prsnl_dtl" style="border-bottom:none;">
								<h3>Personal Details</h3>
								<input type="hidden" name="is_updated_personal" id="is_updated_personal" value="1">
								
								<ul>
									<?php if ($profilevideo!='') {?>
									<li>Video: 
									<div class="gd_vd_prof_indi" style="display:inline-block">
										<?php if($profilevideo!=''){ ?>
											<a class="g_vd_prof_indi" href="#g_id1"><img class="prof_vid" alt=""/>View Video</a>
										<?php } ?>
									</div>

									<div style="display: none;">
										<div class="gd_pop" id="g_id1">
											<?php $videoSrc = CUSTOMER_PROFILE_VIDEO_URL.$profilevideo; ?>
											<video width="700" height="450" controls>
												<source src="<?php echo CUSTOMER_PROFILE_VIDEO_URL.$profilevideo ?>" type="video/mp4"> Your browser does not support the video tag.
											</video>
										</div>
									</div>
									</li>
									<?php } ?>
									
									<?php if ($birthdate_txt!='') {?>
									<li>Age: <span id="dob"><?php if($diff!=''){ echo $diff->format('%y'); ?> Years <?php } ?> <?php if($diff->format('%m')!=''){ echo $diff->format('%m'); ?> Months <?php } ?></span><input type="text" name="date_of_birth" class="form-control" style="display:none;width: 200px;" id="date_of_birth"  value="<?php echo $birthdate_txt; ?>" class="txt_lg" /></li>
									<?php } ?>

									<?php if ($gender_txt!='') {?>
									<li>Gender: <span id="gen"><?php echo $gender_txt; ?></span><p class="chk_rd" id="gender_txt" style="display:none;"><input type="radio" name="gender" <?php if($gender==1){ ?> checked <?php } ?> class="rdk"   id="male" value="1">&nbsp;Male&nbsp;
									<input type="radio" name="gender" <?php if($gender==2){ ?> checked <?php } ?>  id="female" class="rdk"  value="2">&nbsp;Female</p></li>
									<?php } ?>

									<?php if ($height!='') {?>
									<li>Height: <span id="hgt"><?php if($height!=''){ echo $height.' cms'; } ?></span> <input type="text" name="height"  id="height" class="form-control" value="<?php echo $height; ?>"  maxlength="10" style="display:none;width: 200px;" size="10"></li>
									<?php } ?>
									
									<?php if ($build!='') {?>
									<li>Build: <span id="bld"><?php echo $build; ?></span><select name="build" id="build" class="form-control"   style="display:none;width: 200px;">
										<option value="">Select Build</option>
										<option value="muscular" <?php if($build=='muscular'){ ?> selected <?php } ?>>Muscular</option>
										</select>
									</li>
									<?php } ?>
									
									<?php if ($nationality!='') {?>
									<li>Nationality: <span id="nty"><?php echo $nationality; ?></span><select name="nationality" id="nationality" class="form-control"   style="width: 200px;display:none;">
										<option value="">Select Nationality</option>
										<option value="british" <?php if($nationality=='british'){ ?> selected <?php } ?>>British</option>
										</select>
									</li>
									<?php } ?>
									
									<?php if ($language!='') {?>
									<li>Language Spoken: <span id="lng_spoke"><?php echo $language; ?></span><p class="chk_rd" id="lng" style="display:none;"><input type="checkbox" name="language[]"  <?php if(in_array("english",$lang)){ ?> checked <?php } ?> value="english">&nbsp;English
										<input type="checkbox"  name="language[]" <?php if(in_array("polish",$lang)){ ?> checked <?php } ?> value="polish">&nbsp;Polish
										<input type="checkbox"  name="language[]" <?php if(in_array("wellish",$lang)){ ?> checked <?php } ?> value="wellish">&nbsp;Wellish
										<input type="checkbox"  name="language[]" <?php if(in_array("french",$lang)){ ?> checked <?php } ?> value="french">&nbsp;French</p>
									</li>
									<?php } ?>
									
									<?php if ($militry_txt!='') {?>
									<li>Military Background?: <span id="mlt_bgd"><?php echo $militry_txt; ?></span><p class="chk_rd" id="militry_bgd" style="display:none;"><input type="radio" name="militry" class="rdk"  <?php if($militry==1){ ?> checked <?php } ?>   value="1">&nbsp;Yes&nbsp;
										<input type="radio" name="militry" class="rdk"  <?php if($militry==2){ ?> checked <?php } ?>   value="2">&nbsp;No</p>
									</li>
									<?php } ?>
									
									<?php if ($drive_txt!='') {?>
									<li>Do you drive?: <span id="drv"><?php echo $drive_txt; ?></span><p class="chk_rd" id="drive_rd" style="display:none;"><input type="radio" name="drive" class="rdk" <?php if($drive==1){ ?> checked <?php } ?>   value="1">&nbsp;Yes&nbsp;
										<input type="radio" class="rdk" name="drive" <?php if($drive==2){ ?> checked <?php } ?>   value="2">&nbsp;No</p>
									</li>
									<?php } ?>		
									
									<?php if ($firstaid_txt!='') {?>
									<li>First Aid: <span id="fap"><?php echo $firstaid_txt; ?></span><p  class="chk_rd" id="fad_rd" style="display:none;"><input type="radio"  class="rdk" name="firstaid" <?php if($firstaid==1){ ?> checked <?php } ?>   value="1">&nbsp;Yes&nbsp;
										<input type="radio" class="rdk" name="firstaid" <?php if($firstaid==2){ ?> checked <?php } ?>   value="2">&nbsp;No</p>
									</li>
									<?php } ?>
                                    <?php if ($paremedic_txt!='') {?>
									<li>Paramedic Training: <span id="fap"><?php echo $paremedic_txt; ?></span>
									</li>
									<?php } ?>									
									
									<?php if ($tattoos_txt!='') {?>
									<li>Visible Tattoos?: <span id="tat"><?php echo $tattoos_txt; ?></span><p class="chk_rd" id="tat_rd" style="display:none;"><input type="radio" name="tattoos" class="rdk" <?php if($tattoos==1){ ?> checked <?php } ?>   value="1">&nbsp;Yes&nbsp;
										<input type="radio" name="tattoos" class="rdk" <?php if($tattoos==2){ ?> checked <?php } ?>  value="2">&nbsp;No</p>
									</li>
									<?php } ?>
                                    
                                    <?php  if ($piercing_txt!='') {?>
									<li>Visible Piercings?: <span id="prcing"><?php echo $piercing_txt; ?></span><p class="chk_rd" id="prcing_rd" style="display:none;"><input type="radio" name="piercing" class="rdk" <?php if($piercing==1){ ?> checked <?php } ?>   value="1">&nbsp;Yes&nbsp;
										<input type="radio" name="piercing" class="rdk" <?php if($piercing==2){ ?> checked <?php } ?>  value="2">&nbsp;No</p>
									</li>
									<?php } ?>
                                    
                                    <?php if ($right_to_work_uk_txt!='') {?>
									<li>Do you have right to work in UK?: <span id="rgt_wrk"><?php echo $right_to_work_uk_txt; ?></span><p class="chk_rd" id="rgt_wrk_rd" style="display:none;"><input type="radio" name="right_to_work_uk" class="rdk" <?php if($right_to_work_uk==1){ ?> checked <?php } ?>   value="1">&nbsp;Yes&nbsp;
										<input type="radio" name="right_to_work_uk" class="rdk" <?php if($right_to_work_uk==2){ ?> checked <?php } ?>  value="2">&nbsp;No</p>
									</li>
									<?php } ?>
                                    
                                    <?php if ($willing_to_travel_txt!='') {?>
									<li>Willing to travel abroad?: <span id="wlng_trvl"><?php echo $willing_to_travel_txt; ?></span><p class="chk_rd" id="wlng_trvl_rd" style="display:none;"><input type="radio" name="willing_to_travel" class="rdk" <?php if($willing_to_travel==1){ ?> checked <?php } ?>   value="1">&nbsp;Yes&nbsp;
										<input type="radio" name="willing_to_travel" class="rdk" <?php if($willing_to_travel==2){ ?> checked <?php } ?>  value="2">&nbsp;No</p>
									</li>
									<?php } ?>
                                    
                                    <?php if ($uk_driving_license!='') {?>
									<li>Do you hold full UK Driving License?: <span id="uk_drving_lcns"><?php echo $uk_driving_license_txt; ?></span><p class="chk_rd" id="uk_drving_lcns_rd" style="display:none;"><input type="radio" name="uk_driving_license" class="rdk" <?php if($uk_driving_license==1){ ?> checked <?php } ?>   value="1">&nbsp;Yes&nbsp;
										<input type="radio" name="uk_driving_license" class="rdk" <?php if($uk_driving_license==2){ ?> checked <?php } ?>  value="2">&nbsp;No</p>
									</li>
									<?php } ?>
                                    
                                    <?php if ($cscs_card_txt!='') {?>
									<li>Do you have CSCS card?: <span id="cscs_crd"><?php echo $cscs_card_txt; ?></span><p class="chk_rd" id="cscs_crd_rd" style="display:none;"><input type="radio" name="cscs_card" class="rdk" <?php if($cscs_card==1){ ?> checked <?php } ?>   value="1">&nbsp;Yes&nbsp;
										<input type="radio" name="cscs_card" class="rdk" <?php if($cscs_card==2){ ?> checked <?php } ?>  value="2">&nbsp;No</p>
									</li>
									<?php } ?>

									<?php if ($sia_txt!='') {?>
									<li>SIA Badge: <span id="sia_badge"><?php echo $sia_txt; ?></span><p class="chk_rd" id="sia_badge_rd" style="display:none;"><input type="radio" name="sia" <?php if($sia==1){ ?> checked <?php } ?> class="rdk" value="1">&nbsp;Yes&nbsp;
										<input type="radio"  class="rdk" name="sia" <?php if($sia==2){ ?> checked <?php } ?>   value="2">&nbsp;No</p>
									</li>
									<?php } ?>
									
									<?php if ($activity!='') {?>
									<li>
										Any Ailment that could impair activity to work?
										<p id="act"><?php echo $activity ?></p>
										<textarea class="form-control" style='min-height:100px;display:none;'   name="activity" id="activity"><?php echo $activity; ?></textarea>
									</li>
									<?php } ?>
									
									<?php if ($health!='') {?>
									<li>
										Any Health Issues?
										<p id="hel"><?php echo $health; ?></p>
										<textarea class="form-control" style='min-height:100px;display:none;'   name="health" id="health" ><?php echo $health; ?></textarea>
									</li>
									<?php } ?>
									
									<?php if ($bio!='') {?>
									<li>
										Bio
										<p id="bio_txt"><?php echo $bio; ?></p>
										<textarea class="form-control" style='min-height:100px;display:none;'   name="bio" id="bio"><?php echo $bio; ?></textarea>
									</li>
									<?php } ?>
                                    
                                    <?php if ($experience!='') {?>
									<li>
										Experience
										<p id="bio_txt"><?php echo $experience; ?></p>
										<textarea class="form-control" style='min-height:100px;display:none;'   name="experience" id="experience"><?php echo $experience; ?></textarea>
									</li>
									<?php } ?>
                                    
                                    <?php if ($education_credentials!='') {?>
									<li>
										Education and Further Credentials
										<p id="bio_txt"><?php echo $education_credentials; ?></p>
										<textarea class="form-control" style='min-height:100px;display:none;'   name="education_credentials" id="education_credentials"><?php echo $education_credentials; ?></textarea>
									</li>
									<?php } ?>

									<!-- Certificates -->
									<?php 
										$certiCount=0;
										if(isset($_SESSION['user_id']) && $_SESSION['user_id']!='') {
											$userCerties=mysql_query("select * from tbl_user_certi where user_id=".$_SESSION['user_id']."");
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

									
									<li>
										How far are you willing to travel?
										<select name="how_far" id="how_far" style="width:200px;">
											<option value="">Select</option>
											<option value="2" 	<?php if($how_far==2){ ?> selected <?php } ?>>2 Miles</option>
											<option value="5" 	<?php if($how_far==5){ ?> selected <?php } ?>>5 Miles</option>
											<option value="10" 	<?php if($how_far==10){ ?> selected <?php } ?>>10 Miles</option>
											<option value="15" 	<?php if($how_far==15){ ?> selected <?php } ?>>15 Miles</option>
											<option value="20" 	<?php if($how_far==20){ ?> selected <?php } ?>>20 Miles</option>
											<option value="30" 	<?php if($how_far==30){ ?> selected <?php } ?>>30 Miles</option>
											<option value="50" 	<?php if($how_far==50){ ?> selected <?php } ?>>50 Miles</option>
											<option value="75" 	<?php if($how_far==75){ ?> selected <?php } ?>>75 Miles</option>
											<option value="100" <?php if($how_far==100){ ?> selected <?php } ?>>100 Miles</option>
											<option value="125" <?php if($how_far==125){ ?> selected <?php } ?>>125 Miles</option>
											<option value="150" <?php if($how_far==150){ ?> selected <?php } ?>>150 Miles</option>
											<option value="175" <?php if($how_far==175){ ?> selected <?php } ?>>175 Miles</option>
											<option value="200" <?php if($how_far==200){ ?> selected <?php } ?>>200 Miles</option>
											<option value="500" <?php if($how_far==500){ ?> selected <?php } ?>>500 Miles</option>
									 </select>
									 <span class="succ_upda"></span>
									</li>
									
									
									<li>
										<br/>
										<div class="srch_prf">
											<input type="text" id="pac-input" class="txt_search" placeholder="Search Location" />
											<input type="submit" class="btn_search" value="Go" />
										</div>
									</li>
									<li>
										<div id="map"></div>
									</li>
									<!--<li>Location + <span>20mi</span></li>-->
								</ul>
							</div>
							<?php /* ?>
							<div class="bank_dtl">
								<h3>Bank Details</h3>
								<a class="a_edb"  href="javascript:void(0);" id="edit_bank_details">Edit Bank Details</a>
								<ul>
								<input type="hidden" name="is_edit" id="is_edit" value="1">
									<li>A/C Holder Name: <span id="edit_acc_name"><?php echo $acc_holder_name; ?></span><input type="text" name="acc_holder_name" style="display:none;" id="acc_holder_name"  value="<?php echo $acc_holder_name; ?>" class="txt_lg" /></li>
									<li>Bank Name: <span id="edit_bank_name"><?php echo $bank_name; ?></span><input type="text" name="bank_name" id="bank_name" style="display:none;"  value="<?php echo $bank_name; ?>" class="txt_lg" /></li>
									<li>Account Number: <span id="edit_acc_number"><?php echo $acc_number; ?></span><input type="text" name="acc_number" id="acc_number" style="display:none;" value="<?php echo $acc_number; ?>" class="txt_lg" /></li>
								</ul>
							</div>
							<?php */ ?>
						</div>
					</div>
					
				</div>
						
					</div>
					
					
					
				</div>
				
				
				
			</div>
			
		</div>
	</div>
</div>

<!-- Google Marker Query -->
<?php
	$userLat = $latitude;
	$userLong = $longitude;
	$userHowFar = $how_far;

	$markerSql = "SELECT c.name AS title, c.course_id AS id, c.latitude AS lati, c.longitude AS longi, (CASE WHEN 1=1 THEN 'Course' END) AS maintype FROM tblcourse c WHERE (getDistancemiles(c.latitude, c.longitude, ".$userLat.", ".$userLong.") <= ".$userHowFar.") AND (getDistancemiles(c.latitude, c.longitude, ".$userLat.", ".$userLong.") > 0) AND c.status=1 UNION SELECT CONCAT(firstname, ' ', lastname) AS title, u.user_id AS id, u.latitude AS lati, u.longitude AS longi, (CASE WHEN 1=1 THEN 'Candidate' END) AS maintype FROM tbluser u WHERE (getDistancemiles(u.latitude, u.longitude, ".$userLat.", ".$userLong.") <= ".$userHowFar.") AND (getDistancemiles(u.latitude, u.longitude, ".$userLat.", ".$userLong.") > 0) AND u.status=1 UNION SELECT j.job_name AS title, j.job_id AS id, j.latitude AS lati, j.longitude AS longi, (CASE WHEN 1=1 THEN 'Job' END) AS maintype FROM tbljobs j WHERE (getDistancemiles(j.latitude, j.longitude, ".$userLat.", ".$userLong.") <= ".$userHowFar.") AND (getDistancemiles(j.latitude, j.longitude, ".$userLat.", ".$userLong.") > 0) AND j.status=1";

	/* echo $markerSql; */

	$markerQuery = mysql_query($markerSql);
	$markerArray = array();
	while($markerRow = mysql_fetch_assoc($markerQuery)){
		$mainType = $markerRow['maintype'];
		$mainId = $markerRow['id'];

		if($mainType == 'Course'){
			$mainUrl = SITE_URL.'course_details.php?course_id='.$mainId;
		}elseif($mainType == 'Candidate'){
			$mainUrl = SITE_URL.'guard-profile.php?user_id='.$mainId.'&status=1';
		}elseif($mainType == 'Job'){
			$mainUrl = SITE_URL.'place-bid.php?job_id='.$mainId;
		}else{
			$mainUrl = "";
		}

		$markerArray[] = "['".$markerRow['title']."',".$markerRow['lati'].",".$markerRow['longi'].",'".$markerRow['maintype']."','".$mainUrl."']";
	}
	
	$markerLocations = implode(",", $markerArray);
?>

<script>

	function initAutocomplete() {

	var citymap = {
		city: {
		center: {lat: <?php echo $userLat; ?>, lng: <?php echo $userLong; ?>}
		}
	};

	var map = new google.maps.Map(document.getElementById('map'), {
		center: {lat: <?php echo $userLat; ?>, lng: <?php echo $userLong; ?>},
		zoom: 12,
		mapTypeId: 'roadmap'
	});

	/* Functions to point marker as per jobs, cadidate and course on map */
	setMarkers(map);
	
	var howFarValueMap = parseInt($( "#how_far" ).val());
	for (var city in citymap) {
		/* Add the circle for this city to the map. */
		var cityCircle = new google.maps.Circle({
		strokeColor: '#FF0000',
		strokeOpacity: 0.8,
		strokeWeight: 1,
		fillColor: '#FF0000',
		fillOpacity: 0.35,
		map: map,
		center: citymap[city].center,
		radius: (howFarValueMap*1609.34)
		});
	}

	// Create the search box and link it to the UI element.
	var input = document.getElementById('pac-input');
	var searchBox = new google.maps.places.SearchBox(input);
	map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

	// Bias the SearchBox results towards current map's viewport.
	map.addListener('bounds_changed', function() {
		searchBox.setBounds(map.getBounds());
	});

	var markers = [];
	// Listen for the event fired when the user selects a prediction and retrieve
	// more details for that place.
	searchBox.addListener('places_changed', function() {
		var places = searchBox.getPlaces();

		if (places.length == 0) {
			return;
		}

		// Clear out the old markers.
		markers.forEach(function(marker) {
			marker.setMap(null);
		});
		markers = [];

		// For each place, get the icon, name and location.
		var bounds = new google.maps.LatLngBounds();
		places.forEach(function(place) {
		if (!place.geometry) {
			console.log("Returned place contains no geometry");
			return;
		}
		var icon = {
			url: place.icon,
			size: new google.maps.Size(71, 71),
			origin: new google.maps.Point(0, 0),
			anchor: new google.maps.Point(17, 34),
			scaledSize: new google.maps.Size(25, 25)
		};

		// Create a marker for each place.
		markers.push(new google.maps.Marker({
			map: map,
			icon: icon,
			title: place.name,
			position: place.geometry.location
		}));

		if (place.geometry.viewport) {
			// Only geocodes have viewport.
			bounds.union(place.geometry.viewport);
		} else {
			bounds.extend(place.geometry.location);
		}
		});
		map.fitBounds(bounds);
	});
	}

	$(window).load(function(){
		setTimeout(function(){
			$("#pac-input").insertAfter(".gm-style");
		}, 1000);
	});

	var allLocations = [
		<?php echo $markerLocations; ?>
	];

function setMarkers(map) {

	var image_default = {
		url: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png',
		size: new google.maps.Size(20, 32),
		origin: new google.maps.Point(0, 0),
		anchor: new google.maps.Point(0, 32)
	};

	var image_job = {
		url: "<?php echo SITE_URL; ?>marker_images/job.png",
		size: new google.maps.Size(20, 32),
		origin: new google.maps.Point(0, 0),
		anchor: new google.maps.Point(0, 32)
	};

	var image_course = {
		url: '<?php echo SITE_URL; ?>marker_images/course.png',
		size: new google.maps.Size(20, 32),
		origin: new google.maps.Point(0, 0),
		anchor: new google.maps.Point(0, 32)
	};

	var image_candidate = {
		url: '<?php echo SITE_URL; ?>marker_images/candidate.png',
		size: new google.maps.Size(20, 32),
		origin: new google.maps.Point(0, 0),
		anchor: new google.maps.Point(0, 32)
	};

	var shape = {
		coords: [1, 1, 1, 20, 18, 20, 18, 1],
		type: 'poly'
	};

	/* Loop start for all locations for Job, Course and Candidates */
	for (var i = 0; i < allLocations.length; i++) {
		var allLocation = allLocations[i];
		if(allLocation[3] == 'Candidate'){
			var image = image_candidate;
		} else if(allLocation[3] == 'Course'){
			var image = image_course;
		} else if(allLocation[3] == 'Job'){
			var image = image_job;
		}else{
			var image = image_default;
		}
		var marker = new google.maps.Marker({
			position: {lat: allLocation[1], lng: allLocation[2]},
			map: map,
			icon: image,
			shape: shape,
			title: allLocation[0]
		});
		
		/* Popup content onclick marker */
		var popContent = '<b>Title:</b> ' + allLocation[0] + '<br><br>';
		popContent += '<b>Type:</b> ' + allLocation[3] + '<br><br>';
		popContent += '<a class="markeranchor" href="' + allLocation[4] + '" target="_blank"><b><u>View '+allLocation[3]+'</u></b></a><br>';
		addInfoWindow(marker, popContent);
	}
}

/* Info window onclick on market to see Job, Course or Candidate */
function addInfoWindow(marker, content) {
    var infoWindow = new google.maps.InfoWindow({
        content: content
    });

    google.maps.event.addListener(marker, 'click', function () {
        infoWindow.open(map, marker);
    });
}
</script>		

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_JUu2G9vlijX1UgNTylx55U1hZQqw6QI&libraries=places&callback=initAutocomplete"
async defer></script>
<?php include "footer.php"; ?> 
</body>
</html>