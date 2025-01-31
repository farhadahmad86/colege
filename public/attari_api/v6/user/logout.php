<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 18-Feb-19
 * Time: 12:17 PM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../_db/database.php");

$response = (object) array('success' => 0, 'code' => OK, 'data' => array(), 'message' => 'Something went wrong, Please check and try again.');

if (isset($_POST['user_id'])) {

    $userId = $database->escape_value($_POST['user_id']);

    $logoutQuery = "UPDATE user SET user_loged_in = 0, user_login_uid = '' WHERE user_id = $userId;";
    $result = $database->query($logoutQuery);
    if($result) {
        $response->message = " User logout and status update.";
    } else {
        $response->code = NOT_VALID;
        $response->message = " User not logout and status not update.";
    }
}

$response->success = 1;
echo json_encode($response);


if (isset($database)) {
    $database->close_connection();
}