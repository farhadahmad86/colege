<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\CashTransferModel;
use App\Models\JournalVoucherModel;
use App\Models\TransactionModel;
use Auth;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CashReceiveController extends Controller
{

    // update code by shahzaib start
    public function pending_cash_receive_list(Request $request, $array = null, $str = null)
    {
        $route = "pending_cash_receive_list";
        $title = 'Pending Cash Receive List';

        $user = Auth::user();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.pending_cash_receive_list.pending_cash_receive_list';
        $pge_title = 'Pending Cash Receive List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_cash_transfer')
            ->join('financials_users as sendBy', 'sendBy.user_id', '=', 'financials_cash_transfer.ct_send_by')
            ->join('financials_users as receiveBy', 'receiveBy.user_id', '=', 'financials_cash_transfer.ct_receive_by');
//            ->join('financials_users', 'financials_users.user_id', '=', 'financials_cash_transfer.ct_send_by');


        if (!empty($request->search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ct_remarks', 'like', '%' . $search . '%')
                    ->orWhere('ct_send_datetime', 'like', '%' . $search . '%')
                    ->orWhere('ct_amount', 'like', '%' . $search . '%')
                    ->orWhere('sendBy.user_name', 'like', '%' . $search . '%')
                    ->orWhere('sendBy.user_designation', 'like', '%' . $search . '%')
                    ->orWhere('sendBy.user_name', 'like', '%' . $search . '%')
                    ->orWhere('sendBy.user_username', 'like', '%' . $search . '%')
                    ->orWhere('receiveBy.user_name', 'like', '%' . $search . '%')
                    ->orWhere('receiveBy.user_designation', 'like', '%' . $search . '%')
                    ->orWhere('receiveBy.user_name', 'like', '%' . $search . '%')
                    ->orWhere('receiveBy.user_username', 'like', '%' . $search . '%');
            });
        }

        $datas = $query->where('ct_receive_by', $user->user_id)
            ->select('financials_cash_transfer.*', 'sendBy.user_name as SndByUsrName', 'sendBy.user_id as SndById', 'receiveBy.user_name as RcdByUsrName', 'receiveBy.user_id as RcdById')
            ->where('ct_status', 'PENDING')
            ->orderBy('ct_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];

            $pdf = SnappyPdf::loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('cash_receive_list', compact('datas', 'route', 'title', 'search'));
        }

    }

    // update code by shahzaib end


    public function approve_cash_receive(Request $request)
    {
        $this->validate($request, [
            'approve' => ['required', 'numeric'],
        ]);

        DB::beginTransaction();

        $cash = CashTransferModel::where('ct_id', $request->approve)->first();
        $cash->ct_status = 'RECEIVED';
        $cash->ct_receive_datetime = Carbon::now()->toDateTimeString();

        $send_by = $cash->ct_send_by;
        $receive_by = $cash->ct_receive_by;
        $amount = $cash->ct_amount;

        if ($cash->save()) {

            $check_role = new UserController();
            $get_cash_account = new AccountRegisterationsController();
            $get_day_end = new DayEndController();
            $day_end = $get_day_end->day_end();
            $p_invoice = new PurchaseInvoiceController();
            $cash_receive_controller = new \App\Http\Controllers\Teller\CashReceiveController();

            $send_by_role = $check_role->get_user($send_by);

            if ($send_by_role->user_role_id == config('global_variables.teller_account_id')) {

                $send_by_account = $get_cash_account->get_account($send_by);

                $send_by_cash_account = $send_by_account->user_teller_cash_account_uid;
                $send_by_cash_account_name = $this->get_account_name($send_by_cash_account);

            } else {

                $send_by_cash_account = config('global_variables.cash_in_hand');
                $send_by_cash_account_name = 'CASH IN HAND';

            }

            $receive_by_role = $check_role->get_user($receive_by);

            if ($receive_by_role->user_role_id == config('global_variables.teller_account_id')) {

                $receive_by_account = $get_cash_account->get_account($receive_by);

                $receive_by_cash_account = $receive_by_account->user_teller_cash_account_uid;
                $receive_by_cash_account_name = $this->get_account_name($receive_by_cash_account);

            } else {

                $receive_by_cash_account = config('global_variables.cash_in_hand');
                $receive_by_cash_account_name = 'CASH IN HAND';

            }

            $detail_remarks = $send_by_cash_account_name . ' to ' . $receive_by_cash_account_name . ' @' . $amount;

            //////////////////JV VOUCHER /////////////////////////////

            $notes = 'CASH_TRANSFER';
            $voucher_code = config('global_variables.CASH_TRANSFER_CODE');
            $transaction_type = config('global_variables.CASH_TRANSFER');

            $jv = new JournalVoucherModel();

            $jv = $cash_receive_controller->assign_journal_voucher_values($request, $jv, $amount, $voucher_code . $request->approve, $day_end);

            if ($jv->save()) {
                $jv_id = $jv->jv_id;

                $items = [];

                $item = $cash_receive_controller->assign_journal_voucher_items_values($receive_by_cash_account, $receive_by_cash_account_name, $send_by_cash_account, $send_by_cash_account_name, $amount, $voucher_code . $request->approve, $items, $jv_id);

                if (DB::table('financials_journal_voucher_items')->insert($item)) {

                    $transaction = new TransactionModel();

//                    $transaction = $p_invoice->AssignTransactionValues($request, $transaction, $receive_by_cash_account, $amount, $send_by_cash_account, 'CASH TRANSFER', 12, $jv_id);

                    $transaction = $this->AssignTransactionsValues($transaction, $receive_by_cash_account, $amount, $send_by_cash_account, $notes, $transaction_type, $jv_id);

                    if ($transaction->save()) {

                        $transaction_id = $transaction->trans_id;

                        $balances = [];
                        $balance = $cash_receive_controller->assign_journal_voucher_balances_values($request, $balances, $transaction_id, $receive_by_cash_account, $send_by_cash_account, $amount, 'CASH TRANSFER', $voucher_code . $request->approve, $detail_remarks, 'JV-' . $jv_id, $day_end);

                        if (DB::table('financials_balances')->insert($balance)) {
                            $jv->jv_detail_remarks = $detail_remarks;
                            $jv->save();

                            $user = Auth::User();
                            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $voucher_code . $request->approve . ' And JV: ' . $jv_id);

                            DB::commit();
                            return redirect('pending_cash_receive_list')->with('success', 'Successfully Saved');
                        } else {
                            DB::rollBack();
                            return redirect('pending_cash_receive_list')->with('fail', 'Failed');
                        }
                    } else {
                        DB::rollBack();
                        return redirect('pending_cash_receive_list')->with('fail', 'Failed');
                    }

                } else {
                    DB::rollBack();
                    return redirect('pending_cash_receive_list')->with('fail', 'Failed');
                }
            }

            //////////////////End JV VOUCHER ////////////////////////////////
        }

        return redirect('pending_cash_receive_list')->with('success', 'Successfully Saved');
    }

    public function reject_cash_receive(Request $request)
    {
        $this->validate($request, [
            'reject' => ['required', 'numeric'],
            'reason' => ['required', 'string'],
        ]);

        $cash = CashTransferModel::where('ct_id', $request->reject)->first();

        $cash->ct_status = 'REJECTED';
        $cash->ct_reason = $request->reason;
        $cash->ct_receive_datetime = Carbon::now()->toDateTimeString();

        $cash->save();

        return redirect('pending_cash_receive_list')->with('success', 'Successfully Saved');
    }


    // update code by shahzaib start
    public function approve_cash_receive_list(Request $request, $array = null, $str = null)
    {
        $route = "approve_cash_receive_list";
        $title = 'Approve Cash Receive List';

        $user = Auth::user();

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.pending_cash_receive_list.pending_cash_receive_list';
        $pge_title = 'Approve Cash Receive List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_cash_transfer')
            ->join('financials_users as sendBy', 'sendBy.user_id', '=', 'financials_cash_transfer.ct_send_by')
            ->join('financials_users as receiveBy', 'receiveBy.user_id', '=', 'financials_cash_transfer.ct_receive_by');
//            ->join('financials_users', 'financials_users.user_id', '=', 'financials_cash_transfer.ct_send_by');

        if (!empty($request->search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ct_remarks', 'like', '%' . $search . '%')
                    ->orWhere('ct_send_datetime', 'like', '%' . $search . '%')
                    ->orWhere('ct_amount', 'like', '%' . $search . '%')
                    ->orWhere('sendBy.user_name', 'like', '%' . $search . '%')
                    ->orWhere('sendBy.user_designation', 'like', '%' . $search . '%')
                    ->orWhere('sendBy.user_name', 'like', '%' . $search . '%')
                    ->orWhere('sendBy.user_username', 'like', '%' . $search . '%')
                    ->orWhere('receiveBy.user_name', 'like', '%' . $search . '%')
                    ->orWhere('receiveBy.user_designation', 'like', '%' . $search . '%')
                    ->orWhere('receiveBy.user_name', 'like', '%' . $search . '%')
                    ->orWhere('receiveBy.user_username', 'like', '%' . $search . '%');
            });
        }

        $datas = $query->select('financials_cash_transfer.*', 'sendBy.user_name as SndByUsrName', 'sendBy.user_id as SndById', 'receiveBy.user_name as RcdByUsrName', 'receiveBy.user_id as RcdById')
            ->where('ct_receive_by', $user->user_id)
            ->where('ct_status', 'RECEIVED')
            ->orderBy('ct_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];

            $pdf = SnappyPdf::loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('cash_receive_list', compact('datas', 'route', 'title', 'search'));
        }

    }
    // update code by shahzaib end


    // update code by shahzaib start
    public function reject_cash_receive_list(Request $request, $array = null, $str = null)
    {
        $route = "reject_cash_receive_list";
        $title = 'Reject Cash Receive List';

        $user = Auth::user();

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.reject_cash_receive_list.reject_cash_receive_list';
        $pge_title = 'Reject Cash Receive List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_cash_transfer')
            ->join('financials_users as sendBy', 'sendBy.user_id', '=', 'financials_cash_transfer.ct_send_by')
            ->join('financials_users as receiveBy', 'receiveBy.user_id', '=', 'financials_cash_transfer.ct_receive_by');
//            ->join('financials_users', 'financials_users.user_id', '=', 'financials_cash_transfer.ct_send_by');

        if (!empty($request->search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ct_remarks', 'like', '%' . $search . '%')
                    ->orWhere('ct_send_datetime', 'like', '%' . $search . '%')
                    ->orWhere('ct_amount', 'like', '%' . $search . '%')
                    ->orWhere('sendBy.user_name', 'like', '%' . $search . '%')
                    ->orWhere('sendBy.user_designation', 'like', '%' . $search . '%')
                    ->orWhere('sendBy.user_name', 'like', '%' . $search . '%')
                    ->orWhere('sendBy.user_username', 'like', '%' . $search . '%')
                    ->orWhere('receiveBy.user_name', 'like', '%' . $search . '%')
                    ->orWhere('receiveBy.user_designation', 'like', '%' . $search . '%')
                    ->orWhere('receiveBy.user_name', 'like', '%' . $search . '%')
                    ->orWhere('receiveBy.user_username', 'like', '%' . $search . '%');
            });
        }

        $datas = $query->select('financials_cash_transfer.*', 'sendBy.user_name as SndByUsrName', 'sendBy.user_id as SndById', 'receiveBy.user_name as RcdByUsrName', 'receiveBy.user_id as RcdById')
            ->where('ct_receive_by', $user->user_id)
            ->where('ct_status', 'REJECTED')
            ->orderBy('ct_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];

            $pdf = SnappyPdf::loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('cash_receive_list', compact('datas', 'route', 'title', 'search'));
        }


    }
    // update code by shahzaib end 

}
