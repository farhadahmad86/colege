<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 26-Feb-19
 * Time: 10:46 AM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../_db/database.php");

$response = (object)array('success' => 0, 'code' => 0, 'message' => 'Something went wrong, Please check and try again.');

if (isset($_POST['id'])) {

    $invoiceId = $database->escape_value($_POST['id']);

    $query = "DELETE FROM purchase_invoice WHERE puri_id = $invoiceId;";
    $result = $database->query($query);
    if ($result) {
        $response->code = OK;
        $response->message = "Invoice Deleted.";
    } else {
        $response->code = NOT_OK;
        $response->message = "Cannot delete Invoice.";
    }

}
$response->success = 1;
echo json_encode($response);

if (isset($database)) {
    $database->close_connection();
}
