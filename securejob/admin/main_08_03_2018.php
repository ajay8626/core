<?php
	session_start();
	require_once "../config.php";
	require_once "chkadminsess.php";	
	
	$pg=isset($_REQUEST['pg'])?$_REQUEST['pg']:"";

	$adminsessionstr = trim($_SESSION['adminsessionid']);
	
	$parts = explode(";",$adminsessionstr);
	
	$adminsessionstrid=$parts[0];
	$mfile = "";

	if(isset($_REQUEST['pg']) && $_REQUEST['pg']!=""){
	
		$pg=$_REQUEST['pg'];
		// Include Admin Module File
		if($pg == 'viewadmin'){
			$mfile = "admindata/viewadmin.php";
			$title = TITLE."&nbsp;-&nbsp;Admin Management";
		}
		elseif($pg == 'addadmin'){
			$mfile = "admindata/addadmin.php";
			$title = TITLE."&nbsp;-&nbsp;Add Admin";
		}
		elseif($pg == 'adminProc'){
			$mfile = "admindata/adminProc.php";
		}
		elseif($pg == 'admdel'){
			$mfile = "admindata/deladmin.php";
		}
		elseif($pg == 'modadmin'){
			$title = TITLE."&nbsp;-&nbsp;Modify  Admin";
			$mfile = "admindata/modadmin.php";
		}
		elseif($pg == 'logout'){
			$mfile = "logout.php";
			$title = TITLE."&nbsp;- &nbsp;Logout";		
		}
		
		
		// Include State Module File
		
		elseif($pg == 'viewstate'){
			$mfile = "location/state/viewstate.php";
			$title = TITLE."&nbsp;-&nbsp;State Management";
		}
		elseif($pg == 'addstate'){
			$mfile = "location/state/addstate.php";
			$title = TITLE."&nbsp;-&nbsp;Add State";
		}
		elseif($pg == 'stateproc'){
			$mfile = "location/state/stateProc.php";
		}
		elseif($pg == 'modstate'){
			$title = TITLE."&nbsp;-&nbsp;Modify State";
			$mfile = "location/state/modstate.php";
		}
		
		// Include City Module File
		
		elseif($pg == 'viewcity'){
			$mfile = "location/city/viewcity.php";
			$title = TITLE."&nbsp;-&nbsp;City Management";
		}
		elseif($pg == 'addcity'){
			$mfile = "location/city/addcity.php";
			$title = TITLE."&nbsp;-&nbsp;Add City";
		}
		elseif($pg == 'cityproc'){
			$mfile = "location/city/cityProc.php";
		}
		elseif($pg == 'modcity'){
			$title = TITLE."&nbsp;-&nbsp;Modify City";
			$mfile = "location/city/modcity.php";
		}
		
		// Include User Module File
		elseif($pg == 'viewuser'){
			$mfile = "user/view.php";
			$title = TITLE."&nbsp;-&nbsp;User Management";
		}
		elseif($pg == 'adduser'){
			$mfile = "user/add.php";
			$title = TITLE."&nbsp;-&nbsp;Add User";
		}
		elseif($pg == 'userproc'){
			$mfile = "user/proc.php";
		}
		elseif($pg == 'moduser'){
			$title = TITLE."&nbsp;-&nbsp;Modify User";
			$mfile = "user/mod.php";
		}
		
		
		// Include Job Module File
		elseif($pg == 'viewjobratings'){
			$mfile = "jobs/viewjobratings.php";
			$title = TITLE."&nbsp;-&nbsp;Job Ratings";
		}
		elseif($pg == 'viewjobbids'){
			$mfile = "jobs/viewjobbids.php";
			$title = TITLE."&nbsp;-&nbsp;Job Bids";
		}
		elseif($pg == 'viewjobs'){
			$mfile = "jobs/view.php";
			$title = TITLE."&nbsp;-&nbsp;Jobs Management";
		}
		elseif($pg == 'addjob'){
			$mfile = "jobs/add.php";
			$title = TITLE."&nbsp;-&nbsp;Add Job";
		}
		elseif($pg == 'jobproc'){
			$mfile = "jobs/proc.php";
		}
		elseif($pg == 'modjob'){
			$title = TITLE."&nbsp;-&nbsp;Modify Job";
			$mfile = "jobs/mod.php";
		}
		
		// Course
		elseif($pg == 'viewcourse'){
			$mfile = "course/view.php";
			$title = TITLE."&nbsp;-&nbsp;Course Management";
		}
		elseif($pg == 'addcourse'){
			$mfile = "course/add.php";
			$title = TITLE."&nbsp;-&nbsp;Add Course";
		}
		elseif($pg == 'courseproc'){
			$mfile = "course/proc.php";
		}
		elseif($pg == 'modcourse'){
			$title = TITLE."&nbsp;-&nbsp;Modify Course";
			$mfile = "course/mod.php";
		}
		
		// advert
		
		elseif($pg == 'viewadvert'){
			$mfile = "advert/view.php";
			$title = TITLE."&nbsp;-&nbsp;Advert Management";
		}
		elseif($pg == 'addadvert'){
			$mfile = "advert/add.php";
			$title = TITLE."&nbsp;-&nbsp;Add Advert";
		}
		elseif($pg == 'advertproc'){
			$mfile = "advert/proc.php";
		}
		elseif($pg == 'modadvert'){
			$title = TITLE."&nbsp;-&nbsp;Modify Advert";
			$mfile = "advert/mod.php";
		}
		
		// location module
		elseif($pg == 'viewlocation'){
			$mfile = "location/location/viewlocation.php";
			$title = TITLE."&nbsp;-&nbsp;State Management";
		}
		elseif($pg == 'addlocation'){
			$mfile = "location/location/addlocation.php";
			$title = TITLE."&nbsp;-&nbsp;Add State";
		}
		elseif($pg == 'locationproc'){
			$mfile = "location/location/locationProc.php";
		}
		elseif($pg == 'modlocation'){
			$title = TITLE."&nbsp;-&nbsp;Modify State";
			$mfile = "location/location/modlocation.php";
		}
		
		// Include Services Module File
		elseif($pg == 'viewservices'){
			$mfile = "services/view.php";
			$title = TITLE."&nbsp;-&nbsp;Services Management";
		}
		elseif($pg == 'addservice'){
			$mfile = "services/add.php";
			$title = TITLE."&nbsp;-&nbsp;Add Service";
		}
		elseif($pg == 'serviceproc'){
			$mfile = "services/proc.php";
		}
		elseif($pg == 'modservice'){
			$title = TITLE."&nbsp;-&nbsp;Modify Service";
			$mfile = "services/mod.php";
		}
		
		// Include Cleaner Module File
			
				
		// Include system Module File
		elseif($pg == 'viewsystemconfig'){
			$mfile = "settings/view_systemconfig.php";
			$title = TITLE."&nbsp;-&nbsp; System Management";
		}
		elseif($pg == 'addsystemconfig'){
			$mfile = "settings/process_systemconfig.php";
			$title = TITLE."&nbsp;-&nbsp; System Management";
		}
		
		elseif($pg == 'viewterms'){
			$mfile = "terms/view_terms.php";
			$title = TITLE."&nbsp;-&nbsp; Terms & Conditions";
		}
		elseif($pg == 'addterms'){
			$mfile = "terms/process_terms.php";
			$title = TITLE."&nbsp;-&nbsp; Terms & Conditions";
		}
		
		// Include version Module File
		elseif($pg == 'viewversion'){
			$mfile = "version/view_version.php";
			$title = TITLE."&nbsp;-&nbsp; Version Management";
		}
		
		elseif($pg == 'addversion'){
			$mfile = "version/process_version.php";
			$title = TITLE."&nbsp;-&nbsp; Version Management";
		}
		
				
		elseif($pg == 'addcategory'){
			$mfile = "category/process_category.php";
			$title = TITLE."&nbsp;-&nbsp; Categories";
		}
		elseif($pg == 'viewcategories'){
			$mfile = "category/view_category.php";
			$title = TITLE."&nbsp;-&nbsp; Categories";
		}
		
		// rating module
		elseif($pg == 'addrating'){
			$mfile = "rating/process_rating.php";
			$title = TITLE."&nbsp;-&nbsp; Ratings";
		}
		elseif($pg == 'viewrating'){
			$mfile = "rating/view_rating.php";
			$title = TITLE."&nbsp;-&nbsp; Ratings";
		}
		
		elseif($pg == 'addcoursecategory'){
			$mfile = "category/process_course_category.php";
			$title = TITLE."&nbsp;-&nbsp; Categories";
		}
		elseif($pg == 'viewcoursecategories'){
			$mfile = "category/view_course_category.php";
			$title = TITLE."&nbsp;-&nbsp; Categories";
		}
		
		
		elseif($pg == 'addtag'){
			$mfile = "tags/process_tag.php";
			$title = TITLE."&nbsp;-&nbsp; Tags";
		}elseif($pg == 'modtag'){
			$mfile = "tags/process_tag.php";
			$title = TITLE."&nbsp;-&nbsp; Tags";
		}
		elseif($pg == 'viewtags'){
			$mfile = "tags/view_tag.php";
			$title = TITLE."&nbsp;-&nbsp; Tags";
		}
		
		
				
		// Include general Module File
		elseif($pg == 'viewgeneralmsg'){
			$mfile = "general_message/view_general_message.php";
			$title = TITLE."&nbsp;-&nbsp; General Message Management";
		}
		
		elseif($pg == 'addgeneralmsg'){
			$mfile = "general_message/process_general_message.php";
			$title = TITLE."&nbsp;-&nbsp; General Message Management";
		}
		
		elseif($pg == 'addcms'){
			$mfile = "cmspages/process_cms.php";
			$title = TITLE."&nbsp;-&nbsp; CMS";
		}
		elseif($pg == 'viewcms'){
			$mfile = "cmspages/view_cms.php";
			$title = TITLE."&nbsp;-&nbsp; CMS";
		}
		
		
		else{
			$pg = "";
			$mfile = "welcome.php";
			$title = TITLE . "&nbsp; - &nbsp; Home";
		}
			
	}	
	else{
		$pg = "";
		$mfile = "welcome.php";
		$title = TITLE . "&nbsp; - &nbsp; Home";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?php echo $title?></title>
    

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<?php include_once("inc/head.inc.php");?>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/core.js" type="text/javascript"></script>
	<script>
		jQuery(function(){
			var activeurl = window.location;
			if(jQuery('a[href="'+activeurl+'"]').parent().parent().parent().parent().hasClass('nav'))
			{	
				jQuery('a[href="'+activeurl+'"]').parent().parent().parent().children('a').addClass('active');
				jQuery('a[href="'+activeurl+'"]').addClass('submenuactive');
			}
			else
			{
				jQuery('a[href="'+activeurl+'"]').addClass('active');
				jQuery('a[href="'+activeurl+'"]').closest('li').addClass('active');
				
			}
			//$('.error').hide();
		});
	</script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
	<div  class="wrapper">
		<?php require_once("inc/top.inc.php");?>
		<?php require_once("inc/side.inc.php");?>	
		<?php if($mfile != ""){ include_once $mfile;}	?>
		
<?php include_once("inc/footer.php");?>
    <div class="control-sidebar-bg"></div>
  </div>
</body>
</html>