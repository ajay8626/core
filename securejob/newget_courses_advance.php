<?php
include "config.php";

$pagenumber=isset($_GET['page'])?$_GET['page']:1;
$pagelimit=4;
$start=(($pagenumber - 1) * $pagelimit);

$user_id=isset($_SESSION['user_id'])?$_SESSION['user_id']:0;
$courseTitle=isset($_GET['courseTitle'])?$_GET['courseTitle']:'';
$courseLocation=isset($_GET['courseLocation'])?$_GET['courseLocation']:'';
$courseDuration=isset($_GET['courseDuration'])?$_GET['courseDuration']:'';
$coursePrice=isset($_GET['coursePrice'])?$_GET['coursePrice']:'';
$startDate=isset($_GET['startDate'])?$_GET['startDate']:'';
$endDate=isset($_GET['endDate'])?$_GET['endDate']:'';
$zipMiles=isset($_GET['zipMiles'])?$_GET['zipMiles']:'1';
$lati=isset($_GET['lati'])?$_GET['lati']:'';
$longi=isset($_GET['longi'])?$_GET['longi']:'';
//echo "<pre>";print_r($zipMiles);exit;
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
$courseLocationJoin ='';
$courseDurationJoin ='';
$radiusjoin = '';
$jobPriceJoin = '';
$jobDaysJoin = '';
$dateBetween = '';

//Location Search
if($courseDuration!='')
{
	$courseDurationJoin=" and tblcoursemaster.duration like '%".$courseDuration."%'";	
}


//Location Search
if($courseLocation!='')
{
	$courseLocationJoin=" and tblcoursemaster.location like '%".$courseLocation."%'";	
}

//Zip Radius Search
if($zipMiles!='' && $lat !='' && $long !='')
{
	$radiusjoin = ' and (';
	$radiusjoin .=" getDistancemiles(tblcoursemaster.latitude, tblcoursemaster.longitude, ".$lat.", ".$long.") >= ".$zipMiles." )";
} 

//Text Search
if($courseTitle!='')
{
	$titleJoin=" and (tblcoursemaster.course_title like '%".$courseTitle."%')";
}

//Job Price
if($coursePrice!='')
{
	$coursePriceJoin=" and (tblcoursemaster.price <= ".$coursePrice.")";
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
	$user_cond= " and job_user_id!=".$_SESSION['user_id']."";
}


//echo "<pre>";print_r("select * from tblcoursemaster where tblcoursemaster.status=1 ".$titleJoin." ".$courseLocationJoin." ".$courseDurationJoin." ".$coursePriceJoin." ".$dateBetween." ".$radiusjoin." ");exit;

$sql=mysql_query("select * from tblcoursemaster where tblcoursemaster.status=1 ".$titleJoin." ".$courseLocationJoin." ".$courseDurationJoin." ".$coursePriceJoin." ".$dateBetween." ".$radiusjoin." ");


$s = "select * from tblcoursemaster where tblcoursemaster.status=1 ".$titleJoin." ".$courseLocationJoin." ".$courseDurationJoin." ".$coursePriceJoin." ".$dateBetween." ".$radiusjoin." LIMIT $start, $pagelimit";
//echo $sql;
//echo $s; exit;

$frow=mysql_num_rows($sql);

$data='';
if($frow > 0)
{
   while($rows=mysql_fetch_array($sql))
   {
		
		$start_date  = date('d F Y',strtotime($rows["start_date"]));
		$courseimage = $rows["image"];
		
		$img="images/crs1.jpg";
		if($courseimage!='')
		{
			$img=SITE_URL."course/images/".$courseimage;
		}

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
        
        if(isset($_SESSION['user_id'])) {
            $pymnt_pop ='<a class="a_apply" href="#" data-toggle="modal" data-target="#addCredites-'.$rows['course_id'].'">Apply for course</a>';    
        } else {
            $pymnt_pop ='<a class="a_apply" href="login.php">Apply for course</a>';
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
                  					<p>Time: <span>'.$rows['start_time'].'</span></p>
                  					<p>Price: <span><b>£'.$rows['price'].'</b></span></p>
                  					<p>Duration: <span>'.$rows['duration'].'</span></p>
                  				</div>
                  				<div class="crs_lr_rgt">
                  					<a href="newcourse_details.php?course_id='.$rows['course_id'].'">More about course</a>
                  					'.$pymnt_pop.'
                  				</div>
                  			</div>
                  		</li>';
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
							<form action="paypal/payments.php" method="post" id="paypal_form" target="_blank">
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
                                <input type="hidden" name="item_name" value="'.$rows['name'].'" / >
                                <input type="hidden" name="item_number" value="'.$rows['course_id'].'" / >
                                <input type="hidden" name="user_id" value="'.$user_id.'" / >
                                <input type="hidden" name="custom" value="course_payment_with_paypal" / >
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

echo $data;
exit;

?>