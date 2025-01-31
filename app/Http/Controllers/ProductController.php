<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\Utility;
use App\Models\BrandModel;
use App\Models\DayEndModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use App\Models\MainUnitModel;
use App\Models\UnitInfoModel;
use App\Models\GroupInfoModel;
use App\Models\InventoryModel;
use App\Models\WarehouseModel;
use App\Imports\ExcelDataImport;
use App\Models\ProductTypeModel;
use App\Models\CategoryInfoModel;
use App\Models\ProductGroupModel;
use App\Models\SystemConfigModel;
use Illuminate\Support\Facades\DB;
use App\Exports\ExcelFileCusExport;
use App\Models\StockMovementModels;
use App\Models\ProductBalancesModel;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\SaleInvoiceItemsModel;
use PDF;
use App\Models\PurchaseInvoiceItemsModel;
use App\Http\Controllers\Wizard\WizardController;

class ProductController extends ExcelForm\ProductForm\ProductController
{
    public function add_product()
    {
        $user = Auth::User();
        $last_product = ProductModel::where('pro_clg_id', $user->user_clg_id)->orderBy('pro_id', 'DESC')->first();


        $groups = GroupInfoModel::where('grp_clg_id', $user->user_clg_id)->where('grp_delete_status', '!=', 1)->where('grp_disabled', '!=', 1)->orderBy('grp_title', 'ASC')->get();
        $main_units = MainUnitModel::where('mu_clg_id', $user->user_clg_id)->where('mu_delete_status', '!=', 1)->where('mu_disabled', '!=', 1)->orderBy('mu_title', 'ASC')->get();
        $brands = BrandModel::where('br_clg_id', $user->user_clg_id)->where('br_delete_status', '!=', 1)->where('br_disabled', '!=', 1)->orderBy('br_title', 'ASC')->get();
        $product_groups = ProductGroupModel::where('pg_clg_id', $user->user_clg_id)->where('pg_delete_status', '!=', 1)->where('pg_disabled', '!=', 1)->orderBy('pg_title', 'ASC')->get();

        $products = ProductModel::where('pro_clg_id', $user->user_clg_id)->where('pro_delete_status', '!=', 1)->where('pro_disabled', '!=', 1)->orderBy('pro_title', 'ASC')->get();
        $pro_code = ProductModel::where('pro_clg_id', $user->user_clg_id)->orderBy('pro_id', 'DESC')->pluck('pro_id')->first();
        $product_types = ProductTypeModel::orderBy('pt_id', 'ASC')->get();
        $pro_code = $pro_code + 1;
        return view('add_product', compact('groups', 'main_units', 'products', 'product_groups', 'brands', 'product_types', 'pro_code', 'last_product'));
    }

    public function submit_product_excel(Request $request)
    {

        $rules = [
            'add_create_product_excel' => 'required|mimes:xlsx,xls,csv|max:5000',
        ];

        $messages = [
            'add_create_product_excel.max' => "Your File size too long.",
            'add_create_product_excel.required' => "Please select your Product Excel Sheet.",
        ];

        $validator = $this->validate($request, $rules, $messages);

        if ($request->hasFile('add_create_product_excel')) {

            $path = $request->file('add_create_product_excel');
            $data = Excel::toArray(new ExcelDataImport, $path);

            $excelData = json_decode(json_encode($data), FALSE);

            foreach ($excelData as $rows) {
                foreach ($rows as $row) {
                    $rowData = (array)$row;
                    $request->merge($rowData);
                    $this->excel_product_validation($request);

                    $rollBack = self::excel_form_product($row);

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

    public function submit_product(Request $request)
    {
        return self::simple_form_product($request);

    }

    // update code by shahzaib start
    public function product_list(Request $request, $type = 1, $array = null, $str = null)
    {
        $user = Auth::user();
        $main_units = MainUnitModel::where('mu_clg_id', $user->user_clg_id)->where('mu_delete_status', '!=', 1)->where('mu_disabled', '!=', 1)->orderby('mu_title', 'ASC')->get();
        $units = UnitInfoModel::where('unit_clg_id', $user->user_clg_id)->where('unit_delete_status', '!=', 1)->where('unit_disabled', '!=', 1)->orderBy('unit_title', 'ASC')->get();
        $groups = GroupInfoModel::where('grp_clg_id', $user->user_clg_id)->where('grp_delete_status', '!=', 1)->where('grp_disabled', '!=', 1)->orderBy('grp_title', 'ASC')->get();
        $categories = CategoryInfoModel::where('cat_clg_id', $user->user_clg_id)->where('cat_delete_status', '!=', 1)->where('cat_disabled', '!=', 1)->orderBy('cat_title', 'ASC')->get();
        $product_groups = ProductGroupModel::where('pg_clg_id', $user->user_clg_id)->where('pg_delete_status', '!=', 1)->where('pg_disabled', '!=', 1)->orderBy('pg_title', 'ASC')->get();
        $route = "";

        if ($type == config('global_variables.parent_product_type')) {
            $route = 'product_list';
        } else if ($type == config('global_variables.child_product_type')) {
            $route = 'product_clubbing_list';
        }


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_main_unit = (!isset($request->main_unit) && empty($request->main_unit)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->main_unit;
        $search_unit = (!isset($request->unit) && empty($request->unit)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->unit;
        $search_group = (!isset($request->group) && empty($request->group)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->group;
        $search_category = (!isset($request->category) && empty($request->category)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->category;
        $search_product_group = (!isset($request->product_group) && empty($request->product_group)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->product_group;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.' . $route . '.' . $route;
        $pge_title = ucwords(str_replace('_', ' ', $route));
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_main_unit, $search_unit, $search_group, $search_category);

//        $pagination_number = (empty($ar)) ? 30 : 100000000;

        if (!empty($request['page'])) {
            $pagination_number = (empty($ar)) ? 30 : 100000000;
        } else {
            $pagination_number = (empty($ar)) ? 9999999999990 : 100000000;
        }

        $has_pages = $request['page'] > 0 ? '1' : '0';

        $query = DB::table('financials_products')
//            ->leftJoin('financials_inventory', 'financials_products.pro_code', '=', 'financials_inventory.invt_product_id')
            ->leftJoin('financials_groups', 'financials_groups.grp_id', 'financials_products.pro_group_id')
            ->leftJoin('financials_categories', 'financials_categories.cat_id', 'financials_products.pro_category_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_products.pro_createdby')
            ->leftJoin('financials_units', 'financials_units.unit_id', 'financials_products.pro_unit_id')
            ->where('pro_clg_id', $user->user_clg_id);

        if (!empty($search)) {
            $query->where('pro_code', 'like', '%' . $search . '%')
                ->orWhere('pro_title', 'like', '%' . $search . '%')
                ->orWhere('pro_purchase_price', 'like', '%' . $search . '%')
                ->orWhere('pro_sale_price', 'like', '%' . $search . '%')
                ->orWhere('pro_remarks', 'like', '%' . $search . '%')
//                ->orWhere('invt_available_stock', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_main_unit)) {
            $query->where('pro_main_unit_id', $search_main_unit);
        }

        if (!empty($search_unit)) {
            $query->where('pro_unit_id', $search_unit);
        }

        if (!empty($search_group)) {
            $query->where('pro_group_id', $search_group);
        }

        if (!empty($search_category)) {
            $query->where('pro_category_id', $search_category);
        }

        if (!empty($search_product_group)) {
            $query->where('pro_reporting_group_id', $search_product_group);
        }

        if (!empty($search_by_user)) {
            $query->where('pro_createdby', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1) {
            $query->where('pro_delete_status', '=', 1);
        } else {
            $query->where('pro_delete_status', '!=', 1);
        }

        if ($type == config('global_variables.child_product_type')) {
            $query->where('pro_clubbing_codes', '!=', '');
        }

        $option = $request->options;
        if ($option == "ASC") {
            $datas = $query->where('pro_type', 1)
//            ->where('pro_delete_status', '!=', 1)
                ->orderBy('pro_id', config('global_variables.drop_sorting'))
                ->paginate($pagination_number);
        } else {

            $datas = $query->where('pro_type', 1)
//            ->where('pro_delete_status', '!=', 1)
                ->orderBy('pro_id', config('global_variables.query_sorting'))
                ->paginate($pagination_number);
        }


        $product = ProductModel::
        where('pro_clg_id', $user->user_clg_id)->
        where('pro_delete_status', '!=', 1)->
        orderBy('pro_title', 'ASC')->pluck('pro_title')->all();


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
            return view($route, compact('option', 'datas', 'search', 'product', 'main_units', 'units', 'groups', 'categories', 'product_groups', 'search_main_unit', 'search_unit', 'search_group', 'search_category', 'search_by_user', 'search_product_group', 'restore_list', 'has_pages'));
        }


    }

    // update code by shahzaib end

    public function edit_product(Request $request)
    {
        $user = Auth::user();
        $groups = GroupInfoModel::where('grp_clg_id', $user->user_clg_id)->where('grp_delete_status', '!=', 1)->where('grp_disabled', '!=', 1)->orderBy('grp_title', 'ASC')->get();
        $main_units = MainUnitModel::where('mu_clg_id', $user->user_clg_id)->where('mu_delete_status', '!=', 1)->where('mu_disabled', '!=', 1)->orderBy('mu_title', 'ASC')->get();
        $product_groups = ProductGroupModel::where('pg_clg_id', $user->user_clg_id)->where('pg_delete_status', '!=', 1)->where('pg_disabled', '!=', 1)->orderBy('pg_title', 'ASC')->get();
        $brands = BrandModel::where('br_clg_id', $user->user_clg_id)->where('br_delete_status', '!=', 1)->where('br_disabled', '!=', 1)->orderBy('br_title', 'ASC')->get();
        $product_types = ProductTypeModel::orderBy('pt_id', 'ASC')->get();

        $product = ProductModel::where('pro_clg_id', $user->user_clg_id)->where('pro_id', $request->product_id)->first();

        return view('edit_product', compact('request', 'groups', 'main_units', 'product', 'product_groups', 'brands', 'product_types'));
    }

    public function update_product(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'product_type' => ['required', 'numeric'],
            'group_name' => ['required', 'numeric'],
            'category_name' => ['required', 'numeric'],
            'product_group' => ['required', 'numeric'],
            'main_unit' => ['nullable', 'numeric'],
            'unit_name' => ['nullable', 'numeric'],
            'unit_allow_decimal' => ['nullable', 'numeric'],
            'product_id' => ['required', 'numeric'],
//            'product_name' => ['required', 'string', 'unique:financials_products,pro_title,' . $request->product_id . ',pro_id,pro_unit_id,' . $request->unit_name],
            'product_name' => ['required', 'string'],
//            'product_barcode' => ['required', 'string', 'unique:financials_products,pro_code,' . $request->product_id . ',pro_id'],
            'product_code' => ['nullable', 'string'],
            'alternative_code' => ['nullable', 'string'],
            'isbn_number' => ['nullable', 'string'],
            'purchase_price' => ['nullable', 'numeric'],
            'bottom_price' => ['nullable', 'numeric'],
            'sale_price' => ['nullable', 'numeric'],
            'remarks' => ['nullable', 'string'],
            'expiry' => ['nullable', 'date'],
            'min_qty' => ['nullable', 'numeric'],
            'alert' => ['nullable', 'numeric'],
            'tax' => ['nullable', 'regex:/^\d*\.?\d*$/'],
            'retailer' => ['nullable', 'regex:/^\d*\.?\d*$/'],
            'wholesaler' => ['nullable', 'regex:/^\d*\.?\d*$/'],
            'loyalty_card' => ['nullable', 'regex:/^\d*\.?\d*$/'],
            'check_group' => ['nullable', 'numeric'],
        ]);
        $rand_number = Utility::uniqidReal();
        $product = ProductModel::where('pro_clg_id', $user->user_clg_id)->where('pro_id', $request->product_id)->first();

        $product->pro_product_type_id = $request->product_type;
        $product->pro_group_id = $request->group_name;
        $product->pro_category_id = $request->category_name;
        $product->pro_reporting_group_id = $request->product_group;
        $product->pro_main_unit_id = $request->main_unit;
        $product->pro_unit_id = $request->unit_name;
        $product->pro_allow_decimal = $request->unit_allow_decimal;
        $product->pro_brand_id = $request->brand;
        $product->pro_title = ucwords($request->product_name);
        $product->pro_urdu_title = ucwords($request->urdu_product_name);
        $pro_purchase_price = isset($request->purchase_price) ? $request->purchase_price : 0;
        $product->pro_purchase_price = $pro_purchase_price;
        $product->pro_sale_price = isset($request->sale_price) ? $request->sale_price : 0;
        $product->pro_remarks = ucfirst($request->remarks);
        $product->pro_code = $request->product_code;
        $product->pro_alternative_code = $request->alternative_code;
        $product->pro_ISBN = $request->isbn_number;

        $product->pro_tax = (isset($request->tax) || !empty($request->tax)) ? $request->tax : 0;
        $product->pro_retailer_discount = (isset($request->retailer) || !empty($request->retailer)) ? $request->retailer : 0;
        $product->pro_whole_seller_discount = (isset($request->wholesaler) || !empty($request->wholesaler)) ? $request->wholesaler : 0;
        $product->pro_loyalty_card_discount = (isset($request->loyalty_card) || !empty($request->loyalty_card)) ? $request->loyalty_card : 0;
        $product->pro_use_cat_fields = (isset($request->check_group) || !empty($request->check_group)) ? $request->check_group : 0;


        $product->pro_hold_qty_per = (isset($request->hold_per_online) || !empty($request->hold_per_online)) ? $request->hold_per_online : 0;

        $product->pro_brwsr_info = $this->getBrwsrInfo();
        $product->pro_ip_adrs = $this->getIp();


        $pro_bottom_price = $request->bottom_price;
        if (empty($request->bottom_price)) {
            $pro_bottom_price = 0;
        }
        $product->pro_bottom_price = $pro_bottom_price;

        if ($product->pro_quantity <= 0) {
            $pro_average_price = $product->pro_average_rate;

        } else {
            $total_quantity_rate = $product->pro_quantity * $pro_purchase_price;
            $pro_average_price = $total_quantity_rate / $product->pro_quantity;
        }
        $product->pro_average_rate = $pro_average_price;

        if (!empty($request->pimage)) {
            $save_image = new SaveImageController();

            $common_path = config('global_variables.common_path');
            $product_path = config('global_variables.product_path');

            // Handle Image
            $fileNameToStore = $save_image->SaveImage($request, 'pimage', $request->folder, $product_path, $rand_number . 'Product_Image');

            $product->pro_image = $common_path . $fileNameToStore;
        }

        $pro_min_quantity = $request->min_qty;
        if (empty($request->min_qty)) {
            $pro_min_quantity = 0;
        }
        $product->pro_min_quantity = $pro_min_quantity;

        $pro_expiry_date = date('Y-m-d', strtotime($request->expiry));
        if (empty($request->expiry)) {
            $pro_expiry_date = null;
        }

        $pro_min_quantity_alert = $request->alert;
        if (empty($request->alert)) {
            $pro_min_quantity_alert = 0;
        }
        $product->pro_expiry_date = $pro_min_quantity_alert;

        $pro_online_status = $request->online_status;
        if (empty($request->online_status)) {
            $pro_online_status = 0;
        }
        $pro_stock_status = $request->stock_status;
        if (empty($request->stock_status)) {
            $pro_stock_status = 0;
        }
        $pro_edit_status = $request->edit_status;
        if (empty($request->edit_status)) {
            $pro_edit_status = 0;
        }
        $product->pro_online_status = $pro_online_status;
        $product->pro_stock_status = $pro_stock_status;
        $product->pro_edit = $pro_edit_status;

        $product->pro_net_weight = $request->net_weight;
        $product->pro_gross_weight = $request->gross_weight;
        $product->save();

//        $products = ProductModel::where('pro_p_code', $product->pro_p_code)
//            ->update([
//                'pro_product_type_id' => $pro_product_type_id,
//                'pro_group_id' => $pro_group_id,
//                'pro_category_id' => $pro_category_id,
//                'pro_reporting_group_id' => $product_group_id,
//                'pro_main_unit_id' => $pro_main_unit_id,
//                'pro_unit_id' => $pro_unit_id,
//                'pro_allow_decimal' => $pro_allow_decimal,
//                'pro_brand_id' => $pro_brand_id,
//                'pro_title' => $pro_title,
//                'pro_urdu_title' => $pro_urdu_title,
//                'pro_purchase_price' => $pro_purchase_price,
//                'pro_sale_price' => $pro_sale_price,
//                'pro_remarks' => $pro_remarks,
//                'pro_code' => $product_code,
//                'pro_alternative_code' => $alternative_code,
//                'pro_ISBN' => $isbn_number,
//                'pro_tax' => $pro_tax,
//                'pro_retailer_discount' => $pro_retailer_discount,
//                'pro_whole_seller_discount' => $pro_whole_seller_discount,
//                'pro_loyalty_card_discount' => $pro_loyalty_card_discount,
//                'pro_use_cat_fields' => $pro_use_cat_fields,
//                'pro_brwsr_info' => $brwsr_rslt,
//                'pro_ip_adrs' => $ip_rslt,
//                'pro_bottom_price' => $pro_bottom_price,
//                'pro_average_rate' => $pro_average_price,
//                'pro_min_quantity' => $pro_min_quantity,
//                'pro_min_quantity_alert' => $pro_expiry_date,
//                'pro_expiry_date' => $pro_min_quantity_alert,
//                'pro_hold_qty_per' => $pro_hold_qty_per,
//                'pro_online_status' => $pro_online_status,
//                'pro_image' => $product_image,
//            ]);

        if ($product) {
//        if ($products) {


            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Product With Code: ' . $product->pro_code . ' And Name: ' . $product->pro_title . ' And Also Their Childs');

            return redirect('product_list')->with('success', 'Successfully Saved');
        } else {
            return redirect('product_list')->with('fail', 'Failed Try Again!');
        }
    }

    public function product_wise_report()
    {
        $user = Auth::user();
        $products = ProductModel::where('pro_clg_id', $user->user_clg_id)->orderBy('pro_title', 'ASC')->get();

        return view('product_wise_report', compact('products'));
    }

    public function product_wise_purchases_sales_report(Request $request)
    {
        $user = Auth::user();
        if ($request->type == 'purchase') {

            $purchase_invoices = DB::table('financials_purchase_invoice')
                ->join('financials_purchase_invoice_items', 'financials_purchase_invoice_items.pii_purchase_invoice_id', '=', 'financials_purchase_invoice.pi_id')
                ->select('financials_purchase_invoice.*')
                ->where('pii_product_code', $request->pro_id)
                ->where('pi_clg_id', $user->user_clg_id)
                ->where('pi_status', 'PURCHASE')
                ->orderBy('pii_product_code', 'DESC')
                ->get();

            $sale_invoices = [];

            $title = 'Purchase';

        } elseif ($request->type == 'sale') {

            $purchase_invoices = [];

            $sale_invoices = DB::table('financials_sale_invoice')
                ->join('financials_sale_invoice_items', 'financials_sale_invoice_items.sii_sale_invoice_id', '=', 'financials_sale_invoice.si_id')
                ->select('financials_sale_invoice.*')
                ->where('sii_product_code', $request->pro_id)
                ->where('si_status', 'SALE')
                ->where('si_clg_id', $user->user_clg_id)
                ->orderBy('sii_product_code', 'DESC')
                ->get();

            $title = 'Sale';

        } else {

            $purchase_invoices = DB::table('financials_purchase_invoice')
                ->join('financials_purchase_invoice_items', 'financials_purchase_invoice_items.pii_purchase_invoice_id', '=', 'financials_purchase_invoice.pi_id')
                ->select('financials_purchase_invoice.*')
                ->where('pii_product_code', $request->pro_id)
                ->where('pi_status', 'PURCHASE')
                ->where('pi_clg_id', $user->user_clg_id)
                ->orderBy('pii_product_code', 'DESC')
                ->get();

            $sale_invoices = DB::table('financials_sale_invoice')
                ->join('financials_sale_invoice_items', 'financials_sale_invoice_items.sii_sale_invoice_id', '=', 'financials_sale_invoice.si_id')
                ->select('financials_sale_invoice.*')
                ->where('sii_product_code', $request->pro_id)
                ->where('si_status', 'SALE')
                ->where('si_clg_id', $user->user_clg_id)
                ->orderBy('sii_product_code', 'DESC')
                ->get();

            $title = 'Purchase Sale';
        }

        return view('product_wise_purchases_sales_report', compact('purchase_invoices', 'sale_invoices', 'title'));
    }

    public function product_wise_return_report()
    {
        $user = Auth::user();
        $products = ProductModel::where('pro_clg_id', $user->user_clg_id)->orderBy('pro_title', 'ASC')->get();

        return view('product_wise_return_report', compact('products'));
    }

    public function product_wise_purchases_sales_return_report(Request $request)
    {
        $user = Auth::user();
        if ($request->type == 'purchase') {

            $purchase_invoices = DB::table('financials_purchase_invoice')
                ->join('financials_purchase_invoice_items', 'financials_purchase_invoice_items.pii_purchase_invoice_id', '=', 'financials_purchase_invoice.pi_id')
                ->select('financials_purchase_invoice.*')
                ->where('pii_product_code', $request->pro_id)
                ->where('pi_status', 'RETURN')
                ->where('pi_clg_id', $user->user_clg_id)
                ->orderBy('pii_product_code', 'DESC')
                ->get();

            $sale_invoices = [];

            $title = 'Purchase Return';

        } elseif ($request->type == 'sale') {

            $purchase_invoices = [];

            $sale_invoices = DB::table('financials_sale_invoice')
                ->join('financials_sale_invoice_items', 'financials_sale_invoice_items.sii_sale_invoice_id', '=', 'financials_sale_invoice.si_id')
                ->select('financials_sale_invoice.*')
                ->where('sii_product_code', $request->pro_id)
                ->where('si_status', 'RETURN')
                ->where('si_clg_id', $user->user_clg_id)
                ->orderBy('sii_product_code', 'DESC')
                ->get();

            $title = 'Sale Return';

        } else {

            $purchase_invoices = DB::table('financials_purchase_invoice')
                ->join('financials_purchase_invoice_items', 'financials_purchase_invoice_items.pii_purchase_invoice_id', '=', 'financials_purchase_invoice.pi_id')
                ->select('financials_purchase_invoice.*')
                ->where('pii_product_code', $request->pro_id)
                ->where('pi_status', 'RETURN')
                ->where('pi_clg_id', $user->user_clg_id)
                ->orderBy('pii_product_code', 'DESC')
                ->get();

            $sale_invoices = DB::table('financials_sale_invoice')
                ->join('financials_sale_invoice_items', 'financials_sale_invoice_items.sii_sale_invoice_id', '=', 'financials_sale_invoice.si_id')
                ->select('financials_sale_invoice.*')
                ->where('sii_product_code', $request->pro_id)
                ->where('si_status', 'RETURN')
                ->where('si_clg_id', $user->user_clg_id)
                ->orderBy('sii_product_code', 'DESC')
                ->get();

            $title = 'Purchase Sale Return';
        }

        return view('product_wise_purchases_sales_return_report', compact('purchase_invoices', 'sale_invoices', 'title'));
    }

    public function get_product_average_rate($product_code)
    {
        $user = Auth::user();
        $average_rate = ProductModel::where('pro_code', $product_code)->where('pro_clg_id', $user->user_clg_id)->pluck('pro_average_rate')->first();
        return $average_rate;
    }

    public function delete_product(Request $request)
    {
        $user = Auth::User();

        $product = ProductModel::where('pro_clg_id', $user->user_clg_id)->where('pro_id', $request->product_id)->first();
        if ($product->pro_delete_status == 1) {
            $pro_delete_status = 0;
        } else {
            $pro_delete_status = 1;
        }

        $delete_product = ProductModel::where('pro_clg_id', $user->user_clg_id)->where('pro_p_code', $product->pro_p_code)->update(['pro_delete_status' => $pro_delete_status, 'pro_deleted_by' => $user->user_id]);


        if ($delete_product) {

            if ($product->pro_delete_status == 1) {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Restore Product With Id: ' . $product->pro_code . ' And Name: ' . $product->pro_title);

                return redirect()->back()->with('success', 'Successfully Restored');
            } else {
                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Product With Code: ' . $product->pro_code . ' And Name: ' . $product->pro_title);

                return redirect()->back()->with('success', 'Successfully Deleted');
            }


//            return redirect()->back()->with('success', 'Successfully Deleted');
        } else {
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }
    }

    public function change_status_product(Request $request)
    {
        $user = Auth::user();
        if ($request->product_status == 1) {
            $status = config('global_variables.product_discontinue_status');
        } elseif ($request->product_status == 2) {
            $status = config('global_variables.product_lock_status');
        } elseif ($request->product_status == 3) {
            $status = config('global_variables.product_active_status');
        }

        $product = ProductModel::where('pro_clg_id', $user->user_clg_id)->where('pro_code', $request->product_parent_code)->first();

        $update_product = ProductModel::where('pro_clg_id', $user->user_clg_id)->where('pro_p_code', $request->product_parent_code)
            ->update([
                'pro_status' => $status,
            ]);

        if ($update_product) {

            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Change Status Of Product With Code: ' . $product->pro_code . ' And Name: ' . $product->pro_title);

            return redirect()->back()->with('success', 'Status Successfully Changed');
        } else {
            return redirect()->back()->with('fail', 'Failed Try Again!');
        }

    }

    // update code by shahzaib start
    public function product_rate_change(Request $request, $array = null, $str = null)
    {

        $user = Auth::user();
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.product_rate_change.product_rate_change';
        $pge_title = 'Product Rate Change';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $query = DB::table('financials_products')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_products.pro_createdby')
            ->where('pro_clg_id', $user->user_clg_id);

        if (!empty($search)) {
            $query->where('pro_title', 'like', '%' . $search . '%')
                ->orWhere('pro_code', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        $datas = $query->where('pro_type', config('global_variables.parent_product_type'))
            ->orderBy('pro_title', 'ASC')
            ->paginate($pagination_number);

        $product_names = ProductModel::where('pro_clg_id', $user->user_clg_id)->where('pro_type', config('global_variables.parent_product_type'))->orderBy('pro_title', 'ASC')->pluck('pro_title')->all();


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
            return view('product_rate_change', compact('datas', 'search', 'product_names'));
        }


    }

    // update code by shahzaib end

    public function update_product_rate_change(Request $request)
    {
        $this->product_rate_change_validation($request);

        $ids = $request->id;
        $p_rate = $request->p_rate;
        $b_rate = $request->b_rate;
        $s_rate = $request->s_rate;


        // coding from shahzaib start
        $tbl_var_name = 'product';
        $prfx = 'pro';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        // coding from shahzaib end

        $user = Auth::User();
        foreach ($ids as $index => $id) {

            $product = ProductModel::where('pro_clg_id', $user->user_clg_id)->where('pro_code', $ids[$index])->first();

            ProductModel::where('pro_clg_id', $user->user_clg_id)->where('pro_p_code', $ids[$index])->update(['pro_purchase_price' => $p_rate[$index], 'pro_bottom_price' => $b_rate[$index], 'pro_sale_price' => $s_rate[$index], $brwsr_col => $brwsr_rslt, $ip_col => $ip_rslt, $updt_date_col => Carbon::now()->toDateTimeString()]);

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Product Rate of Code: ' . $product->pro_code . ' And Name: ' . $product->pro_title);
        }

        return redirect()->back()->with('success', 'Successfully Saved');
    }

    public function product_rate_change_validation($request)
    {
        return $this->validate($request, [
            'id' => ['required', 'array'],
            'id.*' => ['required', 'numeric'],
            'p_rate' => ['required', 'array'],
            'p_rate.*' => ['required', 'numeric'],
            'b_rate' => ['required', 'array'],
            'b_rate.*' => ['required', 'numeric'],
            's_rate' => ['required', 'array'],
            's_rate.*' => ['required', 'numeric'],
        ]);
    }

    public function assign_product_balances_values($request, $product_balance)
    {
        $user = Auth::user();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $product_balance->pb_p_code = $request->product_code;
        $product_balance->pb_p_name = $request->product_name;
        $product_balance->pb_acccount_uid = 0;
        $product_balance->pb_account_name = 'Opening_Balance';
        $product_balance->pb_s_inward = 0;
        $product_balance->pb_s_outward = 0;
        $product_balance->pb_s_balance = 0;
        $product_balance->pb_amount_inward = 0;
        $product_balance->pb_amount_outward = 0;
        $product_balance->pb_amount_balance = 0;
        $product_balance->pb_notes = 'Opening_Balance';
        $product_balance->pb_voucher_number = '';
        $product_balance->pb_createdby = $user->user_id;
        $product_balance->pb_datetime = Carbon::now()->toDateTimeString();
        $product_balance->pb_dayend_id = $day_end->de_id;
        $product_balance->pb_dayend_date = $day_end->de_datetime;

        // coding from shahzaib start
        $tbl_var_name = 'product_balance';
        $prfx = 'pb';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end

        return $product_balance;
    }

    public function product_clubbing(Request $request)
    {
        $user = Auth::user();
        $pro_code = $request->product_code;
        $status = 0;
        $edit_products = [];
        if (isset($pro_code) && !empty($pro_code)) {

//            $edit_products = ProductModel::where('pro_code', '!=', $pro_code)->where('pro_p_code', $pro_code)->get();
            $edit_products = ProductModel::where('pro_clg_id', $user->user_clg_id)->where('pro_type', config('global_variables.child_product_type'))->where('pro_p_code', $pro_code)->pluck('pro_code')->all();

            $status = 1;
        }


//        $products = ProductModel::where('pro_type', config('global_variables.parent_product_type'))->orderBy('pro_title', 'ASC')->get();
        $products = $this->get_products_by_type(config('global_variables.parent_product_type'));

        $product_code = '';
        $product_name = '';

        foreach ($products as $product) {


            $selected = $pro_code == $product->pro_code ? 'selected' : '';

            $product_code .= "<option value='$product->pro_code' $selected>$product->pro_code</option>";
            $product_name .= "<option value='$product->pro_code' $selected>$product->pro_title</option>";
        }

        return view('product_clubbing', compact('product_code', 'product_name', 'edit_products', 'status'));
    }

    public function submit_product_clubbing(Request $request)
    {
        $product = ProductModel::where('pro_code', $request->product_parent_code)->first();

        $child_products = $request->productsval;
        $child_products = json_decode($child_products, true);
        $delete_products = json_decode($request->delete_products, true);
        $user = Auth::User();
        if ($request->status == 1) {

            if (isset($delete_products) && !empty($delete_products)) {

                $product = ProductModel::whereIn('pro_code', $delete_products)->first();
                ProductModel::whereIn('pro_code', $delete_products)->delete();

                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Delete Child Product With Code: ' . $product->pro_code . ' And Name: ' . $product->pro_title);
            }

        } else {
            $check_pro_exist = ProductModel::whereIn('pro_code', $child_products)->exists();

            if ($check_pro_exist) {
                return redirect()->back()->with('fail', 'Barcode/s Already Exist Try Again');
            }
        }

        foreach ($child_products as $child_product) {

            $check_child = ProductModel::where('pro_code', $child_product[0])->exists();

            if (!$check_child) {

                $user = Auth::user();

                $get_day_end = new DayEndController();
                $day_end = $get_day_end->day_end();

                $brwsr_rslt = $this->getBrwsrInfo();
                $ip_rslt = $this->getIp();

                $product->pro_code = $child_product[0];
                $product->pro_type = config('global_variables.child_product_type');
                $product->pro_ip_adrs = $ip_rslt;
                $product->pro_brwsr_info = $brwsr_rslt;
                $product->pro_day_end_id = $day_end->de_id;
                $product->pro_day_end_date = $day_end->de_datetime;
                $product->pro_createdby = $user->user_id;
                $product->pro_datetime = Carbon::now()->toDateTimeString();

                $pro_array = $product->toArray();
                unset($pro_array['pro_id']);

                ProductModel::create($pro_array);

                $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Child Product With Code: ' . $product->pro_code);

            }
        }

        // WizardController::updateWizardInfo(['product_clubbing'], []);

        if ($request->status == 1) {
            return redirect('product_clubbing_list')->with('success', 'Save Successfully New Barcodes Only');
        } else {
            return redirect()->back()->with('success', 'Save Successfully New Barcodes Only');
        }

    }


    // update code by shahzaib start
    public function product_clubbing_list(Request $request, $array = null, $str = null)
    {
        return $this->product_list($request, config('global_variables.child_product_type'), $array, $str);
    }

    // update code by shahzaib end


    public function change_sale_bottom_price(Request $request)
    {
        $user = Auth::user();
        $change_price = ProductModel::where('pro_clg_id', $user->user_clg_id)->where('pro_p_code', $request->pro_code)->first();

        $change_price->pro_sale_price = $request->sale_price;
        $change_price->pro_bottom_price = $request->bottom_price;

        if ($change_price->save()) {
            return response()->json(['success', 'Successfully Saved']);
        } else {
            return response()->json(['fail', 'Try Again']);
        }

//        return response()->json(['message' => 'User status updated successfully.']);
    }

    public function online_product_list(Request $request, $array = null, $str = null)
    {
        $user = Auth::user();
        $main_units = MainUnitModel::where('mu_clg_id', $user->user_clg_id)->orderby('mu_title', 'ASC')->get();
        $units = UnitInfoModel::where('unit_clg_id', $user->user_clg_id)->orderBy('unit_title', 'ASC')->get();
        $groups = GroupInfoModel::where('grp_clg_id', $user->user_clg_id)->orderBy('grp_title', 'ASC')->get();
        $categories = CategoryInfoModel::where('cat_clg_id', $user->user_clg_id)->orderBy('cat_title', 'ASC')->get();
        $product_reporting_groups = ProductGroupModel::where('pg_clg_id', $user->user_clg_id)->orderBy('pg_title', 'ASC')->get();
        $warehouses = WarehouseModel::where('wh_clg_id', $user->user_clg_id)->orderBy('wh_id', 'ASC')->get();

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_group = (!isset($request->group) && empty($request->group)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->group;
        $search_category = (!isset($request->category) && empty($request->category)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->category;
        $search_product_reporting_group = (!isset($request->product_reporting_group) && empty($request->product_reporting_group)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->product_reporting_group;
        $search_main_unit = (!isset($request->main_unit) && empty($request->main_unit)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->main_unit;
        $search_unit = (!isset($request->unit) && empty($request->unit)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->unit;


        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.product_opening_stock.product_opening_stock';
        $pge_title = 'Product Opening Stock';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_group, $search_category, $search_product_reporting_group, $search_main_unit, $search_unit);

        $pagination_number = (empty($ar)) ? 100000000 : 100000000;

//        DB::enableQueryLog();
        $query = DB::table('financials_products')
            ->leftJoin('financials_groups', 'financials_groups.grp_id', 'financials_products.pro_group_id')
            ->leftJoin('financials_units', 'financials_units.unit_id', 'financials_products.pro_unit_id')
            ->leftJoin('financials_categories', 'financials_categories.cat_id', 'financials_products.pro_category_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_products.pro_createdby')
            ->where('pro_disabled', '!=', 1)
            ->where('pro_clg_id', $user->user_clg_id);

//        $query = DB::table('financials_products')
//            ->leftJoin('financials_groups', 'financials_groups.grp_id', 'financials_products.pro_group_id')
//            ->leftJoin('financials_categories', 'financials_categories.cat_id', 'financials_products.pro_category_id')
//            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_products.pro_createdby');

        if (!empty($search)) {
            $query->where('pro_title', 'like', '%' . $search . '%')
                ->orWhere('pro_p_code', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (isset($search_main_unit) && !empty($search_main_unit)) {
            $query->where('pro_main_unit_id', $search_main_unit);
        }

        if (isset($search_unit) && !empty($search_unit)) {
            $query->where('pro_unit_id', $search_unit);
        }

        if (isset($search_group) && !empty($search_group)) {
            $query->where('pro_group_id', $search_group);
        }

        if (isset($search_category) && !empty($search_category)) {
            $query->where('pro_category_id', $search_category);
        }

        if (isset($search_product_reporting_group) && !empty($search_product_reporting_group)) {
            $query->where('pro_reporting_group_id', $search_product_reporting_group);
        }


        $datas = $query->where('pro_type', config('global_variables.parent_product_type'))
            ->orderBy('pro_title', 'ASC')
            ->paginate($pagination_number);

//        dd(DB::getQueryLog());

        $product_names = ProductModel::where('pro_clg_id', $user->user_clg_id)->where('pro_type', config('global_variables.parent_product_type'))->orderBy('pro_title', 'ASC')->pluck('pro_title')->all();

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
            // WizardController::updateWizardInfo(['opening_stock'], ['opening_party_balance']);
            return view('online_product_list', compact('datas', 'search', 'product_names', 'main_units', 'units', 'groups', 'categories', 'product_reporting_groups', 'search_group', 'search_category', 'search_main_unit', 'search_unit', 'search_product_reporting_group', 'warehouses'));
        }
    }


    public function update_online_product_list(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        $ids = $request->id;
        $online = $request->online;
        $limited = $request->limited;
        $percentage = $request->s_per;
        foreach ($ids as $index => $id) {

            $product = ProductModel::where('pro_clg_id', $user->user_clg_id)->where('pro_p_code', $ids[$index])->first();
            // $online = $product->pro_title;
            // $percentage = $per[$index];
            // $limited = $limited[$index];
            ProductModel::where('pro_clg_id', $user->user_clg_id)->where('pro_p_code', $ids[$index])->update(
                [
                    'pro_online_status' => $online[$index],
                    'pro_hold_qty_per' => $percentage[$index] == '' ? 0 : $percentage[$index],
                    'pro_stock_status' => $limited[$index],

                ]
            );
        }
        return redirect()->back()->with('success', 'Successfully Updated');
    }

}
