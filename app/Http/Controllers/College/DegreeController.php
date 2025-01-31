<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Models\College\Classes;
use App\Models\College\Degree;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class DegreeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $user = Auth::user();
    //     dd($user);
    //     $datas = Degree::with('users')->where('degree_clg_id', $user->user_clg_id)->get();
    //     return view('collegeViews/degree/degree_list', compact('datas'));
    // }

    // update code by farhad gul start
    public function index(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $prnt_page_dir = 'print.college.information_pdf.degree_list';
        $pge_title = 'Degree List';
        $srch_fltr = [];
        array_push($srch_fltr, $search,$search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = Degree::with('users')->where('degree_clg_id', $user->user_clg_id)
        ->leftJoin('branches','branches.branch_id','=','degrees.degree_branch_id');
        // dd($query);
        if (!empty($search)) {
            $query->where('degree_name', 'like', '%' . $search . '%')
                ->orWhere('degree_id', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {

            $query->where('degree_createdby', $search_by_user);
        }
        if (!empty($search_year)) {
            $query->where('degree_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('degree_year_id', '=', $search_year);
        }
        $restore_list = $request->restore_list;
        // if ($restore_list == 1) {
        //     $query->where('degree_delete_status', '=', 1);
        // } else {
        //     $query->where('degree_delete_status', '!=', 1);
        // }
        $datas = $query->orderBy('degree_id', 'DESC')
            ->paginate($pagination_number);
        // ->get();

        $degree_title = Degree::where('degree_clg_id', $user->user_clg_id)->orderBy('degree_id', config('global_variables.query_sorting'))->pluck('degree_name')->all(); //where('degree_delete_status', '!=', 1)->


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
            return view('collegeViews.degree.degree_list', compact('datas', 'search', 'degree_title','search_year', 'search_by_user', 'restore_list'));
        }
    }

    // update code by Farhad end

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('collegeViews.degree.add_degree');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        //        dd($user,$request->all());
        DB::transaction(function () use ($request, $user) {
            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->getIp();

            $validated = $request->validate([
                'degree_name' => ['required', 'string', 'unique:degrees,degree_name,null,null,degree_clg_id,' . $user->user_clg_id],
                // 'degree_name' => ['required', 'string', 'unique:degrees,degree_name,NULL,degree_id,degree_clg_id,' . $user->user_clg_id],
            ]);


            $degree = new Degree();
            $degree->degree_name = $request->degree_name;
            $degree->degree_clg_id = $user->user_clg_id;
            $degree->degree_branch_id = Session::get('branch_id');
            $degree->degree_brwsr_info = $brwsr_rslt;
            $degree->degree_ip_adrs = $clientIP;
            $degree->degree_created_by = $user->user_id;
            $degree->degree_year_id = $this->getYearEndId();
            $degree->save();
        });
        //        dd($request->all());
        return redirect()->route('degree_list')->with('success' . 'Saved Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Degree $degree)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
       $count = Classes::where('class_degree_id', $request->degree_id)->count();
       if($count == 0){
           return view('collegeViews.degree.edit_degree', compact('request'));
       }else{
        return redirect()->back()->with('fail' , 'Degree Already used You cannot edit this degree !');
       }
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
                // 'degree_name' => ['required', 'string', 'unique:degrees,degree_name,' . $request->degree_id . ',degree_id,degree_clg_id,' . $user->user_clg_id],
                // 'degree_name' => ['required', 'string', 'unique:degrees,degree_name,' . $degree->degree_id . ',degree_id'],
                'degree_name' => ['required', 'string', 'unique:degrees,degree_name,' . $request->degree_id . ',degree_id' . ',degree_clg_id,' . $user->user_clg_id],
            ]);
            $Update_degree = Degree::find($request->degree_id);
            $Update_degree->degree_name = $request->degree_name;
            $Update_degree->degree_clg_id = $user->user_clg_id;
            $Update_degree->degree_branch_id = Session::get('branch_id');
            $Update_degree->degree_brwsr_info = $brwsr_rslt;
            $Update_degree->degree_ip_adrs = $clientIP;
            $Update_degree->degree_created_by = $user->user_id;
            $Update_degree->degree_updated_at = Carbon::now();
            $Update_degree->save();
        });
        //        dd($request->all());
        return redirect()->route('degree_list')->with('success' . 'Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Degree $degree)
    {
        //
    }
}
