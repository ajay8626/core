<?php
include "config.php";

$user_id = $_SESSION['user_id'];

$certiSql = "UPDATE tbluser SET profilevideo=NULL WHERE user_id=".$user_id." ";
$certiQuery = mysql_query($certiSql);

if($certiQuery){
    echo 1;
    exit;
}else{
    echo 0;
    exit;
}