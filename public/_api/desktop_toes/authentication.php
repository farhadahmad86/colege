<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../_db/database.php");

$superAdminId = SUPER_ADMIN_ID;
$tellerRoleId = TELLER;

$username = $password = $OSName = $webIP = "";
$username_err = $password_err = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $database->escape_value($_POST["username"]);
    $password = $database->escape_value($_POST["password"]);
    $OSName = $database->escape_value($_POST["OSName"]);
    $webIP = $database->escape_value($_POST["webIP"]);

    $online = false;

    $query = "SELECT user_id, user_name, user_username, user_password, user_login_status, user_desktop_status 
                FROM financials_users 
                WHERE user_username = '$username' and (user_id = $superAdminId or user_role_id = $tellerRoleId);";

    $result = $database->query($query);
// print_r($query);
    $response = array(
        "loggedIn"  => false,
        "user_id"   => "",
        "error"     => ""
    );


    if ($result->num_rows == 1) {

        $u = $database->fetch_assoc($result);
        $user_id = $u['user_id'];
        $user_name = $u['user_name'];
        $user_username = $u['user_username'];
        $user_password = $u['user_password'];
        $user_status = $u['user_login_status'];
        $user_desktop_status = $u['user_desktop_status'];

        if ($user_status == "ENABLE") {
            if ($user_desktop_status == "offline") {
                if (password_verify($password, $user_password)) {
                    $query = "UPDATE financials_users SET user_desktop_status='online', user_ip_adrs='$webIP' WHERE user_username='$username';";
                    $query .="INSERT INTO desktop_login_log (log_user_id, log_datetime, log_ip, log_os_name, log_action) VALUES ($user_id, now(), '$webIP', '$OSName', 'LOGIN');";
                    $result = $database->multi_query($query);
                    $online = true;
                    $response['loggedIn'] = $online;
                    $response['user_id'] = $user_id;
                    $response['user_name'] = $user_name;
                    $response['user_username'] = $user_username;
                    $response['user_password'] = $user_password;
                } else {
                    // Display an error message if password is not valid
                    $password_err = "The password you entered was not valid.";
                    $response['error'] = $password_err;
                }
            } else {
                // Display an error message if user already online
                $username_err = "User already logged in! Please logout first then try again.";
                $response['error'] = $username_err;
            }
        } else {
            // Display an error message if username disabled
            $username_err = "User disabled! Please contact your admin to enable this user.";
            $response['error'] = $username_err;
        }
    } elseif ($result->num_rows == 0) {
        // Display an error message if username doesn't exist
        $username_err = "No account found with this username/password.";
        $response['error'] = $username_err;
    }

    echo json_encode($response);
}


if (isset($database)) {
    $database->close_connection();
}



