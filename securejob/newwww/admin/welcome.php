<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Dashboard
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-home"></i> Home</a></li>
		</ol>
	</section>
	<!-- old data -->
	    <!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-md-6">
					 <div class="box">
					<div class="box-header with-border">
						  
						  <div class="box-body">
						   <h3 class="box-title">Latest 5 Jobs</h3>
						   <table  class="table table-bordered table-striped">
						   <?php 
                           $select_query = mysql_query("select user.*,job.* from tbljobs as job left join tbluser as user on user.user_id = job.job_user_id ORDER By job.job_id DESC limit 0,5");	
		                  ?>				
						<thead>
						<tr>
							<th width="30%">Title</th>
							<!--<th>Name</th>-->
							<th width="50%">Job Location</th>
							<th style="text-align:right;" width="10%">Price</th>
							<th style="text-align:right;" width="10%">Bids</th>
						</tr>
						</thead>
						<?php while($row = mysql_fetch_array($select_query)){ ?>
						<tr>
							<td><a href="<?php echo ADMIN_URL; ?>main.php?pg=modjob&id=<?php echo $row["job_id"]; ?>"><?php echo $row['job_name']; ?></a></td>
							<!--<td><?php // echo $row['firstname'].' '.$row['lastname'];?></td> -->
							<td><?php echo $row['job_location']; ?></td>
							<td style="text-align:right;">&pound;<?php echo $row["price"]; ?></td>
							<td style="text-align:right;"><?php echo bidsCount($row["job_id"]); ?></td>
						</tr>
						<?php } ?>
						   </table>
						  </div>
					</div>
					</div>

				</div>
			
				<div class="col-md-6">
					<div class="box">
					<div class="box-header with-border">
						<div class="box-body">
						<h3 class="box-title">Latest 5 Users</h3>
						   <table id="example1" class="table table-bordered table-striped">
						   <?php 
						$select_query = mysql_query("select * from tbluser ORDER By `user_id` DESC limit 0,5");	
		                   ?>				
		
		                <thead>
						<tr>
							<th width="30%">Name</th>
							<th width="30%">Email</th>
							<th width="10%">Phone</th>
							<th width="30%">User Type</th>
							
						</tr>
						</thead>
						<?php while($row = mysql_fetch_array($select_query)){ 
						
						    if($row['customer_type']==1)
							{
								$type='Business User';
							}elseif($row['customer_type']==2)
							{
								$type='Personal User';
							}else {
							    $type='';
							}
						?>
						<tr>
							<td><a href="<?php echo ADMIN_URL; ?>main.php?pg=moduser&id=<?php echo $row['user_id']; ?>"><?php echo $row["firstname"]."  ".$row["lastname"]; ?></a></td>
							<td><?php echo $row["email"];?></td>
							<td style="text-align:right;"><?php echo $row["phone"]; ?></td>
							<td><?php echo $type; ?></td>
							
						</tr>
						<?php } ?>
						   </table>
						  </div>
					</div>
					</div> 
				</div>
			</div>
      <!-- /.row -->
		</section>
    <!-- /.content -->
</div>

