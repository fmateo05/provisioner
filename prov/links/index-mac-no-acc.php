<?php


$conn = "http://" . $couch_user . ':' . $couch_pass . '@' . $couch_host . ':' . $couch_port ;



header('Access-Control-Allow-Origin: *');

$couch_user = '';
$couch_pass = '';
$couch_host = '127.0.0.1';
$couch_port = '5984';

$user = '';
$password = '';
$host ='';
$port = '5432';
$database ='fusionpbx';


$credentials = trim('');
$otf_couch_host = 'portal.domain.net';
$otf_couch_port = '9443';



$dbconn = "postgres://" . $user . ":" . $password . "@" . $host . "/" . $database . "?sslmode=require" ;




$requestMethod = $_SERVER['REQUEST_METHOD'];

$subpaths = array_filter(explode('/', $_SERVER['REQUEST_URI']));
$path_strip = preg_replace('/\?_=(\d+)/i', '', $subpaths['2']);
//$path_strip = preg_replace('/\?_=(\d+)/i', '', $subpaths['2']);


if(preg_match('/SEP([A-F0-9]{12})\.cnf\.xml/', $path_strip, $matches)){
$mac_address = strtolower(preg_replace('/SEP\.cnf\.xml/', '', $matches[1]));
$sel_query_domain_fmac = "select domain_uuid from v_devices where device_address='". $mac_address."';";

$account_id =  trim(shell_exec("sudo psql -qtAX -d " . '"' . $dbconn . '" -c ' . '"' . $sel_query_domain_fmac . '"'  ));

} else if (preg_match('/y([a-f0-9]{12})\.(cfg|boot)/',$path_strip,$matches)) { 


$user_agent = array_filter(explode(' ', $_SERVER['HTTP_USER_AGENT']));
$mac_address = preg_replace('/:/','',$user_agent['3']);
$sel_query_domain_fmac = "select domain_uuid from v_devices where device_address='". strtolower($mac_address) ."';";
$account_id =  trim(shell_exec("sudo psql -qtAX -d " . '"' . $dbconn . '" -c ' . '"' . $sel_query_domain_fmac . '"'  ));


} else if (preg_match('/cfg([a-f0-9]{12})\.xml/',$path_strip,$matches)){

$mac_address = preg_replace('/cfg\.xml/', '', $matches[1]);

$sel_query_domain_fmac = "select domain_uuid from v_devices where device_address='". $mac_address."';";

$account_id =  trim(shell_exec("sudo psql -qtAX -d " . '"' . $dbconn . '" -c ' . '"' . $sel_query_domain_fmac . '"'  ));

} else if (preg_match('/([a-f0-9]{12})\.(cfg|xml)/',$path_strip,$matches)) { 

$mac_address = preg_replace('/\.(cfg|xml)/', '', $matches[1]);
$sel_query_domain_fmac = "select domain_uuid from v_devices where device_address='". $mac_address."';";

$account_id =  trim(shell_exec("sudo psql -qtAX -d " . '"' . $dbconn . '" -c ' . '"' . $sel_query_domain_fmac . '"'  ));


}



if ($requestMethod === 'GET') {

$sel_query_settings_subcat = "select domain_setting_subcategory  from v_domain_settings where domain_uuid='". $account_id . "';";
$sel_query_settings_value = "select domain_setting_value  from v_domain_settings where domain_uuid='".$account_id ."';";
$sel_query_domain_name = "select domain_name from v_domains where domain_uuid='". $account_id ."'";



$query_settings_subcat =  shell_exec("sudo psql -qtAX -d " . '"' . $dbconn . '" -c ' . '"' . $sel_query_settings_subcat . '"'  );
$query_settings_value =  shell_exec("sudo psql -qtAX -d " . '"' . $dbconn . '" -c ' . '"' . $sel_query_settings_value . '"'  );
$query_domain_name  =  shell_exec("sudo psql -qtAX -d " . '"' . $dbconn . '" -c ' . '"' . $sel_query_domain_name  . '"'  ) ;


$subcat = explode("\n",$query_settings_subcat);
$value = explode("\n",$query_settings_value);

$out = array_combine($subcat,$value);


header("Status: 301 Moved Permanently");
header("Location: http://" . trim($query_domain_name)   .":442/" . $out['http_auth_username'] . "/" . $out['http_auth_password'] . '/' . $subpaths['2'] . '/' . $subpaths['3']);
exit();



}
