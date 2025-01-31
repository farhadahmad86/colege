<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 17-Jan-19
 * Time: 4:56 PM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../_db/database.php");


function getStockMovementLastEntry($productCode, $type = null, $dayEndId = null, $dayEndDate = null) {
    global $database;

    $queryParameters = "";

    if ($type != null) {
        $queryParameters = " AND sm_type = '$type' ";
    }

    if ($dayEndId != null) {
        $queryParameters = " AND sm_day_end_id = $dayEndId ";
    }

    if ($dayEndDate != null) {
        $queryParameters = " AND sm_day_end_date = '$dayEndDate' ";
    }

    $query = "SELECT 
                    sm_type, sm_product_code, sm_product_name, 
                    sm_in_qty, sm_in_bonus, sm_in_rate, sm_in_total, 
                    sm_out_qty, sm_out_bonus, sm_out_rate, sm_out_total, 
                    sm_internal_hold, sm_internal_bonus, sm_internal_claim, 
                    sm_bal_qty_for_sale, sm_bal_bonus_inward, sm_bal_bonus_outward, sm_bal_bonus_qty, sm_bal_hold, sm_bal_total_hold, sm_bal_claims, 
                    sm_bal_total_qty_wo_bonus, sm_bal_total_qty, sm_bal_rate, sm_bal_total, 
                    sm_day_end_id, sm_day_end_date, sm_voucher_code
                FROM financials_stock_movement WHERE sm_product_code = '$productCode' $queryParameters ORDER BY sm_id DESC LIMIT 1;";
    $result = $database->query($query);

    $data = (object)array('found' => false, 'properties' => null);

    if($result && $database->num_rows($result) == 1) {
        $de = $database->fetch_assoc($result);
        $data = (object)array('found' => true, 'properties' => (object)$de);
    }

    return $data;
}

function saleEntryOfStockMovement($lastEntry, $itemQuantity, $itemBonusQuantity, $itemRate, $voucherCode, $dayEndId, $dayEndDate, $userId, $timeStamp) {
    global $database;
    $smType = SM_TYPE_SALE;

    $productCode = $lastEntry->sm_product_code;
    $productName = $database->escape_value($lastEntry->sm_product_name);

    $qtyForSale = $lastEntry->sm_bal_qty_for_sale - $itemQuantity;
    $bonusInWord = 0;
    $bonusOutWord = $itemBonusQuantity;
    $bonusTotal = $lastEntry->sm_bal_bonus_qty - $itemBonusQuantity;
    $hold = 0;
    $totalHold = $lastEntry->sm_bal_total_hold;
    $claims = $lastEntry->sm_bal_claims;
    $tQtyWOBonus = $lastEntry->sm_bal_total_qty_wo_bonus - $itemQuantity;
    $totalQuantity = $lastEntry->sm_bal_total_qty - ($itemQuantity + $itemBonusQuantity);
    $averageRate = $lastEntry->sm_bal_rate;
    $totalAmount = $tQtyWOBonus * $averageRate;

//    $outWordTotal = (float)$itemQuantity * (float)$itemRate;
    $outWordTotal = (float)$itemQuantity * (float)$averageRate;

    $insertQuery = "INSERT INTO financials_stock_movement(
                                      sm_type, sm_product_code, sm_product_name, 
                                      sm_in_qty, sm_in_bonus, sm_in_rate, sm_in_total, 
                                      sm_out_qty, sm_out_bonus, sm_out_rate, sm_out_total, 
                                      sm_internal_hold, sm_internal_bonus, sm_internal_claim, 
                                      sm_bal_qty_for_sale, sm_bal_bonus_inward, sm_bal_bonus_outward, sm_bal_bonus_qty, sm_bal_hold, sm_bal_total_hold, sm_bal_claims, 
                                      sm_bal_total_qty_wo_bonus, sm_bal_total_qty, sm_bal_rate, sm_bal_total, 
                                      sm_day_end_id, sm_day_end_date, sm_voucher_code, sm_remarks, sm_user_id, sm_date_time) 
                    VALUES (
                            '$smType', '$productCode', '$productName', 
                            null, null, null, null,
                            $itemQuantity, $itemBonusQuantity, $itemRate, $outWordTotal, 
                            null, null, null, 
                            $qtyForSale, $bonusInWord, $bonusOutWord, $bonusTotal, $hold, $totalHold, $claims, 
                            $tQtyWOBonus, $totalQuantity, $averageRate, $totalAmount, 
                            $dayEndId, '$dayEndDate', '$voucherCode', '$smType', $userId, '$timeStamp');";

    $insertResult = $database->query($insertQuery);

    if ($insertResult && $database->affected_rows() == 1) {
        return true;
    }
    return false;
}

function saleReturnEntryOfStockMovement($lastEntry, $itemQuantity, $itemBonusQuantity, $itemRate, $voucherCode, $dayEndId, $dayEndDate, $userId, $timeStamp) {
    global $database;
    $smType = SM_TYPE_SALE_RETURN;

    $productCode = $lastEntry->sm_product_code;
    $productName = $database->escape_value($lastEntry->sm_product_name);

    $qtyForSale = $lastEntry->sm_bal_qty_for_sale + $itemQuantity;
    $bonusInWord = $itemBonusQuantity;
    $bonusOutWord = 0;
    $bonusTotal = $lastEntry->sm_bal_bonus_qty + $itemBonusQuantity;
    $hold = 0;
    $totalHold = $lastEntry->sm_bal_total_hold;
    $claims = $lastEntry->sm_bal_claims;
    $tQtyWOBonus = $lastEntry->sm_bal_total_qty_wo_bonus + $itemQuantity;
    $totalQuantity = $lastEntry->sm_bal_total_qty + ($itemQuantity + $itemBonusQuantity);
    $averageRate = $lastEntry->sm_bal_rate;
    $totalAmount = $tQtyWOBonus * $averageRate;

//    $inWordTotal = (float)$itemQuantity * (float)$itemRate;
    $inWordTotal = (float)$itemQuantity * (float)$averageRate;

    $insertQuery = "INSERT INTO financials_stock_movement(
                                      sm_type, sm_product_code, sm_product_name, 
                                      sm_in_qty, sm_in_bonus, sm_in_rate, sm_in_total, 
                                      sm_out_qty, sm_out_bonus, sm_out_rate, sm_out_total, 
                                      sm_internal_hold, sm_internal_bonus, sm_internal_claim, 
                                      sm_bal_qty_for_sale, sm_bal_bonus_inward, sm_bal_bonus_outward, sm_bal_bonus_qty, sm_bal_hold, sm_bal_total_hold, sm_bal_claims, 
                                      sm_bal_total_qty_wo_bonus, sm_bal_total_qty, sm_bal_rate, sm_bal_total, 
                                      sm_day_end_id, sm_day_end_date, sm_voucher_code, sm_remarks, sm_user_id, sm_date_time) 
                    VALUES (
                            '$smType', '$productCode', '$productName', 
                            $itemQuantity, $itemBonusQuantity, $itemRate, $inWordTotal, 
                            null, null, null, null,
                            null, null, null, 
                            $qtyForSale, $bonusInWord, $bonusOutWord, $bonusTotal, $hold, $totalHold, $claims, 
                            $tQtyWOBonus, $totalQuantity, $averageRate, $totalAmount, 
                            $dayEndId, '$dayEndDate', '$voucherCode', '$smType', $userId, '$timeStamp');";

    $insertResult = $database->query($insertQuery);

    if ($insertResult && $database->affected_rows() == 1) {
        return true;
    }
    return false;
}







