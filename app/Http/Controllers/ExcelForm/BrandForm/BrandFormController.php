<?php

namespace App\Http\Controllers\ExcelForm\BrandForm;

use App\Http\Controllers\DayEndController;
use App\Models\BrandModel;
use App\Models\ProductGroupModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BrandFormController extends Controller
{
    public function excel_form_brand($request)
    {

        DB::beginTransaction();
        $rollBack = false;

        $brand = new BrandModel();

        $user = Auth::User();

        $brand = $this->ExcelAssignBrandValues($request, $brand);


        if ($brand->save()) {
            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Brand With Id: ' . $brand->br_id . ' And Name: ' . $brand->br_title);


            if (!$brand->save()) {
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

    public function simple_form_brand($request)
    {

        $this->brand_validation($request);

        $brand = new BrandModel();

        $brand = $this->AssignBrandValues($request, $brand);

        $brand->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Brand With Id: ' . $brand->br_id . ' And Name: ' . $brand->br_title);

        // WizardController::updateWizardInfo(['region'], ['area']);

        return redirect('add_brand')->with('success', 'Successfully Saved');

    }

    public function brand_validation($request)
    {
        $user = Auth::User();
        return $this->validate($request, [
            'brand_name' => ['required', 'string', 'unique:financials_brands,br_title,null,null,br_clg_id,' . $user->user_clg_id],
            'remarks' => ['nullable', 'string'],
        ]);
    }

    public function excel_brand_validation($request)
    {
        $user = Auth::User();
        return $this->validate($request, [
            'brand_name' => ['required', 'string', 'unique:financials_brands,br_title,null,null,br_clg_id,' . $user->user_clg_id],
        ]);

    }

    protected function AssignBrandValues($request, $brand)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $brand->br_title = ucwords($request->brand_name);
        $brand->br_remarks = ucfirst($request->remarks);
        $brand->br_created_by = $user->user_id;
        $brand->br_clg_id = $user->user_clg_id;
        $brand->br_day_end_id = $day_end->de_id;
        $brand->br_day_end_date = $day_end->de_datetime;

        // coding from shahzaib start
        $tbl_var_name = 'brand';
        $prfx = 'br';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adr';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        return $brand;
    }

    protected function ExcelAssignBrandValues($request, $brand)
    {

        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $brand->br_title = ucwords($request->brand_name);
        $brand->br_created_by = $user->user_id;
        $brand->br_clg_id = $user->user_clg_id;
        $brand->br_day_end_id = $day_end->de_id;
        $brand->br_day_end_date = $day_end->de_datetime;

        // coding from shahzaib start
        $tbl_var_name = 'brand';
        $prfx = 'br';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adr';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        return $brand;
    }


}
