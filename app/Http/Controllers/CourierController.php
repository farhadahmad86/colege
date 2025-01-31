<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\CashPaymentVoucherItemsModel;
use App\Models\CashPaymentVoucherModel;
use App\Models\CityModel;
use App\Models\CourierCompanyBranchesModel;
use App\Models\CourierModel;
use App\Models\JournalVoucherItemsModel;
use App\Models\JournalVoucherModel;
use App\Models\ProductPackagesItemsModel;
use App\Models\ProductPackagesModel;
use App\Models\ProductRecipeModel;

use App\Models\RegionModel;
use App\Models\SystemConfigModel;
use App\Models\TransactionModel;
use PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class CourierController extends Controller
{

    //////////////////////////// Add Courier ////////////////////////////////////

    public function add_courier()
    {

        $courier_table = CourierModel::all();

        $courier_table2 = CourierCompanyBranchesModel::all();
// return $courier_table;
// dd($courier_table,$courier_table2);

        $cities = CityModel::orderby('city_name', 'ASC')->get();

        return view('add_courier', compact('cities'));
    }

    //////////////////////////// Submit Courier ////////////////////////////////////

    public function submit_courier(Request $request)
    {

        $this->validation($request);

        $rollBack = false;

        DB::beginTransaction();

        $courier = new CourierModel();

        $user_id = Auth::user()->user_id;
        $browser = $this->getBrwsrInfo();
        $ip = $this->getIp();
        $current_date_time = Carbon::now()->toDateTimeString();

        $courier = $this->AssignValues($request, $courier, $user_id, $ip, $browser, $current_date_time);

        if ($courier->save()) {
            $courier_id = $courier->cc_id;

            $items = [];

            /*
             * This array add Recipe Raw Products in Product Recipe Items Table
             */
            $cartDataForCourier = json_decode($request->products_array, true);

            $item = $this->AssignItemsValuesForQuantity($cartDataForCourier, $items, $courier_id, 'Raw-Product');

            if (!DB::table('financials_courier_company_branches')->insert($item)) {
                $rollBack = true;
                DB::rollBack();
            }
        } else {
            $rollBack = true;
            DB::rollBack();
        }

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {

            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Pack With Id: ' . $courier->cc_id . ' And Name: ' . $courier->cc_name);

            DB::commit();

            // WizardController::updateWizardInfo(['product_recipe'], []);

            return redirect()->back()->with('success', 'Successfully Saved');
        }
    }

    //////////////////////////// Validation Courier ////////////////////////////////////

    public function validation($request)
    {
        return $this->validate($request, [
            'name' => ['required', 'string'],
            'remarks' => ['nullable', 'string'],
        ]);
    }

    //////////////////////////// AssignValues Courier ////////////////////////////////////

    public function AssignValues($request, $courier, $user_id, $ip, $browser, $current_date_time)
    {
        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $courier->cc_name = ucwords($request->name);
        $courier->cc_remarks = ucfirst($request->remarks);
        $courier->cc_datetime = $current_date_time;
        $courier->cc_day_end_id = $day_end->de_id;
        $courier->cc_day_end_date = $day_end->de_datetime;
        $courier->cc_user_id = $user_id;
        $courier->cc_brwsr_info = $browser;
        $courier->cc_ip_adrs = $ip;
        $courier->cc_update_datetime = $current_date_time;

        return $courier;
    }

    public function AssignItemsValuesForQuantity($items, $data, $courier_id, $status)
    {
//        $cartDataForProductRecipes = json_decode($request->cartDataForProductRecipe, true);
        foreach ($items as $key => $item) {
            $data[] = ['ccb_courier_id' => $courier_id, 'ccb_type' => $item['type'], 'ccb_branch_name' => ucwords($item['branch_name']), 'ccb_city_id' => $item['city'], 'ccb_address' => $item['address'], 'ccb_contact_num1' => $item['contact_1'], 'ccb_contact_num2' => $item['contact_2']];
        }
        return $data;
    }

    //////////////////////////// List Courier ////////////////////////////////////

    // update code by shahzaib start
    public function courier_list(Request $request, $array = null, $str = null)
    {
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.region_list.region_list';
        $pge_title = 'Region List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_courier_company')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_courier_company.cc_user_id');

        if (!empty($search)) {
            $query->where('cc_name', 'like', '%' . $search . '%')
                ->orWhere('cc_remarks', 'like', '%' . $search . '%')
                ->orWhere('cc_id', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
//            $pagination_number = 100000000;
            $query->where('cc_user_id', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1) {
            $query->where('cc_delete_status', '=', 1);
        } else {
            $query->where('cc_delete_status', '!=', 1);
        }

        $datas = $query->orderBy('cc_id', 'DESC')
            ->paginate($pagination_number);

        $cc_title = CourierModel::orderBy('cc_id', config('global_variables.query_sorting'))->pluck('cc_name')->all();//where('reg_delete_status', '!=', 1)->


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];

            $pdf = PDF::loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('courier_list', compact('datas', 'search', 'cc_title', 'search_by_user', 'restore_list'));
        }

    }

    // update code by shahzaib end

    //////////////////////////// View Detail Courier ////////////////////////////////////

    public function courier_items_view_details(Request $request)
    {
        $items = DB::table('financials_courier_company_branches')
            ->leftJoin('financials_city', 'financials_city.city_id', 'financials_courier_company_branches.ccb_city_id')
            ->where('ccb_courier_id', $request->id)->select('financials_courier_company_branches.*', 'financials_city.city_name')->get();

//        $items = CourierCompanyBranchesModel::where('ccb_courier_id', $request->id)->get();
//            ->orderby('ccb_courier_id', 'ASC')->get();
        return response()->json($items);
    }

    //////////////////////////// Items View Detail SH Courier ////////////////////////////////////

    public function courier_items_view_details_SH(Request $request, $id)
    {

        $jrnl = CourierModel::where('cc_id', $id)->first();
        $items = DB::table('financials_courier_company_branches')
            ->leftJoin('financials_city', 'financials_city.city_id', 'financials_courier_company_branches.ccb_city_id')
            ->where('ccb_courier_id', $request->id)
            ->select('financials_courier_company_branches.*', 'financials_city.city_name')
            ->get();
//            CourierCompanyBranchesModel::where('ccb_courier_id', $id)->get();
//        $nbrOfWrds = $this->myCnvrtNbr($jrnl->jv_total_dr);
        $invoice_nbr = $jrnl->cc_id;
        $invoice_date = $jrnl->cc_created_datetime;
        $invoice_remarks = $jrnl->cc_remarks;
        $type = 'grid';
        $pge_title = 'Courier';

        return view('voucher_view.courier_company.courier_company_modal', compact('items', 'jrnl', 'type', 'pge_title','invoice_remarks','invoice_date','invoice_nbr'));

    }

    //////////////////////////// Items View Detail PDF SH Courier ////////////////////////////////////

    public function courier_items_view_details_pdf_SH(Request $request, $id)
    {

        $jrnl = CourierModel::where('cc_id', $id)->first();
        $items = DB::table('financials_courier_company_branches')
            ->leftJoin('financials_city', 'financials_city.city_id', 'financials_courier_company_branches.ccb_city_id')
            ->where('ccb_courier_id', $request->id)
            ->select('financials_courier_company_branches.*', 'financials_city.city_name')
            ->get();
//        $items = CourierCompanyBranchesModel::where('ccb_courier_id', $id)->get();
//        $nbrOfWrds = $this->myCnvrtNbr($jrnl->jv_total_dr);
        $invoice_nbr = $jrnl->cc_id;
        $invoice_date = $jrnl->cc_created_datetime;
        $invoice_remarks = $jrnl->cc_remarks;
        $type = 'pdf';
        $pge_title = 'Courier';


        $footer = view('voucher_view._partials.pdf_footer')->render();
        $header = view('voucher_view._partials.pdf_header', compact('pge_title', 'type','invoice_remarks','invoice_date','invoice_nbr'))->render();
        $options = [
            'footer-html' => $footer,
            'header-html' => $header,
            'margin-top' => 30,
        ];

        $pdf = PDF::loadView('voucher_view.courier_company.courier_company_list_modal', compact('items', 'jrnl', 'type'));
        $pdf->setOptions($options);


        return $pdf->stream('Courier-Detail.pdf');
    }

    //////////////////////////// Delete Courier ////////////////////////////////////

    public function delete_courier(Request $request)
    {
        $user = Auth::User();

        $delete = CourierModel::where('cc_id', $request->cc_id)->first();

        if ($delete->cc_delete_status == 1) {
            $delete->cc_delete_status = 0;
        } else {
            $delete->cc_delete_status = 1;
        }

        $delete->cc_deleted_by = $user->user_id;

        if ($delete->save()) {

            if ($delete->cc_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Courier With Id: ' . $delete->cc_id . ' And Name: ' . $delete->cc_name);

//                return redirect('region_list')->with('success', 'Successfully Restored');
                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Courier With Id: ' . $delete->cc_id . ' And Name: ' . $delete->cc_name);

//                return redirect('region_list')->with('success', 'Successfully Deleted');
                return redirect()->back()->with('success', 'Successfully Deleted');
            }

        } else {
//            return redirect('region_list')->with('fail', 'Failed Try Again!');
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }
    }

    //////////////////// Edit Courier /////////////////////////

    public function edit_courier(Request $request)
    {
        $cities = CityModel::orderby('city_name', 'ASC')->get();

        $courier = CourierModel::where('cc_id', $request->cc_id)->first();

        $courier_item = DB::table('financials_courier_company_branches')
            ->leftJoin('financials_city', 'financials_city.city_id', 'financials_courier_company_branches.ccb_city_id')
            ->where('ccb_courier_id', $courier->cc_id)
            ->select('financials_courier_company_branches.*', 'financials_city.city_name')
            ->get();

//        $courier_item = CourierCompanyBranchesModel::where('ccb_courier_id', '=', $courier->cc_id)->get();

        return view('edit_courier', compact('courier', 'cities', 'courier_item'));
    }


    /////////////////////// Update Courier /////////////////////////////

    public function update_courier(Request $request)
    {

        $this->validation($request);

//        $this->validate($request, [
//            'package_id' => ['required', 'numeric', 'min:1'],
//        ]);

        $rollBack = false;

        $courier = CourierModel::where('cc_id', $request->courier_id)->first();

        $user_id = Auth::user()->user_id;
        $browser = $this->getBrwsrInfo();
        $ip = $this->getIp();
        $current_date_time = Carbon::now()->toDateTimeString();

        $cartDataForCourier = json_decode($request->products_array, true);

//        $courier = $this->AssignValues($request, $courier, $user_id, $ip, $browser, $current_date_time);
        $courier = $this->AssignValues($request, $courier, $user_id, $ip, $browser, $current_date_time);

        if ($courier->save()) {
            $courier_id = $courier->cc_id;

            $delete = CourierCompanyBranchesModel::where('ccb_courier_id', $courier_id)->delete();

            if ($delete) {
                $items = [];
//                $item = $this->AssignItemsValuesForQuantity($request, $items, $courier_id, $ip, $browser, $current_date_time);
                $item = $this->AssignItemsValuesForQuantity($cartDataForCourier, $items, $courier_id, 'Raw-Product');

                if (!DB::table('financials_courier_company_branches')->insert($item)) {

                    $rollBack = true;
                    DB::rollBack();
                }
            } else {
                $rollBack = true;
                DB::rollBack();
            }
        } else {
            $rollBack = true;
            DB::rollBack();
        }

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {

            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Courier With Id: ' . $courier->cc_id . ' And Name: ' . $courier->cc_name);

            DB::commit();
            return redirect()->back()->with('success', 'Successfully Saved');
        }

    }


}
