<?php
session_start();
error_reporting(0);
require_once("../config.php");

	$pageLength = $_REQUEST['pageLength'];
	$_SESSION['pageLength'] = $pageLength;