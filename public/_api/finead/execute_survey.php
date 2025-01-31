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

date_default_timezone_set("Asia/Karachi");
$dateFolderName = date("d_m_Y");
$timeFileName = date("H_i_s");
$timeStamp = date(TIME_STAMP_FORMAT);

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

        $rollback = false;
        $database->begin_trans();

        $COMPLETE_SURVEY_IMAGES_DIRECTORY_PATH = "http://finead.digitalmunshi.com/public/api/survey/images/";
        $SURVEY_IMAGES_DIRECTORY_PATH = "./images/";

        if (file_get_contents("php://input")) {

            $survey = json_decode(file_get_contents("php://input"));

            $surveyId = $database->escape_value($survey->survey_id);

            $surveyImages = $survey->items;
            $imagesIds = '';

            foreach ($surveyImages as $si) {

                $base64Image = $database->escape_value($si->image);
                $beforeImageId = $database->escape_value($si->beforeImageId);

                $fileName = $timeFileName . "_" . substr((string)microtime(), 2, 8) . ".png";
                $folder = $SURVEY_IMAGES_DIRECTORY_PATH . $dateFolderName;
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }

                $surveyImagePath = $folder . "/" . $fileName;
                $movableImage = base64_decode($base64Image);
                file_put_contents($surveyImagePath, $movableImage);

                $completeSurveyImagePath = $COMPLETE_SURVEY_IMAGES_DIRECTORY_PATH;
                $completeSurveyImagePath .= $dateFolderName . "/" . $fileName;

                $insertImageQuery = "INSERT INTO images_after(complete_url, file_name, folder_name, survey_id, created_at, before_image_id) 
                                        VALUES ('$completeSurveyImagePath', '$fileName', '$dateFolderName', $surveyId, '$timeStamp', $beforeImageId);";

                $insertImageResult = $database->query($insertImageQuery);

                if ($insertImageResult) {
                    $imgId = $database->inserted_id();
                    $imagesIds .= $imgId . ',';
                } else {
                    $rollback = true;
                    break;
                }

            }

            if ($imagesIds != '') {
                $imagesIds = substr($imagesIds, 0, strlen($imagesIds) - 1);
            }

            $updateSurveyQuery = "UPDATE survey SET 
                                        images_after = '$imagesIds', 
                                        updated_at = '$timeStamp', 
                                        updated_by = $loginUserId,
                                        approved = 'YES',
                                        execution = 'YES'
                                    WHERE id = $surveyId LIMIT 1;";
            $updateSurveyResult = $database->query($updateSurveyQuery);
            if (!$updateSurveyResult || $database->affected_rows($updateSurveyResult) != 1) {
                $rollback = true;
            }

            if ($rollback) {
                $database->rollBack();
                $response->code = NOT_OK;
                $response->message = "Something went wrong, survey data not saved!";
            } else {
                $database->commit();
                $response->code = OK;
                $response->message = "Survey saved.";
            }

        } else {
            $response->message = "Survey not found!";
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



