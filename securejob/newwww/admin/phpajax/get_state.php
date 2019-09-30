<?php
include("../../config.php");
$country_id=$_REQUEST['country_id'];
$state_id=$_REQUEST['state_id'];

				$selectstate = mysql_query("SELECT id, name FROM tblstates where country_id='$country_id' ");				
				?>				
<select name="state_id" data-validation-engine="validate[required]" data-errormessage-value-missing="Please select country" class="input3 mini" style="width: 320px;" onchange="getcity(this.value)">
						<option value="0">-- Select State --</option>
						<?php
						while($staterow = mysql_fetch_array($selectstate))
						{ 
							$statetitle = $staterow['name'];
							?>
							<option <?php if($state_id==$staterow['id']) { echo "selected"; } ?> value="<?php echo $staterow['id']; ?>"><?php echo $statetitle; ?></option>
						<?php } ?>
</select>