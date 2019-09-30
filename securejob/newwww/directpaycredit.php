<?php
include "config.php";

$job_id=isset($_GET['job_id'])?$_GET['job_id']:0;
$total_fees=isset($_GET['total_fees'])?$_GET['total_fees']:0;
$user_id=isset($_SESSION['user_id']) ? $_SESSION['user_id'] :0;
$msg = "";

if($user_id !=0 && $total_fees!=0){
    $creditAvailable = mysql_query("SELECT total_credit FROM tbluser WHERE user_id=$user_id");
    $userCreditArra = mysql_fetch_array($creditAvailable);
    $userCredit = $userCreditArra['total_credit'];
    if($userCredit >= $total_fees){
        $updateJobStatus = "UPDATE tbljobs SET status = 1 WHERE job_id = ".$job_id."";
        mysql_query($updateJobStatus);
        unset($_SESSION['jobdetails']);
	    unset($_SESSION['jobimages']);
	    unset($_SESSION['last_id']);

        $userNewCredit = ($userCredit - $total_fees);
        $updateUserCredit = "UPDATE tbluser SET total_credit = ".$userNewCredit." WHERE user_id = ".$user_id."";
        mysql_query($updateUserCredit);
        /*Mail when user do payment for job post*/
        job_payment_by_credit($user_id,$job_id,$total_fees);

        $msg = "Paid successfully.";

    }else{
        $msg = "You do not have enough credit.";
    }
}else{
    $msg = "Something went wrong.";
}

echo $msg;
exit;

?>