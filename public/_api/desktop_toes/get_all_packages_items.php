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

$query = "SELECT ppi_id, ppi_pro_pack_id, ppi_product_code, ppi_product_name, ppi_qty, ppi_rate, ppi_amount 
            FROM financials_product_packages_items;";

$result = $database->query($query);

$packages_items_List = array();

if ($result) {

    while ($p = $database->fetch_assoc($result)) {
        $packages_items_List[] = $p;
    }

}

echo json_encode($packages_items_List);


if (isset($database)) {
    $database->close_connection();
}


