<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 09-Mar-20
 * Time: 12:45 PM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../libs/jwt-core.php';
require_once '../libs/php-jwt-master/src/BeforeValidException.php';
require_once '../libs/php-jwt-master/src/ExpiredException.php';
require_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
require_once '../libs/php-jwt-master/src/JWT.php';

use \Firebase\JWT\JWT;

require_once("../functions/db_functions.php");


function dieWithError($errorMessage = "", $database = null) {
    $response = (object)array('success' => 1, 'code' => 0, 'message' => '', 'data' => array());
    $response->message = $errorMessage == "" ? "Unable to process your request!" : $errorMessage;
    $response->success = OK;
    echo json_encode($response);
    if ($database != null && isset($database)) {
        $database->close_connection();
    }
    die();
}

function dieIfNotPost($database = null) {
    $response = (object)array('success' => 1, 'code' => 0, 'message' => '', 'data' => array());
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $response->message = "Only POST allow to access this page!";
        $response->success = OK;
        echo json_encode($response);
        if ($database != null && isset($database)) {
            $database->close_connection();
        }
        die();
    }
}

function dieIfNotGet($database = null) {
    $response = (object)array('success' => 1, 'code' => 0, 'message' => '', 'data' => array());
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        $response->message = "Only GET allow to access this page!";
        $response->success = OK;
        echo json_encode($response);
        if ($database != null && isset($database)) {
            $database->close_connection();
        }
        die();
    }
}



function dieIfNotAuth($database = null) {
    $response = (object)array('success' => 1, 'code' => 0, 'message' => '', 'data' => array());
    if (isset($_SERVER[AUTH_HEADER])) {
        return $_SERVER[AUTH_HEADER];
    } else {
        $response->message = "Auth token not found!";
        $response->success = OK;
        echo json_encode($response);
        if ($database != null && isset($database)) {
            $database->close_connection();
        }
        die();
    }
}

function dieIfNotValidUser($jwt, $database = null) {
    $response = (object)array('success' => 1, 'code' => 0, 'message' => '', 'data' => array());
    global $jwtEncryptKey;
    try {
        $decoded = JWT::decode($jwt, $jwtEncryptKey, array('HS256'));
        $loginUserId = $decoded->data->id;

        $user = getUser($loginUserId);
        if ($user->found === true) {
            $currentStatus = $user->properties->user_login_status;
//            $modularGroupId = $user->user_modular_group_id == null ? 0 : $user->user_modular_group_id;

            if ($currentStatus != 'ENABLE') {
                $response->message = "Your account status is 'DISABLE' please contact to your admin!";
                $response->success = OK;
                echo json_encode($response);
                if ($database != null && isset($database)) {
                    $database->close_connection();
                }
                die();
            }

//            $modularGroup = getModularGroup($modularGroupId);
//            $currentModuleId = 0; // todo
//            if ($modularGroup->found == true) {
//                $modularGroup = $modularGroup->properties;
//                $thirdLevelModuleIds = $modularGroup->mg_config;
//
//                if (strpos($thirdLevelModuleIds, $currentModuleId) === false) {
//                    $response->message = "You are not Authorized to access this Module!";
//                    $response->success = OK;
//                    echo json_encode($response);
//                    if ($database != null && isset($database)) {
//                        $database->close_connection();
//                    }
//                    die();
//                }
//
//            }

            return (object)array("user" => $user->properties, "loginUserId" => $loginUserId, "userStatus" => $currentStatus);
        } else {
            $response->message = "User not found";
            $response->success = OK;
            echo json_encode($response);
            if ($database != null && isset($database)) {
                $database->close_connection();
            }
            die();
        }

    } catch (Exception $e) {

        $response->message = "Invalid User: " . $e->getMessage();
        $response->success = OK;
        echo json_encode($response);
        if ($database != null && isset($database)) {
            $database->close_connection();
        }
        die();
    }

}

