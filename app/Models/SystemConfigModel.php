<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemConfigModel extends Model
{
    // tabel name
    protected $table = 'financials_system_config';

    // Primary Key attributes
    protected $primaryKey = 'sc_id';
    public $incrementing = true;

    // Timestamp Attributes
    public $timestamps = false;


    private static $Total_Wizard_Actions = 41;
    private static $Total_Required = 4; // change " $se_welcome_wizard_default " as well
    private $se_welcome_wizard_default = 'company_info:0;;;reporting_group:0;;;product_reporting_group:0;;;add_role_permission:0;;;warehouse:0;;;department:0;;;admin_profile:0;;;parent_account_1:0;;;salary_account:-1;;;employee:-1;;;group:0;;;category:-1;;;main_unit:0;;;unit:-1;;;brand:0;;;product:-1;;;product_clubbing:-1;;;product_packages:-1;;;product_recipe:-1;;;service:0;;;bank_account:0;;;credit_card_machine:-1;;;region:0;;;area:-1;;;sector:-1;;;town:-1;;;client_registration:-1;;;supplier_registration:-1;;;group_account:1;;;parent_account:1;;;entry_account:1;;;fixed_account:1;;;expense_account:1;;;asset_parent_account:0;;;expense_group_account:0;;;asset_registration:0;;;second_head:1;;;capital_registration:0;;;day_end_config:0;;;system_date:-1;;;opening_stock:-1;;;opening_party_balance:-1;;;opening_trail:-1;;;opening_invoice_n_voucher_sequence:-1;;;total_completed:0;;;total_active:1;;;total_disabled:0;;;wizard_completed:0;;;required_completed:0;;;total_required:4';

    public function getTotalWizardActions ()
    {
        return self::$Total_Wizard_Actions;
    }


    public function getScWelcomeWizardAttribute()
    {
        $sc_welcome_wizard = $this->attributes['sc_welcome_wizard'];
        if (!isset($sc_welcome_wizard)) return null;

        $sc_welcome_wizard = explode(';;;', $sc_welcome_wizard);
        $value = [];
        foreach ($sc_welcome_wizard as $index => $pairValue)
        {
            $temp = explode(':', $pairValue);
            $value[$temp[0]] = $temp[1];
        }
        return $value;
    }

    public static function convertScWelcomeWizardToString($sc_welcome_wizard)
    {

        $active = 0;
        $disabled = 0;
        $completed = 0;
        $wizardCompleted = $sc_welcome_wizard['wizard_completed'];
        $requiredCompleted = 0;

        $sc_welcome_wizard_temp = [];
        foreach ($sc_welcome_wizard as $index => $value)
        {
            if ($index == 'total_completed' || $index == 'total_active' || $index == 'total_disabled'|| $index == 'wizard_completed'|| $index == 'required_completed' || $index == 'total_required') continue;

            if ($value == 1) {
                $completed++;

                if ( $index == 'company_info' || $index == 'capital_registration' || $index == 'admin_profile'|| $index == 'day_end_config' )
                {
                    $requiredCompleted++;
                }
            } elseif ($value == 0) {
                $active++;
            } elseif ($value == -1) {
                $disabled++;
            }

            $sc_welcome_wizard_temp[] = $index.':'.$value;
        }

        return implode(';;;', $sc_welcome_wizard_temp).";;;total_completed:$completed;;;total_active:$active;;;total_disabled:$disabled;;;wizard_completed:$wizardCompleted;;;required_completed:$requiredCompleted;;;total_required:".self::$Total_Required;

        //        dd($completed, $active, $disabled, implode(';;;', $sc_welcome_wizard_temp) . ";;;total_completed:$completed;;;total_active:$active;;;total_disabled:$disabled");
//        $sc_welcome_wizard = array_map(function ($value, $key) use ($completed, $active, $disabled) {
//            if ($key == 'total_completed' || $key == 'total_active' || $key == 'total_disabled') return '';
//            return $key.':'.$value;
//        }, array_values($sc_welcome_wizard), array_keys($sc_welcome_wizard));
    }

    public function getScWelcomeWizardStatusClass($sc_welcome_wizard, $index)
    {

        if ($sc_welcome_wizard[$index] == -1)
        {
            return 'fin-wizard__action--disabled';
        }
        if ($sc_welcome_wizard[$index] == 0)
        {
            return 'fin-wizard__action--active';
        }
        if ($sc_welcome_wizard[$index] == 1)
        {
            return 'fin-wizard__action--complete';
        }
    }



}
