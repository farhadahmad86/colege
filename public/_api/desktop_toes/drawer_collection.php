<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 04-May-20
 * Time: 2:31 PM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../_db/database.php");
require_once("../functions/db_functions.php");

require_once("../functions/api_functions.php");

$up = isset($_REQUEST['up']) ? $database->escape_value($_REQUEST['up']) : "";
$uid = isset($_REQUEST['uid']) ? $database->escape_value($_REQUEST['uid']) : "";

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

$userId = isset($_GET['uid']) ? $database->escape_value($_GET['uid']) : 0;

$dayEnd = getOpenDayEnd();
$dayEndId = $dayEnd->id;
$dayEndDate = $dayEnd->date;

$query = "select 
(select sum(ct_amount) from financials_cash_transfer where ct_send_by = $userId and ct_dayend_id = $dayEndId and ct_status = 'RECEIVED') as send,
(select sum(ct_amount) from financials_cash_transfer where ct_receive_by = $userId and ct_dayend_id = $dayEndId and ct_status = 'RECEIVED') as received;";

$result = $database->query($query);

$sendOrReceivedAmount = array();

if ($result) {
    $sendOrReceivedAmount = $database->fetch_assoc($result);
}

echo json_encode($sendOrReceivedAmount);

if (isset($database)) {
    $database->close_connection();
}
