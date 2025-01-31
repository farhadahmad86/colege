<?php

namespace App\Http\Controllers;

use App\Http\Middleware\DayEnd;
use App\Mail\PasswordMail;
use App\Models\AccountGroupModel;
use App\Models\AccountHeadsModel;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\BankPaymentVoucherModel;
use App\Models\BankReceiptVoucherModel;
use App\Models\CashPaymentVoucherModel;
use App\Models\CashReceiptVoucherModel;
use App\Models\CityModel;
use App\Models\College\Student;
use App\Models\CountryModel;
use App\Models\DayEndModel;
use App\Models\ModularConfigDefinitionModel;
use App\Models\ModularGroupModel;
use App\Models\PackagesModel;
use App\Models\ProductGroupModel;
use App\Models\ProductModel;
use App\Models\RolesModel;
use App\Models\SalaryADItemsModel;
use App\Models\SalaryInfoModel;
use App\Models\SystemConfigModel;
use App\User;

//use Auth;
use Carbon\Carbon;
use Hash;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Mail;
use Session;
use Validator;

class UserController extends Controller
{
    public function welcome(Request $request)
    {
        $get_day_end = new DayEndController();
        $financial_days = $get_day_end->day_end_start_date();
        $employee = User::count();
        $app_users = User::where('user_login_status', 'ENABLE')->count();
        $products = ProductModel::count();
        $query = DB::table('financials_goods_receipt_note')
            ->rightJoin('financials_goods_receipt_note_items', 'financials_goods_receipt_note.grn_id', 'financials_goods_receipt_note_items.grni_invoice_id')
            ->where('grni_due_qty', '!=', 0);
        $grn = $query
            ->select('financials_goods_receipt_note.grn_id', 'financials_goods_receipt_note.grn_party_code', 'financials_goods_receipt_note.grn_party_name', 'financials_goods_receipt_note.grn_datetime')
            ->groupBy('grn_id')->get();

        $query = DB::table('financials_delivery_order')
            ->rightJoin('financials_delivery_order_items', 'financials_delivery_order.do_id', 'financials_delivery_order_items.doi_invoice_id')
            ->where('do_status', '=', 0)
            ->where('doi_due_qty', '!=', 0);
        $do = $query
            ->select('financials_delivery_order.do_id', 'financials_delivery_order.do_party_code', 'financials_delivery_order.do_party_name', 'financials_delivery_order.do_datetime')
            ->groupBy('do_id')->get();

        $query = DB::table('financials_sale_order')
            ->Join('financials_sale_order_items', 'financials_sale_order.so_id', 'financials_sale_order_items.soi_invoice_id')
            ->where('soi_due_qty', '!=', 0);
        $so = $query
            ->select('financials_sale_order.so_id', 'financials_sale_order.so_party_code', 'financials_sale_order.so_party_name', 'financials_sale_order.so_datetime')
            ->groupBy('so_id')->get();
        $accounts = AccountRegisterationModel::get();
        $total_account = count($accounts);
        $clients = AccountRegisterationModel::where('account_parent_code','=',11013)->count();
        $suppliers = AccountRegisterationModel::where('account_parent_code','=',21010)->count();

        $cash_payment = CashPaymentVoucherModel::where('cp_status','=','park')->count();
        $cash_receipt = CashReceiptVoucherModel::where('cr_status','=','park')->count();
        $bank_receipt = BankReceiptVoucherModel::where('br_status','=','park')->count();
        $bank_payment = BankPaymentVoucherModel::where('bp_status','=','park')->count();
        $total_users = PackagesModel::pluck('pak_total_user')->first();

        $receivable = BalancesModel::select(DB::raw("(sum(bal_dr)) - (sum(bal_cr)) as diff"), DB::raw("MONTHNAME(bal_day_end_date) as month_name"))
            ->where('bal_account_id', 'like', 11013 . '%')
            ->whereYear('bal_day_end_date', date('Y'))
            ->groupBy(DB::raw("Month(bal_day_end_date)"))
            ->pluck('diff', 'month_name');

        $receivable_labels = $receivable->keys();
        $receivable_data = $receivable->values();

        $roleId = DB::table('model_has_roles')
            ->where('model_id', auth()->user()->user_id)
            ->value('role_id');

        $permissionCount = DB::table('permissions')
            ->where('web_route', 'first_level_chart_of_account')
            ->whereIn('id', function ($query) use ($roleId) {
                $query->select('permission_id')
                    ->from('role_has_permissions')
                    ->where('role_id', $roleId);
            })
            ->count();

        return view('dashboard', compact('employee', 'app_users', 'total_account', 'products', 'total_users','suppliers','clients','cash_receipt','cash_payment','bank_receipt','bank_payment','grn','do','so', 'financial_days','receivable_labels','receivable_data','permissionCount'));

//        return view('error_pages/error_1040');
    }

    public function admin_dashboard(Request $request)
    {
        $get_day_end = new DayEndController();
        $financial_days = $get_day_end->day_end_start_date();

        $query = DB::table('financials_goods_receipt_note')
            ->rightJoin('financials_goods_receipt_note_items', 'financials_goods_receipt_note.grn_id', 'financials_goods_receipt_note_items.grni_invoice_id')
            ->where('grni_due_qty', '!=', 0);
        $grn = $query
            ->select('financials_goods_receipt_note.grn_id', 'financials_goods_receipt_note.grn_party_code', 'financials_goods_receipt_note.grn_party_name', 'financials_goods_receipt_note.grn_datetime')
            ->groupBy('grn_id')->get();

        $query = DB::table('financials_delivery_order')
            ->rightJoin('financials_delivery_order_items', 'financials_delivery_order.do_id', 'financials_delivery_order_items.doi_invoice_id')
            ->where('do_status', '=', 0)
            ->where('doi_due_qty', '!=', 0);
        $do = $query
            ->select('financials_delivery_order.do_id', 'financials_delivery_order.do_party_code', 'financials_delivery_order.do_party_name', 'financials_delivery_order.do_datetime')
            ->groupBy('do_id')->get();

        $query = DB::table('financials_sale_order')
            ->Join('financials_sale_order_items', 'financials_sale_order.so_id', 'financials_sale_order_items.soi_invoice_id')
            ->where('soi_due_qty', '!=', 0);
        $so = $query
            ->select('financials_sale_order.so_id', 'financials_sale_order.so_party_code', 'financials_sale_order.so_party_name', 'financials_sale_order.so_datetime')
            ->groupBy('so_id')->get();


        $clients = AccountRegisterationModel::where('account_parent_code','=',11013)->count();
        $suppliers = AccountRegisterationModel::where('account_parent_code','=',21010)->count();

        $cash_payment = CashPaymentVoucherModel::where('cp_status','=','park')->count();
        $cash_receipt = CashReceiptVoucherModel::where('cr_status','=','park')->count();
        $bank_receipt = BankReceiptVoucherModel::where('br_status','=','park')->count();
        $bank_payment = BankPaymentVoucherModel::where('bp_status','=','park')->count();

        $accounts = AccountRegisterationModel::get();

        $assets = 0;
        $liability = 0;
        $revenue = 0;
        $expense = 0;
        $equity = 0;

        $receivable = BalancesModel::select(DB::raw("(sum(bal_dr)) - (sum(bal_cr)) as diff"), DB::raw("MONTHNAME(bal_day_end_date) as month_name"))
            ->where('bal_account_id', 'like', 11013 . '%')
            ->whereYear('bal_day_end_date', date('Y'))
            ->groupBy(DB::raw("Month(bal_day_end_date)"))
            ->pluck('diff', 'month_name');

        $receivable_labels = $receivable->keys();
        $receivable_data = $receivable->values();

        $payable = BalancesModel::select(DB::raw("(sum(bal_dr))- (sum(bal_cr)) as diff"), DB::raw("MONTHNAME(bal_day_end_date) as month_name"))
            ->where('bal_account_id', 'like', 21010 . '%')
            ->whereYear('bal_day_end_date', date('Y'))
            ->groupBy(DB::raw("Month(bal_day_end_date)"))
            ->pluck('diff', 'month_name');

        $payable_labels = $payable->keys();
        $payable_data = $payable->values();

        $revenues = BalancesModel::select(DB::raw("(sum(bal_dr))- (sum(bal_cr)) as diff"), DB::raw("MONTHNAME(bal_day_end_date) as month_name"))
            ->where('bal_account_id', 'like', 3 . '%')
            ->whereYear('bal_day_end_date', date('Y'))
            ->groupBy(DB::raw("Month(bal_day_end_date)"))
            ->pluck('diff', 'month_name');

        $revenue_labels = $revenues->keys();
        $revenue_data = $revenues->values();

        $expenses = BalancesModel::select(DB::raw("(sum(bal_dr))- (sum(bal_cr)) as diff"), DB::raw("MONTHNAME(bal_day_end_date) as month_name"))
            ->where('bal_account_id', 'like', 4 . '%')
            ->whereYear('bal_day_end_date', date('Y'))
            ->groupBy(DB::raw("Month(bal_day_end_date)"))
            ->pluck('diff', 'month_name');

        $expense_labels = $expenses->keys();
        $expense_data = $expenses->values();

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
//        dd($revenue);
        $total_users = PackagesModel::pluck('pak_total_user')->first();
        $app_users = User::where('user_login_status', 'ENABLE')->count();

        $employee = User::count();

        $products = ProductModel::count();

//        $systm_config = DB::table('financials_system_config')->where('sc_id','1')->first();
        $systm_config = SystemConfigModel::where('sc_id', '1')->first();
        $prgrs_br = 0;
        if ($systm_config->sc_profile_update === 1):
            $prgrs_br = 16.67 + $prgrs_br;
        endif;
        if ($systm_config->sc_company_info_update === 1):
            $prgrs_br = 16.67 + $prgrs_br;
        endif;
        if ($systm_config->sc_products_added === 1):
            $prgrs_br = 16.67 + $prgrs_br;
        endif;
        if ($systm_config->sc_admin_capital_added === 1):
            $prgrs_br = 16.67 + $prgrs_br;
        endif;
        if ($systm_config->sc_opening_trial_complete === 1):
            $prgrs_br = 100;
        endif;

        $get_links = ModularConfigDefinitionModel::where('mcd_parent_code', '=', 0)->where('mcd_before_config', '1')->with('childs')->with(['childs' => function ($query) {
            $query->with('childs');
        }])->get();
        $systm_cnfg_detail = ModularConfigDefinitionModel::where('mcd_level', 3)->where('mcd_before_config', '1')->get();

        $students = Student::query();
        $active=$students->clone()->whereIn('status', [1, 4])->count();
        $graduate=$students->clone()->whereStatus(2)->count();
        $stuckOff=$students->clone()->whereStatus(3)->count();

//        return response()->json($system_congig,200);

//        nabeel

        return view('admin_dashboard', compact('employee', 'app_users', 'total_account', 'products', 'assets', 'liability', 'revenue', 'expense', 'equity', 'systm_config', 'get_links', 'systm_cnfg_detail', 'systm_config', 'prgrs_br','total_users','suppliers','clients','cash_receipt','cash_payment','bank_receipt','bank_payment','grn','do','so', 'financial_days', 'receivable_data','receivable_labels','revenue_labels','revenue_data','payable_data','expense_data','active','graduate','stuckOff'));

//        return view('error_pages/error_1040');
    }

    public function enable_disable_user(Request $request)
    {
        $user_expiry = Auth::user()->user_expiry_date;
        $status = $request->status;
        $emp_id = $request->emp_id;

//        $status = 'T';
//        $emp_id = 3;


        $user = User::where('user_id', $emp_id)->first();

        if ($status == 'F') {
            $user->user_login_status = 'DISABLE';
            if ($user->save()) {
                return response()->json('yes');
            } else {
                return response()->json('no');
            }
        } else {
            $user->user_login_status = 'ENABLE';
            $user->user_expiry_date =  date('Y-m-d', strtotime($user_expiry));
            if ($user->save()) {
                return response()->json('yes');
            } else {
                return response()->json('no');
            }
        }

    }

    public function change_password()
    {
        return view('change_password');
    }

    public function submit_change_password(Request $request)
    {
        $this->change_password_validation($request);

        $current_password = Auth::User()->user_password;
        if (Hash::check($request->input('old_password'), $current_password)) {

            $user_id = Auth::User()->user_id;
            $obj_user = User::findOrFail($user_id);
            $obj_user->user_password = Hash::make($request->input('password'));
            if ($obj_user->save()) {

                $user = Auth::User();

                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Change Their Password');

                return redirect(route('change_password'))->with('success', 'Successfully Saved');
            } else {
                return redirect(route('change_password'))->with('fail', 'Please Try Again!');
            }
        }
        return redirect(route('change_password'))->with('fail', 'Please Try Again!');

    }

    public function submit_change_password_Api(Request $request)
    {
        $response = (object)array('success' => 0, 'code' => 0, 'message' => '', 'data' => array());

        if (Auth::attempt(['user_username' => $request->username, 'password' => $request->op])) {
            $rules = [
                'np' => ['required', 'min:8', 'regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[${\]}{\}@$!~%_`#*\'"|()}:.;,[+{<>=?&\/^-])[A-Za-z\d${\]}{\}@$!~%_`;#*\'"|()}:.,[+{<>=?&\/^-]{8,}$/'],
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response->code=config('global_variables.NOT_OK');
                $response->message = 'Invalid new Password.';
                return response()->json($response, 200);
            }

            $current_password = Auth::User()->user_password;
            if (Hash::check($request->input('op'), $current_password)) {
                if ($request->input('op') == $request->input('np')) {
                    $response->code=config('global_variables.ALREADY_EXISTS');
                    $response->message = 'You can`t use old password try different password!';
                    return response()->json($response, 200);
                } else {
                    $user_id = Auth::User()->user_id;
                    $obj_user = User::findOrFail($user_id);
                    $obj_user->user_password = Hash::make($request->input('np'));
                    if ($obj_user->save()) {
                        $response->code=config('global_variables.OK');
                        $response->message = 'User password updated!';
                        $response->success = config('global_variables.OK');
                        return response()->json($response, 200);
                    } else {
                        $response->message='Please try again!';
                        return response()->json($response, 200);
                    }
                }
            }
            $response->code=config('global_variables.NOT_VALID');
            $response->message = 'Invalid old password!';
            return response()->json($response, 200);
        } else {
            $response->message='Parameters not found!';
            return response()->json($response, 200);
        }

    }

    public
    function change_password_validation($request)
    {
        return $this->validate($request, [
//            'old_password' => ['required', 'min:8', 'regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[${\]}{\}@$!~%_`#*\'"|()}:.;,[+{<>=?&\/^-])[A-Za-z\d${\]}{\}@$!~%_`;#*\'"|()}:.,[+{<>=?&\/^-]{8,}$/'],
            'old_password' => ['required'],
            'password' => ['required', 'confirmed', 'min:8', 'regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[${\]}{\}@$!~%_`#*\'"|()}:.;,[+{<>=?&\/^-])[A-Za-z\d${\]}{\}@$!~%_`;#*\'"|()}:.,[+{<>=?&\/^-]{8,}$/'],
//            'password_confirmation' => ['required', 'min:8', 'regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[${\]}{\}@$!~%_`#*\'"|()}:.;,[+{<>=?&\/^-])[A-Za-z\d${\]}{\}@$!~%_`;#*\'"|()}:.,[+{<>=?&\/^-]{8,}$/'],
        ]);
    }

    public
    function get_user($user_id)
    {
        $user_role = User::where('user_id', $user_id)->first();

        return $user_role;
    }

    public
    function edit_profile(Request $request)
    {
        $user = Auth::user();

        return view('edit_profile', compact('request', 'user'));
    }


// created function by shahzaib start
    public
    function prfl_wd_actvty(Request $request, $id, $array)
    {
        $array_cus = explode(',', $array);

        $ip = $array_cus[0];
        $browser = str_replace('-', ' ', $array_cus[1]);

        $user_profile = User::where('user_id', $id)->first();

        return view('user_profile.user_profile_show', compact('user_profile', 'ip', 'browser'));
    }

// created function by shahzaib end


//    // created function by shahzaib start
//    public function prfl_wd_actvty(Request $request, $id, $array)
//    {
//        $array_cus = explode(',', $array);
//        $othr_tbl_nme = Crypt::decryptString($array_cus[0]);
//        $othr_tbl_col_prfx = Crypt::decryptString($array_cus[1]);
//
//        $othr_tbl_prfx = 'financials_';
//        $othr_tbl = $othr_tbl_prfx.$othr_tbl_nme;
//
//
//        $query = DB::table($othr_tbl)
//            ->leftJoin('financials_users', 'financials_users.user_id', $othr_tbl.'.'.$othr_tbl_col_prfx.'_createdby');
//
//        $user = $query->where($othr_tbl_col_prfx.'_id', $id)
//            ->select($othr_tbl.'.'.$othr_tbl_col_prfx.'_ip_adrs', $othr_tbl.'.'.$othr_tbl_col_prfx.'_brwsr_info', 'financials_users.user_name', 'financials_users.user_designation', 'financials_users.user_mobile', 'financials_users.user_email', 'financials_users.user_cnic', 'financials_users.user_address')
//            ->first();
//
//
//        return view('user_profile.user_profile_show', compact('user', 'othr_tbl_col_prfx'));
//
//    }
//    // created function by shahzaib end

    public
    function update_profile(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'name' => ['required', 'regex:/^[^-\s][a-zA-Z\s-]+$/'],
        ]);

        $profile = User::where('user_id', $user->user_id)->first();

        $profile->user_name = ucwords($request->name);

        if ($profile->save()) {

            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Their Profile');

            return redirect('edit_profile')->with('success', 'Successfully Saved');
        } else {
            return redirect('edit_profile')->with('fail', 'Failed Try Again!');
        }
    }

    public
    function admin_profile(Request $request)
    {
        $employee = User::where('user_id', $request->employee_id)->first();

        $salary_info = SalaryInfoModel::where('si_user_id', $request->employee_id)->first();

        $salary_ads = SalaryADItemsModel::where('sadi_user_id', $request->employee_id)->get();

        $accounts = $this->get_fourth_level_account(0, 0, 0);

        $groups = AccountGroupModel::where('ag_delete_status', '!=', 1)->orderBy('ag_title', 'ASC')->get();

        $product_groups = ProductGroupModel::where('pg_delete_status', '!=', 1)->orderBy('pg_title', 'ASC')->get();

        $roles = RolesModel::orderBy('user_role_id', 'ASC')->get();

        $modular_groups = ModularGroupModel::where('mg_delete_status', '!=', 1)->orderby('mg_title', 'ASC')->get();//where('mg_id', '!=', 1)->

        $cities = CityModel::orderby('city_name', 'ASC')->get();

        $countries = CountryModel::orderby('c_name', 'ASC')->get();

        $salary_expense_second_head = config('global_variables.salary_expense_second_head');
        $salary_heads = AccountHeadsModel::where('coa_parent', $salary_expense_second_head)->orderBy('coa_id', 'ASC')->get();

        return view('admin_profile', compact('accounts', 'salary_heads', 'groups', 'product_groups', 'roles', 'employee', 'modular_groups', 'cities', 'countries', 'salary_info', 'salary_ads'));
    }

    public
    function update_admin_profile(Request $request)
    {
        $this->validate($request, [
            'employee_id' => ['required', 'numeric'],
        ]);

        $this->employee_validation($request);

        if (isset($request->make_salary_account)) {
            $this->employee_salary_info_validation($request);
        }

        if (isset($request->make_credentials)) {
            $this->validate($request, [
                'username' => ['required', 'string', 'unique:financials_users,user_username,1,user_id,user_have_credentials,1'],
                'email' => ['required', 'confirmed', 'string', 'unique:financials_users,user_email,1,user_id,user_have_credentials,1'],
            ]);
        }

        $employee = User::where('user_id', $request->employee_id)->first();

        $department_id=1;
        DB::beginTransaction();
        $rollBack = false;

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $user = Auth::User();

        $uniqueid = $employee->user_folder;

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $user_salary_person_status = $employee->user_salary_person;
        $user_loan_person_status = $employee->user_loan_person;


        $employee->user_name = ucwords($request->name);
        $employee->user_father_name = ucwords($request->fname);
        $employee->user_mobile = $request->mobile;
        $employee->user_emergency_contact = $request->emergency_contact;
        $employee->user_cnic = $request->cnic;
        $employee->user_family_code = $request->family_code;
        $employee->user_marital_status = $request->marital;
        $employee->user_city = $request->city;
        $employee->user_blood_group = $request->blood_group;
        $employee->user_nationality = $request->nationality;
        $employee->user_religion = $request->religion;
        $employee->user_address = ucfirst($request->address);
        $employee->user_address_2 = ucfirst($request->address2);
        $employee->user_folder = $uniqueid;
        $employee->user_brwsr_info = $brwsr_rslt;
        $employee->user_ip_adrs = $ip_rslt;
        $employee->user_update_datetime = Carbon::now()->toDateTimeString();

        if (!empty($request->pimage)) {
            $save_image = new SaveImageController();

            $common_path = config('global_variables.common_path');
            $employee_path = config('global_variables.employee_path');

            // Handle Image
            $fileNameToStore = $save_image->SaveImage($request, 'pimage', $request->folder, $employee_path, 'Profile_Image');

            $employee->user_profilepic = $common_path . $fileNameToStore;
        }


        if (isset($request->make_salary_account)) {
            $employee->user_salary_person = 1;
        }


        if (isset($request->make_credentials)) {
            $employee->user_have_credentials = 1;
            $employee->user_username = $request->username;
            $employee->user_email = $request->email;
        }

        if ($employee->save()) {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Employee With Id: ' . $employee->user_id . ' And Name: ' . $employee->user_name);

            $employee_id = $employee->user_id;
            $employee_name = $employee->user_name;

        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Please Try Again!');
        }


        if (isset($request->make_salary_account)) {

            ////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////// Salary Info //////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////////////////
            if ($user_salary_person_status == 1) {
                ////////////////////////////////////////////////////////////////////////////////////////////
                ///////////////////////////////////// Loan Account //////////////////////////////////////
                ////////////////////////////////////////////////////////////////////////////////////////////
                $loan_account = '';

                if ($user_loan_person_status == 0) {

                    if (isset($request->make_loan_account)) {
                        $account_registerations_controller = new AccountRegisterationsController();
                        $account = new AccountRegisterationModel();
                        $loan_account = new AccountRegisterationModel();

                        $loan_account = $this->AssignAccountValues(config('global_variables.loan_head'), 'Loan - ' . $employee_name, $loan_account, $employee_id, $department_id);

                        if (!$loan_account->save()) {
                            $rollBack = true;
                            DB::rollBack();
                            return redirect()->back()->with('fail', 'Please Try Again!');
                        } else {
                            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $loan_account->account_uid . ' And Name: '
                                . $loan_account->account_name);
                        }

//                    $account->account_link_uid = $loan_account->account_uid;
//
//                    if (!$account->save()) {
//                        $rollBack = true;
//                        DB::rollBack();
//                        return redirect()->back()->with('fail', 'Please Try Again!');
//                    }

                        $loan_account->account_link_uid = $account->account_uid;

                        if (!$loan_account->save()) {
                            $rollBack = true;
                            DB::rollBack();
                            return redirect()->back()->with('fail', 'Please Try Again!');
                        }


                        $account_balance = new BalancesModel();

                        $account_balance = $account_registerations_controller->add_balance($account_balance, $loan_account->account_uid, $loan_account->account_name);

                        if (!$account_balance->save()) {
                            $rollBack = true;
                            DB::rollBack();
                            return redirect()->back()->with('fail', 'Please Try Again!');
                        }
                        $salary_info = SalaryInfoModel::where('si_user_id', $employee_id)->first();
                        $salary_info->si_loan_account_uid = $loan_account->account_uid;
                        $salary_info->si_update_datetime = Carbon::now()->toDateTimeString();

                        if ($salary_info->save()) {

                            $salary_info_id = $salary_info->si_id;

                            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Employee Salary Info With Id: ' . $employee->user_id . ' And Name: ' . $employee->user_name);
                        } else {
                            $rollBack = true;
                            DB::rollBack();
                            return redirect('employee_list')->with('fail', 'Please Try Again!');
                        }
                    }
                }

                /////////// start mustafa update account name////////////

                $exp_acc = AccountRegisterationModel::where('account_employee_id', '=', $request->employee_id)->where('account_parent_code', '=', 41412)->first();
                $adv_acc = AccountRegisterationModel::where('account_employee_id', '=', $request->employee_id)->where('account_parent_code', '=', 11014)->first();
                $loan_acc = AccountRegisterationModel::where('account_employee_id', '=', $request->employee_id)->where('account_parent_code', '=', 11019)->first();

                $exp_acc->account_name = 'Exp - ' . $request->name;
                $exp_acc->account_department_id = $department_id;
                $exp_acc->save();

                $adv_acc->account_name = 'Adv - ' . $request->name;
                $adv_acc->account_department_id = $department_id;
                $adv_acc->save();
                if (isset($request->make_loan_account)) {
                    $loan_acc->account_name = 'Loan - ' . $request->name;
//                    $loan_acc->account_department_id = $department_id;
                    $loan_acc->save();
                }

                /////////// end mustafa ////////////
                $salary_info = SalaryInfoModel::where('si_user_id', $employee_id)->first();
            }
            else if ($user_salary_person_status == 0) {

                ////////////////////////////////////////////////////////////////////////////////////////////
                ///////////////////////////////////// Expense Account //////////////////////////////////////
                ////////////////////////////////////////////////////////////////////////////////////////////

                $account_registerations_controller = new AccountRegisterationsController();

                $account = new AccountRegisterationModel();
                $account = $this->AssignAccountValues(config('global_variables.new_salary_expense_account'), 'Exp - ' . $employee_name, $account, $employee_id, $department_id);

                if (!$account->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Please Try Again!');
                }

                $account_uid = $account->account_uid;
                $account_name = $account->account_name;

                $account_balance = new BalancesModel();

                $account_balance = $account_registerations_controller->add_balance($account_balance, $account_uid, $account_name);

                if (!$account_balance->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Please Try Again!');
                }

                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $account_uid . ' And Name: ' . $account_name);


                ////////////////////////////////////////////////////////////////////////////////////////////
                ///////////////////////////////////// Advance Account //////////////////////////////////////
                ////////////////////////////////////////////////////////////////////////////////////////////

                $advance_salary_account = new AccountRegisterationModel();

                $advance_salary_account = $this->AssignAccountValues(config('global_variables.advance_salary_head'), 'Adv - ' . $employee_name, $advance_salary_account, $employee_id, $department_id);

                if (!$advance_salary_account->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Please Try Again!');
                } else {
                    $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $advance_salary_account->account_uid . ' And Name: '
                        . $advance_salary_account->account_name);
                }

                $account->account_link_uid = $advance_salary_account->account_uid;

                if (!$account->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Please Try Again!');
                }

                $advance_salary_account->account_link_uid = $account->account_uid;

                if (!$advance_salary_account->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Please Try Again!');
                }


                $account_balance = new BalancesModel();

                $account_balance = $account_registerations_controller->add_balance($account_balance, $advance_salary_account->account_uid, $advance_salary_account->account_name);

                if (!$account_balance->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Please Try Again!');
                }
                ////////////////////////////////////////////////////////////////////////////////////////////
                ///////////////////////////////////// Loan Account //////////////////////////////////////
                ////////////////////////////////////////////////////////////////////////////////////////////
                $loan_account = '';
                if (isset($request->make_loan_account)) {
                    $loan_account = new AccountRegisterationModel();

                    $loan_account = $this->AssignAccountValues(config('global_variables.loan_head'), 'Loan - ' . $employee_name, $loan_account, $employee_id, $department_id);

                    if (!$loan_account->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Please Try Again!');
                    } else {
                        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $loan_account->account_uid . ' And Name: '
                            . $loan_account->account_name);
                    }

                    $account->account_link_uid = $loan_account->account_uid;

                    if (!$account->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Please Try Again!');
                    }

                    $loan_account->account_link_uid = $account->account_uid;

                    if (!$loan_account->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Please Try Again!');
                    }


                    $account_balance = new BalancesModel();

                    $account_balance = $account_registerations_controller->add_balance($account_balance, $loan_account->account_uid, $loan_account->account_name);

                    if (!$account_balance->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Please Try Again!');
                    }
                }
                ////////////////////////////////////////////////////////////////////////////////////////////
                ///////////////////////////////////// Salary Info //////////////////////////////////////
                ////////////////////////////////////////////////////////////////////////////////////////////

                $loan_account_uid = '';
                if ($loan_account != '') {
                    $loan_account_uid = $loan_account->account_uid;
                }

                $salary_info = new SalaryInfoModel();

                $salary_info->si_user_id = $employee_id;
                $salary_info->si_advance_salary_account_uid = $advance_salary_account->account_uid;
                $salary_info->si_expense_salary_account_uid = $account->account_uid;
                $salary_info->si_loan_account_uid = $loan_account_uid;
                $salary_info->si_day_end_id = $day_end->de_id;
                $salary_info->si_day_end_date = $day_end->de_datetime;
                $salary_info->si_datetime = Carbon::now()->toDateTimeString();
            }
            else {
//
//
//                /////////// start mustafa ////////////
//
//                $exp_acc = AccountRegisterationModel::where('account_employee_id', '=', $request->employee_id)->where('account_parent_code', '=', 41412)->first();
//                $adv_acc = AccountRegisterationModel::where('account_employee_id', '=', $request->employee_id)->where('account_parent_code', '=', 11014)->first();
//                $loan_acc = AccountRegisterationModel::where('account_employee_id', '=', $request->employee_id)->where('account_parent_code', '=', 11019)->first();
//
//                $exp_acc->account_name = 'Exp - ' . $request->name;
//                $exp_acc->account_department_id = $department_id;
//                $exp_acc->save();
//
//                $adv_acc->account_name = 'Adv - ' . $request->name;
//                $adv_acc->account_department_id = $department_id;
//                $adv_acc->save();
//                if (isset($request->make_salary_account)) {
//                    $loan_acc->account_name = 'Loan - ' . $request->name;
////                    $loan_acc->account_department_id = $department_id;
//                    $loan_acc->save();
//                }
//
//                /////////// end mustafa ////////////

            }


            $salary_info->si_basic_salary = empty($request->basic_salary) ? 0 : $request->basic_salary;
            $salary_info->si_basic_salary_period = $request->salary_period;
            $salary_info->si_working_hours_per_day = empty($request->hour_per_day) ? 0 : $request->hour_per_day;
            $salary_info->si_off_days = empty($request->holidays) ? '' : implode(',', $request->holidays);
            $salary_info->si_update_datetime = Carbon::now()->toDateTimeString();

            if ($salary_info->save()) {

                $salary_info_id = $salary_info->si_id;

                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Employee Salary Info With Id: ' . $employee->user_id . ' And Name: ' . $employee->user_name);
            } else {
                $rollBack = true;
                DB::rollBack();
                return redirect('employee_list')->with('fail', 'Please Try Again!');
            }

            ////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////// Salary Items //////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////////////////

            if (isset($request->accounts_array) && !empty($request->accounts_array)) {

                $delete_exists = SalaryADItemsModel::where('sadi_user_id', $employee_id)->exists();

                if ($delete_exists) {
                    $delete = SalaryADItemsModel::where('sadi_user_id', $employee_id)->delete();

                    if (!$delete) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect('employee_list')->with('fail', 'Please Try Again!');
                    }
                }


                $salary_items = $this->AssignSalaryItemsValues($request->accounts_array, $salary_info_id, $employee_id);

                if (DB::table('financials_salary_ad_items')->insert($salary_items)) {
                    $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Employee Salary Items With Id: ' . $employee->user_id . ' And Name: ' . $employee->user_name);
                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect('employee_list')->with('fail', 'Please Try Again!');
                }
            }
        }

        ////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////// Check Account exist or not ///////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////////

        if ($employee->user_teller_cash_account_uid == 0 && $employee->user_teller_wic_account_uid == 0) {

            $account_registerations_controller = new AccountRegisterationsController();

            if ($request->role == config('global_variables.teller_account_id')) {

                ////////////////////////////////////////////////////////////////////////////////////////////
                ///////////////////////////////////// Cash Account ///////////////////////////////////////
                ////////////////////////////////////////////////////////////////////////////////////////////

                $account = new AccountRegisterationModel();
                $account = $this->AssignAccountValues(config('global_variables.cash'), $employee_name . ' - CASH IN HAND', $account, $employee_id, $department_id);

                if (!$account->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Please Try Again!');
                }

                $account_uid = $account->account_uid;
                $account_name = $account->account_name;


                $employee->user_teller_cash_account_uid = $account_uid;

                if (!$employee->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Please Try Again!');
                }


                $account_balance = new BalancesModel();

                $account_balance = $account_registerations_controller->add_balance($account_balance, $account_uid, $account_name);

                if (!$account_balance->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Please Try Again!');
                }

                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $account_uid . ' And Name: ' . $account_name);


////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Walk in customer /////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


                $parent_account = config('global_variables.walk_in_customer_head');
                $prefix_name = ' - WIC';


                $account = new AccountRegisterationModel();
                $account = $this->AssignAccountValues($parent_account, $employee_name . $prefix_name, $account, $employee_id, $department_id);

                if (!$account->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Please Try Again!');
                }

                $account_uid = $account->account_uid;
                $account_name = $account->account_name;


                $employee->user_teller_wic_account_uid = $account_uid;

                if (!$employee->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Please Try Again!');
                }


                $account_balance = new BalancesModel();

                $account_balance = $account_registerations_controller->add_balance($account_balance, $account_uid, $account_name);

                if (!$account_balance->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Please Try Again!');
                }

                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $account_uid . ' And Name: ' . $account_name);
            }
        }

        if ($employee->user_purchaser_cash_account_uid == 0 && $employee->user_purchaser_wic_account_uid == 0) {

            $account_registerations_controller = new AccountRegisterationsController();

            if ($request->role == config('global_variables.purchaser_role_id')) {

                ////////////////////////////////////////////////////////////////////////////////////////////
                ///////////////////////////////////// Cash Account /////////////////////////////////////////
                ////////////////////////////////////////////////////////////////////////////////////////////

                $account = new AccountRegisterationModel();
                $account = $this->AssignAccountValues(config('global_variables.cash'), $employee_name . ' - CASH IN HAND', $account, $employee_id, $department_id);

                if (!$account->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Please Try Again!');
                }

                $account_uid = $account->account_uid;
                $account_name = $account->account_name;


                $employee->user_purchaser_cash_account_uid = $account_uid;

                if (!$employee->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Please Try Again!');
                }


                $account_balance = new BalancesModel();

                $account_balance = $account_registerations_controller->add_balance($account_balance, $account_uid, $account_name);

                if (!$account_balance->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Please Try Again!');
                }

                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $account_uid . ' And Name: ' . $account_name);


                ////////////////////////////////////////////////////////////////////////////////////////////
                ///////////////////////////////////// Purchaser Account ////////////////////////////////////
                ////////////////////////////////////////////////////////////////////////////////////////////


                $parent_account = config('global_variables.purchaser_account_head');
                $prefix_name = ' - Purchaser';


                $account = new AccountRegisterationModel();
                $account = $this->AssignAccountValues($parent_account, $employee_name . $prefix_name, $account, $employee_id, $department_id);

                if (!$account->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Please Try Again!');
                }

                $account_uid = $account->account_uid;
                $account_name = $account->account_name;


                $employee->user_purchaser_wic_account_uid = $account_uid;

                if (!$employee->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Please Try Again!');
                }


                $account_balance = new BalancesModel();

                $account_balance = $account_registerations_controller->add_balance($account_balance, $account_uid, $account_name);

                if (!$account_balance->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Please Try Again!');
                }

                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $account_uid . ' And Name: ' . $account_name);
            }
        }


        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {
            DB::commit();

//            if ($employee->user_have_credentials == 1) {
//                Mail::to($employee->user_email)->send(new PasswordMail($password, $employee->user_username));
//            }

            return redirect()->back()->with('success', 'Successfully Saved');
        }
    }

    public
    function employee_validation($request)
    {
        return $this->validate($request, [
            'name' => ['required', 'regex:/^[^-\s][a-zA-Z\s-]+$/'],
            'fname' => ['required', 'regex:/^[^-\s][a-zA-Z\s-]+$/'],
            'mobile' => ['required', 'regex:/^((\+92)|(0092))-?3\d{2}-?\d{7}$|^03\d{2}-?\d{7}$/'],
            'emergency_contact' => ['nullable', 'regex:/^((\+92)|(0092))-?3\d{2}-?\d{7}$|^03\d{2}-?\d{7}$/'],
            'cnic' => ['nullable', 'regex:/^\d{5}-\d{7}-\d$|^\d{13}$/'],
            'family_code' => ['nullable', 'string'],
            'marital' => ['required', 'numeric'],
            'city' => ['nullable', 'numeric'],
            'blood_group' => ['nullable', 'string'],
            'nationality' => ['nullable', 'numeric'],
            'religion' => ['required', 'numeric'],
            'address' => ['nullable', 'string'],
            'address2' => ['nullable', 'string'],
            'pimage' => 'nullable|image|mimes:jpeg,jpg,png|max:1999',
        ], [
            'fname.required' => 'Father Name is required',
            'fname.regex' => 'Father Name has invalid format',
        ]);
    }

    public
    function employee_salary_info_validation($request)
    {
        return $this->validate($request, [
//            'parent_head' => ['required', 'numeric'],
            'basic_salary' => ['required', 'numeric'],
            'salary_period' => ['required', 'numeric'],
            'hour_per_day' => ['required', 'numeric'],
            'holidays' => ['nullable', 'array'],
            'accounts_array' => ['nullable', 'string'],
        ]);
    }
    protected function AssignAccountValues($parent_code, $account_name, $account, $employee_id, $department_id)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $account_reg = new AccountRegisterationsController();

        $check_uid = AccountRegisterationModel::where('account_parent_code', $parent_code)->orderBy('account_uid', 'DESC')->pluck('account_uid')->first();

        //dd($check_uid);
        if ($check_uid) {
            $check_uid = $account_reg->generate_account_code($parent_code, $check_uid);

            $uid = $check_uid;
        } else {
            $check_uid = $check_uid + 1;
            $uid = $parent_code . $check_uid;
        }

        $account->account_parent_code = $parent_code;
        $account->account_name = ucwords($account_name);
        $account->account_balance = 0;
        $account->account_remarks = '';
        $account->account_uid = $uid;
        $account->account_group_id = 1;
        $account->account_createdby = $user->user_id;
        $account->account_day_end_id = $day_end->de_id;
        $account->account_day_end_date = $day_end->de_datetime;
        $account->account_employee_id = $employee_id;
        $account->account_brwsr_info = $brwsr_rslt;
        $account->account_ip_adrs = $ip_rslt;
        $account->account_update_datetime = Carbon::now();
        $account->account_department_id = $department_id;


        return $account;
    }
}
