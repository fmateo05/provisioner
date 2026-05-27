<?php

define('__ROOT__', dirname(dirname(__FILE__)));

require_once('/var/www/env.php');

$subpaths = array_filter(explode('/', $_SERVER['REQUEST_URI']));
$path_strip = preg_replace('/\?_=(\d+)/i', '', $subpaths['3']);
$mac_address = preg_replace('/\?_=(\d+)/i', '', $subpaths['4']);
$account = $path_strip ;
$master_account = 'f1058a50b27bab81ca64ad9ac2c49879';

//$json = json_decode(file_get_contents("php://input"),true);
$dbconn = "postgres://" . $user . ":" . $password . "@" . $host . "/" . $database . "?sslmode=require" ;

$testurl = file_get_contents('/var/www/html/api/reseller/providers.json');


$device_uuid = preg_replace("/(\w{8})(\w{4})(\w{4})(\w{4})(\w{12})/i", "$1-$2-$3-$4-$5", $path_strip);

$auth_doc = '{
  "data": {
      "credentials": "'. $credentials .'",
      "account_name": "master"
  }
}';

/*
$sql_device = "SELECT device_uuid FROM v_devices WHERE device_address='". $mac_address ."';";
$device_uuid = shell_exec("sudo psql -qtAX -d " . '"' . $dbconn . '" -c ' . '"' . $sql_device . '"'  );
$device_id = str_replace('-','', $device_uuid);
$cmd_json_auth= 'curl -s -H "Content-Type: application/json" -X PUT ' . $otf_conn . 'user_auth -d ' . "'" . $auth_doc . "'" ;
$json_auth = json_decode(shell_exec($cmd_json_auth),true);
$cmd_json_get= 'curl -s -H "Content-Type: application/json" -H "X-Auth-Token: '. $json_auth['auth_token']. '" -X GET ' . $otf_conn . 'accounts/' . $account ;
$cmd_json_get_devices = 'curl -s -H "Content-Type: application/json" -H "X-Auth-Token: '. $json_auth['auth_token']. '" -X GET ' . $otf_conn . 'accounts/' . $account . '/devices/' ;
$cmd_json_get_device = 'curl -s -H "Content-Type: application/json" -H "X-Auth-Token: '. $json_auth['auth_token']. '" -X GET ' . $otf_conn . 'accounts/' . $account . '/devices/' . $device_id ;

//$accounts = shell_exec($cmd_json_get . ' | python3 -mjson.tool');
$result =  json_decode($testurl,true) ;
$accounts = shell_exec('echo  ' . $result . ' | python3 -mjson.tool');
header('Content-Type: application/json; charset=utf-8');
print_r(json_encode($result))  ;
*/

$requestMethod = $_SERVER['REQUEST_METHOD'];
$initial_data = '{
    "data": {
        "settings": {
            "lines": [
                {
                    "sip": {
                        "realm": "sip.2600hz.com"
                    }
                }
            ],
            "datetime": {
                "time": {
                    "timezone": "America/Los_Angeles"
                }
            }
        }
    }
}';


if ($requestMethod === 'GET') {

//$devices = shell_exec($cmd_json_get_devices );
$init_provider_data = file_get_contents('/var/www/html/provisioner/api/reseller/' . $master_account . '/');

$lsddir = '/var/www/html/provisioner/api/reseller/' . $account . '/' ;
  if(!file_exists($lsddir)) {
      shell_exec('mkdir -p ' . $lsddir);
	if(!file_exists($lsddir . 'provider.json')){

           file_put_contents($lsddir .'provider.json', $initial_provider_data);

	}

}

$output = file_get_contents($lsddir . 'provider.json') ;

header('Content-Type: application/json');
$result = json_encode($output) ;

//$cmd = shell_exec('echo ' . $result  . ' | python3 -mjson.tool');

//print_r($result) ;
print_r($output) ;

} elseif ($requestMethod === 'POST') {
$input  = file_get_contents('php://input');

$postdoc = $input;

$json = json_decode(print_r($input,true),true);

file_put_contents($testurl,  $postdoc) ;

file_put_contents("/var/www/html/provisioner-post.log",print_r($postdoc,true));


} elseif ($requestMethod === 'PUT') {

$input  = file_get_contents('php://input');
$putdoc = json_encode($input,true);

$lsddir = '/var/www/html/provisioner/api/reseller/' . $account . '/' ;
  if(!file_exists($lsddir)) {
      shell_exec('mkdir -p ' . $lsddir);
	if(!file_exists($lsddir . 'account.json')){

           file_put_contents($lsddir .'provider.json', $initial_data);

	}
}


$json = json_decode(print_r($input,true),true);
file_put_contents("/var/www/html/provisioner-put.log",print_r($json,true),FILE_APPEND);

file_put_contents($lsddir . $input,  $putdoc) ;



} elseif ($requestMethod === 'DELETE') {
    echo "This is a DELETE request.";
} else {
    echo "This is an unsupported request method: " . $requestMethod;
}




