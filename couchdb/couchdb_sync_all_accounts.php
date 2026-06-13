<?php


require_once('/var/www/env.php');
require_once('/opt/provisioner/prov-alt-webhook.php');

// 1. Configuración de tu JSON
$couch_url  = "http://couchdb-server:5984";
$couch_user = "<user>";
$couch_pass = "<pass>";

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
                        $owner_id = isset($doc['owner_id']) ? $doc['owner_id']: $doc_id;
                        
                        
                       $alllinesck = array_values(array_keys($doc['provision']['combo_keys']))  ;
                        
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
                            
                            // $combo_keys = procesar_cambio_presence_dispositivo($url, $db_name, $user, $pass, $doc);        
                             
                            // Extraer Extensión / Presence ID desde los callflows de la cuenta
                           // Original $extension = obtener_extension_dispositivo($url, $user, $pass, $db_name, $doc_id);
                            // $extension = obtener_extension_dispositivo($url, $user, $pass, $db_name, $owner_id);
                             
                            $doc_updated = procesar_cambio_presence_dispositivo($url, $db_name, $user, $pass, $doc);        
                             unset($doc_updated['provision']['id']);
                           // $doc['sip']['extension'] = $extension;
                           
                          
                            // Si el dispositivo no tiene un presence_id explícito, usamos la extensión como presence_id estándar
//                            if (empty($doc['presence_id'])) {
//                               $doc['presence_id'] = $extension;
//                            }
//                          
                           
                                
                           // print_r($doc_updated);
                            // Inyectamos la extensión en el payload del dispositivo
                            
                            
                            echo "    [*] Estado: Creado o Modificado. Regenerando plantilla...\n";
                            
                            procesar_cambio_dispositivo($account_id, $doc_id, $doc_updated);
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
function obtener_extension_dispositivo($url, $user, $pass, $db_name, $owner_id) {
// Apuntamos directamente al documento del usuario dentro de la BD de la cuenta
    $user_doc_url = "{$url}/" . urlencode($db_name) . "/" . urlencode($owner_id);
    
    $ch = curl_init($user_doc_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if ($user !== '-') curl_setopt($ch, CURLOPT_USERPWD, "{$user}:{$pass}");
    
    $res = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($http_code === 200 && $res) {
        $user_doc = json_decode($res, true);
        
        // Confirmamos que sea un documento de tipo usuario y extraemos su presence_id nativo
        if (isset($user_doc['pvt_type']) && $user_doc['pvt_type'] === 'user') {
            if (!empty($user_doc['presence_id'])) {
                echo "        [✔] Presence ID encontrado en el usuario: " . $user_doc['presence_id'] . "\n";
                return (string)$user_doc['presence_id'];
            }
        }
    }
    return null;
}
function procesar_cambio_presence_dispositivo($url, $db_name, $user, $pass,  $device_data) {
    

    // 1. Extraer los datos base que ya calculamos
    $username    = isset($device_data['sip']['username']) ? $device_data['sip']['username'] : 'sin_user';
    $realm       = isset($device_data['sip']['realm']) ? $device_data['sip']['realm'] : 'sin_realm';
    $extension   = isset($device_data['sip']['extension']) ? $device_data['sip']['extension'] : '100';
  //  $presence_id = isset($device_data['presence_id']) ? $device_data['presence_id'] : $extension;
  //  $presence_id = obtener_extension_dispositivo($url, $user, $pass, $db_name, $owner_id);
    $mac         = isset($device_data['mac_address']) ? $device_data['mac_address'] : '000000000000';

  //  print_r($device_data['provision']['combo_keys']);
    
    echo "    [*] Analizando estructura de botones (Combo Keys) para la MAC: {$mac}...\n";
    
    // 2. Identificar dónde guarda Kazoo las teclas (suele ser en $device_data['combo_keys'])
    // Si tu versión o frontend lo maneja en un nodo plano, nos aseguramos con una condicional
    $keys_path = false;
    if (isset($device_data['provision']['combo_keys'])) {
        $keys_path = 'combo_keys';
    } else if (isset($device_data['provision']['feature_keys'])) {
        $keys_path = 'feature_keys';
    } elseif (isset($device_data['keys'])) {
        $keys_path = 'keys';
    }

    if ($keys_path !== false && is_array($device_data['provision'][$keys_path])) {
        
        // Recorremos cada botón programado en el teléfono
        foreach ($device_data['provision'][$keys_path] as $key_index => $key_properties) {
            
            // Verificamos si el botón tiene una propiedad 'type' o 'function'
            $key_type = isset($key_properties['type']) ? $key_properties['type'] : '';
            
            // FILTRO DE BOTONES: Evaluamos si es una tecla de presencia o de parqueo personal
            if ($key_type === 'presence' || $key_type === 'personal_parking' || $key_type === 'personal parking') {
                
                echo "        [→] Botón programado encontrado en la posición [{$key_index}] de tipo: '{$key_type}'\n";
                
                // Sobreescribimos el valor antiguo por el presence_id limpio calculado por Owner ID
               // $device_data[$keys_path][$key_index]['value'] = $presence_id;
                
                $presence_owner_id = $device_data['provision'][$keys_path][$key_index]['value']['value'] ;
                $presence_id = obtener_extension_dispositivo($url, $user, $pass, $db_name, $presence_owner_id);
                 $device_data['provision'][$keys_path][$key_index]['value']['value'] = (string)$presence_id;
                 // Opcional: Si el teléfono requiere el formato completo extension@realm para el BLF:
                // $device_data[$keys_path][$key_index]['value'] = $presence_id . "@" . $realm;
               
                echo "            [✔] Valor de la tecla actualizado exitosamente a: " . $device_data['provision'][$keys_path][$key_index]['value']['value'] . "\n";
                
            }
        }
    } else {
        echo "        [i] Este dispositivo no tiene botones (Combo Keys) configurados en Monster UI.\n";
    }

    // 3. AQUÍ PROCEDES A COMPILAR TU PLANTILLA FISICA
    // El array '$device_data' ahora tiene los botones modificados en caliente.
    // Puedes pasar este array corregido directamente a tu generador de archivos XML/CFG.
    
    // Ejemplo ficticio de escritura:
    // $archivo_config = "/opt/provisioner/storage/" . $mac . ".cfg";
    // compilar_y_guardar_template_yealink($archivo_config, $device_data);
    
    echo "    [OK] Proceso de transformación de botones finalizado.\n\n";
    return $device_data;
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
