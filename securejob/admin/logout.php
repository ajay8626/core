<?php 
session_destroy(); 
header("Location:index.php");
exit;
// if php header does not work than use this script
/*
?>
<script type='text/javascript'>//<![CDATA[ 
	$(window).load(function(){
		//$('.body_header').delay(5000);
		$('.body_header').delay(5000).fadeOut(function(){
		$(this).remove();
		$(location).attr('href',"<?php echo ADMIN_URL ?>index.php?logout");
		});
		
	});
//]]>  
</script>
<?php */ ?>