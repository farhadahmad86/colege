<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AuthorModel;
use App\Models\ClassModel;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ClassController extends Controller
{
    public function add_class()
    {
        return view('add_class');
    }

    public function submit_class(Request $request)
    {
        $this->class_validation($request);

        $class = new ClassModel();

        $class = $this->AssignClassValues($request, $class);

        $class->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Class With Id: ' . $class->cla_id . ' And Name: ' . $class->cla_title);

        // WizardController::updateWizardInfo(['region'], ['area']);

        return redirect('add_class')->with('success', 'Successfully Saved');
    }

    public function class_validation($request)
    {
        return $this->validate($request, [
            'name' => ['required', 'string', 'unique:financials_class,cla_title'],
            'remarks' => ['nullable', 'string'],
        ]);
    }

    protected function AssignClassValues($request, $class)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $class->cla_title = ucwords($request->name);
        $class->cla_remarks = ucfirst($request->remarks);
        $class->cla_createdby = $user->user_id;
        $class->cla_day_end_id = $day_end->de_id;
        $class->cla_day_end_date = $day_end->de_datetime;

        // coding from shahzaib start

        $tbl_var_name = 'class';
        $prfx = 'cla';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end

        return $class;
    }


    public function class_list(Request $request, $array = null, $str = null)
    {
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.class_list.class_list';
        $pge_title = 'Class List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_class')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_class.cla_createdby');

        if (!empty($search)) {
            $query->where('cla_title', 'like', '%' . $search . '%')
                ->orWhere('cla_remarks', 'like', '%' . $search . '%')
                ->orWhere('cla_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            //            $pagination_number = 100000000;
            $query->where('cla_createdby', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1) {
            $query->where('cla_delete_status', '=', 1);
        } else {
            $query->where('cla_delete_status', '!=', 1);
        }

        $datas = $query->orderBy('cla_id', 'DESC')
            ->paginate($pagination_number);

        $cla_title = ClassModel::orderBy('cla_id', config('global_variables.query_sorting'))->pluck('cla_title')->all(); //where('cla_delete_status', '!=', 1)->


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
            return view('class_list', compact('datas', 'search', 'cla_title', 'search_by_user', 'restore_list'));
        }
    }

    //    // update code by shahzaib end
    //
    //
    public function edit_class(Request $request)
    {
        return view('edit_class', compact('request'));
    }

    public function update_class(Request $request)
    {
        $this->validate($request, [
            'cla_id' => ['required', 'numeric'],
            'name' => ['required', 'string', 'unique:financials_class,cla_title,' . $request->cla_id . ',cla_id'],
            'remarks' => ['nullable', 'string'],
        ]);

        $class = ClassModel::where('cla_id', $request->cla_id)->first();
        $class = $this->AssignClassValues($request, $class);

        if ($class->save()) {
            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Class With Id: ' . $class->cla_id . ' And Name: ' . $class->cla_title);
            return redirect('class_list')->with('success', 'Successfully Saved');
        } else {
            return redirect('class_list')->with('fail', 'Failed Try Again!');
        }
    }

    public function delete_class(Request $request)
    {

        $user = Auth::User();

        $delete = ClassModel::where('cla_id', $request->cla_id)->first();

        if ($delete->cla_delete_status == 1) {
            $delete->cla_delete_status = 0;
        } else {
            $delete->cla_delete_status = 1;
        }

        $delete->cla_deleted_by = $user->user_id;

        if ($delete->save()) {

            if ($delete->cla_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Class With Id: ' . $delete->cla_id . ' And Name: ' . $delete->cla_title);

                //                return redirect('region_list')->with('success', 'Successfully Restored');
                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Class With Id: ' . $delete->cla_id . ' And Name: ' . $delete->cla_title);

                //                return redirect('region_list')->with('success', 'Successfully Deleted');
                return redirect()->back()->with('success', 'Successfully Deleted');
            }
        } else {
            //            return redirect('region_list')->with('fail', 'Failed Try Again!');
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }
    }
}
