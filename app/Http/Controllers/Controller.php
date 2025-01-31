<?php

namespace App\Http\Controllers;

use App\Models\AccountHeadsModel;
use App\Models\AccountRegisterationModel;
use App\Models\BalancesModel;
use App\Models\College\Student;
use App\Models\College\StudentBalances;
use App\Models\CreditCardMachineModel;
use App\Models\DayEndModel;
use App\Models\EntryLogModel;
use App\Models\LogModel;
use App\Models\ProductBalancesModel;
use App\Models\ProductModel;
use App\Models\StockMovementChildModel;
use App\Models\StockMovementModels;
use App\Models\WarehouseModel;
use App\Models\WarehouseStockModel;
use App\Models\WarehouseStockSummaryModel;
use App\Models\YearEndModel;
use App\Traits\RolePermissionTrait;
use App\User;
use Auth;
use Carbon\Carbon;
use DeviceDetector\Parser\Client\Browser;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use NumberToWords\NumberToWords;
use Jenssegers\Agent\Agent;
use GuzzleHttp\Client;
use Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, RolePermissionTrait;

    public function myCnvrtNbr($value)
    {
        $nbrToWrds = new NumberToWords();
        $nbrTrnsfr = $nbrToWrds->getNumberTransformer('en');
        $nbrOfWrds = $nbrTrnsfr->toWords($value);
        return $nbrOfWrds;
    }


    /////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////     Json Product     //////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////
    public function ajax_get_json_products(Request $request)
    {
//        $products = $this->get_all_products();
//        $products = json_encode($products);

        $user = Auth::user();

        $query = ProductModel::query();

        $query = DB::table('financials_products')
            ->leftJoin('financials_main_units', 'financials_main_units.mu_id', 'financials_products.pro_main_unit_id')
            ->leftJoin('financials_units', 'financials_units.unit_id', 'financials_products.pro_unit_id')
            ->where('pro_clg_id', $user->user_clg_id);

        if ($user->user_level != 100) {
//            $query->where('pro_reporting_group_id', $user->user_product_reporting_group_ids);
            $query->whereIn('pro_reporting_group_id', explode(',', $user->user_product_reporting_group_ids));

        }

        $products = $query->where('pro_status', config('global_variables.product_active_status'))
            ->where('pro_delete_status', '!=', 1)
            ->where('pro_disabled', '!=', 1)
            ->orderby('pro_title', 'ASC')
            ->select('pro_code', 'pro_p_code', 'pro_bottom_price', 'pro_last_purchase_rate', 'pro_alternative_code', 'pro_title', 'pro_purchase_price', 'pro_sale_price', 'pro_average_rate', 'pro_clubbing_codes', 'pro_tax', 'pro_retailer_discount', 'pro_whole_seller_discount', 'pro_loyalty_card_discount', 'financials_units.unit_title', 'financials_main_units.mu_title', 'financials_units.unit_scale_size')
            ->get();

//        return json_encode($products);

//        $products = json_encode($products);

        return response()->json(json_encode($products));
    }



    /////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////     Json Products for trade delivery order sale invoice By Nabeel     //////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////
    public function ajax_get_json_trade_delivery_order_sale_invoice(Request $request)
    {

        $user = Auth::user();

        $heads = explode(',', config('global_variables.payable_receivable_walk_in_customer'));
        if ($user->user_role_id == config('global_variables.teller_account_id')) {
            $account = $this->get_teller_or_purchaser_account($user->user_id);
            $wic_account = $account->user_teller_wic_account_uid;
        } else {
            $wic_account = config('global_variables.walk_in_customer');
        }
        $query = ProductModel::query();

        $query = DB::table('financials_delivery_order')
            ->rightJoin('financials_delivery_order_items', 'financials_delivery_order.do_id', 'financials_delivery_order_items.doi_invoice_id')
            ->where('do_clg_id', $user->user_clg_id)
            ->where('do_status', '=', 0)
            ->where('doi_due_qty', '!=', 0);
//

        $products = $query
            ->select('financials_delivery_order.do_id', 'financials_delivery_order.do_party_code', 'financials_delivery_order.do_party_name', 'financials_delivery_order.do_datetime')
            ->groupBy('do_id')->get();


//        return json_encode($products);

//        $products = json_encode($products);

        return response()->json(json_encode($products));
    }

/////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////     Json Products for trade sale order sale invoice By Nabeel     //////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////
    public function ajax_get_json_trade_sale_order_sale_invoice(Request $request)
    {

        $user = Auth::user();

        $heads = explode(',', config('global_variables.payable_receivable_walk_in_customer'));
        if ($user->user_role_id == config('global_variables.teller_account_id')) {
            $account = $this->get_teller_or_purchaser_account($user->user_id);
            $wic_account = $account->user_teller_wic_account_uid;
        } else {
            $wic_account = config('global_variables.walk_in_customer');
        }
        $query = ProductModel::query();

        $query = DB::table('financials_sale_order')
            ->Join('financials_sale_order_items', 'financials_sale_order.so_id', 'financials_sale_order_items.soi_invoice_id')
            ->where('so_clg_id', $user->user_clg_id)
            ->where('soi_due_qty', '!=', 0);
//
//        -> where('do_status', '!=',0)
//        -> where('doi_due_qty', '!=',0);


        $products = $query
            ->select('financials_sale_order.so_id', 'financials_sale_order.so_party_code', 'financials_sale_order.so_party_name', 'financials_sale_order.so_datetime')
            ->groupBy('so_id')->get();


//        return json_encode($products);

//        $products = json_encode($products);

        return response()->json(json_encode($products));
    }


/////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////     Json Products for trade sale order sale invoice By Nabeel     //////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////
    public function ajax_get_json_trade_sale_order_delivery_order_sale_invoice(Request $request)
    {

        $user = Auth::user();

        $heads = explode(',', config('global_variables.payable_receivable_walk_in_customer'));
        if ($user->user_role_id == config('global_variables.teller_account_id')) {
            $account = $this->get_teller_or_purchaser_account($user->user_id);
            $wic_account = $account->user_teller_wic_account_uid;
        } else {
            $wic_account = config('global_variables.walk_in_customer');
        }
        $query = ProductModel::query();

        $query = DB::table('financials_delivery_order')
            ->Join('financials_delivery_order_items', 'financials_delivery_order.do_id', 'financials_delivery_order_items.doi_invoice_id')
            ->where('do_clg_id', $user->user_clg_id)
            ->where('do_status', '!=', 0)
            ->where('doi_due_qty', '!=', 0);
//

        $products = $query
            ->select('financials_delivery_order.do_id', 'financials_delivery_order.do_party_code', 'financials_delivery_order.do_party_name', 'financials_delivery_order.do_datetime')
            ->groupBy('do_id')->get();


//        return json_encode($products);

//        $products = json_encode($products);

        return response()->json(json_encode($products));
    }


    /////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////     Json Products for trade grn purchase invoice By Nabeel     //////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////
    public function ajax_get_json_temp_purchase_invoice(Request $request)
    {

        $user = Auth::user();

        $heads = explode(',', config('global_variables.payable_receivable_walk_in_customer'));
        if ($user->user_role_id == config('global_variables.teller_account_id')) {
            $account = $this->get_teller_or_purchaser_account($user->user_id);
            $wic_account = $account->user_teller_wic_account_uid;
        } else {
            $wic_account = config('global_variables.walk_in_customer');
        }
        $query = ProductModel::query();

        $query = DB::table('financials_purchase_invoice_temp')
            ->where('pit_clg_id', $user->user_clg_id);
        // ->rightJoin('financials_purchase_invoice_items_temp', 'financials_purchase_invoice_temp.pit_id', 'financials_purchase_invoice_items_temp.pit_invoice_id')
        // ->where('grni_due_qty', '!=', 0);

        $products = $query
            ->select('financials_purchase_invoice_temp.pit_id', 'financials_purchase_invoice_temp.pit_party_code', 'financials_purchase_invoice_temp.pit_party_name', 'financials_purchase_invoice_temp.pit_datetime')
            ->groupBy('pit_id')->get();


        return response()->json(json_encode($products));
    }


    /////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////     Json Products for trade grn purchase invoice By Nabeel     //////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////
    public function ajax_get_json_trade_grn_purchase_invoice(Request $request)
    {

        $user = Auth::user();

        $heads = explode(',', config('global_variables.payable_receivable_walk_in_customer'));
        if ($user->user_role_id == config('global_variables.teller_account_id')) {
            $account = $this->get_teller_or_purchaser_account($user->user_id);
            $wic_account = $account->user_teller_wic_account_uid;
        } else {
            $wic_account = config('global_variables.walk_in_customer');
        }
        $query = ProductModel::query();

        $query = DB::table('financials_goods_receipt_note')
            ->rightJoin('financials_goods_receipt_note_items', 'financials_goods_receipt_note.grn_id', 'financials_goods_receipt_note_items.grni_invoice_id')
            ->where('grn_clg_id', $user->user_clg_id)
            ->where('grni_due_qty', '!=', 0);

        $products = $query
            ->select('financials_goods_receipt_note.grn_id', 'financials_goods_receipt_note.grn_party_code', 'financials_goods_receipt_note.grn_party_name', 'financials_goods_receipt_note.grn_datetime')
            ->groupBy('grn_id')->get();


        return response()->json(json_encode($products));
    }



    /////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////// Browser Info Related Code //////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////

    public function getBrwsrInfo()
    {
        $agnt = new Agent();
        $chk_dsktp = ($agnt->isDesktop() === TRUE) ? 'Desktop' : '';
        $chk_iphn = ($agnt->isPhone() === TRUE) ? 'iPhone' : '';
        $chk_mbl = ($agnt->isMobile() === TRUE) ? 'Mobile' : '';
        $chk_tblt = ($agnt->isTablet() === TRUE) ? 'Tablet' : '';
        $device = '';
        if (!empty($chk_dsktp)) {
            $device = $chk_dsktp;
        } elseif (!empty($chk_iphn)) {
            $device = $chk_iphn;
        } elseif (!empty($chk_mbl)) {
            $device = $chk_mbl;
        } elseif (!empty($chk_tblt)) {
            $device = $chk_tblt;
        }

        $browser = $agnt->browser();
        $browser_rslt = $device . ' Device ' . PHP_EOL . '' . $browser . ' browser | Version:- ' . $agnt->version($browser);

        return $browser_rslt;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////// Ip Related Code ////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////

    public function getIp()
    {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
    }


    /////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////// Account Head Related Code //////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////

    public function get_second_or_third_parents_heads($parent)
    {
        $user = Auth::user();
        $heads = AccountHeadsModel::where('coa_clg_id', $user->user_clg_id)->where('coa_parent', $parent)->orderBy('coa_id', 'ASC')->get();
        return $heads;
    }


    public function get_second_parent_name($child_parent)
    {
        $user = Auth::user();
        $second_parent_name = AccountHeadsModel::where('coa_clg_id', $user->user_clg_id)->where('coa_code', $child_parent)->pluck('coa_head_name')->first();

        return $second_parent_name;
    }

    public function get_third_parent_name($account_code)
    {
        $user = Auth::user();
        $third_parent = AccountHeadsModel::where('coa_clg_id', $user->user_clg_id)->where('coa_code', $account_code)->first();

        return $third_parent;
    }


    /////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////// Entry Log Related Code /////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////

    public function enter_log($remarks)
    {
        $entry_log = new EntryLogModel();

        $user = Auth::user();

        $browser = $this->getBrwsrInfo();
        $ip = $this->getIp();

        $entry_log->el_remarks = $remarks;
        $entry_log->el_user_id = $user->user_id;
        $entry_log->el_clg_id = $user->user_clg_id;
        $entry_log->el_ip = $ip;
        $entry_log->el_browser = $browser;
        $entry_log->el_datetime = Carbon::now()->toDateTimeString();

        $entry_log->save();
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////// Product Inventory Related Code /////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////

    public function AssignProductInventoryValues($array, $sign)
    {//sign 1 for add and sign 2 for subtract

        $flag = true;
        $user = Auth::User();
        foreach ($array as $key) {

            $previous_stock = ProductModel::where('pro_clg_id', $user->user_clg_id)->where('pro_p_code', $key['product_code'])->orderBy('pro_id', 'DESC')->pluck('pro_quantity')->first();

            if ($sign == 1) {
                $current_stock = $previous_stock + $key['product_qty'] + $key['product_bonus_qty'];
            } else {
                $current_stock = $previous_stock - $key['product_qty'] - $key['product_bonus_qty'];
            }

            if ($previous_stock !== null) {

                $product_inventory = ProductModel::where('pro_clg_id', $user->user_clg_id)->where('pro_p_code', $key['product_code'])->update(['pro_quantity' => $current_stock]);

                if (!$product_inventory) {
                    $flag = false;
                }
            }
        }

        return $flag;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////// Warehouse Stock Related Code ///////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////

    public function AssignWarehouseStocksSummaryValues($data, $array, $type)
    {//sign 1 for add and sign 2 for subtract

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $user = Auth::User();
        foreach ($array as $key) {
            $previous_stock = WarehouseStockSummaryModel::where('whss_clg_id', $user->user_clg_id)->where('whss_product_code', $key['product_code'])->where('whss_warehouse_id', $key['warehouse'])
                ->orderBy('whss_update_datetime',
                    'DESC')->first();;
            if ($previous_stock !== null) {
                if ($type == 'PURCHASE') {
                    $current_stock_for_in = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_out = 0;
                    $current_stock_for_hold = $previous_stock->whss_total_hold;
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus + $key['product_bonus_qty'];
                    $current_stock_for_claim = $previous_stock->whss_total_claim;
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale + $key['product_qty'];
                } elseif ($type == 'PURCHASE SALE TAX') {
                    $current_stock_for_in = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_out = 0;
                    $current_stock_for_hold = $previous_stock->whss_total_hold;
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus + $key['product_bonus_qty'];
                    $current_stock_for_claim = $previous_stock->whss_total_claim;
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale + $key['product_qty'];
                } elseif ($type == 'GOODS-RECEIPT-NOTE') {
                    $current_stock_for_in = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_out = 0;
                    $current_stock_for_hold = $previous_stock->whss_total_hold + $key['product_qty'];
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus + $key['product_bonus_qty'];
                    $current_stock_for_claim = $previous_stock->whss_total_claim;
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale;
                } elseif ($type == 'GOODS-RECEIPT-NOTE-RETURN') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $key['product_qty'] + $key['product_bonus_qty'];;
                    $current_stock_for_hold = $previous_stock->whss_total_hold - $key['product_qty'];
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus - $key['product_bonus_qty'];
                    $current_stock_for_claim = $previous_stock->whss_total_claim;
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale;
                } elseif ($type == 'GOODS-RECEIPT-NOTE-PURCHASE') {
                    $current_stock_for_in = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_out = 0;
                    $current_stock_for_hold = $previous_stock->whss_total_hold - $key['product_qty'];
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus + $key['product_bonus_qty'];
                    $current_stock_for_claim = $previous_stock->whss_total_claim;
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale + $key['product_qty'];
                } elseif ($type == 'GOODS-RECEIPT-NOTE-PURCHASE-TAX') {
                    $current_stock_for_in = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_out = 0;
                    $current_stock_for_hold = $previous_stock->whss_total_hold - $key['product_qty'];
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus + $key['product_bonus_qty'];
                    $current_stock_for_claim = $previous_stock->whss_total_claim;
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale + $key['product_qty'];
                } elseif ($type == 'PURCHASE RETURN') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_hold = $previous_stock->whss_total_hold;
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus - $key['product_bonus_qty'];
                    $current_stock_for_claim = $previous_stock->whss_total_claim;
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale - $key['product_qty'];
                } elseif ($type == 'PURCHASE TAX RETURN') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_hold = $previous_stock->whss_total_hold;
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus - $key['product_bonus_qty'];
                    $current_stock_for_claim = $previous_stock->whss_total_claim;
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale - $key['product_qty'];
                } elseif ($type == 'SALE') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_hold = $previous_stock->whss_total_hold;
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus - $key['product_bonus_qty'];
                    $current_stock_for_claim = $previous_stock->whss_total_claim;
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale - $key['product_qty'];
                } elseif ($type == 'SALE TAX') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_hold = $previous_stock->whss_total_hold;
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus - $key['product_bonus_qty'];
                    $current_stock_for_claim = $previous_stock->whss_total_claim;
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale - $key['product_qty'];
                } elseif ($type == 'DELIVERY-ORDER') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_hold = $previous_stock->whss_total_hold + $key['product_qty'];
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus + $key['product_bonus_qty'];
                    $current_stock_for_claim = $previous_stock->whss_total_claim;
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale - $key['product_qty'];
                } elseif ($type == 'SALE-ORDER') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_hold = $previous_stock->whss_total_hold + $key['product_qty'];
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus + $key['product_bonus_qty'];
                    $current_stock_for_claim = $previous_stock->whss_total_claim;
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale - $key['product_qty'];
                } elseif ($type == 'DELIVERY-ORDER-SALE') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_hold = $previous_stock->whss_total_hold - $key['product_qty'];
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    $current_stock_for_claim = $previous_stock->whss_total_claim;
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale;
                } elseif ($type == 'DELIVERY-ORDER-SALE-TAX') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_hold = $previous_stock->whss_total_hold - $key['product_qty'];
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    $current_stock_for_claim = $previous_stock->whss_total_claim;
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale;
                } elseif ($type == 'SALE-ORDER-SALE') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_hold = $previous_stock->whss_total_hold - $key['product_qty'];
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    $current_stock_for_claim = $previous_stock->whss_total_claim;
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale;
                } elseif ($type == 'SALE-ORDER-SALE-TAX') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_hold = $previous_stock->whss_total_hold - $key['product_qty'];
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    $current_stock_for_claim = $previous_stock->whss_total_claim;
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale;
                } elseif ($type == 'SALE-ORDER-DELIVERY-ORDER-SALE') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_hold = $previous_stock->whss_total_hold - $key['product_qty'];
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    $current_stock_for_claim = $previous_stock->whss_total_claim;
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale;
                } elseif ($type == 'SALE-ORDER-DELIVERY-ORDER-SALE-TAX') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_hold = $previous_stock->whss_total_hold - $key['product_qty'];
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    $current_stock_for_claim = $previous_stock->whss_total_claim;
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale;
                } elseif ($type == 'SALE RETURN') {
                    $current_stock_for_in = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_out = 0;
                    $current_stock_for_hold = $previous_stock->whss_total_hold;
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus + $key['product_bonus_qty'];
                    $current_stock_for_claim = $previous_stock->whss_total_claim;
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale + $key['product_qty'];
                } elseif ($type == 'SALE TAX RETURN') {
                    $current_stock_for_in = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_out = 0;
                    $current_stock_for_hold = $previous_stock->whss_total_hold;
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus + $key['product_bonus_qty'];
                    $current_stock_for_claim = $previous_stock->whss_total_claim;
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale + $key['product_qty'];
                } elseif ($type == 'PRODUCT RECOVER') {
                    $current_stock_for_in = $key['product_qty'];
                    $current_stock_for_out = 0;
                    $current_stock_for_hold = $previous_stock->whss_total_hold;
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    $current_stock_for_claim = $previous_stock->whss_total_claim;
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale + $key['product_qty'];
                } elseif ($type == 'PRODUCT LOSS') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $key['product_qty'];
                    $current_stock_for_hold = $previous_stock->whss_total_hold;
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    $current_stock_for_claim = $previous_stock->whss_total_claim;
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale - $key['product_qty'];
                } elseif ($type == 'PRODUCT PRODUCED') {
                    $current_stock_for_in = $key['product_qty'];
                    $current_stock_for_out = 0;
                    $current_stock_for_hold = $previous_stock->whss_total_hold;
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    $current_stock_for_claim = $previous_stock->whss_total_claim;
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale + $key['product_qty'];
                } elseif ($type == 'PRODUCT CONSUMED') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $key['product_qty'];
                    $current_stock_for_hold = $previous_stock->whss_total_hold;
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    $current_stock_for_claim = $previous_stock->whss_total_claim;
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale - $key['product_qty'];
                } elseif ($type == 'CLAIM ISSUE') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $key['product_qty'];
                    $current_stock_for_hold = $previous_stock->whss_total_hold;
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    $current_stock_for_claim = $previous_stock->whss_total_claim - $key['product_qty'];
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale;
                } elseif ($type == 'CLAIM RECEIVED') {
                    $current_stock_for_in = $key['product_qty'];
                    $current_stock_for_out = 0;
                    $current_stock_for_hold = $previous_stock->whss_total_hold;
                    $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    $current_stock_for_claim = $previous_stock->whss_total_claim + $key['product_qty'];
                    $current_stock_for_sale = $previous_stock->whss_total_for_sale;
                }

            }

            $previous_stock_type = WarehouseStockSummaryModel::where('whss_clg_id', $user->user_clg_id)->where('whss_product_code', $key['product_code'])->where('whss_type', $type)->where('whss_warehouse_id', $key['warehouse'])->orderBy('whss_id',
                'DESC')->first();


            if ($previous_stock_type !== null) {

                $inventory = WarehouseStockSummaryModel::where('whss_clg_id', $user->user_clg_id)->where('whss_product_code', $key['product_code'])->where('whss_type', $type)->where
                ('whss_warehouse_id', $key['warehouse'])->first();

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

                if ($type == 'PURCHASE') {
                    $current_stock_for_in = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_out = 0;
                    $current_stock_for_hold = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_hold = $previous_stock->whss_total_hold;
                    }
                    $current_stock_for_bonus = $key['product_bonus_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_bonus = $previous_stock->whss_total_bonus + $key['product_bonus_qty'];
                    }
                    $current_stock_for_claim = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_claim = $previous_stock->whss_total_claim;
                    }
                    $current_stock_for_sale = $key['product_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale + $key['product_qty'];
                    }
                } elseif ($type == 'PURCHASE SALE TAX') {
                    $current_stock_for_in = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_out = 0;
                    $current_stock_for_hold = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_hold = $previous_stock->whss_total_hold;
                    }
                    $current_stock_for_bonus = $key['product_bonus_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_bonus = $previous_stock->whss_total_bonus + $key['product_bonus_qty'];
                    }
                    $current_stock_for_claim = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_claim = $previous_stock->whss_total_claim;
                    }
                    $current_stock_for_sale = $key['product_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale + $key['product_qty'];
                    }
                } elseif ($type == 'GOODS-RECEIPT-NOTE') {
                    $current_stock_for_in = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_out = 0;
                    $current_stock_for_hold = $key['product_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_hold = $previous_stock->whss_total_hold + $key['product_qty'];
                    }
                    $current_stock_for_bonus = $key['product_bonus_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_bonus = $previous_stock->whss_total_bonus + $key['product_bonus_qty'];
                    }
                    $current_stock_for_claim = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_claim = $previous_stock->whss_total_claim;
                    }
                    $current_stock_for_sale = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale;
                    }
                } elseif ($type == 'GOODS-RECEIPT-NOTE-PURCHASE') {
                    $current_stock_for_in = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_out = 0;
                    $current_stock_for_hold = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_hold = $previous_stock->whss_total_hold - $key['product_qty'];
                    }
                    $current_stock_for_bonus = $key['product_bonus_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_bonus = $previous_stock->whss_total_bonus + $key['product_bonus_qty'];
                    }
                    $current_stock_for_claim = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_claim = $previous_stock->whss_total_claim;
                    }
                    $current_stock_for_sale = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale + $key['product_qty'];
                    }
                } elseif ($type == 'GOODS-RECEIPT-NOTE-PURCHASE-TAX') {
                    $current_stock_for_in = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_out = 0;
                    $current_stock_for_hold = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_hold = $previous_stock->whss_total_hold - $key['product_qty'];
                    }
                    $current_stock_for_bonus = $key['product_bonus_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_bonus = $previous_stock->whss_total_bonus + $key['product_bonus_qty'];
                    }
                    $current_stock_for_claim = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_claim = $previous_stock->whss_total_claim;
                    }
                    $current_stock_for_sale = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale + $key['product_qty'];
                    }
                } elseif ($type == 'PURCHASE RETURN') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $key['product_qty'] - $key['product_bonus_qty'];
                    $current_stock_for_hold = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_hold = $previous_stock->whss_total_hold;;
                    }
                    $current_stock_for_bonus = -$key['product_bonus_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_bonus = $previous_stock->whss_total_bonus - $key['product_bonus_qty'];
                    }
                    $current_stock_for_claim = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_claim = $previous_stock->whss_total_claim;
                    }
                    $current_stock_for_sale = -$key['product_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale - $key['product_qty'];
                    }

                } elseif ($type == 'PURCHASE TAX RETURN') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $key['product_qty'] - $key['product_bonus_qty'];
                    $current_stock_for_hold = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_hold = $previous_stock->whss_total_hold;;
                    }
                    $current_stock_for_bonus = -$key['product_bonus_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_bonus = $previous_stock->whss_total_bonus - $key['product_bonus_qty'];
                    }
                    $current_stock_for_claim = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_claim = $previous_stock->whss_total_claim;
                    }
                    $current_stock_for_sale = -$key['product_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale - $key['product_qty'];
                    }

                } elseif ($type == 'SALE') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_hold = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_hold = $previous_stock->whss_total_hold;
                    }
                    $current_stock_for_bonus = -$key['product_bonus_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_bonus = $previous_stock->whss_total_bonus - $key['product_bonus_qty'];
                    }
                    $current_stock_for_claim = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_claim = $previous_stock->whss_total_claim;
                    }
                    $current_stock_for_sale = -$key['product_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale - $key['product_qty'];
                    }

                } elseif ($type == 'SALE TAX') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_hold = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_hold = $previous_stock->whss_total_hold;
                    }
                    $current_stock_for_bonus = -$key['product_bonus_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_bonus = $previous_stock->whss_total_bonus - $key['product_bonus_qty'];
                    }
                    $current_stock_for_claim = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_claim = $previous_stock->whss_total_claim;
                    }
                    $current_stock_for_sale = -$key['product_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale - $key['product_qty'];
                    }

                } elseif ($type == 'DELIVERY-ORDER') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_hold = $key['product_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_hold = $previous_stock->whss_total_hold + $key['product_qty'];
                    }
                    $current_stock_for_bonus = -$key['product_bonus_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_bonus = $previous_stock->whss_total_bonus - $key['product_bonus_qty'];
                    }
                    $current_stock_for_claim = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_claim = $previous_stock->whss_total_claim;
                    }
                    $current_stock_for_sale = -$key['product_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale - $key['product_qty'];
                    }

                } elseif ($type == 'SALE-ORDER') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_hold = $key['product_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_hold = $previous_stock->whss_total_hold + $key['product_qty'];
                    }
                    $current_stock_for_bonus = -$key['product_bonus_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_bonus = $previous_stock->whss_total_bonus - $key['product_bonus_qty'];
                    }
                    $current_stock_for_claim = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_claim = $previous_stock->whss_total_claim;
                    }
                    $current_stock_for_sale = -$key['product_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale - $key['product_qty'];
                    }

                } elseif ($type == 'SALE-ORDER-SALE') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_hold = $key['product_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_hold = $previous_stock->whss_total_hold - $key['product_qty'];
                    }
                    $current_stock_for_bonus = -$key['product_bonus_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    }
                    $current_stock_for_claim = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_claim = $previous_stock->whss_total_claim;
                    }
                    $current_stock_for_sale = -$key['product_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale;
                    }

                } elseif ($type == 'SALE-ORDER-DELIVERY-ORDER-SALE') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_hold = $key['product_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_hold = $previous_stock->whss_total_hold - $key['product_qty'];
                    }
                    $current_stock_for_bonus = -$key['product_bonus_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    }
                    $current_stock_for_claim = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_claim = $previous_stock->whss_total_claim;
                    }
                    $current_stock_for_sale = -$key['product_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale;
                    }

                } elseif ($type == 'SALE-ORDER-SALE-TAX') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_hold = $key['product_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_hold = $previous_stock->whss_total_hold - $key['product_qty'];
                    }
                    $current_stock_for_bonus = -$key['product_bonus_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    }
                    $current_stock_for_claim = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_claim = $previous_stock->whss_total_claim;
                    }
                    $current_stock_for_sale = -$key['product_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale;
                    }

                } elseif ($type == 'SALE-ORDER-DELIVERY-ORDER-SALE-TAX') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_hold = $key['product_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_hold = $previous_stock->whss_total_hold - $key['product_qty'];
                    }
                    $current_stock_for_bonus = -$key['product_bonus_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    }
                    $current_stock_for_claim = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_claim = $previous_stock->whss_total_claim;
                    }
                    $current_stock_for_sale = -$key['product_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale;
                    }

                } elseif ($type == 'DELIVERY-ORDER-SALE') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_hold = $key['product_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_hold = $previous_stock->whss_total_hold - $key['product_qty'];
                    }
                    $current_stock_for_bonus = -$key['product_bonus_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    }
                    $current_stock_for_claim = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_claim = $previous_stock->whss_total_claim;
                    }
                    $current_stock_for_sale = -$key['product_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale;
                    }

                } elseif ($type == 'DELIVERY-ORDER-SALE-TAX') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_hold = $key['product_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_hold = $previous_stock->whss_total_hold - $key['product_qty'];
                    }
                    $current_stock_for_bonus = -$key['product_bonus_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    }
                    $current_stock_for_claim = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_claim = $previous_stock->whss_total_claim;
                    }
                    $current_stock_for_sale = -$key['product_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale;
                    }

                } elseif ($type == 'SALE RETURN') {
                    $current_stock_for_in = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_out = 0;
                    $current_stock_for_hold = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_hold = $previous_stock->whss_total_hold;;
                    }
                    $current_stock_for_bonus = $key['product_bonus_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_bonus = $previous_stock->whss_total_bonus + $key['product_bonus_qty'];
                    }
                    $current_stock_for_claim = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_claim = $previous_stock->whss_total_claim;
                    }
                    $current_stock_for_sale = $key['product_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale + $key['product_qty'];
                    }

                } elseif ($type == 'SALE TAX RETURN') {
                    $current_stock_for_in = $key['product_qty'] + $key['product_bonus_qty'];
                    $current_stock_for_out = 0;
                    $current_stock_for_hold = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_hold = $previous_stock->whss_total_hold;;
                    }
                    $current_stock_for_bonus = $key['product_bonus_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_bonus = $previous_stock->whss_total_bonus + $key['product_bonus_qty'];
                    }
                    $current_stock_for_claim = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_claim = $previous_stock->whss_total_claim;
                    }
                    $current_stock_for_sale = $key['product_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale + $key['product_qty'];
                    }

                } elseif ($type == 'PRODUCT RECOVER') {
                    $current_stock_for_in = $key['product_qty'];
                    $current_stock_for_out = 0;
                    $current_stock_for_hold = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_hold = $previous_stock->whss_total_hold;;
                    }
                    $current_stock_for_bonus = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    }
                    $current_stock_for_claim = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_claim = $previous_stock->whss_total_claim;
                    }
                    $current_stock_for_sale = $key['product_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale + $key['product_qty'];
                    }

                } elseif ($type == 'PRODUCT LOSS') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $key['product_qty'];
                    $current_stock_for_hold = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_hold = $previous_stock->whss_total_hold;;
                    }
                    $current_stock_for_bonus = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    }
                    $current_stock_for_claim = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_claim = $previous_stock->whss_total_claim;
                    }
                    $current_stock_for_sale = -$key['product_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale - $key['product_qty'];
                    }

                } elseif ($type == 'PRODUCT PRODUCED') {
                    $current_stock_for_in = $key['product_qty'];
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
                    $current_stock_for_sale = $key['product_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale + $key['product_qty'];
                    }
                } elseif ($type == 'PRODUCT CONSUMED') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $key['product_qty'];
                    $current_stock_for_hold = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_hold = $previous_stock->whss_total_hold;;
                    }
                    $current_stock_for_bonus = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    }
                    $current_stock_for_claim = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_claim = $previous_stock->whss_total_claim;
                    }
                    $current_stock_for_sale = -$key['product_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale - $key['product_qty'];
                    }

                } elseif ($type == 'CLAIM ISSUE') {
                    $current_stock_for_in = 0;
                    $current_stock_for_out = $key['product_qty'];
                    $current_stock_for_hold = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_hold = $previous_stock->whss_total_hold;;
                    }
                    $current_stock_for_bonus = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    }
                    $current_stock_for_claim = -$key['product_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_claim = $previous_stock->whss_total_claim - $key['product_qty'];
                    }
                    $current_stock_for_sale = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale;
                    }

                } elseif ($type == 'CLAIM RECEIVED') {
                    $current_stock_for_in = $key['product_qty'];
                    $current_stock_for_out = 0;
                    $current_stock_for_hold = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_hold = $previous_stock->whss_total_hold;;
                    }
                    $current_stock_for_bonus = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_bonus = $previous_stock->whss_total_bonus;
                    }
                    $current_stock_for_claim = $key['product_qty'];
                    if ($previous_stock !== null) {
                        $current_stock_for_claim = $previous_stock->whss_total_claim + $key['product_qty'];
                    }
                    $current_stock_for_sale = 0;
                    if ($previous_stock !== null) {
                        $current_stock_for_sale = $previous_stock->whss_total_for_sale;
                    }

                }


                $data[] = [
                    'whss_type' => $type,
                    'whss_product_code' => $key['product_code'],
                    'whss_product_name' => $key['product_name'],
                    'whss_qty_in' => $current_stock_for_in,
                    'whss_qty_out' => $current_stock_for_out,
                    'whss_total_hold' => $current_stock_for_hold,
                    'whss_total_bonus' => $current_stock_for_bonus,
                    'whss_total_claim' => $current_stock_for_claim,
                    'whss_total_for_sale' => $current_stock_for_sale,

                    'whss_clg_id' => $user->user_clg_id,
                    'whss_warehouse_id' => $key['warehouse'],
                    'whss_datetime' => Carbon::now()->toDateTimeString(),
                    'whss_brwsr_info' => $brwsr_rslt,
                    'whss_ip_adrs' => $ip_rslt,
                    'whss_update_datetime' => Carbon::now()->toDateTimeString()
                ];

            }
        }
        return $data;
    }

    public function AssignWarehouseStocksValues($data, $array, $sign)
    {//sign 1 for add and sign 2 for subtract

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $user = Auth::user();
        foreach ($array as $key) {

            $previous_stock = WarehouseStockModel::where('whs_clg_id', $user->user_clg_id)->where('whs_product_code', $key['product_code'])->where('whs_warehouse_id', $key['warehouse'])->orderBy('whs_id', 'DESC')->pluck('whs_stock')->first();

            if ($sign == 1) {
                $current_stock = $previous_stock + $key['product_qty'] + $key['product_bonus_qty'];
            } else {
                $current_stock = $previous_stock - $key['product_qty'] - $key['product_bonus_qty'];
            }

            if ($previous_stock !== null) {

                $inventory = WarehouseStockModel::where('whs_clg_id', $user->user_clg_id)->where('whs_product_code', $key['product_code'])->where('whs_warehouse_id', $key['warehouse'])->first();
                $inventory->whs_stock = $current_stock;
                $inventory->whs_brwsr_info = $brwsr_rslt;
                $inventory->whs_ip_adrs = $ip_rslt;
                $inventory->whs_update_datetime = Carbon::now()->toDateTimeString();
                // coding from shahzaib end

                $inventory->save();
            } else {
                $data[] = [
                    'whs_product_code' => $key['product_code'],
                    'whs_stock' => $current_stock,
                    'whs_warehouse_id' => $key['warehouse'],
                    'whs_clg_id' => $user->user_clg_id,
                    'whs_datetime' => Carbon::now()->toDateTimeString(),
                    'whs_brwsr_info' => $brwsr_rslt,
                    'whs_ip_adrs' => $ip_rslt,
                    'whs_update_datetime' => Carbon::now()->toDateTimeString()
                ];
            }
        }
        return $data;
    }

    public function AssignWarehouseStocksValuesForProduction($data, $array, $sign)
    {//sign 1 for add and sign 2 for subtract

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $user = Auth::user();
        foreach ($array as $key) {

            $previous_stock = WarehouseStockModel::where('whs_clg_id', $user->user_clg_id)->where('whs_product_code', $key['product_code'])->where('whs_warehouse_id', $key['warehouse'])->orderBy('whs_id', 'DESC')->pluck('whs_stock')->first();

            if ($sign == 1) {
                $current_stock = $previous_stock + $key['product_qty'];
            } else {
                $current_stock = $previous_stock - $key['product_qty'];
            }

            if ($previous_stock !== null) {

                $inventory = WarehouseStockModel::where('whs_clg_id', $user->user_clg_id)->where('whs_product_code', $key['product_code'])->where('whs_warehouse_id', $key['warehouse'])->first();
                $inventory->whs_stock = $current_stock;
                $inventory->whs_brwsr_info = $brwsr_rslt;
                $inventory->whs_ip_adrs = $ip_rslt;
                $inventory->whs_update_datetime = Carbon::now()->toDateTimeString();
                // coding from shahzaib end

                $inventory->save();
            } else {

                $data[] = [
                    'whs_product_code' => $key['product_code'],
                    'whs_stock' => $current_stock,
                    'whs_warehouse_id' => $key['warehouse'],
                    'whs_clg_id' => $user->user_clg_id,
                    'whs_datetime' => Carbon::now()->toDateTimeString(),
                    'whs_brwsr_info' => $brwsr_rslt,
                    'whs_ip_adrs' => $ip_rslt,
                    'whs_update_datetime' => Carbon::now()->toDateTimeString()
                ];
            }
        }
        return $data;
    }

//    public function AssignProductBalancesValues($array, $data, $account_uid, $account_name, $invoice_id, $sign, $notes)
//    {//sign 1 for add and sign 2 for subtract
//        $user = Auth::user();
//
//        $get_day_end = new DayEndController();
//        $day_end = $get_day_end->day_end();
//
//        $brwsr_rslt = $this->getBrwsrInfo();
//        $ip_rslt = $this->getIp();
//
//        foreach ($array as $key) {
//
//            $pro_code = $key['product_code'];
//            $pro_name = ucwords($key['product_name']);
//            $qty = $key['product_qty'];
//            $amount = $key['product_amount'];
//
//            $product_stock_balance = $this->calculate_product_stock_balances($pro_code);
//            $product_amount_balance = $this->calculate_product_amount_balances($pro_code);
//
//            if ($sign == 1) {
//
//                $product_stock_balance += $qty;
//                $product_amount_balance += $amount;
//                $inward_qty = $qty;
//                $outward_qty = 0;
//                $inward_amount = $amount;
//                $outward_amount = 0;
//            } else {
//
//                $product_stock_balance -= $qty;
//                $product_amount_balance -= $amount;
//                $inward_qty = 0;
//                $outward_qty = $qty;
//                $inward_amount = 0;
//                $outward_amount = $amount;
//            }
//
//            $data[] = [
//                'pb_p_code' => $pro_code,
//                'pb_p_name' => $pro_name,
//                'pb_acccount_uid' => $account_uid,
//                'pb_account_name' => $account_name,
//                'pb_s_inward' => $inward_qty,
//                'pb_s_outward' => $outward_qty,
//                'pb_s_balance' => $product_stock_balance,
//                'pb_amount_inward' => $inward_amount,
//                'pb_amount_outward' => $outward_amount,
//                'pb_amount_balance' => $product_amount_balance,
//                'pb_notes' => $notes,
//                'pb_voucher_number' => $invoice_id,
//                'pb_createdby' => $user->user_id,
//                'pb_datetime' => Carbon::now()->toDateTimeString(),
//                'pb_dayend_id' => $day_end->de_id,
//                'pb_dayend_date' => $day_end->de_datetime,
//                'pb_brwsr_info' => $brwsr_rslt,
//                'pb_ip_adrs' => $ip_rslt,
//                'pb_update_datetime' => Carbon::now()->toDateTimeString()
//            ];
//        }
//
//        return $data;
//    }

//    public function stock_movement_module($array, $voucher_code, $invoice_type, $invoice_type_text)
//    {// 1 means purchase, 2 means purchase return, 3 means sale and 4 means sale return
//        $flag = true;
//
//        $user_id = Auth::user()->user_id;
//
//        $get_day_end = new DayEndController();
//        $day_end = $get_day_end->day_end();
//
//        $day_end_id = $day_end->de_id;
//        $day_end_date = $day_end->de_datetime;
//        $datetime = Carbon::now()->toDateTimeString();
//
//        foreach ($array as $value) {
//            $product_code = $value['product_code'];
//            $product_name = $value['product_name'];
//
//            $previous_stock = $this->product_stock_movement_last_row($product_code);
//
//            if ($previous_stock !== null) {
//                $previous_bal_qty_for_sale = $previous_stock->sm_bal_qty_for_sale;
//                $previous_bal_rate = $previous_stock->sm_bal_rate;
//                $previous_bal_total = $previous_stock->sm_bal_total;
//                $previous_bal_bonus_qty = $previous_stock->sm_bal_bonus_qty;
//                $previous_bal_total_hold = $previous_stock->sm_bal_total_hold;
//                $previous_bal_claims = $previous_stock->sm_bal_claims;
//            }
//
//
//            $in_qty = $value['product_qty'];
//            $in_bonus = $value['product_bonus_qty'];
//            $in_rate = $value['product_rate'];
//            $in_total = $in_qty * $in_rate;
//
//
//            $out_qty = $value['product_qty'];
//            $out_bonus = $value['product_bonus_qty'];
//            $out_rate = $value['product_rate'];
//            $out_total = $out_qty * $out_rate;
//
//
//            $internal_hold = $value['product_hold_qty'];
//            $internal_bonus = $value['product_bonus_qty'];
//            $internal_claim = $value['product_claim_qty'];
//
//            $bal_qty_for_sale = $previous_bal_qty_for_sale + $in_qty - $out_qty - $internal_claim - $internal_bonus - $internal_hold;
//
//            $bal_bonus_inward = $value['product_bonus_qty'];
//            $bal_bonus_outward = $value['product_bonus_qty'];
//            $bal_bonus_qty = $previous_bal_bonus_qty + $bal_bonus_inward - $bal_bonus_outward + $internal_bonus;
//
//            $bal_hold = $internal_hold;
//            $bal_total_hold = $previous_bal_total_hold + $bal_hold;
//
//            $bal_claims = $previous_bal_claims + $internal_claim;
//
//            $bal_total_qty_wo_bonus = $bal_qty_for_sale + $bal_total_hold + $bal_claims;
//            $bal_total_qty = $bal_qty_for_sale + $bal_bonus_qty + $bal_total_hold + $bal_claims;
//            $bal_rate = ($previous_bal_total + $in_total) / ($bal_total_qty_wo_bonus + $in_rate);
//            $bal_total = $bal_total_qty_wo_bonus * $bal_rate;
//
//
//            $remarks = '';
//
//
//            $stock_movement = new StockMovementModels();
//
//            $stock_movement->sm_type = $product_code;
//            $stock_movement->sm_product_code = $product_code;
//            $stock_movement->sm_product_name = $product_name;
//
//            $stock_movement->sm_in_qty = $in_qty;
//            $stock_movement->sm_in_bonus = $in_bonus;
//            $stock_movement->sm_in_rate = $in_rate;
//            $stock_movement->sm_in_total = $in_total;
//
//            $stock_movement->sm_out_qty = $out_qty;
//            $stock_movement->sm_out_bonus = $out_bonus;
//            $stock_movement->sm_out_rate = $out_rate;
//            $stock_movement->sm_out_total = $out_total;
//
//            $stock_movement->sm_internal_hold = $internal_hold;
//            $stock_movement->sm_internal_bonus = $internal_bonus;
//            $stock_movement->sm_internal_claim = $internal_claim;
//
//            $stock_movement->sm_bal_qty_for_sale = $bal_qty_for_sale;
//
//            $stock_movement->sm_bal_bonus_inward = $bal_bonus_inward;
//            $stock_movement->sm_bal_bonus_outward = $bal_bonus_outward;
//            $stock_movement->sm_bal_bonus_qty = $bal_bonus_qty;
//
//            $stock_movement->sm_bal_hold = $bal_hold;
//            $stock_movement->sm_bal_total_hold = $bal_total_hold;
//
//            $stock_movement->sm_bal_claims = $bal_claims;
//
//            $stock_movement->sm_bal_total_qty_wo_bonus = $bal_total_qty_wo_bonus;
//            $stock_movement->sm_bal_total_qty = $bal_total_qty;
//            $stock_movement->sm_bal_rate = $bal_rate;
//            $stock_movement->sm_bal_total = $bal_total;
//
//            $stock_movement->sm_day_end_id = $day_end_id;
//            $stock_movement->sm_day_end_date = $day_end_date;
//            $stock_movement->sm_voucher_code = $voucher_code;
//            $stock_movement->sm_remarks = $remarks;
//            $stock_movement->sm_user_id = $user_id;
//            $stock_movement->sm_date_time = $datetime;
//
//
//            if ($stock_movement->save()) {
//
//            } else {
//                $flag = false;
//            }
//        }
//
//        return $flag;
//    }

    /////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////// Stock Movement Child Related Code ////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////
    public function stock_movement_child($array, $invoice_id, $account_code, $account_name, $invoice_type)
    {
        $user = Auth::user();
        $flag = true;
        foreach ($array as $value) {
            $product_code = $value['product_code'];
            $product_name = $value['product_name'];

            $previous_stock = $this->product_stock_movement_last_row($product_code);
            $movement_child = new StockMovementChildModel();
            $movement_child->smc_sm_id = $previous_stock->sm_id;
            $movement_child->smc_party_code = $account_code;
            $movement_child->smc_party_name = $account_name;
            $movement_child->smc_invoice_type = $invoice_type;
            $movement_child->smc_invoice_id = $invoice_id;
            $movement_child->smc_invoice_id = $invoice_id;
            $movement_child->smc_clg_id = $user->user_clg_id;
//            $movement_child->save();

            if (!$movement_child->save()) {
                $flag = false;
            }
        }

        return $flag;
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////// Stock Movement Related Code ////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////// For Purchase //////////////////////////////////////////////////////////
    public function stock_movement_module_grn_purchase($array, $voucher_code, $invoice_type_text, $remarks)
    {
        $flag = true;

        foreach ($array as $value) {
            $product_code = $value['product_code'];
            $product_name = $value['product_name'];

            $previous_stock = $this->product_stock_movement_last_row($product_code);

            if ($previous_stock !== null) {
                $previous_bal_qty_for_sale = $previous_stock->sm_bal_qty_for_sale;
                $previous_bal_rate = $previous_stock->sm_bal_rate;
                $previous_bal_total = $previous_stock->sm_bal_total;
                $previous_bal_bonus_qty = $previous_stock->sm_bal_bonus_qty;
                $previous_bal_total_hold = $previous_stock->sm_bal_total_hold;
                $previous_bal_claims = $previous_stock->sm_bal_claims;
                $previous_bal_total_qty_wo_bonus = $previous_stock->sm_bal_total_qty_wo_bonus;
                $previous_sm_bal_total_qty = $previous_stock->sm_bal_total_qty;
            } else {
                $previous_bal_qty_for_sale = 0;
                $previous_bal_rate = 0;
                $previous_bal_total = 0;
                $previous_bal_bonus_qty = 0;
                $previous_bal_total_hold = 0;
                $previous_bal_claims = 0;
            }

            $in_qty = $value['product_qty'];
            $in_bonus = $value['product_bonus_qty'];
            $in_rate = $value['product_rate'];
            $in_total = $in_qty * $in_rate;

            $out_qty = null;
            $out_bonus = null;
            $out_rate = null;
            $out_total = $out_qty * $out_rate;

            $internal_hold = null;
            $internal_bonus = null;
            $internal_claim = null;

            $bal_qty_for_sale = $previous_bal_qty_for_sale + $in_qty - $out_qty - $internal_claim - $internal_bonus - $internal_hold;

            $bal_bonus_inward = $in_bonus;
            $bal_bonus_outward = $out_bonus;
            $bal_bonus_qty = $previous_bal_bonus_qty + $bal_bonus_inward - $bal_bonus_outward + $internal_bonus;

            $bal_hold = $internal_hold;
//            $bal_total_hold = $previous_bal_total_hold + $bal_hold;
            $bal_total_hold = $previous_bal_total_hold - $in_qty;

            $bal_claims = $previous_bal_claims + $internal_claim;

//            $bal_total_qty_wo_bonus = $bal_qty_for_sale + $bal_total_hold + $bal_claims;
            $bal_total_qty_wo_bonus = $bal_qty_for_sale + $bal_total_hold + $bal_claims;
            $bal_total_qty = $previous_sm_bal_total_qty;
//            $bal_total_qty = $bal_qty_for_sale + $bal_bonus_qty + $bal_total_hold + $bal_claims;


            /**
             * Check-Is-Stock-Negative-Positive, Get-Total-Quantity variables start
             * By Shahzaib Coding
             */
            $checkIsStockNegOrPos = 0;
            $getTotalQuantity = 0;
            /**
             * Check-Is-Stock-Negative-Positive, Get-Total-Quantity variables end
             * By Shahzaib Coding
             */

            /**
             * Quantity Control Condition start
             * By Shahzaib Coding
             */
            if ($previous_bal_total_qty_wo_bonus < 0) {
                $checkIsStockNegOrPos = +($previous_bal_total_qty_wo_bonus) + +($in_qty);
                $getTotalQuantity = $checkIsStockNegOrPos;
            } else {
                /**
                 * This Commit line for sale transaction purpose
                 * $checkIsStockNegOrPos = +($previous_bal_total_qty_wo_bonus) - +($in_qty);
                 */
                $checkIsStockNegOrPos = +($previous_bal_total_qty_wo_bonus) + +($in_qty);
                $getTotalQuantity = $checkIsStockNegOrPos;
            }
            /**
             * Quantity Control Condition else
             * By Shahzaib Coding
             */


            /**
             * Check-Stock-Valuation variables start
             * By Shahzaib Coding
             */
            if (intval($getTotalQuantity) !== 0) {
                $checkValuation = ($previous_bal_total + $in_total) / $getTotalQuantity;
            } else {
                $checkValuation = 0;
            }
            /**
             * Check-Stock-Valuation variables end
             * By Shahzaib Coding
             */


            /**
             * Get Balance Rate Condition start
             * By Shahzaib Coding
             */
            if ($previous_bal_total > 0) {
                $bal_rate = ($previous_bal_total + $in_total) / $getTotalQuantity;
            } else if ($previous_bal_total <= 0 || $checkValuation === 0) {
                $bal_rate = $in_rate;
            } else {
                $bal_rate = ($previous_bal_total + $in_total) / $getTotalQuantity;
            }

            /* previous if statement
            if (($previous_bal_total_qty_wo_bonus + $in_qty) == 0) {
                $bal_rate = ($previous_bal_total + $in_total);
            }
            $bal_rate = ($previous_bal_total + $in_total) / ($previous_bal_total_qty_wo_bonus + $in_qty);
            */
            /**
             * Get Balance Rate Condition end
             * By Shahzaib Coding
             */


            /**
             * Get Balance Total Condition start
             * By Shahzaib Coding
             */
            if ($getTotalQuantity < 0) {
                $bal_total = 0;
            } else {
                $bal_total = $bal_total_qty_wo_bonus * $bal_rate;
            }
            /**
             * Get Balance Total Condition end
             * By Shahzaib Coding
             */

            $stock_movement = new StockMovementModels();

            $stock_movement_values = [
                'type_of_invoice' => $invoice_type_text,
                'product_code' => $product_code,
                'product_name' => $product_name,
                'in_qty' => $in_qty,
                'in_bonus' => $in_bonus,
                'in_rate' => $in_rate,
                'in_total' => $in_total,
                'out_qty' => $out_qty,
                'out_bonus' => $out_bonus,
                'out_rate' => $out_rate,
                'out_total' => $out_total,
                'internal_hold' => $internal_hold,
                'internal_bonus' => $internal_bonus,
                'internal_claim' => $internal_claim,
                'bal_qty_for_sale' => $bal_qty_for_sale,
                'bal_bonus_inward' => $bal_bonus_inward,
                'bal_bonus_outward' => $bal_bonus_outward,
                'bal_bonus_qty' => $bal_bonus_qty,
                'bal_hold' => $bal_hold,
                'bal_total_hold' => $bal_total_hold,
                'bal_claims' => $bal_claims,
                'bal_total_qty_wo_bonus' => $bal_total_qty_wo_bonus,
                'bal_total_qty' => $bal_total_qty,
                'bal_rate' => $bal_rate,
                'bal_total' => $bal_total,
                'bal_voucher_code' => $voucher_code,
                'bal_remarks' => $remarks,
            ];


            $stock_movement = $this->stock_movement_values($stock_movement_values, $stock_movement);

            if (!$stock_movement->save()) {
                $flag = false;
            }
        }

        return $flag;
    }

    ///////////////////////////////////////////////////// For Produced //////////////////////////////////////////////////////////
    public function stock_movement_module_produced($array, $voucher_code, $invoice_type_text, $remarks)
    {

        $flag = true;

        foreach ($array as $value) {
            $product_code = $value['product_code'];
            $product_name = $value['product_name'];
            $warehouse = $value['warehouse'];

            $previous_stock = $this->product_stock_movement_last_row($product_code);

            if ($previous_stock !== null) {
                $previous_bal_qty_for_sale = $previous_stock->sm_bal_qty_for_sale;
                $previous_bal_rate = $previous_stock->sm_bal_rate;
                $previous_bal_total = $previous_stock->sm_bal_total;
                $previous_bal_bonus_qty = $previous_stock->sm_bal_bonus_qty;
                $previous_bal_total_hold = $previous_stock->sm_bal_total_hold;
                $previous_bal_claims = $previous_stock->sm_bal_claims;
                $previous_bal_total_qty_wo_bonus = $previous_stock->sm_bal_total_qty_wo_bonus;
            } else {
                $previous_bal_qty_for_sale = 0;
                $previous_bal_rate = 0;
                $previous_bal_total = 0;
                $previous_bal_bonus_qty = 0;
                $previous_bal_total_hold = 0;
                $previous_bal_claims = 0;
            }

            $in_qty = $value['product_qty'];
            $in_bonus = $value['product_bonus_qty'];
            $in_rate = $value['product_rate'];
            $in_total = $in_qty * $in_rate;

            $out_qty = null;
            $out_bonus = null;
            $out_rate = null;
            $out_total = $out_qty * $out_rate;

            $internal_hold = null;
            $internal_bonus = null;
            $internal_claim = null;

            $bal_qty_for_sale = $previous_bal_qty_for_sale + $in_qty - $out_qty - $internal_claim - $internal_bonus - $internal_hold;

            $bal_bonus_inward = $in_bonus;
            $bal_bonus_outward = $out_bonus;
            $bal_bonus_qty = $previous_bal_bonus_qty + $bal_bonus_inward - $bal_bonus_outward + $internal_bonus;

            $bal_hold = $internal_hold;
            $bal_total_hold = $previous_bal_total_hold + $bal_hold;

            $bal_claims = $previous_bal_claims + $internal_claim;

            $bal_total_qty_wo_bonus = $bal_qty_for_sale + $bal_total_hold + $bal_claims;
            $bal_total_qty = $bal_qty_for_sale + $bal_bonus_qty + $bal_total_hold + $bal_claims;


            /**
             * Check-Is-Stock-Negative-Positive, Get-Total-Quantity variables start
             * By Shahzaib Coding
             */
            $checkIsStockNegOrPos = 0;
            $getTotalQuantity = 0;
            /**
             * Check-Is-Stock-Negative-Positive, Get-Total-Quantity variables end
             * By Shahzaib Coding
             */

            /**
             * Quantity Control Condition start
             * By Shahzaib Coding
             */

            if ($previous_bal_total_qty_wo_bonus < 0) {
                $checkIsStockNegOrPos = +($previous_bal_total_qty_wo_bonus) + +($in_qty);
                $getTotalQuantity = $checkIsStockNegOrPos;
            } else {
                /**
                 * This Commit line for sale transaction purpose
                 * $checkIsStockNegOrPos = +($previous_bal_total_qty_wo_bonus) - +($in_qty);
                 */
                $checkIsStockNegOrPos = +($previous_bal_total_qty_wo_bonus) + +($in_qty);
                $getTotalQuantity = $checkIsStockNegOrPos;
            }
            /**
             * Quantity Control Condition else
             * By Shahzaib Coding
             */


            /**
             * Check-Stock-Valuation variables start
             * By Shahzaib Coding
             */
            if (intval($getTotalQuantity) !== 0) {
                $checkValuation = ($previous_bal_total + $in_total) / $getTotalQuantity;
            } else {
                $checkValuation = 0;
            }
            /**
             * Check-Stock-Valuation variables end
             * By Shahzaib Coding
             */


            /**
             * Get Balance Rate Condition start
             * By Shahzaib Coding
             */


            if ($previous_bal_total > 0) {
                $bal_rate = ($previous_bal_total + $in_total) / $getTotalQuantity;
            } else if ($previous_bal_total <= 0 || $checkValuation === 0) {
                $bal_rate = $in_rate;
            } else {
                $bal_rate = ($previous_bal_total + $in_total) / $getTotalQuantity;
            }

            /* previous if statement
            if (($previous_bal_total_qty_wo_bonus + $in_qty) == 0) {
                $bal_rate = ($previous_bal_total + $in_total);
            }
            $bal_rate = ($previous_bal_total + $in_total) / ($previous_bal_total_qty_wo_bonus + $in_qty);
            */
            /**
             * Get Balance Rate Condition end
             * By Shahzaib Coding
             */


            /**
             * Get Balance Total Condition start
             * By Shahzaib Coding
             */


            if ($getTotalQuantity < 0) {

                $bal_total = 0;
            } else {
                $bal_total = $bal_total_qty_wo_bonus * $bal_rate;
//                $this->invoice_total_value += $bal_rate * $in_qty;
            }

            /**
             * Get Balance Total Condition end
             * By Shahzaib Coding
             */

            $stock_movement = new StockMovementModels();

            $stock_movement_values = [
                'type_of_invoice' => $invoice_type_text,
                'product_code' => $product_code,
                'product_name' => $product_name,
                'warehouse' => $warehouse,
                'in_qty' => $in_qty,
                'in_bonus' => $in_bonus,
                'in_rate' => $in_rate,
                'in_total' => $in_total,
                'out_qty' => $out_qty,
                'out_bonus' => $out_bonus,
                'out_rate' => $out_rate,
                'out_total' => $out_total,
                'internal_hold' => $internal_hold,
                'internal_bonus' => $internal_bonus,
                'internal_claim' => $internal_claim,
                'bal_qty_for_sale' => $bal_qty_for_sale,
                'bal_bonus_inward' => $bal_bonus_inward,
                'bal_bonus_outward' => $bal_bonus_outward,
                'bal_bonus_qty' => $bal_bonus_qty,
                'bal_hold' => $bal_hold,
                'bal_total_hold' => $bal_total_hold,
                'bal_claims' => $bal_claims,
                'bal_total_qty_wo_bonus' => $bal_total_qty_wo_bonus,
                'bal_total_qty' => $bal_total_qty,
                'bal_rate' => $bal_rate,
                'bal_total' => $bal_total,
                'bal_voucher_code' => $voucher_code,
                'bal_remarks' => $remarks,
            ];


            $stock_movement = $this->stock_movement_values($stock_movement_values, $stock_movement);

            if (!$stock_movement->save()) {
                $flag = false;
            }
        }

        return $flag;
    }

    ///////////////////////////////////////////////////// For Purchase //////////////////////////////////////////////////////////
    public function stock_movement_module_purchase($array, $voucher_code, $invoice_type_text, $remarks)
    {

        $flag = true;

        foreach ($array as $value) {
            $product_code = $value['product_code'];
            $product_name = $value['product_name'];
            $warehouse = $value['warehouse'];

            $previous_stock = $this->product_stock_movement_last_row($product_code);

            if ($previous_stock !== null) {
                $previous_bal_qty_for_sale = $previous_stock->sm_bal_qty_for_sale;
                $previous_bal_rate = $previous_stock->sm_bal_rate;
                $previous_bal_total = $previous_stock->sm_bal_total;
                $previous_bal_bonus_qty = $previous_stock->sm_bal_bonus_qty;
                $previous_bal_total_hold = $previous_stock->sm_bal_total_hold;
                $previous_bal_claims = $previous_stock->sm_bal_claims;
                $previous_bal_total_qty_wo_bonus = $previous_stock->sm_bal_total_qty_wo_bonus;
            } else {
                $previous_bal_qty_for_sale = 0;
                $previous_bal_rate = 0;
                $previous_bal_total = 0;
                $previous_bal_bonus_qty = 0;
                $previous_bal_total_hold = 0;
                $previous_bal_claims = 0;
            }

            $in_qty = $value['product_qty'];
            $in_bonus = $value['product_bonus_qty'];
            $in_rate = $value['product_rate'];
            $in_total = $in_qty * $in_rate;

            $out_qty = null;
            $out_bonus = null;
            $out_rate = null;
            $out_total = $out_qty * $out_rate;

            $internal_hold = null;
            $internal_bonus = null;
            $internal_claim = null;

            $bal_qty_for_sale = $previous_bal_qty_for_sale + $in_qty - $out_qty - $internal_claim - $internal_bonus - $internal_hold;

            $bal_bonus_inward = $in_bonus;
            $bal_bonus_outward = $out_bonus;
            $bal_bonus_qty = $previous_bal_bonus_qty + $bal_bonus_inward - $bal_bonus_outward + $internal_bonus;

            $bal_hold = $internal_hold;
            $bal_total_hold = $previous_bal_total_hold + $bal_hold;

            $bal_claims = $previous_bal_claims + $internal_claim;

            $bal_total_qty_wo_bonus = $bal_qty_for_sale + $bal_total_hold + $bal_claims;
            $bal_total_qty = $bal_qty_for_sale + $bal_bonus_qty + $bal_total_hold + $bal_claims;


            /**
             * Check-Is-Stock-Negative-Positive, Get-Total-Quantity variables start
             * By Shahzaib Coding
             */
            $checkIsStockNegOrPos = 0;
            $getTotalQuantity = 0;
            /**
             * Check-Is-Stock-Negative-Positive, Get-Total-Quantity variables end
             * By Shahzaib Coding
             */

            /**
             * Quantity Control Condition start
             * By Shahzaib Coding
             */

            if ($previous_bal_total_qty_wo_bonus < 0) {
                $checkIsStockNegOrPos = +($previous_bal_total_qty_wo_bonus) + +($in_qty);
                $getTotalQuantity = $checkIsStockNegOrPos;
            } else {
                /**
                 * This Commit line for sale transaction purpose
                 * $checkIsStockNegOrPos = +($previous_bal_total_qty_wo_bonus) - +($in_qty);
                 */
                $checkIsStockNegOrPos = +($previous_bal_total_qty_wo_bonus) + +($in_qty);
                $getTotalQuantity = $checkIsStockNegOrPos;
            }
            /**
             * Quantity Control Condition else
             * By Shahzaib Coding
             */


            /**
             * Check-Stock-Valuation variables start
             * By Shahzaib Coding
             */
            if (intval($getTotalQuantity) !== 0) {
                $checkValuation = ($previous_bal_total + $in_total) / $getTotalQuantity;
            } else {
                $checkValuation = 0;
            }
            /**
             * Check-Stock-Valuation variables end
             * By Shahzaib Coding
             */


            /**
             * Get Balance Rate Condition start
             * By Shahzaib Coding
             */


            if ($previous_bal_total > 0) {
                $bal_rate = ($previous_bal_total + $in_total) / $getTotalQuantity;
            } else if ($previous_bal_total <= 0 || $checkValuation === 0) {
                $bal_rate = $in_rate;
            } else {
                $bal_rate = ($previous_bal_total + $in_total) / $getTotalQuantity;
            }

            /* previous if statement
            if (($previous_bal_total_qty_wo_bonus + $in_qty) == 0) {
                $bal_rate = ($previous_bal_total + $in_total);
            }
            $bal_rate = ($previous_bal_total + $in_total) / ($previous_bal_total_qty_wo_bonus + $in_qty);
            */
            /**
             * Get Balance Rate Condition end
             * By Shahzaib Coding
             */


            /**
             * Get Balance Total Condition start
             * By Shahzaib Coding
             */


            if ($getTotalQuantity < 0) {

                $bal_total = 0;
            } else {
                $bal_total = $bal_total_qty_wo_bonus * $bal_rate;
                $this->invoice_total_value += $bal_rate * $in_qty;
            }

            /**
             * Get Balance Total Condition end
             * By Shahzaib Coding
             */

            $stock_movement = new StockMovementModels();

            $stock_movement_values = [
                'type_of_invoice' => $invoice_type_text,
                'product_code' => $product_code,
                'product_name' => $product_name,
                'warehouse' => $warehouse,
                'in_qty' => $in_qty,
                'in_bonus' => $in_bonus,
                'in_rate' => $in_rate,
                'in_total' => $in_total,
                'out_qty' => $out_qty,
                'out_bonus' => $out_bonus,
                'out_rate' => $out_rate,
                'out_total' => $out_total,
                'internal_hold' => $internal_hold,
                'internal_bonus' => $internal_bonus,
                'internal_claim' => $internal_claim,
                'bal_qty_for_sale' => $bal_qty_for_sale,
                'bal_bonus_inward' => $bal_bonus_inward,
                'bal_bonus_outward' => $bal_bonus_outward,
                'bal_bonus_qty' => $bal_bonus_qty,
                'bal_hold' => $bal_hold,
                'bal_total_hold' => $bal_total_hold,
                'bal_claims' => $bal_claims,
                'bal_total_qty_wo_bonus' => $bal_total_qty_wo_bonus,
                'bal_total_qty' => $bal_total_qty,
                'bal_rate' => $bal_rate,
                'bal_total' => $bal_total,
                'bal_voucher_code' => $voucher_code,
                'bal_remarks' => $remarks,
            ];


            $stock_movement = $this->stock_movement_values($stock_movement_values, $stock_movement);

            if (!$stock_movement->save()) {
                $flag = false;
            }
        }

        return $flag;
    }

    ///////////////////////////////////////////////////// For Purchase Return //////////////////////////////////////////////////////////
    public function stock_movement_module_purchase_return($array, $voucher_code, $invoice_type_text, $remarks)
    {
        $flag = true;

        foreach ($array as $value) {
            $product_code = $value['product_code'];
            $product_name = $value['product_name'];
            $warehouse = $value['warehouse'];

            $previous_stock = $this->product_stock_movement_last_row($product_code);

            if ($previous_stock !== null) {
                $previous_bal_qty_for_sale = $previous_stock->sm_bal_qty_for_sale;
                $previous_bal_rate = $previous_stock->sm_bal_rate;
                $previous_bal_total = $previous_stock->sm_bal_total;
                $previous_bal_bonus_qty = $previous_stock->sm_bal_bonus_qty;
                $previous_bal_total_hold = $previous_stock->sm_bal_total_hold;
                $previous_bal_claims = $previous_stock->sm_bal_claims;
                $previous_bal_total_qty_wo_bonus = $previous_stock->sm_bal_total_qty_wo_bonus;
            } else {
                $previous_bal_qty_for_sale = 0;
                $previous_bal_rate = 0;
                $previous_bal_total = 0;
                $previous_bal_bonus_qty = 0;
                $previous_bal_total_hold = 0;
                $previous_bal_claims = 0;
            }

            $in_qty = null;
            $in_bonus = null;
            $in_rate = null;
            $in_total = $in_qty * $in_rate;

            $out_qty = $value['product_qty'];
            $out_bonus = $value['product_bonus_qty'];
            $out_rate = $value['product_rate'];
            $out_total = $out_qty * $out_rate;

            $internal_hold = null;
            $internal_bonus = null;
            $internal_claim = null;

            $bal_qty_for_sale = $previous_bal_qty_for_sale + $in_qty - $out_qty - $internal_claim - $internal_bonus - $internal_hold;

            $bal_bonus_inward = $in_bonus;
            $bal_bonus_outward = $out_bonus;
            $bal_bonus_qty = $previous_bal_bonus_qty + $bal_bonus_inward - $bal_bonus_outward + $internal_bonus;

            $bal_hold = $internal_hold;
            $bal_total_hold = $previous_bal_total_hold + $bal_hold;

            $bal_claims = $previous_bal_claims + $internal_claim;

            $bal_total_qty_wo_bonus = $bal_qty_for_sale + $bal_total_hold + $bal_claims;
            $bal_total_qty = $bal_qty_for_sale + $bal_bonus_qty + $bal_total_hold + $bal_claims;

            // if (($previous_bal_total_qty_wo_bonus + $out_total) == 0) {
            //     $bal_rate = ($previous_bal_total - $out_total);
            // } else {
            //     $bal_rate = ($previous_bal_total - $out_total) / ($previous_bal_total_qty_wo_bonus - $out_qty);
            // }

//            $bal_rate = ($previous_bal_total - $out_total) / ($previous_bal_total_qty_wo_bonus - $out_qty);


            /**
             * Check-Is-Stock-Negative-Positive, Get-Total-Quantity variables start
             * By Shahzaib Coding
             */
            $checkIsStockNegOrPos = 0;
            $getTotalQuantity = 0;
            /**
             * Check-Is-Stock-Negative-Positive, Get-Total-Quantity variables end
             * By Shahzaib Coding
             */

            /**
             * Quantity Control Condition start
             * By Shahzaib Coding
             */
            if ($previous_bal_total_qty_wo_bonus < 0) {
                $checkIsStockNegOrPos = +($previous_bal_total_qty_wo_bonus) + +($out_qty);
                $getTotalQuantity = $checkIsStockNegOrPos;
            } else {
                /**
                 * This Commit line for sale transaction purpose
                 * $checkIsStockNegOrPos = +($previous_bal_total_qty_wo_bonus) - +($out_qty);
                 */
                $checkIsStockNegOrPos = +($previous_bal_total_qty_wo_bonus) + +($out_qty);
                $getTotalQuantity = $checkIsStockNegOrPos;
            }
            /**
             * Quantity Control Condition else
             * By Shahzaib Coding
             */


            /**
             * Check-Stock-Valuation variables start
             * By Shahzaib Coding
             */
            if (intval($getTotalQuantity) !== 0) {
                $checkValuation = ($previous_bal_total + $out_total) / $getTotalQuantity;
            } else {
                $checkValuation = 0;
            }
            /**
             * Check-Stock-Valuation variables end
             * By Shahzaib Coding
             */


            /**
             * Get Balance Rate Condition start
             * By Shahzaib Coding
             */
            if ($previous_bal_total > 0) {
                $bal_rate = ($previous_bal_total + $out_total) / $getTotalQuantity;
            } else if ($previous_bal_total <= 0 || $checkValuation === 0) {
                $bal_rate = $out_rate;
            } else {
                $bal_rate = ($previous_bal_total + $out_total) / $getTotalQuantity;
            }

            /* previous if statement
            if (($previous_bal_total_qty_wo_bonus + $out_qty) == 0) {
                $bal_rate = ($previous_bal_total + $out_total);
            }
            $bal_rate = ($previous_bal_total + $out_total) / ($previous_bal_total_qty_wo_bonus + $out_qty);
            */
            /**
             * Get Balance Rate Condition end
             * By Shahzaib Coding
             */


            /**
             * Get Balance Total Condition start
             * By Shahzaib Coding
             */
            if ($getTotalQuantity < 0) {
                $bal_total = 0;
            } else {
                $bal_total = $bal_total_qty_wo_bonus * $bal_rate;
            }
            /**
             * Get Balance Total Condition end
             * By Shahzaib Coding
             */


            /**
             * === old Code ===
             * $bal_rate = $previous_bal_rate;
             * $bal_total = $bal_total_qty_wo_bonus * $bal_rate;
             */


            $stock_movement = new StockMovementModels();

            $stock_movement_values = [
                'type_of_invoice' => $invoice_type_text,
                'product_code' => $product_code,
                'product_name' => $product_name,
                'warehouse' => $warehouse,
                'in_qty' => $in_qty,
                'in_bonus' => $in_bonus,
                'in_rate' => $in_rate,
                'in_total' => $in_total,
                'out_qty' => $out_qty,
                'out_bonus' => $out_bonus,
                'out_rate' => $out_rate,
                'out_total' => $out_total,
                'internal_hold' => $internal_hold,
                'internal_bonus' => $internal_bonus,
                'internal_claim' => $internal_claim,
                'bal_qty_for_sale' => $bal_qty_for_sale,
                'bal_bonus_inward' => $bal_bonus_inward,
                'bal_bonus_outward' => $bal_bonus_outward,
                'bal_bonus_qty' => $bal_bonus_qty,
                'bal_hold' => $bal_hold,
                'bal_total_hold' => $bal_total_hold,
                'bal_claims' => $bal_claims,
                'bal_total_qty_wo_bonus' => $bal_total_qty_wo_bonus,
                'bal_total_qty' => $bal_total_qty,
                'bal_rate' => $bal_rate,
                'bal_total' => $bal_total,
                'bal_voucher_code' => $voucher_code,
                'bal_remarks' => $remarks,
            ];

            $stock_movement = $this->stock_movement_values($stock_movement_values, $stock_movement);

            if (!$stock_movement->save()) {
                $flag = false;
            }
        }

        return $flag;
    }

    ///////////////////////////////////////////////////// For GRN Purchase //////////////////////////////////////////////////////////
    public function stock_movement_module_goods_receipt_note_purchase($array, $voucher_code, $invoice_type_text, $remarks)
    {
        $flag = true;

        foreach ($array as $value) {
            $product_code = $value['product_code'];
            $product_name = $value['product_name'];
            $warehouse = $value['warehouse'];

            $previous_stock = $this->product_stock_movement_last_row($product_code);

            if ($previous_stock !== null) {
                $previous_bal_qty_for_sale = $previous_stock->sm_bal_qty_for_sale;
                $previous_bal_rate = $previous_stock->sm_bal_rate;
                $previous_bal_total = $previous_stock->sm_bal_total;
                $previous_bal_bonus_qty = $previous_stock->sm_bal_bonus_qty;
                $previous_bal_total_hold = $previous_stock->sm_bal_total_hold;
                $previous_bal_claims = $previous_stock->sm_bal_claims;
                $previous_bal_total_qty_wo_bonus = $previous_stock->sm_bal_total_qty_wo_bonus;
            } else {
                $previous_bal_qty_for_sale = 0;
                $previous_bal_rate = 0;
                $previous_bal_total = 0;
                $previous_bal_bonus_qty = 0;
                $previous_bal_total_hold = 0;
                $previous_bal_claims = 0;
            }

            $in_qty = $value['product_qty'];
            $in_bonus = $value['product_bonus_qty'];
            $in_rate = $value['product_rate'];
            $in_total = $in_qty * $in_rate;

            $out_qty = null;
            $out_bonus = null;
            $out_rate = null;
            $out_total = $out_qty * $out_rate;

            $internal_hold = null;
            $internal_bonus = null;
            $internal_claim = null;

            $bal_qty_for_sale = $previous_bal_qty_for_sale + $in_qty - $out_qty - $internal_claim - $internal_bonus - $internal_hold;

            $bal_bonus_inward = $in_bonus;
            $bal_bonus_outward = $out_bonus;
            $bal_bonus_qty = $previous_bal_bonus_qty + $bal_bonus_inward - $bal_bonus_outward + $internal_bonus;

            $bal_hold = $internal_hold;
            $bal_total_hold = $previous_bal_total_hold - $in_qty;

            $bal_claims = $previous_bal_claims + $internal_claim;

            $bal_total_qty_wo_bonus = $bal_qty_for_sale + $bal_total_hold + $bal_claims;
            $bal_total_qty = $bal_qty_for_sale + $bal_bonus_qty + $bal_total_hold + $bal_claims;


            /**
             * Check-Is-Stock-Negative-Positive, Get-Total-Quantity variables start
             * By Shahzaib Coding
             */
            $checkIsStockNegOrPos = 0;
            $getTotalQuantity = 0;
            /**
             * Check-Is-Stock-Negative-Positive, Get-Total-Quantity variables end
             * By Shahzaib Coding
             */

            /**
             * Quantity Control Condition start
             * By Shahzaib Coding
             */
            if ($previous_bal_total_qty_wo_bonus < 0) {
                $checkIsStockNegOrPos = $previous_bal_total_qty_wo_bonus;//+ +($in_qty);
                $getTotalQuantity = $checkIsStockNegOrPos;
            } else {
                /**
                 * This Commit line for sale transaction purpose
                 * $checkIsStockNegOrPos = +($previous_bal_total_qty_wo_bonus) - +($in_qty);
                 */
                $checkIsStockNegOrPos = $previous_bal_total_qty_wo_bonus; //+ $in_qty;
                $getTotalQuantity = $checkIsStockNegOrPos;
            }
            /**
             * Quantity Control Condition else
             * By Shahzaib Coding
             */


            /**
             * Check-Stock-Valuation variables start
             * By Shahzaib Coding
             */
            if (intval($getTotalQuantity) !== 0) {
                $checkValuation = ($previous_bal_total + $in_total) / $getTotalQuantity;
            } else {
                $checkValuation = 0;
            }
            /**
             * Check-Stock-Valuation variables end
             * By Shahzaib Coding
             */


            /**
             * Get Balance Rate Condition start
             * By Shahzaib Coding
             */
            if ($previous_bal_total > 0) {
                $bal_rate = ($previous_bal_total + $in_total) / $getTotalQuantity;
            } else if ($previous_bal_total <= 0 || $checkValuation === 0) {
                $bal_rate = $in_rate;
            } else {
                $bal_rate = ($previous_bal_total + $in_total) / $getTotalQuantity;
            }

            /* previous if statement
            if (($previous_bal_total_qty_wo_bonus + $in_qty) == 0) {
                $bal_rate = ($previous_bal_total + $in_total);
            }
            $bal_rate = ($previous_bal_total + $in_total) / ($previous_bal_total_qty_wo_bonus + $in_qty);
            */
            /**
             * Get Balance Rate Condition end
             * By Shahzaib Coding
             */


            /**
             * Get Balance Total Condition start
             * By Shahzaib Coding
             */
            if ($getTotalQuantity < 0) {
                $bal_total = 0;
            } else {
                $bal_total = $bal_total_qty_wo_bonus * $bal_rate;
                $this->grn_purchase_total_stock_amount += $bal_rate * $in_qty;
            }

            /**
             * Get Balance Total Condition end
             * By Shahzaib Coding
             */

            $stock_movement = new StockMovementModels();

            $stock_movement_values = [
                'type_of_invoice' => $invoice_type_text,
                'product_code' => $product_code,
                'product_name' => $product_name,
                'warehouse' => $warehouse,
                'in_qty' => $in_qty,
                'in_bonus' => $in_bonus,
                'in_rate' => $in_rate,
                'in_total' => $in_total,
                'out_qty' => $out_qty,
                'out_bonus' => $out_bonus,
                'out_rate' => $out_rate,
                'out_total' => $out_total,
                'internal_hold' => $internal_hold,
                'internal_bonus' => $internal_bonus,
                'internal_claim' => $internal_claim,
                'bal_qty_for_sale' => $bal_qty_for_sale,
                'bal_bonus_inward' => $bal_bonus_inward,
                'bal_bonus_outward' => $bal_bonus_outward,
                'bal_bonus_qty' => $bal_bonus_qty,
                'bal_hold' => $bal_hold,
                'bal_total_hold' => $bal_total_hold,
                'bal_claims' => $bal_claims,
                'bal_total_qty_wo_bonus' => $bal_total_qty_wo_bonus,
                'bal_total_qty' => $bal_total_qty,
                'bal_rate' => $bal_rate,
                'bal_total' => $bal_total,
                'bal_voucher_code' => $voucher_code,
                'bal_remarks' => $remarks,
            ];


            $stock_movement = $this->stock_movement_values($stock_movement_values, $stock_movement);

            if (!$stock_movement->save()) {
                $flag = false;
            }
        }

        return $flag;
    }

    ///////////////////////////////////////////////////// For GRN Return  //////////////////////////////////////////////////////////
    public function stock_movement_module_goods_receipt_note_return($array, $voucher_code, $invoice_type_text, $remarks)
    {

        $flag = true;

        foreach ($array as $value) {
            $product_code = $value['product_code'];
            $product_name = $value['product_name'];
            $warehouse = $value['warehouse'];

            $previous_stock = $this->product_stock_movement_last_row($product_code);

            if ($previous_stock !== null) {
                $previous_internal_hold = $previous_stock->sm_internal_hold;
                $previous_bal_hold = $previous_stock->sm_bal_hold;
                $previous_bal_total_hold = $previous_stock->sm_bal_total_hold;

                $previous_bal_qty_for_sale = $previous_stock->sm_bal_qty_for_sale;
                $previous_bal_total_qty_wo_bonus = $previous_stock->sm_bal_total_qty_wo_bonus;
                $previous_bal_total_qty = $previous_stock->sm_bal_total_qty;

                $previous_bal_rate = $previous_stock->sm_bal_rate;
                $previous_bal_total = $previous_stock->sm_bal_total;

                $previous_bal_bonus_qty = $previous_stock->sm_bal_bonus_qty;
                $previous_bal_claims = $previous_stock->sm_bal_claims;
            } else {
                $previous_internal_hold = 0;
                $previous_bal_hold = 0;
                $previous_bal_total_qty = 0;
                $previous_bal_rate = 0;
                $previous_bal_total = 0;
                $previous_bal_bonus_qty = 0;
                $previous_bal_total_hold = 0;
                $previous_bal_claims = 0;
                $previous_bal_total_qty_wo_bonus = 0;
            }

            $in_qty = null;
            $in_bonus = null;
            $in_rate = null;
            $in_total = $in_qty * $in_rate;

            $out_qty = null;//$value['product_qty'];
            $out_bonus = null;//$value['product_bonus_qty'];
            $out_rate = null;//$previous_bal_rate;
            $out_total = $out_qty * $out_rate;

            $internal_hold = $value['product_qty'];
            $internal_bonus = $value['product_bonus_qty'];
//            $bal_total_hold = $out_qty * $out_rate;
            $internal_claim = null;
            $bal_qty_for_sale = $previous_bal_qty_for_sale;

//            $bal_qty_for_sale = $previous_bal_qty_for_sale + $in_qty - $out_qty - $internal_claim - $internal_bonus - $internal_hold;

            $bal_bonus_inward = $in_bonus;
            $bal_bonus_outward = $out_bonus;
            $bal_bonus_qty = $previous_bal_bonus_qty;

            $bal_hold = $internal_hold;
            $bal_total_hold = $previous_bal_total_hold - $bal_hold;

            $bal_claims = $previous_bal_claims + $internal_claim;

//            $bal_total_qty_wo_bonus = $previous_bal_total_qty_wo_bonus;
            $bal_total_qty_wo_bonus = $bal_qty_for_sale - $bal_total_hold + $bal_claims;
            $bal_total_qty = $previous_bal_total_qty - $bal_hold;
//            $bal_total_qty = $previous_bal_total_qty - $bal_hold - $internal_bonus;


//            if( $previous_stock->sm_bal_total_qty_wo_bonus <= 0 ){
//                $bal_rate = $previous_stock->sm_bal_rate;
//            }
//            else if (($previous_bal_total_qty_wo_bonus + $in_qty) == 0) {
            $bal_rate = $previous_bal_rate;
//            }
//            else {
//                $bal_rate = ($previous_bal_total + $in_total) / ($previous_bal_total_qty_wo_bonus + $in_qty);
//            }

//            $bal_rate = ($previous_bal_total + $in_total) / ($previous_bal_total_qty_wo_bonus + $in_qty);
            if ($previous_bal_total_qty_wo_bonus <= 0) {
                $bal_total = 0;
            } else {
                $bal_total = $bal_total_qty_wo_bonus * $bal_rate;
            }

            $stock_movement = new StockMovementModels();

            $stock_movement_values = [
                'type_of_invoice' => $invoice_type_text,
                'product_code' => $product_code,
                'product_name' => $product_name,
                'warehouse' => $warehouse,
                'in_qty' => $in_qty,
                'in_bonus' => $in_bonus,
                'in_rate' => $in_rate,
                'in_total' => $in_total,
                'out_qty' => $out_qty,
                'out_bonus' => $out_bonus,
                'out_rate' => $out_rate,
                'out_total' => $out_total,
                'internal_hold' => $internal_hold,
                'internal_bonus' => $internal_bonus,
                'internal_claim' => $internal_claim,
                'bal_qty_for_sale' => $bal_qty_for_sale,
                'bal_bonus_inward' => $bal_bonus_inward,
                'bal_bonus_outward' => $bal_bonus_outward,
                'bal_bonus_qty' => $bal_bonus_qty,
                'bal_hold' => $bal_hold,
                'bal_total_hold' => $bal_total_hold,
                'bal_claims' => $bal_claims,
                'bal_total_qty_wo_bonus' => $bal_total_qty_wo_bonus,
                'bal_total_qty' => $bal_total_qty,
                'bal_rate' => $bal_rate,
                'bal_total' => $bal_total,
                'bal_voucher_code' => $voucher_code,
                'bal_remarks' => $remarks,
            ];

            $stock_movement = $this->stock_movement_values($stock_movement_values, $stock_movement);

            if (!$stock_movement->save()) {
                $flag = false;
            }
        }

        return $flag;
    }

    ///////////////////////////////////////////////////// For GRN //////////////////////////////////////////////////////////
    public function stock_movement_module_goods_receipt_note($array, $voucher_code, $invoice_type_text, $remarks)
    {

        $flag = true;

        foreach ($array as $value) {
            $product_code = $value['product_code'];
            $product_name = $value['product_name'];
            $warehouse = $value['warehouse'];

            $previous_stock = $this->product_stock_movement_last_row($product_code);

            if ($previous_stock !== null) {
                $previous_internal_hold = $previous_stock->sm_internal_hold;
                $previous_bal_hold = $previous_stock->sm_bal_hold;
                $previous_bal_total_hold = $previous_stock->sm_bal_total_hold;

                $previous_bal_qty_for_sale = $previous_stock->sm_bal_qty_for_sale;
                $previous_bal_total_qty_wo_bonus = $previous_stock->sm_bal_total_qty_wo_bonus;
                $previous_bal_total_qty = $previous_stock->sm_bal_total_qty;

                $previous_bal_rate = $previous_stock->sm_bal_rate;
                $previous_bal_total = $previous_stock->sm_bal_total;

                $previous_bal_bonus_qty = $previous_stock->sm_bal_bonus_qty;
                $previous_bal_claims = $previous_stock->sm_bal_claims;
            } else {
                $previous_internal_hold = 0;
                $previous_bal_hold = 0;
                $previous_bal_total_qty = 0;
                $previous_bal_rate = 0;
                $previous_bal_total = 0;
                $previous_bal_bonus_qty = 0;
                $previous_bal_total_hold = 0;
                $previous_bal_claims = 0;
                $previous_bal_total_qty_wo_bonus = 0;
            }

            $in_qty = null;
            $in_bonus = null;
            $in_rate = null;
            $in_total = $in_qty * $in_rate;

            $out_qty = null;//$value['product_qty'];
            $out_bonus = null;//$value['product_bonus_qty'];
            $out_rate = null;//$previous_bal_rate;
            $out_total = $out_qty * $out_rate;

            $internal_hold = $value['product_qty'];
            $internal_bonus = $value['product_bonus_qty'];
            $bal_total_hold = $out_qty * $out_rate;
            $internal_claim = null;
            $bal_qty_for_sale = $previous_bal_qty_for_sale;

//            $bal_qty_for_sale = $previous_bal_qty_for_sale + $in_qty - $out_qty - $internal_claim - $internal_bonus - $internal_hold;

            $bal_bonus_inward = $in_bonus;
            $bal_bonus_outward = $out_bonus;
            $bal_bonus_qty = $previous_bal_bonus_qty;

            $bal_hold = $internal_hold;
            $bal_total_hold = $previous_bal_total_hold + $bal_hold;

            $bal_claims = $previous_bal_claims + $internal_claim;

//            $bal_total_qty_wo_bonus = $previous_bal_total_qty_wo_bonus;
            $bal_total_qty_wo_bonus = $bal_qty_for_sale + $bal_total_hold + $bal_claims;
            $bal_total_qty = $previous_bal_total_qty + $bal_hold;
//            $bal_total_qty = $previous_bal_total_qty - $bal_hold - $internal_bonus;


//            if( $previous_stock->sm_bal_total_qty_wo_bonus <= 0 ){
//                $bal_rate = $previous_stock->sm_bal_rate;
//            }
//            else if (($previous_bal_total_qty_wo_bonus + $in_qty) == 0) {
            $bal_rate = $previous_bal_rate;
//            }
//            else {
//                $bal_rate = ($previous_bal_total + $in_total) / ($previous_bal_total_qty_wo_bonus + $in_qty);
//            }

//            $bal_rate = ($previous_bal_total + $in_total) / ($previous_bal_total_qty_wo_bonus + $in_qty);
            if ($previous_bal_total_qty_wo_bonus <= 0) {
                $bal_total = 0;
            } else {
                $bal_total = $bal_total_qty_wo_bonus * $bal_rate;
            }

            $stock_movement = new StockMovementModels();

            $stock_movement_values = [
                'type_of_invoice' => $invoice_type_text,
                'product_code' => $product_code,
                'product_name' => $product_name,
                'warehouse' => $warehouse,
                'in_qty' => $in_qty,
                'in_bonus' => $in_bonus,
                'in_rate' => $in_rate,
                'in_total' => $in_total,
                'out_qty' => $out_qty,
                'out_bonus' => $out_bonus,
                'out_rate' => $out_rate,
                'out_total' => $out_total,
                'internal_hold' => $internal_hold,
                'internal_bonus' => $internal_bonus,
                'internal_claim' => $internal_claim,
                'bal_qty_for_sale' => $bal_qty_for_sale,
                'bal_bonus_inward' => $bal_bonus_inward,
                'bal_bonus_outward' => $bal_bonus_outward,
                'bal_bonus_qty' => $bal_bonus_qty,
                'bal_hold' => $bal_hold,
                'bal_total_hold' => $bal_total_hold,
                'bal_claims' => $bal_claims,
                'bal_total_qty_wo_bonus' => $bal_total_qty_wo_bonus,
                'bal_total_qty' => $bal_total_qty,
                'bal_rate' => $bal_rate,
                'bal_total' => $bal_total,
                'bal_voucher_code' => $voucher_code,
                'bal_remarks' => $remarks,
            ];

            $stock_movement = $this->stock_movement_values($stock_movement_values, $stock_movement);

            if (!$stock_movement->save()) {
                $flag = false;
            }
        }

        return $flag;
    }

    ///////////////////////////////////////////////////// For Delivery //////////////////////////////////////////////////////////
    public function stock_movement_module_delivery($array, $voucher_code, $invoice_type_text, $remarks)
    {

        $flag = true;

        foreach ($array as $value) {
            $product_code = $value['product_code'];
            $product_name = $value['product_name'];
            $warehouse = $value['warehouse'];

            $previous_stock = $this->product_stock_movement_last_row($product_code);

            if ($previous_stock !== null) {
                $previous_internal_hold = $previous_stock->sm_internal_hold;
                $previous_bal_hold = $previous_stock->sm_bal_hold;
                $previous_bal_total_hold = $previous_stock->sm_bal_total_hold;

                $previous_bal_qty_for_sale = $previous_stock->sm_bal_qty_for_sale;
                $previous_bal_total_qty_wo_bonus = $previous_stock->sm_bal_total_qty_wo_bonus;
                $previous_bal_total_qty = $previous_stock->sm_bal_total_qty;

                $previous_bal_rate = $previous_stock->sm_bal_rate;
                $previous_bal_total = $previous_stock->sm_bal_total;

                $previous_bal_bonus_qty = $previous_stock->sm_bal_bonus_qty;
                $previous_bal_claims = $previous_stock->sm_bal_claims;
            } else {
                $previous_internal_hold = 0;
                $previous_bal_hold = 0;
                $previous_bal_total_qty = 0;
                $previous_bal_rate = 0;
                $previous_bal_total = 0;
                $previous_bal_bonus_qty = 0;
                $previous_bal_total_hold = 0;
                $previous_bal_claims = 0;
                $previous_bal_total_qty_wo_bonus = 0;
            }

            $in_qty = null;
            $in_bonus = null;
            $in_rate = null;
            $in_total = $in_qty * $in_rate;

            $out_qty = null;//$value['product_qty'];
            $out_bonus = null;//$value['product_bonus_qty'];
            $out_rate = null;//$previous_bal_rate;
            $out_total = $out_qty * $out_rate;

            $internal_hold = $value['product_qty'];
            $internal_bonus = $value['product_bonus_qty'];
            $bal_total_hold = $out_qty * $out_rate;
            $internal_claim = null;
            $bal_qty_for_sale = $previous_bal_qty_for_sale - $internal_hold;

//            $bal_qty_for_sale = $previous_bal_qty_for_sale + $in_qty - $out_qty - $internal_claim - $internal_bonus - $internal_hold;

            $bal_bonus_inward = $in_bonus;
            $bal_bonus_outward = $out_bonus;
            $bal_bonus_qty = $previous_bal_bonus_qty - $internal_bonus;

            $bal_hold = $internal_hold;
            $bal_total_hold = $previous_bal_total_hold + $bal_hold;

            $bal_claims = $previous_bal_claims + $internal_claim;

            $bal_total_qty_wo_bonus = $previous_bal_total_qty_wo_bonus - $internal_hold;
//            $bal_total_qty_wo_bonus = $bal_qty_for_sale + $bal_total_hold + $bal_claims;
            $bal_total_qty = $previous_bal_total_qty - $bal_hold - $internal_bonus;


//            if( $previous_stock->sm_bal_total_qty_wo_bonus <= 0 ){
//                $bal_rate = $previous_stock->sm_bal_rate;
//            }
//            else if (($previous_bal_total_qty_wo_bonus + $in_qty) == 0) {
            $bal_rate = $previous_bal_rate;
//            }
//            else {
//                $bal_rate = ($previous_bal_total + $in_total) / ($previous_bal_total_qty_wo_bonus + $in_qty);
//            }

//            $bal_rate = ($previous_bal_total + $in_total) / ($previous_bal_total_qty_wo_bonus + $in_qty);
            if ($previous_bal_total_qty_wo_bonus <= 0) {
                $bal_total = 0;
            } else {
                $bal_total = $bal_total_qty_wo_bonus * $bal_rate;
            }

            $stock_movement = new StockMovementModels();

            $stock_movement_values = [
                'type_of_invoice' => $invoice_type_text,
                'product_code' => $product_code,
                'product_name' => $product_name,
                'warehouse' => $warehouse,
                'in_qty' => $in_qty,
                'in_bonus' => $in_bonus,
                'in_rate' => $in_rate,
                'in_total' => $in_total,
                'out_qty' => $out_qty,
                'out_bonus' => $out_bonus,
                'out_rate' => $out_rate,
                'out_total' => $out_total,
                'internal_hold' => $internal_hold,
                'internal_bonus' => $internal_bonus,
                'internal_claim' => $internal_claim,
                'bal_qty_for_sale' => $bal_qty_for_sale,
                'bal_bonus_inward' => $bal_bonus_inward,
                'bal_bonus_outward' => $bal_bonus_outward,
                'bal_bonus_qty' => $bal_bonus_qty,
                'bal_hold' => $bal_hold,
                'bal_total_hold' => $bal_total_hold,
                'bal_claims' => $bal_claims,
                'bal_total_qty_wo_bonus' => $bal_total_qty_wo_bonus,
                'bal_total_qty' => $bal_total_qty,
                'bal_rate' => $bal_rate,
                'bal_total' => $bal_total,
                'bal_voucher_code' => $voucher_code,
                'bal_remarks' => $remarks,
            ];

            $stock_movement = $this->stock_movement_values($stock_movement_values, $stock_movement);

            if (!$stock_movement->save()) {
                $flag = false;
            }
        }

        return $flag;
    }

    ///////////////////////////////////////////////////// For Delivery Order Sale Invoice //////////////////////////////////////////////////////////
    public function stock_movement_module_delivery_order_sale($array, $voucher_code, $invoice_type_text, $remarks)
    {
        $flag = true;

        foreach ($array as $value) {
            $product_code = $value['product_code'];
            $product_name = $value['product_name'];
            $warehouse = $value['warehouse'];

            $previous_stock = $this->product_stock_movement_last_row($product_code);

            if ($previous_stock !== null) {

                $previous_bal_qty_for_sale = $previous_stock->sm_bal_qty_for_sale;
                $previous_bal_rate = $previous_stock->sm_bal_rate;
                $previous_bal_total = $previous_stock->sm_bal_total;
                $previous_bal_bonus_qty = $previous_stock->sm_bal_bonus_qty;
                $previous_bal_total_hold = $previous_stock->sm_bal_total_hold;
                $previous_bal_claims = $previous_stock->sm_bal_claims;
                $previous_bal_total_qty_wo_bonus = $previous_stock->sm_bal_total_qty_wo_bonus;
                $previous_bal_total_qty = $previous_stock->sm_bal_total_qty;
            } else {
                $previous_bal_qty_for_sale = 0;
                $previous_bal_rate = 0;
                $previous_bal_total = 0;
                $previous_bal_bonus_qty = 0;
                $previous_bal_total_hold = 0;
                $previous_bal_claims = 0;
                $previous_bal_total_qty_wo_bonus = 0;
            }

            $in_qty = null;
            $in_bonus = null;
            $in_rate = null;
            $in_total = $in_qty * $in_rate;

            $out_qty = $value['product_qty'];
            $out_bonus = $value['product_bonus_qty'];
            $out_rate = $previous_bal_rate;
            $out_total = $out_qty * $out_rate;

            $internal_hold = null;
            $internal_bonus = null;
            $internal_claim = null;

            $bal_qty_for_sale = $previous_bal_qty_for_sale;
            //+ $in_qty - $out_qty - $internal_claim - $internal_bonus - $internal_hold;

            $bal_bonus_inward = $in_bonus;
            $bal_bonus_outward = $out_bonus;
            $bal_bonus_qty = $previous_bal_bonus_qty + $bal_bonus_inward + $internal_bonus;
//            $bal_bonus_qty = $previous_bal_bonus_qty + $bal_bonus_inward - $bal_bonus_outward + $internal_bonus;
            //$bal_bonus_qty = $previous_bal_bonus_qty + $bal_bonus_inward - $bal_bonus_outward + $internal_bonus;

            $bal_hold = '-' . $out_qty;
//            $bal_hold = $internal_hold;
            $bal_total_hold = $previous_bal_total_hold - $out_qty;

            $bal_claims = $previous_bal_claims + $internal_claim;

            $bal_total_qty_wo_bonus = $previous_bal_total_qty_wo_bonus;//$bal_qty_for_sale + $bal_total_hold + $bal_claims;
            $bal_total_qty = $previous_bal_total_qty;


            /*old calculations start
           if (($previous_bal_total_qty_wo_bonus + $in_qty) == 0) {
               $bal_rate = ($previous_bal_total + $in_total);
           }
           else {
               $bal_rate = ($previous_bal_total + $in_total) / ($previous_bal_total_qty_wo_bonus + $in_qty);
           }
            old calculations end*/

//            $bal_rate = ($previous_bal_total + $in_total) / ($previous_bal_total_qty_wo_bonus + $in_qty);

            /**
             * Get Balance Rate Condition start
             * By Shahzaib Coding
             */
            $bal_rate = $previous_bal_rate;
            /**
             * Get Balance Rate Condition start
             * By Shahzaib Coding
             */


            /**
             * Get Balance Total Condition start
             * By Shahzaib Coding
             */
            if ($bal_total_qty_wo_bonus < 0) {
                $bal_total = $bal_total_qty_wo_bonus * 0;
            } else {
                $bal_total = $bal_total_qty_wo_bonus * $bal_rate;
            }
            /**
             * Get Balance Total Condition start
             * By Shahzaib Coding
             */

            $stock_movement = new StockMovementModels();

            $stock_movement_values = [
                'type_of_invoice' => $invoice_type_text,
                'product_code' => $product_code,
                'product_name' => $product_name,
                'warehouse' => $warehouse,
                'in_qty' => $in_qty,
                'in_bonus' => $in_bonus,
                'in_rate' => $in_rate,
                'in_total' => $in_total,
                'out_qty' => $out_qty,
                'out_bonus' => $out_bonus,
                'out_rate' => $out_rate,
                'out_total' => $out_total,
                'internal_hold' => $internal_hold,
                'internal_bonus' => $internal_bonus,
                'internal_claim' => $internal_claim,
                'bal_qty_for_sale' => $bal_qty_for_sale,
                'bal_bonus_inward' => $bal_bonus_inward,
                'bal_bonus_outward' => $bal_bonus_outward,
                'bal_bonus_qty' => $bal_bonus_qty,
                'bal_hold' => $bal_hold,
                'bal_total_hold' => $bal_total_hold,
                'bal_claims' => $bal_claims,
                'bal_total_qty_wo_bonus' => $bal_total_qty_wo_bonus,
                'bal_total_qty' => $bal_total_qty,
                'bal_rate' => $bal_rate,
                'bal_total' => $bal_total,
                'bal_voucher_code' => $voucher_code,
                'bal_remarks' => $remarks,
            ];

            $stock_movement = $this->stock_movement_values($stock_movement_values, $stock_movement);

            if (!$stock_movement->save()) {
                $flag = false;
            }
        }

        return $flag;
    }

    ///////////////////////////////////////////////////// For Sale //////////////////////////////////////////////////////////
    public function stock_movement_module_sale($array, $voucher_code, $invoice_type_text, $remarks)
    {
        $flag = true;

        foreach ($array as $value) {
            $product_code = $value['product_code'];
            $product_name = $value['product_name'];
            $warehouse = $value['warehouse'];

            $previous_stock = $this->product_stock_movement_last_row($product_code);

            if ($previous_stock !== null) {
                $previous_bal_qty_for_sale = $previous_stock->sm_bal_qty_for_sale;
                $previous_bal_rate = $previous_stock->sm_bal_rate;
                $previous_bal_total = $previous_stock->sm_bal_total;
                $previous_bal_bonus_qty = $previous_stock->sm_bal_bonus_qty;
                $previous_bal_total_hold = $previous_stock->sm_bal_total_hold;
                $previous_bal_claims = $previous_stock->sm_bal_claims;
                $previous_bal_total_qty_wo_bonus = $previous_stock->sm_bal_total_qty_wo_bonus;
            } else {
                $previous_bal_qty_for_sale = 0;
                $previous_bal_rate = 0;
                $previous_bal_total = 0;
                $previous_bal_bonus_qty = 0;
                $previous_bal_total_hold = 0;
                $previous_bal_claims = 0;
                $previous_bal_total_qty_wo_bonus = 0;
            }

            $in_qty = null;
            $in_bonus = null;
            $in_rate = null;
            $in_total = $in_qty * $in_rate;

            $out_qty = $value['product_qty'];
            $out_bonus = $value['product_bonus_qty'];
            $out_rate = $previous_bal_rate;
            $out_total = $out_qty * $out_rate;

            $internal_hold = null;
            $internal_bonus = null;
            $internal_claim = null;

            $bal_qty_for_sale = $previous_bal_qty_for_sale + $in_qty - $out_qty - $internal_claim - $internal_bonus - $internal_hold;

            $bal_bonus_inward = $in_bonus;
            $bal_bonus_outward = $out_bonus;
            $bal_bonus_qty = $previous_bal_bonus_qty + $bal_bonus_inward - $bal_bonus_outward + $internal_bonus;

            $bal_hold = $internal_hold;
            $bal_total_hold = $previous_bal_total_hold + $bal_hold;

            $bal_claims = $previous_bal_claims + $internal_claim;

            $bal_total_qty_wo_bonus = $bal_qty_for_sale + $bal_total_hold + $bal_claims;
            $bal_total_qty = $bal_qty_for_sale + $bal_bonus_qty + $bal_total_hold + $bal_claims;


            /*old calculations start
           if (($previous_bal_total_qty_wo_bonus + $in_qty) == 0) {
               $bal_rate = ($previous_bal_total + $in_total);
           }
           else {
               $bal_rate = ($previous_bal_total + $in_total) / ($previous_bal_total_qty_wo_bonus + $in_qty);
           }
            old calculations end*/

//            $bal_rate = ($previous_bal_total + $in_total) / ($previous_bal_total_qty_wo_bonus + $in_qty);

            /**
             * Get Balance Rate Condition start
             * By Shahzaib Coding
             */
            $bal_rate = $previous_bal_rate;
            /**
             * Get Balance Rate Condition start
             * By Shahzaib Coding
             */


            /**
             * Get Balance Total Condition start
             * By Shahzaib Coding
             */
            if ($bal_total_qty_wo_bonus < 0) {
                $bal_total = $bal_total_qty_wo_bonus * 0;
            } else {
                $bal_total = $bal_total_qty_wo_bonus * $bal_rate;
            }
            /**
             * Get Balance Total Condition start
             * By Shahzaib Coding
             */

            $stock_movement = new StockMovementModels();

            $stock_movement_values = [
                'type_of_invoice' => $invoice_type_text,
                'product_code' => $product_code,
                'product_name' => $product_name,
                'warehouse' => $warehouse,
                'in_qty' => $in_qty,
                'in_bonus' => $in_bonus,
                'in_rate' => $in_rate,
                'in_total' => $in_total,
                'out_qty' => $out_qty,
                'out_bonus' => $out_bonus,
                'out_rate' => $out_rate,
                'out_total' => $out_total,
                'internal_hold' => $internal_hold,
                'internal_bonus' => $internal_bonus,
                'internal_claim' => $internal_claim,
                'bal_qty_for_sale' => $bal_qty_for_sale,
                'bal_bonus_inward' => $bal_bonus_inward,
                'bal_bonus_outward' => $bal_bonus_outward,
                'bal_bonus_qty' => $bal_bonus_qty,
                'bal_hold' => $bal_hold,
                'bal_total_hold' => $bal_total_hold,
                'bal_claims' => $bal_claims,
                'bal_total_qty_wo_bonus' => $bal_total_qty_wo_bonus,
                'bal_total_qty' => $bal_total_qty,
                'bal_rate' => $bal_rate,
                'bal_total' => $bal_total,
                'bal_voucher_code' => $voucher_code,
                'bal_remarks' => $remarks,
            ];

            $stock_movement = $this->stock_movement_values($stock_movement_values, $stock_movement);

            if (!$stock_movement->save()) {
                $flag = false;
            }
        }

        return $flag;
    }


    public function stock_movement_module_production($array, $voucher_code, $invoice_type_text, $remarks)
    {
        $flag = true;

        foreach ($array as $value) {
            $product_code = $value['product_code'];
            $product_name = $value['product_name'];

            $previous_stock = $this->product_stock_movement_last_row($product_code);

            if ($previous_stock !== null) {
                $previous_bal_qty_for_sale = $previous_stock->sm_bal_qty_for_sale;
                $previous_bal_rate = $previous_stock->sm_bal_rate;
                $previous_bal_total = $previous_stock->sm_bal_total;
                $previous_bal_bonus_qty = $previous_stock->sm_bal_bonus_qty;
                $previous_bal_total_hold = $previous_stock->sm_bal_total_hold;
                $previous_bal_claims = $previous_stock->sm_bal_claims;
                $previous_bal_total_qty_wo_bonus = $previous_stock->sm_bal_total_qty_wo_bonus;
            } else {
                $previous_bal_qty_for_sale = 0;
                $previous_bal_rate = 0;
                $previous_bal_total = 0;
                $previous_bal_bonus_qty = 0;
                $previous_bal_total_hold = 0;
                $previous_bal_claims = 0;
                $previous_bal_total_qty_wo_bonus = 0;
            }

            $in_qty = null;
            $in_bonus = null;
            $in_rate = null;
            $in_total = $in_qty * $in_rate;

            $out_qty = $value['product_qty'];
            $out_bonus = 0;
            $out_rate = $previous_bal_rate;
            $out_total = $out_qty * $out_rate;

            $internal_hold = null;
            $internal_bonus = null;
            $internal_claim = null;

            $bal_qty_for_sale = $previous_bal_qty_for_sale + $in_qty - $out_qty - $internal_claim - $internal_bonus - $internal_hold;

            $bal_bonus_inward = $in_bonus;
            $bal_bonus_outward = $out_bonus;
            $bal_bonus_qty = $previous_bal_bonus_qty + $bal_bonus_inward - $bal_bonus_outward + $internal_bonus;

            $bal_hold = $internal_hold;
            $bal_total_hold = $previous_bal_total_hold + $bal_hold;

            $bal_claims = $previous_bal_claims + $internal_claim;

            $bal_total_qty_wo_bonus = $bal_qty_for_sale + $bal_total_hold + $bal_claims;
            $bal_total_qty = $bal_qty_for_sale + $bal_bonus_qty + $bal_total_hold + $bal_claims;

            if (($previous_bal_total_qty_wo_bonus + $in_qty) == 0) {
                $bal_rate = ($previous_bal_total + $in_total);
            } else {
                $bal_rate = ($previous_bal_total + $in_total) / ($previous_bal_total_qty_wo_bonus + $in_qty);
            }

//            $bal_rate = ($previous_bal_total + $in_total) / ($previous_bal_total_qty_wo_bonus + $in_qty);

            $bal_total = $bal_total_qty_wo_bonus * $bal_rate;

            $stock_movement = new StockMovementModels();

            $stock_movement_values = [
                'type_of_invoice' => $invoice_type_text,
                'product_code' => $product_code,
                'product_name' => $product_name,
                'in_qty' => $in_qty,
                'in_bonus' => $in_bonus,
                'in_rate' => $in_rate,
                'in_total' => $in_total,
                'out_qty' => $out_qty,
                'out_bonus' => $out_bonus,
                'out_rate' => $out_rate,
                'out_total' => $out_total,
                'internal_hold' => $internal_hold,
                'internal_bonus' => $internal_bonus,
                'internal_claim' => $internal_claim,
                'bal_qty_for_sale' => $bal_qty_for_sale,
                'bal_bonus_inward' => $bal_bonus_inward,
                'bal_bonus_outward' => $bal_bonus_outward,
                'bal_bonus_qty' => $bal_bonus_qty,
                'bal_hold' => $bal_hold,
                'bal_total_hold' => $bal_total_hold,
                'bal_claims' => $bal_claims,
                'bal_total_qty_wo_bonus' => $bal_total_qty_wo_bonus,
                'bal_total_qty' => $bal_total_qty,
                'bal_rate' => $bal_rate,
                'bal_total' => $bal_total,
                'bal_voucher_code' => $voucher_code,
                'bal_remarks' => $remarks,
            ];

            $stock_movement = $this->stock_movement_values($stock_movement_values, $stock_movement);

            if (!$stock_movement->save()) {
                $flag = false;
            }
        }

        return $flag;
    }

    ///////////////////////////////////////////////////// For Sale Return //////////////////////////////////////////////////////////
    public function stock_movement_module_sale_return($array, $voucher_code, $invoice_type_text, $remarks)
    {
        $flag = true;

        foreach ($array as $value) {
            $product_code = $value['product_code'];
            $product_name = $value['product_name'];
            $warehouse = $value['warehouse'];

            $previous_stock = $this->product_stock_movement_last_row($product_code);

            if ($previous_stock !== null) {
                $previous_bal_qty_for_sale = $previous_stock->sm_bal_qty_for_sale;
                $previous_bal_rate = $previous_stock->sm_bal_rate;
                $previous_bal_total = $previous_stock->sm_bal_total;
                $previous_bal_bonus_qty = $previous_stock->sm_bal_bonus_qty;
                $previous_bal_total_hold = $previous_stock->sm_bal_total_hold;
                $previous_bal_claims = $previous_stock->sm_bal_claims;
                $previous_bal_total_qty_wo_bonus = $previous_stock->sm_bal_total_qty_wo_bonus;
            } else {
                $previous_bal_qty_for_sale = 0;
                $previous_bal_rate = 0;
                $previous_bal_total = 0;
                $previous_bal_bonus_qty = 0;
                $previous_bal_total_hold = 0;
                $previous_bal_claims = 0;
            }

            $in_qty = $value['product_qty'];
            $in_bonus = $value['product_bonus_qty'];
            $in_rate = $previous_bal_rate;
            $in_total = $in_qty * $in_rate;

            $out_qty = null;
            $out_bonus = null;
            $out_rate = null;
            $out_total = $out_qty * $out_rate;

            $internal_hold = null;
            $internal_bonus = null;
            $internal_claim = null;

            $bal_qty_for_sale = $previous_bal_qty_for_sale + $in_qty - $out_qty - $internal_claim - $internal_bonus - $internal_hold;

            $bal_bonus_inward = $in_bonus;
            $bal_bonus_outward = $out_bonus;
            $bal_bonus_qty = $previous_bal_bonus_qty + $bal_bonus_inward - $bal_bonus_outward + $internal_bonus;

            $bal_hold = $internal_hold;
            $bal_total_hold = $previous_bal_total_hold + $bal_hold;

            $bal_claims = $previous_bal_claims + $internal_claim;

            $bal_total_qty_wo_bonus = $bal_qty_for_sale + $bal_total_hold + $bal_claims;
            $bal_total_qty = $bal_qty_for_sale + $bal_bonus_qty + $bal_total_hold + $bal_claims;

//            if (($previous_bal_total_qty_wo_bonus + $in_qty) == 0) {
//                $bal_rate = ($previous_bal_total + $in_qty);
//            }else{
//            $bal_rate = ($previous_bal_total + $in_total) / ($previous_bal_total_qty_wo_bonus + $in_qty);
//            }

//            $bal_rate = ($previous_bal_total + $in_total) / ($previous_bal_total_qty_wo_bonus + $in_qty);

            /**
             * Get Balance Rate Condition start
             * By Shahzaib Coding
             */
            $bal_rate = $previous_bal_rate;
            /**
             * Get Balance Rate Condition start
             * By Shahzaib Coding
             */


            /**
             * Get Balance Total Condition start
             * By Shahzaib Coding
             */
            if ($bal_total_qty_wo_bonus < 0) {
                $bal_total = $bal_total_qty_wo_bonus * 0;
            } else {
                $bal_total = $bal_total_qty_wo_bonus * $bal_rate;
            }
            /**
             * Get Balance Total Condition start
             * By Shahzaib Coding
             */

            /**
             * Old Code
             * $bal_rate = $previous_bal_rate;
             * $bal_total = $bal_total_qty_wo_bonus * $bal_rate;
             */


            $stock_movement = new StockMovementModels();

            $stock_movement_values = [
                'type_of_invoice' => $invoice_type_text,
                'product_code' => $product_code,
                'product_name' => $product_name,
                'warehouse' => $warehouse,

                'in_qty' => $in_qty,
                'in_bonus' => $in_bonus,
                'in_rate' => $in_rate,
                'in_total' => $in_total,
                'out_qty' => $out_qty,
                'out_bonus' => $out_bonus,
                'out_rate' => $out_rate,
                'out_total' => $out_total,
                'internal_hold' => $internal_hold,
                'internal_bonus' => $internal_bonus,
                'internal_claim' => $internal_claim,
                'bal_qty_for_sale' => $bal_qty_for_sale,
                'bal_bonus_inward' => $bal_bonus_inward,
                'bal_bonus_outward' => $bal_bonus_outward,
                'bal_bonus_qty' => $bal_bonus_qty,
                'bal_hold' => $bal_hold,
                'bal_total_hold' => $bal_total_hold,
                'bal_claims' => $bal_claims,
                'bal_total_qty_wo_bonus' => $bal_total_qty_wo_bonus,
                'bal_total_qty' => $bal_total_qty,
                'bal_rate' => $bal_rate,
                'bal_total' => $bal_total,
                'bal_voucher_code' => $voucher_code,
                'bal_remarks' => $remarks,
            ];

            $stock_movement = $this->stock_movement_values($stock_movement_values, $stock_movement);

            if (!$stock_movement->save()) {
                $flag = false;
            }
        }

        return $flag;
    }

    ///////////////////////////////////////////////////// For Product Loss //////////////////////////////////////////////////////////
    public function stock_movement_module_product_loss($array, $voucher_code, $invoice_type_text, $remarks)
    {
        $flag = true;

        foreach ($array as $value) {
            $product_code = $value['product_code'];
            $product_name = $value['product_name'];
            $warehouse = $value['warehouse'];

            $previous_stock = $this->product_stock_movement_last_row($product_code);

            if ($previous_stock !== null) {
                $previous_bal_qty_for_sale = $previous_stock->sm_bal_qty_for_sale;
                $previous_bal_rate = $previous_stock->sm_bal_rate;
                $previous_bal_total = $previous_stock->sm_bal_total;
                $previous_bal_bonus_qty = $previous_stock->sm_bal_bonus_qty;
                $previous_bal_total_hold = $previous_stock->sm_bal_total_hold;
                $previous_bal_claims = $previous_stock->sm_bal_claims;
                $previous_bal_total_qty_wo_bonus = $previous_stock->sm_bal_total_qty_wo_bonus;
            } else {
                $previous_bal_qty_for_sale = 0;
                $previous_bal_rate = 0;
                $previous_bal_total = 0;
                $previous_bal_bonus_qty = 0;
                $previous_bal_total_hold = 0;
                $previous_bal_claims = 0;
            }

            $in_qty = null;
            $in_bonus = null;
            $in_rate = null;
            $in_total = $in_qty * $in_rate;

            $out_qty = $value['product_qty'];
            $out_bonus = $value['product_bonus_qty'];
            $out_rate = $value['product_rate'];//hamza
            $out_rate = $previous_bal_rate;//mustafa
            $out_total = $out_qty * $out_rate;

            $internal_hold = null;
            $internal_bonus = null;
            $internal_claim = null;

            $bal_qty_for_sale = $previous_bal_qty_for_sale + $in_qty - $out_qty - $internal_claim - $internal_bonus - $internal_hold;

            $bal_bonus_inward = $in_bonus;
            $bal_bonus_outward = $out_bonus;
            $bal_bonus_qty = $previous_bal_bonus_qty + $bal_bonus_inward - $bal_bonus_outward + $internal_bonus;

            $bal_hold = $internal_hold;
            $bal_total_hold = $previous_bal_total_hold + $bal_hold;

            $bal_claims = $previous_bal_claims + $internal_claim;

            $bal_total_qty_wo_bonus = $bal_qty_for_sale + $bal_total_hold + $bal_claims;
            $bal_total_qty = $bal_qty_for_sale + $bal_bonus_qty + $bal_total_hold + $bal_claims;


            /**
             * Check-Is-Stock-Negative-Positive, Get-Total-Quantity variables start
             * By Shahzaib Coding
             */
            $checkIsStockNegOrPos = 0;
            $getTotalQuantity = 0;
            /**
             * Check-Is-Stock-Negative-Positive, Get-Total-Quantity variables end
             * By Shahzaib Coding
             */

            /**
             * Quantity Control Condition start
             * By Shahzaib Coding
             */
            if ($previous_bal_total_qty_wo_bonus < 0) {
                $checkIsStockNegOrPos = +($previous_bal_total_qty_wo_bonus) + +($in_qty);
                $getTotalQuantity = $checkIsStockNegOrPos;
            } else {
                /**
                 * This Commit line for sale transaction purpose
                 * $checkIsStockNegOrPos = +($previous_bal_total_qty_wo_bonus) - +($in_qty);
                 */
                $checkIsStockNegOrPos = +($previous_bal_total_qty_wo_bonus) + +($in_qty);
                $getTotalQuantity = $checkIsStockNegOrPos;
            }
            /**
             * Quantity Control Condition else
             * By Shahzaib Coding
             */


            /**
             * Check-Stock-Valuation variables start
             * By Shahzaib Coding
             */
            if (intval($getTotalQuantity) !== 0) {
                $checkValuation = ($previous_bal_total + $in_total) / $getTotalQuantity;
            } else {
                $checkValuation = 0;
            }
            /**
             * Check-Stock-Valuation variables end
             * By Shahzaib Coding
             */


            /**
             * Get Balance Rate Condition start
             * By Shahzaib Coding
             */
            if ($previous_bal_total > 0) {
                $bal_rate = ($previous_bal_total + $in_total) / $getTotalQuantity;
            } else if ($previous_bal_total <= 0 || $checkValuation === 0) {
                $bal_rate = $in_rate;
            } else {
                $bal_rate = ($previous_bal_total + $in_total) / $getTotalQuantity;
            }

            /* previous if statement
            if (($previous_bal_total_qty_wo_bonus + $in_qty) == 0) {
                $bal_rate = ($previous_bal_total + $in_total);
            }
            $bal_rate = ($previous_bal_total + $in_total) / ($previous_bal_total_qty_wo_bonus + $in_qty);
            */
            /**
             * Get Balance Rate Condition end
             * By Shahzaib Coding
             */


            /**
             * Get Balance Total Condition start
             * By Shahzaib Coding
             */
            if ($getTotalQuantity < 0) {
                $bal_total = 0;
            } else {
                $bal_total = $bal_total_qty_wo_bonus * $bal_rate;
            }
            /**
             * Get Balance Total Condition end
             * By Shahzaib Coding
             */


            /* previous code
            if (($previous_bal_total_qty_wo_bonus + $in_qty) == 0) {
                $bal_rate = ($previous_bal_total + $in_qty);
            } else {
                $bal_rate = ($previous_bal_total + $in_qty) / ($previous_bal_total_qty_wo_bonus + $in_qty);
            }
            // $bal_rate = ($previous_bal_total + $in_total) / ($previous_bal_total_qty_wo_bonus + $in_qty);
            $bal_total = $bal_total_qty_wo_bonus * $bal_rate;
            */


            $stock_movement = new StockMovementModels();

            $stock_movement_values = [
                'type_of_invoice' => $invoice_type_text,
                'product_code' => $product_code,
                'product_name' => $product_name,
                'warehouse' => $warehouse,
                'in_qty' => $in_qty,
                'in_bonus' => $in_bonus,
                'in_rate' => $in_rate,
                'in_total' => $in_total,
                'out_qty' => $out_qty,
                'out_bonus' => $out_bonus,
                'out_rate' => $out_rate,
                'out_total' => $out_total,
                'internal_hold' => $internal_hold,
                'internal_bonus' => $internal_bonus,
                'internal_claim' => $internal_claim,
                'bal_qty_for_sale' => $bal_qty_for_sale,
                'bal_bonus_inward' => $bal_bonus_inward,
                'bal_bonus_outward' => $bal_bonus_outward,
                'bal_bonus_qty' => $bal_bonus_qty,
                'bal_hold' => $bal_hold,
                'bal_total_hold' => $bal_total_hold,
                'bal_claims' => $bal_claims,
                'bal_total_qty_wo_bonus' => $bal_total_qty_wo_bonus,
                'bal_total_qty' => $bal_total_qty,
                'bal_rate' => $bal_rate,
                'bal_total' => $bal_total,
                'bal_voucher_code' => $voucher_code,
                'bal_remarks' => $remarks,
            ];

            $stock_movement = $this->stock_movement_values($stock_movement_values, $stock_movement);

            if (!$stock_movement->save()) {
                $flag = false;
            }
        }

        return $flag;
    }

    ///////////////////////////////////////////////////// For Product Recover //////////////////////////////////////////////////////////
    public function stock_movement_module_product_recover($array, $voucher_code, $invoice_type_text, $remarks)
    {
        $flag = true;

        foreach ($array as $value) {

            $product_code = $value['product_code'];
            $product_name = $value['product_name'];
            $warehouse = $value['warehouse'];

            $previous_stock = $this->product_stock_movement_last_row($product_code);

            if ($previous_stock !== null) {
                $previous_bal_qty_for_sale = $previous_stock->sm_bal_qty_for_sale;
                $previous_bal_rate = $previous_stock->sm_bal_rate;
                $previous_bal_total = $previous_stock->sm_bal_total;
                $previous_bal_bonus_qty = $previous_stock->sm_bal_bonus_qty;
                $previous_bal_total_hold = $previous_stock->sm_bal_total_hold;
                $previous_bal_claims = $previous_stock->sm_bal_claims;
                $previous_bal_total_qty_wo_bonus = $previous_stock->sm_bal_total_qty_wo_bonus;
            } else {
                $previous_bal_qty_for_sale = 0;
                $previous_bal_rate = 0;
                $previous_bal_total = 0;
                $previous_bal_bonus_qty = 0;
                $previous_bal_total_hold = 0;
                $previous_bal_claims = 0;
            }

            $in_qty = $value['product_qty'];
            $in_bonus = $value['product_bonus_qty'];
//            $in_rate = $value['product_rate'];//hamza
            $in_rate = $previous_bal_rate;//hamza

//            $in_total = $in_qty * $in_rate; //hamza
            $in_total = $in_qty * $in_rate; //mustafa

            $out_qty = null;
            $out_bonus = null;
            $out_rate = null;
            $out_total = $out_qty * $out_rate;

            $internal_hold = null;
            $internal_bonus = null;
            $internal_claim = null;

            $bal_qty_for_sale = $previous_bal_qty_for_sale + $in_qty - $out_qty - $internal_claim - $internal_bonus - $internal_hold;

            $bal_bonus_inward = $in_bonus;
            $bal_bonus_outward = $out_bonus;
            $bal_bonus_qty = $previous_bal_bonus_qty + $bal_bonus_inward - $bal_bonus_outward + $internal_bonus;

            $bal_hold = $internal_hold;
            $bal_total_hold = $previous_bal_total_hold + $bal_hold;

            $bal_claims = $previous_bal_claims + $internal_claim;

            $bal_total_qty_wo_bonus = $bal_qty_for_sale + $bal_total_hold + $bal_claims;
            $bal_total_qty = $bal_qty_for_sale + $bal_bonus_qty + $bal_total_hold + $bal_claims;


            /**
             * Check-Is-Stock-Negative-Positive, Get-Total-Quantity variables start
             * By Shahzaib Coding
             */
            $checkIsStockNegOrPos = 0;
            $getTotalQuantity = 0;
            /**
             * Check-Is-Stock-Negative-Positive, Get-Total-Quantity variables end
             * By Shahzaib Coding
             */

            /**
             * Quantity Control Condition start
             * By Shahzaib Coding
             */
            if ($previous_bal_total_qty_wo_bonus < 0) {
                $checkIsStockNegOrPos = +($previous_bal_total_qty_wo_bonus) + +($in_qty);
                $getTotalQuantity = $checkIsStockNegOrPos;
            } else {
                /**
                 * This Commit line for sale transaction purpose
                 * $checkIsStockNegOrPos = +($previous_bal_total_qty_wo_bonus) - +($in_qty);
                 */
                $checkIsStockNegOrPos = +($previous_bal_total_qty_wo_bonus) + +($in_qty);
                $getTotalQuantity = $checkIsStockNegOrPos;
            }
            /**
             * Quantity Control Condition else
             * By Shahzaib Coding
             */


            /**
             * Check-Stock-Valuation variables start
             * By Shahzaib Coding
             */

            if (intval($getTotalQuantity) !== 0) {
                $checkValuation = ($previous_bal_total + $in_total) / $getTotalQuantity;
            } else {
                $checkValuation = 0;
            }
            /**
             * Check-Stock-Valuation variables end
             * By Shahzaib Coding
             */


            /**
             * Get Balance Rate Condition start
             * By Shahzaib Coding
             */
            if ($previous_bal_total > 0) {
                $bal_rate = ($previous_bal_total + $in_total) / $getTotalQuantity;

            } else if ($previous_bal_total <= 0 || $checkValuation === 0) {
                $bal_rate = $in_rate;

            } else {
                $bal_rate = ($previous_bal_total + $in_total) / $getTotalQuantity;

            }

            /* previous if statement
            if (($previous_bal_total_qty_wo_bonus + $in_qty) == 0) {
                $bal_rate = ($previous_bal_total + $in_total);
            }
            $bal_rate = ($previous_bal_total + $in_total) / ($previous_bal_total_qty_wo_bonus + $in_qty);
            */
            /**
             * Get Balance Rate Condition end
             * By Shahzaib Coding
             */


            /**
             * Get Balance Total Condition start
             * By Shahzaib Coding
             */
            if ($getTotalQuantity < 0) {
                $bal_total = 0;
            } else {
                $bal_total = $bal_total_qty_wo_bonus * $bal_rate;
            }
            /**
             * Get Balance Total Condition end
             * By Shahzaib Coding
             */


            /* previous code
            if (($previous_bal_total_qty_wo_bonus + $in_qty) == 0) {
                $bal_rate = ($previous_bal_total + $in_qty);
            } else {
                $bal_rate = ($previous_bal_total + $in_qty) / ($previous_bal_total_qty_wo_bonus + $in_qty);
            }

            // $bal_rate = ($previous_bal_total + $in_total) / ($previous_bal_total_qty_wo_bonus + $in_qty);

            $bal_total = $bal_total_qty_wo_bonus * $bal_rate;

            */


            $stock_movement = new StockMovementModels();

            $stock_movement_values = [
                'type_of_invoice' => $invoice_type_text,
                'product_code' => $product_code,
                'product_name' => $product_name,
                'warehouse' => $warehouse,
                'in_qty' => $in_qty,
                'in_bonus' => $in_bonus,
                'in_rate' => $in_rate,
                'in_total' => $in_total,
                'out_qty' => $out_qty,
                'out_bonus' => $out_bonus,
                'out_rate' => $out_rate,
                'out_total' => $out_total,
                'internal_hold' => $internal_hold,
                'internal_bonus' => $internal_bonus,
                'internal_claim' => $internal_claim,
                'bal_qty_for_sale' => $bal_qty_for_sale,
                'bal_bonus_inward' => $bal_bonus_inward,
                'bal_bonus_outward' => $bal_bonus_outward,
                'bal_bonus_qty' => $bal_bonus_qty,
                'bal_hold' => $bal_hold,
                'bal_total_hold' => $bal_total_hold,
                'bal_claims' => $bal_claims,
                'bal_total_qty_wo_bonus' => $bal_total_qty_wo_bonus,
                'bal_total_qty' => $bal_total_qty,
                'bal_rate' => $bal_rate,
                'bal_total' => $bal_total,
                'bal_voucher_code' => $voucher_code,
                'bal_remarks' => $remarks,
            ];

            $stock_movement = $this->stock_movement_values($stock_movement_values, $stock_movement);

            if (!$stock_movement->save()) {
                $flag = false;
            }
        }

        return $flag;
    }

    public function stock_movement_values($value_array, $stock_movement)
    {
        $user = Auth::user();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $day_end_id = $day_end->de_id;
        $day_end_date = $day_end->de_datetime;
        $datetime = Carbon::now()->toDateTimeString();

        $stock_movement->sm_type = $value_array['type_of_invoice'];
        $stock_movement->sm_product_code = $value_array['product_code'];
        $stock_movement->sm_product_name = $value_array['product_name'];
        $stock_movement->sm_warehouse_id = $value_array['warehouse'];

        $stock_movement->sm_in_qty = $value_array['in_qty'];
        $stock_movement->sm_in_bonus = $value_array['in_bonus'];
        $stock_movement->sm_in_rate = $value_array['in_rate'];
        $stock_movement->sm_in_total = $value_array['in_total'];

        $stock_movement->sm_out_qty = $value_array['out_qty'];
        $stock_movement->sm_out_bonus = $value_array['out_bonus'];
        $stock_movement->sm_out_rate = $value_array['out_rate'];
        $stock_movement->sm_out_total = $value_array['out_total'];

        $stock_movement->sm_internal_hold = $value_array['internal_hold'];
        $stock_movement->sm_internal_bonus = $value_array['internal_bonus'];
        $stock_movement->sm_internal_claim = $value_array['internal_claim'];

        $stock_movement->sm_bal_qty_for_sale = $value_array['bal_qty_for_sale'] === null ? 0 : $value_array['bal_qty_for_sale'];

        $stock_movement->sm_bal_bonus_inward = $value_array['bal_bonus_inward'] === null ? 0 : $value_array['bal_bonus_inward'];
        $stock_movement->sm_bal_bonus_outward = $value_array['bal_bonus_outward'] === null ? 0 : $value_array['bal_bonus_outward'];
        $stock_movement->sm_bal_bonus_qty = $value_array['bal_bonus_qty'] === null ? 0 : $value_array['bal_bonus_qty'];

        $stock_movement->sm_bal_hold = $value_array['bal_hold'] === null ? 0 : $value_array['bal_hold'];
        $stock_movement->sm_bal_total_hold = $value_array['bal_total_hold'] === null ? 0 : $value_array['bal_total_hold'];

        $stock_movement->sm_bal_claims = $value_array['bal_claims'] === null ? 0 : $value_array['bal_claims'];

        $stock_movement->sm_bal_total_qty_wo_bonus = $value_array['bal_total_qty_wo_bonus'] === null ? 0 : $value_array['bal_total_qty_wo_bonus'];
        $stock_movement->sm_bal_total_qty = $value_array['bal_total_qty'] === null ? 0 : $value_array['bal_total_qty'];
        $stock_movement->sm_bal_rate = $value_array['bal_rate'] === null ? 0 : $value_array['bal_rate'];
        $stock_movement->sm_bal_total = $value_array['bal_total'] === null ? 0 : $value_array['bal_total'];

        $stock_movement->sm_day_end_id = $day_end_id;
        $stock_movement->sm_day_end_date = $day_end_date;
        $stock_movement->sm_voucher_code = $value_array['bal_voucher_code'];
        $stock_movement->sm_remarks = $value_array['bal_remarks'];
        $stock_movement->sm_user_id = $user->user_id;
        $stock_movement->sm_clg_id = $user->user_clg_id;
        $stock_movement->sm_date_time = $datetime;

        return $stock_movement;
    }

    public function stock_movement_module_sale_order($array, $voucher_code, $invoice_type_text, $remarks)
    {
        $flag = true;

        $user = Auth::user();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $day_end_id = $day_end->de_id;
        $day_end_date = $day_end->de_datetime;
        $datetime = Carbon::now()->toDateTimeString();

        foreach ($array as $value) {
            $product_code = $value['product_code'];
            $product_name = $value['product_name'];
            $warehouse = $value['warehouse'];

            $previous_stock = $this->product_stock_movement_last_row($product_code);

            if ($previous_stock !== null) {
                $previous_bal_qty_for_sale = $previous_stock->sm_bal_qty_for_sale;
                $previous_bal_rate = $previous_stock->sm_bal_rate;
                $previous_bal_total = $previous_stock->sm_bal_total;
                $previous_bal_bonus_qty = $previous_stock->sm_bal_bonus_qty;
                $previous_bal_total_hold = $previous_stock->sm_bal_total_hold;
                $previous_bal_claims = $previous_stock->sm_bal_claims;
            }


            $in_qty = 0;
            $in_bonus = 0;
            $in_rate = 0;
            $in_total = $in_qty * $in_rate;

            $out_qty = 0;
            $out_bonus = 0;
            $out_rate = 0;
            $out_total = $out_qty * $out_rate;


            $internal_hold = $value['product_hold_qty'];
            $internal_bonus = 0;
            $internal_claim = 0;

            $bal_qty_for_sale = $previous_bal_qty_for_sale + $in_qty - $out_qty - $internal_claim - $internal_bonus - $internal_hold;

            $bal_bonus_inward = $in_bonus;
            $bal_bonus_outward = $out_bonus;
            $bal_bonus_qty = $previous_bal_bonus_qty + $bal_bonus_inward - $bal_bonus_outward + $internal_bonus;

            $bal_hold = $internal_hold;
            $bal_total_hold = $previous_bal_total_hold + $bal_hold;

            $bal_claims = $previous_bal_claims + $internal_claim;

            $bal_total_qty_wo_bonus = $bal_qty_for_sale + $bal_total_hold + $bal_claims;
            $bal_total_qty = $bal_qty_for_sale + $bal_bonus_qty + $bal_total_hold + $bal_claims;
            $bal_rate = ($previous_bal_total + $in_total) / ($bal_total_qty_wo_bonus + $in_qty);
            $bal_total = $bal_total_qty_wo_bonus * $bal_rate;

            $stock_movement = new StockMovementModels();

            $stock_movement->sm_type = $invoice_type_text;
            $stock_movement->sm_product_code = $product_code;
            $stock_movement->sm_product_name = $product_name;
            $stock_movement->sm_warehouse_id = $warehouse;

            $stock_movement->sm_in_qty = $in_qty;
            $stock_movement->sm_in_bonus = $in_bonus;
            $stock_movement->sm_in_rate = $in_rate;
            $stock_movement->sm_in_total = $in_total;

            $stock_movement->sm_out_qty = $out_qty;
            $stock_movement->sm_out_bonus = $out_bonus;
            $stock_movement->sm_out_rate = $out_rate;
            $stock_movement->sm_out_total = $out_total;

            $stock_movement->sm_internal_hold = $internal_hold;
            $stock_movement->sm_internal_bonus = $internal_bonus;
            $stock_movement->sm_internal_claim = $internal_claim;

            $stock_movement->sm_bal_qty_for_sale = $bal_qty_for_sale;

            $stock_movement->sm_bal_bonus_inward = $bal_bonus_inward;
            $stock_movement->sm_bal_bonus_outward = $bal_bonus_outward;
            $stock_movement->sm_bal_bonus_qty = $bal_bonus_qty;

            $stock_movement->sm_bal_hold = $bal_hold;
            $stock_movement->sm_bal_total_hold = $bal_total_hold;

            $stock_movement->sm_bal_claims = $bal_claims;

            $stock_movement->sm_bal_total_qty_wo_bonus = $bal_total_qty_wo_bonus;
            $stock_movement->sm_bal_total_qty = $bal_total_qty;
            $stock_movement->sm_bal_rate = $bal_rate;
            $stock_movement->sm_bal_total = $bal_total;

            $stock_movement->sm_day_end_id = $day_end_id;
            $stock_movement->sm_day_end_date = $day_end_date;
            $stock_movement->sm_voucher_code = $voucher_code;
            $stock_movement->sm_remarks = $remarks;
            $stock_movement->sm_user_id = $user->user_id;
            $stock_movement->sm_clg_id = $user->user_clg_id;
            $stock_movement->sm_date_time = $datetime;


            if (!$stock_movement->save()) {
                $flag = false;
            }
        }

        return $flag;
    }

    public function product_stock_movement_last_row($product_code)
    {
        $user = Auth::user();
        $product_stock = StockMovementModels::where('sm_clg_id', $user->user_clg_id)->where('sm_product_code', $product_code)->orderBy('sm_id', 'DESC')->first();

        return $product_stock;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////// Cash Voucher Related Code //////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////

    public function assign_cash_voucher_values($total_voucher_amount, $total_voucher_remarks, $cash_voucher, $day_end, $user, $prefix, $account_uid)
    {
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $remarks = $prefix . '_remarks';
        $account_id = $prefix . '_account_id';
        $total_amount = $prefix . '_total_amount';
        $created_datetime = $prefix . '_created_datetime';
        $day_end_id = $prefix . '_day_end_id';
        $day_end_date = $prefix . '_day_end_date';
        $createdby = $prefix . '_createdby';
        $college = $prefix . '_clg_id';
        $branch = $prefix . '_branch_id';
        $brwsr_info = $prefix . '_brwsr_info';
        $ip_adrs = $prefix . '_ip_adrs';


        $cash_voucher->$remarks = $total_voucher_remarks;
        $cash_voucher->$account_id = $account_uid;
        $cash_voucher->$total_amount = $total_voucher_amount;
        $cash_voucher->$created_datetime = Carbon::now()->toDateTimeString();
        $cash_voucher->$day_end_id = $day_end->de_id;
        $cash_voucher->$day_end_date = $day_end->de_datetime;
        $cash_voucher->$createdby = $user->user_id;
        $cash_voucher->$college = $user->user_clg_id;
        $cash_voucher->$branch = Session::get('branch_id');
        $cash_voucher->$brwsr_info = $brwsr_rslt;
        $cash_voucher->$ip_adrs = $ip_rslt;

        return $cash_voucher;
    }

    public function cash_voucher_items_values($account_uid, $account_name, $amount, $remarks, $cash_voucher_items, $cv_id, $item_prefix)
    {
        $cash_voucher_id = $item_prefix . '_voucher_id';
        $cash_voucher_account_id = $item_prefix . '_account_id';
        $cash_voucher_account_name = $item_prefix . '_account_name';
        $cash_voucher_amount = $item_prefix . '_amount';
        $cash_voucher_remarks = $item_prefix . '_remarks';


        $cash_voucher_items->$cash_voucher_id = $cv_id;
        $cash_voucher_items->$cash_voucher_account_id = $account_uid;
        $cash_voucher_items->$cash_voucher_account_name = $account_name;
        $cash_voucher_items->$cash_voucher_amount = $amount;
        $cash_voucher_items->$cash_voucher_remarks = ucfirst(trim($remarks));

        return $cash_voucher_items;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////// Bank Voucher Related Code //////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////

    public function assign_bank_voucher_values($account_uid, $total_voucher_amount, $total_voucher_remarks, $bank_voucher, $day_end, $user, $prefix, $total_bank_amount)
    {
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $account_id = $prefix . '_account_id';
        $total_amount = $prefix . '_total_amount';
        $bank_amount = $prefix . '_bank_amount';
        $remarks = $prefix . '_remarks';
        $created_datetime = $prefix . '_created_datetime';
        $day_end_id = $prefix . '_day_end_id';
        $day_end_date = $prefix . '_day_end_date';
        $createdby = $prefix . '_createdby';
        $brwsr_info = $prefix . '_brwsr_info';
        $ip_adrs = $prefix . '_ip_adrs';


        $bank_voucher->$account_id = $account_uid;
        $bank_voucher->$total_amount = $total_voucher_amount;
        $bank_voucher->$bank_amount = $total_voucher_amount;
        $bank_voucher->$remarks = $total_voucher_remarks;
        $bank_voucher->$created_datetime = Carbon::now()->toDateTimeString();
        $bank_voucher->$day_end_id = $day_end->de_id;
        $bank_voucher->$day_end_date = $day_end->de_datetime;
        $bank_voucher->$createdby = $user->user_id;
        $bank_voucher->$brwsr_info = $brwsr_rslt;
        $bank_voucher->$ip_adrs = $ip_rslt;

        return $bank_voucher;
    }

    public function bank_voucher_items_values($account_uid, $account_name, $amount, $remarks, $bank_voucher_items, $br_id, $item_prefix, $type)
    {
        $bank_voucher_id = $item_prefix . '_voucher_id';
        $bank_voucher_account_id = $item_prefix . '_account_id';
        $bank_voucher_account_name = $item_prefix . '_account_name';
        $bank_voucher_amount = $item_prefix . '_amount';
        $bank_voucher_remarks = $item_prefix . '_remarks';
        $bank_voucher_type = $item_prefix . '_type';


        $bank_voucher_items->$bank_voucher_id = $br_id;
        $bank_voucher_items->$bank_voucher_account_id = $account_uid;
        $bank_voucher_items->$bank_voucher_account_name = $account_name;
        $bank_voucher_items->$bank_voucher_amount = $amount;
        $bank_voucher_items->$bank_voucher_remarks = ucfirst(trim($remarks));
        $bank_voucher_items->$bank_voucher_type = ucfirst($type);

        return $bank_voucher_items;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////// Transaction Related Code ///////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////

    public function AssignTransactionsValues($transaction, $dr_account, $amount, $cr_account, $notes, $type, $entry_id = 0)
    {
        $user = Auth::user();
        $transaction->trans_type = $type;
        $transaction->trans_dr = $dr_account;
        $transaction->trans_cr = $cr_account;
        $transaction->trans_amount = $amount;
        $transaction->trans_notes = $notes;
        $transaction->trans_datetime = Carbon::now()->toDateTimeString();
        $transaction->trans_entry_id = $entry_id;
        $transaction->trans_clg_id = $user->user_clg_id;
        $transaction->trans_branch_id = Session::get('branch_id');
        $transaction->trans_year_id = $this->getYearEndId();

        // coding from shahzaib start
        $tbl_var_name = 'transaction';
        $prfx = 'trans';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now()->toDateTimeString();
        // coding from shahzaib end

        return $transaction;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////// Balances Related Code //////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////

    public function calculate_account_balance($account_uid)
    {
        $user = Auth::user();
        $total = BalancesModel::where('bal_clg_id', $user->user_clg_id)->where('bal_account_id', $account_uid)->orderBy('bal_id', 'DESC')->pluck('bal_total')->first();

        return $total;
    }

    public function AssignAccountBalancesValues($balance, $transaction_id, $account, $amount, $type, $remarks, $transaction_type, $detail_remarks, $voucher_id, $posting_ref_id, $voucher_no,
                                                $year_end_id,$branch_id = null)
    {
//        dump($branch_id);
        $user = Auth::user();

        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();

        $account_head = substr($account, 0, 1);
        $debit_amount = 0;
        $credit_amount = 0;

        $previous_balance = $this->calculate_account_balance($account);

        // if ($account_head == config('global_variables.assets') || $account_head == config('global_variables.expense')) {

        if ($type == 'Dr') {
            $total_balance = $previous_balance + $amount;
            $debit_amount = $amount;

        } else {
            $total_balance = $previous_balance - $amount;
            $credit_amount = $amount;
        }

        // }
        // elseif ($account_head == config('global_variables.liabilities') || $account_head == config('global_variables.revenue') || $account_head == config('global_variables.equity')) {

        //     if ($type == 'Dr') {

        //         $total_balance = $previous_balance - $amount;
        //         $debit_amount = $amount;
        //     } else {
        //         $total_balance = $previous_balance + $amount;
        //         $credit_amount = $amount;
        //     }

        // }

        $balance->bal_account_id = $account;
        $balance->bal_transaction_type = $transaction_type;
        $balance->bal_remarks = ucfirst($remarks);
        $balance->bal_dr = $debit_amount;
        $balance->bal_cr = $credit_amount;
        $balance->bal_total = $total_balance;
        $balance->bal_transaction_id = $transaction_id;
        $balance->bal_datetime = Carbon::now()->toDateTimeString();
        $balance->bal_day_end_id = $day_end->de_id;
        $balance->bal_day_end_date = $day_end->de_datetime;
        $balance->bal_detail_remarks = $detail_remarks;
        $balance->bal_voucher_number = $voucher_id;
        $balance->bal_v_no = $voucher_no;
        $balance->bal_user_id = $user->user_id;
        $balance->bal_pr_id = $posting_ref_id;
        $balance->bal_clg_id = $user->user_clg_id;
        $balance->bal_year_id = $this->getYearEndId();
        $balance->bal_v_year_id = $year_end_id;
        if ($branch_id != null) {
            $balance->bal_branch_id = $branch_id;
        } else {
            $balance->bal_branch_id = Session::get('branch_id');
        }


        // coding from shahzaib start
        $tbl_var_name = 'balance';
        $prfx = 'bal';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now();
        // coding from shahzaib end

        return $balance;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////// Student Balances Related Code //////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////

    public function get_registration_number($student_id)
    {
        $user = Auth::user();
        $registration_number = Student::where('id', $student_id)->where('clg_id', $user->user_clg_id)->pluck('registration_no')->first();

        return $registration_number;
    }

    public function get_student_id($registration_number)
    {
        $user = Auth::user();
        $student_id = Student::where('registration_no', $registration_number)->where('clg_id', $user->user_clg_id)->pluck('id')->first();
        return $student_id;
    }

    public function get_student_name($registration_number)
    {
        $user = Auth::user();
        $student_id = Student::where('registration_no', $registration_number)->where('clg_id', $user->user_clg_id)->pluck('full_name')->first();
        return $student_id;
    }

    public function get_studentName($student_id)
    {
        $user = Auth::user();
        $student_name = Student::where('id', $student_id)->where('clg_id', $user->user_clg_id)->pluck('full_name')->first();
        return $student_name;
    }

    public function calculate_student_balance($student_id)
    {
        $user = Auth::user();
        $total = StudentBalances::where('sbal_clg_id', $user->user_clg_id)->where('sbal_student_id', $student_id)->orderBy('sbal_id', 'DESC')->pluck('sbal_total')->first();

        return $total;
    }

    //entry in student balance table
    public function AssignStudentBalancesValues($balance, $account, $amount, $type, $transaction_type, $detail_remarks, $voucher_id, $student_id, $registration_number, $branch_id = null)
    {
        $user = Auth::user();

        $debit_amount = 0;
        $credit_amount = 0;

        $previous_balance = $this->calculate_student_balance($student_id);

        // if ($account_head == config('global_variables.assets') || $account_head == config('global_variables.expense')) {

        if ($type == 'Dr') {
            $total_balance = $previous_balance + $amount;
            $debit_amount = $amount;

        } else {
            $total_balance = $previous_balance - $amount;
            $credit_amount = $amount;
        }

        $balance->sbal_student_id = $student_id;
        $balance->sbal_registration_no = $registration_number;
        $balance->sbal_account_id = $account;
        $balance->sbal_transaction_type = $transaction_type;
        $balance->sbal_dr = $debit_amount;
        $balance->sbal_cr = $credit_amount;
        $balance->sbal_total = $total_balance;

        $balance->sbal_datetime = Carbon::now()->toDateTimeString();

        $balance->sbal_detail_remarks = $detail_remarks;
        $balance->sbal_voucher_number = $voucher_id;

        $balance->sbal_user_id = $user->user_id;
        $balance->sbal_clg_id = $user->user_clg_id;
        if ($branch_id != null) {
            $balance->sbal_branch_id = $branch_id;
        } else {
            $balance->sbal_branch_id = Session::get('branch_id');
        }


        // coding from shahzaib start
        $tbl_var_name = 'balance';
        $prfx = 'sbal';
        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();
        $brwsr_col = $prfx . '_brwsr_info';
        $ip_col = $prfx . '_ip_adrs';
        $updt_date_col = $prfx . '_update_datetime';

        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
        $$tbl_var_name->$ip_col = $ip_rslt;
        $$tbl_var_name->$updt_date_col = Carbon::now()->toDateTimeString();;

        // coding from shahzaib end

        return $balance;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////// Account Related Code ///////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////

    public function get_teller_or_purchaser_account($teller_id)
    {
        $user = Auth::user();
        $account = User::where('user_clg_id', $user->user_clg_id)->where('user_id', $teller_id)->first();

        return $account;
    }

    public function get_account_name($account_id)
    {
        $user = Auth::user();
        $account_name = AccountRegisterationModel::where('account_clg_id', $user->user_clg_id)->where('account_uid', $account_id)->pluck('account_name')->first();

        return $account_name;
    }

    public function get_branch_id($account_id)
    {
        $user = Auth::user();
        $branch_id = AccountRegisterationModel::where('account_clg_id', $user->user_clg_id)->where('account_uid', $account_id)->pluck('account_branch_id')->first();

        return $branch_id;
    }

    public function get_all_accounts_uid_by_first_head($head)
    {
        $user = Auth::user();
        $account_uids = AccountRegisterationModel::where('account_clg_id', $user->user_clg_id)->where('account_uid', 'like', $head . '%')->pluck('account_uid');

        return $account_uids;
    }

    public function get_account_query($case_name)
    {

        $user = auth()->user();
        $query = null;

        $head_fixed_asset = config('global_variables.fixed_asset_second_head');
        $fixed_account_parent = AccountHeadsModel::where('coa_clg_id', $user->user_clg_id)->where('coa_parent', $head_fixed_asset)->pluck('coa_code');

        switch ($case_name) {
            case 'purchase':
                $heads = explode(',', config('global_variables.payable_receivable_purchaser'));
                if ($user->user_role_id == config('global_variables.purchaser_role_id')) {
                    $account = $this->get_teller_or_purchaser_account($user->user_id);
                    $purchaser_account = $account->user_purchaser_wic_account_uid;
                } else {
                    $purchaser_account = config('global_variables.purchaser_account');
                }
                $query = AccountRegisterationModel::where('account_clg_id', $user->user_clg_id)->whereIn('account_parent_code', $heads)
                    ->whereNotIn(
                        'account_uid', AccountRegisterationModel::where('account_clg_id', $user->user_clg_id)->where('account_parent_code', config('global_variables.purchaser_account_head'))
                        ->where('account_uid', '!=', $purchaser_account)
                        ->pluck('account_uid')->all()
                    );

                break;

            case 'sale':

                $heads = explode(',', config('global_variables.payable_receivable_walk_in_customer'));
                if ($user->user_role_id == config('global_variables.teller_account_id')) {
                    $account = $this->get_teller_or_purchaser_account($user->user_id);
                    $wic_account = $account->user_teller_wic_account_uid;
                } else {
                    $wic_account = config('global_variables.walk_in_customer');
                }
                $query = AccountRegisterationModel::where('account_clg_id', $user->user_clg_id)->whereIn('account_parent_code', $heads)
                    ->whereNotIn(
                        'account_uid', AccountRegisterationModel::where('account_clg_id', $user->user_clg_id)->where('account_parent_code', config('global_variables.walk_in_customer_head'))
                        ->where('account_uid', '!=', $wic_account)
                        ->pluck('account_uid')->all()
                    );

                break;

            case 'cash_voucher':

                $heads = explode(',', config('global_variables.cash_voucher_accounts_not_in'));
                $query = AccountRegisterationModel::query();
                $query = $query->whereNotIn('account_parent_code', $heads)
                    ->whereNotIn('account_parent_code', $fixed_account_parent)
                    ->where('account_clg_id', $user->user_clg_id)
                    ->orderBy('account_parent_code', 'ASC');

                $query2 = AccountRegisterationModel::query();
                $query2 = $query2->where('account_parent_code', config('global_variables.cash'))
                    ->where('account_clg_id', $user->user_clg_id)
                    ->where('account_uid', '!=', config('global_variables.stock_in_hand'))
                    ->orderBy('account_parent_code', 'ASC');

                break;

            case 'bank_voucher':

                $heads = explode(',', config('global_variables.bank_voucher_accounts_not_in'));
                $query = AccountRegisterationModel::query();
                $query = $query->whereNotIn('account_parent_code', $heads)
                    ->whereNotIn('account_parent_code', $fixed_account_parent)
                    ->where('account_clg_id', $user->user_clg_id)
                    ->orderBy('account_parent_code', 'ASC');

                $query2 = AccountRegisterationModel::query();
                $query2 = $query2->where('account_parent_code', config('global_variables.bank_head'))
                    ->where('account_clg_id', $user->user_clg_id)
                    ->where('account_uid', '!=', config('global_variables.stock_in_hand'))
                    ->orderBy('account_parent_code', 'ASC');
                break;

            case 'expense_payment_voucher':

                $expense_voucher_accounts_cash_bank_heads = explode(',', config('global_variables.expense_voucher_accounts_cash_bank'));
                $query = AccountRegisterationModel::whereIn('account_parent_code', $expense_voucher_accounts_cash_bank_heads)->where('account_clg_id', $user->user_clg_id)->orderBy('account_uid', 'ASC');

                $expense_voucher_accounts_not_in_heads = explode(',', config('global_variables.expense_voucher_accounts_not_in'));
                $query2 = AccountRegisterationModel::query();
                $query2 = $query2->where('account_clg_id', $user->user_clg_id)->where('account_parent_code', 'like', config('global_variables.expense') . '%')
                    ->whereNotIn('account_parent_code', $expense_voucher_accounts_not_in_heads)
                    ->orderBy('account_parent_code', 'ASC');

                break;

            case 'journal_voucher':
                $journal_voucher_accounts_not_in_heads = explode(',', config('global_variables.journal_voucher_accounts_not_in'));

                $query = AccountRegisterationModel::query();
                $query = $query->whereNotIn('account_parent_code', $journal_voucher_accounts_not_in_heads)
                    ->whereNotIn('account_parent_code', $fixed_account_parent)
                    ->where('account_clg_id', $user->user_clg_id)
                    ->orderBy('account_parent_code', 'ASC');

                break;

            case 'salary_payment_voucher':

                $salary_payment_accounts_not_in_heads = explode(',', config('global_variables.salary_payment_accounts_not_in'));
                $query = AccountRegisterationModel::query();
                $query = $query->whereNotIn('account_parent_code', $salary_payment_accounts_not_in_heads)
                    ->where('account_clg_id', $user->user_clg_id)
                    ->orderBy('account_parent_code', 'ASC');

                break;

            case 'advance_salary':

                $heads = explode(',', config('global_variables.payable_receivable_cash_bank'));

                $query = AccountRegisterationModel::query();
                $query = $query->whereIn('account_parent_code', $heads)
                    ->where('account_clg_id', $user->user_clg_id)->where('account_uid', '!=', config('global_variables.stock_in_hand'))
                    ->orderBy('account_parent_code', 'ASC');

                $query2 = AccountRegisterationModel::query();
                $query2 = $query2->where('account_clg_id', $user->user_clg_id)->where('account_parent_code', '=', config('global_variables.advance_salary_head'))
                    ->where('account_uid', '!=', config('global_variables.stock_in_hand'))
                    ->orderBy('account_parent_code', 'ASC');

                break;

            case 'payable_receivable':

                $heads = explode(',', config('global_variables.payable_receivable'));

                $query = AccountRegisterationModel::query();
                $query = $query->whereIn('account_parent_code', $heads)
                    ->where('account_clg_id', $user->user_clg_id)
                    ->orderBy('account_parent_code', 'ASC');

                $query2 = AccountRegisterationModel::query();
                $query2 = $query2
                    ->where('account_clg_id', $user->user_clg_id)
                    ->where('account_uid', 'like', '4%')
                    ->whereNotIn('account_parent_code', [41111, 41410])
                    ->orderBy('account_parent_code', 'ASC');

                break;
            case 'claim_account':

                $heads = explode(',', config('global_variables.party_claims_accounts_head'));

                $query = AccountRegisterationModel::query();
                $query = $query->whereIn('account_parent_code', $heads)
                    ->where('account_clg_id', $user->user_clg_id)
                    ->where('account_delete_status', '!=', 1)
                    ->where('account_disabled', '!=', 1)
                    ->orderBy('account_parent_code', 'ASC');

                $query2 = AccountRegisterationModel::query(); //this query note use any where need to modyfy for new query if need new account query
                $query2 = $query2
                    ->where('account_clg_id', $user->user_clg_id)
                    ->where('account_uid', 'like', '4%')
                    ->orderBy('account_parent_code', 'ASC');

                break;
            case 'revenue':

                $query = AccountRegisterationModel::query();
                $query = $query->where('account_uid', 'Like', '3%')
                    ->where('account_clg_id', $user->user_clg_id)
                    ->orderBy('account_parent_code', 'ASC');

                $query2 = AccountRegisterationModel::query();
                $query2 = $query2
                    ->where('account_uid', 'Like', '3%')
                    ->where('account_clg_id', $user->user_clg_id)
                    ->orderBy('account_parent_code', 'ASC');

                break;
            default:
                $query = [];
                break;
        }

        $accounts = $this->filterAccount($query);
        $accounts_2 = isset($query2) ? $this->filterAccount($query2) : null;

        return [$accounts, $accounts_2 ?? null];
    }

    public function filterAccount($query)
    {
        return $query->where('account_delete_status', '!=', 1)
            ->where('account_disabled', '!=', 1)
            ->orderBy('account_uid', 'ASC')
            ->get();
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////// Credit Card Machine Related Code ///////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////

    public function get_credit_card_info($machine_id)
    {
        $user = Auth::user();
        $machine = CreditCardMachineModel::where('ccm_clg_id', $user->user_clg_id)->where('ccm_id', $machine_id)->first();

        return $machine;
    }


    /////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////// Product Related Code ///////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////

    // Function to remove the spacial
    public function RemoveSpecialChar($str)
    {
        // Using str_replace() function
        // to replace the word
        $res = str_replace(array('\'', '"',
            ',', ';', '<', '>'), ' ', $str);

        // Returning the result
        return $res;
    }

    public function get_product_average_rate($barcode)
    {
        $user = Auth::user();
        $product_average_rate = ProductModel::where('pro_clg_id', $user->user_clg_id)->where('pro_p_code', $barcode)->pluck('pro_average_rate')->first();

        return $product_average_rate;
    }

    public function get_product_parent_code($barcode)
    {
        $user = Auth::user();
        $parent_code = ProductModel::where('pro_clg_id', $user->user_clg_id)->where('pro_p_code', $barcode)->pluck('pro_p_code')->first();

        return $parent_code;
    }

    public function get_all_warehouse()
    {
        $user = Auth::user();
        $warehouse = WarehouseModel::where('wh_clg_id', $user->user_clg_id)->where('wh_delete_status', '!=', 1)->where('wh_disabled', '!=', 1)->orderBy('wh_title', 'ASC')->get();

        return $warehouse;
    }

    public function get_all_products()
    {
        $user = Auth::user();

        $query = ProductModel::query();

        $query = DB::table('financials_products')
            ->leftJoin('financials_main_units', 'financials_main_units.mu_id', 'financials_products.pro_main_unit_id')
            ->leftJoin('financials_units', 'financials_units.unit_id', 'financials_products.pro_unit_id')
            ->where('pro_clg_id', $user->user_clg_id);


        if ($user->user_level != 100) {
//            $query->where('pro_reporting_group_id', $user->user_product_reporting_group_ids);
            $query->whereIn('pro_reporting_group_id', explode(',', $user->user_product_reporting_group_ids));

        }

        $products = $query->where('pro_status', config('global_variables.product_active_status'))
            ->where('pro_delete_status', '!=', 1)
            ->where('pro_disabled', '!=', 1)
            ->orderby('pro_title', 'ASC')
            ->get();

        return $products;
    }

    public function get_products_by_type($product_type)
    {
        $user = Auth::user();

        $query = ProductModel::query();

        if ($user->user_level != 100) {
            $query->where('pro_clg_id', $user->user_clg_id)->where('pro_reporting_group_id', $user->user_product_reporting_group_ids);
        }

        $products = $query->where('pro_type', $product_type)
            ->where('pro_clg_id', $user->user_clg_id)
            ->where('pro_delete_status', '!=', 1)
            ->where('pro_disabled', '!=', 1)
            ->where('pro_status', config('global_variables.product_active_status'))
            ->orderby('pro_title', 'ASC')
            ->get();

        return $products;
    }

    public function get_product_purchase_rate($barcode)
    {
        $user = Auth::user();
        $purchase_rate = ProductModel::where('pro_clg_id', $user->user_clg_id)->where('pro_p_code', $barcode)->pluck('pro_purchase_price')->first();

        return $purchase_rate;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////// Day End Related Code ///////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////

    public function day_end_date_only()
    {
        $user = Auth::user();
        $date = DayEndModel::where('de_clg_id', $user->user_clg_id)->where('de_datetime_status', 'OPEN')->orderBy('de_id', 'DESC')->pluck('de_datetime')->first();

        if ($date == null) {
            $date = date("d-m-Y");
        } else {
            $date = date("d-m-Y", strtotime($date));
        }

        return $date;
    }



    /////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////// Start Vouchers Code ////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////

    public function voucher_validation($request)
    {
        return $this->validate($request, [
            'remarks' => ['nullable', 'string'],
            'account' => ['required', 'numeric'],
            'status' => ['required'],
            'total_amount' => ['required', 'numeric'],
            'accountsval' => ['required', 'string'],
        ]);
    }

    public function assign_voucher_values($prfx, $voucher_number, $voucher, $account_uid, $total_voucher_amount, $voucher_remarks, $user, $day_end, $status, $voucher_type = 0)
    {

        $brwsr_rslt = $this->getBrwsrInfo();
        $ip_rslt = $this->getIp();

        $v_no = $prfx . '_v_no';
        $account_id = $prfx . '_account_id';
        $total_amount = $prfx . '_total_amount';
        $bank_amount = $prfx . '_bank_amount';
        $remarks = $prfx . '_remarks';
        $created_datetime = $prfx . '_created_datetime';
        $day_end_id = $prfx . '_day_end_id';
        $day_end_date = $prfx . '_day_end_date';
        $createdby = $prfx . '_createdby';
        $clg_id = $prfx . '_clg_id';
        $branch_id = $prfx . '_branch_id';
        $brwsr_info = $prfx . '_brwsr_info';
        $ip_adrs = $prfx . '_ip_adrs';
        $v_status = $prfx . '_status';
        $posted_by = $prfx . '_posted_by';
        $year_end_id = $prfx . '_year_id';


        $voucher->$v_no = $voucher_number;
        $voucher->$account_id = $account_uid;
        $voucher->$total_amount = $total_voucher_amount;
        $voucher->$remarks = $voucher_remarks;
        $voucher->$created_datetime = Carbon::now()->toDateTimeString();
        $voucher->$day_end_id = $day_end->de_id;
        $voucher->$day_end_date = $day_end->de_datetime;
        $voucher->$createdby = $user->user_id;
        $voucher->$clg_id = $user->user_clg_id;
        $voucher->$branch_id = Session::get('branch_id');
        $voucher->$brwsr_info = $brwsr_rslt;
        $voucher->$ip_adrs = $ip_rslt;
        $voucher->$v_status = $status;
        $voucher->$year_end_id = $this->getYearEndId();

        if ($status == 'post') {
            $voucher->$posted_by = $user->user_id;
        }

        if ($voucher_type == 1) {

            $voucher->$bank_amount = $total_voucher_amount;
        }

        return $voucher;
    }

    public function voucher_items_values($values_array, $voucher_number, $v_number, $prfx)
    {
        $data = [];

        $voucher_id = $prfx . '_voucher_id';
        $voucher_no = $prfx . '_v_no';
        $account_id = $prfx . '_account_id';
        $account_name = $prfx . '_account_name';
        $amount = $prfx . '_amount';
        $remarks = $prfx . '_remarks';
        $posting_reference = $prfx . '_pr_id';
        $year_end_id = $prfx . '_year_id';

        foreach ($values_array as $key) {
            $data[] = [
                $voucher_id => $voucher_number,
                $voucher_no => $v_number,
                $account_id => $key['account_code'],
                $account_name => $key['account_name'],
                $amount => $key['account_amount'],
                $remarks => ucfirst(trim($key['account_remarks'])),
                $posting_reference => $key['posting_reference'],
                $year_end_id => $this->getYearEndId(),
            ];
        }

        return $data;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////// End Vouchers Code //////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////// Start 4th level Account Code ///////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////

    public function get_fourth_level_account($parent_code, $operation, $where_where_in_condition)
    {
        $user = Auth::user();

        $operator = '=';
        $pre_percentage_sign = '';
        $post_percentage_sign = '';

        if ($operation == 1) {
            $operator = '!=';
        } elseif ($operation == 2) {
            $operator = 'like';
            $post_percentage_sign = '%';
        } elseif ($operation == 3) {
            $operator = 'not like';
            $post_percentage_sign = '%';
        }

        $query = AccountRegisterationModel::where('account_clg_id', $user->user_clg_id);

        if ($parent_code > 0) {

            if ($where_where_in_condition == 1) {
                $query->whereIn('account_parent_code', $parent_code);
            } else {
                $query->where('account_parent_code', $operator, $pre_percentage_sign . $parent_code . $post_percentage_sign);
            }
        }

//        if ($user->user_level != 100) {
//            $query->whereIn('account_group_id', explode(',', $user->user_account_reporting_group_ids));
//        }

        $accounts = $query
            ->where('account_uid', '!=', config('global_variables.stock_in_hand'))
            ->where('account_delete_status', '!=', 1)
            ->where('account_disabled', '!=', 1)
            ->orderBy('account_parent_code', 'ASC')
            ->orderBy('account_uid', 'ASC')
            ->get();

        return $accounts;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////// End 4th level Account Code /////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////


    /////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////// Start Employee Code function ///////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////

    public function generate_employee_code($id, $name)
    {
        $code = 'AAAA';
        $l = explode(" ", $name);
        $c = count($l);
        if ($c == 1) {
            $code = $name[0] . $name[0] . $name[0] . $name[0];
        } elseif ($c == 2) {
            $code = $l[0][0] . $l[1][0] . $l[1][0] . $l[1][0];
        } elseif ($c == 3) {
            $code = $l[0][0] . $l[1][0] . $l[2][0] . $l[2][0];
        } elseif ($c == 4) {
            $code = $l[0][0] . $l[1][0] . $l[2][0] . $l[3][0];
        }
        $code .= "-";
        $code .= str_pad($id, 4, '0', STR_PAD_LEFT);
        return strtoupper($code);
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////// End Employee Code function /////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////


    public function createLog($code, $type, $json_data)
    {
        $id = auth()->id();
        $ip = $this->getIp();
        $browser = $this->getBrwsrInfo();

        LogModel::createLog($code, $type, $json_data, now(), $id, $ip, $browser);
    }

    public function SendPasswordMail($email, $username, $password)
    {

        $sub_domain = (env('APP_URL'));
//        $params = [
//            'password'=>$password,
//            'username'=>$username,
//            'url_path'=>$sub_domain,
//        ];

        $client = new Client();
        $url = $sub_domain . '/public/_api/mailer/laravel_mail.php?email=' . $email . '&subject=Softagics%20Credentials&mailContent=User-Name: ' . $username . ' Password: ' . $password;

        $headers = [
            'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
        ];

        $response = $client->request('GET', $url, [
//             'json' => $params,
            'headers' => $headers,
            'verify' => false,
        ]);
        return $response;
    }

    public function SendResetPasswordMail($email, $token)
    {
        $sub_domain = (env('APP_URL'));
//        $params = [
//            'password'=>$password,
//            'username'=>$username,
//            'url_path'=>$sub_domain,
//        ];
        $recover_token = config('global_variables.password_change_path') . $token;
        $client = new Client();
        $url = $sub_domain . '/public/_api/mailer/reset_password.php?email=' . $email . '&token=' . $recover_token;

        $headers = [
            'api-key' => 'k3Hy5qr73QhXrmHLXhpEh6CQ'
        ];

        $response = $client->request('GET', $url, [
//             'json' => $params,
            'headers' => $headers,
            'verify' => false,
        ]);
        return $response;
    }

    public function getYearEndId()
    {
        $year_id=YearEndModel::orderBy('ye_id','DESC')->pluck('ye_id')->first();
        return $year_id;
    }
}
