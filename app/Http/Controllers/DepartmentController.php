<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountHeadsModel;
use App\Models\Department;
use App\Models\RegionModel;
use PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Session;

class DepartmentController extends Controller
{

    public function index(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.department_list.department_list';
        $pge_title = 'Department List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_departments')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_departments.dep_createdby')
            ->where('dep_clg_id', '=', $user->user_clg_id)
            ->where('dep_branch_id', '=', Session::get('branch_id'));

        if (!empty($search)) {
            $query->where('dep_title', 'like', '%' . $search . '%')
                ->orWhere('dep_remarks', 'like', '%' . $search . '%')
                ->orWhere('dep_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('dep_createdby', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1) {
            $query->where('dep_delete_status', '=', 1);
        } else {
            $query->where('dep_delete_status', '!=', 1);
        }

        $datas = $query->orderBy('dep_id', 'DESC')
            ->paginate($pagination_number);

        $dep_title = Department::where('dep_clg_id', '=', $user->user_clg_id)->orderBy('dep_id', config('global_variables.query_sorting'))->pluck('dep_title')->all();//where('dep_delete_status',
        // '!=', 1)->


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
            return view('department_list', compact('datas', 'search', 'dep_title', 'search_by_user', 'restore_list'));
        }

    }


    public function create()
    {
        $departments = Department::where('dep_account_code', '!=', null)->pluck('dep_account_code');
//        $salary_expense_second_head = config('global_variables.salary_expense_second_head');
//
//        $salary_heads = AccountHeadsModel::where('coa_parent', $salary_expense_second_head)->whereNotIn('coa_code',$departments)->orderBy('coa_id', 'ASC')->get();

        return view("add_department");//,compact('salary_heads'));
    }

    public function store(Request $request)
    {
//        $parent_head=$request->parent_head;

        $this->department_validation($request);

//        if($parent_head == 'empty'){
////            $this->third_level_chart_of_account_validation($request);
//
//            $account = new AccountHeadsModel();
//
//            $account = $this->AssignSecondLevelChartOfAccountValues(412, $request->department_name, $request->department_remarks, $account, 3);
//
//            $account->save();
//            $parent_head=$account->coa_code;
//            $department = new Department();
//
//            $department = $this->AssignRegionValues($request, $department,$parent_head);
//
//            $department->save();
//            $user = Auth::User();
//
//            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Region With Id: ' . $department->dep_id . ' And Name: ' . $department->dep_title);
//        }else{

        $department = new Department();
//            $parent_head=$request->parent_head;$parent_head
        $department = $this->AssignRegionValues($request, $department);

        $department->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Region With Id: ' . $department->dep_id . ' And Name: ' . $department->dep_title);
//        }


        // WizardController::updateWizardInfo(['region'], ['area']);

        return redirect('/departments/create')->with('success', 'Successfully Saved');
    }

    public function AssignSecondLevelChartOfAccountValues($parent_code, $account_name, $remarks, $account, $level)
    {
        $user = Auth::User();
        $account_registration_controller = new AccountRegisterationsController();

        if ($level == 2) {

            $check_uid = AccountHeadsModel::where('coa_clg_id', $user->user_clg_id)->where('coa_parent', $parent_code)->orderBy('coa_code', 'DESC')->pluck('coa_code')->first();

//            $account_code = $check_uid + 1;

            if ($check_uid) {
//                $account_code = $parent_code . '10';
                $account_code = $check_uid = $account_registration_controller->generate_account_code($parent_code, $check_uid);
            } else {
                $uid = 10;
                $account_code = $parent_code . $uid;
            }

        } elseif ($level == 3) {

            $check_uid = AccountHeadsModel::where('coa_clg_id', $user->user_clg_id)->where('coa_parent', $parent_code)->orderBy('coa_code', 'DESC')->pluck('coa_code')->first();

            if ($check_uid) {
//                $account_code = $parent_code . '10';
                $account_code = $check_uid = $account_registration_controller->generate_account_code($parent_code, $check_uid);
            } else {
                $uid = 10;
                $account_code = $parent_code . $uid;
            }
        }


        $account->coa_head_name = ucwords($account_name);
        $account->coa_remarks = ucfirst($remarks);
        $account->coa_code = $account_code;
        $account->coa_parent = $parent_code;
        $account->coa_level = $level;
        $account->coa_datetime = Carbon::now()->toDateTimeString();


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

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $department = Department::find($id);
//        $salary_expense_second_head = config('global_variables.salary_expense_second_head');
//        if($department->dep_account_code == null){
//            $departments= Department::where('dep_account_code','!=',null)->pluck('dep_account_code');

//            $salary_heads = AccountHeadsModel::where('coa_parent', $salary_expense_second_head)->whereNotIn('coa_code',$departments)->orderBy('coa_id', 'ASC')->get();

        return view('edit_department', compact('department'));//,'salary_heads'
//        }else{
//            $salary_heads = AccountHeadsModel::where('coa_parent', $salary_expense_second_head)->orderBy('coa_id', 'ASC')->get();

//            return view('edit_department', compact('department','salary_heads'));
//        }

    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $this->validate($request, [
            'department_name' => ['required', 'string', 'unique:financials_departments,dep_title,' . $id . ',dep_id' . ',dep_clg_id,' . $user->user_clg_id.',dep_branch_id,' . Session::get('branch_id')],
            'department_remarks' => ['nullable', 'string'],
        ]);
//        $parent_head=$request->parent_head;
        $department = Department::find($id);

        $department = $this->AssignRegionValues($request, $department);//,$parent_head

        if ($department->save()) {

            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Department With Id: ' . $department->dep_id . ' And Name: ' . $department->dep_title);
            return redirect('departments')->with('success', 'Successfully Saved');
        } else {
            return redirect('departments')->with('fail', 'Failed Try Again!');
        }
    }

    public function destroy($id)
    {

        $user = Auth::User();

        $delete = Department::find($id);

        if ($delete->dep_delete_status == 1) {
            $delete->dep_delete_status = 0;
        } else {
            $delete->dep_delete_status = 1;
        }

        $delete->dep_deleted_by = $user->user_id;

        if ($delete->save()) {

            if ($delete->dep_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Department With Id: ' . $delete->dep_id . ' And Name: ' . $delete->dep_title);

                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Department With Id: ' . $delete->dep_id . ' And Name: ' . $delete->dep_title);

                return redirect()->back()->with('success', 'Successfully Deleted');
            }

        } else {
//            return redirect('region_list')->with('fail', 'Failed Try Again!');
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }
    }

    public function department_validation($request)
    {
        $user = Auth::user();
        return $this->validate($request, [
//            'parent_head' => ['required', 'string'],
            'department_name' => ['required', 'string', 'unique:financials_departments,dep_title,null,null,dep_clg_id,' . $user->user_clg_id.',dep_branch_id,' . Session::get('branch_id')],
            'department_remarks' => ['nullable', 'string'],
        ]);

    }

    protected function AssignRegionValues($request, $department)//$account_code
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

//        $department->dep_account_code = $account_code;
        $department->dep_title = ucwords($request->department_name);
        $department->dep_remarks = ucfirst($request->department_remarks);
        $department->dep_createdby = $user->user_id;
        $department->dep_clg_id = $user->user_clg_id;
        $department->dep_branch_id = Session::get('branch_id');
        $department->dep_day_end_id = $day_end->de_id;
        $department->dep_day_end_date = $day_end->de_datetime;
        $department->dep_year_id = $this->getYearEndId();

        // coding from shahzaib start
        $tbl_var_name = 'department';
        $prfx = 'dep';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        return $department;
    }
}
