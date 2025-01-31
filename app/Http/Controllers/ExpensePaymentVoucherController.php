<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\BankPaymentVoucherItemsModel;
use App\Models\BankPaymentVoucherModel;
use App\Models\CashPaymentVoucherItemsModel;
use App\Models\CashReceiptVoucherModel;
use App\Models\ExpensePaymentVoucherItemsModel;
use App\Models\ExpensePaymentVoucherModel;
use App\Models\JournalVoucherModel;
use App\Models\PostingReferenceModel;
use App\Models\SalaryPaymentVoucherItemsModel;
use App\Models\SalaryPaymentVoucherModel;
use App\Models\SystemConfigModel;
use App\Models\TransactionModel;
use Auth;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class ExpensePaymentVoucherController extends Controller
{
    public function expense_payment_voucher()
    {
        return view('expense_payment_voucher');
    }

    public function submit_expense_payment_voucher(Request $request)
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

        $notes = 'EXPENSE_PAYMENT_VOUCHER';
        $voucher_code = config('global_variables.EXPENSE_PAYMENT_VOUCHER_CODE');
        $transaction_type = config('global_variables.EXPENSE_PAYMENT');

        DB::beginTransaction();

        $ep = new ExpensePaymentVoucherModel();
        $ep_v_no = ExpensePaymentVoucherModel::where('ep_clg_id',$user->user_clg_id)->max('ep_v_no');

        $ep = $this->assign_voucher_values('ep', $ep_v_no + 1, $ep, $account_uid, $total_voucher_amount, $voucher_remarks, $user, $day_end, $status);


        // system config set increment default id according to user giving start coding
        $sstm_cnfg_clm = 'sc_expense_payment_voucher_number';
        $sstm_cnfg_bp_id_chk = SystemConfigModel::where($sstm_cnfg_clm, '!=', '0')->first();
        $chk_bnk_pymnt = ExpensePaymentVoucherModel::all();
        if ($chk_bnk_pymnt->isEmpty()):
            if (isset($sstm_cnfg_bp_id_chk) && !empty($sstm_cnfg_bp_id_chk)):
                $ep->ep_id = $sstm_cnfg_bp_id_chk->$sstm_cnfg_clm;
            endif;
        endif;
        // system config set increment default id according to user giving end coding


        if ($ep->save()) {
            $ep_id = $ep->ep_id;
            $ep_voucher_no = $ep->ep_v_no;
        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }

        $detail_remarks = '';

        $item = $this->voucher_items_values($accountsval, $ep_id, $ep_voucher_no, 'epi');

        foreach ($item as $value) {
            $epi_amount = (float)$value['epi_amount'];

            $detail_remarks .= $value['epi_account_name'] . ', @' . number_format($epi_amount, 2) . config('global_variables.Line_Break');
        }

        if (!DB::table('financials_expense_payment_voucher_items')->insert($item)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }


        $ep->ep_detail_remarks = $detail_remarks;
        if (!$ep->save()) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }
        if ($status == 'post') {
            foreach ($accountsval as $key) {

                $transaction = new TransactionModel();

                $transaction = $this->AssignTransactionsValues($transaction, $key['account_code'], $key['account_amount'], $account_uid, $notes, $transaction_type, $ep_id);

                if ($transaction->save()) {

                    $transaction_id = $transaction->trans_id;

                    // Selected Accounts
                    $branch_id = $this->get_branch_id($key['account_code']);
                    $balances = new BalancesModel();

                    $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key['account_code'], $key['account_amount'], 'Dr', $key['account_remarks'],
                        $notes, $account_name_text . ' to ' . $key['account_name'] . ', @' . number_format($key['account_amount'], 2) . config('global_variables.Line_Break'), $voucher_code . $ep_id,
                        $key['posting_reference'], $voucher_code . $ep_voucher_no,$this->getYearEndId(), $branch_id);

                    if (!$balance->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed');
                    }

                    // Bank Account
                    $branch_id = $this->get_branch_id($account_uid);
                    $balances2 = new BalancesModel();

                    $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id, $account_uid, $key['account_amount'], 'Cr', $key['account_remarks'],
                        $notes, $account_name_text . ' to ' . $key['account_name'] . ', @' . number_format($key['account_amount'], 2) . config('global_variables.Line_Break'), $voucher_code .
                        $ep_id, $key['posting_reference'],$voucher_code . $ep_voucher_no, $this->getYearEndId(),$branch_id);

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
        }

        if ($rollBack) {

            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        } else {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $ep->be_id);
            DB::commit();
            return redirect()->back()->with(['ep_id' => $ep_id, 'success' => 'Successfully Saved']);
        }
    }

    // update code by shahzaib start
    public function expense_payment_voucher_list(Request $request, $array = null, $str = null)
    {
        $accounts = $this->get_fourth_level_account(config('global_variables.expense'), 3, 0);

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $search_account = (isset($request->account) && !empty($request->account)) ? $request->account : '';
        $prnt_page_dir = 'print.expense_payment_voucher_list.expense_payment_voucher_list';
        $pge_title = 'Expense Payment Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from,$search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $user= Auth::user();
//        $query = ExpensePaymentVoucherModel::query();
        $query = DB::table('financials_expense_payment_voucher')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_expense_payment_voucher.ep_createdby')
            ->where('ep_clg_id',$user->user_clg_id);

        $ttl_amnt = $query->sum('ep_total_amount');

        if (!empty($request->search)) {
            $query->where('ep_total_amount', 'like', '%' . $search . '%')
                ->orWhere('ep_remarks', 'like', '%' . $search . '%')
                ->orWhere('ep_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('ep_createdby', $search_by_user);
        }

        if (!empty($search_account)) {
            $query->where('ep_account_id', $search_account);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('ep_day_end_date', [$start, $end]);
            $query->whereDate('ep_day_end_date', '>=', $start)
                ->whereDate('ep_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('ep_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('ep_day_end_date', $end);
        }if (!empty($search_year)) {
        $query->where('ep_year_id', '=', $search_year);
    } else {
        $search_year = $this->getYearEndId();
        $query->where('ep_year_id', '=', $search_year);
    }

        $datas = $query->orderBy('ep_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);


//        if (isset($request->search) && !empty($request->search)) {
//
//            $search = $request->search;
//
//            $vouchers = ExpensePaymentVoucherModel::
//            orWhere('ep_total_amount', 'like', '%' . $search . '%')
//                ->orWhere('ep_remarks', 'like', '%' . $search . '%')
//                ->orWhere('ep_id', 'like', '%' . $search . '%')
//                ->orderBy('ep_id', 'DESC')
//                ->paginate(1000000);
//
//        } else {
//
//            $vouchers = ExpensePaymentVoucherModel::orderBy('ep_id', 'DESC')
//                ->paginate(15);
//        }

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

            $pdf->loadView($prnt_page_dir, compact('srch_fltr','datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $search_year,$prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('expense_payment_voucher_list', compact('datas', 'search','search_year', 'ttl_amnt', 'search_by_user', 'search_to', 'search_from', 'accounts', 'search_account'));
        }
    }

    // update code by shahzaib end

    public function expense_payment_items_view_details(Request $request)
    {
        $items = ExpensePaymentVoucherItemsModel::where('epi_expense_payment_voucher_id', $request->id)->orderby('epi_account_name', 'ASC')->get();

        return response()->json($items);
    }

    public function expense_payment_items_view_details_SH(Request $request, $id)
    {
        $expns = ExpensePaymentVoucherModel::with('user')->where('ep_id', $id)->first();
        $items = ExpensePaymentVoucherItemsModel::Join('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_expense_payment_voucher_items.epi_pr_id')->where('epi_voucher_id', $id)->orderby('epi_account_name', 'ASC')->get();
        $ep_acnt_nme = AccountRegisterationModel::where('account_uid', $expns->ep_account_id)->first();
        $nbrOfWrds = $this->myCnvrtNbr($expns->ep_total_amount);
        $invoice_nbr = $expns->ep_id;
//        $invoice_date = $expns->ep_created_datetime;
        $invoice_date = $expns->ep_day_end_date;
        $invoice_remarks = $expns->ep_remarks;
        $type = 'grid';
        $pge_title = 'Expense Payment Voucher';

        return view('voucher_view.expense_payment_voucher.expense_payment_journal_voucher_list_modal', compact('items', 'expns', 'nbrOfWrds', 'ep_acnt_nme', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));

    }

    public function expense_payment_items_view_details_pdf_SH(Request $request, $id)
    {
        $expns = ExpensePaymentVoucherModel::with('user')->where('ep_id', $id)->first();
        $items = ExpensePaymentVoucherItemsModel::Join('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_expense_payment_voucher_items.epi_pr_id')->where('epi_voucher_id', $id)->orderby('epi_account_name', 'ASC')->get();
        $ep_acnt_nme = AccountRegisterationModel::where('account_uid', $expns->ep_account_id)->first();
        $nbrOfWrds = $this->myCnvrtNbr($expns->ep_total_amount);
        $invoice_nbr = $expns->ep_id;
//        $invoice_date = $expns->ep_created_datetime;
        $invoice_date = $expns->ep_day_end_date;
        $invoice_remarks = $expns->ep_remarks;
        $type = 'pdf';
        $pge_title = 'Expense Payment Voucher';


        $footer = view('voucher_view._partials.pdf_footer')->render();
        $header = view('voucher_view._partials.pdf_header', compact('invoice_nbr', 'invoice_date', 'pge_title', 'type', 'invoice_remarks'))->render();
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
            'margin-top' => 24,
        ];
        $pdf = PDF::setOptions(['isHTML5ParserEnabled'=>true, 'isRemoteEnabled'=>true]);
        $pdf->getDomPDF()->setHttpContext($options,$optionss);
        $pdf->loadView('voucher_view.expense_payment_voucher.expense_payment_journal_voucher_list_modal', compact('items', 'expns', 'nbrOfWrds', 'ep_acnt_nme', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));
        // $pdf->setOptions($options);


        return $pdf->stream('Expense-Payment-Voucher-Detail.pdf');

    }

    // update code by mustafa start
    public function expense_payment_post_voucher_list(Request $request, $array = null, $str = null)
    {
        $accounts = $this->get_fourth_level_account(config('global_variables.expense'), 3, 0);

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $search_account = (isset($request->account) && !empty($request->account)) ? $request->account : '';
        $prnt_page_dir = 'print.expense_payment_voucher_list.expense_payment_post_voucher_list';
        $pge_title = 'Post Expense Payment Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $user= Auth::user();
//        $query = ExpensePaymentVoucherModel::query();
        $query = DB::table('financials_expense_payment_voucher')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_expense_payment_voucher.ep_createdby')
            ->where('ep_status','park')
            ->where('ep_clg_id',$user->user_clg_id);

        $ttl_amnt = $query->sum('ep_total_amount');

        if (!empty($request->search)) {
            $query->where('ep_total_amount', 'like', '%' . $search . '%')
                ->orWhere('ep_remarks', 'like', '%' . $search . '%')
                ->orWhere('ep_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('ep_createdby', $search_by_user);
        }

        if (!empty($search_account)) {
            $query->where('ep_account_id', $search_account);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('ep_day_end_date', [$start, $end]);
            $query->whereDate('ep_day_end_date', '>=', $start)
                ->whereDate('ep_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('ep_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('ep_day_end_date', $end);
        }

        $datas = $query->orderBy('ep_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);


//        if (isset($request->search) && !empty($request->search)) {
//
//            $search = $request->search;
//
//            $vouchers = ExpensePaymentVoucherModel::
//            orWhere('ep_total_amount', 'like', '%' . $search . '%')
//                ->orWhere('ep_remarks', 'like', '%' . $search . '%')
//                ->orWhere('ep_id', 'like', '%' . $search . '%')
//                ->orderBy('ep_id', 'DESC')
//                ->paginate(1000000);
//
//        } else {
//
//            $vouchers = ExpensePaymentVoucherModel::orderBy('ep_id', 'DESC')
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

            $pdf = PDF::loadView($prnt_page_dir, compact('srch_fltr','datas', 'type', 'pge_title'));
            $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('voucher_post_list.expense_payment_post_voucher_list', compact('datas', 'search', 'ttl_amnt', 'search_by_user', 'search_to', 'search_from', 'accounts', 'search_account'));
        }
    }

    // update code by mustafa end

    public function edit_expense_payment_voucher($id)
    {
        $voucher = ExpensePaymentVoucherModel::where('ep_id', '=', $id)->where('ep_status','!=','post')->first();
        if ($voucher != null){
            $voucher_items = ExpensePaymentVoucherItemsModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', '=', 'financials_expense_payment_voucher_items.epi_pr_id')->where
            ('epi_voucher_id', '=', $id)->select('financials_expense_payment_voucher_items.*', 'financials_posting_reference.pr_name as name')->get();
            return view('edit_voucher.edit_expense_payment_voucher', compact('voucher', 'voucher_items'));
        }
        return redirect()->back();

    }

    public function update_expense_payment_voucher($id, Request $request)
    {

        $this->voucher_validation($request);
        ExpensePaymentVoucherItemsModel::where('epi_voucher_id', $id)->delete();
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

        $notes = 'EXPENSE_PAYMENT_VOUCHER';
        $voucher_code = config('global_variables.EXPENSE_PAYMENT_VOUCHER_CODE');
        $transaction_type = config('global_variables.EXPENSE_PAYMENT');

        DB::beginTransaction();

        $ep = ExpensePaymentVoucherModel::where('ep_id', $id)->first();

        $ep = $this->assign_voucher_values('ep', $ep->ep_v_no, $ep, $account_uid, $total_voucher_amount, $voucher_remarks, $user, $day_end, $status);


        // system config set increment default id according to user giving start coding
        $sstm_cnfg_clm = 'sc_expense_payment_voucher_number';
        $sstm_cnfg_bp_id_chk = SystemConfigModel::where($sstm_cnfg_clm, '!=', '0')->first();
        $chk_bnk_pymnt = ExpensePaymentVoucherModel::all();
        if ($chk_bnk_pymnt->isEmpty()):
            if (isset($sstm_cnfg_bp_id_chk) && !empty($sstm_cnfg_bp_id_chk)):
                $ep->ep_id = $sstm_cnfg_bp_id_chk->$sstm_cnfg_clm;
            endif;
        endif;
        // system config set increment default id according to user giving end coding


        if ($ep->save()) {
            $ep_id = $ep->ep_id;
            $ep_voucher_no = $ep->ep_v_no;
        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }

        $detail_remarks = '';

        $item = $this->voucher_items_values($accountsval, $ep_id, $ep_voucher_no,'epi');

        foreach ($item as $value) {
            $epi_amount = (float)$value['epi_amount'];

            $detail_remarks .= $value['epi_account_name'] . ', @' . number_format($epi_amount, 2) . config('global_variables.Line_Break');
        }

        if (!DB::table('financials_expense_payment_voucher_items')->insert($item)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }


        $ep->ep_detail_remarks = $detail_remarks;
        if (!$ep->save()) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }


        if ($rollBack) {

            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        } else {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $ep->be_id);
            DB::commit();
            return redirect()->back()->with(['ep_id' => $ep_id, 'success' => 'Successfully Saved']);
        }

    }

    public function post_expense_payment_voucher($id)
    {

        $ep_id = $id;
        $expense_voucher = ExpensePaymentVoucherModel::where('ep_id', '=', $ep_id)->first();
        $expense_voucher_items = ExpensePaymentVoucherItemsModel::where('epi_voucher_id', '=', $ep_id)->get();
        $rollBack = false;

        $user = Auth::user();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $account_uid = $expense_voucher->ep_account_id;
        $account_name_text = $this->get_account_name($account_uid);
        $total_voucher_amount = $expense_voucher->ep_total_amount;
        $voucher_remarks = $expense_voucher->ep_remarks;
        $status = $expense_voucher->ep_status;


        $notes = 'EXPENSE_PAYMENT_VOUCHER';
        $voucher_code = config('global_variables.EXPENSE_PAYMENT_VOUCHER_CODE');
        $transaction_type = config('global_variables.EXPENSE_PAYMENT');

        DB::beginTransaction();


//            // system config set increment default id according to user giving start coding
//            $sstm_cnfg_clm = 'sc_expense_payment_voucher_number';
//            $sstm_cnfg_bp_id_chk = SystemConfigModel::where($sstm_cnfg_clm, '!=', '0')->first();
//            $chk_bnk_pymnt = ExpensePaymentVoucherModel::all();
//            if ($chk_bnk_pymnt->isEmpty()):
//                if (isset($sstm_cnfg_bp_id_chk) && !empty($sstm_cnfg_bp_id_chk)):
//                    $ep->ep_id = $sstm_cnfg_bp_id_chk->$sstm_cnfg_clm;
//                endif;
//            endif;
//            // system config set increment default id according to user giving end coding


//            if ($ep->save()) {
//                $ep_id = $ep->ep_id;
//            } else {
//                $rollBack = true;
//                DB::rollBack();
//                return redirect()->back()->with('fail', 'Failed');
//            }
//
//            $detail_remarks = '';
//
//            $item = $this->voucher_items_values($accountsval, $ep_id, 'epi');
//
//            foreach ($item as $value) {
//                $epi_amount = (float)$value['epi_amount'];
//
//                $detail_remarks .= $value['epi_account_name'] . ', @' . number_format($epi_amount, 2) . config('global_variables.Line_Break');
//            }
//
//            if (!DB::table('financials_expense_payment_voucher_items')->insert($item)) {
//                $rollBack = true;
//                DB::rollBack();
//                return redirect()->back()->with('fail', 'Failed');
//            }


//            $ep->ep_detail_remarks = $detail_remarks;
//            if (!$ep->save()) {
//                $rollBack = true;
//                DB::rollBack();
//                return redirect()->back()->with('fail', 'Failed');
//            }

        foreach ($expense_voucher_items as $key) {

            $transaction = new TransactionModel();

            $transaction = $this->AssignTransactionsValues($transaction, $key['epi_account_id'], $key['epi_amount'], $account_uid, $notes, $transaction_type, $ep_id);

            if ($transaction->save()) {

                $transaction_id = $transaction->trans_id;

                // Selected Accounts
                $branch_id = $this->get_branch_id($key['epi_account_id']);
                $balances = new BalancesModel();

                $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key['epi_account_id'], $key['epi_amount'], 'Dr', $key['epi_remarks'],
                    $notes, $account_name_text . ' to ' . $key['epi_account_name'] . ', @' . number_format($key['epi_amount'], 2) . config('global_variables.Line_Break'), $voucher_code .
                    $ep_id,
                    $key['epi_pr_id'],$voucher_code.$expense_voucher->ep_v_no,$this->getYearEndId(),$branch_id);

                if (!$balance->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed');
                }

                // Bank Account
                $branch_id = $this->get_branch_id($account_uid);
                $balances2 = new BalancesModel();

                $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id, $account_uid, $key['epi_amount'], 'Cr', $key['epi_remarks'],
                    $notes, $account_name_text . ' to ' . $key['epi_account_name'] . ', @' . number_format($key['epi_amount'], 2) . config('global_variables.Line_Break'),
                    $voucher_code . $ep_id, $key['epi_pr_id'],$voucher_code.$expense_voucher->ep_v_no, $this->getYearEndId(),$branch_id);

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
            $expense_voucher->ep_status = 'post';
            $expense_voucher->ep_posted_by = $user->user_id;
            $expense_voucher->save();
            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $ep_id);
            DB::commit();
            return redirect()->back()->with(['ep_id' => $ep_id, 'success' => 'Successfully Saved']);
        }

    }
}
