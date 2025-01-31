<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 19-Jun-20
 * Time: 2:42 PM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//header('Content-Type: application/json');

require_once("../_db/database.php");
require_once("../functions/db_functions.php");
require_once("../functions/functions.php");

$rollback = false;
//$database->begin_trans();


// insert 25000 products ******************************************************************************************************
/*$rollBack = false;
$database->begin_trans();
$inserted = 0;
for ($i = 5; $i <= 25000; ++$i) {
    $query1 = "INSERT INTO `financials_products`(
	`pro_group_id`, `pro_category_id`, `pro_reporting_group_id`, `pro_code`, `pro_p_code`, `pro_alternative_code`, `pro_title`,
	`pro_purchase_price`, `pro_sale_price`, `pro_average_rate`, `pro_bottom_price`, `pro_last_purchase_rate`)
VALUES
	(1, 1, 1, '5$i', '0000053$i', '5237902$i', 'Pro $i', 500 + $i, 1000 + $i, 500 + $i, 750 + $i, 500 + $i)";
    $result1 = $database->query($query1);
    if ($result1 && $database->inserted_id() > 0) {
        $inserted++;
    } else {
        break;
    }
}

//if ($result1) {
//    $data = $database->fetch_assoc($result1);
//    echo json_encode($data, JSON_PRETTY_PRINT);
//}
echo $inserted . " rows inserted.<br />";
if ($rollBack == true) {
    $database->rollBack();
    echo "Database Rollback!<br />";
} else {
    $database->commit();
    echo "Successfully Commit.<br />";
}*/


// insert 5000 clients ******************************************************************************************************
/*$rollBack = false;
$database->begin_trans();
$inserted = 0;
for ($i = 4; $i <= 5000; ++$i) {
    $uid = '11013' . $i;
    $query1 = "INSERT INTO `financials_accounts`(
                                  account_parent_code, account_uid, account_name, account_credit_limit, account_region_id, account_area, account_sector_id, account_town_id, account_group_id)
                                  VALUES( 11013, $uid, 'Client $i', 50, 1, 1, 1, 1, 1)";

    $result1 = $database->query($query1);
    if ($result1 && $database->inserted_id() > 0) {
        $inserted++;
    } else {
        break;
    }
}

//if ($result1) {
//    $data = $database->fetch_assoc($result1);
//    echo json_encode($data, JSON_PRETTY_PRINT);
//}
echo $inserted . " rows inserted.<br />";
if ($rollBack == true) {
    $database->rollBack();
    echo "Database Rollback!<br />";
} else {
    $database->commit();
    echo "Successfully Commit.<br />";
}*/


// insert 5000 suppliers ******************************************************************************************************
/*$rollBack = false;
$database->begin_trans();
$inserted = 0;
for ($i = 3; $i <= 5000; ++$i) {
    $uid = '21010' . $i;
    $query1 = "INSERT INTO `financials_accounts`(
                                  account_parent_code, account_uid, account_name, account_credit_limit, account_region_id, account_area, account_sector_id, account_town_id, account_group_id)
                                  VALUES( 21010, $uid, 'Supplier $i', 50, 1, 1, 1, 1, 1)";

    $result1 = $database->query($query1);
    if ($result1 && $database->inserted_id() > 0) {
        $inserted++;
    } else {
        break;
    }
}

//if ($result1) {
//    $data = $database->fetch_assoc($result1);
//    echo json_encode($data, JSON_PRETTY_PRINT);
//}
echo $inserted . " rows inserted.<br />";
if ($rollBack == true) {
    $database->rollBack();
    echo "Database Rollback!<br />";
} else {
    $database->commit();
    echo "Successfully Commit.<br />";
}*/


// database show all tables ******************************************************************************************************
//$q1 = "SHOW TABLES;";
//$r1 = $database->query($q1);
//$totalTables = 0;
//while ($d = $database->fetch_assoc($r1)) {
//    $totalTables++;
//    echo 'TRUNCATE TABLE `' . $d['Tables_in_digitalmunshi_jm_pos'] . "`;<br />";
//}
//echo "<br /><br />Total Tables: " . $totalTables . "<br />";


// insert products from other table
//$q1 = "SELECT * FROM `TABLE 119` WHERE barcode not in (000001036077,000002006406,000017000659,000002012155);";
//$r1 = $database->query($q1);
//
//$counter = 0;
//
//if ($r1){
//    while ($p = $database->fetch_assoc($r1)) {
//
//        $cat_id = $p['cat_id'];
//        $unit_id = $p['unit_id'];
//        $prg_id = $p['prg_id'];
//        $code = $database->escape_value($p['code']);
//        $barcode = $database->escape_value($p['barcode']);
//        $alt_code = $database->escape_value($p['alt_code']);
//        $title = $database->escape_value($p['title']);
//        $purchase = $p['purchase'];
//        $sale = $p['sale'];
//        $pur_dis = $p['pur_dis'];
//        $qty = $p['qty'];
//        $tax = $p['tax'] == '' ? 0 : $p['tax'];
//        $retailer_dis = $p['retailer_dis'];
//        $whole_saler_dis = $p['whole_saler_dis'];
//        $loyalty_card_dis = $p['loyalty_card_dis'];
//
//        $q2 = "INSERT INTO financials_products (
//                                 pro_group_id, pro_category_id, pro_reporting_group_id, pro_main_unit_id, pro_unit_id, pro_code, pro_p_code,
//                                 pro_alternative_code, pro_ISBN, pro_title, pro_purchase_price, pro_sale_price, pro_average_rate, pro_bottom_price,
//                                 pro_last_purchase_rate, pro_qty_for_sale, pro_qty_wo_bonus, pro_quantity, pro_tax, pro_retailer_discount, pro_whole_seller_discount,
//                                 pro_loyalty_card_discount)
//                VALUES (
//                         0, $cat_id, $prg_id, 0, $unit_id, '$code', '$barcode',
//                        '$alt_code', '', '$title', $purchase, $sale, $purchase, 0,
//                        $purchase, $qty, $qty, $qty, $tax, $retailer_dis, $whole_saler_dis, $loyalty_card_dis
//                );";
//
//        $r2 = $database->query($q2);
//
//        if (!$r2) {
//            $rollback = true;
//            break;
//        }
//        $counter++;
//    }
//}
//
//if ($rollback) {
//    $database->rollBack();
//    echo "DB Rollback!";
//} else {
//    $database->commit();
//    echo $counter . " products inserted.";
//}





$database->close_connection();

