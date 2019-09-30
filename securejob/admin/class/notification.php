<?php

class stjNotification{

    /* Notification Type Variable */
    public $notificationType;
    public $notificationList;
    public $notificationCount;

    /*
        Notification Type (Switch Case)
        1 - Chat
        2 - Win Bid
        3 - Add Bid
        4 - Job Listing Payment (Either by PayPal or Credit)
        5 - Job Payment
        6 - Add Credit
        7 - Received Feedback (Bidder)
        8 - Received Feedback (Poster)
        9 - Course Payment (Apply)
        10 - Job Invitation
    */

    /* Insert Chat Notification NT=1 */
    function insertChatNotification($jobId=0, $senderId=0){

        $paramenterArray = array(
            'job_id' => $jobId,
            'sender_id' => $senderId,
        );
        $paramenterSerialize = serialize($paramenterArray);
        $status = 0;
        $notificationType = 1;

        $posterIdSql = mysql_query("SELECT job_user_id FROM tbljobs WHERE job_id=".$jobId." ");
        $posterIdArray = mysql_fetch_assoc($posterIdSql);
        $posterId = $posterIdArray['job_user_id'];

        if($posterId != $senderId){
            $insertChatNotification = mysql_query("INSERT INTO tblstjnotification (notification_type, notified_user_id, parameter_array, n_status) VALUES
            (".$notificationType.", ".$posterId.", '".$paramenterSerialize."', ".$status.")");
        }

        $userListSql = mysql_query("SELECT user_id FROM tbljobsapplied WHERE job_id=".$jobId." AND is_winner=1 AND user_id != ".$senderId." ");
        while($userList = mysql_fetch_assoc($userListSql)){
            $insertChatNotification = mysql_query("INSERT INTO tblstjnotification (notification_type, notified_user_id, parameter_array, n_status) VALUES
            (".$notificationType.", ".$userList['user_id'].", '".$paramenterSerialize."', ".$status.")");
        }
    }


    /* Insert Bid Winner Notification NT=2 */
    function bidWinnerNotification($jobId=0, $userId=0){
        
        $status = 0;
        $notificationType = 2;

        $posterIdSql = mysql_query("SELECT job_user_id FROM tbljobs WHERE job_id=".$jobId." ");
        $posterIdArray = mysql_fetch_assoc($posterIdSql);
        $posterId = $posterIdArray['job_user_id'];
        $paramenterArray = array(
            'job_id' => $jobId,
            'user_id' => $userId,
            'poster_id' => $posterId
        );
        $paramenterSerialize = serialize($paramenterArray);

        $insertBidWinnerNotification = mysql_query("INSERT INTO tblstjnotification (notification_type, notified_user_id, parameter_array, n_status) VALUES
            (".$notificationType.", $userId, '".$paramenterSerialize."', ".$status.")");

    }

    

    /* Add Bid Notification NT=3 */
    function addBidNotification($jobId=0, $userId=0){

        $status = 0;
        $notificationType = 3;

        $posterIdSql = mysql_query("SELECT job_user_id FROM tbljobs WHERE job_id=".$jobId." ");
        $posterIdArray = mysql_fetch_assoc($posterIdSql);
        $posterId = $posterIdArray['job_user_id'];
        $paramenterArray = array(
            'job_id' => $jobId,
            'user_id' => $userId,
            'poster_id' => $posterId
        );
        $paramenterSerialize = serialize($paramenterArray);

        $insertAddBidNotification = mysql_query("INSERT INTO tblstjnotification (notification_type, notified_user_id, parameter_array, n_status) VALUES
            (".$notificationType.", $posterId, '".$paramenterSerialize."', ".$status.")");
    }


    /* Job Listing Payment Notification NT=4 */
    function jobListingPaymentNotification($jobId=0, $payWith){

        $status = 0;
        $notificationType = 4;
        if($payWith == 1){
            $payWithText = "Paypal";
        }elseif($payWith == 2){
            $payWithText = "Available Credit";
        }

        $posterIdSql = mysql_query("SELECT job_user_id FROM tbljobs WHERE job_id=".$jobId." ");
        $posterIdArray = mysql_fetch_assoc($posterIdSql);
        $posterId = $posterIdArray['job_user_id'];
        $paramenterArray = array(
            'job_id' => $jobId,
            'poster_id' => $posterId,
            'pay_with' => $payWithText
        );
        $paramenterSerialize = serialize($paramenterArray);

        $insertjobListingPaymentNotification = mysql_query("INSERT INTO tblstjnotification (notification_type, notified_user_id, parameter_array, n_status) VALUES
            (".$notificationType.", $posterId, '".$paramenterSerialize."', ".$status.")");
    }


    /* Job Finalised Payment Notification NT=5 */
    function jobFinalisedPaymentNotification($jobId=0){

        $status = 0;
        $notificationType = 5;

        $posterIdSql = mysql_query("SELECT job_user_id FROM tbljobs WHERE job_id=".$jobId." ");
        $posterIdArray = mysql_fetch_assoc($posterIdSql);
        $posterId = $posterIdArray['job_user_id'];
        $paramenterArray = array(
            'job_id' => $jobId,
            'poster_id' => $posterId,
        );
        $paramenterSerialize = serialize($paramenterArray);

        $insertjobListingPaymentNotification = mysql_query("INSERT INTO tblstjnotification (notification_type, notified_user_id, parameter_array, n_status) VALUES
            (".$notificationType.", $posterId, '".$paramenterSerialize."', ".$status.")");
    }


    /* Add Credit Notification NT=6 */
    function addCreditNotification($userId=0){

        $status = 0;
        $notificationType = 6;

        $paramenterArray = array(
            'user_id' => $userId
        );
        $paramenterSerialize = serialize($paramenterArray);

        $insertjobListingPaymentNotification = mysql_query("INSERT INTO tblstjnotification (notification_type, notified_user_id, parameter_array, n_status) VALUES
            (".$notificationType.", $userId, '".$paramenterSerialize."', ".$status.")");
    }

    /* Add Feedback (Bidder) Notification NT=7 */
    function addFeedbackNotification($jobId=0, $userId=0, $reviewerId=0){

        $status = 0;
        $notificationType = 7;

        $paramenterArray = array(
            'user_id' => $userId,
            'job_id' => $jobId,
            'reviewer_id' => $reviewerId
        );
        $paramenterSerialize = serialize($paramenterArray);

        $insertjobListingPaymentNotification = mysql_query("INSERT INTO tblstjnotification (notification_type, notified_user_id, parameter_array, n_status) VALUES
            (".$notificationType.", $userId, '".$paramenterSerialize."', ".$status.")");
    }

    /* Add Feedback (Poster) Notification NT=8 */
    function addFeedbackPosterNotification($jobId=0, $userId=0, $reviewerId=0){

        $status = 0;
        $notificationType = 8;

        $paramenterArray = array(
            'user_id' => $userId,
            'job_id' => $jobId,
            'reviewer_id' => $reviewerId
        );
        $paramenterSerialize = serialize($paramenterArray);

        $insertjobListingPaymentNotification = mysql_query("INSERT INTO tblstjnotification (notification_type, notified_user_id, parameter_array, n_status) VALUES
            (".$notificationType.", $userId, '".$paramenterSerialize."', ".$status.")");
    }

    /* Course Apply Notification NT=9 */
    function applyCourseNotification($courseId=0, $userId=0){

        $status = 0;
        $notificationType = 9;

        $paramenterArray = array(
            'course_id' => $courseId,
            'user_id' => $userId
        );
        $paramenterSerialize = serialize($paramenterArray);

        $insertjobListingPaymentNotification = mysql_query("INSERT INTO tblstjnotification (notification_type, notified_user_id, parameter_array, n_status) VALUES
            (".$notificationType.", $userId, '".$paramenterSerialize."', ".$status.")");
    }

    /*invite user for job*/
    function userInviteNotification($job_id, $invitee_id,$request_id){

        $status = 0;
        $notificationType = 10;

        /*Invitee Details*/
        $user_details = mysql_query("select * from tbluser where user_id=".$request_id."");
        $result_bidder = mysql_fetch_array($user_details);
        $user_name = $result_bidder["firstname"]." ".$result_bidder["lastname"];
        $user_email = $result_bidder["email"];

        /*Job Details*/
        $job_details = mysql_query("select * from tbljobs where job_id = '".$job_id."'");
        $result_job = mysql_fetch_array($job_details);
        $job_title  = $result_job['job_name'];
        $job_link = SITE_URL."place-bid.php?job_id=".$job_id;
        $job_poster_id = $result_job['job_user_id'];

        /*Job Poster Details*/
        $job_poster_details = mysql_query("select * from tbluser where user_id = '".$job_poster_id."'");
        $result_job_poster = mysql_fetch_array($job_poster_details);
        $job_poster_name = $result_job_poster['firstname'].' '.$result_job_poster['lastname'];

        $paramenterArray = array(
            'job_id' => $job_id,
            'user_id' => $invitee_id,
            'poster_id' => $job_poster_id
        );
        $paramenterSerialize = serialize($paramenterArray);

        $inviteUserNotification = mysql_query("INSERT INTO tblstjnotification (notification_type, notified_user_id, parameter_array, n_status) VALUES
            (".$notificationType.", $request_id, '".$paramenterSerialize."', ".$status.")");


    }

    /* Count Notification */
    function countNotifications($userId=0){
        $CountNotificationQuery = mysql_query("SELECT * FROM tblstjnotification WHERE notified_user_id=".$userId." AND n_status=0");
        $countN = mysql_num_rows($CountNotificationQuery);
        return $this->notificationCount = $countN;
    }
    

    /* List of all Notification */
    function listAllNotifications($userId=0){
        $notificationQuery = mysql_query("SELECT * FROM tblstjnotification WHERE notified_user_id=".$userId." AND n_status=0");
        $this->notificationCount = $this->countNotifications($userId);
        $this->notificationList .= "";

        if($this->notificationCount > 0){
            $this->notificationList .= "<ul class='notification_list'>";
            while($noRow = mysql_fetch_assoc($notificationQuery)){
                $notificationId = $noRow['id'];
                $notificationType = $noRow['notification_type'];
                $notificationParameter = unserialize($noRow['parameter_array']);
                $markAsread = "<a class='mark_read' id='mark_read' onClick='markRead(".$notificationId.")'>Mark as read</a>";
                
                /*
                    Notification Type (Switch Case)
                    1 - Chat
                    2 - Win Bid
                    3 - Add Bid
                    4 - Job Listing Payment (Either by PayPal or Credit)
                    5 - Job Payment
                    6 - Add Credit
                    7 - Received Feedback (Bidder)
                    8 - Received Feedback (Poster)
                    9 - Course Payment (Apply)
                    10 - Job Invitation
                */

                switch($notificationType){
                    case 1:
                        $jobId = $notificationParameter['job_id'];
                        $this->notificationList .= "<div class='alert alert-success' role='alert' style='padding:2px;'><li>You have received a new chat message. ".$markAsread."</li></div>";
                        break;
                    case 2:
                        $userName = getusername($notificationParameter['user_id']);
                        $jobId = $notificationParameter['job_id'];
                        $notifyUrl = SITE_URL."place-bid.php?job_id=".$jobId;
                        $notificationText = "Congratulations ".$userName."! You have won the bid on <a href='".$notifyUrl."' class='alert-link'>Job</a>.";
                        $this->notificationList .= "<div class='alert alert-success' role='alert' style='padding:2px;'><li>".$notificationText." ".$markAsread."</li></div>";
                        break;
                    case 3:
                        $userName = getusername($notificationParameter['user_id']);
                        $jobId = $notificationParameter['job_id'];
                        $notifyUrl = SITE_URL."biddetails.php?job_id=".$jobId;
                        $notificationText = $userName." has added a bid on your <a href='".$notifyUrl."' class='alert-link'>Job</a>.";
                        $this->notificationList .= "<div class='alert alert-success' role='alert' style='padding:2px;'><li>".$notificationText." ".$markAsread."</li></div>";
                        break;
                    case 4:
                        $jobId = $notificationParameter['job_id'];
                        $payWith = $notificationParameter['pay_with'];
                        $notifyUrl = SITE_URL."biddetails.php?job_id=".$jobId;
                        $notificationText = "We have received a Payment for the <a href='".$notifyUrl."' class='alert-link'>Job</a>. Payment has been made via ".$payWith.". ";
                        $this->notificationList .= "<div class='alert alert-success' role='alert' style='padding:2px;'><li>".$notificationText." ".$markAsread."</li></div>";
                        break;
                    case 5:
                        $jobId = $notificationParameter['job_id'];
                        $notifyUrl = SITE_URL."confirmed_post_job.php";
                        $notificationText = "We have received a Payment for the <a href='".$notifyUrl."'>Job</a>. ";
                        $this->notificationList .= "<div class='alert alert-success' role='alert' style='padding:2px;'><li>".$notificationText." ".$markAsread."</li></div>";
                        break;
                    case 6:
                        $userName = getusername($notificationParameter['user_id']);
                        $notificationText = "Congratulations ".$userName."! You have successfully added the credits.";
                        $this->notificationList .= "<div class='alert alert-success' role='alert' style='padding:2px;'><li>".$notificationText." ".$markAsread."</li></div>";
                        break;
                    case 7:
                        $userName = getusername($notificationParameter['user_id']);
                        $jobId = $notificationParameter['job_id'];
                        $notifyUrl = SITE_URL."search_job_confirmed.php?job_id=".$jobId."&flag=complete";
                        $notificationText = "Congratulations ".$userName."! You have received a feedback on <a href='".$notifyUrl."' class='alert-link'>Job</a>. ";
                        $this->notificationList .= "<div class='alert alert-success' role='alert' style='padding:2px;'><li>".$notificationText." ".$markAsread."</li></div>";
                        break;
                    case 8:
                        $userName = getusername($notificationParameter['user_id']);
                        $jobId = $notificationParameter['job_id'];
                        $notifyUrl = SITE_URL."biddetails.php?job_id=".$jobId."&flag=complete";
                        $notificationText = "Congratulations ".$userName."! You have received a feedback on <a href='".$notifyUrl."' class='alert-link'>Job</a>. ";
                        $this->notificationList .= "<div class='alert alert-success' role='alert' style='padding:2px;'><li>".$notificationText." ".$markAsread."</li></div>";
                        break;
                    case 9:
                        $userName = getusername($notificationParameter['user_id']);
                        $courseId = $notificationParameter['course_id'];
                        $notifyUrl = SITE_URL."newcourse_details.php?course_id=".$courseId;
                        $notificationText = "Congratulations ".$userName."! You have successfully applied for a <a href='".$notifyUrl."'  class='alert-link'>Course</a>. We have received your payment.";
                        $this->notificationList .= "<div class='alert alert-success' role='alert' style='padding:2px;'><li>".$notificationText." ".$markAsread."</li></div>";
                        break;

                    case 10:
                        $userName = getusername($notificationParameter['user_id']);
                        $jobId = $notificationParameter['job_id'];
                        $job_link = SITE_URL."place-bid.php?job_id=".$jobId;
                        $notificationText = $userName." has invited you to bid on the <a class='alert-link' href=".$job_link." > Job </a>";
                        $this->notificationList .= "<div class='alert alert-success' role='alert' style='padding:2px;'><li>".$notificationText." ".$markAsread."</li></div>";
                        break;
                    default:
                        $this->notificationList .= "";
                }
            }
            $this->notificationList .= "</ul>";
            return $this->notificationList;
        }else{
            $this->notificationList .= "<center><h4>No notifications</h4></center>";
            return $this->notificationList;
        }
    }

}

?>