<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 12-Feb-19
 * Time: 5:57 PM
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
    $query = "SELECT pro_id as id, pro_title as title, pro_remarks as remarks, c.cat_id as cid, c.cat_title as ctitle, c.cat_remarks as cremarks, pro_unit_type as type
          FROM product 
          JOIN category c ON cat_id = pro_category_id
          ORDER BY pro_title 
          LIMIT $limit OFFSET $offset;";
} else {
    $query = "SELECT pro_id as id, pro_title as title, pro_remarks as remarks, c.cat_id as cid, c.cat_title as ctitle, c.cat_remarks as cremarks, pro_unit_type as type
          FROM product 
          JOIN category c ON cat_id = pro_category_id
          WHERE pro_title LIKE '$text%' OR pro_remarks LIKE '%$text%' 
          ORDER BY pro_title 
          LIMIT $limit OFFSET $offset;";
}

$result = $database->query($query);

if($result) {

    while ($pro = $database->fetch_array($result)) {

        $category = array('id' => $pro['cid'], 'title' => $pro['ctitle'], 'remarks' => $pro['cremarks']);

        $response->data[] = array('id' => $pro['id'], 'title' => $pro['title'], 'remarks' => $pro['remarks'], 'type' => $pro['type'], 'category' => $category);
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

