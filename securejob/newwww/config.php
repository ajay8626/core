<?php
//ini_set('display_errors',1);
error_reporting(0);
//setlocale(LC_MONETARY,"de_DE");
ob_start();
session_start();


//date_default_timezone_set('utc');
//ini_set('date.timezone', 'UTC');

define("CHINA_DATE_FORMAT","Y-m-d");

define("SITE_URL","http://".$_SERVER['SERVER_NAME']."/securethatjob/");
define("ADMIN_URL","http://".$_SERVER['SERVER_NAME']."/securethatjob/admin/");

define("SITE_URL_SHARE",SITE_URL."share/");

define("SITE_PATH",$_SERVER['DOCUMENT_ROOT']."/",true);
define("ADMIN_PATH",$_SERVER['DOCUMENT_ROOT']."/securethatjob/admin/",true);

define("CUSTOMER_PROFILE_IMG_URL","http://".$_SERVER['SERVER_NAME']."/securethatjob/admin/user/profilepictures/",true);
define("CUSTOMER_PROFILE_IMG_PATH",$_SERVER['DOCUMENT_ROOT']."/securethatjob/admin/user/profilepictures/",true);

define("CUSTOMER_CERTIFICATE_IMG_URL","http://".$_SERVER['SERVER_NAME']."/securethatjob/admin/user/certificate/",true);
define("CUSTOMER_CERTIFICATE_IMG_PATH",$_SERVER['DOCUMENT_ROOT']."/securethatjob/admin/user/certificate/",true);

define("CUSTOMER_PROFILE_VIDEO_URL","http://".$_SERVER['SERVER_NAME']."/securethatjob/admin/user/profilevideos/",true);
define("CUSTOMER_PROFILE_VIDEO_PATH",$_SERVER['DOCUMENT_ROOT']."/securethatjob/admin/user/profilevideos/",true);

define("JOBS_IMG_URL","http://".$_SERVER['SERVER_NAME']."/securethatjob/admin/jobs/jobsimages/",true);
define("JOBS_IMG_PATH",$_SERVER['DOCUMENT_ROOT']."/securethatjob/admin/jobs/jobsimages/",true);
 
define("COURSE_IMG_URL","http://".$_SERVER['SERVER_NAME']."/securethatjob/admin/course/courseimages/",true);
define("COURSE_IMG_PATH",$_SERVER['DOCUMENT_ROOT']."/securethatjob/admin/course/courseimages/",true);

define("ADVERT_IMG_URL","http://".$_SERVER['SERVER_NAME']."/securethatjob/admin/advert/advertimages/",true);
define("ADVERT_IMG_PATH",$_SERVER['DOCUMENT_ROOT']."/securethatjob/admin/advert/advertimages/",true);

define("CATEGORY_IMG_URL","http://".$_SERVER['SERVER_NAME']."/securethatjob/admin/category/categoryimages/",true);
define("CATEGORY_IMG_PATH",$_SERVER['DOCUMENT_ROOT']."/securethatjob/admin/category/categoryimages/",true);



define("SERVICES_IMG_URL","http://".$_SERVER['SERVER_NAME']."/securethatjob/admin/services/servicesimages/",true);
define("SERVICES_IMG_PATH",$_SERVER['DOCUMENT_ROOT']."/securethatjob/admin/services/servicesimages/",true);


define("BANNER_IMG_URL","http://".$_SERVER['SERVER_NAME']."/securethatjob/admin/settings/bannerimages/",true);
define("BANNER_IMG_PATH",$_SERVER['DOCUMENT_ROOT']."/securethatjob/admin/settings/bannerimages/",true);

define("_BADLOGIN","Invalid User Name or Password");

define("TIMTHUMB_URL",SITE_URL."timthumb.php");
define("TITLE","Secure That Job"); 
define("AdminEmail","maunik.abbacus@gmail.com");
define("SMTP_EMAIL","mark@webtechsystem.com");
define("SMTP_PASSWORD","Abbacus@098!");
define("SMTP_FROM_EMAIL","donot-reply@securethatjob.com");
define("SMTP_FROM_NAME","Secure That Job");
define("SMTP_HOST","smtp.gmail.com");
define("USERID","");
define("PWD","");
define("FOOTER_TEXT","&copy; Secure That Job");
define("HEADER_TEXT","Secure That Job");
define("ADMINID",1);
define("TITLE_EN","Secure That Job");
define("FaceBookAppID",1942237112681660);
define("FaceBookSecretKey",'bf11baba5e512db8540684f8d889b2a4');

$dbHost = "localhost"; 
$dbName = "securethatjob_db";
$dbUser = "root";
$dbPass = ""; 
require_once(ADMIN_PATH."inc/db.class.php");
$db = new Database();
//$languages="en,fr,de,pl,ro,es,lt,it,pt";
//$languages="en,fr,de,pl,ro,es,lt,it,pt";

$languages="en,fr,de,pl,es,it,el,tr,sq,af,ru";
$languagelist="select title_value from tblsystemconfiguration where title_key='languages'";
$qry=mysql_query($languagelist);
if(mysql_num_rows($qry)>0)
{
	$data = mysql_fetch_array($qry);
	$languages=$data['title_value'];
}
define("LanguageList",$languages);

require_once(ADMIN_PATH."inc/functions.php");
require_once(ADMIN_PATH."inc/img_upload.php");
require_once(ADMIN_PATH."inc/mail_functions.php");
require_once(ADMIN_PATH."inc/PHPMailerAutoload.php");
require_once(ADMIN_PATH."class/notification.php");

?>