<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 13-Feb-19
 * Time: 3:56 PM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../_db/database.php");

$response = (object) array('success' => 0, 'code' => NOT_OK, 'data' => array(), 'message' => 'Something went wrong, Please check and try again.');

$catId = isset($_GET['cat_id']) ? $database->escape_value($_GET['cat_id']) : 0;

if($catId != 0) {
    $query = "SELECT pro_id as id, pro_title as title, pro_unit_type as type FROM product WHERE  pro_category_id = $catId ORDER BY pro_title;";
} else {
    $query = "SELECT pro_id as id, pro_title as title, pro_unit_type as type FROM product ORDER BY pro_title;";
}

$result = $database->query($query);

if($result) {

    while ($pro = $database->fetch_array($result)) {
        $response->data[] = array('id' => $pro['id'], 'title' => $pro['title'], 'type' => $pro['type']);
    }

    if(empty($response->data)) {
        $response->code = DATA_EMPTY;
        $response->message = "Empty list.";
    } else {
        $response->code = OK;
        $response->message = "Products list";
    }

}
$response->success = 1;
echo json_encode($response);


if (isset($database)) {
    $database->close_connection();
}
