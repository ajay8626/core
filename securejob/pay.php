<?php
include "config.php";

$job_id=isset($_GET['job_id'])?$_GET['job_id']:0;

$msg = "";
if($job_id !=0){
	$updateQry = "update tbljobs set payment_status = 1,job_status=2 where job_id = ".$job_id."";
	mysql_query($updateQry); 
	$sqlGetWinners  = mysql_query("select CONCAT(user.firstname ,' ' ,user.lastname  ) as name
								from tbljobsapplied join tbluser as user on tbljobsapplied.user_id = user.user_id
								where tbljobsapplied.job_id = ".$job_id." ");
	
	if(mysql_num_rows($sqlGetWinners)){
		$username = "";
		while($result = mysql_fetch_assoc($sqlGetWinners)){
			if($username !=""){
				$username .= " and ".$result["name"];	
			}
			else{
				$username = $result["name"];
			}
			
		}
		
	}
	
	$msg  = "Thank you for your payment.";	
}
else{
	$msg  = "Something went wrong. Please try after sometime";
}	
echo $msg;
exit;

?>