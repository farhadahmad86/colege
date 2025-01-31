<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Wizard\WizardController;
use App\Models\DayEndConfigModel;
use App\Models\SystemConfigModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DayEndConfigController extends Controller
{
    public function day_end_config()
    {
        $user = Auth::user();
        $systemConfig = SystemConfigModel::where('sc_clg_id', '=', $user->user_clg_id)->first();
        $day_end_config = DayEndConfigModel::where('dec_clg_id', '=', $user->user_clg_id)->firstOrFail();
        WizardController::updateWizardInfo(['day_end_config'], []);

        return view('day_end_config', compact('day_end_config', 'systemConfig'));
    }

    public function submit_day_end_config(Request $request)
    {
        $user = Auth::user();
        $systemConfig = SystemConfigModel::where('sc_clg_id', '=', $user->user_clg_id)->first();

        $data = $this->validate($request, [
            'check_cash' => 'required',
            'check_bank' => 'required',
            'check_product' => 'required',
            'check_warehouse' => 'required',
        ]);

        $data1 = [];
        if ($systemConfig->sc_all_done == 0)
        {
            $data1 = $this->validate($request, [
                'create_trail' => 'required',
                'create_closing' => 'required',
                'create_cb_balance' => 'required',

                'create_pnl' => 'required',
                'create_balance_sheet' => 'required',
                'create_profit_distribution' => 'required',
            ]);
        }

        $data = array_merge($data, $data1);

        $day_end_config = DayEndConfigModel::where('dec_clg_id', '=', $user->user_clg_id)->firstOrFail();
        $day_end_config->dec_cash_check = $data['check_cash'];
        $day_end_config->dec_bank_check = $data['check_bank'];
        $day_end_config->dec_product_check = $data['check_product'];
        $day_end_config->dec_warehouse_check = $data['check_warehouse'];
        if ($systemConfig->sc_all_done == 0)
        {
            $day_end_config->dec_create_trial = $data['create_trail'];
            $day_end_config->dec_create_closing_stock = $data['create_closing'];
            $day_end_config->dec_create_cash_bank_closing = $data['create_cb_balance'];

            $day_end_config->dec_create_pnl = $data['create_pnl'];
            $day_end_config->dec_create_balance_sheet = $data['create_balance_sheet'];
            $day_end_config->dec_create_pnl_distribution = $data['create_profit_distribution'];
        }
        $day_end_config->dec_datetime = now();
        $day_end_config->save();

        return redirect()->back()->with('success', 'Successfully saved');
    }
}
