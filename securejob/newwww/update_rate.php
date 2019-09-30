<?php
include "config.php";
$cat=isset($_POST['cat'])?$_POST['cat']:'';
$user_id=$_SESSION['user_id'];
if(!empty($cat))
{
	foreach($cat as $key => $value)
	{
		if($value!='')
		{
			$checkrate=mysql_query("select id from tblusercategoryratecard where category_id=".$key." and user_id=".$user_id."");
			$norecords=mysql_num_rows($checkrate);
			if($norecords == 0)
			{
			$insert=mysql_query("Insert tblusercategoryratecard SET category_id=".$key.",user_id=".$user_id.",rate=".$value."");
			}
			else
			{
				$update=mysql_query("Update tblusercategoryratecard SET rate=".$value." where category_id=".$key." and user_id=".$user_id."");
			}
		}
	}
	echo '1';
	exit();
}

?>