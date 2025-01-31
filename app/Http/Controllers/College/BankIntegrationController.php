<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Controller;
use App\Models\AccountRegisterationModel;
use App\Models\BankIntegration;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankIntegrationController extends Controller
{
    public function bank_integration_list()
    {
        $user = Auth::user();
                $integrate_account = BankIntegration::leftJoin('financials_users as user', 'user.user_id','=','bank_integrations.bi_updated_by')
                    ->leftJoin('financials_accounts as account', 'account.account_uid','=','bank_integrations.bi_account_no')
                    ->select('bank_integrations.*', 'user.user_name as updated_by_user_name','account.account_name')->first();
            $bankAccounts = AccountRegisterationModel::where('account_parent_code', 11012)->where('account_clg_id',$user->user_clg_id)->select('account_name','account_uid')->get();
            return view('collegeViews/bank_Integration/bank_integration_list',compact('integrate_account','bankAccounts'));
    }
    public function update_bank_integration(Request $request)
    {
        $user = Auth::user();
        $integration = BankIntegration::where('bi_account_no',$request->bi_account_no)->first();
        $integration->bi_account_no = $request->account_no;
        $integration->bi_created_by = $user->user_id;
        $integration->bi_updated_at = Carbon::now();
        $integration->bi_clg_id = $user->user_clg_id;
        $integration->save();
        return redirect()->back()->with('success', 'Updated Successfully');
    }
}
