<?php
/**
 * Created by CH Arbaz Mateen.
 * User: Arbaz Mateen
 * Date: 02-Jan-2019
 * Time: 10:30 AM
 * Desc: Define database host, user, password and DB name.
 */

$pathInPieces = explode(DIRECTORY_SEPARATOR , __FILE__);
//$_path =  $pathInPieces[0].DIRECTORY_SEPARATOR.$pathInPieces[1].DIRECTORY_SEPARATOR.$pathInPieces[2];
$_path =  $pathInPieces[0].DIRECTORY_SEPARATOR.$pathInPieces[1].DIRECTORY_SEPARATOR.$pathInPieces[2].DIRECTORY_SEPARATOR.$pathInPieces[3];

$config = parse_ini_file($_path.'/_college_api_config.ini');

defined('DB_SERVER') ? null : define("DB_SERVER", $config['servername']);

defined('DB_USER') ? null : define("DB_USER", $config['username']);
defined('DB_PASS') ? null : define("DB_PASS", $config['password']);
defined('DB_NAME') ? null : define("DB_NAME", $config['dbname']);
