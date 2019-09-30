<?php
//include("../config.php");
//include(SITE_PATH."api/class/message.php");

error_reporting(0);

$dbcon=mysql_connect("localhost","secureusr",'$eCuWr234');
$conn=mysql_select_db("securedb");

if (!$conn) {
    die('Could not connect: ' . mysql_error());
}


$file = 'Town_List_4_Wales1.csv';
$handle = fopen($file, "r");
if ($file == NULL) {
	echo 'Please select a file to import';
	exit;
} else {
	while(($filesop = fgetcsv($handle, 1000, ",")) !== false) {
		$town = $filesop[0];
		$county = $filesop[1];
		$country = $filesop[2];
		
		
		if(trim($county) != ''){
			$pollingQry = mysql_query("SELECT id from `tblstates` WHERE name LIKE '".$county."'");
			$numPolling = mysql_num_rows($pollingQry);
			if($numPolling >= 1){
				$pollingResult = mysql_fetch_assoc($pollingQry);

				
				$polling_id = $pollingResult['id'];
			}else{
				$insertPolling = mysql_query("INSERT INTO `tblstates` (`name`, `country_id`) VALUES ('".$county."', '253')");
				$polling_id = mysql_insert_id();
			} 
			
		}
		
		
		
        if($town!='') {
		$insertPolling = mysql_query("INSERT INTO `tblcities` (`name`, `state_id`) VALUES ('".$town."', ".$polling_id.")");
        $sqlElector=mysql_insert_id();
		}
      }

      if ($sqlElector) {
        echo "You database has imported successfully!";
      } else {
        echo 'Sorry! There is some problem in the import file.';
        }
    }
?>