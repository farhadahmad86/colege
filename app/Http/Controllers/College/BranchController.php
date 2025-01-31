<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Models\College\Branch;
use App\Models\College\College;
use PDF;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class BranchController extends Controller
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
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->year;
        $prnt_page_dir = 'print.college.information_pdf.branch_list';
        $pge_title = 'Branch List';
        $srch_fltr = [];
        array_push($srch_fltr, $search,$search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        //  $query = DB::table('financials_semesterion')
        //      ->leftJoin('financials_users', 'financials_users.user_id', 'financials_semesterion.branch_createdby')
        //      ->where('branch_clg_id',$user->user_clg_id);
        $query = Branch::with('users')->where('branch_clg_id', $user->user_clg_id);
        if (!empty($search)) {
            $query->where('branch_name', 'like', '%' . $search . '%')
                ->orWhere('branch_id', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('branch_created_by', $search_by_user);
        }
        if (!empty($search_year)) {
            $query->where('branch_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('branch_year_id', '=', $search_year);
        }

        $restore_list = $request->restore_list;
        //  if ($restore_list == 1) {
        //      $query->where('branch_delete_status', '=', 1);
        //  } else {
        //      $query->where('branch_delete_status', '!=', 1);
        //  }

        $datas = $query->orderBy('branch_id', 'ASC')
            ->paginate($pagination_number);

        $branch_title = Branch::where('branch_clg_id', $user->user_clg_id)->orderBy('branch_id', config('global_variables.query_sorting'))->pluck('branch_name')->all(); //where('branch_delete_status', '!=', 1)->


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
            return view('collegeViews.branch.branch_list', compact('datas','search_year', 'search', 'branch_title', 'search_by_user'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user()->user_clg_id;
        $college = College::where('clg_id', $user)->pluck('clg_branch_limit')->first();
        $branch = Branch::where('branch_clg_id', $user)->count();
        $branch_no= $branch ;
        if ($branch < $college) {
            return view('collegeViews.branch.add_branch', compact('branch_no'));
        }
        return redirect()->back()->with('fail', 'Your Branch out of Limit Contact to your Softgics for more Branches');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //        dd($request->all());
        $user = Auth::user();
        //        try {


        DB::transaction(function () use ($request, $user) {
            $validated = $request->validate([
                'branch_name' => ['required', 'string', 'unique:branches,branch_name,NULL,id,branch_clg_id,' . $user->user_clg_id],
                'contact' => ['required', 'string'],
                'address' => ['required', 'string'],
            ]);
            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->getIp();
            $year_id = $this->getYearEndId();
            $branch = new Branch();
            $branch->branch_name = $request->branch_name;
            $branch->branch_clg_id = $user->user_clg_id;
            $branch->branch_contact = $request->contact;
            $branch->branch_no = $request->branch_no;
            $branch->branch_contact2 = $request->contact2;
            $branch->branch_address = $request->address;
            $branch->branch_type = 'Branch';
            $branch->branch_brwsr_info = $brwsr_rslt;
            $branch->branch_ip_adrs = $clientIP;
            $branch->branch_user_id = $user->user_id;
            $branch->branch_year_id = $year_id;
            $branch->save();
        });
        return redirect()->route('branch_list')->with('success' . 'Saved Successfully!');
        //        }
        //        catch (\Exception $e){
        //            $error = $e->getMessage();
        ////            return  redirect()->back();
        //        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        return view('collegeViews.branch.edit_branch', compact('request'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        DB::transaction(function () use ($request, $user) {
            $validated = $request->validate([
                //                'branch' => ['required', 'string', 'unique:branches,branch_name,' . $request->branch_id . ',branch_id'],
                'branch' => ['required', 'string', 'unique:branches,branch_name,' . $request->branch_id . ',branch_id,branch_clg_id,' . $user->user_clg_id],
                'contact' => ['required', 'string'],
                'address' => ['required', 'string'],
            ]);

            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->getIp();
            $branch = Branch::where('branch_id', $request->branch_id)->first();
            $branch->branch_name = $request->branch;
            $branch->branch_clg_id = $user->user_clg_id;
            $branch->branch_contact = $request->contact;
            $branch->branch_contact2 = $request->contact2;
            $branch->branch_address = $request->address;
            $branch->branch_brwsr_info = $brwsr_rslt;
            $branch->branch_ip_adrs = $clientIP;
            $branch->branch_user_id = $user->user_id;
            $branch->save();
        });
        return redirect()->route('branch_list')->with('success' . 'Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        //
    }
}
