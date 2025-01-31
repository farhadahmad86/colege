<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountGroupModel;
use App\Models\AccountHeadsModel;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\Department;
use App\Models\PostingReferenceModel;
use App\Models\ProductModel;
use App\Models\ReportConfigModel;
use App\Models\SaleInvoiceItemsModel;
use App\User;
use PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    // update code by Mustafa start
    public function employee_ledger_balance_list(Request $request, $array = null, $str = null)
    {
        $departments = Department::all();
        $employees = User::where('user_disabled', '=', 0)->get();

        $ar = json_decode($request->array);
        $search_department = (!isset($request->department) && empty($request->department)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->department;
        $search_employee = (!isset($request->employee) && empty($request->employee)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->employee;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.month_wise_salary_details_list.month_wise_salary_details_list';
        $pge_title = 'Salary Detail For The Month Of ' . $search_department;
        $srch_fltr = [];
        array_push($srch_fltr, $search_department, $search_employee);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_accounts as account')
            ->leftJoin('financials_users', 'financials_users.user_id', 'account.account_employee_id')
            ->leftJoin('financials_departments', 'financials_departments.dep_id', 'account.account_department_id')
            ->select('account.account_name', 'financials_departments.dep_title', 'account.account_balance', 'financials_users.user_name')
//            ->groupBy('item.gssi_department_id')
            ->where('account_employee_id', '!=', 0);


        if (!empty($search_by_user)) {
//            $query->where('gssi_created_by', $search_by_user);
        }

        if (!empty($search_department)) {
            $query->where('account_department_id', $search_department);
        }
        if (!empty($search_employee)) {
            $query->where('account_employee_id', $search_employee);
        }


        $datas = $query->orderBy('financials_users.user_name', config('global_variables.drop_sorting'))
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
//            dd($datas);
            return view('extra_report/employee_ledger_balance_list', compact('datas', 'search_by_user', 'departments', 'search_department', 'employees', 'search_employee'));
        }

    }

    // update code by Mustafa end

    // update code by Mustafa start
    public function project_wise_expense_report(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $groups = AccountGroupModel::orderBy('ag_title', 'ASC')->get();
        $expense = 4;
        $first_heads = AccountHeadsModel::where('coa_level', 1)->orderBy('coa_id', 'ASC')->get();
        $second_heads = AccountHeadsModel::where('coa_parent', $expense)->orderBy('coa_id', 'ASC')->get();
        $third_heads = PostingReferenceModel::all();

        $ar = json_decode($request->array);
        $search_third_head = (!isset($request->third_head) && empty($request->third_head)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->third_head;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $prnt_page_dir = 'print.project_wise_expense_report.project_wise_expense_report';
        $pge_title = 'Project Wise Expense';
        $srch_fltr = [];
        array_push($srch_fltr, $search_third_head, $search_to, $search_from);

//        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));


        $expense_entry_accounts = DB::table('financials_accounts')
            ->where('account_uid', 'like', config('global_variables.expense') . '%')->pluck('account_uid');

        $query = DB::table('financials_balances')
            ->leftJoin('financials_posting_reference as posting_reference', 'posting_reference.pr_id', 'financials_balances.bal_pr_id')
            ->leftJoin('financials_accounts as accounts', 'accounts.account_uid', 'financials_balances.bal_account_id')
            ->leftJoin('financials_coa_heads as head', 'head.coa_code', 'accounts.account_parent_code')
            ->whereIn('bal_account_id', $expense_entry_accounts);

        if ((isset($search_to) && !empty($search_to)) && (isset($search_from) && !empty($search_from))) {
            $pagination_number = 1000000;

            $query->whereBetween('bal_day_end_date', [$start, $end]);

        } elseif (isset($search_to) && !empty($search_to)) {
            $pagination_number = 1000000;
            $query->where('bal_day_end_date', $start);

        } elseif (isset($search_from) && !empty($search_from)) {
            $pagination_number = 1000000;
            $query->where('bal_day_end_date', $end);
        }
        $query->sum('bal_dr');
        $query->sum('bal_cr');

        if (!empty($search_third_head)) {
            $query->where('bal_pr_id', '=', $search_third_head);
        }

        $datas = $query->selectRaw('sum(bal_cr) as cr, sum(bal_dr) as dr, financials_balances.*, posting_reference.pr_id, posting_reference.pr_name,accounts.account_name, head.coa_head_name as parent_name')

//            ->select('financials_balances.*', 'posting_reference.pr_id', 'posting_reference.pr_name')
//            ->select('financials_accounts.*', 'financials_users.user_id', 'financials_users.user_name', 'financials_users.user_designation', 'financials_account_group.ag_title', 'parent_account.coa_head_name as parnt_acnt_name', 'group_account.coa_head_name as grp_acnt_name')
//            ->where('account_uid', 'like', config('global_variables.expense') . '%')
//            ->orderBy('bal_account_id', 'ASC')
            ->groupBy('bal_account_id', 'bal_pr_id')->get();
//            ->paginate($pagination_number);


        if ($user->user_level == 100) {
            $account_list = AccountRegisterationModel::where('account_type', 0)
                ->where('account_delete_status', '!=', 1)
                ->orderBy('account_parent_code', 'ASC')
                ->orderBy('account_name', 'ASC')
                ->pluck('account_name')
                ->all();
        } else {
            $account_list = AccountRegisterationModel::where('account_type', 0)
                ->where('account_delete_status', '!=', 1)
                ->whereIn('account_group_id', explode(',', $user->user_account_reporting_group_ids))
                ->orderBy('account_parent_code', 'ASC')
                ->orderBy('account_name', 'ASC')
                ->pluck('account_name')
                ->all();
        }


        $balance = [];
        foreach ($datas as $account) {
            $default = 0;
            if (isset($search_to) && !empty($search_to)) {
                $defaults = BalancesModel::where('bal_account_id', $account->bal_account_id)->where('bal_day_end_date', '<', $start)->where('bal_pr_id', '=', $search_third_head);
                $default = $defaults->selectRaw('(sum(bal_dr) - sum(bal_cr)) as balance')->pluck('balance')->first();
                $query->where('bal_day_end_date', $start);
            }

            if (empty($default)) {
                $balance[] = 0;
            } else {
                $balance[] = $default;
            }
        }


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
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title', 'balance'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title, $balance), $pge_title . '_x.xlsx');
            }

        } else {
            return view('reports.project_wise_expense_report', compact('datas', 'balance', 'account_list', 'search_third_head', 'third_heads', 'search_to', 'search_from'));
        }
    }
    // update code by Mustafa end

    public
    function sale_report(Request $request, $array = null, $str = null)
    {
        $urdu_eng = ReportConfigModel::where('rc_id', '=', 1)->select('rc_invoice', 'rc_invoice_party')->first();

        $heads = config('global_variables.payable_receivable_cash');
        $heads = explode(',', $heads);

        $accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)->orderBy('account_name', 'ASC')->get();
        $products = ProductModel::orderBy('pro_title', 'ASC')->get();
        $sale_persons = User::where('user_delete_status', '!=', 1)->where('user_role_id', '=', 4)->orderBy('user_name', 'ASC')->get();
        $posting_references = PostingReferenceModel::all();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_account = (!isset($request->account) && empty($request->account)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->account;
        $search_product = (!isset($request->product) && empty($request->product)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->product;
        $search_sale_persons = (!isset($request->sale_person) && empty($request->sale_person)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->sale_person;
        $search_posting_reference = (!isset($request->posting) && empty($request->posting)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->posting;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[7]->{'value'} : '') : $request->from;

        $check_desktop = $request->check_desktop;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.sale_invoice_list.sale_invoice_list';
        $pge_title = 'Sale Report';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_account, $search_product, $search_sale_persons,$search_posting_reference, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        if ($urdu_eng->rc_invoice_party == 0) {
            $query = DB::table('financials_sale_invoice')
                ->leftJoin('financials_si_dc_extension', 'financials_si_dc_extension.sde_sale_id', 'financials_sale_invoice.si_id')
                ->leftJoin('financials_users', 'financials_users.user_id', 'financials_sale_invoice.si_createdby')
                ->leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_sale_invoice.si_pr_id')
            ->where('si_party_code','!=',410101);
        } else {
            $query = DB::table('financials_sale_invoice')
                ->leftJoin('financials_si_dc_extension', 'financials_si_dc_extension.sde_sale_id', 'financials_sale_invoice.si_id')
                ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_sale_invoice.si_party_code')
                ->leftJoin('financials_users', 'financials_users.user_id', 'financials_sale_invoice.si_createdby')
                ->leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_sale_invoice.si_pr_id');
        }


        if (!empty($search)) {
            if (isset($check_desktop) && !empty($check_desktop)) {
                $query->where(function ($query) use ($search) {
                    $query->where('si_local_invoice_id', 'like', '%' . $search . '%');
                });
            } else {
                $query->where(function ($query) use ($search) {
                    $query->where('si_party_code', 'like', '%' . $search . '%')
                        ->orWhere('si_party_name', 'like', '%' . $search . '%')
                        ->orWhere('si_remarks', 'like', '%' . $search . '%')
                        ->orWhere('si_id', 'like', '%' . $search . '%')
                        ->orWhere('user_designation', 'like', '%' . $search . '%')
                        ->orWhere('user_name', 'like', '%' . $search . '%')
                        ->orWhere('user_username', 'like', '%' . $search . '%');
                });
            }
        }

        if (!empty($search_account)) {
            $query->where('si_party_code', $search_account);
        }
        if (!empty($search_posting_reference)) {
            $query->where('si_pr_id', $search_posting_reference);
        }

        if (!empty($search_product)) {
            $get_p_id = SaleInvoiceItemsModel::where('sii_product_code', $search_product)->pluck('sii_invoice_id')->all();
            $query->whereIn('si_id', $get_p_id);
        }

        if (!empty($search_sale_persons)) {
            $query->where('si_sale_person', $search_sale_persons);
        }

        if (!empty($search_by_user)) {
            $query->where('si_createdby', $search_by_user);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('si_day_end_date', [$start, $end]);
            $query->whereDate('si_day_end_date', '>=', $start)
                ->whereDate('si_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('si_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('si_day_end_date', $end);
        }

        $datas = $query->orderBy('si_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

        $party = AccountRegisterationModel::whereIn('account_parent_code', $heads)->orderBy('account_name', 'ASC')->pluck('account_name')->all();


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
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('reports/sale_report', compact('datas', 'search', 'party', 'accounts', 'sale_persons', 'search_account', 'search_product', 'products', 'search_to', 'search_from',
                'check_desktop', 'search_by_user', 'search_sale_persons', 'urdu_eng', 'posting_references','search_posting_reference'));
        }
    }
}
