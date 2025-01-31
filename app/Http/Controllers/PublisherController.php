<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\PublisherModel;
use App\Models\RegionModel;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class PublisherController extends Controller
{
    public function add_publisher()
    {
//        $this->enter_log('add_region');
        return view('add_publisher');
    }

    public function submit_publisher(Request $request)
    {
        $this->publisher_validation($request);

        $publisher = new PublisherModel();

        $publisher = $this->AssignPublisherValues($request, $publisher);

        $publisher->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Publisher With Id: ' . $publisher->pub_id . ' And Name: ' . $publisher->pub_title);

        // WizardController::updateWizardInfo(['region'], ['area']);

        return redirect('add_publisher')->with('success', 'Successfully Saved');
    }

    public function publisher_validation($request)
    {
        return $this->validate($request, [
            'name' => ['required', 'string', 'unique:financials_publisher,pub_title'],
            'remarks' => ['nullable', 'string'],
        ]);

    }

    protected function AssignPublisherValues($request, $publisher)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $publisher->pub_title = ucwords($request->name);
        $publisher->pub_remarks = ucfirst($request->remarks);
        $publisher->pub_createdby = $user->user_id;
        $publisher->pub_day_end_id = $day_end->de_id;
        $publisher->pub_day_end_date = $day_end->de_datetime;

        // coding from shahzaib start

        $tbl_var_name = 'publisher';
        $prfx = 'pub';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end

        return $publisher;
    }


    public function publisher_list(Request $request, $array = null, $str = null)
    {
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.publisher_list.publisher_list';
        $pge_title = 'Publisher List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_publisher')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_publisher.pub_createdby');

        if (!empty($search)) {
            $query->where('pub_title', 'like', '%' . $search . '%')
                ->orWhere('pub_remarks', 'like', '%' . $search . '%')
                ->orWhere('pub_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
//            $pagination_number = 100000000;
            $query->where('pub_createdby', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1)
        {
            $query->where('pub_delete_status', '=', 1);
        } else {
            $query->where('pub_delete_status', '!=', 1);
        }

        $datas = $query->orderBy('pub_id', 'DESC')
            ->paginate($pagination_number);

        $pub_title = PublisherModel::orderBy('pub_id', config('global_variables.query_sorting'))->pluck('pub_title')->all();//where('pub_delete_status', '!=', 1)->


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
            return view('publisher_list', compact('datas', 'search', 'pub_title', 'search_by_user', 'restore_list'));
        }

    }

//    // update code by shahzaib end
//
//
    public function edit_publisher(Request $request)
    {
        return view('edit_publisher', compact('request'));
    }

    public function update_publisher(Request $request)
    {
        $this->validate($request, [
            'pub_id' => ['required', 'numeric'],
            'name' => ['required', 'string', 'unique:financials_publisher,pub_title,' . $request->pub_id . ',pub_id'],
            'remarks' => ['nullable', 'string'],
        ]);

        $publisher = PublisherModel::where('pub_id', $request->pub_id)->first();
        $publisher = $this->AssignPublisherValues($request, $publisher);

        if ($publisher->save()) {
            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Publisher With Id: ' . $publisher->pub_id . ' And Name: ' . $publisher->pub_title);
            return redirect('publisher_list')->with('success', 'Successfully Saved');
        } else {
            return redirect('publisher_list')->with('fail', 'Failed Try Again!');
        }
    }

    public function delete_publisher (Request $request)
    {

        $user = Auth::User();

        $delete = PublisherModel::where('pub_id', $request->pub_id)->first();

        if ($delete->pub_delete_status == 1) {
            $delete->pub_delete_status = 0;
        } else {
            $delete->pub_delete_status = 1;
        }

        $delete->pub_deleted_by = $user->user_id;

        if ($delete->save()) {

            if ($delete->pub_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Publisher With Id: ' . $delete->pub_id . ' And Name: ' . $delete->pub_title);

//                return redirect('region_list')->with('success', 'Successfully Restored');
                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Publisher With Id: ' . $delete->pub_id . ' And Name: ' . $delete->pub_title);

//                return redirect('region_list')->with('success', 'Successfully Deleted');
                return redirect()->back()->with('success', 'Successfully Deleted');
            }

        } else {
//            return redirect('region_list')->with('fail', 'Failed Try Again!');
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }
    }

}
