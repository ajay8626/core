<?php
include "config.php";

$pagenumber=isset($_GET['page'])?$_GET['page']:1;
$pagelimit=5;
$start=(($pagenumber - 1) * $pagelimit);
$category=isset($_GET['category'])?$_GET['category']:'';
$sort=isset($_GET['sort'])?$_GET['sort']:'';
$search=isset($_GET['search'])?$_GET['search']:'';

$orderby=' order by tbljobs.isfeatured DESC, tbljobs.job_id desc';
if($sort!='' && $sort=='newest')
{
	$orderby='order by tbljobs.isfeatured DESC,tbljobs.job_id desc';
}
if($sort!='' && $sort=='oldest')
{
	$orderby=' order by tbljobs.isfeatured DESC,tbljobs.job_id asc';
}
if($sort!='' && $sort=='priceh')
{
	$orderby='order by tbljobs.isfeatured DESC,tbljobs.price desc';
}
if($sort!='' && $sort=='pricel')
{
	$orderby='order by tbljobs.isfeatured DESC,tbljobs.price asc';
}

$catjoin='';
$searchtxt='';
if($category!='')
{
 $catjoin=' and tbljobcategories.category_id IN ('.$category.')';	
}

$user_cond='';
if(isset($_SESSION['user_id']) && $_SESSION['user_id']!='')
{
	$user_cond= " and tbljobs.job_user_id=".$_SESSION['user_id']."";
}

if($search!='')
{
	$searchtxt=" and (tbljobs.job_name like '%".$search."%' OR tbljobs.job_description like '%".$search."%' OR tbljobs.price like '%".$search."%' OR tbljobs.job_location like '%".$search."%' OR tbljobs.job_days like '%".$search."%')";
}




$data='';
$newjob=mysql_query("select tbljobs.* from tbljobs LEFT JOIN tbljobcategories ON tbljobs.job_id=tbljobcategories.job_id LEFT JOIN tbljobstatus ON tbljobs.job_id=tbljobstatus.job_id where tbljobs.status=1 and tbljobs.job_status=4 and tbljobstatus.status=4 ".$catjoin." ".$searchtxt." ".$user_cond." group by tbljobs.job_id ".$orderby." LIMIT $start,$pagelimit");
$newrow=mysql_num_rows($newjob);
if($newrow > 0)
{
   while($rows=mysql_fetch_array($newjob))
   {
		$jobcategory=jobcatlist($rows["job_id"]);
		$curdatetime=date('Y-m-d h:i:s');
		$start_date = new DateTime($rows['start_date']);
		$since_start = $start_date->diff(new DateTime($curdatetime));
		$jobimage=jobimage($rows["job_id"]);
		$img="images/list1.png";
		if($jobimage!='')
		{
			$img=JOBS_IMG_URL.$jobimage;
		}
		$isFeatured = $rows["isfeatured"];
		
		$final_amount=$rows['final_amount'];
		$FeatuerdData = "";
		if($isFeatured  == 1){
			$FeatuerdData  = "<div class='stj_si'><span>Featured</span></div>";
		}

		$job_id_rate = $rows["job_id"];
		$rateUrl = SITE_URL."biddetails.php?job_id=".$job_id_rate."&flag=complete";
		
		$data.='<li>                     '.$FeatuerdData.'
                    					<div class="stj_jl_img">
											<a class="a_pyb" href="'.$rateUrl.'"><div class="gnrt_img" style="background-image: url('.$img.');"></div></a>
                    					</div>
                    					<div class="stj_jl_dtl">
											<a class="a_pyb" href="'.$rateUrl.'"><h2>'.$rows['job_name'].'</h2></a>
                    						<h5>('.$jobcategory.')</h5>
                    						<div class="stj_jd_cn">
                    							<p>Location: <span>'.$rows['job_location'].'</span></p>
                    							<p>Duration: <span>'.$rows['job_days'].' Days ('.$rows['job_hours'].' hours per day)</span></p>
												<p>Finalised Price: <span><b>£'.$final_amount.'</b></span></p>
                    						</div>
                    						
                    					</div>
                    					<div class="stj_jl_rgt">
                    						<div class="stj_rating">
                    							'.getUserFeedbackReview($job_id_rate).'
                    						</div>
                    						<div class="stj_rating">
											'.getPosterFeedbackReview($job_id_rate).'
                    						</div>
                    						<a class="a_pyb" href="'.$rateUrl.'">Rate</a>
                    					</div>
                    				</li>';
   }
}   
//$data.='</ul>';
echo $data;
exit;

?>