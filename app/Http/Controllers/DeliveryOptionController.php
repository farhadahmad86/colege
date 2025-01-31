<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;

use App\Models\CompanyDelivery;
use App\Models\CourierModel;
use App\Models\CourierService;
use App\Models\DeliveryOption;
use App\Models\SaleInvoiceModel;
use App\Models\SaleSaletaxInvoiceModel;
use App\Models\SelfCollection;
use App\Models\ThirdParty;
use App\User;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class DeliveryOptionController extends Controller
{

    public function delivery_option()
    {
        $non_tax_invoices = SaleInvoiceModel::orderBy('si_id', 'ASC')->get();

        $tax_invoices = SaleSaletaxInvoiceModel::orderBy('ssi_id', 'ASC')->get();

        $employees = User::orderBy('user_name', 'ASC')->where('user_id', '!=', 1)->get();

        $couriers = CourierModel::where('cc_delete_status', '!=', 1)->where('cc_disabled', '!=', 1)->orderBy('cc_name', config('global_variables.drop_sorting'))->get();

        return view('delivery_option', compact('non_tax_invoices', 'tax_invoices', 'employees', 'couriers'));
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

    function non_tax_invoice_party(Request $request)
    {
        $non_tax_invoice = $request->non_tax_invoice;
        $non_tax_party = SaleInvoiceModel::where('si_id', '=', $non_tax_invoice)->select('si_party_code', 'si_party_name')->get();
        return response()->json(["non_tax_party" => $non_tax_party], 200);

    }

    function tax_invoice_party(Request $request)
    {
        $tax_invoice = $request->tax_invoice;
        $tax_party = SaleSaletaxInvoiceModel::where('ssi_id', '=', $tax_invoice)->select('ssi_party_code', 'ssi_party_name')->get();
        return response()->json(["tax_party" => $tax_party], 200);

    }

    //////////////////////////// Non Tax / Tax Invoices Party ////////////////////////////////////

    //////////////////////////// Submit Delivery Option ////////////////////////////////////

    public function submit_delivery_option(Request $request)
    {


        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $rollBack = false;

        $user = Auth::user();

        DB::beginTransaction();

        $delivery_option_prefix = 'do';;

        $self_collection_prefix = 'sc';
        $company_delivery_prefix = 'cd';
        $courier_service_prefix = 'cs';
        $third_party_prefix = 'tp';

        $delivery_option = new DeliveryOption();

        $self_collection = new SelfCollection();
        $company_delivery = new CompanyDelivery();
        $courier_service = new CourierService();
        $third_party = new ThirdParty();

        $notes = 'DELIVERY_OPTION';

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

            if ($request->name != '' && $request->cnic != '' && $request->mobile != '') {

                $self_collection = $this->AssignSelfCollectionValues($request, $delivery_option_id, $self_collection, $self_collection_prefix);
//                $self_collection->save();
                if ($self_collection->save()) {


                } else {
                    $rollBack = true;
                    DB::rollBack();

                    return redirect()->back()->with('fail', 'Failed Try Again');
                }

            }
        } elseif ($request->delivery_option == 'company_delivery') {

            if ($request->employee != '') {

                $company_delivery = $this->AssignCompanyDeliveryValues($request, $delivery_option_id, $company_delivery, $company_delivery_prefix);
//                $company_delivery->save();
                if ($company_delivery->save()) {


                } else {
                    $rollBack = true;
                    DB::rollBack();

                    return redirect()->back()->with('fail', 'Failed Try Again');
                }

            }

        } elseif ($request->delivery_option == 'courier_service') {

            if ($request->courier != '' && $request->courier_slip_no != '' && $request->courier_slip_date != '' && $request->booking_city != '' && $request->destination_city != '') {

                $courier_service = $this->AssignCourierServiceValues($request, $delivery_option_id, $courier_service, $courier_service_prefix);

//                $courier_service->save();
                if ($courier_service->save()) {


                } else {
                    $rollBack = true;
                    DB::rollBack();

                    return redirect()->back()->with('fail', 'Failed Try Again');
                }

            }
        } elseif ($request->delivery_option == 'third_party') {

            if ($request->vehicle_no != '' && $request->vehicle_type != '' && $request->driver_name != '' && $request->driver_mobile != '') {

                $third_party = $this->AssignThirdPartyValues($request, $delivery_option_id, $third_party, $third_party_prefix);
//                $third_party->save();
                if ($third_party->save()) {


                } else {
                    $rollBack = true;
                    DB::rollBack();

                    return redirect()->back()->with('fail', 'Failed Try Again');
                }

            }
        }

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
            return redirect('delivery_option')->with('success', 'Successfully Saved');
        }
        return redirect('delivery_option')->with('success', 'Successfully Saved');

    }

    //////////////////////////// Submit Delivery Option ////////////////////////////////////

    //////////////////////////// Validation Delivery Option  ////////////////////////////////////

    public function validation($request)
    {
        return $this->validate($request, [
            'non_tax_invoice' => ['required', 'string'],
            'tax_invoice' => ['required', 'string'],
            'invoice_date' => ['required', 'date'],
            'collection_datetime' => ['required', 'date', 'regex:/^((1[0-2]|0?[1-9]):([0-5][0-9]) ?([AaPp][Mm]))/'],
            'remarks' => ['nullable', 'string'],
        ]);
    }

    //////////////////////////// Validation Delivery Option  ////////////////////////////////////

    //////////////////////////// AssignValues Delivery Option  ////////////////////////////////////

    public function AssignDeliveryOptionValues($request, $delivery_option, $day_end, $user, $prfx)
    {
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $col_invoice_type = $prfx . '_invoice_type';
        $col_invoice_no = $prfx . '_invoice_no';
        $col_party_code = $prfx . '_party_code';
        $col_party_name = $prfx . '_party_name';
        $col_invoice_date = $prfx . '_date';
        $col_order_no = $prfx . '_order_no';
        $col_delivery_order_no = $prfx . '_delivery_order_no';
        $col_gate_pass = $prfx . '_gate_pass';
        $col_collection_datetime = $prfx . '_collection_datetime';
        $col_remarks = $prfx . '_remarks';
        $col_delivery_option_type = $prfx . '_type';


        $col_datetime = $prfx . '_datetime';
        $col_day_end_id = $prfx . '_day_end_id';
        $col_day_end_date = $prfx . '_day_end_date';
        $col_createdby = $prfx . '_createdby';

        $col_ip_adrs = $prfx . '_ip_adrs';
        $col_brwsr_info = $prfx . '_brwsr_info';


        $delivery_option->$col_invoice_type = $request->invoice_select;
        $delivery_option->$col_invoice_no = $request->selected_invoice;
        $delivery_option->$col_party_code = $request->party_code;
        $delivery_option->$col_party_name = $request->party_name;
        $delivery_option->$col_invoice_date = date('Y-m-d', strtotime($request->invoice_date));
        $delivery_option->$col_order_no = $request->order_no;
        $delivery_option->$col_delivery_order_no = $request->delivery_order_no;
        $delivery_option->$col_gate_pass = $request->gate_pass;
        $delivery_option->$col_collection_datetime = date("Y-m-d H:i", strtotime($request->collection_datetime));
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


        $self_collection->$col_delivery_option_id = $delivery_id;
        $self_collection->$col_name = $request->name;
        $self_collection->$col_cnic = $request->cnic;
        $self_collection->$col_mobile = $request->mobile;
        $self_collection->$col_remarks = $request->self_collection_remarks;

        return $self_collection;
    }

    //////////////////////////// AssignValues Self Collection  ////////////////////////////////////

    //////////////////////////// AssignValues Company Delivery  ////////////////////////////////////

    public function AssignCompanyDeliveryValues($request, $delivery_id, $company_delivery, $prfx)
    {

        $col_delivery_option_id = $prfx . '_delivery_option_id';
        $col_employee = $prfx . '_employee_id';
        $col_remarks = $prfx . '_remarks';

        $company_delivery->$col_delivery_option_id = $delivery_id;
        $company_delivery->$col_employee = $request->employee;
        $company_delivery->$col_remarks = $request->company_delivery_remarks;

        return $company_delivery;
    }

    //////////////////////////// AssignValues Company Delivery  ////////////////////////////////////

    //////////////////////////// AssignValues Courier Service  ////////////////////////////////////

    public function AssignCourierServiceValues($request, $delivery_id, $courier_service, $prfx)
    {

        $col_delivery_option_id = $prfx . '_delivery_option_id';
        $col_name = $prfx . '_courier_id';
        $col_courier_slip_no = $prfx . '_slip';
        $col_courier_slip_date = $prfx . '_slip_date';
        $col_booking_city = $prfx . '_booking_city';
        $col__destination_city = $prfx . '_destination_city';
        $col_remarks = $prfx . '_remarks';


        $courier_service->$col_delivery_option_id = $delivery_id;
        $courier_service->$col_name = $request->courier;
        $courier_service->$col_courier_slip_no = $request->courier_slip_no;
        $courier_service->$col_courier_slip_date = date('Y-m-d', strtotime($request->courier_slip_date));
        $courier_service->$col_booking_city = $request->booking_city;
        $courier_service->$col__destination_city = $request->destination_city;
        $courier_service->$col_remarks = $request->courier_service_remarks;

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


        $third_party->$col_delivery_option_id = $delivery_id;
        $third_party->$col_vehicle_no = $request->vehicle_no;
        $third_party->$col_vehicle_type = $request->vehicle_type;
        $third_party->$col_driver_name = $request->driver_name;
        $third_party->$col_driver_mobile = $request->driver_mobile;
        $third_party->$col_remarks = $request->third_party_remarks;

        return $third_party;
    }

    //////////////////////////// AssignValues Third Party  ////////////////////////////////////

    //////////////////////////// List Courier ////////////////////////////////////

    // update code by shahzaib start
    public function delivery_option_list(Request $request, $array = null, $str = null)
    {
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.delivery_option_list.delivery_option_list';
        $pge_title = 'Delivery Option List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $query = DB::table('financials_delivery_option')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_delivery_option.do_createdby');

        if (!empty($search)) {
            $query->where('do_invoice_no', 'like', '%' . $search . '%')
                ->orWhere('do_remarks', 'like', '%' . $search . '%')
                ->orWhere('do_id', 'like', '%' . $search . '%')
                ->orWhere('do_party_name', 'like', '%' . $search . '%')
                ->orWhere('do_party_code', 'like', '%' . $search . '%')
                ->orWhere('do_date', 'like', '%' . $search . '%')
                ->orWhere('do_collection_datetime', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_by_user)) {
//            $pagination_number = 100000000;
            $query->where('do_createdby', $search_by_user);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereBetween('do_day_end_date', [$start, $end]);
        } elseif (!empty($search_to)) {
            $query->where('do_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('do_day_end_date', $end);
        }

        $datas = $query->orderBy('do_id', 'DESC')
            ->paginate($pagination_number);

        $do_title = DeliveryOption::orderBy('do_id', config('global_variables.query_sorting'))->pluck('do_invoice_no')->all();//where('reg_delete_status', '!=', 1)->


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
            return view('delivery_option_list', compact('datas', 'search', 'do_title', 'search_by_user', 'search_to', 'search_from'));
        }

    }

    // update code by shahzaib end

//    //////////////////////////// View Detail Courier ////////////////////////////////////
//
    public function delivery_option_view_details(Request $request, $id)
    {

// $id = $request->id;
// $type = $request->type;

//        $items = DB::table('financials_courier_company_branches')
//            ->leftJoin('financials_city', 'financials_city.city_id', 'financials_courier_company_branches.ccb_city_id')
//            ->where('ccb_courier_id', $request->id)->select('financials_courier_company_branches.*', 'financials_city.city_name')->get();

        $items = SelfCollection::where('sc_delivery_option_id', $id)->get();
//            ->orderby('ccb_courier_id', 'ASC')->get();
        return response()->json($items);
    }

    //////////////////////////// Items View Detail SH Courier ////////////////////////////////////

    public function delivery_option_view_details_SH(Request $request, $id)
    {

        $jrnl = DeliveryOption::where('do_id', $id)->first();

        if ($request->type == 'self_collection') {
            $items = SelfCollection::where('sc_delivery_option_id', $id)->get();
//            $nbrOfWrds = $this->myCnvrtNbr($jrnl->jv_total_dr);
            $invoice_nbr = $jrnl->do_id;
            $invoice_date = $jrnl->do_created_datetime;
            $invoice_remarks = $jrnl->do_remarks;
            $type = 'grid';
            $pge_title = 'Self Collection';

            return view('voucher_view.delivery_option.self_collection_modal', compact('items', 'jrnl', 'type', 'pge_title', 'invoice_remarks', 'invoice_date', 'invoice_nbr'));
        } else if ($request->type == 'company_delivery') {
            $items = DB::table('financials_company_delivery')
                ->leftJoin('financials_users', 'financials_users.user_id', 'financials_company_delivery.cd_employee_id')
                ->where('cd_delivery_option_id', $request->id)
                ->select('financials_company_delivery.*', 'financials_users.user_name')
                ->get();

//            $items = CompanyDelivery::where('cd_delivery_option_id', $id)->get();

//            $nbrOfWrds = $this->myCnvrtNbr($jrnl->jv_total_dr);
            $invoice_nbr = $jrnl->do_id;
            $invoice_date = $jrnl->do_created_datetime;
            $invoice_remarks = $jrnl->do_remarks;
            $type = 'grid';
            $pge_title = 'Company Delivery';

            return view('voucher_view.delivery_option.company_delivery_modal', compact('items', 'jrnl', 'type', 'pge_title', 'invoice_remarks', 'invoice_date', 'invoice_nbr'));

        } else if ($request->type == 'courier_service') {
            $items = DB::table('financials_courier_service')
                ->leftJoin('financials_city as courier_city', 'courier_city.city_id', 'financials_courier_service.cs_courier_id')
                ->leftJoin('financials_city as booking_city', 'booking_city.city_id', 'financials_courier_service.cs_booking_city')
                ->leftJoin('financials_city as destination_city', 'destination_city.city_id', 'financials_courier_service.cs_destination_city')
                ->where('cs_delivery_option_id', $request->id)
                ->select('financials_courier_service.*', 'courier_city.city_name','destination_city.city_name as destination_name','booking_city.city_name as booking_name')
                ->get();

//            $items = CompanyDelivery::where('cd_delivery_option_id', $id)->get();

//            $nbrOfWrds = $this->myCnvrtNbr($jrnl->jv_total_dr);
            $invoice_nbr = $jrnl->do_id;
            $invoice_date = $jrnl->do_created_datetime;
            $invoice_remarks = $jrnl->do_remarks;
            $type = 'grid';
            $pge_title = 'Courier Service';

            return view('voucher_view.delivery_option.courier_service_modal', compact('items', 'jrnl', 'type', 'pge_title', 'invoice_remarks', 'invoice_date', 'invoice_nbr'));

        } else if ($request->type == 'third_party') {

            $items = ThirdParty::where('tp_delivery_option_id', $id)->get();
//            $nbrOfWrds = $this->myCnvrtNbr($jrnl->jv_total_dr);
            $invoice_nbr = $jrnl->do_id;
            $invoice_date = $jrnl->do_created_datetime;
            $invoice_remarks = $jrnl->do_remarks;
            $type = 'grid';
            $pge_title = 'Third Party';

            return view('voucher_view.delivery_option.third_party_modal', compact('items', 'jrnl', 'type', 'pge_title', 'invoice_remarks', 'invoice_date', 'invoice_nbr'));
        }

    }
//
//    //////////////////////////// Items View Detail PDF SH Courier ////////////////////////////////////
//
    public function delivery_option_view_details_pdf_SH(Request $request, $id)
    {

        $jrnl = DeliveryOption::where('do_id', $id)->first();

        if ($request->type == 'self_collection') {
            $items = SelfCollection::where('sc_delivery_option_id', $id)->get();
//        $nbrOfWrds = $this->myCnvrtNbr($jrnl->jv_total_dr);
            $invoice_nbr = $jrnl->do_id;
            $invoice_date = $jrnl->do_created_datetime;
            $invoice_remarks = $jrnl->do_remarks;
            $type = 'pdf';
            $pge_title = 'Self Collection';

            $footer = view('voucher_view._partials.pdf_footer')->render();
            $header = view('voucher_view._partials.pdf_header', compact('pge_title', 'type', 'invoice_remarks', 'invoice_date', 'invoice_nbr'))->render();
            $options = [
                'footer-html' => $footer,
                'header-html' => $header,
                'margin-top' => 30,
            ];

            $pdf = PDF::loadView('voucher_view.delivery_option.self_collection_list_modal', compact('items', 'jrnl', 'type'));
            $pdf->setOptions($options);
        } else if ($request->type == 'company_delivery') {
            $items = DB::table('financials_company_delivery')
                ->leftJoin('financials_users', 'financials_users.user_id', 'financials_company_delivery.cd_employee_id')
                ->where('cd_delivery_option_id', $request->id)
                ->select('financials_company_delivery.*', 'financials_users.user_name')
                ->get();
//        $nbrOfWrds = $this->myCnvrtNbr($jrnl->jv_total_dr);
            $invoice_nbr = $jrnl->do_id;
            $invoice_date = $jrnl->do_created_datetime;
            $invoice_remarks = $jrnl->do_remarks;
            $type = 'pdf';
            $pge_title = 'Company Delivery';

            $footer = view('voucher_view._partials.pdf_footer')->render();
            $header = view('voucher_view._partials.pdf_header', compact('pge_title', 'type', 'invoice_remarks', 'invoice_date', 'invoice_nbr'))->render();
            $options = [
                'footer-html' => $footer,
                'header-html' => $header,
                'margin-top' => 30,
            ];

            $pdf = PDF::loadView('voucher_view.delivery_option.company_delivery_list_modal', compact('items', 'jrnl', 'type'));
            $pdf->setOptions($options);
        } else if ($request->type == 'courier_service') {
            $items = DB::table('financials_courier_service')
                ->leftJoin('financials_city as courier_city', 'courier_city.city_id', 'financials_courier_service.cs_courier_id')
                ->leftJoin('financials_city as booking_city', 'booking_city.city_id', 'financials_courier_service.cs_booking_city')
                ->leftJoin('financials_city as destination_city', 'destination_city.city_id', 'financials_courier_service.cs_destination_city')
                ->where('cs_delivery_option_id', $request->id)
                ->select('financials_courier_service.*', 'courier_city.city_name','destination_city.city_name','booking_city.city_name')
                ->get();

//        $nbrOfWrds = $this->myCnvrtNbr($jrnl->jv_total_dr);
            $invoice_nbr = $jrnl->do_id;
            $invoice_date = $jrnl->do_created_datetime;
            $invoice_remarks = $jrnl->do_remarks;
            $type = 'pdf';
            $pge_title = 'Courier Service';

            $footer = view('voucher_view._partials.pdf_footer')->render();
            $header = view('voucher_view._partials.pdf_header', compact('pge_title', 'type', 'invoice_remarks', 'invoice_date', 'invoice_nbr'))->render();
            $options = [
                'footer-html' => $footer,
                'header-html' => $header,
                'margin-top' => 30,
            ];

            $pdf = PDF::loadView('voucher_view.delivery_option.courier_service_list_modal', compact('items', 'jrnl', 'type'));
            $pdf->setOptions($options);
        } else if ($request->type == 'third_party') {

            $items = ThirdParty::where('tp_delivery_option_id', $id)->get();
//        $nbrOfWrds = $this->myCnvrtNbr($jrnl->jv_total_dr);
            $invoice_nbr = $jrnl->do_id;
            $invoice_date = $jrnl->do_created_datetime;
            $invoice_remarks = $jrnl->do_remarks;
            $type = 'pdf';
            $pge_title = 'Third party';

            $footer = view('voucher_view._partials.pdf_footer')->render();
            $header = view('voucher_view._partials.pdf_header', compact('pge_title', 'type', 'invoice_remarks', 'invoice_date', 'invoice_nbr'))->render();
            $options = [
                'footer-html' => $footer,
                'header-html' => $header,
                'margin-top' => 30,
            ];

            $pdf = PDF::loadView('voucher_view.delivery_option.third_party_list_modal', compact('items', 'jrnl', 'type'));
            $pdf->setOptions($options);
        }
//
//        $footer = view('voucher_view._partials.pdf_footer')->render();
//        $header = view('voucher_view._partials.pdf_header', compact('pge_title', 'type', 'invoice_remarks', 'invoice_date', 'invoice_nbr'))->render();
//        $options = [
//            'footer-html' => $footer,
//            'header-html' => $header,
//            'margin-top' => 30,
//        ];
//
//        $pdf = PDF::loadView('voucher_view.delivery_option.self_collection_list_modal', compact('items', 'jrnl', 'type'));
//        $pdf->setOptions($options);


        return $pdf->stream('Delivery-option-Detail.pdf');
    }


}
