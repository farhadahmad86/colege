<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 26-Apr-20
 * Time: 12:04 PM
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

dieIfNotPost();
$jwt = dieIfNotAuth();


require_once("../_db/database.php");
require_once("../functions/db_functions.php");
require_once("../functions/functions.php");
require_once("../mailer/send_mail.php");

$response = (object)array('success' => 0, 'code' => 0, 'message' => '', 'data' => array());

$teller = TELLER;
$purchaser = PURCHASER;

$rollBack = false;
$errorMessages = "";
$database->begin_trans();

$ip = getClientIp();

try {

    if (isset($jwt)) {

        $userData = dieIfNotValidUser($jwt);
        $loginUser = $userData->user;
        $loginUserId = $userData->loginUserId;
        $currentStatus = $userData->userStatus;

        $content = file_get_contents("php://input");

        if ($content) {

            $dayEnd = getOpenDayEnd();
            $dayEndId = $dayEnd->id;
            $dayEndDate = $dayEnd->date;

            $user = json_decode($content);

            $userPersonalInfo = $user->personal_info;

            $isSalaryPerson = $user->salary_person;
            $salaryInfo = $user->salary_info;

            $haveCredentials = $user->have_credentials;
            $credentialsInfo = $user->credentials_info;

            $userId = $database->escape_value($userPersonalInfo->id);
            $enableAll = $database->escape_value($userPersonalInfo->enable);
            $image = $database->escape_value($userPersonalInfo->image);
            $name = $database->escape_value($userPersonalInfo->name);
            $fatherName = $database->escape_value($userPersonalInfo->father_name);
            $designation = $database->escape_value($userPersonalInfo->designation);
            $mobile = $database->escape_value($userPersonalInfo->mobile);
            $emergency = $database->escape_value($userPersonalInfo->emergency);
            $cnic = $database->escape_value($userPersonalInfo->cnic);
            $level = $database->escape_value($userPersonalInfo->level);
            $role = $database->escape_value($userPersonalInfo->role);
            $bloodGroup = $database->escape_value($userPersonalInfo->blood_group);
            $cityId = $database->escape_value($userPersonalInfo->city_id);
            $countryId = PAKISTAN_ID; // $database->escape_value($userPersonalInfo->country_id);
            $isMarried = $database->escape_value($userPersonalInfo->is_married);
            $isMuslim = $database->escape_value($userPersonalInfo->is_muslim);
            $familyCode = $database->escape_value($userPersonalInfo->family_code);
            $doj = $database->escape_value($userPersonalInfo->joining_date);
            $commission = $database->escape_value($userPersonalInfo->commission);
            $targetAmount = $database->escape_value($userPersonalInfo->target_amount);
            $address = $database->escape_value($userPersonalInfo->address);
            $addressTwo = $database->escape_value($userPersonalInfo->addressTwo);

            if ($doj == "" || $doj == "NULL") {
                $doj = "NULL";
            } else {
                $doj = "'$doj'";
            }

            if ($haveCredentials == true) {
                $username = $database->escape_value($credentialsInfo->username);
                $email = $database->escape_value($credentialsInfo->email);
                $reportingGroupIds = $database->escape_value($credentialsInfo->reporting_group_ids);
                $productGroupIds = $database->escape_value($credentialsInfo->product_group_ids);
                $modularGroupId = $database->escape_value($credentialsInfo->modular_group_id);
            } else {
                $username = '';
                $email = '';
                $reportingGroupIds = '0';
                $productGroupIds = '0';
                $modularGroupId = '0';
            }

            $employeeCode = "";

            if ($userId == 0) {
                $remoteDevice = $database->escape_value($userPersonalInfo->device_info);
            } else {
                $remoteDevice = "";
            }

            $isMarried = $isMarried == true ? 1 : 2;
            $isMuslim = $isMuslim == true ? 1 : 2;

            $usernameAlreadyExists = false;
            $emailAlreadyExists = false;

            if ($haveCredentials == true) {
                $checkQuery = "SELECT user_username, user_email FROM financials_users
                            WHERE (user_username = '$username' OR user_email = '$email') AND user_id != $userId LIMIT 1;";
                $checkResult = $database->query($checkQuery);
                if ($checkResult) {
                    $r = $database->fetch_assoc($checkResult);
                    if (strtolower($r['user_email']) == strtolower($email)) {
                        $emailAlreadyExists = true;
                    }

                    if (strtolower($r['user_username']) == strtolower($username)) {
                        $usernameAlreadyExists = true;
                    }

                    if ($emailAlreadyExists || $usernameAlreadyExists) {
                        $response->code = ALREADY_EXISTS;

                        if ($emailAlreadyExists) {
                            $response->message = "Already exists '$email' please save with different Email address.";
                        } elseif ($usernameAlreadyExists) {
                            $response->message = "Already exists '$username' please save with different Username.";
                        }


                        $response->success = OK;
                        echo json_encode($response);

                        if (isset($database)) {
                            $database->close_connection();
                        }
                        die();
                    }
                }
            }

            $password = "";
            if ($userId == 0 && $haveCredentials == true) {
                $loginPassword = randomPassword();
                $password = makHash($loginPassword);
            }

            $folderName = "";
            $completeImagePath = "";
            $imageDir = USERS_PATH;
            $sameImage = false;

            if ($userId == 0 && $image == "0") {

                $folderName = uniqueHashCode();
                $completeImagePath = DEFAULT_USERS_IMAGE;

            } else if ($userId == 0 && $image != "0") {

                $folderName = uniqueHashCode();
                $folderPath = $imageDir . $folderName;
                mkdir($folderPath, 0777, true);

                $profileImageName = "profile_image.png";
                $profileImagePath = $folderPath . "/" . $profileImageName;

                $movableImage = base64_decode($image);

                file_put_contents($profileImagePath, $movableImage);

                $completeImagePath = USERS_IMAGE_PATH;
                $completeImagePath .= $folderName."/".$profileImageName;

            } else if ($userId != 0 && $image == "0") {

                $sameImage = true;

            } else if ($userId != 0 && $image != "0") {

                $folderName = getUser($userId)->user_folder;
                $folderPath = $imageDir . $folderName;

                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0777, true);
                }

                $profileImageName = "profile_image.png";
                $profileImagePath = $folderPath . "/" . $profileImageName;

                $movableImage = base64_decode($image);

                file_put_contents($profileImagePath, $movableImage);

                $completeImagePath = USERS_IMAGE_PATH;
                $completeImagePath .= $folderName."/".$profileImageName;

            }

            if ($userId == 0) {

                $tellerCashAccountUID = 0;
                $tellerWICAccountUID = 0;
                $purchaserCashAccountUID = 0;
                $purchaserWICAccountUID = 0;

                $tellerPurchaserCashAccountUID = 0;

                if ($role == $teller) {
                    $cashParentAccountUID = CASH_PARENT_UID;
                    $wicParentAccountUID = WALK_IN_CUSTOMER_PARENT_UID;

                    $cashAccountName = $name . " - Cash";
                    $wicAccountName = $name . " - WIC";

                    $tellerCashAccountUID = createAccount($cashParentAccountUID, $cashAccountName, $loginUserId, $dbTimeStamp, $dayEndId, $dayEndDate, 1, $ip, $remoteDevice);
                    $tellerWICAccountUID = createAccount($wicParentAccountUID, $wicAccountName, $loginUserId, $dbTimeStamp, $dayEndId, $dayEndDate, 1, $ip, $remoteDevice);

                    $tellerPurchaserCashAccountUID = $tellerCashAccountUID;

                    if ($tellerCashAccountUID == 0 || $tellerWICAccountUID == 0) {
                        $rollBack = true;
                        $errorMessages .= "Unable to create teller cash/wic accounts! ";
                    }

                } elseif ($role == $purchaser) {
                    $cashParentAccountUID = CASH_PARENT_UID;
                    $wicParentAccountUID = PURCHASER_PARENT_UID;

                    $cashAccountName = $name . " - Cash";
                    $wicAccountName = $name . " - WIC";

                    $purchaserCashAccountUID = createAccount($cashParentAccountUID, $cashAccountName, $loginUserId, $dbTimeStamp, $dayEndId, $dayEndDate, 1, $ip, $remoteDevice);
                    $purchaserWICAccountUID = createAccount($wicParentAccountUID, $wicAccountName, $loginUserId, $dbTimeStamp, $dayEndId, $dayEndDate, 1, $ip, $remoteDevice);

                    $tellerPurchaserCashAccountUID = $purchaserCashAccountUID;

                    if ($purchaserCashAccountUID == 0 || $purchaserWICAccountUID == 0) {
                        $rollBack = true;
                        $errorMessages .= "Unable to create purchaser cash/wic accounts! ";
                    }

                }

                $sp = $isSalaryPerson == true ? 1 : 0;
                $hc = $haveCredentials == true ? 1 : 0;

                $query = "INSERT INTO financials_users(
                             user_employee_code, user_designation, user_name, user_father_name, user_username, user_password, user_email, user_mobile, user_emergency_contact, 
                             user_cnic, user_commission_per, user_target_amount, user_address, user_address_2, user_profilepic, user_folder, user_createdby, user_datetime, 
                             user_login_status, user_religion, user_d_o_j, user_account_reporting_group_ids, user_product_reporting_group_ids, user_modular_group_id, user_role_id, user_level, 
                             user_nationality, user_family_code, user_marital_status, user_city, user_blood_group, user_salary_person, user_have_credentials, 
                             user_teller_cash_account_uid, user_teller_wic_account_uid, 
                             user_purchaser_cash_account_uid, user_purchaser_wic_account_uid, 
                             user_day_end_id, user_day_end_date, user_desktop_status, user_ip_adrs, user_brwsr_info) 
                            VALUES (
                                    '', '$designation', '$name', '$fatherName', '$username', '$password', '$email', '$mobile', '$emergency', 
                                    '$cnic', $commission, $targetAmount, '$address', '$addressTwo', '$completeImagePath', '$folderName', $loginUserId, '$dbTimeStamp', 
                                    'DISABLE', $isMuslim, $doj, '$reportingGroupIds', '$productGroupIds', $modularGroupId, $role, $level, 
                                    $countryId, '$familyCode', $isMarried, $cityId, '$bloodGroup', $sp, $hc, 
                                    $tellerPurchaserCashAccountUID, $tellerWICAccountUID, 
                                    $tellerPurchaserCashAccountUID, $purchaserWICAccountUID, 
                                    $dayEndId, '$dayEndDate', 'offline', '$ip', '$remoteDevice'
                            );";

                $result = $database->query($query);

                if ($result && $database->affected_rows() == 1) {

                    $insertedUserId = $database->inserted_id();

                    $employeeCode = generateEmployeeCode($insertedUserId, $name);

                    $upQuery = "UPDATE financials_users SET user_employee_code = '$employeeCode' WHERE user_id = $insertedUserId LIMIT 1;";
                    $upResult = $database->query($upQuery);
                    if ($upResult && $database->affected_rows() == 1) {

                        if ($isSalaryPerson == true) {

                            $salaryParentAccountUID = $database->escape_value($salaryInfo->salary_parent_account_uid);
                            $basicSalary = $database->escape_value($salaryInfo->basic_salary);
                            $salaryPer = $database->escape_value($salaryInfo->salary_per);
                            $workingHours = $database->escape_value($salaryInfo->working_hours);
                            $offDays = $database->escape_value($salaryInfo->off_days);

                            $advSalaryParentAccountUID = PREPAID_EXPENSE_PARENT_UID;

                            $advSalaryAccountUID = createAccount($advSalaryParentAccountUID, 'Adv - ' . $name, $loginUserId, $dbTimeStamp, $dayEndId, $dayEndDate, 1, $ip, $remoteDevice);
                            $expSalaryAccountUID = createAccount($salaryParentAccountUID, 'Exp - ' . $name, $loginUserId, $dbTimeStamp, $dayEndId, $dayEndDate, 1, $ip, $remoteDevice);

                            if ($advSalaryAccountUID == 0 || $expSalaryAccountUID == 0) {
                                $rollBack = true;
                                $errorMessages .= "Unable to create advance/expense salary accounts! ";
                            }

                            $salQuery = "INSERT INTO financials_salary_info (si_basic_salary, si_basic_salary_period, si_working_hours_per_day, si_off_days, si_user_id, 
                                                    si_advance_salary_account_uid, si_expense_salary_account_uid, si_day_end_id, si_day_end_date, si_datetime) 
                                        VALUES (
                                                $basicSalary, $salaryPer, $workingHours, '$offDays', $insertedUserId, 
                                                $advSalaryAccountUID, $expSalaryAccountUID, $dayEndId, '$dayEndDate', '$dbTimeStamp'
                                        );";

                            $salResult = $database->query($salQuery);

                            if ($salResult && $database->affected_rows() == 1) {

                                $salaryInsertedId = $database->inserted_id();

                                $adList = $salaryInfo->a_d;

                                foreach ($adList as $ad) {

                                    $type = $database->escape_value($ad->type);
                                    $accountUID = $database->escape_value($ad->uid);
                                    $accountTitle = $database->escape_value($ad->title);
                                    $remarks = $database->escape_value($ad->remarks);
                                    $amount = $database->escape_value($ad->amount);

                                    $type = $type == 'A' ? 1 : 2;

                                    $salADQuery = "INSERT INTO financials_salary_ad_items(sadi_account_uid, sadi_account_name, sadi_remarks, 
                                                    sadi_allowance_deduction, sadi_taxable, sadi_amount, sadi_absent_deduction, sadi_salary_info_id, sadi_user_id) 
                                                VALUES (
                                                        $accountUID, '$accountTitle', '$remarks', 
                                                        $type, 0, $amount, 0, $salaryInsertedId, $insertedUserId
                                                );";

                                    $salADResult = $database->query($salADQuery);

                                    if (!$salADResult) {
                                        $rollBack = true;
                                        $errorMessages .= "Unable to save allowances/deductions data! ";
                                        break;
                                    }
                                }

                            } else {
                                $rollBack = true;
                                $errorMessages .= "Unable to save salary info! ";
                            }

                        }

                        if ($haveCredentials == true) {

                            $companyInfo = getCompanyInfo();
                            $companyLogo = $subDomain . "/public/_api/company_info/image/logo.png";

                            if ($companyInfo->found == true) {
                                $companyInfo = $companyInfo->properties;
                                $companyLogo = $companyInfo->ci_logo;
                            }

                            $mailData = '<meta charset="UTF-8"><table align="center" style="font-family: Arial, sans-serif; margin: 0px auto; border-spacing: 0px; color: rgb(36, 33, 40); max-width: 600px; width: 600px;">
                                        <tbody>
                                            <tr>
                                                <td style="padding: 0px 10px;">
                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; border-spacing: 0px;">
                                                        <tbody>
                                                            <tr>
                                                                <td align="left" style="text-align:center">
                                                                    <a href="' . $domain .'" title="' . $subDomainName . '">
                                                                        <img src="' . $companyLogo . '" style="margin: 8px" height="100" border="0" alt="Company Logo" />
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 0px 10px;">
                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="font-family: Arial, sans-serif; border-color: rgb(228, 226, 226); border-radius: 4px; border-spacing: 0px; border-style: solid; border-width: 1px; box-shadow: rgba(149, 103, 233, 0.2) 0px 7px 35px 0px;">
                                                        <tbody>
                                                            <tr>
                                                                <td align="center" valign="top" style="padding: 0px;">
                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; border-spacing: 0px;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td height="45" style="font-size: 45px; line-height: 45px; padding: 0px;">&nbsp;</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; border-spacing: 0px;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td align="center" valign="top" style="padding: 0px 20px;">
                                                                                    <p style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 25px; line-height: 1.3; padding: 0px; margin: 0px !important;">Welcome to ' . $subDomainName . '</p>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; border-spacing: 0px;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td height="65" style="font-size: 65px; line-height: 65px; padding: 0px;">&nbsp;</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; border-spacing: 0px;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td align="center" valign="top" style="padding: 0px 50px;">
                                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="font-family: Arial, sans-serif; border-color: rgb(44, 137, 79); border-radius: 4px; border-spacing: 0px; border-style: solid; border-width: 1px;">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td align="center" valign="top" style="padding: 0px;">
                                                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; border-spacing: 0px;">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td height="40" style="font-size: 40px; line-height: 40px; padding: 0px;">&nbsp;</td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table><img src="' . $completeImagePath . '" width="65" height="65" alt="Image" style="border: 8px solid rgb(255, 255, 255); border-radius: 50%; display: block; height: 65px; margin: -82px 0px 0px; outline: none; padding: 0px; width: 65px; max-width: 95vw; max-height: 95vw; /">
                                                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; border-spacing: 0px;">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td height="16" style="font-size: 16px; line-height: 16px; padding: 0px;">&nbsp;</td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; border-spacing: 0px;">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td align="center" valign="top" style="padding: 0px 20px;">
                                                                                                                    <p style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 20px; line-height: 1.3; padding: 0px; margin: 0px !important;">' . $name . '</p>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; border-spacing: 0px;">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td height="25" style="font-size: 25px; line-height: 25px; padding: 0px;">&nbsp;</td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; border-spacing: 0px;">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td align="right" valign="top" style="padding: 4px 20px; width: 35%;">
                                                                                                                    <p style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 1.3; padding: 0px; margin: 0px !important;">Employee Code: </p>
                                                                                                                </td>
                                                                                                                <td align="left" valign="top" style="padding: 4px;">
                                                                                                                    <p style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 1.3; padding: 0px; margin: 0px !important;"><strong>' . $employeeCode . '</strong></p>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td align="right" valign="top" style="padding: 4px 20px; width: 35%;">
                                                                                                                    <p style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 1.3; padding: 0px; margin: 0px !important;">Username: </p>
                                                                                                                </td>
                                                                                                                <td align="left" valign="top" style="padding: 4px;">
                                                                                                                    <p style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 1.3; padding: 0px; margin: 0px !important;"><strong>' . $username . '</strong></p>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td align="right" valign="top" style="padding: 4px 20px; width: 35%;">
                                                                                                                    <p style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 1.3; padding: 0px; margin: 0px !important;">Password: </p>
                                                                                                                </td>
                                                                                                                <td align="left" valign="top" style="padding: 4px;">
                                                                                                                    <p style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 1.3; padding: 0px; margin: 0px !important;"><strong>' . $loginPassword . '</strong></p>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; border-spacing: 0px;">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 12px; line-height: 1.0; padding: 16px; margin: 16px !important; color: rgb(198, 197, 198) !important; text-align: center;"><p>You can change your password after login using above server provided password.</p></td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; border-spacing: 0px;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td height="35" style="font-size: 35px; line-height: 35px; padding: 0px;">&nbsp;</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table width="190" height="48" cellpadding="0" cellspacing="0" border="0" bgcolor="#7b68ee" style="font-family: Arial, sans-serif; background-color: rgb(44, 137, 79); border-radius: 3px; border-spacing: 0px; height: 48px; max-width: 190px; color: rgb(255, 255, 255) !important; width: 190px !important;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td align="center" valign="middle" height="48" style="padding: 0px;"><a href="' . $subDomain . '" title="Click to Login" style="display: inline-block; font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 20px; font-weight: 600; line-height: 48px; max-width: 190px; padding: 0px; text-decoration-line: none; margin: 0px !important; color: rgb(255, 255, 255) !important; width: 190px !important;">Login</a></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0px;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td height="20" style="font-size: 20px; line-height: 20px; padding: 0px;">&nbsp;</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; border-spacing: 0px;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td align="center" valign="top" style="padding: 0px 20px;">
                                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0px;">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td height="15" style="font-size: 15px; line-height: 15px; padding: 0px;">&nbsp;</td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                    <p style="color: rgb(198, 197, 198); font-size: 12px; line-height: 1.3; padding: 0px; margin: 0px !important;">Questions? 24/7 Support: <a href="mailto:support@jadeedmunshi.com" title="Send an email to support@jadeedmunshi.com" style="color: rgb(198, 197, 198); line-height: 1.3; padding: 0px; margin: 0px !important;">support@jadeedmunshi.com</a></p>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; border-spacing: 0px;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td height="45" style="font-size: 45px; line-height: 45px; padding: 0px;">&nbsp;</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 0px;">
                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; border-spacing: 0px;">
                                                        <tbody>
                                                            <tr>
                                                                <td height="40" style="font-size: 40px; line-height: 40px; padding: 0px;">&nbsp;</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 0px 10px;">
                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; border-spacing: 0px;">
                                                        <tbody>
                                                            <tr>
                                                                <td align="center" valign="top" style="color: rgb(204, 204, 204); font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Helvetica, Arial, sans-serif; padding: 0px 10px;">
                                                                <a href="http://jadeedmunshi.com/" title="Click to open in a new window or tab http://jadeedmunshi.com/" style="color: rgb(204, 204, 204); line-height: 1.3; padding: 0px; text-decoration-line: none; margin: 0px !important;">&copy; 2020 Jadeedmunshi</a></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br />';

                            mailTo($email, "Welcome to $subDomainName", $mailData);
                        }

                    } else {
                        $rollBack = true;
                        $errorMessages .= "Unable to save employee code! ";
                    }

                } else {
                    $rollBack = true;
                    $errorMessages .= "Unable to save employee code! ";
                }

            } else {

                // update user

                $sendMail = false;

                $userEmailQuery = "";
                $imageQuery = "";
                $tellerQuery = "";
                $purchaserQuery = "";

                $loginPassword = "";
                $usernameEmailQuery = "";

                if ($userId == SUPER_ADMIN_ID && $enableAll == true) {
                    $userEmailQuery = "user_username = '$username', user_email = '$email', ";
                }

                if ($image != "0" && $sameImage == false) {
                    $imageQuery = "user_profilepic = '$completeImagePath', user_folder = '$folderName', ";
                }

                $previousUserData = getUser($userId);

                $mailImagePath = DEFAULT_USERS_IMAGE;

                if ($previousUserData->found == true) {
                    $previousUserData = $previousUserData->properties;

                    if ($completeImagePath == "") {
                        $mailImagePath = $previousUserData->user_profilepic;
                    } else {
                        $mailImagePath = $completeImagePath;
                    }

                    $employeeCode = $previousUserData->user_employee_code;
                    $previousRole = $previousUserData->user_role_id;

                    $alreadyHaveCredentials = $previousUserData->user_have_credentials;

                    $tellerCashAccountUID = 0;
                    $tellerWICAccountUID = 0;
                    $purchaserCashAccountUID = 0;
                    $purchaserWICAccountUID = 0;

                    if ($previousRole != $role) {

                        $tellerCashAccountUID = $previousUserData->user_teller_cash_account_uid;
                        $tellerWICAccountUID = $previousUserData->user_teller_wic_account_uid;
                        $purchaserCashAccountUID = $previousUserData->user_purchaser_cash_account_uid;
                        $purchaserWICAccountUID = $previousUserData->user_purchaser_wic_account_uid;

                        if ($role == $teller) {

                            $cashParentAccountUID = CASH_PARENT_UID;
                            $wicParentAccountUID = WALK_IN_CUSTOMER_PARENT_UID;

                            $cashAccountName = $name . " - Cash";
                            $wicAccountName = $name . " - WIC";

                            if ($tellerCashAccountUID == 0) {
                                $tellerCashAccountUID = createAccount($cashParentAccountUID, $cashAccountName, $loginUserId, $dbTimeStamp, $dayEndId, $dayEndDate, 1, $ip, $remoteDevice);
                            }

                            if ($tellerWICAccountUID == 0) {
                                $tellerWICAccountUID = createAccount($wicParentAccountUID, $wicAccountName, $loginUserId, $dbTimeStamp, $dayEndId, $dayEndDate, 1, $ip, $remoteDevice);
                            }

                            if ($tellerCashAccountUID == 0 || $tellerWICAccountUID == 0) {
                                $rollBack = true;
                                $errorMessages .= "Unable to save teller cash/wic accounts while update! ";
                            } else {
                                $tellerQuery = "user_teller_cash_account_uid = $tellerCashAccountUID, user_teller_wic_account_uid = $tellerWICAccountUID, user_purchaser_cash_account_uid = $tellerCashAccountUID, ";
                            }

                        } elseif ($role == $purchaser) {

                            $cashParentAccountUID = CASH_PARENT_UID;
                            $wicParentAccountUID = PURCHASER_PARENT_UID;

                            $cashAccountName = $name . " - Cash";
                            $wicAccountName = $name . " - WIC";

                            if ($purchaserCashAccountUID == 0) {
                                $purchaserCashAccountUID = createAccount($cashParentAccountUID, $cashAccountName, $loginUserId, $dbTimeStamp, $dayEndId, $dayEndDate, 1, $ip, $remoteDevice);
                            }

                            if ($purchaserWICAccountUID == 0) {
                                $purchaserWICAccountUID = createAccount($wicParentAccountUID, $wicAccountName, $loginUserId, $dbTimeStamp, $dayEndId, $dayEndDate, 1, $ip, $remoteDevice);
                            }

                            if ($purchaserCashAccountUID == 0 || $purchaserWICAccountUID == 0) {
                                $rollBack = true;
                                $errorMessages .= "Unable to save purchaser cash/wic accounts while update! ";
                            } else {
                                $purchaserQuery = "user_purchaser_cash_account_uid = $purchaserCashAccountUID, user_purchaser_wic_account_uid = $purchaserWICAccountUID, user_teller_cash_account_uid = $purchaserCashAccountUID, ";
                            }

                        }

                    }

                    if ($alreadyHaveCredentials == 0 && $haveCredentials == true && $userId > SUPER_ADMIN_ID) {

                        if ($haveCredentials == true) {
                            $checkQuery = "SELECT user_username, user_email FROM financials_users
                            WHERE (user_username = '$username' OR user_email = '$email') AND user_id != $userId LIMIT 1;";
                            $checkResult = $database->query($checkQuery);
                            if ($checkResult) {
                                $r = $database->fetch_assoc($checkResult);
                                if (strtolower($r['user_email']) == strtolower($email)) {
                                    $emailAlreadyExists = true;
                                }

                                if (strtolower($r['user_username']) == strtolower($username)) {
                                    $usernameAlreadyExists = true;
                                }

                                if ($emailAlreadyExists || $usernameAlreadyExists) {
                                    $response->code = ALREADY_EXISTS;

                                    if ($emailAlreadyExists) {
                                        $response->message = "Already exists '$email' please save with different Email address.";
                                    } elseif ($usernameAlreadyExists) {
                                        $response->message = "Already exists '$username' please save with different Username.";
                                    }

                                    $database->rollBack();
                                    $response->success = OK;
                                    echo json_encode($response);

                                    if (isset($database)) {
                                        $database->close_connection();
                                    }
                                    die();
                                }
                            }
                        }

                        $loginPassword = randomPassword();
                        $password = makHash($loginPassword);

                        $usernameEmailQuery = "user_username = '$username', user_email = '$email', user_password = '$password', ";
                        $sendMail = true;
                    }

                } else {
                    $rollBack = true;
                    $errorMessages .= "Unable to found the previous info or this user! ";
                }

                $sp = $isSalaryPerson == true ? 1 : 0;
                $hc = $haveCredentials == true ? 1 : 0;

                $query = "UPDATE financials_users 
                        SET $userEmailQuery
                            $imageQuery
                            $tellerQuery
                            $purchaserQuery
                            $usernameEmailQuery
                            user_designation = '$designation', 
                            user_name = '$name', 
                            user_father_name = '$fatherName', 
                            user_mobile = '$mobile', 
                            user_emergency_contact = '$emergency', 
                            user_cnic = '$cnic', 
                            user_commission_per = $commission, 
                            user_target_amount = $targetAmount, 
                            user_address = '$address', 
                            user_address_2 = '$addressTwo', 
                            user_religion = $isMuslim, 
                            user_account_reporting_group_ids = '$reportingGroupIds', 
                            user_product_reporting_group_ids = '$productGroupIds', 
                            user_modular_group_id = $modularGroupId, 
                            user_role_id = $role, 
                            user_level = $level, 
                            user_nationality = $countryId, 
                            user_family_code = '$familyCode', 
                            user_marital_status = $isMarried, 
                            user_city = $cityId, 
                            user_blood_group = '$bloodGroup',
                            user_salary_person = $sp,
                            user_have_credentials = $hc
                        WHERE user_id = $userId limit 1;";

                $result = $database->query($query);

                if ($result) {

                    $salInfoQuery = "SELECT * FROM financials_salary_info WHERE si_user_id = $userId LIMIT 1;";
                    $salInfoResult = $database->query($salInfoQuery);

                    $salaryInfoFound = false;

                    if ($salInfoResult && $database->num_rows($salInfoResult) == 1) {
                        $previousSalaryInfo = $database->fetch_assoc($salInfoResult);
                        $salaryInfoFound = true;
                    }

                    if ($isSalaryPerson == true) {

                        if ($salaryInfoFound == false) {

                            $salaryParentAccountUID = $database->escape_value($salaryInfo->salary_parent_account_uid);
                            $basicSalary = $database->escape_value($salaryInfo->basic_salary);
                            $salaryPer = $database->escape_value($salaryInfo->salary_per);
                            $workingHours = $database->escape_value($salaryInfo->working_hours);
                            $offDays = $database->escape_value($salaryInfo->off_days);

                            $advSalaryParentAccountUID = PREPAID_EXPENSE_PARENT_UID;

                            $advSalaryAccountUID = createAccount($advSalaryParentAccountUID, 'Adv - ' . $name, $loginUserId, $dbTimeStamp, $dayEndId, $dayEndDate, 1, $ip, $remoteDevice);
                            $expSalaryAccountUID = createAccount($salaryParentAccountUID, 'Exp - ' . $name, $loginUserId, $dbTimeStamp, $dayEndId, $dayEndDate, 1, $ip, $remoteDevice);

                            if ($advSalaryAccountUID == 0 || $expSalaryAccountUID == 0) {
                                $rollBack = true;
                                $errorMessages .= "Unable to save advance/expense salary accounts while update! ";
                            }

                            $salQuery = "INSERT INTO financials_salary_info (si_basic_salary, si_basic_salary_period, si_working_hours_per_day, si_off_days, si_user_id, 
                                                    si_advance_salary_account_uid, si_expense_salary_account_uid, si_day_end_id, si_day_end_date, si_datetime) 
                                        VALUES (
                                                $basicSalary, $salaryPer, $workingHours, '$offDays', $userId, 
                                                $advSalaryAccountUID, $expSalaryAccountUID, $dayEndId, '$dayEndDate', '$dbTimeStamp'
                                        );";

                            $salResult = $database->query($salQuery);

                            if ($salResult && $database->affected_rows() == 1) {

                                $salaryInsertedId = $database->inserted_id();

                                $adList = $salaryInfo->a_d;

                                foreach ($adList as $ad) {

                                    $type = $database->escape_value($ad->type);
                                    $accountUID = $database->escape_value($ad->uid);
                                    $accountTitle = $database->escape_value($ad->title);
                                    $remarks = $database->escape_value($ad->remarks);
                                    $amount = $database->escape_value($ad->amount);

                                    $type = $type == 'A' ? 1 : 2;

                                    $salADQuery = "INSERT INTO financials_salary_ad_items(sadi_account_uid, sadi_account_name, sadi_remarks, 
                                                    sadi_allowance_deduction, sadi_taxable, sadi_amount, sadi_absent_deduction, sadi_salary_info_id, sadi_user_id) 
                                                VALUES (
                                                        $accountUID, '$accountTitle', '$remarks', 
                                                        $type, 0, $amount, 0, $salaryInsertedId, $userId
                                                );";

                                    $salADResult = $database->query($salADQuery);

                                    if (!$salADResult) {
                                        $rollBack = true;
                                        $errorMessages .= "Unable to save allowances/deductions while update! ";
                                        break;
                                    }
                                }

                            } else {
                                $rollBack = true;
                                $errorMessages .= "Unable to save salary info while update! ";
                            }

                        } else {

                            $salaryParentAccountUID = $database->escape_value($salaryInfo->salary_parent_account_uid);
                            $basicSalary = $database->escape_value($salaryInfo->basic_salary);
                            $salaryPer = $database->escape_value($salaryInfo->salary_per);
                            $workingHours = $database->escape_value($salaryInfo->working_hours);
                            $offDays = $database->escape_value($salaryInfo->off_days);

                            $salQuery = "UPDATE financials_salary_info SET si_basic_salary = $basicSalary, si_basic_salary_period = $salaryPer, si_working_hours_per_day = $workingHours, si_off_days = '$offDays' WHERE si_user_id = $userId;";

                            $salResult = $database->query($salQuery);

                            if ($salResult) {

                                $salaryInsertedId = $previousSalaryInfo['si_id'];

                                $delAllDedQuery = "DELETE FROM financials_salary_ad_items WHERE sadi_user_id = $userId OR sadi_salary_info_id = $salaryInsertedId;";
                                $delAllDedResult = $database->query($delAllDedQuery);

                                $adList = $salaryInfo->a_d;

                                foreach ($adList as $ad) {

                                    $type = $database->escape_value($ad->type);
                                    $accountUID = $database->escape_value($ad->uid);
                                    $accountTitle = $database->escape_value($ad->title);
                                    $remarks = $database->escape_value($ad->remarks);
                                    $amount = $database->escape_value($ad->amount);

                                    $type = $type == 'A' ? 1 : 2;

                                    $salADQuery = "INSERT INTO financials_salary_ad_items(sadi_account_uid, sadi_account_name, sadi_remarks, 
                                                    sadi_allowance_deduction, sadi_taxable, sadi_amount, sadi_absent_deduction, sadi_salary_info_id, sadi_user_id) 
                                                VALUES (
                                                        $accountUID, '$accountTitle', '$remarks', 
                                                        $type, 0, $amount, 0, $salaryInsertedId, $userId
                                                );";

                                    $salADResult = $database->query($salADQuery);

                                    if (!$salADResult) {
                                        $rollBack = true;
                                        $errorMessages .= "Unable to save allowances/deductions while update! ";
                                        break;
                                    }
                                }

                            } else {
                                $rollBack = true;
                                $errorMessages .= "Unable to save salary info while update! ";
                            }

                        }

                    }

                    if ($sendMail == true) {

                        $companyInfo = getCompanyInfo();
                        $companyLogo = $subDomain . "/public/_api/company_info/image/logo.png";

                        if ($companyInfo->found == true) {
                            $companyInfo = $companyInfo->properties;
                            $companyLogo = $companyInfo->ci_logo;
                        }

                        $mailData = '<meta charset="UTF-8"><table align="center" style="font-family: Arial, sans-serif; margin: 0px auto; border-spacing: 0px; color: rgb(36, 33, 40); max-width: 600px; width: 600px;">
                                        <tbody>
                                            <tr>
                                                <td style="padding: 0px 10px;">
                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; border-spacing: 0px;">
                                                        <tbody>
                                                            <tr>
                                                                <td align="left" style="text-align:center">
                                                                    <a href="' . $domain .'" title="' . $subDomainName . '">
                                                                        <img src="' . $companyLogo . '" style="margin: 8px" height="100" border="0" alt="Company Logo" />
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 0px 10px;">
                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="font-family: Arial, sans-serif; border-color: rgb(228, 226, 226); border-radius: 4px; border-spacing: 0px; border-style: solid; border-width: 1px; box-shadow: rgba(149, 103, 233, 0.2) 0px 7px 35px 0px;">
                                                        <tbody>
                                                            <tr>
                                                                <td align="center" valign="top" style="padding: 0px;">
                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; border-spacing: 0px;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td height="45" style="font-size: 45px; line-height: 45px; padding: 0px;">&nbsp;</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; border-spacing: 0px;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td align="center" valign="top" style="padding: 0px 20px;">
                                                                                    <p style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 25px; line-height: 1.3; padding: 0px; margin: 0px !important;">Welcome to ' . $subDomainName . '</p>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; border-spacing: 0px;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td height="65" style="font-size: 65px; line-height: 65px; padding: 0px;">&nbsp;</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; border-spacing: 0px;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td align="center" valign="top" style="padding: 0px 50px;">
                                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="font-family: Arial, sans-serif; border-color: rgb(44, 137, 79); border-radius: 4px; border-spacing: 0px; border-style: solid; border-width: 1px;">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td align="center" valign="top" style="padding: 0px;">
                                                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; border-spacing: 0px;">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td height="40" style="font-size: 40px; line-height: 40px; padding: 0px;">&nbsp;</td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table><img src="' . $mailImagePath . '" width="65" height="65" alt="Image" style="border: 8px solid rgb(255, 255, 255); border-radius: 50%; display: block; height: 65px; margin: -82px 0px 0px; outline: none; padding: 0px; width: 65px; max-width: 95vw; max-height: 95vw; /">
                                                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; border-spacing: 0px;">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td height="16" style="font-size: 16px; line-height: 16px; padding: 0px;">&nbsp;</td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; border-spacing: 0px;">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td align="center" valign="top" style="padding: 0px 20px;">
                                                                                                                    <p style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 20px; line-height: 1.3; padding: 0px; margin: 0px !important;">' . $name . '</p>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; border-spacing: 0px;">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td height="25" style="font-size: 25px; line-height: 25px; padding: 0px;">&nbsp;</td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; border-spacing: 0px;">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td align="right" valign="top" style="padding: 4px 20px; width: 35%;">
                                                                                                                    <p style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 1.3; padding: 0px; margin: 0px !important;">Employee Code: </p>
                                                                                                                </td>
                                                                                                                <td align="left" valign="top" style="padding: 4px;">
                                                                                                                    <p style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 1.3; padding: 0px; margin: 0px !important;"><strong>' . $employeeCode . '</strong></p>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td align="right" valign="top" style="padding: 4px 20px; width: 35%;">
                                                                                                                    <p style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 1.3; padding: 0px; margin: 0px !important;">Username: </p>
                                                                                                                </td>
                                                                                                                <td align="left" valign="top" style="padding: 4px;">
                                                                                                                    <p style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 1.3; padding: 0px; margin: 0px !important;"><strong>' . $username . '</strong></p>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td align="right" valign="top" style="padding: 4px 20px; width: 35%;">
                                                                                                                    <p style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 1.3; padding: 0px; margin: 0px !important;">Password: </p>
                                                                                                                </td>
                                                                                                                <td align="left" valign="top" style="padding: 4px;">
                                                                                                                    <p style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 15px; line-height: 1.3; padding: 0px; margin: 0px !important;"><strong>' . $loginPassword . '</strong></p>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; border-spacing: 0px;">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td style="font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 12px; line-height: 1.0; padding: 16px; margin: 16px !important; color: rgb(198, 197, 198) !important; text-align: center;"><p>You can change your password after login using above server provided password.</p></td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; border-spacing: 0px;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td height="35" style="font-size: 35px; line-height: 35px; padding: 0px;">&nbsp;</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table width="190" height="48" cellpadding="0" cellspacing="0" border="0" bgcolor="#7b68ee" style="font-family: Arial, sans-serif; background-color: rgb(44, 137, 79); border-radius: 3px; border-spacing: 0px; height: 48px; max-width: 190px; color: rgb(255, 255, 255) !important; width: 190px !important;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td align="center" valign="middle" height="48" style="padding: 0px;"><a href="' . $subDomain . '" title="Click to Login" style="display: inline-block; font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 20px; font-weight: 600; line-height: 48px; max-width: 190px; padding: 0px; text-decoration-line: none; margin: 0px !important; color: rgb(255, 255, 255) !important; width: 190px !important;">Login</a></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0px;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td height="20" style="font-size: 20px; line-height: 20px; padding: 0px;">&nbsp;</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; border-spacing: 0px;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td align="center" valign="top" style="padding: 0px 20px;">
                                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0px;">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td height="15" style="font-size: 15px; line-height: 15px; padding: 0px;">&nbsp;</td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                    <p style="color: rgb(198, 197, 198); font-size: 12px; line-height: 1.3; padding: 0px; margin: 0px !important;">Questions? 24/7 Support: <a href="mailto:support@jadeedmunshi.com" title="Send an email to support@jadeedmunshi.com" style="color: rgb(198, 197, 198); line-height: 1.3; padding: 0px; margin: 0px !important;">support@jadeedmunshi.com</a></p>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; border-spacing: 0px;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td height="45" style="font-size: 45px; line-height: 45px; padding: 0px;">&nbsp;</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 0px;">
                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; border-spacing: 0px;">
                                                        <tbody>
                                                            <tr>
                                                                <td height="40" style="font-size: 40px; line-height: 40px; padding: 0px;">&nbsp;</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 0px 10px;">
                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, sans-serif; border-spacing: 0px;">
                                                        <tbody>
                                                            <tr>
                                                                <td align="center" valign="top" style="color: rgb(204, 204, 204); font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Helvetica, Arial, sans-serif; padding: 0px 10px;">
                                                                <a href="http://jadeedmunshi.com/" title="Click to open in a new window or tab http://jadeedmunshi.com/" style="color: rgb(204, 204, 204); line-height: 1.3; padding: 0px; text-decoration-line: none; margin: 0px !important;">&copy; 2020 Jadeedmunshi</a></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br />';

                        mailTo($email, "Welcome to $subDomainName", $mailData);
                    }

                } else {
                    $rollBack = true;
                    $errorMessages .= "Unable to update user data! ";
                }

            }

        } else {
            $response->message = "Data not found!";
        }

    } else {
        $response->message = "Auth token not found!";
    }

} catch (Exception $e) {
    $response->message = $e->getMessage();
}

if ($rollBack == true) {
    $database->rollBack();
    $response->message .= $errorMessages;
    $response->code = NOT_OK;
} else {
    $database->commit();

    $response->data = array('code' => $employeeCode);
    $response->code = OK;
    $response->message = "Employee Saved.";
}

$response->success = OK;
echo json_encode($response);

if (isset($database)) {
    $database->close_connection();
}

