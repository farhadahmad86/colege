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

$query = "SELECT de_id as id, de_datetime as date from financials_day_end where de_datetime_status = 'OPEN';";

$result = $database->query($query);
$data = array();

$data[0] = array('id' => 0, 'date' => '');

if ($result) {

    while ($p = $database->fetch_assoc($result)) {
        $data[0] = $p;
    }

}


echo json_encode($data);


if (isset($database)) {
    $database->close_connection();
}

