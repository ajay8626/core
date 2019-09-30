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
	
	/*$jobcn="select * from tbljobs where job_user_id=".$_SESSION['user_id']." and status=1";
	$jobexc=$db->Query($jobcn);
    $jobRows = mysql_num_rows($jobexc);*/


    $user_cond='';
	if(isset($_SESSION['user_id']) && $_SESSION['user_id']!='')
	{
		$user_cond= " and job_user_id=".$_SESSION['user_id']."";
	}


	$featurejob=mysql_query("select tbljobs.* from tbljobs  LEFT JOIN tbljobcategories ON tbljobs.job_id=tbljobcategories.job_id LEFT JOIN tbljobstatus ON tbljobs.job_id=tbljobstatus.job_id where tbljobs.status=1 and tbljobs.job_status=1 and tbljobs.start_date >='".date("Y-m-d h:i:s")."' and tbljobs.payment_status=-1 ".$user_cond." group by tbljobs.job_id");
	$jobRows=mysql_num_rows($featurejob);

	
	


	
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


	$ongoing_bids=mysql_query("select tbljobs.* from tbljobs  LEFT JOIN tbljobcategories ON tbljobs.job_id=tbljobcategories.job_id LEFT JOIN tbljobstatus ON tbljobs.job_id=tbljobstatus.job_id where  tbljobs.status=1 and tbljobs.job_status=1 and tbljobs.start_date >='".date("Y-m-d h:i:s")."' ".$catjoin." and job_user_id!=".$_SESSION['user_id']." ".$searchtxt." group by tbljobs.job_id ".$orderby."");
	$ongoing_bids_rows=mysql_num_rows($ongoing_bids);

	if ($ongoing_bids_rows == NULL) {
		$ongoing_bids_rows = 0;
	}

	
	$completejob=mysql_query("select tbljobs.* from tbljobs  LEFT JOIN tbljobcategories ON tbljobs.job_id=tbljobcategories.job_id LEFT JOIN tbljobstatus ON tbljobs.job_id=tbljobstatus.job_id where  tbljobs.status=1 and tbljobs.job_status=4  ".$catjoin." ".$user_cond." ".$searchtxt." group by tbljobs.job_id ".$orderby."");
	$completerow=mysql_num_rows($completejob);

		
	$reviewsSql = mysql_query("select tbljobs.* from tbljobs LEFT JOIN tbljobcategories ON tbljobs.job_id=tbljobcategories.job_id LEFT JOIN tbljobstatus ON tbljobs.job_id=tbljobstatus.job_id where tbljobs.status=1 and tbljobs.job_status=4 and tbljobstatus.status=4 and tbljobs.job_user_id=".$_SESSION['user_id']."");

	
	$reviewsRow = mysql_num_rows($reviewsSql);

	$feedbackSql = mysql_query("select * from tblfeedback where reviewer_id=".$_SESSION['user_id']."");
	$feedbackRow = mysql_num_rows($feedbackSql);

	
	
	$job_invites =mysql_query("select * from hire_candidates where request_user_id =".$_SESSION['user_id']." and is_requested = 1");
	$job_invites_rows = mysql_num_rows($job_invites);
	
	$ongoing_jobs =mysql_query("select job_id from tbljobs where job_user_id=".$_SESSION['user_id']." AND status = 1");
	$ongoing_jobs_rows = mysql_num_rows($ongoing_jobs);
	while ($rw = mysql_fetch_assoc($ongoing_jobs)) {
		$ongoing_jobs_ids[] = $rw['job_id'];
	}
	$ongoing_jobs_ids = implode(', ', $ongoing_jobs_ids);

	
	/*my reviw and ratings start*/
	
	$rating_sql = "SELECT * FROM tblfeedback WHERE user_id=".$_SESSION['user_id']."";

	
	$rating_exc = mysql_query($rating_sql);
	$user_performance = 0;
	$user_punctuality = 0;
	$user_presentation = 0;
	$user_dresscode = 0;
	$user_attitude = 0;
	$rating_row_count = mysql_num_rows($rating_exc);
	if($rating_row_count >= 0){
		while($rating_rows = mysql_fetch_array($rating_exc)){
			$user_performance +=  $rating_rows['performance'];
			$user_punctuality +=  $rating_rows['punctuality'];
			$user_presentation +=  $rating_rows['presentation'];
			$user_dresscode +=  $rating_rows['dresscode'];
			$user_attitude +=  $rating_rows['attitude'];
		}
		$overallRating = ($user_performance/$rating_row_count) + ($user_punctuality/$rating_row_count) + ($user_presentation/$rating_row_count) + ($user_dresscode/$rating_row_count) + ($user_attitude/$rating_row_count);
		$overallRating = (($overallRating / 5) * 20);
		$starsFull = (int)($overallRating / 20);
		$starsempty = 5 - $starsFull;


		//echo "<pre>";print_r($overallRating);exit;
		
	}

	

	
	/*my reviw and ratings start*/

	/*$ongoing_bids =mysql_query("select * from tbljobsapplied where user_id=".$_SESSION['user_id']."");
	$ongoing_bids_rows = mysql_num_rows($ongoing_bids);*/

	


	$lost_bids =mysql_query("select * from tbljobsapplied where user_id=".$_SESSION['user_id']." and is_winner = 0");
	$lost_bids_rows = mysql_num_rows($lost_bids);
	if ($lost_bids_rows == NULL) {
		$lost_bids_rows = 0;
	}

	$winning_bids = mysql_query("SELECT  tbljobs.job_name AS title, tbljobs.start_date AS start, CASE WHEN 1=1 THEN '#CF2027' END AS color, CASE WHEN 1=1 THEN tbljobs.job_id END AS url FROM tbljobs LEFT JOIN tbljobcategories ON tbljobs.job_id=tbljobcategories.job_id LEFT JOIN tbljobstatus ON tbljobs.job_id=tbljobstatus.job_id LEFT JOIN  tbljobsapplied ON tbljobs.job_id=tbljobsapplied.job_id WHERE  tbljobs.status=1 AND tbljobs.job_status=1 AND tbljobs.start_date >='".date("Y-m-d h:i:s")."'AND tbljobs.payment_status= -1 AND tbljobsapplied.user_id=".$_SESSION['user_id']." and tbljobsapplied.is_winner= 1 ");


	//$winning_bids =mysql_query("select * from tbljobsapplied where user_id=".$_SESSION['user_id']." and is_winner = 1");
	$winning_bids_rows = mysql_num_rows($winning_bids);

	if ($winning_bids_rows == NULL) {
		$winning_bids_rows = 0;
	}


	/*bank section*/
	$pending_payment = "SELECT Sum(bidprice) as pending_payment_total FROM  tbljobsapplied WHERE  user_id = ".$_SESSION['user_id']." AND is_winner = 0";
	$pending_payment_total =mysql_query($pending_payment);
	$pending_payment = mysql_fetch_assoc($pending_payment_total);

	if ($pending_payment['pending_payment_total'] == NULL) {
		$pending_payment['pending_payment_total'] = 0;
	}


	/*this week start*/
	$monday = strtotime("last monday");
	$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;	 
	$sunday = strtotime(date("Y-m-d h:i:s",$monday)." +6 days");	 
	$this_week_sd = date("Y-m-d h:i:s",$monday);
	$this_week_ed = date("Y-m-d h:i:s",$sunday);	 
	$payed_this_weeks = "SELECT Sum(bidprice) as this_week_payment_total FROM tbljobsapplied WHERE is_winner=1 and user_id = ".$_SESSION['user_id']." AND applied_date BETWEEN '".$this_week_sd."' AND '".$this_week_ed."'";
			
	$payed_this_week =mysql_query($payed_this_weeks);
	$this_week_payed = mysql_fetch_assoc($payed_this_week);

	if ($this_week_payed['this_week_payment_total'] == NULL) {
		$this_week_payed['this_week_payment_total'] = '0';
	}
	/*this week end*/

	/*this month start*/
	$today = date("Y-m-d h:i:s");	
	$first_day = date("Y-m-01 h:i:s");
	$last_day = date("Y-m-t h:i:s", strtotime($today));
	$payed_this_months = "SELECT Sum(bidprice) as this_month_payment_total FROM tbljobsapplied WHERE is_winner=1 and user_id = ".$_SESSION['user_id']." AND applied_date BETWEEN '".$first_day."' AND '".$last_day."'";
			
	$payed_this_month =mysql_query($payed_this_months);
	$this_month_payed = mysql_fetch_assoc($payed_this_month);

	if ($this_month_payed['this_month_payment_total'] == NULL) {
		$this_month_payed['this_month_payment_total'] = '0';
	}
	/*this month end*/
	

	/*total start*/
	$total_payments = "SELECT Sum(bidprice) as total_payment FROM tbljobsapplied WHERE user_id = ".$_SESSION['user_id']." AND is_winner = 1";	
	$total_payment =mysql_query($total_payments);
	$total_payed = mysql_fetch_assoc($total_payment);

	if ($total_payed['total_payment'] == NULL) {
		$total_payed['total_payment'] = '0';
	}
	/*total start*/

	
	
	/*bank section*/	
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
<link href="css/main.css?ver=1.0.0" rel="stylesheet">
<link href="css/ddsmoothmenu.css" rel="stylesheet">
<link href="css/jquery.fancybox.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<link href="fonts/font-awesome.css" rel="stylesheet">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.bxslider.js"></script>
<script type="text/javascript" src="js/jquery.fancybox.js"></script>
<script type="text/javascript" src="js/menu.js"></script>
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
			$('.text_rate_card').show();
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
	height: 100px;    
	width: 100px;            
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
	<?php include "header-inner.php"; ?>
	<!--<div class="bp_wrap">
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

				<!-- Modal Area Start (Add Credits) 
				<div class="modal fade" id="addCredites">
							<div class="modal-dialog modal-dialog-centered">
							<div class="modal-content ">
							
								<!-- Modal Header 
								<h2 class="modal-title modal-head-css">Add Credits</h2>
								<!-- <div class="modal-header">
								<h4 class="modal-title">Add Credit</h4>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								</div> 
								
								<!-- Modal body 
								<div class="modal-body paypal_btn">
								<h6>Your credits amount: &pound;<?php echo $total_credit; ?></h6>
								<br/>

									<!-- Add Credit 
									<form action="paypal/payments.php" method="post" id="paypal_form">
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
								
								<!-- Modal footer 
								<div class="modal-footer">
								<button type="button" class="btn fees-modal-button" data-dismiss="modal">Close</button>
								</div>
								
							</div>
							</div>
						</div>
						<!-- Modal Area Ends (Add Credits) 
				
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
									<li class="call_dtl"><?php echo $phone; ?> <!--<a href="#">(Verify)</a></li>
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
								<!--<div class="cmp_map" id="map"></div>
							</div>
							<?php } ?>

						</div>
					</div>
					
				</div>
				
			</div>
			
		</div>
	</div>
	</div>
	-->

	<div class="stj_job_wrap businessprf">
	<div class="container">
	     <div class=" row">
		      <div class="dasbrod-bg business-user">
			       <div class="col-md-4 col-sm-6 dasbrod-row">
				       <div class="border-box">
					        <div class="my-job">
							     <div class="dasbrod-title">
								      <h2><i class="fas fa-hands-helping"></i> my jobs</h2>
								 </div>
								 <div class="comn-list">
								     <div class="list-row">
										 <div class="title"><span>JOB INVITES</span></div>
										 <div class="numbar"><span><?php echo $job_invites_rows; ?></span></div>
									 </div>
									 <div class="list-row">
									 	<div class="box-color">
										 <div class="title"><a href="ongoing_post_job.php"><span>ACTIVE JOBS</span></a></div>
										</div>
										 <div class="numbar"><span><?php echo $frow; ?></span></div>
									 </div>
									  <div class="list-row">
									  	<div class="box-color">
										 <div class="title"><a href="completed_post_job.php"><span>JOBS COMPLETED</span></a></div>
										</div>
										 <div class="numbar"><span><?php echo $completerow; ?></span><span><a href="#"></a></span></div>
									 </div>
	                                 <div class="list-row">
	                                     <div class="box-color">
										 <div class="title"><a href="postjob.php"><span>JOBS CREATED</span></a></div>
	                                     </div>
										 <div class="numbar"><span><?php echo $jobRows; ?></span></div>
									 </div>
									 
								 </div>
															 
							</div>
							
							<div class="bird">
							     <div class="dasbrod-title">
								      <h2> <i class="fas fa-grip-horizontal"></i> BIDS</h2>
								 </div>
								  <div class="comn-list">
									  <div class="list-row">
								  			<div class="box-color">
											 <div class="title"><a href="ongoing_bids.php"><span>ON GOING BIDS</span></a></div>
									  		</div>
											 <div class="numbar"><span><?php echo $ongoing_bids_rows; ?></span></div>
									</div>
									  <div class="list-row">
											 <div class="title"><span>LOST BIDS</span></div>
											 <div class="numbar"><span><?php echo $lost_bids_rows; ?></span><span></div>
									  </div>
									  <div class="list-row">
									  	<div class="box-color">
											 <div class="title"><a href="confirmedjobs.php"><span>WINNING BIDS</span></a></div>
											</div>
											 <div class="numbar"><span><?php echo $winning_bids_rows; ?></span></div>
									  </div>
								  </div>
							</div>
							
				   </div>
				      </div>
				   
				   <div class="col-md-4 col-sm-6 dasbrod-row">
	                   <div class="border-box">
					       <div class="location">
						        <div class="dasbrod-title">
							        <h2><i class="fas fa-map-marker-alt"></i> LOCATION</h2>
						         </div>
								<!--  <ul>
								 <li><span>SET LOCATION</span><input type="text" name="firstname" required="" class="txt_cnt"></li>
								 <li><span>SET RADIUS</span><input type="text" name="firstname" required="" class="txt_cnt"></li>
								 </ul> -->
								 <form class="select">
								       <span>How far are you willing to travel?</span>
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
								</form>
								<div class="srch_prf">
									<input type="text" id="pac-input" class="txt_search" placeholder="Search Location" />
									<!-- <input type="submit" class="btn_search" value="Go" /> -->
								</div>
								<!-- <div class="pac-card" id="pac-card">      
							      <div id="pac-container">
							        <input id="pac-input" type="text"
							            placeholder="Enter a location">
							      </div>
							    </div> -->
							    <!-- <div id="map" style="height: 500px; width: 800px;"></div> -->

							   	<div class="map" id="map" style="height:250px;">
									  
							    </div>
						   </div>
					   </div>
				   </div>
				   
				   
				   <div class="col-md-4 col-sm-6 dasbrod-row">
				     <div class="border-box">
					      <div class="messages">
						      <div class="dasbrod-title">
							        <h2><i class="fas fa-comment-dots"></i> NOTIFICATIONS</h2>
						       </div>
					
						   <div class="comn-list">
							   <div class="list-row">
							         <div class="box-color">
										<!-- <div class="title"><span>MESSAGES</span></div>
										<div class="numbar"><span><a href="#"></a></span></div> -->
									</div>
								</div>
								<?php
									$obj = new stjNotification;
									 $CountNotificationQuery = mysql_query("SELECT * FROM tblstjnotification WHERE notified_user_id=".$_SESSION['user_id']." ");
	        						$totalNotification = mysql_num_rows($CountNotificationQuery);
	        						$newNotification = $obj->countNotifications($_SESSION['user_id']);
								?>
								 <div class="list-row">
							         <div class="box-color">
										<div class="title"><span>ALL NOTIFICATIONS</span></div>
										<div class="numbar"><?php echo $newNotification;
											if($newNotification > 0) { ?>
										<span><a href="notification.php">(<?php echo $newNotification;?>New)</a></span>
										<?php } ?>
										</div>
									</div>
						   		</div>
						   	</div>	
						   <div class="clear"></div>
						   
						   	<div class="dasbrod-title">
							      <h2><i class="fas fa-user"></i> PROFILE </h2>
						     </div>
						     <div class="ip_wrap">
								<div class="ip_avail">
							 <ul class="profile-btn">
								  <li><a href="guard-profile.php?user_id=<?php echo $_SESSION['user_id']; ?>">VIEW PROFILE</a></li>
								  <!-- <li><a href="business-profile_old.php?user_id=<?php echo $_SESSION['user_id']; ?>">VIEW PROFILE</a></li> -->
								  <li><a href="profile-edit.php">EDIT PROFILE</a></li>
								  <!-- <li><a href="javascript:void(0);" id="edit_rate_card">EDIT RATE CARD</a>

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
								         		<li class="text_rate_card" style="display: none;"><?php echo $catdata['category_name']; ?> <span class="rate">£<?php echo $getratecard; ?></span>
										 		<input type="text" name="category_rate[<?php echo $catdata['category_id']; ?>]" size="3" id="<?php echo $catdata['category_id']; ?>" style="display:none;float:right;" maxlength="4" value="<?php echo $getratecard; ?>" class="txt_lg rate_card" /><span class="currency_symbol" style="display:none;">£</span></li>
							    		
									 			<?php 		}
								 						}
		                         				?>						 
							    			</ul> 
									</li> -->
								  <input type="hidden" name="is_edit_rate" id="is_edit_rate" value="1">
							 </ul>
							</div>
						</div>

							 
							 <!-- <div class="modal fade" id="myModal" role="dialog">
							    <div class="modal-dialog">
							      <div class="modal-content">
							        <div class="modal-header">
							          <button type="button" class="close" data-dismiss="modal">&times;</button>
							          <h4 class="modal-title">RATE CARD DETAIL</h4>
							        </div>
							        <div class="modal-body">
							        	<ul class="edit_card_detail">
							         	<?php 
											 $sql=mysql_query("select category_id,category_name from tblcategory where isactive=1 order by category_name");
											 $rows=mysql_num_rows($sql);
											 if($rows > 0)
											 {
												 while($catdata=mysql_fetch_array($sql))
												 {
													 
													 $getratecard=get_rate_card($catdata['category_id'],$_SESSION['user_id']);
													 
													 
											 ?>	
											 	<li>
											         <label><?php echo $catdata['category_name']; ?></label>
											         <span class="currency_symbol" style="display:none;">£</span>
													 <input type="text" name="category_rate[<?php echo $catdata['category_id']; ?>]" size="3" id="<?php echo $catdata['category_id']; ?>" maxlength="4" value="<?php echo $getratecard; ?>" class="txt_lg rate_card" />
													</li>

										    		
												 <?php }
											 }
					                         ?>
					                     </ul>
							        </div>
							        <div class="modal-footer">
							          <button type="button" id="edit_rate_card" class="btn btn-default" data-dismiss="modal">Close</button>
							        </div>
							      </div>
							      
							    </div>
							  </div> -->


							 
							 <div class="comn-list profile-row">
							     <!--<div class="list-row">
								     <div class="title"><span>ALL NOTIFICATIONS</span></div>
									  <div class="numbar">5</div>
								 </div>-->
								 <div class="list-row">
								     <div class="title"><span>REFERAL CODE</span></div>
									  <div class="numbar"><b><?php echo $referralCode ?></b></div>
								 </div>
								 <div class="list-row">
								     <div class="title"><span>VERIFIED ACCOUNT?</span></div>
									  <div class="numbar">
									       <div class="btn-box">
										   <ul>
										   		<?php
										   			if($verified_user) { 
										   		?>
										   		<li><a href="#"><img src="images/rt-icons.png" style="height:15px;width: 15px; margin: 0px 14px 12px 2px;"></a></li>
										   		
										   		<?php 
										   		}
										   		else{ ?>
										   		<li><a href="#"><img src="images/close-icons.png" style="height:15px;width: 15px; margin: 0px 14px 12px 2px;"></a></li>
										   		<?php 
										   			}
										   		?>
											</ul>  
										   </div>
									  </div>
								 </div>
							 </div>
						   
						 </div>
					  </div>
				   </div>
				   
				   
				    <div class="col-md-4 col-sm-6 dasbrod-row">
					         <div class="border-box">
							       <div class="bank">
								        <div class="dasbrod-title">
							                 <h2> <i class="fas fa-piggy-bank"></i> BANK</h2>
						                  </div>
										  
										     <div class="comn-list">
												   <div class="list-row">
														 <div class="">
															<div class="title"><span>PENDING PAYMENTS</span></div>	     	
														<div class="numbar"><span class="price">£</span><?php echo $pending_payment['pending_payment_total']; ?></div>
														</div>
													</div>
													 <div class="list-row">
													 	 <div class="">
															<div class="title"><span>PAID THIS WEEK</span></div>
															<div class="numbar"><span class="price">£</span><?php echo $this_week_payed['this_week_payment_total']; ?></div>
														</div>
													</div>
													 <div class="list-row">
													 	 <div class="">
															<div class="title"><span>PAID THIS MONTH</span></div>
															<div class="numbar"><span class="price">£</span><?php echo $this_month_payed['this_month_payment_total']; ?></div>
															 </div>
													</div>
													 <div class="list-row">
													 	 <div class="">
															<div class="title"><span>TOTAL PAY</span></div>
															<div class="numbar"><span class="price">£</span><?php echo $total_payed['total_payment']; ?></div>
															 </div>
													</div>
													 <div class="list-row">
													 	 <div class="">
															<div class="title"><span>CREDITS</span></div>
															<div class="numbar"><?php echo $total_credit; ?></div>
														</div>
													</div>
													
													 
											 </div>
								   </div>
							 </div>
					 </div>
					 
					 
					     <div class="col-md-4 col-sm-6 dasbrod-row">
					         <div class="border-box">
							       <div class="search">
								        <div class="dasbrod-title">
							                 <h2> <i class="fas fa-search"></i> SEARCH CANDIDATES</h2>
						                 </div>
										  <div class="comn-list">
										        <div class="list-row">
												     <div class="box-color">
													     <div class="title"><a href="new-request.php"><span>SEARCH CANDIDATES</span></a></div>
													 </div>
												</div>
												<div class="list-row">
												     <div class="box-color">
													     <div class="title"><a href="requested.php"><span>REQUESTED/INVITES</span></a></div> 
													 </div>
												</div>
												<div class="list-row">
												     <div class="box-color">
													     <div class="title"><a href="confirmed.php"><span>CONFIRMED</span></a></div>
													 </div>
												</div>
											 <div class="list-row">
												     <div class="box-color">
													     <div class="title"><a href="favourite_list.php"><span>VIEW FAVOURITES (WATCHLIST)</span></a></div>
													 </div>
												</div>
										  </div>

										  								
								   </div>
							 </div>
					 </div>
					 
					 				     <div class="col-md-4 col-sm-6 dasbrod-row">
					         <div class="border-box">
							       <div class="reviews">
								        <div class="dasbrod-title">
							                 <h2><i class="fas fa-star"></i> REVIEWS &RATINGS</h2>
						                 </div>	
	                                     <div class="comn-list">
										      <div class="list-row">
											      <!-- <div class="title"><span>MYJOBS AWAITING REVIEW</span></div> -->
												   <!-- <div class="numbar"><span><?php echo $reviewsRow; ?></span></div> -->
											  </div>
											   <div class="list-row">
												 	<div class="box-color">
														<div class="title"><span><a href="feedback.php">LEAVE FEEDBACK</a></span></div>
													<div class="numbar"><span><?php //echo $feedbackRow; ?></span></div>
													</div>
												</div>
												 <div class="list-row">
												 	<div class="box-color">
															<div class="title"><span><a href="my_reviews.php">MY REVIEWS</a></span></div>
													<div class="numbar" style="color:#ffffff"><span><?php echo $rating_row_count; ?></span></div> 
													</div>
												</div>
												 <div class="list-row">
												 <div class="box-color">
													<div class="title"><span>MY RATINGS</span></div>
													<div class="numbar" style="color:#ffffff"><span><?php echo $overallRating."%"; ?></span></div>
												</div>
											<div class="list-row">
											      <div class="title"><span>CURRENT RATING</span></div>
											      <div class="star numbar">
												    <?php
												    for($i=1; $i<=$starsFull; $i++){
														echo '<i class="fas fa-star feedback-str-full"></i>';
													}
													for($i=1; $i<=$starsempty; $i++){
														echo '<i class="far fa-star feedback-str-null"></i>';
													} ?>
													</div>
											  </div>
	                                     </div>											  
								   </div>
							 </div>
					 </div>
				   

				   
			  </div>
		 </div>
	  </div>
	</div>


 <?php
	$userLat = $latitude;
	$userLong = $longitude;
	$userHowFar = $how_far;

	//$markerSql = "SELECT c.name AS title, c.course_id AS id, c.latitude AS lati, c.longitude AS longi, (CASE WHEN 1=1 THEN 'Course' END) AS maintype FROM tblcourse c WHERE (getDistancemiles(c.latitude, c.longitude, ".$userLat.", ".$userLong.") <= ".$userHowFar.") AND (getDistancemiles(c.latitude, c.longitude, ".$userLat.", ".$userLong.") > 0) AND c.status=1 UNION SELECT CONCAT(firstname, ' ', lastname) AS title, u.user_id AS id, u.latitude AS lati, u.longitude AS longi, (CASE WHEN 1=1 THEN 'Candidate' END) AS maintype FROM tbluser u WHERE (getDistancemiles(u.latitude, u.longitude, ".$userLat.", ".$userLong.") <= ".$userHowFar.") AND (getDistancemiles(u.latitude, u.longitude, ".$userLat.", ".$userLong.") > 0) AND u.status=1 UNION SELECT j.job_name AS title, j.job_id AS id, j.latitude AS lati, j.longitude AS longi, (CASE WHEN 1=1 THEN 'Job' END) AS maintype FROM tbljobs j WHERE (getDistancemiles(j.latitude, j.longitude, ".$userLat.", ".$userLong.") <= ".$userHowFar.") AND (getDistancemiles(j.latitude, j.longitude, ".$userLat.", ".$userLong.") > 0) AND j.status=1";


	$markerSql = "SELECT c.course_title AS title, c.course_id AS id, c.latitude AS lati, c.longitude AS longi, (CASE WHEN 1=1 THEN 'Course' END) AS maintype FROM tblcoursemaster c WHERE (getDistancemiles(c.latitude, c.longitude, 52.2342262, -0.897602) <= 200) AND (getDistancemiles(c.latitude, c.longitude, 52.2342262, -0.897602) > 0) AND c.status=1 AND c.start_date >='".date("Y-m-d h:i:s")."'
		UNION 
		SELECT CONCAT(firstname, ' ', lastname) AS title, u.user_id AS id, u.latitude AS lati, u.longitude AS longi, (CASE WHEN 1=1 THEN 'Candidate' END) AS maintype FROM tbluser u WHERE (getDistancemiles(u.latitude, u.longitude, 52.2342262, -0.897602) <= 200) AND (getDistancemiles(u.latitude, u.longitude, 52.2342262, -0.897602) > 0) AND u.status=1 
		UNION 
		SELECT j.job_name AS title, j.job_id AS id, j.latitude AS lati, j.longitude AS longi, (CASE WHEN 1=1 THEN 'Job' END) AS maintype FROM tbljobs j WHERE (getDistancemiles(j.latitude, j.longitude, 52.2342262, -0.897602) <= 200) AND (getDistancemiles(j.latitude, j.longitude, 52.2342262, -0.897602) > 0) AND j.status=1 AND j.start_date >='".date("Y-m-d h:i:s")."'";

	//echo "<pre>";print_r($markerSql);exit;
	

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
      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      function initMap() {

      	var latitude = <?php echo $latitude; ?>; // YOUR LATITUDE VALUE
        var longitude = <?php echo $longitude; ?>; // YOUR LONGITUDE VALUE            
        var myLatLng = {lat: latitude, lng: longitude};

        
       var citymap = {
            city: {
            center: {lat: <?php echo $userLat; ?> , lng: <?php echo $userLong; ?>}
            }
          };       


        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: <?php echo $userLat; ?>, lng: <?php echo $userLong; ?>},
          zoom: 12,
          mapTypeId: 'roadmap'
        });

        var marker = new google.maps.Marker({
              position: myLatLng,
              map: map,
              title: latitude + ', ' + longitude 
            }); 

        setMarkers(map);

        var howFarValueMap = parseInt($( "#how_far" ).val());
          for (var city in citymap) {
            
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



        var card = document.getElementById('pac-card');
        var input = document.getElementById('pac-input');
        var types = document.getElementById('type-selector');
        var strictBounds = document.getElementById('strict-bounds-selector');

        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

        var autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.setComponentRestrictions(
            {'country': ['UK', 'pr', 'vi', 'gu', 'mp']});

        // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.
        autocomplete.bindTo('bounds', map);

        // Set the data fields to return when the user selects a place.
        autocomplete.setFields(
            ['address_components', 'geometry', 'icon', 'name']);

        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById('infowindow-content');
        infowindow.setContent(infowindowContent);
        var marker = new google.maps.Marker({
          map: map,
          anchorPoint: new google.maps.Point(0, -29)
        });

        autocomplete.addListener('place_changed', function() {
          infowindow.close();
          marker.setVisible(false);
          var place = autocomplete.getPlace();
          if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert("No details available for input: '" + place.name + "'");
            return;
          }

          // If the place has a geometry, then present it on a map.
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
          }
          marker.setPosition(place.geometry.location);
          marker.setVisible(true);

          var address = '';
          if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
          }

          infowindowContent.children['place-icon'].src = place.icon;
          infowindowContent.children['place-name'].textContent = place.name;
          infowindowContent.children['place-address'].textContent = address;
          infowindow.open(map, marker);
        });

        function setupClickListener(id, types) {
          var radioButton = document.getElementById(id);
          radioButton.addEventListener('click', function() {
            autocomplete.setTypes(types);
          });
        }

        setupClickListener('changetype-all', []);
        setupClickListener('changetype-address', ['address']);
        setupClickListener('changetype-establishment', ['establishment']);
        setupClickListener('changetype-geocode', ['geocode']);

        document.getElementById('use-strict-bounds')
            .addEventListener('click', function() {
              console.log('Checkbox clicked! New state=' + this.checked);
              autocomplete.setOptions({strictBounds: this.checked});
            });
      }

      /*$(window).load(function(){
		setTimeout(function(){
			$("#pac-input").insertAfter(".gm-style");
		}, 1000);
	});*/

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

	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_JUu2G9vlijX1UgNTylx55U1hZQqw6QI&libraries=places&callback=initMap"
        async defer></script>

	<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_JUu2G9vlijX1UgNTylx55U1hZQqw6QI&libraries=places&callback=initMap"        async defer></script> -->
	<?php include "footer.php"; ?>
</body>
</html>