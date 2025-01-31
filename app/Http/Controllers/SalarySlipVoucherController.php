<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\ExpensePaymentVoucherItemsModel;
use App\Models\ExpensePaymentVoucherModel;
use App\Models\SalaryADItemsModel;
use App\Models\SalaryInfoModel;
use App\Models\SalaryPaymentVoucherModel;
use App\Models\SalarySlipVoucherItemsModel;
use App\Models\SalarySlipVoucherModel;
use App\Models\SystemConfigModel;
use App\Models\TransactionModel;
use App\User;
use Auth;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SalarySlipVoucherController extends Controller
{
    public function salary_slip_voucher()
    {
        $current_month = Carbon::now()->month;

        $employees = User::orderby('user_name', 'ASC')->get();

        $accounts = $this->get_fourth_level_account(0, 0, 0);

        $account_code = '';
        $account_name = '';

        foreach ($accounts as $account) {
            $account_code .= "<option value='$account->account_uid'>$account->account_uid</option>";
            $account_name .= "<option value='$account->account_uid'>$account->account_name</option>";
        }

        return view('salary_slip_voucher', compact('employees', 'account_name', 'account_code', 'current_month'));
    }

    public function get_salary_details(Request $request)
    {
        $data = [];
        $employee_id = $request->id;

        $salary_info = SalaryInfoModel::where('si_user_id', $employee_id)->first();

        $data[] = $salary_info;

        $items = SalaryADItemsModel::where('sadi_user_id', $employee_id)->get();

        $data[] = $items;

        return response()->json($data);
    }

    public function submit_salary_slip_voucher(Request $request)
    {
        $this->salary_slip_voucher_validation($request);

        $salary_info = SalaryInfoModel::where('si_user_id', $request->employee)->first();

        $expense_account = $salary_info->si_expense_salary_account_uid;
        $advance_account = $salary_info->si_advance_salary_account_uid;
        $gross_salary = $request->gross_salary;
        $net_salary = $request->net_salary;

        $values_array = json_decode($request->account_arrays, true);

        $rollBack = false;

        $user = Auth::user();

        $notes = 'SALARY_SLIP_VOUCHER';

        $voucher_code = config('global_variables.SALARY_SLIP_VOUCHER_CODE');

        $transaction_type = config('global_variables.SALARY_SLIP');

        DB::beginTransaction();

        ////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////// Salary Slip Insertion ////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////////

        $salary_slip = new SalarySlipVoucherModel();

        $salary_slip = $this->assign_salary_slip_voucher_values($request, $salary_slip);


        // system config set increment default id according to user giving start coding
        $sstm_cnfg_clm = 'sc_salary_slip_voucher_number';
        $sstm_cnfg_bp_id_chk = SystemConfigModel::where($sstm_cnfg_clm, '!=', '0')->first();
        $chk_bnk_pymnt = SalarySlipVoucherModel::all();
        if ($chk_bnk_pymnt->isEmpty()):
            if (isset($sstm_cnfg_bp_id_chk) && !empty($sstm_cnfg_bp_id_chk)):
                $salary_slip->ss_id = $sstm_cnfg_bp_id_chk->$sstm_cnfg_clm;
            endif;
        endif;
        // system config set increment default id according to user giving end coding


        if ($salary_slip->save()) {
            $salary_slip_id = $salary_slip->ss_id;
        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }


        ////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////// Salary Slip Items Insertion //////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////////

        $detail_remarks = '';

        if (!empty($values_array)) {
            $item = $this->salary_slip_voucher_items_values($values_array, $salary_slip_id);

            foreach ($item as $value) {
                $detail_remarks .= $value['ssi_account_name'] . ' @' . number_format($value['ssi_amount'], 2) . config('global_variables.Line_Break');
            }

            if (!DB::table('financials_salary_slip_voucher_items')->insert($item)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed');
            }
        }


        ////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////// Salary Slip Detail Remarks Insertion /////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////////

        $salary_slip->ss_detail_remarks = $detail_remarks;

        if (!$salary_slip->save()) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }


        ////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////// Salary Slip Transactions Insertion ///////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////////

        $trans_detail_remarks = $expense_account . ' @' . number_format($gross_salary, 2) . config('global_variables.Line_Break');

        $transaction = new TransactionModel();

        $transaction = $this->AssignTransactionsValues($transaction, $expense_account, $gross_salary, 0, $notes, $transaction_type, $salary_slip_id);

        if ($transaction->save()) {

            $transaction_id = $transaction->trans_id;

            //////////////////////////// TRANSACTION ONE ///////////////////////////////////////
            $balances = new BalancesModel();

            $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $expense_account, $gross_salary, 'Dr', '', $notes, $trans_detail_remarks, $voucher_code .
                $salary_slip_id);

            if (!$balance->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed');
            }

        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }


        $trans_detail_remarks = $advance_account . ' @' . number_format($net_salary, 2) . config('global_variables.Line_Break');

        $transaction = new TransactionModel();

        $transaction = $this->AssignTransactionsValues($transaction, 0, $net_salary, $advance_account, $notes, $transaction_type, $salary_slip_id);

        if ($transaction->save()) {

            $transaction_id = $transaction->trans_id;

            //////////////////////////// TRANSACTION ONE ///////////////////////////////////////
            $balances = new BalancesModel();

            $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $advance_account, $net_salary, 'Cr', '', $notes, $trans_detail_remarks, $voucher_code .
                $salary_slip_id);

            if (!$balance->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed');
            }

        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }

        if (!empty($values_array)) {
            foreach ($values_array as $value) {

                $account_code = $value['account_code'];
                $account_name = $value['account_name'];
                $allowance_deduction = $value['allowance_deduction'];
                $account_amount = $value['account_amount'];
                $account_remarks = $value['account_remarks'];

                $trans_detail_remarks = $account_name . ' @' . number_format($account_amount, 2) . config('global_variables.Line_Break');

                $transaction = new TransactionModel();

                if ($allowance_deduction == 1) {
                    $dr_account = $account_code;
                    $cr_account = 0;
                    $type = 'Dr';
                } else {
                    $dr_account = 0;
                    $cr_account = $account_code;
                    $type = 'Cr';
                }

                $transaction = $this->AssignTransactionsValues($transaction, $dr_account, $account_amount, $cr_account, $notes, $transaction_type, $salary_slip_id);

                if ($transaction->save()) {

                    $transaction_id = $transaction->trans_id;

                    //////////////////////////// TRANSACTION ONE ///////////////////////////////////////
                    $balances = new BalancesModel();

                    $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $account_code, $account_amount, $type, $account_remarks, $notes, $trans_detail_remarks, $voucher_code . $salary_slip_id);

                    if (!$balance->save()) {
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
        }

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');

        } else {
            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $salary_slip_id);
            DB::commit();
            return redirect()->back()->with('success', 'Successfully Saved');
        }
    }

    public function salary_slip_voucher_validation($request)
    {
        return $this->validate($request, [
            'employee' => ['required', 'numeric'],
            'basic_salary' => ['required', 'numeric'],
            'salary_period' => ['required', 'numeric'],
            'total_working_days_in_months' => ['required', 'numeric'],
            'working_hours_per_day' => ['required', 'numeric'],
            'hours_or_days' => ['required', 'numeric'],
            'attended_hours' => ['nullable', 'numeric'],
            'attended_days' => ['nullable', 'numeric'],
            'salary_payment_method' => ['required', 'numeric'],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date'],
            'salary_month' => ['nullable', 'numeric'],
            'remarks' => ['nullable', 'string'],
            'total_items' => ['nullable', 'numeric'],
            'gross_salary' => ['required', 'numeric'],
            'total_allowances' => ['nullable', 'numeric'],
            'total_deductions' => ['nullable', 'numeric'],
            'net_salary' => ['required', 'numeric'],
            'account_arrays' => ['nullable', 'string'],
        ]);
    }

    public function assign_salary_slip_voucher_values($request, $salary_slip)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $salary_slip->ss_user_id = $request->employee;
        $salary_slip->ss_basic_salary = $request->basic_salary;
        $salary_slip->ss_basic_salary_per = $request->salary_period;
        $salary_slip->ss_working_hours_per_day = $request->working_hours_per_day;
        $salary_slip->ss_off_days = $request->holidays == '' ? '' : implode(',', $request->holidays);
        $salary_slip->ss_payment_period = $request->salary_payment_method;
        $salary_slip->ss_working_days_per_month = $request->total_working_days_in_months;
        $salary_slip->ss_daily_date = date('Y - m - d', strtotime($request->date_from));
        $salary_slip->ss_weekly_date_from = date('Y - m - d', strtotime($request->date_from));
        $salary_slip->ss_weekly_date_to = date('Y - m - d', strtotime($request->date_to));
        $salary_slip->ss_attended_days = $request->attended_days == '' ? 0 : $request->attended_days;
        $salary_slip->ss_attended_hours = $request->attended_hours == '' ? 0 : $request->attended_hours;
        $salary_slip->ss_calculate_attended = $request->hours_or_days;
        $salary_slip->ss_remarks = ucfirst($request->remarks);
        $salary_slip->ss_gross_salary = $request->gross_salary;
        $salary_slip->ss_total_allowances = $request->total_allowances;
        $salary_slip->ss_total_deduction = $request->total_deductions;
        $salary_slip->ss_net_salary = $request->net_salary;
        $salary_slip->ss_current_datetime = Carbon::now()->toDateTimeString();
        $salary_slip->ss_day_end_id = $day_end->de_id;
        $salary_slip->ss_day_end_date = $day_end->de_datetime;
        $salary_slip->ss_created_by = $user->user_id;
        $salary_slip->ss_brwsr_info = $brwsr_rslt;
        $salary_slip->ss_ip_adrs = $ip_rslt;
        $salary_slip->ss_update_datetime = Carbon::now()->toDateTimeString();

        return $salary_slip;
    }

    public function salary_slip_voucher_items_values($values_array, $ss_id)
    {
        $data = [];
        foreach ($values_array as $value) {
            $data[] = [
                'ssi_voucher_id' => $ss_id,
                'ssi_account_id' => $value['account_code'],
                'ssi_account_name' => $value['account_name'],
                'ssi_allow_deduc' => $value['allowance_deduction'],
                'ssi_amount' => $value['account_amount'],
                'ssi_remarks' => $value['account_remarks'],
            ];
        }

        return $data;
    }

    // update code by shahzaib start
    public function salary_slip_voucher_list(Request $request, $array = null, $str = null)
    {

        $employees = User::orderby('user_name', 'ASC')->get();

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $search_employee = (isset($request->employee) && !empty($request->employee)) ? $request->employee : '';
        $prnt_page_dir = 'print.salary_slip_voucher_list . salary_slip_voucher_list';
        $pge_title = 'Salary Slip Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));


//        $query = SalarySlipVoucherModel::query();
        $query = DB::table('financials_salary_slip_voucher')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_salary_slip_voucher.ss_created_by');

        if (!empty($request->search)) {
            $query->where('ss_net_salary', 'like', ' % ' . $search . ' % ')
                ->orWhere('ss_remarks', 'like', ' % ' . $search . ' % ')
                ->orWhere('ss_id', 'like', ' % ' . $search . ' % ')
                ->orWhere('user_designation', 'like', ' % ' . $search . ' % ')
                ->orWhere('user_name', 'like', ' % ' . $search . ' % ')
                ->orWhere('user_username', 'like', ' % ' . $search . ' % ');
        }

        if (!empty($search_by_user)) {
            $query->where('ss_created_by', $search_by_user);
        }

        if (!empty($search_employee)) {
            $query->where('ss_user_id', $search_employee);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('ss_day_end_date', [$start, $end]);
            $query->whereDate('ss_day_end_date', ' >= ', $start)
                ->whereDate('ss_day_end_date', ' <= ', $end);
        } elseif (!empty($search_to)) {
            $query->where('ss_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('ss_day_end_date', $end);
        }


        $datas = $query->orderBy('ss_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials . pdf_footer')->render();
            $header = view('print._partials . pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = [
                'footer - html' => $footer,
                'header - html' => $header,
            ];

            $pdf = PDF::loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x . pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x . pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x . xlsx');
            }

        } else {
            return view('salary_slip_voucher_list', compact('datas', 'search', 'search_to', 'search_from', 'search_by_user', 'employees', 'search_employee'));
        }

    }

    // update code by shahzaib end

    public function salary_slip_items_view_details(Request $request)
    {
        $items = SalarySlipVoucherItemsModel::where('ssi_salary_slip_voucher_id', $request->id)->get();

        return response()->json($items);
    }

    public function salary_slip_items_view_details_SH(Request $request)
    {

        $slry_slp = SalarySlipVoucherModel::where('ss_id', $request->id)->first();
        $emply = User::where('user_id', $slry_slp->ss_user_id)->first();
        $items = SalarySlipVoucherItemsModel::where('ssi_voucher_id', $request->id)->get();
        $nbrOfWrds = $this->myCnvrtNbr($slry_slp->ss_net_salary);
        $invoice_nbr = $slry_slp->ss_id;
//        $invoice_date = $slry_slp->ss_current_datetime;
        $invoice_date = $slry_slp->ss_day_end_date;
        $invoice_remarks = $slry_slp->ss_remarks;
        $type = 'grid';
        $pge_title = 'Salary Slip Voucher';

        return view('voucher_view.salary_slip_voucher.salary_slip_voucher_list_modal', compact('items', 'slry_slp', 'emply', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title', 'invoice_remarks'));

    }

    public function salary_slip_items_view_details_pdf_SH(Request $request)
    {

        $slry_slp = SalarySlipVoucherModel::where('ss_id', $request->id)->first();
        $emply = User::where('user_id', $slry_slp->ss_user_id)->first();
        $items = SalarySlipVoucherItemsModel::where('ssi_voucher_id', $request->id)->get();
        $nbrOfWrds = $this->myCnvrtNbr($slry_slp->ss_net_salary);
        $invoice_nbr = $slry_slp->ss_id;
//        $invoice_date = $slry_slp->ss_current_datetime;
        $invoice_date = $slry_slp->ss_day_end_date;
        $invoice_remarks = $slry_slp->ss_remarks;
        $type = 'pdf';
        $pge_title = 'Salary Slip Voucher';


        $footer = view('voucher_view._partials.pdf_footer')->render();
        $header = view('voucher_view._partials.pdf_header', compact('invoice_nbr', 'invoice_date', 'pge_title', 'type', 'invoice_remarks'))->render();
        $options = [
            'footer-html' => $footer,
            'header-html' => $header,
            'margin-top' => 30,
        ];

        $pdf = PDF::loadView('voucher_view.salary_slip_voucher.salary_slip_voucher_list_modal', compact('items', 'slry_slp', 'emply', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));
        $pdf->setOptions($options);


        return $pdf->stream('Salary-Slip-Voucher-Detail.pdf');

    }

}
