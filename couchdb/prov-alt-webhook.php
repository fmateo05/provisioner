<?php
ini_set('display_errors', '0');
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);


function _get_account_db($account_id) {
        // account/xx/xx/xxxxxxxxxxxxxxxx
        return "account/" . substr_replace(substr_replace($account_id, "/", 2, 0), "/", 5, 0);
    }
function device_value_user($device_key_value,$account_db,$conn){


$result_user['presence_id'] = $request_data_device['presence_id'] ?: '100' ;


//file_put_contents('/var/www/html/webhook-data.log',print_r($command_user,true));

return $result_user['presence_id'];

//file_put_contents("/var/www/html/webhook-data.log",print_r($json,true), FILE_APPEND);
}



function provisioner($wh_action,$wh_type,$account_id,$device_id,$row_doc) {

$json = ["id" => $device_id , "type" => $wh_type , "action" => $wh_action , "account_id" => $account_id ];







//$account_id = $json['account_id'];




$account_db = str_replace('/','%2F',_get_account_db($account_id));



//$conn = "http://" . $couch_user . ':' . $couch_pass . '@' . $couch_host . ':' . $couch_port ;
$device = $device_id;

$command_dev = "curl -s ". $conn . '/'  . $account_db . '/' . $device . '| python3 -mjson.tool' ;
//$document = shell_exec($command_dev);

$result_dev[] = [];//json_decode($document,true);



$account = $account_id;


$command_acc = "curl -s ". $conn . '/'  . $account_db . '/' . $account . '| python3 -mjson.tool' ;
//$document_acc = shell_exec($command_acc);

$result_acc[] = [] ; //json_decode($document_acc,true);


$request_data_account  = $row_doc;
$request_data_user  = $row_doc ;
$request_data_device  = $row_doc;

$other_uuid = trim(file_get_contents('/proc/sys/kernel/random/uuid'));




$account_couchdb_id = $account_id;

$account_uuid = preg_replace("/(\w{8})(\w{4})(\w{4})(\w{4})(\w{12})/i", "$1-$2-$3-$4-$5", $account_couchdb_id);



//$dbconn = "postgres://" . $user . ":" . $password . "@" . $host . "/" . $database . "?sslmode=require" ;

// En lugar de tu variable $dbconn actual, creamos la conexión nativa:
$host = '<fusionpbx-host>';
$database = 'fusionpbx';
$user = 'fusionpbx';
$password = '<fusion-db-password>';


$dbconn = "host=$host dbname=$database user=$user password=$password sslmode=require";
$conn_pg = pg_connect($dbconn);

if (!$conn_pg) {
    file_put_contents("/var/www/html/webhook-data.log", "Error connecting to native PostgreSQL\n", FILE_APPEND);
    exit;
}

$prov_domain =  str_replace('sip','prov',$request_data_account['realm']) ;
$sip_domain =  $request_data_device['sip']['realm'] ;

$auth_doc = '{
  "data": {
      "credentials": "'. $credentials .'",
      "account_name": "master"
  }
}';

$otf_json = '{
   "data":{
    "grandstream_config_server_path": "'. $prov_url .'",
    "http_auth_username": "'. $account .'",
    "http_auth_password": "'. $other_uuid .'"
  }
}';

$cmd_json_auth= 'curl -s -H "Content-Type: application/json" -X PUT ' . $otf_conn . 'user_auth -d ' . "'" . $auth_doc . "'" ;
$json_auth = json_decode(shell_exec($cmd_json_auth),true);
$cmd_json_get= 'curl -s -H "Content-Type: application/json" -H "X-Auth-Token: '. $json_auth['auth_token']. '" -X GET ' . $otf_conn . 'accounts/' . $account ;
$cmd_json_patch = 'curl -s -H "Content-Type: application/json" -H "X-Auth-Token: ' . $json_auth['auth_token'] . '"  -X PATCH ' . $otf_conn . 'accounts/' . $account  .  ' -d ' . "'".  $otf_json  . "'";
//$cmd_json_post = 'curl -s -H "Content-Type: application/json" -X PUT ' . $conn . '/accounts/' . $account . '?rev=' . $json_rev  .  ' -d ' . "'".  $otf_json  . "'";
//$cmd_json_del= 'curl -s -H "Content-Type: application/json" -X DELETE ' . $otf_conn . '/' . $otf_couch_schema . '/'  . $account . '?rev=' . $json_rev  ;

    $sql_settings_prov_check = "SELECT domain_setting_uuid FROM public.v_domain_settings WHERE domain_uuid = $1 AND domain_setting_category = $2 AND domain_setting_subcategory = $3 LIMIT 1;";



//	$sql_settings_prov_check  = "SELECT * from public.v_domain_settings WHERE domain_uuid ='" . $account_uuid . "' AND domain_setting_category='provision' AND domain_setting_subcategory='enabled' LIMIT 1;" ;
/*
	$sql_settings_auth_type = "INSERT INTO public.v_domain_settings (domain_uuid, domain_setting_uuid, domain_setting_category, domain_setting_subcategory, domain_setting_name, domain_setting_value, domain_setting_order, domain_setting_enabled, domain_setting_description) VALUES('". $account_uuid ."','". new_uuid() ."','provision', 'auth_type', 'text','basic', 0, true, 'added from webhook');";
        $sql_settings_prov_enable = "INSERT INTO public.v_domain_settings (domain_uuid, domain_setting_uuid, domain_setting_category, domain_setting_subcategory, domain_setting_name, domain_setting_value, domain_setting_order, domain_setting_enabled, domain_setting_description) VALUES('". $account_uuid ."','". new_uuid() ."','provision', 'enabled', 'boolean',true, 0, true, 'added from webhook');";
        $sql_settings_httpauth_enable = "INSERT INTO public.v_domain_settings (domain_uuid, domain_setting_uuid, domain_setting_category, domain_setting_subcategory, domain_setting_name, domain_setting_value, domain_setting_order, domain_setting_enabled, domain_setting_description) VALUES('". $account_uuid ."','". new_uuid() ."','provision', 'http_auth_enabled', 'boolean',true, 0, true, 'added from webhook');";
        $sql_settings_httpauth_username = "INSERT INTO public.v_domain_settings (domain_uuid, domain_setting_uuid, domain_setting_category, domain_setting_subcategory, domain_setting_name, domain_setting_value, domain_setting_order, domain_setting_enabled, domain_setting_description) VALUES('". $account_uuid ."','". new_uuid() ."','provision', 'http_auth_username', 'text','". $account_id ."', 0, true, 'added from webhook');";
        $sql_settings_httpauth_password = "INSERT INTO public.v_domain_settings (domain_uuid, domain_setting_uuid, domain_setting_category, domain_setting_subcategory, domain_setting_name, domain_setting_value, domain_setting_order, domain_setting_enabled, domain_setting_description) VALUES('". $account_uuid ."','". new_uuid() ."','provision', 'http_auth_password', 'array','". $other_uuid  ."', 0, true, 'added from webhook');";
        $sql_settings_gs_url_path = "INSERT INTO public.v_domain_settings (domain_uuid, domain_setting_uuid, domain_setting_category, domain_setting_subcategory, domain_setting_name, domain_setting_value, domain_setting_order, domain_setting_enabled, domain_setting_description) VALUES('". $account_uuid ."','". new_uuid() ."','provision', 'grandstream_config_server_path', 'text','". $prov_domain . "/app/provision/', 0, true, 'added from webhook');";
        $sql_settings_gs_pb_url_path = "INSERT INTO public.v_domain_settings (domain_uuid, domain_setting_uuid, domain_setting_category, domain_setting_subcategory, domain_setting_name, domain_setting_value, domain_setting_order, domain_setting_enabled, domain_setting_description) VALUES('". $account_uuid ."','". new_uuid() ."','provision', 'grandstream_phonebook_xml_server_path', 'text','". $prov_domain . "/app/provision/', 0, true, 'added from webhook');";
        $sql_settings_gs_pb_download = "INSERT INTO public.v_domain_settings (domain_uuid, domain_setting_uuid, domain_setting_category, domain_setting_subcategory, domain_setting_name, domain_setting_value, domain_setting_order, domain_setting_enabled, domain_setting_description) VALUES('". $account_uuid ."','". new_uuid() ."','provision', 'grandstream_phonebook_download', 'text','3', 0, true, 'added from webhook');";
        $sql_settings_gs_pb_interval= "INSERT INTO public.v_domain_settings (domain_uuid, domain_setting_uuid, domain_setting_category, domain_setting_subcategory, domain_setting_name, domain_setting_value, domain_setting_order, domain_setting_enabled, domain_setting_description) VALUES('". $account_uuid ."','". new_uuid() ."','provision', 'grandstream_phonebook_interval', 'text','5', 0, true, 'added from webhook');";
        $sql_settings_gs_contact_gs= "INSERT INTO public.v_domain_settings (domain_uuid, domain_setting_uuid, domain_setting_category, domain_setting_subcategory, domain_setting_name, domain_setting_value, domain_setting_order, domain_setting_enabled, domain_setting_description) VALUES('". $account_uuid ."','". new_uuid() ."','provision', 'contact_grandstream', 'boolean','1', 0, true, 'added from webhook');";
         $sql_settings_yealink_provision_url = "INSERT INTO public.v_domain_settings (domain_uuid, domain_setting_uuid, domain_setting_category, domain_setting_subcategory, domain_setting_name, domain_setting_value, domain_setting_order, domain_setting_enabled, domain_setting_description) VALUES('". $account_uuid ."','". new_uuid() ."','provision', 'yealink_provision_url', 'text','". $prov_url ."', 0, true, 'added from webhook');";
        $sql_settings_yealink_trust_ctrl = "INSERT INTO public.v_domain_settings (domain_uuid, domain_setting_uuid, domain_setting_category, domain_setting_subcategory, domain_setting_name, domain_setting_value, domain_setting_order, domain_setting_enabled, domain_setting_description) VALUES('". $account_uuid ."','". new_uuid() ."','provision', 'yealink_trust_ctrl', 'text','0', 0, true, 'added from webhook');";
        $sql_settings_yealink_trust_certs = "INSERT INTO public.v_domain_settings (domain_uuid, domain_setting_uuid, domain_setting_category, domain_setting_subcategory, domain_setting_name, domain_setting_value, domain_setting_order, domain_setting_enabled, domain_setting_description) VALUES('". $account_uuid ."','". new_uuid() ."','provision', 'yealink_trust_certificates', 'text','0', 0, true, 'added from webhook');";
	$sql_settings_remove = "DELETE FROM public.v_domain_settings WHERE domain_uuid='". $account_uuid  ."';";

*/



	if ($json['action'] === 'doc_created' && $json['type'] === 'account'){

// good $sql = "INSERT INTO public.v_domains (domain_uuid, domain_name, domain_enabled, domain_description) VALUES('". $account_uuid ."', '" . $prov_domain  .  "', true , '". $request_data_account['name'] ."');";
       $sql = "INSERT INTO public.v_domains (domain_uuid, domain_name, domain_enabled, domain_description) VALUES($1, $2 , $3 , $4 );";

        $params = [
            $account_uuid ,
            $prov_domain ,
            true ,
            $request_data_account['name']
        ];
        safe_sql_exec($conn_pg, $sql, $params);
        file_put_contents("/var/www/html/webhook-data.log",$params, FILE_APPEND);

	


//	shell_exec("sudo psql -d " . '"' . $dbconn . '" -c ' . '"' . $sql . '"'  );

	} else if ($json['action'] === 'doc_edited'&& $json['type'] === 'account'){
//	$sel_query_acc = "SELECT domain_uuid from public.v_domains WHERE domain_name='". $prov_domain ."';";
        $sel_query_acc = "SELECT domain_uuid from public.v_domains WHERE domain_uuid = $1;";
//	$query_account =  trim(shell_exec("sudo psql -qtAX -d " . '"' . $dbconn . '" -c ' . '"' . $sel_query_acc . '"'  ));
        $query_account =  safe_sql_exec($conn_pg, $sel_query_acc, [$account_uuid]);
	if (pg_num_rows($query_account) == 0) {
	file_put_contents("/var/www/html/webhook-data.log",print_r($sql,true), FILE_APPEND);
//	$sql_ins = "INSERT INTO public.v_domains (domain_uuid, domain_name, domain_enabled, domain_description) VALUES('". $account_uuid ."', '" .  $prov_domain .  "', true , '". $request_data_account['name'] ."');";
        $sql_ins = "INSERT INTO public.v_domains (domain_uuid, domain_name, domain_enabled, domain_description) VALUES($1, $2 , $3 , $4 );";
        safe_sql_exec($conn_pg, $sql_ins, [$account_uuid, $prov_domain,true,$request_data_account['name']]);
	} else {
//	$sql = "UPDATE public.v_domains SET domain_name='" . $prov_domain . "', domain_description='". $request_data_account['name'] ."' WHERE domain_uuid='" . $account_uuid .   "';";
        $sql = "UPDATE public.v_domains SET domain_name = $1, domain_description = $2 WHERE domain_uuid = $3;";
        $sql_params = [
            $prov_domain,
            $request_data_account['name'],
            $account_uuid
        ];

	safe_sql_exec($conn_pg, $sql, $sql_params);
        
        

        }
        
        $res_check = safe_sql_exec($conn_pg, $sql_settings_prov_check, [$account_uuid, 'provision', 'enabled']);
	//file_put_contents("/var/www/html/webhook-data.log",$sql_settings_check, FILE_APPEND);

	if (pg_num_rows($res_check) == 0) {
$sql_insert_setting = "INSERT INTO public.v_domain_settings
    (domain_uuid, domain_setting_uuid, domain_setting_category, domain_setting_subcategory, domain_setting_name, domain_setting_value, domain_setting_order, domain_setting_enabled, domain_setting_description)
    VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9);";

// Agrupamos tus configuraciones en una matriz limpia
$settings_to_insert = [
    ['http_auth_type', 'text', 'basic', 0, 'true'],
    ['enabled', 'boolean', 'true', 0, 'true'],
    ['http_auth_enabled', 'boolean', 'true', 0, 'true'],
    ['http_auth_username', 'text', $account_id, 0, 'true'],
    ['http_auth_password', 'array', $other_uuid, 0, 'true'],
    ['grandstream_config_server_path', 'text', $prov_domain . ":444/" . $account_id . '/' . $other_uuid . '/', 0, 'true'],
    ['grandstream_phonebook_xml_server_path', 'text', $prov_domain . ":444/" . $account_id . '/' . $other_uuid . '/', 0, 'true'],
    ['grandstream_phonebook_download', 'text', '3', 0, 'true'],
    ['grandstream_phonebook_interval', 'text', '5', 0, 'true'],
    ['contact_grandstream', 'boolean', '1', 0, 'true'],
    ['yealink_provision_url', 'text', 'https://' .  $prov_domain . ":444/" . $account_id . '/' . $other_uuid . '/', 0, 'true'],
    ['yealink_trust_ctrl', 'text', '0', 0, 'true'],
    ['yealink_trust_certificates', 'text', '0', 0, 'true']
];

// Recorremos la matriz y ejecutamos con el Helper seguro
foreach ($settings_to_insert as $set) {
    $params = [
        $account_uuid,       // $1
        new_uuid(),          // $2
        'provision',         // $3 (category)
        $set[0],             // $4 (subcategory)
        $set[1],             // $5 (name)
        $set[2],             // $6 (value)
        $set[3],             // $7 (order)
        $set[4],             // $8 (enabled)
        'added from webhook' // $9 (description)
    ];

    safe_sql_exec($conn_pg, $sql_insert_setting, $params);
}

	}

        







        } else if ($json['action'] === 'doc_deleted' && $json['type'] === 'account'){
	$sql = "DELETE from public.v_domains WHERE domain_uuid = $1 ;";
	file_put_contents("/var/www/html/webhook-data.log",print_r($sql,true), FILE_APPEND);
        safe_sql_exec($conn_pg, $sql, [$account_uuid]);

	} else {
		                echo "No action or event from webhook performed";
	        }


$device_uuid = preg_replace("/(\w{8})(\w{4})(\w{4})(\w{4})(\w{12})/i", "$1-$2-$3-$4-$5", $device_id);
$account_couch_id = $request_data_device['pvt_account_id'];
$account_couch_uuid = "(SELECT domain_uuid FROM public.v_domains WHERE domain_name='". $prov_domain ."')";
//$account_couch_uuid = preg_replace("/(\w{8})(\w{4})(\w{4})(\w{4})(\w{12})/i", "$1-$2-$3-$4-$5", $account_couch_id);
$mac_address = $request_data_device['mac_address'];
$alllinesck = array_values(array_keys($request_data_device['provision']['combo_keys'])) ;
$alllinesfk = array_values(array_keys($request_data_device['provision']['feature_keys']))  ;

if(isset($alllinesfk)) {
$countfk = 16;
} else {
$countfk = 16;
}

if(isset($alllinesck)){
$countck =  16;
} else {
$countck =  16;
}

if(isset($alllinesek)){
$countek =  16;
} else {
$countek =  16;
}

if(isset($alllinespk)){
$countpk =  16;
} else {
$countpk =  16;
}

$model = $request_data_device['provision']['endpoint_model'];
$brand =  $request_data_device['provision']['endpoint_brand'];
switch($brand){
    case "avaya":
       $modelup = strtoupper($model);
       break;
    case "snom":
        $modelup = strtoupper($model);
       break;
    default:
        $modelup = $model;
        break;
}


	if ($json['action'] === 'doc_created' && $json['type'] === 'device'){
//	$sql = "INSERT INTO public.v_devices (device_uuid, domain_uuid, device_address, device_label, device_vendor, device_model, device_enabled, device_template, device_username, device_password, device_description) VALUES('" . $device_uuid . "'," . $account_couch_uuid . ",'" . $mac_address  . "','" . $request_data_device['name'] . "','" . $request_data_device['provision']['endpoint_brand'] . "','" . $modelup . "', true ,'" . $request_data_device['provision']['endpoint_brand'] . "/" . $modelup . "','" . $request_data_device['sip']['username'] .  "','"  . $request_data_device['sip']['password'] . "','" . $request_data_device['name'] . "');";
	$sql = "INSERT INTO public.v_devices (device_uuid, domain_uuid, device_address, device_label, device_vendor, device_model, device_enabled, device_template, device_username, device_password, device_description) VALUES($1 , $2 , $3 , $4 , $5, $6, $7, $8, $9, $10, $11);";
        $sql_params = [
            $device_uuid,
            $account_uuid,
            $request_data_device['mac_address'],
            $request_data_device['name'],
            $request_data_device['provision']['endpoint_brand'],
            $modelup,
            'true',
            $brand . '/' . $modelup,
            $request_data_device['sip']['username'],
            $request_data_device['sip']['password'],
            $request_data_device['name']
              ];
        safe_sql_exec($conn_pg,$sql,$sql_params);
//        $sql_line= "INSERT INTO public.v_device_lines (domain_uuid, device_line_uuid, device_uuid, line_number, display_name, user_id, auth_id,password, sip_port, sip_transport, register_expires, enabled,server_address) VALUES(" . $account_couch_uuid . ",'". trim(file_get_contents('/proc/sys/kernel/random/uuid')) . "','" . $device_uuid .  "',1,'" . $request_data_device['name'] . "','" . $request_data_device['sip']['username'] . "','" . $request_data_device['sip']['username'] . "','" . $request_data_device['sip']['password'] . "',5060, 'udp', 300,  true,'" . $sip_domain.  "');";

        $sql_line= "INSERT INTO public.v_device_lines (domain_uuid, device_line_uuid, device_uuid, line_number, label, display_name, user_id, auth_id,password, sip_port, sip_transport, register_expires, enabled, server_address) VALUES($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14);";
        $sql_line_params = [
            $account_uuid ,
            new_uuid() ,
            $device_uuid ,
            '1' ,
            $request_data_device['name'] ,
            $request_data_device['name'] ,
            $request_data_device['sip']['username'] ,
            $request_data_device['sip']['username'] ,
            $request_data_device['sip']['password'],
            '5060',
            'udp',
            '300',
            'true',
            $sip_domain
                ];

//        $sql_line= "INSERT INTO public.v_device_lines (domain_uuid, device_line_uuid, device_uuid, line_number, display_name, user_id, auth_id,password, sip_port, sip_transport, register_expires, enabled,server_address) VALUES($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12);";
//        $sql_line_params = [ $account_uuid, new_uuid() ,  $device_uuid , '1' , $request_data_device['name'] , $request_data_device['sip']['username'] , $request_data_device['sip']['username'] , $request_data_device['sip']['password'], "5060" , 'udp', '300',  true, $sip_domain ];
        safe_sql_exec($conn_pg,$sql_line,$sql_line_params);

//        $sql_line_domain= "UPDATE public.v_device_lines set server_address = '" . $sip_domain . "'  WHERE domain_uuid=". $account_couch_uuid  ." AND device_uuid='". $device_uuid  ."';";
         $sql_line_domain= "UPDATE public.v_device_lines set server_address = $1  WHERE domain_uuid = $2 AND device_uuid =  $3;";

	file_put_contents("/var/www/html/webhook-data.log",$sql, FILE_APPEND);

//	shell_exec("sudo psql -d " . '"' . $dbconn . '" -c ' . '"' . $sql_line_domain . '"'  );
	$res_check = safe_sql_exec($conn_pg, $sql_settings_prov_check, [$account_uuid, 'provision', 'enabled']);
	file_put_contents("/var/www/html/webhook-data.log",$sql_settings_check, FILE_APPEND);

	if (pg_num_rows($res_check) == 0) {
$sql_insert_setting = "INSERT INTO public.v_domain_settings
    (domain_uuid, domain_setting_uuid, domain_setting_category, domain_setting_subcategory, domain_setting_name, domain_setting_value, domain_setting_order, domain_setting_enabled, domain_setting_description)
    VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9);";

// Agrupamos tus configuraciones en una matriz limpia
$settings_to_insert = [
    ['http_auth_type', 'text', 'basic', 0, 'true'],
    ['enabled', 'boolean', 'true', 0, 'true'],
    ['http_auth_enabled', 'boolean', 'true', 0, 'true'],
    ['http_auth_username', 'text', $account_id, 0, 'true'],
    ['http_auth_password', 'array', $other_uuid, 0, 'true'],
    ['grandstream_config_server_path', 'text', $prov_domain . ":444/" . $account_id . '/' . $other_uuid . '/', 0, 'true'],
    ['grandstream_phonebook_xml_server_path', 'text', $prov_domain . ":444/" . $account_id . '/' . $other_uuid . '/', 0, 'true'],
    ['grandstream_phonebook_download', 'text', '3', 0, 'true'],
    ['grandstream_phonebook_interval', 'text', '5', 0, 'true'],
    ['contact_grandstream', 'boolean', '1', 0, 'true'],
    ['yealink_provision_url', 'text', $prov_domain . ":444/" . $account_id . '/' . $other_uuid . '/', 0, 'true'],
    ['yealink_trust_ctrl', 'text', '0', 0, 'true'],
    ['yealink_trust_certificates', 'text', '0', 0, 'true']
];

// Recorremos la matriz y ejecutamos con el Helper seguro
foreach ($settings_to_insert as $set) {
    $params = [
        $account_uuid,       // $1
        new_uuid(),          // $2
        'provision',         // $3 (category)
        $set[0],             // $4 (subcategory)
        $set[1],             // $5 (name)
        $set[2],             // $6 (value)
        $set[3],             // $7 (order)
        $set[4],             // $8 (enabled)
        'added from webhook' // $9 (description)
    ];

    safe_sql_exec($conn_pg, $sql_insert_setting, $params);
}




	}


	} if ($json['action'] === 'doc_deleted' && $json['type'] === 'device'){
	$sql = "DELETE FROM public.v_devices WHERE device_uuid = $1 ;";

	safe_sql_exec($conn_pg, $sql,[$device_uuid]);

	} else if  ($json['action'] === 'doc_edited' && $json['type'] === 'device'){
//	        $sel_query_devices = "SELECT device_uuid FROM public.v_devices WHERE domain_uuid='". $account_uuid ."' AND device_address='". $mac_address ."';";
            $sel_query_devices = "SELECT device_uuid FROM public.v_devices WHERE domain_uuid = $1 AND device_address =  $2 ;";


	        $sel_query_device_line = "SELECT device_line_uuid FROM v_device_lines WHERE device_uuid = $1  AND domain_uuid = $2 AND line_number = $3;";
	        $query_devices =  safe_sql_exec($conn_pg, $sel_query_devices,[$account_uuid, $mac_address]) ;
	        $query_lines =  safe_sql_exec($conn_pg, $sel_query_device_line,[$device_uuid, $account_uuid, 1 ]);
                $query_lines_rows = pg_fetch_assoc($query_lines);
                $query_lines_info = $query_lines_rows['device_line_uuid'];

	        if(pg_num_rows($query_devices) == 0){
//	        $sql_ins = "INSERT INTO public.v_devices (device_uuid, domain_uuid, device_address, device_label, device_vendor, device_model, device_enabled, device_template, device_username, device_password) VALUES('". $device_uuid ."','" . $account_uuid . "','".$mac_address."', '".$request_data_device['name'] ."', '". $request_data_device['provision']['endpoint_brand']  ."','". $modelup ."', true ,'". $request_data_device['provision']['endpoint_brand'] . '/' . $modelup . "', '". $request_data_device['sip']['username'] ."', '" . $request_data_device['sip']['password'] . "') ;";
                $sql_ins = "INSERT INTO public.v_devices (device_uuid, domain_uuid, device_address, device_label, device_vendor, device_model, device_enabled, device_template, device_username, device_password) VALUES($1, $2, $3, $4, $5, $6, $7, $8, $9, $10) ;";
                $params_ins = [
                    $device_uuid ,
                    $account_uuid ,
                    $mac_address ,
                    $request_data_device['name'],
                    $request_data_device['provision']['endpoint_brand'] ,
                    $modelup,
                    true ,
                    $request_data_device['provision']['endpoint_brand'] . '/' . $modelup ,
                    $request_data_device['sip']['username'],
                    $request_data_device['sip']['password']
                        ];
                safe_sql_exec($conn_pg, $sql_ins,$params_ins) ;

//                $sql_line= "INSERT INTO public.v_device_lines (domain_uuid, device_line_uuid, device_uuid, line_number, label, display_name, user_id, auth_id,password, sip_port, sip_transport, register_expires, enabled, server_address) VALUES('" . $account_uuid . "','". trim(file_get_contents('/proc/sys/kernel/random/uuid')) . "','" . $device_uuid .  "','1','" . $request_data_device['name'] . "','" . $request_data_device['name'] . "','" . $request_data_device['sip']['username'] . "','" . $request_data_device['sip']['username'] . "','" . $request_data_device['sip']['password'] . "',5060, 'udp', 300,  true,'". $sip_domain  . "');";
                $sql_line= "INSERT INTO public.v_device_lines (domain_uuid, device_line_uuid, device_uuid, line_number, label, display_name, user_id, auth_id,password, sip_port, sip_transport, register_expires, enabled, server_address) VALUES($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14);";
                $sql_line_params = [ $account_uuid ,
                                     new_uuid() ,
                                     $device_uuid ,
                                     '1' ,
                                     $request_data_device['name'] ,
                                     $request_data_device['name'] ,
                                     $request_data_device['sip']['username'] ,
                                     $request_data_device['sip']['username'] ,
                                     $request_data_device['sip']['password'] ,
                                     '5060',
                                     'udp',
                                     '300',
                                      true,
                                      $sip_domain
                                        ];
                safe_sql_exec($conn_pg, $sql_line ,$sql_line_params);




	        } else if(pg_num_rows($query_devices) !== 0 && pg_num_rows($query_lines) !== 0){
                $user_id = $request_data_device['presence_id'];
	   //    $sql = "UPDATE public.v_devices SET domain_uuid=".$account_uuid.", device_address='".$mac_address."', device_label='".$user_id ."', device_vendor='". $request_data_device['provision']['endpoint_brand'] ."', device_model='".$modelup ."', device_enabled=true, device_template='".$request_data_device['provision']['endpoint_brand'] . "/" . $modelup  ."', device_username='".$request_data_device['sip']['username']."', device_password='".$request_data_device['sip']['password']."' WHERE device_uuid='".$device_uuid ."' AND device_address='". $mac_address . "';";
	 	 $sql = "UPDATE public.v_devices SET domain_uuid = $1 , device_address = $2, device_label = $3, device_vendor = $4, device_model = $5, device_enabled = $6, device_template = $7 , device_username = $8 , device_password = $9 WHERE device_uuid = $10  AND device_address = $11 ;";
                 $sql_params =
                   [ $account_uuid,
                     $mac_address,
                     $user_id ,
                     $request_data_device['provision']['endpoint_brand'] ,
                     $modelup,
                     'true' ,
                     $request_data_device['provision']['endpoint_brand'] . "/" . $modelup ,
                     $request_data_device['sip']['username'],
                     $request_data_device['sip']['password'],
                     $device_uuid,
                     $mac_address
                         ];

                 safe_sql_exec($conn_pg, $sql, $sql_params);


//                 $sql_line_domain= "UPDATE public.v_device_lines set line_number='1',label='". $request_data_device['name'] ."', label='". $user_id ."' , display_name='". $user_id ."',user_id='". $request_data_device['sip']['username']."',auth_id='". $request_data_device['sip']['username'] ."', password='". $request_data_device['sip']['password'] ."', server_address='". $sip_domain . "'  WHERE domain_uuid='". $account_couch_uuid  ."' AND device_uuid='". $device_uuid  ."' WHERE device_uuid='". $device_uuid  . "' AND device_line_uuid='". $query_lines ."';";
                $sql_line_domain= "UPDATE public.v_device_lines set line_number = $1, label = $2 , display_name = $3 , user_id = $4 , auth_id = $5 , password = $6 , server_address = $7  WHERE domain_uuid = $8 AND device_uuid = $9  AND device_line_uuid = $10 ;";
                $sql_line_domain_params = [
                     '1',
                     $request_data_device['name'] ,
                     $request_data_device['name'],
                     $request_data_device['sip']['username'] ,
                     $request_data_device['sip']['username'] ,
                     $request_data_device['sip']['password'],
                     $sip_domain,
                     $account_uuid,
                     $device_uuid,
                     $query_lines_info
                        ];

                 safe_sql_exec($conn_pg, $sql_line_domain, $sql_line_domain_params);
	file_put_contents("/var/www/html/webhook-data.log",print_r($sql_line_domain_params,true), FILE_APPEND);




	        } else {

	        echo "do nothing";

	        }




               // $sql_lines_ck_del= "DELETE FROM public.v_device_keys WHERE device_uuid=(SELECT device_uuid FROM public.v_devices WHERE device_address='". $request_data_device['mac_address']."') ;" ;
               $sql_lines_ck_del= "DELETE FROM public.v_device_keys WHERE device_uuid = $1 ;" ;
               safe_sql_exec($conn_pg, $sql_lines_ck_del,[$device_uuid]);

	        //shell_exec("sudo psql -d " . '"' . $dbconn . '" -c ' . '"' . $sql_lines_ck_del . '"'  );


                $key_none_ck = range(0,($countck - 1));
                $vendor_uuid_query = "SELECT device_vendor_uuid from v_device_vendors where name = $1;";
                $vendor_query = safe_sql_exec($conn_pg, $vendor_uuid_query,[ $request_data_device['provision']['endpoint_brand'] ]);
                $vendor_row = pg_fetch_assoc($vendor_query);
                $vendor_uuid = $vendor_row['device_vendor_uuid'];

   //              file_put_contents("/var/www/html/webhook-data.log",print_r($vendor_row,true), FILE_APPEND);


	        $sel_query = "SELECT value FROM public.v_device_vendor_functions where device_vendor_uuid = $1 and type = $2;";
                $none_sql = safe_sql_exec($conn_pg, $sel_query,[ $vendor_uuid , 'none' ]);
                $none_row = pg_fetch_assoc($none_sql);
                $none = $none_row['value'];

                $call_park_sql = safe_sql_exec($conn_pg, $sel_query,[ $vendor_uuid , 'monitored call park' ]);
                $call_park_row = pg_fetch_assoc($call_park_sql);
                $call_park = $call_park_row['value'];

                $presence_sql = safe_sql_exec($conn_pg, $sel_query,[ $vendor_uuid , 'blf' ]);
                $presence_row = pg_fetch_assoc($presence_sql);
                $presence = $presence_row['value'];

                $speed_dial_sql = safe_sql_exec($conn_pg, $sel_query,[ $vendor_uuid , 'speed dial' ]);
                $speed_dial_row = pg_fetch_assoc($speed_dial_sql);
                $speed_dial = $speed_dial_row['value'];

                $lineline_sql = safe_sql_exec($conn_pg, $sel_query,[ $vendor_uuid , 'line' ]);
                $lineline_row = pg_fetch_assoc($lineline_sql);
                $lineline = $lineline_row['value'];

                $transfer_sql = safe_sql_exec($conn_pg, $sel_query,[ $vendor_uuid , 'transfer' ]);
                $transfer_row = pg_fetch_assoc($transfer_sql);
                $transfer = $transfer_row['value'];

                $call_return_sql = safe_sql_exec($conn_pg, $sel_query,[ $vendor_uuid , 'call_return' ]);
                $call_return_row = pg_fetch_assoc($call_return_sql);
                $call_return = $call_return_row['value'];

                $map_key_type = ["none" => $none , "personal parking" => $call_park, 'parking' => $call_park , 'presence' => $presence , 'speed_dial' => $speed_dial , 'speed dial' => $speed_dial , 'line' => $lineline, 'transfer' => $transfer , 'call_return' => $call_return, "" => $none, null => $none ];








                // 1. Conseguir el UUID real del dispositivo antes del bucle para no sobrecargar la BD
                    $sql_get_dev = "SELECT device_uuid FROM public.v_devices WHERE device_address = $1 LIMIT 1;";
                    $res_dev = safe_sql_exec($conn_pg, $sql_get_dev, [$request_data_device['mac_address']]);
                    $dev_row = pg_fetch_assoc($res_dev);
                    $real_device_uuid = $dev_row ? $dev_row['device_uuid'] : $device_uuid;
                    // $real_device_uuid = $trim($device_uuid);
                    $device_key_line_ck = '0';

                    // 2. Definir el query genérico con marcadores de posición
                    $sql_insert_key = "INSERT INTO public.v_device_keys
                        (domain_uuid, device_key_uuid, device_uuid, device_key_id, device_key_category, device_key_vendor, device_key_type, device_key_subtype, device_key_line, device_key_value, device_key_extension, device_key_label)
                        VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12);";

                    for ($h = 0; $h < $countfk; $h++) {
                        // Obtenemos los valores limpios correspondientes a esta iteración...
                        $params_key_line = [
                            $account_uuid,                     // $1
                            new_uuid(),                        // $2 (En lugar de leer /proc/sys/... en cada vuelta, usa tu función)
                            $device_uuid,                 // $3
                            $h,                                // $4
                            'line',                            // $5 (O la categoría que corresponda: memory, expansion, etc.)
                            $request_data_device['provision']['endpoint_brand'], // $6
                            $map_key_type['none'] ,                             // $7
                            '',                                // $8
                            $device_key_line_ck,               // $9
                            '',                                // $10
                            '',                                // $11
                            ''                                 // $12
                        ];
                         $params_key_memory = [
                            $account_uuid,                     // $1
                            new_uuid(),                        // $2 (En lugar de leer /proc/sys/... en cada vuelta, usa tu función)
                            $device_uuid,                 // $3
                            $h,                                // $4
                            'memory',                            // $5 (O la categoría que corresponda: memory, expansion, etc.)
                            $request_data_device['provision']['endpoint_brand'], // $6
                            $map_key_type['none'] ,                             // $7
                            '',                                // $8
                            $device_key_line_ck,               // $9
                            '',                                // $10
                            '',                                // $11
                            ''                                 // $12
                        ];
                          $params_key_expansion = [
                            $account_uuid,                     // $1
                            new_uuid(),                        // $2 (En lugar de leer /proc/sys/... en cada vuelta, usa tu función)
                            $device_uuid,                 // $3
                            $h,                                // $4
                            'expansion',                            // $5 (O la categoría que corresponda: memory, expansion, etc.)
                            $request_data_device['provision']['endpoint_brand'], // $6
                            $map_key_type['none'] ,                             // $7
                            '',                                // $8
                            $device_key_line_ck,               // $9
                            '',                                // $10
                            '',                                // $11
                            ''                                 // $12
                        ];
                           $params_key_progr = [
                            $account_uuid,                     // $1
                            new_uuid(),                        // $2 (En lugar de leer /proc/sys/... en cada vuelta, usa tu función)
                            $device_uuid,                 // $3
                            $h,                                // $4
                            'programmable',                            // $5 (O la categoría que corresponda: memory, expansion, etc.)
                            $request_data_device['provision']['endpoint_brand'], // $6
                            $map_key_type['none'] ,                             // $7
                            '',                                // $8
                            $device_key_line_ck,               // $9
                            '',                                // $10
                            '',                                // $11
                            ''                                 // $12
                        ];
                        // Se ejecuta de manera nativa e inmediata mediante memoria
                        safe_sql_exec($conn_pg, $sql_insert_key, $params_key_line);
                        safe_sql_exec($conn_pg, $sql_insert_key, $params_key_memory);
                        safe_sql_exec($conn_pg, $sql_insert_key, $params_key_expansion);
             //           safe_sql_exec($conn_pg, $sql_insert_key, $params_progr);
                    }

                $sql_lines_ck = "UPDATE public.v_device_keys SET domain_uuid = $1, device_uuid = $2, device_key_vendor = $3, device_key_type = $4 , device_key_line = $5, device_key_value = $6, device_key_label = $7 WHERE device_uuid = $8  and  device_key_category = $9 and device_key_type = $10 and device_key_id = $11 ;";


                for($i = 0 ; $i <= $countck ; $i++ ){

              //  $sql_lines_ck[$i] = "UPDATE public.v_device_keys SET domain_uuid = $1, device_uuid = $2, device_key_vendor = $3, device_key_type = $4 , device_key_line = $5, device_key_value = $6, device_key_label = $7 WHERE device_uuid = $8  and  device_key_category = $9 and device_key_type = $10 and device_key_id = $11 ;";
          //      $sql_lines_ck[$i] = "UPDATE public.v_device_keys SET domain_uuid = '".$account_uuid."', device_uuid = '".$device_uuid ."', device_key_vendor = '". $request_data_device['provision']['endpoint_brand'] ."', device_key_type = '".$map_key_type[$device_key_type_ck] ."' , device_key_line = '0', device_key_value = '". $device_key_value_ck."', device_key_label = '" .$device_key_label_ck ."' WHERE device_uuid = '".$device_uuid ."'  and  device_key_category = 'line' and device_key_type = '".  $none ."' and device_key_id = '". $i ."' ;";
                $device_key_id_ck[$i] = $alllinesck[$i] + 1 ;
                $device_key_value_ck = trim($request_data_device['provision']['combo_keys'][$alllinesck[$i]]['value']['value'])  ;
                $device_key_label_ck = trim($request_data_device['provision']['combo_keys'][$alllinesck[$i]]['value']['label']);
                $device_key_type_ck = str_replace('_',' ',$request_data_device['provision']['combo_keys'][$alllinesck[$i]]['type']) ;

                if($device_key_type_ck === 'parking'){
                    $device_key_value_ck = '*3' . $device_key_value_ck ;
                } else if($device_key_type_ck === 'personal parking'){
                    $user_id = $request_data_device['presence_id'];
                    $device_key_value_ck = '*3' . $user_id ;

                } else if($device_key_type_ck === 'presence'){
                    $user_id = $request_data_device['presence_id'];
                    $device_key_value_ck = $user_id ;
                } else {
                    $device_key_value_ck = $device_key_value_ck ;
                }

                $params_key = [
                            $account_uuid,                     // $1
                            $device_uuid,                        // $2 (En lugar de leer /proc/sys/... en cada vuelta, usa tu función)
                            $request_data_device['provision']['endpoint_brand'],                 // $3
                            $map_key_type[$device_key_type_ck],                                // $4
                            '0',                            // $5 (O la categoría que corresponda: memory, expansion, etc.)
                            $device_key_value_ck , // $6
                            $device_key_label_ck ,
                            $device_uuid ,
                            'line',
                            $none,
                            $device_key_id_ck[$i]
                    // $12
                        ];
                                        //file_put_contents("/var/www/html/webhook-data.log",print_r($sql_lines_ck[$i],true), FILE_APPEND);
                                        file_put_contents("/var/www/html/webhook-data.log",print_r($params_key,true), FILE_APPEND);

                safe_sql_exec($conn_pg, $sql_lines_ck, $params_key);

           //     $sql_lines_ck[$i] = "UPDATE public.v_device_keys SET domain_uuid=".$account_couch_uuid.", device_uuid=(SELECT device_uuid from public.v_devices WHERE device_address='".$request_data_device['mac_address']."'), device_key_vendor='".$request_data_device['provision']['endpoint_brand']."', device_key_type='".$call_park."' , device_key_line='".$device_key_line_ck."', device_key_value='*3".$user_id."', device_key_label='".$device_key_label_ck."' WHERE device_uuid='".$device_uuid."'  and  device_key_category='line' and device_key_type='".$none."' and device_key_id='".$device_key_id_ck."' ;";



                }



	        $key_none_fk = range(0,($countfk - 1));


	//    $sql_lines_fk = "UPDATE public.v_device_keys SET domain_uuid = $1, device_uuid = $2, device_key_vendor = $3, device_key_type = $4 , device_key_line = $5, device_key_value = $6, device_key_label = $7 WHERE device_uuid = $8  and  device_key_category = $9 and device_key_type = $10 and device_key_id = $11 ;";

	        for ($j = 0 ; $j < $countfk  ; $j++){

                $sql_lines_fk[$j] = "UPDATE public.v_device_keys SET domain_uuid = $1, device_uuid = $2, device_key_vendor = $3, device_key_type = $4 , device_key_line = $5, device_key_value = $6, device_key_label = $7 WHERE device_uuid = $8  and  device_key_category = $9 and device_key_type = $10 and device_key_id = $11 ;";

                $device_key_type_fk = str_replace('_',' ',$request_data_device['provision']['feature_keys'][$alllinesfk[$j]]['type']) ?? 'none' ;

                $device_key_value_fk = trim($request_data_device['provision']['feature_keys'][$alllinesfk[$j]]['value'])  ;

                $device_key_line_fk = '0';

	        $device_key_id_fk[$j] = $alllinesfk[$j] +1;
	        $device_key_id_none_fk = $key_none_fk[$j];


                if($device_key_type_fk === 'parking'){
                    $device_key_value_fk = '*3' . $device_key_value_fk ;
                } else if ($device_key_type_fk === 'personal parking') {
                    $user_id = $request_data_device['presence_id'];
                    $device_key_value_fk = '*3' . $user_id ;
                } else if($device_key_type_fk === 'presence'){
                    $user_id = $request_data_device['presence_id'];
                    $device_key_value_fk = $user_id ;
                } else {
                    $device_key_value_fk = $device_key_value_fk ;
                }

                $params_key = [
                            $account_uuid,                     // $1
                            $device_uuid,                        // $2 (En lugar de leer /proc/sys/... en cada vuelta, usa tu función)
                            $request_data_device['provision']['endpoint_brand'],                 // $3
                            $map_key_type[$device_key_type_fk],                                // $4
                            '0',                            // $5 (O la categoría que corresponda: memory, expansion, etc.)
                            $device_key_value_fk , // $6
                            $device_key_label_fk ,
                            $device_uuid ,
                            'memory',
                            $none,
                            $device_key_id_fk[$j]
                    // $12
                        ];
                 safe_sql_exec($conn_pg, $sql_lines_fk[$j], $params_key);


                }
	        $key_none_ek = range(0,($countfk - 1));

        //        $sql_lines_ek = "UPDATE public.v_device_keys SET domain_uuid = $1, device_uuid = $2, device_key_vendor = $3, device_key_type = $4 , device_key_line = $5, device_key_value = $6, device_key_label = $7 WHERE device_uuid = $8  and  device_key_category = $9 and device_key_type = $10 and device_key_id = $11 ;";

	        for($k = 0 ; $k < $countek ; $k++ ){
                  $sql_lines_ek[$k] = "UPDATE public.v_device_keys SET domain_uuid = $1, device_uuid = $2, device_key_vendor = $3, device_key_type = $4 , device_key_line = $5, device_key_value = $6, device_key_label = $7 WHERE device_uuid = $8  and  device_key_category = $9 and device_key_type = $10 and device_key_id = $11 ;";
                 $device_key_type_ek = str_replace('_',' ',$request_data_device['provision']['combo_keys'][$alllinesek[$k]]['type']) ;


                $device_key_value_ek = trim($request_data_device['provision']['combo_keys'][$alllinesck[$k]]['value']['value'])  ;

                $device_key_label_ek = trim($request_data_device['provision']['combo_keys'][$alllinesck[$k]]['value']['label']);

                $device_key_line_ek = '0';

	        $device_key_id_ek = $alllinesek[$k] +1;
	        $device_key_id_none_ek = $key_none_ek[$k];

                 if($device_key_type_ek === 'parking'){
                    $device_key_value_ek = '*3' . $device_key_value_ek ;

                } else if ($device_key_type_ek === 'personal parking') {
                    $user_id = $request_data_device['presence_id'];
                    $device_key_value_ek = '*3' . $user_id ;
                } else if($device_key_type_ek === 'presence'){
                    $user_id = $request_data_device['presence_id'];
                    $device_key_value_ek = $user_id ;
                } else {
                    $device_key_value_ek = $device_key_value_ek ;
                }

                $params_key = [
                            $account_uuid,                     // $1
                            $device_uuid,                        // $2 (En lugar de leer /proc/sys/... en cada vuelta, usa tu función)
                            $request_data_device['provision']['endpoint_brand'],                 // $3
                            $map_key_type[$device_key_type_ek],                                // $4
                            '0',                            // $5 (O la categoría que corresponda: memory, expansion, etc.)
                            $device_key_value_ek , // $6
                            $device_key_label_ek ,
                            $device_uuid ,
                            'expansion',
                            $none,
                            $device_key_id_ek
                    // $12
                        ];
                }


	        } else {
		                echo "No action or event from webhook performed";

	        }

}


function new_uuid(){


$new_uuid = trim(file_get_contents('/proc/sys/kernel/random/uuid'));

return $new_uuid ;

}

function safe_sql_exec($conn, $sql, $params = []) {

    $random_suffix = bin2hex(random_bytes(8));

    static $prepared_sentences = [];

    // Generamos un nombre único para la sentencia preparada basado en el contenido del query
    $query_name = "q_" . $random_suffix;;

    // Verificamos si ya se preparó previamente en esta ejecución para evitar errores de duplicidad
    if (!@pg_prepare($conn, $query_name, $sql)) {
        // Si ya existe o falla la preparación básica, intentamos ejecutar directamente o capturar el error
        $prepared = @pg_prepare($conn, $query_name, $sql);
        if (!$prepared) {
            // Si falla la preparación (y no es porque ya existía), registramos el error
            file_put_contents("/var/www/html/webhook-data.log", "Error al PREPARAR Query: " . pg_last_error($conn) . " | SQL: " . $sql . "\n", FILE_APPEND);
            return false;
        }
        $sentencias_preparadas[$query_name] = true;
    }

    $result = pg_execute($conn, $query_name, $params);

    if (!$result) {
        file_put_contents("/var/www/html/webhook-data.log", "Error in Query: " . pg_last_error($conn) . " | SQL: " . $sql . "\n", FILE_APPEND);
        return false;
    }

    return $result;
}
