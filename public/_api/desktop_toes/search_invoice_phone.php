<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$invoice_phone=$_GET["phone"];
//$created_by=$_GET["user"];
$return_type=$_GET["return_type"];
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

if ($return_type == 0) {
	$query = "SELECT * FROM financials_sale_invoice WHERE si_phone_number='$invoice_phone'";// AND si_status='SALE' AND si_return_status!='FULL'";
} elseif ($return_type == 1) {
	$query = "SELECT * FROM financials_sale_saletax_invoice WHERE ssi_phone_number='$invoice_phone'";// AND si_status='SALE' AND si_return_status!='FULL'";
}

$result = $database->query($query);

$saleInvoice = array();
$saleInvoiceItem = array();

if ($result) {
    //$saleInvoice[] = $database->fetch_assoc($result);
	
	while ($row_invoice = $database->fetch_assoc($result)) {
		
		// -------------Fetching invoice---------------
		$saleInvoice[]= $row_invoice;
		
		// -------------Fetching Product---------------
		if ($return_type == 0) {
			// -------------Fetching invoice ID---------------
			$si_id=$row_invoice['si_id'];
			$query_product = "SELECT * FROM financials_sale_invoice_items WHERE sii_invoice_id='$si_id'";
		} elseif ($return_type == 1) {
			// -------------Fetching invoice ID---------------
			$ssi_id=$row_invoice['ssi_id'];
			$query_product = "SELECT * FROM financials_sale_saletax_invoice_items WHERE ssii_invoice_id='$ssi_id'";
		}

		$result_product = $database->query($query_product);
		

		if ($result_product) {
			while ($row_item = $database->fetch_assoc($result_product)) {
				$saleInvoiceItem[] = $row_item;
			}
		}
	}
	echo json_encode(array(
			"saleInvoice" => $saleInvoice,
			"saleInvoiceItem" => $saleInvoiceItem
				));
}
//echo json_encode($saleInvoice);
//$query_id = "SELECT si_id FROM financials_sale_invoice WHERE si_phone_number='$invoice_phone' AND si_status='SALE' AND si_return_status!='FULL'";
//$result_id = $database->query($query_id);
//$row=$database->fetch_assoc($result_id);

//$si_id=$row['si_id'];
//$query_product = "SELECT * FROM `financials_sale_invoice_items` WHERE sii_sale_invoice_id='$si_id'";
//$result_product = $database->query($query_product);

//if ($result_product) {
//	while ($row_item = $database->fetch_assoc($result_product)) {
//		$saleInvoiceItem[] = $row_item;
//	}
//}


//$json[]=$saleInvoice;
//$json[]=$saleInvoiceItem;



if (isset($database)) {
    $database->close_connection();
}
