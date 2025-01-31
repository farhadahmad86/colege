<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 13-Feb-19
 * Time: 12:06 PM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../_db/database.php");

$response = (object) array('success' => 0, 'code' => OK, 'data' => array(), 'message' => 'Something went wrong, Please check and try again.');

if(isset($_POST['title']) && isset($_POST['phone']) && isset($_POST['address']) && isset($_POST['remarks'])) {

    $partyId = isset($_POST['id']) ? $database->escape_value($_POST['id']) : 0;

    $title = $database->escape_value($_POST['title']);
    $phone = $database->escape_value($_POST['phone']);
    $address = $database->escape_value($_POST['address']);
    $remarks = $database->escape_value($_POST['remarks']);

    $alreadyExists = false;

    $checkQuery = "SELECT prty_title FROM party WHERE prty_title = '$title' AND prty_id != $partyId LIMIT 1;";
    $checkResult = $database->query($checkQuery);
    if($checkResult) {
        $r = $database->fetch_assoc($checkResult);
        if(strtolower($r['prty_title']) == strtolower($title)) {
            $alreadyExists = true;
        }
    }

    if($partyId != 0) {
        $query = "UPDATE party SET prty_title = '$title', prty_phone = '$phone', prty_address = '$address', prty_remarks = '$remarks' WHERE prty_id = $partyId;";
    } else {
        $query = "INSERT INTO party (prty_title, prty_phone, prty_address, prty_remarks) VALUE ('$title', '$phone', '$address', '$remarks');";
    }

    if(!$alreadyExists) {

        $result = $database->query($query);
        if($result) {
            $response->message = "Party Saved.";
        }else {
            $response->code = NOT_OK;
            $response->message = "Cannot save Party.";
        }

    } else {
        $response->code = ALREADY_EXISTS;
        $response->message = "Party already exists.";

    }

}
$response->success = 1;
echo json_encode($response);

if (isset($database)) {
    $database->close_connection();
}

