<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 05-Mar-20
 * Time: 1:37 PM
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

$response = (object)array('success' => 0, 'code' => 0, 'message' => '', 'data' => array());

try {

    if (isset($jwt)) {

        $userData = dieIfNotValidUser($jwt);
        $user = $userData->user;
        $loginUserId = $userData->loginUserId;
        $currentStatus = $userData->userStatus;

        $isConfig = isset($_POST['config']) ? $database->escape_value($_POST['config']) : "";

//        if ($isConfig == "1") {

            $systemConfigQuery = "SELECT * FROM financials_system_config WHERE sc_id = 1;";
            $systemConfigResult = $database->query($systemConfigQuery);
            if ($systemConfigResult && $database->num_rows($systemConfigResult) == 1) {

                $config = $database->fetch_assoc($systemConfigResult);

                $allDone = $config['sc_all_done'];

                if ($allDone == 0) {

                    $profileAdded = $config['sc_profile_update'];
                    $companyAdded = $config['sc_company_info_update'];
                    $productsAdded = $config['sc_products_added'];
                    $capitalAdded = $config['sc_admin_capital_added'];
                    $openingTrialAdded = $config['sc_opening_trial_complete'];
                    $firstDateAdded = $config['sc_first_date_added'];
                    $firstDate = $config['sc_first_date'];

                    $bankPaymentNumber = $config['sc_bank_payment_voucher_number'];
                    $bankReceiptNumber = $config['sc_bank_receipt_voucher_number'];
                    $cashPaymentNumber = $config['sc_cash_payment_voucher_number'];
                    $cashReceiptNumber = $config['sc_cash_receipt_voucher_numer'];
                    $expensePaymentNumber = $config['sc_expense_payment_voucher_number'];
                    $journalVoucherNumber = $config['sc_journal_voucher_number'];
                    $purchaseInvoiceNumber = $config['sc_purchase_invoice_number'];
                    $purchaseReturnNumber = $config['sc_purchase_return_invoice_number'];
                    $purchaseTaxNumber = $config['sc_purchase_st_invoice_number'];
                    $purchaseTaxReturnNumber = $config['sc_purchase_return_st_invoice_number'];
                    $salaryPaymentNumber = $config['sc_salary_payment_voucher_number'];
                    $salarySlipNumber = $config['sc_salary_slip_voucher_number'];
                    $advanceSalaryNumber = $config['sc_advance_salary_voucher_number'];
                    $saleInvoiceNumber = $config['sc_sale_invoice_number'];
                    $saleReturnInvoiceNumber = $config['sc_sale_return_invoice_number'];
                    $saleTaxInvoiceNumber = $config['sc_sale_tax_invoice_number'];
                    $saleTaxReturnInvoiceNumber = $config['sc_sale_tax_return_invoice_number'];
                    $serviceInvoiceNumber = $config['sc_service_invoice_number'];
                    $serviceTaxInvoiceNumber = $config['sc_service_tax_invoice_number'];

                    $response->data = array(
                        'profile' => $profileAdded,
                        'company' => $companyAdded,
                        'products' => $productsAdded,
                        'capital' => $capitalAdded,
                        'openingTrial' => $openingTrialAdded,
                        'firstDateAdded' => $firstDateAdded,
                        'firstDate' => $firstDate,

                        'bankPaymentNumber' => $bankPaymentNumber,
                        'bankReceiptNumber' => $bankReceiptNumber,
                        'cashPaymentNumber' => $cashPaymentNumber,
                        'cashReceiptNumber' => $cashReceiptNumber,
                        'expensePaymentNumber' => $expensePaymentNumber,
                        'journalVoucherNumber' => $journalVoucherNumber,
                        'purchaseInvoiceNumber' => $purchaseInvoiceNumber,
                        'purchaseReturnNumber' => $purchaseReturnNumber,
                        'purchaseTaxNumber' => $purchaseTaxNumber,
                        'purchaseTaxReturnNumber' => $purchaseTaxReturnNumber,
                        'salaryPaymentNumber' => $salaryPaymentNumber,
                        'salarySlipNumber' => $salarySlipNumber,
                        'advanceSalaryNumber' => $advanceSalaryNumber,
                        'saleInvoiceNumber' => $saleInvoiceNumber,
                        'saleReturnInvoiceNumber' => $saleReturnInvoiceNumber,
                        'saleTaxNumber' => $saleTaxInvoiceNumber,
                        'saleTaxReturnInvoiceNumber' => $saleTaxReturnInvoiceNumber,
                        'serviceInvoiceNumber' => $serviceInvoiceNumber,
                        'serviceTaxNumber' => $serviceTaxInvoiceNumber,

                        'done' => $allDone
                    );
                    $response->code = OK;
                    $response->message = "System Config Pending!";

                } else {

//                $lastClosedDayEnd = getLastCloseDayEnd();
//                $lastClosedDayEndId = 0;
//
//                if ($lastClosedDayEnd->found == true && $lastClosedDayEnd->id > 0) {
//                    $lastClosedDayEndId = $lastClosedDayEnd->id;
//                }

//                    $zoneName = ASIA_TIME_ZONE;
//                    $dayEndDate = new DateTime('now', new DateTimeZone($zoneName));
//                    $dayEndDate->format(DAY_END_DATE_FORMAT_FOR_USER);
                    $dayEndId = 0;
                    $dayEndDate = new DateTime();
                    $dayEndLockStatus = "LOCKED";

                    $dayEnd = getOpenDayEnd();
                    if ($dayEnd->found == true) {
                        $dayEndId = $dayEnd->id;
                        $dayEndDate = $dayEnd->date;
                        $dayEndLockStatus = $dayEnd->status;
                    }

                    $response->data = array(
                        'dayEndId' => $dayEndId,
                        'dayEndDate' => $dayEndDate,
                        'dayEndStatus' => $dayEndLockStatus,
                        'done' => $allDone
                    );
                    $response->code = OK;
                    $response->message = "Dashboard Data!";

                }

            } else {

                $response->message = "Initial system configuration not found please contact to 'Jadeed Munshi Support'.";

            }

//        } else {
//
//                $lastClosedDayEnd = getLastCloseDayEnd();
//                $lastClosedDayEndId = 0;
//
//                if ($lastClosedDayEnd->found == true && $lastClosedDayEnd->id > 0) {
//                    $lastClosedDayEndId = $lastClosedDayEnd->id;
//                }
//
//            $zoneName = ASIA_TIME_ZONE;
//            $dayEndDate = new DateTime('now', new DateTimeZone($zoneName));
//            $dayEndDate->format(DAY_END_DATE_FORMAT_FOR_USER);
//            $dayEndId = 0;
//            $dayEndDate = new DateTime();
//            $dayEndLockStatus = "LOCKED";
//
//            $dayEnd = getOpenDayEnd();
//            if ($dayEnd->found == true) {
//                $dayEndId = $dayEnd->id;
//                $dayEndDate = $dayEnd->date;
//                $dayEndLockStatus = $dayEnd->status;
//            }
//
//            $response->data = array(
//                'dayEndId' => $dayEndId,
//                'dayEndDate' => $dayEndDate,
//                'dayEndStatus' => $dayEndLockStatus,
//                'done' => 1
//            );
//            $response->code = OK;
//            $response->message = "Dashboard Data!";
//
//        }

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


