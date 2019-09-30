<?php

ini_set('display_errors',1);
include "../config.php"; 
/*
 * Copyright 2011 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
require_once 'src/apiClient.php';
require_once 'src/contrib/apiOauth2Service.php';
session_start();

$client = new apiClient();
$client->setApplicationName("Google Account Login");
// Visit https://code.google.com/apis/console?api=plus to generate your
// oauth2_client_id, oauth2_client_secret, and to register your oauth2_redirect_uri.
// $client->setClientId('insert_your_oauth2_client_id');
// $client->setClientSecret('insert_your_oauth2_client_secret');
// $client->setRedirectUri('insert_your_redirect_uri');
// $client->setDeveloperKey('insert_your_developer_key');
$oauth2 = new apiOauth2Service($client);

if (isset($_GET['code'])) {
	//echo '111';
	//exit;
  $client->authenticate();
  $_SESSION['token'] = $client->getAccessToken();
  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['token'])) {
	//echo '111';
	//exit;
 $client->setAccessToken($_SESSION['token']);
}

if (isset($_REQUEST['logout'])) {
  unset($_SESSION['token']);
  unset($_SESSION['google_data']); //Google session data unset
  $client->revokeToken();
}

if ($client->getAccessToken()) {
	//echo '111';
	//exit;
  $user = $oauth2->userinfo->get();
  
  $googlelogin=$db->Query("select user_id,email,firstname,lastname,profile_image,status,customer_type from tbluser where googleID='".$user['id']."' and email='".$user['email']."' and status=1");
	$noofrows=mysql_num_rows($googlelogin);
	
	    $gender=0;
		if($user['gender']=='male')
		{
			$gender=1;
		}
		if($user['gender']=='female')
		{
			$gender=2;
		}
  if($noofrows > 0)
	{
		
		$sql=$db->Query("Update tbluser SET email='".$user['email']."',
		firstname='".$user['given_name']."',lastname='".$user['family_name']."',modified_date='".date('Y-m-d h:i:s')."',customer_type=2,gender=".$gender.",password='',phone='',address_1='',address_2='',profile_image='',status=1,isSocial=2,last_login='".date("Y-m-d h:i:s")."' where googleID='".$user['id']."'");
		
		list($user_id,$useremail,$firstname,$lastname,$profile_image,$status,$customer_type)=mysql_fetch_row($googlelogin); 
		$_SESSION['user_id']=$user_id;
		$_SESSION['user_email']=$useremail;
		$_SESSION['fname']=$firstname;
		$_SESSION['lname']=$lastname;
		$_SESSION['pimage']=$profile_image;
		$_SESSION['customer_type']=$customer_type;
		
		$_SESSION['mt'] = "success";
		$_SESSION['me'] = "Login successfully.";
		//echo '2626';
		//exit();
		//echo '<pre>'; print_r($_SESSION);
		//echo SITE_URL;
		//exit;
		header("location:".SITE_URL."individual-profile.php");
		exit();
		
	}
	else
	{
		//echo '456';
		//exit;
		
		
		$sql=$db->Query("Insert tbluser SET email='".$user['email']."',
		firstname='".$user['given_name']."',lastname='".$user['family_name']."',created_date='".date('Y-m-d h:i:s')."',customer_type=2,gender=".$gender.",password='',phone='',address_1='',address_2='',profile_image='',status=1,googleID='".$user['id']."',isSocial=2,last_login='".date("Y-m-d h:i:s")."'");
		$last_insert_id=$db->LastInsert('tbluser');
		$_SESSION['user_id']=$last_insert_id;
		$_SESSION['user_email']=$user['email'];
		$_SESSION['fname']=$user['given_name'];
		$_SESSION['lname']=$user['family_name'];
		//$_SESSION['pimage']=$profile_image;
		$_SESSION['customer_type']=2;
		header("location:".SITE_URL."individual-profile.php");
		exit();
	}
  $_SESSION['token'] = $client->getAccessToken();
} else {
  $authUrl = $client->createAuthUrl();
}
?>
