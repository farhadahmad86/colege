<?php

namespace App\Http\Controllers\TradeInvoices;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\DayEndController;
use App\Models\BalancesModel;
use App\Models\ConvertQuantity;
use App\Models\ProductModel;
use App\Models\StockMovementModels;
use App\Models\TransactionModel;
use App\Models\WarehouseModel;
use App\Models\WarehouseStockSummaryModel;
use App\User;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TradeConvertQuantityController extends Controller
{

    public function show_trade_convert_quantity()
    {
//        $warehouses = WarehouseModel::orderBy('wh_title', 'ASC')->get();
        $products = DB::table('financials_products')
            ->leftJoin('financials_units', 'financials_units.unit_id', '=', 'financials_products.pro_unit_id')
            ->orderBy('pro_title', 'ASC')->get();
//        ProductModel::orderBy('pro_title', 'ASC')->get();

        return view('Trade_Invoices/trade_convert_quantity', compact('products'));
    }

    public function submit_trade_convert_quantity(Request $request)
    {

        $this->validate($request, [
            'warehouse' => ['required', 'string'],
            'product_code' => ['required', 'string'],
            'product_title' => ['required', 'string'],
            'scale_size' => ['required', 'string'],
            'quantity' => ['required', 'numeric'],
            'convert_qty' => ['required', 'numeric'],
            'convert_unit' => ['required', 'numeric'],
        ]);

        $user = Auth::user();
        $rollBack = false;

        DB::beginTransaction();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $convert_Quantity = $this->assignConvertQuantityValues($request, $user, $day_end);
        if (!$convert_Quantity->save()) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        $stock_movement_last_entry = StockMovementModels::where('sm_product_code', '=', $request->product_code)->where('sm_warehouse_id', '=', $request->warehouse)->orderBy('sm_id', 'desc')->first();
//        dd($stock_movement_last_entry);
        $stock_movement = $this->assignStockMovementDefaultValues($request, $user, $day_end, $stock_movement_last_entry);
        $stock_movement = $this->assignStockMovementConditionsBasedValues($request, $stock_movement, $stock_movement_last_entry);
        if (!$stock_movement->save()) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }

        //////////////////////////// Warehouse Stock Summary Insertion ////////////////////////////////////
        $transfer_type_summary = '';
        if ($request->convert_qty == 1) {
            if ($request->convert_unit == 1) {
                $transfer_type_summary = 'TRANSFER FROM HOLD';
            } elseif ($request->convert_unit == 2) {
                $transfer_type_summary = 'CONVERT FROM BONUS';
            } elseif ($request->convert_unit == 3) {
                $transfer_type_summary = 'TRANSFER FROM CLAIM';
            }
        } elseif ($request->convert_qty == 2) {
            if ($request->convert_unit == 1) {
                $transfer_type_summary = 'TRANSFER TO HOLD';
            } elseif ($request->convert_unit == 2) {
                $transfer_type_summary = 'CONVERT TO BONUS';
            } elseif ($request->convert_unit == 3) {
                $transfer_type_summary = 'TRANSFER TO CLAIM';
            }
        }
        $warehouses_summary = [];
        $warehouse_stock_summary = $this->AssignWarehouseStocksSummaryConvertValues($request, $warehouses_summary, $transfer_type_summary);

        if (!DB::table('financials_warehouse_stock_summary')->insert($warehouse_stock_summary)) {
            $rollBack = true;
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }


        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {
            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Convert Quantity With Id: ' . $convert_Quantity->cq_id . ' And Name: ' . $convert_Quantity->cq_pro_title);

            DB::commit();
            return redirect()->back()->with('success', 'Successfully Saved');
        }
    }

    public function assignConvertQuantityValues($request, $user, $day_end)
    {
        $convert_Quantity = new ConvertQuantity();
        $convert_Quantity->cq_warehouse = $request->warehouse;
        $convert_Quantity->cq_pro_code = $request->product_code;
        $convert_Quantity->cq_pro_title = $request->product_title;
        $convert_Quantity->cq_scale_size = $request->scale_size;
        $convert_Quantity->cq_quantity = $request->quantity;
        $convert_Quantity->cq_remarks = $request->remarks;
        $convert_Quantity->cq_convert_quantity = $request->convert_qty;
        $convert_Quantity->cq_convert_unit = $request->convert_unit;
        $convert_Quantity->cq_user_id = $user->user_id;
        $convert_Quantity->cq_datetime = now();
        $convert_Quantity->cq_day_end_id = $day_end->de_id;
        $convert_Quantity->cq_day_end_date = $day_end->de_datetime;

        return $convert_Quantity;
    }

    private function assignStockMovementDefaultValues($request, $user, $day_end, $stock_movement_last_entry)
    {
//        dd($stock_movement_last_entry);
        $stock_movement = new StockMovementModels();
        $stock_movement->sm_warehouse_id = $request->warehouse;
        $stock_movement->sm_product_code = $request->product_code;
        $stock_movement->sm_product_name = $request->product_title;
        $stock_movement->sm_in_qty = null;
        $stock_movement->sm_in_bonus = null;
        $stock_movement->sm_in_rate = null;
        $stock_movement->sm_in_total = null;
        $stock_movement->sm_out_qty = null;
        $stock_movement->sm_out_bonus = null;
        $stock_movement->sm_out_rate = null;
        $stock_movement->sm_out_total = null;

        $stock_movement->sm_internal_hold = null;
        $stock_movement->sm_internal_bonus = null;
        $stock_movement->sm_internal_claim = null;

        $stock_movement->sm_bal_bonus_inward = 0; // $stock_movement_last_entry->sm_bal_bonus_inward;
        $stock_movement->sm_bal_bonus_outward = 0; // $stock_movement_last_entry->sm_bal_bonus_outward;
        $stock_movement->sm_bal_bonus_qty = $stock_movement_last_entry->sm_bal_bonus_qty;

        $stock_movement->sm_bal_hold = 0; // $stock_movement_last_entry->sm_bal_hold;
        $stock_movement->sm_bal_total_hold = $stock_movement_last_entry->sm_bal_total_hold;
        $stock_movement->sm_bal_claims = $stock_movement_last_entry->sm_bal_claims;

        $stock_movement->sm_bal_total_qty_wo_bonus = $stock_movement_last_entry->sm_bal_total_qty_wo_bonus;
        $stock_movement->sm_bal_total_qty = $stock_movement_last_entry->sm_bal_total_qty;
        $stock_movement->sm_bal_rate = $stock_movement_last_entry->sm_bal_rate;
        $stock_movement->sm_bal_total = $stock_movement_last_entry->sm_bal_total;

        $stock_movement->sm_day_end_id = $day_end->de_id;
        $stock_movement->sm_day_end_date = $day_end->de_datetime;
        $stock_movement->sm_voucher_code = '';
        $stock_movement->sm_remarks = '';
        $stock_movement->sm_user_id = $user->user_id;
        $stock_movement->sm_date_time = now();

        return $stock_movement;
    }

    private function assignStockMovementConditionsBasedValues($request, StockMovementModels $stock_movement, StockMovementModels $stock_movement_last_entry)
    {
        if ($request->convert_qty == 1) /* 1 => Convert Quantity for Sale */ {
            if ($request->convert_unit == 1) /* 1 => Hold */ {

                $quantity = -1 * abs($request->quantity);

                $stock_movement->sm_type = 'TRANSFER FROM HOLD';
                $stock_movement->sm_internal_hold = $quantity;
                $stock_movement->sm_bal_qty_for_sale = isset($stock_movement_last_entry) ? $stock_movement_last_entry->sm_bal_qty_for_sale - $quantity : $quantity;
                $stock_movement->sm_bal_hold = $quantity;
                $stock_movement->sm_bal_total_hold = isset($stock_movement_last_entry) ? $stock_movement_last_entry->sm_bal_total_hold + $quantity : $quantity;

            } elseif ($request->convert_unit == 2) /* 2 => Bonus */ {

                $quantity = -1 * abs($request->quantity);

                $stock_movement->sm_type = 'CONVERT FROM BONUS';
                $stock_movement->sm_internal_bonus = $quantity;
                $stock_movement->sm_bal_qty_for_sale = isset($stock_movement_last_entry) ? $stock_movement_last_entry->sm_bal_qty_for_sale - $quantity : $quantity;
                $stock_movement->sm_bal_bonus_qty = isset($stock_movement_last_entry) ? $stock_movement_last_entry->sm_bal_bonus_qty + $quantity : $quantity;
                $stock_movement->sm_bal_total_qty_wo_bonus = $stock_movement->sm_bal_qty_for_sale + $stock_movement->sm_bal_total_hold + $stock_movement->sm_bal_claims;
                $stock_movement->sm_bal_total = $stock_movement->sm_bal_total_qty_wo_bonus * $stock_movement->sm_bal_rate;


                $product_parent_code = $this->get_product_parent_code($request->product_code);
                $product_average_rate = $this->get_product_average_rate($product_parent_code);
                $ammount = $product_average_rate * $request->quantity;

                $stock_in_hand = config('global_variables.stock_in_hand');
                $bonus_A_D = config('global_variables.bonus_allocation_deallocation');
                $purchase = config('global_variables.purchase_account');

                $transactions1 = new TransactionModel();
                $transaction1 = $this->AssignTransactionsValues($transactions1, $stock_in_hand, $ammount, 0, '', '', 0);

                if ($transaction1->save()) {

                    $transaction_id1 = $transaction1->trans_id;

                    $balances1 = new BalancesModel();

                    $balance1 = $this->AssignAccountBalancesValues($balances1, $transaction_id1, $stock_in_hand, $ammount, 'Dr', $request->remarks,
                        '', '', '', '');

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


                $transactions2 = new TransactionModel();
                $transaction2 = $this->AssignTransactionsValues($transactions2, $purchase, $ammount, 0, '', '', 0);

                if ($transaction2->save()) {

                    $transaction_id2 = $transaction2->trans_id;

                    $balances2 = new BalancesModel();

                    $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id2, $purchase, $ammount, 'Dr', $request->remarks,
                        '', '', '', '');

                    if (!$balance2->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed Try Again');
                    }
                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }


                $transactions3 = new TransactionModel();
                $transaction3 = $this->AssignTransactionsValues($transactions3, 0, $ammount, $bonus_A_D, '', '', 0);

                if ($transaction3->save()) {

                    $transaction_id3 = $transaction3->trans_id;

                    $balances3 = new BalancesModel();

                    $balance3 = $this->AssignAccountBalancesValues($balances3, $transaction_id3, $bonus_A_D, $ammount, 'Cr', $request->remarks,
                        '', '', '', '');

                    if (!$balance3->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed Try Again');
                    }
                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }


            } elseif ($request->convert_unit == 3) /* 3 => Claim */ {

                $quantity = -1 * abs($request->quantity);

                $stock_movement->sm_type = 'TRANSFER FROM CLAIM';
                $stock_movement->sm_internal_claim = $quantity;
                $stock_movement->sm_bal_qty_for_sale = isset($stock_movement_last_entry) ? $stock_movement_last_entry->sm_bal_qty_for_sale - $quantity : $quantity;
                $stock_movement->sm_bal_claims = isset($stock_movement_last_entry) ? $stock_movement_last_entry->sm_bal_claims + $quantity : $quantity;

            }
        } elseif ($request->convert_qty == 2) /* 2 => Convert Quantity Not for Sale */ {
            if ($request->convert_unit == 1) /* 1 => Hold */ {

                $stock_movement->sm_type = 'TRANSFER TO HOLD';
                $stock_movement->sm_internal_hold = $request->quantity;
                $stock_movement->sm_bal_qty_for_sale = isset($stock_movement_last_entry) ? $stock_movement_last_entry->sm_bal_qty_for_sale - $request->quantity : 0 - $request->quantity;
                $stock_movement->sm_bal_hold = $request->quantity;
                $stock_movement->sm_bal_total_hold = isset($stock_movement_last_entry) ? $stock_movement_last_entry->sm_bal_total_hold + $request->quantity : $request->quantity;

            } elseif ($request->convert_unit == 2) /* 2 => Bonus */ {

                $stock_movement->sm_type = 'CONVERT TO BONUS';
                $stock_movement->sm_internal_bonus = $request->quantity;
                $stock_movement->sm_bal_qty_for_sale = isset($stock_movement_last_entry) ? $stock_movement_last_entry->sm_bal_qty_for_sale - $request->quantity : $request->quantity;
                $stock_movement->sm_bal_bonus_qty = isset($stock_movement_last_entry) ? $stock_movement_last_entry->sm_bal_bonus_qty + $request->quantity : $request->quantity;
                $stock_movement->sm_bal_total_qty_wo_bonus = $stock_movement->sm_bal_qty_for_sale + $stock_movement->sm_bal_total_hold + $stock_movement->sm_bal_claims;
                $stock_movement->sm_bal_total = $stock_movement->sm_bal_total_qty_wo_bonus * $stock_movement->sm_bal_rate;


                $product_parent_code = $this->get_product_parent_code($request->product_code);
                $product_average_rate = $this->get_product_average_rate($product_parent_code);
                $ammount = $product_average_rate * $request->quantity;

                $stock_in_hand = config('global_variables.stock_in_hand');
                $bonus_A_D = config('global_variables.bonus_allocation_deallocation');
                $purchase = config('global_variables.purchase_account');

                $transactions1 = new TransactionModel();
                $transaction1 = $this->AssignTransactionsValues($transactions1, 0, $ammount, $stock_in_hand, '', '', 0);

                if ($transaction1->save()) {

                    $transaction_id1 = $transaction1->trans_id;

                    $balances1 = new BalancesModel();

                    $balance1 = $this->AssignAccountBalancesValues($balances1, $transaction_id1, $stock_in_hand, $ammount, 'Cr', $request->remarks,
                        '', '', '', '');

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


                $transactions2 = new TransactionModel();
                $transaction2 = $this->AssignTransactionsValues($transactions2, 0, $ammount, $purchase, '', '', 0);

                if ($transaction2->save()) {

                    $transaction_id2 = $transaction2->trans_id;

                    $balances2 = new BalancesModel();

                    $balance2 = $this->AssignAccountBalancesValues($balances2, $transaction_id2, $purchase, $ammount, 'Cr', $request->remarks,
                        '', '', '', '');

                    if (!$balance2->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed Try Again');
                    }
                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }


                $transactions3 = new TransactionModel();
                $transaction3 = $this->AssignTransactionsValues($transactions3, $bonus_A_D, $ammount, 0, '', '', 0);

                if ($transaction3->save()) {

                    $transaction_id3 = $transaction3->trans_id;

                    $balances3 = new BalancesModel();

                    $balance3 = $this->AssignAccountBalancesValues($balances3, $transaction_id3, $bonus_A_D, $ammount, 'Dr', $request->remarks,
                        '', '', '', '');

                    if (!$balance3->save()) {
                        $rollBack = true;
                        DB::rollBack();
                        return redirect()->back()->with('fail', 'Failed Try Again');
                    }
                } else {
                    $rollBack = true;
                    DB::rollBack();
                    return redirect()->back()->with('fail', 'Failed Try Again');
                }


            } elseif ($request->convert_unit == 3) /* 3 => Claim */ {

                $stock_movement->sm_type = 'TRANSFER TO CLAIM';
                $stock_movement->sm_internal_claim = $request->quantity;
                $stock_movement->sm_bal_qty_for_sale = isset($stock_movement_last_entry) ? $stock_movement_last_entry->sm_bal_qty_for_sale - $request->quantity : 0 - $request->quantity;
                $stock_movement->sm_bal_claims = isset($stock_movement_last_entry) ? $stock_movement_last_entry->sm_bal_claims + $request->quantity : $request->quantity;

            }
        }

        return $stock_movement;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////// Warehouse Stock Related Code ///////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////

    public function AssignWarehouseStocksSummaryConvertValues($request, $data, $type)
    {//sign 1 for add and sign 2 for subtract

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        //foreach ($array as $key) {

        $previous_stock = WarehouseStockSummaryModel::where('whss_product_code', $request->product_code)->where('whss_warehouse_id', $request->warehouse)->orderBy('whss_update_datetime',
            'DESC')->first();

        if ($previous_stock !== null) {
            if ($request->convert_qty == 1) {
                if ($type == 'TRANSFER FROM HOLD') {
                    $current_stock_for_in = $request->quantity;
                    $current_stock_for_out = 0;
                    $current_stock_for_hold = $previous_stock->whss_total_hold - $request->quantity;
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    $current_stock_for_claim = $previous_stock->whss_total_claim;
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale + $request->quantity;
                } elseif ($type == 'CONVERT FROM BONUS') {
                    $current_stock_for_in = $request->quantity;
                    $current_stock_for_out = 0;
                    $current_stock_for_hold = $previous_stock->whss_total_hold;
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus - $request->quantity;
                    $current_stock_for_claim = $previous_stock->whss_total_claim;
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale + $request->quantity;
                } elseif ($type == 'TRANSFER FROM CLAIM') {
                    $current_stock_for_in = $request->quantity;
                    $current_stock_for_out = 0;
                    $current_stock_for_hold = $previous_stock->whss_total_hold;
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    $current_stock_for_claim = $previous_stock->whss_total_claim - $request->quantity;
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale + $request->quantity;
                }

            } elseif ($request->convert_qty == 2) {
                if ($type == 'TRANSFER TO HOLD') {
                    $current_stock_for_in = $request->quantity;
                    $current_stock_for_out = 0;
                    $current_stock_for_hold = $previous_stock->whss_total_hold + $request->quantity;
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    $current_stock_for_claim = $previous_stock->whss_total_claim;
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale - $request->quantity;
                } elseif ($type == 'CONVERT TO BONUS') {
                    $current_stock_for_in = $request->quantity;
                    $current_stock_for_out = 0;
                    $current_stock_for_hold = $previous_stock->whss_total_hold;
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus + $request->quantity;
                    $current_stock_for_claim = $previous_stock->whss_total_claim;
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale - $request->quantity;
                } elseif ($type == 'TRANSFER TO CLAIM') {
                    $current_stock_for_in = $request->quantity;
                    $current_stock_for_out = 0;
                    $current_stock_for_hold = $previous_stock->whss_total_hold;
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    $current_stock_for_claim = $previous_stock->whss_total_claim + $request->quantity;
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale - $request->quantity;
                }

            }
        }
        $previous_stock_type = WarehouseStockSummaryModel::where('whss_product_code', $request->product_code)->where('whss_type', $type)->where('whss_warehouse_id', $request->warehouse)
            ->orderBy('whss_id',
                'DESC')->first();
        if ($previous_stock_type !== null) {

            $inventory = WarehouseStockSummaryModel::where('whss_product_code', $request->product_code)->where('whss_type', $type)->where('whss_warehouse_id', $request->warehouse)
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

            if ($request->convert_qty == 1) {
                if ($type == 'TRANSFER FROM HOLD') {
                    $current_stock_for_in = $request->quantity;
                    $current_stock_for_out = 0;
                    $current_stock_for_hold = $request->quantity;
                    if ($previous_stock !== null) {
                        $current_stock_for_hold = $previous_stock->whss_total_hold - $request->quantity;
                    }
                    $current_stock_for_bonus = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    }
                    $current_stock_for_claim = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_claim = $previous_stock->whss_total_claim;
                    }
                    $current_stock_for_sale = $request->quantity;
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale + $request->quantity;
                    }
                } elseif ($type == 'CONVERT FROM BONUS') {
                    $current_stock_for_in = $request->quantity;
                    $current_stock_for_out = 0;
                    $current_stock_for_hold = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_hold = $previous_stock->whss_total_hold;
                    }
                    $current_stock_for_bonus = $request->quantity;
                    if ($previous_stock !== null) {
                        $current_stock_for_bonus = $previous_stock->whss_total_bonus - $request->quantity;
                    }
                    $current_stock_for_claim = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_claim = $previous_stock->whss_total_claim;
                    }
                    $current_stock_for_sale = $request->quantity;
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale + $request->quantity;
                    }
                } elseif ($type == 'TRANSFER FROM CLAIM') {
                    $current_stock_for_in = $request->quantity;
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
                        $current_stock_for_claim = $previous_stock->whss_total_claim - $request->quantity;
                    }
                    $current_stock_for_sale = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale + $request->quantity;
                    }
                }

            } elseif ($request->convert_qty == 2) {
                if ($type == 'TRANSFER TO HOLD') {
                    $current_stock_for_in = $request->quantity;
                    $current_stock_for_out = 0;
                    $current_stock_for_hold = $request->quantity;
                    if ($previous_stock !== null) {
                        $current_stock_for_hold = $previous_stock->whss_total_hold + $request->quantity;
                    }
                    $current_stock_for_bonus = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    }
                    $current_stock_for_claim = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_claim = $previous_stock->whss_total_claim;
                    }
                    $current_stock_for_sale = $request->quantity;
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale - $request->quantity;
                    }
                } elseif ($type == 'CONVERT TO BONUS') {
                    $current_stock_for_in = $request->quantity;
                    $current_stock_for_out = 0;
                    $current_stock_for_hold = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_hold = $previous_stock->whss_total_hold;
                    }
                    $current_stock_for_bonus = $request->quantity;
                    if ($previous_stock !== null) {
                        $current_stock_for_bonus = $previous_stock->whss_total_bonus + $request->quantity;
                    }
                    $current_stock_for_claim = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_claim = $previous_stock->whss_total_claim;
                    }
                    $current_stock_for_sale = $request->quantity;
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale - $request->quantity;
                    }
                } elseif ($type == 'TRANSFER TO CLAIM') {
                    $current_stock_for_in = $request->quantity;
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
                        $current_stock_for_claim = $previous_stock->whss_total_claim + $request->quantity;
                    }
                    $current_stock_for_sale = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale - $request->quantity;
                    }
                }

            }

            $data[] = [
                'whss_type' => $type,
                'whss_product_code' => $request->product_code,
                'whss_product_name' => $request->product_title,
                'whss_qty_in' => $current_stock_for_in,
                'whss_qty_out' => $current_stock_for_out,
                'whss_total_hold' => $current_stock_for_hold,
                'whss_total_bonus' => $current_stock_for_bonus,
                'whss_total_claim' => $current_stock_for_claim,
                'whss_total_for_sale' => $current_stock_for_sale,

                'whss_warehouse_id' => $request->warehouse,
                'whss_datetime' => Carbon::now()->toDateTimeString(),
                'whss_brwsr_info' => $brwsr_rslt,
                'whss_ip_adrs' => $ip_rslt,
                'whss_update_datetime' => Carbon::now()->toDateTimeString()
            ];
        }
        // }

        return $data;
    }

    public function trade_convert_quantity_list(Request $request)
    {
        $ar = json_decode($request->array);
        $search = (!isset($request->search) && empty($request->search)) ? ((!empty($ar)) ? $ar[1]->{'value'} : '') : $request->search;
        $search_product_code = (!isset($request->product_code) && empty($request->product_code)) ? ((!empty($ar)) ? $ar[2]->{'value'} : '') : $request->product_code;
        $search_product_title = (!isset($request->product_code) && empty($request->product_code)) ? ((!empty($ar)) ? $ar[3]->{'value'} : '') : $request->product_code;
        $search_convert_quantity = (!isset($request->convert_quantity) && empty($request->convert_quantity)) ? ((!empty($ar)) ? $ar[4]->{'value'} : '') : $request->convert_quantity;
        $search_convert_unit = (!isset($request->convert_unit) && empty($request->convert_unit)) ? ((!empty($ar)) ? $ar[5]->{'value'} : '') : $request->convert_unit;
        $prnt_page_dir = 'print.trade_convert_quantity.trade_convert_quantity';
        $pge_title = 'Trade Convert Quantity';
        $srch_fltr = [];
        array_push($srch_fltr, $search, $search_product_code, $search_product_title, $search_convert_quantity, $search_convert_unit);
        $pagination_number = (empty($ar)) ? 30 : 100000000;

        $query = ConvertQuantity::orderBy('cq_id', 'DESC');

        if (!empty($search_product_code)) {
            $query = $query->where('cq_pro_code', '=', $search_product_code);
        }
        if (!empty($search_convert_quantity) && $search_convert_quantity != 0) {
            $query = $query->where('cq_convert_quantity', '=', $search_convert_quantity);
        }
        if (!empty($search_convert_unit) && $search_convert_unit != 0) {
            $query = $query->where('cq_convert_unit', '=', $search_convert_unit);
        }

//        $searchData = [];
//        if (isset($request->search) || isset($request->product_code) || isset($request->product_title) || isset($request->convert_quantity) || isset($request->convert_unit)) {
            $searchData = ['search' => $request->search, 'product_code' => $request->product_code, 'product_title' => $request->product_title, 'convert_quantity' => $request->convert_quantity, 'convert_unit' => $request->convert_unit];
//            $convert_quantities = $this->search($searchData);
//        } else {
//            $convert_quantities = ConvertQuantity::orderBy('cq_id', 'DESC');
//        }
        $convert_quantities = $query->paginate($pagination_number);

        $convert_quantities = $this->mapData($convert_quantities);
        $products = ProductModel::orderBy('pro_title', 'ASC')->get();

        if (isset($request->array) && !empty($request->array)) {
            return $this->printable($request, $convert_quantities, $srch_fltr, $prnt_page_dir, $pge_title);
        } else {
            return view('Trade_Invoices.trade_convert_quantity_list', compact('convert_quantities', 'products', 'searchData', 'search_product_code', 'search_product_title'));
        }
    }

    private function search($searchData)
    {
        $query = ConvertQuantity::orderBy('cq_id', 'DESC');

        if (isset($searchData['product_code'])) {
            $query = $query->orWhere('cq_pro_code', '=', $searchData['product_code']);
        }
        if (isset($searchData['product_title'])) {
            $query = $query->orWhere('cq_pro_code', '=', $searchData['product_title']);
        }
        if (isset($searchData['convert_quantity'])) {
            $query = $query->orWhere('cq_convert_quantity', '=', $searchData['convert_quantity']);
        }
        if (isset($searchData['convert_unit'])) {
            $query = $query->orWhere('cq_convert_unit', '=', $searchData['convert_unit']);
        }
        if (isset($searchData['search']) && $searchData['search'] != '') {
            $query = $query->orWhere('cq_pro_code', 'like', '%' . $searchData['search'] . '%')
                ->orWhere('cq_pro_title', 'like', '%' . $searchData['search'] . '%')
                ->orWhere('cq_quantity', 'like', '%' . $searchData['search'] . '%')
                ->orWhere('cq_remarks', 'like', '%' . $searchData['search'] . '%');
        }

        return $query;
    }

    private function mapData($convert_quantities)
    {
        return $convert_quantities->setCollection($convert_quantities->getCollection()->map(function ($convert_quantity) {
            $convert_quantity['createdBy'] = User::where('user_id', '=', $convert_quantity->cq_user_id)->pluck('user_name')->first();
            if ($convert_quantity->cq_convert_unit == 1) {
                $convert_quantity['convertUnit'] = 'Hold';
            } else {
                $convert_quantity['convertUnit'] = $convert_quantity->cq_convert_unit == 2 ? 'Bonus' : 'Claim';
            }
//            $convert_quantity['convertUnit'] = $convert_quantity->cq_convert_unit == 1 ? 'Hold' : $convert_quantity->cq_convert_unit == 2 ? 'Bonus' : 'Claim';
            $convert_quantity['convertQuantity'] = $convert_quantity->cq_convert_quantity == 1 ? 'Convert Quantity for Sale' : 'Convert Quantity Not for Sale';
            return $convert_quantity;
        }));
    }

    private function printable($request, $convert_quantities, $srch_fltr, $prnt_page_dir, $pge_title)
    {
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
        $pdf->loadView($prnt_page_dir, compact('convert_quantities', 'type', 'pge_title'));
        // $pdf->setOptions($options);

        if ($type === 'pdf') {
            return $pdf->stream($pge_title . '_x.pdf');
        } else if ($type === 'download_pdf') {
            return $pdf->download($pge_title . '_x.pdf');
        } else if ($type === 'download_excel') {
            return Excel::download(new ExcelFileCusExport($convert_quantities, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
        }
    }


}
