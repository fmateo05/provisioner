<?php
header('Access-Control-Allow-Headers:Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control, X-Auth-Token, x-kazoo-cluster-id');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Max-Age:86400');

define('__ROOT__', dirname(dirname(__FILE__)));

require_once('/var/www/env.php');


 $host = '127.0.0.1';
    $database = 'shlink';
    $user = 'provisioner';
    $password = 'provisioner';


$dbconn = "host=$host dbname=$database user=$user password=$password";
    $conn_pg = pg_connect($dbconn);

    if (!$conn_pg) {
        file_put_contents("/var/www/html/webhook-data.log", "Error connecting to native PostgreSQL\n", FILE_APPEND);
        exit;
    }

 function safe_sql_exec($conn, $sql, $params = []) {

        $random_suffix = bin2hex(random_bytes(8));

        static $prepared_sentences = [];

        // Generamos un nombre único para la sentencia preparada basado en el contenido del query
        $query_name = "q_" . $random_suffix;

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





$requestMethod = $_SERVER['REQUEST_METHOD'];

$subpaths = array_filter(explode('/', $_SERVER['REQUEST_URI']));
$path_strip = preg_replace('/\?_=(\d+)/i', '', $subpaths['3']);
//$path_strip = preg_replace('/\?_=(\d+)/i', '', $subpaths['2']);

$account_id = $path_strip;

$account_uuid = preg_replace("/(\w{8})(\w{4})(\w{4})(\w{4})(\w{12})/i", "$1-$2-$3-$4-$5", $account_id);

$sel_sql_shorturl = "SELECT shorturl from shorturls where account = $1 ;";



if ($requestMethod === 'GET') {

//$urlparts = parse_url($out['grandstream_config_server_path']);
$sql_query_shortcut = safe_sql_exec($conn_pg,$sel_sql_shorturl,[$account_id]);

$sql_rows_shortcut = pg_fetch_assoc($sql_query_shortcut);

$json = [ "status" => "success" ];
$json['data'] = [ "provision_short_url" => $sql_rows_shortcut['shorturl']  ];
$result = json_encode($json,JSON_PRETTY_PRINT);
//$result = json_encode($json,JSON_PRETTY_PRINT);

print_r($result);



}
