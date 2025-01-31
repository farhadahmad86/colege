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

$offset = isset($_GET{'offset'}) ? $database->escape_value($_GET{'offset'}) : 0;
$text = isset($_GET{'text'}) ? $database->escape_value($_GET{'text'}) : "";

$limit = LIMIT;

if(empty($text)) {
    $query = "SELECT prty_id as id, prty_title as title, prty_remarks as remarks, prty_phone as phone, prty_landline as landLine, prty_address as address 
              FROM party 
              ORDER BY prty_title LIMIT $limit OFFSET $offset;";
} else {
    $query = "SELECT prty_id as id, prty_title as title, prty_remarks as remarks, prty_phone as phone, prty_landline as landLine, prty_address as address FROM party  
              WHERE prty_title LIKE '$text%' OR prty_remarks LIKE '%$text%' 
              ORDER BY prty_title LIMIT $limit OFFSET $offset;";
}

$result = $database->query($query);

if($result) {

    while ($region = $database->fetch_array($result)) {
        $response->data[] = array('id' => $region['id'], 'title' => $region['title'], 'remarks' => $region['remarks'],
                                    'phone' => $region['phone'], 'landLine' => $region['landLine'], 'address' => $region['address']);
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