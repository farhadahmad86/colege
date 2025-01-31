<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Imports\ExcelDataImport;
use App\Models\AreaModel;
use App\Models\CityModel;
use App\Models\RegionModel;
use PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;


class CityController extends Controller
{
    public function add_city()
    {
        return view('add_city');
    }

    public function submit_city(Request $request)
    {
        $this->city_validation($request);

        $city = new CityModel();

        $city = $this->AssignCityValues($request, $city);

        $city->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Area With Id: ' . $city->city_id . ' And Name: ' . $city->city_name);

        // WizardController::updateWizardInfo(['area'], ['sector']);

        return redirect('add_area')->with('success', 'Successfully Saved');

    }

    public function city_validation($request)
    {
        return $this->validate($request, [
            'province' => ['required', 'string'],
            'city_name' => ['required', 'string', 'unique:financials_city,city_name']
        ]);
    }

    protected function AssignCityValues($request, $city)
    {
        $city->city_prov = $request->province;
        $city->city_name = ucwords($request->city_name);
        $city->city_flag = 'F';
        return $city;
    }
    // update code by shahzaib start
    public function city_list(Request $request, $array = null, $str = null)
    {

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_province = (!isset($request->province) && empty($request->province)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->province;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';

        $prnt_page_dir = 'print.city_list.city_list';
        $pge_title = 'City List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_province, $search_by_user);


        $pagination_number = (empty($ar) || !empty($ar)) ? 30 : 100000000;

        $query = DB::table('financials_city');


        if (!empty($search)) {

            $pagination_number = 1000000;
            $query->orWhere('city_id', 'like', '%' . $search . '%')
                ->orWhere('city_name', 'like', '%' . $search . '%')
                ->orWhere('city_prov', 'like', '%' . $search . '%');

        }

        if (!empty($search_province)) {
            $pagination_number = 1000000;
            $query->where('city_prov', '=', $search_province);
        }

        $datas = $query
//            ->where('area_delete_status', '!=', 1)
            ->orderBy('city_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);



        $city_title = CityModel::
        orderBy('city_name', 'ASC')->pluck('city_name')->all();


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
            return view('city_list', compact('datas', 'search', 'city_title', 'search_province'));
        }

    }

    // update code by shahzaib end


    public function edit_city(Request $request)
    {
        return view('edit_city', compact('request'));
    }

    public function update_city(Request $request)
    {
        $this->validate($request, [
            'province' => ['required', 'string'],
            'city_id' => ['required', 'numeric'],
//            'city_name' => ['required', 'string', 'unique:financials_city,city_name'],
            'city_name' => ['required', 'string', 'unique:financials_city,city_name,' . $request->city_id . ',city_id,city_prov,' . $request->province],


        ]);

        $city = CityModel::where('city_id', $request->city_id)->first();

        $city->city_prov = $request->province;
        $city->city_name = ucwords($request->city_name);

        if ($city->save()) {

            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update City With Id: ' . $city->city_id . ' And Name: ' . $city->city_name);

            return redirect('city_list')->with('success', 'Successfully Saved');
        } else {
            return redirect('city_list')->with('fail', 'Failed Try Again!');
        }
    }

    public function delete_area(Request $request)
    {
        $user = Auth::User();
        $delete = AreaModel::where('area_id', $request->area_id)->first();


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
