<?php

namespace App\Http\Controllers\ExcelForm\UnitForm;

use App\Http\Controllers\DayEndController;
use App\Models\RegionModel;
use App\Models\UnitInfoModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UnitFormController extends Controller
{
    public function excel_form_unit($request)
    {

        DB::beginTransaction();
        $rollBack = false;


        $unit = new UnitInfoModel();

        $user = Auth::User();

        $unit = $this->ExcelAssignUnitValues($request, $unit);

        if ($unit->save()) {
            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Unit With Id: ' . $unit->unit_id . ' And Name: ' . $unit->unit_title);


            if (!$unit->save()) {
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

    public function simple_form_unit($request)
    {
        $area_already_exist = UnitInfoModel::where('unit_title', '=', $request->unit_name)->where('unit_main_unit_id', '=', $request->main_unit)->where('unit_scale_size', '=', $request->scale_size)
            ->first();
        if ($area_already_exist != null) {
            return response()->json(['already_exist' => 'Unit Already exist'], 200);
        }
        $this->unit_validation($request);

        $unit_name = $request->unit_name;

        $unit = new UnitInfoModel();

        $unit = $this->AssignUnitValues($request, $unit);

        $unit->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Unit With Id: ' . $unit->unit_id . ' And Name: ' . $unit->unit_title);

        // WizardController::updateWizardInfo(['unit'], []);
        return response()->json(['message' => 'Successfully Saved!', 'name' => $unit_name], 200);
//        return redirect('add_unit')->with('success', 'Successfully Saved');
    }

    public function unit_validation($request)
    {
        $user = Auth::user();
        return $this->validate($request, [
            'main_unit' => ['required', 'numeric'],
//            'unit_name' => ['required', 'string', 'unique:financials_units,unit_title,NULL,unit_id,unit_main_unit_id,' . $request->main_unit],
            //'unit_name' => ['required', 'string'],
            'unit_name' => ['required', 'string', 'unique:financials_units,unit_title,NULL,unit_id,unit_main_unit_id,' . $request->main_unit . ',unit_clg_id,' . $user->user_clg_id],

            'remarks' => ['nullable', 'string'],
            'allowDecimal' => ['nullable'],
            'symbol' => ['nullable', 'string'],
            'scale_size' => ['required', 'string'],
        ]);
    }

    public function excel_unit_validation($request)
    {
        $user = Auth::user();
        return $this->validate($request, [
            'main_unit' => ['required', 'numeric'],
            'unit_name' => ['required', 'string', 'unique:financials_units,unit_title,NULL,unit_id,unit_main_unit_id,' . $request->main_unit . ',unit_clg_id,' . $user->user_clg_id],
            'scale_size' => ['required', 'string'],
        ]);
    }

    protected function AssignUnitValues($request, $unit)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $unit->unit_main_unit_id = $request->main_unit;
        $unit->unit_title = ucwords($request->unit_name);
        $unit->unit_allow_decimal = isset($request->allowDecimal) ? 1 : 0;
        $unit->unit_remarks = ucfirst($request->remarks);
        $unit->unit_symbol = $request->symbol;
        $unit->unit_scale_size = ucwords($request->scale_size);
        $unit->unit_createdby = $user->user_id;
        $unit->unit_clg_id = $user->user_clg_id;
        $unit->unit_day_end_id = $day_end->de_id;
        $unit->unit_day_end_date = $day_end->de_datetime;


        // coding from shahzaib start
        $tbl_var_name = 'unit';
        $prfx = 'unit';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        return $unit;
    }


    protected function ExcelAssignUnitValues($request, $unit)
    {

        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $unit->unit_main_unit_id = $request->main_unit;
        $unit->unit_title = ucwords($request->unit_name);
        $unit->unit_scale_size = ucwords($request->scale_size);
        $unit->unit_createdby = $user->user_id;
        $unit->unit_day_end_id = $day_end->de_id;
        $unit->unit_day_end_date = $day_end->de_datetime;


        // coding from shahzaib start
        $tbl_var_name = 'unit';
        $prfx = 'unit';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        return $unit;
    }
}
