<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Models\College\Classes;
use App\Models\College\Section;
use App\Models\CreateSectionModel;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Dompdf\Cpdf;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use PDF;

class SectionController extends Controller
{
    // $user = Auth::user();
    public function create_section(Request $request)
    {
        $user = Auth::user();
        return view('collegeViews.create_section.create_section');
    }
    public function create(Request $request)
    {
        $user = Auth::user();
        $classes = Classes::where('class_clg_id', $user->user_clg_id)->where('class_id', $request->class_id)->first();
        $users = User::where('user_id', '!=', 1)->where('user_mark', 1)->get();
        $sections = CreateSectionModel::where('cs_clg_id', $user->user_clg_id)->where('cs_branch_id', Session::get('branch_id'))->get();
        return view('collegeViews.section.add_section', compact('classes', 'users', 'sections'));
    }
    public function section_list(Request $request)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.college.information_pdf.section_list';
        $pge_title = 'Section List';
        $srch_fltr = [];
        array_push($srch_fltr, $search,$search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        // dd();
        $query = CreateSectionModel::where('cs_clg_id', $user->user_clg_id)
        ->where('cs_branch_id', Session::get('branch_id'))
        ->leftJoin('branches','branches.branch_id','=','create_section.cs_branch_id');

        if (!empty($search)) {
            $query->where('cs_name',  $search);
        }
        if (!empty($search_year)) {
            $query->where('cs_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('cs_year_id', '=', $search_year);
        }
        $datas = $query->select('create_section.cs_name', 'create_section.cs_id', 'branches.branch_name')->orderBy('cs_id', 'ASC')
            ->paginate($pagination_number);

        $sections = CreateSectionModel::where('cs_clg_id', $user->user_clg_id)->orderBy('cs_id', config('global_variables.query_sorting'))->pluck('cs_name')->all(); //where('section_delete_status', '!=', 1)->


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
            return view('collegeViews.create_section.section_list', compact('datas', 'search_year','search', 'sections', 'user'));
        }
    }
    public function class_section_list($id, Request $request)
    {
        $class_id = $request->id;
        $branch_id = Session::get('branch_id');
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.region_list.region_list';
        $pge_title = 'Region List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        // dd();
        $query = Section::
            where('section_clg_id', $user->user_clg_id)
            ->where('section_branch_id', $branch_id)
            ->where('section_class_id', $request->id)
            ->leftJoin('classes', 'classes.class_id', '=', 'sections.section_class_id')
            ->leftJoin('financials_users as users', 'users.user_id', '=', 'sections.section_incharge_id')
            ->leftJoin('branches','branches.branch_id','=','sections.section_branch_id')
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'sections.section_name');

        if (!empty($search)) {
            $query->where('section_name', 'like', '%' . $search . '%')
                ->orWhere('section_id', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {

            $query->where('section_createdby', $search_by_user);
        }

        $restore_list = $request->restore_list;

        $datas = $query->select('sections.section_name', 'sections.section_id', 'classes.class_name', 'classes.class_id', 'users.user_id', 'users.user_name', 'create_section.cs_name', 'create_section.cs_id','branches.branch_name')->orderBy('section_id', 'ASC')
            ->paginate($pagination_number);

        $section_title = section::where('section_clg_id', $user->user_clg_id)->where('section_class_id', $class_id)->orderBy('section_id', config('global_variables.query_sorting'))->pluck('section_name')->all(); //where('section_delete_status', '!=', 1)->


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
            return view('collegeViews.section.section_list', compact('datas', 'class_id', 'search', 'section_title', 'search_by_user', 'restore_list', 'user'));
        }
    }
    public function section_store(Request $request)
    {
        $user = Auth::user();
        DB::transaction(function () use ($request, $user) {
            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->getIp();

            $validated = $request->validate([
                'section_name' => ['required', 'string', 'unique:create_section,cs_name,null,null,cs_clg_id,' . $user->user_clg_id],
                // 'section_name' => ['required', 'string', 'unique:degrees,degree_name,NULL,degree_id,degree_clg_id,' . $user->user_clg_id],
            ]);
            $section = new CreateSectionModel();
            $section->cs_name = $request->section_name;
            $section->cs_clg_id = $user->user_clg_id;
            $section->cs_branch_id = Session::get('branch_id');
            $section->cs_brwsr_info = $brwsr_rslt;
            $section->cs_ip_adrs = $clientIP;
            $section->cs_created_by = $user->user_id;
            $section->cs_year_id = $this->getYearEndId();
            $section->save();
        });
        return redirect()->back()->with('success' , 'Saved Successfully!');
    }
    public function store(Request $request)
    {
        $user = Auth::user();
        //    dd($request->all());
        DB::transaction(function () use ($request, $user) {
            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->getIp();

            // $validated = $request->validate([
            //     'section_name' => ['required', 'string', 'unique:sections,section_name,null,null,section_clg_id,' . $user->user_clg_id],
            //     // 'section_name' => ['required', 'string', 'unique:degrees,degree_name,NULL,degree_id,degree_clg_id,' . $user->user_clg_id],
            // ]);
            $section = new Section();
            $section->section_name = $request->section_name;
            $section->section_clg_id = $user->user_clg_id;
            $section->section_branch_id = Session::get('branch_id');
            $section->section_class_id = $request->class;
            $section->section_incharge_id = $request->class_incharge;
            $section->section_brwsr_info = $brwsr_rslt;
            $section->section_ip_adrs = $clientIP;
            $section->section_created_by = $user->user_id;
            $section->section_year_id = $this->getYearEndId();
            $section->save();
        });
        return redirect()->route('class_section_list', ['id' => $request->class])->with('success' . 'Saved Successfully!');
    }

    public function edit_section(Request $request)
    {
        $user = Auth::user();
        return view('collegeViews.create_section.edit_section', compact('request'));
    }
    public function edit(Request $request)
    {
        $user = Auth::user();
        $classId = $request->class_id;
        $class = Classes::where('class_clg_id', $user->user_clg_id)->where('class_id',  $request->class_id)->first();
        $sections =  CreateSectionModel::where('cs_clg_id', $user->user_clg_id)->get();
        $users = User::where('user_id', '!=', 1)->where('user_mark', 1)->get();
        return view('collegeViews.section.edit_section', compact('request', 'sections', 'class', 'users'));
    }

    public function update_section(Request $request)
    {
//        dd($request->all());
        $user = Auth::user();
        DB::transaction(function () use ($request, $user) {
            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->getIp();

            $validated = $request->validate([
                'cs_name' => ['required', 'string', 'unique:create_section,cs_name,' . $request->cs_id . ',cs_id' . ',cs_clg_id,' . $user->user_clg_id],
            ]);
            DB::table('create_section')->where('cs_id',  $request->cs_id)
                ->update(['cs_name' => $request->cs_name, 'cs_branch_id'=>Session::get('branch_id')]);
        });
        return redirect()->route('section_list')->with('success', 'Updated Successfully!');
    }
    public function update(Request $request)
    {


        // $user = Auth::user();
        DB::transaction(function () use ($request) {
            $section = Section::where('section_id',$request->section_id)->first();
            $section->section_name=$request->section_name;
            DB::table('sections')->where('section_id',  $request->section_id)->update(['section_name' => $request->section_name, 'section_class_id' => $request->class_id, 'section_incharge_id' => $request->class_incharge,'section_branch_id'=>Session::get('branch_id')]);
        });
        return redirect()->route('class_dashboard')->with('success' , 'Updated Successfully!');
    }


}
