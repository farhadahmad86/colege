<?php


ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

require_once("../_db/database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $p_id = $database->escape_value($_POST["p_id"]);
    $h_id = $database->escape_value($_POST["h_id"]);
    $OSName = $database->escape_value($_POST["OSName"]);
    $exe_name = $database->escape_value($_POST["exe_name"]);
    $key_year = $database->escape_value($_POST["key_year"]);
    $webIP = $database->escape_value($_POST["webIP"]);

    
    $query ="INSERT INTO desktop_security_key_info (p_id, h_id, OSName, webIP,exe_name, key_year ) VALUES ('$p_id', '$h_id', '$OSName','$webIP','$exe_name', '$key_year');";

    $result = $database->multi_query($query);

    echo json_encode($result);

}


if (isset($database)) {
    $database->close_connection();
}
