<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SaveImageController;
use App\Models\College\Branch;
use App\Models\College\Classes;
use App\Models\College\Inquiry;
use App\Models\College\Program;
use App\Models\College\School;
use App\Models\College\Student;
use Session;
use App\Models\User;
use App\Models\Utility;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;

// use Illuminate\Support\Facades\DB as FacadesDB;
use Maatwebsite\Excel\Facades\Excel;

class InquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $search_status = (!isset($request->search_status) && empty($request->search_status)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->search_status;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.college.inquiry_list';
        $pge_title = 'inquiry List';
        $srch_fltr = [];
        array_push($srch_fltr, $search,$search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = Inquiry::where('inq_clg_id', $user->user_clg_id)->where('inq_branch_id', Session::get('branch_id'))
            ->leftJoin('branches', 'branches.branch_id', '=', 'inquiries.inq_branch_id')
            ->leftJoin('programs', 'programs.program_id', '=', 'inquiries.inq_program_id')
            ->leftJoin('financials_users', 'financials_users.user_id', '=', 'inquiries.inq_created_by');


        if (!empty($search)) {
            $query->where('inq_full_name', 'like', '%' . $search . '%');
//                ->orWhere('inq_id', 'like', '%' . $search . '%')
//                ->orWhere('inq_full_name', 'like', '%' . $search . '%');
        }
        if (!empty($search_status)) {
            $query->whereRaw("FIND_IN_SET('$search_status', inq_status) > 0");
        }

        if (!empty($search_by_user)) {
            $query->where('branch_created_by', $search_by_user);
        }
        if (!empty($search_year)) {
            $query->where('inq_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('inq_year_id', '=', $search_year);
        }
        $datas = $query->orderBy('inq_id', 'ASC')
            ->select('inquiries.*', 'branches.branch_name', 'programs.program_name', 'financials_users.user_name as created_by')
            ->paginate($pagination_number);

        $inq_title = Inquiry::where('inq_clg_id', $user->user_clg_id)->orderBy('inq_id', config('global_variables.query_sorting'))->pluck('inq_full_name')->all(); //where('branch_delete_status', '!=', 1)->

        $branch = Branch::where('branch_clg_id', $user->user_clg_id)->where('branch_id', Session::get('branch_id'))->pluck('branch_name')->first();


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
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title', 'branch'));
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
            return view('collegeViews.inquiry.inquiry_list', compact('datas', 'search_year','search', 'inq_title', 'search_by_user','search_status'));
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $user = Auth::user();
        $schools = School::where('sch_clg_id', $user->user_clg_id)->get();
        $programs = Program::where('program_clg_id', $user->user_clg_id)->get();
        $classes = Classes::all();
        return view('collegeViews.inquiry.add_inquiry', compact('schools', 'classes', 'programs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $uniqueId = Utility::uniqidReal() . mt_rand();
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'contact' => ['required', 'string', 'min:11'],
            'gender' => ['required', 'in:Male,Female,Other'],
            'father_name' => ['required', 'string'],
            'parentContact' => ['required', 'string', 'min:11'],
            'inquiry_date' => ['required', 'string'],
            'metric_marks' => ['required', 'string'],
            'program' => ['required', 'string'],
        ]);
        $dob = date('Y-m-d', strtotime($request->dob));
        $brwsr_rslt = $this->getBrwsrInfo();
        $clientIP = $this->getIp();
        $inquiry = new Inquiry();

        $inquiry->inq_clg_id = $user->user_clg_id;
        $inquiry->inq_branch_id = Session::get('branch_id');
        $inquiry->inq_full_name = $request->full_name;
        $inquiry->inq_contact = $request->contact;
        $inquiry->inq_cnic = $request->cnic;
        $inquiry->inq_gender = $request->gender;
        $inquiry->inq_dob = $dob;
        $inquiry->inq_program_id = $request->program;
        $inquiry->inq_religion = $request->religion;
        $inquiry->inq_father_name = $request->father_name;
        $inquiry->inq_parent_contact = $request->parentContact;
        $inquiry->inq_father_cnic = $request->father_cnic;
        $inquiry->inq_inquire_date = date('Y-m-d', strtotime($request->inquiry_date));
        $inquiry->inq_reference = $request->reference;
        $inquiry->inq_code = $request->code;
        $inquiry->inq_city = $request->city;
        $inquiry->inq_status = implode(',', $request->student_type);
        $inquiry->inq_marks_10th = $request->metric_marks;
        $inquiry->inq_marks_11th = $request->first_year_marks;
        $inquiry->inq_address = $request->address;
        $inquiry->inq_school_id = $request->school;
        $inquiry->inq_created_by = $user->user_id;
        $inquiry->inq_browser_info = $brwsr_rslt;
        $inquiry->inq_ip_address = $clientIP;
        $inquiry->inq_year_id = $this->getYearEndId();

        $save_image = new SaveImageController();

        $common_path = config('global_variables.common_path');
        $inquiry_path = config('$global_variables.inquiry_path');

        // Handle Image
        $fileNameToStore = $save_image->SaveImage($request, 'pimage', $request->folder, $inquiry_path . '_' . $user->user_clg_id . '_' . $request->branch, $request->fullname . $uniqueId . $request->username);
        if (!empty($request->pimage)) {
            $inquiry->inq_profile_pic = $common_path . $fileNameToStore;
        } else {
            $inquiry->inq_profile_pic = $fileNameToStore;
        }

        $inquiry->save();
        return redirect()->route('inquiry_list')->with('success', 'Successfully saved');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inquiry $inquiry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $branch_id = Session::get('branch_id');
        $user = Auth::user();
        $inquiry = Inquiry::where('inq_id', $id)->first();
        $branches = Branch::where('branch_clg_id', $user->user_clg_id)->get();
        $schools = School::where('sch_clg_id', $user->user_clg_id)->get();
        $classes = Classes::all();
        $programs = Program::where('program_clg_id', $user->user_clg_id)->get();
        $last = Student::count();
        $year = Carbon::now()->format('Y');
        $reg_no = $year . $last + 1 . $user->user_clg_id . $branch_id;
        // dd($inquiry->all(), $branches->all(), $schools->all());
        return view('collegeViews/inquiry/inquire_to_student', compact('branches', 'schools', 'inquiry', 'classes', 'reg_no', 'programs'));
    }

    public function edit_inquiry(Request $request)
    {
        $inquiry = Inquiry::where('inq_id', $request->inq_id)->first();
        $user = Auth::user();
        $schools = School::where('sch_clg_id', $user->user_clg_id)->get();
        $programs = Program::where('program_clg_id', $user->user_clg_id)->get();

        return view('collegeViews/inquiry/edit_inquiry', compact('programs', 'schools', 'inquiry'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
//         dd($request->all());
        $user = Auth::user();
        DB::transaction(function () use ($request, $user) {
            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->getIp();

//            $validated = $request->validate([
//                'full_name' => ['required', 'string', 'unique:inquiries,inq_full_name,' . $request->inq_id . ',inq_id'],
//
//            ]);
            $inquiry = Inquiry::where('inq_id',$request->inq_id)->first();
            $inquiry->inq_clg_id = $user->user_clg_id;
            $inquiry->inq_branch_id = Session::get('branch_id');
            $inquiry->inq_full_name = $request->full_name;
            $inquiry->inq_contact = $request->contact;
            $inquiry->inq_cnic = $request->cnic;
            $inquiry->inq_gender = $request->gender;
            $inquiry->inq_dob = date('Y-m-d', strtotime($request->dob));
            $inquiry->inq_program_id = $request->program;
            $inquiry->inq_religion = $request->religion;
            $inquiry->inq_father_name = $request->father_name;
            $inquiry->inq_parent_contact = $request->parentContact;
            $inquiry->inq_father_cnic = $request->father_cnic;
            $inquiry->inq_inquire_date = date('Y-m-d', strtotime($request->inquiry_date));
            $inquiry->inq_reference = $request->reference;
            $inquiry->inq_code = $request->code;
            $inquiry->inq_city = $request->city;
            $inquiry->inq_status = implode(',', $request->student_type);
            $inquiry->inq_marks_10th = $request->metric_marks;
            $inquiry->inq_marks_11th = $request->first_year_marks;
            $inquiry->inq_address = $request->address;
            $inquiry->inq_school_id = $request->school;
            $inquiry->inq_created_by = $user->user_id;
            $inquiry->inq_browser_info = $brwsr_rslt;
            $inquiry->inq_ip_address = $clientIP;
            $inquiry->save();
        });
        //        dd($request->all());
        return redirect()->route('inquiry_list')->with('success' . 'Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inquiry $inquiry)
    {
        //
    }
}
