<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AttendanceModel;
use App\Models\Department;
use App\Models\GenerateSalarySlipModel;
use App\Models\YearEndModel;
use App\User;
use PDF;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    public function add_attendance()
    {
        $departments = Department::where('dep_delete_status', '!=', 1)->where('dep_disabled', '!=', 1)->where('dep_clg_id', Auth::user()->user_clg_id)->get();
        return view('add_attendance', compact('departments'));
    }

    public function submit_attendance(Request $request)
    {

        $this->attendance_validation($request);

        $rollBack = false;

        $user = Auth::user();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $requested_arrays = $request->employee_id;

        foreach ($requested_arrays as $index => $requested_array) {

            $item_employee_id = $request->employee_id[$index];
            $item_month_days = $request->month_days[$index];
            $item_attend_days = $request->attend_days[$index];

            $generate_salary_array[] = [
                'employee_id' => $item_employee_id,
                'month_days' => $item_month_days,
                'attend_days' => $item_attend_days,
            ];
        }

        $department_id = $request->department;
        $month = $request->month;
        DB::beginTransaction();


        $item = $this->voucher_attendance_values($generate_salary_array, $department_id, $month, $day_end, 'atten');

        if (!DB::table('financials_attendance')->insert($item)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        }

        if ($rollBack) {

            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        } else {

            DB::commit();
            return redirect()->back()->with('success', 'Successfully Saved');
        }
    }

    public function attendance_validation($request)
    {
        return $this->validate($request, [
            'remarks' => ['nullable', 'string'],
            'month' => ['required', 'string'],
            'total_amount' => ['required', 'string'],
        ]);
    }

    public function voucher_attendance_values($values_array, $department, $month_year, $day_end, $prfx)
    {
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $user = Auth::user();

        $data = [];
        $employee_id = $prfx . '_emp_id';
        $department_id = $prfx . '_department_id';
        $month_days = $prfx . '_month_days';
        $attend_days = $prfx . '_attend_days';
        $month = $prfx . '_month';

        $created_datetime = $prfx . '_datetime';
        $day_end_id = $prfx . '_day_end_id';
        $day_end_date = $prfx . '_day_end_date';
        $createdby = $prfx . '_created_by';
        $brwsr_info = $prfx . '_brwsr_info';
        $ip_adrs = $prfx . '_ip_adrs';
        $clg_id = $prfx . '_clg_id';
        $branch_id = $prfx . '_branch_id';

        foreach ($values_array as $key) {
            $data[] = [
                $employee_id => $key['employee_id'],
                $department_id => $department,
                $month_days => $key['month_days'],
                $attend_days => $key['attend_days'],
                $month => $month_year,

                $created_datetime => Carbon::now()->toDateTimeString(),
                $day_end_id => $day_end->de_id,
                $day_end_date => $day_end->de_datetime,
                $createdby => $user->user_id,
                $clg_id => $user->user_clg_id,
                $branch_id => Session::get('branch_id'),
                $brwsr_info => $brwsr_rslt,
                $ip_adrs => $ip_rslt,
            ];
        }

        return $data;
    }


    // update code by Mustafa start
    public function attendance_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $departments = Department::where('dep_clg_id', $user->user_clg_id)->orderby('dep_title', 'ASC')->get();

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_month = (!isset($request->month) && empty($request->month)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->month;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->from;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $search_department = (isset($request->department) && !empty($request->department)) ? $request->department : '';
        $prnt_page_dir = 'print.attendance.attendance_list';
        $pge_title = 'Attendance List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_month, $search_to, $search_from, $search_department);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $query = DB::table('financials_attendance')
            ->where('atten_clg_id', $user->user_clg_id)
            ->leftJoin('financials_departments', 'financials_departments.dep_id', 'financials_attendance.atten_department_id')
            ->where('dep_clg_id', $user->user_clg_id)
            ->leftJoin('financials_users as emp', 'emp.user_id', 'financials_attendance.atten_emp_id')
            ->where('emp.user_clg_id', $user->user_clg_id)
            ->leftJoin('financials_users as user', 'user.user_id', 'financials_attendance.atten_created_by');


        if (!empty($request->search)) {
            $query
                ->Where('emp.user_name', 'like', '%' . $search . '%')
                ->orWhere('atten_id', 'like', '%' . $search . '%')
                ->orWhere('atten_month_days', 'like', '%' . $search . '%')
                ->orWhere('atten_attend_days', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('atten_created_by', $search_by_user);
        }

        if (!empty($search_department)) {
            $query->where('atten_department_id', $search_department);
        }
        if (!empty($search_month)) {
            $query->where('atten_month', $search_month);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('ss_day_end_date', [$start, $end]);
            $query->whereDate('atten_day_end_date', ' >= ', $start)
                ->whereDate('atten_day_end_date', ' <= ', $end);
        } elseif (!empty($search_to)) {
            $query->where('atten_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('atten_day_end_date', $end);
        }
        if (!empty($search_year)) {
            $query->where('atten_year_id', '=', $search_year);
        } else {
            $search_year =$this->getYearEndId();
            $query->where('atten_year_id', '=', $search_year);
        }


        $datas = $query->select('financials_attendance.*', 'emp.user_name as employee', 'user.user_name as created_by', 'user.user_id as user_id', 'financials_departments.dep_title as department')
            ->orderBy('atten_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);
        $employees = User::where('user_salary_person', 1)->where('user_clg_id', $user->user_clg_id)->pluck('user_name');
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
            return view('attendance_list', compact('datas', 'employees','search_year', 'search', 'search_to', 'search_from', 'search_by_user', 'departments', 'search_department', 'search_month'));
        }

    }

    // update code by Mustafa end

    public function edit_attendance(Request $request)
    {
        $user = Auth::user();
        $attendance = AttendanceModel::where('atten_id', $request->attendance_id)->first();
        $generate = GenerateSalarySlipModel::where('gss_month', $attendance->atten_month)
            ->where('gss_department_id', $attendance->atten_department_id)->where('gss_clg_id', $user->user_clg_id)->count();
        if ($generate > 0) {
            return redirect()->back()->with('fail', 'Salary Slip you are not edit Attendance');
        }
        $departments = Department::where('dep_delete_status', '!=', 1)->where('dep_disabled', '!=', 1)->where('dep_clg_id', $user->user_clg_id)->get();
        $employees = User::where('user_department_id', '=', $attendance->atten_department_id)->where('user_salary_person', '=', 1)->where('user_clg_id', $user->user_clg_id)->get();
        return view('edit_attendance', compact('departments', 'attendance', 'employees'));
    }

    public function update_attendance(AttendanceModel $attendance, Request $request)
    {
        $validated = $request->validate([
            'month_days' => ['required', 'string'],
            'attend_days' => ['required', 'string'],
        ]);
        $attendance->atten_month_days = $request->month_days;
        $attendance->atten_attend_days = $request->attend_days;
        $attendance->save();
        return redirect()->route('attendance_list')->with('success', 'Attendance Updated Successfully!');
    }

    public function get_employees(Request $request)
    {
        $user = Auth::user();
        $department_id = $request->department_id;

        $generated = AttendanceModel::where('atten_month', '=', $request->month)->where('atten_department_id', '=', $department_id)->where('atten_clg_id', $user->user_clg_id)->count();
        if ($generated > 0) {
            return response()->json(compact('generated'), 200);
        } else {

            $employees = User::where('user_salary_person', 1)->where('user_department_id', $department_id)->where('user_clg_id', $user->user_clg_id)->get();

            return response()->json(compact('employees', 'generated'), 200);
        }
    }
}
