<?php
header('Access-Control-Allow-Headers:Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control, X-Auth-Token');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Origin: https://portal.nodtmf.com');
header('Access-Control-Max-Age:86400');


$user = 'provisioner';
$password = 'provisioner';
$host = '127.0.0.1';
$database = 'provisioner';

$dsn = "pgsql:host=$host;dbname=$database";

$pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

//$brand_sql = 'SELECT brand FROM public.brands';
//$family_sql = "SELECT  distinct family FROM public.models WHERE brand='grandstream' and family='dp7xx';" ;
//
//$brand_stmt = $pdo->query($brand_sql);
//$family_stmt = $pdo->query($family_sql);
//$model_sql = "select model from models where brand = 'grandstream' and family = 'dp7xx' and model = 'dp715';";
//$model_stmt = $pdo->query($model_sql);
// $brand_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
//function _buildDocumentName($brand, $family = null, $model = null) {
//        if ($model)
//            return $brand . "_" . $family . "_" . $model;
//        elseif ($family)
//            return $brand . "_" . $family;
//        elseif ($brand)
//            return $brand;
//        else
//            return false;
//    }


function _getAllPhonesInfo() {
//    $json_data = [];
    $result = [];
    $user = 'provisioner';
    $password = 'provisioner';
    $host = '127.0.0.1';
    $database = 'provisioner';
//    $dsn = "pgsql:host=$host;dbname=$database";
    $dsn = "host=$host dbname=$database user=$user password=$password";
    $conn = pg_connect($dsn);

    $brand_sql = 'SELECT  brand FROM public.brands;';
    $brand_query = pg_query($conn, $brand_sql);
    $brand_arr = pg_fetch_all($brand_query);
  //   pg_free_result($brand_query);
    $brand = $brand_arr;


    $brand_result = [];
    $family_result =[];
    $model_result = [];
  //  $family_data = [];
    //  $model_sql = "select model from models;"; //where brand = 'grandstream' and family = 'dp7xx' and model = 'dp715';";
    //   $model_stmt = $pdo->query($model_sql);
    // This is correct
    // Fetch a single row as an associative array


    $count_brands = count($brand_arr);

    //  foreach ($brands as $brand ){
    for ($i = 0; $i < $count_brands; $i++) {
        $brands[$i] = $brand[$i]['brand'] ;
        $family_sql = "SELECT  distinct family FROM public.models WHERE brand='" . $brands[$i] . "' ";
//        $family_sql = "SELECT   family FROM public.models WHERE brand='". $brand[$i]['brand'].  "' ";
        $family_query = pg_query($conn, $family_sql);
        $family_arr = pg_fetch_all($family_query);



         //  $brand_data = [ $brands[$i] => [ "id" => $brands[$i], "name" => $brands[$i], "families" => [] ]];
               $brand_data = [ $brands[$i] => [ "id" => $brands[$i], "name" => $brands[$i], 'families' => [] ]];

        $count_family = count($family_arr);
        //$count_nest = count(array_keys($fam))
      //  pg_free_result($family_query);
      for ($j = 0 ; $j < $count_family ; $j++){
         // $families[$i] = $family_arr[$j]['family'] ;
              $families = $family_arr[$j]['family'];
              $family[$j] =  $family_arr[$j]['family'];
        $otherbrand_sql = "SELECT  brand FROM public.models where family='".$family_arr[$j]['family'] ."' limit 1;";
//        $family_sql = "SELECT   family FROM public.models WHERE brand='". $brand[$i]['brand'].  "' ";
        $otherbrand_query = pg_query($conn, $otherbrand_sql);
        $otherbrand_arr = pg_fetch_all($otherbrand_query);
   //     $families[$j] = $family_arr[$j]['family'];


       // $otherbrand[$j] = $otherbrand_arr[$j]['brand'];



//        $fam_all[$fam_count] = $families;
//  backup       $brand_data[$i] = [ $brands[$i] => [ "id" => $brands[$i], "name" => $brands[$i], "families" => [] ]];



         //$family_data = [];
      //  $family_data[$families[$j]] = [ $families[$j] => ["id" => $brands[$i] . '_' . $families[$j], "name" => $families[$j], "models" => [] ]];
         //$family_data[$families[$j]] = [$families[$j] => ["id" => $brands[$i] . '_' . $families[$j], "name" => $families[$j], "models" => [] ]];
        $family_data =  [ $families => ["id" => $brands[$i] . '_' . $families, "name" => $families, "models" => [] ]];


       // $brand_data += array_merge_recursive($brand_data,["family" => []]) ;
       // $family_result = $family_data[$families[$j]]['families'];

            //       for ($j = 0 ; $j <= $count_family; $j++){






     // --  $family_data = [ $families[$j] => ["id" => $brands[$i] . '_' . $families[$j], "name" => $families[$j], "models" => [] ]];

//           $family_temp_data[] = $family_data[$families[$j]];
//           $brand_temp_data[] =  $brand_data[$brands[$i]]['families'];



                            // array_push($brand_data[$value]['families'],$family_data[$brand]);
                            // array_push($brand_data[$brands[$i]]['families'],$family_data[$families[$j]]);
                          $brand_data[$brands[$i]]['families'] += $family_data;



             //   backup        $family_data[$j] = ["id" => $brands[$i], "name" => $brands[$i], "families" => [$families[$j] => ["id" => $brands[$i] . '_' . $families[$j], "name" => $families[$j] ]]];
            //  $brand_data = [ ["families" =>  [ $family['family']  => [ "id" => $brand['brand'] .'_' . $family['family'], "name" => $family['family']   ]  ] ] ];



// backup            $model_sql = "select model from models where brand = '" . $brands[$i] . "' and family = '" . $family['family'] . "';";   // and model = 'dp715';";
            $model_sql = "select model from models where brand = '" . $brands[$i] . "' and family = '" . $families . "';";   // and model = 'dp715';";
            $model_query = pg_query($conn, $model_sql);
            $model_arr = pg_fetch_all($model_query);

            $count_model = count($model_arr);


//            foreach ($model_arr as $model) {
                  for ($k = 0 ; $k < $count_model ; $k++){
                $model = $model_arr[$k]['model'];
//
//                // $model_data =  [ ["families" => [ "models" => [ $model['model'] => ["id" => $brand['brand'] . '_' . $family['family'] . '_' . $model['model'] , "name" => $model['model'] ] ]]]  ]  ;
//// backup                $model_data = [ $brand['brand'] => [ "id" => $brand['brand'], "name" => $brand['brand'], "families" => [$family['family'] => ["id" => $brand['brand'] . '_' . $family['family'], "name" => $family['family']  , "models" => [ [ $model['model'] => ["id" => $brand['brand'] . '_' . $family['family'] . '_' . $model['model'] , "name" => $model['model'] ]  ] ]  ]]] ];
	        $template = [ "feature_keys" => [ "iterate" => '15'], "combo_keys" => ["iterate" => '15'], "expansion_keys" => ["iterate" => '15'] ] ;
//
	        if($method = 'GET'){
               $model_data = [ $model => ["id" => $brands[$i] . '_' . $families . '_'. $model, "name" => $model, "template" => $template ]];

	        } else if($method = 'OPTIONS'){

               $model_data = [  "template" => $template, 'brand' => $brands[$i], 'family' => $families , 'model' => $model ]  ;

	        } else {
               $model_data = [ "template" => $template, 'brand' => $brands[$i], 'family' => $families , 'model' => $model  ];

	        }

              // $family_data[$families]['models'] += $model_data;

               $brand_data[$brands[$i]]['families'][$families]['models'] += $model_data  ;
              // $brand_data[$brands[$i]]['families'] = $family_data  ;

                //$brand_data[$brands[$i]]['families'],$family_data);
             //  $brand_data[$brands[$i]]['families'][$families]['models'] += $model_data;

            //   $brand_data[$brands[$i]]['families'][$families]['models'] += $model_data ;
//
        //     array_push($brand_data[$brands[$i]]['families'][$j][$families[$j]]['models'],$model_data[$model[$k]]);
//            }
           // $brand_data[$brands[$i]]['families'] = $family_data[$j][$families];
//

        }






       //$brand_data[$brands[$i]]['families'] = $family_data[$families[$j]];


      }



      //  $phone_data[$i] = [];
//        $phone_data[$i]['brand'] = [];
//       $brand_data += $phone_data;

   //     $phone_data[$i] += $brand_data ;
    //    $phone_data[$i] += $model_data;
        // $phone_data += $newbrand_data;
        //$phone_data = $brand_data ;




     //   print_r($brands);

   // print_r($family_data);


      $brand_result[$brands[$i]] =  $brand_data[$brands[$i]]  ;


   }
 //$json_data['data'] = $brand_result ;
//$json = json_encode($json_data,JSON_PRETTY_PRINT);
//print_r($json);

//$json = json_encode($json_data,JSON_PRETTY_PRINT);
 // pg_close($conn);
return $brand_result ;
}



$subpaths = array_filter(explode('/', $_SERVER['REQUEST_URI']));
$brand = preg_replace('/\?_=(\d+)/i', '', $subpaths['3']);
$family = preg_replace('/\?_=(\d+)/i', '', $subpaths['4']);
$model = preg_replace('/\?_=(\d+)/i', '', $subpaths['5']);


// _getAllPhonesInfo();

$method = $_SERVER['REQUEST_METHOD'];


function getElement($brand = null, $family = null, $model = null, $method) {
        if (!$brand){
            $result['data'] = _getAllPhonesInfo();
            //$result = $this->db->getAllByKey('factory_defaults', 'brand', null);
        } elseif (!$family){
            $data = _getAllPhonesInfo();

            $result['data'] = $data[$brand]['families'] ;

       //     $result['data'] = $this->db->getAllByKey('factory_defaults', 'family', $brand);
        } elseif (!$model) {
              $data = _getAllPhonesInfo();
              $result['data'] = $data[$brand]['families'][$family]['models'] ;
       //     $result['data'] = $this->db->getAllByKey('factory_defaults', 'model', $family);
        } else {
              $data = _getAllPhonesInfo();
            $result['data'] = $data[$brand]['families'][$family]['models'][$model] ;
//	      unset($result['data']['id']);
//	      unset($result['data']['name']);
        //    $result['data'] = $this->db->get('factory_defaults', $brand . '_' . $family . '_' . $model);

        }
        if (!empty($result)) {
            print_r(json_encode($result,JSON_PRETTY_PRINT));
        } else {
             http_response_code(404);
        }
    }

getElement($brand,$family,$model,$method);

//print_r($brand . '/' . $family . '/' . $model);
