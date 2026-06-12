<?php
// Forzar salida en tiempo real en la terminal
//ob_implicit_flush(true);
//while (ob_get_level()) ob_end_clean();
ini_set('display_errors', '0');
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

// 1. Configuración de tu JSON
$couch_url  = "http://cdb01.lxd.kazoo.io:5984";
$couch_user = "kazoo";
$couch_pass = "kazookazoo01";

require_once('/var/www/prov-alt-webhook.php');

echo "[*] Iniciando Escucha por '_db_updates' (Filtro estricto de Cuentas)...\n";

// Usamos el feed global de actualización de bases de datos de CouchDB
$url = "{$couch_url}/_db_updates?feed=continuous&heartbeat=30000&since=now";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 0);
curl_setopt($ch, CURLOPT_BUFFERSIZE, 1); 

if ($couch_user !== '-') {
    curl_setopt($ch, CURLOPT_USERPWD, "{$couch_user}:{$couch_pass}");
}

// Control de tiempo para evitar procesar ráfagas repetidas del mismo cambio
$cooldown_cuentas = [];

// 2. CALLBACK PRINCIPAL: Escucha qué base de datos cambió en el clúster
curl_setopt($ch, CURLOPT_WRITEFUNCTION, function($ch, $data) use (&$cooldown_cuentas, $couch_url, $couch_user, $couch_pass) {
    $line = trim($data);
    if (empty($line)) return strlen($data); // Ignorar keep-alive
    
    $event = json_decode($line, true);
    
    // Buscamos eventos donde el tipo sea 'updated' y afecte a una base de datos de cuenta
    if (isset($event['type']) && $event['type'] === 'updated' && isset($event['db_name'])) {
        $db_name = $event['db_name'];
       
        // El nombre de la base de datos debe empezar por 'account/'
        if (strpos($db_name, 'account/') === 0) {
            
            // Extraer el ID limpio de la cuenta de Kazoo (quitando las diagonales)
            $account_id = str_replace(['account/', '/'], '', $db_name);
            
            $ahora = time();
            // Evitar procesar duplicados ruidosos si ocurren en menos de 3 segundos
            if (isset($cooldown_cuentas[$account_id]) && ($ahora - $cooldown_cuentas[$account_id]) < 3) {
                return strlen($data);
            }
            $cooldown_cuentas[$account_id] = $ahora;
            
            echo "[!] Cambio detectado en la base de datos de la cuenta: {$account_id}\n";
            
            // Vamos directamente a buscar el documento de la cuenta para ver si fue lo que cambió
            verificar_y_procesar_cuenta($couch_url, $couch_user, $couch_pass, $db_name, $account_id);
        }
    }
    
    return strlen($data);
});

echo "[*] Conectado al bus de CouchDB. Modifica una cuenta en Monster UI para probar...\n";
$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo '[-] Error en cURL: ' . curl_error($ch) . "\n";
}
curl_close($ch);


// --- LÓGICA DE DETECCIÓN Y FILTRADO ---

function verificar_y_procesar_cuenta($url, $user, $pass, $db_name, $account_id) {
    // En Kazoo, el documento que define la configuración de la cuenta tiene como ID el mismo ID de la cuenta.
    // Ej: En la BD 'account/4a/cf/2735...', el documento de la cuenta se llama '4acf2735...'
    $account_doc_url = "{$url}/" . urlencode($db_name) . "/" . urlencode($account_id);
    
    $ch = curl_init($account_doc_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if ($user !== '-') curl_setopt($ch, CURLOPT_USERPWD, "{$user}:{$pass}");
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($http_code === 200 && $response) {
        $doc = json_decode($response, true);
        
        // Verificación estricta de seguridad: Debe ser de tipo 'account'
        if (isset($doc['pvt_type']) && $doc['pvt_type'] === 'account') {
            
            $account_name = isset($doc['name']) ? $doc['name'] : 'Sin Nombre';
            $realm        = isset($doc['realm']) ? $doc['realm'] : 'Sin Realm';
            
            echo "    [✔] ¡Confirmado! Modificación estructural en los parámetros de la cuenta.\n";
            echo "        [-] Nombre: {$account_name}\n";
            echo "        [-] Realm SIP: {$realm}\n";
            
             provisioner('doc_edited','account',$account_id,$account_id,$doc);

            
            // AQUÍ ejecutas la lógica de tu provisionador para actualizar rutas/dominios globales
            // de la cuenta, ignorando por completo si lo que cambió en la BD fue un teléfono.
        } else {
            // Si el documento modificado en la BD no coincide con el ID de la cuenta,
            // significa que cambiaron un dispositivo, un usuario, etc. Lo ignoramos.
            echo "    [i] Cambio ignorado (Corresponde a un dispositivo o entidad secundaria).\n";
        }
    }
}
