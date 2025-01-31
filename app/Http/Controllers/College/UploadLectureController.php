<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Models\College\Classes;
use App\Models\College\Group;
use App\Models\College\Lecture;
use App\Models\College\NewGroupsModel;
use App\Models\College\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use PDF;

class UploadLectureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $array = null, $str = null)
    {

        $user = Auth::user();
        $classes = Classes::where('class_clg_id', Auth::user()->user_clg_id)->get();
        $groups = NewGroupsModel::where('ng_clg_id', Auth::user()->user_clg_id)->select('ng_id','ng_name')->get();
        $subjects = Subject::where('subject_clg_id', Auth::user()->user_clg_id)->get();

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_class = (!isset($request->class) && empty($request->class)) ? ((!empty($ar) && isset($ar[2])) ? $ar[2]->{'value'} : '') : $request->class;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $search_group = (!isset($request->group) && empty($request->group)) ? ((!empty($ar) && isset($ar[3])) ? $ar[3]->{'value'} : '') : $request->group;
        $search_subject = (!isset($request->subject) && empty($request->subject)) ? ((!empty($ar) && isset($ar[4])) ? $ar[4]->{'value'} : '') : $request->subject;

        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.college.upload_lecture.upload_lecture_list';
        $pge_title = 'Components List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_class, $search_group, $search_subject,$search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = Lecture::where('lec_clg_id', $user->user_clg_id)
            ->leftJoin('classes', 'classes.class_id', '=', 'lectures.lec_class_id')
            ->leftJoin('new_groups', 'new_groups.ng_id', '=', 'lectures.lec_group_id')
            ->leftJoin('subjects', 'subjects.subject_id', '=', 'lectures.lec_subject_id')
            ->leftJoin('financials_users as users', 'users.user_id', '=', 'lectures.lec_created_by');

        if (!empty($search)) {
            $query->where('lec_id', 'like', '%' . $search . '%')
                ->orWhere('lec_title', 'like', '%' . $search . '%');
        }

        if (!empty($search_class)) {

            $query->where('lec_class_id', $search_class);
        }
        if (!empty($search_group)) {

            $query->where('lec_group_id', $search_group);
        }
        if (!empty($search_subject)) {

            $query->where('lec_subject_id', $search_subject);
        }
        if (!empty($search_by_user)) {

            $query->where('sfc_created_by', $search_by_user);
        }
        if (!empty($search_year)) {
            $query->where('lec_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('lec_year_id', '=', $search_year);
        }
        $datas = $query->select('lectures.*', 'classes.class_name', 'new_groups.ng_name', 'subjects.subject_name', 'users.user_name', 'users.user_id')
            ->orderBy('lec_id', 'DESC')
            ->paginate($pagination_number);
        // ->get();

        $title = Lecture::where('lec_clg_id', $user->user_clg_id)->orderBy('lec_id', config('global_variables.query_sorting'))->pluck('lec_title')->all(); //where('group_delete_status', '!=', 1)->


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
            return view('collegeViews.upload_lecture.lecture_list', compact('datas','search_year', 'classes', 'subjects', 'groups', 'search', 'search_class', 'search_subject', 'search_group', 'title', 'search_by_user'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes = Classes::where('class_clg_id', Auth::user()->user_clg_id)->get();
        $groups = Group::where('group_clg_id', Auth::user()->user_clg_id)->get();
        $subjects = Subject::where('subject_clg_id', Auth::user()->user_clg_id)->get();

        return view('collegeViews.upload_lecture.create_lecture', compact('classes', 'subjects', 'groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $this->validate($request, [
                'class' => ['required', 'string'],
                'group' => ['required', 'string'],
                'subject' => ['required', 'string'],
                'title' => ['required', 'string'],
                'link' => ['required', 'string'],
            ]);

            $upload_lecture = new Lecture();

            $upload_lecture = $this->AssignUploadLectureValue($upload_lecture, $request);

            $upload_lecture->save();
        });

        return redirect()->back()->with('success', 'Successfully Saved');
    }


    function AssignUploadLectureValue($upload_lecture, $request)
    {

        $user = Auth::user();
        $upload_lecture->lec_class_id = $request->class;
        $upload_lecture->lec_group_id = $request->group;
        $upload_lecture->lec_subject_id = $request->subject;
        $upload_lecture->lec_title = $request->title;
        $upload_lecture->lec_link = $request->link;
        $upload_lecture->lec_created_by = $user->user_id;
        $upload_lecture->lec_clg_id = $user->user_clg_id;
        $upload_lecture->lec_branch_id = Session::get('branch_id');
        $upload_lecture->lec_created_at = Carbon::now()->toDateTimeString();
        $upload_lecture->lec_year_id = $this->getYearEndId();
        return $upload_lecture;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $classes = Classes::where('class_clg_id', Auth::user()->user_clg_id)->get();

        $groups = DB::table('groups')
            ->where('group_clg_id', Auth::user()->user_clg_id)
            ->where('group_class_id', $request->class_id)
            // ->where('group_branch_id', $branch_id)
            ->leftJoin('new_groups', 'new_groups.ng_id', '=', 'groups.group_name')
            ->groupBy('ng_id')
            ->select('groups.group_id', 'new_groups.ng_name', 'new_groups.ng_id')
            ->get();
        $subjects = Subject::where('subject_clg_id', Auth::user()->user_clg_id)->get();
        return view('collegeViews.upload_lecture.edit_lecture', compact('request', 'classes', 'subjects', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        DB::transaction(function () use ($request) {
            $this->validate($request, [
                'class' => ['required', 'string'],
                'group' => ['required', 'string'],
                'subject' => ['required', 'string'],
                'title' => ['required', 'string'],
                'link' => ['required', 'string'],
            ]);

            $upload_lecture = Lecture::where('lec_id', $request->lec_id)->first();

            $upload_lecture = $this->AssignUploadLectureValue($upload_lecture, $request);

            $upload_lecture->save();

        });

        return redirect()->route('upload_lecture_list')->with('success', 'Successfully Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
