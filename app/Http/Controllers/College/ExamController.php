<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Models\College\AssignAttendanceModel;
use App\Models\College\AssignCoordinatorModel;
use App\Models\College\Branch;
use App\Models\College\Classes;
use App\Models\College\ExamModel;
use App\Models\College\Group;
use App\Models\College\GroupItems;
use App\Models\College\MarkExamModel;
use App\Models\College\NewGroupsModel;
use App\Models\College\Section;
use App\Models\College\Student;
use App\Models\College\Subject;
use App\Models\CreateSectionModel;
use App\Models\StudentAttendanceModel;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use PHPUnit\TextUI\XmlConfiguration\Groups;

class ExamController extends Controller
{
    public function create_exam()
    {

        $user = Auth::user();
        $classes = Classes::where('class_clg_id', $user->user_clg_id)->get();
        return view('collegeViews.exam.create_exam', compact('classes'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        // dd($request->all(), $user);
        DB::transaction(function () use ($request, $user) {
            $this->validate($request, [
                'exam_title' => ['required', 'string'],
                'exam_type' => ['required', 'string'],
            ]);
            $exam_start_date = date('Y-m-d', strtotime($request->to));
            $exam_end_date = date('Y-m-d', strtotime($request->from));
            $exam =  new ExamModel();
            $exam->exam_clg_id = $user->user_clg_id;
            $exam->exam_branch_id  = Session::get('branch_id');
            $exam->exam_name = $request->exam_title;
            $exam->exam_type  = $request->exam_type;
            $exam->exam_start_date  = $exam_start_date;
            $exam->exam_end_date  = $exam_end_date;
            $exam->exam_class_id  = implode(',', $request->class);
            $exam->exam_description  = $request->description;
            $exam->exam_created_by = $user->user_id;
            $exam->exam_browser_info = $this->getBrwsrInfo();
            $exam->exam_ip_address = $this->getIp();
            $exam->exam_year_id = $this->getYearEndId();
            $exam->save();
        });
        return redirect()->back()->with('success', 'Saved Successfully');
    }

    public function index(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $prnt_page_dir = 'print.region_list.region_list';
        $pge_title = 'Region List';
        $srch_fltr = [];
        array_push($srch_fltr, $search,$search_year);
        $pagination_number = (empty($ar)) ? 100000000 : 100000000;
        // $query = Classes::with('users')->where('class_clg_id', $user->user_clg_id)->toSql();
        $query = DB::table('exam')
            ->where('exam_clg_id', $user->user_clg_id)
            ->leftJoin('branches', 'branches.branch_id', '=', 'exam.exam_branch_id')
            ->leftJoin('financials_users', 'financials_users.user_id', '=', 'exam.exam_created_by');
        if (!empty($search)) {
            $query->where('exam_name', 'like', '%' . $search . '%')
                ->orWhere('exam_id', 'like', '%' . $search . '%');
        }
        if (!empty($search_year)) {
            $query->where('exam_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('exam_year_id', '=', $search_year);
        }
        $datas = $query->select('exam.*','financials_users.user_name', 'branches.branch_name')->orderBy('exam_id', 'DESC')
            ->paginate($pagination_number);
        $exams = ExamModel::where('exam_clg_id', $user->user_clg_id)->where('exam_branch_id', Session::get('branch_id'))->orderBy('exam_id', config('global_variables.query_sorting'))->pluck('exam_name')->all(); //where('class_delete_status', '!=', 1)->
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
            return view('collegeViews.exam.exam_list', compact('datas', 'search','search_year', 'user', 'exams'));
        }
    }

    public function edit(Request $request)
    {
        // $count = Student::where('class_id', $request->class_id)->count();
        // if($count == 0){
        $user = Auth::user();
        $classes = Classes::where('class_clg_id', $user->user_clg_id)->get();
        return view('collegeViews.exam.edit_exam', compact('request', 'classes'));
        // }else{
        //  return redirect()->back()->with('fail' , 'Class Already used You cannot edit this class !');
        // }
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        DB::transaction(function () use ($request, $user) {
            // $this->validate($request, [
            // 'exam_title' => ['required', 'string', 'unique:exam,exam_name,' . $request->class_id . ',class_id,class_clg_id,' . $user->user_clg_id],
            // 'fa_date' => ['required', 'date'],
            // 'name' => ['required', 'string', 'unique:classes,class_name,null,null,class_clg_id,' . $user->user_clg_id],
            // ]);
            $exam_start_date = date('Y-m-d', strtotime($request->to));
            $exam_end_date = date('Y-m-d', strtotime($request->from));
            $exam =  ExamModel::where('exam_clg_id', $user->user_clg_id)->where('exam_id', $request->exam_id)->first();
            // dd($exam);
            $exam->exam_clg_id = $user->user_clg_id;
            $exam->exam_branch_id  = Session::get('branch_id');
            $exam->exam_name = $request->exam_title;
            $exam->exam_type  = $request->exam_type;
            $exam->exam_start_date  = $exam_start_date;
            $exam->exam_end_date  = $exam_end_date;
            $exam->exam_class_id  = implode(',', $request->class);
            $exam->exam_description  = $request->description;
            $exam->exam_created_by = $user->user_id;
            $exam->exam_browser_info = $this->getBrwsrInfo();
            $exam->exam_ip_address = $this->getIp();
            $exam->save();
        });
        return redirect()->route('exam_list')->with('success', 'Updated Successfully');
    }

    public function exam_class_list(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        if (empty($request->exam_class_id)) {
            return redirect()->route('exam_list');
        }
        $class_id = explode(',', $request->exam_class_id);
        $co_ordinator = AssignCoordinatorModel::
        where('ac_clg_id', $user->user_clg_id)
            ->whereIn('ac_class_id',$class_id)
            ->where('ac_coordinator_id', $user->user_id)
            ->where('ac_branch_id', Session::get('branch_id'))
            ->pluck('ac_section_id');
        // dd($co_ordinator);
        if (!empty($co_ordinator) && $user->user_designation == 14) {
            $processed_section_ids = $co_ordinator->flatMap(function($item) {
                // Explode comma-separated values into individual items
                return explode(',', $item);
            })->toArray();
            $all_groups = Group::
            where('group_clg_id', $user->user_clg_id)
                ->where('group_disable_enable','=',1)
                ->whereIn('group_class_id', $class_id)
                ->whereIn('group_section_id', $processed_section_ids)
                ->get();
            $classes = [];
            $sections = [];
            $ng_groups = [];
            foreach ($all_groups as $class_id => $groupsIds) {
                $group_class_id = $groupsIds->group_class_id;
                $group_section_id = $groupsIds->group_section_id;
                $group_name = $groupsIds->group_name;
                $classModel = Classes::
                where('class_clg_id', $user->user_clg_id)
                    ->where('class_id', $group_class_id)
                    ->select('class_id', 'class_name')
                    ->first();

                $sectionModel = CreateSectionModel::where('cs_clg_id', $user->user_clg_id)
                    ->where('cs_id', $group_section_id)->where('cs_branch_id', Session::get('branch_id'))
                    ->select('cs_id', 'cs_name')
                    ->first();

                $ngModel = NewGroupsModel::where('ng_clg_id', $user->user_clg_id)
                    ->where('ng_id', $group_name)
                    ->select('ng_id', 'ng_name')
                    ->first();

                if ($classModel && $sectionModel && $ngModel) {
                    // If the matching records are found, store them in their respective arrays
                    $classes[] = $classModel;
                    $sections[] = $sectionModel;
                    $ng_groups[] = $ngModel;
                }

            }
        } else {
            $all_groups = [];
            for ($i = 0; $i < count($class_id); $i++) {
                $groups = Group::where('group_clg_id', $user->user_clg_id)
                    ->where('group_branch_id', Session::get('branch_id'))
                    ->where('group_class_id', $class_id[$i])
                    ->where('group_disable_enable', 1)
                    ->get();
                // Add the groups to the $all_groups array
                $all_groups[$class_id[$i]] = $groups;
            }
            // dd($all_groups);
            $classes = [];
            $sections = [];
            $ng_groups = [];
            foreach ($all_groups as $class_id => $groupId) {
                foreach ($groupId as $group) {

                    $group_class_id = $group->group_class_id;
                    $group_section_id = $group->group_section_id;
                    $group_name = $group->group_name;
                    $classModel = Classes::where('class_clg_id', $user->user_clg_id)
                        ->where('class_id', $group_class_id)
                        ->select('class_id', 'class_name')
                        ->first();

                    $sectionModel = CreateSectionModel::where('cs_clg_id', $user->user_clg_id)
                        ->where('cs_id', $group_section_id)->where('cs_branch_id', Session::get('branch_id'))
                        ->select('cs_id', 'cs_name')
                        ->first();

                    $ngModel = NewGroupsModel::where('ng_clg_id', $user->user_clg_id)
                        ->where('ng_id', $group_name)
                        ->select('ng_id', 'ng_name')
                        ->first();
                    // dd($classModel,$sectionModel,$ngModel);
                    if ($classModel && $sectionModel && $ngModel) {
                        // If the matching records are found, store them in their respective arrays
                        $classes[] = $classModel;
                        $sections[] = $sectionModel;
                        $ng_groups[] = $ngModel;
                    }
                    // Accessing the properties of the group

                }
            }
            $branch = Branch::where('branch_clg_id', $user->user_clg_id)->where('branch_id', $request->exam_branch_id)->pluck('branch_name')->first();
            return view('collegeViews.exam.exam_class_list', compact('classes', 'sections', 'ng_groups', 'request', 'branch'));
        }
        // dd($classes,$sections,$ng_groups);
        $branch = Branch::where('branch_clg_id', $user->user_clg_id)->where('branch_id', $request->exam_branch_id)->pluck('branch_name')->first();
        return view('collegeViews.exam.exam_class_list', compact('classes', 'sections', 'ng_groups', 'request', 'branch'));
    }

    public function group_subject_list(Request $request)
    {
        // dd($request->all());
        $exam_id = Session::get('exam_id');
        $class_id = Session::get('class_id');
        $ng_id = Session::get('ng_id');
        $cs_id = Session::get('cs_id');
        if (empty($exam_id) && empty($ng_id) && empty($cs_id) && empty($class_id)) {
            $exam_id = $request->exam_id;
            $class_id = $request->class_id;
            $ng_id = $request->ng_id;
            $cs_id = $request->cs_id;
            // Session::put('cls_id', $request->class_id);
        }
        $user = Auth::user();
        if (empty($class_id)) {
            return redirect()->route('exam_list');
        }
        $exam_name = ExamModel::where('exam_id', $exam_id)->pluck('exam_name')->first();
        $subjects = GroupItems::where('grpi_class_id', $class_id)
            ->where('grpi_section_id', $cs_id)
            ->where('grpi_gn_id', $ng_id)
            ->leftjoin('subjects', 'subjects.subject_id', '=', 'group_items.grpi_subject_id')
            ->groupBy('grpi_subject_id')
            ->select('subjects.subject_id', 'subjects.subject_name')
            ->get();
        Session::forget(['exam_id', 'class_id', 'cs_id', 'ng_id']);
        $class = Classes::where('class_clg_id', $user->user_clg_id)->where('class_id', $class_id)->pluck('class_name')->first();
        return view('collegeViews.exam.group_subject_list', compact('subjects', 'exam_id','class_id','ng_id','cs_id', 'class','exam_name'));
    }

    public function mark_subject(Request $request, $array = null, $str = null)
    {


        $ar = json_decode($request->array);
        $search_subject = (!isset($request->subject_id) && empty($request->subject_id)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->subject_id;
        // $search_exam = (!isset($request->exam_id) && empty($request->exam_id)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->exam_id;
        $search_class = (!isset($request->class_id) && empty($request->class_id)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->class_id;
        $search_group = (!isset($request->ng_id) && empty($request->ng_id)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->ng_id;
        $search_section = (!isset($request->cs_id) && empty($request->cs_id)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->cs_id;
        $prnt_page_dir = 'print.college.mark_report.mark_report';
        $pge_title = 'Student Mark';
        $srch_fltr = [];
        array_push($srch_fltr, $search_subject, $search_class, $search_group, $search_section);
        $exam_date = date('Y-m-d', strtotime($request->date));
        $pagination_number = (empty($ar)) ? 100000000 : 100000000;
        $user = Auth::user();
        if (empty($search_class)) {
            // dd($request->all(),$class_id);
            return redirect()->route('exam_list');
        }

        $subjects = GroupItems::where('grpi_class_id', $search_class)
            ->where('grpi_section_id', $search_section)
            ->where('grpi_gn_id', $search_group)
            ->leftjoin('subjects', 'subjects.subject_id', '=', 'group_items.grpi_subject_id')
            ->groupBy('grpi_subject_id')
            ->select('subjects.subject_id', 'subjects.subject_name')
            ->paginate($pagination_number);
            $presentStudents = StudentAttendanceModel::where('std_att_class_id', $search_class)->where('std_att_section_id', $search_section)->where('std_att_date', $exam_date)->pluck('std_attendance');
            // dd($presentStudents);
        $class = Classes::where('class_clg_id', $user->user_clg_id)
            ->where('class_id', $search_class)->pluck('class_name')->first();
        $section = CreateSectionModel::where('cs_clg_id', $user->user_clg_id)
            ->where('cs_id', $search_section)->pluck('cs_name')->first();
        $group = NewGroupsModel::where('ng_clg_id', $user->user_clg_id)
            ->where('ng_id', $search_group)->pluck('ng_name')->first();
        $subject_name = Subject::where('subject_clg_id', $user->user_clg_id)
            ->where('subject_id', $search_subject)->pluck('subject_name')->first();
        $students = Student::where('clg_id', $user->user_clg_id)
            ->where('class_id', $search_class)
            ->where('section_id', $search_section)
            ->where('group_id', $search_group)
            ->where('status' , '!=' , 3)
            ->where('branch_id', Session::get('branch_id'))->orderBy('roll_no', 'ASC')->get();
        $subject_marks = MarkExamModel::where('me_exam_id', $request->exam_id)->where('me_class_id', $search_class)->where('me_section_id', $request->cs_id)->where('me_subject_id', $request->subject_id)->where(
            'me_ng_id',
            $search_group
        )->first();
        if (isset($request->array) && !empty($request->array)) {
            // dd($request->all(),$class);
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
            $pdf->loadView($prnt_page_dir, compact('students', 'type', 'class', 'section', 'group',  'pge_title', 'subject_name'));
            // $pdf->setOptions($options);
            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('collegeViews.exam.mark_subject', compact('subjects', 'search_class', 'search_subject', 'request', 'class', 'students', 'subject_marks','presentStudents'));
        }
    }
}
