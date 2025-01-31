<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FixedDataController;
use App\Http\Controllers\SaveImageController;
use App\Models\College\Branch;
use App\Models\College\College;
use App\Models\Utility;
use Illuminate\Support\Facades\View;
use PDF;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CollegeController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth:admin');
//
//        View::share('nav', 'dashboard'); //ss
//    }
    public function create()
    {
        if(Auth::user()->user_id ==1){
            return view('collegeViews/college/create');
        }else{
            return redirect()->back()->with('fail','You are not eligible for this screen');
        }
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->getIp();

            $validated = $request->validate([
                'name' => ['required', 'string', 'unique:colleges,clg_name,NULL,clg_id'],
                // 'branch_limit' => ['required', 'string', 'unique:colleges,clg_branch_limit,NULL,clg_id'],
            ]);

            $college = new College();
            $college->clg_name = $request->name;
            $college->clg_branch_limit = $request->branch_limit;
            $college->clg_browser_info = $brwsr_rslt;
            $college->clg_ip_address = $clientIP;
            $save_image = new SaveImageController();
            $common_path = config('global_variables.common_path');
            $college_path = config('global_variables.college_logo');
            // Handle Image
            $fileNameToStore = $save_image->SaveImage($request, 'pimage', $request->folder, $college_path . $request->name, $request->name . '_College_Logo');

            if (!empty($request->hasFile('pimage'))) {

                $college->clg_logo = $common_path . $fileNameToStore;
            } else {
                $college->clg_logo = $fileNameToStore;
            }
            $college->save();
            $branch = new Branch();
            $branch->branch_name = 'Head Office';
            $branch->branch_no = 'HO';
            $branch->branch_clg_id = $college->clg_id;
            $branch->branch_contact = '03001234567';
            $branch->branch_address = 'update super admin';
            $branch->branch_type = 'H/O';
            $branch->branch_brwsr_info = $brwsr_rslt;
            $branch->branch_ip_adrs = $clientIP;
            //            $branch->branch_user_id = 1;
            $branch->save();
            $create_fixed_data = new FixedDataController();
            //        $day_end //= $get_day_end->day_end();
            $create_fixed_data->create_fixed_data($college->clg_id, $college->clg_name,$college->clg_logo, $branch->branch_id, $branch->branch_no);
        });
        return redirect()->route('college_list')->with('success' . ' Save Successfully');
    }

    public function index(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.region_list.region_list';
        $pge_title = 'semester List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);
        $pagination_number = (empty($ar)) ? 30 : 100000000;
        //  $query = DB::table('financials_semesterion')
        //      ->leftJoin('financials_users', 'financials_users.user_id', 'financials_semesterion.branch_createdby')
        //      ->where('branch_clg_id',$user->user_clg_id);
        $query = College::query();
        if (!empty($search)) {
            $query->where('clg_name', 'like', '%' . $search . '%')
                ->orWhere('clg_id', 'like', '%' . $search . '%');
        }
        // if (!empty($search_by_user)) {
        //     $query->where('clg_created_by', $search_by_user);
        // }
        $restore_list = $request->restore_list;
        //  if ($restore_list == 1) {
        //      $query->where('branch_delete_status', '=', 1);
        //  } else {
        //      $query->where('branch_delete_status', '!=', 1);
        //  }
        $datas = $query->orderBy('clg_id', 'DESC')
            ->get();
        // dd($datas);
        $clg_title = College::where('clg_id', $user->user_clg_id)->orderBy('clg_id', config('global_variables.query_sorting'))->pluck('clg_name')->all(); //where('branch_delete_status', '!=', 1)->


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
            return view('collegeViews.college.index', compact('datas', 'search', 'clg_title', 'search_by_user'));
        }
    }
    public function edit(Request $request)
    {
        return view('collegeViews.college.edit', compact('request'));
    }

    public function update(Request $request)
    {
        $user = Auth::user()->user_clg_id;
        // dd($request->all());
        $uniqueId = Utility::uniqidReal() . mt_rand();
        $validated = $request->validate([
            //            'name' => ['required', 'string', 'unique:colleges,clg_name,NULL,clg_id'],
            'clg_name' => ['required', 'string', 'unique:colleges,clg_name,NULL,id,clg_id,' . $request->clg_id],
        ]);
        $brwsr_rslt = $this->getBrwsrInfo();
        $clientIP = $this->getIp();
        $college = College::where('clg_id', $request->clg_id)->first();
        $college->clg_name = $request->clg_name;
        $college->clg_branch_limit = $request->branch_limit;
        $college->clg_browser_info = $brwsr_rslt;
        $college->clg_ip_address = $clientIP;
        //        dd($college->clg_logo);
        //        if(File::exists(($college->clg_logo))){
        //            File::delete(public_path($college->clg_logo));
        //        }else{
        //            dd('File does not exists.');
        //        }
        if (!empty($request->pimage)) {
            //            File::delete($college->clg_logo);
            $save_image = new SaveImageController();
            $common_path = config('global_variables.common_path');
            $college_path = config('global_variables.college_logo');

            $fileNameToStore = $save_image->SaveImage($request, 'pimage', $request->folder, $college_path . $request->name, $request->name . '_' . $uniqueId);
            // Handle Image
            $college->clg_logo = $common_path . $fileNameToStore;
        }
        $college->save();
        return redirect()->route('college_list')->with('success' . 'Updated Successfully!');
    }
}
