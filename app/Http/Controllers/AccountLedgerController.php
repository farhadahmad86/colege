<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountHeadsModel;
use App\Models\AccountOpeningClosingBalanceModel;
use App\Models\AccountRegisterationModel;
use App\Models\AdvanceSalaryItemsModel;
use App\Models\AdvanceSalaryModel;
use App\Models\AreaModel;
use App\Models\BalancesModel;
use App\Models\BankPaymentVoucherItemsModel;
use App\Models\BankPaymentVoucherModel;
use App\Models\BankReceiptVoucherItemsModel;
use App\Models\BankReceiptVoucherModel;
use App\Models\BillOfLabourItemsModel;
use App\Models\BillOfLabourModel;
use App\Models\CashPaymentVoucherItemsModel;
use App\Models\CashPaymentVoucherModel;
use App\Models\CashReceiptVoucherItemsModel;
use App\Models\CashReceiptVoucherModel;
use App\Models\CashTransferModel;
use App\Models\College\Branch;
use App\Models\ConsumedStockModel;
use App\Models\DayEndModel;
use App\Models\ExpensePaymentVoucherItemsModel;
use App\Models\ExpensePaymentVoucherModel;
use App\Models\GenerateSalarySlipModel;
use App\Models\JournalVoucherItemsModel;
use App\Models\JournalVoucherModel;
use App\Models\PostDatedChequeModel;
use App\Models\ProducedStockModel;
use App\Models\ProductionStockAdjustmentModel;
use App\Models\ProductLossRecoverItemsModel;
use App\Models\ProductLossRecoverModel;
use App\Models\ProductManufactureExpenseModel;
use App\Models\ProductManufactureItemsModel;
use App\Models\ProductManufactureModel;
use App\Models\PurchaseInvoiceItemsModel;
use App\Models\PurchaseInvoiceModel;
use App\Models\PurchaseReturnInvoiceItemsModel;
use App\Models\PurchaseReturnInvoiceModel;
use App\Models\PurchaseReturnSaletaxInvoiceItemsModel;
use App\Models\PurchaseReturnSaletaxInvoiceModel;
use App\Models\PurchaseSaletaxInvoiceModel;
use App\Models\PurchaseSaletaxItemsInvoiceModel;
use App\Models\RegionModel;
use App\Models\ReportConfigModel;
use App\Models\SalaryPaymentVoucherItemsModel;
use App\Models\SalaryPaymentVoucherModel;
use App\Models\SalarySlipVoucherItemsModel;
use App\Models\SalarySlipVoucherModel;
use App\Models\SaleInvoiceModel;
use App\Models\SaleReturnInvoiceModel;
use App\Models\SaleReturnSaletaxInvoiceModel;
use App\Models\SaleSaletaxInvoiceModel;
use App\Models\SectorModel;
use App\Models\ServiceSaleTaxInvoiceItemsModel;
use App\Models\ServiceSaleTaxInvoiceModel;
use App\Models\ServicesInvoiceModel;
use App\Models\YearEndModel;
use App\User;
use Auth;
use PDF;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AccountLedgerController extends Controller
{

    // update code by shahzaib start
    public function account_ledger(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->from;
        $search_account_id = (!isset($request->account_id) && empty($request->account_id)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->account_id;
        $search_account_name = (!isset($request->account_name) && empty($request->account_name)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->account_name;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $account_id = $search_account_id;
        $account_name = $search_account_name;
        $prnt_page_dir = 'print.account_ledger.account_ledger';
        $pge_title = 'Account Ledger ' . $account_name;
        $srch_fltr = [];

        if(empty($search_year)){
            $search_year=$this->getYearEndId();
        }
        array_push($srch_fltr, $search_to, $search_from,$search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;
        if ($search_to != '') {
            $start = date('Y-m-d', strtotime($search_to));
        } else {
            $start = DayEndModel::pluck('de_datetime')->first();
            $search_to = $start;
        }
        if ($search_from != '') {
            $end = date('Y-m-d', strtotime($search_from));
        } else {
            $end = DayEndModel::orderBy('de_id', 'DESC')->pluck('de_datetime')->first();
            $search_from = $end;
        }


        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $month = date('m', strtotime($day_end->de_datetime));
        $year = date('Y', strtotime($day_end->de_datetime));


//        $user = Auth::user();
//
//        if ($user->user_level != 100) {
//            $check_account = AccountRegisterationModel::where('account_id',$account_id)->whereIn('account_group_id', explode(',', $user->user_reporting_group_id))->first();
//
//            if(!$check_account){
//                return redirect()->back()->with('fail', 'This Ledger not Allowed');
//            }
//        }
        if ($search_year == $this->getYearEndId()) {
            $query = DB::table('financials_balances')
                ->leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_balances.bal_pr_id')
                ->where('bal_clg_id', $user->user_clg_id);
        } else {
            $tableName = 'financials_balances_' . $search_year;
            $query = DB::table("$tableName as balance")
                ->leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'balance.bal_pr_id')
                ->where('bal_clg_id', $user->user_clg_id);
        }
        if (!empty($search_to) && !empty($search_from)) {
            $query->whereDate('bal_day_end_date', '>=', $start)
                ->whereDate('bal_day_end_date', '<=', $end);
        } elseif (!empty($search_to) && empty($search_from)) {
            $query->whereDate('bal_day_end_date', '>=', $start);
        } elseif (empty($search_to) && !empty($search_from)) {
            $query->whereDate('bal_day_end_date', '<=', $end);

        } else {
            $query->whereMonth('bal_day_end_date', $month)->whereYear('bal_day_end_date', $year);
        }


        $option = $request->options;
        if ($option == "ASC") {
            $datas = $query->where('bal_account_id', $search_account_id)->orderBy('bal_id', 'ASC')
                ->cursor();
        } else {

            $datas = $query->where('bal_account_id', $search_account_id)->orderBy('bal_id', 'DESC')
                ->cursor();
        }


        $datas = $query->where('bal_account_id', $search_account_id)->orderBy('bal_id', 'ASC')
            ->cursor();


        $opening_balance = '';
        if (!empty($search_to)) {
            $opening_balance = BalancesModel::where('bal_clg_id', $user->user_clg_id)->where('bal_year_id', $search_year)->whereDate('bal_day_end_date', '<', $start)->where('bal_account_id', $search_account_id)->orderBy('bal_id', 'DESC')->pluck('bal_total')->first();
        }
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
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title', 'srch_fltr'));
//            $pdf->setOptions($options);

            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
//                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title.'_x.xlsx');
            }

        } else {
            return view('account_ledger', compact('option', 'datas', 'account_name', 'account_id', 'search_to', 'search_from', 'opening_balance', 'search_year'));
        }
    }
    // update code by shahzaib end


    // update code by shahzaib start
    public function chart_of_account_ledger(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $branches = Branch::where('branch_clg_id', $user->user_clg_id)->select('branch_id', 'branch_name')->get();
        $ar = json_decode($request->array);
        $search_account_id = (!isset($request->account_id) && empty($request->account_id)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->account_id;
        $search_account_name = (!isset($request->account_name) && empty($request->account_name)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->account_name;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_by_invoice_type = (!isset($request->invoice_type) && empty($request->invoice_type)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->invoice_type;
        $search_branch = (!isset($request->branch) && empty($request->branch)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->branch;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->year;

        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $account_id = $search_account_id;
        $account_name = $search_account_name;
        $prnt_page_dir = 'print.chart_of_account_ledger.chart_of_account_ledger';
        $pge_title = 'Chart Of Account Ledger ( ' . $account_name . ' )';
        $srch_fltr = [];
        if (empty($search_year)) {
            $search_year = $this->getYearEndId();
        }
        array_push($srch_fltr, $search_account_name, $search_to, $search_from, $search_by_invoice_type, $search_branch, $search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));


        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $month = date('m', strtotime($day_end->de_datetime));
        $year = date('Y', strtotime($day_end->de_datetime));
        if ($search_year == $this->getYearEndId()) {
            $query = DB::table('financials_balances')
                ->leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_balances.bal_pr_id')
                ->leftJoin('branches', 'branches.branch_id', 'financials_balances.bal_branch_id')
                ->where('bal_clg_id', $user->user_clg_id);
        } else {
            $tableName = 'financials_balances_' . $search_year;
            $query = DB::table("$tableName as balance")
                ->leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'balance.bal_pr_id')
                ->leftJoin('branches', 'branches.branch_id', 'balance.bal_branch_id')
                ->where('bal_clg_id', $user->user_clg_id);
        }

        if (!empty($search_to) && !empty($search_from)) {
            $query->whereDate('bal_day_end_date', '>=', $start)
                ->whereDate('bal_day_end_date', '<=', $end);
        } elseif (!empty($search_to) && empty($search_from)) {
            $query->whereDate('bal_day_end_date', '>=', $start);
        } elseif (empty($search_to) && !empty($search_from)) {
            $query->whereDate('bal_day_end_date', '<=', $end);
        } else {
            $query->whereMonth('bal_day_end_date', $month)->whereYear('bal_day_end_date', $year);
        }

        if (!empty($search_by_invoice_type) && !empty($search_by_invoice_type)) {
            $query->where('bal_voucher_number', 'like', $search_by_invoice_type . '%');
        }
        if (!empty($search_branch)) {
            $query->where('bal_branch_id', '=', $search_branch);
        }
        if (!empty($search_year)) {
            $query->where('bal_year_id', '=', $search_year);
        } else {
            $search_year = YearEndModel::orderBy('ye_id', 'DESC')->pluck('ye_id')->first();
            $query->where('bal_year_id', '=', $search_year);
        }

        $datas = $query->where('bal_account_id', $search_account_id)->orderBy('bal_id', 'DESC')
            ->get();
        $opening_balance = '';
        if (!empty($search_to)) {
//            $opening_balance_query = BalancesModel::where('bal_clg_id', $user->user_clg_id)->whereDate('bal_day_end_date', '<', $start)->where('bal_account_id', $search_account_id);

            $opening_balance = BalancesModel::where('bal_clg_id', $user->user_clg_id)->whereDate('bal_day_end_date', '<', $start)->where('bal_account_id', $search_account_id)->orderBy('bal_id',
                'DESC')->pluck('bal_total')->first();

//            $total_dr = $opening_balance_query->sum('bal_dr');
//            $total_cr = $opening_balance_query->sum('bal_cr');
//            $opening_balance = $total_dr - $total_cr;
        }
        $query = DB::table('financials_accounts')->where('account_clg_id', $user->user_clg_id);

        if ($user->user_level != 100) {
            // $query->whereIn('account_group_id', explode(',', $user->user_group_id));
            $query->whereIn('account_group_id', explode(',', $user->user_account_reporting_group_ids));
        }

        $account_lists = $query->where('account_type', 0)
            ->orderBy('account_parent_code', 'ASC')
            ->orderBy('account_name', 'ASC')
            ->get();
        // ->paginate($pagination_number);

        if (isset($request->array) && !empty($request->array)) {
            $balance = $opening_balance;
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
            $pdf->loadView($prnt_page_dir, compact('datas', 'balance', 'type', 'pge_title', 'srch_fltr'));
//            $pdf->setOptions($options);

            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title, $balance), $pge_title . '_x.xlsx');
            }

        } else {
            return view('chart_of_account_ledger', compact('datas', 'search_year', 'account_name', 'search_year', 'branches', 'account_id', 'search_to', 'search_from', 'search_branch', 'account_lists', 'search_by_invoice_type',
                'opening_balance'));
        }
    }
    // update code by shahzaib end


    // update code by shahzaib start
    public function parties_account_ledger(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $branches = Branch::where('branch_clg_id', $user->user_clg_id)->select('branch_id', 'branch_name')->get();
        $ar = json_decode($request->array);
        $search_account_id = (!isset($request->account_id) && empty($request->account_id)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->account_id;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;

        $search_account_name = (!isset($request->account_name) && empty($request->account_name)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->account_name;
        $search_branch = (!isset($request->branch) && empty($request->branch)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->branch;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $search_by_invoice_type = (isset($request->invoice_type) && !empty($request->invoice_type)) ? $request->invoice_type : '';
        $account_id = $search_account_id;
        $account_name = $search_account_name;
        $prnt_page_dir = 'print/parties_account_ledger/parties_account_ledger';
        $pge_title = 'Parties Account Ledger ( ' . $account_name . ' )';
        $srch_fltr = [];

        if (empty($search_year)) {
            $search_year = $this->getYearEndId();
        }
        array_push($srch_fltr, $search_to, $search_from, $search_year, $search_branch);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));


        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $month = date('m', strtotime($day_end->de_datetime));
        $year = date('Y', strtotime($day_end->de_datetime));

        if ($search_year == $this->getYearEndId()) {
            $query = DB::table('financials_balances')
                ->leftJoin('branches', 'branches.branch_id', 'financials_balances.bal_branch_id')
                ->where('bal_clg_id', $user->user_clg_id);
        } else {
            $tableName = 'financials_balances_' . $search_year;
            $query = DB::table("$tableName as balance")
                ->leftJoin('branches', 'branches.branch_id', 'balance.bal_branch_id')
                ->where('bal_clg_id', $user->user_clg_id);
        }


        if (!empty($search_to) && !empty($search_from)) {

            $query->whereDate('bal_day_end_date', '>=', $start)
                ->whereDate('bal_day_end_date', '<=', $end);
        } elseif (!empty($search_to) && empty($search_from)) {
            $query->whereDate('bal_day_end_date', '>=', $start);
        } elseif (empty($search_to) && !empty($search_from)) {
            $query->whereDate('bal_day_end_date', '<=', $end);
        } else {
//            $query->whereMonth('bal_day_end_date', $month);
        }

        if (!empty($search_by_invoice_type) && !empty($search_by_invoice_type)) {
            $query->where('bal_voucher_number', 'like', $search_by_invoice_type . '%');
        }

        if (!empty($search_branch)) {
            $query->where('bal_branch_id', '=', $search_branch);
        }
        $datas = $query->where('bal_account_id', $search_account_id)->orderBy('bal_id', 'ASC')
            ->get();


        $query = DB::table('financials_accounts')->where('account_clg_id', $user->user_clg_id);

        if ($user->user_level != 100) {
            // $query->whereIn('account_group_id', explode(',', $user->user_group_id));
            $query->whereIn('account_group_id', explode(',', $user->user_account_reporting_group_ids));
        }

        $account_lists = $query->where('account_type', '!=', 0)
            ->orderBy('account_parent_code', 'ASC')
            ->orderBy('account_name', 'ASC')
            ->get();

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

            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title', 'srch_fltr'));
//            $pdf->setOptions($options);

            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('parties_account_ledger', compact('datas', 'search_year', 'account_name', 'branches', 'account_id', 'search_to', 'search_from', 'search_branch', 'account_lists', 'search_by_invoice_type'));
        }
    }
    // update code by shahzaib end

    // update code by shahzaib start
    public function customer_aging_report(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->from;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_account_id = (!isset($request->account_id_aging) && empty($request->account_id_aging)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->account_id_aging;
        $search_account_name = (!isset($request->account_name_aging) && empty($request->account_name_aging)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->account_name_aging;
        $search_sale_person = (!isset($request->sale_person) && empty($request->sale_person)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->sale_person;
        $search_region = (!isset($request->region) && empty($request->region)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->region;
        $search_area = (!isset($request->area) && empty($request->area)) ? ((!empty($ar)) ? $ar[7]->{'value'} : '') : $request->area;
        $search_sector = (!isset($request->sector) && empty($request->sector)) ? ((!empty($ar)) ? $ar[8]->{'value'} : '') : $request->sector;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';

        $prnt_page_dir = 'print.customer_aging_report.customer_aging_report';
        $pge_title = 'Customer Aging Report ( ' . $search_account_name . ' )';
        $srch_fltr = [];
        array_push($srch_fltr, $search_account_name, $search_from, $search_to);


        $pagination_number = (empty($ar)) ? 30 : 100000000;

        if (!empty($request['page'])) {
            $pagination_number = (empty($ar)) ? 30 : 100000000;
        } else {
            $pagination_number = (empty($ar)) ? 9999999999990 : 100000000;
        }

        $has_pages = $request['page'] > 0 ? '1' : '0';


        $regions = RegionModel::where('reg_clg_id', $user->user_clg_id)->orderBy('reg_title', 'ASC')->get();
        $areas = AreaModel::where('area_clg_id', $user->user_clg_id)->orderBy('area_title', 'ASC')->get();
        $sectors = SectorModel::where('sec_clg_id', $user->user_clg_id)->orderBy('sec_title', 'ASC')->get();
        $heads = config('global_variables.receivable');
        $account_lists = AccountRegisterationModel::where('account_clg_id', $user->user_clg_id)->where('account_parent_code', $heads)->orderBy('account_uid', 'ASC')->get();
        $sale_persons = User::where('user_clg_id', '=', $user->user_clg_id)->where('user_delete_status', '!=', 1)
            ->where('user_disabled', '!=', 1)
            ->where('user_id', '!=', 1)
            ->where('user_role_id', 4)
            ->orderBy('user_role_id', 'DESC')
            ->orderBy('user_name', 'ASC')
            ->get();


        $start = date('Y-m-d', strtotime($search_from));
        $end = date('Y-m-d', strtotime($search_to));


        $query = DB::table('financials_accounts as accounts')
            ->where('account_parent_code', $heads)
            ->where('account_clg_id', $user->user_clg_id);

        if ((isset($search_account_id) && !empty($search_account_id)) && $search_account_id !== "All") {
            $query->where('account_uid', $search_account_id);
        }

        if (empty($search_account_id) && (empty($search_from) && empty($search_to))) {
            $query->where('account_uid', $search_account_id);
        }

        if (isset($search_sale_person) && !empty($search_sale_person)) {
            $query->where('account_sale_person', $search_sale_person);
        }

        if (isset($search_region) && !empty($search_region)) {
            $query->where('account_region_id', $search_region);
        }

        if (isset($search_area) && !empty($search_area)) {
            $query->where('account_area', $search_area);
        }

        if (isset($search_sector) && !empty($search_sector)) {
            $query->where('account_sector_id', $search_sector);
        }

        $datas = $query->orderBy('account_id', 'ASC')
            ->select('accounts.account_id', 'accounts.account_parent_code', 'accounts.account_uid', 'accounts.account_name', 'accounts.account_region_id', 'accounts.account_area', 'accounts.account_sector_id',
                \DB::raw("
                    (SELECT
                        IF( (SELECT bal_total FROM financials_balances WHERE bal_clg_id = '$user->user_clg_id' AND bal_account_id = account_uid AND bal_day_end_date < '$start' ORDER BY bal_id ASC LIMIT 1) >= 0,
                         (SELECT bal_total FROM financials_balances WHERE bal_clg_id = '$user->user_clg_id' AND bal_account_id = account_uid AND bal_day_end_date < '$start' ORDER BY bal_id DESC LIMIT 1),
                          (SELECT bal_total FROM financials_balances WHERE bal_clg_id = '$user->user_clg_id' AND bal_account_id = account_uid AND bal_day_end_date <= '$start' ORDER BY bal_id ASC LIMIT 1) ))
                    as opening_balance,


                    (SELECT SUM(bal_dr) FROM financials_balances WHERE bal_clg_id = '$user->user_clg_id' AND bal_account_id = account_uid AND bal_day_end_date BETWEEN '$start' AND '$end' AND bal_transaction_type != 'OPENING_BALANCE' ) as total_inwards,
                    (SELECT SUM(bal_cr) FROM financials_balances WHERE bal_clg_id = '$user->user_clg_id' AND bal_account_id = account_uid AND bal_day_end_date BETWEEN '$start' AND '$end' AND bal_transaction_type != 'OPENING_BALANCE' ) as total_outwards,
                    (SELECT bal_total FROM financials_balances WHERE bal_clg_id = '$user->user_clg_id' AND bal_account_id = account_uid AND bal_day_end_date BETWEEN '$start' AND '$end' ORDER BY bal_id DESC LIMIT 1 ) as ledger_balance_of_customer,

                    (SELECT bal_day_end_date FROM financials_balances WHERE bal_clg_id = '$user->user_clg_id' AND bal_account_id = account_uid AND bal_dr != 0 AND bal_day_end_date BETWEEN '$start' AND '$end' ORDER BY bal_id DESC LIMIT 1 ) as last_inward_transaction_date,
                    (SELECT bal_transaction_type FROM financials_balances WHERE bal_clg_id = '$user->user_clg_id' AND bal_account_id = account_uid AND bal_dr != 0 AND bal_day_end_date BETWEEN '$start' AND '$end' ORDER BY bal_id DESC LIMIT 1 ) as last_inward_transaction_type,
                    (SELECT bal_dr FROM financials_balances WHERE bal_clg_id = '$user->user_clg_id' AND bal_account_id = account_uid AND bal_dr != 0 AND bal_day_end_date BETWEEN '$start' AND '$end' ORDER BY bal_id DESC LIMIT 1 ) as last_inward_transaction_amount,

                    (SELECT bal_day_end_date FROM financials_balances WHERE bal_clg_id = '$user->user_clg_id' AND bal_account_id = account_uid AND bal_cr != 0 AND bal_day_end_date BETWEEN '$start' AND '$end' ORDER BY bal_id DESC LIMIT 1 ) as last_outward_transaction_date,
                    (SELECT bal_transaction_type FROM financials_balances WHERE bal_clg_id = '$user->user_clg_id' AND bal_account_id = account_uid AND bal_cr != 0 AND bal_day_end_date BETWEEN '$start' AND '$end' ORDER BY bal_id DESC LIMIT 1 ) as last_outward_transaction_type,
                    (SELECT bal_cr FROM financials_balances WHERE bal_clg_id = '$user->user_clg_id' AND bal_account_id = account_uid AND bal_cr != 0 AND bal_day_end_date BETWEEN '$start' AND '$end' ORDER BY bal_id DESC LIMIT 1 ) as last_outward_transaction_amount,

                    (SELECT DATEDIFF('$end', bal_day_end_date) FROM financials_balances WHERE bal_clg_id = '$user->user_clg_id' AND bal_account_id = account_uid AND bal_dr != 0 AND bal_day_end_date < '$end' ORDER BY bal_id DESC LIMIT 1 ) as inward_not_received_last_days,
                    (SELECT DATEDIFF('$end', bal_day_end_date) FROM financials_balances WHERE bal_clg_id = '$user->user_clg_id' AND bal_account_id = account_uid AND bal_cr != 0 AND bal_day_end_date < '$end' ORDER BY bal_id DESC LIMIT 1 ) as outward_not_received_last_days

                ")
            )
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
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('customer_aging_report', compact('datas', 'search_account_id', 'search_account_name', 'search_from', 'search_to', 'search_region', 'search_area', 'search_sector', 'account_lists', 'regions', 'areas', 'sectors', 'sale_persons', 'search_sale_person', 'has_pages'));
        }


    }

    // update code by shahzaib start
    public function parent_account_ledger(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $second_heads = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_level', 2)->orderBy('coa_id', 'ASC')->get();
        $third_heads = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_level', 3)->orderBy('coa_id', 'ASC')->get();

        $datas = [];


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $start_date = (!isset($request->start_date) && empty($request->start_date)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->start_date;
        $end_date = (!isset($request->end_date) && empty($request->end_date)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->end_date;
        $account_type = (!isset($request->account_type) && empty($request->account_type)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->account_type;
        $search_second_head = (!isset($request->second_head) && empty($request->second_head)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->second_head;
        $search_third_head = (!isset($request->third_head) && empty($request->third_head)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->third_head;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.parent_account_ledger.parent_account_ledger';
        $pge_title = 'Parent Account Ledger';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $account_type, $search_second_head, $search_third_head);

        $pagination_number = (empty($ar)) ? 100000000 : 100000000;


        $query = DB::table('financials_balances')
            ->leftJoin('financials_accounts', 'financials_accounts.account_uid', 'financials_balances.bal_account_id')
            ->leftJoin('financials_coa_heads as parent_account', 'parent_account.coa_code', 'financials_accounts.account_parent_code')
            ->leftJoin('financials_coa_heads as group_account', 'group_account.coa_code', 'parent_account.coa_parent')
            ->leftJoin('financials_coa_heads as control_account', 'control_account.coa_code', 'group_account.coa_parent')
            ->where('bal_clg_id', '=', $user->user_clg_id)
            ->where('account_clg_id', '=', $user->user_clg_id)
            ->where('parent_account.coa_clg_id', '=', $user->user_clg_id)
            ->where('group_account.coa_clg_id', '=', $user->user_clg_id)
            ->where('control_account.coa_clg_id', '=', $user->user_clg_id)
            ->select('financials_balances.*', 'financials_accounts.account_uid', 'financials_accounts.account_name', 'parent_account.coa_head_name as parnt_acnt_name', 'group_account.coa_head_name as grp_acnt_name');


        if ((!empty($account_type)) || (!empty($start_date)) || (!empty($end_date)) || !empty($search_second_head) || !empty($search_third_head)) {

            $start = date('Y-m-d', strtotime($start_date));

            $end = date('Y-m-d', strtotime($end_date));

            if (!empty($account_type)) {
                $query->where('bal_account_id', 'LIKE', $account_type . '%');
            }

            if ((!empty($start_date)) && (!empty($end_date))) {
                $query->whereDate('bal_day_end_date', '>=', $start)->whereDate('bal_day_end_date', '<=', $end);
            } else if (!empty($start_date)) {
                $query->whereDate('bal_day_end_date', $start);
            } else if (!empty($end_date)) {
                $query->whereDate('bal_day_end_date', $end);
            }

            if (!empty($search_second_head)) {
                $query->where('group_account.coa_code', '=', $search_second_head);
            }

            if (!empty($search_third_head)) {
                $query->where('parent_account.coa_code', '=', $search_third_head);
            }


            $datas = $query->orderBy('bal_id', 'DESC')
                ->orderBy('account_parent_code', 'ASC')
                ->orderBy('account_name', 'ASC')
                ->get();
        }


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
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title', 'srch_fltr'));
//            $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('parent_account_ledger', compact('datas', 'start_date', 'end_date', 'account_type', 'second_heads', 'third_heads', 'search_second_head', 'search_third_head'));
        }

    }

    // update code by shahzaib end


    public function transaction_view_details_SH(Request $request, $id)
    {
        $user = Auth::user();
        $trans_id = explode('-', $id);
        $urdu_eng = ReportConfigModel::where('rc_clg_id', '=', $user->user_clg_id)->select('rc_invoice', 'rc_invoice_party')->first();
        $type = $trans_id[0] . '-';
        $id = $trans_id[1];

        $get_value = [];
        switch ($type) {

            // purchase invoice
            case config('global_variables.PURCHASE_VOUCHER_CODE'):

                if ($urdu_eng->rc_invoice_party == 0) {
                    $pim = PurchaseInvoiceModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_purchase_invoice.pi_pr_id')->where('pi_clg_id', '=',
                        $user->user_clg_id)->where('pi_id', $id)->first();
                } else {
                    $pim = DB::table('financials_purchase_invoice')
                        ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_purchase_invoice.pi_party_code')
                        ->leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_purchase_invoice.pi_pr_id')
                        ->where('pi_clg_id', '=', $user->user_clg_id)
                        ->where('account_clg_id', '=', $user->user_clg_id)
                        ->where('pi_id', $id)
                        ->select('financials_accounts.account_urdu_name as pi_party_name', 'pi_id', 'pi_party_code', 'pi_customer_name', 'pi_remarks', 'pi_total_items', 'pi_total_price', 'pi_product_disc', 'pi_round_off_disc',
                            'pi_cash_disc_per', 'pi_cash_disc_amount', 'pi_total_discount', 'pi_inclusive_sales_tax', 'pi_exclusive_sales_tax', 'pi_total_sales_tax', 'pi_grand_total', 'pi_cash_paid', 'pi_day_end_id', 'pi_day_end_date', 'pi_createdby', 'pr_name')->first();
                }

                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $pim->pi_party_code)->first();
                $piims = PurchaseInvoiceItemsModel::where('pii_purchase_invoice_id', $id)
                    ->select('pii_product_name as name', 'pii_remarks as remarks', 'pii_qty as qty', 'pii_rate as rate', 'pii_discount_per as discount', 'pii_discount_amount as discount_amount', 'pii_after_dis_rate as after_discount', 'pii_saletax_per as sale_tax', 'pii_saletax_amount as sale_tax_amount', 'pii_saletax_inclusive as inclu_exclu', 'pii_amount as amount', 'pii_scale_size as scale_size')
                    ->orderby('pii_product_name', 'ASC')
                    ->get();
                $nbrOfWrds = $this->myCnvrtNbr($pim->pi_grand_total);
                $invoice_nbr = $pim->pi_id;
                $invoice_date = $pim->pi_day_end_date;
                $type = 'grid';
                $pge_title = 'Purchase Invoice';

                return view('invoice_view.purchase_invoice.purchase_invoice_list_modal', compact('piims', 'pim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title', 'urdu_eng'));
                break;

            // trade purchase invoice
            case config('global_variables.TRADE_PURCHASE_VOUCHER_CODE'):

                $pim = PurchaseInvoiceModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_purchase_invoice.pi_pr_id')->where('pi_id', $id)->first();
                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $pim->pi_party_code)->first();
                $piims = PurchaseInvoiceItemsModel::where('pii_purchase_invoice_id', $id)
                    ->select('pii_product_name as name', 'pii_remarks as remarks', 'pii_qty as qty', 'pii_rate as rate', 'pii_discount_per as discount', 'pii_discount_amount as discount_amount', 'pii_after_dis_rate as after_discount', 'pii_saletax_per as sale_tax', 'pii_saletax_amount as sale_tax_amount', 'pii_saletax_inclusive as inclu_exclu', 'pii_amount as amount', 'pii_scale_size as scale_size')
                    ->orderby('pii_product_name', 'ASC')
                    ->get();
                $nbrOfWrds = $this->myCnvrtNbr($pim->pi_grand_total);
                $invoice_nbr = $pim->pi_id;
                $invoice_date = $pim->pi_day_end_date;
                $type = 'grid';
                $pge_title = 'Trade Purchase Invoice';

                return view('trade_invoice_view.trade_purchase_invoice.trade_purchase_invoice_list_modal', compact('piims', 'pim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title', 'urdu_eng'));
                break;

            // GRN purchase invoice mustafa
            case config('global_variables.GOODS_RECEIPT_NOTE_PURCHASE_VOUCHER_CODE'):

                $pim = PurchaseInvoiceModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_purchase_invoice.pi_pr_id')->where('pi_id', $id)->first();
                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $pim->pi_party_code)->first();
                $piims = PurchaseInvoiceItemsModel::where('pii_purchase_invoice_id', $id)
                    ->select('pii_product_name as name', 'pii_remarks as remarks', 'pii_qty as qty', 'pii_rate as rate', 'pii_discount_per as discount', 'pii_after_dis_rate as after_discount', 'pii_saletax_per as sale_tax', 'pii_saletax_amount as sale_tax_amount', 'pii_saletax_inclusive as inclu_exclu', 'pii_amount as amount')
                    ->orderby('pii_product_name', 'ASC')
                    ->get();
                $nbrOfWrds = $this->myCnvrtNbr($pim->pi_grand_total);
                $invoice_nbr = $pim->pi_id;
                $invoice_date = $pim->pi_day_end_date;
                $type = 'grid';
                $pge_title = 'Purchase Invoice';

                return view('invoice_view.purchase_invoice.purchase_invoice_list_modal', compact('piims', 'pim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title', 'urdu_eng'));


                break;

            // Trade GRN purchase invoice mustafa
            case config('global_variables.TRADE_GOODS_RECEIPT_NOTE_PURCHASE_VOUCHER_CODE'):

                $pim = PurchaseInvoiceModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_purchase_invoice.pi_pr_id')->where('pi_id', $id)->first();
                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $pim->pi_party_code)->first();
                $piims = PurchaseInvoiceItemsModel::where('pii_purchase_invoice_id', $id)
                    ->select('pii_product_name as name', 'pii_remarks as remarks', 'pii_qty as qty', 'pii_rate as rate', 'pii_discount_per as discount', 'pii_after_dis_rate as after_discount', 'pii_saletax_per as sale_tax', 'pii_saletax_amount as sale_tax_amount', 'pii_saletax_inclusive as inclu_exclu', 'pii_amount as amount')
                    ->orderby('pii_product_name', 'ASC')
                    ->get();
                $nbrOfWrds = $this->myCnvrtNbr($pim->pi_grand_total);
                $invoice_nbr = $pim->pi_id;
                $invoice_date = $pim->pi_day_end_date;
                $type = 'grid';
                $pge_title = 'Trade Purchase Invoice';

                return view('trade_invoice_view.trade_purchase_invoice.trade_purchase_invoice_list_modal', compact('piims', 'pim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title', 'urdu_eng'));


                break;

            // purchase return invoice
            case config('global_variables.PURCHASE_RETURN_VOUCHER_CODE'):

                $pim = PurchaseReturnInvoiceModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_purchase_return_invoice.pri_pr_id')->where('pri_id', $id)
                    ->first();
                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $pim->pri_party_code)->first();
                $piims = PurchaseReturnInvoiceItemsModel::where('prii_purchase_invoice_id', $id)
                    ->select('prii_product_name as name', 'prii_remarks as remarks', 'prii_qty as qty', 'prii_rate as rate', 'prii_discount_per as discount', 'prii_discount_amount as discount_amount', 'prii_after_dis_rate as after_discount', 'prii_saletax_per as sale_tax', 'prii_saletax_amount as sale_tax_amount', 'prii_saletax_inclusive as inclu_exclu', 'prii_amount as amount', 'prii_scale_size as scale_size')
                    ->orderby('prii_product_name', 'ASC')
                    ->get();
                $nbrOfWrds = $this->myCnvrtNbr($pim->pri_grand_total);
                $invoice_nbr = $pim->pri_id;
                $invoice_date = $pim->pri_day_end_date;
                $type = 'grid';
                $pge_title = 'Purchase Return Invoice';


                return view('invoice_view.purchase_return_invoice.purchase_return_invoice_list_modal', compact('piims', 'pim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title', 'urdu_eng'));

                break;

            // trade purchase return invoice
            case config('global_variables.TRADE_PURCHASE_RETURN_VOUCHER_CODE'):

                $pim = PurchaseReturnInvoiceModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_purchase_return_invoice.pri_pr_id')->where('pri_id', $id)
                    ->first();
                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $pim->pri_party_code)->first();
                $piims = DB::table('financials_purchase_return_invoice_items')
                    ->join('financials_products', 'financials_products.pro_p_code', '=', 'financials_purchase_return_invoice_items.prii_product_code')
                    ->where('prii_purchase_invoice_id', $id)
                    ->select('financials_products.pro_urdu_title as name', 'prii_remarks as remarks', 'prii_qty as qty', 'prii_rate as rate', 'prii_discount_per as discount', 'prii_discount_amount as discount_amount', 'prii_after_dis_rate as after_discount', 'prii_saletax_per as sale_tax', 'prii_saletax_amount as sale_tax_amount', 'prii_saletax_inclusive as inclu_exclu', 'prii_amount as amount', 'prii_scale_size as scale_size', 'prii_uom as uom')
                    ->orderby('prii_product_name', 'ASC')
                    ->get();
                $nbrOfWrds = $this->myCnvrtNbr($pim->pri_grand_total);
                $invoice_nbr = $pim->pri_id;
                $invoice_date = $pim->pri_day_end_date;
                $type = 'grid';
                $pge_title = 'Trade Purchase Return Invoice';


                return view('trade_invoice_view.trade_purchase_return_invoice.trade_purchase_return_invoice_list_modal', compact('piims', 'pim', 'accnts', 'nbrOfWrds', 'invoice_nbr',
                    'invoice_date', 'type', 'pge_title', 'urdu_eng'));

                break;

            // purchase sale tax invoice
            case config('global_variables.PURCHASE_SALE_TAX_VOUCHER_CODE')://change

                $pim = PurchaseSaletaxInvoiceModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_purchase_saletax_invoice.psi_pr_id')->where('psi_id', $id)->first();
                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $pim->psi_party_code)->first();
                $piims = PurchaseSaletaxItemsInvoiceModel::where('psii_purchase_invoice_id', $id)
                    ->select('psii_product_name as name', 'psii_remarks as remarks', 'psii_qty as qty', 'psii_rate as rate', 'psii_discount_per as discount', 'psii_discount_amount as discount_amount', 'psii_after_dis_rate as after_discount', 'psii_saletax_per as sale_tax', 'psii_saletax_amount as sale_tax_amount', 'psii_saletax_inclusive as inclu_exclu', 'psii_amount as amount', 'psii_scale_size as scale_size')
                    ->orderby('psii_product_name', 'ASC')
                    ->get();
                $nbrOfWrds = $this->myCnvrtNbr($pim->psi_grand_total);
                $invoice_nbr = $pim->psi_id;
                $invoice_date = $pim->psi_day_end_date;
                $type = 'grid';
                $pge_title = 'Sale Tax Purchase Invoice';

                return view('invoice_view.purchase_sale_tax_invoice.purchase_sale_tax_invoice_list_modal', compact('piims', 'pim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title', 'urdu_eng'));

                break;

            // trade purchase sale tax invoice
            case config('global_variables.TRADE_PURCHASE_SALE_TAX_VOUCHER_CODE')://change

                $pim = PurchaseSaletaxInvoiceModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_purchase_saletax_invoice.psi_pr_id')->where('psi_id', $id)->first();
                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $pim->psi_party_code)->first();
                $piims = PurchaseSaletaxItemsInvoiceModel::where('psii_purchase_invoice_id', $id)
                    ->select('psii_product_name as name', 'psii_remarks as remarks', 'psii_qty as qty', 'psii_rate as rate', 'psii_discount_per as discount', 'psii_discount_amount as discount_amount', 'psii_after_dis_rate as after_discount', 'psii_saletax_per as sale_tax', 'psii_saletax_amount as sale_tax_amount', 'psii_saletax_inclusive as inclu_exclu', 'psii_amount as amount', 'psii_scale_size as scale_size')
                    ->orderby('psii_product_name', 'ASC')
                    ->get();
                $nbrOfWrds = $this->myCnvrtNbr($pim->psi_grand_total);
                $invoice_nbr = $pim->psi_id;
                $invoice_date = $pim->psi_day_end_date;
                $type = 'grid';
                $pge_title = 'Trade Sale Tax Purchase Invoice';

                return view('trade_invoice_view.trade_purchase_sale_tax_invoice.trade_purchase_sale_tax_invoice_list_modal', compact('piims', 'pim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title', 'urdu_eng'));

                break;

            // GRN purchase sale tax invoice mustafa
            case config('global_variables.GOODS_RECEIPT_NOTE_PURCHASE_VOUCHER_CODE_PURCHASE_SALE_TAX_VOUCHER_CODE')://change

                $pim = PurchaseSaletaxInvoiceModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_purchase_saletax_invoice.psi_pr_id')->where('psi_id', $id)->first();
                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $pim->psi_party_code)->first();
                $piims = PurchaseSaletaxItemsInvoiceModel::where('psii_purchase_invoice_id', $id)
//                    ->select('psii_product_name as name', 'psii_remarks as remarks', 'psii_qty as qty', 'psii_rate as rate', 'psii_discount as discount', 'psii_saletax as sale_tax', 'psii_amount as amount')
                    ->select('psii_product_name as name', 'psii_remarks as remarks', 'psii_qty as qty', 'psii_rate as rate', 'psii_discount_per as discount', 'psii_after_dis_rate as after_discount', 'psii_saletax_per as sale_tax', 'psii_saletax_amount as sale_tax_amount', 'psii_saletax_inclusive as inclu_exclu', 'psii_amount as amount')
                    ->orderby('psii_product_name', 'ASC')
                    ->get();
                $nbrOfWrds = $this->myCnvrtNbr($pim->psi_grand_total);
                $invoice_nbr = $pim->psi_id;
                $invoice_date = $pim->psi_day_end_date;
                $type = 'grid';
                $pge_title = 'Sale Tax Purchase Invoice';

                return view('invoice_view.purchase_sale_tax_invoice.purchase_sale_tax_invoice_list_modal', compact('piims', 'pim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title', 'urdu_eng'));

                break;

            // trade GRN purchase sale tax invoice mustafa
            case config('global_variables.TRADE_GOODS_RECEIPT_NOTE_PURCHASE_VOUCHER_CODE_PURCHASE_SALE_TAX_VOUCHER_CODE')://change

                $pim = PurchaseSaletaxInvoiceModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_purchase_saletax_invoice.psi_pr_id')->where('psi_id', $id)->first();
                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $pim->psi_party_code)->first();
                $piims = PurchaseSaletaxItemsInvoiceModel::where('psii_purchase_invoice_id', $id)
                    ->select('psii_product_name as name', 'psii_remarks as remarks', 'psii_qty as qty', 'psii_rate as rate', 'psii_discount_per as discount', 'psii_after_dis_rate as after_discount', 'psii_saletax_per as sale_tax', 'psii_saletax_amount as sale_tax_amount', 'psii_saletax_inclusive as inclu_exclu', 'psii_amount as amount')
                    ->orderby('psii_product_name', 'ASC')
                    ->get();
                $nbrOfWrds = $this->myCnvrtNbr($pim->psi_grand_total);
                $invoice_nbr = $pim->psi_id;
                $invoice_date = $pim->psi_day_end_date;
                $type = 'grid';
                $pge_title = 'Trade Sale Tax Purchase Invoice';

                return view('trade_invoice_view.trade_purchase_sale_tax_invoice.trade_purchase_sale_tax_invoice_list_modal', compact('piims', 'pim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title', 'urdu_eng'));

                break;

            // purchase sale tax return invoice
            case config('global_variables.PURCHASE_RETURN_SALE_TAX_VOUCHER_CODE')://change

                $pim = PurchaseReturnSaletaxInvoiceModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_purchase_return_saletax_invoice.prsi_pr_id')->where('prsi_id', $id)->first();
                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $pim->prsi_party_code)->first();
                $piims = PurchaseReturnSaletaxInvoiceItemsModel::where('prsii_purchase_invoice_id', $id)
                    ->select('prsii_product_name as name', 'prsii_remarks as remarks', 'prsii_qty as qty', 'prsii_rate as rate', 'prsii_discount_per as discount', 'prsii_discount_amount as discount_amount',
                        'prsii_after_dis_rate as after_discount', 'prsii_saletax_per as sale_tax', 'prsii_saletax_amount as sale_tax_amount', 'prsii_saletax_inclusive as inclu_exclu', 'prsii_amount as amount', 'prsii_scale_size as scale_size')
                    ->orderby('prsii_product_name', 'ASC')
                    ->get();
                $nbrOfWrds = $this->myCnvrtNbr($pim->prsi_grand_total);
                $invoice_nbr = $pim->prsi_id;
                $invoice_date = $pim->prsi_day_end_date;
                $type = 'grid';
                $pge_title = 'Sale Tax Purchase Return Invoice';

                return view('invoice_view.purchase_return_sale_tax_invoice.purchase_return_sale_tax_invoice_list_modal', compact('piims', 'pim', 'accnts', 'nbrOfWrds', 'invoice_nbr',
                    'invoice_date', 'type', 'pge_title', 'urdu_eng'));


                break;

            // Trade purchase sale tax return invoice
            case config('global_variables.TRADE_PURCHASE_RETURN_SALE_TAX_VOUCHER_CODE')://change

                $pim = PurchaseReturnSaletaxInvoiceModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_purchase_return_saletax_invoice.prsi_pr_id')->where('prsi_id', $id)->first();
                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $pim->prsi_party_code)->first();
                $piims = PurchaseReturnSaletaxInvoiceItemsModel::where('prsii_purchase_invoice_id', $id)
                    ->select('prsii_product_name as name', 'prsii_remarks as remarks', 'prsii_qty as qty', 'prsii_rate as rate', 'prsii_discount_per as discount', 'prsii_discount_amount as discount_amount',
                        'prsii_after_dis_rate as after_discount', 'prsii_saletax_per as sale_tax', 'prsii_saletax_amount as sale_tax_amount', 'prsii_saletax_inclusive as inclu_exclu', 'prsii_amount as amount', 'prsii_scale_size as scale_size')
                    ->orderby('prsii_product_name', 'ASC')
                    ->get();
                $nbrOfWrds = $this->myCnvrtNbr($pim->prsi_grand_total);
                $invoice_nbr = $pim->prsi_id;
                $invoice_date = $pim->prsi_day_end_date;
                $type = 'grid';
                $pge_title = 'TradeSale Tax Purchase Return Invoice';

                return view('trade_invoice_view.trade_purchase_return_sale_tax_invoice.trade_purchase_return_sale_tax_invoice_list_modal', compact('piims', 'pim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title', 'urdu_eng'));


                break;

            // sale invoice
            case config('global_variables.SALE_VOUCHER_CODE'):
                $urdu_eng = ReportConfigModel::where('rc_clg_id', '=', $user->user_clg_id)->select('rc_invoice', 'rc_invoice_party')->first();
                if ($urdu_eng->rc_invoice_party == 0) {
                    $sim = SaleInvoiceModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_sale_invoice.si_pr_id')->where('si_id', $id)->first();
                } else {
                    $sim = DB::table('financials_sale_invoice')
                        ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_sale_invoice.si_party_code')
                        ->leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_sale_invoice.si_pr_id')
                        ->where('si_id', $id)
                        ->select('financials_accounts.account_urdu_name as si_party_name', 'si_id', 'si_party_code', 'si_customer_name', 'si_remarks', 'si_total_items', 'si_total_price',
                            'si_product_disc', 'si_round_off_disc',
                            'si_cash_disc_per', 'si_cash_disc_amount', 'si_total_discount', 'si_inclusive_sales_tax', 'si_exclusive_sales_tax', 'si_total_sales_tax', 'si_grand_total',
                            'si_cash_received', 'si_day_end_id', 'si_day_end_date', 'si_createdby', 'si_sale_person', 'si_service_invoice_id', 'si_local_invoice_id', 'si_local_service_invoice_id', 'si_cash_received_from_customer', 'si_return_amount')->first();
                }
                $seim = ServicesInvoiceModel::where('sei_sale_invoice_id', $id)->first();

                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $sim->si_party_code)->first();

                if ($urdu_eng->rc_invoice == 0) {
                    $services = DB::table('financials_service_invoice_items')
                        ->where('seii_invoice_id', $sim->si_service_invoice_id)
                        ->orderby('seii_service_name', 'ASC')
                        ->select('seii_service_name as name', 'seii_remarks as remarks', 'seii_qty as qty', 'seii_rate as rate', 'seii_discount_per as discount', 'seii_discount_amount as discount_amount', 'seii_after_dis_rate as after_discount', 'seii_saletax_per as sale_tax', 'seii_scale_size as scale_size', 'seii_saletax_amount as sale_tax_amount', 'seii_saletax_inclusive as inclu_exclu', 'seii_amount as amount');
                    $siims = DB::table('financials_sale_invoice_items')
                        ->where('sii_invoice_id', $id)
                        ->orderby('sii_product_name', 'ASC')
                        ->select('sii_product_name as name', 'sii_remarks as remarks', 'sii_qty as qty', 'sii_rate as rate', 'sii_discount_per as discount', 'sii_discount_amount as discount_amount', 'sii_after_dis_rate as after_discount', 'sii_saletax_per as sale_tax', 'sii_scale_size as scale_size', 'sii_saletax_amount as sale_tax_amount', 'sii_saletax_inclusive as inclu_exclu', 'sii_amount as amount')
                        ->union($services)
                        ->get();
                } else {
                    $services = DB::table('financials_service_invoice_items')
                        ->where('seii_invoice_id', $sim->si_service_invoice_id)
                        ->orderby('seii_service_name', 'ASC')
                        ->select('seii_service_name as name', 'seii_remarks as remarks', 'seii_qty as qty', 'seii_rate as rate', 'seii_discount_per as discount', 'seii_discount_amount as discount_amount', 'seii_after_dis_rate as after_discount', 'seii_saletax_per as sale_tax', 'seii_scale_size as scale_size', 'seii_saletax_amount as sale_tax_amount', 'seii_saletax_inclusive as inclu_exclu', 'seii_amount as amount');
                    $siims = DB::table('financials_sale_invoice_items')
                        ->join('financials_products', 'financials_products.pro_p_code', '=', 'financials_sale_invoice_items.sii_product_code')
                        ->where('sii_invoice_id', $id)
                        ->orderby('sii_product_name', 'ASC')
                        ->select('financials_products.pro_urdu_title as name', 'sii_remarks as remarks', 'sii_qty as qty', 'sii_rate as rate', 'sii_discount_per as discount', 'sii_discount_amount as discount_amount', 'sii_after_dis_rate as after_discount', 'sii_saletax_per as sale_tax', 'sii_scale_size as scale_size', 'sii_saletax_amount as sale_tax_amount', 'sii_saletax_inclusive as inclu_exclu', 'sii_amount as amount')
                        ->union($services)
                        ->get();
                }

                $si_grand_total = (isset($sim->si_grand_total) && !empty($sim->si_grand_total)) ? $sim->si_grand_total : 0;
                $sei_grand_total = (isset($seim->sei_grand_total) && !empty($seim->sei_grand_total)) ? $seim->sei_grand_total : 0;
                $mainGrndTtl = +$si_grand_total + +$sei_grand_total;
                $nbrOfWrds = $this->myCnvrtNbr($mainGrndTtl);
                $invoice_nbr = $sim->si_id;
                $invoice_date = $sim->si_day_end_date;

                $si_cash_received = (isset($sim->si_cash_received) && !empty($sim->si_cash_received)) ? $sim->si_cash_received : 0;
                $sei_cash_received = (isset($seim->sei_cash_received) && !empty($seim->sei_cash_received)) ? $seim->sei_cash_received : 0;

                $cash_received = $si_cash_received + $sei_cash_received;

                $type = 'grid';
                $pge_title = 'Sale Invoice';

                return view('invoice_view.sale_invoice.sale_invoice_list_modal', compact('siims', 'sim', 'seim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title', 'cash_received', 'urdu_eng'));

                break;

            // trade sale invoice
            case config('global_variables.TRADE_SALE_VOUCHER_CODE'):
                $urdu_eng = ReportConfigModel::where('rc_id', '=', $user->user_clg_id)->select('rc_invoice', 'rc_invoice_party')->first();
                if ($urdu_eng->rc_invoice_party == 0) {
                    $sim = SaleInvoiceModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_sale_invoice.si_pr_id')->where('si_id', $id)->first();
                } else {
                    $sim = DB::table('financials_sale_invoice')
                        ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_sale_invoice.si_party_code')
                        ->leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_sale_invoice.si_pr_id')
                        ->where('si_id', $id)
                        ->select('financials_accounts.account_urdu_name as si_party_name', 'si_id', 'si_party_code', 'si_customer_name', 'si_remarks', 'si_total_items', 'si_total_price', 'si_product_disc', 'si_round_off_disc', 'si_cash_disc_per', 'si_cash_disc_amount', 'si_total_discount', 'si_inclusive_sales_tax', 'si_exclusive_sales_tax', 'si_total_sales_tax', 'si_grand_total', 'si_cash_received', 'si_day_end_id', 'si_day_end_date', 'si_createdby', 'si_sale_person', 'si_service_invoice_id', 'si_local_invoice_id', 'si_local_service_invoice_id', 'si_cash_received_from_customer', 'si_return_amount', 'pr_name')->first();
                }
                $seim = ServicesInvoiceModel::where('sei_sale_invoice_id', $id)->first();

                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $sim->si_party_code)->first();

                if ($urdu_eng->rc_invoice == 0) {
                    $services = DB::table('financials_service_invoice_items')
                        ->where('seii_invoice_id', $sim->si_service_invoice_id)
                        ->orderby('seii_service_name', 'ASC')
                        ->select('seii_service_name as name', 'seii_remarks as remarks', 'seii_qty as qty', 'seii_rate as rate', 'seii_discount_per as discount', 'seii_discount_amount as discount_amount', 'seii_after_dis_rate as after_discount', 'seii_saletax_per as sale_tax', 'seii_scale_size as scale_size', 'seii_saletax_amount as sale_tax_amount', 'seii_saletax_inclusive as inclu_exclu', 'seii_amount as amount', 'seii_saletax_inclusive as uom');
                    $siims = DB::table('financials_sale_invoice_items')
                        ->where('sii_invoice_id', $id)
                        ->orderby('sii_product_name', 'ASC')
                        ->select('sii_product_name as name', 'sii_remarks as remarks', 'sii_qty as qty', 'sii_rate as rate', 'sii_discount_per as discount', 'sii_discount_amount as discount_amount', 'sii_after_dis_rate as after_discount', 'sii_saletax_per as sale_tax', 'sii_scale_size as scale_size', 'sii_saletax_amount as sale_tax_amount', 'sii_saletax_inclusive as inclu_exclu', 'sii_amount as amount', 'sii_uom as uom')
                        ->union($services)
                        ->get();

                } else {
                    $services = DB::table('financials_service_invoice_items')
                        ->where('seii_invoice_id', $sim->si_service_invoice_id)
                        ->orderby('seii_service_name', 'ASC')
                        ->select('seii_service_name as name', 'seii_remarks as remarks', 'seii_qty as qty', 'seii_rate as rate', 'seii_discount_per as discount', 'seii_discount_amount as discount_amount', 'seii_after_dis_rate as after_discount', 'seii_saletax_per as sale_tax', 'seii_scale_size as scale_size', 'seii_saletax_amount as sale_tax_amount', 'seii_saletax_inclusive as inclu_exclu', 'seii_amount as amount');
                    $siims = DB::table('financials_sale_invoice_items')
                        ->join('financials_products', 'financials_products.pro_p_code', '=', 'financials_sale_invoice_items.sii_product_code')
                        ->where('sii_invoice_id', $id)
                        ->orderby('sii_product_name', 'ASC')
                        ->select('financials_products.pro_urdu_title as name', 'sii_remarks as remarks', 'sii_qty as qty', 'sii_rate as rate', 'sii_discount_per as discount', 'sii_discount_amount as discount_amount', 'sii_after_dis_rate as after_discount', 'sii_saletax_per as sale_tax', 'sii_scale_size as scale_size', 'sii_saletax_amount as sale_tax_amount', 'sii_saletax_inclusive as inclu_exclu', 'sii_amount as amount')
                        ->union($services)
                        ->get();
                }
                $si_grand_total = (isset($sim->si_grand_total) && !empty($sim->si_grand_total)) ? $sim->si_grand_total : 0;
                $sei_grand_total = (isset($seim->sei_grand_total) && !empty($seim->sei_grand_total)) ? $seim->sei_grand_total : 0;
                $mainGrndTtl = +$si_grand_total + +$sei_grand_total;
                $nbrOfWrds = $this->myCnvrtNbr($mainGrndTtl);
                $invoice_nbr = $sim->si_id;
                $invoice_date = $sim->si_day_end_date;

                $si_cash_received = (isset($sim->si_cash_received) && !empty($sim->si_cash_received)) ? $sim->si_cash_received : 0;
                $sei_cash_received = (isset($seim->sei_cash_received) && !empty($seim->sei_cash_received)) ? $seim->sei_cash_received : 0;

                $cash_received = $si_cash_received + $sei_cash_received;

                $type = 'grid';
                $pge_title = 'Trade Sale Invoice';

                return view('trade_invoice_view.trade_sale_invoice.trade_sale_invoice_list_modal', compact('siims', 'sim', 'seim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title', 'cash_received', 'urdu_eng'));

                break;

            // DO sale invoice mustafa
            case config('global_variables.DELIVERY_ORDER_SALE_VOUCHER_CODE'):

                $seim = ServicesInvoiceModel::where('sei_sale_invoice_id', $id)->first();
                $sim = SaleInvoiceModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_sale_invoice.si_pr_id')->where('si_id', $id)->first();
                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $sim->si_party_code)->first();
                $services = DB::table('financials_service_invoice_items')
                    ->where('seii_invoice_id', $sim->si_service_invoice_id)
                    ->orderby('seii_service_name', 'ASC')
                    ->select('seii_service_name as name', 'seii_remarks as remarks', 'seii_qty as qty', 'seii_rate as rate', 'seii_discount_per as discount', 'seii_discount_amount as discount_amount', 'seii_after_dis_rate as after_discount', 'seii_saletax_per as sale_tax', 'seii_scale_size as scale_size', 'seii_saletax_amount as sale_tax_amount', 'seii_saletax_inclusive as inclu_exclu', 'seii_amount as amount');
                $siims = DB::table('financials_sale_invoice_items')
                    ->where('sii_invoice_id', $id)
                    ->orderby('sii_product_name', 'ASC')
                    ->select('sii_product_name as name', 'sii_remarks as remarks', 'sii_qty as qty', 'sii_rate as rate', 'sii_discount_per as discount', 'sii_discount_amount as discount_amount', 'sii_after_dis_rate as after_discount', 'sii_saletax_per as sale_tax', 'sii_scale_size as scale_size', 'sii_saletax_amount as sale_tax_amount', 'sii_saletax_inclusive as inclu_exclu', 'sii_amount as amount')
                    ->union($services)
                    ->get();
                $si_grand_total = (isset($sim->si_grand_total) && !empty($sim->si_grand_total)) ? $sim->si_grand_total : 0;
                $sei_grand_total = (isset($seim->sei_grand_total) && !empty($seim->sei_grand_total)) ? $seim->sei_grand_total : 0;
                $mainGrndTtl = +$si_grand_total + +$sei_grand_total;
                $nbrOfWrds = $this->myCnvrtNbr($mainGrndTtl);
                $invoice_nbr = $sim->si_id;
                $invoice_date = $sim->si_day_end_date;

                $si_cash_received = (isset($sim->si_cash_received) && !empty($sim->si_cash_received)) ? $sim->si_cash_received : 0;
                $sei_cash_received = (isset($seim->sei_cash_received) && !empty($seim->sei_cash_received)) ? $seim->sei_cash_received : 0;

                $cash_received = $si_cash_received + $sei_cash_received;

                $type = 'grid';
                $pge_title = 'Trade Delivery Order Sale Invoice';

                return view('invoice_view.sale_invoice.sale_invoice_list_modal', compact('siims', 'sim', 'seim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title', 'cash_received', 'urdu_eng'));

                break;

            // Trade DO sale invoice mustafa
            case config('global_variables.TRADE_DELIVERY_ORDER_SALE_VOUCHER_CODE'):

                $seim = ServicesInvoiceModel::where('sei_sale_invoice_id', $id)->first();
                $sim = SaleInvoiceModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_sale_invoice.si_pr_id')->where('si_id', $id)->first();
                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $sim->si_party_code)->first();
                $services = DB::table('financials_service_invoice_items')
                    ->where('seii_invoice_id', $sim->si_service_invoice_id)
                    ->orderby('seii_service_name', 'ASC')
                    ->select('seii_service_name as name', 'seii_remarks as remarks', 'seii_qty as qty', 'seii_rate as rate', 'seii_discount_per as discount', 'seii_discount_amount as discount_amount', 'seii_after_dis_rate as after_discount', 'seii_saletax_per as sale_tax', 'seii_scale_size as scale_size', 'seii_saletax_amount as sale_tax_amount', 'seii_saletax_inclusive as inclu_exclu', 'seii_amount as amount');
                $siims = DB::table('financials_sale_invoice_items')
                    ->where('sii_invoice_id', $id)
                    ->orderby('sii_product_name', 'ASC')
                    ->select('sii_product_name as name', 'sii_remarks as remarks', 'sii_qty as qty', 'sii_rate as rate', 'sii_discount_per as discount', 'sii_discount_amount as discount_amount', 'sii_after_dis_rate as after_discount', 'sii_saletax_per as sale_tax', 'sii_scale_size as scale_size', 'sii_saletax_amount as sale_tax_amount', 'sii_saletax_inclusive as inclu_exclu', 'sii_amount as amount')
                    ->union($services)
                    ->get();
                $si_grand_total = (isset($sim->si_grand_total) && !empty($sim->si_grand_total)) ? $sim->si_grand_total : 0;
                $sei_grand_total = (isset($seim->sei_grand_total) && !empty($seim->sei_grand_total)) ? $seim->sei_grand_total : 0;
                $mainGrndTtl = +$si_grand_total + +$sei_grand_total;
                $nbrOfWrds = $this->myCnvrtNbr($mainGrndTtl);
                $invoice_nbr = $sim->si_id;
                $invoice_date = $sim->si_day_end_date;

                $si_cash_received = (isset($sim->si_cash_received) && !empty($sim->si_cash_received)) ? $sim->si_cash_received : 0;
                $sei_cash_received = (isset($seim->sei_cash_received) && !empty($seim->sei_cash_received)) ? $seim->sei_cash_received : 0;

                $cash_received = $si_cash_received + $sei_cash_received;

                $type = 'grid';
                $pge_title = 'Trade Delivery Order Sale Invoice';

                return view('trade_invoice_view.trade_sale_invoice.trade_sale_invoice_list_modal', compact('siims', 'sim', 'seim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title', 'cash_received', 'urdu_eng'));

                break;

            // sale return invoice
            case config('global_variables.SALE_RETURN_VOUCHER_CODE'):

                $urdu_eng = ReportConfigModel::where('rc_id', '=', $user->user_clg_id)->select('rc_invoice', 'rc_invoice_party')->first();
                if ($urdu_eng->rc_invoice_party == 0) {
                    $sim = SaleReturnInvoiceModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_sale_return_invoice.sri_pr_id')->where('sri_id', $id)
                        ->first();
                } else {
                    $sim = DB::table('financials_sale_return_invoice')
                        ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_sale_return_invoice.sri_party_code')
                        ->leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_sale_return_invoice.sri_pr_id')
                        ->where('sri_id', $id)
                        ->select('financials_accounts.account_urdu_name as sri_party_name', 'sri_id', 'sri_party_code', 'sri_customer_name', 'sri_remarks', 'sri_total_items', 'sri_total_price',
                            'sri_product_disc', 'sri_round_off_disc',
                            'sri_cash_disc_per', 'sri_cash_disc_amount', 'sri_total_discount', 'sri_inclusive_sales_tax', 'sri_exclusive_sales_tax', 'sri_total_sales_tax', 'sri_grand_total',
                            'sri_cash_received', 'sri_day_end_id', 'sri_day_end_date', 'sri_createdby', 'sri_sale_person', 'sri_service_invoice_id', 'sri_local_invoice_id', 'sri_local_service_invoice_id', 'sri_cash_received_from_customer', 'sri_return_amount', 'pr_name')->first();
                }

                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $sim->sri_party_code)->first();

                if ($urdu_eng->rc_invoice == 0) {
                    $siims = DB::table('financials_sale_return_invoice_items')
                        ->where('srii_invoice_id', $id)
                        ->orderby('srii_product_name', 'ASC')
                        ->select('srii_product_name as name', 'srii_remarks as remarks', 'srii_qty as qty', 'srii_rate as rate', 'srii_discount_per as discount', 'srii_discount_amount as discount_amount', 'srii_after_dis_rate as after_discount', 'srii_saletax_per as sale_tax', 'srii_saletax_amount as sale_tax_amount', 'srii_saletax_inclusive as inclu_exclu', 'srii_amount as amount', 'srii_scale_size as scale_size', 'srii_saletax_inclusive as type')
                        ->get();
                } else {
                    $siims = DB::table('financials_sale_return_invoice_items')
                        ->join('financials_products', 'financials_products.pro_p_code', '=', 'financials_sale_return_invoice_items.srii_product_code')
                        ->where('srii_invoice_id', $id)
                        ->orderby('srii_product_name', 'ASC')
                        ->select('financials_products.pro_urdu_title as name', 'srii_remarks as remarks', 'srii_qty as qty', 'srii_rate as rate', 'srii_discount_per as discount', 'srii_discount_amount as discount_amount', 'srii_after_dis_rate as after_discount', 'srii_saletax_per as sale_tax', 'srii_saletax_amount as sale_tax_amount', 'srii_saletax_inclusive as inclu_exclu', 'srii_amount as amount', 'srii_scale_size as scale_size', 'srii_saletax_inclusive as type')
                        ->get();

                }

                $nbrOfWrds = $this->myCnvrtNbr($sim->sri_grand_total);
                $invoice_nbr = $sim->sri_id;
                $invoice_date = $sim->sri_day_end_date;
                $type = 'grid';
                $pge_title = 'Sale Return Invoice';

                return view('invoice_view.sale_return_invoice.sale_return_invoice_list_modal', compact('siims', 'sim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title', 'urdu_eng'));

                break;

            // trade sale return invoice
            case config('global_variables.TRADE_SALE_RETURN_VOUCHER_CODE'):

                $urdu_eng = ReportConfigModel::where('rc_id', '=', $user->user_clg_id)->select('rc_invoice', 'rc_invoice_party')->first();
                if ($urdu_eng->rc_invoice_party == 0) {
                    $sim = SaleReturnInvoiceModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_sale_return_invoice.sri_pr_id')->where('sri_id', $id)->first();
                } else {
                    $sim = DB::table('financials_sale_return_invoice')
                        ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_sale_return_invoice.sri_party_code')
                        ->leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_sale_return_invoice.sri_pr_id')
                        ->where('sri_id', $id)
                        ->select('financials_accounts.account_urdu_name as sri_party_name', 'sri_id', 'sri_party_code', 'sri_customer_name', 'sri_remarks', 'sri_total_items', 'sri_total_price', 'sri_product_disc', 'sri_round_off_disc', 'sri_cash_disc_per', 'sri_cash_disc_amount', 'sri_total_discount', 'sri_inclusive_sales_tax', 'sri_exclusive_sales_tax', 'sri_total_sales_tax', 'sri_grand_total', 'sri_cash_received', 'sri_day_end_id', 'sri_day_end_date', 'sri_createdby', 'sri_sale_person', 'sri_service_invoice_id', 'sri_local_invoice_id', 'sri_local_service_invoice_id', 'sri_cash_received_from_customer', 'sri_return_amount', 'pr_name')->first();
                }

                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $sim->sri_party_code)->first();

                if ($urdu_eng->rc_invoice == 0) {
                    $siims = DB::table('financials_sale_return_invoice_items')
                        ->where('srii_invoice_id', $id)
                        ->orderby('srii_product_name', 'ASC')
                        ->select('srii_product_name as name', 'srii_remarks as remarks', 'srii_qty as qty', 'srii_rate as rate', 'srii_discount_per as discount', 'srii_discount_amount as discount_amount', 'srii_after_dis_rate as after_discount', 'srii_saletax_per as sale_tax', 'srii_saletax_amount as sale_tax_amount', 'srii_saletax_inclusive as inclu_exclu', 'srii_amount as amount', 'srii_scale_size as scale_size', 'srii_saletax_inclusive as type', 'srii_uom as uom')
                        ->get();
                } else {
                    $siims = DB::table('financials_sale_return_invoice_items')
                        ->join('financials_products', 'financials_products.pro_p_code', '=', 'financials_sale_return_invoice_items.srii_product_code')
                        ->where('srii_invoice_id', $id)
                        ->orderby('srii_product_name', 'ASC')
                        ->select('financials_products.pro_urdu_title as name', 'srii_remarks as remarks', 'srii_qty as qty', 'srii_rate as rate', 'srii_discount_per as discount', 'srii_discount_amount as discount_amount', 'srii_after_dis_rate as after_discount', 'srii_saletax_per as sale_tax', 'srii_saletax_amount as sale_tax_amount', 'srii_saletax_inclusive as inclu_exclu', 'srii_amount as amount', 'srii_scale_size as scale_size', 'srii_saletax_inclusive as type', 'srii_uom as uom')
                        ->get();

                }
                $nbrOfWrds = $this->myCnvrtNbr($sim->sri_grand_total);
                $invoice_nbr = $sim->sri_id;
                $invoice_date = $sim->sri_day_end_date;
                $type = 'grid';
                $pge_title = 'TradeSale Return Invoice';

                return view('trade_invoice_view.trade_sale_return_invoice.trade_sale_return_invoice_list_modal', compact('siims', 'sim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date',
                    'type', 'pge_title', 'urdu_eng'));

                break;

            // sale sale tax invoice
            case config('global_variables.SALE_SALE_TAX_VOUCHER_CODE')://change

                $urdu_eng = ReportConfigModel::where('rc_id', '=', $user->user_clg_id)->select('rc_invoice', 'rc_invoice_party')->first();
                if ($urdu_eng->rc_invoice_party == 0) {
                    $sim = SaleSaletaxInvoiceModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_sale_saletax_invoice.ssi_pr_id')->where('ssi_id', $id)
                        ->first();
                } else {
                    $sim = DB::table('financials_sale_saletax_invoice')
                        ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_sale_saletax_invoice.ssi_party_code')
                        ->leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_sale_saletax_invoice.ssi_pr_id')
                        ->where('ssi_id', $id)
                        ->select('financials_accounts.account_urdu_name as ssi_party_name', 'ssi_id', 'ssi_party_code', 'ssi_customer_name', 'ssi_remarks', 'ssi_total_items', 'ssi_total_price',
                            'ssi_product_disc', 'ssi_round_off_disc',
                            'ssi_cash_disc_per', 'ssi_cash_disc_amount', 'ssi_total_discount', 'ssi_inclusive_sales_tax', 'ssi_exclusive_sales_tax', 'ssi_total_sales_tax', 'ssi_grand_total',
                            'ssi_cash_received', 'ssi_day_end_id', 'ssi_day_end_date', 'ssi_createdby', 'ssi_sale_person', 'ssi_service_invoice_id', 'ssi_local_invoice_id', 'ssi_local_service_invoice_id', 'ssi_cash_received_from_customer', 'ssi_return_amount', 'pr_name')->first();
                }
                $seim = ServiceSaleTaxInvoiceModel::where('sesi_sale_invoice_id', $id)->first();

                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $sim->ssi_party_code)->first();

                if ($urdu_eng->rc_invoice == 0) {
                    $services = DB::table('financials_service_saletax_invoice_items')
                        ->where('sesii_invoice_id', $sim->ssi_service_invoice_id)
                        ->orderby('sesii_service_name', 'ASC')
                        ->select('sesii_service_name as name', 'sesii_remarks as remarks', 'sesii_qty as qty', 'sesii_rate as rate', 'sesii_discount_per as discount', 'sesii_discount_amount as discount_amount',
                            'sesii_after_dis_rate as after_discount', 'sesii_saletax_per as sale_tax', 'sesii_scale_size as scale_size', 'sesii_saletax_amount as sale_tax_amount', 'sesii_saletax_inclusive as inclu_exclu', 'sesii_amount as amount', 'sesii_saletax_inclusive as type');
                    $siims = DB::table('financials_sale_saletax_invoice_items')
                        ->where('ssii_invoice_id', $id)
                        ->orderby('ssii_product_name', 'ASC')
                        ->select('ssii_product_name as name', 'ssii_remarks as remarks', 'ssii_qty as qty', 'ssii_rate as rate', 'ssii_discount_per as discount', 'ssii_discount_amount as discount_amount', 'ssii_after_dis_rate as after_discount', 'ssii_saletax_per as sale_tax', 'ssii_scale_size as scale_size', 'ssii_saletax_amount as sale_tax_amount', 'ssii_saletax_inclusive as inclu_exclu', 'ssii_amount as amount', 'ssii_saletax_inclusive as type')
                        ->union($services)
                        ->get();
                } else {
                    $services = DB::table('financials_service_saletax_invoice_items')
                        ->where('sesii_invoice_id', $sim->ssi_service_invoice_id)
                        ->orderby('sesii_service_name', 'ASC')
                        ->select('sesii_service_name as name', 'sesii_remarks as remarks', 'sesii_qty as qty', 'sesii_rate as rate', 'sesii_discount_per as discount', 'sesii_discount_amount as discount_amount',
                            'sesii_after_dis_rate as after_discount', 'sesii_saletax_per as sale_tax', 'sesii_scale_size as scale_size', 'sesii_saletax_amount as sale_tax_amount', 'sesii_saletax_inclusive as inclu_exclu', 'sesii_amount as amount', 'sesii_saletax_inclusive as type');
                    $siims = DB::table('financials_sale_saletax_invoice_items')
                        ->join('financials_products', 'financials_products.pro_p_code', '=', 'financials_sale_saletax_invoice_items.ssii_product_code')
                        ->where('ssii_invoice_id', $id)
                        ->orderby('ssii_product_name', 'ASC')
                        ->select('financials_products.pro_urdu_title as name', 'ssii_remarks as remarks', 'ssii_qty as qty', 'ssii_rate as rate', 'ssii_discount_per as discount', 'ssii_discount_amount as discount_amount', 'ssii_after_dis_rate as after_discount', 'ssii_saletax_per as sale_tax', 'ssii_scale_size as scale_size', 'ssii_saletax_amount as sale_tax_amount', 'ssii_saletax_inclusive as inclu_exclu', 'ssii_amount as amount', 'ssii_saletax_inclusive as type')
                        ->union($services)
                        ->get();

                }

                $ssi_grand_total = (isset($sim->ssi_grand_total) && !empty($sim->ssi_grand_total)) ? $sim->ssi_grand_total : 0;
                $sesi_grand_total = (isset($seim->sesi_grand_total) && !empty($seim->sesi_grand_total)) ? $seim->sesi_grand_total : 0;
                $mainGrndTtl = +$ssi_grand_total + +$sesi_grand_total;
                $nbrOfWrds = $this->myCnvrtNbr($mainGrndTtl);
                $invoice_nbr = $sim->ssi_id;
                $invoice_date = $sim->ssi_day_end_date;
                $ssi_cash_received = (isset($sim->ssi_cash_received) && !empty($sim->ssi_cash_received)) ? $sim->ssi_cash_received : 0;
                $sesi_cash_received = (isset($seim->sesi_cash_received) && !empty($seim->sesi_cash_received)) ? $seim->sesi_cash_received : 0;
                $cash_received = $ssi_cash_received + $sesi_cash_received;
                $type = 'grid';
                $pge_title = 'Sale Tax Sale Invoice';

                return view('invoice_view.sale_sale_tax_invoice.sale_sale_tax_invoice_list_modal', compact('siims', 'sim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title',
                    'seim', 'cash_received', 'urdu_eng'));


                break;

            // trade sale sale tax invoice
            case config('global_variables.TRADE_SALE_SALE_TAX_VOUCHER_CODE')://change

                $urdu_eng = ReportConfigModel::where('rc_id', '=', $user->user_clg_id)->select('rc_invoice', 'rc_invoice_party')->first();
                if ($urdu_eng->rc_invoice_party == 0) {
                    $sim = SaleSaletaxInvoiceModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_sale_saletax_invoice.ssi_pr_id')->where('ssi_id', $id)->first();
                } else {
                    $sim = DB::table('financials_sale_saletax_invoice')
                        ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_sale_saletax_invoice.ssi_party_code')
                        ->leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_sale_saletax_invoice.ssi_pr_id')
                        ->where('ssi_id', $id)
                        ->select('financials_accounts.account_urdu_name as ssi_party_name', 'ssi_id', 'ssi_party_code', 'ssi_customer_name', 'ssi_remarks', 'ssi_total_items', 'ssi_total_price', 'ssi_product_disc', 'ssi_round_off_disc', 'ssi_cash_disc_per', 'ssi_cash_disc_amount', 'ssi_total_discount', 'ssi_inclusive_sales_tax', 'ssi_exclusive_sales_tax', 'ssi_total_sales_tax', 'ssi_grand_total', 'ssi_cash_received', 'ssi_day_end_id', 'ssi_day_end_date', 'ssi_createdby', 'ssi_sale_person', 'ssi_service_invoice_id', 'ssi_local_invoice_id', 'ssi_local_service_invoice_id', 'ssi_cash_received_from_customer', 'ssi_return_amount', 'pr_name')->first();
                }
                $seim = ServiceSaleTaxInvoiceModel::where('sesi_sale_invoice_id', $id)->first();

                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $sim->ssi_party_code)->first();

                if ($urdu_eng->rc_invoice == 0) {
                    $services = DB::table('financials_service_saletax_invoice_items')
                        ->where('sesii_invoice_id', $sim->ssi_service_invoice_id)
                        ->orderby('sesii_service_name', 'ASC')
                        ->select('sesii_service_name as name', 'sesii_remarks as remarks', 'sesii_qty as qty', 'sesii_rate as rate', 'sesii_discount_per as discount', 'sesii_discount_amount as discount_amount',
                            'sesii_after_dis_rate as after_discount', 'sesii_saletax_per as sale_tax', 'sesii_scale_size as scale_size', 'sesii_saletax_amount as sale_tax_amount', 'sesii_saletax_inclusive as inclu_exclu', 'sesii_amount as amount', 'sesii_saletax_inclusive as type', 'sesii_saletax_inclusive as uom');
                    $siims = DB::table('financials_sale_saletax_invoice_items')
                        ->where('ssii_invoice_id', $id)
                        ->orderby('ssii_product_name', 'ASC')
                        ->select('ssii_product_name as name', 'ssii_remarks as remarks', 'ssii_qty as qty', 'ssii_rate as rate', 'ssii_discount_per as discount', 'ssii_discount_amount as discount_amount', 'ssii_after_dis_rate as after_discount', 'ssii_saletax_per as sale_tax', 'ssii_scale_size as scale_size', 'ssii_saletax_amount as sale_tax_amount', 'ssii_saletax_inclusive as inclu_exclu', 'ssii_amount as amount', 'ssii_saletax_inclusive as type', 'ssii_uom as uom')
                        ->union($services)
                        ->get();
                } else {

                    $services = DB::table('financials_service_saletax_invoice_items')
                        ->where('sesii_invoice_id', $sim->ssi_service_invoice_id)
                        ->orderby('sesii_service_name', 'ASC')
                        ->select('sesii_service_name as name', 'sesii_remarks as remarks', 'sesii_qty as qty', 'sesii_rate as rate', 'sesii_discount_per as discount', 'sesii_discount_amount as discount_amount',
                            'sesii_after_dis_rate as after_discount', 'sesii_saletax_per as sale_tax', 'sesii_scale_size as scale_size', 'sesii_saletax_amount as sale_tax_amount', 'sesii_saletax_inclusive as inclu_exclu', 'sesii_amount as amount', 'sesii_saletax_inclusive as type', 'sesii_saletax_inclusive as uom');
                    $siims = DB::table('financials_sale_saletax_invoice_items')
                        ->join('financials_products', 'financials_products.pro_p_code', '=', 'financials_sale_saletax_invoice_items.ssii_product_code')
                        ->where('ssii_invoice_id', $id)
                        ->orderby('ssii_product_name', 'ASC')
                        ->select('financials_products.pro_urdu_title as name', 'ssii_remarks as remarks', 'ssii_qty as qty', 'ssii_rate as rate', 'ssii_discount_per as discount', 'ssii_discount_amount as discount_amount', 'ssii_after_dis_rate as after_discount', 'ssii_saletax_per as sale_tax', 'ssii_scale_size as scale_size', 'ssii_saletax_amount as sale_tax_amount', 'ssii_saletax_inclusive as inclu_exclu', 'ssii_amount as amount', 'ssii_saletax_inclusive as type', 'ssii_uom as uom')
                        ->union($services)
                        ->get();

                }


                $ssi_grand_total = (isset($sim->ssi_grand_total) && !empty($sim->ssi_grand_total)) ? $sim->ssi_grand_total : 0;
                $sesi_grand_total = (isset($seim->sesi_grand_total) && !empty($seim->sesi_grand_total)) ? $seim->sesi_grand_total : 0;
                $mainGrndTtl = +$ssi_grand_total + +$sesi_grand_total;
                $nbrOfWrds = $this->myCnvrtNbr($mainGrndTtl);
                $invoice_nbr = $sim->ssi_id;
                $invoice_date = $sim->ssi_day_end_date;
                $ssi_cash_received = (isset($sim->ssi_cash_received) && !empty($sim->ssi_cash_received)) ? $sim->ssi_cash_received : 0;
                $sesi_cash_received = (isset($seim->sesi_cash_received) && !empty($seim->sesi_cash_received)) ? $seim->sesi_cash_received : 0;
                $cash_received = $ssi_cash_received + $sesi_cash_received;
                $type = 'grid';
                $pge_title = 'Trade Sale Tax Sale Invoice';

                return view('trade_invoice_view.trade_sale_sale_tax_invoice.trade_sale_sale_tax_invoice_list_modal', compact('siims', 'sim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title', 'seim', 'cash_received', 'urdu_eng'));


                break;

            // DO sale sale tax invoice mustafa
            case config('global_variables.DELIVERY_ORDER_SALE_TAX_VOUCHER_CODE')://change

                $seim = ServiceSaleTaxInvoiceModel::where('sesi_sale_invoice_id', $id)->first();
                $sim = SaleSaletaxInvoiceModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_sale_saletax_invoice.ssi_pr_id')->where('ssi_id', $id)->first();
                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $sim->ssi_party_code)->first();
                $services = DB::table('financials_service_saletax_invoice_items')
                    ->where('sesii_invoice_id', $sim->ssi_service_invoice_id)
                    ->orderby('sesii_service_name', 'ASC')
                    ->select('sesii_service_name as name', 'sesii_remarks as remarks', 'sesii_qty as qty', 'sesii_rate as rate', 'sesii_discount_per as discount', 'sesii_discount_amount as discount_amount',
                        'sesii_after_dis_rate as after_discount', 'sesii_saletax_per as sale_tax', 'sesii_scale_size as scale_size', 'sesii_saletax_amount as sale_tax_amount', 'sesii_saletax_inclusive as inclu_exclu', 'sesii_amount as amount', 'sesii_saletax_inclusive as type');
                $siims = DB::table('financials_sale_saletax_invoice_items')
                    ->where('ssii_invoice_id', $id)
                    ->orderby('ssii_product_name', 'ASC')
                    ->select('ssii_product_name as name', 'ssii_remarks as remarks', 'ssii_qty as qty', 'ssii_rate as rate', 'ssii_discount_per as discount', 'ssii_discount_amount as discount_amount', 'ssii_after_dis_rate as after_discount', 'ssii_saletax_per as sale_tax', 'ssii_scale_size as scale_size', 'ssii_saletax_amount as sale_tax_amount', 'ssii_saletax_inclusive as inclu_exclu', 'ssii_amount as amount', 'ssii_saletax_inclusive as type')
                    ->union($services)
                    ->get();
                $ssi_grand_total = (isset($sim->ssi_grand_total) && !empty($sim->ssi_grand_total)) ? $sim->ssi_grand_total : 0;
                $sesi_grand_total = (isset($seim->sesi_grand_total) && !empty($seim->sesi_grand_total)) ? $seim->sesi_grand_total : 0;
                $mainGrndTtl = +$ssi_grand_total + +$sesi_grand_total;
                $nbrOfWrds = $this->myCnvrtNbr($mainGrndTtl);
                $invoice_nbr = $sim->ssi_id;
                $invoice_date = $sim->ssi_day_end_date;
                $ssi_cash_received = (isset($sim->ssi_cash_received) && !empty($sim->ssi_cash_received)) ? $sim->ssi_cash_received : 0;
                $sesi_cash_received = (isset($seim->sesi_cash_received) && !empty($seim->sesi_cash_received)) ? $seim->sesi_cash_received : 0;
                $cash_received = $ssi_cash_received + $sesi_cash_received;
                $type = 'grid';
                $pge_title = 'Trade Delivery Order Sale Tax Sale Invoice';


                return view('invoice_view.sale_sale_tax_invoice.sale_sale_tax_invoice_list_modal', compact('siims', 'sim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title',
                    'seim', 'cash_received', 'urdu_eng'));


                break;

            // Trade DO sale sale tax invoice mustafa
            case config('global_variables.TRADE_DELIVERY_ORDER_SALE_TAX_VOUCHER_CODE')://change

                $seim = ServiceSaleTaxInvoiceModel::where('sesi_sale_invoice_id', $id)->first();
                $sim = SaleSaletaxInvoiceModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_sale_saletax_invoice.ssi_pr_id')->where('ssi_id', $id)->first();
                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $sim->ssi_party_code)->first();
                $services = DB::table('financials_service_saletax_invoice_items')
                    ->where('sesii_invoice_id', $sim->ssi_service_invoice_id)
                    ->orderby('sesii_service_name', 'ASC')
                    ->select('sesii_service_name as name', 'sesii_remarks as remarks', 'sesii_qty as qty', 'sesii_rate as rate', 'sesii_discount_per as discount', 'sesii_discount_amount as discount_amount',
                        'sesii_after_dis_rate as after_discount', 'sesii_saletax_per as sale_tax', 'sesii_scale_size as scale_size', 'sesii_saletax_amount as sale_tax_amount', 'sesii_saletax_inclusive as inclu_exclu', 'sesii_amount as amount', 'sesii_saletax_inclusive as type');
                $siims = DB::table('financials_sale_saletax_invoice_items')
                    ->where('ssii_invoice_id', $id)
                    ->orderby('ssii_product_name', 'ASC')
                    ->select('ssii_product_name as name', 'ssii_remarks as remarks', 'ssii_qty as qty', 'ssii_rate as rate', 'ssii_discount_per as discount', 'ssii_discount_amount as discount_amount', 'ssii_after_dis_rate as after_discount', 'ssii_saletax_per as sale_tax', 'ssii_scale_size as scale_size', 'ssii_saletax_amount as sale_tax_amount', 'ssii_saletax_inclusive as inclu_exclu', 'ssii_amount as amount', 'ssii_saletax_inclusive as type')
                    ->union($services)
                    ->get();
                $ssi_grand_total = (isset($sim->ssi_grand_total) && !empty($sim->ssi_grand_total)) ? $sim->ssi_grand_total : 0;
                $sesi_grand_total = (isset($seim->sesi_grand_total) && !empty($seim->sesi_grand_total)) ? $seim->sesi_grand_total : 0;
                $mainGrndTtl = +$ssi_grand_total + +$sesi_grand_total;
                $nbrOfWrds = $this->myCnvrtNbr($mainGrndTtl);
                $invoice_nbr = $sim->ssi_id;
                $invoice_date = $sim->ssi_day_end_date;
                $ssi_cash_received = (isset($sim->ssi_cash_received) && !empty($sim->ssi_cash_received)) ? $sim->ssi_cash_received : 0;
                $sesi_cash_received = (isset($seim->sesi_cash_received) && !empty($seim->sesi_cash_received)) ? $seim->sesi_cash_received : 0;
                $cash_received = $ssi_cash_received + $sesi_cash_received;
                $type = 'grid';
                $pge_title = 'Trade Delivery Order Sale Tax Sale Invoice';

                return view('trade_invoice_view.trade_sale_sale_tax_invoice.trade_sale_sale_tax_invoice_list_modal', compact('siims', 'sim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title', 'seim', 'cash_received', 'urdu_eng'));


                break;

            // sale return sale tax invoice
            case config('global_variables.SALE_RETURN_SALE_TAX_VOUCHER_CODE')://change

                if ($urdu_eng->rc_invoice_party == 0) {
                    $sim = SaleReturnSaletaxInvoiceModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_sale_return_saletax_invoice.srsi_pr_id')->where('srsi_id', $id)->first();
                } else {
                    $sim = DB::table('financials_sale_return_saletax_invoice')
                        ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_sale_return_saletax_invoice.srsi_party_code')
                        ->leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_sale_return_saletax_invoice.srsi_pr_id')
                        ->where('srsi_id', $id)
                        ->select('financials_accounts.account_urdu_name as srsi_party_name', 'srsi_id', 'srsi_party_code', 'srsi_customer_name', 'srsi_remarks', 'srsi_total_items', 'srsi_total_price', 'srsi_product_disc', 'srsi_round_off_disc', 'srsi_cash_disc_per', 'srsi_cash_disc_amount', 'srsi_total_discount', 'srsi_inclusive_sales_tax', 'srsi_exclusive_sales_tax', 'srsi_total_sales_tax', 'srsi_grand_total',
                            'srsi_cash_received', 'srsi_day_end_id', 'srsi_day_end_date', 'srsi_createdby', 'srsi_sale_person', 'srsi_service_invoice_id', 'srsi_local_invoice_id', 'srsi_local_service_invoice_id', 'srsi_cash_received_from_customer', 'srsi_return_amount', 'pr_name')->first();
                }

                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $sim->srsi_party_code)->first();

                if ($urdu_eng->rc_invoice == 0) {
                    $siims = DB::table('financials_sale_return_saletax_invoice_items')
                        ->where('srsii_invoice_id', $id)
                        ->orderby('srsii_product_name', 'ASC')
                        ->select('srsii_product_name as name', 'srsii_remarks as remarks', 'srsii_qty as qty', 'srsii_rate as rate', 'srsii_discount_per as discount', 'srsii_discount_amount as discount_amount',
                            'srsii_after_dis_rate as after_discount', 'srsii_saletax_per as sale_tax', 'srsii_saletax_amount as sale_tax_amount', 'srsii_saletax_inclusive as inclu_exclu', 'srsii_amount as amount', 'srsii_saletax_inclusive as type', 'srsii_scale_size as scale_size', 'srsii_saletax_inclusive as type')
                        ->get();
                } else {
                    $siims = DB::table('financials_sale_return_saletax_invoice_items')
                        ->join('financials_products', 'financials_products.pro_p_code', '=', 'financials_sale_return_saletax_invoice_items.srsii_product_code')
                        ->where('srsii_invoice_id', $id)
                        ->orderby('srsii_product_name', 'ASC')
                        ->select('financials_products.pro_urdu_title as name', 'srsii_remarks as remarks', 'srsii_qty as qty', 'srsii_rate as rate', 'srsii_discount_per as discount', 'srsii_discount_amount as discount_amount',
                            'srsii_after_dis_rate as after_discount', 'srsii_saletax_per as sale_tax', 'srsii_saletax_amount as sale_tax_amount', 'srsii_saletax_inclusive as inclu_exclu', 'srsii_amount as amount', 'srsii_saletax_inclusive as type', 'srsii_scale_size as scale_size', 'srsii_saletax_inclusive as type')
                        ->get();
                }
                $nbrOfWrds = $this->myCnvrtNbr($sim->srsi_grand_total);
                $invoice_nbr = $sim->srsi_id;
                $invoice_date = $sim->srsi_day_end_date;
                $type = 'grid';
                $pge_title = 'Sale Return Sale Tax Invoice';

                return view('invoice_view.sale_return_sale_tax_invoice.sale_return_sale_tax_invoice_list_modal', compact('siims', 'sim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date',
                    'type', 'pge_title', 'urdu_eng'));

                break;

            // trade sale return sale tax invoice
            case config('global_variables.TRADE_SALE_RETURN_SALE_TAX_VOUCHER_CODE')://change

                if ($urdu_eng->rc_invoice_party == 0) {
                    $sim = SaleReturnSaletaxInvoiceModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_sale_return_saletax_invoice.srsi_pr_id')->where('srsi_id', $id)->first();
                } else {
                    $sim = DB::table('financials_sale_return_saletax_invoice')
                        ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_sale_return_saletax_invoice.srsi_party_code')
                        ->leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_sale_return_saletax_invoice.srsi_pr_id')
                        ->where('srsi_id', $id)
                        ->select('financials_accounts.account_urdu_name as srsi_party_name', 'srsi_id', 'srsi_party_code', 'srsi_customer_name', 'srsi_remarks', 'srsi_total_items', 'srsi_total_price', 'srsi_product_disc', 'srsi_round_off_disc', 'srsi_cash_disc_per', 'srsi_cash_disc_amount', 'srsi_total_discount', 'srsi_inclusive_sales_tax', 'srsi_exclusive_sales_tax', 'srsi_total_sales_tax', 'srsi_grand_total',
                            'srsi_cash_received', 'srsi_day_end_id', 'srsi_day_end_date', 'srsi_createdby', 'srsi_sale_person', 'srsi_service_invoice_id', 'srsi_local_invoice_id', 'srsi_local_service_invoice_id', 'srsi_cash_received_from_customer', 'srsi_return_amount', 'pr_name')->first();
                }
                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $sim->srsi_party_code)->first();

                if ($urdu_eng->rc_invoice == 0) {
                    $siims = DB::table('financials_sale_return_saletax_invoice_items')
                        ->where('srsii_invoice_id', $id)
                        ->orderby('srsii_product_name', 'ASC')
                        ->select('srsii_product_name as name', 'srsii_remarks as remarks', 'srsii_qty as qty', 'srsii_rate as rate', 'srsii_discount_per as discount', 'srsii_discount_amount as discount_amount',
                            'srsii_after_dis_rate as after_discount', 'srsii_saletax_per as sale_tax', 'srsii_saletax_amount as sale_tax_amount', 'srsii_saletax_inclusive as inclu_exclu', 'srsii_amount as amount', 'srsii_saletax_inclusive as type', 'srsii_scale_size as scale_size', 'srsii_saletax_inclusive as type', 'srsii_uom as uom')
                        ->get();
                } else {
                    $siims = DB::table('financials_sale_return_saletax_invoice_items')
                        ->join('financials_products', 'financials_products.pro_p_code', '=', 'financials_sale_return_saletax_invoice_items.srsii_product_code')
                        ->where('srsii_invoice_id', $id)
                        ->orderby('srsii_product_name', 'ASC')
                        ->select('financials_products.pro_urdu_title as name', 'srsii_remarks as remarks', 'srsii_qty as qty', 'srsii_rate as rate', 'srsii_discount_per as discount', 'srsii_discount_amount as discount_amount',
                            'srsii_after_dis_rate as after_discount', 'srsii_saletax_per as sale_tax', 'srsii_saletax_amount as sale_tax_amount', 'srsii_saletax_inclusive as inclu_exclu', 'srsii_amount as amount', 'srsii_saletax_inclusive as type', 'srsii_scale_size as scale_size', 'srsii_saletax_inclusive as type', 'srsii_uom as uom')
                        ->get();
                }

                $nbrOfWrds = $this->myCnvrtNbr($sim->srsi_grand_total);
                $invoice_nbr = $sim->srsi_id;
                $invoice_date = $sim->srsi_day_end_date;
                $type = 'grid';
                $pge_title = 'Trade Sale Return Sale Tax Invoice';

                return view('trade_invoice_view.trade_sale_tax_sale_return_invoice.trade_sale_return_sale_tax_invoice_list_modal', compact('siims', 'sim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date',
                    'type', 'pge_title', 'urdu_eng'));
                break;

            // journal voucher
            case config('global_variables.JOURNAL_VOUCHER_CODE'):

                $jrnl = JournalVoucherModel::where('jv_id', $id)->first();
                $items = JournalVoucherItemsModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_journal_voucher_items.jvi_pr_id')->where('jvi_journal_voucher_id', $id)->get();
                $nbrOfWrds = $this->myCnvrtNbr($jrnl->jv_total_dr);
                $invoice_nbr = $jrnl->jv_id;
                $invoice_date = $jrnl->jv_day_end_date;
                $invoice_remarks = $jrnl->jv_remarks;
                $type = 'grid';
                $pge_title = 'Journal Voucher';

                return view('voucher_view.journal_voucher.journal_voucher_list_modal', compact('items', 'jrnl', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));

                break;

            // cash receipt voucher
            case config('global_variables.CASH_RECEIPT_VOUCHER_CODE'):

                $csh_rcpt = CashReceiptVoucherModel::where('cr_id', $id)->first();
                $items = CashReceiptVoucherItemsModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_cash_receipt_voucher_items.cri_pr_id')->where('cri_voucher_id', $id)->orderby('cri_account_name', 'ASC')->get();
                $cr_acnt_nme = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', config('global_variables.cash_in_hand'))->first();
                $nbrOfWrds = $this->myCnvrtNbr($csh_rcpt->cr_total_amount);
                $invoice_nbr = $csh_rcpt->cr_id;
                $invoice_date = $csh_rcpt->cr_day_end_date;
                $invoice_remarks = $csh_rcpt->cr_remarks;
                $type = 'grid';
                $pge_title = 'Cash Receipt Voucher';

                return view('voucher_view.cash_voucher.cash_receipt_journal_voucher_list_modal', compact('items', 'csh_rcpt', 'nbrOfWrds', 'cr_acnt_nme', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'))->render();

                break;

            // cash payment voucher
            case config('global_variables.CASH_PAYMENT_VOUCHER_CODE'):

                $csh_pymnt = CashPaymentVoucherModel::where('cp_id', $id)->first();
                $items = CashPaymentVoucherItemsModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_cash_payment_voucher_items.cpi_pr_id')->where('cpi_voucher_id', $id)->orderby('cpi_account_name', 'ASC')->get();
                $cp_acnt_nme = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $csh_pymnt->cp_account_id)->first();
                $nbrOfWrds = $this->myCnvrtNbr($csh_pymnt->cp_total_amount);
                $invoice_nbr = $csh_pymnt->cp_id;
                $invoice_date = $csh_pymnt->cp_day_end_date;
                $invoice_remarks = $csh_pymnt->cp_remarks;
                $type = 'grid';
                $pge_title = 'Cash Payment Voucher';

                return view('voucher_view.cash_payment_voucher.cash_payment_journal_voucher_list_modal', compact('items', 'csh_pymnt', 'nbrOfWrds', 'cp_acnt_nme', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));

                break;

            // bank receipt voucher
            case config('global_variables.BANK_RECEIPT_VOUCHER_CODE'):

                $bnk_rcpt = BankReceiptVoucherModel::where('br_id', $id)->first();
                $items = BankReceiptVoucherItemsModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_bank_receipt_voucher_items.bri_pr_id')->where('bri_voucher_id', $id)->orderby('bri_account_name', 'ASC')->get();
                $br_acnt_nme = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $bnk_rcpt->br_account_id)->first();
                $nbrOfWrds = $this->myCnvrtNbr($bnk_rcpt->br_total_amount);
                $invoice_nbr = $bnk_rcpt->br_id;
                $invoice_date = $bnk_rcpt->br_day_end_date;
                $invoice_remarks = $bnk_rcpt->br_remarks;
                $type = 'grid';
                $pge_title = 'Bank Receipt Voucher';

                return view('voucher_view.bank_voucher.bank_receipt_journal_voucher_list_modal', compact('items', 'bnk_rcpt', 'nbrOfWrds', 'br_acnt_nme', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));

                break;

            // bank payment voucher
            case config('global_variables.BANK_PAYMENT_VOUCHER_CODE'):

                $bnk_pmnt = BankPaymentVoucherModel::where('bp_id', $id)->first();
                $items = BankPaymentVoucherItemsModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_bank_payment_voucher_items.bpi_pr_id')->where('bpi_voucher_id', $id)->orderby('bpi_account_name', 'ASC')->get();
                $bp_acnt_nme = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $bnk_pmnt->bp_account_id)->first();
                $nbrOfWrds = $this->myCnvrtNbr($bnk_pmnt->bp_total_amount);
                $invoice_nbr = $bnk_pmnt->bp_id;
                $invoice_date = $bnk_pmnt->bp_day_end_date;
                $invoice_remarks = $bnk_pmnt->bp_remarks;
                $type = 'grid';
                $pge_title = 'Bank Payment Voucher';

                return view('voucher_view.bank_payment_voucher.bank_payment_journal_voucher_list_modal', compact('items', 'bnk_pmnt', 'nbrOfWrds', 'bp_acnt_nme', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));

                break;

            // expense payment voucher
            case config('global_variables.EXPENSE_PAYMENT_VOUCHER_CODE'):

                $expns = ExpensePaymentVoucherModel::where('ep_id', $id)->first();
                $items = ExpensePaymentVoucherItemsModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_expense_payment_voucher_items.epi_pr_id')->where('epi_voucher_id', $id)->orderby('epi_account_name', 'ASC')->get();
                $ep_acnt_nme = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $expns->ep_account_id)->first();
                $nbrOfWrds = $this->myCnvrtNbr($expns->ep_total_amount);
                $invoice_nbr = $expns->ep_id;
                $invoice_date = $expns->ep_day_end_date;
                $invoice_remarks = $expns->ep_remarks;
                $type = 'grid';
                $pge_title = 'Expense Payment Voucher';

                return view('voucher_view.expense_payment_voucher.expense_payment_journal_voucher_list_modal', compact('items', 'expns', 'nbrOfWrds', 'ep_acnt_nme', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));

                break;

            // service invoice
            case config('global_variables.SERVICE_VOUCHER_CODE'):

                $seim = ServicesInvoiceModel::where('sei_id', $id)->first();
                $sim = SaleInvoiceModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_sale_invoice.si_pr_id')->where('si_service_invoice_id', $id)->first();
                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $sim->sei_party_code)->first();
                $sales = DB::table('financials_sale_invoice_items')
                    ->where('sii_invoice_id', $seim->sesi_sale_invoice_id)
                    ->orderby('sii_product_name', 'ASC')
                    ->select('sii_product_name as name', 'sii_remarks as remarks', 'sii_qty as qty', 'sii_rate as rate', 'sii_discount_per as discount', 'sii_after_dis_rate as after_discount', 'sii_saletax_per as sale_tax', 'sii_saletax_amount as sale_tax_amount', 'sii_saletax_inclusive as inclu_exclu', 'sii_amount as amount');

                $siims = DB::table('financials_service_invoice_items')
                    ->where('seii_invoice_id', $sim->si_service_invoice_id)
                    ->orderby('seii_service_name', 'ASC')
                    ->select('seii_service_name as name', 'seii_remarks as remarks', 'seii_qty as qty', 'seii_rate as rate', 'seii_discount_per as discount', 'seii_after_dis_rate as after_discount', 'seii_saletax_per as sale_tax', 'seii_saletax_amount as sale_tax_amount', 'seii_saletax_inclusive as inclu_exclu', 'seii_amount as amount')
                    ->union($sales)
                    ->get();

                $nbrOfWrds = $this->myCnvrtNbr($sim->sei_grand_total);
                $invoice_nbr = $sim->sei_id;
                $invoice_date = $sim->sei_day_end_date;
                $type = 'grid';
                $pge_title = 'Services Invoice';


                return view('invoice_view.service_invoice.service_invoice_list_modal', compact('siims', 'sim', 'seim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title'));

                break;

            // service sale tax invoice
            case config('global_variables.SERVICE_SALE_TAX_VOUCHER_CODE')://change

                $sim = ServiceSaleTaxInvoiceModel::where('sesi_id', $id)->first();
                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $sim->sesi_party_code)->first();
                $siims = ServiceSaleTaxInvoiceItemsModel::where('sesii_invoice_id', $id)
                    ->select('sesii_service_name as name', 'sesii_remarks as remarks', 'sesii_qty as qty', 'sesii_rate as rate', 'sesii_discount_per as discount', 'sesii_after_dis_rate as after_discount', 'sesii_saletax_per as sale_tax', 'sesii_saletax_amount as sale_tax_amount', 'sesii_saletax_inclusive as inclu_exclu', 'sesii_amount as amount')
                    ->orderby('sesii_service_name', 'ASC')
                    ->get();
                $nbrOfWrds = $this->myCnvrtNbr($sim->sesi_grand_total);
                $invoice_nbr = $sim->sesi_id;
                $invoice_date = $sim->sesi_day_end_date;
                $type = 'grid';
                $pge_title = 'Services Sale Tax Invoice';


                return view('invoice_view.service_sale_tax_invoice.service_sale_tax_invoice_list_modal', compact('siims', 'sim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title'));

                break;

            // salary slip voucher
            case config('global_variables.SALARY_SLIP_VOUCHER_CODE'):

                $slry_slp = SalarySlipVoucherModel::where('ss_id', $request->id)->first();
                $items = SalarySlipVoucherItemsModel::where('ssi_salary_slip_voucher_id', $request->id)->orderby('ssi_adv_account_name', 'ASC')->get();
                $nbrOfWrds = $this->myCnvrtNbr($slry_slp->ss_total_amount);
                $invoice_nbr = $slry_slp->ss_id;
                $invoice_date = $slry_slp->ss_day_end_date;
                $invoice_remarks = $slry_slp->ss_remarks;
                $type = 'grid';
                $pge_title = 'Salary Slip Voucher';

                return view('voucher_view.salary_slip_voucher.salary_slip_voucher_list_modal', compact('items', 'slry_slp', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title', 'invoice_remarks'));

                break;

            // salary payment voucher
            case config('global_variables.SALARY_PAYMENT_VOUCHER_CODE'):

                $slry_pmnt = SalaryPaymentVoucherModel::where('sp_id', $id)->first();
                $items = SalaryPaymentVoucherItemsModel::where('spi_sp_id', $id)->orderby('spi_account_name', 'ASC')->get();
                $sp_acnt_nme = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $slry_pmnt->sp_payment_account)->first();
                $nbrOfWrds = $this->myCnvrtNbr($slry_pmnt->sp_total_amount);
                $invoice_nbr = $slry_pmnt->sp_id;
                $invoice_date = $slry_pmnt->sp_day_end_date;
                $invoice_remarks = $slry_pmnt->sp_remarks;
                $type = 'grid';
                $pge_title = 'Salary Payment Voucher';


                return view('voucher_view.salary_payment_voucher.salary_payment_journal_voucher_list_modal', compact('items', 'slry_pmnt', 'sp_acnt_nme', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));

                break;

            // cash transfer voucher
            case config('global_variables.CASH_TRANSFER_CODE'):
                //pending because of not working
                $cash_trnsfr = CashTransferModel::where('ct_id', $id)->first();
                $usr_snd = User::where('user_id', $cash_trnsfr->ct_send_by)->pluck('user_name');
                $usr_rcvd = User::where('user_id', $cash_trnsfr->ct_receive_by)->pluck('user_name');
                $nbrOfWrds = $this->myCnvrtNbr($cash_trnsfr->ct_amount);
                $invoice_nbr = $cash_trnsfr->ct_id;
                $invoice_date = $cash_trnsfr->ct_day_end_date;
                $invoice_remarks = $cash_trnsfr->ct_remarks;
                $type = 'grid';
                $pge_title = 'Cash Transfer Voucher';


                return view('voucher_view.cash_transfer_voucher.cash_transfer_journal_voucher_list_modal', compact('cash_trnsfr', 'usr_snd', 'usr_rcvd', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));

                break;

            // advance salary voucher
            case config('global_variables.ADVANCE_SALARY_VOUCHER_CODE'):

                $adv_sal = AdvanceSalaryModel::where('as_id', $id)->first();

                $items = AdvanceSalaryItemsModel::where('asi_as_id', '=', $id)->orderby('asi_emp_advance_salary_account_name', 'ASC')->get();

                $usr_snd = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $adv_sal->as_from_pay_account)->value('account_name');
                $usr_rcvd = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $adv_sal->as_from_pay_account)->value('account_name');
                $nbrOfWrds = $this->myCnvrtNbr($adv_sal->as_amount);
                $invoice_nbr = $adv_sal->as_id;
                $invoice_date = $adv_sal->as_day_end_date;
                $invoice_remarks = $adv_sal->as_remarks;
                $type = 'grid';
                $pge_title = 'Advance Salary Voucher';

                return view('voucher_view.advance_salary_voucher.advance_salary_journal_voucher_list_modal', compact('items', 'adv_sal', 'usr_snd', 'usr_rcvd', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));

                break;

            // generate salary slip voucher
            case config('global_variables.GENERATE_SALARY_SLIP_VOUCHER_CODE'):


                $slry_slp = GenerateSalarySlipModel::where('gss_id', $id)->first();

                $emply = User::where('user_id', $slry_slp->gss_created_by)->first();
                $items = DB::table('financials_generate_salary_slip_voucher_items')
                    ->leftJoin('financials_users', 'financials_users.user_id', 'financials_generate_salary_slip_voucher_items.gssi_employee_id')
                    ->where('gssi_gss_id', $id)->select('financials_generate_salary_slip_voucher_items.*', 'financials_users.user_name')->orderBy('financials_users.user_name')->get();

                $nbrOfWrds = $this->myCnvrtNbr($slry_slp->gss_total_amount);
                $invoice_nbr = $slry_slp->gss_id;
                $invoice_date = $slry_slp->gss_day_end_date;
                $invoice_remarks = $slry_slp->gss_remarks;
                $type = 'grid';
                $pge_title = 'Generate Salary Slip Voucher';

                return view('voucher_view.generate_salary_slip_voucher.generate_salary_slip_voucher_list_modal', compact('items', 'slry_slp', 'emply', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title', 'invoice_remarks'));

                break;

            // product loss voucher
            case config('global_variables.PRODUCT_LOSS_VOUCHER_CODE'):

                $pim = ProductLossRecoverModel::where('plr_id', $id)->first();
                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $pim->plr_account_uid)->first();
                $user = User::where('user_id', $pim->plr_user_id)->first();
                $piims = ProductLossRecoverItemsModel::where('plri_plr_id', $id)->orderby('plri_pro_name', 'ASC')->get();
                $nbrOfWrds = $this->myCnvrtNbr($pim->plr_pro_total_amount);
                $invoice_nbr = $pim->plr_id;
                $invoice_date = $pim->plr_datetime;
                $invoice_remarks = $pim->plr_remarks;
                $type = 'grid';
                $pge_title = 'Product Loss Voucher';


                return view('invoice_view.product_loss_invoice.product_loss_invoice_list_modal', compact('piims', 'pim', 'accnts', 'user', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));


                break;

            // trade product loss voucher
            case config('global_variables.TRADE_PRODUCT_LOSS_VOUCHER_CODE'):

                $pim = ProductLossRecoverModel::where('plr_id', $id)->first();
                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $pim->plr_account_uid)->first();
                $user = User::where('user_id', $pim->plr_user_id)->first();
                $piims = ProductLossRecoverItemsModel::where('plri_plr_id', $id)->orderby('plri_pro_name', 'ASC')->get();
                $nbrOfWrds = $this->myCnvrtNbr($pim->plr_pro_total_amount);
                $invoice_nbr = $pim->plr_id;
                $invoice_date = $pim->plr_datetime;
                $invoice_remarks = $pim->plr_remarks;
                $type = 'grid';
                $pge_title = 'Trade Product Loss Voucher';


                return view('trade_invoice_view.trade_product_loss_invoice.trade_product_loss_invoice_list_modal', compact('piims', 'pim', 'accnts', 'user', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));


                break;

            // product recover voucher
            case config('global_variables.PRODUCT_RECOVER_VOUCHER_CODE'):

                $pim = ProductLossRecoverModel::where('plr_id', $id)->first();
                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $pim->plr_account_uid)->first();
                $user = User::where('user_id', $pim->plr_user_id)->first();
                $piims = ProductLossRecoverItemsModel::where('plri_plr_id', $id)->orderby('plri_pro_name', 'ASC')->get();
                $nbrOfWrds = $this->myCnvrtNbr($pim->plr_pro_total_amount);
                $invoice_nbr = $pim->plr_id;
                $invoice_date = $pim->plr_datetime;
                $invoice_remarks = $pim->plr_remarks;
                $type = 'grid';
                $pge_title = 'Product Recover Voucher';

                return view('invoice_view.product_loss_invoice.product_loss_invoice_list_modal', compact('piims', 'pim', 'accnts', 'user', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));

                break;

            // trade product recover voucher
            case config('global_variables.TRADE_PRODUCT_RECOVER_VOUCHER_CODE'):

                $pim = ProductLossRecoverModel::where('plr_id', $id)->first();
                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $pim->plr_account_uid)->first();
                $user = User::where('user_id', $pim->plr_user_id)->first();
                $piims = ProductLossRecoverItemsModel::where('plri_plr_id', $id)->orderby('plri_pro_name', 'ASC')->get();
                $nbrOfWrds = $this->myCnvrtNbr($pim->plr_pro_total_amount);
                $invoice_nbr = $pim->plr_id;
                $invoice_date = $pim->plr_datetime;
                $invoice_remarks = $pim->plr_remarks;
                $type = 'grid';
                $pge_title = 'Trade Product Recover Voucher';

                return view('trade_invoice_view.trade_product_loss_invoice.trade_product_loss_invoice_list_modal', compact('piims', 'pim', 'accnts', 'user', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));

                break;

            // product Stock Produced voucher
            case config('global_variables.PRODUCT_PRODUCED_VOUCHER_CODE'):

                $pim = ProductionStockAdjustmentModel::where('psa_id', $id)->first();
                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $pim->psa_account_uid)->first();
                $user = User::where('user_id', $pim->psa_user_id)->first();
                $piims = ProducedStockModel::where('ps_psa_id', $id)->orderby('ps_pro_title', 'ASC')->get();
                $nbrOfWrds = $this->myCnvrtNbr($pim->psa_produced_total_amount);
                $invoice_nbr = $pim->psa_id;
                $invoice_date = $pim->psa_datetime;
                $invoice_remarks = $pim->psa_remarks;
                $type = 'grid';
                $pge_title = 'Product Produced Voucher';

                return view('invoice_view.product_produced_invoice.product_produced_invoice_list_modal', compact('piims', 'pim', 'accnts', 'user', 'nbrOfWrds', 'invoice_nbr', 'invoice_date',
                    'invoice_remarks', 'type', 'pge_title'));

                break;

            // product Stock Consumed voucher
            case config('global_variables.PRODUCT_CONSUMED_VOUCHER_CODE'):

                $pim = ProductionStockAdjustmentModel::where('psa_id', $id)->first();
                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $pim->psa_account_uid)->first();
                $user = User::where('user_id', $pim->psa_user_id)->first();
                $piims = ConsumedStockModel::where('cs_psa_id', $id)->orderby('cs_pro_title', 'ASC')->get();
                $nbrOfWrds = $this->myCnvrtNbr($pim->psa_consumed_total_amount);
                $invoice_nbr = $pim->psa_id;
                $invoice_date = $pim->psa_datetime;
                $invoice_remarks = $pim->psa_remarks;
                $type = 'grid';
                $pge_title = 'Product Consumed Voucher';

                return view('invoice_view.product_consumed_invoice.product_consumed_invoice_list_modal', compact('piims', 'pim', 'accnts', 'user', 'nbrOfWrds', 'invoice_nbr', 'invoice_date',
                    'invoice_remarks', 'type', 'pge_title'));

                break;

            // post dated cheque issue voucher
            case config('global_variables.POST_DATED_CHEQUE_ISSUE'):

                $pdc = PostDatedChequeModel::where('pdc_id', $id)->first();
                $to = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $pdc->pdc_party_code)->first();
                $from = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $pdc->pdc_account_code)->first();
                $nbrOfWrds = $this->myCnvrtNbr($pdc->pdc_amount);
                $invoice_nbr = $pdc->pdc_id;
                $invoice_date = $pdc->pdc_datetime;
                $invoice_remarks = $pdc->pdc_remarks;
                $type = 'grid';
                $pge_title = 'Post Dated Cheque Issue Voucher';

                return view('voucher_view.post_dated_cheque_issue_voucher.post_dated_cheque_issue_journal_voucher_list_modal', compact('pdc', 'to', 'from', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));

                break;

            // post dated cheque received voucher
            case config('global_variables.POST_DATED_CHEQUE_RECEIVED'):

                $pdc = PostDatedChequeModel::where('pdc_id', $id)->first();
                $from = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $pdc->pdc_party_code)->first();
                $to = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $pdc->pdc_account_code)->first();
                $nbrOfWrds = $this->myCnvrtNbr($pdc->pdc_amount);
                $invoice_nbr = $pdc->pdc_id;
                $invoice_date = $pdc->pdc_datetime;
                $invoice_remarks = $pdc->pdc_remarks;
                $type = 'grid';
                $pge_title = 'Post Dated Cheque Received Voucher';

                return view('voucher_view.post_dated_cheque_received_voucher.post_dated_cheque_received_journal_voucher_list_modal', compact('pdc', 'to', 'from', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));

                break;


            // bill of Labour voucher
            case config('global_variables.BILL_OF_LABOUR_VOUCHER_CODE'):

                $csh_pymnt = BillOfLabourModel::where('bl_id', $id)->first();
                $items = BillOfLabourItemsModel::leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_bill_of_labour_items.bli_pr_id')->where('bli_voucher_id', $id)->orderby
                ('bli_account_name', 'ASC')->get();
                $bl_acnt_nme = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $csh_pymnt->bl_account_id)->first();
                $nbrOfWrds = $this->myCnvrtNbr($csh_pymnt->bl_total_amount);
                $invoice_nbr = $csh_pymnt->bl_id;
                $invoice_date = $csh_pymnt->bl_day_end_date;
                $invoice_remarks = $csh_pymnt->bl_remarks;
                $type = 'grid';
                $pge_title = 'Bill Of Labour Voucher';

                return view('voucher_view.bill_of_labour_voucher.bill_of_labour_voucher_list_modal', compact('items', 'csh_pymnt', 'nbrOfWrds', 'bl_acnt_nme', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));

                break;

            // product manufacture voucher
            case config('global_variables.PRODUCT_MANUFACTURE_VOUCHER_CODE')://change

                $pim = ProductManufactureModel::where('pm_id', $id)->first();
                $accnts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $pim->pm_account_code)->first();
                $piim_expense = ProductManufactureExpenseModel::where('pme_product_manufacture_id', $id)
                    ->select(DB::raw('pme_account_code as code, pme_account_name as name, "expense_qty" as qty, "expense_rate" as rate, pme_amount as amount, "expense" as type'))
                    ->orderby('pme_account_name', 'ASC');

                $piims = ProductManufactureItemsModel::where('pmi_product_manufacture_id', $id)
                    ->select(DB::raw('pmi_product_code as code, pmi_product_name as name, pmi_qty as qty, pmi_rate as rate, pmi_amount as amount, "items" as type'))
                    ->orderby('pmi_product_name', 'ASC')
                    ->union($piim_expense)
                    ->get();
                $nbrOfWrds = $this->myCnvrtNbr($pim->pm_grand_total);
                $invoice_nbr = $pim->pm_id;
                $invoice_date = $pim->pm_datetime;
                $type = 'grid';
                $pge_title = 'Manufacture Product Invoice';

                return view('invoice_view.product_manufacture.product_manufacture_list_modal', compact('piims', 'pim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title'));


                break;

            default:
                $get_value[] = 'No Details';
                $get_value[] = 'No Details';
        }

        return response()->json($get_value);
    }


    // update code by Mustafa start
    public function cashbook(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $date = $day_end->de_datetime;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->from;
        $cash_in_hand = config('global_variables.cash_in_hand');

        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        if (empty($search_to)) {
            $start = $date;
        }
        if (empty($search_from)) {
            $end = $date;
        }

        $opening_balance = BalancesModel::where('bal_clg_id', $user->user_clg_id)->where('bal_account_id', $cash_in_hand)->where('bal_day_end_date', '<', $start)->orderby('bal_id', 'DESC')->pluck('bal_total')
            ->first();


        $queryA = BalancesModel::leftJoin('financials_transactions', 'trans_id', '=', 'bal_transaction_id')
            ->leftJoin('financials_accounts as a2', 'a2.account_uid', '=', 'trans_cr')
            ->where('trans_clg_id', $user->user_clg_id)
            ->where('account_clg_id', $user->user_clg_id)
            ->where('bal_clg_id', $user->user_clg_id)
            ->where('bal_account_id', '=', $cash_in_hand)
            ->where('bal_day_end_date', '>=', $start)
            ->where('bal_day_end_date', '<=', $end)
            ->where('bal_cr', '=', 0)
            ->select('bal_id', 'bal_day_end_date as date_time', 'bal_voucher_number as voucher_code', 'a2.account_name as name',
                'bal_detail_remarks as remarks', 'bal_dr as debit', 'bal_cr as credit', 'bal_total as balance', 'trans_notes as notes');

        $datas = BalancesModel::leftJoin('financials_transactions', 'trans_id', '=', 'bal_transaction_id')
            ->leftJoin('financials_accounts as a2', 'a2.account_uid', '=', 'trans_dr')
            ->where('trans_clg_id', $user->user_clg_id)
            ->where('account_clg_id', $user->user_clg_id)
            ->where('bal_clg_id', $user->user_clg_id)
            ->where('bal_account_id', '=', $cash_in_hand)
            ->where('bal_day_end_date', '>=', $start)
            ->where('bal_day_end_date', '<=', $end)
            ->where('bal_dr', '=', 0)
            ->union($queryA)
            ->orderBy('bal_id', 'ASC')
            ->select('bal_id', 'bal_day_end_date as date_time', 'bal_voucher_number as voucher_code', 'a2.account_name as name',
                'bal_detail_remarks as remarks', 'bal_dr as debit', 'bal_cr as credit', 'bal_total as balance', 'trans_notes as notes')
            ->get();

//        $datas = DB::select(
//            DB::raw("select date_time, voucher_code, name, remarks, debit, credit, balance, notes
//                from (
//
//                  select
//                    bal_day_end_date       as date_time,
//                    bal_voucher_number as voucher_code,
//                    a2.account_name    as name,
//                    bal_detail_remarks as remarks,
//                    bal_dr             as debit,
//                    bal_cr             as credit,
//                    bal_total          as balance,
//                    trans_notes        as notes
//                  from financials_balances
//                    join financials_transactions on bal_transaction_id = trans_id
//                    join financials_accounts a2 on a2.account_uid = trans_cr
//                  where bal_account_id = $cash_in_hand and bal_day_end_date = $start  and bal_cr = 0
//
//                  union
//
//                  select
//                    bal_day_end_date       as date_time,
//                    bal_voucher_number as voucher_code,
//                    a2.account_uid    as code,
//                    a2.account_name    as name,
//                    bal_detail_remarks as remarks,
//                    bal_dr             as debit,
//                    bal_cr             as credit,
//                    bal_total          as balance,
//                    trans_notes        as notes
//                  from financials_balances
//                    join financials_transactions on bal_transaction_id = trans_id
//                    join financials_accounts a2 on a2.account_uid = trans_dr
//                  where bal_account_id = $cash_in_hand and bal_day_end_date = $start and bal_dr = 0
//                ) aa
//                order by date_time"));


        $prnt_page_dir = 'print.cashbook.cashbook';
        $pge_title = 'Cash Book';
        $srch_fltr = [];
        $balance = 0;


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

            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title', 'date', 'opening_balance', 'srch_fltr'));
//            $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title, $balance, $date, $opening_balance), $pge_title . '_x.xlsx');
            }

        } else {
            return view('cashbook', compact('datas', 'date', 'start', 'end', 'opening_balance', 'search_from', 'search_to'));
        }
    }
    // update code by Mustafa end

    // update code by shahzaib start
    public function personal_account_ledger(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $personal_account = AccountRegisterationModel::where('account_clg_id', $user->user_clg_id)->where('account_employee_id', $user->user_id)->first();
        $ar = json_decode($request->array);

        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->from;

        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';

        $account_name = $personal_account->account_name;
        $prnt_page_dir = 'print.parties_account_ledger.parties_account_ledger';
        $pge_title = 'Personal Account Ledger ( ' . $account_name . ' )';
        $srch_fltr = [];
        array_push($srch_fltr, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));


        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $month = date('m', strtotime($day_end->de_datetime));
        $year = date('Y', strtotime($day_end->de_datetime));


        $query = DB::table('financials_balances')
            ->where('bal_clg_id', $user->user_clg_id);

        if (!empty($search_to) && !empty($search_from)) {

            $query->whereDate('bal_day_end_date', '>=', $start)
                ->whereDate('bal_day_end_date', '<=', $end);
        } elseif (!empty($search_to) && empty($search_from)) {
            $query->whereDate('bal_day_end_date', '>=', $start);
        } elseif (empty($search_to) && !empty($search_from)) {
            $query->whereDate('bal_day_end_date', '<=', $end);
        } else {
//            $query->whereMonth('bal_day_end_date', $month);
        }

        if (!empty($search_by_invoice_type) && !empty($search_by_invoice_type)) {
            $query->where('bal_voucher_number', 'like', $search_by_invoice_type . '%');
        }


        $datas = $query->where('bal_account_id', $personal_account->account_uid)->orderBy('bal_id', 'ASC')
            ->get();

//        $datas = $query->get();
//
//        if (!empty($search_account_id)) {
//            $datas = $query->where('bal_account_id', $search_account_id)->orderBy('bal_id', 'ASC')
//                ->get();
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

            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title', 'srch_fltr'));
//            $pdf->setOptions($options);

            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {


            return view('client_supplier/personal_account_ledger', compact('datas', 'account_name', 'search_to', 'search_from'));
        }
    }
    // update code by shahzaib end

}
