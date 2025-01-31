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

        if (isset($_POST['uid']) && isset($_POST['abl'])) {

            $userId = $database->escape_value($_POST['uid']);
            $userAbility = $database->escape_value($_POST['abl']);

            if ($userId > SUPER_ADMIN_ID) {

                $usernameCheckQuery = "UPDATE financials_users SET user_login_status = '$userAbility' WHERE user_id = $userId and user_id != 1 LIMIT 1";

                $resultExists = $database->query($usernameCheckQuery);

                if ($resultExists) {

                    $response->data = $userAbility;
                    $response->code = OK;
                    $response->message = "User $userAbility successfully.";

                } else {
                    $response->code = NOT_OK;
                    $response->message = "Unable to $userAbility the user!";
                }

            } else {
                $response->code = NOT_OK;
                $response->message = "Super Admin cannot be Enabled/Disabled!";
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


