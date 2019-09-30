<?php 
if(!in_array(5,$tes_mod)) { 
echo "<div class='grid_12'><div class='message error'><p>You don't have permission to access this page</p></div></div>";
die;
}
$where = '';
if($_REQUEST['id'] != '' && $_REQUEST['id'] > 0)
{
	$job_id = $_REQUEST['id'];
	$where = " AND jobapply.job_id = $job_id";
}
$select_query = mysql_query("select jobapply.*,user.*,job.* from tbljobsapplied as jobapply
left join tbljobs as job on jobapply.job_id = job.job_id
left join tbluser as user on user.user_id = jobapply.user_id WHERE 1 $where ORDER By jobapply.id DESC");	
?>
<style>
.jobdropdown{
    margin-left: 360px;
	width:20%;
	z-index: 1;
	position: absolute;
	}
.job_label{
	position: absolute;
    margin-left: 325px;
	font-weight: 500; 
	margin-top:6px;
}
</style>
<link rel="stylesheet" href="css/dataTables.bootstrap.css">

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
		<section class="content-header">
		  <h1>
			Bids
			
		  </h1>
		  <ol class="breadcrumb">
			<li><a href="<?php echo ADMIN_URL; ?>main.php"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="#"><i class="fa fa-suitcase"></i>Bids</a></li>
			
		  </ol>
		</section>

    <!-- Main content -->
		 <section class="content">
			  <div class="row">
				<div class="col-xs-12">
				  <div class="box">
					<div class="box-header">
					  <!--<h3 class="box-title">Customer </h3>-->
					  <?php echo getMsg();?>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
					<div class="row">
					<label class="job_label">Jobs</label>
					<select name="jobs" id="jobs" class="jobdropdown form-control">
					<option value="0">Select Job</option>
					<?php 
					$qry=mysql_query("select job_id,job_name from tbljobs where status=1");
					$count=mysql_num_rows($qry);
					if($count > 0)
					{
						while ($row=mysql_fetch_array($qry))
						{
					?>
					<option value="<?php echo $row['job_id'] ?>"
					<?php if(isset($_REQUEST['id']) && $_REQUEST['id']==$row['job_id']){ echo 'selected="selected"'; } ?>><?php echo $row['job_name'] ?></option>
					<?php } 
					}
					?>
					</select>
					</div>
					 <form method="post" name="form">	
					  <table id="example1" class="table table-bordered table-striped">
					  <input type="hidden" name="delId" id = "delId" value="" />	
						<thead>
						<tr>
						  <th>#</th>
						  <th>Job Title</th>
						  <th>Bidder Name</th>
						  <th style="text-align:right;">Bid Price(&pound;)</th>
						  <th style="text-align:right;">No of Persons</th>
						  <th>Job Applied Date</th>
						</tr>
						</thead>
						<tbody>
						<?php 
						$inc = 1;
						if(mysql_num_rows($select_query)){
							while($row = mysql_fetch_assoc($select_query)): 
						
							if(trim($row['status']) == '1')
								$isactive = "Active";
							else
								$isactive = "InActive";
							?>
									<tr>
										<td><?php echo $row['id']; ?></td>
										<td><?php echo $row['job_name']; ?></td>
										<td><?php echo $row['firstname'].' '.$row['lastname']; ?></td>
										<td style="text-align:right;">&pound;<?php echo $row['bidprice']; ?></td>
										<td style="text-align:right;"><?php echo $row['no_of_persons']; ?></td>
										<td><?php echo date('d-m-Y',strtotime($row['applied_date']));?></td>
									 </tr>
						<?php			 

						$inc++;
						endwhile; 
						}?>
						
						
						</tbody>
						
					  </table>
						<?php /* <div >
							<button type="button" onclick="confirmDelete()"  name="submit_me"  class="btn btn-primary">Delete</button>
							<button type="button" onclick="location.href='main.php?pg=addjob'"  name="submit_me"  class="btn btn-primary">Add</button>
						</div> */ ?>
					  </form>
					</div>
					<!-- /.box-body -->
				  </div>
				  <!-- /.box -->
				</div>
				<!-- /.col -->
			  </div>
      <!-- /.row -->
		</section>
    <!-- /.content -->
	</div>
<div class="clear"></div>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>	
<script>
$(function () {
$('#jobs').change(function(){
var job_id=$('#jobs').val();
location.href='<?php echo ADMIN_URL?>main.php?pg=viewjobbids&id='+job_id;
});	
/*
$('#jobs').change(function(){
	//alert("hello");
  $('#example1').DataTable({
  "paging": true,
  destroy: true,
  "lengthChange": true,
  "searching": true,
  "ordering": true,
  "info": true,
  "autoWidth": false,
   "ajax": { "url": "http://192.168.192.154/securethatjob/admin/main.php?pg=viewjobbids","type": "POST","data":function(data) {
							data.jobs = $('#jobs').val();
							
						    
						}},
   });
}); */

	
$('#example1').DataTable({
  "paging": true,
  "lengthChange": true,
  "searching": true,
  "ordering": true,
  "info": true,
  "autoWidth": false,
  "fnInfoCallback": function(oSettings,iStart, iEnd, iMax, iTotal, sPre ) {
	  var tottext = 'entries';
						if(iTotal > 1){ tottext = 'entries'; }else{ tottext = 'entry'; }
						if(iTotal > 0){iStart = iStart;}else{iStart = 0;}
						return 'Showing '+iStart+' to '+iEnd+' of '+iTotal+' '+tottext;
  }
});

});
</script>