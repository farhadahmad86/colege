<?php

namespace App\Http\Controllers\SimpleInvoices;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\DayEndController;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\CashPaymentVoucherItemsModel;
use App\Models\CashPaymentVoucherModel;
use App\Models\PostingReferenceModel;
use App\Models\ProductModel;
use App\Models\PurchaseInvoiceItemsModel;
use App\Models\PurchaseInvoiceModel;
use App\Models\PurchaseReturnSaletaxInvoiceItemsModel;
use App\Models\PurchaseReturnSaletaxInvoiceModel;
use App\Models\PurchaseSaletaxInvoiceModel;
use App\Models\PurchaseSaletaxItemsInvoiceModel;
use App\Models\ReportConfigModel;
use App\Models\SystemConfigModel;
use App\Models\TransactionModel;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SimplePurchaseInvoiceController extends Controller
{
    public $invoice_total_value=0;

    public function simple_purchase_invoice()
    {
        $accounts = $this->get_account_query('purchase')[0];

        $products = $this->get_all_products();//->whereIn('pro_product_type_id',[2,3]);

        $pro_code = '';
        $pro_name = '';

        foreach ($products as $product) {
            $pro_title = $this->RemoveSpecialChar($product->pro_title);

            $pro_code .= "<option value='$product->pro_p_code' data-parent='$product->pro_p_code' data-purchase_price='$product->pro_last_purchase_rate' data-sale_price='$product->pro_sale_price' data-unit='$product->unit_title' data-unit_scale_size='$product->unit_scale_size' data-main_unit='$product->mu_title'> $product->pro_p_code</option>";
            $pro_name .= "<option value='$product->pro_p_code' data-parent='$product->pro_p_code' data-purchase_price='$product->pro_last_purchase_rate' data-sale_price='$product->pro_sale_price' data-unit='$product->unit_title' data-unit_scale_size='$product->unit_scale_size' data-main_unit='$product->mu_title'> $pro_title</option>";
        }

//        $warehouses = $this->get_all_warehouse();
        $posting_references = PostingReferenceModel::where('pr_disabled','=',0)->get();
        return view('Simple_Invoices/simple_purchase_invoice', compact('pro_code', 'pro_name'));
    }

    public function submit_simple_purchase_invoice(Request $request)
    {

        $this->purchase_invoice_validation($request);

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $rollBack = false;

        $purchase_array = [];

        $account_code = $request->account_name;
        $account_name = $this->get_account_name($account_code);
        $product_cash_discount_amount = $request->disc_amount;
        $product_total_discount_amount = $request->total_discount;
        $product_discount_amount = $request->total_product_discount;
        $product_round_off_discount_amount = $request->round_off_discount;
        $product_total_saletax = $request->total_tax;
        $product_grand_total = $request->grand_total;
        $invoice_type = $request->invoice_type;
        $cash_paid = $request->cash_paid;
        $requested_arrays = $request->pro_code;

        $product_cash_paid_ratio = 1;

        $product_cash_paid = $cash_paid * $product_cash_paid_ratio;
        $purchase_amount = $product_grand_total - $product_total_saletax + $product_total_discount_amount;

        $stock_amount = $product_grand_total - $product_total_saletax;

        foreach ($requested_arrays as $index => $requested_array) {

            $item_code = $request->pro_code[$index];
            $item_name = $request->pro_name[$index];
            $item_remarks = $request->product_remarks[$index];
            $item_warehouse = isset($request->warehouse[$index]) ? $request->warehouse[$index] : 0;
            $item_quantity = $request->quantity[$index];
            $item_unit_measurement = $request->unit_measurement[$index];
            $item_unit_measurement_scale_size = $request->unit_measurement_scale_size[$index];
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

            $purchase_array[] = [
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
        }


        $cash_in_hand = config('global_variables.cash_in_hand');
        $purchaser_account = config('global_variables.purchaser_account');
        $stock_in_hand = config('global_variables.stock_in_hand');
        $sale_tax_account = config('global_variables.purchase_sale_tax');
        $purchase_account = config('global_variables.purchase_account');
        $product_discount_account = config('global_variables.product_discount_account');
        $round_off_discount_account = config('global_variables.round_off_discount_account');
        $cash_discount_account = config('global_variables.cash_discount_account');


        $user = Auth::user();

        if ($user->user_role_id == config('global_variables.purchaser_role_id')) {

            $account = $this->get_teller_or_purchaser_account($user->user_id);

            $cash_in_hand = $account->user_purchaser_cash_account_uid;
            $purchaser_account = $account->user_purchaser_wic_account_uid;
        }
//        $cash_in_hand_account_name = $this->get_account_name($cash_in_hand);

        DB::beginTransaction();

        if ($invoice_type == 1) {

            $purchase_prefix = 'pi';
            $purchase_items_prefix = 'pii';

            $purchase_invoice = new PurchaseInvoiceModel();
            $purchase_item_table = 'financials_purchase_invoice_items';

            $notes = 'PURCHASE_INVOICE';

            $voucher_code = config('global_variables.PURCHASE_VOUCHER_CODE');
            $transaction_type = config('global_variables.PURCHASE');

        } else {

            $purchase_prefix = 'psi';
            $purchase_items_prefix = 'psii';

            $purchase_invoice = new PurchaseSaletaxInvoiceModel();
            $purchase_item_table = 'financials_purchase_saletax_invoice_items';

            $notes = 'PURCHASE_SALE_TAX_INVOICE';

            $voucher_code = config('global_variables.PURCHASE_SALE_TAX_VOUCHER_CODE');
            $transaction_type = config('global_variables.PURCHASE_SALE_TAX');
        }


        // system config set increment default id according to user giving start coding
        $chk_bnk_pymnt = $sstm_cnfg_clm = '';
        if ($notes === 'PURCHASE_INVOICE'):
            $chk_bnk_pymnt = PurchaseInvoiceModel::all();
            $sstm_cnfg_clm = 'sc_purchase_invoice_number';
        elseif ($notes === 'PURCHASE_SALE_TAX_INVOICE'):
            $chk_bnk_pymnt = PurchaseSaletaxInvoiceModel::all();
            $sstm_cnfg_clm = 'sc_purchase_st_invoice_number';
        endif;
        $sstm_cnfg_bp_id_chk = SystemConfigModel::where($sstm_cnfg_clm, '!=', '0')->first();
        if ($chk_bnk_pymnt->isEmpty()):
            if (isset($sstm_cnfg_bp_id_chk) && !empty($sstm_cnfg_bp_id_chk)):
                $set_id = $purchase_prefix . '_id';
                $purchase_invoice->$set_id = $sstm_cnfg_bp_id_chk->$sstm_cnfg_clm;
            endif;
        endif;
        // system config set increment default id according to user giving end coding


        //////////////////////////// Purchase Invoice Insertion ////////////////////////////////////

        $purchase_invoice = $this->AssignPurchaseInvoiceValues($request, $purchase_invoice, $day_end, $user, $purchase_prefix);

        if ($purchase_invoice->save()) {

            $p_id = $purchase_prefix . '_id';

            $purchase_invoice_id = $purchase_invoice->$p_id;
        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Purchase Invoice Items Insertion ////////////////////////////////////
        $items = [];
        $detail_remarks = '';

        $item = $this->AssignPurchaseInvoiceItemsValues($items, $purchase_invoice_id, $purchase_array, $purchase_items_prefix);

        foreach ($item as $value) {

            $pro_rate = (float)$value[$purchase_items_prefix . '_rate'];
            $pro_amount = (float)$value[$purchase_items_prefix . '_amount'];
            $qty = $value[$purchase_items_prefix . '_qty'];
            $scale_size = (float)$value[$purchase_items_prefix . '_scale_size'];
            $pack_qty = floor($qty / $scale_size);
            $loose_qty = fmod($qty, $scale_size);

            $detail_remarks .= $value[$purchase_items_prefix . '_product_name'] . ', QTY ' . $value[$purchase_items_prefix . '_qty'] . '@' . number_format($pro_rate, 2) . ' = ' . number_format
                ($pro_amount, 2) . ', Pack QTY = ' . $pack_qty . ', Loose QTY = ' . $loose_qty . config('global_variables.Line_Break');

//            $detail_remarks .= $value[$purchase_items_prefix . '_product_name'] . ', ' . $value[$purchase_items_prefix . '_qty'] . '@' . number_format($pro_rate, 2) . ' = ' . number_format($pro_amount, 2) . config('global_variables.Line_Break');
        }

        if (!DB::table($purchase_item_table)->insert($item)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Details Remarks of Purchase Invoice Insertion ////////////////////////////////////

        $purchase_detail_remarks = $purchase_prefix . '_detail_remarks';

        $purchase_invoice->$purchase_detail_remarks = $detail_remarks;

        if (!$purchase_invoice->save()) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }


        //////////////////////////// Product Inventory Insertion ////////////////////////////////////

//        $inventory = $this->AssignProductInventoryValues($purchase_array, 1);
//
//        if (!$inventory) {
//            $rollBack = true;
//            DB::rollBack();
//            return redirect()->back()->with('fail', 'Failed Try Again');
//        }

        //////////////////////////// Warehouse Stock Insertion ////////////////////////////////////

        $warehouses = [];
        $warehouse = $this->AssignWarehouseStocksValues($warehouses, $purchase_array, 1);

        if (!DB::table('financials_warehouse_stock')->insert($warehouse)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Warehouse Stock Summary Insertion ////////////////////////////////////
        $invoice_type_summary='';
        if ($invoice_type == 1){
            $invoice_type_summary='PURCHASE';
        }else{
            $invoice_type_summary='PURCHASE SALE TAX';
        }
        $warehouses_summary = [];
        $warehouse_stock_summary = $this->AssignWarehouseStocksSummaryValues($warehouses_summary, $purchase_array, $invoice_type_summary);

        if (!DB::table('financials_warehouse_stock_summary')->insert($warehouse_stock_summary)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Stock Movement Insertion ////////////////////////////////////

        $stock_movement = $this->stock_movement_module_purchase($purchase_array, $voucher_code . $purchase_invoice_id, 'PURCHASE', 'PURCHASE');

        if (!$stock_movement) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Stock Movement Child Insertion ////////////////////////////////////
        $stock_movement_child = $this->stock_movement_child($purchase_array,$purchase_invoice_id, $account_code, $account_name,'PURCHASE');

        if (!$stock_movement_child) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// TRANSACTION ONE STOCK IN HAND ////////////////////////////////////
//        dd($stock_in_hand,$stock_amount,$purchase_account, $purchase_amount,$sale_tax_account, $product_total_saletax,$account_code, $product_grand_total,$product_discount_account, $product_discount_amount,$round_off_discount_account, $product_round_off_discount_amount,$cash_discount_account, $product_cash_discount_amount);
        $transactions1 = new TransactionModel();
//        $transaction1 = $this->AssignTransactionsValues($transactions1, $stock_in_hand, $stock_amount, 0, $notes, $transaction_type, $purchase_invoice_id);//hamza
        $transaction1 = $this->AssignTransactionsValues($transactions1, $stock_in_hand, $this->invoice_total_value, 0, $notes, $transaction_type, $purchase_invoice_id);


        if ($transaction1->save()) {

            $transaction_id1 = $transaction1->trans_id;

            $balances1 = new BalancesModel();

//            $balance1 = $this->AssignAccountBalancesValues($balances1, $transaction_id1, $stock_in_hand, $stock_amount, 'Dr', $request->remarks,
//                $notes, $detail_remarks, $voucher_code . $purchase_invoice_id);//hamza
            $balance1 = $this->AssignAccountBalancesValues($balances1, $transaction_id1, $stock_in_hand, $this->invoice_total_value, 'Dr', $request->remarks, $notes, $detail_remarks, $voucher_code . $purchase_invoice_id, $request->posting_reference);

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


        //////////////////////////// TRANSACTION TWO PURCHASE ACCOUNT ////////////////////////////////////

        $transactions2 = new TransactionModel();
        $transaction2 = $this->AssignTransactionsValues($transactions2, $purchase_account, $purchase_amount, 0, $notes, $transaction_type, $purchase_invoice_id);


        if ($transaction2->save()) {

            $transaction_id2 = $transaction2->trans_id;

            $balances2 = new BalancesModel();

            $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id2, $purchase_account, $purchase_amount, 'Dr', $request->remarks,
                $notes, $detail_remarks, $voucher_code . $purchase_invoice_id, $request->posting_reference);

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
            $transaction3 = $this->AssignTransactionsValues($transactions3, $sale_tax_account, $product_total_saletax, 0, $notes, $transaction_type, $purchase_invoice_id);


            if ($transaction3->save()) {

                $transaction_id3 = $transaction3->trans_id;

                $balances3 = new BalancesModel();

                $balance3 = $this->AssignAccountBalancesValues($balances3, $transaction_id3, $sale_tax_account, $product_total_saletax, 'Dr', $request->remarks,
                    $notes, $detail_remarks, $voucher_code . $purchase_invoice_id, $request->posting_reference);

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
        $transaction4 = $this->AssignTransactionsValues($transactions4, 0, $product_grand_total, $account_code, $notes, $transaction_type, $purchase_invoice_id);


        if ($transaction4->save()) {

            $transaction_id4 = $transaction4->trans_id;

            $balances4 = new BalancesModel();

            $balance4 = $this->AssignAccountBalancesValues($balances4, $transaction_id4, $account_code, $product_grand_total, 'Cr', $request->remarks,
                $notes, $detail_remarks, $voucher_code . $purchase_invoice_id, $request->posting_reference);

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
            $transaction5 = $this->AssignTransactionsValues($transactions5, 0, $product_discount_amount, $product_discount_account, $notes, $transaction_type, $purchase_invoice_id);

            if ($transaction5->save()) {

                $transaction_id5 = $transaction5->trans_id;

                $balances5 = new BalancesModel();

                $balance5 = $this->AssignAccountBalancesValues($balances5, $transaction_id5, $product_discount_account, $product_discount_amount, 'Cr', $request->remarks,
                    $notes, $detail_remarks, $voucher_code . $purchase_invoice_id, $request->posting_reference);

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
            $transaction6 = $this->AssignTransactionsValues($transactions6, 0, $product_round_off_discount_amount, $round_off_discount_account, $notes, $transaction_type, $purchase_invoice_id);

            if ($transaction6->save()) {

                $transaction_id6 = $transaction6->trans_id;

                $balances6 = new BalancesModel();

                $balance6 = $this->AssignAccountBalancesValues($balances6, $transaction_id6, $round_off_discount_account, $product_round_off_discount_amount, 'Cr', $request->remarks,
                    $notes, $detail_remarks, $voucher_code . $purchase_invoice_id, $request->posting_reference);

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
            $transaction7 = $this->AssignTransactionsValues($transactions7, 0, $product_cash_discount_amount, $cash_discount_account, $notes, $transaction_type, $purchase_invoice_id);

            if ($transaction7->save()) {

                $transaction_id7 = $transaction7->trans_id;

                $balances7 = new BalancesModel();

                $balance7 = $this->AssignAccountBalancesValues($balances7, $transaction_id7, $cash_discount_account, $product_cash_discount_amount, 'Cr', $request->remarks,
                    $notes, $detail_remarks, $voucher_code . $purchase_invoice_id, $request->posting_reference);

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

//        if party pay cash or select purchaser account
        if ($account_code == $purchaser_account && $product_cash_paid > 0) {


            $cash_voucher_notes = 'CASH_PAYMENT_VOUCHER';
            $cash_voucher_voucher_code = config('global_variables.CASH_PAYMENT_VOUCHER_CODE');
            $cash_voucher_transaction_type = config('global_variables.CASH_PAYMENT');


            if ($account_code == $purchaser_account) {
                $product_cash_paid = $product_grand_total;
            }


            //////////////////////////// Cash Payment Voucher Insertion ////////////////////////////////////

            $cash_voucher = new CashPaymentVoucherModel();
            $cash_voucher_prefix = 'cp';

            $cash_voucher_remarks = $voucher_code . $purchase_invoice_id;

            $cash_voucher = $this->assign_cash_voucher_values($product_cash_paid, $cash_voucher_remarks, $cash_voucher, $day_end, $user, $cash_voucher_prefix, $cash_in_hand);

            if ($cash_voucher->save()) {

                $cv_id = $cash_voucher_prefix . '_id';

                $cash_voucher_id = $cash_voucher->$cv_id;
            } else {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            //////////////////////////// Cash Payment Voucher Items Insertion ////////////////////////////////////


            $cash_voucher_item = new CashPaymentVoucherItemsModel();
            $cash_voucher_item_prefix = 'cpi';

            $cash_voucher_item = $this->cash_voucher_items_values($account_code, $account_name, $product_cash_paid, '', $cash_voucher_item, $cash_voucher_id, $cash_voucher_item_prefix);

            $cash_voucher_detail_remarks = $cash_voucher_item[$cash_voucher_item_prefix . '_account_name'] . ', @' . $cash_voucher_item[$cash_voucher_item_prefix . '_amount'] . config('global_variables.Line_Break');

            if (!$cash_voucher_item->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            //////////////////////////// Cash Payment Voucher Detail Remarks Insertion ////////////////////////////////////

            $cv_detail_remarks = $cash_voucher_prefix . '_detail_remarks';

            $cash_voucher->$cv_detail_remarks = $cash_voucher_detail_remarks;
            $cash_voucher->save();


            //////////////////////////// TRANSACTION EIGHT CASH ACCOUNT ///////////////////////////////////////

            $transactions8 = new TransactionModel();
            $transaction8 = $this->AssignTransactionsValues($transactions8, 0, $product_cash_paid, $cash_in_hand, $cash_voucher_notes, $cash_voucher_transaction_type, $cash_voucher_id);

            if ($transaction8->save()) {

                $transaction_id8 = $transaction8->trans_id;

                $balances8 = new BalancesModel();

                $balance8 = $this->AssignAccountBalancesValues($balances8, $transaction_id8, $cash_in_hand, $product_cash_paid, 'Cr', $cash_voucher_remarks,
                    $cash_voucher_notes, $cash_voucher_detail_remarks, $cash_voucher_voucher_code . $cash_voucher_id, $request->posting_reference);

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


            //////////////////////////// TRANSACTION NINE CASH BACK ACCOUNT ///////////////////////////////////////

            $transactions9 = new TransactionModel();
            $transaction9 = $this->AssignTransactionsValues($transactions9, $account_code, $product_cash_paid, 0, $cash_voucher_notes, $cash_voucher_transaction_type, $cash_voucher_id);

            if ($transaction9->save()) {

                $transaction_id9 = $transaction9->trans_id;

                $balances9 = new BalancesModel();

                $balance9 = $this->AssignAccountBalancesValues($balances9, $transaction_id9, $account_code, $product_cash_paid, 'Dr', $cash_voucher_remarks,
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

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $purchase_invoice_id);

            DB::commit();
//            return redirect()->back()->with('success', 'Successfully Saved');
            return redirect()->back()->with(['pi_id' => $purchase_invoice_id]);
        }
    }

    public function purchase_invoice_validation($request)
    {
        return $this->validate($request, [
            'account_name' => ['required', 'numeric'],
            "remarks" => ['nullable', 'string'],
            "customer_name" => ['nullable', 'string'],
            "invoice_type" => ['required', 'numeric'],
            "total_items" => ['required', 'numeric', 'min:1'],
            "total_price" => ['required', 'numeric'],
            "total_product_discount" => ['nullable', 'numeric'],
            "round_off_discount" => ['nullable', 'numeric'],
            "disc_percentage" => ['nullable', 'numeric'],
            "disc_amount" => ['nullable', 'numeric'],
            "total_discount" => ['nullable', 'numeric'],
            "total_inclusive_tax" => ['nullable', 'numeric'],
            "total_exclusive_tax" => ['nullable', 'numeric'],
            "total_tax" => ['nullable', 'numeric'],
            "grand_total" => ['required', 'numeric'],
            "cash_paid" => ['nullable', 'numeric'],
            "cash_return" => ['nullable', 'numeric'],

            'product_or_service_status' => ['required', 'array'],
            'product_or_service_status.*' => ['required', 'string'],
            'pro_code' => ['required', 'array'],
            'pro_code.*' => ['required', 'string'],
            'pro_name' => ['required', 'array'],
            'pro_name.*' => ['required', 'string'],
            'product_remarks' => ['nullable', 'array'],
            'product_remarks.*' => ['nullable', 'string'],
            'warehouse' => ['required', 'array'],
            'warehouse.*' => ['required', 'string'],
            'quantity' => ['required', 'array'],
            'quantity.*' => ['required', 'numeric'],
            'unit_measurement' => ['nullable', 'array'],
            'unit_measurement.*' => ['nullable', 'string'],
            'bonus' => ['nullable', 'array'],
            'bonus.*' => ['nullable', 'numeric'],
            'rate' => ['required', 'array'],
            'rate.*' => ['required', 'numeric'],
            'product_inclusive_rate' => ['required', 'array'],
            'product_inclusive_rate.*' => ['required', 'numeric'],
            'product_discount' => ['nullable', 'array'],
            'product_discount.*' => ['nullable', 'numeric'],
            'product_discount_amount' => ['nullable', 'array'],
            'product_discount_amount.*' => ['nullable', 'numeric'],
            'product_sales_tax' => ['nullable', 'array'],
            'product_sales_tax.*' => ['nullable', 'numeric'],
            'product_sale_tax_amount' => ['nullable', 'array'],
            'product_sale_tax_amount.*' => ['nullable', 'numeric'],
            'amount' => ['required', 'array'],
            'amount.*' => ['required', 'numeric'],
        ]);
    }

    public function AssignPurchaseInvoiceValues($request, $purchase_invoice, $day_end, $user, $prfx, $invoice_no = 0)
    {
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $party_code = $prfx . '_party_code';
        $party_name = $prfx . '_party_name';
        $posting_reference = $prfx . '_pr_id';
        $customer_name = $prfx . '_customer_name';
        $remarks = $prfx . '_remarks';
        $total_items = $prfx . '_total_items';
        $total_price = $prfx . '_total_price';
        $product_discount = $prfx . '_product_disc';
        $round_off_discount = $prfx . '_round_off_disc';
        $cash_disc_percentage = $prfx . '_cash_disc_per';
        $cash_disc_amount = $prfx . '_cash_disc_amount';
        $total_discount = $prfx . '_total_discount';
        $inclusive_sales_tax = $prfx . '_inclusive_sales_tax';
        $exclusive_sales_tax = $prfx . '_exclusive_sales_tax';
        $total_sales_tax = $prfx . '_total_sales_tax';
        $grand_total = $prfx . '_grand_total';
        $cash_paid = $prfx . '_cash_paid';
        $datetime = $prfx . '_datetime';
        $day_end_id = $prfx . '_day_end_id';
        $day_end_date = $prfx . '_day_end_date';
        $createdby = $prfx . '_createdby';
        $detail_remarks = $prfx . '_detail_remarks';
        $ip_adrs = $prfx . '_ip_adrs';
        $brwsr_info = $prfx . '_brwsr_info';
        $update_datetime = $prfx . '_update_datetime';
        $invoice_number = $prfx . '_invoice_number';


        $purchase_invoice->$party_code = $request->account_name;
        $purchase_invoice->$party_name = $this->get_account_name($request->account_name);
        $purchase_invoice->$posting_reference = $request->posting_reference;
        $purchase_invoice->$customer_name = ucwords($request->customer_name);
        $purchase_invoice->$remarks = ucfirst($request->remarks);
        $purchase_invoice->$total_items = $request->total_items;
        $purchase_invoice->$total_price = $request->total_price;
        $purchase_invoice->$product_discount = $request->total_product_discount;
        $purchase_invoice->$round_off_discount = $request->round_off_discount == '' ? 0 : $request->round_off_discount;
        $purchase_invoice->$cash_disc_percentage = $request->disc_percentage == '' ? 0 : $request->disc_percentage;
        $purchase_invoice->$cash_disc_amount = $request->disc_amount == '' ? 0 : $request->disc_amount;
        $purchase_invoice->$total_discount = $request->total_discount == '' ? 0 : $request->total_discount;
        $purchase_invoice->$inclusive_sales_tax = $request->total_inclusive_tax == '' ? 0 : $request->total_inclusive_tax;
        $purchase_invoice->$exclusive_sales_tax = $request->total_exclusive_tax == '' ? 0 : $request->total_exclusive_tax;
        $purchase_invoice->$total_sales_tax = $request->total_tax == '' ? 0 : $request->total_tax;
        $purchase_invoice->$cash_paid = $request->cash_paid;

        $account_head = substr($request->account_name, 0, 5);

        if ($account_head == config('global_variables.purchaser_account_head')) {
            $purchase_invoice->$cash_paid = $request->grand_total;
        }

        $purchase_invoice->$grand_total = $request->grand_total;
        $purchase_invoice->$datetime = Carbon::now()->toDateTimeString();
        $purchase_invoice->$day_end_id = $day_end->de_id;
        $purchase_invoice->$day_end_date = $day_end->de_datetime;
        $purchase_invoice->$createdby = $user->user_id;

        if ($invoice_no > 0 && !empty($invoice_no)) {
            $purchase_invoice->$invoice_number = $invoice_no;
        }

        $purchase_invoice->$brwsr_info = $brwsr_rslt;
        $purchase_invoice->$ip_adrs = $ip_rslt;
        $purchase_invoice->$update_datetime = Carbon::now()->toDateTimeString();

        return $purchase_invoice;
    }

    public function AssignPurchaseInvoiceItemsValues($data, $purchase_invoice_id, $array, $prfx)
    {
        foreach ($array as $value) {

            $purchase_invoice = $prfx . '_purchase_invoice_id';
            $product_code = $prfx . '_product_code';
            $product_name = $prfx . '_product_name';
            $remarks = $prfx . '_remarks';
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
            $warehouse_id = $prfx . '_warehouse_id';

            $data[] = [
                $purchase_invoice => $purchase_invoice_id,
                $product_code => $value['product_code'],
                $product_name => $value['product_name'],
                $warehouse_id => $value['warehouse'],
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
                $remarks => $value['product_remarks'],
            ];
        }

        return $data;
    }


    // update code by shahzaib start
    public function simple_purchase_invoice_list(Request $request, $array = null, $str = null)
    {
        $heads = config('global_variables.payable_receivable_cash');
        $heads = explode(',', $heads);

        $accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)->orderBy('account_name', 'ASC')->get();
        $products = ProductModel::orderBy('pro_id', 'ASC')->get();
        $posting_references = PostingReferenceModel::all();
        $pro_code = '';
        $pro_name = '';

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_account = (!isset($request->account) && empty($request->account)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->account;
        $search_product = (!isset($request->product) && empty($request->product)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->product;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->from;
        $search_posting_reference = (!isset($request->posting) && empty($request->posting)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->posting;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.purchase_invoice_list.purchase_invoice_list';
        $pge_title = 'Purchase Invoice List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_account, $search_product, $search_posting_reference,$search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        foreach ($products as $product) {
            $selected = $product->pro_p_code == $search_product ? 'selected' : '';
            $pro_code .= "<option value='$product->pro_p_code' data-parent='$product->pro_p_code' $selected>$product->pro_p_code</option>";
            $pro_name .= "<option value='$product->pro_p_code' data-parent='$product->pro_p_code' $selected>$product->pro_title</option>";
        }

        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

//        dd($search_product);


//        $query = PurchaseInvoiceModel::query();
        $query = DB::table('financials_purchase_invoice')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_purchase_invoice.pi_createdby')
            ->leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_purchase_invoice.pi_pr_id');

        $posting_references = PostingReferenceModel::where('pr_disabled','=',0)->get();



        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('pi_party_code', 'like', '%' . $search . '%')
                    ->orWhere('pi_party_name', 'like', '%' . $search . '%')
                    ->orWhere('pi_remarks', 'like', '%' . $search . '%')
                    ->orWhere('pi_id', 'like', '%' . $search . '%')
                    ->orWhere('user_designation', 'like', '%' . $search . '%')
                    ->orWhere('user_name', 'like', '%' . $search . '%')
                    ->orWhere('user_username', 'like', '%' . $search . '%');
            });
        }

        if (!empty($search_account)) {
            $query->where('pi_party_code', $search_account);
        }

        if (!empty($search_product)) {
            $get_p_id = PurchaseInvoiceItemsModel::where('pii_product_code', $search_product)->pluck('pii_purchase_invoice_id')->all();
            $query->whereIn('pi_id', $get_p_id);
        }

        if (!empty($search_posting_reference)) {
            $query->where('pi_pr_id', $search_posting_reference);
        }

        if (!empty($search_by_user)) {
            $query->where('pi_pr_id', $search_by_user);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('pi_day_end_date', [$start, $end]);
            $query->whereDate('pi_day_end_date', '>=', $start)
                ->whereDate('pi_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('pi_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('pi_day_end_date', $end);
        }


        $datas = $query->orderBy('pi_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

        $party = AccountRegisterationModel::whereIn('account_parent_code', $heads)->orderBy('account_name', 'ASC')->pluck('account_name')->all();


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];

            $pdf = PDF::loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('purchase_invoice_list', compact('posting_references','datas', 'search', 'party', 'accounts', 'search_account', 'search_product', 'pro_code', 'pro_name', 'search_to', 'search_from', 'search_by_user', 'search_posting_reference'));
        }

    }
    // update code by shahzaib end


    public function simple_purchase_items_view_details(Request $request)
    {
        $items = PurchaseInvoiceItemsModel::where('pii_purchase_invoice_id', $request->id)->orderby('pii_product_name', 'ASC')->get();

        return response()->json($items);
    }

    public function simple_purchase_items_view_details_SH(Request $request, $id)
    {
        $urdu_eng = ReportConfigModel::where('rc_id', '=', 1)->select('rc_invoice', 'rc_invoice_party')->first();

        if ($urdu_eng->rc_invoice_party == 0) {
            $pim = PurchaseInvoiceModel::Join('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_purchase_invoice.pi_pr_id')->where('pi_id', $id)->first();
        } else {
            $pim = DB::table('financials_purchase_invoice')
                ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_purchase_invoice.pi_party_code')
                ->Join('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_purchase_invoice.pi_pr_id')
                ->where('pi_id', $id)
                ->select('financials_accounts.account_urdu_name as pi_party_name', 'pi_id', 'pi_party_code', 'pi_customer_name', 'pi_remarks', 'pi_total_items', 'pi_total_price', 'pi_product_disc', 'pi_round_off_disc',
                    'pi_cash_disc_per', 'pi_cash_disc_amount', 'pi_total_discount', 'pi_inclusive_sales_tax', 'pi_exclusive_sales_tax', 'pi_total_sales_tax', 'pi_grand_total', 'pi_cash_paid', 'pi_day_end_id', 'pi_day_end_date', 'pi_createdby','pr_name')->first();
        }


        $accnts = AccountRegisterationModel::where('account_uid', $pim->pi_party_code)->first();
        if ($urdu_eng->rc_invoice == 0) {
            $piims = PurchaseInvoiceItemsModel::where('pii_purchase_invoice_id', $id)
//            ->select('pii_product_name as name', 'pii_remarks as remarks', 'pii_qty as qty', 'pii_rate as rate', 'pii_discount as discount', 'pii_saletax as sale_tax', 'pii_amount as amount')
                ->select('pii_product_name as name', 'pii_remarks as remarks', 'pii_qty as qty', 'pii_rate as rate', 'pii_discount_per as discount', 'pii_discount_amount as discount_amount', 'pii_after_dis_rate as after_discount', 'pii_saletax_per as sale_tax', 'pii_saletax_amount as sale_tax_amount', 'pii_saletax_inclusive as inclu_exclu', 'pii_amount as amount', 'pii_scale_size as scale_size')
                ->orderby('pii_product_name', 'ASC')
                ->get();

        } else {
            $piims = DB::table('financials_purchase_invoice_items')
                ->join('financials_products', 'financials_products.pro_p_code', '=', 'financials_purchase_invoice_items.pii_product_code')
                ->where('pii_purchase_invoice_id', $id)

//                PurchaseInvoiceItemsModel::where('pii_purchase_invoice_id', $id)

                ->select('financials_products.pro_urdu_title as name', 'pii_remarks as remarks', 'pii_qty as qty', 'pii_rate as rate', 'pii_discount_per as discount', 'pii_discount_amount as discount_amount', 'pii_after_dis_rate as after_discount', 'pii_saletax_per as sale_tax', 'pii_saletax_amount as sale_tax_amount', 'pii_saletax_inclusive as inclu_exclu', 'pii_amount as amount', 'pii_scale_size as scale_size')
                ->orderby('financials_products.pro_urdu_title', 'ASC')
                ->get();

        }

        $nbrOfWrds = $this->myCnvrtNbr($pim->pi_grand_total);
        $invoice_nbr = $pim->pi_id;
        $invoice_date = $pim->pi_day_end_date;
        $type = 'grid';
        $pge_title = 'Purchase Invoice';

        return view('invoice_view.purchase_invoice.purchase_invoice_list_modal', compact('piims', 'pim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title','urdu_eng'));
    }

    public function simple_purchase_items_view_details_pdf_SH(Request $request, $id)
    {
        $urdu_eng = ReportConfigModel::where('rc_id', '=', 1)->select('rc_invoice', 'rc_invoice_party')->first();

        if ($urdu_eng->rc_invoice_party == 0) {
            $pim = PurchaseInvoiceModel::Join('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_purchase_invoice.pi_pr_id')->where('pi_id', $id)->first();
        } else {
            $pim = DB::table('financials_purchase_invoice')
                ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_purchase_invoice.pi_party_code')
                ->Join('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_purchase_invoice.pi_pr_id')
                ->where('pi_id', $id)
                ->select('financials_accounts.account_urdu_name as pi_party_name', 'pi_id', 'pi_party_code', 'pi_customer_name', 'pi_remarks', 'pi_total_items', 'pi_total_price', 'pi_product_disc', 'pi_round_off_disc',
                    'pi_cash_disc_per', 'pi_cash_disc_amount', 'pi_total_discount', 'pi_inclusive_sales_tax', 'pi_exclusive_sales_tax', 'pi_total_sales_tax', 'pi_grand_total', 'pi_cash_paid', 'pi_day_end_id', 'pi_day_end_date', 'pi_createdby','pr_name')->first();
        }


        $accnts = AccountRegisterationModel::where('account_uid', $pim->pi_party_code)->first();

        if ($urdu_eng->rc_invoice == 0) {
            $piims = PurchaseInvoiceItemsModel::where('pii_purchase_invoice_id', $id)
//            ->select('pii_product_name as name', 'pii_remarks as remarks', 'pii_qty as qty', 'pii_rate as rate', 'pii_discount as discount', 'pii_saletax as sale_tax', 'pii_amount as amount')
                ->select('pii_product_name as name', 'pii_remarks as remarks', 'pii_qty as qty', 'pii_rate as rate', 'pii_discount_per as discount', 'pii_discount_amount as discount_amount', 'pii_after_dis_rate as after_discount', 'pii_saletax_per as sale_tax', 'pii_saletax_amount as sale_tax_amount', 'pii_saletax_inclusive as inclu_exclu', 'pii_amount as amount', 'pii_scale_size as scale_size')
                ->orderby('pii_product_name', 'ASC')
                ->get();

        } else {
            $piims = DB::table('financials_purchase_invoice_items')
                ->join('financials_products', 'financials_products.pro_p_code', '=', 'financials_purchase_invoice_items.pii_product_code')
                ->where('pii_purchase_invoice_id', $id)

//                PurchaseInvoiceItemsModel::where('pii_purchase_invoice_id', $id)

                ->select('financials_products.pro_urdu_title as name', 'pii_remarks as remarks', 'pii_qty as qty', 'pii_rate as rate', 'pii_discount_per as discount', 'pii_discount_amount as discount_amount', 'pii_after_dis_rate as after_discount', 'pii_saletax_per as sale_tax', 'pii_saletax_amount as sale_tax_amount', 'pii_saletax_inclusive as inclu_exclu', 'pii_amount as amount', 'pii_scale_size as scale_size')
                ->orderby('financials_products.pro_urdu_title', 'ASC')
                ->get();

        }
        $nbrOfWrds = $this->myCnvrtNbr($pim->pi_grand_total);
        $invoice_nbr = $pim->pi_id;
        $invoice_date = $pim->pi_day_end_date;
        $type = 'pdf';
        $pge_title = 'Purchase Invoice';

        $footer = view('invoice_view._partials.pdf_footer')->render();
        $header = view('invoice_view._partials.pdf_header', compact('invoice_nbr', 'invoice_date', 'pge_title', 'type'))->render();
        $options = [
            'footer-html' => $footer,
            'header-html' => $header,
            'margin-top' => 24,
        ];

        $pdf = PDF::loadView('invoice_view.purchase_invoice.purchase_invoice_list_modal', compact('piims', 'pim', 'nbrOfWrds', 'accnts', 'invoice_nbr', 'invoice_date', 'type', 'pge_title','urdu_eng'));
        $pdf->setOptions($options);

        return $pdf->stream('Purchase-Invoice.pdf');
    }


    // update code by shahzaib start
    public function sale_tax_purchase_invoice_list(Request $request, $array = null, $str = null)
    {
        $heads = config('global_variables.payable_receivable_cash');
        $heads = explode(',', $heads);

        $accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)->orderBy('account_name', 'ASC')->get();
        $products = ProductModel::orderBy('pro_id', 'ASC')->get();
        $posting_references = PostingReferenceModel::all();

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_account = (!isset($request->account) && empty($request->account)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->account;
        $search_product = (!isset($request->product) && empty($request->product)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->product;
        $search_posting_reference = (!isset($request->posting) && empty($request->posting)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->posting;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.sale_tax_purchase_invoice_list.sale_tax_purchase_invoice_list';
        $pge_title = 'Sale Tax Purchase Invoice List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_account, $search_product, $search_posting_reference, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $pro_code = '';
        $pro_name = '';


        foreach ($products as $product) {
            $selected = $product->pro_p_code == $search_product ? 'selected' : '';
            $pro_code .= "<option value='$product->pro_p_code' data-parent='$product->pro_p_code' $selected>$product->pro_p_code</option>";
            $pro_name .= "<option value='$product->pro_p_code' data-parent='$product->pro_p_code' $selected>$product->pro_title</option>";
        }


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));


//        $query = PurchaseInvoiceModel::query();
        $query = DB::table('financials_purchase_saletax_invoice')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_purchase_saletax_invoice.psi_createdby')
            ->leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_purchase_saletax_invoice.psi_pr_id');

        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('psi_party_code', 'like', '%' . $search . '%')
                    ->orWhere('psi_party_name', 'like', '%' . $search . '%')
                    ->orWhere('psi_remarks', 'like', '%' . $search . '%')
                    ->orWhere('psi_id', 'like', '%' . $search . '%')
                    ->orWhere('user_designation', 'like', '%' . $search . '%')
                    ->orWhere('user_name', 'like', '%' . $search . '%')
                    ->orWhere('user_username', 'like', '%' . $search . '%');
            });
        }

        if (!empty($search_account)) {
            $query->where('psi_party_code', $search_account);
        }
        if (!empty($search_posting_reference)) {
            $query->where('psi_pr_id', $search_posting_reference);
        }

        if (!empty($search_product)) {
            $get_p_id = PurchaseSaletaxItemsInvoiceModel::where('psii_product_code', $search_product)->pluck('psii_invoice_id')->all();
            $query->whereIn('psi_id', $get_p_id);
        }

        if (!empty($search_by_user)) {
            $query->where('psi_createdby', $search_by_user);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('pi_day_end_date', [$start, $end]);
            $query->whereDate('psi_day_end_date', '>=', $start)
                ->whereDate('psi_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('psi_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('psi_day_end_date', $end);
        }


        $datas = $query->orderBy('psi_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

        $party = AccountRegisterationModel::whereIn('account_parent_code', $heads)->orderBy('account_name', 'ASC')->pluck('account_name')->all();


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];

            $pdf = PDF::loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('purchase_invoice_sale_tax_list', compact('datas', 'search', 'party', 'accounts', 'search_account', 'search_product', 'pro_name', 'pro_code', 'search_to', 'search_from', 'search_by_user', 'posting_references','search_posting_reference'));
        }
    }

    // update code by shahzaib end

    public function sale_tax_purchase_items_view_details_SH(Request $request, $id)
    {
        $urdu_eng = ReportConfigModel::where('rc_id', '=', 1)->select('rc_invoice','rc_invoice_party')->first();
        if ($urdu_eng->rc_invoice_party == 0){
            $pim = PurchaseSaletaxInvoiceModel::Join('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_purchase_saletax_invoice.psi_pr_id')->where('psi_id', $id)->first();
        }else{
            $pim = DB::table('financials_purchase_saletax_invoice')
                ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_purchase_saletax_invoice.psi_party_code')
                ->Join('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_purchase_saletax_invoice.psi_pr_id')
                ->where('psi_id', $id)
                ->select('financials_accounts.account_urdu_name as psi_party_name','psi_id','psi_party_code','psi_customer_name','psi_remarks','psi_total_items','psi_total_price',
                    'psi_product_disc','psi_round_off_disc',
                    'psi_cash_disc_per','psi_cash_disc_amount','psi_total_discount','psi_inclusive_sales_tax','psi_exclusive_sales_tax','psi_total_sales_tax','psi_grand_total','psi_cash_paid','psi_day_end_id','psi_day_end_date','psi_createdby','pr_name')->first();
        }

        $accnts = AccountRegisterationModel::where('account_uid', $pim->psi_party_code)->first();

        if($urdu_eng->rc_invoice == 0) {
            $piims = PurchaseSaletaxItemsInvoiceModel::where('psii_purchase_invoice_id', $id)
                ->select('psii_product_name as name', 'psii_remarks as remarks', 'psii_qty as qty', 'psii_rate as rate', 'psii_discount_per as discount', 'psii_discount_amount as discount_amount', 'psii_after_dis_rate as after_discount', 'psii_saletax_per as sale_tax', 'psii_saletax_amount as sale_tax_amount', 'psii_saletax_inclusive as inclu_exclu', 'psii_amount as amount', 'psii_scale_size as scale_size')
                ->orderby('psii_product_name', 'ASC')
                ->get();
        }else{
            $piims =DB::table('financials_purchase_saletax_invoice_items')
                ->join('financials_products','financials_products.pro_p_code','=','financials_purchase_saletax_invoice_items.psii_product_code')
                ->where('psii_purchase_invoice_id', $id)

                ->select('financials_products.pro_urdu_title as name', 'psii_remarks as remarks', 'psii_qty as qty', 'psii_rate as rate', 'psii_discount_per as discount', 'psii_discount_amount as discount_amount', 'psii_after_dis_rate as after_discount', 'psii_saletax_per as sale_tax', 'psii_saletax_amount as sale_tax_amount', 'psii_saletax_inclusive as inclu_exclu', 'psii_amount as amount', 'psii_scale_size as scale_size')
                ->orderby('financials_products.pro_urdu_title', 'ASC')
                ->get();
        }


        $nbrOfWrds = $this->myCnvrtNbr($pim->psi_grand_total);
        $invoice_nbr = $pim->psi_id;
        $invoice_date = $pim->psi_day_end_date;
        $type = 'grid';
        $pge_title = 'Sale Tax Purchase Invoice';

        return view('invoice_view.purchase_sale_tax_invoice.purchase_sale_tax_invoice_list_modal', compact('piims', 'pim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title', 'urdu_eng'));

    }

    public function sale_tax_purchase_items_view_details_pdf_SH(Request $request, $id)
    {
        $urdu_eng = ReportConfigModel::where('rc_id', '=', 1)->select('rc_invoice','rc_invoice_party')->first();
        if ($urdu_eng->rc_invoice_party == 0){
            $pim = PurchaseSaletaxInvoiceModel::Join('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_purchase_saletax_invoice.psi_pr_id')->where('psi_id', $id)->first();
        }else{
            $pim = DB::table('financials_purchase_saletax_invoice')
                ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_purchase_saletax_invoice.psi_party_code')
                ->Join('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_purchase_saletax_invoice.psi_pr_id')
                ->where('psi_id', $id)
                ->select('financials_accounts.account_urdu_name as psi_party_name','psi_id','psi_party_code','psi_customer_name','psi_remarks','psi_total_items','psi_total_price',
                    'psi_product_disc','psi_round_off_disc',
                    'psi_cash_disc_per','psi_cash_disc_amount','psi_total_discount','psi_inclusive_sales_tax','psi_exclusive_sales_tax','psi_total_sales_tax','psi_grand_total','psi_cash_paid','psi_day_end_id','psi_day_end_date','psi_createdby','pr_name')->first();
        }

        $accnts = AccountRegisterationModel::where('account_uid', $pim->psi_party_code)->first();

        if($urdu_eng->rc_invoice == 0) {
            $piims = PurchaseSaletaxItemsInvoiceModel::where('psii_purchase_invoice_id', $id)
                ->select('psii_product_name as name', 'psii_remarks as remarks', 'psii_qty as qty', 'psii_rate as rate', 'psii_discount_per as discount', 'psii_discount_amount as discount_amount', 'psii_after_dis_rate as after_discount', 'psii_saletax_per as sale_tax', 'psii_saletax_amount as sale_tax_amount', 'psii_saletax_inclusive as inclu_exclu', 'psii_amount as amount', 'psii_scale_size as scale_size')
                ->orderby('psii_product_name', 'ASC')
                ->get();
        }else{
            $piims =DB::table('financials_purchase_saletax_invoice_items')
                ->join('financials_products','financials_products.pro_p_code','=','financials_purchase_saletax_invoice_items.psii_product_code')
                ->where('psii_purchase_invoice_id', $id)

                ->select('financials_products.pro_urdu_title as name', 'psii_remarks as remarks', 'psii_qty as qty', 'psii_rate as rate', 'psii_discount_per as discount', 'psii_discount_amount as discount_amount', 'psii_after_dis_rate as after_discount', 'psii_saletax_per as sale_tax', 'psii_saletax_amount as sale_tax_amount', 'psii_saletax_inclusive as inclu_exclu', 'psii_amount as amount', 'psii_scale_size as scale_size')
                ->orderby('financials_products.pro_urdu_title', 'ASC')
                ->get();
        }

        $nbrOfWrds = $this->myCnvrtNbr($pim->psi_grand_total);
        $invoice_nbr = $pim->psi_id;
        $invoice_date = $pim->psi_day_end_date;
        $type = 'pdf';
        $pge_title = 'Sale Tax Purchase Invoice';


        $footer = view('invoice_view._partials.pdf_footer')->render();
        $header = view('invoice_view._partials.pdf_header', compact('invoice_nbr', 'invoice_date', 'pge_title', 'type'))->render();
        $options = [
            'footer-html' => $footer,
            'header-html' => $header,
            'margin-top' => 24,
        ];

        $pdf = PDF::loadView('invoice_view.purchase_sale_tax_invoice.purchase_sale_tax_invoice_list_modal', compact('piims', 'pim', 'nbrOfWrds', 'accnts', 'invoice_nbr', 'invoice_date', 'type', 'pge_title', 'urdu_eng'));
        $pdf->setOptions($options);

        return $pdf->stream('Purchase-Invoice.pdf');
    }


    // update code by shahzaib start
    public function sale_tax_purchase_return_invoice_list(Request $request, $array = null, $str = null)
    {

        $heads = config('global_variables.payable_receivable_cash');
        $heads = explode(',', $heads);

        $accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)->orderBy('account_name', 'ASC')->get();
        $products = ProductModel::orderBy('pro_id', 'ASC')->get();
        $posting_references = PostingReferenceModel::all();

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_account = (!isset($request->account) && empty($request->account)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->account;
        $search_product = (!isset($request->product) && empty($request->product)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->product;
        $search_posting_reference = (!isset($request->posting) && empty($request->posting)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->posting;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.sale_tax_purchase_return_invoice_list.sale_tax_purchase_return_invoice_list';
        $pge_title = 'Sale Tax Purchase Return Invoice List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_account, $search_product, $search_posting_reference, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $pro_code = '';
        $pro_name = '';


        foreach ($products as $product) {
            $selected = $product->pro_p_code == $search_product ? 'selected' : '';
            $pro_code .= "<option value='$product->pro_p_code' data-parent='$product->pro_p_code' $selected>$product->pro_p_code</option>";
            $pro_name .= "<option value='$product->pro_p_code' data-parent='$product->pro_p_code' $selected>$product->pro_title</option>";
        }


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));


//        $query = PurchaseInvoiceModel::query();
        $query = DB::table('financials_purchase_return_saletax_invoice')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_purchase_return_saletax_invoice.prsi_createdby')
            ->leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_purchase_return_saletax_invoice.prsi_pr_id');

        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('prsi_party_code', 'like', '%' . $search . '%')
                    ->orWhere('prsi_party_name', 'like', '%' . $search . '%')
                    ->orWhere('prsi_remarks', 'like', '%' . $search . '%')
                    ->orWhere('prsi_id', 'like', '%' . $search . '%')
                    ->orWhere('user_designation', 'like', '%' . $search . '%')
                    ->orWhere('user_name', 'like', '%' . $search . '%')
                    ->orWhere('user_username', 'like', '%' . $search . '%');
            });
        }

        if (!empty($search_account)) {
            $query->where('prsi_party_code', $search_account);
        }
        if (!empty($search_posting_reference)) {
            $query->where('prsi_pr_id', $search_posting_reference);
        }

        if (!empty($search_product)) {
            $get_p_id = PurchaseReturnSaletaxInvoiceItemsModel::where('prsii_product_code', $search_product)->pluck('prsii_invoice_id')->all();
            $query->whereIn('prsi_id', $get_p_id);
        }

        if (!empty($search_by_user)) {
            $query->where('prsi_createdby', $search_by_user);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('pi_day_end_date', [$start, $end]);
            $query->whereDate('prsi_day_end_date', '>=', $start)
                ->whereDate('prsi_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('prsi_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('prsi_day_end_date', $end);
        }


        $datas = $query->orderBy('prsi_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

        $party = AccountRegisterationModel::whereIn('account_parent_code', $heads)->orderBy('account_name', 'ASC')->pluck('account_name')->all();


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];

            $pdf = PDF::loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('purchase_return_invoice_sale_tax_list', compact('datas', 'search', 'party', 'accounts', 'search_account', 'search_product', 'pro_name', 'pro_code', 'search_to', 'search_from',
                'search_by_user', 'posting_references','search_posting_reference'));
        }

    }

    // update code by shahzaib end

    public function return_sale_tax_purchase_items_view_details_SH(Request $request, $id)
    {
        $urdu_eng = ReportConfigModel::where('rc_id', '=', 1)->select('rc_invoice','rc_invoice_party')->first();
        if ($urdu_eng->rc_invoice_party == 0){
            $pim = PurchaseReturnSaletaxInvoiceModel::Join('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_purchase_return_saletax_invoice.prsi_pr_id')->where('prsi_id',
                $id)->first();
        }else{
            $pim = DB::table('financials_purchase_return_saletax_invoice')
                ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_purchase_return_saletax_invoice.prsi_party_code')
                ->Join('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_purchase_return_saletax_invoice.prsi_pr_id')
                ->where('prsi_id', $id)
                ->select('financials_accounts.account_urdu_name as prsi_party_name','prsi_id','prsi_party_code','prsi_customer_name','prsi_remarks','prsi_total_items','prsi_total_price',
                    'prsi_product_disc','prsi_round_off_disc',
                    'prsi_cash_disc_per','prsi_cash_disc_amount','prsi_total_discount','prsi_inclusive_sales_tax','prsi_exclusive_sales_tax','prsi_total_sales_tax','prsi_grand_total',
                    'prsi_cash_paid','prsi_day_end_id','prsi_day_end_date','prsi_createdby','pr_name')->first();
        }

        $accnts = AccountRegisterationModel::where('account_uid', $pim->prsi_party_code)->first();

        if($urdu_eng->rc_invoice == 0) {
            $piims = PurchaseReturnSaletaxInvoiceItemsModel::where('prsii_purchase_invoice_id', $id)
                ->select('prsii_product_name as name', 'prsii_remarks as remarks', 'prsii_qty as qty', 'prsii_rate as rate', 'prsii_discount_per as discount', 'prsii_discount_amount as discount_amount',
                    'prsii_after_dis_rate as after_discount', 'prsii_saletax_per as sale_tax', 'prsii_saletax_amount as sale_tax_amount', 'prsii_saletax_inclusive as inclu_exclu', 'prsii_amount as amount', 'prsii_scale_size as scale_size')
                ->orderby('prsii_product_name', 'ASC')
                ->get();
        }else{
            $piims =DB::table('financials_purchase_return_saletax_invoice_items')
                ->join('financials_products','financials_products.pro_p_code','=','financials_purchase_return_saletax_invoice_items.prsii_product_code')
                ->where('prsii_purchase_invoice_id', $id)

                ->select('financials_products.pro_urdu_title as name', 'prsii_remarks as remarks', 'prsii_qty as qty', 'prsii_rate as rate', 'prsii_discount_per as discount', 'prsii_discount_amount as discount_amount',
                    'prsii_after_dis_rate as after_discount', 'prsii_saletax_per as sale_tax', 'prsii_saletax_amount as sale_tax_amount', 'prsii_saletax_inclusive as inclu_exclu', 'prsii_amount as amount', 'prsii_scale_size as scale_size')
                ->orderby('financials_products.pro_urdu_title', 'ASC')
                ->get();
        }


        $nbrOfWrds = $this->myCnvrtNbr($pim->prsi_grand_total);
        $invoice_nbr = $pim->prsi_id;
        $invoice_date = $pim->prsi_day_end_date;
        $type = 'grid';
        $pge_title = 'Sale Tax Purchase Return Invoice';

        return view('invoice_view.purchase_return_sale_tax_invoice.purchase_return_sale_tax_invoice_list_modal', compact('piims', 'pim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date',
            'type', 'pge_title', 'urdu_eng'));

    }

    public function return_sale_tax_purchase_items_view_details_pdf_SH(Request $request, $id)
    {
        $urdu_eng = ReportConfigModel::where('rc_id', '=', 1)->select('rc_invoice','rc_invoice_party')->first();
        if ($urdu_eng->rc_invoice_party == 0){
            $pim = PurchaseReturnSaletaxInvoiceModel::Join('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_purchase_return_saletax_invoice.prsi_pr_id')->where('prsi_id', $id)->first();
        }else{
            $pim = DB::table('financials_purchase_return_saletax_invoice')
                ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_purchase_return_saletax_invoice.prsi_party_code')
                ->Join('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_purchase_return_saletax_invoice.prsi_pr_id')
                ->where('prsi_id', $id)
                ->select('financials_accounts.account_urdu_name as prsi_party_name','prsi_id','prsi_party_code','prsi_customer_name','prsi_remarks','prsi_total_items','prsi_total_price',
                    'prsi_product_disc','prsi_round_off_disc',
                    'prsi_cash_disc_per','prsi_cash_disc_amount','prsi_total_discount','prsi_inclusive_sales_tax','prsi_exclusive_sales_tax','prsi_total_sales_tax','prsi_grand_total',
                    'prsi_cash_paid','prsi_day_end_id','prsi_day_end_date','prsi_createdby','pr_name')->first();
        }

        $accnts = AccountRegisterationModel::where('account_uid', $pim->prsi_party_code)->first();

        if($urdu_eng->rc_invoice == 0) {
            $piims = PurchaseReturnSaletaxInvoiceItemsModel::where('prsii_purchase_invoice_id', $id)
                ->select('prsii_product_name as name', 'prsii_remarks as remarks', 'prsii_qty as qty', 'prsii_rate as rate', 'prsii_discount_per as discount', 'prsii_discount_amount as discount_amount',
                    'prsii_after_dis_rate as after_discount', 'prsii_saletax_per as sale_tax', 'prsii_saletax_amount as sale_tax_amount', 'prsii_saletax_inclusive as inclu_exclu', 'prsii_amount as amount', 'prsii_scale_size as scale_size')
                ->orderby('prsii_product_name', 'ASC')
                ->get();
        }else{
            $piims =DB::table('financials_purchase_return_saletax_invoice_items')
                ->join('financials_products','financials_products.pro_p_code','=','financials_purchase_return_saletax_invoice_items.prsii_product_code')
                ->where('prsii_purchase_invoice_id', $id)

                ->select('financials_products.pro_urdu_title as name', 'prsii_remarks as remarks', 'prsii_qty as qty', 'prsii_rate as rate', 'prsii_discount_per as discount', 'prsii_discount_amount as discount_amount',
                    'prsii_after_dis_rate as after_discount', 'prsii_saletax_per as sale_tax', 'prsii_saletax_amount as sale_tax_amount', 'prsii_saletax_inclusive as inclu_exclu', 'prsii_amount as amount', 'prsii_scale_size as scale_size')
                ->orderby('financials_products.pro_urdu_title', 'ASC')
                ->get();
        }


        $nbrOfWrds = $this->myCnvrtNbr($pim->prsi_grand_total);
        $invoice_nbr = $pim->prsi_id;
        $invoice_date = $pim->prsi_day_end_date;
        $type = 'pdf';
        $pge_title = 'Sale Tax Purchase Return Invoice';

        $footer = view('invoice_view._partials.pdf_footer')->render();
        $header = view('invoice_view._partials.pdf_header', compact('invoice_nbr', 'invoice_date', 'pge_title', 'type'))->render();
        $options = [
            'footer-html' => $footer,
            'header-html' => $header,
            'margin-top' => 24,
        ];

        $pdf = PDF::loadView('invoice_view.purchase_return_sale_tax_invoice.purchase_return_sale_tax_invoice_list_modal', compact('piims', 'pim', 'nbrOfWrds', 'accnts', 'invoice_nbr', 'invoice_date', 'type', 'pge_title', 'urdu_eng'));
        $pdf->setOptions($options);

        return $pdf->stream('Purchase-Invoice.pdf');
    }

    public function get_purchased_items_for_return(Request $request)
    {
        $invoice_type = $request->invoice_type;
        $invoice_no = $request->invoice_no;

        $array = [];

        if ($invoice_type == 1) {

            $purchase = PurchaseInvoiceModel::where('pi_id', $invoice_no)->first();

            $items = PurchaseInvoiceItemsModel::where('pii_purchase_invoice_id', $invoice_no)->get();
        } else {
            $purchase = PurchaseSaletaxInvoiceModel::where('psi_id', $invoice_no)->first();

            $items = PurchaseSaletaxItemsInvoiceModel::where('psii_purchase_invoice_id', $invoice_no)->get();
        }

        $array[] = $purchase;
        $array[] = $items;
        return response()->json($array);
    }

}
