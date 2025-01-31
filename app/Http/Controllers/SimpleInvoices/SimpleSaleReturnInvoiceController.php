<?php

namespace App\Http\Controllers\SimpleInvoices;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\DayEndController;
use App\Http\Controllers\SaleInvoiceController;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\CashPaymentVoucherItemsModel;
use App\Models\CashPaymentVoucherModel;
use App\Models\PostingReferenceModel;
use App\Models\ProductModel;
use App\Models\ProductPackagesModel;
use App\Models\ReportConfigModel;
use App\Models\SaleInvoiceItemsModel;
use App\Models\SaleInvoiceModel;
use App\Models\SaleReturnInvoiceItemsModel;
use App\Models\SaleReturnInvoiceModel;
use App\Models\SaleReturnSaletaxInvoiceModel;
use App\Models\SaleSaletaxInvoiceItemsModel;
use App\Models\SaleSaletaxInvoiceModel;
use App\Models\SystemConfigModel;
use App\Models\TransactionModel;
use PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SimpleSaleReturnInvoiceController extends Controller
{
    public function simple_sale_return_invoice()
    {

        $accounts = $this->get_account_query('sale')[0];

        $products = $this->get_all_products();//->whereIn('pro_product_type_id',[1,3,4]);
        $pro_code = '';
        $pro_name = '';
        foreach ($products as $product) {
            $pro_title = $this->RemoveSpecialChar($product->pro_title);

            $pro_code .= "<option value='$product->pro_p_code' data-parent='$product->pro_p_code' data-sale_price='$product->pro_sale_price' data-tax='$product->pro_tax' data-retailer_dis='$product->pro_retailer_discount' data-whole_saler_dis='$product->pro_whole_seller_discount' data-loyalty_dis='$product->pro_loyalty_card_discount' data-unit='$product->unit_title' data-unit_scale_size='$product->unit_scale_size' data-main_unit='$product->mu_title'>$product->pro_p_code</option>";
            $pro_name .= "<option value='$product->pro_p_code' data-parent='$product->pro_p_code' data-sale_price='$product->pro_sale_price' data-tax='$product->pro_tax' data-retailer_dis='$product->pro_retailer_discount' data-whole_saler_dis='$product->pro_whole_seller_discount' data-loyalty_dis='$product->pro_loyalty_card_discount' data-unit='$product->unit_title' data-unit_scale_size='$product->unit_scale_size' data-main_unit='$product->mu_title'>$pro_title</option>";
        }

        $packages = ProductPackagesModel::where('pp_delete_status', '!=', 1)->where('pp_disabled', '!=', 1)->orderBy('pp_name', 'ASC')->get();


//        $sale_persons = User::where('user_id', '!=', 1)->orderBy('user_role_id', 'DESC')->orderBy('user_name', 'ASC')->get();
        $detail_remarks = ReportConfigModel::where('rc_id', '=', 1)->pluck('rc_detail_remarks')->first();
//        $warehouses = $this->get_all_warehouse();
//        $posting_references = PostingReferenceModel::where('pr_disabled','=',0)->get();
        return view('Simple_Invoices/simple_sale_return_invoice', compact('pro_code', 'pro_name', 'accounts', 'products', 'packages', 'detail_remarks'));
    }

    public function get_simple_sale_items_for_return(Request $request)
    {
        $invoice_type = $request->invoice_type;
        $invoice_no = $request->invoice_no;
        $desktop_invoice_id = $request->desktop_invoice_id;

        $array = [];

        if ($invoice_type == 1) {

            if ($desktop_invoice_id == 0) {
                $sale = SaleInvoiceModel::where('si_id', $invoice_no)->first();
            } else {
                $sale = SaleInvoiceModel::where('si_local_invoice_id', $invoice_no)->first();
            }

            $items = SaleInvoiceItemsModel::where('sii_invoice_id', $invoice_no)->get();

        } else {

            if ($desktop_invoice_id == 0) {
                $sale = SaleSaletaxInvoiceModel::where('ssi_id', $invoice_no)->first();
            } else {
                $sale = SaleSaletaxInvoiceModel::where('ssi_local_invoice_id', $invoice_no)->first();
            }

            $items = SaleSaletaxInvoiceItemsModel::where('ssii_invoice_id', $invoice_no)->get();
        }

        $array[] = $sale;
        $array[] = $items;

        return response()->json($array);
    }

    public function submit_simple_sale_return_invoice(Request $request)
    {
        $sale_invoice_controller = new SaleInvoiceController;

        $this->sale_invoice_validation($request);

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $rollBack = false;

        $sales_array = [];

        $account_code = $request->account_name;
        $account_name = $this->get_account_name($account_code);
        $cash_discount_per = $request->disc_percentage;
        $product_cash_discount_amount = $request->disc_amount;
        $product_total_discount_amount=$request->total_discount;
        $product_total_items = $request->total_items;
        $product_total_price = $request->total_price;
        $product_discount_amount = $request->total_product_discount;
        $product_round_off_discount_amount = $request->round_off_discount;
        $product_inclusive_saletax = $request->total_inclusive_tax;
        $product_exclusive_saletax = $request->total_exclusive_tax;
        $product_total_saletax = $request->total_tax;
        $product_grand_total = $request->grand_total;
        $invoice_type = $request->invoice_type;
        $cash_paid = $request->cash_paid;
        $requested_arrays = $request->pro_code;

        $product_cash_paid_ratio = 1;

        $product_cash_paid = $cash_paid * $product_cash_paid_ratio;
        $sale_amount = $product_grand_total - $product_total_saletax + $product_total_discount_amount;

        $sale_invoice_number = '';


        foreach ($requested_arrays as $index => $requested_array) {

            $item_code = $request->pro_code[$index];
            $item_name = $request->pro_name[$index];
            $item_remarks = isset($request->product_remarks[$index]) ? $request->product_remarks[$index] : '';
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

            $sales_array[] = [
                'product_code' => $item_code,
                'product_name' => $item_name,
                'product_remarks' => $item_remarks,
                'warehouse' => $item_warehouse,
                'product_qty' => $item_quantity,
                'product_unit_measurement' => $item_unit_measurement,
                'product_unit_scale_size' => $item_unit_measurement_scale_size, //mustafa
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
        $stock_in_hand = config('global_variables.stock_in_hand');
        $sale_tax_account = config('global_variables.sales_tax_payable_account');
        $sale_account = config('global_variables.sales_returns_and_allowances');
        $sale_margin_account = config('global_variables.sale_margin_account');
        $walk_in_customer_account = config('global_variables.walk_in_customer');
        $product_discount_account = config('global_variables.product_discount_account');
        $round_off_discount_account = config('global_variables.round_off_discount_account');
        $cash_discount_account = config('global_variables.cash_discount_account');
        $retailer_discount_account = config('global_variables.retailer_discount_account');
        $wholesaler_discount_account = config('global_variables.wholesaler_discount_account');
        $loyalty_card_discount_account = config('global_variables.loyalty_card_discount_account');

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

            $sale_prefix = 'sri';
            $sale_items_prefix = 'srii';

            $sale_invoice = new SaleReturnInvoiceModel();
            $item_table = 'financials_sale_return_invoice_items';

            $notes = 'SALE_RETURN_INVOICE';

            $voucher_code = config('global_variables.SALE_VOUCHER_CODE');
            $transaction_type = config('global_variables.SALE');


        } else {

            $sale_prefix = 'srsi';
            $sale_items_prefix = 'srsii';

            $sale_invoice = new SaleReturnSaletaxInvoiceModel();
            $item_table = 'financials_sale_return_saletax_invoice_items';

            $notes = 'SALE_RETURN_SALE_TAX_INVOICE';

            $voucher_code = config('global_variables.SALE_SALE_TAX_VOUCHER_CODE');
            $transaction_type = config('global_variables.SALE_SALE_TAX');
        }

        //sale invoice
        if (!empty($sales_array)) {

            // system config set increment default id according to user giving start coding
            $chk_bnk_pymnt = $sstm_cnfg_clm = '';
            if ($notes === 'SALE_RETURN_INVOICE'):
                $chk_bnk_pymnt = SaleReturnInvoiceModel::all();
                $sstm_cnfg_clm = 'sc_sale_return_invoice_number';
            elseif ($notes === 'SALE_RETURN_SALE_TAX_INVOICE'):
                $chk_bnk_pymnt = SaleReturnSaletaxInvoiceModel::all();
                $sstm_cnfg_clm = 'sc_sale_tax_return_invoice_number';
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

            $sale_invoice = $sale_invoice_controller->AssignSaleInvoiceValues($request, $sale_invoice, $day_end, $user, $sale_prefix, $account_code, $account_name, $request->remarks, $product_total_items, $product_total_price, $product_discount_amount, $product_round_off_discount_amount, $cash_discount_per, $product_cash_discount_amount, $product_total_discount_amount, $product_inclusive_saletax, $product_exclusive_saletax, $product_total_saletax, $product_grand_total, $product_cash_paid);


            if ($sale_invoice->save()) {

                $s_id = $sale_prefix . '_id';

                $sale_invoice_id = $sale_invoice->$s_id;

                $sale_invoice_number .= $voucher_code . $sale_invoice_id;
            } else {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            //////////////////////////// Sale Invoice Items Insertion ////////////////////////////////////
            $detail_remarks = '';

            $item = $sale_invoice_controller->AssignSaleInvoiceItemsValues($sale_invoice_id, $sales_array, $sale_items_prefix, 1);

            foreach ($item as $value) {

                $pro_rate = (float)$value[$sale_items_prefix . '_rate'];
                $pro_amount = (float)$value[$sale_items_prefix . '_amount'];

                $qty = $value[$sale_items_prefix . '_qty'];

                $scale_size = (float)$value[$sale_items_prefix . '_scale_size'];
                $pack_qty = floor($qty/$scale_size);
                $loose_qty = fmod($qty, $scale_size);

                $pro_code = ($value[$sale_items_prefix . '_product_code']);
                $product_name = '';
                if ($request->detail_remarks_type == 0) {
                    $product_name = $value[$sale_items_prefix . '_product_name'];
                } else {
                    $product_name = ProductModel::where('pro_p_code', '=', $pro_code)->pluck('pro_urdu_title')->first();

                }

                $detail_remarks .= $product_name . ', QTY ' . $value[$sale_items_prefix . '_qty'] . '@' . number_format($pro_rate, 2) . ' = ' . number_format
                    ($pro_amount, 2) . ', Pack QTY = ' . $pack_qty . ', Loose QTY = ' . $loose_qty . config('global_variables.Line_Break');
            }

            if (!DB::table($item_table)->insert($item)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }


            $stock_amount = $sale_invoice_controller->actual_stock_price;


            //////////////////////////// Details Remarks of Sale Invoice Insertion ////////////////////////////////////

            $sale_detail_remarks = $sale_prefix . '_detail_remarks';

            $sale_invoice->$sale_detail_remarks = $detail_remarks;

            if (!$sale_invoice->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            //////////////////////////// Product Inventory Insertion ////////////////////////////////////

//            $inventory = $this->AssignProductInventoryValues($sales_array, 1);
//
//            if (!$inventory) {
//                $rollBack = true;
//                DB::rollBack();
//                return redirect()->back()->with('fail', 'Failed Try Again');
//            }

            //////////////////////////// Warehouse Stock Insertion ////////////////////////////////////

            $warehouses = [];
            $warehouse = $this->AssignWarehouseStocksValues($warehouses, $sales_array, 1);

            if (!DB::table('financials_warehouse_stock')->insert($warehouse)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            //////////////////////////// Warehouse Stock Summary Insertion ////////////////////////////////////
            $invoice_type_summary='';
            if ($invoice_type == 1){
                $invoice_type_summary='SALE RETURN';
            }else{
                $invoice_type_summary='SALE TAX RETURN';
            }
            $warehouses_summary = [];
            $warehouse_stock_summary = $this->AssignWarehouseStocksSummaryValues($warehouses_summary, $sales_array, $invoice_type_summary);

            if (!DB::table('financials_warehouse_stock_summary')->insert($warehouse_stock_summary)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            //////////////////////////// Stock Movement Insertion ////////////////////////////////////

            $stock_movement = $this->stock_movement_module_sale_return($sales_array, $voucher_code . $sale_invoice_id, 'SALE RETURN', 'SALE_RETURN');

            if (!$stock_movement) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }


            //////////////////////////// TRANSACTION ONE STOCK IN HAND ////////////////////////////////////

            $transactions1 = new TransactionModel();
            $transaction1 = $this->AssignTransactionsValues($transactions1, $stock_in_hand, $stock_amount, 0, $notes, $transaction_type, $sale_invoice_id);

            if ($transaction1->save()) {
                $transaction_id1 = $transaction1->trans_id;

                $balances1 = new BalancesModel();

                $balance1 = $this->AssignAccountBalancesValues($balances1, $transaction_id1, $stock_in_hand, $stock_amount, 'Dr', $request->remarks,
                    $notes, $detail_remarks, $voucher_code . $sale_invoice_id, $request->posting_reference, $voucher_no='');

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
            $transaction2 = $this->AssignTransactionsValues($transactions2, $sale_account, $sale_amount, 0, $notes, $transaction_type, $sale_invoice_id);


            if ($transaction2->save()) {

                $transaction_id2 = $transaction2->trans_id;

                $balances2 = new BalancesModel();

                $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id2, $sale_account, $sale_amount, 'Dr', $request->remarks,
                    $notes, $detail_remarks, $voucher_code . $sale_invoice_id, $request->posting_reference, $voucher_no='');

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
                $transaction3 = $this->AssignTransactionsValues($transactions3, $sale_tax_account, $product_total_saletax, 0, $notes, $transaction_type, $sale_invoice_id);

                if ($transaction3->save()) {
                    $transaction_id3 = $transaction3->trans_id;

                    $balances3 = new BalancesModel();

                    $balance3 = $this->AssignAccountBalancesValues($balances3, $transaction_id3, $sale_tax_account, $product_total_saletax, 'Dr', $request->remarks,
                        $notes, $detail_remarks, $voucher_code . $sale_invoice_id, $request->posting_reference, $voucher_no='');

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
            elseif ($product_total_saletax > 0) {

                //////////////////////////// TRANSACTION THREE SALE TAX ACCOUNT ////////////////////////////////////

                $transactions3 = new TransactionModel();
                $transaction3 = $this->AssignTransactionsValues($transactions3, $sale_margin_account, $product_total_saletax, 0, $notes, $transaction_type, $sale_invoice_id);

                if ($transaction3->save()) {
                    $transaction_id3 = $transaction3->trans_id;

                    $balances3 = new BalancesModel();

                    $balance3 = $this->AssignAccountBalancesValues($balances3, $transaction_id3, $sale_margin_account, $product_total_saletax, 'Dr', $request->remarks,
                        $notes, $detail_remarks, $voucher_code . $sale_invoice_id, $request->posting_reference, $voucher_no='');

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
            $transaction4 = $this->AssignTransactionsValues($transactions4, 0, $product_grand_total, $account_code, $notes, $transaction_type, $sale_invoice_id);

            if ($transaction4->save()) {
                $transaction_id4 = $transaction4->trans_id;

                $balances4 = new BalancesModel();

                $balance4 = $this->AssignAccountBalancesValues($balances4, $transaction_id4, $account_code, $product_grand_total, 'Cr', $request->remarks,
                    $notes, $detail_remarks, $voucher_code . $sale_invoice_id, $request->posting_reference, $voucher_no='');

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
                $transaction5 = $this->AssignTransactionsValues($transactions5, 0, $product_discount_amount, $product_discount_account, $notes, $transaction_type, $sale_invoice_id);

                if ($transaction5->save()) {

                    $transaction_id5 = $transaction5->trans_id;

                    $balances5 = new BalancesModel();

                    $balance5 = $this->AssignAccountBalancesValues($balances5, $transaction_id5, $product_discount_account, $product_discount_amount, 'Cr', $request->remarks,
                        $notes, $detail_remarks, $voucher_code . $sale_invoice_id, $request->posting_reference, $voucher_no='');

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
                $transaction6 = $this->AssignTransactionsValues($transactions6, 0, $product_round_off_discount_amount, $round_off_discount_account, $notes, $transaction_type, $sale_invoice_id);

                if ($transaction6->save()) {

                    $transaction_id6 = $transaction6->trans_id;

                    $balances6 = new BalancesModel();

                    $balance6 = $this->AssignAccountBalancesValues($balances6, $transaction_id6, $round_off_discount_account, $product_round_off_discount_amount, 'Cr', $request->remarks,
                        $notes, $detail_remarks, $voucher_code . $sale_invoice_id, $request->posting_reference, $voucher_no='');

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
                $transaction7 = $this->AssignTransactionsValues($transactions7, 0, $product_cash_discount_amount, $cash_discount_account, $notes, $transaction_type, $sale_invoice_id);

                if ($transaction7->save()) {

                    $transaction_id7 = $transaction7->trans_id;

                    $balances7 = new BalancesModel();

                    $balance7 = $this->AssignAccountBalancesValues($balances7, $transaction_id7, $cash_discount_account, $product_cash_discount_amount, 'Cr', $request->remarks,
                        $notes, $detail_remarks, $voucher_code . $sale_invoice_id, $request->posting_reference, $voucher_no='');

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
        }


        //        if party pay cash or select walk in customer account
//        if ($account_code == $walk_in_customer_account || $product_cash_paid > 0) { // hamza
        if ($product_cash_paid > 0) { // mustafa

            $cash_voucher_notes = 'CASH_PAYMENT_VOUCHER';
            $cash_voucher_voucher_code = config('global_variables.CASH_PAYMENT_VOUCHER_CODE');
            $cash_voucher_transaction_type = config('global_variables.CASH_PAYMENT');

//            if ($account_code == $walk_in_customer_account) {
//                $product_cash_paid = $product_grand_total;
//            }

            //////////////////////////// Cash Payment Voucher Insertion ////////////////////////////////////

            $cash_voucher = new CashPaymentVoucherModel();
            $cash_voucher_prefix = 'cp';

            $cash_voucher_remarks = $sale_invoice_number;

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
            $transaction8 = $this->AssignTransactionsValues($transactions8, $account_code, $product_cash_paid, $cash_in_hand, $cash_voucher_notes, $cash_voucher_transaction_type, $cash_voucher_id);

            if ($transaction8->save()) {

                $transaction_id8 = $transaction8->trans_id;

                $balances8 = new BalancesModel();

                $balance8 = $this->AssignAccountBalancesValues($balances8, $transaction_id8, $cash_in_hand, $product_cash_paid, 'Cr', $cash_voucher_remarks,
                    $cash_voucher_notes, $cash_voucher_detail_remarks, $cash_voucher_voucher_code . $cash_voucher_id, $request->posting_reference, $voucher_no='');

                if (!$balance8->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }

                //////////////////////////// TRANSACTION NINE PARTY ACCOUNT ///////////////////////////////////////

                $balances9 = new BalancesModel();

                $balance9 = $this->AssignAccountBalancesValues($balances9, $transaction_id8, $account_code, $product_cash_paid, 'Dr', $cash_voucher_remarks,
                    $cash_voucher_notes, $cash_voucher_detail_remarks, $cash_voucher_voucher_code . $cash_voucher_id, $request->posting_reference, $voucher_no='');

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
            DB::commit();
            return redirect()->back()->with(['sri_id' => $sale_invoice_id]);
//            return redirect()->back()->with('success', 'Successfully Saved');
        }
    }

    public function sale_invoice_validation($request)
    {
        return $this->validate($request, [
            'account_name' => ['required', 'numeric'],
            "package" => ['nullable', 'string'],
            "remarks" => ['nullable', 'string'],
            "customer_name" => ['nullable', 'string'],
            "invoice_type" => ['required', 'numeric'],
            "discount_type" => ['required', 'numeric'],
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
            'unit_measurement' => ['nullable', 'array'],
            'unit_measurement.*' => ['nullable', 'string'],
            'warehouse' => ['required', 'array'],
            'warehouse.*' => ['required', 'numeric'],
            'quantity' => ['required', 'array'],
            'quantity.*' => ['required', 'numeric'],
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

    public function simple_sale_return_items_view_details_SH(Request $request, $id)
    {
        $urdu_eng = ReportConfigModel::where('rc_id', '=', 1)->select('rc_invoice','rc_invoice_party')->first();
        if ($urdu_eng->rc_invoice_party == 0){
            $sim = SaleReturnInvoiceModel::Join('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_sale_return_invoice.sri_pr_id')->where('sri_id', $id)->first();
        }else{
            $sim = DB::table('financials_sale_return_invoice')
                ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_sale_return_invoice.sri_party_code')
                ->Join('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_sale_return_invoice.sri_pr_id')
                ->where('sri_id', $id)
                ->select('financials_accounts.account_urdu_name as sri_party_name','sri_id','sri_party_code','sri_customer_name','sri_remarks','sri_total_items','sri_total_price',
                    'sri_product_disc','sri_round_off_disc',
                    'sri_cash_disc_per','sri_cash_disc_amount','sri_total_discount','sri_inclusive_sales_tax','sri_exclusive_sales_tax','sri_total_sales_tax','sri_grand_total',
                    'sri_cash_received','sri_day_end_id','sri_day_end_date','sri_createdby','sri_sale_person','sri_service_invoice_id','sri_local_invoice_id','sri_local_service_invoice_id','sri_cash_received_from_customer','sri_return_amount','pr_name')->first();
        }

        $accnts = AccountRegisterationModel::where('account_uid', $sim->sri_party_code)->first();

        if ($urdu_eng->rc_invoice == 0) {
            $siims = DB::table('financials_sale_return_invoice_items')
                ->where('srii_invoice_id', $id)
                ->orderby('srii_product_name', 'ASC')
                ->select('srii_product_name as name', 'srii_remarks as remarks', 'srii_qty as qty', 'srii_rate as rate', 'srii_discount_per as discount',  'srii_discount_amount as discount_amount', 'srii_after_dis_rate as after_discount', 'srii_saletax_per as sale_tax', 'srii_saletax_amount as sale_tax_amount', 'srii_saletax_inclusive as inclu_exclu', 'srii_amount as amount', 'srii_scale_size as scale_size', 'srii_saletax_inclusive as type')
//            ->select('srii_product_name as name', 'srii_remarks as remarks', 'srii_qty as qty', 'srii_rate as rate', 'srii_discount as discount', 'srii_saletax as sale_tax', 'srii_amount as amount')
                ->get();
        } else {
            $siims = DB::table('financials_sale_return_invoice_items')
                ->join('financials_products', 'financials_products.pro_p_code', '=', 'financials_sale_return_invoice_items.srii_product_code')
                ->where('srii_invoice_id', $id)
                ->orderby('srii_product_name', 'ASC')
                ->select('financials_products.pro_urdu_title as name', 'srii_remarks as remarks', 'srii_qty as qty', 'srii_rate as rate', 'srii_discount_per as discount',  'srii_discount_amount as discount_amount', 'srii_after_dis_rate as after_discount', 'srii_saletax_per as sale_tax', 'srii_saletax_amount as sale_tax_amount', 'srii_saletax_inclusive as inclu_exclu', 'srii_amount as amount', 'srii_scale_size as scale_size', 'srii_saletax_inclusive as type')
//            ->select('srii_product_name as name', 'srii_remarks as remarks', 'srii_qty as qty', 'srii_rate as rate', 'srii_discount as discount', 'srii_saletax as sale_tax', 'srii_amount as amount')
                ->get();

        }

        $nbrOfWrds = $this->myCnvrtNbr($sim->sri_grand_total);
        $invoice_nbr = $sim->sri_id;
        $invoice_date = $sim->sri_day_end_date;
        $type = 'grid';
        $pge_title = 'Sale Return Invoice';

        return view('invoice_view.sale_return_invoice.sale_return_invoice_list_modal', compact('siims', 'sim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title', 'urdu_eng'));
    }

    public function simple_sale_return_items_view_details_pdf_SH(Request $request, $id)
    {
        $urdu_eng = ReportConfigModel::where('rc_id', '=', 1)->select('rc_invoice','rc_invoice_party')->first();
        if ($urdu_eng->rc_invoice_party == 0){
            $sim = SaleReturnInvoiceModel::Join('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_sale_return_invoice.sri_pr_id')->where('sri_id', $id)->first();
        }else{
            $sim = DB::table('financials_sale_return_invoice')
                ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_sale_return_invoice.sri_party_code')
                ->Join('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_sale_return_invoice.sri_pr_id')
                ->where('sri_id', $id)
                ->select('financials_accounts.account_urdu_name as sri_party_name','sri_id','sri_party_code','sri_customer_name','sri_remarks','sri_total_items','sri_total_price',
                    'sri_product_disc','sri_round_off_disc',
                    'sri_cash_disc_per','sri_cash_disc_amount','sri_total_discount','sri_inclusive_sales_tax','sri_exclusive_sales_tax','sri_total_sales_tax','sri_grand_total',
                    'sri_cash_received','sri_day_end_id','sri_day_end_date','sri_createdby','sri_sale_person','sri_service_invoice_id','sri_local_invoice_id','sri_local_service_invoice_id','sri_cash_received_from_customer','sri_return_amount', 'pr_name')->first();
        }

        $accnts = AccountRegisterationModel::where('account_uid', $sim->sri_party_code)->first();
        if ($urdu_eng->rc_invoice == 0) {
            $siims = DB::table('financials_sale_return_invoice_items')
                ->where('srii_invoice_id', $id)
                ->orderby('srii_product_name', 'ASC')
                ->select('srii_product_name as name', 'srii_remarks as remarks', 'srii_qty as qty', 'srii_rate as rate', 'srii_discount_per as discount',  'srii_discount_amount as discount_amount', 'srii_after_dis_rate as after_discount', 'srii_saletax_per as sale_tax', 'srii_saletax_amount as sale_tax_amount', 'srii_saletax_inclusive as inclu_exclu', 'srii_amount as amount', 'srii_scale_size as scale_size', 'srii_saletax_inclusive as type')
//            ->select('srii_product_name as name', 'srii_remarks as remarks', 'srii_qty as qty', 'srii_rate as rate', 'srii_discount as discount', 'srii_saletax as sale_tax', 'srii_amount as amount')
                ->get();
        } else {
            $siims = DB::table('financials_sale_return_invoice_items')
                ->join('financials_products', 'financials_products.pro_p_code', '=', 'financials_sale_return_invoice_items.srii_product_code')
                ->where('srii_invoice_id', $id)
                ->orderby('srii_product_name', 'ASC')
                ->select('financials_products.pro_urdu_title as name', 'srii_remarks as remarks', 'srii_qty as qty', 'srii_rate as rate', 'srii_discount_per as discount',  'srii_discount_amount as discount_amount', 'srii_after_dis_rate as after_discount', 'srii_saletax_per as sale_tax', 'srii_saletax_amount as sale_tax_amount', 'srii_saletax_inclusive as inclu_exclu', 'srii_amount as amount', 'srii_scale_size as scale_size', 'srii_saletax_inclusive as type')
//            ->select('srii_product_name as name', 'srii_remarks as remarks', 'srii_qty as qty', 'srii_rate as rate', 'srii_discount as discount', 'srii_saletax as sale_tax', 'srii_amount as amount')
                ->get();

        }
        $nbrOfWrds = $this->myCnvrtNbr($sim->sri_grand_total);
        $invoice_nbr = $sim->sri_id;
        $invoice_date = $sim->sri_day_end_date;
        $type = 'pdf';
        $pge_title = 'Sale Return Invoice';


        $footer = view('invoice_view._partials.pdf_footer')->render();
        $header = view('invoice_view._partials.pdf_header', compact('invoice_nbr', 'invoice_date', 'pge_title', 'type'))->render();
        $options = [
            'footer-html' => $footer,
            'header-html' => $header,
            'margin-top' => 24,
        ];

        $pdf = PDF::loadView('invoice_view.sale_return_invoice.sale_return_invoice_list_modal', compact('siims', 'sim', 'nbrOfWrds', 'accnts', 'type', 'pge_title', 'urdu_eng'));
        $pdf->setOptions($options);

        return $pdf->stream('Sale-Invoice.pdf');
    }

}
