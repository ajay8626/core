<script>
function check_delete()
{
	if(confirm("Once you delete your account, all of your personal information will be removed and you will not be able to log in to the website unless you sign up again"))
	{
		window.location.href='deleteprofile.php';
	}else{
	 	return false;
	}
}
</script>
<div class="header">
  <div class="container"> 
      <div class="logo"><a href="index.php"><img class="img-responsive" src="images/logo.png"></a></div>
      <div class="navigation"> <a href="#" class="lines-button x2"><span class="lines"></span></a>
        <div class="main_menu">
          	<ul class="firstul">
				<?php 
				$postjoburl='login.php';
				if(isset($_SESSION['user_id'])){ 
				$postjoburl='postjob.php';
				}
				?>
				<li <?php if(basename($_SERVER['PHP_SELF'])=='index.php'){ ?> class="current_page_item" <?php } ?>><a href="index.php">Home</a></li>
				<li <?php if(basename($_SERVER['PHP_SELF'])=='jobs.php' || basename($_SERVER['PHP_SELF'])=='ongoing_bids.php' || basename($_SERVER['PHP_SELF'])=='confirmedjobs.php' || basename($_SERVER['PHP_SELF'])=='ongoingjobs.php' || basename($_SERVER['PHP_SELF'])=='completedjobs.php'){ ?> class="current_page_item" <?php } ?>><a href="jobs.php">Search jobs</a></li>
				<li <?php if(basename($_SERVER['PHP_SELF'])=='postjob.php' || basename($_SERVER['PHP_SELF'])=='pending_post_job.php' || basename($_SERVER['PHP_SELF'])=='confirmed_post_job.php' || basename($_SERVER['PHP_SELF'])=='ongoing_post_job.php' || basename($_SERVER['PHP_SELF'])=='completed_post_job.php'){ ?> class="current_page_item" <?php } ?>><a href="<?php echo $postjoburl; ?>">post jobs</a></li>
				<?php if(isset($_SESSION['user_id'])){ ?>
				<li <?php if(basename($_SERVER['PHP_SELF'])=='new-request.php' || basename($_SERVER['PHP_SELF'])=='requested.php' || basename($_SERVER['PHP_SELF'])=='confirmed.php' || basename($_SERVER['PHP_SELF'])=='favourite_list.php' || basename($_SERVER['PHP_SELF'])=='guard-profile.php'){ ?> class="current_page_item" <?php } ?>><a href="new-request.php">Search Candidate</a></li>				
				<?php } ?>
				<?php if(isset($_SESSION['user_id'])){ ?>
				<li <?php if(basename($_SERVER['PHP_SELF'])=='reviews.php'){ ?> class="current_page_item" <?php } ?>><a href="reviews.php">Reviews</a></li>				
				<?php } ?>
				<li <?php if(basename($_SERVER['PHP_SELF'])=='course.php'){ ?> class="current_page_item" <?php } ?>><a href="newcourselist.php">courses</a></li>
          	</ul>
        </div>
		<?php if(isset($_SESSION['user_id'])){ 
		      $link='login.php';
			  if(isset($_SESSION['user_id']) && $_SESSION['customer_type']==1)
			  {
				  $link='business-profile.php';
				  $profileCLass = 'business-profile-class';
			  }
			  if(isset($_SESSION['user_id']) && $_SESSION['customer_type']==2)
			  {
				  $link='individual-profile.php';
				  $profileCLass = 'individual-profile-class';
			  }
		?>
        <?php 
		/* Select Name of Logged In User */
		$nameSql = "SELECT firstname,customer_type FROM tbluser WHERE user_id=".$_SESSION['user_id']."";
		$nameQuery = mysql_query($nameSql);
		$nameArray = mysql_fetch_array($nameQuery);
		$nameUser = $nameArray['firstname'];
		?>
        <div class="loginlik <?php echo $profileCLass; ?>"><a href="<?php echo $link; ?>">Hello <?php echo $nameUser; ?></a>
         	<ul>
		 		<li><a href="<?php echo $link; ?>">Dashboard</a></li> 
				<li><a href="profile-edit.php">Edit Profile</a></li>
				<?php if ($nameArray['customer_type'] == 1){ ?>
					<li><a href="manage-course.php">Manage Course</a></li>
				<?php } ?>
				<li><a href="javascript:void(0);" onclick="return check_delete();">Delete My Account</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
        </div>
		<?php } ?>
		<?php if(!isset($_SESSION['user_id'])){ ?>
		<div class="loginlik"><a href="login.php">Login/Register</a></div>
        <?php } ?>
        <!--<div class="loginlik"><a href="login.php">Login/Register</a></div>-->
        <div class="selectdrpdwn">
			<div id="google_translate_element"></div>
        </div>
      </div> 
  </div>
</div>