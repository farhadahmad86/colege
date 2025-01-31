<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Wizard\WizardController;
use App\Imports\ExcelDataImport;
use App\Models\AccountRegisterationModel;
use App\Models\AreaModel;
use App\Models\BalancesModel;
use App\Models\ProductModel;
use App\Models\RegionModel;
use Artisan;
use Auth;
use PDF;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Reader;
use function Aws\map;

class RegionController extends ExcelForm\RegionForm\RegionController
{
    public function add_region_search_test()
    {
        return view('add_region_search_test');
    }

    public function add_region()
    {
        //        $this->enter_log('add_region');
        return view('add_region');
    }

    public function submit_region_excel(Request $request)
    {

        $rules = [
            'add_region_excel' => 'required|mimes:xlsx,xls,csv|max:5000',
        ];

        $messages = [
            'add_region_excel.max' => "Your File size too long.",
            'add_region_excel.required' => "Please select your Region Excel Sheet.",
        ];

        $validator = $this->validate($request, $rules, $messages);

        if ($request->hasFile('add_region_excel')) {

            //            dd($request->add_employee_excel);
            //            $dateTime = date('Ymd_His');
            //            $file = $request->file('add_employee_excel');
            //            $fileName = $dateTime . '-' . $file->getClientOriginalName();
            //            $savePath = public_path('/uploads/'.config('global_variables.excel_storage_folder_name'));
            //            $file->move($savePath, $fileName);
            //            $data = Excel::load($path)->get();



            $path = $request->file('add_region_excel');
            $data = Excel::toArray(new ExcelDataImport, $path);

            $excelData = json_decode(json_encode($data), FALSE);
            foreach ($data as $key => $value) {
                foreach ($excelData as $rows) {
                    foreach ($rows as $row) {
                        $rowData = (array) $row;
                        $request->merge($rowData);
                        $this->excel_region_validation($request);

                        $rollBack = self::excel_form_region($row);

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

    public function submit_region(Request $request)
    {
        return self::simple_form_region($request);
    }


    // update code by shahzaib start
    public function region_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.region_list.region_list';
        $pge_title = 'Region List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_region')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_region.reg_createdby')
            ->where('reg_clg_id', $user->user_clg_id);

        if (!empty($search)) {
            $query->where('reg_title', 'like', '%' . $search . '%')
                ->orWhere('reg_remarks', 'like', '%' . $search . '%')
                ->orWhere('reg_id', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {

            $query->where('reg_createdby', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1) {
            $query->where('reg_delete_status', '=', 1);
        } else {
            $query->where('reg_delete_status', '!=', 1);
        }

        $datas = $query->orderBy('reg_id', 'DESC')
            ->paginate($pagination_number);

        $reg_title = RegionModel::orderBy('reg_id', config('global_variables.query_sorting'))->pluck('reg_title')->all(); //where('reg_delete_status', '!=', 1)->


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
            return view('region_list', compact('datas', 'search', 'reg_title', 'search_by_user', 'restore_list'));
        }
    }

    // update code by shahzaib end


    public function edit_region(Request $request)
    {
        return view('edit_region', compact('request'));
    }

    public function update_region(Request $request)
    {
        $user = Auth::User();
        $this->validate($request, [
            'region_id' => ['required', 'numeric'],
            'region_name' => ['required', 'string', 'unique:financials_region,reg_title,' . $request->region_id . ',reg_id'.',reg_clg_id,' . $user->user_clg_id],
            'remarks' => ['nullable', 'string'],
        ]);

        $region = RegionModel::where('reg_id', $request->region_id)->first();

        $region = $this->AssignRegionValues($request, $region);

        if ($region->save()) {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Region With Id: ' . $region->reg_id . ' And Name: ' . $region->reg_title);
            return redirect('region_list')->with('success', 'Successfully Saved');
        } else {
            return redirect('region_list')->with('fail', 'Failed Try Again!');
        }
    }

    public function delete_region(Request $request)
    {
        $user = Auth::User();

        $delete = RegionModel::where('reg_id', $request->reg_id)->first();

        if ($delete->reg_delete_status == 1) {
            $delete->reg_delete_status = 0;
        } else {
            $delete->reg_delete_status = 1;
        }

        $delete->reg_deleted_by = $user->user_id;

        if ($delete->save()) {

            if ($delete->reg_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Region With Id: ' . $delete->reg_id . ' And Name: ' . $delete->reg_title);

                //                return redirect('region_list')->with('success', 'Successfully Restored');
                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Region With Id: ' . $delete->reg_id . ' And Name: ' . $delete->reg_title);

                //                return redirect('region_list')->with('success', 'Successfully Deleted');
                return redirect()->back()->with('success', 'Successfully Deleted');
            }
        } else {
            //            return redirect('region_list')->with('fail', 'Failed Try Again!');
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }
    }
}
