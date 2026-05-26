<?php
require_once('/var/www/env.php');
header('Content-Type: application-json');



define('__ROOT__', dirname(dirname(__FILE__)));

require_once('/var/www/env.php');

$database = 'provisioner_app';

$requestMethod = $_SERVER['REQUEST_METHOD'];


$subpaths = array_filter(explode('/', $_SERVER['REQUEST_URI']));
$path_strip = preg_replace('/\?_=(\d+)/i', '', $subpaths['4']);
//$mac_address = preg_replace('/\?_=(\d+)/i', '', $subpaths['4']);
$account = $path_strip ;
if(empty($subpahts['4'])){



$account = $_SERVER['REMOTE_ADDR'];


}

//$json = json_decode(file_get_contents("php://input"),true);
$host = "127.0.0.1";
$user = '<user>';
$pass = '<pass>';

$dbconn = pg_connect('host=' . $host . ' dbname=' . $database . ' user=' . $user . ' password=' . $pass ) ;
//$dbconn = "postgres://" . $user . ":" . $password . "@" . $host . "/" . $database . "?sslmode=require" ;


if ($requestMethod === 'GET') {














//file_put_contents($lsddir .'devices.json', $modified_json);





//$output = file_get_contents($lsddir .'devices.json') ;


$sql_devices_sel = "SELECT * from check_ip  WHERE ip='". $account . "'";
$sql_devices_query = pg_query($dbconn,$sql_devices_sel);
$rows = pg_fetch_all($sql_devices_query);
//$rows_num = pg_num_rows($sql_devices_query);

$devices = json_encode($rows,true,JSON_PRETTY_PRINT) ;

$json_devices[] = [];

$map = ['t' => true, 'f' => false, 'T' => true, 'F' => false];

$json_devices =  [  'banned' => $map[$rows['0']['banned']], 'failed' => $map[$rows['0']['failed']] , 'whitelist' => $map[$rows['0']['whitelist']], 'blacklist' => $map[$rows['0']['blacklist']], "ip" => $account  ] ;

}

$json_result = ["data" => $json_devices ]  ;
$data = json_encode($json_result) ?? '{"data":{}}';



print_r($data);



?>
