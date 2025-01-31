<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Wizard\WizardController;
use App\Imports\ExcelDataImport;
use App\Models\MainUnitModel;
use App\Models\SystemConfigModel;
use App\Models\UnitInfoModel;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class MainUnitController extends ExcelForm\MainUnitForm\MainUnitController
{
    public function add_main_unit()
    {
        return view('add_main_unit');
    }

    public function submit_main_unit_excel(Request $request)
    {
        $rules = [
            'add_main_unit_excel' => 'required|mimes:xlsx,xls,csv|max:5000',
        ];

        $messages = [
            'add_main_unit_excel.max' => "Your File size too long.",
            'add_main_unit_excel.required' => "Please select your Main Unit Excel Sheet.",
        ];

        $validator = $this->validate($request, $rules, $messages);

        if ($request->hasFile('add_main_unit_excel')) {

//            dd($request->add_employee_excel);
//            $dateTime = date('Ymd_His');
//            $file = $request->file('add_employee_excel');
//            $fileName = $dateTime . '-' . $file->getClientOriginalName();
//            $savePath = public_path('/uploads/'.config('global_variables.excel_storage_folder_name'));
//            $file->move($savePath, $fileName);
//            $data = Excel::load($path)->get();



            $path = $request->file('add_main_unit_excel');
            $data = Excel::toArray(new ExcelDataImport, $path);

            $excelData = json_decode (json_encode ($data), FALSE);
//            foreach ($data as $key => $value) {
                foreach ($excelData as $rows) {
                    foreach ($rows as $row) {
                        $rowData = (array) $row;
                        $request->merge($rowData);
                        $this->excel_main_unit_validation($request);

                        $rollBack = self::excel_form_main_unit($row);

                        if ($rollBack) {
                            DB::rollBack();
                            return redirect()->back()->with('fail', 'Failed Try Again');
                        }
                        else {
                            DB::commit();
                        }
                    }
//                }
            }

            return redirect()->back()->with(['success' => 'File Uploaded successfully.']);
        } else {
            return redirect()->back()->with(['errors' => $validator]);
        }


    }

    public function submit_main_unit(Request $request)
    {
        return self::simple_form_main_unit($request);
//        $this->main_unit_validation($request);
//
//        $main_unit = new MainUnitModel();
//
//        $main_unit = $this->AssignMainUnitValues($request, $main_unit);
//
//        $main_unit->save();
//
//        $user = Auth::User();
//
//        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Main Unit With Id: ' . $main_unit->mu_id . ' And Name: ' . $main_unit->mu_title);
//
//        // WizardController::updateWizardInfo(['main_unit'], ['unit']);
//
//        return redirect('add_main_unit')->with('success', 'Successfully Saved');
    }


    // update code by shahzaib start
    public function main_unit_list(Request $request, $array = null, $str = null)
    {
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.main_unit_list.main_unit_list';
        $pge_title = 'Main Unit List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;
        $user=Auth::user();

        $query = DB::table('financials_main_units')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_main_units.mu_created_by')
            ->where('mu_clg_id', $user->user_clg_id);

        if (!empty($search)) {
            $query->where('mu_title', 'like', '%' . $search . '%')
                ->orWhere('mu_remarks', 'like', '%' . $search . '%')
                ->orWhere('mu_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('mu_created_by', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1)
        {
            $query->where('mu_delete_status', '=', 1);
        } else {
            $query->where('mu_delete_status', '!=', 1);
        }

        $datas = $query
//            ->where('mu_delete_status', '!=', 1)
            ->orderBy('mu_id', 'DESC')
            ->paginate($pagination_number);

        $main_unit = MainUnitModel::
            where('mu_clg_id', $user->user_clg_id)->
        where('mu_delete_status', '!=', 1)->
        orderBy('mu_title', 'ASC')->pluck('mu_title')->all();

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
            return view('main_unit_list', compact('datas', 'search', 'main_unit','restore_list'));
        }
    }

    // update code by shahzaib end


    public function edit_main_unit(Request $request)
    {
        return view('edit_main_unit', compact('request'));
    }

    public function update_main_unit(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'unit_id' => ['required', 'numeric'],
            'name' => ['required', 'string', 'unique:financials_main_units,mu_title,' . $request->unit_id . ',mu_id,mu_clg_id,'.$user->user_clg_id],
            'remarks' => ['nullable', 'string'],
        ]);

        $main_unit = MainUnitModel::where('mu_id', $request->unit_id)->first();

        $main_unit = $this->AssignMainUnitValues($request, $main_unit);

        if ($main_unit->save()) {

            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Main Unit With Id: ' . $main_unit->mu_id . ' And Name: ' . $main_unit->mu_title);

            return redirect('main_unit_list')->with('success', 'Successfully Saved');
        } else {
            return redirect('main_unit_list')->with('fail', 'Failed Try Again!');
        }
    }

    public function delete_main_unit(Request $request)
    {
        $user = Auth::User();

        $delete = MainUnitModel::where('mu_id', $request->main_unit_id)->first();

//        $delete->mu_delete_status = 1;

        if ($delete->mu_delete_status == 1) {
            $delete->mu_delete_status = 0;
        } else {
            $delete->mu_delete_status = 1;
        }

        $delete->mu_deleted_by = $user->user_id;

        if ($delete->save()) {

            if ($delete->mu_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Main Unit With Id: ' . $delete->mu_id . ' And Name: ' . $delete->mu_title);

                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Main Unit With Id: ' . $delete->mu_id . ' And Name: ' . $delete->mu_title);

                return redirect()->back()->with('success', 'Successfully Deleted');
            }


        } else {
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }

    }
}
