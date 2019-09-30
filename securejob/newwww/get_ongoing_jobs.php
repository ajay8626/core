<?php
include "config.php";

$pagenumber=isset($_GET['page'])?$_GET['page']:1;
$pagelimit=4;
$start=(($pagenumber - 1) * $pagelimit);
$category=isset($_GET['category'])?$_GET['category']:'';
$sort=isset($_GET['sort'])?$_GET['sort']:'';
$search=isset($_GET['search'])?$_GET['search']:'';

$orderby='order by tbljobs.isfeatured DESC , tbljobs.job_id desc';
if($sort!='' && $sort=='newest')
{
	$orderby='order by tbljobs.isfeatured DESC ,tbljobs.job_id desc';
}
if($sort!='' && $sort=='oldest')
{
	$orderby='order by tbljobs.isfeatured DESC ,tbljobs.job_id asc';
}
if($sort!='' && $sort=='priceh')
{
	$orderby='order by tbljobs.isfeatured DESC ,tbljobs.price desc';
}
if($sort!='' && $sort=='pricel')
{
	$orderby='order by tbljobs.isfeatured DESC ,tbljobs.price asc';
}

$catjoin='';
$searchtxt='';
if($category!='')
{
 $catjoin=' and tbljobcategories.category_id IN ('.$category.')';	
}

if($search!='')
{
	$searchtxt=" and (tbljobs.job_name like '%".$search."%' OR tbljobs.job_description like '%".$search."%' OR tbljobs.price like '%".$search."%' OR tbljobs.job_location like '%".$search."%' OR tbljobs.job_days like '%".$search."%')";
}

$user_cond='';
if(isset($_SESSION['user_id']) && $_SESSION['user_id']!='')
{
	$user_cond= " and job_user_id!=".$_SESSION['user_id']."";
}



$featurejob=mysql_query("select tbljobs.*,tbljobstatus.status as jobstatus,tbljobsapplied.bidprice as finalprice from tbljobs  LEFT JOIN tbljobcategories ON tbljobs.job_id=tbljobcategories.job_id LEFT JOIN tbljobstatus ON tbljobs.job_id=tbljobstatus.job_id LEFT JOIN  tbljobsapplied ON tbljobs.job_id=tbljobsapplied.job_id where  tbljobs.status=1 and tbljobs.job_status=3  ".$catjoin." ".$user_cond." and tbljobs.payment_status=1 ".$searchtxt." and tbljobsapplied.user_id=".$_SESSION['user_id']."    group by tbljobs.job_id ".$orderby." LIMIT $start,$pagelimit");
$frow=mysql_num_rows($featurejob);
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
		$isFeatured = $rows["isfeatured"];
		$FeatuerdData = "";
		if($isFeatured  == 1){
			$FeatuerdData  = "<div class='stj_si'><span>Featured</span></div>";
		}
		$img="images/list1.png";
		if($jobimage!='')
		{
			$img=JOBS_IMG_URL.$jobimage;
		}
		
		$userjobstatus=$rows['jobstatus'];
		$userstatus='OnGoing';
		if($userjobstatus==3)
		{
			$userstatus='In Progress';
		}
        if($userjobstatus==4)
		{
			$userstatus='Completed';
		}		
		$userfinalprice=($rows['finalprice']);
		

		// $finalizedPriceSql = "SELECT bidprice, no_of_persons FROM tbljobsapplied WHERE tbljobsapplied.job_id=".$rows["job_id"]." AND tbljobsapplied.user_id=".$_SESSION['user_id']." AND is_winner=1";
		// // $finalizedPriceArray = mysql_fetch_array($finalizedPriceSql);
		// // $finalizedPrice = $finalizedPriceArray['bidprice'];

		$data.='<li>
					'.$FeatuerdData.'
					<div class="stj_jl_img">
						<a class="a_pyb" href="search_job_confirmed.php?job_id='.$rows["job_id"].'&flag=ongoing""><div class="gnrt_img" style="background-image: url('.$img.');"></div></a>
					</div>
					<div class="stj_jl_dtl">
						<a class="a_pyb" href="search_job_confirmed.php?job_id='.$rows["job_id"].'&flag=ongoing""><h2>'.$rows['job_name'].'</h2></a>
						<h5>('.$jobcategory.')</h5>
						<div class="stj_jd_cn">
							<p>Location: <span>'.$rows['job_location'].'</span></p>
							<p>Duration: <span>'.$rows['job_days'].' Days ('.$rows['job_hours'].' hours per day)</span></p>
						</div>
						
					</div>
					<div class="stj_jl_rgt">
						<div class="stj_rating">
							'.getPosterFeedback($rows["job_id"]).'
						</div>
						<div class="stj_jd_cn">
							<p>Job Status: <span>'.$userstatus.'</span></p>
							<p>Finalised Price: <span>£'.$userfinalprice.' per hour per person</span></p>
						</div>
						<a class="a_pyb" href="search_job_confirmed.php?job_id='.$rows["job_id"].'&flag=ongoing"">View Details</a>
						
					</div>
				</li>';
   }
   //$data.='</ul>';
}
echo $data;
exit;

?>