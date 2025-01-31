<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountRegisterationModel;
use App\Models\ApprovalJournalVoucherItemsModel;
use App\Models\ApprovalJournalVoucherModel;
use App\Models\BalancesModel;
use App\Models\JournalVoucherModel;
use App\Models\LogModel;
use App\Models\PostingReferenceModel;
use App\Models\SystemConfigModel;
use App\Models\TransactionModel;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class ApprovalJournalVoucherController extends Controller
{
    public function approval_journal_voucher()
    {
        $user = Auth::user();

        $query = AccountRegisterationModel::query();

        $accounts = $query
            ->where('account_uid', 'not like', config('global_variables.stock') . '%')
//            ->where('account_uid', 'not like', config('global_variables.cash') . '%')
            ->where('account_uid', 'not like', config('global_variables.walk_in_customer_head') . '%')
            ->where('account_uid', 'not like', config('global_variables.purchaser_account_head') . '%')
            ->where('account_uid', '!=', config('global_variables.sale_account'))
            ->where('account_uid', '!=', config('global_variables.sales_returns_and_allowances'))
            ->where('account_uid', '!=', config('global_variables.purchase_account'))
            ->where('account_uid', '!=', config('global_variables.purchase_return_and_allowances'))
            ->where('account_delete_status', '!=', 1)
            ->where('account_disabled', '!=', 1)
            ->orderBy('account_parent_code', 'ASC')
            ->orderBy('account_uid', 'ASC')
            ->get();

        $title = '';
//        $posting_references = PostingReferenceModel::where('pr_disabled', '=', 0)->get();
        $type = 'journal_voucher';
        $array_index = 0;
        $title = '';
        $route = 'account_registration';
        return view('approval_journal_voucher', compact('accounts', 'title', 'type', 'array_index', 'title', 'route'));
    }

    public function approval_journal_voucher_bank()
    {

        $accounts = $this->get_fourth_level_account(config('global_variables.bank_head'), 0, 0);

        $type = 'bank_voucher';
        $array_index = 1;
        $title = 'Bank';
        $route = 'bank_account_registration';
        return view('approval_journal_voucher', compact('accounts', 'title', 'type', 'array_index', 'route'));
    }

    public function approval_journal_voucher_reference()
    {

        $heads = explode(',', config('global_variables.payable_receivable'));

        $accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)->orderBy('account_uid', 'ASC')->get();


        $type = 'journal_voucher';
        $title = 'Reference';
        $array_index = 0;
        $route = 'account_registration';
        return view('approval_journal_voucher', compact('accounts', 'title', 'type', 'array_index', 'route'));
    }

    public function submit_approval_journal_voucher(Request $request)
    {
        $user = Auth::user();
        $this->approval_journal_voucher_validation($request);

        $flag = false;

        $values_array = json_decode($request->accountsval, true);

        $notes = 'APPROVAL_JOURNAL_VOUCHER';
        $voucher_code = config('global_variables.APPROVAL_JOURNAL_VOUCHER_CODE');
        $transaction_type = config('global_variables.AJV');

        $total_dr = 0;
        $total_cr = 0;
        foreach ($values_array as $key) {
            if ($key[3] == 'Dr') {
                $total_dr += $key[2];
            } else {
                $total_cr += $key[2];
            }
        }
        if ($total_dr != $total_cr) {
            return redirect('approval_journal_voucher')->with('fail', 'Failed');
        }

        DB::beginTransaction();

        $ajv = new ApprovalJournalVoucherModel();
        $ajv_v_no = ApprovalJournalVoucherModel::where('ajv_clg_id', $user->user_clg_id)->max('ajv_v_no');

        $ajv = $this->assign_approval_journal_voucher_values($request, $ajv, $ajv_v_no + 1);
        $ajv->ajv_status = 'Pending';

        if ($ajv->save()) {
            $ajv_id = $ajv->ajv_id;
            $jv_voucher_no = $ajv->ajv_v_no;

            $items = [];
            $detail_remarks = '';

            $item = $this->assign_approval_journal_voucher_items_values($values_array, $items, $ajv_id, $jv_voucher_no);

            foreach ($item as $value) {

                $ajvi_amount = (float)$value['ajvi_amount'];

                $detail_remarks .= $value['ajvi_account_name'] . ', ' . $value['ajvi_type'] . '@' . number_format($ajvi_amount, 2) . "  '" . $value['ajvi_remarks'] . "'" . config('global_variables.Line_Break');
            }

            if (DB::table('financials_approval_journal_voucher_items')->insert($item)) {
                if ($flag) {
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed');
                } else {

                    $user = Auth::User();

                    $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Approval Journal Voucher With Id: ' . $ajv->ajv_id);

                    $ajv->ajv_detail_remarks = $detail_remarks;
                    $ajv->save();

                    DB::commit();
                    return redirect()->back()->with(['ajv_id' => $ajv_id, 'success' => 'Successfully Saved']);
                }
            } else {
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed');
            }
        } else {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }
        DB::rollBack();
        return redirect()->back()->with('fail', 'Failed');
    }

    public function approval_journal_voucher_validation($request)
    {
        return $this->validate($request, [
            'session' => ['nullable', 'string'],
            'business_name' => ['nullable', 'string'],
            'remarks' => ['nullable', 'string'],
            'total_debit' => ['required', 'numeric', 'same:total_credit'],
            'total_credit' => ['required', 'numeric', 'same:total_debit'],
            'accountsval' => ['required', 'string'],
        ]);
    }

    public function assign_approval_journal_voucher_values($request, $ajv, $voucher_v_no)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();
        $ajv->ajv_v_no = $voucher_v_no;
        $ajv->ajv_voucher_type = $request->voucher_type;
        $ajv->ajv_session = $request->session;
        $ajv->ajv_business_name = $request->business_name;
        $ajv->ajv_remarks = ucfirst($request->remarks);
        $ajv->ajv_total_dr = $request->total_debit;
        $ajv->ajv_total_cr = $request->total_credit;
        $ajv->ajv_created_datetime = Carbon::now()->toDateTimeString();
        $ajv->ajv_day_end_id = $day_end->de_id;
        $ajv->ajv_day_end_date = $day_end->de_datetime;
        $ajv->ajv_createdby = $user->user_id;
        $ajv->ajv_clg_id = $user->user_clg_id;
        $ajv->ajv_branch_id = Session::get('branch_id');
        $ajv->ajv_year_id = $this->getYearEndId();

        // coding from shahzaib start
        $tbl_var_name = 'ajv';
        $prfx = 'ajv';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now()->toDateTimeString();
        // coding from shahzaib end

        return $ajv;
    }

    public function assign_approval_journal_voucher_items_values($accountsval, $data, $ajv_id, $jv_voucher_no)
    {
        // coding from shahzaib start
        $prfx = 'ajvi';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';
        // coding from shahzaib end


        foreach ($accountsval as $key) {
            $data[] = ['ajvi_journal_voucher_id' => $ajv_id, 'ajvi_v_no' => $jv_voucher_no, 'ajvi_account_id' => $key[0], 'ajvi_account_name' => $key[1], 'ajvi_amount' => $key[2], 'ajvi_type' => $key[3], 'ajvi_pr_id' => $key[5],
                'ajvi_remarks' => $key[4] == 'N/A' ? $key[4] : ucfirst($key[4]), $brwsr_col => $brwsr_rslt, $ip_col => $ip_rslt, $updt_date_col => Carbon::now()->toDateTimeString(), 'ajvi_year_id' => $this->getYearEndId()];
        }

        return $data;
    }

    public function approval_journal_voucher_list(Request $request, $array = null, $str = null)
    {
        $urls = $request->getRequestUri();
        // Or we can write ltrim($str, $str[0]);
        $urls = ltrim($urls, '/');

        $status = 'Pending';
        if (strpos($request->getRequestUri(), 'approval_journal_voucher_all_list')) $status = '';
        if (strpos($request->getRequestUri(), 'approval_journal_voucher_approved_list')) $status = 'Approved';
        if (strpos($request->getRequestUri(), 'approval_journal_voucher_rejected_list')) $status = 'Rejected';

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.approval_journal_voucher_list.approval_journal_voucher_list';
        $pge_title = 'Approval Journal Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from, $search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $query = DB::table('financials_approval_journal_voucher')->where('ajv_status', 'like', $status . '%')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_approval_journal_voucher.ajv_createdby');
//            ->where('ajv_consume_amount','=',0.00);
        $ttl_dr = $query->sum('ajv_total_dr');
        $ttl_cr = $query->sum('ajv_total_cr');


        if (!empty($request->search)) {
            $query->where(function ($q) use ($search) {
                $q->where('ajv_total_dr', 'like', '%' . $search . '%')
                    ->orWhere('ajv_total_cr', 'like', '%' . $search . '%')
                    ->orWhere('ajv_remarks', 'like', '%' . $search . '%')
                    ->orWhere('ajv_id', 'like', '%' . $search . '%')
                    ->orWhere('user_designation', 'like', '%' . $search . '%')
                    ->orWhere('user_name', 'like', '%' . $search . '%')
                    ->orWhere('user_username', 'like', '%' . $search . '%');
            });
        }

        if (!empty($search_by_user)) {
            $query->where('ajv_createdby', $search_by_user);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereDate('ajv_day_end_date', '>=', $start)
                ->whereDate('ajv_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('ajv_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('ajv_day_end_date', $end);
        }
        if (!empty($search_year)) {
            $query->where('ajv_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('ajv_year_id', '=', $search_year);
        }
        $datas = $query->orderBy('ajv_id', 'DESC')
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
            return view('approval_journal_voucher_list', compact('datas', 'search', 'search_year', 'search_to', 'search_from', 'ttl_dr', 'ttl_cr', 'search_by_user', 'status', 'urls'));
        }
    }

    public function approval_journal_voucher_items_view_details(Request $request)
    {
        $items = ApprovalJournalVoucherItemsModel::where('ajvi_journal_voucher_id', $request->id)->orderby('ajvi_account_name', 'ASC')->get();
        return response()->json($items);
    }

    public function approval_journal_voucher_items_view_details_SH(Request $request, $id)
    {
        $jrnl = ApprovalJournalVoucherModel::with('user')->where('ajv_id', $id)->first();
        $items = ApprovalJournalVoucherItemsModel::where('ajvi_journal_voucher_id', $id)->get();
        $nbrOfWrds = $this->myCnvrtNbr($jrnl->ajv_total_dr);
        $invoice_nbr = $jrnl->ajv_id;
//        $invoice_date = $jrnl->ajv_created_datetime;
        $invoice_date = $jrnl->ajv_day_end_date;
        $invoice_remarks = $jrnl->ajv_remarks;
        $type = 'grid';
        $pge_title = 'Approval Journal Voucher';

        return view('voucher_view.approval_journal_voucher.approval_journal_voucher_list_modal', compact('items', 'jrnl', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title', 'invoice_remarks'));
    }

    public function approval_journal_voucher_items_view_details_pdf_SH(Request $request, $id)
    {
        $jrnl = ApprovalJournalVoucherModel::with('user')->where('ajv_id', $id)->first();
        $items = ApprovalJournalVoucherItemsModel::where('ajvi_journal_voucher_id', $id)->get();
        $nbrOfWrds = $this->myCnvrtNbr($jrnl->ajv_total_dr);
        $invoice_nbr = $jrnl->ajv_id;
//        $invoice_date = $jrnl->ajv_created_datetime;
        $invoice_date = $jrnl->ajv_day_end_date;
        $invoice_remarks = $jrnl->ajv_remarks;
        $type = 'pdf';
        $pge_title = 'Approval Journal Voucher';

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
        $pdf = PDF::loadView('voucher_view.approval_journal_voucher.approval_journal_voucher_list_modal', compact('items', 'invoice_nbr', 'invoice_date', 'jrnl', 'nbrOfWrds', 'type', 'pge_title', 'invoice_remarks'));
        // $pdf->setOptions($options);


        return $pdf->stream('Approval_Journal-Voucher-Detail.pdf');
    }

    public function approval_journal_voucher_edit(Request $request)
    {
        $posting_references = PostingReferenceModel::where('pr_disabled', '=', 0)->get();
        $user = Auth::user();
//        $ajv = ApprovalJournalVoucherModel::join('financials_approval_journal_voucher_items', 'financials_approval_journal_voucher_items.ajvi_journal_voucher_id', 'financials_approval_journal_voucher.ajv_createdby')
//            ->where('ajv_id', '=', $request->ajv_id)->get();
        $ajv = ApprovalJournalVoucherModel::where('ajv_id', '=', $request->ajv_id)->first();
        $ajvi = ApprovalJournalVoucherItemsModel::with('postingReference')->where('ajvi_journal_voucher_id', '=', $ajv->ajv_id)->get();
        $ajv['approval_journal_voucher_items'] = $ajvi;

        $query = AccountRegisterationModel::query();
        $accounts = $query
            ->where('account_uid', 'not like', config('global_variables.stock') . '%')
            ->where('account_uid', 'not like', config('global_variables.cash') . '%')
            ->where('account_uid', 'not like', config('global_variables.walk_in_customer_head') . '%')
            ->where('account_uid', 'not like', config('global_variables.purchaser_account_head') . '%')
            ->where('account_uid', '!=', config('global_variables.sale_account'))
            ->where('account_uid', '!=', config('global_variables.sales_returns_and_allowances'))
            ->where('account_uid', '!=', config('global_variables.purchase_account'))
            ->where('account_uid', '!=', config('global_variables.purchase_return_and_allowances'))
            ->where('account_delete_status', '!=', 1)
            ->where('account_disabled', '!=', 1)
            ->orderBy('account_parent_code', 'ASC')
            ->orderBy('account_uid', 'ASC')
            ->get();

        $title = '';

        return view('approval_journal_voucher_edit', compact('accounts', 'title', 'user', 'ajv', 'posting_references'));
    }

    public function approval_journal_voucher_update(Request $request)
    {
        $this->approval_journal_voucher_validation($request);

        $flag = false;

        $values_array = json_decode($request->accountsval, true);


        $notes = 'APPROVAL_JOURNAL_VOUCHER';
        $voucher_code = config('global_variables.APPROVAL_JOURNAL_VOUCHER_CODE');
        $transaction_type = config('global_variables.AJV');

        $total_dr = 0;
        $total_cr = 0;
        foreach ($values_array as $key) {
            if ($key[3] == 'Dr') {
                $total_dr += $key[2];
            } else {
                $total_cr += $key[2];
            }
        }
        if ($total_dr != $total_cr) {
            return redirect('approval_journal_voucher')->with('fail', 'Failed');
        }

        DB::beginTransaction();

        /* ========== Log ========== */
        $ajv = ApprovalJournalVoucherModel::where('ajv_id', '=', $request->ajv_id)->first();
        $ajvi = ApprovalJournalVoucherItemsModel::where('ajvi_journal_voucher_id', '=', $request->ajv_id)->get()->toArray();
        $ajv['approval_journal_voucher_items'] = $ajvi;
        $ajv_json = json_encode($ajv);

        $this->createLog($ajv->ajv_id, config('global_variables.Approval_Journal_Voucher'), $ajv_json);
        /* ========== Log ========== */

        $ajv = $this->assign_approval_journal_voucher_values($request, $ajv, $ajv->ajv_v_no);
        unset($ajv['approval_journal_voucher_items']);
        if ($ajv->save()) {
            $ajv_id = $ajv->ajv_id;

            ApprovalJournalVoucherItemsModel::where('ajvi_journal_voucher_id', '=', $request->ajv_id)->delete();

            $items = [];
            $detail_remarks = '';

            $item = $this->assign_approval_journal_voucher_items_values($values_array, $items, $ajv_id,$ajv->ajv_v_no);

            foreach ($item as $value) {

                $ajvi_amount = (float)$value['ajvi_amount'];

                $detail_remarks .= $value['ajvi_account_name'] . ', ' . $value['ajvi_type'] . '@' . number_format($ajvi_amount, 2) . config('global_variables.Line_Break');
            }

            if (DB::table('financials_approval_journal_voucher_items')->insert($item)) {
                if ($flag) {
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed');
                } else {

                    $user = Auth::User();

                    $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Approval Journal Voucher With Id: ' . $ajv->ajv_id);

                    $ajv->ajv_detail_remarks = $detail_remarks;
                    $ajv->save();

                    DB::commit();
                    return redirect()->route('approval_journal_voucher_list')->with(['ajv_id' => $ajv_id, 'success' => 'Successfully Saved']);
                }
            } else {
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed');
            }
        } else {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }
        DB::rollBack();
        return redirect()->back()->with('fail', 'Failed');
    }

    public function approval_journal_voucher_response(Request $request)
    {
        $user = Auth::user();
        $ajv = ApprovalJournalVoucherModel::where('ajv_id', '=', $request->ajv_response_id)->first();
        if (!isset($ajv)) return redirect()->back()->with('fail', 'Approval Journal Voucher not found');

        if ($request->ajv_response_type == 'approved') {
            $ajv->ajv_status = 'Approved';
        } elseif ($request->ajv_response_type == 'rejected') {
            $ajv->ajv_status = 'Rejected';
        } else {
            return redirect()->back()->with('fail', 'Something Went Wrong');
        }
        $ajv->save();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' "' . $ajv->ajv_status . '""  Approval Journal Voucher With Id: ' . $ajv->ajv_id);

        return redirect()->back()->with('success', 'Successfully Save');
    }

    public function approval_journal_voucher_confirm(Request $request)
    {
        $user = Auth::user();
        $ajv_id = $request->ajv_confirm_id;
        $ajv = ApprovalJournalVoucherModel::where('ajv_id', '=', $ajv_id)->first();
        $ajvi = ApprovalJournalVoucherItemsModel::where('ajvi_journal_voucher_id', '=', $ajv_id)->get();

        $flag = false;

        $values_array = [];
        foreach ($ajvi as $key => $jvi) {
            $values_array[] = [$jvi->ajvi_account_id, $jvi->ajvi_account_name, $jvi->ajvi_amount, $jvi->ajvi_type, $jvi->ajvi_remarks, $jvi->ajvi_pr_id];
        }

        $notes = 'APPROVAL_JOURNAL_VOUCHER';
        $voucher_code = config('global_variables.APPROVAL_JOURNAL_VOUCHER_CODE');
        $transaction_type = config('global_variables.AJV');

        $total_dr = 0;
        $total_cr = 0;
        foreach ($values_array as $key) {
            if ($key[3] == 'Dr') {
                $total_dr += $key[2];
            } else {
                $total_cr += $key[2];
            }
        }
        if ($total_dr != $total_cr) {
            return redirect()->back()->with('fail', 'Failed');
        }

        DB::beginTransaction();

//        $jv = new JournalVoucherModel();
//        $jv_v_no = JournalVoucherModel::where('jv_clg_id', $user->user_clg_id)->count();
//        $jv = $this->assign_journal_voucher_values($ajv, $jv, $jv_v_no, $jv_v_no + 1);


//        if ($jv->save()) {
        $jv_id = $ajv->ajv_id;
        $jv_voucher_no = $ajv->ajv_v_no;

        $items = [];
        $detail_remarks = $ajv->ajv_detail_remarks;

//            $item = $this->assign_journal_voucher_items_values($values_array, $items, $jv_id, $jv_voucher_no);

//            foreach ($item as $value) {
//
//                $jvi_amount = (float)$value['jvi_amount'];
//
//                $detail_remarks .= $value['jvi_account_name'] . ', ' . $value['jvi_type'] . '@' . number_format($jvi_amount, 2) . config('global_variables.Line_Break');
//            }

//            if (DB::table('financials_journal_voucher_items')->insert($item)) {

        foreach ($values_array as $key) {

            $transaction = new TransactionModel();

            if ($key[3] == 'Dr') {

                $transaction = $this->AssignTransactionsValues($transaction, $key[0], $key[2], 0, $notes, $transaction_type, $jv_id);

                if ($transaction->save()) {

                    $transaction_id = $transaction->trans_id;
                    $branch_id = $this->get_branch_id($key[0]);
                    $balances = new BalancesModel();

                    $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key[0], $key[2], $key[3], $key[4], $notes, $detail_remarks, $voucher_code .
                        $jv_id, $key[5], $voucher_code . $jv_voucher_no, $this->getYearEndId(), $branch_id);

                    if (!$balance->save()) {

                        $flag = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed');
                    }
                } else {
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed');
                }

            } else {

                $transaction = $this->AssignTransactionsValues($transaction, 0, $key[2], $key[0], 'JOURNAL VOUCHER', 5, $jv_id);
                if ($transaction->save()) {
                    $transaction_id = $transaction->trans_id;
                    $branch_id = $this->get_branch_id($key[0]);
                    $balances = new BalancesModel();

                    $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key[0], $key[2], $key[3], $key[4], $notes, $detail_remarks, $voucher_code .
                        $jv_id, $key[5], $voucher_code . $jv_voucher_no, $this->getYearEndId(), $branch_id);

                    if (!$balance->save()) {
                        $flag = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed');
                    }
                } else {
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed');
                }
            }
        }


        if ($flag) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        } else {

            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Approval Journal Voucher With Id: ' . $ajv->ajv_id);

//                    $jv->jv_detail_remarks = $detail_remarks;
//                    $jv->save();


            DB::commit();

            $ajv->ajv_status = 'Confirmed';
            $ajv->save();

            return redirect()->back()->with(['jv_id' => $jv_id, 'success' => 'Successfully Saved']);
        }
//            } else {
//                DB::rollBack();
//                return redirect()->back()->with('fail', 'Failed');
//            }
//        } else {
//            DB::rollBack();
//            return redirect()->back()->with('fail', 'Failed');
//        }
        DB::rollBack();
        return redirect()->back()->with('fail', 'Failed');
    }

    private function assign_journal_voucher_values(ApprovalJournalVoucherModel $ajv, JournalVoucherModel $jv, $jv_v_no)
    {

        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $jv->jv_project_id = $ajv->ajv_project_id;
        $jv->jv_order_list_id = $ajv->ajv_order_list_id;
        $jv->jv_remarks = ucfirst($ajv->ajv_remarks);
        $jv->jv_total_dr = $ajv->ajv_total_dr;
        $jv->jv_total_cr = $ajv->ajv_total_cr;
        $jv->jv_created_datetime = Carbon::now()->toDateTimeString(); //
        $jv->jv_day_end_id = $day_end->de_id;
        $jv->jv_day_end_date = $day_end->de_datetime;
        $jv->jv_createdby = $user->user_id;
        $jv->jv_v_no = $jv_v_no;
        // coding from shahzaib start
        $tbl_var_name = 'jv';
        $prfx = 'jv';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now()->toDateTimeString();
        // coding from shahzaib end

        return $jv;
    }

    private function assign_journal_voucher_items_values(array $values_array, array $items, $jv_id, $jv_voucher_no)
    {
        // coding from shahzaib start
        $prfx = 'jvi';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';
        // coding from shahzaib end


        foreach ($values_array as $key) {
            $data[] = ['jvi_journal_voucher_id' => $jv_id, 'jvi_account_id' => $key[0], 'jvi_v_no' => $jv_voucher_no, 'jvi_account_name' => $key[1], 'jvi_amount' => $key[2], 'jvi_type' => $key[3], 'jvi_pr_id' => $key[5], 'jvi_remarks' => $key[4] == 'N/A' ? $key[4] : ucfirst($key[4]), $brwsr_col => $brwsr_rslt, $ip_col => $ip_rslt, $updt_date_col => Carbon::now()->toDateTimeString()];
        }

        return $data;
    }

}
