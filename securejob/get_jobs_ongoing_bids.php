<?php
include "config.php";

$pagenumber=isset($_GET['page'])?$_GET['page']:1;
$pagelimit=4;
$start=(($pagenumber - 1) * $pagelimit);
$category=isset($_GET['category'])?$_GET['category']:'';
$sort=isset($_GET['sort'])?$_GET['sort']:'';
$search=isset($_GET['search'])?$_GET['search']:'';


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


$featurejob=mysql_query("select tbljobs.* from tbljobs  LEFT JOIN tbljobcategories ON tbljobs.job_id=tbljobcategories.job_id LEFT JOIN tbljobstatus ON tbljobs.job_id=tbljobstatus.job_id where  tbljobs.status=1 and tbljobs.job_status=1 and tbljobs.start_date >='".date("Y-m-d h:i:s")."' ".$catjoin." ".$user_cond." ".$searchtxt." group by tbljobs.job_id ".$orderby." LIMIT $start,$pagelimit");
$frow=mysql_num_rows($featurejob);

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
        
		$text='<p>Highest Bid: <span>£'.round(maxbidprice($rows["job_id"])).' per hour per person</span></p>';
		if(round(maxbidprice($rows["job_id"]))==0)
		{
			$text='<p>No Bids</p>';
		}
		
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
												<p>Price: <span><b>£'.round($rows['price']).'</b>/hr per person</span></p>
                    							<p>Opening Positions: <span>'.$rows['opening_position'].'</span></p>
                    						</div>
                    					</div>
                    					<div class="stj_jl_rgt">
                    						<div class="stj_rating">
											'.getPosterFeedback($rows["job_id"]).'
                    						</div>
                    						<div class="stj_jd_cn">
                    							<p>Total Bids: <span>'.bidsCount($rows["job_id"]).' Bids</span></p>
                    							'.$text.'
                                                <p>Job Type: <span>'.$job_type_txt.'</span></p>
                    						</div>';

                                            if ($user_sts  == 0) {
                                                $data.='<a class="a_pyb" data-toggle="modal" data-target="#admin_call">Place your bid</a>';
                                            } else {
                                               $data.='<a class="a_pyb" href="place-bid.php?job_id='.$rows["job_id"].'">Place your bid</a>'; 
                                            }
                                            

                    						

                    						$data.='<div class="bid_start">Starts in <span>'.$since_start->d.'D '.$since_start->h.'H '.$since_start->i.'M</span></div>
                    					</div>
                    				</li>';
   }
   //$data.='</ul>';
}



 
//$data.='</ul>';
echo $data;
exit;

?>