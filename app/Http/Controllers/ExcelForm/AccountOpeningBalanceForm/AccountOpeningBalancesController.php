<?php

namespace App\Http\Controllers\ExcelForm\AccountOpeningBalanceForm;

use App\Models\AccountRegisterationModel;
use App\Models\OpeningTrialBalanceModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountOpeningBalancesController extends Controller
{
    public
    function excel_form_account_opening_balance($request)
    {
        $user = Auth::User();
        $rollBack = false;

        $account_ids = $request->account_id;
        $account_names = $request->account_name;
        $dr_balances = $request->dr;
        $cr_balances = $request->cr;
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        DB::beginTransaction();
        $account_id = $account_ids;
        $account_name = $account_names;
        // $dr_balance = $dr_balances[$index];
        // $cr_balance = $cr_balances[$index];
        $account_balance = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', '=', $account_id)->first();
        if ($dr_balances != null) {
            $account_balance->account_today_opening_type = 'DR';
            $account_balance->account_today_opening = $dr_balances;
        } else if ($cr_balances != null) {
            $account_balance->account_today_opening_type = 'CR';
            $account_balance->account_today_opening = $cr_balances;
        }
        $account_balance->save();

        $dr_balance = ($dr_balances === null || $dr_balances === "null") ? 0.00 : $dr_balances;
        $cr_balance = ($cr_balances === null || $cr_balances === "null") ? 0.00 : $cr_balances;

        OpeningTrialBalanceModel::where('tb_clg_id', $user->user_clg_id)->where('tb_account_id', $account_id)->delete();
        $opening_trial = new OpeningTrialBalanceModel();
        $opening_trial->tb_account_id = $account_id;
        $opening_trial->tb_account_name = $account_name;
        $opening_trial->tb_total_debit = $dr_balance;
        $opening_trial->tb_total_credit = $cr_balance;
        $opening_trial->tb_datetime = Carbon::now()->toDateTimeString();
        $opening_trial->tb_ip_adrs = $ip_rslt;
        $opening_trial->tb_brwsr_info = $brwsr_rslt;
        $opening_trial->tb_update_datetime = Carbon::now()->toDateTimeString();
        $opening_trial->tb_clg_id = $user->user_clg_id;
        $opening_trial->tb_year_id = $this->getYearEndId();
        if ($opening_trial->save()) {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Opening Trial Balances');
            DB::commit();
            return redirect()->back()->with('success', 'Successfully Saved');
        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

    }

    public
    function simple_form_account_opening_balance(Request $request)
    {
        $this->account_opening_balance_validation($request);

        $user = Auth::User();
        $rollBack = false;
        $account_array = json_decode($request->accountsval, true);

//        $account_ids = $request->id;
//        $account_names = $request->name;
//        $dr_balances = $request->dr_balances;
//        $cr_balances = $request->cr_balances;


        DB::beginTransaction();

//        OpeningTrialBalanceModel::where('tb_id', '>', 0)->delete();

        $new_data = [];

//        foreach ($account_ids as $index => $id) {
        foreach ($account_array as $index => $id) {

            $account_id = $id['id'];
            $account_name = $id['name'];
            $dr_bal = $id['dr_balances'];
            $cr_bal = $id['cr_balances'];
            $account_balance = AccountRegisterationModel::where('account_uid', '=', $account_id)->where('account_clg_id', '=', $user->user_clg_id)->first();
            if ($id['dr_balances'] != null) {
                $account_balance->account_today_opening_type = 'DR';
                $account_balance->account_today_opening = $id['dr_balances'];
            } else if ($id['cr_balances'] != null) {
                $account_balance->account_today_opening_type = 'CR';
                $account_balance->account_today_opening = $id['cr_balances'];
            }
            $account_balance->save();


            $dr_balance = ($dr_bal === null || $dr_bal === "null") ? 0.00 : $dr_bal;
            $cr_balance = ($cr_bal === null || $cr_bal === "null") ? 0.00 : $cr_bal;


            OpeningTrialBalanceModel::where('tb_account_id', $account_id)->where('tb_clg_id', '=', $user->user_clg_id)->delete();

            $new_data[] = $this->assign_opening_trial_values($account_id, $account_name, $dr_balance, $cr_balance);
        }

        foreach (array_chunk($new_data, 1000) as $t) {
            if (!DB::table('financials_opening_trial_balance')->insert($t)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }
        }

//        if (!DB::table('financials_opening_trial_balance')->insert($new_data)) {
//            $rollBack = true;
//            DB::rollBack();
//            return redirect()->back()->with('fail', 'Failed Try Again');
//        }

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Opening Trial Balances');
            DB::commit();
            return redirect()->back()->with('success', 'Successfully Saved');
        }
    }

    public
    function assign_opening_trial_values($account_id, $account_name, $dr_balance, $cr_balance)
    {
        $user= Auth::user();
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $data = ['tb_account_id' => $account_id, 'tb_account_name' => $account_name, 'tb_total_debit' => $dr_balance, 'tb_total_credit' => $cr_balance, 'tb_datetime' =>
            Carbon::now()->toDateTimeString(), 'tb_ip_adrs' => $ip_rslt, 'tb_brwsr_info' => $brwsr_rslt, 'tb_update_datetime' => Carbon::now()->toDateTimeString(), 'tb_clg_id' => $user->user_clg_id,'tb_year_id' => $this->getYearEndId()];

        return $data;
    }

    public
    function account_opening_balance_validation($request)
    {
        return $this->validate($request, [
            'id' => ['required', 'array'],
            'id.*' => ['required', 'numeric'],
            'dr_balances' => ['required', 'array'],
            'dr_balances.*' => ['nullable', 'numeric'],
            'cr_balances' => ['required', 'array'],
            'cr_balances.*' => ['nullable', 'numeric'],
        ]);
    }

    function excel_account_opening_balance_validation($request)
    {
        return $this->validate($request, [
//            'id' => ['required', 'array'],
//            'id.*' => ['required', 'numeric'],
//            'dr_balances' => ['required', 'array'],
//            'dr_balances.*' => ['nullable', 'numeric'],
//            'cr_balances' => ['required', 'array'],
//            'cr_balances.*' => ['nullable', 'numeric'],
        ]);
    }
}
