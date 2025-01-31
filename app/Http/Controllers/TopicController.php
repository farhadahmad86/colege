<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\TopicModel;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Maatwebsite\Excel\Facades\Excel;

class TopicController extends Controller
{
    public function add_topic()
    {
//        $this->enter_log('add_region');
        return view('add_topic');
    }

    public function submit_topic(Request $request)
    {
        $this->topic_validation($request);

        $topic = new TopicModel();

        $topic = $this->AssignTopicValues($request, $topic);

        $topic->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Topic With Id: ' . $topic->top_id . ' And Name: ' . $topic->top_title);

        // WizardController::updateWizardInfo(['region'], ['area']);

        return redirect('add_topic')->with('success', 'Successfully Saved');
    }

    public function topic_validation($request)
    {
        return $this->validate($request, [
            'name' => ['required', 'string', 'unique:financials_topic,top_title'],
            'remarks' => ['nullable', 'string'],
        ]);

    }

    protected function AssignTopicValues($request, $topic)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $topic->top_title = ucwords($request->name);
        $topic->top_remarks = ucfirst($request->remarks);
        $topic->top_createdby = $user->user_id;
        $topic->top_day_end_id = $day_end->de_id;
        $topic->top_day_end_date = $day_end->de_datetime;

        // coding from shahzaib start

        $tbl_var_name = 'topic';
        $prfx = 'top';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end

        return $topic;
    }


    public function topic_list(Request $request, $array = null, $str = null)
    {
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.topic_list.topic_list';
        $pge_title = 'Topic List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_topic')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_topic.top_createdby');

        if (!empty($search)) {
            $query->where('top_title', 'like', '%' . $search . '%')
                ->orWhere('top_remarks', 'like', '%' . $search . '%')
                ->orWhere('top_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
//            $pagination_number = 100000000;
            $query->where('top_createdby', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1)
        {
            $query->where('top_delete_status', '=', 1);
        } else {
            $query->where('top_delete_status', '!=', 1);
        }

        $datas = $query->orderBy('top_id', 'DESC')
            ->paginate($pagination_number);

        $top_title = TopicModel::orderBy('top_id', config('global_variables.query_sorting'))->pluck('top_title')->all();//where('top_delete_status', '!=', 1)->


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];

            $pdf = PDF::loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('topic_list', compact('datas', 'search', 'top_title', 'search_by_user', 'restore_list'));
        }

    }

//    // update code by shahzaib end
//
//
    public function edit_topic(Request $request)
    {
        return view('edit_topic', compact('request'));
    }

    public function update_topic(Request $request)
    {
        $this->validate($request, [
            'top_id' => ['required', 'numeric'],
            'name' => ['required', 'string', 'unique:financials_topic,top_title,' . $request->top_id . ',top_id'],
            'remarks' => ['nullable', 'string'],
        ]);

        $topic = TopicModel::where('top_id', $request->top_id)->first();
        $topic = $this->AssignTopicValues($request, $topic);

        if ($topic->save()) {
            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Topic With Id: ' . $topic->top_id . ' And Name: ' . $topic->top_title);
            return redirect('topic_list')->with('success', 'Successfully Saved');
        } else {
            return redirect('topic_list')->with('fail', 'Failed Try Again!');
        }
    }

    public function delete_topic (Request $request)
    {

        $user = Auth::User();

        $delete = TopicModel::where('top_id', $request->top_id)->first();

        if ($delete->top_delete_status == 1) {
            $delete->top_delete_status = 0;
        } else {
            $delete->top_delete_status = 1;
        }

        $delete->top_deleted_by = $user->user_id;

        if ($delete->save()) {

            if ($delete->top_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Topic With Id: ' . $delete->top_id . ' And Name: ' . $delete->top_title);

//                return redirect('region_list')->with('success', 'Successfully Restored');
                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Topic With Id: ' . $delete->top_id . ' And Name: ' . $delete->top_title);

//                return redirect('region_list')->with('success', 'Successfully Deleted');
                return redirect()->back()->with('success', 'Successfully Deleted');
            }

        } else {
//            return redirect('region_list')->with('fail', 'Failed Try Again!');
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }
    }
}
