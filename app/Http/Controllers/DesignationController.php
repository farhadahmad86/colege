<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Models\Designation;
use App\Models\DesignationModel;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DesignationController extends Controller
{


    public function add_desig()
    {
        //        $this->enter_log('add_desig');
        return view('add_desig');
    }



    public function submit_desig(Request $request)
    {
        // dd($request->all());
        $this->designation_validation($request);

        $designation = new DesignationModel();

        $designation = $this->AssignDesignationValues($request, $designation);

        $designation->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Designation With Id: ' . $designation->desig_id . ' And Name: ' . $designation->desig_name);

        // WizardController::updateWizardInfo(['region'], ['area']);

        return redirect('desig_list')->with('success', 'Successfully Saved');
    }
    protected function AssignDesignationValues($request, $designation)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $designation->desig_name = ucwords($request->desig_name);
        $designation->desig_remarks = ucfirst($request->remarks);
        $designation->desig_createdby = $user->user_id;
        $designation->desig_day_end_id = $day_end->de_id;
        $designation->desig_day_end_date = $day_end->de_datetime;
        $designation->desig_clg_id = $user->user_clg_id;
        $designation->desig_year_id = $this->getYearEndId();

        // coding from shahzaib start
        $tbl_var_name = 'designation';
        $prfx = 'desig';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        return $designation;
    }
    public function designation_validation($request)
    {
        $user = Auth::User();
        return $this->validate($request, [
            'desig_name' => ['required', 'string', 'unique:financials_designation,desig_name,null,null,desig_clg_id,' . $user->user_clg_id],
            'remarks' => ['nullable', 'string'],
        ]);
    }

    // update code by shahzaib start
    public function desig_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.designation_list.designation_list';
        $pge_title = 'Designation List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_designation')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_designation.desig_createdby')
            ->where('desig_id', '!=', 1)
            ->where('desig_clg_id', $user->user_clg_id);

        if (!empty($search)) {
            $query->where('desig_name', 'like', '%' . $search . '%')
                ->orWhere('desig_remarks', 'like', '%' . $search . '%')
                ->orWhere('desig_id', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {

            $query->where('desig_createdby', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1) {
            $query->where('desig_delete_status', '=', 1);
        } else {
            $query->where('desig_delete_status', '!=', 1);
        }

        $datas = $query->orderBy('desig_id', 'DESC')
            ->paginate($pagination_number);

        $desig_title = DesignationModel::where('desig_id', '!=', 1)->orderBy('desig_id', config('global_variables.query_sorting'))->pluck('desig_name')->all(); //where('desig_delete_status', '!=',
        // 1)->


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
            return view('desig_list', compact('datas', 'search', 'desig_title', 'search_by_user', 'restore_list'));
        }
    }

    // update code by shahzaib end


    public function edit_desig(Request $request)
    {
        return view('edit_desig', compact('request'));
    }

    public function update_desig(Request $request)
    {
        $user = Auth::User();
        $this->validate($request, [
            'desig_id' => ['required', 'numeric'],
            'desig_name' => ['required', 'string', 'unique:financials_designation,desig_name,' . $request->desig_id . ',desig_id' . ',desig_clg_id,' . $user->user_clg_id],
            'remarks' => ['nullable', 'string'],
        ]);

        $desig = DesignationModel::where('desig_id', $request->desig_id)->first();

        $desig = $this->AssignDesignationValues($request, $desig);

        if ($desig->save()) {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Designation With Id: ' . $desig->desig_id . ' And Name: ' . $desig->desig_name);
            return redirect('desig_list')->with('success', 'Successfully Saved');
        } else {
            return redirect('desig_list')->with('fail', 'Failed Try Again!');
        }
    }

    public function delete_desig(Request $request)
    {
        $user = Auth::User();
        $delete = DesignationModel::where('desig_id', $request->des_id)->first();

        if ($delete->desig_delete_status == 1) {
            $delete->desig_delete_status = 0;
        } else {
            $delete->desig_delete_status = 1;
        }

        $delete->desig_deleted_by = $user->user_id;

        if ($delete->save()) {

            if ($delete->desig_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Designation With Id: ' . $delete->desig_id . ' And Name: ' . $delete->desig_name);

                //                return redirect('desig_list')->with('success', 'Successfully Restored');
                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Designation With Id: ' . $delete->desig_id . ' And Name: ' . $delete->desig_name);

                //                return redirect('desig_list')->with('success', 'Successfully Deleted');
                return redirect()->back()->with('success', 'Successfully Deleted');
            }
        } else {
            //            return redirect('desig_list')->with('fail', 'Failed Try Again!');
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }
    }
}
