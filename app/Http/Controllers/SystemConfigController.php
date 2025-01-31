<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Wizard\WizardController;
use App\Models\SystemConfigModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Session;

class SystemConfigController extends Controller
{

    public function index()
    {
        WizardController::updateWizardInfo(['opening_invoice_n_voucher_sequence'], ['opening_stock']);
        $systm_config = SystemConfigModel::first();

        return view('opening_invoice_voucher_sequence', compact('systm_config'));
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $rules = [
            'sc_bank_payment_voucher_number' => 'numeric',
            'sc_bank_receipt_voucher_number' => 'numeric',
            'sc_cash_payment_voucher_number' => 'numeric',
            'sc_cash_receipt_voucher_numer' => 'numeric',
            'sc_expense_payment_voucher_number' => 'numeric',
            'sc_journal_voucher_number' => 'numeric',
            'sc_purchase_invoice_number' => 'numeric',
            'sc_purchase_return_invoice_number' => 'numeric',
            'sc_purchase_st_invoice_number' => 'numeric',
            'sc_purchase_return_st_invoice_number' => 'numeric',
            'sc_salary_payment_voucher_number' => 'numeric',
            'sc_salary_slip_voucher_number' => 'numeric',
            'sc_advance_salary_voucher_number' => 'numeric',
            'sc_sale_invoice_number' => 'numeric',
            'sc_sale_return_invoice_number' => 'numeric',
            'sc_sale_tax_invoice_number' => 'numeric',
            'sc_sale_tax_return_invoice_number' => 'numeric',
            'sc_service_invoice_number' => 'numeric',
            'sc_service_tax_invoice_number' => 'numeric',
        ];
        $message = [
            'sc_bank_payment_voucher_number:numeric' => 'Only Number allowed on Bank Payment Voucher Number Field',
            'sc_bank_receipt_voucher_number:numeric' => 'Only Number allowed on Bank Receipt Voucher Number Field',
            'sc_cash_payment_voucher_number:numeric' => 'Only Number allowed on Cash Payment Voucher Number Field',
            'sc_cash_receipt_voucher_numer:numeric' => 'Only Number allowed on Cash Receipt Voucher Number Field',
            'sc_expense_payment_voucher_number:numeric' => 'Only Number allowed on Expense Payment Voucher Number Field',
            'sc_journal_voucher_number:numeric' => 'Only Number allowed on Journal Voucher Number Field',
            'sc_purchase_invoice_number:numeric' => 'Only Number allowed on Purchase Invoice Number Field',
            'sc_purchase_return_invoice_number:numeric' => 'Only Number allowed on Purchase Return Invoice Number Field',
            'sc_purchase_st_invoice_number:numeric' => 'Only Number allowed on Purchase Sale Tax Invoice Number Field',
            'sc_purchase_return_st_invoice_number:numeric' => 'Only Number allowed on Purchase Return Sale Tax Invoice Number Field',
            'sc_salary_payment_voucher_number:numeric' => 'Only Number allowed on Salary Payment Voucher Number Field',
            'sc_salary_slip_voucher_number:numeric' => 'Only Number allowed on Salary Slip Voucher Number Field',
            'sc_advance_salary_voucher_number:numeric' => 'Only Number allowed on Advance Salary Voucher  Number Field',
            'sc_sale_invoice_number:numeric' => 'Only Number allowed on Sale Invoice Number Field',
            'sc_sale_return_invoice_number:numeric' => 'Only Number allowed on Sale Return Invoice Number Field',
            'sc_sale_tax_invoice_number:numeric' => 'Only Number allowed on Sale Tax Invoice Number Field',
            'sc_sale_tax_return_invoice_number:numeric' => 'Only Number allowed on Sale Tax Return Invoice Number Field',
            'sc_service_invoice_number:numeric' => 'Only Number allowed on Service Invoice Number Field',
            'sc_service_tax_invoice_number:numeric' => 'Only Number allowed on Service Tax Invoice Number Field',
        ];
        $this->validate($request, $rules, $message);

        $system_config = new SystemConfigModel();

        if ($request->has('sc_first_date')) {
            $system_config->sc_first_date = date('Y-m-d', strtotime($request->input('sc_first_date')));
            WizardController::updateWizardInfo(['system_date'], ['opening_invoice_n_voucher_sequence']);
            $system_config->sc_first_date_added = 1;
        }

        if ($request->has('sc_bank_payment_voucher_number')) {
            $system_config->sc_bank_payment_voucher_number = $request->input('sc_bank_payment_voucher_number');
        }

        if ($request->has('sc_bank_receipt_voucher_number')) {
            $system_config->sc_bank_receipt_voucher_number = $request->input('sc_bank_receipt_voucher_number');
        }

        if ($request->has('sc_cash_payment_voucher_number')) {
            $system_config->sc_cash_payment_voucher_number = $request->input('sc_cash_payment_voucher_number');
        }

        if ($request->has('sc_cash_receipt_voucher_numer')) {
            $system_config->sc_cash_receipt_voucher_numer = $request->input('sc_cash_receipt_voucher_numer');
        }

        if ($request->has('sc_expense_payment_voucher_number')) {
            $system_config->sc_expense_payment_voucher_number = $request->input('sc_expense_payment_voucher_number');
        }

        if ($request->has('sc_journal_voucher_number')) {
            $system_config->sc_journal_voucher_number = $request->input('sc_journal_voucher_number');
        }

        if ($request->has('sc_purchase_invoice_number')) {
            $system_config->sc_purchase_invoice_number = $request->input('sc_purchase_invoice_number');
        }

        if ($request->has('sc_purchase_return_invoice_number')) {
            $system_config->sc_purchase_return_invoice_number = $request->input('sc_purchase_return_invoice_number');
        }

        if ($request->has('sc_purchase_st_invoice_number')) {
            $system_config->sc_purchase_st_invoice_number = $request->input('sc_purchase_st_invoice_number');
        }

        if ($request->has('sc_purchase_return_st_invoice_number')) {
            $system_config->sc_purchase_return_st_invoice_number = $request->input('sc_purchase_return_st_invoice_number');
        }

        if ($request->has('sc_salary_payment_voucher_number')) {
            $system_config->sc_salary_payment_voucher_number = $request->input('sc_salary_payment_voucher_number');
        }

        if ($request->has('sc_salary_slip_voucher_number')) {
            $system_config->sc_salary_slip_voucher_number = $request->input('sc_salary_slip_voucher_number');
        }

        if ($request->has('sc_advance_salary_voucher_number')) {
            $system_config->sc_advance_salary_voucher_number = $request->input('sc_advance_salary_voucher_number');
        }

        if ($request->has('sc_sale_invoice_number')) {
            $system_config->sc_sale_invoice_number = $request->input('sc_sale_invoice_number');
        }

        if ($request->has('sc_sale_return_invoice_number')) {
            $system_config->sc_sale_return_invoice_number = $request->input('sc_sale_return_invoice_number');
        }

        if ($request->has('sc_sale_tax_invoice_number')) {
            $system_config->sc_sale_tax_invoice_number = $request->input('sc_sale_tax_invoice_number');
        }

        if ($request->has('sc_sale_tax_return_invoice_number')) {
            $system_config->sc_sale_tax_return_invoice_number = $request->input('sc_sale_tax_return_invoice_number');
        }

        if ($request->has('sc_service_invoice_number')) {
            $system_config->sc_service_invoice_number = $request->input('sc_service_invoice_number');
        }

        if ($request->has('sc_service_tax_invoice_number')) {
            $system_config->sc_service_tax_invoice_number = $request->input('sc_service_tax_invoice_number');
        }

        $system_config->save();
        Session::flash('success', 'System Configuration Successfully Saved!!!.');

        return redirect()->back();

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {

        $rules = [
            'sc_bank_payment_voucher_number' => 'numeric',
            'sc_bank_receipt_voucher_number' => 'numeric',
            'sc_cash_payment_voucher_number' => 'numeric',
            'sc_cash_receipt_voucher_numer' => 'numeric',
            'sc_expense_payment_voucher_number' => 'numeric',
            'sc_journal_voucher_number' => 'numeric',
            'sc_purchase_invoice_number' => 'numeric',
            'sc_purchase_return_invoice_number' => 'numeric',
            'sc_purchase_st_invoice_number' => 'numeric',
            'sc_purchase_return_st_invoice_number' => 'numeric',
            'sc_salary_payment_voucher_number' => 'numeric',
            'sc_salary_slip_voucher_number' => 'numeric',
            'sc_advance_salary_voucher_number' => 'numeric',
            'sc_sale_invoice_number' => 'numeric',
            'sc_sale_return_invoice_number' => 'numeric',
            'sc_sale_tax_invoice_number' => 'numeric',
            'sc_sale_tax_return_invoice_number' => 'numeric',
            'sc_service_invoice_number' => 'numeric',
            'sc_service_tax_invoice_number' => 'numeric',
        ];
        $message = [
            'sc_bank_payment_voucher_number:numeric' => 'Only Number allowed on Bank Payment Voucher Number Field',
            'sc_bank_receipt_voucher_number:numeric' => 'Only Number allowed on Bank Receipt Voucher Number Field',
            'sc_cash_payment_voucher_number:numeric' => 'Only Number allowed on Cash Payment Voucher Number Field',
            'sc_cash_receipt_voucher_numer:numeric' => 'Only Number allowed on Cash Receipt Voucher Number Field',
            'sc_expense_payment_voucher_number:numeric' => 'Only Number allowed on Expense Payment Voucher Number Field',
            'sc_journal_voucher_number:numeric' => 'Only Number allowed on Journal Voucher Number Field',
            'sc_purchase_invoice_number:numeric' => 'Only Number allowed on Purchase Invoice Number Field',
            'sc_purchase_return_invoice_number:numeric' => 'Only Number allowed on Purchase Return Invoice Number Field',
            'sc_purchase_st_invoice_number:numeric' => 'Only Number allowed on Purchase Sale Tax Invoice Number Field',
            'sc_purchase_return_st_invoice_number:numeric' => 'Only Number allowed on Purchase Return Sale Tax Invoice Number Field',
            'sc_salary_payment_voucher_number:numeric' => 'Only Number allowed on Salary Payment Voucher Number Field',
            'sc_salary_slip_voucher_number:numeric' => 'Only Number allowed on Salary Slip Voucher Number Field',
            'sc_advance_salary_voucher_number:numeric' => 'Only Number allowed on Advance Salary Voucher  Number Field',
            'sc_sale_invoice_number:numeric' => 'Only Number allowed on Sale Invoice Number Field',
            'sc_sale_return_invoice_number:numeric' => 'Only Number allowed on Sale Return Invoice Number Field',
            'sc_sale_tax_invoice_number:numeric' => 'Only Number allowed on Sale Tax Invoice Number Field',
            'sc_sale_tax_return_invoice_number:numeric' => 'Only Number allowed on Sale Tax Return Invoice Number Field',
            'sc_service_invoice_number:numeric' => 'Only Number allowed on Service Invoice Number Field',
            'sc_service_tax_invoice_number:numeric' => 'Only Number allowed on Service Tax Invoice Number Field',
        ];
        $this->validate($request, $rules, $message);

        $system_config = SystemConfigModel::find($id);

        if ($request->has('sc_first_date')) {
            $system_config->sc_first_date = date('Y-m-d', strtotime($request->input('sc_first_date')));
            WizardController::updateWizardInfo(['system_date'], ['opening_invoice_n_voucher_sequence']);
            $system_config->sc_first_date_added = 1;
        }

        if ($request->has('sc_bank_payment_voucher_number')) {
            $system_config->sc_bank_payment_voucher_number = $request->input('sc_bank_payment_voucher_number');
        }

        if ($request->has('sc_bank_receipt_voucher_number')) {
            $system_config->sc_bank_receipt_voucher_number = $request->input('sc_bank_receipt_voucher_number');
        }

        if ($request->has('sc_cash_payment_voucher_number')) {
            $system_config->sc_cash_payment_voucher_number = $request->input('sc_cash_payment_voucher_number');
        }

        if ($request->has('sc_cash_receipt_voucher_numer')) {
            $system_config->sc_cash_receipt_voucher_numer = $request->input('sc_cash_receipt_voucher_numer');
        }

        if ($request->has('sc_expense_payment_voucher_number')) {
            $system_config->sc_expense_payment_voucher_number = $request->input('sc_expense_payment_voucher_number');
        }

        if ($request->has('sc_journal_voucher_number')) {
            $system_config->sc_journal_voucher_number = $request->input('sc_journal_voucher_number');
        }

        if ($request->has('sc_purchase_invoice_number')) {
            $system_config->sc_purchase_invoice_number = $request->input('sc_purchase_invoice_number');
        }

        if ($request->has('sc_purchase_return_invoice_number')) {
            $system_config->sc_purchase_return_invoice_number = $request->input('sc_purchase_return_invoice_number');
        }

        if ($request->has('sc_purchase_st_invoice_number')) {
            $system_config->sc_purchase_st_invoice_number = $request->input('sc_purchase_st_invoice_number');
        }

        if ($request->has('sc_purchase_return_st_invoice_number')) {
            $system_config->sc_purchase_return_st_invoice_number = $request->input('sc_purchase_return_st_invoice_number');
        }

        if ($request->has('sc_salary_payment_voucher_number')) {
            $system_config->sc_salary_payment_voucher_number = $request->input('sc_salary_payment_voucher_number');
        }

        if ($request->has('sc_salary_slip_voucher_number')) {
            $system_config->sc_salary_slip_voucher_number = $request->input('sc_salary_slip_voucher_number');
        }

        if ($request->has('sc_advance_salary_voucher_number')) {
            $system_config->sc_advance_salary_voucher_number = $request->input('sc_advance_salary_voucher_number');
        }

        if ($request->has('sc_sale_invoice_number')) {
            $system_config->sc_sale_invoice_number = $request->input('sc_sale_invoice_number');
        }

        if ($request->has('sc_sale_return_invoice_number')) {
            $system_config->sc_sale_return_invoice_number = $request->input('sc_sale_return_invoice_number');
        }

        if ($request->has('sc_sale_tax_invoice_number')) {
            $system_config->sc_sale_tax_invoice_number = $request->input('sc_sale_tax_invoice_number');
        }

        if ($request->has('sc_sale_tax_return_invoice_number')) {
            $system_config->sc_sale_tax_return_invoice_number = $request->input('sc_sale_tax_return_invoice_number');
        }

        if ($request->has('sc_service_invoice_number')) {
            $system_config->sc_service_invoice_number = $request->input('sc_service_invoice_number');
        }

        if ($request->has('sc_service_tax_invoice_number')) {
            $system_config->sc_service_tax_invoice_number = $request->input('sc_service_tax_invoice_number');
        }

        $system_config->update();
        Session::flash('success', 'System Configuration Successfully Save!!!.');

        return redirect()->back();

    }

    public function destroy($id)
    {
        //
    }


    public function edit_date()
    {
        $user = Auth::user();
        $system_config = SystemConfigModel::where('sc_clg_id', $user->user_clg_id)->first();

        return view('_ab.system_config_date', compact('system_config'));
    }

    public function update_date(Request $request)
    {
        $user = Auth::user();
        $system_config = SystemConfigModel::where('sc_clg_id', $user->user_clg_id)->first();
        $system_config->sc_first_date = date('Y-m-d', strtotime($request->input('sc_first_date')));
        $system_config->sc_first_date_added = 1;
        $system_config->save();

        WizardController::updateWizardInfo(['system_date'], ['opening_invoice_n_voucher_sequence']);

        Session::flash('success', 'System Configuration Date Successfully Save!!!.');
        return redirect()->back();
    }
}
