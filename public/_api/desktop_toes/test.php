<?php

require_once("../_db/database.php");
require_once("../functions/functions.php");

$query = "SELECT si_id FROM financials_sale_invoice WHERE si_datetime = '2020-12-23 13:17:161' AND si_local_invoice_id=0 AND si_sale_person=0 LIMIT 1;";
    $result = $database->query_rows($query);
    if($result) {
        echo 'Row Exists';
    }else{
        echo 'Row does not exists';
    }