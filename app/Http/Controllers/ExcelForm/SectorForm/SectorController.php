<?php

namespace App\Http\Controllers\ExcelForm\SectorForm;

use App\Http\Controllers\DayEndController;
use App\Models\SectorModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use Illuminate\Support\Facades\DB;

class SectorController extends Controller
{
    public function excel_form_sector($request)
    {
        DB::beginTransaction();
        $rollBack = false;

        $sector = new SectorModel();

        $sector = $this->ExcelAssignSectorValues($request, $sector);
        $user = Auth::User();

        if ($sector->save()) {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Sector With Id: ' . $sector->sec_id . ' And Name: ' . $sector->sec_title);

            if (!$sector->save()) {
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

    public function simple_form_sector($request)
    {
        $area_already_exist = SectorModel::where('sec_title', '=', $request->sector_name)->where('sec_area_id', '=', $request->area_name)->first();
        if ($area_already_exist != null) {
            return response()->json(['already_exist' => 'Sector Already exist'], 200);
        }
        $this->sector_validation($request);
        $sector_name = $request->sector_name;
        $sector = new SectorModel();

        $sector = $this->AssignSectorValues($request, $sector);

        $sector->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Sector With Id: ' . $sector->sec_id . ' And Name: ' . $sector->sec_title);

        // WizardController::updateWizardInfo(['sector'], ['town']);

        return response()->json(['message' => 'Successfully Saved!', 'name' => $sector_name], 200);
//        return redirect('add_sector')->with('success', 'Successfully Saved');

    }

    protected function ExcelAssignSectorValues($request, $sector)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $sector->sec_area_id = $request->area_name;
        $sector->sec_title = ucwords($request->sector_name);
        $sector->sec_createdby = $user->user_id;
        $sector->sec_day_end_id = $day_end->de_id;
        $sector->sec_day_end_date = $day_end->de_datetime;
        $sector->sec_clg_id = $user->user_clg_id;
        $sector->sec_branch_id = Session::get('branch_id');

        // coding from shahzaib start
        $tbl_var_name = 'sector';
        $prfx = 'sec';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        return $sector;
    }

    public function sector_validation($request)
    {
        $user = Auth::user();
        return $this->validate($request, [
            'region_name' => ['required', 'numeric'],
            'area_name' => ['required', 'numeric'],
            'sector_name' => ['required', 'string', 'unique:financials_sectors,sec_title,NULL,sec_id,sec_area_id,' . $request->area_name.',sec_clg_id,' . $user->user_clg_id],
            'remarks' => ['nullable', 'string'],
        ]);

    }

    public function excel_sector_validation($request)
    {
        $user = Auth::user();
        return $this->validate($request, [
            'region_name' => ['required', 'numeric'],
            'area_name' => ['required', 'numeric'],
            'sector_name' => ['required', 'string', 'unique:financials_sectors,sec_title,NULL,sec_id,sec_area_id,' . $request->area_name.',sec_clg_id,' . $user->user_clg_id],
        ]);
    }
    protected function AssignSectorValues($request, $sector)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $sector->sec_area_id = $request->area_name;
        $sector->sec_title = ucwords($request->sector_name);
        $sector->sec_remarks = ucfirst($request->remarks);
        $sector->sec_createdby = $user->user_id;
        $sector->sec_day_end_id = $day_end->de_id;
        $sector->sec_day_end_date = $day_end->de_datetime;
        $sector->sec_clg_id = $user->user_clg_id;
        $sector->sec_branch_id = Session::get('branch_id');

        // coding from shahzaib start
        $tbl_var_name = 'sector';
        $prfx = 'sec';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        return $sector;
    }
}
