<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\CategoryInfoModel;
use App\Models\GroupInfoModel;
use App\Models\MainUnitModel;
use App\Models\ProductGroupModel;
use App\Models\ProductModel;
use App\Models\UnitInfoModel;
use PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProductSearchTestController extends Controller
{
    public function product_search_1(Request $request, $type = 1, $array = null, $str = null)
    {
        $main_units = MainUnitModel::where('mu_delete_status', '!=', 1)->where('mu_disabled', '!=', 1)->orderby('mu_title', 'ASC')->get();
        $units = UnitInfoModel::where('unit_delete_status', '!=', 1)->where('unit_disabled', '!=', 1)->orderBy('unit_title', 'ASC')->get();
        $groups = GroupInfoModel::where('grp_delete_status', '!=', 1)->where('grp_disabled', '!=', 1)->orderBy('grp_title', 'ASC')->get();
        $categories = CategoryInfoModel::where('cat_delete_status', '!=', 1)->where('cat_disabled', '!=', 1)->orderBy('cat_title', 'ASC')->get();
        $product_groups = ProductGroupModel::where('pg_delete_status', '!=', 1)->where('pg_disabled', '!=', 1)->orderBy('pg_title', 'ASC')->get();
        $route = "";

        if ($type == config('global_variables.parent_product_type')) {
            $route = 'product_list';
        } else if ($type == config('global_variables.child_product_type')) {
            $route = 'product_clubbing_list';
        }


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_main_unit = (!isset($request->main_unit) && empty($request->main_unit)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->main_unit;
        $search_unit = (!isset($request->unit) && empty($request->unit)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->unit;
        $search_group = (!isset($request->group) && empty($request->group)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->group;
        $search_category = (!isset($request->category) && empty($request->category)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->category;
        $search_product_group = (!isset($request->product_group) && empty($request->product_group)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->product_group;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.' . $route . '.' . $route;
        $pge_title = ucwords(str_replace('_', ' ', $route));
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_main_unit, $search_unit, $search_group, $search_category);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_products')
//            ->leftJoin('financials_inventory', 'financials_products.pro_code', '=', 'financials_inventory.invt_product_id')
            ->leftJoin('financials_groups', 'financials_groups.grp_id', 'financials_products.pro_group_id')
            ->leftJoin('financials_categories', 'financials_categories.cat_id', 'financials_products.pro_category_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_products.pro_createdby');

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
            ->orderBy('pro_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

        $products = $this->get_all_products();

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
            return view($route, compact('datas', 'search', 'product', 'products', 'main_units', 'units', 'groups', 'categories', 'product_groups', 'search_main_unit', 'search_unit', 'search_group', 'search_category', 'search_by_user', 'search_product_group', 'restore_list'));
        }
    }

    public function product_search_2(Request $request)
    {

    }

    public function product_search_3(Request $request)
    {

    }

}
