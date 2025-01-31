<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../_db/database.php");
require_once("../functions/api_functions.php");

$up = isset($_REQUEST['up']) ? $database->escape_value($_REQUEST['up']) : "";
$uid = isset($_REQUEST['user_id']) ? $database->escape_value($_REQUEST['user_id']) : "";

if($up==""||$uid==""){
    dieWithError("API Authentication Failed!", null);
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

$date_from = $database->escape_value($_GET["from"]);
$date_to = $database->escape_value($_GET["to"]);
$created_by = $database->escape_value($_GET["user_id"]);

$query = "SELECT
  (SELECT SUM(ts)
   FROM
     (SELECT sum(si_grand_total) AS ts
      FROM financials_sale_invoice
      WHERE si_createdby = $created_by
        AND date(si_datetime) BETWEEN '$date_from' AND '$date_to'
      UNION ALL SELECT sum(ssi_grand_total) AS ts
      FROM financials_sale_saletax_invoice
      WHERE ssi_createdby = $created_by
        AND date(ssi_datetime) BETWEEN '$date_from' AND '$date_to'
      UNION ALL SELECT sum(sei_grand_total) AS ts
      FROM financials_service_invoice
      WHERE sei_createdby = $created_by
        AND date(sei_datetime) BETWEEN '$date_from' AND '$date_to'
      UNION ALL SELECT sum(sesi_grand_total) AS ts
      FROM financials_service_saletax_invoice
      WHERE sesi_createdby = $created_by
        AND date(sesi_datetime) BETWEEN '$date_from' AND '$date_to' ) AS tsS)AS total_sale,

  (SELECT SUM(tc)
   FROM
     (SELECT COUNT(si_grand_total) AS tc
      FROM financials_sale_invoice
      WHERE si_createdby = $created_by
        AND date(si_datetime) BETWEEN'$date_from' AND '$date_to'
      UNION ALL SELECT COUNT(ssi_grand_total) AS tc
      FROM financials_sale_saletax_invoice
      WHERE ssi_createdby = $created_by
        AND date(ssi_datetime) BETWEEN'$date_from' AND '$date_to'
      UNION ALL SELECT COUNT(sei_grand_total) AS tc
      FROM financials_service_invoice
      WHERE sei_createdby = $created_by
        AND date(sei_datetime) BETWEEN'$date_from' AND '$date_to'
      UNION ALL SELECT COUNT(sesi_grand_total) AS tc
      FROM financials_service_saletax_invoice
      WHERE sesi_createdby = $created_by
        AND date(sesi_datetime) BETWEEN'$date_from' AND '$date_to' ) AS tcC) AS total_customer,

  (SELECT SUM(tsr)
   FROM
     (SELECT sum(sri_grand_total) AS tsr
      FROM financials_sale_return_invoice
      WHERE sri_createdby = $created_by
        AND date(sri_datetime) BETWEEN'$date_from' AND '$date_to'
      UNION ALL SELECT sum(srsi_grand_total) AS tsr
      FROM financials_sale_return_saletax_invoice
      WHERE srsi_createdby = $created_by
        AND date(srsi_datetime) BETWEEN'$date_from' AND '$date_to' ) AS tsrR) AS total_sale_return,

  (SELECT SUM(cs)
   FROM
     (SELECT sum(si_cash_received) AS cs
      FROM financials_sale_invoice
      WHERE si_createdby = $created_by
        AND si_party_code = 110101
        AND date(si_datetime) BETWEEN'$date_from' AND '$date_to'
      UNION ALL SELECT sum(ssi_cash_received) AS cs
      FROM financials_sale_saletax_invoice
      WHERE ssi_createdby = $created_by
        AND ssi_party_code = 110101
        AND date(ssi_datetime) BETWEEN'$date_from' AND '$date_to'
      UNION ALL SELECT sum(sei_cash_received) AS cs
      FROM financials_service_invoice
      WHERE sei_createdby = $created_by
        AND sei_party_code = 110101
        AND date(sei_datetime) BETWEEN'$date_from' AND '$date_to'
      UNION ALL SELECT sum(sesi_cash_received) AS cs
      FROM financials_service_saletax_invoice
      WHERE sesi_createdby = $created_by
        AND sesi_party_code = 110101
        AND date(sesi_datetime) BETWEEN'$date_from' AND '$date_to' ) AS csS) AS cash_sale,

  (SELECT SUM(ccs)
   FROM
     (SELECT sum(si_grand_total - si_cash_received) AS ccs
      FROM financials_sale_invoice
      WHERE si_createdby = $created_by
        AND si_invoice_machine_id > 0
        AND date(si_datetime) BETWEEN'$date_from' AND '$date_to'
      UNION ALL SELECT sum(ssi_grand_total - ssi_cash_received) AS css
      FROM financials_sale_saletax_invoice
      WHERE ssi_createdby = $created_by
        AND ssi_invoice_machine_id > 0
        AND date(ssi_datetime) BETWEEN'$date_from' AND '$date_to'
      UNION ALL SELECT sum(sei_grand_total - sei_cash_received) AS cs
      FROM financials_service_invoice
      WHERE sei_createdby = $created_by
        AND sei_invoice_machine_id > 0
        AND date(sei_datetime) BETWEEN'$date_from' AND '$date_to'
      UNION ALL SELECT sum(sesi_grand_total - sesi_cash_received) AS cs
      FROM financials_service_saletax_invoice
      WHERE sesi_createdby = $created_by
        AND sesi_invoice_machine_id > 0
        AND date(sesi_datetime) BETWEEN'$date_from' AND '$date_to' ) AS ccsS) AS credit_sale";

$result = $database->query($query);
$productList = array();

if ($result) {

    while ($p = $database->fetch_array($result)) {
        $productList[] = $p;
    }

}

echo json_encode($productList);

if (isset($database)) {
    $database->close_connection();
}

