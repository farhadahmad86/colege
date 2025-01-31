<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\ClassModel;
use App\Models\LanguageModel;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class LanguageController extends Controller
{
    public function add_language()
    {
        return view('add_language');
    }

    public function submit_language(Request $request)
    {
        $this->language_validation($request);

        $language = new LanguageModel();

        $language = $this->AssignLangugaeValues($request, $language);

        $language->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Language With Id: ' . $language->lan_id . ' And Name: ' . $language->lan_title);

        // WizardController::updateWizardInfo(['region'], ['area']);

        return redirect('add_language')->with('success', 'Successfully Saved');
    }

    public function language_validation($request)
    {
        return $this->validate($request, [
            'name' => ['required', 'string', 'unique:financials_language,lan_title'],
            'remarks' => ['nullable', 'string'],
        ]);

    }

    protected function AssignLangugaeValues($request, $language)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $language->lan_title = ucwords($request->name);
        $language->lan_remarks = ucfirst($request->remarks);
        $language->lan_createdby = $user->user_id;
        $language->lan_day_end_id = $day_end->de_id;
        $language->lan_day_end_date = $day_end->de_datetime;

        // coding from shahzaib start

        $tbl_var_name = 'language';
        $prfx = 'lan';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end

        return $language;
    }


    public function language_list(Request $request, $array = null, $str = null)
    {
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.language_list.language_list';
        $pge_title = 'Class List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_language')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_language.lan_createdby');

        if (!empty($search)) {
            $query->where('lan_title', 'like', '%' . $search . '%')
                ->orWhere('lan_remarks', 'like', '%' . $search . '%')
                ->orWhere('lan_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
//            $pagination_number = 100000000;
            $query->where('lan_createdby', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1)
        {
            $query->where('lan_delete_status', '=', 1);
        } else {
            $query->where('lan_delete_status', '!=', 1);
        }

        $datas = $query->orderBy('lan_id', 'DESC')
            ->paginate($pagination_number);

        $lan_title = LanguageModel::orderBy('lan_id', config('global_variables.query_sorting'))->pluck('lan_title')->all();//where('lan_delete_status', '!=', 1)->


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
            return view('language_list', compact('datas', 'search', 'lan_title', 'search_by_user', 'restore_list'));
        }

    }

//    // update code by shahzaib end
//
//
    public function edit_language(Request $request)
    {
        return view('edit_language', compact('request'));
    }

    public function update_language(Request $request)
    {
        $this->validate($request, [
            'lan_id' => ['required', 'numeric'],
            'name' => ['required', 'string', 'unique:financials_language,lan_title,' . $request->lan_id . ',lan_id'],
            'remarks' => ['nullable', 'string'],
        ]);

        $language = LanguageModel::where('lan_id', $request->lan_id)->first();
        $language = $this->AssignLangugaeValues($request, $language);

        if ($language->save()) {
            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Language With Id: ' . $language->lan_id . ' And Name: ' . $language->lan_title);
            return redirect('language_list')->with('success', 'Successfully Saved');
        } else {
            return redirect('language_list')->with('fail', 'Failed Try Again!');
        }
    }

    public function delete_language (Request $request)
    {

        $user = Auth::User();

        $delete = LanguageModel::where('lan_id', $request->lan_id)->first();

        if ($delete->lan_delete_status == 1) {
            $delete->lan_delete_status = 0;
        } else {
            $delete->lan_delete_status = 1;
        }

        $delete->lan_deleted_by = $user->user_id;

        if ($delete->save()) {

            if ($delete->lan_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Language With Id: ' . $delete->lan_id . ' And Name: ' . $delete->lan_title);

//                return redirect('region_list')->with('success', 'Successfully Restored');
                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Language With Id: ' . $delete->lan_id . ' And Name: ' . $delete->lan_title);

//                return redirect('region_list')->with('success', 'Successfully Deleted');
                return redirect()->back()->with('success', 'Successfully Deleted');
            }

        } else {
//            return redirect('region_list')->with('fail', 'Failed Try Again!');
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }
    }
}
