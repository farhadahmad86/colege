<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\CashReceiptVoucherItemsModel;
use App\Models\CashReceiptVoucherModel;
use App\Models\SaleInvoiceItemsModel;
use App\Models\SaleInvoiceModel;
use App\Models\SaleSaletaxInvoiceModel;
use App\Models\ServiceSaleTaxInvoiceItemsModel;
use App\Models\ServiceSaleTaxInvoiceModel;
use App\Models\ServicesInvoiceItemsModel;
use App\Models\ServicesInvoiceModel;
use App\Models\ServicesModel;
use App\Models\TransactionModel;
use Auth;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class ServicesInvoiceController extends Controller
{
    public $invoice_profit = 0;

//    public function services_invoice_on_cash()
//    {
//        $account = AccountRegisterationModel::where('account_uid', config('global_variables.cash_in_hand'))->first();
//
//        $services = ServicesModel::orderBy('ser_id', 'ASC')->get();
//
//        return view('service_invoice_on_cash', compact('account', 'services'));
//    }

    public function services_invoice()
    {
        $heads = config('global_variables.payable_receivable_cash_bank');
        $heads = explode(',', $heads);

//        $accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)->orderBy('account_uid', 'ASC')->get();

        $accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)
            ->whereNotIn(
                'account_uid', AccountRegisterationModel::where('account_parent_code', config('global_variables.cash'))
                ->where('account_uid', '!=', config('global_variables.cash_in_hand'))
                ->pluck('account_uid')->all()
            )
            ->orderBy('account_uid', 'ASC')
            ->get();

        $services = ServicesModel::orderBy('ser_id', 'ASC')->get();

        $service_code = '';
        $service_name = '';

        foreach ($services as $service) {
            $service_code .= "<option value='$service->ser_id'>$service->ser_id</option>";
            $service_name .= "<option value='$service->ser_id'>$service->ser_title</option>";
        }

        return view('service_invoice', compact('accounts', 'service_code', 'service_name'));
    }

//    public function service_tax_invoice()
//    {
//        $heads = config('global_variables.payable_receivable');
//        $heads = explode(',', $heads);
//
//        $accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)->orderBy('account_uid', 'ASC')->get();
//
//        $services = ServicesModel::orderBy('ser_id', 'ASC')->get();
//
//        return view('service_tax_invoice', compact('accounts', 'services'));
//    }

    public function submit_services_invoice(Request $request)
    {
        $this->service_invoice_validation($request);

        $user = Auth::user();
        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $rollBack = false;
        $account_code = $request->account_code;

        $cash_in_hand = config('global_variables.cash_in_hand');
        $sale_tax_account = config('global_variables.sales_tax_payable_account');
        $sale_account = config('global_variables.sale_account');

        $values_array = json_decode($request->servicesval, true);
        $invoice_type = $request->invoice_type;
        $grand_total = $request->grand_total;
        $saletax_amount = $request->sales_tax_amount;
        $total_sale_amount = $grand_total - $saletax_amount;


        if ($user->user_role_id == config('global_variables.teller_account_id')) {

            $account = $this->get_teller_cash_account($user->user_id);

            $cash_in_hand = $account->account_uid;
        }

        DB::beginTransaction();

        if ($invoice_type == 1) {

            $service_prefix = 'sei';
            $service_items_prefix = 'seii';

            $service_invoice = new ServicesInvoiceModel();
            $item_table = 'financials_service_invoice_items';

            $notes = 'SERVICE_INVOICE';

            $voucher_code = config('global_variables.SERVICE_VOUCHER_CODE');

            $transaction_type = config('global_variables.SERVICE_INVOICE');

        } else {

            $service_prefix = 'sesi';
            $service_items_prefix = 'sesii';

            $service_invoice = new ServiceSaleTaxInvoiceModel();
            $item_table = 'financials_service_saletax_invoice_items';

            $notes = 'SERVICE_SALE_TAX_INVOICE';

            $voucher_code = config('global_variables.SERVICE_SALE_TAX_VOUCHER_CODE');

            $transaction_type = config('global_variables.SERVICE_SALE_TAX_INVOICE');
        }

        //////////////////////////// Service Invoice Insertion ////////////////////////////////////

        $service_invoice = $this->AssignServiceInvoiceValues($request, $service_invoice, $day_end, $user, $service_prefix);

        if ($service_invoice->save()) {

            $se_id = $service_prefix . '_id';

            $service_invoice_id = $service_invoice->$se_id;
        } else {
            $rollBack = true;
            DB::rollBack();
        }

        //////////////////////////// Service Invoice Items Insertion ////////////////////////////////////

        $items = [];
        $detail_remarks = '';

        $item = $this->AssignServiceInvoiceItemsValues($items, $service_invoice_id, $values_array, $service_items_prefix);

        foreach ($item as $value) {

            $service_rate = (float)$value[$service_items_prefix . '_rate'];
            $service_amount = (float)$value[$service_items_prefix . '_amount'];

            $detail_remarks .= $value[$service_items_prefix . '_service_name'] . ', ' . $value[$service_items_prefix . '_qty'] . '@' . number_format($service_rate, 2) . ' = ' . number_format($service_amount, 2) . config('global_variables.Line_Break');
        }

        if (!DB::table($item_table)->insert($item)) {
            $rollBack = true;
            DB::rollBack();
        }

        //////////////////////////// Details Remarks of Service Invoice Insertion ////////////////////////////////////

        $service_detail_remarks = $service_prefix . '_detail_remarks';

        $service_invoice->$service_detail_remarks = $detail_remarks;

        if (!$service_invoice->save()) {
            $rollBack = true;
            DB::rollBack();
        }

        //////////////////////////// TRANSACTION ONE STOCK IN HAND ////////////////////////////////////

        $transactions1 = new TransactionModel();
        $transaction1 = $this->AssignTransactionsValues($transactions1, 0, $total_sale_amount, $sale_account, $notes, $transaction_type, $service_invoice_id);

        if ($transaction1->save()) {

            $transaction_id1 = $transaction1->trans_id;

            $balances1 = new BalancesModel();

            $balance1 = $this->AssignAccountBalancesValues($balances1, $transaction_id1, $sale_account, $total_sale_amount, 'Cr', $request->remarks,
                $notes, $detail_remarks, $voucher_code . $service_invoice_id,1);


            if (!$balance1->save()) {
                $rollBack = true;
                DB::rollBack();
            }
        } else {
            $rollBack = true;
            DB::rollBack();
        }


        if ($invoice_type == 2 && $saletax_amount > 0) {

            //////////////////////////// TRANSACTION TWO SALE TAX ACCOUNT ////////////////////////////////////

            $transactions2 = new TransactionModel();
            $transaction2 = $this->AssignTransactionsValues($transactions2, 0, $saletax_amount, $sale_tax_account, $notes, $transaction_type, $service_invoice_id);

            if ($transaction2->save()) {

                $transaction_id2 = $transaction2->trans_id;

                $balances2 = new BalancesModel();

                $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id2, $sale_tax_account, $saletax_amount, 'Cr', $request->remarks, $notes, $detail_remarks, $voucher_code .
                    $service_invoice_id,1);

                if (!$balance2->save()) {
                    $rollBack = true;
                    DB::rollBack();
                }
            } else {
                $rollBack = true;
                DB::rollBack();
            }

        }


        if ($request->account_code != $cash_in_hand && $request->cash_paid > 0) {

            //////////////////////////// TRANSACTION THREE CASH ACCOUNT ////////////////////////////////////
            ///
            $remaining_grand_total = $grand_total - $request->cash_paid;

            $transactions3 = new TransactionModel();
            $transaction3 = $this->AssignTransactionsValues($transactions3, $cash_in_hand, $request->cash_paid, 0, $notes, $transaction_type, $service_invoice_id);


            if ($transaction3->save()) {

                $transaction_id3 = $transaction3->trans_id;

                $balances3 = new BalancesModel();

                $balance3 = $this->AssignAccountBalancesValues($balances3, $transaction_id3, $cash_in_hand, $request->cash_paid, 'Dr', $request->remarks,
                    $notes, $detail_remarks, $voucher_code . $service_invoice_id,1);

                if (!$balance3->save()) {
                    $rollBack = true;
                    DB::rollBack();
                }
            } else {
                $rollBack = true;
                DB::rollBack();
            }

        } else {
            $remaining_grand_total = $request->grand_total;
        }


        //////////////////////////// TRANSACTION FOUR PARTY ACCOUNT ////////////////////////////////////

        $transactions4 = new TransactionModel();
        $transaction4 = $this->AssignTransactionsValues($transactions4, $account_code, $remaining_grand_total, 0, $notes, $transaction_type, $service_invoice_id);

        if ($transaction4->save()) {

            $transaction_id4 = $transaction4->trans_id;
            $balances4 = new BalancesModel();

            $balance4 = $this->AssignAccountBalancesValues($balances4, $transaction_id4, $account_code, $remaining_grand_total, 'Dr', $request->remarks,
                $notes, $detail_remarks, $voucher_code . $service_invoice_id,1);

            if (!$balance4->save()) {
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

            DB::commit();
            return redirect()->back()->with('success', 'Successfully Saved');
        }
    }

    public function service_invoice_validation($request)
    {
        return $this->validate($request, [
            'account_code' => ['required', 'numeric'],
            'account_name_text' => ['required', 'string'],
            'remarks' => ['nullable', 'string'],
            'customer_name' => ['nullable', 'string'],
            'invoice_type' => ['required', 'numeric', 'min:1'],
            'total_items' => ['required', 'numeric', 'min:1'],
            'total_price' => ['required', 'numeric'],
            'expense' => ['nullable', 'numeric'],
            'disc_percentage' => ['nullable', 'numeric'],
            'disc_amount' => ['nullable', 'numeric'],
            'services_tax_amount' => ['nullable', 'numeric'],
            'grand_total' => ['required', 'numeric', 'min:1'],
            'cash_paid' => ['nullable', 'numeric'],
            'servicesval' => ['required', 'string'],
        ]);

    }

    public function AssignServiceInvoiceValues($request, $service_invoice, $day_end, $user, $prfx)
    {
        $party_code = $prfx . '_party_code';
        $party_name = $prfx . '_party_name';
        $customer_name = $prfx . '_customer_name';
        $remarks = $prfx . '_remarks';
        $total_items = $prfx . '_total_items';
        $total_price = $prfx . '_total_price';
        $expense = $prfx . '_expense';
        $trade_disc_percentage = $prfx . '_trade_disc_percentage';
        $trade_disc = $prfx . '_trade_disc';
        $total_discount = $prfx . '_total_discount';
        $sales_tax = $prfx . '_sales_tax';
        $grand_total = $prfx . '_grand_total';
        $cash_paid = $prfx . '_cash_paid';
        $datetime = $prfx . '_datetime';
        $day_end_id = $prfx . '_day_end_id';
        $day_end_date = $prfx . '_day_end_date';
        $createdby = $prfx . '_createdby';
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $service_invoice->$party_code = $request->account_code;
        $service_invoice->$party_name = $request->account_name_text;
        $service_invoice->$customer_name = ucwords($request->customer_name);
        $service_invoice->$remarks = ucfirst($request->remarks);
        $service_invoice->$total_items = $request->total_items;
        $service_invoice->$total_price = $request->total_price;
        $service_invoice->$expense = $request->expense == '' ? 0 : $request->expense;
        $service_invoice->$trade_disc_percentage = $request->disc_percentage == '' ? 0 : $request->disc_percentage;
        $service_invoice->$trade_disc = $request->disc_amount;
        $service_invoice->$total_discount = $request->total_discount;
        $service_invoice->$sales_tax = $request->sales_tax_amount;
        $service_invoice->$cash_paid = $request->cash_paid == '' ? 0 : $request->cash_paid;

        if ($request->account_code == config('global_variables.cash_in_hand')) {
            $service_invoice->$cash_paid = $request->grand_total;
        }

        $service_invoice->$grand_total = $request->grand_total;
        $service_invoice->$datetime = Carbon::now()->toDateTimeString();
        $service_invoice->$day_end_id = $day_end->de_id;
        $service_invoice->$day_end_date = $day_end->de_datetime;
        $service_invoice->$createdby = $user->user_id;

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $service_invoice->$brwsr_col = $brwsr_rslt;
        $service_invoice->$ip_col = $ip_rslt;
        $service_invoice->$updt_date_col = Carbon::now()->toDateTimeString();
        // coding from shahzaib end

        return $service_invoice;
    }

    public function AssignServiceInvoiceItemsValues($data, $service_invoice_id, $values, $prfx)
    {
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        foreach ($values as $key) {

            $service_invoice = $prfx . '_service_invoice_id';
            $service_code = $prfx . '_service_code';
            $service_name = $prfx . '_service_name';
            $remarks = $prfx . '_remarks';
            $qty = $prfx . '_qty';
            $rate = $prfx . '_rate';
            $discount = $prfx . '_discount';
            $saletax = $prfx . '_saletax';
            $amount = $prfx . '_amount';
//            $brwsr_col = $prfx . '_brwsr_info';
//            $ip_col = $prfx . '_ip_adrs';
//            $updt_date_col = $prfx . '_update_datetime';

            $data[] = [$service_invoice => $service_invoice_id, $service_code => $key[0], $service_name => ucwords($key[1]), $remarks => ucfirst($key[8]), $qty => $key[2], $rate => $key[3],
                $discount => $key[5], $saletax => $key[6], $amount => $key[4]
//                , $brwsr_col => $brwsr_rslt, $ip_col => $ip_rslt, $updt_date_col => Carbon::now()->toDateTimeString()
            ];
        }

        return $data;
    }

//    public function AssignBalancesValues($request, $data, $transaction_id, $cr, $amount, $account_id, $remarks, $detail_remarks, $service_invoice_id)
//    {
//        $user = Auth::user();
//
//        $get_day_end = new DayEndController();
//        $day_end = $get_day_end->day_end();
//
//        $calculate_balance = new BalancesController();
//
//        $previous_balance_stock = $calculate_balance->calculate_balance($cr);
//        $total_balance_stock = $previous_balance_stock + $amount;
//
//
//        // coding from shahzaib start
//        $prfx = 'bal';
//        $brwsr_rslt = $this->getBrwsrInfo();
//        $ip_rslt = $this->getIp();
//        $brwsr_col = $prfx . '_brwsr_info';
//        $ip_col = $prfx . '_ip_adrs';
//        $updt_date_col = $prfx . '_update_datetime';
//        // coding from shahzaib end
//
//
//        $data[] = ['bal_account_id' => $cr, 'bal_transaction_type' => 'SERVICE INVOICE', 'bal_remarks' => ucfirst($remarks), 'bal_dr' => 0, 'bal_cr' => $amount, 'bal_total' => $total_balance_stock, 'bal_transaction_id' => $transaction_id, 'bal_datetime' => Carbon::now()->toDateTimeString(), 'bal_day_end_id' => $day_end->de_id, 'bal_day_end_date' => $day_end->de_datetime, 'bal_detail_remarks' => $detail_remarks, 'bal_voucher_number' => $service_invoice_id, 'bal_user_id' => $user->user_id, $brwsr_col => $brwsr_rslt, $ip_col => $ip_rslt, $updt_date_col => Carbon::now()->toDateTimeString()];
//
//
//        $previous_balance_party = $calculate_balance->calculate_balance($account_id);
//
//        if ($request->party_head == config('global_variables.payable')) {
//            //payables
//            $total_balance_party = $previous_balance_party - $amount;
//
//        } elseif ($request->party_head == config('global_variables.receivable') || $request->party_head == config('global_variables.cash')) {
//            //receivables
//            $total_balance_party = $previous_balance_party + $amount;
//        }
//
//        if ($account_id == config('global_variables.cash_in_hand')) {
//            $total_balance_party = $previous_balance_party + $amount;
//        }
//
//        $data[] = ['bal_account_id' => $account_id, 'bal_transaction_type' => 'SERVICE INVOICE', 'bal_remarks' => ucfirst($remarks), 'bal_dr' => $amount, 'bal_cr' => 0, 'bal_total' => $total_balance_party, 'bal_transaction_id' => $transaction_id, 'bal_datetime' => Carbon::now()->toDateTimeString(), 'bal_day_end_id' => $day_end->de_id, 'bal_day_end_date' => $day_end->de_datetime, 'bal_detail_remarks' => $detail_remarks, 'bal_voucher_number' => $service_invoice_id, 'bal_user_id' => $user->user_id, $brwsr_col => $brwsr_rslt, $ip_col => $ip_rslt, $updt_date_col => Carbon::now()->toDateTimeString()];
//
//        return $data;
//    }


    // update code by shahzaib start
    public function services_invoice_list(Request $request, $array = null, $str = null)
    {

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.services_invoice_list.services_invoice_list';
        $pge_title = 'Services Invoice List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;


        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));


        $query = DB::table('financials_service_invoice')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_service_invoice.sei_createdby');

        if (!empty($request->search)) {
            $query->where(function ($query) use ($search) {
                $query->where('sei_party_code', 'like', '%' . $search . '%')
                    ->orWhere('sei_party_name', 'like', '%' . $search . '%')
                    ->orWhere('sei_remarks', 'like', '%' . $search . '%')
                    ->orWhere('sei_id', 'like', '%' . $search . '%')
                    ->orWhere('user_designation', 'like', '%' . $search . '%')
                    ->orWhere('user_name', 'like', '%' . $search . '%')
                    ->orWhere('user_username', 'like', '%' . $search . '%');
            });
        }

        if (!empty($search_by_user)) {
            $query->where('sei_createdby', $search_by_user);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereDate('sei_day_end_date', '>=', $start)
                ->whereDate('sei_day_end_date', '<=', $end);
        }

        elseif (!empty($search_to)) {
            $query->where('sei_day_end_date', $start);
        }

        elseif (!empty($search_from)) {
            $query->where('sei_day_end_date', $end);
        }

        $datas = $query->orderBy('sei_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

        $heads = config('global_variables.payable_receivable_cash');
        $heads = explode(',', $heads);
        $party = AccountRegisterationModel::whereIn('account_parent_code', $heads)->orderBy('account_name', 'ASC')->pluck('account_name')->all();


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

            $pdf->loadView($prnt_page_dir, compact('srch_fltr','datas', 'type', 'pge_title','srch_fltr'));
//            $pdf->setOptions($options);

            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        }
        else {
            return view('service_invoice_list', compact('datas', 'search', 'party', 'search_by_user', 'search_to', 'search_from'));
        }

    }
    // update code by shahzaib end


    public function services_items_view_details(Request $request)
    {
        $items = ServicesInvoiceItemsModel::where('seii_service_invoice_id', $request->id)->orderby('seii_service_name', 'ASC')->get();

        return response()->json($items);
    }

    public function services_items_view_details_SH(Request $request, $id)
    {

        $seim = ServicesInvoiceModel::where('sei_id', $id)->first();
        $sim = SaleInvoiceModel::where('si_service_invoice_id', $id)->first();
        $accnts = AccountRegisterationModel::where('account_uid', $seim->sei_party_code)->first();
        $sales = DB::table('financials_sale_invoice_items')
            ->where('sii_invoice_id', $seim->sei_sale_invoice_id)
            ->orderby('sii_product_name', 'ASC')
//            ->select('sii_product_name as name', 'sii_remarks as remarks', 'sii_qty as qty', 'sii_rate as rate', 'sii_discount as discount', 'sii_saletax as sale_tax', 'sii_amount as amount')
            ->select('sii_product_name as name', 'sii_remarks as remarks', 'sii_qty as qty', 'sii_rate as rate', 'sii_discount_per as discount', 'sii_after_dis_rate as after_discount', 'sii_saletax_per as sale_tax', 'sii_saletax_amount as sale_tax_amount', 'sii_saletax_inclusive as inclu_exclu', 'sii_amount as amount');

        $siims = DB::table('financials_service_invoice_items')
            ->where('seii_invoice_id', $id)
            ->orderby('seii_service_name', 'ASC')
//            ->select('sseii_service_name as name', 'sseii_remarks as remarks', 'sseii_qty as qty', 'sseii_rate as rate', 'sseii_discount as discount', 'sseii_saletax as sale_tax', 'sseii_amount as amount')
            ->select('seii_service_name as name', 'seii_remarks as remarks', 'seii_qty as qty', 'seii_rate as rate', 'seii_discount_per as discount', 'seii_after_dis_rate as after_discount', 'seii_saletax_per as sale_tax', 'seii_saletax_amount as sale_tax_amount', 'seii_saletax_inclusive as inclu_exclu', 'seii_amount as amount')
            ->union($sales)
            ->get();

        $si_grand_total = (isset($sim->si_grand_total) && !empty($sim->si_grand_total)) ? $sim->si_grand_total : 0;
        $sei_grand_total = (isset($seim->sei_grand_total) && !empty($seim->sei_grand_total)) ? $seim->sei_grand_total : 0;
        $mainGrndTtl = +$si_grand_total + +$sei_grand_total;
        $nbrOfWrds = $this->myCnvrtNbr($mainGrndTtl);
        $invoice_nbr = $seim->sei_id;
        $invoice_date = $seim->sei_day_end_date;
        $type = 'grid';
        $pge_title = 'Services Invoice';


        return view('invoice_view.service_invoice.service_invoice_list_modal', compact('siims', 'sim', 'seim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title'));


    }

    public function services_items_view_details_pdf_SH(Request $request, $id)
    {

        $seim = ServicesInvoiceModel::where('sei_id', $id)->first();
        $sim = SaleInvoiceModel::where('si_service_invoice_id', $id)->first();
        $accnts = AccountRegisterationModel::where('account_uid', $seim->sei_party_code)->first();
        $sales = DB::table('financials_sale_invoice_items')
            ->where('sii_invoice_id', $seim->sei_sale_invoice_id)
            ->orderby('sii_product_name', 'ASC')
//            ->select('sii_product_name as name', 'sii_remarks as remarks', 'sii_qty as qty', 'sii_rate as rate', 'sii_discount as discount', 'sii_saletax as sale_tax', 'sii_amount as amount')
            ->select('sii_product_name as name', 'sii_remarks as remarks', 'sii_qty as qty', 'sii_rate as rate', 'sii_discount_per as discount', 'sii_after_dis_rate as after_discount', 'sii_saletax_per as sale_tax', 'sii_saletax_amount as sale_tax_amount', 'sii_saletax_inclusive as inclu_exclu', 'sii_amount as amount');

        $siims = DB::table('financials_service_invoice_items')
            ->where('seii_invoice_id', $id)
            ->orderby('seii_service_name', 'ASC')
//            ->select('sseii_service_name as name', 'sseii_remarks as remarks', 'sseii_qty as qty', 'sseii_rate as rate', 'sseii_discount as discount', 'sseii_saletax as sale_tax', 'sseii_amount as amount')
            ->select('seii_service_name as name', 'seii_remarks as remarks', 'seii_qty as qty', 'seii_rate as rate', 'seii_discount_per as discount', 'seii_after_dis_rate as after_discount', 'seii_saletax_per as sale_tax', 'seii_saletax_amount as sale_tax_amount', 'seii_saletax_inclusive as inclu_exclu', 'seii_amount as amount')
            ->union($sales)
            ->get();

        $si_grand_total = (isset($sim->si_grand_total) && !empty($sim->si_grand_total)) ? $sim->si_grand_total : 0;
        $sei_grand_total = (isset($seim->sei_grand_total) && !empty($seim->sei_grand_total)) ? $seim->sei_grand_total : 0;
        $mainGrndTtl = +$si_grand_total + +$sei_grand_total;
        $nbrOfWrds = $this->myCnvrtNbr($mainGrndTtl);
        $invoice_nbr = $seim->sei_id;
        $invoice_date = $seim->sei_day_end_date;
        $type = 'pdf';
        $pge_title = 'Services Invoice';


        $footer = view('invoice_view._partials.pdf_footer')->render();
        $header = view('invoice_view._partials.pdf_header', compact( 'invoice_nbr', 'invoice_date', 'pge_title', 'type'))->render();
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

        $pdf->loadView('invoice_view.service_invoice.service_invoice_list_modal', compact('siims', 'sim', 'seim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title'));
//        $pdf->setOptions($options);

        return $pdf->stream('Services-Invoice.pdf');
    }

    // update code by shahzaib start
    public function service_tax_invoice_list(Request $request, $array = null, $str = null)
    {

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.services_tax_invoice_list.services_tax_invoice_list';
        $pge_title = 'Services Sale Tax Invoice List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));


        $query = DB::table('financials_service_saletax_invoice')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_service_saletax_invoice.sesi_createdby');

        if (!empty($request->search)) {
            $query->where(function ($query) use ($search) {
                $query->where('sesi_party_code', 'like', '%' . $search . '%')
                    ->orWhere('sesi_party_name', 'like', '%' . $search . '%')
                    ->orWhere('sesi_remarks', 'like', '%' . $search . '%')
                    ->orWhere('sesi_id', 'like', '%' . $search . '%')
                    ->orWhere('user_designation', 'like', '%' . $search . '%')
                    ->orWhere('user_name', 'like', '%' . $search . '%')
                    ->orWhere('user_username', 'like', '%' . $search . '%');
            });
        }

        if (!empty($search_by_user)) {
            $query->where('sesi_createdby', $search_by_user);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereDate('sesi_day_end_date', '>=', $start)
                ->whereDate('sesi_day_end_date', '<=', $end);
        }

        elseif (!empty($search_to)) {
            $query->where('sesi_day_end_date', $start);
        }

        elseif (!empty($search_from)) {
            $query->where('sesi_day_end_date', $end);
        }



        $datas = $query->orderBy('sesi_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);


        $heads = config('global_variables.payable_receivable');
        $heads = explode(',', $heads);
        $party = AccountRegisterationModel::whereIn('account_parent_code', $heads)->orderBy('account_name', 'ASC')->pluck('account_name')->all();


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
            $pdf->loadView($prnt_page_dir, compact('srch_fltr','datas', 'type', 'pge_title'));
            // $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        }
        else {
            return view('service_tax_invoice_list', compact('datas', 'party', 'search_by_user', 'search', 'search_to', 'search_from'));
        }
    }
    // update code by shahzaib end

    public function services_tax_items_view_details_SH(Request $request, $id)
    {

        $seim = ServiceSaleTaxInvoiceModel::where('sesi_id', $id)->first();
        $sim = SaleSaletaxInvoiceModel::where('ssi_service_invoice_id', $id)->first();
        $accnts = AccountRegisterationModel::where('account_uid', $seim->sesi_party_code)->first();
        $sales = DB::table('financials_sale_saletax_invoice_items')
            ->where('ssii_invoice_id', $seim->sesi_sale_invoice_id)
            ->orderby('ssii_product_name', 'ASC')
//            ->select('sii_product_name as name', 'sii_remarks as remarks', 'sii_qty as qty', 'sii_rate as rate', 'sii_discount as discount', 'sii_saletax as sale_tax', 'sii_amount as amount')
            ->select('ssii_product_name as name', 'ssii_remarks as remarks', 'ssii_qty as qty', 'ssii_rate as rate', 'ssii_discount_per as discount', 'ssii_after_dis_rate as after_discount', 'ssii_saletax_per as sale_tax', 'ssii_saletax_amount as sale_tax_amount', 'ssii_saletax_inclusive as inclu_exclu', 'ssii_amount as amount');

        $siims = DB::table('financials_service_saletax_invoice_items')
            ->where('sesii_invoice_id', $id)
            ->orderby('sesii_service_name', 'ASC')
//            ->select('sseii_service_name as name', 'sseii_remarks as remarks', 'sseii_qty as qty', 'sseii_rate as rate', 'sseii_discount as discount', 'sseii_saletax as sale_tax', 'sseii_amount as amount')
            ->select('sesii_service_name as name', 'sesii_remarks as remarks', 'sesii_qty as qty', 'sesii_rate as rate', 'sesii_discount_per as discount', 'sesii_after_dis_rate as after_discount', 'sesii_saletax_per as sale_tax', 'sesii_saletax_amount as sale_tax_amount', 'sesii_saletax_inclusive as inclu_exclu', 'sesii_amount as amount')
            ->union($sales)
            ->get();

        $ssi_grand_total = (isset($sim->ssi_grand_total) && !empty($sim->ssi_grand_total)) ? $sim->ssi_grand_total : 0;
        $sesi_grand_total = (isset($seim->sesi_grand_total) && !empty($seim->sesi_grand_total)) ? $seim->sesi_grand_total : 0;
        $mainGrndTtl = +$ssi_grand_total + +$sesi_grand_total;
        $nbrOfWrds = $this->myCnvrtNbr($mainGrndTtl);
        $invoice_nbr = $seim->sesi_id;
        $invoice_date = $seim->sesi_day_end_date;
        $type = 'grid';
        $pge_title = 'Services Sale Tax Invoice';


        return view('invoice_view.service_sale_tax_invoice.service_sale_tax_invoice_list_modal', compact('siims', 'sim', 'seim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title'));


    }

    public function services_tax_items_view_details_pdf_SH(Request $request, $id)
    {

        $seim = ServiceSaleTaxInvoiceModel::where('sesi_id', $id)->first();
        $sim = SaleSaletaxInvoiceModel::where('ssi_service_invoice_id', $id)->first();
        $accnts = AccountRegisterationModel::where('account_uid', $seim->sesi_party_code)->first();
        $sales = DB::table('financials_sale_saletax_invoice_items')
            ->where('ssii_invoice_id', $seim->sesi_sale_invoice_id)
            ->orderby('ssii_product_name', 'ASC')
//            ->select('sii_product_name as name', 'sii_remarks as remarks', 'sii_qty as qty', 'sii_rate as rate', 'sii_discount as discount', 'sii_saletax as sale_tax', 'sii_amount as amount')
            ->select('ssii_product_name as name', 'ssii_remarks as remarks', 'ssii_qty as qty', 'ssii_rate as rate', 'ssii_discount_per as discount', 'ssii_after_dis_rate as after_discount', 'ssii_saletax_per as sale_tax', 'ssii_saletax_amount as sale_tax_amount', 'ssii_saletax_inclusive as inclu_exclu', 'ssii_amount as amount');

        $siims = DB::table('financials_service_saletax_invoice_items')
            ->where('sesii_invoice_id', $id)
            ->orderby('sesii_service_name', 'ASC')
//            ->select('sseii_service_name as name', 'sseii_remarks as remarks', 'sseii_qty as qty', 'sseii_rate as rate', 'sseii_discount as discount', 'sseii_saletax as sale_tax', 'sseii_amount as amount')
            ->select('sesii_service_name as name', 'sesii_remarks as remarks', 'sesii_qty as qty', 'sesii_rate as rate', 'sesii_discount_per as discount', 'sesii_after_dis_rate as after_discount', 'sesii_saletax_per as sale_tax', 'sesii_saletax_amount as sale_tax_amount', 'sesii_saletax_inclusive as inclu_exclu', 'sesii_amount as amount')
            ->union($sales)
            ->get();

        $ssi_grand_total = (isset($sim->ssi_grand_total) && !empty($sim->ssi_grand_total)) ? $sim->ssi_grand_total : 0;
        $sesi_grand_total = (isset($seim->sesi_grand_total) && !empty($seim->sesi_grand_total)) ? $seim->sesi_grand_total : 0;
        $mainGrndTtl = +$ssi_grand_total + +$sesi_grand_total;
        $nbrOfWrds = $this->myCnvrtNbr($mainGrndTtl);
        $invoice_nbr = $seim->sesi_id;
        $invoice_date = $seim->sesi_day_end_date;
        $type = 'pdf';
        $pge_title = 'Services Sale Tax Invoice';


        $footer = view('invoice_view._partials.pdf_footer')->render();
        $header = view('invoice_view._partials.pdf_header', compact( 'invoice_nbr', 'invoice_date', 'pge_title', 'type'))->render();
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
        $pdf = PDF::loadView('invoice_view.service_sale_tax_invoice.service_sale_tax_invoice_list_modal', compact('siims', 'sim', 'seim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title'));
        // $pdf->setOptions($options);

        return $pdf->stream('Services-Invoice.pdf');
    }


}
