<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\Department;
use App\Models\SalaryPaymentItemsModel;
use App\Models\SalaryPaymentModel;
use App\Models\SystemConfigModel;
use App\Models\TransactionModel;
use App\User;
use PDF;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use function Brick\Math\floatToString;
use function GuzzleHttp\Promise\all;
use function PHPUnit\Framework\assertIsFloat;

class NewSalaryPaymentVoucherController extends Controller
{
    public function new_salary_payment_voucher()
    {
        $user = Auth::user();
        $heads = explode(',', config('global_variables.payable_receivable_cash_bank'));
//        $heads = explode(',', config('global_variables.advance_salary_head'));
        $pay_accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)
            ->select('account_name', 'account_uid')
            ->where('account_disabled', '!=', 1)
            ->where('account_delete_status', '!=', 1)
            ->where('account_clg_id', $user->user_clg_id)
            ->get();

        $accounts_array = $this->get_account_query('advance_salary');

        $advance_salary_accounts = $accounts_array[1];
        $departments = Department::where('dep_delete_status', '!=', 1)->where('dep_disabled', '!=', 1)->where('dep_clg_id', $user->user_clg_id)->get();

        return view('new_salary_payment_voucher', compact('departments', 'pay_accounts', 'advance_salary_accounts'));
    }

    public function get_salary_payment_accounts(Request $request)
    {
        $user = Auth::user();

        $department_id = $request->department_id;
        $month = $request->month;

//        $pay_accounts = DB::table('financials_accounts as fa')
//            ->where('fa.account_department_id', $department_id)
//            ->where('fa.account_clg_id', $user->user_clg_id)
//            ->whereIn('fa.account_employee_id', function ($query) use ($department_id) {
//                $query->select('user_id')
//                    ->from('financials_users')
//                    ->where('user_delete_status', '!=', 1)
//                    ->where('user_disabled', '=', 0)
//                    ->where('user_department_id', '=', $department_id);
//            })
//            ->groupBy('fa.account_employee_id')
//            ->join('financials_salary_info as fsi', 'fsi.si_user_id', '=', 'fa.account_employee_id')
//            ->join('financials_generate_salary_slip_voucher_items as fgssvi', 'fgssvi.gssi_account_id', '=', 'fsi.si_expense_salary_account_uid')
//            ->join('financials_balances as fb', 'fb.bal_account_id', '=', 'fsi.si_advance_salary_account_uid')
//            ->join('financials_users as fu', 'fu.user_id', '=', 'fa.account_employee_id')
//            ->leftJoin('financials_balances as max_bal', function ($join) use ($user) {
//                $join->on('max_bal.bal_account_id', '=', 'fsi.si_advance_salary_account_uid')
//                    ->where('max_bal.bal_clg_id', '=', $user->user_clg_id)
//                    ->selectRaw('MAX(max_bal.bal_id)');
//            })
//            ->where('fu.user_delete_status', '!=', 1)
//            ->where('fu.user_disabled', '=', 0)
//            ->where('fsi.si_clg_id', $user->user_clg_id)
//            ->where('fb.bal_clg_id', $user->user_clg_id)
//            ->where('fgssvi.gssi_month_year', '=', $month)
//            ->where('fgssvi.gssi_clg_id', $user->user_clg_id)
//            ->whereRaw('fb.bal_id = max_bal.bal_id')
//            ->select('fgssvi.gssi_net_salary', 'fb.bal_id', 'fb.bal_account_id', 'fb.bal_total', 'fu.user_id', 'fu.user_name')
//            ->orderBy('fu.user_name')
//            ->get();
//
//        return response()->json(compact('pay_accounts'), 200);
        $users = User::where('user_delete_status','!=',1)
            ->where('user_disabled','=',0)
            ->where('user_department_id','=',$department_id)
            ->pluck('user_id');

        $max_bal_id = DB::table('financials_accounts')
            ->where('account_department_id', $department_id)
            ->where('account_clg_id', $user->user_clg_id)
            ->whereIn('account_employee_id',$users)
            ->groupBy('account_employee_id')
            ->join('financials_salary_info', 'financials_salary_info.si_user_id', '=', 'financials_accounts.account_employee_id')
            ->join('financials_balances', 'financials_balances.bal_account_id', '=', 'financials_salary_info.si_advance_salary_account_uid')
            ->where('financials_salary_info.si_clg_id', $user->user_clg_id)
            ->where('financials_balances.bal_clg_id', $user->user_clg_id)
            ->select(DB::raw('MAX(bal_id) AS bal_id'))
            ->pluck('bal_id');

        $pay_accounts = DB::table('financials_accounts')
            ->where('account_department_id', $department_id)
            ->where('account_clg_id', $user->user_clg_id)
            ->whereIn('account_employee_id',$users)
            ->groupBy('account_employee_id')
            ->join('financials_salary_info', 'financials_salary_info.si_user_id', '=', 'financials_accounts.account_employee_id')
            ->join('financials_generate_salary_slip_voucher_items', 'financials_generate_salary_slip_voucher_items.gssi_account_id', '=', 'financials_salary_info.si_expense_salary_account_uid')
            ->where('financials_generate_salary_slip_voucher_items.gssi_month_year', '=', $month)
            ->join('financials_balances', 'financials_balances.bal_account_id', '=', 'financials_salary_info.si_advance_salary_account_uid')
            ->join('financials_users', 'financials_users.user_id', '=', 'financials_accounts.account_employee_id')
            ->where('user_delete_status','!=',1)
            ->where('user_disabled','=',0)
            ->whereIn('financials_balances.bal_id', $max_bal_id)
            ->where('financials_salary_info.si_clg_id', $user->user_clg_id)
            ->where('financials_balances.bal_clg_id', $user->user_clg_id)
            ->where('financials_generate_salary_slip_voucher_items.gssi_clg_id', $user->user_clg_id)
            ->select('financials_generate_salary_slip_voucher_items.gssi_net_salary', 'financials_balances.bal_id', 'financials_balances.bal_account_id', 'financials_balances.bal_total', 'financials_users.user_id', 'financials_users.user_name')
            ->orderBy('financials_users.user_name')
            ->get();

        return response()->json(compact('pay_accounts'), 200);

    }

    public function submit_salary_payment(Request $request)
    {
        $user = Auth::user();
        $this->salary_payment_voucher_validation($request);
        $month = $request->month;


        $payment_salary_array = json_decode($request->accountsval, true);
//        dd($request->all(),$payment_salary_array);
//        $requested_arrays = $request->account_code;
//        foreach ($requested_arrays as $index => $requested_array) {
//            if ($request->payment_amount[$index] != 0) {
//                $item_employee_id = $request->employee_id[$index];
//                $item_department = $request->department_id[$index];
//                $item_department_name = $request->department_name[$index];
//                $item_code = $request->account_code[$index];
//                $item_name = $request->account_name[$index];
//                $item_net_salary = $request->net_salary[$index];
//                $item_adv_salary_led_bal = $request->adv_salary_led_bal[$index];
//                $item_payment_amount = $request->payment_amount[$index];
//
//
//                $payment_salary_array[] = [
//                    'employee_id' => $item_employee_id,
//                    'department' => $item_department,
//                    'department_name' => $item_department_name,
//                    'account_code' => $item_code,
//                    'account_name' => $item_name,
//                    'net_salary' => $item_net_salary,
//                    'adv_salary_led_bal' => $item_adv_salary_led_bal,
//                    'payment_amount' => $item_payment_amount,
//                ];
//            }
//        }

        $rollBack = false;

        $notes = 'SALARY_PAYMENT_VOUCHER';

        $voucher_code = config('global_variables.SALARY_PAYMENT_VOUCHER_CODE');

        $transaction_type = config('global_variables.SALARY_PAYMENT');
        $account_name_text = $this->get_account_name($request->account);

        DB::beginTransaction();

        $salary_payment = new SalaryPaymentModel();
        $salary_v_no = SalaryPaymentModel::where('sp_clg_id', $user->user_clg_id)->count();

        $salary_payment = $this->assign_salary_payment_voucher_values($request, $salary_payment, $salary_v_no + 1);


        // system config set increment default id according to user giving start coding
        $sstm_cnfg_clm = 'sc_salary_payment_voucher_number';
        $sstm_cnfg_bp_id_chk = SystemConfigModel::where('sc_clg_id', '=', $user->user_clg_id)->where($sstm_cnfg_clm, '!=', '0')->first();
        $chk_bnk_pymnt = SalaryPaymentModel::where('sp_clg_id', '=', $user->user_clg_id)->get();
        if ($chk_bnk_pymnt->isEmpty()):
            if (isset($sstm_cnfg_bp_id_chk) && !empty($sstm_cnfg_bp_id_chk)):
                $salary_payment->sp_id = $sstm_cnfg_bp_id_chk->$sstm_cnfg_clm;
            endif;
        endif;
        // system config set increment default id according to user giving end coding


        if ($salary_payment->save()) {
            $salary_payment_id = $salary_payment->sp_id;
            $sp_voucher_no = $salary_payment->sp_v_no;
        }


        $items = [];
        $detail_remarks = '';
//        $item = $this->voucher_salary_items_values($generate_salary_array, $generate_salary_id, $month, 'gssi');
        $item = $this->salary_payment_voucher_items_values($payment_salary_array, $salary_payment_id, $month, $sp_voucher_no, 'spi');

        foreach ($item as $value) {
            $account_name = AccountRegisterationModel::where('account_uid', '=', $value['spi_account_id'])->pluck('account_name');

            $paid_salary_amount = (float)$value['spi_paid_amount'];

            $detail_remarks .= $account_name_text . ' to ' . $value['spi_account_name'] . ', ' . $month . ', @' . number_format($paid_salary_amount, 2) . config('global_variables.Line_Break');
        }

        if (!DB::table('financials_salary_payment_items')->insert($item)) {
            $rollBack = true;
        }

        $salary_payment->sp_detail_remarks = $detail_remarks;

        if (!$salary_payment->save()) {
            $rollBack = true;
        }

        $transaction = new TransactionModel();

        $transaction = $this->AssignTransactionsValues($transaction, 0, $request->total_payable_amount, $request->account, $notes, $transaction_type, $salary_payment_id);
        if ($transaction->save()) {

            $transaction_id = $transaction->trans_id;

            $balances = new BalancesModel();

            $balances = $this->AssignAccountBalancesValues($balances, $transaction_id, $request->account, $request->total_payable_amount, 'Cr', $request->remarks, $notes, $detail_remarks, $voucher_code .
                $salary_payment_id, '', $voucher_code . $sp_voucher_no,$this->getYearEndId());

            if (!$balances->save()) {
                $rollBack = true;
            }
        } else {
            $rollBack = true;
        }

        foreach ($payment_salary_array as $key) {

//            $account_code = SalaryInfoModel::where('si_user_id', $key['account_code'])->pluck('si_advance_salary_account_uid')->first();
            $account_code = $key['account_code'];
            $account_name = $this->get_account_name($account_code);
            $account_amount = $key['payment_amount'];

            $item_remarks = $account_name_text . ' to ' . $account_name . ', ' . $month . ', @' . $account_amount;

            $transaction = new TransactionModel();
            $transaction = $this->AssignTransactionsValues($transaction, $account_code, $account_amount, 0, $notes, $transaction_type, $salary_payment_id);

            if ($transaction->save()) {

                $transaction_id = $transaction->trans_id;

                $balances = new BalancesModel();

                $balances = $this->AssignAccountBalancesValues($balances, $transaction_id, $account_code, $account_amount, 'Dr', $request->remarks, $notes, $item_remarks, $voucher_code .
                    $salary_payment_id, '', $voucher_code . $sp_voucher_no,$this->getYearEndId());

                if (!$balances->save()) {
                    $rollBack = true;
                }
            } else {
                $rollBack = true;
            }
        }

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');

        } else {
            $user = Auth::user();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $salary_payment_id);

            DB::commit();
            return redirect()->back()->with(['salary_payment_id' => $salary_payment_id, 'success' => 'Successfully Saved']);
        }
    }

    public function salary_payment_voucher_validation($request)
    {
        return $this->validate($request, [
            'account' => ['required', 'numeric'],
            'month' => ['required', 'string'],
            'department' => ['required', 'numeric'],
            'remarks' => ['nullable', 'string'],
            'total_payable_amount' => ['required', 'numeric'],
        ]);

    }

    public function assign_salary_payment_voucher_values($request, $ep, $voucher_no)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $ep->sp_v_no = $voucher_no;
        $ep->sp_payment_account = $request->account;
        $ep->sp_month = $request->month;
        $ep->sp_remarks = ucfirst($request->remarks);
        $ep->sp_total_amount = $request->total_payable_amount;
        $ep->sp_created_datetime = Carbon::now()->toDateTimeString();
        $ep->sp_day_end_id = $day_end->de_id;
        $ep->sp_day_end_date = $day_end->de_datetime;
        $ep->sp_createdby = $user->user_id;
        $ep->sp_clg_id = $user->user_clg_id;
        $ep->sp_branch_id = Session::get('branch_id');
        $ep->sp_year_id = $this->getYearEndId();

        // coding from shahzaib start
        $tbl_var_name = 'ep';
        $prfx = 'sp';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now()->toDateTimeString();
        // coding from shahzaib end

        return $ep;
    }

    public function salary_payment_voucher_items_values($values_array, $voucher_number, $month_year, $v_number, $prfx)
    {
        $user = Auth::user();
        $data = [];

        $voucher_id = $prfx . '_sp_id';
        $voucher_no = $prfx . '_v_no';
        $employee_id = $prfx . '_employee_id';
        $department_id = $prfx . '_department_id';
        $department_name = $prfx . '_department_name';
        $account_id = $prfx . '_account_id';
        $account_name = $prfx . '_account_name';
        $net_salary = $prfx . '_net_salary';
        $adv_salary_led_bal = $prfx . '_payable_amount';
        $payment_amount = $prfx . '_paid_amount';
        $clg_id = $prfx . '_clg_id';
        $branch_id = $prfx . '_branch_id';
        $year_id = $prfx . '_year_id';

        $month = $prfx . '_month_year';

        foreach ($values_array as $key) {
            $emp_account_name = AccountRegisterationModel::where('account_uid', '=', $key['account_code'])->first();

            $data[] = [
                $voucher_id => $voucher_number,
                $voucher_no => $v_number,
                $employee_id => $key['employee_id'],
                $department_id => $key['department'],
                $department_name => $key['department_name'],
                $account_id => $key['account_code'],
                $account_name => $emp_account_name->account_name,
                $net_salary => $key['net_salary'],
                $adv_salary_led_bal => $key['adv_salary_led_bal'],
                $payment_amount => $key['payment_amount'],
                $month => $month_year,
                $clg_id => $user->user_clg_id,
                $branch_id => Session::get('branch_id'),
                $year_id => $this->getYearEndId()
            ];
        }

        return $data;
    }

    // update code by Mustafa start
    public function salary_payment_list(Request $request, $array = null, $str = null)
    {
        $heads = explode(',', config('global_variables.payable_receivable_cash_bank'));
        $accounts = $this->get_fourth_level_account($heads, 0, 1);

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_month = (!isset($request->month) && empty($request->month)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->month;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->from;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $search_account = (isset($request->account) && !empty($request->account)) ? $request->account : '';
        $prnt_page_dir = 'print.salary_payment_voucher_list.salary_payment_voucher_list';
        $pge_title = 'Salary Payment Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_month, $search_to, $search_from,$search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));


//        $query = SalaryPaymentVoucherModel::query();
        $query = DB::table('financials_salary_payment')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_salary_payment.sp_createdby');
        $ttl_amnt = $query->sum('sp_total_amount');

        if (!empty($request->search)) {
            $query->where('sp_total_amount', 'like', '%' . $search . '%')
                ->orWhere('sp_remarks', 'like', '%' . $search . '%')
                ->orWhere('sp_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('sp_createdby', $search_by_user);
        }
        if (!empty($search_month)) {
            $query->where('sp_month', $search_month);
        }
        if (!empty($search_account)) {
            $query->where('sp_payment_account_id', $search_account);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('sp_day_end_date', [$start, $end]);
            $query->whereDate('sp_day_end_date', '>=', $start)
                ->whereDate('sp_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('sp_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('sp_day_end_date', $end);
        }
        if (!empty($search_year)) {
            $query->where('sp_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('sp_year_id', '=', $search_year);
        }
        $datas = $query->orderBy('sp_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);


//        if (isset($request->search) && !empty($request->search)) {
//
//            $search = $request->search;
//
//            $vouchers = SalaryPaymentVoucherModel::
//            orWhere('sp_total_amount', 'like', '%' . $search . '%')
//                ->orWhere('sp_remarks', 'like', '%' . $search . '%')
//                ->orWhere('sp_id', 'like', '%' . $search . '%')
//                ->orderBy('sp_id', 'DESC')
//                ->paginate(1000000);
//
//        } else {
//
//            $vouchers = SalaryPaymentVoucherModel::orderBy('sp_id', 'DESC')
//                ->paginate(15);
//        }


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
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type,$search_year, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('new_salary_payment_list', compact('datas', 'search', 'search_to', 'search_year','search_from', 'ttl_amnt', 'search_by_user', 'accounts', 'search_account', 'search_month'));
        }

    }

    // update code by Mustafa end

    public function new_salary_payment_items_view_details(Request $request)
    {
        $items = SalaryPaymentItemsModel::where('spi_sp_id', $request->id)->orderby('spi_account_name', 'ASC')->get();

        return response()->json($items);
    }

    public function new_salary_payment_items_view_details_SH(Request $request, $id)
    {

        $slry_pmnt = SalaryPaymentModel::with('user')->where('sp_id', $id)->first();
        $items = SalaryPaymentItemsModel::where('spi_sp_id', $id)->orderby('spi_account_name', 'ASC')->get();
        $sp_acnt_nme = AccountRegisterationModel::where('account_uid', $slry_pmnt->sp_payment_account)->first();
        $nbrOfWrds = $this->myCnvrtNbr($slry_pmnt->sp_total_amount);
        $invoice_nbr = $slry_pmnt->sp_id;
//        $invoice_date = $slry_pmnt->sp_created_datetime;
        $invoice_date = $slry_pmnt->sp_day_end_date;
        $invoice_remarks = $slry_pmnt->sp_remarks;
        $type = 'grid';
        $pge_title = 'Salary Payment Voucher';


        return view('voucher_view.new_salary_payment_voucher.new_salary_payment_journal_voucher_list_modal', compact('items', 'slry_pmnt', 'sp_acnt_nme', 'nbrOfWrds', 'invoice_nbr', 'invoice_date',
            'invoice_remarks', 'type', 'pge_title'));

    }

    public function new_salary_payment_items_view_details_pdf_SH(Request $request, $id)
    {

        $slry_pmnt = SalaryPaymentModel::with('user')->where('sp_id', $id)->first();
        $items = SalaryPaymentItemsModel::where('spi_sp_id', $id)->orderby('spi_account_name', 'ASC')->get();
        $sp_acnt_nme = AccountRegisterationModel::where('account_uid', $slry_pmnt->sp_payment_account)->first();
        $nbrOfWrds = $this->myCnvrtNbr($slry_pmnt->sp_total_amount);
        $invoice_nbr = $slry_pmnt->sp_id;
//        $invoice_date = $slry_pmnt->sp_created_datetime;
        $invoice_date = $slry_pmnt->sp_day_end_date;
        $invoice_remarks = $slry_pmnt->sp_remarks;
        $type = 'pdf';
        $pge_title = 'Salary Payment Voucher';


        $footer = view('voucher_view._partials.pdf_footer')->render();
        $header = view('voucher_view._partials.pdf_header', compact('invoice_nbr', 'invoice_date', 'pge_title', 'type', 'invoice_remarks'))->render();
        $options = [
            'footer-html' => $footer,
            'header-html' => $header,
            'margin-top' => 30,
        ];

        $pdf = PDF::loadView('voucher_view.new_salary_payment_voucher.new_salary_payment_journal_voucher_list_modal', compact('items', 'slry_pmnt', 'sp_acnt_nme', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));
        $pdf->setOptions($options);


        return $pdf->stream('Salary-Payment-Voucher-Detail.pdf');

    }

    public function new_salary_payment_items_view_details_single_pdf_SH(Request $request, $id)
    {

//        $slry_pmnt = SalaryPaymentVoucherModel::where('sp_id', $request->id)->first();
//        $items = SalaryPaymentVoucherItemsModel::where('spi_salary_payment_voucher_id', $request->id)->orderby('spi_account_name', 'ASC')->get();
//        $sp_acnt_nme = AccountRegisterationModel::where('account_uid', $slry_pmnt->sp_account_id)->first();
//        $nbrOfWrds = $this->myCnvrtNbr($slry_pmnt->sp_total_amount);
//
//        $pdf = PDF::loadView('voucher_view.salary_payment_voucher.salary_payment_journal_voucher_double_entry_list_pdf', compact('items', 'slry_pmnt', 'sp_acnt_nme', 'nbrOfWrds'));
//        return $pdf->stream('Salary-Payment-Voucher-Detail.pdf');


        $slry_pmnt = SalaryPaymentModel::where('sp_id', $id)->first();
        $items = SalaryPaymentItemsModel::where('spi_sp_id', $id)->orderby('spi_account_name', 'ASC')->get();
        $sp_acnt_nme = AccountRegisterationModel::where('account_uid', $slry_pmnt->sp_payment_account)->first();
        $nbrOfWrds = $this->myCnvrtNbr($slry_pmnt->sp_total_amount);
        $invoice_nbr = $slry_pmnt->sp_id;
        $invoice_date = $slry_pmnt->sp_created_datetime;
        $invoice_remarks = $slry_pmnt->sp_remarks;
        $type = 'pdf';
        $pge_title = 'Salary Payment Voucher';


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
        $pdf->loadView('voucher_view.salary_payment_voucher.salary_payment_journal_voucher_double_entry_list_modal', compact('items', 'slry_pmnt', 'sp_acnt_nme', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));
        // $pdf->setOptions($options);


        return $pdf->stream('Salary-Payment-Voucher-Detail.pdf');


    }
}
