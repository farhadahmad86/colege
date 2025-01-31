<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountRegisterationModel;
use App\Models\ProductModel;
use App\Models\PurchaseInvoiceItemsModel;
use Illuminate\Support\Facades\Auth;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TodayReportController extends Controller
{
    // update code by Mustafa start
    public function today_report_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $heads = config('global_variables.payable_receivable_cash');
        $heads = explode(',', $heads);

        $accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)->where('account_clg_id', '=', $user->user_clg_id)->orderBy('account_name', 'ASC')->get();
        $products = ProductModel::where('pro_clg_id', '=', $user->user_clg_id)->orderBy('pro_id', 'ASC')->get();

        $pro_code = '';
        $pro_name = '';

        $ar = json_decode($request->array);
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->from;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;

        $prnt_page_dir = 'print.today_report_list.today_report_list';
        $pge_title = 'Daily Activity Report';
        $srch_fltr = [];

        array_push($srch_fltr, $search_from, $search_to);

        $start = date('Y-m-d', strtotime($search_from));
        $end = date('Y-m-d', strtotime($search_to));

        $today_date = Carbon::now();

        $query = DB::table('financials_purchase_invoice')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_purchase_invoice.pi_createdby')
            ->where('pi_clg_id', '=', $user->user_clg_id);

        $query_sale = DB::table('financials_sale_invoice')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_sale_invoice.si_createdby')
            ->where('si_clg_id', '=', $user->user_clg_id);

        $query_crv = DB::table('financials_cash_receipt_voucher')
            ->leftJoin('financials_cash_receipt_voucher_items', 'financials_cash_receipt_voucher_items.cri_voucher_id', 'financials_cash_receipt_voucher.cr_id')
            ->leftJoin('financials_accounts', 'financials_accounts.account_uid', 'financials_cash_receipt_voucher_items.cri_account_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_cash_receipt_voucher.cr_createdby')
            ->where('account_clg_id', '=', $user->user_clg_id)
            ->where('cr_clg_id', '=', $user->user_clg_id);

        $query_cp = DB::table('financials_cash_payment_voucher')
            ->leftJoin('financials_cash_payment_voucher_items', 'financials_cash_payment_voucher_items.cpi_voucher_id', 'financials_cash_payment_voucher.cp_id')
            ->leftJoin('financials_accounts', 'financials_accounts.account_uid', 'financials_cash_payment_voucher_items.cpi_account_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_cash_payment_voucher.cp_createdby')
            ->where('account_clg_id', '=', $user->user_clg_id)
            ->where('cp_clg_id', '=', $user->user_clg_id);

        $query_br = DB::table('financials_bank_receipt_voucher')
            ->leftJoin('financials_bank_receipt_voucher_items', 'financials_bank_receipt_voucher_items.bri_voucher_id', 'financials_bank_receipt_voucher.br_id')
            ->leftJoin('financials_accounts', 'financials_accounts.account_uid', 'financials_bank_receipt_voucher_items.bri_account_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_bank_receipt_voucher.br_createdby')
            ->where('account_clg_id', '=', $user->user_clg_id)
            ->where('br_clg_id', '=', $user->user_clg_id);

        $query_bp = DB::table('financials_bank_payment_voucher')
            ->leftJoin('financials_bank_payment_voucher_items', 'financials_bank_payment_voucher_items.bpi_voucher_id', 'financials_bank_payment_voucher.bp_id')
            ->leftJoin('financials_accounts', 'financials_accounts.account_uid', 'financials_bank_payment_voucher_items.bpi_account_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_bank_payment_voucher.bp_createdby')
            ->where('account_clg_id', '=', $user->user_clg_id)
            ->where('bp_clg_id', '=', $user->user_clg_id);

        $query_ep = DB::table('financials_expense_payment_voucher')
            ->leftJoin('financials_accounts', 'financials_accounts.account_uid', 'financials_expense_payment_voucher.ep_account_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_expense_payment_voucher.ep_createdby')
            ->where('account_clg_id', '=', $user->user_clg_id)
            ->where('ep_clg_id', '=', $user->user_clg_id);

        $query_jv = DB::table('financials_journal_voucher')
            ->leftJoin('financials_journal_voucher_items', 'financials_journal_voucher_items.jvi_journal_voucher_id', 'financials_journal_voucher.jv_id')
            ->leftJoin('financials_accounts', 'financials_accounts.account_uid', 'financials_journal_voucher_items.jvi_account_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_journal_voucher.jv_createdby')
            ->where('account_clg_id', '=', $user->user_clg_id)
            ->where('jv_clg_id', '=', $user->user_clg_id);

        $query_jvr = DB::table('financials_journal_voucher_reference')
            ->leftJoin('financials_journal_voucher_reference_items', 'financials_journal_voucher_reference_items.jvri_journal_voucher_id', 'financials_journal_voucher_reference.jvr_id')
            ->leftJoin('financials_accounts', 'financials_accounts.account_uid', 'financials_journal_voucher_reference_items.jvri_account_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_journal_voucher_reference.jvr_createdby')
            ->where('account_clg_id', '=', $user->user_clg_id)
            ->where('jvr_clg_id', '=', $user->user_clg_id);

        $query_as = DB::table('financials_advance_salary')
            ->leftJoin('financials_advance_salary_items as asi', 'asi.asi_as_id', 'financials_advance_salary.as_id')
            ->join('financials_accounts AS ac2', 'financials_advance_salary.as_from_pay_account', '=', 'ac2.account_uid')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_advance_salary.as_created_by')
            ->select('ac2.account_name AS from', 'financials_advance_salary.*', 'asi.asi_emp_advance_salary_account_name as employee_account', 'asi.asi_amount', 'financials_users.user_id', 'financials_users.user_name')
            ->where('account_clg_id', '=', $user->user_clg_id)
            ->where('as_clg_id', '=', $user->user_clg_id);

        $query_sp = DB::table('financials_salary_payment')
            ->leftJoin('financials_salary_payment_items as spi', 'spi.spi_sp_id', '=', 'financials_salary_payment.sp_id')
            ->leftJoin('financials_users', 'financials_users.user_id', '=', 'financials_salary_payment.sp_createdby')
            ->where('sp_clg_id', '=', $user->user_clg_id);

        $query_ss = DB::table('financials_salary_slip_voucher')
            ->leftJoin('financials_salary_slip_voucher_items as ssi', 'ssi.ssi_voucher_id', 'financials_salary_slip_voucher.ss_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_salary_slip_voucher.ss_created_by')
            ->where('ss_clg_id', '=', $user->user_clg_id);

        $query_bill = DB::table('financials_bill_of_labour')
            ->leftJoin('financials_bill_of_labour_items', 'financials_bill_of_labour_items.bli_voucher_id', 'financials_bill_of_labour.bl_id')
            ->leftJoin('financials_accounts', 'financials_accounts.account_uid', 'financials_bill_of_labour_items.bli_account_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_bill_of_labour.bl_createdby')
            ->where('account_clg_id', '=', $user->user_clg_id)
            ->where('bl_clg_id', '=', $user->user_clg_id);

        $query_fixed_asset = DB::table('financials_fixed_asset_voucher')
            ->leftJoin('financials_fixed_asset_voucher_items', 'financials_fixed_asset_voucher_items.favi_voucher_id', 'financials_fixed_asset_voucher.fav_id')
            ->leftJoin('financials_accounts', 'financials_accounts.account_uid', 'financials_fixed_asset_voucher_items.favi_account_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_fixed_asset_voucher.fav_createdby')
            ->where('account_clg_id', '=', $user->user_clg_id)
            ->where('fav_clg_id', '=', $user->user_clg_id);
//        dd($query_sp);

        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereBetween('pi_day_end_date', [$start, $end]);
            $query_sale->whereBetween('si_day_end_date', [$start, $end]);
            $query_crv->whereBetween('cr_day_end_date', [$start, $end]);
            $query_cp->whereBetween('cp_day_end_date', [$start, $end]);
            $query_br->whereBetween('br_day_end_date', [$start, $end]);
            $query_bp->whereBetween('bp_day_end_date', [$start, $end]);
            $query_ep->whereBetween('ep_day_end_date', [$start, $end]);
            $query_jv->whereBetween('jv_day_end_date', [$start, $end]);
            $query_jvr->whereBetween('jvr_day_end_date', [$start, $end]);
            $query_as->whereBetween('as_day_end_date', [$start, $end]);
            $query_sp->whereBetween('sp_day_end_date', [$start, $end]);
            $query_ss->whereBetween('ss_day_end_date', [$start, $end]);
            $query_bill->whereBetween('bl_day_end_date', [$start, $end]);
            $query_fixed_asset->whereBetween('fav_day_end_date', [$start, $end]);

            $query->whereDate('pi_day_end_date', '>=', $start)
                ->whereDate('pi_day_end_date', '<=', $end);
            $query_sale->whereDate('si_day_end_date', '>=', $start)
                ->whereDate('si_day_end_date', '<=', $end);
            $query_crv->whereDate('cr_day_end_date', '>=', $start)
                ->whereDate('cr_day_end_date', '<=', $end);
            $query_cp->whereDate('cp_day_end_date', '>=', $start)
                ->whereDate('cp_day_end_date', '<=', $end);
            $query_br->whereDate('br_day_end_date', '>=', $start)
                ->whereDate('br_day_end_date', '<=', $end);
            $query_bp->whereDate('bp_day_end_date', '>=', $start)
                ->whereDate('bp_day_end_date', '<=', $end);
            $query_ep->whereDate('ep_day_end_date', '>=', $start)
                ->whereDate('ep_day_end_date', '<=', $end);
            $query_jv->whereDate('jv_day_end_date', '>=', $start)
                ->whereDate('jv_day_end_date', '<=', $end);

            $query_jvr->whereDate('jvr_day_end_date', '>=', $start)
                ->whereDate('jvr_day_end_date', '<=', $end);
            $query_as->whereDate('as_day_end_date', '>=', $start)
                ->whereDate('as_day_end_date', '<=', $end);
            $query_sp->whereDate('sp_day_end_date', '>=', $start)
                ->whereDate('sp_day_end_date', '<=', $end);
            $query_ss->whereDate('ss_day_end_date', '>=', $start)
                ->whereDate('ss_day_end_date', '<=', $end);
            $query_bill->whereDate('bl_day_end_date', '>=', $start)
                ->whereDate('bl_day_end_date', '<=', $end);
            $query_fixed_asset->whereDate('fav_day_end_date', '>=', $start)
                ->whereDate('fav_day_end_date', '<=', $end);

        } elseif (!empty($search_to)) {
            $query->where('pi_day_end_date', $end);
            $query_sale->where('si_day_end_date', $end);
            $query_crv->where('cr_day_end_date', $end);
            $query_cp->where('cp_day_end_date', $end);
            $query_br->where('br_day_end_date', $end);
            $query_bp->where('bp_day_end_date', $end);
            $query_ep->where('ep_day_end_date', $end);
            $query_jv->where('jv_day_end_date', $end);
            $query_jvr->where('jvr_day_end_date', $end);
            $query_as->where('as_day_end_date', $end);
            $query_sp->where('sp_day_end_date', $end);
            $query_ss->where('ss_day_end_date', $end);
            $query_bill->where('bl_day_end_date', $end);
            $query_fixed_asset->where('fav_day_end_date', $end);

        } elseif (!empty($search_from)) {
            $query->where('pi_day_end_date', $start);
            $query_sale->where('si_day_end_date', $start);
            $query_crv->where('cr_day_end_date', $start);
            $query_cp->where('cp_day_end_date', $start);
            $query_br->where('br_day_end_date', $start);
            $query_bp->where('bp_day_end_date', $start);
            $query_ep->where('ep_day_end_date', $start);
            $query_jv->where('jv_day_end_date', $start);
            $query_jvr->where('jvr_day_end_date', $start);
            $query_as->where('as_day_end_date', $start);
            $query_sp->where('sp_day_end_date', $start);
            $query_ss->where('ss_day_end_date', $start);
            $query_bill->where('bl_day_end_date', $start);
            $query_fixed_asset->where('fav_day_end_date', $start);
        } else {
            $query->whereDate('pi_day_end_date', '=', $today_date);
            $query_sale->whereDate('si_day_end_date', '=', $today_date);
            $query_crv->whereDate('cr_day_end_date', '=', $today_date);
            $query_cp->whereDate('cp_day_end_date', '=', $today_date);
            $query_br->whereDate('br_day_end_date', '=', $today_date);
            $query_bp->whereDate('bp_day_end_date', '=', $today_date);
            $query_ep->whereDate('ep_day_end_date', '=', $today_date);
            $query_jv->whereDate('jv_day_end_date', '=', $today_date);
            $query_jvr->whereDate('jvr_day_end_date', '=', $today_date);
            $query_as->whereDate('as_day_end_date', '=', $today_date);
            $query_sp->whereDate('sp_day_end_date', '=', $today_date);
            $query_ss->whereDate('ss_day_end_date', '=', $today_date);
            $query_bill->whereDate('bl_day_end_date', '=', $today_date);
            $query_fixed_asset->whereDate('fav_day_end_date', '=', $today_date);
        }


        $datas = $query->orderBy('pi_id', config('global_variables.query_sorting'))
            ->get();

        $datas_sale = $query_sale->orderBy('si_id', config('global_variables.query_sorting'))
            ->get();

        $datas_crp = $query_crv->orderBy('cr_id', config('global_variables.query_sorting'))
            ->get();

        $datas_cp = $query_cp->orderBy('cp_id', config('global_variables.query_sorting'))
            ->get();


        $datas_br = $query_br->orderBy('br_id', config('global_variables.query_sorting'))
            ->get();


        $datas_bp = $query_bp->orderBy('bp_id', config('global_variables.query_sorting'))
            ->get();


        $datas_ep = $query_ep->orderBy('ep_id', config('global_variables.query_sorting'))
            ->get();
        $datas_jv = $query_jv->orderBy('jv_id', config('global_variables.query_sorting'))
            ->get();
        $datas_jvr = $query_jvr->orderBy('jvr_id', config('global_variables.query_sorting'))
            ->get();
        $datas_as = $query_as->orderBy('as_id', config('global_variables.query_sorting'))
            ->get();
        $datas_sp = $query_sp->orderBy('sp_id', config('global_variables.query_sorting'))
            ->get();
        $datas_ss = $query_ss->orderBy('ss_id', config('global_variables.query_sorting'))
            ->get();
        $datas_bill = $query_bill->orderBy('bl_id', config('global_variables.query_sorting'))
            ->get();
        $datas_fixed_asset = $query_fixed_asset->orderBy('fav_id', config('global_variables.query_sorting'))
            ->get();

        $allData = [
            'datas' => $datas,
            'datas_sale' => $datas_sale,
            'datas_crp' => $datas_crp,
            'datas_cp' => $datas_cp,
            'datas_br' => $datas_br,
            'datas_bp' => $datas_bp,
            'datas_ep' => $datas_ep,
            'datas_jv' => $datas_jv,
            'datas_jvr' => $datas_jvr,
            'datas_as' => $datas_as,
            'datas_sp' => $datas_sp,
            'datas_ss' => $datas_ss,
            'datas_bill' => $datas_bill,
            'datas_fixed_asset' => $datas_fixed_asset,
        ];
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
            $pdf->loadView($prnt_page_dir, compact('allData', 'type', 'pge_title', 'srch_fltr'));
//            $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($allData, $srch_fltr,
                    $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('today_report/today_report', compact('allData', 'search_to', 'search_from'));
        }
    }

    // update code by Mustafa end
}
