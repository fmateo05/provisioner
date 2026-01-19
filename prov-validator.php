<?php

require_once('/var/www/env.php');


$auth_doc = '{
  "data": {
      "credentials": "'. $credentials .'",
      "account_name": "master"
  }
}';

$account = '<master-account-id>';

$cmd_json_auth= 'curl -s -H "Content-Type: application/json" -X PUT ' . $otf_conn . 'user_auth -d ' . "'" . $auth_doc . "'" ;
$json_auth = json_decode(shell_exec($cmd_json_auth),true);
$cmd_json_get_acc= 'curl -s -H "Content-Type: application/json" -H "X-Auth-Token: '. $json_auth['auth_token']. '" -X GET ' . $otf_conn . 'accounts/' . $account . '/descendants?paginate=false' ;
$accounts = json_decode(shell_exec($cmd_json_get_acc),true);


$count = count(array_keys($accounts['data']));

for ($i = 0 ; $i < $count ; $i++) {

//$accounts = json_decode(shell_exec($cmd_json_get_acc),true);
$subacc[$i] = $accounts['data'][$i]['id'];

$cmd_json_get_devices[$i] = 'curl -s -H "Content-Type: application/json" -H "X-Auth-Token: '. $json_auth['auth_token']. '" -X GET ' . $otf_conn . 'accounts/' . $subacc[$i] . '/devices?paginate=false' ;

$devices[$i] = json_decode(shell_exec($cmd_json_get_devices[$i]),true);
$count_devices = count(array_keys($devices[$i]['data']));

	for ($j = 0 ; $j < $count_devices ; $j++){
	
	$device[$j] = $devices[$i]['data'][$j]['id'];

$payload_device[$j] = '{
    "id": "'. $device[$j] .'",
    "account_id": "'.$subacc[$i] .'",
    "action": "doc_edited",
    "type": "device",
    "cluster_id": "'. $account .'"
}';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1/prov-webhook.php");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload_device[$j]);
curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type: application/json '));
$output_device=curl_exec($ch);


		
	  

				}
$payload_account[$i] = '{
    "id": "'. $subacc[$i] .'",
    "account_id": "'. $subacc[$i] .'",
    "action": "doc_edited",
    "type": "account",
    "cluster_id": "'. $account . '"
}';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1/prov-webhook.php");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload_account[$i]);
curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type: application/json '));
$output_account=curl_exec($ch);


	}



