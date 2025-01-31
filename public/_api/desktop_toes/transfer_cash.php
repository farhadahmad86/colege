<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 22-Apr-19
 * Time: 3:36 PM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../_db/database.php");
require_once("../functions/db_functions.php");
require_once("../functions/api_functions.php");

$up = isset($_REQUEST['up']) ? $database->escape_value($_REQUEST['up']) : "";
$uid = isset($_REQUEST['user_id']) ? $database->escape_value($_REQUEST['user_id']) : "";

if($up==""||$uid==""){
    dieWithError("Upload API Authentication Failed!", null);
}else{
    $lgnUser = getUser($uid);

    if ($lgnUser->found == true) {
        $upwd = $lgnUser->properties->user_password;
        if(!password_verify($up,$upwd)){
            dieWithError("User Authentication Failed!", null);
        }
    }else{
        dieWithError("User Authentication Failed!", null);
    }
}

$responseToDesktop = array('success' => 0, 'code' => 0, 'message' => 'Something went wrong, Cannot save data! Please check and try again.');

if (isset($_GET['receiver_id']) && isset($_GET['remarks']) && isset($_GET['user_id']) && isset($_GET['amount'])) {

    $senderId = $database->escape_value($_GET['user_id']);
    $receiverId = $database->escape_value($_GET['receiver_id']);
    $amount = $database->escape_value($_GET['amount']);
    $remarks = $database->escape_value($_GET['remarks']);

    $dayEnd = getOpenDayEnd();
    $dayEndId = $dayEnd->id;
    $dayEndDate = $dayEnd->date;

    $query = "INSERT INTO financials_cash_transfer (ct_send_by, ct_amount, ct_receive_by, ct_dayend_id, ct_dayend_date, ct_status, ct_reason, ct_remarks) 
              VALUES ($senderId, $amount, $receiverId, $dayEndId, '$dayEndDate', 'PENDING', '', '$remarks');";

    $result = $database->query($query);

    if($result) {
        $responseToDesktop['code'] = 1;
        $responseToDesktop['message'] = "Cash transferred.";
    }

}
$responseToDesktop['success'] = 1;
echo json_encode($responseToDesktop);

if (isset($database)) {
    $database->close_connection();
}

