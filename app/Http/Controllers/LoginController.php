<?php

namespace App\Http\Controllers;

use App\Mail\reset_password;
use App\Models\College\Branch;
use App\Models\CompanyInfoModel;
use App\Models\EmployeeModel;
use App\Models\ModularConfigDefinitionModel;
use App\Models\ModularGroupModel;
use App\Models\PackagesModel;
use App\Models\SystemConfigModel;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use function GuzzleHttp\Psr7\str;
use Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Mail;
use Session;

class LoginController extends Controller
{
    public function login_form()
    {
        $username = session('username');
        return view('login', compact('username'));
    }

    public function login_master_form()
    {
        // $username = session('username');
        return view('login', compact('title'));
    }

    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:master')->except('logout');
    }

    ///////////////////////////////////////////////
    ////////////////  Login User   ////////////////
    ///////////////////////////////////////////////
    public function showLoginForm()
    {
        dd(1);
        // return view('login');/
    }

    public function showMasterLoginForm()
    {
        dd('master');
        // return view('login');
    }

    public function login(Request $request)
    {

        $username = $request->user_name;
        $this->validate($request, [
            'user_name' => 'required|string',
            'password' => 'required|string',
        ]);
        if ($this->myLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        return redirect()->route('login')->with('fail', 'Please enter correct Username/Email and Password')->with('username', $username);
    }

//    hello this is fe_dev branch

    protected function myLogin(Request $request)
    {
        $username = $request->input('user_name'); //the input field has name='username' in form


        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            //user sent their email
            Auth::attempt([
                'user_email' => $username,
                'password' => $request->input('password')], false);
        } else {
            //they sent their username instead
            Auth::attempt([

                'user_username' => $username,
                'password' => $request->input('password')], false);
        }

        return !Auth::guest() ? true : false;
    }

    protected function sendLoginResponse(Request $request)
    {

        $request->session()->regenerate();
        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());

    }

    public function authenticated($request, $user)
    {
        if ($user->user_login_status == 'DISABLE') {
            auth()->logout();
            return redirect('login')->with('fail', 'You need to contact admin.');
        }
//        if ($user->user_web_status == 'online'&& $user->user_id != 1) {
//            auth()->logout();
//            return redirect('login')->with('fail', 'You have already login in other device.');
//        }

//        nabeel
//        $user->user_web_status = 'online';
//        $user->save();
//        if ($user->user_role_id == config('global_variables.teller_account_id')) {
//            return redirect()->route('teller/dashboard');
//        }

//        $modules=DB::table('role_has_permissions')->where('role_id',$user->user_modular_group_id)->pluck('permission_id')->toArray();
//        $modules = ModularGroupModel::where('mg_id', $user->user_modular_group_id)->first();
//
//        if ($modules != null) {
//            Session::put('first_level_modules', explode(',', $modules->mg_first_level_config));
//            Session::put('second_level_modules', explode(',', $modules->mg_second_level_config));
//            Session::put('third_level_modules', explode(',', $modules->mg_config));
//        } else {
//            Session::put('first_level_modules', explode(',', ''));
//            Session::put('second_level_modules', explode(',', ''));
//            Session::put('third_level_modules', explode(',', ''));
//        }

        $company_info = CompanyInfoModel::where('ci_clg_id', $user->user_clg_id)->first();
        $branches = Branch::whereIn('branch_id', explode(',', $user->user_branch_id))->select('branch_id', 'branch_name', 'branch_no')->get();
        if ($user->user_id != 1) {
            Session::put('company_info', $company_info);
            Session::put(['branch_id'=>$branches[0]->branch_id, 'branch_name'=>$branches[0]->branch_name, 'branch_no'=>$branches[0]->branch_no]);
        }
        //        nabeel
//        if ($user->user_id != 1) {
        if ($user->user_type != 'Master') {
//            mustafa expire user date

            if (Carbon::now()->format('Y-m-d') > Carbon::parse($user->user_expiry_date)->format('Y-m-d') && $user->user_status == 'Employee') {
                auth()->logout();
                return redirect()->back()->with('fail', 'Your License have expired please Renew Your License.');
            }
            $get_day_end = new DayEndController();
            $financials_days = $get_day_end->day_end_start_date();
            $finacial_year_days = PackagesModel::where('pak_id', '=', 1)->pluck('pak_financial_year')->first();
            if ($financials_days >= $finacial_year_days) {
                auth()->logout();
                return redirect()->back()->with('fail', 'Your Year have ended Renew your year.');
            }
            $role = Role::where('id', $user->user_modular_group_id)->first();

            if ($role->delete_status == 1 || $role->disabled == 1) {
                auth()->logout();
                return redirect()->back()->with('fail', 'Check your Role Permission status from your administrator.');
            }
//            end mustafa

            $this->swapSession($request, $user);
            if ($this->swapSession($request, $user) != null) {
                return redirect()->back()->with('fail', 'You have already logged in on other device.');
            }
            return redirect()->intended($this->redirectPath());

        }

        $systemConfig = SystemConfigModel::where('sc_clg_id', '=', $user->user_clg_id)->first();
        if ($systemConfig->sc_welcome_wizard['wizard_completed'] == 1) {
            if ($user->user_id == 1 ||$user->user_type == 'Master' || $user->user_type == 'Super Admin') {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('index'); // index
            }

        }
        return redirect()->route('wizard.index'); // index

    }

//    nabeel
    private function swapSession(Request $request, $user)
    {
        $new_id = $request->session()->getId();

        if ($user->hasSession()) {

            echo "<script>";
            echo "alert('You have already login in other device.');";
            echo "</script>";

            auth()->logout();
            return redirect()->back()->with('success', 'You have already login in other device.');

            Session::getHandler()->destroy($user->session_id);
        }

        $user->saveSession($new_id);

    }

    protected function guard()
    {
        return Auth::guard();
    }

    public function password_reset()
    {
        return view('auth/passwords/email');
    }

    public function password_reset_email(Request $request)
    {
        $email_validate = User::where('user_email', $request->email)->first();

//        if ($email_validate->user_reset_password != null || $email_validate->user_reset_password != '') {

        if ($email_validate) {

            $token = Str::random(40);
//            $token = str_random(40);

            $email_validate->user_reset_password = $token;

            if ($email_validate->save()) {
                $this->SendResetPasswordMail($request->email, $token);
//                Mail::to($request->email)->send(new reset_password($token));
                return redirect()->back()->with('success', 'Password Reset Link Send To Your Email');
            }
        } else {
            return redirect()->back()->with('fail', 'Invalid Email Address');
        }
//        }else {
//            return redirect()->back()->with('fail', 'Email Already Send');
//        }

    }

    public function change_forgotten_password(Request $request)
    {
        $token = $request->token;
        $token_validate = User::where('user_reset_password', $request->token)->first();

        if (!$token_validate) {
            return redirect('login')->with('fail', 'Invalid Token.');
        }

        return view('auth/passwords/reset', compact('token'));
    }

    public function update_forget_password(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email',
            'password' => ['required', 'confirmed', 'min:8', 'regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[${\]}{\}@$!~%_`#*\'"|()}:.;,[+{<>=?&\/^-])[A-Za-z\d${\]}{\}@$!~%_`;#*\'"|()}:.,[+{<>=?&\/^-]{8,}$/'],
        ]);

        $obj_user = User::where('user_email', $request->email)->where('user_reset_password', $request->token)->first();

        if ($obj_user) {
            $obj_user->user_password = Hash::make($request->input('password'));
            if ($obj_user->save()) {
                $obj_user->user_reset_password = '';
                $obj_user->save();
                return redirect('login')->with('success', 'Password Successfully Changed');
            } else {
                return redirect('login')->with('fail', 'Password Not Changed. Try Again');
            }
        } else {
            return redirect('login')->with('fail', 'Password Not Changed. Try Again');
        }
    }

}
