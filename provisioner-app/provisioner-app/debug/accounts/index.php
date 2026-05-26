<?php
require_once('/var/www/env.php');
header('Content-Type: application-json');

//header('Access-Control-Allow-Origin: https://phoneprov.bevoip.net');

define('__ROOT__', dirname(dirname(__FILE__)));

require_once('/var/www/env.php');

$database = 'provisioner_app';

$requestMethod = $_SERVER['REQUEST_METHOD'];


$subpaths = array_filter(explode('/', $_SERVER['REQUEST_URI']));
$path_strip = preg_replace('/\?_=(\d+)/i', '', $subpaths['4']);
$mac_address = preg_replace('/\?_=(\d+)/i', '', $subpaths['6']);
$account = $path_strip ;

//$json = json_decode(file_get_contents("php://input"),true);
$host = "127.0.0.1";
$user = '<user>';
$pass = '<pass>';

$dbconn = pg_connect('host=' . $host . ' dbname=' . $database . ' user=' . $user . ' password=' . $pass ) ;
//$dbconn = "postgres://" . $user . ":" . $password . "@" . $host . "/" . $database . "?sslmode=require" ;


if ($requestMethod === 'GET') {

$file = file_get_contents("https://portal.<domain.com>/links/" . $account . "/" . $mac_address . '.cfg');
$json_data['data'] = ["config_files" => [ $mac_address => $file  ] ];

$json = json_encode($json_data);

print_r($json);






?>
