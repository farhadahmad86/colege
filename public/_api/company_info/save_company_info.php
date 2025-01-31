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

    if (isset($jwt)) {

        $userData = dieIfNotValidUser($jwt);
        $user = $userData->user;
        $loginUserId = $userData->loginUserId;
        $currentStatus = $userData->userStatus;

        $companyInfo = array();

        $content = file_get_contents("php://input");

        if ($content) {

            $dayEnd = getOpenDayEnd();
            $dayEndId = $dayEnd->id;
            $dayEndDate = $dayEnd->date;

            $companyInfo = json_decode($content);

//            $companyId = $database->escape_value($companyInfo->id);
            $companyName = $database->escape_value($companyInfo->name);
            $email = $database->escape_value($companyInfo->email);
            $mobileNumber = $database->escape_value($companyInfo->mobile);
            $whatsappNumber = $database->escape_value($companyInfo->whatsapp);
            $phoneNumber = $database->escape_value($companyInfo->phone);
            $faxNumber = $database->escape_value($companyInfo->fax);
            $address = $database->escape_value($companyInfo->address);
            $image = $database->escape_value($companyInfo->image);
            $facebookLink = $database->escape_value($companyInfo->fb);
            $twitterLink = $database->escape_value($companyInfo->tw);
            $youtubeLink = $database->escape_value($companyInfo->yt);
            $instagramLink = $database->escape_value($companyInfo->inst);
            $googleLink = $database->escape_value($companyInfo->google);

            $imageQuery = "";

            $completeImagePath = DEFAULT_LOGO_IMAGE_PATH;
            if ($image != "0") {

                $folderName = uniqueHashCode();
                $imageDir = LOGO_PATH;

                $folderPath = $imageDir . $folderName;
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0777, true);
                }

                $profileImageName = "logo.png";
                $profileImagePath = $folderPath . "/" . $profileImageName;

                $movableImage = base64_decode($image);

                file_put_contents($profileImagePath, $movableImage);

                $completeImagePath = LOGO_IMAGE_PATH;
                $completeImagePath .= $folderName."/".$profileImageName;

                $imageQuery = ", ci_logo = '$completeImagePath' ";
            }


            $query = "UPDATE financials_company_info 
                    set 
                        ci_name = '$companyName',
                        ci_email = '$email',
                        ci_mobile_numer = '$mobileNumber',
                        ci_whatsapp_number = '$whatsappNumber',
                        ci_ptcl_number = '$phoneNumber',
                        ci_fax_number = '$faxNumber',
                        ci_address = '$address',
                        ci_facebook = '$facebookLink',
                        ci_twitter = '$twitterLink',
                        ci_youtube = '$youtubeLink',
                        ci_google = '$googleLink',
                        ci_instagram = '$instagramLink'
                        $imageQuery
                    where ci_id = 1;";

                $result = $database->query($query);

                if ($result) {

                    $response->code = OK;
                    $response->message = "Company Info Saved";

                } else {
                    $response->code = NOT_OK;
                    $response->message = "Unable to save Company nfo.";
                }

        } else {
            $response->message = "Company Info not found!";
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



