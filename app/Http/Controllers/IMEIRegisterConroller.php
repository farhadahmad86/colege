<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Carbon\Carbon;
use App\Models\IMEIModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use function JmesPath\search;


use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Controller;
use App\Models\ProductPackagesModel;

use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\DayEndController;
use Illuminate\Support\Facades\DB as FacadesDB;
use Barryvdh\DomPDF\PDF;

class IMEIRegisterConroller extends Controller
{
    public function create_imei()
    {
        $accounts = $this->get_account_query('sale')[0];

        $products = $this->get_all_products();
        $pro_code = '';
        $pro_name = '';
        foreach ($products as $product) {
            $pro_title = $this->RemoveSpecialChar($product->pro_title);

            $pro_code .= "<option value='$product->pro_p_code' data-parent='$product->pro_p_code' data-sale_price='$product->pro_sale_price' data-tax='$product->pro_tax' data-retailer_dis='$product->pro_retailer_discount' data-whole_saler_dis='$product->pro_whole_seller_discount' data-loyalty_dis='$product->pro_loyalty_card_discount' data-unit='$product->unit_title' data-unit_scale_size='$product->unit_scale_size'>$product->pro_p_code</option>";
            $pro_name .= "<option value='$product->pro_p_code' data-parent='$product->pro_p_code' data-sale_price='$product->pro_sale_price' data-tax='$product->pro_tax' data-retailer_dis='$product->pro_retailer_discount' data-whole_saler_dis='$product->pro_whole_seller_discount' data-loyalty_dis='$product->pro_loyalty_card_discount' data-unit='$product->unit_title' data-unit_scale_size='$product->unit_scale_size'>$pro_title</option>";
        }

        $packages = ProductPackagesModel::where('pp_delete_status', '!=', 1)->where('pp_disabled', '!=', 1)->orderBy('pp_name', 'ASC')->get();
        return view('imei_regisration', compact('pro_code', 'pro_name', 'accounts', 'products', 'packages', 'products'));
    }


    public function store_imei(Request $request)
    {

        $this->imei_validation($request);
        $product = $request->product;
        $mb_imei = new IMEIModel();

        $mb_imei = $this->AssignIMEIValues($request, $mb_imei);

        $mb_imei->save();


        foreach ($request->product_remarks as $index => $requested_array) {
            IMEIModel::where('mi_id', $mb_imei->mi_id)->update([
                'mi_imei_' . $index + 1 =>  $request->product_remarks[$index],
            ]);
            // $item_code = $request->product_remarks[$index];
        }

        // $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create mi With Id: ' . $mb_imei_no->mi_id . ' And Name: ' . $mb_imei_no->mi_title);



        return redirect()->back()->with('success', 'Successfully Saved');
    }
    public function imei_validation($request)
    {
        return $this->validate($request, [
            'product' => ['required', 'numeric'],

        ]);
    }
    protected function AssignIMEIValues($request, $mb_imei)
    {
        $user = Auth::User();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $mb_imei->mi_pro_code = $request->product;

        $mb_imei->mi_createdby = $user->user_id;
        $mb_imei->mi_day_end_id = $day_end->de_id;
        $mb_imei->mi_day_end_date = $day_end->de_datetime;
        $mb_imei->mi_purchase_id = 1;


        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $mb_imei->mi_brwsr_info = $brwsr_rslt;
        $mb_imei->mi_ip_adrs = $ip_rslt;
        $mb_imei->mi_update_datetime = Carbon::now()->toDateTimeString();



        return $mb_imei;
        // $mb_imei = DB::table('mobile_imei')->leftJoin('financials_products', 'financials_products.pro_p_code', 'mobile_imei.mi_pro_code')
        //     ->select('financials_products.pro_title', 'mobile_imei.*')->get();
    }
    public function imei_list(Request $request, $array = null, $str = null)
    {
        $regions = ProductModel::orderby('pro_title', 'ASC')->get();

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_region = (!isset($request->region) && empty($request->region)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->region;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';

        $prnt_page_dir = 'print.mi_list.area_list';
        $pge_title = 'Area List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_region, $search_by_user);


        $pagination_number = (empty($ar) || !empty($ar)) ? 30 : 100000000;

        $query = DB::table('mobile_imei')
            ->join('financials_products', 'financials_products.pro_p_code', '=', 'mobile_imei.mi_pro_code')
            ->leftJoin('financials_users', 'financials_users.user_id', '=', 'mobile_imei.mi_createdby');


        if (!empty($search)) {

            $pagination_number = 1000000;
            $query->orWhere('mi_id', 'like', '%' . $search . '%')
                ->orWhere('mi_pro_code', 'like', '%' . $search . '%')
                ->orWhere('mi_imei_1', 'like', '%' . $search . '%')
                ->orWhere('mi_imei_2', 'like', '%' . $search . '%')
                ->orWhere('mi_imei_3', 'like', '%' . $search . '%')
                ->orWhere('mi_imei_4', 'like', '%' . $search . '%')
                ->orWhere('mi_imei_5', 'like', '%' . $search . '%')
                ->orWhere('pro_title', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%');
        }

        if (!empty($search_region)) {
            $pagination_number = 1000000;
            $query->where('mi_pro_code', '=', $search_region);
        }

        if (!empty($search_by_user)) {
            $pagination_number = 1000000;
            $query->where('mi_createdby', '=', $search_by_user);
        }

        $datas = $query
            ->orderBy('mi_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);



        $mi_title = IMEIModel::where('mi_delete_status', '!=', 1)->orderBy('mi_id', 'ASC')->pluck('mi_imei_1')->all();


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

            return view('imei_list', compact('datas', 'search', 'mi_title', 'regions', 'search_region'));
        }
    }
    public function delete_imei(Request $request)
    {
        $user = Auth::User();
        $delete = IMEIModel::where('mi_id', $request->area_id)->first();


        if ($delete->mi_delete_status == 1) {
            $delete->mi_delete_status = 0;
        } else {
            $delete->mi_delete_status = 1;
        }

        $delete->mi_deleted_by = $user->user_id;

        if ($delete->save()) {

            if ($delete->mi_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Area With Id: ' . $delete->mi_id . ' And Name: ' . $delete->pro_title);

//                return redirect('area_list')->with('success', 'Successfully Restored');
                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Area With Id: ' . $delete->mi_id . ' And Name: ' . $delete->pro_title);

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
