<?php
include "config.php"; 

$user_id = isset($_GET['user_id'])?$_GET['user_id']:0;
$job_id = isset($_GET['job_id'])?$_GET['job_id']:0;
$rate = isset($_GET['rate'])?$_GET['rate']:"";

$jobPosterSql = "SELECT job_user_id FROM tbljobs WHERE job_id=$job_id";
$jobPosterArray = mysql_query($jobPosterSql);
$jobPoster = mysql_fetch_array($jobPosterArray);
$jobPosterId = $jobPoster['job_user_id'];

/* Check if rating added */
$checkQuery = "SELECT * FROM tbl_job_poster_rating WHERE user_id=".$user_id." AND job_id=".$job_id." AND job_poster_id=".$jobPosterId." ";
$checkRow = mysql_query($checkQuery);
$checkRowNum = mysql_num_rows($checkRow);
if($checkRowNum == 0){

	/* Insert Record */
	$insertRate = mysql_query("INSERT INTO tbl_job_poster_rating (user_id, job_poster_id, job_id, rating) VALUES (".$user_id.", ".$jobPosterId.", ".$job_id.", ".$rate.") ");
	$ratingStatus = "You have successfully rate the job poster.";

}elseif($checkRowNum > 0){

	/* Update Record */
	$updateRate = mysql_query("UPDATE tbl_job_poster_rating SET rating=".$rate." WHERE user_id=".$user_id." AND job_id=".$job_id." AND job_poster_id=".$jobPosterId." ");
	$ratingStatus = "You have successfully rate the job poster.";

}else{

	$ratingStatus = "Fail! Something went wrong. Please try again.";
	
}
echo $ratingStatus;
exit;
?>