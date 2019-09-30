<?php
include "config.php";

$emailaddress='';
$totRows=0;
if(isset($_POST['emailaddress']) && $_POST['emailaddress']!='')
{
  $emailaddress=$_POST['emailaddress'];
  $sql="select * from tbluser where email='".$emailaddress."' and status=1";  
  $exc=$db->Query($sql);
  $totRows = mysql_num_rows($exc);
  //$totRows;
}
echo $totRows;
exit();
?>