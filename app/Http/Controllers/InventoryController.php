<?php

namespace App\Http\Controllers;

use App\Models\InventoryModel;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function get_inventory(Request $request)
    {
        $pro_id = $request->pro_id;
//        $pro_id = '8961008212272';
        $inventory = InventoryModel::where('invt_product_id', $pro_id)->orderBy('invt_id', 'DESC')->pluck('invt_available_stock')->first();

        if($inventory ==null){
            $inventory=0;
        }

        return response()->json($inventory);
    }
}
