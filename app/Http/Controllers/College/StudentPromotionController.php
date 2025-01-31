<?php

namespace App\Http\Controllers\College;

use App\Http\Controllers\Controller;
use App\Models\College\Classes;
use App\Models\College\Group;
use App\Models\College\Group as GroupAlias;
use App\Models\College\NewGroupsModel;
use App\Models\College\Semester;
use App\Models\College\Student;
use App\Models\College\StudentPromotioModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;
use function Laravel\Prompts\select;

class StudentPromotionController extends Controller
{
    public function promotion()
    {
        $user = Auth::user();
        $classes = Classes::where('class_clg_id', $user->user_clg_id)->get();
        $groups = NewGroupsModel::where('ng_clg_id', $user->user_clg_id)->get();
        return view('collegeViews.student_promotion.promotion', compact('classes', 'groups'));
    }

    public function submit_class_promotion(Request $request)
    {
        $check = Student::where('class_id', $request->class)->where('branch_id',Session::get('branch_id'))->where('group_id', $request->group_id)->count();
        if ($check > 0) {
            return redirect()->back()->with('fail', 'Class Already in this group !');
        }
        DB::transaction(function () use ($request) {
            $class_id = $request->class;
            $group_id = $request->group;
            $pr_group = $request->group_id;
            $current = Student::where('class_id', $class_id)
                ->where('group_id', $group_id)
                ->where('branch_id', $request->branch_id)
                ->where('status', '!=', 3)
                ->where('student_disable_enable', '!=', 0)
                ->get();
            $user = Auth::user();
            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->getIp();

            $validated = $request->validate([
//                'branch' => ['required', 'integer'],
                'class' => ['required', 'integer'],
                'group' => ['required', 'integer'],
            ]);
            $promotionStudents = [];

            foreach ($current as $student) {
                $promotionStudents[] = [
                    'sp_student_id' => $student->id,
                    'sp_branch_id' => Session::get('branch_id'),
                    'sp_class_id' => $student->class_id,
                    'sp_section_id' => $student->section_id,
                    'sp_group_id' => $student->group_id,
                    'sp_promotion_group_id' => $pr_group,
                    'sp_browser_info' => $brwsr_rslt,
                    'sp_ip_address' => $clientIP,
                    'sp_created_by' => $user->user_id,
                    'sp_clg_id' => $user->user_clg_id,
                    'sp_created_at' => Carbon::now(),
                    'sp_year_id' => $this->getYearEndId(),
                ];
            }
            StudentPromotioModel::insert($promotionStudents);

            Student::where('class_id', $class_id)
                ->where('group_id', $group_id)->where('branch_id', Session::get('branch_id'))
                ->where('status', '!=', 3)->where('student_disable_enable', '!=', 0)->update([
                    'group_id' => $pr_group,
                ]);

        });

        return redirect()->back()->with('success', 'Promote Successfully');
    }

    public function promotion_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search_by_class = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $search_by_group = (!isset($request->group_id) && empty($request->group_id)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->group_id;
        $prnt_page_dir = 'print/college/Transport/prnt_transport_list';
        $pge_title = 'Bus Route List';
        $srch_fltr = [];
        array_push($srch_fltr, $search_by_class, $search_by_group,$search_year);
        $pagination_number = (empty($ar)) ? 100000000 : 100000000;
        // $query = Classes::with('users')->where('class_clg_id', $user->user_clg_id)->toSql();
        $query = DB::table('student_promotion')
            ->where('sp_class_id', $search_by_class)
            ->where('sp_group_id', $search_by_group)
            ->where('sp_branch_id', Session::get('branch_id'))
            ->leftJoin('classes', 'classes.class_id', '=', 'student_promotion.sp_class_id')
            ->leftJoin('new_groups', 'new_groups.ng_id', '=', 'student_promotion.sp_group_id')
            ->leftJoin('new_groups as promote_group', 'promote_group.ng_id', '=', 'student_promotion.sp_promotion_group_id')
            ->leftJoin('financials_users as users', 'users.user_id', '=', 'student_promotion.sp_created_by')
            ->leftJoin('students', 'students.id', '=', 'student_promotion.sp_student_id');


        if (!empty($search_year)) {
            $query->where('sp_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('sp_year_id', '=', $search_year);
        }

        $classes = Classes::where('class_clg_id', $user->user_clg_id)->get();
        $groups = NewGroupsModel::where('ng_clg_id', $user->user_clg_id)->get();
        $datas = $query->select(
            'student_promotion.*', 'classes.class_id',
            'classes.class_name', 'new_groups.ng_id',
            'promote_group.ng_id as promotion_group_id',
            'promote_group.ng_name as promotion_group_name',
            'new_groups.ng_name', 'students.id',
            'students.full_name', 'users.user_name')->orderBy('sp_id', 'ASC')
            ->paginate($pagination_number);
        //where('class_delete_status', '!=', 1)->
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
            return view('collegeViews.student_promotion.promotion_list', compact('datas', 'search_year','search_by_group', 'search_by_class', 'user', 'classes', 'groups'));
        }

    }
}
