<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Wizard\WizardController;
use App\Imports\ExcelDataImport;
use App\Models\AccountRegisterationModel;
use App\Models\AreaModel;
use App\Models\RegionModel;
use App\Models\SectorModel;
use Auth;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SectorController extends ExcelForm\SectorForm\SectorController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_sector()
    {
        $user = Auth::user();
        $regions = RegionModel::where('reg_clg_id', '=', $user->user_clg_id)->where('reg_delete_status', '!=', 1)->where('reg_disabled', '!=', 1)->orderBy('reg_title', 'ASC')->get();
        return view('add_sector', compact('regions'));
    }

    public function get_area(Request $request)
    {
        $reg_id = $request->reg_id;

        $areas = AreaModel::where('area_delete_status', '!=', 1)->where('area_disabled', '!=', 1)->where('area_reg_id', $reg_id)->orderBy('area_title', 'ASC')->get();

        $get_area = "<option value=''>Select Area</option>";
        foreach ($areas as $area) {
            $selected = $area->area_id == $request->area_id ? 'selected' : '';
            $get_area .= "<option value='$area->area_id' $selected>$area->area_title</option>";
        }

        return response()->json($get_area);
    }

    public function get_sector(Request $request)
    {
        $user = Auth::user();
        $area_id = $request->area_id;

        $sectors = SectorModel::where('sec_clg_id', '=', $user->user_clg_id)->where('sec_delete_status', '!=', 1)->where('sec_area_id', $area_id)->where('sec_disabled', '!=', 1)->orderBy('sec_title',
            'ASC')
            ->get();

        $get_sector = "<option value=''>Select Sector</option>";
        foreach ($sectors as $sector) {
            $selected = $sector->sec_id == $request->sector_id ? 'selected' : '';
            $get_sector .= "<option value='$sector->sec_id' $selected>$sector->sec_title</option>";
        }

        return response()->json($get_sector);
    }

    public function submit_sector_excel(Request $request)
    {

        $rules = [
            'add_sector_excel' => 'required|mimes:xlsx,xls,csv|max:5000',
        ];

        $messages = [
            'add_sector_excel.max' => "Your File size too long.",
            'add_sector_excel.required' => "Please select your Sector Excel Sheet.",
        ];

        $validator = $this->validate($request, $rules, $messages);

        if ($request->hasFile('add_sector_excel')) {

//            dd($request->add_employee_excel);
//            $dateTime = date('Ymd_His');
//            $file = $request->file('add_employee_excel');
//            $fileName = $dateTime . '-' . $file->getClientOriginalName();
//            $savePath = public_path('/uploads/'.config('global_variables.excel_storage_folder_name'));
//            $file->move($savePath, $fileName);
//            $data = Excel::load($path)->get();



            $path = $request->file('add_sector_excel');
            $data = Excel::toArray(new ExcelDataImport, $path);

            $excelData = json_decode (json_encode ($data), FALSE);
//            foreach ($data as $key => $value) {
                foreach ($excelData as $rows) {
                    foreach ($rows as $row) {

                        $rowData = (array) $row;
                        $request->merge($rowData);
                        $this->excel_sector_validation($request);

                        $rollBack = self::excel_form_sector($row);

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

    public function submit_sector(Request $request)
    {
        return self::simple_form_sector($request);
    }

    // update code by shahzaib start
    public function sector_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $regions = RegionModel::where('reg_clg_id', '=', $user->user_clg_id)->orderby('reg_title', 'ASC')->get();
        $areas = AreaModel::where('area_clg_id', '=', $user->user_clg_id)->orderBy('area_title', 'ASC')->get();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_region = (!isset($request->region) && empty($request->region)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->region;
        $search_area = (!isset($request->area) && empty($request->area)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->area;
        $search_by_user = $request->search_by_user;

        $prnt_page_dir = 'print.sector_list.sector_list';
        $pge_title = 'Sector List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_region, $search_area, $search_by_user);


        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $query = DB::table('financials_sectors')
            ->join('financials_areas', 'financials_areas.area_id', '=', 'financials_sectors.sec_area_id')
            ->join('financials_region', 'financials_region.reg_id', '=', 'financials_areas.area_reg_id')
            ->leftJoin('financials_users', 'financials_users.user_id', '=', 'financials_sectors.sec_createdby')
            ->where('sec_clg_id', '=', $user->user_clg_id);


        if (!empty($search)) {
            $pagination_number = 1000000;
            $query->orWhere('reg_title', 'like', '%' . $search . '%')
                ->orWhere('area_title', 'like', '%' . $search . '%')
                ->orWhere('sec_id', 'like', '%' . $search . '%')
                ->orWhere('sec_title', 'like', '%' . $search . '%')
                ->orWhere('sec_remarks', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%');
        }

        if (!empty($search_region)) {
            $pagination_number = 1000000;
            $query->orWhere('reg_id', $search_region);
        }

        if (!empty($search_area)) {
            $pagination_number = 1000000;
            $query->where('area_id', $search_area);
        }

        if (!empty($search_by_user)) {
            $pagination_number = 1000000;
            $query->where('sec_createdby', '=', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1)
        {
            $query->where('sec_delete_status', '=', 1);
        } else {
            $query->where('sec_delete_status', '!=', 1);
        }


        $datas = $query
//            ->where('sec_delete_status', '!=', 1)
            ->orderBy('sec_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

        $sec_title = SectorModel::
        where('sec_clg_id', '=', $user->user_clg_id)->
//        where('sec_delete_status', '!=', 1)->
        orderBy('sec_title', 'ASC')->pluck('sec_title')->all();


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
                'margin-top' => 24,
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
            return view('sector_list', compact('datas', 'search', 'sec_title', 'areas', 'regions', 'search_region', 'search_area', 'search_by_user','restore_list'));
        }

    }

    // update code by shahzaib end


    public function edit_sector(Request $request)
    {
        $user = Auth::user();
        $regions = RegionModel::where('reg_clg_id', '=', $user->user_clg_id)->where('reg_delete_status', '!=', 1)->where('reg_disabled', '!=', 1)->orderBy('reg_title', 'ASC')->get();
//        $areas=AreaModel::orderby('area_title','ASC')->get();
        return view('edit_sector', compact('request', 'regions'));
    }

    public function update_sector(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'region_name' => ['required', 'string'],
            'area_name' => ['required', 'numeric'],
            'sector_id' => ['required', 'numeric'],
//            'area_id' => ['required', 'numeric'],
            'sector_name' => ['required', 'string', 'unique:financials_sectors,sec_title,' . $request->sector_id . ',sec_id,sec_area_id,' . $request->area_name. ',sec_clg_id,' . $user->user_clg_id],
            'remarks' => ['nullable', 'string'],
        ]);

        $sector = SectorModel::where('sec_id', $request->sector_id)->first();

        $sector->sec_area_id = $request->area_name;
        $sector->sec_title = ucwords($request->sector_name);
        $sector->sec_remarks = ucfirst($request->remarks);

        if ($sector->save()) {


            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Sector With Id: ' . $sector->sec_id . ' And Name: ' . $sector->sec_title);

            return redirect('sector_list')->with('success', 'Successfully Saved');
        } else {
            return redirect('sector_list')->with('fail', 'Failed Try Again!');
        }
    }

    public function delete_sector(Request $request)
    {
        $user = Auth::User();

        $delete = SectorModel::where('sec_id', $request->sector_id)->first();

//        $delete->sec_delete_status = 1;
        if ($delete->sec_delete_status == 1) {
            $delete->sec_delete_status = 0;
        } else {
            $delete->sec_delete_status = 1;
        }

        $delete->sec_deleted_by = $user->user_id;

        if ($delete->save()) {

            if ($delete->sec_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Sector With Id: ' . $delete->sec_id . ' And Name: ' . $delete->sec_title);

//                return redirect('sector_list')->with('success', 'Successfully Restored');
                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Sector With Id: ' . $delete->sec_id . ' And Name: ' . $delete->sec_title);

//                return redirect('sector_list')->with('success', 'Successfully Deleted');
                return redirect()->back()->with('success', 'Successfully Deleted');
            }


        } else {
//            return redirect('sector_list')->with('fail', 'Failed Try Again!');
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }

    }

}
