<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 22-Jan-19
 * Time: 12:26 PM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../_db/database.php");
require_once("functions.php");



function isAsset($accountUID) {

    $topLevelUID = ASSETS;

    if (startsWith($accountUID, $topLevelUID)) {
        return true;
    }
    return false;
}

function isExpense($accountUID) {

    $topLevelUID = EXPENSES;

    if (startsWith($accountUID, $topLevelUID)) {
        return true;
    }
    return false;
}

function isLiability($accountUID) {

    $topLevelUID = LIABILITIES;

    if (startsWith($accountUID, $topLevelUID)) {
        return true;
    }
    return false;
}

function isRevenue($accountUID) {

    $topLevelUID = REVENUES;

    if (startsWith($accountUID, $topLevelUID)) {
        return true;
    }
    return false;
}

function isEquity($accountUID) {

    $topLevelUID = EQUITY;

    if (startsWith($accountUID, $topLevelUID)) {
        return true;
    }
    return false;
}

function getCity($id) {

    global $database;

    $query = "SELECT * FROM financials_city WHERE city_id = $id LIMIT 1;";

    $result = $database->query($query);

    $data = (object)array('found' => false);

    if($result && $database->num_rows($result) == 1) {

        $de = $database->fetch_assoc($result);
        $data = (object)array('found' => true, 'properties' => (object)$de);

    }

    return $data;
}

function getCountry($id) {

    global $database;

    $query = "SELECT * FROM financials_country WHERE c_id = $id LIMIT 1;";

    $result = $database->query($query);

    $data = (object)array('found' => false);

    if($result && $database->num_rows($result) == 1) {

        $de = $database->fetch_assoc($result);
        $data = (object)array('found' => true, 'properties' => (object)$de);

    }

    return $data;
}

function getRegion($id) {

    global $database;

    $query = "SELECT * FROM financials_region WHERE reg_id = $id LIMIT 1;";

    $result = $database->query($query);

    $data = (object)array('found' => false);

    if($result && $database->num_rows($result) == 1) {

        $de = $database->fetch_assoc($result);
        $data = (object)array('found' => true, 'properties' => (object)$de);

    }

    return $data;
}

function getArea($id) {

    global $database;

    $query = "SELECT * FROM financials_areas WHERE area_id = $id LIMIT 1;";

    $result = $database->query($query);

    $data = (object)array('found' => false);

    if($result && $database->num_rows($result) == 1) {

        $de = $database->fetch_assoc($result);
        $data = (object)array('found' => true, 'properties' => (object)$de);

    }

    return $data;
}

function getSector($id) {

    global $database;

    $query = "SELECT * FROM financials_sectors WHERE sec_id = $id LIMIT 1;";

    $result = $database->query($query);

    $data = (object)array('found' => false);

    if($result && $database->num_rows($result) == 1) {

        $de = $database->fetch_assoc($result);
        $data = (object)array('found' => true, 'properties' => (object)$de);

    }

    return $data;
}

function getTown($id) {

    global $database;

    $query = "SELECT * FROM financials_towns WHERE town_id = $id LIMIT 1;";

    $result = $database->query($query);

    $data = (object)array('found' => false);

    if($result && $database->num_rows($result) == 1) {

        $de = $database->fetch_assoc($result);
        $data = (object)array('found' => true, 'properties' => (object)$de);

    }

    return $data;
}

function getAccount($accountUID) {

    global $database;

    $query = "SELECT * FROM financials_accounts WHERE account_uid = $accountUID LIMIT 1;";
// print_r($query);
    $result = $database->query($query);

    $data = (object)array('found' => false);

    if($result && $database->num_rows($result) == 1) {

        $de = $database->fetch_assoc($result);
        $data = (object)array('found' => true, 'properties' => (object)$de);

    }

    return $data;
}

function getMainUnit($id) {

    global $database;

    $query = "SELECT * FROM financials_main_units WHERE mu_id = $id LIMIT 1;";

    $result = $database->query($query);

    $data = (object)array('found' => false);

    if($result && $database->num_rows($result) == 1) {

        $de = $database->fetch_assoc($result);
        $data = (object)array('found' => true, 'properties' => (object)$de);

    }

    return $data;
}

function getUnit($id) {

    global $database;

    $query = "SELECT * FROM financials_units WHERE unit_id = $id LIMIT 1;";

    $result = $database->query($query);

    $data = (object)array('found' => false);

    if($result && $database->num_rows($result) == 1) {

        $de = $database->fetch_assoc($result);
        $data = (object)array('found' => true, 'properties' => (object)$de);

    }

    return $data;
}

function getProductGroup($id) {

    global $database;

    $query = "SELECT * FROM financials_groups WHERE grp_id = $id LIMIT 1;";

    $result = $database->query($query);

    $data = (object)array('found' => false);

    if($result && $database->num_rows($result) == 1) {

        $de = $database->fetch_assoc($result);
        $data = (object)array('found' => true, 'properties' => (object)$de);

    }

    return $data;
}

function getProductCategory($id) {

    global $database;

    $query = "SELECT * FROM financials_categories WHERE cat_id = $id LIMIT 1;";

    $result = $database->query($query);

    $data = (object)array('found' => false);

    if($result && $database->num_rows($result) == 1) {

        $de = $database->fetch_assoc($result);
        $data = (object)array('found' => true, 'properties' => (object)$de);

    }

    return $data;
}

function getReportingGroup($id) {

    global $database;

    $query = "SELECT * FROM financials_account_group WHERE ag_id = $id LIMIT 1;";

    $result = $database->query($query);

    $data = (object)array('found' => false);

    if($result && $database->num_rows($result) == 1) {

        $de = $database->fetch_assoc($result);
        $data = (object)array('found' => true, 'properties' => (object)$de);

    }

    return $data;
}

function getProductReportingGroup($id) {

    global $database;

    $query = "SELECT * FROM financials_product_group WHERE pg_id = $id LIMIT 1;";

    $result = $database->query($query);

    $data = (object)array('found' => false);

    if($result && $database->num_rows($result) == 1) {

        $de = $database->fetch_assoc($result);
        $data = (object)array('found' => true, 'properties' => (object)$de);

    }

    return $data;
}

function getAreaFromSector($sectorId) {

    global $database;

    $query = "SELECT * FROM financials_sectors join financials_areas on area_id = sec_area_id WHERE sec_id = $sectorId limit 1;";

    $result = $database->query($query);

    $data = (object)array('found' => false);

    if($result && $database->num_rows($result) == 1) {

        $de = $database->fetch_assoc($result);
        $data = (object)array('found' => true, 'properties' => (object)$de);

    }

    return $data;
}

function getRegionFromArea($areaId) {

    global $database;

    $query = "SELECT * FROM financials_areas join financials_region on reg_id = area_reg_id WHERE area_id = $areaId limit 1;";

    $result = $database->query($query);

    $data = (object)array('found' => false);

    if($result && $database->num_rows($result) == 1) {

        $de = $database->fetch_assoc($result);
        $data = (object)array('found' => true, 'properties' => (object)$de);

    }

    return $data;
}

function getAccountClosingBalance($accountUID) {

    global $database;
    $assetsTopLevelUID = ASSETS;
    $expensesTopLevelUID = EXPENSES;

    $query = "SELECT bal_total FROM financials_balances WHERE bal_account_id = $accountUID ORDER BY bal_id DESC LIMIT 1;";

    $result = $database->query($query);

    $balance = (object) array('found' => false, 'balance' => 0);

    if($result && $database->num_rows($result) == 1) {

        $data = $database->fetch_assoc($result);

        if (startsWith($accountUID, $assetsTopLevelUID) || startsWith($accountUID, $expensesTopLevelUID)) {

            if ($data['bal_total'] > 0) $type = 'DR';
            elseif ($data['bal_total'] < 0) $type = 'CR';
            else $type = '';

        } else {

            if ($data['bal_total'] > 0) $type = 'CR';
            elseif ($data['bal_total'] < 0) $type = 'DR';
            else $type = '';

        }

        $balance = (object) array('balance' => $data['bal_total'], 'type' => $type, 'found' => true);

    }

    return $balance;
}

function getAccountOpeningBalance($accountUID) {

    global $database;
    $assetsTopLevelUID = ASSETS;
    $expensesTopLevelUID = EXPENSES;

    $query = "SELECT bal_total FROM financials_balances WHERE bal_account_id = $accountUID ORDER BY bal_id ASC LIMIT 1;";

    $result = $database->query($query);

    $balance = (object) array('found' => false, 'balance' => 0);

    if($result && $database->num_rows($result) == 1) {

        $data = $database->fetch_assoc($result);

        if (startsWith($accountUID, $assetsTopLevelUID) || startsWith($accountUID, $expensesTopLevelUID)) {

            if ($data['bal_total'] > 0) $type = 'DR';
            elseif ($data['bal_total'] < 0) $type = 'CR';
            else $type = '';

        } else {

            if ($data['bal_total'] > 0) $type = 'CR';
            elseif ($data['bal_total'] < 0) $type = 'DR';
            else $type = '';

        }

        $balance = (object) array('balance' => $data['bal_total'], 'type' => $type, 'found' => true);

    }

    return $balance;
}

function getAccountClosingBalanceFrom($accountUID, $dayEndId = 0, $dayEndDate = '') {

    global $database;
    $assetsTopLevelUID = ASSETS;
    $expensesTopLevelUID = EXPENSES;

    if ($dayEndId == 0 && $dayEndDate == '') {
        return (object)array('found' => false);
    }

    if ($dayEndId > 0) {
        $query = "SELECT bal_total FROM financials_balances WHERE bal_account_id = $accountUID AND bal_day_end_id = $dayEndId ORDER BY bal_id DESC LIMIT 1;";
    } else if ($dayEndDate != '') {
        $query = "SELECT bal_total FROM financials_balances WHERE bal_account_id = $accountUID AND bal_day_end_date = '$dayEndDate' ORDER BY bal_id DESC LIMIT 1;";
    } else {
        return (object)array('found' => false);
    }

    $result = $database->query($query);

    $balance = (object) array('found' => false);

    if($result && $database->num_rows($result) == 1) {

        $data = $database->fetch_assoc($result);

        if (startsWith($accountUID, $assetsTopLevelUID) || startsWith($accountUID, $expensesTopLevelUID)) {

            if ($data['bal_total'] > 0) $type = 'DR';
            elseif ($data['bal_total'] < 0) $type = 'CR';
            else $type = '';

        } else {

            if ($data['bal_total'] > 0) $type = 'CR';
            elseif ($data['bal_total'] < 0) $type = 'DR';
            else $type = '';

        }

        $balance = (object) array('balance' => $data['bal_total'], 'type' => $type, 'found' => true);

    }

    return $balance;
}

function getAccountOpeningClosingBalanceFrom($accountUID, $dayEndId = 0, $dayEndDate = '') {

    global $database;

    if ($dayEndId == 0 && $dayEndDate == '') {
        return (object)array('found' => false);
    }

    if ($dayEndId > 0) {
        $query = "SELECT aoc_balance, aoc_type FROM financials_account_opening_closing_balance WHERE aoc_account_uid = $accountUID AND aoc_day_end_id = $dayEndId;";
    } else if ($dayEndDate != '') {
        $query = "SELECT aoc_balance, aoc_type FROM financials_account_opening_closing_balance WHERE aoc_account_uid = $accountUID AND aoc_day_end_date = '$dayEndDate';";
    } else {
        return (object)array('found' => false);
    }

    $result = $database->query($query);

    $balance = (object) array('found' => false, 'balance' => 0);

    if($result && $database->num_rows($result) == 1) {

        $data = $database->fetch_assoc($result);

        $balance = (object) array('balance' => $data['aoc_balance'], 'type' => $data['aoc_type'], 'found' => true);

    }

    return $balance;
}

function getProductQuantityInWarehouse($productCode, $warehouseId) {

    global $database;
    $query = "SELECT whs_product_code, whs_stock FROM financials_warehouse_stock WHERE whs_product_code = '$productCode' AND whs_warehouse_id = $warehouseId LIMIT 1;";

    $result = $database->query($query);

    $data = (object) array('found' => false);

    if($result) {

        $q = $database->fetch_assoc($result)['whs_stock'];

        $data = (object) array('found' => true, 'quantity' => $q == '' ? 0 : $q);

    }

    return $data;
}

function getOpenDayEnd() {

    global $database;

    $query = "SELECT de_id as id, de_datetime as date, de_status as status FROM financials_day_end WHERE de_datetime_status = 'OPEN' ORDER BY de_id DESC LIMIT 1;";

    $result = $database->query($query);

    $data = (object)array('found' => false);

    if($result && $database->num_rows($result) == 1) {
        $de = $database->fetch_assoc($result);
        $data = (object)array('found' => true, 'id' => $de['id'], 'date' => $de['date'], 'status' => $de['status']);
    }
// print_r($result);
    return $data;
}

function getFirstDayEnd() {

    global $database;

    $query = "SELECT de_id as id, de_datetime as date, de_datetime_status as status FROM financials_day_end ORDER BY de_id ASC LIMIT 1;";

    $result = $database->query($query);

    $data = (object)array('found' => false);

    if($result && $database->num_rows($result) == 1) {
        $de = $database->fetch_assoc($result);
        $data = (object)array('found' => true, 'id' => $de['id'], 'date' => $de['date'], 'status' => $de['status']);
    }

    return $data;
}

function getDayEnd($date) {

    global $database;

    $query = "SELECT de_id as id, de_datetime as date, de_datetime_status as status FROM financials_day_end WHERE de_datetime = '$date';";

    $result = $database->query($query);

    $data = (object)array('found' => false);

    if($result && $database->num_rows($result) == 1) {
        $de = $database->fetch_assoc($result);
        $data = (object)array('found' => true, 'id' => $de['id'], 'date' => $de['date'], 'status' => $de['status']);
    }

    return $data;
}

function getPreviousDayEnd($date) {

    global $database;

    $newDate = '';

    try {
        $date = new DateTime($date);
        $nDate = $date->modify('-1 day');
        $newDate = $nDate->format('Y-m-d');
    } catch (Exception $e) {}

    $query = "SELECT de_id as id, de_datetime as date, de_datetime_status as status FROM financials_day_end WHERE de_datetime = '$newDate';";

    $result = $database->query($query);

    $data = (object)array('found' => false);

    if($result && $database->num_rows($result) == 1) {
        $de = $database->fetch_assoc($result);
        $data = (object)array('found' => true, 'id' => $de['id'], 'date' => $de['date'], 'status' => $de['status']);
    }

    return $data;
}

function getLastCloseDayEnd() {

    global $database;

    $query = "SELECT de_id as id, de_datetime as date FROM financials_day_end WHERE de_datetime_status = 'CLOSE' ORDER BY de_id DESC LIMIT 1;";

    $result = $database->query($query);

    $data = (object)array('found' => false);

    if($result && $database->num_rows($result) == 1) {
        $de = $database->fetch_assoc($result);
        $data = (object)array('found' => true, 'id' => $de['id'], 'date' => $de['date']);
    }

    return $data;
}

function getHead($code) {

    $head = null;

    $query = "SELECT coa_id as id, coa_code as code, coa_head_name as name, coa_parent as parentCode, coa_level as level FROM financials_coa_heads WHERE coa_code = $code;";

    global $database;

    $result = $database->query($query);

    if ($result) {

        $headData = $database->fetch_assoc($result);

        $parent = null;

        $parentCode = $headData['parentCode'];

        if ($parentCode > 0)
            $parent = getHead($parentCode);

        $head = array('id' => $headData['id'],
            'code' => $headData['code'],
            'parent' => $parent,
            'name' => $headData['name'],
            'level' => $headData['level']);

    }

    return $head;
}

function getUser($id) {
    $query = "SELECT * FROM financials_users WHERE user_id = $id;";

    global $database;

    $result = $database->query($query);

    $data = (object)array('found' => false);

    if($result && $database->num_rows($result) == 1) {
        $de = $database->fetch_assoc($result);
        $data = (object)array('found' => true, 'properties' => (object)$de);
    }

    return $data;
}

function getProduct($code) {
    $query = "SELECT * FROM financials_products WHERE pro_code = $code;";

    global $database;

    $result = $database->query($query);

    $data = (object)array('found' => false);

    if($result && $database->num_rows($result) == 1) {
        $de = $database->fetch_assoc($result);
        $data = (object)array('found' => true, 'properties' => (object)$de);
    }

    return $data;
}

function getCreditCardMachine($id) {
    $query = "SELECT * FROM financials_credit_card_machine WHERE ccm_id = $id;";

    global $database;

    $result = $database->query($query);

    $data = (object)array('found' => false);

    if($result && $database->num_rows($result) == 1) {
        $de = $database->fetch_assoc($result);
        $data = (object)array('found' => true, 'properties' => (object)$de);
    }

    return $data;
}

function getModularGroup($id) {
    $query = "SELECT * FROM financials_modular_groups WHERE mg_id = $id;";

    global $database;

    $result = $database->query($query);

    $data = (object)array('found' => false);

    if($result && $database->num_rows($result) == 1) {
        $de = $database->fetch_assoc($result);
        $data = (object)array('found' => true, 'properties' => (object)$de);
    }

    return $data;
}

function newAccountUID($headUID) {

    global $database;

    $accountUid = 0;

    $uidQuery = "SELECT account_uid FROM financials_accounts WHERE account_parent_code = $headUID order by account_uid desc limit 1;";
    $uidResult = $database->query($uidQuery);
    if ($uidResult) {
        $uidData = $database->fetch_assoc($uidResult);
        if (!empty($uidData['account_uid'])) {
            $id = replaceFirst($headUID . "", "", $uidData['account_uid'] . "");
            $id = $id + 1;
            $accountUid = "$headUID" . $id;
        } else {
            $accountUid = "$headUID" . "1";
        }
    }

    return $accountUid;
}

function createAccount($parentUID, $accountName, $createdBy, $timeStamp, $dayEndId, $dayEndDate, $reportingGroupId, $ip, $browser) {

    global $database;

    $accountUid = newAccountUID($parentUID);

    $accQuery = "INSERT INTO financials_accounts (account_parent_code, account_uid, account_name, account_print_name, account_cnic, account_address, 
                                 account_proprietor, account_company_code, account_mobile_no, account_whatsapp, account_phone, account_email, account_gst, 
                                 account_ntn, account_type, account_credit_limit, account_page_no, account_balance, account_datetime, account_region_id, 
                                 account_area, account_sector_id, account_createdby, account_day_end_id, account_day_end_date, account_remarks, account_group_id, 
                                 account_employee_id, account_link_uid, account_sale_person, account_ip_adrs, account_brwsr_info) 
                    VALUES (
                            $parentUID, $accountUid, '$accountName', '$accountName', '', '', 
                            '', '', '', '', '', '', '', 
                            '', 0, 0, '', 0, '$timeStamp', 0, 
                            0, 0, $createdBy, $dayEndId, '$dayEndDate', '', $reportingGroupId, 
                            0, 0, 0, '$ip', '$browser'
                    );";

    $accResult = $database->query($accQuery);

    if ($accResult && $database->affected_rows() == 1) {

        $balQuery = "INSERT INTO financials_balances (bal_account_id, bal_transaction_type, bal_dr, bal_cr, bal_total, bal_transaction_id, bal_day_end_id, bal_day_end_date, bal_user_id) 
                        VALUES ($accountUid, 'OPENING_BALANCE', 0, 0, 0, 0, $dayEndId, '$dayEndDate', $createdBy);";

        $balResult = $database->query($balQuery);

        if ($balResult && $database->affected_rows() == 1) {
            return $accountUid;
        }
    }

    return 0;
}

function getPDC($id) {
    $query = "SELECT * FROM financials_post_dated_cheques WHERE pdc_id = $id;";

    global $database;

    $result = $database->query($query);

    $data = (object)array('found' => false);

    if($result && $database->num_rows($result) == 1) {
        $de = $database->fetch_assoc($result);
        $data = (object)array('found' => true, 'properties' => (object)$de);
    }

    return $data;
}

function addProductQuantity($parentCode, $quantity) {
    global $database;
    $query = "UPDATE financials_products SET pro_quantity = pro_quantity + $quantity WHERE pro_p_code = '$parentCode';";
    $result = $database->query($query);
    if ($result) {
        return $database->affected_rows();
    }
    return 0;
}

function addProductQuantityInWarehouse($parentCode, $quantity, $warehouseId) {
    global $database;

    $q = "SELECT * FROM financials_warehouse_stock WHERE whs_product_code = '$parentCode' AND whs_warehouse_id = $warehouseId;";
    $r = $database->query($q);
    if ($r && $database->num_rows($r) > 0) {
        $query = "UPDATE financials_warehouse_stock SET whs_stock = whs_stock + $quantity WHERE whs_product_code = '$parentCode' AND whs_warehouse_id = $warehouseId;";
        $result = $database->query($query);
        if ($result) {
            return $database->affected_rows();
        }
    } else {
        $query = "INSERT INTO financials_warehouse_stock (whs_product_code, whs_stock, whs_warehouse_id) VALUES ('$parentCode', $quantity, $warehouseId);";
        $result = $database->query($query);
        if ($result) {
            return $database->affected_rows();
        }
    }
    return 0;
}

function getProductLastAverageRate($proCode) {
    global $database;
    $query = "SELECT sm_bal_rate FROM financials_stock_movement WHERE sm_product_code = '$proCode' ORDER BY sm_id DESC LIMIT 1;";

    $result = $database->query($query);

    $rate = 0;

    if($result && $database->num_rows($result) == 1) {

        $rate = $database->fetch_assoc($result)['sm_bal_rate'];

    }

    return $rate;
}


function getProductLastPurchaseRate($proCode) {
    global $database;

    $query = "SELECT sm_in_rate FROM financials_stock_movement WHERE sm_type = 'PURCHASE' AND sm_product_code = '$proCode' ORDER BY sm_id DESC LIMIT 1;";

    $result = $database->query($query);

    $rate = 0;

    if($result && $database->num_rows($result) == 1) {
        $rate = $database->fetch_assoc($result)['sm_in_rate'];
    } else {
        $query = "SELECT sm_bal_rate FROM financials_stock_movement WHERE sm_product_code = '$proCode' ORDER BY sm_id ASC LIMIT 1;";
        $result = $database->query($query);
        if($result && $database->num_rows($result) == 1) {
            $rate = $database->fetch_assoc($result)['sm_bal_rate'];
        }
    }

    return $rate;
}

function getProductStockQuantityBalance($proCode) {
    global $database;
    $query = "SELECT sm_bal_total_qty_wo_bonus, sm_bal_total_qty FROM financials_stock_movement WHERE sm_product_code = '$proCode' ORDER BY sm_id DESC LIMIT 1;";

    $result = $database->query($query);

    $quantity = 0;

    if($result && $database->num_rows($result) == 1) {

//        $quantity = $database->fetch_assoc($result)['sm_bal_total_qty_wo_bonus'];
        $quantity = $database->fetch_assoc($result)['sm_bal_total_qty'];

    }

    return $quantity;
}

//function getStockMovementLastEntry($productCode) {
//    global $database;
//    $query = "SELECT sm_bal_total_qty_wo_bonus, sm_bal_rate, sm_bal_total FROM financials_stock_movement WHERE sm_product_code = '$productCode' ORDER BY sm_id DESC LIMIT 1;";
//
//    $result = $database->query($query);
//
//    $data = (object)array('found' => false, 'quantity' => 0, 'rate' => 0.0, 'amount' => 0);
//
//    if($result && $database->num_rows($result) == 1) {
//        $de = $database->fetch_assoc($result);
//        $data = (object)array('found' => true, 'quantity' => $de['sm_bal_total_qty_wo_bonus'], 'rate' => $de['sm_bal_rate'], 'amount' => $de['sm_bal_total']);
//    }
//
//    return $data;
//}

function transaction($transactionType, $debitCode, $creditCode, $amount, $note, $timeStamp, $entryId, $ip = '', $os = '') {
    global $database;
    $transactionQuery = "INSERT INTO financials_transactions(trans_type, trans_dr, trans_cr, trans_amount, trans_notes, trans_datetime, trans_entry_id, trans_ip_adrs, trans_brwsr_info) 
                                VALUES ($transactionType, $debitCode, $creditCode, $amount, '$note', '$timeStamp', $entryId, '$ip', '$os');";

    $transactionResult = $database->query($transactionQuery);

    if ($transactionResult && $database->affected_rows() == 1) {
        return $database->inserted_id();
    }
    return 0;
}

function debit($accountUID, $amount, $transactionType, $transactionId, $timeStamp, $userId, $dayEndId, $dayEndDate, $remarks, $detailRemarks = '', $voucherCode = '', $ip = '', $os = '', $contra = false) {

    global $database;

    $currentBalance = getAccountClosingBalance($accountUID)->balance;

    if (isAsset($accountUID) || isExpense($accountUID)) {
        if ($contra == true) {
            $newBalance = $currentBalance - $amount;
        } else {
            $newBalance = $currentBalance + $amount;
        }
    } else {
        if ($contra == true) {
            $newBalance = $currentBalance + $amount;
        } else {
            $newBalance = $currentBalance - $amount;
        }
    }

    $balanceQuery = "INSERT INTO financials_balances(
                                bal_account_id, bal_transaction_type, bal_remarks, bal_dr, bal_cr, bal_total, bal_transaction_id, 
                                bal_datetime, bal_user_id, bal_day_end_id, bal_day_end_date, bal_detail_remarks, bal_voucher_number, bal_ip_adrs, bal_brwsr_info) 
                            VALUES ($accountUID, '$transactionType', '$remarks', $amount, 0, $newBalance, $transactionId, 
                                    '$timeStamp', $userId, $dayEndId, '$dayEndDate', '$detailRemarks', '$voucherCode', '$ip', '$os');";

    $balanceResult = $database->query($balanceQuery);

    if ($balanceResult && $database->affected_rows() == 1) {
        return true;
    }
    return false;
}

function credit($accountUID, $amount, $transactionType, $transactionId, $timeStamp, $userId, $dayEndId, $dayEndDate, $remarks, $detailRemarks = '', $voucherCode = '', $ip = '', $os = '', $contra = false) {

    global $database;

    $currentBalance = getAccountClosingBalance($accountUID)->balance;

    if (isAsset($accountUID) || isExpense($accountUID)) {
        if ($contra == true) {
            $newBalance = $currentBalance + $amount;
        } else {
            $newBalance = $currentBalance - $amount;
        }
    } else {
        if ($contra == true) {
            $newBalance = $currentBalance - $amount;
        } else {
            $newBalance = $currentBalance + $amount;
        }
    }

    $balanceQuery = "INSERT INTO financials_balances(
                                bal_account_id, bal_transaction_type, bal_remarks, bal_dr, bal_cr, bal_total, bal_transaction_id, 
                                bal_datetime, bal_user_id, bal_day_end_id, bal_day_end_date, bal_detail_remarks, bal_voucher_number, bal_ip_adrs, bal_brwsr_info) 
                            VALUES ($accountUID, '$transactionType', '$remarks', 0, $amount, $newBalance, $transactionId, 
                                    '$timeStamp', $userId, $dayEndId, '$dayEndDate', '$detailRemarks', '$voucherCode', '$ip', '$os');";

    $balanceResult = $database->query($balanceQuery);

    if ($balanceResult && $database->affected_rows() == 1) {
        return true;
    }
    return false;
}

function getCompanyInfo() {

    global $database;

    $query = "SELECT * FROM financials_company_info LIMIT 1;";

    $result = $database->query($query);

    $data = (object)array('found' => false);

    if($result && $database->num_rows($result) == 1) {

        $de = $database->fetch_assoc($result);
        $data = (object)array('found' => true, 'properties' => (object)$de);

    }

    return $data;
}

function getCountOfTable($tableName) {

    global $database;

    $query = "SELECT count(*) as number FROM $tableName;";

    $result = $database->query($query);

    $data = 0;

    if($result && $database->num_rows($result) == 1) {

        $de = $database->fetch_assoc($result);
        $data = $de['number'];

    }

    return $data;
}