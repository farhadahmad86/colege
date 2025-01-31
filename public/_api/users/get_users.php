<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 01-May-20
 * Time: 11:54 AM
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

dieIfNotGet();
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
        $search = isset($_GET['search']) ? $database->escape_value($_GET['search']) : '';
        $rg = isset($_GET['rg']) ? $database->escape_value($_GET['rg']) : 0;
        $pg = isset($_GET['pg']) ? $database->escape_value($_GET['pg']) : 0;
        $mg = isset($_GET['mg']) ? $database->escape_value($_GET['mg']) : 0;
        $lvl = isset($_GET['lvl']) ? $database->escape_value($_GET['lvl']) : 0;
        $rl = isset($_GET['rl']) ? $database->escape_value($_GET['rl']) : 0;
        $cb = isset($_GET['cb']) ? $database->escape_value($_GET['cb']) : 0;
        $st = isset($_GET['st']) ? $database->escape_value($_GET['st']) : 1;

        $searchFilter = " WHERE user_id NOT IN ($adminId,$loginUserId) AND user_delete_status = 0";

        if ($q != '') {
            $searchFilter .= " AND user_name LIKE '%$q%' ";
        }

        if ($search != '') {
            $searchFilter .= " AND (user_name LIKE '%$search%' OR user_email LIKE '%$search%') ";
        }

        if ($rg > 0) {
            $searchFilter .= " AND user_account_reporting_group_ids = $rg ";
        }

        if ($pg > 0) {
            $searchFilter .= " AND user_product_reporting_group_ids = $pg ";
        }

        if ($mg > 0) {
            $searchFilter .= " AND user_modular_group_id = $mg ";
        }

        if ($lvl > 0) {
            $searchFilter .= " AND user_level = $lvl ";
        }

        if ($rl > 0) {
            $searchFilter .= " AND user_role_id = $rl ";
        }

        if ($cb > 0) {
            $searchFilter .= " AND user_createdby = $cb ";
        }

        if ($st == 2) {
            $searchFilter .= " AND user_desktop_status = 'online' ";
        } elseif ($st == 3) {
            $searchFilter .= " AND (user_desktop_status = 'NULL' OR user_desktop_status = 'offline' OR user_desktop_status = '') ";
        }

        $query = "SELECT user_id, user_employee_code, user_name, user_email, user_designation, user_login_status, user_profilepic, user_desktop_status 
                    FROM financials_users $searchFilter order by user_name;";

        $result = $database->query($query);

        if ($result) {

            while ($us = $database->fetch_array($result)) {

                $users[] = array(
                    'id' => (int)$us['user_id'],
                    'code' => $us['user_employee_code'],
                    'name' => $us['user_name'],
                    'email' => $us['user_email'],
                    'designation' => $us['user_designation'],
                    'status' => $us['user_login_status'],
                    'desktopStatus' => $us['user_desktop_status'],
                    'profilePic' => $us['user_profilepic']
                );

            }

            if (sizeof($users) > 0) {
                $response->code = OK;
            } else {
                $response->code = DATA_EMPTY;
            }

            $response->data = $users;
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
