<?php
include "config.php";

$pagenumber=isset($_GET['page'])?$_GET['page']:1;
$pagelimit=4;
$start=(($pagenumber - 1) * $pagelimit);

$user_id=isset($_SESSION['user_id'])?$_SESSION['user_id']:0;
$jobTitle=isset($_GET['jobTitle'])?$_GET['jobTitle']:'';
$openingType=isset($_GET['openingType'])?$_GET['openingType']:'';
$jobLocation=isset($_GET['jobLocation'])?$_GET['jobLocation']:'';
$jobCategory=isset($_GET['jobCategory'])?$_GET['jobCategory']:'';
$riskMeter=isset($_GET['riskMeter'])?$_GET['riskMeter']:'';
$featuredJob=isset($_GET['featuredJob'])?$_GET['featuredJob']:'';
$transportLink=isset($_GET['transportLink'])?$_GET['transportLink']:'';
$dressCode=isset($_GET['dressCode'])?$_GET['dressCode']:'';
$jobPrice=isset($_GET['jobPrice'])?$_GET['jobPrice']:'';
$startDate=isset($_GET['startDate'])?$_GET['startDate']:'';
$endDate=isset($_GET['endDate'])?$_GET['endDate']:'';
$jobDays=isset($_GET['jobDays'])?$_GET['jobDays']:'';
$zipMiles=isset($_GET['zipMiles'])?$_GET['zipMiles']:'1';
$lati=isset($_GET['lati'])?$_GET['lati']:'';
$longi=isset($_GET['longi'])?$_GET['longi']:'';

$lat='';
$long='';

if($lati == ''){
	$lat='';
}else{
	$lat=$lati;
}

if($longi == ''){
	$long='';
}else{
	$long=$longi;
}

$titleJoin ='';
$openingTypeJoin ='';
$jobLocationJoin ='';
$categoryJoin ='';
$riskMeterJoin ='';
$featuredJobJoin ='';
$transportLinkJoin ='';
$dressCodeJoin ='';
$radiusjoin = '';
$jobPriceJoin = '';
$jobDaysJoin = '';
$dateBetween = '';

//Category Search
if($jobCategory!='')
{
	$categoryJoin=' and tbljobcategories.category_id IN ('.$jobCategory.')';	
}

//Location Search
if($jobLocation!='')
{
	$jobLocationJoin=" and tbljobs.job_location like '%".$jobLocation."%'";	
}

//Opening Type Search
if($featuredJob!='')
{
	$featuredJobJoin=" and tbljobs.isfeatured like '%".$featuredJob."%'";
}

//Transport Link Search
if($transportLink!='')
{
	$transportLinkJoin=" and tbljobs.transport_link like '%".$transportLink."%'";
}

//Dress Code Search
if($dressCode!='')
{
	$dressCodeJoin=" and tbljobs.dresscode like '%".$dressCode."%'";
}

//Risk Meter Search
if($riskMeter!='')
{
 	$riskMeterJoin=" and tbljobs.riskmeter like '%".$riskMeter."%'";
}

//Opening Type Search
if($openingType!='')
{
 	$openingTypeJoin=" and tbljobs.opening_type like '%".$openingType."%'";
}

//Zip Radius Search
if($zipMiles!='')
{
	$radiusjoin=' and (';
	$radiusjoin .=" getDistancemiles(tbljobs.latitude, tbljobs.longitude, ".$lat.", ".$long.") <= ".$zipMiles." )";
} 

//Text Search
if($jobTitle!='')
{
	$titleJoin=" and (tbljobs.job_name like '%".$jobTitle."%')";
}

//Job Price
if($jobPrice!='')
{
	$jobPriceJoin=" and (tbljobs.price <= ".$jobPrice.")";
}

//Job Days
if($jobDays!='')
{
	$jobDaysJoin=" and (tbljobs.job_days like '%".$jobDays."%')";
}

//Start-End Date Search
if($startDate!='' && $endDate!='')
{
	$dateBetween = " and start_date >= '".$startDate."' and start_date <= '".$endDate."' ";
}

//Filter Job by User
$user_cond='';
if(isset($_SESSION['user_id']) && $_SESSION['user_id']!='')
{
	$user_cond= " and job_user_id=".$_SESSION['user_id']."";
}

$featurejob=mysql_query("select tbljobs.* from tbljobs LEFT JOIN tbljobcategories ON tbljobs.job_id=tbljobcategories.job_id LEFT JOIN tbljobstatus ON tbljobs.job_id=tbljobstatus.job_id where tbljobs.status=1  ".$categoryJoin." ".$radiusjoin." ".$jobLocationJoin." ".$jobDaysJoin." ".$jobPriceJoin." ".$openingTypeJoin." ".$dressCodeJoin." ".$transportLinkJoin." ".$featuredJobJoin." ".$riskMeterJoin." ".$user_cond." ".$dateBetween." ".$titleJoin." group by tbljobs.job_id ".$orderby." LIMIT $start,$pagelimit");
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
						
						<img src="'.$img.'" alt=""/>
					</div>
					<div class="stj_jl_dtl">
						<h2>'.$rows['job_name'].'</h2>
						<h5>('.$jobcategory.')</h5>
						<div class="stj_jd_cn">
							<p>Location: <span>'.$rows['job_location'].'</span></p>
							<p>Duration: <span>'.$rows['duration_in'].' Days ('.$rows['job_hours'].' hours per day)</span></p>
						</div>
						
					</div>
					<div class="stj_jl_rgt">
						<div class="stj_rating">
							<label>Ratings:</label>
							<div class="stj_star"><img src="images/star.png" alt=""/></div>
							<div class="stj_star"><img src="images/star.png" alt=""/></div>
							<div class="stj_star"><img src="images/star.png" alt=""/></div>
							<div class="stj_star"><img src="images/star.png" alt=""/></div>
						</div>
						<div class="stj_jd_cn">
							<p>Total Bids: <span>'.bidsCount($rows["job_id"]).' Bid(s)</span></p>
							'.$text.'
						</div>
						<div class="stj_jd_cn">
							<p>Total Views: <span>'.$totalVisits.'</span></p>
						</div>
						
						
					</div>
				</li>';
   }
   //$data.='</ul>';
}

echo $data;
exit;

?>