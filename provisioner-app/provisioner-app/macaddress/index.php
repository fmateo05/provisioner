<?php

define('__ROOT__', dirname(dirname(__FILE__)));

require_once('/var/www/html/env.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];

$subpaths = array_filter(explode('/', $_SERVER[REQUEST_URI]));
$path_strip = preg_replace('/\?_=(\d+)/i', '', $subpaths['3']);
$mac_address = preg_replace('/\?_=(\d+)/i', '', $subpaths['4']);
$account = $path_strip ;

$output = file_get_contents('/var/www/html/provisioner/api/macaddress/' . $mac_address .'.json');
$output_devices = file_get_contents('/var/www/html/provisioner/api/devices/' . $account  . '/devices.json');


//$json = json_decode(file_get_contents("php://input"),true);
$dbconn = "postgres://" . $user . ":" . $password . "@" . $host . "/" . $database . "?sslmode=require" ;


//$device_id = $path_strip;
$device_uuid = preg_replace("/(\w{8})(\w{4})(\w{4})(\w{4})(\w{12})/i", "$1-$2-$3-$4-$5", $path_strip);

$auth_doc = '{
  "data": {
      "credentials": "'. $credentials .'",
      "account_name": "master"
  }
}';

$sql_device = "SELECT device_uuid FROM v_devices WHERE device_address='". $mac_address ."';";
$device_uuid = shell_exec("sudo psql -qtAX -d " . '"' . $dbconn . '" -c ' . '"' . $sql_device . '"'  );
$device_id = str_replace('-','', $device_uuid);

$cmd_json_auth= 'curl -s -H "Content-Type: application/json" -X PUT ' . $otf_conn . 'user_auth -d ' . "'" . $auth_doc . "'" ;
$json_auth = json_decode(shell_exec($cmd_json_auth),true);
$cmd_json_get= 'curl -s -H "Content-Type: application/json" -H "X-Auth-Token: '. $json_auth['auth_token']. '" -X GET ' . $otf_conn . 'accounts/' . $account ;
$cmd_json_get_devices = 'curl -s -H "Content-Type: application/json" -H "X-Auth-Token: '. $json_auth['auth_token']. '" -X GET ' . $otf_conn . 'accounts/' . $account . '/devices/' ;
$cmd_json_get_device = 'curl -s -H "Content-Type: application/json" -H "X-Auth-Token: '. $json_auth['auth_token']. '" -X GET ' . $otf_conn . 'accounts/' . $account . '/devices/' . $device_id . '/ | python3 -mjson.tool';
$device = shell_exec($cmd_json_get_device );
//$cmd_json_get_device = 'curl -s -H "Content-Type: application/json" -H "X-Auth-Token: '. $json_auth['auth_token']. '" -X GET ' . $otf_conn . 'accounts/' . $account . '/devices/' . $device_id . '/ | python3 -mjson.tool';

if ($requestMethod === 'GET') {

$devices = json_decode($output,true) ;

//header('Content-Type: application/json');
$result = json_encode($devices,JSON_PRETTY_PRINT) ;

//$cmd = shell_exec('echo ' . $result  . ' | python3 -mjson.tool');

print_r($result) ;




//$sql_device = "SELECT domain_uuid FROM v_devices WHERE device_uuid='". $device_uuid ."';";
//$account = shell_exec("sudo psql -qtAX -d " . '"' . $dbconn . '" -c ' . '"' . $sql_device . '"'  );

//file_put_contents("/var/www/html/provisioner.log",print_r($cmd_json_get_device,true),FILE_APPEND);

} elseif ($requestMethod === 'POST') {
$cmd_json_get_device = 'curl -s -H "Content-Type: application/json" -H "X-Auth-Token: '. $json_auth['auth_token']. '" -X GET ' . $otf_conn . 'accounts/' . $account . '/devices/' . $device_id . '/ | python3 -mjson.tool';

$input  = file_get_contents('php://input');
$json = json_decode($input,true);
$mac = $json['data']['mac_address'];
//$originalJson = $output ;

$cmd_json_post_dev = file_put_contents('/var/www/html/provisioner-post.log',  $postdoc) ;

$putdoc_arr = $json;
$postdoc = $input ;



$decodedData = json_decode($postdoc,true);
//$decodedData = json_decode($originalJson,true);

$dataDeviceOrig = shell_exec($cmd_json_get_device);
$DataDevice = json_decode($dataDeviceOrig,true);   
$newDataDevice = $DataDevice['data'] ;

//file_put_contents("/var/www/html/provisioner-post.log",print_r($postdoc,true),FILE_APPEND);

   function cast_numbers_to_strings(&$item, $key) {
        if (is_numeric($item)) {
            $item = (string) $item;
        }
    }

$count_ck  = count($putdoc_arr['data']['settings']['combo_keys']);
for ($i = 0 ; $i <= $count_ck ; $i++){
$y = $i + 1;
$type[$i] = $putdoc_arr['data']['settings']['combo_keys'][$i]['key']['type'];
if($type[$i] === "parking"){
$value[$i] = (int)$putdoc_arr['data']['settings']['combo_keys'][$i]['key']['value'];
} else {

$value[$i] = $putdoc_arr['data']['settings']['combo_keys'][$i]['key']['value'];

}
$label[$i] = $putdoc_arr['data']['settings']['combo_keys'][$i]['key']['label'];
//$newDataDevice['data']['provision'][['combo_keys'][$i]] = [$i];
if (empty($type[$i]) || empty($value[$i])  || empty($label[$i])) {
$newDataDevice['provision']['combo_keys']["'" . $i . "'"] = [ 'type' => "line"    ] ;

	$i++;
} else {


$newDataDevice['provision']['combo_keys']["'" . $i . "'"] = [ 'type' => $type[$i], 'value' => [ 'value' => $value[$i], 'label' => $label[$i]]   ] ;
//$prov_data_device[$i] =  [ 'type' => $type[$i], 'value' => [ 'value' => $value[$i], 'label' => $label[$i] ]   ] ;
//$newDataDevice['data']['provision']['combo_keys']["'" . $i . "'" ]  =  $prov_data_device[$i] ;
}
//$newDataDevice['data']['provision'] = $newDataSettings;
//array_walk_recursive($newDataDevice,'cast_numbers_to_strings');
}
unset($newDataDevice['ringtones']);
unset($newDataDevice['contact_list']);
unset($newDataDevice['music_on_hold']);
if(empty($newDataDevice['provision']['feature_keys'])){
unset($newDataDevice['provision']['feature_keys']);
}
else if(empty($newDataDevice['provision']['combo_keys'])){
unset($newDataDevice['provision']['combo_keys']);
}
$modifiedDataDevice = json_encode($newDataDevice );


$stripJson = preg_replace("/\\'/",'',$modifiedDataDevice);
$striptoObjJson = preg_replace("/[]/",'{}',$stripJson);

$cmd_put_devices= 'curl -s -H "Content-Type: application/json" -H "X-Auth-Token: '. trim($json_auth['auth_token']). '" -X POST  ' . $otf_conn . 'accounts/' . $account . '/devices/' . trim($device_id) . ' -d ' . "'{" . '"data": '  . $stripJson  .  "}'"  ;
shell_exec($cmd_put_devices);

file_put_contents('/var/www/html/provisioner-post.log',  $cmd_put_devices) ;

$newData  = [ "mac_address" =>  $putdoc_arr['data']['mac_address'] , "name" =>  $putdoc_arr['data']['name'] , "brand" =>  $putdoc_arr['data']['brand'] , "family" =>   $putdoc_arr['data']['family']  , "model" =>  $putdoc_arr['data']['model'], "settings" => $putdoc_arr['data']['settings']];


$decodedData['data'][] = $newData  ;

$modifiedJson = json_encode($decodedData,JSON_PRETTY_PRINT);

//file_put_contents('/var/www/html/provisioner/api/macaddress/' . $mac . '.json', $postdoc) ;
$cmd_json_post_dev = file_put_contents('/var/www/html/provisioner/api/macaddress/' . $mac . '.json',  $postdoc) ;

print_r($cmd_json_post_dev);

} elseif ($requestMethod === 'PUT') {
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

$modifiedJson = json_encode($decodedData,true);

shell_exec($cmd_json_put_dev); 
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
$cmd = shell_exec($cmd_put_devices); 
print_r($cmd);

} elseif ($requestMethod === 'DELETE') {

$cmd_delete = 'rm -f /var/www/html/provisioner/api/macaddress/' . $mac_address .'.json';

$cmd_json_delete_dev= 'curl -s -H "Content-Type: application/json" -H "X-Auth-Token: '. $json_auth['auth_token']. '" -X DELETE  ' . $otf_conn . 'accounts/' . $account . '/devices/' . $device_id  ;

shell_exec($cmd_json_delete_dev); 
shell_exec($cmd_delete); 


} else {
    echo "This is an unsupported request method: " . $requestMethod;
}
?>
