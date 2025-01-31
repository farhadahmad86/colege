<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 12-Jun-20
 * Time: 4:06 PM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../_db/database.php");

?>

<html>
<head>

    <title>Single Entry Module</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <script>

        function togglePassword() {
            let password = document.getElementById("password");
            if (password.type === "password") {
                password.type = "text";
            } else {
                password.type = "password";
            }
        }

        function togglePassword2() {
            let showPass = document.getElementById("showPass");
            let password = document.getElementById("password");
            if (password.type === "password") {
                password.type = "text";
                showPass.checked = true;
            } else {
                password.type = "password";
                showPass.checked = false;
            }
        }

        $(function () {

            $('form').on('submit', function (e) {

                e.preventDefault();

                let accountError = $("#account_error");

                let accountUid = $("#account_uid option:selected").val();
                if (accountUid === '-') {
                    accountError.removeClass("hide");
                    return;
                } else {
                    accountError.addClass("hide");
                }

                $.ajax({
                    type: 'post',
                    url: 'single_entry_submit.php',
                    data: $('form').serialize(),
                    success: function (data) {
                        let values = data.split(';');

                        if (values[0] == 1) {

                            $("#error").addClass("hide");
                            $("#success").removeClass("hide");

                            $("#success").html(values[1]);

                            $('form').reset();

                        } else {

                            $("#success").addClass("hide");
                            $("#error").removeClass("hide");

                            $("#error").html(values[1]);

                        }

                    }
                });

            });

        });
    </script>

    <style>

        optgroup {
            font-size: 16px;
        }

        .red {
            color: red;
        }

        .hide {
            display: none;
        }

        .text {
            font-weight: 700;
        }

    </style>

</head>
<body>

<h2 style="text-align: center; padding-top: 22px">Single Entry Module</h2>

<div class="container" style="margin: auto; padding: 16px">

    <form id="entry_form" method="post" action="./single_entry_submit.php">

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required />
            </div>
            <div class="form-group col-md-6">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required />
                <input id="showPass" type="checkbox" style="cursor: pointer" onclick="togglePassword(this)" /><span style="cursor: pointer" onclick="togglePassword2()">&nbsp;Show Password</span>
            </div>
        </div>

        <div style="padding-top: 50px !important;">
            <br />
            <br />
        </div>

        <div class="form-group">
            <label for="account_uid">Account:</label>
            <select class="form-control" id="account_uid" name="account_uid" required>
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

    while ($acc = $database->fetch_assoc($result)) {
        echo '<option value="' . $acc['account_uid'] . '">' . $acc['account_uid'] . ' - ' . $acc['account_name'] . '</option>';
    }

    echo '</optgroup><optgroup></optgroup>';

    $query = "SELECT account_uid, account_name 
                FROM financials_accounts
                WHERE account_uid LIKE '$liability%'
                ORDER BY account_name;";
    $result = $database->query($query);

    echo '<optgroup label="Liability">';

    while ($acc = $database->fetch_assoc($result)) {
        echo '<option value="' . $acc['account_uid'] . '">' . $acc['account_uid'] . ' - ' . $acc['account_name'] . '</option>';
    }

    echo '</optgroup><optgroup></optgroup>';

    $query = "SELECT account_uid, account_name 
                FROM financials_accounts
                WHERE account_uid LIKE '$revenue%'
                ORDER BY account_name;";
    $result = $database->query($query);

    echo '<optgroup label="Revenue">';

    while ($acc = $database->fetch_assoc($result)) {
        echo '<option value="' . $acc['account_uid'] . '">' . $acc['account_uid'] . ' - ' . $acc['account_name'] . '</option>';
    }

    echo '</optgroup><optgroup></optgroup>';

    $query = "SELECT account_uid, account_name 
                FROM financials_accounts
                WHERE account_uid LIKE '$expenses%'
                ORDER BY account_name;";
    $result = $database->query($query);

    echo '<optgroup label="Expenses">';

    while ($acc = $database->fetch_assoc($result)) {
        echo '<option value="' . $acc['account_uid'] . '">' . $acc['account_uid'] . ' - ' . $acc['account_name'] . '</option>';
    }

    echo '</optgroup><optgroup></optgroup>';

    $query = "SELECT account_uid, account_name 
                FROM financials_accounts
                WHERE account_uid LIKE '$equity%'
                ORDER BY account_name;";
    $result = $database->query($query);

    echo '<optgroup label="Equity">';

    while ($acc = $database->fetch_assoc($result)) {
        echo '<option value="' . $acc['account_uid'] . '">' . $acc['account_uid'] . ' - ' . $acc['account_name'] . '</option>';
    }

    echo '</optgroup>';

?>


                <optgroup></optgroup>
            </select>
            <label id="account_error" class="red hide">Please select a account first!</label>
        </div>

        <label class="radio-inline text"><input type="radio" value="1" name="debit_credit" checked>Debit</label>
        <label class="radio-inline text"><input type="radio" value="2" name="debit_credit">Credit</label>
        <br />
        <br />
        <div class="form-group">
            <label for="amount">Amount:</label>
            <input type="text" class="form-control" id="amount" placeholder="Amount" name="amount" required>
        </div>
        <div class="form-group">
            <label for="remarks">Remarks:</label>
            <textarea class="form-control" rows="3" id="remarks" name="remarks" required></textarea>
        </div>
        <div class="form-group">
            <label class="form-check-input text"><input type="checkbox" value="1" name="force_submit">&nbsp;&nbsp;Force Submit</label>
        </div>
        <input type="hidden" name="se">
        <button type="reset" class="btn btn-default">Reset</button>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <br />

    <h4 id="error" style="background-color: red; color: white; padding: 16px" class="hide"></h4>
    <h4 id="success" style="background-color: green; color: white; padding: 16px" class="hide"></h4>

</div>

</body>
</html>
