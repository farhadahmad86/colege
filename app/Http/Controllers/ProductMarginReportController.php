<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\ProductModel;
use App\Models\SaleInvoiceItemsModel;
use App\Models\SaleInvoiceModel;
use App\Models\SaleSaletaxInvoiceItemsModel;
use App\Models\SaleSaletaxInvoiceModel;
use App\Models\StockMovementModels;
use PDF;
use Illuminate\Http\Request;

use Auth;
use Maatwebsite\Excel\Facades\Excel;


class ProductMarginReportController extends Controller
{
    // update code by mustafa start
    public function product_margin_report(Request $request, $array = null, $str = null)
    {

        $ar = json_decode($request->array);
//        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->from;
        $search_product = (!isset($request->product_code) && empty($request->product_code)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->product_code;
//        $search_product_name = (!isset($request->product_name) && empty($request->product_name)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->product_name;
//        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->to;
//        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.product_margin_report.product_margin_report';
        $pge_title = 'Product Margin Report';
        $srch_fltr = [];
        array_push($srch_fltr, $search_from, $search_product);//, $search_product_name);//$search_to,

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_from));
//        $end = date('Y-m-d', strtotime($search_to));
//mysql sub query query
//        SELECT * FROM `financials_stock_movement` WHERE sm_id IN (SELECT MAX(sm_id) FROM financials_stock_movement WHERE sm_type='SALE' AND sm_day_end_date='2021-09-30' GROUP BY sm_product_code)

// laravel sub query query
        $query= StockMovementModels::whereIn('sm_id', function($query) use($start){
            $query->selectRaw('max(sm_id)')->from('financials_stock_movement')->where('sm_type', '=', 'SALE')
                ->where('sm_day_end_date', '=', $start)->groupBy('sm_product_code');
        });


//        if (!empty($search)) {
//            $query->where(function ($query) use ($search) {
//                $query->where('sm_product_name', 'like', '%' . $search . '%')
//                    ->orWhere('sm_type', 'like', '%' . $search . '%')
//                    ->orWhere('sm_product_code', 'like', '%' . $search . '%');
//            });
//        }
        if (!empty($search_product)) {
            $query->where('sm_product_code', $search_product);
        }

        $datas = $query->paginate($pagination_number);

        $products = ProductModel::orderBy('pro_id', 'ASC')->get();

        $product = ProductModel::
        where('pro_delete_status', '!=', 1)->
        orderBy('pro_title', 'ASC')->pluck('pro_title')->all();

        $sale_qty = [];
        foreach ($datas as $product) {
            $default = 0;
            $default = StockMovementModels::where('sm_product_code', $product->sm_product_code)->where('sm_type', '=', 'SALE')
                ->where('sm_day_end_date', $start)->orderBy('sm_product_name')->sum('sm_out_qty');
            if (empty($default)) {
                $sale_qty[] = 0;
            } else {
                $sale_qty[] = $default;
            }
        }

        $sale_amount = [];
        $sale_id = SaleInvoiceModel::where('si_day_end_date', '=', $start)->pluck('si_id');
        $sale_tax_id = SaleSaletaxInvoiceModel::where('ssi_day_end_date', '=', $start)->pluck('ssi_id');

        foreach ($datas as $product) {
            $default = 0;
            $sale = SaleInvoiceItemsModel::whereIn('sii_invoice_id', $sale_id)
                ->where('sii_product_code', $product->sm_product_code)
                ->sum('sii_amount');
            $sale_tax = SaleSaletaxInvoiceItemsModel::whereIn('ssii_invoice_id', $sale_tax_id)
                ->where('ssii_product_code', $product->sm_product_code)
                ->sum('ssii_amount');
            $default = $sale + $sale_tax;
            if (empty($default)) {
                $sale_amount[] = 0;
            } else {
                $sale_amount[] = $default;
            }
        }


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
            $pdf->loadView($prnt_page_dir, compact('datas', 'sale_qty', 'sale_amount', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $sale_qty, $sale_amount, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {

            return view('product_margin_report', compact('datas',  'search_from', 'search_product', 'products', 'product', 'sale_qty', 'sale_amount'));//'search_to',
        }
//         'search_product_name',
    }
    // update code by mustafa end
}
