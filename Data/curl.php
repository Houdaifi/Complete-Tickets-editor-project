<?php
// create a new cURL resource
$ch = curl_init();

// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, "http://ip-api.com/json/24.48.0.1");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1);

// grab URL and pass it to the browser
$var = curl_exec($ch);
$var1 = json_decode($var);
// var_dump($var1);
// exit();
echo $var1->country;

// close cURL resource, and free up system resources
curl_close($ch);
?>