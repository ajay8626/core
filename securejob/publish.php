<?php 

include "config.php"; 

require_once(ADMIN_PATH."inc/img_upload.php");
include_once(ADMIN_PATH."inc/functions.php");
include_once(ADMIN_PATH."inc/resize-class.php");


if(isset($_POST['submit']) && $_POST['submit']=='Next')
{
		$user_id = $_SESSION['user_id'];
	    $job_title=isset($_POST['job_title']) ? $_POST['job_title'] :'';
		$job_location=isset($_POST['job_location']) ? $_POST['job_location'] :'';
		$description =	isset($_REQUEST["description"])&&$_REQUEST["description"]!=''?$_REQUEST["description"]:'';
		$is_featured = 	isset($_REQUEST["is_featured"])&&$_REQUEST["is_featured"]!=''?$_REQUEST["is_featured"]:0;
		$status = 	isset($_REQUEST["status"])&&$_REQUEST["status"]!=''?$_REQUEST["status"]:0;
		$price = 	isset($_REQUEST["proposed_amount"])&&$_REQUEST["proposed_amount"]!=''?$_REQUEST["proposed_amount"]:0;
		$hours = 	isset($_REQUEST["hours"])&&$_REQUEST["hours"]!=''?$_REQUEST["hours"]:0;
		$days = 	isset($_REQUEST["days"])&&$_REQUEST["days"]!=''?$_REQUEST["days"]:0;
		$start_date = 	isset($_REQUEST["start_date"])&&$_REQUEST["start_date"]!=''?$_REQUEST["start_date"]:'';
		$riskmeter = 	isset($_REQUEST["riskmeter"])&&$_REQUEST["riskmeter"]!=''?$_REQUEST["riskmeter"]:'';
		$job_type = 	isset($_REQUEST["job_type"])&&$_REQUEST["job_type"]!=''?$_REQUEST["job_type"]:'';
		$categories = 	isset($_REQUEST["categories"])&&$_REQUEST["categories"]!=''?$_REQUEST["categories"]:'';
		$tags = 	isset($_REQUEST["tags"])&&$_REQUEST["tags"]!=''?$_REQUEST["tags"]:'';
		$transportlink = 	isset($_REQUEST["transportlink"])&&$_REQUEST["transportlink"]!=''?$_REQUEST["transportlink"]:'';
		$dresscode_description = 	isset($_REQUEST["dresscode_description"])&&$_REQUEST["dresscode_description"]!=''?$_REQUEST["dresscode_description"]:'';
		$opening_position = 	isset($_REQUEST["opening_position"])&&$_REQUEST["opening_position"]!=''?$_REQUEST["opening_position"]:0;
		$joblocation = 	isset($_REQUEST["joblocation"])&&$_REQUEST["joblocation"]!=''?$_REQUEST["joblocation"]:'';
		$openning_type = 	isset($_REQUEST["opening_type"])&&$_REQUEST["opening_type"]!=''?$_REQUEST["opening_type"]:0;
		$duration_in = 	isset($_REQUEST["duration_in"])&&$_REQUEST["duration_in"]!=''?$_REQUEST["duration_in"]:0;
		$latitude = 	isset($_REQUEST["latitude"])&&$_REQUEST["latitude"]!=''?$_REQUEST["latitude"]:'';
		$longitude = 	isset($_REQUEST["longitude"])&&$_REQUEST["longitude"]!=''?$_REQUEST["longitude"]:'';
		$address_1 = 	isset($_REQUEST["address_1"])&&$_REQUEST["address_1"]!=''?$_REQUEST["address_1"]:'';
		$address_2 = 	isset($_REQUEST["address_2"])&&$_REQUEST["address_2"]!=''?$_REQUEST["address_2"]:'';
		$postal_code = 	isset($_REQUEST["postalcode"])&&$_REQUEST["postalcode"]!=''?$_REQUEST["postalcode"]:'';
		$country_id =	isset($_REQUEST["country_id"])&&$_REQUEST["country_id"]!=''?$_REQUEST["country_id"]:0;
		$state_id =	isset($_REQUEST["state_id"])&&$_REQUEST["state_id"]!=''?$_REQUEST["state_id"]:0;
		$city_id =	isset($_REQUEST["city_id"])&&$_REQUEST["city_id"]!=''?$_REQUEST["city_id"]:0;
		$last_id =	isset($_REQUEST["last_id"]) ? $_REQUEST["last_id"]:'';
	
		if($start_date!='')
		{
			$start_ex=explode("/",$start_date);
			$start_date=$start_ex[2]."-".$start_ex[1]."-".$start_ex[0];
		}
		$newfilename='';
		$newFilePath='';
		$newFileURL='';
		
		if($address_1 != ""){
			$latLongAddress = $address_1;
		}else{
			$latLongAddress = $postal_code;
		}

		$latlong    =   get_lat_long($latLongAddress);
		$map        =   explode(',' ,$latlong);
		$mapLat     =   $map[0];
		$mapLong    =   $map[1];
		
	    $images='';
	    $_SESSION['jobdetails']=$_POST;
		$_SESSION['jobimages']=$_FILES;
	
	if($last_id=='')
	{	
		
		$data = array('job_user_id'=>$_SESSION['user_id'],'job_name'=>$job_title,'job_description'=>$description,'price'=>$price,'image'=>$images,'job_days'=>$days,'job_hours'=>$hours,'start_date'=>$start_date,'riskmeter'=>$riskmeter,'job_type'=>$job_type,'latitude'=>$mapLat,'longitude'=>$mapLong,'address1'=>$address_1,'address2'=>$address_2,'postalcode'=>$postal_code,'country_id'=>$country_id,'state_id'=>$state_id,'city_id'=>$city_id,'transport_link'=>$transportlink,'dresscode'=>$dresscode_description,'status'=>$status,'created_date'=>date('Y-m-d H:i:s'),'isfeatured'=>$is_featured,'opening_position'=>$opening_position,'job_location'=>$job_location,'opening_type'=>$openning_type,'duration_in'=>$duration_in);
		$db->Insert($data,"tbljobs");
		
		$last_id = mysql_insert_id();
		mysql_query("INSERT INTO tbltotalview (job_id, totalvisit) VALUES('".$last_id."', '0')");
		$_SESSION['last_id']=$last_id;
		
		if($_FILES['image']['name']!='')
		{
			$imgcount=count($_FILES['image']['name']);
			
			for($i=0;$i<$imgcount;$i++)
			{
			$tmpFilePath = $_FILES['image']['tmp_name'][$i];
			if ($tmpFilePath != ""){
				$path = $_FILES['image']['name'][$i];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$randname=rand(111111,999999);
				$newfilename =$randname.".".$ext;
				$newthumbfilename = "th_".$randname.".".$ext;
				
				$newFilePath = JOBS_IMG_PATH . $newfilename;
				if(move_uploaded_file($tmpFilePath, $newFilePath))
				{
					$path2=JOBS_IMG_PATH;
					$resizeObj1 = new resize(JOBS_IMG_PATH.$newfilename);
					$resizeObj1->resizeImage(780, 780, 'exact');
					$resizeObj1->saveImage("$path2/$newthumbfilename", 100);
				}
				
			}
				$job_image = '';
				if($newfilename!='')
				{
					$job_image = $newfilename;
					$data=array("jobid"=>$last_id,"imagename"=>$job_image);
					$db->Insert($data,"tbljobimages");
				}
			}
		}
			
		if(!empty($categories)){
			foreach($categories as $cat_id){
				$data=array("job_id"=>$last_id,"category_id"=>$cat_id);
				$db->Insert($data,"tbljobcategories");	
			}
		}
			
		if(!empty($tags)){
			foreach($tags as $tag_id){
				$data=array("job_id"=>$last_id,"tag_id"=>$tag_id);
				$db->Insert($data,"tbljobtags");	
			}
		}

		/* Mail Function */
		job_created($user_id, $job_title); 
	}
    else
	{
	 
	   $where ="job_id ={$last_id}";
	   
	   $data = array('job_user_id'=>$_SESSION['user_id'],'job_name'=>$job_title,'job_description'=>$description,'price'=>$price,'image'=>$images,'job_days'=>$days,'job_hours'=>$hours,'start_date'=>$start_date,'riskmeter'=>$riskmeter,'job_type'=>$job_type,'latitude'=>$mapLat,'longitude'=>$mapLong,'address1'=>$address_1,'address2'=>$address_2,'postalcode'=>$postal_code,'country_id'=>$country_id,'state_id'=>$state_id,'city_id'=>$city_id,'transport_link'=>$transportlink,'dresscode'=>$dresscode_description,'status'=>$status,'created_date'=>date('Y-m-d H:i:s'),'isfeatured'=>$is_featured,'opening_position'=>$opening_position,'job_location'=>$job_location,'opening_type'=>$openning_type,'duration_in'=>$duration_in);
		$db->Update($data,"tbljobs",$where);
		
		$img="jobid ={$last_id}";
		$db->Delete("tbljobimages",$img);
		
		if($_FILES['image']['name']!='')
		{
			$imgcount=count($_FILES['image']['name']);
			
			for($i=0;$i<$imgcount;$i++)
			{
			$tmpFilePath = $_FILES['image']['tmp_name'][$i];
			if ($tmpFilePath != ""){
				$path = $_FILES['image']['name'][$i];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$randname=rand(111111,999999);
				$newfilename =$randname.".".$ext;
				$newthumbfilename = "th_".$randname.".".$ext;
				
				$newFilePath = JOBS_IMG_PATH . $newfilename;
				if(move_uploaded_file($tmpFilePath, $newFilePath))
				{
					$path2=JOBS_IMG_PATH;
					$resizeObj1 = new resize(JOBS_IMG_PATH.$newfilename);
					$resizeObj1->resizeImage(780, 780, 'exact');
					$resizeObj1->saveImage("$path2/$newthumbfilename", 100);
				}
				
			}
			
				$job_image = '';
				if($newfilename!='')
				{
					$job_image = $newfilename;
					$data=array("jobid"=>$last_id,"imagename"=>$job_image);
					$db->Insert($data,"tbljobimages");
				}
			}
		}
			
		if(!empty($categories)){
			$db->Delete("tbljobcategories",$where);
			foreach($categories as $cat_id){
				$data=array("job_id"=>$last_id,"category_id"=>$cat_id);
				$db->Insert($data,"tbljobcategories");	
			}
		}
			
		if(!empty($tags)){
			$db->Delete("tbljobtags",$where);
			foreach($tags as $tag_id){
				$data=array("job_id"=>$last_id,"tag_id"=>$tag_id);
				$db->Insert($data,"tbljobtags");	
			}
		}
		
		/* Mail Function */
		job_created($user_id, $job_title);
     	 
	}		
  
}



 
//echo '<pre>'; print_r($_SESSION['jobimages']);
//echo '<br>';
//echo $_SESSION['jobimages']['image']['name'];
//exit;


$job_title=isset($_SESSION['jobdetails']['job_title']) ? $_SESSION['jobdetails']['job_title']:'';
$job_location=isset($_SESSION['jobdetails']['job_location']) ? $_SESSION['jobdetails']['job_location']:'';
$address1=isset($_SESSION['jobdetails']['address_1']) ? $_SESSION['jobdetails']['address_1']:'';
$categories=isset($_SESSION['jobdetails']['categories']) ? $_SESSION['jobdetails']['categories']:'';
$opening_type=isset($_SESSION['jobdetails']['opening_type']) ? $_SESSION['jobdetails']['opening_type']:'';
$proposed_amount=isset($_SESSION['jobdetails']['proposed_amount']) ? $_SESSION['jobdetails']['proposed_amount']:0;
$opening_position=isset($_SESSION['jobdetails']['opening_position']) ? $_SESSION['jobdetails']['opening_position']:'';
$duration_in=isset($_SESSION['jobdetails']['duration_in']) ? $_SESSION['jobdetails']['duration_in']:'';
$days=isset($_SESSION['jobdetails']['days']) ? $_SESSION['jobdetails']['days']:'';
$hours=isset($_SESSION['jobdetails']['hours']) ? $_SESSION['jobdetails']['hours']:0;
$start_date=isset($_SESSION['jobdetails']['start_date']) ? $_SESSION['jobdetails']['start_date']:'';
$description=isset($_SESSION['jobdetails']['description']) ? $_SESSION['jobdetails']['description']:'';
$tags=isset($_SESSION['jobdetails']['tags']) ? $_SESSION['jobdetails']['tags']:'';
$riskmeter=isset($_SESSION['jobdetails']['riskmeter']) ? $_SESSION['jobdetails']['riskmeter']:'';
$job_type=isset($_SESSION['jobdetails']['job_type']) ? $_SESSION['jobdetails']['job_type']:'';
$transportlink=isset($_SESSION['jobdetails']['transportlink']) ? $_SESSION['jobdetails']['transportlink']:'';
$dresscode_description=isset($_SESSION['jobdetails']['dresscode_description']) ? $_SESSION['jobdetails']['dresscode_description']:'';
$is_featured=isset($_SESSION['jobdetails']['is_featured']) ? $_SESSION['jobdetails']['is_featured']:0;
$user_id=isset($_SESSION['user_id']) ? $_SESSION['user_id']:0;
$total_user_credit=get_credit($user_id);
$total=$proposed_amount * $opening_position * $days * $hours;

$categorynames='';
if(!empty($categories))
{
	$category_ids=implode(",",$categories);
	$sql=mysql_query("select category_name from tblcategory where isactive=1 and category_id IN (".$category_ids.") order by category_name");
	 $rows=mysql_num_rows($sql);
	 if($rows > 0)
	 {
		 while($catdata=mysql_fetch_array($sql))
		 {
			 $categorynames .=$catdata['category_name'].", ";
		 }
		 $categorynames=substr($categorynames,0,-2);
	 }
}

//Base Fees
$configBaseFee = mysql_query("SELECT * FROM tblsystemconfiguration WHERE config_id=1");
$configBaseFeeRows = mysql_fetch_array($configBaseFee);
$base_fee=$configBaseFeeRows['title_value'];

//Featured Fees
$configFeaturedFee = mysql_query("SELECT * FROM tblsystemconfiguration WHERE config_id=2");
$configFeaturedFeeRows = mysql_fetch_array($configFeaturedFee);
$featurefee=$configFeaturedFeeRows['title_value'];

$voucherDiscount=0;
$voucherFlag = "";
$totalfees=$base_fee;

if($is_featured==1)
{
	$totalfees=$base_fee + $featurefee;
}

if(isset($_POST['voucher_code_submit'])){
	$voucherCode = $_POST['voucher_code'];
	if($voucherCode != ''){
		$voucherSql = mysql_query("SELECT * FROM tblcouponcodemaster WHERE couponcode='$voucherCode'");
		$voucherRowsNum = mysql_num_rows($voucherSql);
		if($voucherRowsNum > 0){
			$voucherFlag = 1;
			$voucherRows = mysql_fetch_array($voucherSql);
			$voucherType = $voucherRows['type'];
			if($voucherType == 1){
				$voucherDiscount = $voucherRows['amount'];
				$totalfees=$totalfees-$voucherDiscount;
			}
			if($voucherType == 2){
				$voucherDiscount = number_format((float)(($totalfees * $voucherRows['amount'])/100), 2);
				$totalfees=number_format((float)($totalfees-$voucherDiscount), 2);
			}
		}else{
			$voucherCodeErrMsg = "<p><font color='red'>Invalid code</font></p>";
		}
	}else{
		$voucherCodeErrMsg = "<p><font color='red'>Please enter the code</font></p>";
	}
}

// if($is_featured==1)
// {
// 	$totalfees=$base_fee + $featurefee;
// }


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


$job_type_txt='';
if(isset($job_type) && $job_type==1)
{
	$job_type_txt='Part Time';
}
if(isset($job_type) && $job_type==2)
{
	$job_type_txt='Full Time';
}


if(isset($_POST['submit']) && ($_POST['submit']=='Pay by Credits' || $_POST['submit']=='Pay by paypal'))
{
	
	$data=array('status'=>1);
	$where ="job_id ={$_SESSION['last_id']}";
    $db->Update($data,"tbljobs",$where);
	
	unset($_SESSION['jobdetails']);
	unset($_SESSION['jobimages']);
	unset($_SESSION['last_id']);
	if(isset($_SESSION['request_user_id']))
	{
	  header("Location:guard-profile.php?user_id=".$_SESSION['request_user_id']."");
	  exit();
	}
	else
	{
	  header("Location:postjob.php");
	  exit();
	}
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
<title>Publish - SECURE THAT JOB</title>
<link href="https://fonts.googleapis.com/css?family=Fira+Sans:300,400,400i,500,600,700,800" rel="stylesheet"> 
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link href="css/jquery-ui.css" rel="stylesheet">
<link href="css/ddsmoothmenu.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">
<link href="fonts/font-awesome.css" rel="stylesheet">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.bxslider.js"></script>
<script type="text/javascript" src="js/menu.js"></script>
<script src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/at-jquery.js"></script> 
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({includedLanguages: '<?php echo LanguageList; ?>', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script> 
<script>
function directPayCredit(job_id,total_fees){
	var retVal = confirm("Do you want to pay with available credit?");
	if( retVal == true ){
	$.ajax(
		{
			url: 'directpaycredit.php?job_id='+job_id+"&total_fees="+total_fees,
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
			if(!alert(data)){window.location.href = 'postjob.php';}			
		})
		.fail(function(jqXHR, ajaxOptions, thrownError)
		{
				//alert('No response from server');
		});
	}else{
		return false;
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
<div id="preloader" style="display:none; z-index:99999;"></div>
<?php 
include "header-inner.php";
?>

<div class="stj_login_wrap stj_reg_wrap">
	<div class="container">
		<div class="row">
			
			<div class="reg_dv">
				<h2>Add New Job Details</h2>
				<div class="jobdetail">
					<ul class="jobtab">
						<li><a href="#">Job Details</a></li>
						<li class="active"><a href="#">Publish</a></li>
					</ul>
					<div class="jobmain">
						<div class="jobleft publish">
						<form method="post" name="publish" action="add-new-job.php">
					<ul>	
							<li>
							<label>Job Title: </label><div class="detail"><?php echo $job_title; ?></div>  
						</li>				
								<li>
							<label>Job Location: </label><div class="detail"><?php echo $job_location; ?></div>  
						</li>		
									<li>
							<label>Job Category:</label><div class="detail"><?php echo $categorynames; ?></div>  
						</li>

                        <li>
							<label>Job Type:</label><div class="detail"><?php echo $job_type_txt; ?></div>  
						</li>    
									<li>
							<label>Proposed Amount:</label><div class="detail">£<?php echo $proposed_amount; ?> per person per hour <?php if($total!=''){ ?>(Total: £   <?php echo  number_format($total, 2, '.', ''); ?>)<?php } ?></div>  
						</li>		
									<li>
							<label>No. of openings:</label><div class="detail"><?php echo $opening_position; ?></div>  
						</li>
                            <li>
							<label>Duration:</label><div class="detail"><?php echo $days; ?> Days (<?php echo $hours; ?> hours working per day)</div>  
						</li>
						
						<li>
							<label>Start Date:</label><div class="detail"><?php echo $start_date; ?></div>  
						</li>
						
						<li>
							<label>Job Description:</label><div class="detail"><?php echo $description; ?></div>  
						</li>
                        <li>
							<label>Risk Meter:</label><div class="detail"><?php echo $risk_txt; ?></div>  
						</li>

						<?php if($transportlink != ''){ ?>
                        <li>
							<label>Nearest Transport Link:</label><div class="detail"><?php echo $transportlink; ?></div>  
						</li>
						<?php } ?>

						<?php if($dresscode_description != ''){ ?>
                         <li>
							<label>Dress Code:</label><div class="detail"><?php echo $dresscode_description; ?></div>  
						</li>		
						<?php } ?>

					</ul>
					<div class="nextbtn">
					<input value="Edit" name="submit" class="btn_lg" type="submit">				
				</div>
				</form>
				</div>
				<!-- Modal Area Start -->
				<?php 
					$fee_sql = mysql_query("SELECT title, content FROM tblcmspages WHERE page_id=11");
					$fees_row = mysql_fetch_array($fee_sql);
				?>
				<div class="modal fade" id="postingFees">
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


				<!-- Modal Area Start (Add Credits) -->
				<?php 
					$fee_sql = mysql_query("SELECT title, content FROM tblcmspages WHERE page_id=11");
					$fees_row = mysql_fetch_array($fee_sql);
				?>
				<div class="modal fade" id="addCredites">
					<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
					
						<!-- Modal Header -->
						<h2 class="modal-title">Add Credit</h2>
						<!-- <div class="modal-header">
						<h4 class="modal-title">Add Credit</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div> -->
						
						<!-- Modal body -->
						<div class="modal-body paypal_btn">
						<h4>Base Fee: &pound;<?php echo $base_fee; ?></h4>
						<?php if($is_featured==1){ ?>
							<h4>Featured Fee: &pound;<?php echo $featurefee; ?></h4>
						<?php } ?>
						<?php if($voucherFlag==1){ ?>
							<h4>Discount: &pound;<?php echo $voucherDiscount; ?></h4>
						<?php } ?>
						<h4>Total to Pay: &pound;<?php echo $totalfees; ?></h4>
						<?php if(isset($_POST['submitcredit'])){ ?>
							<h1>Yeah</h1>
						<?php } ?>
						<h6>Your credits amount: &pound;<?php echo $total_user_credit; ?></h6>
						<br/>
							<!-- Directly Pay with Credit -->
							<form action="" method="post" id="paypal_form" target="_blank">
							
								<input type="hidden" name="item_number" value="<?php echo $_SESSION['last_id']; ?>" />
								<input type="hidden" name="amount" value="<?php echo $totalfees; ?>"  />
								<input type="hidden" name="user_id" value="<?php echo $user_id ?>" />
								<input type="hidden" name="custom" value="pay_with_paypal" />
								<input type="button" class="direct_pay_credit" onclick="javascript:return directPayCredit(<?php echo $_SESSION['last_id']; ?>, <?php echo $totalfees; ?>);" value="Pay"/>
							
							</form>
							<br/>
							<h4>OR</h4>
							<br/>
							<!-- Add Credit -->
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
								<input type="hidden" name="user_id" value="<?php echo $user_id ?>" / >
								<input type="hidden" name="custom" value="add_credits" / >
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

				<!-- COUPON APPLY FORM -->
				<div class="jobright">
				<form method="post" name="publish" enctype="multipart/form-data" action="">
				<table width="100%" border="1">
				<tbody>
					<tr>
						<td>Base Fee</td>
						<td>&pound; <?php echo $base_fee; ?></td>
					</tr>
					<?php if($is_featured==1){ ?>
					<tr>
						<td>Feature Ad Charges</td>
						<td>&pound; <?php echo $featurefee; ?></td>
					</tr> 
					<?php } ?>
					<?php if($voucherFlag==1){ ?>
					<tr>
						<td>Discount</td>
						<td>&pound; <?php echo $voucherDiscount; ?></td>
					</tr> 
					<?php } ?>
					<tr>
						<td>Total</td>
						<td>&pound; <?php echo $totalfees; ?></td>
					</tr> 
				</tbody>
				</table>
				
				<div class="stj_payment">
                  	<!-- <p>* Get discounts on posting fees. <a href="#" data-toggle="modal" data-target="#postingFees">Click Here</a> to know how</p> -->
                  	<ul>
                  		<li>
							<input type="text" class="txt_pymnt" placeholder="Enter Voucher Code" name="voucher_code" />
							<input type="submit" class="btn_pymnt" name="voucher_code_submit" value="Apply Code" />
							<?php echo $voucherCodeErrMsg;?>
                  		</li>
                  	</ul>
				</div>
				
				</form>
				
				<!-- BUY CREDIT FORM -->
				
					<div class="stj_payment">
						<ul>
							<li>
								<label>Your Total Credits:</label>
								<div class="price_pymnt">&pound; <?php echo $total_user_credit; ?>
									<a href="#" data-toggle="modal" data-target="#addCredites">Add Credit</a>
								</div>
							</li>
							<!-- <li class="btn_li">
								<input type="submit" name="submit" class="btn_pymnt" value="Pay by Paypal" />
								<input type="submit" name="submit" class="btn_pymnt" value="Pay by Credit" />
							</li> -->
						</ul>
					</div>
				</form>
				
				<!-- PAY BUTTOM FORM -->
				<div class="paypal_btn">
					<?php
						$userDetailsSql = "SELECT firstname, lastname FROM tbluser WHERE user_id=".$user_id."";
						$userDetails = mysql_query($userDetailsSql);
						$userDetailsArr = mysql_fetch_array($userDetails);
						$firstName = $userDetailsArr['firstname'];
						$lastName = $userDetailsArr['lastname'];
					?>
					<!-- Pay with PayPal Button -->
					<form action="paypal/payments.php" method="post" id="paypal_form">
						<input type="hidden" name="cmd" value="_xclick" />
						<input type="hidden" name="no_note" value="1" />
						<input type="hidden" name="lc" value="UK" />
						<input type="hidden" name="currency_code" value="GBP" />
						<input type='hidden' name='rm' value='2'>
						<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
						<input type="hidden" name="first_name" value="<?php echo $firstName; ?>"  />
						<input type="hidden" name="last_name" value="<?php echo $lastName; ?>"  />
						<input type="hidden" name="item_number" value="<?php echo $_SESSION['last_id']; ?>" />
						<input type="hidden" name="amount" value="<?php echo $totalfees; ?>"  />
						<input type="hidden" name="item_name" value="<?php echo $job_title; ?>" />
						<input type="hidden" name="user_id" value="<?php echo $user_id ?>" />
						<input type="hidden" name="custom" value="pay_with_paypal" />
						<input type="submit" name="paypal" class="paypal_btn_pymnt" value="Pay with PayPal"/>
					</form>
					
					<!-- Pay with Credit Button -->
					<form action="" method="post" id="paypal_form">
						<input type="button" name="submitcredit" class="paypal_btn_pymnt" value="Pay with Credits" data-toggle="modal" data-target="#addCredites"/>
					</form>
				</div>

				</div>
				</div>					
				</div>
			</div>
		</div>
	</div>
</div>
 
<?php include "footer.php"; ?>
</body>
</html>