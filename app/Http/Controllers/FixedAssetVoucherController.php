<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\CashReceiptVoucherItemsModel;
use App\Models\CashReceiptVoucherModel;
use App\Models\FixedAssetModel;
use App\Models\FixedAssetVoucherItemsModel;
use App\Models\FixedAssetVoucherModel;
use App\Models\SystemConfigModel;
use App\Models\TransactionModel;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class FixedAssetVoucherController extends Controller
{
    public function fixed_asset_voucher()
    {
        $user = Auth::user();
        $fixedAssetAccountList = array();
        $fixed_accounts = FixedAssetModel::where('fa_clg_id', $user->user_clg_id)->get();
        foreach ($fixed_accounts as $fixed_account) {
            $depAccounts = explode(',', $fixed_account['fa_link_account_uids']);
            $depAssetAccountUID = $depAccounts[0];
            $account = AccountRegisterationModel::where('account_clg_id', $user->user_clg_id)->where('account_uid', $depAssetAccountUID)->first();
            $controlCode = $account['account_uid'];
            $controlName = $account['account_name'];

            $fixedAssetAccountList[$controlCode] =
                array('code' => $controlCode, 'name' => "$controlName", 'balance' => $fixed_account->fa_temp_residual_value);
        }


        $accounts_head = explode(',', config('global_variables.cash') . ',' . config('global_variables.bank_head') . ',' . config('global_variables.payable') . ',' . config('global_variables.suspense') . ',' . config('global_variables.suspense_lib') . ',' . 51010);

        $accounts = AccountRegisterationModel::
        whereIn('account_parent_code', $accounts_head)
            ->where('account_clg_id', $user->user_clg_id)->select('account_uid', 'account_name')->get();
        return view('fixed_asset_account_voucher.fixed_asset_voucher', compact('accounts', 'fixedAssetAccountList'));
    }

    public function submit_fixed_asset_voucher(Request $request)
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

        $notes = 'FIXED_ASSET_VOUCHER';
        $voucher_code = config('global_variables.FIXED_ASSET_VOUCHER_CODE');
        $transaction_type = config('global_variables.FIXED_ASSET');

        DB::beginTransaction();

        $fav = new FixedAssetVoucherModel();
        $fav_v_no = FixedAssetVoucherModel::where('fav_clg_id', $user->user_clg_id)->count();

        $fav = $this->assign_voucher_values('fav', $fav_v_no + 1, $fav, $account_uid, $total_voucher_amount, $voucher_remarks, $user, $day_end, $status);


        // system config set increment default id according to user giving start coding
        $sstm_cnfg_clm = 'sc_fixed_asset_voucher_number';
        $sstm_cnfg_bp_id_chk = SystemConfigModel::where($sstm_cnfg_clm, '!=', '0')->first();
        $chk_bnk_pymnt = FixedAssetVoucherModel::all();
        if ($chk_bnk_pymnt->isEmpty()):
            if (isset($sstm_cnfg_bp_id_chk) && !empty($sstm_cnfg_bp_id_chk)):
                $fav->fav_id = $sstm_cnfg_bp_id_chk->$sstm_cnfg_clm;
            endif;
        endif;
        // system config set increment default id according to user giving end coding


        if ($fav->save()) {
            $fav_id = $fav->fav_id;
            $fav_voucher_no = $fav->fav_v_no;
        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }

        $detail_remarks = '';

        $item = $this->voucher_items_values($accountsval, $fav_id, $fav_voucher_no, 'favi');

        foreach ($item as $value) {
            $favi_amount = (float)$value['favi_amount'];

            $detail_remarks .= $value['favi_account_name'] . ', @' . number_format($favi_amount, 2) . config('global_variables.Line_Break');
        }

        if (!DB::table('financials_fixed_asset_voucher_items')->insert($item)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }


        $fav->fav_detail_remarks = $detail_remarks;
        if (!$fav->save()) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }
//        if ($status == 'post') {
        foreach ($accountsval as $key) {

            $transaction = new TransactionModel();

            $transaction = $this->AssignTransactionsValues($transaction, $account_uid, $key['account_amount'], $key['account_code'], $notes, $transaction_type, $fav_id);

            if ($transaction->save()) {

                $transaction_id = $transaction->trans_id;

                // Selected Accounts
                $branch_id = $this->get_branch_id($key['account_code']);
                $balances = new BalancesModel();

                $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key['account_code'], $key['account_amount'], 'Cr', $key['account_remarks'],
                    $notes, $account_name_text . ' to ' . $key['account_name'] . ', @' . number_format($key['account_amount'], 2) . config('global_variables.Line_Break'), $voucher_code .
                    $fav_id,
                    $key['posting_reference'], $voucher_code . $fav_voucher_no, $this->getYearEndId(), $branch_id);

                if (!$balance->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed');
                }

                // Bank Account
                $branch_id = $this->get_branch_id($account_uid);
                $balances2 = new BalancesModel();

                $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id, $account_uid, $key['account_amount'], 'Dr', $key['account_remarks'],
                    $notes, $account_name_text . ' to ' . $key['account_name'] . ', @' . number_format($key['account_amount'], 2) . config('global_variables.Line_Break'), $voucher_code . $fav_id,
                    $key['posting_reference'], $voucher_code . $fav_voucher_no, $this->getYearEndId(), $branch_id);

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

            $fixed_account = FixedAssetModel::where('fa_clg_id', $user->user_clg_id)->where('fa_link_account_uids', 'like', $request->account . '%')->first();
            if ($fixed_account->fa_status == 0) {
                $fixed_account->fa_status = $fixed_account->fa_status + 1;
                $fixed_account->fa_temp_residual_value = 0;
                $fixed_account->fa_book_value = $request->total_amount;
                $fixed_account->fa_price = $request->total_amount;
                $fixed_account->save();
            } else {
                $fixed_account->fa_status = $fixed_account->fa_status + 1;
                $fixed_account->fa_temp_residual_value = 0;
                $fixed_account->fa_book_value = $fixed_account->fa_book_value + $request->total_amount;
                $fixed_account->fa_price = $fixed_account->fa_price + $request->total_amount;
                $fixed_account->save();
            }

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $fav->fav_id);
            DB::commit();
            return redirect()->back()->with(['fav_id' => $fav_id, 'success' => 'Successfully Saved']);
        }
    }

    // update code by shahzaib start
    public function fixed_asset_voucher_list(Request $request, $array = null, $str = null)
    {
        $fixedAssetAccountList = array();
        $fixed_accounts = FixedAssetModel::get();
        foreach ($fixed_accounts as $fixed_account) {
            $depAccounts = explode(',', $fixed_account['fa_link_account_uids']);
            $depAssetAccountUID = $depAccounts[0];
            $account = AccountRegisterationModel::where('account_uid', $depAssetAccountUID)->first();
            $controlCode = $account['account_uid'];
            $controlName = $account['account_name'];

            $fixedAssetAccountList[$controlCode] =
                array('code' => $controlCode, 'name' => "$controlName");
        }


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_fixed_account = (isset($request->fixed_account) && !empty($request->fixed_account)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->fixed_account;
        $search_year = (isset($request->year) && !empty($request->year)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';

        $prnt_page_dir = 'print.fixed_asset_voucher_list.fixed_asset_voucher_list';
        $pge_title = 'Fixed Asset Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from, $search_fixed_account, $search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $user = Auth::user();
//        $query = CashReceiptVoucherModel::query();
        $query = DB::table('financials_fixed_asset_voucher')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_fixed_asset_voucher.fav_createdby')
            ->where('fav_clg_id', $user->user_clg_id);
        $ttl_amnt = $query->sum('fav_total_amount');


        if (!empty($request->search)) {
            $query->where('fav_total_amount', 'like', '%' . $search . '%')
                ->orWhere('fav_remarks', 'like', '%' . $search . '%')
                ->orWhere('fav_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('fav_createdby', $search_by_user);
        }

        if (!empty($search_fixed_account)) {
            $query->where('fav_account_id', $search_fixed_account);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('fav_day_end_date', [$start, $end]);
            $query->whereDate('fav_day_end_date', '>=', $start)
                ->whereDate('fav_day_end_date', '<=', $end);

        } elseif (!empty($search_to)) {
            $query->where('fav_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('fav_day_end_date', $end);
        }

        if (!empty($search_year)) {
            $query->where('fav_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('fav_year_id', '=', $search_year);
        }
        $datas = $query->orderBy('fav_id', config('global_variables.query_sorting'))
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
            return view('fixed_asset_account_voucher.fixed_asset_voucher_list', compact('datas', 'search', 'search_year', 'search_to', 'search_from', 'ttl_amnt', 'fixedAssetAccountList', 'search_fixed_account'));
        }

    }

    // update code by shahzaib end

    public function fixed_asset_items_view_details(Request $request)
    {
        $items = FixedAssetVoucherItemsModel::where('favi_voucher_id', $request->id)->orderby('favi_account_name', 'ASC')->get();

        return response()->json($items);
    }

    public function fixed_asset_items_view_details_SH(Request $request, $id)
    {

        $csh_rcpt = FixedAssetVoucherModel::with('user')->where('fav_id', $id)->first();
        $items = FixedAssetVoucherItemsModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_fixed_asset_voucher_items.favi_pr_id')
            ->where('favi_voucher_id', $id)->orderby('favi_account_name', 'ASC')->get();
        $cr_acnt_nme = AccountRegisterationModel::where('account_uid', $csh_rcpt->fav_account_id)->first();
        $nbrOfWrds = $this->myCnvrtNbr($csh_rcpt->fav_total_amount);
        $invoice_nbr = $csh_rcpt->fav_id;
//        $invoice_date = $csh_rcpt->fav_created_datetime;
        $invoice_date = $csh_rcpt->fav_day_end_date;
        $invoice_remarks = $csh_rcpt->fav_remarks;
        $type = 'grid';
        $pge_title = 'Fixed Asset Voucher';

        return view('voucher_view.fixed_asset_voucher.fixed_asset_journal_voucher_list_modal', compact('items', 'csh_rcpt', 'nbrOfWrds', 'cr_acnt_nme', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'))->render();

    }

    public function fixed_asset_items_view_details_pdf_SH(Request $request, $id)
    {

        $csh_rcpt = FixedAssetVoucherModel::with('user')->where('fav_id', $id)->first();
        $items = FixedAssetVoucherItemsModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_fixed_asset_voucher_items.favi_pr_id')->where
        ('favi_voucher_id', $id)->orderby('favi_account_name', 'ASC')->get();
        $cr_acnt_nme = AccountRegisterationModel::where('account_uid', $csh_rcpt->fav_account_id)->first();
        $nbrOfWrds = $this->myCnvrtNbr($csh_rcpt->fav_total_amount);
        $invoice_nbr = $csh_rcpt->fav_id;
//        $invoice_date = $csh_rcpt->cr_created_datetime;
        $invoice_date = $csh_rcpt->fav_day_end_date;
        $invoice_remarks = $csh_rcpt->fav_remarks;
        $type = 'pdf';
        $pge_title = 'Fixed Asset Voucher';


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
        $pdf->loadView('voucher_view.fixed_asset_voucher.fixed_asset_journal_voucher_list_modal', compact('items', 'csh_rcpt', 'nbrOfWrds', 'cr_acnt_nme', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));
        // $pdf->setOptions($options);


        return $pdf->stream('Fixed-Asset-Voucher-Detail.pdf');

    }
}
