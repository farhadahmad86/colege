<?php

namespace App\Http\Controllers;

use App\Mail\PasswordMail;
use App\Models\College\Branch;
use App\Models\ModularGroupModel;
use App\Models\OpeningTrialBalanceModel;
use App\Models\Utility;
use Illuminate\Support\Facades\Mail;
use PDF;
use Auth;
use App\User;
use Carbon\Carbon;
use function foo\func;
use App\Models\AreaModel;
use App\Models\RegionModel;
use App\Models\SectorModel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\BalancesModel;
use App\Models\EmployeeModel;
use App\Models\PackagesModel;
use App\Models\UserGroupModel;
use App\Models\FixedAssetModel;
use App\Imports\ExcelDataImport;
use App\Models\AccountGroupModel;
use App\Models\AccountHeadsModel;
use App\Models\SystemConfigModel;
use Illuminate\Support\Facades\DB;
use App\Exports\ExcelFileCusExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\CreditCardMachineModel;
use App\Models\CapitalRegistrationModel;
use App\Models\AccountRegisterationModel;
use Illuminate\Database\Eloquent\Builder;
use phpDocumentor\Reflection\Types\Null_;
use App\Http\Controllers\DayEndController;
use App\Models\SalaryAccountStructureModel;
use App\Http\Controllers\Wizard\WizardController;
use App\Models\AccountOpeningClosingBalanceModel;
use Session;


class AccountRegisterationsController extends ExcelForm\AccountRegistrationForm\AccountRegistrationsController
{
    public $parent_account_uid = '';
    public $link_account_uids = '';
    public $capital_account_uid_for_cap_reg = '';
    public $profit_loss_account_uid_for_cap_reg = '';
    public $drawing_account_uid_for_cap_reg = '';
    public $reserve_account_uid_for_cap_reg = '';

    public function account_registration()
    {
//        $branch_id = Session::get('branch_id');
//        $branches = DB::select('select * from branches where branch_id  IN ('.$branch_id.')');
//       dd($branches);


        $user = Auth::user();
        $expense = "";
        $heads = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_delete_status', '!=', 1)->where('coa_disabled', '!=', 1)->where('coa_level', 1)->where('coa_code', '!=',
            5)->orderBy('coa_id', 'ASC')->get();

        $groups = AccountGroupModel::where('ag_clg_id', '=', $user->user_clg_id)->where('ag_delete_status', '!=', 1)->where('ag_disabled', '!=', 1)->orderBy('ag_title', 'ASC')->get();

        $title = 'Entry Account Registration';

        // WizardController::updateWizardInfo(['entry_account'], []);

        return view('account_registration', compact('heads', 'groups', 'expense', 'title'));
    }

    public function expense_account_registration()
    {
        $user = Auth::user();
        $expense = 4;
        $heads = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_delete_status', '!=', 1)->where('coa_disabled', '!=', 1)->where('coa_level', 1)->orderBy('coa_id', 'ASC')
            ->get();

        $groups = AccountGroupModel::where('ag_clg_id', '=', $user->user_clg_id)->where('ag_delete_status', '!=', 1)->where('ag_disabled', '!=', 1)->orderBy('ag_title', 'ASC')->get();

        $title = 'Expense Account Registration';

        // WizardController::updateWizardInfo(['expense_account'], []);

        return view('account_registration', compact('heads', 'groups', 'expense', 'title'));
    }

    public function bank_account_registration()
    {
        $user = Auth::user();
        $bank_account = config('global_variables.bank_head');
        $groups = AccountGroupModel::where('ag_clg_id', '=', $user->user_clg_id)->where('ag_delete_status', '!=', 1)->where('ag_disabled', '!=', 1)->orderBy('ag_title', 'ASC')->get();

        return view('bank_account_registration', compact('bank_account', 'groups'));
    }

    public function salary_account_registration()
    {
        $user = Auth::user();
        $salary_expense_second_head = config('global_variables.salary_expense_second_head');

        $salary_accounts = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_delete_status', '!=', 1)->where('coa_disabled', '!=', 1)->where('coa_parent', $salary_expense_second_head)->orderBy('coa_id', 'ASC')->get();

        $groups = AccountGroupModel::where('ag_clg_id', '=', $user->user_clg_id)->where('ag_delete_status', '!=', 1)->where('ag_disabled', '!=', 1)->orderBy('ag_title', 'ASC')->get();

        return view('salary_account_registration', compact('salary_accounts', 'groups'));
    }

    public function receivables_account_registration()
    {
        $user = Auth::user();
        $parent_code = config('global_variables.receivable');

        $account = AccountRegisterationModel::find(\DB::table('financials_accounts')->where('account_parent_code', '=', $parent_code)->where('account_clg_id', $user->user_clg_id)->max('account_id'));

        $regions = RegionModel::where('reg_delete_status', '!=', 1)->where('reg_clg_id', $user->user_clg_id)->where('reg_disabled', '!=', 1)->orderBy('reg_title', 'ASC')->get();

        $groups = AccountGroupModel::where('ag_delete_status', '!=', 1)->where('ag_clg_id', $user->user_clg_id)->where('ag_disabled', '!=', 1)->orderBy('ag_title', 'ASC')->get();
        $modular_groups = ModularGroupModel::where('mg_delete_status', '!=', 1)->where('mg_disabled', '!=', 1)->orderby('mg_title', 'ASC')->get();
        $sale_persons = User::where('user_id', '!=', 1)->where('user_designation', '!=', 1)->where('user_delete_status', '!=', 1)->where('user_clg_id', $user->user_clg_id)
            ->where('user_disabled', '!=', 1)
            ->where('user_id', '!=', 1)->where('user_role_id', 4)->orderBy('user_name', 'ASC')->get();

        $purchasers = User::where('user_id', '!=', 1)->where('user_designation', '!=', 1)->where('user_delete_status', '!=', 1)->where('user_clg_id', $user->user_clg_id)
            ->where('user_disabled', '!=', 1)
            ->where('user_id', '!=', 1)->where('user_role_id', 5)->orderBy('user_name', 'ASC')->get();

        return view('account_registration_receivables', compact('regions', 'groups', 'sale_persons', 'account', 'modular_groups', 'purchasers'));
    }

    public function payables_account_registration()
    {
        $parent_code = config('global_variables.payable');
        $user = Auth::user();
        $account = AccountRegisterationModel::find(\DB::table('financials_accounts')->where('account_clg_id', '=', $user->user_clg_id)->where('account_parent_code', '=', $parent_code)->max('account_id'));

        $regions = RegionModel::where('reg_clg_id', '=', $user->user_clg_id)->where('reg_delete_status', '!=', 1)->where('reg_disabled', '!=', 1)->orderBy('reg_title', 'ASC')->get();

        $groups = AccountGroupModel::where('ag_clg_id', '=', $user->user_clg_id)->where('ag_delete_status', '!=', 1)->where('ag_disabled', '!=', 1)->orderBy('ag_title', 'ASC')->get();
        $modular_groups = ModularGroupModel::where('mg_delete_status', '!=', 1)->where('mg_disabled', '!=', 1)->orderby('mg_title', 'ASC')->get();
        $sale_persons = User::where('user_id', '!=', 1)->where('user_designation', '!=', 1)->where('user_clg_id', '=', $user->user_clg_id)->where('user_delete_status', '!=', 1)
            ->where('user_disabled', '!=', 1)
            ->where('user_id', '!=', 1)->where('user_role_id', 4)->orderBy('user_name', 'ASC')->get();

        return view('account_registration_payables', compact('regions', 'groups', 'sale_persons', 'account', 'modular_groups'));
    }

    public function generate_account_code($parent_head, $pre_account_id)
    {
        $id = $this->str_replace_firstss($parent_head, "", $pre_account_id);

        $id = $id + 1;

        $newId = $parent_head . $id;

        return $newId;
    }

    function str_replace_firstss($search, $replace, $subject)
    {
        return Str::replaceFirst($search, $replace, $subject);
    }

    function str_replace_first($from, $to, $content)
    {
        $from = '/' . preg_quote($from, '/') . '/';

        return preg_replace($from, $to, $content, 1);
    }

    public function submit_receivables_payable_account_excel(Request $request)
    {
        $rules = [
            'add_client_excel' => 'required|mimes:xlsx,xls,csv|max:5000',
        ];

        $messages = [
            'add_client_excel.max' => "Your File size too long.",
            'add_client_excel.required' => "Please select your Client Excel Sheet.",
        ];

        $validator = $this->validate($request, $rules, $messages);

        if ($request->hasFile('add_client_excel')) {

//            dd($request->add_employee_excel);
//            $dateTime = date('Ymd_His');
//            $file = $request->file('add_employee_excel');
//            $fileName = $dateTime . '-' . $file->getClientOriginalName();
//            $savePath = public_path('/uploads/'.config('global_variables.excel_storage_folder_name'));
//            $file->move($savePath, $fileName);
//            $data = Excel::load($path)->get();


            $path = $request->file('add_client_excel');
            $data = Excel::toArray(new ExcelDataImport, $path);
            $parent_code = $request->head_code_excel;

            $excelData = json_decode(json_encode($data), FALSE);
            foreach ($excelData as $rows) {
                foreach ($rows as $row) {
//
                    $rowData = (array)$row;
                    $request->merge($rowData);
                    if ($parent_code == config('global_variables.receivable')) {
                        $this->receivables_payable_account_validation_excel($request, config('global_variables.receivable'));
                    } else {
                        $this->receivables_payable_account_validation_excel($request, config('global_variables.payable'));
                    }

                    $rollBack = self::excel_form_receivables_payable($row, $parent_code);

                    if ($rollBack) {
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed Try Again');
                    } else {
                        DB::commit();
                    }
                }

            }

            return redirect()->back()->with(['success' => 'File Uploaded successfully.']);
        } else {
            return redirect()->back()->with(['errors' => $validator]);
        }
    }

    public function submit_receivables_payable_account(Request $request)
    {
        return self::simple_form_receivables_payable($request);
    }

    public function submit_other_account_excel(Request $request)
    {
        $rules = [
            'add_other_account_excel' => 'required|mimes:xlsx,xls,csv|max:5000',
        ];

        $messages = [
            'add_other_account_excel.max' => "Your File size too long.",
            'add_other_account_excel.required' => "Please select your Account Excel Sheet.",
        ];

        $validator = $this->validate($request, $rules, $messages);

        if ($request->hasFile('add_other_account_excel')) {

//            dd($request->add_employee_excel);
//            $dateTime = date('Ymd_His');
//            $file = $request->file('add_employee_excel');
//            $fileName = $dateTime . '-' . $file->getClientOriginalName();
//            $savePath = public_path('/uploads/'.config('global_variables.excel_storage_folder_name'));
//            $file->move($savePath, $fileName);
//            $data = Excel::load($path)->get();


            $path = $request->file('add_other_account_excel');
            $data = Excel::toArray(new ExcelDataImport, $path);

            $excelData = json_decode(json_encode($data), FALSE);
            foreach ($excelData as $rows) {
                foreach ($rows as $row) {

                    $rowData = (array)$row;
                    $request->merge($rowData);

                    $this->account_validation_excel($request);


                    $rollBack = self::excel_form_other_account($row);

                    if ($rollBack) {
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed Try Again');
                    } else {
                        DB::commit();
                    }
                }

            }

            return redirect()->back()->with(['success' => 'File Uploaded successfully.']);
        } else {
            return redirect()->back()->with(['errors' => $validator]);
        }
    }

    public function submit_other_account(Request $request)
    {
        return self::simple_form_other_account($request);
    }

    public function submit_salary_account_registration_excel(Request $request)
    {
        $rules = [
            'add_salary_account_excel' => 'required|mimes:xlsx,xls,csv|max:5000',
        ];

        $messages = [
            'add_salary_account_excel.max' => "Your File size too long.",
            'add_salary_account_excel.required' => "Please select your Salary Account Excel Sheet.",
        ];

        $validator = $this->validate($request, $rules, $messages);

        if ($request->hasFile('add_salary_account_excel')) {

//            dd($request->add_employee_excel);
//            $dateTime = date('Ymd_His');
//            $file = $request->file('add_employee_excel');
//            $fileName = $dateTime . '-' . $file->getClientOriginalName();
//            $savePath = public_path('/uploads/'.config('global_variables.excel_storage_folder_name'));
//            $file->move($savePath, $fileName);
//            $data = Excel::load($path)->get();


            $path = $request->file('add_salary_account_excel');
            $data = Excel::toArray(new ExcelDataImport, $path);

            $excelData = json_decode(json_encode($data), FALSE);
            foreach ($excelData as $rows) {
                foreach ($rows as $row) {

                    $rowData = (array)$row;
                    $request->merge($rowData);

                    $this->account_validation_excel($request);


                    $rollBack = self::excel_form_salary_account_registration($row);

                    if ($rollBack) {
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed Try Again');
                    } else {
                        DB::commit();
                    }
                }

            }

            return redirect()->back()->with(['success' => 'File Uploaded successfully.']);
        } else {
            return redirect()->back()->with(['errors' => $validator]);
        }
    }

    public function submit_salary_account_registration(Request $request)
    {
        return self::simple_form_salary_account_registration($request);
    }

    public function receivables_payable_account_validation($request, $parent_code)
    {
        $user = Auth::user();
        return $this->validate($request, [
            'region' => ['required', 'numeric'],
            'area' => ['required', 'numeric'],
            'sector' => ['required', 'numeric'],
            'group' => ['required', 'numeric'],
            'account_name' => 'required | unique:financials_accounts,account_name,NULL,account_id,account_parent_code,' . $parent_code . ',account_clg_id,' . $user->user_clg_id,
            'remarks' => ['nullable', 'string'],
            'print_name' => ['nullable', 'string'],
            'cnic' => ['nullable', 'regex:/^\d{5}-\d{7}-\d$|^\d{13}$/'],
            'opening_balance' => ['nullable', 'numeric'],
            'address' => ['nullable', 'string'],
            'proprietor' => ['nullable', 'string'],
            'co_code' => ['nullable', 'string'],
            'mobile' => ['nullable', 'regex:/^((\+92)|(0092))-?3\d{2}-?\d{7}$|^03\d{2}-?\d{7}$/'],
            'whatsapp' => ['nullable', 'regex:/^((\+92)|(0092))-?3\d{2}-?\d{7}$|^03\d{2}-?\d{7}$/'],
            'phone' => ['nullable', 'regex:/^\d{3}-?\d{3}-?\d{4}$|^\d{3} ?\d{3} ?\d{4}$/'],
            'email' => ['nullable', 'email'],
            'gst' => ['nullable', 'regex:/^([0-9]{1}[0-9]{1})-?([0-9]{1}[0-9]{1})-?([0-9]{4}-?[0-9]{3}-?[0-9]{2})+$|^([0-9]{1}[0-9]{1}) ?([0-9]{1}[0-9]{1}) ?([0-9]{4} ?[0-9]{3} ?[0-9]{2})+$/'],
            'ntn' => ['nullable', 'regex:/^\d{7}-?\d$/'],
            'credit_limit' => ['nullable', 'numeric', 'min:0'],
            'unlimited' => ['nullable', 'numeric'],
            'page_no' => ['nullable', 'string'],
            'sale_person' => ['nullable', 'numeric'],
            'discountType' => ['required'],
        ]);
    }

    public function check_name(Request $request)
    {
        $user = Auth::user();
        $check_account = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_name', $request->account_name)->where('account_parent_code', $request->head_code)->count();

        if ($check_account > 0) {
            return response()->json('yes');
        } else {
            return response()->json('no');
        }
    }

    // update code by shahzaib start
    public function account_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $groups = AccountGroupModel::where('ag_clg_id', '=', $user->user_clg_id)->orderBy('ag_title', 'ASC')->get();
        $first_heads = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_level', 1)->orderBy('coa_id', 'ASC')->get();
        $second_heads = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_level', 2)->orderBy('coa_id', 'ASC')->get();
        $third_heads = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_level', 3)->orderBy('coa_id', 'ASC')->get();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_first_head = (!isset($request->first_head) && empty($request->first_head)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->first_head;
        $search_second_head = (!isset($request->second_head) && empty($request->second_head)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->second_head;
        $search_third_head = (!isset($request->third_head) && empty($request->third_head)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->third_head;
        $search_group = (!isset($request->group) && empty($request->group)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->group;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.account_list.account_list';
        $pge_title = 'Entry Account List';
        $srch_fltr = [];
        if (empty($search_year)) {
            $search_year = $this->getYearEndId();
        }
        array_push($srch_fltr, $search, $search_first_head, $search_second_head, $search_third_head, $search_group, $search_year);

        $pagination_number = (empty($ar)) ? 100000000 : 10000000000;


//        $search_to = $request->to;
        $search_from = $request->from;

//        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));


        $query = DB::table('financials_accounts')
            ->leftJoin('financials_coa_heads as parent_account', 'parent_account.coa_code', 'financials_accounts.account_parent_code')
            ->leftJoin('financials_coa_heads as group_account', 'group_account.coa_code', 'parent_account.coa_parent')
            ->leftJoin('financials_coa_heads as control_account', 'control_account.coa_code', 'group_account.coa_parent')
            ->leftJoin('financials_account_group', 'financials_account_group.ag_id', 'financials_accounts.account_group_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_accounts.account_createdby')
            ->where('account_clg_id', '=', $user->user_clg_id)
            ->where('group_account.coa_clg_id', '=', $user->user_clg_id)
            ->where('control_account.coa_clg_id', '=', $user->user_clg_id)
            ->where('parent_account.coa_clg_id', '=', $user->user_clg_id);

        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('account_uid', 'like', '%' . $search . '%')
                    ->orWhere('account_name', 'like', '%' . $search . '%')
                    ->orWhere('control_account.coa_head_name', 'like', '%' . $search . '%')
                    ->orWhere('group_account.coa_head_name', 'like', '%' . $search . '%')
                    ->orWhere('parent_account.coa_head_name', 'like', '%' . $search . '%')
                    ->orWhere('control_account.coa_code', 'like', '%' . $search . '%')
                    ->orWhere('group_account.coa_code', 'like', '%' . $search . '%')
                    ->orWhere('parent_account.coa_code', 'like', '%' . $search . '%')
                    ->orWhere('user_designation', 'like', '%' . $search . '%')
                    ->orWhere('user_name', 'like', '%' . $search . '%')
                    ->orWhere('user_username', 'like', '%' . $search . '%')
                    ->orWhere('ag_title', 'like', '%' . $search . '%');
            });
        }


//        if ((isset($search_to) && !empty($search_to)) && (isset($search_from) && !empty($search_from))) {
//            $pagination_number = 1000000;
//
//            $query->whereBetween('account_datetime', [$start, $end]);
//
//        } elseif (isset($search_to) && !empty($search_to)) {
//            $pagination_number = 1000000;
//            $query->where('account_datetime', $start);
//
//        }
//        if (isset($search_from) && !empty($search_from)) {
//            $pagination_number = 1000000;
//            $query->where('account_datetime', $end);
//        }


        if (!empty($search_first_head)) {
            $query->where('control_account.coa_code', '=', $search_first_head);
        }

        if (!empty($search_second_head)) {
            $query->where('group_account.coa_code', '=', $search_second_head);
        }

        if (!empty($search_third_head)) {
            $query->where('parent_account.coa_code', '=', $search_third_head);
        }

        if (!empty($search_group)) {
            $query->where('account_group_id', '=', $search_group);
        }

        if (!empty($search_by_user)) {
            $query->where('account_createdby', '=', $search_by_user);
        }

        if ($user->user_level != 100) {
            $query->whereIn('account_group_id', explode(',', $user->user_account_reporting_group_ids));
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1) {
            $query->where('account_delete_status', '=', 1);
        } else {
            $query->where('account_delete_status', '!=', 1);
        }

        $datas = $query
//            ->where('account_type', 0) // coment for show all type of account\
//            ->where('account_delete_status', '!=', 1)
            ->select('financials_accounts.*', 'financials_users.user_id', 'financials_users.user_name', 'financials_users.user_designation', 'financials_account_group.ag_title', 'parent_account.coa_head_name as parnt_acnt_name', 'group_account.coa_head_name as grp_acnt_name')
            ->orderBy('account_parent_code', 'ASC')
            ->orderBy('account_name', 'ASC')
            ->paginate($pagination_number);


        if ($user->user_level == 100) {
            $account_list = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->
//            where('account_type', 0)
            where('account_delete_status', '!=', 1)
                ->orderBy('account_parent_code', 'ASC')
                ->orderBy('account_name', 'ASC')
                ->pluck('account_name')
                ->all();
        } else {
            $account_list = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->
//            where('account_type', 0)
            where('account_delete_status', '!=', 1)
                ->whereIn('account_group_id', explode(',', $user->user_account_reporting_group_ids))
                ->orderBy('account_parent_code', 'ASC')
                ->orderBy('account_name', 'ASC')
                ->pluck('account_name')
                ->all();
        }

        $balance = [];
        foreach ($datas as $account) {
            $default = 0;
            if (isset($search_from) && !empty($search_from)) {
                if ($this->getYearEndId() == $search_year) {
                    $default = BalancesModel::where('bal_clg_id', '=', $user->user_clg_id)->where('bal_account_id', $account->account_uid)->where('bal_day_end_date', '<=', $end)->orderBy('bal_id',
                        'DESC')->pluck('bal_total')->first();
                } else {
                    $tableName = 'financials_balances_' . $search_year;
                    $default = DB::table($tableName)->where('bal_clg_id', '=', $user->user_clg_id)->where('bal_account_id', $account->account_uid)->where('bal_day_end_date', '<=', $end)->orderBy('bal_id',
                        'DESC')->pluck('bal_total')->first();
                }

            } else {
                if ($this->getYearEndId() == $search_year) {
                    $default = BalancesModel::where('bal_clg_id', '=', $user->user_clg_id)->where('bal_account_id', $account->account_uid)->orderBy('bal_id', 'DESC')->pluck('bal_total')->first();
                } else {

                    $tableName = 'financials_balances_' . $search_year;
                    $default = DB::table($tableName)->where('bal_clg_id', '=', $user->user_clg_id)->where('bal_account_id', $account->account_uid)->orderBy('bal_id', 'DESC')->pluck('bal_total')->first();

                }
            }
            if (empty($default)) {
                $balance[] = 0;
            } else {
                $balance[] = $default;
            }
        }


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
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title', 'balance'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title, $balance), $pge_title . '_x.xlsx');
            }

        } else {

            return view('account_list', compact('datas', 'balance', 'search_year', 'search', 'account_list', 'search_first_head', 'search_second_head', 'search_third_head', 'search_group', 'first_heads', 'second_heads', 'third_heads', 'groups', 'restore_list', 'search_from'));
        }
    }
    // update code by shahzaib end


    // update code by shahzaib start
    public
    function expense_account_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $groups = AccountGroupModel::where('ag_clg_id', '=', $user->user_clg_id)->orderBy('ag_title', 'ASC')->get();
        $expense = 4;
        $first_heads = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_level', 1)->orderBy('coa_id', 'ASC')->get();
        $second_heads = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_parent', $expense)->orderBy('coa_id', 'ASC')->get();
        $third_heads = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_code', 'like', config('global_variables.expense') . '%')->where('coa_level', 3)->orderBy('coa_id', 'ASC')->get();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_first_head = (!isset($request->first_head) && empty($request->first_head)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->first_head;
        $search_second_head = (!isset($request->second_head) && empty($request->second_head)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->second_head;
        $search_third_head = (!isset($request->third_head) && empty($request->third_head)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->third_head;
        $search_group = (!isset($request->group) && empty($request->group)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->group;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.expense_account_list.expense_account_list';
        $pge_title = 'Expense Account List';
        $srch_fltr = [];
        if (empty($search_year)) {
            $search_year = $this->getYearEndId();
        }
        array_push($srch_fltr, $search, $search_first_head, $search_second_head, $search_third_head, $search_group,$search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query_list = DB::table('financials_accounts')->where('account_clg_id', '=', $user->user_clg_id);
        $query = DB::table('financials_accounts')
            ->leftJoin('financials_coa_heads as parent_account', 'parent_account.coa_code', 'financials_accounts.account_parent_code')
            ->leftJoin('financials_coa_heads as group_account', 'group_account.coa_code', 'parent_account.coa_parent')
            ->leftJoin('financials_coa_heads as control_account', 'control_account.coa_code', 'group_account.coa_parent')
            ->leftJoin('financials_account_group', 'financials_account_group.ag_id', 'financials_accounts.account_group_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_accounts.account_createdby')
            ->where('account_clg_id', '=', $user->user_clg_id)
            ->where('group_account.coa_clg_id', '=', $user->user_clg_id)
            ->where('control_account.coa_clg_id', '=', $user->user_clg_id)
            ->where('parent_account.coa_clg_id', '=', $user->user_clg_id);


        if (!empty($search)) {
//            $pagination_number = 1000000;
            $query->where(function ($query) use ($search) {
                $query->where('account_uid', 'like', '%' . $search . '%')
                    ->orWhere('account_name', 'like', '%' . $search . '%')
                    ->orWhere('parent_account.coa_head_name', 'like', '%' . $search . '%')
                    ->orWhere('group_account.coa_head_name', 'like', '%' . $search . '%')
                    ->orWhere('user_designation', 'like', '%' . $search . '%')
                    ->orWhere('user_name', 'like', '%' . $search . '%')
                    ->orWhere('user_username', 'like', '%' . $search . '%')
                    ->orWhere('ag_title', 'like', '%' . $search . '%');
            });
        }


        if (!empty($search_second_head)) {
//            $pagination_number = 1000000;
            $get_second_head = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_parent', $search_second_head)->pluck('coa_code')->all();
            $query->whereIn('account_parent_code', $get_second_head);
        }


        if (!empty($search_third_head)) {
//            $pagination_number = 1000000;
            $query->where('parent_account.coa_code', $search_third_head);
        }

        if (!empty($search_group)) {
//            $pagination_number = 1000000;
            $query->where('account_group_id', '=', $search_group);
        }

        if (!empty($search_by_user)) {
//            $pagination_number = 1000000;
            $query->where('account_createdby', $search_by_user);
        }

        if ($user->user_level !== 100) {
            $query->whereIn('account_group_id', explode(',', $user->user_account_reporting_group_ids));
            $query_list->whereIn('account_group_id', explode(',', $user->user_account_reporting_group_ids));
        }


        $restore_list = $request->restore_list;
        if ($restore_list == 1) {
            $query->where('account_delete_status', '=', 1);
        } else {
            $query->where('account_delete_status', '!=', 1);
        }


        $datas = $query->where('account_type', 0)
//            ->where('account_delete_status', '!=', 1)
            ->select('financials_accounts.*', 'financials_users.user_id', 'financials_users.user_name', 'financials_users.user_designation', 'financials_account_group.ag_title', 'parent_account.coa_head_name as parnt_acnt_name', 'group_account.coa_head_name as grp_acnt_name')
            ->where('account_uid', 'like', config('global_variables.expense') . '%')
            ->orderBy('account_parent_code', 'ASC')
            ->orderBy('account_name', 'ASC')
            ->paginate($pagination_number);


        $account_list = $query_list->where('account_type', '!=', 0)
            ->where('account_delete_status', '!=', 1)
            ->orderBy('account_parent_code', 'ASC')
            ->orderBy('account_name', 'ASC')
            ->pluck('account_name')
            ->all();


        $balance = [];
        foreach ($datas as $account) {
            $default = 0;
            if ($this->getYearEndId() == $search_year)
            {
            $default = BalancesModel::where('bal_clg_id', '=', $user->user_clg_id)->where('bal_account_id', $account->account_uid)->orderBy('bal_id', 'DESC')->pluck('bal_total')->first();
            }else{
                    $tableName = 'financials_balances_' . $search_year;
                    $default = DB::table($tableName)->where('bal_clg_id', '=', $user->user_clg_id)->where('bal_account_id', $account->account_uid)->where('bal_year_id', '=', $search_year)->orderBy('bal_id', 'DESC')->pluck('bal_total')->first();
            }
            if (empty($default)) {
                $balance[] = 0;
            } else {
                $balance[] = $default;
            }
        }


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
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title', 'balance'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title, $balance), $pge_title . '_x.xlsx');
            }

        } else {
            return view('expense_account_list', compact('datas', 'balance', 'search','search_year', 'account_list', 'groups', 'search_group', 'search_first_head', 'search_second_head', 'search_third_head', 'expense', 'first_heads', 'second_heads', 'third_heads', 'search_by_user', 'restore_list'));
        }
    }

    // update code by shahzaib end

    // update code by shahzaib start
    public
    function account_receivable_payable_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();

        $regions = RegionModel::where('reg_clg_id', '=', $user->user_clg_id)->where('reg_delete_status', '!=', 1)->where('reg_disabled', '!=', 1)->orderBy('reg_title', 'ASC')->get();
        $areas = AreaModel::where('area_clg_id', '=', $user->user_clg_id)->where('area_delete_status', '!=', 1)->where('area_disabled', '!=', 1)->orderBy('area_title', 'ASC')->get();
        $sectors = SectorModel::where('sec_clg_id', '=', $user->user_clg_id)->where('sec_delete_status', '!=', 1)->where('sec_disabled', '!=', 1)->orderBy('sec_title', 'ASC')->get();
        $groups = AccountGroupModel::where('ag_clg_id', '=', $user->user_clg_id)->orderBy('ag_title', 'ASC')->get();
        $sale_persons = User::where('user_id', '!=', 1)->where('user_designation', '!=', 1)->where('user_clg_id', '=', $user->user_clg_id)->where('user_delete_status', '!=', 1)->where('user_id', '!=', 1)->orderBy('user_role_id', 'DESC')->orderBy('user_name', 'ASC')->get();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_region = (!isset($request->region) && empty($request->region)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->region;
        $search_area = (!isset($request->area) && empty($request->area)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->area;
        $search_sector = (!isset($request->sector) && empty($request->sector)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->sector;
        $search_group = (!isset($request->group) && empty($request->group)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->group;
        $search_sale_persons = (!isset($request->sale_person) && empty($request->sale_person)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->sale_person;
        $search_date = (!isset($request->date) && empty($request->date)) ? ((!empty($ar)) ? $ar[7]->{'value'} : '') : $request->date;
        $account_type = (!isset($request->account_type) && empty($request->account_type)) ? "" : $request->account_type;
        $search_by_user = $request->search_by_user;

        $prnt_page_dir = 'print.account_receivable_payable_list.account_receivable_payable_list';
        $pge_title = 'Account Payable Receivable';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_region, $search_area, $search_sector, $search_group, $search_sale_persons, $search_by_user, $search_date);

        $date = date('Y-m-d', strtotime($search_date));


        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $query = DB::table('financials_accounts')
            ->leftJoin('financials_region', 'financials_accounts.account_region_id', 'financials_region.reg_id')
            ->leftJoin('financials_sectors', 'financials_accounts.account_sector_id', 'financials_sectors.sec_id')
            ->leftJoin('financials_areas', 'financials_accounts.account_area', 'financials_areas.area_id')
            ->leftJoin('financials_account_group', 'financials_account_group.ag_id', 'financials_accounts.account_group_id')
            ->leftJoin('financials_users', 'financials_users.user_id', '=', 'financials_accounts.account_createdby')
            ->where('account_clg_id', '=', $user->user_clg_id);


        if (!empty($search)) {
//            $pagination = 1000000;
//            $query->where(function ($query) use ($search) {
            $query->where('account_uid', 'like', '%' . $search . '%')
                ->orWhere('account_name', 'like', '%' . $search . '%')
                ->orWhere('financials_region.reg_title', 'like', '%' . $search . '%')
                ->orWhere('financials_sectors.sec_title', 'like', '%' . $search . '%')
                ->orWhere('financials_areas.area_title', 'like', '%' . $search . '%');
//            });
        }

        if (!empty($search_region)) {
//            $pagination_number = 1000000;
            $query->where('account_region_id', $search_region);
        }

        if (!empty($search_area)) {
//            $pagination_number = 1000000;
            $query->where('account_area', $search_area);
        }

        if (!empty($search_sector)) {
//            $pagination_number = 1000000;
            $query->where('account_sector_id', $search_sector);
        }

        if (!empty($search_group)) {
//            $pagination_number = 1000000;
            $query->where('account_group_id', $search_group);
        }

        if (!empty($account_type)) {
//            $pagination_number = 1000000;
            $query->where('account_type', $account_type);
        } else {
            $query->where('account_type', '!=', 0);
        }

        if (!empty($search_by_user)) {
//            $pagination_number = 1000000;
            $query->where('account_createdby', $search_by_user);
        }

        if (!empty($search_sale_persons)) {
//            $pagination_number = 1000000;
            $query->where('account_sale_person', $search_sale_persons);
        }

        if ($user->user_level !== 100) {
            $query->whereIn('account_group_id', explode(',', $user->user_account_reporting_group_ids));
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1) {
            $query->where('account_delete_status', '=', 1);
        } else {
            $query->where('account_delete_status', '!=', 1);
        }

//
        $datas = $query
//            ->where('account_delete_status', '!=', 1)
            ->orderBy('account_parent_code', 'ASC')
            ->orderBy('account_name', 'ASC')
            ->select('financials_accounts.*', 'financials_region.reg_title', 'financials_sectors.sec_title', 'financials_areas.area_title', 'financials_users.user_id', 'financials_users.user_name', 'financials_users.user_designation', 'financials_account_group.ag_title')
            ->paginate($pagination_number);

        $query_lst = DB::table('financials_accounts')->where('account_clg_id', '=', $user->user_clg_id);
        if ($user->user_level !== 100) {
            $query_lst->whereIn('account_group_id', explode(',', $user->user_account_reporting_group_ids));
        }
        $account_list = $query_lst->where('account_type', '!=', 0)
            ->where('account_delete_status', '!=', 1)
            ->orderBy('account_parent_code', 'ASC')
            ->orderBy('account_name', 'ASC')
            ->pluck('account_name')
            ->all();


        $balance = [];
        $balance_date_array = [];

        if (!empty($search_date)) {
            foreach ($datas as $account) {
                $default = 0;
//            $default = BalancesModel::where('bal_account_id', $account->account_uid)->orderBy('bal_id', 'DESC')->pluck('bal_total')->first();
//                $default = BalancesModel::where('bal_account_id', $account->account_uid)->where('bal_day_end_date', $date)->orderBy('bal_id', 'DESC')->pluck('bal_total')->first();
                $default = BalancesModel::where('bal_clg_id', '=', $user->user_clg_id)->where('bal_account_id', $account->account_uid)->whereDate('bal_day_end_date', '<=', $date)->orderBy('bal_id',
                    'DESC')->pluck('bal_total')->first();

                $balance_date = BalancesModel::where('bal_clg_id', '=', $user->user_clg_id)->where('bal_account_id', $account->account_uid)->orderBy('bal_id', 'DESC')->pluck('bal_day_end_date')
                    ->first();
//                $balance_date = BalancesModel::where('bal_account_id', $account->account_uid)->orderBy('bal_id', 'DESC')->pluck('bal_day_end_date')->first();


                $balance_date_array[] = $balance_date;

                if (empty($default)) {
                    $balance[] = 0;
                } else {
                    $balance[] = $default;
                }
            }
        } else {

            foreach ($datas as $account) {
                $default = 0;
                $default = BalancesModel::where('bal_clg_id', '=', $user->user_clg_id)->where('bal_account_id', $account->account_uid)->orderBy('bal_id', 'DESC')->pluck('bal_total')->first();

                $balance_date = BalancesModel::where('bal_clg_id', '=', $user->user_clg_id)->where('bal_account_id', $account->account_uid)->orderBy('bal_id', 'DESC')->pluck('bal_day_end_date')
                    ->first();
                $balance_date_array[] = $balance_date;


                if (empty($default)) {
                    $balance[] = 0;
                } else {
                    $balance[] = $default;
                }
            }
        }


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
            $pdf->loadView($prnt_page_dir, compact('datas', 'balance', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title, $balance), $pge_title . '_x.xlsx');
            }

        } else {
            return view('account_receivable_payable_list', compact('datas', 'areas', 'balance', 'search', 'account_list', 'regions', 'groups', 'sale_persons', 'search_region', 'search_area', 'search_sector', 'search_group', 'areas', 'sectors', 'search_by_user', 'search_sale_persons', 'search_date', 'balance_date_array'));
        }
    }

    public
    function account_receivable_payable_simple_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $regions = RegionModel::where('reg_clg_id', '=', $user->user_clg_id)->where('reg_delete_status', '!=', 1)->where('reg_disabled', '!=', 1)->orderBy('reg_title', 'ASC')->get();
        $areas = AreaModel::where('area_clg_id', '=', $user->user_clg_id)->where('area_delete_status', '!=', 1)->where('area_disabled', '!=', 1)->orderBy('area_title', 'ASC')->get();
        $sectors = SectorModel::where('sec_clg_id', '=', $user->user_clg_id)->where('sec_delete_status', '!=', 1)->where('sec_disabled', '!=', 1)->orderBy('sec_title', 'ASC')->get();
        $groups = AccountGroupModel::where('ag_clg_id', '=', $user->user_clg_id)->orderBy('ag_title', 'ASC')->get();
        $sale_persons = User::where('user_id', '!=', 1)->where('user_designation', '!=', 1)->where('user_clg_id', '=', $user->user_clg_id)->where('user_delete_status', '!=', 1)->where('user_id', '!=', 1)->orderBy('user_role_id', 'DESC')->orderBy('user_name',
            'ASC')->get();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_region = (!isset($request->region) && empty($request->region)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->region;
        $search_area = (!isset($request->area) && empty($request->area)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->area;
        $search_sector = (!isset($request->sector) && empty($request->sector)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->sector;
        $search_group = (!isset($request->group) && empty($request->group)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->group;
        $search_sale_persons = (!isset($request->sale_person) && empty($request->sale_person)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->sale_person;
        $search_date = (!isset($request->date) && empty($request->date)) ? ((!empty($ar)) ? $ar[7]->{'value'} : '') : $request->date;
        $account_type = (!isset($request->account_type) && empty($request->account_type)) ? "" : $request->account_type;
        $search_by_user = $request->search_by_user;

        $prnt_page_dir = 'print.account_receivable_payable_list.account_receivable_payable_list';
        $pge_title = 'Account Payable Receivable';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_region, $search_area, $search_sector, $search_group, $search_sale_persons, $search_by_user, $search_date);

        $date = date('Y-m-d', strtotime($search_date));


        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $query = DB::table('financials_accounts')
            ->leftJoin('financials_region', 'financials_accounts.account_region_id', 'financials_region.reg_id')
            ->leftJoin('financials_sectors', 'financials_accounts.account_sector_id', 'financials_sectors.sec_id')
            ->leftJoin('financials_areas', 'financials_accounts.account_area', 'financials_areas.area_id')
            ->leftJoin('financials_account_group', 'financials_account_group.ag_id', 'financials_accounts.account_group_id')
            ->leftJoin('financials_users as sale_person', 'sale_person.user_id', '=', 'financials_accounts.account_sale_person')
            ->leftJoin('financials_users', 'financials_users.user_id', '=', 'financials_accounts.account_createdby')
            ->where('account_clg_id', '=', $user->user_clg_id);


        if (!empty($search)) {
//            $pagination = 1000000;
//            $query->where(function ($query) use ($search) {
            $query->where('account_uid', 'like', '%' . $search . '%')
                ->orWhere('account_name', 'like', '%' . $search . '%')
                ->orWhere('financials_region.reg_title', 'like', '%' . $search . '%')
                ->orWhere('financials_sectors.sec_title', 'like', '%' . $search . '%')
                ->orWhere('financials_areas.area_title', 'like', '%' . $search . '%');
//            });
        }

        if (!empty($search_region)) {
//            $pagination_number = 1000000;
            $query->where('account_region_id', $search_region);
        }

        if (!empty($search_area)) {
//            $pagination_number = 1000000;
            $query->where('account_area', $search_area);
        }

        if (!empty($search_sector)) {
//            $pagination_number = 1000000;
            $query->where('account_sector_id', $search_sector);
        }

        if (!empty($search_group)) {
//            $pagination_number = 1000000;
            $query->where('account_group_id', $search_group);
        }

        if (!empty($account_type)) {
//            $pagination_number = 1000000;
            $query->where('account_type', $account_type);
        } else {
            $query->where('account_type', '!=', 0);
        }

        if (!empty($search_by_user)) {
//            $pagination_number = 1000000;
            $query->where('account_createdby', $search_by_user);
        }

        if (!empty($search_sale_persons)) {
//            $pagination_number = 1000000;
            $query->where('account_sale_person', $search_sale_persons);
        }

        if ($user->user_level !== 100) {
            $query->whereIn('account_group_id', explode(',', $user->user_account_reporting_group_ids));
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1) {
            $query->where('account_delete_status', '=', 1);
        } else {
            $query->where('account_delete_status', '!=', 1);
        }

//
        $datas = $query
//            ->where('account_delete_status', '!=', 1)
            ->orderBy('account_parent_code', 'ASC')
            ->orderBy('account_name', 'ASC')
            ->select('financials_accounts.*', 'financials_region.reg_title', 'financials_sectors.sec_title', 'financials_areas.area_title', 'financials_users.user_id', 'financials_users.user_name',
                'financials_users.user_designation', 'financials_account_group.ag_title', 'sale_person.user_name as sale_person_name')
            ->paginate($pagination_number);

        $query_lst = DB::table('financials_accounts')->where('account_clg_id', '=', $user->user_clg_id);
        if ($user->user_level !== 100) {
            $query_lst->whereIn('account_group_id', explode(',', $user->user_account_reporting_group_ids));
        }
        $account_list = $query_lst->where('account_type', '!=', 0)
            ->where('account_delete_status', '!=', 1)
            ->orderBy('account_parent_code', 'ASC')
            ->orderBy('account_name', 'ASC')
            ->pluck('account_name')
            ->all();


        $balance = [];
        $balance_date_array = [];

        if (!empty($search_date)) {
            foreach ($datas as $account) {
                $default = 0;
//            $default = BalancesModel::where('bal_account_id', $account->account_uid)->orderBy('bal_id', 'DESC')->pluck('bal_total')->first();
//                $default = BalancesModel::where('bal_account_id', $account->account_uid)->where('bal_day_end_date', $date)->orderBy('bal_id', 'DESC')->pluck('bal_total')->first();
                $default = BalancesModel::where('bal_clg_id', '=', $user->user_clg_id)->where('bal_account_id', $account->account_uid)->whereDate('bal_day_end_date', '<=', $date)->orderBy('bal_id',
                    'DESC')->pluck('bal_total')->first();

                $balance_date = BalancesModel::where('bal_clg_id', '=', $user->user_clg_id)->where('bal_account_id', $account->account_uid)->orderBy('bal_id', 'DESC')->pluck('bal_day_end_date')->first();
//                $balance_date = BalancesModel::where('bal_account_id', $account->account_uid)->orderBy('bal_id', 'DESC')->pluck('bal_day_end_date')->first();


                $balance_date_array[] = $balance_date;

                if (empty($default)) {
                    $balance[] = 0;
                } else {
                    $balance[] = $default;
                }
            }
        } else {

            foreach ($datas as $account) {
                $default = 0;
                $default = BalancesModel::where('bal_clg_id', '=', $user->user_clg_id)->where('bal_account_id', $account->account_uid)->orderBy('bal_id', 'DESC')->pluck('bal_total')->first();

                $balance_date = BalancesModel::where('bal_clg_id', '=', $user->user_clg_id)->where('bal_account_id', $account->account_uid)->orderBy('bal_id', 'DESC')->pluck('bal_day_end_date')->first();
                $balance_date_array[] = $balance_date;


                if (empty($default)) {
                    $balance[] = 0;
                } else {
                    $balance[] = $default;
                }
            }
        }


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
            $pdf->loadView($prnt_page_dir, compact('datas', 'balance', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title, $balance), $pge_title . '_x.xlsx');
            }

        } else {
            return view('account_receivable_payable_simple_list', compact('datas', 'areas', 'balance', 'search', 'account_list', 'regions', 'groups', 'sale_persons', 'search_region', 'search_area', 'search_sector', 'search_group', 'areas', 'sectors', 'search_by_user', 'search_sale_persons', 'search_date', 'balance_date_array'));
        }
    }

    // update code by shahzaib end

//    nabeel panga
    public
    function party_account_balance_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $regions = RegionModel::where('reg_clg_id', '=', $user->user_clg_id)->where('reg_delete_status', '!=', 1)->where('reg_disabled', '!=', 1)->orderBy('reg_title', 'ASC')->get();
        $areas = AreaModel::where('area_clg_id', '=', $user->user_clg_id)->where('area_delete_status', '!=', 1)->where('area_disabled', '!=', 1)->orderBy('area_title', 'ASC')->get();
        $sectors = SectorModel::where('sec_clg_id', '=', $user->user_clg_id)->where('sec_delete_status', '!=', 1)->where('sec_disabled', '!=', 1)->orderBy('sec_title', 'ASC')->get();
        $groups = AccountGroupModel::where('ag_clg_id', '=', $user->user_clg_id)->orderBy('ag_title', 'ASC')->get();
        $sale_persons = User::where('user_id', '!=', 1)->where('user_designation', '!=', 1)->where('user_clg_id', '=', $user->user_clg_id)->where('user_delete_status', '!=', 1)->where('user_id', '!=', 1)->orderBy('user_role_id', 'DESC')->orderBy('user_name',
            'ASC')->get();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_region = (!isset($request->region) && empty($request->region)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->region;
        $search_area = (!isset($request->area) && empty($request->area)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->area;
        $search_sector = (!isset($request->sector) && empty($request->sector)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->sector;
        $search_group = (!isset($request->group) && empty($request->group)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->group;
        $search_sale_persons = (!isset($request->sale_person) && empty($request->sale_person)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->sale_person;
        $account_type = (!isset($request->account_type) && empty($request->account_type)) ? "" : $request->account_type;
        $search_by_user = $request->search_by_user;

        $prnt_page_dir = 'print.account_receivable_payable_list.account_receivable_payable_list';
        $pge_title = 'Account Payable Receivable';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_region, $search_area, $search_sector, $search_group, $search_sale_persons, $search_by_user);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $query = DB::table('financials_accounts')
            ->leftJoin('financials_region', 'financials_accounts.account_region_id', 'financials_region.reg_id')
            ->leftJoin('financials_sectors', 'financials_accounts.account_sector_id', 'financials_sectors.sec_id')
            ->leftJoin('financials_areas', 'financials_accounts.account_area', 'financials_areas.area_id')
            ->leftJoin('financials_account_group', 'financials_account_group.ag_id', 'financials_accounts.account_group_id')
            ->leftJoin('financials_users', 'financials_users.user_id', '=', 'financials_accounts.account_createdby')
            ->where('account_clg_id', '=', $user->user_clg_id);
//            ->leftJoin('financials_balances', 'financials_balances.bal_account_id', '=', 'financials_accounts.account_uid');


        if (!empty($search)) {
//            $pagination = 1000000;
//            $query->where(function ($query) use ($search) {
            $query->where('account_uid', 'like', '%' . $search . '%')
                ->orWhere('account_name', 'like', '%' . $search . '%')
                ->orWhere('financials_region.reg_title', 'like', '%' . $search . '%')
                ->orWhere('financials_sectors.sec_title', 'like', '%' . $search . '%')
                ->orWhere('financials_areas.area_title', 'like', '%' . $search . '%');
//            });
        }

        if (!empty($search_region)) {
//            $pagination_number = 1000000;
            $query->where('account_region_id', $search_region);
        }

        if (!empty($search_area)) {
//            $pagination_number = 1000000;
            $query->where('account_area', $search_area);
        }

        if (!empty($search_sector)) {
//            $pagination_number = 1000000;
            $query->where('account_sector_id', $search_sector);
        }

        if (!empty($search_group)) {
//            $pagination_number = 1000000;
            $query->where('account_group_id', $search_group);
        }

        if (!empty($account_type)) {
//            $pagination_number = 1000000;
            $query->where('account_type', $account_type);
        } else {
            $query->where('account_type', '!=', 0);
        }

        if (!empty($search_by_user)) {
//            $pagination_number = 1000000;
            $query->where('account_createdby', $search_by_user);
        }

        if (!empty($search_sale_persons)) {
//            $pagination_number = 1000000;
            $query->where('account_sale_person', $search_sale_persons);
        }

        if ($user->user_level !== 100) {
            $query->whereIn('account_group_id', explode(',', $user->user_account_reporting_group_ids));
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1) {
            $query->where('account_delete_status', '=', 1);
        } else {
            $query->where('account_delete_status', '!=', 1);
        }

//
        $datas = $query
//            ->where('account_delete_status', '!=', 1)
            ->orderBy('account_parent_code', 'ASC')
            ->orderBy('account_name', 'ASC')
            ->select('financials_accounts.*', 'financials_region.reg_title', 'financials_sectors.sec_title', 'financials_areas.area_title', 'financials_users.user_id', 'financials_users.user_name', 'financials_users.user_designation', 'financials_account_group.ag_title')
            ->paginate($pagination_number);

        $query_lst = DB::table('financials_accounts')->where('account_clg_id', '=', $user->user_clg_id);
        if ($user->user_level !== 100) {
            $query_lst->whereIn('account_group_id', explode(',', $user->user_account_reporting_group_ids));
        }
        $account_list = $query_lst->where('account_type', '!=', 0)
            ->where('account_delete_status', '!=', 1)
            ->orderBy('account_parent_code', 'ASC')
            ->orderBy('account_name', 'ASC')
            ->pluck('account_name')
            ->all();


        $balance = [];
        foreach ($datas as $account) {
            $default = 0;
//            $default = BalancesModel::where('bal_account_id', $account->account_uid)->orderBy('bal_id', 'DESC')->pluck('bal_total')->first();
            $default = BalancesModel::where('bal_clg_id', '=', $user->user_clg_id)->where('bal_account_id', $account->account_uid)->where('bal_day_end_date', '2021-08-01')->orderBy('bal_id', 'DESC')->pluck('bal_total')->first();
            if (empty($default)) {
                $balance[] = 0;
            } else {
                $balance[] = $default;
            }
        }


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
            $pdf->loadView($prnt_page_dir, compact('datas', 'balance', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title, $balance), $pge_title . '_x.xlsx');
            }

        } else {
            return view('party_account_balance_list', compact('datas', 'areas', 'balance', 'search', 'account_list', 'regions', 'groups', 'sale_persons', 'search_region', 'search_area', 'search_sector', 'search_group', 'areas', 'sectors', 'search_by_user', 'search_sale_persons'));
        }
    }


    // update code by shahzaib start
    public
    function salary_account_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $groups = AccountGroupModel::where('ag_clg_id', '=', $user->user_clg_id)->orderBy('ag_title', 'ASC')->get();
        $first_heads = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_level', 1)->orderBy('coa_id', 'ASC')->get();
        $second_heads = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_level', 2)->orderBy('coa_id', 'ASC')->get();
        $third_heads = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_level', 3)->orderBy('coa_id', 'ASC')->get();


//        $heads = explode(',', config('global_variables.salary_expense_account'));

        $salary_expense_second_head = config('global_variables.salary_expense_second_head');

        $heads = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_parent', $salary_expense_second_head)->orderBy('coa_id', 'ASC')->pluck('coa_code')->all();

        $query = DB::table('financials_accounts')
            ->leftJoin('financials_coa_heads as parent_account', 'parent_account.coa_code', 'financials_accounts.account_parent_code')
            ->leftJoin('financials_coa_heads as group_account', 'group_account.coa_code', 'parent_account.coa_parent')
            ->leftJoin('financials_coa_heads as control_account', 'control_account.coa_code', 'group_account.coa_parent')
            ->leftJoin('financials_account_group', 'financials_account_group.ag_id', 'financials_accounts.account_group_id')
            ->leftJoin('financials_advance_salary', 'financials_advance_salary.as_emp_advance_salary_account', 'financials_accounts.account_link_uid')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_accounts.account_createdby')
            ->where('account_clg_id', '=', $user->user_clg_id)
            ->where('group_account.coa_clg_id', '=', $user->user_clg_id)
            ->where('control_account.coa_clg_id', '=', $user->user_clg_id)
            ->where('parent_account.coa_clg_id', '=', $user->user_clg_id);

        $query_list = DB::table('financials_accounts')->where('account_clg_id', '=', $user->user_clg_id);


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_first_head = (!isset($request->first_head) && empty($request->first_head)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->first_head;
        $search_second_head = (!isset($request->second_head) && empty($request->second_head)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->second_head;
        $search_third_head = (!isset($request->third_head) && empty($request->third_head)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->third_head;
        $search_group = (!isset($request->group) && empty($request->group)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->group;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.salary_account_list.salary_account_list';
        $pge_title = 'Salary Account List';
        $srch_fltr = [];
        if (empty($search_year)) {
            $search_year = $this->getYearEndId();
        }
        array_push($srch_fltr, $search, $search_first_head, $search_second_head, $search_third_head, $search_group,$search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        if (!empty($search)) {
//            $pagination_number = 1000000;
            $query->where(function ($query) use ($search) {
                $query->where('account_uid', 'like', '%' . $search . '%')
                    ->orWhere('account_name', 'like', '%' . $search . '%')
                    ->orWhere('user_designation', 'like', '%' . $search . '%')
                    ->orWhere('user_name', 'like', '%' . $search . '%')
                    ->orWhere('user_username', 'like', '%' . $search . '%')
                    ->orWhere('ag_title', 'like', '%' . $search . '%');
            });
        }

        if (!empty($search_first_head)) {
//            $pagination_number = 1000000;
            $query->where('control_account.coa_code', $search_first_head);
        }

        if (!empty($search_second_head)) {
//            $pagination_number = 1000000;
            $query->where('group_account.coa_code', $search_second_head);
        }

        if (!empty($search_third_head)) {
//            $pagination_number = 1000000;
            $query->where('account_parent_code', $search_third_head);
        }

        if (!empty($search_group)) {
//            $pagination_number = 1000000;
            $query->where('account_group_id', $search_group);
        }

        if (!empty($search_by_user)) {
//            $pagination_number = 1000000;
            $query->where('account_createdby', $search_by_user);
        }

        if ($user->user_level !== 100) {
            $query->whereIn('account_group_id', explode(',', $user->user_account_reporting_group_ids));
            $query_list->whereIn('account_group_id', explode(',', $user->user_account_reporting_group_ids));
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1) {
            $query->where('account_delete_status', '=', 1);
        } else {
            $query->where('account_delete_status', '!=', 1);
        }


        $datas = $query->whereIn('account_parent_code', $heads)
            ->where('account_delete_status', '!=', 1)
            ->select('financials_accounts.*', 'financials_users.user_id', 'financials_users.user_name', 'financials_users.user_designation', 'financials_account_group.ag_title', 'parent_account.coa_head_name as parnt_acnt_name', 'group_account.coa_head_name as grp_acnt_name', 'financials_advance_salary.as_amount')
//            ->select('financials_accounts.*', 'financials_users.user_name', 'financials_users.user_designation', 'financials_account_group.ag_title', 'financials_advance_salary.as_amount')
            ->orderBy('account_parent_code', 'ASC')
            ->orderBy('account_name', 'ASC')
            ->paginate($pagination_number);


        $account_list = $query_list->whereIn('account_parent_code', $heads)
            ->where('account_delete_status', '!=', 1)
            ->orderBy('account_parent_code', 'ASC')
            ->orderBy('account_name', 'ASC')
            ->pluck('account_name')
            ->all();

//        $third_parent = $this->get_third_parent_name(config('global_variables.salaries_account'));
//        $third_parent_name = $third_parent->coa_head_name;
//        $second_parent_name = $this->get_second_parent_name($third_parent->coa_parent);

        $balance = [];
        foreach ($datas as $account) {
            $default = 0;
            if ($this->getYearEndId() == $search_year) {
                $default = BalancesModel::where('bal_clg_id', '=', $user->user_clg_id)->where('bal_account_id', $account->account_uid)->orderBy('bal_id', 'DESC')->pluck('bal_total')->first();
            } else {
                $tableName = 'financials_balances_' . $search_year;
                $default = DB::table($tableName)->where('bal_clg_id', '=', $user->user_clg_id)->where('bal_account_id', $account->account_uid)->where('bal_year_id', $search_year)->orderBy('bal_id', 'DESC')->pluck('bal_total')->first();
            }
            if (empty($default)) {
                $balance[] = 0;
            } else {
                $balance[] = $default;
            }
        }


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
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title', 'balance'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title, $balance), $pge_title . '_x.xlsx');
            }

        } else {
            return view('salary_account_list', compact('datas', 'balance','search_year','search', 'search_first_head', 'search_second_head', 'search_third_head', 'search_group', 'account_list', 'groups', 'first_heads', 'second_heads', 'third_heads', 'restore_list'));
        }
    }

    // update code by shahzaib end


    // update code by shahzaib start
    public
    function bank_account_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $groups = AccountGroupModel::where('ag_clg_id', '=', $user->user_clg_id)->orderBy('ag_title', 'ASC')->get();
        $first_heads = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_level', 1)->orderBy('coa_id', 'ASC')->get();
        $second_heads = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_level', 2)->orderBy('coa_id', 'ASC')->get();
        $third_heads = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_level', 3)->orderBy('coa_id', 'ASC')->get();


        $heads = config('global_variables.bank_head');
        $heads = explode(',', $heads);


        $query = DB::table('financials_accounts')
            ->leftJoin('financials_coa_heads as parent_account', 'parent_account.coa_code', 'financials_accounts.account_parent_code')
            ->leftJoin('financials_coa_heads as group_account', 'group_account.coa_code', 'parent_account.coa_parent')
            ->leftJoin('financials_coa_heads as control_account', 'control_account.coa_code', 'group_account.coa_parent')
            ->leftJoin('financials_account_group', 'financials_account_group.ag_id', 'financials_accounts.account_group_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_accounts.account_createdby')
            ->where('account_clg_id', '=', $user->user_clg_id)
            ->where('group_account.coa_clg_id', '=', $user->user_clg_id)
            ->where('control_account.coa_clg_id', '=', $user->user_clg_id)
            ->where('parent_account.coa_clg_id', '=', $user->user_clg_id);


        $query_list = DB::table('financials_accounts')->where('account_clg_id', '=', $user->user_clg_id);

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_first_head = (!isset($request->first_head) && empty($request->first_head)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->first_head;
        $search_second_head = (!isset($request->second_head) && empty($request->second_head)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->second_head;
        $search_third_head = (!isset($request->third_head) && empty($request->third_head)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->third_head;
        $search_group = (!isset($request->group) && empty($request->group)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->group;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.bank_account_list.bank_account_list';
        $pge_title = 'Bank Account List';
        $srch_fltr = [];
        if (empty($search_year)) {
            $search_year = $this->getYearEndId();
        }
        array_push($srch_fltr, $search, $search_first_head, $search_second_head, $search_third_head, $search_group, $search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        if (!empty($search)) {
            $pagination = 1000000;
            $query->where(function ($Cquery) use ($search) {
                $Cquery->where('account_uid', 'like', '%' . $search . '%')
                    ->orWhere('account_name', 'like', '%' . $search . '%')
                    ->orWhere('parent_account.coa_head_name', 'like', '%' . $search . '%')
                    ->orWhere('group_account.coa_head_name', 'like', '%' . $search . '%')
                    ->orWhere('user_designation', 'like', '%' . $search . '%')
                    ->orWhere('user_name', 'like', '%' . $search . '%')
                    ->orWhere('user_username', 'like', '%' . $search . '%')
                    ->orWhere('ag_title', 'like', '%' . $search . '%');
            });
        }

        if (!empty($search_first_head)) {
//            $pagination_number = 1000000;
            $query->where('control_account.coa_code', $search_first_head);
        }

        if (!empty($search_second_head)) {
//            $pagination_number = 1000000;
            $query->where('group_account.coa_code', $search_second_head);
        }

        if (!empty($search_third_head)) {
//            $pagination_number = 1000000;
            $query->where('account_parent_code', $search_third_head);
        }

        if (!empty($search_group)) {
            $pagination_number = 1000000;

            $query->where('account_group_id', $search_group);
        }

        if (!empty($search_by_user)) {
            $pagination_number = 1000000;

            $query->where('account_createdby', $search_by_user);
        }

        if ($user->user_level !== 100) {
            $query->whereIn('account_group_id', explode(',', $user->user_account_reporting_group_ids));
            $query_list->whereIn('account_group_id', explode(',', $user->user_account_reporting_group_ids));
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1) {
            $query->where('account_delete_status', '=', 1);
        } else {
            $query->where('account_delete_status', '!=', 1);
        }


        $datas = $query->whereIn('account_parent_code', $heads)
//            ->where('account_delete_status', '!=', 1)
            ->select('financials_accounts.*', 'financials_users.user_id', 'financials_users.user_name', 'financials_users.user_designation', 'financials_account_group.ag_title', 'parent_account.coa_head_name as parnt_acnt_name', 'group_account.coa_head_name as grp_acnt_name')
//            ->select('financials_accounts.*', 'financials_users.user_name', 'financials_users.user_designation', 'financials_account_group.ag_title')
            ->orderBy('account_parent_code', 'ASC')
            ->orderBy('account_name', 'ASC')
            ->paginate($pagination_number);

        $account_list = $query_list->whereIn('account_parent_code', $heads)
            ->where('account_clg_id', '=', $user->user_clg_id)
            ->where('account_delete_status', '!=', 1)
            ->orderBy('account_parent_code', 'ASC')
            ->orderBy('account_name', 'ASC')
            ->pluck('account_name')
            ->all();

//        $third_parent = $this->get_third_parent_name(config('global_variables.bank_head'));
//        $third_parent_name = $third_parent->coa_head_name;
//        $second_parent_name = $this->get_second_parent_name($third_parent->coa_parent);

        $balance = [];
        foreach ($datas as $account) {
            $default = 0;
            if ($this->getYearEndId() == $search_year) {
                $default = BalancesModel::where('bal_clg_id', '=', $user->user_clg_id)->where('bal_account_id', $account->account_uid)->where('bal_year_id', $search_year)->orderBy('bal_id', 'DESC')->pluck('bal_total')->first();
            } else {
                $tableName = 'financials_balances_' . $search_year;
                $default = DB::table($tableName)->where('bal_clg_id', '=', $user->user_clg_id)->where('bal_account_id', $account->account_uid)->where('bal_year_id', $search_year)->orderBy('bal_id', 'DESC')->pluck('bal_total')->first();
            }
            if (empty($default)) {
                $balance[] = 0;
            } else {
                $balance[] = $default;
            }
        }


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
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title', 'balance'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title, $balance), $pge_title . '_x.xlsx');
            }

        } else {
            return view('bank_account_list', compact('datas', 'balance', 'search_year', 'search', 'account_list', 'search_group', 'groups', 'first_heads', 'second_heads', 'third_heads', 'search_first_head', 'search_second_head', 'search_third_head', 'restore_list'));
        }
    }

    // update code by shahzaib end

    public
    function edit_account(Request $request)
    {
        $user = Auth::user();
        $account = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_id', $request->acc_id)->first();

//        $salary_structure = SalaryAccountStructureModel::where('sas_account_uid', $account->account_uid)->first();

        $third_head = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_delete_status', '!=', 1)->where('coa_code', $account->account_parent_code)->first();
        $second_head = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_delete_status', '!=', 1)->where('coa_code', $third_head->coa_parent)->first();
        $first_head = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_delete_status', '!=', 1)->where('coa_code', $second_head->coa_parent)->first();
        $groups = AccountGroupModel::where('ag_clg_id', '=', $user->user_clg_id)->where('ag_delete_status', '!=', 1)->orderBy('ag_title', 'ASC')->get();

        return view('edit_account', compact('account', 'third_head', 'second_head', 'first_head', 'groups'));
    }

    public
    function update_account(Request $request)
    {
        $this->account_update_validation($request);
        $user = Auth::user();
        $check_account = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_name', $request->account_name)->where('account_parent_code', $request->head_code)
            ->where('account_id', '!=', $request->account_id)->count();

        if ($check_account > 0) {

            if ($request->head_code == config('global_variables.bank_head')) {
                return redirect('bank_account_list')->with('fail', 'Account Already Exist!');
            } elseif ($request->head_code == config('global_variables.salaries_account')) {
                return redirect('salary_account_list')->with('fail', 'Account Already Exist!');
            } elseif (substr($request->head_code, 0, 1) == config('global_variables.expense')) {
                return redirect('expense_account_list')->with('success', 'Successfully Saved');
            } else {
                return redirect('account_list')->with('success', 'Successfully Saved');
            }
        }

        $account = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_id', $request->account_id)->first();

        $account = $this->AssignUpdateAccountValues($request, $account);

        $account->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Account With Unique Id: ' . $account->account_uid . ' And Name: ' . $account->account_name);

        if ($request->head_code == config('global_variables.bank_head')) {
            return redirect('bank_account_list')->with('success', 'Successfully Saved');
        } elseif ($request->head_code == config('global_variables.salary_expense_account')) {
            return redirect('salary_account_list')->with('success', 'Successfully Saved');
        } elseif (substr($request->head_code, 0, 1) == config('global_variables.expense')) {
            return redirect('expense_account_list')->with('success', 'Successfully Saved');
        } else {
            return redirect('account_list')->with('success', 'Successfully Saved');
        }

        return redirect()->back()->with('success', 'Successfully Saved');
    }

    public
    function account_update_validation($request)
    {
        $user = Auth::user();
        return $this->validate($request, [
            'account_id' => ['required', 'numeric'],
            'group' => ['required', 'numeric'],
            'head_code' => ['required', 'string'],
            'account_name' => 'required|unique:financials_accounts,account_name,' . $request->account_id . ',account_id,account_parent_code,' . $request->head_code . ',account_clg_id,' . $user->user_clg_id,
            'remarks' => ['nullable', 'string'],
        ]);
    }

    protected
    function AssignUpdateAccountValues($request, $account)
    {
        $account->account_name = ucwords($request->account_name);
        $account->account_group_id = $request->group;
        $account->account_remarks = ucfirst($request->remarks);

        // coding from shahzaib start
        $tbl_var_name = 'account';
        $prfx = 'account';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        return $account;
    }

    public
    function get_head(Request $request)
    {
        $user = Auth::user();
        $first_head_code = $request->first_head_code;
        $second_head_code = $request->second_head_code;

        if (isset($first_head_code)) {

            $heads = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_parent', $first_head_code)->where('coa_delete_status', '!=', 1)->where('coa_disabled', '!=', 1)
                ->orderBy('coa_id', 'ASC')->get();

            $get_head = "<option value=''>Select Parent Account</option>";
            foreach ($heads as $head) {

                $selected = $head->coa_code == $request->second_parent ? 'selected' : '';

                $get_head .= "<option value='$head->coa_code' $selected>$head->coa_head_name</option>";
            }

        } elseif (isset($second_head_code)) {
            if ($second_head_code == 411) {
                $heads = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_code', 41111)->where('coa_delete_status', '!=', 1)->where('coa_disabled', '!=', 1)->orderBy('coa_id', 'ASC')->get();
            } elseif ($second_head_code == 414) {
                $heads = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_code', 41410)->where('coa_delete_status', '!=', 1)->where('coa_disabled', '!=', 1)->orderBy('coa_id', 'ASC')->get();
            } else {
                $heads = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_parent', $second_head_code)->where('coa_delete_status', '!=', 1)->where('coa_disabled', '!=', 1)->orderBy('coa_id', 'ASC')->get();
            }
            $get_head = "<option value=''>Select Child Account</option>";
            foreach ($heads as $head) {
                $get_head .= "<option value='$head->coa_code' >$head->coa_head_name</option>";
            }

        } else {
            $get_head = "<option value=''>Select Parent Account</option>";
        }

        return response()->json($get_head);
    }

    public
    function get_account_heads(Request $request)
    {
        $first_head_code = $request->first_head_code;
        $second_head_code = $request->second_head_code;
        $user = Auth::user();
        if (isset($first_head_code)) {

//            $heads = AccountHeadsModel::where('coa_parent', $first_head_code)->where('coa_delete_status', '!=', 1)->where('coa_disabled', '!=', 1)->where('coa_code', '!=', config('global_variables.salary_expense_second_head'))->where('coa_code', '!=', config('global_variables.fixed_asset_second_head'))->orderBy('coa_id', 'ASC')->get();
            $heads = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_parent', $first_head_code)->where('coa_delete_status', '!=', 1)->where('coa_disabled', '!=', 1)
                ->where('coa_code',
                    '!=', config('global_variables.fixed_asset_second_head'))->orderBy('coa_id', 'ASC')->get();

            $get_head = "<option value=''>Select Parent Account</option>";
            foreach ($heads as $head) {

                $selected = $head->coa_code == $request->second_parent ? 'selected' : '';

                $get_head .= "<option value='$head->coa_code' $selected>$head->coa_head_name</option>";
            }

        } elseif (isset($second_head_code)) {

            $heads = AccountHeadsModel::whereNotIn('coa_code', ['11013', '21010'])->where('coa_parent', $second_head_code)->where('coa_clg_id', '=', $user->user_clg_id)->where('coa_delete_status', '!=', 1)->where('coa_disabled', '!=', 1)
                ->orderBy('coa_id', 'ASC')->get();

            $get_head = "<option value=''>Select Child Account</option>";
            foreach ($heads as $head) {
                $get_head .= "<option value='$head->coa_code' >$head->coa_head_name</option>";
            }

        } else {
            $get_head = "<option value=''>Select Parent Account</option>";
        }

        return response()->json($get_head);
    }

    public
    function get_accounts_by_parent($parent)
    {
        $user = Auth::user();
        $accounts = AccountRegisterationModel::where('coa_clg_id', '=', $user->user_clg_id)->where('account_uid', 'like', $parent . '%')->get();

        return $accounts;
    }

    public
    function edit_account_receivable_payable(Request $request)
    {
        $user = Auth::user();
        $account = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_id', $request->acc_id)->first();

        $regions = RegionModel::where('reg_clg_id', '=', $user->user_clg_id)->where('reg_delete_status', '!=', 1)->where('reg_disabled', '!=', 1)->orderBy('reg_title', 'ASC')->get();

        $account_type = $request->account_type;

        $groups = AccountGroupModel::where('ag_clg_id', '=', $user->user_clg_id)->where('ag_delete_status', '!=', 1)->where('ag_disabled', '!=', 1)->orderBy('ag_title', 'ASC')->get();

        $sale_persons = User::where('user_id', '!=', 1)->where('user_designation', '!=', 1)->where('user_clg_id', '=', $user->user_clg_id)->where('user_delete_status', '!=', 1)
            ->where('user_disabled', '!=', 1)
            ->where('user_id', '!=', 1)->where('user_role_id', 4)->orderBy('user_name', 'ASC')->get();
        $purchasers = User::where('user_id', '!=', 1)->where('user_designation', '!=', 1)->where('user_clg_id', '=', $user->user_clg_id)->where('user_delete_status', '!=', 1)
            ->where('user_disabled', '!=', 1)
            ->where('user_id', '!=', 1)->where('user_role_id', 5)->orderBy('user_name', 'ASC')->get();
        $modular_groups = ModularGroupModel::where('mg_delete_status', '!=', 1)->where('mg_disabled', '!=', 1)->orderby('mg_title', 'ASC')->get();
        return view('edit_account_receivable_payable', compact('account', 'regions', 'account_type', 'groups', 'sale_persons', 'modular_groups', 'purchasers'));
    }

    public
    function update_account_receivable_payable(Request $request)
    {
        $user = Auth::user();
        $this->account_receivable_payable_update_validation($request);
        if (isset($request->make_credentials)) {
            $this->employee_credentials_validation($request);
        }
        $check_account = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_name', $request->account_name)->where('account_parent_code', $request->head_code)
            ->where('account_id', '!=', $request->account_id)->count();

        if ($check_account > 0) {
            return redirect()->back()->with('fail', 'Account Already Exist!');
        }

        $client_supplier = new User();

        $password = Utility::uniqidReal();

        if (isset($request->make_credentials)) {
            $client_supplier = $this->AssignEmployeeValues($request, $client_supplier, $password);
            if ($client_supplier->save()) {
                $employee_id = $client_supplier->user_id;
                $employee_name = $client_supplier->user_name;

                $client_supplier->user_employee_code = $this->generate_employee_code($employee_id, $employee_name);
                $client_supplier->save();
            }
        }

        $account = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_id', $request->account_id)->first();

        $account = $this->AssignUpdateReceivablePayableAccountValues($request, $account);
        if (isset($request->make_credentials)) {
            $account->account_employee_id = $client_supplier->user_id;
        }
        $account->save();
        if (isset($request->make_credentials)) {
            $this->SendPasswordMail($request->email, $request->username, $password);
//            Mail::to($request->email)->send(new PasswordMail($password, $request->username));
        }


        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Account With Unique Id: ' . $account->account_uid . ' And Name: ' . $account->account_name);

        return redirect()->route('account_receivable_payable_simple_list')->with('success', 'Successfully Saved');
    }

    public
    function account_receivable_payable_update_validation($request)
    {
        $user = Auth::user();
        return $this->validate($request, [
            'account_id' => ['required', 'numeric'],
            'head_code' => ['required', 'string'],
            'region' => ['required', 'numeric'],
            'area' => ['required', 'numeric'],
            'sector' => ['required', 'numeric'],
            'group' => ['required', 'numeric'],
            'account_name' => 'required|unique:financials_accounts,account_name,' . $request->account_id . ',account_id,account_parent_code,' . $request->head_code . ',account_clg_id,' . $user->user_clg_id,
            'remarks' => ['nullable', 'string'],
            'print_name' => ['nullable', 'string'],
            'cnic' => ['nullable', 'regex:/^\d{5}-\d{7}-\d$|^\d{13}$/'],
            'opening_balance' => ['nullable', 'numeric'],
            'address' => ['nullable', 'string'],
            'proprietor' => ['nullable', 'string'],
            'co_code' => ['nullable', 'string'],
            'mobile' => ['nullable', 'regex:/^((\+92)|(0092))-?3\d{2}-?\d{7}$|^03\d{2}-?\d{7}$/'],
            'whatsapp' => ['nullable', 'regex:/^((\+92)|(0092))-?3\d{2}-?\d{7}$|^03\d{2}-?\d{7}$/'],
            'phone' => ['nullable', 'regex:/^\d{3}-?\d{3}-?\d{4}$|^\d{3} ?\d{3} ?\d{4}$/'],
            'email' => ['nullable', 'email'],
            'gst' => ['nullable', 'regex:/^([0-9]{1}[0-9]{1})-?([0-9]{1}[0-9]{1})-?([0-9]{4}-?[0-9]{3}-?[0-9]{2})+$|^([0-9]{1}[0-9]{1}) ?([0-9]{1}[0-9]{1}) ?([0-9]{4} ?[0-9]{3} ?[0-9]{2})+$/'],
            'ntn' => ['nullable', 'regex:/^\d{7}-?\d$/'],
            'credit_limit' => ['nullable', 'numeric', 'min:0'],
            'page_no' => ['nullable', 'string'],
            'sale_person' => ['nullable', 'numeric'],
            'discountType' => ['required'],
        ]);
    }

    protected
    function AssignUpdateReceivablePayableAccountValues($request, $account)
    {
        $user = Auth::user();
        $account->account_region_id = $request->region;
        $account->account_area = $request->area;
        $account->account_sector_id = $request->sector;
        $account->account_name = ucwords($request->account_name);
        $account->account_urdu_name = ucwords($request->account_urdu_name);
        $account->account_print_name = ucwords($request->print_name);
        $account->account_cnic = $request->cnic;
        $account->account_remarks = ucfirst($request->remarks);
        if ($request->head_code == 21010) {
            if (isset($request->purchaser) && !empty($request->purchaser)) {
                $account->account_sale_person = $request->purchaser;
            }
        }

        if (isset($request->sale_person) && !empty($request->sale_person)) {
            $account->account_sale_person = $request->sale_person;
        }


//        if ($request->opening_balance != '') {
//            $account->account_balance = $request->opening_balance;
//        } else {
//            $account->account_balance = 0;
//        }
        $account->account_address = ucfirst($request->address);
        $account->account_proprietor = $request->proprietor;
        $account->account_company_code = $request->co_code;
        $account->account_mobile_no = $request->mobile;
        $account->account_whatsapp = $request->whatsapp;
        $account->account_phone = $request->phone;
        $account->account_email = $request->email;
        $account->account_gst = $request->gst;
        $account->account_ntn = $request->ntn;
        $account->account_discount_type = $request->discountType;
//        $account->account_credit_limit = $request->credit_limit;
        if (isset($request->unlimited)) {
            $account->account_credit_limit_status = 1;
            $account->account_credit_limit = 0;
        } else {
            $account->account_credit_limit = isset($request->credit_limit) ? $request->credit_limit : 0;
        }
        $account->account_page_no = $request->page_no;
        $account->account_group_id = $request->group;
        $account->account_clg_id = $user->user_clg_id;

        // coding from shahzaib start
        $tbl_var_name = 'account';
        $prfx = 'account';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        return $account;
    }

    public
    function get_account($employee_id)
    {
//        $cash_in_hand = AccountRegisterationModel::where('account_employee_id', $account_id)->first();
        $user = Auth::user();
        $cash_in_hand = User::where('user_id', '!=', 1)->where('user_designation', '!=', 1)->where('user_clg_id', '=', $user->user_clg_id)->where('user_id', $employee_id)->first();

        return $cash_in_hand;
    }

    public
    function get_account_info(Request $request)
    {
        $user = Auth::user();
        $account_id = $request->account_id;

        $account = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $account_id)->first();

        return response()->json($account);
    }

    public
    function delete_account(Request $request)
    {
        $account_id = $request->account_id;
        $default_accounts = explode(',', config('global_variables.default_account_list'));

        $user = Auth::User();

        if (in_array($account_id, $default_accounts)) {
            return redirect()->back()->with('fail', "Can't Be Deleted");
        }

        $delete_account = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $account_id)->first();

//        $delete_account->account_delete_status = 1;
        if ($delete_account->account_delete_status == 1) {
            $delete_account->account_delete_status = 0;
        } else {
            $delete_account->account_delete_status = 1;
        }
        $delete_account->account_deleted_by = $user->user_id;

        if ($delete_account->save()) {

            if ($delete_account->account_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Account With Unique Id: ' . $delete_account->account_uid . ' And Name: ' . $delete_account->account_name);

                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Account With Unique Id: ' . $delete_account->account_uid . ' And Name: ' . $delete_account->account_name);

                return redirect()->back()->with('success', 'Successfully Deleted');
            }

        } else {
            return redirect()->back()->with('fail', "Failed Try Again");
        }
    }

    public
    function fixed_asset()
    {
        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();
        $dayend_date =
            date('m-d-Y', strtotime($day_end->de_datetime));

        $user = Auth::user();

        $fixed_assets = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_delete_status', '!=', 1)->where('coa_disabled', '!=', 1)->where('coa_parent', config('global_variables.fixed_asset_second_head'))->orderBy('coa_id', 'ASC')->get();

        $parent_expense_head = explode(',', config('global_variables.cgs_second_head') . ',' . config('global_variables.operating_expense_second_head'));

        $expense_heads = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_delete_status', '!=', 1)->where('coa_disabled', '!=', 1)->whereIn('coa_code',
            $parent_expense_head)->orderBy('coa_id', 'ASC')->get();

        $groups = AccountGroupModel::where('ag_clg_id', '=', $user->user_clg_id)->where('ag_delete_status', '!=', 1)->where('ag_disabled', '!=', 1)->orderBy('ag_title', 'ASC')->get();

        return view('fixed_asset_registration', compact('fixed_assets', 'groups', 'expense_heads', 'dayend_date'));
    }

    public
    function submit_fixed_asset_excel(Request $request)
    {
        $rules = [
            'add_fixed_asset_excel' => 'required|mimes:xlsx,xls,csv|max:5000',
        ];

        $messages = [
            'add_fixed_asset_excel.max' => "Your File size too long.",
            'add_fixed_asset_excel.required' => "Please select your Account Excel Sheet.",
        ];

        $validator = $this->validate($request, $rules, $messages);

        if ($request->hasFile('add_fixed_asset_excel')) {

//            dd($request->add_employee_excel);
//            $dateTime = date('Ymd_His');
//            $file = $request->file('add_employee_excel');
//            $fileName = $dateTime . '-' . $file->getClientOriginalName();
//            $savePath = public_path('/uploads/'.config('global_variables.excel_storage_folder_name'));
//            $file->move($savePath, $fileName);
//            $data = Excel::load($path)->get();


            $path = $request->file('add_fixed_asset_excel');
            $data = Excel::toArray(new ExcelDataImport, $path);

            $excelData = json_decode(json_encode($data), FALSE);
            foreach ($excelData as $rows) {
                foreach ($rows as $row) {

                    $rowData = (array)$row;
                    $request->merge($rowData);

                    $this->fixed_asset_validation_excel($request);


                    $rollBack = self::excel_form_fixed_asset($row);

                    if ($rollBack) {
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed Try Again');
                    } else {
                        DB::commit();
                    }
                }

            }

            return redirect()->back()->with(['success' => 'File Uploaded successfully.']);
        } else {
            return redirect()->back()->with(['errors' => $validator]);
        }
    }

    public
    function submit_fixed_asset(Request $request)
    {
        return self::simple_form_fixed_asset($request);
//        $this->fixed_asset_validation($request);
//
//        if ($request->account_type == 1) {
//            $this->validate($request, [
//                'expense_group_account' => ['required', 'numeric'],
//                'expense_parent_account' => ['required', 'numeric'],
//            ]);
//        }
//
//        $user = Auth::User();
//        $rollBack = false;
//
//        DB::beginTransaction();
//
//        /////////////////////////////////////////////////// 1st Account //////////////////////////////////////////////////////
//
//        $parent_code = $request->head_code;
//
//        $account = new AccountRegisterationModel();
//        $account = $this->AssignAccountValues($request, $account, $parent_code, 0, '');
//
//        if (!$account->save()) {
//            $rollBack = true;
//        }
//
//        $account_uid = $account->account_uid;
//        $account_name = $account->account_name;
//
//        $account_balance = new BalancesModel();
//
//        $account_balance = $this->add_balance($account_balance, $account_uid, $account_name);
//
//        if (!$account_balance->save()) {
//            $rollBack = true;
//        }
//
//        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $account_uid . ' And Name: ' . $account_name);
//
//
//        if ($request->account_type == 2) {
//
//            $pre_account_name = 'Amo. ';
//            $account_type_parent_code = config('global_variables.amortization');
//        } else {
//            $pre_account_name = 'Dep. ';
//
//            if (isset($request->expense_parent_account) && !empty($request->expense_parent_account)) {
//                $account_type_parent_code = $request->expense_parent_account;
//            } else {
//
//                $account_type_parent_code = config('global_variables.depreciation');
//            }
//
//        }
//
//        /////////////////////////////////////////////////// 2nd Account //////////////////////////////////////////////////////
//
//        $accumulated_account = new AccountRegisterationModel();
//
//        $accumulated_account = $this->AssignAccountValues($request, $accumulated_account, $parent_code, 0, 'Acc. ' . $pre_account_name);
//
//        if (!$accumulated_account->save()) {
//            $rollBack = true;
//        }
//
//        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $accumulated_account->account_uid . ' And Name: '
//            . $accumulated_account->account_name);
//
//
//        $account_balance = new BalancesModel();
//
//        $account_balance = $this->add_balance($account_balance, $accumulated_account->account_uid, $accumulated_account->account_name);
//
//        if (!$account_balance->save()) {
//            $rollBack = true;
//        }
//
//        /////////////////////////////////////////////////// 3rd Account //////////////////////////////////////////////////////
//
//
//        $expense_or_revenue_account = new AccountRegisterationModel();
//
//        $expense_or_revenue_account = $this->AssignAccountValues($request, $expense_or_revenue_account, $account_type_parent_code, 0, $pre_account_name);
//
//        if (!$expense_or_revenue_account->save()) {
//            $rollBack = true;
//        }
//
//        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $expense_or_revenue_account->account_uid . ' And Name: '
//            . $expense_or_revenue_account->account_name);
//
//        $account_balance = new BalancesModel();
//
//        $account_balance = $this->add_balance($account_balance, $expense_or_revenue_account->account_uid, $expense_or_revenue_account->account_name);
//
//        if (!$account_balance->save()) {
//            $rollBack = true;
//        }
//
//        $this->parent_account_uid = $account->account_uid;
//        $this->link_account_uids .= $account->account_uid . ',' . $accumulated_account->account_uid . ',' . $expense_or_revenue_account->account_uid;
//
//
//        $fixed_asset = new FixedAssetModel();
//
//        $fixed_asset = $this->AssignFixedAssetValues($request, $fixed_asset);
//
//        if (!$fixed_asset->save()) {
//            $rollBack = true;
//            DB::rollBack();
//        }
//
//        if ($rollBack) {
//            DB::rollBack();
//            return redirect()->back()->with('fail', 'Failed Try Again');
//        } else {
//            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Fixed Asset With Unique Id: ' . $fixed_asset->fa_id . ' And Name: '
//                . $fixed_asset->fa_account_name);
//
//            DB::commit();
//            // WizardController::updateWizardInfo(['asset_registration'], []);
//            return redirect()->back()->with('success', 'Successfully Saved');
//        }
    }


    public
    function fixed_asset_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $groups = AccountGroupModel::where('ag_clg_id', '=', $user->user_clg_id)->orderBy('ag_title', 'ASC')->get();

        $fixed_asset_second_head = config('global_variables.fixed_asset_second_head');

        $third_heads = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_parent', $fixed_asset_second_head)->orderBy('coa_id', 'ASC')->get();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_first_head = (!isset($request->first_head) && empty($request->first_head)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->first_head;
        $search_group = (!isset($request->group) && empty($request->group)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->group;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.fixed_asset_list.fixed_asset_list';
        $pge_title = 'Fixed Account List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_first_head, $search_group);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_fixed_asset')
            ->leftJoin('financials_coa_heads as parent_account', 'parent_account.coa_code', 'financials_fixed_asset.fa_parent_account_uid')
            ->leftJoin('financials_coa_heads as group_account', 'group_account.coa_code', 'parent_account.coa_parent')
            ->leftJoin('financials_coa_heads as control_account', 'control_account.coa_code', 'group_account.coa_parent')
            ->leftJoin('financials_account_group', 'financials_account_group.ag_id', 'financials_fixed_asset.fa_group_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_fixed_asset.fa_user_id')
            ->where('fa_clg_id', '=', $user->user_clg_id);


        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('fa_account_name', 'like', '%' . $search . '%')
                    ->orWhere('fa_parent_account_uid', 'like', '%' . $search . '%')
                    ->orWhere('fa_group_id', 'like', '%' . $search . '%')
                    ->orWhere('fa_link_account_uids', 'like', '%' . $search . '%')
                    ->orWhere('fa_register_number', 'like', '%' . $search . '%')
                    ->orWhere('fa_supplier_details', 'like', '%' . $search . '%')
                    ->orWhere('fa_guarantee_period', 'like', '%' . $search . '%')
                    ->orWhere('fa_specification', 'like', '%' . $search . '%')
                    ->orWhere('fa_capacity', 'like', '%' . $search . '%')
                    ->orWhere('fa_size', 'like', '%' . $search . '%')
                    ->orWhere('fa_method', 'like', '%' . $search . '%')
                    ->orWhere('fa_dep_amo', 'like', '%' . $search . '%')
                    ->orWhere('fa_price', 'like', '%' . $search . '%')
                    ->orWhere('fa_residual_value', 'like', '%' . $search . '%')
                    ->orWhere('fa_dep_period', 'like', '%' . $search . '%')
                    ->orWhere('fa_posting', 'like', '%' . $search . '%')
                    ->orWhere('fa_acquisition_date', 'like', '%' . $search . '%')
                    ->orWhere('fa_remarks', 'like', '%' . $search . '%')
                    ->orWhere('fa_user_id', 'like', '%' . $search . '%')
                    ->orWhere('fa_date_time', 'like', '%' . $search . '%')
                    ->orWhere('fa_day_end_id', 'like', '%' . $search . '%')
                    ->orWhere('fa_day_end_date', 'like', '%' . $search . '%')
                    ->orWhere('user_designation', 'like', '%' . $search . '%')
                    ->orWhere('user_name', 'like', '%' . $search . '%')
                    ->orWhere('user_username', 'like', '%' . $search . '%')
                    ->orWhere('parent_account.coa_code', 'like', '%' . $search . '%')
                    ->orWhere('parent_account.coa_head_name', 'like', '%' . $search . '%')
                    ->orWhere('ag_title', 'like', '%' . $search . '%');
            });
        }

        if (!empty($search_first_head)) {
            $query->where('fa_parent_account_uid', '=', $search_first_head);
        }

        if (!empty($search_group)) {
            $query->where('fa_group_id', '=', $search_group);
        }

        if (!empty($search_by_user)) {
            $query->where('account_createdby', '=', $search_by_user);
        }

//        if ($user->user_level != 100) {
//            $query->whereIn('account_group_id', explode(',', $user->user_account_reporting_group_ids));
//        }

        $datas = $query->select('financials_fixed_asset.*', 'financials_users.user_id', 'financials_users.user_name', 'financials_users.user_designation', 'financials_account_group.ag_title', 'parent_account.coa_head_name as prnt_acnt_name')
            ->orderBy('fa_id', 'DESC')
            ->paginate($pagination_number);

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
//            $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('fixed_asset_list', compact('datas', 'search', 'search_first_head', 'search_group', 'third_heads', 'groups'));
        }
    }

    public
    function edit_fixed_asset(Request $request)
    {
        $user = Auth::user();
        $fixed_asset = FixedAssetModel::where('fa_clg_id', '=', $user->user_clg_id)->where('fa_id', $request->fixed_asset)->first();

        if ($fixed_asset->fa_dep_entries > 0) {
            return redirect()->back()->with('fail', 'Cannot Be Edited');
        }

        if ($fixed_asset) {
            $parent_account = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_delete_status', '!=', 1)->where('coa_disabled', '!=', 1)->where('coa_code',
                $fixed_asset->fa_parent_account_uid)->pluck('coa_head_name')->first();

            $group = AccountGroupModel::where('ag_clg_id', '=', $user->user_clg_id)->where('ag_delete_status', '!=', 1)->where('ag_disabled', '!=', 1)->where('ag_id', $fixed_asset->fa_group_id)
                ->pluck('ag_title')->first();

            $link_uids = explode(',', $fixed_asset->fa_link_account_uids);

            $parent_expense_head = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_delete_status', '!=', 1)->where('coa_disabled', '!=', 1)->where('coa_code', substr
            ($link_uids[2], 0, 5))->orderBy('coa_id', 'ASC')->first();

            $group_expense_head = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_code', $parent_expense_head->coa_parent)->where('coa_disabled', '!=', 1)->orderBy('coa_id', 'ASC')->first();

            return view('edit_fixed_asset_registration', compact('fixed_asset', 'parent_account', 'group', 'parent_expense_head', 'group_expense_head'));
        } else {
            return redirect()->back()->with('fail', 'Failed Try Again');
        }
    }

    public
    function update_fixed_asset(Request $request)
    {
        $this->update_fixed_asset_validation($request);
        $user = Auth::User();

        $fixed_asset = FixedAssetModel::where('fa_clg_id', '=', $user->user_clg_id)->where('fa_id', $request->fixed_asset)->first();

        $fixed_asset = $this->UpdateFixedAssetValues($request, $fixed_asset);

        if ($fixed_asset->save()) {

            $depAccounts = explode(',', $fixed_asset->fa_link_account_uids);
            $asset_first_account = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $depAccounts[0])->first();
            $asset_first_account->account_name = ucwords($request->account_name);
            $asset_first_account->save();
            $asset_second_account = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $depAccounts[1])->first();
            $asset_second_account->account_name = 'Acc. Dep. ' . ucwords($request->account_name);
            $asset_second_account->save();
            $asset_third_account = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_uid', $depAccounts[2])->first();
            $asset_third_account->account_name = 'Dep. ' . ucwords($request->account_name);
            $asset_third_account->save();
            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Fixed Asset With Unique Id: ' . $fixed_asset->fa_id . ' And Name: '
                . $fixed_asset->fa_account_name);

            return redirect()->back()->with('success', 'Successfully Saved');
        } else {
            return redirect()->back()->with('fail', 'Failed Try Again');
        }
    }

    public
    function update_fixed_asset_validation($request)
    {
        return $this->validate($request, [
            'fixed_asset' => ['required', 'numeric'],
            'account_name' => 'required | string',
            'asset_registration_no' => ['nullable', 'string'],
            'importer_supplier_detail' => ['nullable', 'string'],
            'asset_guarantee_period' => ['nullable', 'string'],
            'asset_specification' => ['nullable', 'string'],
            'asset_capacity' => ['nullable', 'string'],
            'asset_size' => ['nullable', 'string'],
            'asset_purchase_price' => ['required', 'numeric'],
            'residual_value' => ['required', 'string'],
            'useful_life' => ['required', 'string'],
            'depreciation_percentage' => ['required', 'numeric'],
            'acquisition_date' => ['required', 'date'],
            'remarks' => ['nullable', 'string'],
        ]);
    }

    protected
    function UpdateFixedAssetValues($request, $fixed_asset)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $fixed_asset->fa_account_name = ucwords($request->account_name);
        $fixed_asset->fa_register_number = $request->asset_registration_no;
        $fixed_asset->fa_supplier_details = $request->importer_supplier_detail;
        $fixed_asset->fa_guarantee_period = $request->asset_guarantee_period;
        $fixed_asset->fa_specification = $request->asset_specification;
        $fixed_asset->fa_capacity = $request->asset_capacity;
        $fixed_asset->fa_size = $request->asset_size;
        $fixed_asset->fa_method = $request->method;
        $fixed_asset->fa_dep_amo = $request->account_type;
        $fixed_asset->fa_price = $request->asset_purchase_price;
        $fixed_asset->fa_book_value = $request->asset_purchase_price;
        $fixed_asset->fa_residual_value = $request->residual_value;
        $fixed_asset->fa_useful_life_year = $request->useful_life;
        $fixed_asset->fa_useful_life_month = $request->useful_life * 12;
        $fixed_asset->fa_useful_life_day = $request->useful_life * 365;
        $fixed_asset->fa_dep_period = $request->depreciation_percentage_radio;
        $fixed_asset->fa_dep_percentage_year = $request->depreciation_percentage;
        $fixed_asset->fa_dep_percentage_month = $request->depreciation_percentage / 12;
        $fixed_asset->fa_dep_percentage_day = $request->depreciation_percentage / 365;
        $fixed_asset->fa_posting = $request->posting_method;
        $fixed_asset->fa_acquisition_date = date('Y-m-d', strtotime($request->acquisition_date));
        $fixed_asset->fa_remarks = ucfirst($request->remarks);
        $fixed_asset->fa_user_id = $user->user_id;
        $fixed_asset->fa_clg_id = $user->user_clg_id;
        $fixed_asset->fa_date_time = Carbon::now()->toDateTimeString();
        $fixed_asset->fa_day_end_id = $day_end->de_id;
        $fixed_asset->fa_day_end_date = $day_end->de_datetime;

        // coding from shahzaib start
        $tbl_var_name = 'fixed_asset';
        $prfx = 'fa';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        // coding from shahzaib end

        return $fixed_asset;
    }

    public
    function capital_registration()
    {
        $user = Auth::user();
        $users = User::where('user_id', '!=', 1)->where('user_designation', '!=', 1)->where('user_clg_id', '=', $user->user_clg_id)->where('user_delete_status', '!=', 1)
            ->where('user_disabled', '!=', 1)
            ->whereIn('user_role_id', [1, 4])
            ->whereIn('user_level', [100, 30])
            ->where('user_type', '!=', 'Master')
            ->select('user_id', 'user_name')->get();

        $equity_second_accounts = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_delete_status', '!=', 1)->where('coa_disabled', '!=', 1)->where('coa_parent', config('global_variables.equity'))->where('coa_level', 2)->orderBy('coa_id', 'ASC')->get();

        $total_capital = $this->calculate_total_capital();
        $software_package = PackagesModel::where('pak_clg_id', '=', $user->user_clg_id)->where('pak_id', '=', 1)->pluck('pak_name');
        return view('capital_registration', compact('users', 'equity_second_accounts', 'total_capital', 'software_package'));
    }

    public
    function submit_capital_registration(Request $request)
    {
        $user = Auth::User();
        $software_package = PackagesModel::where('pak_clg_id', '=', $user->user_clg_id)->where('pak_id', '=', 1)->pluck('pak_name')->first();
        $capital_id = CapitalRegistrationModel::where('cr_clg_id', '=', $user->user_clg_id)->pluck('cr_id')->first();

        if ($software_package == 'Basic') {
            if (!empty($capital_id)) {
                return redirect()->back()->with('fail', 'You are not able to create more account');
            }
        }

        $this->capital_registration_validation($request);

        $check_user_cap_account = CapitalRegistrationModel::where('cr_clg_id', '=', $user->user_clg_id)->where('cr_user_id', $request->user_name)->exists();

        if ($check_user_cap_account) {
            return redirect()->back()->with('fail', "Already Exist!");
        }


        DB::beginTransaction();

        $rollBack = $this->submit_capital_account($request, 0);

        $capital_registration = new CapitalRegistrationModel();

        $capital_registration = $this->AssignCapitalRegistrationValues($request, $capital_registration);

        if (!$capital_registration->save()) {
            $rollBack = true;
            DB::rollBack();
        }

        $recalculate_capital = $this->recalculate_capital();

        if (!$recalculate_capital) {
            $rollBack = true;
            DB::rollBack();
        }

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {

            $system_config = SystemConfigModel::where('sc_clg_id', '=', $user->user_clg_id)->first();

            if ($system_config->sc_all_done == 0) {
                $system_config->sc_admin_capital_added = 1;

                if (!$system_config->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }
            }


            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Capital Registration With Unique Id: ' . $capital_registration->fa_id . ' And Name: '
                . $capital_registration->fa_account_name);

            DB::commit();

            if (!empty($capital_registration)) {
                $capital_accounts = collect((object)array(
                    (object)['account_id' => $capital_registration->cr_capital_account_uid],
                    (object)['account_id' => $capital_registration->cr_profit_loss_account_uid],
                    (object)['account_id' => $capital_registration->cr_drawing_account_uid],
                    (object)['account_id' => $capital_registration->cr_reserve_account_uid])
                );
            }
            foreach ($capital_accounts as $account) {
                $trial_balance = new OpeningTrialBalanceModel();
                $trial_balance->tb_account_id = $account->account_id;
                $trial_balance->tb_account_name = AccountRegisterationModel::where('account_uid', $account->account_id)->where('account_clg_id', $user->user_clg_id)->pluck('account_name')
                    ->first();
                $trial_balance->tb_total_debit = 0;
                $trial_balance->tb_total_credit = 0;
                $trial_balance->tb_clg_id = $user->user_clg_id;
                $trial_balance->save();
            }

            // WizardController::updateWizardInfo(['capital_registration'], []);
            return redirect()->back()->with('success', 'Successfully Saved');
        }
    }

    public
    function recalculate_capital()
    {
        $rollBack = true;
        $user = Auth::user();
        $accounts = CapitalRegistrationModel::where('cr_clg_id', '=', $user->user_clg_id)->get();

        $total_capital = $this->calculate_total_capital();

        $total_capital = $total_capital == 0 ? 1 : $total_capital;

        if ($accounts) {
            foreach ($accounts as $account) {

                $initial_capital = $this->calculate_total_capital_of_single_account($account->cr_capital_account_uid);

                $system_calculated = ($initial_capital / $total_capital) * 100;

                if ($account->cr_is_custom_profit == 1) {
                    $custom_profit_ratio = ($account->cr_fixed_profit_per * $system_calculated) / 100;
                } else {
                    $custom_profit_ratio = $system_calculated;
                }

                if ($account->cr_is_custom_loss == 1) {
                    $custom_loss_ratio = ($account->cr_fixed_loss_per * $system_calculated) / 100;
                } else {
                    $custom_loss_ratio = $system_calculated;
                }

                $capital_registration = CapitalRegistrationModel::where('cr_clg_id', '=', $user->user_clg_id)->where('cr_id', $account->cr_id)->first();

                $capital_registration->cr_system_ratio = $system_calculated;
                $capital_registration->cr_custom_profit_ratio = $custom_profit_ratio;
                $capital_registration->cr_custom_loss_ratio = $custom_loss_ratio;

                if (!$capital_registration->save()) {
                    $rollBack = false;
                }
            }
        }

        return $rollBack;
    }

    public
    function capital_registration_validation($request)
    {
        return $this->validate($request, [
            'second_head' => ['required', 'numeric'],
            'user_name' => ['required', 'numeric'],
            'account_name' => ['required', 'string'],
            'nature' => ['required', 'numeric'],
            'initial_capital' => ['required', 'numeric'],
            'system_calculated' => ['required', 'numeric'],
            'custom_profit_ratio' => ['nullable', 'numeric'],
            'prft_fxd_prft_actl_ratio' => ['nullable', 'numeric'],
            'prft_crnt_ratio' => ['nullable', 'numeric'],
            'prft_remaining_ratio' => ['nullable', 'numeric'],
            'prft_stck_hldrs' => ['nullable', 'numeric'],
            'custom_loss_ratio' => ['nullable', 'numeric'],
            'loss_fxd_prft_actl_ratio' => ['nullable', 'numeric'],
            'loss_crnt_ratio' => ['nullable', 'numeric'],
            'loss_remaining_ratio' => ['nullable', 'numeric'],
            'loss_stck_hldrs' => ['nullable', 'numeric'],
        ]);
    }

    protected
    function AssignCapitalRegistrationValues($request, $capital_registration)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $capital_registration->cr_parent_account_uid = $this->parent_account_uid;
        $capital_registration->cr_capital_account_uid = $this->capital_account_uid_for_cap_reg;
        $capital_registration->cr_profit_loss_account_uid = $this->profit_loss_account_uid_for_cap_reg;
        $capital_registration->cr_drawing_account_uid = $this->drawing_account_uid_for_cap_reg;
        $capital_registration->cr_reserve_account_uid = $this->reserve_account_uid_for_cap_reg;
        $capital_registration->cr_user_id = $request->user_name;
        $capital_registration->cr_partner_nature = $request->nature;
        $capital_registration->cr_initial_capital = $request->initial_capital;
        $capital_registration->cr_system_ratio = $request->system_calculated;
        $capital_registration->cr_is_custom_profit = !empty($request->custom_profit_ratio) ? $request->custom_profit_ratio : 0;
        $capital_registration->cr_fixed_profit_per = !empty($request->prft_fxd_prft_actl_ratio) ? $request->prft_fxd_prft_actl_ratio : 0;
        $capital_registration->cr_custom_profit_ratio = !empty($request->prft_crnt_ratio) ? $request->prft_crnt_ratio : 0;
        $capital_registration->cr_ramaning_profit_per = !empty($request->prft_remaining_ratio) ? $request->prft_remaining_ratio : 0;
        $capital_registration->cr_remaning_profit_division = !empty($request->prft_stck_hldrs) ? $request->prft_stck_hldrs : 0;
        $capital_registration->cr_is_custom_loss = !empty($request->custom_loss_ratio) ? $request->custom_loss_ratio : 0;
        $capital_registration->cr_fixed_loss_per = !empty($request->loss_fxd_prft_actl_ratio) ? $request->loss_fxd_prft_actl_ratio : 0;
        $capital_registration->cr_custom_loss_ratio = !empty($request->loss_crnt_ratio) ? $request->loss_crnt_ratio : 0;
        $capital_registration->cr_remaning_loss_per = !empty($request->loss_remaining_ratio) ? $request->loss_remaining_ratio : 0;
        $capital_registration->cr_remaning_loss_division = !empty($request->loss_stck_hldrs) ? $request->loss_stck_hldrs : 0;
        $capital_registration->cr_created_by = $user->user_id;
        $capital_registration->cr_clg_id = $user->user_clg_id;
        $capital_registration->cr_day_end_id = $day_end->de_id;
        $capital_registration->cr_day_end_date = $day_end->de_datetime;
        $capital_registration->cr_remarks = ucfirst($request->remarks);
        $capital_registration->cr_relation_with_director = ucfirst($request->relation);
        $capital_registration->cr_current_date_time = Carbon::now()->toDateTimeString();

        return $capital_registration;
    }

    public
    function calculate_total_capital()
    {
        $user = Auth::user();
        $capital_account_balance = 0;
        $profit_loss_account_balance = 0;
        $drawing_account_balance = 0;
        $reserve_account_balance = 0;
        $total_capital = 0;

        $capital_accounts = CapitalRegistrationModel::where('cr_clg_id', '=', $user->user_clg_id)->get();

        if ($capital_accounts) {
            foreach ($capital_accounts as $capital_account) {
                $previous_capital_account_balance = $this->calculate_account_balance($capital_account->cr_capital_account_uid);
                $previous_profit_loss_account_balance = $this->calculate_account_balance($capital_account->cr_profit_loss_account_uid);
                $previous_drawing_account_balance = $this->calculate_account_balance($capital_account->cr_drawing_account_uid);
                $previous_reserve_account_balance = $this->calculate_account_balance($capital_account->cr_reserve_account_uid);

                $capital_account_balance += $previous_capital_account_balance;
                $profit_loss_account_balance += $previous_profit_loss_account_balance;
                $drawing_account_balance += $previous_drawing_account_balance;
                $reserve_account_balance += $previous_reserve_account_balance;
            }

            $total_capital = ($capital_account_balance + $profit_loss_account_balance + $reserve_account_balance) - $drawing_account_balance;
        }

        return $total_capital;
    }

    public
    function calculate_total_capital_of_single_account($capital_account_uid)
    {
        $user = Auth::user();
        $capital_account_balance = 0;
        $profit_loss_account_balance = 0;
        $drawing_account_balance = 0;
        $reserve_account_balance = 0;
        $total_capital = 0;

        $capital_account = CapitalRegistrationModel::where('cr_clg_id', '=', $user->user_clg_id)->where('cr_capital_account_uid', $capital_account_uid)->first();

        $previous_capital_account_balance = $this->calculate_account_balance($capital_account->cr_capital_account_uid);
        $previous_profit_loss_account_balance = $this->calculate_account_balance($capital_account->cr_profit_loss_account_uid);
        $previous_drawing_account_balance = $this->calculate_account_balance($capital_account->cr_drawing_account_uid);
        $previous_reserve_account_balance = $this->calculate_account_balance($capital_account->cr_reserve_account_uid);

        $capital_account_balance += $previous_capital_account_balance;
        $profit_loss_account_balance += $previous_profit_loss_account_balance;
        $drawing_account_balance += $previous_drawing_account_balance;
        $reserve_account_balance += $previous_reserve_account_balance;


        $total_capital = ($capital_account_balance + $profit_loss_account_balance + $reserve_account_balance) - $drawing_account_balance;


        return $total_capital;
    }

    public
    function submit_capital_account($request, $account_type)
    {
        $user = Auth::User();
        $rollBack = false;

        /////////////////////////////////////////////////// Chart of Account //////////////////////////////////////////////////////

        $chart_of_account_controller = new ChartOfAccountController();

        $account_head = new AccountHeadsModel();

        $account_head = $chart_of_account_controller->AssignSecondLevelChartOfAccountValues($request->second_head, $request->account_name, '', $account_head, 3);

        if (!$account_head->save()) {
            $rollBack = true;
        } else {

            $parent_code = $account_head->coa_code;


            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Parent Account With Unique Id: ' . $account_head->coa_code . ' And Name: ' . $account_head->coa_head_name);

            $capital_account_prefix = 'Capital - ';
            $profit_loss_account_prefix = 'Profit & Loss - ';
            $drawing_account_prefix = 'Drawing - ';
            $reserve_account_prefix = 'Reserve - ';

            /////////////////////////////////////////////////// 1st Account //////////////////////////////////////////////////////

            $account = new AccountRegisterationModel();
            $account = $this->AssignAccountValues($request, $account, $parent_code, $account_type, $capital_account_prefix);

            if (!$account->save()) {
                $rollBack = true;
            }

            $account_uid = $account->account_uid;
            $account_name = $account->account_name;

            $account_balance = new BalancesModel();

            $account_balance = $this->add_balance($account_balance, $account_uid, $account_name);

            if (!$account_balance->save()) {
                $rollBack = true;
            }

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $account_uid . ' And Name: ' . $account_name);


            /////////////////////////////////////////////////// 2nd Account //////////////////////////////////////////////////////

            $profit_loss_account = new AccountRegisterationModel();

            $profit_loss_account = $this->AssignAccountValues($request, $profit_loss_account, $parent_code, $account_type, $profit_loss_account_prefix);

            if (!$profit_loss_account->save()) {
                $rollBack = true;
            }

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $profit_loss_account->account_uid . ' And Name: '
                . $profit_loss_account->account_name);


            $account_balance = new BalancesModel();

            $account_balance = $this->add_balance($account_balance, $profit_loss_account->account_uid, $profit_loss_account->account_name);

            if (!$account_balance->save()) {
                $rollBack = true;
            }


            /////////////////////////////////////////////////// 3rd Account //////////////////////////////////////////////////////

            $drawing_account = new AccountRegisterationModel();

            $drawing_account = $this->AssignAccountValues($request, $drawing_account, $parent_code, $account_type, $drawing_account_prefix);

            if (!$drawing_account->save()) {
                $rollBack = true;
            }

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $drawing_account->account_uid . ' And Name: '
                . $drawing_account->account_name);


            $account_balance = new BalancesModel();

            $account_balance = $this->add_balance($account_balance, $drawing_account->account_uid, $drawing_account->account_name);

            if (!$account_balance->save()) {
                $rollBack = true;
            }


            /////////////////////////////////////////////////// 4th Account //////////////////////////////////////////////////////

            $reserve_account = new AccountRegisterationModel();

            $reserve_account = $this->AssignAccountValues($request, $reserve_account, $parent_code, $account_type, $reserve_account_prefix);

            if (!$reserve_account->save()) {
                $rollBack = true;
            }

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $reserve_account->account_uid . ' And Name: '
                . $reserve_account->account_name);


            $account_balance = new BalancesModel();

            $account_balance = $this->add_balance($account_balance, $reserve_account->account_uid, $reserve_account->account_name);

            if (!$account_balance->save()) {
                $rollBack = true;
            }

            $this->parent_account_uid = $parent_code;
            $this->capital_account_uid_for_cap_reg = $account->account_uid;
            $this->profit_loss_account_uid_for_cap_reg = $profit_loss_account->account_uid;
            $this->drawing_account_uid_for_cap_reg = $drawing_account->account_uid;
            $this->reserve_account_uid_for_cap_reg = $reserve_account->account_uid;
        }

        return $rollBack;
    }


    public
    function capital_registration_list(Request $request, $array = null, $str = null)
    {
        DB::beginTransaction();
        $recalculate_capital = $this->recalculate_capital();

        if (!$recalculate_capital) {
            DB::rollBack();
        } else {
            DB::commit();
        }
        $user = Auth::user();
        $users = User::where('user_id', '!=', 1)->where('user_designation', '!=', 1)->where('user_clg_id', '=', $user->user_clg_id)->select('user_id', 'user_username')->get();

        $equity_second_accounts = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_parent', config('global_variables.equity'))->where('coa_level', 2)->orderBy('coa_id', 'ASC')->get();
        $equity_third_accounts = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_parent', 'LIKE', config('global_variables.equity') . '%')->where('coa_level', 3)->orderBy('coa_id', 'ASC')->get();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_second_head = (!isset($request->second_head) && empty($request->second_head)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->second_head;
        $search_third_head = (!isset($request->third_head) && empty($request->third_head)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->third_head;
        $prnt_page_dir = 'print.capital_registration_list.capital_registration_list';
        $pge_title = 'Capital Registration List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_second_head, $search_third_head);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_capital_register')
            ->leftJoin('financials_coa_heads as parent_account', 'parent_account.coa_code', 'financials_capital_register.cr_parent_account_uid')
            ->leftJoin('financials_coa_heads as group_account', 'group_account.coa_code', 'parent_account.coa_parent')
            ->leftJoin('financials_coa_heads as control_account', 'control_account.coa_code', 'group_account.coa_parent')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_capital_register.cr_created_by')
            ->leftJoin('financials_users as capital_reg_user', 'capital_reg_user.user_id', 'financials_capital_register.cr_user_id')
            ->where('cr_clg_id', '=', $user->user_clg_id)
            ->where('group_account.coa_clg_id', '=', $user->user_clg_id)
            ->where('control_account.coa_clg_id', '=', $user->user_clg_id)
            ->where('parent_account.coa_clg_id', '=', $user->user_clg_id);;


        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('fa_account_name', 'like', '%' . $search . '%')
                    ->orWhere('cr_parent_account_uid', 'like', '%' . $search . '%')
                    ->orWhere('cr_capital_account_uid', 'like', '%' . $search . '%')
                    ->orWhere('cr_profit_loss_account_uid', 'like', '%' . $search . '%')
                    ->orWhere('cr_user_id', 'like', '%' . $search . '%')
                    ->orWhere('cr_partner_nature', 'like', '%' . $search . '%')
                    ->orWhere('cr_initial_capital', 'like', '%' . $search . '%')
                    ->orWhere('cr_system_ratio', 'like', '%' . $search . '%')
                    ->orWhere('cr_is_custom_profit', 'like', '%' . $search . '%')
                    ->orWhere('cr_is_custom_loss', 'like', '%' . $search . '%')
                    ->orWhere('cr_fixed_profit_per', 'like', '%' . $search . '%')
                    ->orWhere('cr_fixed_loss_per', 'like', '%' . $search . '%')
                    ->orWhere('cr_custom_profit_ratio', 'like', '%' . $search . '%')
                    ->orWhere('cr_custom_loss_ratio', 'like', '%' . $search . '%')
                    ->orWhere('cr_ramaning_profit_per', 'like', '%' . $search . '%')
                    ->orWhere('cr_remaning_loss_per', 'like', '%' . $search . '%')
                    ->orWhere('cr_remaning_profit_division', 'like', '%' . $search . '%')
                    ->orWhere('cr_remaning_loss_division', 'like', '%' . $search . '%')
                    ->orWhere('user_designation', 'like', '%' . $search . '%')
                    ->orWhere('user_name', 'like', '%' . $search . '%')
                    ->orWhere('user_username', 'like', '%' . $search . '%')
                    ->orWhere('parent_account.coa_code', 'like', '%' . $search . '%')
                    ->orWhere('parent_account.coa_head_name', 'like', '%' . $search . '%');
            });
        }

        if (!empty($search_second_head)) {
            $query->where('cr_parent_account_uid', 'LIKE', $search_second_head . '%');
        }

        if (!empty($search_third_head)) {
            $query->where('cr_capital_account_uid', 'LIKE', $search_third_head . '%');
        }

        $datas = $query->select('financials_capital_register.*', 'financials_users.user_id', 'financials_users.user_name', 'financials_users.user_designation', 'parent_account.coa_head_name as prnt_acnt_name', 'group_account.coa_head_name as grp_acnt_name', 'capital_reg_user.user_name as cr_username')
            ->orderBy('cr_id', 'DESC')
            ->paginate($pagination_number);

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
                'margin-top' => 24,
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
            return view('capital_registration_list', compact('datas', 'search', 'search_second_head', 'search_third_head', 'users', 'equity_second_accounts', 'equity_third_accounts'));
        }
    }

    public
    function edit_capital_registration(Request $request)
    {
        $user = Auth::user();
        $capital_registration = CapitalRegistrationModel::where('cr_clg_id', '=', $user->user_clg_id)->where('cr_id', $request->capital_registration)->first();

        $users = User::where('user_id', '!=', 1)->where('user_designation', '!=', 1)->where('user_clg_id', '=', $user->user_clg_id)->where('user_delete_status', '!=', 1)->where('user_disabled', '!=', 1)->select('user_id', 'user_name')->get();

        $equity_second_accounts = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_delete_status', '!=', 1)->where('coa_disabled', '!=', 1)->where('coa_parent', config('global_variables.equity'))->where('coa_level', 2)->orderBy('coa_id', 'ASC')->get();

        $total_capital = $this->calculate_total_capital();


        return view('edit_capital_registration', compact('capital_registration', 'users', 'equity_second_accounts', 'total_capital'));


//        if ($capital_registration) {
//            $parent_account = AccountHeadsModel::where('coa_delete_status', '!=', 1)->where('coa_code', $capital_registration->fa_parent_account_uid)->pluck('coa_head_name')->first();
//
//            $group = AccountGroupModel::where('ag_delete_status', '!=', 1)->where('ag_id', $capital_registration->fa_group_id)->pluck('ag_title')->first();
//
//            return view('edit_capital_registration_registration', compact('capital_registration', 'parent_account', 'group'));
//        } else {
//            return redirect()->back()->with('fail', 'Failed Try Again');
//        }
    }

    public
    function update_capital_registration(Request $request)
    {
        $this->validate($request, [
            'nature' => ['required', 'numeric'],
            'custom_profit_ratio' => ['nullable', 'numeric'],
            'prft_fxd_prft_actl_ratio' => ['nullable', 'numeric'],
            'prft_crnt_ratio' => ['nullable', 'numeric'],
            'prft_remaining_ratio' => ['nullable', 'numeric'],
            'prft_stck_hldrs' => ['nullable', 'numeric'],
            'custom_loss_ratio' => ['nullable', 'numeric'],
            'loss_fxd_prft_actl_ratio' => ['nullable', 'numeric'],
            'loss_crnt_ratio' => ['nullable', 'numeric'],
            'loss_remaining_ratio' => ['nullable', 'numeric'],
            'loss_stck_hldrs' => ['nullable', 'numeric'],
        ]);

        $user = Auth::User();
        DB::beginTransaction();

//        $rollBack = $this->submit_capital_account($request, 0);

        $capital_registration = CapitalRegistrationModel::where('cr_clg_id', '=', $user->user_clg_id)->where('cr_id', '=', $request->cr_id)->first();

        // $capital_registration = $this->AssignCapitalRegistrationValues($request, $capital_registration);
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $capital_registration->cr_partner_nature = $request->nature;
        $capital_registration->cr_is_custom_profit = !empty($request->custom_profit_ratio) ? $request->custom_profit_ratio : 0;
        $capital_registration->cr_fixed_profit_per = !empty($request->prft_fxd_prft_actl_ratio) ? $request->prft_fxd_prft_actl_ratio : 0;
        $capital_registration->cr_custom_profit_ratio = !empty($request->prft_crnt_ratio) ? $request->prft_crnt_ratio : 0;
        $capital_registration->cr_ramaning_profit_per = !empty($request->prft_remaining_ratio) ? $request->prft_remaining_ratio : 0;
        $capital_registration->cr_remaning_profit_division = !empty($request->prft_stck_hldrs) ? $request->prft_stck_hldrs : 0;
        $capital_registration->cr_is_custom_loss = !empty($request->custom_loss_ratio) ? $request->custom_loss_ratio : 0;
        $capital_registration->cr_fixed_loss_per = !empty($request->loss_fxd_prft_actl_ratio) ? $request->loss_fxd_prft_actl_ratio : 0;
        $capital_registration->cr_custom_loss_ratio = !empty($request->loss_crnt_ratio) ? $request->loss_crnt_ratio : 0;
        $capital_registration->cr_remaning_loss_per = !empty($request->loss_remaining_ratio) ? $request->loss_remaining_ratio : 0;
        $capital_registration->cr_remaning_loss_division = !empty($request->loss_stck_hldrs) ? $request->loss_stck_hldrs : 0;
        $capital_registration->cr_created_by = $user->user_id;
        $capital_registration->cr_clg_id = $user->user_clg_id;
        $capital_registration->cr_remarks = ucfirst($request->remarks);
        $capital_registration->cr_relation_with_director = ucfirst($request->relation);
        $capital_registration->cr_current_date_time = Carbon::now()->toDateTimeString();

        $rollBack = false;

        if (!$capital_registration->save()) {
            $rollBack = true;
            DB::rollBack();
        }

        $recalculate_capital = $this->recalculate_capital();

        if (!$recalculate_capital) {
            $rollBack = true;
            DB::rollBack();
        }

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {

            $system_config = SystemConfigModel::where('sc_clg_id', '=', $user->user_clg_id)->first();

            if ($system_config->sc_all_done == 0) {
                $system_config->sc_admin_capital_added = 1;

                if (!$system_config->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }
            }


            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Capital Registration With Unique Id: ' . $capital_registration->fa_id . ' And Name: '
                . $capital_registration->fa_account_name);

            DB::commit();
            // WizardController::updateWizardInfo(['capital_registration'], []);
            return redirect()->back()->with('success', 'Successfully Saved');
        }

        /*
        $this->update_capital_registration_validation($request);
        $user = Auth::User();

        $capital_registration = CapitalRegistrationModel::where('fa_id', $request->capital_registration)->first();

        $capital_registration = $this->UpdateCapitalRegistrationValues($request, $capital_registration);

        if ($capital_registration->save()) {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Fixed Asset With Unique Id: ' . $capital_registration->fa_id . ' And Name: '
                . $capital_registration->fa_account_name);

            return redirect()->back()->with('success', 'Successfully Saved');
        } else {
            return redirect()->back()->with('fail', 'Failed Try Again');
        }*/
    }

    public
    function update_capital_registration_validation($request)
    {
        return $this->validate($request, [
            'capital_registration' => ['required', 'numeric'],
            'account_name' => ['required', 'string'],
            'asset_registration_no' => ['nullable', 'string'],
            'importer_supplier_detail' => ['nullable', 'string'],
            'asset_guarantee_period' => ['nullable', 'string'],
            'asset_specification' => ['nullable', 'string'],
            'asset_capacity' => ['nullable', 'string'],
            'asset_size' => ['nullable', 'string'],
            'asset_purchase_price' => ['required', 'numeric'],
            'residual_value' => ['required', 'string'],
            'useful_life' => ['required', 'string'],
            'depreciation_percentage' => ['required', 'numeric'],
            'acquisition_date' => ['required', 'date'],
            'remarks' => ['nullable', 'string'],
        ]);
    }

    protected
    function UpdateCapitalRegistrationValues($request, $capital_registration)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $capital_registration->fa_account_name = ucwords($request->account_name);
        $capital_registration->fa_register_number = $request->asset_registration_no;
        $capital_registration->fa_supplier_details = $request->importer_supplier_detail;
        $capital_registration->fa_guarantee_period = $request->asset_guarantee_period;
        $capital_registration->fa_specification = $request->asset_specification;
        $capital_registration->fa_capacity = $request->asset_capacity;
        $capital_registration->fa_size = $request->asset_size;
        $capital_registration->fa_price = $request->asset_purchase_price;
        $capital_registration->fa_residual_value = $request->residual_value;
        $capital_registration->fa_useful_life = $request->useful_life;
        $capital_registration->fa_dep_percentage = $request->depreciation_percentage;
        $capital_registration->fa_acquisition_date = date('Y-m-d', strtotime($request->acquisition_date));
        $capital_registration->fa_remarks = ucfirst($request->remarks);
        $capital_registration->fa_user_id = $user->user_id;
        $capital_registration->fa_clg_id = $user->user_clg_id;
        $capital_registration->fa_date_time = Carbon::now()->toDateTimeString();
        $capital_registration->fa_day_end_id = $day_end->de_id;
        $capital_registration->fa_day_end_date = $day_end->de_datetime;

        // coding from shahzaib start
        $tbl_var_name = 'capital_registration';
        $prfx = 'fa';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        // coding from shahzaib end

        return $capital_registration;
    }


}
