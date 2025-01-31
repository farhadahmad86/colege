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

$response = (object) array('success' => 0, 'code' => OK, 'data' => array(), 'message' => 'Something went wrong, Please check and try again.');

if(isset($_POST['title']) && isset($_POST['remarks'])) {

    $catId = isset($_POST['id']) ? $database->escape_value($_POST['id']) : 0;

    $title = $database->escape_value($_POST['title']);
    $remarks = $database->escape_value($_POST['remarks']);

    $alreadyExists = false;

    $checkQuery = "SELECT cat_title FROM category WHERE cat_title = '$title' AND cat_id != $catId LIMIT 1;";
    $checkResult = $database->query($checkQuery);
    if($checkResult) {
        $r = $database->fetch_assoc($checkResult);
        if(strtolower($r['cat_title']) == strtolower($title)) {
            $alreadyExists = true;
        }
    }

    if($catId != 0) {
        $query = "UPDATE category SET cat_title = '$title', cat_remarks = '$remarks' WHERE cat_id = $catId;";
    } else {
        $query = "INSERT INTO category (cat_title, cat_remarks) VALUE ('$title', '$remarks');";
    }

    if(!$alreadyExists) {

        $result = $database->query($query);
        if($result) {
            $response->message = "Category Saved.";
        }else {
            $response->code = NOT_OK;
            $response->message = "Cannot save Category.";
        }

    } else {
        $response->code = ALREADY_EXISTS;
        $response->message = "Category already exists.";

    }

}
$response->success = 1;
echo json_encode($response);

if (isset($database)) {
    $database->close_connection();
}

