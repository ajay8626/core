<?php
function get_lat_long($address){

    //$address = str_replace(" ", "+", $address);

    $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=".urlencode($address)."&key=AIzaSyA_JUu2G9vlijX1UgNTylx55U1hZQqw6QI&sensor=false");
    $json = json_decode($json,true);
     echo '<pre>'; print_r($json);
	 exit;
    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
    return $lat.','.$long;
}
$location='MGT DESIGN LTD PORTFOLIO CENTRE, ST GEORGES AVENUE,NORTHAMPTON,NORTHAMPTONSHIRE,NN2 6FB
UK';
 $latlong    =   get_lat_long($location); // create a function with the name "get_lat_long" given as below
        $map        =   explode(',' ,$latlong);
        echo $mapLat         =   $map[0];
        echo $mapLong    =   $map[1];
exit;		
?>