<?php
include "config.php";
$pagenumber=isset($_GET['page'])?$_GET['page']:1;
$pagelimit=3;
$start=(($pagenumber - 1) * $pagelimit);
$sort=isset($_GET['sort'])?$_GET['sort']:'';
$search=isset($_GET['search'])?$_GET['search']:'';

$user_id=isset($_SESSION['user_id']) ? $_SESSION['user_id'] :0 ;
$userdetails=mysql_query("select * from tbluser where user_id='".$user_id."'");
$rowcount1=mysql_num_rows($userdetails);   

if($rowcount1 > 0)
{
    $userdata=mysql_fetch_array($userdetails);
    $firstname=$userdata['firstname'];
    $lastname=$userdata['lastname'];
    $email=$userdata['email'];
}
else
{
    $firstname='';
    $lastname='';
    $email='';
}

$data='';

$orderby=' order by price desc';

if($sort!='' && $sort=='priceh')
{
	$orderby='order by price desc';
}
if($sort!='' && $sort=='pricel')
{
	$orderby=' order by price asc';
}
$searchtxt='';
if($search!='')
{
	$searchtxt=" and (name like '%".$search."%' OR description like '%".$search."%' OR price like '%".$search."%' OR course_location like '%".$search."%' OR course_days like '%".$search."%')";
}

$newcourse=mysql_query("select * from tblcourse where  status=1 ".$searchtxt." ".$orderby." LIMIT $start,$pagelimit");
$newrow=mysql_num_rows($newcourse);
if($newrow > 0)
{
   while($rows=mysql_fetch_array($newcourse))
   {
		
		$start_date  = date('d F Y',strtotime($rows["start_date"]));
		$courseimage = $rows["image"];
		
		$img="images/crs1.jpg";
		if($courseimage!='')
		{
			$img=COURSE_IMG_URL.$courseimage;
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
                  			    <h3>'.$rows['name'].' (Door Security)</h3>
                  				<div class="crs_lr_lft">
                  					<p>Location: <span>'.$rows['course_location'].'</span></p>
                  					<p>Date: <span>'.$start_date.'</span></p>
                  					<p>Time: <span>'.$rows['course_time'].'</span></p>
                  					<p>Price: <span><b>£'.$rows['price'].'</b></span></p>
                  					<p>Duration: <span>'.$rows['course_days'].'</span></p>
                  				</div>
                  				<div class="crs_lr_rgt">
                  					<a href="course_details.php?course_id='.$rows['course_id'].'">More about course</a>
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
							<form action="paypal/payments.php" method="post" id="paypal_form">
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
                                <input type="hidden" name="item_name" value="'.$rows['name'].'" />
                                <input type="hidden" name="item_number" value="'.$rows['course_id'].'" />
                                <input type="hidden" name="user_id" value="'.$user_id.'" />
                                <input type="hidden" name="custom" value="course_payment_with_paypal" />
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
//$data.='</ul>';
echo $data;
exit;

?>