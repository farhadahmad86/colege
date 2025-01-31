<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// $created_by=$_GET["user"];
//$day_end_date=$_GET["date"];

require_once("../_db/database.php");
require_once("../functions/api_functions.php");

$up = isset($_REQUEST['up']) ? $database->escape_value($_REQUEST['up']) : "";
$uid = isset($_REQUEST['uid']) ? $database->escape_value($_REQUEST['uid']) : "";

if($up==""||$uid==""){
    dieWithError("Upload API Authentication Failed!", null);
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

$local_invoice_id = isset($_GET["local_id"]) ? $database->escape_value($_GET["local_id"]) : 0;
$return_type = isset($_GET["return_type"]) ? $database->escape_value($_GET["return_type"]) : 0;

if ($return_type == 0) {
	$query = "SELECT * FROM financials_sale_invoice WHERE si_local_invoice_id = $local_invoice_id";// AND si_createdby='$created_by' AND si_status='SALE' AND si_return_status!='FULL'";
} elseif ($return_type == 1) {
	$query = "SELECT * FROM financials_sale_saletax_invoice WHERE ssi_local_invoice_id = $local_invoice_id";// AND ssi_createdby='$created_by' AND si_status='SALE' AND si_return_status!='FULL'";
}

$result = $database->query($query);

$saleInvoice = array();

if ($result) {

    while ($row_invoice = $database->fetch_assoc($result)) {

        $saleInvoice[]= $row_invoice;

    }

}

//echo json_encode($saleInvoice);

// if ($return_type == 0) {
// 	$query_id = "SELECT si_id FROM financials_sale_invoice WHERE si_local_invoice_id='$local_invoice_id' AND si_createdby='$created_by'";// AND si_day_end_date='$day_end_date'";
// } elseif ($return_type == 1) {
// 	$query_id = "SELECT ssi_id FROM financials_sale_saletax_invoice WHERE ssi_local_invoice_id='$local_invoice_id' AND ssi_createdby='$created_by'";// AND si_day_end_date='$day_end_date'";
// }
	
// $result_id = $database->query($query_id);
// $row=$database->fetch_assoc($result_id);

// if ($return_type == 0) {
// 	$si_id=$row['si_id'];
// 	$query_product = "SELECT * FROM financials_sale_invoice_items WHERE sii_invoice_id='$si_id'";
// } elseif ($return_type == 1) {
// 	$ssi_id=$row['ssi_id'];
// 	$query_product = "SELECT * FROM financials_sale_saletax_invoice_items WHERE ssii_invoice_id='$ssi_id'";
// }


// $result_product = $database->query($query_product);

// $saleInvoiceItem = array();

// if ($result_product) {
// 	while ($row_item = $database->fetch_assoc($result_product)) {
// 		$saleInvoiceItem[] = $row_item;
// 	}
// }
//$json[]=$saleInvoice;
//$json[]=$saleInvoiceItem;


echo json_encode(array(
// 			"saleInvoice" => $saleInvoice,
// 			"saleInvoiceItem" => $saleInvoiceItem
			"saleInvoice" => $saleInvoice
				));

if (isset($database)) {
    $database->close_connection();
}

