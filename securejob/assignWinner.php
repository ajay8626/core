<?php
include "config.php";

$user_id=isset($_GET['user_id'])?$_GET['user_id']:0;
$job_id=isset($_GET['job_id'])?$_GET['job_id']:0;

$msg = "Fail";
if($user_id != 0 && $job_id !=0){
	$NoOfPersons= 0; // initialize to zero
	$opening_position= 0; // initialize to zero
	$alreadyWinnerPersons= 0; // initialize to zero
	
	// fetching actual requirement of no of person
	$selectPositionsQry = mysql_query("select opening_position from  tbljobs where job_id = ".$job_id." ");
	if(mysql_num_rows($selectPositionsQry)){
		$selectPositionsResult = mysql_fetch_assoc($selectPositionsQry);
		$opening_position = $selectPositionsResult["opening_position"];	
	}
	
	
	// fetch about to be winner's no of person
	$selectPersons = mysql_query("select no_of_persons from  tbljobsapplied where job_id = ".$job_id." and user_id = ".$user_id." ");
	if(mysql_num_rows($selectPersons)){
		$NoOfPersonsResult = mysql_fetch_assoc($selectPersons);
		$NoOfPersons = $NoOfPersonsResult["no_of_persons"];
	}
	
	
	
	// fetching no of persons if Employer has already selected any winner
	$alreadyWinnerQry = mysql_query("select no_of_persons from  tbljobsapplied where job_id = ".$job_id." and is_winner = 1 ");
	if(mysql_num_rows($alreadyWinnerQry)){
		$alreadyWinnerResult = mysql_fetch_assoc($alreadyWinnerQry);
		$alreadyWinnerPersons = $alreadyWinnerResult["no_of_persons"];
	}
	
	if($opening_position >= ( $alreadyWinnerPersons + $NoOfPersons ) ){
		$updateQry = "update tbljobsapplied set is_winner = 1 where user_id = ".$user_id." and job_id = ".$job_id."";
		$addWinner = mysql_query($updateQry); 

		/*Mail when user won the bid they have post on any job*/
		user_selected_for_bid($user_id,$job_id);
		if($addWinner){
			$obj = new stjNotification;
			$obj->bidWinnerNotification($job_id, $user_id);
		}
		$msg  = "Success";	
	}
	else{
		$msg = "By selecting this user total no. of persons exceeds";
	}
		
	
}
else{
	$msg  = "Something went wrong. Please try after sometime";
}	
echo $msg;
exit;

?>