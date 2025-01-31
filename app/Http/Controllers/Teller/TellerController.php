<?php

namespace App\Http\Controllers\Teller;

use App\Http\Controllers\UserController;
use App\Models\AccountRegisterationModel;
use App\Models\ProductModel;
use App\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TellerController extends Controller
{
    public function dashboard()
    {
        $accounts = AccountRegisterationModel::get();

        $assets = 0;
        $liability = 0;
        $revenue = 0;
        $expense = 0;
        $equity = 0;

        $total_account = count($accounts);

        foreach ($accounts as $account) {

            if (substr($account->account_uid, 0, 1) == 1) {
                $assets++;
            } elseif (substr($account->account_uid, 0, 1) == 2) {
                $liability++;
            } elseif (substr($account->account_uid, 0, 1) == 3) {
                $revenue++;
            } elseif (substr($account->account_uid, 0, 1) == 4) {
                $expense++;
            } elseif (substr($account->account_uid, 0, 1) == 5) {
                $equity++;
            }
        }

        if ($assets == 0 && $liability == 0 && $revenue == 0 && $expense == 0 && $equity == 0) {
            $assets = 50;
            $liability = 50;
            $revenue = 50;
            $expense = 50;
            $equity = 50;
        }

        $app_users = User::where('user_status', 'ENABLE')->count();

        $employee = User::count();

        $products = ProductModel::count();

        return view('teller/dashboard', compact('employee', 'app_users', 'total_account', 'products', 'assets', 'liability', 'revenue', 'expense', 'equity'));


//        return view('teller/dashboard');
    }

    public function change_password()
    {
        return view('teller/change_password');
    }

    public function submit_change_password(Request $request)
    {
        $this->change_password_validation($request);

        $password = $this->AssignPasswordValues($request);

        if ($password) {
            return redirect(route('teller/change_password'))->with('success', 'Successfully Saved');
        } else {
            return redirect(route('teller/change_password'))->with('fail', 'Please Try Again!');
        }
    }

    public function change_password_validation($request)
    {
        return $this->validate($request, [
            'old_password' => ['required', 'min:8', 'regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[${\]}{\}@$!~%_`#*\'"|()}:.;,[+{<>=?&\/^-])[A-Za-z\d${\]}{\}@$!~%_`;#*\'"|()}:.,[+{<>=?&\/^-]{8,}$/'],
            'password' => ['required', 'confirmed', 'min:8', 'regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[${\]}{\}@$!~%_`#*\'"|()}:.;,[+{<>=?&\/^-])[A-Za-z\d${\]}{\}@$!~%_`;#*\'"|()}:.,[+{<>=?&\/^-]{8,}$/'],
//            'password_confirmation' => ['required', 'min:8', 'regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[${\]}{\}@$!~%_`#*\'"|()}:.;,[+{<>=?&\/^-])[A-Za-z\d${\]}{\}@$!~%_`;#*\'"|()}:.,[+{<>=?&\/^-]{8,}$/'],
        ]);
    }

    protected function AssignPasswordValues($request)
    {
        $current_password = Auth::User()->user_password;
        $result = false;

        if (Hash::check($request->input('old_password'), $current_password)) {
            $user_id = Auth::User()->user_id;
            $obj_user = User::findOrFail($user_id);
            $obj_user->user_password = Hash::make($request->input('password'));
            $result = $obj_user->save();
        }

        return $result;
    }

    public function edit_profile(Request $request)
    {
        $user = Auth::user();

        return view('teller/edit_profile', compact('request','user'));
    }

    public function update_profile(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'name' => ['required', 'regex:/^[^-\s][a-zA-Z\s-]+$/'],
        ]);

        $profile = User::where('user_id', $user->user_id)->first();

        $profile->user_name = ucwords($request->name);

        if ($profile->save()) {
            return redirect('teller/edit_profile')->with('success', 'Successfully Saved');
        } else {
            return redirect('teller/edit_profile')->with('fail', 'Failed Try Again!');
        }
    }
}
