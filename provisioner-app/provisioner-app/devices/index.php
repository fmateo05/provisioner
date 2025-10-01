<?php

define('__ROOT__', dirname(dirname(__FILE__)));

require_once('/var/www/html/env.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];


$subpaths = array_filter(explode('/', $_SERVER[REQUEST_URI]));
$path_strip = preg_replace('/\?_=(\d+)/i', '', $subpaths['3']);
//$mac_address = preg_replace('/\?_=(\d+)/i', '', $subpaths['4']);
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



$lsddir = '/var/www/html/provisioner/api/devices/' . $account . '/' ;
$initial_data = '{ "data": [] }';


if(!file_exists($lsddir)) { 
  shell_exec('mkdir -p ' . $lsddir);
//	if(!file_exists($lsddir . 'devices.json')){
	
	shell_exec('touch ' . $lsddir . 'devices.json');
file_put_contents($lsddir .'devices.json', $initial_data);
	
//	}
}




$cmd_json_auth= 'curl -s -H "Content-Type: application/json" -X PUT ' . $otf_conn . 'user_auth -d ' . "'" . $auth_doc . "'" ;
$json_auth = json_decode(shell_exec($cmd_json_auth),true);
$cmd_json_get= 'curl -s -H "Content-Type: application/json" -H "X-Auth-Token: '. $json_auth['auth_token']. '" -X GET ' . $otf_conn . 'accounts/' . $account ;
$cmd_json_get_devices = 'curl -s -H "Content-Type: application/json" -H "X-Auth-Token: '. $json_auth['auth_token']. '" -X GET ' . $otf_conn . 'accounts/' . $account . '/devices?paginate=false' ;
//$cmd_json_get_devices = 'curl -s -H "Content-Type: application/json" -H "X-Auth-Token: '. $json_auth['auth_token']. '" -X GET ' . $otf_conn . 'accounts/' . $account . '/devices/' ;

if ($requestMethod === 'GET') {
/*
  if(!file_exists($lsddir)) { 
      shell_exec('mkdir -p ' . $lsddir);
	if(!file_exists($lsddir . 'devices.json')){
	
           file_put_contents($lsddir .'devices.json', $initial_data);
	
	}
}
	*/
//$devices = shell_exec($cmd_json_get_devices );
//$output = file_get_contents($lsddir .'devices.json') ;
$devices_crossbar = shell_exec($cmd_json_get_devices);
$devices_decoded_data = json_decode($devices_crossbar,true);
$devices_count = count($devices_decoded_data['data']);
$counts = $devices_decoded_data['0']['page_size'];

$main_json = '{ "data":[] }';

$original_json = '{
    "success": true,
    "data": [
        {
            "mac_address": "000b82f843e1",
            "name": "test gs2170",
            "brand": "grandstream",
            "family": "gxp21xx",
            "model": "gxp2170"
        },
        {
            "mac_address": "000b82f843e2",
            "name": "test yealink",
            "brand": "yealink",
            "family": "t",
            "model": "t46g"
        },
        {
            "brand": "yealink",
            "family": "t",
            "model": "t26p",
            "mac_address": "00156519331a",
            "name": "yealink t26p test"
        },
        {
            "mac_address": "19331a102304",
            "name": "test dp715",
            "brand": "grandstream",
            "family": "dp",
            "model": "dp715"
        }
    ],
    "request_id": "e16ba744-a7e1-4348-8383-5f7ae23b449a"
}';
for($i = 0 ; $i <= $devices_count ; $i++){
$device_id[$i] = $devices_decoded_data['data'][$i]['id'];

$cmd_json_get_device_unit[$i] = 'curl -s -H "Content-Type: application/json" -H "X-Auth-Token: '. $json_auth['auth_token']. '" -X GET ' . $otf_conn . 'accounts/' . $account . '/devices/' . $device_id[$i];


$device_data[$i] = shell_exec($cmd_json_get_device_unit[$i]);

$device_data_decoded[$i] = json_decode($device_data[$i],true);

$mac_address[$i] = $device_data_decoded[$i]['data']['mac_address'];
$name[$i] = $device_data_decoded[$i]['data']['name'];
$brand[$i] = $device_data_decoded[$i]['data']['provision']['endpoint_brand'];
$family[$i] = $device_data_decoded[$i]['data']['provision']['endpoint_family'];
$model[$i]  = $device_data_decoded[$i]['data']['provision']['endpoint_model'];

if (empty($mac_address[$i]) && empty($name[$i])  && empty($brand[$i]) && empty($family[$i]) && empty($model[$i]) ) {

	$i++;
} else if($device_data_decoded[$i]['data']['device_type'] != 'sip_device'){
	$i++;
} else {
$phpArray['data'][] = ['mac_address' => $mac_address[$i], 'name' => $name[$i] , 'brand' => $brand[$i], 'family' => $family[$i], 'model' => $model[$i] ];

$phpmac['data'] = ['mac_address' => $mac_address[$i], 'name' => $name[$i] , 'brand' => $brand[$i], 'family' => $family[$i], 'model' => $model[$i] ];

$macfile[$i] = '/var/www/html/provisioner/api/macaddress/' . $mac_address[$i] . '.json';
if(!file_exists($macfile[$i])){
file_put_contents($macfile[$i], json_encode($phpmac,true)) ;
	}

}

}

$modified_json = json_encode($phpArray,true);

file_put_contents($lsddir .'devices.json', $modified_json);



file_put_contents("/var/www/html/provisioner.log",print_r($phpArray,true));



$output = file_get_contents($lsddir .'devices.json') ;



$devices = json_decode($output,true) ;

header('Content-Type: application/json');
$result = json_encode($devices,true) ;

$cmd = shell_exec('echo ' . $result  . ' | python3 -mjson.tool');

print_r($cmd) ;
print_r($result) ;

} elseif ($requestMethod === 'POST') {
$devices = shell_exec($cmd_json_get_devices );
$input  = file_get_contents('php://input');
$json = json_decode(print_r($input,true),true);
file_put_contents("/var/www/html/provisioner-post.log",print_r($json,true),FILE_APPEND);


} elseif ($requestMethod === 'PUT') {
/*
$devices = shell_exec($cmd_json_get_devices );

$input  = file_get_contents('php://input');
$json = json_decode(print_r($input,true),true);
file_put_contents("/var/www/html/provisioner-put.log",print_r($json,true),FILE_APPEND);
 */
$input  = file_get_contents('php://input');
$json = json_decode(print_r($input,true),true);
$mac = $json['data']['mac_address'];

$putdoc = json_encode($json);

$cmd_json_put_dev = file_put_contents('/var/www/html/provisioner/api/macaddress/' . $mac . '.json',  $putdoc) ;

$putdoc_arr = json_decode($putdoc,true);
//$putdoc_dev_arr = json_decode($output_devices,true);

$originalJson =   $output_devices  ;

$decodedData = json_decode($originalJson,true);

$newData  = [ "mac_address" =>  $putdoc_arr['data']['mac_address'] , "name" =>  $putdoc_arr['data']['name'] , "brand" =>  $putdoc_arr['data']['brand'] , "family" =>   $putdoc_arr['data']['family']  , "model" =>  $putdoc_arr['data']['model']   ];

$decodedData['data'][] = $newData  ;

$modifiedJson = json_encode($decodedData,JSON_PRETTY_PRINT);

//shell_exec($cmd_json_put_dev); 
$lsddir = '/var/www/html/provisioner/api/devices/' . $account . '/' ;
/*
if(!file_exists($lsddir)) { 
  shell_exec('mkdir -p ' . $lsddir);
}
*/


file_put_contents($lsddir .'devices.json', $modifiedJson);


$originalJsonDev = '{ "data":{}}' ;
//$originalJsonDev = $output ;

$dev_decodedData = json_decode($originalJsonDev,true);
$dev_newData = ['mac_address' => $putdoc_arr['data']['mac_address'], "name" => $putdoc_arr['data']['name']];
$dev_prov_newData = [ 'endpoint_brand' => $putdoc_arr['data']['brand'], 'endpoint_family' => $putdoc_arr['data']['family'], 'endpoint_model' => $putdoc_arr['data']['model'] ];

$dev_decodedData['data'] = $dev_newData;
$dev_decodedData['data']['provision'] = $dev_prov_newData;

$modifiedJsonDev = json_encode($dev_decodedData,true);

$cmd_put_devices= 'curl -s -H "Content-Type: application/json" -H "X-Auth-Token: '. $json_auth['auth_token']. '" -X PUT  ' . $otf_conn . 'accounts/' . $account . '/devices/' . ' -d ' . "'" . $modifiedJsonDev . "'"  ;

file_put_contents("/var/www/html/provisioner-put.log",print_r($cmd_put_devices,true),FILE_APPEND);
//shell_exec($cmd_put_devices); 


} elseif ($requestMethod === 'DELETE') {
    echo "This is a DELETE request.";
} else {
    echo "This is an unsupported request method: " . $requestMethod;
}







//$sql_device = "SELECT device_uuid FROM v_devices WHERE device_address='". $mac_address ."';";
//$device_uuid = shell_exec("sudo psql -qtAX -d " . '"' . $dbconn . '" -c ' . '"' . $sql_device . '"'  );
//$device_id = preg_replace('-','', $device_uuid);

//$sql_device = "SELECT domain_uuid FROM v_devices WHERE device_uuid='". $device_uuid ."';";
//$account = shell_exec("sudo psql -qtAX -d " . '"' . $dbconn . '" -c ' . '"' . $sql_device . '"'  );

//file_put_contents("/var/www/html/provisioner.log",print_r($response,true),FILE_APPEND);
