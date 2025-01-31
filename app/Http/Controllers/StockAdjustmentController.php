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

class StockAdjustmentController extends Controller
{
    public function stock_adjustment(Request $request, $type = 1, $array = null, $str = null)
    {
        $products = ProductModel::orderBy('pro_title', 'ASC')->get();
//
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_product = (!isset($request->product) && empty($request->product)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->product;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->to;

        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = '';//print.' . $route . '.' . $route;
        $pge_title = 'Stock Taking'; //ucwords(str_replace('_', ' ', $route));
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_product, $search_from, $search_to);

//        $pagination_number = (empty($ar)) ? 30 : 100000000;
        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $query = DB::table('financials_stock_taking')
            ->leftJoin('financials_products', 'financials_stock_taking.st_product_code', '=', 'financials_products.pro_p_code');
//            ->leftJoin('financials_tos', 'financials_tos.grp_id', 'financials_products.pro_to_id')
//            ->leftJoin('financials_categories', 'financials_categories.cat_id', 'financials_products.pro_category_id')
//            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_products.pro_createdby')
//            ->leftJoin('financials_froms', 'financials_froms.from_id', 'financials_products.pro_from_id');

        if (!empty($search)) {
            $query->where('st_product_code', 'like', '%' . $search . '%')
                ->orWhere('st_product_name', 'like', '%' . $search . '%')
                ->orWhere('pro_purchase_price', 'like', '%' . $search . '%')
                ->orWhere('pro_sale_price', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_product)) {
            $query->where('st_product_code', $search_product);
        }

//        if ((!empty($search_to)) && (!empty($search_from))) {
//
            $query->whereDate('st_posting_date_time', '>=', $start)
                ->whereDate('st_posting_date_time', '<=', $end);
//        } elseif (!empty($search_to)) {
//            $query->where('st_posting_date_time', $start);
//        } elseif (!empty($search_from)) {
//            $query->where('st_posting_date_time', $end);
//        }

        if (!empty($search_by_user)) {
            $query->where('pro_createdby', $search_by_user);
        }

        $datas = $query
            ->orderBy('st_id', config('global_variables.query_sorting'))->get();
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
            return view('stock_adjustment', compact('datas', 'search', 'product', 'products', 'search_product', 'search_from', 'search_to', 'search_by_user'));
        }
    }
}
