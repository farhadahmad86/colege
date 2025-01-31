<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 14-Jul-19
 * Time: 10:38 AM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//date_default_timezone_set('Asia/Karachi');

require_once("../_db/database.php");

$pathInPieces = explode(DIRECTORY_SEPARATOR , __FILE__);
$_path =  $pathInPieces[0].DIRECTORY_SEPARATOR.$pathInPieces[1].DIRECTORY_SEPARATOR.$pathInPieces[2];

$config = parse_ini_file($_path.'/_pos_api_config.ini');

$time = time();
$time2 = time() + (60 * 60); // time + 1 hour

$jwtEncryptKey = $config['jwtkey'];

$iss = $subDomain; // "http://jadeedmunshi.com"; // issuer
$aud = $audience; // "com.jadeedmunshi.jadeed_munshi"; // audience
$iat = $time; // issue at
$nbf = $time; // not before
$exp = $time2; // expire at


//$data = json_decode(file_get_contents("php://input"));
//
////echo $data->jwt;
//
//try {
//    $decoded = JWT::decode($data->jwt, $key, array('HS256'));
//
//    echo "Given: \n";
//    print_r($decoded);
//
//    echo "\n";
//
//} catch (Exception $e) {
//    echo $e->getMessage();
//    echo "\n";
//}
//
//$token = array(
//    "iss" => $iss,
//    "aud" => $aud,
//    "iat" => $iat,
//    "nbf" => $nbf,
//    "exp" => $exp,
//    "data" => array(
//        "id" => 1,
//        "username" => 'admin',
//        "email" => 'admin@jb.com'
//    )
//);
//
//$jwt = JWT::encode($token, $key);
//
//echo "New: \n";
//print_r($jwt);


//echo $_SERVER['HTTP_USER_AGENT'] . "\n";
//echo $_SERVER['REMOTE_ADDR'] . "\n";
//echo $_SERVER['HTTP_JWT'] . "\n";
//echo $_SERVER['HTTP_AUTHORIZATION'] . "\n";
