<?php
require('config.php');
/* $commisionRate = mysql_query("SELECT title_value FROM tblsystemconfiguration WHERE title_key='commission' ");
$com = mysql_fetch_array($commisionRate);
echo (100 - $com['title_value']); */

/*Job Details*/
$job_details = mysql_query("select * from tbljobs where job_id = 143");
$result_job = mysql_fetch_array($job_details);
$job_title	= $result_job['job_name'];
$job_poster_id = $result_job['job_user_id'];

/*Job Poster Details*/
$job_poster_details = mysql_query("select * from tbluser where user_id = '".$job_poster_id."'");
$result_job_poster = mysql_fetch_array($job_poster_details);
$job_poster_name = $result_job_poster['firstname'].' '.$result_job_poster['lastname'];
$job_poster_email = $result_job_poster['email'];

/*Job Bidders Details*/
$user_details = mysql_query("SELECT tu.email FROM tbluser as tu inner join tbljobsapplied as ta ON tu.user_id = ta.user_id where ta.job_id=143 AND ta.is_winner=1 ");
$bidder_emails = array();
while($user_details_array = mysql_fetch_assoc($user_details)){
    $bidder_emails[] = $user_details_array['email'];
}
$bidder_emails_string = implode(",", $bidder_emails);
echo $bidder_emails_string;
