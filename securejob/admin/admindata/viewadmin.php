<?php 
if(!in_array(1,$tes_mod)) { 
echo "<div class='grid_12'><div class='message error'><p>You don't have permission to access this page</p></div></div>";
die;
}
// delete record
	$delId = (int)isset($_POST["delId"])?$_POST["delId"]:0;	
	$delRqst = !empty($delId)?TRUE:FALSE; 
	
	if($delRqst) {
		$adminid = ADMINID;
		foreach ($_POST["del"] as $a_id) {	
			if(is_numeric($a_id) && $a_id > 0 AND $a_id != $adminid){	
				$where = "adminid  = {$a_id} AND adminid  <> {$adminid} ";
				if($db->Delete("tbladmin",$where)){
					$_SESSION['mt'] = "success";
					$_SESSION['me'] = "Admin user deleted successfully.";
				}else{
					$_SESSION['mt'] = "error";
					$_SESSION['me'] = "Error while delete admin user. Please try again.";
					
				}
			} else{
				$_SESSION['mt'] = "error";
				$_SESSION['me'] = "Invalid ID/Name.";
				header('Location:main.php?pg=viewadmin');
				exit;	
			}	
			
		}
		header('Location:main.php?pg=viewadmin&delete');
		exit;
		
	}
	
$select_query = mysql_query("select * from tbladmin ORDER By `adminid` DESC");	
?>
<link rel="stylesheet" href="css/dataTables.bootstrap.css">
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>	
<script>
$(function () {
$('#example1').DataTable({
  "paging": true,
  "lengthChange": true,
  "searching": true,
  "ordering": true,
  "info": true,
  "autoWidth": false
});
});
</script>
<script type="text/javascript">
function confirmDelete(){
	var f=0;
	var len=document.form.length;
	for(i=1;i<len;i++){
		if(document.form.elements[i].checked==true){
			f=1;
			break;
		}
		else{	
			f=0;
		}
	}
	if(f==0){
		alert("Atleast select one record to be deleted..!");
		return false;
	}
	else{
		var temp=confirm("Do you really want to delete...!");
			if(temp==false)	{
				return false;
			}
			else{
				document.getElementById("delId").value="del";
				document.form.submit();
			}
	}
}
function selectall()
{
	
	if(document.form.delall.checked==true)
	{
		var chks = document.getElementsByName('del[]');
		
		for(i=0;i<chks.length;i++)
		{
			chks[i].checked=true;
		}
	}
	else if(document.form.delall.checked==false)
	{
		var chks = document.getElementsByName('del[]');
		
		for(i=0;i<chks.length;i++)
		{
			chks[i].checked=false;
		}
	}
}

</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
		<section class="content-header">
		  <h1>Admin user management</h1>
		  <ol class="breadcrumb">
			<li><a href="<?php echo ADMIN_URL; ?>main.php"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="#"><i class="fa fa-user"></i>Admin</a></li>
			
		  </ol>
		</section>
			    <!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
					<form method="post" name="form">
						<div class="box-header">
							<!--<h3 class="box-title">Appointments </h3>-->
							<?php echo getMsg();?>
						</div>
						<div class="box-body">
						<table id="example1" class="table table-bordered table-striped">
						 <input type="hidden" name="delId" id="delId" value="" />	
						<thead>
						<tr>
							<th><input type="checkbox" name="delall" onClick="selectall();"></th>
							<th>First Name</th>
							<th>Last Name</th>							
							<th>Email</th>
							<th>Status</th>
							<th>Modify</th>
						</tr>
						</thead>
						<tbody>
						<?php while($row = mysql_fetch_assoc($select_query)): 
						if(trim($row['isactive']) == '1')
							$isactive = "Active";
						else
							$isactive = "InActive";
						?>					
						<tr>
							<td>
								<?php
									if($row["adminid"] != 1) {
								?>
								<input type='checkbox' name='del[]' value='<?php echo $row["adminid"];?>'>
									<?php } 
									
								?>
							</td>
							<td><?php echo $row['adminfname'] ?></td>
							<td><?php echo $row['adminlname'] ?></td>							
							<td><?php echo $row['adminemail'] ?></td>
							<td>
							<img id="loading-image_<?php echo $row["adminid"];?>" src="img/ajax-loader.gif" style="display:none;"/>
							<span id="ajaxStatus_<?php echo $row["adminid"];?>"><a href="javascript:void(0);" onclick="changeContent(<?php echo $row['adminid'];?> , <?php echo $row['isactive'];?> )"><?php echo $isactive; ?></a></span></td>
							<td><a class="btn btn-primary" href="<?php echo ADMIN_URL; ?>main.php?pg=modadmin&a_id=<?php echo $row['adminid'] ?>"> Modify </a></td>
						</tr>
						
					<?php endwhile; ?>
						</tbody>
						</table>
						<div >
							<button type="button" onclick="confirmDelete()"  name="submit_me"  class="btn btn-primary">Delete</button>
							<button type="button" onclick="location.href='main.php?pg=addadmin'"  name="submit_me"  class="btn btn-primary">Add</button>
						</div>
						</div>
					</form>
					</div>
				</div>
			</div>
		</section>
</div>
<div class="clear"></div>
<script>
function changeContent(id,val){
	var data = {
	"id": id , "val" : val
	};
	data = $(this).serialize() + "&" + $.param(data);
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "phpajax/AdminActiveInactive.php", 
		data: data,
		beforeSend: function() {
		  $("#loading-image_"+id).show();
	   },
		success: function(data) {
			if(data["msg"] == "success"){
				var rowID = data["id"];
				var status = data["status"];
				var statusText = data["statusText"];
				var link  = "<a href='javascript:void(0);' onclick='changeContent(" + id + ", " + status + ")'> " +  statusText + " </a>";
				$("#ajaxStatus_"+rowID).html(link);
				$("#loading-image_"+id).hide();
			}
				
		}
	});
}	
</script>