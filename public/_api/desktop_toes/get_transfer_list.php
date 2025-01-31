<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 21-Apr-19
 * Time: 2:50 PM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../_db/database.php");
require_once("../functions/db_functions.php");
require_once("../functions/api_functions.php");

$userId = isset($_GET['user_id']) ? $database->escape_value($_GET['user_id']) : 0;


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

$transferList = array();

$dayEnd = getOpenDayEnd();
$dayEndId = $dayEnd->id;
$dayEndDate = $dayEnd->date;

$query = "SELECT ct_id as id, ct_send_by as sender, ct_receive_by as receiver, ct_amount as amount, ct_status as status, ct_reason as reason, ct_remarks as remarks, ct_send_datetime as send_datetime, ct_receive_datetime as receive_datetime 
            FROM financials_cash_transfer 
            WHERE (ct_send_by = $userId OR ct_receive_by = $userId) AND ct_dayend_id = $dayEndId
            ORDER BY ct_id;";

$result = $database->query($query);

if($result) {

    while ($trans = $database->fetch_array($result)) {
        $senderId = $trans['sender'];
        $receiverId = $trans['receiver'];

        $sender = getUser($senderId);
        $receiver = getUser($receiverId);

        $senderId = 0;
        $receiverId = 0;

        $senderName = '';
        $receiverName = '';

        if ($sender->found) {
            $senderId = $sender->properties->user_id;
            $senderName = $sender->properties->user_name;
        }

        if ($receiver->found) {
            $receiverId = $receiver->properties->user_id;
            $receiverName = $receiver->properties->user_name;
        }

        $sender = array('id' => $senderId, 'name' => $senderName);
        $receiver = array('id' => $receiverId, 'name' => $receiverName);

        $reason = $trans['reason'];
        if($reason == null || empty($reason)) $reason = "";
	
        $transferList[] = array('id' => $trans['id'],
                                'sender' => $sender,
                                'receiver' => $receiver,
                                'amount' => $trans['amount'],
                                'status' => $trans['status'],
                                'reason' => $reason,
                                'remarks' => $trans['remarks'],
								'send_datetime' => $trans['send_datetime'],
								'receive_datetime' => $trans['receive_datetime']);
    }
}

echo json_encode($transferList);


if (isset($database)) {
    $database->close_connection();
}


