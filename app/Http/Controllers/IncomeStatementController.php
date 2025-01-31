<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountOpeningClosingBalanceModel;
use App\Models\IncomeStatementItemsModel;
use App\Models\IncomeStatementModel;
use App\Models\RegionModel;
use PDF;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class IncomeStatementController extends Controller
{

    // update code by shahzaib start
    public function income_statement(Request $request, $array = null, $str = null)
    {

        $ar = json_decode($request->array);
        $to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->to;
        $prnt_page_dir = 'print.income_statement.income_statement';
        $pge_title = 'Income Statement';
        $srch_fltr = [];
        array_push($srch_fltr, $to);
        $datas = [];

        $balance = 0;
        $cshBkDate = 0;
        $opening_balance = 0;


        $accounts = '';
        if (!empty($to)) {
//            $to=$request->to;
            $new_date = date('Y-m-d', strtotime($to));
        } else {
            $get_day_end = new DayEndController();
            $day_end = $get_day_end->day_end();

            $your_date = strtotime("-1 day", strtotime($day_end->de_datetime));
            $new_date = date("Y-m-d", $your_date);
        }

        $income_statement = IncomeStatementModel::where('is_day_end_date', $new_date)->first();

        if ($income_statement) {
            $datas = IncomeStatementItemsModel::where('isi_income_statement_id', $income_statement->is_id)->get();
        }


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];

            $pdf = PDF::loadView($prnt_page_dir, compact('datas', 'type', 'pge_title', 'income_statement'));
            $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title, $balance, $cshBkDate, $opening_balance, $income_statement), $pge_title . '_x.xlsx');
            }

        } else {
            return view('income_statement', compact('income_statement', 'datas'));
        }
    }
    // update code by shahzaib end


}
