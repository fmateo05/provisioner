<?php
// Forzar salida en tiempo real en la terminal
ob_implicit_flush(true);
while (ob_get_level()) ob_end_clean();

require_once('/var/www/prov-alt-webhook.php');

// 1. Configuración de tu JSON
$couch_url  = "http://cdb01.lxd.kazoo.io:5984";
$couch_user = "kazoo";
$couch_pass = "kazookazoo01";



echo "[*] Iniciando Escucha Multi-Cuenta para el Provisionador...\n";

// --- PASO A: OBTENER TODAS LAS CUENTAS ACTUALES ---
$todas_las_dbs = obtener_todas_las_bases_de_datos($couch_url, $couch_user, $couch_pass);
$cuentas_kazoo = filtrar_cuentas_kazoo($todas_las_dbs);

echo "[*] Se encontraron " . count($cuentas_kazoo) . " cuentas activas en el clúster Kazoo.\n";

// --- PASO B: ESCUCHAR LA BD MAESTRA 'accounts' PARA NUEVOS TENANTS ---
// Monitoreamos la base de datos central de cuentas de Kazoo. Si se crea una cuenta nueva en Monster UI, 
// este feed se entera y podemos añadirla al flujo.
$master_accounts_db = "accounts";
//$changes_url = "{$couch_url}/{$master_accounts_db}/_changes?feed=continuous&heartbeat=30000&since=now";
// $changes_url = "{$couch_url}/_db_updates?feed=continuous&heartbeat=30000&since=now&include_docs=true";
 $changes_url = "{$couch_url}/_global_changes/_changes?feed=continuous&heartbeat=30000&since=now&include_docs=true";

echo "[*] Escuchando cambios globales en tiempo real...\n";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $changes_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 0);
curl_setopt($ch, CURLOPT_BUFFERSIZE, 1); // Buffer al mínimo para evitar retrasos en CLI

if ($couch_user !== '-') {
    curl_setopt($ch, CURLOPT_USERPWD, "{$couch_user}:{$couch_pass}");
}

// 3. CALLBACK PRINCIPAL: Procesa cuando hay actividad en las cuentas
curl_setopt($ch, CURLOPT_WRITEFUNCTION, function($ch, $data) use ($couch_url, $couch_user, $couch_pass) {
    $line = trim($data);
    if (empty($line)) {
        return strlen($data); // Ignorar keep-alive
    }
    
    $change = json_decode($line, true);
   // print_r($change);
   
    
    // Si detectamos un cambio en la BD 'accounts', significa que se creó, modificó o eliminó una cuenta
//    if (isset($change['id'])) {
//        $account_id = $change['id']; // ID real de la cuenta Kazoo (ej: 4acf2735...)
//        
//        // Formatear el ID como lo hace CouchDB internamente para sus nombres de BD: account/4a/cf/2735...
//        $db_encoded = "account/" . substr($account_id, 0, 2) . "/" . substr($account_id, 2, 2) . "/" . substr($account_id, 4);
//        
//        if (isset($change['deleted']) && $change['deleted'] === true) {
//            echo "[-] Cuenta eliminada del sistema: {$account_id}\n";
//            // Lógica opcional para borrar archivos en /opt/provisioner de esa cuenta entera
//        } else {
//            echo "[+] Actividad/Modificación en Cuenta: {$account_id}. Escaneando dispositivos...\n";
//            // Escaneamos la base de datos de esa cuenta específica para ver qué cambió
//            escanear_dispositivos_de_cuenta($couch_url, $couch_user, $couch_pass, $db_encoded, $account_id);
//        }
//    }
    //if (isset($change['db_name'])) { 
    if (isset($change['id'])) {
         $raw_id = $change['id'];
         //$raw_db_id = $change['db_name'];
        
        
         $is_deleted = isset($change['deleted']) && $change['deleted'] === true;
        
        // Filtrar para capturar solo las acciones de actualización (updates)
          if ($is_deleted) {
            echo "    [-] El documento fue eliminado. Ejecutando limpieza...\n";
            // Aquí ejecutas tu lógica de borrado en tu provisionador
            // ej: unlink("/opt/provisioner/cfg/001122334455.cfg");
          } else {
         if (strpos($raw_id, 'updated:') !== false) {
        //      if ($change['type'] === 'updated') {

            // Extraer el nombre de la base de datos afectada
            // Ejemplo: de "v1:update:account/ab/cd/12345" extrae "account/ab/cd/12345"
            $parts = explode('updated:', $raw_id);

            $db_name = isset($parts[1]) ? $parts[1] : '';
             //     $db_name = $change['db_name'];

            // Validar que el cambio provenga de una base de datos de cuenta de Kazoo
            if (strpos($db_name, 'account/') === 0){ 
                if (strpos($db_name, '_modb') !== false) return  ;
                
               
                if (preg_match('/-\d{6}$/', $db_name)){
                    return ;
                }
                // Limpiar el ID de la cuenta para quedarnos con el ID real de Kazoo (sin diagonales)
                // Convierte "account/1a/2b/3c4d..." en "1a2b3c4d..."
                $account_id = str_replace(['account/', '/'], '', $db_name);
                if (preg_match('/-\d{4,6}$/', $account_id)){
                    return ;
                }
                echo "[+] Evento detectado en la cuenta Kazoo: {$account_id}\n";
               
                // Ejecutar la sincronización inversa pasando el ID de la cuenta afectada
                 //procesar_cambio_cuenta_global($account_id, $db_name);
                 escanear_dispositivos_de_cuenta($couch_url, $couch_user, $couch_pass, $db_name, $account_id);
            
                
                }
        }
          }
    } 

    
    
    return strlen($data);
});

// 4. Ejecutar bucle infinito de escucha
$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo '[-] Error de conexión en cURL: ' . curl_error($ch) . "\n";
}
curl_close($ch);


// --- FUNCIONES DE ASISTENCIA ---

// Obtiene el listado plano de todas las bases de datos en CouchDB
function obtener_todas_las_bases_de_datos($url, $user, $pass) {
    $ch = curl_init("{$url}/_all_dbs");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if ($user !== '-') curl_setopt($ch, CURLOPT_USERPWD, "{$user}:{$pass}");
    $res = curl_exec($ch);
    curl_close($ch);
    return $res ? json_decode($res, true) : [];
}

// Filtra el listado para quedarse únicamente con las bases de datos de cuentas Kazoo
function filtrar_cuentas_kazoo($dbs) {
    $cuentas = [];
                
    foreach ($dbs as $db) {
        if (strpos($db, 'account/') === 0) {
            if (preg_match('/-\d{4-6}$/', $db)){
              //  return false;
            }
            $cuentas[] = $db;
        }
    }
    return $cuentas;
}

// Interroga los últimos cambios de la base de datos de una cuenta en específico
function escanear_dispositivos_de_cuenta($url, $user, $pass, $db_name, $account_id) {
    // Traemos los últimos 5 cambios de esa base de datos de cuenta para procesar el ID de dispositivo modificado
    $url_clean = "{$url}/" . urlencode($db_name) . "/_changes?descending=true&include_docs=true&since=now&limit=5";
    
    $ch = curl_init($url_clean);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if ($user !== '-') curl_setopt($ch, CURLOPT_USERPWD, "{$user}:{$pass}");
    $response = curl_exec($ch);
    curl_close($ch);
    
    if ($response) {
        $data = json_decode($response, true);
      //  print_r($data);
        
         
        
        if (!empty($data['results'])) {
            foreach ($data['results'] as $device) {    
             
          //$is_deleted = (isset($device['doc']['pvt_deleted']) && $device['doc']['pvt_deleted'] === 1);
          if(isset($device['doc']['pvt_deleted']) && $device['doc']['pvt_deleted'] == 1){
              
              echo "    [-] El documento {$device['id']} fue eliminado. Ejecutando limpieza...\n";
            // Aquí ejecutas tu lógica de borrado en tu provisionador
            // ej: unlink("/opt/provisioner/cfg/001122334455.cfg");
                         
                
          }
          
          
//        pvt_deleted
            foreach ($data['results'] as $row) {
             $doc_id = $row['id'];   
             if(isset($row['doc']['pvt_type']) && $row['doc']['pvt_type'] == 'device' && isset($row['doc']['device_type']) && $row['doc']['device_type'] == 'sip_device') {   
                
                
                // Ignorar documentos de diseño del core de Kazoo
                //--if (strpos($doc_id, '_design/') == 0) continue;
//                if (preg_match('/\d{4,6}-/', $doc_id)) continue;
//                if (preg_match('/-\d{4,6}$/', $doc_id)) continue;
//                if (preg_match('/-\d{4,6}$/', $account_id)) continue;
               // if (preg_match('/^[a-f0-9]{32}$/i', $doc_id) || preg_match('/^[a-f]{32}$/i', $account_id) ) {
                // AQUÍ TIENES AMBOS DATOS: La cuenta y el documento (dispositivo) alterado
                echo "    [→] Dispositivo Identificado: {$doc_id}\n";
                procesar_actualizacion_provisioner($account_id, $doc_id,$row['doc']);
               // } 
            
            
//          } else if ($account_id = $doc_id) {
//              return ;
//          } else {
//              return;
          }
          }
            }     
    }
}
}

function procesar_cambio_cuenta_global($account_id, $db_name) {
    global $couch_url, $couch_user, $couch_pass;

    echo "    [*] Analizando últimas modificaciones en la base de datos: {$db_name}\n";

    // Dado que _global_changes solo avisa qué BASE DE DATOS cambió, hacemos una petición rápida
    // a los últimos cambios de ESA cuenta específica para saber qué DOCUMENTO (teléfono/usuario) varió.
    $account_changes_url = "{$couch_url}/" . urlencode($db_name) . "/_changes?descending=true&since=now";

    $sub_ch = curl_init();
    curl_setopt($sub_ch, CURLOPT_URL, $account_changes_url);
    curl_setopt($sub_ch, CURLOPT_RETURNTRANSFER, true);
    if ($couch_user !== '-') {
        curl_setopt($sub_ch, CURLOPT_USERPWD, "{$couch_user}:{$couch_pass}");
    }

    $response = curl_exec($sub_ch);
    curl_close($sub_ch);

    if ($response) {
        $result = json_decode($response, true);
        
        if (isset($result['results'][0]['id'])) {
            $doc_id = $result['results'][0]['id'];
            
            
            echo "    [→] Documento modificado: {$doc_id} (Cuenta: {$account_id})\n";
            if (preg_match('/-\d{4-6}$/', $doc_id) || preg_match('/\d{4-6}-/', $doc_id)){
                 return ;
            }
            // AQUÍ tu provisionador ya sabe exactamente QUÉ cuenta y QUÉ dispositivo cambió.
            // Puedes meter tu lógica para reconstruir el archivo correspondiente.
             
            
            
            }
        
    }
}


// Tu función de lógica de negocio (Adaptada para multi-cuenta)
function procesar_actualizacion_provisioner($account_id, $device_id,$row_doc){
    
$exec = provisioner('doc_edited','device',$account_id,$device_id,$row_doc);
//print_r($exec); 
        echo "    [OK] Sincronización finalizada para dispositivo {$device_id} en cuenta {$account_id}\n";
         
   // }
}
