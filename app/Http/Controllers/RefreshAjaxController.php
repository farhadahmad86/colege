<?php

namespace App\Http\Controllers;


use App\Models\AccountHeadsModel;

use App\Models\AccountGroupModel;

use App\Models\AccountRegisterationModel;
use App\Models\AreaModel;
use App\Models\AuthorModel;
use App\Models\BrandModel;
use App\Models\CategoryInfoModel;
use App\Models\ClassModel;
use App\Models\CourierModel;
use App\Models\CreditCardMachineModel;
use App\Models\CurrencyModel;
use App\Models\Department;
use App\Models\DesignationModel;
use App\Models\GenreModel;
use App\Models\GroupInfoModel;
use App\Models\IllustratedModel;
use App\Models\ImPrintModel;
use App\Models\LanguageModel;
use App\Models\MainUnitModel;
use App\Models\ModularGroupModel;
use App\Models\PostingReferenceModel;
use App\Models\ProductGroupModel;
use App\Models\ProductModel;
use App\Models\ProductPackagesModel;
use App\Models\ProductRecipeModel;
use App\Models\PublisherModel;
use App\Models\RegionModel;
use App\Models\SalarySlipVoucherModel;
use App\Models\SectorModel;
use App\Models\ServicesModel;
use App\Models\TopicModel;
use App\Models\TownModel;
use App\Models\UnitInfoModel;
use App\Models\WarehouseModel;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefreshAjaxController extends Controller
{
    public function refresh_region()
    {
        $regions = RegionModel::where('reg_delete_status', '!=', 1)->where('reg_disabled', '!=', 1)->orderBy('reg_title', config('global_variables.drop_sorting'))->get();

        $get_region = "<option value=''>Select Region</option>";
        foreach ($regions as $region) {

            $get_region .= "<option value='$region->reg_id'>$region->reg_title</option>";
        }

        return response()->json($get_region);
    }

    public function refresh_area(Request $request)
    {
        $reg_id = $request->region_id;

        $areas = AreaModel::where('area_reg_id', $reg_id)->where('area_delete_status', '!=', 1)->where('area_disabled', '!=', 1)->orderBy('area_title', 'ASC')->get();

        $get_area = "<option value=''>Select Area</option>";
        foreach ($areas as $area) {

            $get_area .= "<option value='$area->area_id'>$area->area_title</option>";
        }

        return response()->json($get_area);
    }

    public function refresh_head()
    {
        $salary_expense_second_head = config('global_variables.salary_expense_second_head');

        $salary_accounts = AccountHeadsModel::where('coa_parent', $salary_expense_second_head)->where('coa_delete_status', '!=', 1)->where('coa_disabled', '!=', 1)->orderBy('coa_id', 'ASC')->get();
//        $heads = AccountHeadsModel::orderBy('coa_head_name', 'ASC')->get();

        $get_head = "<option value=''>Select Child Account</option>";
        foreach ($salary_accounts as $head) {

            $get_head .= "<option value='$head->coa_code'>$head->coa_head_name</option>";
        }

        return response()->json($get_head);
    }

    public function refresh_sector(Request $request)
    {
        $area_id = $request->area_id;
        $sectors = SectorModel::where('sec_area_id', $area_id)->where('sec_delete_status', '!=', 1)->where('sec_disabled', '!=', 1)->orderBy('sec_title', 'ASC')->get();

        $get_sector = "<option value=''>Select Sector</option>";
        foreach ($sectors as $sector) {

            $get_sector .= "<option value='$sector->sec_id'>$sector->sec_title</option>";
        }

        return response()->json($get_sector);
    }

    public function refresh_town(Request $request)
    {
        $sector_id = $request->sector_id;

        $towns = TownModel::where('town_sector_id', $sector_id)->where('town_disabled', '!=', 1)->orderBy('town_title', 'ASC')->get();

        $get_town = "<option value=''>Select Town</option>";
        foreach ($towns as $town) {

            $get_town .= "<option value='$town->town_id'>$town->town_title</option>";
        }


//        $area_id = $request->area_id;
//        $sectors = TownModel::where('sec_area_id', $area_id)->where('sec_delete_status', '!=', 1)->orderBy('sec_title', 'ASC')->get();
//
//        $get_sector = "<option value=''>Select Town</option>";
//        foreach ($sectors as $sector) {
//
//            $get_sector .= "<option value='$sector->sec_id'>$sector->sec_title</option>";
//        }

        return response()->json($get_town);
    }

    public function refresh_reporting_group()
    {
        $groups = AccountGroupModel::where('ag_delete_status', '!=', 1)->where('ag_disabled', '!=', 1)->orderBy('ag_title', 'ASC')->get();

        $get_group = "<option value=''>Select Account Ledger Access Group</option>";
        foreach ($groups as $group) {
            $get_group .= "<option value='$group->ag_id'>$group->ag_title</option>";
        }

        return response()->json($get_group);
    }

    public function refresh_sale_person()
    {
        $sale_persons = User::where('user_id', '!=', 1)->where('user_delete_status', '!=', 1)
            ->where('user_disabled', '!=', 1)
            ->orderBy('user_role_id', 'DESC')->orderBy('user_name', 'ASC')->get();
//        $sale_persons = User::where('user_id', '!=', 1)->where('user_delete_status', '!=', 1)->where('user_login_status', '=' ,'ENABLE')->orderBy('user_role_id', 'DESC')->orderBy('user_name', 'ASC')->get();
//        $sale_persons = User::orderBy('user_name', 'ASC')->get();


        $get_person = "<option value=''>Select Person</option>";
        foreach ($sale_persons as $sale_person) {
            $get_person .= "<option value='$sale_person->user_id'>$sale_person->user_name</option>";
        }

        return response()->json($get_person);
    }

    public function refresh_third_head(Request $request)
    {
        $second_head_id = $request->second_head_id;
        $third_heads = AccountHeadsModel::where('coa_parent', $second_head_id)->where('coa_delete_status', '!=', 1)->where('coa_disabled', '!=', 1)->orderBy('coa_id', 'ASC')->get();

        $get_third_head = "<option value=''>Select Child Account</option>";
        foreach ($third_heads as $third_head) {
            $get_third_head .= "<option value='$third_head->coa_code'>$third_head->coa_head_name</option>";
        }
        return response()->json($get_third_head);
    }

    public function refresh_second_head(Request $request)
    {

        $first_head_code = $request->first_head_code;
        $second_head_code = $request->second_head_code;

        if (isset($first_head_code)) {

//            $heads = AccountHeadsModel::where('coa_parent', $first_head_code)->where('coa_delete_status', '!=', 1)->where('coa_disabled', '!=', 1)->where('coa_code', '!=', config('global_variables.salary_expense_second_head'))->where('coa_code', '!=', config('global_variables.fixed_asset_second_head'))->orderBy('coa_id', 'ASC')->get();
            $heads = AccountHeadsModel::where('coa_parent', $first_head_code)->where('coa_delete_status', '!=', 1)->where('coa_disabled', '!=', 1)->where('coa_code', '!=', config('global_variables.fixed_asset_second_head'))->orderBy('coa_id', 'ASC')->get();

            $get_head = "<option value=''>Select Group Account</option>";
            foreach ($heads as $head) {

                $selected = $head->coa_code == $request->second_parent ? 'selected' : '';

                $get_head .= "<option value='$head->coa_code' $selected>$head->coa_head_name</option>";
            }

        } elseif (isset($second_head_code)) {

            $heads = AccountHeadsModel::where('coa_parent', $second_head_code)->where('coa_delete_status', '!=', 1)->where('coa_disabled', '!=', 1)->orderBy('coa_id', 'ASC')->get();

            $get_head = "<option value=''>Select Parent Account</option>";
            foreach ($heads as $head) {
                $get_head .= "<option value='$head->coa_code' >$head->coa_head_name</option>";
            }

        } else {
            $get_head = "<option value=''>Select Head</option>";
        }

        return response()->json($get_head);
    }

    public function refresh_product_group()
    {
        $product_groups = ProductGroupModel::where('pg_delete_status', '!=', 1)->where('pg_disabled', '!=', 1)->orderBy('pg_title', 'ASC')->get();

        $get_product_group = "<option value=''>Select Product Handling Group</option>";
        foreach ($product_groups as $product_group) {
            $get_product_group .= "<option value='$product_group->pg_id'>$product_group->pg_title</option>";
        }

        return response()->json($get_product_group);
    }

    public function refresh_modular_group()
    {
        $modular_groups = ModularGroupModel::where('mg_delete_status', '!=', 1)->where('mg_disabled', '!=', 1)->orderby('mg_title', 'ASC')->get();
        $get_modular_group = "<option value=''>Select Modular Group</option>";
        foreach ($modular_groups as $modular_group) {
            $get_modular_group .= "<option value='$modular_group->mg_id'>$modular_group->mg_title</option>";
        }

        return response()->json($get_modular_group);
    }

    public function refresh_mainUnit()
    {
        $main_units = MainUnitModel::where('mu_delete_status', '!=', 1)->where('mu_disabled', '!=', 1)->orderBy('mu_title', 'ASC')->get();
        $get_main_unit = "<option value=''>Select Main Unit</option>";
        foreach ($main_units as $main_unit) {
            $get_main_unit .= "<option value='$main_unit->mu_id'>$main_unit->mu_title</option>";
        }

        return response()->json($get_main_unit);
    }

    public function refresh_GroupInfo_group()
    {
        $groups = GroupInfoModel::where('grp_delete_status', '!=', 1)->where('grp_disabled', '!=', 1)->orderBy('grp_title', 'ASC')->get();
        $get_group = "<option value=''>Select Product Group Title</option>";
        foreach ($groups as $group) {
            $get_group .= "<option value='$group->grp_id'>$group->grp_title</option>";
        }

        return response()->json($get_group);
    }

    public function refresh_Group_cat_group()
    {
        $groups = GroupInfoModel::where('grp_delete_status', '!=', 1)->where('grp_disabled', '!=', 1)->orderBy('grp_title', 'ASC')->get();

        $get_group = "<option value=''>Select Group</option>";
        foreach ($groups as $group) {
            $get_group .= "<option value='$group->grp_id' data-tax='$group->grp_tax' data-retailer='$group->grp_retailer_discount' data-wholesaler='$group->grp_whole_seller_discount'
                                                                    data-loyalty_card='$group->grp_loyalty_card_discount'>$group->grp_title</option>";
        }

        return response()->json($get_group);
    }

    public function refresh_category_group(Request $request)
    {
        $group_id = $request->group_id;
        $categories = CategoryInfoModel::where('cat_group_id', $group_id)->where('cat_disabled', '!=', 1)->where('cat_delete_status', '!=', 1)->orderBy('cat_title', 'ASC')->get();

        $get_category = "<option value=''>Select Product Category Title</option>";
        foreach ($categories as $category) {
            $get_category .= "<option value='$category->cat_id'>$category->cat_title</option>";

        }

        return response()->json($get_category);
    }

    public function refresh_categorys_group(Request $request)
    {
        $group_id = $request->group_id;
        $categories = CategoryInfoModel::where('cat_group_id', $group_id)->where('cat_delete_status', '!=', 1)->where('cat_disabled', '!=', 1)->orderBy('cat_title', 'ASC')->get();

        $get_cat = "<option value=''>Select Product Category Title</option>";
        foreach ($categories as $cat) {

            $get_cat .= "<option value='$cat->cat_id'  data-tax='$cat->cat_tax' data-retailer='$cat->cat_retailer_discount' data-wholesaler='$cat->cat_whole_seller_discount' data-loyalty_card='$cat->cat_loyalty_card_discount' >$cat->cat_title</option>";

        }

        return response()->json($get_cat);
    }

    public function refresh_unit(Request $request)
    {
        $main_unit_id = $request->main_unit_id;
        $units = UnitInfoModel::where('unit_main_unit_id', $main_unit_id)->where('unit_delete_status', '!=', 1)->where('unit_disabled', '!=', 1)->orderBy('unit_title', 'ASC')->get();

        $get_unit = "<option value=''>Select Unit</option>";
        foreach ($units as $unit) {
            $get_unit .= "<option value='$unit->unit_id'>$unit->unit_scale_size  $unit->unit_title</option>";
        }

        return response()->json($get_unit);
    }

    public function refresh_warehouse()
    {
        $warehouses = WarehouseModel::where('wh_delete_status', '!=', 1)->where('wh_disabled', '!=', 1)->orderBy('wh_title', 'ASC')->get();

        $get_warehouse = "<option value='0'>Select Warehouse</option>";
        foreach ($warehouses as $warehouse) {
            $get_warehouse .= "<option value='$warehouse->wh_id'>$warehouse->wh_title</option>";
        }

        return response()->json($get_warehouse);
    }

    public function refresh_posting_reference()
    {
        $posting_references = PostingReferenceModel::where('pr_disabled', '=', 0)->get();

        $get_posting_reference = "<option value='0'>Select Posting Reference</option>";
        foreach ($posting_references as $posting_reference) {
            $get_posting_reference .= "<option value='$posting_reference->pr_id'>$posting_reference->pr_name</option>";
        }

        return response()->json($get_posting_reference);
    }

    public function refresh_store_warehouse()
    {
        $warehouses = WarehouseModel::where('wh_delete_status', '!=', 1)->where('wh_disabled', '!=', 1)->orderBy('wh_title', 'ASC')->get();

        $get_warehouse = "<option value=''>Main Store</option>";
        foreach ($warehouses as $warehouse) {
            $get_warehouse .= "<option value='$warehouse->wh_id'>$warehouse->wh_title</option>";
        }

        return response()->json($get_warehouse);
    }

    public function refresh_cash_transfer_to()
    {
        $tellers = User::where('user_role_id', config('global_variables.teller_account_id'))->where('user_login_status', '=', 'ENABLE')->where('user_disabled', '!=', 1)->where('user_delete_status', '!=', 1)->get();

        $get_teller = "<option value=''>Cash Transfer To</option>";
        foreach ($tellers as $teller) {
            $get_teller .= "<option value='$teller->user_id'>$teller->user_name</option>";
        }

        return response()->json($get_teller);
    }

    public function refresh_bank()
    {
        $banks = $this->get_fourth_level_account(config('global_variables.bank_head'), 0, 0);

        $get_bank = "<option value=''>Select Bank</option>";
        foreach ($banks as $bank) {
            $get_bank .= "<option value='$bank->account_uid'>$bank->account_name</option>";
        }

        return response()->json($get_bank);
    }

    public function refresh_purchase_account_code(Request $request)
    {
//        $user = Auth::user();
//
//        $heads = explode(',', config('global_variables.payable_receivable_purchaser'));
//
//        $query = AccountRegisterationModel::whereIn('account_parent_code', $heads)
//            ->whereNotIn(
//                'account_uid', AccountRegisterationModel::where('account_parent_code', config('global_variables.purchaser_account_head'))
//                ->where('account_uid', '!=', config('global_variables.purchaser_account'))
//                ->pluck('account_uid')->all()
//            );
//
//        $accounts = $query->where('account_delete_status', '!=', 1)->where('account_disabled', '!=', 1)
//            ->orderBy('account_uid', 'ASC')
//            ->get();
        $accounts = $this->get_account_query($request->type)[0];
        $get_account = "<option value=''>Party Name</option>";
        foreach ($accounts as $account) {
            $get_account .= "<option value='$account->account_uid'>$account->account_uid</option>";
        }
        return response()->json($get_account);
    }

    public function refresh_purchase_account_name(Request $request)
    {
//        $user = Auth::user();
//
//        $heads = explode(',', config('global_variables.payable_receivable_purchaser'));
//
//        $query = AccountRegisterationModel::whereIn('account_parent_code', $heads)
//            ->whereNotIn(
//                'account_uid', AccountRegisterationModel::where('account_parent_code', config('global_variables.purchaser_account_head'))
//                ->where('account_uid', '!=', config('global_variables.purchaser_account'))
//                ->pluck('account_uid')->all()
//            );
//
//
//        $accounts = $query->where('account_delete_status', '!=', 1)->where('account_disabled', '!=', 1)->orderBy('account_uid', 'ASC')
//            ->get();
        $accounts = $this->get_account_query($request->type)[0];
        $get_account = "<option value=''>Party Name</option>";
        foreach ($accounts as $account) {
            $get_account .= "<option value='$account->account_uid'>$account->account_name</option>";
        }
        return response()->json($get_account);
    }

    public function refresh_cash_receipt()
    {
        $accounts = $this->get_fourth_level_account(config('global_variables.cash'), 0, 0);

        $get_account = "<option value=''>Select Cash Account</option>";
        foreach ($accounts as $account) {
            $get_account .= "<option value='$account->account_uid'>$account->account_name</option>";
        }
        return response()->json($get_account);
    }

    public function refresh_credit_card_machine()
    {
        $machines = CreditCardMachineModel::where('ccm_delete_status', '!=', 1)->where('ccm_disabled', '!=', 1)->orderBy('ccm_title', 'ASC')->get();

        $get_machine = "<option value=''>Select Machine</option>";
        foreach ($machines as $machine) {
            $get_machine .= "<option value='$machine->ccm_id'>$machine->ccm_title</option>";
        }
        return response()->json($get_machine);
    }

    public function refresh_to_bank()
    {
        $heads = config('global_variables.payable_receivable');
        $heads = explode(',', $heads);

        $to_accounts = $this->get_fourth_level_account($heads, 0, 1);

        $get_to_account = "<option value=''>Select Account</option>";
        foreach ($to_accounts as $to_account) {
            $get_to_account .= "<option value='$to_account->account_uid'>$to_account->account_name</option>";
        }
        return response()->json($get_to_account);
    }

    public function refresh_from_bank()
    {
        $banks = $this->get_fourth_level_account(config('global_variables.bank_head'), 0, 0);

        $get_bank = "<option value=''>Select Account</option>";
        foreach ($banks as $bank) {
            $get_bank .= "<option value='$bank->account_uid'>$bank->account_name</option>";
        }

        return response()->json($get_bank);
    }

    public function refresh_expense_payment()
    {
        $accounts = $this->get_fourth_level_account(config('global_variables.expense'), 3, 0);

        $get_account = "<option value=''>Select Account</option>";
        foreach ($accounts as $account) {
            $get_account .= "<option value='$account->account_uid'>$account->account_name</option>";
        }

        return response()->json($get_account);
    }

    public function refresh_advance_payment()
    {
        $heads = config('global_variables.payable_receivable_cash') . ',' . config('global_variables.bank_head');
        $heads = explode(',', $heads);
        $pay_accounts = $this->get_fourth_level_account($heads, 0, 1);

        $get_account = "<option value=''>Select Advance Payment Account</option>";
        foreach ($pay_accounts as $account) {
            $get_account .= "<option value='$account->account_uid'>$account->account_name</option>";
        }

        return response()->json($get_account);
    }

    public function refresh_advance_salary_issue_to()
    {
        $advance_salary_accounts = $this->get_fourth_level_account(config('global_variables.advance_salary_head'), 0, 0);

        $get_advance_salary_account = "<option value=''>Select Advance Employee Account</option>";
        foreach ($advance_salary_accounts as $advance_salary_account) {
            $get_advance_salary_account .= "<option value='$advance_salary_account->account_uid'>$advance_salary_account->account_name</option>";
        }

        return response()->json($get_advance_salary_account);
    }

    public function refresh_employee()
    {
        $employees = User::where('user_delete_status', '!=', 1)->where('user_disabled', '!=', 1)->orderby('user_name', 'ASC')->get();

        $get_employee = "<option value=''>Select Account</option>";
        foreach ($employees as $employee) {
            $get_employee .= "<option value='$employee->user_id'>$employee->user_name</option>";
        }

        return response()->json($get_employee);
    }

    public function refresh_product_code(Request $request)
    {
//        $pro_code = $request->product_code;
        $status = 0;

        $products = $this->get_products_by_type(config('global_variables.parent_product_type'));

        $product_code = '';
        $product_code = "<option value='0'>Select Code</option>";

        foreach ($products as $product) {
            $product_code .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' data-purchase_price='$product->pro_sale_price'>$product->pro_code</option>";
        }

//        foreach ($products as $product) {
//
//
//            $selected = $pro_code == $product->pro_code ? 'selected' : '';
//
//            $product_code .= "<option value='$product->pro_code' $selected>$product->pro_code</option>";
////         $product_name .= "<option value='$product->pro_code' $selected>$product->pro_title</option>";
//        }
        return response()->json($product_code);
    }

    public function refresh_products_code()
    {
        $products = $this->get_all_products();

        $pro_code = '';
        $pro_name = '';
        $pro_code = "<option value='0'>Code</option>";
        foreach ($products as $product) {
            $pro_code .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' data-purchase_price='$product->pro_purchase_price'> $product->pro_code</option>";
//            $pro_name .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' data-purchase_price='$product->pro_purchase_price'>$product->pro_title</option>";
        }

        return response()->json($pro_code);
    }

    public function refresh_product_name(Request $request)
    {
        $pro_code = $request->product_code;
        $status = 0;

        $products = $this->get_products_by_type(config('global_variables.parent_product_type'));

        $product_name = '';
        $product_name = "<option value='0' >Select Name</option>";
        foreach ($products as $product) {


            $selected = $pro_code == $product->pro_code ? 'selected' : '';

//         $product_code .= "<option value='$product->pro_code' $selected>$product->pro_code</option>";
            $product_name .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' data-purchase_price='$product->pro_sale_price'>$product->pro_title</option>";

//            $product_name .= "<option value='$product->pro_code' $selected>$product->pro_title</option>";
        }
        return response()->json($product_name);
    }

    public function refresh_products_name()
    {
        $products = $this->get_all_products();

        $pro_code = '';
        $pro_name = '';
        $pro_name = "<option value='0'>Product</option>";
        foreach ($products as $product) {
//            $pro_code .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' data-purchase_price='$product->pro_purchase_price'> $product->pro_code</option>";
            $pro_name .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' data-purchase_price='$product->pro_purchase_price'>$product->pro_title</option>";
        }

        return response()->json($pro_name);
    }

    public function refresh_recipe()
    {
        $recipe_lists = ProductRecipeModel::where('pr_delete_status', '!=', 1)->where('pr_disabled', '!=', 1)->orderBy('pr_name', 'ASC')->get();

        $get_recipe_list = "<option value=''>Select Recipe</option>";
        foreach ($recipe_lists as $recipe_list) {
            $get_recipe_list .= "<option value='$recipe_list->pr_id'>$recipe_list->pr_name</option>";
        }

        return response()->json($get_recipe_list);
    }

    public function refresh_manufacture_account_name()
    {
        $heads = explode(',', config('global_variables.payable_receivable'));
        $accounts = $this->get_fourth_level_account($heads, 0, 1);

        $get_account = "<option value=''>Account</option>";
        foreach ($accounts as $account) {
            $get_account .= "<option value='$account->account_uid'>$account->account_name</option>";
        }
        return response()->json($get_account);
    }

    public function refresh_manufacture_account_code()
    {
        $heads = explode(',', config('global_variables.payable_receivable'));
        $accounts = $this->get_fourth_level_account($heads, 0, 1);

        $get_account = "<option value='0'>Code</option>";
        foreach ($accounts as $account) {
            $get_account .= "<option value='$account->account_uid'>$account->account_uid</option>";
        }
        return response()->json($get_account);
    }

    public function refresh_packages()
    {
        $packages = ProductPackagesModel::where('pp_delete_status', '!=', 1)->where('pp_disabled', '!=', 1)->orderBy('pp_name', 'ASC')->get();

        $get_package = "<option value=''>Select Package</option>";
        foreach ($packages as $package) {
            $get_package .= "<option value='$package->pp_id'>$package->pp_name</option>";
        }

        return response()->json($get_package);
    }

    public function refresh_equity_second_account()
    {
        $equity_second_accounts = AccountHeadsModel::where('coa_parent', config('global_variables.equity'))->where('coa_delete_status', '!=', 1)->where('coa_disabled', '!=', 1)->where('coa_level', 2)->orderBy('coa_id', 'ASC')->get();

        $get_equity_second_account = "<option value=''>Select Second Head</option>";
        foreach ($equity_second_accounts as $equity_second_account) {
            $get_equity_second_account .= "<option value='$equity_second_account->coa_code'>$equity_second_account->coa_head_name</option>";
        }

        return response()->json($get_equity_second_account);
    }

    public function refresh_user_name()
    {
        $users = User::where('user_delete_status', '!=', 1)->where('user_disabled', '!=', 1)->select('user_id', 'user_name')->get();

        $get_user = "<option value=''>Select Name</option>";
        foreach ($users as $user) {
            $get_user .= "<option value='$user->user_id'>$user->user_username</option>";
        }

        return response()->json($get_user);
    }

    public function refresh_fixed_assets()
    {
        $fixed_assets = AccountHeadsModel::where('coa_parent', config('global_variables.fixed_asset_second_head'))->where('coa_delete_status', '!=', 1)->where('coa_disabled', '!=', 1)->orderBy('coa_id', 'ASC')->get();

        $get_fixed_asset = "<option value=''>Select Asset Parent Account</option>";
        foreach ($fixed_assets as $fixed_asset) {
            $get_fixed_asset .= "<option value='$fixed_asset->coa_code'>$fixed_asset->coa_head_name</option>";
        }

        return response()->json($get_fixed_asset);
    }

    public function refresh_expense_head()
    {
        $parent_expense_head = explode(',', config('global_variables.cgs_second_head') . ',' . config('global_variables.operating_expense_second_head'));
        $expense_heads = AccountHeadsModel::whereIn('coa_code', $parent_expense_head)->where('coa_delete_status', '!=', 1)->orderBy('coa_id', 'ASC')->get();

        $get_expense_head = "<option value=''>Select Expense Group Account</option>";
        foreach ($expense_heads as $expense_head) {
            $get_expense_head .= "<option value='$expense_head->coa_code'>$expense_head->coa_head_name</option>";
        }

        return response()->json($get_expense_head);
    }

    public function refresh_expense_parent_account(Request $request)
    {
        $second_head_code = $request->second_head_code;

        $expense_heads = AccountHeadsModel::whereIn('coa_code', $second_head_code)->where('coa_delete_status', '!=', 1)->where('coa_disabled', '!=', 1)->orderBy('coa_id', 'ASC')->get();

        $get_expense_head = "<option value=''>Select Parent Account</option>";
        foreach ($expense_heads as $expense_head) {
            $get_expense_head .= "<option value='$expense_head->coa_code'>$expense_head->coa_head_name</option>";
        }

        return response()->json($get_expense_head);
    }

    public function refresh_account_code(Request $request)
    {
        $heads = explode(',', config('global_variables.payable_receivable'));

        $to_accounts = $this->get_fourth_level_account($heads, 0, 1);

        $get_to_account = "<option value=''>Code</option>";
        foreach ($to_accounts as $to_account) {
            $get_to_account .= "<option value='$to_account->account_uid'>$to_account->account_uid</option>";
        }
        return response()->json($get_to_account);
    }

    public function refresh_accounts_name(Request $request)
    {

        $accounts_array = $this->get_account_query('cash_voucher');
        $to_accounts = $accounts_array[0];

        $get_to_account = "<option value='0'>Account Name</option>";
        foreach ($to_accounts as $to_account) {
            $get_to_account .= "<option value='$to_account->account_uid'>$to_account->account_name</option>";
        }
        return response()->json($get_to_account);
    }

    public function refresh_accounts(Request $request)
    {
        $type = $request->type;
        $array_index = $request->array_index;
        $accounts_array = $this->get_account_query($type);
        $to_accounts = $accounts_array[$array_index];
        return response()->json($to_accounts);
    }


    public function refresh_account_voucher_code()
    {
        $accounts = $this->get_fourth_level_account(config('global_variables.bank_head'), 1, 0);

        $get_account = "<option value=''>Code</option>";
        foreach ($accounts as $account) {
            $get_account .= "<option value='$account->account_uid'>$account->account_uid</option>";
        }
        return response()->json($get_account);
    }

    public function refresh_account_voucher_name()
    {
        $accounts = $this->get_fourth_level_account(config('global_variables.bank_head'), 1, 0);

        $get_account = "<option value=''>Account</option>";
        foreach ($accounts as $account) {
            $get_account .= "<option value='$account->account_uid'>$account->account_name</option>";
        }
        return response()->json($get_account);
    }

    public function refresh_bank_code()
    {
        $banks = $this->get_fourth_level_account(config('global_variables.bank_head'), 0, 0);

        $get_bank = "<option value=''>Code</option>";
        foreach ($banks as $bank) {
            $get_bank .= "<option value='$bank->account_uid'>$bank->account_uid</option>";
        }

        return response()->json($get_bank);
    }

    public function refresh_bank_name()
    {
        $banks = $this->get_fourth_level_account(config('global_variables.bank_head'), 0, 0);

        $get_bank = "<option value=''>Account</option>";
        foreach ($banks as $bank) {
            $get_bank .= "<option value='$bank->account_uid'>$bank->account_name</option>";
        }

        return response()->json($get_bank);
    }

    public function refresh_expense_account_code()
    {
        $expense_accounts = $this->get_fourth_level_account(config('global_variables.expense'), 2, 0);

        $get_expense_account = "<option value=''>Code</option>";
        foreach ($expense_accounts as $expense_account) {
            $get_expense_account .= "<option value='$expense_account->account_uid'>$expense_account->account_uid</option>";
        }

        return response()->json($get_expense_account);
    }

    public function refresh_expense_account_name()
    {
        $expense_accounts = $this->get_fourth_level_account(config('global_variables.expense'), 2, 0);

        $get_expense_account = "<option value=''>Account</option>";
        foreach ($expense_accounts as $expense_account) {
            $get_expense_account .= "<option value='$expense_account->account_uid'>$expense_account->account_name</option>";
        }

        return response()->json($get_expense_account);
    }

    public function refresh_new_employee_name()
    {
        $employees = User::where('user_delete_status', '!=', 1)->where('user_disabled', '!=', 1)->orderBy('user_name', 'ASC')->get();


        foreach ($employees as $employee) {

            $net_salary = SalarySlipVoucherModel::where('ss_user_id', $employee->user_id)->orderBy('ss_id', 'DESC')->pluck('ss_net_salary')->first();
            if (empty($net_salary)) {
                $net_salary = 0;
            }

            $employee['net_salary'] = $net_salary;
            $new_employees[] = $employee;
        }


        $get_new_employee = "<option value=''>Account</option>";
        foreach ($new_employees as $new_employee) {
            $get_new_employee .= "<option value='$new_employee->user_id'>$new_employee->user_name</option>";
        }

        return response()->json($get_new_employee);
    }

    public function refresh_expense_accounts_code()
    {
//        $expense_accounts = AccountRegisterationModel::where('account_parent_code', 'like', config('global_variables.expense') . '%')->orderBy('account_uid', 'ASC')->get();

        $expense_accounts = $this->get_fourth_level_account(config('global_variables.expense'), 2, 0);

        $get_expense_account = "<option value=''>Code</option>";
        foreach ($expense_accounts as $expense_account) {
            $get_expense_account .= "<option value='$expense_account->account_uid'>$expense_account->account_uid</option>";
        }

        return response()->json($get_expense_account);
    }

    public function refresh_expense_accounts_name()
    {
//        $expense_accounts = AccountRegisterationModel::where('account_parent_code', 'like', config('global_variables.expense') . '%')->orderBy('account_uid', 'ASC')->get();

        $expense_accounts = $this->get_fourth_level_account(config('global_variables.expense'), 2, 0);

        $get_expense_account = "<option value=''>Select Account</option>";
        foreach ($expense_accounts as $expense_account) {
            $get_expense_account .= "<option value='$expense_account->account_uid'>$expense_account->account_name</option>";
        }

        return response()->json($get_expense_account);
    }

    public function refresh_sale_product_code()
    {
        $products = $this->get_all_products();

        $pro_code = '';
        $pro_name = '';
        $pro_code = "<option value='0'>Code</option>";
        foreach ($products as $product) {

            $pro_code .= "<option value='$product->pro_p_code' data-parent='$product->pro_p_code' data-purchase_price='$product->pro_last_purchase_rate' data-sale_price='$product->pro_sale_price' data-unit='$product->unit_title' data-unit_scale_size='$product->unit_scale_size' data-main_unit='$product->mu_title'> $product->pro_p_code</option>";

//            $pro_name .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' data-sale_price='$product->pro_sale_price' data-tax='$product->pro_tax' data-retailer_dis='$product->pro_retailer_discount' data-whole_saler_dis='$product->pro_whole_seller_discount' data-loyalty_dis='$product->pro_loyalty_card_discount'>$product->pro_title</option>";

        }

        return response()->json($pro_code);
    }

    public function refresh_sale_product_name()
    {
        $products = $this->get_all_products();

        $pro_code = '';
        $pro_name = '';
        $pro_name = "<option value='0'>Product</option>";
        foreach ($products as $product) {

//            $pro_code .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' data-sale_price='$product->pro_sale_price' data-tax='$product->pro_tax' data-retailer_dis='$product->pro_retailer_discount' data-whole_saler_dis='$product->pro_whole_seller_discount' data-loyalty_dis='$product->pro_loyalty_card_discount'>$product->pro_code</option>";

            $pro_name .= "<option value='$product->pro_p_code' data-parent='$product->pro_p_code' data-purchase_price='$product->pro_last_purchase_rate' data-sale_price='$product->pro_sale_price' data-unit='$product->unit_title' data-unit_scale_size='$product->unit_scale_size' data-main_unit='$product->mu_title'> $product->pro_title</option>";


        }

        return response()->json($pro_name);
    }

    public function refresh_recipe_product_code()
    {
        $products = $this->get_all_products();

        $pro_code = '';
        $pro_code = "<option value='0'>Code</option>";
        foreach ($products as $product) {
            $pro_code .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' data-sale_price='$product->pro_average_rate'> $product->pro_code</option>";
        }

        return response()->json($pro_code);
    }

    public function refresh_recipe_product_name()
    {
        $products = $this->get_all_products();

        $pro_name = '';
        $pro_name = "<option value='0'>Product</option>";
        foreach ($products as $product) {
            $pro_name .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' data-sale_price='$product->pro_average_rate'>$product->pro_title</option>";
        }

        return response()->json($pro_name);
    }

    public function refresh_manufacture_product_code()
    {
        $products = $this->get_all_products();

        $pro_code = '';
        $pro_code = "<option value='0'>Code</option>";
        foreach ($products as $product) {
            $pro_code .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' data-sale_price='$product->pro_purchase_price'> $product->pro_code</option>";
        }

        return response()->json($pro_code);
    }

    public function refresh_manufacture_product_name()
    {
        $products = $this->get_all_products();

        $pro_name = '';
        $pro_name = "<option value='0'>Product</option>";
        foreach ($products as $product) {
            $pro_name .= "<option value='$product->pro_code' data-parent='$product->pro_p_code' data-sale_price='$product->pro_purchase_price'>$product->pro_title</option>";
        }

        return response()->json($pro_name);
    }

    public function refresh_parent_head()
    {
        $salary_expense_second_head = config('global_variables.salary_expense_second_head');

        $salary_heads = AccountHeadsModel::where('coa_parent', $salary_expense_second_head)->where('coa_delete_status', '!=', 1)->where('coa_disabled', '!=', 1)->orderBy('coa_id', 'ASC')->get();

        $get_salary_head = "<option value=''>Select Parent Head</option>";
        foreach ($salary_heads as $salary_head) {
            $get_salary_head .= "<option value='$salary_head->coa_code'>$salary_head->coa_head_name</option>";
        }

        return response()->json($get_salary_head);
    }

    public function refresh_accounting_group()
    {
        $groups = AccountGroupModel::where('ag_delete_status', '!=', 1)->where('ag_disabled', '!=', 1)->orderBy('ag_title', 'ASC')->get();

        $get_group = "";
        foreach ($groups as $group) {
            $get_group .= "<option value='$group->ag_id'>$group->ag_title</option>";
        }

        return response()->json($get_group);
    }

    public function refresh_product_club_code(Request $request)
    {
        $pro_code = $request->product_code;
        $status = 0;

        $products = $this->get_products_by_type(config('global_variables.parent_product_type'));

        $product_code = '';
        $product_code = "<option value='0'>Code</option>";


        foreach ($products as $product) {


            $selected = $pro_code == $product->pro_code ? 'selected' : '';

            $product_code .= "<option value='$product->pro_code' $selected>$product->pro_code</option>";
//         $product_name .= "<option value='$product->pro_code' $selected>$product->pro_title</option>";
        }
        return response()->json($product_code);
    }


    public function refresh_product_club_name(Request $request)
    {
        $pro_code = $request->product_code;
        $status = 0;

//        $products = ProductModel::where('pro_type', config('global_variables.parent_product_type'))->orderBy('pro_title', 'ASC')->get();
        $products = $this->get_products_by_type(config('global_variables.parent_product_type'));

        $product_name = '';
        $product_name = "<option value='0' >Product</option>";
        foreach ($products as $product) {


            $selected = $pro_code == $product->pro_code ? 'selected' : '';

            $product_name .= "<option value='$product->pro_code' $selected>$product->pro_title</option>";
        }
        return response()->json($product_name);
    }


    public function refresh_jv_account_code()
    {
//        $banks = $this->get_fourth_level_account(0, 0, 0);

        $user = Auth::user();

        $query = AccountRegisterationModel::query();

//        if ($user->user_level != 100) {
//            $query->whereIn('account_group_id', explode(',', $user->user_account_reporting_group_ids));
//        }

        $banks = $query
            ->where('account_uid', 'not like', config('global_variables.stock') . '%')
            ->where('account_uid', 'not like', config('global_variables.cash') . '%')
            ->where('account_uid', 'not like', config('global_variables.walk_in_customer_head') . '%')
            ->where('account_uid', 'not like', config('global_variables.purchaser_account_head') . '%')
            ->where('account_uid', '!=', config('global_variables.sale_account'))
            ->where('account_uid', '!=', config('global_variables.sales_returns_and_allowances'))
            ->where('account_uid', '!=', config('global_variables.purchase_account'))
            ->where('account_uid', '!=', config('global_variables.purchase_return_and_allowances'))
            ->where('account_delete_status', '!=', 1)
            ->where('account_disabled', '!=', 1)
            ->orderBy('account_parent_code', 'ASC')
            ->orderBy('account_uid', 'ASC')
            ->get();

        $get_bank = "<option value=''>Code</option>";
        foreach ($banks as $bank) {
            $get_bank .= "<option value='$bank->account_uid'>$bank->account_uid</option>";
        }

        return response()->json($get_bank);
    }

    public function refresh_jv_account_name()
    {
//        $banks = $this->get_fourth_level_account(0, 0, 0);
        $user = Auth::user();

        $query = AccountRegisterationModel::query();

//        if ($user->user_level != 100) {
//            $query->whereIn('account_group_id', explode(',', $user->user_account_reporting_group_ids));
//        }

        $banks = $query
            ->where('account_uid', 'not like', config('global_variables.stock') . '%')
            ->where('account_uid', 'not like', config('global_variables.cash') . '%')
            ->where('account_uid', 'not like', config('global_variables.walk_in_customer_head') . '%')
            ->where('account_uid', 'not like', config('global_variables.purchaser_account_head') . '%')
            ->where('account_uid', '!=', config('global_variables.sale_account'))
            ->where('account_uid', '!=', config('global_variables.sales_returns_and_allowances'))
            ->where('account_uid', '!=', config('global_variables.purchase_account'))
            ->where('account_uid', '!=', config('global_variables.purchase_return_and_allowances'))
            ->where('account_delete_status', '!=', 1)
            ->where('account_disabled', '!=', 1)
            ->orderBy('account_parent_code', 'ASC')
            ->orderBy('account_uid', 'ASC')
            ->get();


        $get_bank = "<option value=''>Account</option>";
        foreach ($banks as $bank) {
            $get_bank .= "<option value='$bank->account_uid'>$bank->account_name</option>";
        }

        return response()->json($get_bank);
    }

    public function refresh_salary_slip_account_code()
    {
        $accounts = $this->get_fourth_level_account(0, 0, 0);

        $get_account = "<option value=''>Account Code</option>";
        foreach ($accounts as $account) {
            $get_account .= "<option value='$account->account_uid'>$account->account_name</option>";
        }
        return response()->json($get_account);
    }

    public function refresh_salary_slip_account_name()
    {
        $accounts = $this->get_fourth_level_account(0, 0, 0);

        $get_account = "<option value=''>Account Title</option>";
        foreach ($accounts as $account) {
            $get_account .= "<option value='$account->account_uid'>$account->account_name</option>";
        }
        return response()->json($get_account);
    }

    public function refresh_salary_payment_account()
    {
        $heads = explode(',', config('global_variables.payable_receivable_cash_bank'));

        $accounts = $this->get_fourth_level_account($heads, 0, 1);

        $get_account = "<option value=''>Select Account</option>";
        foreach ($accounts as $account) {
            $get_account .= "<option value='$account->account_uid'>$account->account_name</option>";
        }
        return response()->json($get_account);
    }

    public function refresh_sale_account_code()
    {
        $user = Auth::user();

        $heads = explode(',', config('global_variables.payable_receivable_walk_in_customer'));

        $query = AccountRegisterationModel::whereIn('account_parent_code', $heads)
            ->whereNotIn(
                'account_uid', AccountRegisterationModel::where('account_parent_code', config('global_variables.walk_in_customer_head'))
                ->where('account_uid', '!=', config('global_variables.walk_in_customer'))
                ->pluck('account_uid')->all()
            );

//        if ($user->user_level != 100) {
//            $query->whereIn('account_group_id', explode(',', $user->user_account_reporting_group_ids));
//        }

        $accounts = $query->where('account_delete_status', '!=', 1)->where('account_disabled', '!=', 1)->orderBy('account_uid', 'ASC')
            ->get();

        $get_account = "<option value=''>Code</option>";
        foreach ($accounts as $account) {
            $get_account .= "<option value='$account->account_uid'>$account->account_uid</option>";
        }
        return response()->json($get_account);
    }

    public function refresh_sale_account_name()
    {
        $user = Auth::user();

        $heads = explode(',', config('global_variables.payable_receivable_walk_in_customer'));

        $query = AccountRegisterationModel::whereIn('account_parent_code', $heads)
            ->whereNotIn(
                'account_uid', AccountRegisterationModel::where('account_parent_code', config('global_variables.walk_in_customer_head'))
                ->where('account_uid', '!=', config('global_variables.walk_in_customer'))
                ->pluck('account_uid')->all()
            );

//        if ($user->user_level != 100) {
//            $query->whereIn('account_group_id', explode(',', $user->user_account_reporting_group_ids));
//        }

        $accounts = $query->where('account_delete_status', '!=', 1)->where('account_disabled', '!=', 1)->orderBy('account_uid', 'ASC')
            ->get();

        $get_account = "<option value=''>Party Name</option>";
        foreach ($accounts as $account) {
            $get_account .= "<option value='$account->account_uid'>$account->account_name</option>";
        }
        return response()->json($get_account);
    }

    public function refresh_service()
    {
        $services = ServicesModel::where('ser_delete_status', '!=', 1)->where('ser_disabled', '!=', 1)->orderBy('ser_id', 'ASC')->get();

        $service_code = '';
        $service_name = '';
        $get_service_name = "<option value=''>Select Service</option>";
        foreach ($services as $service) {
//            $service_code .= "<option value='$service->ser_id'>$service->ser_id</option>";
            $get_service_name .= "<option value='$service->ser_id'>$service->ser_title</option>";
        }

        return response()->json($get_service_name);
    }

    public function refresh_party_claim()
    {

        $heads = config('global_variables.party_claims_accounts_head');

        $accounts = AccountRegisterationModel::where('account_parent_code', $heads)->where('account_delete_status', '!=', 1)->where('account_disabled', '!=', 1)->orderBy('account_uid', 'ASC')->get();

        $get_account_name = "<option value=''>Select Account</option>";
        foreach ($accounts as $account) {

            $get_account_name .= "<option value='$account->account_uid'>$account->account_name</option>";
        }

        return response()->json($get_account_name);
    }

    public function refresh_brand()
    {
        $brands = BrandModel::where('br_delete_status', '!=', 1)->where('br_disabled', '!=', 1)->orderBy('br_title', 'ASC')->get();

        $get_brand_name = "<option value=''>Select Brand</option>";
        foreach ($brands as $brand) {

            $get_brand_name .= "<option value='$brand->br_id'>$brand->br_title</option>";
        }

        return response()->json($get_brand_name);
    }

    public function refresh_publisher()
    {
        $publishers = PublisherModel::where('pub_delete_status', '!=', 1)->where('pub_disabled', '!=', 1)->orderBy('pub_title', 'ASC')->get();

        $get_publisher = "<option value=''>Select Publisher</option>";
        foreach ($publishers as $publisher) {
            $get_publisher .= "<option value='$publisher->pub_id'>$publisher->pub_title</option>";
        }
        return response()->json($get_publisher);
    }

    public function refresh_topic()
    {
        $topics = TopicModel::where('top_delete_status', '!=', 1)->where('top_disabled', '!=', 1)->orderBy('top_title', 'ASC')->get();

        $get_topic = "<option value=''>Select Topic</option>";
        foreach ($topics as $topic) {
            $get_topic .= "<option value='$topic->top_id'>$topic->top_title</option>";
        }
        return response()->json($get_topic);
    }

    public function refresh_class()
    {
        $classes = ClassModel::where('cla_delete_status', '!=', 1)->where('cla_disabled', '!=', 1)->orderBy('cla_title', 'ASC')->get();

        $get_class = "<option value=''>Select Class</option>";
        foreach ($classes as $class) {
            $get_class .= "<option value='$class->cla_id'>$class->cla_title</option>";
        }
        return response()->json($get_class);
    }

    public function refresh_currency()
    {
        $currencies = CurrencyModel::where('cur_delete_status', '!=', 1)->where('cur_disabled', '!=', 1)->orderBy('cur_title', 'ASC')->get();

        $get_currency = "<option value=''>Select Currency</option>";
        foreach ($currencies as $currency) {
            $get_currency .= "<option value='$currency->cur_id'>$currency->cur_title</option>";
        }
        return response()->json($get_currency);
    }

    public function refresh_language()
    {
        $languages = LanguageModel::where('lan_delete_status', '!=', 1)->where('lan_disabled', '!=', 1)->orderBy('lan_title', 'ASC')->get();

        $get_language = "<option value=''>Select Language</option>";
        foreach ($languages as $language) {
            $get_language .= "<option value='$language->lan_id'>$language->lan_title</option>";
        }
        return response()->json($get_language);
    }

    public function refresh_imprint()
    {
        $imprints = ImPrintModel::where('imp_delete_status', '!=', 1)->where('imp_disabled', '!=', 1)->orderBy('imp_title', 'ASC')->get();

        $get_imprint = "<option value=''>Select ImPrint</option>";
        foreach ($imprints as $imprint) {
            $get_imprint .= "<option value='$imprint->imp_id'>$imprint->imp_title</option>";
        }
        return response()->json($get_imprint);
    }

    public function refresh_illustrated()
    {
        $illustrateds = IllustratedModel::where('ill_delete_status', '!=', 1)->where('ill_disabled', '!=', 1)->orderBy('ill_title', 'ASC')->get();

        $get_illustrated = "<option value=''>Select Illustrated</option>";
        foreach ($illustrateds as $illustrated) {
            $get_illustrated .= "<option value='$illustrated->ill_id'>$illustrated->ill_title</option>";
        }
        return response()->json($get_illustrated);
    }

    public function refresh_author()
    {
        $authors = AuthorModel::where('aut_delete_status', '!=', 1)->where('aut_disabled', '!=', 1)->orderBy('aut_title', 'ASC')->get();

        $get_author = "<option value=''>Select Author</option>";
        foreach ($authors as $author) {
            $get_author .= "<option value='$author->aut_id'>$author->aut_title</option>";
        }
        return response()->json($get_author);
    }

    public function refresh_genre()
    {
        $genres = GenreModel::where('gen_delete_status', '!=', 1)->where('gen_disabled', '!=', 1)->orderBy('gen_title', 'ASC')->get();

        $get_genre = "<option value=''>Select Genre</option>";
        foreach ($genres as $genre) {
            $get_genre .= "<option value='$genre->gen_id'>$genre->gen_title</option>";
        }
        return response()->json($get_genre);
    }

    public function refresh_courier()
    {
        $couriers = CourierModel::where('cc_delete_status', '!=', 1)->where('cc_disabled', '!=', 1)->orderBy('cc_name', 'ASC')->get();

        $get_courier = "<option value=''>Select Courier</option>";
        foreach ($couriers as $courier) {
            $get_courier .= "<option value='$courier->cc_id'>$courier->cc_name</option>";
        }
        return response()->json($get_courier);
    }

    public function refresh_department()
    {
        $departments = Department::where('dep_delete_status', '!=', 1)->where('dep_id', '!=', 1)->where('dep_disabled', '!=', 1)->orderBy('dep_title', 'ASC')->get();

        $get_department = "<option value=''>Select Department</option>";
        foreach ($departments as $department) {
            $get_department .= "<option value='$department->dep_id'>$department->dep_title</option>";
        }
        return response()->json($get_department);
    }
    public function refresh_designation()
    {
        $designations = DesignationModel::where('desig_delete_status', '!=', 1)->where('desig_id', '!=', 1)->where('desig_disabled', '!=', 1)->orderBy('desig_name', 'ASC')->get();

        $get_designation = "<option value=''>Select Designation</option>";
        foreach ($designations as $designation) {
            $get_designation .= "<option value='$designation->desig_id'>$designation->desig_name</option>";
        }
        return response()->json($get_designation);
    }


}
