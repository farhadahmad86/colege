<?php

namespace App\Http\Controllers;

use App\Models\IllustratedModel;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class IllustratedController extends Controller
{
    public function add_illustrated()
    {
        return view('add_illustrated');
    }

    public function submit_illustrated(Request $request)
    {
        $this->illustrated_validation($request);

        $illustrated = new IllustratedModel();

        $illustrated = $this->AssignIllustratedValues($request, $illustrated);

        $illustrated->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Illustrated With Id: ' . $illustrated->ill_id . ' And Name: ' . $illustrated->ill_title);

        // WizardController::updateWizardInfo(['illustrated'], ['area']);

        return redirect('add_illustrated')->with('success', 'Successfully Saved');
    }

    public function illustrated_validation($request)
    {
        return $this->validate($request, [
            'name' => ['required', 'string', 'unique:financials_illustrated,ill_title'],
            'remarks' => ['nullable', 'string'],
        ]);

    }

    protected function AssignIllustratedValues($request, $illustrated)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $illustrated->ill_title = ucwords($request->name);
        $illustrated->ill_remarks = ucfirst($request->remarks);
        $illustrated->ill_createdby = $user->user_id;
        $illustrated->ill_day_end_id = $day_end->de_id;
        $illustrated->ill_day_end_date = $day_end->de_datetime;

        // coding from shahzaib start
        $tbl_var_name = 'illustrated';
        $prfx = 'ill';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        return $illustrated;
    }


    // update code by shahzaib start
    public function illustrated_list(Request $request, $array = null, $str = null)
    {
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.illustrated_list.illustrated_list';
        $pge_title = 'Illustrated List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_illustrated')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_illustrated.ill_createdby');

        if (!empty($search)) {
            $query->where('ill_title', 'like', '%' . $search . '%')
                ->orWhere('ill_remarks', 'like', '%' . $search . '%')
                ->orWhere('ill_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
//            $pagination_number = 100000000;
            $query->where('ill_createdby', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1)
        {
            $query->where('ill_delete_status', '=', 1);
        } else {
            $query->where('ill_delete_status', '!=', 1);
        }

        $datas = $query->orderBy('ill_id', 'DESC')
            ->paginate($pagination_number);

        $ill_title = IllustratedModel::orderBy('ill_id', config('global_variables.query_sorting'))->pluck('ill_title')->all();//where('ill_delete_status', '!=', 1)->


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
            return view('illustrated_list', compact('datas', 'search', 'ill_title', 'search_by_user', 'restore_list'));
        }

    }

    // update code by shahzaib end


    public function edit_illustrated(Request $request)
    {
        return view('edit_illustrated', compact('request'));
    }

    public function update_illustrated(Request $request)
    {
        $this->validate($request, [
            'illustrated_id' => ['required', 'numeric'],
            'name' => ['required', 'string', 'unique:financials_illustrated,ill_title,' . $request->illustrated_id . ',ill_id'],
            'remarks' => ['nullable', 'string'],
        ]);

        $illustrated = IllustratedModel::where('ill_id', $request->illustrated_id)->first();

        $illustrated = $this->AssignIllustratedValues($request, $illustrated);

        if ($illustrated->save()) {

            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Illustrated With Id: ' . $illustrated->ill_id . ' And Name: ' . $illustrated->ill_title);
            return redirect('illustrated_list')->with('success', 'Successfully Saved');
        } else {
            return redirect('illustrated_list')->with('fail', 'Failed Try Again!');
        }
    }

    public function delete_illustrated(Request $request)
    {
        $user = Auth::User();

        $delete = IllustratedModel::where('ill_id', $request->ill_id)->first();

        if ($delete->ill_delete_status == 1) {
            $delete->ill_delete_status = 0;
        } else {
            $delete->ill_delete_status = 1;
        }

        $delete->ill_deleted_by = $user->user_id;

        if ($delete->save()) {

            if ($delete->ill_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Illustrated With Id: ' . $delete->ill_id . ' And Name: ' . $delete->ill_title);

                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Illustrated With Id: ' . $delete->ill_id . ' And Name: ' . $delete->ill_title);

                return redirect()->back()->with('success', 'Successfully Deleted');
            }

        } else {
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }
    }
}
