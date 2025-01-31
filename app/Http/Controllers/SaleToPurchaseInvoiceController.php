<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\CashPaymentVoucherItemsModel;
use App\Models\CashPaymentVoucherModel;
use App\Models\DatabaseModal;
use App\Models\PostingReferenceModel;
use App\Models\ProductModel;
use App\Models\PurchaseInvoiceModel;
use App\Models\PurchaseInvoiceTempModel;
use App\Models\PurchaseSaletaxInvoiceModel;
use App\Models\ReportConfigModel;
use App\Models\SaleInvoiceItemsModel;
use App\Models\SaleInvoiceModel;
use App\Models\SystemConfigModel;
use App\Models\TransactionModel;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SaleToPurchaseInvoiceController extends Controller
{
// update code by Mustafa start
    public
    function sale_invoice_list(Request $request, $array = null, $str = null)
    {
        $client_account = DatabaseModal::pluck('db_client_id');
        $urdu_eng = ReportConfigModel::where('rc_id', '=', 1)->select('rc_invoice', 'rc_invoice_party')->first();

        $accounts = AccountRegisterationModel::whereIn('account_uid', $client_account)->orderBy('account_name', 'ASC')->get();
        $products = ProductModel::orderBy('pro_title', 'ASC')->get();
        $sale_persons = User::where('user_delete_status', '!=', 1)->where('user_role_id', '=', 4)->orderBy('user_name', 'ASC')->get();
        $posting_references = PostingReferenceModel::all();


        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_account = (!isset($request->account) && empty($request->account)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->account;
        $search_product = (!isset($request->product) && empty($request->product)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->product;
        $search_sale_persons = (!isset($request->sale_person) && empty($request->sale_person)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->sale_person;
        $search_posting_reference = (!isset($request->posting) && empty($request->posting)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->posting;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[6]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[7]->{'value'} : '') : $request->from;

        $check_desktop = $request->check_desktop;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.sale_invoice_list.sale_invoice_list';
        $pge_title = 'Sale Invoice List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_account, $search_product, $search_sale_persons, $search_posting_reference, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));

        if ($urdu_eng->rc_invoice_party == 0) {
            $query = DB::table('financials_sale_invoice')
                ->leftJoin('financials_si_dc_extension', 'financials_si_dc_extension.sde_sale_id', 'financials_sale_invoice.si_id')
                ->leftJoin('financials_users', 'financials_users.user_id', 'financials_sale_invoice.si_createdby')
                ->leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_sale_invoice.si_pr_id')
                ->whereIn('si_party_code', $client_account);
        } else {
            $query = DB::table('financials_sale_invoice')
                ->leftJoin('financials_si_dc_extension', 'financials_si_dc_extension.sde_sale_id', 'financials_sale_invoice.si_id')
                ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_sale_invoice.si_party_code')
                ->leftJoin('financials_users', 'financials_users.user_id', 'financials_sale_invoice.si_createdby')
                ->leftJoin('financials_posting_reference', 'financials_posting_reference.pr_id', 'financials_sale_invoice.si_pr_id')
                ->whereIn('si_party_code', $client_account);
        }


        if (!empty($search)) {
            if (isset($check_desktop) && !empty($check_desktop)) {
                $query->where(function ($query) use ($search) {
                    $query->where('si_local_invoice_id', 'like', '%' . $search . '%');
                });
            } else {
                $query->where(function ($query) use ($search) {
                    $query->where('si_party_code', 'like', '%' . $search . '%')
                        ->orWhere('si_party_name', 'like', '%' . $search . '%')
                        ->orWhere('si_remarks', 'like', '%' . $search . '%')
                        ->orWhere('si_id', 'like', '%' . $search . '%')
                        ->orWhere('user_designation', 'like', '%' . $search . '%')
                        ->orWhere('user_name', 'like', '%' . $search . '%')
                        ->orWhere('user_username', 'like', '%' . $search . '%');
                });
            }
        }

        if (!empty($search_account)) {
            $query->where('si_party_code', $search_account);
        }
        if (!empty($search_posting_reference)) {
            $query->where('si_pr_id', $search_posting_reference);
        }

        if (!empty($search_product)) {
            $get_p_id = SaleInvoiceItemsModel::where('sii_product_code', $search_product)->pluck('sii_invoice_id')->all();
            $query->whereIn('si_id', $get_p_id);
        }

        if (!empty($search_sale_persons)) {
            $query->where('si_sale_person', $search_sale_persons);
        }

        if (!empty($search_by_user)) {
            $query->where('si_createdby', $search_by_user);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {

            $query->whereDate('si_day_end_date', '>=', $start)
                ->whereDate('si_day_end_date', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('si_day_end_date', $start);
        } elseif (!empty($search_from)) {
            $query->where('si_day_end_date', $end);
        }

        $datas = $query->orderBy('si_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

        $party = AccountRegisterationModel::whereIn('account_uid', $client_account)->orderBy('account_name', 'ASC')->pluck('account_name')->all();


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
            return view('prego_system.sale_invoice_post_temp_purchase_invoice', compact('datas', 'search', 'party', 'accounts', 'sale_persons', 'search_account', 'search_product', 'products', 'search_to', 'search_from', 'check_desktop', 'search_by_user', 'search_sale_persons', 'urdu_eng', 'posting_references', 'search_posting_reference'));
        }
    }

    // update code by Mustafa end

    public function purchase_temp(Request $request)
    {
        $sale_invoice = SaleInvoiceModel::where('si_id', '=', $request->id)->first();
        $sale_invoice_items = SaleInvoiceItemsModel::where('sii_invoice_id', '=', $request->id)->get();
        $database_name = DatabaseModal::where('db_client_id', $sale_invoice->si_party_code)->pluck('db_name')->first();
        $preDatabase = Config::get('database.connections.mysql.database');
        $db = DB::statement("CREATE DATABASE IF NOT EXISTS $database_name");

        $new = Config::set('database.connections.mysql.database', $database_name);

        DB::purge('mysql');

        DB::reconnect('mysql');

//        Artisan::call('migrate', array('--force' => true));
//        Artisan::call('migrate');

//        $user = User::all();


        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $rollBack = false;

        $purchase_array = [];

        $invoice_type = 1;//$sale_invoice->invoice_type;

        foreach ($sale_invoice_items as $index => $requested_array) {

            $item_code = $requested_array->sii_product_code;
            $item_name = $requested_array->sii_product_name;
            $item_remarks = $requested_array->sii_remarks;
            $item_warehouse = isset($requested_array->sii_warehouse_id) ? $requested_array->sii_warehouse_id : 0;
            $item_quantity = $requested_array->sii_qty;
            $item_unit_measurement = $requested_array->sii_uom;
            $item_unit_measurement_scale_size = $requested_array->sii_scale_size;
            $item_bonus = isset($requested_array->sii_bonus_qty) ? $requested_array->sii_bonus_qty : 0;
            $item_rate = $requested_array->sii_rate;
            $item_discount = $requested_array->sii_discount_per;
            $item_discount_amount = $requested_array->sii_discount_amount;
            $item_inclusive_rate = $requested_array->sii_net_rate;
            $item_after_disc_rate = $item_rate - ($item_discount_amount / $item_quantity);
            $item_sales_tax = $requested_array->sii_saletax_per;
            $item_inclusive_exclusive = isset($requested_array->sii_saletax_inclusive) ? $requested_array->sii_saletax_inclusive : 0;
            $item_sale_tax_amount = $requested_array->psii_saletax_amount;
            $item_amount = $requested_array->sii_amount;

            $purchase_array[] = [
                'product_code' => $item_code,
                'product_name' => $item_name,
                'product_remarks' => $item_remarks,
                'warehouse' => $item_warehouse,
                'product_qty' => $item_quantity,
                'product_unit_measurement' => $item_unit_measurement,
                'product_unit_measurement_scale_size' => $item_unit_measurement_scale_size,
                'product_bonus_qty' => $item_bonus,
                'product_rate' => $item_rate,
                'product_discount' => $item_discount,
                'product_discount_amount' => $item_discount_amount,
                'product_inclusive_rate' => $item_inclusive_rate,
                'product_after_disc_rate' => $item_after_disc_rate,
                'product_sale_tax' => $item_sales_tax,
                'inclusive_exclusive_status' => $item_inclusive_exclusive,
                'product_sale_tax_amount' => $item_sale_tax_amount,
                'product_amount' => $item_amount,
            ];
        }

        $user = Auth::user();

        DB::beginTransaction();

        if ($invoice_type == 1) {

            $purchase_prefix = 'pit';
            $purchase_items_prefix = 'piit';

            $purchase_invoice = new PurchaseInvoiceTempModel();
            $purchase_item_table = 'financials_purchase_invoice_items_temp';

            $notes = 'PURCHASE_INVOICE_TEMP';

        }


        // system config set increment default id according to user giving start coding
//            $chk_bnk_pymnt = $sstm_cnfg_clm = '';
//            if ($notes === 'PURCHASE_INVOICE_TEMP'):
//                $chk_bnk_pymnt = PurchaseInvoiceTempModel::all();
//                $sstm_cnfg_clm = 'sc_purchase_invoice_number';
//
//            endif;
//            $sstm_cnfg_bp_id_chk = SystemConfigModel::where($sstm_cnfg_clm, '!=', '0')->first();
//            if ($chk_bnk_pymnt->isEmpty()):
//                if (isset($sstm_cnfg_bp_id_chk) && !empty($sstm_cnfg_bp_id_chk)):
//                    $set_id = $purchase_prefix . '_id';
//                    $purchase_invoice->$set_id = $sstm_cnfg_bp_id_chk->$sstm_cnfg_clm;
//                endif;
//            endif;
        // system config set increment default id according to user giving end coding


        //////////////////////////// Purchase Invoice Insertion ////////////////////////////////////

        $purchase_invoice = $this->AssignPurchaseInvoiceValues($sale_invoice, $purchase_invoice, $day_end, $user, $purchase_prefix);

        if ($purchase_invoice->save()) {

            $p_id = $purchase_prefix . '_id';

            $purchase_invoice_id = $purchase_invoice->$p_id;
        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Purchase Invoice Items Insertion ////////////////////////////////////
        $items = [];
        $detail_remarks = '';

        $item = $this->AssignPurchaseInvoiceItemsValues($items, $purchase_invoice_id, $purchase_array, $purchase_items_prefix);

        foreach ($item as $value) {

            $pro_rate = (float)$value[$purchase_items_prefix . '_rate'];
            $pro_amount = (float)$value[$purchase_items_prefix . '_amount'];

            $detail_remarks .= $value[$purchase_items_prefix . '_product_name'] . ', ' . $value[$purchase_items_prefix . '_qty'] . '@' . number_format($pro_rate, 2) . ' = ' . number_format($pro_amount, 2) . config('global_variables.Line_Break');
        }

        if (!DB::table($purchase_item_table)->insert($item)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Details Remarks of Purchase Invoice Insertion ////////////////////////////////////

        $purchase_detail_remarks = $purchase_prefix . '_detail_remarks';

        $purchase_invoice->$purchase_detail_remarks = $detail_remarks;

        if (!$purchase_invoice->save()) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }


        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $purchase_invoice_id);
            $dblast = Config::set('database.connections.mysql.database', $preDatabase);
//                dd($database_name, $sale_invoice, $new, $dblast, $db);
            DB::commit();
            return redirect()->back()->with('success', 'Successfully Saved');
        }


//        return dd('create database and user data');

    }

    public function AssignPurchaseInvoiceValues($request, $purchase_invoice, $day_end, $user, $prfx, $invoice_no = 0)
    {
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $party_code = $prfx . '_party_code';
        $party_name = $prfx . '_party_name';
        $posting_reference = $prfx . '_pr_id';
        $customer_name = $prfx . '_customer_name';
        $remarks = $prfx . '_remarks';
        $total_items = $prfx . '_total_items';
        $total_price = $prfx . '_total_price';
        $product_discount = $prfx . '_product_disc';
        $round_off_discount = $prfx . '_round_off_disc';
        $cash_disc_percentage = $prfx . '_cash_disc_per';
        $cash_disc_amount = $prfx . '_cash_disc_amount';
        $total_discount = $prfx . '_total_discount';
        $inclusive_sales_tax = $prfx . '_inclusive_sales_tax';
        $exclusive_sales_tax = $prfx . '_exclusive_sales_tax';
        $total_sales_tax = $prfx . '_total_sales_tax';
        $grand_total = $prfx . '_grand_total';
        $cash_paid = $prfx . '_cash_paid';
        $datetime = $prfx . '_datetime';
        $day_end_id = $prfx . '_day_end_id';
        $day_end_date = $prfx . '_day_end_date';
        $createdby = $prfx . '_createdby';
        $detail_remarks = $prfx . '_detail_remarks';
        $ip_adrs = $prfx . '_ip_adrs';
        $brwsr_info = $prfx . '_brwsr_info';
        $update_datetime = $prfx . '_update_datetime';
        $invoice_number = $prfx . '_invoice_number';


        $purchase_invoice->$party_code = $request->si_party_code;
        $purchase_invoice->$party_name = $request->si_party_name;
        $purchase_invoice->$posting_reference = $request->si_pr_id;

        $purchase_invoice->$customer_name = $request->si_customer_name;
        $purchase_invoice->$remarks = ucfirst($request->si_remarks);
        $purchase_invoice->$total_items = $request->si_total_items;
        $purchase_invoice->$total_price = $request->si_total_price;
        $purchase_invoice->$product_discount = $request->si_product_disc;
        $purchase_invoice->$round_off_discount = $request->si_round_off_disc == '' ? 0 : $request->si_round_off_disc;
        $purchase_invoice->$cash_disc_percentage = $request->si_cash_disc_per == '' ? 0 : $request->si_cash_disc_per;
        $purchase_invoice->$cash_disc_amount = $request->si_cash_disc_amount == '' ? 0 : $request->si_cash_disc_amount;
        $purchase_invoice->$total_discount = $request->si_total_discount == '' ? 0 : $request->si_total_discount;
        $purchase_invoice->$inclusive_sales_tax = $request->si_inclusive_sales_tax == '' ? 0 : $request->si_inclusive_sales_tax;
        $purchase_invoice->$exclusive_sales_tax = $request->si_exclusive_sales_tax == '' ? 0 : $request->si_exclusive_sales_tax;
        $purchase_invoice->$total_sales_tax = $request->si_total_sales_tax == '' ? 0 : $request->si_total_sales_tax;
        $purchase_invoice->$cash_paid = $request->si_cash_received;

//        $account_head = substr($request->account_name, 0, 5);

//        if ($account_head == config('global_variables.purchaser_account_head')) {
//            $purchase_invoice->$cash_paid = $request->grand_total;
//        }

        $purchase_invoice->$grand_total = $request->si_grand_total;
        $purchase_invoice->$datetime = Carbon::now()->toDateTimeString();
        $purchase_invoice->$day_end_id = $day_end->de_id;
        $purchase_invoice->$day_end_date = $day_end->de_datetime;
        $purchase_invoice->$createdby = $user->user_id;

        if ($invoice_no > 0 && !empty($invoice_no)) {
            $purchase_invoice->$invoice_number = $invoice_no;
        }

        $purchase_invoice->$brwsr_info = $brwsr_rslt;
        $purchase_invoice->$ip_adrs = $ip_rslt;
        $purchase_invoice->$update_datetime = Carbon::now()->toDateTimeString();

        return $purchase_invoice;
    }

    public function AssignPurchaseInvoiceItemsValues($data, $purchase_invoice_id, $array, $prfx)
    {
        foreach ($array as $value) {

            $purchase_invoice = $prfx . '_purchase_invoice_id';
            $product_code = $prfx . '_product_code';
            $product_name = $prfx . '_product_name';
            $remarks = $prfx . '_remarks';
            $qty = $prfx . '_qty';
            $uom = $prfx . '_uom';
            $scale_size = $prfx . '_scale_size';
            $rate = $prfx . '_rate';
            $bonus_qty = $prfx . '_bonus_qty';
            $discount_per = $prfx . '_discount_per';
            $discount_amount = $prfx . '_discount_amount';
            $after_dis_rate = $prfx . '_after_dis_rate';
            $net_rate = $prfx . '_net_rate';
            $saletax_per = $prfx . '_saletax_per';
            $saletax_inclusive = $prfx . '_saletax_inclusive';
            $saletax_amount = $prfx . '_saletax_amount';
            $amount = $prfx . '_amount';
            $warehouse_id = $prfx . '_warehouse_id';

            $data[] = [
                $purchase_invoice => $purchase_invoice_id,
                $product_code => $value['product_code'],
                $product_name => $value['product_name'],
                $warehouse_id => $value['warehouse'],
                $qty => $value['product_qty'],
                $uom => $value['product_unit_measurement'],
                $scale_size => $value['product_unit_measurement_scale_size'],
                $bonus_qty => $value['product_bonus_qty'],
                $rate => $value['product_rate'],
                $net_rate => $value['product_inclusive_rate'],
                $discount_per => $value['product_discount'],
                $discount_amount => $value['product_discount_amount'],
                $after_dis_rate => $value['product_rate'] - ($value['product_discount_amount'] / $value['product_qty']),
                $saletax_per => $value['product_sale_tax'],
                $saletax_inclusive => $value['inclusive_exclusive_status'],
                $saletax_amount => $value['product_sale_tax_amount'],
                $amount => $value['product_amount'],
                $remarks => $value['product_remarks'],
            ];
        }

        return $data;
    }
}
