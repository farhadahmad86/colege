<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 14-Apr-20
 * Time: 7:03 PM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../_db/database.php");
require_once("../functions/functions.php");
require_once("../functions/api_functions.php");

$number = isset($_REQUEST['in']) ? $database->escape_value($_REQUEST['in']) : "";
$invoiceFormat = isset($_REQUEST['format']) ? $database->escape_value($_REQUEST['format']) : 2;

$invoiceType = isset($_REQUEST['type']) ? $database->escape_value($_REQUEST['type']) : 0;
$invoiceNumber = isset($_REQUEST['number']) ? $database->escape_value($_REQUEST['number']) : 0;

$A4 = 1;
$_80mm = 2;

$SALE = 1;
$SALE_TAX = 2;
$SALE_RETURN = 3;
$SALE_TAX_RETURN = 4;

$SERVICE = 5;
$SERVICE_TAX = 6;

$specialInstructions = "Some instructions for customer!";

if ($number != "") {
    $ar = explode('-', $number);
    if (count($ar) == 2) {
        $invoiceType = $ar[0] . '-';
        switch ($invoiceType) {
            case SALE_VOUCHER_CODE:
                $invoiceType = $SALE;
                break;
            case SALE_TEX_SALE_VOUCHER_CODE:
                $invoiceType = $SALE_TAX;
                break;
            case SALE_RETURN_VOUCHER_CODE:
                $invoiceType = $SALE_RETURN;
                break;
            case SALE_TEX_SALE_RETURN_VOUCHER_CODE:
                $invoiceType = $SALE_TAX_RETURN;
                break;
            case SERVICE_VOUCHER_CODE:
                $invoiceType = $SERVICE;
                break;
            case SERVICE_TAX_VOUCHER_CODE:
                $invoiceType = $SERVICE_TAX;
                break;
        }
        $invoiceNumber = $ar[1];
    }
}

if ($invoiceType == 0) {
    dieWithError("Invoice type not found!", $database);
}

if ($invoiceNumber == 0) {
    dieWithError("Invoice number not found!", $database);
}

$primaryInvoiceId = 0;
$secondaryInvoiceId = 0;

$primaryVoucherNumber = '';
$secondaryVoucherNumber = '';

$primaryInvoiceData = array();
$primaryItemsData = array();

$secondaryInvoiceData = array();
$secondaryItemsData = array();

$invoiceTitle = "";

$detailHTML = "";
$detailHTML_80mm = "";

switch ($invoiceType) {
    case $SALE:
        // todo sale invoice
        $invoiceTitle = "SALE INVOICE";
        $invoiceQuery = "SELECT * FROM financials_sale_invoice WHERE si_id = $invoiceNumber LIMIT 1;";
        $invoiceResult = $database->query($invoiceQuery);
        if ($invoiceResult && $database->num_rows($invoiceResult) == 1) {
            $primaryInvoiceData = $database->fetch_assoc($invoiceResult);
            $primaryInvoiceId = $primaryInvoiceData['si_id'];
            $secondaryId = $primaryInvoiceData['si_service_invoice_id'];
            $primaryVoucherNumber = SALE_VOUCHER_CODE . $primaryInvoiceId;
            $itemsQuery = "SELECT * FROM financials_sale_invoice_items WHERE sii_invoice_id = $primaryInvoiceId;";
            $itemsResult = $database->query($itemsQuery);
            if ($itemsResult && $database->num_rows($itemsResult) > 0) {
                while ($item = $database->fetch_assoc($itemsResult)) {
                    $primaryItemsData[] = $item;
                }
            }

            if ($secondaryId != 0) {
                $invoiceQuery = "SELECT * FROM financials_service_invoice WHERE sei_id = $secondaryId LIMIT 1;";
                $invoiceResult = $database->query($invoiceQuery);
                if ($invoiceResult && $database->num_rows($invoiceResult) == 1) {
                    $secondaryInvoiceData = $database->fetch_assoc($invoiceResult);
                    $secondaryInvoiceId = $secondaryInvoiceData['sei_id'];
                    $secondaryVoucherNumber = SERVICE_VOUCHER_CODE . $secondaryInvoiceId;
                    $itemsQuery = "SELECT * FROM financials_service_invoice_items WHERE seii_invoice_id = $secondaryInvoiceId;";
                    $itemsResult = $database->query($itemsQuery);
                    if ($itemsResult && $database->num_rows($itemsResult) > 0) {
                        while ($item = $database->fetch_assoc($itemsResult)) {
                            $secondaryItemsData[] = $item;
                        }
                    }
                }
            }

            try {
                $formattedDate = new DateTime($primaryInvoiceData['si_day_end_date']);
                $formattedDate = $formattedDate->format(USER_DATE_FORMAT);

                $formattedTimeStamp = new DateTime($primaryInvoiceData['si_datetime']);
                $formattedTimeStamp = $formattedTimeStamp->format(USER_DATE_TIME_FORMAT);
            } catch (Exception $e) {}

            $linkPageUrl = $subDomain . '/public/_api/view/invoice.php?type=' . $SERVICE . '&number=' . $secondaryInvoiceId . '&format=' . $invoiceFormat;
            $secondaryInvoiceLink = $secondaryVoucherNumber == "" ? "" : '<h4 style="margin: 0; padding: 0"><a href="' . $linkPageUrl . '" target="_blank">' . $secondaryVoucherNumber . '</a></h4>';


            $detailHTML .= '<main>
                              <div id="details" class="clearfix">
                                <div id="client">
                                  <div class="to">INVOICE TO:</div>
                                  <h2 class="name">' . $primaryInvoiceData['si_party_name'] . '</h2>
                                  <div class="customer-name">' . $primaryInvoiceData['si_customer_name'] . '&nbsp;</div>
                                  <div class="phone">' . $primaryInvoiceData['si_phone_number'] . '&nbsp;</div>
                                  <div class="phone">' . $primaryInvoiceData['si_whatsapp'] . '&nbsp;</div>
                                  <div class="email"><a href="mailto:' . $primaryInvoiceData['si_email'] . '">' . $primaryInvoiceData['si_email'] . '</a>&nbsp;</div>
                                </div>
                                <div id="invoice">
                                  <h1>' . $primaryVoucherNumber . '</h1>' . $secondaryInvoiceLink . '
                                  <div class="date">Dated: ' . $formattedDate . '</div>
                                  <div class="date">Generated: ' . $formattedTimeStamp . '</div>
                                </div>
                              </div>
                              <table border="0" cellspacing="0" cellpadding="0">
                                <thead>
                                    <tr>
                                        <th class="no" rowspan="2">#</th>
                                        <th class="desc" rowspan="2">PRODUCTS</th>
                                        <th class="qty" rowspan="2">QTY</th>
                                        <th class="qty" rowspan="2">BNS</th>
                                        <th class="unit" rowspan="2">RATE</th>
                                        <th class="disc" colspan="2">DISCOUNT</th>
                                        <th class="tax" colspan="2">TAX</th>
                                        <th class="total" rowspan="2">TOTAL</th>
                                    </tr>
                                    <tr>
                                        <th class="disc-per">%</th>
                                        <th class="disc-amt">AMOUNT</th>
                                        <th class="tax-per">%</th>
                                        <th class="tax-amt">AMOUNT</th>
                                    </tr>
                                </thead>
                                <tbody>';

            $detailHTML_80mm .= '<main>
                              <div id="details" class="clearfix">
                                <div id="invoice">
                                  <h1>' . $primaryVoucherNumber . '</h1>' . $secondaryInvoiceLink . '
                                  <div class="date">Dated: ' . $formattedDate . '</div>
                                  <div class="date">Generated: ' . $formattedTimeStamp . '</div>
                                </div>
                                <div id="client">
                                  <div class="to">INVOICE TO:</div>
                                  <h2 class="name">' . $primaryInvoiceData['si_party_name'] . '</h2>
                                  <div class="customer-name">' . $primaryInvoiceData['si_customer_name'] . '</div>
                                  <div class="phone">' . $primaryInvoiceData['si_phone_number'] . '</div>
                                  <div class="phone">' . $primaryInvoiceData['si_whatsapp'] . '</div>
                                  <div class="email"><a href="mailto:' . $primaryInvoiceData['si_email'] . '">' . $primaryInvoiceData['si_email'] . '</a></div>
                                </div>
                              </div>
                              <table border="0" cellspacing="0" cellpadding="0">
                            <thead>
                                <tr>
                                    <th class="qty">QTY</th>
                                    <th class="unit">RATE</th>
                                    <th class="disc">DIS</th>
                                    <th class="tax">TAX</th>
                                    <th class="total">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>';

            $counter = 0;
            $totalQuantity = 0;
            $totalBonuses = 0;
            $totalPrimaryDiscount = 0;
            $totalPrimaryTax = 0;
            $totalPrimaryAmount = 0;
            $totalPrimarySubAmount = 0;

            $subTotalAmount = 0;
            $totalProductDiscount = $primaryInvoiceData['si_product_disc'];
            $totalServiceDiscount = 0;
            $totalRoundOffDiscount = $primaryInvoiceData['si_round_off_disc'];
            $totalCashDiscount = $primaryInvoiceData['si_cash_disc_amount'];
            $totalDiscount = $primaryInvoiceData['si_total_discount'];
            $totalInclusiveTax = $primaryInvoiceData['si_inclusive_sales_tax'];
            $totalExclusiveTax = $primaryInvoiceData['si_exclusive_sales_tax'];
            $totalTax = $primaryInvoiceData['si_total_sales_tax'];
            $grandTotal = $primaryInvoiceData['si_grand_total'];

            foreach ($primaryItemsData as $item) {

                $counter++;

                $totalQuantity = $totalQuantity + $item['sii_qty'];
                $totalBonuses = $totalBonuses + $item['sii_bonus_qty'];
                $totalPrimaryDiscount = $totalPrimaryDiscount + $item['sii_discount_amount'];
                $totalPrimaryTax = $totalPrimaryTax + $item['sii_saletax_amount'];
                $totalPrimaryAmount = $totalPrimaryAmount + $item['sii_amount'];

                $totalPrimarySubAmount = $totalPrimarySubAmount + ($item['sii_qty'] * $item['sii_rate']);

                $detailHTML .= '
                                <tr>
                                    <td class="no">' . str_pad($counter, 2, '0', STR_PAD_LEFT) . '</td>
                                    <td class="desc"><h3>' . $item['sii_product_name'] . '</h3>' . $item['sii_product_code'] . '</td>
                                    <td class="qty">' . $item['sii_qty'] . '</td>
                                    <td class="qty">' . $item['sii_bonus_qty'] . '</td>
                                    <td class="unit">' . number_format($item['sii_rate'], 2) . '</td>
                                    <td class="disc-per">' . number_format($item['sii_discount_per'], 2) . '</td>
                                    <td class="disc-amt">' . number_format($item['sii_discount_amount'], 2) . '</td>
                                    <td class="tax-per">' . number_format($item['sii_saletax_per'], 2) . ($item['sii_saletax_inclusive'] == 1 ? '(incl)' : '') . '</td>
                                    <td class="tax-amt">' . number_format($item['sii_saletax_amount'], 2) . '</td>
                                    <td class="total">' . number_format($item['sii_amount'], 2) . '</td>
                              </tr>
                                ';

                $detailHTML_80mm .= '<tr>
                                        <td class="desc" colspan="5">' . $item['sii_product_code'] . '<h3>' . $item['sii_product_name'] . '</h3></td>
                                    </tr>
                                    <tr>
                                        <td class="qty">' . $item['sii_qty'] . '</td>
                                        <td class="unit">' . number_format($item['sii_rate'], 2) . '</td>
                                        <td class="disc-amt">' . number_format($item['sii_discount_amount'], 2) . '</td>
                                        <td class="tax-amt">' . number_format($item['sii_saletax_amount'], 2) . ($item['sii_saletax_inclusive'] == 1 ? '(i)' : '') . '</td>
                                        <td class="total">' . number_format($item['sii_amount'], 2) . '</td>
                                  </tr>';
            }

            $subTotalAmount = $subTotalAmount + $totalPrimarySubAmount;

            $detailHTML .= '
                            <tr>
                                <th class="no">' . $counter . '</th>
                                <th class="desc">TOTAL</th>
                                <th class="qty">' . number_format($totalQuantity, 3) . '</th>
                                <th class="qty">' . number_format($totalBonuses, 3) . '</th>
                                <th class="unit"></th>
                                <th class="disc-per"></th>
                                <th class="disc-amt">' . number_format($totalPrimaryDiscount, 2) . '</th>
                                <th class="tax-per"></th>
                                <th class="tax-amt">' . number_format($totalPrimaryTax, 2) . '</th>
                                <th class="total">' . number_format($totalPrimaryAmount, 2) . '</th>
                          </tr>
                          </tbody>
                          </table>';

            $detailHTML_80mm .= '<tr>
                                        <th class="qty">' . number_format($totalQuantity, 3) . '</th>
                                        <th class="unit"></th>
                                        <th class="disc-amt">' . number_format($totalPrimaryDiscount, 2) . '</th>
                                        <th class="tax-amt">' . number_format($totalPrimaryTax, 2) . '</th>
                                        <th class="total">' . number_format($totalPrimaryAmount, 2) . '</th>
                                  </tr>
                                  </tbody>
                                  </table>';


            if (count($secondaryItemsData) > 0) {

                $detailHTML .= '
                          <table border="0" cellspacing="0" cellpadding="0">
                            <thead>
                                <tr>
                                    <th class="no" rowspan="2">#</th>
                                    <th class="desc" rowspan="2">SERVICES</th>
                                    <th class="qty" rowspan="2">QTY</th>
                                    <th class="unit" rowspan="2">RATE</th>
                                    <th class="disc" colspan="2">DISCOUNT</th>
                                    <th class="tax" colspan="2">TAX</th>
                                    <th class="total" rowspan="2">TOTAL</th>
                                </tr>
                                <tr>
                                    <th class="disc-per">%</th>
                                    <th class="disc-amt">AMOUNT</th>
                                    <th class="tax-per">%</th>
                                    <th class="tax-amt">AMOUNT</th>
                                </tr>
                            </thead>
                            <tbody>';

                $detailHTML_80mm .= '</tbody>
                                      </table>
                                </table>
                                      <table border="0" cellspacing="0" cellpadding="0">
                                        <thead>
                                            <tr>
                                                <th class="qty">QTY</th>
                                                <th class="unit">RATE</th>
                                                <th class="disc">DIS</th>
                                                <th class="tax">TAX</th>
                                                <th class="total">TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>';

                $secondaryCounter = 0;
                $totalSecondaryQuantity = 0;
                $totalSecondaryDiscount = 0;
                $totalSecondaryTax = 0;
                $totalSecondaryAmount = 0;
                $totalSecondarySubAmount = 0;

                $totalProductDiscount += 0;
                $totalServiceDiscount += $secondaryInvoiceData['sei_product_disc'];
                $totalRoundOffDiscount += $secondaryInvoiceData['sei_round_off_disc'];
                $totalCashDiscount += $secondaryInvoiceData['sei_cash_disc_amount'];
                $totalDiscount += $secondaryInvoiceData['sei_total_discount'];
                $totalInclusiveTax += $secondaryInvoiceData['sei_inclusive_sales_tax'];
                $totalExclusiveTax += $secondaryInvoiceData['sei_exclusive_sales_tax'];
                $totalTax += $secondaryInvoiceData['sei_total_sales_tax'];
                $grandTotal += $secondaryInvoiceData['sei_grand_total'];

                foreach ($secondaryItemsData as $item) {

                    $secondaryCounter++;

                    $totalSecondaryQuantity = $totalSecondaryQuantity + $item['seii_qty'];
                    $totalSecondaryDiscount = $totalSecondaryDiscount + $item['seii_discount_amount'];
                    $totalSecondaryTax = $totalSecondaryTax + $item['seii_saletax_amount'];
                    $totalSecondaryAmount = $totalSecondaryAmount + $item['seii_amount'];

                    $totalSecondarySubAmount = $totalSecondarySubAmount + ($item['seii_qty'] * $item['seii_rate']);

                    $detailHTML .= '
                                <tr>
                                    <td class="no">' . str_pad($secondaryCounter, 2, '0', STR_PAD_LEFT) . '</td>
                                    <td class="desc"><h3>' . $item['seii_service_name'] . '</h3></td>
                                    <td class="qty">' . $item['seii_qty'] . '</td>
                                    <td class="unit">' . number_format($item['seii_rate'], 2) . '</td>
                                    <td class="disc-per">' . number_format($item['seii_discount_per'], 2) . '</td>
                                    <td class="disc-amt">' . number_format($item['seii_discount_amount'], 2) . '</td>
                                    <td class="tax-per">' . number_format($item['seii_saletax_per'], 2) . ($item['seii_saletax_inclusive'] == 1 ? '(incl)' : '') . '</td>
                                    <td class="tax-amt">' . number_format($item['seii_saletax_amount'], 2) . '</td>
                                    <td class="total">' . number_format($item['seii_amount'], 2) . '</td>
                              </tr>
                                ';

                    $detailHTML_80mm .= '<tr>
                                                <td class="desc" colspan="5"><h3>' . $item['seii_service_name'] . '</h3></td>
                                          </tr>
                                        <tr>
                                            <td class="qty">' . $item['seii_qty'] . '</td>
                                            <td class="unit">' . number_format($item['seii_rate'], 2) . '</td>
                                            <td class="disc-amt">' . number_format($item['seii_discount_amount'], 2) . '</td>
                                            <td class="tax-amt">' . number_format($item['seii_saletax_amount'], 2) . ($item['seii_saletax_inclusive'] == 1 ? '(i)' : '') . '</td>
                                            <td class="total">' . number_format($item['seii_amount'], 2) . '</td>
                                      </tr>';
                }

                $subTotalAmount = $subTotalAmount + $totalSecondarySubAmount;

                $detailHTML .= '
                            <tr>
                                <th class="no">' . $secondaryCounter . '</th>
                                <th class="desc">TOTAL</th>
                                <th class="qty">' . number_format($totalSecondaryQuantity, 3) . '</th>
                                <th class="unit"></th>
                                <th class="disc-per"></th>
                                <th class="disc-amt">' . number_format($totalSecondaryDiscount, 2) . '</th>
                                <th class="tax-per"></th>
                                <th class="tax-amt">' . number_format($totalSecondaryTax, 2) . '</th>
                                <th class="total">' . number_format($totalSecondaryAmount, 2) . '</th>
                          </tr>
                          </tbody>
                          </table>
                            ';

                $detailHTML_80mm .= '<tr>
                                            <th class="qty">' . number_format($totalSecondaryQuantity, 3) . '</th>
                                            <th class="unit"></th>
                                            <th class="disc-amt">' . number_format($totalSecondaryDiscount, 2) . '</th>
                                            <th class="tax-amt">' . number_format($totalSecondaryTax, 2) . '</th>
                                            <th class="total">' . number_format($totalSecondaryAmount, 2) . '</th>
                                      </tr>
                                        </tbody>
                                      </table>';

            }

            $detailHTML .= '
                        <div class="total-section">
                        <div class="inst">
                            <h4>SPECIAL INSTRUCTIONS</h4>
                            <p>
                                ' . $specialInstructions . '
                            </p>
                        </div>
                        <div class="totals">
                        <table>
                        <tfoot>
                          <tr>
                            <td>SUBTOTAL</td>
                            <td></td>
                            <td>' . number_format($subTotalAmount, 2) . '</td>
                          </tr>
                          <tr>
                            <td>PRODUCT DISCOUNT</td>
                            <td>' . number_format($totalProductDiscount, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>SERVICE DISCOUNT</td>
                            <td>' . number_format($totalServiceDiscount, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>ROUND OFF DISCOUNT</td>
                            <td>' . number_format($totalRoundOffDiscount, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>CASH DISCOUNT</td>
                            <td>' . number_format($totalCashDiscount, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>TOTAL DISCOUNT</td>
                            <td></td>
                            <td>' . number_format($totalDiscount, 2) . '</td>
                          </tr>
                          <tr>
                            <td>INCLUSIVE TAX</td>
                            <td>' . number_format($totalInclusiveTax, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>EXCLUSIVE TAX</td>
                            <td>' . number_format($totalExclusiveTax, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>TOTAL TAX</td>
                            <td></td>
                            <td>' . number_format($totalTax, 2) . '</td>
                          </tr>
                          <tr>
                            <td class="grand">GRAND TOTAL</td>
                            <td></td>
                            <td class="grand">' . number_format($grandTotal, 2) . '</td>
                          </tr>
                          <tr>
                            <td class="words" colspan="3">' . number_to_word($grandTotal) . '</td>
                          </tr>
                        </tfoot>
                        </table>
                        </div>
                        </div>
                        <div id="thanks">Thank you!</div>
                            </main>
                            <footer>
                              Invoice was system generated and is valid without the signature and seal.
                            </footer>
                          </body>
                        </html>
                        ';

            $detailHTML_80mm .= '<table>
                                <tfoot>
                                  <tr>
                                    <td>SUBTOTAL</td>
                                    <td></td>
                                    <td>' . number_format($subTotalAmount, 2) . '</td>
                                  </tr>
                                  <tr>
                                    <td>PRODUCT DISCOUNT</td>
                                    <td>' . number_format($totalProductDiscount, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>SERVICE DISCOUNT</td>
                                    <td>' . number_format($totalServiceDiscount, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>ROUND OFF DISCOUNT</td>
                                    <td>' . number_format($totalRoundOffDiscount, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>CASH DISCOUNT</td>
                                     <td>' . number_format($totalCashDiscount, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>TOTAL DISCOUNT</td>
                                    <td></td>
                                    <td>' . number_format($totalDiscount, 2) . '</td>
                                  </tr>
                                  <tr>
                                    <td>INCLUSIVE TAX</td>
                                    <td>' . number_format($totalInclusiveTax, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>EXCLUSIVE TAX</td>
                                    <td>' . number_format($totalExclusiveTax, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>TOTAL TAX</td>
                                    <td></td>
                                    <td>' . number_format($totalTax, 2) . '</td>
                                  </tr>
                                  <tr>
                                    <td class="grand">GRAND TOTAL</td>
                                    <td class="grand" colspan="2">' . number_format($grandTotal, 2) . '</td>
                                  </tr>
                                  <tr>
                                    <td class="words" colspan="3">' . number_to_word($grandTotal) . '</td>
                                  </tr>
                                </tfoot>
                                </table>
                                <h4 class="center">SPECIAL INSTRUCTIONS</h4>
                                <p class="center">
                                    ' . $specialInstructions . '
                                </p>
                                <div id="thanks" class="center">Thank you!</div>
                                    </main>
                                    <footer>
                                      Invoice was system generated and is valid without the signature and seal.
                                    </footer>
                                  </body>
                                </html>';

        } else {
            dieWithError("Invoice not found!", $database);
        }
        break;
    case $SALE_TAX:
        // todo sale tax invoice
        $invoiceTitle = "SALE TAX INVOICE";
        $invoiceQuery = "SELECT * FROM financials_sale_saletax_invoice WHERE ssi_id = $invoiceNumber LIMIT 1;";
        $invoiceResult = $database->query($invoiceQuery);
        if ($invoiceResult && $database->num_rows($invoiceResult) == 1) {
            $primaryInvoiceData = $database->fetch_assoc($invoiceResult);
            $primaryInvoiceId = $primaryInvoiceData['ssi_id'];
            $secondaryId = $primaryInvoiceData['ssi_service_invoice_id'];
            $primaryVoucherNumber = SALE_TEX_SALE_VOUCHER_CODE . $primaryInvoiceId;
            $itemsQuery = "SELECT * FROM financials_sale_saletax_invoice_items WHERE ssii_invoice_id = $primaryInvoiceId;";
            $itemsResult = $database->query($itemsQuery);
            if ($itemsResult && $database->num_rows($itemsResult) > 0) {
                while ($item = $database->fetch_assoc($itemsResult)) {
                    $primaryItemsData[] = $item;
                }
            }

            if ($secondaryId != 0) {
                $invoiceQuery = "SELECT * FROM financials_service_saletax_invoice WHERE sesi_id = $secondaryId LIMIT 1;";
                $invoiceResult = $database->query($invoiceQuery);
                if ($invoiceResult && $database->num_rows($invoiceResult) == 1) {
                    $secondaryInvoiceData = $database->fetch_assoc($invoiceResult);
                    $secondaryInvoiceId = $secondaryInvoiceData['sesi_id'];
                    $secondaryVoucherNumber = SERVICE_TAX_VOUCHER_CODE . $secondaryInvoiceId;
                    $itemsQuery = "SELECT * FROM financials_service_saletax_invoice_items WHERE sesii_invoice_id = $secondaryInvoiceId;";
                    $itemsResult = $database->query($itemsQuery);
                    if ($itemsResult && $database->num_rows($itemsResult) > 0) {
                        while ($item = $database->fetch_assoc($itemsResult)) {
                            $secondaryItemsData[] = $item;
                        }
                    }
                }
            }

            try {
                $formattedDate = new DateTime($primaryInvoiceData['ssi_day_end_date']);
                $formattedDate = $formattedDate->format(USER_DATE_FORMAT);

                $formattedTimeStamp = new DateTime($primaryInvoiceData['ssi_datetime']);
                $formattedTimeStamp = $formattedTimeStamp->format(USER_DATE_TIME_FORMAT);
            } catch (Exception $e) {}

            $linkPageUrl = $subDomain . '/public/_api/view/invoice.php?type=' . $SERVICE_TAX . '&number=' . $secondaryInvoiceId . '&format=' . $invoiceFormat;
            $secondaryInvoiceLink = $secondaryVoucherNumber == "" ? "" : '<h4 style="margin: 0; padding: 0"><a href="' . $linkPageUrl . '" target="_blank">' . $secondaryVoucherNumber . '</a></h4>';


            $detailHTML .= '<main>
                              <div id="details" class="clearfix">
                                <div id="client">
                                  <div class="to">INVOICE TO:</div>
                                  <h2 class="name">' . $primaryInvoiceData['ssi_party_name'] . '</h2>
                                  <div class="customer-name">' . $primaryInvoiceData['ssi_customer_name'] . '&nbsp;</div>
                                  <div class="phone">' . $primaryInvoiceData['ssi_phone_number'] . '&nbsp;</div>
                                  <div class="phone">' . $primaryInvoiceData['ssi_whatsapp'] . '&nbsp;</div>
                                  <div class="email"><a href="mailto:' . $primaryInvoiceData['ssi_email'] . '">' . $primaryInvoiceData['ssi_email'] . '</a>&nbsp;</div>
                                </div>
                                <div id="invoice">
                                  <h1>' . $primaryVoucherNumber . '</h1>' . $secondaryInvoiceLink . '
                                  <div class="date">Dated: ' . $formattedDate . '</div>
                                  <div class="date">Generated: ' . $formattedTimeStamp . '</div>
                                </div>
                              </div>
                              <table border="0" cellspacing="0" cellpadding="0">
                                <thead>
                                    <tr>
                                        <th class="no" rowspan="2">#</th>
                                        <th class="desc" rowspan="2">PRODUCTS</th>
                                        <th class="qty" rowspan="2">QTY</th>
                                        <th class="unit" rowspan="2">RATE</th>
                                        <th class="disc" colspan="2">DISCOUNT</th>
                                        <th class="tax" colspan="2">TAX</th>
                                        <th class="total" rowspan="2">TOTAL</th>
                                    </tr>
                                    <tr>
                                        <th class="disc-per">%</th>
                                        <th class="disc-amt">AMOUNT</th>
                                        <th class="tax-per">%</th>
                                        <th class="tax-amt">AMOUNT</th>
                                    </tr>
                                </thead>
                                <tbody>';

            $detailHTML_80mm .= '<main>
                              <div id="details" class="clearfix">
                                <div id="invoice">
                                  <h1>' . $primaryVoucherNumber . '</h1>' . $secondaryInvoiceLink . '
                                  <div class="date">Dated: ' . $formattedDate . '</div>
                                  <div class="date">Generated: ' . $formattedTimeStamp . '</div>
                                </div>
                                <div id="client">
                                  <div class="to">INVOICE TO:</div>
                                  <h2 class="name">' . $primaryInvoiceData['ssi_party_name'] . '</h2>
                                  <div class="customer-name">' . $primaryInvoiceData['ssi_customer_name'] . '</div>
                                  <div class="phone">' . $primaryInvoiceData['ssi_phone_number'] . '</div>
                                  <div class="phone">' . $primaryInvoiceData['ssi_whatsapp'] . '</div>
                                  <div class="email"><a href="mailto:' . $primaryInvoiceData['ssi_email'] . '">' . $primaryInvoiceData['ssi_email'] . '</a></div>
                                </div>
                              </div>
                              <table border="0" cellspacing="0" cellpadding="0">
                            <thead>
                                <tr>
                                    <th class="qty">QTY</th>
                                    <th class="unit">RATE</th>
                                    <th class="disc">DIS</th>
                                    <th class="tax">TAX</th>
                                    <th class="total">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>';

            $counter = 0;
            $totalQuantity = 0;
            $totalPrimaryDiscount = 0;
            $totalPrimaryTax = 0;
            $totalPrimaryAmount = 0;
            $totalPrimarySubAmount = 0;

            $subTotalAmount = 0;
            $totalProductDiscount = $primaryInvoiceData['ssi_product_disc'];
            $totalServiceDiscount = 0;
            $totalRoundOffDiscount = $primaryInvoiceData['ssi_round_off_disc'];
            $totalCashDiscount = $primaryInvoiceData['ssi_cash_disc_amount'];
            $totalDiscount = $primaryInvoiceData['ssi_total_discount'];
            $totalInclusiveTax = $primaryInvoiceData['ssi_inclusive_sales_tax'];
            $totalExclusiveTax = $primaryInvoiceData['ssi_exclusive_sales_tax'];
            $totalTax = $primaryInvoiceData['ssi_total_sales_tax'];
            $grandTotal = $primaryInvoiceData['ssi_grand_total'];

            foreach ($primaryItemsData as $item) {

                $counter++;

                $totalQuantity = $totalQuantity + $item['ssii_qty'];
                $totalPrimaryDiscount = $totalPrimaryDiscount + $item['ssii_discount_amount'];
                $totalPrimaryTax = $totalPrimaryTax + $item['ssii_saletax_amount'];
                $totalPrimaryAmount = $totalPrimaryAmount + $item['ssii_amount'];

                $totalPrimarySubAmount = $totalPrimarySubAmount + ($item['ssii_qty'] * $item['ssii_rate']);

                $detailHTML .= '
                                <tr>
                                    <td class="no">' . str_pad($counter, 2, '0', STR_PAD_LEFT) . '</td>
                                    <td class="desc"><h3>' . $item['ssii_product_name'] . '</h3>' . $item['ssii_product_code'] . '</td>
                                    <td class="qty">' . $item['ssii_qty'] . '</td>
                                    <td class="unit">' . number_format($item['ssii_rate'], 2) . '</td>
                                    <td class="disc-per">' . number_format($item['ssii_discount_per'], 2) . '</td>
                                    <td class="disc-amt">' . number_format($item['ssii_discount_amount'], 2) . '</td>
                                    <td class="tax-per">' . number_format($item['ssii_saletax_per'], 2) . ($item['ssii_saletax_inclusive'] == 1 ? '(incl)' : '') . '</td>
                                    <td class="tax-amt">' . number_format($item['ssii_saletax_amount'], 2) . '</td>
                                    <td class="total">' . number_format($item['ssii_amount'], 2) . '</td>
                              </tr>
                                ';

                $detailHTML_80mm .= '<tr>
                                        <td class="desc" colspan="5">' . $item['ssii_product_code'] . '<h3>' . $item['ssii_product_name'] . '</h3></td>
                                    </tr>
                                    <tr>
                                        <td class="qty">' . $item['ssii_qty'] . '</td>
                                        <td class="unit">' . number_format($item['ssii_rate'], 2) . '</td>
                                        <td class="disc-amt">' . number_format($item['ssii_discount_amount'], 2) . '</td>
                                        <td class="tax-amt">' . number_format($item['ssii_saletax_amount'], 2) . ($item['ssii_saletax_inclusive'] == 1 ? '(i)' : '') . '</td>
                                        <td class="total">' . number_format($item['ssii_amount'], 2) . '</td>
                                  </tr>';
            }

            $subTotalAmount = $subTotalAmount + $totalPrimarySubAmount;

            $detailHTML .= '
                            <tr>
                                <th class="no">' . $counter . '</th>
                                <th class="desc">TOTAL</th>
                                <th class="qty">' . $totalQuantity . '</th>
                                <th class="unit"></th>
                                <th class="disc-per"></th>
                                <th class="disc-amt">' . number_format($totalPrimaryDiscount, 2) . '</th>
                                <th class="tax-per"></th>
                                <th class="tax-amt">' . number_format($totalPrimaryTax, 2) . '</th>
                                <th class="total">' . number_format($totalPrimaryAmount, 2) . '</th>
                          </tr>
                    </tbody>
                  </table>';

            $detailHTML_80mm .= '<tr>
                                        <th class="qty">' . $totalQuantity . '</th>
                                        <th class="unit"></th>
                                        <th class="disc-amt">' . number_format($totalPrimaryDiscount, 2) . '</th>
                                        <th class="tax-amt">' . number_format($totalPrimaryTax, 2) . '</th>
                                        <th class="total">' . number_format($totalPrimaryAmount, 2) . '</th>
                                  </tr>
                                  </tbody>
                                  </table>';


            if (count($secondaryItemsData) > 0) {

                $detailHTML .= '
                          <table border="0" cellspacing="0" cellpadding="0">
                            <thead>
                                <tr>
                                    <th class="no" rowspan="2">#</th>
                                    <th class="desc" rowspan="2">SERVICES</th>
                                    <th class="qty" rowspan="2">QTY</th>
                                    <th class="unit" rowspan="2">RATE</th>
                                    <th class="disc" colspan="2">DISCOUNT</th>
                                    <th class="tax" colspan="2">TAX</th>
                                    <th class="total" rowspan="2">TOTAL</th>
                                </tr>
                                <tr>
                                    <th class="disc-per">%</th>
                                    <th class="disc-amt">AMOUNT</th>
                                    <th class="tax-per">%</th>
                                    <th class="tax-amt">AMOUNT</th>
                                </tr>
                            </thead>
                            <tbody>';

                $detailHTML_80mm .= '</tbody>
                                      </table>
                                </table>
                                      <table border="0" cellspacing="0" cellpadding="0">
                                        <thead>
                                            <tr>
                                                <th class="qty">QTY</th>
                                                <th class="unit">RATE</th>
                                                <th class="disc">DIS</th>
                                                <th class="tax">TAX</th>
                                                <th class="total">TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
                $secondaryCounter = 0;
                $totalSecondaryQuantity = 0;
                $totalSecondaryDiscount = 0;
                $totalSecondaryTax = 0;
                $totalSecondaryAmount = 0;
                $totalSecondarySubAmount = 0;

                $totalProductDiscount += 0;
                $totalServiceDiscount += $secondaryInvoiceData['sesi_product_disc'];
                $totalRoundOffDiscount += $secondaryInvoiceData['sesi_round_off_disc'];
                $totalCashDiscount += $secondaryInvoiceData['sesi_cash_disc_amount'];
                $totalDiscount += $secondaryInvoiceData['sesi_total_discount'];
                $totalInclusiveTax += $secondaryInvoiceData['sesi_inclusive_sales_tax'];
                $totalExclusiveTax += $secondaryInvoiceData['sesi_exclusive_sales_tax'];
                $totalTax += $secondaryInvoiceData['sesi_total_sales_tax'];
                $grandTotal += $secondaryInvoiceData['sesi_grand_total'];

                foreach ($secondaryItemsData as $item) {

                    $secondaryCounter++;

                    $totalSecondaryQuantity = $totalSecondaryQuantity + $item['sesii_qty'];
                    $totalSecondaryDiscount = $totalSecondaryDiscount + $item['sesii_discount_amount'];
                    $totalSecondaryTax = $totalSecondaryTax + $item['sesii_saletax_amount'];
                    $totalSecondaryAmount = $totalSecondaryAmount + $item['sesii_amount'];

                    $totalSecondarySubAmount = $totalSecondarySubAmount + ($item['sesii_qty'] * $item['sesii_rate']);

                    $detailHTML .= '
                                <tr>
                                    <td class="no">' . str_pad($secondaryCounter, 2, '0', STR_PAD_LEFT) . '</td>
                                    <td class="desc"><h3>' . $item['sesii_service_name'] . '</h3></td>
                                    <td class="qty">' . $item['sesii_qty'] . '</td>
                                    <td class="unit">' . number_format($item['sesii_rate'], 2) . '</td>
                                    <td class="disc-per">' . number_format($item['sesii_discount_per'], 2) . '</td>
                                    <td class="disc-amt">' . number_format($item['sesii_discount_amount'], 2) . '</td>
                                    <td class="tax-per">' . number_format($item['sesii_saletax_per'], 2) . ($item['sesii_saletax_inclusive'] == 1 ? '(incl)' : '') . '</td>
                                    <td class="tax-amt">' . number_format($item['sesii_saletax_amount'], 2) . '</td>
                                    <td class="total">' . number_format($item['sesii_amount'], 2) . '</td>
                              </tr>
                                ';

                    $detailHTML_80mm .= '<tr>
                                                <td class="desc" colspan="5"><h3>' . $item['sesii_service_name'] . '</h3></td>
                                          </tr>
                                        <tr>
                                            <td class="qty">' . $item['sesii_qty'] . '</td>
                                            <td class="unit">' . number_format($item['sesii_rate'], 2) . '</td>
                                            <td class="disc-amt">' . number_format($item['sesii_discount_amount'], 2) . '</td>
                                            <td class="tax-amt">' . number_format($item['sesii_saletax_amount'], 2) . ($item['sesii_saletax_inclusive'] == 1 ? '(i)' : '') . '</td>
                                            <td class="total">' . number_format($item['sesii_amount'], 2) . '</td>
                                      </tr>';
                }

                $subTotalAmount = $subTotalAmount + $totalSecondarySubAmount;

                $detailHTML .= '
                            <tr>
                                <th class="no">' . $secondaryCounter . '</th>
                                <th class="desc">TOTAL</th>
                                <th class="qty">' . $totalSecondaryQuantity . '</th>
                                <th class="unit"></th>
                                <th class="disc-per"></th>
                                <th class="disc-amt">' . number_format($totalSecondaryDiscount, 2) . '</th>
                                <th class="tax-per"></th>
                                <th class="tax-amt">' . number_format($totalSecondaryTax, 2) . '</th>
                                <th class="total">' . number_format($totalSecondaryAmount, 2) . '</th>
                          </tr>
                            </tbody>
                          </table>';

                $detailHTML_80mm .= '<tr>
                                            <th class="qty">' . $totalSecondaryQuantity . '</th>
                                            <th class="unit"></th>
                                            <th class="disc-amt">' . number_format($totalSecondaryDiscount, 2) . '</th>
                                            <th class="tax-amt">' . number_format($totalSecondaryTax, 2) . '</th>
                                            <th class="total">' . number_format($totalSecondaryAmount, 2) . '</th>
                                      </tr>
                                        </tbody>
                                      </table>';

            }

            $detailHTML .= '
                        <div class="total-section">
                        <div class="inst">
                            <h4>SPECIAL INSTRUCTIONS</h4>
                            <p>
                                ' . $specialInstructions . '
                            </p>
                        </div>
                        <div class="totals">
                        <table>
                        <tfoot>
                          <tr>
                            <td>SUBTOTAL</td>
                            <td></td>
                            <td>' . number_format($subTotalAmount, 2) . '</td>
                          </tr>
                          <tr>
                            <td>PRODUCT DISCOUNT</td>
                            <td>' . number_format($totalProductDiscount, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>SERVICE DISCOUNT</td>
                            <td>' . number_format($totalServiceDiscount, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>ROUND OFF DISCOUNT</td>
                            <td>' . number_format($totalRoundOffDiscount, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>CASH DISCOUNT</td>
                            <td>' . number_format($totalCashDiscount, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>TOTAL DISCOUNT</td>
                            <td></td>
                            <td>' . number_format($totalDiscount, 2) . '</td>
                          </tr>
                          <tr>
                            <td>INCLUSIVE TAX</td>
                            <td>' . number_format($totalInclusiveTax, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>EXCLUSIVE TAX</td>
                            <td>' . number_format($totalExclusiveTax, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>TOTAL TAX</td>
                            <td></td>
                            <td>' . number_format($totalTax, 2) . '</td>
                          </tr>
                          <tr>
                            <td class="grand">GRAND TOTAL</td>
                            <td></td>
                            <td class="grand">' . number_format($grandTotal, 2) . '</td>
                          </tr>
                          <tr>
                            <td class="words" colspan="3">' . number_to_word($grandTotal) . '</td>
                          </tr>
                        </tfoot>
                        </table>
                        </div>
                        </div>
                        <div id="thanks">Thank you!</div>
                            </main>
                            <footer>
                              Invoice was system generated and is valid without the signature and seal.
                            </footer>
                          </body>
                        </html>
                        ';

            $detailHTML_80mm .= '<table>
                                <tfoot>
                                  <tr>
                                    <td>SUBTOTAL</td>
                                    <td></td>
                                    <td>' . number_format($subTotalAmount, 2) . '</td>
                                  </tr>
                                  <tr>
                                    <td>PRODUCT DISCOUNT</td>
                                    <td>' . number_format($totalProductDiscount, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>SERVICE DISCOUNT</td>
                                    <td>' . number_format($totalServiceDiscount, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>ROUND OFF DISCOUNT</td>
                                    <td>' . number_format($totalRoundOffDiscount, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>CASH DISCOUNT</td>
                                     <td>' . number_format($totalCashDiscount, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>TOTAL DISCOUNT</td>
                                    <td></td>
                                    <td>' . number_format($totalDiscount, 2) . '</td>
                                  </tr>
                                  <tr>
                                    <td>INCLUSIVE TAX</td>
                                    <td>' . number_format($totalInclusiveTax, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>EXCLUSIVE TAX</td>
                                    <td>' . number_format($totalExclusiveTax, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>TOTAL TAX</td>
                                    <td></td>
                                    <td>' . number_format($totalTax, 2) . '</td>
                                  </tr>
                                  <tr>
                                    <td class="grand">GRAND TOTAL</td>
                                    <td class="grand" colspan="2">' . number_format($grandTotal, 2) . '</td>
                                  </tr>
                                  <tr>
                                    <td class="words" colspan="3">' . number_to_word($grandTotal) . '</td>
                                  </tr>
                                </tfoot>
                                </table>
                                <h4 class="center">SPECIAL INSTRUCTIONS</h4>
                                <p class="center">
                                    ' . $specialInstructions . '
                                </p>
                                <div id="thanks" class="center">Thank you!</div>
                                    </main>
                                    <footer>
                                      Invoice was system generated and is valid without the signature and seal.
                                    </footer>
                                  </body>
                                </html>';

        } else {
            dieWithError("Invoice not found!", $database);
        }
        break;
    case $SALE_RETURN:
        // todo sale return invoice
        $invoiceTitle = "SALE RETURN INVOICE";
        $invoiceQuery = "SELECT * FROM financials_sale_return_invoice WHERE sri_id = $invoiceNumber LIMIT 1;";
        $invoiceResult = $database->query($invoiceQuery);
        if ($invoiceResult && $database->num_rows($invoiceResult) == 1) {
            $primaryInvoiceData = $database->fetch_assoc($invoiceResult);
            $primaryInvoiceId = $primaryInvoiceData['sri_id'];
            $primaryVoucherNumber = SALE_RETURN_VOUCHER_CODE . $primaryInvoiceId;
            $itemsQuery = "SELECT * FROM financials_sale_return_invoice_items WHERE srii_invoice_id = $primaryInvoiceId;";
            $itemsResult = $database->query($itemsQuery);
            if ($itemsResult && $database->num_rows($itemsResult) > 0) {
                while ($item = $database->fetch_assoc($itemsResult)) {
                    $primaryItemsData[] = $item;
                }
            }

            try {
                $formattedDate = new DateTime($primaryInvoiceData['sri_day_end_date']);
                $formattedDate = $formattedDate->format(USER_DATE_FORMAT);

                $formattedTimeStamp = new DateTime($primaryInvoiceData['sri_datetime']);
                $formattedTimeStamp = $formattedTimeStamp->format(USER_DATE_TIME_FORMAT);
            } catch (Exception $e) {}

            $detailHTML .= '<main>
                              <div id="details" class="clearfix">
                                <div id="client">
                                  <div class="to">INVOICE TO:</div>
                                  <h2 class="name">' . $primaryInvoiceData['sri_party_name'] . '</h2>
                                  <div class="customer-name">' . $primaryInvoiceData['sri_customer_name'] . '&nbsp;</div>
                                  <div class="phone">' . $primaryInvoiceData['sri_phone_number'] . '&nbsp;</div>
                                  <div class="phone">' . $primaryInvoiceData['sri_whatsapp'] . '&nbsp;</div>
                                  <div class="email"><a href="mailto:' . $primaryInvoiceData['sri_email'] . '">' . $primaryInvoiceData['sri_email'] . '</a>&nbsp;</div>
                                </div>
                                <div id="invoice">
                                  <h1>' . $primaryVoucherNumber . '</h1>
                                  <div class="date">Dated: ' . $formattedDate . '</div>
                                  <div class="date">Generated: ' . $formattedTimeStamp . '</div>
                                </div>
                              </div>
                              <table border="0" cellspacing="0" cellpadding="0">
                                <thead>
                                    <tr>
                                        <th class="no" rowspan="2">#</th>
                                        <th class="desc" rowspan="2">PRODUCTS</th>
                                        <th class="qty" rowspan="2">QTY</th>
                                        <th class="unit" rowspan="2">RATE</th>
                                        <th class="disc" colspan="2">DISCOUNT</th>
                                        <th class="tax" colspan="2">TAX</th>
                                        <th class="total" rowspan="2">TOTAL</th>
                                    </tr>
                                    <tr>
                                        <th class="disc-per">%</th>
                                        <th class="disc-amt">AMOUNT</th>
                                        <th class="tax-per">%</th>
                                        <th class="tax-amt">AMOUNT</th>
                                    </tr>
                                </thead>
                                <tbody>';

            $detailHTML_80mm .= '<main>
                              <div id="details" class="clearfix">
                                <div id="invoice">
                                  <h1>' . $primaryVoucherNumber . '</h1>
                                  <div class="date">Dated: ' . $formattedDate . '</div>
                                  <div class="date">Generated: ' . $formattedTimeStamp . '</div>
                                </div>
                                <div id="client">
                                  <div class="to">INVOICE TO:</div>
                                  <h2 class="name">' . $primaryInvoiceData['sri_party_name'] . '</h2>
                                  <div class="customer-name">' . $primaryInvoiceData['sri_customer_name'] . '</div>
                                  <div class="phone">' . $primaryInvoiceData['sri_phone_number'] . '</div>
                                  <div class="phone">' . $primaryInvoiceData['sri_whatsapp'] . '</div>
                                  <div class="email"><a href="mailto:' . $primaryInvoiceData['sri_email'] . '">' . $primaryInvoiceData['sri_email'] . '</a></div>
                                </div>
                              </div>
                              <table border="0" cellspacing="0" cellpadding="0">
                            <thead>
                                <tr>
                                    <th class="qty">QTY</th>
                                    <th class="unit">RATE</th>
                                    <th class="disc">DIS</th>
                                    <th class="tax">TAX</th>
                                    <th class="total">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>';

            $counter = 0;
            $totalQuantity = 0;
            $totalPrimaryDiscount = 0;
            $totalPrimaryTax = 0;
            $totalPrimaryAmount = 0;
            $totalPrimarySubAmount = 0;

            $subTotalAmount = 0;
            $totalProductDiscount = $primaryInvoiceData['sri_product_disc'];
            $totalServiceDiscount = 0;
            $totalRoundOffDiscount = $primaryInvoiceData['sri_round_off_disc'];
            $totalCashDiscount = $primaryInvoiceData['sri_cash_disc_amount'];
            $totalDiscount = $primaryInvoiceData['sri_total_discount'];
            $totalInclusiveTax = $primaryInvoiceData['sri_inclusive_sales_tax'];
            $totalExclusiveTax = $primaryInvoiceData['sri_exclusive_sales_tax'];
            $totalTax = $primaryInvoiceData['sri_total_sales_tax'];
            $grandTotal = $primaryInvoiceData['sri_grand_total'];

            foreach ($primaryItemsData as $item) {

                $counter++;

                $totalQuantity = $totalQuantity + $item['srii_qty'];
                $totalPrimaryDiscount = $totalPrimaryDiscount + $item['srii_discount_amount'];
                $totalPrimaryTax = $totalPrimaryTax + $item['srii_saletax_amount'];
                $totalPrimaryAmount = $totalPrimaryAmount + $item['srii_amount'];

                $totalPrimarySubAmount = $totalPrimarySubAmount + ($item['srii_qty'] * $item['srii_rate']);

                $detailHTML .= '
                                <tr>
                                    <td class="no">' . str_pad($counter, 2, '0', STR_PAD_LEFT) . '</td>
                                    <td class="desc"><h3>' . $item['srii_product_name'] . '</h3>' . $item['srii_product_code'] . '</td>
                                    <td class="qty">' . $item['srii_qty'] . '</td>
                                    <td class="unit">' . number_format($item['srii_rate'], 2) . '</td>
                                    <td class="disc-per">' . number_format($item['srii_discount_per'], 2) . '</td>
                                    <td class="disc-amt">' . number_format($item['srii_discount_amount'], 2) . '</td>
                                    <td class="tax-per">' . number_format($item['srii_saletax_per'], 2) . ($item['srii_saletax_inclusive'] == 1 ? '(incl)' : '') . '</td>
                                    <td class="tax-amt">' . number_format($item['srii_saletax_amount'], 2) . '</td>
                                    <td class="total">' . number_format($item['srii_amount'], 2) . '</td>
                              </tr>
                                ';

                $detailHTML_80mm .= '<tr>
                                        <td class="desc" colspan="5">' . $item['srii_product_code'] . '<h3>' . $item['srii_product_name'] . '</h3></td>
                                    </tr>
                                    <tr>
                                        <td class="qty">' . $item['srii_qty'] . '</td>
                                        <td class="unit">' . number_format($item['srii_rate'], 2) . '</td>
                                        <td class="disc-amt">' . number_format($item['srii_discount_amount'], 2) . '</td>
                                        <td class="tax-amt">' . number_format($item['srii_saletax_amount'], 2) . ($item['srii_saletax_inclusive'] == 1 ? '(i)' : '') . '</td>
                                        <td class="total">' . number_format($item['srii_amount'], 2) . '</td>
                                  </tr>';
            }

            $subTotalAmount = $subTotalAmount + $totalPrimarySubAmount;

            $detailHTML .= '
                            <tr>
                                <th class="no">' . $counter . '</th>
                                <th class="desc">TOTAL</th>
                                <th class="qty">' . $totalQuantity . '</th>
                                <th class="unit"></th>
                                <th class="disc-per"></th>
                                <th class="disc-amt">' . number_format($totalPrimaryDiscount, 2) . '</th>
                                <th class="tax-per"></th>
                                <th class="tax-amt">' . number_format($totalPrimaryTax, 2) . '</th>
                                <th class="total">' . number_format($totalPrimaryAmount, 2) . '</th>
                          </tr>
                    </tbody>
                  </table>';

            $detailHTML_80mm .= '<tr>
                                        <th class="qty">' . $totalQuantity . '</th>
                                        <th class="unit"></th>
                                        <th class="disc-amt">' . number_format($totalPrimaryDiscount, 2) . '</th>
                                        <th class="tax-amt">' . number_format($totalPrimaryTax, 2) . '</th>
                                        <th class="total">' . number_format($totalPrimaryAmount, 2) . '</th>
                                  </tr>
                                  </tbody>
                                  </table>';

            $detailHTML .= '
                        <div class="total-section">
                        <div class="inst">
                            <h4>SPECIAL INSTRUCTIONS</h4>
                            <p>
                                ' . $specialInstructions . '
                            </p>
                        </div>
                        <div class="totals">
                        <table>
                        <tfoot>
                          <tr>
                            <td>SUBTOTAL</td>
                            <td></td>
                            <td>' . number_format($subTotalAmount, 2) . '</td>
                          </tr>
                          <tr>
                            <td>PRODUCT DISCOUNT</td>
                            <td>' . number_format($totalProductDiscount, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>ROUND OFF DISCOUNT</td>
                            <td>' . number_format($totalRoundOffDiscount, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>CASH DISCOUNT</td>
                            <td>' . number_format($totalCashDiscount, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>TOTAL DISCOUNT</td>
                            <td></td>
                            <td>' . number_format($totalDiscount, 2) . '</td>
                          </tr>
                          <tr>
                            <td>INCLUSIVE TAX</td>
                            <td>' . number_format($totalInclusiveTax, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>EXCLUSIVE TAX</td>
                            <td>' . number_format($totalExclusiveTax, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>TOTAL TAX</td>
                            <td></td>
                            <td>' . number_format($totalTax, 2) . '</td>
                          </tr>
                          <tr>
                            <td class="grand">GRAND TOTAL</td>
                            <td></td>
                            <td class="grand">' . number_format($grandTotal, 2) . '</td>
                          </tr>
                          <tr>
                            <td class="words" colspan="3">' . number_to_word($grandTotal) . '</td>
                          </tr>
                        </tfoot>
                        </table>
                        </div>
                        </div>
                        <div id="thanks">Thank you!</div>
                            </main>
                            <footer>
                              Invoice was system generated and is valid without the signature and seal.
                            </footer>
                          </body>
                        </html>
                        ';

            $detailHTML_80mm .= '<table>
                                <tfoot>
                                  <tr>
                                    <td>SUBTOTAL</td>
                                    <td></td>
                                    <td>' . number_format($subTotalAmount, 2) . '</td>
                                  </tr>
                                  <tr>
                                    <td>PRODUCT DISCOUNT</td>
                                    <td>' . number_format($totalProductDiscount, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>ROUND OFF DISCOUNT</td>
                                    <td>' . number_format($totalRoundOffDiscount, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>CASH DISCOUNT</td>
                                     <td>' . number_format($totalCashDiscount, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>TOTAL DISCOUNT</td>
                                    <td></td>
                                    <td>' . number_format($totalDiscount, 2) . '</td>
                                  </tr>
                                  <tr>
                                    <td>INCLUSIVE TAX</td>
                                    <td>' . number_format($totalInclusiveTax, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>EXCLUSIVE TAX</td>
                                    <td>' . number_format($totalExclusiveTax, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>TOTAL TAX</td>
                                    <td></td>
                                    <td>' . number_format($totalTax, 2) . '</td>
                                  </tr>
                                  <tr>
                                    <td class="grand">GRAND TOTAL</td>
                                    <td class="grand" colspan="2">' . number_format($grandTotal, 2) . '</td>
                                  </tr>
                                  <tr>
                                    <td class="words" colspan="3">' . number_to_word($grandTotal) . '</td>
                                  </tr>
                                </tfoot>
                                </table>
                                <h4 class="center">SPECIAL INSTRUCTIONS</h4>
                                <p class="center">
                                    ' . $specialInstructions . '
                                </p>
                                <div id="thanks" class="center">Thank you!</div>
                                    </main>
                                    <footer>
                                      Invoice was system generated and is valid without the signature and seal.
                                    </footer>
                                  </body>
                                </html>';

        } else {
            dieWithError("Invoice not found!", $database);
        }
        break;
    case $SALE_TAX_RETURN:
        // todo sale tax return invoice
        $invoiceTitle = "SALE TAX RETURN INVOICE";
        $invoiceQuery = "SELECT * FROM financials_sale_return_saletax_invoice WHERE srsi_id = $invoiceNumber LIMIT 1;";
        $invoiceResult = $database->query($invoiceQuery);
        if ($invoiceResult && $database->num_rows($invoiceResult) == 1) {
            $primaryInvoiceData = $database->fetch_assoc($invoiceResult);
            $primaryInvoiceId = $primaryInvoiceData['srsi_id'];
            $primaryVoucherNumber = SALE_TEX_SALE_RETURN_VOUCHER_CODE . $primaryInvoiceId;
            $itemsQuery = "SELECT * FROM financials_sale_return_saletax_invoice_items WHERE srsii_invoice_id = $primaryInvoiceId;";
            $itemsResult = $database->query($itemsQuery);
            if ($itemsResult && $database->num_rows($itemsResult) > 0) {
                while ($item = $database->fetch_assoc($itemsResult)) {
                    $primaryItemsData[] = $item;
                }
            }

            try {
                $formattedDate = new DateTime($primaryInvoiceData['srsi_day_end_date']);
                $formattedDate = $formattedDate->format(USER_DATE_FORMAT);

                $formattedTimeStamp = new DateTime($primaryInvoiceData['srsi_datetime']);
                $formattedTimeStamp = $formattedTimeStamp->format(USER_DATE_TIME_FORMAT);
            } catch (Exception $e) {}

            $detailHTML .= '<main>
                              <div id="details" class="clearfix">
                                <div id="client">
                                  <div class="to">INVOICE TO:</div>
                                  <h2 class="name">' . $primaryInvoiceData['srsi_party_name'] . '</h2>
                                  <div class="customer-name">' . $primaryInvoiceData['srsi_customer_name'] . '&nbsp;</div>
                                  <div class="phone">' . $primaryInvoiceData['srsi_phone_number'] . '&nbsp;</div>
                                  <div class="phone">' . $primaryInvoiceData['srsi_whatsapp'] . '&nbsp;</div>
                                  <div class="email"><a href="mailto:' . $primaryInvoiceData['srsi_email'] . '">' . $primaryInvoiceData['srsi_email'] . '</a>&nbsp;</div>
                                </div>
                                <div id="invoice">
                                  <h1>' . $primaryVoucherNumber . '</h1>
                                  <div class="date">Dated: ' . $formattedDate . '</div>
                                  <div class="date">Generated: ' . $formattedTimeStamp . '</div>
                                </div>
                              </div>
                              <table border="0" cellspacing="0" cellpadding="0">
                                <thead>
                                    <tr>
                                        <th class="no" rowspan="2">#</th>
                                        <th class="desc" rowspan="2">PRODUCTS</th>
                                        <th class="qty" rowspan="2">QTY</th>
                                        <th class="unit" rowspan="2">RATE</th>
                                        <th class="disc" colspan="2">DISCOUNT</th>
                                        <th class="tax" colspan="2">TAX</th>
                                        <th class="total" rowspan="2">TOTAL</th>
                                    </tr>
                                    <tr>
                                        <th class="disc-per">%</th>
                                        <th class="disc-amt">AMOUNT</th>
                                        <th class="tax-per">%</th>
                                        <th class="tax-amt">AMOUNT</th>
                                    </tr>
                                </thead>
                                <tbody>';

            $detailHTML_80mm .= '<main>
                              <div id="details" class="clearfix">
                                <div id="invoice">
                                  <h1>' . $primaryVoucherNumber . '</h1>
                                  <div class="date">Dated: ' . $formattedDate . '</div>
                                  <div class="date">Generated: ' . $formattedTimeStamp . '</div>
                                </div>
                                <div id="client">
                                  <div class="to">INVOICE TO:</div>
                                  <h2 class="name">' . $primaryInvoiceData['srsi_party_name'] . '</h2>
                                  <div class="customer-name">' . $primaryInvoiceData['srsi_customer_name'] . '</div>
                                  <div class="phone">' . $primaryInvoiceData['srsi_phone_number'] . '</div>
                                  <div class="phone">' . $primaryInvoiceData['srsi_whatsapp'] . '</div>
                                  <div class="email"><a href="mailto:' . $primaryInvoiceData['srsi_email'] . '">' . $primaryInvoiceData['srsi_email'] . '</a></div>
                                </div>
                              </div>
                              <table border="0" cellspacing="0" cellpadding="0">
                            <thead>
                                <tr>
                                    <th class="qty">QTY</th>
                                    <th class="unit">RATE</th>
                                    <th class="disc">DIS</th>
                                    <th class="tax">TAX</th>
                                    <th class="total">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>';

            $counter = 0;
            $totalQuantity = 0;
            $totalPrimaryDiscount = 0;
            $totalPrimaryTax = 0;
            $totalPrimaryAmount = 0;
            $totalPrimarySubAmount = 0;

            $subTotalAmount = 0;
            $totalProductDiscount = $primaryInvoiceData['srsi_product_disc'];
            $totalServiceDiscount = 0;
            $totalRoundOffDiscount = $primaryInvoiceData['srsi_round_off_disc'];
            $totalCashDiscount = $primaryInvoiceData['srsi_cash_disc_amount'];
            $totalDiscount = $primaryInvoiceData['srsi_total_discount'];
            $totalInclusiveTax = $primaryInvoiceData['srsi_inclusive_sales_tax'];
            $totalExclusiveTax = $primaryInvoiceData['srsi_exclusive_sales_tax'];
            $totalTax = $primaryInvoiceData['srsi_total_sales_tax'];
            $grandTotal = $primaryInvoiceData['srsi_grand_total'];

            foreach ($primaryItemsData as $item) {

                $counter++;

                $totalQuantity = $totalQuantity + $item['srsii_qty'];
                $totalPrimaryDiscount = $totalPrimaryDiscount + $item['srsii_discount_amount'];
                $totalPrimaryTax = $totalPrimaryTax + $item['srsii_saletax_amount'];
                $totalPrimaryAmount = $totalPrimaryAmount + $item['srsii_amount'];

                $totalPrimarySubAmount = $totalPrimarySubAmount + ($item['srsii_qty'] * $item['srsii_rate']);

                $detailHTML .= '
                                <tr>
                                    <td class="no">' . str_pad($counter, 2, '0', STR_PAD_LEFT) . '</td>
                                    <td class="desc"><h3>' . $item['srsii_product_name'] . '</h3>' . $item['srsii_product_code'] . '</td>
                                    <td class="qty">' . $item['srsii_qty'] . '</td>
                                    <td class="unit">' . number_format($item['srsii_rate'], 2) . '</td>
                                    <td class="disc-per">' . number_format($item['srsii_discount_per'], 2) . '</td>
                                    <td class="disc-amt">' . number_format($item['srsii_discount_amount'], 2) . '</td>
                                    <td class="tax-per">' . number_format($item['srsii_saletax_per'], 2) . ($item['srsii_saletax_inclusive'] == 1 ? '(incl)' : '') . '</td>
                                    <td class="tax-amt">' . number_format($item['srsii_saletax_amount'], 2) . '</td>
                                    <td class="total">' . number_format($item['srsii_amount'], 2) . '</td>
                              </tr>
                                ';

                $detailHTML_80mm .= '<tr>
                                        <td class="desc" colspan="5">' . $item['srsii_product_code'] . '<h3>' . $item['srsii_product_name'] . '</h3></td>
                                    </tr>
                                    <tr>
                                        <td class="qty">' . $item['srsii_qty'] . '</td>
                                        <td class="unit">' . number_format($item['srsii_rate'], 2) . '</td>
                                        <td class="disc-amt">' . number_format($item['srsii_discount_amount'], 2) . '</td>
                                        <td class="tax-amt">' . number_format($item['srsii_saletax_amount'], 2) . ($item['srsii_saletax_inclusive'] == 1 ? '(i)' : '') . '</td>
                                        <td class="total">' . number_format($item['srsii_amount'], 2) . '</td>
                                  </tr>';
            }

            $subTotalAmount = $subTotalAmount + $totalPrimarySubAmount;

            $detailHTML .= '
                            <tr>
                                <th class="no">' . $counter . '</th>
                                <th class="desc">TOTAL</th>
                                <th class="qty">' . $totalQuantity . '</th>
                                <th class="unit"></th>
                                <th class="disc-per"></th>
                                <th class="disc-amt">' . number_format($totalPrimaryDiscount, 2) . '</th>
                                <th class="tax-per"></th>
                                <th class="tax-amt">' . number_format($totalPrimaryTax, 2) . '</th>
                                <th class="total">' . number_format($totalPrimaryAmount, 2) . '</th>
                          </tr>
                    </tbody>
                  </table>';


            $detailHTML_80mm .= '<tr>
                                        <th class="qty">' . $totalQuantity . '</th>
                                        <th class="unit"></th>
                                        <th class="disc-amt">' . number_format($totalPrimaryDiscount, 2) . '</th>
                                        <th class="tax-amt">' . number_format($totalPrimaryTax, 2) . '</th>
                                        <th class="total">' . number_format($totalPrimaryAmount, 2) . '</th>
                                  </tr>
                                  </tbody>
                                  </table>';

            $detailHTML .= '
                        <div class="total-section">
                        <div class="inst">
                            <h4>SPECIAL INSTRUCTIONS</h4>
                            <p>
                                ' . $specialInstructions . '
                            </p>
                        </div>
                        <div class="totals">
                        <table>
                        <tfoot>
                          <tr>
                            <td>SUBTOTAL</td>
                            <td></td>
                            <td>' . number_format($subTotalAmount, 2) . '</td>
                          </tr>
                          <tr>
                            <td>PRODUCT DISCOUNT</td>
                            <td>' . number_format($totalProductDiscount, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>ROUND OFF DISCOUNT</td>
                            <td>' . number_format($totalRoundOffDiscount, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>CASH DISCOUNT</td>
                            <td>' . number_format($totalCashDiscount, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>TOTAL DISCOUNT</td>
                            <td></td>
                            <td>' . number_format($totalDiscount, 2) . '</td>
                          </tr>
                          <tr>
                            <td>INCLUSIVE TAX</td>
                            <td>' . number_format($totalInclusiveTax, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>EXCLUSIVE TAX</td>
                            <td>' . number_format($totalExclusiveTax, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>TOTAL TAX</td>
                            <td></td>
                            <td>' . number_format($totalTax, 2) . '</td>
                          </tr>
                          <tr>
                            <td class="grand">GRAND TOTAL</td>
                            <td></td>
                            <td class="grand">' . number_format($grandTotal, 2) . '</td>
                          </tr>
                          <tr>
                            <td class="words" colspan="3">' . number_to_word($grandTotal) . '</td>
                          </tr>
                        </tfoot>
                        </table>
                        </div>
                        </div>
                        <div id="thanks">Thank you!</div>
                            </main>
                            <footer>
                              Invoice was system generated and is valid without the signature and seal.
                            </footer>
                          </body>
                        </html>
                        ';

            $detailHTML_80mm .= '<table>
                                <tfoot>
                                  <tr>
                                    <td>SUBTOTAL</td>
                                    <td></td>
                                    <td>' . number_format($subTotalAmount, 2) . '</td>
                                  </tr>
                                  <tr>
                                    <td>PRODUCT DISCOUNT</td>
                                    <td>' . number_format($totalProductDiscount, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>ROUND OFF DISCOUNT</td>
                                    <td>' . number_format($totalRoundOffDiscount, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>CASH DISCOUNT</td>
                                     <td>' . number_format($totalCashDiscount, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>TOTAL DISCOUNT</td>
                                    <td></td>
                                    <td>' . number_format($totalDiscount, 2) . '</td>
                                  </tr>
                                  <tr>
                                    <td>INCLUSIVE TAX</td>
                                    <td>' . number_format($totalInclusiveTax, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>EXCLUSIVE TAX</td>
                                    <td>' . number_format($totalExclusiveTax, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>TOTAL TAX</td>
                                    <td></td>
                                    <td>' . number_format($totalTax, 2) . '</td>
                                  </tr>
                                  <tr>
                                    <td class="grand">GRAND TOTAL</td>
                                    <td class="grand" colspan="2">' . number_format($grandTotal, 2) . '</td>
                                  </tr>
                                  <tr>
                                    <td class="words" colspan="3">' . number_to_word($grandTotal) . '</td>
                                  </tr>
                                </tfoot>
                                </table>
                                <h4 class="center">SPECIAL INSTRUCTIONS</h4>
                                <p class="center">
                                    ' . $specialInstructions . '
                                </p>
                                <div id="thanks" class="center">Thank you!</div>
                                    </main>
                                    <footer>
                                      Invoice was system generated and is valid without the signature and seal.
                                    </footer>
                                  </body>
                                </html>';

        } else {
            dieWithError("Invoice not found!", $database);
        }
        break;
    case $SERVICE:
        // todo service invoice
        $invoiceTitle = "SERVICE INVOICE";
        $invoiceQuery = "SELECT * FROM financials_service_invoice WHERE sei_id = $invoiceNumber LIMIT 1;";
        $invoiceResult = $database->query($invoiceQuery);
        if ($invoiceResult && $database->num_rows($invoiceResult) == 1) {
            $primaryInvoiceData = $database->fetch_assoc($invoiceResult);
            $primaryInvoiceId = $primaryInvoiceData['sei_id'];
            $secondaryId = $primaryInvoiceData['sei_sale_invoice_id'];
            $primaryVoucherNumber = SERVICE_VOUCHER_CODE . $primaryInvoiceId;
            $itemsQuery = "SELECT * FROM  financials_service_invoice_items WHERE seii_invoice_id = $primaryInvoiceId;";
            $itemsResult = $database->query($itemsQuery);
            if ($itemsResult && $database->num_rows($itemsResult) > 0) {
                while ($item = $database->fetch_assoc($itemsResult)) {
                    $primaryItemsData[] = $item;
                }
            }

            if ($secondaryId != 0) {
                $invoiceQuery = "SELECT * FROM financials_sale_invoice WHERE si_id = $secondaryId LIMIT 1;";
                $invoiceResult = $database->query($invoiceQuery);
                if ($invoiceResult && $database->num_rows($invoiceResult) == 1) {
                    $secondaryInvoiceData = $database->fetch_assoc($invoiceResult);
                    $secondaryInvoiceId = $secondaryInvoiceData['si_id'];
                    $secondaryVoucherNumber = SALE_VOUCHER_CODE . $secondaryInvoiceId;
                    $itemsQuery = "SELECT * FROM financials_sale_invoice_items WHERE sii_invoice_id = $secondaryInvoiceId;";
                    $itemsResult = $database->query($itemsQuery);
                    if ($itemsResult && $database->num_rows($itemsResult) > 0) {
                        while ($item = $database->fetch_assoc($itemsResult)) {
                            $secondaryItemsData[] = $item;
                        }
                    }
                }
            }

            try {
                $formattedDate = new DateTime($primaryInvoiceData['sei_day_end_date']);
                $formattedDate = $formattedDate->format(USER_DATE_FORMAT);

                $formattedTimeStamp = new DateTime($primaryInvoiceData['sei_datetime']);
                $formattedTimeStamp = $formattedTimeStamp->format(USER_DATE_TIME_FORMAT);
            } catch (Exception $e) {}

            $linkPageUrl = $subDomain . '/public/_api/view/invoice.php?type=' . $SALE . '&number=' . $secondaryInvoiceId . '&format=' . $invoiceFormat;
            $secondaryInvoiceLink = $secondaryVoucherNumber == "" ? "" : '<h4 style="margin: 0; padding: 0"><a href="' . $linkPageUrl . '" target="_blank">' . $secondaryVoucherNumber . '</a></h4>';


            $detailHTML .= '<main>
                              <div id="details" class="clearfix">
                                <div id="client">
                                  <div class="to">INVOICE TO:</div>
                                  <h2 class="name">' . $primaryInvoiceData['sei_party_name'] . '</h2>
                                  <div class="customer-name">' . $primaryInvoiceData['sei_customer_name'] . '&nbsp;</div>
                                  <div class="phone">' . $primaryInvoiceData['sei_phone_number'] . '&nbsp;</div>
                                  <div class="phone">' . $primaryInvoiceData['sei_whatsapp'] . '&nbsp;</div>
                                  <div class="email"><a href="mailto:' . $primaryInvoiceData['sei_email'] . '">' . $primaryInvoiceData['sei_email'] . '</a>&nbsp;</div>
                                </div>
                                <div id="invoice">
                                  <h1>' . $primaryVoucherNumber . '</h1>' . $secondaryInvoiceLink . '
                                  <div class="date">Dated: ' . $formattedDate . '</div>
                                  <div class="date">Generated: ' . $formattedTimeStamp . '</div>
                                </div>
                              </div>
                              <table border="0" cellspacing="0" cellpadding="0">
                                <thead>
                                    <tr>
                                        <th class="no" rowspan="2">#</th>
                                        <th class="desc" rowspan="2">SERVICES</th>
                                        <th class="qty" rowspan="2">QTY</th>
                                        <th class="unit" rowspan="2">RATE</th>
                                        <th class="disc" colspan="2">DISCOUNT</th>
                                        <th class="tax" colspan="2">TAX</th>
                                        <th class="total" rowspan="2">TOTAL</th>
                                    </tr>
                                    <tr>
                                        <th class="disc-per">%</th>
                                        <th class="disc-amt">AMOUNT</th>
                                        <th class="tax-per">%</th>
                                        <th class="tax-amt">AMOUNT</th>
                                    </tr>
                                </thead>
                                <tbody>';

            $detailHTML_80mm .= '<main>
                              <div id="details" class="clearfix">
                                <div id="invoice">
                                  <h1>' . $primaryVoucherNumber . '</h1>' . $secondaryInvoiceLink . '
                                  <div class="date">Dated: ' . $formattedDate . '</div>
                                  <div class="date">Generated: ' . $formattedTimeStamp . '</div>
                                </div>
                                <div id="client">
                                  <div class="to">INVOICE TO:</div>
                                  <h2 class="name">' . $primaryInvoiceData['sei_party_name'] . '</h2>
                                  <div class="customer-name">' . $primaryInvoiceData['sei_customer_name'] . '</div>
                                  <div class="phone">' . $primaryInvoiceData['sei_phone_number'] . '</div>
                                  <div class="phone">' . $primaryInvoiceData['sei_whatsapp'] . '</div>
                                  <div class="email"><a href="mailto:' . $primaryInvoiceData['sei_email'] . '">' . $primaryInvoiceData['sei_email'] . '</a></div>
                                </div>
                              </div>
                              <table border="0" cellspacing="0" cellpadding="0">
                            <thead>
                                <tr>
                                    <th class="qty">QTY</th>
                                    <th class="unit">RATE</th>
                                    <th class="disc">DIS</th>
                                    <th class="tax">TAX</th>
                                    <th class="total">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>';

            $counter = 0;
            $totalQuantity = 0;
            $totalPrimaryDiscount = 0;
            $totalPrimaryTax = 0;
            $totalPrimaryAmount = 0;
            $totalPrimarySubAmount = 0;

            $subTotalAmount = 0;
            $totalProductDiscount = 0;
            $totalServiceDiscount = $primaryInvoiceData['sei_product_disc'];
            $totalRoundOffDiscount = $primaryInvoiceData['sei_round_off_disc'];
            $totalCashDiscount = $primaryInvoiceData['sei_cash_disc_amount'];
            $totalDiscount = $primaryInvoiceData['sei_total_discount'];
            $totalInclusiveTax = $primaryInvoiceData['sei_inclusive_sales_tax'];
            $totalExclusiveTax = $primaryInvoiceData['sei_exclusive_sales_tax'];
            $totalTax = $primaryInvoiceData['sei_total_sales_tax'];
            $grandTotal = $primaryInvoiceData['sei_grand_total'];

            foreach ($primaryItemsData as $item) {

                $counter++;

                $totalQuantity = $totalQuantity + $item['seii_qty'];
                $totalPrimaryDiscount = $totalPrimaryDiscount + $item['seii_discount_amount'];
                $totalPrimaryTax = $totalPrimaryTax + $item['seii_saletax_amount'];
                $totalPrimaryAmount = $totalPrimaryAmount + $item['seii_amount'];

                $totalPrimarySubAmount = $totalPrimarySubAmount + ($item['seii_qty'] * $item['seii_rate']);

                $detailHTML .= '
                                <tr>
                                    <td class="no">' . str_pad($counter, 2, '0', STR_PAD_LEFT) . '</td>
                                    <td class="desc"><h3>' . $item['seii_service_name'] . '</h3></td>
                                    <td class="qty">' . $item['seii_qty'] . '</td>
                                    <td class="unit">' . number_format($item['seii_rate'], 2) . '</td>
                                    <td class="disc-per">' . number_format($item['seii_discount_per'], 2) . '</td>
                                    <td class="disc-amt">' . number_format($item['seii_discount_amount'], 2) . '</td>
                                    <td class="tax-per">' . number_format($item['seii_saletax_per'], 2) . ($item['seii_saletax_inclusive'] == 1 ? '(incl)' : '') . '</td>
                                    <td class="tax-amt">' . number_format($item['seii_saletax_amount'], 2) . '</td>
                                    <td class="total">' . number_format($item['seii_amount'], 2) . '</td>
                              </tr>
                                ';

                $detailHTML_80mm .= '<tr>
                                        <td class="desc" colspan="5"><h3>' . $item['seii_service_name'] . '</h3></td>
                                    </tr>
                                    <tr>
                                        <td class="qty">' . $item['seii_qty'] . '</td>
                                        <td class="unit">' . number_format($item['seii_rate'], 2) . '</td>
                                        <td class="disc-amt">' . number_format($item['seii_discount_amount'], 2) . '</td>
                                        <td class="tax-amt">' . number_format($item['seii_saletax_amount'], 2) . ($item['seii_saletax_inclusive'] == 1 ? '(i)' : '') . '</td>
                                        <td class="total">' . number_format($item['seii_amount'], 2) . '</td>
                                  </tr>';
            }

            $subTotalAmount = $subTotalAmount + $totalPrimarySubAmount;

            $detailHTML .= '
                            <tr>
                                <th class="no">' . $counter . '</th>
                                <th class="desc">TOTAL</th>
                                <th class="qty">' . $totalQuantity . '</th>
                                <th class="unit"></th>
                                <th class="disc-per"></th>
                                <th class="disc-amt">' . number_format($totalPrimaryDiscount, 2) . '</th>
                                <th class="tax-per"></th>
                                <th class="tax-amt">' . number_format($totalPrimaryTax, 2) . '</th>
                                <th class="total">' . number_format($totalPrimaryAmount, 2) . '</th>
                          </tr>
                    </tbody>
                  </table>';

            $detailHTML_80mm .= '<tr>
                                        <th class="qty">' . $totalQuantity . '</th>
                                        <th class="unit"></th>
                                        <th class="disc-amt">' . number_format($totalPrimaryDiscount, 2) . '</th>
                                        <th class="tax-amt">' . number_format($totalPrimaryTax, 2) . '</th>
                                        <th class="total">' . number_format($totalPrimaryAmount, 2) . '</th>
                                  </tr>
                                  </tbody>
                                  </table>';


            if (count($secondaryItemsData) > 0) {

                $detailHTML .= '
                          <table border="0" cellspacing="0" cellpadding="0">
                            <thead>
                                <tr>
                                    <th class="no" rowspan="2">#</th>
                                    <th class="desc" rowspan="2">PRODUCTS</th>
                                    <th class="qty" rowspan="2">QTY</th>
                                    <th class="unit" rowspan="2">RATE</th>
                                    <th class="disc" colspan="2">DISCOUNT</th>
                                    <th class="tax" colspan="2">TAX</th>
                                    <th class="total" rowspan="2">TOTAL</th>
                                </tr>
                                <tr>
                                    <th class="disc-per">%</th>
                                    <th class="disc-amt">AMOUNT</th>
                                    <th class="tax-per">%</th>
                                    <th class="tax-amt">AMOUNT</th>
                                </tr>
                            </thead>
                            <tbody>';

                $detailHTML_80mm .= '</tbody>
                                      </table>
                                </table>
                                      <table border="0" cellspacing="0" cellpadding="0">
                                        <thead>
                                            <tr>
                                                <th class="qty">QTY</th>
                                                <th class="unit">RATE</th>
                                                <th class="disc">DIS</th>
                                                <th class="tax">TAX</th>
                                                <th class="total">TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>';

                $secondaryCounter = 0;
                $totalSecondaryQuantity = 0;
                $totalSecondaryDiscount = 0;
                $totalSecondaryTax = 0;
                $totalSecondaryAmount = 0;
                $totalSecondarySubAmount = 0;

                $totalProductDiscount += $secondaryInvoiceData['si_product_disc'];
                $totalServiceDiscount += 0;
                $totalRoundOffDiscount += $secondaryInvoiceData['si_round_off_disc'];
                $totalCashDiscount += $secondaryInvoiceData['si_cash_disc_amount'];
                $totalDiscount += $secondaryInvoiceData['si_total_discount'];
                $totalInclusiveTax += $secondaryInvoiceData['si_inclusive_sales_tax'];
                $totalExclusiveTax += $secondaryInvoiceData['si_exclusive_sales_tax'];
                $totalTax += $secondaryInvoiceData['si_total_sales_tax'];
                $grandTotal += $secondaryInvoiceData['si_grand_total'];

                foreach ($secondaryItemsData as $item) {

                    $secondaryCounter++;

                    $totalSecondaryQuantity = $totalSecondaryQuantity + $item['sii_qty'];
                    $totalSecondaryDiscount = $totalSecondaryDiscount + $item['sii_discount_amount'];
                    $totalSecondaryTax = $totalSecondaryTax + $item['sii_saletax_amount'];
                    $totalSecondaryAmount = $totalSecondaryAmount + $item['sii_amount'];

                    $totalSecondarySubAmount = $totalSecondarySubAmount + ($item['sii_qty'] * $item['sii_rate']);

                    $detailHTML .= '
                                <tr>
                                    <td class="no">' . str_pad($secondaryCounter, 2, '0', STR_PAD_LEFT) . '</td>
                                    <td class="desc"><h3>' . $item['sii_product_name'] . '</h3>' . $item['sii_product_code'] . '</td>
                                    <td class="qty">' . $item['sii_qty'] . '</td>
                                    <td class="unit">' . number_format($item['sii_rate'], 2) . '</td>
                                    <td class="disc-per">' . number_format($item['sii_discount_per'], 2) . '</td>
                                    <td class="disc-amt">' . number_format($item['sii_discount_amount'], 2) . '</td>
                                    <td class="tax-per">' . number_format($item['sii_saletax_per'], 2) . ($item['sii_saletax_inclusive'] == 1 ? '(incl)' : '') . '</td>
                                    <td class="tax-amt">' . number_format($item['sii_saletax_amount'], 2) . '</td>
                                    <td class="total">' . number_format($item['sii_amount'], 2) . '</td>
                              </tr>
                                ';

                    $detailHTML_80mm .= '<tr>
                                                <td class="desc" colspan="5">' . $item['sii_product_code'] . '<h3>' . $item['sii_product_name'] . '</h3></td>
                                          </tr>
                                        <tr>
                                            <td class="qty">' . $item['sii_qty'] . '</td>
                                            <td class="unit">' . number_format($item['sii_rate'], 2) . '</td>
                                            <td class="disc-amt">' . number_format($item['sii_discount_amount'], 2) . '</td>
                                            <td class="tax-amt">' . number_format($item['sii_saletax_amount'], 2) . ($item['sii_saletax_inclusive'] == 1 ? '(i)' : '') . '</td>
                                            <td class="total">' . number_format($item['sii_amount'], 2) . '</td>
                                      </tr>';
                }

                $subTotalAmount = $subTotalAmount + $totalSecondarySubAmount;

                $detailHTML .= '
                            <tr>
                                <th class="no">' . $secondaryCounter . '</th>
                                <th class="desc">TOTAL</th>
                                <th class="qty">' . $totalSecondaryQuantity . '</th>
                                <th class="unit"></th>
                                <th class="disc-per"></th>
                                <th class="disc-amt">' . number_format($totalSecondaryDiscount, 2) . '</th>
                                <th class="tax-per"></th>
                                <th class="tax-amt">' . number_format($totalSecondaryTax, 2) . '</th>
                                <th class="total">' . number_format($totalSecondaryAmount, 2) . '</th>
                          </tr>
                            </tbody>
                          </table>';

                $detailHTML_80mm .= '<tr>
                                            <th class="qty">' . $totalSecondaryQuantity . '</th>
                                            <th class="unit"></th>
                                            <th class="disc-amt">' . number_format($totalSecondaryDiscount, 2) . '</th>
                                            <th class="tax-amt">' . number_format($totalSecondaryTax, 2) . '</th>
                                            <th class="total">' . number_format($totalSecondaryAmount, 2) . '</th>
                                      </tr>
                                        </tbody>
                                      </table>';

            }

            $detailHTML .= '
                        <div class="total-section">
                        <div class="inst">
                            <h4>SPECIAL INSTRUCTIONS</h4>
                            <p>
                                ' . $specialInstructions . '
                            </p>
                        </div>
                        <div class="totals">
                        <table>
                        <tfoot>
                          <tr>
                            <td>SUBTOTAL</td>
                            <td></td>
                            <td>' . number_format($subTotalAmount, 2) . '</td>
                          </tr>
                          <tr>
                            <td>PRODUCT DISCOUNT</td>
                            <td>' . number_format($totalProductDiscount, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>SERVICE DISCOUNT</td>
                            <td>' . number_format($totalServiceDiscount, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>ROUND OFF DISCOUNT</td>
                            <td>' . number_format($totalRoundOffDiscount, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>CASH DISCOUNT</td>
                            <td>' . number_format($totalCashDiscount, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>TOTAL DISCOUNT</td>
                            <td></td>
                            <td>' . number_format($totalDiscount, 2) . '</td>
                          </tr>
                          <tr>
                            <td>INCLUSIVE TAX</td>
                            <td>' . number_format($totalInclusiveTax, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>EXCLUSIVE TAX</td>
                            <td>' . number_format($totalExclusiveTax, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>TOTAL TAX</td>
                            <td></td>
                            <td>' . number_format($totalTax, 2) . '</td>
                          </tr>
                          <tr>
                            <td class="grand">GRAND TOTAL</td>
                            <td></td>
                            <td class="grand">' . number_format($grandTotal, 2) . '</td>
                          </tr>
                          <tr>
                            <td class="words" colspan="3">' . number_to_word($grandTotal) . '</td>
                          </tr>
                        </tfoot>
                        </table>
                        </div>
                        </div>
                        <div id="thanks">Thank you!</div>
                            </main>
                            <footer>
                              Invoice was system generated and is valid without the signature and seal.
                            </footer>
                          </body>
                        </html>
                        ';

            $detailHTML_80mm .= '<table>
                                <tfoot>
                                  <tr>
                                    <td>SUBTOTAL</td>
                                    <td></td>
                                    <td>' . number_format($subTotalAmount, 2) . '</td>
                                  </tr>
                                  <tr>
                                    <td>PRODUCT DISCOUNT</td>
                                    <td>' . number_format($totalProductDiscount, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>SERVICE DISCOUNT</td>
                                    <td>' . number_format($totalServiceDiscount, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>ROUND OFF DISCOUNT</td>
                                    <td>' . number_format($totalRoundOffDiscount, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>CASH DISCOUNT</td>
                                     <td>' . number_format($totalCashDiscount, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>TOTAL DISCOUNT</td>
                                    <td></td>
                                    <td>' . number_format($totalDiscount, 2) . '</td>
                                  </tr>
                                  <tr>
                                    <td>INCLUSIVE TAX</td>
                                    <td>' . number_format($totalInclusiveTax, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>EXCLUSIVE TAX</td>
                                    <td>' . number_format($totalExclusiveTax, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>TOTAL TAX</td>
                                    <td></td>
                                    <td>' . number_format($totalTax, 2) . '</td>
                                  </tr>
                                  <tr>
                                    <td class="grand">GRAND TOTAL</td>
                                    <td class="grand" colspan="2">' . number_format($grandTotal, 2) . '</td>
                                  </tr>
                                  <tr>
                                    <td class="words" colspan="3">' . number_to_word($grandTotal) . '</td>
                                  </tr>
                                </tfoot>
                                </table>
                                <h4 class="center">SPECIAL INSTRUCTIONS</h4>
                                <p class="center">
                                    ' . $specialInstructions . '
                                </p>
                                <div id="thanks" class="center">Thank you!</div>
                                    </main>
                                    <footer>
                                      Invoice was system generated and is valid without the signature and seal.
                                    </footer>
                                  </body>
                                </html>';

        } else {
            dieWithError("Invoice not found!", $database);
        }
        break;
    case $SERVICE_TAX:
        // todo service tax invoice
        $invoiceTitle = "SERVICE TAX INVOICE";
        $invoiceQuery = "SELECT * FROM financials_service_saletax_invoice WHERE sesi_id = $invoiceNumber LIMIT 1;";
        $invoiceResult = $database->query($invoiceQuery);
        if ($invoiceResult && $database->num_rows($invoiceResult) == 1) {
            $primaryInvoiceData = $database->fetch_assoc($invoiceResult);
            $primaryInvoiceId = $primaryInvoiceData['sesi_id'];
            $secondaryId = $primaryInvoiceData['sesi_sale_invoice_id'];
            $primaryVoucherNumber = SERVICE_TAX_VOUCHER_CODE . $primaryInvoiceId;
            $itemsQuery = "SELECT * FROM  financials_service_saletax_invoice_items WHERE sesii_invoice_id = $primaryInvoiceId;";
            $itemsResult = $database->query($itemsQuery);
            if ($itemsResult && $database->num_rows($itemsResult) > 0) {
                while ($item = $database->fetch_assoc($itemsResult)) {
                    $primaryItemsData[] = $item;
                }
            }

            if ($secondaryId != 0) {
                $invoiceQuery = "SELECT * FROM financials_sale_saletax_invoice WHERE ssi_id = $secondaryId LIMIT 1;";
                $invoiceResult = $database->query($invoiceQuery);
                if ($invoiceResult && $database->num_rows($invoiceResult) == 1) {
                    $secondaryInvoiceData = $database->fetch_assoc($invoiceResult);
                    $secondaryInvoiceId = $secondaryInvoiceData['ssi_id'];
                    $secondaryVoucherNumber = SALE_TEX_SALE_VOUCHER_CODE . $secondaryInvoiceId;
                    $itemsQuery = "SELECT * FROM financials_sale_saletax_invoice_items WHERE ssii_invoice_id = $secondaryInvoiceId;";
                    $itemsResult = $database->query($itemsQuery);
                    if ($itemsResult && $database->num_rows($itemsResult) > 0) {
                        while ($item = $database->fetch_assoc($itemsResult)) {
                            $secondaryItemsData[] = $item;
                        }
                    }
                }
            }

            try {
                $formattedDate = new DateTime($primaryInvoiceData['sesi_day_end_date']);
                $formattedDate = $formattedDate->format(USER_DATE_FORMAT);

                $formattedTimeStamp = new DateTime($primaryInvoiceData['sesi_datetime']);
                $formattedTimeStamp = $formattedTimeStamp->format(USER_DATE_TIME_FORMAT);
            } catch (Exception $e) {}

            $linkPageUrl = $subDomain . '/public/_api/view/invoice.php?type=' . $SALE_TAX . '&number=' . $secondaryInvoiceId . '&format=' . $invoiceFormat;
            $secondaryInvoiceLink = $secondaryVoucherNumber == "" ? "" : '<h4 style="margin: 0; padding: 0"><a href="' . $linkPageUrl . '" target="_blank">' . $secondaryVoucherNumber . '</a></h4>';


            $detailHTML .= '<main>
                              <div id="details" class="clearfix">
                                <div id="client">
                                  <div class="to">INVOICE TO:</div>
                                  <h2 class="name">' . $primaryInvoiceData['sesi_party_name'] . '</h2>
                                  <div class="customer-name">' . $primaryInvoiceData['sesi_customer_name'] . '&nbsp;</div>
                                  <div class="phone">' . $primaryInvoiceData['sesi_phone_number'] . '&nbsp;</div>
                                  <div class="phone">' . $primaryInvoiceData['sesi_whatsapp'] . '&nbsp;</div>
                                  <div class="email"><a href="mailto:' . $primaryInvoiceData['sesi_email'] . '">' . $primaryInvoiceData['sesi_email'] . '</a>&nbsp;</div>
                                </div>
                                <div id="invoice">
                                  <h1>' . $primaryVoucherNumber . '</h1>' . $secondaryInvoiceLink . '
                                  <div class="date">Dated: ' . $formattedDate . '</div>
                                  <div class="date">Generated: ' . $formattedTimeStamp . '</div>
                                </div>
                              </div>
                              <table border="0" cellspacing="0" cellpadding="0">
                                <thead>
                                    <tr>
                                        <th class="no" rowspan="2">#</th>
                                        <th class="desc" rowspan="2">SERVICES</th>
                                        <th class="qty" rowspan="2">QTY</th>
                                        <th class="unit" rowspan="2">RATE</th>
                                        <th class="disc" colspan="2">DISCOUNT</th>
                                        <th class="tax" colspan="2">TAX</th>
                                        <th class="total" rowspan="2">TOTAL</th>
                                    </tr>
                                    <tr>
                                        <th class="disc-per">%</th>
                                        <th class="disc-amt">AMOUNT</th>
                                        <th class="tax-per">%</th>
                                        <th class="tax-amt">AMOUNT</th>
                                    </tr>
                                </thead>
                                <tbody>';

            $detailHTML_80mm .= '<main>
                              <div id="details" class="clearfix">
                                <div id="invoice">
                                  <h1>' . $primaryVoucherNumber . '</h1>' . $secondaryInvoiceLink . '
                                  <div class="date">Dated: ' . $formattedDate . '</div>
                                  <div class="date">Generated: ' . $formattedTimeStamp . '</div>
                                </div>
                                <div id="client">
                                  <div class="to">INVOICE TO:</div>
                                  <h2 class="name">' . $primaryInvoiceData['sesi_party_name'] . '</h2>
                                  <div class="customer-name">' . $primaryInvoiceData['sesi_customer_name'] . '</div>
                                  <div class="phone">' . $primaryInvoiceData['sesi_phone_number'] . '</div>
                                  <div class="phone">' . $primaryInvoiceData['sesi_whatsapp'] . '</div>
                                  <div class="email"><a href="mailto:' . $primaryInvoiceData['sesi_email'] . '">' . $primaryInvoiceData['sesi_email'] . '</a></div>
                                </div>
                              </div>
                              <table border="0" cellspacing="0" cellpadding="0">
                            <thead>
                                <tr>
                                    <th class="qty">QTY</th>
                                    <th class="unit">RATE</th>
                                    <th class="disc">DIS</th>
                                    <th class="tax">TAX</th>
                                    <th class="total">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>';

            $counter = 0;
            $totalQuantity = 0;
            $totalPrimaryDiscount = 0;
            $totalPrimaryTax = 0;
            $totalPrimaryAmount = 0;
            $totalPrimarySubAmount = 0;

            $subTotalAmount = 0;
            $totalProductDiscount = 0;
            $totalServiceDiscount = $primaryInvoiceData['sesi_product_disc'];
            $totalRoundOffDiscount = $primaryInvoiceData['sesi_round_off_disc'];
            $totalCashDiscount = $primaryInvoiceData['sesi_cash_disc_amount'];
            $totalDiscount = $primaryInvoiceData['sesi_total_discount'];
            $totalInclusiveTax = $primaryInvoiceData['sesi_inclusive_sales_tax'];
            $totalExclusiveTax = $primaryInvoiceData['sesi_exclusive_sales_tax'];
            $totalTax = $primaryInvoiceData['sesi_total_sales_tax'];
            $grandTotal = $primaryInvoiceData['sesi_grand_total'];

            foreach ($primaryItemsData as $item) {

                $counter++;

                $totalQuantity = $totalQuantity + $item['sesii_qty'];
                $totalPrimaryDiscount = $totalPrimaryDiscount + $item['sesii_discount_amount'];
                $totalPrimaryTax = $totalPrimaryTax + $item['sesii_saletax_amount'];
                $totalPrimaryAmount = $totalPrimaryAmount + $item['sesii_amount'];

                $totalPrimarySubAmount = $totalPrimarySubAmount + ($item['sesii_qty'] * $item['sesii_rate']);

                $detailHTML .= '
                                <tr>
                                    <td class="no">' . str_pad($counter, 2, '0', STR_PAD_LEFT) . '</td>
                                    <td class="desc"><h3>' . $item['sesii_service_name'] . '</h3></td>
                                    <td class="qty">' . $item['sesii_qty'] . '</td>
                                    <td class="unit">' . number_format($item['sesii_rate'], 2) . '</td>
                                    <td class="disc-per">' . number_format($item['sesii_discount_per'], 2) . '</td>
                                    <td class="disc-amt">' . number_format($item['sesii_discount_amount'], 2) . '</td>
                                    <td class="tax-per">' . number_format($item['sesii_saletax_per'], 2) . ($item['sesii_saletax_inclusive'] == 1 ? '(incl)' : '') . '</td>
                                    <td class="tax-amt">' . number_format($item['sesii_saletax_amount'], 2) . '</td>
                                    <td class="total">' . number_format($item['sesii_amount'], 2) . '</td>
                              </tr>
                                ';

                $detailHTML_80mm .= '<tr>
                                        <td class="desc" colspan="5"><h3>' . $item['sesii_service_name'] . '</h3></td>
                                    </tr>
                                    <tr>
                                        <td class="qty">' . $item['sesii_qty'] . '</td>
                                        <td class="unit">' . number_format($item['sesii_rate'], 2) . '</td>
                                        <td class="disc-amt">' . number_format($item['sesii_discount_amount'], 2) . '</td>
                                        <td class="tax-amt">' . number_format($item['sesii_saletax_amount'], 2) . ($item['sesii_saletax_inclusive'] == 1 ? '(i)' : '') . '</td>
                                        <td class="total">' . number_format($item['sesii_amount'], 2) . '</td>
                                  </tr>';
            }

            $subTotalAmount = $subTotalAmount + $totalPrimarySubAmount;

            $detailHTML .= '
                            <tr>
                                <th class="no">' . $counter . '</th>
                                <th class="desc">TOTAL</th>
                                <th class="qty">' . $totalQuantity . '</th>
                                <th class="unit"></th>
                                <th class="disc-per"></th>
                                <th class="disc-amt">' . number_format($totalPrimaryDiscount, 2) . '</th>
                                <th class="tax-per"></th>
                                <th class="tax-amt">' . number_format($totalPrimaryTax, 2) . '</th>
                                <th class="total">' . number_format($totalPrimaryAmount, 2) . '</th>
                          </tr>
                    </tbody>
                  </table>';

            $detailHTML_80mm .= '<tr>
                                        <th class="qty">' . $totalQuantity . '</th>
                                        <th class="unit"></th>
                                        <th class="disc-amt">' . number_format($totalPrimaryDiscount, 2) . '</th>
                                        <th class="tax-amt">' . number_format($totalPrimaryTax, 2) . '</th>
                                        <th class="total">' . number_format($totalPrimaryAmount, 2) . '</th>
                                  </tr>
                                  </tbody>
                                  </table>';

            if (count($secondaryItemsData) > 0) {

                $detailHTML .= '
                          <table border="0" cellspacing="0" cellpadding="0">
                            <thead>
                                <tr>
                                    <th class="no" rowspan="2">#</th>
                                    <th class="desc" rowspan="2">PRODUCTS</th>
                                    <th class="qty" rowspan="2">QTY</th>
                                    <th class="unit" rowspan="2">RATE</th>
                                    <th class="disc" colspan="2">DISCOUNT</th>
                                    <th class="tax" colspan="2">TAX</th>
                                    <th class="total" rowspan="2">TOTAL</th>
                                </tr>
                                <tr>
                                    <th class="disc-per">%</th>
                                    <th class="disc-amt">AMOUNT</th>
                                    <th class="tax-per">%</th>
                                    <th class="tax-amt">AMOUNT</th>
                                </tr>
                            </thead>
                            <tbody>';

                $detailHTML_80mm .= '</tbody>
                                      </table>
                                </table>
                                      <table border="0" cellspacing="0" cellpadding="0">
                                        <thead>
                                            <tr>
                                                <th class="qty">QTY</th>
                                                <th class="unit">RATE</th>
                                                <th class="disc">DIS</th>
                                                <th class="tax">TAX</th>
                                                <th class="total">TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>';

                $secondaryCounter = 0;
                $totalSecondaryQuantity = 0;
                $totalSecondaryDiscount = 0;
                $totalSecondaryTax = 0;
                $totalSecondaryAmount = 0;
                $totalSecondarySubAmount = 0;

                $totalProductDiscount += $secondaryInvoiceData['ssi_product_disc'];
                $totalServiceDiscount += 0;
                $totalRoundOffDiscount += $secondaryInvoiceData['ssi_round_off_disc'];
                $totalCashDiscount += $secondaryInvoiceData['ssi_cash_disc_amount'];
                $totalDiscount += $secondaryInvoiceData['ssi_total_discount'];
                $totalInclusiveTax += $secondaryInvoiceData['ssi_inclusive_sales_tax'];
                $totalExclusiveTax += $secondaryInvoiceData['ssi_exclusive_sales_tax'];
                $totalTax += $secondaryInvoiceData['ssi_total_sales_tax'];
                $grandTotal += $secondaryInvoiceData['ssi_grand_total'];

                foreach ($secondaryItemsData as $item) {

                    $secondaryCounter++;

                    $totalSecondaryQuantity = $totalSecondaryQuantity + $item['ssii_qty'];
                    $totalSecondaryDiscount = $totalSecondaryDiscount + $item['ssii_discount_amount'];
                    $totalSecondaryTax = $totalSecondaryTax + $item['ssii_saletax_amount'];
                    $totalSecondaryAmount = $totalSecondaryAmount + $item['ssii_amount'];

                    $totalSecondarySubAmount = $totalSecondarySubAmount + ($item['ssii_qty'] * $item['ssii_rate']);

                    $detailHTML .= '
                                <tr>
                                    <td class="no">' . str_pad($secondaryCounter, 2, '0', STR_PAD_LEFT) . '</td>
                                    <td class="desc"><h3>' . $item['ssii_product_name'] . '</h3>' . $item['ssii_product_code'] . '</td>
                                    <td class="qty">' . $item['ssii_qty'] . '</td>
                                    <td class="unit">' . number_format($item['ssii_rate'], 2) . '</td>
                                    <td class="disc-per">' . number_format($item['ssii_discount_per'], 2) . '</td>
                                    <td class="disc-amt">' . number_format($item['ssii_discount_amount'], 2) . '</td>
                                    <td class="tax-per">' . number_format($item['ssii_saletax_per'], 2) . ($item['ssii_saletax_inclusive'] == 1 ? '(incl)' : '') . '</td>
                                    <td class="tax-amt">' . number_format($item['ssii_saletax_amount'], 2) . '</td>
                                    <td class="total">' . number_format($item['ssii_amount'], 2) . '</td>
                              </tr>
                                ';

                    $detailHTML_80mm .= '<tr>
                                                <td class="desc" colspan="5">' . $item['ssii_product_code'] . '<h3>' . $item['ssii_product_name'] . '</h3></td>
                                          </tr>
                                        <tr>
                                            <td class="qty">' . $item['ssii_qty'] . '</td>
                                            <td class="unit">' . number_format($item['ssii_rate'], 2) . '</td>
                                            <td class="disc-amt">' . number_format($item['ssii_discount_amount'], 2) . '</td>
                                            <td class="tax-amt">' . number_format($item['ssii_saletax_amount'], 2) . ($item['ssii_saletax_inclusive'] == 1 ? '(i)' : '') . '</td>
                                            <td class="total">' . number_format($item['ssii_amount'], 2) . '</td>
                                      </tr>';
                }

                $subTotalAmount = $subTotalAmount + $totalSecondarySubAmount;

                $detailHTML .= '
                            <tr>
                                <th class="no">' . $secondaryCounter . '</th>
                                <th class="desc">TOTAL</th>
                                <th class="qty">' . $totalSecondaryQuantity . '</th>
                                <th class="unit"></th>
                                <th class="disc-per"></th>
                                <th class="disc-amt">' . number_format($totalSecondaryDiscount, 2) . '</th>
                                <th class="tax-per"></th>
                                <th class="tax-amt">' . number_format($totalSecondaryTax, 2) . '</th>
                                <th class="total">' . number_format($totalSecondaryAmount, 2) . '</th>
                          </tr>
                            </tbody>
                          </table>';

                $detailHTML_80mm .= '<tr>
                                            <th class="qty">' . $totalSecondaryQuantity . '</th>
                                            <th class="unit"></th>
                                            <th class="disc-amt">' . number_format($totalSecondaryDiscount, 2) . '</th>
                                            <th class="tax-amt">' . number_format($totalSecondaryTax, 2) . '</th>
                                            <th class="total">' . number_format($totalSecondaryAmount, 2) . '</th>
                                      </tr>
                                        </tbody>
                                      </table>';
            }

            $detailHTML .= '
                        <div class="total-section">
                        <div class="inst">
                            <h4>SPECIAL INSTRUCTIONS</h4>
                            <p>
                                ' . $specialInstructions . '
                            </p>
                        </div>
                        <div class="totals">
                        <table>
                        <tfoot>
                          <tr>
                            <td>SUBTOTAL</td>
                            <td></td>
                            <td>' . number_format($subTotalAmount, 2) . '</td>
                          </tr>
                          <tr>
                            <td>PRODUCT DISCOUNT</td>
                            <td>' . number_format($totalProductDiscount, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>SERVICE DISCOUNT</td>
                            <td>' . number_format($totalServiceDiscount, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>ROUND OFF DISCOUNT</td>
                            <td>' . number_format($totalRoundOffDiscount, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>CASH DISCOUNT</td>
                            <td>' . number_format($totalCashDiscount, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>TOTAL DISCOUNT</td>
                            <td></td>
                            <td>' . number_format($totalDiscount, 2) . '</td>
                          </tr>
                          <tr>
                            <td>INCLUSIVE TAX</td>
                            <td>' . number_format($totalInclusiveTax, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>EXCLUSIVE TAX</td>
                            <td>' . number_format($totalExclusiveTax, 2) . '</td>
                            <td></td>
                          </tr>
                          <tr>
                            <td>TOTAL TAX</td>
                            <td></td>
                            <td>' . number_format($totalTax, 2) . '</td>
                          </tr>
                          <tr>
                            <td class="grand">GRAND TOTAL</td>
                            <td></td>
                            <td class="grand">' . number_format($grandTotal, 2) . '</td>
                          </tr>
                          <tr>
                            <td class="words" colspan="3">' . number_to_word($grandTotal) . '</td>
                          </tr>
                        </tfoot>
                        </table>
                        </div>
                        </div>
                        <div id="thanks">Thank you!</div>
                            </main>
                            <footer>
                              Invoice was system generated and is valid without the signature and seal.
                            </footer>
                          </body>
                        </html>
                        ';

            $detailHTML_80mm .= '<table>
                                <tfoot>
                                  <tr>
                                    <td>SUBTOTAL</td>
                                    <td></td>
                                    <td>' . number_format($subTotalAmount, 2) . '</td>
                                  </tr>
                                  <tr>
                                    <td>PRODUCT DISCOUNT</td>
                                    <td>' . number_format($totalProductDiscount, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>SERVICE DISCOUNT</td>
                                    <td>' . number_format($totalServiceDiscount, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>ROUND OFF DISCOUNT</td>
                                    <td>' . number_format($totalRoundOffDiscount, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>CASH DISCOUNT</td>
                                     <td>' . number_format($totalCashDiscount, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>TOTAL DISCOUNT</td>
                                    <td></td>
                                    <td>' . number_format($totalDiscount, 2) . '</td>
                                  </tr>
                                  <tr>
                                    <td>INCLUSIVE TAX</td>
                                    <td>' . number_format($totalInclusiveTax, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>EXCLUSIVE TAX</td>
                                    <td>' . number_format($totalExclusiveTax, 2) . '</td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>TOTAL TAX</td>
                                    <td></td>
                                    <td>' . number_format($totalTax, 2) . '</td>
                                  </tr>
                                  <tr>
                                    <td class="grand">GRAND TOTAL</td>
                                    <td class="grand" colspan="2">' . number_format($grandTotal, 2) . '</td>
                                  </tr>
                                  <tr>
                                    <td class="words" colspan="3">' . number_to_word($grandTotal) . '</td>
                                  </tr>
                                </tfoot>
                                </table>
                                <h4 class="center">SPECIAL INSTRUCTIONS</h4>
                                <p class="center">
                                    ' . $specialInstructions . '
                                </p>
                                <div id="thanks" class="center">Thank you!</div>
                                    </main>
                                    <footer>
                                      Invoice was system generated and is valid without the signature and seal.
                                    </footer>
                                  </body>
                                </html>';

        } else {
            dieWithError("Invoice not found!", $database);
        }
        break;
}

$companyName = '';
$companyLogo = DEFAULT_LOGO_IMAGE_PATH;
$companyPTCL = '';
$companyEmail = '';
$companyAddress = '';

$companyInfoQuery = "SELECT ci_logo, ci_name, ci_ptcl_number, ci_email, ci_address FROM financials_company_info WHERE ci_id = 1 LIMIT 1;";
$companyInfoResult = $database->query($companyInfoQuery);
if ($companyInfoResult) {
    $companyData = $database->fetch_assoc($companyInfoResult);

    $companyName = $companyData['ci_name'];
    $companyLogo = $companyData['ci_logo'];
    $companyPTCL = $companyData['ci_ptcl_number'];
    $companyEmail = $companyData['ci_email'];
    $companyAddress = $companyData['ci_address'];

}

try {
    $printedTimeStamp = new DateTime();
    $printedTimeStamp = $printedTimeStamp->format(USER_DATE_TIME_FORMAT);
} catch (Exception $e) {}

if ($invoiceFormat == $_80mm) {
    $htmlInvoice = '<!DOCTYPE html>
                    <html lang="en">
                      <head>
                        <base href="' . $subDomain . '/public/_api/view/" />
                        <meta charset="utf-8">
                        <title>' . $invoiceTitle . ' ' . $primaryInvoiceId . '</title>
                        <link rel="stylesheet" href="invoice-80mm.css" media="all" />
                      </head>
                      <body>
                        <header class="clearfix">
                          <div id="logo">
                            <img src="' . $companyLogo . '" alt="Company Logo">
                          </div>
                          <div id="company">
                            <h2 class="name">' . $companyName . '</h2>
                            <div>' . $companyAddress . '</div>
                            <div>' . $companyPTCL . '</div>
                            <div><a href="mailto:' . $companyEmail . '">' . $companyEmail . '</a></div>
                            <div>Printed: ' . $printedTimeStamp . '</div>
                          </div>
                        </header>
                          <div id="title">
                            <h2 class="name">' . $invoiceTitle . '</h2>
                          </div>';

    $htmlInvoice .= $detailHTML_80mm;
} else {
    $htmlInvoice = '<!DOCTYPE html>
                    <html lang="en">
                      <head>
                        <base href="' . $subDomain . '/public/_api/view/" />
                        <meta charset="utf-8">
                        <title>' . $invoiceTitle . ' ' . $primaryInvoiceId . '</title>
                        <link rel="stylesheet" href="invoice.css" media="all" />
                      </head>
                      <body>
                        <header class="clearfix">
                          <div id="logo">
                            <img src="' . $companyLogo . '" alt="Company Logo">
                          </div>
                          <div id="company">
                            <h2 class="name">' . $companyName . '</h2>
                            <div>' . $companyAddress . '</div>
                            <div>' . $companyPTCL . '</div>
                            <div><a href="mailto:' . $companyEmail . '">' . $companyEmail . '</a></div>
                            <div>Printed: ' . $printedTimeStamp . '</div>
                          </div>
                        </header>
                          <div id="title">
                            <h2 class="name">' . $invoiceTitle . '</h2>
                          </div>';

    $htmlInvoice .= $detailHTML;
}


echo $htmlInvoice;


if (isset($database)) {
    $database->close_connection();
}
