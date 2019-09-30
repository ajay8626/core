<?php 
ob_start();
error_reporting(1);
//ini_set('display_errors',1);
session_start();

//ini_set("upload_tmp_dir",$_SERVER['DOCUMENT_ROOT']."/securejob/wwwroot/admin/user/documents");

date_default_timezone_set('utc');
ini_set('date.timezone', 'UTC');

define("CHINA_DATE_FORMAT","Y-m-d");
 
define("SITE_URL","http://".$_SERVER['SERVER_NAME']."/securejob/");
define("ADMIN_URL","http://".$_SERVER['SERVER_NAME']."/securejob/admin/");

define("SITE_URL_SHARE",SITE_URL."share/");

define("SITE_PATH",$_SERVER['DOCUMENT_ROOT']."/securejob/",true);
define("ADMIN_PATH",$_SERVER['DOCUMENT_ROOT']."/securejob/admin/",true);

define("CUSTOMER_PROFILE_IMG_URL","http://".$_SERVER['SERVER_NAME']."/securejob/admin/user/profilepictures/",true);
define("CUSTOMER_PROFILE_IMG_PATH",$_SERVER['DOCUMENT_ROOT']."/securejob/admin/user/profilepictures/",true);

define("CUSTOMER_CERTIFICATE_IMG_URL","http://".$_SERVER['SERVER_NAME']."/securejob/admin/user/certificate/",true);
define("CUSTOMER_CERTIFICATE_IMG_PATH",$_SERVER['DOCUMENT_ROOT']."/securejob/admin/user/certificate/",true);

define("CUSTOMER_SIABADGE_IMG_URL","http://".$_SERVER['SERVER_NAME']."/securejob/admin/user/siabadge/",true);
define("CUSTOMER_SIABADGE_IMG_PATH",$_SERVER['DOCUMENT_ROOT']."/securejob/admin/user/siabadge/",true);

define("CUSTOMER_LICENSEPASSPORT_IMG_URL","http://".$_SERVER['SERVER_NAME']."/securejob/admin/user/documents/",true);
define("CUSTOMER_LICENSEPASSPORT_IMG_PATH",$_SERVER['DOCUMENT_ROOT']."/securejob/admin/user/documents/",true);

define("CUSTOMER_UTILITY_IMG_URL","http://".$_SERVER['SERVER_NAME']."/securejob/admin/user/utility/",true);
define("CUSTOMER_UTILITY_IMG_PATH",$_SERVER['DOCUMENT_ROOT']."/securejob/admin/user/utility/",true);

define("CUSTOMER_COMPANYCERTI_IMG_URL","http://".$_SERVER['SERVER_NAME']."/securejob/admin/user/company_certificates/",true);
define("CUSTOMER_COMPANYCERTI_IMG_PATH",$_SERVER['DOCUMENT_ROOT']."/securejob/admin/user/company_certificates/",true);

define("CUSTOMER_PROFILE_VIDEO_URL","http://".$_SERVER['SERVER_NAME']."/securejob/admin/user/profilevideos/",true);
define("CUSTOMER_PROFILE_VIDEO_PATH",$_SERVER['DOCUMENT_ROOT']."/securejob/admin/user/profilevideos/",true);

define("JOBS_IMG_URL","http://".$_SERVER['SERVER_NAME']."/securejob/admin/jobs/jobsimages/",true);
define("JOBS_IMG_PATH",$_SERVER['DOCUMENT_ROOT']."/securejob/admin/jobs/jobsimages/",true);

define("COURSE_IMG_URL","http://".$_SERVER['SERVER_NAME']."/securejob/admin/course/courseimages/",true);
define("COURSE_IMG_PATH",$_SERVER['DOCUMENT_ROOT']."/securejob/admin/course/courseimages/",true);

define("ADVERT_IMG_URL","http://".$_SERVER['SERVER_NAME']."/securejob/admin/advert/advertimages/",true);
define("ADVERT_IMG_PATH",$_SERVER['DOCUMENT_ROOT']."/securejob/admin/advert/advertimages/",true); 

define("CATEGORY_IMG_URL","http://".$_SERVER['SERVER_NAME']."/securejob/admin/category/categoryimages/",true);
define("CATEGORY_IMG_PATH",$_SERVER['DOCUMENT_ROOT']."/securejob/admin/category/categoryimages/",true);

define("SERVICES_IMG_URL","http://".$_SERVER['SERVER_NAME']."/securejob/admin/services/servicesimages/",true);
define("SERVICES_IMG_PATH",$_SERVER['DOCUMENT_ROOT']."/securejob/admin/services/servicesimages/",true);


define("BANNER_IMG_URL","http://".$_SERVER['SERVER_NAME']."/securejob/admin/settings/bannerimages/",true);
define("BANNER_IMG_PATH",$_SERVER['DOCUMENT_ROOT']."/securejob/admin/settings/bannerimages/",true);

define("COURSE_NEWIMG_URL","http://".$_SERVER['SERVER_NAME']."/securejob/course/images/",true);
define("COURSE_NEWIMG_PATH",$_SERVER['DOCUMENT_ROOT']."/securejob/course/images/",true);

define("COURSE_CERTI_IMG_URL","http://".$_SERVER['SERVER_NAME']."/securejob/course/certificates/",true);
define("COURSE_CERTI_IMG_PATH",$_SERVER['DOCUMENT_ROOT']."/securejob/course/certificates/",true);

define("_BADLOGIN","Invalid User Name or Password");

define("TIMTHUMB_URL",SITE_URL."timthumb.php");
define("TITLE","Secure That Job"); 
define("AdminEmail","mike@gmail.com");
define("SMTP_EMAIL","smtp@on-linedemo.com");
define("SMTP_PASSWORD","Smtp!@98S@M@!");
define("SMTP_FROM_EMAIL","donot-reply@securethatjob.com");
define("SMTP_FROM_NAME","Secure That Job");
define("SMTP_HOST","mail.on-linedemo.com");
define("USERID","");
define("PWD","");
define("FOOTER_TEXT","&copy; Secure That Job");
define("HEADER_TEXT","Secure That Job");
define("ADMINID",1);
define("TITLE_EN","Secure That Job");
define("FaceBookAppID",1942237112681660);
define("FaceBookSecretKey",'bf11baba5e512db8540684f8d889b2a4');
$dbHost = "localhost"; 
$dbName = "securedb";
$dbUser = "root";
$dbPass = 'root'; 

//echo "<pre>";print_r(ADMIN_PATH);exit;

require_once(ADMIN_PATH."inc/db.class.php");
$db = new Database();
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
require_once(ADMIN_PATH."inc/mail_functions.php");
require_once(ADMIN_PATH."inc/img_upload.php");
require_once(ADMIN_PATH."inc/PHPMailerAutoload.php");
require_once(ADMIN_PATH."class/notification.php");

?>