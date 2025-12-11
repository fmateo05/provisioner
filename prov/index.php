<?php

$fusionpbx_host = '10.76.147.5';

$subpaths = array_filter(explode('/', $_SERVER['REQUEST_URI']));
if(isset($subpaths['4'])) {
$actual_link = "http://" . $fusionpbx_host .  "/app/provision/" . $subpaths['3'] . "/" . $subpaths['4'] ;
} else {

$actual_link = "http://" . $fusionpbx_host .  "/app/provision/" . $subpaths['3'] ;

}
$credentials = base64_encode($subpaths['1'] . ":" . $subpaths['2']);



$targetUrl = $actual_link; // Replace with your target URL

$basehost = $_SERVER['HTTP_HOST'];

$http_host = parse_url($basehost, PHP_URL_HOST);

/*

$request_headers = [];
$request_headers[] = 'Host: ' . $http_host ;
$request_headers[] = 'Authorization: Basic ' . $credentials ;
$request_headers[] = 'User-Agent: ' . $_SERVER['HTTP_USER_AGENT'] ;
$request_headers[] = 'Content-Type: text/plain; charset=utf-8';


//$cmd = 'curl  -H ' .   '"Authorization: Basic '  . $credentials  . '" ' .  '-H  . "User-Agent: ' . $_SERVER['HTTP_USER_AGENT'] . '" -H  "Content-Type: application/xml" -H "Host: ' . $_SERVER['HTTP_HOST'] . '"  '   . $targetUrl;
*/
$options = [
    'http' => [
        'method' => 'GET',
        'header' => "Host: " . $http_host . "\r\n" .
                    "User-Agent: " . $_SERVER['HTTP_USER_AGENT'] ."\r\n" .
                    "Authorization: Basic " . $credentials . '"'
    ]
];

$context = stream_context_create($options);

$url = $targetUrl;

/*
$response = file_get_contents($url, false, $context);

header('Content-Type: text/plain');

//$response  = shell_exec($cmd);
if ($response === false) {
//    echo "Error fetching content.";
	http_response_code(404);
} else {
//    echo "Content received:\n";
//   http_response_code(401);
	 print_r($response) ;
}


function curl_get_contents($url, $request_headers)
{
    $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers); // For x-www-form-urlencoded
   curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
   $html = curl_exec($ch);
   $data = curl_exec($ch);
   curl_close($ch);
   return $data;
}
header('Content-Type: text/plain');
$response =  curl_get_contents($url,$request_headers);
*/
header('Content-Type: text/plain');
$response = file_get_contents($url, false, $context);

if ($response === false) {
//    echo "Error fetching content.";
	http_response_code(404);
} else {
//    echo "Content received:\n";
//   http_response_code(401);
	 printf('%s',$response) ;
}


/*
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $targetUrl);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers); // For x-www-form-urlencoded
curl_setopt(CURLOPT_RETURNTRANSFER, true);

curl_exec($ch);

curl_close($ch);
*/
?>
