<?php

namespace App\Http\Controllers\Wizard;

use App\Models\AccountGroupModel;
use App\Models\AccountHeadsModel;
use App\Models\AccountRegisterationModel;
use App\Models\AreaModel;
use App\Models\BrandModel;
use App\Models\CapitalRegistrationModel;
use App\Models\CategoryInfoModel;
use App\Models\CompanyInfoModel;
use App\Models\CreditCardMachineModel;
use App\Models\Department;
use App\Models\FixedAssetModel;
use App\Models\GroupInfoModel;
use App\Models\MainUnitModel;
use App\Models\ModularGroupModel;
use App\Models\PackagesModel;
use App\Models\ProductGroupModel;
use App\Models\ProductModel;
use App\Models\ProductPackagesModel;
use App\Models\ProductRecipeModel;
use App\Models\RegionModel;
use App\Models\SectorModel;
use App\Models\ServicesModel;
use App\Models\SystemConfigModel;
use App\Models\TownModel;
use App\Models\UnitInfoModel;
use App\Models\WarehouseModel;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use function Aws\flatmap;

class WizardController extends Controller
{
    public static function updateWizardInfo(array $completedTags, array $activateTags)
    {
        $user = Auth::user();
        $systemConfig = SystemConfigModel::where('sc_clg_id', '=', $user->user_clg_id)->first();
        if ($systemConfig->sc_welcome_wizard !== null) {
            $sc_welcome_wizard = $systemConfig->sc_welcome_wizard;
            foreach ($completedTags as $completedTag) {
                $sc_welcome_wizard[$completedTag] = 1;
                if ($completedTag == 'opening_trail') { $sc_welcome_wizard['wizard_completed'] = 1; }
            }
            foreach ($activateTags as $activateTag) {
                if ($sc_welcome_wizard[$activateTag] == 1) continue;
                $sc_welcome_wizard[$activateTag] = 0;
            }
            $systemConfig->sc_welcome_wizard = SystemConfigModel::convertScWelcomeWizardToString($sc_welcome_wizard);
            $systemConfig->save();

            $sc_welcome_wizard = $systemConfig->sc_welcome_wizard;
            if ($sc_welcome_wizard['required_completed'] == $sc_welcome_wizard['total_required'] && $sc_welcome_wizard['system_date'] == -1)
            {
                self::updateWizardInfo([], ['system_date']);
            }
        }

    }

    public function index()
    {
        $user = Auth::user();
        $software_pack=PackagesModel::where('pak_clg_id',$user->user_clg_id)->pluck('pak_name')->first();
        $systemConfig = $this->getSystemConfig();

        return view('_ab.wizard.index', compact('systemConfig','software_pack'));
    }

    public function index2()
    {
        $user = Auth::user();
        $systemConfig = SystemConfigModel::where('sc_clg_id', '=', $user->user_clg_id)->first();
        return view('_ab.wizard.index2', compact('systemConfig'));
    }


    /* Ajax get System Config */
    public function ajaxGetWizardInfo()
    {
        $user = Auth::user();
        $software_pack=PackagesModel::where('pak_clg_id', '=', $user->user_clg_id)->pluck('pak_name')->first();
        $systemConfig = $this->getSystemConfig();
        return response()->json(['result' => true, 'data' => $systemConfig, 'software_pack' => $software_pack]);
    }

    private function getSystemConfig()
    {

        $user = Auth::user();
        $systemConfig = SystemConfigModel::where('sc_clg_id', '=', $user->user_clg_id)->first();
        $sc_welcome_wizard = $systemConfig->sc_welcome_wizard;

        $company_info = false;
        if (CompanyInfoModel::where('ci_clg_id', '=', $user->user_clg_id)->where('ci_name', '!=', '')->where('ci_email', '!=', '')->exists()) { $sc_welcome_wizard['company_info'] = 1;$company_info =
            true; }
        if (AccountGroupModel::where('ag_clg_id', '=', $user->user_clg_id)->count()) { $sc_welcome_wizard['reporting_group'] = 1; }
        if (ProductGroupModel::where('pg_clg_id', '=', $user->user_clg_id)->count()) { $sc_welcome_wizard['product_reporting_group'] = 1; }
        if (Permission::count()) { $sc_welcome_wizard['add_role_permission'] = 1; }
//        if (ModularGroupModel::count()) { $sc_welcome_wizard['add_modular_group'] = 1; }
        if (WarehouseModel::where('wh_clg_id', '=', $user->user_clg_id)->count()) { $sc_welcome_wizard['warehouse'] = 1; }
        if (Department::where('dep_clg_id', '=', $user->user_clg_id)->count()) { $sc_welcome_wizard['department'] = 1; }

        $admin_profile = false;
        if (User::where('user_clg_id', '=', $user->user_clg_id)->where('user_id', '=', 1)->where('user_email', '!=', 'support@jadeedmunshi.com')->exists()) { $sc_welcome_wizard['admin_profile'] = 1;
        $admin_profile = true; }
        if (AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_parent', '=', config('global_variables.salary_expense_second_head'))->count()) { $sc_welcome_wizard['parent_account_1'] = 1;$sc_welcome_wizard['employee'] = 0; }
        if (User::where('user_clg_id', '=', $user->user_clg_id)->count() > 1) { $sc_welcome_wizard['employee'] = 1; }

        if (GroupInfoModel::where('grp_clg_id', '=', $user->user_clg_id)->count()) { $sc_welcome_wizard['group'] = 1;$sc_welcome_wizard['category'] = 0; }
        if (CategoryInfoModel::where('cat_clg_id', '=', $user->user_clg_id)->count()) { $sc_welcome_wizard['category'] = 1;$sc_welcome_wizard['product'] = 0; }
        if (MainUnitModel::where('mu_clg_id', '=', $user->user_clg_id)->count()) { $sc_welcome_wizard['main_unit'] = 1;$sc_welcome_wizard['unit'] = 0; }
        if (UnitInfoModel::where('unit_clg_id', '=', $user->user_clg_id)->count()) { $sc_welcome_wizard['unit'] = 1; }
        if (BrandModel::where('br_clg_id', '=', $user->user_clg_id)->count()) { $sc_welcome_wizard['brand'] = 1; }
        if (ProductModel::where('pro_clg_id', '=', $user->user_clg_id)->where('pro_type', '=', config('global_variables.parent_product_type'))->count()) { $sc_welcome_wizard['product'] = 1;
        $sc_welcome_wizard['product_clubbing'] = 0; $sc_welcome_wizard['product_packages'] = 0; $sc_welcome_wizard['product_recipe'] = 0;}
        if (ProductModel::where('pro_clg_id', '=', $user->user_clg_id)->where('pro_type', '=', config('global_variables.child_product_type'))->count()) { $sc_welcome_wizard['product_clubbing'] = 1; }
        if (ProductPackagesModel::where('pp_clg_id', '=', $user->user_clg_id)->count()) { $sc_welcome_wizard['product_packages'] = 1; }
        if (ProductRecipeModel::where('pr_clg_id', '=', $user->user_clg_id)->count()) { $sc_welcome_wizard['product_recipe'] = 1; }

        if (ServicesModel::where('ser_clg_id', '=', $user->user_clg_id)->count()) { $sc_welcome_wizard['service'] = 1; }

        if (AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_parent_code', '=', config('global_variables.bank_head'))->count()) { $sc_welcome_wizard['bank_account'] = 1;$sc_welcome_wizard['credit_card_machine'] = 0; }
        if (CreditCardMachineModel::where('ccm_clg_id', '=', $user->user_clg_id)->count()) { $sc_welcome_wizard['credit_card_machine'] = 1; }

        if (RegionModel::where('reg_clg_id', '=', $user->user_clg_id)->count()) { $sc_welcome_wizard['region'] = 1;$sc_welcome_wizard['area'] = 0; }
        if (AreaModel::where('area_clg_id', '=', $user->user_clg_id)->count()) { $sc_welcome_wizard['area'] = 1;$sc_welcome_wizard['sector'] = 0; }
        if (SectorModel::where('sec_clg_id', '=', $user->user_clg_id)->count()) { $sc_welcome_wizard['sector'] = 1;$sc_welcome_wizard['town'] = 0; }
        if (TownModel::where('town_clg_id', '=', $user->user_clg_id)->count()) { $sc_welcome_wizard['town'] = 1;$sc_welcome_wizard['client_registration'] = 0;
        $sc_welcome_wizard['supplier_registration'] = 0; }
        if (AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_parent_code', '=', config('global_variables.receivable'))->count()) { $sc_welcome_wizard['client_registration'] = 1; }
        if (AccountRegisterationModel::where('account_clg_id', '=', $user->user_clg_id)->where('account_parent_code', '=', config('global_variables.payable'))->count()) { $sc_welcome_wizard['supplier_registration'] = 1; }

        $asset_parent_account = false;
        $expense_group_account = false;
        if (AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_parent', '=', config('global_variables.fixed_asset_second_head'))->count()) { $sc_welcome_wizard['asset_parent_account'] = 1;$asset_parent_account = true; }
        if (AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_parent', '=', config('global_variables.expense'))->count()) { $sc_welcome_wizard['expense_group_account'] = 1;
        $expense_group_account = true; }
        if ($asset_parent_account && $expense_group_account) { $sc_welcome_wizard['asset_registration'] = 0; }
        if (FixedAssetModel::where('fa_clg_id', '=', $user->user_clg_id)->count()) { $sc_welcome_wizard['asset_registration'] = 1; }

        $capital_registration = false;
        if (AccountHeadsModel::where('coa_clg_id', '=', $user->user_clg_id)->where('coa_parent', '=', config('global_variables.equity'))->count()) { $sc_welcome_wizard['second_head'] = 1; }
        if (CapitalRegistrationModel::where('cr_clg_id', '=', $user->user_clg_id)->count()) { $sc_welcome_wizard['capital_registration'] = 1;$capital_registration = true; }

        if ($company_info && $admin_profile && $capital_registration) {
            if ($sc_welcome_wizard['system_date'] != 1 && $sc_welcome_wizard['day_end_config'] == 1) { $sc_welcome_wizard['system_date'] = 0; }
        }

        $systemConfig->sc_welcome_wizard = SystemConfigModel::convertScWelcomeWizardToString($sc_welcome_wizard);
        $systemConfig->save();

        return $systemConfig;
    }
}
