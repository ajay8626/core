<?php
include "config.php";
$user_id = isset($_SESSION['user_id'])?$_SESSION['user_id']:0;
$howFar = isset($_GET['howFar'])?$_GET['howFar']:'';

$sql=mysql_query('UPDATE tbluser SET how_far_willing_to_travel="'.$howFar.'" WHERE user_id='.$user_id.' ');

$updateText = "Successfully Updated!";
echo $updateText;
exit;
?>