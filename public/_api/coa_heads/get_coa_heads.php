<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 04-Apr-20
 * Time: 9:42 AM
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

        $level = isset($_POST['level']) ? $database->escape_value($_POST['level']) : 0;
        $parentCode = isset($_POST['parent']) ? $database->escape_value($_POST['parent']) : 0;

        $searchQuery = "WHERE coa_id > 0";

        if ($level > 0) {
            $searchQuery .= " AND coa_level = $level";
        }

        if ($parentCode > 0) {
            $searchQuery .= " AND coa_parent = $parentCode";
        }

        if ($level == 0 && $parentCode == 0) {
            $searchQuery .= " AND coa_level = 1 ORDER by coa_id";
        } else {
            $searchQuery .= " ORDER by coa_head_name";
        }

        $query = "SELECT coa_code, coa_head_name FROM financials_coa_heads $searchQuery;";
        $result = $database->query($query);

        if ($result && $database->num_rows($result) > 0) {

            $dataArray = array();

            while ($head = $database->fetch_assoc($result)) {

                $dataArray[] = array(
                    'id' => (int)$head['coa_code'],
                    'title' => $head['coa_head_name']
                );

            }

            $response->data = $dataArray;
            $response->code = OK;
            $response->message = "Chart of Account Heads.";

        } else {
            $response->data = array();
            $response->code = DATA_EMPTY;
            $response->message = "No Head found!";
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



