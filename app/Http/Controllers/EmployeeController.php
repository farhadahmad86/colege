<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Wizard\WizardController;
use App\Imports\ExcelDataImport;
use App\Mail\PasswordMail;
use App\Mail\UserCredentialEmail;
use App\Models\AccountGroupModel;
use App\Models\AccountHeadsModel;
use App\Models\AccountRegisterationModel;
use App\Models\AllowanceDeductionModel;
use App\Models\BalancesModel;
use App\Models\CityModel;
use App\Models\College\Branch;
use App\Models\CountryModel;
use App\Models\Department;
use App\Models\DesignationModel;
use App\Models\PackagesModel;
use App\Models\ProductGroupModel;
use App\Models\RolesModel;
use App\Models\SalaryADItemsModel;
use App\Models\SalaryInfoModel;
use App\Models\Utility;
use App\User;
use Auth;
use Illuminate\Support\Facades\Mail;
use PDF;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class EmployeeController extends EmployeeForm\EmployeeController
{
    public function add_employee()
    {
        $user = Auth::user();

        $employee = User::find(\DB::table('financials_users')->where('user_clg_id', $user->user_clg_id)->where('user_designation', '!=', 1)->max('user_id'));

        $salary_info = SalaryInfoModel::where('si_clg_id', $user->user_clg_id)->where('si_user_id', $employee->user_id)->first();

        $branches = Branch::where('branch_clg_id', $user->user_clg_id)->get();

        //        nabeel
        $departments = Department::where('dep_clg_id', $user->user_clg_id)->where('dep_delete_status', '!=', 1)->where('dep_disabled', '!=', 1)
            //->where('dep_branch_id', '=', Session::get('branch_id'))
            ->orderBy('dep_title', 'ASC')
            ->get();
        $designations = DesignationModel::where('desig_clg_id', $user->user_clg_id)->where('desig_id', '!=', 1)->where('desig_delete_status', '!=', 1)->where('desig_disabled', '!=', 1)->orderBy('desig_name', 'ASC')
            ->get();

        $accounts = AccountRegisterationModel::where('account_parent_code', 'like', '21015%')->select('account_uid', 'account_name')->get();

        $groups = AccountGroupModel::where('ag_clg_id', $user->user_clg_id)->where('ag_delete_status', '!=', 1)->where('ag_disabled', '!=', 1)->orderBy('ag_title', 'ASC')->get();

        $product_groups = ProductGroupModel::where('pg_clg_id', $user->user_clg_id)->where('pg_delete_status', '!=', 1)->where('pg_disabled', '!=', 1)->orderBy('pg_title', 'ASC')->get();

        $roles = RolesModel::orderBy('user_role_id', 'ASC')->get();

        //        $modular_groups = ModularGroupModel::where('mg_delete_status', '!=', 1)->where('mg_disabled', '!=', 1)->orderby('mg_title', 'ASC')->get();//where('mg_id', '!=', 1)->
        $modular_groups = Role::where('type', 2)->where('clg_id', $user->user_clg_id)->where('created_by', '!=', 0)->where('delete_status', '!=', 1)->where('disabled', '!=', 1)
            ->orderby('name', 'ASC')
            ->get();

        $cities = CityModel::orderby('city_name', 'ASC')->get();

        $countries = CountryModel::orderby('c_name', 'ASC')->get();

        $salary_expense_second_head = config('global_variables.salary_expense_second_head');

        $salary_heads = AccountHeadsModel::where('coa_clg_id', $user->user_clg_id)->where('coa_parent', $salary_expense_second_head)->orderBy('coa_id', 'ASC')->get();

        return view('add_employee', compact('departments', 'accounts', 'groups', 'roles', 'modular_groups', 'cities', 'countries', 'product_groups', 'salary_heads', 'salary_info', 'employee', 'branches', 'designations'));
    }

    public function submit_employee_excel(Request $request)
    {

        $rules = [
            'add_employee_excel' => 'required|mimes:xlsx,xls,csv|max:5000',
        ];

        $messages = [
            'add_employee_excel.max' => "Your File size too long.",
            'add_employee_excel.required' => "Please select your Employee Excel Sheet.",
        ];

        $validator = $this->validate($request, $rules, $messages);

        if ($request->hasFile('add_employee_excel')) {

            //            dd($request->add_employee_excel);
            //            $dateTime = date('Ymd_His');
            //            $file = $request->file('add_employee_excel');
            //            $fileName = $dateTime . '-' . $file->getClientOriginalName();
            //            $savePath = public_path('/uploads/'.config('global_variables.excel_storage_folder_name'));
            //            $file->move($savePath, $fileName);
            //            $data = Excel::load($path)->get();


            $path = $request->file('add_employee_excel');
            $data = Excel::toArray(new ExcelDataImport, $path);

            $excelData = json_decode(json_encode($data), FALSE);
            //            foreach ($data as $key => $value) {
            foreach ($excelData as $rows) {
                foreach ($rows as $row) {
                    $rowData = (array)$row;
                    $request->merge($rowData);
                    $this->excel_employee_validation($request);

                    $rollBack = self::excel_form_employee($row);

                    if ($rollBack) {
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed Try Again');
                    } else {
                        DB::commit();
                    }
                }
            }
            //            }

            return redirect()->back()->with(['success' => 'File Uploaded successfully.']);
        } else {
            return redirect()->back()->with(['errors' => $validator]);
        }
    }

    public function submit_employee(Request $request)
    {

        return self::simple_form_employee($request);
    }

    public function resend_employee_password_email(Request $request)
    {
        $password = Utility::uniqidReal();
        $user = Auth::user();
        $employee = User::where('user_clg_id', $user->user_clg_id)->findOrFail($request->employee_id);
        $employee->user_password = Hash::make($password);
        $employee->save();

//        $this->SendPasswordMail($employee->user_email, $employee->user_username, $password);




        Mail::to($employee->user_email)->send(new UserCredentialEmail($password, $employee->user_username));

        return redirect()->back()->with('success', 'New Password sent to your Email address.');
    }

    public function check_employee_username(Request $request)
    {
        $username = $request->username;
        $isUserExist = User::where('user_username', $username)->exists();
        $isUserExist = $isUserExist > 0 ? 'yes' : 'no';
        return response()->json($isUserExist);
    }

    public function check_employee_email(Request $request)
    {
        $email = $request->email;
        $isUserExist = User::where('user_email', $email)->exists();
        $isUserExist = $isUserExist > 0 ? 'yes' : 'no';
        return response()->json($isUserExist);
    }

    // update code by shahzaib start
    public function employee_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $accounts = AccountRegisterationModel::where('account_clg_id', $user->user_clg_id)->where('account_parent_code', config('global_variables.salaries_account'))->orderBy('account_uid', 'ASC')
            ->get();
        $groups = AccountGroupModel::where('ag_clg_id', $user->user_clg_id)->orderBy('ag_title', 'ASC')->get();
        $roles = RolesModel::orderBy('user_role_id', 'ASC')->get();
        //        $modular_groups = ModularGroupModel::where('mg_id', '!=', 1)->orderby('mg_title', 'ASC')->get();
        $modular_groups = Role::where('delete_status', '!=', 1)->where('disabled', '!=', 1)->orderby('name', 'ASC')->get();
        $product_groups = ProductGroupModel::where('pg_clg_id', $user->user_clg_id)->where('pg_delete_status', '!=', 1)->where('pg_disabled', '!=', 1)->orderBy('pg_title', 'ASC')->get();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_salary_account = (!isset($request->salary_account) && empty($request->salary_account)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->salary_account;
        $search_group = (!isset($request->group) && empty($request->group)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->group;
        $search_modular_group = (!isset($request->modular_group) && empty($request->modular_group)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->modular_group;
        $search_user_type = (!isset($request->user_type) && empty($request->user_type)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->user_type;
        $search_role = (!isset($request->role) && empty($request->role)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->role;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $search_product_group = (isset($request->product_group) && !empty($request->product_group)) ? $request->product_group : '';


        $prnt_page_dir = 'print.employee_list.employee_list';
        $pge_title = 'Employee List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_salary_account, $search_group, $search_modular_group, $search_user_type, $search_role);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        //        $query = User::query()
        $query = DB::table('financials_users as usrs')
            ->leftJoin('financials_departments as f_dep', 'f_dep.dep_id', 'usrs.user_department_id')
            ->leftJoin('financials_account_group', 'financials_account_group.ag_id', 'usrs.user_account_reporting_group_ids')
            ->leftJoin('financials_users as usr_crtd_info', 'usr_crtd_info.user_id', 'usrs.user_createdby')
            ->leftJoin('financials_designation', 'financials_designation.desig_id', 'usrs.user_designation')
            ->where('usrs.user_status', '=', 'Employee');
        if ($user->user_id != 1) {
            $query->whereNotIn('usrs.user_designation', [0, 1])
                ->where('usrs.user_clg_id', $user->user_clg_id);
        }
        // dd($query);
        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('usrs.user_name', 'like', '%' . $search . '%')
                    ->orWhere('usrs.user_username', 'like', '%' . $search . '%')
                    ->orWhere('usrs.user_email', 'like', '%' . $search . '%')
                    ->orWhere('usrs.user_mobile', 'like', '%' . $search . '%')
                    ->orWhere('usrs.user_cnic', 'like', '%' . $search . '%')
                    ->orWhere('usrs.user_address', 'like', '%' . $search . '%')
                    ->orWhere('usr_crtd_info.user_designation', 'like', '%' . $search . '%')
                    ->orWhere('usr_crtd_info.user_name', 'like', '%' . $search . '%')
                    ->orWhere('usr_crtd_info.user_username', 'like', '%' . $search . '%')
                    ->orWhere('ag_title', 'like', '%' . $search . '%');
            });
        }

        if (!empty($search_salary_account)) {
            $query->where('usrs.user_account_uid', $search_salary_account);
        }

        if (!empty($search_group)) {
            $query->whereRaw('FIND_IN_SET(' . $search_group . ',usrs.user_account_reporting_group_ids)');
        }

        if (!empty($search_role)) {
            $query->where('usrs.user_role_id', $search_role);
        }

        if (!empty($search_modular_group)) {
            $query->where('usrs.user_modular_group_id', $search_modular_group);
        }

        if (!empty($search_user_type)) {
            $query->where('usrs.user_level', $search_user_type);
        }

        if (isset($search_by_user) && !empty($search_by_user)) {
            $query->where('usrs.user_createdby', $search_by_user);
        }

        if (isset($search_product_group) && !empty($search_product_group)) {
            $query->whereRaw('FIND_IN_SET(' . $search_product_group . ',usrs.user_product_reporting_group_ids)');
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1) {
            $query->where('usrs.user_delete_status', '=', 1);
        } else {
            $query->where('usrs.user_delete_status', '!=', 1);
        }

        $datas = $query
            //            ->where('usrs.user_id', '!=', 1)
            //            ->where('usrs.user_id', '!=', 2)
            //            ->where('usrs.user_delete_status', '!=', 1)
            ->select('usrs.*', 'financials_designation.desig_name', 'usr_crtd_info.user_name as usr_crtd', 'usr_crtd_info.user_designation as usr_crtd_desig', 'financials_account_group.ag_title', 'f_dep.*')
            ->orderBy('usrs.user_id', 'DESC')
            ->paginate($pagination_number);

        $employee = User::where('user_clg_id', $user->user_clg_id)->where('user_id', '!=', 1)->where('user_id', '!=', 2)
            ->where('user_delete_status', '!=', 1)
            ->where('user_status', '=', 'Employee')
            ->orderBy('user_name', 'ASC')->pluck('user_name')->all();


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed' => TRUE,
                ]
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('employee_list', compact('datas', 'search', 'employee', 'accounts', 'groups', 'roles', 'modular_groups', 'search_salary_account', 'search_group', 'search_role', 'search_modular_group', 'search_user_type', 'product_groups', 'search_product_group', 'restore_list'));
        }
    }

    // Mark As Teacher By Farhad
    public function mark_teacher(Request $request, $array = null, $str = null)
    {

        $user = Auth::user();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $department_id = (!isset($request->department_id) && empty($request->department_id)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->department_id;
        $teacher = (!isset($request->teacher) && empty($request->teacher)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->teacher;


        $prnt_page_dir = 'print.employee_list.employee_list';
        $pge_title = 'Employee List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $department_id, $teacher,$search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        //        $query = User::query()
        $query = DB::table('financials_users as usrs')
            ->leftJoin('financials_departments as f_dep', 'f_dep.dep_id', 'usrs.user_department_id')
            ->leftJoin('financials_account_group', 'financials_account_group.ag_id', 'usrs.user_account_reporting_group_ids')
            ->leftJoin('financials_users as usr_crtd_info', 'usr_crtd_info.user_id', 'usrs.user_createdby')
            ->leftJoin('financials_designation', 'financials_designation.desig_id', 'usrs.user_designation', 'usrs.user_designation', 'usrs.user_designation')
            ->where('usrs.user_status', '=', 'Employee');
        if ($user->user_id != 1) {
            $query->where('usrs.user_designation', '!=', 1)
                ->where('usrs.user_clg_id', $user->user_clg_id);
        }
        // dd($query);
        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('usrs.user_name', 'like', '%' . $search . '%')
                    ->orWhere('usrs.user_father_name', 'like', '%' . $search . '%')
                    ->orWhere('usrs.user_mobile', 'like', '%' . $search . '%')
                    ->orWhere('usrs.user_cnic', 'like', '%' . $search . '%')
                    ->orWhere('usrs.user_department_id', 'like', '%' . $search . '%');
            });
        }
        if (!empty($department_id)) {
            $query->where('usrs.user_department_id', $department_id);
        }
        if (!empty($teacher)) {
            $query->where('usrs.user_mark', $teacher);
        }
        $restore_list = $request->restore_list;
        if ($restore_list == 1) {
            $query->where('usrs.user_delete_status', '=', 1);
        } else {
            $query->where('usrs.user_delete_status', '!=', 1);
        }
        if (!empty($search_year)) {
            $query->where('usrs.user_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('usrs.user_year_id', '=', $search_year);
        }
        $datas = $query
            //            ->where('usrs.user_id', '!=', 1)
            //            ->where('usrs.user_id', '!=', 2)
            //            ->where('usrs.user_delete_status', '!=', 1)
            ->select('usrs.*', 'financials_designation.desig_name', 'usr_crtd_info.user_name as usr_crtd', 'usr_crtd_info.user_designation as usr_crtd_desig', 'financials_account_group.ag_title', 'f_dep.*')
            ->orderBy('usrs.user_id', 'DESC')
            ->paginate($pagination_number);

        $employee = User::where('user_clg_id', $user->user_clg_id)
            ->where('user_id', '!=', 1)
            ->where('user_id', '!=', 2)
            ->where('user_delete_status', '!=', 1)
            ->where('user_status', '=', 'Employee')
            ->orderBy('user_name', 'ASC')->pluck('user_name')
            ->all();
        // dd($employee);
        $departments = Department::where('dep_clg_id', $user->user_clg_id)
            ->where('dep_delete_status', '!=', 1)->where('dep_disabled', '!=', 1)
            ->orderBy('dep_title', 'ASC')
            ->get();

        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed' => TRUE,
                ]
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('collegeViews.Mark_as_teacher.mark_teacher', compact('datas','search_year', 'search', 'employee', 'departments', 'restore_list'));
        }
    }

    // update code by shahzaib end

    public function edit_employee(Request $request)
    {
        $user = Auth::user();
        $departments = Department::where('dep_clg_id', $user->user_clg_id)->where('dep_delete_status', '!=', 1)->where('dep_disabled', '!=', 1)
            //->where('dep_branch_id', '=', Session::get('branch_id'))
            ->get();
        //        $employee = User::where('user_id', $request->employee_id)->first();
        //        $setParentHead=null;
        //        $salary_info = DB::table('financials_salary_info')
        //            ->where('si_user_id', $request->employee_id)
        //            ->first();
        //
        //        if ($salary_info != null) {
        //            $getParentHead = DB::table('financials_accounts')
        //                ->where('account_uid', $salary_info->si_expense_salary_account_uid)
        //                ->where('account_employee_id', $request->employee_id)
        //                ->select('account_parent_code')
        //                ->first();
        //dd($getParentHead);
        //            $setParentHead = DB::table('financials_coa_heads')
        //                ->where('coa_code', $getParentHead->account_parent_code)
        //                ->select('coa_head_name', 'coa_code')
        //                ->first();
        //        }
        //
        //        $salary_ads = SalaryADItemsModel::where('sadi_user_id', $request->employee_id)->get();
        //
        //        $accounts = $this->get_fourth_level_account(0, 0, 0);
        //
        //        $groups = AccountGroupModel::where('ag_delete_status', '!=', 1)->where('ag_disabled', '!=', 1)->orderBy('ag_title', 'ASC')->get();
        //
        //        $product_groups = ProductGroupModel::where('pg_delete_status', '!=', 1)->where('pg_disabled', '!=', 1)->orderBy('pg_title', 'ASC')->get();
        //
        //        $roles = RolesModel::orderBy('user_role_id', 'ASC')->get();
        //
        //        $modular_groups = ModularGroupModel::where('mg_delete_status', '!=', 1)->where('mg_disabled', '!=', 1)->orderby('mg_title', 'ASC')->get();//where('mg_id', '!=', 1)->
        //
        //        $cities = CityModel::orderby('city_name', 'ASC')->get();
        //
        //        $countries = CountryModel::orderby('c_name', 'ASC')->get();
        //
        //        $salary_expense_second_head = config('global_variables.salary_expense_second_head');
        //        $salary_heads = AccountHeadsModel::where('coa_parent', $salary_expense_second_head)->orderBy('coa_id', 'ASC')->get();
        $employee = User::where('user_clg_id', $user->user_clg_id)->where('user_id', $request->employee_id)->first();
        $salary_info = SalaryInfoModel::where('si_clg_id', $user->user_clg_id)->where('si_user_id', $request->employee_id)->first();
        $salary_ads = SalaryADItemsModel::where('sadi_clg_id', $user->user_clg_id)->where('sadi_user_id', $request->employee_id)->get();

        $accounts = AccountRegisterationModel::where('account_parent_code', 'like', '21015%')->select('account_uid', 'account_name')->get();
        $groups = AccountGroupModel::where('ag_clg_id', $user->user_clg_id)->where('ag_delete_status', '!=', 1)->where('ag_disabled', '!=', 1)->orderBy('ag_title', 'ASC')->get();
        $product_groups = ProductGroupModel::where('pg_clg_id', $user->user_clg_id)->where('pg_delete_status', '!=', 1)->where('pg_disabled', '!=', 1)->orderBy('pg_title', 'ASC')->get();
        $roles = RolesModel::orderBy('user_role_id', 'ASC')->get();
        //        $modular_groups = ModularGroupModel::where('mg_delete_status', '!=', 1)->where('mg_disabled', '!=', 1)->orderby('mg_title', 'ASC')->get();//where('mg_id', '!=', 1)->
        $modular_groups = Role::where('type', 2)->where('clg_id', $user->user_clg_id)->where('created_by', '!=', 0)->where('delete_status', '!=', 1)->where('disabled', '!=', 1)->orderby('name', 'ASC')->get();

        $cities = CityModel::orderby('city_name', 'ASC')->get();
        $countries = CountryModel::orderby('c_name', 'ASC')->get();
        $salary_expense_second_head = config('global_variables.salary_expense_second_head');
        $salary_heads = AccountHeadsModel::where('coa_clg_id', $user->user_clg_id)->where('coa_parent', $salary_expense_second_head)->orderBy('coa_id', 'ASC')->get();
        $group_id = AccountRegisterationModel::where('account_clg_id', $user->user_clg_id)->where('account_employee_id', $request->employee_id)->pluck('account_group_id')->first();

        $designations = DesignationModel::where('desig_clg_id', $user->user_clg_id)->where('desig_id', '!=', 1)->where('desig_delete_status', '!=', 1)->where('desig_disabled', '!=', 1)->orderBy('desig_name', 'ASC')
            ->get();
        $allowance_deduction = AllowanceDeductionModel::where('ad_clg_id', $user->user_clg_id)->where('ad_employee_id', $request->employee_id)->get();

        $branches = Branch::where('branch_clg_id', $user->user_clg_id)->get();
        // dd($branches);
        return view('edit_employee', compact('departments', 'accounts', 'salary_heads', 'groups', 'product_groups', 'roles', 'employee', 'modular_groups', 'cities', 'countries', 'salary_info', 'salary_ads', 'group_id', 'designations', 'branches', 'allowance_deduction'));


        //        return view('edit_employee', compact('departments', 'accounts', 'salary_heads', 'groups', 'product_groups', 'roles', 'employee', 'modular_groups', 'cities', 'countries', 'salary_info', 'salary_ads', 'setParentHead'));
    }

    public function employee_update_validation($request)
    {
        $user = Auth::User();
        return $this->validate($request, [
            'user_department_id' => ['required'],
            'user_type' => ['required', 'numeric'],
            'role' => ['required', 'numeric'],
            'designation' => ['required', 'string'],
            //            'name' => ['required', 'regex:/^[^-\s][a-zA-Z\s-]+$/', 'unique:financials_users,user_name,' . $request->employee_id . ',user_id,' . $user->user_clg_id . ',user_clg_id,'],
            'fname' => ['required', 'regex:/^[^-\s][a-zA-Z\s-]+$/'],
            'mobile' => ['required'], //, 'regex:/^((\+92)|(0092))-?3\d{2}-?\d{7}$|^03\d{2}-?\d{7}$/'],
            'emergency_contact' => ['nullable', 'regex:/^((\+92)|(0092))-?3\d{2}-?\d{7}$|^03\d{2}-?\d{7}$/'],
            'cnic' => ['nullable', 'regex:/^\d{5}-\d{7}-\d$|^\d{13}$/'],
            'family_code' => ['nullable', 'string'],
            'marital' => ['required', 'numeric'],
            'city' => ['nullable', 'numeric'],
            'blood_group' => ['nullable', 'string'],
            'nationality' => ['nullable', 'numeric'],
            'religion' => ['required', 'numeric'],
            'doj' => ['nullable', 'string'],
            'grade' => ['nullable', 'string'],
            'commission' => ['nullable', 'numeric'],
            'target_amount' => ['nullable', 'numeric'],
            'address' => ['nullable', 'string'],
            'address2' => ['nullable', 'string'],
            'pimage' => 'nullable|image|mimes:jpeg,jpg,png|max:1999',
        ]);
    }


    public function update_employee(Request $request)
    {

        $user = Auth::user();
        $group_id = AccountGroupModel::where('ag_clg_id', $user->user_clg_id)->orderBy('ag_id', 'ASC')->pluck('ag_id')->first();
        $total_user = PackagesModel::where('pak_clg_id', '=', $user->user_clg_id)->pluck('pak_total_user')->first();
        $count_user = User::where('user_clg_id', '=', $user->user_clg_id)->where('user_username', '!=', null)->where('user_status', '=', 'Employee')->where('user_id', '!=', 1)->where(
            'user_type',
            '!=',
            'Master'
        )->count();

        $this->validate($request, [
            'employee_id' => ['required', 'numeric'],
        ]);
        //            ASSIGN DEPARTMENT ID TO FINANCIAL ACCOUNT
        $department_id = $request->user_department_id;
        //            ASSIGN DEPARTMENT ID TO FINANCIAL ACCOUNT
        $this->employee_update_validation($request);

        if (isset($request->make_salary_account)) {
            $this->employee_salary_info_validation($request);
        }

        $employee = User::where('user_clg_id', '=', $user->user_clg_id)->where('user_id', $request->employee_id)->first();

        if (isset($request->make_credentials)) {
            $this->validate($request, [
                'group' => ['required', 'array'],
                'product_reporting_group' => ['required', 'array'],
                'modular_group' => ['required', 'numeric'],
            ]);
            if ($employee->user_have_credentials == 0) {
                $this->validate($request, [
                    'username' => ['required', 'string', 'unique:financials_users,user_username,NULL,user_id,user_have_credentials,1'],
                    'email' => ['required', 'confirmed', 'string', 'unique:financials_users,user_email,NULL,user_id,user_have_credentials,1'],
                ]);
            }
        }

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

        $employee->user_department_id = $request->user_department_id;
        $employee->user_level = $request->user_type;
        $employee->user_designation = $request->designation;
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
        $employee->user_d_o_j = empty($request->doj) ? '0000-00-00' : date('Y-m-d', strtotime($request->doj));
        $employee->user_commission_per = empty($request->commission) ? 0 : $request->commission;
        $employee->user_target_amount = empty($request->target_amount) ? 0 : $request->target_amount;
        $employee->user_role_id = $request->role;
        $employee->user_address = ucfirst($request->address);
        $employee->user_address_2 = ucfirst($request->address2);
        $employee->user_createdby = $user->user_id;
        $employee->user_clg_id = $user->user_clg_id;
        $employee->user_branch_id = implode(",", $request->branch);
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
        if (isset($request->make_loan_account)) {
            $employee->user_loan_person = 1;
        }

        $password = Utility::uniqidReal();
        $user_msg = '';

        if (isset($request->make_credentials)) {
            if (!empty($employee->user_email)) {
                $employee->user_account_reporting_group_ids = implode(',', $request->group);
                $employee->user_product_reporting_group_ids = implode(',', $request->product_reporting_group);
                $employee->user_modular_group_id = $request->modular_group;
                DB::table('model_has_roles')->where('model_id', $employee->user_id)->delete();
                $role = Role::findById($request->modular_group);
                $employee->assignRole($role);
                if ($employee->user_have_credentials == 0) {
                    $employee->user_have_credentials = 1;
                    $employee->user_username = $request->username;
                    $employee->user_password = Hash::make($password);
                    $employee->user_email = $request->email;
                    $employee->user_expiry_date = date('Y-m-d', strtotime($user->user_expiry_date));
                }
            } else {
                if ($total_user >= $count_user) {
                    $employee->user_account_reporting_group_ids = implode(',', $request->group);
                    $employee->user_product_reporting_group_ids = implode(',', $request->product_reporting_group);
                    $employee->user_modular_group_id = $request->modular_group;

                    if ($employee->user_have_credentials == 0) {
                        $employee->user_have_credentials = 1;
                        $employee->user_username = $request->username;
                        $employee->user_password = Hash::make($password);
                        $employee->user_email = $request->email;
                        $employee->user_expiry_date = date('Y-m-d', strtotime($user->user_expiry_date));
                        DB::table('model_has_roles')->where('model_id', $employee->user_id)->delete();
                        $role = Role::findById($request->modular_group);
                        $employee->assignRole($role);
                    }
                } else {
                    $user_msg = '(You are not eligible to make more user for login contact Softagics! )';
                }
            }
        }
        if ($employee->save()) {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Employee With Id: ' . $employee->user_id . ' And Name: ' . $employee->user_name);

            $employee_id = $employee->user_id;
            $employee_name = $employee->user_name;
        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect('employee_list')->with('fail', 'Please Try Again!');
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

                        $loan_account = $this->AssignAccountValues(config('global_variables.loan_head'), 'Loan - ' . $employee_name, $loan_account, $employee_id, $request, $request->group_id);

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

                $exp_acc = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_employee_id', '=', $request->employee_id)->where(
                    'account_parent_code',
                    '=',
                    41412
                )->first();
                $adv_acc = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_employee_id', '=', $request->employee_id)->where('account_parent_code', '=', 11014)->first();
                $loan_acc = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_employee_id', '=', $request->employee_id)->where('account_parent_code', '=', 11019)->first();

                $exp_acc->account_name = 'Exp - ' . $request->name;
                $exp_acc->account_department_id = $department_id;
                $exp_acc->account_group_id = $request->group_id;
                $exp_acc->save();

                $adv_acc->account_name = 'Adv - ' . $request->name;
                $adv_acc->account_department_id = $department_id;
                $adv_acc->account_group_id = $request->group_id;
                $adv_acc->save();
                if (isset($request->make_loan_account)) {
                    $loan_acc->account_name = 'Loan - ' . $request->name;
                    $loan_acc->account_group_id = $request->group_id;
                    //                    $loan_acc->account_department_id = $department_id;
                    $loan_acc->save();
                }

                /////////// end mustafa ////////////
                $salary_info = SalaryInfoModel::where('si_clg_id', '=', $user->user_clg_id)->where('si_user_id', $employee_id)->first();
            }
            else if ($user_salary_person_status == 0) {

                ////////////////////////////////////////////////////////////////////////////////////////////
                ///////////////////////////////////// Expense Account //////////////////////////////////////
                ////////////////////////////////////////////////////////////////////////////////////////////

                $account_registerations_controller = new AccountRegisterationsController();

                $account = new AccountRegisterationModel();
                $account = $this->AssignAccountValues(config('global_variables.new_salary_expense_account'), 'Exp - ' . $employee_name, $account, $employee_id, $request, $request->group_id);

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

                $advance_salary_account = $this->AssignAccountValues(config('global_variables.advance_salary_head'), 'Adv - ' . $employee_name, $advance_salary_account, $employee_id, $request, $request->group_id);

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

                    $loan_account = $this->AssignAccountValues(config('global_variables.loan_head'), 'Loan - ' . $employee_name, $loan_account, $employee_id, $request, $request->group_id);

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
            $salary_info->si_payment_type = $request->payment_type;
            $salary_info->si_branch_code = $request->branch_code;
            $salary_info->si_account_number = $request->account_no;
            $salary_info->si_branch_id = Session::get('branch_id');
            $salary_info->si_clg_id = $user->user_clg_id;

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

                $delete_exists = AllowanceDeductionModel::where('ad_clg_id', '=', $user->user_clg_id)->where('ad_employee_id', $employee_id)->exists();

                if ($delete_exists) {
                    $delete = AllowanceDeductionModel::where('ad_clg_id', '=', $user->user_clg_id)->where('ad_employee_id', $employee_id)->delete();

                    if (!$delete) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect('employee_list')->with('fail', 'Please Try Again!');
                    }
                }


                $salary_items = $this->AssignAllowanceDeductionValues($request->accounts_array, $salary_info_id, $employee_id);

                if (DB::table('financials_allowances_deductions')->insert($salary_items)) {
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

        $notesCus = "";

        if ($request->role == config('global_variables.cashier_account_id')) {
            $notesCus = " - CASHIER - CASH";
        }
        if ($request->role == config('global_variables.teller_account_id')) {
            $notesCus = " - TELLER - CASH";
        }
        if ($request->role == config('global_variables.purchaser_role_id')) {
            $notesCus = " - PURCHASER - CASH";
        }
        if ($request->role == config('global_variables.seller_role_account_id')) {
            $notesCus = " - SALEMAN - CASH";
        }

        if ($request->role > 1) {

            if ($employee->user_teller_cash_account_uid == 0 && $employee->user_teller_wic_account_uid == 0) {

                $account_registerations_controller = new AccountRegisterationsController();

                if ($request->role == config('global_variables.cashier_account_id')) {

                    ////////////////////////////////////////////////////////////////////////////////////////////
                    ///////////////////////////////////// Cash Account /////////////////////////////////////////
                    ////////////////////////////////////////////////////////////////////////////////////////////

                    $account = new AccountRegisterationModel();
                    $account = $this->AssignAccountValues(config('global_variables.cash'), $employee_name . $notesCus, $account, $employee_id, $request, $group_id);

                    if (!$account->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Please Try Again!');
                    }

                    $account_uid = $account->account_uid;
                    $account_name = $account->account_name;


                    if ($request->role == config('global_variables.cashier_account_id')) {

                        $employee->user_teller_cash_account_uid = $account_uid;

                        if (!$employee->save()) {
                            $rollBack = true;
                            DB::rollBack();
                            return redirect()->back()->with('fail', 'Please Try Again!');
                        }
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

                if ($request->role == config('global_variables.teller_account_id')) {

                    ////////////////////////////////////////////////////////////////////////////////////////////
                    ///////////////////////////////////// Cash Account ///////////////////////////////////////
                    ////////////////////////////////////////////////////////////////////////////////////////////

                    $account = new AccountRegisterationModel();
                    $account = $this->AssignAccountValues(config('global_variables.cash'), $employee_name . $notesCus, $account, $employee_id, $request, $group_id);

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
                    $account = $this->AssignAccountValues($parent_account, $employee_name . $prefix_name, $account, $employee_id, $request, $group_id);

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

                if ($request->role == config('global_variables.seller_role_account_id')) {

                    ////////////////////////////////////////////////////////////////////////////////////////////
                    ///////////////////////////////////// Cash Account /////////////////////////////////////////
                    ////////////////////////////////////////////////////////////////////////////////////////////

                    $account = new AccountRegisterationModel();
                    $account = $this->AssignAccountValues(config('global_variables.cash'), $employee_name . $notesCus, $account, $employee_id, $request, $group_id);

                    if (!$account->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Please Try Again!');
                    }

                    $account_uid = $account->account_uid;
                    $account_name = $account->account_name;


                    if ($request->role == config('global_variables.seller_role_account_id')) {

                        $employee->user_teller_cash_account_uid = $account_uid;

                        if (!$employee->save()) {
                            $rollBack = true;
                            DB::rollBack();
                            return redirect()->back()->with('fail', 'Please Try Again!');
                        }
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
                    $account = $this->AssignAccountValues(config('global_variables.cash'), $employee_name . $notesCus, $account, $employee_id, $request, $group_id);

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
                    $account = $this->AssignAccountValues($parent_account, $employee_name . $prefix_name, $account, $employee_id, $request, $group_id);

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
        }

        if ($rollBack) {
            DB::rollBack();
            return redirect('employee_list')->with('fail', 'Failed Try Again');
        } else {
            DB::commit();

            if ($employee->user_have_credentials == 1) {
//                $this->SendPasswordMail($employee->user_email, $employee->user_username, $password);
                Mail::to($employee->user_email)->send(new UserCredentialEmail($password, $employee->user_username));
            }

            return redirect('employee_list')->with('success', 'Successfully Saved ' . $user_msg);
        }
    }

    public
    function delete_employee(Request $request)
    {
        $user = Auth::User();

        $delete = User::where('user_id', $request->employee_id)->first();
        $employee_accounts = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_employee_id', '=', $request->employee_id)->get();


        foreach ($employee_accounts as $account) {

            $account->account_delete_status = 1;
            $account->account_deleted_by = $user->user_id;
            $account->save();
        }
        //        $delete->user_delete_status = 1;

        if ($delete->user_delete_status == 1) {
            $delete->user_delete_status = 0;
        } else {
            $delete->user_delete_status = 1;
        }

        $delete->user_deleted_by = $user->user_id;

        if ($delete->save()) {

            if ($delete->user_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Employee With Id: ' . $delete->user_id . ' And Name: ' . $delete->user_name);

                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Employee With Id: ' . $delete->user_id . ' And Name: ' . $delete->user_name);

                return redirect()->back()->with('success', 'Successfully Deleted');
            }
        } else {
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }
    }

    public
    function update_force_offline_user(Request $request)
    {
        $employee_id = $request->employee_id;
        $user = Auth::User();

        $employee = User::where('user_clg_id', '=', $user->user_clg_id)->where('user_id', $employee_id)->first();

        $employee->user_desktop_status = config('global_variables.offline');

        if ($employee->save()) {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Forced Offline User With Id: ' . $employee->user_id . ' And Name: ' . $employee->user_name);

            return redirect()->back()->with('success', 'Successfully Saved');
        } else {
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }
    }

    public
    function update_all_force_offline_user()
    {
        $user = Auth::User();

        $employee = User::where('user_clg_id', '=', $user->user_clg_id)->where('user_desktop_status', config('global_variables.online'))
            ->update([
                'user_desktop_status' => config('global_variables.offline'),
            ]);

        if ($employee) {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Forced Offline All Users');

            return redirect()->back()->with('success', 'Successfully Saved');
        } else {
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }
    }

    public
    function update_force_offline_user_web(Request $request)
    {
        $employee_id = $request->employee_id;
        $user = Auth::User();

        $employee = User::where('user_clg_id', '=', $user->user_clg_id)->where('user_id', $employee_id)->first();

        $employee->session_id = null;

        if ($employee->save()) {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Forced Offline User With Id: ' . $employee->user_id . ' And Name: ' . $employee->user_name);

            return redirect()->back()->with('success', 'Successfully Saved');
        } else {
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }
    }


    public
    function update_all_force_offline_user_web()
    {
        $user = Auth::User();

        $employee = User::where('user_clg_id', '=', $user->user_clg_id)->where('session_id', '!=', 'Null')
            ->update([
                'session_id' => null,
            ]);

        if ($employee) {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Forced Offline All Users');

            return redirect()->back()->with('success', 'Successfully Saved');
        } else {
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }
    }

    public function add_machine()
    {
        $user = Auth::user();
        $branches = Branch::where('branch_clg_id', $user->user_clg_id)->get();
        return view('add_machine', compact('branches'));
    }
    public function submit_machine(Request $request)
    {
        $this->validate($request, [
            'user_name' => ['required', 'string', 'unique:financials_users,user_username,NULL,user_id,user_have_credentials,1'],
            'email' => ['required', 'string', 'unique:financials_users,user_email,NULL,user_id,user_have_credentials,1'],
        ]);

        $user = Auth::user();

        $employee = new User();
        $employee->user_have_credentials = 1;
        $employee->user_name = $request->user_name;
        $employee->user_username = $request->user_name;
        $employee->user_email = $request->email;
        $employee->user_password = Hash::make($request->password);
        $employee->user_branch_id = $request->branch;
        $employee->user_status = 'Machine';
        $employee->user_type = 'Machine';
        $employee->user_login_status = 'ENABLE';
        $employee->user_delete_status = 0;
        $employee->user_createdby = $user->user_id;
        $employee->user_clg_id = $user->user_clg_id;
        $employee->save();
        $employee_id = $employee->user_id;
        $employee_name = $employee->user_name;

        $employee->user_employee_code = $this->generate_employee_code($employee_id, $employee_name);
        $employee->save();
        return redirect()->back()->with(['success' => 'Save successfully.']);
    }
    public function machine_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $accounts = AccountRegisterationModel::where('account_clg_id', $user->user_clg_id)->where('account_parent_code', config('global_variables.salaries_account'))->orderBy('account_uid', 'ASC')
            ->get();
        $groups = AccountGroupModel::where('ag_clg_id', $user->user_clg_id)->orderBy('ag_title', 'ASC')->get();
        $roles = RolesModel::orderBy('user_role_id', 'ASC')->get();
        //        $modular_groups = ModularGroupModel::where('mg_id', '!=', 1)->orderby('mg_title', 'ASC')->get();
        $modular_groups = Role::where('delete_status', '!=', 1)->where('disabled', '!=', 1)->orderby('name', 'ASC')->get();
        $product_groups = ProductGroupModel::where('pg_clg_id', $user->user_clg_id)->where('pg_delete_status', '!=', 1)->where('pg_disabled', '!=', 1)->orderBy('pg_title', 'ASC')->get();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_salary_account = (!isset($request->salary_account) && empty($request->salary_account)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->salary_account;
        $search_group = (!isset($request->group) && empty($request->group)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->group;
        $search_modular_group = (!isset($request->modular_group) && empty($request->modular_group)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->modular_group;
        $search_user_type = (!isset($request->user_type) && empty($request->user_type)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->user_type;
        $search_role = (!isset($request->role) && empty($request->role)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->role;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $search_product_group = (isset($request->product_group) && !empty($request->product_group)) ? $request->product_group : '';


        $prnt_page_dir = 'print.machine_list.machine_list';
        $pge_title = 'Machine List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_salary_account, $search_group, $search_modular_group, $search_user_type, $search_role);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        //        $query = User::query()
        $query = DB::table('financials_users as usrs')
            ->leftJoin('branches','branches.branch_id','=','usrs.user_branch_id')
            ->leftJoin('financials_users as usr_crtd_info', 'usr_crtd_info.user_id', 'usrs.user_createdby')
//            ->leftJoin('financials_users as users','users.user_id','=','users.user_createdby')
            ->where('usrs.user_status', '=', 'Machine');
//        if ($user->user_id != 1) {
//            $query->whereNotIn('usrs.user_designation', [0, 1])
//                ->where('usrs.user_clg_id', $user->user_clg_id);
//        }
        // dd($query);
        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('usrs.user_name', 'like', '%' . $search . '%')
                    ->orWhere('usrs.user_username', 'like', '%' . $search . '%')
                    ->orWhere('usrs.user_email', 'like', '%' . $search . '%')
                    ->orWhere('usrs.user_mobile', 'like', '%' . $search . '%')
                    ->orWhere('usrs.user_cnic', 'like', '%' . $search . '%')
                    ->orWhere('usrs.user_address', 'like', '%' . $search . '%')
                    ->orWhere('usr_crtd_info.user_designation', 'like', '%' . $search . '%')
                    ->orWhere('usr_crtd_info.user_name', 'like', '%' . $search . '%')
                    ->orWhere('usr_crtd_info.user_username', 'like', '%' . $search . '%')
                    ->orWhere('ag_title', 'like', '%' . $search . '%');
            });
        }

        if (!empty($search_salary_account)) {
            $query->where('usrs.user_account_uid', $search_salary_account);
        }

        if (!empty($search_group)) {
            $query->whereRaw('FIND_IN_SET(' . $search_group . ',usrs.user_account_reporting_group_ids)');
        }

        if (!empty($search_role)) {
            $query->where('usrs.user_role_id', $search_role);
        }

        if (!empty($search_modular_group)) {
            $query->where('usrs.user_modular_group_id', $search_modular_group);
        }

        if (!empty($search_user_type)) {
            $query->where('usrs.user_level', $search_user_type);
        }

        if (isset($search_by_user) && !empty($search_by_user)) {
            $query->where('usrs.user_createdby', $search_by_user);
        }

        if (isset($search_product_group) && !empty($search_product_group)) {
            $query->whereRaw('FIND_IN_SET(' . $search_product_group . ',usrs.user_product_reporting_group_ids)');
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1) {
            $query->where('usrs.user_delete_status', '=', 1);
        } else {
            $query->where('usrs.user_delete_status', '!=', 1);
        }

        $datas = $query
            //            ->where('usrs.user_id', '!=', 1)
            //            ->where('usrs.user_id', '!=', 2)
            //            ->where('usrs.user_delete_status', '!=', 1)
            ->select('usrs.*','branches.*','usr_crtd_info.user_name as usr_crtd',)
            ->orderBy('usrs.user_id', 'DESC')
//            ->get();
//        dd($datas);
            ->paginate($pagination_number);


//        $employee = User::where('user_clg_id', $user->user_clg_id)->where('user_id', '!=', 1)->where('user_id', '!=', 2)
//            ->where('user_delete_status', '!=', 1)
//            ->where('user_status', '=', 'Employee')
//            ->orderBy('user_name', 'ASC')->pluck('user_name')
//            ->all();


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                    'allow_self_signed' => TRUE,
                ]
            ]);
            $optionss = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled' => true, 'isRemoteEnabled' => true]);
            $pdf->getDomPDF()->setHttpContext($options, $optionss);
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('machine_list', compact('datas', 'search',  'accounts', 'groups', 'roles', 'modular_groups', 'search_salary_account', 'search_group', 'search_role', 'search_modular_group', 'search_user_type', 'product_groups', 'search_product_group', 'restore_list'));
        }
    }

    public function change_machine_password(Request $request)
    {
//        dd($request->all());

        return view('change_machine_password',compact('request'));
    }

    public function submit_machine_password(Request $request)
    {
//       dd($request->all());
        $this->validate($request, [
//            'old_password' => ['required', 'min:8', 'regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[${\]}{\}@$!~%_`#*\'"|()}:.;,[+{<>=?&\/^-])[A-Za-z\d${\]}{\}@$!~%_`;#*\'"|()}:.,[+{<>=?&\/^-]{8,}$/'],
            'old_password' => ['required'],
            'password' => ['required', 'confirmed', 'min:8', 'regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[${\]}{\}@$!~%_`#*\'"|()}:.;,[+{<>=?&\/^-])[A-Za-z\d${\]}{\}@$!~%_`;#*\'"|()}:.,[+{<>=?&\/^-]{8,}$/'],
//            'password_confirmation' => ['required', 'min:8', 'regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[${\]}{\}@$!~%_`#*\'"|()}:.;,[+{<>=?&\/^-])[A-Za-z\d${\]}{\}@$!~%_`;#*\'"|()}:.,[+{<>=?&\/^-]{8,}$/'],
        ]);

        $current_password = User::where('user_id', $request->machine_id)->first()->user_password;
        if (Hash::check($request->input('old_password'), $current_password)) {

            $user_id = $request->machine_id;
            $obj_user = User::findOrFail($user_id);
            $obj_user->user_password = Hash::make($request->input('password'));
            if ($obj_user->save()) {

                $user = User::where('user_id', $request->machine_id)->first();

                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Change Their Password');

                return redirect(route('change_machine_password'))->with('success', 'Successfully Saved');
            } else {
                return redirect(route('change_machine_password'))->with('fail', 'Please Try Again!');
            }
        }
        return redirect(route('change_machine_password'))->with('fail', 'Please Try Again!');

    }
}
