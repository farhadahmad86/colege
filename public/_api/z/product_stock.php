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

    <title>Product Stock Details</title>

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

<h2 style="text-align: center; padding-top: 22px">Product Stock Details</h2>

<div style="margin: auto; padding: 16px">

<?php

    $tHeader = "";
    $totalWarehouses = 0;

    $query = "SELECT wh_id, wh_title FROM financials_warehouse ORDER BY wh_id;";
    $result = $database->query($query);

    while ($wh = $database->fetch_assoc($result)) {

        $totalWarehouses++;

        $tHeader .= "<th style='width: 7%'>" . $wh['wh_title'] . "</th>";

    }

?>

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
        <th style='width: 7%'>Sale Qty</th>
        <th style='width: 7%'>Hold Qty</th>
        <th style='width: 7%'>Bonus Qty</th>
        <th style='width: 7%'>Claim Qty</th>
        <th style='width: 7%'>W-Bonus Qty</th>
        <th style='width: 7%'>Pro Qty</th>
        <th style='width: 7%'>Total Qty</th>
        <?php echo $tHeader; ?>
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

$query1 = "SELECT pro_id, pro_code, pro_p_code, pro_alternative_code, pro_ISBN, pro_clubbing_codes, pro_title, pro_qty_for_sale, pro_hold_qty, pro_bonus_qty, pro_claim_qty, pro_qty_wo_bonus, pro_quantity 
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

        $saleQty = $pro['pro_qty_for_sale'];
        $holdQty = $pro['pro_hold_qty'];
        $bonusQty = $pro['pro_bonus_qty'];
        $claimQty = $pro['pro_claim_qty'];
        $woBonusQty = $pro['pro_qty_wo_bonus'];
        $proQty = $pro['pro_quantity'];

        $saleQty = $saleQty != 0 ? $saleQty : '-';
        $holdQty = $holdQty != 0 ? $holdQty : '-';
        $bonusQty = $bonusQty != 0 ? $bonusQty : '-';
        $claimQty = $claimQty != 0 ? $claimQty : '-';
        $woBonusQty = $woBonusQty != 0 ? $woBonusQty : '-';
        $proQty = $proQty != 0 ? $proQty : '-';

        echo "
            <tr>
                <td>$proId</td>
                <td style='display: none'>$proCode</td>
                <td>$proPCode</td>
                <td style='display: none'>$proAltCode</td>
                <td style='display: none'>$proIsbnCode</td>
                <td style='display: none'>$proClubCode</td>
                <td>$proTitle</td>
                <td style='text-align: center'>$saleQty</td>
                <td style='text-align: center'>$holdQty</td>
                <td style='text-align: center'>$bonusQty</td>
                <td style='text-align: center'>$claimQty</td>
                <td style='text-align: center'>$woBonusQty</td>
                <td style='text-align: center'>$proQty</td>
        ";

        $smQty = getProductStockQuantityBalance($proPCode);
        $smQty = $smQty != 0 ? $smQty : '-';
        echo "<td style='text-align: center'>" . $smQty . "</td>";

        for ($wid = 1; $wid <= $totalWarehouses; $wid++) {
            $qty = getProductQuantityInWarehouse($proPCode, $wid)->quantity;
            $qty = $qty != 0 ? $qty : '-';
            echo "<td style='text-align: center'>" . $qty . "</td>";
        }

        echo "</tr>";
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
                <th style='width: 7%'>Sale Qty</th>
                <th style='width: 7%'>Hold Qty</th>
                <th style='width: 7%'>Bonus Qty</th>
                <th style='width: 7%'>Claim Qty</th>
                <th style='width: 7%'>W-Bonus Qty</th>
                <th style='width: 7%'>Total Qty</th>
                <?php echo $tHeader; ?>
            </tr>
        </tfoot>
    </table>

</div>

</body>
</html>
