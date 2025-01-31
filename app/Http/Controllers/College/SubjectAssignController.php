<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Models\College\Classes;
use App\Models\College\Semester;
use App\Models\College\Subject;
use App\Models\College\SubjectAssigModel;
use App\Models\Department;
use App\Models\DesignationModel;
use App\User;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class SubjectAssignController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $departments = Department::where('dep_clg_id', $user->user_clg_id)->get();
        $Subjects = Subject::where('subject_clg_id', $user->user_clg_id)->get();
        $classes = Classes::where('class_clg_id', $user->user_clg_id)->where('class_type', 'SemesterWise')->get();
        $semesters = Semester::where('semester_clg_id', $user->user_clg_id)->whereNotIn('semester_name', ['Annual 1st Year', 'Annual 2nd Year'])->get();

        return view('collegeViews.SubjectAssign.subject_assign_create', compact('departments', 'Subjects', 'classes', 'semesters'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        // dd(Auth::user(), $request->all());
        $expiry_date = SubjectAssigModel::where('sa_class_id', $request->class)
            ->where('sa_semester_end_date', '>=', $request->semester_end_date)
            ->pluck('sa_semester_end_date')->first();
        $current_date =  Carbon::now();
        $c_date = date('Y-m-d', strtotime($current_date));
        if ($c_date >= $expiry_date) {
            DB::transaction(function () use ($request, $user) {
                $this->validate($request, [
                    // 'subject_name' => ['required', 'string', 'unique:subjects,subject_name,null,null,subject_clg_id,' . $user->user_clg_id],
                ]);
                $semester_end_date = date('Y-m-d', strtotime($request->semester_end_date));

                $subject_assign = new SubjectAssigModel();
                $subject_assign->sa_clg_id = $user->user_clg_id;
                $subject_assign->sa_branch_id = Session::get('branch_id');
                $subject_assign->sa_class_id = $request->class;
                $subject_assign->sa_semester_id = $request->semester;
                $subject_assign->sa_semester_end_date = $semester_end_date;
                $subject_assign->sa_subject_id = implode(",", $request->subject);
                $subject_assign->sa_created_by = $user->user_id;
                $subject_assign->sa_browser_info = $this->getBrwsrInfo();
                $subject_assign->sa_ip_address = $this->getIp();
                $subject_assign->sa_created_at = Carbon::now();
                $subject_assign->save();
            });
            return redirect()->route('subject_assign_list')->with('success', 'Saved Successfully');
        }

        return redirect()->back()->with('fail', 'Sorry Previous Semester Not End');
    }

    public function list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.region_list.region_list';
        $pge_title = 'Region List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('subject_assign')->where('sa_clg_id', $user->user_clg_id)
            ->leftJoin('classes', 'classes.class_id', '=', 'subject_assign.sa_class_id')
            ->leftJoin('branches', 'branches.branch_id', '=', 'subject_assign.sa_branch_id')
            ->leftJoin('semesters', 'semesters.semester_id', '=', 'subject_assign.sa_semester_id');


        // if (!empty($search)) {
        //     $query->where('sa_user_id', 'like', '%' . $search . '%')
        //         ->orWhere('sa_id', 'like', '%' . $search . '%');
        // }

        if (!empty($search_by_user)) {

            $query->where('sa_createdby', $search_by_user);
        }

        $datas = $query->select('subject_assign.*', 'classes.class_name', 'semesters.semester_name', 'branches.branch_name')->orderBy('sa_id', 'ASC')
            ->paginate($pagination_number);
        // ->get();

        $subject_assign = SubjectAssigModel::where('sa_clg_id', $user->user_clg_id)->orderBy('sa_id', config('global_variables.query_sorting'))->get(); //where('subject_delete_status', '!=', 1)->

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
            return view('collegeViews.SubjectAssign.subject_assign_list', compact('datas', 'search', 'subject_assign', 'search_by_user'));
        }
    }

    public function edit(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        $classes = Classes::where('class_clg_id', $user->user_clg_id)->where('class_type', 'SemesterWise')->get();
        $semesters = Semester::where('semester_clg_id', $user->user_clg_id)->whereNotIn('semester_name', ['Annual 1st Year', 'Annual 2nd Year'])->get();
        $Subjects = Subject::where('subject_clg_id', $user->user_clg_id)->get();
        return view('collegeViews.SubjectAssign.subject_assign_edit', compact('request', 'classes', 'Subjects', 'semesters'));
    }
    public function update(Request $request)
    {
        $user = Auth::user();
        // dd(Auth::user(), $request->all());

        DB::transaction(function () use ($request, $user) {
            $this->validate($request, [
                // 'subject_name' => ['required', 'string', 'unique:subjects,subject_name,null,null,subject_clg_id,' . $user->user_clg_id],
            ]);
            $semester_end_date = date('Y-m-d', strtotime($request->semester_end_date));
            $subject_assign = SubjectAssigModel::find($request->sa_id);
            $subject_assign->sa_clg_id = $user->user_clg_id;
            $subject_assign->sa_branch_id = Session::get('branch_id');
            $subject_assign->sa_class_id = $request->class;
            $subject_assign->sa_semester_id = $request->semester;
            $subject_assign->sa_semester_end_date = $semester_end_date;
            $subject_assign->sa_subject_id = implode(",", $request->subject);
            $subject_assign->sa_created_by = $user->user_id;
            $subject_assign->sa_browser_info = $this->getBrwsrInfo();
            $subject_assign->sa_ip_address = $this->getIp();
            $subject_assign->sa_created_at = Carbon::now();
            $subject_assign->save();
        });
        return redirect()->route('subject_assign_list')->with('success', 'Saved Successfully');
    }

    public function get_expiry(Request $request)
    {
        $currentDate = Carbon::now();
        $semester_expiry =  SubjectAssigModel::where('sa_semester_id', $request->semester_id)
            ->where('sa_class_id', $request->class_id)->where('sa_semester_end_date', '>=', $request->date)
            ->pluck('sa_semester_end_date')->first();
        return response()->json($semester_expiry);
    }
    // public function assign_subject(Request $request)
    // {
    //     $currentDate = Carbon::now();
    //     $semester_expiry =  SubjectAssigModel::where('sa_semester_id', $request->semester_id)
    //         ->where('sa_class_id', $request->class_id)->where('sa_semester_end_date', '>=', $request->date)
    //         ->pluck('sa_semester_end_date')->first();
    //     return response()->json($semester_expiry);
    // }
}
