<?php 
include "config.php";


$home_name='';
if(isset($_SESSION['home_name']) && $_SESSION['home_name']!='')
{
	$home_name=$_SESSION['home_name'];
}

if(isset($_POST['register']) && !empty($_POST))
{
//$_SESSION['user_details']=$_POST;
$_SESSION['user_details']['customer_email']=$_POST['customer_email'];
$_SESSION['user_details']['cust_password']=$_POST['cust_password'];
$_SESSION['user_details']['customer_type']=$_POST['customer_type'];
$_SESSION['user_details']['company_name']=$_POST['company_name'];
}
$title='Company Details';
if(isset($_SESSION['user_details']) && $_SESSION['user_details']['customer_type']==1)
{
	$title='Company Details';
}
if(isset($_SESSION['user_details']) && $_SESSION['user_details']['customer_type']==2)
{
	$title='User Details';
}
//echo '<pre>'; print_r($_SESSION['user_details']);
//	exit;
if(isset($_POST['registerbtn']))
{
	$c_name=isset($_REQUEST["c_name"])?stripslashes($_REQUEST["c_name"]):"";
	$first_name=isset($_REQUEST["first_name"])?stripslashes($_REQUEST["first_name"]):"";
	$last_name=isset($_REQUEST["last_name"])?stripslashes($_REQUEST["last_name"]):"";
	$address_1=isset($_REQUEST["address_1"])?stripslashes($_REQUEST["address_1"]):"";
	$address_2=isset($_REQUEST["address_2"])?stripslashes($_REQUEST["address_2"]):"";
	$town_city=isset($_REQUEST["town_city"])?stripslashes($_REQUEST["town_city"]):"";
	$postal_code=isset($_REQUEST["postal_code"])?stripslashes($_REQUEST["postal_code"]):"";
	$registration_no=isset($_REQUEST["registration_no"])?stripslashes($_REQUEST["registration_no"]):"";
	$vat_registration_no=isset($_REQUEST["vat_registration_no"])?stripslashes($_REQUEST["vat_registration_no"]):"";
	$bank_name=isset($_REQUEST["bank_name"])?stripslashes($_REQUEST["bank_name"]):"";
	$acc_holder_name=isset($_REQUEST["acc_holder_name"])?stripslashes($_REQUEST["acc_holder_name"]):"";
	$sort_code=isset($_REQUEST["sort_code"])?stripslashes($_REQUEST["sort_code"]):"";
	$acc_number=isset($_REQUEST["acc_number"])?stripslashes($_REQUEST["acc_number"]):"";
	$phone=isset($_REQUEST["phone"])?stripslashes($_REQUEST["phone"]):"";

	$state_id=isset($_REQUEST["state_id"])?stripslashes($_REQUEST["state_id"]):"";
	$city_id=isset($_REQUEST["city_id"])?stripslashes($_REQUEST["city_id"]):"";
	
	$address='';
	if($address_1!='')
	{
		$address .=$address_1;
	}
	if($address_2!='')
	{
		$address .=$address_2;
	}
	
	  if($address_1!='') {
	    $latlong    =   get_lat_long($address_1);
		$map        =   explode(',' ,$latlong);
		$mapLat     =   $map[0];
		$mapLong    =   $map[1];
	  } else {
	    $latlong    =   get_lat_long($postal_code);
		$map        =   explode(',' ,$latlong);
		$mapLat     =   $map[0];
		$mapLong    =   $map[1];
	  }
	
	
	/* Check if Referral Code already Exist */
	/* if Yes, will create a new one. */
	function checkReferralCode(){
		$referralCodeValue = getReferralCode(7);
		$check_sql = mysql_query("SELECT referralCode FROM tbluser WHERE referralCode='$referralCodeValue'");
		$num_rows = mysql_num_rows($check_sql);
		if($num_rows > 1){
			checkReferralCode();
		}else{
			return $referralCodeValue;
		}
	}

	$referralCodeValue = checkReferralCode();

	$sql=mysql_query("Insert into tbluser SET email='".$_SESSION['user_details']['customer_email']."',password='".md5($_SESSION['user_details']['cust_password'])."',firstname='".$first_name."',lastname='".$last_name."',address_1='".$address_1."',address_2='".$address_2."',state_id = '".$state_id."', city_id = '".$city_id."',postal_code='".$postal_code."',created_date='".date("Y-m-d h:i:s")."',customer_type='".$_SESSION['user_details']['customer_type']."',bank_name='".$bank_name."',acc_holder_name='".$acc_holder_name."',sort_code='".$sort_code."',acc_number='".$acc_number."',reg_no='".$registration_no."',reg_vat_no='".$vat_registration_no."',company_name='".$c_name."',status=1,phone='".$phone."',profile_image='',latitude='".$mapLat."',longitude='".$mapLong."',last_login='".date("Y-m-d h:i:s")."',referralCode='".$referralCodeValue."'");
	$last_insert_id=mysql_insert_id();
	/* Mail when new user created*/
	new_user_registration($last_insert_id,$_SESSION['user_details']['cust_password']); 
	
	    $_SESSION['user_id']=$last_insert_id;
		$_SESSION['user_email']=$_SESSION['user_details']['customer_email'];
		$_SESSION['fname']=$firstname;
		$_SESSION['lname']=$lastname;
		$_SESSION['customer_type']=$_SESSION['user_details']['customer_type'];
	      
		  if(isset($_SESSION['home_jobtype']) && $_SESSION['home_jobtype']==1)
		  {
			 header("Location:profile-edit.php");
             exit();			 
		  }else if(isset($_SESSION['home_jobtype']) && $_SESSION['home_jobtype']==2)
		  {
			 header("Location:profile-edit.php");
             exit();			 
		  }else {
		    header("Location:profile-edit.php");
             exit();
		  }
}
?>
<script>
	getCities(<?php echo $state_id; ?>);
  	function getCities(val) {
		$.ajax({
			type: "POST",
			url: "<?php echo ADMIN_URL ?>phpajax/get_city.php",
			data:'state_id='+val+'&city_id=<?php echo $city_id; ?>',
			beforeSend: function()
			{
				$('#preloader').show();
			},
			success: function(data){
				$('#preloader').hide();
				$("#city_id").html(data);	
			}
		});
	}
</script>
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
<title>Register - SECURE THAT JOB</title>

<!-- Bootstrap -->
<link href="https://fonts.googleapis.com/css?family=Fira+Sans:300,400,400i,500,600,700,800" rel="stylesheet"> 
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link href="css/ddsmoothmenu.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">
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
</head>
<body>
<div id="preloader" style="display:none"></div>
<?php include "header-inner.php"; ?>
<div class="stj_login_wrap stj_reg_wrap">
	<div class="container">
		<div class="row">
			<div class="reg_dv">
				<h2>Register with Us</h2>
				<div class="reg_cd">
				     
					<h3><?php echo $title; ?></h3>
					<div class="reg_ul">
					<form method="post" name="register" action="" class="validateForm"> <!-- class="validateForm" -->
					 <ul>
					     <?php 
						 if(isset($_SESSION['user_details']) && $_SESSION['user_details']['customer_type']==1)
                            { 
						?>

						<!-- Company Name (Business) -->
						<li>
							<label>Company Name <em>*</em></label>
							<input type="text" maxlength="200" name="c_name" required value="<?php echo $_SESSION['user_details']['company_name'] ?>" class="txt_lg" />
						</li>
						
						<?php } ?>
						<li>
							<label>First Name <em>*</em></label>
							<input type="text" maxlength="100" name="first_name" value="<?php echo $home_name; ?>" required class="txt_lg" />
						</li>
						<li>
							<label>Last Name <em>*</em></label>
							<input type="text" maxlength="100" name="last_name" required class="txt_lg" />
						</li>
						<li>
							<label>Address Line 1 <em>*</em></label>
							<input type="text" id="autocomplete" maxlength="200" name="address_1" value="" required class="txt_lg" />
						</li>
						<li>
							<label>Address Line 2</label>
							<input type="text" maxlength="200" name="address_2" value="" class="txt_lg" />
						</li>

						<!-- Country -->
						<li>
							<label>County<em>*</em></label>
							<select name="state_id" id="state_id" required onchange="getCities(this.value)" class="txt_lg">
							<option value="">Select County</option>
							<?php 
								$select_query = mysql_query("SELECT * FROM tblstates ORDER BY name ASC");
								while($row = mysql_fetch_assoc($select_query)) {
								$selected='';
								if($state_id==$row['id'])
								{
									$selected='selected';
								}
							?>
								<option value="<?php echo $row['id'] ?>" <?php echo $selected; ?>><?php echo $row['name']; ?></option>
							<?php } ?>
							</select>
						</li>

						<!-- Town City -->
						<li>
								<label>Town / City <em>*</em></label>
								<select id="city_id" name="city_id" required class="txt_lg">
									<option value="">Select City</option>
								</select>
						</li>
						
						<!-- Postcode -->
						<li>
							<label>Postcode <em>*</em></label>
							<input type="text" maxlength="200" name="postal_code" required value="" class="txt_lg" />
						</li>
						
						<!-- Mobile Number (Personal) -->
						<?php 
						 if(isset($_SESSION['user_details']) && $_SESSION['user_details']['customer_type']==2)
                            { 
						?>
						<li>
							<label>Mobile No <em>*</em></label>
							<input type="text" maxlength="12" name="phone" required value="" class="txt_lg" />
						</li>
						<?php } ?>
						
						<?php 
						 if(isset($_SESSION['user_details']) && $_SESSION['user_details']['customer_type']==1)
                            { 
						?>
						
						<!-- Mobile Number (Business) -->
						<li>
							<label>Mobile No <em>*</em></label>
							<input type="text" maxlength="12" name="phone" required value="" class="txt_lg" />
						</li>
						
						<!-- Registration Number (Business) -->
						<li>
							<label>Registration No. <em>*</em></label>
							<input type="text" maxlength="200" name="registration_no" required value="" class="txt_lg" />
						</li>

						<?php } ?>

						<!-- VAT Registration (Business) -->
						<?php 
						 if(isset($_SESSION['user_details']) && $_SESSION['user_details']['customer_type']==1)
                            { 
						?>
						<li>
							<label>VAT Registration No. <em>*</em></label>
							<input type="text" maxlength="200" name="vat_registration_no" required value="" class="txt_lg" />
						</li>
					   <?php } ?>


					   <li>
							<label>&nbsp;</label>
					 		<div class="tk">
							 <label for="terms-personal"><input type="checkbox" required name="terms-personal" id="terms-personal" value="1" data-toggle="modal" data-target="#acceptTerms">Do you agree all information is true and accurate? </label>
					 			<label for="ckbox"><input id="ckbox" type="checkbox" required name="terms"  id="terms" value="1">By creating an account, you agree to Secure That Job <a href="#" data-toggle="modal" data-target="#postingFees">Terms of Conditions</a> and <a href="#" data-toggle="modal" data-target="#privacy" style="margin-left:23px;">Privacy Policy</a></label>
					 		</div>
						</li>
					   	<li class="btn_li">
							<input type="submit" name="registerbtn" value="Register" class="btn_lg"/>
						</li>
						
					   
					 </ul>
					 
				    </div>
				</div>
			</div>
			
		</div>
	</div>
</div>
<?php
/* Queries for Modal for terms and policy */
$sqlTerms='select title,content from tblcmspages where page_id=10';
$resTerms = mysql_query($sqlTerms);
$fetchTerms = mysql_fetch_array($resTerms);
$contentTerms = $fetchTerms['content'];
$descTerms = $contentTerms;

$sqlPrivacy = 'select title,content from tblcmspages where page_id=9';
$resPrivacy = mysql_query($sqlPrivacy);
$fetchPrivacy = mysql_fetch_array($resPrivacy);
$contentPrivacy = $fetchPrivacy['content'];
$descPrivacy = $contentPrivacy;
?>

<!-- Modal for terms of conditions -->
<div class="modal fade" id="postingFees">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
		
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title"><center>Terms & Conditions</center></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			
			<!-- Modal body -->
			<div class="modal-body">
				<center><?php echo $descTerms; ?></center>
			</div>
			
			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" class="btn fees-modal-button" data-dismiss="modal">Close</button>
			</div>
			
		</div>
	</div>
</div>

<!-- Modal for terms of conditions -->
<div class="modal fade" id="acceptTerms">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
		
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title"><center>Terms & Conditions</center></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			
			<!-- Modal body -->
			<div class="modal-body">
				<center><?php echo $descTerms; ?></center>
			</div>
			
			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" class="btn fees-modal-button" id="acceptT" data-dismiss="modal">Accept</button>
			</div>
			
		</div>
	</div>
</div>

<!-- Modal for terms of privacy policy -->
<div class="modal fade" id="privacy">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
		
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title"><center>Privacy Policy</center></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			
			<!-- Modal body -->
			<div class="modal-body">
				<center><?php echo $descPrivacy; ?></center>
			</div>
			
			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" class="btn fees-modal-button" data-dismiss="modal">Close</button>
			</div>
			
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
    $("#acceptT").click(function(){
        $("#terms-personal").prop("checked",true);
	});
	
	$("#terms-personal").click(function(){
        $("#terms-personal").prop("checked",false);
    });
});
</script>

<script>
      // This example displays an address form, using the autocomplete feature
      // of the Google Places API to help users fill in the information.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      var placeSearch, autocomplete;
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };

      function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});
        autocomplete.setComponentRestrictions(
            {'country': ['UK', 'pr', 'vi', 'gu', 'mp']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
      }

      function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
          document.getElementById(component).value = '';
          document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
          }
        }
      }

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
    </script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_JUu2G9vlijX1UgNTylx55U1hZQqw6QI&libraries=places&callback=initAutocomplete"
async defer></script>
<?php include "footer.php"; ?>
<?php include('admin/inc/validation.php'); ?>
</body>
</html>