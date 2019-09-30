<div class="footer">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
       <div class="flogo"><img src="images/footerlogo.png" alt=""/></div>
      </div>
      <div class="col-md-9">
        <div class="footermenu">
          <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="page.php?page_id=3">About Us</a></li>
            <li><a href="page.php?page_id=9">Privacy Policy</a></li>
            <li><a href="page.php?page_id=10">Terms of Use</a></li>
			<?php if(!isset($_SESSION['user_id'])){ ?>
            <li><a href="login.php">Login/Register</a></li>
			<?php } ?>
            <?php if(isset($_SESSION['user_id'])){ ?>
            <li><a href="new-request.php">Search Candidates</a></li>
			<?php } ?>
       <li><a href="faq.php">Faq</a></li>
       <li><a href="feedback.php">Feedback</a></li>
            <li><a href="contact.php">Contact Us</a></li>
          </ul>
        </div>
        <div class="copyright">(c) <?php echo date("Y") ?> <a href="index.php">Securethatjob.com</a> | Web Development by <a href="http://www.mgtdesign.co.uk/" target="_blank">MGT Design</a></div>
        <div class="social">
        	<a href="https://www.facebook.com/Secure-That-Job-1254716687927805/" target="_blank"><i class="fa fa-facebook"></i></a>
        	<a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
        	<a href="https://www.instagram.com/securethatjob/" target="_blank"><i class="fa fa-instagram"></i></a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Pop-up to say Hello!! -->
<?php if(isset($_SESSION['fname']) && isset($_SESSION['login_pop_up'])){ ?>
  <script>
    $( document ).ready(function() {
      //$("#infor").delay(6000).fadeOut(2000);
    }); 
  </script>
<?php 
  if($_SESSION['customer_type'] == 2 ){
    $backColor = "style='background: #CF2027;'";
  }else{
    $backColor = "style='background: #4D5170;'";
  }
?>

<!-- <div id="infor" class="mt_pro" <?php /* echo $backColor; */ ?> >
	  <p>Hello <strong><?php /* echo @$_SESSION['fname']." ".@$_SESSION['lname']; */ ?></strong></p>
</div> -->

<?php /* unset($_SESSION['login_pop_up']); */ } ?>


<?php
unset($_SESSION['mt']);
unset($_SESSION['me']);
?>

<!-- Script For Social Share -->
<script src="social-share/dist/jquery.shares.js"></script>
<script>
  $(document).ready(function(){
    $('a.share').shares();
  });
</script>

<!-- Script to Open Name Pop Up -->
<?php if(isset($_SESSION['fname'])){ ?>
<script>
  $(window).load(function(){
	  setTimeout(function(){ 
		  $('.mt_pro').addClass("mt_pro_show");
	  }, 500);	
});
</script>
<?php } ?>

<!-- Script to Close Name Pop Up -->
<script>	 
	$("#infor").click(function(){
    $('.mt_pro').removeClass("mt_pro_show");
  });	
</script>
