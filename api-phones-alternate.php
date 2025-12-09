<?php

$user = 'provisioner';
$password = 'provisioner';
$host = '10.0.100.96';
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
    $user = 'provisioner';
    $password = 'provisioner';
    $host = '10.0.100.96';
    $database = 'provisioner';
//    $dsn = "pgsql:host=$host;dbname=$database";
    $dsn = "host=$host dbname=$database user=$user password=$password";
    $conn = pg_connect($dsn);

    $brand_sql = 'SELECT  brand FROM public.brands;';
    $brand_query = pg_query($conn, $brand_sql);
    $brand_arr = pg_fetch_all($brand_query);
  //   pg_free_result($brand_query);
    $brand = $brand_arr;

    
    $brand_data = [];
    $family_data = [];
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
        
        
        
           $brand_data = [ $brands[$i] => [ "id" => $brands[$i], "name" => $brands[$i], "families" => [] ]];
        $count_family = count($family_arr);
        //$count_nest = count(array_keys($fam))
      //  pg_free_result($family_query);
      for ($j = 0 ; $j < $count_family ; $j++){
         // $families[$i] = $family_arr[$j]['family'] ;
              $families[$j] = $family_arr[$j]['family'];
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
            $family_data[$families[$j]] =  ["id" => $brands[$i] . '_' . $families[$j], "name" => $families[$j], "models" => [] ];
            
           
            //       for ($j = 0 ; $j <= $count_family; $j++){
        
      
       
       
       
      
     // --  $family_data = [ $families[$j] => ["id" => $brands[$i] . '_' . $families[$j], "name" => $families[$j], "models" => [] ]];
        
//           $family_temp_data[] = $family_data[$families[$j]];
//           $brand_temp_data[] =  $brand_data[$brands[$i]]['families'];
           
                        
                    
                            // array_push($brand_data[$value]['families'],$family_data[$brand]);
                             array_push($brand_data[$brands[$i]]['families'],$family_data[$families[$j]]);
                       
                        
               
            
             //   backup        $family_data[$j] = ["id" => $brands[$i], "name" => $brands[$i], "families" => [$families[$j] => ["id" => $brands[$i] . '_' . $families[$j], "name" => $families[$j] ]]];
            //  $brand_data = [ ["families" =>  [ $family['family']  => [ "id" => $brand['brand'] .'_' . $family['family'], "name" => $family['family']   ]  ] ] ];
           
            
            
// backup            $model_sql = "select model from models where brand = '" . $brands[$i] . "' and family = '" . $family['family'] . "';";   // and model = 'dp715';";
        //    $model_sql = "select model from models where brand = '" . $brands[$i] . "' and family = '" . $families[$j] . "';";   // and model = 'dp715';";
        //    $model_query = pg_query($conn, $model_sql);
        //    $model_arr = pg_fetch_all($model_query);

//            $count_model = count(array_keys($model_arr));
//            foreach ($model_arr as $model) {
//                //           for ($k = 0 ; $k < $count_model ; $k++){    
//                //$model = $model_arr;
//
//                // $model_data =  [ ["families" => [ "models" => [ $model['model'] => ["id" => $brand['brand'] . '_' . $family['family'] . '_' . $model['model'] , "name" => $model['model'] ] ]]]  ]  ;
//// backup                $model_data = [ $brand['brand'] => [ "id" => $brand['brand'], "name" => $brand['brand'], "families" => [$family['family'] => ["id" => $brand['brand'] . '_' . $family['family'], "name" => $family['family']  , "models" => [ [ $model['model'] => ["id" => $brand['brand'] . '_' . $family['family'] . '_' . $model['model'] , "name" => $model['model'] ]  ] ]  ]]] ];   
//                    
//                $model_data = ["id" => $brands[$i], "name" => $brands[$i], "families" => [$family['family'] => ["id" => $brands[$i] . '_' . $family['family'], "name" => $family['family'], "models" => [[$model['model'] => ["id" => $brands[$i] . '_' . $family['family'] . '_' . $model['model'], "name" => $model['model']]]]]]];
//            
//                
//            }
           // $brand_data[$brands[$i]]['families'] = $family_data[$j][$families];
//       
        
        //}
          
            

        
        
        
       //$brand_data[$brands[$i]]['families'] = $family_data[$families[$j]];
       
            
      }    
             
              
             
        $phone_data[$i] = [];
//        $phone_data[$i]['brand'] = [];
//       $brand_data += $phone_data;
        
   //     $phone_data[$i] += $brand_data ;
    //    $phone_data[$i] += $model_data;
        // $phone_data += $newbrand_data;
        //$phone_data = $brand_data ;

        $json_data['data'] = $phone_data;
        $json = json_encode($json_data);
     //   print_r($brands);
        
    //print_r();
     print_r($brand_data);
    }
 
  pg_close($conn);

}

_getAllPhonesInfo();
