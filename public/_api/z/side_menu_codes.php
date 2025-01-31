<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 25-Apr-20
 * Time: 10:15 AM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../_db/database.php");

$query = "select concat('static const ', 'L1_', REPLACE(mcd_title,' ','_'), ' = ', mcd_code, ';') as text
  from financials_modular_config_defination
  where mcd_level = 1
  order by mcd_code";

$result = $database->query($query);

if ($result) {

    while ($raw = $database->fetch_array($result)) {

        $text = str_replace('(', '', $raw['text']);
        $text = str_replace(')', '', $text);

        echo $text . '<br />';

    }

}

echo '<br />';

$query2 = "select concat('static const ', 'L2_', REPLACE(mcd_title,' ','_'), ' = ', mcd_code, ';') as text
  from financials_modular_config_defination
  where mcd_level = 2
  order by mcd_code";

$result2 = $database->query($query2);

if ($result2) {

    while ($raw = $database->fetch_array($result2)) {

        $text = str_replace('(', '', $raw['text']);
        $text = str_replace(')', '', $text);

        echo $text . '<br />';

    }

}

echo '<br />';

$query3 = "select concat('static const ', 'L3_', REPLACE(mcd_title,' ','_'), ' = ', mcd_code, ';') as text
  from financials_modular_config_defination
  where mcd_level = 3
  order by mcd_code";

$result3 = $database->query($query3);

if ($result3) {

    while ($raw = $database->fetch_array($result3)) {

        $text = str_replace('(', '', $raw['text']);
        $text = str_replace(')', '', $text);

        echo $text . '<br />';

    }

}

if (isset($database)) {
    $database->close_connection();
}