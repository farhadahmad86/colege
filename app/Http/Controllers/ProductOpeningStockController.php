<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Exports\OpeningExcelExport;
use App\Http\Controllers\Wizard\WizardController;
use App\Imports\ExcelDataImport;
use App\Models\CategoryInfoModel;
use App\Models\DayEndModel;
use App\Models\GroupInfoModel;
use App\Models\MainUnitModel;
use App\Models\ProductGroupModel;
use App\Models\ProductModel;
use App\Models\StockMovementModels;
use App\Models\UnitInfoModel;
use App\Models\WarehouseModel;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProductOpeningStockController extends ExcelForm\ProductOpeningStockForm\ProductOpeningStokController
{
    // update code by shahzaib start
//    public function product_opening_stock(Request $request, $array = null, $str = null)
//    {
//        $count = DayEndModel::count();
////        if ($count == 0) {
//            $main_units = MainUnitModel::orderby('mu_title', 'ASC')->get();
//            $units = UnitInfoModel::orderBy('unit_title', 'ASC')->get();
//            $groups = GroupInfoModel::orderBy('grp_title', 'ASC')->get();
//            $categories = CategoryInfoModel::orderBy('cat_title', 'ASC')->get();
//            $product_reporting_groups = ProductGroupModel::orderBy('pg_title', 'ASC')->get();
//
//            $warehouses = WarehouseModel::orderBy('wh_id', 'ASC')->get();
//
//
//            $ar = json_decode($request->array);
//            $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
//            $search_group = (!isset($request->group) && empty($request->group)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->group;
//            $search_category = (!isset($request->category) && empty($request->category)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->category;
//            $search_product_reporting_group = (!isset($request->product_reporting_group) && empty($request->product_reporting_group)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->product_reporting_group;
//            $search_main_unit = (!isset($request->main_unit) && empty($request->main_unit)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->main_unit;
//            $search_unit = (!isset($request->unit) && empty($request->unit)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->unit;
//
//
//            $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
//            $prnt_page_dir = 'print.product_opening_stock.product_opening_stock';
//            $pge_title = 'Product Opening Stock';
//            $srch_fltr = [];
//            array_push($srch_fltr, $search, $search_group, $search_category, $search_product_reporting_group, $search_main_unit, $search_unit);
//
//            $pagination_number = (empty($ar)) ? 100000000 : 100000000;
//
////        DB::enableQueryLog();
//
//            $query = DB::table('financials_products')
//                ->leftJoin('financials_groups', 'financials_groups.grp_id', 'financials_products.pro_group_id')
//                ->leftJoin('financials_units', 'financials_units.unit_id', 'financials_products.pro_unit_id')
//                ->leftJoin('financials_categories', 'financials_categories.cat_id', 'financials_products.pro_category_id')
//                ->leftJoin('financials_users', 'financials_users.user_id', 'financials_products.pro_createdby')
//                ->where('pro_disabled', '!=', 1);
//
//            if (!empty($search)) {
//                $query->where('pro_title', 'like', '%' . $search . '%')
//                    ->orWhere('pro_p_code', 'like', '%' . $search . '%')
//                    ->orWhere('user_designation', 'like', '%' . $search . '%')
//                    ->orWhere('user_name', 'like', '%' . $search . '%')
//                    ->orWhere('user_username', 'like', '%' . $search . '%');
//            }
//
//            if (isset($search_main_unit) && !empty($search_main_unit)) {
//                $query->where('pro_main_unit_id', $search_main_unit);
//            }
//
//            if (isset($search_unit) && !empty($search_unit)) {
//                $query->where('pro_unit_id', $search_unit);
//            }
//
//            if (isset($search_group) && !empty($search_group)) {
//                $query->where('pro_group_id', $search_group);
//            }
//
//            if (isset($search_category) && !empty($search_category)) {
//                $query->where('pro_category_id', $search_category);
//            }
//
//            if (isset($search_product_reporting_group) && !empty($search_product_reporting_group)) {
//                $query->where('pro_reporting_group_id', $search_product_reporting_group);
//            }
//
//
//            $datas = $query->where('pro_type', config('global_variables.parent_product_type'))
//                ->orderBy('pro_title', 'ASC')
//                ->paginate($pagination_number);
//
////        dd(DB::getQueryLog());
//
//            $product_names = ProductModel::where('pro_type', config('global_variables.parent_product_type'))->orderBy('pro_title', 'ASC')->pluck('pro_title')->all();
//
//            if (isset($request->array) && !empty($request->array)) {
//
//                $type = (isset($request->str)) ? $request->str : '';
//
//                $footer = view('print._partials.pdf_footer')->render();
//                $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
//                $options = [
//                    'footer-html' => $footer,
//                    'header-html' => $header,
//                ];
//
//                $pdf = PDF::loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
//                $pdf->setOptions($options);
//
//
//                if ($type === 'pdf') {
//                    return $pdf->stream($pge_title . '_x.pdf');
//                } else if ($type === 'download_pdf') {
//                    return $pdf->download($pge_title . '_x.pdf');
//                } else if ($type === 'download_excel') {
//                    return Excel::download(new OpeningExcelExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
//                }
//
//            } else {
//                WizardController::updateWizardInfo(['opening_stock'], ['opening_party_balance']);
//                return view('product_opening_stock', compact('datas', 'search', 'product_names', 'main_units', 'units', 'groups', 'categories', 'product_reporting_groups', 'search_group', 'search_category', 'search_main_unit', 'search_unit', 'search_product_reporting_group', 'warehouses'));
//            }
////        } else {
////
////            return redirect()->route('home')->with("fail", "Can not proceed again ");
////        }
//
//    }

    public function product_opening_stock(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $count = DayEndModel::where('de_clg_id',$user->user_clg_id)->count();
        if ($count == 0) {
            $main_units = MainUnitModel::where('mu_clg_id',$user->user_clg_id)->orderby('mu_title', 'ASC')->get();
            $units = UnitInfoModel::where('unit_clg_id',$user->user_clg_id)->orderBy('unit_title', 'ASC')->get();
            $groups = GroupInfoModel::where('grp_clg_id',$user->user_clg_id)->orderBy('grp_title', 'ASC')->get();
            $categories = CategoryInfoModel::where('cat_clg_id',$user->user_clg_id)->orderBy('cat_title', 'ASC')->get();
            $product_reporting_groups = ProductGroupModel::where('pg_clg_id',$user->user_clg_id)->orderBy('pg_title', 'ASC')->get();
            $warehouses = WarehouseModel::where('wh_clg_id',$user->user_clg_id)->orderBy('wh_id', 'ASC')->get();

            $ar = json_decode($request->array);
            $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
            $search_group = (!isset($request->group) && empty($request->group)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->group;
            $search_category = (!isset($request->category) && empty($request->category)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->category;
            $search_product_reporting_group = (!isset($request->product_reporting_group) && empty($request->product_reporting_group)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->product_reporting_group;
            $search_main_unit = (!isset($request->main_unit) && empty($request->main_unit)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->main_unit;
            $search_unit = (!isset($request->unit) && empty($request->unit)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->unit;


            $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
            $prnt_page_dir = 'print.product_opening_stock.product_opening_stock';
            $pge_title = 'Product Opening Stock';
            $srch_fltr = [];
            array_push($srch_fltr, $search, $search_group, $search_category, $search_product_reporting_group, $search_main_unit, $search_unit);

            $pagination_number = (empty($ar)) ? 100 : 100000000;

//        DB::enableQueryLog();
            $query = DB::table('financials_products')
                ->leftJoin('financials_groups', 'financials_groups.grp_id', 'financials_products.pro_group_id')
                ->leftJoin('financials_units', 'financials_units.unit_id', 'financials_products.pro_unit_id')
                ->leftJoin('financials_categories', 'financials_categories.cat_id', 'financials_products.pro_category_id')
                ->leftJoin('financials_users', 'financials_users.user_id', 'financials_products.pro_createdby')
                ->where('pro_disabled', '!=', 1)
                ->where('pro_clg_id',$user->user_clg_id);

//        $query = DB::table('financials_products')
//            ->leftJoin('financials_groups', 'financials_groups.grp_id', 'financials_products.pro_group_id')
//            ->leftJoin('financials_categories', 'financials_categories.cat_id', 'financials_products.pro_category_id')
//            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_products.pro_createdby');

            if (!empty($search)) {
                $query->where('pro_title', 'like', '%' . $search . '%')
                    ->orWhere('pro_p_code', 'like', '%' . $search . '%')
                    ->orWhere('user_designation', 'like', '%' . $search . '%')
                    ->orWhere('user_name', 'like', '%' . $search . '%')
                    ->orWhere('user_username', 'like', '%' . $search . '%');
            }

            if (isset($search_main_unit) && !empty($search_main_unit)) {
                $query->where('pro_main_unit_id', $search_main_unit);
            }

            if (isset($search_unit) && !empty($search_unit)) {
                $query->where('pro_unit_id', $search_unit);
            }

            if (isset($search_group) && !empty($search_group)) {
                $query->where('pro_group_id', $search_group);
            }

            if (isset($search_category) && !empty($search_category)) {
                $query->where('pro_category_id', $search_category);
            }

            if (isset($search_product_reporting_group) && !empty($search_product_reporting_group)) {
                $query->where('pro_reporting_group_id', $search_product_reporting_group);
            }


            $datas = $query->where('pro_type', config('global_variables.parent_product_type'))
                ->orderBy('pro_id', 'ASC')
                ->paginate($pagination_number);

            if ($request->ajax()) {
                if ($datas != null) {
                    $view = view('infinite_scroll.product_opening_stock_data', compact('datas'))->render();
                    return response()->json(['html' => $view, 'message' => 'Loading More data']);
                }
                return response()->json(['html' => ' ', 'message' => 'No More data']);
            }

//        dd(DB::getQueryLog());

            $product_names = ProductModel::where('pro_clg_id',$user->user_clg_id)->where('pro_type', config('global_variables.parent_product_type'))->orderBy('pro_title', 'ASC')->pluck('pro_title')
                ->all();

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
                WizardController::updateWizardInfo(['opening_stock'], ['opening_party_balance']);
                return view('product_opening_stock', compact('datas', 'search', 'product_names', 'main_units', 'units', 'groups', 'categories', 'product_reporting_groups', 'search_group', 'search_category', 'search_main_unit', 'search_unit', 'search_product_reporting_group', 'warehouses'));
            }

        } else {

            return redirect()->route('home')->with("fail", "Can not proceed again ");
        }
    }

    // update code by shahzaib end

    public function update_product_opening_stock_excel(Request $request)
    {

        $rules = [
            'add_create_product_opening_stock_excel' => 'required|mimes:xlsx,xls,csv|max:5000',
        ];

        $messages = [
            'add_create_product_opening_stock_excel.max' => "Your File size too long.",
            'add_create_product_opening_stock_excel.required' => "Please select your Product Excel Sheet.",
        ];

        $validator = $this->validate($request, $rules, $messages);

        if ($request->hasFile('add_create_product_opening_stock_excel')) {

//            dd($request->add_employee_excel);
//            $dateTime = date('Ymd_His');
//            $file = $request->file('add_employee_excel');
//            $fileName = $dateTime . '-' . $file->getClientOriginalName();
//            $savePath = public_path('/uploads/'.config('global_variables.excel_storage_folder_name'));
//            $file->move($savePath, $fileName);
//            $data = Excel::load($path)->get();


            $path = $request->file('add_create_product_opening_stock_excel');
            $data = Excel::toArray(new ExcelDataImport, $path);

            $excelData = json_decode(json_encode($data), FALSE);

            foreach ($excelData as $rows) {
                foreach ($rows as $row) {
                    $rowData = (array)$row;
                    $request->merge($rowData);
                    $this->excel_product_opening_stock_validation($request);
                    if ($request->qty != null) {
                        $rollBack = self::excel_form_product_opening_stock($row);
                    }
                    if ($rollBack) {
                        DB::rollBack();
//                        return redirect()->back()->with('fail', 'Failed Try Again');
                    } else {
                        DB::commit();
                    }
                }
            }


            return redirect()->back()->with(['success' => 'File Uploaded successfully.']);
        } else {
            return redirect()->back()->with(['errors' => $validator]);
        }

    }

    public function update_product_opening_stock(Request $request)
    {
        return self::simple_form_product_opening_stock($request);

    }

    public function update_product_openings_stock(Request $request)
    {
        $this->product_opening_stock_validation($request);

        $ids = $request->id;
        $p_rate = $request->p_rate;
        $b_rate = $request->b_rate;
        $s_rate = $request->s_rate;
        $quantity = $request->quantity;


        // coding from shahzaib start
        $tbl_var_name = 'product';
        $prfx = 'pro';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        // coding from shahzaib end

        $user = Auth::User();
        foreach ($ids as $index => $id) {

            $product = ProductModel::where('pro_clg_id',$user->user_clg_id)->where('pro_p_code', $ids[$index])->first();
            $product_name = $product->pro_title;
            $product_quantity = $quantity[$index];
            $product_rate = $p_rate[$index];
            ProductModel::where('pro_clg_id',$user->user_clg_id)->where('pro_p_code', $ids[$index])->update(
                [
                    'pro_purchase_price' => $p_rate[$index] == '' ? 0 : $p_rate[$index],
                    'pro_bottom_price' => $b_rate[$index] == '' ? 0 : $b_rate[$index],
                    'pro_sale_price' => $s_rate[$index] == '' ? 0 : $s_rate[$index],
                    'pro_average_rate' => $p_rate[$index] == '' ? 0 : $p_rate[$index],
                    'pro_last_purchase_rate' => $p_rate[$index] == '' ? 0 : $p_rate[$index],
                    'pro_quantity' => $quantity[$index] == '' ? 0 : $quantity[$index],
                    'pro_qty_wo_bonus' => $quantity[$index] == '' ? 0 : $quantity[$index],
                    'pro_qty_for_sale' => $quantity[$index] == '' ? 0 : $quantity[$index],
                    $brwsr_col => $brwsr_rslt,
                    $ip_col => $ip_rslt,
                    $updt_date_col => Carbon::now()->toDateTimeString()
                ]
            );
            $stock = StockMovementModels::where('sm_clg_id',$user->user_clg_id)->where('sm_product_code', $ids[$index])->orderBy('sm_id', 'DESC')->first();
            if ($stock == '') {
                $stock_movement = new StockMovementModels();

                $this->ProductCreationStockMovementValues($ids[$index], $product_name, $product_quantity, $product_rate, $stock_movement);

                if (!$stock_movement->save()) {
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again!');
                }
            } else {
                $total_bal = $product_quantity * $p_rate[$index];
                $stock->sm_bal_rate = $p_rate[$index];
                $stock->sm_bal_total = $total_bal;
                $stock->sm_in_qty = $product_quantity;
                $stock->sm_bal_qty_for_sale = $product_quantity;
                $stock->sm_bal_total_qty_wo_bonus = $product_quantity;
                $stock->sm_bal_total_qty = $product_quantity;
                $stock->save();

//                StockMovementModels::where('sm_product_code', $ids[$index])->orderBy('sm_id', 'DESC')->first()->update(
//                    [
////                        'sm_bal_rate' => $p_rate[$index] == '' ? 0 : $p_rate[$index],
//                        'sm_bal_total' => $total_bal == '' ? 0 : $total_bal,
//                        'sm_bal_qty_for_sale' => $product_quantity == '' ? 0 : $product_quantity,
//                        'sm_bal_total_qty_wo_bonus' => $product_quantity == '' ? 0 : $product_quantity,
//                        'sm_in_qty' => $product_quantity == '' ? 0 : $product_quantity,
//
////                    $brwsr_col => $brwsr_rslt,
////                    $ip_col => $ip_rslt,
////                    $updt_date_col => Carbon::now()->toDateTimeString()
//                    ]
//                );
            }
            ////////////////////////// Warehouse Stock Insertion ////////////////////////////////////
            $warehouses = [];
            $warehouse = $this->AssignWarehouseStocksOpeningValues($warehouses, $ids[$index], $product_quantity, 1);

            if (!DB::table('financials_warehouse_stock')->insert($warehouse)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

//////////////////////////// Warehouse Stock Summary Insertion ////////////////////////////////////

            $invoice_type_summary = 'OPENING STOCK';

            $warehouses_summary = [];
            $warehouse_stock_summary = $this->AssignWarehouseStocksSummaryOpeningValues($warehouses_summary, $ids[$index], $product_name, $product_quantity, $invoice_type_summary);

            if (!DB::table('financials_warehouse_stock_summary')->insert($warehouse_stock_summary)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }


            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Product Rate of Code: ' . $product->pro_p_code . ' And Name: ' . $product->pro_title);
        }

        return redirect()->back()->with('success', 'Successfully Saved');
    }

//    public function ProductCreationStockMovementValues($product_code, $product_name, $qty, $rate, $stock_movement)
//    {
//        $user = Auth::user();
//
//        $get_day_end = new DayEndController();
//        $day_end = $get_day_end->day_end();
//
//        $product_code = $product_code;
//        $product_name = $product_name;
////        $product_remarks = $product->pro_remarks;
//        $product_bal_qty = $qty;
//        $product_bal_rate = $rate;
//        $product_bal_total = $product_bal_qty * $product_bal_rate;
//        $notes = 'OPENING_BALANCE';
//
//
//        $stock_movement->sm_product_code = $product_code;
//        $stock_movement->sm_product_name = $product_name;
////        $stock_movement->sm_pur_qty = 0;
////        $stock_movement->sm_pur_rate = 0;
////        $stock_movement->sm_pur_total = 0;
////        $stock_movement->sm_sale_qty = 0;
////        $stock_movement->sm_sale_rate = 0;
////        $stock_movement->sm_sale_total = 0;
//        $stock_movement->sm_in_qty = $product_bal_qty;
//        $stock_movement->sm_bal_qty_for_sale = $product_bal_qty;
//        $stock_movement->sm_bal_total_qty_wo_bonus = $product_bal_qty;
//        $stock_movement->sm_bal_total_qty = $product_bal_qty;
////        $stock_movement->sm_bal_qty = $product_bal_qty;
//        $stock_movement->sm_bal_rate = $product_bal_rate;
//        $stock_movement->sm_bal_total = $product_bal_total;
//        $stock_movement->sm_warehouse_id = 1;
//        $stock_movement->sm_type = $notes;
//        $stock_movement->sm_day_end_id = 1;
//        $stock_movement->sm_day_end_date = $day_end->de_datetime;
////        $stock_movement->sm_voucher_code = 0;
////        $stock_movement->sm_remarks = $product_remarks;
//        $stock_movement->sm_user_id = $user->user_id;
//        $stock_movement->sm_date_time = Carbon::now()->toDateTimeString();
//
//        return $stock_movement;
//    }
//
//    public function AssignWarehouseStocksOpeningValues($data, $pro_code, $qty, $sign)
//    {//sign 1 for add and sign 2 for subtract
//
//        $brwsr_rslt = $this->getBrwsrInfo();
//        $ip_rslt = $this->getIp();
//
//        if ($pro_code != '') {
//
//            $previous_stock = WarehouseStockModel::where('whs_product_code', $pro_code)->where('whs_warehouse_id', 1)->orderBy('whs_id', 'DESC')->pluck('whs_stock')->first();
//
//            if ($sign == 1) {
//                $current_stock = $qty;
//            } else {
//                $current_stock = $qty;
//            }
//
//            if ($previous_stock !== null) {
//
//                $inventory = WarehouseStockModel::where('whs_product_code', $pro_code)->where('whs_warehouse_id', 1)->first();
//                $inventory->whs_stock = $current_stock;
//                $inventory->whs_brwsr_info = $brwsr_rslt;
//                $inventory->whs_ip_adrs = $ip_rslt;
//                $inventory->whs_update_datetime = Carbon::now()->toDateTimeString();
//                // coding from shahzaib end
//
//                $inventory->save();
//            } else {
//
//                $data[] = [
//                    'whs_product_code' => $pro_code,
//                    'whs_stock' => $current_stock,
//                    'whs_warehouse_id' => 1,
//                    'whs_datetime' => Carbon::now()->toDateTimeString(),
//                    'whs_brwsr_info' => $brwsr_rslt,
//                    'whs_ip_adrs' => $ip_rslt,
//                    'whs_update_datetime' => Carbon::now()->toDateTimeString()
//                ];
//            }
//        }
//        return $data;
//    }
//
//    public function AssignWarehouseStocksSummaryOpeningValues($data, $product_code, $product_name, $qty, $type)
//    {//sign 1 for add and sign 2 for subtract
//
//        $brwsr_rslt = $this->getBrwsrInfo();
//        $ip_rslt = $this->getIp();
//
//        $previous_stock = WarehouseStockSummaryModel::where('whss_product_code', $product_code)->where('whss_warehouse_id', 1)->orderBy('whss_update_datetime',
//            'DESC')->first();
//
//        if ($previous_stock !== null) {
//            if ($type == 'OPENING STOCK') {
//                $current_stock_for_in = $qty;
//                $current_stock_for_out = 0;
//                $current_stock_for_hold = $previous_stock->whss_total_hold;
//                $current_stock_for_bonus = $previous_stock->whss_total_bonus;
//                $current_stock_for_claim = $previous_stock->whss_total_claim;
//                $current_stock_for_sale = $qty;
//            }
//
//        }
//        $previous_stock_type = WarehouseStockSummaryModel::where('whss_product_code', $product_code)->where('whss_type', $type)->where('whss_warehouse_id', 1)->orderBy('whss_id',
//            'DESC')->first();
//        if ($previous_stock_type !== null) {
//
//            $inventory = WarehouseStockSummaryModel::where('whss_product_code', $product_code)->where('whss_type', $type)->where('whss_warehouse_id', 1)->first();
//
//
//            $inventory->whss_qty_in = $current_stock_for_in;
//            $inventory->whss_qty_out = $current_stock_for_out;
//            $inventory->whss_total_hold = $current_stock_for_hold;
//            $inventory->whss_total_bonus = $current_stock_for_bonus;
//            $inventory->whss_total_claim = $current_stock_for_claim;
//            $inventory->whss_total_for_sale = $current_stock_for_sale;
//            $inventory->whss_brwsr_info = $brwsr_rslt;
//            $inventory->whss_ip_adrs = $ip_rslt;
//            $inventory->whss_update_datetime = Carbon::now()->toDateTimeString();
//            // coding from shahzaib end
//
//            $inventory->save();
//        } else {
//
//            if ($type == 'OPENING STOCK') {
//                $current_stock_for_in = $qty;
//                $current_stock_for_out = 0;
//                $current_stock_for_hold = 0;
//                if ($previous_stock !== null) {
//                    $current_stock_for_hold = $previous_stock->whss_total_hold;
//                }
//                $current_stock_for_bonus = 0;
//                if ($previous_stock !== null) {
//                    $current_stock_for_bonus = $previous_stock->whss_total_bonus;
//                }
//                $current_stock_for_claim = 0;
//                if ($previous_stock !== null) {
//                    $current_stock_for_claim = $previous_stock->whss_total_claim;
//                }
//                $current_stock_for_sale = $qty;
//                if ($previous_stock !== null) {
//                    $current_stock_for_sale = $qty;
//                }
//            }
//
//            $data[] = [
//                'whss_type' => $type,
//                'whss_product_code' => $product_code,
//                'whss_product_name' => $product_name,
//                'whss_qty_in' => $current_stock_for_in,
//                'whss_qty_out' => $current_stock_for_out,
//                'whss_total_hold' => $current_stock_for_hold,
//                'whss_total_bonus' => $current_stock_for_bonus,
//                'whss_total_claim' => $current_stock_for_claim,
//                'whss_total_for_sale' => $current_stock_for_sale,
//
//                'whss_warehouse_id' => 1,
//                'whss_datetime' => Carbon::now()->toDateTimeString(),
//                'whss_brwsr_info' => $brwsr_rslt,
//                'whss_ip_adrs' => $ip_rslt,
//                'whss_update_datetime' => Carbon::now()->toDateTimeString()
//            ];
//        }
//
//        return $data;
//    }


//    public function view_product_opening_stock(Request $request, $array = null, $str = null)
//    {
//        $main_units = MainUnitModel::orderby('mu_title', 'ASC')->get();
//        $units = UnitInfoModel::orderBy('unit_title', 'ASC')->get();
//        $groups = GroupInfoModel::orderBy('grp_title', 'ASC')->get();
//        $categories = CategoryInfoModel::orderBy('cat_title', 'ASC')->get();
//        $product_reporting_groups = ProductGroupModel::orderBy('pg_title', 'ASC')->get();
//
//        $search_main_unit = $request->main_unit;
//        $search_unit = $request->unit;
//        $search_group = $request->group;
//        $search_category = $request->category;
//        $search_product_reporting_group = $request->product_reporting_group;
//
//
//        $ar = json_decode($request->array);
//        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
//        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
//        $prnt_page_dir = 'print.product_opening_stock.product_opening_stock';
//        $pge_title = 'Product Opening Stock';
//        $srch_fltr = [];
//        array_push($srch_fltr, $search);
//
//        $pagination_number = (empty($ar)) ? 30 : 100000000;
//
////        DB::enableQueryLog();
//
//        $query = DB::table('financials_products')
//            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_products.pro_createdby');
//
//        if (!empty($search)) {
//            $query->where('pro_title', 'like', '%' . $search . '%')
//                ->orWhere('pro_code', 'like', '%' . $search . '%')
//                ->orWhere('user_designation', 'like', '%' . $search . '%')
//                ->orWhere('user_name', 'like', '%' . $search . '%')
//                ->orWhere('user_username', 'like', '%' . $search . '%');
//        }
//
//        if (isset($search_main_unit) && !empty($search_main_unit)) {
//            $query->where('pro_main_unit_id', $search_main_unit);
//        }
//
//        if (isset($search_unit) && !empty($search_unit)) {
//            $query->where('pro_unit_id', $search_unit);
//        }
//
//        if (isset($search_group) && !empty($search_group)) {
//            $query->where('pro_group_id', $search_group);
//        }
//
//        if (isset($search_category) && !empty($search_category)) {
//            $query->where('pro_category_id', $search_category);
//        }
//
//        if (isset($search_product_reporting_group) && !empty($search_product_reporting_group)) {
//            $query->where('pro_reporting_group_id', $search_product_reporting_group);
//        }
//
//
//        $datas = $query->where('pro_type', config('global_variables.parent_product_type'))
//            ->orderBy('pro_title', 'ASC')
//            ->paginate($pagination_number);
//
////        dd(DB::getQueryLog());
//
//        $product_names = ProductModel::where('pro_type', config('global_variables.parent_product_type'))->orderBy('pro_title', 'ASC')->pluck('pro_title')->all();
//
//        if (isset($request->array) && !empty($request->array)) {
//
//            $type = (isset($request->str)) ? $request->str : '';
//
//            $footer = view('print._partials.pdf_footer')->render();
//            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
//            $options = [
//                'footer-html' => $footer,
//                'header-html' => $header,
//            ];
//
//            $pdf = PDF::loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
//            $pdf->setOptions($options);
//
//
//            if ($type === 'pdf') {
//                return $pdf->stream($pge_title . '_x.pdf');
//            } else if ($type === 'download_pdf') {
//                return $pdf->download($pge_title . '_x.pdf');
//            } else if ($type === 'download_excel') {
//                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
//            }
//
//        } else {
//            return view('view_product_opening_stock', compact('datas', 'search', 'product_names', 'main_units', 'units', 'groups', 'categories', 'product_reporting_groups', 'search_group', 'search_category', 'search_main_unit', 'search_unit', 'search_product_reporting_group'));
//        }
//    }

//    public function submit_product_opening_stock()
//    {
//        $notes = 'OPENING_BALANCE';
//        $rollBack = false;
//        $user = Auth::User();
//
//        $products = ProductModel::where('pro_type', config('global_variables.parent_product_type'))->get();
//
//        DB::beginTransaction();
//
//        $warehouse_stock = $this->UpdateWarehouseStocksValues($products, 1);
//
//        if (!DB::table('financials_warehouse_stock')->insert($warehouse_stock)) {
//            $rollBack = true;
//            DB::rollBack();
//            return redirect()->back()->with('fail', 'Failed Try Again');
//        }
//
//        $opening_stock = $this->UpdateStockMovementValues($products, 0, $notes, '', $notes);
//
//        if (!DB::table('financials_stock_movement')->insert($opening_stock)) {
//            $rollBack = true;
//            DB::rollBack();
//            return redirect()->back()->with('fail', 'Failed Try Again');
//        }
//
//        if ($rollBack) {
//            DB::rollBack();
//            return redirect()->back()->with('fail', 'Failed Try Again');
//        } else {
//
//            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' Of Products');
//            DB::commit();
//            return redirect()->back()->with('success', 'Successfully Saved');
//        }
//    }
//
//    public function UpdateWarehouseStocksValues($array, $warehouse_id)
//    {
//        $brwsr_rslt = $this->getBrwsrInfo();
//        $ip_rslt = $this->getIp();
//
//        $data = [];
//        foreach ($array as $key) {
//
//            $pro_code = $key->pro_p_code;
//            $current_stock = $key->pro_quantity;
//
//            $data[] = ['whs_product_code' => $pro_code, 'whs_stock' => $current_stock, 'whs_warehouse_id' => $warehouse_id, 'whs_datetime' => Carbon::now()->toDateTimeString(), 'whs_brwsr_info' => $brwsr_rslt, 'whs_ip_adrs' => $ip_rslt, 'whs_update_datetime' => Carbon::now()->toDateTimeString()];
//
//        }
//        return $data;
//    }
//
//    public function UpdateStockMovementValues($array, $account_uid, $account_name, $invoice_id, $notes)
//    {
//        $user = Auth::user();
//
//        $data = [];
//
//        $get_day_end = new DayEndController();
//        $day_end = $get_day_end->day_end();
//
//        foreach ($array as $value) {
//
//            $product_code = $value->pro_code;
//            $product_name = $value->pro_title;
//            $product_remarks = $value->pro_remarks;
//            $product_bal_qty = $value->pro_quantity;
//            $product_bal_rate = $value->pro_purchase_price;
//            $product_bal_total = $product_bal_qty * $product_bal_rate;
//
//            $data[] = [
//                'sm_product_code' => $product_code,
//                'sm_product_name' => $product_name,
//                'sm_pur_qty' => 0,
//                'sm_pur_rate' => 0,
//                'sm_pur_total' => 0,
//                'sm_sale_qty' => 0,
//                'sm_sale_rate' => 0,
//                'sm_sale_total' => 0,
//                'sm_bal_qty' => $product_bal_qty,
//                'sm_bal_rate' => $product_bal_rate,
//                'sm_bal_total' => $product_bal_total,
//                'sm_type' => $notes,
//                'sm_day_end_id' => 1,
//                'sm_day_end_date' => $day_end->de_datetime,
//                'sm_voucher_code' => 0,
//                'sm_remarks' => $product_remarks,
//                'sm_user_id' => $user->user_id,
//                'sm_date_time' => Carbon::now()->toDateTimeString(),
//            ];
//        }
//
//        return $data;
//    }

}
