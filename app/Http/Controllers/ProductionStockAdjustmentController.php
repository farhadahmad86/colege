<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\ConsumedStockModel;
use App\Models\ProducedStockModel;
use App\Models\ProductionStockAdjustmentModel;
use App\Models\ProductLossRecoverItemsModel;
use App\Models\ProductLossRecoverModel;
use App\Models\ProductModel;
use App\Models\ProductRecipeItemsModel;
use App\Models\ProductRecipeModel;
use App\Models\PurchaseInvoiceModel;
use App\Models\PurchaseReturnInvoiceModel;
use App\Models\TransactionModel;
use App\Models\WarehouseModel;
use App\User;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProductionStockAdjustmentController extends Controller
{
//    public $invoice_total_value=0;
    public $produced_total_items = 0;
    public $consumed_total_items = 0;
    public $detail_remarks = '';
    public $detail_consumed_remarks = '';
    public $detail_produced_remarks = '';
    public $total_amount = 0;
    public $new_consumed_value_array = [];
    public $new_produced_value_array = [];

    public function production_stock_adjustment()
    {
        $products = $this->get_all_products()->whereIn('pro_product_type_id', [2, 3]);

        $finish_products = $this->get_all_products()->whereIn('pro_product_type_id', [1, 4]);
        $warehouses = WarehouseModel::all();

//        $pro_code = '';
//        $pro_name = '';
//
//        $manufacture_pro_code = '';
//        $manufacture_pro_name = '';

//        foreach ($products as $key=>$product) {
//            $pro_title = $this->RemoveSpecialChar($product->pro_title);
//
//            $pro_code .= "<option value='$product->pro_p_code' data-parent='$product->pro_p_code' data-sale_price='$product->pro_average_rate' data-uom='$product->unit_title' data-code='$product->pro_p_code'> $product->pro_p_code</option>";
//            $pro_name .= "<option value='$product->pro_title' data-parent='$product->pro_p_code' data-sale_price='$product->pro_average_rate' data-uom='$product->unit_title' data-code='$product->pro_p_code'>$pro_title</option>";
//        }

//        foreach ($parent_products as $parent_product) {
//            $pro_title = $this->RemoveSpecialChar($parent_product->pro_title);
//
//            $manufacture_pro_code .= "<option value='$parent_product->pro_p_code'> $parent_product->pro_p_code</option>";
//            $manufacture_pro_name .= "<option value='$parent_product->pro_p_code'>$pro_title</option>";
//        }

        $expense_accounts = $this->get_fourth_level_account(config('global_variables.expense'), 2, 0);

        return view('production_stock_adjustment', compact('expense_accounts', 'products', 'finish_products', 'warehouses'));
    }

    public function submit_production_stock_adjustment(Request $request)
    {
//        dd($request->all());

        $this->validation($request);

        $rollBack = false;
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();
        DB::beginTransaction();

        $consumed_array = json_decode($request->cartDataForProductRecipe, true);
        $produced_array = json_decode($request->cartDataForFinishedGoods, true);
        $values_consumed_array = [];
        $values_produced_array = [];
        foreach ($consumed_array as $array) {
            $values_consumed_array[] = [
                'product_code' => $array['code'],
                'product_name' => $array['title'],
                'warehouse' => $array['warehouse_id'],
                'warehouse_name' => $array['warehouse_title'],
                'product_qty' => $array['quantity'],
                'product_remarks' => $array['remarks'],
                'product_unit_measurement' => $array['uom'],
                'product_unit_measurement_scale_size' => $array['packSize'],
                'product_rate' => $array['rate'],
                'product_amount' => $array['amount'],
                'product_bonus_qty' => 0,
            ];
        }
        foreach ($produced_array as $array) {
            $values_produced_array[] = [
                'product_code' => $array['code'],
                'product_name' => $array['title'],
                'warehouse' => $array['warehouse_id'],
                'warehouse_name' => $array['warehouse_title'],
                'product_qty' => $array['quantity'],
                'product_remarks' => $array['remarks'],
                'product_unit_measurement' => $array['uom'],
                'product_unit_measurement_scale_size' => $array['packSize'],
                'product_rate' => $array['rate'],
                'product_amount' => $array['amount'],
                'product_bonus_qty' => 0,
            ];
        }


        $notes = 'PRODUCT_ADJUSTMENT';
//        $notes2 = 'PRODUCT_RECOVER';
        $voucher_code_consumed = config('global_variables.PRODUCT_CONSUMED_VOUCHER_CODE');
        $voucher_code_produced = config('global_variables.PRODUCT_PRODUCED_VOUCHER_CODE');
        $transaction_type = config('global_variables.CONSUMED_PRODUCED');

        $purchase_notes = 'PRODUCT_PRODUCED';
        $purchase_return_notes = 'PRODUCT_CONSUMED';

        $purchase_return_voucher_code = config('global_variables.PRODUCT_CONSUMED_VOUCHER_CODE');
        $purchase_voucher_code = config('global_variables.PRODUCT_PRODUCED_VOUCHER_CODE');
        $purchase_return_transaction_type = config('global_variables.PURCHASE_RETURN');
        $purchase_transaction_type = config('global_variables.PURCHASE');

        //////////////////////////// Product Insertion ////////////////////////////////////

        $product_loss = new ProductionStockAdjustmentModel();

        $product_loss = $this->assign_product_values($request, $product_loss);

        if ($product_loss->save()) {
            $product_loss_id = $product_loss->psa_id;
        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Consumed Items Insertion ////////////////////////////////////

        $item = $this->assign_consumed_values($values_consumed_array, $product_loss_id);

        if (!DB::table('financials_consumed_stock')->insert($item)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }
        //////////////////////////// Produced Items Insertion ////////////////////////////////////
        $item = $this->assign_produced_values($values_produced_array, $product_loss_id);

        if (!DB::table('financials_produced_stock')->insert($item)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        $new_consumed_array = $this->new_consumed_value_array;
        $new_produced_array = $this->new_produced_value_array;

        //////////////////////////// Product Detail Remarks and amount Insertion ////////////////////////////////////

        $product_loss->psa_detail_remarks = $this->detail_remarks;

        if (!$product_loss->save()) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Product Detail Remarks and amount Insertion ////////////////////////////////////
        //////////////////////////// Purchase Invoice Insertion for Produced ////////////////////////////////////

        $purchase_invoice = new PurchaseInvoiceModel();

        $purchase_invoice = $this->AssignPurchaseInvoiceValues($purchase_invoice, $day_end, $user, 'pi', $this->produced_total_items, $request->ttlAmountForProduced, $voucher_code_produced .
            $product_loss_id, $this->detail_produced_remarks,$request->posting_reference);

        if ($purchase_invoice->save()) {
            $purchase_invoice_id = $purchase_invoice->pi_id;
        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Purchase Items Insertion for Produced ////////////////////////////////////

        $purchase_item = $this->AssignPurchaseInvoiceItemsValues($purchase_invoice_id, $new_produced_array, 'pii');

        if (!DB::table('financials_purchase_invoice_items')->insert($purchase_item)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Produced Warehouse Stock Insertion ////////////////////////////////////

        $warehouses = [];
        $warehouse = $this->AssignWarehouseStocksValues($warehouses, $new_produced_array, 1);

        if (!DB::table('financials_warehouse_stock')->insert($warehouse)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Produced Warehouse Stock Summary Insertion ////////////////////////////////////

        $warehouses_summary = [];
        $warehouse_stock_summary = $this->AssignWarehouseStocksSummaryValues($warehouses_summary, $new_produced_array, 'PRODUCT PRODUCED');

        if (!DB::table('financials_warehouse_stock_summary')->insert($warehouse_stock_summary)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Produced Stock Movement Insertion ////////////////////////////////////

        $stock_movement = $this->stock_movement_module_produced($new_produced_array, $purchase_voucher_code . $purchase_invoice_id, 'STOCK PRODUCED', 'PRODUCT PRODUCED');

        if (!$stock_movement) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

//        //////////////////////////// Stock Movement Child Insertion ////////////////////////////////////
//        $stock_movement_child = $this->stock_movement_child($new_produced_array, $purchase_invoice_id, $account_code, $account_name, 'PURCHASE');
//
//        if (!$stock_movement_child) {
//            $rollBack = true;
//            DB::rollBack();
//            return redirect()->back()->with('fail', 'Failed Try Again');
//        }
//..............................................................................................................
        //////////////////////////// Purchase Return Invoice Insertion for Consumed ////////////////////////////////////

        $purchase_return_invoice = new PurchaseReturnInvoiceModel();

        $purchase_return_invoice = $this->AssignPurchaseInvoiceValues($purchase_return_invoice, $day_end, $user, 'pri', $this->consumed_total_items, $request->ttlAmountForConsumed,
            $voucher_code_consumed .
            $product_loss_id, $this->detail_consumed_remarks,$request->posting_reference);

        if ($purchase_return_invoice->save()) {
            $purchase_return_invoice_id = $purchase_return_invoice->pri_id;
        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Purchase Return Items Insertion for Consumed ////////////////////////////////////

        $purchase_return_item = $this->AssignPurchaseInvoiceItemsValues($purchase_return_invoice_id, $new_consumed_array, 'prii');

        if (!DB::table('financials_purchase_return_invoice_items')->insert($purchase_return_item)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Consumed Warehouse Stock Insertion ////////////////////////////////////

        $warehouses = [];
        $warehouse = $this->AssignWarehouseStocksValues($warehouses, $new_consumed_array, 1);

        if (!DB::table('financials_warehouse_stock')->insert($warehouse)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Consumed Warehouse Stock Summary Insertion ////////////////////////////////////

        $warehouses_summary = [];
        $warehouse_stock_summary = $this->AssignWarehouseStocksSummaryValues($warehouses_summary, $new_consumed_array, 'PRODUCT CONSUMED');

        if (!DB::table('financials_warehouse_stock_summary')->insert($warehouse_stock_summary)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Consumed Stock Movement Insertion ////////////////////////////////////

        $stock_movement = $this->stock_movement_module_purchase_return($new_consumed_array, $purchase_return_voucher_code . $purchase_return_invoice_id, 'PURCHASE CONSUMED', 'PRODUCT_CONSUMED');

        if (!$stock_movement) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

//:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

        //////////////////////////// PRODUCED TRANSACTION ////////////////////////////////////

        $transactions = new TransactionModel();

        $transaction = $this->AssignTransactionsValues($transactions, config('global_variables.product_stock_produced'), $request->ttlAmountForProduced, config('global_variables.production_stock_adjustment'),
            $notes, $transaction_type, $product_loss_id);

        if ($transaction->save()) {

            $transaction_id = $transaction->trans_id;

            $balances1 = new BalancesModel();

            $balance1 = $this->AssignAccountBalancesValues($balances1, $transaction_id, config('global_variables.production_stock_adjustment'), $request->ttlAmountForProduced, 'Cr', $request->remarks,
                $notes, $this->detail_produced_remarks, $voucher_code_produced . $product_loss_id,$request->posting_reference);


            if (!$balance1->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            $balances2 = new BalancesModel();

            $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id, config('global_variables.product_stock_produced'), $request->ttlAmountForProduced, 'Dr', $request->remarks, $notes, $this->detail_produced_remarks,
                $voucher_code_produced . $product_loss_id, $request->posting_reference);


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

//::::::::::::::::::::::::::::::::::::::::::::::::: CONSUMED ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

        //////////////////////////// Consumed TRANSACTION ////////////////////////////////////

        $transactions = new TransactionModel();

        $transaction = $this->AssignTransactionsValues($transactions, config('global_variables.production_stock_adjustment'), $request->ttlAmountForConsumed, config('global_variables.product_consumed_stock_account'),
            $notes, $transaction_type, $product_loss_id);

        if ($transaction->save()) {

            $transaction_id = $transaction->trans_id;

            $balances1 = new BalancesModel();

            $balance1 = $this->AssignAccountBalancesValues($balances1, $transaction_id, config('global_variables.production_stock_adjustment'), $request->ttlAmountForConsumed, 'Dr', $request->remarks,
                $notes, $this->detail_consumed_remarks, $voucher_code_consumed . $product_loss_id, $request->posting_reference);

            if (!$balance1->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            $balances2 = new BalancesModel();

            $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id, config('global_variables.product_consumed_stock_account'), $request->ttlAmountForConsumed, 'Cr', $request->remarks, $notes,
                $this->detail_consumed_remarks,
                $voucher_code_consumed . $product_loss_id, $request->posting_reference);

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

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {

            $user = Auth::User();

//            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Pack With Id: ' . $product_recipe->pp_id . ' And Name: ' . $product_recipe->pp_name);

            DB::commit();

            // WizardController::updateWizardInfo(['product_recipe'], []);

            return redirect()->back()->with('success', 'Successfully Saved');
        }


    }

    public function validation($request)
    {
        return $this->validate($request, [
//            'recipe_name' => ['required', 'string'],
//            'remarks' => ['nullable', 'string'],
//            'primary_limited_product_code' => ['nullable', 'string'],
//            'primary_limited_product_title' => ['nullable', 'string'],
//            'primary_limited_product_quantity' => ['nullable', 'string'],
//            'manufacture_product_code' => ['required', 'string'],
//            'manufacture_product_name' => ['required', 'string'],
//            'manufacture_qty' => ['required', 'numeric', 'min:1'],
//            'total_items' => ['required', 'numeric', 'min:1'],
//            'total_price' => ['required', 'numeric'],
//            'salesval' => ['required', 'string'],
            'cartDataForProductRecipe' => ['required', 'string'],
//            'cartDataForExpense' => ['required', 'string'],
            'cartDataForFinishedGoods' => ['required', 'string'],
        ]);
    }

    public function assign_product_values($request, $product_loss)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $product_loss->psa_account_uid = config('global_variables.product_consumed_stock_account');

        $account_name = $this->get_account_name(config('global_variables.product_consumed_stock_account'));

        $product_loss->psa_account_name = ucwords($account_name);
//        $product_loss->psa_pro_total_item = $request->total_items;
        $product_loss->psa_remarks = ucfirst($request->voucher_remarks);
        $product_loss->psa_consumed_total_amount = $request->ttlAmountForConsumed;
        $product_loss->psa_produced_total_amount = $request->ttlAmountForProduced;
        $product_loss->psa_user_id = $user->user_id;
        $product_loss->psa_pr_id = $request->posting_reference;
//        $product_loss->psa_status = $status;
        $product_loss->psa_datetime = Carbon::now()->toDateTimeString();
        $product_loss->psa_day_end_id = $day_end->de_id;
        $product_loss->psa_day_end_date = $day_end->de_datetime;
        $product_loss->psa_brwsr_info = $brwsr_rslt;
        $product_loss->psa_ip_adrs = $ip_rslt;
//        $product_loss->psa_update_datetime = Carbon::now()->toDateTimeString();

        return $product_loss;
    }

    public function assign_consumed_values($products_array, $product_loss_id)
    {
        $this->detail_remarks .= 'Consumed Stock' . config('global_variables.Line_Break');
        $data = [];
        foreach ($products_array as $value) {
            $this->consumed_total_items = $this->consumed_total_items + 1;
            $this->new_consumed_value_array[] = $value;

            $this->detail_remarks .= $value['product_name'] . ', ' . $value['product_qty'] . '@' . $value['product_rate'] . ' = ' . $value['product_amount'] . config('global_variables.Line_Break');

            $this->detail_consumed_remarks .= $value['product_name'] . ', ' . $value['product_qty'] . '@' . $value['product_rate'] . ' = ' . $value['product_amount'] . config('global_variables.Line_Break');

            $data[] = [
                'cs_psa_id' => $product_loss_id,
                'cs_warehouse_id' => $value['warehouse'],
                'cs_warehouse_name' => $value['warehouse_name'],
                'cs_pro_code' => $value['product_code'],
                'cs_pro_title' => $value['product_name'],
                'cs_quantity' => $value['product_qty'],
                'cs_rate' => $value['product_rate'],
                'cs_amount' => $value['product_amount'],
                'cs_scale_size' => $value['product_unit_measurement_scale_size'],
                'cs_uom' => $value['product_unit_measurement'],
                'cs_remarks' => ucfirst($value['product_remarks'])
            ];
        }
        return $data;
    }

    public function assign_produced_values($products_array, $product_loss_id)
    {
        $this->detail_remarks .= 'Produced Stock' . config('global_variables.Line_Break');
        $data = [];
        foreach ($products_array as $value) {
            $this->produced_total_items = $this->produced_total_items + 1;
            $this->new_produced_value_array[] = $value;

            $this->detail_remarks .= $value['product_name'] . ', ' . $value['product_qty'] . '@' . $value['product_rate'] . ' = ' . $value['product_amount'] . config('global_variables.Line_Break');

            $this->detail_produced_remarks .= $value['product_name'] . ', ' . $value['product_qty'] . '@' . $value['product_rate'] . ' = ' . $value['product_amount'] . config('global_variables.Line_Break');

            $data[] = [
                'ps_psa_id' => $product_loss_id,
                'ps_warehouse_id' => $value['warehouse'],
                'ps_warehouse_name' => $value['warehouse_name'],
                'ps_pro_code' => $value['product_code'],
                'ps_pro_title' => $value['product_name'],
                'ps_quantity' => $value['product_qty'],
                'ps_rate' => $value['product_rate'],
                'ps_amount' => $value['product_amount'],
                'ps_scale_size' => $value['product_unit_measurement_scale_size'],
                'ps_uom' => $value['product_unit_measurement'],
                'ps_remarks' => ucfirst($value['product_remarks'])
            ];
        }
        return $data;
    }

    public function AssignPurchaseInvoiceValues($purchase_invoice, $day_end, $user, $prfx, $total_no_of_items, $total_amount, $invoice_remarks, $invoice_detail_remarks,$posting_reference_id)
    {//status 1 for products and 2 for services
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $party_code = $prfx . '_party_code';
        $party_name = $prfx . '_party_name';
        $customer_name = $prfx . '_customer_name';
        $posting_reference = $prfx . '_pr_id';
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

        $account_name = $this->get_account_name(config('global_variables.product_consumed_stock_account'));

        $purchase_invoice->$party_code = config('global_variables.product_consumed_stock_account');
        $purchase_invoice->$party_name = $account_name;
        $purchase_invoice->$customer_name = '';
        $purchase_invoice->$posting_reference = $posting_reference_id;
        $purchase_invoice->$remarks = ucfirst($invoice_remarks);
        $purchase_invoice->$total_items = $total_no_of_items;
        $purchase_invoice->$total_price = $total_amount;
        $purchase_invoice->$product_discount = 0;
        $purchase_invoice->$round_off_discount = 0;
        $purchase_invoice->$cash_disc_percentage = 0;
        $purchase_invoice->$cash_disc_amount = 0;
        $purchase_invoice->$total_discount = 0;
        $purchase_invoice->$inclusive_sales_tax = 0;
        $purchase_invoice->$exclusive_sales_tax = 0;
        $purchase_invoice->$total_sales_tax = 0;
        $purchase_invoice->$grand_total = $total_amount;
        $purchase_invoice->$cash_paid = 0;
        $purchase_invoice->$datetime = Carbon::now()->toDateTimeString();
        $purchase_invoice->$day_end_id = $day_end->de_id;
        $purchase_invoice->$day_end_date = $day_end->de_datetime;
        $purchase_invoice->$createdby = $user->user_id;
        $purchase_invoice->$detail_remarks = $invoice_detail_remarks;
        $purchase_invoice->$brwsr_info = $brwsr_rslt;
        $purchase_invoice->$ip_adrs = $ip_rslt;
        $purchase_invoice->$update_datetime = Carbon::now()->toDateTimeString();


        return $purchase_invoice;



    }

    public function AssignPurchaseInvoiceItemsValues($invoice_id, $array, $prfx)
    {
        $data = [];

        foreach ($array as $value) {
            $sale_invoice = $prfx . '_purchase_invoice_id';
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

            $data[] = [
                $sale_invoice => $invoice_id,
                $product_code => $value['product_code'],
                $product_name => ucwords($value['product_name']),
                $remarks => ucfirst($value['product_remarks']),
                $qty => $value['product_qty'],
                $uom => $value['product_unit_measurement'],
                $scale_size => $value['product_unit_measurement_scale_size'],
                $bonus_qty => 0,
                $rate => $value['product_rate'],
                $net_rate => $value['product_rate'],
                $discount_per => 0,
                $discount_amount => 0,
                $after_dis_rate => $value['product_amount'],
                $saletax_per => 0,
                $saletax_inclusive => 0,
                $saletax_amount => 0,
                $amount => $value['product_amount'],
            ];
        }

        return $data;
    }

    // update code by shahzaib start
    public function production_stock_adjustment_list(Request $request, $array = null, $str = null)
    {
//        $heads = config('global_variables.all_expense_accounts');
//        $heads = explode(',', $heads);
//
//        $accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)->orderBy('account_uid', 'ASC')->get();
        $search_products = ProductModel::orderBy('pro_title', 'ASC')->get();

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_product = (!isset($request->product) && empty($request->product)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->product;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
//        $search_account = $request->account;
        $prnt_page_dir = 'print.product_loss_list.product_loss_list';
        $pge_title = 'Production Stock Adjustment List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_product, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));


        $query = ProductionStockAdjustmentModel::query();

        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('psa_id', 'like', '%' . $search . '%')
                    ->orWhere('psa_account_uid', 'like', '%' . $search . '%')
                    ->orWhere('psa_produced_total_amount', 'like', '%' . $search . '%')
                    ->orWhere('psa_consumed_total_amount', 'like', '%' . $search . '%')
                    ->orWhere('psa_remarks', 'like', '%' . $search . '%')
                    ->orWhere('psa_detail_remarks', 'like', '%' . $search . '%');
            });
        }

//        if (isset($search_account) && !empty($search_account)) {
//            $pagination_number = 1000000;
//
//            $query->where('plr_account_uid', $search_account);
//        }
        if (!empty($search_product)) {
//            $get_p_id = ProductLossRecoverItemsModel::where('plri_pro_id', $search_product)->pluck('plri_plr_id')->all();

//            $query->whereIn('plr_id', $get_p_id);
        }

        if (!empty($search_by_user)) {
            $query->where('psa_user_id', $search_by_user);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereBetween('psa_day_end_date', [$start, $end]);
        } elseif (!empty($search_to)) {
            $query->where('psa_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('psa_day_end_date', $end);
        }

        $datas = $query->orderBy('psa_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

//        if (isset($request->search) && !empty($request->search)) {
//
//            $search = $request->search;
//
//            $products = ProductLossRecoverModel::where('plr_status', 'LOSS')
//                ->where(function ($query) use ($search) {
//                    $query->where('plr_id', 'like', '%' . $search . '%')
//                        ->orWhere('plr_account_uid', 'like', '%' . $search . '%')
//                        ->orWhere('plr_pro_total_item', 'like', '%' . $search . '%')
//                        ->orWhere('plr_pro_total_amount', 'like', '%' . $search . '%')
//                        ->orWhere('plr_remarks', 'like', '%' . $search . '%')
//                        ->orWhere('plr_detail_remarks', 'like', '%' . $search . '%');
//                })
//                ->orderBy('plr_id', 'DESC')
//                ->paginate(1000000);
//
//        } else {
//
//            $products = ProductLossRecoverModel::where('plr_status', 'LOSS')
//                ->orderBy('plr_id', 'DESC')
//                ->paginate(10);
//        }

        $product = ProductModel::orderBy('pro_title', 'ASC')->pluck('pro_title')->all();


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl'=>[
                    'verify_peer'=>FALSE,
                    'verify_peer_name'=>FALSE,
                    'allow_self_signed'=>TRUE,
                ]
            ]);
            $optionss =[
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled'=>true, 'isRemoteEnabled'=>true]);
            $pdf->getDomPDF()->setHttpContext($options,$optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('production_stock_adjustment_list', compact('datas', 'search', 'product', 'search_products', 'search_product', 'search_to', 'search_from', 'search_by_user'));
        }

    }

    // update code by shahzaib end


    public function production_stock_consumed_produced_items_view_details(Request $request)
    {
        $items = ConsumedStockModel::where('cs_psa_id', $request->id)->orderby('cs_pro_title', 'ASC')->get();

        return response()->json($items);
    }

    public function production_stock_consumed_produced_items_view_details_SH(Request $request, $id)
    {

        $pim = ProductionStockAdjustmentModel::where('psa_id', $id)->first();
        $accnts = AccountRegisterationModel::where('account_uid', $pim->psa_account_uid)->first();
        $user = User::where('user_id', $pim->psa_user_id)->first();
        $produced = DB::table('financials_produced_stock as ps')
            ->where('ps_psa_id', $id)
            ->orderby('ps_pro_title', 'ASC')
            ->select('ps.ps_pro_code as pro_code','ps.ps_pro_title as pro_name','ps.ps_remarks as remarks','ps.ps_quantity as quantity','ps.ps_rate as rate','ps.ps_amount as amount','ps.ps_uom as uom','ps.ps_scale_size as scale_size','ps.ps_status as status');
        $piims = DB::table('financials_consumed_stock as cs')
            ->where('cs_psa_id', $id)
            ->orderby('cs_pro_title', 'ASC')
            ->select('cs.cs_pro_code as pro_code','cs.cs_pro_title as pro_name','cs.cs_remarks as remarks','cs.cs_quantity as quantity','cs.cs_rate as rate','cs.cs_amount as amount','cs.cs_uom as uom','cs.cs_scale_size as scale_size','cs.cs_status as status')
            ->union($produced)->get();
        $total = $pim->psa_consumed_total_amount + $pim->psa_produced_total_amount;
        $nbrOfWrds = $this->myCnvrtNbr($total);
        $invoice_nbr = $pim->psa_id;
        $invoice_date = $pim->psa_day_end_date;
        $invoice_remarks = $pim->psa_remarks;
        $type = 'grid';
        $pge_title = 'Produced & Consumed Invoice';


        return view('invoice_view.production_stock_adjustment.production_stock_adjustment_invoice_list_modal', compact('piims', 'pim', 'accnts', 'user', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));

    }

    public function production_stock_consumed_produced_items_view_details_pdf_SH(Request $request, $id)
    {

        $pim = ProductionStockAdjustmentModel::where('psa_id', $id)->first();
        $accnts = AccountRegisterationModel::where('account_uid', $pim->psa_account_uid)->first();
        $user = User::where('user_id', $pim->psa_user_id)->first();
        $produced = DB::table('financials_produced_stock as ps')
            ->where('ps_psa_id', $id)
            ->orderby('ps_pro_title', 'ASC')
            ->select('ps.ps_pro_code as pro_code','ps.ps_pro_title as pro_name','ps.ps_remarks as remarks','ps.ps_quantity as quantity','ps.ps_rate as rate','ps.ps_amount as amount','ps.ps_uom as uom','ps.ps_scale_size as scale_size','ps.ps_status as status');
        $piims = DB::table('financials_consumed_stock as cs')
            ->where('cs_psa_id', $id)
            ->orderby('cs_pro_title', 'ASC')
            ->select('cs.cs_pro_code as pro_code','cs.cs_pro_title as pro_name','cs.cs_remarks as remarks','cs.cs_quantity as quantity','cs.cs_rate as rate','cs.cs_amount as amount','cs.cs_uom as uom','cs.cs_scale_size as scale_size','cs.cs_status as status')
            ->union($produced)->get();
        $total = $pim->psa_consumed_total_amount + $pim->psa_produced_total_amount;
        $nbrOfWrds = $this->myCnvrtNbr($total);
        $invoice_nbr = $pim->psa_id;
        $invoice_date = $pim->psa_day_end_date;
        $invoice_remarks = $pim->psa_remarks;
        $type = 'pdf';
        $pge_title = 'Produced & Consumed Invoice';


        $footer = view('invoice_view._partials.pdf_footer')->render();
        $header = view('invoice_view._partials.pdf_header', compact('invoice_nbr', 'invoice_date', 'pge_title', 'type', 'invoice_remarks'))->render();
        $options = stream_context_create([
            'ssl'=>[
                'verify_peer'=>FALSE,
                'verify_peer_name'=>FALSE,
                'allow_self_signed'=>TRUE,
            ]
        ]);
        $optionss =[
            'footer-html' => $footer,
            'header-html' => $header,
            'margin-top' => 24,
        ];
        $pdf = PDF::setOptions(['isHTML5ParserEnabled'=>true, 'isRemoteEnabled'=>true]);
        $pdf->getDomPDF()->setHttpContext($options,$optionss);
        $pdf->loadView('invoice_view.production_stock_adjustment.production_stock_adjustment_invoice_list_modal', compact('piims', 'pim', 'accnts', 'user', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));
        // $pdf->setOptions($options);


        return $pdf->stream('Production-Stock-Adjustment-Detail.pdf');

    }

    public function product_consumed_items_view_details_pdf_SH(Request $request, $id)
    {
        $pim = ProductionStockAdjustmentModel::where('psa_id', $id)->first();
        $accnts = AccountRegisterationModel::where('account_uid', $pim->psa_account_uid)->first();
        $user = User::where('user_id', $pim->psa_user_id)->first();
        $piims = ConsumedStockModel::where('cs_psa_id', $id)->orderby('cs_pro_title', 'ASC')->get();
        $nbrOfWrds = $this->myCnvrtNbr($pim->psa_consumed_total_amount);
        $invoice_nbr = $pim->psa_id;
        $invoice_date = $pim->psa_datetime;
        $invoice_remarks = $pim->psa_remarks;
        $type = 'pdf';
        $pge_title = 'Product Consumed Invoice';

        $footer = view('invoice_view._partials.pdf_footer')->render();
        $header = view('invoice_view._partials.pdf_header', compact('invoice_nbr', 'invoice_date', 'pge_title', 'type', 'invoice_remarks'))->render();
        $options = [
            'footer-html' => $footer,
            'header-html' => $header,
            'margin-top' => 25,
        ];

        $pdf = PDF::loadView('invoice_view.product_consumed_invoice.product_consumed_invoice_list_modal', compact('piims', 'pim', 'accnts', 'user', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));
        $pdf->setOptions($options);


        return $pdf->stream('Product-Consumed-Invoice-Detail.pdf');

    }

    public function product_produced_items_view_details_pdf_SH(Request $request, $id)
    {
        $pim = ProductionStockAdjustmentModel::where('psa_id', $id)->first();
        $accnts = AccountRegisterationModel::where('account_uid', $pim->psa_account_uid)->first();
        $user = User::where('user_id', $pim->psa_user_id)->first();
        $piims = ProducedStockModel::where('ps_psa_id', $id)->orderby('ps_pro_title', 'ASC')->get();
        $nbrOfWrds = $this->myCnvrtNbr($pim->psa_produced_total_amount);
        $invoice_nbr = $pim->psa_id;
        $invoice_date = $pim->psa_datetime;
        $invoice_remarks = $pim->psa_remarks;
        $type = 'pdf';
        $pge_title = 'Product Produced Invoice';

        $footer = view('invoice_view._partials.pdf_footer')->render();
        $header = view('invoice_view._partials.pdf_header', compact('invoice_nbr', 'invoice_date', 'pge_title', 'type', 'invoice_remarks'))->render();
        $options = [
            'footer-html' => $footer,
            'header-html' => $header,
            'margin-top' => 25,
        ];

        $pdf = PDF::loadView('invoice_view.product_produced_invoice.product_produced_invoice_list_modal', compact('piims', 'pim', 'accnts', 'user', 'nbrOfWrds', 'invoice_nbr', 'invoice_date',
            'invoice_remarks', 'type', 'pge_title'));
        $pdf->setOptions($options);


        return $pdf->stream('Product-Consumed-Invoice-Detail.pdf');

    }
}
