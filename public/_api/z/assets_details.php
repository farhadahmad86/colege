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

    <title>Fixed Assets Details</title>

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

<h2 style="text-align: center; padding-top: 22px">Fixed Assets Details</h2>

<div style="margin: auto; padding: 16px">

    <table id="dataTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th style='width: 3%'>#</th>
                <th style='width: 3%; display: none;'>UIDs</th>
                <th>Account Title</th>
                <th style='width: 7%'>Starting Value</th>
                <th style='width: 7%'>Ending Value</th>
                <th style='width: 7%'>Life</th>
                <th style='width: 7%'>Dep. %</th>
                <th style='width: 7%'>Method</th>
                <th style='width: 7%'>Period</th>
                <th style='width: 7%'>Entries</th>
                <th style='width: 7%'>Assets</th>
                <th style='width: 7%'>Acc. Dep</th>
                <th style='width: 7%'>Book Value</th>
                <th style='width: 7%'>Actual Value</th>
            </tr>
        </thead>
        <tbody>

        <?php

        $query1 = "SELECT fa_link_account_uids, fa_account_name, fa_price, fa_residual_value, fa_useful_life_year, fa_useful_life_month, fa_useful_life_day, 
                        fa_dep_percentage_day, fa_dep_percentage_month, fa_dep_percentage_year, fa_dep_period, 
                        fa_dep_entries, fa_book_value, fa_method
            FROM financials_fixed_asset
            WHERE fa_posting = 1;";

        $result1 = $database->query($query1);

        if ($result1) {

            $serialNumber = 0;

            while ($acc = $database->fetch_assoc($result1)) {

                $serialNumber++;

                $accIds = $acc['fa_link_account_uids'];

                $accountUIDs = explode(',', $accIds);

                $assetOpBalance = getAccountOpeningBalance($accountUIDs[0])->balance;
                $assetBalance = getAccountClosingBalance($accountUIDs[0])->balance;

                $accDepOpBalance = getAccountOpeningBalance($accountUIDs[1])->balance;
                $accDepBalance = getAccountClosingBalance($accountUIDs[1])->balance;

                $depExpBalance = getAccountClosingBalance($accountUIDs[2])->balance;

                $accName = $acc['fa_account_name'];
                $accStarting = $acc['fa_price'];
                $accEnding = $acc['fa_residual_value'];
                $lifeDay = $acc['fa_useful_life_day'];
                $lifeMonth = $acc['fa_useful_life_month'];
                $lifeYear = $acc['fa_useful_life_year'];
                $depDaily = $acc['fa_dep_percentage_day'];
                $depMonthly = $acc['fa_dep_percentage_month'];
                $depYearly = $acc['fa_dep_percentage_year'];
                $period = $acc['fa_dep_period'];

                if ($period == 1) {
                    $period = "Annually";
                } elseif ($period == 2) {
                    $period = "Monthly";
                } elseif ($period == 3) {
                    $period = "Daily";
                } else {
                    $period = "-";
                }

                $entries = $acc['fa_dep_entries'];
                $bookValue = $acc['fa_book_value'];
                $method = $acc['fa_method'];

                if ($method == 1) {
                    $method = "SLM";
                } elseif ($method == 2) {
                    $method = "RBM";
                } else {
                    $method = "-";
                }

                $actualValue = $assetBalance - $accDepBalance;

                $accStarting = $accStarting != 0 ? number_format($accStarting, 2) : '-';
                $accEnding = $accEnding != 0 ? number_format($accEnding, 2) : '-';
                $bookValue = $bookValue != 0 ? number_format($bookValue, 2) : '-';
                $assetOpBalance = $assetOpBalance != 0 ? number_format($assetOpBalance, 2) : '-';
                $assetBalance = $assetBalance != 0 ? number_format($assetBalance, 2) : '-';
                $accDepOpBalance = $accDepOpBalance != 0 ? number_format($accDepOpBalance, 2) : '-';
                $accDepBalance = $accDepBalance != 0 ? number_format($accDepBalance, 2) : '-';
                $depExpBalance = $depExpBalance != 0 ? number_format($depExpBalance, 2) : '-';

                $actualValue = $actualValue != 0 ? number_format($actualValue, 2) : '-';

                echo "
                    <tr>
                        <td>$serialNumber</td>
                        <td style='display: none;'>$accIds</td>
                        <td>$accName</td>
                        <td style='text-align: center'>$accStarting</td>
                        <td style='text-align: center'>$accEnding</td>
                        <td style='text-align: center'>$lifeDay<br />$lifeMonth<br />$lifeYear</td>
                        <td style='text-align: center'>$depDaily<br />$depMonthly<br />$depYearly</td>
                        <td style='text-align: center'>$method</td>
                        <td style='text-align: center'>$period</td>
                        <td style='text-align: center'>$entries</td>
                        <td style='text-align: center'>$assetOpBalance<br />$assetBalance</td>
                        <td style='text-align: center'>$accDepOpBalance<br />$accDepBalance</td>
                        <td style='text-align: center'>$bookValue</td>
                        <td style='text-align: center'>$actualValue</td>
                    </tr>
                ";
            }

        }

        ?>

        </tbody>
        <tfoot>
            <tr>
                <th style='width: 3%'>#</th>
                <th style='width: 3%; display: none;'>UIDs</th>
                <th>Account Title</th>
                <th style='width: 7%'>Starting Value</th>
                <th style='width: 7%'>Ending Value</th>
                <th style='width: 7%'>Life</th>
                <th style='width: 7%'>Dep. %</th>
                <th style='width: 7%'>Method</th>
                <th style='width: 7%'>Period</th>
                <th style='width: 7%'>Entries</th>
                <th style='width: 7%'>Assets</th>
                <th style='width: 7%'>Acc. Dep</th>
                <th style='width: 7%'>Book Value</th>
                <th style='width: 7%'>Actual Value</th>
            </tr>
        </tfoot>
    </table>

</div>

</body>
</html
