<?php
session_start();
require_once 'config.php';
$customer_type =  $_SESSION['customer_type'];
$user_email = $_SESSION['user_email'];
$user_id = $_SESSION['user_id'];

if ($customer_type == 1) {
		$customer_1 = "SELECT tusr.* FROM tbluser AS tusr WHERE tusr.email ='".$user_email."' AND tusr.company_name != '' AND tusr.firstname != '' AND tusr.lastname != '' AND tusr.address_1 != '' AND tusr.postal_code != '' AND tusr.reg_no != '' AND tusr.reg_vat_no != '' AND tusr.email != '' AND tusr.phone != '' AND tusr.paypal_email != ''";
		$sql_detail=mysql_query($customer_1);
		
		
		$comp_certi ="select comp_certi FROM tbl_user_comp_certi WHERE user_id = '".$user_id."'";
		$comp_certi_detail=mysql_query($comp_certi);

		$license_passport ="select license_passport FROM tbl_user_license_passport WHERE user_id = '".$user_id."'";
		$license_passport_detail=mysql_query($license_passport);

		
		$detail_row1=mysql_num_rows($sql_detail);		
		$comp_certi_detail_row=mysql_num_rows($comp_certi_detail);
		$license_passport_detail_row=mysql_num_rows($license_passport_detail);
		
	}else{
		$customer_2 = "SELECT tusr.*,tulp.license_passport FROM tbluser AS tusr LEFT JOIN tbl_user_license_passport AS tulp ON tusr.user_id = tulp.user_id LEFT JOIN tbl_user_comp_certi AS ucc ON tusr.user_id = ucc.user_id WHERE tusr.email ='".$user_email."' AND tusr.firstname != '' AND tusr.lastname != '' AND tusr.address_1 != '' AND tusr.postal_code != '' AND tusr.email != '' AND tusr.phone != '' AND tusr.birthdate != '' AND tusr.gender != '' AND tusr.height != '' AND tusr.build != '' AND tusr.nationality != '' AND tusr.language != '' AND tusr.militry != '' AND tusr.drive != '' AND tusr.firstaid != '' AND tusr.paremedic != '' AND tusr.tattoos != '' AND tusr.piercing != '' AND tusr.paypal_email != '' AND tusr.right_to_work_uk != '' AND tusr.willing_to_travel != '' AND tusr.sia != '' AND tusr.how_far_willing_to_travel != '' AND tusr.activity != '' AND tusr.health != '' AND tusr.bio != '' AND tusr.experience != '' AND tusr.education_credentials != '' AND tulp.license_passport != '' AND tusr.uk_driving_license != ''";
		
		$sql_detail=mysql_query($customer_2);

		$utility ="select utility FROM tbl_user_utility WHERE user_id = '".$user_id."'";
		$utility_detail=mysql_query($utility);

		$certificate ="select certificate FROM tbl_user_certi WHERE user_id = '".$user_id."'";
		$certificate_detail=mysql_query($certificate);

		$detail_row2=mysql_num_rows($sql_detail);
		$utility_detail_row=mysql_num_rows($utility_detail);
		$certificate_detail_row=mysql_num_rows($certificate_detail);
		
	}



	if ($customer_type == 2) 
	{
		

		if ($detail_row2 < 1 || $utility_detail_row < 1 || $certificate_detail_row < 1)
		{				
			//header("Location:profile-edit.php");
			$return = array('data' => 0);
			echo json_encode($return);
			exit();
		}else{
			//header("Location:add-course.php");
			$return = array('data' => 1);
			echo json_encode($return);
			exit();				
		}
		
	}

	if($customer_type == 1)
	{		
		
		if ($detail_row1 < 1 || $comp_certi_detail_row < 1 || $license_passport_detail_row < 1) {
			
			//header("Location:profile-edit.php");
			$return = array('data' => 0);
			echo json_encode($return);
			exit();
		}else{
			//header("Location:add-course.php");
			$return = array('data' => 1);
			echo json_encode($return);
			exit();
		}
		
	}




?>