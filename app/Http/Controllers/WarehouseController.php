<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Wizard\WizardController;
use App\Imports\ExcelDataImport;
use App\Models\PurchaseInvoiceModel;
use App\Models\SystemConfigModel;
use App\Models\WarehouseModel;
use App\Models\WarehouseStockModel;
use Auth;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class WarehouseController extends ExcelForm\WarehouseForm\WarehouseController
{

    public function add_warehouse()
    {
        // WizardController::updateWizardInfo(['warehouse'], [/*'organization_department',*/ 'parent_account_1', 'group', 'service', 'bank_account', 'region', 'group_account', 'parent_account', 'entry_account', 'fixed_account', 'expense_account', 'asset_parent_account', 'expense_group_account', 'asset_registration', 'second_head', 'capital_registration']);
        return view('add_warehouse');
    }

    public function submit_warehouse_excel(Request $request)
    {

        $rules = [
            'add_create_warehouse_excel' => 'required|mimes:xlsx,xls,csv|max:5000',
        ];

        $messages = [
            'add_create_warehouse_excel.max' => "Your File size too long.",
            'add_create_warehouse_excel.required' => "Please select your Warehouse Excel Sheet.",
        ];

        $validator = $this->validate($request, $rules, $messages);

        if ($request->hasFile('add_create_warehouse_excel')) {

//            dd($request->add_employee_excel);
//            $dateTime = date('Ymd_His');
//            $file = $request->file('add_employee_excel');
//            $fileName = $dateTime . '-' . $file->getClientOriginalName();
//            $savePath = public_path('/uploads/'.config('global_variables.excel_storage_folder_name'));
//            $file->move($savePath, $fileName);
//            $data = Excel::load($path)->get();


            $path = $request->file('add_create_warehouse_excel');
            $data = Excel::toArray(new ExcelDataImport, $path);

            $excelData = json_decode(json_encode($data), FALSE);
            foreach ($data as $key => $value) {
                foreach ($excelData as $rows) {
                    foreach ($rows as $row) {
                        $rowData = (array)$row;
                        $request->merge($rowData);
                        $this->excel_warehouse_validation($request);

                        $rollBack = self::excel_form_warehouse($row);

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

    public function submit_warehouse(Request $request)
    {
        return self::simple_form_warehouse($request);
//        $this->warehouse_validation($request);
//
//        $warehouse = new WarehouseModel();
//
//        $warehouse = $this->AssignWarehouseValues($request, $warehouse);
//
//        $warehouse->save();
//
//        $user = Auth::User();
//
//        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Warehouse With Id: ' . $warehouse->wh_id . ' And Name: ' . $warehouse->wh_title);
//
//        return redirect('add_warehouse')->with('success', 'Successfully Saved');
    }


    // update code by shahzaib start
    public function warehouse_list(Request $request, $array = null, $str = null)
    {
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.warehouse_list.warehouse_list';
        $pge_title = 'Warehouse List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $user = Auth::user();
        $query = DB::table('financials_warehouse')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_warehouse.wh_created_by')
            ->where('wh_clg_id', '=', $user->user_clg_id);

        if (!empty($search)) {
            $query->where('wh_title', 'like', '%' . $search . '%')
                ->orWhere('wh_remarks', 'like', '%' . $search . '%')
                ->orWhere('wh_id', 'like', '%' . $search . '%')
                ->orWhere('wh_address', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
//            $pagination_number = 1000000;
            $query->where('wh_created_by', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1) {
            $query->where('wh_delete_status', '=', 1);
        } else {
            $query->where('wh_delete_status', '!=', 1);
        }


        $datas = $query
//            ->where('wh_delete_status', '!=', 1)
            ->orderBy('wh_id', config('global_variables.query_sorting'))->paginate($pagination_number);

        $warehouse_title = WarehouseModel::
        where('wh_delete_status', '!=', 1)->where('wh_clg_id', '=', $user->user_clg_id)
        ->orderBy('wh_id', 'DESC')->pluck('wh_title')->all();


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
            return view('warehouse_list', compact('datas', 'search', 'warehouse_title', 'restore_list'));
        }
    }

    // update code by shahzaib end


    public function edit_warehouse(Request $request)
    {
        return view('edit_warehouse', compact('request'));
    }

    public function update_warehouse(Request $request)
    {
        $user = Auth::User();
        $this->validate($request, [
            'warehouse_id' => ['required', 'numeric'],
            'warehouse_name' => ['required', 'string', 'unique:financials_warehouse,wh_title,' . $request->warehouse_id . ',wh_id,wh_clg_id,' . $user->user_clg_id],
            'remarks' => ['nullable', 'string'],
        ]);

        $warehouse = WarehouseModel::where('wh_id', $request->warehouse_id)->first();

        $warehouse = $this->AssignWarehouseValues($request, $warehouse);

        if ($warehouse->save()) {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Warehouse With Id: ' . $warehouse->wh_id . ' And Name: ' . $warehouse->wh_title);

            return redirect('warehouse_list')->with('success', 'Successfully Saved');
        } else {
            return redirect('warehouse_list')->with('fail', 'Failed Try Again!');
        }
    }

    public function delete_warehouse(Request $request)
    {
        $user = Auth::User();

        $delete = WarehouseModel::where('wh_clg_id', $user->user_clg_id)->where('wh_id', $request->warehouse_id)->first();

//        $delete->wh_delete_status = 1;
        if ($delete->wh_delete_status == 1) {
            $delete->wh_delete_status = 0;
        } else {
            $delete->wh_delete_status = 1;
        }
        $delete->wh_deleted_by = $user->user_id;

        if ($delete->save()) {
            if ($delete->wh_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Warehouse With Id: ' . $delete->wh_id . ' And Name: ' . $delete->wh_title);

                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Warehouse With Id: ' . $delete->wh_id . ' And Name: ' . $delete->wh_title);

                return redirect()->back()->with('success', 'Successfully Deleted');
            }

        } else {
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }
    }
}
