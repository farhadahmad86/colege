<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Models\College\Classes;
use App\Models\College\Group;
use App\Models\College\GroupItems;
use App\Models\College\NewGroupsModel;
use App\Models\College\Semester;
use App\Models\College\Subject;
use App\Models\User;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class GroupController extends Controller
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
    //     $datas = Group::with('colleges')->with('branches')->with('users')->where('group_disable_enable', 1)->get();
    //     return view('group.group', compact('datas'));
    // }
    // update code by farhad gul start
    public function index(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = !isset($request->search) && empty($request->search) ? (!empty($ar) ? $ar[1]->{'value'} : '') : $request->search;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $search_by_user = isset($request->search_by_user) && !empty($request->search_by_user) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.college.information_pdf.assign_group_list';
        $pge_title = 'Assign Group List';
        $srch_fltr = [];
        array_push($srch_fltr, $search,$search_year);

        $pagination_number = empty($ar) ? 30 : 100000000;

        $query = Group::with('users')
            ->where('group_clg_id', $user->user_clg_id)
            ->leftJoin('new_groups', 'new_groups.ng_id', '=', 'groups.group_name')
            ->where('ng_clg_id', $user->user_clg_id)
            ->leftJoin('classes', 'classes.class_id', '=', 'groups.group_class_id')
            ->where('class_clg_id', $user->user_clg_id)
            ->leftJoin('semesters', function ($join) use ($user) {
                $join->on('semesters.semester_id', '=', 'groups.group_semester_id')->where('semesters.semester_clg_id', $user->user_clg_id);
            })
            ->leftJoin('subjects', 'subjects.subject_id', '=', 'groups.group_subject_id')
            ->where('subject_clg_id', $user->user_clg_id)
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'groups.group_section_id')
            ->where('cs_clg_id', $user->user_clg_id)
            ->leftJoin('branches', 'branches.branch_id', '=', 'groups.group_branch_id')
            ->where('branch_clg_id', $user->user_clg_id)
            ->where('group_branch_id', Session::get('branch_id'))
            ->select('groups.*', 'create_section.cs_name', 'create_section.cs_id', 'classes.class_name', 'classes.class_id', 'subjects.subject_name', 'branches.branch_name', 'new_groups.ng_name', 'new_groups.ng_id', 'semesters.semester_name', 'semesters.semester_id'); // Include semester_name in select
        // ->get();

        $count = DB::table('students')
        ->leftJoin('classes', 'classes.class_id', 'students.class_id')
        ->leftJoin('create_section', 'create_section.cs_id', 'students.section_id')
        ->leftJoin('new_groups', 'new_groups.ng_id', 'students.group_id')
        ->where('clg_id', $user->user_clg_id)
        ->where('status', '=', 1)
        ->where('branch_id', '=', Session::get('branch_id'))
        ->selectRaw('count(id) as total_students');
        if (!empty($search)) {
            $query->where('ng_name', 'like', '%' . $search . '%')
            ->orWhere('group_id', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('group_createdby', $search_by_user);
        }
        if (!empty($search_year)) {
            $query->where('group_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('group_year_id', '=', $search_year);
        }
        $restore_list = $request->restore_list;
        // if ($restore_list == 1) {
        //     $query->where('group_delete_status', '=', 1);
        // } else {
        //     $query->where('group_delete_status', '!=', 1);
        // }
        $datas = $query->orderBy('group_id', 'DESC')->paginate($pagination_number);
        // ->get();

        $group_title = NewGroupsModel::where('ng_clg_id', $user->user_clg_id)
            ->orderBy('ng_id', config('global_variables.query_sorting'))
            ->pluck('ng_name')
            ->all(); //where
        //('group_delete_status', '!=',
        // 1)->

        if (isset($request->array) && !empty($request->array)) {
            $type = isset($request->str) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
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
            } elseif ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } elseif ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('collegeViews.group.group', compact('datas','search_year', 'search', 'group_title', 'search_by_user', 'restore_list','count'));
        }
    }

    // update code by Farhad end

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        $classesAnnual = Classes::where('class_clg_id', $user->user_clg_id)
            ->where('class_type', 'Annual')
            ->get();

        $classesSemester = Classes::where('class_clg_id', $user->user_clg_id)
            ->where('class_type', 'SemesterWise')
            ->get();

        $annuals = $query = Semester::whereIn('semester_name', ['Annual 1st Year', 'Annual 2nd Year'])
            ->where('semester_clg_id', $user->user_clg_id)
            ->get();

        $semesters = $query = Semester::whereNotIN('semester_name', ['Annual 1st Year', 'Annual 2nd Year'])
            ->where('semester_clg_id', $user->user_clg_id)
            ->get();

        $subjects = Subject::where('subject_clg_id', $user->user_clg_id)->get();
        $groups = NewGroupsModel::where('ng_clg_id', $user->user_clg_id)->get();
        $semesters = Semester::where('semester_clg_id', $user->user_clg_id)
            ->whereNotIn('semester_name', ['Annual 1st Year', 'Annual 2nd Year'])
            ->get();

        return view('collegeViews.group.add_group', compact('classesAnnual', 'annuals', 'semesters', 'classesSemester', 'subjects', 'groups', 'semesters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        // dd($user, $request->all());
        DB::transaction(function () use ($request, $user) {
            $this->validate($request, [
                'group_names' => ['required', 'string', 'unique:groups,group_name,null,null,group_clg_id,' . $user->user_clg_id.',group_section_id,'.$request->section_id.',group_class_id,'.$request->class_id.',group_branch_id,' .
                    Session::get('branch_id')],

//                'group_names' => ['required', 'string','unique:groups,group_name,'.$request->group_name.',group_section_id,' . $request->section_id .',group_clg_id,'.$user->user_clg_id ],
//                'group_names' => ['required', 'string','unique:groups,group_name,null,null,group_clg_id,group_section_id' .  .'!='. $request->section_id],
                // 'group_names' => ['required', 'string', 'unique:groups,group_name,'],
            ]);
            $group = new Group();
            $group->group_clg_id = $user->user_clg_id;
            $group->group_branch_id = Session::get('branch_id');
            $group->group_class_id = $request->class_id;
            $group->group_section_id = $request->section_id;
            $group->group_name = $request->group_names;
            $group->group_discipline = $request->discipline;
            $group->group_semester_id = $request->semester_id;
            $group->group_subject_id = implode(',', $request->subject);
            $group->group_created_by = $user->user_id;
            $group->group_browser_info = $this->getBrwsrInfo();
            $group->group_ip_address = $this->getIp();
            $group->group_year_id = $this->getYearEndId();
            $group->save();

            foreach ($request->subject as $items) {
                $grou_items = new GroupItems();
                $grou_items->grpi_grp_id = $group->group_id;
                $grou_items->grpi_gn_id = $request->group_names;
                $grou_items->grpi_class_id = $request->class_id;
                $grou_items->grpi_section_id = $request->section_id;
                $grou_items->grpi_semester_id = $request->semester_id;
                $grou_items->grpi_subject_id = $items;
                $grou_items->save();
            }
        });
        return redirect()
            ->route('college_group_list')
            ->with('success', 'Saved Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        $classesAnnual = Classes::where('class_clg_id', $user->user_clg_id)
            ->where('class_type', 'Annual')
            ->get();

        $classesSemester = Classes::where('class_clg_id', $user->user_clg_id)
            ->where('class_type', 'SemesterWise')
            ->get();

        $annuals = $query = Semester::whereIn('semester_name', ['Annual 1st Year', 'Annual 2nd Year'])
            ->where('semester_clg_id', $user->user_clg_id)
            ->get();

        $semesters = $query = Semester::whereNotIN('semester_name', ['Annual 1st Year', 'Annual 2nd Year'])
            ->where('semester_clg_id', $user->user_clg_id)
            ->get();

        $subjects = Subject::where('subject_clg_id', $user->user_clg_id)->get();
        $groups = NewGroupsModel::where('ng_clg_id', $user->user_clg_id)->get();
        $semesters = Semester::where('semester_clg_id', $user->user_clg_id)
            ->whereNotIn('semester_name', ['Annual 1st Year', 'Annual 2nd Year'])
            ->get();
        return view('collegeViews.group.edit_group', compact('request', 'classesAnnual', 'classesSemester', 'subjects', 'groups', 'semesters', 'annuals', 'semesters'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        // dd($user, $request->all());
        // DB::transaction(function () use ($request, $user) {
        //     $this->validate($request, [
        //         'group_names' => ['required', 'string', 'unique:groups,group_name,' . $request->group_id . ',group_id' . ',group_clg_id,' . $user->user_clg_id],
        //     ]);
        $group = Group::find($request->group_id);
        $group->group_clg_id = $user->user_clg_id;
        $group->group_branch_id = Session::get('branch_id');
        $group->group_class_id = $request->class_id;
        $group->group_section_id = $request->section_id;
        $group->group_name = $request->group_names;
        $group->group_discipline = $request->discipline;
        $group->group_semester_id = $request->semester_id;
        $group->group_subject_id = implode(',', $request->subject);
        $group->group_created_by = $user->user_id;
        $group->group_browser_info = $this->getBrwsrInfo();
        $group->group_ip_address = $this->getIp();
        $group->save();

        GroupItems::where('grpi_grp_id', $group->group_id)->delete();

        foreach ($request->subject as $items) {
            $grou_items = new GroupItems();
            $grou_items->grpi_grp_id = $group->group_id;
            $grou_items->grpi_gn_id = $request->group_names;
            $grou_items->grpi_class_id = $request->class_id;
            $grou_items->grpi_section_id = $request->section_id;
            $grou_items->grpi_semester_id = $request->semester_id;
            $grou_items->grpi_subject_id = $items;
            $grou_items->save();
        }

        return redirect()
            ->route('college_group_list')
            ->with('success', 'Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        //
    }

    public function create_group()
    {
        return view('collegeViews.group.create_group');
    }

    public function store_new_group(Request $request)
    {
        $user = Auth::user();
        // dd($user, $request->all());
        DB::transaction(function () use ($request, $user) {
            $this->validate($request, [
                'name' => ['required', 'string', 'unique:new_groups,ng_name,null,null,ng_clg_id,' . $user->user_clg_id],
                // 'group_names' => ['required', 'string', 'unique:groups,group_name,'],
            ]);
            $group = new NewGroupsModel();
            $group = $this->assignValue($request, $group);
            $group->save();
        });
        return redirect()
            ->back()
            ->with('success', 'Saved Successfully');
    }

    public function assignValue($request, $group)
    {
        $user = Auth::user();
        $group->ng_clg_id = $user->user_clg_id;
        $group->ng_branch_id = Session::get('branch_id');
        $group->ng_name = $request->name;
        $group->ng_created_by = $user->user_id;
        $group->ng_brwsr_info = $this->getBrwsrInfo();
        $group->ng_ip_adrs = $this->getIp();
        $group->ng_year_id = $this->getYearEndId();
        return $group;
    }

    public function new_group_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = !isset($request->search) && empty($request->search) ? (!empty($ar) ? $ar[1]->{'value'} : '') : $request->search;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $search_by_user = isset($request->search_by_user) && !empty($request->search_by_user) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.college.information_pdf.group_list';
        $pge_title = 'Region List';
        $srch_fltr = [];
        array_push($srch_fltr, $search,$search_year);

        $pagination_number = empty($ar) ? 30 : 100000000;

        $query = NewGroupsModel::leftJoin('financials_users as user', 'user.user_id', '=', 'new_groups.ng_created_by')
            ->where('ng_clg_id', $user->user_clg_id)
            ->leftJoin('branches', 'branches.branch_id', '=', 'new_groups.ng_branch_id');
        // dd($query);
        if (!empty($search)) {
            $query->where('ng_name', 'like', '%' . $search . '%')->orWhere('ng_id', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('ng_created_by', $search_by_user);
        }
        if (!empty($search_year)) {
            $query->where('ng_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('ng_year_id', '=', $search_year);
        }

        $datas = $query->orderBy('ng_id', 'DESC')->paginate($pagination_number);
        // ->get();

        $groups_title = NewGroupsModel::where('ng_clg_id', $user->user_clg_id)
            ->orderBy('ng_id', config('global_variables.query_sorting'))
            ->pluck('ng_name')
            ->all(); //where('ng_delete_status',
        // '!=', 1)->

        if (isset($request->array) && !empty($request->array)) {
            $type = isset($request->str) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
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
            } elseif ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } elseif ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }
        } else {
            return view('collegeViews.group.new_group_list', compact('datas','search_year', 'search', 'groups_title', 'search_by_user'));
        }
    }

    public function edit_new_group(Request $request)
    {
        //        $count = NewGroupsModel::where('class_degree_id', $request->group_id)->count();
        //        if($count == 0){
        return view('collegeViews.group.edit_new_group', compact('request'));
        //        }else{
        //            return redirect()->back()->with('fail' , 'Degree Already used You cannot edit this degree !');
        //        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_new_group(Request $request)
    {
        $user = Auth::user();

        DB::transaction(function () use ($request, $user) {
            $validated = $request->validate([
                'name' => ['required', 'string', 'unique:new_groups,ng_name,' . $request->group_id . ',ng_id' . ',ng_clg_id,' . $user->user_clg_id],
            ]);
            $Update_group = NewGroupsModel::where('ng_id', $request->group_id)->first();
            $Update_group = $this->assignValue($request, $Update_group);
            $Update_group->ng_updated_at = Carbon::now();
            $Update_group->save();
        });
        return redirect()
            ->route('new_group_list')
            ->with('success' . 'Updated Successfully!');
    }
}
