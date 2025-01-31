<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 12-Feb-19
 * Time: 5:56 PM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../_db/database.php");

$response = (object) array('success' => 0, 'code' => OK, 'data' => array(), 'message' => 'Something went wrong, Please check and try again.');

$offset = isset($_GET{'offset'}) ? $database->escape_value($_GET{'offset'}) : 0;
$text = isset($_GET{'text'}) ? $database->escape_value($_GET{'text'}) : "";

$limit = LIMIT;

if(empty($text)) {
    $query = "SELECT cat_id as id, cat_title as title, cat_remarks as remarks FROM category ORDER BY cat_title LIMIT $limit OFFSET $offset;";
} else {
    $query = "SELECT cat_id as id, cat_title as title, cat_remarks as remarks FROM category WHERE cat_title LIKE '$text%' OR cat_remarks LIKE '%$text%' ORDER BY cat_title LIMIT $limit OFFSET $offset;";
}

$result = $database->query($query);

if($result) {

    while ($region = $database->fetch_array($result)) {
        $response->data[] = array('id' => $region['id'], 'title' => $region['title'], 'remarks' => $region['remarks']);
    }

    if(empty($response->data)) {
        $response->code = DATA_EMPTY;
        $response->message = "Empty list.";
    } else {
        $response->message = "Categories list";
    }

}
$response->success = 1;
echo json_encode($response);


if (isset($database)) {
    $database->close_connection();
}