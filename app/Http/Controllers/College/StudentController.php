<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DayEndController;
use App\Http\Controllers\SaveImageController;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\College\Branch;
use App\Models\College\ChangeStudentStatusModel;
use App\Models\College\ChangeStudentStatusReasonModel;
use App\Models\College\Classes;
use App\Models\College\ComponentModel;
use App\Models\College\CustomVoucherItemsModel;
use App\Models\College\CustomVoucherModel;
use App\Models\College\School;
use App\Models\College\Section;
use App\Models\College\Semester;
use App\Models\College\SessionModel as clgession;
use App\Models\College\StuckOffVoucherModel;
use App\Models\College\Student;
use App\Models\College\StudentBalances;
use App\Models\College\StudentInstallment;
use App\Models\College\StudentInstallmentItems;
use App\Models\College\StudentPackage;
use App\Models\College\StudentPackageItems;
use App\Models\College\StudentsPackageModel;
use App\Models\College\TransportRouteModel;
use App\Models\CreateSectionModel;
use App\Models\PostingReferenceModel;
use App\Models\TransactionModel;
use App\Models\Utility;
use PDF;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // update code by farhad gul start
    public function index(Request $request, $array = null, $str = null)
    {
        Session::forget('student_id');
        $user = Auth::user();
        $branch_id = Session::get('branch_id');
        $query_sections = CreateSectionModel::where('cs_clg_id', '=', $user->user_clg_id)->where('cs_branch_id', '=', $branch_id);
        $ar = json_decode($request->array);
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_class = (!isset($request->class) && empty($request->class)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->class;
        $search_section = (!isset($request->section) && empty($request->section)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->section;
        $search_status = (!isset($request->status) && empty($request->status)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->status;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.college.student.student_list';
        $pge_title = 'Stduent List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_class, $search_status, $search_section, $search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = Student::join('financials_users as user', 'user.user_id', '=', 'students.created_by')
            ->leftJoin('classes', 'classes.class_id', '=', 'students.class_id')
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'students.section_id')
            ->leftJoin('branches', 'branches.branch_id', '=', 'students.branch_id')
            ->where('students.clg_id', $user->user_clg_id)
            ->where('students.branch_id', $branch_id);

        if (!empty($search)) {
            $query->where('full_name', 'like', '%' . $search . '%')
                ->orWhere('registration_no', 'like', '%' . $search . '%')
                ->orWhere('cnic', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%');
        }
        if (!empty($search_class)) {
            $section = Section::where('section_clg_id', $user->user_clg_id)
                ->where('section_branch_id', $branch_id)
                ->where('section_class_id', $search_class)->pluck('section_name');
            $query_sections->whereIn('cs_id', $section);
            $query->where('students.class_id', $search_class);
        }
        if (!empty($search_status)) {
            $query->where('students.student_disable_enable', $search_status);
        }
        if (!empty($search_section)) {
            $query->where('students.section_id', $search_section);
        }

        if (!empty($search_by_user)) {

            $query->where('created_by', $search_by_user);
        }
        if (!empty($search_year)) {
            $query->where('students.year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('students.year_id', '=', $search_year);
        }
        $restore_list = $request->restore_list;
        // if ($restore_list == 1) {
        //     $query->where('delete_status', '=', 1);
        // } else {
        //     $query->where('delete_status', '!=', 1);
        // }
        $datas = $query->orderBy('id', 'DESC')
            ->select('students.*', 'user.user_id', 'user.user_name', 'classes.class_name', 'branches.branch_name', 'create_section.cs_name', 'create_section.cs_id')
            ->paginate($pagination_number);
        // ->get();

        $student_title = Student::where('clg_id', $user->user_clg_id)->orderBy('id', config('global_variables.query_sorting'))->pluck('full_name')->all(); //where('delete_status', '!=', 1)->
        $sections = $query_sections->get();
        $branch = Branch::where('branch_clg_id', $user->user_clg_id)->where('branch_id', $branch_id)->pluck('branch_name')->first();


        if (isset($request->array) && !empty($request->array)) {
            // dd($request->all(),$datas,$search_class,$search_section);
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
            return view('collegeViews.student.student_list', compact('datas', 'search_year', 'search', 'search_class', 'student_title', 'search_status', 'search_by_user', 'restore_list', 'sections', 'search_section'));
        }
    }

    // update code by Farhad end

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $schools = School::where('sch_clg_id', $user->user_clg_id)->get();
        $classes = Classes::where('class_clg_id', $user->user_clg_id)->get();
//        $reg_no=$this->get_reg_number($user);
        $routes = TransportRouteModel::where('tr_branch_id', Session::get('branch_id'))->get();
        return view('collegeViews.student.add_student', compact('schools', 'classes', 'routes'));
    }

    /**
     * Store a newly created resource in storage.
     */

    function get_reg_number($user)
    {
        $branch_id = Session::get('branch_id');
        $last = Student::where('clg_id', $user->user_clg_id)->count();
        $year = Carbon::now()->format('Y');
        $lastTwoDigits = substr($year, -2);
        $reg_no = $lastTwoDigits . $user->user_clg_id . $branch_id . $last + 1;
        return $reg_no;
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $uniqueId = Utility::uniqidReal() . mt_rand();

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
//            'reg_no' => ['required', 'string', 'unique:students,registration_no,null,null,clg_id,' . $user->user_clg_id],
            'gender' => ['required', 'in:Male,Female,Other'],
            'father_name' => ['required', 'string'],
            'admission_date' => ['required', 'string'],
            'section' => ['required', 'string'],
            'group' => ['required', 'string'],
        ]);

        $brwsr_rslt = $this->getBrwsrInfo();
        $clientIP = $this->getIp();
        $reg_no = $this->get_reg_number($user);

        $admission_date = $request->admission_date == null ? $request->admission_date : date('Y-m-d', strtotime($request->admission_date));
        $dob = $request->dob == null ? $request->dob : date('Y-m-d', strtotime($request->dob));
        $student = new Student();

        $student->clg_id = $user->user_clg_id;
        $student->branch_id = Session::get('branch_id');
        $student->full_name = $request->full_name;
        $student->registration_no = $reg_no;
        $student->email = $request->email;
        $student->show_password = 12345678;
        $student->password = Hash::make($student->show_password);
        $student->email = $request->email;
        $student->group_id = $request->group;
        $student->contact = $request->contact;
        $student->cnic = $request->cnic;
        $student->gender = $request->gender;
        $student->dob = $dob;
        $student->admission_date = $admission_date;
        $student->religion = $request->religion;
        $student->class_id = $request->class;
        $student->father_name = $request->father_name;
        $student->parent_contact = $request->parentContact;
        $student->father_cnic = $request->father_cnic;
        $student->reference = $request->reference;
        $student->section_id = $request->section;
        $student->city = $request->city;
        $student->marks_10th = $request->metric_marks;
        $student->marks_11th = $request->first_year_marks;
        $student->address = $request->address;
        $student->hostel = $request->hostel;
        $student->zakat = $request->zakat;
        $student->demand = $request->demand;
        $student->package = $request->package;
        $student->discount = $request->discount;
        $student->transport = $request->transport;
        $student->route_id = $request->route_id;
        $student->route_type = $request->route_type;
//        $student->form_pdf = $request->address;
        $student->school_id = $request->school;
        $student->created_by = $user->user_id;
        $student->browser_info = $brwsr_rslt;
        $student->ip_address = $clientIP;
        $student->year_id = $this->getYearEndId();

        $save_image = new SaveImageController();

        $common_path = config('global_variables.common_path');
        $inquiry_path = config('global_variables.inquiry_path');
        $form_pdf_path = config('global_variables.form_pdf_path');
//        $path = $request->file('file')->store('pdfs');
        // // Handle Image
        $fileNameToStore = $save_image->SaveImage($request, 'pimage', $request->folder, $inquiry_path . '_' . $user->user_clg_id . '_' . $request->branch, $request->fullname . $uniqueId . $request->username);
        if (!empty($request->pimage)) {
            $student->profile_pic = $common_path . $fileNameToStore;
        } else {
            $student->profile_pic = $fileNameToStore;
        }
        $fileNameToStorePath = $save_image->SaveImage($request, 'file', $request->folder, $form_pdf_path . '_' . $user->user_clg_id . '_' . $request->branch, $request->fullname . $uniqueId . $request->username);


        if (!empty($request->file)) {
            $student->form_pdf = $common_path . $fileNameToStorePath;
        }
//        $student->form_pdf = $form_pdf_path.$path;
        $student->save();

        // student balance table entry start

        $balances = new StudentBalances();

        $balances->sbal_account_id = '';
        $balances->sbal_student_id = $student->id;
        $balances->sbal_registration_no = $student->registration_no;

        $balances->sbal_transaction_type = 'OPENING_BALANCE';
        $balances->sbal_detail_remarks = 'OPENING_BALANCE';
        $balances->sbal_dr = 0;
        $balances->sbal_cr = 0;
        // $balances->sbal_total = $dr_balance != 0 ? $dr_balance : $cr_balance;
        $balances->sbal_total = 0;
        $balances->sbal_user_id = $user->user_id;
        $balances->sbal_clg_id = $user->user_clg_id;
        $balances->sbal_branch_id = Session::get('branch_id');

        $balances->sbal_ip_adrs = $clientIP;
        $balances->sbal_brwsr_info = $brwsr_rslt;
        $balances->sbal_update_datetime = Carbon::now()->toDateTimeString();

        $balances->save();

        return redirect()->back()->with('success', 'Successfully saved! Registration Number is: ' . $student->registration_no);
    }

    public function StudentOpeningBalancesValues($balance, $transaction_id, $account, $amount, $type, $remarks, $transaction_type, $detail_remarks, $voucher_id, $sp_id)
    {
        $user = Auth::user();

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();


        return $balance;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit_student(Request $request)
    {
        $user = Auth::user();
        $schools = School::where('sch_clg_id', $user->user_clg_id)->get();
        $classes = Classes::where('class_clg_id', $user->user_clg_id)->get();
        $reg_no = $this->get_reg_number($user);
        $routes = TransportRouteModel::where('tr_branch_id', Session::get('branch_id'))->get();
        $student = Student::where('clg_id', $user->user_clg_id)->where('id', $request->student_id)->first();
        return view('collegeViews.student.edit_student', compact('schools', 'reg_no', 'classes', 'student', 'routes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_student(Request $request)
    {
        $user = Auth::user();
        DB::transaction(function () use ($user, $request) {

            $uniqueId = Utility::uniqidReal() . mt_rand();
            $validated = $request->validate([
                'full_name' => ['required', 'string', 'max:255'],
                'gender' => ['required', 'in:Male,Female,Other'],
                'father_name' => ['required', 'string'],
                'admission_date' => ['required', 'string'],
            ]);

            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->getIp();
            $admission_date = date('Y-m-d', strtotime($request->admission_date));
            $dob = date('Y-m-d', strtotime($request->dob));

            $student = Student::where('id', $request->id)->first();

            $student->clg_id = $user->user_clg_id;
            $student->branch_id = Session::get('branch_id');
            $student->full_name = $request->full_name;
            // $student->group_id = $request->group;
            $student->contact = $request->contact;
            $student->cnic = $request->cnic;
            $student->gender = $request->gender;
            $student->dob = $dob;
            $student->admission_date = $admission_date;
            $student->religion = $request->religion;
            // $student->class_id = $request->class;
            $student->father_name = $request->father_name;
            $student->parent_contact = $request->parentContact;
            $student->father_cnic = $request->father_cnic;
            $student->reference = $request->reference;
            $student->city = $request->city;
            $student->marks_10th = $request->metric_marks;
            $student->marks_11th = $request->first_year_marks;
            $student->address = $request->address;
            $student->hostel = $request->hostel;
            $student->zakat = $request->zakat;
            $student->transport = $request->transport;
            $student->route_id = $request->route_id;
            $student->route_type = $request->route_type;
            $student->address = $request->address;
            $student->school_id = $request->school;
            $student->created_by = $user->user_id;
            $student->browser_info = $brwsr_rslt;
            $student->ip_address = $clientIP;
            $save_image = new SaveImageController();
            $common_path = config('global_variables.common_path');
            $inquiry_path = config('global_variables.inquiry_path');
            $form_pdf_path = config('global_variables.form_pdf_path');
            // // Handle Image
            $fileNameToStore = $save_image->SaveImage($request, 'pimage', $request->folder, $inquiry_path . '_' . $user->user_clg_id . '_' . $request->branch, $request->fullname . $uniqueId . $request->username);
            if (!empty($request->pimage)) {
                $student->profile_pic = $common_path . $fileNameToStore;
            } else {
                $student->profile_pic = $fileNameToStore;
            }
            $fileNameToStorePath = $save_image->SaveImage($request, 'file', $request->folder, $form_pdf_path . '_' . $user->user_clg_id . '_' . $request->branch, $request->fullname . $uniqueId . $request->username);
            if (!empty($request->file)) {
                $student->form_pdf = $common_path . $fileNameToStorePath;
            }

//            $student->form_pdf = $form_pdf_path.$path;
            $student->save();
        });
        return redirect()->route('student_dashboard')->with('success', 'Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function get_instalment_details(Request $request)
    {
        $package = StudentsPackageModel::leftJoin('semesters', 'semesters.semester_id', '=', 'students_package.sp_semester')->where('sp_id', $request->package_id)->select('students_package.*', 'semesters.semester_name')->first();
        $query = StudentInstallment::where('si_sp_id', $request->package_id);
        $semester = Semester::where('semester_id', $package->sp_semester)->first();
        $count = $query->count();
        $instalments = $query->get();
        return response()->json(['instalments' => $instalments, 'package' => $package, 'count' => $count, 'semester' => $semester]);
    }

    public function student_dashboard(Request $request, $array = null, $str = null)
    {
        Session::forget('student_id');
        $user = Auth::user();
        $branch_id = Session::get('branch_id');
        $query_sections = CreateSectionModel::where('cs_clg_id', '=', $user->user_clg_id)->where('cs_branch_id', '=', $branch_id);
        $reasons = ChangeStudentStatusReasonModel::where('cssr_clg_id', $user->user_clg_id)->get();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_class = (!isset($request->class) && empty($request->class)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->class;
        $search_section = (!isset($request->section) && empty($request->section)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->section;
        $search_status = (!isset($request->status) && empty($request->status)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->status;
        $search_roll_no = (!isset($request->roll_no) && empty($request->roll_no)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->roll_no;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.region_list.region_list';
        $pge_title = 'Region List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_class, $search_section, $search_status, $search_roll_no, $search_year);

        $pagination_number = (empty($ar)) ? 60 : 100000000;


        $query = Student::where('students.clg_id', $user->user_clg_id)
            ->leftJoin('financials_users as user', 'user.user_id', '=', 'students.created_by')
            ->leftJoin('classes', 'classes.class_id', '=', 'students.class_id')
            ->leftJoin('branches', 'branches.branch_id', '=', 'students.branch_id')
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'students.section_id')
            ->leftJoin('new_groups', 'new_groups.ng_id', '=', 'students.group_id')
            ->where('students.branch_id', $branch_id);
        if (!empty($search)) {
            $query
                ->where('registration_no', 'like', '%' . $search . '%')
                ->orWhere('full_name', 'like', '%' . $search . '%')
                ->where('students.branch_id', $branch_id);
        }
        if (!empty($search_class)) {
            $section = Section::where('section_clg_id', $user->user_clg_id)
                ->where('section_branch_id', $branch_id)
                ->where('section_class_id', $search_class)->pluck('section_name');
            $query_sections->whereIn('cs_id', $section);
            $query->where('students.class_id', $search_class);
        }
        if (!empty($search_section)) {
            $query->where('students.section_id', $search_section);
        }
        if (!empty($search_status)) {
            $query->where('students.status', $search_status);
        }
        if (!empty($search_roll_no)) {
            $query->where('students.roll_no', $search_roll_no);
        }

        if (!empty($search_by_user)) {

            $query->where('created_by', $search_by_user);
        }
        if (!empty($search_year)) {
            $query->where('students.year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('students.year_id', '=', $search_year);
        }
        $restore_list = $request->restore_list;
        // if ($restore_list == 1) {
        //     $query->where('delete_status', '=', 1);
        // } else {
        //     $query->where('delete_status', '!=', 1);
        // }
        $datas = $query->orderBy('id', 'DESC')->where('students.branch_id', Session::get('branch_id'))
            ->select('students.*', 'user.user_id', 'user.user_name', 'classes.class_name', 'branches.branch_name', 'create_section.cs_name', 'new_groups.ng_name')
            ->paginate($pagination_number);
        // ->get();
        $sections = $query_sections->get();
        $student_title = Student::where('clg_id', $user->user_clg_id)->where('branch_id', $branch_id)->orderBy('id', config('global_variables.query_sorting'))->pluck('full_name')->all(); //where
        //('delete_status', '!=', 1)->
        //where('delete_status', '!=', 1)->


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
            return view('collegeViews.student.student_dashboard', compact('datas', 'search', 'search_year', 'reasons', 'search_class', 'search_section', 'sections', 'student_title', 'search_by_user', 'restore_list', 'search_status', 'search_roll_no'));
        }
    }

    public function stuck_off_students(Request $request, $array = null, $str = null)
    {
        Session::forget('student_id');
        $user = Auth::user();
        $branch_id = Session::get('branch_id');
        $query_sections = CreateSectionModel::where('cs_clg_id', '=', $user->user_clg_id)->where('cs_branch_id', '=', $branch_id);
        $reasons = ChangeStudentStatusReasonModel::where('cssr_clg_id', $user->user_clg_id)->get();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_class = (!isset($request->class) && empty($request->class)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->class;
        $search_section = (!isset($request->section) && empty($request->section)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->section;
        $search_status = (!isset($request->status) && empty($request->status)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->status;
        $search_roll_no = (!isset($request->roll_no) && empty($request->roll_no)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->roll_no;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.region_list.region_list';
        $pge_title = 'Region List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_class, $search_section, $search_status, $search_roll_no);

        $pagination_number = (empty($ar)) ? 60 : 100000000;


        $query = Student::where('students.clg_id', $user->user_clg_id)
            ->leftJoin('financials_users as user', 'user.user_id', '=', 'students.created_by')
            ->leftJoin('classes', 'classes.class_id', '=', 'students.class_id')
            ->leftJoin('branches', 'branches.branch_id', '=', 'students.branch_id')
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'students.section_id')
            ->leftJoin('new_groups', 'new_groups.ng_id', '=', 'students.group_id')
            ->where('students.branch_id', $branch_id)
            ->where('students.status', '=', 3);
        if (!empty($search)) {
            $query
                ->where('registration_no', 'like', '%' . $search . '%')
                ->orWhere('full_name', 'like', '%' . $search . '%')
                ->where('students.branch_id', $branch_id);
        }
        if (!empty($search_class)) {
            $section = Section::where('section_clg_id', $user->user_clg_id)
                ->where('section_branch_id', $branch_id)
                ->where('section_class_id', $search_class)->pluck('section_name');
            $query_sections->whereIn('cs_id', $section);
            $query->where('students.class_id', $search_class);
        }
        if (!empty($search_section)) {
            $query->where('students.section_id', $search_section);
        }
        if (!empty($search_status)) {
            $query->where('students.status', $search_status);
        }
        if (!empty($search_roll_no)) {
            $query->where('students.roll_no', $search_roll_no);
        }

        if (!empty($search_by_user)) {

            $query->where('created_by', $search_by_user);
        }

        $restore_list = $request->restore_list;
        // if ($restore_list == 1) {
        //     $query->where('delete_status', '=', 1);
        // } else {
        //     $query->where('delete_status', '!=', 1);
        // }
        $datas = $query->orderBy('id', 'DESC')->where('students.branch_id', Session::get('branch_id'))
            ->select('students.*', 'user.user_id', 'user.user_name', 'classes.class_name', 'branches.branch_name', 'create_section.cs_name', 'new_groups.ng_name')
            ->paginate($pagination_number);
        // ->get();
        $sections = $query_sections->get();
        $student_title = Student::where('clg_id', $user->user_clg_id)->where('branch_id', $branch_id)->orderBy('id', config('global_variables.query_sorting'))->pluck('full_name')->all(); //where
        //('delete_status', '!=', 1)->
        //where('delete_status', '!=', 1)->


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
            return view('collegeViews.student.stuck_off_students', compact('datas', 'search', 'reasons', 'search_class', 'search_section', 'sections', 'student_title', 'search_by_user', 'restore_list', 'search_status', 'search_roll_no'));
        }
    }

    public function student_ledger(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $student_name = '';
        $students = Student::where('clg_id', $user->user_clg_id)->where('branch_id', Session::get('branch_id'))->get();
        $ar = json_decode($request->array);
        $search_student = (!isset($request->student) && empty($request->student)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->student;

        $prnt_page_dir = 'print.student_ledger.student_ledger';
        $pge_title = 'Region List';
        $srch_fltr = [];
        array_push($srch_fltr, $search_student);

        $pagination_number = (empty($ar)) ? 100000000 : 100000000;
        $student_name = $this->get_studentName($search_student);
        $query = StudentBalances::leftJoin('branches', 'branches.branch_id', '=', 'student_balances.sbal_branch_id')
            ->leftJoin('students', 'students.id', '=', 'student_balances.sbal_student_id')
            ->where('sbal_clg_id', $user->user_clg_id)
            ->where('sbal_student_id', $search_student)
            ->where('sbal_branch_id', Session::get('branch_id'));

        $datas = $query->orderBy('id', 'DESC')
            ->select('student_balances.*', 'students.full_name', 'students.registration_no', 'branches.branch_name')
            ->paginate($pagination_number);
        // ->get();


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
            return view('collegeViews.ledger.student_ledger', compact('datas', 'student_name', 'search_student', 'students'));
        }
    }

    public function issue_rollno(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $classes = Classes::where('class_clg_id', $user->user_clg_id)->get();
        $sections = CreateSectionModel::where('cs_clg_id', $user->user_clg_id)->where('cs_branch_id', Session::get('branch_id'))->get();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_class = (!isset($request->class) && empty($request->class)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->class;
        $search_section = (!isset($request->section) && empty($request->section)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->section;
        $search_status = (!isset($request->status) && empty($request->status)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->status;

        $prnt_page_dir = 'print.region_list.region_list';
        $pge_title = 'Region List';
        $srch_fltr = [];
        array_push($srch_fltr, $search_class, $search_section, $search_status);

        $pagination_number = (empty($ar)) ? 100 : 100000000;


        $query = Student::leftJoin('classes', 'classes.class_id', '=', 'students.class_id')
            ->leftJoin('branches', 'branches.branch_id', '=', 'students.branch_id')
            ->where('students.clg_id', $user->user_clg_id)
            ->where('students.branch_id', Session::get('branch_id'));

        if (!empty($search)) {
            $query->where('full_name', 'like', '%' . $search . '%')
                ->orWhere('registration_no', 'like', '%' . $search . '%')
                ->orWhere('cnic', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%');
        }
        if (!empty($search_class)) {
            $query->where('students.class_id', $search_class);
        }
        if (!empty($search_section)) {
            $query->where('students.section_id', $search_section);
        }
        if (!empty($search_status)) {
            $query->where('students.student_disable_enable', $search_status);
        }
        $datas = $query->orderBy('full_name', 'ASC')
            ->select('students.*', 'classes.class_name', 'branches.branch_name')
            ->paginate($pagination_number);


        $student_title = Student::where('clg_id', $user->user_clg_id)->orderBy('id', config('global_variables.query_sorting'))->pluck('full_name')->all(); //where('delete_status', '!=', 1)->
        //where('delete_status', '!=', 1)->


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
            return view('collegeViews.student.issue_rollno', compact('datas', 'search', 'search_class', 'classes', 'student_title', 'search_status', 'search_section', 'sections'));
        }
    }

    public function submit_rollno(Request $request)
    {
        $user = Auth::User();

        $rollno = $request->rollno;
        $student_ids = $request->student_id;

        foreach ($student_ids as $index => $id) {
            $student_id = $id;
            $roll_no = $rollno[$index];
            $student = Student::where('clg_id', '=', $user->user_clg_id)->where('id', '=', $student_id)->first();
            $student->roll_no = $roll_no;
            $student->save();
        }
        return redirect()->back()->with('success', 'Successfully Update');
    }

    public function change_student_status(Request $request)
    {
        $student_id = $request->student_id;
        $status = $request->status;
        $date = $request->date;
        $reason = $request->reason;
        $remarks = $request->remarks;
        $detail_remarks = '';
        $rand_number = Utility::uniqidReal();
        $uniqueId = Utility::uniqidReal() . mt_rand();
        $student = Student::where('id', $student_id)->first();

        $user = Auth::user();
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $flag = false;
        $values_array = [];
        $detail_remarks = '';
        if ($status == 3) {
            $customs = CustomVoucherModel::where('cv_std_id', $student_id)->where('cv_status', '=', 'Pending')->leftJoin('student_custom_voucher_items as items', 'items.cvi_voucher_id', '=', 'student_custom_voucher.cv_id')
                ->leftJoin('student_fee_components as components', 'components.sfc_id', '=', 'items.cvi_component_id')
                ->selectRaw('sum(cvi_amount),cvi_component_id,components.*')->groupBy('cvi_component_id')->get();


            $inst_amount = StudentInstallment::where('si_std_id', $student_id)->where('si_status_update', '!=', 1)->where('si_package_type', '=', 1)->selectRaw('sum(si_t_fee) as tution_fee, sum(si_p_fund) as paper_fund, sum(si_a_fund) as annual_fund , sum(si_z_fund) as zakat_fund')
                ->first();
//            for arrears
            $arrear_amount = StudentInstallment::where('si_std_id', $student_id)->where('si_status_update', '!=', 1)->where('si_package_type', '=', 2)->selectRaw('sum(si_t_fee) as tution_fee')
                ->first();

            $posting_reference = PostingReferenceModel::where('pr_clg_id', $user->user_clg_id)->pluck('pr_id')->first();
            $ledger_amount = StudentBalances::where('sbal_student_id', '=', $student_id)->orderBy('sbal_id', 'DESC')->pluck('sbal_total')->first();
            if ($ledger_amount > 0) {

                if ($inst_amount->tution_fee > 0) {
                    $detail_remarks .= '110201 - Tution Fee Receivable HO' . ', ' . 'Cr' . '@' . number_format($inst_amount->tution_fee, 2) . config('global_variables.Line_Break');

                    $values_array[] = [
                        '0' => '110201',
                        '1' => '110201 - Tution Fee Receivable HO',
                        '2' => $inst_amount->tution_fee,
                        '3' => 'Cr',
                        '4' => $student->registration_no . ' - ' . $student->full_name,
                        '5' => $posting_reference,

                    ];
                    $detail_remarks .= '310111 - Tution Fee Income HO' . ', ' . 'Dr' . '@' . number_format($inst_amount->tution_fee, 2) . config('global_variables.Line_Break');
                    $values_array[] = [
                        '0' => '310111',
                        '1' => '310111 - Tution Fee Income HO',
                        '2' => $inst_amount->tution_fee,
                        '3' => 'Dr',
                        '4' => $student->registration_no . ' - ' . $student->full_name,
                        '5' => $posting_reference,
                    ];
                }
                if ($inst_amount->paper_fund > 0) {
                    $detail_remarks .= '110202 - Paper Fund Receivable HO' . ', ' . 'Cr' . '@' . number_format($inst_amount->paper_fund, 2) . config('global_variables.Line_Break');
                    $values_array[] = [
                        '0' => '110202',
                        '1' => '110202 - Paper Fund Receivable HO',
                        '2' => $inst_amount->paper_fund,
                        '3' => 'Cr',
                        '4' => $student->registration_no . ' - ' . $student->full_name,
                        '5' => $posting_reference,
                    ];
                    $detail_remarks .= '310112 - Paper Fund Income HO' . ', ' . 'Dr' . '@' . number_format($inst_amount->paper_fund, 2) . config('global_variables.Line_Break');
                    $values_array[] = [
                        '0' => '310112',
                        '1' => '310112 - Paper Fund Income HO',
                        '2' => $inst_amount->paper_fund,
                        '3' => 'Dr',
                        '4' => $student->registration_no . ' - ' . $student->full_name,
                        '5' => $posting_reference,
                    ];
                }
                if ($inst_amount->annual_fund > 0) {
                    $detail_remarks .= '110203 - Annual Fund Receivable HO' . ', ' . 'Cr' . '@' . number_format($inst_amount->annual_fund, 2) . config('global_variables.Line_Break');
                    $values_array[] = [
                        '0' => '110203',
                        '1' => '110203 - Annual Fund Receivable HO',
                        '2' => $inst_amount->annual_fund,
                        '3' => 'Cr',
                        '4' => $student->registration_no . ' - ' . $student->full_name,
                        '5' => $posting_reference,
                    ];
                    $detail_remarks .= '310113 - Annual Fund Income HO' . ', ' . 'Dr' . '@' . number_format($inst_amount->annual_fund, 2) . config('global_variables.Line_Break');
                    $values_array[] = [
                        '0' => '310113',
                        '1' => '310113 - Annual Fund Income HO',
                        '2' => $inst_amount->annual_fund,
                        '3' => 'Dr',
                        '4' => $student->registration_no . ' - ' . $student->full_name,
                        '5' => $posting_reference,
                    ];
                }
                if ($inst_amount->zakat_fund > 0) {
                    $detail_remarks .= '110201 - Tution Fee Receivable HO as a zakat' . ', ' . 'Cr' . '@' . number_format($inst_amount->zakat_fund, 2) . config('global_variables.Line_Break');
                    $values_array[] = [
                        '0' => '110201',
                        '1' => '110201 - Tution Fee Receivable HO',
                        '2' => $inst_amount->zakat_fund,
                        '3' => 'Cr',
                        '4' => $student->registration_no . ' - ' . $student->full_name . ' - Zakat',
                        '5' => $posting_reference,
                    ];
                    $detail_remarks .= '310111 - Tution Fee Income HO As a Zakat' . ', ' . 'Dr' . '@' . number_format($inst_amount->zakat_fund, 2) . config('global_variables.Line_Break');
                    $values_array[] = [
                        '0' => '310111',
                        '1' => '310111 - Tution Fee Income HO',
                        '2' => $inst_amount->zakat_fund,
                        '3' => 'Dr',
                        '4' => $student->registration_no . ' - ' . $student->full_name . ' - Zakat',
                        '5' => $posting_reference,
                    ];
                }
                if ($arrear_amount->tution_fee > 0) {
                    $values_array[] = [
                        '0' => '110211',
                        '1' => '110211 - Arrears Receivables - HO',
                        '2' => $arrear_amount->tution_fee,
                        '3' => 'Cr',
                        '4' => $student->registration_no . ' - ' . $student->full_name,
                        '5' => $posting_reference,

                    ];
                    $detail_remarks .= '310111 - Tution Fee Income HO' . ', ' . 'Dr' . '@' . number_format($inst_amount->tution_fee, 2) . config('global_variables.Line_Break');
                    $values_array[] = [
                        '0' => '310111',
                        '1' => '310111 - Tution Fee Income HO',
                        '2' => $arrear_amount->tution_fee,
                        '3' => 'Dr',
                        '4' => $student->registration_no . ' - ' . $student->full_name,
                        '5' => $posting_reference,
                    ];
                }
                if ($customs) {
                    foreach ($customs as $custom) {
                        $dr_account_name = $this->get_account_name($custom->sfc_dr_account);
                        $cr_account_name = $this->get_account_name($custom->sfc_cr_account);
                        $values_array[] = [
                            '0' => $custom->sfc_dr_account,
                            '1' => $custom->sfc_dr_account . ' - ' . $dr_account_name,
                            '2' => $custom->sfc_amount,
                            '3' => 'Cr',
                            '4' => $custom->sfc_name,
                            '5' => $posting_reference,

                        ];
                        $values_array[] = [
                            '0' => $custom->sfc_cr_account,
                            '1' => $custom->sfc_cr_account . ' - ' . $cr_account_name,
                            '2' => $custom->sfc_amount,
                            '3' => 'Dr',
                            '4' => $custom->sfc_name,
                            '5' => $posting_reference,
                        ];
                    }
                }
                $tota_get = 0;
                foreach ($values_array as $data) {
                    $tota_get += $data[2];
                }
                $json_array = json_encode($values_array);


                $get_day_end = new DayEndController();
                $day_end = $get_day_end->day_end();

                $notes = 'STUDENT_STUCK_OFF_VOUCHER';
                $voucher_code = config('global_variables.STUCK_OFF_STUDENT_VOUCHER_CODE');
                $transaction_type = config('global_variables.STUCK_OFF');

                \Illuminate\Support\Facades\DB::beginTransaction();

                $sov = new StuckOffVoucherModel();

                $sov = $this->assign_stuckOFF_values('sov', $request, $sov, $ledger_amount, $user, $day_end, $student->registration_no, $json_array);

                if ($sov->save()) {
                    $sov_id = $sov->sov_id;
                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed');
                }

                foreach ($values_array as $key) {

                    $transaction = new TransactionModel();

                    if ($key[3] == 'Dr') {

                        $transaction = $this->AssignTransactionsValues($transaction, $key[0], $key[2], 0, $notes, $transaction_type, $sov_id);

                        if ($transaction->save()) {

                            $transaction_id = $transaction->trans_id;
                            $balances = new BalancesModel();
                            $detail_remarks_std = $key[1] . ', ' . 'Dr' . '@' . number_format($key[2], 2) . config('global_variables.Line_Break');

                            $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key[0], $key[2], $key[3], $key[4], $notes, $detail_remarks_std, $voucher_code .
                                $sov_id, $key[5], $voucher_code . $sov_id, $this->getYearEndId());

                            if (!$balance->save()) {
                                $flag = true;
                                DB::rollBack();
                                return redirect()->back()->with('fail', 'Failed');
                            }

                        } else {
                            DB::rollBack();
                            return redirect()->back()->with('fail', 'Failed');
                        }

                    } else {

                        $transaction = $this->AssignTransactionsValues($transaction, 0, $key[2], $key[0], $notes, 5, $sov_id);
                        if ($transaction->save()) {
                            $transaction_id = $transaction->trans_id;
                            $balances = new BalancesModel();
                            $detail_remarks_std = $key[1] . ', ' . 'Cr' . '@' . number_format($key[2], 2) . config('global_variables.Line_Break');
                            $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key[0], $key[2], $key[3], $key[4], $notes, $detail_remarks_std, $voucher_code .
                                $sov_id, $key[5], $voucher_code . $sov_id, $this->getYearEndId());

                            if (!$balance->save()) {
                                $flag = true;
                                DB::rollBack();
                                return redirect()->back()->with('fail', 'Failed');
                            }
                            // student balance table entry start
                            $std_balances = new StudentBalances();

                            $std_balances = $this->AssignStudentBalancesValues($std_balances, $key[0], $key[2], 'Cr',
                                $notes, $key[4] . ', @' . number_format($key[2], 2) . config('global_variables.Line_Break'),
                                $voucher_code . $sov_id, $student_id, $student->registration_no);
                            if (!$std_balances->save()) {
                                $rollBack = true;
                                DB::rollBack();
                                return redirect()->back()->with('fail', 'Failed');
                            }

                            // student balance table entry end
                        } else {
                            DB::rollBack();
                            return redirect()->back()->with('fail', 'Failed');
                        }
                    }
                }
            }
        }
        if ($flag) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        } else {

            $student->struck_off_date = date('Y-m-d', strtotime($date));;
            $student->is_struck_off = $user->user_id;
            $student->status = $status;
            $student->save();

            $student_status = new ChangeStudentStatusModel();
            $student_status->css_student_id = $student_id;
            $student_status->css_reg_no = $student->registration_no;
            $student_status->css_status = $status;
            $student_status->css_date = date('Y-m-d', strtotime($date));
            $student_status->css_reason = $reason;
            $student_status->css_remarks = $remarks;
            $student_status->css_brwsr_info = $brwsr_rslt;
            $student_status->css_ip_adrs = $ip_rslt;
            $student_status->css_clg_id = $user->user_clg_id;
            $student_status->css_branch_id = Session::get('branch_id');
            $student_status->css_created_by = $user->user_id;
            $student_status->css_created_datetime = Carbon::now()->toDateTimeString();;

            $save_image = new SaveImageController();

            $common_path = config('global_variables.common_path');
            $product_path = config('global_variables.student_status');

            // Handle Image
            $fileNameToStore = $save_image->SaveImage($request, 'pimage', $uniqueId, $product_path, $rand_number . 'Reasons');


            if ($request->hasFile('pimage')) {
                $student_status->css_file = $common_path . $fileNameToStore;
            } else {
                $student_status->css_file = $fileNameToStore;
            }

            $student_status->save();


            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Journal Voucher With Id: ');

            DB::commit();
            return redirect()->back()->with('success', 'Status Update Successfully!');
        }
    }

    public function change_student_status_active(Request $request)
    {
        $student_id = $request->student_id;
        $status = $request->status;
        $date = $request->date;
        $reason = $request->reason;
        $remarks = $request->remarks;
        $detail_remarks = '';
        $rand_number = Utility::uniqidReal();
        $uniqueId = Utility::uniqidReal() . mt_rand();
        $student = Student::where('id', $student_id)->first();

        $user = Auth::user();
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $flag = false;
        $values_array = [];
        $detail_remarks = '';
        if ($status == 1) {
            $customs = CustomVoucherModel::where('cv_std_id', $student_id)->where('cv_status', '=', 'Pending')->leftJoin('student_custom_voucher_items as items', 'items.cvi_voucher_id', '=', 'student_custom_voucher.cv_id')
                ->leftJoin('student_fee_components as components', 'components.sfc_id', '=', 'items.cvi_component_id')
                ->selectRaw('sum(cvi_amount),cvi_component_id,components.*')->groupBy('cvi_component_id')->get();


            $inst_amount = StudentInstallment::where('si_std_id', $student_id)->where('si_status_update', '!=', 1)->where('si_package_type', '=', 1)->selectRaw('sum(si_t_fee) as tution_fee, sum(si_p_fund) as paper_fund, sum(si_a_fund) as annual_fund , sum(si_z_fund) as zakat_fund')
                ->first();
//            for arrears
            $arrear_amount = StudentInstallment::where('si_std_id', $student_id)->where('si_status_update', '!=', 1)->where('si_package_type', '=', 2)->selectRaw('sum(si_t_fee) as tution_fee')
                ->first();

            $posting_reference = PostingReferenceModel::where('pr_clg_id', $user->user_clg_id)->pluck('pr_id')->first();
            $ledger_amount = StudentBalances::where('sbal_student_id', '=', $student_id)->orderBy('sbal_id', 'DESC')->pluck('sbal_total')->first();
            if ($ledger_amount == 0) {

                if ($inst_amount->tution_fee > 0) {
                    $detail_remarks .= '110201 - Tution Fee Receivable HO' . ', ' . 'Dr' . '@' . number_format($inst_amount->tution_fee, 2) . config('global_variables.Line_Break');

                    $values_array[] = [
                        '0' => '110201',
                        '1' => '110201 - Tution Fee Receivable HO',
                        '2' => $inst_amount->tution_fee,
                        '3' => 'Dr',
                        '4' => $student->registration_no . ' - ' . $student->full_name,
                        '5' => $posting_reference,

                    ];
                    $detail_remarks .= '310111 - Tution Fee Income HO' . ', ' . 'Cr' . '@' . number_format($inst_amount->tution_fee, 2) . config('global_variables.Line_Break');
                    $values_array[] = [
                        '0' => '310111',
                        '1' => '310111 - Tution Fee Income HO',
                        '2' => $inst_amount->tution_fee,
                        '3' => 'Cr',
                        '4' => $student->registration_no . ' - ' . $student->full_name,
                        '5' => $posting_reference,
                    ];
                }
                if ($inst_amount->paper_fund > 0) {
                    $detail_remarks .= '110202 - Paper Fund Receivable HO' . ', ' . 'Dr' . '@' . number_format($inst_amount->paper_fund, 2) . config('global_variables.Line_Break');
                    $values_array[] = [
                        '0' => '110202',
                        '1' => '110202 - Paper Fund Receivable HO',
                        '2' => $inst_amount->paper_fund,
                        '3' => 'Dr',
                        '4' => $student->registration_no . ' - ' . $student->full_name,
                        '5' => $posting_reference,
                    ];
                    $detail_remarks .= '310112 - Paper Fund Income HO' . ', ' . 'Cr' . '@' . number_format($inst_amount->paper_fund, 2) . config('global_variables.Line_Break');
                    $values_array[] = [
                        '0' => '310112',
                        '1' => '310112 - Paper Fund Income HO',
                        '2' => $inst_amount->paper_fund,
                        '3' => 'Cr',
                        '4' => $student->registration_no . ' - ' . $student->full_name,
                        '5' => $posting_reference,
                    ];
                }
                if ($inst_amount->annual_fund > 0) {
                    $detail_remarks .= '110203 - Annual Fund Receivable HO' . ', ' . 'Dr' . '@' . number_format($inst_amount->annual_fund, 2) . config('global_variables.Line_Break');
                    $values_array[] = [
                        '0' => '110203',
                        '1' => '110203 - Annual Fund Receivable HO',
                        '2' => $inst_amount->annual_fund,
                        '3' => 'Dr',
                        '4' => $student->registration_no . ' - ' . $student->full_name,
                        '5' => $posting_reference,
                    ];
                    $detail_remarks .= '310113 - Annual Fund Income HO' . ', ' . 'Cr' . '@' . number_format($inst_amount->annual_fund, 2) . config('global_variables.Line_Break');
                    $values_array[] = [
                        '0' => '310113',
                        '1' => '310113 - Annual Fund Income HO',
                        '2' => $inst_amount->annual_fund,
                        '3' => 'Cr',
                        '4' => $student->registration_no . ' - ' . $student->full_name,
                        '5' => $posting_reference,
                    ];
                }
                if ($inst_amount->zakat_fund > 0) {
                    $detail_remarks .= '110201 - Tution Fee Receivable HO as a zakat' . ', ' . 'Dr' . '@' . number_format($inst_amount->zakat_fund, 2) . config('global_variables.Line_Break');
                    $values_array[] = [
                        '0' => '110201',
                        '1' => '110201 - Tution Fee Receivable HO',
                        '2' => $inst_amount->zakat_fund,
                        '3' => 'Dr',
                        '4' => $student->registration_no . ' - ' . $student->full_name . ' - Zakat',
                        '5' => $posting_reference,
                    ];
                    $detail_remarks .= '310111 - Tution Fee Income HO As a Zakat' . ', ' . 'Cr' . '@' . number_format($inst_amount->zakat_fund, 2) . config('global_variables.Line_Break');
                    $values_array[] = [
                        '0' => '310111',
                        '1' => '310111 - Tution Fee Income HO',
                        '2' => $inst_amount->zakat_fund,
                        '3' => 'Cr',
                        '4' => $student->registration_no . ' - ' . $student->full_name . ' - Zakat',
                        '5' => $posting_reference,
                    ];
                }
                if ($arrear_amount->tution_fee > 0) {
                    $values_array[] = [
                        '0' => '110211',
                        '1' => '110211 - Arrears Receivables - HO',
                        '2' => $arrear_amount->tution_fee,
                        '3' => 'Dr',
                        '4' => $student->registration_no . ' - ' . $student->full_name,
                        '5' => $posting_reference,

                    ];
                    $detail_remarks .= '310111 - Tution Fee Income HO' . ', ' . 'Cr' . '@' . number_format($inst_amount->tution_fee, 2) . config('global_variables.Line_Break');
                    $values_array[] = [
                        '0' => '310111',
                        '1' => '310111 - Tution Fee Income HO',
                        '2' => $arrear_amount->tution_fee,
                        '3' => 'Cr',
                        '4' => $student->registration_no . ' - ' . $student->full_name,
                        '5' => $posting_reference,
                    ];
                }
                if ($customs) {
                    foreach ($customs as $custom) {
                        $dr_account_name = $this->get_account_name($custom->sfc_dr_account);
                        $cr_account_name = $this->get_account_name($custom->sfc_cr_account);
                        $values_array[] = [
                            '0' => $custom->sfc_dr_account,
                            '1' => $custom->sfc_dr_account . ' - ' . $dr_account_name,
                            '2' => $custom->sfc_amount,
                            '3' => 'Dr',
                            '4' => $custom->sfc_name,
                            '5' => $posting_reference,

                        ];
                        $values_array[] = [
                            '0' => $custom->sfc_cr_account,
                            '1' => $custom->sfc_cr_account . ' - ' . $cr_account_name,
                            '2' => $custom->sfc_amount,
                            '3' => 'Cr',
                            '4' => $custom->sfc_name,
                            '5' => $posting_reference,
                        ];
                    }
                }
                $tota_get = 0;
                foreach ($values_array as $data) {
                    $tota_get += $data[2];
                }
                $json_array = json_encode($values_array);


                $get_day_end = new DayEndController();
                $day_end = $get_day_end->day_end();

                $notes = 'STUDENT_STUCK_OFF_TO_ACTIVE_VOUCHER';
                $voucher_code = config('global_variables.STUCK_OFF_STUDENT_VOUCHER_CODE');
                $transaction_type = config('global_variables.STUCK_OFF');

                \Illuminate\Support\Facades\DB::beginTransaction();

                $sov = new StuckOffVoucherModel();

                $sov = $this->assign_stuckOFF_values('sov', $request, $sov, $ledger_amount, $user, $day_end, $student->registration_no, $json_array);

                if ($sov->save()) {
                    $sov_id = $sov->sov_id;
                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed');
                }

                foreach ($values_array as $key) {

                    $transaction = new TransactionModel();

                    if ($key[3] == 'Dr') {

                        $transaction = $this->AssignTransactionsValues($transaction, $key[0], $key[2], 0, $notes, $transaction_type, $sov_id);

                        if ($transaction->save()) {

                            $transaction_id = $transaction->trans_id;
                            $balances = new BalancesModel();
                            $detail_remarks_std = $key[1] . ', ' . 'Dr' . '@' . number_format($key[2], 2) . config('global_variables.Line_Break');

                            $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key[0], $key[2], $key[3], $key[4], $notes, $detail_remarks_std, $voucher_code .
                                $sov_id, $key[5], $voucher_code . $sov_id, $this->getYearEndId());

                            if (!$balance->save()) {
                                $flag = true;
                                DB::rollBack();
                                return redirect()->back()->with('fail', 'Failed');
                            }
                            // student balance table entry start
                            $std_balances = new StudentBalances();

                            $std_balances = $this->AssignStudentBalancesValues($std_balances, $key[0], $key[2], 'Dr',
                                $notes, $key[4] . ', @' . number_format($key[2], 2) . config('global_variables.Line_Break'),
                                $voucher_code . $sov_id, $student_id, $student->registration_no);
                            if (!$std_balances->save()) {
                                $rollBack = true;
                                DB::rollBack();
                                return redirect()->back()->with('fail', 'Failed');
                            }

                            // student balance table entry end

                        } else {
                            DB::rollBack();
                            return redirect()->back()->with('fail', 'Failed');
                        }

                    } else {

                        $transaction = $this->AssignTransactionsValues($transaction, 0, $key[2], $key[0], $notes, 5, $sov_id);
                        if ($transaction->save()) {
                            $transaction_id = $transaction->trans_id;
                            $balances = new BalancesModel();
                            $detail_remarks_std = $key[1] . ', ' . 'Cr' . '@' . number_format($key[2], 2) . config('global_variables.Line_Break');
                            $balance = $this->AssignAccountBalancesValues($balances, $transaction_id, $key[0], $key[2], $key[3], $key[4], $notes, $detail_remarks_std, $voucher_code .
                                $sov_id, $key[5], $voucher_code . $sov_id, $this->getYearEndId());

                            if (!$balance->save()) {
                                $flag = true;
                                DB::rollBack();
                                return redirect()->back()->with('fail', 'Failed');
                            }

                        } else {
                            DB::rollBack();
                            return redirect()->back()->with('fail', 'Failed');
                        }
                    }
                }
            }

        }
        if ($flag) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed');
        } else {

            $student->status = $status;
            $student->save();

            $student_status = new ChangeStudentStatusModel();
            $student_status->css_student_id = $student_id;
            $student_status->css_reg_no = $student->registration_no;
            $student_status->css_status = $status;
            $student_status->css_date = date('Y-m-d', strtotime($date));
            $student_status->css_reason = $reason;
            $student_status->css_remarks = $remarks;
            $student_status->css_brwsr_info = $brwsr_rslt;
            $student_status->css_ip_adrs = $ip_rslt;
            $student_status->css_clg_id = $user->user_clg_id;
            $student_status->css_branch_id = Session::get('branch_id');
            $student_status->css_created_by = $user->user_id;
            $student_status->css_created_datetime = Carbon::now()->toDateTimeString();;

            $save_image = new SaveImageController();

            $common_path = config('global_variables.common_path');
            $product_path = config('global_variables.student_status');

            // Handle Image
            $fileNameToStore = $save_image->SaveImage($request, 'pimage', $uniqueId, $product_path, $rand_number . 'Reasons');


            if ($request->hasFile('pimage')) {
                $student_status->css_file = $common_path . $fileNameToStore;
            } else {
                $student_status->css_file = $fileNameToStore;
            }

            $student_status->save();


            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Journal Voucher With Id: ');

            DB::commit();
            return redirect()->back()->with('success', 'Status Update Successfully!');
        }
    }

    public function assign_stuckOFF_values($prfx, $request, $sov, $ledger_amount, $user, $day_end, $registration_number, $json_array)
    {
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $std_id = $prfx . '_student_id';
        $std_reg_no = $prfx . '_reg_no';
        $total_amount = $prfx . '_amount';

        $created_datetime = $prfx . '_created_datetime';
        $day_end_id = $prfx . '_day_end_id';
        $day_end_date = $prfx . '_day_end_date';
        $createdby = $prfx . '_createdby';
        $clg_id = $prfx . '_clg_id';
        $branch_id = $prfx . '_branch_id';
        $brwsr_info = $prfx . '_brwsr_info';
        $ip_adrs = $prfx . '_ip_adrs';
        $data = $prfx . '_data';
        $year_id = $prfx . '_year_id';


        $sov->$std_id = $request->student_id;
        $sov->$std_reg_no = $registration_number;
        $sov->$total_amount = $ledger_amount;
        $sov->$data = $json_array;


        $sov->$created_datetime = Carbon::now()->toDateTimeString();
        $sov->$day_end_id = $day_end->de_id;
        $sov->$day_end_date = $day_end->de_datetime;
        $sov->$createdby = $user->user_id;
        $sov->$clg_id = $user->user_clg_id;
        $sov->$branch_id = Session::get('branch_id');
        $sov->$brwsr_info = $brwsr_rslt;
        $sov->$ip_adrs = $ip_rslt;
        $sov->$year_id = $this->getYearEndId();

        return $sov;
    }

    public function mark_graduate()
    {
        return view('collegeViews.student/graduate');
    }

    function get_active_students(Request $request)
    {
        $query = Student::where('class_id', $request->class_id)
            ->where('branch_id', Session::get('branch_id'))
            ->where('student_disable_enable', 1)
            ->whereIn('status', [1, 4]);
//            ->pluck('id');
        $student_ids = $query->get();
//        $students=$query->get();
        return response()->json(['students' => $student_ids]);
    }

    public function submit_mark_graduate(Request $request)
    {

        $validated = $request->validate([
            'class' => ['required'],
            'students' => ['required', 'array'],
            'students.*' => ['integer', 'exists:students,id'],
        ], [
            'class.required' => 'Please select class.',
            'students.required' => 'Please select at least one student.',
            'students.array' => 'The students field must be an array.',
            'students.*.integer' => 'Each student ID must be a valid integer.',
            'students.*.exists' => 'The selected student does not exist in our records.',
        ]);

        Student::whereIn('id', $request->students)->update([
            'status' => 2
        ]);
        return redirect()->back()->with('success', 'Successfully Graduated');
    }

    public function graduate_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $branch_id = Session::get('branch_id');
        $query_sections = CreateSectionModel::where('cs_clg_id', '=', $user->user_clg_id)->where('cs_branch_id', '=', $branch_id);
        $ar = json_decode($request->array);

        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_class = (!isset($request->class) && empty($request->class)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->class;
        $search_section = (!isset($request->section) && empty($request->section)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->section;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $prnt_page_dir = 'print.college.student.student_list';
        $pge_title = 'Stduent List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_class, $search_section, $search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = Student::join('financials_users as user', 'user.user_id', '=', 'students.created_by')
            ->leftJoin('classes', 'classes.class_id', '=', 'students.class_id')
            ->leftJoin('create_section', 'create_section.cs_id', '=', 'students.section_id')
            ->leftJoin('branches', 'branches.branch_id', '=', 'students.branch_id')
            ->where('students.status', 2)
            ->where('students.clg_id', $user->user_clg_id)
            ->where('students.branch_id', $branch_id);

        if (!empty($search)) {
            $query->where('full_name', 'like', '%' . $search . '%')
                ->orWhere('registration_no', 'like', '%' . $search . '%')
                ->orWhere('cnic', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%');
        }
        if (!empty($search_class)) {
            $section = Section::where('section_clg_id', $user->user_clg_id)
                ->where('section_branch_id', $branch_id)
                ->where('section_class_id', $search_class)->pluck('section_name');
            $query_sections->whereIn('cs_id', $section);
            $query->where('students.class_id', $search_class);
        }

        if (!empty($search_section)) {
            $query->where('students.section_id', $search_section);
        }

        if (!empty($search_year)) {
            $query->where('students.year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('students.year_id', '=', $search_year);
        }

        $datas = $query->orderBy('id', 'DESC')
            ->select('students.*', 'user.user_id', 'user.user_name', 'classes.class_name', 'branches.branch_name', 'create_section.cs_name', 'create_section.cs_id')
            ->paginate($pagination_number);
        // ->get();

        $student_title = Student::where('clg_id', $user->user_clg_id)->where('branch_id', $branch_id)->where('status', 2)->orderBy('id', config('global_variables.query_sorting'))->pluck('full_name')->all(); //where('delete_status', '!=', 1)->
        $sections = $query_sections->get();
        $branch = Branch::where('branch_clg_id', $user->user_clg_id)->where('branch_id', $branch_id)->pluck('branch_name')->first();


        if (isset($request->array) && !empty($request->array)) {
            // dd($request->all(),$datas,$search_class,$search_section);
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
            return view('collegeViews.student.graduate_list', compact('datas', 'search_year', 'search', 'search_class', 'student_title', 'sections', 'search_section'));
        }
    }
}
