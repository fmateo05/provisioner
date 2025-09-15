<?php

//require_once('/var/www/html/provisioner/vendor/autoload.php');
//require_once __DIR__.'/../vendor/autoload.php';
//require_once __DIR__.'/../vendor/autoload.php';

use chillerlan\QRCode\{QRCode, QROptions};


/*
define('__ROOT__', dirname(dirname(__FILE__)));

require_once(__ROOT__.'/env.php');
 */


$json = json_decode(file_get_contents("php://input"),true);


//file_put_contents("/var/www/html/webhook-data-qr.log",print_r($json,true));


$wh_action = $json['action'];
$wh_type = $json['type'];



if($wh_type === 'device'){
$device_id = $json['id'];

}



		
$account_id = $json['account_id'];


function _get_account_db($account_id) {
        // account/xx/xx/xxxxxxxxxxxxxxxx
        return "account/" . substr_replace(substr_replace($account_id, "/", 2, 0), "/", 5, 0);
    }


$account_db = str_replace('/','%2F',_get_account_db($account_id));


$couch_user = '';
$couch_pass = '';
$couch_host = '';
$couch_port = '15984';



$conn = "http://" . $couch_user . ':' . $couch_pass . '@' . $couch_host . ':' . $couch_port ;
$device = $device_id;

$command_dev = "curl -s ". $conn . '/'  . $account_db . '/' . $device . '| python3 -mjson.tool' ;
$document = shell_exec($command_dev);

$result_dev = json_decode($document,true);

function device_value_user($device_key_value,$account_db,$conn){

$users = $device_key_value;

$command_user = "curl -s ". $conn . '/'  . $account_db . '/' . $users . '| python3 -mjson.tool' ;
$document_user = shell_exec($command_user);
$result_user = json_decode($document_user,true);

return $result_user;
}


$account = $account_id;


$command_acc = "curl -s ". $conn . '/'  . $account_db . '/' . $account . '| python3 -mjson.tool' ;
$document_acc = shell_exec($command_acc);

$result_acc = json_decode($document_acc,true);

$result_user = device_value_user($result_dev['owner_id'],$account_db,$conn);
//file_put_contents('/var/www/html/webhook-data-qr.log',print_r($result_dev,true),FILE_APPEND);	


$request_data_account  = $result_acc;
$request_data_user  = $result_user;
$request_data_device  = $result_dev;

if($request_data_device['provision']['endpoint_brand'] === 'portsip'){
$portsip_qr_data = '{    "name": "'. $request_data_user['caller_id']['internal']['name'] . '",    "dn": "' . $request_data_account['realm'] . '",    "wdn": "' . $request_data_account['realm'] . '",    "ts": [        {            "pn": "UDP",            "port": "5060"        }   ],        "ext": "' . $request_data_device['sip']['username'] . '",    "pwd": "'. $request_data_device['sip']['password'] .'",     "v": 1 }';

} else if($request_data_device['provision']['endpoint_brand'] === 'linphone') {


$portsip_qr_data = 'https://b97816.prov.nodtmf.com:6971/app/provision/' . $request_data_device['mac_address'] . '.xml';


} else {

$portsip_qr_data = '{}';

}




	if ($json['action'] === 'doc_edited' && $json['type'] === 'device'){
//	if ($json['action'] === 'doc_created' && $json['type'] === 'device'){
		if(($request_data_device['provision']['endpoint_brand'] === 'portsip') || ($request_data_device['provision']['endpoint_brand'] === 'linphone' )){


	       $ecc = 'L';
$pixel_Size = 10;
$frame_Size = 5;
$ext = 'svg+xml';
$path = 'images';
$file =  $path.uniqid().".png";




require_once('/var/www/html/vendor/autoload.php');
$qrcode = new QRCode;
$options = new QROptions([
    'eccLevel'       => QRCode::ECC_H, // High error correction
    'outputType'     => QRCode::OUTPUT_IMAGE_PNG,
    'outputBase64'   => false,
    'imageTransparent' => false,
    'bgColor'        => '#FFFFFF', // White background
    'fgColor'        => '#000000', // Black foreground
    'scale'          => 10, // Size of each module
    'addQuietzone'   => true,
    'quietzoneSize'  => 4,
    'logoPath'       => 'https://play-lh.googleusercontent.com/4vt8UALpqWiMbwJn-TmyLF_Lv8aBoyAEgQqXGgECNrJj3cK0PwPHF-JfqovmxMkN6Co=w240-h480-rw', // Optional: path to a logo image
    'logoSpaceWidth' => 100, // Space reserved for logo
    'logoSpaceHeight' => 100,
]);
/*
$options->version      = 7;
$options->outputBase64 = false;
$options->cachefile    =  $file ;
 */


  		$qrcode = (new QRCode($options))->render($portsip_qr_data,$file);
		header('Content-Type: image/png');
	       //$qrcode = (new QRCode)->render($portsip_qr_datae);
//	       $qrcode = QRcode::png($portsip_qr_data, $file, QR_ECLEVEL_H, 10, 0);

               $to      = '"' . $request_data_user['email'] . '"';
	       

               $subject = 'Your PortSIP / Kazoo QR Credentials';
	       // message with attachment
               $headers = 'From: qrcode@gmail.com'       . "\r\n" .
                 'Reply-To: info@gmail.com' . "\r\n" .
                 'Content-Type: image/png' . "\r\n" .
		 'Content-Transfer-Encoding: base64' . "\r\n" .
//		 'Content-Disposition: attachment; filename="template-qrcodestyling.html"' . "\r\n" .
                 'X-Mailer: PHP/' . phpversion();
	       /*
	       $imgstring = trim( str_replace('data:image/'.$ext.';base64,', "", $output) );
        $imgstring = str_replace( ' ', '+', $imgstring );
        $data = base64_decode( $imgstring );
		*/
//	       shell_exec('convert -density 300 -background none ' . $file . ' ' . $file . '.png');
//	       $printftestsvg = sprintf('<p><img src="%s" width="300" height="280"/></p>', 'https://portal.nodtmf.com/qr/' . $file    );
	       $binary_data = file_get_contents($file);
	       $html = base64_encode($binary_data);
//	       $html = $printftestsvg;
/*
$html = "<!DOCTYPE html>
<html>
<head>
  <title>QR Code</title>
</head>
<body>
 <td>
        <h3>
  Don't Forget to Scan your QR Code for Kazoo/PortSIP PBX Login
  \r\n
            </h3>
". $printftestsvg . "
        <br />
            </td>
</body>
</html>";
 */
	       mail($to,$subject,$html,$headers);
	 }
	       

	} else {
			echo "No action or event from webhook performed";
		}
