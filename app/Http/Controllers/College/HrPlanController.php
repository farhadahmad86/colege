<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Models\College\HrPlan;
use App\Models\User;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class HrPlanController extends Controller
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
    //     $hr_plans = HrPlan::with('users')->get();

    //     return view('collegeViews.hr_plan.hr_plan_list', compact('hr_plans'));
    // }
    public function index(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.college.information_pdf.hrplane_list';
        $pge_title = 'HrPlane List';
        $srch_fltr = [];
        array_push($srch_fltr, $search,$search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = HrPlan::with('users')->where('hr_plan_clg_id', $user->user_clg_id)
        ->leftJoin('branches','branches.branch_id','=','hr_plans.hr_plan_branch_id');
        // dd($query);
        if (!empty($search)) {
            $query->where('hr_plan_name', 'like', '%' . $search . '%')
                ->orWhere('hr_plan_id', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {

            $query->where('hr_plan_createdby', $search_by_user);
        }
        if (!empty($search_year)) {
            $query->where('hr_plan_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('hr_plan_year_id', '=', $search_year);
        }

        $restore_list = $request->restore_list;
        // if ($restore_list == 1) {
        //     $query->where('hr_plan_delete_status', '=', 1);
        // } else {
        //     $query->where('hr_plan_delete_status', '!=', 1);
        // }
        $datas = $query->orderBy('hr_plan_id', 'DESC')
            ->paginate($pagination_number);
        // ->get();

        $hr_plan_title = HrPlan::where('hr_plan_clg_id', $user->user_clg_id)->orderBy('hr_plan_id', config('global_variables.query_sorting'))->pluck('hr_plan_name')->all(); //where('hr_plan_delete_status', '!=', 1)->


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
            return view('collegeViews.hr_plan.hr_plan_list', compact('datas', 'search_year','search', 'hr_plan_title', 'search_by_user', 'restore_list'));
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('collegeViews.hr_plan.add_hr_plan');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // dd($request->all());
        $validated = $request->validate([
            'hr_plan_name' => ['required', 'string', 'unique:hr_plans,hr_plan_name,null,null,hr_plan_clg_id,' . $user->user_clg_id],
            'hr_plan_extra_leave' => ['nullable', 'string'],
            'hr_plan_causual_leave' => ['nullable', 'string'],
            'hr_plan_short_leave' => ['nullable', 'string'],
            'hr_plan_half_leave' => ['nullable', 'string'],
            'hr_plan_description' => ['nullable', 'string'],
        ]);

        $hr_plan = new HrPlan();
        $hr_plan->hr_plan_clg_id = $user->user_clg_id;
        $hr_plan->hr_plan_branch_id = Session::get('branch_id');
        $hr_plan->hr_plan_name = $request->hr_plan_name;
        $hr_plan->hr_plan_created_by = $user->user_id;
        $hr_plan->hr_plan_extra_leave = $request->hr_plan_extra_leave;
        $hr_plan->hr_plan_causual_leave = $request->hr_plan_causual_leave;
        $hr_plan->hr_plan_short_leave = $request->hr_plan_short_leave;
        $hr_plan->hr_plan_half_leave = $request->hr_plan_half_leave;
        $hr_plan->hr_plan_description = $request->hr_plan_description;
        $hr_plan->hr_plan_browser_info = $this->getBrwsrInfo();
        $hr_plan->hr_plan_ip_address = $this->getIp();
        $hr_plan->hr_plan_year_id = $this->getYearEndId();
        $hr_plan->save();

        return redirect()->route('hr_plan_list')->with('success', 'Saved Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(HrPlan $hrPlan)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        // dd($request->all());
        return view('collegeViews.hr_plan.edit_hr_plan', compact('request'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $user = Auth::user();
        // dd(Auth::user(), $request->all());
        DB::transaction(function () use ($request, $user) {

            $validated = $request->validate([
                'hr_plan_name' => ['required', 'string', 'unique:hr_plans,hr_plan_name,' . $request->hr_plan_id . ',hr_plan_id' . ',hr_plan_clg_id,' . $user->user_clg_id],
                'hr_plan_extra_leave' => ['nullable', 'string'],
                'hr_plan_causual_leave' => ['nullable', 'string'],
                'hr_plan_short_leave' => ['nullable', 'string'],
                'hr_plan_half_leave' => ['nullable', 'string'],
                'hr_plan_description' => ['nullable', 'string'],
            ]);

            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->getIp();
            $Update_hrPlan = HrPlan::find($request->hr_plan_id);
            $Update_hrPlan->hr_plan_clg_id = $user->user_clg_id;
            $Update_hrPlan->hr_plan_branch_id = Session::get('branch_id');
            $Update_hrPlan->hr_plan_name = $request->hr_plan_name;
            $Update_hrPlan->hr_plan_created_by = $user->user_id;
            $Update_hrPlan->hr_plan_extra_leave = $request->hr_plan_extra_leave;
            $Update_hrPlan->hr_plan_causual_leave = $request->hr_plan_causual_leave;
            $Update_hrPlan->hr_plan_short_leave = $request->hr_plan_short_leave;
            $Update_hrPlan->hr_plan_half_leave = $request->hr_plan_half_leave;
            $Update_hrPlan->hr_plan_description = $request->hr_plan_description;
            $Update_hrPlan->hr_plan_browser_info = $this->getBrwsrInfo();
            $Update_hrPlan->hr_plan_ip_address = $this->getIp();
            $Update_hrPlan->save();
        });

        return  redirect()->route('hr_plan_list')->with('success', 'Successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HrPlan $hrPlan)
    {
        //
    }
}
