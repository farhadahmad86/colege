<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\BankPaymentVoucherItemsModel;
use App\Models\BankPaymentVoucherModel;
use App\Models\BankReceiptVoucherItemsModel;
use App\Models\BankReceiptVoucherModel;
use App\Models\PostingReferenceModel;
use App\Models\SystemConfigModel;
use App\Models\TransactionModel;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class BankPaymentVoucherController extends Controller
{
    public function bank_payment_voucher()
    {
        return view('bank_payment_voucher');
    }

    public function submit_bank_payment_voucher(Request $request)
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

        $notes = 'BANK_PAYMENT_VOUCHER';
        $voucher_code = config('global_variables.BANK_PAYMENT_VOUCHER_CODE');
        $transaction_type = config('global_variables.BANK_PAYMENT');

        DB::beginTransaction();

        $bp = new BankPaymentVoucherModel();
        $bp_v_no = BankPaymentVoucherModel::where('bp_clg_id', $user->user_clg_id)->max('bp_v_no');

        $bp = $this->assign_voucher_values('bp', $bp_v_no + 1, $bp, $account_uid, $total_voucher_amount, $voucher_remarks, $user, $day_end, $status);

        // system config set increment default id according to user giving start coding$status
        $sstm_cnfg_clm = 'sc_bank_payment_voucher_number';
        $sstm_cnfg_bp_id_chk = SystemConfigModel::where('sc_clg_id', '=', $user->user_clg_id)->where($sstm_cnfg_clm, '!=', '0')->first();
        $chk_bnk_pymnt = BankPaymentVoucherModel::where('bp_clg_id', '=', $user->user_clg_id)->get();
        if ($chk_bnk_pymnt->isEmpty()):
            if (isset($sstm_cnfg_bp_id_chk) && !empty($sstm_cnfg_bp_id_chk)):
                $bp->bp_id = $sstm_cnfg_bp_id_chk->$sstm_cnfg_clm;
            endif;
        endif;
        // system config set increment default id according to user giving end coding

        if ($bp->save()) {
            $bp_id = $bp->bp_id;
            $bp_voucher_no = $bp->bp_v_no;
        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }


        $detail_remarks = '';

        $item = $this->voucher_items_values($accountsval, $bp_id, $bp_voucher_no, 'bpi');

        foreach ($item as $value) {
            $bpi_amount = (float)$value['bpi_amount'];

            $detail_remarks .= $value['bpi_account_name'] . ', @' . number_format($bpi_amount, 2) . config('global_variables.Line_Break');
        }


        if (!DB::table('financials_bank_payment_voucher_items')->insert($item)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }


        $bp->bp_detail_remarks = $detail_remarks;
        if (!$bp->save()) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }
        if ($status == 'post') {
            foreach ($accountsval as $key) {

                $transaction = new TransactionModel();

                $transaction = $this->AssignTransactionsValues($transaction, $key['account_code'], $key['account_amount'], $account_uid, $notes, $transaction_type, $bp_id);

                if ($transaction->save()) {

                    $transaction_id = $transaction->trans_id;

                    // Selected Accounts

                    $branch_id = $this->get_branch_id($key['account_code']);
                    $balances = new BalancesModel();

                    $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key['account_code'], $key['account_amount'], 'Dr', $key['account_remarks'],
                        $notes, $account_name_text . ' to ' . $key['account_name'] . ', @' . number_format($key['account_amount'], 2) . config('global_variables.Line_Break'), $voucher_code .
                        $bp_id, $key['posting_reference'], $voucher_code . $bp_voucher_no, $this->getYearEndId(), $branch_id);

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
                        $bp_id, $key['posting_reference'], $voucher_code . $bp_voucher_no, $this->getYearEndId(), $branch_id);

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

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $bp->bp_id);
            DB::commit();
            return redirect()->back()->with(['bp_id' => $bp_id, 'success' => 'Successfully Saved']);
        }
    }


    // update code by shahzaib start
    public function bank_payment_voucher_list(Request $request, $array = null, $str = null)
    {
        $bank_accounts = $this->get_fourth_level_account(config('global_variables.bank_head'), 0, 0);

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $search_bank_account = (isset($request->bank_account) && !empty($request->bank_account)) ? $request->bank_account : '';
        $prnt_page_dir = 'print.bank_payment_voucher_list.bank_payment_voucher_list';
        $pge_title = 'Bank Payment Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from, $search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $user = Auth::user();
//        $query = BankPaymentVoucherModel::query();
        $query = DB::table('financials_bank_payment_voucher')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_bank_payment_voucher.bp_createdby')
            ->where('bp_clg_id', $user->user_clg_id);
        $ttl_amnt = $query->sum('bp_total_amount');

        if (!empty($request->search)) {
            $query->where('bp_total_amount', 'like', '%' . $search . '%')
                ->orWhere('bp_remarks', 'like', '%' . $search . '%')
                ->orWhere('bp_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('bp_createdby', $search_by_user);
        }

        if (!empty($search_bank_account)) {
            $query->where('bp_account_id', $search_bank_account);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('bp_day_end_date', [$start, $end]);
            $query->whereDate('bp_day_end_date', '>=', $start)
                ->whereDate('bp_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('bp_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('bp_day_end_date', $end);
        }
        if (!empty($search_year)) {
            $query->where('bp_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('bp_year_id', '=', $search_year);
        }

        $datas = $query->orderBy('bp_id', config('global_variables.query_sorting'))
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
            return view('bank_payment_voucher_list', compact('datas', 'search', 'search_to', 'search_year', 'search_from', 'ttl_amnt', 'search_by_user', 'bank_accounts', 'search_bank_account'));
        }

    }

    // update code by shahzaib end


    public function bank_payment_items_view_details(Request $request)
    {
        $items = BankPaymentVoucherItemsModel::where('bpi_bank_payment_voucher_id', $request->id)->orderby('bpi_account_name', 'ASC')->get();

        return response()->json($items);
    }

    public function bank_payment_items_view_details_SH(Request $request, $id)
    {

        $bnk_pmnt = BankPaymentVoucherModel::with('user')->where('bp_id', $id)->first();
        $items = BankPaymentVoucherItemsModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', '=', 'financials_bank_payment_voucher_items.bpi_pr_id')->where('bpi_voucher_id', $id)->orderby('bpi_account_name', 'ASC')->get();
        $bp_acnt_nme = AccountRegisterationModel::where('account_uid', $bnk_pmnt->bp_account_id)->first();
        $nbrOfWrds = $this->myCnvrtNbr($bnk_pmnt->bp_total_amount);
        $invoice_nbr = $bnk_pmnt->bp_id;
//        $invoice_date = $bnk_pmnt->bp_created_datetime;
        $invoice_date = $bnk_pmnt->bp_day_end_date;
        $invoice_remarks = $bnk_pmnt->bp_remarks;
        $type = 'grid';
        $pge_title = 'Bank Payment Voucher';

        return view('voucher_view.bank_payment_voucher.bank_payment_journal_voucher_list_modal', compact('items', 'bnk_pmnt', 'nbrOfWrds', 'bp_acnt_nme', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));

    }

    public function bank_payment_items_view_details_pdf_SH(Request $request, $id)
    {
        $bnk_pmnt = BankPaymentVoucherModel::with('user')->where('bp_id', $id)->first();
        $items = BankPaymentVoucherItemsModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', '=', 'financials_bank_payment_voucher_items.bpi_pr_id')->where('bpi_voucher_id', $id)->orderby('bpi_account_name', 'ASC')->get();
        $bp_acnt_nme = AccountRegisterationModel::where('account_uid', $bnk_pmnt->bp_account_id)->first();
        $nbrOfWrds = $this->myCnvrtNbr($bnk_pmnt->bp_total_amount);
        $invoice_nbr = $bnk_pmnt->bp_id;
        $invoice_date = $bnk_pmnt->bp_created_datetime;
        $invoice_date = $bnk_pmnt->bp_day_end_date;
        $invoice_remarks = $bnk_pmnt->bp_remarks;
        $type = 'pdf';
        $pge_title = 'Bank Payment Voucher';


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
        $pdf->loadView('voucher_view.bank_payment_voucher.bank_payment_journal_voucher_list_modal', compact('items', 'bnk_pmnt', 'nbrOfWrds', 'bp_acnt_nme', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));
        // $pdf->setOptions($options);


        return $pdf->stream('Bank-Payment-Voucher-Detail.pdf');

    }

    public function edit_bank_payment_voucher($id)
    {
        $voucher = BankPaymentVoucherModel::where('bp_id', '=', $id)->where('bp_status', '!=', 'post')->first();
        if ($voucher != null) {
            $voucher_items = BankPaymentVoucherItemsModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', '=', 'financials_bank_payment_voucher_items.bpi_pr_id')->where('bpi_voucher_id', '=', $id)->select('financials_bank_payment_voucher_items.*', 'financials_posting_reference.pr_name as name')->get();

            return view('edit_voucher.edit_bank_payment_voucher', compact('voucher', 'voucher_items'));
        }
        return redirect()->back();

    }

    public function delete_bank_payment_voucher($id)
    {
        $user = Auth::user()->user_id;
        $delete = BankPaymentVoucherModel::where('bp_id', '=', $id)->where('bp_status', '!=', 'post')->first();
        $delete->bp_status = 'deleted';
        $delete->bp_posted_by = $user;
        $delete->save();
        return redirect()->back()->with('success', 'Deleted Successfully!');
    }

    public function update_bank_payment_voucher($id, Request $request)
    {
        $this->voucher_validation($request);
        BankPaymentVoucherItemsModel::where('bpi_voucher_id', $id)->delete();

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

        $notes = 'BANK_PAYMENT_VOUCHER';
        $notes = 'BANK_PAYMENT_VOUCHER';
        $voucher_code = config('global_variables.BANK_PAYMENT_VOUCHER_CODE');
        $transaction_type = config('global_variables.BANK_PAYMENT');

        DB::beginTransaction();

        $bp = BankPaymentVoucherModel::where('bp_id', $id)->first();

        $bp = $this->assign_voucher_values('bp', $bp->bp_v_no, $bp, $account_uid, $total_voucher_amount, $voucher_remarks, $user, $day_end, $status);


        // system config set increment default id according to user giving start coding$status
        $sstm_cnfg_clm = 'sc_bank_payment_voucher_number';
        $sstm_cnfg_bp_id_chk = SystemConfigModel::where('sc_clg_id', '=', $user->user_clg_id)->where($sstm_cnfg_clm, '!=', '0')->first();
        $chk_bnk_pymnt = BankPaymentVoucherModel::where('bp_clg_id', '=', $user->user_clg_id)->get();
        if ($chk_bnk_pymnt->isEmpty()):
            if (isset($sstm_cnfg_bp_id_chk) && !empty($sstm_cnfg_bp_id_chk)):
                $bp->bp_id = $sstm_cnfg_bp_id_chk->$sstm_cnfg_clm;
            endif;
        endif;
        // system config set increment default id according to user giving end coding


        if ($bp->save()) {
            $bp_id = $bp->bp_id;
            $bp_voucher_no = $bp->bp_v_no;
        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }

        $detail_remarks = '';

        $item = $this->voucher_items_values($accountsval, $bp_id, $bp_voucher_no, 'bpi');

        foreach ($item as $value) {
            $bpi_amount = (float)$value['bpi_amount'];

            $detail_remarks .= $value['bpi_account_name'] . ', @' . number_format($bpi_amount, 2) . config('global_variables.Line_Break');
        }

        if (!DB::table('financials_bank_payment_voucher_items')->insert($item)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }


        $bp->bp_detail_remarks = $detail_remarks;
        if (!$bp->save()) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }
        if ($rollBack) {

            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        } else {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $bp->bp_id);
            DB::commit();
            return redirect()->back()->with(['bp_id' => $bp_id, 'success' => 'Successfully Saved']);
        }
    }

    // update code by supply_chain start
    public function bank_payment_post_voucher_list(Request $request, $array = null, $str = null)
    {
        $bank_accounts = $this->get_fourth_level_account(config('global_variables.bank_head'), 0, 0);

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $search_bank_account = (isset($request->bank_account) && !empty($request->bank_account)) ? $request->bank_account : '';
        $prnt_page_dir = 'print.bank_payment_voucher_list.bank_payment_post_voucher_list';
        $pge_title = 'Post Bank Payment Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $user = Auth::user();
        //        $query = BankPaymentVoucherModel::query();
        $query = DB::table('financials_bank_payment_voucher')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_bank_payment_voucher.bp_createdby')
            ->where('bp_clg_id', $user->user_clg_id)
            ->where('bp_status', 'park');
        $ttl_amnt = $query->sum('bp_total_amount');

        if (!empty($request->search)) {
            $query->where('bp_total_amount', 'like', '%' . $search . '%')
                ->orWhere('bp_remarks', 'like', '%' . $search . '%')
                ->orWhere('bp_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('bp_createdby', $search_by_user);
        }

        if (!empty($search_bank_account)) {
            $query->where('bp_account_id', $search_bank_account);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
            //            $query->whereBetween('bp_day_end_date', [$start, $end]);
            $query->whereDate('bp_day_end_date', '>=', $start)
                ->whereDate('bp_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('bp_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('bp_day_end_date', $end);
        }

        $datas = $query->orderBy('bp_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];

            $pdf = PDF::loadView($prnt_page_dir, compact('srch_fltr', 'datas', 'type', 'pge_title'));
            $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('voucher_post_list.bank_payment_post_voucher_list', compact('datas', 'search', 'search_to', 'search_from', 'ttl_amnt', 'search_by_user', 'bank_accounts', 'search_bank_account'));
        }

    }

    // update code by brhan end
    public function post_bank_payment_voucher($id)
    {
        $bp_id = $id;
        // $this->voucher_validation($request);
        $bank_voucher = BankPaymentVoucherModel::where('bp_id', '=', $id)->first();
        $bank_voucher_items = BankPaymentVoucherItemsModel::where('bpi_voucher_id', '=', $id)->get();

        $rollBack = false;

        $user = Auth::user();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $account_uid = $bank_voucher->bp_account_id;
        $account_name_text = $this->get_account_name($account_uid);
        $total_voucher_amount = $bank_voucher->bp_total_amount;
        $voucher_remarks = $bank_voucher->bp_remarks;
        $status = $bank_voucher->bp_status;

        $notes = 'BANK_PAYMENT_VOUCHER';
        $voucher_code = config('global_variables.BANK_PAYMENT_VOUCHER_CODE');
        $transaction_type = config('global_variables.BANK_PAYMENT');

        DB::beginTransaction();


        // $bp = $this->assign_voucher_values('bp', $bp, $account_uid, $total_voucher_amount, $voucher_remarks, $user, $day_end,$status);


        // system config set increment default id according to user giving start coding$status
        // $sstm_cnfg_clm = 'sc_bank_payment_voucher_number';
        // $sstm_cnfg_bp_id_chk = SystemConfigModel::where($sstm_cnfg_clm,'!=', '0')->first();
        // $chk_bnk_pymnt = BankPaymentVoucherModel::all();
        // if( $chk_bnk_pymnt->isEmpty() ):
        //     if( isset($sstm_cnfg_bp_id_chk) && !empty($sstm_cnfg_bp_id_chk) ):
        //         $bp->bp_id = $sstm_cnfg_bp_id_chk->$sstm_cnfg_clm;
        //     endif;
        // endif;
        // // system config set increment default id according to user giving end coding


        // if ($bp->save()) {
        //     $bp_id = $bp->bp_id;
        // } else {
        //     $rollBack = true;
        //     DB::rollBack();
        //     return redirect()->back()->with('fail', 'Failed');
        // }

        // $detail_remarks = '';

        // $item = $this->voucher_items_values($accountsval, $bp_id, 'bpi');

        // foreach ($item as $value) {
        //     $bpi_amount = (float)$value['bpi_amount'];

        //     $detail_remarks .= $value['bpi_account_name'] . ', @' . number_format($bpi_amount, 2) .config('global_variables.Line_Break');
        // }


        // if (!DB::table('financials_bank_payment_voucher_items')->insert($item)) {
        //     $rollBack = true;
        //     DB::rollBack();
        //     return redirect()->back()->with('fail', 'Failed');
        // }


        // $bp->bp_detail_remarks = $detail_remarks;
        // if (!$bp->save()) {
        //     $rollBack = true;
        //     DB::rollBack();
        //     return redirect()->back()->with('fail', 'Failed');
        // }
        // if ($status == 'post') {
        foreach ($bank_voucher_items as $key) {

            $transaction = new TransactionModel();

            $transaction = $this->AssignTransactionsValues($transaction, $key['bpi_account_id'], $key['bpi_amount'], $account_uid, $notes, $transaction_type, $bp_id);

            if ($transaction->save()) {

                $transaction_id = $transaction->trans_id;

                // Selected Accounts

                $branch_id = $this->get_branch_id($key['bpi_account_id']);
                $balances = new BalancesModel();

                $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key['bpi_account_id'], $key['bpi_amount'], 'Dr', $key['bpi_remarks'],
                    $notes, $account_name_text . ' to ' . $key['bpi_account_name'] . ', @' . number_format($key['bpi_amount'], 2) . config('global_variables.Line_Break'), $voucher_code . $bp_id,
                    $key['bpi_pr_id'], $voucher_code . $bank_voucher->bp_v_no, $this->getYearEndId(), $branch_id);

                if (!$balance->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed');
                }

                // Bank Account
                $branch_id = $this->get_branch_id($account_uid);
                $balances2 = new BalancesModel();

                $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id, $account_uid, $key['bpi_amount'], 'Cr', $key['bpi_remarks'],
                    $notes, $account_name_text . ' to ' . $key['bpi_account_name'] . ', @' . number_format($key['bpi_amount'], 2) . config('global_variables.Line_Break'), $voucher_code . $bp_id,
                    $key['bpi_pr_id'], $voucher_code . $bank_voucher->bp_v_no, $this->getYearEndId(), $branch_id);

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
        // }

        if ($rollBack) {

            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        } else {
            $bank_voucher->bp_status = 'post';
            $bank_voucher->bp_posted_by = $user->user_id;
            $bank_voucher->save();
            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $bp_id);
            DB::commit();
            return redirect()->back()->with(['bp_id' => $bp_id, 'success' => 'Successfully Update']);
        }
    }


}
