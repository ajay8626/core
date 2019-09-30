<?php 
include "config.php";
require_once __DIR__ .'/googlelogin/google_login.php';
require_once __DIR__ . '/Facebook/autoload.php';
$fb = new Facebook\Facebook([
  'app_id' => '470658440154198', // Replace {app-id} with your app id
  'app_secret' => 'b103c260a4cadb3b1657d1a563716bfc',
  'default_graph_version' => 'v2.4',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$fburl=SITE_URL.'fb-callback.php';

$loginUrl = $helper->getLoginUrl($fburl, $permissions);

$googleloginurl=SITE_URL.'googlelogin/google_login.php';
if(isset($authUrl)) {
$googleloginurl=$authUrl;
}

$home_email='';
if(isset($_SESSION['home_email']) && $_SESSION['home_email']!='')
{
	$home_email=$_SESSION['home_email'];
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
<title>Login - SECURE THAT JOB</title>

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
<script>
jQuery(document).ready(function($) {	
$('.rd_lb input:radio').click(function() {
    $('.rd_lb input:radio[name='+$(this).attr('name')+']').parent().removeClass('active');
        $(this).parent().addClass('active');
});
$('#business_user').click(function() {
$('#comp_div').show();
});	
$('#personal_user').click(function() {
$('#comp_div').hide();
});	
});

function validate()
{
	//alert("hello");
	if(($('#customer_type').val()==1) && ($('#company_name').val()=='')) 
	{
	  alert("Please enter company name");
	  $('#company_name').focus();
	  return false;
	}
	
	var vals=$('#customer_email').val();
	if(vals!='')
	{
		get_check(vals);
		//alert(get_check(vals));
		//return false; 
	}
}

function get_check(vals)
{
	var vals = $('#customer_email').val();
	if(vals!='')
	{
		$.post("check_email.php",{
			emailaddress:vals
		},
		function(result)
		{
			if(result!=0)
			{
				$('.danger').remove();
				$('#customer_email').after('<span class="danger loginError">This email address already exists, please log in with your credentials. Or <a class="a_fp" href="forgot.php"><u>click here</u></a> if you have forgotten your password</span>');
				$('#sub_regs').attr("disabled",true);
				return false;
			}
			else
			{
				$('.danger').remove();
				$('#sub_regs').attr("disabled",false);
			}
		});
	}
	/* event.preventDefault(); */
}


</script>
</head>
<?php
if (isset($_GET['post_new_job']) || $_GET['post_new_job']== 1) {
	$post_new_job = 1;
}else{
	$post_new_job = 0;
}
?>
<body class="">
<?php include "header-inner.php"; ?>
<div class="stj_login_wrap">
	<div class="container">
		<div class="row">
			 
			<div class="login_dv">
				<div class="lg_dv_lft">
				<?php echo getMsg(); ?>
					<h2>Login</h2>
					<ul>
					   <form method="post" name="login_form" action="check_login.php">
					   	<input type="hidden" name="post_new_job" value="<?php echo $post_new_job; ?>">
						<li>
							<label>Email Address <em>*</em></label>
							<input type="email" name="emailaddress" required value="" class="txt_lg" />
						</li>
						<li>
							<label>Password <em>*</em></label>
							<input type="password" name="password" required value="" class="txt_lg" />
						</li>
						<li class="keep-me-logged">
							<div class="tk">
								<label for="keep_me_logged"><input type="checkbox" name="keep_me_logged" id="keep_me_logged" value="1" data-toggle="modal" data-target="#postingFees">Keep me logged in </label>
							</div>
						</li>
						<li>
							<a class="a_fp" href="forgot.php">Forgot Password?</a>
							<input type="submit" value="Login" class="btn_lg"/>
						</li>
						</form>
					</ul>
					<div class="lg_social">
						<a class="lg_fb" href="<?php echo $loginUrl; ?>"><img src="images/fb.png" alt=""/>Sign in with Facebook</a>
						<a class="lg_g" href="<?php echo $googleloginurl; ?>"><img src="images/g.png" alt=""/>Sign in with Google</a>
					</div>
				</div>
				
				<div class="lg_dv_rgt">
					<h2>Register</h2>
					<form method="post" name="register" onsubmit="return validate()" action="register.php">
					<ul>
						<li>
							<span class="iaa">I am a</span>
							<!--<label class="rd_lb active"><input type="radio" name="customer_type" class="rd_chk" checked="checked" id="business_user" value="1" />Business User</label>
							<label class="rd_lb"><input type="radio" name="customer_type" class="rd_chk" id="personal_user" value="2" />Personal User</label>-->
							<input type="hidden" name="customer_type" id="customer_type" value="2">
							<div class="job-type-button job-type-button-registration"><button type="button" name="customer_types" value="2" class="btn job-type-job active" id="personal_user">Personal User</button></div>
							<div class="job-type-button job-type-button-registration"><button type="button" name="customer_types" value="1" class="btn job-type-security" id="business_user">Business User</button></div>
						</li>
						<li id="comp_div" style="display:none">
							<label>Company Name <em>*</em></label>
							<input type="text"  name="company_name" id="company_name" maxlength="100" value="" class="txt_lg" />
						</li>
						<li>
							<label>Email Address <em>*</em></label>
							<input type="text" required name="customer_email" id="customer_email" maxlength="100" class="txt_lg" value="<?php echo $home_email; ?>" />
						</li>
						<li>
							<label>Create Password <em>*</em></label>
							<input type="password" required name="cust_password" onfocus="return get_check()" maxlength="100" class="txt_lg" />
						</li>
						<li>
							<input type="submit" name="register" value="Next" id="sub_regs" class="btn_lg"/>
						</li>
					</ul>
					</form>
				</div>
			</div>
			
		</div>
	</div>
</div>
 
<?php include "footer.php"; ?>
<script>
	$(".job-type-button").on('click', '#personal_user', function () {
		$("#customer_type").val('2');
    	$("button.job-type-job").addClass('active');
		$("button.job-type-security").removeClass('active');
	});

	$(".job-type-button").on('click', '#business_user', function () {
		$("#customer_type").val('1');
    	$("button.job-type-security").addClass('active');
		$("button.job-type-job").removeClass('active');
	});
</script>
</body>
</html>