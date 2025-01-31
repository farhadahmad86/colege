<?php

namespace App\Http\Controllers\Teller;

use App\Http\Controllers\AccountRegisterationsController;
use App\Http\Controllers\BalancesController;
use App\Http\Controllers\DayEndController;
use App\Http\Controllers\PurchaseInvoiceController;
use App\Http\Controllers\UserController;
use App\Models\CashTransferModel;
use App\Models\JournalVoucherModel;
use App\Models\TransactionModel;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CashReceiveController extends Controller
{
    public function pending_cash_receive_list(Request $request)
    {
        $user = Auth::user();

        $search = $request->search;
        if (isset($request->search) && !empty($request->search)) {


            $cash_receives = DB::table('financials_cash_transfer')
                ->join('financials_users', 'financials_users.user_id', '=', 'financials_cash_transfer.ct_send_by')
                ->where('ct_receive_by', $user->user_id)
                ->where('ct_status', 'PENDING')
                ->where(function ($query) use ($search) {
                    $query->orWhere('ct_remarks', 'like', '%' . $search . '%')
                        ->orWhere('ct_send_datetime', 'like', '%' . $search . '%')
                        ->orWhere('ct_amount', 'like', '%' . $search . '%')
                        ->orWhere('user_name', 'like', '%' . $search . '%');
                })
                ->orderBy('ct_id', 'DESC')
                ->paginate(1000000);

        } else {

            $cash_receives = DB::table('financials_cash_transfer')
                ->join('financials_users', 'financials_users.user_id', '=', 'financials_cash_transfer.ct_send_by')
//                ->where('user_role_id', config('global_variables.teller_account_id'))
                ->where('ct_receive_by', $user->user_id)
                ->where('ct_status', 'PENDING')
                ->orderBy('ct_id', 'DESC')
                ->paginate(15);

        }

        return view('teller/pending_cash_receive', compact('cash_receives', 'search'));
    }


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

            $send_by_role = $check_role->get_user($send_by);

            if ($send_by_role->user_role_id == config('global_variables.teller_account_id')) {

                $send_by_account = $get_cash_account->get_account($send_by);

                $send_by_cash_account = $send_by_account->account_uid;
                $send_by_cash_account_name = $send_by_account->account_name;

            } else {

                $send_by_cash_account = config('global_variables.cash_in_hand');
                $send_by_cash_account_name = 'CASH IN HAND';

            }

            $receive_by_role = $check_role->get_user($receive_by);

            if ($receive_by_role->user_role_id == config('global_variables.teller_account_id')) {

                $receive_by_account = $get_cash_account->get_account($receive_by);

                $receive_by_cash_account = $receive_by_account->account_uid;
                $receive_by_cash_account_name = $receive_by_account->account_name;

            } else {

                $receive_by_cash_account = config('global_variables.cash_in_hand');
                $receive_by_cash_account_name = 'CASH IN HAND';

            }

            $detail_remarks = $send_by_cash_account_name . ' to ' . $receive_by_cash_account_name . ' @' . $amount;

            //////////////////JV VOUCHER /////////////////////////////

            $jv = new JournalVoucherModel();

            $jv = $this->assign_journal_voucher_values($request, $jv, $amount, 'CT-' . $request->approve, $day_end);

            if ($jv->save()) {
                $jv_id = $jv->jv_id;

                $items = [];

                $item = $this->assign_journal_voucher_items_values($receive_by_cash_account, $receive_by_cash_account_name, $send_by_cash_account, $send_by_cash_account_name, $amount, 'CT-' . $request->approve, $items, $jv_id);

                if (DB::table('financials_journal_voucher_items')->insert($item)) {

                    $transaction = new TransactionModel();

//                    $transaction = $p_invoice->AssignTransactionValues($request, $transaction, $receive_by_cash_account, $amount, $send_by_cash_account, 'CASH TRANSFER', 12, $jv_id);

                    $transaction = $this->AssignTransactionsValues($transaction, $receive_by_cash_account, $amount, $send_by_cash_account, 'CASH_TRANSFER', 12, $jv_id);

                    if ($transaction->save()) {

                        $transaction_id = $transaction->trans_id;

                        $balances = [];
                        $balance = $this->assign_journal_voucher_balances_values($request, $balances, $transaction_id, $receive_by_cash_account, $send_by_cash_account, $amount, 'CASH TRANSFER', 'CT-' . $request->approve, $detail_remarks, 'JV-' . $jv_id, $day_end);

                        if (DB::table('financials_balances')->insert($balance)) {
                            $jv->jv_detail_remarks = $detail_remarks;
                            $jv->save();
                            DB::commit();
                            return redirect('teller/pending_cash_receive_list')->with('success', 'Successfully Saved');
                        } else {
                            DB::rollBack();
                            return redirect('teller/pending_cash_receive_list')->with('fail', 'Failed');
                        }
                    } else {
                        DB::rollBack();
                        return redirect('teller/pending_cash_receive_list')->with('fail', 'Failed');
                    }

                } else {
                    DB::rollBack();
                    return redirect('teller/pending_cash_receive_list')->with('fail', 'Failed');
                }
            }

            //////////////////End JV VOUCHER ////////////////////////////////
        }

        return redirect('teller/pending_cash_receive_list')->with('success', 'Successfully Saved');
    }

    public function assign_journal_voucher_values($request, $jv, $amount, $remarks, $day_end)
    {
        $user = Auth::User();

        $jv->jv_remarks = ucfirst($remarks);
        $jv->jv_total_dr = $amount;
        $jv->jv_total_cr = $amount;
        $jv->jv_created_datetime = Carbon::now()->toDateTimeString();
        $jv->jv_day_end_id = $day_end->de_id;
        $jv->jv_day_end_date = $day_end->de_datetime;
        $jv->jv_createdby = $user->user_id;

        return $jv;
    }

    public function assign_journal_voucher_items_values($receive_by, $receive_by_name, $send_by, $send_by_name, $amount, $remarks, $item, $jv_id)
    {
        $item[] = ['jvi_journal_voucher_id' => $jv_id, 'jvi_account_id' => $receive_by, 'jvi_account_name' => $receive_by_name, 'jvi_amount' => $amount, 'jvi_type' => 'Dr', 'jvi_remarks' => ucfirst($remarks)];

        $item[] = ['jvi_journal_voucher_id' => $jv_id, 'jvi_account_id' => $send_by, 'jvi_account_name' => $send_by_name, 'jvi_amount' => $amount, 'jvi_type' => 'Cr', 'jvi_remarks' => ucfirst($remarks)];

        return $item;
    }

    public function assign_journal_voucher_balances_values($request, $data, $transaction_id, $dr, $cr, $amount, $type, $remarks, $detail_remarks, $jv_id, $day_end)
    {
        $user= Auth::user();

        $calculate_balance = new BalancesController();

        $previous_balance = $calculate_balance->calculate_balance($dr);

        $total_balance = $previous_balance + $amount;


        $data[] = ['bal_account_id' => $dr, 'bal_transaction_type' => $type, 'bal_remarks' => ucfirst($remarks), 'bal_dr' => $amount, 'bal_cr' => 0, 'bal_total' => $total_balance, 'bal_transaction_id' => $transaction_id, 'bal_datetime' => Carbon::now()->toDateTimeString(), 'bal_day_end_id' => $day_end->de_id, 'bal_day_end_date' => $day_end->de_datetime, 'bal_detail_remarks' => $detail_remarks, 'bal_voucher_number' => $jv_id, 'bal_user_id' => $user->user_id];


        $previous_balance = $calculate_balance->calculate_balance($cr);

        $total_balance = $previous_balance - $amount;

        $data[] = ['bal_account_id' => $cr, 'bal_transaction_type' => $type, 'bal_remarks' => ucfirst($remarks), 'bal_dr' => 0, 'bal_cr' => $amount, 'bal_total' => $total_balance, 'bal_transaction_id' => $transaction_id, 'bal_datetime' => Carbon::now()->toDateTimeString(), 'bal_day_end_id' => $day_end->de_id, 'bal_day_end_date' => $day_end->de_datetime, 'bal_detail_remarks' => $detail_remarks, 'bal_voucher_number' => $jv_id, 'bal_user_id' => $user->user_id];

        return $data;
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

        $cash->save();

        return redirect('teller/pending_cash_receive_list')->with('success', 'Successfully Saved');
    }

    public function approve_cash_receive_list(Request $request)
    {
        $route = "teller/approve_cash_receive_list";
        $title = 'Approve Cash Receive List';
        $user = Auth::user();

        $search = $request->search;
        if (isset($request->search) && !empty($request->search)) {


            $cash_receives = DB::table('financials_cash_transfer')
                ->join('financials_users', 'financials_users.user_id', '=', 'financials_cash_transfer.ct_send_by')
                ->where('ct_receive_by', $user->user_id)
                ->where('ct_status', 'RECEIVED')
                ->where(function ($query) use ($search) {
                    $query->orWhere('ct_remarks', 'like', '%' . $search . '%')
                        ->orWhere('ct_send_datetime', 'like', '%' . $search . '%')
                        ->orWhere('ct_amount', 'like', '%' . $search . '%')
                        ->orWhere('user_name', 'like', '%' . $search . '%');
                })
                ->orderBy('ct_id', 'DESC')
                ->paginate(1000000);

        } else {

            $cash_receives = DB::table('financials_cash_transfer')
                ->join('financials_users', 'financials_users.user_id', '=', 'financials_cash_transfer.ct_send_by')
//                ->where('user_role_id', config('global_variables.teller_account_id'))
                ->where('ct_receive_by', $user->user_id)
                ->where('ct_status', 'RECEIVED')
                ->orderBy('ct_id', 'DESC')
                ->paginate(15);

        }

        return view('teller/cash_receive_list', compact('cash_receives', 'search','route','title'));
    }

    public function reject_cash_receive_list(Request $request)
    {
        $route = "teller/reject_cash_receive_list";
        $title = 'Reject Cash Receive List';
        $user = Auth::user();

        $search = $request->search;
        if (isset($request->search) && !empty($request->search)) {


            $cash_receives = DB::table('financials_cash_transfer')
                ->join('financials_users', 'financials_users.user_id', '=', 'financials_cash_transfer.ct_send_by')
                ->where('ct_receive_by', $user->user_id)
                ->where('ct_status', 'REJECTED')
                ->where(function ($query) use ($search) {
                    $query->orWhere('ct_reason', 'like', '%' . $search . '%')
                        ->orWhere('ct_send_datetime', 'like', '%' . $search . '%')
                        ->orWhere('ct_amount', 'like', '%' . $search . '%')
                        ->orWhere('user_name', 'like', '%' . $search . '%');
                })
                ->orderBy('ct_id', 'DESC')
                ->paginate(1000000);

        } else {

            $cash_receives = DB::table('financials_cash_transfer')
                ->join('financials_users', 'financials_users.user_id', '=', 'financials_cash_transfer.ct_send_by')
//                ->where('user_role_id', config('global_variables.teller_account_id'))
                ->where('ct_receive_by', $user->user_id)
                ->where('ct_status', 'REJECTED')
                ->orderBy('ct_id', 'DESC')
                ->paginate(15);

        }

        return view('teller/cash_receive_list', compact('cash_receives', 'search','route','title'));
    }
}
