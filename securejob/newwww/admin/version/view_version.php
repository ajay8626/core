<?php 
if(!in_array(2,$tes_mod)) { 
echo "<div class='grid_12'><div class='message error'><p>You don't have permission to access this page</p></div></div>";
die;
}


// delete record
$delId = (int)isset($_POST["delId"])?$_POST["delId"]:0;	
$delRqst = !empty($delId)?TRUE:FALSE;

if($delRqst) {
	foreach ($_POST["del"] as $deletAdminID) {	
		if(is_numeric($deletAdminID) && $deletAdminID > 0 ){	
			$where = "id  = {$deletAdminID}";
			if($db->Delete("tblversion",$where)){
				$_SESSION['mt'] = "success";
				$_SESSION['me'] = "Version deleted successfully.";
			}else{
				$_SESSION['mt'] = "error";
				$_SESSION['me'] = "Error while delete Version. Please try again.";
				
			}
		}
		
	}
	header('Location:main.php?pg=viewversion&delete');
	exit;
	
}	
$Query= "SELECT version.* FROM tblversion as version";
$result = $db->Query($Query);

?>
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
<link rel="stylesheet" href="css/dataTables.bootstrap.css">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>Version</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo ADMIN_URL; ?>main.php"><i class="fa fa-dashboard"></i>Home</a></li>
				<li><a href="#"><i class="fa fa-paint-brush"></i>Version</a></li>
			</ol>
		</section>

    <!-- Main content -->
		 <section class="content">
			  <div class="row">
				<div class="col-xs-12">
				  <div class="box">
					<div class="box-header">
					  <h3 class="box-title">Version Management</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
					 <form method="post" name="form">	
					  <table id="example1" class="table table-bordered table-striped">
					  <input type="hidden" name="delId" id = "delId" value="" />	
						<thead>
						<tr>
							<th><input type="checkbox" name="delall" onClick="selectall();"></th>
							<th>Type</th>
							<th>Version</th>
							<th>Url</th>
							<th>Culture code</th>
							<th>Is update available</th>
							<th>Modify</th>
						</tr>
						</thead>
						<tbody>
						<?php
						
								while($row = mysql_fetch_assoc($result)): 
								$id = $row["id"];
								$type = ($row["app_type"]==1) ? 'Android' : 'iPhone';
								$version = $row["app_version"];					
								$url = $row["app_url"];					
								$culture_code = $row["culture_code"];					
								$is_update_available = $row["is_update_available"];
								if($is_update_available=="0") {
									$updateText =  "No update available"; 
								}elseif($is_update_available=="1") {
									$updateText =  "No mandatory update available"; 
								}elseif($is_update_available=="2") { 
									$updateText =  "Mandatory update available"; 
								}
								echo "<tr>
										<td><input type='checkbox' name='del[]' value='".$id."'></td>
										<td>".$type."</td>
										<td>".$version."</td>
										<td>".$url."</td>
										<td>".$culture_code."</td>
										<td>".$updateText."</td>
										<td><a class='btn btn-primary' href='main.php?pg=addversion&id=".$id."'>Modify</a></td>
									 </tr>";
									
								endwhile; ?>
						
						
						</tbody>
						
					  </table>
						<div >
							<button type="button" onclick="confirmDelete()"  name="submit_me"  class="btn btn-primary">Delete</button>
							<!-- <button type="button" onclick="location.href='main.php?pg=addversion'"  name="submit_me"  class="btn btn-primary">Add</button>-->
						</div>
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

