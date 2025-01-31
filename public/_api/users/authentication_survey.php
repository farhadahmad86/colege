<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('default_charset', 'UTF-8');
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: false");
header('Access-Control-Allow-Methods: POST');
//header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
header('Access-Control-Max-Age: 0');
header("Cache-Control: no-cache");
header("Pragma: no-cache");
header('content-type: application/json; charset=UTF-8');

require_once '../libs/jwt-core.php';
require_once '../libs/php-jwt-master/src/BeforeValidException.php';
require_once '../libs/php-jwt-master/src/ExpiredException.php';
require_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
require_once '../libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

require_once("../_db/database.php");
require_once("../functions/db_functions.php");

$response = (object) array('success' => 0, 'code' => 0, 'message' => '', 'data' => array());

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response->message = "Only POST allow to access this page!";
    echo json_encode($response);

    if (isset($database)) {
        $database->close_connection();
    }
    die();
}

$ANDROID = 0;
$IOS = 1;

if (isset($_POST['un']) && isset($_POST['ps'])) {

    $user = array();

    $passwordMatch = 0;

    $username = $database->escape_value($_POST['un']);
    $password = $database->escape_value($_POST['ps']);

    $platform = isset($_POST['pf']) ? $database->escape_value($_POST['pf']) : 0;
    $checkLogin = isset($_POST['cl']) ? $database->escape_value($_POST['cl']) : 0;
    $deviceInfo = isset($_POST['di']) ? $database->escape_value($_POST['di']) : "";

    $q = "SELECT user_password as password FROM financials_users WHERE (user_username = '$username' OR user_email = '$username') LIMIT 1;";
    $r = $database->query($q);

    if ($r && $database->num_rows($r) == 1) {
        $u = $database->fetch_assoc($r);

        $p = $u['password'];
        $passwordMatch = password_verify($password, $p);
        if (empty($passwordMatch)) {
            $passwordMatch = 0;
        }
    }

    if ($passwordMatch == 1) {

        $usernameCheckQuery = "SELECT 
                              user_id as id,
                              user_employee_code as employee_code,
                              user_name as name,
                              user_father_name as father_name,
                              user_email as email,
                              user_login_status as status,
                              user_android_status as androidStatus,
                              user_ios_status as iosStatus,
                              user_delete_status as deleted,
                              user_level as level,
                              user_role_id as role_id,
                              user_designation as designation,
                              user_username as username,
                              user_mobile as mobile,
                              user_cnic as cnic,
                              user_emergency_contact as emergency_contact,
                              user_family_code as family_code,
                              user_marital_status as marital_status, 
                              user_religion as religion, 
                              user_blood_group as blood_group, 
                              user_city as city,
                              user_address as address,
                              user_profilepic as image_url
                            FROM financials_users us
                            WHERE (us.user_username = '$username'  OR us.user_email = '$username') AND $passwordMatch = 1 LIMIT 1";

        $resultExists = $database->query($usernameCheckQuery);

        if ($resultExists && $database->num_rows($resultExists) == 1) {
            $user = $database->fetch_assoc($resultExists);

            $superAdminID = SUPER_ADMIN_ID;
            if ($user['id'] != $superAdminID && $user['status'] == "DISABLE") {
                $response->code = DISABLE;
                $response->message = "Your account is 'DISABLE' please contact to you admin for login!";

                $response->data = array();

            } else if ($user['id'] != $superAdminID && $user['deleted'] == 1) {

                $response->code = DELETED;
                $response->message = "Your account is 'DELETED' please contact to you admin for login!";

                $response->data = array();

            } else if ($checkLogin == 1 && $platform == $ANDROID && $user['androidStatus'] == 'online') {

                $response->code = ALREADY_LOGIN;
                $response->message = "You already login to other ANDROID device please logout from that device first!";

                $response->data = array();

            } else if ($checkLogin == 1 && $platform == $IOS && $user['iosStatus'] == 'online') {

                $response->code = ALREADY_LOGIN;
                $response->message = "You already login to other IOS device please logout from that device first!";

                $response->data = array();

            } else {
                $token = array(
                    "iss" => $iss,
                    "aud" => $aud,
                    "iat" => $iat,
                    "data" => array(
                        "id" => $user['id'],
                        "name" => $user['name'],
                        "username" => $user['username'],
                        "email" => $user['email'],
                        "level" => $user['level'],
                        "status" => $user['status'],
                        "roleId" => $user['role_id']
                    )
                );

                $authKey = JWT::encode($token, $jwtEncryptKey);

                $cId = $user['city'];
                if ($cId != "" && $cId > 0) {
                    $cityData = getCity($cId);
                    if ($cityData->found == true) {
                        $user['city'] = $cityData->properties->city_name;
                    } else {
                        $user['city'] = "Unknown";
                    }
                } else {
                    $user['city'] = "Unknown";
                }

                $user['auth'] = $authKey;

                $response->data = $user;
                $response->code = OK;
                $response->message = "Valid Credentials.";

                $currentLoginInUserId = $user['id'];
                if ($platform == $ANDROID) {
                    $loginQuery = "UPDATE financials_users SET user_android_status = 'online' WHERE user_id = $currentLoginInUserId LIMIT 1;";
                } else {
                    $loginQuery = "UPDATE financials_users SET user_ios_status = 'online' WHERE user_id = $currentLoginInUserId LIMIT 1;";
                }

                $loginResult = $database->query($loginQuery);

            }

        } else {
            $response->code = NOT_FOUND;
            $response->message = "No result found!";
        }

    } else {
        $response->code = NOT_VALID;
        $response->message = "Invalid Credentials!";
    }
} else {
    $response->message = "Credentials not found!";
}
$response->success = OK;
echo json_encode($response);

if (isset($database)) {
    $database->close_connection();
}
