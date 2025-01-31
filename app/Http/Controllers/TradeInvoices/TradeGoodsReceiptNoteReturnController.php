<?php

namespace App\Http\Controllers\TradeInvoices;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DayEndController;
use App\Models\AccountRegisterationModel;
use App\Models\GoodsReceiptNoteItemsModel;
use App\Models\GoodsReceiptNoteLogModel;
use App\Models\GoodsReceiptNoteModel;
use App\Models\ProductModel;
use App\Models\ReportConfigModel;
use App\Models\GoodsReceiptNoteReturnItemsModal;
use App\Models\GoodsReceiptNoteReturnModal;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TradeGoodsReceiptNoteReturnController extends Controller
{
    public $grn_purchase_total_stock_amount=0;
    public function trade_goods_receipt_note_return()
    {
        $products = $this->get_all_products();//->whereIn('pro_product_type_id',[2,3]);

        $pro_code = '';
        $pro_name = '';

        foreach ($products as $product) {
            $pro_title = $this->RemoveSpecialChar($product->pro_title);

            $pro_code .= "<option value='$product->pro_p_code' data-parent='$product->pro_p_code' data-purchase_price='$product->pro_last_purchase_rate' data-sale_price='$product->pro_sale_price' data-unit='$product->unit_title' data-unit_scale_size='$product->unit_scale_size' data-main_unit='$product->mu_title'> $product->pro_p_code</option>";
            $pro_name .= "<option value='$product->pro_p_code' data-parent='$product->pro_p_code' data-purchase_price='$product->pro_last_purchase_rate' data-sale_price='$product->pro_sale_price' data-unit='$product->unit_title' data-unit_scale_size='$product->unit_scale_size' data-main_unit='$product->mu_title'> $pro_title</option>";
        }


        return view('Trade_Invoices/trade_goods_receipt_note_return', compact('pro_code', 'pro_name'));
    }

    public function submit_trade_goods_receipt_note_return(Request $request)
    {
        $this->goods_receipt_note_return_validation($request);

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $rollBack = false;

        $grnr_array = [];

        $account_code = $request->account_name;
        $account_name = $this->get_account_name($account_code);
        $invoice_type = $request->invoice_type;
        $requested_arrays = $request->pro_code;
        $goods_receipt_note = $request->invoice_nbr_chk;

        foreach ($requested_arrays as $index => $requested_array) {

            $item_grn_id = $request->grn_id[$index];
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

            $grnr_array[] = [
                'grn_id' => $item_grn_id,
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


        $user = Auth::user();


        DB::beginTransaction();

            $grnr_prefix = 'grnr';
            $grnr_items_prefix = 'grnri';

            $grnr_invoice = new GoodsReceiptNoteReturnModal();
            $grnr_item_table = 'financials_goods_receipt_note_return_items';

            $grn_log_prefix = 'grnl';
            $grn_log_table = 'financials_grn_log';
            $notes = 'GOODS_RECEIPT_NOTE_RETURN';

            $voucher_code = config('global_variables.TRADE_GOODS_RECEIPT_NOTE_RETURN_CODE');


        //////////////////////////// Purchase Invoice Insertion ////////////////////////////////////

        $grnr_invoice = $this->AssignGoodsReceiptNoteReturnValues($request, $grnr_invoice, $day_end, $user, $grnr_prefix);

        if ($grnr_invoice->save()) {

            $p_id = $grnr_prefix . '_id';

            $grnr_id = $grnr_invoice->$p_id;
        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Purchase Invoice Items Insertion ////////////////////////////////////
        $items = [];
        $detail_remarks = '';

        $item = $this->AssignGoodsReceiptNoteReturnItemsValues($items, $grnr_id, $grnr_array, $grnr_items_prefix);

        foreach ($item as $value) {

            $pro_rate = (float)$value[$grnr_items_prefix . '_rate'];
            $pro_amount =0;// (float)$value[$grnr_items_prefix . '_amount'];

            $detail_remarks .= $value[$grnr_items_prefix . '_product_name'] . ', ' . $value[$grnr_items_prefix . '_qty'] . '@' . number_format($pro_rate, 2) . ' = ' . number_format($pro_amount, 2)
                . config('global_variables.Line_Break');
        }

        if (!DB::table($grnr_item_table)->insert($item)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        $item_log = $this->AssignGoodsReceiptNoteValuesLog($grnr_id, $goods_receipt_note, $invoice_type, $grnr_array, $grn_log_prefix, 1);
        if (!DB::table($grn_log_table)->insert($item_log)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Details Remarks of Purchase Invoice Insertion ////////////////////////////////////

        $grnr_detail_remarks = $grnr_prefix . '_detail_remarks';

        $grnr_invoice->$grnr_detail_remarks = $detail_remarks;

        if (!$grnr_invoice->save()) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Warehouse Stock Insertion ////////////////////////////////////

        $warehouses = [];
        $warehouse = $this->AssignWarehouseStocksValues($warehouses, $grnr_array, 0);

        if (!DB::table('financials_warehouse_stock')->insert($warehouse)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Warehouse Stock Summary Insertion ////////////////////////////////////

        $invoice_type_summary='GOODS-RECEIPT-NOTE-RETURN';


        $warehouses_summary = [];
        $warehouse_stock_summary = $this->AssignWarehouseStocksSummaryValues($warehouses_summary, $grnr_array, $invoice_type_summary);

        if (!DB::table('financials_warehouse_stock_summary')->insert($warehouse_stock_summary)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Stock Movement Insertion ////////////////////////////////////

        $stock_movement = $this->stock_movement_module_goods_receipt_note_return ($grnr_array, $voucher_code . $grnr_id, 'GOODS-RECEIPT-NOTE-RETURN', 'GOODS-RECEIPT-NOTE-RETURN');

        if (!$stock_movement) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Stock Movement Child Insertion ////////////////////////////////////
        $stock_movement_child = $this->stock_movement_child($grnr_array,$grnr_id, $account_code, $account_name,'GOODS-RECEIPT-NOTE-RETURN');

        if (!$stock_movement_child) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }
        foreach ($grnr_array as $val) {

            $product_code = $val['product_code'];
            $warehouse = $val['warehouse'];
            $qty = $val['product_qty'];
            $goods_receipt_note = GoodsReceiptNoteItemsModel::where('grni_product_code', $product_code)->where('grni_warehouse_id', $warehouse)->where('grni_invoice_id', '=', $val['grn_id'])
                ->first();

                if ($goods_receipt_note->grni_status != null || $goods_receipt_note->grni_status != 0) {
                    $id = $goods_receipt_note->grni_status;
                    $goods_receipt_note->grni_status = $id . ',' . 'GRNI-'.$grnr_id;
                } else {
                    $goods_receipt_note->grni_status = 'GRNR-'.$grnr_id;
                }

            $goods_receipt_note->grni_due_qty = $goods_receipt_note->grni_due_qty - $qty;
            $goods_receipt_note->save();
        }
        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $grnr_id);

            DB::commit();

            return redirect()->back()->with(['grnr_id' => $grnr_id]);
        }
    }

    public function goods_receipt_note_return_validation($request)
    {
        return $this->validate($request, [
            'account_name' => ['required', 'numeric'],
            "remarks" => ['nullable', 'string'],
            "customer_name" => ['nullable', 'string'],
            "invoice_type" => ['required', 'numeric'],
            "total_items" => ['required', 'numeric', 'min:1'],


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

    public function AssignGoodsReceiptNoteReturnValues($request, $grnr_invoice, $day_end, $user, $prfx, $invoice_no = 0)
    {
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $party_code = $prfx . '_party_code';
        $party_name = $prfx . '_party_name';
        $posting_reference = $prfx . '_pr_id';
        $customer_name = $prfx . '_customer_name';
        $remarks = $prfx . '_remarks';
        $total_items = $prfx . '_total_items';
        $grn_id = $prfx . '_grn_id';
        $datetime = $prfx . '_datetime';
        $day_end_id = $prfx . '_day_end_id';
        $day_end_date = $prfx . '_day_end_date';
        $createdby = $prfx . '_createdby';
        $detail_remarks = $prfx . '_detail_remarks';
        $ip_adrs = $prfx . '_ip_adrs';
        $brwsr_info = $prfx . '_brwsr_info';
        $update_datetime = $prfx . '_update_datetime';



        $grnr_invoice->$party_code = $request->account_name;
        $grnr_invoice->$party_name = $this->get_account_name($request->account_name);
        $grnr_invoice->$posting_reference = $request->posting_reference;
        $grnr_invoice->$customer_name = ucwords($request->customer_name);
        $grnr_invoice->$remarks = ucfirst($request->remarks);
        $grnr_invoice->$total_items = $request->total_items;
        $grnr_invoice->$grn_id = implode(',', $request->grn_id);
        $grnr_invoice->$datetime = Carbon::now()->toDateTimeString();
        $grnr_invoice->$day_end_id = $day_end->de_id;
        $grnr_invoice->$day_end_date = $day_end->de_datetime;
        $grnr_invoice->$createdby = $user->user_id;


        $grnr_invoice->$brwsr_info = $brwsr_rslt;
        $grnr_invoice->$ip_adrs = $ip_rslt;
        $grnr_invoice->$update_datetime = Carbon::now()->toDateTimeString();

        return $grnr_invoice;
    }

    public function AssignGoodsReceiptNoteReturnItemsValues($data, $grnr_id, $array, $prfx)
    {
        foreach ($array as $value) {

            $grnr_invoice = $prfx . '_invoice_id';
            $product_code = $prfx . '_product_code';
            $product_name = $prfx . '_product_name';
            $remarks = $prfx . '_remarks';
            $qty = $prfx . '_qty';
            $uom = $prfx . '_uom';
            $scale_size = $prfx . '_scale_size';
            $rate = $prfx . '_rate';
            $bonus_qty = $prfx . '_bonus_qty';
            $amount = $prfx . '_amount';
            $warehouse_id = $prfx . '_warehouse_id';

            $data[] = [
                $grnr_invoice => $grnr_id,
                $product_code => $value['product_code'],
                $product_name => $value['product_name'],
                $warehouse_id => $value['warehouse'],
                $qty => $value['product_qty'],
                $uom => $value['product_unit_measurement'],
                $scale_size => $value['product_unit_measurement_scale_size'],
                $bonus_qty => $value['product_bonus_qty'],
                $rate => $value['product_rate'],
                $amount => $value['product_amount'],
                $remarks => $value['product_remarks'],
            ];
        }

        return $data;
    }

    public
    function AssignGoodsReceiptNoteValuesLog($invoice_id, $delivery_order_id, $invoice_type, $array, $prfx, $status)
    {//status 1 for products and 2 for services

        $data = [];

        foreach ($array as $value) {

            $qty = GoodsReceiptNoteLogModel::where('grnl_product_code', $value['product_code'])->where('grnl_warehouse_id', $value['warehouse'])->orderBy('grnl_id', 'DESC')->first();

            $dc_invoice = $prfx . '_grn_id';
            $grnr_invoice = $prfx . '_purchase_id';
            $purchase_tax_invoice = $prfx . '_purchase_tax_id';
            $product_code = $prfx . '_product_code';
            $warehouse = $prfx . '_warehouse_id';
            $purchase_qty = $prfx . '_purchase_qty';
            $balance_qty = $prfx . '_balance_qty';
            $invoice_no='';
            $invoice_purchase_sale_tax_no='';
            if ($invoice_type == 1) {
                $invoice_no=$invoice_id;
            }else{
                $invoice_purchase_sale_tax_no=$invoice_id;
            }
            $data[] = [
                $dc_invoice => $value['grn_id'],

                $grnr_invoice => $invoice_no,
                $purchase_tax_invoice => $invoice_purchase_sale_tax_no,

                $product_code => $value['product_code'],
                $warehouse => $value['warehouse'],
                $purchase_qty => $value['product_qty'],
                $balance_qty => $qty->grnl_balance_qty - $value['product_qty'],

            ];
        }

        return $data;
    }

    // update code by mustafa start
    public function trade_goods_receipt_note_return_list(Request $request, $array = null, $str = null)
    {
        $heads = config('global_variables.payable_receivable_cash');
        $heads = explode(',', $heads);

        $accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)->orderBy('account_name', 'ASC')->get();
        $products = ProductModel::orderBy('pro_title', 'ASC')->get();

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_account = (!isset($request->account) && empty($request->account)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->account;
        $search_product = (!isset($request->product) && empty($request->product)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->product;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->from;
        $check_desktop = $request->check_desktop;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.goods_receipt_note_return.goods_receipt_note_return_list';
        $pge_title = 'Trade Goods Receipt Note Return List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_account, $search_product, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $query = DB::table('financials_goods_receipt_note_return')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_goods_receipt_note_return.grnr_createdby')
            ->leftJoin('financials_purchase_order', 'financials_purchase_order.po_id', 'financials_goods_receipt_note_return.grnr_po_id');


        if (!empty($search)) {

            $query->where(function ($query) use ($search) {
                $query->where('grnr_party_code', 'like', '%' . $search . '%')
                    ->orWhere('grnr_party_name', 'like', '%' . $search . '%')
                    ->orWhere('grnr_remarks', 'like', '%' . $search . '%')
                    ->orWhere('grnr_id', 'like', '%' . $search . '%')
                    ->orWhere('user_designation', 'like', '%' . $search . '%')
                    ->orWhere('user_name', 'like', '%' . $search . '%')
                    ->orWhere('user_username', 'like', '%' . $search . '%');
            });

        }

        if (!empty($search_account)) {
            $query->where('grnr_party_code', $search_account);
        }

        if (!empty($search_product)) {
            $get_p_id = GoodsReceiptNoteReturnItemsModal::where('grni_product_code', $search_product)->pluck('grni_invoice_id')->all();
            $query->whereIn('grnr_id', $get_p_id);
        }

        if (!empty($search_by_user)) {
            $query->where('grnr_createdby', $search_by_user);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('grnr_day_end_date', [$start, $end]);
            $query->whereDate('grnr_day_end_date', '>=', $start)
                ->whereDate('grnr_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('grnr_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('grnr_day_end_date', $end);
        }

        $datas = $query->orderBy('grnr_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

        $party = AccountRegisterationModel::whereIn('account_parent_code', $heads)->orderBy('account_name', 'ASC')->pluck('account_name')->all();


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
                'margin-top' => 24,
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
            return view('Trade_Invoices/trade_goods_receipt_note_return_list', compact('datas', 'search', 'party', 'accounts', 'search_account', 'search_product', 'products', 'search_to', 'search_from', 'check_desktop', 'search_by_user'));

        }
    }
    // update code by mustafa end

    public
    function trade_goods_receipt_note_return_items_view_details(Request $request)
    {
        $items = GoodsReceiptNoteReturnItemsModal::where('grnri_invoice_id', $request->id)->orderby('grnri_product_name', 'ASC')->get();

        return response()->json($items);
    }

    public
    function trade_goods_receipt_note_return_items_view_details_SH(Request $request, $id)
    {
        $urdu_eng = ReportConfigModel::where('rc_id', '=', 1)->select('rc_invoice','rc_invoice_party')->first();
        if ($urdu_eng->rc_invoice_party == 0){
            $sim = GoodsReceiptNoteReturnModal::where('grnr_id', $id)->first();
        }else{
            $sim = DB::table('financials_goods_receipt_note_return')
                ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_goods_receipt_note_return.grnr_party_code')
                ->where('grnr_id', $id)
                ->select('financials_accounts.account_urdu_name as grnr_party_name','grnr_id','grnr_party_code','grnr_customer_name','grnr_remarks','grnr_total_items', 'grnr_day_end_id','grnr_day_end_date','grnr_createdby')->first();
        }

        $accnts = AccountRegisterationModel::where('account_uid', $sim->grnr_party_code)->first();
        if ($urdu_eng->rc_invoice == 0) {
            $siims = DB::table('financials_goods_receipt_note_return_items')
                ->where('grnri_invoice_id', $id)
                ->orderby('grnri_product_name', 'ASC')
                ->select('grnri_product_name as name', 'grnri_remarks as remarks', 'grnri_qty as qty', 'grnri_scale_size as scale_size', 'grnri_bonus_qty as bonus', 'grnri_status as status')
                ->get();
        } else {

            $siims = DB::table('financials_goods_receipt_note_return_items')
                ->join('financials_products', 'financials_products.pro_p_code', '=', 'financials_goods_receipt_note_return_items.grnri_product_code')
                ->where('grnri_invoice_id', $id)
                ->select('financials_products.pro_urdu_title as name', 'grnri_remarks as remarks', 'grnri_qty as qty', 'grnri_scale_size as scale_size', 'grnri_bonus_qty as bonus', 'grnri_status as status')
                ->orderby('grnri_product_name', 'ASC')
                ->get();

        }

        $invoice_nbr = $sim->grnr_id;
        $invoice_date = $sim->grnr_day_end_date;
        $type = 'grid';
        $pge_title = 'Trade Goods Receipt Note Return';

        return view('trade_invoice_view.trade_goods_receipt_note_return.trade_goods_receipt_note_return_list_modal', compact('siims', 'sim', 'accnts', 'invoice_nbr', 'invoice_date', 'type', 'pge_title'));
    }

    public
    function trade_goods_receipt_note_items_view_details_pdf_SH(Request $request, $id)
    {
        $urdu_eng = ReportConfigModel::where('rc_id', '=', 1)->select('rc_invoice','rc_invoice_party')->first();
        if ($urdu_eng->rc_invoice_party == 0){
            $sim = GoodsReceiptNoteReturnModal::where('grnr_id', $id)->first();
        }else{
            $sim = DB::table('financials_goods_receipt_note_return')
                ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_goods_receipt_note_return.grnr_party_code')
                ->where('grnr_id', $id)
                ->select('financials_accounts.account_urdu_name as grnr_party_name','grnr_id','grnr_party_code','grnr_customer_name','grnr_remarks','grnr_total_items', 'grnr_day_end_id','grnr_day_end_date','grnr_createdby')->first();
        }

        $accnts = AccountRegisterationModel::where('account_uid', $sim->grnr_party_code)->first();

        if ($urdu_eng->rc_invoice == 0) {
            $siims = DB::table('financials_goods_receipt_note_return_items')
                ->where('grnri_invoice_id', $id)
                ->orderby('grnri_product_name', 'ASC')
                ->select('grnri_product_name as name', 'grnri_remarks as remarks', 'grnri_qty as qty', 'grnri_scale_size as scale_size', 'grnri_bonus_qty as bonus', 'grnri_status as status')
                ->get();
        } else {

            $siims = DB::table('financials_goods_receipt_note_return_items')
                ->join('financials_products', 'financials_products.pro_p_code', '=', 'financials_goods_receipt_note_return_items.grnri_product_code')
                ->where('grnri_invoice_id', $id)
                ->select('financials_products.pro_urdu_title as name', 'grnri_remarks as remarks', 'grnri_qty as qty', 'grnri_scale_size as scale_size', 'grnri_bonus_qty as bonus', 'grnri_status as status')
                ->orderby('grnri_product_name', 'ASC')
                ->get();

        }


        //$nbrOfWrds = $this->myCnvrtNbr($sim->si_grand_total);
        $invoice_nbr = $sim->grnr_id;
        $invoice_date = $sim->grnr_day_end_date;
        $type = 'pdf';
        $pge_title = 'Trade Goods Receipt Note Return';


        $footer = view('invoice_view._partials.pdf_footer')->render();
        $header = view('invoice_view._partials.pdf_header', compact('invoice_nbr', 'invoice_date', 'pge_title', 'type'))->render();
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
        $pdf->loadView('trade_invoice_view.trade_goods_receipt_note_return.trade_goods_receipt_note_return_list_modal', compact('siims', 'sim', 'accnts', 'type', 'pge_title','invoice_nbr','invoice_date'));
        // $pdf->setOptions($options);

        return $pdf->stream('Trade-Goods-Receipt-Note-Return.pdf');
    }
}
