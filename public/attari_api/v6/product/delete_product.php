<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 26-Feb-19
 * Time: 10:35 AM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../_db/database.php");

$response = (object)array('success' => 0, 'code' => 0, 'message' => 'Something went wrong, Please check and try again.');

if (isset($_POST['id'])) {

    $productId = $database->escape_value($_POST['id']);

    $inUse = false;

    $checkQuery = "SELECT puri_product_id as product_id FROM purchase_invoice WHERE puri_product_id = $productId LIMIT 1;";
    $checkResult = $database->query($checkQuery);
    if ($checkResult) {
        $r = $database->fetch_assoc($checkResult);
        if ($r['product_id'] == $productId) {
            $inUse = true;
        }
    }

    if (!$inUse) {

        $query = "DELETE FROM product WHERE pro_id = $productId;";
        $result = $database->query($query);
        if ($result) {
            $response->code = OK;
            $response->message = "Product Deleted.";
        } else {
            $response->code = NOT_OK;
            $response->message = "Cannot delete Product.";
        }

    } else {
        $response->code = IN_USE;
        $response->message = "Product already in use.";
    }

}
$response->success = 1;
echo json_encode($response);

if (isset($database)) {
    $database->close_connection();
}

