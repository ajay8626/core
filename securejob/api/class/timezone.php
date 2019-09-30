<?php 
class Timezone
{
	
	public function ConvertDate($Date,$Timezone)
	{
		
		$strsign=substr($Timezone,0,1);
		$h=$strsign.substr($Timezone,1,2)." hours "; 
		$m=$strsign.substr($Timezone,4,2)." minutes";
		$final=$h.$m;
		
			$temp= strtotime("$Date $final");
			$convert = date('Y-m-d H:i:s',$temp); 
			
		return $convert;
	}
	
}




?>