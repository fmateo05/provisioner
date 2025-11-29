<?php

define('__ROOT__', dirname(dirname(__FILE__)));
include_once '/var/www/html/env.php';

require '/var/www/html-alt/prov-wh.php';

require '/var/www/vendor/autoload.php';

$auth_doc = '{
  "data": {
      "credentials": "'. $credentials .'",
      "account_name": "master"
  }
}';

$account = '<MASTER-ACCOUNT-ID>';

$cmd_json_auth= 'curl -s -H "Content-Type: application/json" -X PUT ' . $otf_conn . 'user_auth -d ' . "'" . $auth_doc . "'" ;
$json_auth = json_decode(shell_exec($cmd_json_auth),true);
$cmd_json_get_acc= 'curl -s -H "Content-Type: application/json" -H "X-Auth-Token: '. $json_auth['auth_token']. '" -X GET ' . $otf_conn . 'accounts/' . $account . '/descendants?paginate=false' ;
$accounts = json_decode(shell_exec($cmd_json_get_acc),true);

//print_r($accounts);

$count = count($accounts);

for ($i = 0 ; $i <= $count ; $i++) {

$subacc[$i] = $accounts['data'][$i]['id'];

$payload[$i] = '{
    "action": "subscribe",
    "auth_token": "'. $json_auth['auth_token'] .'",
    "request_id": "'. $subacc[$i] .'",
    "data": {
        "account_id": "'. $subacc[$i] .'",
        "binding": "object.*.*"
    }
}';


}
//print_r($payload);

$output = "test";

function globalOutput($output){
	global $output;


}
function return_output($payload,$client){
    try {
        $message = $client->receive();
        // Act on received message
        // Break while loop to stop listening
	global $output;
	return json_decode($message,true);
    } catch (\WebSocket\ConnectionException $e) {
        // Possibly log errors
    }
}

$client = new WebSocket\Client("ws://10.10.105.2:5555");
for ($j = 0  ; $j <= $count ; $j++){
$client->text($payload[$j]);

}

while (true) {

for ($k = 0 ; $k <= $count ; $k++){
$out[$k] = return_output($payload[$k],$client);
print_r($out[$k]);
provisioner($out[$k]['data']);

}


}
$client->close();
