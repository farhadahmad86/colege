<?php

namespace App\Http\Controllers\College;

use Carbon\Carbon;
use Illuminate\Validation\Rule;
use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Models\College\NewGroupsModel;
use App\Models\College\Subject;
use App\Models\CourseOutline;
use PDF;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class CourseOutlineController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $subjects = Subject::where('subject_clg_id', $user->user_clg_id)->get();
        $groups = NewGroupsModel::where('ng_clg_id', $user->user_clg_id)->get();
        return view('collegeViews.course_outline.create_outine', compact('subjects', 'groups'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        DB::transaction(function () use ($request, $user) {
            $this->validate($request, [
                'subject_id' => [
                    'required'
                ],
            ]);
            $course_outline = new CourseOutline();
            $course_outline->co_clg_id = $user->user_clg_id;
            $course_outline->co_branch_id = Session::get('branch_id');
            $course_outline->co_subject_id = $request->subject_id;
            $course_outline->co_group_id = $request->subject_group;
            $course_outline->co_chp_no = $request->ch_no;
            $course_outline->co_chp_name = $request->ch_name;
            $course_outline->co_outlines = $request->outlines;
            $course_outline->co_created_by = $user->user_id;
            $course_outline->co_created_at = Carbon::now();
            $course_outline->co_lang_type = $request->urdu_type == 1 ? $request->urdu_type : 0;
            $course_outline->co_browser_info = $this->getBrwsrInfo();
            $course_outline->co_year_id = $this->getYearEndId();
            $course_outline->co_ip_address = $this->getIp();
            $course_outline->save();
        });
        return redirect()->back()->with('success', 'Saved Successfully');
    }

    public function index(Request $request, $array = null, $str = null)
    {

        $user = Auth::user();
        $branch_id = Session::get('branch_id');
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $subject_group = (!isset($request->subject_group) && empty($request->subject_group)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->subject_group;
        $prnt_page_dir = 'print.region_list.region_list';
        $pge_title = 'Region List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $subject_group);

        $pagination_number = (empty($ar)) ? 30 : 100000000;
        // $start = date('Y-m-d', strtotime($search_by_date));

        $query = DB::table('course_outlines')->where('co_clg_id', $user->user_clg_id)
            ->leftJoin('financials_users as users', 'users.user_id', '=', 'course_outlines.co_created_by')
            ->leftJoin('subjects', 'subjects.subject_id', '=', 'course_outlines.co_subject_id');
        if (!empty($search) && !empty($subject_group)) {
            $query->where('co_subject_id', 'like', '%' . $search . '%')->where('co_group_id', 'like', '%' . $subject_group . '%');
        }


        $groups = NewGroupsModel::where('ng_clg_id', $user->user_clg_id)->get();
        $datas = $query->where('co_subject_id', $search)->select('course_outlines.*', 'subjects.subject_id', 'subjects.subject_name', 'users.user_name')->orderBy('co_id', 'ASC')
            ->paginate($pagination_number);

        $subjects = Subject::where('subject_clg_id', $user->user_clg_id)->orderBy('subject_id', config('global_variables.query_sorting'))->get();

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
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title, $subject_group), $pge_title . '_x.xlsx');
            }
        } else {
            return view('collegeViews.course_outline.outline_list', compact('datas', 'search', 'subjects', 'subject_group', 'search', 'groups'));
        }
    }

    public function edit_outlines(Request $request)
    {
        $user = Auth::user();
        $outlines = CourseOutline::where('co_id', $request->co_id)->first();
        $subjects = Subject::where('subject_clg_id', $user->user_clg_id)->get();
        $groups = NewGroupsModel::where('ng_clg_id', $user->user_clg_id)->get();
        return view('collegeViews/course_outline.edit_outlines', compact('outlines', 'subjects', 'groups'));
    }

    public function update_outlines(Request $request)
    {
//        dd($request->all());
        $user = Auth::user();
        DB::transaction(function () use ($request, $user) {
            $this->validate($request, [
                // 'chp_no' => ['required'],
                // 'ch_name' => ['required'],
            ]);
            $course_outline = CourseOutline::where('co_id', $request->co_id)->first();
            $course_outline->co_clg_id = $user->user_clg_id;
            $course_outline->co_branch_id = Session::get('branch_id');
            $course_outline->co_subject_id = $request->subject_id;
            $course_outline->co_group_id = $request->subject_group;
            $course_outline->co_chp_no = $request->ch_no;
            $course_outline->co_chp_name = $request->ch_name;
            $course_outline->co_outlines = $request->outlines;
            $course_outline->co_updated_at = Carbon::now();
            $course_outline->co_created_by = $user->user_id;
            $course_outline->co_lang_type = $request->urdu_type == 1 ? $request->urdu_type : 0;
            $course_outline->co_browser_info = $this->getBrwsrInfo();
            $course_outline->co_ip_address = $this->getIp();
            $course_outline->save();
        });
        return redirect()->route('course_outline_list')->with('success', 'Update Successfully');
    }
}
