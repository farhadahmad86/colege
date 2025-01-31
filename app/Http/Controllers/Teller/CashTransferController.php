<?php

namespace App\Http\Controllers\Teller;

use App\Http\Controllers\AccountRegisterationsController;
use App\Http\Controllers\BalancesController;
use App\Http\Controllers\DayEndController;
use App\Http\Controllers\PurchaseInvoiceController;
use App\Http\Controllers\UserController;
use App\Models\AccountRegisterationModel;
use App\Models\CashPaymentVoucherItemsModel;
use App\Models\CashPaymentVoucherModel;
use App\Models\CashTransferModel;
use App\Models\JournalVoucherItemsModel;
use App\Models\JournalVoucherModel;
use App\Models\TransactionModel;
use App\User;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CashTransferController extends Controller
{
    public function cash_transfer()
    {
        $user = Auth::user();

        $tellers = User::where('user_id', '!=', $user->user_id)->get();

        return view('teller/cash_transfer', compact('tellers'));
    }

    public function submit_cash_transfer(Request $request)
    {
        $cash_transfer_controller = new \App\Http\Controllers\CashTransferController();

        $cash_transfer_controller->cash_transfer_validation($request);

        $cash_transfer = new CashTransferModel();

        $cash_transfer = $cash_transfer_controller->AssignCashTransferValues($request, $cash_transfer);

        $cash_transfer->save();

        return redirect('teller/cash_transfer')->with('success', 'Successfully Saved');
    }

    public function pending_cash_transfer_list(Request $request)
    {
        $route = "teller/pending_cash_transfer_list";
        $title = 'Pending Cash Transfer List';

        $user = Auth::user();

        $search = $request->search;
        if (isset($request->search) && !empty($request->search)) {


            $cash_transfers = DB::table('financials_cash_transfer')
                ->join('financials_users', 'financials_users.user_id', '=', 'financials_cash_transfer.ct_receive_by')
                ->where('ct_send_by', $user->user_id)
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

            $cash_transfers = DB::table('financials_cash_transfer')
                ->join('financials_users', 'financials_users.user_id', '=', 'financials_cash_transfer.ct_receive_by')
//                ->where('user_role_id', config('global_variables.teller_account_id'))
                ->where('ct_send_by', $user->user_id)
                ->where('ct_status', 'PENDING')
                ->orderBy('ct_id', 'DESC')
                ->paginate(15);

        }

        return view('teller/cash_transfer_list', compact('cash_transfers', 'search','title','route'));
    }


    public function approve_cash_transfer_list(Request $request)
    {
        $route = "teller/approve_cash_transfer_list";
        $title = 'Approve Cash Transfer List';

        $user = Auth::user();

        $search = $request->search;
        if (isset($request->search) && !empty($request->search)) {


            $cash_transfers = DB::table('financials_cash_transfer')
                ->join('financials_users', 'financials_users.user_id', '=', 'financials_cash_transfer.ct_receive_by')
                ->where('ct_send_by', $user->user_id)
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

            $cash_transfers = DB::table('financials_cash_transfer')
                ->join('financials_users', 'financials_users.user_id', '=', 'financials_cash_transfer.ct_receive_by')
//                ->where('user_role_id', config('global_variables.teller_account_id'))
                ->where('ct_send_by', $user->user_id)
                ->where('ct_status', 'RECEIVED')
                ->orderBy('ct_id', 'DESC')
                ->paginate(15);

        }

        return view('teller/cash_transfer_list', compact('cash_transfers', 'search','title','route'));
    }


    public function reject_cash_transfer_list(Request $request)
    {
        $route = "teller/reject_cash_transfer_list";
        $title = 'Reject Cash Transfer List';

        $user = Auth::user();

        $search = $request->search;
        if (isset($request->search) && !empty($request->search)) {


            $cash_transfers = DB::table('financials_cash_transfer')
                ->join('financials_users', 'financials_users.user_id', '=', 'financials_cash_transfer.ct_receive_by')
                ->where('ct_send_by', $user->user_id)
                ->where('ct_status', 'REJECTED')
                ->where(function ($query) use ($search) {
                    $query->orWhere('ct_remarks', 'like', '%' . $search . '%')
                        ->orWhere('ct_send_datetime', 'like', '%' . $search . '%')
                        ->orWhere('ct_amount', 'like', '%' . $search . '%')
                        ->orWhere('user_name', 'like', '%' . $search . '%');
                })
                ->orderBy('ct_id', 'DESC')
                ->paginate(1000000);

        } else {

            $cash_transfers = DB::table('financials_cash_transfer')
                ->join('financials_users', 'financials_users.user_id', '=', 'financials_cash_transfer.ct_receive_by')
//                ->where('user_role_id', config('global_variables.teller_account_id'))
                ->where('ct_send_by', $user->user_id)
                ->where('ct_status', 'REJECTED')
                ->orderBy('ct_id', 'DESC')
                ->paginate(15);

        }

        return view('teller/cash_transfer_list', compact('cash_transfers', 'search','title','route'));
    }

}
