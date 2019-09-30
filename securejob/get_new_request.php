<?php
include "config.php";

$pagenumber=isset($_GET['page'])?$_GET['page']:1;
$pagelimit=12;
$start=(($pagenumber - 1) * $pagelimit);
$category=isset($_GET['category'])?$_GET['category']:'';
$sort=isset($_GET['sort'])?$_GET['sort']:'';
$search=isset($_GET['search'])?$_GET['search']:'';
$searchtxt='';
$login_id=isset($_SESSION['user_id']) ? $_SESSION['user_id'] :0 ;

/*code for display confirm user*/
$confirmedby=isset($_GET['confirmedby'])?$_GET['confirmedby']:'';
/*end code for display confirm user*/


//echo "<pre>";print_r($search);exit;


$orderby=' order by tbluser.user_id desc';
if($sort!='' && $sort=='newest')
{
	$orderby='order by tbluser.user_id desc';
}
if($sort!='' && $sort=='oldest')
{
	$orderby=' order by tbluser.user_id asc';
}
if($sort!='' && $sort=='priceh')
{
	$orderby='order by tbluser.user_id desc';
}
if($sort!='' && $sort=='pricel')
{
	$orderby=' order by tbluser.user_id asc';
}

$user_cond='';
if(isset($_SESSION['user_id']) && $_SESSION['user_id']!='')
{
	$user_cond= " and tbluser.user_id!=".$_SESSION['user_id']."";
}



if($search!='')
{
	$searchtxt=" and (tbluser.firstname like '%".$search."%' OR tbluser.lastname like '%".$search."%' OR tbluser.email like '%".$search."%' OR tbluser.address_1 like '%".$search."%' OR tbluser.address_2 like '%".$search."%' OR tbluser.address_3 like '%".$search."%' OR tbluser.experience like '%".$search."%' OR CONCAT(tbluser.firstname, ' ', tbluser.lastname) LIKE '%".$search."%')";
}

$join_category='';
$catjoin='';
if($category!='')
{
 $join_category='LEFT JOIN tblusercategoryratecard ON tbluser.user_id=tblusercategoryratecard.user_id';
 $catjoin=' and tblusercategoryratecard.category_id IN ('.$category.')';	
}


if ($confirmedby != '') {

	$confirmedby = mysql_query("select job_id from tbljobs WHERE job_user_id = $confirmedby AND start_date >='".date("Y-m-d h:i:s")."' AND status = 1 AND job_status = 2 AND payment_status = 1");
	while($rows=mysql_fetch_array($confirmedby)){

 		$jobids[] = $rows['job_id'];
	}
	$job_ids= implode(",",$jobids);

	$tbljobsapplied = mysql_query("select user_id from tbljobsapplied WHERE job_id IN ($job_ids) AND is_winner = 1 group by user_id");
		while($rows=mysql_fetch_array($tbljobsapplied)){
	 		$user_id[] = $rows['user_id'];
		}

		$confirmed_uids=isset($user_id)?$user_id:'';
		$confirmed_uids = implode(',', $confirmed_uids);

		if ($confirmed_uids != NULL) {
			$confirmed_uids = " AND tbluser.user_id IN ($confirmed_uids)";
			$sql=mysql_query("select tbluser.user_id,tbluser.verified_user,tbluser.email,tbluser.firstname,tbluser.lastname,tbluser.address_1,tbluser.address_2,tbluser.address_3,tbluser.city_id,tbluser.state_id,tbluser.profile_image, tbluser.is_email_verify from tbluser ".$join_category." where tbluser.status=1 ".$confirmed_uids.$catjoin."  ".$user_cond." ".$searchtxt." ".$orderby." LIMIT $start,$pagelimit");
			$frow=mysql_num_rows($sql);

		}else if($confirmed_uids == NULL){
			$frow = -1;
			exit();
		}
		
}else{

	
	$sql=mysql_query("select tbluser.user_id,tbluser.verified_user,tbluser.email,tbluser.firstname,tbluser.lastname,tbluser.address_1,tbluser.address_2,tbluser.address_3,tbluser.city_id,tbluser.state_id,tbluser.profile_image, tbluser.is_email_verify from tbluser ".$join_category." where tbluser.status=1 ".$catjoin."  ".$user_cond." ".$searchtxt." ".$orderby." LIMIT $start,$pagelimit");
	$frow=mysql_num_rows($sql);
}

$data=''; 
if($frow > 0)
{
	while($rows=mysql_fetch_array($sql))
	{
		
		$currentuserId=$rows['user_id'];
		$rate_count=rate_count($rows['user_id']);
		
		$address_1=$rows['address_1'];
		$address_2=$rows['address_2'];
		$address_3=$rows['address_3'];
		if($address_1!='')
		{
			$address=$address_1;
		}
		if($address_1!='' && $address_2!='')
		{
			$address.=", ".$address_2;
		}
		if($address_1!='' && $address_2!='' && $address_3!='')
		{
			$address.=", ".$address_3;
		}
		$profile_image=$rows['profile_image'];
		 $img='images/grdimg.jpg';
		 if($profile_image!=''){
			 
		 $upload_extension =  explode(".", $profile_image);
         $upload_extension = end($upload_extension);
			 if ((strlen($upload_extension)==3) || (strlen($upload_extension)==4)) {
			 $img=CUSTOMER_PROFILE_IMG_URL.$profile_image;
			 } else {
			 $img=$profile_image; 
			 }
		 }			 
		$like=get_like($login_id,$currentuserId);
		
		if($like==1)
		{
			$class='fa fa-heart-o like';
		} else {
		    $class='fa fa-heart-o';
		}  

		/* User Rating Individually */
		$rating_sql = "SELECT * FROM tblfeedback WHERE user_id=$currentuserId";
		$rating_exc = mysql_query($rating_sql);
		$rating_row_count = mysql_num_rows($rating_exc);
		$user_performance = 0;
		$user_punctuality = 0;
		$user_presentation = 0;
		$user_dresscode = 0;
		$user_attitude = 0;
		$echoStarts = '';
		if($rating_row_count > 0){
			while($rating_rows = mysql_fetch_array($rating_exc)){
				$user_performance +=  $rating_rows['performance'];
				$user_punctuality +=  $rating_rows['punctuality'];
				$user_presentation +=  $rating_rows['presentation'];
				$user_dresscode +=  $rating_rows['dresscode'];
				$user_attitude +=  $rating_rows['attitude'];
			}
		
			/* User Rating Overall */
			$overallRating = ($user_performance/$rating_row_count) + ($user_punctuality/$rating_row_count) + ($user_presentation/$rating_row_count) + ($user_dresscode/$rating_row_count) + ($user_attitude/$rating_row_count);
			$overallRating = (($overallRating / 5) * 20);
			$starsFull = (int)($overallRating / 20);
			$starsempty = 5 - $starsFull;

			$echoStarts .= '<div class="rat">';
			for($i=1; $i<=$starsFull; $i++){
				$echoStarts .= '<img src="images/star.png" alt=""/>';
			}
			for($i=1; $i<=$starsempty; $i++){
				$echoStarts .= '<img src="images/star-null.png" alt=""/>';
			}
			$echoStarts .= '</div>';
		}

		if($rows['verified_user'] == 1){
			$verifiedClass = 'verified_usr';
		}else{
			$verifiedClass = '';
		}
		
		$data .='<li>
                   	<div class="rqstmain">
                   	<div class="leftimg"><a class="viewrate" href="guard-profile.php?user_id='.$rows['user_id'].'&status=1"><div class="gnrt_img" style="background-image: url('.$img.');"></div></a></div>
                   	<div class="rgtcnt">
                   	<div class="addwsh">    
                   		<a href="javascript:void(0)"><i class="'.$class.'" id="'.$rows['user_id'].'"></i></a>              		
                   	</div>
					   <a class="viewrate" href="guard-profile.php?user_id='.$rows['user_id'].'&status=1"><h2 class="'.$verifiedClass.'">'.$rows['firstname'].' '.$rows['lastname'].'</h2> </a>
                   		<p>'.$rate_count.' Job(s) Completed</p>
                   		'.$echoStarts.'
                   	 		<a class="viewrate" href="guard-profile.php?user_id='.$rows['user_id'].'&status=1">View Rate Card </a>
                   	</div>
                   		</div>
                   	</li>';
	}
}
echo $data;
exit;
?>