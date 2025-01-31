<?php

namespace App\Http\Controllers\ExcelForm\CashTransferForm;

use App\Http\Controllers\DayEndController;
use App\Models\CashTransferModel;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CashTransferController extends Controller
{
    public function excel_form_cash_transfer($request)
    {
        DB::beginTransaction();
        $rollBack = false;

        $cash_transfer = new CashTransferModel();
        $user = Auth::User();
        $cash_transfer = $this->ExcelAssignCashTransferValues($request, $cash_transfer);

        if ($cash_transfer->save()) {

            $trnsfer_to = User::where('user_id', $cash_transfer->ct_receive_by)->first();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Cash Transfer To User_id: ' . $trnsfer_to->user_id . ' And Name: ' . $trnsfer_to->user_name . ' In Pending State');


            if (!$cash_transfer->save()) {
                $rollBack = true;
                DB::rollBack();
                return true;
            }

        } else {
            $rollBack = true;
            DB::rollBack();
            return true;
        }

    }

    public function simple_form_cash_transfer($request)
    {
        $this->cash_transfer_validation($request);

        $cash_transfer = new CashTransferModel();

        $cash_transfer = $this->AssignCashTransferValues($request, $cash_transfer);

        $cash_transfer->save();

        $user = Auth::User();

        $trnsfer_to = User::where('user_id', $cash_transfer->ct_receive_by)->first();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Cash Transfer To User_id: ' . $trnsfer_to->user_id . ' And Name: ' . $trnsfer_to->user_name . ' In Pending State');

        return redirect('cash_transfer')->with('success', 'Successfully Saved');

    }

    public function cash_transfer_validation($request)
    {
        return $this->validate($request, [
            'cash_transfer_to' => ['required', 'numeric'],
            'amount' => ['required', 'numeric'],
            'remarks' => ['nullable', 'string'],
        ]);

    }

    public function excel_cash_transfer_validation($request)
    {
        return $this->validate($request, [
            'cash_transfer_to' => ['required', 'numeric'],
            'amount' => ['required', 'numeric'],
        ]);
    }

    public function AssignCashTransferValues($request, $cash_transfer)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $cash_transfer->ct_send_by = $user->user_id;
        $cash_transfer->ct_clg_id = $user->user_clg_id;
        $cash_transfer->ct_amount = $request->amount;
        $cash_transfer->ct_receive_by = $request->cash_transfer_to;
        $cash_transfer->ct_status = 'PENDING';
        $cash_transfer->ct_remarks = $request->remarks;
        $cash_transfer->ct_send_datetime = Carbon::now()->toDateTimeString();
        $cash_transfer->ct_dayend_id = $day_end->de_id;
        $cash_transfer->ct_dayend_date = $day_end->de_datetime;

        // coding from shahzaib start
        $tbl_var_name = 'cash_transfer';
        $prfx = 'ct';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        return $cash_transfer;
    }

    protected function ExcelAssignCashTransferValues($request, $cash_transfer)
    {

        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $cash_transfer->ct_send_by = $user->user_id;
        $cash_transfer->ct_clg_id = $user->user_clg_id;
        $cash_transfer->ct_amount = $request->amount;
        $cash_transfer->ct_receive_by = $request->cash_transfer_to;
        $cash_transfer->ct_status = 'PENDING';
        $cash_transfer->ct_send_datetime = Carbon::now()->toDateTimeString();
        $cash_transfer->ct_dayend_id = $day_end->de_id;
        $cash_transfer->ct_dayend_date = $day_end->de_datetime;

        // coding from shahzaib start
        $tbl_var_name = 'cash_transfer';
        $prfx = 'ct';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        return $cash_transfer;
    }
}
