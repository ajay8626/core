<?php 
include "config.php"; 
include "check_user_login.php";
include_once(ADMIN_PATH."inc/resize-class.php");

$customer_type=isset($_SESSION['customer_type']) ? $_SESSION['customer_type'] : 0;
$activetitle='';
if($customer_type==1)
{
    $activetitle='Business User';
}
if($customer_type==2)
{
    $activetitle='Personal User';
}

if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'del') {
	$course_id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
	if(!empty($course_id)){
		$where = "course_id  = {$course_id}";
		$db->Delete("tblcoursemaster",$where);
	}
	header('Location:manage-course.php');
}
$search_txt = '';
if(isset($_REQUEST['search']) && !empty($_REQUEST['search'])){

	$user_id= $_SESSION['user_id'];
	$search_txt = trim($_REQUEST['search']);
	$select_query = mysql_query("select * from tblcoursemaster WHERE created_by = $user_id AND course_title LIKE '%$search_txt%' ORDER By `course_id` DESC");
} else {
	$user_id= $_SESSION['user_id'];	
	$select_query = mysql_query("select * from tblcoursemaster WHERE created_by = $user_id ORDER By `course_id` DESC");
}


$user_id= $_SESSION['user_id'];
$user_status_query = mysql_query("select verified_user from tbluser WHERE user_id = '".$user_id."'");
while($user_status = mysql_fetch_assoc($user_status_query)){

	$user_sts = $user_status['verified_user'];
	
}


if (isset($user_sts) && $user_sts == 0) {
	$user_sts = 0;
}else{
	$user_sts = 1;
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
<title>Manage Course - SECURE THAT JOB</title>

<!-- Bootstrap -->
<link href="https://fonts.googleapis.com/css?family=Fira+Sans:300,400,400i,500,600,700,800" rel="stylesheet"> 
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link href="css/jquery-ui.css" rel="stylesheet">
<link href="css/ddsmoothmenu.css" rel="stylesheet">
<link href="css/jquery.fancybox.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">
<link href="fonts/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" href="admin/css/font-awesome.min.css">
<link href="css/cropper.css" rel="stylesheet">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.bxslider.js"></script>
<script type="text/javascript" src="js/menu.js"></script>
<script type="text/javascript" src="js/jquery.fancybox.js"></script>
<script src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/at-jquery.js"></script>
<script type="text/javascript" src="js/cropper.min.js"></script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<!-- <link rel="stylesheet" href="admin/css/dataTables.bootstrap.css">
<script src="admin/js/jquery.dataTables.min.js"></script>
<script src="admin/js/dataTables.bootstrap.min.js"></script>
<script>
$(function () {
$('#course_tbl').DataTable({
  "paging": true,
  "lengthChange": true,
  "searching": true,
  "ordering": true,
  "info": true,
  "autoWidth": false
});
});
</script> -->
<script type="text/javascript">
	$(document).ready(function() {
	    var input = $("#search");
	    var len = input.val().length;
	    input[0].focus();
	    input[0].setSelectionRange(len, len);
	});
	/*$( "#search").keyup(function() {
		alert('df');
	});*/
	/*function searchcourse() {
		 var inputVal = $("#search").val();

	}*/
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
<div id="preloader" style="display:none"></div>
<?php include "header-inner.php"; ?>
<div class="course-contain">
	<div class="container">
		<div class="row source_manage">
			<div class="col-xs-12 col-md-12 source_div">
				<div class="header_title">
					<h3>Course Listing</h3>
				</div>
				<form method="post">
					<div class="sourse_search">
							<input class="txt_lg" name="search" id="search" autocomplete="off" placeholder="Search..."  type="text" value="<?php echo $search_txt; ?>">
							<input type="submit" name="search_btn" class="btn btn-primary" value="Search">
						<?php 
						if ($user_sts == 0) { 
							echo "<a class='btn btn-primary' id='add_course' data-toggle='modal' data-target='#admin_call'>Add New</a>";
						} else {
							echo "<a class='btn btn-primary' id='add_course' href='add-course.php'>Add New</a>";
						}
						
						?>

						
					</div>
				</form>
				<!-- rout time use add_course_rout.php -->
			</div>


			<div id="admin_call" class="modal fade" role="dialog">
			  <div class="modal-dialog">

			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title"></h4>
			      </div>
			      <div class="modal-body">
			        <p>You can not post a course as you are not a Verified User.</p>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			      </div>
			    </div>

			  </div>
			</div>



			<div class="col-xs-12 col-md-12 source_div">
				<table id="course_tbl" class="table">
				  <thead>
				    <tr>
				      
				      <th scope="col">Course Title</th>
				      <th scope="col">Created Date</th>
				      <th scope="col">Start From</th>
				      <th scope="col">Price (£)</th>
				      <th scope="col">Positions Filled</th>
				      <th scope="col">Action</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php $no = 1;
				  	$no_row = mysql_num_rows($select_query);
				  	if ($no_row > 0) {
					  	while($row = mysql_fetch_assoc($select_query)): ?>
					    <tr>
					      
					      <td><?php echo $row['course_title']; ?></td>
					      <td><?php echo date("d-M-Y", strtotime($row['created_date'])); ?></td>
					      <td><?php echo date("d-M-Y", strtotime($row['start_date'])); ?></td>
					      <td><?php echo "&pound; ".$row['price']; ?></td>
					      <?php
					      	$cid = $row['course_id'];
					        $Filled = mysql_query("SELECT * FROM tbl_course_payment WHERE course_id = $cid");
							$user_appayed = mysql_num_rows($Filled);

							/*if ($user_appayed != 0) {
								$left_enrollment = $row['enrollment_limit'] - $user_appayed;
							}else{
								$left_enrollment = $row['enrollment_limit'];
							} */
					      ?>

					      <td><?php echo $user_appayed; ?> / <?php echo $row['enrollment_limit']; ?></td>
					      <td>
					      	<a href="<?php echo SITE_URL.'edit-course.php?id='.$row['course_id']; ?>"><i class="fa fa-edit"></i></a>
					      	<?php
					      	if ($user_appayed<=0) { ?>
					      		<a href="<?php echo SITE_URL.'manage-course.php?action=del&id='.$row['course_id']; ?>"><i class="fa fa-trash"></i></a>
					      	<?php }else{ ?>
					      		<a class="not_trash"><i class="fa fa-trash"></i></a>
					      	<?php } ?>
					      	
					      </td>
					    </tr>
					  	<?php $no++; 
					  	endwhile; 
					} else { ?>
						<tr>
							<td colspan="7"> No Course Available...</td>
						</tr>
					<?php } ?>
				  </tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php include "footer.php"; ?>
<?php include('admin/inc/validation.php'); ?>
</body>
</html>

