<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Wizard\WizardController;
use App\Imports\ExcelDataImport;
use App\Models\AccountGroupModel;
use App\Models\AccountHeadsModel;
use App\Models\AccountRegisterationModel;
use App\Models\AreaModel;
use App\Models\BalancesModel;
use App\Models\BrandModel;
use App\Models\CapitalRegistrationModel;
use App\Models\CategoryInfoModel;
use App\Models\CompanyInfoModel;
use App\Models\CreditCardMachineModel;
use App\Models\Department;
use App\Models\FixedAssetModel;
use App\Models\GroupInfoModel;
use App\Models\MainUnitModel;
use App\Models\ModularGroupModel;
use App\Models\ProductGroupModel;
use App\Models\ProductModel;
use App\Models\ProductPackagesModel;
use App\Models\ProductRecipeModel;
use App\Models\RegionModel;
use App\Models\SectorModel;
use App\Models\ServicesModel;
use App\Models\SystemConfigModel;
use App\Models\TownModel;
use App\Models\UnitInfoModel;
use App\Models\WarehouseModel;
use App\User;
use Auth;
use PDF;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;

class ChartOfAccountController extends ExcelForm\ChartOfAccountForm\ChartOfAccountController
{

//    nabeel start
    public function chart_of_account()
    {
        $user = Auth::user();
        $systemConfig = $this->getSystemConfig();
        $categories = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_delete_status', '!=', 1)->where('coa_disabled', '!=', 1)->where('coa_parent', '=', 0)->get();

        return view('chart_of_account', compact('categories', 'systemConfig'));
    }

// nabeel panga start
    public function store_chart_of_account(Request $request){
        $user = Auth::user();
        $already_exist = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_clg_id', '=', $user->user_clg_id)->where('coa_head_name', '=', $request->account_name)->where('coa_parent', '=', $request->code)->first();
        if ($already_exist != null) {
            return redirect()->back()->with(['success' => 'Account Already Exist']);
        }

//        $this->second_level_chart_of_account_validation($request);

        $account = new AccountHeadsModel();

        $account = $this->AssignSecondLevelChartOfAccountValues($request->code, $request->account_name, '', $account, 2);

        $account->save();



        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Group Account With Unique Id: ' . $account->coa_code . ' And Name: ' . $account->coa_head_name);


        return redirect()->back()->with(['success' => 'Successfully Saved!']);

    }

    public function store_chart_of_account2(Request $request){
        $user = Auth::User();
        $already_exist = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_clg_id', '=', $user->user_clg_id)->where('coa_head_name', '=', $request->account_name)->where('coa_parent', '=', $request->code)->first();
        if ($already_exist != null) {
            return redirect()->back()->with(['success' => 'Account Already Exist']);
        }

        $account = new AccountHeadsModel();

        $account = $this->AssignSecondLevelChartOfAccountValues($request->code, $request->account_name, '', $account, 3);

        $account->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Parent Account With Unique Id: ' . $account->coa_code . ' And Name: ' . $account->coa_head_name);

        return redirect()->back()->with(['success' => 'Successfully Saved!']);

    }

    public function store_chart_of_account3(Request $request){
        $user = Auth::User();
        $already_exist = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_clg_id', '=', $user->user_clg_id)->where('account_name', '=',
            $request->account_name)->where('account_parent_code', '=',
            $request->code)
            ->first();
        if ($already_exist != null) {
            return redirect()->back()->with(['success' => 'Account Already Exist']);
        }

        DB::beginTransaction();

        $rollBack = $this->submit_account($request, 0);

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {
            DB::commit();

            return redirect()->back()->with(['success' => 'Successfully Saved!']);
        }


    }

    public function submit_account($request, $account_type)
    {
        $branch_no=Session::get('branch_no');
        $parent_code = $request->code;

        $user = Auth::User();
        $rollBack = false;

        $prefix = '';

        $account = new AccountRegisterationModel();
        $account = $this->AssignAccountValues($request, $account, $parent_code, $account_type, $prefix);

        if (!$account->save()) {
            $rollBack = true;
        }

        $account_uid = $account->account_uid;
        $account_name = $account->account_name. ' - '.$branch_no;

        $account_balance = new BalancesModel();

        $account_balance = $this->add_balance($account_balance, $account_uid, $account_name);

        if (!$account_balance->save()) {
            $rollBack = true;
        }

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $account_uid . ' And Name: ' . $account_name);

        return $rollBack;


    }

    public function AssignAccountValues($request, $account, $parent_code, $account_type, $prefix, $postfix = '')
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $check_uid = AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_parent_code', $parent_code)->orderBy('account_uid', 'DESC')->pluck('account_uid')
            ->first();

        if ($check_uid) {

            $check_uid = $this->generate_account_code($parent_code, $check_uid);

            $uid = $check_uid;
        } else {
            $check_uid = $check_uid + 1;
            $uid = $parent_code . $check_uid;
        }

        $account->account_group_id = !empty($request->group) ? $request->group : 1;
        $account->account_parent_code = $parent_code;
        $account->account_uid = $uid;
        $account->account_name = $prefix . ucwords($request->account_name) . $postfix;
        $account->account_urdu_name = $prefix . ucwords($request->account_urdu_name) . $postfix;
        $account->account_remarks = ucfirst($request->remarks);
        $account->account_balance = 0;

        if ($account_type == 1) {
            $account->account_region_id = $request->region;
            $account->account_area = $request->area;
            $account->account_sector_id = $request->sector;
            $account->account_town_id = $request->town;
            $account->account_sale_person = $request->sale_person;
            $account->account_print_name = ucwords($request->print_name);
            $account->account_cnic = $request->cnic;
            $account->account_type = $account_type;
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

            if (isset($request->unlimited)) {
                $account->account_credit_limit_status = 1;
                $account->account_credit_limit = 0;
            } else {
                $account->account_credit_limit = isset($request->credit_limit) ? $request->credit_limit : 0;
            }

            $account->account_page_no = $request->page_no;
        }

        $account->account_createdby = $user->user_id;
        $account->account_clg_id = $user->user_clg_id;
        $account->account_day_end_id = $day_end->de_id;
        $account->account_day_end_date = $day_end->de_datetime;
        $account->account_brwsr_info = $brwsr_rslt;
        $account->account_ip_adrs = $ip_rslt;
        $account->account_update_datetime = Carbon::now()->toDateTimeString();

        return $account;
    }

    public function add_balance($account_balance, $account_uid, $account_name)
    {
        $user = Auth::user();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $account_balance->bal_account_id = $account_uid;
        $account_balance->bal_dr = 0;
        $account_balance->bal_cr = 0;
        $account_balance->bal_total = 0;
        $account_balance->bal_transaction_type = 'OPENING_BALANCE';
        $account_balance->bal_transaction_id = 0;
        $account_balance->bal_remarks = 'OPENING_BALANCE';
        $account_balance->bal_detail_remarks = 'OPENING_BALANCE';
        $account_balance->bal_day_end_id = $day_end->de_id;
        $account_balance->bal_day_end_date = $day_end->de_datetime;
        $account_balance->bal_user_id = $user->user_id;
        $account_balance->bal_clg_id = $user->user->user_clg_id;

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Opening Balance of Account With Unique Id: ' . $account_uid . ' And Name: ' . $account_name);

        return $account_balance;
    }

    public function generate_account_code($parent_head, $pre_account_id)
    {
        $id = str_replace_first(trim($parent_head, ""), "", $pre_account_id);

        $id = $id + 1;

        $newId = $parent_head . $id;

        return $newId;
    }
// nabeel panga end


    private function getSystemConfig()
    {
        $user = Auth::user();
        $systemConfig = SystemConfigModel::where('sc_clg_id', '=', $user->user_clg_id)->first();
        $sc_welcome_wizard = $systemConfig->sc_welcome_wizard;

        $company_info = false;
//        if (CompanyInfoModel::where('ci_name', '!=', '')->where('ci_email', '!=', '')->exists()) { $sc_welcome_wizard['company_info'] = 1;$company_info = true; }
        if (AccountHeadsModel::count()) { $sc_welcome_wizard['add_second_level_chart_of_account'] = 1; }
        if (AccountHeadsModel::count()) { $sc_welcome_wizard['add_third_level_chart_of_account'] = 1; }
        if (AccountGroupModel::count()) { $sc_welcome_wizard['add_account_group'] = 1; }
        if (AccountHeadsModel::count()) { $sc_welcome_wizard['account_registration'] = 1; }
        if (WarehouseModel::count()) { $sc_welcome_wizard['warehouse'] = 1; }


        $systemConfig->sc_welcome_wizard = SystemConfigModel::convertScWelcomeWizardToString($sc_welcome_wizard);
        $systemConfig->save();

        return $systemConfig;
    }
//    nabeel end


    public function add_second_level_chart_of_account()
    {
        $user = Auth::user();
        $first_level_accounts = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_parent', '=', 0)->get();
        // WizardController::updateWizardInfo(['group_account', 'expense_group_account', 'second_head'], []);

        return view('add_second_level_chart_of_account', compact('first_level_accounts'));
    }

    public function submit_second_level_chart_of_account_excel(Request $request)
    {
        $rules = [
            'add_create_group_pattern_excel' => 'required|mimes:xlsx,xls,csv|max:5000',
        ];

        $messages = [
            'add_create_group_pattern_excel.max' => "Your File size too long.",
            'add_create_group_pattern_excel.required' => "Please select your Group Account Excel Sheet.",
        ];

        $validator = $this->validate($request, $rules, $messages);

        if ($request->hasFile('add_create_group_pattern_excel')) {

//            dd($request->add_employee_excel);
//            $dateTime = date('Ymd_His');
//            $file = $request->file('add_employee_excel');
//            $fileName = $dateTime . '-' . $file->getClientOriginalName();
//            $savePath = public_path('/uploads/'.config('global_variables.excel_storage_folder_name'));
//            $file->move($savePath, $fileName);
//            $data = Excel::load($path)->get();


            $path = $request->file('add_create_group_pattern_excel');
            $data = Excel::toArray(new ExcelDataImport, $path);

            $excelData = json_decode(json_encode($data), FALSE);
            foreach ($excelData as $rows) {
                foreach ($rows as $row) {
                    $rowData = (array)$row;
                    $request->merge($rowData);
                    $this->excel_second_level_chart_of_account_validation($request);

                    $rollBack = self::excel_form_second_level_chart_of_account($row);

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

    public function submit_second_level_chart_of_account(Request $request)
    {
        return self::simple_form_second_level_chart_of_account($request);
//        $this->second_level_chart_of_account_validation($request);
//
//        $account = new AccountHeadsModel();
//
//        $account = $this->AssignSecondLevelChartOfAccountValues($request->head_code, $request->account_name, $request->remarks, $account, 2);
//
//        $account->save();
//
//        $user = Auth::User();
//
//        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Group Account With Unique Id: ' . $account->coa_code . ' And Name: ' . $account->coa_head_name);
//
////        if ($request->head_code == config('global_variables.expense'))
////        {
////            WizardController::updateWizardInfo(['expense_group_account'], ['asset_registration']);
////        } else {
////            WizardController::updateWizardInfo(['group_account'], ['parent_account']);
////            WizardController::updateWizardInfo(['second_head'], ['capital_registration']);
////        }
//
//        return redirect('add_second_level_chart_of_account')->with('success', 'Successfully Saved');
    }

    public function add_third_level_chart_of_account()
    {
        $user = Auth::user();
        $first_level_accounts = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_delete_status', '!=', 1)->where('coa_disabled', '!=', 1)->where('coa_parent', '=', 0)->get();
        // WizardController::updateWizardInfo(['parent_account'], []);

        return view('add_third_level_chart_of_account', compact('first_level_accounts'));
    }

    public function submit_third_level_chart_of_account_excel(Request $request)
    {

        $rules = [
            'add_parent_account_excel' => 'required|mimes:xlsx,xls,csv|max:5000',
        ];

        $messages = [
            'add_parent_account_excel.max' => "Your File size too long.",
            'add_parent_account_excel.required' => "Please select your Parent Account Excel Sheet.",
        ];

        $validator = $this->validate($request, $rules, $messages);

        if ($request->hasFile('add_parent_account_excel')) {

//            dd($request->add_employee_excel);
//            $dateTime = date('Ymd_His');
//            $file = $request->file('add_employee_excel');
//            $fileName = $dateTime . '-' . $file->getClientOriginalName();
//            $savePath = public_path('/uploads/'.config('global_variables.excel_storage_folder_name'));
//            $file->move($savePath, $fileName);
//            $data = Excel::load($path)->get();


            $path = $request->file('add_parent_account_excel');
            $data = Excel::toArray(new ExcelDataImport, $path);

            $excelData = json_decode(json_encode($data), FALSE);
            foreach ($excelData as $rows) {
                foreach ($rows as $row) {
                    $rowData = (array)$row;
                    $request->merge($rowData);
                    $this->excel_third_level_chart_of_account_validation($request);

                    $rollBack = self::excel_form_third_level_chart_of_account($row);

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

    public function submit_third_level_chart_of_account(Request $request)
    {
        return self::simple_form_third_level_chart_of_account($request);
//        $this->third_level_chart_of_account_validation($request);
//
//        $account = new AccountHeadsModel();
//
//        $account = $this->AssignSecondLevelChartOfAccountValues($request->head_code, $request->account_name, $request->remarks, $account, 3);
//
//        $account->save();
//
//        $user = Auth::User();
//
//        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Parent Account With Unique Id: ' . $account->coa_code . ' And Name: ' . $account->coa_head_name);
//
////        if ($request->head_code == config('global_variables.fixed_asset_second_head'))
////        {
////            WizardController::updateWizardInfo(['asset_parent_account'], []);
////        } elseif ($request->head_code == config('global_variables.salary_expense_second_head')) {
////            WizardController::updateWizardInfo(['parent_account_1'], ['salary_account']);
////        }
//
//        return redirect('add_third_level_chart_of_account')->with('success', 'Successfully Saved');
    }

    // update code by shahzaib start
    public function second_level_chart_of_account_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $first_level_accounts = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_parent', 0)->get();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_first_level_account = (!isset($request->first_level) && empty($request->first_level)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->first_level;
        $prnt_page_dir = 'print.second_level_chart_of_account_list.second_level_chart_of_account_list';
        $pge_title = 'Second Level Chart Of Account List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_first_level_account);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_coa_heads AS second')
            ->join('financials_coa_heads AS first', 'first.coa_code', '=', 'second.coa_parent')
            ->where('second.coa_clg_id', '=', $user->user_clg_id)
            ->where('first.coa_clg_id', '=', $user->user_clg_id)
            ->select('first.coa_head_name AS first_level_name', 'second.coa_head_name AS second_level_name', 'second.coa_code', 'second.coa_id', 'second.coa_remarks', 'first.coa_code AS parent_id', 'second.coa_delete_status', 'second.coa_disabled');


        if (!empty($search)) {
//            $pagination_number = 1000000;
            $query->where('first.coa_head_name', 'like', '%' . $search . '%')
                ->orWhere('second.coa_head_name', 'like', '%' . $search . '%');
        }

        if (!empty($search_first_level_account)) {
//            $pagination_number = 1000000;
            $query->where('second.coa_parent', 'like', '%' . $search_first_level_account . '%');
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1) {
            $query->where('second.coa_delete_status', '=', 1);
        } else {
            $query->where('second.coa_delete_status', '!=', 1);
        }


        $datas = $query->where('second.coa_level', '=', 2)
//            ->where('second.coa_delete_status', '!=', 1)
            ->orderBy('first.coa_code', 'ASC')
            ->orderBy('second.coa_head_name', 'ASC')
            ->paginate($pagination_number);

        $account_titles = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_level', '=', 2)
//            ->where('coa_delete_status', '!=', 1)
            ->pluck('coa_head_name')->all();


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl'=>[
                    'verify_peer'=>FALSE,
                    'verify_peer_name'=>FALSE,
                    'allow_self_signed'=>TRUE,
                ]
            ]);
            $optionss =[
                'footer-html' => $footer,
                'header-html' => $header,
                'margin-top' => 24,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled'=>true, 'isRemoteEnabled'=>true]);
            $pdf->getDomPDF()->setHttpContext($options,$optionss);
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
            return view('second_level_chart_of_account_list', compact('datas', 'account_titles', 'search', 'first_level_accounts', 'search_first_level_account', 'restore_list'));
        }
    }
    // update code by shahzaib end


    // update code by shahzaib start
    public function third_level_chart_of_account_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $first_level_accounts = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_parent', 0)->get();
        $second_level_accounts = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_level', '=', 2)->get();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_first_level_account = (isset($request->first_level)) ? $request->first_level : '';
        $search_second_level_account = (isset($request->second_level)) ? $request->second_level : '';


        $prnt_page_dir = 'print.third_level_chart_of_account_list.third_level_chart_of_account_list';
        $pge_title = 'Parent Account List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_first_level_account, $search_second_level_account);
        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_coa_heads AS second')
            ->join('financials_coa_heads AS first', 'first.coa_code', '=', 'second.coa_parent')
            ->where('second.coa_clg_id', '=', $user->user_clg_id)
            ->where('first.coa_clg_id', '=', $user->user_clg_id)
            ->select('first.coa_head_name AS first_level_name', 'second.coa_head_name AS second_level_name', 'second.coa_code', 'second.coa_id', 'second.coa_remarks', 'first.coa_code AS parent_id', 'second.coa_delete_status', 'second.coa_disabled');

        if (!empty($search)) {
//            $pagination_number = 1000000;
            $query->where('second.coa_head_name', 'like', '%' . $search . '%')
                ->orWhere('first.coa_head_name', 'like', '%' . $search . '%');
        }


        if (!empty($search_first_level_account)) {

            $get_first_level_account = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_parent', $search_first_level_account)->pluck('coa_code')->all();

            $query->whereIn('second.coa_parent', $get_first_level_account);
        }

        if (!empty($search_second_level_account)) {
            $query->where('second.coa_parent', $search_second_level_account);
        }


        $restore_list = $request->restore_list;
        if ($restore_list == 1) {
            $query->where('second.coa_delete_status', '=', 1);
        } else {
            $query->where('second.coa_delete_status', '!=', 1);
        }


        $datas = $query->where('second.coa_level', '=', 3)
//            ->where('second.coa_delete_status', '!=', 1)
            ->orderBy('first.coa_code', 'ASC')
            ->orderBy('second.coa_head_name', 'ASC')
            ->paginate($pagination_number);

        $account_titles = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_level', '=', 3)
//            ->where('coa_delete_status', '!=', 1)
            ->pluck('coa_head_name')->all();


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl'=>[
                    'verify_peer'=>FALSE,
                    'verify_peer_name'=>FALSE,
                    'allow_self_signed'=>TRUE,
                ]
            ]);
            $optionss =[
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled'=>true, 'isRemoteEnabled'=>true]);
            $pdf->getDomPDF()->setHttpContext($options,$optionss);
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
            return view('third_level_chart_of_account_list', compact('datas', 'account_titles', 'search', 'first_level_accounts', 'second_level_accounts', 'search_first_level_account', 'search_second_level_account', 'restore_list'));
        }


    }

    // update code by shahzaib end


    public function edit_second_level_chart_of_account(Request $request)
    {
        $user = Auth::user();
        $first_level_accounts = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_delete_status', '!=', 1)->where('coa_disabled', '!=', 1)->where('coa_parent', '=', 0)->get();

        $account = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_id', $request->account_id)->first();

        return view('edit_second_level_chart_of_account', compact('first_level_accounts', 'request', 'account'));
    }

    public function update_chart_of_account(Request $request)
    {
        $user = Auth::user();
//        dd($request);
        $this->update_chart_of_account_values_validation($request);

        $account = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_id', $request->account_id)->first();

        $account = $this->assign_update_chart_of_account_values($request, $account);

        $account->save();

        if ($account->save()) {

            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Group/Parent Account With Unique Id: ' . $account->coa_code . ' And Name: ' . $account->coa_head_name);

            return redirect()->back()->with('success', 'Successfully Saved');
        } else {
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }

    }

    public function update_chart_of_account_values_validation($request)
    {
        $user = Auth::user();
        return $this->validate($request, [
            'head_code' => ['required', 'numeric'],
            'account_id' => ['required', 'numeric'],
            'account_name' => ['required', 'string', 'unique:financials_coa_heads,coa_head_name,' . $request->account_id . ',coa_id,coa_parent,' . $request->head_code.',coa_clg_id,'
                .$user->user_clg_id],
            'remarks' => ['nullable', 'string'],
        ]);
    }

    public function assign_update_chart_of_account_values($request, $account)
    {
        $account->coa_head_name = ucwords($request->account_name);
        $account->coa_remarks = ucfirst($request->remarks);

        // coding from shahzaib start
        $tbl_var_name = 'account';
        $prfx = 'coa';
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

    public function edit_third_level_chart_of_account(Request $request)
    {
        $user = Auth::user();
        $first_level_accounts = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_delete_status', '!=', 1)->where('coa_disabled', '!=', 1)->where('coa_parent', '=', 0)->get();

        $account = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_id', $request->account_id)->first();

        return view('edit_third_level_chart_of_account', compact('first_level_accounts', 'request', 'account'));
    }

    public function delete_second_level_chart_of_account(Request $request)
    {
        $user = Auth::user();
        $user = Auth::User();

        $check_account = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_id', $request->account_id)->pluck('coa_system_generated')->first();

        if ($check_account == 1) {
            return redirect()->back()->with('fail', "Can't Be Deleted");
        } else {

            $delete = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_id', $request->account_id)->first();

//            $delete->coa_delete_status = 1;
            if ($delete->coa_delete_status == 1) {
                $delete->coa_delete_status = 0;
            } else {
                $delete->coa_delete_status = 1;
            }
            $delete->coa_deleted_by = $user->user_id;

            if ($delete->save()) {

                if ($delete->coa_delete_status == 0) {
                    $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Group Account With Unique Id: ' . $delete->coa_code . ' And Name: ' . $delete->coa_head_name);

                    return redirect()->back()->with('success', 'Successfully Restored');
                } else {
                    $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Group Account With Unique Id: ' . $delete->coa_code . ' And Name: ' . $delete->coa_head_name);

                    return redirect()->back()->with('success', 'Successfully Deleted');
                }

            } else {
                return redirect()->back()->with('fail', 'Failed Try Again!');
            }

        }
    }

    public function delete_third_level_chart_of_account(Request $request)
    {
        $user = Auth::User();

        $check_account = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_id', $request->account_id)->pluck('coa_system_generated')->first();

        if ($check_account == 1) {
            return redirect()->back()->with('fail', "Can't Be Deleted");
        } else {

            $delete = AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_id', $request->account_id)->first();

//            $delete->coa_delete_status = 1;

            if ($delete->coa_delete_status == 1) {
                $delete->coa_delete_status = 0;
            } else {
                $delete->coa_delete_status = 1;
            }

            $delete->coa_deleted_by = $user->user_id;
            $delete->coa_clg_id = $user->user_clg_id;

            if ($delete->save()) {
                if ($delete->coa_delete_status == 0) {
                    $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Parent Account With Unique Id: ' . $delete->coa_code . ' And Name: ' . $delete->coa_head_name);

                    return redirect()->back()->with('success', 'Successfully Restored');
                } else {
                    $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Parent Account With Unique Id: ' . $delete->coa_code . ' And Name: ' . $delete->coa_head_name);

                    return redirect()->back()->with('success', 'Successfully Deleted');
                }


            } else {
                return redirect()->back()->with('fail', 'Failed Try Again!');
            }
        }
    }
}
