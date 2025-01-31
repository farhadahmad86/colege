<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 01-Aug-19
 * Time: 9:39 AM
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
require_once("../functions/functions.php");

$response = (object)array('success' => 0, 'code' => 0, 'message' => '', 'data' => array());

try {

    if (isset($jwt)) {

        $userData = dieIfNotValidUser($jwt);
        $user = $userData->user;
        $loginUserId = $userData->loginUserId;
        $currentStatus = $userData->userStatus;

        if (isset($_POST['img'])) {

            $imageDir = USERS_PATH;

            $folderName = $user->user_folder;

            $folderPath = $imageDir . $folderName;

            if (!empty($folderName)) {
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0777, true);
                }
            } else {
                $folderName = uniqueHashCode();
                $folderPath = $imageDir . $folderName;
                mkdir($folderPath, 0777, true);
            }

            $profileImageName = "profile_image.png";
            $profileImagePath = $folderPath . "/" . $profileImageName;

            $image = base64_decode($_POST['img']);

            file_put_contents($profileImagePath, $image);

            $completeImagePath = USERS_IMAGE_PATH;
            $completeImagePath .= $folderName."/".$profileImageName;

            $usernameCheckQuery = "UPDATE financials_users SET user_profilepic = '$completeImagePath', user_folder = '$folderName' WHERE user_id = $loginUserId LIMIT 1";

            $resultExists = $database->query($usernameCheckQuery);

            if ($resultExists) {

                $response->data = $completeImagePath;
                $response->code = OK;
                $response->message = "User profile image updated.";

            } else {
                $response->code = NOT_OK;
                $response->message = "Unable to update profile image!";
            }

        } else {
            $response->message = "Image not found!";
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


