<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\ImPrintModel;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Maatwebsite\Excel\Facades\Excel;

class ImPrintController extends Controller
{
    public function add_imPrint()
    {
//        $this->enter_log('add_region');
        return view('add_imprint');
    }

    public function submit_imPrint(Request $request)
    {
        $this->imPrint_validation($request);

        $imPrint = new ImPrintModel();

        $imPrint = $this->AssignImPrintValues($request, $imPrint);

        $imPrint->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ImPrint With Id: ' . $imPrint->imp_id . ' And Name: ' . $imPrint->imp_title);

        // WizardController::updateWizardInfo(['region'], ['area']);

        return redirect('add_imPrint')->with('success', 'Successfully Saved');
    }

    public function imPrint_validation($request)
    {
        return $this->validate($request, [
            'name' => ['required', 'string', 'unique:financials_imprint,imp_title'],
            'remarks' => ['nullable', 'string'],
        ]);

    }


    protected function AssignImPrintValues($request, $imPrint)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $imPrint->imp_title = ucwords($request->name);
        $imPrint->imp_remarks = ucfirst($request->remarks);
        $imPrint->imp_createdby = $user->user_id;
        $imPrint->imp_day_end_id = $day_end->de_id;
        $imPrint->imp_day_end_date = $day_end->de_datetime;

        // coding from shahzaib start

        $tbl_var_name = 'imPrint';
        $prfx = 'imp';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end

        return $imPrint;
    }



    public function imPrint_list(Request $request, $array = null, $str = null)
    {
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.imPrint_list.imPrint_list';
        $pge_title = 'ImPrint List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_imprint')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_imprint.imp_createdby');

        if (!empty($search)) {
            $query->where('imp_title', 'like', '%' . $search . '%')
                ->orWhere('imp_remarks', 'like', '%' . $search . '%')
                ->orWhere('imp_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
//            $pagination_number = 100000000;
            $query->where('imp_createdby', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1)
        {
            $query->where('imp_delete_status', '=', 1);
        } else {
            $query->where('imp_delete_status', '!=', 1);
        }

        $datas = $query->orderBy('imp_id', 'DESC')
            ->paginate($pagination_number);

        $imp_title = ImPrintModel::orderBy('imp_id', config('global_variables.query_sorting'))->pluck('imp_title')->all();//where('imp_delete_status', '!=', 1)->


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
            return view('imPrint_list', compact('datas', 'search', 'imp_title', 'search_by_user', 'restore_list'));
        }

    }

//    // update code by shahzaib end
//
//
    public function edit_imPrint(Request $request)
    {
        return view('edit_imPrint', compact('request'));
    }

    public function update_imPrint(Request $request)
    {
        $this->validate($request, [
            'imp_id' => ['required', 'numeric'],
            'name' => ['required', 'string', 'unique:financials_imprint,imp_title,' . $request->imp_id . ',imp_id'],
            'remarks' => ['nullable', 'string'],
        ]);

        $imPrint = ImPrintModel::where('imp_id', $request->imp_id)->first();
        $imPrint = $this->AssignImPrintValues($request, $imPrint);

        if ($imPrint->save()) {
            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update ImPrint With Id: ' . $imPrint->imp_id . ' And Name: ' . $imPrint->imp_title);
            return redirect('imPrint_list')->with('success', 'Successfully Saved');
        } else {
            return redirect('imPrint_list')->with('fail', 'Failed Try Again!');
        }
    }

    public function delete_imPrint (Request $request)
    {

        $user = Auth::User();

        $delete = ImPrintModel::where('imp_id', $request->imp_id)->first();

        if ($delete->imp_delete_status == 1) {
            $delete->imp_delete_status = 0;
        } else {
            $delete->imp_delete_status = 1;
        }

        $delete->imp_deleted_by = $user->user_id;

        if ($delete->save()) {

            if ($delete->imp_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore ImPrint With Id: ' . $delete->imp_id . ' And Name: ' . $delete->imp_title);

//                return redirect('region_list')->with('success', 'Successfully Restored');
                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete ImPrint With Id: ' . $delete->imp_id . ' And Name: ' . $delete->imp_title);

//                return redirect('region_list')->with('success', 'Successfully Deleted');
                return redirect()->back()->with('success', 'Successfully Deleted');
            }

        } else {
//            return redirect('region_list')->with('fail', 'Failed Try Again!');
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }
    }

}
