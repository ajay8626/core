<?php 
if(!in_array(8,$tes_mod)) { 
echo "<div class='grid_12'><div class='message error'><p>You don't have permission to access this page</p></div></div>";
die;
}
$Query= "SELECT tblgeneralmessage.id, tblgeneralmessage.title_key , tblgeneralmessagetranslation.title_value as title
FROM tblgeneralmessage
LEFT JOIN tblgeneralmessagetranslation ON tblgeneralmessagetranslation.general_message_id = tblgeneralmessage.id
ORDER BY tblgeneralmessage.id DESC";

$result = $db->Query($Query);

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

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>General Message</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo ADMIN_URL; ?>main.php"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="#"><i class="fa fa-comment"></i>General Message</a></li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
				<div class="box-header">
							<h3 class="box-title">General Message </h3>
							<?php echo getMsg();?>
				</div>
				<div class="box-body">
				<table id="example1" class="table table-bordered table-striped">
				<thead>
						<tr class="trheader">
							<th>Title Key</th>
							<th>Message</th>
							<th>Modify</th>
						</tr>
					</thead>
					<tbody>
					<?php while($row = mysql_fetch_assoc($result)): 
					$isactive = $row["status"];
					$id = $row["id"];
					$title = $row["title"];					
					$title_key = $row["title_key"];					
					$sort_order = $row["sort_order"];					
					?>
						<tr>
							<td><?php echo $title_key; ?></td>
							
							<td><?php echo $title; ?></td>
							
														
							<td>
								<a href="<?php echo ADMIN_URL; ?>main.php?pg=addgeneralmsg&id=<?php echo $id; ?>"  class="btn btn-primary"> Modify </a>
							</td>
						</tr>
					<?php endwhile; ?>
					</tbody>
				</table>
				<div>
					<button type="button" onclick="location.href='main.php?pg=addgeneralmsg'"  name="submit_me"  class="btn btn-primary">Add</button>
				</div>
				</div>
				</div>
			</div>
		</div>
	</section>
</div>

<div class="clear"></div>