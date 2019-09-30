<?php
$deviceToken = 'D04516D77FCC116F6F5E289F6BF0FB09EF151A6EB72A79A7A4E0A7EF5EC4E64A';

$passphrase = '1234';

$message = 'My ios push notification...!';

////////////////////////////////////////////////////////////////////////////////

$ctx = stream_context_create();
//$filename = 'apns-dev-cert.pem';
define("SITE_PATH234",dirname(dirname(__FILE__))."/",true);
$filename = SITE_PATH234.'ios-notification/WindowCleaner_Distribution.pem';
stream_context_set_option($ctx, 'ssl', 'local_cert', $filename);
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
$fp = stream_socket_client(
'ssl://gateway.push.apple.com:2195', $err,
$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)
exit("Failed to connect: $err $errstr" . PHP_EOL);

echo 'Connected to APNS' . PHP_EOL;

// Create the payload body
$body['aps'] = array(
'alert' => $message,
'sound' => 'default',
'badge' => 10
);

// Encode the payload as JSON
$payload = json_encode($body);

// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));

if (!$result)
    echo '<br>Message not delivered' . PHP_EOL;
else
    echo '<br>Message successfully delivered'.PHP_EOL;

// Close the connection to the server
fclose($fp);

?>