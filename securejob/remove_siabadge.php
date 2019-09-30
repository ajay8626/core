<?php
include "config.php";

$userId = isset($_REQUEST["userId"]) ? $_REQUEST["userId"]:'';
$certiId = isset($_REQUEST["certiId"]) ? $_REQUEST["certiId"]:'';

if($userId != "" && $certiId != ""){
    $certiSql = "DELETE FROM tbl_user_siabadge WHERE user_id=".$userId." AND id=".$certiId." ";
    $certiQuery = mysql_query($certiSql);

    if($certiQuery){
        echo 1;
        exit;
    }else{
        echo 0;
        exit;
    }
}else{
    echo 0;
    exit;
}