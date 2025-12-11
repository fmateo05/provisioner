<?php
header('Access-Control-Allow-Headers:Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control, X-Auth-Token');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Origin: https://portal.example.net');
header('Access-Control-Max-Age:86400');

define('__ROOT__', dirname(dirname(__FILE__)));

require_once('/var/www/html/env.php');

$dbconn = "postgres://" . $user . ":" . $password . "@" . $host . "/" . $database . "?sslmode=require" ;




$requestMethod = $_SERVER['REQUEST_METHOD'];

$subpaths = array_filter(explode('/', $_SERVER['REQUEST_URI']));
$path_strip = preg_replace('/\?_=(\d+)/i', '', $subpaths['2']);

$account_id = $path_strip;

$account_uuid = preg_replace("/(\w{8})(\w{4})(\w{4})(\w{4})(\w{12})/i", "$1-$2-$3-$4-$5", $account_id);



if ($requestMethod === 'GET') {
$sel_query_settings_subcat = "select domain_setting_subcategory  from v_domain_settings where domain_uuid='". $account_uuid . "';";
$sel_query_settings_value = "select domain_setting_value  from v_domain_settings where domain_uuid='".$account_uuid ."';";
$sel_query_domain_name = "select domain_name from v_domains where domain_uuid='". $account_uuid ."'";

$creds = file_get_contents('/home/www-data/' . $account_id . '.json');

$query_settings_subcat =  shell_exec("sudo psql -qtAX -d " . '"' . $dbconn . '" -c ' . '"' . $sel_query_settings_subcat . '"'  );
$query_settings_value =  shell_exec("sudo psql -qtAX -d " . '"' . $dbconn . '" -c ' . '"' . $sel_query_settings_value . '"'  );
$query_domain_name  =  shell_exec("sudo psql -qtAX -d " . '"' . $dbconn . '" -c ' . '"' . $sel_query_domain_name  . '"'  );
//$cmd = shell_exec('echo ' . $result  . ' | python3 -mjson.tool');

$subcat = explode("\n",$query_settings_subcat);
$value = explode("\n",$query_settings_value);

$out = array_combine($subcat,$value);

//$urlparts = parse_url($out['grandstream_config_server_path']);

$json['data'] = [ 'http_auth_username' => $out['http_auth_username'] , 'http_auth_password' => $out['http_auth_password'], 'grandstream_config_server_path' =>  trim($query_domain_name) ] ;

$result = json_encode($json);
//$result = json_encode($json,JSON_PRETTY_PRINT);

print_r($result);



}
