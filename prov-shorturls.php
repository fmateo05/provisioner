    <?php

    $lockFile = __DIR__ . '/script.lock';
    $fp = fopen($lockFile, 'w+');

    // Attempt to acquire an exclusive lock without blocking (LOCK_NB)
    if (!flock($fp, LOCK_EX | LOCK_NB)) {
        // If the lock cannot be acquired, another process is already running this script
        header('HTTP/1.1 429 Too Many Requests');
        echo "This script is already executing.";
        fclose($fp);
        exit;
    }


  

  

    $host = '127.0.0.1';
    $database = 'shlink';
    $user = 'provisioner';
    $password = 'provisioner';


    $json = json_decode(file_get_contents("php://input"),true);


    //file_put_contents("/var/www/html/webhook-data.log",print_r($json,true), FILE_APPEND);


    $wh_action = $json['action'];
    $wh_type = $json['type'];



    if($wh_type === 'device'){
    $device_id = $json['id'];

    }

    $shlink_domain = $json['shlink_domain'];   
    $shlink_api_key = $json['shlink_api_key'];




    $account_id = $json['account_id'];
    $longurl = $json['portal_url'] . '/links/' . $account_id;


    function _get_account_db($account_id) {
            // account/xx/xx/xxxxxxxxxxxxxxxx
            return "account/" . substr_replace(substr_replace($account_id, "/", 2, 0), "/", 5, 0);
        }


    $account_db = str_replace('/','%2F',_get_account_db($account_id));





    $dbconn = "host=$host dbname=$database user=$user password=$password sslmode=require";
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


    if ($json['action'] === 'doc_edited' && $json['type'] === 'account'){ 


         $body =  ["longUrl" => $longurl , "title" => $account_id ];
         $bodyjson = json_encode($body);  



      $cmd = "curl -X GET  https://" . $shlink_domain . "/rest/v3/short-urls -H 'Content-Type: application/json' -H 'X-API-Key: " . $shlink_api_key . "'"; 
      $cmd_exec = shell_exec($cmd);  
      $data = json_decode($cmd_exec,true);

      $keys =  $data['shortUrls']['data'] ;
      $sql_sel_data = "SELECT shortcode FROM shorturls WHERE account = $1 ;";
      

      $sql_ins_data = "INSERT INTO shorturls (shorturl,shortcode,longurl,account) VALUES ($1, $2, $3, $4);";
      $sql_upd_data = "UPDATE shorturls SET shorturl = $1 , shortcode = $2, longurl = $3 WHERE account = $4"; 
      
      $title = '';
      $shorturl = '';
      $shortcode = '';
      $longurl = '';

      foreach($keys as $shorturldata) {
      //  file_put_contents("/var/www/html/webhook-data.log",print_r($shorturldata,true), FILE_APPEND);  
      $shorturl = $shorturldata['shortUrl'] ;
         $shortcode = $shorturldata['shortCode'] ;       
         $longurl = $shorturldata['longUrl']; 
         $title = $shorturldata['title'];
         
      $sql_query_data = safe_sql_exec($conn_pg,$sql_sel_data,[$title]);
     


         

        $sql_params = [
           $shorturl,
           $shortcode ,
           $longurl ,
           $title
        ];       

//         if ($title != $account_id){
//         $cmd = "curl -X POST  https://" . $shlink_domain . "/rest/v3/short-urls -H 'Content-Type: application/json' -H 'X-API-Key: " . $shlink_api_key . "' -d '" . $bodyjson  . "'"; // cafaf588-adde-4435-a5a5-fb230a0462d4"     
//    //  //   shell_exec($cmd);  
//         file_put_contents("/var/www/html/webhook-data.log",print_r($cmd,true), FILE_APPEND); 
//         
//         } 

       if (pg_num_rows($sql_query_data) == 0) {


        safe_sql_exec($conn_pg,$sql_ins_data,$sql_params); 
       } else {
        safe_sql_exec($conn_pg,$sql_upd_data,$sql_params);    
       }
         
      }
      if ($title != $account_id){
         
         $cmd = "curl -X POST  https://" . $shlink_domain . "/rest/v3/short-urls -H 'Content-Type: application/json' -H 'X-API-Key: " . $shlink_api_key . "' -d '" . $bodyjson  . "'"; // cafaf588-adde-4435-a5a5-fb230a0462d4"     
         $cmdpost =   shell_exec($cmd);  
         $postresponse = json_decode($cmdpost,true);
        
         $shourturlpost = $postresponse['shortUrl'] ;
         $shortcodepost = $postresponse['shortCode'] ;       
         $longurlpost = $postresponse['longUrl']; 
         $titlepost = $postresponse['title'];
         $sql_params = [
           $shorturlpost,
           $shortcodepost ,
           $longurlpost ,
           $titlepost
        ];       
          safe_sql_exec($conn_pg,$sql_ins_data,$sql_params); 
               
//         file_put_contents("/var/www/html/webhook-data.log",print_r($cmd,true), FILE_APPEND); 
         
         }


      file_put_contents("/var/www/html/webhook-data.log",print_r($sql_query_rows,true), FILE_APPEND);  
    }


    // Release the lock when finished
    flock($fp, LOCK_UN);
    fclose($fp);
    unlink($lockFile);
    ?>