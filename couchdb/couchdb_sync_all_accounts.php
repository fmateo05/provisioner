<?php
// Forzar salida en tiempo real en la terminal
ob_implicit_flush(true);
while (ob_get_level()) ob_end_clean();

require_once('/var/www/prov-alt-webhook.php');

// 1. Configuración de tu JSON
$couch_url  = "http://couch-url:5984";
$couch_user = "user";
$couch_pass = "password";

echo "[*] Iniciando Escucha por '_db_updates' (Filtro estricto de DISPOSITIVOS)...\n";

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

// Control de tiempo para mitigar ráfagas de eventos sobre el mismo dispositivo
$cooldown_dispositivos = [];

// 2. CALLBACK PRINCIPAL: Detecta qué base de datos cambió
curl_setopt($ch, CURLOPT_WRITEFUNCTION, function($ch, $data) use (&$cooldown_dispositivos, $couch_url, $couch_user, $couch_pass) {
    $line = trim($data);
    if (empty($line)) return strlen($data); // Ignorar keep-alive
    
    $event = json_decode($line, true);
    
    // Validar que sea una actualización en una base de datos de cuenta
    if (isset($event['type']) && $event['type'] === 'updated' && isset($event['db_name'])) {
        $db_name = $event['db_name'];
        
        if (strpos($db_name, 'account/') === 0) {
            // Extraer el ID limpio de la cuenta de Kazoo
            $account_id = str_replace(['account/', '/'], '', $db_name);
            
            // Ir a buscar los últimos documentos modificados dentro de esa cuenta específica
            buscar_dispositivos_modificados($couch_url, $couch_user, $couch_pass, $db_name, $account_id, $cooldown_dispositivos);
        }
    }
    
    return strlen($data);
});

echo "[*] Conectado al bus de CouchDB. Modifica un teléfono en Monster UI para probar...\n";
$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo '[-] Error en cURL: ' . curl_error($ch) . "\n";
}
curl_close($ch);


// --- LÓGICA DE DETECCIÓN Y FILTRADO DE DISPOSITIVOS ---

function buscar_dispositivos_modificados($url, $user, $pass, $db_name, $account_id, &$cooldown) {
    // Pedimos los últimos 5 cambios de la cuenta e incluimos el documento completo ('include_docs=true')
    // $changes_url = "{$url}/" . urlencode($db_name) . "/_changes?descending=true&limit=5&include_docs=true";
    $changes_url = "{$url}/" . urlencode($db_name) . "/_changes?descending=true&limit=5&include_docs=true";
    
    $ch = curl_init($changes_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if ($user !== '-') curl_setopt($ch, CURLOPT_USERPWD, "{$user}:{$pass}");
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    if ($response) {
        $data = json_decode($response, true);
        
        if (!empty($data['results'])) {
            foreach ($data['results'] as $row) {
                $doc_id = $row['id'];
                
                // 1. Ignorar de inmediato documentos de diseño internos
                if (strpos($doc_id, '_design/') === 0) continue;
                
                // 2. Ignorar el documento maestro de la cuenta (el script anterior se encargaba de este)
                if ($doc_id === $account_id) continue;
                
                if (isset($row['doc'])) {
                    $doc = $row['doc'];
                    
                    // FILTRO ESPECÍFICO: Comprobar que el tipo privado de documento de Kazoo sea 'device'
                    if (isset($doc['pvt_type']) && $doc['pvt_type'] === 'device') {
                        
                        $is_deleted = isset($doc['pvt_deleted']) && $doc['pvt_deleted'] === true;
                        $device_name = isset($doc['name']) ? $doc['name'] : 'Dispositivo sin nombre';
                        $mac_address = isset($doc['mac_address']) ? $doc['mac_address'] : 'Sin MAC';
                        
                        // Control de cooldown para no duplicar la escritura del archivo de aprovisionamiento
                        $cache_key = $account_id . "_" . $doc_id;
                        $ahora = time();
                        if (isset($cooldown[$cache_key]) && ($ahora - $cooldown[$cache_key]) < 2) {
                            continue;
                        }
                        $cooldown[$cache_key] = $ahora;
                        
                        // --- DISPARO DE EVENTOS ---
                        echo "[!] EVENTO DE DISPOSITIVO DETECTADO (Cuenta: {$account_id})\n";
                        echo "    [+] ID de Teléfono: {$doc_id}\n";
                        echo "    [+] Nombre en Kazoo: {$device_name}\n";
                        echo "    [+] MAC Detectada: {$mac_address}\n";
                        
                        if ($is_deleted) {
                            echo "    [-] Estado: Eliminado de Monster UI. Ejecutando limpieza...\n";
                            procesar_eliminacion_dispositivo($account_id, $doc_id, $mac_address);
                        } else {
                            if ($realm_cuenta === null) {
                                $realm_cuenta = obtener_realm_de_cuenta($url, $user, $pass, $db_name, $account_id);
                            }
                            
                            // Inyectamos el Realm directamente dentro del array del documento del dispositivo
                            $doc['sip']['realm'] = $realm_cuenta;
                            
                            // Extraer Extensión / Presence ID desde los callflows de la cuenta
                            $extension = obtener_extension_dispositivo($url, $user, $pass, $db_name, $doc_id);
                            
                            // Inyectamos la extensión en el payload del dispositivo
                            $doc['sip']['extension'] = $extension;
                            
                            // Si el dispositivo no tiene un presence_id explícito, usamos la extensión como presence_id estándar
                            if (empty($doc['presence_id'])) {
                               $doc['presence_id'] = $extension;
                            }
                            
                            echo "    [*] Estado: Creado o Modificado. Regenerando plantilla...\n";
                            procesar_cambio_dispositivo($account_id, $doc_id, $doc);
                        }
                    }
                }
            }
        }
    }
}
// Función auxiliar para ir a traer el Realm desde el documento maestro de la cuenta
function obtener_realm_de_cuenta($url, $user, $pass, $db_name, $account_id) {
    $account_doc_url = "{$url}/" . urlencode($db_name) . "/" . urlencode($account_id);
    
    $ch = curl_init($account_doc_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if ($user !== '-') curl_setopt($ch, CURLOPT_USERPWD, "{$user}:{$pass}");
    
    $res = curl_exec($ch);
    curl_close($ch);
    
    if ($res) {
        $account_doc = json_decode($res, true);
        if (isset($account_doc['realm'])) {
            return $account_doc['realm'];
        }
    }
    
    return "realm_no_detectado.com"; // Valor por defecto en caso de fallo
}

// --- FUNCIÓN PARA BUSCAR LA EXTENSIÓN (CALLFLOW) ---
function obtener_extension_dispositivo($url, $user, $pass, $db_name, $device_id) {
    // Consultamos la vista de diseño nativa de Kazoo para listar callflows rápidamente
    // Si tu CouchDB no tiene esta vista indexada, puedes usar un filtro plano de documentos
    $callflows_url = "{$url}/" . urlencode($db_name) . "/_all_docs?include_docs=true";
    
    $ch = curl_init($callflows_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if ($user !== '-') curl_setopt($ch, CURLOPT_USERPWD, "{$user}:{$pass}");
    
    $res = curl_exec($ch);
    curl_close($ch);
    
    if ($res) {
        $all_docs = json_decode($res, true);
        if (isset($all_docs['rows'])) {
            foreach ($all_docs['rows'] as $row) {
                $doc = isset($row['doc']) ? $row['doc'] : [];
                
                // Buscamos documentos que sean de tipo 'callflow'
                if (isset($doc['pvt_type']) && $doc['pvt_type'] === 'callflow') {
                    
                    // Verificamos si este callflow apunta a nuestro dispositivo actual en sus reglas de marcado
                    $flow_json = json_encode($doc['flow']);
                    if (strpos($flow_json, $device_id) !== false) {
                        
                        // Extraemos el número asignado (normalmente el primer elemento del array 'numbers')
                        if (!empty($doc['numbers'][0])) {
                            return $doc['numbers'][0];
                        }
                    }
                }
            }
        }
    }
    
    return "100"; // Extensión de respaldo por defecto si el teléfono no está mapeado a un flujo
}

// --- LÓGICA DE NEGOCIO PARA TU PROVISIONADOR ---

function procesar_cambio_dispositivo($account_id, $device_id, $device_data) {
    // Aquí tienes todo listo para tu lógica del provisionador (fmateo05)
    // El parámetro '$device_data' ya contiene el JSON completo del teléfono con sus credenciales SIP,
    // codecs, campos de botones (BLF), etc. No necesitas consultar nada más.
    
    $username = isset($device_data['sip']['username']) ? $device_data['sip']['username'] : 'sin_user';
    provisioner('doc_edited','device',$account_id,$device_id,$device_data);
    echo "    [OK] Archivo de configuración actualizado para la extensión SIP: {$username}\n\n";
}

function procesar_eliminacion_dispositivo($account_id, $device_id, $mac_address) {
    // Si el teléfono tenía una MAC asignada, puedes usar este bloque para borrar automáticamente
    // su archivo de configuración física en tu directorio plano /opt/provisioner
    if ($mac_address !== 'Sin MAC') {
        provisioner('doc_deleted','device',$account_id,$device_id,$device_id);
        echo "    [OK] Removiendo archivo físico asociado a la MAC: {$mac_address}\n\n";
    }
}
