<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 01-May-20
 * Time: 11:38 AM
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

$adminId = SUPER_ADMIN_ID;
$adminLevel = SUPER_ADMIN_LEVEL;
$cashier = CASHIER;
$tellers = TELLER;
$salePersons = SALE_PERSON;
$purchaser = PURCHASER;

try {

    if (isset($jwt)) {

        $userData = dieIfNotValidUser($jwt);
        $loginUser = $userData->user;
        $loginUserLevel = $loginUser->user_level;
        $loginUserRoleId = $loginUser->user_role_id;
        $loginUserId = $userData->loginUserId;
        $currentStatus = $userData->userStatus;

        $users = array();

        $q = isset($_GET['q']) ? $database->escape_value($_GET['q']) : '';
        $roleId = isset($_GET['rid']) ? $database->escape_value($_GET['rid']) : 0;
        $multiRoles = isset($_GET['mrids']) ? $database->escape_value($_GET['mrids']) : '';
        $wa = isset($_GET['wa']) ? $database->escape_value($_GET['wa']) : 0;
        $nu = isset($_GET['nu']) ? $database->escape_value($_GET['nu']) : 0;
        $cashTransfer = isset($_GET['ct']) ? $database->escape_value($_GET['ct']) : 0;

        if ($cashTransfer == 1 && ($loginUserLevel == $adminLevel || $loginUserRoleId == $cashier)) {

            $searchFilter = " WHERE user_role_id = $tellers AND user_delete_status = 0 ";

        } else {

            if ($wa == 1) {
                $searchFilter = " WHERE (user_id > 0 OR user_id = $adminId OR user_role_id = 0) AND user_delete_status = 0 ";
            } else {
                $searchFilter = " WHERE user_id > 0 AND user_delete_status = 0 ";
            }

            if ($multiRoles != '') {
                if ($wa == 1) {
                    $searchFilter .= " AND user_role_id in (0,$multiRoles) ";
                } else {
                    $searchFilter .= " AND user_role_id in ($multiRoles) ";
                }
            }

            if ($roleId > 0) {
                if ($wa == 1) {
                    $searchFilter .= " AND user_role_id in (0,$roleId) ";
                } else {
                    $searchFilter .= " AND user_role_id = $roleId ";
                }
            }

            if ($nu == 1) {
                $searchFilter .= " AND user_id != $loginUserId ";
            }

        }

        if ($q != '') {
            $searchFilter .= " AND user_name LIKE '%$q%' ";
        }


        $query = "SELECT user_id, user_name FROM financials_users $searchFilter order by user_name;";

        $result = $database->query($query);

        if ($result && $database->num_rows($result) > 0) {

            while ($data = $database->fetch_array($result)) {

                $users[] = array('id' => (int)$data['user_id'], 'title' => $data['user_name']);

            }

            if (sizeof($users) > 0) {
                $response->code = OK;
            } else {
                $response->code = DATA_EMPTY;
            }

            $response->data = $users;
            $response->code = OK;
            $response->message = "Users List.";

        } else {
            $response->code = NOT_OK;
            $response->message = "Unable to get Users List.";
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

