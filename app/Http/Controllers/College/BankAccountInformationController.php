<?php

namespace App\Http\Controllers\College;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DayEndController;
use App\Models\College\BankAccountModel;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class BankAccountInformationController extends Controller
{

    public function add_bank_account_info()
    {
        return view('collegeViews.bank_account_information.create_bank_account_info');
    }

    public function submit_bank_account_info(Request $request)
    {
        $user = Auth::User();;
        DB::transaction(function () use ($request, $user) {
            $this->bank_account_validation($request);

            $bank_info = new BankAccountModel();

            $bank_info = $this->AssignBankValues($request, $bank_info);

            $bank_info->save();



            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Bank With Id: ' . $bank_info->bi_id . ' And Name: ' . $bank_info->bi_bank_name);
        });
        // WizardController::updateWizardInfo(['area'], ['sector']);
        return redirect()->back()->with('success', 'Successfully Saved!');
        //        return redirect('add_area')->with('success', 'Successfully Saved');


    }

    // update code by shahzaib start
    public function bank_account_info_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_year = (!isset($request->year) && empty($request->year)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->year;
        $search_account_no = (!isset($request->account) && empty($request->account)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->account;
        $search_branch_code = (!isset($request->branch_code) && empty($request->branch_code)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->branch_code;
        $search_bank_name = (!isset($request->bank_name) && empty($request->bank_name)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->bank_name;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.college.information_pdf.bank_info_list';
        $pge_title = 'Bank Info List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_account_no, $search_branch_code,$search_year, $search_bank_name, $search_by_user);


        $pagination_number = (empty($ar) || !empty($ar)) ? 30 : 100000000;

        $query = BankAccountModel::where('bi_clg_id', '=', $user->user_clg_id);


        if (!empty($search)) {

            $pagination_number = 1000000;
            $query->orWhere('bi_id', 'like', '%' . $search . '%')
                ->orWhere('bi_bank_name', 'like', '%' . $search . '%')
                ->orWhere('bi_account_no', 'like', '%' . $search . '%')
                ->orWhere('bi_branch_code', 'like', '%' . $search . '%');
        }

        if (!empty($search_account_no)) {
            $query->where('bi_account_no', '=', $search_account_no);
        }
        if (!empty($search_branch_code)) {
            $query->where('bi_branch_code', '=', $search_branch_code);
        }
        if (!empty($search_bank_name)) {
            $query->where('bi_bank_name', '=', $search_bank_name);
        }
        if (!empty($search_by_user)) {
            $query->where('bi_createdby', '=', $search_by_user);
        }
        if (!empty($search_year)) {
            $query->where('bi_year_id', '=', $search_year);
        } else {
            $search_year = $this->getYearEndId();
            $query->where('bi_year_id', '=', $search_year);
        }
        $datas = $query->orderBy('bi_id', 'ASC')
            ->paginate($pagination_number);
        $branch_information_title = BankAccountModel::where('bi_clg_id', '=', $user->user_clg_id)->orderBy('bi_id', config('global_variables.query_sorting'))->pluck('bi_bank_name')->all();


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
            return view('collegeViews.bank_account_information.bank_account_info_list', compact('datas','search_year', 'search', 'branch_information_title', 'search_account_no', 'search_branch_code', 'search_bank_name', 'user'));
        }
    }

    // update code by shahzaib end


    public function edit_bank_account_info(Request $request)
    {

        return view('collegeViews.bank_account_information.edit_bank_account_info', compact('request'));
    }

    public function update_bank_account_info(Request $request)
    {
        // dd($request->all());
        $user = Auth::User();
        DB::transaction(function () use ($request, $user) {
            $this->bank_account_validation($request);

            $bank_info = BankAccountModel::where('bi_id', $request->bi_id)->first();

            $bank_info = $this->AssignBankValues($request, $bank_info);

            $bank_info->save();



            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Bank With Id: ' . $bank_info->bi_id . ' And Name: ' . $bank_info->bi_bank_name);
        });
        // WizardController::updateWizardInfo(['area'], ['sector']);
        return redirect()->route('bank_account_info_list')->with('success', 'Successfully Saved!');
    }

    public function delete_bank_account_info(Request $request)
    {
        $user = Auth::User();
        $delete = AreaModel::where('area_clg_id', '=', $user->user_clg_id)->where('area_id', $request->area_id)->first();


        if ($delete->area_delete_status == 1) {
            $delete->area_delete_status = 0;
        } else {
            $delete->area_delete_status = 1;
        }

        $delete->area_deleted_by = $user->user_id;

        if ($delete->save()) {

            if ($delete->area_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Area With Id: ' . $delete->area_id . ' And Name: ' . $delete->area_title);

                //                return redirect('area_list')->with('success', 'Successfully Restored');
                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Area With Id: ' . $delete->area_id . ' And Name: ' . $delete->area_title);

                //                return redirect('area_list')->with('success', 'Successfully Deleted');
                return redirect()->back()->with('success', 'Successfully Deleted');
            }

            //            return redirect('area_list')->with('success', 'Successfully Saved');
            return redirect()->back()->with('success', 'Successfully Saved');
        } else {
            //            return redirect('area_list')->with('fail', 'Failed Try Again!');
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }
    }


    public function bank_account_validation($request)
    {
        $user = Auth::User();
        return $this->validate($request, [
            'bank_name' => ['required', 'string'],
            'account' => ['required', 'string', 'unique:bank_information,bi_account_no,NULL,bi_id,bi_clg_id,' . $user->user_clg_id],
            'branch_code' => ['required', 'string'],
            'account_title' => ['required', 'string'],
        ]);
    }

    protected function AssignBankValues($request, $bank_info)
    {
        $user = Auth::User();
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $bank_info->bi_bank_name = $request->bank_name;
        $bank_info->bi_branch_code = $request->branch_code;
        $bank_info->bi_account_no = $request->account;
        $bank_info->bi_account_title = $request->account_title;
        $bank_info->bi_createdby = $user->user_id;
        $bank_info->bi_clg_id = $user->user_clg_id;
        $bank_info->bi_branch_id = Session::get('branch_id');
        $bank_info->bi_brwsr_info = $brwsr_rslt;
        $bank_info->bi_ip_adrs = $ip_rslt;
        $bank_info->bi_datetime = Carbon::now()->toDateTimeString();
        $bank_info->bi_year_id = $this->getYearEndId();

        return $bank_info;
    }
}
