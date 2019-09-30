<?php 
if(!in_array(10,$tes_mod)) { 
echo "<div class='grid_12'><div class='message error'><p>You don't have permission to access this page</p></div></div>";
die;
}

if($_REQUEST['del'])
{
	$delarr = $_REQUEST['del'];
	foreach($delarr as $delId)
	{
		unlink("../api/crash_report/".$delId);
	}
	$_SESSION['mt'] = "success";
	$_SESSION['me'] = "Record deleted successfully";
	header("location:main.php?pg=viewcrashreport");
	exit;
}

?>

 <script type="text/javascript">
         $(document).ready(function () {
            $('.datatable').dataTable(	{ 
			"order": [[ 2, "desc" ]],
			aoColumnDefs: [ 
				{  bSortable: false, bSearchable: false, aTargets: [ -1 , 0 ] },
				
			],
			"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            var settings = this.fnSettings();
            var str = settings.oPreviousSearch.sSearch;
            $('.td', nRow).each( function (i) {
                this.innerHTML = aData[i].replace( str, '<span class="highlight">'+str+'</span>' );
            } );
            return nRow;
			}
		});
		
	});
</script>
<script type="text/javascript">
function confirmdeleteproduct(){
	var f=0;
	var len=document.countryForm.length;
	for(i=1;i<len;i++){
		if(document.countryForm.elements[i].checked==true){
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
				document.countryForm.submit();
			}
	}
}
function selectall()
{		
	if(document.countryForm.delall.checked==true)
	{			
		var chks = document.getElementsByName('del[]');
		for(i=0;i<chks.length;i++)
		{
			chks[i].checked=true;			
		}
	}
	else if(document.countryForm.delall.checked==false)
	{
		var chks = document.getElementsByName('del[]');
		for(i=0;i<chks.length;i++)
		{
			chks[i].checked=false;
		}
	}
}
</script>

<div class="grid_12 ">
	<div class="box round first fullpage">
		<h2>
			Crash Report
		</h2>
		<div class="block minheight420">
				<form action="" method="post"  name="countryForm">	
                    <table class="data display datatable" id="datatable">
					<thead>
						<tr class="trheader">
							<th width="5%"><input type="checkbox" onclick="selectall();" name="delall"></th>				
								<th>File Name</th>
							<th>Date</th>
							<th width="80px" align="right">Action</th>
						</tr>
					</thead>
					<tbody>
					<?php
					
					$dir = "../api/crash_report/";

					// Open a directory, and read its contents
					if (is_dir($dir)){
					  if ($dh = opendir($dir)){
						while (($file = readdir($dh)) !== false){
						if($file != '.' && $file != '..'){
					?>
					
						<tr class="">
							<td class="td"><input type="checkbox" name="del[]" value="<?php echo $file; ?>"></td>							
							<td class="td">Crash Report</td>
							
							<td class="td">
							<?php echo $file; ?>
							</td>
							<td align="right">
								<a href="<?php echo SITE_URL; ?>/api/crash_report/<?php echo $file; ?>"  class="btn editbtn" target="_blank" > View </a>								
							</td>
						</tr>
					<?php } 
						}
						closedir($dh);
					  }
					}
					?>
					
					
					</tbody>
				</table>
			<input type="submit" value="Delete Multiple" onclick="return confirmdeleteproduct();" class="btn delbtn">
			</form>
		</div>
	</div>
</div>
<div class="clear"></div>