<?php

namespace App\Http\Controllers\TradeInvoices;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\DayEndController;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\PostingReferenceModel;
use App\Models\ProductLossRecoverItemsModel;
use App\Models\ProductLossRecoverModel;
use App\Models\ProductModel;
use App\Models\SaleInvoiceModel;
use App\Models\TransactionModel;
use App\Models\WarehouseModel;
use App\User;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class TradeProductLossController extends Controller
{
    public $detail_remarks = '';
    public $total_amount = 0;
    public $new_value_array = [];

    public function trade_product_loss()
    {
        $heads = config('global_variables.all_expense_accounts');
        $heads = explode(',', $heads);

        $accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)->where('account_delete_status', '!=', 1)->where('account_disabled', '!=', 1)->orderBy('account_uid', 'ASC')->get();

        $products = $this->get_all_products();//->whereIn('pro_product_type_id',[1,2,3]);

        $pro_code = '';
        $pro_name = '';

        foreach ($products as $product) {
            $pro_title = $this->RemoveSpecialChar($product->pro_title);

            $pro_code .= "<option value='$product->pro_p_code' data-parent='$product->pro_p_code' data-purchase_price='$product->pro_sale_price'>$product->pro_p_code</option>";
            $pro_name .= "<option value='$product->pro_p_code' data-parent='$product->pro_p_code' data-purchase_price='$product->pro_sale_price'>$pro_title</option>";
        }

//        $warehouses = WarehouseModel::where('wh_delete_status', '!=', 1)->where('wh_disabled', '!=', 1)->orderBy('wh_title', 'ASC')->get();
//        $posting_references = PostingReferenceModel::where('pr_disabled','=',0)->get();

        return view('Trade_Invoices/trade_product_loss', compact('accounts', 'pro_code', 'pro_name'));
    }

    public function submit_trade_product_loss(Request $request)
    {
        $product_total_items = 0;
        $product_grand_total = 0;
        $this->product_validation($request);

        $rollBack = false;

        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        DB::beginTransaction();

//        $values_array = json_decode($request->products_array, true);

        $requested_arrays = $request->pro_code;

        foreach ($requested_arrays as $index => $requested_array) {

            $item_code = $request->pro_code[$index];
            $item_name = $request->pro_name[$index];
            $item_remarks = $request->product_remarks[$index];
            $item_warehouse = isset($request->warehouse[$index]) ? $request->warehouse[$index] : 0;
            $item_unit_measurement = $request->unit_measurement[$index];
            $item_unit_measurement_scale_size = $request->unit_measurement_scale_size[$index];
            $item_quantity = $request->quantity[$index];
            $item_rate = $request->rate[$index];
            $item_amount = $request->amount[$index];

//            if ($request->product_or_service_status[$index] == 0) {

                $product_total_items++;
//
                $product_grand_total += $item_amount;

                $values_array[] = [
                    'product_code' => $item_code,
                    'product_name' => $item_name,
                    'product_remarks' => $item_remarks,
                    'warehouse' => $item_warehouse,
                    'product_qty' => $item_quantity,
                    'product_unit_measurement' => $item_unit_measurement,
                    'product_unit_scale_size' => $item_unit_measurement_scale_size, //mustafa
                    'product_rate' => $item_rate,
                    'product_amount' => $item_amount,
                ];
//            }
        }


        $notes = 'TRADE_PRODUCT_LOSS';
        $voucher_code = config('global_variables.TRADE_PRODUCT_LOSS_VOUCHER_CODE');
        $transaction_type = config('global_variables.PRODUCT_LOSS');

        $sale_notes = 'PRODUCT_LOSS_SI'; //mustafa
//        $sale_notes = 'SALE_INVOICE';
//        $sale_voucher_code = config('global_variables.SALE_VOUCHER_CODE');
        $sale_voucher_code = config('global_variables.TRADE_PRODUCT_LOSS_VOUCHER_CODE');//mustafa

        $sale_transaction_type = config('global_variables.SALE');

        //////////////////////////// Product Insertion ////////////////////////////////////

        $product_loss = new ProductLossRecoverModel();

        $product_loss = $this->assign_product_values($request, $product_loss, 'LOSS');

        if ($product_loss->save()) {
            $product_loss_id = $product_loss->plr_id;
        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Product Items Insertion ////////////////////////////////////

        $item = $this->assign_product_items_values($values_array, $product_loss_id);

        if (!DB::table('financials_product_loss_recover_items')->insert($item)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        $new_array = $this->new_value_array;


        //////////////////////////// Product Detail Remarks and amount Insertion ////////////////////////////////////

        $product_loss->plr_detail_remarks = $this->detail_remarks;
        $product_loss->plr_pro_total_amount = $this->total_amount;

        $amount = $this->total_amount;

        if (!$product_loss->save()) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }


        //////////////////////////// Sale Invoice Insertion ////////////////////////////////////

        $sale_invoice = new SaleInvoiceModel();

        $sale_invoice = $this->AssignSaleInvoiceValues($sale_invoice, $day_end, $user, 'si', $request->total_items, $amount, $voucher_code . $product_loss_id, $this->detail_remarks, $request->posting_reference);

        if ($sale_invoice->save()) {
            $sale_invoice_id = $sale_invoice->si_id;
        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Sale Items Insertion ////////////////////////////////////

        $sale_item = $this->AssignSaleInvoiceItemsValues($sale_invoice_id, $new_array, 'sii');

        if (!DB::table('financials_sale_invoice_items')->insert($sale_item)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }


        //////////////////////////// Product Inventory Insertion ////////////////////////////////////

//        $inventory = $this->AssignProductInventoryValues($new_array, 2);
//
//        if (!$inventory) {
//            $rollBack = true;
//            DB::rollBack();
//            return redirect()->back()->with('fail', 'Failed Try Again');
//        }

        //////////////////////////// Warehouse Stock Insertion ////////////////////////////////////

        $warehouses = [];
        $warehouse = $this->AssignWarehouseStocksValues($warehouses, $new_array, 2);

        if (!DB::table('financials_warehouse_stock')->insert($warehouse)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Warehouse Stock Summary Insertion ////////////////////////////////////

        $warehouses_summary = [];
        $warehouse_stock_summary = $this->AssignWarehouseStocksSummaryValues($warehouses_summary, $new_array, 'PRODUCT LOSS');

        if (!DB::table('financials_warehouse_stock_summary')->insert($warehouse_stock_summary)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Stock Movement Insertion ////////////////////////////////////

        $stock_movement = $this->stock_movement_module_product_loss($new_array, $sale_voucher_code . $sale_invoice_id, 'PRODUCT LOSS', 'PRODUCT_LOSS');

        if (!$stock_movement) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }


        //////////////////////////// TRANSACTION ////////////////////////////////////

        $transactions = new TransactionModel();

        $transaction = $this->AssignTransactionsValues($transactions, config('global_variables.product_loss_recover_account'), $amount, config('global_variables.stock_in_hand'),
            $notes, $transaction_type, $product_loss_id);

        if ($transaction->save()) {

            $transaction_id = $transaction->trans_id;

            $balances1 = new BalancesModel();

            $balance1 = $this->AssignAccountBalancesValues($balances1, $transaction_id, config('global_variables.product_loss_recover_account'), $amount, 'Dr', $request->remarks,
                $notes, $this->detail_remarks, $voucher_code . $product_loss_id, $request->posting_reference);

            if (!$balance1->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            $balances2 = new BalancesModel();

            $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id, config('global_variables.stock_in_hand'), $amount, 'Cr', $request->remarks, $notes, $this->detail_remarks,
                $voucher_code . $product_loss_id, $request->posting_reference);

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


        //////////////////////////// TRANSACTION Two Sale Account ////////////////////////////////////

        $transactions2 = new TransactionModel();

        $transaction2 = $this->AssignTransactionsValues($transactions2, 0, $amount, config('global_variables.product_recover_loss'), $sale_notes, $sale_transaction_type, $sale_invoice_id); //mustafa
//        $transaction2 = $this->AssignTransactionsValues($transactions2, 0, $amount, config('global_variables.sale_account'), $sale_notes, $sale_transaction_type, $sale_invoice_id);

        if ($transaction2->save()) {

            $transaction_id2 = $transaction2->trans_id;

            $balances3 = new BalancesModel();

            $balance3 = $this->AssignAccountBalancesValues($balances3, $transaction_id2, config('global_variables.product_recover_loss'), $amount, 'Cr', $request->remarks,
                $sale_notes, $this->detail_remarks, $sale_voucher_code . $sale_invoice_id, $request->posting_reference); //mustafa

//            $balance3 = $this->AssignAccountBalancesValues($balances3, $transaction_id2, config('global_variables.sale_account'), $amount, 'Cr', $request->remarks,
//                $sale_notes, $this->detail_remarks, $sale_voucher_code . $sale_invoice_id);

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

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $product_loss_id);

            DB::commit();
//            return redirect()->back()->with('success', 'Successfully Saved');
            return redirect()->back()->with(['pl_id' => $product_loss_id]);
        }
    }

    public function product_validation($request)
    {
        return $this->validate($request, [
            'remarks' => ['required', 'string'],
            'total_items' => ['required', 'numeric', 'min:1'],
//            'products_array' => ['required', 'string'],

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
            'rate' => ['required', 'array'],
            'rate.*' => ['required', 'numeric'],

        ]);
    }

    public function assign_product_values($request, $product_loss, $status)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $product_loss->plr_account_uid = config('global_variables.product_loss_recover_account');

        $account_name = $this->get_account_name(config('global_variables.product_loss_recover_account'));

        $product_loss->plr_account_name = ucwords($account_name);
        $product_loss->plr_pro_total_item = $request->total_items;
        $product_loss->plr_pr_id = $request->posting_reference;
        $product_loss->plr_remarks = ucfirst($request->remarks);
        $product_loss->plr_user_id = $user->user_id;
        $product_loss->plr_status = $status;
        $product_loss->plr_datetime = Carbon::now()->toDateTimeString();
        $product_loss->plr_day_end_id = $day_end->de_id;
        $product_loss->plr_day_end_date = $day_end->de_datetime;
        $product_loss->plr_brwsr_info = $brwsr_rslt;
        $product_loss->plr_ip_adrs = $ip_rslt;
        $product_loss->plr_update_datetime = Carbon::now()->toDateTimeString();

        return $product_loss;
    }

    public function assign_product_items_values($products_array, $product_loss_id)
    {
        $data = [];
        foreach ($products_array as $value) {

            $product_stock = $this->product_stock_movement_last_row($value['product_code']);

            if (isset($product_stock)) {

                $rate = $product_stock->sm_bal_rate;
                $amount = $rate * $value['product_qty'];
            } else {

                $purchase_rate = $this->get_product_purchase_rate($value['product_code']);

                $rate = $purchase_rate;
                $amount = $purchase_rate * $value['product_qty'];
            }


//            $amount = $value['product_qty'] * $rate;

            $value['product_inclusive_rate'] = $rate;
            $value['product_bonus_qty'] = 0;
            $value['product_amount'] = $amount;

            $this->new_value_array[] = $value;

            $this->detail_remarks .= $value['product_name'] . ', ' . $value['product_qty'] . '@' . $rate . ' = ' . $amount  . config('global_variables.Line_Break');

            $this->total_amount += $amount;

            $data[] = [
                'plri_plr_id' => $product_loss_id,
                'plri_warehouse_id' => $value['warehouse'],
                'plri_pro_id' => $value['product_code'],
                'plri_pro_name' => $value['product_name'],
                'plri_pro_qty' => $value['product_qty'],
                'plri_scale_size' => $value['product_unit_scale_size'],
                'plri_pro_purchase_price' => $rate,
//                'plri_pro_purchase_price' => $rate,
                'plri_pro_total_amount' => $amount,
                'plri_remarks' => ucfirst($value['product_remarks'])
            ];
        }
        return $data;
    }

    public function AssignSaleInvoiceValues($sale_invoice, $day_end, $user, $prfx, $total_no_of_items, $total_amount, $invoice_remarks, $invoice_detail_remarks, $posting_id)
    {//status 1 for products and 2 for services
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
        $cash_paid = $prfx . '_cash_received';
        $datetime = $prfx . '_datetime';
        $day_end_id = $prfx . '_day_end_id';
        $day_end_date = $prfx . '_day_end_date';
        $createdby = $prfx . '_createdby';
        $detail_remarks = $prfx . '_detail_remarks';
        $ip_adrs = $prfx . '_ip_adrs';
        $brwsr_info = $prfx . '_brwsr_info';
        $update_datetime = $prfx . '_update_datetime';

        $account_name = $this->get_account_name(config('global_variables.product_loss_recover_account'));

        $sale_invoice->$party_code = config('global_variables.product_loss_recover_account');
        $sale_invoice->$party_name = $account_name;
        $sale_invoice->$posting_reference = $posting_id;
        $sale_invoice->$customer_name = '';
        $sale_invoice->$remarks = ucfirst($invoice_remarks);
        $sale_invoice->$total_items = $total_no_of_items;
        $sale_invoice->$total_price = $total_amount;
        $sale_invoice->$product_discount = 0;
        $sale_invoice->$round_off_discount = 0;
        $sale_invoice->$cash_disc_percentage = 0;
        $sale_invoice->$cash_disc_amount = 0;
        $sale_invoice->$total_discount = 0;
        $sale_invoice->$inclusive_sales_tax = 0;
        $sale_invoice->$exclusive_sales_tax = 0;
        $sale_invoice->$total_sales_tax = 0;
        $sale_invoice->$grand_total = $total_amount;
        $sale_invoice->$cash_paid = 0;
        $sale_invoice->$datetime = Carbon::now()->toDateTimeString();
        $sale_invoice->$day_end_id = $day_end->de_id;
        $sale_invoice->$day_end_date = $day_end->de_datetime;
        $sale_invoice->$createdby = $user->user_id;
        $sale_invoice->$detail_remarks = $invoice_detail_remarks;
        $sale_invoice->$brwsr_info = $brwsr_rslt;
        $sale_invoice->$ip_adrs = $ip_rslt;
        $sale_invoice->$update_datetime = Carbon::now()->toDateTimeString();

        return $sale_invoice;
    }

    public function AssignSaleInvoiceItemsValues($invoice_id, $array, $prfx)
    {
        $data = [];

        foreach ($array as $value) {

            $sale_invoice = $prfx . '_invoice_id';
            $product_code = $prfx . '_product_code';
            $product_name = $prfx . '_product_name';
            $remarks = $prfx . '_remarks';
            $scale_size = $prfx . '_scale_size';
            $qty = $prfx . '_qty';
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
                $scale_size => $value['product_unit_scale_size'],
                $qty => $value['product_qty'],
                $bonus_qty => 0,
                $rate => $value['product_inclusive_rate'],
                $net_rate => $value['product_inclusive_rate'],
                $discount_per => 0,
                $discount_amount => 0,
                $after_dis_rate => $value['product_inclusive_rate'],
                $saletax_per => 0,
                $saletax_inclusive => 0,
                $saletax_amount => 0,
                $amount => $value['product_amount'],
            ];
        }

        return $data;
    }


    public function trade_product_loss_list(Request $request, $array = null, $str = null)
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
        $pge_title = 'Trade Product Loss List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_product, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));


        $query = ProductLossRecoverModel::query();

        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('plr_id', 'like', '%' . $search . '%')
                    ->orWhere('plr_account_uid', 'like', '%' . $search . '%')
                    ->orWhere('plr_pro_total_item', 'like', '%' . $search . '%')
                    ->orWhere('plr_pro_total_amount', 'like', '%' . $search . '%')
                    ->orWhere('plr_remarks', 'like', '%' . $search . '%')
                    ->orWhere('plr_detail_remarks', 'like', '%' . $search . '%');
            });
        }

//        if (isset($search_account) && !empty($search_account)) {
//            $pagination_number = 1000000;
//
//            $query->where('plr_account_uid', $search_account);
//        }
        if (!empty($search_product)) {
            $get_p_id = ProductLossRecoverItemsModel::where('plri_pro_id', $search_product)->pluck('plri_plr_id')->all();

            $query->whereIn('plr_id', $get_p_id);
        }

        if (!empty($search_by_user)) {
            $query->where('plr_user_id', $search_by_user);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereBetween('plr_day_end_date', [$start, $end]);
        } elseif (!empty($search_to)) {
            $query->where('plr_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('plr_day_end_date', $end);
        }

        $datas = $query->where('plr_status', 'LOSS')
            ->orderBy('plr_id', config('global_variables.query_sorting'))
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
            return view('Trade_Invoices/trade_product_loss_list', compact('datas', 'search', 'product', 'search_products', 'search_product', 'search_to', 'search_from', 'search_by_user'));
        }

    }


    // update code by shahzaib end


    public function trade_product_loss_recover_items_view_details(Request $request)
    {
        $items = ProductLossRecoverItemsModel::where('plri_plr_id', $request->id)->orderby('plri_pro_name', 'ASC')->get();

        return response()->json($items);
    }

    public function trade_product_loss_recover_items_view_details_SH(Request $request, $id)
    {

        $pim = ProductLossRecoverModel::where('plr_id', $id)->first();
        $accnts = AccountRegisterationModel::where('account_uid', $pim->plr_account_uid)->first();
        $user = User::where('user_id', $pim->plr_user_id)->first();
        $piims = ProductLossRecoverItemsModel::where('plri_plr_id', $id)->orderby('plri_pro_name', 'ASC')->get();
        $nbrOfWrds = $this->myCnvrtNbr($pim->plr_pro_total_amount);
        $invoice_nbr = $pim->plr_id;
        $invoice_date = $pim->plr_datetime;
        $invoice_remarks = $pim->plr_remarks;
        $type = 'grid';
        $pge_title = 'Trade Product ' . ucfirst(strtolower($pim->plr_status)) . ' Invoice';


        return view('trade_invoice_view.trade_product_loss_invoice.trade_product_loss_invoice_list_modal', compact('piims', 'pim', 'accnts', 'user', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'invoice_remarks',
            'type', 'pge_title'));

    }

    public function trade_product_loss_recover_items_view_details_pdf_SH(Request $request, $id)
    {

        $pim = ProductLossRecoverModel::where('plr_id', $id)->first();
        $accnts = AccountRegisterationModel::where('account_uid', $pim->plr_account_uid)->first();
        $user = User::where('user_id', $pim->plr_user_id)->first();
        $piims = ProductLossRecoverItemsModel::where('plri_plr_id', $id)->orderby('plri_pro_name', 'ASC')->get();
        $nbrOfWrds = $this->myCnvrtNbr($pim->plr_pro_total_amount);
        $invoice_nbr = $pim->plr_id;
        $invoice_date = $pim->plr_datetime;
        $invoice_remarks = $pim->plr_remarks;
        $type = 'pdf';
        $pge_title = 'Trade Product ' . ucfirst(strtolower($pim->plr_status)) . ' Invoice';


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
        $pdf->loadView('trade_invoice_view.trade_product_loss_invoice.trade_product_loss_invoice_list_modal', compact('piims', 'pim', 'accnts', 'user', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));
        // $pdf->setOptions($options);


        return $pdf->stream('Product-Loss-Invoice-Detail.pdf');

    }



}
