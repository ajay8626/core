<?php 

if(isset($_SESSION['user_id']))
{ 
	$postjoburl='postjob.php';
}else{
	$postjoburl='login.php?post_new_job=1';
}
?>
<div class="header-new header">
  <div class="container">
		      <div class="logo-left">
			      <a href="index.php"><img src="images/logo-new.png" alt="logo"></a>
			  </div>
			  <div class="rt-box">
			      <div class="login-btn">
				      <ul>
				      <?php if(!isset($_SESSION['user_id'])){ ?>	
					  <li><a href="login.php">Sign In</a></li>
					  <li><a href="login.php">Join</a></li>
					<?php } ?>
					  </ul>
				  </div>
				  <div class="post-btn">
				      <ul>
					  <li><a href="<?php echo $postjoburl; ?>">Post new job</a></li>
					  <li><a href="newcourselist.php" class="post-btn2">COURSES</a></li>
					  </ul>
				  </div>
			  </div>
  </div>			  
</div>