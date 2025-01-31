<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 04-Apr-20
 * Time: 1:56 PM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: false");
header('Access-Control-Allow-Methods: GET');
//header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
header('Access-Control-Max-Age: 0');
header("Cache-Control: no-cache");
header("Pragma: no-cache");
header('content-type: application/json; charset=UTF-8');

require_once("../functions/api_functions.php");

dieIfNotGet();
$jwt = dieIfNotAuth();


require_once("../_db/database.php");
require_once("../functions/db_functions.php");

$response = (object)array('success' => 0, 'code' => 0, 'message' => '', 'data' => array());

$clientParentUID = RECEIVABLE_PARENT_UID;
$supplierParentUID = PAYABLE_PARENT_UID;
$bankParentUID = BANK_PARENT_UID;
$cashParentUID = CASH_PARENT_UID;
$expenseTopParentUID = EXPENSES;
$salariesParentUID = SALARIES_EXPENSE_GROUP_UID;
$advSalariesParentUID = PREPAID_EXPENSE_PARENT_UID;
$stockAccountUID = STOCK_ACCOUNT_UID;

$wicAccountUID = WALK_IN_CUSTOMER_ACCOUNT_UID;

$tellerRoleId = TELLER;
$purchaserRoleId = PURCHASER;

$assets = ASSETS;
$expense = EXPENSES;

$assets = "$assets";
$expense = "$expense";

try {

    $ALL = 0;
    $CLIENTS = 1;
    $SUPPLIERS = 2;
    $BANKS = 3;
    $SALARIES = 4;
    $EXPANSES = 5;
    $ADV_SALARIES = 6;
    $ENTRY_ACCOUNTS = 7;
    $PARTIES_ACCOUNTS = 8;
    $SALE_PURCHASE = 9;

    $max = 10;

    if (isset($jwt)) {

        $userData = dieIfNotValidUser($jwt);
        $loginUser = $userData->user;
        $loginUserId = $userData->loginUserId;
        $currentStatus = $userData->userStatus;

        $accounts = array();

        $firstHead = isset($_GET['fh']) ? $database->escape_value($_GET['fh']) : 0;
        $secondHead = isset($_GET['sh']) ? $database->escape_value($_GET['sh']) : 0;
        $thirdHead = isset($_GET['th']) ? $database->escape_value($_GET['th']) : 0;

        $regionId = isset($_GET['rid']) ? $database->escape_value($_GET['rid']) : 0;
        $areaId = isset($_GET['aid']) ? $database->escape_value($_GET['aid']) : 0;
        $sectorId = isset($_GET['sid']) ? $database->escape_value($_GET['sid']) : 0;
        $townId = isset($_GET['tid']) ? $database->escape_value($_GET['tid']) : 0;
        $groupId = isset($_GET['gid']) ? $database->escape_value($_GET['gid']) : 0;
        $salesMan = isset($_GET['sp']) ? $database->escape_value($_GET['sp']) : 0;
        $createdBy = isset($_GET['cb']) ? $database->escape_value($_GET['cb']) : 0;

        $userId = isset($_GET['uid']) ? $database->escape_value($_GET['uid']) : 0;
        $q = isset($_GET['q']) ? $database->escape_value($_GET['q']) : '';
        $search = isset($_GET['search']) ? $database->escape_value($_GET['search']) : '';
        $type = isset($_GET['type']) ? $database->escape_value($_GET['type']) : $ALL;
        $isLedger = isset($_GET['ledger']) ? $database->escape_value($_GET['ledger']) : 0;

        $creation = isset($_GET['creation']) ? $database->escape_value($_GET['creation']) : '';
        $creationMatch = isset($_GET['creation_match']) ? $database->escape_value($_GET['creation_match']) : "1";

//        $salaryAccountNotUsed = isset($_GET['nu']) ? $database->escape_value($_GET['nu']) : 0;
        $notThisAccounts = isset($_GET['not']) ? $database->escape_value($_GET['not']) : '';

        $showStockAccount = isset($_GET['sa']) ? $database->escape_value($_GET['sa']) : 0;

        $showEnabledDisabledAll = isset($_GET['disabled']) ? $database->escape_value($_GET['disabled']) : -1;
        $showDeleted = isset($_GET['deleted']) ? $database->escape_value($_GET['deleted']) : 0;

        $searchFilter = " WHERE account_delete_status = 0 ";

        if ($showStockAccount == 0) {
            $searchFilter .= " AND account_uid != $stockAccountUID";
        }

        if ($thirdHead > 0) {
            $searchFilter .= " AND account_parent_code = $thirdHead ";
        } elseif ($secondHead > 0) {
            $searchFilter .= " AND account_parent_code LIKE '$secondHead%' ";
        } elseif ($firstHead > 0) {
            $searchFilter .= " AND account_parent_code LIKE '$firstHead%' ";
        }

        if ($regionId > 0) {
            $searchFilter .= " AND account_region_id = $regionId ";
        }

        if ($areaId > 0) {
            $searchFilter .= " AND account_area = $areaId ";
        }

        if ($sectorId > 0) {
            $searchFilter .= " AND account_sector_id = $sectorId ";
        }

//        if ($townId > 0) {
//            $searchFilter .= " AND account_town_id = $townId ";
//        }

        if ($groupId > 0) {
            $searchFilter .= " AND account_group_id = $groupId ";
        }

//        if ($q != '') {
//            if (strpos($q, ' ') !== false)  {
//                $advQ = explode(' ', $q);
//                $sizeQ = sizeof($advQ);
//                if ($sizeQ == 1) {
//                    $searchFilter .= " AND (account_name LIKE '%$q%') ";
//                } elseif ($sizeQ == 2) {
//                    $searchFilter .= " AND (account_name LIKE '%$advQ[0]%' AND account_name LIKE '%$advQ[1]%') ";
//                } elseif ($sizeQ == 3) {
//                    $searchFilter .= " AND (account_name LIKE '%$advQ[0]%' AND account_name LIKE '%$advQ[1]%' AND account_name LIKE '%$advQ[2]%') ";
//                } else {
//                    $searchFilter .= " AND (account_name LIKE '%$q%') ";
//                }
//            } else {
//                $searchFilter .= " AND (account_name LIKE '%$q%') ";
//            }
//        }
//
//        if ($search != '') {
//            $searchFilter .= " AND (account_name LIKE '%$search%' OR account_uid LIKE '%$search%' OR account_print_name LIKE '%$search%') ";
//        }

        if ($userId > 0) {

            $groupsIds = getUser($userId)->properties->user_group_id;
            $searchFilter .= " AND account_group_id in ($groupsIds) ";

        } else {

            if ($isLedger == 1) {

                if ($loginUser->user_role_id == $tellerRoleId) {

                    $tellerCashWICAccountIds = $loginUser->user_teller_cash_account_uid . ',' . $loginUser->user_teller_wic_account_uid;
                    $groupsIds = $loginUser->user_group_id;
                    $searchFilter .= " AND (account_group_id in ($groupsIds) OR account_uid in ($tellerCashWICAccountIds))";

                } else if ($loginUser->user_role_id == $purchaserRoleId) {

                    $purchaserCashWICAccountIds = $loginUser->user_purchaser_cash_account_uid . ',' . $loginUser->user_purchaser_wic_account_uid;
                    $groupsIds = $loginUser->user_group_id;
                    $searchFilter .= " AND (account_group_id in ($groupsIds) OR account_uid in ($purchaserCashWICAccountIds))";

                } else {

                    if ($loginUser->user_level != SUPER_ADMIN_LEVEL) {
                        $groupsIds = $loginUser->user_group_id;
                        $searchFilter .= " AND account_group_id in ($groupsIds) ";
                    }

                }

            }

        }

        if ($salesMan > 0) {
            $searchFilter .= " AND account_sale_person = $salesMan ";
        }

        if ($createdBy > 0) {
            $searchFilter .= " AND account_createdby = $createdBy ";
        }

        if ($creation != '') {
            if ($creationMatch == 1) $creatQ = '(account_datetime >= "' . $creation . ' 00:00:00" AND account_datetime <= "' . $creation . ' 23:59:59")';
            elseif ($creationMatch == 2) $creatQ = 'account_datetime > "' . $creation . ' 00:00:00"';
            else $creatQ = 'account_datetime < "' . $creation . ' 00:00:00"';
            $searchFilter .= " AND $creatQ ";
        }

        if ($type > 0 && $type < $max) {
            switch ($type) {
                case $CLIENTS: {
                    $searchFilter .= " AND account_parent_code = $clientParentUID ";
                    break;
                }
                case $SUPPLIERS: {
                    $searchFilter .= " AND account_parent_code = $supplierParentUID ";
                    break;
                }
                case $BANKS: {
                    $searchFilter .= " AND account_parent_code = $bankParentUID ";
                    break;
                }
                case $EXPANSES: {
                    $searchFilter .= " AND account_uid LIKE '$expenseTopParentUID%' ";
                    break;
                }
                case $SALARIES: {
                    $searchFilter .= " AND account_parent_code = $salariesParentUID ";
                    break;
                }
                case $ADV_SALARIES: {
                    $searchFilter .= " AND account_parent_code = $advSalariesParentUID ";
                    break;
                }
                case $ENTRY_ACCOUNTS: {
                    $searchFilter .= " AND account_parent_code != $clientParentUID AND account_parent_code != $supplierParentUID ";
                    break;
                }
                case $PARTIES_ACCOUNTS: {
                    $searchFilter .= " AND account_parent_code in ($supplierParentUID, $clientParentUID) ";
                    break;
                }
                case $SALE_PURCHASE: {

                    $cashWicAccountUID = '';

                    if ($loginUser->user_role_id == $tellerRoleId) {
                        $cashWicAccountUID = $loginUser->user_teller_wic_account_uid;
                        $searchFilter .= " AND account_uid = $cashWicAccountUID ";
                    } else if ($loginUser->user_role_id == $purchaserRoleId) {
                        $cashWicAccountUID = $loginUser->user_purchaser_wic_account_uid;
                        $searchFilter .= " AND (account_parent_code in ($supplierParentUID, $clientParentUID) OR account_uid = $cashWicAccountUID) ";
                    } else {
                        $cashWicAccountUID = $wicAccountUID;
                        $searchFilter .= " AND (account_parent_code in ($supplierParentUID, $clientParentUID) OR account_uid = $wicAccountUID) ";
                    }

                    break;
                }
            }
        }

        if ($notThisAccounts != '') {
            $searchFilter .= " AND account_uid not in ($notThisAccounts)";
        }

        if ($showEnabledDisabledAll == 0) {
            $searchFilter .= " AND account_disabled = 0";
        } else if ($showEnabledDisabledAll == 1) {
            $searchFilter .= " AND account_disabled = 1";
        } else {
            // all account visible
        }

        if ($showDeleted == 1) {
            $searchFilter .= " AND account_delete_status = 1";
        } else {
            $searchFilter .= " AND account_delete_status = 0";
        }


        $query = "SELECT account_uid, account_name, account_parent_code FROM financials_accounts $searchFilter order by account_name;";

        $result = $database->query($query);

        if ($result && $database->num_rows($result) > 0) {

            while ($acc = $database->fetch_array($result)) {

//                $balance = getAccountClosingBalance($acc['account_uid'])->balance;
//                $balanceType = "  ";

                $parentCode = $acc['account_parent_code'];

//                if (startsWith($parentCode, $assets) || startsWith($parentCode, $expense)) {
//                    if ($balance > 0) {
//                        $balanceType = "Dr";
//                    } else if ($balance < 0) {
//                        $balanceType = "Cr";
//                    }
//                } else {
//                    if ($balance > 0) {
//                        $balanceType = "Cr";
//                    } else if ($balance < 0) {
//                        $balanceType = "Dr";
//                    }
//                }

                $p = getHead($parentCode);

                $parent = $p['parent']['parent']['name'] . '/' . $p['parent']['name'] . '/' . $p['name'];

                $accounts[] = array('id' => (int)$acc['account_uid'], 'title' => $acc['account_name'], 'remarks' => $parent); // , 'balance' => number_format($balance, 2) . ' ' . $balanceType);

            }

            $response->code = OK;
            $response->data = $accounts;
            $response->message = "Accounts List.";

        } else {
            $response->code = DATA_EMPTY;
            $response->message = "No account found!";
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



