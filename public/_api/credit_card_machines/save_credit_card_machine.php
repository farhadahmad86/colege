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

    $database->begin_trans();
    $rollback = false;

    $bankServiceChargesParentUID = BANK_SERVICE_CHARGES_PARENT_UID;

    if (isset($jwt)) {

        $userData = dieIfNotValidUser($jwt);
        $loginUser = $userData->user;
        $loginUserLevel = $loginUser->user_level;
        $loginUserRoleId = $loginUser->user_role_id;
        $loginUserId = $userData->loginUserId;
        $currentStatus = $userData->userStatus;

        $machine = array();

        if (file_get_contents("php://input")) {

            $dayEnd = getOpenDayEnd();
            $dayEndId = $dayEnd->id;
            $dayEndDate = $dayEnd->date;

            $machine = json_decode(file_get_contents("php://input"));

            $machineId = $database->escape_value($machine->id);
            $machineTitle = $database->escape_value($machine->title);
            $machinePercentage = $database->escape_value($machine->percentage);
            $machineMerchantId = $database->escape_value($machine->merchant_id);
            $machineRemarks = $database->escape_value($machine->remarks);
            $bankUID = $database->escape_value($machine->bank_uid);

            $alreadyExists = false;

            $checkQuery = "SELECT ccm_title FROM financials_credit_card_machine WHERE ccm_title = '$machineTitle' AND ccm_id != $machineId LIMIT 1;";
            $checkResult = $database->query($checkQuery);
            if ($checkResult) {
                $r = $database->fetch_assoc($checkResult);
                if (strtolower($r['ccm_title']) == strtolower($machineTitle)) {
                    $alreadyExists = true;
                }
            }

            if (!$alreadyExists) {
                if ($machineId == 0) {

                    $serviceChargesAccountUID = 0;

                    $uidQuery = "SELECT account_uid FROM financials_accounts WHERE account_parent_code = $bankServiceChargesParentUID order by account_uid desc limit 1;";
                    $uidResult = $database->query($uidQuery);
                    if ($uidResult) {
                        $uidData = $database->fetch_assoc($uidResult);
                        if (!empty($uidData['account_uid'])) {
                            $id = replaceFirst($bankServiceChargesParentUID . "", "", $uidData['account_uid'] . "");
                            $id = $id + 1;
                            $serviceChargesAccountUID = "$bankServiceChargesParentUID" . $id;
                        } else {
                            $serviceChargesAccountUID = "$bankServiceChargesParentUID" . "1";
                        }
                    } else {
                        $rollback = true;
                    }

                    $name = $machineTitle . " - Service Charges";

                    $accountQuery = "INSERT INTO financials_accounts 
                                (account_parent_code, account_name, account_print_name, account_cnic, account_address, account_area, account_proprietor, 
                                account_company_code, account_mobile_no, account_whatsapp, account_phone, account_email, account_gst, account_ntn, 
                                account_type, account_credit_limit, account_page_no, account_balance, account_sector_id, account_uid, account_region_id, account_group_id, 
                                account_createdby, account_day_end_id, account_day_end_date, account_link_uid, account_remarks, account_datetime) 
                              VALUE ($bankServiceChargesParentUID, '$name', '$name', '', '', 0, '', '', '', '', '', '', '', '', 0, 0, '', 0, 0, $serviceChargesAccountUID, 0, 1, 
                                     $loginUserId, $dayEndId, '$dayEndDate', 0, '$name', '$timeStamp');";

                    $accountResult = $database->query($accountQuery);

                    if (!$accountResult) {
                        $rollback = true;
                    }

                    $query = "INSERT INTO financials_credit_card_machine(ccm_title, ccm_percentage, ccm_merchant_id, ccm_remarks, ccm_created_by, ccm_bank_code, ccm_service_account_code, ccm_datetime) 
                            VALUES ('$machineTitle', $machinePercentage, $machineMerchantId, '$machineRemarks', $loginUserId, $bankUID, $serviceChargesAccountUID, '$timeStamp');";
                } else {
                    $query = "UPDATE financials_credit_card_machine 
                        SET ccm_title = '$machineTitle', ccm_remarks = '$machineRemarks', ccm_datetime = '$timeStamp', ccm_created_by = $loginUserId, 
                            ccm_percentage = $machinePercentage, ccm_merchant_id = $machineMerchantId
                        WHERE ccm_id = $machineId limit 1;";
                }

                $result = $database->query($query);

                if ($result && !$rollback) {

                    $response->code = OK;
                    $response->message = "Machine Saved.";

                } else {

                    $rollback = true;

                    $response->code = NOT_OK;
                    $response->message = "Unable to save Machine details.";
                }
            } else {
                $response->code = ALREADY_EXISTS;
                $response->message = "Already exists '$machineTitle' please save with different title.";
            }

        } else {
            $response->message = "Machine not found!";
        }

    } else {
        $response->message = "Auth token not found!";
    }

    if (!$rollback) {
        $database->commit();
    } else {
        $database->rollBack();
    }

} catch (Exception $e) {
    $response->message = $e->getMessage();
}

$response->success = OK;
echo json_encode($response);

if (isset($database)) {
    $database->close_connection();
}



