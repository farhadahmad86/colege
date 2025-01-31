<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Models\College\TeacherLoadModel;
use App\Models\ReportConfigModel;
use App\User;
use PDF;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TeacherLoadController extends Controller
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

        $query = TeacherLoadModel::with('users')
            ->where('tl_clg_id', $user->user_clg_id)
            // ->where('tl_branch_id', Session::get('branch_id'))
            ->leftJoin('financials_users', 'financials_users.user_id', '=', 'teacher_load.tl_teacher_id')
            ->leftJoin('branches', 'branches.branch_id', '=', 'teacher_load.tl_branch_id')
            ->leftJoin('financials_report_config', 'financials_report_config.rc_id', '=', 'teacher_load.tl_fixed_amount')
            ->select('teacher_load.*', 'financials_users.user_name','financials_users.user_id', 'branches.branch_name', 'financials_report_config.rc_extra_lecture_amount', 'financials_report_config.rc_id')
        ;// ->get();
        // dd($query);
        if (!empty($search)) {
            $query->where('user_name', 'like', '%' . $search . '%')
            ->orWhere('user_id', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_teacher)) {
            $query->where('tl_teacher_id', $search_by_teacher);
        }
        if (!empty($search_year)) {
            $query->where('tl_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('tl_year_id', '=', $search_year);
        }
        $restore_list = $request->restore_list;
        // if ($restore_list == 1) {
        //     $query->where('subject_delete_status', '=', 1);
        // } else {
        //     $query->where('subject_delete_status', '!=', 1);
        // }
        $datas = $query->orderBy('tl_id', 'DESC')->paginate($pagination_number);
        // ->get();
        // dd($datas);

        $subject_title = TeacherLoadModel::with('users')
        ->leftJoin('financials_users', 'financials_users.user_id', '=', 'teacher_load.tl_teacher_id')
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
            return view('collegeViews.TeacherLoad.teacher_load_list', compact('datas', 'search_year','search', 'search_by_teacher', 'restore_list','subject_title'));
        }
    }

    public function create()
    {
        $user = Auth::User();
        $teachers = User::where('user_id', '!=', 1)
            ->where('user_mark', 1)
            ->where('user_type', '!=', 'master')
            ->get();
        $fixed_amount = ReportConfigModel::where('rc_clg_id', '=', $user->user_clg_id)->firstOrFail();
        // dd($fixed_amount);
        return view('collegeViews.TeacherLoad.add_teacher_load', compact('teachers', 'fixed_amount'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        $teacherId = $request->input('teacher_id');
        // Check if a load with the same teacher_id already exists
        $existingLoad = TeacherLoadModel::where('tl_teacher_id', $teacherId)
            ->where('tl_branch_id', Session::get('branch_id'))
            ->where('tl_clg_id', $user->user_clg_id)
            ->first();

        if ($existingLoad) {
            return redirect()
                ->route('add_teacher_load')
                ->with('success', 'Load for this teacher is already created');
        }
        DB::transaction(function () use ($request, $user) {
            $this->validate($request, [
                // 'subject_name' => ['required', 'string', 'unique:subjects,subject_name,null,null,subject_clg_id,' . $user->user_clg_id],
            ]);
            $teacher_load = new TeacherLoadModel();
            $teacher_load->tl_teacher_id = $request->teacher_id;
            $teacher_load->tl_acctual_load = $request->acctual_load;
            $teacher_load->tl_attendance_load = $request->attendance_load;
            $teacher_load->tl_appointment_load	= $request->appointment_load;
            if ($request->extra_load_amount == null) {
                $teacher_load->tl_fixed_amount = $request->fixed_amount;
            }
            $teacher_load->tl_extra_load_amount = $request->extra_load_amount;
            $teacher_load->tl_created_by = $user->user_id;
            $teacher_load->tl_clg_id = $user->user_clg_id;
            $teacher_load->tl_browser_info = $this->getBrwsrInfo();
            $teacher_load->tl_branch_id = Session::get('branch_id');
            $teacher_load->tl_ip_address = $this->getIp();
            $teacher_load->tl_year_id = $this->getYearEndId();
            $teacher_load->save();
        });
        return redirect()
            ->route('add_teacher_load')
            ->with('success', 'Saved Successfully');
    }
    public function edit(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        $teachers = User::where('user_id', '!=', 1)
            ->where('user_mark', 1)
            ->where('user_id', $request->title)
            ->where('user_type', '!=', 'master')
            ->first();
            // dd($user);
        $fixed_amount = ReportConfigModel::where('rc_clg_id', '=', $user->user_clg_id)->firstOrFail();
        return view('collegeViews.TeacherLoad.edit_teacher_load', compact('teachers', 'request', 'fixed_amount'));
    }
    public function update(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();

        DB::transaction(function () use ($request, $user) {
            $this->validate($request, [
                // 'subject_name' => ['required', 'string', 'unique:subjects,subject_name,null,null,subject_clg_id,' . $user->user_clg_id],
            ]);
            $teacher_load = TeacherLoadModel::find($request->tl_id);
            $teacher_load->tl_teacher_id = $request->teacher_id;
            $teacher_load->tl_acctual_load = $request->acctual_load;
            $teacher_load->tl_attendance_load = $request->attendance_load;
            $teacher_load->tl_appointment_load	= $request->appointment_load;
            if ($request->extra_load_amount == null) {
                $teacher_load->tl_fixed_amount = $request->fixed_amount;
            }
            if ($request->extra_load_amount != null) {
                $teacher_load->tl_fixed_amount = null;
            }
            $teacher_load->tl_extra_load_amount = $request->extra_load_amount;
            $teacher_load->tl_created_by = $user->user_id;
            $teacher_load->tl_clg_id = $user->user_clg_id;
            $teacher_load->tl_browser_info = $this->getBrwsrInfo();
            $teacher_load->tl_branch_id = Session::get('branch_id');
            $teacher_load->tl_ip_address = $this->getIp();
            $teacher_load->save();
        });
        return redirect()
            ->route('teacher_load_list')
            ->with('success', 'Updated Successfully');
    }
}
