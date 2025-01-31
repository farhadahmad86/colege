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

require_once '../libs/jwt-core.php';
require_once '../libs/php-jwt-master/src/BeforeValidException.php';
require_once '../libs/php-jwt-master/src/ExpiredException.php';
require_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
require_once '../libs/php-jwt-master/src/JWT.php';

use \Firebase\JWT\JWT;

require_once("../_db/database.php");

$response = (object)array('success' => 0, 'code' => 0, 'message' => '', 'data' => array());

$jwt = "";

if (isset($_SERVER[AUTH_HEADER])) {
    $jwt = $_SERVER[AUTH_HEADER];
} else {
    $response->message = "Auth token not found!";
    $response->success = OK;
    echo json_encode($response);
    if (isset($database)) {
        $database->close_connection();
    }
    die();
}

try {

    if (isset($jwt)) {

        $decoded = JWT::decode($jwt, $jwtEncryptKey, array('HS256'));

        $loginUserId = $decoded->data->id;

        $loginUser = Database::getUser($loginUserId);

        $currentStatus = $loginUser->status;

        if ($loginUser->found === true && $currentStatus != 'ENABLE') {
            $response->message = "Your account status is 'DISABLE' please contact to your admin!";
            $response->success = OK;
            echo json_encode($response);
            if (isset($database)) {
                $database->close_connection();
            }
            die();
        }

        $list = array();

        $q = isset($_GET['q']) ? $database->escape_value($_GET['q']) : '';
        $uid = isset($_GET['uid']) ? $database->escape_value($_GET['uid']) : 0;

        $searchFilter = " WHERE id > 0 ";

        if ($q != '') {
            $searchFilter .= " AND name LIKE '%$q%' ";
        }

        if ($uid > 1) {
            $searchFilter .= " AND id in (SELECT projects FROM users WHERE users.id = $uid) ";
        }

        $query = "SELECT id, name FROM project $searchFilter order by name;";

        $result = $database->query($query);

        if ($result) {

            while ($data = $database->fetch_array($result)) {

                $list[] = array('id' => $data['id'], 'title' => $data['name']);

            }

            if (sizeof($list) > 0) {
                $response->code = OK;
            } else {
                $response->code = DATA_EMPTY;
            }

            $response->data = $list;
            $response->message = "Project List.";

        } else {
            $response->code = NOT_OK;
            $response->message = "Unable to get Projects.";
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



