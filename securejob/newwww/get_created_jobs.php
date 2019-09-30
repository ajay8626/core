<!-- <script src="social-share/dist/jquery.shares.js"></script>
<script>
  $(document).ready(function(){
    $('a.share').shares();
  });
</script> -->
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
	$user_cond= " and job_user_id=".$_SESSION['user_id']."";
}


	
$featurejob=mysql_query("select tbljobs.* from tbljobs  LEFT JOIN tbljobcategories ON tbljobs.job_id=tbljobcategories.job_id LEFT JOIN tbljobstatus ON tbljobs.job_id=tbljobstatus.job_id where  tbljobs.status=1   ".$catjoin." ".$radiusjoin." ".$user_cond." ".$searchtxt." group by tbljobs.job_id ".$orderby." LIMIT $start,$pagelimit");
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
						</div>
						
					</div>
					<div class="stj_jl_rgt">
						<div class="stj_rating">
						'.getPosterFeedback($rows["job_id"]).'
						</div>
						<div class="stj_jd_cn">
							<p>Total Bids: <span>'.bidsCount($rows["job_id"]).' Bid(s)</span></p>
							'.$text.'
						</div>
						<div class="stj_jd_cn">
							<p>Total Views: <span>'.$totalVisits.'</span></p>
							<a class="a_pyb" href="biddetails.php?job_id='.$rows["job_id"].'">Details</a>
						</div>
						
						
					</div>
				</li>';
   }
   //$data.='</ul>';
}



echo $data;
exit;

?>