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
$query = "SELECT ci_id, ci_name,warning as `ci_address`, ci_email, 
       ci_ptcl_number, ci_mobile_numer, ci_whatsapp_number, ci_fax_number, ci_logo, 
       ci_facebook, ci_twitter, ci_youtube, ci_google, ci_instagram
            FROM financials_company_info;";

$result = $database->query($query);

$infoList = array();

if ($result) {
    while ($i_list = $database->fetch_assoc($result)) {
        $infoList[] = $i_list;
    }
}

echo json_encode($infoList);

if (isset($database)) {
    $database->close_connection();
}
