<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 07-Apr-20
 * Time: 3:48 PM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once("../_db/database.php");
require_once("../functions/db_functions.php");
require_once("../functions/stock_movement_functions.php");
require_once("../functions/api_functions.php");
require_once("../mailer/send_mail.php");


$response = (object)array('success' => 0, 'code' => 0, 'message' => '');

//$loginUserId = isset($_GET['uid']) ? $database->escape_value($_GET['uid']) : 0;
$dataType = isset($_REQUEST['dt']) ? $database->escape_value($_REQUEST['dt']) : 0;
$fileName = isset($_REQUEST['fn']) ? $database->escape_value($_REQUEST['fn']) : "";
$up = isset($_REQUEST['up']) ? $database->escape_value($_REQUEST['up']) : "";
$uid = isset($_REQUEST['uid']) ? $database->escape_value($_REQUEST['uid']) : "";

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

$POST_DATA = 1;
$FILE_DATA = 2;

$pendingFolderName = "pending_sync_files/";

if ($dataType == $POST_DATA) {

    $content = file_get_contents("php://input");

    if ($content == "" || !isset($content)) {
        dieWithError("Cannot received data from request!", $database);
    }
    $content = json_decode($content);

    $content = $content[0];

} else if ($dataType == $FILE_DATA) {
    if ($fileName == "") {
        dieWithError("File name not found!", $database);
    } else {

        $content = file($pendingFolderName . $fileName) or dieWithError("File not found!", $database);

        $content = json_decode($content[0]);

        $content = $content[0];
    }
} else {
    dieWithError("Data type (POST - 1, FILE - 2) not found!", $database);
}


$rollBack = false;
$error = false;
$errorMessages = "";

$uploadedInvoices = 0;
$savedInvoices = 0;

$walkInCustomerInvoices = 0; // cash invoices
$creditInvoices = 0;
$creditCardInvoices = 0;
$saleInvoices = 0;
$saleReturnInvoices = 0;
$saleTaxInvoices = 0;
$saleTaxReturnInvoices = 0;
$serviceInvoices = 0;
$serviceTaxInvoices = 0;
$totalInvoices = 0;


$totalSaleAmount = 0;
$totalSaleReturnAmount = 0;
$totalSaleTaxAmount = 0;
$totalSaleTaxReturnAmount = 0;
$totalSaleMarginAmount = 0;
$totalSaleMarginReturnAmount = 0;

$totalServiceAmount = 0;
$totalServiceTaxAmount = 0;
$totalServiceMarginAmount = 0;

$totalCreditCardSaleAmount = 0;
$totalCreditCardChargesAmount = 0;

$totalProductDiscountAmount = 0;
$totalServiceDiscountAmount = 0;
$totalRetailerDiscountAmount = 0;
$totalWholeSellerDiscountAmount = 0;
$totalLoyaltyDiscountAmount = 0;
$totalRoundOffDiscountAmount = 0;
$totalCashDiscountAmount = 0;

$cashParentUID = CASH_PARENT_UID;
$walkInCustomerParentUID = WALK_IN_CUSTOMER_PARENT_UID;

$cashAccountUID = CASH_ACCOUNT_UID;
$walkInCustomerAccountUID = WALK_IN_CUSTOMER_ACCOUNT_UID;
$stockAccountUID = STOCK_ACCOUNT_UID;
$salesAccountUID = SALES_ACCOUNT_UID;
$salesReturnAccountUID = SALE_RETURN_ACCOUNT_UID;
$serviceAccountUID = SERVICES_ACCOUNT_UID;

$salesTaxAccountUID = FBR_OUTPUT_TAX_ACCOUNT_UID;
$serviceTaxAccountUID = PROVINCE_OUTPUT_TAX_ACCOUNT_UID;

$salesMarginAccountUID = SALE_MARGIN_ACCOUNT_UID;
$roundOffDiscountAccountUID = ROUND_OFF_DISCOUNT_ACCOUNT_UID;
$cashDiscountAccountUID = CASH_DISCOUNT_ACCOUNT_UID;
$productDiscountAccountUID = PRODUCT_DISCOUNT_ACCOUNT_UID;
$serviceDiscountAccountUID = SERVICE_DISCOUNT_ACCOUNT_UID;
$retailerDiscountAccountUID = RETAILER_DISCOUNT_ACCOUNT_UID;
$wholeSellerDiscountAccountUID = WHOLE_SELLER_DISCOUNT_ACCOUNT_UID;
$loyaltyCardDiscountAccountUID = LOYALTY_DISCOUNT_ACCOUNT_UID;

$tellerRoleId = TELLER;
$superAdminId = SUPER_ADMIN_ID;
$superAdminLevel = SUPER_ADMIN_LEVEL;

$mainWarehouseId = 1;

// discount types
$none = 1;
$retailer = 2;
$wholeSeller = 3;
$loyalty = 4;


$loginUserId = $database->escape_value($content->user_id);
$totalInvoices = $database->escape_value($content->total_invoices);
//$loginUserPassword = $database->escape_value($content->user_password);

$loginUserName = "";
$loginUserEmail = "";
$UserPassword = "";
$loginUserRole = 0;
$userCashAccount = null;
$userWalkInCustomerAccount = null;

if ($loginUserId == $superAdminId) {

    $loginUser = getUser($loginUserId);

    if ($loginUser->found == true) {
        $loginUserRole = $loginUser->properties->user_role_id;
        $loginUserName = $loginUser->properties->user_name;
        $loginUserEmail = $loginUser->properties->user_email;
        $UserPassword = $loginUser->properties->user_password;
    }
    $cashAcc = getAccount($cashAccountUID);
    $wicAcc = getAccount($walkInCustomerAccountUID);

    if ($cashAcc->found == true) {
        $userCashAccount = (object)array('uid' => $cashAccountUID, 'name' => $cashAcc->properties->account_name, 'parentCode' => $cashAcc->properties->account_parent_code);
    } else {
        dieWithError("Cannot found cash account!", $database);
    }

    if ($wicAcc->found == true) {
        $userWalkInCustomerAccount = (object)array('uid' => $walkInCustomerAccountUID, 'name' => $wicAcc->properties->account_name, 'parentCode' => $wicAcc->properties->account_parent_code);
    } else {
        dieWithError("Cannot found walk in customer account!", $database);
    }

} else {

    $loginUser = getUser($loginUserId);

    if ($loginUser->found == true) {
        $loginUserRole = $loginUser->properties->user_role_id;
        $loginUserName = $loginUser->properties->user_name;
        $loginUserEmail = $loginUser->properties->user_email;
// print_r($loginUser);
        if ($loginUserRole == $tellerRoleId) {

            $tellerCashAccountUID = $loginUser->properties->user_teller_cash_account_uid;
            $tellerWalkInCustomerAccountUID = $loginUser->properties->user_teller_wic_account_uid;

            if ($tellerCashAccountUID > 0) {
                $tellerCashAccount = getAccount($tellerCashAccountUID);
                if ($tellerCashAccount->found) {
                    $accProp = $tellerCashAccount->properties;
                    $userCashAccount = (object)array('uid' => $accProp->account_uid, 'name' => $accProp->account_name, 'parentCode' => $accProp->account_parent_code);
                } else {
                    dieWithError("Cannot found teller cash account! upper", $database);
                }
            } else {
                dieWithError("Cannot found teller cash account! test", $database);
            }

            if ($tellerWalkInCustomerAccountUID > 0) {
                $tellerWalkInCustomerAccount = getAccount($tellerWalkInCustomerAccountUID);
                if ($tellerWalkInCustomerAccount->found) {
                    $accProp = $tellerWalkInCustomerAccount->properties;
                    $userWalkInCustomerAccount = (object)array('uid' => $accProp->account_uid, 'name' => $accProp->account_name, 'parentCode' => $accProp->account_parent_code);
                } else {
                    dieWithError("Cannot found teller walk in customer account! 1", $database);
                }
            } else {
                dieWithError("Cannot found teller walk in customer account!2", $database);
            }

        } else {
            dieWithError("Only admin and teller can sync the sale record!", $database);
        }

    } else {
        dieWithError("Cannot found user of ID: $loginUserId", $database);
    }

}

$dayEnd = getOpenDayEnd();
$dayEndId = 0;
$dayEndDate = "";
if ($dayEnd->found == true) {
    $dayEndId = $dayEnd->id;
    $dayEndDate = $dayEnd->date;
} else {
    dieWithError("Current day end not found!", $database);
}

$saleServiceInvoicesLink = array();
$saleServiceTaxInvoicesLink = array();

$saleInvoiceList = $content->sale_invoices;
$serviceInvoiceList = $content->service_invoices;
$saleTaxInvoiceList = $content->sale_tax_invoices;
$serviceTaxInvoiceList = $content->service_tax_invoices;
$saleReturnInvoiceList = $content->return_invoices;
$saleTaxReturnInvoiceList = $content->return_tax_invoices;


$database->begin_trans();

/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/

foreach ($saleInvoiceList as $invoice) {

    $saleInvoices++;
    $savedInvoices++;
    
    $localInvoiceId = $database->escape_value($invoice->id);
    $invoiceTimeStamp = $database->escape_value($invoice->si_datetime);
    $query = "SELECT si_id FROM financials_sale_invoice WHERE si_datetime = '$invoiceTimeStamp' AND si_local_invoice_id=$localInvoiceId AND si_createdby=$loginUserId;";
    $result = $database->query_rows($query);
    
    
    if(!$result){
    $partyCode = $database->escape_value($userWalkInCustomerAccount->uid);
    $partyName = $database->escape_value($userWalkInCustomerAccount->name);
    $customerName = $database->escape_value($invoice->customer_name);
    $remarks = $database->escape_value($invoice->remarks);
    $totalItems = $database->escape_value($invoice->total_items);
    $totalPrice = $database->escape_value($invoice->total_price);
    $productDiscount = $database->escape_value($invoice->product_disc);
    $roundOffDiscount = $database->escape_value($invoice->round_off_disc);
    $cashDiscountPer = $database->escape_value($invoice->cash_disc_per);
    $cashDiscount = $database->escape_value($invoice->cash_disc_amount);
    $totalDiscount = $database->escape_value($invoice->total_discount);
    $inclusiveSalesTax = $database->escape_value($invoice->inclusive_sales_tax);
    $exclusiveSalesTax = $database->escape_value($invoice->exclusive_sales_tax);
    $totalSalesTax = $database->escape_value($invoice->total_sales_tax);
    $grandTotal = $database->escape_value($invoice->grand_total);
    $cashReceived = $database->escape_value($invoice->cash_received);
    $creditCardAmountReceived = $database->escape_value($invoice->credit_received);
    $salesPersonId = $database->escape_value($invoice->user);
    $creditCardMachineId = $database->escape_value($invoice->credit_card_machine);
    $clientPhoneNumber = $database->escape_value($invoice->si_phone_number);
    $creditCardRefNumber = $database->escape_value($invoice->si_credit_card_reference_number);
    $clientEmail = $database->escape_value($invoice->si_email);
    $whatsAppNumber = $database->escape_value($invoice->si_whatsapp);
    
    $localServiceInvoiceId = $database->escape_value($invoice->service_invoice_id);
    $ipAddress = $database->escape_value($invoice->si_ip_adrs);
    $browserInfo = $database->escape_value($invoice->si_brwsr_info);
    
    $cashReceivedFromCustomer = $database->escape_value($invoice->cash_received_from_customer);
    $cashReturnToCustomer = $invoice->return_amount == "" ? 0 : $database->escape_value($invoice->return_amount);
    $discountType = $database->escape_value($invoice->discount_type);

    $detailRemarks = "";
    $transactionType = 0;

    $creditCardMachineName = "";
    $creditCardBankAccountUID = 0;
    $creditCardBankSCAccountUID = 0;
    $creditCardAccountUID = 0;
    $creditCardMachineCharges = 0.0;

    if ($creditCardMachineId > 0) {
        $machine = getCreditCardMachine($creditCardMachineId);

        if ($machine->found == true) {
            $creditCardMachineName = $machine->properties->ccm_title;
            $creditCardMachineCharges = $machine->properties->ccm_percentage;
            $creditCardBankAccountUID = $machine->properties->ccm_bank_code;
            $creditCardAccountUID = $machine->properties->ccm_credit_card_account_code;
            $creditCardBankSCAccountUID = $machine->properties->ccm_service_account_code;
        } else {
            dieWithError("Credit card machine not found of id: $creditCardMachineId", $database);
        }
    }

    $itemsList = $invoice->sale_items;

    foreach ($itemsList as $item) {
        $productParentCode = $database->escape_value($item->product->code);
        $productName = $database->escape_value($item->product->name);
        $itemQuantity = $database->escape_value($item->quantity);
        $itemUOM = $database->escape_value($item->uom);
        $itemRate = $database->escape_value($item->rate);
        $discountAmount = $database->escape_value($item->discount_amount);
        $saleTaxInclusive = $database->escape_value($item->sale_tax_inclusive);
        $saleTaxAmount = $database->escape_value($item->sale_tax_amount);
        $itemAmount = $database->escape_value($item->grand_amount);

        $inclusiveOrNot = $saleTaxInclusive == 1 ? '(Incl)' : '';
        $detailRemarks .= $productParentCode . '-' . $productName . ', ' . $itemQuantity . $itemUOM . '@' . $itemRate . ' - ' .
            $discountAmount . ' + ' . $saleTaxAmount . $inclusiveOrNot . ' = ' . $itemAmount . '\r\n';
    }
    $detailRemarks = substr($detailRemarks, 0, strlen($detailRemarks) - 4);

    $saleInsertQuery = "INSERT INTO financials_sale_invoice(
                                    si_party_code, si_party_name, si_customer_name, si_remarks, si_total_items, si_total_price,
                                    si_product_disc, si_round_off_disc, si_cash_disc_per, si_cash_disc_amount, si_total_discount,
                                    si_inclusive_sales_tax, si_exclusive_sales_tax, si_total_sales_tax, si_grand_total,
                                    si_cash_received, si_datetime, si_day_end_id, si_day_end_date, si_createdby, si_detail_remarks,
                                    si_sale_person, si_invoice_transcation_type, si_invoice_machine_id, si_invoice_machine_name, si_service_charges_percentage,
                                    si_phone_number, si_credit_card_reference_number, si_email, si_whatsapp,
                                    si_service_invoice_id, si_local_invoice_id, si_local_service_invoice_id,
                                    si_ip_adrs, si_brwsr_info, si_cash_received_from_customer, si_return_amount,
                                    si_discount_type, si_invoice_profit)
                        VALUES (
                                $partyCode, '$partyName', '$customerName', '$remarks', $totalItems, $totalPrice, 
                                $productDiscount, $roundOffDiscount, $cashDiscountPer, $cashDiscount, $totalDiscount, 
                                $inclusiveSalesTax, $exclusiveSalesTax, $totalSalesTax, $grandTotal, 
                                $cashReceived, '$invoiceTimeStamp', $dayEndId, '$dayEndDate', $loginUserId, '$detailRemarks', 
                                $salesPersonId, $transactionType, $creditCardMachineId, '$creditCardMachineName', $creditCardMachineCharges,
                                '$clientPhoneNumber', '$creditCardRefNumber', '$clientEmail', '$whatsAppNumber', 
                                0, $localInvoiceId, $localServiceInvoiceId,
                                '$ipAddress', '$browserInfo', $cashReceived, $cashReturnToCustomer, 
                                $discountType, 0);";

    $saleInsertResult = $database->query($saleInsertQuery);

    if ($saleInsertResult && $database->affected_rows() == 1) {

        $lastInsertedId = $database->inserted_id();

        if ($localServiceInvoiceId != 0) {
            $saleServiceInvoicesLink[$lastInsertedId] = $localServiceInvoiceId;
        }

        $voucherCode = SALE_VOUCHER_CODE . $lastInsertedId;

        $actualStockAmount = 0;

        foreach ($itemsList as $item) {
            $productParentCode = $database->escape_value($item->product->code);
            $productName = $database->escape_value($item->product->name);
            $itemQuantity = $database->escape_value($item->quantity);
            $itemUOM = $database->escape_value($item->uom);
            $itemWarehouseId = $database->escape_value($item->warehouse);
            $bonusQuantity = $database->escape_value($item->bonus_quantity);
            $itemRate = $database->escape_value($item->rate);
            $discountPer = $database->escape_value($item->discount_per);
            $discountAmount = $database->escape_value($item->discount_amount);
            $afterDiscountRate = $database->escape_value($item->after_dis_rate);
            $netRate = $database->escape_value($item->net_rate);
            $saleTaxPer = $database->escape_value($item->sale_tax_per);
            $saleTaxInclusive = $database->escape_value($item->sale_tax_inclusive);
            $saleTaxAmount = $database->escape_value($item->sale_tax_amount);
            $itemAmount = $database->escape_value($item->grand_amount);
            $itemRemarks = $database->escape_value($item->remarks);

            $saleItemsQuery = "INSERT INTO financials_sale_invoice_items(
                                          sii_invoice_id, sii_product_code, sii_product_name, sii_remarks, 
                                          sii_qty, sii_uom, sii_bonus_qty, sii_rate, sii_discount_per, sii_discount_amount, sii_after_dis_rate, sii_net_rate, 
                                          sii_saletax_per, sii_saletax_inclusive, sii_saletax_amount, sii_amount, sii_product_profit) 
                                VALUES (
                                        $lastInsertedId, '$productParentCode', '$productName', '$itemRemarks', 
                                        $itemQuantity, '$itemUOM', $bonusQuantity, $itemRate, $discountPer, $discountAmount, $afterDiscountRate, $netRate, 
                                        $saleTaxPer, $saleTaxInclusive, $saleTaxAmount, $itemAmount, 0);";

            $saleItemsResult = $database->query($saleItemsQuery);

            if (!$saleItemsResult || $database->affected_rows() != 1) {
                $errorMessages .= "Unable to save Sale Invoice Data!\n";
                $rollBack = true;
                $error = true;
                break;

            }

//            addProductQuantity($productParentCode, $itemQuantity * -1);
            $whUpdated = addProductQuantityInWarehouse($productParentCode, ($itemQuantity + $bonusQuantity) * -1, $itemWarehouseId);

            if ($whUpdated == 0) {
                $errorMessages .= "Failed to found product Quantity in warehouse!\n";
                $rollBack = true;
                $error = true;
                break;
            }

            // stock movement entry
            $lastRecord = getStockMovementLastEntry($productParentCode);

            $lastQuantity = 0;
            $lastRate = 0;

            if ($lastRecord->found == true) {
                $lastEntry = $lastRecord->properties;
                $lastQuantity = $lastEntry->sm_bal_total_qty_wo_bonus;
                $lastRate = $lastEntry->sm_bal_rate;

                $actualStockAmount += ($itemQuantity * $lastRate);

                $smInserted = saleEntryOfStockMovement($lastEntry, $itemQuantity, $bonusQuantity, $itemRate, $voucherCode, $dayEndId, $dayEndDate, $loginUserId, $invoiceTimeStamp);

                if ($smInserted == false) {
                    $errorMessages .= "Failed to save Product data into Stock Movement!\n";
                    $rollBack = true;
                    $error = true;
                    break;
                }
            }
/*
            $smType = SM_TYPE_SALE;

            $salAmount = $itemQuantity * $itemRate;
            $balQuantity = $lastQuantity - $itemQuantity;
            $balAmount = $balQuantity * $lastRate;

            $insertStockMovementQuery = "INSERT INTO financials_stock_movement(sm_type,
                                      sm_product_code, sm_product_name, sm_pur_qty, sm_pur_rate, sm_pur_total, 
                                      sm_sale_qty, sm_sale_rate, sm_sale_total, 
                                      sm_bal_qty, sm_bal_rate, sm_bal_total, 
                                      sm_day_end_id, sm_day_end_date, sm_voucher_code, sm_remarks, sm_user_id, sm_date_time) 
                                      VALUES ('$smType', 
                                              '$productParentCode', '$productName', 0, 0, 0, 
                                              $itemQuantity, $itemRate, $salAmount, 
                                              $balQuantity, $lastRate, $balAmount,
                                              $dayEndId, '$dayEndDate', '$voucherCode', '', $loginUserId, '$invoiceTimeStamp'
                                      );";

            $insertStockMovementResult = $database->query($insertStockMovementQuery);

            if (!$insertStockMovementResult || $database->affected_rows() != 1) {
                $rollBack = true;
                $error = true;
                break;
            }


            if ($bonusQuantity != "" && $bonusQuantity > 0) {
                addProductQuantity($productParentCode, $bonusQuantity * -1);
                addProductQuantityInWarehouse($productParentCode, $bonusQuantity * -1, $itemWarehouseId);

                // bonus stock movement entry
                $lastRecord = getStockMovementLastEntry($productParentCode);

                $lastQuantity = 0;
                $lastRate = 0;
                $lastAmount = 0;

                if ($lastRecord->found == true) {
                    $lastQuantity = $lastRecord->quantity;
                    $lastRate = $lastRecord->rate;
                    $lastAmount = $lastRecord->amount;
                }

                $smType = SM_TYPE_SALE_BONUS;

                $balQuantity = $lastQuantity - $bonusQuantity;
                $balRate = $lastRate;
                $balAmount = $balQuantity * $balRate;

                $insertStockMovementQuery = "INSERT INTO financials_stock_movement(sm_type, 
                                      sm_product_code, sm_product_name, sm_pur_qty, sm_pur_rate, sm_pur_total, 
                                      sm_sale_qty, sm_sale_rate, sm_sale_total, 
                                      sm_bal_qty, sm_bal_rate, sm_bal_total, 
                                      sm_day_end_id, sm_day_end_date, sm_voucher_code, sm_remarks, sm_user_id, sm_date_time) 
                                      VALUES ('$smType', 
                                              '$productParentCode', '$productName', 0, 0, 0, 
                                              $bonusQuantity, 0, 0, 
                                              $balQuantity, $balRate, $balAmount,
                                              $dayEndId, '$dayEndDate', '$voucherCode', '', $loginUserId, '$invoiceTimeStamp'
                                      );";

                $insertStockMovementResult = $database->query($insertStockMovementQuery);

                if (!$insertStockMovementResult || $database->affected_rows() != 1) {
                    $rollBack = true;
                    $error = true;
                    break;
                }

            }
*/
        }

        $transactionType = SALE;
        $note = TRANS_NOTE_SALE_INVOICE;

        // entry
        // Account              DR          CR

        // WIC                  0
        // Product Dis          0
        // Round Off Dis        0
        // Cash Dis             0
        //          Sales                   0
        //          Sale Margin             0

        // Stock                            0


        // WIC Dr *******************************************************************************************************************************************************//
        $transactionId = transaction($transactionType, $partyCode, 0, $grandTotal, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

        if ($transactionId > 0) {

            $ok = debit($partyCode, $grandTotal, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

            if (!$ok) {
                $errorMessages .= "Unable to store Debit entry of party!\n";
                $rollBack = true;
                $error = true;
                break;
            }

        } else {
            $errorMessages .= "Failed to store transaction!\n";
            $rollBack = true;
            $error = true;
            break;
        }
        //***************************************************************************************************************************************************************//


        if ($productDiscount > 0) {
            switch ($discountType) {
                case $none:

                    $totalProductDiscountAmount = (double)$totalProductDiscountAmount + (double)$productDiscount;

                    // Product Discount Dr *******************************************************************************************************************************************************//
                    $transactionId = transaction($transactionType, $productDiscountAccountUID, 0, $productDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

                    if ($transactionId > 0) {

                        $ok = debit($productDiscountAccountUID, $productDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                        if (!$ok) {
                            $errorMessages .= "Unable to store debit entry of Discounts!\n";
                            $rollBack = true;
                            $error = true;
                            break;
                        }

                    } else {
                        $errorMessages .= "Unable to store transaction!\n";
                        $rollBack = true;
                        $error = true;
                        break;
                    }
                    //***************************************************************************************************************************************************************//
                    break;
                case $retailer:

                    $totalRetailerDiscountAmount = (double)$totalRetailerDiscountAmount + (double)$productDiscount;

                    // Retailer Discount Dr *******************************************************************************************************************************************************//
                    $transactionId = transaction($transactionType, $retailerDiscountAccountUID, 0, $productDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

                    if ($transactionId > 0) {

                        $ok = debit($retailerDiscountAccountUID, $productDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                        if (!$ok) {
                            $errorMessages .= "Unable to store Debit entry of retailer discount!\n";
                            $rollBack = true;
                            $error = true;
                            break;
                        }

                    } else {
                        $errorMessages .= "Unable to store transaction!\n";
                        $rollBack = true;
                        $error = true;
                        break;
                    }
                    //***************************************************************************************************************************************************************//
                    break;
                case $wholeSeller:

                    $totalWholeSellerDiscountAmount = (double)$totalWholeSellerDiscountAmount + (double)$productDiscount;

                    // WholeSeller Discount Dr *******************************************************************************************************************************************************//
                    $transactionId = transaction($transactionType, $wholeSellerDiscountAccountUID, 0, $productDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

                    if ($transactionId > 0) {

                        $ok = debit($wholeSellerDiscountAccountUID, $productDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                        if (!$ok) {
                            $errorMessages .= "Unable to store Debit entry of whole seller discount!\n";
                            $rollBack = true;
                            $error = true;
                            break;
                        }

                    } else {
                        $errorMessages .= "Unable to store transaction!\n";
                        $rollBack = true;
                        $error = true;
                        break;
                    }
                    //***************************************************************************************************************************************************************//
                    break;
                case $loyalty:

                    $totalLoyaltyDiscountAmount = (double)$totalLoyaltyDiscountAmount + (double)$productDiscount;

                    // loyalty Discount Dr *******************************************************************************************************************************************************//
                    $transactionId = transaction($transactionType, $loyaltyCardDiscountAccountUID, 0, $productDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

                    if ($transactionId > 0) {

                        $ok = debit($loyaltyCardDiscountAccountUID, $productDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                        if (!$ok) {
                            $errorMessages .= "Unable to store Debit entry of loyality discount!\n";
                            $rollBack = true;
                            $error = true;
                            break;
                        }

                    } else {
                        $errorMessages .= "Unable to store transaction!\n";
                        $rollBack = true;
                        $error = true;
                        break;
                    }
                    //***************************************************************************************************************************************************************//
                    break;
            }
        }


        if ($roundOffDiscount != 0) {

            $totalRoundOffDiscountAmount = (double)$totalRoundOffDiscountAmount + (double)$roundOffDiscount;

            // round off Discount Dr *******************************************************************************************************************************************************//
            $transactionId = transaction($transactionType, $roundOffDiscountAccountUID, 0, $roundOffDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

            if ($transactionId > 0) {

                $ok = debit($roundOffDiscountAccountUID, $roundOffDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                if (!$ok) {
                    $errorMessages .= "Unable to store Debit entry of round off discount!\n";
                    $rollBack = true;
                    $error = true;
                    break;
                }

            } else {
                $errorMessages .= "Unable to store transaction!\n";
                $rollBack = true;
                $error = true;
                break;
            }
            //***************************************************************************************************************************************************************//
        }


        if ($cashDiscount > 0) {

            $totalCashDiscountAmount = (double)$totalCashDiscountAmount + (double)$cashDiscount;

            // Cash Discount Dr *******************************************************************************************************************************************************//
            $transactionId = transaction($transactionType, $cashDiscountAccountUID, 0, $cashDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

            if ($transactionId > 0) {

                $ok = debit($cashDiscountAccountUID, $cashDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                if (!$ok) {
                    $errorMessages .= "Unable to store Debit entry of cash discount!\n";
                    $rollBack = true;
                    $error = true;
                    break;
                }

            } else {
                $errorMessages .= "Unable to store transaction!\n";
                $rollBack = true;
                $error = true;
                break;
            }
            //***************************************************************************************************************************************************************//
        }


        $saleAmount = (double)$grandTotal + (double)$totalDiscount - (double)$totalSalesTax;
        $totalSaleAmount = $totalSaleAmount + $saleAmount;

        // Sales Cr *******************************************************************************************************************************************************//
        $transactionId = transaction($transactionType, 0, $salesAccountUID, $saleAmount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

        if ($transactionId > 0) {

            $ok = credit($salesAccountUID, $saleAmount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

            if (!$ok) {
                $errorMessages .= "Unable to store Credit entry of Sale!\n";
                $rollBack = true;
                $error = true;
                break;
            }

        } else {
            $errorMessages .= "Unable to store transaction!\n";
            $rollBack = true;
            $error = true;
            break;
        }
        //***************************************************************************************************************************************************************//


        if ($totalSalesTax > 0) {

            $totalSaleMarginAmount += (double)$totalSalesTax;

            // Sale Margin Cr *******************************************************************************************************************************************************//
            $transactionId = transaction($transactionType, 0, $salesMarginAccountUID, $totalSalesTax, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

            if ($transactionId > 0) {

                $ok = credit($salesMarginAccountUID, $totalSalesTax, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                if (!$ok) {
                    $errorMessages .= "Unable to store Credit entry of Sales Tax!\n";
                    $rollBack = true;
                    $error = true;
                    break;
                }

            } else {
                $errorMessages .= "Unable to store transaction!\n";
                $rollBack = true;
                $error = true;
                break;
            }
            //***************************************************************************************************************************************************************//
        }


        // Stock Cr *******************************************************************************************************************************************************//
        $transactionId = transaction($transactionType, 0, $stockAccountUID, $actualStockAmount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

        if ($transactionId > 0) {

            $ok = credit($stockAccountUID, $actualStockAmount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

            if (!$ok) {
                $errorMessages .= "Unable to store Credit entry of Stock!\n";
                $rollBack = true;
                $error = true;
                break;
            }

        } else {
            $errorMessages .= "Unable to store transaction!\n";
            $rollBack = true;
            $error = true;
            break;
        }
        //***************************************************************************************************************************************************************//


        // Cash Received Voucher If any ************************************************//
        if ($cashReceived > 0) {

            $cashReceivedVoucherDetailRemarks = $userWalkInCustomerAccount->name . '@' . $cashReceived;
            $cashReceivedVoucherDetailRemarks2 = $userCashAccount->name . '@' . $cashReceived;

            $cashReceivedQuery = "INSERT INTO financials_cash_receipt_voucher(cr_account_id, cr_total_amount, cr_remarks, cr_created_datetime, cr_day_end_id, cr_day_end_date, cr_createdby, cr_detail_remarks, cr_ip_adrs, cr_brwsr_info) 
                                    VALUES ($userCashAccount->uid, $cashReceived, '$voucherCode', '$invoiceTimeStamp', $dayEndId, '$dayEndDate', $loginUserId, '$cashReceivedVoucherDetailRemarks', '$ipAddress', '$browserInfo');";

            $cashReceivedResult = $database->query($cashReceivedQuery);

            if ($cashReceivedResult && $database->affected_rows() == 1) {

                $cashReceivedVoucherInsertedId = $database->inserted_id();

                $cashReceivedItemsQuery = "INSERT INTO financials_cash_receipt_voucher_items(cri_voucher_id, cri_account_id, cri_account_name, cri_amount, cri_remarks) 
                                            VALUES ($cashReceivedVoucherInsertedId, $userWalkInCustomerAccount->uid, '$userWalkInCustomerAccount->name', $cashReceived, '');";

                $cashReceivedItemsResult = $database->query($cashReceivedItemsQuery);

                if ($cashReceivedItemsResult && $database->affected_rows() == 1) {

                    $transactionType = CASH_RECEIPT;
                    $transactionNote = TRANS_NOTE_CASH_RECEIPT_VOUCHER;
                    $cashReceivedVoucherCode = CASH_RECEIPT_VOUCHER_CODE . $cashReceivedVoucherInsertedId;


                    // CRV *******************************************************************************************************************************************************//
                    $transactionId = transaction($transactionType, $userCashAccount->uid, $userWalkInCustomerAccount->uid, $cashReceived, $transactionNote, $invoiceTimeStamp, $cashReceivedVoucherInsertedId, $ipAddress, $browserInfo);

                    if ($transactionId > 0) {

                        $debitOk = debit($userCashAccount->uid, $cashReceived, $transactionNote, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $cashReceivedVoucherDetailRemarks, $cashReceivedVoucherCode, $ipAddress, $browserInfo);
                        $creditOk = credit($userWalkInCustomerAccount->uid, $cashReceived, $transactionNote, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $cashReceivedVoucherDetailRemarks2, $cashReceivedVoucherCode, $ipAddress, $browserInfo);

                        if (!$debitOk || !$creditOk) {
                            $errorMessages .= "Unable to store cash receipt voucher entries!\n";
                            $rollBack = true;
                            $error = true;
                            break;
                        }

                    } else {
                        $errorMessages .= "Unable to store transaction!\n";
                        $rollBack = true;
                        $error = true;
                        break;
                    }
                    //***************************************************************************************************************************************************************//


                } else {
                    $errorMessages .= "Unable to store cash receipt voucher!\n";
                    $rollBack = true;
                    $error = true;
                    break;
                }

            } else {
                $rollBack = true;
                $error = true;
                break;
            }

        }
        // Cash Received Voucher If any ************************************************//



        // Bank Received Voucher If any ************************************************//
        if ($creditCardMachineId > 0) {
            if ($creditCardAmountReceived > 0 ) {
                $transactionId = transaction(0, $creditCardAccountUID, $userWalkInCustomerAccount->uid, $creditCardAmountReceived, '', $invoiceTimeStamp, 0, $ipAddress, $browserInfo);

                $debitOk = debit($creditCardAccountUID, $creditCardAmountReceived, '', $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, '', $voucherCode, $ipAddress, $browserInfo);
                $creditOk = credit($userWalkInCustomerAccount->uid, $creditCardAmountReceived, '', $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, '', $voucherCode, $ipAddress, $browserInfo);

                if (!$debitOk || !$creditOk) {
                    $errorMessages .= "Unable to store Credit Card amount!\n";
                    $rollBack = true;
                    $error = true;
                    break;
                }
            }
        }


//        if ($creditCardMachineId > 0) {
//
//            $serviceChargesAmount = ($creditCardAmountReceived * $creditCardMachineCharges) / 100;
//            $creditCardAmountForBank = $creditCardAmountReceived - $serviceChargesAmount;
//
//            if ($creditCardAmountReceived > 0 ) {
//
//                $totalCreditCardSaleAmount += $creditCardAmountForBank;
//                $totalCreditCardChargesAmount += $serviceChargesAmount;
//
//                $bankReceivedDetailRemarks = $userWalkInCustomerAccount->name . '@' . $creditCardAmountReceived;
//
//                $bankAccount = getAccount($creditCardBankAccountUID);
//                $bankAccountName = $bankAccount->properties->account_name;
//
//                $bankSCAccount = getAccount($creditCardBankSCAccountUID);
//                $bankSCAccountName = $bankSCAccount->properties->account_name;
//
//                $ledgerBankDetailRemarks = $bankAccountName . ' Dr@' . $creditCardAmountForBank . '\r\n';
//                $ledgerBankDetailRemarks .= $bankSCAccountName . ' Dr@' . $serviceChargesAmount . '\r\n';
//                $ledgerBankDetailRemarks .= $userWalkInCustomerAccount->name . ' Cr@' . $creditCardAmountReceived;
//
//                $bankReceivedQuery = "INSERT INTO financials_bank_receipt_voucher(br_account_id, br_bank_amount, br_total_amount, br_remarks, br_created_datetime, br_day_end_id, br_day_end_date, br_createdby, br_detail_remarks, br_ip_adrs, br_brwsr_info)
//                                        VALUES ($creditCardBankAccountUID, $creditCardAmountForBank, $creditCardAmountReceived, '$voucherCode', '$invoiceTimeStamp', $dayEndId, '$dayEndDate', $loginUserId, '$bankReceivedDetailRemarks', '$ipAddress', '$browserInfo');";
//
//                $bankReceivedResult = $database->query($bankReceivedQuery);
//
//                if ($bankReceivedResult && $database->affected_rows() == 1) {
//
//                    $bankReceivedVoucherInsertedId = $database->inserted_id();
//
//                    $bankReceivedItemsQuery = "INSERT INTO financials_bank_receipt_voucher_items(bri_voucher_id, bri_account_id, bri_account_name, bri_type, bri_amount, bri_remarks)
//                                                VALUES ($bankReceivedVoucherInsertedId, $creditCardBankSCAccountUID, '$bankSCAccountName', 'DR', $serviceChargesAmount, ''),
//                                                       ($bankReceivedVoucherInsertedId, $userWalkInCustomerAccount->uid, '$userWalkInCustomerAccount->name', 'CR', $creditCardAmountReceived, '');";
//
//                    $bankReceivedItemsResult = $database->query($bankReceivedItemsQuery);
//
//                    if ($bankReceivedItemsResult && $database->affected_rows() == 2) {
//
//                        $transactionType = BANK_RECEIPT;
//                        $transactionNote = TRANS_NOTE_BANK_RECEIPT_VOUCHER;
//                        $bankReceivedVoucherCode = BANK_RECEIPT_VOUCHER_CODE . $bankReceivedVoucherInsertedId;
//
//
//                        // BRV *******************************************************************************************************************************************************//
//                        $transactionId = transaction($transactionType, $creditCardBankAccountUID, 0, $creditCardAmountForBank, $transactionNote, $invoiceTimeStamp, $bankReceivedVoucherInsertedId, $ipAddress, $browserInfo);
//                        $transactionId2 = transaction($transactionType, $creditCardBankSCAccountUID, 0, $serviceChargesAmount, $transactionNote, $invoiceTimeStamp, $bankReceivedVoucherInsertedId, $ipAddress, $browserInfo);
//                        $transactionId3 = transaction($transactionType, 0, $userWalkInCustomerAccount->uid, $creditCardAmountReceived, $transactionNote, $invoiceTimeStamp, $bankReceivedVoucherInsertedId, $ipAddress, $browserInfo);
//
//                        if ($transactionId > 0 && $transactionId2 > 0 && $transactionId3 > 0) {
//
//                            $debitOk = debit($creditCardBankAccountUID, $creditCardAmountForBank, $transactionNote, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $ledgerBankDetailRemarks, $bankReceivedVoucherCode, $ipAddress, $browserInfo);
//                            $debit2Ok = debit($creditCardBankSCAccountUID, $serviceChargesAmount, $transactionNote, $transactionId2, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $ledgerBankDetailRemarks, $bankReceivedVoucherCode, $ipAddress, $browserInfo);
//                            $creditOk = credit($userWalkInCustomerAccount->uid, $creditCardAmountReceived, $transactionNote, $transactionId3, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $ledgerBankDetailRemarks, $bankReceivedVoucherCode, $ipAddress, $browserInfo);
//
//                            if (!$debitOk || !$debit2Ok || !$creditOk) {
//                                $errorMessages .= "Unable to store Bank receipt voucher entries!\n";
//                                $rollBack = true;
//                                $error = true;
//                                break;
//                            }
//
//                        } else {
//                            $errorMessages .= "Unable to store transaction!\n";
//                            $rollBack = true;
//                            $error = true;
//                            break;
//                        }
//                        //***************************************************************************************************************************************************************//
//
//
//
//                    } else {
//                        $errorMessages .= "Unable to store Bank Receipt Voucher!\n";
//                        $rollBack = true;
//                        $error = true;
//                        break;
//                    }
//
//                } else {
//                    $errorMessages .= "Unable to store Bank Receipt Voucher!\n";
//                    $rollBack = true;
//                    $error = true;
//                    break;
//                }
//
//            }
//        }

        // Bank Received Voucher If any ************************************************//

    }
    
}

}


/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/

foreach ($serviceInvoiceList as $invoice) {

    $serviceInvoices++;
    $savedInvoices++;
    
    $localInvoiceId = $database->escape_value($invoice->id);
    $invoiceTimeStamp = $database->escape_value($invoice->si_datetime);
    
    $query = "SELECT sei_id FROM financials_service_invoice WHERE sei_datetime = '$invoiceTimeStamp' AND sei_local_invoice_id=$localInvoiceId AND sei_createdby=$loginUserId;";
    $result = $database->query_rows($query);
    if(!$result){
    $partyCode = $database->escape_value($userWalkInCustomerAccount->uid);
    $partyName = $database->escape_value($userWalkInCustomerAccount->name);
    $customerName = $invoice->customer_name;
    $remarks = $database->escape_value($invoice->remarks);
    $totalItems = $database->escape_value($invoice->total_items);
    $totalPrice = $database->escape_value($invoice->total_price);
    $productDiscount = $database->escape_value($invoice->product_disc);
    $roundOffDiscount = $database->escape_value($invoice->round_off_disc);
    $cashDiscountPer = $database->escape_value($invoice->cash_disc_per);
    $cashDiscount = $database->escape_value($invoice->cash_disc_amount);
    $totalDiscount = $database->escape_value($invoice->total_discount);
    $inclusiveSalesTax = $database->escape_value($invoice->inclusive_sales_tax);
    $exclusiveSalesTax = $database->escape_value($invoice->exclusive_sales_tax);
    $totalSalesTax = $database->escape_value($invoice->total_sales_tax);
    $grandTotal = $database->escape_value($invoice->grand_total);
    $cashReceived = $database->escape_value($invoice->cash_received);
    $creditCardAmountReceived = $database->escape_value($invoice->credit_received);
    $salesPersonId = $database->escape_value($invoice->user);
    $creditCardMachineId = $database->escape_value($invoice->credit_card_machine);
    $clientPhoneNumber = $database->escape_value($invoice->si_phone_number);
    $creditCardRefNumber = $database->escape_value($invoice->si_credit_card_reference_number);
    $clientEmail = $database->escape_value($invoice->si_email);
    $whatsAppNumber = $database->escape_value($invoice->si_whatsapp);
    
    $localSaleInvoiceId = $database->escape_value($invoice->sale_invoice_id);
    $ipAddress = $database->escape_value($invoice->si_ip_adrs);
    $browserInfo = $database->escape_value($invoice->si_brwsr_info);
    
    $cashReceivedFromCustomer = $database->escape_value($invoice->cash_received_from_customer);
    $cashReturnToCustomer = $invoice->return_amount == "" ? 0 : $database->escape_value($invoice->return_amount);
    $discountType = $database->escape_value($invoice->discount_type);

    $detailRemarks = "";
    $transactionType = 0;

    $creditCardMachineName = "";
    $creditCardBankAccountUID = 0;
    $creditCardBankSCAccountUID = 0;
    $creditCardAccountUID = 0;
    $creditCardMachineCharges = 0.0;

    if ($creditCardMachineId > 0) {
        $machine = getCreditCardMachine($creditCardMachineId);

        if ($machine->found == true) {
            $creditCardMachineName = $machine->properties->ccm_title;
            $creditCardMachineCharges = $machine->properties->ccm_percentage;
            $creditCardBankAccountUID = $machine->properties->ccm_bank_code;
            $creditCardAccountUID = $machine->properties->ccm_credit_card_account_code;
            $creditCardBankSCAccountUID = $machine->properties->ccm_service_account_code;
        } else {
            dieWithError("Credit card machine not found of id: $creditCardMachineId", $database);
        }
    }

    $itemsList = $invoice->sale_items;

    foreach ($itemsList as $item) {
        $productParentCode = $database->escape_value($item->product->code);
        $productName = $database->escape_value($item->product->name);
        $itemQuantity = $database->escape_value($item->quantity);
        $itemRate = $database->escape_value($item->rate);
        $discountAmount = $database->escape_value($item->discount_amount);
        $saleTaxInclusive = $database->escape_value($item->sale_tax_inclusive);
        $saleTaxAmount = $database->escape_value($item->sale_tax_amount);
        $itemAmount = $database->escape_value($item->grand_amount);

        $inclusiveOrNot = $saleTaxInclusive == 1 ? '(Incl)' : '';
        $detailRemarks .= $productParentCode . '-' . $productName . ', ' . $itemQuantity . '@' . $itemRate . ' - ' .
            $discountAmount . ' + ' . $saleTaxAmount . $inclusiveOrNot . ' = ' . $itemAmount . '\r\n';
    }
    $detailRemarks = substr($detailRemarks, 0, strlen($detailRemarks) - 4);

    $foundSaleInvoiceId = array_search($localInvoiceId, $saleServiceInvoicesLink);
    if (!$foundSaleInvoiceId) {
        $foundSaleInvoiceId = 0;
    }

    $saleInsertQuery = "INSERT INTO financials_service_invoice(
                                    sei_party_code, sei_party_name, sei_customer_name, sei_remarks, sei_total_items, sei_total_price,
                                    sei_product_disc, sei_round_off_disc, sei_cash_disc_per, sei_cash_disc_amount, sei_total_discount,
                                    sei_inclusive_sales_tax, sei_exclusive_sales_tax, sei_total_sales_tax, sei_grand_total,
                                    sei_cash_received, sei_datetime, sei_day_end_id, sei_day_end_date, sei_createdby, sei_detail_remarks,
                                    sei_sale_person, sei_invoice_transcation_type, sei_invoice_machine_id, sei_invoice_machine_name, sei_service_charges_percentage,
                                    sei_phone_number, sei_credit_card_reference_number, sei_email, sei_whatsapp,
                                    sei_sale_invoice_id, sei_local_invoice_id, sei_local_service_invoice_id,
                                    sei_ip_adrs, sei_brwsr_info, sei_cash_received_from_customer, sei_return_amount,
                                    sei_discount_type, sei_invoice_profit)
                        VALUES (
                                $partyCode, '$partyName', '$customerName', '$remarks', $totalItems, $totalPrice, 
                                $productDiscount, $roundOffDiscount, $cashDiscountPer, $cashDiscount, $totalDiscount, 
                                $inclusiveSalesTax, $exclusiveSalesTax, $totalSalesTax, $grandTotal, 
                                $cashReceived, '$invoiceTimeStamp', $dayEndId, '$dayEndDate', $loginUserId, '$detailRemarks', 
                                $salesPersonId, $transactionType, $creditCardMachineId, '$creditCardMachineName', $creditCardMachineCharges,
                                '$clientPhoneNumber', '$creditCardRefNumber', '$clientEmail', '$whatsAppNumber', 
                                $foundSaleInvoiceId, $localInvoiceId, $localSaleInvoiceId,
                                '$ipAddress', '$browserInfo', $cashReceived, $cashReturnToCustomer, 
                                $discountType, 0);";

    $saleInsertResult = $database->query($saleInsertQuery);

    if ($saleInsertResult && $database->affected_rows() == 1) {

        $lastInsertedId = $database->inserted_id();

        if ($localSaleInvoiceId != 0 && $foundSaleInvoiceId != 0) {
            $saleServiceInvoicesLink[$foundSaleInvoiceId] = $lastInsertedId;
        }

        $voucherCode = SERVICE_VOUCHER_CODE . $lastInsertedId;

        foreach ($itemsList as $item) {
            $productParentCode = $database->escape_value($item->product->code);
            $productName = $database->escape_value($item->product->name);
            $itemQuantity = $database->escape_value($item->quantity);
            $bonusQuantity = $database->escape_value($item->bonus_quantity);
            $itemRate = $database->escape_value($item->rate);
            $discountPer = $database->escape_value($item->discount_per);
            $discountAmount = $database->escape_value($item->discount_amount);
            $afterDiscountRate = $database->escape_value($item->after_dis_rate);
            $netRate = $database->escape_value($item->net_rate);
            $saleTaxPer = $database->escape_value($item->sale_tax_per);
            $saleTaxInclusive = $database->escape_value($item->sale_tax_inclusive);
            $saleTaxAmount = $database->escape_value($item->sale_tax_amount);
            $itemAmount = $database->escape_value($item->grand_amount);
            $itemRemarks = $database->escape_value($item->remarks);

            $saleItemsQuery = "INSERT INTO financials_service_invoice_items(
                                          seii_invoice_id, seii_service_code, seii_service_name, seii_remarks, 
                                          seii_qty, seii_rate, seii_discount_per, seii_discount_amount, seii_after_dis_rate, seii_net_rate, 
                                          seii_saletax_per, seii_saletax_inclusive, seii_saletax_amount, seii_amount) 
                                VALUES (
                                        $lastInsertedId, '$productParentCode', '$productName', '$itemRemarks', 
                                        $itemQuantity, $itemRate, $discountPer, $discountAmount, $afterDiscountRate, $netRate, 
                                        $saleTaxPer, $saleTaxInclusive, $saleTaxAmount, $itemAmount);";

            $saleItemsResult = $database->query($saleItemsQuery);

            if (!$saleItemsResult || $database->affected_rows() != 1) {
                $errorMessages .= "Unable to store Service invoice!\n";
                $rollBack = true;
                $error = true;
                break;
            }

        }

        $transactionType = SERVICE_INVOICE;
        $note = TRANS_NOTE_SERVICE_INVOICE;

        // entry
        // Account              DR          CR

        // WIC                  0
        // Service Dis          0
        // Round Off Dis        0
        // Cash Dis             0
        //          Service                 0
        //          Sale Margin             0


        // WIC Dr *******************************************************************************************************************************************************//
        $transactionId = transaction($transactionType, $partyCode, 0, $grandTotal, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

        if ($transactionId > 0) {

            $ok = debit($partyCode, $grandTotal, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

            if (!$ok) {
                $errorMessages .= "Unable to store Debit entry of Walk In Customer!\n";
                $rollBack = true;
                $error = true;
                break;
            }

        } else {
            $errorMessages .= "Unable to store transaction!\n";
            $rollBack = true;
            $error = true;
            break;
        }
        //***************************************************************************************************************************************************************//


        if ($productDiscount > 0) {
            switch ($discountType) {
                case $none:

                    $totalServiceDiscountAmount = (double)$totalServiceDiscountAmount + (double)$productDiscount;

                    // Service Discount Dr *******************************************************************************************************************************************************//
                    $transactionId = transaction($transactionType, $serviceDiscountAccountUID, 0, $productDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

                    if ($transactionId > 0) {

                        $ok = debit($serviceDiscountAccountUID, $productDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                        if (!$ok) {
                            $errorMessages .= "Unable to store Debit entry of discount!\n";
                            $rollBack = true;
                            $error = true;
                            break;
                        }

                    } else {
                        $errorMessages .= "Unable to store transaction!\n";
                        $rollBack = true;
                        $error = true;
                        break;
                    }
                    //***************************************************************************************************************************************************************//
                    break;
                case $retailer:

                    $totalRetailerDiscountAmount = (double)$totalRetailerDiscountAmount + (double)$productDiscount;

                    // Retailer Discount Dr *******************************************************************************************************************************************************//
                    $transactionId = transaction($transactionType, $retailerDiscountAccountUID, 0, $productDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

                    if ($transactionId > 0) {

                        $ok = debit($retailerDiscountAccountUID, $productDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                        if (!$ok) {
                            $errorMessages .= "Unable to store Debit entry of retailer discount!\n";
                            $rollBack = true;
                            $error = true;
                            break;
                        }

                    } else {
                        $errorMessages .= "Unable to store transaction!\n";
                        $rollBack = true;
                        $error = true;
                        break;
                    }
                    //***************************************************************************************************************************************************************//
                    break;
                case $wholeSeller:

                    $totalWholeSellerDiscountAmount = (double)$totalWholeSellerDiscountAmount + (double)$productDiscount;

                    // WholeSeller Discount Dr *******************************************************************************************************************************************************//
                    $transactionId = transaction($transactionType, $wholeSellerDiscountAccountUID, 0, $productDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

                    if ($transactionId > 0) {

                        $ok = debit($wholeSellerDiscountAccountUID, $productDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                        if (!$ok) {
                            $errorMessages .= "Unable to store Debit entry of whole seller discount!\n";
                            $rollBack = true;
                            $error = true;
                            break;
                        }

                    } else {
                        $errorMessages .= "Unable to store transaction!\n";
                        $rollBack = true;
                        $error = true;
                        break;
                    }
                    //***************************************************************************************************************************************************************//
                    break;
                case $loyalty:

                    $totalLoyaltyDiscountAmount = (double)$totalLoyaltyDiscountAmount + (double)$productDiscount;

                    // loyalty Discount Dr *******************************************************************************************************************************************************//
                    $transactionId = transaction($transactionType, $loyaltyCardDiscountAccountUID, 0, $productDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

                    if ($transactionId > 0) {

                        $ok = debit($loyaltyCardDiscountAccountUID, $productDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                        if (!$ok) {
                            $errorMessages .= "Unable to store Debit entry of loyality discount!\n";
                            $rollBack = true;
                            $error = true;
                            break;
                        }

                    } else {
                        $errorMessages .= "Unable to store transaction!\n";
                        $rollBack = true;
                        $error = true;
                        break;
                    }
                    //***************************************************************************************************************************************************************//
                    break;
            }
        }


        if ($roundOffDiscount != 0) {

            $totalRoundOffDiscountAmount = (double)$totalRoundOffDiscountAmount + (double)$roundOffDiscount;

            // round off Discount Dr *******************************************************************************************************************************************************//
            $transactionId = transaction($transactionType, $roundOffDiscountAccountUID, 0, $roundOffDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

            if ($transactionId > 0) {

                $ok = debit($roundOffDiscountAccountUID, $roundOffDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                if (!$ok) {
                    $errorMessages .= "Unable to store Debit entry of round off discount!\n";
                    $rollBack = true;
                    $error = true;
                    break;
                }

            } else {
                $errorMessages .= "Unable to store transaction!\n";
                $rollBack = true;
                $error = true;
                break;
            }
            //***************************************************************************************************************************************************************//
        }


        if ($cashDiscount > 0) {

            $totalCashDiscountAmount = (double)$totalCashDiscountAmount + (double)$cashDiscount;

            // Cash Discount Dr *******************************************************************************************************************************************************//
            $transactionId = transaction($transactionType, $cashDiscountAccountUID, 0, $cashDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

            if ($transactionId > 0) {

                $ok = debit($cashDiscountAccountUID, $cashDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                if (!$ok) {
                    $errorMessages .= "Unable to store Debit entry of cash discount!\n";
                    $rollBack = true;
                    $error = true;
                    break;
                }

            } else {
                $errorMessages .= "Unable to store transaction!\n";
                $rollBack = true;
                $error = true;
                break;
            }
            //***************************************************************************************************************************************************************//
        }

        $serviceAmount = (double)$grandTotal + (double)$totalDiscount - (double)$totalSalesTax;
        $totalServiceAmount = $totalServiceAmount + $serviceAmount;

        // Service Cr *******************************************************************************************************************************************************//
        $transactionId = transaction($transactionType, $serviceAccountUID, 0, $serviceAmount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

        if ($transactionId > 0) {

            $ok = credit($serviceAccountUID, $serviceAmount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

            if (!$ok) {
                $errorMessages .= "Unable to store Credit entry of service!\n";
                $rollBack = true;
                $error = true;
                break;
            }

        } else {
            $errorMessages .= "Unable to store transaction!\n";
            $rollBack = true;
            $error = true;
            break;
        }
        //***************************************************************************************************************************************************************//


        if ($totalSalesTax > 0) {

            $totalServiceMarginAmount += (double)$totalSalesTax;

            // Sale Margin Cr *******************************************************************************************************************************************************//
            $transactionId = transaction($transactionType, $salesMarginAccountUID, 0, $totalSalesTax, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

            if ($transactionId > 0) {

                $ok = credit($salesMarginAccountUID, $totalSalesTax, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                if (!$ok) {
                    $errorMessages .= "Unable to store Credit entry of Sales margin!\n";
                    $rollBack = true;
                    $error = true;
                    break;
                }

            } else {
                $errorMessages .= "Unable to store transaction!\n";
                $rollBack = true;
                $error = true;
                break;
            }
            //***************************************************************************************************************************************************************//
        }



        // Cash Received Voucher If any ************************************************//
        if ($cashReceived > 0) {

            $cashReceivedVoucherDetailRemarks = $userWalkInCustomerAccount->name . '@' . $cashReceived;
            $cashReceivedVoucherDetailRemarks2 = $userCashAccount->name . '@' . $cashReceived;

            $cashReceivedQuery = "INSERT INTO financials_cash_receipt_voucher(cr_account_id, cr_total_amount, cr_remarks, cr_created_datetime, cr_day_end_id, cr_day_end_date, cr_createdby, cr_detail_remarks, cr_ip_adrs, cr_brwsr_info) 
                                    VALUES ($userCashAccount->uid, $cashReceived, '$voucherCode', '$invoiceTimeStamp', $dayEndId, '$dayEndDate', $loginUserId, '$cashReceivedVoucherDetailRemarks', '$ipAddress', '$browserInfo');";

            $cashReceivedResult = $database->query($cashReceivedQuery);

            if ($cashReceivedResult && $database->affected_rows() == 1) {

                $cashReceivedVoucherInsertedId = $database->inserted_id();

                $cashReceivedItemsQuery = "INSERT INTO financials_cash_receipt_voucher_items(cri_voucher_id, cri_account_id, cri_account_name, cri_amount, cri_remarks) 
                                            VALUES ($cashReceivedVoucherInsertedId, $userWalkInCustomerAccount->uid, '$userWalkInCustomerAccount->name', $cashReceived, '');";

                $cashReceivedItemsResult = $database->query($cashReceivedItemsQuery);

                if ($cashReceivedItemsResult && $database->affected_rows() == 1) {

                    $transactionType = CASH_RECEIPT;
                    $transactionNote = TRANS_NOTE_CASH_RECEIPT_VOUCHER;
                    $cashReceivedVoucherCode = CASH_RECEIPT_VOUCHER_CODE . $cashReceivedVoucherInsertedId;


                    // CRV *******************************************************************************************************************************************************//
                    $transactionId = transaction($transactionType, $userCashAccount->uid, $userWalkInCustomerAccount->uid, $cashReceived, $transactionNote, $invoiceTimeStamp, $cashReceivedVoucherInsertedId, $ipAddress, $browserInfo);

                    if ($transactionId > 0) {

                        $debitOk = debit($userCashAccount->uid, $cashReceived, $transactionNote, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $cashReceivedVoucherDetailRemarks, $cashReceivedVoucherCode, $ipAddress, $browserInfo);
                        $creditOk = credit($userWalkInCustomerAccount->uid, $cashReceived, $transactionNote, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $cashReceivedVoucherDetailRemarks2, $cashReceivedVoucherCode, $ipAddress, $browserInfo);

                        if (!$debitOk || !$creditOk) {
                            $errorMessages .= "Unable to store entries of cash receipt voucher!\n";
                            $rollBack = true;
                            $error = true;
                            break;
                        }

                    } else {
                        $errorMessages .= "Unable to store transaction!\n";
                        $rollBack = true;
                        $error = true;
                        break;
                    }
                    //***************************************************************************************************************************************************************//


                } else {
                    $errorMessages .= "Unable to store Cash Receipt Voucher!\n";
                    $rollBack = true;
                    $error = true;
                    break;
                }

            } else {
                $errorMessages .= "Unable to store Cash Receipt Voucher!\n";
                $rollBack = true;
                $error = true;
                break;
            }

        }
        // Cash Received Voucher If any ************************************************//



        // Bank Received Voucher If any ************************************************//
        if ($creditCardMachineId > 0) {
            if ($creditCardAmountReceived > 0 ) {
                $transactionId = transaction(0, $creditCardAccountUID, $userWalkInCustomerAccount->uid, $creditCardAmountReceived, '', $invoiceTimeStamp, 0, $ipAddress, $browserInfo);

                $debitOk = debit($creditCardAccountUID, $creditCardAmountReceived, '', $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, '', $voucherCode, $ipAddress, $browserInfo);
                $creditOk = credit($userWalkInCustomerAccount->uid, $creditCardAmountReceived, '', $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, '', $voucherCode, $ipAddress, $browserInfo);

                if (!$debitOk || !$creditOk) {
                    $errorMessages .= "Unable to store Credit Card amount!\n";
                    $rollBack = true;
                    $error = true;
                    break;
                }
            }
        }


//        if ($creditCardMachineId > 0) {
//
//            $serviceChargesAmount = ($creditCardAmountReceived * $creditCardMachineCharges) / 100;
//            $creditCardAmountForBank = $creditCardAmountReceived - $serviceChargesAmount;
//
//            if ($creditCardAmountReceived > 0 ) {
//
//                $totalCreditCardSaleAmount += $creditCardAmountForBank;
//                $totalCreditCardChargesAmount += $serviceChargesAmount;
//
//                $bankReceivedDetailRemarks = $userWalkInCustomerAccount->name . '@' . $creditCardAmountReceived;
//
//                $bankAccount = getAccount($creditCardBankAccountUID);
//                $bankAccountName = $bankAccount->properties->account_name;
//
//                $bankSCAccount = getAccount($creditCardBankSCAccountUID);
//                $bankSCAccountName = $bankSCAccount->properties->account_name;
//
//                $ledgerBankDetailRemarks = $bankAccountName . ' Dr@' . $creditCardAmountForBank . '\r\n';
//                $ledgerBankDetailRemarks .= $bankSCAccountName . ' Dr@' . $serviceChargesAmount . '\r\n';
//                $ledgerBankDetailRemarks .= $userWalkInCustomerAccount->name . ' Cr@' . $creditCardAmountReceived;
//
//                $bankReceivedQuery = "INSERT INTO financials_bank_receipt_voucher(br_account_id, br_bank_amount, br_total_amount, br_remarks, br_created_datetime, br_day_end_id, br_day_end_date, br_createdby, br_detail_remarks, br_ip_adrs, br_brwsr_info)
//                                        VALUES ($creditCardBankAccountUID, $creditCardAmountForBank, $creditCardAmountReceived, '$voucherCode', '$invoiceTimeStamp', $dayEndId, '$dayEndDate', $loginUserId, '$bankReceivedDetailRemarks', '$ipAddress', '$browserInfo');";
//
//                $bankReceivedResult = $database->query($bankReceivedQuery);
//
//                if ($bankReceivedResult && $database->affected_rows() == 1) {
//
//                    $bankReceivedVoucherInsertedId = $database->inserted_id();
//
//                    $bankReceivedItemsQuery = "INSERT INTO financials_bank_receipt_voucher_items(bri_voucher_id, bri_account_id, bri_account_name, bri_type, bri_amount, bri_remarks)
//                                                VALUES ($bankReceivedVoucherInsertedId, $creditCardBankSCAccountUID, '$bankSCAccountName', 'DR', $serviceChargesAmount, ''),
//                                                       ($bankReceivedVoucherInsertedId, $userWalkInCustomerAccount->uid, '$userWalkInCustomerAccount->name', 'CR', $creditCardAmountReceived, '');";
//
//                    $bankReceivedItemsResult = $database->query($bankReceivedItemsQuery);
//
//                    if ($bankReceivedItemsResult && $database->affected_rows() == 2) {
//
//                        $transactionType = BANK_RECEIPT;
//                        $transactionNote = TRANS_NOTE_BANK_RECEIPT_VOUCHER;
//                        $bankReceivedVoucherCode = BANK_RECEIPT_VOUCHER_CODE . $bankReceivedVoucherInsertedId;
//
//
//                        // BRV *******************************************************************************************************************************************************//
//                        $transactionId = transaction($transactionType, $creditCardBankAccountUID, 0, $creditCardAmountForBank, $transactionNote, $invoiceTimeStamp, $bankReceivedVoucherInsertedId, $ipAddress, $browserInfo);
//                        $transactionId2 = transaction($transactionType, $creditCardBankSCAccountUID, 0, $serviceChargesAmount, $transactionNote, $invoiceTimeStamp, $bankReceivedVoucherInsertedId, $ipAddress, $browserInfo);
//                        $transactionId3 = transaction($transactionType, 0, $userWalkInCustomerAccount->uid, $creditCardAmountReceived, $transactionNote, $invoiceTimeStamp, $bankReceivedVoucherInsertedId, $ipAddress, $browserInfo);
//
//                        if ($transactionId > 0 && $transactionId2 > 0 && $transactionId3 > 0) {
//
//                            $debitOk = debit($creditCardBankAccountUID, $creditCardAmountForBank, $transactionNote, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $ledgerBankDetailRemarks, $bankReceivedVoucherCode, $ipAddress, $browserInfo);
//                            $debit2Ok = debit($creditCardBankSCAccountUID, $serviceChargesAmount, $transactionNote, $transactionId2, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $ledgerBankDetailRemarks, $bankReceivedVoucherCode, $ipAddress, $browserInfo);
//                            $creditOk = credit($userWalkInCustomerAccount->uid, $creditCardAmountReceived, $transactionNote, $transactionId3, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $ledgerBankDetailRemarks, $bankReceivedVoucherCode, $ipAddress, $browserInfo);
//
//                            if (!$debitOk || !$debit2Ok || !$creditOk) {
//                                $errorMessages .= "Unable to store entries of Bank Receipt Voucher!\n";
//                                $rollBack = true;
//                                $error = true;
//                                break;
//                            }
//
//                        } else {
//                            $errorMessages .= "Unable to store transaction!\n";
//                            $rollBack = true;
//                            $error = true;
//                            break;
//                        }
//                        //***************************************************************************************************************************************************************//
//
//
//
//                    } else {
//                        $errorMessages .= "Unable to store Bank Receipt Voucher!\n";
//                        $rollBack = true;
//                        $error = true;
//                        break;
//                    }
//
//                } else {
//                    $errorMessages .= "Unable to store Bank Receipt Voucher!\n";
//                    $rollBack = true;
//                    $error = true;
//                    break;
//                }
//
//            }
//        }

        // Bank Received Voucher If any ************************************************//

    }

}
}


/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/

foreach ($saleTaxInvoiceList as $invoice) {

    
    $saleTaxInvoices++;
    $savedInvoices++;
    $invoiceTimeStamp = $database->escape_value($invoice->si_datetime);
    $localInvoiceId = $database->escape_value($invoice->id);
    
    $query = "SELECT ssi_id FROM financials_sale_saletax_invoice WHERE ssi_datetime = '$invoiceTimeStamp' AND ssi_local_invoice_id='$localInvoiceId' AND ssi_createdby='$loginUserId'";
    $result = $database->query_rows($query);
    if(!$result){

    $partyCode = $database->escape_value($userWalkInCustomerAccount->uid);
    $partyName = $database->escape_value($userWalkInCustomerAccount->name);
    $customerName = $database->escape_value($invoice->customer_name);
    $remarks = $database->escape_value($invoice->remarks);
    $totalItems = $database->escape_value($invoice->total_items);
    $totalPrice = $database->escape_value($invoice->total_price);
    $productDiscount = $database->escape_value($invoice->product_disc);
    $roundOffDiscount = $database->escape_value($invoice->round_off_disc);
    $cashDiscountPer = $database->escape_value($invoice->cash_disc_per);
    $cashDiscount = $database->escape_value($invoice->cash_disc_amount);
    $totalDiscount = $database->escape_value($invoice->total_discount);
    $inclusiveSalesTax = $database->escape_value($invoice->inclusive_sales_tax);
    $exclusiveSalesTax = $database->escape_value($invoice->exclusive_sales_tax);
    $totalSalesTax = $database->escape_value($invoice->total_sales_tax);
    $grandTotal = $database->escape_value($invoice->grand_total);
    $cashReceived = $database->escape_value($invoice->cash_received);
    $creditCardAmountReceived = $database->escape_value($invoice->credit_received);
    $salesPersonId = $database->escape_value($invoice->user);
    $creditCardMachineId = $database->escape_value($invoice->credit_card_machine);
    $clientPhoneNumber = $database->escape_value($invoice->si_phone_number);
    $creditCardRefNumber = $database->escape_value($invoice->si_credit_card_reference_number);
    $clientEmail = $database->escape_value($invoice->si_email);
    $whatsAppNumber = $database->escape_value($invoice->si_whatsapp);
    
    $localServiceInvoiceId = $database->escape_value($invoice->service_invoice_id);
    $ipAddress = $database->escape_value($invoice->si_ip_adrs);
    $browserInfo = $database->escape_value($invoice->si_brwsr_info);
    
    $cashReceivedFromCustomer = $database->escape_value($invoice->cash_received_from_customer);
    $cashReturnToCustomer = $invoice->return_amount == "" ? 0 : $database->escape_value($invoice->return_amount);
    $discountType = $database->escape_value($invoice->discount_type);

    $detailRemarks = "";
    $transactionType = 0;

    $creditCardMachineName = "";
    $creditCardBankAccountUID = 0;
    $creditCardBankSCAccountUID = 0;
    $creditCardAccountUID = 0;
    $creditCardMachineCharges = 0.0;

    if ($creditCardMachineId > 0) {
        $machine = getCreditCardMachine($creditCardMachineId);

        if ($machine->found == true) {
            $creditCardMachineName = $machine->properties->ccm_title;
            $creditCardMachineCharges = $machine->properties->ccm_percentage;
            $creditCardBankAccountUID = $machine->properties->ccm_bank_code;
            $creditCardAccountUID = $machine->properties->ccm_credit_card_account_code;
            $creditCardBankSCAccountUID = $machine->properties->ccm_service_account_code;
        } else {
            dieWithError("Credit card machine not found of id: $creditCardMachineId", $database);
        }
    }

    $itemsList = $invoice->sale_items;

    foreach ($itemsList as $item) {
        $productParentCode = $database->escape_value($item->product->code);
        $productName = $database->escape_value($item->product->name);
        $itemQuantity = $database->escape_value($item->quantity);
        $itemUOM = $database->escape_value($item->uom);
        $itemRate = $database->escape_value($item->rate);
        $discountAmount = $database->escape_value($item->discount_amount);
        $saleTaxInclusive = $database->escape_value($item->sale_tax_inclusive);
        $saleTaxAmount = $database->escape_value($item->sale_tax_amount);
        $itemAmount = $database->escape_value($item->grand_amount);

        $inclusiveOrNot = $saleTaxInclusive == 1 ? '(Incl)' : '';
        $detailRemarks .= $productParentCode . '-' . $productName . ', ' . $itemQuantity . $itemUOM . '@' . $itemRate . ' - ' .
            $discountAmount . ' + ' . $saleTaxAmount . $inclusiveOrNot . ' = ' . $itemAmount . '\r\n';
    }
    $detailRemarks = substr($detailRemarks, 0, strlen($detailRemarks) - 4);
// print_r($partyCode);
    $saleInsertQuery = "INSERT INTO financials_sale_saletax_invoice(
                                    ssi_party_code, ssi_party_name, ssi_customer_name, ssi_remarks, ssi_total_items, ssi_total_price,
                                    ssi_product_disc, ssi_round_off_disc, ssi_cash_disc_per, ssi_cash_disc_amount, ssi_total_discount,
                                    ssi_inclusive_sales_tax, ssi_exclusive_sales_tax, ssi_total_sales_tax, ssi_grand_total,
                                    ssi_cash_received, ssi_datetime, ssi_day_end_id, ssi_day_end_date, ssi_createdby, ssi_detail_remarks,
                                    ssi_sale_person, ssi_invoice_transcation_type, ssi_invoice_machine_id, ssi_invoice_machine_name, ssi_service_charges_percentage,
                                    ssi_phone_number, ssi_credit_card_reference_number, ssi_email, ssi_whatsapp,
                                    ssi_service_invoice_id, ssi_local_invoice_id, ssi_local_service_invoice_id,
                                    ssi_ip_adrs, ssi_brwsr_info, ssi_cash_received_from_customer, ssi_return_amount,
                                    ssi_discount_type, ssi_invoice_profit)
                        VALUES (
                                $partyCode, '$partyName', '$customerName', '$remarks', $totalItems, $totalPrice,
                                $productDiscount, $roundOffDiscount, $cashDiscountPer, $cashDiscount, $totalDiscount,
                                $inclusiveSalesTax, $exclusiveSalesTax, $totalSalesTax, $grandTotal,
                                $cashReceived, '$invoiceTimeStamp', $dayEndId, '$dayEndDate', $loginUserId, '$detailRemarks',
                                $salesPersonId, $transactionType, $creditCardMachineId, '$creditCardMachineName', $creditCardMachineCharges,
                                '$clientPhoneNumber', '$creditCardRefNumber', '$clientEmail', '$whatsAppNumber',
                                0, $localInvoiceId, $localServiceInvoiceId,
                                '$ipAddress', '$browserInfo', $cashReceived, $cashReturnToCustomer,
                                $discountType, 0);";

    $saleInsertResult = $database->query($saleInsertQuery);

    if ($saleInsertResult && $database->affected_rows() == 1) {

        $lastInsertedId = $database->inserted_id();

        if ($localServiceInvoiceId != 0) {
            $saleServiceTaxInvoicesLink[$lastInsertedId] = $localServiceInvoiceId;
        }

        $voucherCode = SALE_TEX_SALE_VOUCHER_CODE . $lastInsertedId;

        $actualStockAmount = 0;

        foreach ($itemsList as $item) {
            $productParentCode = $database->escape_value($item->product->code);
            $productName = $database->escape_value($item->product->name);
            $itemQuantity = $database->escape_value($item->quantity);
            $bonusQuantity = $database->escape_value($item->bonus_quantity);
            $itemUOM = $database->escape_value($item->uom);
            $itemWarehouseId = $database->escape_value($item->warehouse);
            $itemRate = $database->escape_value($item->rate);
            $discountPer = $database->escape_value($item->discount_per);
            $discountAmount = $database->escape_value($item->discount_amount);
            $afterDiscountRate = $database->escape_value($item->after_dis_rate);
            $netRate = $database->escape_value($item->net_rate);
            $saleTaxPer = $database->escape_value($item->sale_tax_per);
            $saleTaxInclusive = $database->escape_value($item->sale_tax_inclusive);
            $saleTaxAmount = $database->escape_value($item->sale_tax_amount);
            $itemAmount = $database->escape_value($item->grand_amount);
            $itemRemarks = $database->escape_value($item->remarks);

            $saleItemsQuery = "INSERT INTO financials_sale_saletax_invoice_items(
                                          ssii_invoice_id, ssii_product_code, ssii_product_name, ssii_remarks,
                                          ssii_qty, ssii_uom, ssii_bonus_qty, ssii_rate, ssii_discount_per, ssii_discount_amount, ssii_after_dis_rate, ssii_net_rate,
                                          ssii_saletax_per, ssii_saletax_inclusive, ssii_saletax_amount, ssii_amount, ssii_product_profit)
                                VALUES (
                                        $lastInsertedId, '$productParentCode', '$productName', '$itemRemarks',
                                        $itemQuantity, '$itemUOM', $bonusQuantity, $itemRate, $discountPer, $discountAmount, $afterDiscountRate, $netRate,
                                        $saleTaxPer, $saleTaxInclusive, $saleTaxAmount, $itemAmount, 0);";

            $saleItemsResult = $database->query($saleItemsQuery);

            if (!$saleItemsResult || $database->affected_rows() != 1) {
                $errorMessages .= "Unable to store sale tax invoice!\n";
                $rollBack = true;
                $error = true;
                break;
            }

//            addProductQuantity($productParentCode, $itemQuantity * -1);
            $whUpdated = addProductQuantityInWarehouse($productParentCode, ($itemQuantity + $bonusQuantity) * -1, $itemWarehouseId);

            if ($whUpdated == 0) {
                $errorMessages .= "Unable to store product quantitiy at warehouse!\n";
                $rollBack = true;
                $error = true;
                break;
            }

            // stock movement entry
            $lastRecord = getStockMovementLastEntry($productParentCode);

            $lastQuantity = 0;
            $lastRate = 0;

            if ($lastRecord->found == true) {
                $lastEntry = $lastRecord->properties;
                $lastQuantity = $lastEntry->sm_bal_total_qty_wo_bonus;
                $lastRate = $lastEntry->sm_bal_rate;

                $actualStockAmount += ($itemQuantity * $lastRate);

                $smInserted = saleEntryOfStockMovement($lastEntry, $itemQuantity, $bonusQuantity, $itemRate, $voucherCode, $dayEndId, $dayEndDate, $loginUserId, $invoiceTimeStamp);

                if ($smInserted == false) {
                    $errorMessages .= "Unable to store quantity at stock movement!\n";
                    $rollBack = true;
                    $error = true;
                    break;
                }
            }

/*
            $smType = SM_TYPE_SALE;

            $salAmount = $itemQuantity * $itemRate;
            $balQuantity = $lastQuantity - $itemQuantity;
            $balAmount = $balQuantity * $lastRate;

            $insertStockMovementQuery = "INSERT INTO financials_stock_movement(sm_type,
                                      sm_product_code, sm_product_name, sm_pur_qty, sm_pur_rate, sm_pur_total,
                                      sm_sale_qty, sm_sale_rate, sm_sale_total,
                                      sm_bal_qty, sm_bal_rate, sm_bal_total,
                                      sm_day_end_id, sm_day_end_date, sm_voucher_code, sm_remarks, sm_user_id, sm_date_time)
                                      VALUES ('$smType',
                                              '$productParentCode', '$productName', 0, 0, 0,
                                              $itemQuantity, $itemRate, $salAmount,
                                              $balQuantity, $lastRate, $balAmount,
                                              $dayEndId, '$dayEndDate', '$voucherCode', '', $loginUserId, '$invoiceTimeStamp'
                                      );";

            $insertStockMovementResult = $database->query($insertStockMovementQuery);

            if (!$insertStockMovementResult || $database->affected_rows() != 1) {
                $rollBack = true;
                $error = true;
                break;
            }


            if ($bonusQuantity != "" && $bonusQuantity > 0) {
                addProductQuantity($productParentCode, $bonusQuantity * -1);
                addProductQuantityInWarehouse($productParentCode, $bonusQuantity * -1, $itemWarehouseId);

                // bonus stock movement entry
                $lastRecord = getStockMovementLastEntry($productParentCode);

                $lastQuantity = 0;
                $lastRate = 0;
                $lastAmount = 0;

                if ($lastRecord->found == true) {
                    $lastQuantity = $lastRecord->quantity;
                    $lastRate = $lastRecord->rate;
                    $lastAmount = $lastRecord->amount;
                }

                $smType = SM_TYPE_SALE_BONUS;

                $balQuantity = $lastQuantity - $bonusQuantity;
                $balRate = $lastRate;
                $balAmount = $balQuantity * $balRate;

                $insertStockMovementQuery = "INSERT INTO financials_stock_movement(sm_type,
                                      sm_product_code, sm_product_name, sm_pur_qty, sm_pur_rate, sm_pur_total,
                                      sm_sale_qty, sm_sale_rate, sm_sale_total,
                                      sm_bal_qty, sm_bal_rate, sm_bal_total,
                                      sm_day_end_id, sm_day_end_date, sm_voucher_code, sm_remarks, sm_user_id, sm_date_time)
                                      VALUES ('$smType',
                                              '$productParentCode', '$productName', 0, 0, 0,
                                              $bonusQuantity, 0, 0,
                                              $balQuantity, $balRate, $balAmount,
                                              $dayEndId, '$dayEndDate', '$voucherCode', '', $loginUserId, '$invoiceTimeStamp'
                                      );";

                $insertStockMovementResult = $database->query($insertStockMovementQuery);

                if (!$insertStockMovementResult || $database->affected_rows() != 1) {
                    $rollBack = true;
                    $error = true;
                    break;
                }

            }
*/
        }

        $transactionType = SALE_TAX;
        $note = TRANS_NOTE_SALE_TAX_INVOICE;

        // entry
        // Account              DR          CR

        // WIC                  0
        // Product Dis          0
        // Round Off Dis        0
        // Cash Dis             0
        //          Sales                   0
        //          FBR                     0

        // Stock                            0


        // WIC Dr *******************************************************************************************************************************************************//
        $transactionId = transaction($transactionType, $partyCode, 0, $grandTotal, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

        if ($transactionId > 0) {

            $ok = debit($partyCode, $grandTotal, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

            if (!$ok) {
                $errorMessages .= "Unable to store debit entry of Walk in Customer!\n";
                $rollBack = true;
                $error = true;
                break;
            }

        } else {
            $errorMessages .= "Unable to store transaction!\n";
            $rollBack = true;
            $error = true;
            break;
        }
        //***************************************************************************************************************************************************************//


        if ($productDiscount > 0) {
            switch ($discountType) {
                case $none:

                    $totalProductDiscountAmount = (double)$totalProductDiscountAmount + (double)$productDiscount;

                    // Product Discount Dr *******************************************************************************************************************************************************//
                    $transactionId = transaction($transactionType, $productDiscountAccountUID, 0, $productDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

                    if ($transactionId > 0) {

                        $ok = debit($productDiscountAccountUID, $productDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                        if (!$ok) {
                            $errorMessages .= "Unable to store debit entry of discount!\n";
                            $rollBack = true;
                            $error = true;
                            break;
                        }

                    } else {
                        $errorMessages .= "Unable to store transaction!\n";
                        $rollBack = true;
                        $error = true;
                        break;
                    }
                    //***************************************************************************************************************************************************************//
                    break;
                case $retailer:

                    $totalRetailerDiscountAmount = (double)$totalRetailerDiscountAmount + (double)$productDiscount;

                    // Retailer Discount Dr *******************************************************************************************************************************************************//
                    $transactionId = transaction($transactionType, $retailerDiscountAccountUID, 0, $productDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

                    if ($transactionId > 0) {

                        $ok = debit($retailerDiscountAccountUID, $productDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                        if (!$ok) {
                            $errorMessages .= "Unable to store debit entry of retailer discount!\n";
                            $rollBack = true;
                            $error = true;
                            break;
                        }

                    } else {
                        $errorMessages .= "Unable to store transaction!\n";
                        $rollBack = true;
                        $error = true;
                        break;
                    }
                    //***************************************************************************************************************************************************************//
                    break;
                case $wholeSeller:

                    $totalWholeSellerDiscountAmount = (double)$totalWholeSellerDiscountAmount + (double)$productDiscount;

                    // WholeSeller Discount Dr *******************************************************************************************************************************************************//
                    $transactionId = transaction($transactionType, $wholeSellerDiscountAccountUID, 0, $productDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

                    if ($transactionId > 0) {

                        $ok = debit($wholeSellerDiscountAccountUID, $productDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                        if (!$ok) {
                            $errorMessages .= "Unable to store debit entry of whole seller discount!\n";
                            $rollBack = true;
                            $error = true;
                            break;
                        }

                    } else {
                        $errorMessages .= "Unable to store transaction!\n";
                        $rollBack = true;
                        $error = true;
                        break;
                    }
                    //***************************************************************************************************************************************************************//
                    break;
                case $loyalty:

                    $totalLoyaltyDiscountAmount = (double)$totalLoyaltyDiscountAmount + (double)$productDiscount;

                    // loyalty Discount Dr *******************************************************************************************************************************************************//
                    $transactionId = transaction($transactionType, $loyaltyCardDiscountAccountUID, 0, $productDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

                    if ($transactionId > 0) {

                        $ok = debit($loyaltyCardDiscountAccountUID, $productDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                        if (!$ok) {
                            $errorMessages .= "Unable to store debit entry of loyality discount!\n";
                            $rollBack = true;
                            $error = true;
                            break;
                        }

                    } else {
                        $errorMessages .= "Unable to store transaction!\n";
                        $rollBack = true;
                        $error = true;
                        break;
                    }
                    //***************************************************************************************************************************************************************//
                    break;
            }
        }


        if ($roundOffDiscount != 0) {

            $totalRoundOffDiscountAmount = (double)$totalRoundOffDiscountAmount + (double)$roundOffDiscount;

            // round off Discount Dr *******************************************************************************************************************************************************//
            $transactionId = transaction($transactionType, $roundOffDiscountAccountUID, 0, $roundOffDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

            if ($transactionId > 0) {

                $ok = debit($roundOffDiscountAccountUID, $roundOffDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                if (!$ok) {
                    $errorMessages .= "Unable to store debit entry of round off discount!\n";
                    $rollBack = true;
                    $error = true;
                    break;
                }

            } else {
                $errorMessages .= "Unable to store transaction!\n";
                $rollBack = true;
                $error = true;
                break;
            }
            //***************************************************************************************************************************************************************//
        }


        if ($cashDiscount > 0) {

            $totalCashDiscountAmount = (double)$totalCashDiscountAmount + (double)$cashDiscount;

            // Cash Discount Dr *******************************************************************************************************************************************************//
            $transactionId = transaction($transactionType, $cashDiscountAccountUID, 0, $cashDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

            if ($transactionId > 0) {

                $ok = debit($cashDiscountAccountUID, $cashDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                if (!$ok) {
                    $errorMessages .= "Unable to store debit entry of cash discount!\n";
                    $rollBack = true;
                    $error = true;
                    break;
                }

            } else {
                $errorMessages .= "Unable to store transaction!\n";
                $rollBack = true;
                $error = true;
                break;
            }
            //***************************************************************************************************************************************************************//
        }


        $saleAmount = (double)$grandTotal + (double)$totalDiscount - (double)$totalSalesTax;
        $totalSaleAmount = $totalSaleAmount + $saleAmount;


        // Sales Cr *******************************************************************************************************************************************************//
        $transactionId = transaction($transactionType, $salesAccountUID, 0, $saleAmount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

        if ($transactionId > 0) {

            $ok = credit($salesAccountUID, $saleAmount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

            if (!$ok) {
                $errorMessages .= "Unable to store credit entry of Sales!\n";
                $rollBack = true;
                $error = true;
                break;
            }

        } else {
            $errorMessages .= "Unable to store transaction!\n";
            $rollBack = true;
            $error = true;
            break;
        }
        //***************************************************************************************************************************************************************//


        if ($totalSalesTax > 0) {

            $totalSaleTaxAmount += (double)$totalSalesTax;

            // FBR Tax Cr *******************************************************************************************************************************************************//
            $transactionId = transaction($transactionType, $salesTaxAccountUID, 0, $totalSalesTax, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

            if ($transactionId > 0) {

                $ok = credit($salesTaxAccountUID, $totalSalesTax, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                if (!$ok) {
                    $errorMessages .= "Unable to store credit entry of sales tax!\n";
                    $rollBack = true;
                    $error = true;
                    break;
                }

            } else {
                $errorMessages .= "Unable to store transaction!\n";
                $rollBack = true;
                $error = true;
                break;
            }
            //***************************************************************************************************************************************************************//
        }


        // Stock Cr *******************************************************************************************************************************************************//
        $transactionId = transaction($transactionType, 0, $stockAccountUID, $actualStockAmount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

        if ($transactionId > 0) {

            $ok = credit($stockAccountUID, $actualStockAmount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

            if (!$ok) {
                $errorMessages .= "Unable to store credit entry of stock!\n";
                $rollBack = true;
                $error = true;
                break;
            }

        } else {
            $errorMessages .= "Unable to store transaction!\n";
            $rollBack = true;
            $error = true;
            break;
        }
        //***************************************************************************************************************************************************************//


        // Cash Received Voucher If any ************************************************//
        if ($cashReceived > 0) {

            $cashReceivedVoucherDetailRemarks = $userWalkInCustomerAccount->name . '@' . $cashReceived;
            $cashReceivedVoucherDetailRemarks2 = $userCashAccount->name . '@' . $cashReceived;

            $cashReceivedQuery = "INSERT INTO financials_cash_receipt_voucher(cr_account_id, cr_total_amount, cr_remarks, cr_created_datetime, cr_day_end_id, cr_day_end_date, cr_createdby, cr_detail_remarks, cr_ip_adrs, cr_brwsr_info)
                                    VALUES ($userCashAccount->uid, $cashReceived, '$voucherCode', '$invoiceTimeStamp', $dayEndId, '$dayEndDate', $loginUserId, '$cashReceivedVoucherDetailRemarks', '$ipAddress', '$browserInfo');";

            $cashReceivedResult = $database->query($cashReceivedQuery);

            if ($cashReceivedResult && $database->affected_rows() == 1) {

                $cashReceivedVoucherInsertedId = $database->inserted_id();

                $cashReceivedItemsQuery = "INSERT INTO financials_cash_receipt_voucher_items(cri_voucher_id, cri_account_id, cri_account_name, cri_amount, cri_remarks)
                                            VALUES ($cashReceivedVoucherInsertedId, $userWalkInCustomerAccount->uid, '$userWalkInCustomerAccount->name', $cashReceived, '');";

                $cashReceivedItemsResult = $database->query($cashReceivedItemsQuery);

                if ($cashReceivedItemsResult && $database->affected_rows() == 1) {

                    $transactionType = CASH_RECEIPT;
                    $transactionNote = TRANS_NOTE_CASH_RECEIPT_VOUCHER;
                    $cashReceivedVoucherCode = CASH_RECEIPT_VOUCHER_CODE . $cashReceivedVoucherInsertedId;


                    // CRV *******************************************************************************************************************************************************//
                    $transactionId = transaction($transactionType, $userCashAccount->uid, $userWalkInCustomerAccount->uid, $cashReceived, $transactionNote, $invoiceTimeStamp, $cashReceivedVoucherInsertedId, $ipAddress, $browserInfo);

                    if ($transactionId > 0) {

                        $debitOk = debit($userCashAccount->uid, $cashReceived, $transactionNote, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $cashReceivedVoucherDetailRemarks, $cashReceivedVoucherCode, $ipAddress, $browserInfo);
                        $creditOk = credit($userWalkInCustomerAccount->uid, $cashReceived, $transactionNote, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $cashReceivedVoucherDetailRemarks2, $cashReceivedVoucherCode, $ipAddress, $browserInfo);

                        if (!$debitOk || !$creditOk) {
                            $errorMessages .= "Unable to store entries of Cash Receipt Voucher!\n";
                            $rollBack = true;
                            $error = true;
                            break;
                        }

                    } else {
                        $errorMessages .= "Unable to store transaction!\n";
                        $rollBack = true;
                        $error = true;
                        break;
                    }
                    //***************************************************************************************************************************************************************//


                } else {
                    $errorMessages .= "Unable to store Cash Receipt Voucher!\n";
                    $rollBack = true;
                    $error = true;
                    break;
                }

            } else {
                $errorMessages .= "Unable to store Cash Receipt Voucher!\n";
                $rollBack = true;
                $error = true;
                break;
            }

        }
        // Cash Received Voucher If any ************************************************//



        // Bank Received Voucher If any ************************************************//
        if ($creditCardMachineId > 0) {
            if ($creditCardAmountReceived > 0 ) {
                $transactionId = transaction(0, $creditCardAccountUID, $userWalkInCustomerAccount->uid, $creditCardAmountReceived, '', $invoiceTimeStamp, 0, $ipAddress, $browserInfo);

                $debitOk = debit($creditCardAccountUID, $creditCardAmountReceived, '', $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, '', $voucherCode, $ipAddress, $browserInfo);
                $creditOk = credit($userWalkInCustomerAccount->uid, $creditCardAmountReceived, '', $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, '', $voucherCode, $ipAddress, $browserInfo);

                if (!$debitOk || !$creditOk) {
                    $errorMessages .= "Unable to store Credit Card amount!\n";
                    $rollBack = true;
                    $error = true;
                    break;
                }
            }
        }


//        if ($creditCardMachineId > 0) {
//
//            $serviceChargesAmount = ($creditCardAmountReceived * $creditCardMachineCharges) / 100;
//            $creditCardAmountForBank = $creditCardAmountReceived - $serviceChargesAmount;
//
//            if ($creditCardAmountReceived > 0 ) {
//
//                $totalCreditCardSaleAmount += $creditCardAmountForBank;
//                $totalCreditCardChargesAmount += $serviceChargesAmount;
//
//                $bankReceivedDetailRemarks = $userWalkInCustomerAccount->name . '@' . $creditCardAmountReceived;
//
//                $bankAccount = getAccount($creditCardBankAccountUID);
//                $bankAccountName = $bankAccount->properties->account_name;
//
//                $bankSCAccount = getAccount($creditCardBankSCAccountUID);
//                $bankSCAccountName = $bankSCAccount->properties->account_name;
//
//                $ledgerBankDetailRemarks = $bankAccountName . ' Dr@' . $creditCardAmountForBank . '\r\n';
//                $ledgerBankDetailRemarks .= $bankSCAccountName . ' Dr@' . $serviceChargesAmount . '\r\n';
//                $ledgerBankDetailRemarks .= $userWalkInCustomerAccount->name . ' Cr@' . $creditCardAmountReceived;
//
//                $bankReceivedQuery = "INSERT INTO financials_bank_receipt_voucher(br_account_id, br_bank_amount, br_total_amount, br_remarks, br_created_datetime, br_day_end_id, br_day_end_date, br_createdby, br_detail_remarks, br_ip_adrs, br_brwsr_info)
//                                        VALUES ($creditCardBankAccountUID, $creditCardAmountForBank, $creditCardAmountReceived, '$voucherCode', '$invoiceTimeStamp', $dayEndId, '$dayEndDate', $loginUserId, '$bankReceivedDetailRemarks', '$ipAddress', '$browserInfo');";
//
//                $bankReceivedResult = $database->query($bankReceivedQuery);
//
//                if ($bankReceivedResult && $database->affected_rows() == 1) {
//
//                    $bankReceivedVoucherInsertedId = $database->inserted_id();
//
//                    $bankReceivedItemsQuery = "INSERT INTO financials_bank_receipt_voucher_items(bri_voucher_id, bri_account_id, bri_account_name, bri_type, bri_amount, bri_remarks)
//                                                VALUES ($bankReceivedVoucherInsertedId, $creditCardBankSCAccountUID, '$bankSCAccountName', 'DR', $serviceChargesAmount, ''),
//                                                       ($bankReceivedVoucherInsertedId, $userWalkInCustomerAccount->uid, '$userWalkInCustomerAccount->name', 'CR', $creditCardAmountReceived, '');";
//
//                    $bankReceivedItemsResult = $database->query($bankReceivedItemsQuery);
//
//                    if ($bankReceivedItemsResult && $database->affected_rows() == 2) {
//
//                        $transactionType = BANK_RECEIPT;
//                        $transactionNote = TRANS_NOTE_BANK_RECEIPT_VOUCHER;
//                        $bankReceivedVoucherCode = BANK_RECEIPT_VOUCHER_CODE . $bankReceivedVoucherInsertedId;
//
//
//                        // BRV *******************************************************************************************************************************************************//
//                        $transactionId = transaction($transactionType, $creditCardBankAccountUID, 0, $creditCardAmountForBank, $transactionNote, $invoiceTimeStamp, $bankReceivedVoucherInsertedId, $ipAddress, $browserInfo);
//                        $transactionId2 = transaction($transactionType, $creditCardBankSCAccountUID, 0, $serviceChargesAmount, $transactionNote, $invoiceTimeStamp, $bankReceivedVoucherInsertedId, $ipAddress, $browserInfo);
//                        $transactionId3 = transaction($transactionType, 0, $userWalkInCustomerAccount->uid, $creditCardAmountReceived, $transactionNote, $invoiceTimeStamp, $bankReceivedVoucherInsertedId, $ipAddress, $browserInfo);
//
//                        if ($transactionId > 0 && $transactionId2 > 0 && $transactionId3 > 0) {
//
//                            $debitOk = debit($creditCardBankAccountUID, $creditCardAmountForBank, $transactionNote, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $ledgerBankDetailRemarks, $bankReceivedVoucherCode, $ipAddress, $browserInfo);
//                            $debit2Ok = debit($creditCardBankSCAccountUID, $serviceChargesAmount, $transactionNote, $transactionId2, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $ledgerBankDetailRemarks, $bankReceivedVoucherCode, $ipAddress, $browserInfo);
//                            $creditOk = credit($userWalkInCustomerAccount->uid, $creditCardAmountReceived, $transactionNote, $transactionId3, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $ledgerBankDetailRemarks, $bankReceivedVoucherCode, $ipAddress, $browserInfo);
//
//                            if (!$debitOk || !$debit2Ok || !$creditOk) {
//                                $errorMessages .= "Unable to store entries of Bank Receipt Voucher!\n";
//                                $rollBack = true;
//                                $error = true;
//                                break;
//                            }
//
//                        } else {
//                            $errorMessages .= "Unable to store transaction!\n";
//                            $rollBack = true;
//                            $error = true;
//                            break;
//                        }
//                        //***************************************************************************************************************************************************************//
//
//
//
//                    } else {
//                        $errorMessages .= "Unable to store Bank Receipt Voucher!\n";
//                        $rollBack = true;
//                        $error = true;
//                        break;
//                    }
//
//                } else {
//                    $errorMessages .= "Unable to store Bank Receipt Voucher!\n";
//                    $rollBack = true;
//                    $error = true;
//                    break;
//                }
//
//            }
//        }

        // Bank Received Voucher If any ************************************************//

    }

}
}


/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/

foreach ($serviceTaxInvoiceList as $invoice) {

    $serviceTaxInvoices++;
    $savedInvoices++;
    $localInvoiceId = $database->escape_value($invoice->id);
    $invoiceTimeStamp = $database->escape_value($invoice->si_datetime);
    
    $query = "SELECT sesi_id FROM financials_service_saletax_invoice WHERE sesi_datetime = '$invoiceTimeStamp' AND sesi_local_invoice_id=$localInvoiceId AND sesi_createdby=$loginUserId;";
    $result = $database->query_rows($query);
    if(!$result){

    $partyCode = $database->escape_value($userWalkInCustomerAccount->uid);
    $partyName = $database->escape_value($userWalkInCustomerAccount->name);
    $customerName = $database->escape_value($invoice->customer_name);
    $remarks = $database->escape_value($invoice->remarks);
    $totalItems = $database->escape_value($invoice->total_items);
    $totalPrice = $database->escape_value($invoice->total_price);
    $productDiscount = $database->escape_value($invoice->product_disc);
    $roundOffDiscount = $database->escape_value($invoice->round_off_disc);
    $cashDiscountPer = $database->escape_value($invoice->cash_disc_per);
    $cashDiscount = $database->escape_value($invoice->cash_disc_amount);
    $totalDiscount = $database->escape_value($invoice->total_discount);
    $inclusiveSalesTax = $database->escape_value($invoice->inclusive_sales_tax);
    $exclusiveSalesTax = $database->escape_value($invoice->exclusive_sales_tax);
    $totalSalesTax = $database->escape_value($invoice->total_sales_tax);
    $grandTotal = $database->escape_value($invoice->grand_total);
    $cashReceived = $database->escape_value($invoice->cash_received);
    $creditCardAmountReceived = $database->escape_value($invoice->credit_received);
    $salesPersonId = $database->escape_value($invoice->user);
    $creditCardMachineId = $database->escape_value($invoice->credit_card_machine);
    $clientPhoneNumber = $database->escape_value($invoice->si_phone_number);
    $creditCardRefNumber = $database->escape_value($invoice->si_credit_card_reference_number);
    $clientEmail = $database->escape_value($invoice->si_email);
    $whatsAppNumber = $database->escape_value($invoice->si_whatsapp);
    
    $localSaleInvoiceId = $database->escape_value($invoice->sale_invoice_id);
    $ipAddress = $database->escape_value($invoice->si_ip_adrs);
    $browserInfo = $database->escape_value($invoice->si_brwsr_info);
    
    $cashReceivedFromCustomer = $database->escape_value($invoice->cash_received_from_customer);
    $cashReturnToCustomer = $invoice->return_amount == "" ? 0 : $database->escape_value($invoice->return_amount);
    $discountType = $database->escape_value($invoice->discount_type);

    $detailRemarks = "";
    $transactionType = 0;

    $creditCardMachineName = "";
    $creditCardBankAccountUID = 0;
    $creditCardBankSCAccountUID = 0;
    $creditCardAccountUID = 0;
    $creditCardMachineCharges = 0.0;

    if ($creditCardMachineId > 0) {
        $machine = getCreditCardMachine($creditCardMachineId);

        if ($machine->found == true) {
            $creditCardMachineName = $machine->properties->ccm_title;
            $creditCardMachineCharges = $machine->properties->ccm_percentage;
            $creditCardBankAccountUID = $machine->properties->ccm_bank_code;
            $creditCardAccountUID = $machine->properties->ccm_credit_card_account_code;
            $creditCardBankSCAccountUID = $machine->properties->ccm_service_account_code;
        } else {
            dieWithError("Credit card machine not found of id: $creditCardMachineId", $database);
        }
    }

    $itemsList = $invoice->sale_items;

    foreach ($itemsList as $item) {
        $productParentCode = $database->escape_value($item->product->code);
        $productName = $database->escape_value($item->product->name);
        $itemQuantity = $database->escape_value($item->quantity);
        $itemRate = $database->escape_value($item->rate);
        $discountAmount = $database->escape_value($item->discount_amount);
        $saleTaxInclusive = $database->escape_value($item->sale_tax_inclusive);
        $saleTaxAmount = $database->escape_value($item->sale_tax_amount);
        $itemAmount = $database->escape_value($item->grand_amount);

        $inclusiveOrNot = $saleTaxInclusive == 1 ? '(Incl)' : '';
        $detailRemarks .= $productParentCode . '-' . $productName . ', ' . $itemQuantity . '@' . $itemRate . ' - ' .
            $discountAmount . ' + ' . $saleTaxAmount . $inclusiveOrNot . ' = ' . $itemAmount . '\r\n';
    }
    $detailRemarks = substr($detailRemarks, 0, strlen($detailRemarks) - 4);

    $foundSaleInvoiceId = array_search($localInvoiceId, $saleServiceTaxInvoicesLink);
    if (!$foundSaleInvoiceId) {
        $foundSaleInvoiceId = 0;
    }

    $saleInsertQuery = "INSERT INTO financials_service_saletax_invoice(
                                    sesi_party_code, sesi_party_name, sesi_customer_name, sesi_remarks, sesi_total_items, sesi_total_price,
                                    sesi_product_disc, sesi_round_off_disc, sesi_cash_disc_per, sesi_cash_disc_amount, sesi_total_discount,
                                    sesi_inclusive_sales_tax, sesi_exclusive_sales_tax, sesi_total_sales_tax, sesi_grand_total,
                                    sesi_cash_received, sesi_datetime, sesi_day_end_id, sesi_day_end_date, sesi_createdby, sesi_detail_remarks,
                                    sesi_sale_person, sesi_invoice_transcation_type, sesi_invoice_machine_id, sesi_invoice_machine_name, sesi_service_charges_percentage,
                                    sesi_phone_number, sesi_credit_card_reference_number, sesi_email, sesi_whatsapp,
                                    sesi_sale_invoice_id, sesi_local_invoice_id, sesi_local_service_invoice_id,
                                    sesi_ip_adrs, sesi_brwsr_info, sesi_cash_received_from_customer, sesi_return_amount,
                                    sesi_discount_type, sesi_invoice_profit)
                        VALUES (
                                $partyCode, '$partyName', '$customerName', '$remarks', $totalItems, $totalPrice,
                                $productDiscount, $roundOffDiscount, $cashDiscountPer, $cashDiscount, $totalDiscount,
                                $inclusiveSalesTax, $exclusiveSalesTax, $totalSalesTax, $grandTotal,
                                $cashReceived, '$invoiceTimeStamp', $dayEndId, '$dayEndDate', $loginUserId, '$detailRemarks',
                                $salesPersonId, $transactionType, $creditCardMachineId, '$creditCardMachineName', $creditCardMachineCharges,
                                '$clientPhoneNumber', '$creditCardRefNumber', '$clientEmail', '$whatsAppNumber',
                                $foundSaleInvoiceId, $localInvoiceId, $localSaleInvoiceId,
                                '$ipAddress', '$browserInfo', $cashReceived, $cashReturnToCustomer,
                                $discountType, 0);";

    $saleInsertResult = $database->query($saleInsertQuery);

    if ($saleInsertResult && $database->affected_rows() == 1) {

        $lastInsertedId = $database->inserted_id();

        if ($localSaleInvoiceId != 0 && $foundSaleInvoiceId != 0) {
            $saleServiceTaxInvoicesLink[$foundSaleInvoiceId] = $lastInsertedId;
        }

        $voucherCode = SERVICE_TAX_VOUCHER_CODE . $lastInsertedId;

        foreach ($itemsList as $item) {
            $productParentCode = $database->escape_value($item->product->code);
            $productName = $database->escape_value($item->product->name);
            $itemQuantity = $database->escape_value($item->quantity);
            $bonusQuantity = $database->escape_value($item->bonus_quantity);
            $itemRate = $database->escape_value($item->rate);
            $discountPer = $database->escape_value($item->discount_per);
            $discountAmount = $database->escape_value($item->discount_amount);
            $afterDiscountRate = $database->escape_value($item->after_dis_rate);
            $netRate = $database->escape_value($item->net_rate);
            $saleTaxPer = $database->escape_value($item->sale_tax_per);
            $saleTaxInclusive = $database->escape_value($item->sale_tax_inclusive);
            $saleTaxAmount = $database->escape_value($item->sale_tax_amount);
            $itemAmount = $database->escape_value($item->grand_amount);
            $itemRemarks = $database->escape_value($item->remarks);

            $saleItemsQuery = "INSERT INTO financials_service_saletax_invoice_items(
                                          sesii_invoice_id, sesii_service_code, sesii_service_name, sesii_remarks,
                                          sesii_qty, sesii_rate, sesii_discount_per, sesii_discount_amount, sesii_after_dis_rate, sesii_net_rate,
                                          sesii_saletax_per, sesii_saletax_inclusive, sesii_saletax_amount, sesii_amount)
                                VALUES (
                                        $lastInsertedId, '$productParentCode', '$productName', '$itemRemarks',
                                        $itemQuantity, $itemRate, $discountPer, $discountAmount, $afterDiscountRate, $netRate,
                                        $saleTaxPer, $saleTaxInclusive, $saleTaxAmount, $itemAmount);";

            $saleItemsResult = $database->query($saleItemsQuery);

            if (!$saleItemsResult || $database->affected_rows() != 1) {
                $errorMessages .= "Unable to store service tax invoice!\n";
                $rollBack = true;
                $error = true;
                break;
            }

        }

        $transactionType = SERVICE_SALE_TAX;
        $note = TRANS_NOTE_SERVICE_TAX_INVOICE;

        // entry
        // Account              DR          CR

        // WIC                  0
        // Service Dis          0
        // Round Off Dis        0
        // Cash Dis             0
        //          Service                 0
        //          Provence                0


        // WIC Dr *******************************************************************************************************************************************************//
        $transactionId = transaction($transactionType, $partyCode, 0, $grandTotal, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

        if ($transactionId > 0) {

            $ok = debit($partyCode, $grandTotal, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

            if (!$ok) {
                $errorMessages .= "Unable to store Debit entry of Walk in Customer!\n";
                $rollBack = true;
                $error = true;
                break;
            }

        } else {
            $errorMessages .= "Unable to store transaction!\n";
            $rollBack = true;
            $error = true;
            break;
        }
        //***************************************************************************************************************************************************************//


        if ($productDiscount > 0) {
            switch ($discountType) {
                case $none:

                    $totalServiceDiscountAmount = (double)$totalServiceDiscountAmount + (double)$productDiscount;

                    // Service Discount Dr *******************************************************************************************************************************************************//
                    $transactionId = transaction($transactionType, $serviceDiscountAccountUID, 0, $productDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

                    if ($transactionId > 0) {

                        $ok = debit($serviceDiscountAccountUID, $productDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                        if (!$ok) {
                            $errorMessages .= "Unable to store Debit entry of discount!\n";
                            $rollBack = true;
                            $error = true;
                            break;
                        }

                    } else {
                        $errorMessages .= "Unable to store transaction!\n";
                        $rollBack = true;
                        $error = true;
                        break;
                    }
                    //***************************************************************************************************************************************************************//
                    break;
                case $retailer:

                    $totalRetailerDiscountAmount = (double)$totalRetailerDiscountAmount + (double)$productDiscount;

                    // Retailer Discount Dr *******************************************************************************************************************************************************//
                    $transactionId = transaction($transactionType, $retailerDiscountAccountUID, 0, $productDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

                    if ($transactionId > 0) {

                        $ok = debit($retailerDiscountAccountUID, $productDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                        if (!$ok) {
                            $errorMessages .= "Unable to store Debit entry of retailer discount!\n";
                            $rollBack = true;
                            $error = true;
                            break;
                        }

                    } else {
                        $errorMessages .= "Unable to store transaction!\n";
                        $rollBack = true;
                        $error = true;
                        break;
                    }
                    //***************************************************************************************************************************************************************//
                    break;
                case $wholeSeller:

                    $totalWholeSellerDiscountAmount = (double)$totalWholeSellerDiscountAmount + (double)$productDiscount;

                    // WholeSeller Discount Dr *******************************************************************************************************************************************************//
                    $transactionId = transaction($transactionType, $wholeSellerDiscountAccountUID, 0, $productDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

                    if ($transactionId > 0) {

                        $ok = debit($wholeSellerDiscountAccountUID, $productDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                        if (!$ok) {
                            $errorMessages .= "Unable to store Debit entry of whole seller discount!\n";
                            $rollBack = true;
                            $error = true;
                            break;
                        }

                    } else {
                        $errorMessages .= "Unable to store transaction!\n";
                        $rollBack = true;
                        $error = true;
                        break;
                    }
                    //***************************************************************************************************************************************************************//
                    break;
                case $loyalty:

                    $totalLoyaltyDiscountAmount = (double)$totalLoyaltyDiscountAmount + (double)$productDiscount;

                    // loyalty Discount Dr *******************************************************************************************************************************************************//
                    $transactionId = transaction($transactionType, $loyaltyCardDiscountAccountUID, 0, $productDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

                    if ($transactionId > 0) {

                        $ok = debit($loyaltyCardDiscountAccountUID, $productDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                        if (!$ok) {
                            $errorMessages .= "Unable to store Debit entry of loyality discount!\n";
                            $rollBack = true;
                            $error = true;
                            break;
                        }

                    } else {
                        $errorMessages .= "Unable to store transaction!\n";
                        $rollBack = true;
                        $error = true;
                        break;
                    }
                    //***************************************************************************************************************************************************************//
                    break;
            }
        }


        if ($roundOffDiscount != 0) {

            $totalRoundOffDiscountAmount = (double)$totalRoundOffDiscountAmount + (double)$roundOffDiscount;

            // round off Discount Dr *******************************************************************************************************************************************************//
            $transactionId = transaction($transactionType, $roundOffDiscountAccountUID, 0, $roundOffDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

            if ($transactionId > 0) {

                $ok = debit($roundOffDiscountAccountUID, $roundOffDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                if (!$ok) {
                    $errorMessages .= "Unable to store Debit entry of round off discount!\n";
                    $rollBack = true;
                    $error = true;
                    break;
                }

            } else {
                $errorMessages .= "Unable to store transaction!\n";
                $rollBack = true;
                $error = true;
                break;
            }
            //***************************************************************************************************************************************************************//
        }


        if ($cashDiscount > 0) {

            $totalCashDiscountAmount = (double)$totalCashDiscountAmount + (double)$cashDiscount;

            // Cash Discount Dr *******************************************************************************************************************************************************//
            $transactionId = transaction($transactionType, $cashDiscountAccountUID, 0, $cashDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

            if ($transactionId > 0) {

                $ok = debit($cashDiscountAccountUID, $cashDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                if (!$ok) {
                    $errorMessages .= "Unable to store Debit entry of cash discount!\n";
                    $rollBack = true;
                    $error = true;
                    break;
                }

            } else {
                $errorMessages .= "Unable to store transaction!\n";
                $rollBack = true;
                $error = true;
                break;
            }
            //***************************************************************************************************************************************************************//
        }

        $serviceAmount = (double)$grandTotal + (double)$totalDiscount - (double)$totalSalesTax;
        $totalServiceAmount = $totalServiceAmount + $serviceAmount;


        // Service Cr *******************************************************************************************************************************************************//
        $transactionId = transaction($transactionType, $serviceAccountUID, 0, $serviceAmount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

        if ($transactionId > 0) {

            $ok = credit($serviceAccountUID, $serviceAmount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

            if (!$ok) {
                $errorMessages .= "Unable to store Credit entry of Service!\n";
                $rollBack = true;
                $error = true;
                break;
            }

        } else {
            $errorMessages .= "Unable to store transaction!\n";
            $rollBack = true;
            $error = true;
            break;
        }
        //***************************************************************************************************************************************************************//


        if ($totalSalesTax > 0) {

            $totalServiceTaxAmount += (double)$totalSalesTax;

            // Province Tax Cr *******************************************************************************************************************************************************//
            $transactionId = transaction($transactionType, $serviceTaxAccountUID, 0, $totalSalesTax, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

            if ($transactionId > 0) {

                $ok = credit($serviceTaxAccountUID, $totalSalesTax, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                if (!$ok) {
                    $errorMessages .= "Unable to store Credit entry of Province Tax!\n";
                    $rollBack = true;
                    $error = true;
                    break;
                }

            } else {
                $errorMessages .= "Unable to store transaction!\n";
                $rollBack = true;
                $error = true;
                break;
            }
            //***************************************************************************************************************************************************************//
        }



        // Cash Received Voucher If any ************************************************//
        if ($cashReceived > 0) {

            $cashReceivedVoucherDetailRemarks = $userWalkInCustomerAccount->name . '@' . $cashReceived;
            $cashReceivedVoucherDetailRemarks2 = $userCashAccount->name . '@' . $cashReceived;

            $cashReceivedQuery = "INSERT INTO financials_cash_receipt_voucher(cr_account_id, cr_total_amount, cr_remarks, cr_created_datetime, cr_day_end_id, cr_day_end_date, cr_createdby, cr_detail_remarks, cr_ip_adrs, cr_brwsr_info)
                                    VALUES ($userCashAccount->uid, $cashReceived, '$voucherCode', '$invoiceTimeStamp', $dayEndId, '$dayEndDate', $loginUserId, '$cashReceivedVoucherDetailRemarks', '$ipAddress', '$browserInfo');";

            $cashReceivedResult = $database->query($cashReceivedQuery);

            if ($cashReceivedResult && $database->affected_rows() == 1) {

                $cashReceivedVoucherInsertedId = $database->inserted_id();

                $cashReceivedItemsQuery = "INSERT INTO financials_cash_receipt_voucher_items(cri_voucher_id, cri_account_id, cri_account_name, cri_amount, cri_remarks)
                                            VALUES ($cashReceivedVoucherInsertedId, $userWalkInCustomerAccount->uid, '$userWalkInCustomerAccount->name', $cashReceived, '');";

                $cashReceivedItemsResult = $database->query($cashReceivedItemsQuery);

                if ($cashReceivedItemsResult && $database->affected_rows() == 1) {

                    $transactionType = CASH_RECEIPT;
                    $transactionNote = TRANS_NOTE_CASH_RECEIPT_VOUCHER;
                    $cashReceivedVoucherCode = CASH_RECEIPT_VOUCHER_CODE . $cashReceivedVoucherInsertedId;


                    // CRV *******************************************************************************************************************************************************//
                    $transactionId = transaction($transactionType, $userCashAccount->uid, $userWalkInCustomerAccount->uid, $cashReceived, $transactionNote, $invoiceTimeStamp, $cashReceivedVoucherInsertedId, $ipAddress, $browserInfo);

                    if ($transactionId > 0) {

                        $debitOk = debit($userCashAccount->uid, $cashReceived, $transactionNote, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $cashReceivedVoucherDetailRemarks, $cashReceivedVoucherCode, $ipAddress, $browserInfo);
                        $creditOk = credit($userWalkInCustomerAccount->uid, $cashReceived, $transactionNote, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $cashReceivedVoucherDetailRemarks2, $cashReceivedVoucherCode, $ipAddress, $browserInfo);

                        if (!$debitOk || !$creditOk) {
                            $errorMessages .= "Unable to store entries of Cash Receipt Voucher!\n";
                            $rollBack = true;
                            $error = true;
                            break;
                        }

                    } else {
                        $errorMessages .= "Unable to store transaction!\n";
                        $rollBack = true;
                        $error = true;
                        break;
                    }
                    //***************************************************************************************************************************************************************//


                } else {
                    $errorMessages .= "Unable to store Cash Receipt Voucher!\n";
                    $rollBack = true;
                    $error = true;
                    break;
                }

            } else {
                $errorMessages .= "Unable to store Cash Receipt Voucher!\n";
                $rollBack = true;
                $error = true;
                break;
            }

        }
        // Cash Received Voucher If any ************************************************//



        // Bank Received Voucher If any ************************************************//
        if ($creditCardMachineId > 0) {
            if ($creditCardAmountReceived > 0 ) {
                $transactionId = transaction(0, $creditCardAccountUID, $userWalkInCustomerAccount->uid, $creditCardAmountReceived, '', $invoiceTimeStamp, 0, $ipAddress, $browserInfo);

                $debitOk = debit($creditCardAccountUID, $creditCardAmountReceived, '', $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, '', $voucherCode, $ipAddress, $browserInfo);
                $creditOk = credit($userWalkInCustomerAccount->uid, $creditCardAmountReceived, '', $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, '', $voucherCode, $ipAddress, $browserInfo);

                if (!$debitOk || !$creditOk) {
                    $errorMessages .= "Unable to store Credit Card amount!\n";
                    $rollBack = true;
                    $error = true;
                    break;
                }
            }
        }


//        if ($creditCardMachineId > 0) {
//
//            $serviceChargesAmount = ($creditCardAmountReceived * $creditCardMachineCharges) / 100;
//            $creditCardAmountForBank = $creditCardAmountReceived - $serviceChargesAmount;
//
//            if ($creditCardAmountReceived > 0 ) {
//
//                $totalCreditCardSaleAmount += $creditCardAmountForBank;
//                $totalCreditCardChargesAmount += $serviceChargesAmount;
//
//                $bankReceivedDetailRemarks = $userWalkInCustomerAccount->name . '@' . $creditCardAmountReceived;
//
//                $bankAccount = getAccount($creditCardBankAccountUID);
//                $bankAccountName = $bankAccount->properties->account_name;
//
//                $bankSCAccount = getAccount($creditCardBankSCAccountUID);
//                $bankSCAccountName = $bankSCAccount->properties->account_name;
//
//                $ledgerBankDetailRemarks = $bankAccountName . ' Dr@' . $creditCardAmountForBank . '\r\n';
//                $ledgerBankDetailRemarks .= $bankSCAccountName . ' Dr@' . $serviceChargesAmount . '\r\n';
//                $ledgerBankDetailRemarks .= $userWalkInCustomerAccount->name . ' Cr@' . $creditCardAmountReceived;
//
//                $bankReceivedQuery = "INSERT INTO financials_bank_receipt_voucher(br_account_id, br_bank_amount, br_total_amount, br_remarks, br_created_datetime, br_day_end_id, br_day_end_date, br_createdby, br_detail_remarks, br_ip_adrs, br_brwsr_info)
//                                        VALUES ($creditCardBankAccountUID, $creditCardAmountForBank, $creditCardAmountReceived, '$voucherCode', '$invoiceTimeStamp', $dayEndId, '$dayEndDate', $loginUserId, '$bankReceivedDetailRemarks', '$ipAddress', '$browserInfo');";
//
//                $bankReceivedResult = $database->query($bankReceivedQuery);
//
//                if ($bankReceivedResult && $database->affected_rows() == 1) {
//
//                    $bankReceivedVoucherInsertedId = $database->inserted_id();
//
//                    $bankReceivedItemsQuery = "INSERT INTO financials_bank_receipt_voucher_items(bri_voucher_id, bri_account_id, bri_account_name, bri_type, bri_amount, bri_remarks)
//                                                VALUES ($bankReceivedVoucherInsertedId, $creditCardBankSCAccountUID, '$bankSCAccountName', 'DR', $serviceChargesAmount, ''),
//                                                       ($bankReceivedVoucherInsertedId, $userWalkInCustomerAccount->uid, '$userWalkInCustomerAccount->name', 'CR', $creditCardAmountReceived, '');";
//
//                    $bankReceivedItemsResult = $database->query($bankReceivedItemsQuery);
//
//                    if ($bankReceivedItemsResult && $database->affected_rows() == 2) {
//
//                        $transactionType = BANK_RECEIPT;
//                        $transactionNote = TRANS_NOTE_BANK_RECEIPT_VOUCHER;
//                        $bankReceivedVoucherCode = BANK_RECEIPT_VOUCHER_CODE . $bankReceivedVoucherInsertedId;
//
//
//                        // BRV *******************************************************************************************************************************************************//
//                        $transactionId = transaction($transactionType, $creditCardBankAccountUID, 0, $creditCardAmountForBank, $transactionNote, $invoiceTimeStamp, $bankReceivedVoucherInsertedId, $ipAddress, $browserInfo);
//                        $transactionId2 = transaction($transactionType, $creditCardBankSCAccountUID, 0, $serviceChargesAmount, $transactionNote, $invoiceTimeStamp, $bankReceivedVoucherInsertedId, $ipAddress, $browserInfo);
//                        $transactionId3 = transaction($transactionType, 0, $userWalkInCustomerAccount->uid, $creditCardAmountReceived, $transactionNote, $invoiceTimeStamp, $bankReceivedVoucherInsertedId, $ipAddress, $browserInfo);
//
//                        if ($transactionId > 0 && $transactionId2 > 0 && $transactionId3 > 0) {
//
//                            $debitOk = debit($creditCardBankAccountUID, $creditCardAmountForBank, $transactionNote, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $ledgerBankDetailRemarks, $bankReceivedVoucherCode, $ipAddress, $browserInfo);
//                            $debit2Ok = debit($creditCardBankSCAccountUID, $serviceChargesAmount, $transactionNote, $transactionId2, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $ledgerBankDetailRemarks, $bankReceivedVoucherCode, $ipAddress, $browserInfo);
//                            $creditOk = credit($userWalkInCustomerAccount->uid, $creditCardAmountReceived, $transactionNote, $transactionId3, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $ledgerBankDetailRemarks, $bankReceivedVoucherCode, $ipAddress, $browserInfo);
//
//                            if (!$debitOk || !$debit2Ok || !$creditOk) {
//                                $errorMessages .= "Unable to store entries of Bank Receipt Voucher!\n";
//                                $rollBack = true;
//                                $error = true;
//                                break;
//                            }
//
//                        } else {
//                            $errorMessages .= "Unable to store transaction!\n";
//                            $rollBack = true;
//                            $error = true;
//                            break;
//                        }
//                        //***************************************************************************************************************************************************************//
//
//
//
//                    } else {
//                        $errorMessages .= "Unable to store Bank Receipt Voucher!\n";
//                        $rollBack = true;
//                        $error = true;
//                        break;
//                    }
//
//                } else {
//                    $errorMessages .= "Unable to store Bank Receipt Voucher!\n";
//                    $rollBack = true;
//                    $error = true;
//                    break;
//                }
//
//            }
//        }

        // Bank Received Voucher If any ************************************************//

    }

}
}


/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/

// link sale services invoices with new inserted ids

foreach ($saleServiceInvoicesLink as $saleInvoiceId => $serviceInvoiceId) {
    $linkInvoiceQuery = "UPDATE financials_sale_invoice SET si_service_invoice_id = $serviceInvoiceId WHERE si_id = $saleInvoiceId LIMIT 1;";
    $linkInvoiceResult = $database->query($linkInvoiceQuery);
    if (!$linkInvoiceResult) {
        $errorMessages .= "Unable to store sale invoice local IDs!\n";
        $error = true;
        $rollBack = true;
        break;
    }
}

foreach ($saleServiceTaxInvoicesLink as $saleTaxInvoiceId => $serviceTaxInvoiceId) {
    $linkInvoiceQuery = "UPDATE financials_sale_saletax_invoice SET ssi_service_invoice_id = $serviceTaxInvoiceId WHERE ssi_id = $saleTaxInvoiceId LIMIT 1;";
    $linkInvoiceResult = $database->query($linkInvoiceQuery);
    if (!$linkInvoiceResult) {
        $errorMessages .= "Unable to store sale tax invoice local IDs!\n";
        $error = true;
        $rollBack = true;
        break;
    }
}

/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/

foreach ($saleReturnInvoiceList as $invoice) {

    $saleReturnInvoices++;
    $savedInvoices++;
    
    $localInvoiceId = $database->escape_value($invoice->id);
    $invoiceTimeStamp = $database->escape_value($invoice->si_datetime);
    
    $query = "SELECT sri_id FROM financials_sale_return_invoice WHERE sri_datetime = '$invoiceTimeStamp' AND sri_local_invoice_id=$localInvoiceId AND sri_createdby=$loginUserId;";
    $result = $database->query_rows($query);
    if(!$result){

    $partyCode = $database->escape_value($userWalkInCustomerAccount->uid);
    $partyName = $database->escape_value($userWalkInCustomerAccount->name);
    $customerName = $database->escape_value($invoice->customer_name);
    $remarks = $database->escape_value($invoice->remarks);
    $totalItems = $database->escape_value($invoice->total_items);
    $totalPrice = $database->escape_value($invoice->total_price);
    $productDiscount = $database->escape_value($invoice->product_disc);
    $roundOffDiscount = $database->escape_value($invoice->round_off_disc);
    $cashDiscountPer = $database->escape_value($invoice->cash_disc_per);
    $cashDiscount = $database->escape_value($invoice->cash_disc_amount);
    $totalDiscount = $database->escape_value($invoice->total_discount);
    $inclusiveSalesTax = $database->escape_value($invoice->inclusive_sales_tax);
    $exclusiveSalesTax = $database->escape_value($invoice->exclusive_sales_tax);
    $totalSalesTax = $database->escape_value($invoice->total_sales_tax);
    $grandTotal = $database->escape_value($invoice->grand_total);
    $cashReceived = $database->escape_value($invoice->cash_received);
    $salesPersonId = $database->escape_value($invoice->user);
    $creditCardMachineId = $database->escape_value($invoice->credit_card_machine);
    $clientPhoneNumber = $database->escape_value($invoice->si_phone_number);
    $creditCardRefNumber = $database->escape_value($invoice->si_credit_card_reference_number);
    $clientEmail = $database->escape_value($invoice->si_email);
    $whatsAppNumber = $database->escape_value($invoice->si_whatsapp);
    
    $localServiceInvoiceId = $database->escape_value($invoice->service_invoice_id);
    $localSaleInvoiceId = $database->escape_value($invoice->sale_invoice_id);
    $ipAddress = $database->escape_value($invoice->si_ip_adrs);
    $browserInfo = $database->escape_value($invoice->si_brwsr_info);
    
    $cashReceivedFromCustomer = $database->escape_value($invoice->cash_received_from_customer);
    $cashReturnToCustomer = $invoice->return_amount == "" ? 0 : $database->escape_value($invoice->return_amount);
    $discountType = $database->escape_value($invoice->discount_type);

    $detailRemarks = "";
    $transactionType = 0;

    $creditCardMachineName = "";
    $creditCardBankAccountUID = 0;
    $creditCardBankSCAccountUID = 0;
    $creditCardAccountUID = 0;
    $creditCardMachineCharges = 0.0;

    if ($creditCardMachineId > 0) {
        $machine = getCreditCardMachine($creditCardMachineId);

        if ($machine->found == true) {
            $creditCardMachineName = $machine->properties->ccm_title;
            $creditCardMachineCharges = $machine->properties->ccm_percentage;
            $creditCardBankAccountUID = $machine->properties->ccm_bank_code;
            $creditCardAccountUID = $machine->properties->ccm_credit_card_account_code;
            $creditCardBankSCAccountUID = $machine->properties->ccm_service_account_code;
        } else {
            dieWithError("Credit card machine not found of id: $creditCardMachineId", $database);
        }
    }

    $itemsList = $invoice->sale_items;

    foreach ($itemsList as $item) {
        $productParentCode = $database->escape_value($item->product->code);
        $productName = $database->escape_value($item->product->name);
        $itemQuantity = $database->escape_value($item->quantity);
        $itemUOM = $database->escape_value($item->uom);
        $itemRate = $database->escape_value($item->rate);
        $discountAmount = $database->escape_value($item->discount_amount);
        $saleTaxInclusive = $database->escape_value($item->sale_tax_inclusive);
        $saleTaxAmount = $database->escape_value($item->sale_tax_amount);
        $itemAmount = $database->escape_value($item->grand_amount);

        $inclusiveOrNot = $saleTaxInclusive == 1 ? '(Incl)' : '';
        $detailRemarks .= $productParentCode . '-' . $productName . ', ' . $itemQuantity . $itemUOM . '@' . $itemRate . ' - ' .
            $discountAmount . ' + ' . $saleTaxAmount . $inclusiveOrNot . ' = ' . $itemAmount . '\r\n';
    }
    $detailRemarks = substr($detailRemarks, 0, strlen($detailRemarks) - 4);

    $saleInsertQuery = "INSERT INTO financials_sale_return_invoice(
                                    sri_party_code, sri_party_name, sri_customer_name, sri_remarks, sri_total_items, sri_total_price,
                                    sri_product_disc, sri_round_off_disc, sri_cash_disc_per, sri_cash_disc_amount, sri_total_discount,
                                    sri_inclusive_sales_tax, sri_exclusive_sales_tax, sri_total_sales_tax, sri_grand_total,
                                    sri_cash_received, sri_datetime, sri_day_end_id, sri_day_end_date, sri_createdby, sri_detail_remarks,
                                    sri_sale_person, sri_invoice_transcation_type, sri_invoice_machine_id, sri_invoice_machine_name, sri_service_charges_percentage,
                                    sri_phone_number, sri_credit_card_reference_number, sri_email, sri_whatsapp,
                                    sri_service_invoice_id, sri_sale_invoice_number, sri_local_invoice_id, sri_local_service_invoice_id,
                                    sri_ip_adrs, sri_brwsr_info, sri_cash_received_from_customer, sri_return_amount,
                                    sri_discount_type, sri_invoice_profit)
                        VALUES (
                                $partyCode, '$partyName', '$customerName', '$remarks', $totalItems, $totalPrice,
                                $productDiscount, $roundOffDiscount, $cashDiscountPer, $cashDiscount, $totalDiscount,
                                $inclusiveSalesTax, $exclusiveSalesTax, $totalSalesTax, $grandTotal,
                                $cashReceived, '$invoiceTimeStamp', $dayEndId, '$dayEndDate', $loginUserId, '$detailRemarks',
                                $salesPersonId, $transactionType, $creditCardMachineId, '$creditCardMachineName', $creditCardMachineCharges,
                                '$clientPhoneNumber', '$creditCardRefNumber', '$clientEmail', '$whatsAppNumber',
                                0, $localSaleInvoiceId, $localInvoiceId, $localServiceInvoiceId,
                                '$ipAddress', '$browserInfo', $cashReceived, $cashReturnToCustomer,
                                $discountType, 0);";

    $saleInsertResult = $database->query($saleInsertQuery);

    if ($saleInsertResult && $database->affected_rows() == 1) {

        $lastInsertedId = $database->inserted_id();

        $voucherCode = SALE_RETURN_VOUCHER_CODE . $lastInsertedId;

        $actualStockAmount = 0;

        foreach ($itemsList as $item) {
            $productParentCode = $database->escape_value($item->product->code);
            $productName = $database->escape_value($item->product->name);
            $itemQuantity = $database->escape_value($item->quantity);
            $bonusQuantity = $database->escape_value($item->bonus_quantity);
            $itemUOM = $database->escape_value($item->uom);
            $itemWarehouseId = $database->escape_value($item->warehouse);
            $itemRate = $database->escape_value($item->rate);
            $discountPer = $database->escape_value($item->discount_per);
            $discountAmount = $database->escape_value($item->discount_amount);
            $afterDiscountRate = $database->escape_value($item->after_dis_rate);
            $netRate = $database->escape_value($item->net_rate);
            $saleTaxPer = $database->escape_value($item->sale_tax_per);
            $saleTaxInclusive = $database->escape_value($item->sale_tax_inclusive);
            $saleTaxAmount = $database->escape_value($item->sale_tax_amount);
            $itemAmount = $database->escape_value($item->grand_amount);
            $itemRemarks = $database->escape_value($item->remarks);

            $saleItemsQuery = "INSERT INTO financials_sale_return_invoice_items(
                                          srii_invoice_id, srii_product_code, srii_product_name, srii_remarks,
                                          srii_qty, srii_uom, srii_bonus_qty, srii_rate, srii_discount_per, srii_discount_amount, srii_after_dis_rate, srii_net_rate,
                                          srii_saletax_per, srii_saletax_inclusive, srii_saletax_amount, srii_amount, srii_product_profit)
                                VALUES (
                                        $lastInsertedId, '$productParentCode', '$productName', '$itemRemarks',
                                        $itemQuantity, '$itemUOM', $bonusQuantity, $itemRate, $discountPer, $discountAmount, $afterDiscountRate, $netRate,
                                        $saleTaxPer, $saleTaxInclusive, $saleTaxAmount, $itemAmount, 0);";

            $saleItemsResult = $database->query($saleItemsQuery);

            if (!$saleItemsResult || $database->affected_rows() != 1) {
                $errorMessages .= "Unable to store sale return invoice!\n";
                $rollBack = true;
                $error = true;
                break;
            }

//            addProductQuantity($productParentCode, $itemQuantity);
            $whUpdated = addProductQuantityInWarehouse($productParentCode, $itemQuantity + $bonusQuantity, $itemWarehouseId);

            if ($whUpdated == 0) {
                $errorMessages .= "Unable to store product quantity in warehouse!\n";
                $rollBack = true;
                $error = true;
                break;
            }

            // stock movement entry
            $lastRecord = getStockMovementLastEntry($productParentCode);

            $lastQuantity = 0;
            $lastRate = 0;
            $lastAmount = 0;

            if ($lastRecord->found == true) {
                $lastEntry = $lastRecord->properties;
                $lastQuantity = $lastEntry->sm_bal_total_qty_wo_bonus;
                $lastRate = $lastEntry->sm_bal_rate;

                $actualStockAmount += ($itemQuantity * $lastRate);

                $smInserted = saleReturnEntryOfStockMovement($lastEntry, $itemQuantity, $bonusQuantity, $itemRate, $voucherCode, $dayEndId, $dayEndDate, $loginUserId, $invoiceTimeStamp);

                if ($smInserted == false) {
                    $errorMessages .= "Unable to store product quantity at stock movement!\n";
                    $rollBack = true;
                    $error = true;
                    break;
                }
            }

/*
            if ($lastRecord->found == true) {
                $lastQuantity = $lastRecord->quantity;
                $lastRate = $lastRecord->rate;
                $lastAmount = $lastRecord->amount;

                $actualStockAmount += ($itemQuantity * $lastRate);
            }

            $smType = SM_TYPE_SALE_RETURN;

            $salAmount = $itemQuantity * $lastRate;
            $balQuantity = (int)$lastQuantity + (int)$itemQuantity;
            $balAmount = $lastAmount + $salAmount;
            $balRate =  $balQuantity == 0 ? 0 : $balAmount / $balQuantity;

            $insertStockMovementQuery = "INSERT INTO financials_stock_movement(sm_type,
                                      sm_product_code, sm_product_name, sm_pur_qty, sm_pur_rate, sm_pur_total,
                                      sm_sale_qty, sm_sale_rate, sm_sale_total,
                                      sm_bal_qty, sm_bal_rate, sm_bal_total,
                                      sm_day_end_id, sm_day_end_date, sm_voucher_code, sm_remarks, sm_user_id, sm_date_time)
                                      VALUES ('$smType',
                                              '$productParentCode', '$productName', $itemQuantity, $lastRate, $salAmount,
                                              0, 0, 0,
                                              $balQuantity, $balRate, $balAmount,
                                              $dayEndId, '$dayEndDate', '$voucherCode', '', $loginUserId, '$invoiceTimeStamp'
                                      );";

            $insertStockMovementResult = $database->query($insertStockMovementQuery);

            if (!$insertStockMovementResult || $database->affected_rows() != 1) {
                $rollBack = true;
                $error = true;
                break;
            }


            if ($bonusQuantity != "" && $bonusQuantity > 0) {
                addProductQuantity($productParentCode, $bonusQuantity);
                addProductQuantityInWarehouse($productParentCode, $bonusQuantity, $itemWarehouseId);

                // bonus stock movement entry
                $lastRecord = getStockMovementLastEntry($productParentCode);

                $lastQuantity = 0;
                $lastRate = 0;
                $lastAmount = 0;

                if ($lastRecord->found == true) {
                    $lastQuantity = $lastRecord->quantity;
                    $lastRate = $lastRecord->rate;
                    $lastAmount = $lastRecord->amount;
                }

                $smType = SM_TYPE_SALE_BONUS;

                $salAmount = $itemQuantity * $itemRate;
                $balQuantity = (int)$lastQuantity + (int)$bonusQuantity;
                $balAmount = $lastAmount + $salAmount;
                $balRate =  $balQuantity == 0 ? 0 : $balAmount / $balQuantity;

                $insertStockMovementQuery = "INSERT INTO financials_stock_movement(sm_type,
                                      sm_product_code, sm_product_name, sm_pur_qty, sm_pur_rate, sm_pur_total,
                                      sm_sale_qty, sm_sale_rate, sm_sale_total,
                                      sm_bal_qty, sm_bal_rate, sm_bal_total,
                                      sm_day_end_id, sm_day_end_date, sm_voucher_code, sm_remarks, sm_user_id, sm_date_time)
                                      VALUES ('$smType',
                                              '$productParentCode', '$productName', $bonusQuantity, 0, 0,
                                              0, 0, 0,
                                              $balQuantity, $balRate, $balAmount,
                                              $dayEndId, '$dayEndDate', '$voucherCode', '', $loginUserId, '$invoiceTimeStamp'
                                      );";

                $insertStockMovementResult = $database->query($insertStockMovementQuery);

                if (!$insertStockMovementResult || $database->affected_rows() != 1) {
                    $rollBack = true;
                    $error = true;
                    break;
                }

            }
*/
        }

        $transactionType = SALE_RETURN;
        $note = TRANS_NOTE_SALE_RETURN_INVOICE;

        // entry
        // Account              DR          CR

        // Sales                0
        // Margin               0
        //       WIC                        0
        //       Product Dis                0
        //       Round Off Dis              0
        //       Cash Dis                   0

        // Stock                0


        $saleReturnAmount = (double)$grandTotal + (double)$totalDiscount - (double)$totalSalesTax;
        $totalSaleReturnAmount = $totalSaleReturnAmount + $saleReturnAmount;

        // Sales Return Dr *******************************************************************************************************************************************************//
        $transactionId = transaction($transactionType, 0, $salesReturnAccountUID, $saleReturnAmount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

        if ($transactionId > 0) {

            $ok = debit($salesReturnAccountUID, $saleReturnAmount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo, true);

            if (!$ok) {
                $errorMessages .= "Unable to store Debit entry of Sales Return!\n";
                $rollBack = true;
                $error = true;
                break;
            }

        } else {
            $errorMessages .= "Unable to store transaction!\n";
            $rollBack = true;
            $error = true;
            break;
        }
        //***************************************************************************************************************************************************************//


        if ($totalSalesTax > 0) {

            $totalSaleMarginReturnAmount += (double)$totalSalesTax;

            // Sale Margin Dr *******************************************************************************************************************************************************//
            $transactionId = transaction($transactionType, $salesMarginAccountUID, 0, $totalSalesTax, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

            if ($transactionId > 0) {

                $ok = debit($salesMarginAccountUID, $totalSalesTax, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                if (!$ok) {
                    $errorMessages .= "Unable to store Debit entry of sales margin!\n";
                    $rollBack = true;
                    $error = true;
                    break;
                }

            } else {
                $errorMessages .= "Unable to store transaction!\n";
                $rollBack = true;
                $error = true;
                break;
            }
            //***************************************************************************************************************************************************************//
        }


        // WIC Cr *******************************************************************************************************************************************************//
        $transactionId = transaction($transactionType, 0, $partyCode, $grandTotal, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

        if ($transactionId > 0) {

            $ok = credit($partyCode, $grandTotal, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

            if (!$ok) {
                $errorMessages .= "Unable to store Credit entry of Walk in Customer!\n";
                $rollBack = true;
                $error = true;
                break;
            }

        } else {
            $errorMessages .= "Unable to store transaction!\n";
            $rollBack = true;
            $error = true;
            break;
        }
        //***************************************************************************************************************************************************************//


        if ($productDiscount > 0) {
            switch ($discountType) {
                case $none:

                    $totalProductDiscountAmount = $totalProductDiscountAmount - $productDiscount;

                    // Product Discount Cr *******************************************************************************************************************************************************//
                    $transactionId = transaction($transactionType, 0, $productDiscountAccountUID, $productDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

                    if ($transactionId > 0) {

                        $ok = credit($productDiscountAccountUID, $productDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                        if (!$ok) {
                            $errorMessages .= "Unable to store Credit entry of discount!\n";
                            $rollBack = true;
                            $error = true;
                            break;
                        }

                    } else {
                        $errorMessages .= "Unable to store transaction!\n";
                        $rollBack = true;
                        $error = true;
                        break;
                    }
                    //***************************************************************************************************************************************************************//
                    break;
                case $retailer:

                    $totalRetailerDiscountAmount = $totalRetailerDiscountAmount - $productDiscount;

                    // Retailer Discount Cr *******************************************************************************************************************************************************//
                    $transactionId = transaction($transactionType, 0, $retailerDiscountAccountUID, $productDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

                    if ($transactionId > 0) {

                        $ok = credit($retailerDiscountAccountUID, $productDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                        if (!$ok) {
                            $errorMessages .= "Unable to store Credit entry of retailer discount!\n";
                            $rollBack = true;
                            $error = true;
                            break;
                        }

                    } else {
                        $errorMessages .= "Unable to store transaction!\n";
                        $rollBack = true;
                        $error = true;
                        break;
                    }
                    //***************************************************************************************************************************************************************//
                    break;
                case $wholeSeller:

                    $totalWholeSellerDiscountAmount = $totalWholeSellerDiscountAmount - $productDiscount;

                    // WholeSeller Discount Cr *******************************************************************************************************************************************************//
                    $transactionId = transaction($transactionType, 0, $wholeSellerDiscountAccountUID, $productDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

                    if ($transactionId > 0) {

                        $ok = credit($wholeSellerDiscountAccountUID, $productDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                        if (!$ok) {
                            $errorMessages .= "Unable to store Credit entry of whole seller discount!\n";
                            $rollBack = true;
                            $error = true;
                            break;
                        }

                    } else {
                        $errorMessages .= "Unable to store transaction!\n";
                        $rollBack = true;
                        $error = true;
                        break;
                    }
                    //***************************************************************************************************************************************************************//
                    break;
                case $loyalty:

                    $totalLoyaltyDiscountAmount = $totalLoyaltyDiscountAmount - $productDiscount;

                    // loyalty Discount Cr *******************************************************************************************************************************************************//
                    $transactionId = transaction($transactionType, 0, $loyaltyCardDiscountAccountUID, $productDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

                    if ($transactionId > 0) {

                        $ok = credit($loyaltyCardDiscountAccountUID, $productDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                        if (!$ok) {
                            $errorMessages .= "Unable to store Credit entry of loyality discount!\n";
                            $rollBack = true;
                            $error = true;
                            break;
                        }

                    } else {
                        $errorMessages .= "Unable to store transaction!\n";
                        $rollBack = true;
                        $error = true;
                        break;
                    }
                    //***************************************************************************************************************************************************************//
                    break;
            }
        }


        if ($roundOffDiscount != 0) {

            $totalRoundOffDiscountAmount = $totalRoundOffDiscountAmount - $roundOffDiscount;

            // round off Discount Cr *******************************************************************************************************************************************************//
            $transactionId = transaction($transactionType, 0, $roundOffDiscountAccountUID, $roundOffDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

            if ($transactionId > 0) {

                $ok = credit($roundOffDiscountAccountUID, $roundOffDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                if (!$ok) {
                    $errorMessages .= "Unable to store Credit entry of round off discount!\n";
                    $rollBack = true;
                    $error = true;
                    break;
                }

            } else {
                $errorMessages .= "Unable to store transaction!\n";
                $rollBack = true;
                $error = true;
                break;
            }
            //***************************************************************************************************************************************************************//
        }


        if ($cashDiscount > 0) {

            $totalCashDiscountAmount = $totalCashDiscountAmount - $cashDiscount;

            // Cash Discount Cr *******************************************************************************************************************************************************//
            $transactionId = transaction($transactionType, 0, $cashDiscountAccountUID, $cashDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

            if ($transactionId > 0) {

                $ok = credit($cashDiscountAccountUID, $cashDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                if (!$ok) {
                    $errorMessages .= "Unable to store Credit entry of cash discount!\n";
                    $rollBack = true;
                    $error = true;
                    break;
                }

            } else {
                $errorMessages .= "Unable to store transaction!\n";
                $rollBack = true;
                $error = true;
                break;
            }
            //***************************************************************************************************************************************************************//
        }


        // Stock Cr *******************************************************************************************************************************************************//
        $transactionId = transaction($transactionType, $stockAccountUID, 0, $actualStockAmount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

        if ($transactionId > 0) {

            $ok = debit($stockAccountUID, $actualStockAmount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

            if (!$ok) {
                $errorMessages .= "Unable to store Debit entry of Stock!\n";
                $rollBack = true;
                $error = true;
                break;
            }

        } else {
            $errorMessages .= "Unable to store transaction!\n";
            $rollBack = true;
            $error = true;
            break;
        }
        //***************************************************************************************************************************************************************//


        // Cash Payment Voucher If any ************************************************//
        if ($cashReceived > 0) {

            $cashReceivedVoucherDetailRemarks = $userWalkInCustomerAccount->name . '@' . $cashReceived;
            $cashReceivedVoucherDetailRemarks2 = $userCashAccount->name . '@' . $cashReceived;

            $cashReceivedQuery = "INSERT INTO financials_cash_payment_voucher(cp_account_id, cp_total_amount, cp_remarks, cp_created_datetime, cp_day_end_id, cp_day_end_date, cp_createdby, cp_detail_remarks, cp_ip_adrs, cp_brwsr_info)
                                    VALUES ($userCashAccount->uid, $cashReceived, '$voucherCode', '$invoiceTimeStamp', $dayEndId, '$dayEndDate', $loginUserId, '$cashReceivedVoucherDetailRemarks', '$ipAddress', '$browserInfo');";

            $cashReceivedResult = $database->query($cashReceivedQuery);

            if ($cashReceivedResult && $database->affected_rows() == 1) {

                $cashPaymentVoucherInsertedId = $database->inserted_id();

                $cashReceivedItemsQuery = "INSERT INTO financials_cash_payment_voucher_items(cpi_voucher_id, cpi_account_id, cpi_account_name, cpi_amount, cpi_remarks)
                                            VALUES ($cashPaymentVoucherInsertedId, $userWalkInCustomerAccount->uid, '$userWalkInCustomerAccount->name', $cashReceived, '');";

                $cashReceivedItemsResult = $database->query($cashReceivedItemsQuery);

                if ($cashReceivedItemsResult && $database->affected_rows() == 1) {

                    $transactionType = CASH_PAYMENT;
                    $transactionNote = TRANS_NOTE_CASH_PAYMENT_VOUCHER;
                    $cashReceivedVoucherCode = CASH_PAYMENT_VOUCHER_CODE . $cashPaymentVoucherInsertedId;


                    // CPV *******************************************************************************************************************************************************//
                    $transactionId = transaction($transactionType, $userWalkInCustomerAccount->uid, $userCashAccount->uid, $cashReceived, $transactionNote, $invoiceTimeStamp, $cashPaymentVoucherInsertedId, $ipAddress, $browserInfo);

                    if ($transactionId > 0) {

                        $debitOk = debit($userWalkInCustomerAccount->uid, $cashReceived, $transactionNote, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $cashReceivedVoucherDetailRemarks2, $cashReceivedVoucherCode, $ipAddress, $browserInfo);
                        $creditOk = credit($userCashAccount->uid, $cashReceived, $transactionNote, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $cashReceivedVoucherDetailRemarks, $cashReceivedVoucherCode, $ipAddress, $browserInfo);

                        if (!$debitOk || !$creditOk) {
                            $errorMessages .= "Unable to store entries of Cash Payment Voucher!\n";
                            $rollBack = true;
                            $error = true;
                            break;
                        }

                    } else {
                        $errorMessages .= "Unable to store transaction!\n";
                        $rollBack = true;
                        $error = true;
                        break;
                    }
                    //***************************************************************************************************************************************************************//


                } else {
                    $errorMessages .= "Unable to store Cash Payment Voucher!\n";
                    $rollBack = true;
                    $error = true;
                    break;
                }

            } else {
                $errorMessages .= "Unable to store Cash Payment Voucher!\n";
                $rollBack = true;
                $error = true;
                break;
            }

        }
        // Cash Payment Voucher If any ************************************************//

    }

}
}


/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/
/************************************************************************************************************************************************************************************/

foreach ($saleTaxReturnInvoiceList as $invoice) {

    $saleTaxReturnInvoices++;
    $savedInvoices++;
    
    $localInvoiceId = $database->escape_value($invoice->id);
    $invoiceTimeStamp = $database->escape_value($invoice->si_datetime);
    
    $query = "SELECT srsi_id FROM financials_sale_return_saletax_invoice WHERE srsi_datetime = '$invoiceTimeStamp' AND srsi_local_invoice_id=$localInvoiceId AND srsi_createdby=$loginUserId;";
    $result = $database->query_rows($query);
    if(!$result){

    $partyCode = $database->escape_value($userWalkInCustomerAccount->uid);
    $partyName = $database->escape_value($userWalkInCustomerAccount->name);
    $customerName = $database->escape_value($invoice->customer_name);
    $remarks = $database->escape_value($invoice->remarks);
    $totalItems = $database->escape_value($invoice->total_items);
    $totalPrice = $database->escape_value($invoice->total_price);
    $productDiscount = $database->escape_value($invoice->product_disc);
    $roundOffDiscount = $database->escape_value($invoice->round_off_disc);
    $cashDiscountPer = $database->escape_value($invoice->cash_disc_per);
    $cashDiscount = $database->escape_value($invoice->cash_disc_amount);
    $totalDiscount = $database->escape_value($invoice->total_discount);
    $inclusiveSalesTax = $database->escape_value($invoice->inclusive_sales_tax);
    $exclusiveSalesTax = $database->escape_value($invoice->exclusive_sales_tax);
    $totalSalesTax = $database->escape_value($invoice->total_sales_tax);
    $grandTotal = $database->escape_value($invoice->grand_total);
    $cashReceived = $database->escape_value($invoice->cash_received);
    $salesPersonId = $database->escape_value($invoice->user);
    $creditCardMachineId = $database->escape_value($invoice->credit_card_machine);
    $clientPhoneNumber = $database->escape_value($invoice->si_phone_number);
    $creditCardRefNumber = $database->escape_value($invoice->si_credit_card_reference_number);
    $clientEmail = $database->escape_value($invoice->si_email);
    $whatsAppNumber = $database->escape_value($invoice->si_whatsapp);
    
    $localServiceInvoiceId = $database->escape_value($invoice->service_invoice_id);
    $localSaleInvoiceId = $database->escape_value($invoice->sale_invoice_id);
    $ipAddress = $database->escape_value($invoice->si_ip_adrs);
    $browserInfo = $database->escape_value($invoice->si_brwsr_info);
    
    $cashReceivedFromCustomer = $database->escape_value($invoice->cash_received_from_customer);
    $cashReturnToCustomer = $invoice->return_amount == "" ? 0 : $database->escape_value($invoice->return_amount);
    $discountType = $database->escape_value($invoice->discount_type);

    $detailRemarks = "";
    $transactionType = 0;

    $creditCardMachineName = "";
    $creditCardBankAccountUID = 0;
    $creditCardBankSCAccountUID = 0;
    $creditCardAccountUID = 0;
    $creditCardMachineCharges = 0.0;

    if ($creditCardMachineId > 0) {
        $machine = getCreditCardMachine($creditCardMachineId);

        if ($machine->found == true) {
            $creditCardMachineName = $machine->properties->ccm_title;
            $creditCardMachineCharges = $machine->properties->ccm_percentage;
            $creditCardBankAccountUID = $machine->properties->ccm_bank_code;
            $creditCardAccountUID = $machine->properties->ccm_credit_card_account_code;
            $creditCardBankSCAccountUID = $machine->properties->ccm_service_account_code;
        } else {
            dieWithError("Credit card machine not found of id: $creditCardMachineId", $database);
        }
    }

    $itemsList = $invoice->sale_items;

    foreach ($itemsList as $item) {
        $productParentCode = $database->escape_value($item->product->code);
        $productName = $database->escape_value($item->product->name);
        $itemQuantity = $database->escape_value($item->quantity);
        $itemUOM = $database->escape_value($item->uom);
        $itemRate = $database->escape_value($item->rate);
        $discountAmount = $database->escape_value($item->discount_amount);
        $saleTaxInclusive = $database->escape_value($item->sale_tax_inclusive);
        $saleTaxAmount = $database->escape_value($item->sale_tax_amount);
        $itemAmount = $database->escape_value($item->grand_amount);

        $inclusiveOrNot = $saleTaxInclusive == 1 ? '(Incl)' : '';
        $detailRemarks .= $productParentCode . '-' . $productName . ', ' . $itemQuantity . $itemUOM . '@' . $itemRate . ' - ' .
            $discountAmount . ' + ' . $saleTaxAmount . $inclusiveOrNot . ' = ' . $itemAmount . '\r\n';
    }
    $detailRemarks = substr($detailRemarks, 0, strlen($detailRemarks) - 4);

    $saleInsertQuery = "INSERT INTO financials_sale_return_saletax_invoice(
                                    srsi_party_code, srsi_party_name, srsi_customer_name, srsi_remarks, srsi_total_items, srsi_total_price,
                                    srsi_product_disc, srsi_round_off_disc, srsi_cash_disc_per, srsi_cash_disc_amount, srsi_total_discount,
                                    srsi_inclusive_sales_tax, srsi_exclusive_sales_tax, srsi_total_sales_tax, srsi_grand_total,
                                    srsi_cash_received, srsi_datetime, srsi_day_end_id, srsi_day_end_date, srsi_createdby, srsi_detail_remarks,
                                    srsi_sale_person, srsi_invoice_transcation_type, srsi_invoice_machine_id, srsi_invoice_machine_name, srsi_service_charges_percentage,
                                    srsi_phone_number, srsi_credit_card_reference_number, srsi_email, srsi_whatsapp,
                                    srsi_service_invoice_id, srsi_sale_invoice_number, srsi_local_invoice_id, srsi_local_service_invoice_id,
                                    srsi_ip_adrs, srsi_brwsr_info, srsi_cash_received_from_customer, srsi_return_amount,
                                    srsi_discount_type, srsi_invoice_profit)
                        VALUES (
                                $partyCode, '$partyName', '$customerName', '$remarks', $totalItems, $totalPrice,
                                $productDiscount, $roundOffDiscount, $cashDiscountPer, $cashDiscount, $totalDiscount,
                                $inclusiveSalesTax, $exclusiveSalesTax, $totalSalesTax, $grandTotal,
                                $cashReceived, '$invoiceTimeStamp', $dayEndId, '$dayEndDate', $loginUserId, '$detailRemarks',
                                $salesPersonId, $transactionType, $creditCardMachineId, '$creditCardMachineName', $creditCardMachineCharges,
                                '$clientPhoneNumber', '$creditCardRefNumber', '$clientEmail', '$whatsAppNumber',
                                0, $localSaleInvoiceId, $localInvoiceId, $localServiceInvoiceId,
                                '$ipAddress', '$browserInfo', $cashReceived, $cashReturnToCustomer,
                                $discountType, 0);";

    $saleInsertResult = $database->query($saleInsertQuery);

    if ($saleInsertResult && $database->affected_rows() == 1) {

        $lastInsertedId = $database->inserted_id();

        $voucherCode = SALE_TEX_SALE_RETURN_VOUCHER_CODE . $lastInsertedId;

        $actualStockAmount = 0;

        foreach ($itemsList as $item) {
            $productParentCode = $database->escape_value($item->product->code);
            $productName = $database->escape_value($item->product->name);
            $itemQuantity = $database->escape_value($item->quantity);
            $bonusQuantity = $database->escape_value($item->bonus_quantity);
            $itemUOM = $database->escape_value($item->uom);
            $itemWarehouseId = $database->escape_value($item->warehouse);
            $itemRate = $database->escape_value($item->rate);
            $discountPer = $database->escape_value($item->discount_per);
            $discountAmount = $database->escape_value($item->discount_amount);
            $afterDiscountRate = $database->escape_value($item->after_dis_rate);
            $netRate = $database->escape_value($item->net_rate);
            $saleTaxPer = $database->escape_value($item->sale_tax_per);
            $saleTaxInclusive = $database->escape_value($item->sale_tax_inclusive);
            $saleTaxAmount = $database->escape_value($item->sale_tax_amount);
            $itemAmount = $database->escape_value($item->grand_amount);
            $itemRemarks = $database->escape_value($item->remarks);

            $saleItemsQuery = "INSERT INTO financials_sale_return_saletax_invoice_items(
                                          srsii_invoice_id, srsii_product_code, srsii_product_name, srsii_remarks,
                                          srsii_qty, srsii_uom, srsii_bonus_qty, srsii_rate, srsii_discount_per, srsii_discount_amount, srsii_after_dis_rate, srsii_net_rate,
                                          srsii_saletax_per, srsii_saletax_inclusive, srsii_saletax_amount, srsii_amount, srsii_product_profit)
                                VALUES (
                                        $lastInsertedId, '$productParentCode', '$productName', '$itemRemarks',
                                        $itemQuantity, '$itemUOM', $bonusQuantity, $itemRate, $discountPer, $discountAmount, $afterDiscountRate, $netRate,
                                        $saleTaxPer, $saleTaxInclusive, $saleTaxAmount, $itemAmount, 0);";

            $saleItemsResult = $database->query($saleItemsQuery);

            if (!$saleItemsResult || $database->affected_rows() != 1) {
                $errorMessages .= "Unable to store sale return tax invoice!\n";
                $rollBack = true;
                $error = true;
                break;
            }

//            addProductQuantity($productParentCode, $itemQuantity);
            $whUpdated = addProductQuantityInWarehouse($productParentCode, $itemQuantity + $bonusQuantity, $itemWarehouseId);

            if ($whUpdated == 0) {
                $errorMessages .= "Unable to store product quantity in warehouse!\n";
                $rollBack = true;
                $error = true;
                break;
            }

            // stock movement entry
            $lastRecord = getStockMovementLastEntry($productParentCode);

            $lastQuantity = 0;
            $lastRate = 0;
            $lastAmount = 0;

            if ($lastRecord->found == true) {
                $lastEntry = $lastRecord->properties;
                $lastQuantity = $lastEntry->sm_bal_total_qty_wo_bonus;
                $lastRate = $lastEntry->sm_bal_rate;

                $actualStockAmount += ($itemQuantity * $lastRate);

                $smInserted = saleReturnEntryOfStockMovement($lastEntry, $itemQuantity, $bonusQuantity, $itemRate, $voucherCode, $dayEndId, $dayEndDate, $loginUserId, $invoiceTimeStamp);

                if ($smInserted == false) {
                    $errorMessages .= "Unable to store product quantity at stock movement!\n";
                    $rollBack = true;
                    $error = true;
                    break;
                }
            }

/*
            $smType = SM_TYPE_SALE_RETURN;

            $salAmount = $itemQuantity * $lastRate;
            $balQuantity = (int)$lastQuantity + (int)$itemQuantity;
            $balAmount = $lastAmount + $salAmount;
            $balRate =  $balQuantity == 0 ? 0 : $balAmount / $balQuantity;

            $insertStockMovementQuery = "INSERT INTO financials_stock_movement(
                                      sm_product_code, sm_product_name, sm_pur_qty, sm_pur_rate, sm_pur_total,
                                      sm_sale_qty, sm_sale_rate, sm_sale_total,
                                      sm_bal_qty, sm_bal_rate, sm_bal_total,
                                      sm_day_end_id, sm_day_end_date, sm_voucher_code, sm_remarks, sm_user_id, sm_date_time)
                                      VALUES (
                                              '$productParentCode', '$productName', $itemQuantity, $lastRate, $salAmount,
                                              0, 0, 0,
                                              $balQuantity, $balRate, $balAmount,
                                              $dayEndId, '$dayEndDate', '$voucherCode', '', $loginUserId, '$invoiceTimeStamp'
                                      );";

            $insertStockMovementResult = $database->query($insertStockMovementQuery);

            if (!$insertStockMovementResult || $database->affected_rows() != 1) {
                $rollBack = true;
                $error = true;
                break;
            }


            if ($bonusQuantity != "" && $bonusQuantity > 0) {
                addProductQuantity($productParentCode, $bonusQuantity);
                addProductQuantityInWarehouse($productParentCode, $bonusQuantity, $itemWarehouseId);

                // bonus stock movement entry
                $lastRecord = getStockMovementLastEntry($productParentCode);

                $lastQuantity = 0;
                $lastRate = 0;
                $lastAmount = 0;

                if ($lastRecord->found == true) {
                    $lastQuantity = $lastRecord->quantity;
                    $lastRate = $lastRecord->rate;
                    $lastAmount = $lastRecord->amount;
                }

                $smType = SM_TYPE_SALE_BONUS;

                $salAmount = $itemQuantity * $itemRate;
                $balQuantity = (int)$lastQuantity + (int)$bonusQuantity;
                $balAmount = $lastAmount + $salAmount;
                $balRate =  $balQuantity == 0 ? 0 : $balAmount / $balQuantity;

                $insertStockMovementQuery = "INSERT INTO financials_stock_movement(
                                      sm_product_code, sm_product_name, sm_pur_qty, sm_pur_rate, sm_pur_total,
                                      sm_sale_qty, sm_sale_rate, sm_sale_total,
                                      sm_bal_qty, sm_bal_rate, sm_bal_total,
                                      sm_day_end_id, sm_day_end_date, sm_voucher_code, sm_remarks, sm_user_id, sm_date_time)
                                      VALUES (
                                              '$productParentCode', '$productName', $bonusQuantity, 0, 0,
                                              0, 0, 0,
                                              $balQuantity, $balRate, $balAmount,
                                              $dayEndId, '$dayEndDate', '$voucherCode', '', $loginUserId, '$invoiceTimeStamp'
                                      );";

                $insertStockMovementResult = $database->query($insertStockMovementQuery);

                if (!$insertStockMovementResult || $database->affected_rows() != 1) {
                    $rollBack = true;
                    $error = true;
                    break;
                }

            }
*/
        }

        $transactionType = SALE_RETURN;
        $note = TRANS_NOTE_SALE_RETURN_INVOICE;

        // entry
        // Account              DR          CR

        // Sales                0
        // Province Tax         0
        //       WIC                        0
        //       Product Dis                0
        //       Round Off Dis              0
        //       Cash Dis                   0

        // Stock                0


        $saleReturnAmount = (double)$grandTotal + (double)$totalDiscount - (double)$totalSalesTax;
        $totalSaleReturnAmount = $totalSaleReturnAmount + $saleReturnAmount;


        // Sales Return Dr *******************************************************************************************************************************************************//
        $transactionId = transaction($transactionType, 0, $salesReturnAccountUID, $saleReturnAmount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

        if ($transactionId > 0) {

            $ok = debit($salesReturnAccountUID, $saleReturnAmount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo, true);

            if (!$ok) {
                $errorMessages .= "Unable to store Debit entry of sales return!\n";
                $rollBack = true;
                $error = true;
                break;
            }

        } else {
            $errorMessages .= "Unable to store transaction!\n";
            $rollBack = true;
            $error = true;
            break;
        }
        //***************************************************************************************************************************************************************//


        if ($totalSalesTax > 0) {

            $totalSaleTaxReturnAmount += (double)$totalSalesTax;

            // Sale Margin Dr *******************************************************************************************************************************************************//
            $transactionId = transaction($transactionType, $serviceTaxAccountUID, 0, $totalSalesTax, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

            if ($transactionId > 0) {

                $ok = debit($serviceTaxAccountUID, $totalSalesTax, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                if (!$ok) {
                    $errorMessages .= "Unable to store Debit entry of sales margin!\n";
                    $rollBack = true;
                    $error = true;
                    break;
                }

            } else {
                $errorMessages .= "Unable to store transaction!\n";
                $rollBack = true;
                $error = true;
                break;
            }
            //***************************************************************************************************************************************************************//
        }


        // WIC Cr *******************************************************************************************************************************************************//
        $transactionId = transaction($transactionType, 0, $partyCode, $grandTotal, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

        if ($transactionId > 0) {

            $ok = credit($partyCode, $grandTotal, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

            if (!$ok) {
                $errorMessages .= "Unable to store Credit entry of Walk in Customer!\n";
                $rollBack = true;
                $error = true;
                break;
            }

        } else {
            $errorMessages .= "Unable to store transaction!\n";
            $rollBack = true;
            $error = true;
            break;
        }
        //***************************************************************************************************************************************************************//


        if ($productDiscount > 0) {
            switch ($discountType) {
                case $none:

                    $totalProductDiscountAmount = $totalProductDiscountAmount - $productDiscount;

                    // Product Discount Cr *******************************************************************************************************************************************************//
                    $transactionId = transaction($transactionType, 0, $productDiscountAccountUID, $productDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

                    if ($transactionId > 0) {

                        $ok = credit($productDiscountAccountUID, $productDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                        if (!$ok) {
                            $errorMessages .= "Unable to store Credit entry of discount!\n";
                            $rollBack = true;
                            $error = true;
                            break;
                        }

                    } else {
                        $errorMessages .= "Unable to store transaction!\n";
                        $rollBack = true;
                        $error = true;
                        break;
                    }
                    //***************************************************************************************************************************************************************//
                    break;
                case $retailer:

                    $totalRetailerDiscountAmount = $totalRetailerDiscountAmount - $productDiscount;

                    // Retailer Discount Cr *******************************************************************************************************************************************************//
                    $transactionId = transaction($transactionType, 0, $retailerDiscountAccountUID, $productDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

                    if ($transactionId > 0) {

                        $ok = credit($retailerDiscountAccountUID, $productDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                        if (!$ok) {
                            $errorMessages .= "Unable to store Credit entry of retailer discount!\n";
                            $rollBack = true;
                            $error = true;
                            break;
                        }

                    } else {
                        $errorMessages .= "Unable to store transaction!\n";
                        $rollBack = true;
                        $error = true;
                        break;
                    }
                    //***************************************************************************************************************************************************************//
                    break;
                case $wholeSeller:

                    $totalWholeSellerDiscountAmount = $totalWholeSellerDiscountAmount - $productDiscount;

                    // WholeSeller Discount Cr *******************************************************************************************************************************************************//
                    $transactionId = transaction($transactionType, 0, $wholeSellerDiscountAccountUID, $productDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

                    if ($transactionId > 0) {

                        $ok = credit($wholeSellerDiscountAccountUID, $productDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                        if (!$ok) {
                            $errorMessages .= "Unable to store Credit entry of whole seller discount!\n";
                            $rollBack = true;
                            $error = true;
                            break;
                        }

                    } else {
                        $errorMessages .= "Unable to store transaction!\n";
                        $rollBack = true;
                        $error = true;
                        break;
                    }
                    //***************************************************************************************************************************************************************//
                    break;
                case $loyalty:

                    $totalLoyaltyDiscountAmount = $totalLoyaltyDiscountAmount - $productDiscount;

                    // loyalty Discount Cr *******************************************************************************************************************************************************//
                    $transactionId = transaction($transactionType, 0, $loyaltyCardDiscountAccountUID, $productDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

                    if ($transactionId > 0) {

                        $ok = credit($loyaltyCardDiscountAccountUID, $productDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                        if (!$ok) {
                            $errorMessages .= "Unable to store Credit entry of loyality discount!\n";
                            $rollBack = true;
                            $error = true;
                            break;
                        }

                    } else {
                        $errorMessages .= "Unable to store transaction!\n";
                        $rollBack = true;
                        $error = true;
                        break;
                    }
                    //***************************************************************************************************************************************************************//
                    break;
            }
        }


        if ($roundOffDiscount != 0) {

            $totalRoundOffDiscountAmount = $totalRoundOffDiscountAmount - $roundOffDiscount;

            // round off Discount Cr *******************************************************************************************************************************************************//
            $transactionId = transaction($transactionType, 0, $roundOffDiscountAccountUID, $roundOffDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

            if ($transactionId > 0) {

                $ok = credit($roundOffDiscountAccountUID, $roundOffDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                if (!$ok) {
                    $errorMessages .= "Unable to store Credit entry of round off discount!\n";
                    $rollBack = true;
                    $error = true;
                    break;
                }

            } else {
                $errorMessages .= "Unable to store transaction!\n";
                $rollBack = true;
                $error = true;
                break;
            }
            //***************************************************************************************************************************************************************//
        }


        if ($cashDiscount > 0) {

            $totalCashDiscountAmount = $totalCashDiscountAmount - $cashDiscount;

            // Cash Discount Cr *******************************************************************************************************************************************************//
            $transactionId = transaction($transactionType, 0, $cashDiscountAccountUID, $cashDiscount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

            if ($transactionId > 0) {

                $ok = credit($cashDiscountAccountUID, $cashDiscount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

                if (!$ok) {
                    $errorMessages .= "Unable to store Credit entry of cash discount!\n";
                    $rollBack = true;
                    $error = true;
                    break;
                }

            } else {
                $errorMessages .= "Unable to store transaction!\n";
                $rollBack = true;
                $error = true;
                break;
            }
            //***************************************************************************************************************************************************************//
        }


        // Stock Cr *******************************************************************************************************************************************************//
        $transactionId = transaction($transactionType, $stockAccountUID, 0, $actualStockAmount, $note, $invoiceTimeStamp, $lastInsertedId, $ipAddress, $browserInfo);

        if ($transactionId > 0) {

            $ok = debit($stockAccountUID, $actualStockAmount, $note, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $detailRemarks, $voucherCode, $ipAddress, $browserInfo);

            if (!$ok) {
                $errorMessages .= "Unable to store Debit entry of stock!\n";
                $rollBack = true;
                $error = true;
                break;
            }

        } else {
            $errorMessages .= "Unable to store transaction!\n";
            $rollBack = true;
            $error = true;
            break;
        }
        //***************************************************************************************************************************************************************//


        // Cash Payment Voucher If any ************************************************//
        if ($cashReceived > 0) {

            $cashReceivedVoucherDetailRemarks = $userWalkInCustomerAccount->name . '@' . $cashReceived;
            $cashReceivedVoucherDetailRemarks2 = $userCashAccount->name . '@' . $cashReceived;

            $cashReceivedQuery = "INSERT INTO financials_cash_payment_voucher(cp_account_id, cp_total_amount, cp_remarks, cp_created_datetime, cp_day_end_id, cp_day_end_date, cp_createdby, cp_detail_remarks, cp_ip_adrs, cp_brwsr_info)
                                    VALUES ($userCashAccount->uid, $cashReceived, '$voucherCode', '$invoiceTimeStamp', $dayEndId, '$dayEndDate', $loginUserId, '$cashReceivedVoucherDetailRemarks', '$ipAddress', '$browserInfo');";

            $cashReceivedResult = $database->query($cashReceivedQuery);

            if ($cashReceivedResult && $database->affected_rows() == 1) {

                $cashPaymentVoucherInsertedId = $database->inserted_id();

                $cashReceivedItemsQuery = "INSERT INTO financials_cash_payment_voucher_items(cpi_voucher_id, cpi_account_id, cpi_account_name, cpi_amount, cpi_remarks)
                                            VALUES ($cashPaymentVoucherInsertedId, $userWalkInCustomerAccount->uid, '$userWalkInCustomerAccount->name', $cashReceived, '');";

                $cashReceivedItemsResult = $database->query($cashReceivedItemsQuery);

                if ($cashReceivedItemsResult && $database->affected_rows() == 1) {

                    $transactionType = CASH_PAYMENT;
                    $transactionNote = TRANS_NOTE_CASH_PAYMENT_VOUCHER;
                    $cashReceivedVoucherCode = CASH_PAYMENT_VOUCHER_CODE . $cashPaymentVoucherInsertedId;


                    // CPV *******************************************************************************************************************************************************//
                    $transactionId = transaction($transactionType, $userWalkInCustomerAccount->uid, $userCashAccount->uid, $cashReceived, $transactionNote, $invoiceTimeStamp, $cashPaymentVoucherInsertedId, $ipAddress, $browserInfo);

                    if ($transactionId > 0) {

                        $debitOk = debit($userWalkInCustomerAccount->uid, $cashReceived, $transactionNote, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $cashReceivedVoucherDetailRemarks2, $cashReceivedVoucherCode, $ipAddress, $browserInfo);
                        $creditOk = credit($userCashAccount->uid, $cashReceived, $transactionNote, $transactionId, $invoiceTimeStamp, $loginUserId, $dayEndId, $dayEndDate, $voucherCode, $cashReceivedVoucherDetailRemarks, $cashReceivedVoucherCode, $ipAddress, $browserInfo);

                        if (!$debitOk || !$creditOk) {
                            $errorMessages .= "Unable to store entries Cash Payment Voucher!\n";
                            $rollBack = true;
                            $error = true;
                            break;
                        }

                    } else {
                        $errorMessages .= "Unable to store transaction!\n";
                        $rollBack = true;
                        $error = true;
                        break;
                    }
                    //***************************************************************************************************************************************************************//


                } else {
                    $errorMessages .= "Unable to store Cash Payment Voucher!\n";
                    $rollBack = true;
                    $error = true;
                    break;
                }

            } else {
                $errorMessages .= "Unable to store Cash Payment Voucher!\n";
                $rollBack = true;
                $error = true;
                break;
            }

        }
        // Cash Payment Voucher If any ************************************************//

    }

}
}


$rpMessage = "";

if ($rollBack || $error) {
    $database->rollBack();

    $rpMessage = "Sync not complete due to some internal errors!" . " \nErrors: " . $errorMessages;

    $response->code = NOT_OK;

} else {
    $database->commit();

    $rpMessage .= "Invoices:\n";
    $rpMessage .= "Sale: $saleInvoices\n";
    $rpMessage .= "SaleTax: $saleTaxInvoices\n";
    $rpMessage .= "SaleReturn: $saleReturnInvoices\n";
    $rpMessage .= "SaleTaxReturn: $saleTaxReturnInvoices\n";
    $rpMessage .= "Service: $serviceInvoices\n";
    $rpMessage .= "ServiceTax: $serviceTaxInvoices\n";
    $rpMessage .= "Total: $totalInvoices\n";
    $rpMessage .= "Saved: $savedInvoices\n";

    $response->code = OK;

    try {

        $fullFileName = "";
        if ($dataType == $POST_DATA) {
            $syncFileTimeStampFormat = 'd_m_Y_h_i_s_a';
            date_default_timezone_set(ASIA_TIME_ZONE);
            $syncTimeStamp = date($syncFileTimeStampFormat);

            $fullFileName = 'C_' . $totalInvoices . '_' . 'D_' . $dayEndId . '_' . $syncTimeStamp . '.txt';
        } else {
            $fullFileName = 'C_' . $totalInvoices . '_' . 'D_' . $dayEndId . '_' . $fileName;
            rename($pendingFolderName . $fileName, "sync_files/$fullFileName");
        }

        $nDt = new DateTime($dayEndDate);
        $nDt = $nDt->format('d-m-Y');

    } catch (Exception $e) {}

    date_default_timezone_set(ASIA_TIME_ZONE);
    $userTimeStamp = date(USER_DATE_TIME_FORMAT);

    $syncReportHTML = "";
    $syncReportHTML .= "";
    $syncReportHTML .= "<!DOCTYPE html>
                        <html lang='en'>
                        <head>
                        <style>

                        tr:nth-child(even) {
                          background-color: #dddddd;
                        }
                        </style>
                        <title>Sync Report of ($nDt)</title>
                        </head>
                        <body style='height: auto; margin: 0 auto; padding-left: 0.2in; padding-right: 0.2in; padding-top: 0.1in; width: 3.9in; background: #FFF;
                        border-radius: 1px; box-shadow: 0 10px 0 0 white, 0 -10px 0 0 white, 12px 0 15px -4px rgba(0, 0, 0, 0.5), -12px 0 15px -4px rgba(0, 0, 0, 0.5);'>";

    $syncReportHTML .= "<h2 style='background-color: green; text-align: center; color: white; padding: 16px'>Sync Report of <br />($nDt)</h2>";

    $syncReportHTML .= "
                    <table style='font-family: arial, sans-serif; border-collapse: collapse; width: 100%;'>
                      <tr>
                        <th style=\"width:100px;text-align:center;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Uploaded</th>
                        <th style='width:100px;text-align:center;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;'>Saved</th>
                        <th style=\"width:150px;text-align:center;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Difference</th>
                      </tr>
                      <tr>
                        <td style=\"width:100px;text-align:center;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">" . $totalInvoices . "</td>
                        <td style='width:100px;text-align:center;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;'>" . $savedInvoices . "</td>
                        <td style=\"width:150px;text-align:center;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">" . abs($totalInvoices - $savedInvoices) . "</td>
                      </tr>
                    </table><br /><br />";

    $syncReportHTML .= "
                    <table style='font-family: arial, sans-serif; border-collapse: collapse; width: 100%;'>
                      <tr>
                        <th style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Invoices</th>
                        <th style='width:100px;text-align:center;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;'>Count</th>
                      </tr>
                      <tr>
                        <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Sale Invoices</td>
                        <td style='width:100px;text-align:center;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;'>" . $saleInvoices . "</td>
                      </tr>
                      <tr>
                        <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Sale Tax Invoices</td>
                        <td style='width:100px;text-align:center;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;'>" . $saleTaxInvoices . "</td>
                      </tr>
                      <tr>
                        <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Sale Return Invoices</td>
                        <td style='width:100px;text-align:center;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;'>" . $saleReturnInvoices . "</td>
                      </tr>
                      <tr>
                        <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Sale Tax Return Invoices</td>
                        <td style='width:100px;text-align:center;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;'>" . $saleTaxReturnInvoices . "</td>
                      </tr>
                      <tr>
                        <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Service Invoices</td>
                        <td style='width:100px;text-align:center;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;'>" . $serviceInvoices . "</td>
                      </tr>
                      <tr>
                        <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Service Tax Invoices</td>
                        <td style='width:100px;text-align:center;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;'>" . $serviceTaxInvoices . "</td>
                      </tr>
                      <tr>
                        <th style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Total Invoices</th>
                        <th style='width:100px;text-align:center;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;'>" . $totalInvoices . "</th>
                      </tr>
                    </table><br /><br />";

    $syncReportHTML .= "<table style='font-family: arial, sans-serif; border-collapse: collapse; width: 100%;'>";

    $syncReportHTML .= "<tr>
                            <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Sale</td>
                            <td style='border: 1px solid #bbbbbb;text-align: right;padding: 8px;white-space:nowrap;'>" . number_format($totalSaleAmount, 2) . "</td>
                            <td style=\"width:100px;text-align:right;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                        </tr>";

    $syncReportHTML .= "<tr>
                            <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Sale Return</td>
                            <td style='border: 1px solid #bbbbbb;text-align: right;padding: 8px;white-space:nowrap;'>(" . number_format($totalSaleReturnAmount, 2) . ")</td>
                            <td style=\"width:100px;text-align:right;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                        </tr>";

    $netSale = $totalSaleAmount - $totalSaleReturnAmount;

    $syncReportHTML .= "<tr>
                            <th style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Net Sale</th>
                            <td style=\"width:100px;text-align:right;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                            <th style='border: 1px solid #bbbbbb;text-align: right;padding: 8px;white-space:nowrap;'>" . number_format($netSale, 2) . "</th>
                        </tr>";

    $syncReportHTML .= "<tr>
                            <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                            <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                            <td style='border: 1px solid #bbbbbb;text-align: left;padding: 8px;white-space:nowrap;'>&nbsp;</td>
                        </tr>";

    $syncReportHTML .= "<tr>
                            <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Sale Tax</td>
                            <td style='border: 1px solid #bbbbbb;text-align: right;padding: 8px;white-space:nowrap;'>" . number_format($totalSaleTaxAmount, 2) . "</td>
                            <td style=\"width:100px;text-align:right;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                        </tr>";

    $syncReportHTML .= "<tr>
                            <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Tax Return</td>
                            <td style='border: 1px solid #bbbbbb;text-align: right;padding: 8px;white-space:nowrap;'>(" . number_format($totalSaleTaxReturnAmount, 2) . ")</td>
                            <td style=\"width:100px;text-align:right;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                        </tr>";

    $syncReportHTML .= "<tr>
                            <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Sale Margin</td>
                            <td style='border: 1px solid #bbbbbb;text-align: right;padding: 8px;white-space:nowrap;'>" . number_format($totalSaleMarginAmount, 2) . "</td>
                            <td style=\"width:100px;text-align:right;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                        </tr>";

    $syncReportHTML .= "<tr>
                            <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Margin Return</td>
                            <td style='border: 1px solid #bbbbbb;text-align: right;padding: 8px;white-space:nowrap;'>(" . number_format($totalSaleMarginReturnAmount, 2) . ")</td>
                            <td style=\"width:100px;text-align:right;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                        </tr>";

    $totalSaleTaxPlusMargin = ($totalSaleTaxAmount - $totalSaleTaxReturnAmount) + ($totalSaleMarginAmount - $totalSaleMarginReturnAmount);

    $syncReportHTML .= "<tr>
                            <th style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Tax + Margin</th>
                            <td style=\"width:100px;text-align:right;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                            <th style='border: 1px solid #bbbbbb;text-align: right;padding: 8px;white-space:nowrap;'>" . number_format($totalSaleTaxPlusMargin, 2) . "</th>
                        </tr>";

    $syncReportHTML .= "<tr>
                            <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                            <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                            <td style='border: 1px solid #bbbbbb;text-align: left;padding: 8px;white-space:nowrap;'>&nbsp;</td>
                        </tr>";

    $syncReportHTML .= "<tr>
                            <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Services</td>
                            <td style='border: 1px solid #bbbbbb;text-align: right;padding: 8px;white-space:nowrap;'>" . number_format($totalServiceAmount, 2) . "</td>
                            <td style=\"width:100px;text-align:right;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                        </tr>";

    $syncReportHTML .= "<tr>
                            <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Services Tax</td>
                            <td style='border: 1px solid #bbbbbb;text-align: right;padding: 8px;white-space:nowrap;'>" . number_format($totalServiceTaxAmount, 2) . "</td>
                            <td style=\"width:100px;text-align:right;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                        </tr>";

    $syncReportHTML .= "<tr>
                            <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Services Margin</td>
                            <td style='border: 1px solid #bbbbbb;text-align: right;padding: 8px;white-space:nowrap;'>" . number_format($totalServiceMarginAmount, 2) . "</td>
                            <td style=\"width:100px;text-align:right;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                        </tr>";

    $totalServicesPlusTaxMargin = $totalServiceAmount + $totalServiceTaxAmount + $totalServiceMarginAmount;

    $syncReportHTML .= "<tr>
                            <th style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Total Services</th>
                            <td style=\"width:100px;text-align:right;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                            <th style='border: 1px solid #bbbbbb;text-align: right;padding: 8px;white-space:nowrap;'>" . number_format($totalServicesPlusTaxMargin, 2) . "</th>
                        </tr>";

    $syncReportHTML .= "<tr>
                            <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                            <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                            <td style='border: 1px solid #bbbbbb;text-align: left;padding: 8px;white-space:nowrap;'>&nbsp;</td>
                        </tr>";

    $syncReportHTML .= "<tr>
                            <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Product Dis</td>
                            <td style='border: 1px solid #bbbbbb;text-align: right;padding: 8px;white-space:nowrap;'>" . number_format($totalProductDiscountAmount, 2) . "</td>
                            <td style=\"width:100px;text-align:right;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                        </tr>";

    $syncReportHTML .= "<tr>
                            <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Services Dis</td>
                            <td style='border: 1px solid #bbbbbb;text-align: right;padding: 8px;white-space:nowrap;'>" . number_format($totalServiceDiscountAmount, 2) . "</td>
                            <td style=\"width:100px;text-align:right;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                        </tr>";

    $syncReportHTML .= "<tr>
                            <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Retailer Dis</td>
                            <td style='border: 1px solid #bbbbbb;text-align: right;padding: 8px;white-space:nowrap;'>" . number_format($totalRetailerDiscountAmount, 2) . "</td>
                            <td style=\"width:100px;text-align:right;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                        </tr>";

    $syncReportHTML .= "<tr>
                            <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Whole Seller Dis</td>
                            <td style='border: 1px solid #bbbbbb;text-align: right;padding: 8px;white-space:nowrap;'>" . number_format($totalWholeSellerDiscountAmount, 2) . "</td>
                            <td style=\"width:100px;text-align:right;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                        </tr>";

    $syncReportHTML .= "<tr>
                            <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Loyalty Card Dis</td>
                            <td style='border: 1px solid #bbbbbb;text-align: right;padding: 8px;white-space:nowrap;'>" . number_format($totalLoyaltyDiscountAmount, 2) . "</td>
                            <td style=\"width:100px;text-align:right;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                        </tr>";

    $syncReportHTML .= "<tr>
                            <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Round Off Dis</td>
                            <td style='border: 1px solid #bbbbbb;text-align: right;padding: 8px;white-space:nowrap;'>" . number_format($totalRoundOffDiscountAmount, 2) . "</td>
                            <td style=\"width:100px;text-align:right;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                        </tr>";

    $syncReportHTML .= "<tr>
                            <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Cash Dis</td>
                            <td style='border: 1px solid #bbbbbb;text-align: right;padding: 8px;white-space:nowrap;'>" . number_format($totalCashDiscountAmount, 2) . "</td>
                            <td style=\"width:100px;text-align:right;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                        </tr>";

    $totalDiscountAmount = $totalProductDiscountAmount + $totalServiceDiscountAmount + $totalRetailerDiscountAmount + $totalWholeSellerDiscountAmount + $totalLoyaltyDiscountAmount + $totalRoundOffDiscountAmount + $totalCashDiscountAmount;

    $syncReportHTML .= "<tr>
                            <th style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Total Discount</th>
                            <td style=\"width:100px;text-align:right;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                            <th style='border: 1px solid #bbbbbb;text-align: right;padding: 8px;white-space:nowrap;'>(" . number_format($totalDiscountAmount, 2) . ")</th>
                        </tr>";

    $syncReportHTML .= "<tr>
                            <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                            <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                            <td style='border: 1px solid #bbbbbb;text-align: left;padding: 8px;white-space:nowrap;'>&nbsp;</td>
                        </tr>";

    $totalReceived = $netSale + $totalSaleTaxPlusMargin + $totalServicesPlusTaxMargin - $totalDiscountAmount;

    $syncReportHTML .= "<tr>
                            <th style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Total Received</th>
                            <td style=\"width:100px;text-align:right;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                            <th style='border: 1px solid #bbbbbb;text-align: right;padding: 8px;white-space:nowrap;'>" . number_format($totalReceived, 2) . "</td>
                        </tr>";

    $syncReportHTML .= "<tr>
                            <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                            <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                            <td style='border: 1px solid #bbbbbb;text-align: left;padding: 8px;white-space:nowrap;'>&nbsp;</td>
                        </tr>";

    $syncReportHTML .= "<tr>
                            <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Credit Card Sale</td>
                            <td style='border: 1px solid #bbbbbb;text-align: right;padding: 8px;white-space:nowrap;'>" . number_format($totalCreditCardSaleAmount, 2) . "</td>
                            <td style=\"width:100px;text-align:right;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                        </tr>";

    $syncReportHTML .= "<tr>
                            <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Service Charges</td>
                            <td style='border: 1px solid #bbbbbb;text-align: right;padding: 8px;white-space:nowrap;'>" . number_format($totalCreditCardChargesAmount, 2) . "</td>
                            <td style=\"width:100px;text-align:right;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                        </tr>";

    $totalCreditCardReceived = (double)$totalCreditCardSaleAmount + (double)$totalCreditCardChargesAmount;

    $syncReportHTML .= "<tr>
                            <th style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">CC Received</th>
                            <td style=\"width:100px;text-align:right;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                            <th style='border: 1px solid #bbbbbb;text-align: right;padding: 8px;white-space:nowrap;'>" . number_format($totalCreditCardReceived, 2) . "</td>
                        </tr>";

    $syncReportHTML .= "<tr>
                            <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                            <td style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                            <td style='border: 1px solid #bbbbbb;text-align: left;padding: 8px;white-space:nowrap;'>&nbsp;</td>
                        </tr>";

    $syncReportHTML .= "<tr>
                            <th style=\"width:100px;text-align:left;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\">Cash Received</th>
                            <td style=\"width:100px;text-align:right;border: 1px solid #bbbbbb;padding: 8px;white-space:nowrap;\"></td>
                            <th style='border: 1px solid #bbbbbb;text-align: right;padding: 8px;white-space:nowrap;'>" . number_format($totalReceived - $totalCreditCardReceived, 2) . "</td>
                        </tr>";

    $syncReportHTML .= "</table><br /><br />";

    $syncReportHTML .= "<h5 style='text-align: center; padding: 0; margin: 0;'>Sync at: $userTimeStamp</h5>";
    $syncReportHTML .= "<h6 style='text-align: center; padding: 0; margin: 0;'>By: $loginUserName ($loginUserEmail)</h6><br /><br />";
    $syncReportHTML .= "</body></html>";


    try {

        $syncReportsFolder = SYNC_REPORT_FOLDER;
        $syncReportsFolderPath = SYNC_REPORT_FOLDER_PATH;
        $syncReportFile = explode('.', $fullFileName)[0] . ".html";

        $fp = fopen($syncReportsFolder . '/' . $syncReportFile,"wb");
        fwrite($fp, $syncReportHTML);
        fclose($fp);

        $reportURL = $subDomain . $syncReportsFolderPath . $syncReportFile;

        $syncQuery = "INSERT INTO desktop_sync_reports(dsr_user_id, dsr_day_end_id, dsr_day_end_date, dsr_report_url)
                                    VALUES ($loginUserId, $dayEndId, '$dayEndDate', '$reportURL');";
        $syncResult = $database->query($syncQuery);

    } catch (Exception $e) {}

    mailOnly($loginUserEmail, 'Sync Report of ' . $nDt, $syncReportHTML);

}


$response->success = OK;
$response->message = $rpMessage;

echo json_encode($response);


if (isset($database)) {
    $database->close_connection();
}
