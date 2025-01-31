<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Wizard\WizardController;
use App\Models\CategoryInfoModel;
use App\Models\GroupInfoModel;
use App\Models\MainUnitModel;
use App\Models\ProductGroupModel;
use App\Models\ProductModel;
use App\Models\UnitInfoModel;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProductPriceUpdateController extends Controller
{
    // update code by shahzaib start
    public function product_price_update(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $main_units = MainUnitModel::where('mu_clg_id',$user->user_clg_id)->orderby('mu_title', 'ASC')->get();
        $units = UnitInfoModel::where('unit_clg_id',$user->user_clg_id)->orderBy('unit_title', 'ASC')->get();
        $groups = GroupInfoModel::where('grp_clg_id',$user->user_clg_id)->orderBy('grp_title', 'ASC')->get();
        $categories = CategoryInfoModel::where('cat_clg_id',$user->user_clg_id)->orderBy('cat_title', 'ASC')->get();
        $product_reporting_groups = ProductGroupModel::where('pg_clg_id',$user->user_clg_id)->orderBy('pg_title', 'ASC')->get();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_group = (!isset($request->group) && empty($request->group)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->group;
        $search_category = (!isset($request->category) && empty($request->category)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->category;
        $search_product_reporting_group = (!isset($request->product_reporting_group) && empty($request->product_reporting_group)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->product_reporting_group;
        $search_main_unit = (!isset($request->main_unit) && empty($request->main_unit)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->main_unit;
        $search_unit = (!isset($request->unit) && empty($request->unit)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->unit;


        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.product_price_update_list.product_price_update_list';
        $pge_title = 'Product Price List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_group, $search_category, $search_product_reporting_group, $search_main_unit, $search_unit);

        $pagination_number = (empty($ar)) ? 100 : 100000000;

//        DB::enableQueryLog();

        $query = DB::table('financials_products')
            ->where('pro_clg_id',$user->user_clg_id)
            ->leftJoin('financials_groups', 'financials_groups.grp_id', 'financials_products.pro_group_id')
            ->leftJoin('financials_categories', 'financials_categories.cat_id', 'financials_products.pro_category_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_products.pro_createdby');

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
            ->orderBy('pro_title', 'ASC')
            ->paginate($pagination_number);

//        dd(DB::getQueryLog());

        $product_names = ProductModel::where('pro_clg_id',$user->user_clg_id)->where('pro_type', config('global_variables.parent_product_type'))->orderBy('pro_title', 'ASC')->pluck('pro_title')
            ->all();

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
            WizardController::updateWizardInfo(['opening_stock'], ['opening_party_balance']);
            return view('product_price_update', compact('datas', 'search', 'product_names', 'main_units', 'units', 'groups', 'categories', 'product_reporting_groups', 'search_group', 'search_category', 'search_main_unit', 'search_unit', 'search_product_reporting_group'));
        }


    }

    // update code by shahzaib end

    public function update_product_price(Request $request)
    {
        $this->product_opening_stock_validation($request);

        $ids = $request->id;
        $p_rate = $request->p_rate;
        $b_rate = $request->b_rate;
        $s_rate = $request->s_rate;
        //        $quantity = $request->quantity;


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

            ProductModel::where('pro_clg_id',$user->user_clg_id)->where('pro_p_code', $ids[$index])->update(
                [
                    'pro_purchase_price' => $p_rate[$index] == '' ? 0 : $p_rate[$index],
                    'pro_bottom_price' => $b_rate[$index] == '' ? 0 : $b_rate[$index],
                    'pro_sale_price' => $s_rate[$index] == '' ? 0 : $s_rate[$index],
            //                    'pro_quantity' => $quantity[$index] == '' ? 0 : $quantity[$index],
                    $brwsr_col => $brwsr_rslt,
                    $ip_col => $ip_rslt,
                    $updt_date_col => Carbon::now()->toDateTimeString()
                ]
            );

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Product Rate of Code: ' . $product->pro_p_code . ' And Name: ' . $product->pro_title);
        }

        return redirect()->back()->with('success', 'Successfully Saved');
    }

    public function product_opening_stock_validation($request)
    {
        return $this->validate($request, [
            'id' => ['required', 'array'],
            'id.*' => ['required', 'numeric'],
            'p_rate' => ['required', 'array'],
            'p_rate.*' => ['nullable', 'numeric'],
            'b_rate' => ['required', 'array'],
            'b_rate.*' => ['nullable', 'numeric'],
            's_rate' => ['required', 'array'],
            's_rate.*' => ['nullable', 'numeric'],
            //            'quantity' => ['required', 'array'],
            //            'quantity.*' => ['nullable', 'numeric'],
        ]);
    }

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
