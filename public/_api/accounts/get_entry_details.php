<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 19-Mar-20
 * Time: 12:41 PM
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

        $stockAccountUID = STOCK_ACCOUNT_UID;

        $debitEntry = array();
        $creditEntry = array();
        $stockEntry = array();
        $ledger = array();

        $voucher = isset($_POST['vc']) ? $database->escape_value($_POST['vc']) : '';

        $found = false;

        $voucherCodes = array(PURCHASE_VOUCHER_CODE, PURCHASE_RETURN_VOUCHER_CODE, SALE_TEX_PURCHASE_VOUCHER_CODE, SALE_TEX_PURCHASE_RETURN_VOUCHER_CODE,
            SALE_VOUCHER_CODE, SALE_RETURN_VOUCHER_CODE, SALE_TEX_SALE_VOUCHER_CODE, SALE_TEX_SALE_RETURN_VOUCHER_CODE);

        foreach ($voucherCodes as $code) {
            if (stristr($voucher, $code) !== FALSE) {
                $found = true;
            }
        }


        if ($voucher != '') {

            $query = "SELECT bal_account_id as account_uid, bal_datetime as time, bal_day_end_date as date, bal_dr as dr, bal_cr as cr, bal_remarks as remarks, bal_detail_remarks as detail_remarks
                      FROM financials_balances 
                      WHERE bal_voucher_number = '$voucher';";


            $result = $database->query($query);

            if($result) {

                $totalDebit = 0;
                $totalCredit = 0;

                while ($item = $database->fetch_array($result)) {

                    $time = '';
                    $date = '';
                    try{

                        $time = new DateTime($item['time']);
                        $time = $time->format('h:i:s a');

                        $date = new DateTime($item['date']);
                        $date = $date->format('d-m-Y');

                    } catch (Exception $e) {
                        $time = '';
                        $date = '';
                    }

                    $dr = $item['dr'];
                    $cr = $item['cr'];

                    $accountUID = $item['account_uid'];
                    $accountData = getAccount($accountUID);
                    $accountName = "";

                    if ($accountData->found == true) {
                        $accountName = $accountData->properties->account_name;
                    }

                    if ($found == true && $accountUID == $stockAccountUID) {

                        $stockEntry[] = array(

                            'account_uid' => $accountUID,
                            'account_name' => $accountName,
                            'date' => $date,
                            'time' => $time,
                            'remarks' => $item['remarks'],
                            'detail_remarks' => $item['detail_remarks'],
                            'debit' => number_format($dr, 2, '.', ','),
                            'credit' => number_format($cr, 2, '.', ','),
                            'exclude' => true

                        );

                        continue;

                    } else {

                        $totalDebit += $dr;
                        $totalCredit += $cr;

                    }

                    if ($dr > $cr) {
                        $debitEntry[] = array(

                            'account_uid' => $accountUID,
                            'account_name' => $accountName,
                            'date' => $date,
                            'time' => $time,
                            'remarks' => $item['remarks'],
                            'detail_remarks' => $item['detail_remarks'],
                            'debit' => number_format($dr, 2, '.', ','),
                            'credit' => number_format($cr, 2, '.', ','),
                            'exclude' => false

                        );
                    } else {
                        $creditEntry[] = array(

                            'account_uid' => $accountUID,
                            'account_name' => $accountName,
                            'date' => $date,
                            'time' => $time,
                            'remarks' => $item['remarks'],
                            'detail_remarks' => $item['detail_remarks'],
                            'debit' => number_format($dr, 2, '.', ','),
                            'credit' => number_format($cr, 2, '.', ','),
                            'exclude' => false

                        );
                    }

                }

                $ledger = array_merge($debitEntry, $creditEntry, $stockEntry);

                if (sizeof($ledger) > 0) {
                    $response->data = $ledger;
                    $response->debit = number_format($totalDebit, 2, '.', ',');
                    $response->credit = number_format($totalCredit, 2, '.', ',');
                    $response->items = sizeof($ledger);
                    $response->code = OK;
                    $response->message = "Account Ledger Entry";
                } else {
                    $response->code = DATA_EMPTY;
                    $response->message = "Ledger entry is empty!";
                }

            } else {
                $response->code = NOT_OK;
                $response->message = "Unable to get Ledger entry.";
            }

        } else {
            $response->code = NOT_OK;
            $response->message = "Parameters not found!";
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


