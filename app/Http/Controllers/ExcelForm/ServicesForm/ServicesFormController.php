<?php

namespace App\Http\Controllers\ExcelForm\ServicesForm;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\DayEndController;
use App\Models\BrandModel;
use App\Models\ServicesModel;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ServicesFormController extends Controller
{

    public function excel_form_services($request)
    {

        DB::beginTransaction();
        $rollBack = false;

        $service = new ServicesModel();

        $user = Auth::User();

        $service = $this->ExcelAssignServicesForm($request, $service);


        if ($service->save()) {
            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Brand With Id: ' . $service->br_id . ' And Name: ' . $service->br_title);


            if (!$service->save()) {
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

    public function simple_form_services($request)
    {

        $this->services_validation($request);

        $service = new ServicesModel();

        $service = $this->AssignServicesValues($request, $service);

        $service->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Service With Id: ' . $service->ser_id . ' And Name: ' . $service->ser_title);

        // WizardController::updateWizardInfo(['service'], []);

        return redirect('add_services')->with('success', 'Successfully Saved');

    }

    public function services_validation($request)
    {$user = Auth::User();
        return $this->validate($request, [
            'service_name' => ['required', 'string', 'unique:financials_services,ser_title,null,null,ser_clg_id,' . $user->user_clg_id],
            'remarks' => ['nullable', 'string'],
        ]);

    }

    public function excel_services_validation($request)
    {$user = Auth::User();
        return $this->validate($request, [
            'service_name' => ['required', 'string', 'unique:financials_services,ser_title,null,null,ser_clg_id,' . $user->user_clg_id],
        ]);
    }

    protected function AssignServicesValues($request, $service)
    {
        $user = Auth::User();

        $service->ser_title = ucwords($request->service_name);
        $service->ser_created_by = $user->user_id;
        $service->ser_clg_id = $user->user_clg_id;
        $service->ser_datetime = Carbon::now()->toDateTimeString();

        // coding from shahzaib start
        $tbl_var_name = 'service';
        $prfx = 'ser';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end

        return $service;
    }

    protected function ExcelAssignServicesForm($request, $service)
    {

        $user = Auth::User();

        $service->ser_title = ucwords($request->service_name);
        $service->ser_created_by = $user->user_id;
        $service->ser_clg_id = $user->user_clg_id;
        $service->ser_datetime = Carbon::now()->toDateTimeString();

        // coding from shahzaib start
        $tbl_var_name = 'service';
        $prfx = 'ser';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end

        return $service;
    }

}
