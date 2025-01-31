<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Wizard\WizardController;
use App\Imports\ExcelDataImport;
use App\Models\ServicesInvoiceItemsModel;
use App\Models\ServicesModel;
use Auth;
use PDF;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ServicesController extends ExcelForm\ServicesForm\ServicesFormController
{
    public function add_services()
    {
        return view('add_services');
    }

    public function submit_services(Request $request)
    {
        return self::simple_form_services($request);
//        $this->services_validation($request);
//
//        $service = new ServicesModel();
//
//        $service = $this->AssignServicesValues($request, $service);
//
//        $service->save();
//
//        $user = Auth::User();
//
//        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Service With Id: ' . $service->ser_id . ' And Name: ' . $service->ser_title);
//
//        // WizardController::updateWizardInfo(['service'], []);
//
//        return redirect('add_services')->with('success', 'Successfully Saved');
    }

    public function submit_services_excel(Request $request)
    {

        $rules = [
            'add_services_excel' => 'required|mimes:xlsx,xls,csv|max:5000',
        ];

        $messages = [
            'add_services_excel.max' => "Your File size too long.",
            'add_services_excel.required' => "Please select your Brand Excel Sheet.",
        ];

        $validator = $this->validate($request, $rules, $messages);

        if ($request->hasFile('add_services_excel')) {

//            dd($request->add_employee_excel);
//            $dateTime = date('Ymd_His');
//            $file = $request->file('add_employee_excel');
//            $fileName = $dateTime . '-' . $file->getClientOriginalName();
//            $savePath = public_path('/uploads/'.config('global_variables.excel_storage_folder_name'));
//            $file->move($savePath, $fileName);
//            $data = Excel::load($path)->get();



            $path = $request->file('add_services_excel');
            $data = Excel::toArray(new ExcelDataImport, $path);

            $excelData = json_decode (json_encode ($data), FALSE);

            foreach ($excelData as $rows) {
                foreach ($rows as $row) {
                    $rowData = (array) $row;
                    $request->merge($rowData);
                    $this->excel_services_validation($request);

                    $rollBack = self::excel_form_services($row);

                    if ($rollBack) {
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed Try Again');
                    }
                    else {
                        DB::commit();
                    }
                }
            }


            return redirect()->back()->with(['success' => 'File Uploaded successfully.']);
        } else {
            return redirect()->back()->with(['errors' => $validator]);
        }

    }

    public function services_validation($request)
    {
        return $this->validate($request, [
            'service_name' => ['required', 'string', 'unique:financials_services,ser_title'],
            'remarks' => ['nullable', 'string'],
        ]);

    }

    protected function AssignServicesValues($request, $service)
    {
        $user = Auth::User();

        $service->ser_title = ucwords($request->service_name);
        $service->ser_remarks = ucfirst($request->remarks);
        $service->ser_created_by = $user->user_id;
        $service->ser_clg_id = $user->user_clg_id;
        $service->ser_datetime = Carbon::now()->toDateTimeString();

        // coding from shahzaib start
        $tbl_var_name = 'service';
        $prfx = 'ser';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end

        return $service;
    }

    // update code by shahzaib start
    public function services_list(Request $request, $array = null, $str = null)
    {
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.services_list.services_list';
        $pge_title = 'Services List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;
        $user = Auth::User();

        $query = DB::table('financials_services')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_services.ser_created_by')
            ->where('ser_clg_id',$user->user_clg_id);

        if (!empty($request->search)) {
            $query->where('ser_title', 'like', '%' . $search . '%')
                ->orWhere('ser_remarks', 'like', '%' . $search . '%')
                ->orWhere('ser_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('ser_created_by', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1)
        {
            $query->where('ser_delete_status', '=', 1);
        } else {
            $query->where('ser_delete_status', '!=', 1);
        }


        $datas = $query
//            ->where('ser_delete_status', '!=', 1)
            ->orderBy('ser_id', config('global_variables.query_sorting'))->paginate($pagination_number);

        $service_title = ServicesModel::
        where('ser_clg_id',$user->user_clg_id)->
        where('ser_delete_status', '!=', 1)->
        orderBy('ser_id', 'DESC')->pluck('ser_title')->all();


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
            return view('services_list', compact('datas', 'search', 'service_title', 'search_by_user','restore_list'));
        }
    }

    // update code by shahzaib end

    public function edit_services(Request $request)
    {
        return view('edit_services', compact('request'));
    }

    public function update_services(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'service_id' => ['required', 'numeric'],
            'service_name' => ['required', 'string', 'unique:financials_services,ser_title,' . $request->service_id . ',ser_id,'.$user->user_clg_id.',ser_clg_id'],
            'remarks' => ['nullable', 'string'],
        ]);

        $service = ServicesModel::where('ser_clg_id',$user->user_clg_id)->where('ser_id', $request->service_id)->first();

        $service = $this->AssignServicesValues($request, $service);

        if ($service->save()) {

            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Service With Id: ' . $service->ser_id . ' And Name: ' . $service->ser_title);

            return redirect('services_list')->with('success', 'Successfully Saved');
        } else {
            return redirect('services_list')->with('fail', 'Failed Try Again!');
        }
    }

    public function delete_services(Request $request)
    {
        $user = Auth::User();

        $delete = ServicesModel::where('ser_clg_id',$user->user_clg_id)->where('ser_id', $request->service_id)->first();

//        $delete->ser_delete_status = 1;
        if ($delete->ser_delete_status == 1) {
            $delete->ser_delete_status = 0;
        } else {
            $delete->ser_delete_status = 1;
        }
        $delete->ser_deleted_by = $user->user_id;

        if ($delete->save()) {

            if ($delete->ser_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Service With Id: ' . $delete->ser_id . ' And Name: ' . $delete->ser_title);

                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Service With Id: ' . $delete->ser_id . ' And Name: ' . $delete->ser_title);

                return redirect()->back()->with('success', 'Successfully Deleted');
            }

        } else {
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }

    }


}
