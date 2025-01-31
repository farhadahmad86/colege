<?php

namespace App\Http\Controllers\ExcelForm\MainUnitForm;

use App\Http\Controllers\DayEndController;
use App\Models\MainUnitModel;
use App\Models\RegionModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MainUnitController extends Controller
{
    public function excel_form_main_unit($request)
    {

        DB::beginTransaction();
        $rollBack = false;

        $main_unit = new MainUnitModel();

        $user = Auth::User();

        $main_unit = $this->ExcelAssignMainUnitValues($request, $main_unit);

        if ($main_unit->save()) {
            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Main Unit With Id: ' . $main_unit->mu_id . ' And Name: ' . $main_unit->mu_title);


            if (!$main_unit->save()) {
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

    public function simple_form_main_unit($request)
    {

        $this->main_unit_validation($request);

        $main_unit = new MainUnitModel();

        $main_unit = $this->AssignMainUnitValues($request, $main_unit);

        $main_unit->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Main Unit With Id: ' . $main_unit->mu_id . ' And Name: ' . $main_unit->mu_title);

        // WizardController::updateWizardInfo(['main_unit'], ['unit']);

        return redirect('add_main_unit')->with('success', 'Successfully Saved');

    }

    public function main_unit_validation($request)
    {$user = Auth::user();
        return $this->validate($request, [
            'name' => ['required', 'string', 'unique:financials_main_units,mu_title,null,null,mu_clg_id,'.$user->user_clg_id],
            'remarks' => ['nullable', 'string'],
        ]);

    }

    public function excel_main_unit_validation($request)
    {$user = Auth::user();
        return $this->validate($request, [
            'name' => ['required', 'string', 'unique:financials_main_units,mu_title,null,null,mu_clg_id,'.$user->user_clg_id],
        ]);
    }

    protected function AssignMainUnitValues($request, $main_unit)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $main_unit->mu_title = ucwords($request->name);
        $main_unit->mu_remarks = ucfirst($request->remarks);
        $main_unit->mu_created_by = $user->user_id;
        $main_unit->mu_clg_id = $user->user_clg_id;
        $main_unit->mu_day_end_id = $day_end->de_id;
        $main_unit->mu_day_end_date = $day_end->de_datetime;
        $main_unit->mu_datetime = Carbon::now()->toDateTimeString();


        // coding from shahzaib start
        $tbl_var_name = 'main_unit';
        $prfx = 'mu';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        return $main_unit;
    }

    protected function ExcelAssignMainUnitValues($request, $main_unit)
    {

        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $main_unit->mu_title = ucwords($request->name);
        $main_unit->mu_created_by = $user->user_id;
        $main_unit->mu_clg_id = $user->user_clg_id;
        $main_unit->mu_day_end_id = $day_end->de_id;
        $main_unit->mu_day_end_date = $day_end->de_datetime;
        $main_unit->mu_datetime = Carbon::now()->toDateTimeString();


        // coding from shahzaib start
        $tbl_var_name = 'main_unit';
        $prfx = 'mu';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        return $main_unit;
    }

}
