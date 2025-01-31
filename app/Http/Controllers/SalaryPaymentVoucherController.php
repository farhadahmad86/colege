<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\JournalVoucherModel;
use App\Models\SalaryInfoModel;
use App\Models\SalaryPaymentVoucherItemsModel;
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
use NumberToWords\NumberToWords;

class SalaryPaymentVoucherController extends Controller
{
    public function salary_payment_voucher()
    {
//        $heads = explode(',', config('global_variables.payable_receivable_cash_bank'));
////        $accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)->orderBy('account_uid', 'ASC')->get();
//        $accounts = $this->get_fourth_level_account($heads, 0, 1);

        $accounts = $this->get_account_query('salary_payment_voucher')[0];

        $employees = User::orderBy('user_name', 'ASC')->get();
        foreach ($employees as $employee) {
            $net_salary = SalarySlipVoucherModel::where('ss_user_id', $employee->user_id)->orderBy('ss_id', 'DESC')->pluck('ss_net_salary')->first();
            if (empty($net_salary)) {
                $net_salary = 0;
            }

            $employee['net_salary'] = $net_salary;
            $new_employees[] = $employee;
        }

        return view('salary_payment_voucher', compact('accounts', 'new_employees'));
    }

    public function submit_salary_payment_voucher(Request $request)
    {

        $this->salary_payment_voucher_validation($request);

        $values_array = json_decode($request->accountsval, true);

        $rollBack = false;

        $notes = 'SALARY_PAYMENT_VOUCHER';

        $voucher_code = config('global_variables.SALARY_PAYMENT_VOUCHER_CODE');

        $transaction_type = config('global_variables.SALARY_PAYMENT');

        DB::beginTransaction();

        $salary_payment = new SalaryPaymentVoucherModel();

        $salary_payment = $this->assign_salary_payment_voucher_values($request, $salary_payment);


        // system config set increment default id according to user giving start coding
        $sstm_cnfg_clm = 'sc_salary_payment_voucher_number';
        $sstm_cnfg_bp_id_chk = SystemConfigModel::where($sstm_cnfg_clm, '!=', '0')->first();
        $chk_bnk_pymnt = SalaryPaymentVoucherModel::all();
        if ($chk_bnk_pymnt->isEmpty()):
            if (isset($sstm_cnfg_bp_id_chk) && !empty($sstm_cnfg_bp_id_chk)):
                $salary_payment->sp_id = $sstm_cnfg_bp_id_chk->$sstm_cnfg_clm;
            endif;
        endif;
        // system config set increment default id according to user giving end coding


        if ($salary_payment->save()) {
            $salary_payment_id = $salary_payment->sp_id;
        }


        $items = [];
        $detail_remarks = '';

        $item = $this->salary_payment_voucher_items_values($request, $items, $salary_payment_id);

        foreach ($item as $value) {

            $spi_deduct_amount = (float)$value['spi_deduct_amount'];
            $spi_amount = (float)$value['spi_amount'];

            $remaining_total_amount = $spi_amount - $spi_deduct_amount;

            if ($spi_deduct_amount != 0) {
                $advance_account_remarks = ', After Advance Deduction of : ' . number_format($spi_deduct_amount, 2);
            } else {
                $advance_account_remarks = '';
            }

            $detail_remarks .= $request->account_name_text . ' to ' . $value['spi_account_name'] . ', @' . number_format($remaining_total_amount, 2) . $advance_account_remarks . config('global_variables.Line_Break');
        }

        if (!DB::table('financials_salary_payment_voucher_items')->insert($item)) {
            $rollBack = true;
        }

        $salary_payment->sp_detail_remarks = $detail_remarks;

        if (!$salary_payment->save()) {
            $rollBack = true;
        }

        $transaction = new TransactionModel();

        $transaction = $this->AssignTransactionsValues($transaction, 0, $request->total_amount, $request->account, $notes, $transaction_type, $salary_payment_id);
        if ($transaction->save()) {

            $transaction_id = $transaction->trans_id;

            $balances = new BalancesModel();

            $balances = $this->AssignAccountBalancesValues($balances, $transaction_id, $request->account, $request->total_amount, 'Cr', $request->remarks, $notes, $detail_remarks, $voucher_code .
                $salary_payment_id,'');

            if (!$balances->save()) {
                $rollBack = true;
            }
        } else {
            $rollBack = true;
        }

        foreach ($values_array as $key) {

            $account_code = SalaryInfoModel::where('si_user_id', $key['account_code'])->pluck('si_advance_salary_account_uid')->first();
            $account_name = $this->get_account_name($account_code);
            $account_amount = $key['amount'];
            $account_amount_deduct = $key['deduct_amount'];
            $remaining_amount = $account_amount - $account_amount_deduct;

            $item_remarks = $request->account_name_text . ' to ' . $account_name . ', @' . $remaining_amount;

            $transaction = new TransactionModel();
            $transaction = $this->AssignTransactionsValues($transaction, $account_code, $remaining_amount, 0, $notes, $transaction_type, $salary_payment_id);

            if ($transaction->save()) {

                $transaction_id = $transaction->trans_id;

                $balances = new BalancesModel();

                $balances = $this->AssignAccountBalancesValues($balances, $transaction_id, $account_code, $remaining_amount, 'Dr', $request->remarks, $notes, $item_remarks, $voucher_code .
                    $salary_payment_id,'');

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
            return redirect()->back()->with( ['salary_payment_id'=>$salary_payment_id, 'success'=>'Successfully Saved'] );
        }
    }

    public function salary_payment_voucher_validation($request)
    {
        return $this->validate($request, [
            'account' => ['required', 'numeric'],
            'account_name_text' => ['required', 'string'],
            'remarks' => ['nullable', 'string'],
            'total_amount' => ['required', 'numeric'],
            'accountsval' => ['required', 'string'],
        ]);

    }

    public function assign_salary_payment_voucher_values($request, $ep)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $ep->sp_session = $request->session;
        $ep->sp_business_name = $request->business_name;
        $ep->sp_account_id = $request->account;
        $ep->sp_remarks = ucfirst($request->remarks);
        $ep->sp_total_amount = $request->total_amount;
        $ep->sp_created_datetime = Carbon::now()->toDateTimeString();
        $ep->sp_day_end_id = $day_end->de_id;
        $ep->sp_day_end_date = $day_end->de_datetime;
        $ep->sp_createdby = $user->user_id;

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

    public function salary_payment_voucher_items_values($request, $data, $sp_id)
    {
        $accountsval = json_decode($request->accountsval, true);

        // coding from shahzaib start
        $prfx = 'spi';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';
        // coding from shahzaib end


        foreach ($accountsval as $key) {

            $data[] = [
                'spi_salary_payment_voucher_id' => $sp_id,
                'spi_account_id' => $key['account_code'],
                'spi_account_name' => $key['account_name'],
                'spi_amount' => $key['amount'],
                'spi_remarks' => ucfirst($key['account_remarks']),
                'spi_deduct_amount' => $key['deduct_amount'],
                $brwsr_col => $brwsr_rslt,
                $ip_col => $ip_rslt,
                $updt_date_col => Carbon::now()->toDateTimeString()
            ];
        }

        return $data;
    }

    // update code by shahzaib start
    public function salary_payment_voucher_list(Request $request, $array = null, $str = null)
    {
        $heads = explode(',', config('global_variables.payable_receivable_cash_bank'));
        $accounts = $this->get_fourth_level_account($heads, 0, 1);

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $search_account = (isset($request->account) && !empty($request->account)) ? $request->account : '';
        $prnt_page_dir = 'print.salary_payment_voucher_list.salary_payment_voucher_list';
        $pge_title = 'Salary Payment Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));


//        $query = SalaryPaymentVoucherModel::query();
        $query = DB::table('financials_salary_payment_voucher')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_salary_payment_voucher.sp_createdby');
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
            $query->where('ss_createdby', $search_by_user);
        }

        if (!empty($search_account)) {
            $query->where('sp_account_id', $search_account);
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
            return view('salary_payment_voucher_list', compact('datas', 'search', 'search_to', 'search_from', 'ttl_amnt', 'search_by_user', 'accounts', 'search_account'));
        }

    }

    // update code by shahzaib end

    public function salary_payment_items_view_details(Request $request)
    {
        $items = SalaryPaymentVoucherItemsModel::where('spi_salary_payment_voucher_id', $request->id)->orderby('spi_account_name', 'ASC')->get();

        return response()->json($items);
    }

    public function salary_payment_items_view_details_SH(Request $request, $id)
    {

        $slry_pmnt = SalaryPaymentVoucherModel::where('sp_id', $id)->first();
        $items = SalaryPaymentVoucherItemsModel::where('spi_salary_payment_voucher_id', $id)->orderby('spi_account_name', 'ASC')->get();
        $sp_acnt_nme = AccountRegisterationModel::where('account_uid', $slry_pmnt->sp_account_id)->first();
        $nbrOfWrds = $this->myCnvrtNbr($slry_pmnt->sp_total_amount);
        $invoice_nbr = $slry_pmnt->sp_id;
//        $invoice_date = $slry_pmnt->sp_created_datetime;
        $invoice_date = $slry_pmnt->sp_day_end_date;
        $invoice_remarks = $slry_pmnt->sp_remarks;
        $type = 'grid';
        $pge_title = 'Salary Payment Voucher';


        return view('voucher_view.salary_payment_voucher.salary_payment_journal_voucher_list_modal', compact('items', 'slry_pmnt', 'sp_acnt_nme', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));

    }

    public function salary_payment_items_view_details_pdf_SH(Request $request, $id)
    {

        $slry_pmnt = SalaryPaymentVoucherModel::where('sp_id', $id)->first();
        $items = SalaryPaymentVoucherItemsModel::where('spi_salary_payment_voucher_id', $id)->orderby('spi_account_name', 'ASC')->get();
        $sp_acnt_nme = AccountRegisterationModel::where('account_uid', $slry_pmnt->sp_account_id)->first();
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

        $pdf = PDF::loadView('voucher_view.salary_payment_voucher.salary_payment_journal_voucher_list_modal', compact('items', 'slry_pmnt', 'sp_acnt_nme', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));
        $pdf->setOptions($options);


        return $pdf->stream('Salary-Payment-Voucher-Detail.pdf');

    }

    public function salary_payment_items_view_details_single_pdf_SH(Request $request, $id)
    {

//        $slry_pmnt = SalaryPaymentVoucherModel::where('sp_id', $request->id)->first();
//        $items = SalaryPaymentVoucherItemsModel::where('spi_salary_payment_voucher_id', $request->id)->orderby('spi_account_name', 'ASC')->get();
//        $sp_acnt_nme = AccountRegisterationModel::where('account_uid', $slry_pmnt->sp_account_id)->first();
//        $nbrOfWrds = $this->myCnvrtNbr($slry_pmnt->sp_total_amount);
//
//        $pdf = PDF::loadView('voucher_view.salary_payment_voucher.salary_payment_journal_voucher_double_entry_list_pdf', compact('items', 'slry_pmnt', 'sp_acnt_nme', 'nbrOfWrds'));
//        return $pdf->stream('Salary-Payment-Voucher-Detail.pdf');


        $slry_pmnt = SalaryPaymentVoucherModel::where('sp_id', $id)->first();
        $items = SalaryPaymentVoucherItemsModel::where('spi_salary_payment_voucher_id', $id)->orderby('spi_account_name', 'ASC')->get();
        $sp_acnt_nme = AccountRegisterationModel::where('account_uid', $slry_pmnt->sp_account_id)->first();
        $nbrOfWrds = $this->myCnvrtNbr($slry_pmnt->sp_total_amount);
        $invoice_nbr = $slry_pmnt->sp_id;
        $invoice_date = $slry_pmnt->sp_created_datetime;
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

        $pdf = PDF::loadView('voucher_view.salary_payment_voucher.salary_payment_journal_voucher_double_entry_list_modal', compact('items', 'slry_pmnt', 'sp_acnt_nme', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));
        $pdf->setOptions($options);


        return $pdf->stream('Salary-Payment-Voucher-Detail.pdf');


    }


}
