<?php

namespace App\Http\Controllers;

use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductClubbingController extends Controller
{
    public function product_clubbing(Request $request)
    {
        $pro_code = $request->product_code;
        $status = 0;
        $edit_products = [];
        if (isset($pro_code) && !empty($pro_code)) {
            $edit_product = ProductModel::where('pro_p_code', $pro_code)->pluck('pro_clubbing_codes')->first();

            $edit_products = explode(',', $edit_product);

            $status = 1;
        }

        $products = $this->get_products_by_type(config('global_variables.parent_product_type'));

        $product_code = '';
        $product_name = '';

        foreach ($products as $product) {
            $selected = $pro_code == $product->pro_code ? 'selected' : '';

            $product_code .= "<option value='$product->pro_p_code' $selected>$product->pro_p_code</option>";
            $product_name .= "<option value='$product->pro_p_code' $selected>$product->pro_title</option>";
        }

        return view('product_clubbing', compact('product_code', 'product_name', 'edit_products', 'status'));
    }

    public function submit_product_clubbing(Request $request)
    {
        $product = ProductModel::where('pro_p_code', $request->product_parent_code)->first();

        $child_products = $request->productsval;
        $child_products = json_decode($child_products, true);
        $delete_products = json_decode($request->delete_products, true);
        $user = Auth::User();

        $child_codes = '';

        foreach ($child_products as $child_product) {
            $child_codes .= $child_product[0] . ',';
        }

        $product->pro_clubbing_codes = rtrim($child_codes, ",");
        if ($product->save()) {

            if ($request->status == 1) {
                return redirect('product_clubbing_list')->with('success', 'Save Successfully New Barcodes Only');
            } else {
                return redirect()->back()->with('success', 'Save Successfully New Barcodes Only');
            }
        }else{
            if ($request->status == 1) {
                return redirect('product_clubbing_list')->with('fail', 'Failed Try Again!');
            } else {
                return redirect()->back()->with('fail', 'Failed Try Again!');
            }
        }
    }

    public function product_clubbing_list(Request $request, $array = null, $str = null)
    {
        $product_controller = new ProductController();

        return $product_controller->product_list($request, config('global_variables.child_product_type'), $array, $str);
    }

}
