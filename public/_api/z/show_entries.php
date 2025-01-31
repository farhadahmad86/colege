<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 09-Jun-20
 * Time: 1:12 PM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../_db/database.php");
require_once("../functions/db_functions.php");

$voucher = isset($_REQUEST['vc']) ? $database->escape_value($_REQUEST['vc']) : '';

$stockAccountUID = STOCK_ACCOUNT_UID;
$found = false;

$voucherCodes = array(PURCHASE_VOUCHER_CODE, PURCHASE_RETURN_VOUCHER_CODE, SALE_TEX_PURCHASE_VOUCHER_CODE, SALE_TEX_PURCHASE_RETURN_VOUCHER_CODE,
    SALE_VOUCHER_CODE, SALE_RETURN_VOUCHER_CODE, SALE_TEX_SALE_VOUCHER_CODE, SALE_TEX_SALE_RETURN_VOUCHER_CODE);

foreach ($voucherCodes as $code) {
    if (stristr($voucher, $code) !== FALSE) {
        $found = true;
    }
}

$debitEntry = array();
$creditEntry = array();
$stockEntry = array();
$ledger = array();

if ($voucher != '') {

    $query = "SELECT bal_account_id as account_uid, bal_datetime as time, bal_day_end_date as date, bal_dr as dr, bal_cr as cr, bal_remarks as remarks, bal_detail_remarks as detail_remarks
                      FROM financials_balances 
                      WHERE bal_voucher_number = '$voucher';";


    $result = $database->query($query);

    if($result) {

        $totalDebit = 0;
        $totalCredit = 0;

        while ($item = $database->fetch_array($result)) {

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
                    'debit' => number_format($dr, 2, '.', ','),
                    'credit' => number_format($cr, 2, '.', ','),
                    'exclude' => false

                );
            } else {
                $creditEntry[] = array(

                    'account_uid' => $accountUID,
                    'account_name' => $accountName,
                    'debit' => number_format($dr, 2, '.', ','),
                    'credit' => number_format($cr, 2, '.', ','),
                    'exclude' => false

                );
            }

        }

        $ledger = array_merge($debitEntry, $creditEntry, $stockEntry);

        echo "<html>
            <head>
            <style>
                table {
                  font-family: arial, sans-serif;
                  border-collapse: collapse;
                  width: 50%;
                  margin: auto;
                }
                
                th {
                  border: 1px solid #dddddd;
                  text-align: center;
                  padding: 8px;
                }
                
                td {
                  border: 1px solid #dddddd;
                  text-align: left;
                  padding: 8px;
                }
                
                tr:nth-child(even) {
                  background-color: #dddddd;
                }
            </style>
            </head>
        ";

        echo "<body><br /><br /><br /><br /><table>
                    <tr>
                        <th>UID</th>
                        <th style='text-align: left'>Title</th>
                        <th>Debit</th>
                        <th>Credit</th>
                    </tr>
            ";

        foreach ($ledger as $item) {
            $color = $item['exclude'] == true ? "color: red" : "";
            echo "
                    <tr>
                        <td style='text-align: center; " . $color . "'>" . $item['account_uid'] . "</td>
                        <td style='text-align: left; " . $color . "'>" . $item['account_name'] . "</td>
                        <td style='text-align: right; " . $color . "'>" . $item['debit'] . "</td>
                        <td style='text-align: right; " . $color . "'>" . $item['credit'] . "</td>
                    </tr>
            ";
        }

        echo "
                <tr>
                    <th>------</th>
                    <th style='text-align: left'>Total</th>
                    <th style='text-align: right'>" . number_format($totalDebit, 2) . "</th>
                    <th style='text-align: right'>" . number_format($totalCredit, 2) . "</th>
                </tr>
            </table></body></html>";

    } else {
        echo "Unable to get entry.";
    }

} else {
    echo "Parameters not found!";
}

$database->close_connection();
