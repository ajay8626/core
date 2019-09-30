<?php
include "config.php"; 
$update=mysql_query("update tbluser SET last_logout='".date("Y-m-d h:i:s")."' where user_id=".$_SESSION['user_id'].""); 
unset($_SESSION['FBRLH_state']);
$_SESSION['FBRLH_state']='';
session_destroy(); 
header("Location:index.php");
exit;
?>