<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Models\BalancesModel;
use App\Models\CashReceiptVoucherItemsModel;
use App\Models\CashReceiptVoucherModel;
use App\Models\ProductionModel;
use App\Models\ProductRecipeModel;
use App\Models\SaleInvoiceModel;
use App\Models\SaleSaletaxInvoiceModel;
use App\Models\ServiceSaleTaxInvoiceModel;
use App\Models\ServicesInvoiceModel;
use App\Models\SystemConfigModel;
use App\Models\TransactionModel;
use PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductionController extends Controller
{

    public $actual_stock_price = 0;
    public $product_total_rate = 0;


    public function index(Request $request)
    {

        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_by_user = (isset($request->search_by_user) && !empty($request->search_by_user)) ? $request->search_by_user : '';
        $prnt_page_dir = 'print.production_list.production_list';
        $pge_title = 'Production List';
        $srch_fltr = [];
        array_push($srch_fltr, $search);

        $pagination_number = (empty($ar)) ? 30 : 100000000;



        $query = DB::table('financials_production as pr')
            ->leftJoin('financials_product_recipe_items as pri', 'pr.pr_id', 'pri.pri_product_recipe_id')
            ->leftJoin('financials_users', 'financials_users.user_id', 'pr.pr_createdby');

        if (!empty($search)) {
            $query->where('pr.pr_id', 'like', '%' . $search . '%')
                ->orWhere('pr.pr_name', 'like', '%' . $search . '%')
                ->orWhere('pr.pr_remarks', 'like', '%' . $search . '%')
                ->orWhere('pri.pri_product_code', 'like', '%' . $search . '%')
                ->orWhere('pri.pri_product_name', 'like', '%' . $search . '%')
                ->orWhere('pri.pri_uom', 'like', '%' . $search . '%')
                ->orWhere('pri.pri_status', 'like', '%' . $search . '%')
                ->orWhere('financials_users.user_designation', 'like', '%' . $search . '%')
                ->orWhere('financials_users.user_name', 'like', '%' . $search . '%')
                ->orWhere('financials_users.user_username', 'like', '%' . $search . '%');
        }

        if (!empty($search_product)) {
            $query->where('pri.pri_product_code', $search_product);
        }

        if (!empty($search_by_user)) {
            $query->where('pr.pr_createdby', $search_by_user);
        }

        $restore_list = $request->restore_list;
        if ($restore_list == 1)
        {
            $query->where('pr.pr_delete_status', '=', 1);
        } else {
            $query->where('pr.pr_delete_status', '!=', 1);
        }



        $datas = $query->where('pri.pri_status', 'Primary-Finish-Goods')
            ->select("pr.pr_id", "pr.pr_name", "pr.pr_remarks", "pr.pr_brwsr_info", "pr.pr_ip_adrs", "pr.pr_delete_status", "pr.pr_disabled", "pri.pri_product_name", "pri.pri_qty", "financials_users.user_id", "financials_users.user_name" )
            ->orderBy('pr.pr_id', config('global_variables.query_sorting'))
            ->paginate($pagination_number);

        $product_recipe_name = ProductRecipeModel::
        where('pr_delete_status', '!=', 1)->
        orderBy('pr_name', 'ASC')->pluck('pr_name')->all();


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
            return view('product_recipe_list', compact('datas', 'search', 'product_recipe_name', 'search_by_user', 'pro_code', 'pro_name','restore_list'));
        }

    }


    public function create()
    {
        $products = self::GET_ALL_PRODUCTS();

        $pro_code = '';
        $pro_name = '';

        $manufacture_pro_code = '';
        $manufacture_pro_name = '';

        foreach ($products as $key=>$product) {
            $pro_title = $this->RemoveSpecialChar($product->proTitle);

            $pro_code .= "<option value='$product->proCode' data-parent='$product->proCode' data-purchase_price='$product->proPurchasePrice' data-average_price='$product->proAveragePrice' data-uom='$product->unitTitle' data-pack_size='$product->unitScaleSize' data-code='$product->proCode'> $product->proCode</option>";
            $pro_name .= "<option value='$product->unitTitle' data-parent='$product->proCode' data-purchase_price='$product->proPurchasePrice' data-average_price='$product->proAveragePrice' data-uom='$product->unitTitle' data-pack_size='$product->unitScaleSize' data-code='$product->proCode'>$pro_title</option>";
        }

        $expense_accounts = $this->get_fourth_level_account(config('global_variables.expense'), 2, 0);


        return view('production_add', compact('pro_code', 'pro_name', 'manufacture_pro_code', 'manufacture_pro_name', 'expense_accounts'));

    }


    public function store(Request $request)
    {

        $this->production_validation($request);


        $production_item_array = [];
        $production_amount = ( $request->ttlAmountId !== "" && $request->ttlAmountId > 0 ) ? $request->ttlAmountId : 0;
        $rollBack = false;

        $stock_in_hand = config('global_variables.stock_in_hand');
        $stock_consumed_account = config('global_variables.stock_consumed');

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();
        $user = Auth::user();
        DB::beginTransaction();


        $requested_arrays = json_decode($request->cartDataForProductRecipe, true);

        foreach ($requested_arrays as $index => $requested_array) {

            $item_code = $requested_array['code'];
            $item_name = $requested_array['title'];
            $item_remarks = $requested_array['remarks'];
            $item_warehouse = 1;
            $item_unit_measurement = $requested_array['uom'];
            $item_quantity = $requested_array['quantity'];
            $item_pack_size = $requested_array['packSize'];
            $item_rate = $requested_array['rate'];
            $item_amount = $requested_array['amount'];



            $production_item_array[] = [
                'product_code' => $item_code,
                'product_name' => $item_name,
                'product_remarks' => $item_remarks,
                'warehouse' => $item_warehouse,
                'product_qty' => $item_quantity,
                'product_unit_measurement' => $item_unit_measurement,
                'product_rate' => $item_rate,
                'product_amount' => $item_amount,
            ];

        }

        $production_prefix = 'prod';
        $production_items_prefix = 'prodi';

        $production = new ProductionModel();
        $item_table = 'financials_production_items';

        $notes = 'STOCK_CONSUMED';
        $voucher_code = config('global_variables.STOCK_CONSUMED_VOUCHER_CODE');
        $transaction_type = config('global_variables.PRODUCTION');


        //Production
        if (!empty($production_item_array)) {

            //////////////////////////// Production Insertion ////////////////////////////////////

            $production = $this->AssignProductionValues($request, $production, $day_end, $user, $production_prefix);

            if ($production->save()) {

                $prod_id = $production_prefix . '_id';
                $production_invoice_id = $production->$prod_id;

            }
            else {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            //////////////////////////// Production Items Insertion ////////////////////////////////////
            $detail_remarks = '';

            $item = $this->AssignProductionItemsValues($production_invoice_id, $production_item_array, $production_items_prefix );

            foreach ($item as $value) {

                $pro_rate = (float)$value[$production_items_prefix . '_rate'];
                $pro_amount = (float)$value[$production_items_prefix . '_amount'];

                $detail_remarks .= $value[$production_items_prefix . '_product_name'] . ', ' . $value[$production_items_prefix . '_qty'] . '@' . number_format($pro_rate, 2) . ' = ' . number_format($pro_amount, 2) . PHP_EOL;
            }

            if (!DB::table($item_table)->insert($item)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            $stock_amount = $this->actual_stock_price;


            //////////////////////////// Details Remarks of Production Insertion ////////////////////////////////////

            $sale_detail_remarks = $production_prefix . '_detail_remarks';

            $production->$sale_detail_remarks = $detail_remarks;

            if (!$production->save()) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }


            //////////////////////////// Warehouse Stock Insertion ////////////////////////////////////

            $warehouses = [];
            $warehouse = $this->AssignWarehouseStocksValuesForProduction($warehouses, $production_item_array, 2);

            if (!DB::table('financials_warehouse_stock')->insert($warehouse)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

            //////////////////////////// Stock Movement Insertion ////////////////////////////////////

            $stock_movement = $this->stock_movement_module_production($production_item_array, $voucher_code . $production_invoice_id, 'PRODUCTION', 'PRODUCTION');

            if (!$stock_movement) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }


            //////////////////////////// TRANSACTION ONE STOCK IN HAND ////////////////////////////////////


            $transactions1 = new TransactionModel();
            $transaction1 = $this->AssignTransactionsValues($transactions1, 0, $stock_amount, $stock_in_hand, $notes, $transaction_type, $production_invoice_id);

            if ($transaction1->save()) {
                $transaction_id1 = $transaction1->trans_id;

                $balances1 = new BalancesModel();

                $balance1 = $this->AssignAccountBalancesValues($balances1, $transaction_id1, $stock_in_hand, $stock_amount, 'Cr', $request->remarks,
                    $notes, $detail_remarks, $voucher_code . $production_invoice_id);

                if (!$balance1->save()) {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }
            } else {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }




            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create ' . $notes . ' With Id: ' . $production_invoice_id);

        }

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }
        else {

            DB::commit();
            return redirect()->back()->with(['si_id'=>$production_invoice_id, 'success'=>'Successfully Saved']);
        }
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }



    public function production_validation($request)
    {
        return $this->validate($request, [
            'primary_limited_product_code' => ['nullable', 'string'],
            'primary_limited_product_title' => ['nullable', 'string'],
            'primary_limited_product_quantity' => ['nullable', 'string'],
            'pro_uom_primary' => ['nullable', 'string'],
            'pack_size_primary' => ['nullable', 'string'],
            'pro_rate_primary' => ['nullable', 'string'],
            'amount_primary' => ['nullable', 'string'],
            'ttlAmountId' => ['required', 'numeric'],
            'cartDataForProductRecipe' => ['required', 'string'],
            'cartDataForFinishedGoods' => ['required', 'string'],
        ]);
    }


    public function AssignProductionValues( $request, $production, $day_end, $user, $prfx )
    {

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();


        $col_datetime = $prfx . '_datetime';
        $col_day_end_id = $prfx . '_day_end_id';
        $col_day_end_date = $prfx . '_day_end_date';
        $col_createdby = $prfx . '_createdby';
        $col_ip_adrs = $prfx . '_ip_adrs';
        $col_brwsr_info = $prfx . '_brwsr_info';
        $col_update_datetime = $prfx . '_update_datetime';


        $production->$col_datetime = Carbon::now()->toDateTimeString();
        $production->$col_day_end_id = $day_end->de_id;
        $production->$col_day_end_date = $day_end->de_datetime;
        $production->$col_createdby = $user->user_id;
        $production->$col_brwsr_info = $brwsr_rslt;
        $production->$col_ip_adrs = $ip_rslt;
        $production->$col_update_datetime = Carbon::now()->toDateTimeString();


        return $production;

    }


    public function AssignProductionItemsValues($invoice_id, $array, $prfx )
    {

        $data = [];

        foreach ($array as $value) {

            $average_rate = $this->product_stock_movement_last_row($value['product_code']);

            if (isset($average_rate)) {
                $this->actual_stock_price += $average_rate->sm_bal_rate * $value['product_qty'];
            }
            else {

                $purchase_rate = $this->get_product_purchase_rate($value['product_code']);

                $this->actual_stock_price += $purchase_rate * $value['product_qty'];
            }


            $this->product_total_rate += $value['product_qty'] * $value['product_rate'];

            $sale_invoice = $prfx . '_prod_id';
            $product_code = $prfx . '_product_code';
            $product_name = $prfx . '_product_name';
            $remarks = $prfx . '_remarks';
            $qty = $prfx . '_qty';
            $uom = $prfx . '_uom';
            $rate = $prfx . '_rate';
            $amount = $prfx . '_amount';
            $status = $prfx . '_status';


            $data[] = [
                $sale_invoice => $invoice_id,
                $product_code => $value['product_code'],
                $product_name => ucwords($value['product_name']),
                $remarks => ucfirst($value['product_remarks']),
                $qty => $value['product_qty'],
                $uom => $value['product_unit_measurement'],
                $rate => $value['product_rate'],
                $amount => $value['product_amount'],
                $status => "RAW",
            ];
        }

        return $data;
    }




    public function GET_ALL_PRODUCTS(){

        $user = Auth::user();

        $query = DB::table('financials_products as products')
            ->leftJoin('financials_units as units', 'units.unit_id', 'products.pro_unit_id');

        if ($user->user_level != 100) {
            $query->whereIn('products.pro_reporting_group_id', explode(',', $user->user_product_reporting_group_ids));
        }

        $products = $query->where('pro_status', config('global_variables.product_active_status'))
            ->where('products.pro_delete_status', '!=', 1)
            ->where('products.pro_disabled', '!=', 1)
            ->select("products.pro_id as proId", "products.pro_group_id as groupId", "products.pro_category_id as categoryId", "products.pro_reporting_group_id as reportingGroupId", "products.pro_main_unit_id as mainUnitId", "products.pro_unit_id as unitId", "products.pro_p_code as proCode", "products.pro_title as proTitle", "products.pro_purchase_price as proPurchasePrice", "products.pro_average_rate as proAveragePrice", "products.pro_last_purchase_rate as proLastPurchasePrice", "products.pro_min_quantity_alert as proMinQuantityAlert", "products.pro_allow_decimal as proAllowDecimal", "units.unit_id as unitId", "units.unit_title as unitTitle", "units.unit_scale_size as unitScaleSize")
            ->orderby('products.pro_title', 'ASC')
            ->get();

        return $products;

    }




}
