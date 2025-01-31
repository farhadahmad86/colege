<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DayEndController;
use App\Jobs\GenerateTransportVoucherPDF;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\College\BankAccountModel;
use App\Models\College\Student;
use App\Models\College\StudentBalances;
use App\Models\College\TransportVoucherModel;
use App\Models\SystemConfigModel;
use App\Models\TransactionModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use PDF;

class TransportVoucherController extends Controller
{
    public function transport_voucher()
    {
        $user = Auth::user();
        $branch_id = Session::get('branch_id');
        $dr_accounts = AccountRegisterationModel::where('account_parent_code', 11020)
            ->select('account_name', 'account_uid')
            ->where('account_disabled', '!=', 1)
            ->where('account_delete_status', '!=', 1)
            ->where('account_clg_id', $user->user_clg_id)
            ->where('account_branch_id', $branch_id)
            ->get();

        $cr_accounts = AccountRegisterationModel::where('account_parent_code', 31114)
            ->select('account_name', 'account_uid')
            ->where('account_disabled', '!=', 1)
            ->where('account_delete_status', '!=', 1)
            ->where('account_clg_id', $user->user_clg_id)
            ->where('account_branch_id', $branch_id)
            ->get();

        $students = Student::where('transport', '=', 'Yes')->whereIn('status', [1, 4])->where('student_disable_enable', 1)->where('branch_id', $branch_id)->where('clg_id', $user->user_clg_id)
            ->leftJoin('transport', 'transport.tr_id', '=', 'students.route_id')
            ->leftJoin('classes', 'classes.class_id', '=', 'students.class_id')
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'students.section_id')
            ->get();

        return view('collegeViews/transport_voucher/transport_voucher', compact('students', 'dr_accounts', 'cr_accounts'));
    }

    public function submit_transport_voucher(Request $request)
    {
        $user = Auth::user();
        $this->transport_voucher_validation($request);

        $month = $request->month;

        $transport_array = json_decode($request->accountsval, true);
        $dr_account_name = $this->get_account_name($request->dr_account);
        $cr_account_name = $this->get_account_name($request->cr_account);
        $existing = '';
        DB::beginTransaction();
        foreach ($transport_array as $index => $requested_array) {

            $student_id = $requested_array['std_id'];
            $reg_no = $requested_array['registration_no'];
            $amount = $requested_array['amount'];
            $route_id = $requested_array['route_id'];
            $exist = TransportVoucherModel::where('tv_month', '=', $month)->where('tv_std_id', $student_id)->count();
            $rollBack = false;
            if ($exist == 0) {
                $detail_remarks = $cr_account_name . ' to ' . $dr_account_name . ', ' . $month . ', @' . number_format($amount, 2) . config('global_variables.Line_Break');

                $notes = 'TRANSPORT_VOUCHER';

                $voucher_code = config('global_variables.TRANSPORT_VOUCHER_CODE');

                $transaction_type = config('global_variables.TRANSPORT');


                $transport = new TransportVoucherModel();

                $transport = $this->assign_transport_voucher_values($request, $transport, $student_id, $reg_no, $amount, $detail_remarks, $route_id);


                // system config set increment default id according to user giving start coding
                $sstm_cnfg_clm = 'sc_transport_voucher_number';
                $sstm_cnfg_tv_id_chk = SystemConfigModel::where('sc_clg_id', '=', $user->user_clg_id)->where($sstm_cnfg_clm, '!=', '0')->first();
                $chk_transport = TransportVoucherModel::where('tv_clg_id', '=', $user->user_clg_id)->get();
                if ($chk_transport->isEmpty()):
                    if (isset($sstm_cnfg_tv_id_chk) && !empty($sstm_cnfg_tv_id_chk)):
                        $transport->tv_id = $sstm_cnfg_tv_id_chk->$sstm_cnfg_clm;
                    endif;
                endif;
                // system config set increment default id according to user giving end coding

                if ($transport->save()) {
                    $transport_id = $transport->tv_id;
                    $tv_voucher_no = $transport->tv_v_no;
                }

                $transaction = new TransactionModel();

                $transaction = $this->AssignTransactionsValues($transaction, $request->dr_account, $amount, $request->cr_account, $notes, $transaction_type, $transport_id);

                if ($transaction->save()) {

                    $transaction_id = $transaction->trans_id;

                    // Selected Student Receivable Accounts
                    $branch_id = $this->get_branch_id($request->dr_account);
                    $balances = new BalancesModel();

                    $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $request->dr_account, $amount, 'Dr', $request->remarks,
                        $notes, $cr_account_name . ' to ' . $dr_account_name . ', @' . number_format($amount, 2) . config('global_variables.Line_Break')
                        , $voucher_code . $transport_id, '', $voucher_code . $tv_voucher_no, $this->getYearEndId(), $branch_id);

                    if (!$balance->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed');
                    }

// student balance
                    $std_balances = new StudentBalances();

                    $std_balances = $this->AssignStudentBalancesValues($std_balances, $dr_account_name, $amount, 'Dr',
                        $notes, $cr_account_name . ' to ' . $dr_account_name . ', @' . number_format($amount, 2) . config('global_variables.Line_Break'),
                        $voucher_code . $transport_id, $student_id, $reg_no, $branch_id);
                    if (!$std_balances->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed');
                    }


                    // Selected Transport Income Accounts
                    $branch_id = $this->get_branch_id($request->cr_account);
                    $balances2 = new BalancesModel();

                    $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id, $request->cr_account, $amount, 'Cr', $request->remarks,
                        $notes, $cr_account_name . ' to ' . $dr_account_name . ', @' . number_format($amount, 2) . config('global_variables.Line_Break'),
                        $voucher_code . $transport_id,
                        '', $voucher_code . $tv_voucher_no, $this->getYearEndId(), $branch_id);

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
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $transport_id);
            } else {
                $existing = $existing . ' ' . $reg_no;
            }
        }

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');

        } else {
            DB::commit();
            return redirect()->back()->with(['exist' => $existing, 'month' => $month, 'success' => 'Successfully Saved']);
        }
    }

    public
    function transport_voucher_validation($request)
    {
        return $this->validate($request, [
            'dr_account' => ['required', 'numeric'],
            'cr_account' => ['required', 'numeric'],
            'month' => ['required', 'string'],
            'accountsval' => ['required', 'string'],
            'remarks' => ['nullable', 'string'],
            'issue_date' => ['required', 'string'],
            'due_date' => ['required', 'string'],
            'total_payable_amount' => ['required', 'numeric'],
        ]);
    }

    public
    function assign_transport_voucher_values($request, $transport, $student_id, $reg_no, $amount, $detail_remarks, $route_id)
    {
        $user = Auth::User();


        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

//        $maxId = TransportVoucherModel::where('tv_clg_id', $user->user_clg_id)->orderBy('tv_id', 'DESC')->pluck('tv_v_no')->first();
        $maxId = TransportVoucherModel::lockForUpdate()->selectRaw('MAX(CAST(tv_v_no AS UNSIGNED)) as max_tv_v_no')
            ->where('tv_clg_id', $user->user_clg_id)
            ->where('tv_v_no', 'like', '5%')
            ->value('max_tv_v_no');

        $new_value = $maxId ? (int)substr($maxId, 1) : null;

        if ($maxId == null) {
            $voucher_number = $new_value + 1;
            $voucher_number = 100 + $voucher_number;
            $transport->tv_v_no = '5' . $voucher_number;
        } else {
            $transport->tv_v_no = '5' . $new_value + 1;
        }
//        dd($new_value,$new_value2,$voucher_number,$transport->tv_v_no);
        $transport->tv_std_id = $student_id;
        $transport->tv_reg_no = $reg_no;
        $transport->tv_dr_account = $request->dr_account;
        $transport->tv_cr_account = $request->cr_account;
        $transport->tv_month = $request->month;
        $transport->tv_route_id = $route_id;
        $transport->tv_issue_date = date('Y-m-d', strtotime($request->issue_date));
        $transport->tv_due_date = date('Y-m-d', strtotime($request->due_date));
        $transport->tv_remarks = ucfirst($request->remarks);
        $transport->tv_detail_remarks = $detail_remarks;
        $transport->tv_total_amount = $amount;
        $transport->tv_created_datetime = Carbon::now()->toDateTimeString();
        $transport->tv_day_end_id = $day_end->de_id;
        $transport->tv_day_end_date = $day_end->de_datetime;
        $transport->tv_createdby = $user->user_id;
        $transport->tv_clg_id = $user->user_clg_id;
        $transport->tv_branch_id = Session::get('branch_id');
        $transport->tv_brwsr_info = $brwsr_rslt;
        $transport->tv_ip_adrs = $ip_rslt;
        $transport->tv_year_id = $this->getYearEndId();
        return $transport;
    }

    // code by Mustafa start
    public function transport_voucher_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $branch_id = Session::get('branch_id');

        $month_year = TransportVoucherModel::where('tv_clg_id', '=', $user->user_clg_id)->where('tv_branch_id', '=', $branch_id)->groupBy('tv_month')->pluck('tv_month');

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_month = (!isset($request->month) && empty($request->month)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->month;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->from;
        $search_status = (!isset($request->status) && empty($request->status)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->status;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->year;

        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.college.transport_voucher_list.transport_voucher_list';
        $pge_title = 'Transport Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from, $search_month, $search_status, $search_year);

        $pagination_number = (empty($ar)) ? 100 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $query = DB::table('transport_voucher')
            ->leftJoin('students', 'students.id', 'transport_voucher.tv_std_id')
            ->leftJoin('branches', 'branches.branch_id', 'transport_voucher.tv_branch_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'transport_voucher.tv_createdby')
            ->leftJoin('create_section', 'create_section.cs_id', 'students.section_id')
            ->where('tv_clg_id', $user->user_clg_id)
            ->where('tv_branch_id', Session::get('branch_id'));
        $ttl_amnt = $query->sum('tv_total_amount');

        if (!empty($request->search)) {
            $query->where('tv_total_amount', 'like', '%' . $search . '%')
                ->orWhere('tv_remarks', 'like', '%' . $search . '%')
                ->orWhere('tv_id', 'like', '%' . $search . '%')
                ->orWhere('tv_v_no', 'like', '%' . $search . '%')
                ->orWhere('tv_reg_no', 'like', '%' . $search . '%');
        }

        if (!empty($search_month)) {
            $query->where('tv_month', $search_month);
        }

        if ($search_status != '') {
            $query->where('tv_status', '=', $search_status);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereDate('tv_day_end_date', '>=', $start)
                ->whereDate('tv_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('tv_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('tv_day_end_date', $end);
        }
        if (!empty($search_year)) {
            $query->where('tv_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('tv_year_id', '=', $search_year);
        }
        $datas = $query->orderBy('tv_id', config('global_variables.query_sorting'))
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
            return view('collegeViews.transport_voucher.transport_voucher_list', compact('datas', 'search', 'search_year', 'search_to', 'search_from', 'ttl_amnt', 'search_by_user', 'search_status',
                'search_month', 'month_year'));
        }
    }

    public function transport_items_view_details(Request $request)
    {
        $user = Auth::user();
        $items = TransportVoucherModel::where('tv_v_no', $request->id)->where('tv_clg_id', $user->user_clg_id)
//            ->where('tv_status', 0)
            ->orderby('tv_id', 'ASC')->get();
        return response()->json($items);
    }

    public function transport_items_view_details_SH(Request $request, $id)
    {
        $user = Auth::user();
        $transport_voucher = TransportVoucherModel::leftJoin('students', 'students.id', '=', 'transport_voucher.tv_std_id')
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'students.section_id')
            ->leftJoin('branches', 'branches.branch_id', '=', 'transport_voucher.tv_branch_id')
            ->leftJoin('classes', 'classes.class_id', '=', 'students.class_id')
            ->leftJoin('transport', 'transport.tr_id', '=', 'students.route_id')
            ->where('tv_v_no', $request->id)->where('tv_reg_no', $request->reg_no)->where('tv_status', $request->status)->where('tv_clg_id', $user->user_clg_id)
//            ->where('tv_status', 0)
            ->first();
        $college_bank_info = BankAccountModel::where('bi_clg_id', $user->user_clg_id)->first();
        $type = 'grid';
        $pge_title = 'Transport Voucher';

        return view('voucher_view.transportVoucher.view_transport_voucher_all', compact('transport_voucher', 'college_bank_info', 'type', 'pge_title'));
    }

    public function transport_items_view_details_pdf_SH(Request $request, $id)
    {
        $user = Auth::user();
        $transport_voucher = TransportVoucherModel::leftJoin('students', 'students.id', '=', 'transport_voucher.tv_std_id')
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'students.section_id')
            ->leftJoin('branches', 'branches.branch_id', '=', 'transport_voucher.tv_branch_id')
            ->leftJoin('classes', 'classes.class_id', '=', 'students.class_id')
            ->leftJoin('transport', 'transport.tr_id', '=', 'students.route_id')
            ->where('tv_v_no', $request->id)->where('tv_reg_no', $request->reg_no)->where('tv_status', $request->status)->where('tv_clg_id', $user->user_clg_id)->where('tv_status', 0)->first();
        $college_bank_info = BankAccountModel::where('bi_clg_id', $user->user_clg_id)->first();
        $company_info = Session::get('company_info');
        $type = 'pdf';
        $pge_title = 'Transport Voucher';

        $options = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ];

        $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        $pdf->getDomPDF()->setHttpContext(stream_context_create($options));
//        $pdf->getDomPDF()->setHttpContext($options);
        $pdf->loadView('voucher_view.transportVoucher.print_transport_voucher_all', compact('college_bank_info', 'transport_voucher', 'company_info', 'type', 'pge_title'));

        return $pdf->stream('Transport-Voucher-Detail.pdf');
    }

    public function submit_student_wise_transport_voucher(Request $request)
    {
        Session::put('student_id', $request->t_student_id);
        $user = Auth::user();
        $this->transport_single_voucher_validation($request);

        $month = $request->month;

        $dr_account_name = $this->get_account_name($request->dr_account);
        $cr_account_name = $this->get_account_name($request->cr_account);
        $existing = '';
        $student = Student::where('id', $request->t_student_id)->first();
        DB::beginTransaction();

        $student_id = $request->t_student_id;
        $reg_no = $student->registration_no;
        $amount = $request->amount;
        $route_id = $student->route_id;
        $exist = TransportVoucherModel::where('tv_month', '=', $month)->where('tv_std_id', $student_id)->count();
        $rollBack = false;
        if ($exist == 0) {
            $detail_remarks = $cr_account_name . ' to ' . $dr_account_name . ', ' . $month . ', @' . number_format($amount, 2) . config('global_variables.Line_Break');

            $notes = 'TRANSPORT_VOUCHER';

            $voucher_code = config('global_variables.TRANSPORT_VOUCHER_CODE');

            $transaction_type = config('global_variables.TRANSPORT');


            $transport = new TransportVoucherModel();

            $transport = $this->assign_transport_voucher_values($request, $transport, $student_id, $reg_no, $amount, $detail_remarks, $route_id);

            // system config set increment default id according to user giving start coding
            $sstm_cnfg_clm = 'sc_transport_voucher_number';
            $sstm_cnfg_tv_id_chk = SystemConfigModel::where('sc_clg_id', '=', $user->user_clg_id)->where($sstm_cnfg_clm, '!=', '0')->first();
            $chk_transport = TransportVoucherModel::where('tv_clg_id', '=', $user->user_clg_id)->get();
            if ($chk_transport->isEmpty()):
                if (isset($sstm_cnfg_tv_id_chk) && !empty($sstm_cnfg_tv_id_chk)):
                    $transport->tv_id = $sstm_cnfg_tv_id_chk->$sstm_cnfg_clm;
                endif;
            endif;
            // system config set increment default id according to user giving end coding

            if ($transport->save()) {
                $transport_id = $transport->tv_id;
                $tv_voucher_no = $transport->tv_v_no;
            }

            $transaction = new TransactionModel();

            $transaction = $this->AssignTransactionsValues($transaction, $request->dr_account, $amount, $request->cr_account, $notes, $transaction_type, $transport_id);

            if ($transaction->save()) {

                $transaction_id = $transaction->trans_id;

                // Selected Student Receivable Accounts
                $branch_id = $this->get_branch_id($request->dr_account);
                $balances = new BalancesModel();

                $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $request->dr_account, $amount, 'Dr', $request->remarks,
                    $notes, $cr_account_name . ' to ' . $dr_account_name . ', @' . number_format($amount, 2) . config('global_variables.Line_Break')
                    , $voucher_code . $transport_id, '', $voucher_code . $tv_voucher_no, $this->getYearEndId(), $branch_id);

                if (!$balance->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed');
                }

                // student balance
                $std_balances = new StudentBalances();

                $std_balances = $this->AssignStudentBalancesValues($std_balances, $dr_account_name, $amount, 'Dr',
                    $notes, $cr_account_name . ' to ' . $dr_account_name . ', @' . number_format($amount, 2) . config('global_variables.Line_Break'),
                    $voucher_code . $transport_id, $student_id, $reg_no, $branch_id);
                if (!$std_balances->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed');
                }


                // Selected Transport Income Accounts
                $branch_id = $this->get_branch_id($request->cr_account);
                $balances2 = new BalancesModel();

                $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id, $request->cr_account, $amount, 'Cr', $request->remarks,
                    $notes, $cr_account_name . ' to ' . $dr_account_name . ', @' . number_format($amount, 2) . config('global_variables.Line_Break'),
                    $voucher_code . $transport_id,
                    '', $voucher_code . $tv_voucher_no, $this->getYearEndId(), $branch_id);

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
            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $transport_id);
        } else {
            return redirect()->route('create_installments')->with('success', 'Already created ' . $month . ' month voucher');
        }


        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');

        } else {
            DB::commit();
            return redirect()->route('create_installments')->with('success', 'Successfully Saved');
        }
    }

    function transport_single_voucher_validation($request)
    {
        return $this->validate($request, [
            'dr_account' => ['required', 'numeric'],
            'cr_account' => ['required', 'numeric'],
            'month' => ['required', 'string'],
            'issue_date' => ['required', 'string'],
            'due_date' => ['required', 'string'],
            'amount' => ['required', 'numeric'],
        ]);
    }

    // month wise voucher
    public function month_transport_voucher_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $branch_id = Session::get('branch_id');

        $ar = json_decode($request->array);
        $search = !isset($request->search) && empty($request->search) ? (!empty($ar) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = !isset($request->to) && empty($request->to) ? (!empty($ar) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = !isset($request->from) && empty($request->from) ? (!empty($ar) ? $ar[3]->{'value'} : '') : $request->from;
        $search_year = !isset($request->year) && empty($request->year) ? (!empty($ar) ? $ar[4]->{'value'} : '') : $request->year;
        $search_by_user = isset($request->search_by_user) && !empty($request->search_by_user) ? $request->search_by_user : '';

        $prnt_page_dir = 'print.college.custom_voucher_list.month_wise_custom_voucher_list';
        $pge_title = 'Month Wise Custom Fee Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from, $search_year);

        $pagination_number = empty($ar) ? 30 : 100000000;

        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $query = DB::table('transport_voucher')
            ->leftJoin('students', 'students.id', 'transport_voucher.tv_std_id')
            ->leftJoin('branches', 'branches.branch_id', 'transport_voucher.tv_branch_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'transport_voucher.tv_createdby')
            ->where('tv_clg_id', $user->user_clg_id)
            ->where('tv_branch_id', $branch_id)
            ->where('tv_status', '=', 0)
            ->selectRaw('MONTH(tv_issue_date) AS month, YEAR(tv_issue_date) AS year, count(tv_std_id) as total_students, sum(tv_total_amount) as total_amount, tv_issue_date,tv_due_date,tv_month');
        $ttl_amnt = $query->sum('tv_total_amount');

        if (!empty($request->search)) {
            $query
                ->where('tv_total_amount', 'like', '%' . $search . '%')
                ->orWhere('tv_remarks', 'like', '%' . $search . '%')
                ->orWhere('tv_id', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('tv_createdby', $search_by_user);
        }

        if (!empty($search_to) && !empty($search_from)) {
            $query->whereDate('tv_day_end_date', '>=', $start)->whereDate('tv_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('tv_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('tv_day_end_date', $end);
        }
        if (!empty($search_year)) {
            $query->where('tv_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('tv_year_id', '=', $search_year);
        }
        $datas = $query
            ->groupByRaw('tv_month,tv_issue_date')
            ->paginate($pagination_number);

        if (isset($request->array) && !empty($request->array)) {
            $type = isset($request->str) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('srch_fltr', 'datas', 'type', 'ttl_amnt', 'pge_title'));
            // $pdf->setOptions($options);

            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } elseif ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } elseif ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $search_year, $ttl_amnt, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('collegeViews.transport_voucher.month_transport_voucher_list', compact('datas', 'search', 'search_year', 'search_to', 'search_from', 'ttl_amnt', 'search_by_user'));
        }
    }

    public function month_transport_voucher_items_view_details(Request $request)
    {
        $user = Auth::user();
        $items = TransportVoucherModel::where('tv_month', $request->id)->where('tv_clg_id', $user->user_clg_id)->where('cv_branch_id', Session::get('branch_id'))->where('tv_status', 0)->get();
        return response()->json($items);
    }

    public function month_transport_voucher_items_view_details_SH(Request $request, $id)
    {
        $monthNumber = $request->month; // Assuming the month number is 3
        $year = $request->year; // Assuming the month number is 3
        $monthName = Carbon::createFromFormat('m', $monthNumber)->format('F');
        $month_year = $monthName . ' ' . $year; // Output: March
        $branch_id = Session::get('branch_id');
        $user = Auth::user();

        $issue_date = $request->issue_date;

        $items = TransportVoucherModel::leftJoin('students', 'students.id', '=', 'transport_voucher.tv_std_id')
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'students.section_id')
            ->leftJoin('branches', 'branches.branch_id', '=', 'transport_voucher.tv_branch_id')
            ->leftJoin('classes', 'classes.class_id', '=', 'students.class_id')
            ->leftJoin('transport', 'transport.tr_id', '=', 'students.route_id')
            ->where('tv_issue_date', $issue_date)
            ->where('tv_month', $month_year)->where('tv_clg_id', $user->user_clg_id)->where('tv_status', 0)->where('tv_branch_id', $branch_id)->get();
        $bank_info = BankAccountModel::where('bi_clg_id', $user->user_clg_id)->first();

        $type = 'grid';
        $pge_title = 'Transport Voucher';
        $data = [
            'items' => $items,
            'bank_info' => $bank_info,
        ];
        Session::put(['data' => $data]);
        return view('voucher_view.transportVoucher.view_transport_voucher_monthly', compact('data', 'type', 'pge_title', 'year', 'monthNumber', 'issue_date'));
    }

    public function month_transport_voucher_items_view_details_pdf_SH(Request $request, $id)
    {
        // Get the data for PDF
        $data = Session::get('data');
        $type = 'pdf';
        $page_title = 'Transport Voucher';

        // Dispatch the job to the queue
        GenerateTransportVoucherPDF::dispatch($data, $type, $page_title);

        // Optionally, you can return a message or redirect the user
        return response()->json(['message' => 'PDF generation started. You will be notified when ready!']);
//        $user = Auth::user();

//        $monthNumber = $request->month; // Assuming the month number is 3
//        $year = $request->year; // Assuming the month number is 3
//        $monthName = Carbon::createFromFormat('m', $monthNumber)->format('F');
//        $month_year = $monthName . ' ' . $year; // Output: March
//        $branch_id = Session::get('branch_id');
//        $issue_date = $request->issue_date;
//        $items = TransportVoucherModel::leftJoin('students', 'students.id', '=', 'transport_voucher.tv_std_id')
//            ->leftJoin('create_section', 'create_section.cs_id', '=', 'students.section_id')
//            ->leftJoin('branches', 'branches.branch_id', '=', 'transport_voucher.tv_branch_id')
//            ->leftJoin('classes', 'classes.class_id', '=', 'students.class_id')
//            ->leftJoin('transport', 'transport.tr_id', '=', 'students.route_id')
//            ->where('tv_issue_date', $issue_date)
//            ->where('tv_month', $month_year)->where('tv_clg_id', $user->user_clg_id)->where('tv_status', 0)->where('tv_branch_id', $branch_id)->get();
//        $bank_info = BankAccountModel::where('bi_clg_id', $user->user_clg_id)->first();

        $data = Session::get('data');
        Session::forget('data');

        $type = 'pdf';
        $pge_title = 'Transport Voucher';

        $options = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ]);

        $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        $pdf->getDomPDF()->setHttpContext($options);
        $pdf->loadView('voucher_view.transportVoucher.print_transport_voucher_monthly', compact('data', 'type', 'pge_title'));

        return $pdf->stream('Transport-Voucher-Detail.pdf');
    }

    public function transport_voucher_pending_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $branch_id = Session::get('branch_id');

        $month_year = TransportVoucherModel::where('tv_clg_id', '=', $user->user_clg_id)->where('tv_branch_id', '=', $branch_id)->groupBy('tv_month')->pluck('tv_month');

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_month = (!isset($request->month) && empty($request->month)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->month;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->from;

        $prnt_page_dir = 'print.college.transport_voucher_list.transport_voucher_list';
        $pge_title = 'Transport Pending Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from, $search_month);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $query = DB::table('transport_voucher')
            ->leftJoin('students', 'students.id', 'transport_voucher.tv_std_id')
            ->leftJoin('branches', 'branches.branch_id', 'transport_voucher.tv_branch_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'transport_voucher.tv_createdby')
            ->where('tv_clg_id', $user->user_clg_id)
            ->where('tv_branch_id', Session::get('branch_id'))
            ->where('tv_status', 0);
        $ttl_amnt = $query->sum('tv_total_amount');

        if (!empty($request->search)) {
            $query->where('tv_total_amount', 'like', '%' . $search . '%')
                ->orWhere('tv_remarks', 'like', '%' . $search . '%')
                ->orWhere('tv_id', 'like', '%' . $search . '%')
                ->orWhere('tv_v_no', 'like', '%' . $search . '%')
                ->orWhere('tv_reg_no', 'like', '%' . $search . '%');
        }

        if (!empty($search_month)) {
            $query->where('tv_month', $search_month);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereDate('tv_day_end_date', '>=', $start)
                ->whereDate('tv_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('tv_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('tv_day_end_date', $end);
        }

        $datas = $query->orderBy('tv_id', config('global_variables.query_sorting'))
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
            return view('collegeViews.transport_voucher.transport_voucher_pending_list', compact('datas', 'search', 'search_to', 'search_from', 'ttl_amnt', 'search_month', 'month_year'));
        }
    }

    public function transport_voucher_reverse_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $branch_id = Session::get('branch_id');

        $month_year = TransportVoucherModel::where('tv_clg_id', '=', $user->user_clg_id)->where('tv_branch_id', '=', $branch_id)->groupBy('tv_month')->pluck('tv_month');

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_month = (!isset($request->month) && empty($request->month)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->month;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->from;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->year;

        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.college.transport_voucher_list.transport_voucher_list';
        $pge_title = 'Transport Reverse Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from, $search_month, $search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $query = DB::table('transport_voucher')
            ->leftJoin('students', 'students.id', 'transport_voucher.tv_std_id')
            ->leftJoin('branches', 'branches.branch_id', 'transport_voucher.tv_branch_id')
            ->leftJoin('financials_users as createdUser', 'createdUser.user_id', 'transport_voucher.tv_createdby')
            ->leftJoin('financials_users as deleteUser', 'deleteUser.user_id', 'transport_voucher.tv_posted_by')
            ->where('tv_clg_id', $user->user_clg_id)
            ->where('tv_branch_id', Session::get('branch_id'))
            ->where('tv_status', 2);
        $ttl_amnt = $query->sum('tv_total_amount');

        if (!empty($request->search)) {
            $query->where('tv_total_amount', 'like', '%' . $search . '%')
                ->orWhere('tv_remarks', 'like', '%' . $search . '%')
                ->orWhere('tv_id', 'like', '%' . $search . '%')
                ->orWhere('tv_v_no', 'like', '%' . $search . '%')
                ->orWhere('tv_reg_no', 'like', '%' . $search . '%');
        }

        if (!empty($search_month)) {
            $query->where('tv_month', $search_month);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereDate('tv_day_end_date', '>=', $start)
                ->whereDate('tv_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('tv_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('tv_day_end_date', $end);
        }
        if (!empty($search_year)) {
            $query->where('tv_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('tv_year_id', '=', $search_year);
        }
        $datas = $query->orderBy('tv_id', config('global_variables.query_sorting'))
            ->select('transport_voucher.*', 'createdUser.user_name as createdBy', 'deleteUser.user_name as deletedBy', 'branches.branch_name',
                'students.full_name', 'students.registration_no')
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
            return view('collegeViews.transport_voucher.transport_voucher_reverse_list', compact('datas', 'search', 'search_year', 'search_to', 'search_from', 'ttl_amnt', 'search_by_user',
                'search_month', 'month_year'));
        }
    }

    public function reverse_transport_voucher(Request $request)
    {
        DB::beginTransaction();
        $user = Auth::user();
        $transport = TransportVoucherModel::where('tv_id', '=', $request->tv_id)->where('tv_status', 0)->first();

        $rollBack = false;
        if (!empty($transport)) {
            $dr_account_name = $this->get_account_name($transport->tv_cr_account);
            $cr_account_name = $this->get_account_name($transport->tv_dr_account);
            $dr_account = $transport->tv_cr_account;
            $cr_account = $transport->tv_dr_account;
            $student_id = $transport->tv_std_id;
            $reg_no = $transport->tv_reg_no;
            $amount = $transport->tv_total_amount;

            $notes = 'TRANSPORT_REVERSE_VOUCHER';

            $voucher_code = config('global_variables.TRANSPORT_VOUCHER_CODE');

            $transaction_type = config('global_variables.TRANSPORT');


            $transport_id = $transport->tv_id;
            $tv_voucher_no = $transport->tv_v_no;


            $transaction = new TransactionModel();

            $transaction = $this->AssignTransactionsValues($transaction, $dr_account, $amount, $cr_account, $notes, $transaction_type, $transport_id);

            if ($transaction->save()) {

                $transaction_id = $transaction->trans_id;

                // Selected Student Receivable Accounts
                $branch_id = $this->get_branch_id($dr_account);
                $balances = new BalancesModel();

                $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $dr_account, $amount, 'Dr', 'Reverse',
                    $notes, $cr_account_name . ' to ' . $dr_account_name . ', @' . number_format($amount, 2) . config('global_variables.Line_Break')
                    , $voucher_code . $transport_id, '', $voucher_code . $tv_voucher_no, $this->getYearEndId(), $branch_id);

                if (!$balance->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed');
                }

                // student balance
                $std_balances = new StudentBalances();

                $std_balances = $this->AssignStudentBalancesValues($std_balances, $dr_account_name, $amount, 'Cr',
                    $notes, $cr_account_name . ' to ' . $dr_account_name . ', @' . number_format($amount, 2) . config('global_variables.Line_Break'),
                    $voucher_code . $transport_id, $student_id, $reg_no, $branch_id);
                if (!$std_balances->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed');
                }


                // Selected Transport Income Accounts
                $branch_id = $this->get_branch_id($cr_account);
                $balances2 = new BalancesModel();

                $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id, $cr_account, $amount, 'Cr', 'Reverse',
                    $notes, $cr_account_name . ' to ' . $dr_account_name . ', @' . number_format($amount, 2) . config('global_variables.Line_Break'),
                    $voucher_code . $transport_id,
                    '', $voucher_code . $tv_voucher_no, $this->getYearEndId(), $branch_id);

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
            $transport->tv_status = 2;
            $transport->tv_posted_by = $user->user_id;
            $transport->tv_paid_date = Carbon::now();
            $transport->save();
            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $transport_id);
        }

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');

        } else {
            DB::commit();
            return redirect()->back()->with('success', 'Voucher Deleted Successfully');
        }

    }
}
