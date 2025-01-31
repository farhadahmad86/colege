<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\LoanModel;
use App\Models\LoanReceiptModel;
use App\Models\SystemConfigModel;
use App\Models\TransactionModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use PDF;

class LoanReceiptVoucherController extends Controller
{
    public function loan_receipt_voucher()
    {
        $user = Auth::user();
        $loan_accounts = LoanModel::where('loan_clg_id', $user->user_clg_id)->where('loan_status', '=', 'Approved')->where('loan_paid_status', '=', 1)->where('loan_remaining_amount', '>', 0)
            ->leftJoin('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_loan.loan_account_id')
            ->select('financials_loan.*', 'financials_accounts.account_name', 'financials_accounts.account_uid')->get();


        $accounts_head = explode(',', config('global_variables.cash') . ',' . config('global_variables.bank_head') . ',' . config('global_variables.payable') . ',' . 51010);

        $accounts = AccountRegisterationModel::whereIn('account_parent_code', $accounts_head)->where('account_clg_id', $user->user_clg_id)->select('account_uid', 'account_name')->get();
        return view('loan_voucher.loan_receipt_voucher', compact('accounts', 'loan_accounts'));
    }

    public function submit_loan_receipt_voucher(Request $request)
    {

        $this->voucher_validation($request);

        $rollBack = false;

        $user = Auth::user();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $accountsval = json_decode($request->accountsval, true);

        $account_uid = $request->account;
        $account_name_text = $request->account_name_text;
        $total_voucher_amount = $request->total_amount;
        $voucher_remarks = $request->remarks;
        $status = $request->status;

        $notes = 'LOAN_RECEIPT_VOUCHER';
        $voucher_code = config('global_variables.LOAN_RECEIPT_VOUCHER_CODE');
        $transaction_type = config('global_variables.LOAN_RECEIPT');

        DB::beginTransaction();
        $loanUpdate = LoanModel::where('loan_id', '=', $request->loan_id)->first();
        if ($loanUpdate->loan_remaining_amount >= $total_voucher_amount) {

            $lv = new LoanReceiptModel();
            $lv_v_no = LoanReceiptModel::where('lrv_clg_id', $user->user_clg_id)->count();

            $lv = $this->assign_loan_receipt_voucher_values('lrv', $lv_v_no + 1, $lv, $account_uid, $total_voucher_amount, $voucher_remarks, $user, $day_end, $request->accountsval, $status);

            // system config set increment default id according to user giving start coding
            $sstm_cnfg_clm = 'sc_loan_voucher_number';
            $sstm_cnfg_bp_id_chk = SystemConfigModel::where('sc_clg_id', '=', $user->user_clg_id)->where($sstm_cnfg_clm, '!=', '0')->first();
            $chk_bnk_pymnt = LoanReceiptModel::where('lrv_clg_id', $user->user_clg_id)->get();
            if ($chk_bnk_pymnt->isEmpty()):
                if (isset($sstm_cnfg_bp_id_chk) && !empty($sstm_cnfg_bp_id_chk)):
                    $lv->lv_id = $sstm_cnfg_bp_id_chk->$sstm_cnfg_clm;
                endif;
            endif;
            // system config set increment default id according to user giving end coding


            if ($lv->save()) {
                $lv_id = $lv->lrv_id;
                $lv_voucher_no = $lv->lrv_v_no;
            } else {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed');
            }

            $detail_remarks = '';

//        $item = $this->voucher_items_values($accountsval, $lv_id, $lv_voucher_no,'lvi');

            foreach ($accountsval as $key) {
                $lvi_amount = (float)$key['account_amount'];

                $detail_remarks .= $key['account_name'] . ' to ' . $account_name_text . ', @' . number_format($lvi_amount, 2) . config('global_variables.Line_Break');
            }

//        if (!DB::table('financials_loan_voucher_items')->insert($item)) {
//            $rollBack = true;
//            DB::rollBack();
//            return redirect()->back()->with('fail', 'Failed');
//        }


            $lv->lrv_detail_remarks = $detail_remarks;
            if (!$lv->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed');
            }
//        if ($status == 'post') {
            foreach ($accountsval as $key) {

                $transaction = new TransactionModel();

                $transaction = $this->AssignTransactionsValues($transaction, $account_uid, $key['account_amount'], $key['account_code'], $notes, $transaction_type, $lv_id);

                if ($transaction->save()) {

                    $transaction_id = $transaction->trans_id;

                    // Selected Accounts
                    $branch_id = $this->get_branch_id($key['account_code']);
                    $balances = new BalancesModel();

                    $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key['account_code'], $key['account_amount'], 'Dr', $key['account_remarks'],
                        $notes, $key['account_name'] . ' to ' . $account_name_text . ', @' . number_format($key['account_amount'], 2) . config('global_variables.Line_Break'), $voucher_code .
                        $lv_id,
                        $key['posting_reference'], $voucher_code . $lv_voucher_no, $this->getYearEndId(), $branch_id);

                    if (!$balance->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed');
                    }

                    // Bank Account
                    $branch_id = $this->get_branch_id($account_uid);
                    $balances2 = new BalancesModel();

                    $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id, $account_uid, $key['account_amount'], 'Cr', $key['account_remarks'],
                        $notes, $key['account_name'] . ' to ' . $account_name_text . ', @' . number_format($key['account_amount'], 2) . config('global_variables.Line_Break'), $voucher_code . $lv_id,
                        $key['posting_reference'], $voucher_code . $lv_voucher_no, $this->getYearEndId(), $branch_id);

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
            if ($rollBack == false) {
                $remaining_amount = $loanUpdate->loan_remaining_amount - $total_voucher_amount;
                if ($remaining_amount == 0) {
                    $loanUpdate->loan_remaining_amount = $remaining_amount;
                    $loanUpdate->loan_paid_status = 2;
                } else {
                    $new_installment_amount = $remaining_amount / $loanUpdate->loan_remaining_installment;
                    $loanUpdate->loan_remaining_amount = $remaining_amount;
                    $loanUpdate->loan_instalment_amount = $new_installment_amount;
                }

                $loanUpdate->save();
            }

//        }

            if ($rollBack) {

                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $lv->lv_id);
                DB::commit();
                return redirect()->back()->with(['lrv_id' => $lv_id, 'success' => 'Successfully Saved']);
            }
        } else {
            return redirect()->back()->with('error', 'Loan amount less then voucher amount! try again');
        }
    }

    // update code by mustafa start
    public function loan_receipt_voucher_list(Request $request, $array = null, $str = null)
    {
        $loan_accounts = AccountRegisterationModel::where('account_parent_code', 11019)
            ->get();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_loan_account = (!isset($request->loan_account) && empty($request->loan_account)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->loan_account;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';

        $prnt_page_dir = 'print.loan_voucher_list.loan_receipt_voucher_list';
        $pge_title = 'Loan Receipt Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from, $search_loan_account, $search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $user = Auth::user();
//        $query = CashReceiptVoucherModel::query();
        $query = DB::table('financials_loan_receipt_voucher')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_loan_receipt_voucher.lrv_createdby')
            ->where('lrv_clg_id', $user->user_clg_id);
        $ttl_amnt = $query->sum('lrv_total_amount');


        if (!empty($request->search)) {
            $query->where('lrv_total_amount', 'like', '%' . $search . '%')
                ->orWhere('lrv_remarks', 'like', '%' . $search . '%')
                ->orWhere('lrv_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('lrv_createdby', $search_by_user);
        }

        if (!empty($search_loan_account)) {
            $query->where('lrv_account_id', $search_loan_account);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereDate('lrv_day_end_date', '>=', $start)
                ->whereDate('lrv_day_end_date', '<=', $end);

        } elseif (!empty($search_to)) {
            $query->where('lrv_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('lrv_day_end_date', $end);
        }
        if (!empty($search_year)) {
            $query->where('lrv_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('lrv_year_id', '=', $search_year);
        }

        $datas = $query->orderBy('lrv_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

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
            $pdf->loadView($prnt_page_dir, compact('srch_fltr', 'datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $search_year, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('loan_voucher.loan_receipt_voucher_list', compact('datas', 'search', 'search_year', 'search_to', 'search_from', 'ttl_amnt', 'loan_accounts', 'search_loan_account'));
        }

    }

    // update code by mustafa end

    public function loan_receipt_items_view_details(Request $request)
    {
        $items = LoanReceiptModel::where('lrv_voucher_id', $request->id)->orderby('lv_account_id', 'ASC')->get();

        return response()->json($items);
    }

    public function loan_receipt_items_view_details_SH(Request $request, $id)
    {

        $loan_rcpt = LoanReceiptModel::with('user')->where('lrv_id', $id)->first();
        $items = json_decode($loan_rcpt->lrv_items);
        $cr_acnt_nme = AccountRegisterationModel::where('account_uid', $loan_rcpt->lrv_account_id)->first();
        $nbrOfWrds = $this->myCnvrtNbr($loan_rcpt->lrv_total_amount);
        $invoice_nbr = $loan_rcpt->lrv_id;
        $invoice_date = $loan_rcpt->lrv_day_end_date;
        $invoice_remarks = $loan_rcpt->lrv_remarks;
        $type = 'grid';
        $pge_title = 'Loan Receipt Voucher';

        return view('voucher_view.loan_voucher.loan_receipt_voucher_list_modal', compact('items', 'loan_rcpt', 'nbrOfWrds', 'cr_acnt_nme', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'))->render();

    }

    public function loan_receipt_items_view_details_pdf_SH(Request $request, $id)
    {
        $loan_rcpt = LoanReceiptModel::with('user')->where('lrv_id', $id)->first();
        $items = json_decode($loan_rcpt->lrv_items);
        $cr_acnt_nme = AccountRegisterationModel::where('account_uid', $loan_rcpt->lrv_account_id)->first();
        $nbrOfWrds = $this->myCnvrtNbr($loan_rcpt->lrv_total_amount);
        $invoice_nbr = $loan_rcpt->lrv_id;
//        $invoice_date = $loan_rcpt->cr_created_datetime;
        $invoice_date = $loan_rcpt->lrv_day_end_date;
        $invoice_remarks = $loan_rcpt->lrv_remarks;
        $type = 'pdf';
        $pge_title = 'Loan Receipt Voucher';

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
        $pdf->loadView('voucher_view.loan_voucher.loan_receipt_voucher_list_modal', compact('items', 'loan_rcpt', 'nbrOfWrds', 'cr_acnt_nme', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type',
            'pge_title'));
        // $pdf->setOptions($options);


        return $pdf->stream('Loan-Voucher-Detail.pdf');

    }

    public function assign_loan_receipt_voucher_values($prfx, $voucher_number, $voucher, $account_uid, $total_voucher_amount, $voucher_remarks, $user, $day_end, $accountsval, $status, $voucher_type
    = 0)
    {

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $v_no = $prfx . '_v_no';
        $account_id = $prfx . '_account_id';
        $total_amount = $prfx . '_total_amount';
        $bank_amount = $prfx . '_bank_amount';
        $remarks = $prfx . '_remarks';
        $created_datetime = $prfx . '_created_datetime';
        $day_end_id = $prfx . '_day_end_id';
        $day_end_date = $prfx . '_day_end_date';
        $createdby = $prfx . '_createdby';
        $clg_id = $prfx . '_clg_id';
        $branch_id = $prfx . '_branch_id';
        $brwsr_info = $prfx . '_brwsr_info';
        $ip_adrs = $prfx . '_ip_adrs';
        $v_status = $prfx . '_status';
        $posted_by = $prfx . '_posted_by';
        $v_items = $prfx . '_items';
        $year_id = $prfx . '_year_id';


        $voucher->$v_no = $voucher_number;
        $voucher->$account_id = $account_uid;
        $voucher->$total_amount = $total_voucher_amount;
        $voucher->$remarks = $voucher_remarks;
        $voucher->$created_datetime = Carbon::now()->toDateTimeString();
        $voucher->$day_end_id = $day_end->de_id;
        $voucher->$day_end_date = $day_end->de_datetime;
        $voucher->$createdby = $user->user_id;
        $voucher->$clg_id = $user->user_clg_id;
        $voucher->$branch_id = Session::get('branch_id');
        $voucher->$brwsr_info = $brwsr_rslt;
        $voucher->$ip_adrs = $ip_rslt;
        $voucher->$v_status = $status;
        $voucher->$v_items = $accountsval;
        $voucher->$year_id = $this->getYearEndId();

        if ($status == 'post') {
            $voucher->$posted_by = $user->user_id;
        }

        if ($voucher_type == 1) {

            $voucher->$bank_amount = $total_voucher_amount;
        }

        return $voucher;
    }
}
