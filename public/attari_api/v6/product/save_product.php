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

$response = (object)array('success' => 0, 'code' => OK, 'data' => array(), 'message' => 'Something went wrong, Please check and try again.');

if (isset($_POST['title']) && isset($_POST['remarks'])) {

    $productId = isset($_POST['id']) ? $database->escape_value($_POST['id']) : 0;
    $catId = isset($_POST['catId']) ? $database->escape_value($_POST['catId']) : 0;

    $title = $database->escape_value($_POST['title']);
    $type = $database->escape_value($_POST['type']);
    $remarks = $database->escape_value($_POST['remarks']);

    if ($productId != 0) {
        $query = "UPDATE product
                    SET pro_title = '$title', pro_remarks = '$remarks', pro_unit_type = '$type', pro_category_id = $catId
                  WHERE pro_id = $productId;";
    } else {
        $query = "INSERT INTO product (pro_title, pro_remarks, pro_unit_type, pro_category_id) VALUE ('$title', '$remarks', '$type', $catId);";
    }

    $result = $database->query($query);
    if ($result) {
        $response->message = "Product Saved.";
    } else {
        $response->code = NOT_OK;
        $response->message = "Cannot save Product.";
    }

}
$response->success = 1;
echo json_encode($response);

if (isset($database)) {
    $database->close_connection();
}

