<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountRegisterationModel;
use App\Models\AdvanceSalaryItemsModel;
use App\Models\AdvanceSalaryModel;
use App\Models\BalancesModel;
use App\Models\Department;
use App\Models\GenerateSalarySlipModel;
use App\Models\SalarySlipVoucherModel;
use App\Models\SystemConfigModel;
use App\Models\TransactionModel;
use Auth;
use PDF;
use Carbon\Carbon;
use DB;
use Session;
use http\Env\Response;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use phpDocumentor\Reflection\Types\Null_;

class AdvanceSalaryController extends Controller
{
    public function add_advance_salary()
    {
        $heads = explode(',', config('global_variables.payable_receivable_cash_bank'));
//        $heads = explode(',', config('global_variables.advance_salary_head'));
        $pay_accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)
//            ->whereNotIn(
//                'account_uid', AccountRegisterationModel::where('account_parent_code', config('global_variables.purchaser_account_head'))
//                ->where('account_uid', '!=', $purchaser_account)
            ->select('account_name', 'account_uid')->get();
//        return $query;
        $accounts_array = $this->get_account_query('advance_salary');
//        $pay_accounts = $accounts_array[0];
        $advance_salary_accounts = $accounts_array[1];
        $departments = Department::where('dep_delete_status', '!=', 1)->where('dep_disabled', '!=', 1)->get();

        return view('add_advance_salary', compact('departments', 'pay_accounts', 'advance_salary_accounts'));
    }

    public function submit_advance_salary(Request $request)
    {

        $this->advance_salary_validation($request);

        $rollBack = false;

        $user = Auth::user();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();


        $advance_salary_array = json_decode($request->accountsval, true);
        $account_uid = $request->account;
        $account_name_text = $request->account_name_text;
        $total_voucher_amount = $request->total_amount;
        $voucher_remarks = $request->remarks;
        $month = $request->month;

        $notes = 'ADVANCE_SALARY';
        $voucher_code = config('global_variables.ADVANCE_SALARY_VOUCHER_CODE');
        $transaction_type = config('global_variables.ADVANCE_SALARY');


        DB::beginTransaction();

        $adv_salary = new AdvanceSalaryModel();


        $adv_salary = $this->assign_salary_values('as', $adv_salary, $account_uid, $total_voucher_amount, $voucher_remarks, $month, $user, $day_end);


        // system config set increment default id according to user giving start coding
        $sstm_cnfg_clm = 'sc_advance_salary_voucher_number';
        $sstm_cnfg_bp_id_chk = SystemConfigModel::where($sstm_cnfg_clm, '!=', '0')->first();
        $chk_bnk_pymnt = AdvanceSalaryModel::all();
        if ($chk_bnk_pymnt->isEmpty()):
            if (isset($sstm_cnfg_bp_id_chk) && !empty($sstm_cnfg_bp_id_chk)):
                $adv_salary->as_id = $sstm_cnfg_bp_id_chk->$sstm_cnfg_clm;
            endif;
        endif;
        // system config set increment default id according to user giving end coding


        if ($adv_salary->save()) {
            $adv_salary_id = $adv_salary->as_id;
        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }

        $detail_remarks = '';

        $item = $this->voucher_salary_items_values($advance_salary_array, $adv_salary_id, $month, 'asi');

        foreach ($item as $value) {
            $adv_salary_amount = (float)$value['asi_amount'];

            $detail_remarks .= $value['asi_emp_advance_salary_account_name'] . ', @' . number_format($adv_salary_amount, 2) . config('global_variables.Line_Break');
        }

        if (!DB::table('financials_advance_salary_items')->insert($item)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }


        $adv_salary->as_detail_remarks = $detail_remarks;
        if (!$adv_salary->save()) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }

        foreach ($advance_salary_array as $key) {

            $transaction = new TransactionModel();

            $transaction = $this->AssignTransactionsValues($transaction, $key['account_code'], $key['account_amount'], $account_uid, $notes, $transaction_type, $adv_salary_id);

            if ($transaction->save()) {

                $transaction_id = $transaction->trans_id;

                // Selected Accounts

                $balances = new BalancesModel();

                $balances = $this->AssignAccountBalancesValues($balances, $transaction_id, $key['account_code'], $key['account_amount'], 'Dr', $voucher_remarks,
                    $notes, $account_name_text . ' to ' . $key['account_name'] . ', @' . number_format($key['account_amount'], 2) . config('global_variables.Line_Break'), $voucher_code . $adv_salary_id, '');
//
                if (!$balances->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed');
                }

                // Bank Account

                $balances2 = new BalancesModel();

                $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id, $account_uid, $key['account_amount'], 'Cr', $voucher_remarks,
                    $notes, $account_name_text . ' to ' . $key['account_name'] . ', @' . number_format($key['account_amount'], 2) . config('global_variables.Line_Break'), $voucher_code . $adv_salary_id, '');
//                $account_name_text . ' to ' . $key['to_text'] .
                if (!$balance2->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed');
                }

            } else {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed');
            }
        }


        if ($rollBack) {

            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        } else {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $adv_salary->bp_id);
            DB::commit();
            return redirect()->back()->with(['as_id' => $adv_salary_id, 'success' => 'Successfully Saved']);
        }
    }

    public function assign_salary_values($prfx, $voucher_no, $voucher, $account_uid, $total_voucher_amount, $voucher_remarks, $month_year, $user, $day_end, $voucher_type = 0)
    {
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $v_no = $prfx . '_v_no';
        $account_id = $prfx . '_from_pay_account';
        $total_amount = $prfx . '_amount';
//        $bank_amount = $prfx . '_bank_amount';
        $remarks = $prfx . '_remarks';
        $month = $prfx . '_month';
        $created_datetime = $prfx . '_datetime';
        $day_end_id = $prfx . '_day_end_id';
        $day_end_date = $prfx . '_day_end_date';
        $createdby = $prfx . '_created_by';
        $brwsr_info = $prfx . '_brwsr_info';
        $ip_adrs = $prfx . '_ip_adrs';
        $clg_id = $prfx . '_clg_id';
        $branch_id = $prfx . '_branch_id';
        $year_id = $prfx . '_year_id';


        $voucher->$v_no = $voucher_no;
        $voucher->$account_id = $account_uid;
        $voucher->$total_amount = $total_voucher_amount;
        $voucher->$remarks = $voucher_remarks;
        $voucher->$month = $month_year; //date("Y-m-d", strtotime($month_year));
        $voucher->$created_datetime = Carbon::now()->toDateTimeString();
        $voucher->$day_end_id = $day_end->de_id;
        $voucher->$day_end_date = $day_end->de_datetime;
        $voucher->$createdby = $user->user_id;
        $voucher->$clg_id = $user->user_clg_id;
        $voucher->$branch_id = Session::get('branch_id');
        $voucher->$ip_adrs = $ip_rslt;
        $voucher->$year_id = $this->getYearEndId();

//        if ($voucher_type == 1) {
//
//            $voucher->$bank_amount = $total_voucher_amount;
//        }

        return $voucher;
    }

    public function voucher_salary_items_values($values_array, $voucher_number, $month_year, $voucher_no, $prfx)
    {
        $data = [];
//dd($values_array);
        $voucher_id = $prfx . '_as_id';
        $col_voucher_no = $prfx . '_v_no';
        $department_id = $prfx . '_department_id';
        $department_name = $prfx . '_department_name';
        $account_id = $prfx . '_emp_advance_salary_account';
        $account_name = $prfx . '_emp_advance_salary_account_name';
        $amount = $prfx . '_amount';
        $remarks = $prfx . '_remarks';
        $month = $prfx . '_month_year';
        $year_id = $prfx . '_year_id';

        foreach ($values_array as $key) {
            $data[] = [
                $voucher_id => $voucher_number,
                $col_voucher_no => $voucher_no,
                $department_id => $key['department'],
                $department_name => $key['department_name'],
                $account_id => $key['account_code'],
                $account_name => $key['account_name'],
                $amount => $key['account_amount'],
                $remarks => ucfirst($key['account_remarks']),
                $month => $month_year,
                $year_id => $this->getYearEndId(),
            ];
        }

        return $data;
    }

    public function advance_salary_validation($request)
    {
        return $this->validate($request, [
            'account' => ['required', 'numeric'],
//            'to' => ['required', 'numeric'],
//            'amount' => ['required', 'numeric'],
            'remarks' => ['nullable', 'string'],
            'total_advance_amount' => ['required', 'string'],
            'accountsval' => ['required', 'string'],
        ]);
    }


    // update code by shahzaib start
    public function advance_salary_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $heads = config('global_variables.payable_receivable_cash') . ',' . config('global_variables.bank_head');
        $heads = explode(',', $heads);

        $pay_accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)->where('account_employee_id', 0)->where('account_clg_id', $user->user_clg_id)->orderBy('account_uid', 'ASC')
            ->get();

        $advance_salary_accounts = AccountRegisterationModel::where('account_clg_id', $user->user_clg_id)->where('account_parent_code', config('global_variables.advance_salary_head'))->orderBy('account_uid', 'ASC')->get();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_account_to = (!isset($request->account_to) && empty($request->account_to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->account_to;
        $search_account_from = (!isset($request->account_from) && empty($request->account_from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->account_from;
        $search_month = (!isset($request->month) && empty($request->month)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->month;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->from;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.advance_salary_list.advance_salary_list';
        $pge_title = 'Advance Salary List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_account_to, $search_account_from, $search_month, $search_to, $search_from, $search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));


        $query = DB::table('financials_advance_salary')
            ->where('as_clg_id', $user->user_clg_id)
//            ->join('financials_accounts AS ac1', 'financials_advance_salary.as_emp_advance_salary_account', '=', 'ac1.account_uid')
            ->join('financials_accounts AS ac2', 'financials_advance_salary.as_from_pay_account', '=', 'ac2.account_uid')
            ->where('ac2.account_clg_id', $user->user_clg_id)
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_advance_salary.as_created_by')
            ->select('ac2.account_name AS from', 'financials_advance_salary.*', 'financials_users.user_id', 'financials_users.user_name');
//        'ac1.account_name AS to',
        if (!empty($request->search)) {
            $query
//                ->where('ac1.account_name', 'like', '%' . $search . '%')
                ->Where('ac2.account_name', 'like', '%' . $search . '%')
                ->orWhere('as_amount', 'like', '%' . $search . '%')
                ->orWhere('as_remarks', 'like', '%' . $search . '%')
                ->orWhere('as_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_account_to)) {
            $query->where('as_emp_advance_salary_account', $search_account_to);
        }

        if (!empty($search_account_from)) {
            $query->where('as_from_pay_account', $search_account_from);
        }

        if (!empty($search_month)) {
            $query->where('as_month', $search_month);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('as_day_end_date', [$start, $end]);
            $query->whereDate('as_day_end_date', '>=', $start)
                ->whereDate('as_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('as_day_end_date', $start);

        } elseif (!empty($search_from)) {
            $query->where('as_day_end_date', $end);
        }

        if (!empty($search_by_user)) {
            $query->where('as_created_by', $search_by_user);
        }
        if (!empty($search_year)) {
            $query->where('as_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('as_year_id', '=', $search_year);
        }
        $datas = $query->orderBy('as_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

//        if (isset($request->search) && !empty($request->search)) {
//
//            $search = $request->search;
//
//            $salaries = DB::table('financials_advance_salary')
//                ->join('financials_accounts AS ac1', 'financials_advance_salary.as_emp_advance_salary_account', '=', 'ac1.account_uid')
//                ->join('financials_accounts AS ac2', 'financials_advance_salary.as_from_pay_account', '=', 'ac2.account_uid')
//                ->select('ac1.account_name AS to', 'ac2.account_name AS from', 'financials_advance_salary.as_amount', 'financials_advance_salary.as_remarks', 'financials_advance_salary.as_id')
//                ->where('ac1.account_name', 'like', '%' . $search . '%')
//                ->orWhere('ac2.account_name', 'like', '%' . $search . '%')
//                ->orWhere('as_amount', 'like', '%' . $search . '%')
//                ->orWhere('as_remarks', 'like', '%' . $search . '%')
//                ->orWhere('as_id', 'like', '%' . $search . '%')
//                ->orderBy('as_id', 'DESC')
//                ->paginate(1000000);
//        } else {
//
//            $salaries = DB::table('financials_advance_salary')
//                ->join('financials_accounts AS ac1', 'financials_advance_salary.as_emp_advance_salary_account', '=', 'ac1.account_uid')
//                ->join('financials_accounts AS ac2', 'financials_advance_salary.as_from_pay_account', '=', 'ac2.account_uid')
//                ->select('ac1.account_name AS to', 'ac2.account_name AS from', 'financials_advance_salary.as_amount', 'financials_advance_salary.as_remarks', 'financials_advance_salary.as_id')
//                ->orderBy('as_id', 'DESC')
//                ->paginate(15);
//        }

        $heads = config('global_variables.payable_receivable_cash') . ',' . config('global_variables.bank_head') . ',' . config('global_variables.advance_salary_head');
        $heads = explode(',', $heads);

        $accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)->where('account_employee_id', 0)->where('account_clg_id', $user->user_clg_id)->orderBy('account_uid', 'ASC')->pluck('account_name')->all();


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed' => TRUE,
                ]
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
                'margin-top' => 24,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $search_year, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('advance_salary_list', compact('datas', 'search', 'search_year', 'accounts', 'pay_accounts', 'advance_salary_accounts', 'search_to', 'search_from', 'search_account_to', 'search_account_from', 'search_by_user', 'search_month'));
        }


    }

    // update code by shahzaib end

    public function get_advance_salary(Request $request)
    {
        $calculate_balance = new BalancesController();

        $balance = $calculate_balance->calculate_balance($request->id);

        return response()->json($balance);
    }

    public function bank_payment_items_view_details(Request $request)
    {
        $items = AdvanceSalaryItemsModel::where('asi_as_id', $request->id)->orderby('asi_emp_advance_salary_account_name', 'ASC')->get();

        return response()->json($items);
    }

    public function advance_salary_items_view_details_SH(Request $request, $id)
    {

        $adv_sal = AdvanceSalaryModel::with('user')->where('as_id', $id)->first();

        $items = AdvanceSalaryItemsModel::where('asi_as_id', '=', $id)->orderby('asi_emp_advance_salary_account_name', 'ASC')->get();

        $usr_snd = AccountRegisterationModel::where('account_uid', $adv_sal->as_from_pay_account)->value('account_name');
//                $usr_rcvd = AccountRegisterationModel::where('account_uid', $adv_sal->as_emp_advance_salary_account)->value('account_name');
        $usr_rcvd = AccountRegisterationModel::where('account_uid', $adv_sal->as_from_pay_account)->value('account_name');
        $nbrOfWrds = $this->myCnvrtNbr($adv_sal->as_amount);
        $invoice_nbr = $adv_sal->as_id;
//        $invoice_date = $adv_sal->as_created_datetime;
        $invoice_date = $adv_sal->as_day_end_date;
        $invoice_remarks = $adv_sal->as_remarks;
        $type = 'grid';
        $pge_title = 'Advance Salary Voucher';

        return view('voucher_view.advance_salary_voucher.advance_salary_journal_voucher_list_modal', compact('items', 'adv_sal', 'usr_snd', 'usr_rcvd', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));

    }

    public function advance_salary_view_details_pdf_SH(Request $request, $id)
    {
        $adv_sal = AdvanceSalaryModel::with('user')->where('as_id', $id)->first();

        $items = AdvanceSalaryItemsModel::where('asi_as_id', '=', $id)->orderby('asi_emp_advance_salary_account_name', 'ASC')->get();

        $usr_snd = AccountRegisterationModel::where('account_uid', $adv_sal->as_from_pay_account)->value('account_name');
//                $usr_rcvd = AccountRegisterationModel::where('account_uid', $adv_sal->as_emp_advance_salary_account)->value('account_name');
        $usr_rcvd = AccountRegisterationModel::where('account_uid', $adv_sal->as_from_pay_account)->value('account_name');
        $nbrOfWrds = $this->myCnvrtNbr($adv_sal->as_amount);
        $invoice_nbr = $adv_sal->as_id;
//        $invoice_date = $adv_sal->as_created_datetime;
        $invoice_date = $adv_sal->as_day_end_date;
        $invoice_remarks = $adv_sal->as_remarks;
        $type = 'pdf';
        $pge_title = 'Advance Salary Voucher';


        $footer = view('voucher_view._partials.pdf_footer')->render();
        $header = view('voucher_view._partials.pdf_header', compact('invoice_nbr', 'invoice_date', 'pge_title', 'type', 'invoice_remarks'))->render();
        $options = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE,
            ]
        ]);
        $optionss = [
            'footer-html' => $footer,
            'header-html' => $header,
            'margin-top' => 24,
        ];
        $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        $pdf->getDomPDF()->setHttpContext($options, $optionss);
        $pdf->loadView('voucher_view.advance_salary_voucher.advance_salary_journal_voucher_list_modal', compact('items', 'adv_sal', 'usr_snd', 'usr_rcvd', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));
        // $pdf->setOptions($options);


        return $pdf->stream('Advance-Salary-Voucher-Detail.pdf');


    }

    public function get_adv_accounts(Request $request)
    {
        $department_id = $request->department_id;
        $month_year = $request->month_year;
        $month = $request->month;
        $generated = GenerateSalarySlipModel::where('gss_month', $month)->where('gss_department_id', $department_id)->count();
        if ($generated > 0) {
            return response()->json(compact('generated'), 200);
        }
//        $heads = explode(',', config('global_variables.advance_salary_head'));

//        $pay_accounts = DB::table('financials_accounts')
//            ->join('financials_users', 'financials_users.user_id', '=', 'financials_accounts.account_employee_id')
//            ->where('account_department_id', '=', $department_id)->whereIn('account_parent_code', $heads)->where('account_delete_status', '!=', 1)->where('account_disabled', '!=', 1)->where('financials_users.user_disabled','=',0)->select
//            ('account_name', 'account_uid','account_balance as adv_balance')->orderBy('financials_users.user_name')->get();


        $pay_accounts = \Illuminate\Support\Facades\DB::select(DB::raw("select `account_name`, `account_uid`, `bal_total`as total_loan_amount,`loan_instalment_amount`,advance_salary, `financials_salary_info`.* from `financials_accounts`
LEFT join `financials_salary_info` on `financials_salary_info`.`si_user_id` = `financials_accounts`.`account_employee_id`
LEFT join `financials_users` on `financials_users`.`user_id` = `financials_accounts`.`account_employee_id`
LEFT JOIN ( SELECT `bal_id`,`bal_total` ,`bal_account_id` FROM `financials_balances` WHERE `bal_id` IN (SELECT MAX(`bal_id`) AS `bal_id` FROM `financials_balances` GROUP By bal_account_id DESC) ) fin_bal  on (`fin_bal`.`bal_account_id`=`financials_salary_info`.`si_loan_account_uid`)
LEFT JOIN ( SELECT `bal_id` as ad_bal_id,`bal_total` as advance_salary ,`bal_account_id` as ad_account_id FROM `financials_balances` WHERE `bal_id` IN (SELECT MAX(`bal_id`) AS `bal_id` FROM `financials_balances` GROUP By bal_account_id DESC) ) as fin_bal1  on (`fin_bal1`.`ad_account_id`=`financials_salary_info`.`si_advance_salary_account_uid`)
LEFT JOIN (SELECT SUM(`loan_instalment_amount`) AS `loan_instalment_amount`,`loan_account_id` FROM `financials_loan` WHERE  date('" . $month_year . "') BETWEEN `loan_first_payment_month` AND `loan_last_payment_month`  GROUP BY `loan_account_id`) `financials_loan` ON `financials_loan`.`loan_account_id`= `financials_salary_info`.`si_loan_account_uid` where `account_department_id` = '" . $department_id . "' and `account_parent_code` in (11014) and `account_delete_status` != 1 and `account_disabled` != 1  and financials_users.user_disabled=0 GROUP by `financials_users`.`user_name`"));//41412

        return response()->json(compact('pay_accounts', 'month_year', 'generated'), 200);

    }

    public function add_new_advance_salary()
    {
        $user = Auth::User();
        $heads = explode(',', config('global_variables.payable_receivable_cash_bank'));
//        $heads = explode(',', config('global_variables.advance_salary_head'));
        $pay_accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)
//            ->whereNotIn(
//                'account_uid', AccountRegisterationModel::where('account_parent_code', config('global_variables.purchaser_account_head'))
//                ->where('account_uid', '!=', $purchaser_account)
            ->select('account_name', 'account_uid')
            ->where('account_disabled', '!=', 1)
            ->where('account_delete_status', '!=', 1)
            ->where('account_clg_id', $user->user_clg_id)
            ->get();
//        return $query;
        $accounts_array = $this->get_account_query('advance_salary');
//        $pay_accounts = $accounts_array[0];
        $advance_salary_accounts = $accounts_array[1];
        $departments = Department::where('dep_clg_id', $user->user_clg_id)->where('dep_delete_status', '!=', 1)->where('dep_disabled', '!=', 1)->get();

        return view('new_add_advance_salary', compact('departments', 'pay_accounts', 'advance_salary_accounts'));
    }

    public function submit_new_advance_salary(Request $request)
    {

        $this->advance_salary_validation($request);

        $rollBack = false;

        $user = Auth::user();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $advance_salary_array = json_decode($request->accountsval, true);
//        foreach ($requested_arrays as $index => $requested_array) {
//            if ($request->amount[$index] != null) {
//                $item_department = $request->department_id[$index];
//                $item_department_name = $request->department_name[$index];
//                $item_code = $request->account_code[$index];
//                $item_name = $request->account_name[$index];
//                $item_remarks = $request->account_remarks[$index];
//
//                $item_amount = $request->amount[$index];
//
//
//                $advance_salary_array[] = [
//                    'department' => $item_department,
//                    'department_name' => $item_department_name,
//                    'account_code' => $item_code,
//                    'account_name' => $item_name,
//                    'account_remarks' => $item_remarks,
//                    'account_amount' => $item_amount,
//                ];
//            }
//
//        }

        $total_voucher_amount = $request->total_advance_amount;
        $advance_amount = 0;
        foreach ($advance_salary_array as $item) {
            $advance_amount += $item['account_amount'];
        }

        if ($total_voucher_amount == $advance_amount) {

            $account_uid = $request->account;
            $account_name_text = $request->account_name_text;

            $voucher_remarks = $request->remarks;
            $month = $request->month;

            $notes = 'ADVANCE_SALARY';
            $voucher_code = config('global_variables.ADVANCE_SALARY_VOUCHER_CODE');
            $transaction_type = config('global_variables.ADVANCE_SALARY');


            DB::beginTransaction();

            $adv_salary = new AdvanceSalaryModel();
            $adv_v_no = AdvanceSalaryModel::where('as_clg_id', $user->user_clg_id)->count();


            $adv_salary = $this->assign_salary_values('as', $adv_v_no + 1, $adv_salary, $account_uid, $total_voucher_amount, $voucher_remarks, $month, $user, $day_end);


            // system config set increment default id according to user giving start coding
            $sstm_cnfg_clm = 'sc_advance_salary_voucher_number';
            $sstm_cnfg_bp_id_chk = SystemConfigModel::where('sc_clg_id', '=', $user->user_clg_id)->where($sstm_cnfg_clm, '!=', '0')->first();
            $chk_bnk_pymnt = AdvanceSalaryModel::where('as_clg_id', '=', $user->user_clg_id)->get();
            if ($chk_bnk_pymnt->isEmpty()):
                if (isset($sstm_cnfg_bp_id_chk) && !empty($sstm_cnfg_bp_id_chk)):
                    $adv_salary->as_id = $sstm_cnfg_bp_id_chk->$sstm_cnfg_clm;
                endif;
            endif;
            // system config set increment default id according to user giving end coding


            if ($adv_salary->save()) {
                $adv_salary_id = $adv_salary->as_id;
                $adv_voucher_no = $adv_salary->as_v_no;
            } else {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed');
            }

            $detail_remarks = '';

            $item = $this->voucher_salary_items_values($advance_salary_array, $adv_salary_id, $month, $adv_voucher_no, 'asi');

            foreach ($item as $value) {
                $adv_salary_amount = (float)$value['asi_amount'];

                $detail_remarks .= $value['asi_emp_advance_salary_account_name'] . ', ' . $month . ', @' . number_format($adv_salary_amount, 2) . config('global_variables.Line_Break');
            }

            if (!DB::table('financials_advance_salary_items')->insert($item)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed');
            }


            $adv_salary->as_detail_remarks = $detail_remarks;
            if (!$adv_salary->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed');
            }

            foreach ($advance_salary_array as $key) {

//            dd($key);
                $transaction = new TransactionModel();

                $transaction = $this->AssignTransactionsValues($transaction, $key['account_code'], $key['account_amount'], $account_uid, $notes, $transaction_type, $adv_salary_id);

                if ($transaction->save()) {

                    $transaction_id = $transaction->trans_id;

                    // Selected Accounts

                    $balances = new BalancesModel();

                    $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key['account_code'], $key['account_amount'], 'Dr', $voucher_remarks, $notes, $account_name_text . ' to ' . $key['account_name'] . ', ' . $month . ', @'
                        . number_format($key['account_amount'], 2), $voucher_code . $adv_salary_id, '', $voucher_code . $adv_voucher_no, $this->getYearEndId());
//                $account_name_text . ' to ' . $key['to_text'] .
                    if (!$balance->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed');
                    }

                    // Bank Account

                    $balances2 = new BalancesModel();

                    $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id, $account_uid, $key['account_amount'], 'Cr', $voucher_remarks,
                        $notes, $account_name_text . ' to ' . $key['account_name'] . ', ' . $month . ', @' . number_format($key['account_amount'], 2), $voucher_code . $adv_salary_id, '', $voucher_code . $adv_voucher_no, $this->getYearEndId());
//                $account_name_text . ' to ' . $key['to_text'] .
                    if (!$balance2->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed');
                    }

                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed');
                }
            }


            if ($rollBack) {

                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed');
            } else {

                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $adv_salary->bp_id);
                DB::commit();
                return redirect()->back()->with(['as_id' => $adv_salary_id, 'success' => 'Successfully Saved']);
            }
        } else {
            return redirect()->back()->with('fail', 'Something went wrong!');
        }
    }

    public function advance_salary_report()
    {
        $advance_salary = AdvanceSalaryItemsModel::leftJoin('financials_departments', 'financials_departments.dep_id', '=', 'financials_advance_salary_items.asi_department_id')
            ->select('financials_advance_salary_items.*', 'dep_title')
            ->get();
        return $advance_salary;
        $department_id = Department::where('dep_id', '!=', 1)->pluck('dep_id');
        $month_year = '2023-03-13';
        $pay_accounts = \Illuminate\Support\Facades\DB::select(DB::raw("select `account_name`, `account_uid`, `bal_total`as total_loan_amount,`loan_instalment_amount`,advance_salary, `financials_salary_info`.* from `financials_accounts`
LEFT join `financials_salary_info` on `financials_salary_info`.`si_user_id` = `financials_accounts`.`account_employee_id`
LEFT join `financials_users` on `financials_users`.`user_id` = `financials_accounts`.`account_employee_id`
LEFT JOIN ( SELECT `bal_id`,`bal_total` ,`bal_account_id` FROM `financials_balances` WHERE `bal_id` IN (SELECT MAX(`bal_id`) AS `bal_id` FROM `financials_balances` GROUP By bal_account_id DESC) ) fin_bal  on (`fin_bal`.`bal_account_id`=`financials_salary_info`.`si_loan_account_uid`)
LEFT JOIN ( SELECT `bal_id` as ad_bal_id,`bal_total` as advance_salary ,`bal_account_id` as ad_account_id FROM `financials_balances` WHERE `bal_id` IN (SELECT MAX(`bal_id`) AS `bal_id` FROM `financials_balances` GROUP By bal_account_id DESC) ) as fin_bal1  on (`fin_bal1`.`ad_account_id`=`financials_salary_info`.`si_advance_salary_account_uid`)
LEFT JOIN (SELECT SUM(`loan_instalment_amount`) AS `loan_instalment_amount`,`loan_account_id` FROM `financials_loan` WHERE  date('" . $month_year . "') BETWEEN `loan_first_payment_month` AND `loan_last_payment_month`  GROUP BY `loan_account_id`) `financials_loan` ON `financials_loan`.`loan_account_id`= `financials_salary_info`.`si_loan_account_uid` where `account_department_id` =  2 and `account_parent_code` in (11014) and `account_delete_status` != 1 and `account_disabled` != 1  and financials_users.user_disabled=0 GROUP by `financials_users`.`user_name`"));//41412

        return $pay_accounts;
    }
}
