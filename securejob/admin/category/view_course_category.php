<?php 
if(!in_array(4,$tes_mod)) { 
echo "<div class='grid_12'><div class='message error'><p>You don't have permission to access this page</p></div></div>";
die;
}
$Query= "SELECT * from tblcoursecategory order by category_name asc";

$result = $db->Query($Query);

$delId = (int)isset($_REQUEST["delId"])?$_REQUEST["delId"]:0;	
$delRqst = !empty($delId)?TRUE:FALSE;
if($delRqst && !isset($_REQUEST['del'])) {
	if(is_numeric($delId) && $delId > 0 ){	
		$where = " category_id = {$delId} ";
		$db->Delete("tblcoursecategory",$where);		
	}
	$_SESSION['mt'] = "success";
	$_SESSION['me'] = "Category deleted successfully";
	header("location:main.php?pg=viewcoursecategories");
	exit;
}

if($_REQUEST['del'])
{
	$delarr = $_REQUEST['del'];
	foreach($delarr as $delId)
	{
		$where = " category_id = {$delId} ";
		$db->Delete("tblcoursecategory",$where);					
	}
	$_SESSION['mt'] = "success";
	$_SESSION['me'] = "Categories deleted successfully";
	header("location:main.php?pg=viewcoursecategories");
	exit;
}

?>
<link rel="stylesheet" href="css/dataTables.bootstrap.css">
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>	
<style type="text/css">
#datatable_wrapper #datatable th:first-child {
	background:none;cursor:not-allowed;
}
</style>
 <script type="text/javascript">
         $(document).ready(function () {
            $('#example1').DataTable({
			aoColumnDefs: [ 
				{  bSortable: false, bSearchable: false, aTargets: [ -1,0 ] },
				
			],
			"stateSave": true,
			"fnInfoCallback": function( oSettings, iStart, iEnd, iMax, iTotal, sPre ) {
						var tottext = 'entries';
						if(iTotal > 1){ tottext = 'entries'; }else{ tottext = 'entry'; }
						if(iTotal > 0){iStart = iStart;}else{iStart = 0;}
						return 'Showing '+iStart+' to '+iEnd+' of '+iTotal+' '+tottext;
					},
			//"pageLength": pageLength,
			"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            var settings = this.fnSettings();
            var str = settings.oPreviousSearch.sSearch;
            $('.td', nRow).each( function (i) {
               // this.innerHTML = aData[i].replace( str, '<span class="highlight">'+str+'</span>' );
            } );
            return nRow;
			}
		});
		<?php if(mysql_num_rows($result)<10): ?>
			$('#datatable_paginate').hide();
		<?php endif; ?>
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
		alert("Please select at least one record to delete");
		return false;
	}
	else{
		var temp=confirm("Do you really want to delete the selected records?");
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
	  <h1>
		Course Categories
		
	  </h1>
	  <ol class="breadcrumb">
		<li><a href="<?php echo ADMIN_URL; ?>main.php"><i class="fa fa-home"></i> Home</a></li>
		<li><a href="#"><i class="fa fa-tree"></i>Course Categories</a></li>
		
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
				 <form method="post" name="form">	
				  <table id="example1" class="table table-bordered table-striped">
				  <input type="hidden" name="delId" id = "delId" value="" />	
					<thead>
					<tr>
					  <th><input type="checkbox" name="delall" onClick="selectall();"></th>
					  <th>Name</th>
					  <th>Sort Order</th>
					  <th>Status</th>
					  <th>Action</th>
					</tr>
					</thead>
					<tbody>
					<?php 
					$inc = 1;
					if(mysql_num_rows($result)){
						while($row = mysql_fetch_assoc($result)): 
					
						if(trim($row['isactive']) == '1')
							$isactive = "Active";
						else
							$isactive = "InActive";
						
						echo "<tr>
									<td><input type='checkbox' name='del[]' value='".$row["category_id"]."'></td>
									<td>".$row["category_name"]."</td>
									<td>".$row["sortorder"]."</td>";?>
									<td>
										<img id="loading-image_<?php echo $row["category_id"];?>" src="img/ajax-loader.gif" style="display:none;"/>
										<span id="ajaxStatus_<?php echo $row["category_id"];?>">
											<a href="javascript:void(0);" onclick="changeContent(<?php echo $row['category_id'];?> , <?php echo $row['isactive'];?> )">
											<?php echo $isactive; ?></a>
										</span>
									</td>
									<td>
										<a class='btn btn-primary' href='main.php?pg=addcoursecategory&id=<?=$row["category_id"]?>'>Modify</a>
										<a class='btn btn-warning' onclick="return confirm('Are you sure want to delete this category?')" href='main.php?pg=viewcoursecategories&delId=<?=$row["category_id"]?>' title="are you sure want to delete this category?">Delete</a>
									</td>
							 </tr>
					<?php			 

					$inc++;
					endwhile; 
					}?>
					
					
					</tbody>
					
				  </table>
					<div >
						<button type="button" onclick="confirmDelete()"  name="submit_me"  class="btn btn-primary">Delete</button>
						<button type="button" onclick="location.href='main.php?pg=addcoursecategory'"  name="submit_me"  class="btn btn-primary">Add</button>
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
		url: "phpajax/CourseCategoryActiveInactive.php", 
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