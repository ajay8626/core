<?php

class stjNotification{

    /* Notification Type Variable */
    var $notificationType;

    /*
        Notification Type:
        1 - Chat
        2 - Win Bid
        3 - Add Bid
        4 - Job Listing Payment
        5 - Job Payment
    */

    /* Insert Chat Notification */
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

    /*Insert Bid Winner Notification*/
    function bidWinnerNotification($jobId=0, $userId=0){
        $notificationType = 2;
        $posterIdSql = mysql_query("SELECT job_user_id FROM tbljobs WHERE job_id=".$jobId." ");
        $posterIdArray = mysql_fetch_assoc($posterIdSql);
        $posterId = $posterIdArray['job_user_id'];
        $paramenterArray = array(
            'job_id' => $jobId,
            'sender_id' => $senderId,
        );
        $paramenterSerialize = serialize($paramenterArray);

    }

}

?>