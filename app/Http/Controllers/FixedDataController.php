<?php

namespace App\Http\Controllers;

use App\Models\AccountGroupModel;
use App\Models\AccountHeadsModel;
use App\Models\AccountRegisterationModel;
use App\Models\AreaModel;
use App\Models\CategoryInfoModel;
use App\Models\College\Semester;
use App\Models\CompanyInfoModel;
use App\Models\DayEndConfigModel;
use App\Models\Department;
use App\Models\DesignationModel;
use App\Models\GroupInfoModel;
use App\Models\MainUnitModel;
use App\Models\ModularGroupModel;
use App\Models\OpeningTrialBalanceModel;
use App\Models\PackagesModel;
use App\Models\Prerequisites\BoardTypeModel;
use App\Models\ProductGroupModel;
use App\Models\ProductTypeModel;
use App\Models\PostingReferenceModel;
use App\Models\RegionModel;
use App\Models\ReportConfigModel;
use App\Models\RolesModel;
use App\Models\SectorModel;
use App\Models\SystemConfigModel;
use App\Models\TownModel;
use App\Models\UnitInfoModel;
use App\Models\WarehouseModel;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use function GuzzleHttp\Promise\all;

class FixedDataController extends Controller
{
    public function create_fixed_data($college_id, $college_name, $logo, $branch_id, $branch_no)
    {

        DB::transaction(function () use ($college_id, $college_name, $logo, $branch_id, $branch_no) {
//        $admin_user =  User::firstOrNew(['user_id'=>'2']);
//        $admin_user->user_employee_code = 'AAAA-0002';
//        $admin_user->user_designation = 'Admin';
//        $admin_user->user_name = 'Admin';
//        $admin_user->user_father_name = 'Admin';
//        $admin_user->user_username = 'admin';
//        $admin_user->user_password = '$2y$10$Aol5etRmJWQtWFTF4WRMB.e4Uq0XFSTTvUexIlP0LH9mxYvwYcBLS';
//        $admin_user->user_email = 'admin@gmail.com';
//        $admin_user->user_mobile = '03001234567';
//        $admin_user->user_login_status = 'ENABLE';
//        $admin_user->user_religion = 1;
//        $admin_user->user_modular_group_id = 1;
//        $admin_user->user_role_id = 1;
//        $admin_user->user_level = 20;
//        $admin_user->user_marital_status = 1;
//        $admin_user->user_salary_person = 1;
//        $admin_user->user_loan_person = 0;
//        $admin_user->user_have_credentials = 1;
//        $admin_user->user_loan_person = 0;
//        $admin_user->user_delete_status = 0;
//        $admin_user->user_deleted_by = 0;
//        $admin_user->user_web_status = 'offline';
//        $admin_user->user_desktop_status = 'offline';
//        $admin_user->user_disabled = 0;
//        $admin_user->user_android_status = 'offline';
//        $admin_user->user_ios_status = 'offline';
//        $admin_user->user_send_day_end_report = 1;
//        $admin_user->user_send_month_end_report = 1;
//        $admin_user->user_send_sync_report = 1;
//        $admin_user->user_status = 'Employee';
//        $admin_user->save();

//        $sale_user =  User::firstOrNew(['user_id'=>'3']);
//        $sale_user->user_employee_code = 'AHHH-0003';
//        $sale_user->user_designation = 'Sale Man';
//        $sale_user->user_name = 'Independent';
//        $sale_user->user_father_name = 'Independent';
//        $sale_user->user_mobile = '03001234567';
//        $sale_user->user_login_status = 'DISABLE';
//        $sale_user->user_religion = 1;
//        $sale_user->user_role_id = 4;
//        $sale_user->user_level = 100;
//        $sale_user->user_marital_status = 1;
//        $sale_user->user_salary_person = 0;
//        $sale_user->user_loan_person = 0;
//        $sale_user->user_delete_status = 0;
//        $sale_user->user_deleted_by = 0;
//        $sale_user->user_web_status = 'offline';
//        $sale_user->user_desktop_status = 'offline';
//        $sale_user->user_disabled = 0;
//        $sale_user->user_android_status = 'offline';
//        $sale_user->user_ios_status = 'offline';
//        $sale_user->user_status = 'Employee';
//        $sale_user->user_clg_id = $college_id;
//        $sale_user->save();
//        $college_id=Auth::User()->user_clg_id;


            $permission = Permission::pluck('id');
            $modular_group = Role::create(['name' => 'Master ' . $college_name,
                'remarks' => '',
                'created_by' => 0,
                'clg_id' => $college_id,
                'type' => 1,
            ]);

            $modular_group->syncPermissions($permission);

            $user = Auth::User();

            /////////////////// modular group
            $modular_grop = ModularGroupModel::pluck('mg_title')->first();
            if (empty($modular_grop)) {

                $m_gruop = new ModularGroupModel();
                $m_gruop->mg_title = 'Initial Group Admin';
                $m_gruop->mg_remarks = 'System generated (Default/Required) accounts. By default all group fall this modular group.';
                $m_gruop->mg_first_level_config = '1,2,3,4,5,6,7,11,16,17';
                $m_gruop->mg_second_level_config = '110,111,112,113,210,212,213,215,216,217,218,219,311,312,313,314,315,316,317,318,410,510,511,512,513,514,515,516,1517,1518,1519,610,710,711,712,713,1110,1111,1112,1113,1610,1611,1612,1613,1614,1710';
                $m_gruop->mg_config = '11010,11011,11012,11013,11014,11015,11016,11017,11110,11111,11112,11113,11114,11115,11116,11117,11118,11119,11210,11211,11212,11213,11214,11215,11216,11217,11310,11311,11312,11313,11314,11315,11316,11317,21010,21011,21012,21013,21014,21015,21210,21211,21212,21213,21214,21215,21216,21217,21218,21219,21220,21221,21222,21223,21224,21225,21310,21311,21312,21313,21510,21511,21512,21610,21611,21612,21613,21614,21615,21616,21710,21711,21712,21713,21810,21811,21812,21910,21911,31110,31111,31210,31211,31212,31213,31310,31311,31412,31414,31511,31512,31611,31612,31613,31614,31711,31712,31810,31811,31812,31813,41010,41011,41012,41014,41017,51010,51011,51110,51111,51112,51210,51211,51310,51311,51312,51410,51411,51412,51413,51510,51511,51610,51611,51612,51613,151710,151711,151712,151713,151714,151810,151811,151910,151911,61010,61011,61012,61013,61014,61015,61016,61017,61018,71010,71011,71014,71110,71111,71211,71212,71310,111010,111011,111012,111013,111014,111015,111016,111017,111018,111019,111020,111021,111110,111111,111112,111113,111114,111115,111116,111117,111118,111119,111120,111121,111122,111123,111124,111125,111126,111127,111128,111210,111211,111212,111213,111214,111215,111216,111217,111218,111219,111220,111221,111222,111223,111224,111225,111226,111227,111310,111311,111312,111313,111314,111315,111316,111317,111318,111319,111320,111321,111322,111323,111324,111325,111326,111327,111328,111329,111330,111331,111332,111333,111334,111335,161010,161011,161012,161110,161111,161112,161113,161114,161115,161116,161117,161118,161210,161211,161212,161213,161214,161215,161310,161311,161312,161313,161314,161410,161411,171010,171011';
                $m_gruop->mg_created_by = '0';
                $m_gruop->mg_delete_status = '0';
                $m_gruop->mg_disabled = '0';
                $m_gruop->save();
            }

            /////////////////// account group
            $grop = AccountGroupModel::where('ag_clg_id', $college_id)->pluck('ag_title')->first();
            if (empty($grop)) {

                $account_gruop = new AccountGroupModel();
                $account_gruop->ag_title = 'Initial Accounts';
                $account_gruop->ag_remarks = 'System generated (Default/Required) accounts. By default all accounts fall in this group, you can change group of each account according to your need.';
                $account_gruop->ag_day_end_date = '0000-00-00';
                $account_gruop->ag_day_end_id = '0';
                $account_gruop->ag_created_by = '0';
                $account_gruop->ag_delete_status = '0';
                $account_gruop->ag_disabled = '0';
                $account_gruop->ag_clg_id = $college_id;
                $account_gruop->save();
            }

            /////////////////// Software package
            $soft_pack = PackagesModel::where('pak_clg_id', $college_id)->pluck('pak_id')->first();
            if (empty($soft_pack)) {

                $software_package = new PackagesModel();
                $software_package->pak_name = 'Advance';
                $software_package->pak_total_user = 1;
                $software_package->pak_user_id = $user->user_id;
                $software_package->pak_clg_id = $college_id;
                $software_package->save();
            }

            ////////////////// Semester
            $semester = Semester::where('semester_clg_id', $college_id)->pluck('semester_id')->first();
            if (empty($semester)) {
                $semesters = collect((object)array(
                    (object)['name' => 'Annual 1st Year'],
                    (object)['name' => 'Annual 2nd Year'])
                );

                foreach ($semesters as $item) {
                    $semester = new Semester();
                    $semester->semester_name = $item->name;
                    $semester->semester_created_by = 0;
                    $semester->semester_disable_enable = 0;
                    $semester->semester_delete_status = 0;
                    $semester->semester_clg_id = $college_id;
                    $semester->semester_branch_id = $branch_no;
                    $semester->save();
                }
            }

            //////// company info
            $company = CompanyInfoModel::where('ci_clg_id', $college_id)->pluck('ci_name')->first();
            if (empty($company)) {
                $company_info = new CompanyInfoModel();
                $company_info->ci_name = $college_name;
                $company_info->ci_address = 'Multan';
                $company_info->ci_email = 'support@digitalmunshi.com';
                $company_info->ci_logo = $logo;
                $company_info->info_bx = 'min';
                $company_info->warning = '*Please Execute day end before April 2021';
                $company_info->ci_clg_id = $college_id;
                $company_info->save();
            }


            /////// day end configuration
            $day_config = DayEndConfigModel::where('dec_clg_id', $college_id)->pluck('dec_cash_check')->first();
            if (empty($day_config)) {
                $day_end_config = new DayEndConfigModel();
                $day_end_config->dec_cash_check = 1;
                $day_end_config->dec_bank_check = 1;
                $day_end_config->dec_product_check = 1;
                $day_end_config->dec_warehouse_check = 1;
                $day_end_config->dec_create_trial = 2;
                $day_end_config->dec_create_closing_stock = 2;
                $day_end_config->dec_create_cash_bank_closing = 2;
                $day_end_config->dec_create_pnl = 2;
                $day_end_config->dec_create_balance_sheet = 2;
                $day_end_config->dec_create_pnl_distribution = 2;
                $day_end_config->dec_user_id = $user->user_id;
                $day_end_config->dec_clg_id = $college_id;
                $day_end_config->save();
            }


            ///////////////////// Department
            $depart = Department::where('dep_clg_id', $college_id)->pluck('dep_title')->first();
            if (empty($depart)) {

                $department = new Department();
                $department->dep_title = 'Initial Department';
                $department->dep_day_end_date = now();
                $department->dep_day_end_id = 0;
                $department->dep_createdby = 0;
                $department->dep_disabled = 0;
                $department->dep_delete_status = 0;
                $department->dep_clg_id = $college_id;
                $department->save();

                $department = new Department();
                $department->dep_title = 'General Department';
                $department->dep_day_end_date = now();
                $department->dep_day_end_id = 0;
                $department->dep_createdby = 0;
                $department->dep_disabled = 0;
                $department->dep_delete_status = 0;
                $department->dep_clg_id = $college_id;
                $department->save();
            }


            ///////////////////// Group entry 1
            $group_ = GroupInfoModel::where('grp_clg_id', $college_id)->pluck('grp_title')->first();
            if (empty($group_)) {
                $groups = collect((object)array(
                    (object)['name' => 'Initial Group'],
                    (object)['name' => 'Fixed Raw Product'])
                );
                foreach ($groups as $item) {
                    $group = new GroupInfoModel();
                    $group->grp_title = $item->name;
                    $group->grp_day_end_date = now();
                    $group->grp_day_end_id = 0;
                    $group->grp_createdby = 0;
                    $group->grp_disabled = 0;
                    $group->grp_delete_status = 0;
                    $group->grp_clg_id = $college_id;
                    $group->save();
                }
            }

            ///////////////////// Category
            $group_id = GroupInfoModel::where('grp_clg_id', $college_id)->pluck('grp_id')->first();
            $category = CategoryInfoModel::where('cat_clg_id', $college_id)->pluck('cat_title')->first();
            if (empty($category)) {

                $categorys = new CategoryInfoModel();
                $categorys->cat_group_id = $group_id;
                $categorys->cat_title = 'Initial Category';
                $categorys->cat_day_end_date = now();
                $categorys->cat_day_end_id = 0;
                $categorys->cat_createdby = 0;
                $categorys->cat_disabled = 0;
                $categorys->cat_delete_status = 0;
                $categorys->cat_clg_id = $college_id;
                $categorys->save();
            }

            ///////////////////// Main Unit
            $main_uni = MainUnitModel::where('mu_clg_id', $college_id)->pluck('mu_title')->first();
            if (empty($main_uni)) {
                $main_units = collect((object)array(
                    (object)['name' => 'Number'],
                    (object)['name' => 'Weight'],
                    (object)['name' => 'Measurement'])
                );
                foreach ($main_units as $mainUnit) {
                    $main_unit = new MainUnitModel();
                    $main_unit->mu_title = $mainUnit->name;
                    $main_unit->mu_day_end_date = now();
                    $main_unit->mu_day_end_id = 0;
                    $main_unit->mu_created_by = 0;
                    $main_unit->mu_disabled = 0;
                    $main_unit->mu_delete_status = 0;
                    $main_unit->mu_clg_id = $college_id;
                    $main_unit->save();
                }
            }

            /////////////////////  Unit
            $unit = UnitInfoModel::where('unit_clg_id', $college_id)->pluck('unit_title')->first();
            $main_unit_id = MainUnitModel::where('mu_clg_id', $college_id)->pluck('mu_id');
            if (empty($unit)) {
                $units = collect((object)array(
                    (object)['name' => 'Piece', 'main_unit' => $main_unit_id[0], 'scale_size' => 1],
                    (object)['name' => 'Kg', 'main_unit' => $main_unit_id[1], 'scale_size' => 1000],
                    (object)['name' => 'Feet', 'main_unit' => $main_unit_id[2], 'scale_size' => 12])
                );
                foreach ($units as $mainUnit) {
                    $unit_info = new UnitInfoModel();
                    $unit_info->unit_main_unit_id = $mainUnit->main_unit;
                    $unit_info->unit_title = $mainUnit->name;
                    $unit_info->unit_scale_size = $mainUnit->scale_size;
                    $unit_info->unit_day_end_date = now();
                    $unit_info->unit_day_end_id = 0;
                    $unit_info->unit_createdby = 0;
                    $unit_info->unit_disabled = 0;
                    $unit_info->unit_delete_status = 0;
                    $unit_info->unit_clg_id = $college_id;
                    $unit_info->save();
                }
            }

            ///////////////////// Product Groups

            $products_grp = ProductGroupModel::where('pg_clg_id', $college_id)->pluck('pg_title')->first();
            if (empty($products_grp)) {
                $product_groups = collect((object)array(
                    (object)['name' => 'Managerial Group'],
                    (object)['name' => 'Sales Group'],
                    (object)['name' => 'Purchase Group'],
                    (object)['name' => 'Accounts Group'],
                    (object)['name' => 'Cashier Group'])
                );
                foreach ($product_groups as $product_group) {
                    $products_group = new ProductGroupModel();
                    $products_group->pg_title = $product_group->name;
                    $products_group->pg_day_end_date = now();
                    $products_group->pg_day_end_id = 0;
                    $products_group->pg_created_by = 0;
                    $products_group->pg_disabled = 0;
                    $products_group->pg_delete_status = 0;
                    $products_group->pg_clg_id = $college_id;
                    $products_group->save();
                }
            }


            ///////////////////// Product Type
            $products_typ = ProductTypeModel::pluck('pt_title')->first();

            if (empty($products_typ)) {
                $product_types = collect((object)array(
                    (object)['name' => 'Saleable Goods / Finish Goods', 'description' => 'Sale Invoice , Sale Return Invoice , Loss Voucer , Recvoer Voucher , Transfer Voucher , DO , DC , SO , Production Finish Goods  , Gate Outward'],
                    (object)['name' => 'Purchase Able Goods / Raw Material', 'description' => 'Purchase Invoice, Purchase Return Invoice Loss Voucer   Recvoer Voucher, Transfer Voucher, GRN, Gate Inward, Production Raw Material'],
                    (object)['name' => 'Trading Goods', 'description' => 'Sale Invoice , Sale Return Invoice , Loss Voucer , Recvoer Voucher , Transfer Voucher , DO , DC , SO , Production Finish Goods  , Gate Outward


Purchase Invoice , Purchase Return Invoice, Loss Voucer,  Recvoer Voucher, Transfer Voucher, GRN, Gate Inward, Production Raw Material '],
                    (object)['name' => 'By-Products', 'description' => 'Sale Invoice , Sale Return Invoice , Transfer Voucher , DO , DC , SO , Production By-Products  , Gate Outward'])
                );
                foreach ($product_types as $item) {
                    $products_group = new ProductTypeModel();
                    $products_group->pt_title = $item->name;
                    $products_group->pt_description = $item->description;
                    $products_group->save();
                }
            }

            ///////////////////// region
            $reg = RegionModel::where('reg_clg_id', $college_id)->pluck('reg_title')->first();
            if (empty($reg)) {
                $region = new RegionModel();
                $region->reg_title = 'Initial Region';
                $region->reg_day_end_date = now();
                $region->reg_day_end_id = 0;
                $region->reg_createdby = 0;
                $region->reg_disabled = 0;
                $region->reg_delete_status = 0;
                $region->reg_clg_id = $college_id;
                $region->save();
            }
            ///////////////////// area
            $ara = AreaModel::where('area_clg_id', $college_id)->pluck('area_title')->first();
            if (empty($ara)) {
                $area = new AreaModel();
                $area->area_reg_id = $region->reg_id;
                $area->area_title = 'Initial Area';
                $area->area_day_end_date = now();
                $area->area_day_end_id = 0;
                $area->area_createdby = 0;
                $area->area_disabled = 0;
                $area->area_delete_status = 0;
                $area->area_clg_id = $college_id;
                $area->save();
            }
            ///////////////////// sector
            $sect = SectorModel::where('sec_clg_id', $college_id)->pluck('sec_title')->first();
            if (empty($sect)) {
                $sector = new SectorModel();
                $sector->sec_area_id = $area->area_id;
                $sector->sec_title = 'Initial Sector';
                $sector->sec_day_end_date = now();
                $sector->sec_day_end_id = 0;
                $sector->sec_createdby = 0;
                $sector->sec_disabled = 0;
                $sector->sec_delete_status = 0;
                $sector->sec_clg_id = $college_id;
                $sector->save();
            }
            ///////////////////// town
            $town = TownModel::where('town_clg_id', $college_id)->pluck('town_title')->first();
            if (empty($town)) {
                $towns = new TownModel();
                $towns->town_sector_id = $sector->sec_id;
                $towns->town_title = 'Initial Town';
                $towns->town_day_end_date = now();
                $towns->town_day_end_id = 0;
                $towns->town_createdby = 0;
                $towns->town_disabled = 0;
                $towns->town_delete_status = 0;
                $towns->town_clg_id = $college_id;
                $towns->save();
            }


            ///////////////////// Report Config

            $rept_config = ReportConfigModel::where('rc_clg_id', $college_id)->pluck('rc_invoice')->first();
            if (empty($rept_config)) {
                $report_config = new ReportConfigModel();
                $report_config->rc_invoice = 0;
                $report_config->rc_invoice_party = 0;
                $report_config->rc_detail_remarks = 0;
                $report_config->rc_user_id = $user->user_id;
                $report_config->rc_clg_id = $college_id;
                $report_config->save();
            }
            ///////////////////// Project Reference

            $posting_reference = PostingReferenceModel::where('pr_clg_id', $college_id)->pluck('pr_id')->first();
            if (empty($posting_reference)) {
                $posting_ref = new PostingReferenceModel();
                $posting_ref->pr_name = 'Universal Posting';
                $posting_ref->pr_createdby = $user->user_id;
                $posting_ref->pr_clg_id = $college_id;
                $posting_ref->save();
            }


            ///////////////////// System configuration
            $system_config = SystemConfigModel::where('sc_clg_id', $college_id)->where('sc_id', '=', 1)->first();
            if (empty($system_config)) {
                $system_config = new SystemConfigModel();
            }
            $system_config->sc_clg_id = $college_id;
            $system_config->sc_profile_update = 0;
            $system_config->sc_company_info_update = 0;
            $system_config->sc_products_added = 0;
            $system_config->sc_admin_capital_added = 0;
            $system_config->sc_opening_trial_complete = 0;
            $system_config->sc_first_date = now();
            $system_config->sc_first_date_added = 0;
            $system_config->sc_bank_payment_voucher_number = 0;
            $system_config->sc_bank_receipt_voucher_number = 0;
            $system_config->sc_cash_payment_voucher_number = 0;
            $system_config->sc_cash_receipt_voucher_numer = 0;
            $system_config->sc_expense_payment_voucher_number = 0;
            $system_config->sc_journal_voucher_number = 0;
            $system_config->sc_purchase_invoice_number = 0;
            $system_config->sc_purchase_return_invoice_number = 0;
            $system_config->sc_purchase_st_invoice_number = 0;
            $system_config->sc_purchase_return_st_invoice_number = 0;
            $system_config->sc_salary_payment_voucher_number = 0;
            $system_config->sc_salary_slip_voucher_number = 0;
            $system_config->sc_advance_salary_voucher_number = 0;
            $system_config->sc_sale_invoice_number = 0;
            $system_config->sc_sale_return_invoice_number = 0;
            $system_config->sc_sale_tax_invoice_number = 0;
            $system_config->sc_sale_tax_return_invoice_number = 0;
            $system_config->sc_service_invoice_number = 0;
            $system_config->sc_service_tax_invoice_number = 0;
            $system_config->sc_all_done = 0;
            $system_config->sc_welcome_wizard = 'company_info:1;;;reporting_group:1;;;product_reporting_group:1;;;add_modular_group:0;;;warehouse:1;;;organization_department:-1;;;admin_profile:1;;;parent_account_1:0;;;salary_account:-1;;;employee:1;;;group:1;;;category:1;;;main_unit:1;;;unit:1;;;brand:0;;;product:1;;;product_clubbing:0;;;product_packages:0;;;product_recipe:0;;;service:0;;;bank_account:1;;;credit_card_machine:0;;;region:1;;;area:1;;;sector:1;;;town:1;;;client_registration:1;;;supplier_registration:1;;;group_account:1;;;parent_account:1;;;entry_account:1;;;fixed_account:1;;;expense_account:1;;;asset_parent_account:0;;;expense_group_account:1;;;asset_registration:0;;;second_head:1;;;capital_registration:1;;;day_end_config:1;;;system_date:0;;;opening_stock:0;;;opening_party_balance:1;;;opening_trail:0;;;opening_invoice_n_voucher_sequence:-1;;;department:1;;;add_role_permission:1;;;total_completed:30;;;total_active:11;;;total_disabled:5;;;wizard_completed:0;;;required_completed:4;;;total_required:4';
            $system_config->save();


            ///////////////////// Role
            $rol = RolesModel::pluck('user_role_title')->first();
            if (empty($rol)) {
                $roles = collect((object)array(
                    (object)['name' => 'Other Employee'],
                    (object)['name' => 'Cashier'],
                    (object)['name' => 'Teller'],
                    (object)['name' => 'Sale Person'],
                    (object)['name' => 'Purchaser'])
                );

                foreach ($roles as $item) {
                    $role = new RolesModel();
                    $role->user_role_title = $item->name;
                    $role->save();
                }
            }

            ///////////////////// Designation
            $designation = DesignationModel::where('desig_clg_id',$college_id)->pluck('desig_name')->first();
            if (empty($designation)) {
                $designations = collect((object)array(
                    (object)['name' => 'Super Admin'],
                    (object)['name' => 'Coordinator'])
                );
                foreach ($designations as $items) {
                    $warehouse = new DesignationModel();
                    $warehouse->desig_name = $items->name;
                    $warehouse->desig_clg_id = $college_id;
                    $warehouse->save();
                }
            }

            ///////////////////// Warehouse
            $warehous = WarehouseModel::where('wh_clg_id', $college_id)->pluck('wh_title')->first();
            if (empty($warehous)) {
                $warehouses = collect((object)array(
                    (object)['name' => 'Main Store'],
                    (object)['name' => 'Sale Return Warehouse'],
                    (object)['name' => 'Claim Warehouse'],
                    (object)['name' => 'Work In Progress Warehouse'])
                );
                foreach ($warehouses as $items) {
                    $warehouse = new WarehouseModel();
                    $warehouse->wh_title = $items->name;
                    $warehouse->wh_created_by = 0;
                    $warehouse->wh_disabled = 0;
                    $warehouse->wh_delete_status = 0;
                    $warehouse->wh_clg_id = $college_id;
                    $warehouse->save();
                }
            }


            ///////////////////// coa heads
            $head = AccountHeadsModel::where('coa_clg_id', $college_id)->pluck('coa_code')->first();
            if (empty($head)) {
                $coa_heads = collect((object)array(
                    (object)['code' => 1, 'name' => 'ASSETS', 'parent' => 0, 'level' => 1],
                    (object)['code' => 2, 'name' => 'LIABILITIES', 'parent' => 0, 'level' => 1],
                    (object)['code' => 3, 'name' => 'REVENUE', 'parent' => 0, 'level' => 1],
                    (object)['code' => 4, 'name' => 'EXPENSES', 'parent' => 0, 'level' => 1],
                    (object)['code' => 5, 'name' => 'EQUITY', 'parent' => 0, 'level' => 1],

                    (object)['code' => 110, 'name' => 'Current Asset', 'parent' => 1, 'level' => 2],
                    (object)['code' => 111, 'name' => 'Fixed Asset', 'parent' => 1, 'level' => 2],
                    (object)['code' => 112, 'name' => 'Other Assets', 'parent' => 1, 'level' => 2],

                    (object)['code' => 11010, 'name' => 'Cash', 'parent' => 110, 'level' => 3],
                    (object)['code' => 11011, 'name' => 'Stock', 'parent' => 110, 'level' => 3],
                    (object)['code' => 11012, 'name' => 'Bank', 'parent' => 110, 'level' => 3],
                    (object)['code' => 11013, 'name' => 'Account Receivables', 'parent' => 110, 'level' => 3],
                    (object)['code' => 11014, 'name' => 'Prepaid Expenses', 'parent' => 110, 'level' => 3],
                    (object)['code' => 11015, 'name' => 'Tax Receivables', 'parent' => 110, 'level' => 3],
                    (object)['code' => 11016, 'name' => 'Walk In Customer', 'parent' => 110, 'level' => 3],
                    (object)['code' => 11017, 'name' => 'Party Claims', 'parent' => 110, 'level' => 3],
                    (object)['code' => 11018, 'name' => 'Credit Card Machine', 'parent' => 110, 'level' => 3],
                    (object)['code' => 11019, 'name' => 'Staff Loan', 'parent' => 110, 'level' => 3],
                    (object)['code' => 11020, 'name' => 'Receivable From Student ', 'parent' => 110, 'level' => 3],
                    (object)['code' => 11021, 'name' => 'Arrears Receivables ', 'parent' => 110, 'level' => 3],

                    (object)['code' => 11210, 'name' => 'Suspenses', 'parent' => 112, 'level' => 3],

                    (object)['code' => 210, 'name' => 'Current Liability', 'parent' => 2, 'level' => 2],
                    (object)['code' => 211, 'name' => 'Other Liability', 'parent' => 2, 'level' => 2],

                    (object)['code' => 21010, 'name' => 'Account Payables', 'parent' => 210, 'level' => 3],
                    (object)['code' => 21011, 'name' => 'Taxes Payables', 'parent' => 210, 'level' => 3],
                    (object)['code' => 21012, 'name' => 'Purchaser', 'parent' => 210, 'level' => 3],
                    (object)['code' => 21013, 'name' => 'Unearned Student Fee', 'parent' => 210, 'level' => 3],
                    (object)['code' => 21110, 'name' => 'Suspenses', 'parent' => 211, 'level' => 3],

                    (object)['code' => 310, 'name' => 'Income From Sales', 'parent' => 3, 'level' => 2],
                    (object)['code' => 311, 'name' => 'Other Incomes', 'parent' => 3, 'level' => 2],

                    (object)['code' => 31010, 'name' => 'Sales Revenue', 'parent' => 310, 'level' => 3],
                    (object)['code' => 31011, 'name' => 'Student Income', 'parent' => 310, 'level' => 3],
                    (object)['code' => 31110, 'name' => 'Services Revenue', 'parent' => 311, 'level' => 3],
                    (object)['code' => 31111, 'name' => 'Margins', 'parent' => 311, 'level' => 3],
                    (object)['code' => 31112, 'name' => 'Amortization', 'parent' => 311, 'level' => 3],
                    (object)['code' => 31113, 'name' => 'Fine Income', 'parent' => 311, 'level' => 3],

                    (object)['code' => 410, 'name' => 'Stock Expenses', 'parent' => 4, 'level' => 2],
                    (object)['code' => 411, 'name' => 'CGS Expenses', 'parent' => 4, 'level' => 2],
                    (object)['code' => 412, 'name' => 'Salaries Expenses', 'parent' => 4, 'level' => 2],
                    (object)['code' => 413, 'name' => 'Service Charges', 'parent' => 4, 'level' => 2],
                    (object)['code' => 414, 'name' => 'Operating Expenses', 'parent' => 4, 'level' => 2],
                    (object)['code' => 415, 'name' => 'Sales Discounts', 'parent' => 4, 'level' => 2],
                    (object)['code' => 416, 'name' => 'Over Time Expense', 'parent' => 4, 'level' => 2],

                    (object)['code' => 41010, 'name' => 'Loss & Recover', 'parent' => 410, 'level' => 3],
                    (object)['code' => 41011, 'name' => 'Bonus Expenses', 'parent' => 410, 'level' => 3],

                    (object)['code' => 41110, 'name' => 'Purchases', 'parent' => 411, 'level' => 3],
                    (object)['code' => 41111, 'name' => 'Depreciation CGS', 'parent' => 411, 'level' => 3],
                    (object)['code' => 41112, 'name' => 'Claims', 'parent' => 411, 'level' => 3],

                    (object)['code' => 41310, 'name' => 'Bank Service Charges', 'parent' => 413, 'level' => 3],

                    (object)['code' => 41410, 'name' => 'Depreciation OPT', 'parent' => 414, 'level' => 3],
                    (object)['code' => 41411, 'name' => 'Discounts', 'parent' => 414, 'level' => 3],

                    (object)['code' => 41510, 'name' => 'Discounts', 'parent' => 415, 'level' => 3],
                    (object)['code' => 41511, 'name' => 'Trade Discounts', 'parent' => 415, 'level' => 3],

                    (object)['code' => 41610, 'name' => 'Over Time', 'parent' => 416, 'level' => 3],

                    (object)['code' => 510, 'name' => "Owner's Equity", 'parent' => 5, 'level' => 2],
                    (object)['code' => 511, 'name' => "Investoer's Equity", 'parent' => 5, 'level' => 2],
                    (object)['code' => 512, 'name' => 'Other Equity', 'parent' => 5, 'level' => 2],

                    (object)['code' => 51210, 'name' => 'Undistributed Equity', 'parent' => 512, 'level' => 3],
                    (object)['code' => 41412, 'name' => 'Salaries Exp (NEW In OE)', 'parent' => 414, 'level' => 3],

                    (object)['code' => 41113, 'name' => 'Stock Adjustment', 'parent' => 411, 'level' => 3],
                    (object)['code' => 41012, 'name' => 'Consumed & Produced', 'parent' => 410, 'level' => 3])
                );
                foreach ($coa_heads as $items) {
                    $coa_head = new AccountHeadsModel();
                    $coa_head->coa_code = $items->code;
                    $coa_head->coa_head_name = $items->name;
                    $coa_head->coa_parent = $items->parent;
                    $coa_head->coa_level = $items->level;
                    $coa_head->coa_system_generated = 1;
                    $coa_head->coa_disabled = 0;
                    $coa_head->coa_delete_status = 0;
                    $coa_head->coa_clg_id = $college_id;

                    $coa_head->save();
                }
            }


            ///////////////////// Accounts
            $acount = AccountRegisterationModel::where('account_clg_id', $college_id)->pluck('account_uid')->first();
            if (empty($acount)) {
                $accounts = collect((object)array(
                    (object)['account_parent_code' => 11010, 'account_uid' => 110101, 'account_name' => 'Cash', 'account_print_name' => 'Cash', 'account_remarks' => 'System main cash account'],
                    (object)['account_parent_code' => 11011, 'account_uid' => 110111, 'account_name' => 'Stock', 'account_print_name' => 'Stock', 'account_remarks' => 'Stock amount calculated from products purchase price multiply to quantity.'],
                    (object)['account_parent_code' => 11015, 'account_uid' => 110151, 'account_name' => 'Input Tax', 'account_print_name' => 'Input Tax', 'account_remarks' => 'Sales tax at the time of purchase invoice.'],
                    (object)['account_parent_code' => 11016, 'account_uid' => 110161, 'account_name' => 'Walk In Customer', 'account_print_name' => 'Walk In Customer', 'account_remarks' => 'Walk in Customer account used at the time of counter sale.'],
                    (object)['account_parent_code' => 11210, 'account_uid' => 112101, 'account_name' => 'Suspense', 'account_print_name' => 'Suspense', 'account_remarks' => ''],
                    (object)['account_parent_code' => 21011, 'account_uid' => 210111, 'account_name' => 'FBR Output Tax(Tax Payable)', 'account_print_name' => 'FBR Output Tax(Tax Payable)', 'account_remarks' => 'Sales tax at the time of sale invoice.'],
                    (object)['account_parent_code' => 21011, 'account_uid' => 210112, 'account_name' => 'Province Output Tax(Tax Payable)', 'account_print_name' => 'Province Output Tax(Tax Payable)', 'account_remarks' => 'Service tax at the time of service invoice.'],
                    (object)['account_parent_code' => 21110, 'account_uid' => 211101, 'account_name' => 'Suspense', 'account_print_name' => 'Suspense', 'account_remarks' => ''],
                    (object)['account_parent_code' => 21012, 'account_uid' => 210121, 'account_name' => 'Purchaser', 'account_print_name' => 'Purchaser', 'account_remarks' => 'Default purchaser account used at the time of purchase invoice.'],

                    (object)['account_parent_code' => 21013, 'account_uid' => 210131, 'account_name' => 'Unearned Tution Fee', 'account_print_name' => 'Unearned Tution Fee', 'account_remarks' => ''],
                    (object)['account_parent_code' => 21013, 'account_uid' => 210132, 'account_name' => 'Unearned Paper Fund', 'account_print_name' => 'Unearned Tution Fee', 'account_remarks' =>
                        ''],
                    (object)['account_parent_code' => 21013, 'account_uid' => 210133, 'account_name' => 'Unearned Annual Fund', 'account_print_name' => 'Unearned Tution Fee', 'account_remarks' => ''],

                    (object)['account_parent_code' => 31010, 'account_uid' => 310101, 'account_name' => 'Sales', 'account_print_name' => 'Sales', 'account_remarks' => 'Sales account used at the time of sale invoice.'],
                    (object)['account_parent_code' => 31010, 'account_uid' => 310102, 'account_name' => 'Sales Return', 'account_print_name' => 'Sales Return', 'account_remarks' => 'Sales account used at the time of sale return invoice.'],

                    (object)['account_parent_code' => 31011, 'account_uid' => 310111, 'account_name' => 'Tution Fee Income', 'account_print_name' => 'Tution Fee Income', 'account_remarks' => ''],
                    (object)['account_parent_code' => 31011, 'account_uid' => 310112, 'account_name' => 'Paper Fund Income', 'account_print_name' => 'Paper Fund Income', 'account_remarks' => ''],
                    (object)['account_parent_code' => 31011, 'account_uid' => 310113, 'account_name' => 'Annual Fund Income', 'account_print_name' => 'Annual Fund Income', 'account_remarks' => ''],

                    (object)['account_parent_code' => 31110, 'account_uid' => 311101, 'account_name' => 'Services', 'account_print_name' => 'Services', 'account_remarks' => 'Service account used at the time of service invoice.'],
                    (object)['account_parent_code' => 31111, 'account_uid' => 311111, 'account_name' => 'Sale Margin', 'account_print_name' => 'Sale Margin', 'account_remarks' => 'Sale margin account used at the time of non tax sale invoice.'],

                    (object)['account_parent_code' => 31113, 'account_uid' => 311131, 'account_name' => 'Fine Income', 'account_print_name' => 'Fine Income', 'account_remarks' => ''],
                    (object)['account_parent_code' => 41010, 'account_uid' => 410101, 'account_name' => 'Product Loss & Recover', 'account_print_name' => 'Product Loss & Recover', 'account_remarks' => ''],
                    (object)['account_parent_code' => 41011, 'account_uid' => 410111, 'account_name' => 'Bonus Allocation-Deallocation', 'account_print_name' => 'Bonus Allocation-Deallocation', 'account_remarks' => ''],
                    (object)['account_parent_code' => 41110, 'account_uid' => 411101, 'account_name' => 'Purchase', 'account_print_name' => 'Purchase', 'account_remarks' => ''],
                    (object)['account_parent_code' => 41110, 'account_uid' => 411102, 'account_name' => 'Purchase Return', 'account_print_name' => 'Purchase Return', 'account_remarks' => ''],
                    (object)['account_parent_code' => 41112, 'account_uid' => 411121, 'account_name' => 'Claim Issue', 'account_print_name' => 'Claim Issue', 'account_remarks' => ''],
                    (object)['account_parent_code' => 41112, 'account_uid' => 411122, 'account_name' => 'Claim Received', 'account_print_name' => 'Claim Received', 'account_remarks' => ''],
                    (object)['account_parent_code' => 41411, 'account_uid' => 414111, 'account_name' => 'Round off Discount', 'account_print_name' => 'Round off Discount', 'account_remarks' => ''],
                    (object)['account_parent_code' => 41411, 'account_uid' => 414112, 'account_name' => 'Zakat', 'account_print_name' => 'Zakat', 'account_remarks' => ''],
                    (object)['account_parent_code' => 41511, 'account_uid' => 415111, 'account_name' => 'Product Discount', 'account_print_name' => 'Product Discount', 'account_remarks' => ''],
                    (object)['account_parent_code' => 41511, 'account_uid' => 415112, 'account_name' => 'Retailer Discount', 'account_print_name' => 'Retailer Discount', 'account_remarks' => ''],
                    (object)['account_parent_code' => 41511, 'account_uid' => 415113, 'account_name' => 'Whole Seller Discount', 'account_print_name' => 'Whole Seller Discount', 'account_remarks' => ''],
                    (object)['account_parent_code' => 41511, 'account_uid' => 415114, 'account_name' => 'Loyality Card Discount', 'account_print_name' => 'Loyality Card Discount', 'account_remarks' => ''],
                    (object)['account_parent_code' => 41510, 'account_uid' => 415101, 'account_name' => 'Cash Discount', 'account_print_name' => 'Cash Discount', 'account_remarks' => ''],
                    (object)['account_parent_code' => 41510, 'account_uid' => 415102, 'account_name' => 'Service Discount', 'account_print_name' => 'Service Discount', 'account_remarks' => ''],
                    (object)['account_parent_code' => 41610, 'account_uid' => 415101, 'account_name' => 'Over Time', 'account_print_name' => 'Over Time', 'account_remarks' => ''],



                    (object)['account_parent_code' => 51210, 'account_uid' => 512101, 'account_name' => 'Undistributed Profit & Loss', 'account_print_name' => 'Undistributed Profit & Loss',
                        'account_remarks' => ''],
                    (object)['account_parent_code' => 11013, 'account_uid' => 110131, 'account_name' => 'Client One', 'account_print_name' => 'Client One', 'account_remarks' => ''],
                    (object)['account_parent_code' => 21010, 'account_uid' => 210101, 'account_name' => 'Supplier One', 'account_print_name' => 'Supplier One', 'account_remarks' => ''],
                    (object)['account_parent_code' => 21010, 'account_uid' => 210102, 'account_name' => 'Zakat', 'account_print_name' => 'Zakat', 'account_remarks' => ''],
                    (object)['account_parent_code' => 11012, 'account_uid' => 110121, 'account_name' => 'Bank1', 'account_print_name' => 'Bank1', 'account_remarks' => ''],
                    (object)['account_parent_code' => 41113, 'account_uid' => 411131, 'account_name' => 'Product Recover & Loss', 'account_print_name' => 'Product Recover & Loss', 'account_remarks' => ''],
                    (object)['account_parent_code' => 41511, 'account_uid' => 415115, 'account_name' => 'Trade Offer Account', 'account_print_name' => 'Trade Offer Account', 'account_remarks' => ''],
                    (object)['account_parent_code' => 41012, 'account_uid' => 410121, 'account_name' => 'Product Stock Consumed', 'account_print_name' => 'Product Stock Consumed', 'account_remarks' => ''],
                    (object)['account_parent_code' => 41113, 'account_uid' => 411132, 'account_name' => 'Product Stock Produced', 'account_print_name' => 'Product Stock Produced', 'account_remarks' => ''],
                    (object)['account_parent_code' => 41113, 'account_uid' => 411133, 'account_name' => 'Production Stock Adjustment', 'account_print_name' => 'Production Stock Adjustment', 'account_remarks' => ''],
                    (object)['account_parent_code' => 11017, 'account_uid' => 110171, 'account_name' => 'Client One Claims', 'account_print_name' => 'Client One Claims', 'account_remarks' => ''],
                    (object)['account_parent_code' => 11017, 'account_uid' => 110172, 'account_name' => 'Supplier One Claims', 'account_print_name' => 'Supplier One Claims', 'account_remarks' => ''],
                    (object)['account_parent_code' => 41310, 'account_uid' => 413101, 'account_name' => 'Bank1 Credit Card Service Charges', 'account_print_name' => 'Bank1 Credit Card Service Charges',
                        'account_remarks'
                        => ''],
                    (object)['account_parent_code' => 11018, 'account_uid' => 110181, 'account_name' => 'Bank1 Credit Card Machine', 'account_print_name' => 'Bank1 Credit Card Machine',
                        'account_remarks' => ''],
                    (object)['account_parent_code' => 11020, 'account_uid' => 110201, 'account_name' => 'Tution Fee Receivable', 'account_print_name' => 'Tution Fee Receivable',
                        'account_remarks' => ''],
                    (object)['account_parent_code' => 11020, 'account_uid' => 110202, 'account_name' => 'Paper Fund Receivable', 'account_print_name' => 'Paper Fund Receivable',
                        'account_remarks' => ''],
                    (object)['account_parent_code' => 11020, 'account_uid' => 110203, 'account_name' => 'Annual Fund Receivable', 'account_print_name' => 'Annual Fund Receivable',
                        'account_remarks' => ''],
                    (object)['account_parent_code' => 11021, 'account_uid' => 110211, 'account_name' => 'Arrears Receivable', 'account_print_name' => 'Arrears Receivables',
                        'account_remarks' => ''],
                    )

                );

                foreach ($accounts as $items) {
                    $account = new AccountRegisterationModel();
                    $account->account_parent_code = $items->account_parent_code;
                    $account->account_uid = $items->account_uid;
                    $account->account_name = $items->account_name.' - '.$branch_no;
                    $account->account_print_name = $items->account_print_name.' '.$branch_no;
                    $account->account_remarks = $items->account_remarks;
                    $account->account_today_opening_type = '';
                    $account->account_today_opening = 0;
                    $account->account_today_debit = 0;
                    $account->account_today_credit = 0;
                    $account->account_monthly_opening_type = '';
                    $account->account_monthly_opening = 0;
                    $account->account_monthly_debit = 0;
                    $account->account_monthly_credit = 0;
                    $account->account_balance = 0;

                    $account->account_region_id = 0;
                    $account->account_area = 0;
                    $account->account_sector_id = 0;
                    $account->account_town_id = 0;

                    $account->account_createdby = 0;
                    $account->account_group_id = 1;
                    $account->account_employee_id = 0;
                    $account->account_link_uid = 0;
                    $account->account_sale_person = 0;
                    $account->account_sale_person = 0;

                    $account->account_disabled = 0;
                    $account->account_delete_status = 0;
                    $account->account_clg_id = $college_id;
                    $account->save();
                }

            }

            ///////////////////// Trial balance
            $accounts = AccountRegisterationModel::where('account_clg_id', $college_id)->select('account_uid','account_name')->get();
            if (!empty($accounts)) {
                foreach ($accounts as $account) {
                    $trial_balance = new OpeningTrialBalanceModel();
                    $trial_balance->tb_account_id = $account->account_uid;
                    $trial_balance->tb_account_name = $account->account_name;
                    $trial_balance->tb_total_debit = 0;
                    $trial_balance->tb_total_credit = 0;
                    $trial_balance->tb_clg_id = $college_id;
                    $trial_balance->save();
                }
            }
            ///////////////////// Master And Super admin User
            $designation = DesignationModel::where('desig_clg_id',$college_id)->pluck('desig_id')->first();
            $depart = Department::where('dep_clg_id', $college_id)->pluck('dep_id')->first();
            $grop = AccountGroupModel::where('ag_clg_id', $college_id)->pluck('ag_id')->first();
            $products_grp = ProductGroupModel::where('pg_clg_id', $college_id)->pluck('pg_id')->first();
            $users = User::where('user_clg_id', $college_id)->count();
            if ($users == 0) {
                $master_user = new User();
                $master_user->user_employee_code = 'MAAA-0001' . $college_id;
                $master_user->user_designation = 1;
                $master_user->user_name = 'Master' . $college_name;
                $master_user->user_father_name = 'Master';
                $master_user->user_username = 'master' . $college_id;
                $master_user->user_password = '$2y$10$aaNT6T1D3ujaC179oe9mO.107yRvY1WyRehU2Cx00OXkKu0pZ8Ela';
                $master_user->user_email = 'master@digitalmunshi' . $college_id . '.com';
                $master_user->user_mobile = '03118798654';
                $master_user->user_login_status = 'ENABLE';
                $master_user->user_religion = 1;
                $master_user->user_role_id = 1;
                $master_user->user_level = 100;
                $master_user->user_marital_status = 1;
                $master_user->user_salary_person = 0;
                $master_user->user_loan_person = 0;
                $master_user->user_have_credentials = 1;
                $master_user->user_loan_person = 0;
                $master_user->user_delete_status = 0;
                $master_user->user_deleted_by = 0;
                $master_user->user_web_status = 'offline';
                $master_user->user_desktop_status = 'offline';
                $master_user->user_disabled = 0;
                $master_user->user_android_status = 'offline';
                $master_user->user_ios_status = 'offline';
                $master_user->user_send_day_end_report = 1;
                $master_user->user_send_month_end_report = 1;
                $master_user->user_send_sync_report = 1;
                $master_user->user_status = 'Employee';
                $master_user->user_clg_id = $college_id;
                $master_user->user_branch_id = $branch_id;
                $master_user->user_account_reporting_group_ids = $grop;
                $master_user->user_product_reporting_group_ids = $products_grp;
                $master_user->user_modular_group_id = $modular_group->id;
                $master_user->user_department_id = $depart;
                $master_user->user_expiry_date = Carbon::now()->addDays(50);
                $master_user->user_type = 'Master';

                $master_user->save();
                $master_user->assignRole($modular_group->id);

                $sadmin = new User();
                $sadmin->user_employee_code = 'SAAA-0001' . $college_id;
                $sadmin->user_designation = $designation;
                $sadmin->user_name = 'Super Admin' . $college_name;
                $sadmin->user_father_name = 'Super Admin';
                $sadmin->user_username = 'sadmin' . $college_id;
                $sadmin->user_password = '$2y$10$Aol5etRmJWQtWFTF4WRMB.e4Uq0XFSTTvUexIlP0LH9mxYvwYcBLS';
                $sadmin->user_email = 'sadmin@digitalmunshi' . $college_id . '.com';
                $sadmin->user_mobile = '03118798654';
                $sadmin->user_login_status = 'ENABLE';
                $sadmin->user_religion = 1;
                $sadmin->user_role_id = 1;
                $sadmin->user_level = 100;
                $sadmin->user_marital_status = 1;
                $sadmin->user_salary_person = 0;
                $sadmin->user_loan_person = 0;
                $sadmin->user_have_credentials = 1;
                $sadmin->user_loan_person = 0;
                $sadmin->user_delete_status = 0;
                $sadmin->user_deleted_by = 0;
                $sadmin->user_web_status = 'offline';
                $sadmin->user_desktop_status = 'offline';
                $sadmin->user_disabled = 0;
                $sadmin->user_android_status = 'offline';
                $sadmin->user_ios_status = 'offline';
                $sadmin->user_send_day_end_report = 1;
                $sadmin->user_send_month_end_report = 1;
                $sadmin->user_send_sync_report = 1;
                $sadmin->user_status = 'Employee';
                $sadmin->user_clg_id = $college_id;
                $sadmin->user_branch_id = $branch_id;
                $sadmin->user_account_reporting_group_ids = $grop;
                $sadmin->user_product_reporting_group_ids = $products_grp;
                $sadmin->user_modular_group_id = $modular_group->id;
                $sadmin->user_department_id = $depart;
                $sadmin->user_expiry_date = Carbon::now()->addDays(50);
                $sadmin->user_type = 'Super Admin';

                $sadmin->save();

                $sadmin->assignRole($modular_group->id);
            }
        });
        return redirect()->back()->with('success', 'Successfully Saved');
    }


}
