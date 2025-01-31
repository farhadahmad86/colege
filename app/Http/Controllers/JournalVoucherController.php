<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\BankPaymentVoucherItemsModel;
use App\Models\BankPaymentVoucherModel;
use App\Models\CashPaymentVoucherModel;
use App\Models\ExpensePaymentVoucherModel;
use App\Models\JournalVoucherItemsModel;
use App\Models\JournalVoucherModel;
use App\Models\PostingReferenceModel;
use App\Models\PurchaseInvoiceItemsModel;
use App\Models\SystemConfigModel;
use App\Models\TransactionModel;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class JournalVoucherController extends Controller
{
    public function journal_voucher()
    {
//        $accounts = $this->get_account_query('journal_voucher')[0];
        $type = 'journal_voucher';
        $array_index=0;
        $title = '';
        $route='account_registration';

        return view('journal_voucher', compact( 'title','type','array_index','route'));
    }

    public function journal_voucher_bank()
    {

//        $accounts = $this->get_fourth_level_account(config('global_variables.bank_head'), 0, 0);
        $type = 'bank_voucher';
        $array_index=1;
        $title = 'Bank';
        $route='bank_account_registration';
        return view('journal_voucher', compact( 'title','type','array_index','route'));
    }

    public function journal_voucher_reference()
    {
        $heads = explode(',', config('global_variables.payable_receivable'));

        $accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)->orderBy('account_uid', 'ASC')->get();

        $type = 'journal_voucher';
        $title = 'Reference';
        $array_index=0;


        return view('journal_voucher', compact('accounts', 'title','type','array_index'));
    }

    public function submit_journal_voucher(Request $request)
    {
        $user = Auth::user();
        $this->journal_voucher_validation($request);

        $flag = false;

//        $accountsval = $request->accountsval;
//        $accountsval = stripslashes($accountsval);
        $values_array = json_decode($request->accountsval, true);


        $notes = 'JOURNAL_VOUCHER';
        $voucher_code = config('global_variables.JOURNAL_VOUCHER_CODE');
        $transaction_type = config('global_variables.JV');

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
            return redirect('journal_voucher')->with('fail', 'Failed');
        }

        DB::beginTransaction();

        $jv = new JournalVoucherModel();
        $jv_v_no = JournalVoucherModel::where('jv_clg_id', $user->user_clg_id)->max('jv_v_no');


        $jv = $this->assign_journal_voucher_values($request, $jv, $jv_v_no + 1);


        // system config set increment default id according to user giving start coding
        $sstm_cnfg_clm = 'sc_journal_voucher_number';
        $sstm_cnfg_bp_id_chk = SystemConfigModel::where('sc_clg_id', '=', $user->user_clg_id)->where($sstm_cnfg_clm, '!=', '0')->first();
        $chk_bnk_pymnt = JournalVoucherModel::where('jv_clg_id', '=', $user->user_clg_id)->get();
        if ($chk_bnk_pymnt->isEmpty()):
            if (isset($sstm_cnfg_bp_id_chk) && !empty($sstm_cnfg_bp_id_chk)):
                $jv->jv_id = $sstm_cnfg_bp_id_chk->$sstm_cnfg_clm;
            endif;
        endif;
        // system config set increment default id according to user giving end coding


        if ($jv->save()) {
            $jv_id = $jv->jv_id;
            $jv_voucher_no = $jv->jv_v_no;
            $items = [];
            $detail_remarks = '';

            $item = $this->assign_journal_voucher_items_values($values_array, $items, $jv_id, $jv_voucher_no);

            foreach ($item as $value) {

                $jvi_amount = (float)$value['jvi_amount'];

                $detail_remarks .= $value['jvi_account_name'] . ', ' . $value['jvi_type'] . '@' . number_format($jvi_amount, 2) .config('global_variables.Line_Break');
            }

            if (DB::table('financials_journal_voucher_items')->insert($item)) {

                foreach ($values_array as $key) {

                    $transaction = new TransactionModel();

                    if ($key[3] == 'Dr') {

                        $transaction = $this->AssignTransactionsValues($transaction, $key[0], $key[2], 0, $notes, $transaction_type, $jv_id);

                        if ($transaction->save()) {

                            $transaction_id = $transaction->trans_id;
                            $branch_id = $this->get_branch_id($key[0]);
                            $balances = new BalancesModel();

                            $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key[0], $key[2], $key[3], $key[4], $notes, $detail_remarks, $voucher_code .
                                $jv_id,$key[5], $voucher_code .$jv_voucher_no,$this->getYearEndId(),$branch_id);

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
                                $jv_id,$key[5],$voucher_code .$jv_voucher_no, $this->getYearEndId(),$branch_id);

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

                    $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Journal Voucher With Id: ' . $jv->jv_id);

                    $jv->jv_detail_remarks = $detail_remarks;
                    $jv->save();
                    DB::commit();
                    return redirect()->back()->with(['jv_id' => $jv_id, 'success' => 'Successfully Saved']);
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

    public function journal_voucher_validation($request)
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

    public function assign_journal_voucher_values($request, $jv, $jv_v_no)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $jv->jv_session = $request->session;
        $jv->jv_business_name = $request->business_name;
        $jv->jv_remarks = ucfirst($request->remarks);
        $jv->jv_total_dr = $request->total_debit;
        $jv->jv_total_cr = $request->total_credit;
        $jv->jv_created_datetime = Carbon::now()->toDateTimeString();
        $jv->jv_day_end_id = $day_end->de_id;
        $jv->jv_day_end_date = $day_end->de_datetime;
        $jv->jv_createdby = $user->user_id;
        $jv->jv_v_no = $jv_v_no;
        $jv->jv_clg_id = $user->user_clg_id;
        $jv->jv_year_id = $this->getYearEndId();

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

    public function assign_journal_voucher_items_values($accountsval, $data, $jv_id, $jv_voucher_no)
    {
//        $accountsval = $request->accountsval;
////        $accountsval = stripslashes($accountsval);
//        $accountsval = json_decode($accountsval, true);

        // coding from shahzaib start
        $prfx = 'jvi';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';
        // coding from shahzaib end


        foreach ($accountsval as $key) {
            $data[] = ['jvi_journal_voucher_id' => $jv_id,'jvi_v_no' => $jv_voucher_no, 'jvi_account_id' => $key[0], 'jvi_account_name' => $key[1], 'jvi_amount' => $key[2], 'jvi_type' => $key[3],'jvi_pr_id'
            => $key[5], 'jvi_remarks' => $key[4] == 'N/A' ? $key[4] : ucfirst($key[4]), $brwsr_col => $brwsr_rslt, $ip_col => $ip_rslt, $updt_date_col => Carbon::now()->toDateTimeString(),'jvi_year_id' => $this->getYearEndId()];
        }

        return $data;
    }

    // update code by shahzaib start
    public function journal_voucher_list(Request $request, $array = null, $str = null)
    {

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.journal_voucher_list.journal_voucher_list';
        $pge_title = 'Journal Voucher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from,$search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $user = Auth::user();
//        $query = JournalVoucherModel::query();
        $query = DB::table('financials_journal_voucher')
            //->leftJoin('finead_projects', 'finead_projects.proj_id', 'financials_journal_voucher.jv_project_id')
            //->leftJoin('finead_order_list', 'finead_order_list.ol_id', 'financials_journal_voucher.jv_order_list_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_journal_voucher.jv_createdby')
        ->where('jv_clg_id',$user->user_clg_id);
        $ttl_dr = $query->sum('jv_total_dr');
        $ttl_cr = $query->sum('jv_total_cr');

        if (!empty($request->search)) {
            $query->where('jv_total_dr', 'like', '%' . $search . '%')
                ->orWhere('jv_total_cr', 'like', '%' . $search . '%')
                ->orWhere('jv_remarks', 'like', '%' . $search . '%')
                ->orWhere('jv_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('jv_createdby', $search_by_user);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('jv_day_end_date', [$start, $end]);
            $query->whereDate('jv_day_end_date', '>=', $start)
                ->whereDate('jv_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('jv_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('jv_day_end_date', $end);
        }
        if (!empty($search_year)) {
            $query->where('jv_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('jv_year_id', '=', $search_year);
        }
        $datas = $query->orderBy('jv_id', 'DESC')
            ->paginate($pagination_number);

//        if (isset($request->search) && !empty($request->search)) {
//
//            $search = $request->search;
//
//            $vouchers = JournalVoucherModel::
//            orWhere('jv_total_dr', 'like', '%' . $search . '%')
//                ->orWhere('jv_total_cr', 'like', '%' . $search . '%')
//                ->orWhere('jv_remarks', 'like', '%' . $search . '%')
//                ->orWhere('jv_id', 'like', '%' . $search . '%')
//                ->orderBy('jv_id', 'DESC')
//                ->paginate(1000000);
//
//        } else {
//
//            $vouchers = JournalVoucherModel::orderBy('jv_id', 'DESC')
//                ->paginate(10);
//        }

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
            return view('journal_voucher_list', compact('datas', 'search','search_year', 'search_to', 'search_from', 'ttl_dr', 'ttl_cr', 'search_by_user'));
        }


    }

    // update code by shahzaib end


    public function journal_voucher_items_view_details(Request $request)
    {
        $items = JournalVoucherItemsModel::where('jvi_journal_voucher_id', $request->id)->orderby('jvi_account_name', 'ASC')->get();
        return response()->json($items);
    }

    public function journal_voucher_items_view_details_SH(Request $request, $id)
    {

        $jrnl = JournalVoucherModel::with('user')->where('jv_id', $id)->first();
        $items = JournalVoucherItemsModel::Join('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_journal_voucher_items.jvi_pr_id')->where('jvi_journal_voucher_id', $id)->get();
        $nbrOfWrds = $this->myCnvrtNbr($jrnl->jv_total_dr);
        $invoice_nbr = $jrnl->jv_id;
//        $invoice_date = $jrnl->jv_created_datetime;
        $invoice_date = $jrnl->jv_day_end_date;
        $invoice_remarks = $jrnl->jv_remarks;
        $type = 'grid';
        $pge_title = 'Journal Voucher';

        return view('voucher_view.journal_voucher.journal_voucher_list_modal', compact('items', 'jrnl', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title', 'invoice_remarks'));

    }

    public function journal_voucher_items_view_details_pdf_SH(Request $request, $id)
    {

        $jrnl = JournalVoucherModel::with('user')->where('jv_id', $id)->first();
        $items = JournalVoucherItemsModel::Join('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_journal_voucher_items.jvi_pr_id')->where('jvi_journal_voucher_id', $id)->get();
        $nbrOfWrds = $this->myCnvrtNbr($jrnl->jv_total_dr);
        $invoice_nbr = $jrnl->jv_id;
//        $invoice_date = $jrnl->jv_created_datetime;
        $invoice_date = $jrnl->jv_day_end_date;
        $invoice_remarks = $jrnl->jv_remarks;
        $type = 'pdf';
        $pge_title = 'Journal Voucher';


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

        $pdf->loadView('voucher_view.journal_voucher.journal_voucher_list_modal', compact('items', 'jrnl', 'nbrOfWrds', 'type', 'invoice_nbr', 'invoice_date','pge_title', 'invoice_remarks'));
        // $pdf->setOptions($options);


        return $pdf->stream('Journal-Voucher-Detail.pdf');
    }


}
