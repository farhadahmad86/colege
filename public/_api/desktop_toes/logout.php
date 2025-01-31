<?php


ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

require_once("../_db/database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $database->escape_value($_POST["user_id"]);
    $username = $database->escape_value($_POST["username"]);
    $OSName = $database->escape_value($_POST["OSName"]);
    $webIP = $database->escape_value($_POST["webIP"]);

    $query = "UPDATE financials_users SET user_desktop_status='offline', user_ip_adrs='$webIP' WHERE user_username='$username';";
    $query .="INSERT INTO desktop_login_log (log_user_id, log_datetime, log_ip, log_os_name, log_action) VALUES ($user_id, now(), '$webIP', '$OSName', 'LOGOUT');";

    $result = $database->multi_query($query);

    echo json_encode($result);

}


if (isset($database)) {
    $database->close_connection();
}
