<?php
if(!isset($_SESSION['user_id']))
{
	
	$_SESSION['page_name']=basename($_SERVER['REQUEST_URI']);
	echo '<script> window.location.href="login.php";</script>';
}
?>