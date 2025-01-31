<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Models\College\AssignCoordinatorModel;
use App\Models\College\Classes;
use App\Models\College\Section;
use App\Models\Department;
use App\Models\DesignationModel;
use App\User;
use PDF;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

// farhad
class AssignCoordinatorController extends Controller
{
    public function index(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = !isset($request->search) && empty($request->search) ? (!empty($ar) ? $ar[1]->{'value'} : '') : $request->search;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $search_by_teacher = isset($request->search) && !empty($request->search) ? $request->search : '';
        $prnt_page_dir = 'print.region_list.region_list';
        $pge_title = 'Region List';
        $srch_fltr = [];
        array_push($srch_fltr, $search,$search_year);

        $pagination_number = empty($ar) ? 30 : 100000000;

        $query = AssignCoordinatorModel::with('users')
            ->where('assign_coordinator.ac_clg_id', $user->user_clg_id)
            ->leftJoin('financials_users AS coordinator_users', 'coordinator_users.user_id', '=', 'assign_coordinator.ac_coordinator_id')
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'assign_coordinator.ac_section_id')
            ->leftJoin('classes', 'classes.class_id', '=', 'assign_coordinator.ac_class_id')
            ->leftJoin('branches', 'branches.branch_id', '=', 'assign_coordinator.ac_branch_id')
            ->where('branches.branch_clg_id', $user->user_clg_id)
            ->where('assign_coordinator.ac_branch_id', Session::get('branch_id'))
            ->select('assign_coordinator.*', 'create_section.cs_name', 'create_section.cs_id','classes.class_id','classes.class_name', 'coordinator_users.user_name AS coordinator_name', 'branches.branch_name' )
        ;
            // ->get();

        // dd($query);

        if (!empty($search)) {
            $query->where('user_name', 'like', '%' . $search . '%')
            ->orWhere('user_id', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_teacher)) {
            $query->where('ac_coordinator_id', $search_by_teacher);
        }
        if (!empty($search_year)) {
            $query->where('ac_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('ac_year_id', '=', $search_year);
        }
        $restore_list = $request->restore_list;
        // if ($restore_list == 1) {
        //     $query->where('subject_delete_status', '=', 1);
        // } else {
        //     $query->where('subject_delete_status', '!=', 1);
        // }
        $datas = $query->orderBy('ac_id', 'DESC')->paginate($pagination_number);
        // ->get();
        // dd($datas);
        $desig = DesignationModel::
        where('desig_name','Coordinator')
        ->where('desig_clg_id',$user->user_clg_id)
        ->pluck('desig_id')
        ->first();
        $subject_title = AssignCoordinatorModel::with('users')
        ->leftJoin('financials_users', 'financials_users.user_id', '=', 'assign_coordinator.ac_coordinator_id')
        ->where('user_branch_id',Session::get('branch_id'))
        ->where('user_designation', '=', $desig)
        ->orderBy('user_id', config('global_variables.query_sorting'))
        ->pluck('user_name')
        ->all();

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
            return view('collegeViews.AssignCoordinator.assign_coordinator_list', compact('datas','search_year', 'search', 'search_by_teacher', 'restore_list','subject_title'));
        }
    }
    public function create(Request $request)
    {
        $user = Auth::user();
        $branch_id = Session::get('branch_id');

        $desig = DesignationModel::
        where('desig_name','Coordinator')
        ->where('desig_clg_id',$user->user_clg_id)
        ->pluck('desig_id')
        ->first();

        $allusers = User::where('user_clg_id', $user->user_clg_id)
            ->where('user_designation', '=', $desig)
            ->where('user_branch_id', $branch_id)
            ->where('user_type', '!=', 'master')
            ->get();
            // dd($allusers);
        $allclasses = Classes::where('class_clg_id', $user->user_clg_id)
            // ->where('class_branch_id', $branch_id)
            // ->select('classes.*', 'create_section.cs_name', 'create_section.cs_id')
            ->get();
            // dd($allclasses);
        // $allsections = Section::where('section_clg_id', $user->user_clg_id)
        //     ->where('section_branch_id', $branch_id)
        //     ->leftJoin('create_section', 'create_section.cs_id', '=', 'sections.section_name')
        //     ->select('sections.*', 'create_section.cs_name', 'create_section.cs_id')
        //     ->get();


        return view('collegeViews.AssignCoordinator.assign_coordinator', compact('allusers', 'allclasses'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        $coordinatorId = $request->coordinator_id;;
        // Check if a Section with the same coordinator_id already exists
        $existingTimetable = AssignCoordinatorModel::where('ac_coordinator_id', $coordinatorId)
            ->where('ac_class_id', $request->class_id)
            ->where('ac_branch_id', Session::get('branch_id'))
            ->where('ac_clg_id', $user->user_clg_id)
            ->where('ac_disable_enable', 1)
            ->first();

        if ($existingTimetable) {
            return redirect()
                ->route('assign_coordinator')
                ->with('success', 'Sections have already been assigned to this coordinator.');
        }
        $user = Auth::user();
        // dd($user, $request->all());
        DB::transaction(function () use ($request, $user) {
            $this->validate($request, [
                // 'ac_names' => ['required', 'string', 'unique:groups,group_name,null,null,group_clg_id,' . $user->user_clg_id],
                // 'group_names' => ['required', 'string', 'unique:groups,group_name,'],
            ]);
            $assign_coordinator = new AssignCoordinatorModel();
            $assign_coordinator->ac_clg_id = $user->user_clg_id;
            $assign_coordinator->ac_branch_id = Session::get('branch_id');
            $assign_coordinator->ac_coordinator_id = $request->coordinator_id;
            $assign_coordinator->ac_section_id = implode(',', $request->section_id);
            $assign_coordinator->ac_class_id = $request->class_id;
            $assign_coordinator->ac_browser_info = $this->getBrwsrInfo();
            $assign_coordinator->ac_ip_address = $this->getIp();
            $assign_coordinator->ac_created_by = $user->user_id;
            $assign_coordinator->ac_year_id = $this->getYearEndId();
            $assign_coordinator->save();
        });
        return redirect()
            ->route('assign_coordinator_list')
            ->with('success', 'Saved Successfully');
    }
    public function edit(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        $branch_id = Session::get('branch_id');

        $desig = DesignationModel::
        where('desig_name','Coordinator')
        ->where('desig_clg_id',$user->user_clg_id)
        ->pluck('desig_id')
        ->first();

        $allusers = User::where('user_clg_id', $user->user_clg_id)
            ->where('user_designation', '=', $desig)
            ->where('user_branch_id', $branch_id)
            ->where('user_type', '!=', 'master')
            ->get();
            // dd($allusers);
            $allclasses = Classes::where('class_clg_id', $user->user_clg_id)
            ->where('class_branch_id', $branch_id)
            // ->select('classes.*', 'create_section.cs_name', 'create_section.cs_id')
            ->get();
            // $selectedClassIds = explode(',',$request->class_id);
            // $selectedsectionsIds = explode(',',$request->section_id);
            $allsections = DB::table('sections')
            ->select('sections.*', 'create_section.cs_name', 'create_section.cs_id')
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'sections.section_name')
            ->where('sections.section_clg_id', $user->user_clg_id)
            ->where('sections.section_branch_id', Session::get('branch_id'))
            ->where('sections.section_class_id', $request->class_id)
            // ->whereIn('sections.section_name', $selectedsectionsIds)
            ->get();
            // dd($allsections);

        return view('collegeViews.AssignCoordinator.edit_assign_coordinator', compact('allusers','request', 'allsections','allclasses'));
    }
    public function update(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        // dd($user, $request->all());
        DB::transaction(function () use ($request, $user) {
            $this->validate($request, [
                // 'ac_names' => ['required', 'string', 'unique:groups,group_name,null,null,group_clg_id,' . $user->user_clg_id],
                // 'group_names' => ['required', 'string', 'unique:groups,group_name,'],
            ]);
            $assign_coordinator = AssignCoordinatorModel::find($request->ac_id);
            $assign_coordinator->ac_clg_id = $user->user_clg_id;
            $assign_coordinator->ac_branch_id = Session::get('branch_id');
            $assign_coordinator->ac_coordinator_id = $request->coordinator_id;
            $assign_coordinator->ac_section_id = implode(',', $request->section_id);
            $assign_coordinator->ac_class_id = $request->class_id;
            $assign_coordinator->ac_browser_info = $this->getBrwsrInfo();
            $assign_coordinator->ac_ip_address = $this->getIp();
            $assign_coordinator->ac_created_by = $user->user_id;
            $assign_coordinator->save();
        });
        return redirect()
            ->route('assign_coordinator_list')
            ->with('success', 'Saved Successfully');
    }
}
