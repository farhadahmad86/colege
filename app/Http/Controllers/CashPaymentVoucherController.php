<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\BankPaymentVoucherModel;
use App\Models\CashPaymentVoucherItemsModel;
use App\Models\CashPaymentVoucherModel;
use App\Models\CashReceiptVoucherItemsModel;
use App\Models\CashReceiptVoucherModel;
use App\Models\PostingReferenceModel;
use App\Models\SystemConfigModel;
use App\Models\TransactionModel;
use Auth;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashPaymentVoucherController extends Controller
{
    public function cash_payment_voucher()
    {
//        $accounts_array = $this->get_account_query('cash_voucher');
//        $accounts = $accounts_array[0];
//        $cash_accounts = $accounts_array[1];

        return view('cash_payment_voucher');
    }

    public function submit_cash_payment_voucher(Request $request)
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

        $notes = 'CASH_PAYMENT_VOUCHER';
        $voucher_code = config('global_variables.CASH_PAYMENT_VOUCHER_CODE');
        $transaction_type = config('global_variables.CASH_PAYMENT');

        DB::beginTransaction();

        $cp = new CashPaymentVoucherModel();
        $cp_v_no = CashPaymentVoucherModel::where('cp_clg_id', $user->user_clg_id)->max('cp_v_no');

        $cp = $this->assign_voucher_values('cp', $cp_v_no + 1, $cp, $account_uid, $total_voucher_amount, $voucher_remarks, $user, $day_end, $status);

        // system config set increment default id according to user giving start coding
        $sstm_cnfg_clm = 'sc_cash_payment_voucher_number';
        $sstm_cnfg_bp_id_chk = SystemConfigModel::where('sc_clg_id', '=', $user->user_clg_id)->where($sstm_cnfg_clm, '!=', '0')->first();
        $chk_bnk_pymnt = CashPaymentVoucherModel::where('cp_clg_id', '=', $user->user_clg_id)->get();
        if ($chk_bnk_pymnt->isEmpty()):
            if (isset($sstm_cnfg_bp_id_chk) && !empty($sstm_cnfg_bp_id_chk)):
                $cp->cp_id = $sstm_cnfg_bp_id_chk->$sstm_cnfg_clm;
            endif;
        endif;
        // system config set increment default id according to user giving end coding


        if ($cp->save()) {
            $cp_id = $cp->cp_id;
            $cp_voucher_no = $cp->cp_v_no;
        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }

        $detail_remarks = '';

        $item = $this->voucher_items_values($accountsval, $cp_id, $cp_voucher_no, 'cpi');

        foreach ($item as $value) {
            $cpi_amount = (float)$value['cpi_amount'];

            $detail_remarks .= $value['cpi_account_name'] . ', @' . number_format($cpi_amount, 2) . config('global_variables.Line_Break');
        }

        if (!DB::table('financials_cash_payment_voucher_items')->insert($item)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }


        $cp->cp_detail_remarks = $detail_remarks;
        if (!$cp->save()) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }
        if ($status == 'post') {
            foreach ($accountsval as $key) {

                $transaction = new TransactionModel();

                $transaction = $this->AssignTransactionsValues($transaction, $key['account_code'], $key['account_amount'], $account_uid, $notes, $transaction_type, $cp_id);

                if ($transaction->save()) {

                    $transaction_id = $transaction->trans_id;

                    // Selected Accounts
                    $branch_id = $this->get_branch_id($key['account_code']);
                    $balances = new BalancesModel();

                    $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key['account_code'], $key['account_amount'], 'Dr', $key['account_remarks'],
                        $notes, $account_name_text . ' to ' . $key['account_name'] . ', @' . number_format($key['account_amount'], 2) . config('global_variables.Line_Break')
                        , $voucher_code . $cp_id, $key['posting_reference'], $voucher_code . $cp_voucher_no, $this->getYearEndId(), $branch_id);

                    if (!$balance->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed');
                    }

                    // Bank Account
                    $branch_id = $this->get_branch_id($account_uid);
                    $balances2 = new BalancesModel();

                    $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id, $account_uid, $key['account_amount'], 'Cr', $key['account_remarks'],
                        $notes, $account_name_text . ' to ' . $key['account_name'] . ', @' . number_format($key['account_amount'], 2) . config('global_variables.Line_Break'),
                        $voucher_code . $cp_id,
                        $key['posting_reference'], $voucher_code . $cp_voucher_no, $this->getYearEndId(), $branch_id);

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

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $cp->cp_id);
            DB::commit();
            return redirect()->back()->with(['cp_id' => $cp_id, 'success' => 'Successfully Saved']);
        }
    }

    // update code by shahzaib start
    public function cash_payment_vouchers_list(Request $request, $array = null, $str = null)
    {
        $cash_accounts = $this->get_fourth_level_account(config('global_variables.cash'), 0, 0);

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $search_cash_account = (isset($request->cash_account) && !empty($request->cash_account)) ? $request->cash_account : '';
        $prnt_page_dir = 'print.cash_payment_voucher_list.cash_payment_voucher_list';
        $pge_title = 'Cash Payment Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from, $search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $user = Auth::user();
//        $query = CashPaymentVoucherModel::query();
        $query = DB::table('financials_cash_payment_voucher')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_cash_payment_voucher.cp_createdby')
            ->where('cp_clg_id', '=', $user->user_clg_id);
        $ttl_amnt = $query->sum('cp_total_amount');

        if (!empty($request->search)) {
            $query->where('cp_total_amount', 'like', '%' . $search . '%')
                ->orWhere('cp_remarks', 'like', '%' . $search . '%')
                ->orWhere('cp_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('cp_createdby', $search_by_user);
        }

        if (!empty($search_cash_account)) {
            $query->where('cp_account_id', $search_cash_account);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('cp_day_end_date', [$start, $end]);
            $query->whereDate('cp_day_end_date', '>=', $start)
                ->whereDate('cp_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('cp_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('cp_day_end_date', $end);
        }
        if (!empty($search_year)) {
            $query->where('cp_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('cp_year_id', '=', $search_year);
        }

        $datas = $query->orderBy('cp_id', config('global_variables.query_sorting'))
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
            return view('cash_payment_voucher_list', compact('datas', 'search', 'search_to', 'search_year', 'search_from', 'ttl_amnt', 'search_by_user', 'cash_accounts', 'search_cash_account'));
        }
    }

    public function cash_payment_voucher_list(Request $request, $array = null, $str = null)
    {
        $cash_accounts = $this->get_fourth_level_account(config('global_variables.cash'), 0, 0);

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $search_cash_account = (isset($request->cash_account) && !empty($request->cash_account)) ? $request->cash_account : '';
        $prnt_page_dir = 'print.cash_payment_voucher_list.cash_payment_voucher_list';
        $pge_title = 'Cash Payment Voucher List';
        $srch_fltr = [];

        array_push($srch_fltr, $search, $search_to, $search_from, $search_year, $search_cash_account);


        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $user = Auth::user();
//        $query = CashReceiptVoucherModel::query();
        $query = DB::table('financials_cash_payment_voucher')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_cash_payment_voucher.cp_createdby')
            ->where('cp_clg_id', '=', $user->user_clg_id);
        $ttl_amnt = $query->sum('cp_total_amount');


        if (!empty($request->search)) {
            $query->where('cp_total_amount', 'like', '%' . $search . '%')
                ->orWhere('cp_remarks', 'like', '%' . $search . '%')
                ->orWhere('cp_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('cp_createdby', $search_by_user);
        }

        if (!empty($search_cash_account)) {
            $query->where('cp_account_id', $search_cash_account);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('cp_day_end_date', [$start, $end]);
            $query->whereDate('cp_day_end_date', '>=', $start)
                ->whereDate('cp_day_end_date', '<=', $end);

        } elseif (!empty($search_to)) {
            $query->where('cp_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('cp_day_end_date', $end);
        }

        if (!empty($search_year)) {
            $query->where('cp_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('cp_year_id', '=', $search_year);
        }
        $datas = $query->orderBy('cp_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';
            // dump($srch_fltr,$search_cash_account);
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
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'srch_fltr', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $search_year, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('cash_payment_voucher_list', compact('datas', 'search', 'search_to', 'search_year', 'search_from', 'ttl_amnt', 'cash_accounts', 'search_cash_account'));
        }

    }

    // update code by shahzaib end

    public function cash_payment_items_view_details(Request $request)
    {
        $items = CashPaymentVoucherItemsModel::where('cpi_cash_payment_voucher_id', $request->id)->orderby('cpi_account_name', 'ASC')->get();

        return response()->json($items);
    }

    public function cash_payment_items_view_details_SH(Request $request, $id)
    {
        $csh_pymnt = CashPaymentVoucherModel::with('user')->where('cp_id', $id)->first();
        $items = CashPaymentVoucherItemsModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_cash_payment_voucher_items.cpi_pr_id')->where('cpi_voucher_id',
            $id)->orderby('cpi_account_name', 'ASC')->get();
//        $cp_acnt_nme = AccountRegisterationModel::where('account_uid', config('global_variables.cash_in_hand'))->first();
        $cp_acnt_nme = AccountRegisterationModel::where('account_uid', $csh_pymnt->cp_account_id)->first();
        $nbrOfWrds = $this->myCnvrtNbr($csh_pymnt->cp_total_amount);
        $invoice_nbr = $csh_pymnt->cp_id;
//        $invoice_date = $csh_pymnt->cp_created_datetime;
        $invoice_date = $csh_pymnt->cp_day_end_date;
        $invoice_remarks = $csh_pymnt->cp_remarks;
        $type = 'grid';
        $pge_title = 'Cash Payment Voucher';


        return view('voucher_view.cash_payment_voucher.cash_payment_journal_voucher_list_modal', compact('items', 'csh_pymnt', 'nbrOfWrds', 'cp_acnt_nme', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));

    }

    public function cash_payment_items_view_details_pdf_SH(Request $request, $id)
    {
        $csh_pymnt = CashPaymentVoucherModel::with('user')->where('cp_id', $id)->first();
        $items = CashPaymentVoucherItemsModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_cash_payment_voucher_items.cpi_pr_id')->where('cpi_voucher_id', $id)->orderby('cpi_account_name', 'ASC')->get();
//        $cp_acnt_nme = AccountRegisterationModel::where('account_uid', config('global_variables.cash_in_hand'))->first();
        $cp_acnt_nme = AccountRegisterationModel::where('account_uid', $csh_pymnt->cp_account_id)->first();
        $nbrOfWrds = $this->myCnvrtNbr($csh_pymnt->cp_total_amount);
        $invoice_nbr = $csh_pymnt->cp_id;
//        $invoice_date = $csh_pymnt->cp_created_datetime;
        $invoice_date = $csh_pymnt->cp_day_end_date;
        $invoice_remarks = $csh_pymnt->cp_remarks;
        $type = 'pdf';
        $pge_title = 'Cash Payment Voucher';


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
        $pdf->loadView('voucher_view.cash_payment_voucher.cash_payment_journal_voucher_list_modal', compact('items', 'csh_pymnt', 'nbrOfWrds', 'cp_acnt_nme', 'type', 'invoice_nbr', 'invoice_date', 'pge_title', 'invoice_remarks'));
        // $pdf->setOptions($options);

        return $pdf->stream('Cash-Payment-Voucher-Detail.pdf');

    }

    // update code by mustafa start
    public function cash_payment_post_voucher_list(Request $request, $array = null, $str = null)
    {
        $cash_accounts = $this->get_fourth_level_account(config('global_variables.cash'), 0, 0);

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $search_cash_account = (isset($request->cash_account) && !empty($request->cash_account)) ? $request->cash_account : '';
        $prnt_page_dir = 'print.cash_payment_voucher_list.cash_payment_voucher_post_list';
        $pge_title = 'Post Cash Payment Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $user = Auth::user();
//        $query = CashPaymentVoucherModel::query();
        $query = DB::table('financials_cash_payment_voucher')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_cash_payment_voucher.cp_createdby')
            ->where('cp_status', '=', 'park')
            ->where('cp_clg_id', '=', $user->user_clg_id);
        $ttl_amnt = $query->sum('cp_total_amount');

        if (!empty($request->search)) {
            $query->where('cp_total_amount', 'like', '%' . $search . '%')
                ->orWhere('cp_remarks', 'like', '%' . $search . '%')
                ->orWhere('cp_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('cp_createdby', $search_by_user);
        }

        if (!empty($search_cash_account)) {
            $query->where('cp_account_id', $search_cash_account);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('cp_day_end_date', [$start, $end]);
            $query->whereDate('cp_day_end_date', '>=', $start)
                ->whereDate('cp_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('cp_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('cp_day_end_date', $end);
        }


        $datas = $query->orderBy('cp_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);


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
            return view('voucher_post_list.cash_payment_voucher_post_list', compact('datas', 'search', 'search_to', 'search_from', 'ttl_amnt', 'search_by_user', 'cash_accounts', 'search_cash_account'));
        }
    }

    // update code by mustafa end
    public function post_cash_payment_voucher($id, Request $request)
    {
        $cp_id = $id;
        $cash_voucher = CashPaymentVoucherModel::where('cp_id', '=', $cp_id)->first();
        $cash_voucher_items = CashPaymentVoucherItemsModel::where('cpi_voucher_id', '=', $cp_id)->get();
//        $this->voucher_validation($request);

        $rollBack = false;

        $user = Auth::user();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

//        $accountsval = json_decode($request->accountsval, true);

        $account_uid = $cash_voucher->cp_account_id;
        $account_name_text = $this->get_account_name($account_uid);
        $total_voucher_amount = $cash_voucher->cp_total_amount;
        $voucher_remarks = $cash_voucher->cp_remarks;
        $status = $cash_voucher->cp_status;


        $notes = 'CASH_PAYMENT_VOUCHER';
        $voucher_code = config('global_variables.CASH_PAYMENT_VOUCHER_CODE');
        $transaction_type = config('global_variables.CASH_PAYMENT');

        DB::beginTransaction();

//        $cp = new CashPaymentVoucherModel();
//
//        $cp = $this->assign_voucher_values('cp', $cp, $account_uid, $total_voucher_amount, $voucher_remarks, $user, $day_end, $status);
//
//
//        // system config set increment default id according to user giving start coding
//        $sstm_cnfg_clm = 'sc_cash_payment_voucher_number';
//        $sstm_cnfg_bp_id_chk = SystemConfigModel::where($sstm_cnfg_clm, '!=', '0')->first();
//        $chk_bnk_pymnt = CashPaymentVoucherModel::all();
//        if ($chk_bnk_pymnt->isEmpty()):
//            if (isset($sstm_cnfg_bp_id_chk) && !empty($sstm_cnfg_bp_id_chk)):
//                $cp->cp_id = $sstm_cnfg_bp_id_chk->$sstm_cnfg_clm;
//            endif;
//        endif;
        // system config set increment default id according to user giving end coding


//        if ($cp->save()) {
//            $cp_id = $cp->cp_id;
//        } else {
//            $rollBack = true;
//            DB::rollBack();
//            return redirect()->back()->with('fail', 'Failed');
//        }
//
//        $detail_remarks = '';
//
//        $item = $this->voucher_items_values($accountsval, $cp_id, 'cpi');
//
//        foreach ($item as $value) {
//            $cpi_amount = (float)$value['cpi_amount'];
//
//            $detail_remarks .= $value['cpi_account_name'] . ', @' . number_format($cpi_amount, 2) . config('global_variables.Line_Break');
//        }
//
//        if (!DB::table('financials_cash_payment_voucher_items')->insert($item)) {
//            $rollBack = true;
//            DB::rollBack();
//            return redirect()->back()->with('fail', 'Failed');
//        }
//
//
//        $cp->cp_detail_remarks = $detail_remarks;
//        if (!$cp->save()) {
//            $rollBack = true;
//            DB::rollBack();
//            return redirect()->back()->with('fail', 'Failed');
//        }
//        if ($status == 'post') {
        foreach ($cash_voucher_items as $key) {

            $transaction = new TransactionModel();

            $transaction = $this->AssignTransactionsValues($transaction, $key['cpi_account_id'], $key['cpi_amount'], $account_uid, $notes, $transaction_type, $cp_id);

            if ($transaction->save()) {

                $transaction_id = $transaction->trans_id;

                // Selected Accounts
                $branch_id = $this->get_branch_id($key['cpi_account_id']);
                $balances = new BalancesModel();

                $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key['cpi_account_id'], $key['cpi_amount'], 'Dr', $key['cpi_remarks'],
                    $notes, $account_name_text . ' to ' . $key['cpi_account_name'] . ', @' . number_format($key['cpi_amount'], 2) . config('global_variables.Line_Break')
                    , $voucher_code . $cp_id, $key['cpi_pr_id'], $voucher_code . $cash_voucher->cp_v_no, $this->getYearEndId(), $branch_id);

                if (!$balance->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed');
                }

                // Bank Account
                $branch_id = $this->get_branch_id($account_uid);
                $balances2 = new BalancesModel();

                $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id, $account_uid, $key['cpi_amount'], 'Cr', $key['cpi_remarks'],
                    $notes, $account_name_text . ' to ' . $key['cpi_account_name'] . ', @' . number_format($key['cpi_amount'], 2) . config('global_variables.Line_Break'),
                    $voucher_code . $cp_id,
                    $key['cpi_pr_id'], $voucher_code . $cash_voucher->cp_v_no, $this->getYearEndId(), $branch_id);

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
            $cash_voucher->cp_status = 'post';
            $cash_voucher->cp_posted_by = $user->user_id;
            $cash_voucher->save();
            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $cp_id);
            DB::commit();
            return redirect()->back()->with(['cp_id' => $cp_id, 'success' => 'Successfully Saved']);
        }


    }

    public function edit_cash_payment_voucher($id)
    {
        $voucher = CashPaymentVoucherModel::where('cp_id', '=', $id)->where('cp_status', '!=', 'post')->first();
        if ($voucher != null) {
            $voucher_items = CashPaymentVoucherItemsModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', '=', 'financials_cash_payment_voucher_items.cpi_pr_id')->where('cpi_voucher_id', '=', $id)
                ->select('financials_cash_payment_voucher_items.*', 'financials_posting_reference.pr_name as name')->get();

            return view('edit_voucher.edit_cash_payment_voucher', compact('voucher', 'voucher_items'));
        }
        return redirect()->back();
    }

    public function delete_cash_payment_voucher($id)
    {
        $user = Auth::user()->user_id;
        $delete = CashPaymentVoucherModel::where('cp_id', '=', $id)->where('cp_status', '!=', 'post')->first();
        $delete->cp_status = 'deleted';
        $delete->cp_posted_by = $user;
        $delete->save();
        return redirect()->back()->with('success', 'Deleted Successfully!');
    }

    public function update_cash_payment_voucher($id, Request $request)
    {
        $this->voucher_validation($request);
        CashPaymentVoucherItemsModel::where('cpi_voucher_id', $id)->delete();


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

        $notes = 'CASH_PAYMENT_VOUCHER';
        $voucher_code = config('global_variables.CASH_PAYMENT_VOUCHER_CODE');
        $transaction_type = config('global_variables.CASH_PAYMENT');

        DB::beginTransaction();

        $cp = CashPaymentVoucherModel::where('cp_id', $id)->first();

        $cp = $this->assign_voucher_values('cp', $cp->cp_v_no, $cp, $account_uid, $total_voucher_amount, $voucher_remarks, $user, $day_end, $status);

        // system config set increment default id according to user giving start coding
        $sstm_cnfg_clm = 'sc_cash_payment_voucher_number';
        $sstm_cnfg_bp_id_chk = SystemConfigModel::where('sc_clg_id', '=', $user->user_clg_id)->where($sstm_cnfg_clm, '!=', '0')->first();
        $chk_bnk_pymnt = CashPaymentVoucherModel::where('cp_clg_id', '=', $user->user_clg_id)->get();
        if ($chk_bnk_pymnt->isEmpty()):
            if (isset($sstm_cnfg_bp_id_chk) && !empty($sstm_cnfg_bp_id_chk)):
                $cp->cp_id = $sstm_cnfg_bp_id_chk->$sstm_cnfg_clm;
            endif;
        endif;
        // system config set increment default id according to user giving end coding


        if ($cp->save()) {
            $cp_id = $cp->cp_id;
            $cp_voucher_no = $cp->cp_v_no;
        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }

        $detail_remarks = '';

        $item = $this->voucher_items_values($accountsval, $cp_id, $cp_voucher_no, 'cpi');

        foreach ($item as $value) {
            $cpi_amount = (float)$value['cpi_amount'];

            $detail_remarks .= $value['cpi_account_name'] . ', @' . number_format($cpi_amount, 2) . config('global_variables.Line_Break');
        }

        if (!DB::table('financials_cash_payment_voucher_items')->insert($item)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }


        $cp->cp_detail_remarks = $detail_remarks;
        if (!$cp->save()) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }

        if ($rollBack) {

            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        } else {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $cp->cp_id);
            DB::commit();
            return redirect()->back()->with(['cp_id' => $cp_id, 'success' => 'Successfully Saved']);
        }

    }
}
