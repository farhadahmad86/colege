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
        $user = $userData->user;
        $loginUserId = $userData->loginUserId;
        $currentStatus = $userData->userStatus;

        $query = "SELECT 
                    ci_id as id,
                    ci_name as companyName,
                    ci_email as email,
                    ci_mobile_numer as mobileNumber,
                    ci_whatsapp_number as whatsappNumber,
                    ci_ptcl_number as phoneNumber,
                    ci_fax_number as faxNumber,
                    ci_address as address,
                    ci_facebook as facebook,
                    ci_twitter as twitter,
                    ci_youtube as youtube,
                    ci_instagram as instagram,
                    ci_google as google,
                    ci_logo as imageUrl
            FROM financials_company_info WHERE ci_id = 1;";

        $result = $database->query($query);

        if ($result) {

            $data = $database->fetch_assoc($result);

            $companyInfo = array(
                'id' => $data['id'],
                'name' => $data['companyName'],
                'email' => $data['email'],
                'mobile' => $data['mobileNumber'],
                'whatsapp' => $data['whatsappNumber'],
                'phone' => $data['phoneNumber'],
                'fax' => $data['faxNumber'],
                'address' => $data['address'],
                'facebook' => $data['facebook'],
                'twitter' => $data['twitter'],
                'youtube' => $data['youtube'],
                'instagram' => $data['instagram'],
                'google' => $data['google'],
                'image' => $data['imageUrl']
            );

            $response->data = $companyInfo;
            $response->code = OK;
            $response->message = "Company Info.";

        } else {
            $response->code = NOT_OK;
            $response->message = "Unable to get Company Info.";
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



