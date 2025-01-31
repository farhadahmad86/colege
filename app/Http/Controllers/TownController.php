<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Wizard\WizardController;
use App\Imports\ExcelDataImport;
use App\Models\AccountRegisterationModel;
use App\Models\AreaModel;
use App\Models\RegionModel;
use App\Models\SectorModel;
use App\Models\TownModel;
use App\User;
use Auth;
use PDF;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TownController extends ExcelForm\TownForm\TownController
{
    public function add_town()
    {
        $user = Auth::User();
        $regions = RegionModel::where('reg_clg_id', '=', $user->user_clg_id)->where('reg_delete_status', '!=', 1)->where('reg_disabled', '!=', 1)->orderBy('reg_title', 'ASC')->get();
        return view('add_town', compact('regions'));
    }

    public function get_town(Request $request)
    {
        $user = Auth::User();
        $sector_id = $request->sector_id;

        $towns = TownModel::where('town_clg_id', '=', $user->user_clg_id)->where('town_sector_id', $sector_id)->where('town_disabled', '!=', 1)->orderBy('town_title', 'ASC')->get();

        $get_town = "<option value=''>Select Town</option>";
        foreach ($towns as $town) {
            $selected = $town->town_id == $request->town_id ? 'selected' : '';
            $get_town .= "<option value='$town->town_id' $selected>$town->town_title</option>";
        }

        return response()->json($get_town);
    }

    public function submit_town_excel(Request $request)
    {
        $rules = [
            'add_town_excel' => 'required|mimes:xlsx,xls,csv|max:5000',
        ];

        $messages = [
            'add_town_excel.max' => "Your File size too long.",
            'add_town_excel.required' => "Please select your Town Excel Sheet.",
        ];

        $validator = $this->validate($request, $rules, $messages);

        if ($request->hasFile('add_town_excel')) {

//            dd($request->add_employee_excel);
//            $dateTime = date('Ymd_His');
//            $file = $request->file('add_employee_excel');
//            $fileName = $dateTime . '-' . $file->getClientOriginalName();
//            $savePath = public_path('/uploads/'.config('global_variables.excel_storage_folder_name'));
//            $file->move($savePath, $fileName);
//            $data = Excel::load($path)->get();


            $path = $request->file('add_town_excel');
            $data = Excel::toArray(new ExcelDataImport, $path);

            $excelData = json_decode(json_encode($data), FALSE);
//            foreach ($data as $key => $value) {
            foreach ($excelData as $rows) {
                foreach ($rows as $row) {

                    $rowData = (array)$row;
                    $request->merge($rowData);
                    $this->excel_town_validation($request);

                    $rollBack = self::excel_form_town($row);

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

    public function submit_town(Request $request)
    {
        return self::simple_form_town($request);

    }

    // update code by shahzaib start
    public function town_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::User();
        $regions = RegionModel::where('reg_clg_id', '=', $user->user_clg_id)->orderby('reg_title', 'ASC')->get();
        $areas = AreaModel::where('area_clg_id', '=', $user->user_clg_id)->orderBy('area_title', 'ASC')->get();
        $sectors = SectorModel::where('sec_clg_id', '=', $user->user_clg_id)->orderBy('sec_title', 'ASC')->get();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_region = (!isset($request->region) && empty($request->region)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->region;
        $search_area = (!isset($request->area) && empty($request->area)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->area;
        $search_sector = (!isset($request->sector) && empty($request->sector)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->sector;
        $search_by_user = $request->search_by_user;

        $prnt_page_dir = 'print.town_list.town_list';
        $pge_title = 'Town List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_region, $search_area, $search_sector, $search_by_user);


        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $query = DB::table('financials_towns')
            ->join('financials_sectors', 'financials_sectors.sec_id', '=', 'financials_towns.town_sector_id')
            ->join('financials_areas', 'financials_areas.area_id', '=', 'financials_sectors.sec_area_id')
            ->join('financials_region', 'financials_region.reg_id', '=', 'financials_areas.area_reg_id')
            ->leftJoin('financials_users', 'financials_users.user_id', '=', 'financials_towns.town_createdby')
            ->where('town_clg_id', '=', $user->user_clg_id);


        if (!empty($search)) {
            $pagination_number = 1000000;
            $query->orWhere('reg_title', 'like', '%' . $search . '%')
                ->orWhere('area_title', 'like', '%' . $search . '%')
                ->orWhere('sec_title', 'like', '%' . $search . '%')
                ->orWhere('town_id', 'like', '%' . $search . '%')
                ->orWhere('town_title', 'like', '%' . $search . '%')
                ->orWhere('town_remarks', 'like', '%' . $search . '%')
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

        if (!empty($search_sector)) {
            $pagination_number = 1000000;
            $query->where('sec_id', $search_sector);
        }

        if (!empty($search_by_user)) {
            $pagination_number = 1000000;
            $query->where('town_createdby', '=', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1) {
            $query->where('town_delete_status', '=', 1);
        } else {
            $query->where('town_delete_status', '!=', 1);
        }


        $datas = $query
//            ->where('town_delete_status', '!=', 1)
            ->orderBy('town_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

        $town_title = TownModel::
        where('town_clg_id', '=', $user->user_clg_id)->
        where('town_delete_status', '!=', 1)->
        orderBy('town_title', 'ASC')->pluck('town_title')->all();


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
            return view('town_list', compact('datas', 'search', 'town_title', 'regions', 'areas', 'sectors', 'search_region', 'search_area', 'search_sector', 'search_by_user', 'restore_list'));
        }

    }

    // update code by shahzaib end


    public function edit_town(Request $request)
    {
        $user = Auth::User();
        $regions = RegionModel:: where('reg_clg_id', '=', $user->user_clg_id)
            ->where('reg_disabled', '!=', 1)->orderBy('reg_title', 'ASC')->get();

        return view('edit_town', compact('request', 'regions'));
    }

    public function update_town(Request $request)
    {
        $user = Auth::User();
        $this->validate($request, [
            'region_name' => ['required', 'string'],
            'area_name' => ['required', 'numeric'],
            'sector_name' => ['required', 'numeric'],
            'town_id' => ['required', 'numeric'],
            'town_name' => ['required', 'string', 'unique:financials_towns,town_title,' . $request->town_id . ',town_id,town_sector_id,' . $request->sector_name . ',town_clg_id,' . $user->user_clg_id],
            'remarks' => ['nullable', 'string'],
        ]);

        $town = TownModel::where('town_clg_id', '=', $user->user_clg_id)->where('town_id', $request->town_id)->first();

        $town->town_sector_id = $request->sector_name;
        $town->town_title = ucwords($request->town_name);
        $town->town_remarks = ucfirst($request->remarks);

        if ($town->save()) {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Town With Id: ' . $town->town_id . ' And Name: ' . $town->town_title);

            return redirect('town_list')->with('success', 'Successfully Saved');
        } else {
            return redirect('town_list')->with('fail', 'Failed Try Again!');
        }
    }

    public function delete_town(Request $request)
    {
        $user = Auth::User();

        $delete = TownModel::where('town_clg_id', '=', $user->user_clg_id)->where('town_id', $request->town_id)->first();

//        $delete->town_delete_status = 1;
        if ($delete->town_delete_status == 1) {
            $delete->town_delete_status = 0;
        } else {
            $delete->town_delete_status = 1;
        }
        $delete->town_deleted_by = $user->user_id;

        if ($delete->save()) {
            if ($delete->town_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Town With Id: ' . $delete->town_id . ' And Name: ' . $delete->town_title);

                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Town With Id: ' . $delete->town_id . ' And Name: ' . $delete->town_title);

                return redirect()->back()->with('success', 'Successfully Deleted');
            }

        } else {
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }
    }

}
