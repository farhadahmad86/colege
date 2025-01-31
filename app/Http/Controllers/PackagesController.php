<?php

namespace App\Http\Controllers;

use App\Models\College\Branch;
use App\Models\PackagesModel;
use App\User;
use Carbon\Carbon;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;


class PackagesController extends Controller
{
    public function software_package()
    {
        $user = Auth::user();
        if (Auth::user()->user_type == 'Master') {
            $package = PackagesModel::where('pak_clg_id', $user->user_clg_id)->first();
            return view('software_package.edit_package', compact('package'));
        } else {
            return redirect()->route('home')->with('fail', 'You are not eligible person');
        }

    }

    public function update_software_package(Request $request)
    {

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $user = Auth::user();
        $package = PackagesModel::where('pak_clg_id', $user->user_clg_id)->first();
        $package->pak_name = $request->check_package;
        $package->pak_total_user = $request->check_user;
        $package->pak_financial_year = $request->financial_year;
        $package->pak_user_id = $user->user_id;
        $package->pak_update_datetime = Carbon::now()->toDateTimeString();
        $package->pak_brwsr_info = $brwsr_rslt;
        $package->pak_ip_adrs = $ip_rslt;
        $package->save();

        return redirect()->back()->with('Success', 'Package Update Successfully!');

    }

    public function user_expiry()
    {
        $user = Auth::user();
        if (Auth::user()->user_type == 'Master') {
            $expiry_date = User::where('user_clg_id', $user->user_clg_id)->pluck('user_expiry_date')->first();
            return view('software_package.user_expire', compact('expiry_date'));
        } else {
            return redirect()->route('home')->with('fail', 'You are not eligible person');
        }

    }

    public function update_user_expiry(Request $request)
    {
        $user = Auth::user();
        $expiry_date = date('Y-m-d', strtotime($request->expiry_date));
        $users = User::where('user_clg_id', $user->user_clg_id)->where('user_status', '=', 'Employee')->pluck('user_id');
        foreach ($users as $user_id) {
            $user = User::where('user_id', $user_id)->first();
            $user->user_expiry_date = $expiry_date;
            $user->save();
        }
        return redirect()->back()->with('Success', 'Update Successfully!');

    }

    public function user_expiry_alert()
    {
        $user = Auth::user();
        $expiry_date = User::where('user_clg_id', $user->user_clg_id)->pluck('user_expiry_date')->first();
        $current_date = Carbon::now()->format('Y-m-d');
        $formatted_dt1 = Carbon::parse($expiry_date);

        $formatted_dt2 = Carbon::parse($current_date);

        $diff_in_days = $formatted_dt1->diffInDays($formatted_dt2);
        return $diff_in_days;
//        if ($diff_in_days <= 15) {
//            return redirect()->back()->with('success', $diff_in_days . ' Days Remaining');
//        }
//        return redirect()->back();
    }

    /**
     * Branch Store in session .
     */
    public function branch_session(Request $request, $id)
    {
        $branch = Branch::where('branch_id', $id)->select('branch_name', 'branch_no')->first();
        Session::put(['branch_id' => $id, 'branch_name' => $branch->branch_name, 'branch_no' => $branch->branch_no]);
        if ($request->expectsJson()) {
            $branch_id = $id;
            return response()->json(['branch_id' => $branch_id], 200);
        } else {
            return back();
        }
    }
}
