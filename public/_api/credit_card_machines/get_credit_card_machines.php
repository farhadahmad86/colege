<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 17-Aug-19
 * Time: 12:30 PM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET');
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

        $machines = array();

        $q = isset($_GET['q']) ? $database->escape_value($_GET['q']) : '';
        $bankAccountUID = isset($_GET['bank_uid']) ? $database->escape_value($_GET['bank_uid']) : 0;
        $search = isset($_GET['search']) ? $database->escape_value($_GET['search']) : '';
        $createdBy = isset($_GET['cb']) ? $database->escape_value($_GET['cb']) : 0;

        $searchFilter = " WHERE ccm_id > 0 ";

        if ($bankAccountUID > 0) {
            $searchFilter .= " AND ccm_bank_code = $bankAccountUID ";
        }

        if ($q != '') {
            $searchFilter .= " AND ccm_title LIKE '%$q%' ";
        }

        if ($search != '') {
            $searchFilter .= " AND (ccm_title LIKE '%$search%' OR ccm_remarks LIKE '%$search%') ";
        }

        if ($createdBy > 0) {
            $searchFilter .= " AND ccm_created_by = $createdBy ";
        }

        $query = "SELECT ccm_id, ccm_title FROM financials_credit_card_machine $searchFilter order by ccm_title;";

        $result = $database->query($query);

        if ($result) {

            while ($data = $database->fetch_array($result)) {

                $machines[] = array('id' => (int)$data['ccm_id'], 'title' => $data['ccm_title']);

            }

            if (sizeof($machines) > 0) {
                $response->code = OK;
            } else {
                $response->code = DATA_EMPTY;
            }

            $response->data = $machines;
            $response->message = "Credit Card Machines List.";

        } else {
            $response->code = NOT_OK;
            $response->message = "Unable to get Credit Card Machines List.";
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



