<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 18-Mar-20
 * Time: 3:24 PM
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

        $typeProfile = 1;
        $typeCompanyInfo = 2;
        $typeCapital = 3;
        $typeFirstDate = 4;

        $typeBankPayment = 5;
        $typeBankReceipt = 6;
        $typeCashPayment = 7;
        $typeCashReceipt = 8;
        $typeExpensePayment = 9;
        $typeJournalVoucher = 10;
        $typePurchaseInvoice = 11;
        $typePurchaseReturnInvoice = 12;
        $typePurchaseSTInvoice = 13;
        $typePurchaseSTReturnInvoice = 14;
        $typeSalaryPayment = 15;
        $typeSalarySlip = 16;
        $typeAdvanceSalary = 17;
        $typeSaleInvoice = 18;
        $typeSaleReturnInvoice = 19;
        $typeSaleTaxInvoice = 20;
        $typeSaleTaxReturnInvoice = 21;
        $typeServiceInvoice = 22;
        $typeServiceTaxInvoice = 23;

        $dataType = isset($_POST['type']) ? $database->escape_value($_POST['type']) : 0;

        if ($dataType == 0) {
            $response->code = NOT_OK;
            $response->message = "No config found";
            $response->success = OK;
            echo json_encode($response);

            if (isset($database)) {
                $database->close_connection();
            }
            die();
        } else {

            $firstDate = isset($_POST['date']) ? $database->escape_value($_POST['date']) : "";

            $bankPaymentNumber = isset($_POST['bank_payment']) ? $database->escape_value($_POST['bank_payment']) : 0;
            $bankReceiptNumber = isset($_POST['bank_receipt']) ? $database->escape_value($_POST['bank_receipt']) : 0;
            $cashPaymentNumber = isset($_POST['cash_payment']) ? $database->escape_value($_POST['cash_payment']) : 0;
            $cashReceiptNumber = isset($_POST['cash_receipt']) ? $database->escape_value($_POST['cash_receipt']) : 0;
            $expensePaymentNumber = isset($_POST['expense_payment']) ? $database->escape_value($_POST['expense_payment']) : 0;
            $journalVoucherNumber = isset($_POST['journal_voucher']) ? $database->escape_value($_POST['journal_voucher']) : 0;
            $purchaseInvoiceNumber = isset($_POST['purchase_invoice']) ? $database->escape_value($_POST['purchase_invoice']) : 0;
            $purchaseReturnInvoiceNumber = isset($_POST['purchase_return_invoice']) ? $database->escape_value($_POST['purchase_return_invoice']) : 0;
            $purchaseSTInvoiceNumber = isset($_POST['purchase_st_invoice']) ? $database->escape_value($_POST['purchase_st_invoice']) : 0;
            $purchaseSTReturnInvoiceNumber = isset($_POST['purchase_st_return_invoice']) ? $database->escape_value($_POST['purchase_st_return_invoice']) : 0;
            $salaryPaymentNumber = isset($_POST['salary_payment']) ? $database->escape_value($_POST['salary_payment']) : 0;
            $salarySlipNumber = isset($_POST['salary_slip']) ? $database->escape_value($_POST['salary_slip']) : 0;
            $advanceSalaryNumber = isset($_POST['advance_salary']) ? $database->escape_value($_POST['advance_salary']) : 0;
            $saleInvoiceNumber = isset($_POST['sale_invoice']) ? $database->escape_value($_POST['sale_invoice']) : 0;
            $saleReturnInvoiceNumber = isset($_POST['sale_return_invoice']) ? $database->escape_value($_POST['sale_return_invoice']) : 0;
            $saleTaxInvoiceNumber = isset($_POST['sale_tax_invoice']) ? $database->escape_value($_POST['sale_tax_invoice']) : 0;
            $saleTaxReturnInvoiceNumber = isset($_POST['sale_tax_return_invoice']) ? $database->escape_value($_POST['sale_tax_return_invoice']) : 0;
            $serviceInvoiceNumber = isset($_POST['service_invoice']) ? $database->escape_value($_POST['service_invoice']) : 0;
            $serviceTaxInvoiceNumber = isset($_POST['service_tax_invoice']) ? $database->escape_value($_POST['service_tax_invoice']) : 0;

            $query = "";

            switch ($dataType) {
                case $typeProfile:
                    $query = "UPDATE financials_system_config SET sc_products_added = 1 where sc_id = 1;";
                    break;
                case $typeCompanyInfo:
                    $query = "UPDATE financials_system_config SET sc_company_info_update = 1 where sc_id = 1;";
                    break;
                case $typeCapital:
                    $query = "UPDATE financials_system_config SET sc_admin_capital_added = 1 where sc_id = 1;";
                    break;
                case $firstDate:
                    $query = "UPDATE financials_system_config SET sc_first_date = '$firstDate', sc_first_date_added = 1 where sc_id = 1;";
                    break;
                case $typeBankPayment:
                    $query = "UPDATE financials_system_config SET sc_bank_payment_voucher_number = $bankPaymentNumber where sc_id = 1;";
                    break;
                case $typeBankReceipt:
                    $query = "UPDATE financials_system_config SET sc_bank_receipt_voucher_number = $bankReceiptNumber where sc_id = 1;";
                    break;
                case $typeCashPayment:
                    $query = "UPDATE financials_system_config SET sc_cash_payment_voucher_number = $cashPaymentNumber where sc_id = 1;";
                    break;
                case $typeCashReceipt:
                    $query = "UPDATE financials_system_config SET sc_cash_receipt_voucher_numer = $cashReceiptNumber where sc_id = 1;";
                    break;
                case $typeExpensePayment:
                    $query = "UPDATE financials_system_config SET sc_expense_payment_voucher_number = $expensePaymentNumber where sc_id = 1;";
                    break;
                case $typeJournalVoucher:
                    $query = "UPDATE financials_system_config SET sc_journal_voucher_number = $journalVoucherNumber where sc_id = 1;";
                    break;
                case $typePurchaseInvoice:
                    $query = "UPDATE financials_system_config SET sc_purchase_invoice_number = $purchaseInvoiceNumber where sc_id = 1;";
                    break;
                case $typePurchaseReturnInvoice:
                    $query = "UPDATE financials_system_config SET sc_purchase_return_invoice_number = $purchaseReturnInvoiceNumber where sc_id = 1;";
                    break;
                case $typePurchaseSTInvoice:
                    $query = "UPDATE financials_system_config SET sc_purchase_st_invoice_number = $purchaseSTInvoiceNumber where sc_id = 1;";
                    break;
                case $typePurchaseSTReturnInvoice:
                    $query = "UPDATE financials_system_config SET sc_purchase_return_st_invoice_number = $purchaseSTReturnInvoiceNumber where sc_id = 1;";
                    break;
                case $typeSalaryPayment:
                    $query = "UPDATE financials_system_config SET sc_salary_payment_voucher_number = $salaryPaymentNumber where sc_id = 1;";
                    break;
                case $typeSalarySlip:
                    $query = "UPDATE financials_system_config SET sc_salary_slip_voucher_number = $salarySlipNumber where sc_id = 1;";
                    break;
                case $typeAdvanceSalary:
                    $query = "UPDATE financials_system_config SET sc_advance_salary_voucher_number = $advanceSalaryNumber where sc_id = 1;";
                    break;
                case $typeSaleInvoice:
                    $query = "UPDATE financials_system_config SET sc_sale_invoice_number = $saleInvoiceNumber where sc_id = 1;";
                    break;
                case $typeSaleReturnInvoice:
                    $query = "UPDATE financials_system_config SET sc_sale_return_invoice_number = $saleReturnInvoiceNumber where sc_id = 1;";
                    break;
                case $typeSaleTaxInvoice:
                    $query = "UPDATE financials_system_config SET sc_sale_tax_invoice_number = $saleTaxInvoiceNumber where sc_id = 1;";
                    break;
                case $typeSaleTaxReturnInvoice:
                    $query = "UPDATE financials_system_config SET sc_sale_tax_return_invoice_number = $saleTaxReturnInvoiceNumber where sc_id = 1;";
                    break;
                case $typeServiceInvoice:
                    $query = "UPDATE financials_system_config SET sc_service_invoice_number = $serviceInvoiceNumber where sc_id = 1;";
                    break;
                case $typeServiceTaxInvoice:
                    $query = "UPDATE financials_system_config SET sc_service_tax_invoice_number = $serviceTaxInvoiceNumber where sc_id = 1;";
                    break;
            }

            if ($query == "") {
                $response->code = NOT_OK;
                $response->message = "No config found";
                $response->success = OK;
                echo json_encode($response);

                if (isset($database)) {
                    $database->close_connection();
                }
                die();
            } else {

                $result = $database->query($query);

                if ($result && $database->affected_rows() == 1) {
                    $response->code = OK;
                    $response->message = "System Config updated.";
                } else {
                    $response->code = NOT_OK;
                    $response->message = "Failed to update config!";
                }
            }

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



