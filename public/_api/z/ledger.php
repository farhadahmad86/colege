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

$limit = isset($_REQUEST['limit']) ? $database->escape_value($_REQUEST['limit']) : 50;
$offset = isset($_REQUEST['offset']) ? $database->escape_value($_REQUEST['offset']) : -1;

$account = isset($_REQUEST['account']) ? $database->escape_value($_REQUEST['account']) : "";
$accountName = isset($_REQUEST['name']) ? $database->escape_value($_REQUEST['name']) : "";
$accountUID = isset($_REQUEST['uid']) ? $database->escape_value($_REQUEST['uid']) : "";
$startDate = isset($_REQUEST['date_from']) ? $database->escape_value($_REQUEST['date_from']) : "";
$endDate = isset($_REQUEST['date_to']) ? $database->escape_value($_REQUEST['date_to']) : "";

if ($account != "" && $account != "-") {
    $acc = explode(" : ", $account);
    $accountUID = $acc[0];
    $accountName = $acc[1];
} else {
    if ($accountUID != "" && $accountUID != "-" && $accountName != "" && $accountName != "-") {
        $account = $accountUID . " : " . $accountName;
    }
}

?>

<html>
<head>

    <title>Ledger: <?php echo $accountName; ?></title>


    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <style>
        .alignment {
            display: inline-block;
            float: left;
        }

        .alignment.date-align {
            width: 70%;
        }

        .alignment.arrow-align {
            margin-left: 30px;
        }
    </style>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable( {
                "scrollX": true,
                stateSave: true,
                "select": "single",
                "lengthMenu": [[15, 25, 50, 100, 250, 500, -1], [15, 25, 50, 100, 250, 500, "All"]],
                "pagingType": "full_numbers",
                dom: 'lfrtip'
            } );
        } );

        function same() {
            let from = document.getElementById("date_from");
            let to = document.getElementById("date_to");

            to.value = from.value;
        }
    </script>

</head>
<body>

<h2 style="text-align: center; padding-top: 22px">Ledger: <?php echo $accountName; ?></h2>

<div class="container" style="margin: auto; padding: 16px">
    <form id="entry_form" method="post" action="./ledger.php">
        <div class="form-row">

            <div class="form-group col-md-4">
                <label for="account">Account:</label>
                <select class="form-control" id="account_uid" name="account" required>
                    <optgroup>
                        <option value="-" style="display: none">Select Account</option>
                    </optgroup>

                    <?php

                        $asset = ASSETS;
                        $liability = LIABILITIES;
                        $revenue = REVENUES;
                        $expenses = EXPENSES;
                        $equity = EQUITY;

                        $query = "SELECT account_uid, account_name 
                                    FROM financials_accounts
                                    WHERE account_uid LIKE '$asset%'
                                    ORDER BY account_name;";
                        $result = $database->query($query);

                        echo '<optgroup label="Assets">';

                        $selected = '';
                        while ($acc = $database->fetch_assoc($result)) {
                            if ($account == $acc['account_uid'] . " : " . $acc['account_name']) {
                                $selected = 'selected';
                            } else {
                                $selected = '';
                            }
                            echo '<option value="' . $acc['account_uid'] . ' : ' . $acc['account_name'] . '" ' . $selected . '>' . $acc['account_uid'] . ' : ' . $acc['account_name'] . '</option>';
                        }

                        echo '</optgroup><optgroup></optgroup>';

                        $query = "SELECT account_uid, account_name 
                                    FROM financials_accounts
                                    WHERE account_uid LIKE '$liability%'
                                    ORDER BY account_name;";
                        $result = $database->query($query);

                        echo '<optgroup label="Liability">';

                        $selected = '';
                        while ($acc = $database->fetch_assoc($result)) {
                            if ($account == $acc['account_uid'] . " : " . $acc['account_name']) {
                                $selected = 'selected';
                            } else {
                                $selected = '';
                            }
                            echo '<option value="' . $acc['account_uid'] . ' : ' . $acc['account_name'] . '" ' . $selected . '>' . $acc['account_uid'] . ' : ' . $acc['account_name'] . '</option>';
                        }

                        echo '</optgroup><optgroup></optgroup>';

                        $query = "SELECT account_uid, account_name 
                                    FROM financials_accounts
                                    WHERE account_uid LIKE '$revenue%'
                                    ORDER BY account_name;";
                        $result = $database->query($query);

                        echo '<optgroup label="Revenue">';

                        $selected = '';
                        while ($acc = $database->fetch_assoc($result)) {
                            if ($account == $acc['account_uid'] . " : " . $acc['account_name']) {
                                $selected = 'selected';
                            } else {
                                $selected = '';
                            }
                            echo '<option value="' . $acc['account_uid'] . ' : ' . $acc['account_name'] . '" ' . $selected . '>' . $acc['account_uid'] . ' : ' . $acc['account_name'] . '</option>';
                        }

                        echo '</optgroup><optgroup></optgroup>';

                        $query = "SELECT account_uid, account_name 
                                    FROM financials_accounts
                                    WHERE account_uid LIKE '$expenses%'
                                    ORDER BY account_name;";
                        $result = $database->query($query);

                        echo '<optgroup label="Expenses">';

                        $selected = '';
                        while ($acc = $database->fetch_assoc($result)) {
                            if ($account == $acc['account_uid'] . " : " . $acc['account_name']) {
                                $selected = 'selected';
                            } else {
                                $selected = '';
                            }
                            echo '<option value="' . $acc['account_uid'] . ' : ' . $acc['account_name'] . '" ' . $selected . '>' . $acc['account_uid'] . ' : ' . $acc['account_name'] . '</option>';
                        }

                        echo '</optgroup><optgroup></optgroup>';

                        $query = "SELECT account_uid, account_name 
                                    FROM financials_accounts
                                    WHERE account_uid LIKE '$equity%'
                                    ORDER BY account_name;";
                        $result = $database->query($query);

                        echo '<optgroup label="Equity">';

                        $selected = '';
                        while ($acc = $database->fetch_assoc($result)) {
                            if ($account == $acc['account_uid'] . " : " . $acc['account_name']) {
                                $selected = 'selected';
                            } else {
                                $selected = '';
                            }
                            echo '<option value="' . $acc['account_uid'] . ' : ' . $acc['account_name'] . '" ' . $selected . '>' . $acc['account_uid'] . ' : ' . $acc['account_name'] . '</option>';
                        }

                        echo '</optgroup>';

                    ?>

                    <optgroup></optgroup>
                </select>
                <label id="account_error" class="red hide">Please select a account first!</label>
            </div>

            <div class="form-group col-md-3">
                <div class="alignment date-align">
                    <label for="date_from">Date (To): </label>
                    <input type="date" class="form-control" id="date_from" name="date_from" placeholder="Start Date"value="<?php echo $startDate; ?>" />
                </div>
                <div class="alignment arrow-align">
                    <div style="padding-top: 25px !important;"></div>
                    <button type="button" onclick="same()" class="btn-small btn">&gt;&gt;</button>
                </div>
            </div>

            <div class="form-group col-md-2">
                <label for="date_to">Date (From): </label>
                <input type="date" class="form-control" id="date_to" name="date_to" placeholder="End Date" value="<?php echo $endDate; ?>"/>
            </div>

            <div class="form-group col-md-1">
                <label for="limit">Limit: </label>
                <input type="number" class="form-control" id="limit" name="limit" placeholder="Entries Limit" value="<?php echo $limit; ?>"/>
            </div>

            <div class="form-group col-md-2">
                <div style="padding-top: 25px !important;"></div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </div>
    </form>
</div>

<div style="margin: auto; padding: 16px">

    <table id="dataTable" class="display" style="width:100%">
        <thead>
        <tr>
            <th style='width: 3%'>ID</th>
            <th style='width: 8%'>Time</th>
            <th style='width: 10%'>Type</th>
            <th style='width: 8%'>Code</th>
            <th style='width: 10%'>Remarks</th>
            <th style='width: 10%'>D-Remarks</th>
            <th style='width: 8%'>Debit</th>
            <th style='width: 8%'>Credit</th>
            <th style='width: 8%'>Balance</th>
        </tr>
        </thead>
        <tbody>

        <?php

        $searchQuery = "WHERE bal_id > 0";
        $limitAndOrder = "ORDER BY bal_id LIMIT $limit";

        if ($accountUID != "" && $accountUID > 0) {
            $searchQuery .= " AND bal_account_id = $accountUID";
        } else {
            $limitAndOrder = " ORDER BY bal_id DESC LIMIT 50";
        }

        if ($startDate != "" && $endDate != "") {
            try {
                $to = new DateTime($startDate);
                $startDate = $to->format(DB_DATE_STAMP_FORMAT);

                $from = new DateTime($endDate);
                $endDate = $from->format(DB_DATE_STAMP_FORMAT);

                $searchQuery .= " AND (bal_day_end_date >= '$startDate' AND bal_day_end_date <= '$endDate')";
            } catch (Exception $e) {}
        } else {
            $oneWeekBefore = new DateTime();
            $oneWeekBefore = $oneWeekBefore->modify('-7 day');
            $oneWeekBefore = $oneWeekBefore->format(DB_DATE_STAMP_FORMAT);

            $searchQuery .= " AND bal_day_end_date >= '$oneWeekBefore'";
            $limitAndOrder = " ORDER BY bal_id DESC LIMIT $limit";
        }

        $query1 = "SELECT
                        bal_id, bal_voucher_number, bal_transaction_type, bal_remarks, bal_dr, bal_cr, bal_total, bal_datetime, bal_detail_remarks, 
                        bal_user_id, bal_day_end_id, bal_day_end_date
                    FROM financials_balances 
                    $searchQuery
                    $limitAndOrder;";

        $result1 = $database->query($query1);

        if ($result1) {

            while ($data = $database->fetch_assoc($result1)) {

                $id = $data['bal_id'];
                $time = $data['bal_datetime'];
                $dayEndId = $data['bal_day_end_id'];
                $dayEndDate = $data['bal_day_end_date'];
                $time = $data['bal_datetime'];
                $voucherCode = $data['bal_voucher_number'];
                $type = $data['bal_transaction_type'];
                $remarks = $data['bal_remarks'];
                $detailsRemarks = $data['bal_detail_remarks'];
                $debit = $data['bal_dr'];
                $credit = $data['bal_cr'];
                $balance = $data['bal_total'];

                $link = "";
                if ($voucherCode != "") {
                    $link = "<a href='" . $subDomain . "/public/_api/view/voucher.php?format=1&vn=" . $voucherCode . "' target='_blank'>$voucherCode</a>";
                    $link .= "&nbsp;";
                    $link .= "<a href='" . $subDomain . "/public/_api/view/invoice.php?format=1&in=" . $voucherCode . "' target='_blank'>$voucherCode</a>";
                }

                $debit = $debit != 0 ? number_format($debit, 2) : '';
                $credit = $credit != 0 ? number_format($credit, 2) : '';
                $balance = $balance != 0 ? number_format($balance, 2) : '0.00';

                $dayEnd = $dayEndId . ':' . $dayEndDate;
                $timeStamp = $dayEnd . "<br />" . $time;

                echo "
                    <tr>
                        <td>$id</td>
                        <td>$timeStamp</td>
                        <td>$type</td>
                        <td>$link</td>
                        <td>$remarks</td>
                        <td>$detailsRemarks</td>
                        <td style='text-align: right'>$debit</td>
                        <td style='text-align: right'>$credit</td>
                        <td style='text-align: right'>$balance</td>
                    </tr>
                ";

            }

        }

        ?>

        </tbody>
        <tfoot>
            <tr>
                <th style='width: 3%'>ID</th>
                <th style='width: 8%'>Time</th>
                <th style='width: 10%'>Type</th>
                <th style='width: 8%'>Code</th>
                <th style='width: 10%'>Remarks</th>
                <th style='width: 10%'>D-Remarks</th>
                <th style='width: 8%'>Debit</th>
                <th style='width: 8%'>Credit</th>
                <th style='width: 8%'>Balance</th>
            </tr>
        </tfoot>
    </table>

</div>

</body>
</html>