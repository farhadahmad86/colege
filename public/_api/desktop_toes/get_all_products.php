<?php


ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);


require_once("../_db/database.php");
require_once("../functions/api_functions.php");

$up = isset($_REQUEST['up']) ? $database->escape_value($_REQUEST['up']) : "";
$uid = isset($_REQUEST['uid']) ? $database->escape_value($_REQUEST['uid']) : "";

if($up==""||$uid==""){
    dieWithError("Upload API Authentication Failed!", null);
}else{
    $lgnUser = getUser($uid);

    if ($lgnUser->found == true) {
        $upwd = $lgnUser->properties->user_password;
        if(!password_verify($up,$upwd)){
            dieWithError("User Authentication Failed!", null);
        }
    }else{
        dieWithError("User Authentication Failed!", null);
    }
}

$query = "SELECT 
                pro_id, pro_unit_id, pro_code, pro_p_code, pro_alternative_code, pro_ISBN, 
                pro_category_id,
                pro_title, pro_purchase_price, pro_sale_price, 
                pro_clubbing_codes, pro_tax, pro_retailer_discount, pro_whole_seller_discount, pro_loyalty_card_discount, pro_remarks
            FROM financials_products WHERE pro_status = 'ACTIVE' AND pro_delete_status = 0 AND pro_disabled = 0;";

$result = $database->query($query);

$productList = array();

if ($result) {

    while ($p = $database->fetch_assoc($result)) {
        $productList[] = $p;
    }

}

echo json_encode($productList);


if (isset($database)) {
    $database->close_connection();
}


