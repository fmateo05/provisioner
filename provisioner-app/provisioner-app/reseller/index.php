<?php

define('__ROOT__', dirname(dirname(__FILE__)));

require_once('/var/www/html/env.php');

$urltest = '/var/www/html/provisioner/api/reseller/providers.json';

$provider = file_get_contents($urltest);

//$urltest = 'https://portal.disruptive-telecom.com/p/api/phones/grandstream/gxp/gxp2170/' ;

$subpaths = array_filter(explode('/', $_SERVER[REQUEST_URI]));
$path_strip = preg_replace('/\?_=(\d+)/i', '', $subpaths['3']);
$mac_address = preg_replace('/\?_=(\d+)/i', '', $subpaths['4']);
$account = $path_strip ;

//$json = json_decode(file_get_contents("php://input"),true);
$dbconn = "postgres://" . $user . ":" . $password . "@" . $host . "/" . $database . "?sslmode=require" ;


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
*/
$cmd_json_auth= 'curl -s -H "Content-Type: application/json" -X PUT ' . $otf_conn . 'user_auth -d ' . "'" . $auth_doc . "'" ;
$json_auth = json_decode(shell_exec($cmd_json_auth),true);
$cmd_json_get= 'curl -s -H "Content-Type: application/json" -H "X-Auth-Token: '. $json_auth['auth_token']. '" -X GET ' . $urltest ;
//$cmd_json_get= 'curl -s -H "Content-Type: application/json" -H "X-Auth-Token: '. $json_auth['auth_token']. '" -X GET ' . $otf_conn . 'accounts/' . $account ;
//$cmd_json_get_devices = 'curl -s -H "Content-Type: application/json" -H "X-Auth-Token: '. $json_auth['auth_token']. '" -X GET ' . $otf_conn . 'accounts/' . $account . '/devices/' ;
$cmd_json_get_device = 'curl -s -H "Content-Type: application/json" -H "X-Auth-Token: '. $json_auth['auth_token']. '" -X GET ' . $otf_conn . 'accounts/' . $account . '/devices/' . $device_id ;

$accounts = shell_exec('cat ' . $urltest  . '| python3 -mjson.tool');
$result = $accounts ;

//$accounts = shell_exec($cmd_json_get . ' | python3 -mjson.tool');

header('Content-Type: application/json');
print_r($result)  ;







//$sql_device = "SELECT domain_uuid FROM v_devices WHERE device_uuid='". $device_uuid ."';";
//$account = shell_exec("sudo psql -qtAX -d " . '"' . $dbconn . '" -c ' . '"' . $sql_device . '"'  );

file_put_contents("/var/www/html/provisioner.log",print_r($cmd_json_get_device,true),FILE_APPEND);
?>
