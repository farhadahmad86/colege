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


$query = "SELECT gen_id, gen_title, gen_remarks FROM financials_genre WHERE gen_delete_status = 0;";

$result = $database->query($query);

$packagesList = array();

if ($result) {

    while ($p = $database->fetch_assoc($result)) {
        $packagesList[] = $p;
    }

}

echo json_encode($packagesList);


if (isset($database)) {
    $database->close_connection();
}


