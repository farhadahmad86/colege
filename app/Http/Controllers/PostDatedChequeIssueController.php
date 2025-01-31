<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\CashPaymentVoucherItemsModel;
use App\Models\CashPaymentVoucherModel;
use App\Models\CashTransferModel;
use App\Models\JournalVoucherModel;
use App\Models\PostDatedChequeModel;
use App\Models\PostingReferenceModel;
use App\Models\TransactionModel;
use Auth;

use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class PostDatedChequeIssueController extends Controller
{
    public function add_post_dated_cheque_issue()
    {
        $heads = config('global_variables.payable_receivable');
        $heads = explode(',', $heads);

//        $to_accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)->orderBy('account_uid', 'ASC')->get();
        $to_accounts = $this->get_fourth_level_account($heads, 0, 1);

//        $from_accounts = AccountRegisterationModel::where('account_parent_code', config('global_variables.bank_head'))->orderBy('account_uid', 'ASC')->get();
        $from_accounts = $this->get_fourth_level_account(config('global_variables.bank_head'), 0, 0);
        $posting_references = PostingReferenceModel::where('pr_disabled','=',0)->get();
        return view('add_post_dated_cheque_issue', compact('to_accounts', 'from_accounts', 'posting_references'));
    }

    public function submit_post_dated_cheque_issue(Request $request)
    {
        $this->post_dated_cheque_issue_validation($request);

        $post_dated_cheque_issue = new PostDatedChequeModel();

        $post_dated_cheque_issue = $this->AssignPostDatedChequeValues($request, $post_dated_cheque_issue, 'ISSUED', 'PENDING');

        $post_dated_cheque_issue->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Post Dated Cheque Issue With Id: ' . $post_dated_cheque_issue->pdc_id . ' In Pending State');

        return redirect()->back()->with('success', 'Successfully Saved');
    }

    public function post_dated_cheque_issue_validation($request)
    {
        return $this->validate($request, [
            'from' => ['required', 'numeric'],
            'to' => ['required', 'numeric'],
            'amount' => ['required', 'numeric'],
            'cheque_date' => ['required', 'date', 'after_or_equal:today'],
            'remarks' => ['nullable', 'string'],
        ]);

    }

    public function AssignPostDatedChequeValues($request, $post_dated_cheque_issue, $type, $status)
    {
        $user = Auth::User();

        $post_dated_cheque_issue->pdc_type = $type;
        $post_dated_cheque_issue->pdc_status = $status;
        $post_dated_cheque_issue->pdc_account_code = $request->from;
        $post_dated_cheque_issue->pdc_party_code = $request->to;
        $post_dated_cheque_issue->pdc_amount = $request->amount;
        $post_dated_cheque_issue->pdc_pr_id = $request->posting_reference;
        $post_dated_cheque_issue->pdc_cheque_date = date('Y-m-d', strtotime($request->cheque_date));
        $post_dated_cheque_issue->pdc_remarks = ucfirst($request->remarks);
        $post_dated_cheque_issue->pdc_created_by = $user->user_id;
        $post_dated_cheque_issue->pdc_datetime = Carbon::now()->toDateTimeString();
        $post_dated_cheque_issue->pdc_year_id = $this->getYearEndId();

        // coding from shahzaib start
        $tbl_var_name = 'post_dated_cheque_issue';
        $prfx = 'pdc';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now()->toDateTimeString();
        // coding from shahzaib end


        return $post_dated_cheque_issue;
    }


    // update code by shahzaib start
    public function post_dated_cheque_issue_list(Request $request, $array = null, $str = null)
    {
        $heads = config('global_variables.payable_receivable');
        $heads = explode(',', $heads);

        $to_accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)->orderBy('account_uid', 'ASC')->get();

        $from_accounts = AccountRegisterationModel::where('account_parent_code', config('global_variables.bank_head'))->orderBy('account_uid', 'ASC')->get();

        $title = 'Pending Post Dated Cheque Issue List';


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_account_from = (!isset($request->from_accounts) && empty($request->from_accounts)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->from_accounts;
        $search_account_to = (!isset($request->to_accounts) && empty($request->to_accounts)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->to_accounts;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->from;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.post_dated_cheque_issue_list.post_dated_cheque_issue_list';
        $pge_title = 'Post Dated Cheque Issue List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from, $search_account_to, $search_account_from,$search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));


        $query = DB::table('financials_post_dated_cheques')
            ->join('financials_accounts AS ac1', 'financials_post_dated_cheques.pdc_party_code', '=', 'ac1.account_uid')
            ->join('financials_accounts AS ac2', 'financials_post_dated_cheques.pdc_account_code', '=', 'ac2.account_uid')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_post_dated_cheques.pdc_created_by')
            ->select('ac1.account_name AS to', 'ac2.account_name AS from', 'financials_post_dated_cheques.pdc_amount', 'financials_post_dated_cheques.pdc_remarks', 'financials_post_dated_cheques.pdc_cheque_date', 'financials_post_dated_cheques.pdc_id', 'financials_post_dated_cheques.pdc_party_code', 'financials_post_dated_cheques.pdc_account_code', 'financials_post_dated_cheques.pdc_ip_adrs', 'financials_post_dated_cheques.pdc_brwsr_info', 'financials_users.*');

        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ac1.account_name', 'like', '%' . $search . '%')
                    ->orWhere('ac2.account_name', 'like', '%' . $search . '%')
                    ->orWhere('pdc_amount', 'like', '%' . $search . '%')
                    ->orWhere('pdc_cheque_date', 'like', '%' . $search . '%')
                    ->orWhere('pdc_remarks', 'like', '%' . $search . '%')
                    ->orWhere('pdc_id', 'like', '%' . $search . '%')
                    ->orWhere('user_designation', 'like', '%' . $search . '%')
                    ->orWhere('user_name', 'like', '%' . $search . '%')
                    ->orWhere('user_username', 'like', '%' . $search . '%');
            });
        }

        if (!empty($search_account_to)) {
            $query->where('pdc_party_code', $search_account_to);
        }

        if (!empty($search_account_from)) {
            $query->where('pdc_account_code', $search_account_from);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereDate('pdc_datetime', '>=', $start)
                ->whereDate('pdc_datetime', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('pdc_datetime', $start);
        } elseif (!empty($search_from)) {
            $query->where('pdc_datetime', $end);
        }

        if (!empty($search_by_user)) {
            $query->where('pdc_created_by', $search_by_user);
        }
        if (!empty($search_year)) {
            $query->where('pdc_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('pdc_year_id', '=', $search_year);
        }
        $datas = $query->where('pdc_type', 'ISSUED')
            ->where('pdc_status', 'PENDING')
            ->orderBy('pdc_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);


//        $pdc_title = PostDatedChequeModel::orderBy('pdc_id', 'DESC')->pluck('pdc_title')->all();

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
            return view('post_dated_cheque_issue_list', compact('datas', 'title', 'search_by_user','search_year', 'search', 'to_accounts', 'from_accounts', 'search_to', 'search_from', 'search_account_to', 'search_account_from'));
        }


    }
    // update code by shahzaib end


    public function approve_post_dated_cheque_issue(Request $request)
    {
        $this->validate($request, [
            'send_by_account' => ['required', 'numeric'],
            'send_by_account_name' => ['required', 'string'],
            'receive_by_account' => ['required', 'numeric'],
            'receive_by_account_name' => ['required', 'string'],
            'amount' => ['required', 'numeric'],
            'approve_id' => ['required', 'numeric'],
            'cheque_date' => ['required', 'date'],
            'remarks' => ['nullable', 'string'],
        ]);

        $notes = 'POST_DATED_CHEQUE_ISSUED';
        $voucher_code = config('global_variables.POST_DATED_CHEQUE_ISSUE');
        $transaction_type = config('global_variables.POST_DATED_CHEQUE');

        DB::beginTransaction();

        $post_dated_cheque_issue = PostDatedChequeModel::where('pdc_id', $request->approve_id)->first();
        $post_dated_cheque_issue->pdc_status = 'CONFIRMED';

        if ($post_dated_cheque_issue->save()) {

            $get_day_end = new DayEndController();
            $day_end = $get_day_end->day_end();
//            $p_invoice = new PurchaseInvoiceController();

            $send_by_account = $request->send_by_account;
//            $send_by_account_name = $request->send_by_account_name;

            $receive_by_account = $request->receive_by_account;
//            $receive_by_account_name = $request->receive_by_account_name;

            $amount = $request->amount;

            $detail_remarks = 'Cheque of Dated: ' . date("d-m-Y", strtotime($request->cheque_date)) . ' , Amount: ' . $amount . ' , ' . $request->remarks;

            $transaction = new TransactionModel();

//            $transaction = $p_invoice->AssignTransactionValues($request, $transaction, $receive_by_account, $amount, $send_by_account, 'POST DATED CHEQUE ISSUED', 15, $request->approve_id);

            $transaction = $this->AssignTransactionsValues($transaction, $receive_by_account, $amount, $send_by_account, $notes, $transaction_type, $request->approve_id);
            if ($transaction->save()) {

                $transaction_id = $transaction->trans_id;

                $balances = [];
                $balance = $this->assign_balances_values($request, $balances, $transaction_id, $receive_by_account, $send_by_account, $amount, $notes, $request->remarks, $detail_remarks,
                    $voucher_code . $request->approve_id, $day_end, $post_dated_cheque_issue->pdc_pr_id);

                if (DB::table('financials_balances')->insert($balance)) {

                    $user = Auth::User();

                    $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Approve Post Dated Cheque Issue With Id: ' . $post_dated_cheque_issue->pdc_id);

                    DB::commit();
                    return redirect('post_dated_cheque_issue_list')->with('success', 'Successfully Saved');
                } else {
                    DB::rollBack();
                    return redirect('post_dated_cheque_issue_list')->with('fail', 'Failed');
                }
            } else {
                DB::rollBack();
                return redirect('post_dated_cheque_issue_list')->with('fail', 'Failed');
            }
        }

        return redirect('post_dated_cheque_issue_list')->with('fail', 'Failed');
    }

    public function assign_balances_values($request, $data, $transaction_id, $dr, $cr, $amount, $type, $remarks, $detail_remarks, $pdci_id, $day_end, $posting_id)
    {
        $user = Auth::user();

        $calculate_balance = new BalancesController();

        $previous_balance_dr = $calculate_balance->calculate_balance($dr);

        $account = substr($dr, 0, 5);

        // coding from shahzaib start
        $prfx = 'bal';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';
        // coding from shahzaib end

        $total_balance_dr='';
//        if ($account == config('global_variables.payable')) {
//            //payables
//            $total_balance_dr = $previous_balance_dr - $amount;

//        } elseif ($account == config('global_variables.receivable')) {

            $total_balance_dr = $previous_balance_dr + $amount;
//        }

        $data[] = ['bal_account_id' => $dr, 'bal_transaction_type' => $type, 'bal_remarks' => ucfirst($remarks), 'bal_dr' => $amount, 'bal_cr' => 0, 'bal_total' => $total_balance_dr, 'bal_transaction_id' => $transaction_id, 'bal_pr_id' => $posting_id, 'bal_datetime' => Carbon::now()->toDateTimeString(), 'bal_day_end_id' => $day_end->de_id, 'bal_day_end_date' => $day_end->de_datetime, 'bal_detail_remarks' => $detail_remarks, 'bal_voucher_number' => $pdci_id, 'bal_user_id' => $user->user_id, $brwsr_col => $brwsr_rslt, $ip_col => $ip_rslt, $updt_date_col => Carbon::now()->toDateTimeString(),'bal_year_id'=>$this->getYearEndId(),'bal_v_year_id'=>$this->getYearEndId()];


        $previous_balance_cr = $calculate_balance->calculate_balance($cr);

        $total_balance_cr = $previous_balance_cr - $amount;

        $data[] = ['bal_account_id' => $cr, 'bal_transaction_type' => $type, 'bal_remarks' => ucfirst($remarks), 'bal_dr' => 0, 'bal_cr' => $amount, 'bal_total' => $total_balance_cr, 'bal_transaction_id' => $transaction_id, 'bal_pr_id' => $posting_id, 'bal_datetime' => Carbon::now()->toDateTimeString(), 'bal_day_end_id' => $day_end->de_id, 'bal_day_end_date' => $day_end->de_datetime, 'bal_detail_remarks' => $detail_remarks, 'bal_voucher_number' => $pdci_id, 'bal_user_id' => $user->user_id, $brwsr_col => $brwsr_rslt, $ip_col => $ip_rslt, $updt_date_col => Carbon::now()->toDateTimeString(),'bal_year_id'=>$this->getYearEndId(),'bal_v_year_id'=>$this->getYearEndId()];

        return $data;
    }

    public function reject_post_dated_cheque_issue(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'reject' => ['required', 'numeric'],
            'reason' => ['required', 'string'],
        ]);

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $post_dated_cheque_issue = PostDatedChequeModel::where('pdc_id', $request->reject)->first();

        $post_dated_cheque_issue->pdc_status = 'REJECTED';
        $post_dated_cheque_issue->pdc_reason = ucfirst($request->reason);

        $post_dated_cheque_issue->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Reject Post Dated Cheque Issue With Id: ' . $post_dated_cheque_issue->pdc_id);

        $account = $post_dated_cheque_issue->pdc_party_code;

        $calculate_balance = new BalancesController();

        $balances = new BalancesModel();

        $previous_balance = $calculate_balance->calculate_balance($account);

        $remarks = 'Cheque Dishonoured of Dated: ' . date("d-m-Y", strtotime($post_dated_cheque_issue->pdc_cheque_date)) . ' , Amount: ' . $post_dated_cheque_issue->pdc_amount . ' , ' . $post_dated_cheque_issue->pdc_remarks . ' , Rejected Reason: ' . $post_dated_cheque_issue->pdc_reason;

        $balances->bal_account_id = $account;
        $balances->bal_transaction_type = 'POST DATED CHEQUE DISHONOURED';
        $balances->bal_remarks = $remarks;
        $balances->bal_dr = 0;
        $balances->bal_cr = 0;
        $balances->bal_total = $previous_balance;
        $balances->bal_transaction_id = 0;
        $balances->bal_day_end_id = $day_end->de_id;
        $balances->bal_day_end_date = $day_end->de_datetime;
        $balances->bal_detail_remarks = $remarks;
        $balances->bal_voucher_number = 'PDCI-' . $request->reject;
        $balances->bal_user_id = $user->user_id;
        $balances->bal_year_id = $this->getYearEndId();

        $balances->save();

        return redirect()->back()->with('success', 'Successfully Saved');
    }


    // update code by shahzaib start
    public function approve_post_dated_cheque_issue_list(Request $request, $array = null, $str = null)
    {
        $heads = config('global_variables.payable_receivable');
        $heads = explode(',', $heads);

        $to_accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)->orderBy('account_uid', 'ASC')->get();

        $from_accounts = AccountRegisterationModel::where('account_parent_code', config('global_variables.bank_head'))->orderBy('account_uid', 'ASC')->get();
        $title = 'Confirmed Post Dated Cheque Issue List';

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_account_from = (!isset($request->from_accounts) && empty($request->from_accounts)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->from_accounts;
        $search_account_to = (!isset($request->to_accounts) && empty($request->to_accounts)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->to_accounts;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->from;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.post_dated_cheque_issue_list.post_dated_cheque_issue_list';
        $pge_title = 'Approve Post Dated Cheque Issue List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));


        $query = DB::table('financials_post_dated_cheques')
            ->join('financials_accounts AS ac1', 'financials_post_dated_cheques.pdc_party_code', '=', 'ac1.account_uid')
            ->join('financials_accounts AS ac2', 'financials_post_dated_cheques.pdc_account_code', '=', 'ac2.account_uid')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_post_dated_cheques.pdc_created_by')
            ->select('ac1.account_name AS to', 'ac2.account_name AS from', 'financials_post_dated_cheques.pdc_amount', 'financials_post_dated_cheques.pdc_remarks', 'financials_post_dated_cheques.pdc_cheque_date', 'financials_post_dated_cheques.pdc_id', 'financials_post_dated_cheques.pdc_ip_adrs', 'financials_post_dated_cheques.pdc_brwsr_info', 'financials_users.*');

        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ac1.account_name', 'like', '%' . $search . '%')
                    ->orWhere('ac2.account_name', 'like', '%' . $search . '%')
                    ->orWhere('pdc_amount', 'like', '%' . $search . '%')
                    ->orWhere('pdc_cheque_date', 'like', '%' . $search . '%')
                    ->orWhere('pdc_remarks', 'like', '%' . $search . '%')
                    ->orWhere('pdc_id', 'like', '%' . $search . '%')
                    ->orWhere('user_designation', 'like', '%' . $search . '%')
                    ->orWhere('user_name', 'like', '%' . $search . '%')
                    ->orWhere('user_username', 'like', '%' . $search . '%');
            });
        }

        if (!empty($search_account_to)) {
            $query->where('pdc_party_code', $search_account_to);
        }

        if (!empty($search_account_from)) {
            $query->where('pdc_account_code', $search_account_from);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereDate('pdc_datetime', '>=', $start)
                ->whereDate('pdc_datetime', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('pdc_datetime', $start);
        } elseif (!empty($search_from)) {
            $query->where('pdc_datetime', $end);
        }


        if (!empty($search_by_user)) {
            $query->where('pdc_created_by', $search_by_user);
        }
        if (!empty($search_year)) {
            $query->where('pdc_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('pdc_year_id', '=', $search_year);
        }
        $datas = $query->where('pdc_type', 'ISSUED')
            ->where('pdc_status', 'CONFIRMED')
            ->orderBy('pdc_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);


//        $pdc_title = PostDatedChequeModel::orderBy('pdc_id', 'DESC')->pluck('pdc_title')->all();

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
            return view('post_dated_cheque_issue_list', compact('datas', 'title', 'search_by_user', 'search','search_year', 'to_accounts', 'from_accounts', 'search_to', 'search_from', 'search_account_to', 'search_account_from'));
        }

    }
    // update code by shahzaib end


    // update code by shahzaib start
    public function reject_post_dated_cheque_issue_list(Request $request, $array = null, $str = null)
    {
        $heads = config('global_variables.payable_receivable');
        $heads = explode(',', $heads);

        $to_accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)->orderBy('account_uid', 'ASC')->get();

        $from_accounts = AccountRegisterationModel::where('account_parent_code', config('global_variables.bank_head'))->orderBy('account_uid', 'ASC')->get();
        $title = 'Rejected Post Dated Cheque Issue List';


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_account_from = (!isset($request->from_accounts) && empty($request->from_accounts)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->from_accounts;
        $search_account_to = (!isset($request->to_accounts) && empty($request->to_accounts)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->to_accounts;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->from;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.reject_post_dated_cheque_issue_list.reject_post_dated_cheque_issue_list';
        $pge_title = 'Reject Post Dated Cheque Issue List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));


        $query = DB::table('financials_post_dated_cheques')
            ->join('financials_accounts AS ac1', 'financials_post_dated_cheques.pdc_party_code', '=', 'ac1.account_uid')
            ->join('financials_accounts AS ac2', 'financials_post_dated_cheques.pdc_account_code', '=', 'ac2.account_uid')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_post_dated_cheques.pdc_created_by')
            ->select('ac1.account_name AS to', 'ac2.account_name AS from', 'financials_post_dated_cheques.pdc_amount', 'financials_post_dated_cheques.pdc_remarks', 'financials_post_dated_cheques.pdc_reason', 'financials_post_dated_cheques.pdc_cheque_date', 'financials_post_dated_cheques.pdc_id', 'financials_post_dated_cheques.pdc_ip_adrs', 'financials_post_dated_cheques.pdc_brwsr_info', 'financials_users.*');


        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ac1.account_name', 'like', '%' . $search . '%')
                    ->orWhere('ac2.account_name', 'like', '%' . $search . '%')
                    ->orWhere('pdc_amount', 'like', '%' . $search . '%')
                    ->orWhere('pdc_cheque_date', 'like', '%' . $search . '%')
                    ->orWhere('pdc_remarks', 'like', '%' . $search . '%')
                    ->orWhere('pdc_id', 'like', '%' . $search . '%')
                    ->orWhere('user_designation', 'like', '%' . $search . '%')
                    ->orWhere('user_name', 'like', '%' . $search . '%')
                    ->orWhere('user_username', 'like', '%' . $search . '%');
            });
        }

        if (!empty($search_account_to)) {
            $query->where('pdc_party_code', $search_account_to);
        }

        if (!empty($search_account_from)) {
            $query->where('pdc_account_code', $search_account_from);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereDate('pdc_datetime', '>=', $start)
                ->whereDate('pdc_datetime', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('pdc_datetime', $start);
        } elseif (!empty($search_from)) {
            $query->where('pdc_datetime', $end);
        }


        if (!empty($search_by_user)) {
            $query->where('pdc_created_by', $search_by_user);
        }

        if (!empty($search_year)) {
            $query->where('pdc_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('pdc_year_id', '=', $search_year);
        }
        $datas = $query->where('pdc_type', 'ISSUED')
            ->where('pdc_status', 'REJECTED')
            ->orderBy('pdc_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);


//        $pdc_title = PostDatedChequeModel::orderBy('pdc_id', 'DESC')->pluck('pdc_title')->all();

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
            return view('post_dated_cheque_issue_list', compact('datas', 'title', 'search','search_year', 'to_accounts', 'from_accounts', 'search_to', 'search_from', 'search_account_to', 'search_account_from'));
        }

    }
    // update code by shahzaib end


    public function post_dated_cheque_issue_pdf_SH(Request $request, $id)
    {

        $pdc = PostDatedChequeModel::where('pdc_id', $id)->first();
        $to = AccountRegisterationModel::where('account_uid', $pdc->pdc_party_code)->first();
        $from = AccountRegisterationModel::where('account_uid', $pdc->pdc_account_code)->first();
        $nbrOfWrds = $this->myCnvrtNbr($pdc->pdc_amount);
        $invoice_nbr = $pdc->pdc_id;
        $invoice_date = $pdc->pdc_datetime;
        $invoice_remarks = $pdc->pdc_remarks;
        $type = 'pdf';
        $pge_title = 'Post Dated Cheque Issue Voucher';


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
        $pdf->loadView('voucher_view.post_dated_cheque_issue_voucher.post_dated_cheque_issue_journal_voucher_list_modal', compact('pdc', 'to', 'from', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'invoice_remarks', 'type', 'pge_title'));
        // $pdf->setOptions($options);

        return $pdf->stream('Post-Dated-Cheque-Issue-Voucher-Detail.pdf');

    }


}
