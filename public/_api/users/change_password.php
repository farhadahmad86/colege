<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 05-Aug-19
 * Time: 1:19 PM
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

        if (isset($_POST['op']) && isset($_POST['np'])) {

            $oldPassword = $database->escape_value($_POST['op']);
            $newPassword = $database->escape_value($_POST['np']);

            $passwordMatch = 0;

            $q = "SELECT user_password as password, user_status as status FROM financials_users WHERE user_id = $loginUserId LIMIT 1;";
            $r = $database->query($q);

            if ($r) {
                $u = $database->fetch_assoc($r);

                $p = $u['password'];
                $passwordMatch = password_verify($oldPassword, $p);
                if (empty($passwordMatch)) {
                    $passwordMatch = 0;
                }
            }

            if ($passwordMatch == 1) {

                $newPassHash = makHash($newPassword);

                $usernameCheckQuery = "UPDATE financials_users SET user_password = '$newPassHash' WHERE user_id = $loginUserId LIMIT 1";

                $resultExists = $database->query($usernameCheckQuery);

                if ($resultExists && $database->affected_rows() == 1) {

                    $response->code = OK;
                    $response->message = "User password updated.";

                } else {
                    $response->code = NOT_OK;
                    $response->message = "Unable to change password!";
                }

            } else {
                $response->code = NOT_VALID;
                $response->message = "Invalid old password!";
            }

        } else {
            $response->message = "Parameters not found!";
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



