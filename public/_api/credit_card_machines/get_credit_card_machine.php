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

        $machine = array();

        if (isset($_GET['mid'])) {

            $mid = $database->escape_value($_GET['mid']);

            $query = "SELECT ccm_id, ccm_title, user_id, user_name, ccm_remarks, ccm_datetime, ccm_bank_code, ccm_percentage, ccm_merchant_id, ccm_service_account_code 
                        FROM financials_credit_card_machine
                        JOIN financials_users on ccm_created_by = user_id
                        WHERE ccm_id = $mid limit 1;";

            $result = $database->query($query);

            if ($result) {

                $data = $database->fetch_assoc($result);

                $bankAccount = getAccount($data['ccm_bank_code']);
                $bankChargesAccount = getAccount($data['ccm_service_account_code']);

                $machine = array(
                    'id' => $data['ccm_id'],
                    'title' => $data['ccm_title'],
                    'extraOne' => $data['ccm_percentage'],
                    'extraTwo' => $data['ccm_merchant_id'],
                    'remarks' => $data['ccm_remarks'],
                    'itemOne' => array('id' => $bankAccount->account_uid, 'title' => $bankAccount->account_name),
                    'itemTwo' => array('id' => $bankChargesAccount->account_uid, 'title' => $bankChargesAccount->account_name),
                    'user_id' => $data['user_id'],
                    'user_name' => $data['user_name'],
                    'date_time' => $data['ccm_datetime']
                );

                $response->data = $machine;
                $response->code = OK;
                $response->message = "Credit Card Machine Details.";

            } else {
                $response->code = NOT_OK;
                $response->message = "Unable to get Credit Card Machine details.";
            }

        } else {
            $response->message = "Credit Card Machine id not found!";
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



