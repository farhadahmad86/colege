<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AreaModel;
use App\Models\RegionModel;
use PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DayEndReportController extends Controller
{
    // update code by shahzaib start
    public function day_end_reports(Request $request, $array = null, $str = null)
    {



//        $search = (isset($request->search) && $request->filter_search === "normal_search") ? $request->search : '';
//        $search_region = (isset($request->region) && $request->filter_search === "filter_search") ? $request->region : '';

//        dd($request);/
        $ar = json_decode($request->array);

        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->to;

        $start = date('Y-m-d', strtotime($search_to));



        $prnt_page_dir = 'print.day_end_list.day_end_list';
        $pge_title = 'Day End Report';
        $srch_fltr = [];
        array_push($srch_fltr, $search_to);


        $pagination_number = (empty($ar) || !empty($ar)) ? 30 : 100000000;

        $query = DB::table('financials_day_end')->where('de_datetime_status','=','CLOSE')
            ->leftJoin('financials_users', 'financials_users.user_id', '=', 'financials_day_end.de_createdby');

        if ((!empty($search_to))) {
//
            $query->whereDate('de_datetime', '=', $start);

        } elseif (!empty($search_to)) {
            $query->where('de_datetime', $start);
        }

        $datas = $query
//            ->where('area_delete_status', '!=', 1)
//            ->orderBy('de_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);



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
//            $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
//            dd($datas);
            return view('new_day_end_report', compact('datas', 'search_to'));
        }

    }

    // update code by shahzaib end

}
