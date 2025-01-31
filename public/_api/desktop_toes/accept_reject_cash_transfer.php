<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 22-Apr-19
 * Time: 5:38 PM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../_db/database.php");
require_once("../functions/db_functions.php");
$up = isset($_REQUEST['up']) ? $database->escape_value($_REQUEST['up']) : "";
$uid = isset($_REQUEST['uid']) ? $database->escape_value($_REQUEST['uid']) : "";

if($up==""||$uid==""){
    dieWithError("API Authentication Failed!", null);
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

$responseToDesktop = array('success' => 0, 'code' => 0, 'message' => 'Something went wrong, Cannot save data! Please check and try again.');

if (isset($_REQUEST['id']) && isset($_REQUEST['ar']) && isset($_REQUEST['reason'])) {

    $dayEnd = getOpenDayEnd();
    $dayEndId = $dayEnd->id;
    $dayEndDate = $dayEnd->date;

    //$cashTransfer = $_POST['cash_transfer'];

    //$cashTransfer = json_decode($cashTransfer);

    $id = $database->escape_value($_REQUEST['id']);
    $senderId = $database->escape_value($_REQUEST['sender_id']);
    $receiverId = $database->escape_value($_REQUEST['receiver_id']);
    $amount = $database->escape_value($_REQUEST['amount']);

    $approveReject = $database->escape_value($_REQUEST['ar']);
    $reason = $database->escape_value($_REQUEST['reason']);
//echo "$id,$senderId,$receiverId,$amount,$approveReject,$reason";
    
    $rollBack = false;
    $database->begin_trans();

    $query = "UPDATE financials_cash_transfer SET ct_status = '$approveReject', ct_reason = '$reason', ct_receive_datetime = current_timestamp WHERE ct_id = $id;";

    $responseToDesktop['message'] = $query;
    $responseToDesktop['message'] .= " >>> ";

    $result = $database->query($query);

    if ($result) {

        $cashInHandUID = CASH_ACCOUNT_UID;

        $senderCashAccountUID = 0;
        $senderCashAccountName = "";
        $receiverCashAccountUID = 0;
        $receiverCashAccountName = "";

        $sender = getUser($senderId);
        $receiver = getUser($receiverId);

        $senderRoleId = $sender->properties->user_role_id;
        $receiverRoleId = $receiver->properties->user_role_id;

        $tellerRoleId = TELLER;
        $cashierRoleId = CASHIER;

        if ($senderRoleId == $tellerRoleId) {
            $ac1 = getAccount($sender->properties->user_teller_cash_account_uid);
            $senderCashAccountUID = $ac1->properties->account_uid;
            $senderCashAccountName = $ac1->properties->account_name;
        } else {
            $senderCashAccountUID = $cashInHandUID;
            $senderCashAccountName = "Cash In Hand";
        }

        if ($receiverRoleId == $tellerRoleId) {
            $ac2 = getAccount($receiver->properties->user_teller_cash_account_uid);
            $receiverCashAccountUID = $ac2->properties->account_uid;
            $receiverCashAccountName = $ac2->properties->account_name;
        } else {
            $receiverCashAccountUID = $cashInHandUID;
            $receiverCashAccountName = "Cash In Hand";
        }

        $remarks = CASH_TRANSFER_CODE . $id;
        $detailRemarks = $senderCashAccountName . ' TO ' . $receiverCashAccountName . ' @ ' . $amount;

        if ($approveReject == 'RECEIVED') {

            $JVQuery = "INSERT INTO financials_journal_voucher (jv_total_dr, jv_total_cr, jv_remarks, jv_day_end_id, jv_day_end_date, jv_createdby, jv_detail_remarks) 
                            VALUES ($amount, $amount, '$remarks', $dayEndId, '$dayEndDate', $senderId, '$detailRemarks');";

            $responseToDesktop['message'] .= $JVQuery;
            $responseToDesktop['message'] .= " >>> ";

            $JVResult = $database->query($JVQuery);

            if ($JVResult) {

                $JVInsertedId = $database->inserted_id();

                $JVItemsQuery = "INSERT INTO financials_journal_voucher_items (jvi_journal_voucher_id, jvi_account_id, jvi_account_name, jvi_amount, jvi_type, jvi_remarks) 
                                      VALUES ($JVInsertedId, $receiverCashAccountUID, '$receiverCashAccountName', $amount, 'Dr', '$remarks'), 
                                      ($JVInsertedId, $senderCashAccountUID, '$senderCashAccountName', $amount, 'Cr', '$remarks');";

                $responseToDesktop['message'] .= $JVItemsQuery;
                $responseToDesktop['message'] .= " >>> ";

                $JVItemsResult = $database->query($JVItemsQuery);

                if ($JVItemsResult) {

                    $transactionType = JV;

                    $transactionQuery = "INSERT INTO financials_transactions (trans_type, trans_dr, trans_cr, trans_amount, trans_notes, trans_entry_id)
                              VALUES ($transactionType, $receiverCashAccountUID, 0, $amount, 'JOURNAL VOUCHER', $JVInsertedId), 
                              ($transactionType, 0, $senderCashAccountUID, $amount, 'JOURNAL VOUCHER', $JVInsertedId);";

                    $responseToDesktop['message'] .= $transactionQuery;
                    $responseToDesktop['message'] .= " >>> ";

                    $transactionResult = $database->query($transactionQuery);

                    if ($transactionResult) {

                        $transactionLastInsertedId = $database->inserted_id();

                        $voucherCode = JOURNAL_VOUCHER_CODE . $JVInsertedId;

                        $senderAccountBalance = getAccountClosingBalance($senderCashAccountUID)->balance;
                        $receiverAccountBalance = getAccountClosingBalance($receiverCashAccountUID)->balance;

                        $senderNewAccountBalance = $senderAccountBalance - (double)$amount;
                        $receiverNewAccountBalance = $receiverAccountBalance + (double)$amount;

                        $balanceQuery = "INSERT INTO financials_balances (bal_account_id, bal_transaction_type, bal_remarks, bal_dr, bal_cr, bal_total, bal_transaction_id, bal_day_end_id, bal_day_end_date, bal_detail_remarks, bal_voucher_number, bal_user_id) 
                            VALUES ($receiverCashAccountUID, 'JOURNAL VOUCHER', '$remarks', $amount, 0, $receiverNewAccountBalance, $transactionLastInsertedId, $dayEndId, '$dayEndDate', '$detailRemarks', '$voucherCode', $receiverId), 
                            ($senderCashAccountUID, 'JOURNAL VOUCHER', '$remarks', 0, $amount, $senderNewAccountBalance, $transactionLastInsertedId, $dayEndId, '$dayEndDate', '$detailRemarks', '$voucherCode', $receiverId);";

                        $responseToDesktop['message'] .= $balanceQuery;
                        $responseToDesktop['message'] .= " >>> ";

                        $balanceResult = $database->query($balanceQuery);

                        if (!$balanceResult) {
                            $rollBack = true;
                            $database->rollBack();
                        }

                    } else {
                        $rollBack = true;
                        $database->rollBack();
                    }

                } else {
                    $rollBack = true;
                    $database->rollBack();
                }

            } else {
                $rollBack = true;
                $database->rollBack();
            }

        }

    } else {
        $rollBack = true;
        $database->rollBack();
    }

    if(!$rollBack) {
        $responseToDesktop['code'] = 1;
        $database->commit();
        $responseToDesktop['message'] = "Cash Transferred.";
    }

}

$responseToDesktop['success'] = 1;
echo json_encode($responseToDesktop);

if (isset($database)) {
    $database->close_connection();
}

