<?php
include "../../../config.php";

$userId = isset($_REQUEST["userId"]) ? $_REQUEST["userId"]:'';
$certiId = isset($_REQUEST["certiId"]) ? $_REQUEST["certiId"]:'';
$flag = isset($_REQUEST["flag"]) ? $_REQUEST["flag"]:'';

if($userId != "" && $certiId != "" && $flag != ""){
    $certiSql = "UPDATE tbl_user_utility SET verified=".$flag." WHERE user_id=".$userId." AND id=".$certiId." ";
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