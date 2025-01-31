<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 28-Jul-19
 * Time: 5:27 PM
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

        $groupId = 0;
        $firstLevelCodes = "";
        $secondLevelCodes = "";
        $thirdLevelCodes = "";

        $userLevel = $user->user_level;

        if ($userLevel != SUPER_ADMIN_LEVEL) {
            $groupId = $user->user_modular_group_id;

            if ($groupId != null && $groupId > 0) {
                $modularGroup = getModularGroup($groupId);
                if ($modularGroup->found === true) {
                    $firstLevelCodes = $modularGroup->properties->mg_first_level_config;
                    $secondLevelCodes = $modularGroup->properties->mg_second_level_config;
                    $thirdLevelCodes = $modularGroup->properties->mg_config;
                }
            } else {
                $response->message = "You dont have any Modular Group assigned! Please contact to your admin!";
                $response->success = OK;
                echo json_encode($response);
                if (isset($database)) {
                    $database->close_connection();
                }
                die();
            }

        }

        $firstLevelConfigQueryPram = "";
        $secondLevelConfigQueryPram = "";
        $thirdLevelConfigQueryPram = "";

        if ($firstLevelCodes != "") {
            $firstLevelConfigQueryPram = "and mcd_code in ($firstLevelCodes)";
        }

        if ($secondLevelCodes != "") {
            $secondLevelConfigQueryPram = "and mcd_code in ($secondLevelCodes)";
        }

        if ($thirdLevelCodes != "") {
            $thirdLevelConfigQueryPram = "and mcd_code in ($thirdLevelCodes)";
        }

        $configMenu = "and mcd_after_config = 1 ";

        $systemConfigQuery = "SELECT sc_all_done FROM financials_system_config WHERE sc_id = 1;";
        $systemConfigResult = $database->query($systemConfigQuery);
        if ($systemConfigResult && $database->num_rows($systemConfigResult) == 1) {

            $config = $database->fetch_assoc($systemConfigResult);

            $allDone = $config['sc_all_done'];

            if ($allDone == 0) {
                $configMenu = "and mcd_before_config = 1 ";
            }
        }

        $menuArray = array();

        $query = "select mcd_id as id, mcd_code as code, mcd_title as title, mcd_parent_code as parentCode, mcd_level as level 
                    from financials_modular_config_defination 
                    where mcd_level = 1 $configMenu $firstLevelConfigQueryPram ORDER BY mcd_code;";

        $result = $database->query($query);

        if ($result) {

            while ($raw = $database->fetch_array($result)) {

                $code = $raw['code'];

                $query2 = "select mcd_id as id, mcd_code as code, mcd_title as title, mcd_parent_code as parentCode, mcd_level as level 
                            from financials_modular_config_defination 
                            where mcd_level = 2 $configMenu $secondLevelConfigQueryPram and mcd_parent_code = $code ORDER BY mcd_code;";

                $result2 = $database->query($query2);

                if ($result2) {

                    $subMenuArray = array();

                    while ($raw2 = $database->fetch_array($result2)) {

                        $code2 = $raw2['code'];

                        $query3 = "select mcd_id as id, mcd_code as code, mcd_title as title, mcd_parent_code as parentCode, mcd_level as level 
                                    from financials_modular_config_defination 
                                    where mcd_level = 3 $configMenu $thirdLevelConfigQueryPram and mcd_parent_code = $code2 ORDER BY mcd_code;";

                        $result3 = $database->query($query3);

                        if ($result3) {

                            $menuItemArray = array();

                            while ($raw3 = $database->fetch_array($result3)) {

                                $menuItemArray[] = array(
                                    'code' => $raw3['code'],
                                    'title' => $raw3['title'],
                                    'level' => $raw3['level']
                                );

                            }

                            $subMenuArray[] = array(
                                'code' => $raw2['code'],
                                'title' => $raw2['title'],
                                'level' => $raw2['level'],
                                'childList' => $menuItemArray
                            );

                        }

                    }

                    $menuArray[] = array(
                        'code' => $raw['code'],
                        'title' => $raw['title'],
                        'level' => $raw['level'],
                        'childList' => $subMenuArray
                    );

                }

            }

        }

        $response->data = $menuArray;
        $response->code = OK;
        $response->message = "Modules list.";

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
