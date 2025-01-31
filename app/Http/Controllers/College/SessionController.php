<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Models\College\Semester;
use App\Models\College\SessionModel;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $array = null, $str = null)

    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $prnt_page_dir = 'print.college.information_pdf.session_list';
        $pge_title = 'Session List';
        $srch_fltr = [];
        array_push($srch_fltr, $search,$search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;
        $query = SessionModel::with('users')->where('session_clg_id', $user->user_clg_id)
            ->leftJoin('branches', 'branches.branch_id', '=', 'sessions.session_branch_id');
        if (!empty($search)) {
            $query->where('session_name', 'like', '%' . $search . '%')
                ->orWhere('session_id', 'like', '%' . $search . '%');
        }
        if (!empty($search_by_user)) {
            $query->where('session_created_by', $search_by_user);
        }
        if (!empty($search_year)) {
            $query->where('session_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('session_year_id', '=', $search_year);
        }
        $restore_list = $request->restore_list;
        $datas = $query->orderBy('session_id', 'ASC')
            ->paginate($pagination_number);

        $session_title = SessionModel::where('session_clg_id', $user->user_clg_id)->orderBy('session_id', config('global_variables.query_sorting'))->pluck('session_name')->all(); //where('session_delete_status', '!=', 1)->


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
        } else
            return view('collegeViews.session.session_list', compact('datas', 'search_year','search', 'session_title', 'search_by_user'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('collegeViews.session.add_session');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $user = Auth::user();
        DB::transaction(function () use ($request, $user) {
            $start = date('Y-m-d', strtotime($request->start_date));
            $end = date('Y-m-d', strtotime($request->end_date));
            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->getIp();

            $validated = $request->validate([
                'session_name' => ['required', 'string', 'unique:sessions,session_name,NULL,session_id,session_clg_id,' . $user->user_clg_id],
            ]);
            $session = new SessionModel();
            $session->session_name = $request->session_name;
            // $session->session_start_date = $start;
            $session->session_branch_id = Session::get('branch_id');
            $session->session_clg_id = $user->user_clg_id;
            $session->session_brwsr_info = $brwsr_rslt;
            $session->session_ip_adrs = $clientIP;
            $session->session_created_by = $user->user_id;
            $session->session_year_id = $this->getYearEndId();;
            $session->save();
        });

        return redirect()->route('session_list')->with('success' . 'Save Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(SessionModel $session)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        // dd($request->all());
        return view('collegeViews.session.edit_session', compact('request'));
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
            $start = date('Y-m-d', strtotime($request->start_date));
            $end = date('Y-m-d', strtotime($request->end_date));

            $validated = $request->validate([
                // 'session_name' => ['required', 'string', 'unique:session,session_name,' . $request->session_id . ',semester_id'],
                'session_name' => ['required', 'string', 'unique:sessions,session_name,' . $request->session_id . ',session_id' . ',session_clg_id,' . $user->user_clg_id],

            ]);
            // dd($request->all());
            $session = SessionModel::find($request->session_id);
            $session->session_name = $request->session_name;
            // $session->session_start_date = $start;
            $session->session_branch_id = Session::get('branch_id');
            $session->session_clg_id = $user->user_clg_id;
            $session->session_brwsr_info = $brwsr_rslt;
            $session->session_ip_adrs = $clientIP;
            $session->session_created_by = $user->user_id;
            $session->session_updated_at = Carbon::now();
            $session->save();
        });
        //        dd($request->all());
        return redirect()->route('session_list')->with('success' . 'Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SessionModel $session)
    {
        //
    }
}
