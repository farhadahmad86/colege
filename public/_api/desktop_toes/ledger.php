<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../_db/database.php");
require_once("../functions/db_functions.php");
require_once("../functions/api_functions.php");

$up = isset($_REQUEST['up']) ? $database->escape_value($_REQUEST['up']) : "";
$uid = isset($_REQUEST['uid']) ? $database->escape_value($_REQUEST['uid']) : "";

if($up==""||$uid==""){
    dieWithError("Upload API Authentication Failed!", null);
}else{
    $lgnUser = getUser($uid);

    if ($lgnUser->found == true) {
        $upwd = $lgnUser->properties->user_password;
        if(!password_verify($up,$upwd)){
            dieWithError("User Authentication Failed!", null);
        }
    }else{
        dieWithError("User Authentication Failed!", null);
    }
}

$ledger = array();

$tellerRoleId = TELLER;
$superAdminId = SUPER_ADMIN_ID;

$userId = isset($_GET['uid']) ? $database->escape_value($_GET['uid']) : 0;

$tellerCashAccountUID = 0;

if ($userId == $superAdminId) {
    dieWithError("Super Admin does'nt need to transfer cash or view ledger from desktop!", $database);
} else {

    $loginUser = getUser($userId);

    if ($loginUser->found == true) {
        $loginUserRole = $loginUser->properties->user_role_id;

        if ($loginUserRole == $tellerRoleId) {

            $tellerCashAccountUID = $loginUser->properties->user_teller_cash_account_uid;

            if ($tellerCashAccountUID == 0) {
                dieWithError("You does'nt have any cash account!", $database);
            }

        } else {
            dieWithError("Only teller allow to see ledger from desktop!", $database);
        }

    } else {
        dieWithError("User not found!!", $database);
    }

}

$dayEnd = getOpenDayEnd();
$dayEndId = $dayEnd->id;
$dayEndDate = $dayEnd->date;

$query = "SELECT bal_id as id, bal_datetime as date_time, bal_remarks as remarks, bal_detail_remarks as detail_remarks, 
                bal_voucher_number as voucher_number, bal_dr as dr, bal_cr as cr, bal_total as total 
              FROM financials_balances 
              WHERE bal_account_id = $tellerCashAccountUID AND bal_day_end_id = $dayEndId
              ORDER BY bal_id;";

$result = $database->query($query);

if ($result) {

    while ($item = $database->fetch_array($result)) {

        $ledger[] = array(

            //'ID' => $item['id'],
            'Voucher Number' => $item['voucher_number'],
            'Remarks' => $item['remarks'],
            'Detail Remarks' => $item['detail_remarks'],
            'Debit' => $item['dr'],
            'Credit' => $item['cr'],
            'Total' => $item['total'],
            'Date Time' => $item['date_time']

        );

    }

}

echo json_encode($ledger);

if (isset($database)) {
    $database->close_connection();
}
