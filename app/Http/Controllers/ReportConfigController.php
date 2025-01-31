<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Wizard\WizardController;
use App\Models\DayEndConfigModel;
use App\Models\ReportConfigModel;
use App\Models\SystemConfigModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;

class ReportConfigController extends Controller
{
    public function report_config()
    {
        $user = Auth::User();
        $systemConfig = SystemConfigModel::where('sc_clg_id', '=', $user->user_clg_id)->where('sc_id', '=', 1)->first();
        $report_config = ReportConfigModel::where('rc_clg_id', '=', $user->user_clg_id)->where('rc_id', '=', 1)->firstOrFail();
        WizardController::updateWizardInfo(['report_config'], []);

        return view('report_config', compact('report_config', 'systemConfig'));
    }
    public function submit_report_config(Request $request)
    {
        $user = Auth::User();
        $systemConfig = SystemConfigModel::where('sc_clg_id', '=', $user->user_clg_id)->where('sc_id', '=', 1)->first();

        $data = $this->validate($request, [
            'check_invoice' => 'required',
            'check_invoice_party' => 'required',
            'check_detail_remarks' => 'required',
                //            'check_product' => 'required',
                //            'check_warehouse' => 'required',
                        ]);

        $data1 = [];
                //        if ($systemConfig->sc_all_done == 0)
                //        {
                //            $data1 = $this->validate($request, [
                //                'create_trail' => 'required',
                //                'create_closing' => 'required',
                //                'create_cb_balance' => 'required',
                //
                //                'create_pnl' => 'required',
                //                'create_balance_sheet' => 'required',
                //                'create_profit_distribution' => 'required',
                //            ]);
                //        }

        $data = array_merge($data, $data1);

        $report_config = ReportConfigModel::where('rc_clg_id', '=', $user->user_clg_id)->where('rc_id', '=', 1)->firstOrFail();
        $report_config->rc_invoice = $data['check_invoice'];
        $report_config->rc_invoice_party = $data['check_invoice_party'];
        $report_config->rc_detail_remarks = $data['check_detail_remarks'];
                    //        $report_config->dec_product_check = $data['check_product'];
                //        $report_config->dec_warehouse_check = $data['check_warehouse'];

        $report_config->rc_updated_datetime = now();
        $report_config->rc_user_id = $user->user_id;
        $report_config->rc_clg_id = $user->user_clg_id;
        $report_config->save();

        return redirect()->back()->with('success', 'Successfully saved');
    }
    public function extra_lecture_amount_list()
    {
        $user = Auth::User();
        $datas = ReportConfigModel::where('rc_clg_id', '=', $user->user_clg_id)->where('rc_id', '=', 1)->firstOrFail();
        // dd($datas);

        return view('collegeViews.Extra_amout.extra_amount_list', compact('datas'));
    }
    public function edit_extra_amount(Request $request)
    {
        // $request->all();
        $user = Auth::User();
        $datas = ReportConfigModel::where('rc_clg_id', '=', $user->user_clg_id)->where('rc_id', '=', 1)->firstOrFail();
        // dd($datas);

        return view('collegeViews.Extra_amout.edit_extra_amount', compact('datas','request'));
    }
    public function update_extra_amount(Request $request)
    {
        // $request->all();
        $user = Auth::user();

        DB::transaction(function () use ($request, $user) {

            $validated = $request->validate([
                // 'degree_name' => ['required', 'string', 'unique:degrees,degree_name,' . $request->degree_id . ',degree_id,degree_clg_id,' . $user->user_clg_id],
                // 'degree_name' => ['required', 'string', 'unique:degrees,degree_name,' . $degree->degree_id . ',degree_id'],
                // 'degree_name' => ['required', 'string', 'unique:degrees,degree_name,' . $request->degree_id . ',degree_id' . ',degree_clg_id,' . $user->user_clg_id],
            ]);
            $Update_degree = ReportConfigModel::find($request->rc_id);
            $Update_degree->rc_extra_lecture_amount = $request->extra_amount;
            $Update_degree->save();
        });
        return redirect()->route('extra_amount_list')->with('success' . 'Updated Successfully!');
}
}
