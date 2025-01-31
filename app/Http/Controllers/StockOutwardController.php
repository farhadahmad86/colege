<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountRegisterationModel;
use App\Models\CityModel;
use App\Models\CompanyDelivery;
use App\Models\CourierModel;
use App\Models\CourierService;
use App\Models\DeliveryOrderModel;
use App\Models\SaleInvoiceModel;
use App\Models\SaleOrderModel;
use App\Models\SaleSaletaxInvoiceModel;
use App\Models\SelfCollection;
use App\Models\StockOutwardModel;
use App\Models\StockInwardModel;
use App\Models\ThirdParty;
use App\User;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class StockOutwardController extends Controller
{
    public function stock_outward()
    {

        $non_tax_invoices = SaleInvoiceModel::orderBy('si_id', 'ASC')->get();

        $tax_invoices = SaleSaletaxInvoiceModel::orderBy('ssi_id', 'ASC')->get();


        $courier_names = CourierService::where('cs_courier_id', 0)->orderBy('cs_courier_name', 'ASC')->pluck('cs_courier_name')->all();

        $accounts = $this->get_account_query('sale')[0];

        $cities = CityModel::orderby('city_name', 'ASC')->get();

        $employees = User::orderBy('user_name', 'ASC')->where('user_id', '!=', 1)->get();

        $couriers = CourierModel::where('cc_delete_status', '!=', 1)->where('cc_disabled', '!=', 1)->orderBy('cc_name', config('global_variables.drop_sorting'))->get();

        return view('stock_outward', compact('non_tax_invoices', 'tax_invoices', 'cities', 'employees', 'couriers', 'accounts', 'courier_names'));
    }

    //////////////////////////// Get Courier City name ////////////////////////////////////

    public function get_courier_city(Request $request)
    {
        $courier_id = $request->cc_id;

        $courier_cities = DB::table('financials_courier_company_branches')
            ->leftJoin('financials_city', 'financials_city.city_id', 'financials_courier_company_branches.ccb_city_id')
            ->where('ccb_courier_id', $courier_id)
            ->select('financials_courier_company_branches.*', 'financials_city.city_name')
            ->get();

//        $courier_cities = CourierCompanyBranchesModel::where('ccb_courier_id', $courier_id)->orderBy('ccb_id', 'ASC')->get();

        $get_courier_city = "<option value=''>Select City</option>";
        foreach ($courier_cities as $city) {
//            $selected = $city->ccb_id == $request->ccb_id ? 'selected' : '';
            $get_courier_city .= "<option value='$city->ccb_city_id' >$city->city_name</option>";
        }

        return response()->json($get_courier_city);
    }

    //////////////////////////// Get Courier City name ////////////////////////////////////

    //////////////////////////// Non Tax / Tax Invoices Party ////////////////////////////////////

    function get_party_invoice(Request $request)
    {
        $invoice_type = $request->invoice_type;
        $party_code = $request->party_code;
        if ($invoice_type == 'so_inv') {
            $id = StockOutwardModel::where('so_invoice_type','=','SO')->pluck('so_invoice_no');
            $invoice = SaleOrderModel::whereNotIn('so_id',$id)->where('so_party_code', '=', $party_code)->select('so_id as id')->get();
        } elseif ($invoice_type == 'do_inv') {
            $id = StockOutwardModel::where('so_invoice_type','=','DO')->pluck('so_invoice_no');
            $invoice = DeliveryOrderModel::whereNotIn('do_id',$id)->where('do_party_code', '=', $party_code)->select('do_id as id')->get();
        } elseif ($invoice_type == 'non_tax_inv') {
            $id = StockOutwardModel::where('so_invoice_type','=','SI')->pluck('so_invoice_no');
            $invoice = SaleInvoiceModel::whereNotIn('si_id',$id)->where('si_party_code', '=', $party_code)->select('si_id as id')->get();
        } else {
            $id = StockOutwardModel::where('so_invoice_type','=','STI')->pluck('so_invoice_no');
            $invoice = SaleSaletaxInvoiceModel::whereNotIn('ssi_id',$id)->where('ssi_party_code', '=', $party_code)->select('ssi_id as id')->get();
        }
        return response()->json(["invoice" => $invoice], 200);

    }

    function tax_invoice_party(Request $request)
    {
        $tax_invoice = $request->tax_invoice;
        $tax_party = SaleSaletaxInvoiceModel::where('ssi_id', '=', $tax_invoice)->select('ssi_party_code', 'ssi_party_name')->get();
        return response()->json(["tax_party" => $tax_party], 200);

    }

    //////////////////////////// Non Tax / Tax Invoices Party ////////////////////////////////////

    //////////////////////////// Submit Delivery Option ////////////////////////////////////

    public function submit_stock_outward(Request $request)
    {
        $this->validation($request);
        if ($request->delivery_option == 'self_collection') {
            $this->self_collection_validation($request);
        } else if ($request->delivery_option == 'company_delivery') {
            $this->company_delivery_validation($request);
        } else if ($request->delivery_option == 'courier_service') {
            $this->courier_validation($request);
        } else {
            $this->third_party_validation($request);
        }

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $rollBack = false;

        $user = Auth::user();

        DB::beginTransaction();

        $delivery_option_prefix = 'so';;

        $self_collection_prefix = 'sc';
        $company_delivery_prefix = 'cd';
        $courier_service_prefix = 'cs';
        $third_party_prefix = 'tp';

        $delivery_option = new StockOutwardModel();

        $self_collection = new SelfCollection();
        $company_delivery = new CompanyDelivery();
        $courier_service = new CourierService();
        $third_party = new ThirdParty();

        $notes = 'STOCK_OUTWARD';

        $delivery_option = $this->AssignDeliveryOptionValues($request, $delivery_option, $day_end, $user, $delivery_option_prefix);


        if ($delivery_option->save()) {

            $delivery_id = $delivery_option_prefix . '_id';

            $delivery_option_id = $delivery_option->$delivery_id;

        } else {
            $rollBack = true;
            DB::rollBack();

            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        if ($request->delivery_option == 'self_collection') {

//            if ($request->name != '' && $request->cnic != '' && $request->mobile != '') {

                $self_collection = $this->AssignSelfCollectionValues($request, $delivery_option_id, $self_collection, $self_collection_prefix);
//                $self_collection->save();
                if ($self_collection->save()) {


                } else {
                    $rollBack = true;
                    DB::rollBack();

                    return redirect()->back()->with('fail', 'Failed Try Again');
                }

//            }
        } elseif ($request->delivery_option == 'company_delivery') {

//            if ($request->employee != '') {

                $company_delivery = $this->AssignCompanyDeliveryValues($request, $delivery_option_id, $company_delivery, $company_delivery_prefix);
//                $company_delivery->save();
                if ($company_delivery->save()) {


                } else {
                    $rollBack = true;
                    DB::rollBack();

                    return redirect()->back()->with('fail', 'Failed Try Again');
                }

//            }

        } elseif ($request->delivery_option == 'courier_service') {

//            if ($request->courier != '' && $request->courier_slip_no != '' && $request->courier_slip_date != '') {
//&& $request->booking_city != ''
                $courier_service = $this->AssignCourierServiceValues($request, $delivery_option_id, $courier_service, $courier_service_prefix);

//                $courier_service->save();
                if ($courier_service->save()) {


                } else {
                    $rollBack = true;
                    DB::rollBack();

                    return redirect()->back()->with('fail', 'Failed Try Again');
                }

//            }
        } elseif ($request->delivery_option == 'third_party') {

//            if ($request->vehicle_no != '' && $request->vehicle_type != '' && $request->driver_name != '' && $request->driver_mobile != '') {

                $third_party = $this->AssignThirdPartyValues($request, $delivery_option_id, $third_party, $third_party_prefix);
//                $third_party->save();
                if ($third_party->save()) {


                } else {
                    $rollBack = true;
                    DB::rollBack();

                    return redirect()->back()->with('fail', 'Failed Try Again');
                }

            }
//        }

        if (!$delivery_option->save()) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }


        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $delivery_option_id);

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {
            DB::commit();

//            return redirect('')->back()->with('Success', 'Delivery Option Saved successfully.');
            return redirect()->back()->with('success', 'Successfully Saved');
        }
//        return redirect('delivery_option')->with('success', 'Successfully Saved');

    }

    //////////////////////////// Submit Delivery Option ////////////////////////////////////

    //////////////////////////// Validation Delivery Option  ////////////////////////////////////

    public function validation($request)
    {
        return $this->validate($request, [
            'party_name' => ['required', 'numeric'],
//            'sending_datetime' => ['required'],// 'date', 'regex:/^((1[0-2]|0?[1-9]):([0-5][0-9]) ?([AaPp][Mm]))/'],
            'remarks' => ['nullable', 'string'],
        ]);
    }

    public function self_collection_validation($request)
    {
        return $this->validate($request, [
            'name' => ['required', 'string'],
//            'cnic' => ['required', 'regex:/^\d{5}-\d{7}-\d$|^\d{13}$/'],
            'mobile' => ['required', 'string'],
            'remarks' => ['nullable', 'string'],
        ]);
    }

    public function company_delivery_validation($request)
    {
        return $this->validate($request, [
            'employee' => ['required', 'numeric'],
            'remarks' => ['nullable', 'string'],
        ]);
    }

    public function courier_validation($request)
    {
        return $this->validate($request, [
            'courier' => ['required', 'numeric'],
            'courier_slip_no' => ['required'],// 'date', 'regex:/^((1[0-2]|0?[1-9]):([0-5][0-9]) ?([AaPp][Mm]))/'],
            'courier_slip_date' => ['required', 'date'],
            'booking_city' => ['required', 'numeric'],
            'remarks' => ['nullable', 'string'],
        ]);
    }

    public function third_party_validation($request)
    {
        return $this->validate($request, [
            'vehicle_no' => ['required', 'string'],
            'vehicle_type' => ['required', 'string'],
            'driver_name' => ['required', 'string'],
            'driver_mobile' => ['required', 'string'],
            'remarks' => ['nullable', 'string'],
        ]);
    }

    //////////////////////////// Validation Delivery Option  ////////////////////////////////////

    //////////////////////////// AssignValues Delivery Option  ////////////////////////////////////

    public function AssignDeliveryOptionValues($request, $delivery_option, $day_end, $user, $prfx)
    {
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $invoice_type='';
        if($request->invoice_select == 'so_inv'){
            $invoice_type='SO';
        }else if($request->invoice_select == 'do_inv'){
            $invoice_type='DO';
        }else if($request->invoice_select == 'non_tax_inv'){
            $invoice_type='SI';
        }else if($request->invoice_select == 'tax_inv'){
            $invoice_type='STI';
        }


        $account_name = AccountRegisterationModel::where('account_uid', $request->party_name)->pluck('account_name')->first();
        $col_invoice_no = $prfx . '_invoice_no';
        $col_invoice_select = $prfx . '_invoice_type';
        $col_party_code = $prfx . '_party_code';
        $col_party_name = $prfx . '_party_name';
        $col_builty_qty = $prfx . '_builty_qty';
        $col_sending_datetime = $prfx . '_sending_datetime';
        $col_remarks = $prfx . '_remarks';
        $col_delivery_option_type = $prfx . '_type';


        $col_datetime = $prfx . '_datetime';
        $col_day_end_id = $prfx . '_day_end_id';
        $col_day_end_date = $prfx . '_day_end_date';
        $col_createdby = $prfx . '_createdby';

        $col_ip_adrs = $prfx . '_ip_adrs';
        $col_brwsr_info = $prfx . '_brwsr_info';


        $delivery_option->$col_invoice_no = $request->invoice_no;
        $delivery_option->$col_invoice_select = $invoice_type;
        $delivery_option->$col_party_code = $request->party_name;
        $delivery_option->$col_party_name = $account_name;
        $delivery_option->$col_builty_qty = $request->builty_qty;
        $delivery_option->$col_sending_datetime = date("Y-m-d H:i", strtotime($request->sending_datetime));
        $delivery_option->$col_remarks = $request->remarks;
        $delivery_option->$col_delivery_option_type = $request->delivery_option;


        $delivery_option->$col_datetime = Carbon::now()->toDateTimeString();
        $delivery_option->$col_day_end_id = $day_end->de_id;
        $delivery_option->$col_day_end_date = $day_end->de_datetime;
        $delivery_option->$col_createdby = $user->user_id;
        $delivery_option->$col_brwsr_info = $brwsr_rslt;
        $delivery_option->$col_ip_adrs = $ip_rslt;

        return $delivery_option;
    }

    //////////////////////////// AssignItemsValues Delivery Option  ////////////////////////////////////

    //////////////////////////// AssignValues Self Collection  ////////////////////////////////////

    public function AssignSelfCollectionValues($request, $delivery_id, $self_collection, $prfx)
    {

        $col_delivery_option_id = $prfx . '_delivery_option_id';
        $col_name = $prfx . '_name';
        $col_cnic = $prfx . '_cnic';
        $col_mobile = $prfx . '_mobile';
        $col_remarks = $prfx . '_remarks';
        $col_stock_type = $prfx . '_stock_type';


        $self_collection->$col_delivery_option_id = $delivery_id;
        $self_collection->$col_name = $request->name;
        $self_collection->$col_cnic = $request->cnic;
        $self_collection->$col_mobile = $request->mobile;
        $self_collection->$col_remarks = $request->self_collection_remarks;
        $self_collection->$col_stock_type = 'Outward';

        return $self_collection;
    }

    //////////////////////////// AssignValues Self Collection  ////////////////////////////////////

    //////////////////////////// AssignValues Company Delivery  ////////////////////////////////////

    public function AssignCompanyDeliveryValues($request, $delivery_id, $company_delivery, $prfx)
    {

        $col_delivery_option_id = $prfx . '_delivery_option_id';
        $col_employee = $prfx . '_employee_id';
        $col_remarks = $prfx . '_remarks';
        $col_stock_type = $prfx . '_stock_type';

        $company_delivery->$col_delivery_option_id = $delivery_id;
        $company_delivery->$col_employee = $request->employee;
        $company_delivery->$col_remarks = $request->company_delivery_remarks;
        $company_delivery->$col_stock_type = 'Outward';

        return $company_delivery;
    }

    //////////////////////////// AssignValues Company Delivery  ////////////////////////////////////

    //////////////////////////// AssignValues Courier Service  ////////////////////////////////////

    public function AssignCourierServiceValues($request, $delivery_id, $courier_service, $prfx)
    {

        $col_delivery_option_id = $prfx . '_delivery_option_id';
        $col_name = $prfx . '_courier_id';
        $col_courier_name = $prfx . '_courier_name';
        $col_courier_slip_no = $prfx . '_slip';
        $col_courier_slip_date = $prfx . '_slip_date';
        $col_booking_city = $prfx . '_booking_city';
        $col__destination_city = $prfx . '_destination_city';
        $col_remarks = $prfx . '_remarks';
        $col_stock_type = $prfx . '_stock_type';

        if ($request->courier != 0) {
            $courier_name = CourierModel::where('cc_id', '=', $request->courier)->pluck('cc_name')->first();
        } else {
            $courier_name = $request->other_courier;
        }

        $courier_service->$col_delivery_option_id = $delivery_id;
        $courier_service->$col_name = $request->courier;
        $courier_service->$col_courier_name = $courier_name;
        $courier_service->$col_courier_slip_no = $request->courier_slip_no;
        $courier_service->$col_courier_slip_date = date('Y-m-d', strtotime($request->courier_slip_date));
        $courier_service->$col_booking_city = $request->booking_city;
        $courier_service->$col__destination_city = $request->destination_city;
        $courier_service->$col_remarks = $request->courier_service_remarks;
        $courier_service->$col_stock_type = 'Outward';

        return $courier_service;
    }

    //////////////////////////// AssignValues Courier Service  ////////////////////////////////////

    //////////////////////////// AssignValues Third Party  ////////////////////////////////////

    public function AssignThirdPartyValues($request, $delivery_id, $third_party, $prfx)
    {

        $col_delivery_option_id = $prfx . '_delivery_option_id';
        $col_vehicle_no = $prfx . '_vehicle_no';
        $col_vehicle_type = $prfx . '_vehicle_type';
        $col_driver_name = $prfx . '_driver_name';
        $col_driver_mobile = $prfx . '_mobile';
        $col_remarks = $prfx . '_remarks';
        $col_stock_type = $prfx . '_stock_type';


        $third_party->$col_delivery_option_id = $delivery_id;
        $third_party->$col_vehicle_no = $request->vehicle_no;
        $third_party->$col_vehicle_type = $request->vehicle_type;
        $third_party->$col_driver_name = $request->driver_name;
        $third_party->$col_driver_mobile = $request->driver_mobile;
        $third_party->$col_remarks = $request->third_party_remarks;
        $third_party->$col_stock_type = 'Outward';

        return $third_party;
    }

    //////////////////////////// AssignValues Third Party  ////////////////////////////////////

    //////////////////////////// List Courier ////////////////////////////////////


    // update code by shahzaib start
    public function stock_outward_list(Request $request, $array = null, $str = null)
    {
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.stock_outward_list.stock_outward_list';
        $pge_title = 'Stock Outward List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $query = DB::table('financials_stock_outward')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_stock_outward.so_createdby');

        if (!empty($search)) {
            $query->where('so_purchase_order_id', 'like', '%' . $search . '%')
                ->orWhere('so_remarks', 'like', '%' . $search . '%')
                ->orWhere('so_id', 'like', '%' . $search . '%')
                ->orWhere('so_party_name', 'like', '%' . $search . '%')
                ->orWhere('so_party_code', 'like', '%' . $search . '%')
                ->orWhere('so_sending_datetime', 'like', '%' . $search . '%')
                ->orWhere('so_type', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
//            $pagination_number = 100000000;
            $query->where('so_createdby', $search_by_user);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('si_day_end_date', [$start, $end]);
            $query->whereDate('so_datetime', '>=', $start)
                ->whereDate('so_datetime', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('so_datetime', $start);
        } elseif (!empty($search_from)) {
            $query->where('so_datetime', $end);
        }


//        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('so_datetime', [$start, $end]);
//        } elseif (!empty($search_to)) {
//            $query->where('so_datetime', $start);
//        } elseif (!empty($search_from)) {
//            $query->where('so_datetime', $end);
//        }

        $datas = $query->orderBy('so_id', 'DESC')
            ->paginate($pagination_number);

        $do_title = StockOutwardModel::orderBy('so_id', config('global_variables.query_sorting'))->groupBy('so_party_name')->pluck('so_party_name')->all();//where('reg_delete_status', '!=', 1)->


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
            $pdf = PDF::loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('stock_outward_list', compact('datas', 'search', 'do_title', 'search_by_user', 'search_to', 'search_from'));
        }

    }

    // update code by shahzaib end

//    //////////////////////////// View Detail Courier ////////////////////////////////////
//
    public function stock_outward_view_details(Request $request, $id)
    {
        $items = SelfCollection::where('sc_delivery_option_id', $id)->where('sc_stock_type', '=','Outward')->get();
//            ->orderby('ccb_courier_id', 'ASC')->get();
        return response()->json($items);
    }

    //////////////////////////// Items View Detail SH Courier ////////////////////////////////////

    public function stock_outward_view_details_SH(Request $request, $id)
    {

        $jrnl = StockOutwardModel::where('so_id', $id)->first();

        if ($request->type == 'self_collection') {
            $items = SelfCollection::where('sc_delivery_option_id', $id)->where('sc_stock_type', '=','Outward')->get();
//            $nbrOfWrds = $this->myCnvrtNbr($jrnl->jv_total_dr);
            $invoice_nbr = $jrnl->so_id;
            $invoice_date = $jrnl->so_datetime;
            $invoice_remarks = $jrnl->so_remarks;
            $type = 'grid';
            $pge_title = 'Stock Outward';
            $delivery_title = 'Client Collection';

            return view('voucher_view.stock_outward.self_collection_modal', compact('items', 'jrnl', 'type', 'pge_title', 'invoice_remarks', 'invoice_date', 'invoice_nbr','delivery_title'));
        } else if ($request->type == 'company_delivery') {
            $items = DB::table('financials_company_delivery')
                ->leftJoin('financials_users', 'financials_users.user_id', 'financials_company_delivery.cd_employee_id')
                ->where('cd_delivery_option_id', $request->id)
                ->where('cd_stock_type', '=','Outward')
                ->select('financials_company_delivery.*', 'financials_users.user_name')
                ->get();

//            $items = CompanyDelivery::where('cd_delivery_option_id', $id)->get();

//            $nbrOfWrds = $this->myCnvrtNbr($jrnl->jv_total_dr);
            $invoice_nbr = $jrnl->so_id;
            $invoice_date = $jrnl->so_datetime;
            $invoice_remarks = $jrnl->so_remarks;
            $type = 'grid';
            $pge_title = 'Stock Outward';
            $delivery_title = 'Company Delivery';

            return view('voucher_view.stock_outward.company_delivery_modal', compact('items', 'jrnl', 'type', 'pge_title', 'invoice_remarks', 'invoice_date', 'invoice_nbr', 'delivery_title'));

        } else if ($request->type == 'courier_service') {
            $items = DB::table('financials_courier_service')
                ->leftJoin('financials_city as courier_city', 'courier_city.city_id', 'financials_courier_service.cs_courier_id')
                ->leftJoin('financials_city as booking_city', 'booking_city.city_id', 'financials_courier_service.cs_booking_city')
                ->leftJoin('financials_city as destination_city', 'destination_city.city_id', 'financials_courier_service.cs_destination_city')
                ->where('cs_delivery_option_id', $request->id)
                ->where('cs_stock_type', '=','Outward')
                ->select('financials_courier_service.*', 'courier_city.city_name', 'destination_city.city_name as destination_name', 'booking_city.city_name as booking_name')
                ->get();

//            $items = CompanyDelivery::where('cd_delivery_option_id', $id)->get();

//            $nbrOfWrds = $this->myCnvrtNbr($jrnl->jv_total_dr);
            $invoice_nbr = $jrnl->so_id;
            $invoice_date = $jrnl->so_datetime;
            $invoice_remarks = $jrnl->so_remarks;
            $type = 'grid';
            $pge_title = 'Stock Outward';
            $delivery_title = 'Courier Service';

            return view('voucher_view.stock_outward.courier_service_modal', compact('items', 'jrnl', 'type', 'pge_title', 'invoice_remarks', 'invoice_date', 'invoice_nbr', 'delivery_title'));

        } else if ($request->type == 'third_party') {

            $items = ThirdParty::where('tp_delivery_option_id', $id)->where('tp_stock_type', '=','Outward')->get();
//            $nbrOfWrds = $this->myCnvrtNbr($jrnl->jv_total_dr);
            $invoice_nbr = $jrnl->so_id;
            $invoice_date = $jrnl->so_datetime;
            $invoice_remarks = $jrnl->so_remarks;
            $type = 'grid';
            $pge_title = 'Stock Outward';
            $delivery_title = 'Third Party';

            return view('voucher_view.stock_outward.third_party_modal', compact('items', 'jrnl', 'type', 'pge_title', 'invoice_remarks', 'invoice_date', 'invoice_nbr', 'delivery_title'));
        }

    }

//    //////////////////////////// Items View Detail PDF SH Courier ////////////////////////////////////

    public function stock_outward_view_details_pdf_SH(Request $request, $id)
    {

        $jrnl = StockOutwardModel::where('so_id', $id)->first();

        if ($jrnl->so_type == 'self_collection') {
            $items = SelfCollection::where('sc_delivery_option_id', $id)->where('sc_stock_type', '=','Outward')->get();
//        $nbrOfWrds = $this->myCnvrtNbr($jrnl->jv_total_dr);
            $invoice_nbr = $jrnl->so_id;
            $invoice_date = $jrnl->so_datetime;
            $invoice_remarks = $jrnl->so_remarks;
            $type = 'pdf';
            $pge_title = 'Stock Outward';
            $delivery_title = 'Client Collection';

            $footer = view('voucher_view._partials.pdf_footer')->render();
            $header = view('voucher_view._partials.pdf_header', compact('pge_title', 'type', 'invoice_remarks', 'invoice_date', 'invoice_nbr', 'delivery_title'))->render();
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
            $pdf->loadView('voucher_view.stock_outward.self_collection_modal', compact('items', 'jrnl', 'type', 'delivery_title','invoice_nbr','invoice_date','pge_title','invoice_remarks'));
            // $pdf->setOptions($options);

        } else if ($jrnl->so_type == 'company_delivery') {
            $items = DB::table('financials_company_delivery')
                ->leftJoin('financials_users', 'financials_users.user_id', 'financials_company_delivery.cd_employee_id')
                ->where('cd_delivery_option_id', $request->id)
                ->where('cd_stock_type', '=','Outward')
                ->select('financials_company_delivery.*', 'financials_users.user_name')
                ->get();
//        $nbrOfWrds = $this->myCnvrtNbr($jrnl->jv_total_dr);
            $invoice_nbr = $jrnl->so_id;
            $invoice_date = $jrnl->so_datetime;
            $invoice_remarks = $jrnl->so_remarks;
            $type = 'pdf';
            $pge_title = 'Stock Outward';
            $delivery_title = 'Company Delivery';

            $footer = view('voucher_view._partials.pdf_footer')->render();
            $header = view('voucher_view._partials.pdf_header', compact('pge_title', 'type', 'invoice_remarks', 'invoice_date', 'invoice_nbr', 'delivery_title'))->render();
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
            $pdf->loadView('voucher_view.stock_outward.company_delivery_modal', compact('items', 'jrnl', 'type', 'delivery_title','invoice_nbr','invoice_date','pge_title', 'invoice_remarks'));
            // $pdf->setOptions($options);

        } else if ($jrnl->so_type == 'courier_service') {
            $items = DB::table('financials_courier_service')
                ->leftJoin('financials_city as courier_city', 'courier_city.city_id', 'financials_courier_service.cs_courier_id')
                ->leftJoin('financials_city as booking_city', 'booking_city.city_id', 'financials_courier_service.cs_booking_city')
                ->leftJoin('financials_city as destination_city', 'destination_city.city_id', 'financials_courier_service.cs_destination_city')
                ->where('cs_delivery_option_id', $request->id)
                ->where('cs_stock_type', '=','Outward')
                ->select('financials_courier_service.*', 'courier_city.city_name', 'destination_city.city_name as destination_name', 'booking_city.city_name as booking_name')
                ->get();

//        $nbrOfWrds = $this->myCnvrtNbr($jrnl->jv_total_dr);
            $invoice_nbr = $jrnl->so_id;
            $invoice_date = $jrnl->so_datetime;
            $invoice_remarks = $jrnl->so_remarks;
            $type = 'pdf';
            $pge_title = 'Stock Outward';
            $delivery_title = 'Courier Service';

            $footer = view('voucher_view._partials.pdf_footer')->render();
            $header = view('voucher_view._partials.pdf_header', compact('pge_title', 'type', 'invoice_remarks', 'invoice_date', 'invoice_nbr','delivery_title'))->render();
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
                'margin-top' => 30
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled'=>true, 'isRemoteEnabled'=>true]);
            $pdf->getDomPDF()->setHttpContext($options,$optionss);
            $pdf->loadView('voucher_view.stock_outward.courier_service_modal', compact('items', 'jrnl', 'type', 'delivery_title', 'invoice_remarks', 'invoice_date', 'invoice_nbr','pge_title'));
//            $pdf->setOptions($options);

        } else if ($jrnl->so_type == 'third_party') {

            $items = ThirdParty::where('tp_delivery_option_id', $id)->where('tp_stock_type', '=','Outward')->get();
//        $nbrOfWrds = $this->myCnvrtNbr($jrnl->jv_total_dr);
            $invoice_nbr = $jrnl->so_id;
            $invoice_date = $jrnl->so_datetime;
            $invoice_remarks = $jrnl->so_remarks;
            $type = 'pdf';
            $pge_title = 'Stock Outward';
            $delivery_title = 'Third party';

            $footer = view('voucher_view._partials.pdf_footer')->render();
            $header = view('voucher_view._partials.pdf_header', compact('pge_title', 'type', 'invoice_remarks', 'invoice_date', 'invoice_nbr', 'delivery_title'))->render();
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
                'margin-top' => 30
            ];
            $pdf = PDF::setOptions(['isHTML5ParserEnabled'=>true, 'isRemoteEnabled'=>true]);
            $pdf->getDomPDF()->setHttpContext($options,$optionss);
            $pdf->loadView('voucher_view.stock_outward.third_party_modal', compact('items', 'jrnl', 'type','delivery_title', 'invoice_remarks', 'invoice_date', 'invoice_nbr', 'pge_title'));
//            $pdf->setOptions($options);

        }

        return $pdf->stream('Stock-Outward-Detail.pdf');
    }


//    list 2 start

    public function stock_outward_detail_list(Request $request, $array = null, $str = null)
    {
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_outward_type = (!isset($request->inward_type) && empty($request->inward_type)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->inward_type;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.stock_outward_list.stock_outward_list';
        $pge_title = 'Stock Outward List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from, $search_outward_type);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));


        $datas = DB::select(DB::raw("select * from `financials_stock_outward` left join `financials_self_collection` on `financials_self_collection`.`sc_delivery_option_id` = `financials_stock_outward`.`so_id` left join `financials_third_party` on `financials_third_party`.`tp_delivery_option_id` = `financials_stock_outward`.`so_id` left join `financials_courier_service` on `financials_courier_service`.`cs_delivery_option_id` = `financials_stock_outward`.`so_id` left join `financials_company_delivery` on `financials_company_delivery`.`cd_delivery_option_id` = `financials_stock_outward`.`so_id` left join `financials_users` on `financials_users`.`user_id` = `financials_company_delivery`.`cd_employee_id` left join `financials_city` on `financials_city`.`city_id` = `financials_courier_service`.`cs_courier_id` where (`financials_self_collection`.`sc_stock_type` = 'Outward' or `financials_third_party`.`tp_stock_type` = 'Outward' or `financials_courier_service`.`cs_stock_type` = 'Outward' or `financials_company_delivery`.`cd_stock_type` = 'Outward')"));


        if ((!empty($search_to)) && (!empty($search_from)) && (!empty($search_outward_type))) {
            $datas = DB::select(DB::raw("select * from `financials_stock_outward` left join `financials_self_collection` on `financials_self_collection`.`sc_delivery_option_id` = `financials_stock_outward`.`so_id` left join `financials_third_party` on `financials_third_party`.`tp_delivery_option_id` = `financials_stock_outward`.`so_id` left join `financials_courier_service` on `financials_courier_service`.`cs_delivery_option_id` = `financials_stock_outward`.`so_id` left join `financials_company_delivery` on `financials_company_delivery`.`cd_delivery_option_id` = `financials_stock_outward`.`so_id` left join `financials_users` on `financials_users`.`user_id` = `financials_company_delivery`.`cd_employee_id` left join `financials_city` on `financials_city`.`city_id` = `financials_courier_service`.`cs_courier_id` where (`financials_self_collection`.`sc_stock_type` = 'Outward' or `financials_third_party`.`tp_stock_type` = 'Outward' or `financials_courier_service`.`cs_stock_type` = 'Outward' or `financials_company_delivery`.`cd_stock_type` = 'Outward') and (`financials_stock_outward`.`so_type` = '".$search_outward_type."')  and (`financials_stock_outward`.`so_datetime` BETWEEN '".$start."' AND '".$end."') "));
        }
        else if ((!empty($search_to)) && (!empty($search_outward_type))) {
            $datas = DB::select(DB::raw("select * from `financials_stock_outward` left join `financials_self_collection` on `financials_self_collection`.`sc_delivery_option_id` = `financials_stock_outward`.`so_id` left join `financials_third_party` on `financials_third_party`.`tp_delivery_option_id` = `financials_stock_outward`.`so_id` left join `financials_courier_service` on `financials_courier_service`.`cs_delivery_option_id` = `financials_stock_outward`.`so_id` left join `financials_company_delivery` on `financials_company_delivery`.`cd_delivery_option_id` = `financials_stock_outward`.`so_id` left join `financials_users` on `financials_users`.`user_id` = `financials_company_delivery`.`cd_employee_id` left join `financials_city` on `financials_city`.`city_id` = `financials_courier_service`.`cs_courier_id` where (`financials_self_collection`.`sc_stock_type` = 'Outward' or `financials_third_party`.`tp_stock_type` = 'Outward' or `financials_courier_service`.`cs_stock_type` = 'Outward' or `financials_company_delivery`.`cd_stock_type` = 'Outward') and (`financials_stock_outward`.`so_type` = '".$search_outward_type."')  and (`financials_stock_outward`.`so_datetime` LIKE '".$start."%') "));
        }
        else if ((!empty($search_to)) && (!empty($search_from))) {
            $datas = DB::select(DB::raw("select * from `financials_stock_outward` left join `financials_self_collection` on `financials_self_collection`.`sc_delivery_option_id` = `financials_stock_outward`.`so_id` left join `financials_third_party` on `financials_third_party`.`tp_delivery_option_id` = `financials_stock_outward`.`so_id` left join `financials_courier_service` on `financials_courier_service`.`cs_delivery_option_id` = `financials_stock_outward`.`so_id` left join `financials_company_delivery` on `financials_company_delivery`.`cd_delivery_option_id` = `financials_stock_outward`.`so_id` left join `financials_users` on `financials_users`.`user_id` = `financials_company_delivery`.`cd_employee_id` left join `financials_city` on `financials_city`.`city_id` = `financials_courier_service`.`cs_courier_id` where (`financials_self_collection`.`sc_stock_type` = 'Outward' or `financials_third_party`.`tp_stock_type` = 'Outward' or `financials_courier_service`.`cs_stock_type` = 'Outward' or `financials_company_delivery`.`cd_stock_type` = 'Outward') and (`financials_stock_outward`.`so_datetime` BETWEEN '".$start."' AND '".$end."') "));
        }
        else if (!empty($search_outward_type)) {
            $datas = DB::select(DB::raw("select * from `financials_stock_outward` left join `financials_self_collection` on `financials_self_collection`.`sc_delivery_option_id` = `financials_stock_outward`.`so_id` left join `financials_third_party` on `financials_third_party`.`tp_delivery_option_id` = `financials_stock_outward`.`so_id` left join `financials_courier_service` on `financials_courier_service`.`cs_delivery_option_id` = `financials_stock_outward`.`so_id` left join `financials_company_delivery` on `financials_company_delivery`.`cd_delivery_option_id` = `financials_stock_outward`.`so_id` left join `financials_users` on `financials_users`.`user_id` = `financials_company_delivery`.`cd_employee_id` left join `financials_city` on `financials_city`.`city_id` = `financials_courier_service`.`cs_courier_id` where (`financials_self_collection`.`sc_stock_type` = 'Outward' or `financials_third_party`.`tp_stock_type` = 'Outward' or `financials_courier_service`.`cs_stock_type` = 'Outward' or `financials_company_delivery`.`cd_stock_type` = 'Outward') and (`financials_stock_outward`.`so_type` = '".$search_outward_type."')"));
        }
        else if (!empty($search_to)) {
            $datas = DB::select(DB::raw("select * from `financials_stock_outward` left join `financials_self_collection` on `financials_self_collection`.`sc_delivery_option_id` = `financials_stock_outward`.`so_id` left join `financials_third_party` on `financials_third_party`.`tp_delivery_option_id` = `financials_stock_outward`.`so_id` left join `financials_courier_service` on `financials_courier_service`.`cs_delivery_option_id` = `financials_stock_outward`.`so_id` left join `financials_company_delivery` on `financials_company_delivery`.`cd_delivery_option_id` = `financials_stock_outward`.`so_id` left join `financials_users` on `financials_users`.`user_id` = `financials_company_delivery`.`cd_employee_id` left join `financials_city` on `financials_city`.`city_id` = `financials_courier_service`.`cs_courier_id` where (`financials_self_collection`.`sc_stock_type` = 'Outward' or `financials_third_party`.`tp_stock_type` = 'Outward' or `financials_courier_service`.`cs_stock_type` = 'Outward' or `financials_company_delivery`.`cd_stock_type` = 'Outward') and (`financials_stock_outward`.`so_datetime` LIKE '".$start."%')"));
        }


//
//        $datas = $query->orderBy('so_id', 'DESC')
//            ->paginate($pagination_number);

        $do_title = StockOutwardModel::orderBy('so_id', config('global_variables.query_sorting'))->groupBy('so_party_name')->pluck('so_party_name')->all();//where('reg_delete_status', '!=', 1)->


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
            return view('stock_outward_detail_list', compact('datas', 'search', 'do_title', 'search_by_user', 'search_to', 'search_from', 'search_outward_type'));
        }

    }

    // update code by Mustafa start
    public function dispatch_list(Request $request, $array = null, $str = null)
    {
        $auth_id = Auth::user()->user_id;
        $account_id = AccountRegisterationModel::where('account_employee_id',$auth_id)->pluck('account_uid')->first();
        $ar = json_decode($request->array);
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.stock_outward_list.stock_outward_list';
        $pge_title = 'Dispatch List';
        $srch_fltr = [];
        array_push($srch_fltr, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $query = DB::table('financials_stock_outward')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_stock_outward.so_createdby')
        ->where('so_party_code',$account_id);

        if (!empty($search_by_user)) {
//            $pagination_number = 100000000;
            $query->where('so_createdby', $search_by_user);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('si_day_end_date', [$start, $end]);
            $query->whereDate('so_datetime', '>=', $start)
                ->whereDate('so_datetime', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('so_datetime', $start);
        } elseif (!empty($search_from)) {
            $query->where('so_datetime', $end);
        }


//        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('so_datetime', [$start, $end]);
//        } elseif (!empty($search_to)) {
//            $query->where('so_datetime', $start);
//        } elseif (!empty($search_from)) {
//            $query->where('so_datetime', $end);
//        }

        $datas = $query->orderBy('so_id', 'DESC')
            ->paginate($pagination_number);

        $do_title = StockOutwardModel::orderBy('so_id', config('global_variables.query_sorting'))->groupBy('so_party_name')->pluck('so_party_name')->all();//where('reg_delete_status', '!=', 1)->


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
            return view('cart.dispatch_list', compact('datas', 'do_title', 'search_by_user', 'search_to', 'search_from'));
        }

    }

    // update code by Mustafa end

//    list 2 end


}
