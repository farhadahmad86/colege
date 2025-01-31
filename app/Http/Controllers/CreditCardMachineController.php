<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Wizard\WizardController;
use App\Imports\ExcelDataImport;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\CreditCardMachineModel;
use App\Models\SaleInvoiceModel;
use Auth;
use PDF;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CreditCardMachineController extends ExcelForm\CreditCardMachineForm\CreditCardMachineController
{

    public function add_credit_card_machine()
    {

//        $banks = AccountRegisterationModel::where('account_delete_status', '!=', 1)->where('account_parent_code', config('global_variables.bank_head'))->orderBy('account_uid', 'ASC')->get();

        $banks = $this->get_fourth_level_account(config('global_variables.bank_head'), 0, 0);

        return view('add_credit_card_machine', compact('banks'));
    }

    public function submit_credit_card_machine_excel(Request $request)
    {

        $rules = [
            'add_credit_card_machine_excel' => 'required|mimes:xlsx,xls,csv|max:5000',
        ];

        $messages = [
            'add_credit_card_machine_excel.max' => "Your File size too long.",
            'add_credit_card_machine_excel.required' => "Please select your Credit Card Machine Excel Sheet.",
        ];

        $validator = $this->validate($request, $rules, $messages);

        if ($request->hasFile('add_credit_card_machine_excel')) {

//            dd($request->add_employee_excel);
//            $dateTime = date('Ymd_His');
//            $file = $request->file('add_employee_excel');
//            $fileName = $dateTime . '-' . $file->getClientOriginalName();
//            $savePath = public_path('/uploads/'.config('global_variables.excel_storage_folder_name'));
//            $file->move($savePath, $fileName);
//            $data = Excel::load($path)->get();


            $path = $request->file('add_credit_card_machine_excel');
            $data = Excel::toArray(new ExcelDataImport, $path);

            $excelData = json_decode(json_encode($data), FALSE);
            foreach ($data as $key => $value) {
                foreach ($excelData as $rows) {
                    foreach ($rows as $row) {
                        $rowData = (array)$row;
                        $request->merge($rowData);
                        $this->excel_credit_card_machine_validation($request);

                        $rollBack = self::excel_form_credit_card_machine($row);

                        if ($rollBack) {
                            DB::rollBack();
                            return redirect()->back()->with('fail', 'Failed Try Again');
                        } else {
                            DB::commit();
                        }
                    }
                }
            }

            return redirect()->back()->with(['success' => 'File Uploaded successfully.']);
        } else {
            return redirect()->back()->with(['errors' => $validator]);
        }

    }

    public function submit_credit_card_machine(Request $request)
    {
        return self::simple_form_credit_card_machine($request);
//        DB::beginTransaction();
//
//        $this->credit_card_machine_validation($request);
//
//        $user = Auth::User();
//        $rollBack = false;
//
//
//        $request->request->add(['account_name' => $request->name]);
//
//
//        ////////////////////////////////////////////////////////////////////////////////////////////
//        ///////////////////////////////////// Bank Service Charges Account /////////////////////////
//        ////////////////////////////////////////////////////////////////////////////////////////////
//
//        $bank_service_charges_parent_code = config('global_variables.bank_service_charges');
//
//        $account_registration_controller = new AccountRegisterationsController();
//
//        $bank_service_charges_account = new AccountRegisterationModel();
//        $bank_service_charges_account = $account_registration_controller->AssignAccountValues($request, $bank_service_charges_account, $bank_service_charges_parent_code, 0, '', ' Service Charges');
//
//        if (!$bank_service_charges_account->save()) {
//            $rollBack = true;
//        }
//
//        $bank_service_charges_account_uid = $bank_service_charges_account->account_uid;
//        $bank_service_charges_account_name = $bank_service_charges_account->account_name;
//
//        $account_balance = new BalancesModel();
//
//        $account_balance = $account_registration_controller->add_balance($account_balance, $bank_service_charges_account_uid, $bank_service_charges_account_name);
//
//        if (!$account_balance->save()) {
//            $rollBack = true;
//        }
//
//        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $bank_service_charges_account_uid . ' And Name: ' . $bank_service_charges_account_name);
//
//        ////////////////////////////////////////////////////////////////////////////////////////////
//        ///////////////////////////////////// Credit Card Machine Account //////////////////////////
//        ////////////////////////////////////////////////////////////////////////////////////////////
//
//        $credit_card_machine_parent_code = config('global_variables.credit_card_accounts_head');
//
//        $account_registration_controller = new AccountRegisterationsController();
//
//        $credit_card_machine_account = new AccountRegisterationModel();
//        $credit_card_machine_account = $account_registration_controller->AssignAccountValues($request, $credit_card_machine_account, $credit_card_machine_parent_code, 0, '', ' Credit Card Machine');
//
//        if (!$credit_card_machine_account->save()) {
//            $rollBack = true;
//        }
//
//        $credit_card_machine_account_uid = $credit_card_machine_account->account_uid;
//        $credit_card_machine_account_name = $credit_card_machine_account->account_name;
//
//        $account_balance = new BalancesModel();
//
//        $account_balance = $account_registration_controller->add_balance($account_balance, $credit_card_machine_account_uid, $credit_card_machine_account_name);
//
//        if (!$account_balance->save()) {
//            $rollBack = true;
//        }
//
//        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Account With Unique Id: ' . $credit_card_machine_account_uid . ' And Name: ' . $credit_card_machine_account_name);
//
//        ////////////////////////////////////////////////////////////////////////////////////////////
//        ///////////////////////////////////// Creat Credit Card Machine ////////////////////////////
//        ////////////////////////////////////////////////////////////////////////////////////////////
//
//        $credit_card_machine = new CreditCardMachineModel();
//
//        $credit_card_machine = $this->AssignCreditCardMachineValues($request, $credit_card_machine, $credit_card_machine_account_uid, $bank_service_charges_account_uid);
//
//        if ($credit_card_machine->save()) {
//
//            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Credit Card Machine With Id: ' . $credit_card_machine->ccm_id . ' And Name: ' .
//                $credit_card_machine->ccm_title);
//        } else {
//            $rollBack = true;
//        }
//
//        if ($rollBack) {
//            DB::rollBack();
//            return redirect()->back()->with('fail', 'Failed Try Again');
//        } else {
//            DB::commit();
//            return redirect()->back()->with('success', 'Successfully Saved');
//        }

    }


    protected function AssignCreditCardMachineValues($request, $credit_card_machine, $credit_card_machine_account_uid, $bank_service_charges_account_uid, $edit = 0)
    {
        $user = Auth::User();

        $credit_card_machine->ccm_title = ucwords($request->name);
        $credit_card_machine->ccm_bank_code = $request->bank;

        if ($edit == 0) {
            $credit_card_machine->ccm_credit_card_account_code = $credit_card_machine_account_uid;
            $credit_card_machine->ccm_service_account_code = $bank_service_charges_account_uid;
        }

        $credit_card_machine->ccm_percentage = $request->percentage;
        $credit_card_machine->ccm_merchant_id = $request->merchant_id;
        $credit_card_machine->ccm_remarks = ucfirst($request->remarks);
        $credit_card_machine->ccm_created_by = $user->user_id;
        $credit_card_machine->ccm_clg_id = $user->user_clg_id;
        $credit_card_machine->ccm_datetime = Carbon::now()->toDateTimeString();


        // coding from shahzaib start
        $tbl_var_name = 'credit_card_machine';
        $prfx = 'ccm';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        return $credit_card_machine;
    }


    // update code by shahzaib start
    public function credit_card_machine_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $banks = $this->get_fourth_level_account(config('global_variables.bank_head'), 0, 0);

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
//        $bank_search = (!isset($request->bank_search) && empty($request->bank_search)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->bank_search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.credit_card_machine_list.credit_card_machine_list';
        $pge_title = 'Credit Card Machine List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_credit_card_machine')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_credit_card_machine.ccm_created_by')
            ->leftJoin('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_credit_card_machine.ccm_bank_code')
            ->where('ccm_clg_id', $user->user_clg_id);

        if (!empty($search)) {
//            $pagination_number = 1000000;
            $query->where('ccm_title', 'like', '%' . $search . '%')
                ->orWhere('account_name', 'like', '%' . $search . '%')
                ->orWhere('ccm_percentage', 'like', '%' . $search . '%')
                ->orWhere('ccm_merchant_id', 'like', '%' . $search . '%')
                ->orWhere('ccm_remarks', 'like', '%' . $search . '%')
                ->orWhere('ccm_id', 'like', '%' . $search . '%');
        }

//        if (!empty($bank_search)) {
////            $pagination_number = 1000000;
//            $query->where('ccm_bank_code', $bank_search);
//        }

        if (!empty($search_by_user)) {
//            $pagination_number = 1000000;
            $query->where('ccm_created_by', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1) {
            $query->where('ccm_delete_status', '=', 1);
        } else {
            $query->where('ccm_delete_status', '!=', 1);
        }


        $datas = $query
//            ->where('ccm_delete_status', '!=', 1)
            ->orderBy('ccm_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

        $ccm_title = CreditCardMachineModel::
        where('ccm_delete_status', '!=', 1)->where('ccm_clg_id',$user->user_clg_id)->
        orderBy('ccm_id', 'DESC')->pluck('ccm_title')->all();


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
            return view('credit_card_machine_list', compact('datas', 'ccm_title', 'banks', 'search', 'search_by_user', 'restore_list'));// 'bank_search',
        }
    }

    // update code by shahzaib end


    public function edit_credit_card_machine(Request $request)
    {
//        $banks = AccountRegisterationModel::where('account_delete_status', '!=', 1)->where('account_parent_code', config('global_variables.bank_head'))->orderBy('account_uid', 'ASC')->get();
$user =Auth::user();
        $banks = $this->get_fourth_level_account(config('global_variables.bank_head'), 0, 0);

        $credit_card_machine = CreditCardMachineModel::where('ccm_clg_id',$user->user_clg_id)->where('ccm_id', $request->id)->first();

        return view('edit_credit_card_machine', compact('credit_card_machine', 'banks'));
    }

    public function update_credit_card_machine(Request $request)
    {
        $user = Auth::User();
        $this->validate($request, [
            'machine_id' => ['required', 'numeric'],
            'name' => ['required', 'string', 'unique:financials_credit_card_machine,ccm_title,' . $request->machine_id . ',ccm_id,reg_clg_id,' . $user->user_clg_id],
            'bank' => ['required', 'numeric', 'unique:financials_credit_card_machine,ccm_bank_code,' . $request->machine_id . ',ccm_id,reg_clg_id,' . $user->user_clg_id],
            'percentage' => ['required', 'numeric'],
            'merchant_id' => ['required', 'string'],
            'remarks' => ['nullable', 'string'],
        ]);

        $credit_card_machine = CreditCardMachineModel::where('ccm_id', $request->machine_id)->first();

        $credit_card_machine = $this->AssignCreditCardMachineValues($request, $credit_card_machine, 0, 0, 1);

        if ($credit_card_machine->save()) {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Credit Card Machine With Id: ' . $credit_card_machine->ccm_id . ' And Name: ' .
                $credit_card_machine->ccm_title);

            return redirect('credit_card_machine_list')->with('success', 'Successfully Saved');
        } else {
            return redirect('credit_card_machine_list')->with('fail', 'Failed Try Again!');
        }
    }

    public function delete_credit_card_machine(Request $request)
    {
        $user = Auth::User();

        $delete = CreditCardMachineModel::where('ccm_clg_id',$user->user_clg_id)->where('ccm_id', $request->machine_id)->first();

//        $delete->ccm_delete_status = 1;

        if ($delete->ccm_delete_status == 1) {
            $delete->ccm_delete_status = 0;
        } else {
            $delete->ccm_delete_status = 1;
        }

        $delete->ccm_deleted_by = $user->user_id;

        if ($delete->save()) {

            if ($delete->ccm_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Credit Card Machine With Id: ' . $delete->ccm_id . ' And Name: ' . $delete->ccm_title);

                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Credit Card Machine With Id: ' . $delete->ccm_id . ' And Name: ' . $delete->ccm_title);

                return redirect()->back()->with('success', 'Successfully Deleted');
            }


        } else {
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }


    }


}
