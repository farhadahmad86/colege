<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileCusExport;
use App\Http\Controllers\Wizard\WizardController;
use App\Models\AccountRegisterationModel;
use Auth;
use PDF;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DefaultAccountsController extends Controller
{
    public function default_account_list()
    {
        $heads = config('global_variables.default_account_list');
        $heads = explode(',', $heads);

        $accounts = AccountRegisterationModel::whereIn('account_uid', $heads)->orderBy('account_uid', 'ASC')->get();

        // WizardController::updateWizardInfo(['fixed_account'], []);

        return view('default_account_list', compact('accounts'));
    }

    public function default_account_list_view(Request $request, $array = null, $str = null)
    {
        $heads = config('global_variables.default_account_list');
        $heads = explode(',', $heads);

        $prnt_page_dir = 'print.default_account_list_view.default_account_list_view';
        $pge_title = 'Default Account List';
        $srch_fltr = [];

        $datas = AccountRegisterationModel::whereIn('account_uid', $heads)->orderBy('account_uid', 'ASC')->get();


        if (isset($request->str) && !empty($request->str)) {
            $type = (isset($request->str)) ? $request->str : '';

            $footer = view('print._partials.pdf_footer')->render();
            $header = view('print._partials.pdf_header', compact('pge_title', 'srch_fltr'))->render();
            $options = [
                'footer-html' => $footer,
                'header-html' => $header,
            ];

            $pdf = PDF::loadView($prnt_page_dir, compact('datas', 'type', 'pge_title'));
            $pdf->setOptions($options);


            if ($type === 'pdf') {
                return $pdf->stream($pge_title . '_x.pdf');
            } else if ($type === 'download_pdf') {
                return $pdf->download($pge_title . '_x.pdf');
            } else if ($type === 'download_excel') {
                return Excel::download(new ExcelFileCusExport($datas, $srch_fltr, $type, $prnt_page_dir, $pge_title), $pge_title . '_x.xlsx');
            }

        } else {
            return view('default_account_list_view', compact('datas'));
        }
    }

    public function update_default_account_list(Request $request)
    {
        $this->account_validation($request);
        $account = AccountRegisterationModel::where('account_id', $request->id)->first();

        $account = $this->AssignAccountValues($request, $account);

        $account->save();

        $user = Auth::User();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Account Name With Unique Id: ' . $account->account_uid . ' And Name: ' . $account->account_name);

//        WizardController::updateWizardInfo(['fixed_account'], ['expense_account']);

        return redirect('default_account_list')->with('success', 'Successfully Saved');
    }

    public function account_validation($request)
    {
        return $this->validate($request, [
            'name' => 'required|unique:financials_accounts,account_name,' . $request->id . ',account_id,account_parent_code,' . $request->head_code,
        ]);

    }

    protected function AssignAccountValues($request, $account)
    {
        $account->account_name = $request->name;
        return $account;
    }

    public function set_default_account()
    {
        $user = Auth::User();

        ///////////////////////////////////////////////////////////// Account Name Change ////////////////////////////////////////////////////////////////////

        $account = AccountRegisterationModel::where('account_uid', config('global_variables.cash_in_hand'))->first();

        $account->account_name = config('global_variables.cash_account_name');

        $account->save();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Account Name To Default With Unique Id: ' . $account->account_uid . ' And Name: ' .
            $account->account_name);


        ///////////////////////////////////////////////////////////// Account Name Change ////////////////////////////////////////////////////////////////////

        $account = AccountRegisterationModel::where('account_uid', config('global_variables.stock_in_hand'))->first();

        $account->account_name = config('global_variables.stock_account_name');

        $account->save();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Account Name To Default With Unique Id: ' . $account->account_uid . ' And Name: ' .
            $account->account_name);

        ///////////////////////////////////////////////////////////// Account Name Change ////////////////////////////////////////////////////////////////////

        $account = AccountRegisterationModel::where('account_uid', config('global_variables.purchase_sale_tax'))->first();

        $account->account_name = config('global_variables.purchase_sale_tax_account_name');

        $account->save();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Account Name To Default With Unique Id: ' . $account->account_uid . ' And Name: ' .
            $account->account_name);

        ///////////////////////////////////////////////////////////// Account Name Change ////////////////////////////////////////////////////////////////////

        $account = AccountRegisterationModel::where('account_uid', config('global_variables.walk_in_customer'))->first();

        $account->account_name = config('global_variables.walk_in_customer_account_name');
        $account->save();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Account Name To Default With Unique Id: ' . $account->account_uid . ' And Name: ' .
            $account->account_name);

        ///////////////////////////////////////////////////////////// Account Name Change ////////////////////////////////////////////////////////////////////

        $account = AccountRegisterationModel::where('account_uid', config('global_variables.other_asset_suspense_account'))->first();

        $account->account_name = config('global_variables.other_asset_suspense_account_name');

        $account->save();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Account Name To Default With Unique Id: ' . $account->account_uid . ' And Name: ' .
            $account->account_name);

        ///////////////////////////////////////////////////////////// Account Name Change ////////////////////////////////////////////////////////////////////

        $account = AccountRegisterationModel::where('account_uid', config('global_variables.sales_tax_payable_account'))->first();

        $account->account_name = config('global_variables.sale_sale_tax_account_name');

        $account->save();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Account Name To Default With Unique Id: ' . $account->account_uid . ' And Name: ' .
            $account->account_name);

        ///////////////////////////////////////////////////////////// Account Name Change ////////////////////////////////////////////////////////////////////

        $account = AccountRegisterationModel::where('account_uid', config('global_variables.service_sale_tax_account'))->first();

        $account->account_name = config('global_variables.service_tax_account_name');

        $account->save();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Account Name To Default With Unique Id: ' . $account->account_uid . ' And Name: ' .
            $account->account_name);

///////////////////////////////////////////////////////////// Account Name Change ////////////////////////////////////////////////////////////////////

        $account = AccountRegisterationModel::where('account_uid', config('global_variables.purchaser_account'))->first();

        $account->account_name = config('global_variables.purchaser_account_name');

        $account->save();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Account Name To Default With Unique Id: ' . $account->account_uid . ' And Name: ' .
            $account->account_name);

///////////////////////////////////////////////////////////// Account Name Change ////////////////////////////////////////////////////////////////////

        $account = AccountRegisterationModel::where('account_uid', config('global_variables.other_liability_suspense_account'))->first();

        $account->account_name = config('global_variables.other_liability_suspense_account_name');

        $account->save();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Account Name To Default With Unique Id: ' . $account->account_uid . ' And Name: ' .
            $account->account_name);

        ///////////////////////////////////////////////////////////// Account Name Change ////////////////////////////////////////////////////////////////////

        $account = AccountRegisterationModel::where('account_uid', config('global_variables.sale_account'))->first();

        $account->account_name = config('global_variables.sales_account_name');

        $account->save();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Account Name To Default With Unique Id: ' . $account->account_uid . ' And Name: ' .
            $account->account_name);

        ///////////////////////////////////////////////////////////// Account Name Change ////////////////////////////////////////////////////////////////////

        $account = AccountRegisterationModel::where('account_uid', config('global_variables.sales_returns_and_allowances'))->first();

        $account->account_name = config('global_variables.sales_returns_and_allowances_account_name');

        $account->save();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Account Name To Default With Unique Id: ' . $account->account_uid . ' And Name: ' .
            $account->account_name);

        ///////////////////////////////////////////////////////////// Account Name Change ////////////////////////////////////////////////////////////////////

        $account = AccountRegisterationModel::where('account_uid', config('global_variables.service_account'))->first();

        $account->account_name = config('global_variables.service_account_name');

        $account->save();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Account Name To Default With Unique Id: ' . $account->account_uid . ' And Name: ' .
            $account->account_name);

        ///////////////////////////////////////////////////////////// Account Name Change ////////////////////////////////////////////////////////////////////

        $account = AccountRegisterationModel::where('account_uid', config('global_variables.sale_margin_account'))->first();

        $account->account_name = config('global_variables.sales_margin_account_name');

        $account->save();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Account Name To Default With Unique Id: ' . $account->account_uid . ' And Name: ' .
            $account->account_name);

        ///////////////////////////////////////////////////////////// Account Name Change ////////////////////////////////////////////////////////////////////

        $account = AccountRegisterationModel::where('account_uid', config('global_variables.product_loss_recover_account'))->first();

        $account->account_name = config('global_variables.product_loss_recover_account_name');

        $account->save();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Account Name To Default With Unique Id: ' . $account->account_uid . ' And Name: ' .
            $account->account_name);

        ///////////////////////////////////////////////////////////// Account Name Change ////////////////////////////////////////////////////////////////////

        $account = AccountRegisterationModel::where('account_uid', config('global_variables.bonus_allocation_deallocation'))->first();

        $account->account_name = config('global_variables.bonus_allocation_deallocation_account_name');

        $account->save();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Account Name To Default With Unique Id: ' . $account->account_uid . ' And Name: ' .
            $account->account_name);

        ///////////////////////////////////////////////////////////// Account Name Change ////////////////////////////////////////////////////////////////////

        $account = AccountRegisterationModel::where('account_uid', config('global_variables.claim_issue'))->first();

        $account->account_name = config('global_variables.claim_issue_account_name');

        $account->save();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Account Name To Default With Unique Id: ' . $account->account_uid . ' And Name: ' .
            $account->account_name);

        ///////////////////////////////////////////////////////////// Account Name Change ////////////////////////////////////////////////////////////////////

        $account = AccountRegisterationModel::where('account_uid', config('global_variables.claim_received'))->first();

        $account->account_name = config('global_variables.claim_received_account_name');

        $account->save();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Account Name To Default With Unique Id: ' . $account->account_uid . ' And Name: ' .
            $account->account_name);


        ///////////////////////////////////////////////////////////// Account Name Change ////////////////////////////////////////////////////////////////////

        $account = AccountRegisterationModel::where('account_uid', config('global_variables.purchase_account'))->first();

        $account->account_name = config('global_variables.purchase_account_name');

        $account->save();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Account Name To Default With Unique Id: ' . $account->account_uid . ' And Name: ' .
            $account->account_name);

        ///////////////////////////////////////////////////////////// Account Name Change ////////////////////////////////////////////////////////////////////

        $account = AccountRegisterationModel::where('account_uid', config('global_variables.purchase_return_and_allowances'))->first();

        $account->account_name = config('global_variables.purchase_return_and_allowances_account_name');

        $account->save();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Account Name To Default With Unique Id: ' . $account->account_uid . ' And Name: ' .
            $account->account_name);

        ///////////////////////////////////////////////////////////// Account Name Change ////////////////////////////////////////////////////////////////////

        $account = AccountRegisterationModel::where('account_uid', config('global_variables.round_off_discount_account'))->first();

        $account->account_name = config('global_variables.round_off_discount_account_name');

        $account->save();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Account Name To Default With Unique Id: ' . $account->account_uid . ' And Name: ' .
            $account->account_name);

        ///////////////////////////////////////////////////////////// Account Name Change ////////////////////////////////////////////////////////////////////

        $account = AccountRegisterationModel::where('account_uid', config('global_variables.cash_discount_account'))->first();

        $account->account_name = config('global_variables.cash_discount_account_name');

        $account->save();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Account Name To Default With Unique Id: ' . $account->account_uid . ' And Name: ' .
            $account->account_name);

        ///////////////////////////////////////////////////////////// Account Name Change ////////////////////////////////////////////////////////////////////

        $account = AccountRegisterationModel::where('account_uid', config('global_variables.service_discount_account'))->first();

        $account->account_name = config('global_variables.service_discount_account_name');

        $account->save();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Account Name To Default With Unique Id: ' . $account->account_uid . ' And Name: ' .
            $account->account_name);

        ///////////////////////////////////////////////////////////// Account Name Change ////////////////////////////////////////////////////////////////////

        $account = AccountRegisterationModel::where('account_uid', config('global_variables.product_discount_account'))->first();

        $account->account_name = config('global_variables.product_discount_account_name');

        $account->save();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Account Name To Default With Unique Id: ' . $account->account_uid . ' And Name: ' .
            $account->account_name);

        ///////////////////////////////////////////////////////////// Account Name Change ////////////////////////////////////////////////////////////////////

        $account = AccountRegisterationModel::where('account_uid', config('global_variables.retailer_discount_account'))->first();

        $account->account_name = config('global_variables.retailer_discount_account_name');

        $account->save();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Account Name To Default With Unique Id: ' . $account->account_uid . ' And Name: ' .
            $account->account_name);

        ///////////////////////////////////////////////////////////// Account Name Change ////////////////////////////////////////////////////////////////////

        $account = AccountRegisterationModel::where('account_uid', config('global_variables.wholesaler_discount_account'))->first();

        $account->account_name = config('global_variables.wholesaler_discount_account_name');

        $account->save();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Account Name To Default With Unique Id: ' . $account->account_uid . ' And Name: ' .
            $account->account_name);

        ///////////////////////////////////////////////////////////// Account Name Change ////////////////////////////////////////////////////////////////////

        $account = AccountRegisterationModel::where('account_uid', config('global_variables.loyalty_card_discount_account'))->first();

        $account->account_name = config('global_variables.loyalty_discount_account_name');

        $account->save();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Account Name To Default With Unique Id: ' . $account->account_uid . ' And Name: ' .
            $account->account_name);

        //////////////////////////////////////////////////////////// Account Name Change ////////////////////////////////////////////////////////////////////

        $account = AccountRegisterationModel::where('account_uid', config('global_variables.capital_undistributed_profit_and_loss'))->first();

        $account->account_name = config('global_variables.capital_undistributed_profit_and_loss_account_name');

        $account->save();

        $this->enter_log('User_id: ' . $user->user_id . ' With Name: ' . $user->user_name . ' Update Account Name To Default With Unique Id: ' . $account->account_uid . ' And Name: ' .
            $account->account_name);


        return redirect('default_account_list')->with('success', 'Successfully Saved');
    }


}
