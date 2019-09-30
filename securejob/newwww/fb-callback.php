<?php
include "config.php";
require_once __DIR__ . '/Facebook/autoload.php';
$fb = new Facebook\Facebook([
  'app_id' => '1942237112681660', // Replace {app-id} with your app id
  'app_secret' => 'bf11baba5e512db8540684f8d889b2a4',
  'default_graph_version' => 'v2.4',
  ]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; // Optional permissions
$fburl=SITE_URL.'fb-callback.php';
try {
	if (isset($_SESSION['facebook_access_token'])) {
		$accessToken = $_SESSION['facebook_access_token'];
	} else {
  		$accessToken = $helper->getAccessToken();
	}
} catch(Facebook\Exceptions\FacebookResponseException $e) {
 	// When Graph returns an error
 	echo 'Graph returned an error: ' . $e->getMessage();

  	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
 	// When validation fails or other local issues
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
  	exit;
 }
 
 if (isset($accessToken)) {
	if (isset($_SESSION['facebook_access_token'])) {
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	} else {
		// getting short-lived access token
		$_SESSION['facebook_access_token'] = (string) $accessToken;

	  	// OAuth 2.0 client handler
		$oAuth2Client = $fb->getOAuth2Client();

		// Exchanges a short-lived access token for a long-lived one
		$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);

		$_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;

		// setting default access token to be used in script
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	}

	// redirect the user back to the same page if it has "code" GET variable
	if (isset($_GET['code'])) {
		header('Location: fb-callback.php');
	}

	// getting basic info about user
	try {
		$profile_request = $fb->get('/me?fields=name,first_name,last_name,email,gender,cover,age_range,picture,timezone');
		$profile = $profile_request->getGraphNode()->asArray();
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		// When Graph returns an error
		echo 'Graph returned an error: ' . $e->getMessage();
		session_destroy();
		// redirecting user back to app login page
		//exit;
		header("Location: login.php");
		
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		// When validation fails or other local issues
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}
	//print_r($profile);
	
	function checkReferralCode(){
		$referralCodeValue = getReferralCode(7);
		$check_sql = mysql_query("SELECT referralCode FROM tbluser WHERE referralCode=$referralCodeValue");
		$num_rows = mysql_num_rows($check_sql);
		if($num_rows > 1){
			checkReferralCode();
		}else{
			return $referralCodeValue;
		}
	}

	$referralCodeValue = checkReferralCode();

	$fbsql=$db->Query("select user_id,email,firstname,lastname,profile_image,status,customer_type from tbluser where facebookID='".$profile['id']."' and email='".$profile['email']."' and status=1");
	$noofrows=mysql_num_rows($fbsql);
	//echo $noofrows;
	//exit;
	    $gender=0;
		if($profile['gender']==1)
		{
			$gender=1;
		}
		if($profile['gender']==1)
		{
			$gender=2;
		}
	
	if($noofrows > 0)
	{
		//echo '111';
		//exit;
		$sql=$db->Query("Update tbluser SET email='".$profile['email']."',
		firstname='".$profile['first_name']."',lastname='".$profile['last_name']."',created_date='".date('Y-m-d h:i:s')."',customer_type=2,gender=".$gender.",password='',phone='',address_1='',address_2='',profile_image='',status=1,isSocial=1,last_login='".date("Y-m-d h:i:s")."' where facebookID='".$profile['id']."'");
		
		list($user_id,$useremail,$firstname,$lastname,$profile_image,$status,$customer_type)=mysql_fetch_row($fbsql);
		$_SESSION['user_id']=$user_id;
		$_SESSION['user_email']=$useremail;
		$_SESSION['fname']=$firstname;
		$_SESSION['lname']=$lastname;
		$_SESSION['pimage']=$profile_image;
		$_SESSION['customer_type']=$customer_type;
		
		$_SESSION['mt'] = "success";
		$_SESSION['me'] = "Login successfully.";
		header("location:individual-profile.php");
		exit();
		
	}
	else
	{
		//echo '456';
		//exit;
		
		
		$sql=$db->Query("Insert tbluser SET email='".$profile['email']."',
		firstname='".$profile['first_name']."',lastname='".$profile['last_name']."',created_date='".date('Y-m-d h:i:s')."',customer_type=2,gender=".$gender.",password='',phone='',address_1='',address_2='',profile_image='',status=1,facebookID='".$profile['id']."',isSocial=1,last_login='".date("Y-m-d h:i:s")."',referralCode='".$referralCodeValue."'");
		$last_insert_id=$db->LastInsert('tbluser');
		$_SESSION['user_id']=$last_insert_id;
		$_SESSION['user_email']=$profile['email'];
		$_SESSION['fname']=$profile['first_name'];
		$_SESSION['lname']=$profile['last_name'];
		//$_SESSION['pimage']=$profile_image;
		$_SESSION['customer_type']=2;
		header("location:individual-profile.php");
		exit();
	}
	
	
	// printing $profile array on the screen which holds the basic info about user
	

  	// Now you can redirect to another page and use the access token from $_SESSION['facebook_access_token']
} else {
	// replace your website URL same as added in the developers.facebook.com/apps e.g. if you used http instead of https and you used non-www version or www version of your website then you must add the same here
	$loginUrl = $helper->getLoginUrl($fburl, $permissions);
	//echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
	header("Location: login.php");
}

?>