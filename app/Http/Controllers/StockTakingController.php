<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\CategoryInfoModel;
use App\Models\GroupInfoModel;
use App\Models\MainUnitModel;
use App\Models\ProductGroupModel;
use App\Models\ProductModel;
use App\Models\StockMovementModels;
use App\Models\StockTakingModel;
use App\Models\UnitInfoModel;
use App\Models\WarehouseModel;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel;

class StockTakingController extends Controller
{
    // update code by shahzaib start
    public function stock_taking_industrial(Request $request, $type = 1, $array = null, $str = null)
    {
        $warehouses = WarehouseModel::where('wh_delete_status', '!=', 1)->where('wh_disabled', '!=', 1)->orderby('wh_title', 'ASC')->get();
        $main_units = MainUnitModel::where('mu_delete_status', '!=', 1)->where('mu_disabled', '!=', 1)->orderby('mu_title', 'ASC')->get();
        $units = UnitInfoModel::where('unit_delete_status', '!=', 1)->where('unit_disabled', '!=', 1)->orderBy('unit_title', 'ASC')->get();
        $groups = GroupInfoModel::where('grp_delete_status', '!=', 1)->where('grp_disabled', '!=', 1)->orderBy('grp_title', 'ASC')->get();
        $categories = CategoryInfoModel::where('cat_delete_status', '!=', 1)->where('cat_disabled', '!=', 1)->orderBy('cat_title', 'ASC')->get();
        $product_groups = ProductGroupModel::where('pg_delete_status', '!=', 1)->where('pg_disabled', '!=', 1)->orderBy('pg_title', 'ASC')->get();
//        $route = "";
//
//        if ($type == config('global_variables.parent_product_type')) {
//            $route = 'product_list';
//        } else if ($type == config('global_variables.child_product_type')) {
//            $route = 'product_clubbing_list';
//        }


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_warehouse = (!isset($request->warehouse) && empty($request->warehouse)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->warehouse;
        $search_main_unit = (!isset($request->main_unit) && empty($request->main_unit)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->main_unit;
        $search_unit = (!isset($request->unit) && empty($request->unit)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->unit;
        $search_group = (!isset($request->group) && empty($request->group)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->group;
        $search_category = (!isset($request->category) && empty($request->category)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->category;
        $search_product_group = (!isset($request->product_group) && empty($request->product_group)) ? ((!empty($ar)) ? $ar[7]->{'value'} : '') : $request->product_group;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = '';//print.' . $route . '.' . $route;
        $pge_title = 'Stock Taking'; //ucwords(str_replace('_', ' ', $route));
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_warehouse, $search_main_unit, $search_unit, $search_group, $search_category);

//        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_products')
//            ->leftJoin('financials_inventory', 'financials_products.pro_code', '=', 'financials_inventory.invt_product_id')
            ->join('financials_warehouse_stock', 'financials_warehouse_stock.whs_product_code', '=', 'financials_products.pro_p_code')
            ->leftJoin('financials_groups', 'financials_groups.grp_id', 'financials_products.pro_group_id')
            ->leftJoin('financials_categories', 'financials_categories.cat_id', 'financials_products.pro_category_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_products.pro_createdby')
            ->leftJoin('financials_units', 'financials_units.unit_id', 'financials_products.pro_unit_id');

        if (!empty($search)) {
            $query->where('pro_code', 'like', '%' . $search . '%')
                ->orWhere('pro_title', 'like', '%' . $search . '%')
                ->orWhere('pro_purchase_price', 'like', '%' . $search . '%')
                ->orWhere('pro_sale_price', 'like', '%' . $search . '%')
                ->orWhere('pro_remarks', 'like', '%' . $search . '%')
//                ->orWhere('invt_available_stock', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        $query->where('whs_warehouse_id', $search_warehouse);
        if (!empty($search_main_unit)) {
            $query->where('pro_main_unit_id', $search_main_unit);
        }

        if (!empty($search_unit)) {
            $query->where('pro_unit_id', $search_unit);
        }

        if (!empty($search_group)) {
            $query->where('pro_group_id', $search_group);
        }

        if (!empty($search_category)) {
            $query->where('pro_category_id', $search_category);
        }

        if (!empty($search_product_group)) {
            $query->where('pro_reporting_group_id', $search_product_group);
        }

        if (!empty($search_by_user)) {
            $query->where('pro_createdby', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1) {
            $query->where('pro_delete_status', '=', 1);
        } else {
            $query->where('pro_delete_status', '!=', 1);
        }

        if ($type == config('global_variables.child_product_type')) {
            $query->where('pro_clubbing_codes', '!=', '');
        }


        $datas = $query->where('pro_type', 1)
//            ->where('pro_delete_status', '!=', 1)
            ->orderBy('pro_id', config('global_variables.query_sorting'))->get();
//            ->paginate($pagination_number);

        $product = ProductModel::
        where('pro_delete_status', '!=', 1)->
        orderBy('pro_title', 'ASC')->pluck('pro_title')->all();


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
            return view('stock_taking_industrial', compact('datas', 'search', 'product', 'main_units', 'units', 'groups', 'categories', 'warehouses', 'product_groups', 'search_main_unit',
                'search_warehouse', 'search_unit', 'search_group', 'search_category', 'search_by_user', 'search_product_group', 'restore_list'));
        }


    }

    public function stock_taking(Request $request, $type = 1, $array = null, $str = null)
    {
        //$products = $this->get_all_products();
        $warehouses = WarehouseModel::where('wh_delete_status', '!=', 1)->where('wh_disabled', '!=', 1)->orderby('wh_title', 'ASC')->get();
        return view('stock_taking', compact('warehouses'));

    }

    // update code by shahzaib end}

    public function submit_stock_taking(Request $request)
    {
        DB::beginTransaction();
        $rollBack = false;
        $stock_array = json_decode($request->stock_array, true);


        $stock_taking_prefix = 'st';

        $item_table = 'financials_stock_taking';
        $warehouse_id = $request->warehouse;


        $item = $this->AssignStockTakingValues($stock_array, $stock_taking_prefix,$warehouse_id);


        if (!DB::table($item_table)->insert($item)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }
        return back()->with('success', 'Saved Successfully');
    }

    public function submit_stock_taking_industrial(Request $request)
    {

        $stock_array = [];
        foreach ($request->physical as $index => $physical) {
            if ($request->physical[$index] != null) {
                $product_code = $request->product_code[$index];
                $product_name = $request->product_name[$index];
                $physical_qty = $request->physical[$index];
                $bonus_qty = $request->bonus[$index];

                $stock_array[] = [
                    '0' => $product_code,
                    '1' => $product_name,
                    '2' => $physical_qty,
                    '3' => $bonus_qty,
                ];
            }
        }
        DB::beginTransaction();
        $rollBack = false;


        $stock_taking_prefix = 'st';

        $item_table = 'financials_stock_taking';
        $warehouse_id = $request->warehouse;
        $user = Auth::User();

        $item = $this->AssignStockTakingValues($stock_array, $stock_taking_prefix,$warehouse_id);


        if (!DB::table($item_table)->insert($item)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }
        return back()->with('success', 'Saved Successfully');

    }


    function AssignStockTakingValues($array, $prfx,$warehouse)
    {
        $user = Auth::User();
        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $data = [];

        foreach ($array as $value) {

            $warehouse_stock = DB::table('financials_warehouse_stock')
                ->where('whs_warehouse_id', $warehouse)
                ->where('whs_product_code', $value[0])
                ->orderBy('whs_product_code', 'DESC')
                ->first();

            $delivery_hold_qty = 0;
            $delivery_stock = StockMovementModels::where('sm_product_code', $value[0])->whereIn('sm_type', ['DELIVERY-ORDER', 'DELIVERY-ORDER-SALE'])->select('sm_bal_hold')->get();

            foreach ($delivery_stock as $hold) {
                $delivery_hold_qty += $hold->sm_bal_hold;
            }

            $product_code = $value[0];
            $product_name = $value[1];
            $previous_stock = $this->product_stock_movement_last_row($product_code);

            $current_stock = $previous_stock->sm_bal_qty_for_sale + $delivery_hold_qty + $previous_stock->sm_bal_claims;

            $warehouse_id = $prfx . '_warehouse_id';
            $product_code = $prfx . '_product_code';
            $product_name = $prfx . '_product_name';
            $physical_qty = $prfx . '_physical_qty';
            $bonus_qty = $prfx . '_bonus_qty';
            $current_stock_qty = $prfx . '_current_stock';
            $warehouse_stock_qty = $prfx . '_warehouse_stock';

            $date_time = $prfx . '_posting_date_time';
            $created_by = $prfx . '_createdby';

            $day_end_id = $prfx . '_day_end_id';
            $day_end_date = $prfx . '_day_end_date';

            $datetime = $prfx . '_datetime';
            $ip_adrs = $prfx . '_ip_adrs';
            $brwsr_info = $prfx . '_brwsr_info';

            $updt_date_col = $prfx . '_update_datetime';


            $data[] = [
                $warehouse_id => $warehouse,
                $product_code => $value[0],
                $product_name => ucwords($value[1]),

                $physical_qty => $value[2],
                $bonus_qty => $value[3],
                $current_stock_qty => $current_stock,
                $warehouse_stock_qty => $warehouse_stock->whs_stock,

                $date_time => Carbon::now(),
                $created_by => $user->user_id,

                $day_end_id => $day_end->de_id,
                $day_end_date => $day_end->de_datetime,

                $datetime => Carbon::now()->toDateTimeString(),
                $ip_adrs => $ip_rslt,
                $brwsr_info => $brwsr_rslt,
                $updt_date_col => Carbon::now()->toDateTimeString(),

            ];

        }

        return $data;
    }

    public
    function stock_taking_list(Request $request, $array = null, $str = null)
    {

        $products = ProductModel::orderBy('pro_title', 'ASC')->get();

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;

        $search_product = (!isset($request->product) && empty($request->product)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->product;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->to;
        $check_desktop = $request->check_desktop;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.sale_invoice_list.sale_invoice_list';
        $pge_title = 'Sale Invoice List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_product, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $start = date('Y-m-d', strtotime($search_from));
        $end = date('Y-m-d', strtotime($search_to));

        $query = DB::table('financials_stock_taking')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_stock_taking.st_createdby');

        if (!empty($search)) {

            $query->where(function ($query) use ($search) {
                $query->where('st_product_code', 'like', '%' . $search . '%')
                    ->orWhere('st_product_name', 'like', '%' . $search . '%')
                    ->orWhere('st_id', 'like', '%' . $search . '%')
                    ->orWhere('user_designation', 'like', '%' . $search . '%')
                    ->orWhere('user_name', 'like', '%' . $search . '%')
                    ->orWhere('user_username', 'like', '%' . $search . '%');
            });

        }

        if (!empty($search_product)) {
            $query->where('st_product_code', $search_product);
        }

        if (!empty($search_by_user)) {
            $query->where('st_createdby', $search_by_user);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('si_day_end_date', [$start, $end]);
            $query->whereDate('st_posting_date_time', '>=', $start)
                ->whereDate('st_posting_date_time', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('st_posting_date_time', $start);
        } elseif (!empty($search_from)) {
            $query->where('st_posting_date_time', $end);
        }

        $datas = $query->orderBy('st_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);
        $stock_taking = StockTakingModel::orderBy('st_id', config('global_variables.query_sorting'))->pluck('st_product_name')->all();//where('reg_delete_status', '!=', 1)->

        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];

            $pdf = SnappyPdf::loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('stock_taking_list', compact('datas', 'stock_taking', 'search', 'search_product', 'products', 'search_to', 'search_from', 'check_desktop', 'search_by_user'));
        }
    }
}
