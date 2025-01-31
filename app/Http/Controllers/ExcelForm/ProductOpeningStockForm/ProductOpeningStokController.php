<?php

namespace App\Http\Controllers\ExcelForm\ProductOpeningStockForm;

use App\Http\Controllers\DayEndController;
use App\Models\ProductModel;
use App\Models\StockMovementModels;
use App\Models\WarehouseStockModel;
use App\Models\WarehouseStockSummaryModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductOpeningStokController extends Controller
{
    public
    function excel_form_product_opening_stock($request)
    {
        $ids = $request->product_code;
        $p_rate = $request->purchase_price;
        $b_rate = $request->bottom_price;
        $s_rate = $request->sale_price;
        $quantity = $request->qty;


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
//        foreach ($ids as $index => $id) {

            $product = ProductModel::where('pro_clg_id',$user->user_clg_id)->where('pro_p_code', $ids)->first();
            $product_name = $product->pro_title;
            $product_quantity = $quantity;
            $product_rate = $p_rate;
            ProductModel::where('pro_clg_id',$user->user_clg_id)->where('pro_p_code', $ids)->update(
                [
                    'pro_purchase_price' => $p_rate == '' ? 0 : $p_rate,
                    'pro_bottom_price' => $b_rate == '' ? 0 : $b_rate,
                    'pro_sale_price' => $s_rate == '' ? 0 : $s_rate,
                    'pro_average_rate' => $p_rate == '' ? 0 : $p_rate,
                    'pro_last_purchase_rate' => $p_rate == '' ? 0 : $p_rate,
                    'pro_quantity' => $quantity == '' ? 0 : $quantity,
                    'pro_qty_wo_bonus' => $quantity == '' ? 0 : $quantity,
                    'pro_qty_for_sale' => $quantity == '' ? 0 : $quantity,
                    $brwsr_col => $brwsr_rslt,
                    $ip_col => $ip_rslt,
                    $updt_date_col => Carbon::now()->toDateTimeString()
                ]
            );
            $stock = StockMovementModels::where('sm_clg_id',$user->user_clg_id)->where('sm_product_code', $ids)->orderBy('sm_id', 'DESC')->first();
            if ($stock == '') {
                $stock_movement = new StockMovementModels();

                $this->ProductCreationStockMovementValues($ids, $product_name, $product_quantity, $product_rate, $stock_movement);

                if (!$stock_movement->save()) {
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again!');
                }
            } else {
                $total_bal = $product_quantity * $p_rate;
                $stock->sm_bal_rate = $p_rate;
                $stock->sm_bal_total = $total_bal;
                $stock->sm_in_qty = $product_quantity;
                $stock->sm_bal_qty_for_sale = $product_quantity;
                $stock->sm_bal_total_qty_wo_bonus = $product_quantity;
                $stock->sm_bal_total_qty = $product_quantity;
                $stock->sm_clg_id = $user->user_clg_id;
                $stock->save();

//                StockMovementModels::where('sm_product_code', $ids[$index])->orderBy('sm_id', 'DESC')->first()->update(
//                    [
////                        'sm_bal_rate' => $p_rate[$index] == '' ? 0 : $p_rate[$index],
//                        'sm_bal_total' => $total_bal == '' ? 0 : $total_bal,
//                        'sm_bal_qty_for_sale' => $product_quantity == '' ? 0 : $product_quantity,
//                        'sm_bal_total_qty_wo_bonus' => $product_quantity == '' ? 0 : $product_quantity,
//                        'sm_in_qty' => $product_quantity == '' ? 0 : $product_quantity,
//
////                    $brwsr_col => $brwsr_rslt,
////                    $ip_col => $ip_rslt,
////                    $updt_date_col => Carbon::now()->toDateTimeString()
//                    ]
//                );
            }
            ////////////////////////// Warehouse Stock Insertion ////////////////////////////////////
            $warehouses = [];
            $warehouse = $this->AssignWarehouseStocksOpeningValues($warehouses, $ids, $product_quantity, 1);

            if (!DB::table('financials_warehouse_stock')->insert($warehouse)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

//////////////////////////// Warehouse Stock Summary Insertion ////////////////////////////////////

            $invoice_type_summary = 'OPENING STOCK';

            $warehouses_summary = [];
            $warehouse_stock_summary = $this->AssignWarehouseStocksSummaryOpeningValues($warehouses_summary, $ids, $product_name, $product_quantity, $invoice_type_summary);

            if (!DB::table('financials_warehouse_stock_summary')->insert($warehouse_stock_summary)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }


            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Product Rate of Code: ' . $product->pro_p_code . ' And Name: ' . $product->pro_title);
//        }

        return redirect()->back()->with('success', 'Successfully Saved');
    }

    public
    function simple_form_product_opening_stock(Request $request)
    {
//        $this->product_opening_stock_validation($request);

        $ids = $request->id;
        $p_rate = $request->p_rate;
        $b_rate = $request->b_rate;
        $s_rate = $request->s_rate;
        $quantity = $request->quantity;


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

            $product = ProductModel::where('pro_clg_id',$user->user_clg_id)->where('pro_p_code', $ids[$index])->first();
            $product_name = $product->pro_title;
            $product_quantity = $quantity[$index];
            $product_rate = $p_rate[$index];
            ProductModel::where('pro_clg_id',$user->user_clg_id)->where('pro_p_code', $ids[$index])->update(
                [
                    'pro_purchase_price' => $p_rate[$index] == '' ? 0 : $p_rate[$index],
                    'pro_bottom_price' => $b_rate[$index] == '' ? 0 : $b_rate[$index],
                    'pro_sale_price' => $s_rate[$index] == '' ? 0 : $s_rate[$index],
                    'pro_average_rate' => $p_rate[$index] == '' ? 0 : $p_rate[$index],
                    'pro_last_purchase_rate' => $p_rate[$index] == '' ? 0 : $p_rate[$index],
                    'pro_quantity' => $quantity[$index] == '' ? 0 : $quantity[$index],
                    'pro_qty_wo_bonus' => $quantity[$index] == '' ? 0 : $quantity[$index],
                    'pro_qty_for_sale' => $quantity[$index] == '' ? 0 : $quantity[$index],
                    $brwsr_col => $brwsr_rslt,
                    $ip_col => $ip_rslt,
                    $updt_date_col => Carbon::now()->toDateTimeString()
                ]
            );
            $stock = StockMovementModels::where('sm_clg_id',$user->user_clg_id)->where('sm_product_code', $ids[$index])->orderBy('sm_id', 'DESC')->first();
            if ($stock == '') {
                $stock_movement = new StockMovementModels();

                $this->ProductCreationStockMovementValues($ids[$index], $product_name, $product_quantity, $product_rate, $stock_movement);

                if (!$stock_movement->save()) {
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again!');
                }
            } else {
                $total_bal = $product_quantity * $p_rate[$index];
                $stock->sm_bal_rate = $p_rate[$index];
                $stock->sm_bal_total = $total_bal;
                $stock->sm_in_qty = $product_quantity;
                $stock->sm_bal_qty_for_sale = $product_quantity;
                $stock->sm_bal_total_qty_wo_bonus = $product_quantity;
                $stock->sm_bal_total_qty = $product_quantity;
                $stock->sm_clg_id = $user->user_clg_id;
                $stock->save();

//                StockMovementModels::where('sm_product_code', $ids[$index])->orderBy('sm_id', 'DESC')->first()->update(
//                    [
////                        'sm_bal_rate' => $p_rate[$index] == '' ? 0 : $p_rate[$index],
//                        'sm_bal_total' => $total_bal == '' ? 0 : $total_bal,
//                        'sm_bal_qty_for_sale' => $product_quantity == '' ? 0 : $product_quantity,
//                        'sm_bal_total_qty_wo_bonus' => $product_quantity == '' ? 0 : $product_quantity,
//                        'sm_in_qty' => $product_quantity == '' ? 0 : $product_quantity,
//
////                    $brwsr_col => $brwsr_rslt,
////                    $ip_col => $ip_rslt,
////                    $updt_date_col => Carbon::now()->toDateTimeString()
//                    ]
//                );
            }
            ////////////////////////// Warehouse Stock Insertion ////////////////////////////////////
            $warehouses = [];
            $warehouse = $this->AssignWarehouseStocksOpeningValues($warehouses, $ids[$index], $product_quantity, 1);

            if (!DB::table('financials_warehouse_stock')->insert($warehouse)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }

//////////////////////////// Warehouse Stock Summary Insertion ////////////////////////////////////

            $invoice_type_summary = 'OPENING STOCK';

            $warehouses_summary = [];
            $warehouse_stock_summary = $this->AssignWarehouseStocksSummaryOpeningValues($warehouses_summary, $ids[$index], $product_name, $product_quantity, $invoice_type_summary);

            if (!DB::table('financials_warehouse_stock_summary')->insert($warehouse_stock_summary)) {
                $rollBack = true;
                DB::rollBack();
                return redirect()->back()->with('fail', 'Failed Try Again');
            }


            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Product Rate of Code: ' . $product->pro_p_code . ' And Name: ' . $product->pro_title);
        }

        return redirect()->back()->with('success', 'Successfully Saved');
    }


    public function ProductCreationStockMovementValues($product_code, $product_name, $qty, $rate, $stock_movement)
    {
        $user = Auth::user();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $product_code = $product_code;
        $product_name = $product_name;
//        $product_remarks = $product->pro_remarks;
        $product_bal_qty = $qty;
        $product_bal_rate = $rate;
        $product_bal_total = $product_bal_qty * $product_bal_rate;
        $notes = 'OPENING_BALANCE';


        $stock_movement->sm_product_code = $product_code;
        $stock_movement->sm_product_name = $product_name;
//        $stock_movement->sm_pur_qty = 0;
//        $stock_movement->sm_pur_rate = 0;
//        $stock_movement->sm_pur_total = 0;
//        $stock_movement->sm_sale_qty = 0;
//        $stock_movement->sm_sale_rate = 0;
//        $stock_movement->sm_sale_total = 0;
        $stock_movement->sm_in_qty = $product_bal_qty;
        $stock_movement->sm_bal_qty_for_sale = $product_bal_qty;
        $stock_movement->sm_bal_total_qty_wo_bonus = $product_bal_qty;
        $stock_movement->sm_bal_total_qty = $product_bal_qty;
//        $stock_movement->sm_bal_qty = $product_bal_qty;
        $stock_movement->sm_bal_rate = $product_bal_rate;
        $stock_movement->sm_bal_total = $product_bal_total;
        $stock_movement->sm_warehouse_id = 1;
        $stock_movement->sm_type = $notes;
        $stock_movement->sm_day_end_id = 1;
        $stock_movement->sm_day_end_date = $day_end->de_datetime;
//        $stock_movement->sm_voucher_code = 0;
//        $stock_movement->sm_remarks = $product_remarks;
        $stock_movement->sm_user_id = $user->user_id;
        $stock_movement->sm_clg_id = $user->user_clg_id;
        $stock_movement->sm_date_time = Carbon::now()->toDateTimeString();

        return $stock_movement;
    }

    public function AssignWarehouseStocksOpeningValues($data, $pro_code, $qty, $sign)
    {//sign 1 for add and sign 2 for subtract
        $user = Auth::user();
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        if ($pro_code != '') {

            $previous_stock = WarehouseStockModel::where('whs_clg_id',$user->user_clg_id)->where('whs_product_code', $pro_code)->where('whs_warehouse_id', 1)->orderBy('whs_id', 'DESC')->pluck('whs_stock')->first();

            if ($sign == 1) {
                $current_stock = $qty;
            } else {
                $current_stock = $qty;
            }

            if ($previous_stock !== null) {

                $inventory = WarehouseStockModel::where('whs_clg_id',$user->user_clg_id)->where('whs_product_code', $pro_code)->where('whs_warehouse_id', 1)->first();
                $inventory->whs_stock = $current_stock;
                $inventory->whs_brwsr_info = $brwsr_rslt;
                $inventory->whs_ip_adrs = $ip_rslt;
                $inventory->whs_update_datetime = Carbon::now()->toDateTimeString();
                // coding from shahzaib end

                $inventory->save();
            } else {

                $data[] = [
                    'whs_product_code' => $pro_code,
                    'whs_stock' => $current_stock,
                    'whs_warehouse_id' => 1,
                    'whs_datetime' => Carbon::now()->toDateTimeString(),
                    'whs_brwsr_info' => $brwsr_rslt,
                    'whs_ip_adrs' => $ip_rslt,
                    'whs_update_datetime' => Carbon::now()->toDateTimeString(),
                    'whs_clg_id' => $user->user_clg_id
                ];
            }
        }
        return $data;
    }

    public function AssignWarehouseStocksSummaryOpeningValues($data, $product_code, $product_name, $qty, $type)
    {//sign 1 for add and sign 2 for subtract
        $user = Auth::user();
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $previous_stock = WarehouseStockSummaryModel::where('whss_clg_id',$user->user_clg_id)->where('whss_product_code', $product_code)->where('whss_warehouse_id', 1)->orderBy('whss_update_datetime',
            'DESC')->first();

        if ($previous_stock !== null) {
            if ($type == 'OPENING STOCK') {
                $current_stock_for_in = $qty;
                $current_stock_for_out = 0;
                $current_stock_for_hold = $previous_stock->whss_total_hold;
                $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                $current_stock_for_claim = $previous_stock->whss_total_claim;
                $current_stock_for_sale = $qty;
            }

        }
        $previous_stock_type = WarehouseStockSummaryModel::where('whss_clg_id',$user->user_clg_id)->where('whss_product_code', $product_code)->where('whss_type', $type)->where('whss_warehouse_id', 1)
            ->orderBy('whss_id',
            'DESC')->first();
        if ($previous_stock_type !== null) {

            $inventory = WarehouseStockSummaryModel::where('whss_clg_id',$user->user_clg_id)->where('whss_product_code', $product_code)->where('whss_type', $type)->where('whss_warehouse_id', 1)
                ->first();


            $inventory->whss_qty_in = $current_stock_for_in;
            $inventory->whss_qty_out = $current_stock_for_out;
            $inventory->whss_total_hold = $current_stock_for_hold;
            $inventory->whss_total_bonus = $current_stock_for_bonus;
            $inventory->whss_total_claim = $current_stock_for_claim;
            $inventory->whss_total_for_sale = $current_stock_for_sale;
            $inventory->whss_brwsr_info = $brwsr_rslt;
            $inventory->whss_ip_adrs = $ip_rslt;
            $inventory->whss_update_datetime = Carbon::now()->toDateTimeString();
            // coding from shahzaib end

            $inventory->save();
        } else {

            if ($type == 'OPENING STOCK') {
                $current_stock_for_in = $qty;
                $current_stock_for_out = 0;
                $current_stock_for_hold = 0;
                if ($previous_stock !== null) {
                    $current_stock_for_hold = $previous_stock->whss_total_hold;
                }
                $current_stock_for_bonus = 0;
                if ($previous_stock !== null) {
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                }
                $current_stock_for_claim = 0;
                if ($previous_stock !== null) {
                    $current_stock_for_claim = $previous_stock->whss_total_claim;
                }
                $current_stock_for_sale = $qty;
                if ($previous_stock !== null) {
                    $current_stock_for_sale = $qty;
                }
            }

            $data[] = [
                'whss_type' => $type,
                'whss_product_code' => $product_code,
                'whss_product_name' => $product_name,
                'whss_qty_in' => $current_stock_for_in,
                'whss_qty_out' => $current_stock_for_out,
                'whss_total_hold' => $current_stock_for_hold,
                'whss_total_bonus' => $current_stock_for_bonus,
                'whss_total_claim' => $current_stock_for_claim,
                'whss_total_for_sale' => $current_stock_for_sale,

                'whss_warehouse_id' => 1,
                'whss_datetime' => Carbon::now()->toDateTimeString(),
                'whss_brwsr_info' => $brwsr_rslt,
                'whss_ip_adrs' => $ip_rslt,
                'whss_update_datetime' => Carbon::now()->toDateTimeString(),
                'whss_clg_id' => $user->user_clg_id
            ];
        }

        return $data;
    }

    public function product_opening_stock_validation($request)
    {

        return $this->validate($request, [
            'id' => ['required', 'array'],
            'id.*' => ['required', 'string'],
            'p_rate' => ['required', 'array'],
            'p_rate.*' => ['nullable', 'numeric'],
            'b_rate' => ['required', 'array'],
            'b_rate.*' => ['nullable', 'numeric'],
            's_rate' => ['required', 'array'],
            's_rate.*' => ['nullable', 'numeric'],
            'quantity' => ['required', 'array'],
            'quantity.*' => ['nullable', 'numeric'],
        ]);
    }

    function excel_product_opening_stock_validation($request)
    {
        return $this->validate($request, [
//            'id' => ['required', 'array'],
//            'id.*' => ['required', 'numeric'],
//            'dr_balances' => ['required', 'array'],
//            'dr_balances.*' => ['nullable', 'numeric'],
//            'cr_balances' => ['required', 'array'],
//            'cr_balances.*' => ['nullable', 'numeric'],
        ]);
    }
}
