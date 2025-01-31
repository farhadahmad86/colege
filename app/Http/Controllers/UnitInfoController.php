<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Wizard\WizardController;
use App\Imports\ExcelDataImport;
use App\Models\GroupInfoModel;
use App\Models\MainUnitModel;
use App\Models\ProductModel;
use App\Models\SystemConfigModel;
use App\Models\UnitInfoModel;
use Auth;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class UnitInfoController extends ExcelForm\UnitForm\UnitFormController
{


    public function add_unit()
    {
        $user = Auth::user();
        $main_units = MainUnitModel::where('mu_clg_id', '=', $user->user_clg_id)->where('mu_delete_status', '!=', 1)->where('mu_disabled', '!=', 1)->orderBy('mu_title', 'ASC')->get();
        return view('add_unit', compact('main_units'));
    }

    public function submit_unit_excel(Request $request)
    {

        $rules = [
            'add_create_unit_excel' => 'required|mimes:xlsx,xls,csv|max:5000',
        ];

        $messages = [
            'add_create_unit_excel.max' => "Your File size too long.",
            'add_create_unit_excel.required' => "Please select your Unit Excel Sheet.",
        ];

        $validator = $this->validate($request, $rules, $messages);

        if ($request->hasFile('add_create_unit_excel')) {

//            dd($request->add_employee_excel);
//            $dateTime = date('Ymd_His');
//            $file = $request->file('add_employee_excel');
//            $fileName = $dateTime . '-' . $file->getClientOriginalName();
//            $savePath = public_path('/uploads/'.config('global_variables.excel_storage_folder_name'));
//            $file->move($savePath, $fileName);
//            $data = Excel::load($path)->get();


            $path = $request->file('add_create_unit_excel');
            $data = Excel::toArray(new ExcelDataImport, $path);

            $excelData = json_decode(json_encode($data), FALSE);
            foreach ($data as $key => $value) {
                foreach ($excelData as $rows) {
                    foreach ($rows as $row) {
                        $rowData = (array)$row;
                        $request->merge($rowData);
                        $this->excel_unit_validation($request);

                        $rollBack = self::excel_form_unit($row);

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

    public function submit_unit(Request $request)
    {

        return self::simple_form_unit($request);

//        $this->unit_validation($request);
//
//        $unit = new UnitInfoModel();
//
//        $unit = $this->AssignUnitValues($request, $unit);
//
//        $unit->save();
//
//        $user = Auth::User();
//
//        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Unit With Id: ' . $unit->unit_id . ' And Name: ' . $unit->unit_title);
//
//        // WizardController::updateWizardInfo(['unit'], []);
//
//        return redirect('add_unit')->with('success', 'Successfully Saved');
    }

//    public function unit_validation($request)
//    {
//        return $this->validate($request, [
//            'main_unit' => ['required', 'numeric'],
////            'unit_name' => ['required', 'string', 'unique:financials_units,unit_title,NULL,unit_id,unit_main_unit_id,' . $request->main_unit],
//
////            'unit_name' => ['required', 'string'],
//            'remarks' => ['nullable', 'string'],
//            'allowDecimal' => ['nullable'],
//            'symbol' => ['nullable', 'string'],
//            'scale_size' => ['required', 'string'],
//        ]);
//    }

    protected function AssignUnitValues($request, $unit)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $unit->unit_main_unit_id = $request->main_unit;
        $unit->unit_title = ucwords($request->unit_name);
        $unit->unit_allow_decimal = isset($request->allowDecimal) ? 1 : 0;
        $unit->unit_remarks = ucfirst($request->remarks);
        $unit->unit_symbol = $request->symbol;
        $unit->unit_scale_size = ucwords($request->scale_size);
        $unit->unit_createdby = $user->user_id;
        $unit->unit_clg_id = $user->user_clg_id;
        $unit->unit_day_end_id = $day_end->de_id;
        $unit->unit_day_end_date = $day_end->de_datetime;


        // coding from shahzaib start
        $tbl_var_name = 'unit';
        $prfx = 'unit';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        return $unit;
    }

    public function get_unit(Request $request)
    {
        $user = Auth::user();
        $main_unit_id = $request->main_unit_id;

        $unit_id = $request->unit_id;

        $units = UnitInfoModel::where('unit_clg_id', '=', $user->user_clg_id)->where('unit_delete_status', '!=', 1)->where('unit_disabled', '!=', 1)->where('unit_main_unit_id', $main_unit_id)->orderBy
        ('unit_title',
            'ASC')->get();

        $get_unit = "<option value=''>Select Unit</option>";
        foreach ($units as $unit) {
            $selected = $unit->unit_id == $unit_id ? 'selected' : '';
            $get_unit .= "<option value='$unit->unit_id' data-unit_symbol='$unit->unit_symbol' data-unit_allow_decimal='$unit->unit_allow_decimal' $selected>$unit->unit_scale_size  $unit->unit_title</option>";
        }

        return response()->json($get_unit);
    }


    // update code by shahzaib start
    public function unit_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $main_units = MainUnitModel::where('mu_clg_id', '=',  $user->user_clg_id)->orderBy('mu_title', 'ASC')->get();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_main_unit = (!isset($request->main_unit) && empty($request->main_unit)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->main_unit;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.unit_list.unit_list';
        $pge_title = 'Unit List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_units')
            ->join('financials_main_units', 'financials_main_units.mu_id', '=', 'financials_units.unit_main_unit_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_units.unit_createdby')
            ->where('unit_clg_id', '=',  $user->user_clg_id);

        if (!empty($search)) {
            $query->orWhere('mu_title', 'like', '%' . $search . '%')
                ->orWhere('unit_id', 'like', '%' . $search . '%')
                ->orWhere('unit_title', 'like', '%' . $search . '%')
                ->orWhere('unit_remarks', 'like', '%' . $search . '%')
                ->orWhere('unit_symbol', 'like', '%' . $search . '%')
                ->orWhere('unit_scale_size', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_main_unit)) {
            $query->where('unit_main_unit_id', $search_main_unit);
        }

        if (!empty($search_by_user)) {
            $query->where('unit_createdby', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1) {
            $query->where('unit_delete_status', '=', 1);
        } else {
            $query->where('unit_delete_status', '!=', 1);
        }


        $datas = $query
//            ->where('unit_delete_status', '!=', 1)
            ->orderBy('unit_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

        $unit = UnitInfoModel::
        where('unit_clg_id', '=',  $user->user_clg_id)->
        where('unit_delete_status', '!=', 1)->
        orderBy('unit_title', 'ASC')->pluck('unit_title')->all();


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
            return view('unit_list', compact('datas', 'search', 'unit', 'main_units', 'search_main_unit', 'restore_list'));
        }
    }

    // update code by shahzaib end

    public function edit_unit(Request $request)
    {
        $user = Auth::user();
        $main_units = MainUnitModel::where('mu_clg_id', '=', $user->user_clg_id)->where('mu_delete_status', '!=', 1)->where('mu_disabled', '!=', 1)->orderBy('mu_title', 'ASC')->get();
        return view('edit_unit', compact('request', 'main_units'));
    }

    public function update_unit(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'main_unit' => ['required', 'string'],
            'unit_id' => ['required', 'numeric'],
//            'main_unit_id' => ['required', 'numeric'],
            'unit_name' => ['required', 'string', 'unique:financials_units,unit_title,' . $request->unit_id . ',unit_id,unit_main_unit_id,' . $request->main_unit . ',unit_clg_id,' .
                $user->user_clg_id],
            'remarks' => ['nullable', 'string'],
            'allowDecimal' => ['nullable'],
            'symbol' => ['nullable', 'string'],
            'scale_size' => ['required', 'string'],
        ]);

        $unit = UnitInfoModel::where('unit_clg_id', '=', $user->user_clg_id)->where('unit_id', $request->unit_id)->first();

        $unit->unit_main_unit_id = $request->main_unit;
        $unit->unit_title = ucwords($request->unit_name);
        $unit->unit_remarks = ucfirst($request->remarks);
        $unit->unit_allow_decimal = isset($request->allowDecimal) ? 1 : 0;
        $unit->unit_symbol = $request->symbol;
        $unit->unit_scale_size = ucwords($request->scale_size);


        // coding from shahzaib start
        $tbl_var_name = 'unit';
        $prfx = 'unit';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        if ($unit->save()) {

            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Unit With Id: ' . $unit->unit_id . ' And Name: ' . $unit->unit_title);

            return redirect('unit_list')->with('success', 'Successfully Saved');
        } else {
            return redirect('unit_list')->with('fail', 'Failed Try Again!');
        }
    }

    public function delete_unit(Request $request)
    {
        $user = Auth::User();

        $delete = UnitInfoModel::where('unit_id', $request->unit_id)->first();

//        $delete->unit_delete_status = 1;

        if ($delete->unit_delete_status == 1) {
            $delete->unit_delete_status = 0;
        } else {
            $delete->unit_delete_status = 1;
        }

        $delete->unit_deleted_by = $user->user_id;

        if ($delete->save()) {

            if ($delete->unit_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Unit With Id: ' . $delete->unit_id . ' And Name: ' . $delete->unit_title);

                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Unit With Id: ' . $delete->unit_id . ' And Name: ' . $delete->unit_title);

                return redirect()->back()->with('success', 'Successfully Deleted');
            }

        } else {
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }

    }


}
