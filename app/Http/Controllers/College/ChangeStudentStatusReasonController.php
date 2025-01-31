<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Imports\ExcelDataImport;
use App\Models\College\ChangeStudentStatusReasonModel;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ChangeStudentStatusReasonController extends Controller
{
    public function add_reason()
    {
        return view('collegeViews.reason.add_reason');
    }

    public function submit_reason(Request $request)
    {
        $this->reason_validation($request);

        $reason = new ChangeStudentStatusReasonModel();

        $reason = $this->AssignReasonValues($request, $reason);

        $reason->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Region With Id: ' . $reason->cssr_id . ' And Name: ' . $reason->cssr_title);

        // WizardController::updateWizardInfo(['reason'], ['area']);

        return redirect()->back()->with('success', 'Successfully Saved');
    }

    public function reason_validation($request)
    {
        $user = Auth::User();
        return $this->validate($request, [
            'reason' => ['required', 'string', 'unique:change_student_status_reason,cssr_title,null,null,cssr_clg_id,' . $user->user_clg_id],
        ]);
    }

    protected function AssignReasonValues($request, $reason)
    {
        $user = Auth::User();
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $reason->cssr_title = ucwords($request->reason);
        $reason->cssr_createdby = $user->user_id;
        $reason->cssr_clg_id = $user->user_clg_id;
        $reason->cssr_branch_id = Session::get('branch_id');
        $reason->cssr_brwsr_info = $brwsr_rslt;
        $reason->cssr_ip_adrs = $ip_rslt;
        $reason->cssr_update_datetime = Carbon::now();
        $reason->cssr_year_id = $this->getYearEndId();

        return $reason;
    }

    // update code by shahzaib start
    public function reason_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.college.information_pdf.reason_list';
        $pge_title = 'Reason List';
        $srch_fltr = [];
        array_push($srch_fltr, $search,$search_year);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('change_student_status_reason')
            ->leftJoin('financials_users', 'financials_users.user_id', 'change_student_status_reason.cssr_createdby')
            ->where('cssr_clg_id', $user->user_clg_id);

        if (!empty($search)) {
            $query->where('cssr_title', 'like', '%' . $search . '%')
                ->orWhere('cssr_id', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {

            $query->where('cssr_createdby', $search_by_user);
        }
        if (!empty($search_year)) {
            $query->where('cssr_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('cssr_year_id', '=', $search_year);
        }
        $datas = $query->orderBy('cssr_id', 'DESC')
            ->paginate($pagination_number);

        $reason_title = ChangeStudentStatusReasonModel::orderBy('cssr_id', config('global_variables.query_sorting'))->pluck('cssr_title')->all(); //where('cssr_delete_status', '!=', 1)->


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
            return view('collegeViews.reason.reason_list', compact('datas', 'search_year','search', 'reason_title', 'search_by_user'));
        }
    }

    // update code by shahzaib end


    public function edit_reason(Request $request)
    {
        return view('collegeViews.reason.edit_reason', compact('request'));
    }

    public function update_reason(Request $request)
    {
        $user = Auth::User();
        $this->validate($request, [
            'reason_id' => ['required', 'numeric'],
            'reason' => ['required', 'string', 'unique:change_student_status_reason,cssr_title,' . $request->reason_id . ',cssr_id'.',cssr_clg_id,' . $user->user_clg_id],
        ]);

        $reason = ChangeStudentStatusReasonModel::where('cssr_id', $request->reason_id)->first();

        $reason = $this->AssignReasonValues($request, $reason);

        if ($reason->save()) {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Region With Id: ' . $reason->cssr_id . ' And Name: ' . $reason->cssr_title);
            return redirect('reason_list')->with('success', 'Successfully Saved');
        } else {
            return redirect('reason_list')->with('fail', 'Failed Try Again!');
        }
    }

}
