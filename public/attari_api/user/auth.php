<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 12-Feb-19
 * Time: 5:57 PM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../_db/database.php");

$response = (object) array('success' => 0, 'code' => OK, 'data' => (object) array(), 'message' => 'Something went wrong, Please check and try again.');

$passwordMatch = 0;

$user = null;

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['uid'])) {

    $username = $database->escape_value($_POST['username']);
    $password = $database->escape_value($_POST['password']);
    $uid = $database->escape_value($_POST['uid']);

    $q = "SELECT 
            user_id as id,
            user_password as password, 
            user_loged_in as loged_in, 
            user_status as status, 
            user_login_uid as uid
          FROM user WHERE (user_username = '$username'  OR user_email = '$username') LIMIT 1;";

    $r = $database->query($q);

    if($r) {
        $u = $database->fetch_assoc($r);

        $user = array('id' => $u['id'], 'UID' => $u['uid'], 'login' => $u['loged_in'], 'status' => $u['status']);

        $pass = $u['password'];

        $passwordMatch = password_verify($password, $pass);
        if(empty($passwordMatch)) {
            $passwordMatch = 0;
        }
    }

    if($passwordMatch == 1) {
        $response->message = "User Authenticated.";

        $userId = $user['id'];

        if(empty($user['UID'])) {
            $loginQuery = "UPDATE user SET user_loged_in = 1, user_login_uid = '$uid' WHERE user_id = $userId;";
            $result = $database->query($loginQuery);
            if($result) {
                $response->message .= " User login status update.";
            } else {
                $response->message .= " User login status not update.";
            }
        }

        if($user['status'] == 'LOGIN_AGAIN') {
            $loginQuery = "UPDATE user SET user_status = 'OK' WHERE user_id = $userId;";
            $result = $database->query($loginQuery);
            if($result) {
                $response->message .= " User login status update.";
            } else {
                $response->message .= " User login status not update.";
            }
        }

        $response->data = $user;

        if($user['UID'] != $uid && $user['login'] == 1) {
            $response->code = ALREADY_LOGED_IN;
            $response->message = "User already log in.";
//            $response->data = $user;
        }

    } else {
        $response->code = NOT_VALID;
        $response->message = "Username/Password not matched.";
    }

}
$response->success = 1;
echo json_encode($response);


if (isset($database)) {
    $database->close_connection();
}