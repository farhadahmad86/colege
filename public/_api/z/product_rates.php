<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 09-Jun-20
 * Time: 1:12 PM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../_db/database.php");
require_once("../functions/db_functions.php");

$limit = isset($_REQUEST['limit']) ? $database->escape_value($_REQUEST['limit']) : -1;
$offset = isset($_REQUEST['offset']) ? $database->escape_value($_REQUEST['offset']) : -1;

?>

<html>
<head>

    <title>Product Rate Details</title>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable( {
                "scrollX": true,
                stateSave: true,
                "select": "single",
                "lengthMenu": [[15, 25, 50, 100, 250, 500, -1], [15, 25, 50, 100, 250, 500, "All"]],
                "pagingType": "full_numbers",
                dom: 'lfrtip'
            } );
        } );
    </script>

</head>
<body>

<h2 style="text-align: center; padding-top: 22px">Product Rate Details</h2>

<div style="margin: auto; padding: 16px">

<table id="dataTable" class="display" style="width:100%">
    <thead>
    <tr>
        <th style='width: 3%'>ID</th>
        <th style='width: 10%; display: none'>Code</th>
        <th style='width: 10%'>Barcode</th>
        <th style='width: 10%; display: none'>Alternative Code</th>
        <th style='width: 10%; display: none'>ISBN</th>
        <th style='width: 10%; display: none'>Club</th>
        <th>Product Title</th>
        <th style='width: 7%'>Purchase</th>
        <th style='width: 7%'>Bottom</th>
        <th style='width: 7%'>Sale</th>
        <th style='width: 7%'>Average</th>
        <th style='width: 7%'>Last Purchase</th>
    </tr>
    </thead>
    <tbody>

<?php

$searchQuery = "";

if ($limit != -1) {
    $searchQuery .= " LIMIT $limit";
}

if ($offset != -1) {
    $searchQuery .= " OFFSET $offset";
}

$query1 = "SELECT pro_id, pro_code, pro_p_code, pro_alternative_code, pro_ISBN, pro_clubbing_codes, pro_title, pro_purchase_price, pro_bottom_price, pro_sale_price, pro_average_rate, pro_last_purchase_rate
            FROM financials_products ORDER BY pro_id $searchQuery;";
$result1 = $database->query($query1);

if ($result1) {

    while ($pro = $database->fetch_assoc($result1)) {

        $proId = $pro['pro_id'];
        $proCode = $pro['pro_code'];
        $proPCode = $pro['pro_p_code'];
        $proAltCode = $pro['pro_alternative_code'];
        $proIsbnCode = $pro['pro_ISBN'];
        $proClubCode = $pro['pro_clubbing_codes'];
        $proTitle = $pro['pro_title'];

        $purchase = $pro['pro_purchase_price'];
        $bottom = $pro['pro_bottom_price'];
        $sale = $pro['pro_sale_price'];
        $average = $pro['pro_average_rate'];
        $lastPurchase = $pro['pro_last_purchase_rate'];

        $purchase = $purchase != 0 ? $purchase : '-';
        $bottom = $bottom != 0 ? $bottom : '-';
        $sale = $sale != 0 ? $sale : '-';
        $average = $average != 0 ? $average : '-';
        $lastPurchase = $lastPurchase != 0 ? $lastPurchase : '-';

        echo "
            <tr>
                <td>$proId</td>
                <td style='display: none'>$proCode</td>
                <td>$proPCode</td>
                <td style='display: none'>$proAltCode</td>
                <td style='display: none'>$proIsbnCode</td>
                <td style='display: none'>$proClubCode</td>
                <td>$proTitle</td>
                <td style='text-align: center'>$purchase</td>
                <td style='text-align: center'>$bottom</td>
                <td style='text-align: center'>$sale</td>
                <td style='text-align: center'>$average</td>
                <td style='text-align: center'>$lastPurchase</td>
            </tr>
        ";

    }

}

?>

        </tbody>
        <tfoot>
            <tr>
                <th style='width: 3%'>ID</th>
                <th style='width: 10%; display: none'>Code</th>
                <th style='width: 10%'>Barcode</th>
                <th style='width: 10%; display: none'>Alternative Code</th>
                <th style='width: 10%; display: none'>ISBN</th>
                <th style='width: 10%; display: none'>Club</th>
                <th>Product Title</th>
                <th style='width: 7%'>Purchase</th>
                <th style='width: 7%'>Bottom</th>
                <th style='width: 7%'>Sale</th>
                <th style='width: 7%'>Average</th>
                <th style='width: 7%'>Last Purchase</th>
            </tr>
        </tfoot>
    </table>

</div>

</body>
</html>
