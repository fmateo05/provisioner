<?php


define('__ROOT__', dirname(dirname(__FILE__)));

require_once('/var/www/env.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];

$subpaths = array_filter(explode('/', $_SERVER['REQUEST_URI']));
$path_strip = preg_replace('/\?_=(\d+)/i', '', $subpaths['3']);
$mac_address = preg_replace('/\?_=(\d+)/i', '', $subpaths['4']);
$account = $path_strip ;

$prov_host = "127.0.0.1";
$prov_user = '<user>';
$prov_pass = '<pass>';
$prov_database = 'provisioner_app';

$prov_dbconn = pg_connect('host=' . $prov_host . ' dbname=' . $prov_database . ' user=' . $prov_user . ' password=' . $prov_pass ) ;


$output = file_get_contents('/var/www/html/provisioner/api/macaddress/' . $mac_address .'.json');
$output_devices = file_get_contents('/var/www/html/provisioner/api/devices/' . $account  . '/devices.json');

//$json = json_decode(file_get_contents("php://input"),true);

$dbconn = "postgres://" . $user . ":" . $password . "@" . $host . "/" . $database . "?sslmode=require" ;


//$device_id = $path_strip;
$account_uuid = preg_replace("/(\w{8})(\w{4})(\w{4})(\w{4})(\w{12})/i", "$1-$2-$3-$4-$5", $account);

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
$cmd_json_get_account = 'curl -s -H "Content-Type: application/json" -H "X-Auth-Token: '. $json_auth['auth_token']. '" -X GET ' . $otf_conn . 'accounts/' . $account . '/' ;
$cmd_json_get_devices = 'curl -s -H "Content-Type: application/json" -H "X-Auth-Token: '. $json_auth['auth_token']. '" -X GET ' . $otf_conn . 'accounts/' . $account . '/devices/' ;
$cmd_json_get_device = 'curl -s -H "Content-Type: application/json" -H "X-Auth-Token: '. $json_auth['auth_token']. '" -X GET ' . $otf_conn . 'accounts/' . $account . '/devices/' . $device_id . '/ | python3 -mjson.tool';
$accounts = shell_exec($cmd_json_get_account );
$device = shell_exec($cmd_json_get_device );
//$cmd_json_get_device = 'curl -s -H "Content-Type: application/json" -H "X-Auth-Token: '. $json_auth['auth_token']. '" -X GET ' . $otf_conn . 'accounts/' . $account . '/devices/' . $device_id . '/ | python3 -mjson.tool';

if ($requestMethod === 'GET') {



$sql_devices_sel = "SELECT macaddress,name,brand,family,model from devices WHERE account_id='". $account . "' AND macaddress='". $mac_address ."'";
$sql_devices_query = pg_query($prov_dbconn,$sql_devices_sel);
$rows = pg_fetch_all($sql_devices_query);
$rows_num = pg_num_rows($sql_devices_query);

$devices = json_encode($rows,true,JSON_PRETTY_PRINT) ;


$json_devices =  [  'mac_address' => $rows['0']['macaddress'], 'name' => $rows['0']['name'] , 'brand' => $rows['0']['brand'], 'family' => $rows['0']['family'], 'model' => $rows['0']['model']  ] ;

$json_result = ["data" => $json_devices ]  ;
$data = json_encode($json_result);

$getdoc_arr_acc = json_decode($accounts,true);
$getdoc_acc_data = $getdoc_arr_acc['data'] ;

$getdoc_arr = json_decode($device,true);
$getdoc_data = $getdoc_arr['data'];

$out_data = json_decode($output,true);


$map = [ true =>  "1" , false =>  "0", "true" => "1", "false" => "0" , null => "1" ];

$lines = array_keys($out_data['data']['settings']['lines']);

$outp_data_line = $out_data['data']['settings']['lines'];

$count_lines = count($lines);
if ($count_lines > 1 ){
for ($x = 0 ; $x < $count_lines ; $x++){
$basic_settings[$x] = $outp_data_line[$x]['basic'] ;
$sip_settings[$x] = $outp_data_line[$x]['sip'] ;

// other -- $new_data_parse[$x] = [ 'basic' => ["enable" => $map[$getdoc_data['enabled']], "display_name" => $getdoc_data['name'], "transport" => "udp", "expire" => $getdoc_data['sip']['expire_seconds'], "voicemail" => "*97" ], "sip" => [ "realm" => $getdoc_acc_data["realm"], "username" => $getdoc_data['sip']['username'], "password" => $getdoc_data['sip']['password']], "advanced" => [ "srtp" => "0"]   ]  ;
$new_data_parse[$x] = [ 'basic' => ["enable" => $map[$basic_settings[$x]['enable']], "display_name" => $basic_settings[$x]['display_name'], "transport" => "udp", "expire" => $basic_settings[$x]['expire'], "voicemail" => "*97" ], "sip" => [ "realm" => $sip_settings[$x]["realm"], "username" => $sip_settings[$x]['username'], "password" => $sip_settings[$x]['password']], "advanced" => [ "srtp" => "0"]   ]  ;

//$new_data_parse['settings']['lines'] = [ "0" => [ 'basic' => ["enable" => $map[$getdoc_data['enabled']], "display_name" => $getdoc_data['name'], "transport" => "udp", "expire" => $getdoc_data['sip']['expire_seconds'], "voicemail" => "*97" ], "sip" => [ "realm" => $getdoc_acc_data["realm"], "username" => $getdoc_data['sip']['username'], "password" => $getdoc_data['sip']['password'], "advanced" => [ "srtp" => "0"] ] ], "1" => [ "basic" => []]]  ;

//$out_data['data']['settings']= $new_data_parse['settings'];
$out_data['data']['settings']['lines'] = $new_data_parse ;
$out_data_json = json_encode($out_data,JSON_FORCE_OBJECT);
}
} else {

$new_data_parse['settings']['lines'] = [ "0" => [ 'basic' => ["enable" => $map[$getdoc_data['enabled']], "display_name" => $getdoc_data['name'], "transport" => "udp", "expire" => $getdoc_data['sip']['expire_seconds'], "voicemail" => "*97" ], "sip" => [ "realm" => $getdoc_acc_data["realm"], "username" => $getdoc_data['sip']['username'], "password" => $getdoc_data['sip']['password'], "advanced" => [ "srtp" => "0"] ] ]]  ;
//$new_data_parse['settings']['lines'] = [ "0" => [ 'basic' => ["enable" => $map[$getdoc_data['enabled']], "display_name" => $getdoc_data['name'], "transport" => "udp", "expire" => $getdoc_data['sip']['expire_seconds'], "voicemail" => "*97" ], "sip" => [ "realm" => $getdoc_acc_data["realm"], "username" => $getdoc_data['sip']['username'], "password" => $getdoc_data['sip']['password'], "advanced" => [ "srtp" => "0"] ] ], "1" => [ "basic" => []]]  ;

$out_data['data']['settings']['lines'] = $new_data_parse['settings']['lines'] ;
$out_data_json = json_encode($out_data,JSON_FORCE_OBJECT);

}


file_put_contents("/var/www/html/provisioner/macaddress/" . $mac_address . '.json',$out_data_json);

$output_new = file_get_contents('/var/www/html/provisioner/macaddress/' . $mac_address . '.json');

//print_r($getdoc_arr);

print_r($output_new);















} elseif ($requestMethod === 'POST') {
$cmd_json_get_device = 'curl -s -H "Content-Type: application/json" -H "X-Auth-Token: '. $json_auth['auth_token']. '" -X GET ' . $otf_conn . 'accounts/' . $account . '/devices/' . $device_id . '/ | python3 -mjson.tool';

$input  = file_get_contents('php://input');
$json = json_decode($input,true);
$mac = $json['data']['mac_address'];
//$originalJson = $output ;


$putdoc_arr = $json;
$postdoc = $input ;

//$cmd_json_post_dev = file_put_contents('/var/www/html/provisioner-post.log',  $postdoc) ;


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
//shell_exec($cmd_put_devices);

//file_put_contents('/var/www/html/provisioner-post.log',  $cmd_put_devices) ;

$newData  = [ "mac_address" =>  $putdoc_arr['data']['mac_address'] , "name" =>  $putdoc_arr['data']['name'] , "brand" =>  $putdoc_arr['data']['brand'] , "family" =>   $putdoc_arr['data']['family']  , "model" =>  $putdoc_arr['data']['model'], "settings" => $putdoc_arr['data']['settings']];

$sql_update= "UPDATE devices set macaddress='". $putdoc_arr['data']['mac_address']  . "', name='". $putdoc_arr['data']['name'] . "', brand='". $putdoc_arr['data']['brand'] ."', family='". $putdoc_arr['data']['family'] ."', model='". $putdoc_arr['data']['model'] . "';";
$sql_upd_device = pg_query($prov_dbconn,$sql_update);

$decodedData['data'] = $newData  ;

$modifiedJson = json_encode($decodedData,JSON_PRETTY_PRINT);



$line = array_keys($json['data']['settings']['lines']);
$countline = count($line) ;

$map_true_false = [ "1" => "true" , "0" => "false", "" => "true" ];

$sql_del_lines = "DELETE FROM public.v_device_lines WHERE domain_uuid='". $account_uuid ."' AND device_uuid='". trim($device_uuid) ."';";
shell_exec("sudo psql -d " . '"' . $dbconn . '" -c ' . '"' . $sql_del_lines . '"'  );



for ($z = 0 ; $z < $countline ; $z++) {
$basic_settings[$z] = $json['data']['settings']['lines'][$z]['basic'];
$sip_settings[$z] = $json['data']['settings']['lines'][$z]['sip'];
// $combokeys_settings[$z] = $json['data']['settings']['combo_keys'];

$sql_line[$z]= "INSERT INTO public.v_device_lines (domain_uuid, device_line_uuid, device_uuid, line_number, label, display_name, user_id, auth_id,password, sip_port, sip_transport, register_expires, enabled, server_address) VALUES('" . $account_uuid . "','". trim(file_get_contents('/proc/sys/kernel/random/uuid')) . "','" . trim($device_uuid) .  "','". ($z + 1) ."','" . $basic_settings[$z]['display_name'] . "','" . $basic_settings[$z]['display_name'] . "','" . $sip_settings[$z]['username'] . "','" . $sip_settings[$z]['username'] . "','" . $sip_settings[$z]['password'] . "',5060,'". $basic_settings[$z]['transport'] ."', '". $basic_settings[$z]['expire']. "','". $map_true_false[$basic_settings[$z]['enable']] ."','". $sip_settings[$z]['realm'] . "');";


//
// file_put_contents('/var/www/html/provisioner-post.log', $sql_line_keys[$z]) ;
//
shell_exec("sudo psql -d " . '"' . $dbconn . '" -c ' . '"' . $sql_line[$z] . '"'  );

}

$sel_query = "SELECT value FROM public.v_device_vendor_functions where device_vendor_uuid=(SELECT device_vendor_uuid from v_device_vendors where name='".$putdoc_arr['data']['brand']."') and type='none';";
                $sel_query_call_park = "SELECT value FROM public.v_device_vendor_functions where device_vendor_uuid=(SELECT device_vendor_uuid from v_device_vendors where name='".$putdoc_arr['data']['brand']."') and type='monitored call park';";
                $sel_query_presence = "SELECT value FROM public.v_device_vendor_functions where device_vendor_uuid=(SELECT device_vendor_uuid from v_device_vendors where name='".$putdoc_arr['data']['brand']."') and type='blf';";
                $sel_query_speed_dial = "SELECT value FROM public.v_device_vendor_functions where device_vendor_uuid=(SELECT device_vendor_uuid from v_device_vendors where name='".$putdoc_arr['data']['brand']."') and type='speed dial';";
                $sel_query_line = "SELECT value FROM public.v_device_vendor_functions where device_vendor_uuid=(SELECT device_vendor_uuid from v_device_vendors where name='".$putdoc_arr['data']['brand']."') and type='line';";
                $sel_query_call_return = "SELECT value FROM public.v_device_vendor_functions where device_vendor_uuid=(SELECT device_vendor_uuid from v_device_vendors where name='".$putdoc_arr['data']['brand']."') and type='call_return';";
                $sel_query_transfer = "SELECT value FROM public.v_device_vendor_functions where device_vendor_uuid=(SELECT device_vendor_uuid from v_device_vendors where name='".$putdoc_arr['data']['brand']."') and type='transfer';";

                $none = trim(shell_exec("sudo psql -qtAX -d " . '"' . $dbconn . '" -c ' . '"' . $sel_query . '"'  ));
                $call_park = trim(shell_exec("sudo psql -qtAX -d " . '"' . $dbconn . '" -c ' . '"' . $sel_query_call_park . '"'  ));
                $presence = trim(shell_exec("sudo psql -qtAX -d " . '"' . $dbconn . '" -c ' . '"' . $sel_query_presence . '"'  ));
                $speed_dial = trim(shell_exec("sudo psql -qtAX -d " . '"' . $dbconn . '" -c ' . '"' . $sel_query_speed_dial . '"'  ));
                $lineline = trim(shell_exec("sudo psql -qtAX -d " . '"' . $dbconn . '" -c ' . '"' . $sel_query_line . '"'  ));
                $transfer = trim(shell_exec("sudo psql -qtAX -d " . '"' . $dbconn . '" -c ' . '"' . $sel_query_transfer . '"'  ));
                $call_return = trim(shell_exec("sudo psql -qtAX -d " . '"' . $dbconn . '" -c ' . '"' . $sel_query_call_return . '"'  ));

$combokeys_number = array_keys($json['data']['settings']['combo_keys']) ;
$count_ck_keys = count($combokeys_number);

$sql_del_keys = "DELETE FROM public.v_device_keys WHERE domain_uuid='". $account_uuid ."' AND device_uuid='". trim($device_uuid) ."';";

file_put_contents('/var/www/html/provisioner-post.log', $sql_del_keys) ;
shell_exec("sudo psql -d " . '"' . $dbconn . '" -c ' . '"' . $sql_del_keys . '"'  );

for ($y = 0 ; $y < $count_ck_keys ; $y++) {
$num = (string)$y  ;
$combokeys_settings[$y] = $json['data']['settings']['combo_keys'];

$combokey_type = $combokeys_settings[$y][$combokeys_number[$num]]['key']['type'];
$combokey_label = $combokeys_settings[$y][$combokeys_number[$num]]['key']['label'];
$combokey_value = $combokeys_settings[$y][$combokeys_number[$num]]['key']['value'];

$map_ck = [ 'parking' => $call_park , 'none' => $none , 'presence' => $presence , 'speed_dial' => $speed_dial , 'line' => $lineline , 'transfer' => $transfer , 'calL_return' => $call_return  ] ;

$sql_line_keys[$y]= "INSERT INTO public.v_device_keys (domain_uuid, device_key_uuid, device_uuid, device_key_id, device_key_category, device_key_vendor, device_key_type, device_key_subtype, device_key_line, device_key_value, device_key_extension,  device_key_label) VALUES('".$account_uuid ."', '".trim(file_get_contents('/proc/sys/kernel/random/uuid'))."','". trim($device_uuid) ."','".( $combokeys_number[$num] + 1 )."' , 'line', '".$putdoc_arr['data']['brand']."', (select value from public.v_device_vendor_functions where device_vendor_uuid=(select device_vendor_uuid from public.v_device_vendors where name='". $putdoc_arr['data']['brand'] ."') and type=(SELECT value FROM public.v_device_vendor_functions where device_vendor_uuid=(select device_vendor_uuid from v_device_vendors where name='". $putdoc_arr['data']['brand']  ."') and type='". $map_ck[$combokey_type]."')) , '', '".$combokeys_settings[$y][$combokeys_number[$num]]['key']['account']."', '". $combokey_value  ."', '', '". $combokey_label."');";
//file_put_contents('/var/www/html/provisioner-post.log', print_r($combokeys_settings[$y][$combokeys_number[$num]]['key']['account'],true)) ;
//file_put_contents('/var/www/html/provisioner-post.log', print_r($combokeys_settings[$y][$combokeys_number[$num]]['key']['account'],true)) ;
shell_exec("sudo psql -d " . '"' . $dbconn . '" -c ' . '"' . $sql_line_keys[$y] . '"'  );


}
$cmd_json_post_dev = file_put_contents('/var/www/html/provisioner/macaddress/' . $mac . '.json',  $modifiedJson) ;

//print_r($cmd_json_post_dev);

} elseif ($requestMethod === 'PUT') {
$input  = file_get_contents('php://input');
$json = json_decode(print_r($input,true),true);
$mac = $json['data']['mac_address'];

$putdoc = json_encode($json);

$cmd_json_put_dev = file_put_contents('/var/www/html/provisioner/macaddress/' . $mac . '.json',  $putdoc) ;

$putdoc_arr = json_decode($putdoc,true);
//$putdoc_dev_arr = json_decode($output_devices,true);

$originalJson =   $output_devices  ;

$decodedData = json_decode($originalJson,true);

$newData  = [ "mac_address" =>  $putdoc_arr['data']['mac_address'] , "name" =>  $putdoc_arr['data']['name'] , "brand" =>  $putdoc_arr['data']['brand'] , "family" =>   $putdoc_arr['data']['family']  , "model" =>  $putdoc_arr['data']['model']   ];

$decodedData['data'][] = $newData  ;

$modifiedJson = json_encode($decodedData,true);

shell_exec($cmd_json_put_dev);
$lsddir = '/var/www/html/provisioner/api/devices/' . $account . '/' ;
if(!file_exists($lsddir)) {
  shell_exec('mkdir -p ' . $lsddir);
}


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
$cmd = shell_exec($cmd_put_devices);
$put_json = json_decode($cmd,true);
$device_id  = $put_json['data']['id'];



$sql_ins_device = "INSERT INTO devices (macaddress,brand,family,model,account_id,device_id) VALUES('". $putdoc_arr['data']['mac_address']  ."','". $putdoc_arr['data']['name'] . "','". $putdoc_arr['data']['brand'] ."','". $putdoc_arr['data']['family'] ."','". $putdoc_arr['data']['model'] ."','". $account  ."','". $device_id . "')";
$sql_ins_device = pg_query($prov_dbconn,$sql_ins_device);



print_r($cmd);
file_put_contents("/var/www/html/provisioner-put.log",print_r($putdoc_arr,true));

//$cmd_json_put_dev = file_put_contents('/var/www/html/provisioner/api/macaddress/' . $mac . '.json',  $postdoc) ;


} elseif ($requestMethod === 'DELETE') {

$sql_deviceid_sel = "SELECT device_id FROM devices WHERE account_id='". $account . "' AND macaddress='". $mac_address ."'";
$sql_deviceid_query = pg_query($prov_dbconn,$sql_deviceid_sel);
$row  = pg_fetch_all($sql_deviceid_query);
$device_id = $row['0']['device_id'];


$cmd_json_delete_dev= 'curl -s -H "Content-Type: application/json" -H "X-Auth-Token: '. $json_auth['auth_token']. '" -X DELETE  ' . $otf_conn . 'accounts/' . $account . '/devices/' . $device_id  ;

$cmd_delete = shell_exec($cmd_json_delete_dev);
print_r($cmd_delete);

$sql_delete = "DELETE from devices where account_id='". $account . "' AND macaddress='". $mac_address  ."' AND device_id='". $device_id ."'" ;
$sql_del_device = pg_query($prov_dbconn,$sql_delete);


$cmd_json_del_dev = shell_exec('rm -f /var/www/html/provisioner/api/macaddress/' . $mac . '.json') ;

//file_put_contents("/var/www/html/provisioner-put.log",print_r($row,true));
print_r($sql_deviceid_sel);
print_r($cmd_json_del_dev);


} else {
    echo "This is an unsupported request method: " . $requestMethod;
}
?>
