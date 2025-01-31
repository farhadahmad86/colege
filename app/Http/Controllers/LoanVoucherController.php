<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\LoanVoucherItemsModel;
use App\Models\LoanVoucherModel;
use App\Models\SystemConfigModel;
use App\Models\TransactionModel;
use App\User;
use Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LoanVoucherController extends Controller
{
    public function loan_voucher()
    {
        $user = Auth::user();
        $loan_accounts = DB::table("financials_accounts")
            ->where('account_clg_id', $user->user_clg_id)
            ->where('account_parent_code', 11019)
            ->select("account_uid", "account_name",
                DB::raw("(SELECT SUM(financials_balances.bal_dr) FROM financials_balances
                                WHERE financials_balances.bal_account_id = financials_accounts.account_uid
                                and financials_balances.bal_clg_id = $user->user_clg_id
                                GROUP BY financials_balances.bal_account_id) as balance"),
                DB::raw("(SELECT SUM(financials_loan.loan_total_amount) FROM financials_loan
                                WHERE financials_loan.loan_account_id = financials_accounts.account_uid
                                and financials_loan.loan_clg_id = $user->user_clg_id
                                and financials_loan.loan_status = 'Approved'
                                GROUP BY financials_loan.loan_account_id) as approved_loan_amount"))
            ->get();

        $accounts_head = explode(',', config('global_variables.cash') . ',' . config('global_variables.bank_head') . ',' . config('global_variables.payable') . ',' . 51010);

        $accounts = AccountRegisterationModel::whereIn('account_parent_code', $accounts_head)->where('account_clg_id', $user->user_clg_id)->select('account_uid', 'account_name')->get();
        return view('loan_voucher.loan_voucher', compact('accounts', 'loan_accounts'));
    }

    public function submit_loan_voucher(Request $request)
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

        $notes = 'LOAN_VOUCHER';
        $voucher_code = config('global_variables.LOAN_VOUCHER_CODE');
        $transaction_type = config('global_variables.LOAN');

        DB::beginTransaction();

        $lv = new LoanVoucherModel();
        $lv_v_no = LoanVoucherModel::where('lv_clg_id', $user->user_clg_id)->count();

        $lv = $this->assign_voucher_values('lv', $lv_v_no + 1, $lv, $account_uid, $total_voucher_amount, $voucher_remarks, $user, $day_end, $status);

        // system config set increment default id according to user giving start coding
        $sstm_cnfg_clm = 'sc_loan_voucher_number';
        $sstm_cnfg_bp_id_chk = SystemConfigModel::where('sc_clg_id', '=', $user->user_clg_id)->where($sstm_cnfg_clm, '!=', '0')->first();
        $chk_bnk_pymnt = LoanVoucherModel::where('lv_clg_id', $user->user_clg_id)->get();
        if ($chk_bnk_pymnt->isEmpty()):
            if (isset($sstm_cnfg_bp_id_chk) && !empty($sstm_cnfg_bp_id_chk)):
                $lv->lv_id = $sstm_cnfg_bp_id_chk->$sstm_cnfg_clm;
            endif;
        endif;
        // system config set increment default id according to user giving end coding


        if ($lv->save()) {
            $lv_id = $lv->lv_id;
            $lv_voucher_no = $lv->lv_v_no;
        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }

        $detail_remarks = '';

        $item = $this->voucher_items_values($accountsval, $lv_id, $lv_voucher_no, 'lvi');

        foreach ($item as $value) {
            $lvi_amount = (float)$value['lvi_amount'];

            $detail_remarks .= $value['lvi_account_name'] . ' to ' . $account_name_text . ', @' . number_format($lvi_amount, 2) . config('global_variables.Line_Break');
        }

        if (!DB::table('financials_loan_voucher_items')->insert($item)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }


        $lv->lv_detail_remarks = $detail_remarks;
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

                $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key['account_code'], $key['account_amount'], 'Cr', $key['account_remarks'],
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

                $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id, $account_uid, $key['account_amount'], 'Dr', $key['account_remarks'],
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
//        }

        if ($rollBack) {

            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        } else {
            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $lv->lv_id);
            DB::commit();
            return redirect()->back()->with(['lv_id' => $lv_id, 'success' => 'Successfully Saved']);
        }
    }

    // update code by shahzaib start
    public function loan_voucher_list(Request $request, $array = null, $str = null)
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

        $prnt_page_dir = 'print.loan_voucher_list.loan_voucher_list';
        $pge_title = 'Loan Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from, $search_loan_account, $search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $user = Auth::user();
//        $query = CashReceiptVoucherModel::query();
        $query = DB::table('financials_loan_voucher')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_loan_voucher.lv_createdby')
            ->where('lv_clg_id', $user->user_clg_id);
        $ttl_amnt = $query->sum('lv_total_amount');


        if (!empty($request->search)) {
            $query->where('lv_total_amount', 'like', '%' . $search . '%')
                ->orWhere('lv_remarks', 'like', '%' . $search . '%')
                ->orWhere('lv_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('lv_createdby', $search_by_user);
        }

        if (!empty($search_loan_account)) {
            $query->where('lv_account_id', $search_loan_account);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereDate('lv_day_end_date', '>=', $start)
                ->whereDate('lv_day_end_date', '<=', $end);

        } elseif (!empty($search_to)) {
            $query->where('lv_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('lv_day_end_date', $end);
        }

        if (!empty($search_year)) {
            $query->where('lv_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('lv_year_id', '=', $search_year);
        }
        $datas = $query->orderBy('lv_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

//        if (isset($request->search) && !empty($request->search)) {
//
//            $search = $request->search;
//
//            $vouchers = CashReceiptVoucherModel::
//            orWhere('cr_total_amount', 'like', '%' . $search . '%')
//                ->orWhere('cr_remarks', 'like', '%' . $search . '%')
//                ->orWhere('cr_id', 'like', '%' . $search . '%')
//                ->orderBy('cr_id', 'DESC')
//                ->paginate(1000000);
//
//        } else {
//
//            $vouchers = CashReceiptVoucherModel::orderBy('cr_id', 'DESC')
//                ->paginate(10);
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
            return view('loan_voucher.loan_voucher_list', compact('datas', 'search', 'search_year', 'search_to', 'search_from', 'ttl_amnt', 'loan_accounts', 'search_loan_account'));
        }

    }

    // update code by shahzaib end

    public function loan_items_view_details(Request $request)
    {
        $items = LoanVoucherItemsModel::where('lvi_voucher_id', $request->id)->orderby('lvi_account_name', 'ASC')->get();

        return response()->json($items);
    }

    public function loan_items_view_details_SH(Request $request, $id)
    {

        $loan_rcpt = LoanVoucherModel::with('user')->where('lv_id', $id)->first();
        $items = LoanVoucherItemsModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_loan_voucher_items.lvi_pr_id')
            ->where('lvi_voucher_id', $id)->orderby('lvi_account_name', 'ASC')->get();
        $cr_acnt_nme = AccountRegisterationModel::where('account_uid', $loan_rcpt->lv_account_id)->first();
        $nbrOfWrds = $this->myCnvrtNbr($loan_rcpt->lv_total_amount);
        $invoice_nbr = $loan_rcpt->lv_id;
        $invoice_date = $loan_rcpt->lv_day_end_date;
        $invoice_remarks = $loan_rcpt->lv_remarks;
        $type = 'grid';
        $pge_title = 'Loan Voucher';

        return view('voucher_view.loan_voucher.loan_journal_voucher_list_modal', compact('items', 'loan_rcpt', 'nbrOfWrds', 'cr_acnt_nme', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'))->render();

    }

    public function loan_items_view_details_pdf_SH(Request $request, $id)
    {
        $loan_rcpt = LoanVoucherModel::with('user')->where('lv_id', $id)->first();
        $items = LoanVoucherItemsModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_loan_voucher_items.lvi_pr_id')->where
        ('lvi_voucher_id', $id)->orderby('lvi_account_name', 'ASC')->get();
        $cr_acnt_nme = AccountRegisterationModel::where('account_uid', $loan_rcpt->lv_account_id)->first();
        $nbrOfWrds = $this->myCnvrtNbr($loan_rcpt->lv_total_amount);
        $invoice_nbr = $loan_rcpt->lv_id;
//        $invoice_date = $loan_rcpt->cr_created_datetime;
        $invoice_date = $loan_rcpt->lv_day_end_date;
        $invoice_remarks = $loan_rcpt->lv_remarks;
        $type = 'pdf';
        $pge_title = 'Loan Voucher';


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
        $pdf->loadView('voucher_view.loan_voucher.loan_journal_voucher_list_modal', compact('items', 'loan_rcpt', 'nbrOfWrds', 'cr_acnt_nme', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type',
            'pge_title'));
        // $pdf->setOptions($options);


        return $pdf->stream('Loan-Voucher-Detail.pdf');

    }
}
