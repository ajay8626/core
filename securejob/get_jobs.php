<?php
include "config.php";

$pagenumber=isset($_GET['page'])?$_GET['page']:1;
$pagelimit=4;
$start=(($pagenumber - 1) * $pagelimit);
$category=isset($_GET['category'])?$_GET['category']:'';
$sort=isset($_GET['sort'])?$_GET['sort']:'';
$search=isset($_GET['search'])?$_GET['search']:'';
$radiuscat=isset($_GET['radiuscat']) ? $_GET['radiuscat']:'';
$user_id=isset($_SESSION['user_id'])?$_SESSION['user_id']:0;

$lat='';
$long='';

if($user_id!='' && $user_id!=0)
{
	$lat=getlatitude($user_id);
	$long=getlongitude($user_id);
} 

$orderby=' order by tbljobs.isfeatured DESC , tbljobs.job_id desc';
if($sort!='' && $sort=='newest')
{
	$orderby='order by tbljobs.isfeatured DESC ,tbljobs.job_id desc';
}
if($sort!='' && $sort=='oldest')
{
	$orderby=' order by tbljobs.isfeatured DESC ,tbljobs.job_id asc';
}
if($sort!='' && $sort=='priceh')
{
	$orderby='order by tbljobs.isfeatured DESC ,tbljobs.price desc';
}
if($sort!='' && $sort=='pricel')
{
	$orderby=' order by tbljobs.isfeatured DESC ,tbljobs.price asc';
}


$catjoin='';
$searchtxt='';
$radiusjoin='';
if($category!='')
{
 $catjoin=' and tbljobcategories.category_id IN ('.$category.')';	
}

$or='';
$flag=0;

if($radiuscat!='')
{
	$radiusjoin=' and (';
	$or='OR';
	$radiusarr=explode(",",$radiuscat);
	foreach($radiusarr as $vals)
	{
		if($vals==1)
		{
			$flag=1;
			$radiusjoin .=" getDistancemiles(tbljobs.latitude,tbljobs.longitude,".$lat.",".$long.") <= 1 OR";
		}
		if($vals==2)
		{
			$flag=1;
			$radiusjoin .=" (getDistancemiles(tbljobs.latitude,tbljobs.longitude,".$lat.",".$long.") >= 1 AND getDistancemiles(tbljobs.latitude,tbljobs.longitude,".$lat.",".$long.") <=5 ) OR ";
		}
		if($vals==3)
		{
			$flag=1;
			$radiusjoin .=" (getDistancemiles(tbljobs.latitude,tbljobs.longitude,".$lat.",".$long.") >= 5 AND getDistancemiles(tbljobs.latitude,tbljobs.longitude,".$lat.",".$long.") <=10) OR ";
		}
		if($vals==4)
		{
			$flag=1;
			$radiusjoin .=" (getDistancemiles(tbljobs.latitude,tbljobs.longitude,".$lat.",".$long.") >= 10 AND getDistancemiles(tbljobs.latitude,tbljobs.longitude,".$lat.",".$long.") <=15)  OR";
		}
		if($vals==5)
		{
			$flag=1;
			$radiusjoin .=" ( getDistancemiles(tbljobs.latitude,tbljobs.longitude,".$lat.",".$long.") >= 15 ) OR ";
		}
		
		
	}
	
	$radiusjoin .=" 1 )  ";
} 



/*
if($radiuscat!='' && $radiuscat==1)
{
	$radiusjoin=" and getDistancemiles(tbljobs.latitude,tbljobs.longitude,".$lat.",".$long.") <= 1";
}

if($radiuscat!='' && $radiuscat==2)
{
	$radiusjoin=" and getDistancemiles(tbljobs.latitude,tbljobs.longitude,".$lat.",".$long.") <= 5";
}

if($radiuscat!='' && $radiuscat==3)
{
	$radiusjoin=" and getDistancemiles(tbljobs.latitude,tbljobs.longitude,".$lat.",".$long.") <= 10";
}

if($radiuscat!='' && $radiuscat==4)
{
	$radiusjoin=" and getDistancemiles(tbljobs.latitude,tbljobs.longitude,".$lat.",".$long.") <= 15";
}

if($radiuscat!='' && $radiuscat==5)
{
	$radiusjoin=" and getDistancemiles(tbljobs.latitude,tbljobs.longitude,".$lat.",".$long.") > 15";
}
 */

if($search!='')
{
	$searchtxt=" and (tbljobs.job_name like '%".$search."%' OR tbljobs.job_description like '%".$search."%' OR tbljobs.price like '%".$search."%' OR tbljobs.job_location like '%".$search."%' OR tbljobs.job_days like '%".$search."%')";
}

$user_cond='';
if(isset($_SESSION['user_id']) && $_SESSION['user_id']!='')
{
	$user_cond= " and job_user_id!=".$_SESSION['user_id']."";
}


	
$featurejob=mysql_query("select tbljobs.* from tbljobs  LEFT JOIN tbljobcategories ON tbljobs.job_id=tbljobcategories.job_id LEFT JOIN tbljobstatus ON tbljobs.job_id=tbljobstatus.job_id where  tbljobs.status=1 and tbljobs.job_status=1 and tbljobs.start_date >='".date("Y-m-d h:i:s")."' ".$catjoin." ".$radiusjoin." ".$user_cond." ".$searchtxt." group by tbljobs.job_id ".$orderby." LIMIT $start,$pagelimit");
$frow=mysql_num_rows($featurejob);

//echo "<pre>";print_r($frow);exit;

$data='';
if($frow > 0)
{
	
   while($rows=mysql_fetch_array($featurejob))
   {
		$jobcategory=jobcatlist($rows["job_id"]);
		$curdatetime=date('Y-m-d h:i:s');
		$start_date = new DateTime($rows['start_date']);
		$since_start = $start_date->diff(new DateTime($curdatetime));
		$jobimage=jobimage($rows["job_id"]);
		$img="images/list1.png";
		$isFeatured = $rows["isfeatured"];
		$FeatuerdData = "";
		if($isFeatured  == 1){
			$FeatuerdData  = "<div class='stj_si'><span>Featured</span></div>";
		}
		if($jobimage!='')
		{
			$img=JOBS_IMG_URL.$jobimage;
		}
		
		$text='<p>Highest Bid: <span>£'.round(maxbidprice($rows["job_id"])).' per hour per person</span></p>';
		if(round(maxbidprice($rows["job_id"]))==0)
		{
			$text='<p>No Bids</p>';
		}
        
        $job_type = $rows["job_type"];
        $job_type_txt='';
        if(isset($job_type) && $job_type==1)
        {
            $job_type_txt='Part Time';
        }
        if(isset($job_type) && $job_type==2)
        {
            $job_type_txt='Full Time';
        }

		$jobIdCheck = $rows["job_id"];
		$check_visits = mysql_query("SELECT totalvisit FROM tbltotalview WHERE job_id='$jobIdCheck' ");
		$check_visit = mysql_fetch_array($check_visits);
		$totalVisits = $check_visit['totalvisit'];
		$jobURL = SITE_URL.'place-bid.php?job_id='.$jobIdCheck;
		
		$data.='<li>
				'.$FeatuerdData.'
				
				<div class="stj_jl_img">
					<a class="a_pyb" href="place-bid.php?job_id='.$rows["job_id"].'"><div class="gnrt_img" style="background-image: url('.$img.');"></div></a>
				</div>
				<div class="stj_jl_dtl">
					<a class="a_pyb" href="place-bid.php?job_id='.$rows["job_id"].'"><h2>'.$rows['job_name'].'</h2></a>
					<h5>('.$jobcategory.')</h5>
					<div class="stj_jd_cn">
						<p>Location: <span>'.$rows['job_location'].'</span></p>
						<p>Duration: <span>'.$rows['job_days'].' Days ('.$rows['job_hours'].' hours per day)</span></p>
						<p>Bid Amount: <span> £'.$rows['price'].'</span></p>
                        <p>Job Type: <span>'.$job_type_txt.'</span></p>
					</div>
					
				</div>
				<div class="stj_jl_rgt">
					<div class="stj_rating">
						'.getPosterFeedback($rows["job_id"]).'
					</div>
					
					<div class="stj_jd_cn">
						<p>Total Bids: <span>'.bidsCount($rows["job_id"]).' Bid(s)</span></p>
						'.$text.'
						<p>Total Views: <span>'.$totalVisits.'</span></p>
					</div>';


					

					/*check for profiel start*/
					$customer_type =  $_SESSION['customer_type'];		
					$user_email = $_SESSION['user_email'];
					$user_id = $_SESSION['user_id'];

					//echo "<pre>";print_r($customer_type);exit;
					
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


						/*check user is verified or not*/
						$user_id= $_SESSION['user_id'];
						$user_status_query = mysql_query("select verified_user from tbluser WHERE user_id = '".$user_id."'");
						while($user_status = mysql_fetch_assoc($user_status_query)){

							$user_sts = $user_status['verified_user'];
							
						}


						if (isset($user_sts) && $user_sts == 0) {
							$user_sts = 0;
						}else{
							$user_sts = 1;
						}

						
						
						if ($customer_type == 2) 
						{
							
							if ($user_sts == 0) {
								$data.='<a class="a_pybb" href="#" data-toggle="modal" data-target="#admin_call">Place your bid</a>';
							} else {
								
								if ($detail_row2 < 1 || $utility_detail_row < 1 || $certificate_detail_row < 1)
									{ 
									$data.='<a class="a_pybb" href="#" data-toggle="modal" data-target="#myModalbid">Place your bid</a>';
									}else{ 
									$data.='<a class="a_pybb" href="place-bid.php?job_id='.$rows["job_id"].'">Place your bid</a>';
												
									}

							}
							

							
							
						}

						if($customer_type == 1)
						{		
							
							if ($user_sts == 0) {
								$data.='<a class="a_pybb" href="#" data-toggle="modal" data-target="#admin_call">Place your bid</a>';
							} else {
								if ($detail_row1 < 1 || $comp_certi_detail_row < 1 || $license_passport_detail_row < 1) { 
								
									$data.='<a class="a_pybb" href="#" data-toggle="modal" data-target="#myModalbid">Place your bid</a>';
								}else{ 
									$data.='<a class="a_pybb" href="place-bid.php?job_id='.$rows["job_id"].'">Place your bid</a>';
									}
									
								}
							}
							

							

					/*check for profiel end */
					/*$data.='<a class="a_pybb" href="place-bid.php?job_id='.$rows["job_id"].'">Place your bid</a>';*/

					if ($user_sts == 0) {
						$data.='<a class="a_pyba" data-toggle="modal" data-target="#admin_call">Apply Now</a>
							</div>
						</li>';
					}else{
						$data.='<a class="a_pyba" onclick="javascript:return applyForJob('.$rows["job_id"].', '.$user_id.', '.$rows["price"].');">Apply Now</a>
					<div class="bid_start">Starts in <span>'.$since_start->d.'D '.$since_start->h.'H '.$since_start->i.'M</span></div>
				</div>
			</li>';

					}

				
   }
   //$data.='</ul>';
}

echo $data;
exit;

?>