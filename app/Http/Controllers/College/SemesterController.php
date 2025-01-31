<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Models\College\Degree;
use App\Models\College\Semester;
use PDF;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // update code by shahzaib start
    public function index(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.college.information_pdf.semester_list';
        $pge_title = 'Semester List';
        $srch_fltr = [];
        array_push($srch_fltr, $search,$search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        //  $query = DB::table('financials_semesterion')
        //      ->leftJoin('financials_users', 'financials_users.user_id', 'financials_semesterion.semester_createdby')
        //      ->where('semester_clg_id',$user->user_clg_id);
        $query = Semester::with('users')->where('semester_clg_id', $user->user_clg_id)
        ->whereNotIn('semester_name',['Annual 1st Year', 'Annual 2nd Year'])
        ->leftJoin('branches','branches.branch_id','=','semesters.semester_branch_id');
        if (!empty($search)) {
            $query->where('semester_name', 'like', '%' . $search . '%')
                ->orWhere('semester_id', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('semester_created_by', $search_by_user);
        }
        if (!empty($search_year)) {
            $query->where('semester_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('semester_year_id', '=', $search_year);
        }

        $restore_list = $request->restore_list;
        //  if ($restore_list == 1) {
        //      $query->where('semester_delete_status', '=', 1);
        //  } else {
        //      $query->where('semester_delete_status', '!=', 1);
        //  }

        $datas = $query->orderBy('semester_id', 'DESC')
            ->paginate($pagination_number);

        $semester_title = Semester::where('semester_clg_id', $user->user_clg_id)->whereNotIn('semester_name',['Annual 1st Year', 'Annual 2nd Year'])->orderBy('semester_id', config('global_variables.query_sorting'))->pluck('semester_name')->all(); //where('semester_delete_status', '!=', 1)->


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
            // dd($datas);
            return view('collegeViews.semester.semester_list', compact('datas','search_year', 'search', 'semester_title', 'search_by_user'));
        }
    }
    // public function index()
    // {
    //     $user = Auth::user();

    //     $datas = Semester::with('users')->where('semester_clg_id',$user->clg_id)->get();


    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('collegeViews/semester/add_semester');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        DB::transaction(function () use ($request, $user) {
            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->getIp();

            $validated = $request->validate([
                'semester_name' => ['required', 'string', 'unique:semesters,semester_name,null,null,semester_clg_id,' . $user->user_clg_id],
                // 'semester_name' => ['required', 'string', 'unique:semesters,semester_name,NULL,semester_id,semester_clg_id,' . $user->clg_id],
            ]);


            $semester = new Semester();
            $semester->semester_name = $request->semester_name;
            $semester->semester_clg_id = $user->user_clg_id;
            $semester->semester_branch_id = Session::get('branch_id');
            $semester->semester_brwsr_info = $brwsr_rslt;
            $semester->semester_ip_adrs = $clientIP;
            $semester->semester_created_by = $user->user_id;
            $semester->semester_year_id = $this->getYearEndId();
            $semester->save();
        });
        return redirect()->route('semester_list')->with('success' , 'Saved Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Semester $semester)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
         if($request->title == 'Annual 1st Year' || $request->title == 'Annual 2nd Year' ){
             return redirect()->route('semester_list')->with('fail' , 'Your Are not Update first two rows!');
         }
        return view('collegeViews.semester.edit_semester', compact('request'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // dd($request->all(), $semester->all());
        $user = Auth::user();
        DB::transaction(function () use ($request, $user) {
            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->getIp();

            $validated = $request->validate([
                'semester_name' => ['required', 'string', 'unique:semesters,semester_name,' . $request->semester_id . ',semester_id,semester_clg_id,'. $user->user_clg_id],

            ]);
            $semester = Semester::where('semester_id', $request->semester_id)->first();
            $semester->semester_name = $request->semester_name;
            $semester->semester_clg_id = $user->user_clg_id;
            $semester->semester_branch_id = Session::get('branch_id');
            $semester->semester_brwsr_info = $brwsr_rslt;
            $semester->semester_ip_adrs = $clientIP;
            $semester->semester_created_by = $user->user_id;
            $semester->semester_updated_at = Carbon::now();
            $semester->save();
        });
        //        dd($request->all());
        return redirect()->route('semester_list')->with('success' , 'Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Semester $semester)
    {
        //
    }
}
