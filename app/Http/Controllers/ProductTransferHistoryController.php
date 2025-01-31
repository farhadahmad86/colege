<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\InventoryModel;
use App\Models\ProductLossRecoverItemsModel;
use App\Models\ProductLossRecoverModel;
use App\Models\ProductModel;
use App\Models\ProductTransferHistoryModel;
use App\Models\WarehouseModel;
use App\Models\WarehouseStockModel;
use App\Models\WarehouseStockSummaryModel;
use Auth;
use PDF;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductTransferHistoryController extends Controller
{
    public function add_transfer_product_stock()
    {
        $warehouses = WarehouseModel::where('wh_delete_status', '!=', 1)->where('wh_disabled', '!=', 1)->orderBy('wh_title', 'ASC')->get();
        $products = ProductModel::where('pro_delete_status', '!=', 1)->where('pro_disabled', '!=', 1)//->whereIn('pro_product_type_id',[1,2,3,4])
            ->orderBy('pro_title', 'ASC')->get();

        return view('add_transfer_product_stock', compact('warehouses', 'products'));
    }


    public function submit_transfer_product_stock(Request $request)
    {

        $this->transfer_product_stock_validation($request);

        $product_parent_code = $this->get_product_parent_code($request->product);

        DB::beginTransaction();

        $product_transfer = new ProductTransferHistoryModel();

        $product_transfer = $this->AssignTransferProductStockValues($request, $product_transfer, $product_parent_code);

        if ($product_transfer->save()) {



            $warehouse_to = new WarehouseStockModel();
            $warehouse_to = $this->AssignWarehouseStockValues($product_parent_code, $request->quantity, $request->warehouse_to, 'add');

            if ($warehouse_to) {

                $warehouse_from = new WarehouseStockModel();

                //////////////////////////// Warehouse Stock Summary for In Insertion Start ////////////////////////////////////
                $warehouses_summary = [];
                $warehouse_stock_summary = $this->AssignWarehouseStocksSummarysValues($warehouses_summary, $product_parent_code, $request->quantity, $request->warehouse_to, 'PRODUCT TRANSFER IN');

                if (!DB::table('financials_warehouse_stock_summary')->insert($warehouse_stock_summary)) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }
//                $warehouse_stock_summary = new WarehouseStockSummaryModel();
//                $warehouse_stock_summary = $this->AssignWarehouseStocksSummarysValues($warehouse_stock_summary, $product_parent_code, $request->quantity, $request->warehouse_to, 'PRODUCT TRANSFER IN');
//
//                if (!$warehouse_stock_summary->save()) {
//                    $rollBack = true;
//                    DB::rollBack();
//                    return redirect()->back()->with('fail', 'Failed Try Again');
//                }

                //////////////////////////// Warehouse Stock Summary for In Insertion End ////////////////////////////////////

                $warehouse_from = $this->AssignWarehouseStockValues($product_parent_code, $request->quantity, $request->warehouse_from, 'minus');

                if (!$warehouse_from) {
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again!');
                }

                //////////////////////////// Warehouse Stock Summary for Out Insertion Start ////////////////////////////////////
                $warehouses_summary = [];
                $warehouse_stock_summary = $this->AssignWarehouseStocksSummarysValues($warehouses_summary, $product_parent_code, $request->quantity, $request->warehouse_from, 'PRODUCT TRANSFER OUT');

                if (!DB::table('financials_warehouse_stock_summary')->insert($warehouse_stock_summary)) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }

//                $warehouse_stock_summary = new WarehouseStockSummaryModel();
//                $warehouse_stock_summary = $this->AssignWarehouseStocksSummarysValues($warehouse_stock_summary, $product_parent_code, $request->quantity, $request->warehouse_from, 'PRODUCT TRANSFER OUT');
//                if (!$warehouse_stock_summary->save()) {
//                    $rollBack = true;
//                    DB::rollBack();
//                    return redirect()->back()->with('fail', 'Failed Try Again');
//                }
//                if (!DB::table('financials_warehouse_stock_summary')->insert($warehouse_stock_summary)) {
//                    $rollBack = true;
//                    DB::rollBack();
//                    return redirect()->back()->with('fail', 'Failed Try Again');
//                }

                //////////////////////////// Warehouse Stock Summary for Out Insertion End ////////////////////////////////////

                $user = Auth::User();

                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Transfer Stock Id: ' . $product_transfer->pth_id);

                DB::commit();
                return redirect()->back()->with('success', 'Successfully Saved');
            } else {
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again!');
            }
        } else {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }

    }

    public function transfer_product_stock_validation($request)
    {
        return $this->validate($request, [
            'product' => ['required', 'numeric'],
            'warehouse_to' => ['required', 'numeric'],
            'warehouse_from' => ['required', 'numeric'],
            'stock_qty' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric', 'min:0', 'max:' . $request->stock_qty],
            'remarks' => ['nullable', 'string'],
        ]);
    }

    protected function AssignTransferProductStockValues($request, $product, $product_parent_code)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $product->pth_product_code = $product_parent_code;
        $product->pth_stock = $request->quantity;
        $product->pth_warehouse_to = $request->warehouse_to;
        $product->pth_scale_size = $request->scale_size;
        $product->pth_warehouse_from = $request->warehouse_from;
        $product->pth_remarks = ucfirst($request->remarks);
        $product->pth_datetime = $request->purchase_price;
        $product->pth_user_id = $user->user_id;
        $product->pth_day_end_id = $day_end->de_id;
        $product->pth_day_end_date = $day_end->de_datetime;

        // coding from shahzaib start
        $tbl_var_name = 'product';
        $prfx = 'pth';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        return $product;
    }


    public function AssignWarehouseStockValues($product_code, $qty, $warehouse, $sign)
    {
        $stocks = WarehouseStockModel::where('whs_product_code', $product_code)->where('whs_warehouse_id', $warehouse)->orderBy('whs_id', 'DESC')->pluck('whs_stock')->first();

        if ($sign == 'add') {
            $stock = $stocks + $qty;
        } else {
            $stock = $stocks - $qty;
        }

        if ($stocks !== null) {
            $warehouse_value = WarehouseStockModel::where('whs_product_code', $product_code)->where('whs_warehouse_id', $warehouse)->first();

            $warehouse_value->whs_stock = $stock;

        } else {

            $warehouse_value = new WarehouseStockModel();

            $warehouse_value->whs_product_code = $product_code;
            $warehouse_value->whs_stock = $stock;
            $warehouse_value->whs_warehouse_id = $warehouse;
            $warehouse_value->whs_datetime = Carbon::now()->toDateTimeString();
        }

        // coding from shahzaib start
        $tbl_var_name = 'warehouse_value';
        $prfx = 'whs';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end

        if ($warehouse_value->save()) {
            return true;
        } else {
            return false;
        }
    }

    public function AssignWarehouseStocksSummarysValues($data, $product,$quntity, $warehouse ,$type)
    {//sign 1 for add and sign 2 for subtract

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

//        foreach ($array as $key) {
            $product_name=ProductModel::where('pro_p_code','=',$product)->pluck('pro_title')->first();
            $previous_stock = WarehouseStockSummaryModel::where('whss_product_code', $product)->where('whss_warehouse_id', $warehouse)->orderBy('whss_update_datetime',
                'DESC')->first();


            if ($previous_stock !== null) {
                if ($type == 'PRODUCT TRANSFER IN') {
                    $current_stock_for_in = $quntity;
                    $current_stock_for_out = 0;
                    $current_stock_for_hold = $previous_stock->whss_total_hold;
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    $current_stock_for_claim = $previous_stock->whss_total_claim;
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale + $quntity;
                }
                elseif ($type == 'PRODUCT TRANSFER OUT') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $quntity;
                    $current_stock_for_hold = $previous_stock->whss_total_hold;
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    $current_stock_for_claim = $previous_stock->whss_total_claim;
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale - $quntity;
                }


            }
            $previous_stock_type = WarehouseStockSummaryModel::where('whss_product_code', $product)->where('whss_type', $type)->where('whss_warehouse_id', $warehouse)->orderBy('whss_id',
                'DESC')->first();



            if ($previous_stock_type !== null) {

                $inventory = WarehouseStockSummaryModel::where('whss_product_code', $product)->where('whss_type', $type)->where('whss_warehouse_id', $warehouse)->first();

//dd($inventory);
                $inventory->whss_qty_in = $current_stock_for_in;
                $inventory->whss_qty_out = $current_stock_for_out;
                $inventory->whss_total_hold = $current_stock_for_hold;
                $inventory->whss_total_bonus = $current_stock_for_bonus;
                $inventory->whss_total_claim = $current_stock_for_claim;
                $inventory->whss_total_for_sale = $current_stock_for_sale;
                $inventory->whss_brwsr_info = $brwsr_rslt;
                $inventory->whss_ip_adrs = $ip_rslt;
                $inventory->whss_update_datetime = Carbon::now()->toDateTimeString();
                // coding from shahzaib end

                $inventory->save();
            } else {

                if ($type == 'PRODUCT TRANSFER IN') {
                    $current_stock_for_in = $quntity;
                    $current_stock_for_out = 0;
                    $current_stock_for_hold = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_hold = $previous_stock->whss_total_hold;
                    }
                    $current_stock_for_bonus = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    }
                    $current_stock_for_claim = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_claim = $previous_stock->whss_total_claim;
                    }
                    $current_stock_for_sale = $quntity;
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale + $quntity;
                    }
                }
                elseif ($type == 'PRODUCT TRANSFER OUT') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $quntity;
                    $current_stock_for_hold = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_hold = $previous_stock->whss_total_hold;
                    }
                    $current_stock_for_bonus = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    }
                    $current_stock_for_claim = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_claim = $previous_stock->whss_total_claim;
                    }
                    $current_stock_for_sale = -$quntity;
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale - $quntity;
                    }
                }

                $data[] = [
                    'whss_type' => $type,
                    'whss_product_code' => $product,
                    'whss_product_name' => $product_name,
                    'whss_qty_in' => $current_stock_for_in,
                    'whss_qty_out' => $current_stock_for_out,
                    'whss_total_hold' => $current_stock_for_hold,
                    'whss_total_bonus' => $current_stock_for_bonus,
                    'whss_total_claim' => $current_stock_for_claim,
                    'whss_total_for_sale' => $current_stock_for_sale,

                    'whss_warehouse_id' => $warehouse,
                    'whss_datetime' => Carbon::now()->toDateTimeString(),
                    'whss_brwsr_info' => $brwsr_rslt,
                    'whss_ip_adrs' => $ip_rslt,
                    'whss_update_datetime' => Carbon::now()->toDateTimeString()
                ];

            }
//        }
        return $data;
    }

    public function transfer_product_stock_list(Request $request, $array = null, $str = null)
    {

        $products = ProductModel::orderBy('pro_title', 'ASC')->get();
        $warehouses = WarehouseModel::where('wh_delete_status', '!=', 1)->where('wh_disabled', '!=', 1)->orderBy('wh_title', 'ASC')->get();

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_product = (!isset($request->product) && empty($request->product)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->product;
        $search_warehouse = (!isset($request->warehouse) && empty($request->warehouse)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->warehouse;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';

        $prnt_page_dir = 'print.transfer_product_stock_list.transfer_product_stock_list';
        $pge_title = 'Transfer Product Stock List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_product, $search_warehouse);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $query = DB::table('financials_product_transfer_history')
            ->join('financials_products', 'financials_products.pro_p_code', '=', 'financials_product_transfer_history.pth_product_code')
            ->join('financials_warehouse AS wh', 'financials_product_transfer_history.pth_warehouse_to', '=', 'wh.wh_id')
            ->join('financials_warehouse AS wh1', 'financials_product_transfer_history.pth_warehouse_from', '=', 'wh1.wh_id')
            ->select('wh.wh_title AS to', 'wh1.wh_title AS from', 'financials_products.pro_title', 'financials_products.pro_p_code', 'financials_product_transfer_history.pth_stock', 'financials_product_transfer_history.pth_remarks', 'financials_product_transfer_history.pth_datetime');

        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('pro_p_code', 'like', '%' . $search . '%')
                    ->orWhere('pro_title', 'like', '%' . $search . '%')
                    ->orWhere('pth_remarks', 'like', '%' . $search . '%')
                    ->orWhere('wh1.wh_title', 'like', '%' . $search . '%')
                    ->orWhere('wh.wh_title', 'like', '%' . $search . '%');
            });
        }

        if (!empty($search_product)) {
            $pagination_number = 1000000;
            $query->where('pth_product_code', '=', $search_product);
        }
        if (!empty($search_warehouse)) {
            $pagination_number = 1000000;
            $query->where('pth_warehouse_to', '=', $search_warehouse)
                ->orWhere('pth_warehouse_from', '=', $search_warehouse);
        }

        if (!empty($search_by_user)) {
            $query->where('pth_user_id', $search_by_user);
        }

        $datas = $query
            ->orderBy('pth_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

        $product_title = ProductModel::orderBy('pro_title', 'ASC')->pluck('pro_title')->all();


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
            $pdf->loadView($prnt_page_dir, compact('srch_fltr','datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('transfer_product_stock_list', compact('datas', 'search', 'warehouses', 'product_title', 'products', 'search_product', 'search_by_user','search_warehouse'));
        }

    }


    public function get_product_stock_warehouse_wise(Request $request)
    {
        $data = [];
        $warehouse_id = $request->warehouse_id;

        $products = DB::table('financials_products')
            ->join('financials_warehouse_stock', 'financials_warehouse_stock.whs_product_code', '=', 'financials_products.pro_p_code')
            ->join('financials_units', 'financials_units.unit_id', '=', 'financials_products.pro_unit_id')
            ->where('whs_warehouse_id', $warehouse_id)
            ->where('pro_status', config('global_variables.product_active_status'))
            ->orderBy('pro_title', 'ASC')//->whereIn('pro_product_type_id',[1,2,3,4])
            ->get();

        $get_products = "<option value=''>Select Product</option>";
        $get_products_name = "<option value=''>Select Product</option>";

        foreach ($products as $product) {
            $get_products .= "<option value='$product->pro_p_code' data-stock='$product->whs_stock' data-scale_size='$product->unit_scale_size' data-unit_title='$product->unit_title'>$product->pro_p_code</option>";
            $get_products_name .= "<option value='$product->pro_p_code' data-stock='$product->whs_stock' data-scale_size='$product->unit_scale_size' data-unit_title='$product->unit_title'>$product->pro_title</option>";
        }

        $data[] = $get_products;
        $data[] = $get_products_name;

        return response()->json($data);
    }
}
