<?php 
if(!in_array(14,$tes_mod)) { 
	echo "<div class='grid_12'><div class='message error'><p>You don't have permission to access this page</p></div></div>";
	die;
}

require_once(ADMIN_PATH."inc/img_upload.php");
include_once(ADMIN_PATH."inc/functions.php");
include_once(ADMIN_PATH."inc/resize-class.php");

if (!isAdminLoggedIn())
	header("location:index.php");
else	
	$adminid=isAdminLoggedIn();
	
	$id = isset($_GET["id"])?($_GET["id"]):0;

	if((isset($_GET["id"])) && ($_GET["id"]!="")){
		$id = isset($_GET["id"])?($_GET["id"]):0;
		$sql = mysql_query("select * from tblcouponcodemaster where coupon_id = ".$id."");
		list($id,$couponcode,$type,$amount,$fromdate,$todate,$status) = mysql_fetch_row($sql);
	   if($fromdate)
		{
			$fromdates=explode("-",$fromdate);
			$fromdate=$fromdates[2]."/".$fromdates[1]."/".$fromdates[0];
		}
		
		if($todate)
		{
			$todates=explode("-",$todate);
			$todate=$todates[2]."/".$todates[1]."/".$todates[0];
		}
	}
	$errMsg=array();
	if($_POST["act"] == 'add' || $_POST["act"] == 'edit')
	{
		$err = 0;
		$couponcode = isset($_REQUEST["couponcode"])?stripslashes($_REQUEST["couponcode"]):"";	
		$type=isset($_REQUEST["type"])?stripslashes($_REQUEST["type"]):"";	
		$amount=isset($_REQUEST["amount"])?$_REQUEST["amount"]:0;
		$fromdate=isset($_REQUEST["fromdate"])? ($_REQUEST["fromdate"]):0;
		$todate=isset($_REQUEST["todate"])? ($_REQUEST["todate"]):0;
		$status=isset($_REQUEST["isactive"])?$_REQUEST["isactive"]:0;

		if($fromdate)
		{
			$fromdates=explode("/",$fromdate);
			$fromdate=$fromdates[2]."-".$fromdates[1]."-".$fromdates[0];
		}
		
		if($todate)
		{
			$todates=explode("/",$todate);
			$todate=$todates[2]."-".$todates[1]."-".$todates[0];
		}
		
		if($couponcode=='')
		{
			$err++;				
		}
		
		if($err>0)  
		{
			$_SESSION['mt'] = "error";
			$_SESSION['me'] = "Please fill require fields.";
		}
		
		if($id == 0 && $err==0)
		{
			$sql_category = "select * from tblcouponcodemaster WHERE couponcode = '$couponcode'";
					
			$res_category = $db->Query($sql_category);
			
			$totRowsCategory = mysql_num_rows($res_category);
			if($totRowsCategory > 0)
			{
				$err++;
				$_SESSION['mt'] = "error";
				$_SESSION['me'] = "Coupon Code already exist.";
			}
		}
		
        
		
		if($_POST["act"] == 'add' && $err==0){
			$data =array("couponcode"=>$couponcode,'type'=>$type,'amount'=>$amount,'fromdate'=>$fromdate,'todate'=>$todate,'status'=>$status);
			if($db->Insert($data,"tblcouponcodemaster")){
				$lastid=$db->LastInsert("tblcouponcodemaster");
				$_SESSION['mt'] = "success";
				$_SESSION['me'] = "Coupon added successfully.";
				header("Location: main.php?pg=viewcoupon");
				exit;
			}else{
				$_SESSION['mt'] = "error";
				$_SESSION['me'] = "Error while inserting data";
				header("Location: main.php?pg=viewcoupon");
				exit;
			}
		}
		if($_POST["act"] == 'edit' && $err==0){
			$data =array("couponcode"=>$couponcode,'type'=>$type,'amount'=>$amount,'fromdate'=>$fromdate,'todate'=>$todate,'status'=>$status);
			$db->Update($data,"tblcouponcodemaster","coupon_id=".$id."");					
			$_SESSION['mt'] = "success";
			$_SESSION['me'] = "Coupon updated successfully.";
			header("Location: main.php?pg=viewcoupon");
			exit;
		}	
	}
?>
<script>
function checknumeric(val)
{
	if(isNaN(val))
	{
		alert("please enter valid amount.");
		$('#amount').focus();
		$('#amount').val('');
	}
}
</script>
<div class="content-wrapper">
<?php  echo getMsg(); ?>
    <!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Coupon Master</h1>
		  <ol class="breadcrumb">
			<li><a href="<?php echo ADMIN_URL; ?>main.php"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="<?php echo ADMIN_URL; ?>main.php?pg=viewcoupon"><i class="fa fa-tree"></i>Coupon Master</a></li>
			
		  </ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-6">
					  <!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Coupon Master</h3>
					</div>
				<div class="error"></div>
				<div class="box-body">
				<form class="validateForm" name="frmadminadded" method="post" action="" enctype="multipart/form-data">
			<?php 
			if ($id!=0) {
				echo '<input type="hidden" value="edit" name="act" />'; 
				echo "<input type='hidden' value='$id' name='keyid' id='keyid' />"; 
				}
			else {
				echo '<input type="hidden" value="add" name="act" />';
				}
			?>
			<div class="form-group">
				<label>Coupon Code</label><span style="color:#FF0000;">*</span>
				<input class="form-control" id="couponcode"  maxlength='50' name="couponcode" value="<?php echo $couponcode; ?>"  data-errormessage-value-missing="Please enter coupon code" data-validation-engine="validate[required]" />
			</div>
			<div class="form-group">
				<label>Coupon Type</label><span style="color:#FF0000;">*</span><br>
				<input type="radio" name="type" checked <?php if($type==2){ ?> checked <?php } ?> id="percentage" value="2">&nbsp;Percentage&nbsp;
				<input type="radio" name="type" id="fixed" <?php if($type==1){ ?> checked <?php } ?> value="1">&nbsp;Fixed
			</div>
			<div class="form-group">
				<label>Coupon Amount</label><span style="color:#FF0000;">*</span>
				<input class="form-control" id="amount"  maxlength='5' name="amount" onkeyup="checknumeric(this.value)" value="<?php echo $amount; ?>"  data-errormessage-value-missing="Please enter coupon amount" data-validation-engine="validate[required]" />
			</div>
			<div class="form-group">
				<label>Coupon From Date</label>
				<input class="form-control" id="fromdate"  maxlength='50' name="fromdate" value="<?php echo $fromdate; ?>"  />
			</div>
			<div class="form-group">
				<label>Coupon To Date</label>
				<input class="form-control" id="todate"  maxlength='50' name="todate" value="<?php echo $todate; ?>" />
			</div>
						
			<div class="form-group">
			  <label>Status</label>
			</div>
			<div class="checkbox">
				<?php
				$isActiveChecked = "";
				if($status == 1){ 
					$isActiveChecked = "checked=checked"; 
				} 
				?>
				<label><input type="checkbox" value="1" name="isactive" <?php echo $isActiveChecked;?> > NOTE:- Please tick this checkbox if you want to keep this coupon code Active</label>
			</div>				
			
				</div>
				<div class="box-footer">
					<button type="submit"  name="submit_me"  class="btn btn-primary">Submit</button>
				</div>
			</form>
				</div>
				</div>
			</div>
	</section>
</div>
<div class="clear"></div>
<script>
	$(function () {
		$('#percentage').click(function() {
		if($('#amount').val() > 100 && $('#percentage').prop('checked'))
		{
		  alert("please enter valid coupon amount");
		  $('#amount').val('');
		}
		});
		$('#amount').keyup(function() {
			if($('#amount').val() > 100 && $('#percentage').prop('checked'))
			{
			  alert("please enter valid coupon amount");
			  $('#amount').val('');
			}
        });
		
    //Date picker
		$('#fromdate').datepicker({
			autoclose: true,
			format: 'dd/mm/yyyy'
		});
		
		$('#todate').datepicker({
			autoclose: true,
			format: 'dd/mm/yyyy'
		});
	});
</script> 