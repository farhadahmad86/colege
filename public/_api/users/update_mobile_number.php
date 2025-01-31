<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 01-Aug-19
 * Time: 9:39 AM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
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

require_once("../functions/api_functions.php");

dieIfNotPost();
$jwt = dieIfNotAuth();


require_once("../_db/database.php");
require_once("../functions/db_functions.php");

$response = (object)array('success' => 0, 'code' => 0, 'message' => '', 'data' => array());

try {

    if (isset($jwt)) {

        $userData = dieIfNotValidUser($jwt);
        $user = $userData->user;
        $loginUserId = $userData->loginUserId;
        $currentStatus = $userData->userStatus;

        if (isset($_POST['mb']) || isset($_POST['em'])) {

            $mobileNumber = $database->escape_value($_POST['mb']);
            $emergencyNumber = $database->escape_value($_POST['em']);

            if ($mobileNumber == "") {
                $mobileNumberQuery = "UPDATE financials_users SET user_emergency_contact = '$emergencyNumber' WHERE user_id = $loginUserId LIMIT 1";
            } else if ($emergencyNumber == "") {
                $mobileNumberQuery = "UPDATE financials_users SET user_mobile = '$mobileNumber' WHERE user_id = $loginUserId LIMIT 1";
            } else {

                $response->code = NOT_OK;
                $response->message = "Unable to update Mobile/Emergency number!";

                $response->success = OK;
                echo json_encode($response);

                if (isset($database)) {
                    $database->close_connection();
                }
                die();
            }

            $resultExists = $database->query($mobileNumberQuery);

            if ($resultExists && $database->affected_rows() == 1) {

                $response->data = $mobileNumber;
                $response->code = OK;
                $response->message = "Mobile/Emergency number updated.";

            } else {
                $response->code = NOT_OK;
                $response->message = "Unable to update Mobile/Emergency number!";
            }

        } else {
            $response->message = "Mobile/Emergency number not found!";
        }

    } else {
        $response->message = "Auth token not found!";
    }

} catch (Exception $e) {
    $response->message = $e->getMessage();
}

$response->success = OK;
echo json_encode($response);

if (isset($database)) {
    $database->close_connection();
}


