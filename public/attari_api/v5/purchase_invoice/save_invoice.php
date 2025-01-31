<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 12-Feb-19
 * Time: 6:07 PM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../_db/database.php");

$response = (object)array('success' => 0, 'code' => 0, 'data' => array(), 'message' => 'Something went wrong, Please check and try again.');

$purchaseInvoice = isset($_POST['purchase_invoice']) ? $_POST['purchase_invoice'] : false;

if ($purchaseInvoice) {

    $purchaseItem = json_decode($purchaseInvoice);

    $invoiceId = $database->escape_value($purchaseItem->id);
    $categoryId = $database->escape_value($purchaseItem->category->id);
    $partyId = $database->escape_value($purchaseItem->party->id);
    $productId = $database->escape_value($purchaseItem->product->id);
    $invoiceNumber = $database->escape_value($purchaseItem->invoice_number);

    $quantity = $database->escape_value($purchaseItem->quantity);
    $purchasePrice = $database->escape_value($purchaseItem->purchase_price);
    $totalPurchasePrice = $database->escape_value($purchaseItem->total_purchase_price);

    $bottomPrice = $database->escape_value($purchaseItem->bottom_price);
    $salePrice = $database->escape_value($purchaseItem->sale_price);
    $date = $database->escape_value($purchaseItem->date);
    $remarks = $database->escape_value($purchaseItem->remarks);

    if ($invoiceId > 0) {
        $purchaseInvoiceQuery = "UPDATE purchase_invoice SET 
                                                              puri_invouce_number = '$invoiceNumber', 
                                                              puri_category_id = $categoryId, 
                                                              puri_party_id = $partyId, 
                                                              puri_product_id = $productId, 
                                                              puri_quantity = $quantity, 
                                                              puri_purchase_price = $purchasePrice, 
                                                              puri_total_purchase_price = $totalPurchasePrice, 
                                                              puri_bottom_price = $bottomPrice, 
                                                              puri_sale_price = $salePrice, 
                                                              puri_datetime = '$date', 
                                                              puri_remarks = '$remarks'
                                                          WHERE puri_id = $invoiceId";
    } else {
        $purchaseInvoiceQuery = "INSERT INTO purchase_invoice (puri_invouce_number, puri_category_id, puri_party_id, puri_product_id, puri_quantity, puri_purchase_price, puri_total_purchase_price, 
                                      puri_bottom_price, puri_sale_price, puri_datetime, puri_remarks) 
                                VALUES ('$invoiceNumber', $categoryId, $partyId, $productId, $quantity, $purchasePrice, $totalPurchasePrice, $bottomPrice, $salePrice, '$date', '$remarks');";
    }

    $purchaseInvoiceResult = $database->query($purchaseInvoiceQuery);

    if ($purchaseInvoiceResult) {
        $response->code = OK;
        $response->message = "Purchase Invoice saved...";
    } else {
        $response->code = NOT_OK;
        $response->message = "Cannot saved purchase data!";
    }

}
$response->success = 1;
echo json_encode($response);

if (isset($database)) {
    $database->close_connection();
}
