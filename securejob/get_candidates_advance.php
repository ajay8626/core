<?php
include "config.php";

$pagenumber=isset($_GET['page'])?$_GET['page']:1;
$pagelimit=12;
$start=(($pagenumber - 1) * $pagelimit);

$user_id=isset($_SESSION['user_id'])?$_SESSION['user_id']:0;
$candidateName=isset($_GET['candidateName'])?$_GET['candidateName']:'';
$candidateGender=isset($_GET['candidateGender'])?$_GET['candidateGender']:0;
$stateId=isset($_GET['stateId'])?$_GET['stateId']:'';
$cityId=isset($_GET['cityId'])?$_GET['cityId']:'';
$nationality=isset($_GET['nationality'])?$_GET['nationality']:0;
$militryBackground=isset($_GET['militryBackground'])?$_GET['militryBackground']:0;
$firstAid=isset($_GET['firstAid'])?$_GET['firstAid']:0;
$paremedicTraining=isset($_GET['paremedicTraining'])?$_GET['paremedicTraining']:0;
$tattoo=isset($_GET['tattoo'])?$_GET['tattoo']:0;
$piercing=isset($_GET['piercing'])?$_GET['piercing']:0;
$siaBadge=isset($_GET['siaBadge'])?$_GET['siaBadge']:0;
$build=isset($_GET['build'])?$_GET['build']:'';
$zipMiles=isset($_GET['zipMiles'])?$_GET['zipMiles']:'';
$zipCode=isset($_GET['zipCode'])?$_GET['zipCode']:'';
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

$user_cond = '';
$candidateNameJoin ='';
$candidateGenderJoin ='';
$stateIdJoin = '';
$cityIdJoin = '';
$nationalityJoin = '';
$militryBackgroundJoin = '';
$firstAidJoin = '';
$paremedicTrainingJoin = '';
$tattooJoin = '';
$piercingJoin = '';
$siaBadgeJoin = '';
$buildJoin = '';
$buildJoin = '';


//Candidate Name Search
if($candidateName!='')
{
	$candidateNameJoin = " and (tbluser.firstname like '%".$candidateName."%' OR tbluser.lastname like '%".$candidateName."%')";
}

//Gender Search
if($candidateGender!='')
{
	$candidateGenderJoin = " and (tbluser.gender like '%".$candidateGender."%')";
}

//State Search
if($stateId!='')
{
	$stateIdJoin = " and (tbluser.state_id like '%".$stateId."%')";
}

//City Search
if($cityId!='')
{
	$cityIdJoin = " and (tbluser.city_id like '%".$cityId."%')";
}

//Nationality Search
if($nationality!='')
{
	$nationalityJoin = " and (tbluser.nationality like '%".$nationality."%')";
}

//Militry Background Search
if($militryBackground!='')
{
	$militryBackgroundJoin = " and (tbluser.militry like '%".$militryBackground."%')";
}

//First Aids Search
if($firstAid!='')
{
	$firstAidJoin = " and (tbluser.firstaid like '%".$firstAid."%')";
}

//Paremedic Training Search
if($paremedicTraining!='')
{
	$paremedicTrainingJoin = " and (tbluser.paremedic like '%".$paremedicTraining."%')";
}

//Tattoo Search
if($tattoo!='')
{
	$tattooJoin = " and (tbluser.tattoos like '%".$tattoo."%')";
}

//Piercing Search
if($piercing!='')
{
	$piercingJoin = " and (tbluser.piercing like '%".$piercing."%')";
}

//SIA Badge Search
if($siaBadge!='')
{
	$siaBadgeJoin = " and (tbluser.sia like '%".$siaBadge."%')";
}

//Build Search
if($build!='')
{
	$buildJoin = " and (tbluser.build like '%".$build."%')";
}

//Zip Radius Search
if($zipMiles!='')
{
	$radiusjoin=' and (';
	$radiusjoin .=" getDistancemiles(tbluser.latitude, tbluser.longitude, ".$lat.", ".$long.") <= ".$zipMiles." )";
}

//User Filter
if(isset($_SESSION['user_id']) && $_SESSION['user_id']!='')
{
	$user_cond= " and tbluser.user_id!=".$_SESSION['user_id']."";
}

$join_category='';
$catjoin='';
if($category!='')
{
 $join_category='LEFT JOIN tblusercategoryratecard ON tbluser.user_id=tblusercategoryratecard.user_id';
 $catjoin=' and tblusercategoryratecard.category_id IN ('.$category.')';	
}


$sql=mysql_query("select * from tbluser ".$join_category." where tbluser.status=1 ".$candidateNameJoin." ".$candidateGenderJoin." ".$stateIdJoin." ".$cityIdJoin." ".$nationalityJoin." ".$firstAidJoin." ".$radiusjoin." ".$tattooJoin." ".$siaBadgeJoin." ".$buildJoin." ".$piercingJoin." ".$paremedicTrainingJoin." ".$militryBackgroundJoin." ".$user_cond." and tbluser.customer_type=2 LIMIT $start, $pagelimit");
$frow=mysql_num_rows($sql);
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

		if($rows['is_email_verify'] == 1){
			$verifiedClass = 'verified_usr';
		}else{
			$verifiedClass = '';
		}
		
		$data .='<li>
                   	<div class="rqstmain">
                       <div class="leftimg">
					   <a class="viewrate" href="guard-profile.php?user_id='.$rows['user_id'].'&status=1"><div class="gnrt_img" style="background-image: url('.$img.');"></div></a></div>
                   	<div class="rgtcnt">
                        <div class="addwsh">    
                            <a href="javascript:void(0)"><i class="'.$class.'" id="'.$rows['user_id'].'"></i></a>              		
                        </div>
						<a class="viewrate" href="guard-profile.php?user_id='.$rows['user_id'].'&status=1"><h2 class="'.$verifiedClass.'">'.$rows['firstname'].' '.$rows['lastname'].'</h2></a>
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