<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\PostingReferenceModel;
use App\Models\ProductLossRecoverItemsModel;
use App\Models\ProductLossRecoverModel;
use App\Models\ProductModel;
use App\Models\SaleInvoiceModel;
use App\Models\SaleReturnInvoiceModel;
use App\Models\TransactionModel;
use App\Models\WarehouseModel;
use App\Models\WarehouseStockModel;
use Auth;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProductRecoverController extends Controller
{
    public function product_recover()
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
        return view('product_recover', compact('accounts', 'pro_code', 'pro_name'));
    }

    public function submit_product_recover(Request $request)
    {
        $product_loss_controller = new ProductLossController();
        $product_loss_controller->product_validation($request);

        $rollBack = false;

        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        DB::beginTransaction();

        $values_array = json_decode($request->products_array, true);

        $notes = 'PRODUCT_RECOVER';
        $voucher_code = config('global_variables.PRODUCT_RECOVER_VOUCHER_CODE');
        $transaction_type = config('global_variables.PRODUCT_RECOVER');

        $sale_notes = 'PRODUCT_RECOVER_SR';
//        $sale_voucher_code = config('global_variables.SALE_VOUCHER_CODE');
        $sale_voucher_code = config('global_variables.PRODUCT_RECOVER_VOUCHER_CODE');
        $sale_transaction_type = config('global_variables.SALE');

        //////////////////////////// Product Insertion ////////////////////////////////////

        $product_loss = new ProductLossRecoverModel();

        $product_loss = $product_loss_controller->assign_product_values($request, $product_loss, 'RECOVER');

        if ($product_loss->save()) {
            $product_loss_id = $product_loss->plr_id;
        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Product Items Insertion ////////////////////////////////////

        $item = $product_loss_controller->assign_product_items_values($values_array, $product_loss_id);

        if (!DB::table('financials_product_loss_recover_items')->insert($item)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }


        //////////////////////////// Product Detail Remarks and amount Insertion ////////////////////////////////////

        $product_loss->plr_detail_remarks = $product_loss_controller->detail_remarks;
        $product_loss->plr_pro_total_amount = $product_loss_controller->total_amount;

        $amount = $product_loss_controller->total_amount;

        if (!$product_loss->save()) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        $new_array = $product_loss_controller->new_value_array;


        //////////////////////////// Sale Invoice Insertion ////////////////////////////////////

        $sale_invoice = new SaleReturnInvoiceModel();

        $sale_invoice = $product_loss_controller->AssignSaleInvoiceValues($sale_invoice, $day_end, $user, 'sri', $request->total_items, $amount, $voucher_code . $product_loss_id,
            $product_loss_controller->detail_remarks, $request->posting_reference);

        if ($sale_invoice->save()) {
            $sale_invoice_id = $sale_invoice->sri_id;
        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Sale Items Insertion ////////////////////////////////////

        $sale_item = $product_loss_controller->AssignSaleInvoiceItemsValues($sale_invoice_id, $new_array, 'srii');

        if (!DB::table('financials_sale_return_invoice_items')->insert($sale_item)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Product Inventory Insertion ////////////////////////////////////

//        $inventory = $this->AssignProductInventoryValues($new_array, 1);
//
//        if (!$inventory) {
//            $rollBack = true;
//            DB::rollBack();
//            return redirect()->back()->with('fail', 'Failed Try Again');
//        }

        //////////////////////////// Warehouse Stock Insertion ////////////////////////////////////

        $warehouses = [];
        $warehouse = $this->AssignWarehouseStocksValues($warehouses, $new_array, 1);

        if (!DB::table('financials_warehouse_stock')->insert($warehouse)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Warehouse Stock Summary Insertion ////////////////////////////////////

        $warehouses_summary = [];
        $warehouse_stock_summary = $this->AssignWarehouseStocksSummaryValues($warehouses_summary, $new_array, 'PRODUCT RECOVER');

        if (!DB::table('financials_warehouse_stock_summary')->insert($warehouse_stock_summary)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Stock Movement Insertion ////////////////////////////////////

        $stock_movement = $this->stock_movement_module_product_recover($new_array, $sale_voucher_code . $sale_invoice_id, 'PRODUCT RECOVER', 'PRODUCT_RECOVER');

        if (!$stock_movement) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }


        //////////////////////////// TRANSACTION ////////////////////////////////////

        $transactions = new TransactionModel();

        $transaction = $this->AssignTransactionsValues($transactions, config('global_variables.stock_in_hand'), $amount, config('global_variables.product_loss_recover_account'),
            $notes, $transaction_type, $product_loss_id);

        if ($transaction->save()) {

            $transaction_id = $transaction->trans_id;

            $balances1 = new BalancesModel();

            $balance1 = $this->AssignAccountBalancesValues($balances1, $transaction_id, config('global_variables.product_loss_recover_account'), $amount, 'Cr', $request->remarks,
                $notes, $product_loss_controller->detail_remarks, $voucher_code . $product_loss_id, $request->posting_reference);


            if (!$balance1->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            $balances2 = new BalancesModel();

            $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id, config('global_variables.stock_in_hand'), $amount, 'Dr', $request->remarks, $notes, $product_loss_controller->detail_remarks,
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

//        $transaction2 = $this->AssignTransactionsValues($transactions2, config('global_variables.sales_returns_and_allowances'), $amount, 0, $sale_notes, $sale_transaction_type, $sale_invoice_id);
        $transaction2 = $this->AssignTransactionsValues($transactions2, config('global_variables.product_recover_loss'), $amount, 0, $sale_notes, $sale_transaction_type, $sale_invoice_id);

        if ($transaction2->save()) {

            $transaction_id2 = $transaction2->trans_id;

            $balances3 = new BalancesModel();

            $balance3 = $this->AssignAccountBalancesValues($balances3, $transaction_id2, config('global_variables.product_recover_loss'), $amount, 'Dr', $request->remarks,
                $sale_notes, $product_loss_controller->detail_remarks, $sale_voucher_code . $sale_invoice_id, $request->posting_reference);

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
            return redirect()->back()->with('success', 'Successfully Saved');
        }
    }

    // update code by shahzaib start
    public function product_recover_list(Request $request, $array = null, $str = null)
    {
        $search_products = ProductModel::orderBy('pro_title', 'ASC')->get();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_product = (!isset($request->product) && empty($request->product)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->product;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
//        $search_account = $request->account;
        $prnt_page_dir = 'print.product_recover_list.product_recover_list';
        $pge_title = 'Product Recover List';
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


        $datas = $query->where('plr_status', 'RECOVER')
            ->orderBy('plr_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

//        if (isset($request->search) && !empty($request->search)) {
//
//            $search = $request->search;
//
//            $products = ProductLossRecoverModel::where('plr_status', 'RECOVER')
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
//            $products = ProductLossRecoverModel::where('plr_status', 'RECOVER')
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
            return view('product_recover_list', compact('datas', 'search', 'product', 'search_products', 'search_product', 'search_to', 'search_from', 'search_by_user'));
        }


    }
    // update code by shahzaib end

}
