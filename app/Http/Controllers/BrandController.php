<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Imports\ExcelDataImport;
use App\Models\BrandModel;
use App\Models\RegionModel;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class BrandController extends ExcelForm\BrandForm\BrandFormController
{
    public function add_brand()
    {
        return view('add_brand');
    }

    public function submit_brand_excel(Request $request)
    {

        $rules = [
            'add_create_brand_excel' => 'required|mimes:xlsx,xls,csv|max:5000',
        ];

        $messages = [
            'add_create_brand_excel.max' => "Your File size too long.",
            'add_create_brand_excel.required' => "Please select your Brand Excel Sheet.",
        ];

        $validator = $this->validate($request, $rules, $messages);

        if ($request->hasFile('add_create_brand_excel')) {

//            dd($request->add_employee_excel);
//            $dateTime = date('Ymd_His');
//            $file = $request->file('add_employee_excel');
//            $fileName = $dateTime . '-' . $file->getClientOriginalName();
//            $savePath = public_path('/uploads/'.config('global_variables.excel_storage_folder_name'));
//            $file->move($savePath, $fileName);
//            $data = Excel::load($path)->get();


            $path = $request->file('add_create_brand_excel');
            $data = Excel::toArray(new ExcelDataImport, $path);

            $excelData = json_decode(json_encode($data), FALSE);

            foreach ($excelData as $rows) {
                foreach ($rows as $row) {
                    $rowData = (array)$row;
                    $request->merge($rowData);
                    $this->excel_brand_validation($request);

                    $rollBack = self::excel_form_brand($row);

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

    public function submit_brand(Request $request)
    {
        return self::simple_form_brand($request);
//        $this->brand_validation($request);
//
//        $brand = new BrandModel();
//
//        $brand = $this->AssignBrandValues($request, $brand);
//
//        $brand->save();
//
//        $user = Auth::User();
//
//        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Brand With Id: ' . $brand->br_id . ' And Name: ' . $brand->br_title);
//
//        // WizardController::updateWizardInfo(['region'], ['area']);
//
//        return redirect('add_brand')->with('success', 'Successfully Saved');
    }

    public function brand_validation($request)
    {
        $user = Auth::User();
        return $this->validate($request, [
            'brand_name' => ['required', 'string', 'unique:financials_brands,br_title,null,null,br_clg_id,' . $user->user_clg_id],
        ]);

    }

    protected function AssignBrandValues($request, $brand)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $brand->br_title = ucwords($request->brand_name);
        $brand->br_remarks = ucfirst($request->remarks);
        $brand->br_created_by = $user->user_id;
        $brand->br_clg_id = $user->user_clg_id;
        $brand->br_day_end_id = $day_end->de_id;
        $brand->br_day_end_date = $day_end->de_datetime;

        // coding from shahzaib start
        $tbl_var_name = 'brand';
        $prfx = 'br';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adr';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end


        return $brand;
    }

    public function brand_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::User();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.brand_list.brand_list';
        $pge_title = 'Brand List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_brands')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_brands.br_created_by')
            ->where('br_clg_id', $user->user_clg_id);

        if (!empty($search)) {
            $query->where('br_title', 'like', '%' . $search . '%')
                ->orWhere('br_remarks', 'like', '%' . $search . '%')
                ->orWhere('br_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
//            $pagination_number = 100000000;
            $query->where('br_created_by', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1) {
            $query->where('br_delete_status', '=', 1);
        } else {
            $query->where('br_delete_status', '!=', 1);
        }

        $datas = $query->orderBy('br_id', 'DESC')
            ->paginate($pagination_number);

        $br_title = BrandModel::where('br_clg_id', $user->user_clg_id)->orderBy('br_id', config('global_variables.query_sorting'))->pluck('br_title')->all();//where('reg_delete_status', '!=', 1)->


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
            return view('brand_list', compact('datas', 'search', 'br_title', 'search_by_user', 'restore_list'));
        }

    }

    // update code by shahzaib end

    public function edit_brand(Request $request)
    {
        return view('edit_brand', compact('request'));
    }

    public function update_brand(Request $request)
    {
        $user = Auth::User();
        $this->validate($request, [
            'brand_id' => ['required', 'numeric'],
            'brand_name' => ['required', 'string', 'unique:financials_brands,br_title,' . $request->brand_id . ',br_id,br_clg_id,' . $user->user_clg_id],
            'remarks' => ['nullable', 'string'],
        ]);

        $brand = BrandModel::where('br_id', $request->brand_id)->first();

        $brand = $this->AssignBrandValues($request, $brand);

        if ($brand->save()) {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Brand With Id: ' . $brand->br_id . ' And Name: ' . $brand->br_title);
            return redirect('brand_list')->with('success', 'Successfully Saved');
        } else {
            return redirect('brand_list')->with('fail', 'Failed Try Again!');
        }
    }

    public function delete_brand(Request $request)
    {
        $user = Auth::User();

        $delete = BrandModel::where('br_id', $request->br_id)->first();

        if ($delete->br_delete_status == 1) {
            $delete->br_delete_status = 0;
        } else {
            $delete->br_delete_status = 1;
        }

        $delete->br_deleted_by = $user->user_id;

        if ($delete->save()) {

            if ($delete->br_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Brand With Id: ' . $delete->br_id . ' And Name: ' . $delete->br_title);

//                return redirect('brand_list')->with('success', 'Successfully Restored');
                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Brand With Id: ' . $delete->br_id . ' And Name: ' . $delete->br_title);

//                return redirect('brand_list')->with('success', 'Successfully Deleted');
                return redirect()->back()->with('success', 'Successfully Deleted');
            }

        } else {
//            return redirect('brion_list')->with('fail', 'Failed Try Again!');
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }
    }
}
