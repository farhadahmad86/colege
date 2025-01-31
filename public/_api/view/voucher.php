<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 23-Apr-20
 * Time: 4:12 PM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../_db/database.php");
require_once("../functions/functions.php");
require_once("../functions/api_functions.php");

$number = isset($_REQUEST['vn']) ? $database->escape_value($_REQUEST['vn']) : "";

$number = strtoupper($number);

$JV = 1;
$CPV = 2;
$CRV = 3;
$BPV = 4;
$BRV = 5;
$CT = 6;
$EPV = 7;

$invoiceTitle = "";
$voucherNumber = '';
$detailHTML = "";

$data = array();

if ($number != "") {
    $ar = explode('-', $number);
    if (count($ar) == 2) {
        $voucherType = $ar[0] . '-';
        switch ($voucherType) {
            case JOURNAL_VOUCHER_CODE:
                $voucherType = $JV;
                $invoiceTitle = "JOURNAL VOUCHER";
                break;
            case CASH_PAYMENT_VOUCHER_CODE:
                $voucherType = $CPV;
                $invoiceTitle = "CASH PAYMENT VOUCHER";
                break;
            case CASH_RECEIPT_VOUCHER_CODE:
                $voucherType = $CRV;
                $invoiceTitle = "CASH RECEIPT VOUCHER";
                break;
            case BANK_PAYMENT_VOUCHER_CODE:
                $voucherType = $BPV;
                $invoiceTitle = "BANK PAYMENT VOUCHER";
                break;
            case BANK_RECEIPT_VOUCHER_CODE:
                $voucherType = $BRV;
                $invoiceTitle = "BANK RECEIPT VOUCHER";
                break;
            case CASH_TRANSFER_CODE:
                $voucherType = $JV;
                $invoiceTitle = "JOURNAL VOUCHER";
                break;
            case EXPENSE_PAYMENT_CODE:
                $voucherType = $EPV;
                $invoiceTitle = "EXPENSE PAYMENT VOUCHER";
                break;
        }
        $invoiceNumber = $ar[1];
    }
}

if ($invoiceNumber == 0) {
    dieWithError("Invoice number not found!", $database);
}








$query = "select bal_account_id as accountId, bal_remarks as remarks, bal_dr as dr, bal_cr as cr, bal_datetime as dateTime, bal_day_end_date as dayEndDate 
                    from financials_balances where bal_voucher_number = '$number';";
$result = $database->query($query);
if ($result && $database->num_rows($result) > 0) {
    while ($row = $database->fetch_assoc($result)) {
        $data[] = $row;
    }

    try {
        $formattedDate = new DateTime($data[0]['dayEndDate']);
        $formattedDate = $formattedDate->format(USER_DATE_FORMAT);

        $formattedTimeStamp = new DateTime($data[0]['dateTime']);
        $formattedTimeStamp = $formattedTimeStamp->format(USER_DATE_TIME_FORMAT);
    } catch (Exception $e) {
    }

    $detailHTML .= '
            <main>
                <div id="details" class="clearfix">
                    <div id="invoice">
                        <h1>' . $number . '</h1>
                        <div class="date">Dated: ' . $formattedDate . '</div>
                        <div class="date">Generated: ' . $formattedTimeStamp . '</div>
                    </div>
                </div>
                <table border="0" cellspacing="0" cellpadding="0">
                <thead>
                <tr>
                    <th class="no">#</th>
                    <th class="aid">Account ID</th>
                    <th class="aname">Account Name</th>
                    <th class="total">Debit</th>
                    <th class="total">Credit</th>
                </tr>
                </thead>
                <tbody>
            ';

    $counter = 0;
    $totalDr = 0;
    $totalCr = 0;

    foreach ($data as $d) {
        $counter++;
        $accountName = getAccount($d['accountId'])->properties->account_name;
        $totalDr = $totalDr + $d['dr'];
        $totalCr = $totalCr + $d['cr'];

        $debitAmount = $d['dr'] == 0.00 ? '' : number_format($d['dr'], 2);
        $creditAmount = $d['cr'] == 0.00 ? '' : number_format($d['cr'], 2);

        $detailHTML .= '
                <tr>
                    <td class="no">' . str_pad($counter, 2, '0', STR_PAD_LEFT) . '</td>
                    <td class="aid">' . $d['accountId'] . '</td>
                    <td class="aname">
                        <h3><b>' . $accountName . '</b></h3>
                        ' . $d['remarks'] . '
                    </td>
                    <td class="total">' . $debitAmount . '</td>
                    <td class="total">' . $creditAmount . '</td>
                </tr>
                ';
    }

    $detailHTML .= '
            <tr>
                <th class="no">' . $counter . '</th>
                <th class="left" colspan="2">TOTAL</th>
                <th class="total">' . number_format($totalDr, 2) . '</th>
                <th class="total">' . number_format($totalCr, 2) . '</th>
            </tr>
            </tbody>
        </table>
        <div class="total-section">
            <div class="totals">
                <table>
                    <tfoot>
                    <tr>
                        <td class="grand">GRAND TOTAL</td>
                        <td></td>
                        <td class="grand">' . number_format($totalDr, 2) . '</td>
                    </tr>
                    <tr>
                        <td class="words" colspan="3">' . number_to_word($totalDr) . '</td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </main>
    <footer>
        Invoice was system generated and is valid without the signature and seal.
    </footer>
    </body>
    </html>
            ';
}






$companyName = '';
$companyLogo = DEFAULT_LOGO_IMAGE_PATH;
$companyPTCL = '';
$companyEmail = '';
$companyAddress = '';

$companyInfoQuery = "SELECT ci_logo, ci_name, ci_ptcl_number, ci_email, ci_address FROM financials_company_info WHERE ci_id = 1 LIMIT 1;";
$companyInfoResult = $database->query($companyInfoQuery);
if ($companyInfoResult) {
    $companyData = $database->fetch_assoc($companyInfoResult);

    $companyName = $companyData['ci_name'];
    $companyLogo = $companyData['ci_logo'];
    $companyPTCL = $companyData['ci_ptcl_number'];
    $companyEmail = $companyData['ci_email'];
    $companyAddress = $companyData['ci_address'];

}

try {
    $printedTimeStamp = new DateTime();
    $printedTimeStamp = $printedTimeStamp->format(USER_DATE_TIME_FORMAT);
} catch (Exception $e) {}

$htmlInvoice = '<!DOCTYPE html>
                    <html lang="en">
                      <head>
                        <base href="' . $subDomain . '/public/_api/view/" />
                        <meta charset="utf-8">
                        <title>' . $invoiceTitle . ' ' . $invoiceNumber . '</title>
                        <link rel="stylesheet" href="voucher.css" media="all" />
                      </head>
                      <body>
                        <header class="clearfix">
                          <div id="logo">
                            <img src="' . $companyLogo . '" alt="Company Logo">
                          </div>
                          <div id="company">
                            <h2 class="name">' . $companyName . '</h2>
                            <div>' . $companyAddress . '</div>
                            <div>' . $companyPTCL . '</div>
                            <div><a href="mailto:' . $companyEmail . '">' . $companyEmail . '</a></div>
                            <div>Printed: ' . $printedTimeStamp . '</div>
                          </div>
                        </header>
                          <div id="title">
                            <h2 class="name left">' . $invoiceTitle . '</h2>
                          </div>';

$htmlInvoice .= $detailHTML;


echo $htmlInvoice;


if (isset($database)) {
    $database->close_connection();
}
