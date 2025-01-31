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
require_once("../functions/functions.php");

?>

<html>
<head>

    <title>Capital Details</title>

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

<h2 style="text-align: center; padding-top: 22px">Capital Details</h2>

<div style="margin: auto; padding: 16px">

    <table id="dataTable" class="display" style="width:100%">
        <thead>
        <tr>
            <th style='width: 3%'>#</th>
            <th>User</th>
            <th style='width: 7%'>Nature</th>
            <th style='width: 7%'>Initial Capital</th>
            <th style='width: 7%'>Capital</th>
            <th style='width: 7%'>Profit & Loss</th>
            <th style='width: 7%'>Drawing</th>
            <th style='width: 7%'>Reserve</th>
            <th style='width: 7%'>Total Capital</th>
            <th style='width: 7%'>System Ratio</th>
            <th style='width: 7%'>Profit Ratio</th>
            <th style='width: 7%'>Loss Ratio</th>
            <th style='width: 7%'>Remaining Profit (E)</th>
            <th style='width: 7%'>Remaining Loss (E)</th>
        </tr>
        </thead>
        <tbody>

        <?php

        $query1 = "SELECT cr_parent_account_uid, cr_capital_account_uid, cr_profit_loss_account_uid, cr_drawing_account_uid, cr_reserve_account_uid, cr_user_id, user_name, cr_initial_capital, 
                cr_system_ratio, cr_is_custom_profit, cr_is_custom_loss, cr_fixed_profit_per, cr_fixed_loss_per, cr_custom_profit_ratio, cr_custom_loss_ratio, 
                cr_remaning_profit_division, cr_remaning_loss_division, cr_partner_nature
            FROM financials_capital_register
            JOIN financials_users ON cr_user_id = user_id";
        $result1 = $database->query($query1);

        if ($result1) {

            $DIVIDE_TO_ALL_EQUALLY = 1;
            $DIVIDE_TO_ALL_OWNERS_EQUALLY = 2;
            $DIVIDE_TO_ALL_INVESTORS_EQUALLY = 3;
            $DIVIDE_TO_ALL_ACTIVE_PARTNERS_EQUALLY = 4;
            $DIVIDE_TO_ALL_SLEEPING_PARTNERS_EQUALLY = 5;

            $totalInitCap = 0;
            $totalAllCap = 0;
            $totalAllPnL = 0;
            $totalAllDrawing = 0;
            $totalAllReserve = 0;
            $totalSysRatio = 0;

            $serialNumber = 0;

            $systemsCapital = 0;
            $totalRegisteredCapitals = $database->num_rows($result1);;

            $capitalsArray = array();

            while ($acc = $database->fetch_assoc($result1)) {

                $serialNumber++;

                $capitalUID = $acc['cr_capital_account_uid'];
                $pnlUID = $acc['cr_profit_loss_account_uid'];
                $drawingUID = $acc['cr_drawing_account_uid'];
                $reserveUID = $acc['cr_reserve_account_uid'];

                $capitalBalance = getAccountClosingBalance($capitalUID)->balance;
                $pnlBalance = getAccountClosingBalance($pnlUID)->balance;
                $drawingBalance = getAccountClosingBalance($drawingUID)->balance;
                $reserveBalance = getAccountClosingBalance($reserveUID)->balance;

                $parentUID = $acc['cr_parent_account_uid'];
                $userId = $acc['cr_user_id'];
                $userName = $acc['user_name'];
                $nature = $acc['cr_partner_nature'];
                $initialCapital = $acc['cr_initial_capital'];
                $systemRatio = $acc['cr_system_ratio'];
                $isCustomProfit = $acc['cr_is_custom_profit'];
                $isCustomLoss = $acc['cr_is_custom_loss'];
                $fixedProfitPer = $acc['cr_fixed_profit_per'];
                $fixedLossPer = $acc['cr_fixed_loss_per'];
                $customProfitRatio = $acc['cr_custom_profit_ratio'];
                $customLossRatio = $acc['cr_custom_loss_ratio'];
                $remainingProfitDivision = $acc['cr_remaning_profit_division'];
                $remainingLossDivision = $acc['cr_remaning_loss_division'];

                $totalCapital = ((double)$capitalBalance + (double)$pnlBalance + (double)$reserveBalance) - $drawingBalance;
                $systemsCapital += $totalCapital;
//                $totalCapital = $totalCapital != 0 ? number_format($totalCapital, 2) : '-';

                if ($isCustomProfit == 0) {
                    $customProfitRatio = $systemRatio;
                }

                if ($isCustomLoss == 0) {
                    $customLossRatio = $systemRatio;
                }

                if (startsWith($parentUID, OWNERS_EQUITY_GROUP_UID)) {
                    $type = "Owner";
                } else {
                    $type = "Investor";
                }

                $remainingProfit = "";
                $remainingLoss = "";

                if ($nature == 1) {
                    $nature = "Active";
                } else {
                    $nature = "Sleeping";
                }

                switch ($remainingProfitDivision) {
                    case $DIVIDE_TO_ALL_EQUALLY:
                        $remainingProfit = "To All";
                        break;
                    case $DIVIDE_TO_ALL_OWNERS_EQUALLY:
                        $remainingProfit = "To Owners";
                        break;
                    case $DIVIDE_TO_ALL_INVESTORS_EQUALLY:
                        $remainingProfit = "To Investors";
                        break;
                    case $DIVIDE_TO_ALL_ACTIVE_PARTNERS_EQUALLY:
                        $remainingProfit = "To Active Partners";
                        break;
                    case $DIVIDE_TO_ALL_SLEEPING_PARTNERS_EQUALLY:
                        $remainingProfit = "To Sleeping Partners";
                        break;
                    default:
                        $remainingProfit = "-";
                        break;
                }

                switch ($remainingLossDivision) {
                    case $DIVIDE_TO_ALL_EQUALLY:
                        $remainingLoss = "To All";
                        break;
                    case $DIVIDE_TO_ALL_OWNERS_EQUALLY:
                        $remainingLoss = "To Owners";
                        break;
                    case $DIVIDE_TO_ALL_INVESTORS_EQUALLY:
                        $remainingLoss = "To Investors";
                        break;
                    case $DIVIDE_TO_ALL_ACTIVE_PARTNERS_EQUALLY:
                        $remainingLoss = "To Active Partners";
                        break;
                    case $DIVIDE_TO_ALL_SLEEPING_PARTNERS_EQUALLY:
                        $remainingLoss = "To Sleeping Partners";
                        break;
                    default:
                        $remainingLoss = "-";
                        break;
                }

                $totalInitCap += $initialCapital;
                $totalAllCap += $capitalBalance;
                $totalAllPnL += $pnlBalance;
                $totalAllDrawing += $drawingBalance;
                $totalAllReserve += $reserveBalance;

                $initialCapital = $initialCapital != 0 ? number_format($initialCapital, 2) : '-';
                $capitalBalance = $capitalBalance != 0 ? number_format($capitalBalance, 2) : '-';
                $pnlBalance = $pnlBalance != 0 ? number_format($pnlBalance, 2) : '-';
                $drawingBalance = $drawingBalance != 0 ? number_format($drawingBalance, 2) : '-';
                $reserveBalance = $reserveBalance != 0 ? number_format($reserveBalance, 2) : '-';

                if ($totalRegisteredCapitals == 1) {
                    $systemRatio = 100.00;
                    $customProfitRatio = 100.00;
                    $customLossRatio = 100.00;
                }

                $capitalsArray[] = array(
                    'serial' => $serialNumber,
                    'user' => $userName,
                    'nature' => "$nature<br />$type",
                    'initialCapital' => $initialCapital,
                    'capitalBalance' => $capitalBalance,
                    'pnlBalance' => $pnlBalance,
                    'drawingBalance' => $drawingBalance,
                    'reserveBalance' => $reserveBalance,
                    'totalCapital' => $totalCapital,
                    'systemRatio' => $systemRatio,
                    'isCustomProfit' => $isCustomProfit,
                    'isCustomLoss' => $isCustomLoss,
                    'fixedProfitPer' => $fixedProfitPer,
                    'fixedLossPer' => $fixedLossPer,
                    'customProfitRatio' => $customProfitRatio,
                    'customLossRatio' => $customLossRatio,
                    'remainingProfit' => $remainingProfit,
                    'remainingLoss' => $remainingLoss,
                );

            }

        }


        foreach ($capitalsArray as $cap) {
            $cap = (object)$cap;

            $systemRatio = ($cap->totalCapital / $systemsCapital) * 100;

            $totalSysRatio += $systemRatio;

            if ($cap->isCustomProfit) {
                $customProfitRatio = ($systemRatio * $cap->fixedProfitPer) / 100;
                $customProfitRatio = $cap->fixedProfitPer . "%<br />" . number_format($customProfitRatio, 6);
            } else {
                $customProfitRatio = $systemRatio;
                $customProfitRatio = number_format($customProfitRatio, 6);
            }

            if ($cap->isCustomLoss) {
                $customLossRatio = ($systemRatio * $cap->fixedLossPer) / 100;
                $customLossRatio = $cap->fixedLossPer . "%<br />" . number_format($customLossRatio, 6);
            } else {
                $customLossRatio = $systemRatio;
                $customLossRatio = number_format($customLossRatio, 6);
            }

            $totalCapital = $cap->totalCapital != 0 ? number_format($cap->totalCapital, 2) : '-';
            $systemRatio = number_format($systemRatio, 6);


            echo "
                <tr>
                    <td>$cap->serial</td>
                    <td>$cap->user</td>
                    <td style='text-align: center'>$cap->nature</td>
                    <td style='text-align: center'>$cap->initialCapital</td>
                    <td style='text-align: center'>$cap->capitalBalance</td>
                    <td style='text-align: center'>$cap->pnlBalance</td>
                    <td style='text-align: center'>$cap->drawingBalance</td>
                    <td style='text-align: center'>$cap->reserveBalance</td>
                    <td style='text-align: center'>$totalCapital</td>
                    <td style='text-align: center'>$systemRatio</td>
                    <td style='text-align: center'>$customProfitRatio</td>
                    <td style='text-align: center'>$customLossRatio</td>
                    <td style='text-align: center'>$cap->remainingProfit</td>
                    <td style='text-align: center'>$cap->remainingLoss</td>
                </tr>
            ";

        }

        $totalInitCap = number_format($totalInitCap, 2);
        $totalAllCap = number_format($totalAllCap, 2);
        $totalAllPnL = number_format($totalAllPnL, 2);
        $totalAllDrawing = number_format($totalAllDrawing, 2);
        $totalAllReserve = number_format($totalAllReserve, 2);
        $totalSysRatio = number_format($totalSysRatio, 2);

        ?>

        </tbody>
        <tfoot>

        <?php

        if ($totalRegisteredCapitals > 1) {

            echo "
                <tr>
                    <th>-</th>
                    <th>Total</th>
                    <th style='text-align: center'></th>
                    <th style='text-align: center'>$totalInitCap</th>
                    <th style='text-align: center'>$totalAllCap</th>
                    <th style='text-align: center'>$totalAllPnL</th>
                    <th style='text-align: center'>$totalAllDrawing</th>
                    <th style='text-align: center'>$totalAllReserve</th>
                    <th style='text-align: center'>$systemsCapital</th>
                    <th style='text-align: center'>$totalSysRatio</th>
                    <th style='text-align: center'></th>
                    <th style='text-align: center'></th>
                    <th style='text-align: center'></th>
                    <th style='text-align: center'></th>
                </tr>
            ";

        }

        ?>

            <tr>
                <th style='width: 3%'>#</th>
                <th>User</th>
                <th style='width: 7%'>Nature</th>
                <th style='width: 7%'>Initial Capital</th>
                <th style='width: 7%'>Capital</th>
                <th style='width: 7%'>Profit & Loss</th>
                <th style='width: 7%'>Drawing</th>
                <th style='width: 7%'>Reserve</th>
                <th style='width: 7%'>Total Capital</th>
                <th style='width: 7%'>System Ratio</th>
                <th style='width: 7%'>Profit Ratio</th>
                <th style='width: 7%'>Loss Ratio</th>
                <th style='width: 7%'>Remaining Profit (E)</th>
                <th style='width: 7%'>Remaining Loss (E)</th>
            </tr>
        </tfoot>
    </table>

</div>

</body>
</html>
