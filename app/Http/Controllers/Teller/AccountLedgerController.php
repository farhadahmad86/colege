<?php

namespace App\Http\Controllers\Teller;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\DayEndController;
use App\Models\AccountRegisterationModel;
use Auth;
use PDF;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Excel;

class AccountLedgerController extends Controller
{
    public function account_ledger(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();

        $account = AccountRegisterationModel::where('account_employee_id', $user->user_id)->first();

//        dd($account);

        $ar = json_decode($request->array);
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->from;
        $search_account_id = (!isset($account->account_uid) && empty($account->account_uid)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $account->account_uid;
        $search_account_name = (!isset($account->account_name) && empty($account->account_name)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $account->account_name;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $account_id = $search_account_id;
        $account_name = $search_account_name;
        $prnt_page_dir = 'print.account_ledger.account_ledger';
        $pge_title = 'Account Ledger ' . $account_name;
        $srch_fltr = [];
        array_push($srch_fltr, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));


        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $month = date('m', strtotime($day_end->de_datetime));

        $query = DB::table('financials_balances');


        if (!empty($search_to) && !empty($search_from)) {
//                ->whereBetween('bal_day_end_date', [$start, $end])
            $query->whereDate('bal_day_end_date', '>=', $start)
                ->whereDate('bal_day_end_date', '<=', $end)
                ->orderBy('bal_day_end_date', 'DESC');
        } elseif (!empty($search_to) && empty($search_from)) {
            $query->whereDate('bal_day_end_date', '>=', $start)
                ->orderBy('bal_day_end_date', 'DESC');
        } elseif (empty($search_to) && !empty($search_from)) {
            $query->whereDate('bal_day_end_date', '<=', $end)
                ->orderBy('bal_day_end_date', 'DESC');
        } else {
            $query->whereMonth('bal_day_end_date', $month)
//                ->orderBy('bal_id', 'DESC')
                ->orderBy('bal_day_end_id', 'DESC');
        }

        $datas = $query->where('bal_account_id', $search_account_id)
            ->get();


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
            return view('teller/account_ledger', compact('datas', 'account_name', 'account_id', 'search_to', 'search_from'));
        }
    }
}
