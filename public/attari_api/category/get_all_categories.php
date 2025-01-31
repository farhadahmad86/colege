<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 13-Feb-19
 * Time: 1:37 PM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../_db/database.php");

$response = (object) array('success' => 0, 'code' => NOT_OK, 'data' => array(), 'message' => 'Something went wrong, Please check and try again.');

$query = "SELECT cat_id as id, cat_title as title, cat_remarks as remarks FROM category ORDER BY cat_title;";

$result = $database->query($query);

if($result) {

    while ($region = $database->fetch_array($result)) {
        $response->data[] = array('id' => $region['id'], 'title' => $region['title'], 'remarks' => $region['remarks']);
    }

    if(empty($response->data)) {
        $response->code = DATA_EMPTY;
        $response->message = "Empty list.";
    } else {
        $response->code = OK;
        $response->message = "Categories list";
    }

}
$response->success = 1;
echo json_encode($response);


if (isset($database)) {
    $database->close_connection();
}