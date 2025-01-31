<?php

namespace App\Http\Controllers\ExcelForm\WarehouseForm;

use App\Http\Controllers\DayEndController;
use App\Models\AreaModel;
use App\Models\WarehouseModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{
    public function excel_form_warehouse($request)
    {

        DB::beginTransaction();
        $rollBack = false;

        $warehouse = new WarehouseModel();
        $user = Auth::User();
        $warehouse = $this->ExcelAssignWarehouseValues($request, $warehouse);

        if ($warehouse->save()) {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Warehouse With Id: ' . $warehouse->wh_id . ' And Name: ' . $warehouse->wh_title);


            if (!$warehouse->save()) {
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

    public function simple_form_warehouse($request)
    {
        $this->warehouse_validation($request);

        $warehouse = new WarehouseModel();

        $warehouse = $this->AssignWarehouseValues($request, $warehouse);

        $warehouse->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Warehouse With Id: ' . $warehouse->wh_id . ' And Name: ' . $warehouse->wh_title);

        return redirect('add_warehouse')->with('success', 'Successfully Saved');

    }

    public function warehouse_validation($request)
    {
        $user = Auth::User();
        return $this->validate($request, [
            'warehouse_name' => ['required', 'string', 'unique:financials_warehouse,wh_title,null,null,wh_clg_id,' . $user->user_clg_id],
            'address' => ['required', 'string'],
            'remarks' => ['nullable', 'string'],
        ]);
    }

    public function excel_warehouse_validation($request)
    {
        $user = Auth::User();
        return $this->validate($request, [
            'warehouse_name' => ['required', 'string', 'unique:financials_warehouse,wh_title,null,null,wh_clg_id,' . $user->user_clg_id],
            'address' => ['required', 'string'],
        ]);
    }

    protected function AssignWarehouseValues($request, $warehouse)
    {
        $user = Auth::User();

        $warehouse->wh_title = ucwords($request->warehouse_name);
        $warehouse->wh_address = ucfirst($request->address);
        $warehouse->wh_remarks = ucfirst($request->remarks);
        $warehouse->wh_created_by = $user->user_id;
        $warehouse->wh_clg_id = $user->user_clg_id;
        $warehouse->wh_datetime = Carbon::now()->toDateTimeString();


        // coding from shahzaib start
        $tbl_var_name = 'warehouse';
        $prfx = 'wh';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        return $warehouse;
    }

    protected function ExcelAssignWarehouseValues($request, $warehouse)
    {

        $user = Auth::User();

        $warehouse->wh_title = ucwords($request->warehouse_name);
        $warehouse->wh_address = ucfirst($request->address);
        $warehouse->wh_created_by = $user->user_id;
        $warehouse->wh_clg_id = $user->user_clg_id;
        $warehouse->wh_datetime = Carbon::now()->toDateTimeString();


        // coding from shahzaib start
        $tbl_var_name = 'warehouse';
        $prfx = 'wh';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        return $warehouse;
    }
}
