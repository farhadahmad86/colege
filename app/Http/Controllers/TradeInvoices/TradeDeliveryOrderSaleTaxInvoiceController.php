<?php

namespace App\Http\Controllers\TradeInvoices;

use App\Http\Controllers\DayEndController;
use App\Models\BalancesModel;
use App\Models\CashReceiptVoucherItemsModel;
use App\Models\CashReceiptVoucherModel;
use App\Models\DeliveryOrderItemsModel;
use App\Models\DeliveryOrderQuantityHoldModel;
use App\Models\PostingReferenceModel;
use App\Models\ProductPackagesModel;
use App\Models\SaleInvoiceModel;
use App\Models\SaleSaletaxInvoiceModel;
use App\Models\ServiceSaleTaxInvoiceModel;
use App\Models\ServicesInvoiceModel;
use App\Models\SystemConfigModel;
use App\Models\TransactionModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TradeDeliveryOrderSaleTaxInvoiceController extends Controller
{
    public $actual_stock_price = 0;
    public $product_total_rate = 0;

    public function trade_delivery_order_sale_tax_invoice()
    {

        $accounts = $this->get_account_query('sale')[0];

        $products = $this->get_all_products();
        $pro_code = '';
        $pro_name = '';
        foreach ($products as $product) {
            $pro_title = $this->RemoveSpecialChar($product->pro_title);

            $pro_code .= "<option value='$product->pro_p_code' data-parent='$product->pro_p_code' data-sale_price='$product->pro_sale_price' data-tax='$product->pro_tax' data-retailer_dis='$product->pro_retailer_discount' data-whole_saler_dis='$product->pro_whole_seller_discount' data-loyalty_dis='$product->pro_loyalty_card_discount' data-unit='$product->unit_title' data-unit_scale_size='$product->unit_scale_size' data-main_unit='$product->mu_title'>$product->pro_p_code</option>";
            $pro_name .= "<option value='$product->pro_p_code' data-parent='$product->pro_p_code' data-sale_price='$product->pro_sale_price' data-tax='$product->pro_tax' data-retailer_dis='$product->pro_retailer_discount' data-whole_saler_dis='$product->pro_whole_seller_discount' data-loyalty_dis='$product->pro_loyalty_card_discount' data-unit='$product->unit_title' data-unit_scale_size='$product->unit_scale_size' data-main_unit='$product->mu_title'>$pro_title</option>";
        }

        $packages = ProductPackagesModel::where('pp_delete_status', '!=', 1)->where('pp_disabled', '!=', 1)->orderBy('pp_name', 'ASC')->get();

//        $sale_persons = User::where('user_id', '!=', 1)->orderBy('user_role_id', 'DESC')->orderBy('user_name', 'ASC')->get();

//        $warehouses = $this->get_all_warehouse();
//        $posting_references = PostingReferenceModel::where('pr_disabled','=',0)->get();

        return view('Trade_Invoices/trade_delivery_order_sale_tax_invoice', compact('pro_code', 'pro_name', 'accounts', 'products', 'packages'));
    }

    public function submit_trade_delivery_order_sale_tax_invoice(Request $request)
    {

        $this->delivery_order_sale_invoice_validation($request);
        $cash_discount_per = $request->disc_percentage;

        $product_total_items = 0;
        $product_total_price = 0;
        $product_discount_amount = 0;
        $product_round_off_discount_amount = 0;
        $product_inclusive_saletax = 0;
        $product_exclusive_saletax = 0;
        $product_total_saletax = 0;
        $product_grand_total = 0;

        $service_total_items = 0;
        $service_total_price = 0;
        $service_discount_amount = 0;
        $service_round_off_discount_amount = 0;
        $service_inclusive_saletax = 0;
        $service_exclusive_saletax = 0;
        $service_total_saletax = 0;
        $service_grand_total = 0;
        $delivery_order = $request->invoice_nbr_chk;
        $sales_array = [];
        $services_array = [];

        $requested_arrays = $request->pro_code;

        foreach ($requested_arrays as $index => $requested_array) {

            $item_delivery_order_id = $request->delivery_order_id[$index];
            $item_code = $request->pro_code[$index];
            $item_name = $request->pro_name[$index];
            $item_remarks = $request->product_remarks[$index];
            $item_warehouse = isset($request->warehouse[$index]) ? $request->warehouse[$index] : 0;
            $item_unit_measurement = $request->unit_measurement[$index];
            $item_unit_measurement_scale_size = $request->unit_measurement_scale_size[$index];
            $item_quantity = $request->quantity[$index];
            $item_bonus = isset($request->bonus[$index]) ? $request->bonus[$index] : 0;
            $item_rate = $request->rate[$index];
            $item_discount = $request->product_discount[$index];
            $item_discount_amount = $request->product_discount_amount[$index];
            $item_inclusive_rate = $request->product_inclusive_rate[$index];
            $item_after_disc_rate = $item_rate - ($item_discount_amount / $item_quantity);
            $item_sales_tax = $request->product_sales_tax[$index];
            $item_inclusive_exclusive = isset($request->inclusive_exclusive_status_value[$index]) ? $request->inclusive_exclusive_status_value[$index] : 0;
            $item_sale_tax_amount = $request->product_sale_tax_amount[$index];
            $item_amount = $request->amount[$index];

            if ($request->product_or_service_status[$index] == 0) {

                $product_total_items++;

                $product_total_price = round($product_total_price + ($item_rate * $item_quantity), 2);

                $product_discount_amount = round($product_discount_amount + $item_discount_amount, 2);

                if ($item_inclusive_exclusive == 1) {
                    $product_inclusive_saletax = round($product_inclusive_saletax + $item_sale_tax_amount, 2);
                } else {
                    $product_exclusive_saletax = round($product_exclusive_saletax + $item_sale_tax_amount, 2);
                }

                $product_total_saletax = round($product_total_saletax + $item_sale_tax_amount, 2);

                $product_grand_total += $item_amount;

                $sales_array[] = [
                    'delivery_order_id' => $item_delivery_order_id,
                    'product_code' => $item_code,
                    'product_name' => $item_name,
                    'product_remarks' => $item_remarks,
                    'warehouse' => $item_warehouse,
                    'product_qty' => $item_quantity,
                    'product_unit_measurement' => $item_unit_measurement,
                    'product_unit_measurement_scale_size' => $item_unit_measurement_scale_size,
                    'product_bonus_qty' => $item_bonus,
                    'product_rate' => $item_rate,
                    'product_discount' => $item_discount,
                    'product_discount_amount' => $item_discount_amount,
                    'product_inclusive_rate' => $item_inclusive_rate,
                    'product_after_disc_rate' => $item_after_disc_rate,
                    'product_sale_tax' => $item_sales_tax,
                    'inclusive_exclusive_status' => $item_inclusive_exclusive,
                    'product_sale_tax_amount' => $item_sale_tax_amount,
                    'product_amount' => $item_amount,
                ];
            } else {
                $service_total_items++;

                $service_total_price = round($service_total_price + ($item_rate * $item_quantity), 2);

                $service_discount_amount = round($service_discount_amount + $item_discount_amount, 2);

                if ($item_inclusive_exclusive == 1) {
                    $service_inclusive_saletax = round($service_inclusive_saletax + $item_sale_tax_amount, 2);
                } else {
                    $service_exclusive_saletax = round($service_exclusive_saletax + $item_sale_tax_amount, 2);
                }

                $service_total_saletax = round($service_total_saletax + $item_sale_tax_amount, 2);

                $service_grand_total += $item_amount;

                $services_array[] = [
                    'service_code' => $item_code,
                    'service_name' => $item_name,
                    'service_remarks' => $item_remarks,
                    'service_qty' => $item_quantity,
                    'service_bonus_qty' => 0,
                    'service_rate' => $item_rate,
                    'service_discount' => $item_discount,
                    'service_discount_amount' => $item_discount_amount,
                    'service_inclusive_rate' => $item_inclusive_rate,
                    'service_after_disc_rate' => $item_after_disc_rate,
                    'service_sale_tax' => $item_sales_tax,
                    'service_inclusive_exclusive_status' => $item_inclusive_exclusive,
                    'service_sale_tax_amount' => $item_sale_tax_amount,
                    'service_amount' => $item_amount,
                ];
            }
        }

        $without_tax_amount = $product_total_price + $service_total_price;

        $cash_discount_amount = ($without_tax_amount * $cash_discount_per) / 100;

        $product_cash_discount_amount = round(($cash_discount_amount / ($product_grand_total + $service_grand_total) * 100 * $product_grand_total) / 100, 2);

        $service_cash_discount_amount = round(($cash_discount_amount / ($product_grand_total + $service_grand_total) * 100 * $service_grand_total) / 100, 2);

        $product_total_discount_amount = $product_discount_amount + $product_cash_discount_amount;

        $service_total_discount_amount = $service_discount_amount + $service_cash_discount_amount;

        $product_grand_total = ($product_total_price - $product_total_discount_amount) + $product_exclusive_saletax;

        $service_grand_total = ($service_total_price - $service_total_discount_amount) + $service_exclusive_saletax;

        if ($request->round_off_discount == 1) {
            $product_round_off_discount_amount = round($product_grand_total - round($product_grand_total), 2);
            $service_round_off_discount_amount = round($service_grand_total - round($service_grand_total), 2);
        }

        $product_total_discount_amount = round($product_total_discount_amount + $product_round_off_discount_amount, 2);

        $service_total_discount_amount = round($service_total_discount_amount + $service_round_off_discount_amount, 2);

        $product_grand_total = round($product_grand_total - $product_round_off_discount_amount, 2);

        $service_grand_total = round($service_grand_total - $service_round_off_discount_amount, 2);


        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $rollBack = false;
        $account_code = $request->account_name;
        $account_name = $this->get_account_name($account_code);

        if ($request->machine > 0) {

            $machine_info = $this->get_credit_card_info($request->machine);

            $credit_card_machine_account_code = $machine_info->ccm_credit_card_account_code;
            $credit_card_machine_account_name = $this->get_account_name($credit_card_machine_account_code);
            $bank_service_charges_account = $machine_info->ccm_service_account_code;
            $bank_charges_percentage = $machine_info->ccm_percentage;

            $bank_code = $credit_card_machine_account_code;
            $bank_name = $credit_card_machine_account_name;
        }

        $invoice_type = $request->invoice_type;

        $credit_card_amount = $request->credit_card_amount;

        $cash = $request->cash_paid;

        $grand_total = $product_grand_total + $service_grand_total;


        $product_cash_paid_ratio = $product_grand_total / $grand_total;
        $service_cash_paid_ratio = $service_grand_total / $grand_total;

        $product_credit_paid = 0;
        $service_credit_paid = 0;


//        if ($credit_card_amount > 0) {
//            $cash += $credit_card_amount;
//
//            $cash_paid = $cash - ($cash - $grand_total) - $credit_card_amount;
//        } else {
//            $cash = $credit_card_amount;
        $cash_paid = $cash;
//        }

        $product_credit_paid = $credit_card_amount * $product_cash_paid_ratio;
        $service_credit_paid = $credit_card_amount * $service_cash_paid_ratio;


        $product_cash_paid = $cash_paid * $product_cash_paid_ratio;
        $service_cash_paid = $cash_paid * $service_cash_paid_ratio;

        $sale_amount = $product_grand_total - $product_total_saletax + $product_total_discount_amount;
        $service_amount = $service_grand_total - $service_total_saletax + $service_total_discount_amount;

        $sale_invoice_number = 0;
        $service_invoice_number = '';

        $product_bank_remaining_grand_total = 0;
        $service_bank_remaining_grand_total = 0;
        $product_bank_service_charges_amount = 0;
        $service_service_charges_amount = 0;


        $cash_in_hand = config('global_variables.cash_in_hand');
        $stock_in_hand = config('global_variables.stock_in_hand');
        $sale_tax_account = config('global_variables.sales_tax_payable_account');
        $sale_account = config('global_variables.sale_account');
        $sale_margin_account = config('global_variables.sale_margin_account');
        $walk_in_customer_account = config('global_variables.walk_in_customer');
        $product_discount_account = config('global_variables.product_discount_account');
        $round_off_discount_account = config('global_variables.round_off_discount_account');
        $cash_discount_account = config('global_variables.cash_discount_account');
        $retailer_discount_account = config('global_variables.retailer_discount_account');
        $wholesaler_discount_account = config('global_variables.wholesaler_discount_account');
        $loyalty_card_discount_account = config('global_variables.loyalty_card_discount_account');
        $service_discount_account = config('global_variables.service_discount_account');
        $service_account = config('global_variables.service_account');
        $service_sale_tax_account = config('global_variables.service_sale_tax_account');

        if ($request->discount_type == 2) {
            $product_discount_account = $retailer_discount_account;
        } elseif ($request->discount_type == 3) {
            $product_discount_account = $wholesaler_discount_account;
        } elseif ($request->discount_type == 4) {
            $product_discount_account = $loyalty_card_discount_account;
        }


        $user = Auth::user();

        if ($user->user_role_id == config('global_variables.teller_account_id')) {

            $account = $this->get_teller_or_purchaser_account($user->user_id);

            $cash_in_hand = $account->user_teller_cash_account_uid;
            $walk_in_customer_account = $account->user_teller_wic_account_uid;
        }

        DB::beginTransaction();

        if ($invoice_type == 1) {

            $sale_prefix = 'si';
            $sale_items_prefix = 'sii';

            $sale_invoice = new SaleInvoiceModel();
            $item_table = 'financials_sale_invoice_items';

            $service_prefix = 'sei';
            $service_items_prefix = 'seii';

            $delivery_qty_hold_prefix = 'doqh';
            $qty_hold_table = 'financials_delivery_order_qty_hold_log';

            $service_invoice = new ServicesInvoiceModel();
            $service_item_table = 'financials_service_invoice_items';

            $notes = 'SALE_INVOICE';
            $service_notes = 'SERVICE_INVOICE';

            $voucher_code = config('global_variables.TRADE_DELIVERY_ORDER_SALE_VOUCHER_CODE');
            $service_voucher_code = config('global_variables.SERVICE_VOUCHER_CODE');

            $transaction_type = config('global_variables.SALE');
            $service_transaction_type = config('global_variables.SERVICE_INVOICE');


        } else {

            $sale_prefix = 'ssi';
            $sale_items_prefix = 'ssii';

            $delivery_qty_hold_prefix = 'doqh';
            $qty_hold_table = 'financials_delivery_order_qty_hold_log';

            $sale_invoice = new SaleSaletaxInvoiceModel();
            $item_table = 'financials_sale_saletax_invoice_items';

            $service_prefix = 'sesi';
            $service_items_prefix = 'sesii';

            $service_invoice = new ServiceSaleTaxInvoiceModel();
            $service_item_table = 'financials_service_saletax_invoice_items';

            $notes = 'SALE_SALE_TAX_INVOICE';
            $service_notes = 'SERVICE_SALE_TAX_INVOICE';

            $voucher_code = config('global_variables.TRADE_DELIVERY_ORDER_SALE_TAX_VOUCHER_CODE');
            $service_voucher_code = config('global_variables.SERVICE_SALE_TAX_VOUCHER_CODE');

            $transaction_type = config('global_variables.SALE_SALE_TAX');
            $service_transaction_type = config('global_variables.SERVICE_SALE_TAX_INVOICE');
        }

        //sale invoice
        if (!empty($sales_array)) {

//            array_walk($sales_array, function (&$a) {
//                $a['warehouse'] = 1;
//            });

            // system config set increment default id according to user giving start coding
            $chk_bnk_pymnt = $sstm_cnfg_clm = '';
            if ($notes === 'SALE_INVOICE'):
                $chk_bnk_pymnt = SaleInvoiceModel::all();
                $sstm_cnfg_clm = 'sc_sale_invoice_number';
            elseif ($notes === 'SALE_SALE_TAX_INVOICE'):
                $chk_bnk_pymnt = SaleSaletaxInvoiceModel::all();
                $sstm_cnfg_clm = 'sc_sale_tax_invoice_number';
            endif;
            $sstm_cnfg_bp_id_chk = SystemConfigModel::where($sstm_cnfg_clm, '!=', '0')->first();
            if ($chk_bnk_pymnt->isEmpty()):
                if (isset($sstm_cnfg_bp_id_chk) && !empty($sstm_cnfg_bp_id_chk)):
                    $set_id = $sale_prefix . '_id';
                    $sale_invoice->$set_id = $sstm_cnfg_bp_id_chk->$sstm_cnfg_clm;
                endif;
            endif;
            // system config set increment default id according to user giving end coding

            //////////////////////////// Sale Invoice Insertion ////////////////////////////////////

            $sale_invoice = $this->AssignDeliveryOrderSaleInvoiceValues($request, $sale_invoice, $day_end, $user, $sale_prefix, $account_code, $account_name, $request->remarks, $product_total_items, $product_total_price, $product_discount_amount, $product_round_off_discount_amount, $cash_discount_per, $product_cash_discount_amount, $product_total_discount_amount, $product_inclusive_saletax, $product_exclusive_saletax, $product_total_saletax, $product_grand_total, $product_cash_paid);

            if ($sale_invoice->save()) {

                $s_id = $sale_prefix . '_id';

                $sale_invoice_id = $sale_invoice->$s_id;

                $sale_invoice_number = $voucher_code . $sale_invoice_id;
            } else {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            //////////////////////////// Sale Invoice Items Insertion ////////////////////////////////////
            $detail_remarks = '';

            $item = $this->AssignDeliveryOrderSaleInvoiceItemsValues($sale_invoice_id, $sales_array, $sale_items_prefix, 1);

            foreach ($item as $value) {

                $pro_rate = (float)$value[$sale_items_prefix . '_rate'];
                $pro_amount = (float)$value[$sale_items_prefix . '_amount'];

                $detail_remarks .= $value[$sale_items_prefix . '_product_name'] . ', ' . $value[$sale_items_prefix . '_qty'] . '@' . number_format($pro_rate, 2) . ' = ' . number_format($pro_amount, 2) . config('global_variables.Line_Break');
            }

            if (!DB::table($item_table)->insert($item)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }
            $item_qty_hold = $this->AssignDeliveryOrderSaleQtyHoldValues($sale_invoice_id, $delivery_order, $invoice_type, $sales_array, $delivery_qty_hold_prefix, 1);
            if (!DB::table($qty_hold_table)->insert($item_qty_hold)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            $stock_amount = $this->actual_stock_price;


            //////////////////////////// Details Remarks of Sale Invoice Insertion ////////////////////////////////////

            $sale_detail_remarks = $sale_prefix . '_detail_remarks';

            $sale_invoice->$sale_detail_remarks = $detail_remarks;

            if (!$sale_invoice->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            //////////////////////////// Product Inventory Insertion ////////////////////////////////////

//            $inventory = $this->AssignProductInventoryValues($sales_array, 2);
//
//            if (!$inventory) {
//                $rollBack = true;
//                DB::rollBack();
//                return redirect()->back()->with('fail', 'Failed Try Again');
//            }

            //////////////////////////// Warehouse Stock Insertion ////////////////////////////////////

//            $warehouses = [];
//            $warehouse = $this->AssignWarehouseStocksValues($warehouses, $sales_array, 2);
//
//            if (!DB::table('financials_warehouse_stock')->insert($warehouse)) {
//                $rollBack = true;
//                DB::rollBack();
//                return redirect()->back()->with('fail', 'Failed Try Again');
//            }

            //////////////////////////// Warehouse Stock Summary Insertion ////////////////////////////////////
            $invoice_type_summary='';
            if ($invoice_type == 1){
                $invoice_type_summary='DELIVERY-ORDER-SALE';
            }else{
                $invoice_type_summary='DELIVERY-ORDER-SALE-TAX';
            }

            $warehouses_summary = [];
            $warehouse_stock_summary = $this->AssignWarehouseStocksSummaryValues($warehouses_summary, $sales_array, $invoice_type_summary);

            if (!DB::table('financials_warehouse_stock_summary')->insert($warehouse_stock_summary)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            //////////////////////////// Stock Movement Insertion ////////////////////////////////////

            $stock_movement = $this->stock_movement_module_delivery_order_sale($sales_array, $voucher_code . $sale_invoice_id, 'DELIVERY-ORDER-SALE', 'DELIVERY-ORDER-SALE');

            if (!$stock_movement) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }


            //////////////////////////// Stock Movement Child Insertion ////////////////////////////////////
            $stock_movement_child = $this->stock_movement_child($sales_array,$sale_invoice_id, $account_code, $account_name,'DELIVERY_ORDER_SALE');

            if (!$stock_movement_child) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }


            //////////////////////////// TRANSACTION ONE STOCK IN HAND ////////////////////////////////////

            $transactions1 = new TransactionModel();
            $transaction1 = $this->AssignTransactionsValues($transactions1, 0, $stock_amount, $stock_in_hand, $notes, $transaction_type, $sale_invoice_id);

            if ($transaction1->save()) {
                $transaction_id1 = $transaction1->trans_id;

                $balances1 = new BalancesModel();

                $balance1 = $this->AssignAccountBalancesValues($balances1, $transaction_id1, $stock_in_hand, $stock_amount, 'Cr', $request->remarks,
                    $notes, $detail_remarks, $voucher_code . $sale_invoice_id, $request->posting_reference);

                if (!$balance1->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }
            } else {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }


            //////////////////////////// TRANSACTION TWO SALE ACCOUNT ////////////////////////////////////

            $transactions2 = new TransactionModel();
            $transaction2 = $this->AssignTransactionsValues($transactions2, 0, $sale_amount, $sale_account, $notes, $transaction_type, $sale_invoice_id);


            if ($transaction2->save()) {

                $transaction_id2 = $transaction2->trans_id;

                $balances2 = new BalancesModel();

                $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id2, $sale_account, $sale_amount, 'Cr', $request->remarks,
                    $notes, $detail_remarks, $voucher_code . $sale_invoice_id, $request->posting_reference);

                if (!$balance2->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }
            } else {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }


            if ($invoice_type == 2 && $product_total_saletax > 0) {

                //////////////////////////// TRANSACTION THREE SALE TAX ACCOUNT ////////////////////////////////////

                $transactions3 = new TransactionModel();
                $transaction3 = $this->AssignTransactionsValues($transactions3, 0, $product_total_saletax, $sale_tax_account, $notes, $transaction_type, $sale_invoice_id);

                if ($transaction3->save()) {
                    $transaction_id3 = $transaction3->trans_id;

                    $balances3 = new BalancesModel();

                    $balance3 = $this->AssignAccountBalancesValues($balances3, $transaction_id3, $sale_tax_account, $product_total_saletax, 'Cr', $request->remarks,
                        $notes, $detail_remarks, $voucher_code . $sale_invoice_id, $request->posting_reference);

                    if (!$balance3->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed Try Again');
                    }
                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }
            } elseif ($product_total_saletax > 0) {

                //////////////////////////// TRANSACTION THREE SALE TAX ACCOUNT ////////////////////////////////////

                $transactions3 = new TransactionModel();
                $transaction3 = $this->AssignTransactionsValues($transactions3, 0, $product_total_saletax, $sale_margin_account, $notes, $transaction_type, $sale_invoice_id);

                if ($transaction3->save()) {
                    $transaction_id3 = $transaction3->trans_id;

                    $balances3 = new BalancesModel();

                    $balance3 = $this->AssignAccountBalancesValues($balances3, $transaction_id3, $sale_margin_account, $product_total_saletax, 'Cr', $request->remarks,
                        $notes, $detail_remarks, $voucher_code . $sale_invoice_id, $request->posting_reference);

                    if (!$balance3->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed Try Again');
                    }
                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }
            }


            //////////////////////////// TRANSACTION FOUR PARTY ACCOUNT ////////////////////////////////////

            $transactions4 = new TransactionModel();
            $transaction4 = $this->AssignTransactionsValues($transactions4, $account_code, $product_grand_total, 0, $notes, $transaction_type, $sale_invoice_id);

            if ($transaction4->save()) {
                $transaction_id4 = $transaction4->trans_id;

                $balances4 = new BalancesModel();

                $balance4 = $this->AssignAccountBalancesValues($balances4, $transaction_id4, $account_code, $product_grand_total, 'Dr', $request->remarks,
                    $notes, $detail_remarks, $voucher_code . $sale_invoice_id, $request->posting_reference);

                if (!$balance4->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }
            } else {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }


            if ($product_discount_amount != 0) {
                //////////////////////////// TRANSACTION FIVE PRODUCT DISCOUNT ////////////////////////////////////

                $transactions5 = new TransactionModel();
                $transaction5 = $this->AssignTransactionsValues($transactions5, $product_discount_account, $product_discount_amount, 0, $notes, $transaction_type, $sale_invoice_id);

                if ($transaction5->save()) {

                    $transaction_id5 = $transaction5->trans_id;

                    $balances5 = new BalancesModel();

                    $balance5 = $this->AssignAccountBalancesValues($balances5, $transaction_id5, $product_discount_account, $product_discount_amount, 'Dr', $request->remarks,
                        $notes, $detail_remarks, $voucher_code . $sale_invoice_id, $request->posting_reference);

                    if (!$balance5->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed Try Again');
                    }
                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }
            }

            if ($product_round_off_discount_amount != 0) {
                //////////////////////////// TRANSACTION SIX ROUND OFF DISCOUNT ////////////////////////////////////

                $transactions6 = new TransactionModel();
                $transaction6 = $this->AssignTransactionsValues($transactions6, $round_off_discount_account, $product_round_off_discount_amount, 0, $notes, $transaction_type, $sale_invoice_id);

                if ($transaction6->save()) {

                    $transaction_id6 = $transaction6->trans_id;

                    $balances6 = new BalancesModel();

                    $balance6 = $this->AssignAccountBalancesValues($balances6, $transaction_id6, $round_off_discount_account, $product_round_off_discount_amount, 'Dr', $request->remarks,
                        $notes, $detail_remarks, $voucher_code . $sale_invoice_id, $request->posting_reference);

                    if (!$balance6->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed Try Again');
                    }
                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }
            }

            if ($product_cash_discount_amount != 0) {
                //////////////////////////// TRANSACTION SEVEN CASH DISCOUNT ////////////////////////////////////

                $transactions7 = new TransactionModel();
                $transaction7 = $this->AssignTransactionsValues($transactions7, $cash_discount_account, $product_cash_discount_amount, 0, $notes, $transaction_type, $sale_invoice_id);

                if ($transaction7->save()) {

                    $transaction_id7 = $transaction7->trans_id;

                    $balances7 = new BalancesModel();

                    $balance7 = $this->AssignAccountBalancesValues($balances7, $transaction_id7, $cash_discount_account, $product_cash_discount_amount, 'Dr', $request->remarks,
                        $notes, $detail_remarks, $voucher_code . $sale_invoice_id, $request->posting_reference);

                    if (!$balance7->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed Try Again');
                    }
                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }
            }

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $sale_invoice_id);


            //        if party pay cash or select walk in customer account
            if ($account_code == $walk_in_customer_account || $product_cash_paid > 0) {

                $cash_voucher_notes = 'CASH_RECEIPT_VOUCHER';
                $cash_voucher_voucher_code = config('global_variables.CASH_RECEIPT_VOUCHER_CODE');
                $cash_voucher_transaction_type = config('global_variables.CASH_RECEIPT');


                if ($account_code == $walk_in_customer_account) {
                    $cash_paid = $grand_total + $service_grand_total;
                }

//                if ($request->transaction_type == 2) {
//                    $account_code = $walk_in_customer_account;
//                    $account_name = $this->get_account_name($account_code);
//                }


                //////////////////////////// Cash Receipt Voucher Insertion ////////////////////////////////////

                $cash_voucher = new CashReceiptVoucherModel();
                $cash_voucher_prefix = 'cr';

                $cash_voucher_remarks = $sale_invoice_number . $service_invoice_number;

                $cash_voucher = $this->assign_cash_voucher_values($product_cash_paid, $cash_voucher_remarks, $cash_voucher, $day_end, $user, $cash_voucher_prefix, $cash_in_hand);

                if ($cash_voucher->save()) {

                    $cv_id = $cash_voucher_prefix . '_id';

                    $cash_voucher_id = $cash_voucher->$cv_id;
                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }

                //////////////////////////// Cash Receipt Voucher Items Insertion ////////////////////////////////////


                $cash_voucher_item = new CashReceiptVoucherItemsModel();
                $cash_voucher_item_prefix = 'cri';

                $cash_voucher_item = $this->cash_voucher_items_values($account_code, $account_name, $product_cash_paid, '', $cash_voucher_item, $cash_voucher_id, $cash_voucher_item_prefix);

                $cash_voucher_detail_remarks = $cash_voucher_item[$cash_voucher_item_prefix . '_account_name'] . ', @' . $cash_voucher_item[$cash_voucher_item_prefix . '_amount'] . PHP_EOL;

                if (!$cash_voucher_item->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }

                //////////////////////////// Cash Receipt Voucher Detail Remarks Insertion ////////////////////////////////////

                $cv_detail_remarks = $cash_voucher_prefix . '_detail_remarks';

                $cash_voucher->$cv_detail_remarks = $cash_voucher_detail_remarks;
                $cash_voucher->save();


                //////////////////////////// TRANSACTION EIGHT CASH ACCOUNT ///////////////////////////////////////

                $transactions8 = new TransactionModel();
                $transaction8 = $this->AssignTransactionsValues($transactions8, $cash_in_hand, $product_cash_paid, $account_code, $cash_voucher_notes, $cash_voucher_transaction_type, $cash_voucher_id);

                if ($transaction8->save()) {

                    $transaction_id8 = $transaction8->trans_id;

                    $balances8 = new BalancesModel();

                    $balance8 = $this->AssignAccountBalancesValues($balances8, $transaction_id8, $cash_in_hand, $product_cash_paid, 'Dr', $cash_voucher_remarks,
                        $cash_voucher_notes, $cash_voucher_detail_remarks, $cash_voucher_voucher_code . $cash_voucher_id, $request->posting_reference);

                    if (!$balance8->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed Try Again');
                    }

                    //////////////////////////// TRANSACTION NINE PARTY ACCOUNT ///////////////////////////////////////

                    $balances9 = new BalancesModel();

                    $balance9 = $this->AssignAccountBalancesValues($balances9, $transaction_id8, $account_code, $product_cash_paid, 'Cr', $cash_voucher_remarks,
                        $cash_voucher_notes, $cash_voucher_detail_remarks, $cash_voucher_voucher_code . $cash_voucher_id, $request->posting_reference);

                    if (!$balance9->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed Try Again');
                    }

                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }
            }

            //        if credit card machine selected
            if ($product_credit_paid != 0 && $request->machine > 0) {
                //////////////////////////// TRANSACTION Ten BANK ACCOUNT ///////////////////////////////////////

                $transactions10 = new TransactionModel();                                                           //$product_credit_card_bank_amount
                $transaction10 = $this->AssignTransactionsValues($transactions10, $credit_card_machine_account_code, $product_credit_paid, 0, $notes, $transaction_type, $sale_invoice_id);

                if ($transaction10->save()) {

                    $transaction_id10 = $transaction10->trans_id;

                    $balances10 = new BalancesModel();

                    $balance10 = $this->AssignAccountBalancesValues($balances10, $transaction_id10, $credit_card_machine_account_code, $product_credit_paid, 'Dr', $request->remarks,
                        $notes, $detail_remarks, $voucher_code . $sale_invoice_id, $request->posting_reference);

                    if (!$balance10->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed Try Again');
                    }
                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }

                //////////////////////////// TRANSACTION ELEVEN PARTY ACCOUNT ///////////////////////////////////////

                $transactions11 = new TransactionModel();
                $transaction11 = $this->AssignTransactionsValues($transactions11, 0, $product_credit_paid, $account_code, $notes, $transaction_type, $sale_invoice_id);

                if ($transaction11->save()) {

                    $transaction_id11 = $transaction11->trans_id;

                    $balances11 = new BalancesModel();
                    $bank_voucher_remarks = '';
                    $balance11 = $this->AssignAccountBalancesValues($balances11, $transaction_id11, $account_code, $product_credit_paid, 'Cr', $bank_voucher_remarks,
                        $notes, $detail_remarks, $voucher_code . $sale_invoice_id, $request->posting_reference);

                    if (!$balance11->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed Try Again');
                    }
                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }
            }


            //        if credit card machine selected
//            if ($product_credit_paid != 0 && $request->machine > 0) {
//
//                $bank_voucher_notes = 'BANK_RECEIPT_VOUCHER';
//                $bank_voucher_voucher_code = config('global_variables.BANK_RECEIPT_VOUCHER_CODE');
//                $bank_voucher_transaction_type = config('global_variables.BANK_RECEIPT');
//
////                if ($request->transaction_type == 2) {
////                    $account_code = $walk_in_customer_account;
////                    $account_name = $this->get_account_name($account_code);
////                }
//
//                $product_bank_service_charges = ($product_credit_paid * $bank_charges_percentage) / 100;
//                $product_credit_card_bank_amount = $product_credit_paid - $product_bank_service_charges;
//
//                //////////////////////////// Bank Receipt Voucher Insertion ////////////////////////////////////
//
//                $bank_voucher = new BankReceiptVoucherModel();
//                $bank_voucher_prefix = 'br';
//
//                $bank_voucher_remarks = $sale_invoice_number . $service_invoice_number;
//
//                $bank_voucher = $this->assign_bank_voucher_values($credit_card_machine_account_code, $product_credit_paid, $bank_voucher_remarks, $bank_voucher, $day_end, $user, $bank_voucher_prefix, $product_credit_card_bank_amount);
//
//                if ($bank_voucher->save()) {
//
//                    $br_id = $bank_voucher_prefix . '_id';
//
//                    $bank_voucher_id = $bank_voucher->$br_id;
//                } else {
//                    $rollBack = true;
//                    DB::rollBack();
//                    return redirect()->back()->with('fail', 'Failed Try Again');
//                }
//
//                //////////////////////////// Bank Receipt Voucher Items Insertion ////////////////////////////////////
//
//
//                $bank_voucher_item = new BankReceiptVoucherItemsModel();
//                $bank_voucher_item_prefix = 'bri';
//
//                $bank_voucher_item = $this->bank_voucher_items_values($bank_code, $bank_name, $product_credit_paid, '', $bank_voucher_item, $bank_voucher_id, $bank_voucher_item_prefix, config('global_variables.brv_cr_type'));
//
//                $bank_voucher_detail_remarks = $bank_voucher_item[$bank_voucher_item_prefix . '_account_name'] . ', @' . $bank_voucher_item[$bank_voucher_item_prefix . '_amount'] . PHP_EOL;
//
//                if (!$bank_voucher_item->save()) {
//                    $rollBack = true;
//                    DB::rollBack();
//                    return redirect()->back()->with('fail', 'Failed Try Again');
//                }
//
//
//                $bank_voucher_item = new BankReceiptVoucherItemsModel();
//                $bank_voucher_item_prefix = 'bri';
//
//
//                $bank_service_charges_account_name = $this->get_account_name($bank_service_charges_account);
//
//                $bank_voucher_item = $this->bank_voucher_items_values($bank_service_charges_account, $bank_service_charges_account_name, $product_bank_service_charges, '', $bank_voucher_item, $bank_voucher_id, $bank_voucher_item_prefix, config('global_variables.brv_dr_type'));
//
//                $bank_voucher_detail_remarks .= $bank_voucher_item[$bank_voucher_item_prefix . '_account_name'] . ', @' . $bank_voucher_item[$bank_voucher_item_prefix . '_amount'] . PHP_EOL;
//
//                if (!$bank_voucher_item->save()) {
//                    $rollBack = true;
//                    DB::rollBack();
//                    return redirect()->back()->with('fail', 'Failed Try Again');
//                }
//
//                //////////////////////////// Bank Receipt Voucher Detail Remarks Insertion ////////////////////////////////////
//
//                $br_detail_remarks = $bank_voucher_prefix . '_detail_remarks';
//
//                $bank_voucher->$br_detail_remarks = $bank_voucher_detail_remarks;
//                $bank_voucher->save();
//
//
//                //////////////////////////// TRANSACTION EIGHT BANK ACCOUNT ///////////////////////////////////////
//
//                $transactions8 = new TransactionModel();                                                           //$product_credit_card_bank_amount
//                $transaction8 = $this->AssignTransactionsValues($transactions8, $credit_card_machine_account_code, $product_credit_paid, 0, $bank_voucher_notes, $bank_voucher_transaction_type, $bank_voucher_id);
//
//                if ($transaction8->save()) {
//
//                    $transaction_id8 = $transaction8->trans_id;
//
//                    $balances8 = new BalancesModel();
//
//                    $balance8 = $this->AssignAccountBalancesValues($balances8, $transaction_id8, $credit_card_machine_account_code, $product_credit_paid, 'Dr', $bank_voucher_remarks,
//                        $bank_voucher_notes, $bank_voucher_detail_remarks, $bank_voucher_voucher_code . $bank_voucher_id);
//
//                    if (!$balance8->save()) {
//                        $rollBack = true;
//                        DB::rollBack();
//                        return redirect()->back()->with('fail', 'Failed Try Again');
//                    }
//                } else {
//                    $rollBack = true;
//                    DB::rollBack();
//                    return redirect()->back()->with('fail', 'Failed Try Again');
//                }
//
//
//                //////////////////////////// TRANSACTION NINE SERVICE CHARGES ACCOUNT ///////////////////////////////////////
//
//                $transactions9 = new TransactionModel();
//                $transaction9 = $this->AssignTransactionsValues($transactions9, $bank_service_charges_account, $product_bank_service_charges, 0, $bank_voucher_notes, $bank_voucher_transaction_type, $bank_voucher_id);
//
//                if ($transaction9->save()) {
//
//                    $transaction_id9 = $transaction9->trans_id;
//
//                    $balances9 = new BalancesModel();
//
//                    $balance9 = $this->AssignAccountBalancesValues($balances9, $transaction_id9, $bank_service_charges_account, $product_bank_service_charges, 'Dr', $bank_voucher_remarks,
//                        $bank_voucher_notes, $bank_voucher_detail_remarks, $bank_voucher_voucher_code . $bank_voucher_id);
//
//                    if (!$balance9->save()) {
//                        $rollBack = true;
//                        DB::rollBack();
//                        return redirect()->back()->with('fail', 'Failed Try Again');
//                    }
//                } else {
//                    $rollBack = true;
//                    DB::rollBack();
//                    return redirect()->back()->with('fail', 'Failed Try Again');
//                }
//
////            $total_account_amount = $total_bank_payment + $total_service_charges;
//
//                //////////////////////////// TRANSACTION TEN PARTY ACCOUNT ///////////////////////////////////////
//
//                $transactions9 = new TransactionModel();
//                $transaction9 = $this->AssignTransactionsValues($transactions9, 0, $product_credit_paid, $account_code, $bank_voucher_notes, $bank_voucher_transaction_type, $bank_voucher_id);
//
//                if ($transaction9->save()) {
//
//                    $transaction_id9 = $transaction9->trans_id;
//
//                    $balances9 = new BalancesModel();
//
//                    $balance9 = $this->AssignAccountBalancesValues($balances9, $transaction_id9, $account_code, $product_credit_paid, 'Cr', $bank_voucher_remarks,
//                        $bank_voucher_notes, $bank_voucher_detail_remarks, $bank_voucher_voucher_code . $bank_voucher_id);
//
//                    if (!$balance9->save()) {
//                        $rollBack = true;
//                        DB::rollBack();
//                        return redirect()->back()->with('fail', 'Failed Try Again');
//                    }
//                } else {
//                    $rollBack = true;
//                    DB::rollBack();
//                    return redirect()->back()->with('fail', 'Failed Try Again');
//                }
//            }

        }

//        service invoice
        if (!empty($services_array)) {

            // system config set increment default id according to user giving start coding
            $chk_bnk_pymnt = $sstm_cnfg_clm = '';
            if ($service_notes === 'SERVICE_INVOICE'):
                $chk_bnk_pymnt = ServicesInvoiceModel::all();
                $sstm_cnfg_clm = 'sc_service_invoice_number';
            elseif ($service_notes === 'SERVICE_SALE_TAX_INVOICE'):
                $chk_bnk_pymnt = ServiceSaleTaxInvoiceModel::all();
                $sstm_cnfg_clm = 'sc_service_tax_invoice_number';
            endif;
            $sstm_cnfg_bp_id_chk = SystemConfigModel::where($sstm_cnfg_clm, '!=', '0')->first();
            if ($chk_bnk_pymnt->isEmpty()):
                if (isset($sstm_cnfg_bp_id_chk) && !empty($sstm_cnfg_bp_id_chk)):
                    $set_id = $service_prefix . '_id';
                    $service_invoice->$set_id = $sstm_cnfg_bp_id_chk->$sstm_cnfg_clm;
                endif;
            endif;
            // system config set increment default id according to user giving end coding


            //////////////////////////// service Invoice Insertion ////////////////////////////////////

            $service_invoice = $this->AssignDeliveryOrderSaleInvoiceValues($request, $service_invoice, $day_end, $user, $service_prefix, $account_code, $account_name, $request->remarks, $service_total_items,
                $service_total_price, $service_discount_amount, $service_round_off_discount_amount, $cash_discount_per, $service_cash_discount_amount, $service_total_discount_amount,
                $service_inclusive_saletax, $service_exclusive_saletax, $service_total_saletax, $service_grand_total, $service_cash_paid);

            if ($service_invoice->save()) {

                $s_id = $service_prefix . '_id';

                $service_invoice_id = $service_invoice->$s_id;

                $service_invoice_number .= '/' . $service_voucher_code . $service_invoice_id;
            } else {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

//////////////////////////// service Invoice Items Insertion ////////////////////////////////////

            $detail_remarks = '';

            $service_item = $this->AssignDeliveryOrderSaleInvoiceItemsValues($service_invoice_id, $services_array, $service_items_prefix, 2);

            foreach ($service_item as $value) {

                $ser_rate = (float)$value[$service_items_prefix . '_rate'];
                $ser_amount = (float)$value[$service_items_prefix . '_amount'];

                $detail_remarks .= $value[$service_items_prefix . '_service_name'] . ', ' . $value[$service_items_prefix . '_qty'] . '@' . number_format($ser_rate, 2) . ' = ' . number_format
                    ($ser_amount, 2) . config('global_variables.Line_Break');
            }

            if (!DB::table($service_item_table)->insert($service_item)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }


//////////////////////////// Details Remarks of service Invoice Insertion ////////////////////////////////////

            $service_detail_remarks = $service_prefix . '_detail_remarks';

            $service_invoice->$service_detail_remarks = $detail_remarks;

            if (!$service_invoice->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }


//////////////////////////// TRANSACTION ONE SERVICE ACCOUNT ////////////////////////////////////

            $transactions1 = new TransactionModel();
            $transaction1 = $this->AssignTransactionsValues($transactions1, 0, $service_amount, $service_account, $service_notes, $service_transaction_type, $service_invoice_id);


            if ($transaction1->save()) {

                $transaction_id1 = $transaction1->trans_id;

                $balances1 = new BalancesModel();

                $balance1 = $this->AssignAccountBalancesValues($balances1, $transaction_id1, $service_account, $service_amount, 'Cr', $request->remarks,
                    $service_notes, $detail_remarks, $service_voucher_code . $service_invoice_id, $request->posting_reference);

                if (!$balance1->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }
            } else {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }


            if ($invoice_type == 2 && $service_total_saletax > 0) {

                //////////////////////////// TRANSACTION TWO SALE TAX ACCOUNT ////////////////////////////////////

                $transactions2 = new TransactionModel();
                $transaction2 = $this->AssignTransactionsValues($transactions2, 0, $service_total_saletax, $service_sale_tax_account, $service_notes, $service_transaction_type, $service_invoice_id);

                if ($transaction2->save()) {
                    $transaction_id2 = $transaction2->trans_id;

                    $balances2 = new BalancesModel();

                    $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id2, $service_sale_tax_account, $service_total_saletax, 'Cr', $request->remarks,
                        $service_notes, $detail_remarks, $service_voucher_code . $service_invoice_id, $request->posting_reference);

                    if (!$balance2->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed Try Again');
                    }
                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }
            } elseif ($service_total_saletax > 0) {

                //////////////////////////// TRANSACTION TWO SALE TAX ACCOUNT ////////////////////////////////////

                $transactions2 = new TransactionModel();
                $transaction2 = $this->AssignTransactionsValues($transactions2, 0, $service_total_saletax, $sale_margin_account, $service_notes, $service_transaction_type, $service_invoice_id);

                if ($transaction2->save()) {
                    $transaction_id2 = $transaction2->trans_id;

                    $balances2 = new BalancesModel();

                    $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id2, $sale_margin_account, $service_total_saletax, 'Cr', $request->remarks,
                        $service_notes, $detail_remarks, $service_voucher_code . $service_invoice_id, $request->posting_reference);

                    if (!$balance2->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed Try Again');
                    }
                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }
            }

//////////////////////////// TRANSACTION THREE PARTY ACCOUNT ////////////////////////////////////

            $transactions3 = new TransactionModel();
            $transaction3 = $this->AssignTransactionsValues($transactions3, $account_code, $service_grand_total, 0, $service_notes, $service_transaction_type, $service_invoice_id);

            if ($transaction3->save()) {
                $transaction_id3 = $transaction3->trans_id;

                $balances3 = new BalancesModel();

                $balance3 = $this->AssignAccountBalancesValues($balances3, $transaction_id3, $account_code, $service_grand_total, 'Dr', $request->remarks,
                    $service_notes, $detail_remarks, $service_voucher_code . $service_invoice_id, $request->posting_reference);

                if (!$balance3->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }
            } else {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }


            if ($service_discount_amount != 0) {
                //////////////////////////// TRANSACTION SIX PRODUCT DISCOUNT ////////////////////////////////////

                $transactions6 = new TransactionModel();
                $transaction6 = $this->AssignTransactionsValues($transactions6, $service_discount_account, $service_discount_amount, 0, $service_notes, $service_transaction_type, $service_invoice_id);

                if ($transaction6->save()) {

                    $transaction_id6 = $transaction6->trans_id;

                    $balances6 = new BalancesModel();

                    $balance6 = $this->AssignAccountBalancesValues($balances6, $transaction_id6, $service_discount_account, $service_discount_amount, 'Dr', $request->remarks,
                        $service_notes, $detail_remarks, $service_voucher_code . $service_invoice_id, $request->posting_reference);

                    if (!$balance6->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed Try Again');
                    }
                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }
            }

            if ($service_round_off_discount_amount != 0) {
                //////////////////////////// TRANSACTION SEVEN ROUND OFF DISCOUNT ////////////////////////////////////

                $transactions7 = new TransactionModel();
                $transaction7 = $this->AssignTransactionsValues($transactions7, $round_off_discount_account, $service_round_off_discount_amount, 0, $service_notes, $service_transaction_type, $service_invoice_id);

                if ($transaction7->save()) {

                    $transaction_id7 = $transaction7->trans_id;

                    $balances7 = new BalancesModel();

                    $balance7 = $this->AssignAccountBalancesValues($balances7, $transaction_id7, $round_off_discount_account, $service_round_off_discount_amount, 'Dr', $request->remarks,
                        $service_notes, $detail_remarks, $service_voucher_code . $service_invoice_id, $request->posting_reference);

                    if (!$balance7->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed Try Again');
                    }
                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }
            }

            if ($service_cash_discount_amount != 0) {
                //////////////////////////// TRANSACTION EIGHT CASH DISCOUNT ////////////////////////////////////

                $transactions8 = new TransactionModel();
                $transaction8 = $this->AssignTransactionsValues($transactions8, $cash_discount_account, $service_cash_discount_amount, 0, $service_notes, $service_transaction_type, $service_invoice_id);

                if ($transaction8->save()) {

                    $transaction_id8 = $transaction8->trans_id;

                    $balances8 = new BalancesModel();

                    $balance8 = $this->AssignAccountBalancesValues($balances8, $transaction_id8, $cash_discount_account, $service_cash_discount_amount, 'Dr', $request->remarks,
                        $service_notes, $detail_remarks, $service_voucher_code . $service_invoice_id, $request->posting_reference);

                    if (!$balance8->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed Try Again');
                    }
                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }
            }

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $service_notes . ' With Id: ' . $service_invoice_id);

//        if party pay cash or select walk in customer account
            if ($account_code == $walk_in_customer_account || $service_cash_paid > 0) {

                $cash_voucher_notes = 'CASH_RECEIPT_VOUCHER';
                $cash_voucher_voucher_code = config('global_variables.CASH_RECEIPT_VOUCHER_CODE');
                $cash_voucher_transaction_type = config('global_variables.CASH_RECEIPT');


                if ($account_code == $walk_in_customer_account) {
                    $cash_paid = $grand_total + $service_grand_total;
                }

//                if ($request->transaction_type == 2) {
//                    $account_code = $walk_in_customer_account;
//                    $account_name = $this->get_account_name($account_code);
//                }


                //////////////////////////// Cash Receipt Voucher Insertion ////////////////////////////////////

                $cash_voucher = new CashReceiptVoucherModel();
                $cash_voucher_prefix = 'cr';

                $cash_voucher_remarks = $sale_invoice_number . $service_invoice_number;

                $cash_voucher = $this->assign_cash_voucher_values($service_cash_paid, $cash_voucher_remarks, $cash_voucher, $day_end, $user, $cash_voucher_prefix, $cash_in_hand);

                if ($cash_voucher->save()) {

                    $cv_id = $cash_voucher_prefix . '_id';

                    $cash_voucher_id = $cash_voucher->$cv_id;
                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }

                //////////////////////////// Cash Receipt Voucher Items Insertion ////////////////////////////////////


                $cash_voucher_item = new CashReceiptVoucherItemsModel();
                $cash_voucher_item_prefix = 'cri';

                $cash_voucher_item = $this->cash_voucher_items_values($account_code, $account_name, $service_cash_paid, '', $cash_voucher_item, $cash_voucher_id, $cash_voucher_item_prefix);

                $cash_voucher_detail_remarks = $cash_voucher_item[$cash_voucher_item_prefix . '_account_name'] . ', @' . $cash_voucher_item[$cash_voucher_item_prefix . '_amount'] . PHP_EOL;

                if (!$cash_voucher_item->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }

                //////////////////////////// Cash Receipt Voucher Detail Remarks Insertion ////////////////////////////////////

                $cv_detail_remarks = $cash_voucher_prefix . '_detail_remarks';

                $cash_voucher->$cv_detail_remarks = $cash_voucher_detail_remarks;
                $cash_voucher->save();


                //////////////////////////// TRANSACTION EIGHT CASH ACCOUNT ///////////////////////////////////////

                $transactions8 = new TransactionModel();
                $transaction8 = $this->AssignTransactionsValues($transactions8, $cash_in_hand, $service_cash_paid, $account_code, $cash_voucher_notes, $cash_voucher_transaction_type,
                    $cash_voucher_id);

                if ($transaction8->save()) {

                    $transaction_id8 = $transaction8->trans_id;

                    $balances8 = new BalancesModel();

                    $balance8 = $this->AssignAccountBalancesValues($balances8, $transaction_id8, $cash_in_hand, $service_cash_paid, 'Dr', $cash_voucher_remarks,
                        $cash_voucher_notes, $cash_voucher_detail_remarks, $cash_voucher_voucher_code . $cash_voucher_id, $request->posting_reference);

                    if (!$balance8->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed Try Again');
                    }

                    //////////////////////////// TRANSACTION NINE PARTY ACCOUNT ///////////////////////////////////////

                    $balances9 = new BalancesModel();

                    $balance9 = $this->AssignAccountBalancesValues($balances9, $transaction_id8, $account_code, $service_cash_paid, 'Cr', $cash_voucher_remarks,
                        $cash_voucher_notes, $cash_voucher_detail_remarks, $cash_voucher_voucher_code . $cash_voucher_id, $request->posting_reference);

                    if (!$balance9->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed Try Again');
                    }

                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }
            }

//        if credit card machine selected
            if ($service_credit_paid != 0 && $request->machine > 0) {
                //////////////////////////// TRANSACTION Ten BANK ACCOUNT ///////////////////////////////////////

                $transactions10 = new TransactionModel();                                                           //$service_credit_card_bank_amount
                $transaction10 = $this->AssignTransactionsValues($transactions10, $credit_card_machine_account_code, $service_credit_paid, 0, $service_notes,
                    $service_transaction_type, $service_invoice_id);

                if ($transaction10->save()) {

                    $transaction_id10 = $transaction10->trans_id;

                    $balances10 = new BalancesModel();

                    $balance10 = $this->AssignAccountBalancesValues($balances10, $transaction_id10, $credit_card_machine_account_code, $service_credit_paid, 'Dr', $request->remarks,
                        $service_notes, $detail_remarks, $service_voucher_code . $service_invoice_id, $request->posting_reference);

                    if (!$balance10->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed Try Again');
                    }
                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }

                //////////////////////////// TRANSACTION ELEVEN PARTY ACCOUNT ///////////////////////////////////////

                $transactions11 = new TransactionModel();
                $transaction11 = $this->AssignTransactionsValues($transactions11, 0, $service_credit_paid, $account_code, $service_notes, $service_transaction_type, $service_invoice_id);

                if ($transaction11->save()) {

                    $transaction_id11 = $transaction11->trans_id;

                    $balances11 = new BalancesModel();

                    $balance11 = $this->AssignAccountBalancesValues($balances11, $transaction_id11, $account_code, $service_credit_paid, 'Cr', $request->remarks,
                        $service_notes, $detail_remarks, $service_voucher_code . $service_invoice_id, $request->posting_reference);

                    if (!$balance11->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed Try Again');
                    }
                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }
            }


//        if credit card machine selected
//            if ($service_credit_paid != 0 && $request->machine > 0) {
//
//                $bank_voucher_notes = 'BANK_RECEIPT_VOUCHER';
//                $bank_voucher_voucher_code = config('global_variables.BANK_RECEIPT_VOUCHER_CODE');
//                $bank_voucher_transaction_type = config('global_variables.BANK_RECEIPT');
//
////                if ($request->transaction_type == 2) {
////                    $account_code = $walk_in_customer_account;
////                    $account_name = $this->get_account_name($account_code);
////                }
//
//                $service_bank_service_charges = ($service_credit_paid * $bank_charges_percentage) / 100;
//                $service_credit_card_bank_amount = $service_credit_paid - $service_bank_service_charges;
//
//                //////////////////////////// Bank Receipt Voucher Insertion ////////////////////////////////////
//
//                $bank_voucher = new BankReceiptVoucherModel();
//                $bank_voucher_prefix = 'br';
//
//                $bank_voucher_remarks = $sale_invoice_number . $service_invoice_number;
//
//                $bank_voucher = $this->assign_bank_voucher_values($credit_card_machine_account_code, $service_credit_paid, $bank_voucher_remarks, $bank_voucher, $day_end, $user, $bank_voucher_prefix,
//                    $service_credit_card_bank_amount);
//
//                if ($bank_voucher->save()) {
//
//                    $br_id = $bank_voucher_prefix . '_id';
//
//                    $bank_voucher_id = $bank_voucher->$br_id;
//                } else {
//                    $rollBack = true;
//                    DB::rollBack();
//                    return redirect()->back()->with('fail', 'Failed Try Again');
//                }
//
//                //////////////////////////// Bank Receipt Voucher Items Insertion ////////////////////////////////////
//
//
//                $bank_voucher_item = new BankReceiptVoucherItemsModel();
//                $bank_voucher_item_prefix = 'bri';
//
//                $bank_voucher_item = $this->bank_voucher_items_values($account_code, $account_name, $service_credit_paid, '', $bank_voucher_item, $bank_voucher_id, $bank_voucher_item_prefix, config
//                ('global_variables.brv_cr_type'));
//
//                $bank_voucher_detail_remarks = $bank_voucher_item[$bank_voucher_item_prefix . '_account_name'] . ', @' . $bank_voucher_item[$bank_voucher_item_prefix . '_amount'] . PHP_EOL;
//
//                if (!$bank_voucher_item->save()) {
//                    $rollBack = true;
//                    DB::rollBack();
//                    return redirect()->back()->with('fail', 'Failed Try Again');
//                }
//
//
//                $bank_voucher_item = new BankReceiptVoucherItemsModel();
//                $bank_voucher_item_prefix = 'bri';
//
//
//                $bank_service_charges_account_name = $this->get_account_name($bank_service_charges_account);
//
//                $bank_voucher_item = $this->bank_voucher_items_values($bank_service_charges_account, $bank_service_charges_account_name, $service_bank_service_charges, '', $bank_voucher_item,
//                    $bank_voucher_id, $bank_voucher_item_prefix, config('global_variables.brv_dr_type'));
//
//                $bank_voucher_detail_remarks .= $bank_voucher_item[$bank_voucher_item_prefix . '_account_name'] . ', @' . $bank_voucher_item[$bank_voucher_item_prefix . '_amount'] . PHP_EOL;
//
//                if (!$bank_voucher_item->save()) {
//                    $rollBack = true;
//                    DB::rollBack();
//                    return redirect()->back()->with('fail', 'Failed Try Again');
//                }
//
//                //////////////////////////// Bank Receipt Voucher Detail Remarks Insertion ////////////////////////////////////
//
//                $br_detail_remarks = $bank_voucher_prefix . '_detail_remarks';
//
//                $bank_voucher->$br_detail_remarks = $bank_voucher_detail_remarks;
//                $bank_voucher->save();
//
//
//                //////////////////////////// TRANSACTION EIGHT BANK ACCOUNT ///////////////////////////////////////
//
//                $transactions8 = new TransactionModel();                                                        //$service_credit_card_bank_amount
//                $transaction8 = $this->AssignTransactionsValues($transactions8, $credit_card_machine_account_code, $service_credit_paid, 0, $bank_voucher_notes,
//                    $bank_voucher_transaction_type, $bank_voucher_id);
//
//                if ($transaction8->save()) {
//
//                    $transaction_id8 = $transaction8->trans_id;
//
//                    $balances8 = new BalancesModel();
//
//                    $balance8 = $this->AssignAccountBalancesValues($balances8, $transaction_id8, $credit_card_machine_account_code, $service_credit_paid, 'Dr', $bank_voucher_remarks,
//                        $bank_voucher_notes, $bank_voucher_detail_remarks, $bank_voucher_voucher_code . $bank_voucher_id);
//
//                    if (!$balance8->save()) {
//                        $rollBack = true;
//                        DB::rollBack();
//                        return redirect()->back()->with('fail', 'Failed Try Again');
//                    }
//                } else {
//                    $rollBack = true;
//                    DB::rollBack();
//                    return redirect()->back()->with('fail', 'Failed Try Again');
//                }
//
//
//                //////////////////////////// TRANSACTION NINE SERVICE CHARGES ACCOUNT ///////////////////////////////////////
//
//                $transactions9 = new TransactionModel();
//                $transaction9 = $this->AssignTransactionsValues($transactions9, $bank_service_charges_account, $service_bank_service_charges, 0, $bank_voucher_notes, $bank_voucher_transaction_type,
//                    $bank_voucher_id);
//
//                if ($transaction9->save()) {
//
//                    $transaction_id9 = $transaction9->trans_id;
//
//                    $balances9 = new BalancesModel();
//
//                    $balance9 = $this->AssignAccountBalancesValues($balances9, $transaction_id9, $bank_service_charges_account, $service_bank_service_charges, 'Dr', $bank_voucher_remarks,
//                        $bank_voucher_notes, $bank_voucher_detail_remarks, $bank_voucher_voucher_code . $bank_voucher_id);
//
//                    if (!$balance9->save()) {
//                        $rollBack = true;
//                        DB::rollBack();
//                        return redirect()->back()->with('fail', 'Failed Try Again');
//                    }
//                } else {
//                    $rollBack = true;
//                    DB::rollBack();
//                    return redirect()->back()->with('fail', 'Failed Try Again');
//                }
//
////            $total_account_amount = $total_bank_payment + $total_service_charges;
//
//                //////////////////////////// TRANSACTION TEN PARTY ACCOUNT ///////////////////////////////////////
//
//                $transactions9 = new TransactionModel();
//                $transaction9 = $this->AssignTransactionsValues($transactions9, 0, $service_credit_paid, $account_code, $bank_voucher_notes, $bank_voucher_transaction_type, $bank_voucher_id);
//
//                if ($transaction9->save()) {
//
//                    $transaction_id9 = $transaction9->trans_id;
//
//                    $balances9 = new BalancesModel();
//
//                    $balance9 = $this->AssignAccountBalancesValues($balances9, $transaction_id9, $account_code, $service_credit_paid, 'Cr', $bank_voucher_remarks,
//                        $bank_voucher_notes, $bank_voucher_detail_remarks, $bank_voucher_voucher_code . $bank_voucher_id);
//
//                    if (!$balance9->save()) {
//                        $rollBack = true;
//                        DB::rollBack();
//                        return redirect()->back()->with('fail', 'Failed Try Again');
//                    }
//                } else {
//                    $rollBack = true;
//                    DB::rollBack();
//                    return redirect()->back()->with('fail', 'Failed Try Again');
//                }
//            }
        }

        if (!empty($services_array) && !empty($sales_array)) {

            //////////////////////////// INSERT SERVICE INVOICE ID IN SALE INVOICE ////////////////////////////////////

            $sale_service_invoice_id = $sale_prefix . '_service_invoice_id';

            $sale_invoice->$sale_service_invoice_id = $service_invoice_id;

            if (!$sale_invoice->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }


            //////////////////////////// INSERT SALE INVOICE ID IN SERVICE INVOICE ////////////////////////////////////

            $service_sale_invoice_id = $service_prefix . '_sale_invoice_id';

            $service_invoice->$service_sale_invoice_id = $sale_invoice_id;

            if (!$service_invoice->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }
        }

        foreach ($sales_array as $val) {

            $product_code = $val['product_code'];
            $warehouse = $val['warehouse'];
            $qty = $val['product_qty'];
            $delivery_order = DeliveryOrderItemsModel::where('doi_product_code', $product_code)->where('doi_warehouse_id', $warehouse)->where('doi_invoice_id', '=', $val['delivery_order_id'])->first();
            if($invoice_type ==1) {
                if ($delivery_order->doi_status != null || $delivery_order->doi_status != 0) {
                    $id = $delivery_order->doi_status;
                    $delivery_order->doi_status = $id . ',' . 'SI-'.$sale_invoice_id;
                } else {
                    $delivery_order->doi_status = 'SI-'.$sale_invoice_id;
                }
            }else{
                if ($delivery_order->doi_status != null || $delivery_order->doi_status != 0) {
                    $id = $delivery_order->doi_status;
                    $delivery_order->doi_status = $id . ',' . 'STSI-'.$sale_invoice_id;
                } else {
                    $delivery_order->doi_status = 'STSI-'.$sale_invoice_id;
                }
            }
            $delivery_order->doi_due_qty = $delivery_order->doi_due_qty - $qty;
            $delivery_order->save();
        }

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {

            DB::commit();
//            return redirect()->back()->with(['si_id' => $sale_invoice_id, 'success' => 'Successfully Saved']);
            return redirect()->back()->with(['dostsi_id' => $sale_invoice_id]);
        }
    }

    public
    function delivery_order_sale_invoice_validation($request)
    {
        return $this->validate($request, [
            'account_name' => ['required', 'numeric'],
            "package" => ['nullable', 'string'],
            "remarks" => ['nullable', 'string'],
            "customer_name" => ['nullable', 'string'],
            "invoice_type" => ['required', 'numeric'],
            "discount_type" => ['required', 'numeric'],
            "total_items" => ['required', 'string', 'gt:0'],
            "total_price" => ['required', 'numeric'],
            "total_product_discount" => ['nullable', 'numeric'],
            "round_off_discount" => ['nullable', 'numeric'],
            "disc_percentage" => ['nullable', 'numeric'],
            "disc_amount" => ['nullable', 'numeric'],
            "total_discount" => ['nullable', 'numeric'],
            "total_inclusive_tax" => ['nullable', 'numeric'],
            "total_exclusive_tax" => ['nullable', 'numeric'],
            "total_tax" => ['nullable', 'numeric'],
            "grand_total" => ['required', 'numeric', 'gt:0'],
            "cash_paid" => ['nullable', 'numeric'],
            "cash_return" => ['nullable', 'numeric'],
            'customer_email' => ['nullable', 'string', 'email'],
            'credit_card_number' => ['nullable', 'numeric'],
            'customer_phone_number' => ['nullable', 'numeric'],

            'product_or_service_status' => ['required', 'array'],
            'product_or_service_status.*' => ['required', 'string'],
            'pro_code' => ['required', 'array'],
            'pro_code.*' => ['required', 'string'],
            'pro_name' => ['required', 'array'],
            'pro_name.*' => ['required', 'string'],
            'product_remarks' => ['nullable', 'array'],
            'product_remarks.*' => ['nullable', 'string'],
            'unit_measurement' => ['nullable', 'array'],
            'unit_measurement.*' => ['nullable', 'string'],
            'warehouse' => ['nullable', 'array'],
            'warehouse.*' => ['nullable', 'numeric'],
            'quantity' => ['required', 'array'],
            'quantity.*' => ['required', 'numeric'],
            'bonus' => ['nullable', 'array'],
            'bonus.*' => ['nullable', 'numeric'],
            'rate' => ['required', 'array'],
            'rate.*' => ['required', 'numeric'],
            'product_inclusive_rate' => ['required', 'array'],
            'product_inclusive_rate.*' => ['required', 'numeric'],
            'product_discount' => ['required', 'array'],
            'product_discount.*' => ['required', 'numeric'],
            'product_discount_amount' => ['required', 'array'],
            'product_discount_amount.*' => ['required', 'numeric'],
            'product_sales_tax' => ['required', 'array'],
            'product_sales_tax.*' => ['required', 'numeric'],
            'product_sale_tax_amount' => ['required', 'array'],
            'product_sale_tax_amount.*' => ['required', 'numeric'],
            'amount' => ['required', 'array'],
            'amount.*' => ['required', 'numeric'],
        ]);
    }

    public
    function AssignDeliveryOrderSaleInvoiceValues($request, $sale_invoice, $day_end, $user, $prfx, $account_code, $account_name, $remarks, $total_item, $total_price, $product_disc, $round_off_disc,
                                                  $cash_disc_perc, $cash_disc_amount, $total_disc_amount, $inclusive_saletax, $exclusive_saletax, $total_saletax, $grand_total, $cash_paid, $invoice_no = 0)
    {//status 1 for products and 2 for services
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $col_party_code = $prfx . '_party_code';
        $col_party_name = $prfx . '_party_name';
        $col_posting_reference = $prfx . '_pr_id';
        $col_customer_name = $prfx . '_customer_name';
        $col_remarks = $prfx . '_remarks';
        $col_total_items = $prfx . '_total_items';
        $col_total_price = $prfx . '_total_price';
        $col_product_discount = $prfx . '_product_disc';
        $col_round_off_discount = $prfx . '_round_off_disc';
        $col_cash_disc_percentage = $prfx . '_cash_disc_per';
        $col_cash_disc_amount = $prfx . '_cash_disc_amount';
        $col_total_discount = $prfx . '_total_discount';
        $col_inclusive_sales_tax = $prfx . '_inclusive_sales_tax';
        $col_exclusive_sales_tax = $prfx . '_exclusive_sales_tax';
        $col_total_sales_tax = $prfx . '_total_sales_tax';
        $col_grand_total = $prfx . '_grand_total';
        $col_cash_paid = $prfx . '_cash_received';
        $col_datetime = $prfx . '_datetime';
        $col_day_end_id = $prfx . '_day_end_id';
        $col_day_end_date = $prfx . '_day_end_date';
        $col_createdby = $prfx . '_createdby';
        $col_detail_remarks = $prfx . '_detail_remarks';
        $col_ip_adrs = $prfx . '_ip_adrs';
        $col_brwsr_info = $prfx . '_brwsr_info';
        $col_update_datetime = $prfx . '_update_datetime';
        $col_invoice_number = $prfx . '_invoice_number';
        $col_email = $prfx . '_email';
        $col_credit_card_reference_number = $prfx . '_credit_card_reference_number';
        $col_phone_number = $prfx . '_phone_number';
        $col_delivery_order_id = $prfx . '_whatsapp';
        $col_invoice_transcation_type = $prfx . '_invoice_transcation_type';
        $col_invoice_machine_id = $prfx . '_invoice_machine_id';
        $col_invoice_machine_name = $prfx . '_invoice_machine_name';
        $col_invoice_percentage = $prfx . '_service_charges_percentage';
        $col_return_amount = $prfx . '_return_amount';
        $col_cash_received_from_customer = $prfx . '_cash_received_from_customer';
        $col_discount_type = $prfx . '_discount_type';

        $sale_invoice->$col_party_code = $account_code;
        $sale_invoice->$col_party_name = $account_name;
        $sale_invoice->$col_posting_reference = ucwords($request->posting_reference);
        $sale_invoice->$col_customer_name = ucwords($request->customer_name);
        $sale_invoice->$col_remarks = ucfirst($remarks);
        $sale_invoice->$col_total_items = $total_item;
        $sale_invoice->$col_total_price = $total_price;
        $sale_invoice->$col_product_discount = $product_disc;
        $sale_invoice->$col_round_off_discount = $round_off_disc == '' ? 0 : $round_off_disc;
        $sale_invoice->$col_cash_disc_percentage = $cash_disc_perc == '' ? 0 : $cash_disc_perc;
        $sale_invoice->$col_cash_disc_amount = $cash_disc_amount == '' ? 0 : $cash_disc_amount;
        $sale_invoice->$col_total_discount = $total_disc_amount == '' ? 0 : $total_disc_amount;
        $sale_invoice->$col_inclusive_sales_tax = $inclusive_saletax == '' ? 0 : $inclusive_saletax;
        $sale_invoice->$col_exclusive_sales_tax = $exclusive_saletax == '' ? 0 : $exclusive_saletax;
        $sale_invoice->$col_total_sales_tax = $total_saletax == '' ? 0 : $total_saletax;
        $sale_invoice->$col_grand_total = $grand_total;
        $sale_invoice->$col_cash_paid = $cash_paid;
        $sale_invoice->$col_discount_type = $request->discount_type;
        $do_ids = str_replace(array('"', '[', ']'), '', $request->invoice_nbr);
        $sale_invoice->$col_delivery_order_id = 'DO-' . implode(',', $do_ids);

        $sale_invoice->$col_invoice_machine_id = $request->machine;
        $sale_invoice->$col_invoice_machine_name = $request->machine_name;
        $sale_invoice->$col_invoice_percentage = $request->percentage;


        $sale_invoice->$col_datetime = Carbon::now()->toDateTimeString();
        $sale_invoice->$col_day_end_id = $day_end->de_id;
        $sale_invoice->$col_day_end_date = $day_end->de_datetime;
        $sale_invoice->$col_createdby = $user->user_id;
        $sale_invoice->$col_brwsr_info = $brwsr_rslt;
        $sale_invoice->$col_ip_adrs = $ip_rslt;
        $sale_invoice->$col_update_datetime = Carbon::now()->toDateTimeString();

        if ($invoice_no > 0 && !empty($invoice_no)) {
            $sale_invoice->$col_invoice_number = $invoice_no;

            $account_head = substr($account_code, 0, 5);

            if ($account_head == config('global_variables.walk_in_customer_head')) {
                $sale_invoice->$col_cash_paid = $grand_total;
            }

        } else {
            $sale_invoice->$col_email = $request->customer_email;
            $sale_invoice->$col_credit_card_reference_number = $request->credit_card_number;
            $sale_invoice->$col_phone_number = $request->customer_phone_number;
            $sale_invoice->$col_return_amount = $request->cash_paid;
            $sale_invoice->$col_cash_received_from_customer = $request->cash_return;
        }

        return $sale_invoice;
    }

    public
    function AssignDeliveryOrderSaleInvoiceItemsValues($invoice_id, $array, $prfx, $status)
    {//status 1 for products and 2 for services

        $data = [];

        if ($status == 1) {

            foreach ($array as $value) {

                $average_rate = $this->product_stock_movement_last_row($value['product_code']);

                if (isset($average_rate)) {
                    $this->actual_stock_price += $average_rate->sm_bal_rate * $value['product_qty'];
                } else {

                    $purchase_rate = $this->get_product_purchase_rate($value['product_code']);

                    $this->actual_stock_price += $purchase_rate * $value['product_qty'];
                }


                $this->product_total_rate += $value['product_qty'] * $value['product_rate'];

                $sale_invoice = $prfx . '_invoice_id';
                $product_code = $prfx . '_product_code';
                $product_name = $prfx . '_product_name';
                $remarks = $prfx . '_remarks';
                $warehouse = $prfx . '_warehouse_id';
                $qty = $prfx . '_qty';
                $uom = $prfx . '_uom';
                $scale_size = $prfx . '_scale_size';
                $rate = $prfx . '_rate';
                $bonus_qty = $prfx . '_bonus_qty';
                $discount_per = $prfx . '_discount_per';
                $discount_amount = $prfx . '_discount_amount';
                $after_dis_rate = $prfx . '_after_dis_rate';
                $net_rate = $prfx . '_net_rate';
                $saletax_per = $prfx . '_saletax_per';
                $saletax_inclusive = $prfx . '_saletax_inclusive';
                $saletax_amount = $prfx . '_saletax_amount';
                $amount = $prfx . '_amount';


                $data[] = [
                    $sale_invoice => $invoice_id,
                    $product_code => $value['product_code'],
                    $product_name => ucwords($value['product_name']),
                    $remarks => ucfirst($value['product_remarks']),
                    $warehouse => ucfirst($value['warehouse']),
                    $qty => $value['product_qty'],
                    $uom => $value['product_unit_measurement'],
                    $scale_size => $value['product_unit_measurement_scale_size'],
                    $bonus_qty => $value['product_bonus_qty'],
                    $rate => $value['product_rate'],
                    $net_rate => $value['product_inclusive_rate'],
                    $discount_per => $value['product_discount'],
                    $discount_amount => $value['product_discount_amount'],
                    $after_dis_rate => $value['product_rate'] - ($value['product_discount_amount'] / $value['product_qty']),
                    $saletax_per => $value['product_sale_tax'],
                    $saletax_inclusive => $value['inclusive_exclusive_status'],
                    $saletax_amount => $value['product_sale_tax_amount'],
                    $amount => $value['product_amount'],
                ];
            }
        } else {
            foreach ($array as $value) {

                $service_invoice = $prfx . '_invoice_id';
                $service_code = $prfx . '_service_code';
                $service_name = $prfx . '_service_name';
                $remarks = $prfx . '_remarks';
                $qty = $prfx . '_qty';
                $rate = $prfx . '_rate';
                $discount_per = $prfx . '_discount_per';
                $discount_amount = $prfx . '_discount_amount';
                $after_dis_rate = $prfx . '_after_dis_rate';
                $net_rate = $prfx . '_net_rate';
                $saletax_per = $prfx . '_saletax_per';
                $saletax_inclusive = $prfx . '_saletax_inclusive';
                $saletax_amount = $prfx . '_saletax_amount';
                $amount = $prfx . '_amount';


                $data[] = [
                    $service_invoice => $invoice_id,
                    $service_code => $value['service_code'],
                    $service_name => ucwords($value['service_name']),
                    $remarks => ucfirst($value['service_remarks']),
                    $qty => $value['service_qty'],
                    $rate => $value['service_rate'],
                    $net_rate => $value['service_inclusive_rate'],
                    $discount_per => $value['service_discount'],
                    $discount_amount => $value['service_discount_amount'],
                    $after_dis_rate => $value['service_rate'] - $value['service_discount_amount'],
                    $saletax_per => $value['service_sale_tax'],
                    $saletax_inclusive => $value['service_inclusive_exclusive_status'],
                    $saletax_amount => $value['service_sale_tax_amount'],
                    $amount => $value['service_amount'],
                ];
            }
        }

        return $data;
    }

    public
    function AssignDeliveryOrderSaleQtyHoldValues($invoice_id, $delivery_order_id, $invoice_type, $array, $prfx, $status)
    {//status 1 for products and 2 for services

        $data = [];

        foreach ($array as $value) {

            $qty = DeliveryOrderQuantityHoldModel::where('doqh_product_code', $value['product_code'])->where('doqh_warehouse_id', $value['warehouse'])->orderBy('doqh_id', 'DESC')->first();

            $dc_invoice = $prfx . '_do_id';
            $sale_invoice = $prfx . '_sale_invoice_id';
            $sale_tax_invoice = $prfx . '_sale_tax_id';
            $product_code = $prfx . '_product_code';
            $warehouse = $prfx . '_warehouse_id';
            $sale_qty = $prfx . '_sale_qty';
            $balance_qty = $prfx . '_balance_qty';
            $invoice_no='';
            $invoice_sale_tax_no='';
            if ($invoice_type == 1) {
                $invoice_no=$invoice_id;
            }else{
                $invoice_sale_tax_no=$invoice_id;
            }
            $data[] = [
                $dc_invoice => $value['delivery_order_id'],

                $sale_invoice => $invoice_no,
                $sale_tax_invoice => $invoice_sale_tax_no,

                $product_code => $value['product_code'],
                $warehouse => $value['warehouse'],
                $sale_qty => $value['product_qty'],
                $balance_qty => $qty->doqh_balance_qty - $value['product_qty'],

            ];
        }

        return $data;
    }
}
