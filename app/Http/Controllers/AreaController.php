<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Wizard\WizardController;
use App\Imports\ExcelDataImport;
use App\Models\AreaModel;
use App\Models\BalancesModel;
use App\Models\RegionModel;
use Auth;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AreaController extends ExcelForm\AreaForm\AreaController
{
    public function add_area()
    {
//                 $account_id = 414172;
//       $accounts= DB::table('financials_accounts')->WHERE('account_uid', 'LIKE', '4%')->select('account_uid')->get();
//         foreach($accounts as $acc){
//             $account_id=$acc->account_uid;
//             // dd($account_id);
//       $opening=BalancesModel::where('bal_account_id',	$account_id)->pluck('bal_total')->first();
//         $balances = BalancesModel::where('bal_account_id',	$account_id)->get();
//         foreach ($balances as $balance){
//
//             $update = BalancesModel::where('bal_id',$balance->bal_id)->first();
//             $dr =$update->bal_dr;
//             $cr =$update->bal_cr;
//             $opening= $opening + $dr - $cr;
//             $update->bal_total = $opening;
//             $update->save();
//         }
//         $results = BalancesModel::select(DB::raw('SUM(bal_dr) as total_dr'), DB::raw('SUM(bal_cr) as total_cr'))
//     ->where('bal_account_id', $account_id)
//     ->first();
//
// if ($results->total_dr != null) {
//     $totalDr = $results->total_dr;
//     $totalCr = $results->total_cr;
//     $difference = round($totalDr - $totalCr,2); // Subtract total_dr from total_cr
// } else {
//   dd("Account Not Found");
// }
// // Update the financials_accounts table
//     DB::table('financials_accounts')
//         ->where('account_uid', $account_id) // Replace with the correct column and value to identify the row
//         ->update([
//             'account_monthly_debit' => $totalDr,
//             'account_monthly_credit' => $totalCr,
//             'account_balance' => $difference
//         ]);
//         // dd($balances,$totalDr,$totalCr,$difference,$account_id);
//         }
//         dd($balances,$totalDr,$totalCr,$difference,$account_id);
        $user = Auth::user();
        $regions = RegionModel::where('reg_clg_id', '=', $user->user_clg_id)->where('reg_delete_status', '!=', 1)->where('reg_disabled', '!=', 1)->orderBy('reg_title', config('global_variables.drop_sorting'))
            ->get();
        return view('add_area', compact('regions'));
    }

    public function submit_area_excel(Request $request)
    {

        $rules = [
            'add_area_excel' => 'required|mimes:xlsx,xls,csv|max:5000',
        ];

        $messages = [
            'add_area_excel.max' => "Your File size too long.",
            'add_area_excel.required' => "Please select your Area Excel Sheet.",
        ];

        $validator = $this->validate($request, $rules, $messages);

        if ($request->hasFile('add_area_excel')) {

//            dd($request->add_employee_excel);
//            $dateTime = date('Ymd_His');
//            $file = $request->file('add_employee_excel');
//            $fileName = $dateTime . '-' . $file->getClientOriginalName();
//            $savePath = public_path('/uploads/'.config('global_variables.excel_storage_folder_name'));
//            $file->move($savePath, $fileName);
//            $data = Excel::load($path)->get();


            $path = $request->file('add_area_excel');
            $data = Excel::toArray(new ExcelDataImport, $path);

            $excelData = json_decode(json_encode($data), FALSE);
            foreach ($data as $key => $value) {
                foreach ($excelData as $rows) {
                    foreach ($rows as $row) {
                        $rowData = (array)$row;
                        $request->merge($rowData);
                        $this->excel_area_validation($request);

                        $rollBack = self::excel_form_area($row);

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

    public function submit_area(Request $request)
    {
        return self::simple_form_area($request);

    }

    // update code by shahzaib start
    public function area_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $regions = RegionModel::where('reg_clg_id', '=', $user->user_clg_id)->orderby('reg_title', 'ASC')->get();

//        $search = (isset($request->search) && $request->filter_search === "normal_search") ? $request->search : '';
//        $search_region = (isset($request->region) && $request->filter_search === "filter_search") ? $request->region : '';

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_region = (!isset($request->region) && empty($request->region)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->region;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';

        $prnt_page_dir = 'print.area_list.area_list';
        $pge_title = 'Area List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_region, $search_by_user);


        $pagination_number = (empty($ar) || !empty($ar)) ? 30 : 100000000;

        $query = DB::table('financials_areas')
            ->join('financials_region', 'financials_region.reg_id', '=', 'financials_areas.area_reg_id')
            ->leftJoin('financials_users', 'financials_users.user_id', '=', 'financials_areas.area_createdby')
            ->where('area_clg_id', '=', $user->user_clg_id);


        if (!empty($search)) {

            $pagination_number = 1000000;
            $query->orWhere('area_id', 'like', '%' . $search . '%')
                ->orWhere('area_title', 'like', '%' . $search . '%')
                ->orWhere('area_remarks', 'like', '%' . $search . '%')
                ->orWhere('reg_title', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%');
        }

        if (!empty($search_region)) {
            $pagination_number = 1000000;
            $query->where('area_reg_id', '=', $search_region);
        }

        if (!empty($search_by_user)) {
            $pagination_number = 1000000;
            $query->where('area_createdby', '=', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1) {
            $query->where('area_delete_status', '=', 1);
        } else {
            $query->where('area_delete_status', '!=', 1);
        }

        $datas = $query
//            ->where('area_delete_status', '!=', 1)
            ->orderBy('area_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);


        $area_title = AreaModel::
        where('area_clg_id', '=', $user->user_clg_id)->
        where('area_delete_status', '!=', 1)->
        orderBy('area_title', 'ASC')->pluck('area_title')->all();


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
            return view('area_list', compact('datas', 'search', 'area_title', 'regions', 'search_region', 'restore_list'));
        }

    }

    // update code by shahzaib end


    public function edit_area(Request $request)
    {
        $user = Auth::user();
        $regions = RegionModel::where('reg_clg_id', '=', $user->user_clg_id)->where('reg_delete_status', '!=', 1)->where('reg_disabled', '!=', 1)->orderBy('reg_title', 'ASC')->get();
        return view('edit_area', compact('request', 'regions'));
    }

    public function update_area(Request $request)
    {
        $user = Auth::User();
        $this->validate($request, [
            'region_name' => ['required', 'numeric'],
            'area_id' => ['required', 'numeric'],
            'area_name' => ['required', 'string', 'unique:financials_areas,area_title,' . $request->area_id . ',area_id,area_reg_id,' . $request->region_id . ',area_clg_id,' . $user->user_clg_id],
            'remarks' => ['nullable', 'string'],
        ]);

        $area = AreaModel::where('area_id', $request->area_id)->first();

        $area->area_reg_id = $request->region_name;
        $area->area_title = ucwords($request->area_name);
        $area->area_remarks = ucfirst($request->remarks);

        if ($area->save()) {

            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Area With Id: ' . $area->area_id . ' And Name: ' . $area->area_title);

            return redirect('area_list')->with('success', 'Successfully Saved');
        } else {
            return redirect('area_list')->with('fail', 'Failed Try Again!');
        }
    }

    public function delete_area(Request $request)
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

}
