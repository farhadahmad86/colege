<?php

namespace App\Http\Controllers\ExcelForm\TownForm;

use App\Http\Controllers\DayEndController;
use App\Models\SectorModel;
use App\Models\TownModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;

class TownController extends Controller
{
    public function excel_form_town($request)
    {

        DB::beginTransaction();
        $rollBack = false;

        $town = new TownModel();

        $town = $this->ExcelAssignTownValues($request, $town);
        $user = Auth::User();

        if ($town->save()) {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Town With Id: ' . $town->town_id . ' And Name: ' . $town->town_title);

            if (!$town->save()) {
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

    public function simple_form_town($request)
    {
        $area_already_exist = TownModel::where('town_title', '=', $request->town_name)->where('town_sector_id', '=', $request->sector_name)->first();
        if ($area_already_exist != null) {
            return response()->json(['already_exist' => 'Town Already exist'], 200);
        }

        $this->town_validation($request);
        $town_name = $request->town_name;
        $town = new TownModel();

        $town = $this->AssignTownValues($request, $town);

        $town->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Town With Id: ' . $town->town_id . ' And Name: ' . $town->town_title);

        // WizardController::updateWizardInfo(['town'], ['client_registration', 'supplier_registration']);
        return response()->json(['message' => 'Successfully Saved!', 'name' => $town_name], 200);
//        return redirect()->back()->with('success', 'Successfully Saved');

    }

    protected function ExcelAssignTownValues($request, $town)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $town->town_sector_id = $request->sector_name;
        $town->town_title = ucwords($request->town_name);
        $town->town_createdby = $user->user_id;
        $town->town_day_end_id = $day_end->de_id;
        $town->town_day_end_date = $day_end->de_datetime;
        $town->town_brwsr_info = $brwsr_rslt;
        $town->town_ip_adrs = $ip_rslt;
        $town->town_update_datetime = Carbon::now()->toDateTimeString();
        $town->town_clg_id = $user->user_clg_id;
        $town->town_branch_id = Session::get('branch_id');;

        return $town;
    }

    public function town_validation($request)
    {
        $user = Auth::User();
        return $this->validate($request, [
            'region_name' => ['required', 'numeric'],
            'area_name' => ['required', 'numeric'],
            'sector_name' => ['required', 'numeric'],
            'town_name' => ['required', 'string', 'unique:financials_towns,town_title,NULL,town_id,town_sector_id,' . $request->sector_name . ',town_clg_id,' . $user->user_clg_id],
            'remarks' => ['nullable', 'string'],
        ]);
    }

    public function excel_town_validation($request)
    {
        $user = Auth::User();
        return $this->validate($request, [
            'region_name' => ['required', 'numeric'],
            'area_name' => ['required', 'numeric'],
            'sector_name' => ['required', 'numeric'],
            'town_name' => ['required', 'string', 'unique:financials_towns,town_title,NULL,town_id,town_sector_id,' . $request->sector_name . ',town_clg_id,' . $user->user_clg_id],
        ]);
    }

    protected function AssignTownValues($request, $town)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $town->town_sector_id = $request->sector_name;
        $town->town_title = ucwords($request->town_name);
        $town->town_remarks = ucfirst($request->remarks);
        $town->town_createdby = $user->user_id;
        $town->town_day_end_id = $day_end->de_id;
        $town->town_day_end_date = $day_end->de_datetime;
        $town->town_brwsr_info = $brwsr_rslt;
        $town->town_ip_adrs = $ip_rslt;
        $town->town_update_datetime = Carbon::now()->toDateTimeString();
        $town->town_clg_id = $user->user_clg_id;
        $town->town_branch_id = Session::get('branch_id');
        return $town;
    }
}
