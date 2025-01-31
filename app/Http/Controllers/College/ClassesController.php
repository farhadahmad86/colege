<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Models\College\Classes;
use App\Models\College\Degree;
use App\Models\College\Group;
use App\Models\College\Program;
use App\Models\College\Section;
use App\Models\College\Semester;
use App\Models\College\SessionModel;
use App\Models\College\Student;
use App\Models\College\Subject;
use App\Models\Department;
use App\User;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Builder\Class_;
use Session;

class ClassesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $datas = Classes::with('colleges')->with('branches')->with('users')->with('degrees')->with('groups')->with('subjects')->with('semesters')->get();

    //     return view('collegeViews.classes.class_list', compact('datas'));
    // }
    public function index(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.college.information_pdf.class_list';
        $pge_title = 'Classes List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;
        // $query = Classes::with('users')->where('class_clg_id', $user->user_clg_id)->toSql();
        $query = DB::table('classes')
            ->where('class_clg_id', $user->user_clg_id)
//            ->where('class_branch_id', Session::get('branch_id'))
            ->leftJoin('degrees', 'degrees.degree_id', '=', 'classes.class_degree_id')
            ->leftJoin('sessions', 'sessions.session_id', '=', 'classes.class_session_id')
            ->leftJoin('branches', 'branches.branch_id', '=', 'classes.class_branch_id')
            ->leftJoin('programs', 'programs.program_id', '=', 'classes.class_program_id');
        if (!empty($search)) {
            $query->where('class_name', 'like', '%' . $search . '%')
                ->orWhere('class_id', 'like', '%' . $search . '%');
        }
        if (!empty($search_by_user)) {
            $query->where('class_createdby', $search_by_user);
        }
        if (!empty($search_year)) {
            $query->where('class_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('class_year_id', '=', $search_year);
        }
        $restore_list = $request->restore_list;
        $datas = $query->select('classes.*', 'programs.program_name', 'programs.program_id', 'degrees.degree_name', 'sessions.session_name', 'branches.branch_name')->orderBy('class_id', 'ASC')
            ->paginate($pagination_number);

        $class_title = Classes::where('class_clg_id', $user->user_clg_id)->orderBy('class_id', config('global_variables.query_sorting'))->pluck('class_name')->all(); //where('class_delete_status', '!=', 1)->


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
            return view('collegeViews.classes.class_list', compact('datas','search_year', 'search', 'class_title', 'search_by_user', 'restore_list', 'user'));
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $degree = Degree::where('degree_clg_id', $user->user_clg_id)->get();
        $sessions = SessionModel::where('session_clg_id', $user->user_clg_id)->get();

        return view('collegeViews.classes.add_class', compact('degree', 'sessions'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        // dd($request->all(), $user);
        DB::transaction(function () use ($request, $user) {
            $this->validate($request, [
                'name' => ['required', 'string', 'unique:classes,class_name,null,null,class_clg_id,' . $user->user_clg_id],
                'attendance' => ['required', 'string'],
                'class_type' => ['required', 'string'],
                // 'subject_name' => ['required', 'string', 'unique:subjects,subject_name,null,null,subject_clg_id,' . $user->user_clg_id],
                // 'fa_date' => ['required', 'date'],
            ]);
            $class =  new Classes();
            $class->class_clg_id = $user->user_clg_id;
            $class->class_branch_id  = Session::get('branch_id');
            $class->class_name = $request->name;
            $class->class_degree_id  = $request->degree;
            $class->class_session_id  = $request->session;
            $class->class_program_id  = $request->program;
            // $class->class_incharge_id  = $request->class_incharge;
            $class->class_demand  = $request->demand;
            $class->class_attendance  = $request->attendance;
            $class->class_type  = $request->class_type;
            $class->class_created_by = $user->user_id;
            $class->class_browser_info = $this->getBrwsrInfo();
            $class->class_ip_address = $this->getIp();
            $class->class_year_id = $this->getYearEndId();
            $class->save();
        });
        return redirect()->route('class_list')->with('success', 'Saved Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Classes $classes)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        // $count = Student::where('class_id', $request->class_id)->count();
        // if($count == 0){
        $user = Auth::user();
        $degree = Degree::where('degree_clg_id', $user->user_clg_id)->get();
        $sessions = SessionModel::where('session_clg_id', $user->user_clg_id)->get();
        return view('collegeViews.classes.edit_class', compact('request', 'degree', 'sessions'));
        // }else{
        //  return redirect()->back()->with('fail' , 'Class Already used You cannot edit this class !');
        // }


    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        // dd($request->all(), $user);
        DB::transaction(function () use ($request, $user) {
            $this->validate($request, [
                'name' => ['required', 'string', 'unique:classes,class_name,' . $request->class_id . ',class_id,class_clg_id,' . $user->user_clg_id],
                // 'fa_date' => ['required', 'date'],
                // 'name' => ['required', 'string', 'unique:classes,class_name,null,null,class_clg_id,' . $user->user_clg_id],
            ]);
            $class =  Classes::find($request->class_id);
            $class->class_clg_id = $user->user_clg_id;
            $class->class_branch_id  = Session::get('branch_id');
            $class->class_name = $request->name;
            $class->class_degree_id  = $request->degree;
            $class->class_session_id  = $request->session;
            $class->class_program_id  = $request->program;
            // $class->class_incharge_id  = $request->class_incharge;
            $class->class_demand  = $request->demand;
            $class->class_attendance  = $request->attendance;
            $class->class_type  = $request->class_type;
            $class->class_created_by = $user->user_id;
            $class->class_browser_info = $this->getBrwsrInfo();
            $class->class_ip_address = $this->getIp();
            $class->save();
        });
        return redirect()->route('class_list')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classes $classes)
    {
        //
    }
    //    public function dashboard(Classes $classes)
    //    {
    //        $user = Auth::user();
    //        $classes = Classes::where('class_clg_id', $user->user_clg_id)->get();
    //        // dd($classes);
    //     return view('collegeViews.classes.dashboard', compact('classes'));
    //    }
    public function dashboard(Request $request, $array = null, $str = null)
    {
        $branch_id = Session::get('branch_id');

        $user = Auth::user();
        $ar = json_decode($request->array);
        $search_class = (!isset($request->class_id) && empty($request->class_id)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->class_id;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.region_list.region_list';
        $pge_title = 'Region List';
        $srch_fltr = [];
        array_push($srch_fltr, $search_class);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $classes = Classes::where('class_clg_id', $user->user_clg_id)->get();

        $query = DB::table('classes')->where('class_clg_id', $user->user_clg_id);

        if (!empty($search_class)) {
            $query->where('class_id', $search_class);
        }

        $datas = $query->orderBy('class_id', 'ASC')
            ->paginate($pagination_number);
        //dd($datas);
        // dd($classes);
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
            return view('collegeViews.classes.dashboard', compact('datas', 'classes', 'search_class'));
        }
    }
}
