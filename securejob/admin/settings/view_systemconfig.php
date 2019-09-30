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
			$where = "config_id  = {$deletAdminID}";
			if($db->Delete("tblsystemconfiguration",$where)){
				$_SESSION['mt'] = "success";
				$_SESSION['me'] = "Configuration deleted successfully.";
			}else{
				$_SESSION['mt'] = "error";
				$_SESSION['me'] = "Error while delete Configuration. Please try again.";
				
			}
		}
		
	}
	header('Location:main.php?pg=viewsystemconfig&delete');
	exit;
	
}	


$Query= "SELECT * from tblsystemconfiguration where is_active='active'";

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
			<h1>Settings</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo ADMIN_URL; ?>main.php"><i class="fa fa-dashboard"></i>Home</a></li>
				<li><a href="#"><i class="fa fa-paint-brush"></i>Settings</a></li>
			</ol>
		</section>

    <!-- Main content -->
		 <section class="content">
			  <div class="row">
				<div class="col-xs-12">
				  <div class="box">
					<div class="box-header">
					  <h3 class="box-title">Settings</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
					 <form method="post" name="form">	
					  <table id="example1" class="table table-bordered table-striped">
					  <input type="hidden" name="delId" id = "delId" value="" />	
						<thead>
						<tr>
						 <!--  <th><input type="checkbox" name="delall" onClick="selectall();"></th> -->
						  <th>Key</th>
						  <th>Value</th>
						  <th>Modify</th>
						</tr>
						</thead>
						<tbody>
						<?php
						while($row = mysql_fetch_assoc($result)): 
							$id = $row["config_id"];
							$title_value = $row["title_value"];					
							$title_key = $row["title_key"];
							if($title_key == "Base Price" || $title_key == "Featured Price"){
								$poundSign = '&#163;';
							}else{
								$poundSign = '';
							}			
						
							
							echo "<tr>
										<!-- <td><input type='checkbox' name='del[]' value='".$id."'></td> -->
										<td>".$title_key."</td>
										<td>".$poundSign."".$title_value."</td>
										<td><a class='btn btn-primary' href='main.php?pg=addsystemconfig&id=".$id."'>Modify</a></td>
									 </tr>";
						endwhile; 
						
						?>
						
						
						</tbody>
						
					  </table>
						<div >
							<!--<button type="button" onclick="confirmDelete()"  name="submit_me"  class="btn btn-primary">Delete</button>-->
							<button type="button" onclick="location.href='main.php?pg=addsystemconfig'"  name="submit_me"  class="btn btn-primary">Add</button>
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

