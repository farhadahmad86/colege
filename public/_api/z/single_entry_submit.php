<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 12-Jun-20
 * Time: 4:10 PM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../_db/database.php");
require_once("../functions/db_functions.php");


if (isset($_POST['se'])) {

    $dayEnd = getOpenDayEnd();
    if ($dayEnd->found == true) {
        $dayEndId = $dayEnd->id;
        $dayEndDate = $dayEnd->date;
    } else {

        $forceSubmit = "0";

        if (isset($_POST['force_submit'])) {
            $forceSubmit = $_POST['force_submit'];

            if ($forceSubmit != "1") {

                echo "2;Current Day End is not available for any financial transaction!!";
                $database->close_connection();
                die();

            }

        } else {

            echo "2;Current Day End is not available for any financial transaction!!";
            $database->close_connection();
            die();

        }

    }

    $username = $database->escape_value($_POST['username']);
    $password = $database->escape_value($_POST['password']);

    $accountUID = $database->escape_value($_POST['account_uid']);
    $debitCredit = $database->escape_value($_POST['debit_credit']);
    $amount = $database->escape_value($_POST['amount']);
    $remarks = $database->escape_value($_POST['remarks']);

    if ($username == null || $username == '' || $password == null || $password == '') {

        echo "2;Invalid Credentials!";
        $database->close_connection();
        die();

    } else {

        if ($username != 'admin' || $password != 'Az@012345') {

            echo "2;Invalid Credentials!";
            $database->close_connection();
            die();

        }

    }

    if ($accountUID == null || $accountUID == '' || $accountUID == '-') {

        echo "2;Please select Account!";
        $database->close_connection();
        die();

    }

    if ($amount == null || $amount == '') {

        echo "2;Invalid amount!";
        $database->close_connection();
        die();

    } elseif ((double)$amount == 0.00) {

        echo "2;Amount should be grater then 0.00";
        $database->close_connection();
        die();

    } else {

        if (!is_numeric((double)$amount)) {

            echo "2;Amount is not a number!";
            $database->close_connection();
            die();
        }

    }

    if ($remarks == null || $remarks == "") {

        echo "2;Remarks is required!";
        $database->close_connection();
        die();

    }

    if ($debitCredit == 1) {

        debit($accountUID, $amount, "SINGLE ENTRY", 0, $dbTimeStamp, 0, $dayEndId, $dayEndDate, $remarks);

        echo "1;Account UID $accountUID debited with amount: " . number_format($amount, 2);

    } else if ($debitCredit == 2) {

        credit($accountUID, $amount, "SINGLE ENTRY", 0, $dbTimeStamp, 0, $dayEndId, $dayEndDate, $remarks);

        echo "1;Account UID $accountUID credited with amount: " . number_format($amount, 2);

    } else {

        echo "2;Type Debit/Credit not found!";

    }

} else {

    echo "2;Form data not found!";

}

$database->close_connection();
