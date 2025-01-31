<?php

namespace App\Http\Controllers\ExcelForm\GroupForm;

use App\Http\Controllers\DayEndController;
use App\Models\GroupInfoModel;
use App\Models\UnitInfoModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;

class GroupFormController extends Controller
{
    public function excel_form_group($request)
    {

        DB::beginTransaction();
        $rollBack = false;


        $group = new GroupInfoModel();

        $user = Auth::User();

        $group = $this->ExcelAssignGroupValues($request, $group);


        if ($group->save()) {
            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Product Group With Id: ' . $group->grp_id . ' And Name: ' . $group->grp_title);


            if (!$group->save()) {
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

    public function simple_form_group($request)
    {
        $this->group_validation($request);

        $group = new GroupInfoModel();

        $group = $this->AssignGroupValues($request, $group);

        $group->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Product Group With Id: ' . $group->grp_id . ' And Name: ' . $group->grp_title);

        // WizardController::updateWizardInfo(['group'], ['category']);

        return redirect('add_group')->with('success', 'Successfully Saved');
    }

    public function group_validation($request)
    {$user = Auth::user();
        return $this->validate($request, [
            'group_name' => ['required', 'string', 'unique:financials_groups,grp_title,null,null,grp_clg_id,' . $user->user_clg_id],

            'remarks' => ['nullable', 'string'],
            'tax' => ['nullable', 'regex:/^\d*\.?\d*$/'],
            'retailer' => ['nullable', 'regex:/^\d*\.?\d*$/'],
            'wholesaler' => ['nullable', 'regex:/^\d*\.?\d*$/'],
            'loyalty_card' => ['nullable', 'regex:/^\d*\.?\d*$/'],
        ]);
    }

    public function excel_group_validation($request)
    {$user = Auth::user();
        return $this->validate($request, [
            'group_name' => ['required', 'string', 'unique:financials_groups,grp_title,null,null,grp_clg_id,' . $user->user_clg_id],

        ]);
    }

    protected function AssignGroupValues($request, $group)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $group->grp_title = ucwords($request->group_name);
        $group->grp_remarks = ucfirst($request->remarks);
        $group->grp_createdby = $user->user_id;
        $group->grp_clg_id = $user->user_clg_id;
        $group->grp_branch_id = Session::get('branch_id');
        $group->grp_day_end_id = $day_end->de_id;
        $group->grp_day_end_date = $day_end->de_datetime;
        $group->grp_tax = (isset($request->tax) || !empty($request->tax)) ? $request->tax : 0;
        $group->grp_retailer_discount = (isset($request->retailer) || !empty($request->retailer)) ? $request->retailer : 0;
        $group->grp_whole_seller_discount = (isset($request->wholesaler) || !empty($request->wholesaler)) ? $request->wholesaler : 0;
        $group->grp_loyalty_card_discount = (isset($request->loyalty_card) || !empty($request->loyalty_card)) ? $request->loyalty_card : 0;

        // coding from shahzaib start
        $tbl_var_name = 'group';
        $prfx = 'grp';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        return $group;
    }

    protected function ExcelAssignGroupValues($request, $group)
    {

        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $group->grp_title = ucwords($request->group_name);

        $group->grp_createdby = $user->user_id;
        $group->grp_clg_id = $user->user_clg_id;
        $group->grp_branch_id = Session::get('branch_id');
        $group->grp_day_end_id = $day_end->de_id;
        $group->grp_day_end_date = $day_end->de_datetime;
        $group->grp_tax = 0;
        $group->grp_retailer_discount = 0;
        $group->grp_whole_seller_discount = 0;
        $group->grp_loyalty_card_discount = 0;

        // coding from shahzaib start
        $tbl_var_name = 'group';
        $prfx = 'grp';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        return $group;
    }
}
