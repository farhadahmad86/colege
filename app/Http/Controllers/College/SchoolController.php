<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Models\College\School;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // update code by farhad gul start
    public function index(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.print.college.information_pdf.school_list';
        $pge_title = 'Region List';
        $srch_fltr = [];
        array_push($srch_fltr, $search,$search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = School::with('users')->where('sch_clg_id', $user->user_clg_id)
        ->leftJoin('branches','branches.branch_id','=','schools.sch_branch_id');
        if (!empty($search)) {
            $query->where('sch_name', 'like', '%' . $search . '%')
                ->orWhere('sch_id', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {

            $query->where('sch_createdby', $search_by_user);
        }
        if (!empty($search_year)) {
            $query->where('sch_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('sch_year_id', '=', $search_year);
        }

        $restore_list = $request->restore_list;
        // if ($restore_list == 1) {
        //     $query->where('sch_delete_status', '=', 1);
        // } else {
        //     $query->where('sch_delete_status', '!=', 1);
        // }
        $datas = $query->orderBy('sch_id', 'DESC')
            ->paginate($pagination_number);
        // ->get();

        $sch_title = School::where('sch_clg_id', $user->user_clg_id)->orderBy('sch_id', config('global_variables.query_sorting'))->pluck('sch_name')->all(); //where('sch_delete_status', '!=', 1)->


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
            return view('collegeViews.school.school_list', compact('datas', 'search_year','search', 'sch_title', 'search_by_user', 'restore_list'));
        }
    }

    // update code by Farhad end
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('collegeViews.school.add_school');
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
                'school_name' => ['required', 'string', 'unique:schools,sch_name,null,null,sch_clg_id,' . $user->user_clg_id],
            ]);


            $school = new School();
            $school->sch_name = $request->school_name;
            $school->sch_clg_id = $user->user_clg_id;
            $school->sch_branch_id = Session::get('branch_id');
            $school->sch_brwsr_info = $brwsr_rslt;
            $school->sch_ip_adrs = $clientIP;
            $school->sch_created_by = $user->user_id;
            $school->sch_year_id = $this->getYearEndId();
            $school->save();
        });
        return redirect()->route('school_list')->with('success' . 'Saved Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(School $school)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        // dd($request->all());
        return view('collegeViews.school.edit_school', compact('request'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        DB::transaction(function () use ($request, $user) {
            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->getIp();

            $validated = $request->validate([
                'school_name' => ['required', 'string', 'unique:schools,sch_name,' . $request->sch_id . ',sch_id' . ',sch_clg_id,' . $user->user_clg_id],

            ]);
            $school = School::find($request->sch_id);
            $school->sch_name = $request->school_name;
            $school->sch_clg_id = $user->user_clg_id;
            $school->sch_branch_id = Session::get('branch_id');
            $school->sch_brwsr_info = $brwsr_rslt;
            $school->sch_ip_adrs = $clientIP;
            $school->sch_created_by = $user->user_id;
            $school->sch_updated_at = Carbon::now();
            $school->save();
        });
        //        dd($request->all());
        return redirect()->route('school_list')->with('success' . 'Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(School $school)
    {
        //
    }
}
