<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Wizard\WizardController;
use App\Imports\ExcelDataImport;
use App\Models\ProductGroupModel;
use App\Models\ProductModel;
use App\Models\SystemConfigModel;
use Auth;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProductGroupController extends ExcelForm\ProductReportingGroupForm\ProductReportingGroupController
{
    public function product_group()
    {
        return view('product_group');
    }

    public function submit_product_group_excel(Request $request)
    {
        $rules = [
            'add_product_group_excel' => 'required|mimes:xlsx,xls,csv|max:5000',
        ];

        $messages = [
            'add_product_group_excel.max' => "Your File size too long.",
            'add_product_group_excel.required' => "Please select your Main Unit Excel Sheet.",
        ];

        $validator = $this->validate($request, $rules, $messages);

        if ($request->hasFile('add_product_group_excel')) {

//            dd($request->add_employee_excel);
//            $dateTime = date('Ymd_His');
//            $file = $request->file('add_employee_excel');
//            $fileName = $dateTime . '-' . $file->getClientOriginalName();
//            $savePath = public_path('/uploads/'.config('global_variables.excel_storage_folder_name'));
//            $file->move($savePath, $fileName);
//            $data = Excel::load($path)->get();


            $path = $request->file('add_product_group_excel');
            $data = Excel::toArray(new ExcelDataImport, $path);

            $excelData = json_decode(json_encode($data), FALSE);
//            foreach ($data as $key => $value) {
            foreach ($excelData as $rows) {
                foreach ($rows as $row) {
                    $rowData = (array)$row;
                    $request->merge($rowData);
                    $this->excel_product_group_validation($request);

                    $rollBack = self::excel_form_product_group($row);

                    if ($rollBack) {
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed Try Again');
                    } else {
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

    public function submit_product_group(Request $request)
    {
        return self::simple_form_product_group($request);
//        $this->product_group_validation($request);
//
//        $product_group = new ProductGroupModel();
//
//        $product_group = $this->AssignProductGroupValues($request, $product_group);
//
//        $product_group->save();
//
//        $user = Auth::User();
//
//        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Product Group With Id: ' . $product_group->pg_id . ' And Name: ' . $product_group->pg_title);
//
//        // WizardController::updateWizardInfo(['product_reporting_group'], ['add_modular_group']);
//
//        return redirect()->back()->with('success', 'Successfully Saved');
    }

    public function product_group_validation($request)
    {
        $user = Auth::user();
        return $this->validate($request, [
            'group_name' => ['required', 'string', 'unique:financials_product_group,pg_title,null,null,pg_clg_id,' . $user->user_clg_id],
            'remarks' => ['nullable', 'string'],
        ]);
    }

    protected function AssignProductGroupValues($request, $product_group)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $product_group->pg_title = ucwords($request->group_name);
        $product_group->pg_remarks = ucfirst($request->remarks);
        $product_group->pg_created_by = $user->user_id;
        $product_group->pg_clg_id = $user->user_clg_id;
        $product_group->pg_day_end_id = $day_end->de_id;
        $product_group->pg_day_end_date = $day_end->de_datetime;
        $product_group->pg_brwsr_info = $brwsr_rslt;
        $product_group->pg_ip_adrs = $ip_rslt;
        $product_group->pg_update_datetime = Carbon::now()->toDateTimeString();

        return $product_group;
    }

    // update code by shahzaib start
    public function product_group_list(Request $request, $array = null, $str = null)
    {

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.product_group_list.product_group_list';
        $pge_title = 'Product Group List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;
        $user=Auth::user();

        $query = DB::table('financials_product_group')
            ->leftJoin('financials_users', 'financials_users.user_id', '=', 'financials_product_group.pg_created_by')
            ->where('pg_clg_id', $user->user_clg_id);

        if (!empty($search)) {
            $query->where('pg_title', 'like', '%' . $search . '%')
                ->orWhere('pg_remarks', 'like', '%' . $search . '%')
                ->orWhere('pg_id', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
            $query->where('pg_created_by', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1) {
            $query->where('pg_delete_status', '=', 1);
        } else {
            $query->where('pg_delete_status', '!=', 1);
        }


        $datas = $query
//            ->where('pg_delete_status', '!=', 1)
            ->orderBy('pg_id', config('global_variables.query_sorting'))->paginate($pagination_number);

        $product_group = ProductGroupModel::where('pg_clg_id', $user->user_clg_id)->where('pg_delete_status', '!=', 1)->orderBy('pg_title', 'ASC')->pluck('pg_title')->all();


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
            return view('product_group_list', compact('datas', 'product_group', 'search', 'search_by_user', 'restore_list'));
        }
    }

    // update code by shahzaib end


    public function edit_product_group(Request $request)
    {
        return view('edit_product_group', compact('request'));
    }

    public function update_product_group(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'group_id' => ['required', 'numeric'],
            'group_name' => ['required', 'string', 'unique:financials_product_group,pg_title,' . $request->group_id . ',pg_id,pg_clg_id,'. $user->user_clg_id],
            'remarks' => ['nullable', 'string'],
        ]);

        $group = ProductGroupModel::where('pg_id', $request->group_id)->first();

        $group = $this->AssignProductGroupValues($request, $group);

        if ($group->save()) {

            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Reporting Group With Id: ' . $group->pg_id . ' And Name: ' . $group->pg_title);

            return redirect('product_group_list')->with('success', 'Successfully Saved');
        } else {
            return redirect('product_group_list')->with('fail', 'Failed Try Again!');
        }
    }

    public function delete_product_group(Request $request)
    {
        $user = Auth::User();

        $delete = ProductGroupModel::where('pg_id', $request->group_id)->first();

        $delete->pg_delete_status = 1;
        $delete->pg_deleted_by = $user->user_id;

        if ($delete->save()) {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Reporting Group With Id: ' . $delete->pg_id . ' And Name: ' . $delete->pg_title);

            return redirect()->back()->with('success', 'Successfully Saved');
        } else {
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }

    }
}
