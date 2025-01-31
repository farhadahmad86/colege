<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Wizard\WizardController;
use App\Models\CompanyInfoModel;
use App\Models\SystemConfigModel;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyInfoController extends Controller
{
    public function company_info(Request $request)
    {
        $company_information = CompanyInfoModel::first();

        return view('company_info', compact('company_information'));
    }


    public function update_company_info(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'name' => ['required', 'string'],
            'email' => 'required|string|email',
            'mobile' => ['nullable', 'regex:/^((\+92)|(0092))-?3\d{2}-?\d{7}$|^03\d{2}-?\d{7}$/'],
            'whatsapp' => ['nullable', 'regex:/^((\+92)|(0092))-?3\d{2}-?\d{7}$|^03\d{2}-?\d{7}$/'],
            'phone' => ['nullable', 'regex:/^0\d{2}-?\d{7}$/'],
            'fax' => ['nullable', 'regex:/^0\d{2}-?\d{7}$/'],
            'address' => ['required', 'string'],
            'pimage' => 'nullable|mimes:jpeg,jpg,png|max:1999',
//            'pimage' => 'nullable|image|mimes:jpeg,jpg,png|max:1999',
            'facebook' => ['nullable', 'string'],
            'twitter' => ['nullable', 'string'],
            'youtube' => ['nullable', 'string'],
            'google' => ['nullable', 'string'],
            'instagram' => ['nullable', 'string'],
        ]);


        $company = CompanyInfoModel::where('ci_clg_id', $user->user_clg_id)->first();

        $company->ci_name = ucwords($request->name);
        $company->ci_email = $request->email;
        $company->ci_mobile_numer = $request->mobile;
        $company->ci_whatsapp_number = $request->whatsapp;
        $company->ci_ptcl_number = $request->phone;
        $company->ci_fax_number = $request->fax;
        $company->ci_address = ucfirst($request->address);
        $company->ci_facebook = $request->facebook;
        $company->ci_twitter = $request->twitter;
        $company->ci_youtube = $request->youtube;
        $company->ci_google = $request->google;
        $company->ci_instagram = $request->instagram;
        $company->ci_clg_id = $user->user_clg_id;


        // coding from shahzaib start
        $tbl_var_name = 'company';
        $prfx = 'ci';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now()->toDateTimeString();
        // coding from shahzaib end


        if (!empty($request->pimage)) {
            $save_image = new SaveImageController();
            $common_path = config('global_variables.common_path');
            $college_path = config('global_variables.college_logo');
            // Handle Image
            $fileNameToStore = $save_image->SaveImage($request, 'pimage', $request->folder, $college_path . $user->user_clg_id, '/'.$user->user_clg_id . '_College_Logo');

            if (!empty($request->hasFile('pimage'))) {
                $company->ci_logo = $common_path . $fileNameToStore;
            } else {
                $company->ci_logo = $fileNameToStore;
            }
//            $save_image = new SaveImageController();
//
//            $common_path = config('global_variables.common_path');
//            $company_path = config('global_variables.company_logo');
//
//            // Handle Image
//
//		    $imageName = rand( 11111, 99999 ) . '.' . request()->pimage->getClientOriginalExtension();
//
//		    Storage::put('/company_logo/'.$imageName,file_get_contents($request->file('pimage')));
//
//            $company->ci_logo = $common_path.'/company_logo/'.$imageName;
        }

        if ($company->save()) {

            $user = Auth::User();
            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Company Info');

            // WizardController::updateWizardInfo(['company_info'], ['reporting_group']);

            return redirect()->back()->with('success', 'Successfully Saved');
        } else {
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }
    }
}
