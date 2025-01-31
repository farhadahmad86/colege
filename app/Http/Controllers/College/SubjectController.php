<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Models\College\Subject;
use App\User;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class SubjectController extends Controller
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
    //     $datas = Subject::with('colleges')->with('branches')->with('users')->where('subject_disable_enable', 1)->get();
    //     // dd($datas);
    //     return view('collegeViews.subject.subject', compact('datas'));
    // }
    public function index(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.college.information_pdf.subject_list';
        $pge_title = 'Subject List';
        $srch_fltr = [];
        array_push($srch_fltr, $search,$search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = Subject::with('users')->where('subject_clg_id', $user->user_clg_id)
        ->leftJoin('branches','branches.branch_id','=','subjects.subject_branch_id');
        // dd($query);
        if (!empty($search)) {
            $query->where('subject_name', 'like', '%' . $search . '%')
                ->orWhere('subject_id', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {

            $query->where('subject_createdby', $search_by_user);
        }
        if (!empty($search_year)) {
            $query->where('subject_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('subject_year_id', '=', $search_year);
        }
        $restore_list = $request->restore_list;
        // if ($restore_list == 1) {
        //     $query->where('subject_delete_status', '=', 1);
        // } else {
        //     $query->where('subject_delete_status', '!=', 1);
        // }
        $datas = $query->orderBy('subject_id', 'DESC')
            ->paginate($pagination_number);
        // ->get();

        $subject_title = Subject::where('subject_clg_id', $user->user_clg_id)->orderBy('subject_id', config('global_variables.query_sorting'))->pluck('subject_name')->all(); //where('subject_delete_status', '!=', 1)->


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
            return view('collegeViews.subject.subject', compact('datas', 'search_year','search', 'subject_title', 'search_by_user', 'restore_list'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = User::where('user_id', '!=', 1)
        ->where('user_mark', 1)
        ->where('user_type', '!=', 'master')
        ->get();
        return view('collegeViews.subject.add_subject',compact('teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        DB::transaction(function () use ($request, $user) {
            $this->validate($request, [
                'subject_name' => ['required', 'string', 'unique:subjects,subject_name,null,null,subject_clg_id,' . $user->user_clg_id],
            ]);
            $subject = new Subject();
            $subject->subject_name = $request->subject_name;
            $subject->subject_teacher_id = implode(',', $request->teacher);
            $subject->subject_created_by = $user->user_id;
            $subject->subject_clg_id = $user->user_clg_id;
            $subject->subject_browser_info = $this->getBrwsrInfo();
            $subject->subject_branch_id = Session::get('branch_id');
            $subject->subject_ip_address = $this->getIp();
            $subject->subject_year_id = $this->getYearEndId();
            $subject->save();
        });
        return redirect()->route('subject_list')->with('success', 'Saved Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        // dd($request->all());
        $teachers = User::where('user_id', '!=', 1)->where('user_mark', 1)->get();
        return view('collegeViews.subject.edit_subject', compact('request','teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $user = Auth::user();

        DB::transaction(function () use ($request, $user) {
            $this->validate($request, [
                'subject_name' => ['required', 'string', 'unique:subjects,subject_name,' . $request->subject_id . ',subject_id' . ',subject_clg_id,' . $user->user_clg_id],
            ]);
            $update_subject = Subject::find($request->subject_id);
            $update_subject->subject_name = $request->subject_name;
            $update_subject->subject_teacher_id = implode(',',$request->teacher);
            $update_subject->subject_created_by = $user->user_id;
            $update_subject->subject_clg_id = $user->user_clg_id;
            $update_subject->subject_branch_id = Session::get('branch_id');
            $update_subject->subject_browser_info = $this->getBrwsrInfo();
            $update_subject->subject_ip_address = $this->getIp();
            $update_subject->save();
        });
        return redirect()->route('subject_list')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        //
    }
}
