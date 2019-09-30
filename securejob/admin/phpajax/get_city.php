<?php
include("../../config.php");
$state_id=$_REQUEST['state_id'];
$city_id=$_REQUEST['city_id'];



$selectCities = mysql_query("SELECT id, name FROM tblcities where state_id='$state_id' ORDER By name ASC");


?>
<select class="form-control" id="city_id" name="city_id"  size="" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select city name" >
	<option value="">Select City</option>
	<?php
	while($cityRow = mysql_fetch_array($selectCities))
	{ 
		$cityTitle = $cityRow['name'];
		?>
		<option <?php if($city_id==$cityRow['id']) { echo "selected"; } ?> value="<?php echo $cityRow['id']; ?>"><?php echo $cityTitle; ?></option>
	<?php } ?>
</select>