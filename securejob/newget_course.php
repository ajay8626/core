<script src="js/jquery.min.js"></script>
<?php
include "config.php";
$cateId=$_GET['cateid'];
//echo "<pre>";print_r($_GET['cateid']);exit;
$pagenumber=isset($_GET['page'])?$_GET['page']:1;
$pagelimit=3;
$start=(($pagenumber - 1) * $pagelimit);
$sort=isset($_GET['sort'])?$_GET['sort']:'';
$search=isset($_GET['search'])?$_GET['search']:'';

$user_id=isset($_SESSION['user_id']) ? $_SESSION['user_id'] :0 ;
$userdetails=mysql_query("select * from tbluser where user_id='".$user_id."'");
$rowcount1=mysql_num_rows($userdetails);   

if($rowcount1 > 0)
{
    $userdata=mysql_fetch_array($userdetails);
    $firstname=$userdata['firstname'];
    $lastname=$userdata['lastname'];
    $email=$userdata['email'];
}
else
{
    $firstname='';
    $lastname='';
    $email='';
}

$data='';

$orderby=' order by tblcoursemaster.price desc';

if($sort!='' && $sort=='priceh')
{
	$orderby='order by tblcoursemaster.price desc';
}
if($sort!='' && $sort=='pricel')
{
	$orderby=' order by tblcoursemaster.price asc';
}
$searchtxt='';
if($search!='')
{
	$searchtxt=" and (tblcoursemaster.course_title like '%".$search."%' OR tblcoursemaster.description like '%".$search."%' OR tblcoursemaster.price like '%".$search."%' OR tblcoursemaster.location like '%".$search."%' OR tblcoursemaster.specify_days like '%".$search."%')";
}

if ($search!='') {

	$newcourse=mysql_query("select tblcoursemaster.*,tuser.verified_user from tblcoursemaster
	    LEFT JOIN tbluser AS tuser ON tblcoursemaster.created_by = tuser.user_id
	    where tblcoursemaster.status=1 and tuser.verified_user = 1 ".$searchtxt." ".$orderby." LIMIT $start,$pagelimit");
    $newrow=mysql_num_rows($newcourse);
} else {

	$newcourse=mysql_query("select tblcoursemaster.*,tuser.verified_user from tblcoursemaster
	LEFT JOIN tbluser AS tuser ON tblcoursemaster.created_by = tuser.user_id 
	where tblcoursemaster.category_id = $cateId AND tblcoursemaster.status=1 and tuser.verified_user = 1".$searchtxt." ".$orderby." LIMIT $start,$pagelimit");
	$newrow=mysql_num_rows($newcourse);
}

if($newrow > 0)
{
   while($rows=mysql_fetch_array($newcourse))
   {
				
		$start_date  = date('d F Y',strtotime($rows["start_date"]));
		$courseimage = $rows["image"];

		$stime = '';
		if ($rows['start_time'] != '') {
			$stime = explode(":", $rows['start_time']);
			$shrs = $stime[0];
	    	$smin = $stime[1];                 	
	    	$stime = $shrs.":".$smin;
		}
		
		
		$img="images/crs1.jpg";
		if($courseimage!='')
		{
			$img=SITE_URL."course/images/".$courseimage;
		}
        
        if(isset($_SESSION['user_id'])) {

        /*check for profile start*/

       
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
					
					$pymnt_pop ='<a class="a_apply" href="#" data-toggle="modal" data-target="#myModal">Apply for course</a>';
					
				}else{
					$pymnt_pop ='<a class="a_apply" href="#" data-toggle="modal" data-target="#addCredites-'.$rows['course_id'].'">Apply for course</a>';
							
				}
				
			}

			if($customer_type == 1)
			{		
				
				if ($detail_row1 < 1 || $comp_certi_detail_row < 1 || $license_passport_detail_row < 1) {
					
					$pymnt_pop ='<a class="a_apply" href="#" data-toggle="modal" data-target="#myModal">Apply for course</a>';
					
				}else{
					$pymnt_pop ='<a class="a_apply" href="#" data-toggle="modal" data-target="#addCredites-'.$rows['course_id'].'">Apply for course</a>';
				}
				
			}
		/*check for profile end*/
	 } else {
        	unset($_SESSION['page_name']);
         	$_SESSION['page_name'] = 'newcourse.php';
         	$_SESSION['cateId'] = $cateId;
            $pymnt_pop ='<a class="a_apply" href="login.php">Apply for course</a>';
        }
        //echo "<pre>";print_r($pymnt_pop);exit;

        $file_headers = @get_headers($img);

		if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
		    $exists = "false";
		}
		else {
		    $exists = "true";
		}
        if ($exists == "false") {
        	$img=SITE_URL."course/images/default.png";
        }
        
		$data.='<li>
                  			<div class="crs_list_lft">
                  				<img src="'.$img.'" alt=""/>
                  			</div>
                  			<div class="crs_list_rgt">
                  			    <h3>'.$rows['course_title'].' ('.$rows['course_body'].')</h3>
                  				<div class="crs_lr_lft">
                  					<p>Location: <span>'.$rows['location'].'</span></p>
                  					<p>Date: <span>'.$start_date.'</span></p>
                  					<p>Time: <span>'.$stime.'</span></p>
                  					<p>Price: <span><b>£'.$rows['price'].'</b></span></p>
                  					<p>Duration: <span>'.$rows['duration']." Days".'</span></p>
                  				</div>
                  				<div class="crs_lr_rgt">
                  					<a href="newcourse_details.php?course_id='.$rows['course_id'].'">More about course</a>
                  					'.$pymnt_pop.'
                  				</div>
                  			</div>
                  		</li>';
       //echo "<pre>";print_r($rows['course_id']);exit;
        $data.='<div class="modal fade addCredites_cls" id="addCredites-'.$rows['course_id'].'">
					<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
					
						<!-- Modal Header -->
						<h2 class="modal-title">Course Payment</h2>
						<!-- <div class="modal-header">
						<h4 class="modal-title">Add Credit</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div> -->
						
						<!-- Modal body -->
						<div class="modal-body paypal_btn">
						
						<!-- Directly Pay with Credit -->
							<!-- Add Credit -->
							<form action="paypal/payments.php" method="post" id="paypal_form">
                                <label for="firstname" style="display:block">First Name</label>
                                <input type="text" name="firstname" value="'.$firstname.'"  />
                                <label for="lastname" style="display:block">Last Name</label>
								<input type="text" name="lastname" value="'.$lastname.'"  />
                                <label for="email" style="display:block">Email</label>
								<input type="text" name="email" value="'.$email.'"  />
								<input type="hidden" name="cmd" value="_xclick" />
								<input type="hidden" name="no_note" value="1" />
								<input type="hidden" name="lc" value="UK" />
								<input type="hidden" name="currency_code" value="GBP" />
								<input type="hidden" name="rm" value="2">
								<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
                                <input type="hidden" name="amount" value="'.$rows['price'].'"  />
                                <input type="hidden" name="item_name" value="'.$rows['name'].'" />
                                <input type="hidden" name="item_number" value="'.$rows['course_id'].'" />
                                <input type="hidden" name="user_id" value="'.$user_id.'" />
                                <input type="hidden" name="custom" value="course_payment_with_paypal" />
                                <br>
                                <br>
								<input type="submit" name="paypal" class="add_credit_btn" value="Pay with Paypal"/>
							</form>
						</div>
						
						<!-- Modal footer -->
						<div class="modal-footer">
						<button type="button" class="btn fees-modal-button" data-dismiss="modal">Close</button>
						</div>
						
					</div>
					</div>
				</div>';                
   }
}   
//$data.='</ul>';
echo $data;
exit;

?>