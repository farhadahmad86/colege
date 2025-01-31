<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Models\College\Degree;
use App\Models\College\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use PDF;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.college.information_pdf.program_list';
        $pge_title = 'Program List';
        $srch_fltr = [];
        array_push($srch_fltr, $search,$search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = Program::where('program_clg_id', $user->user_clg_id)
            ->leftJoin('degrees', 'degrees.degree_id', '=', 'programs.program_degree_id')
            ->leftJoin('branches','branches.branch_id','=','programs.program_branch_id');
        // dd($query);
        if (!empty($search)) {
            $query->where('program_name', 'like', '%' . $search . '%')
                ->orWhere('program_id', 'like', '%' . $search . '%');
        }

        if (!empty($search_year)) {
            $query->where('program_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('program_year_id', '=', $search_year);
        }
        if (!empty($search_by_user)) {

            $query->where('program_createdby', $search_by_user);
        }

        $restore_list = $request->restore_list;
        // if ($restore_list == 1) {
        //     $query->where('program_delete_status', '=', 1);
        // } else {
        //     $query->where('program_delete_status', '!=', 1);
        // }
        $datas = $query->select('programs.program_name', 'programs.program_id', 'degrees.degree_name', 'degrees.degree_id','branches.branch_id','branches.branch_name')->orderBy('program_id', 'DESC')
            ->paginate($pagination_number);
        // ->get();

        $program_title = Program::where('program_clg_id', $user->user_clg_id)->orderBy('program_id', config('global_variables.query_sorting'))->pluck('program_name')->all(); //where('program_delete_status', '!=', 1)->


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
            return view('collegeViews.program.program_list', compact('datas', 'search', 'program_title','search_year', 'search_by_user', 'restore_list', 'user'));
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();

        $degree = Degree::where('degree_clg_id', $user->user_clg_id)->get();
        return view('collegeViews.program.add_program', compact('degree'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        //        dd($user,$request->all());
        DB::transaction(function () use ($request, $user) {
            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->getIp();

            $validated = $request->validate([
                'program_name' => ['required', 'string', 'unique:programs,program_name,null,null,program_clg_id,' . $user->user_clg_id],
                // 'program_name' => ['required', 'string', 'unique:degrees,degree_name,NULL,degree_id,degree_clg_id,' . $user->user_clg_id],
            ]);
            $program = new Program();
            $program->program_name = $request->program_name;
            $program->program_clg_id = $user->user_clg_id;
            $program->program_branch_id = Session::get('branch_id');
            $program->program_degree_id = $request->degree;
            $program->program_brwsr_info = $brwsr_rslt;
            $program->program_ip_adrs = $clientIP;
            $program->program_created_by = $user->user_id;
            $program->program_year_id = $this->getYearEndId();
            $program->save();
        });
        return redirect()->route('program_list')->with('success' . 'Saved Successfully!');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        $degree = Degree::where('degree_clg_id', $user->user_clg_id)->where('degree_id', $request->degree_id)->get();
        return view('collegeViews.program.edit_program', compact('request','degree'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        DB::transaction(function () use ($request, $user) {
            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->getIp();

            $validated = $request->validate([
                'program_name' => ['required', 'string', 'unique:programs,program_name,' . $request->program_name . ',program_id,program_clg_id,' . $user->user_clg_id],

            ]);
            $program = Program::where('program_id', $request->program_id)->first();
            $program->program_name = $request->program_name;
            $program->program_clg_id = $user->user_clg_id;
            $program->program_branch_id = Session::get('branch_id');
            $program->program_degree_id = $request->degree;
            $program->program_brwsr_info = $brwsr_rslt;
            $program->program_ip_adrs = $clientIP;
            $program->program_created_by = $user->user_id;
            $program->save();
        });
        //        dd($request->all());
        return redirect()->route('program_list')->with('success' . 'Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
