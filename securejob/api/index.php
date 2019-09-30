<?php
/*

Authenticate : base64_encode(userid:token)
eg. base64_encode(30:3035581482397017)

*/
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$json = file_get_contents('php://input');
	$rqst_data = json_decode($json);

	if(isset($rqst_data->function) || isset($_REQUEST['function'])){
		
		
		if(!isset($rqst_data->function)) {
			$rqst_data->function = null;
		}
		
		if(!isset($_REQUEST['function'])) {
			$_REQUEST['function'] = null;
		}
			
		if($rqst_data->function == 'checkVersion'){
			include_once "version_check.php";
		}else if($rqst_data->function == 'customerReg'){
			include_once "customer_reg.php";
		}else if($rqst_data->function == 'pay_invoice'){
			include_once "pay_invoice.php";	
		}else if($rqst_data->function == 'userLogin'){
			include_once "login.php";
		}else if($rqst_data->function == 'get_time_slot'){
			include_once "get_time_slot.php";
		}else if($rqst_data->function == 'get_postcode'){
			include_once "get_postcode.php";
		} else if($rqst_data->function == 'get_postcode_customer'){
			include_once "get_postcode_customer.php";
		} else if($rqst_data->function == 'add_appointment'){
			include_once "add_appointment.php";
		} else if($rqst_data->function == 'forgotPassword'){
				include_once "forgotPassword.php";
		}else if($rqst_data->function == 'userRecommendation'){
				include_once "userRecommendation.php";
		}else if($rqst_data->function == 'update_appointment'){
				include_once "update_appointment.php";
		}else if($rqst_data->function == 'delete_appointment'){
				include_once "delete_appointment.php";
		}else if($rqst_data->function == 'cleaner_list'){
				include_once "cleaner_list.php";
        }else if($rqst_data->function == 'appoinment_detail'){
				include_once "appointment_detail.php";
        }else if($rqst_data->function == 'assign_cleaner'){
				include_once "assign_cleaner.php";
        }else if($rqst_data->function == 'update_manager'){
				include_once "update_manager.php";
        }else if($rqst_data->function == 'update_cleaner'){
				include_once "update_cleaner.php";				
		}else if($rqst_data->function == 'getMessage'){
				include_once "get_messages.php";
		}else if($rqst_data->function == 'upcoming_appoinment'){
				include_once "upcoming_appoinment.php";
		}else if($rqst_data->function == 'change_appointment'){
				include_once "change_appointment.php";		
		}else if($rqst_data->function == 'crashReport'){
			include_once "CrashReport.php";
		}else if($rqst_data->function == 'get_day_time_slot'){
			include_once "get_day_time_slot.php";
		}else if($rqst_data->function == 'test'){
			include_once "test.php";
		}else if(isset($_SERVER['HTTP_AUTHENTICATE']) && $_SERVER['HTTP_AUTHENTICATE'] != ''){
			if($rqst_data->function == 'topicList'){
				
				include_once "topics.php";
			}else{
				$final_array = array('message'=>'Invalid Function! '.$rqst_data->function,'status'=>0);
				echo $json= json_encode($final_array);
			}
		}else{
			
			$final_array = array('message'=>'Authenticate Required!','status'=>0);
			echo $json= json_encode($final_array);
		}	
	}else{
		
		$final_array = array('message'=>'Function Required!','status'=>0);
		echo $json= json_encode($final_array);
	}
}
include("../config.php");
$data = "json : ";
$data .= print_r($rqst_data, true);
$data .= '<br> --------------------------------- <br>';
$data .= "Form Data : ";
$data .= print_r($_REQUEST, true);
$data .= '<br> --------------------------------- <br>';
$data .= print_r($_FILES, true);

$emailto = 'komal@webtechsystem.com';
$subject1 = 'Test paramters';
//$chk = sendMsg($emailto, $subject1, $data);
?>