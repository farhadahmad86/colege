<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 06-Apr-20
 * Time: 9:43 AM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: false");
header('Access-Control-Allow-Methods: POST');
//header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
header('Access-Control-Max-Age: 0');
header("Cache-Control: no-cache");
header("Pragma: no-cache");
header('content-type: application/json; charset=UTF-8');

require_once("../functions/api_functions.php");

dieIfNotGet();
$jwt = dieIfNotAuth();


require_once("../_db/database.php");
require_once("../functions/db_functions.php");

$response = (object)array('success' => 0, 'code' => 0, 'message' => '', 'data' => array());

$superAdminId = SUPER_ADMIN_ID;

try {

    if (isset($jwt)) {

        $userData = dieIfNotValidUser($jwt);
        $user = $userData->user;
        $loginUserId = $userData->loginUserId;
        $currentStatus = $userData->userStatus;

        $userId = isset($_GET['id']) ? $database->escape_value($_GET['id']) : 0;

        if ($userId == 0) {
            dieWithError("Parameters not found!", $database);
        }

        $query = "SELECT 
                        user_id as id, 
                        user_employee_code as employeeCode,
                        user_profilepic as image,
                        user_name as name,
                        user_father_name as fatherName,
                        user_username as username,
                        user_email as email,
                        user_designation as designation,
                        user_mobile as mobile,
                        user_emergency_contact as emergencyContact,
                        user_cnic as cnic,
                        user_login_status as status,
                        user_desktop_status as desktop_status,
                        user_send_sync_report as syncReport,
                        user_send_day_end_report as dayEndReport,
                        user_send_month_end_report as monthEndReport,
                        user_account_reporting_group_ids as accountReportingGroupIds,
                        user_product_reporting_group_ids as productReportingGroupIds,
                        user_modular_group_id as modularGroupIds,
                        user_level as level,
                        user_role_id as role,
                        user_blood_group as bloodGroup,
                        user_salary_person as salaryPerson,
                        user_have_credentials as haveCredentials,
                        user_city as city,
                        user_nationality as country,
                        user_marital_status as married,
                        user_religion as muslim,
                        user_family_code as familyCode,
                        user_commission_per as commission,
                        user_target_amount as targetAmount,
                        user_address as address,
                        user_address_2 as addressLine2
                    FROM financials_users 
                    WHERE user_id = $userId LIMIT 1;";

        $result = $database->query($query);

        $data = array();

        if ($result && $database->num_rows($result) == 1) {

            $data = $database->fetch_assoc($result);

            $data['salaryPerson'] = (int)$data['salaryPerson'];
            $data['haveCredentials'] = (int)$data['haveCredentials'];

            if ($data['haveCredentials'] != 1) {
                $data['username'] = "";
                $data['email'] = "";
            }

            if ($userId == $superAdminId) {

                $arg = array();
                $prg = array();

                $arg[] = array("id" => 0, "title" => "N/A");
                $prg[] = array("id" => 0, "title" => "N/A");

                $data['accountReportingGroups'] = $arg;
                $data['productReportingGroups'] = $prg;
                $data['modularGroup'] = array("id" => 0, "title" => "N/A");
                $data['level'] = array("id" => 0, "title" => "N/A");
                $data['role'] = array("id" => 0, "title" => "N/A");

            } else {

                $accountReportingGroupIds = $data['accountReportingGroupIds'];
                $productReportingGroupIds = $data['productReportingGroupIds'];
                $modularGroupId = $data['modularGroupIds'];

                $accountReportingGroups = array();
                $productReportingGroups = array();

                $arpQuery = "select ag_id, ag_title from financials_account_group where ag_id in ($accountReportingGroupIds);";
                $arpResult = $database->query($arpQuery);
                if ($arpResult) {
                    while ($arp = $database->fetch_array($arpResult)) {
                        $accountReportingGroups[] = array('id' => (int)$arp['ag_id'], 'title' => $arp['ag_title']);
                    }
                }

                $prpQuery = "select pg_id, pg_title from financials_product_group where pg_id in ($productReportingGroupIds);";
                $prpResult = $database->query($prpQuery);
                if ($prpResult) {
                    while ($prp = $database->fetch_array($prpResult)) {
                        $productReportingGroups[] = array('id' => (int)$prp['pg_id'], 'title' => $prp['pg_title']);
                    }
                }

                $mdGroup = getModularGroup($modularGroupId);
                if ($mdGroup->found == true) {
                    $mdGroup = array("id" => (int)$modularGroupId, "title" => $mdGroup->properties->mg_title);
                } else {
                    $mdGroup = null;
                }

                $data['accountReportingGroups'] = $accountReportingGroups;
                $data['productReportingGroups'] = $productReportingGroups;
                $data['modularGroup'] = $mdGroup;

                $levelId = $data['level'];
                $roleId = $data['role'];

                $roleName = "Unknown";
                $levelName = "Unknown";

                switch ($roleId) {
                    case NONE:
                        $roleName = "Other Employee";
                        break;
                    case CASHIER:
                        $roleName = "Cashier";
                        break;
                    case TELLER:
                        $roleName = "Teller";
                        break;
                    case SALE_PERSON:
                        $roleName = "Sale Person";
                        break;
                    case PURCHASER:
                        $roleName = "Purchaser";
                        break;
                }

                switch ($levelId) {
                    case ADMIN_LEVEL:
                        $levelName = "Admin";
                        break;
                    case MANAGER_LEVEL:
                        $levelName = "Manager";
                        break;
                    case OPERATOR_LEVEL:
                        $levelName = "Operator";
                        break;
                }

                $data['role'] = array("id" => (int)$roleId, "title" => $roleName);
                $data['level'] = array("id" => (int)$levelId, "title" => $levelName);

            }

            $cityId = $data['city'] != "" && $data['city'] > 0 ? $data['city'] : 0;
            if ($cityId > 0) {
                $city = getCity($cityId);
                if ($city->found == true) {
                    $data['city'] = array("id" => (int)$cityId, "title" => $city->properties->city_name);
                } else {
                    $data['city'] = array("id" => (int)$cityId, "title" => "Unknown");
                }
            } else {
                $data['city'] = array("id" => (int)$cityId, "title" => "Unknown");
            }

//            $countryId = $data['country'] != "" && $data['country'] > 0 ? $data['country'] : 0;
//            if ($countryId > 0) {
//                $city = getCountry($countryId);
//                if ($city->found == true) {
//                    $data['country'] = array("id" => (int)$countryId, "title" => $city->properties->c_name);
//                } else {
//                    $data['country'] = array("id" => (int)$countryId, "title" => "Unknown");
//                }
//            } else {
//                $data['country'] = array("id" => (int)$countryId, "title" => "Unknown");
//            }

            $salaryInfoQuery = "SELECT
                                    si_id as id, 
                                    si_basic_salary as basicSalary, 
                                    si_expense_salary_account_uid as expAccountUID, 
                                    si_basic_salary_period as basicSalaryPer, 
                                    si_working_hours_per_day as workingHoursPerDays, 
                                    si_off_days as offDays
                                FROM financials_salary_info 
                                WHERE si_user_id = $userId LIMIT 1;";

            $salaryInfoResult = $database->query($salaryInfoQuery);

            $salaryInfoData = array();
            $salaryADList = array();
//            $data['salaryPerson'] = (int)0;

            if ($salaryInfoResult && $database->num_rows($salaryInfoResult) == 1) {

//                $data['salaryPerson'] = (int)1;

                $salaryInfoData = $database->fetch_assoc($salaryInfoResult);

                $salaryInfoId = $salaryInfoData['id'];

                $basicSalaryPer = (int)$salaryInfoData['basicSalaryPer'];
                $offDays = explode(',', $salaryInfoData['offDays']);

                switch ($basicSalaryPer) {
                    case PER_HOUR:
                        $basicSalaryPer = array("id" => (int)$basicSalaryPer, "title" => "Hour");
                        break;
                    case PER_DAY:
                        $basicSalaryPer = array("id" => (int)$basicSalaryPer, "title" => "Day");
                        break;
                    case PER_MONTH:
                        $basicSalaryPer = array("id" => (int)$basicSalaryPer, "title" => "Month");
                        break;
                }

                $salaryParentAccountUID = substr($salaryInfoData['expAccountUID'], 0, 5);

                $salAccParentsName = getHead($salaryParentAccountUID)['name'];

                $salaryParentAccount = array('id' => (int)$salaryParentAccountUID, 'title' => $salAccParentsName);

                $salaryInfoData['salaryParentAccount'] = $salaryParentAccount;
                $salaryInfoData['basicSalaryPer'] = $basicSalaryPer;

                $offDaysList = array();

                foreach ($offDays as $od) {

                    if ($od > 0 && $od < 8) {

                        $dayName = "";

                        switch ($od) {
                            case 1:
                                $dayName = "Monday";
                                break;
                            case 2:
                                $dayName = "Tuesday";
                                break;
                            case 3:
                                $dayName = "Wednesday";
                                break;
                            case 4:
                                $dayName = "Thursday";
                                break;
                            case 5:
                                $dayName = "Friday";
                                break;
                            case 6:
                                $dayName = "Saturday";
                                break;
                            case 7:
                                $dayName = "Sunday";
                                break;
                        }

                        $offDaysList[] = array("id" => (int)$od, "title" => $dayName);

                    }

                }

                $salaryInfoData['offDays'] = $offDaysList;


                // allowances, deductions
                $salaryInfoItemsQuery = "SELECT sadi_account_uid, sadi_account_name, sadi_allowance_deduction, sadi_amount, sadi_remarks
                                FROM financials_salary_ad_items WHERE sadi_salary_info_id = $salaryInfoId AND sadi_user_id = $userId;";

                $salaryInfoItemsResult = $database->query($salaryInfoItemsQuery);

                if ($salaryInfoItemsResult && $database->num_rows($salaryInfoItemsResult) > 0) {

                    while ($ad = $database->fetch_assoc($salaryInfoItemsResult)) {

                        $salaryADList[] = array(
                            "type" => $ad['sadi_allowance_deduction'],
                            "uid" => (int)$ad['sadi_account_uid'],
                            "name" => $ad['sadi_account_name'],
                            "remarks" => $ad['sadi_remarks'],
                            "amount" => (int)$ad['sadi_amount']
                        );

                    }

                }

            }

            $data['salary'] = array("info" => $salaryInfoData, "all_ded" => $salaryADList);

            $response->data = $data;
            $response->code = OK;
            $response->message = "User details";

        } else {

            $response->data = array();
            $response->code = DATA_EMPTY;
            $response->message = "User not found!";

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



