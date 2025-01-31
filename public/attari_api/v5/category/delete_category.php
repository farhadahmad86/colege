<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 26-Feb-19
 * Time: 10:19 AM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../_db/database.php");

$response = (object)array('success' => 0, 'code' => 0, 'message' => 'Something went wrong, Please check and try again.');

if (isset($_POST['id'])) {

    $catId = $database->escape_value($_POST['id']);

    $inUse = false;

    $checkQuery = "SELECT pro_category_id as category_id FROM product WHERE pro_category_id = $catId LIMIT 1;";
    $checkResult = $database->query($checkQuery);
    if ($checkResult) {
        $r = $database->fetch_assoc($checkResult);
        if ($r['category_id'] == $catId) {
            $inUse = true;
        }
    }

    if (!$inUse) {

        $query = "DELETE FROM category WHERE cat_id = $catId;";
        $result = $database->query($query);
        if ($result) {
            $response->code = OK;
            $response->message = "Category Deleted.";
        } else {
            $response->code = NOT_OK;
            $response->message = "Cannot delete Category.";
        }

    } else {
        $response->code = IN_USE;
        $response->message = "Category already in use.";
    }

}
$response->success = 1;
echo json_encode($response);

if (isset($database)) {
    $database->close_connection();
}


