<?php

$fusionpbx_host = '';

$subpaths = array_filter(explode('/', $_SERVER[REQUEST_URI]));

$actual_link = "http://" . $fusionpbx_host .  "/app/provision/" . $subpaths['3'] ;

$credentials = base64_encode($subpaths['1'] . ":" . $subpaths['2']);





$targetUrl = $actual_link; // Replace with your target URL

$postData = [
    'Host: ' . "'" . $_SERVER['HTTP_HOST'] . "'",
    'Authorization: Basic ' . $credentials . "'"
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $targetUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, $postData ); // For x-www-form-urlencoded
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt(CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

curl_close($ch);


?>
