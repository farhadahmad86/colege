<?php

namespace App\Http\Controllers\Teller;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountRegisterationModel;
use App\Models\ProductModel;
use App\Models\ProductPackagesModel;
use App\Models\SaleReturnInvoiceItemsModel;
use App\Models\ServicesModel;
use App\User;
use Auth;
use PDF;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Excel;

class SaleReturnInvoiceController extends Controller
{
    public function sale_return_invoice()
    {
//        $heads = explode(',', config('global_variables.payable_receivable_cash'));
//
//        $accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)
//            ->whereNotIn(
//                'account_uid', AccountRegisterationModel::where('account_parent_code', config('global_variables.cash'))
//                ->where('account_uid', '!=', config('global_variables.cash_in_hand'))
//                ->pluck('account_uid')->all()
//            )
//            ->orderBy('account_uid', 'ASC')
//            ->get();
//
            $user = Auth::user();
            $accounts = AccountRegisterationModel::where('account_employee_id', $user->user_id)->get();

        $products = ProductModel::orderBy('pro_id', 'ASC')->get();

        $pro_code = '';
        $pro_name = '';

        foreach ($products as $product) {

            $pro_code .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' data-sale_price='$product->pro_sale_price' data-tax='$product->pro_tax' data-retailer_dis='$product->pro_retailer_discount' data-whole_saler_dis='$product->pro_whole_seller_discount' data-loyalty_dis='$product->pro_loyalty_card_discount'>$product->pro_code</option>";

            $pro_name .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' data-sale_price='$product->pro_sale_price' data-tax='$product->pro_tax' data-retailer_dis='$product->pro_retailer_discount' data-whole_saler_dis='$product->pro_whole_seller_discount' data-loyalty_dis='$product->pro_loyalty_card_discount'>$product->pro_title</option>";

        }

        $services = ServicesModel::orderBy('ser_id', 'ASC')->get();

        $service_code = '';
        $service_name = '';

        foreach ($services as $service) {
            $service_code .= "<option value='$service->ser_id'>$service->ser_id</option>";
            $service_name .= "<option value='$service->ser_id'>$service->ser_title</option>";
        }

        $packages = ProductPackagesModel::orderBy('pp_name', 'ASC')->get();

        $sale_persons = User::where('user_id', '!=', 1)->orderBy('user_role_id', 'DESC')->orderBy('user_name', 'ASC')->get();

        return view('teller/sale_return_invoice', compact('pro_code', 'pro_name', 'accounts', 'products', 'sale_persons', 'service_code', 'service_name', 'packages'));
    }

    public function sale_return_invoice_list(Request $request, $array = null, $str = null)
    {
        $heads = config('global_variables.payable_receivable_cash');
        $heads = explode(',', $heads);

        $accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)->orderBy('account_name', 'ASC')->get();
        $products = ProductModel::orderBy('pro_title', 'ASC')->get();

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_account = (!isset($request->account) && empty($request->account)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->account;
        $search_product = (!isset($request->product) && empty($request->product)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->product;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->from;
        $check_desktop = $request->check_desktop;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.sale_invoice_list.sale_invoice_list';
        $pge_title = 'Sale Invoice List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_account, $search_product, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $query = DB::table('financials_sale_return_invoice')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_sale_return_invoice.sri_createdby');

        if (!empty($search)) {
            if (isset($check_desktop) && !empty($check_desktop)) {
                $query->where(function ($query) use ($search) {
                    $query->where('sri_local_invoice_id', 'like', '%' . $search . '%');
                });
            } else {
                $query->where(function ($query) use ($search) {
                    $query->where('sri_party_code', 'like', '%' . $search . '%')
                        ->orWhere('sri_party_name', 'like', '%' . $search . '%')
                        ->orWhere('sri_remarks', 'like', '%' . $search . '%')
                        ->orWhere('sri_id', 'like', '%' . $search . '%')
                        ->orWhere('user_designation', 'like', '%' . $search . '%')
                        ->orWhere('user_name', 'like', '%' . $search . '%')
                        ->orWhere('user_username', 'like', '%' . $search . '%');
                });
            }
        }

        if (!empty($search_account)) {
            $query->where('sri_party_code', $search_account);
        }

        if (!empty($search_product)) {
            $get_p_id = SaleReturnInvoiceItemsModel::where('srii_product_code', $search_product)->pluck('srii_sale_invoice_id')->all();
            $query->whereIn('sri_id', $get_p_id);
        }

        if (!empty($search_by_user)) {
            $query->where('sri_createdby', $search_by_user);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('si_day_end_date', [$start, $end]);
            $query->whereDate('sri_day_end_date', '>=', $start)
                ->whereDate('sri_day_end_date', '<=', $end);
        }

        elseif (!empty($search_to)) {
            $query->where('sri_day_end_date', $start);
        }

        elseif (!empty($search_from)) {
            $query->where('sri_day_end_date', $end);
        }

        $user = Auth::user();

        $datas = $query->where('sri_createdby', $user->user_id)
            ->orderBy('sri_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

        $party = AccountRegisterationModel::whereIn('account_parent_code', $heads)->orderBy('account_name', 'ASC')->pluck('account_name')->all();


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
            return view('teller/sale_return_invoice_list', compact('datas', 'search', 'party', 'accounts', 'search_account', 'search_product', 'products', 'search_to', 'search_from', 'check_desktop',
                'search_by_user'));
        }
    }

    public function sale_tax_sale_return_invoice_list(Request $request, $array = null, $str = null)
    {
        $heads = config('global_variables.payable_receivable_cash');
        $heads = explode(',', $heads);

        $accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)->orderBy('account_name', 'ASC')->get();
        $products = ProductModel::orderBy('pro_title', 'ASC')->get();

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_account = (!isset($request->account) && empty($request->account)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->account;
        $search_product = (!isset($request->product) && empty($request->product)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->product;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->from;
        $check_desktop = $request->check_desktop;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.sale_invoice_list.sale_invoice_list';
        $pge_title = 'Sale Invoice List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_account, $search_product, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        $query = DB::table('financials_sale_return_saletax_invoice')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_sale_return_saletax_invoice.srsi_createdby');

        if (!empty($search)) {
            if (isset($check_desktop) && !empty($check_desktop)) {
                $query->where(function ($query) use ($search) {
                    $query->where('srsi_local_invoice_id', 'like', '%' . $search . '%');
                });
            } else {
                $query->where(function ($query) use ($search) {
                    $query->where('srsi_party_code', 'like', '%' . $search . '%')
                        ->orWhere('srsi_party_name', 'like', '%' . $search . '%')
                        ->orWhere('srsi_remarks', 'like', '%' . $search . '%')
                        ->orWhere('srsi_id', 'like', '%' . $search . '%')
                        ->orWhere('user_designation', 'like', '%' . $search . '%')
                        ->orWhere('user_name', 'like', '%' . $search . '%')
                        ->orWhere('user_username', 'like', '%' . $search . '%');
                });
            }
        }

        if (!empty($search_account)) {
            $query->where('srsi_party_code', $search_account);
        }

        if (!empty($search_product)) {
            $get_p_id = SaleReturnInvoiceItemsModel::where('srsii_product_code', $search_product)->pluck('srsii_sale_invoice_id')->all();
            $query->whereIn('srsi_id', $get_p_id);
        }

        if (!empty($search_by_user)) {
            $query->where('srsi_createdby', $search_by_user);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
//            $query->whereBetween('si_day_end_date', [$start, $end]);
            $query->whereDate('srsi_day_end_date', '>=', $start)
                ->whereDate('srsi_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('srsi_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('srsi_day_end_date', $end);
        }

        $user = Auth::user();

        $datas = $query->where('srsi_createdby', $user->user_id)
            ->orderBy('srsi_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

        $party = AccountRegisterationModel::whereIn('account_parent_code', $heads)->orderBy('account_name', 'ASC')->pluck('account_name')->all();


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
            return view('teller/sale_return_invoice_sale_tax_list', compact('datas', 'search', 'party', 'accounts', 'search_account', 'search_product', 'products', 'search_to', 'search_from', 'check_desktop', 'search_by_user'));
        }
    }
}
