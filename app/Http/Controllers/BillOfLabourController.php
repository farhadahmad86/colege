<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountHeadsModel;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\BillOfLabourItemsModel;
use App\Models\BillOfLabourModel;
use App\Models\CashPaymentVoucherModel;
use App\Models\PostingReferenceModel;
use App\Models\SystemConfigModel;
use App\Models\TransactionModel;
use App\Models\UnitInfoModel;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class BillOfLabourController extends Controller
{
    public function bill_of_labour_voucher()
    {
        $accounts = DB::table('financials_accounts')
            ->where('account_delete_status', '!=', 1)
            ->where('account_disabled', '!=', 1)
            ->select('account_uid', 'account_name')
            ->where('account_uid', 'like', '4%')
            ->get();
        $cash_accounts = DB::table('financials_accounts')
            ->where('account_delete_status', '!=', 1)
            ->where('account_disabled', '!=', 1)
            ->select('account_uid', 'account_name')
            ->where('account_uid', 'like', '21010%')
            ->orWhere('account_uid', 'like', '11013%')
            ->get();


        $units = UnitInfoModel::all();

        return view('Bill_Of_Labour.add_bill_of_labour', compact('accounts', 'cash_accounts', 'units'));

    }

    public function submit_bill_of_labour_voucher(Request $request)
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

        $notes = 'BILL_OF_LABOUR_VOUCHER';
        $voucher_code = config('global_variables.BILL_OF_LABOUR_VOUCHER_CODE');
        $transaction_type = config('global_variables.BILL_OF_LABOUR');

        DB::beginTransaction();

        $bl = new BillOfLabourModel();
        $bl_v_no = BillOfLabourModel::where('bl_clg_id', $user->user_clg_id)->max('bl_v_no');

        $bl = $this->assign_voucher_values('bl', $bl_v_no + 1, $bl, $account_uid, $total_voucher_amount, $voucher_remarks, $user, $day_end, $status);

        // system config set increment default id according to user giving start coding
        $sstm_cnfg_clm = 'sc_bill_of_labour_voucher_number';
        $sstm_cnfg_bp_id_chk = SystemConfigModel::where('sc_clg_id', '=', $user->user_clg_id)->where($sstm_cnfg_clm, '!=', '0')->first();
        $chk_bnk_pymnt = BillOfLabourModel::where('bl_clg_id', '=', $user->user_clg_id)->get();
        if ($chk_bnk_pymnt->isEmpty()):
            if (isset($sstm_cnfg_bp_id_chk) && !empty($sstm_cnfg_bp_id_chk)):
                $bl->bl_id = $sstm_cnfg_bp_id_chk->$sstm_cnfg_clm;
            endif;
        endif;
        // system config set increment default id according to user giving end coding


        if ($bl->save()) {

            $bl_id = $bl->bl_id;
            $bl_voucher_no = $bl->bl_v_no;

        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }

        $detail_remarks = '';

        $item = $this->bill_voucher_items_values($accountsval, $bl_id, $bl_voucher_no, 'bli');

        foreach ($item as $value) {
            $bli_amount = (float)$value['bli_amount'];
            $bli_rate = (float)$value['bli_rate'];
            $bli_qty = (float)$value['bli_qty'];

            $detail_remarks .= $value['bli_account_name'] . ' ' . ' @' . number_format($bli_rate, 2) . ' QTY ' . number_format($bli_qty, 2) . ' ' . $value['bli_uom']
                . ' = ' .
                number_format($bli_amount, 2) . config('global_variables.Line_Break');
        }

        if (!DB::table('financials_bill_of_labour_items')->insert($item)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }


        $bl->bl_detail_remarks = $detail_remarks;
        if (!$bl->save()) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }
        if ($status == 'post') {
            foreach ($accountsval as $key) {

                $transaction = new TransactionModel();

                $transaction = $this->AssignTransactionsValues($transaction, $key['account_code'], $key['account_amount'], $account_uid, $notes, $transaction_type, $bl_id);

                if ($transaction->save()) {

                    $transaction_id = $transaction->trans_id;

                    // Selected Accounts
                    $branch_id = $this->get_branch_id($key['account_code']);
                    $balances = new BalancesModel();

                    $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key['account_code'], $key['account_amount'], 'Dr', $key['account_remarks'],
                        $notes, $account_name_text . ' to ' . $key['account_name'] . ' ' . $key['account_remarks'] . ', @' . number_format($key['rate'], 2) . ' QTY ' . number_format($key['qty'],
                            2) . ' ' . $key['uom_text'] . ', = ' . number_format($key['account_amount'], 2) . config('global_variables.Line_Break')
                        , $voucher_code . $bl_id, $key['posting_reference'], $voucher_code . $bl_voucher_no, $this->getYearEndId(), $branch_id);

                    if (!$balance->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed');
                    }

                    // Bank Account
                    $branch_id = $this->get_branch_id($account_uid);
                    $balances2 = new BalancesModel();

                    $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id, $account_uid, $key['account_amount'], 'Cr', $key['account_remarks'],
                        $notes, $account_name_text . ' to ' . $key['account_name'] . ' ' . $key['account_remarks'] . ', @' . number_format($key['rate'], 2) . ' QTY ' . number_format($key['qty'],
                            2) . ' ' . $key['uom_text'] . ', = ' . number_format($key['account_amount'], 2) . config('global_variables.Line_Break'),
                        $voucher_code . $bl_id,
                        $key['posting_reference'], $voucher_code . $bl_voucher_no, $this->getYearEndId(), $branch_id);

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

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $bl->bl_id);
            DB::commit();
            return redirect()->back()->with(['bl_id' => $bl_id, 'success' => 'Successfully Saved']);
        }
    }

    public function bill_voucher_items_values($values_array, $voucher_number, $v_number, $prfx)
    {
        $data = [];

        $voucher_id = $prfx . '_voucher_id';
        $voucher_no = $prfx . '_v_no';
        $account_id = $prfx . '_account_id';
        $account_name = $prfx . '_account_name';
        $qty = $prfx . '_qty';
        $rate = $prfx . '_rate';
        $amount = $prfx . '_amount';
        $remarks = $prfx . '_remarks';
        $posting_reference = $prfx . '_pr_id';
        $uom_id = $prfx . '_uom_id';
        $uom = $prfx . '_uom';

        foreach ($values_array as $key) {

            $unit_tile = UnitInfoModel::where('unit_id', $key['uom_id'])->pluck('unit_title')->first();
            $data[] = [
                $voucher_id => $voucher_number,
                $voucher_no => $v_number,
                $account_id => $key['account_code'],
                $account_name => $key['account_name'],
                $qty => $key['qty'],
                $rate => $key['rate'],
                $amount => $key['account_amount'],
                $remarks => ucfirst($key['account_remarks']),
                $posting_reference => $key['posting_reference'],
                $uom_id => $key['uom_id'],
                $uom => $unit_tile,
            ];
        }

        return $data;
    }

    // update code by shahzaib start
    public function bill_of_labour_voucher_list(Request $request, $array = null, $str = null)
    {
        $cash_accounts = $this->get_fourth_level_account(config('global_variables.cash'), 0, 0);

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $search_cash_account = (isset($request->cash_account) && !empty($request->cash_account)) ? $request->cash_account : '';
        $prnt_page_dir = 'print.bill_of_labour_voucher_list.bill_of_labour_voucher_list';
        $pge_title = 'Bill Of Labour Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from, $search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));


//        $query = CashPaymentVoucherModel::query();
        $query = DB::table('financials_bill_of_labour')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_bill_of_labour.bl_createdby');
        $ttl_amnt = $query->sum('bl_total_amount');

        if (!empty($request->search)) {
            $query->where('bl_total_amount', 'like', '%' . $search . '%')
                ->orWhere('bl_remarks', 'like', '%' . $search . '%')
                ->orWhere('bl_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('bl_createdby', $search_by_user);
        }

        if (!empty($search_cash_account)) {
            $query->where('bl_account_id', $search_cash_account);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('cp_day_end_date', [$start, $end]);
            $query->whereDate('bl_day_end_date', '>=', $start)
                ->whereDate('bl_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('bl_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('bl_day_end_date', $end);
        }
        if (!empty($search_year)) {
            $query->where('bl_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('bl_year_id', '=', $search_year);
        }

        $datas = $query->orderBy('bl_id', config('global_variables.query_sorting'))
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
            return view('Bill_Of_Labour.bill_of_labour_list', compact('datas', 'search', 'search_year', 'search_to', 'search_from', 'ttl_amnt', 'search_by_user', 'cash_accounts', 'search_cash_account'));
        }
    }

    // update code by shahzaib end


    public function bill_of_labour_items_view_details(Request $request)
    {
        $items = BillOfLabourItemsModel::with('user')->where('bli_voucher_id', $request->id)->orderby('bli_account_name', 'ASC')->get();

        return response()->json($items);
    }

    public function bill_of_labour_items_view_details_SH(Request $request, $id)
    {
        $csh_pymnt = BillOfLabourModel::with('user')->where('bl_id', $id)->first();
        $items = BillOfLabourItemsModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_bill_of_labour_items.bli_pr_id')->where('bli_voucher_id', $id)->orderby('bli_account_name', 'ASC')->get();

//        $bl_acnt_nme = AccountRegisterationModel::where('account_uid', config('global_variables.cash_in_hand'))->first();
        $bl_acnt_nme = AccountRegisterationModel::where('account_uid', $csh_pymnt->bl_account_id)->first();
        $nbrOfWrds = $this->myCnvrtNbr($csh_pymnt->bl_total_amount);
        $invoice_nbr = $csh_pymnt->bl_id;
//        $invoice_date = $csh_pymnt->bl_created_datetime;
        $invoice_date = $csh_pymnt->bl_day_end_date;
        $invoice_remarks = $csh_pymnt->bl_remarks;
        $type = 'grid';
        $pge_title = 'Bill Of Labour Voucher';


        return view('voucher_view.bill_of_labour_voucher.bill_of_labour_voucher_list_modal', compact('items', 'csh_pymnt', 'nbrOfWrds', 'bl_acnt_nme', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));

    }

    public function bill_of_labour_items_view_details_pdf_SH(Request $request, $id)
    {
        $csh_pymnt = BillOfLabourModel::where('bl_id', $id)->first();
        $items = BillOfLabourItemsModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_bill_of_labour_items.bli_pr_id')->where('bli_voucher_id',
            $id)->orderby('bli_account_name', 'ASC')->get();
//        $bl_acnt_nme = AccountRegisterationModel::where('account_uid', config('global_variables.cash_in_hand'))->first();
        $bl_acnt_nme = AccountRegisterationModel::where('account_uid', $csh_pymnt->bl_account_id)->first();
        $nbrOfWrds = $this->myCnvrtNbr($csh_pymnt->bl_total_amount);
        $invoice_nbr = $csh_pymnt->bl_id;
//        $invoice_date = $csh_pymnt->bl_created_datetime;
        $invoice_date = $csh_pymnt->bl_day_end_date;
        $invoice_remarks = $csh_pymnt->bl_remarks;
        $type = 'pdf';
        $pge_title = 'Bill Of Labour Voucher';


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
        $pdf->loadView('voucher_view.bill_of_labour_voucher.bill_of_labour_voucher_list_modal', compact('items', 'csh_pymnt', 'nbrOfWrds', 'bl_acnt_nme', 'type', 'invoice_nbr', 'invoice_date', 'pge_title', 'invoice_remarks'));
        // $pdf->setOptions($options);

        return $pdf->stream('Cash-Payment-Voucher-Detail.pdf');

    }

    public function edit_bill_of_labour($id)
    {
        $voucher = BillOfLabourModel::where('bl_id', $id)->where('bl_status', '!=', 'post')->first();

        if ($voucher != null) {
            $voucher_items = BillOfLabourItemsModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', '=', 'financials_bill_of_labour_items.bli_pr_id')->where('bli_voucher_id', '=', $id)->select('financials_bill_of_labour_items.*', 'financials_posting_reference.pr_name as name')->get();

            $accounts = DB::table('financials_accounts')
                ->where('account_delete_status', '!=', 1)
                ->where('account_disabled', '!=', 1)
                ->select('account_uid', 'account_name')
                ->where('account_uid', 'like', '4%')
                ->get();
            $cash_accounts = DB::table('financials_accounts')
                ->where('account_delete_status', '!=', 1)
                ->where('account_disabled', '!=', 1)
                ->select('account_uid', 'account_name')
                ->where('account_uid', 'like', '21010%')
                ->orWhere('account_uid', 'like', '11013%')
                ->get();

            $units = UnitInfoModel::all();
            return view('Bill_Of_Labour.edit_bill_of_labour', compact('voucher', 'voucher_items', 'accounts', 'cash_accounts', 'units'));
        }
        return redirect()->back();
    }

    public function update_bill_of_labour_voucher($id, Request $request)
    {
        $this->voucher_validation($request);
        BillOfLabourItemsModel::where('bli_voucher_id', $id)->delete();
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

        $notes = 'BILL_OF_LABOUR_VOUCHER';
        $voucher_code = config('global_variables.BILL_OF_LABOUR_VOUCHER_CODE');
        $transaction_type = config('global_variables.BILL_OF_LABOUR');

        DB::beginTransaction();

        $bl = BillOfLabourModel::where('bl_id', $id)->first();

        $bl = $this->assign_voucher_values('bl', $bl->bl_v_no, $bl, $account_uid, $total_voucher_amount, $voucher_remarks, $user, $day_end, $status);


        // system config set increment default id according to user giving start coding
        $sstm_cnfg_clm = 'sc_bill_of_labour_voucher_number';
        $sstm_cnfg_bp_id_chk = SystemConfigModel::where($sstm_cnfg_clm, '!=', '0')->first();
        $chk_bnk_pymnt = BillOfLabourModel::all();
        if ($chk_bnk_pymnt->isEmpty()):
            if (isset($sstm_cnfg_bp_id_chk) && !empty($sstm_cnfg_bp_id_chk)):
                $bl->bl_id = $sstm_cnfg_bp_id_chk->$sstm_cnfg_clm;
            endif;
        endif;
        // system config set increment default id according to user giving end coding


        if ($bl->save()) {

            $bl_id = $bl->bl_id;

        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }

        $detail_remarks = '';

        $item = $this->bill_voucher_items_values($accountsval, $bl_id, 'bli');

        foreach ($item as $value) {
            $bli_amount = (float)$value['bli_amount'];
            $bli_rate = (float)$value['bli_rate'];
            $bli_qty = (float)$value['bli_qty'];

            $detail_remarks .= $value['bli_account_name'] . ' ' . ' @' . number_format($bli_rate, 2) . ' QTY ' . number_format($bli_qty, 2) . ' ' . $value['bli_uom']
                . ' = ' .
                number_format($bli_amount, 2) . config('global_variables.Line_Break');
        }

        if (!DB::table('financials_bill_of_labour_items')->insert($item)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }


        $bl->bl_detail_remarks = $detail_remarks;
        if (!$bl->save()) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }

        if ($rollBack) {

            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        } else {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $bl->bl_id);
            DB::commit();
            return redirect()->route('bill_of_labour_voucher_list')->with(['bl_id' => $bl_id, 'success' => 'Successfully Saved']);
        }

    }

    // update code by mustafa start
    public function bill_of_labour_post_voucher_list(Request $request, $array = null, $str = null)
    {
        $cash_accounts = $this->get_fourth_level_account(config('global_variables.cash'), 0, 0);

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $search_cash_account = (isset($request->cash_account) && !empty($request->cash_account)) ? $request->cash_account : '';
        $prnt_page_dir = 'print.bill_of_labour_voucher_list.bill_of_labour_voucher_list';
        $pge_title = 'Bill Of Labour Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));


//        $query = CashPaymentVoucherModel::query();
        $query = DB::table('financials_bill_of_labour')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_bill_of_labour.bl_createdby')
            ->where('bl_status', '=', 'park');
        $ttl_amnt = $query->sum('bl_total_amount');

        if (!empty($request->search)) {
            $query->where('bl_total_amount', 'like', '%' . $search . '%')
                ->orWhere('bl_remarks', 'like', '%' . $search . '%')
                ->orWhere('bl_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('bl_createdby', $search_by_user);
        }

        if (!empty($search_cash_account)) {
            $query->where('bl_account_id', $search_cash_account);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('cp_day_end_date', [$start, $end]);
            $query->whereDate('bl_day_end_date', '>=', $start)
                ->whereDate('bl_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('bl_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('bl_day_end_date', $end);
        }


        $datas = $query->orderBy('bl_id', config('global_variables.query_sorting'))
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
//            $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('Bill_Of_Labour.post_bill_of_labour_list', compact('datas', 'search', 'search_to', 'search_from', 'ttl_amnt', 'search_by_user', 'cash_accounts', 'search_cash_account'));
        }
    }

    // update code by mustafa end

    public function post_bill_of_labour_voucher($id, Request $request)
    {
        $rollBack = false;

        $user = Auth::user();
        $bl_id = $id;
        $bl = BillOfLabourModel::where('bl_id', '=', $bl_id)->first();
        $bill_voucher_items = BillOfLabourItemsModel::where('bli_voucher_id', '=', $bl_id)->get();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $account_uid = $bl->bl_account_id;
        $account_name_text = $this->get_account_name($account_uid);
        $total_voucher_amount = $bl->bl_total_amount;
        $voucher_remarks = $bl->bl_remarks;
        $status = $bl->bl_status;

        $notes = 'BILL_OF_LABOUR_VOUCHER';
        $voucher_code = config('global_variables.BILL_OF_LABOUR_VOUCHER_CODE');
        $transaction_type = config('global_variables.BILL_OF_LABOUR');

        DB::beginTransaction();

        foreach ($bill_voucher_items as $key) {

            $transaction = new TransactionModel();

            $transaction = $this->AssignTransactionsValues($transaction, $key['bli_account_id'], $key['bli_amount'], $account_uid, $notes, $transaction_type, $bl_id);

            if ($transaction->save()) {

                $transaction_id = $transaction->trans_id;

                // Selected Accounts
                $branch_id = $this->get_branch_id($key['account_code']);
                $balances = new BalancesModel();

                $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key['bli_account_id'], $key['bli_amount'], 'Dr', $key['bli_remarks'],
                    $notes, $account_name_text . ' to ' . $key['bli_account_name'] . ' ' . $key['bli_remarks'] . ', @' . number_format($key['bli_rate'], 2) . ' QTY ' . number_format($key['bli_qty'],
                        2) . ' ' . $key['bli_uom'] . ', = ' . number_format($key['bli_amount'], 2) . config('global_variables.Line_Break')
                    , $voucher_code . $bl_id, $key['bli_pr_id'], $voucher_code . $bl->bl_v_no, $this->getYearEndId(), $branch_id);

                if (!$balance->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed');
                }

                // Bank Account
                $branch_id = $this->get_branch_id($account_uid);
                $balances2 = new BalancesModel();

                $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id, $account_uid, $key['bli_amount'], 'Cr', $key['bli_remarks'],
                    $notes, $account_name_text . ' to ' . $key['bli_account_name'] . ' ' . $key['bli_remarks'] . ', @' . number_format($key['bli_rate'], 2) . ' QTY ' . number_format($key['bli_qty'],
                        2) . ' ' . $key['bli_uom'] . ', = ' . number_format($key['bli_amount'], 2) . config('global_variables.Line_Break'),
                    $voucher_code . $bl_id,
                    $key['bli_pr_id'], $voucher_code . $bl->bl_v_no, $this->getYearEndId(), $branch_id);

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
            $bl->bl_status = 'post';
            $bl->bl_posted_by = $user->user_id;
            $bl->save();
            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $bl->bl_id);
            DB::commit();
            return redirect()->back()->with(['bl_id' => $bl_id, 'success' => 'Successfully Posted']);
        }
    }


    // update code by mustafa start
    public function bill_of_labour_voucher_posting_ref_list(Request $request, $array = null, $str = null)
    {

        $accounts = DB::table('financials_accounts')
            ->where('account_delete_status', '!=', 1)
            ->where('account_disabled', '!=', 1)
            ->select('account_uid', 'account_name')
            ->where('account_uid', 'like', '4%')
            ->get();
        $posting_references = PostingReferenceModel::all();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_account = (!isset($request->account) && empty($request->account)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->account;
        $search_posting_reference = (!isset($request->posting_reference) && empty($request->posting_reference)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->posting_reference;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->from;
        $prnt_page_dir = 'print.bill_of_labour_voucher_list.bill_of_labour_voucher_list';
        $pge_title = 'Bill Of Labour Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_account, $search_posting_reference, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));


//        $query = CashPaymentVoucherModel::query();

        $query = DB::table('financials_bill_of_labour_items')
            ->leftJoin('financials_bill_of_labour', 'financials_bill_of_labour.bl_id', '=', 'financials_bill_of_labour_items.bli_voucher_id')
            ->leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', '=', 'financials_bill_of_labour_items.bli_pr_id');


        if (!empty($request->search)) {
            $query->where('bli_amount', 'like', '%' . $search . '%')
                ->orWhere('bli_remarks', 'like', '%' . $search . '%')
                ->orWhere('bli_id', 'like', '%' . $search . '%')
                ->orWhere('bli_account_id', 'like', '%' . $search . '%');
        }
        $bill_query = BillOfLabourModel::query();
        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereDate('bl_day_end_date', '>=', $start)
                ->whereDate('bl_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('bl_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('bl_day_end_date', $end);
        }
//        $bill_ids = $bill_query->pluck('bl_id');
//        $query->whereIn('bli_voucher_id', $bill_ids);
        if (!empty($search_account)) {
            $query->where('bli_account_id', $search_account);
        }
        if (!empty($search_posting_reference)) {
            $query->where('bli_pr_id', $search_posting_reference);
        }

        $ttl_amnt = $query->sum('bli_amount');
        $datas = $query->orderBy('bli_id', config('global_variables.query_sorting'))
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
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('Bill_Of_Labour.bill_of_labour_posting_reference_list', compact('datas', 'posting_references', 'search', 'search_to', 'search_from', 'ttl_amnt', 'search_posting_reference', 'accounts', 'search_account'));
        }
    }

    // update code by mustafa end

}
