<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Wizard\WizardController;
use App\Imports\ExcelDataImport;
use App\Models\AccountGroupModel;
use App\Models\AccountRegisterationModel;
use App\Models\SystemConfigModel;
use Auth;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AccountGroupController extends ExcelForm\GroupAccountForm\AccountGroupController
{
    public function add_account_group()
    {
        // WizardController::updateWizardInfo(['reporting_group'], ['product_reporting_group']);
        return view('add_account_group');
    }

    public function submit_account_group_excel(Request $request)
    {
        $rules = [
            'add_create_account_group_pattern_excel' => 'required|mimes:xlsx,xls,csv|max:5000',
        ];

        $messages = [
            'add_create_account_group_pattern_excel.max' => "Your File size too long.",
            'add_create_account_group_pattern_excel.required' => "Please select your Group Account Excel Sheet.",
        ];

        $validator = $this->validate($request, $rules, $messages);

        if ($request->hasFile('add_create_account_group_pattern_excel')) {

//            dd($request->add_employee_excel);
//            $dateTime = date('Ymd_His');
//            $file = $request->file('add_employee_excel');
//            $fileName = $dateTime . '-' . $file->getClientOriginalName();
//            $savePath = public_path('/uploads/'.config('global_variables.excel_storage_folder_name'));
//            $file->move($savePath, $fileName);
//            $data = Excel::load($path)->get();

            $path = $request->file('add_create_account_group_pattern_excel');
            $data = Excel::toArray(new ExcelDataImport, $path);

            $excelData = json_decode(json_encode($data), FALSE);

            foreach ($excelData as $rows) {
                foreach ($rows as $row) {
                    $rowData = (array)$row;
                    $request->merge($rowData);
                    $this->excel_account_group_validation($request);

                    $rollBack = self::excel_form_account_group($row);

                    if ($rollBack) {
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed Try Again');
                    } else {
                        DB::commit();
                    }
                }
            }


            return redirect()->back()->with(['success' => 'File Uploaded successfully.']);
        } else {
            return redirect()->back()->with(['errors' => $validator]);
        }

    }

    public function submit_account_group(Request $request)
    {
        return self::simple_form_account_group($request);

//        $this->account_group_validation($request);
//
//        $group = new AccountGroupModel();
//
//        $group = $this->AssignAccountGroupValues($request, $group);
//
//        $group->save();
//
//        $user = Auth::User();
//
//        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Reporting Group With Id: ' . $group->ag_id . ' And Name: ' . $group->ag_title);
//
////        WizardController::updateWizardInfo(['reporting_group'], ['product_reporting_group']);
//
//        return redirect('add_account_group')->with('success', 'Successfully Saved');
    }


    // update code by shahzaib start
    public function account_group_list(Request $request, $array = null, $str = null)
    {
$user = Auth::user();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.account_group_list.account_group_list';
        $pge_title = 'Account Viewing Group List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_account_group')
            ->where('ag_clg_id',$user->user_clg_id)
            ->leftJoin('financials_users', 'financials_users.user_id', '=', 'financials_account_group.ag_created_by');

        if (!empty($search)) {
//            $pagination_number = 1000000;
            $query->where('ag_title', 'like', '%' . $search . '%')
                ->orWhere('ag_remarks', 'like', '%' . $search . '%')
                ->orWhere('ag_id', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
//            $pagination_number = 1000000;
            $query->where('ag_created_by', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1) {
            $query->where('ag_delete_status', '=', 1);
        } else {
            $query->where('ag_delete_status', '!=', 1);
        }


        $datas = $query
//            ->where('ag_delete_status', '!=', 1)
            ->orderBy('ag_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

        $account_group = AccountGroupModel::
        where('ag_clg_id',$user->user_clg_id)->
        where('ag_delete_status', '!=', 1)->
        orderBy('ag_title', 'ASC')->pluck('ag_title')->all();


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = stream_context_create([
                'ssl'=>[
                    'verify_peer'=>FALSE,
                    'verify_peer_name'=>FALSE,
                    'allow_self_signed'=>TRUE,
                ]
            ]);
            $optionss =[
                'footer-html' => $footer,
                'header-html' => $header,
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled'=>true, 'isRemoteEnabled'=>true]);
            $pdf->getDomPDF()->setHttpContext($options,$optionss);
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
            return view('account_group_list', compact('datas', 'account_group', 'search', 'search_by_user', 'restore_list'));
        }
    }

    // update code by shahzaib end


    public function edit_account_group(Request $request)
    {
        return view('edit_account_group', compact('request'));
    }

    public function update_account_group(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'group_id' => ['required', 'numeric'],
            'group_name' => ['required', 'string', 'unique:financials_account_group,ag_title,' . $request->group_id . ',ag_id'.',ag_clg_id,' . $user->user_clg_id],
            'remarks' => ['nullable', 'string'],
        ]);

        $group = AccountGroupModel:: where('ag_clg_id',$user->user_clg_id)->where('ag_id', $request->group_id)->first();

        $group = $this->AssignAccountGroupValues($request, $group);

        if ($group->save()) {

            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Reporting Group With Id: ' . $group->ag_id . ' And Name: ' . $group->ag_title);

            return redirect('account_group_list')->with('success', 'Successfully Saved');
        } else {
            return redirect('account_group_list')->with('fail', 'Failed Try Again!');
        }
    }

    public function delete_account_group(Request $request)
    {
        $user = Auth::User();

        $delete = AccountGroupModel::where('ag_clg_id',$user->user_clg_id)->where('ag_id', $request->group_id)->first();

//        $delete->ag_delete_status = 1;
        if ($delete->ag_delete_status == 1) {
            $delete->ag_delete_status = 0;
        } else {
            $delete->ag_delete_status = 1;
        }

        $delete->ag_deleted_by = $user->user_id;

        if ($delete->save()) {

            if ($delete->ag_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Reporting Group With Id: ' . $delete->ag_id . ' And Name: ' . $delete->ag_title);
                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Reporting Group With Id: ' . $delete->ag_id . ' And Name: ' . $delete->ag_title);

                return redirect()->back()->with('success', 'Successfully Deleted');
            }

        } else {
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }

    }
}
