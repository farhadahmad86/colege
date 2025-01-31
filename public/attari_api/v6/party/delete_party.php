<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 26-Feb-19
 * Time: 10:33 AM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../_db/database.php");

$response = (object)array('success' => 0, 'code' => 0, 'message' => 'Something went wrong, Please check and try again.');

if (isset($_POST['id'])) {

    $partyId = $database->escape_value($_POST['id']);

    $inUse = false;

    $checkQuery = "SELECT puri_party_id as party_id FROM purchase_invoice WHERE puri_party_id = $partyId LIMIT 1;";
    $checkResult = $database->query($checkQuery);
    if ($checkResult) {
        $r = $database->fetch_assoc($checkResult);
        if ($r['party_id'] == $partyId) {
            $inUse = true;
        }
    }

    if (!$inUse) {

        $query = "DELETE FROM party WHERE prty_id = $partyId;";
        $result = $database->query($query);
        if ($result) {
            $response->code = OK;
            $response->message = "Party Deleted.";
        } else {
            $response->code = NOT_OK;
            $response->message = "Cannot delete Party.";
        }

    } else {
        $response->code = IN_USE;
        $response->message = "Party already in use.";
    }

}
$response->success = 1;
echo json_encode($response);

if (isset($database)) {
    $database->close_connection();
}


