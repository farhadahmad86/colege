<?php

namespace App\Http\Controllers;

use App\Models\AddInventoryModel;
use App\Models\InventoryBatchModel;
use App\Models\InventoryModel;
use App\Models\ProductModel;
use App\Models\WarehouseModel;
use App\Models\WarehouseStockModel;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddInventoryController extends Controller
{
    public function add_inventory()
    {
//        $products = ProductModel::orderBy('pro_id', 'ASC')->get();

        $warehouses = WarehouseModel::orderBy('wh_title', 'ASC')->get();

        return view('add_inventory', compact('warehouses'));
//        return view('add_inventory', compact('products','warehouses'));
    }


    public function submit_add_inventory(Request $request)
    {
        $rollBack = false;
        DB::beginTransaction();

        $this->product_validation($request);

        $user_id = Auth::user()->user_id;
        $user_name = Auth::user()->user_name;

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $warehouse_id = $request->warehouse_id;
        $warehouse_name = $request->warehouse_name;

        $insert_type = $request->insert_type;


        $current_date_time = Carbon::now()->toDateTimeString();

        $batch = new InventoryBatchModel();

        $batch = $this->AssignInventoryBatchValues($request, $batch, $user_id, $user_name, $brwsr_rslt, $ip_rslt, $day_end, $warehouse_id, $warehouse_name, $insert_type,$current_date_time);


//        dd($batch);

        if (!$batch->save()) {
            $rollBack = true;
            DB::rollBack();
        }

        $inventories = [];
        $inventory = $this->AssignInventoryValues($request, $inventories, $user_id, $user_name, $brwsr_rslt, $ip_rslt, $day_end, $warehouse_id, $warehouse_name, $batch->bat_id, $insert_type,$current_date_time);

        if (!DB::table('new_new_inventory')->insert($inventory)) {
            $rollBack = true;
            DB::rollBack();
        }

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        } else {

            DB::commit();
            return redirect()->back()->with('success', 'Successfully Saved & Batch#: ' . $batch->bat_id);
        }
    }

    public function product_validation($request)
    {
        return $this->validate($request, [
            'warehouse_id' => ['required', 'numeric'],
            'products' => ['required', 'string'],
        ]);

    }


    public function AssignInventoryBatchValues($request, $batch, $user_id, $user_name, $brwsr_rslt, $ip_rslt, $day_end, $warehouse_id, $warehouse_name, $insert_type,$current_date_time)
    {
        $batch->bat_user_id = $user_id;
        $batch->bat_user_name = $user_name;
        $batch->bat_datetime = $current_date_time;
        $batch->bat_ip_add = $ip_rslt;
        $batch->bat_browser = $brwsr_rslt;
        $batch->bat_warehouse_id = $warehouse_id;
        $batch->bat_warehouse_name = $warehouse_name;
        $batch->bat_day_end_id = $day_end->de_id;
        $batch->bat_day_end_date = $day_end->de_datetime;
        $batch->bat_insert_type = $insert_type;
        $batch->bat_total_items = $request->total_items;
        $batch->bat_total_qty = $request->total_qty;
        return $batch;
    }


    public function AssignInventoryValues($request, $data, $user_id, $user_name, $brwsr_rslt, $ip_rslt, $day_end, $warehouse_id, $warehouse_name, $batch_id, $insert_type,$current_date_time)
    {
        $products = $request->products;
        $products = json_decode($products, true);

//        $user_id = Auth::user()->user_id;
//        $user_name = Auth::user()->user_name;
//
//        $brwsr_rslt = $this->getBrwsrInfo();
//        $ip_rslt = $this->getIp();
//
//        $get_day_end = new DayEndController();
//        $day_end = $get_day_end->day_end();
//
//        $warehouse_id = $request->warehouse_id;
//        $warehouse_name = $request->warehouse_name;


        foreach ($products as $key) {
            $stock = $key[1];

//            $stocks = AddInventoryModel::where('new_pro_code', $key[0])->orderBy('new_id', 'DESC')->pluck('new_stock')->first();
//
//            $stock = $stocks + $key[1];
//
//
//            if ($stocks) {
//
//                $inventory = AddInventoryModel::where('new_pro_code', $key[0])->first();
//                $inventory->new_stock = $stock;
//                $inventory->new_date_time = Carbon::now()->toDateTimeString();
//                $inventory->save();
//            } else {

            $warehouse_stock = WarehouseStockModel::where('whs_product_code', $key[0])->where('whs_warehouse_id', $warehouse_id)->orderBy('whs_id', 'DESC')->pluck('whs_stock')->first();

            $inventory_stock = InventoryModel::where('invt_product_id', $key[0])->orderBy('invt_id', 'DESC')->pluck('invt_available_stock')->first();

            $product_name = ProductModel::where('pro_code', $key[0])->pluck('pro_title')->first();

            if (!$warehouse_stock) {
                $warehouse_stock = 0;
            }

            if (!$inventory_stock) {
                $inventory_stock = 0;
            }

            if (!$product_name) {
                $product_name = '';
            }


            $data[] = ['new_pro_code' => $key[0], 'new_pro_name' => $product_name, 'new_stock' => $stock, 'new_date_time' => $current_date_time, 'new_ip_adrs' => $ip_rslt, 'new_brwsr_info' =>
                $brwsr_rslt, 'new_user_id' => $user_id, 'new_user_name' => $user_name, 'warehouse_id' => $warehouse_id, 'new_warehouse_name' => $warehouse_name, 'new_day_end_id' => $day_end->de_id,
                'new_day_end_date' => $day_end->de_datetime, 'new_curr_qty_warehouse' => $warehouse_stock, 'new_total_inventory' => $inventory_stock, 'new_batch_id' => $batch_id, 'new_insert_type' => $insert_type];
//            }

        }
        return $data;
    }

    public function add_inventory_list()
    {
//        $products = DB::table('new_new_inventory')
//            ->leftJoin('financials_products', 'financials_products.pro_code', '=', 'new_new_inventory.new_pro_code')
//            ->orderBy('new_date_time', 'DESC')
//            ->get();


        $products = AddInventoryModel::orderBy('new_date_time', 'DESC')->get();

//        dd($products);

        return view('add_inventory_list', compact('products'));
    }
}
