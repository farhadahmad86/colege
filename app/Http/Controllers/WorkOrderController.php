<?php

namespace App\Http\Controllers;

use App\Models\AccountRegisterationModel;
use App\Models\Department;
use App\Models\ProductionOverHeadModel;
use App\Models\ProductRecipeModel;
use App\Models\ServicesModel;
use App\Models\UnitInfoModel;
use App\Models\WorkOrderModel;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Auth;

class WorkOrderController extends Controller
{

    public function index()
    {
//        $workOrder = WorkOrderModel::where('odr_delete_status', '!=', 1)->where('odr_disabled', '!=', 1)->get();
        $workOrder = DB::table("financials_work_order as work_order")
            ->leftJoin("financials_production_over_head as over_head", "over_head.poh_odr_id", "work_order.odr_id")
            ->leftJoin("financials_departments as department", "department.dep_id", "over_head.poh_department")
            ->leftJoin('financials_users as party_client', 'party_client.user_id', 'over_head.poh_parties_clients')
            ->leftJoin('financials_users as supervisor', 'supervisor.user_id', 'over_head.poh_supervisor')
            ->leftJoin("financials_product_recipe as recipe", "recipe.pr_id", "work_order.odr_recipe_id")
            ->leftJoin("financials_product_recipe_items as recipe_item", "recipe_item.pri_product_recipe_id", "recipe.pr_id")
            ->leftJoin('financials_users as users', 'users.user_id', 'work_order.odr_createdby')
            ->select("work_order.odr_id as work_odr_id","work_order.odr_ip_adrs","work_order.odr_brwsr_info", "work_order.odr_estimated_start_time as start_time", "work_order.odr_estimated_end_time as end_time", "recipe.pr_name as recipe_name", "recipe_item.pri_product_name as finished_good", "recipe_item.pri_qty as quantity", "recipe_item.pri_uom as uom", "department.dep_title as department", "party_client.user_name as client", "supervisor.user_name as supervisor", "users.user_name as created_by")
            ->where("recipe_item.pri_status","Primary-Finish-Goods")
            ->where('work_order.odr_delete_status', '!=', 1)
            ->where('work_order.odr_disabled', '!=', 1)
            ->get();

        return view('work_order_list', compact('workOrder'));

    }

    public function create()
    {

        $get_recipies = ProductRecipeModel::select('pr_id as recipe_id', 'pr_name as recipe_name')->get();
        $departments = Department::where('dep_disabled', '!=', '1')
            ->where('dep_delete_status', '!=', '1')
            ->select('dep_id as department_id', 'dep_title as department_name')
            ->get();
        $employees = User::where('user_delete_status', '!=', 1)->where('user_id', '!=', 1)
            ->where('user_login_status', '=', 'ENABLE')
//            ->whereIn('user_role_id', '2,3,4,5')
            ->select('user_id', 'user_name')
            ->get();
        $products = $this->get_all_products();
        $pro_code = '';
        $pro_name = '';

        foreach ($products as $key=>$product) {
            $pro_code .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' data-sale_price='$product->pro_average_rate'> $product->pro_code</option>";
            $pro_name .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' data-sale_price='$product->pro_average_rate'>$product->pro_title</option>";
        }


        $heads = explode(',', config('global_variables.payable_receivable'));
        $accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)->orderBy('account_uid', 'ASC')->get();

        $units = UnitInfoModel::where('unit_delete_status', '!=', 1)
            ->where('unit_disabled','!=', 1)
            ->orderBy('unit_title', 'ASC')
            ->get();

        $services = ServicesModel::where('ser_delete_status', '!=', 1)->where('ser_disabled', '!=', 1)->orderBy('ser_id', 'ASC')->get();

        $service_code = '';
        $service_name = '';

        foreach ($services as $service) {
            $service_code .= "<option value='$service->ser_id'>$service->ser_id</option>";
            $service_name .= "<option value='$service->ser_id'>$service->ser_title</option>";
        }

        $expense_accounts = $this->get_fourth_level_account(config('global_variables.expense'), 2, 0);


        return view('work_order', compact('get_recipies', 'departments', 'employees', 'pro_code', 'pro_name', 'accounts', 'units', 'expense_accounts', 'service_code', 'service_name'));
//        return view('work_order', compact('get_recipies', 'departments', 'employees', 'pro_code', 'pro_name', 'accounts', 'units', 'expense_accounts', 'service_code', 'service_name', 'check_jsn'));

    }


    public function store(Request $request)
    {

        $this->validation($request);

        $rollBack = false;
        DB::beginTransaction();

        $workOrder = new WorkOrderModel();

        $user_id = Auth::user()->user_id;
        $browser = $this->getBrwsrInfo();
        $ip = $this->getIp();
        $current_date_time = Carbon::now()->toDateTimeString();

        $workOrder = $this->AssignValues($request, $workOrder, $user_id, $ip, $browser, $current_date_time);

        if ($workOrder->save()) {
            $workOrderId = $workOrder->odr_id;

            $items = [];

            /*
             * This array add Budgeted Raw Stock Values In Budgeted Raw Stock Table
             */
            $cartDataForBudgetRawStock = json_decode($request->cartDataForBudgetRawStock, true);
            $item = $this->AssignItemsValuesForBudgetRawStock($cartDataForBudgetRawStock, $items, $workOrderId);
            if (!DB::table('financials_budgeted_raw_stock')->insert($item)) {
                $rollBack = true;
                DB::rollBack();
            }

            /*
             * This array add Raw Stock Costing Values In Raw Stock Costing Table
             */
            $cartDataForRawStockCosting = json_decode($request->cartDataForRawStockCosting, true);
            $item = $this->AssignItemsValuesForRawStockCosting($cartDataForRawStockCosting, $items, $workOrderId);
            if (!DB::table('financials_raw_stock_costing')->insert($item)) {
                $rollBack = true;
                DB::rollBack();
            }

            /*
             * This array add Primary Finished Goods Values In Primary Finished Goods Table
             */
            $cartDataForPrimaryGoods = json_decode($request->cartDataForPrimaryGoods, true);
            $item = $this->AssignItemsValuesForPrimaryGoods($cartDataForPrimaryGoods, $items, $workOrderId);
            if (!DB::table('financials_primary_finished_goods')->insert($item)) {
                $rollBack = true;
                DB::rollBack();
            }

            /*
             * This array add Secondary Finished Goods Values In Secondary Finished Goods Table
             */
            $cartDataForSecondaryGoods = json_decode($request->cartDataForSecondaryGoods, true);
            $item = $this->AssignItemsValuesForSecondaryGoods($cartDataForSecondaryGoods, $items, $workOrderId);
            if (!DB::table('financials_secondary_finished_good')->insert($item)) {
                $rollBack = true;
                DB::rollBack();
            }



            /*
             * This Function Add Values In Over Head Table
             */
            $overHead = new ProductionOverHeadModel();
            $overHead = $this->AssignValuesForServicesProductionOverHead($request, $overHead, $workOrderId);

            if ($overHead->save()) {
                $overHeadId = $overHead->poh_id;
                /*
                 * This array add Production Over Head Items Values in Production Over Head Items Table
                 */
                $cartDataForServicesProductionOverHead = json_decode($request->cartDataForServicesProductionOverHead, true);
                $item = $this->AssignItemsValuesForServicesProductionOverHead($cartDataForServicesProductionOverHead, $items, $overHeadId);
                if (!DB::table('financials_production_over_head_items')->insert($item)) {
                    $rollBack = true;
                    DB::rollBack();
                }
            }
        }
        else {
            $rollBack = true;
            DB::rollBack();
        }

        if ($rollBack) {
            DB::rollBack();
            return redirect()->back()->with('fail', 'Failed Try Again');
        }
        else {

            $user = Auth::User();

            $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Create Pack With Id: ' . $workOrder->pp_id . ' And Name: ' . $workOrder->pp_name);

            DB::commit();

            return redirect()->back()->with('success', 'Successfully Saved');
        }


    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {


        $workOrder = WorkOrderModel::where('odr_id','=',$id)->first();

        $get_recipies = ProductRecipeModel::select('pr_id as recipe_id', 'pr_name as recipe_name')->get();
        $departments = Department::where('dep_disabled', '!=', '1')
            ->where('dep_delete_status', '!=', '1')
            ->select('dep_id as department_id', 'dep_title as department_name')
            ->get();
        $employees = User::where('user_delete_status', '!=', 1)
            ->where('user_login_status', '=', 'ENABLE')
//            ->whereIn('user_role_id', '2,3,4,5')
            ->select('user_id', 'user_name')
            ->get();
        $products = $this->get_all_products();
        $pro_code = '';
        $pro_name = '';

        foreach ($products as $key=>$product) {
            $pro_code .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' data-sale_price='$product->pro_average_rate'> $product->pro_code</option>";
            $pro_name .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' data-sale_price='$product->pro_average_rate'>$product->pro_title</option>";
        }


        $heads = explode(',', config('global_variables.payable_receivable'));
        $accounts = AccountRegisterationModel::whereIn('account_parent_code', $heads)->orderBy('account_uid', 'ASC')->get();

        $units = UnitInfoModel::where('unit_delete_status', '!=', 1)
            ->where('unit_disabled','!=', 1)
            ->orderBy('unit_title', 'ASC')
            ->get();

        $services = ServicesModel::where('ser_delete_status', '!=', 1)->where('ser_disabled', '!=', 1)->orderBy('ser_id', 'ASC')->get();

        $service_code = '';
        $service_name = '';

        foreach ($services as $service) {
            $service_code .= "<option value='$service->ser_id'>$service->ser_id</option>";
            $service_name .= "<option value='$service->ser_id'>$service->ser_title</option>";
        }

        $expense_accounts = $this->get_fourth_level_account(config('global_variables.expense'), 2, 0);


        return view('work_order_edit', compact('workOrder','get_recipies', 'departments', 'employees', 'pro_code', 'pro_name', 'accounts', 'units', 'expense_accounts', 'service_code', 'service_name'));//,
        // 'check_jsn'

    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }


    public function validation($request)
    {
        return $this->validate($request, [
            'pro_recipe' => ['required', 'string'],
            'order_quantity' => ['nullable', 'string'],
            'show_uom_main' => ['required', 'string'],
            'estimated_start_time' => ['required', 'string'],
            'estimated_end_time' => ['required', 'string'],
            'warehouse_select' => ['nullable', 'string'],
            'department_list' => ['nullable', 'string'],
            'party_client_list' => ['nullable', 'string'],
            'employee_list' => ['nullable', 'string'],
            'ttlAmountForOverHead' => ['nullable', 'string'],
            'product_rate_type' => ['required', 'string'],
            'rate_type_grand_total' => ['required', 'string'],
            'overHeadPlusStockCostingTotal' => ['required', 'string'],
//            'manufacture_product_code' => ['required', 'string'],
//            'manufacture_product_name' => ['required', 'string'],
//            'manufacture_qty' => ['required', 'numeric', 'min:1'],
//            'total_items' => ['required', 'numeric', 'min:1'],
//            'total_price' => ['required', 'numeric'],
//            'salesval' => ['required', 'string'],
            'cartDataForServicesProductionOverHead' => ['nullable', 'string'],
            'cartDataForBudgetRawStock' => ['required', 'string'],
            'cartDataForRawStockCosting' => ['required', 'string'],
            'cartDataForPrimaryGoods' => ['required', 'string'],
            'cartDataForSecondaryGoods' => ['required', 'string'],
        ]);
    }


    public function AssignValues($request, $workOrder, $user_id, $ip, $browser, $current_date_time)
    {
        $get_day_end = new DayEndController();
        $day_end = $get_day_end->day_end();
//        $startTime = strtotime($request->staestimated_start_timertFro);
        $startTime = strtotime($request->estimated_start_time);
        $endTime = strtotime($request->estimated_end_time);

//        $workOrder->pr_name = ucwords($request->recipe_name);
        $workOrder->odr_recipe_id = $request->pro_recipe;
        $workOrder->odr_recipe_name = $request->pro_recipe;
        $workOrder->odr_qty = $request->order_quantity;
        $workOrder->odr_uom = $request->show_uom_main;
        $workOrder->odr_estimated_start_time = date('Y-m-d H:i:s', $startTime);
        $workOrder->odr_estimated_end_time = date('Y-m-d H:i:s', $endTime);
        $workOrder->odr_production_overhead_total = $request->ttlAmountForOverHead;
        $workOrder->odr_product_rate_type = $request->product_rate_type;
        $workOrder->odr_production_raw_stock_costing_total = $request->rate_type_grand_total;
        $workOrder->odr_total_amount = $request->overHeadPlusStockCostingTotal;


        $workOrder->odr_datetime = $current_date_time;
        $workOrder->odr_day_end_id = $day_end->de_id;
        $workOrder->odr_day_end_date = $day_end->de_datetime;
        $workOrder->odr_createdby = $user_id;
        $workOrder->odr_brwsr_info = $browser;
        $workOrder->odr_ip_adrs = $ip;
        $workOrder->odr_update_datetime = $current_date_time;

        return $workOrder;
    }

    public function AssignItemsValuesForBudgetRawStock($items, $data, $workOrderId)
    {
        foreach ($items as $key=>$item) {
            $data[] = ['brs_odr_id' => $workOrderId, 'brs_pro_code' => $item['code'], 'brs_pro_name' => ucwords($item['title']), 'brs_pro_remarks' => $item['remarks'], 'brs_uom' => $item['uom'], 'brs_recipe_consumption' => $item['quantity'], 'brs_required_production_qty' => $item['ttlQuantity'], 'brs_in_hand_stock' => $item['availableQuantity'] ];
        }
        return $data;
    }

    public function AssignItemsValuesForRawStockCosting($items, $data, $workOrderId)
    {
        foreach ($items as $key=>$item) {
            $data[] = ['rsc_odr_id' => $workOrderId, 'rsc_pro_code' => $item['code'], 'rsc_pro_name' => ucwords($item['title']), 'rsc_pro_remarks' => $item['remarks'], 'rsc_uom' => $item['uom'], 'rsc_qty' => $item['ttlQuantity'], 'rsc_rate' => $item['rate'], 'rsc_total' => $item['amount'] ];
        }
        return $data;
    }

    public function AssignItemsValuesForPrimaryGoods($items, $data, $workOrderId)
    {
        foreach ($items as $key=>$item) {
            $data[] = ['pfg_odr_id' => $workOrderId, 'pfg_pro_code' => $item['code'], 'pfg_pro_name' => ucwords($item['title']), 'pfg_pro_remarks' => $item['remarks'], 'pfg_uom' => $item['uom'], 'pfg_recipe_production_qty' => $item['quantity'], 'pfg_stock_before_production' => $item['stockBeforeProduction'], 'pfg_stock_after_production' => $item['stockAfterProduction'] ];
        }
        return $data;
    }

    public function AssignItemsValuesForSecondaryGoods($items, $data, $workOrderId)
    {
        foreach ($items as $key=>$item) {
            $data[] = ['sfg_odr_id' => $workOrderId, 'sfg_pro_code' => $item['code'], 'sfg_pro_name' => ucwords($item['title']), 'sfg_pro_remarks' => $item['remarks'], 'sfg_uom' => $item['uom'], 'sfg_recipe_production_qty' => $item['quantity'], 'sfg_reqd_production_qty' => $item['ttlQuantity'], 'sfg_stock_before_production' => $item['availableQuantity'], 'sfg_stock_after_production' => $item['stockAfterProduction'] ];
        }
        return $data;
    }

    public function AssignValuesForServicesProductionOverHead($request, $overHead, $workOrderId)
    {
        $overHead->poh_odr_id = $workOrderId;
        $overHead->poh_warehouse = $request->warehouse_select;
        $overHead->poh_department = $request->department_list;
        $overHead->poh_parties_clients = $request->party_client_list;
        $overHead->poh_supervisor = $request->employee_list;

        return $overHead;
    }

    public function AssignItemsValuesForServicesProductionOverHead($items, $data, $workOrderId)
    {
        foreach ($items as $key=>$item) {
            $data[] = ['pohi_poh_id' => $workOrderId, 'pohi_ser_code' => $item['code'], 'pohi_ser_name' => ucwords($item['title']), 'pohi_ser_remarks' => $item['remarks'], 'pohi_uom' => $item['uomText'], 'pohi_qty' => $item['quantity'], 'pohi_rate' => $item['rate'], 'pohi_amount' => $item['amount'], 'pohi_expense_account' => $item['expenseAccount'] ];
        }
        return $data;
    }




}
