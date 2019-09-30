<?php 
if(!in_array(10,$tes_mod)) { 
echo "<div class='grid_12'><div class='message error'><p>You don't have permission to access this page</p></div></div>";
die;
}
$delId = (int)isset($_REQUEST["delId"])?$_REQUEST["delId"]:0;	
$delRqst = !empty($delId)?TRUE:FALSE;
if($delRqst) {
	if(is_numeric($delId) && $delId > 0 ){	
		$db->Delete("tblcmspages"," page_id=".$delId);
	}
	$_SESSION['mt'] = "success";
	$_SESSION['me'] = "Deleted successfully";
	header("location:main.php?pg=viewcms");
	exit;
}

if($_REQUEST['del'])
{
	$delarr = $_REQUEST['del'];
	foreach($delarr as $delId)
	{
		$db->Delete("tblcmspages"," page_id=".$delId);
	}
	$_SESSION['mt'] = "success";
	$_SESSION['me'] = "Deleted successfully";
	header("location:main.php?pg=viewcms");
	exit;
}

?>
<link rel="stylesheet" href="css/dataTables.bootstrap.css">
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>	
 <script type="text/javascript">
		$(document).ready(function() {
			$('#example1').DataTable( {
				"bProcessing": true,
				"bServerSide": true,
				"filter": true,
				"stateSave": true,
				"fnInfoCallback": function( oSettings, iStart, iEnd, iMax, iTotal, sPre ) {
						var tottext = 'entries';
						if(iTotal > 1){ tottext = 'entries'; }else{ tottext = 'entry'; }
						if(iTotal > 0){iStart = iStart;}else{iStart = 0;}
						return 'Showing '+iStart+' to '+iEnd+' of '+iTotal+' '+tottext;
					},
				//"pageLength": pageLength,
				"sAjaxSource": "<?php echo ADMIN_URL; ?>cmspages/script.php",
				
				aoColumnDefs: [ 
						{  bSortable: false, bSearchable: false, aTargets: [ -1 , 0 ] },							
					],
				 "aoColumns": [ 
				 {"sClass": "center"},
				 {"sClass": "center"},
				 {"sClass": "center"}
				 ],
			} );
		} );
</script>
<script type="text/javascript">
function confirmdeleteproduct(){
	var f=0;
	var len=document.userForm.length;
	for(i=1;i<len;i++){
		if(document.userForm.elements[i].checked==true){
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
				document.userForm.submit();
			}
	}
}
function selectall()
{		
	if(document.userForm.delall.checked==true)
	{			
		var chks = document.getElementsByName('del[]');
		for(i=0;i<chks.length;i++)
		{
			chks[i].checked=true;			
		}
	}
	else if(document.userForm.delall.checked==false)
	{
		var chks = document.getElementsByName('del[]');
		for(i=0;i<chks.length;i++)
		{
			chks[i].checked=false;
		}
	}
}
function viewAction(str,id)
{

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtAction-"+id).innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","<?php echo ADMIN_URL ;?>cmsaction.php?q="+str+"&page_id="+id,true);
xmlhttp.send();

}

</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>CMS management</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo ADMIN_URL; ?>main.php"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="#"><i class="fa fa-folder"></i>CMS</a></li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
				<div class="box-header">
							<h3 class="box-title">CMS </h3>
							<?php echo getMsg();?>
				</div>
				<div class="box-body">
				<table id="example1" class="table table-bordered table-striped">
					<thead>
						<tr class="trheader">
							<?php /* <th><input type="checkbox" onclick="selectall();" name="delall"></th> */ ?>
							<th width="25%">Page Title</th>
							<!--<th width="15%">Url</th>-->
							<th width="15%">Status</th>
							<th width="10%">Action</th>
						</tr>
					</thead>
					<tbody>
					
					</tbody>
				</table>
				<div>
					<button type="button" onclick="location.href='main.php?pg=addcms'"  name="submit_me"  class="btn btn-primary hidden">Add</button>
				</div>
				</div>
				</div>
			</div>
		</div>
	</section>
</div>

<div class="clear"></div>