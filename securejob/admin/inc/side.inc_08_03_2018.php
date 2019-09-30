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

<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
     
      <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
        
		
		<li>
			<a href="<?php echo ADMIN_URL;?>main.php">
				<i class='fa fa-home'></i> <span>Home</span>
			</a>
		</li>				
		<?php	if(in_array(1,$tes_mod)) { ?>
		<li>
			<a href="<?php echo ADMIN_URL;?>main.php?pg=viewadmin">
				<i class='fa fa-user'></i> <span>Admin Management</span>
			</a>
		</li>				
		<?php
			
		} ?>	
		<?php	if(in_array(3,$tes_mod)) { ?>
		<li>
			<a href="<?php echo ADMIN_URL;?>main.php?pg=viewuser">
				<i class='fa fa-users'></i> <span>Users</span>
			</a>
		</li>				
		<?php } ?>
		
		<?php	if(in_array(4,$tes_mod)) { ?>
		<li>
			<a href="<?php echo ADMIN_URL;?>main.php?pg=viewcategories">
				<i class='fa fa-tree'></i> <span>Categories</span>
			</a>
		</li>
			
		<?php } ?>
		<?php	if(in_array(11,$tes_mod)) { ?>
		<li>
			<a href="<?php echo ADMIN_URL;?>main.php?pg=viewcourse">
				<i class='fa fa-book'></i> <span>Courses</span>
			</a>
		</li>
		<?php } ?>
		<?php	if(in_array(12,$tes_mod)) { ?>
        <li>
			<a href="<?php echo ADMIN_URL;?>main.php?pg=viewadvert">
				<i class='fa fa-buysellads'></i> <span>Advert Manager</span>
			</a>
		</li>	
		<?php } ?>
		<?php	if(in_array(7,$tes_mod)) { ?>
		<li>
			<a href="<?php echo ADMIN_URL;?>main.php?pg=viewtags">
				<i class='fa fa-tags'></i> <span>Tags</span>
			</a>
		</li>				
		<?php } ?>
		
		<?php	if(in_array(10,$tes_mod)) { ?>
		<li>
			<a href="<?php echo ADMIN_URL;?>main.php?pg=viewcms">
				<i class='fa fa-folder'></i> <span>CMS</span>
			</a>
		</li>				
		<?php } ?>
		
		<?php	/* if(in_array(2,$tes_mod)) { ?>
		<li class='treeview'>
			<a href='#'>
				<i class='fa fa-dashboard'></i> <span>Configuration</span>
				<span class='pull-right-container'>
					<i class='fa fa-angle-left pull-right'></i>
				</span>
			</a>
			<ul class='treeview-menu'>
				<li><a href="<?php echo ADMIN_URL;?>main.php?pg=viewsystemconfig"><i class='fa fa-wrench'></i>Settings</a></li>
				
				<?php	if(in_array(6,$tes_mod)) { ?>
				<li>
					<a href="<?php echo ADMIN_URL;?>main.php?pg=viewversion">
						<i class='fa fa-cog'></i> <span>Versions</span>
					</a>
				</li>				
				<?php } ?>	
				
				
				<?php	if(in_array(8,$tes_mod)) { ?>
				<li>
					<a href="<?php echo ADMIN_URL;?>main.php?pg=viewgeneralmsg">
						<i class='fa fa-comment'></i> <span>General Message</span>
					</a>
				</li>
                 				
				<?php } ?>	
				
			</ul>
		</li>
		<?php } */ ?>
		
		
		<?php	if(in_array(5,$tes_mod)) { ?>
		<li class='treeview'>
			<a href='#'>
				<i class='fa fa-suitcase'></i> <span>Jobs</span>
				<span class='pull-right-container'>
					<i class='fa fa-angle-left pull-right'></i>
				</span>
			</a>
			<ul class='treeview-menu'>
				<li>
					<a href="<?php echo ADMIN_URL;?>main.php?pg=viewjobs">
						<i class='fa fa-suitcase'></i> <span>Jobs</span>
					</a>
				</li>
				<li>
					<a href="<?php echo ADMIN_URL;?>main.php?pg=viewjobbids">
						<i class='fa fa-suitcase'></i> <span>Job Bids</span>
					</a>
				</li>
				<li>
					<a href="<?php echo ADMIN_URL;?>main.php?pg=viewjobratings">
						<i class='fa fa-suitcase'></i> <span>Job Ratings</span>
					</a>
				</li>
			</ul>
		</li>
		<?php } ?>
		
		<?php	if(in_array(9,$tes_mod)) { ?>
		<li>
			<a href="<?php echo ADMIN_URL;?>main.php?pg=viewservices">
				<i class='fa fa-gears'></i> <span>Services</span>
			</a>
		</li>				
		<?php } ?>
		
		<?php	if(in_array(2,$tes_mod)) { ?>
		<li>
			<a href="<?php echo ADMIN_URL;?>main.php?pg=viewlocation">
				<i class='fa fa-location-arrow'></i> <span>Locations</span>
			</a>
		</li>
		<?php /*<li class='treeview'>
			<a href='#'>
				<i class='fa fa-location-arrow'></i> <span>Location</span>
				<span class='pull-right-container'>
					<i class='fa fa-angle-left pull-right'></i>
				</span>
			</a>
			<ul class='treeview-menu'>
	
				
				<li>
					<a href="<?php echo ADMIN_URL;?>main.php?pg=viewcity">
						<i class='fa fa-location-arrow'></i> <span>City</span>
					</a>
				</li>				
				<li>
					<a href="<?php echo ADMIN_URL;?>main.php?pg=viewstate">
						<i class='fa fa-location-arrow'></i> <span>States</span>
					</a>
				</li>
				<li>
					<a href="<?php echo ADMIN_URL;?>main.php?pg=viewlocation">
						<i class='fa fa-location-arrow'></i> <span>Locations</span>
					</a>
				</li>
				
				
			</ul>
		</li> */ ?>
		<?php } ?>
		<?php	if(in_array(13,$tes_mod)) { ?>
		<li>
			<a href="<?php echo ADMIN_URL;?>main.php?pg=viewrating">
				<i class='fa fa-star'></i> <span>Ratings</span>
			</a>
		</li>
		<?php } ?>
		
	</ul>
    </section>
    <!-- /.sidebar -->
  </aside>