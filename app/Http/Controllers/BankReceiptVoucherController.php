<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\BankPaymentVoucherModel;
use App\Models\BankReceiptVoucherItemsModel;
use App\Models\BankReceiptVoucherModel;
use App\Models\CashReceiptVoucherItemsModel;
use App\Models\CashReceiptVoucherModel;
use App\Models\ExpensePaymentVoucherItemsModel;
use App\Models\ExpensePaymentVoucherModel;
use App\Models\PostingReferenceModel;
use App\Models\SystemConfigModel;
use App\Models\TransactionModel;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Route;
use PDF;

class BankReceiptVoucherController extends Controller
{
    public function bank_receipt_voucher()
    {
        return view('bank_receipt_voucher');
    }

    public function submit_bank_receipt_voucher(Request $request)
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

        $notes = 'BANK_RECEIPT_VOUCHER';
        $voucher_code = config('global_variables.BANK_RECEIPT_VOUCHER_CODE');
        $transaction_type = config('global_variables.BANK_RECEIPT');

        DB::beginTransaction();

        $br = new BankReceiptVoucherModel();
        $br_v_no = BankReceiptVoucherModel::where('br_clg_id', $user->user_clg_id)->max('br_v_no');

        $br = $this->assign_voucher_values('br', $br_v_no + 1, $br, $account_uid, $total_voucher_amount, $voucher_remarks, $user, $day_end, $status, 1);


        // system config set increment default id according to user giving start coding
        $sstm_cnfg_clm = 'sc_bank_receipt_voucher_number';
        $sstm_cnfg_bp_id_chk = SystemConfigModel::where('sc_clg_id', '=', $user->user_clg_id)->where($sstm_cnfg_clm, '!=', '0')->first();
        $chk_bnk_pymnt = BankReceiptVoucherModel::where('br_clg_id', '=', $user->user_clg_id)->get();
        if ($chk_bnk_pymnt->isEmpty()):
            if (isset($sstm_cnfg_bp_id_chk) && !empty($sstm_cnfg_bp_id_chk)):
                $br->br_id = $sstm_cnfg_bp_id_chk->$sstm_cnfg_clm;
            endif;
        endif;
        // system config set increment default id according to user giving end coding


        if ($br->save()) {
            $br_id = $br->br_id;
            $br_voucher_no = $br->br_v_no;
        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }

        $detail_remarks = '';

        $item = $this->voucher_items_values($accountsval, $br_id, $br_voucher_no,'bri');

        foreach ($item as $value) {
            $bri_amount = (float)$value['bri_amount'];

            $detail_remarks .= $value['bri_account_name'] . ', @' . number_format($bri_amount, 2) . config('global_variables.Line_Break');
        }

        if (!DB::table('financials_bank_receipt_voucher_items')->insert($item)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }


        $br->br_detail_remarks = $detail_remarks;
        if (!$br->save()) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }
        if ($status == 'post') {
            foreach ($accountsval as $key) {

                $transaction = new TransactionModel();

                $transaction = $this->AssignTransactionsValues($transaction, $account_uid, $key['account_amount'], $key['account_code'], $notes, $transaction_type, $br_id);

                if ($transaction->save()) {

                    $transaction_id = $transaction->trans_id;

                    // Selected Accounts
                    $branch_id = $this->get_branch_id($key['account_code']);
                    $balances = new BalancesModel();

                    $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key['account_code'], $key['account_amount'], 'Cr', $key['account_remarks'],
                        $notes, $account_name_text . ' to ' . $key['account_name'] . ', @' . number_format($key['account_amount'], 2) . config('global_variables.Line_Break'), $voucher_code .
                        $br_id, $key['posting_reference'], $voucher_code .$br_voucher_no,$this->getYearEndId(),$branch_id);

                    if (!$balance->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed');
                    }

                    // Bank Account
                    $branch_id = $this->get_branch_id($account_uid);
                    $balances2 = new BalancesModel();

                    $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id, $account_uid, $key['account_amount'], 'Dr', $key['account_remarks'],
                        $notes, $account_name_text . ' to ' . $key['account_name'] . ', @' . number_format($key['account_amount'], 2) . config('global_variables.Line_Break'), $voucher_code .
                        $br_id, $key['posting_reference'],$voucher_code .$br_voucher_no,$this->getYearEndId(),$branch_id);

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

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $br->br_id);
            DB::commit();
            return redirect()->back()->with(['br_id' => $br_id, 'success' => 'Successfully Saved']);
        }
    }


    // update code by shahzaib start
    public function bank_receipt_voucher_list(Request $request, $array = null, $str = null)
    {
        $bank_accounts = $this->get_fourth_level_account(config('global_variables.bank_head'), 0, 0);

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $search_bank_account = (isset($request->bank_account) && !empty($request->bank_account)) ? $request->bank_account : '';
        $prnt_page_dir = 'print.bank_receipt_voucher_list.bank_receipt_voucher_list';
        $pge_title = 'Bank Receipt Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from,$search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $user = Auth::user();
//        $query = BankReceiptVoucherModel::query();
        $query = DB::table('financials_bank_receipt_voucher')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_bank_receipt_voucher.br_createdby')
        ->where('br_clg_id',$user->user_clg_id);
        $ttl_amnt = $query->sum('br_total_amount');

        if (!empty($request->search)) {
            $query->where('br_total_amount', 'like', '%' . $search . '%')
                ->orWhere('br_remarks', 'like', '%' . $search . '%')
                ->orWhere('br_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('br_createdby', $search_by_user);
        }

        if (!empty($search_bank_account)) {
            $query->where('br_account_id', $search_bank_account);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('br_day_end_date', [$start, $end]);
            $query->whereDate('br_day_end_date', '>=', $start)
                ->whereDate('br_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('br_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('br_day_end_date', $end);
        }
        if (!empty($search_year)) {
            $query->where('br_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('br_year_id', '=', $search_year);
        }
        $datas = $query->orderBy('br_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);


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
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type,$search_year, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('bank_receipt_voucher_list', compact('datas', 'search', 'search_year','search_to', 'search_from', 'ttl_amnt', 'search_by_user', 'bank_accounts', 'search_bank_account'));
        }


    }

    // update code by shahzaib end

    public function bank_receipt_items_view_details(Request $request)
    {
        $items = BankReceiptVoucherItemsModel::where('bri_bank_receipt_voucher_id', $request->id)->orderby('bri_account_name', 'ASC')->get();

        return response()->json($items);
    }

    public function bank_receipt_items_view_details_SH(Request $request, $id)
    {

        $bnk_rcpt = BankReceiptVoucherModel::with('user')->where('br_id', $id)->first();
        $items = BankReceiptVoucherItemsModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', '=', 'financials_bank_receipt_voucher_items.bri_pr_id')->where('bri_voucher_id', $id)->orderby('bri_account_name', 'ASC')->get();
        $br_acnt_nme = AccountRegisterationModel::where('account_uid', $bnk_rcpt->br_account_id)->first();
        $nbrOfWrds = $this->myCnvrtNbr($bnk_rcpt->br_total_amount);
        $invoice_nbr = $bnk_rcpt->br_id;
//        $invoice_date = $bnk_rcpt->br_created_datetime;
        $invoice_date = $bnk_rcpt->br_day_end_date;
        $invoice_remarks = $bnk_rcpt->br_remarks;
        $type = 'grid';
        $pge_title = 'Bank Receipt Voucher';

        return view('voucher_view.bank_voucher.bank_receipt_journal_voucher_list_modal', compact('items', 'bnk_rcpt', 'nbrOfWrds', 'br_acnt_nme', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));

    }

    public function bank_receipt_items_view_details_pdf_SH(Request $request, $id)
    {

        $bnk_rcpt = BankReceiptVoucherModel::with('user')->where('br_id', $id)->first();
        $items = BankReceiptVoucherItemsModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', '=', 'financials_bank_receipt_voucher_items.bri_pr_id')->where('bri_voucher_id', $id)->orderby('bri_account_name', 'ASC')->get();
        $br_acnt_nme = AccountRegisterationModel::where('account_uid', $bnk_rcpt->br_account_id)->first();
        $nbrOfWrds = $this->myCnvrtNbr($bnk_rcpt->br_total_amount);
        $invoice_nbr = $bnk_rcpt->br_id;
//        $invoice_date = $bnk_rcpt->br_created_datetime;
        $invoice_date = $bnk_rcpt->br_day_end_date;
        $invoice_remarks = $bnk_rcpt->br_remarks;
        $type = 'pdf';
        $pge_title = 'Bank Receipt Voucher';


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
        $pdf->loadView('voucher_view.bank_voucher.bank_receipt_journal_voucher_list_modal', compact('items', 'bnk_rcpt', 'nbrOfWrds', 'br_acnt_nme', 'invoice_nbr', 'invoice_date',
            'invoice_remarks', 'type', 'pge_title', 'invoice_remarks'));
        // $pdf->setOptions($options);

        return $pdf->stream('Bank-Receipt-Voucher-Detail.pdf');

    }

    // update code by mustafa start
    public function bank_receipt_post_voucher_list(Request $request, $array = null, $str = null)
    {
        $bank_accounts = $this->get_fourth_level_account(config('global_variables.bank_head'), 0, 0);

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $search_bank_account = (isset($request->bank_account) && !empty($request->bank_account)) ? $request->bank_account : '';
        $prnt_page_dir = 'print.bank_receipt_voucher_list.bank_receipt_post_voucher_list';
        $pge_title = 'Post Bank Receipt Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $user = Auth::user();
        //        $query = BankReceiptVoucherModel::query();
        $query = DB::table('financials_bank_receipt_voucher')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_bank_receipt_voucher.br_createdby')
            ->where('br_clg_id',$user->user_clg_id)
            ->where('br_status', '=', 'park');
        $ttl_amnt = $query->sum('br_total_amount');

        if (!empty($request->search)) {
            $query->where('br_total_amount', 'like', '%' . $search . '%')
                ->orWhere('br_remarks', 'like', '%' . $search . '%')
                ->orWhere('br_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('br_createdby', $search_by_user);
        }

        if (!empty($search_bank_account)) {
            $query->where('br_account_id', $search_bank_account);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
            //            $query->whereBetween('br_day_end_date', [$start, $end]);
            $query->whereDate('br_day_end_date', '>=', $start)
                ->whereDate('br_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('br_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('br_day_end_date', $end);
        }

        $datas = $query->orderBy('br_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);


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
                'margin-top' => 24,
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
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('voucher_post_list.bank_receipt_post_voucher_list', compact('datas', 'search', 'search_to', 'search_from', 'ttl_amnt', 'search_by_user', 'bank_accounts', 'search_bank_account'));
        }

    }

    // update code by mustafa end
    public function edit_bank_receipt_voucher($id)
    {

        $voucher = BankReceiptVoucherModel::where('br_id', '=', $id)->where('br_status', '!=', 'post')->first();
        if ($voucher != null) {

            $voucher_items = BankReceiptVoucherItemsModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', '=', 'financials_bank_receipt_voucher_items.bri_pr_id')->where('bri_voucher_id', '=', $id)->select('financials_bank_receipt_voucher_items.*', 'financials_posting_reference.pr_name as name')->get();
            return view('edit_voucher.edit_bank_receipt_voucher', compact('voucher', 'voucher_items'));
        }
        return redirect()->back();
    }
    public function delete_bank_receipt_voucher($id)
    {
        $user = Auth::user()->user_id;
       $delete = BankReceiptVoucherModel::where('br_id', '=', $id)->where('br_status', '!=', 'post')->first();
        $delete->br_status='deleted';
        $delete->br_posted_by= $user;
        $delete->save();
        return redirect()->back()->with('success','Deleted Successfully!');
    }

    public function update_bank_receipt_voucher($id, Request $request)
    {
        $this->voucher_validation($request);
        BankReceiptVoucherItemsModel::where('bri_voucher_id', $id)->delete();

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

        $notes = 'BANK_RECEIPT_VOUCHER';
        $voucher_code = config('global_variables.BANK_RECEIPT_VOUCHER_CODE');
        $transaction_type = config('global_variables.BANK_RECEIPT');

        DB::beginTransaction();

        $br = BankReceiptVoucherModel::where('br_id', $id)->first();

        $br = $this->assign_voucher_values('br', $br->br_v_no, $br, $account_uid, $total_voucher_amount, $voucher_remarks, $user, $day_end, $status, 1);


        // system config set increment default id according to user giving start coding
        $sstm_cnfg_clm = 'sc_bank_receipt_voucher_number';
        $sstm_cnfg_bp_id_chk = SystemConfigModel::where('sc_clg_id', '=', $user->user_clg_id)->where($sstm_cnfg_clm, '!=', '0')->first();
        $chk_bnk_pymnt = BankReceiptVoucherModel::where('br_clg_id', '=', $user->user_clg_id)->get();
        if ($chk_bnk_pymnt->isEmpty()):
            if (isset($sstm_cnfg_bp_id_chk) && !empty($sstm_cnfg_bp_id_chk)):
                $br->br_id = $sstm_cnfg_bp_id_chk->$sstm_cnfg_clm;
            endif;
        endif;
        // system config set increment default id according to user giving end coding


        if ($br->save()) {
            $br_id = $br->br_id;
            $br_voucher_no = $br->br_v_no;
        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }

        $detail_remarks = '';

        $item = $this->voucher_items_values($accountsval, $br_id, $br_voucher_no,'bri');

        foreach ($item as $value) {
            $bri_amount = (float)$value['bri_amount'];

            $detail_remarks .= $value['bri_account_name'] . ', @' . number_format($bri_amount, 2) . config('global_variables.Line_Break');
        }

        if (!DB::table('financials_bank_receipt_voucher_items')->insert($item)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }


        $br->br_detail_remarks = $detail_remarks;
        if (!$br->save()) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }


        if ($rollBack) {

            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        } else {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $br->br_id);
            DB::commit();
            return redirect()->back()->with(['br_id' => $br_id, 'success' => 'Successfully Saved']);
        }
    }

    public function post_bank_receipt_voucher($id)
    {

        // $this->voucher_validation($request);

        $br_id = $id;
        $bank_voucher = BankReceiptVoucherModel::where('br_id', '=', $id)->first();
        $bank_voucher_items = BankReceiptVoucherItemsModel::where('bri_voucher_id', '=', $id)->get();
        // dd($bank_voucher,$bank_voucher_items);
        $rollBack = false;

        $user = Auth::user();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();


        $account_uid = $bank_voucher->br_account_id;
        $account_name_text = $this->get_account_name($account_uid);
        $total_voucher_amount = $bank_voucher->br_total_amount;
        $voucher_remarks = $bank_voucher->br_remarks;
        $status = $bank_voucher->br_status;

        $notes = 'BANK_RECEIPT_VOUCHER';
        $voucher_code = config('global_variables.BANK_RECEIPT_VOUCHER_CODE');
        $transaction_type = config('global_variables.BANK_RECEIPT');

        DB::beginTransaction();

        // $br = new BankReceiptVoucherModel();

        // $br = $this->assign_voucher_values('br', $br, $account_uid, $total_voucher_amount, $voucher_remarks, $user, $day_end,$status, 1);


        // system config set increment default id according to user giving start coding
        // $sstm_cnfg_clm = 'sc_bank_receipt_voucher_number';
        // $sstm_cnfg_bp_id_chk = SystemConfigModel::where($sstm_cnfg_clm, '!=', '0')->first();
        // $chk_bnk_pymnt = BankReceiptVoucherModel::all();
        // if ($chk_bnk_pymnt->isEmpty()):
        //     if (isset($sstm_cnfg_bp_id_chk) && !empty($sstm_cnfg_bp_id_chk)):
        //         $br->br_id = $sstm_cnfg_bp_id_chk->$sstm_cnfg_clm;
        //     endif;
        // endif;
        // // system config set increment default id according to user giving end coding


        // if ($br->save()) {
        //     $br_id = $br->br_id;
        // } else {
        //     $rollBack = true;
        //     DB::rollBack();
        //     return redirect()->back()->with('fail', 'Failed');
        // }

        // $detail_remarks = '';

        // $item = $this->voucher_items_values($accountsval, $br_id, 'bri');

        // foreach ($item as $value) {
        //     $bri_amount = (float)$value['bri_amount'];

        //     $detail_remarks .= $value['bri_account_name'] . ', @' . number_format($bri_amount, 2) . config('global_variables.Line_Break');
        // }

        // if (!DB::table('financials_bank_receipt_voucher_items')->insert($item)) {
        //     $rollBack = true;
        //     DB::rollBack();
        //     return redirect()->back()->with('fail', 'Failed');
        // }


        // $br->br_detail_remarks = $detail_remarks;
        // if (!$br->save()) {
        //     $rollBack = true;
        //     DB::rollBack();
        //     return redirect()->back()->with('fail', 'Failed');
        // }
        // if ($status == 'post') {
        foreach ($bank_voucher_items as $key) {

            $transaction = new TransactionModel();

            $transaction = $this->AssignTransactionsValues($transaction, $account_uid, $key['bri_amount'], $key['bri_account_id'], $notes, $transaction_type, $br_id);

            if ($transaction->save()) {

                $transaction_id = $transaction->trans_id;

                // Selected Accounts
                $branch_id = $this->get_branch_id($key['bri_account_id']);
                $balances = new BalancesModel();

                $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key['bri_account_id'], $key['bri_amount'], 'Cr', $key['bri_remarks'],
                    $notes, $account_name_text . ' to ' . $key['bri_account_name'] . ', @' . number_format($key['bri_amount'], 2) . config('global_variables.Line_Break'), $voucher_code . $br_id,
                    $key['bri_pr_id'],$voucher_code . $bank_voucher->br_v_no,$this->getYearEndId(),$branch_id);

                if (!$balance->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed');
                }

                // Bank Account
                $branch_id = $this->get_branch_id($account_uid);
                $balances2 = new BalancesModel();

                $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id, $account_uid, $key['bri_amount'], 'Dr', $key['bri_remarks'],
                    $notes, $account_name_text . ' to ' . $key['bri_account_name'] . ', @' . number_format($key['bri_amount'], 2) . config('global_variables.Line_Break'), $voucher_code . $br_id,
                    $key['bri_pr_id'],$voucher_code . $bank_voucher->br_v_no, $this->getYearEndId(),$branch_id);

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
            $bank_voucher->br_status = 'post';
            $bank_voucher->br_posted_by = $user->user_id;
            $bank_voucher->save();
            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $br_id);
            DB::commit();
            return redirect()->back()->with(['br_id' => $br_id, 'success' => 'Successfully Post']);
        }

    }

}
