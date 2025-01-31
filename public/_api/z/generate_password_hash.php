<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 13-Jun-20
 * Time: 10:53 AM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../functions/functions.php");

if (isset($_POST['hash'])) {

    $password = $_POST['password'];

    if ($password != '' && $password != null) {


        echo "1;" . makHash($password);

    } else {

        echo "2;Password filed is Empty, Cannot generate hash";

    }

} else {

    echo "2;Form data not found!";

}
