<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 02-May-20
 * Time: 11:15 AM
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
        $loginUser = $userData->user;
        $loginUserLevel = $loginUser->user_level;
        $loginUserRoleId = $loginUser->user_role_id;
        $loginUserId = $userData->loginUserId;
        $currentStatus = $userData->userStatus;

        $userId = isset($_POST['id']) ? $database->escape_value($_POST['id']) : 0;

        if ($userId == 0) {
            dieWithError("Parameters not found!", $database);
        }

        $query = "UPDATE financials_users SET user_login_status = 'DISABLE', user_delete_status = 1, user_deleted_by = $loginUserId WHERE user_id = $userId LIMIT 1;";

        $result = $database->query($query);

        if ($result && $database->affected_rows() == 1) {
            $response->code = OK;
            $response->message = "User deleted.";
        } else {
            $response->code = NOT_OK;
            $response->message = "Unable to delete this user!";
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

