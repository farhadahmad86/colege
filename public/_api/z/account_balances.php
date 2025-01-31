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

?>

<html>
<head>

    <title>Account Balances</title>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable( {
                "scrollX": true,
                stateSave: true,
                "select": "single",
                "lengthMenu": [[15, 25, 50, 100, 250, -1], [15, 25, 50, 100, 250, "All"]],
                "pagingType": "full_numbers",
                dom: 'lfrtip'
            } );
        } );
    </script>

</head>
<body>

<h2 style="text-align: center; padding-top: 22px">Account Balances</h2>

<div style="margin: auto; padding: 16px">

    <table id="dataTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th rowspan="2" style='width: 3%'>Id</th>
                <th rowspan="2" style='width: 3%'>UID</th>
                <th rowspan="2" >Account Title</th>
                <th colspan="4" style='width: 28%'>Daily</th>
                <th colspan="4" style='width: 28%'>Monthly</th>
                <th rowspan="2" style='width: 7%'>Balance</th>
            </tr>
            <tr>
                <th style='width: 7%'>Type</th>
                <th style='width: 7%'>Opening</th>
                <th style='width: 7%'>Debit</th>
                <th style='width: 7%'>Credit</th>
                <th style='width: 7%'>Type</th>
                <th style='width: 7%'>Opening</th>
                <th style='width: 7%'>Debit</th>
                <th style='width: 7%'>Credit</th>
            </tr>
        </thead>
        <tbody>

<?php

$query1 = "SELECT account_id, account_uid, account_name, account_today_opening_type, account_today_opening, account_today_debit, account_today_credit, 
                account_monthly_opening_type, account_monthly_opening, account_monthly_debit, account_monthly_credit, account_balance 
            FROM financials_accounts";
$result1 = $database->query($query1);

if ($result1) {

    while ($acc = $database->fetch_assoc($result1)) {

        $accId = $acc['account_id'];
        $accUid = $acc['account_uid'];
        $accTitle = $acc['account_name'];

        $dType = $acc['account_today_opening_type'];
        $dOpening = $acc['account_today_opening'];
        $dDebit = $acc['account_today_debit'];
        $dCredit = $acc['account_today_credit'];

        $mType = $acc['account_monthly_opening_type'];
        $mOpening = $acc['account_monthly_opening'];
        $mDebit = $acc['account_monthly_debit'];
        $mCredit = $acc['account_monthly_credit'];

        $accBal = $acc['account_balance'];

        $dOpening = $dOpening != 0 ? number_format($dOpening, 2) : '-';
        $dDebit = $dDebit != 0 ? number_format($dDebit, 2) : '-';
        $dCredit = $dCredit != 0 ? number_format($dCredit, 2) : '-';
        $mOpening = $mOpening != 0 ? number_format($mOpening, 2) : '-';
        $mDebit = $mDebit != 0 ? number_format($mDebit, 2) : '-';
        $mCredit = $mCredit != 0 ? number_format($mCredit, 2) : '-';
        $accBal = $accBal != 0 ? number_format($accBal, 2) : '-';

        echo "
            <tr>
                <td>$accId</td>
                <td>$accUid</td>
                <td>$accTitle</td>
                <td style='text-align: center'>$dType</td>
                <td style='text-align: center'>$dOpening</td>
                <td style='text-align: center'>$dDebit</td>
                <td style='text-align: center'>$dCredit</td>
                <td style='text-align: center'>$mType</td>
                <td style='text-align: center'>$mOpening</td>
                <td style='text-align: center'>$mDebit</td>
                <td style='text-align: center'>$mCredit</td>
                <td style='text-align: center'>$accBal</td>
            </tr>
        ";
    }

}

?>

        </tbody>
        <tfoot>
            <tr>
                <th rowspan="2" style='width: 3%'>Id</th>
                <th rowspan="2" style='width: 3%'>UID</th>
                <th rowspan="2" >Account Title</th>
                <th colspan="4" style='width: 28%'>Daily</th>
                <th colspan="4" style='width: 28%'>Monthly</th>
                <th rowspan="2" style='width: 7%'>Balance</th>
            </tr>
            <tr>
                <th style='width: 7%'>Type</th>
                <th style='width: 7%'>Opening</th>
                <th style='width: 7%'>Debit</th>
                <th style='width: 7%'>Credit</th>
                <th style='width: 7%'>Type</th>
                <th style='width: 7%'>Opening</th>
                <th style='width: 7%'>Debit</th>
                <th style='width: 7%'>Credit</th>
            </tr>
        </tfoot>
    </table>

</div>

</body>
</html>
