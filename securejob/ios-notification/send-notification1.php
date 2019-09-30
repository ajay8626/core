<?php
$deviceToken = $DeviceId;
$passphrase = '123456';

////////////////////////////////////////////////////////////////////////////////

$ctx = stream_context_create();
//define("SITE_PATH234",$_SERVER['DOCUMENT_ROOT']."/",true);
define("SITE_PATH234",dirname(dirname(__FILE__))."/",true);

if($body['aps']['Receiver'] == 306 || $body['aps']['Receiver'] == 690 ) {
	$filename = SITE_PATH234.'ios-notification/pushDevCert.pem';
} else {
	$filename = SITE_PATH234.'ios-notification/production_Certi_Lawo.pem';
}
//$filename = SITE_PATH234.'ios-notification/production_Certi_Lawo.pem';

stream_context_set_option($ctx, 'ssl', 'local_cert', $filename);
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
/*
//Sandbox
$fp = stream_socket_client(
'ssl://gateway.sandbox.push.apple.com:2195', $err,
$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);*/

if($body['aps']['Receiver'] == 306 || $body['aps']['Receiver'] == 690 ) {
	//Sandbox
	$fp = stream_socket_client(
	'ssl://gateway.sandbox.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
} else {
	//Production
	$fp = stream_socket_client(
	'ssl://gateway.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
}
/*$fp = stream_socket_client(
	'ssl://gateway.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);*/

 if (!$fp)
 {
	//exit("Failed to connect: $err $errstr" . PHP_EOL);     
 }
 
// Encode the payload as JSON

if(is_array($deviceToken))
{
	foreach($deviceToken as $deviceToken)
	{
		$payload = json_encode($body);
		// Build the binary notification
		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . 
		$payload;
		// Send it to the server
		$result = fwrite($fp, $msg, strlen($msg));		
	}
}else{

$payload = json_encode($body);
// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . 
$payload;
// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));

}

/*if (!$result)
    echo 'Message not delivered' . PHP_EOL;
else
    echo 'Message successfully delivered'.PHP_EOL;
*/
// Close the connection to the server
fclose($fp);


	
?>
