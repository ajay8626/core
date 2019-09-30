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
	$user_cond= " and job_user_id=".$_SESSION['user_id']."";
}


$featurejob=mysql_query("select tbljobs.* from tbljobs  LEFT JOIN tbljobcategories ON tbljobs.job_id=tbljobcategories.job_id LEFT JOIN tbljobstatus ON tbljobs.job_id=tbljobstatus.job_id where  tbljobs.status=1 and tbljobs.job_status=3  ".$catjoin." ".$user_cond." ".$searchtxt." group by tbljobs.job_id ".$orderby." LIMIT $start,$pagelimit");
$frow=mysql_num_rows($featurejob);
$data='';
if($frow > 0)
{
	
   while($rows=mysql_fetch_array($featurejob))
   {
	   
	   $finalizeamount=0;
       $getfinal = mysql_query ("select bidprice as hourrate , no_of_persons as total_persons from tbljobsapplied where job_id=".$rows["job_id"]." and is_winner=1");
		 if(mysql_num_rows($getfinal)){
			while($result = mysql_fetch_assoc($getfinal))
			{	
					$total=$result['hourrate'] * $result['total_persons'] *   $rows['job_days'] *  $rows['job_hours'];
					$finalizeamount=$finalizeamount+$total;
				
			}	
		 }
	   
	   
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
		$data.='<li>
                    				    '.$FeatuerdData.'
                    					<div class="stj_jl_img">
											<a class="a_pyb" href="biddetails.php?job_id='.$rows["job_id"].'&flag=ongoing"><div class="gnrt_img" style="background-image: url('.$img.');"></div></a>
                    					</div>
                    					<div class="stj_jl_dtl">
											<a class="a_pyb" href="biddetails.php?job_id='.$rows["job_id"].'&flag=ongoing"><h2>'.$rows['job_name'].'</h2></a>
                    						<h5>('.$jobcategory.')</h5>
                    						<div class="stj_jd_cn">
                    							<p>Location: <span>'.$rows['job_location'].'</span></p>
                    							<p>Duration: <span>'.$rows['job_days'].' Days ('.$rows['job_hours'].' hours per day)</span></p>
                    						</div>
                    						<div class="stj_jd_cn">
                    							
                    							<p>Opening Positions: <span>'.$rows['opening_position'].'</span></p>
                    						</div>
                    					</div>
                    					<div class="stj_jl_rgt">
                    						<div class="stj_rating">
                    							
                    						</div>
                    						<div class="stj_jd_cn">
                    							
                    							<p>Finalised Price: <span>£'.number_format($finalizeamount,2).' </span></p>
                    						</div>
                    						<a class="a_pyb" href="biddetails.php?job_id='.$rows["job_id"].'&flag=ongoing">Details</a>
                    						
                    					</div>
                    				</li>';
   }
}
echo $data;
exit;

?>