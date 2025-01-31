<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 12-Feb-19
 * Time: 5:57 PM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../_db/database.php");

$response = (object) array('success' => 0, 'code' => OK, 'data' => array(), 'message' => 'Something went wrong, Please check and try again.');

$queryProduct = isset($_GET{'product'}) ? $database->escape_value($_GET{'product'}) : 0;
$queryCategory = isset($_GET{'category'}) ? $database->escape_value($_GET{'category'}) : 0;
$queryParty = isset($_GET{'party'}) ? $database->escape_value($_GET{'party'}) : 0;
$queryDate = isset($_GET{'date'}) ? $database->escape_value($_GET{'date'}) : "";
$queryStartDate = isset($_GET{'start_date'}) ? $database->escape_value($_GET{'start_date'}) : "";
$queryEndDate = isset($_GET{'end_date'}) ? $database->escape_value($_GET{'end_date'}) : "";
$offset = isset($_GET{'offset'}) ? $database->escape_value($_GET{'offset'}) : 0;

$limit = LIMIT;

$searchQuery = " WHERE puri_id != 0 ";

if($queryProduct != 0) {
    $searchQuery .= " AND p.pro_id = $queryProduct ";
}

if($queryCategory != 0) {
    $searchQuery .= " AND  c.cat_id = $queryCategory ";
}

if($queryParty != 0) {
    $searchQuery .= " AND  pr.prty_id = $queryParty ";
}

if(!empty($queryDate)) {
    $searchQuery .= " AND (puri_datetime >= '$queryStartDate' AND puri_datetime <= '$queryEndDate')";
}

$query = "SELECT 
              puri_id as id, 
              puri_invouce_number as number, 
              puri_datetime as date, 
              pro_title as product, 
              cat_title as category, 
              pro_unit_type as type, 
              prty_title as party, 
              puri_quantity as qn, 
              puri_purchase_price as pp, 
              puri_total_purchase_price as tpp, 
              puri_bottom_price as bp, 
              puri_sale_price as sp 
            FROM purchase_invoice puri
            JOIN product p ON p.pro_id = puri.puri_product_id
            JOIN category c ON c.cat_id = puri.puri_category_id
            JOIN party pr ON pr.prty_id = puri.puri_party_id
            $searchQuery
            ORDER BY puri_id DESC LIMIT $limit OFFSET $offset;";

$result = $database->query($query);

if($result) {

    while ($inv = $database->fetch_array($result)) {

        $product = array('title' => $inv['product'], 'type' => $inv['type']);
        $category = array('title' => $inv['category']);
        $party = array('title' => $inv['party']);

        $response->data[] = array(
            'id' => $inv['id'],
            'invoice_number' => $inv['number'],
            'date' => $inv['date'],
            'product' => $product,
            'category' => $category,
            'party' => $party,
            'quantity' => $inv['qn'],
            'purchase_price' => $inv['pp'],
            'total_purchase_price' => $inv['tpp'],
            'bottom_price' => $inv['bp'],
            'sale_price' => $inv['sp']
        );
        
    }

    if(empty($response->data)) {
        $response->code = DATA_EMPTY;
        $response->message = "Empty list. $query";
    } else {
        $response->message = "Categories list. $query";
    }

}
$response->success = 1;
echo json_encode($response);


if (isset($database)) {
    $database->close_connection();
}

