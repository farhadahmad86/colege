<?php

namespace App\Http\Controllers\ExcelForm\AreaForm;

use App\Http\Controllers\DayEndController;
use App\Models\AreaModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;
use Session;

class AreaController extends Controller
{
    public function excel_form_area($request)
    {
        DB::beginTransaction();
        $rollBack = false;

        $area = new AreaModel();
        $user = Auth::User();
        $area = $this->ExcelAssignAreaValues($request, $area);

        if ($area->save()) {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Area With Id: ' . $area->area_id . ' And Name: ' . $area->area_title);


            if (!$area->save()) {
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

    public function simple_form_area($request)
    {
        $area_already_exist = AreaModel::where('area_title', '=', $request->area_name)->where('area_reg_id', '=', $request->region_name)->first();
        if ($area_already_exist != null) {
            return response()->json(['already_exist' => 'Area Already exist'], 200);
        }
        $this->area_validation($request);
        $area_name = $request->area_name;
        $area = new AreaModel();

        $area = $this->AssignAreaValues($request, $area);

        $area->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Area With Id: ' . $area->area_id . ' And Name: ' . $area->area_title);

        // WizardController::updateWizardInfo(['area'], ['sector']);
        return response()->json(['message' => 'Successfully Saved!', 'name' => $area_name], 200);
//        return redirect('add_area')->with('success', 'Successfully Saved');

    }

    public function area_validation($request)
    {
        $user = Auth::User();
        return $this->validate($request, [
            'region_name' => ['required', 'numeric'],
            'area_name' => ['required', 'string', 'unique:financials_areas,area_title,NULL,area_id,area_reg_id,' . $request->region_name. ',area_clg_id,' . $user->user_clg_id],
            'remarks' => ['nullable', 'string'],
        ]);
    }

    public function excel_area_validation($request)
    {
        $user = Auth::User();
        return $this->validate($request, [
            'region_name' => ['required', 'numeric'],
            'area_name' => ['required', 'string', 'unique:financials_areas,area_title,NULL,area_id,area_reg_id,' . $request->region_name. ',area_clg_id,' . $user->user_clg_id],
        ]);
    }

    protected function AssignAreaValues($request, $area)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $area->area_reg_id = $request->region_name;
        $area->area_title = ucwords($request->area_name);
        $area->area_remarks = ucfirst($request->remarks);
        $area->area_createdby = $user->user_id;
        $area->area_day_end_id = $day_end->de_id;
        $area->area_day_end_date = $day_end->de_datetime;
        $area->area_clg_id = $user->user_clg_id;
        $area->area_branch_id = Session::get('branch_id');

        // coding from shahzaib start
        $tbl_var_name = 'area';
        $prfx = 'area';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now()->toDateTimeString();
        // coding from shahzaib end


        return $area;
    }

    protected function ExcelAssignAreaValues($request, $area)
    {

        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $area->area_reg_id = $request->region_name;
        $area->area_title = ucwords($request->area_name);
        $area->area_createdby = $user->user_id;
        $area->area_day_end_id = $day_end->de_id;
        $area->area_day_end_date = $day_end->de_datetime;
        $area->area_clg_id = $user->user_clg_id;
        $area->area_branch_id = Session::get('branch_id');

        // coding from shahzaib start
        $tbl_var_name = 'area';
        $prfx = 'area';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now()->toDateTimeString();
        // coding from shahzaib end


        return $area;
    }
}
