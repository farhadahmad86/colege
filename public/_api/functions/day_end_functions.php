<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 09-Jan-20
 * Time: 12:22 PM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../_db/database.php");

$assetsTopLevelUID = ASSETS;
$liabilityTopLevelUID = LIABILITIES;
$revenueTopLevelUID = REVENUES;
$expensesTopLevelUID = EXPENSES;
$equityTopLevelUID = EQUITY;

function getAccount($accountUID) {

    global $database;

    $query = "SELECT * FROM financials_accounts WHERE account_uid = $accountUID LIMIT 1;";

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
        
        // print_r($balance);
        // print_r($accountUID);
        // exit();

    }

    return $balance;
}

function getAccountBalanceFrom($accountUID, $dayEndId) {

    global $database;
    $assetsTopLevelUID = ASSETS;
    $expensesTopLevelUID = EXPENSES;

    $query = "SELECT bal_total FROM financials_balances WHERE bal_account_id = $accountUID AND bal_day_end_id = $dayEndId ORDER BY bal_id DESC LIMIT 1;";

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

function getOpenDayEnd() {

    global $database;

    $query = "SELECT de_id as id, de_datetime as date, de_status as status FROM financials_day_end WHERE de_datetime_status = 'OPEN' ORDER BY de_id DESC LIMIT 1;";

    $result = $database->query($query);

    $data = (object)array('found' => false);

    if($result && $database->num_rows($result) == 1) {
        $de = $database->fetch_assoc($result);
        $data = (object)array('found' => true, 'id' => $de['id'], 'date' => $de['date'], 'status' => $de['status']);
    }

    return $data;
}

function getPendingMonthEnd() {

    global $database;

    $query = "SELECT de_id as id, de_datetime as date, de_status as status FROM financials_day_end WHERE de_month_status = 'PENDING' ORDER BY de_id DESC LIMIT 1;";

    $result = $database->query($query);

    $data = (object)array('found' => false);

    if($result && $database->num_rows($result) == 1) {
        $de = $database->fetch_assoc($result);
        $data = (object)array('found' => true, 'id' => $de['id'], 'date' => $de['date'], 'status' => $de['status']);
    }

    return $data;
}

function getDayEndWithId($dayEndId) {

    global $database;

    $query = "SELECT de_id as id, de_datetime as date, de_status as status FROM financials_day_end WHERE de_id = $dayEndId ORDER BY de_id DESC LIMIT 1;";

    $result = $database->query($query);

    $data = (object)array('found' => false);

    if($result && $database->num_rows($result) == 1) {
        $de = $database->fetch_assoc($result);
        $data = (object)array('found' => true, 'id' => $de['id'], 'date' => $de['date'], 'status' => $de['status']);
    }

    return $data;
}

function getDayEndWithDate($dayEndDate) {

    global $database;

    $query = "SELECT de_id as id, de_datetime as date, de_status as status FROM financials_day_end WHERE de_datetime = '$dayEndDate' ORDER BY de_id DESC LIMIT 1;";

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

function getFirstDayEndOfCurrentMonth() {
    global $database;

    $query = "SELECT de_id as id, de_datetime as date FROM financials_day_end WHERE de_first_day_of_month = 1 ORDER BY de_id DESC LIMIT 1;";

    $result = $database->query($query);

    $data = (object)array('found' => false);

    if($result && $database->num_rows($result) == 1) {
        $de = $database->fetch_assoc($result);
        $data = (object)array('found' => true, 'id' => $de['id'], 'date' => $de['date']);
    }

    return $data;
}

function getParents($code) {

    $head = null;

    $query = "SELECT coa_id as id, coa_code as code, coa_head_name as name, coa_parent as parentCode, coa_level as level FROM financials_coa_heads WHERE coa_code = $code;";

    global $database;

    $result = $database->query($query);

    if ($result) {

        $headData = $database->fetch_assoc($result);

        $parent = null;

        $parentCode = $headData['parentCode'];

        if ($parentCode > 0)
            $parent = getParents($parentCode);

        $head = array('id' => $headData['id'],
            'code' => $headData['code'],
            'parent' => $parent,
            'name' => $headData['name'],
            'level' => $headData['level']);

    }

    return $head;
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

function getAccountOpeningClosingBalanceFrom($accountUID, $dayEndId) {

    global $database;

    $query = "SELECT aoc_balance, aoc_type FROM financials_account_opening_closing_balance WHERE aoc_account_uid = $accountUID AND aoc_day_end_id = $dayEndId;";

    $result = $database->query($query);

    $balance = (object) array('found' => false, 'balance' => 0);

    if($result && $database->num_rows($result) == 1) {

        $data = $database->fetch_assoc($result);

        $balance = (object) array('balance' => $data['aoc_balance'], 'type' => $data['aoc_type'], 'found' => true);

    }

    return $balance;
}

function getProductLastPurchaseRate($proCode, $database = null) {
    $query = "SELECT sm_in_rate FROM financials_stock_movement WHERE sm_in_rate IS NOT NULL AND sm_type = 'PURCHASE' AND sm_product_code = '$proCode' ORDER BY sm_id DESC LIMIT 1;";

    if ($database == null) {
        global $database;
    }

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

function getProductStockQuantityBalance($proCode, $database = null) {
    $query = "SELECT sm_bal_total_qty_wo_bonus FROM financials_stock_movement WHERE sm_product_code = '$proCode' ORDER BY sm_id DESC LIMIT 1;";

    if ($database == null) {
        global $database;
    }

    $result = $database->query($query);

    $quantity = 0;

    if($result && $database->num_rows($result) == 1) {

        $quantity = $database->fetch_assoc($result)['sm_bal_total_qty_wo_bonus'];

    }

    return $quantity;
}

function getProductStockAmountBalance($proCode, $database = null) {
    $query = "SELECT sm_bal_total FROM financials_stock_movement WHERE sm_product_code = '$proCode' ORDER BY sm_id DESC LIMIT 1;";

    if ($database == null) {
        global $database;
    }

    $result = $database->query($query);

    $amount = 0;

    if($result && $database->num_rows($result) == 1) {

        $amount = $database->fetch_assoc($result)['sm_bal_total'];

    }

    return $amount;
}

function getEndingInventoryOfPurchaseRate($database = null) {
    $query = "SELECT pro_p_code FROM financials_products GROUP BY pro_p_code;";

    if ($database == null) {
        global $database;
    }

    $result = $database->query($query);

    $inventory = 0;

    if($result && $database->num_rows($result) > 0) {

        while ($pro = $database->fetch_assoc($result)) {

            $inventory += (getProductLastPurchaseRate($pro['pro_p_code'], $database) * getProductStockQuantityBalance($pro['pro_p_code'], $database));

        }

    }

    return $inventory;
}

function getEndingInventoryOfPurchaseRateNew() {
    $query = "SELECT sum(pro_qty_wo_bonus * pro_last_purchase_rate) as inventoryValue FROM financials_products where pro_qty_wo_bonus > 0;";
    global $database;
    $result = $database->query($query);
    $inventory = 0;
    if($result && $database->num_rows($result) == 1) {
        while ($pro = $database->fetch_assoc($result)) {
            $inventory = $pro['inventoryValue'];
        }
    }
    return $inventory;
}

function getEndingInventoryOfNetRate($database = null) {
    $query = "SELECT pro_p_code FROM financials_products GROUP BY pro_p_code;";

    if ($database == null) {
        global $database;
    }

    $result = $database->query($query);

    $inventory = 0;

    if($result && $database->num_rows($result) > 0) {

        while ($pro = $database->fetch_assoc($result)) {

            $inventory += getProductStockAmountBalance($pro['pro_p_code'], $database);

        }

    }

    return $inventory;
}

function getEndingInventoryOfNetRateNew() {
    $query = "SELECT sum(pro_qty_wo_bonus * pro_average_rate) as inventoryValue FROM `financials_products` where pro_qty_wo_bonus > 0;";
    global $database;
    $result = $database->query($query);
    $inventory = 0;
    if($result && $database->num_rows($result) > 0) {
        while ($pro = $database->fetch_assoc($result)) {
            $inventory = $pro['inventoryValue'];
        }
    }
    return $inventory;
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

function resetAutoIncrementOf($tableName, $idColumn, $database) {
    $selectMaxId = "SELECT max($idColumn) as num FROM $tableName;";
    $result = $database->query($selectMaxId);
    if ($result && $database->num_rows($result) == 1) {
        $number = $database->fetch_assoc($result)['num'];

        $resetAutoIncrementQuery = "ALTER TABLE $tableName AUTO_INCREMENT = $number;";
        $resetAutoIncrementResult = $database->query($resetAutoIncrementQuery);
        if ($resetAutoIncrementResult) {
            return true;
        }
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
