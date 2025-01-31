<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\PostingReferenceModel;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;

class PostingReferenceController extends Controller
{
    public function add_posting_reference()
    {
        return view('add_posting_reference');
    }

    public function submit_posting_reference(Request $request)
    {
        $this->posting_reference_validation($request);

        $posting_reference = new PostingReferenceModel();

        $posting_reference = $this->AssignPostingReferenceValues($request, $posting_reference);

        $posting_reference->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Project Reference With Id: ' . $posting_reference->pr_id . ' And Name: ' .
            $posting_reference->pr_name);

        return redirect('add_posting_reference')->with('success', 'Successfully Saved');

    }

    public function posting_reference_validation($request)
    {
        $user = Auth::user();
        return $this->validate($request, [
            'posting_reference' => [
                'required',
                'string',
                Rule::unique('financials_posting_reference', 'pr_name')
                    ->where(function ($query) use ($user) {
                        return $query->where('pr_clg_id', $user->user_clg_id);
                    })
            ],
            'remarks' => ['nullable', 'string'],
        ]);

    }

    protected function AssignPostingReferenceValues($request, $posting_reference)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $posting_reference->pr_name = ucwords($request->posting_reference);
        $posting_reference->pr_remarks = ucfirst($request->remarks);
        $posting_reference->pr_createdby = $user->user_id;
        $posting_reference->pr_clg_id = $user->user_clg_id;
        $posting_reference->pr_day_end_id = $day_end->de_id;
        $posting_reference->pr_day_end_date = $day_end->de_datetime;
        $posting_reference->pr_year_id = $this->getYearEndId();

        // coding from shahzaib start
        $tbl_var_name = 'posting_reference';
        $prfx = 'pr';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        return $posting_reference;
    }

    // update code by shahzaib start
    public function posting_reference_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.posting_reference_list.posting_reference_list';
        $pge_title = 'Posting Reference List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_posting_reference')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_posting_reference.pr_createdby')
            ->where('pr_clg_id', $user->user_clg_id);

        if (!empty($search)) {
            $query->where('pr_name', 'like', '%' . $search . '%')
                ->orWhere('pr_remarks', 'like', '%' . $search . '%')
                ->orWhere('pr_id', 'like', '%' . $search . '%');
//                ->orWhere('user_designation', 'like', '%' . $search . '%')
//                ->orWhere('user_name', 'like', '%' . $search . '%')
//                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
//            $pagination_number = 100000000;
            $query->where('pr_createdby', $search_by_user);
        }


        $datas = $query->orderBy('pr_id', 'DESC')
            ->paginate($pagination_number);

        $pr_title = PostingReferenceModel::where('pr_clg_id', $user->user_clg_id)->orderBy('pr_id', config('global_variables.query_sorting'))->pluck('pr_name')->all();//where('pr_delete_status', '!=', 1)->


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
            return view('posting_reference_list', compact('datas', 'search', 'pr_title', 'search_by_user'));
        }

    }

    // update code by shahzaib end


    public function edit_posting_reference(Request $request)
    {
        $posting_reference = PostingReferenceModel::where('pr_id', $request->posting_reference_id)->first();
        return view('edit_posting_reference', compact('posting_reference'));
    }

    public function update_posting_reference(Request $request)
    {
        $this->posting_reference_validation($request);

        $posting_reference = PostingReferenceModel::where('pr_id', $request->posting_reference_id)->first();

        $posting_reference = $this->AssignPostingReferenceValues($request, $posting_reference);

        $posting_reference->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Project Reference With Id: ' . $posting_reference->pr_id . ' And Name: ' .
            $posting_reference->pr_name);

        return redirect('edit_posting_reference')->with('success', 'Successfully Saved');
    }

}
