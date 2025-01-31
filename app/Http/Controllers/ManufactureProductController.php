<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\JournalVoucherItemsModel;
use App\Models\JournalVoucherModel;
use App\Models\ProductManufactureExpenseModel;
use App\Models\ProductManufactureItemsModel;
use App\Models\ProductManufactureModel;
use App\Models\ProductModel;
use App\Models\ProductRecipeModel;
use App\Models\PurchaseInvoiceItemsModel;
use App\Models\TransactionModel;
use Auth;
use PDF;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ManufactureProductController extends Controller
{
    protected $total_amount = 0;
    protected $new_value_array = [];

    public function manufacture_product()
    {
        $products = $this->get_all_products();

        $parent_products = $this->get_products_by_type(config('global_variables.parent_product_type'));

//        $expense_accounts = AccountRegisterationModel::where('account_parent_code', 'like', config('global_variables.expense') . '%')->orderBy('account_uid', 'ASC')->get();
        $expense_accounts = $this->get_fourth_level_account(config('global_variables.expense'), 2, 0);

        $expense_account_code = '';
        $expense_account_name = '';


        $account_code = '';
        $account_name = '';

        $pro_code = '';
        $pro_name = '';

        $manufacture_pro_code = '';
        $manufacture_pro_name = '';

        foreach ($products as $product) {
            $pro_code .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' data-sale_price='$product->pro_purchase_price'> $product->pro_code</option>";
            $pro_name .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' data-sale_price='$product->pro_purchase_price'>$product->pro_title</option>";
        }

        foreach ($parent_products as $parent_product) {

            $manufacture_pro_code .= "<option value='$parent_product->pro_code'> $parent_product->pro_code</option>";
            $manufacture_pro_name .= "<option value='$parent_product->pro_code'>$parent_product->pro_title</option>";
        }

        foreach ($expense_accounts as $expense_account) {

            $expense_account_code .= "<option value='$expense_account->account_uid'> $expense_account->account_uid</option>";
            $expense_account_name .= "<option value='$expense_account->account_uid'>$expense_account->account_name</option>";
        }

        $recipe_lists = ProductRecipeModel::where('pr_delete_status', '!=', 1)->where('pr_disabled', '!=', 1)->orderBy('pr_name', 'ASC')->get();

        $heads = explode(',', config('global_variables.payable_receivable'));

//        $accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)->orderBy('account_uid', 'ASC')->get();
        $accounts = $this->get_fourth_level_account($heads, 0, 1);

        foreach ($accounts as $account) {

            $account_code .= "<option value='$account->account_uid'> $account->account_uid</option>";
            $account_name .= "<option value='$account->account_uid'>$account->account_name</option>";
        }

        return view('manufacture_product', compact('pro_code', 'pro_name', 'manufacture_pro_code', 'manufacture_pro_name', 'recipe_lists', 'expense_account_code', 'expense_account_name', 'account_code', 'account_name'));
    }

    public function submit_manufacture_product(Request $request)
    {
        $this->validation($request);

        $rollBack = false;
        DB::beginTransaction();

        $notes = 'PRODUCT_MANUFACTURE';
        $voucher_code = config('global_variables.PRODUCT_MANUFACTURE_VOUCHER_CODE');
        $transaction_type = config('global_variables.PRODUCT_MANUFACTURE');

        $user_id = Auth::user()->user_id;
        $browser = $this->getBrwsrInfo();
        $ip = $this->getIp();
        $current_date_time = Carbon::now()->toDateTimeString();
        $item_values = json_decode($request->salesval, true);

        array_walk($item_values, function (&$a) {
            $a['product_bonus_qty'] = 0;
            $a['warehouse'] = 1;
        });


        //////////////////////////// Product Manufacture Insertion ////////////////////////////////////

        $manufacture_product = new ProductManufactureModel();

        $manufacture_product = $this->AssignValues($request, $manufacture_product, $user_id, $ip, $browser, $current_date_time);

        if ($manufacture_product->save()) {
            $manufacture_product_id = $manufacture_product->pm_id;
            $account_code = $manufacture_product->pm_account_code;
            $account_name = $manufacture_product->pm_account_name;
        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }


        //////////////////////////// Product Manufacture Items Insertion ////////////////////////////////////

        $product_items = [];

        $product_item = $this->AssignItemsValues($item_values, $product_items, $manufacture_product_id);

        if (!DB::table('financials_product_manufacture_items')->insert($product_item)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Product Manufacture Amount and Grand Total Insertion ////////////////////////////////////

        $manufacture_product->pm_total_pro_amount = $this->total_amount;
        $manufacture_product->pm_grand_total = $this->total_amount + $request->total_account_amount;

        if (!$manufacture_product->save()) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }


        $new_array = $this->new_value_array;

        //////////////////////////// Expense Insertion ////////////////////////////////////

        $expense_items = [];

        $expense_item = $this->AssignExpenseValues($request, $expense_items, $manufacture_product_id);
        if (!DB::table('financials_product_manufacture_expense')->insert($expense_item)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

//        dd($new_array);


        //////////////////////////// Product Inventory Insertion ////////////////////////////////////

//        $inventory = $this->AssignProductInventoryValues($new_array, 2);
//
//        if (!$inventory) {
//            $rollBack = true;
//            DB::rollBack();
//            return redirect()->back()->with('fail', 'Failed Try Again');
//        }


        //////////////////////////// Product Warehouse Insertion ////////////////////////////////////

        $warehouses = [];
        $warehouse = $this->AssignWarehouseStocksValues($warehouses, $new_array, 2);

        $warehouse = DB::table('financials_warehouse_stock')->insert($warehouse);

        if (!$warehouse) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Stock Movement Insertion ////////////////////////////////////

        $stock_movement = $this->stock_movement_module($new_array, $voucher_code . $manufacture_product_id, 2, 'MANUFACTURING');

        if (!$stock_movement) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }


        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {

            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Manufacture Product With Id: ' . $manufacture_product->pm_id);

            DB::commit();
            return redirect()->back()->with('success', 'Successfully Saved');
        }
    }

    public function validation($request)
    {
        return $this->validate($request, [
            'recipe' => ['nullable', 'numeric'],
            'manufacture_account_code' => ['required', 'string'],
            'manufacture_account_name_text' => ['required', 'string'],
            'manufacture_product_code' => ['required', 'string'],
            'manufacture_product_name_text' => ['required', 'string'],
            'manufacture_qty' => ['required', 'numeric', 'min:1'],
            'complete_date' => ['nullable', 'date'],
            'remarks' => ['nullable', 'string'],
            'total_items' => ['required', 'numeric'],
            'total_price' => ['required', 'numeric'],
            'total_accounts' => ['nullable', 'numeric'],
            'total_account_amount' => ['nullable', 'numeric'],
            'grand_total' => ['required', 'numeric'],
            'salesval' => ['required', 'string'],
            'account_values' => ['nullable', 'string'],
        ]);
    }

    public function AssignValues($request, $manufacture_product, $user_id, $ip, $browser, $current_date_time)
    {
        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $manufacture_product->pm_account_code = $request->manufacture_account_code;
        $manufacture_product->pm_account_name = $request->manufacture_account_name_text;
        $manufacture_product->pm_pro_code = $request->manufacture_product_code;
        $manufacture_product->pm_pro_name = $request->manufacture_product_name_text;
        $manufacture_product->pm_qty = $request->manufacture_qty;
        $manufacture_product->pm_remarks = ucfirst($request->remarks);
        $manufacture_product->pm_total_items = $request->total_items;
        $manufacture_product->pm_total_pro_amount = $request->total_price;
        $manufacture_product->pm_total_expense_accounts = $request->total_accounts;
        $manufacture_product->pm_total_expense_amount = $request->total_account_amount;
        $manufacture_product->pm_grand_total = $request->grand_total;
        $manufacture_product->pm_status = 'PROCESSING';
        $manufacture_product->pm_datetime = $current_date_time;
        $manufacture_product->pm_complete_datetime = date('Y-m-d', strtotime($request->complete_date));
        $manufacture_product->pm_day_end_id = $day_end->de_id;
        $manufacture_product->pm_day_end_date = $day_end->de_datetime;
        $manufacture_product->pm_createdby = $user_id;
        $manufacture_product->pm_brwsr_info = $browser;
        $manufacture_product->pm_ip_adrs = $ip;
        $manufacture_product->pm_update_datetime = $current_date_time;

        return $manufacture_product;
    }

    public function AssignItemsValues($item_values, $data, $manufacture_product_id)
    {
        foreach ($item_values as $value) {

            $product_stock = $this->product_stock_movement_last_row($value['product_code']);

            if (isset($product_stock)) {
                $rate = $product_stock->sm_bal_rate;

                $amount = $rate * $value['product_qty'];
            } else {

                $purchase_rate = $this->get_product_purchase_rate($value['product_code']);

                $amount = $purchase_rate * $value['product_qty'];
            }


//            $amount = $value['product_qty'] * $product_stock->sm_bal_rate;

            $value['product_inclusive_rate'] = $rate;
            $value['product_bonus_qty'] = 0;
            $value['product_amount'] = $amount;

            $this->new_value_array[] = $value;

            $this->total_amount += $amount;

            $data[] = [
                'pmi_product_manufacture_id' => $manufacture_product_id,
                'pmi_product_code' => $value['product_code'],
                'pmi_product_name' => ucwords($value['product_name']),
                'pmi_qty' => $value['product_qty'],
                'pmi_rate' => $rate,
                'pmi_amount' => $amount
            ];
        }

        return $data;
    }

    public function AssignExpenseValues($request, $data, $manufacture_product_id)
    {
        $account_values = json_decode($request->account_values, true);

        if (isset($account_values) && !empty($account_values)) {
            foreach ($account_values as $value) {

                $data[] = ['pme_product_manufacture_id' => $manufacture_product_id, 'pme_account_code' => $value[0], 'pme_account_name' => ucwords($value[1]), 'pme_amount' => $value[2]];
            }
        }

        return $data;
    }

    public function manufacture_product_search_result($status, $search, $search_by_user, $search_to, $search_from, $search_product, $pagi_number,$search_account)
    {
        $pagination_number = $pagi_number;

        $start = date('Y-m-d', strtotime($search_to));
        $end = date('Y-m-d', strtotime($search_from));


        $query = DB::table('financials_product_manufacture')
            ->leftJoin('financials_users', 'financials_users.user_id', 'financials_product_manufacture.pm_createdby');

        if (isset($search) && !empty($search)) {
            $query->where('pm_id', 'like', '%' . $search . '%')
                ->orWhere('pm_account_code', 'like', '%' . $search . '%')
                ->orWhere('pm_account_name', 'like', '%' . $search . '%')
                ->orWhere('pm_pro_code', 'like', '%' . $search . '%')
                ->orWhere('pm_pro_name', 'like', '%' . $search . '%')
                ->orWhere('pm_qty', 'like', '%' . $search . '%')
                ->orWhere('pm_remarks', 'like', '%' . $search . '%')
                ->orWhere('user_designation', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_product)) {
            $query->where('pm_pro_code', $search_product);
        }

        if ((!empty($search_to)) && (!empty($search_from))) {
            $query->whereDate('pm_datetime', '>=', $start)
                ->whereDate('pm_datetime', '<=', $end);
        } elseif (!empty($search_to)) {
            $query->where('pm_datetime', $start);
        } elseif (!empty($search_from)) {
            $query->where('pm_datetime', $end);
        }

        if (isset($search_by_user) && !empty($search_by_user)) {
            $query->where('pm_createdby', $search_by_user);
        }

        if (isset($search_account) && !empty($search_account)) {
            $query->where('pm_account_code', $search_account);
        }

        $manufacture_products = $query->where('pm_status', $status)->orderBy('pm_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

        return $manufacture_products;
    }


    // update code by shahzaib start
    public function manufacture_product_list(Request $request, $array = null, $str = null)
    {
        $heads = explode(',', config('global_variables.payable_receivable'));
        $accounts = $this->get_fourth_level_account($heads, 0, 1);

        $products = ProductModel::orderBy('pro_id', 'ASC')->get();

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_product = (!isset($request->product_code) && empty($request->product_code)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->product_code;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $search_account = (isset($request->account) && !empty($request->account)) ? $request->account : '';
        $search_by_status = 'PROCESSING';
        $route = 'manufacture_product_list';
        $balance = $route;
        $prnt_page_dir = 'print.manufacture_product_list.manufacture_product_list';
        $pge_title = 'Manufacture Product List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from, $search_product);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $pro_code = '';
        $pro_name = '';

        foreach ($products as $product) {
            $selected = $product->pro_code == $search_product ? 'selected' : '';
            $pro_code .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' $selected>$product->pro_code</option>";
            $pro_name .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' $selected>$product->pro_title</option>";
        }


        $datas = $this->manufacture_product_search_result($search_by_status, $search, $search_by_user, $search_to, $search_from, $search_product, $pagination_number,$search_account);


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];

            $pdf = PDF::loadView($prnt_page_dir, compact('datas', 'type', 'pge_title', 'balance'));
            $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title, $route), $pge_title . '_x.xlsx');
            }

        } else {
            return view('manufacture_product_list', compact('datas', 'search', 'search_by_user', 'search_to', 'search_from', 'search_product', 'route', 'pro_code', 'pro_name', 'pge_title', 'search_by_status','accounts','search_account'));
        }

    }
    // update code by shahzaib end


    // update code by shahzaib start
    public function complete_manufacture_product_list(Request $request, $array = null, $str = null)
    {
        $heads = explode(',', config('global_variables.payable_receivable'));
        $accounts = $this->get_fourth_level_account($heads, 0, 1);

        $products = ProductModel::orderBy('pro_id', 'ASC')->get();

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_product = (!isset($request->product_code) && empty($request->product_code)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->product_code;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $search_account = (isset($request->account) && !empty($request->account)) ? $request->account : '';
        $search_by_status = 'COMPLETED';
        $route = 'complete_manufacture_product_list';
        $balance = $route;
        $prnt_page_dir = 'print.manufacture_product_list.manufacture_product_list';
        $pge_title = 'Complete Manufacture Product List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from, $search_product);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $pro_code = '';
        $pro_name = '';

        foreach ($products as $product) {
            $selected = $product->pro_code == $search_product ? 'selected' : '';
            $pro_code .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' $selected>$product->pro_code</option>";
            $pro_name .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' $selected>$product->pro_title</option>";
        }


        $datas = $this->manufacture_product_search_result($search_by_status, $search, $search_by_user, $search_to, $search_from, $search_product, $pagination_number,$search_account);


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];

            $pdf = PDF::loadView($prnt_page_dir, compact('datas', 'type', 'pge_title', 'balance'));
            $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title, $route), $pge_title . '_x.xlsx');
            }

        } else {
            return view('manufacture_product_list', compact('datas', 'search', 'search_by_user', 'search_to', 'search_from', 'search_product', 'route', 'pro_code', 'pro_name', 'pge_title', 'search_by_status','accounts','search_account'));
        }

    }
    // update code by shahzaib end


    // update code by shahzaib start
    public function reject_manufacture_product_list(Request $request, $array = null, $str = null)
    {
        $heads = explode(',', config('global_variables.payable_receivable'));
        $accounts = $this->get_fourth_level_account($heads, 0, 1);

        $products = ProductModel::orderBy('pro_id', 'ASC')->get();

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_product = (!isset($request->product_code) && empty($request->product_code)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->product_code;
        $search_to = (!isset($request->to) && empty($request->to)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->to;
        $search_from = (!isset($request->from) && empty($request->from)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->from;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $search_account = (isset($request->account) && !empty($request->account)) ? $request->account : '';
        $search_by_status = 'REJECTED';
        $route = 'reject_manufacture_product_list';
        $balance = $route;
        $prnt_page_dir = 'print.manufacture_product_list.manufacture_product_list';
        $pge_title = 'Reject Manufacture Product List';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_to, $search_from, $search_product);

        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $pro_code = '';
        $pro_name = '';

        foreach ($products as $product) {
            $selected = $product->pro_code == $search_product ? 'selected' : '';
            $pro_code .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' $selected>$product->pro_code</option>";
            $pro_name .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' $selected>$product->pro_title</option>";
        }


        $datas = $this->manufacture_product_search_result($search_by_status, $search, $search_by_user, $search_to, $search_from, $search_product, $pagination_number,$search_account);


        if (isset($request->array) && !empty($request->array)) {

            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];

            $pdf = PDF::loadView($prnt_page_dir, compact('datas', 'type', 'pge_title', 'balance'));
            $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title, $route), $pge_title . '_x.xlsx');
            }

        } else {
            return view('manufacture_product_list', compact('datas', 'search', 'search_by_user', 'search_to', 'search_from', 'search_product', 'route', 'pro_code', 'pro_name', 'pge_title', 'search_by_status','accounts','search_account'));
        }


    }

    // update code by shahzaib end


    public function edit_manufacture_product(Request $request)
    {
        $expense_accounts = AccountRegisterationModel::where('account_delete_status', '!=', 1)->where('account_disabled', '!=', 1)->where('account_parent_code', 'like', config('global_variables.expense') . '%')->orderBy('account_uid', 'ASC')->get();

        $manufacture_product = ProductManufactureModel::where('pm_id', $request->manufacture_id)->first();

        $expense_account_code = '';
        $expense_account_name = '';

        foreach ($expense_accounts as $expense_account) {

            $expense_account_code .= "<option value='$expense_account->account_uid'>$expense_account->account_uid</option>";
            $expense_account_name .= "<option value='$expense_account->account_uid'>$expense_account->account_name</option>";
        }

        $recipe_lists = ProductRecipeModel::where('pr_delete_status', '!=', 1)->where('pr_disabled', '!=', 1)->orderBy('pr_name', 'ASC')->get();

        return view('edit_manufacture_product', compact('recipe_lists', 'expense_account_code', 'expense_account_name', 'manufacture_product'));
    }

    public function update_manufacture_product(Request $request)
    {
        $this->validate($request, [
            'complete_date' => ['nullable', 'date'],
            'remarks' => ['nullable', 'string'],
            'total_accounts' => ['nullable', 'numeric'],
            'total_account_amount' => ['nullable', 'numeric'],
            'grand_total' => ['required', 'numeric'],
            'account_values' => ['nullable', 'string'],
            'manufacture_id' => ['required', 'numeric', 'min:1'],
        ]);

        $rollBack = false;
        DB::beginTransaction();

        $manufacture_product = ProductManufactureModel::where('pm_id', $request->manufacture_id)->first();

        $user_id = Auth::user()->user_id;
        $browser = $this->getBrwsrInfo();
        $ip = $this->getIp();
        $current_date_time = Carbon::now()->toDateTimeString();

        $manufacture_product->pm_remarks = ucfirst($request->remarks);
        $manufacture_product->pm_complete_datetime = date('Y-m-d', strtotime($request->complete_date));
        $manufacture_product->pm_total_expense_accounts = $request->total_accounts;
        $manufacture_product->pm_total_expense_amount = $request->total_account_amount;
        $manufacture_product->pm_grand_total = $manufacture_product->pm_total_pro_amount + $request->total_account_amount;
        $manufacture_product->pm_createdby = $user_id;
        $manufacture_product->pm_brwsr_info = $browser;
        $manufacture_product->pm_ip_adrs = $ip;
        $manufacture_product->pm_update_datetime = $current_date_time;

        if ($manufacture_product->save()) {
            $manufacture_product_id = $manufacture_product->pm_id;

            $exist_expense = ProductManufactureExpenseModel::where('pme_product_manufacture_id', $manufacture_product_id)->exists();

            if ($exist_expense) {

                $delete = ProductManufactureExpenseModel::where('pme_product_manufacture_id', $manufacture_product_id)->delete();

                if (!$delete) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }
            }

            $items = [];
            $item = $this->AssignExpenseValues($request, $items, $manufacture_product_id);

            if (!DB::table('financials_product_manufacture_expense')->insert($item)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }


        } else {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {
            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Manufacture Product With Id: ' . $manufacture_product->pm_id);

            DB::commit();
            return redirect()->back()->with('success', 'Successfully Saved');
        }

    }

    public function complete_manufacture_product(Request $request)
    {
        $this->validate($request, [
            'complete_manufacture_id' => ['required', 'numeric', 'min:1'],
        ]);

        $rollBack = false;
        DB::beginTransaction();

        $notes = 'PRODUCT_MANUFACTURE_COMPLETED';
        $voucher_code = config('global_variables.PRODUCT_MANUFACTURE_VOUCHER_CODE');
        $transaction_type = config('global_variables.PRODUCT_MANUFACTURE');


        //////////////////////////// Product Manufacture Update ////////////////////////////////////

        $manufacture_product = ProductManufactureModel::where('pm_id', $request->complete_manufacture_id)->first();

        $item_values[] = [
            'product_code' => $manufacture_product->pm_pro_code,
            'product_name' => $manufacture_product->pm_pro_name,
            'product_qty' => $manufacture_product->pm_qty,
            'product_bonus_qty' => 0,
            'product_inclusive_rate' => $manufacture_product->pm_grand_total,
            'warehouse' => 1,
            'product_remarks' => $manufacture_product->pm_remarks,
        ];

        $account_values[] = [
            'account_code' => $manufacture_product->pm_account_code,
            'account_name' => $manufacture_product->pm_account_name,
            'amount' => $manufacture_product->pm_total_expense_amount,
            'type' => 'Cr'
        ];


        $user_id = Auth::user()->user_id;
        $browser = $this->getBrwsrInfo();
        $ip = $this->getIp();
        $current_date_time = Carbon::now()->toDateTimeString();
        $detail_remarks = '';

        $transaction_accounts = ProductManufactureExpenseModel::where('pme_product_manufacture_id', $request->complete_manufacture_id)->get();

        if ($transaction_accounts->count() > 0) {
            foreach ($transaction_accounts as $transaction_account) {
                $account_values[] = ['account_code' => $transaction_account->pme_account_code, 'account_name' => $transaction_account->pme_account_name, 'amount' => $transaction_account->pme_amount, 'type' => 'Dr'];
            }
        } else {
            $account_values = [];
        }

        $manufacture_product->pm_createdby = $user_id;
        $manufacture_product->pm_brwsr_info = $browser;
        $manufacture_product->pm_ip_adrs = $ip;
        $manufacture_product->pm_update_datetime = $current_date_time;
        $manufacture_product->pm_status = 'COMPLETED';

        if ($manufacture_product->save()) {
            $manufacture_product_id = $manufacture_product->pm_id;
        } else {
            DB::rollBack();
            $rollBack = true;
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Product Inventory Insertion ////////////////////////////////////

//        $inventory = $this->AssignProductInventoryValues($item_values, 1);
//
//        if (!$inventory) {
//            DB::rollBack();
//            $rollBack = true;
//            return redirect()->back()->with('fail', 'Failed Try Again');
//        }


        //////////////////////////// Product Warehouse Insertion ////////////////////////////////////

        $warehouses = [];
        $warehouse = $this->AssignWarehouseStocksValues($warehouses, $item_values, 1);

        if (!DB::table('financials_warehouse_stock')->insert($warehouse)) {
            DB::rollBack();
            $rollBack = true;
            return redirect()->back()->with('fail', 'Failed Try Again');
        }


        //////////////////////////// Stock Movement Insertion ////////////////////////////////////

        $stock_movement = $this->stock_movement_module($item_values, $voucher_code . $manufacture_product_id, 1, 'COMPLETE');

        if (!$stock_movement) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }


        if (isset($account_values) && !empty($account_values)) {

            foreach ($account_values as $account_value) {
                $detail_remarks .= $account_value['account_code'] . ' ' . $account_value['account_name'] . ', ' . $account_value['type'] . '@' . $account_value['amount'] . PHP_EOL;
            }

            foreach ($account_values as $account_value) {

                $transaction = new TransactionModel();

                $dr_account = 0;
                $cr_account = 0;

                if ($account_value['type'] == 'Dr') {
                    $dr_account = $account_value['account_code'];
                } else {
                    $cr_account = $account_value['account_code'];
                }

                $transaction = $this->AssignTransactionsValues($transaction, $dr_account, $account_value['amount'], $cr_account, $notes, $transaction_type, $manufacture_product_id);

                if ($transaction->save()) {

                    $transaction_id = $transaction->trans_id;

                    $balance = new BalancesModel();

                    $balance = $this->AssignAccountBalancesValues($balance, $transaction_id, $account_value['account_code'], $account_value['amount'], $account_value['type'],
                        $manufacture_product->pm_remarks, $notes, $detail_remarks, $voucher_code . $manufacture_product_id);

                    if (!$balance->save()) {
                        DB::rollBack();
                        $rollBack = true;
                    }
                } else {
                    DB::rollBack();
                    $rollBack = true;
                }
            }
        }


        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {

            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Complete Manufacture Product With Id: ' . $manufacture_product->pm_id);

            DB::commit();
            return redirect()->back()->with('success', 'Successfully Completed');
        }
    }

    public function reject_manufacture_product(Request $request)
    {
        $this->validate($request, [
            'reject_manufacture_id' => ['required', 'numeric', 'min:1'],
        ]);

        $notes = 'PRODUCT_MANUFACTURE_REJECTED';
        $voucher_code = config('global_variables.PRODUCT_MANUFACTURE_VOUCHER_CODE');
        $transaction_type = config('global_variables.PRODUCT_MANUFACTURE');

        $rollBack = false;
        DB::beginTransaction();


        //////////////////////////// Product Manufacture Update ////////////////////////////////////

        $manufacture_product = ProductManufactureModel::where('pm_id', $request->reject_manufacture_id)->first();

        $user_id = Auth::user()->user_id;
        $browser = $this->getBrwsrInfo();
        $ip = $this->getIp();
        $current_date_time = Carbon::now()->toDateTimeString();
        $item_values = [];

        $manufacture_product_items = ProductManufactureItemsModel::where('pmi_product_manufacture_id', $request->reject_manufacture_id)->get();

        foreach ($manufacture_product_items as $manufacture_product_item) {

            $item_values[] = [
                'product_code' => $manufacture_product_item->pmi_product_code,
                'product_name' => $manufacture_product_item->pmi_product_name,
                'product_qty' => $manufacture_product_item->pmi_qty,
                'product_bonus_qty' => 0,
                'product_inclusive_rate' => $manufacture_product_item->pmi_rate,
                'warehouse' => 1,
                'product_remarks' => '',
            ];
        }

        $manufacture_product->pm_createdby = $user_id;
        $manufacture_product->pm_brwsr_info = $browser;
        $manufacture_product->pm_ip_adrs = $ip;
        $manufacture_product->pm_update_datetime = $current_date_time;
        $manufacture_product->pm_reject_reason = $request->reason;
        $manufacture_product->pm_status = 'REJECTED';

        if ($manufacture_product->save()) {
            $manufacture_product_id = $manufacture_product->pm_id;

        } else {
            DB::rollBack();
            $rollBack = true;
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Product Inventory Insertion ////////////////////////////////////

//        $inventory = $this->AssignProductInventoryValues($item_values, 1);
//
//        if ($inventory) {
//        } else {
//            DB::rollBack();
//            $rollBack = true;
//            return redirect()->back()->with('fail', 'Failed Try Again');
//        }

        //////////////////////////// Product Warehouse Insertion ////////////////////////////////////

        $warehouses = [];
        $warehouse = $this->AssignWarehouseStocksValues($warehouses, $item_values, 1);

        if (!DB::table('financials_warehouse_stock')->insert($warehouse)) {
            DB::rollBack();
            $rollBack = true;
            return redirect()->back()->with('fail', 'Failed Try Again');
        }


        //////////////////////////// Stock Movement Insertion ////////////////////////////////////

        $stock_movement = $this->stock_movement_module($item_values, $voucher_code . $manufacture_product_id, 1, 'REJECT');

        if (!$stock_movement) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {

            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Reject Manufacture Product With Id: ' . $manufacture_product->pm_id);

            DB::commit();
            return redirect()->back()->with('success', 'Successfully Rejected');
        }
    }

    public function get_manufacture_product_details(Request $request)
    {
        $data = [];
        $items = ProductManufactureItemsModel::where('pmi_product_manufacture_id', $request->id)->get();
        $expense_items = ProductManufactureExpenseModel::where('pme_product_manufacture_id', $request->id)->get();

        $data[] = [$items];
        $data[] = [$expense_items];
        return response()->json($data);
    }


    public function get_manufacture_product_details_SH(Request $request, $id)
    {

        $pim = ProductManufactureModel::where('pm_id', $id)->first();
        $accnts = AccountRegisterationModel::where('account_uid', $pim->pm_account_code)->first();
        $piim_expense = ProductManufactureExpenseModel::where('pme_product_manufacture_id', $id)
            ->select(DB::raw('pme_account_code as code, pme_account_name as name, "expense_qty" as qty, "expense_rate" as rate, pme_amount as amount, "expense" as type'))
            ->orderby('pme_account_name', 'ASC');

        $piims = ProductManufactureItemsModel::where('pmi_product_manufacture_id', $id)
            ->select(DB::raw('pmi_product_code as code, pmi_product_name as name, pmi_qty as qty, pmi_rate as rate, pmi_amount as amount, "items" as type'))
            ->orderby('pmi_product_name', 'ASC')
            ->union($piim_expense)
            ->get();
        $nbrOfWrds = $this->myCnvrtNbr($pim->pm_grand_total);
        $invoice_nbr = $pim->pm_id;
        $invoice_date = $pim->pm_datetime;
        $type = 'grid';
        $pge_title = 'Manufacture Product Invoice';

        return view('invoice_view.product_manufacture.product_manufacture_list_modal', compact('piims', 'pim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title'));


    }

    public function get_manufacture_product_details_pdf_SH(Request $request, $id)
    {

        $pim = ProductManufactureModel::where('pm_id', $id)->first();
        $accnts = AccountRegisterationModel::where('account_uid', $pim->pm_account_code)->first();
        $piim_expense = ProductManufactureExpenseModel::where('pme_product_manufacture_id', $id)
            ->select(DB::raw('pme_account_code as code, pme_account_name as name, "expense_qty" as qty, "expense_rate" as rate, pme_amount as amount, "expense" as type'))
            ->orderby('pme_account_name', 'ASC');

        $piims = ProductManufactureItemsModel::where('pmi_product_manufacture_id', $id)
            ->select(DB::raw('pmi_product_code as code, pmi_product_name as name, pmi_qty as qty, pmi_rate as rate, pmi_amount as amount, "items" as type'))
            ->orderby('pmi_product_name', 'ASC')
            ->union($piim_expense)
            ->get();
        $nbrOfWrds = $this->myCnvrtNbr($pim->pm_grand_total);
        $invoice_nbr = $pim->pm_id;
        $invoice_date = $pim->pm_datetime;
        $type = 'grid';
        $pge_title = 'Manufacture Product Invoice';


        $footer = view('voucher_view._partials.pdf_footer')->render();
        $header = view('voucher_view._partials.pdf_header', compact('invoice_nbr', 'invoice_date', 'pge_title', 'type', 'invoice_remarks'))->render();
        $options = [
            'footer-html' => $footer,
            'header-html' => $header,
            'margin-top' => 30,
        ];

        $pdf = PDF::loadView('invoice_view.product_manufacture.product_manufacture_list_modal', compact('piims', 'pim', 'accnts', 'nbrOfWrds', 'invoice_nbr', 'invoice_date', 'type', 'pge_title'));
        $pdf->setOptions($options);


        return $pdf->stream('Manufacture-Product-Detail.pdf');

    }


}
