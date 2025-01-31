<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../_db/database.php");
require_once("../functions/api_functions.php");

$query = "SELECT 
                p_id, h_id, OSName, webIP,exe_name, key_year FROM desktop_security_key_info;";
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


