<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\CurrencyModel;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Maatwebsite\Excel\Facades\Excel;

class CurrencyController extends Controller
{
    public function add_currency()
    {
//        $this->enter_log('add_region');
        return view('add_currency');
    }

    public function submit_currency(Request $request)
    {
        $this->currency_validation($request);

        $currency = new CurrencyModel();

        $currency = $this->AssignCurrencyValues($request, $currency);

        $currency->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Currency With Id: ' . $currency->cur_id . ' And Name: ' . $currency->cur_title);

        // WizardController::updateWizardInfo(['region'], ['area']);

        return redirect('add_currency')->with('success', 'Successfully Saved');
    }

    public function currency_validation($request)
    {
        return $this->validate($request, [
            'name' => ['required', 'string', 'unique:financials_currency,cur_title'],
            'remarks' => ['nullable', 'string'],
        ]);

    }


    protected function AssignCurrencyValues($request, $currency)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $currency->cur_title = ucwords($request->name);
        $currency->cur_remarks = ucfirst($request->remarks);
        $currency->cur_createdby = $user->user_id;
        $currency->cur_day_end_id = $day_end->de_id;
        $currency->cur_day_end_date = $day_end->de_datetime;

        // coding from shahzaib start

        $tbl_var_name = 'currency';
        $prfx = 'cur';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end

        return $currency;
    }


    public function currency_list(Request $request, $array = null, $str = null)
    {
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.currency_list.currency_list';
        $pge_title = 'Currency List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_currency')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_currency.cur_createdby');

        if (!empty($search)) {
            $query->where('cur_title', 'like', '%' . $search . '%')
                ->orWhere('cur_remarks', 'like', '%' . $search . '%')
                ->orWhere('cur_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
//            $pagination_number = 100000000;
            $query->where('cur_createdby', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1)
        {
            $query->where('cur_delete_status', '=', 1);
        } else {
            $query->where('cur_delete_status', '!=', 1);
        }

        $datas = $query->orderBy('cur_id', 'DESC')
            ->paginate($pagination_number);

        $cur_title = CurrencyModel::orderBy('cur_id', config('global_variables.query_sorting'))->pluck('cur_title')->all();//where('cur_delete_status', '!=', 1)->


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
            return view('currency_list', compact('datas', 'search', 'cur_title', 'search_by_user', 'restore_list'));
        }

    }

//    // update code by shahzaib end
//
//
    public function edit_currency(Request $request)
    {
        return view('edit_currency', compact('request'));
    }

    public function update_currency(Request $request)
    {
        $this->validate($request, [
            'cur_id' => ['required', 'numeric'],
            'name' => ['required', 'string', 'unique:financials_currency,cur_title,' . $request->cur_id . ',cur_id'],
            'remarks' => ['nullable', 'string'],
        ]);

        $currency = CurrencyModel::where('cur_id', $request->cur_id)->first();
        $currency = $this->AssignCurrencyValues($request, $currency);

        if ($currency->save()) {
            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Currency With Id: ' . $currency->cur_id . ' And Name: ' . $currency->cur_title);
            return redirect('currency_list')->with('success', 'Successfully Saved');
        } else {
            return redirect('currency_list')->with('fail', 'Failed Try Again!');
        }
    }

    public function delete_currency (Request $request)
    {

        $user = Auth::User();

        $delete = CurrencyModel::where('cur_id', $request->cur_id)->first();

        if ($delete->cur_delete_status == 1) {
            $delete->cur_delete_status = 0;
        } else {
            $delete->cur_delete_status = 1;
        }

        $delete->cur_deleted_by = $user->user_id;

        if ($delete->save()) {

            if ($delete->cur_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Currency With Id: ' . $delete->cur_id . ' And Name: ' . $delete->cur_title);

//                return redirect('region_list')->with('success', 'Successfully Restored');
                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Currency With Id: ' . $delete->cur_id . ' And Name: ' . $delete->cur_title);

//                return redirect('region_list')->with('success', 'Successfully Deleted');
                return redirect()->back()->with('success', 'Successfully Deleted');
            }

        } else {
//            return redirect('region_list')->with('fail', 'Failed Try Again!');
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }
    }
}
