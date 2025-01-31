<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Wizard\WizardController;
use App\Models\ProductModel;
use App\Models\ProductPackagesItemsModel;
use App\Models\ProductPackagesModel;
use App\Models\SystemConfigModel;
use Auth;
use PDF;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductPackagesController extends Controller
{


    public function product_packages()
    {
        $products = $this->get_all_products();

        $pro_code = '';
        $pro_name = '';
        foreach ($products as $product) {
            $pro_title = $this->RemoveSpecialChar($product->pro_title);

            $pro_code .= "<option value='$product->pro_p_code' data-sale_price='$product->pro_sale_price' data-parent='$product->pro_p_code' data-tax='$product->pro_tax' data-retailer='$product->pro_retailer_discount' data-wholesaler='$product->pro_whole_seller_discount' data-loyalty='$product->pro_loyalty_card_discount' data-scale_size='$product->unit_scale_size' data-unit='$product->unit_title' data-main_unit='$product->mu_title'> $product->pro_p_code</option>";
            $pro_name .= "<option value='$product->pro_p_code' data-sale_price='$product->pro_sale_price' data-parent='$product->pro_p_code' data-tax='$product->pro_tax' data-retailer='$product->pro_retailer_discount' data-wholesaler='$product->pro_whole_seller_discount' data-loyalty='$product->pro_loyalty_card_discount' data-scale_size='$product->unit_scale_size' data-unit='$product->unit_title' data-main_unit='$product->mu_title'>$pro_title</option>";
        }

        return view('product_packages', compact('pro_code', 'pro_name'));
    }

    public function submit_product_packages(Request $request)
    {
        $this->validation($request);

        $rollBack = false;
        DB::beginTransaction();

        $product_packages = new ProductPackagesModel();

        $user_id = Auth::user()->user_id;
        $browser = $this->getBrwsrInfo();
        $ip = $this->getIp();
        $current_date_time = Carbon::now()->toDateTimeString();

        $product_packages = $this->AssignValues($request, $product_packages, $user_id, $ip, $browser, $current_date_time);

        if ($product_packages->save()) {
            $product_packages_id = $product_packages->pp_id;

            $items = [];

            $item = $this->AssignItemsValues($request, $items, $product_packages_id, $ip, $browser, $current_date_time);

            if (!DB::table('financials_product_packages_items')->insert($item)) {

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

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Package With Id: ' . $product_packages->pp_id . ' And Name: ' . $product_packages->pp_name);

            DB::commit();

            // WizardController::updateWizardInfo(['product_packages'], []);

            return redirect()->back()->with('success', 'Successfully Saved');
        }
    }

    public function validation($request)
    {
        return $this->validate($request, [
            'package_name' => ['required', 'string'],
            'remarks' => ['nullable', 'string'],
            'total_items' => ['required', 'numeric', 'min:1'],
            'total_price' => ['required', 'numeric'],
            'salesval' => ['required', 'string'],
        ]);
    }

    public function AssignValues($request, $product_packages, $user_id, $ip, $browser)
    {
        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $product_packages->pp_name = ucwords($request->package_name);
        $product_packages->pp_remarks = ucfirst($request->remarks);
        $product_packages->pp_total_items = $request->total_items;
        $product_packages->pp_total_price = $request->total_price;
        $product_packages->pp_datetime = Carbon::now()->toDateTimeString();
        $product_packages->pp_day_end_id = $day_end->de_id;
        $product_packages->pp_day_end_date = $day_end->de_datetime;
        $product_packages->pp_createdby = $user_id;

        $product_packages->pp_brwsr_info = $browser;
        $product_packages->pp_ip_adrs = $ip;
        $product_packages->pp_update_datetime = Carbon::now()->toDateTimeString();

        return $product_packages;
    }

    public function AssignItemsValues($request, $data, $product_packages_id, $ip, $browser, $current_date_time)
    {
        $salesval = json_decode($request->salesval, true);

        foreach ($salesval as $key) {

            $data[] = ['ppi_pro_pack_id' => $product_packages_id, 'ppi_product_code' => $key[0], 'ppi_product_name' => ucwords($key[1]), 'ppi_remarks' => ucfirst($key[2]), 'ppi_qty' => $key[3], 'ppi_scale_size' => $key[4], 'ppi_uom' => $key[5], 'ppi_rate' => $key[6], 'ppi_amount' => $key[7], 'ppi_ip_adrs' => $ip, 'ppi_brwsr_info' => $browser, 'ppi_update_datetime' => $current_date_time];
        }

        return $data;
    }


    // update code by shahzaib start
    public function product_packages_list(Request $request, $array = null, $str = null)
    {

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_product = (!isset($request->product_code) && empty($request->product_code)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->product_code;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.product_packages_list.product_packages_list';
        $pge_title = 'Product Package List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from, $search_product);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_from));
        $end = date('Y-m-d', strtotime($search_to));


        $query = DB::table('financials_product_packages')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_product_packages.pp_createdby');

        if (!empty($search)) {
            $query->where('pp_id', 'like', '%' . $search . '%')
                ->orWhere('pp_name', 'like', '%' . $search . '%')
                ->orWhere('pp_total_items', 'like', '%' . $search . '%')
                ->orWhere('pp_total_price', 'like', '%' . $search . '%')
                ->orWhere('pp_remarks', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_product)) {
            $query->where('pp_name', $search_product);
        }

        if ((!empty($search_to)) && (!empty($search_from)) ) {
            $query->whereBetween('pp_datetime', [$start, $end]);
        }

        elseif (!empty($search_to) && empty($search_from) ) {
            $query->where('pp_datetime', $start);
        }

        elseif (!empty($search_from) && empty($search_to) ) {
            $query->where('pp_datetime', $end);
        }

        if (!empty($search_by_user)) {
            $query->where('pp_createdby', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1)
        {
            $query->where('pp_delete_status', '=', 1);
        } else {
            $query->where('pp_delete_status', '!=', 1);
        }


        $datas = $query
//            ->where('pp_delete_status', '!=', 1)
            ->orderBy('pp_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

        $packages_name = ProductPackagesModel::
        where('pp_delete_status', '!=', 1)->
        orderBy('pp_name', 'ASC')->pluck('pp_name')->all();



        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title','srch_fltr'))->render();
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
            $pdf->loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if( $type === 'pdf') {
                return $pdf->stream($pge_title.'_x.pdf');
            }
            else if( $type === 'download_pdf') {
                return $pdf->download($pge_title.'_x.pdf');
            }
            else if( $type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title.'_x.xlsx');
            }

        }
        else {
            return view('product_packages_list', compact('datas', 'search', 'packages_name', 'search_by_user', 'search_to', 'search_from', 'search_product','restore_list'));
        }

    }
    // update code by shahzaib end


    public function edit_product_packages(Request $request)
    {
        $products = $this->get_all_products();

        $pro_code = '';
        $pro_name = '';
        foreach ($products as $product) {
            $pro_code .= "<option value='$product->pro_p_code' data-sale_price='$product->pro_sale_price' data-parent='$product->pro_p_code' data-tax='$product->pro_tax' data-retailer='$product->pro_retailer_discount' data-wholesaler='$product->pro_whole_seller_discount' data-loyalty='$product->pro_loyalty_card_discount' data-scale_size='$product->unit_scale_size' data-unit='$product->unit_title' data-main_unit='$product->mu_title'> $product->pro_p_code</option>";
            $pro_name .= "<option value='$product->pro_p_code' data-sale_price='$product->pro_sale_price' data-parent='$product->pro_p_code' data-tax='$product->pro_tax' data-retailer='$product->pro_retailer_discount' data-wholesaler='$product->pro_whole_seller_discount' data-loyalty='$product->pro_loyalty_card_discount' data-scale_size='$product->unit_scale_size' data-unit='$product->unit_title' data-main_unit='$product->mu_title'>$product->pro_title</option>";
        }

        $product_package = ProductPackagesModel::where('pp_id', $request->package_id)->first();

        return view('edit_product_packages', compact('product_package', 'pro_code', 'pro_name'));
    }

    public function update_product_packages(Request $request)
    {
        $this->validation($request);

        $this->validate($request, [
            'package_id' => ['required', 'numeric', 'min:1'],
        ]);

        $rollBack = false;
        DB::beginTransaction();

        $product_package = ProductPackagesModel::where('pp_id', $request->package_id)->first();

        $user_id = Auth::user()->user_id;
        $browser = $this->getBrwsrInfo();
        $ip = $this->getIp();
        $current_date_time = Carbon::now()->toDateTimeString();

        $product_package = $this->AssignValues($request, $product_package, $user_id, $ip, $browser, $current_date_time);

        if ($product_package->save()) {
            $product_packages_id = $product_package->pp_id;

            $delete = ProductPackagesItemsModel::where('ppi_pro_pack_id', $product_packages_id)->delete();

            if ($delete) {
                $items = [];
                $item = $this->AssignItemsValues($request, $items, $product_packages_id, $ip, $browser, $current_date_time);

                if (!DB::table('financials_product_packages_items')->insert($item)) {

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

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Package With Id: ' . $product_package->pp_id . ' And Name: ' . $product_package->pp_name);

            DB::commit();
            return redirect()->back()->with('success', 'Successfully Saved');
        }

    }

    public function delete_product_packages(Request $request)
    {
        $this->validate($request, [
            'del_package_id' => ['required', 'numeric', 'min:1'],
        ]);

        $user = Auth::User();

        $delete = ProductPackagesModel::where('pp_id', $request->del_package_id)->first();

//        $delete->pp_delete_status = 1;

        if ($delete->pp_delete_status == 1) {
            $delete->pp_delete_status = 0;
        } else {
            $delete->pp_delete_status = 1;
        }

        $delete->pp_deleted_by = $user->user_id;

        if ($delete->save()) {

            if ($delete->pp_delete_status == 0) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Package With Id: ' . $delete->pp_id . ' And Name: ' . $delete->pp_name);

                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Package With Id: ' . $delete->pp_id . ' And Name: ' . $delete->pp_name);

                return redirect()->back()->with('success', 'Successfully Deleted');
            }


        }else {
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }

    }

    public function get_product_packages_details(Request $request)
    {
        $items=DB::table('financials_product_packages_items')
            ->leftjoin('financials_products','financials_product_packages_items.ppi_product_code','=','financials_products.pro_p_code')
            ->leftjoin('financials_main_units','financials_products.pro_main_unit_id','=','financials_main_units.mu_id')->where('ppi_pro_pack_id', $request->id)->get();

//        $items = ProductPackagesItemsModel::where('ppi_pro_pack_id', $request->id)->get();


        return response()->json($items);
    }


}
