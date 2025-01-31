<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Models\AreaModel;
use App\Models\College\Branch;
use App\Models\College\Classes;
use App\Models\College\CustomVoucherItemsModel;
use App\Models\College\CustomVoucherModel;
use App\Models\College\FeeVoucherModel;
use App\Models\College\Student;
use App\Models\College\StudentInstallment;
use App\Models\College\StudentsPackageModel;
use App\Models\College\StudentTransferModel;
use App\Models\RegionModel;
use App\Models\StudentAttendanceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class StudentTransferController extends Controller
{
    public function student_transfer(Request $request)
    {
        $user = Auth::user();
        $student = Student::where('id', '=', $request->student_id)
            ->leftJoin('classes', 'classes.class_id', '=', 'students.class_id')
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'students.section_id')
            ->leftJoin('new_groups', 'new_groups.ng_id', '=', 'students.group_id')
            ->leftJoin('branches', 'branches.branch_id', '=', 'students.branch_id')
            ->select('students.*', 'classes.class_name', 'create_section.cs_name', 'branches.branch_name', 'new_groups.ng_name')
            ->first();
        $branches = Branch::where('branch_clg_id', $user->user_clg_id)->get();
        $classes = Classes::where('class_clg_id', $user->user_clg_id)->get();
        return view('collegeViews/studentTransfer/student_transfer', compact('student', 'branches', 'classes'));
    }

    public function submit_student_transfer(Request $request)
    {
        DB::transaction(function () use ($request) {
            $branch_id = $request->branch;
            $class_id = $request->class;
            $section_id = $request->section;
            $student_id = $request->student_id;
            $group_id = $request->group;
            $reg_no = $request->reg_no;
            $current =  Student::where('id', $student_id)->where('registration_no', $reg_no)->first();
            $user = Auth::user();
            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->getIp();

            $validated = $request->validate([
                'branch' => ['required', 'integer'],
                'class' => ['required', 'integer'],
                'section' => ['required', 'integer'],
            ]);

            $custom_voucher = CustomVoucherModel::where('cv_std_id', $student_id)->where('cv_reg_no', $reg_no)->pluck('cv_id');
            $transfer_student = new StudentTransferModel();
            $transfer_student->st_std_id = $student_id;
            $transfer_student->st_reg_no = $reg_no;
            $transfer_student->st_branch_id = $current->branch_id;
            $transfer_student->st_class_id = $current->class_id;
            $transfer_student->st_section_id = $current->section_id;
            $transfer_student->st_group_id = $current->group_id;
            $transfer_student->st_brwsr_info = $brwsr_rslt;
            $transfer_student->st_ip_adrs = $clientIP;
            $transfer_student->st_created_by = $user->user_id;
            $transfer_student->st_clg_id = $user->user_clg_id;
            $transfer_student->st_year_id = $this->getYearEndId();
            $transfer_student->save();

            Student::where('id', $student_id)->where('registration_no', $reg_no)->update([
                'branch_id' => $branch_id,
                'class_id' => $class_id,
                'section_id' => $section_id,
                'group_id' => $group_id,
            ]);
            FeeVoucherModel::where('fv_std_id', $student_id)->where('fv_std_reg_no', $reg_no)->update([
                'fv_branch_id' => $branch_id,
                'fv_class_id' => $class_id,
                'fv_section_id' => $section_id,
            ]);
            CustomVoucherModel::where('cv_std_id', $student_id)->where('cv_reg_no', $reg_no)->update([
                'cv_branch_id' => $branch_id,
                'cv_class_id' => $class_id,
                'cv_section_id' => $section_id,
            ]);
            CustomVoucherItemsModel::whereIn('cvi_voucher_id', $custom_voucher)->update([
                'cvi_class_id' => $class_id,
                'cvi_section_id' => $section_id,
            ]);

            StudentInstallment::where('si_std_id', $student_id)->where('si_std_reg', $reg_no)->update([
                'si_branch_id' => $branch_id,
                'si_class_id' => $class_id,
                'si_section_id' => $section_id,
            ]);
            StudentsPackageModel::where('sp_sid', $student_id)->where('sp_std_reg', $reg_no)->update([
                'sp_branch_id' => $branch_id,
                'sp_class_id' => $class_id,
                'sp_section_id' => $section_id,
                'sp_group_id' => $group_id,
            ]);

        });

        return redirect()->route('student_dashboard')->with('success', 'Transfer Successfully');
    }

    // code by mustafa start
    public function student_transfer_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $regions = RegionModel::where('reg_clg_id', '=', $user->user_clg_id)->orderby('reg_title', 'ASC')->get();

        //        $search = (isset($request->search) && $request->filter_search === "normal_search") ? $request->search : '';
        //        $search_region = (isset($request->region) && $request->filter_search === "filter_search") ? $request->region : '';

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_region = (!isset($request->region) && empty($request->region)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->region;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';

        $prnt_page_dir = 'print.area_list.area_list';
        $pge_title = 'Area List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_region, $search_by_user);


        $pagination_number = (empty($ar) || !empty($ar)) ? 30 : 100000000;

        $query = DB::table('financials_areas')
            ->join('financials_region', 'financials_region.reg_id', '=', 'financials_areas.area_reg_id')
            ->leftJoin('financials_users', 'financials_users.user_id', '=', 'financials_areas.area_createdby')
            ->where('area_clg_id', '=', $user->user_clg_id);


        if (!empty($search)) {

            $pagination_number = 1000000;
            $query->orWhere('area_id', 'like', '%' . $search . '%')
                ->orWhere('area_title', 'like', '%' . $search . '%')
                ->orWhere('area_remarks', 'like', '%' . $search . '%')
                ->orWhere('reg_title', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%');
        }

        if (!empty($search_region)) {
            $pagination_number = 1000000;
            $query->where('area_reg_id', '=', $search_region);
        }

        if (!empty($search_by_user)) {
            $pagination_number = 1000000;
            $query->where('area_createdby', '=', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1) {
            $query->where('area_delete_status', '=', 1);
        } else {
            $query->where('area_delete_status', '!=', 1);
        }

        $datas = $query
            //            ->where('area_delete_status', '!=', 1)
            ->orderBy('area_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);


        $area_title = AreaModel::where('area_clg_id', '=', $user->user_clg_id)->where('area_delete_status', '!=', 1)->orderBy('area_title', 'ASC')->pluck('area_title')->all();


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
            return view('area_list', compact('datas', 'search', 'area_title', 'regions', 'search_region', 'restore_list'));
        }
    }

    // code by mustafa end
    //code by burhan start

    public function transfer_student_attendace_record(Request $request, $array = null, $str = null)
    {

        $branch = Session::get('branch_id');
        $search_student = $request->student_id;
        $search_section = $request->section_id;
        // $students = StudentTransferModel::with('getStudent')->where('st_branch_id', $branch)->groupBy('st_std_id')->get();
        if (!empty($request->start_date) && !empty($request->end_date)) {
            $start = date('Y-m-d', strtotime($request->start_date));
            $end = date('Y-m-d', strtotime($request->end_date));
        } else {
            $start = $request->start_date;
            $end = $request->end_date;
        }

        $students = StudentTransferModel::where('st_branch_id', $branch)
            ->leftJoin('students', 'students.id', '=', 'st_std_id')->groupBy('st_std_id')->get();

        $attendaces = StudentAttendanceModel::where('std_att_section_id', $request->section_id)
            ->whereBetween('std_att_date', [$start, $end])->orderBy('std_att_date')
            ->get();
        return view('collegeViews.studentService.transfer_student_attendace_record', compact('attendaces', 'students', 'search_section', 'search_student', 'start', 'end'));
    }
}
