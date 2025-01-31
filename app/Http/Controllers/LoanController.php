<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\Department;
use App\Models\GenerateSalarySlipItemsModel;
use App\Models\LoanModel;
use App\Models\YearEndModel;
use Illuminate\Support\Facades\Route;
use Session;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LoanController extends Controller
{
    public function add_loan()
    {
        $user = Auth::user();
        $departments = Department::where('dep_delete_status', '!=', 1)->where('dep_disabled', '!=', 1)->where('dep_clg_id', $user->user_clg_id)->orderBy('dep_title', 'ASC')->get();
        return view('add_loan', compact('departments'));
    }

    public function submit_loan(Request $request)
    {
        $this->loan_validation($request);

        $rollBack = false;

        $user = Auth::user();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $notes = 'LOAN';


        DB::beginTransaction();

        $loan = new LoanModel();


        $loan = $this->assign_loan_values('loan', $loan, $request, $user, $day_end);


        if ($loan->save()) {
            $loan_id = $loan->as_id;

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $loan->loan_id);
            DB::commit();
            return redirect()->back()->with(['loan_id' => $loan_id, 'success' => 'Successfully Saved']);
        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }

//        if ($rollBack) {
//
//            DB::rollBack();
//            return redirect()->back()->with('fail', 'Failed');
//        } else {
//
//            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $loan->loan_id);
//            DB::commit();
//            return redirect()->back()->with(['as_id' => $loan_id, 'success' => 'Successfully Saved']);
//        }
    }

    public function loan_validation($request)
    {
        return $this->validate($request, [
            'department' => ['required', 'numeric'],
            'account_name' => ['required', 'numeric'],
            'loan_amount' => ['required', 'string'],
            'total_instalment' => ['required', 'numeric'],
            'instalment_amount' => ['required', 'string'],
            'last_payment_month' => ['required', 'string'],
        ]);
    }

    public function assign_loan_values($prfx, $voucher, $request, $user, $day_end)
    {
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $department_id = $prfx . '_department_id';
        $account_id = $prfx . '_account_id';
        $total_amount = $prfx . '_total_amount';
        $remaining_instalment = $prfx . '_remaining_installment';
        $total_remaining_amount = $prfx . '_remaining_amount';
        $total_instalment = $prfx . '_total_instalment';
        $instalment_amount = $prfx . '_instalment_amount';
        $first_payment_month = $prfx . '_first_payment_month';
        $last_payment_month = $prfx . '_last_payment_month';
        $created_datetime = $prfx . '_datetime';
        $day_end_id = $prfx . '_day_end_id';
        $day_end_date = $prfx . '_day_end_date';
        $createdby = $prfx . '_createdby';
        $brwsr_info = $prfx . '_brwsr_info';
        $ip_adrs = $prfx . '_ip_adrs';
        $clg_id = $prfx . '_clg_id';
        $branch_id = $prfx . '_branch_id';


        $voucher->$department_id = $request->department;
        $voucher->$account_id = $request->account_name;
        $voucher->$total_amount = $request->loan_amount;
        $voucher->$total_remaining_amount = $request->loan_amount;
        $voucher->$total_instalment = $request->total_instalment;
        $voucher->$remaining_instalment = $request->total_instalment;
        $voucher->$instalment_amount = $request->instalment_amount;
        $voucher->$first_payment_month = date("Y-m-d", strtotime($request->first_payment_month));//$request->last_payment_month;
        $voucher->$last_payment_month = date("Y-m-d", strtotime($request->last_payment_month));//$request->last_payment_month;
        $voucher->$created_datetime = Carbon::now()->toDateTimeString();
        $voucher->$day_end_id = $day_end->de_id;
        $voucher->$day_end_date = $day_end->de_datetime;
        $voucher->$createdby = $user->user_id;
        $voucher->$clg_id = $user->user_clg_id;
        $voucher->$branch_id = Session::get('branch_id');
        $voucher->$brwsr_info = $brwsr_rslt;
        $voucher->$ip_adrs = $ip_rslt;

//        if ($voucher_type == 1) {
//
//            $voucher->$bank_amount = $total_voucher_amount;
//        }

        return $voucher;
    }

    public function get_loan_account(Request $request)
    {
        $user = Auth::user();
        $department_id = $request->department_id;
        $heads = explode(',', config('global_variables.loan_head'));

        $loan_accounts = DB::table('financials_accounts')
            ->join('financials_users', 'financials_users.user_id', '=', 'financials_accounts.account_employee_id')
            ->where('account_department_id', '=', $department_id)->whereIn('account_parent_code', $heads)->where('account_delete_status', '!=', 1)->where('account_disabled', '!=', 1)->where('account_clg_id',
                $user->user_clg_id)
            ->select('account_name', 'account_uid')->orderBy('financials_users.user_name')->get();


        return response()->json(compact('loan_accounts'), 200);

    }

    // update code by mustafa start
    public function loan_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $route = Route::currentRouteName();
        $title = 'Loan';
        $departments = Department::where('dep_clg_id', $user->user_clg_id)->orderby('dep_title', 'ASC')->get();
        $heads = explode(',', config('global_variables.loan_head'));

        $accounts = DB::table('financials_accounts')
            ->join('financials_users', 'financials_users.user_id', '=', 'financials_accounts.account_employee_id')
            ->whereIn('account_parent_code', $heads)->where('account_delete_status', '!=', 1)->where('account_disabled', '!=', 1)->where('account_clg_id', $user->user_clg_id)->select('account_uid', 'account_name')->orderBy('financials_users.user_name')->get();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_department = (!isset($request->department) && empty($request->department)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->department;
        $search_account = (!isset($request->account) && empty($request->account)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->account;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;

        $search_by_user = $request->search_by_user;

        $prnt_page_dir = 'print.loan_list.loan_list';
        $pge_title = 'Loan List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_department, $search_account, $search_by_user);


        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $query = DB::table('financials_loan')
            ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_loan.loan_account_id')
            ->join('financials_departments', 'financials_departments.dep_id', '=', 'financials_loan.loan_department_id')
            ->leftJoin('financials_users', 'financials_users.user_id', '=', 'financials_loan.loan_createdby')
            //->where('loan_status', '!=', 'Pending')
            ->where('loan_clg_id', $user->user_clg_id);


        if (!empty($search)) {
            $pagination_number = 1000000;
            $query->orWhere('dep_title', 'like', '%' . $search . '%')
                ->orWhere('account_name', 'like', '%' . $search . '%')
                ->orWhere('loan_id', 'like', '%' . $search . '%')
                ->orWhere('loan_total_amount', 'like', '%' . $search . '%')
                ->orWhere('loan_total_instalment', 'like', '%' . $search . '%')
                ->orWhere('loan_instalment_amount', 'like', '%' . $search . '%')
                ->orWhere('loan_last_payment_month', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%');
        }

        if (!empty($search_department)) {
            $pagination_number = 1000000;
            $query->orWhere('loan_department_id', $search_department);
        }

        if (!empty($search_account)) {
            $pagination_number = 1000000;
            $query->where('loan_account_id', $search_account);
        }

        if (!empty($search_by_user)) {
            $pagination_number = 1000000;
            $query->where('loan_createdby', '=', $search_by_user);
        }

        if (!empty($search_year)) {
            $query->where('loan_year_id', '=', $search_year);
        } else {
            $search_year = YearEndModel::orderBy('ye_id', 'DESC')->pluck('ye_id')->first();
            $query->where('loan_year_id', '=', $search_year);
        }

        $datas = $query
//            ->where('town_delete_status', '!=', 1)
            ->orderBy('loan_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

        $loan_title = LoanModel::where('loan_clg_id', $user->user_clg_id)
        ->orderBy('loan_id', 'ASC')->pluck('loan_id')->all();


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
                'margin-top' => 24,
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
            return view('loan_list', compact('datas', 'search','search_year', 'loan_title', 'departments', 'accounts', 'search_department', 'search_account', 'search_by_user', 'title','route'));
        }

    }

    // update code by mustafa end
    // update code by mustafa start
    public function loan_pending_list(Request $request, $array = null, $str = null)
    {
        $route = Route::currentRouteName();

        $user = Auth::user();
        $title = 'Loan Pending';
        $departments = Department::where('dep_clg_id', $user->user_clg_id)->orderby('dep_title', 'ASC')->get();
        $heads = explode(',', config('global_variables.loan_head'));

        $accounts = DB::table('financials_accounts')
            ->join('financials_users', 'financials_users.user_id', '=', 'financials_accounts.account_employee_id')
            ->whereIn('account_parent_code', $heads)->where('account_delete_status', '!=', 1)->where('account_disabled', '!=', 1)->where('account_clg_id', $user->user_clg_id)->select('account_uid', 'account_name')->orderBy('financials_users.user_name')->get();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_department = (!isset($request->department) && empty($request->department)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->department;
        $search_account = (!isset($request->account) && empty($request->account)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->account;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;

        $search_by_user = $request->search_by_user;

        $prnt_page_dir = 'print.loan_list.loan_list';
        $pge_title = 'Loan List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_department, $search_account, $search_by_user);


        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $query = DB::table('financials_loan')
            ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_loan.loan_account_id')
            ->join('financials_departments', 'financials_departments.dep_id', '=', 'financials_loan.loan_department_id')
            ->leftJoin('financials_users', 'financials_users.user_id', '=', 'financials_loan.loan_createdby')
            ->where('loan_status', '=', 'Pending')->where('loan_clg_id', $user->user_clg_id);


        if (!empty($search)) {
            $pagination_number = 1000000;
            $query->orWhere('dep_title', 'like', '%' . $search . '%')
                ->orWhere('account_name', 'like', '%' . $search . '%')
                ->orWhere('loan_id', 'like', '%' . $search . '%')
                ->orWhere('loan_total_amount', 'like', '%' . $search . '%')
                ->orWhere('loan_total_instalment', 'like', '%' . $search . '%')
                ->orWhere('loan_instalment_amount', 'like', '%' . $search . '%')
                ->orWhere('loan_last_payment_month', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%');
        }

        if (!empty($search_department)) {
            $pagination_number = 1000000;
            $query->orWhere('loan_department_id', $search_department);
        }

        if (!empty($search_account)) {
            $pagination_number = 1000000;
            $query->where('loan_account_id', $search_account);
        }

        if (!empty($search_by_user)) {
            $pagination_number = 1000000;
            $query->where('loan_createdby', '=', $search_by_user);
        }
        if (!empty($search_year)) {
            $query->where('loan_year_id', '=', $search_year);
        } else {
            $search_year = YearEndModel::orderBy('ye_id', 'DESC')->pluck('ye_id')->first();
            $query->where('loan_year_id', '=', $search_year);
        }


        $datas = $query
//            ->where('town_delete_status', '!=', 1)
            ->orderBy('loan_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

        $loan_title = LoanModel::where('loan_clg_id', $user->user_clg_id)->
        orderBy('loan_id', 'ASC')->pluck('loan_id')->all();


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
                'margin-top' => 24,
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
            return view('loan_list', compact('datas', 'search','search_year','loan_title', 'departments', 'accounts', 'search_department', 'search_account', 'search_by_user','title','route'));
        }

    }

    // update code by mustafa end

    public function loan_approved(LoanModel $loan)
    {
        $loan->loan_status = 'Approved';
        $loan->loan_update_datetime = Carbon::now();
        $loan->save();
        return redirect()->back()->with('success', 'Loan Approved Successfully!');
    }

    public function loan_reject(LoanModel $loan)
    {
        $loan->loan_status = 'Reject';
        $loan->loan_update_datetime = Carbon::now();
        $loan->save();
        return redirect()->back()->with('success', 'Loan Reject Successfully!');
    }

    public function get_salary_generate_account(Request $request)
    {
        $generated = GenerateSalarySlipItemsModel::where('gssi_month_year', $request->month)->where('gssi_department_id', $request->department_id)->count();
        return response()->json(compact('generated'), 200);
    }

    public function edit_loan(LoanModel $loan){
        $user = Auth::user();
        $account_name = AccountRegisterationModel::where('account_uid',$loan->loan_account_id)->pluck('account_name')->first();
        $departments = Department::where('dep_delete_status', '!=', 1)->where('dep_disabled', '!=', 1)->where('dep_clg_id', $user->user_clg_id)->orderBy('dep_title', 'ASC')->get();
        return view('edit_loan',compact('loan','departments','account_name'));
    }

    public function update_loan(Request $request)
    {
        $this->validate($request, [

            'loan_amount' => ['required', 'string'],
            'remaining_amount' => ['required', 'string'],
            'total_instalment' => ['required', 'numeric'],
            'instalment_amount' => ['required', 'string'],
            'last_payment_month' => ['required', 'string'],
        ]);

        $rollBack = false;

        $user = Auth::user();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $notes = 'LOAN';


        DB::beginTransaction();

        $loan = LoanModel::where('loan_id','=',$request->id)->first();

        $prfx ='loan';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $total_remaining_amount = $prfx . '_remaining_amount';
        $total_instalment = $prfx . '_total_instalment';
        $remaining_instalment = $prfx . '_remaining_installment';
        $instalment_amount = $prfx . '_instalment_amount';
        $first_payment_month = $prfx . '_first_payment_month';
        $last_payment_month = $prfx . '_last_payment_month';
        $created_datetime = $prfx . '_update_datetime';
        $day_end_id = $prfx . '_day_end_id';
        $day_end_date = $prfx . '_day_end_date';
        $createdby = $prfx . '_createdby';
        $brwsr_info = $prfx . '_brwsr_info';
        $ip_adrs = $prfx . '_ip_adrs';
        $clg_id = $prfx . '_clg_id';
        $branch_id = $prfx . '_branch_id';

        $loan->$total_remaining_amount = $request->remaining_amount;
        $loan->$total_instalment = $request->total_instalment;
        $loan->$remaining_instalment = $request->remaining_instalment;
        $loan->$instalment_amount = $request->instalment_amount;
        $loan->$first_payment_month = date("Y-m-d", strtotime($request->first_payment_month));//$request->last_payment_month;
        $loan->$last_payment_month = date("Y-m-d", strtotime($request->last_payment_month));//$request->last_payment_month;
        $loan->$created_datetime = Carbon::now()->toDateTimeString();
        $loan->$day_end_id = $day_end->de_id;
        $loan->$day_end_date = $day_end->de_datetime;
        $loan->$createdby = $user->user_id;
        $loan->$clg_id = $user->user_clg_id;
        $loan->$branch_id = Session::get('branch_id');
        $loan->$brwsr_info = $brwsr_rslt;
        $loan->$ip_adrs = $ip_rslt;


        if ($loan->save()) {
            $loan_id = $loan->as_id;

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $loan->loan_id);
            DB::commit();
            return redirect()->route('loan_list')->with(['loan_id' => $loan_id, 'success' => 'Successfully Saved']);
        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }
    }
}
