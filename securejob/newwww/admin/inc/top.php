<?php
$date = date('l, d-m-y');
$admin_name = "admin";
list($adminid,$admin,$sessionid) = explode(";",$_SESSION['adminsessionid']);
$sql = mysql_query("select * from tbladmin where adminid =".$adminid."");
if(mysql_num_rows($sql)>0){
	$result = mysql_fetch_assoc($sql);
	$admin_name = $result["adminfname"];
}
	
	if($adminid==1)
	{
		for($i=1;$i<=100;$i++)
		{
			$rst_val .= $i.",";
			
		}		
	}
	else 
	{		
			$sql_new = mysql_query("select * from tbladminrights where admin_id = {$adminid}");			
			while($rst_new = mysql_fetch_array($sql_new))
			{
				$rst_val .= $rst_new['menu_id'].",";
			}
		
	}
			$tes_mod = explode(",",$rst_val);	
	
?>
 <div class="grid_12 header-repeat">
	<div id="branding">
		<div class="floatleft">
			<a href="<?php echo ADMIN_URL;?>main.php">
				<h1><img src="img/logonew.png" alt=""/> <?php //echo HEADER_TEXT;?></h1>
			</a>
		</div>
		<div class="floatright">
			<div class="floatleft">
				<img src="img/img-profile.png" alt="Profile Pic"  width="30px;"/></div>
			<div class="floatleft marginleft10">
				<ul class="inline-ul floatleft">
					<li>Hello Admin</li>
					<li><a href="<?php echo ADMIN_URL;?>main.php?pg=logout">Logout</a></li>
				</ul>
				<br />
			</div>
			<div class="floatleft marginleft10 dateDiv">
				<ul class="inline-ul floatleft">
					<li><?php echo date("F j, Y, g:i a");?></li>
				</ul>
				<br />
			</div>
			
		</div>
		<div class="clear">
		</div>
	</div>
</div>
<div class="clear"></div>
<div class="grid_12">
	<ul class="nav main">
		<li><a href="<?php echo ADMIN_URL;?>main.php"><span style="display:inline; height:28px; padding-top:5px;">Home</span></a></li>
		
		<?php	if(in_array(1,$tes_mod)) { ?>
		<li><a href="<?php echo ADMIN_URL;?>main.php?pg=viewadmin"><span>Admin Management</span></a></li> 
		<?php } ?>	
		
		<?php	if(in_array(3,$tes_mod)) { ?>		
		<li><a href="<?php echo ADMIN_URL;?>main.php?pg=viewcustomer"><span>Customer</span></a></li>
		<?php } ?>
		<?php	if(in_array(4,$tes_mod)) { ?>	
		<li><a href="<?php echo ADMIN_URL;?>main.php?pg=viewcleaner"><span>Cleaner</span></a></li>
		<?php } ?>
		<?php	if(in_array(5,$tes_mod)) { ?>		
		<li><a href="<?php echo ADMIN_URL;?>main.php?pg=viewappointments"><span>Appointments</span></a></li>
		<?php } ?>
		<?php	if(in_array(9,$tes_mod)) { ?>		
		<li><a href="<?php echo ADMIN_URL;?>main.php?pg=viewmanager"><span>Manager</span></a></li>
		<?php } ?>
		<?php	if(in_array(2,$tes_mod)) { ?>
		<li><a href="#"><span>Configuration</span></a>
			<ul>
				<li><a href="<?php echo ADMIN_URL;?>main.php?pg=viewsystemconfig"><span>Settings</span></a></li>
				
				<?php	if(in_array(6,$tes_mod)) { ?>		
					<li><a href="<?php echo ADMIN_URL;?>main.php?pg=viewversion"><span>Versions</span></a></li>
				<?php } ?>
				
				<?php	if(in_array(7,$tes_mod)) { ?>		
					<li><a href="<?php echo ADMIN_URL;?>main.php?pg=viewtimeslot"><span>Time Slot</span></a></li>
				<?php } ?>
				<?php	if(in_array(8,$tes_mod)) { ?>		
					<li><a href="<?php echo ADMIN_URL;?>main.php?pg=viewgeneralmsg"><span>General Message</span></a></li>
				<?php } ?>
			</ul>	
		</li>
		<?php } ?>			
		<li><a href="<?php echo ADMIN_URL;?>main.php?pg=logout"><span style="display:inline; height:28px; padding-top:5px;">Log Out</a></li>
	</ul>
</div>