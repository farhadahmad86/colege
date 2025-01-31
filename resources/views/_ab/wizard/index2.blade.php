@extends('_ab.wizard.layout2')


@section('style')
    <style>
        body,
        main {
            padding: 0 !important;
            margin: 0 !important;
            background: white;
        }
        .fin-wizard {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            padding: 40px 50px;
            background: white;
        }
        .fin-wizard--head {
            padding: 0 20px 5px;
        }
        .fin-wizard--body {
            padding: 20px;
        }

        .progress,
        .table-responsive {
            max-width: 1540px;
            margin: 0 auto;
        }
        .progress-text {
            position: absolute;
            top: 39px;
            left: 50%;
            color: white;
            font-weight: bold;
            transform: translateX(-50%);
        }


        .fin-wizard--body {
            width: 100%;
            height: 610px;
        }

        .table-responsive {
            overflow: auto;
        }

        .fin-wizard--body .table {
            width: unset;
            height: 606px;
        }
        .fin-wizard--body .table tr {
            min-height: 50px;
        }
        .fin-wizard--body .table tbody tr:nth-child(2n),
        .fin-wizard--body .table tbody tr:nth-child(2n+1) {
            background-color: transparent;
        }

        .fin-wizard--body .table tr {
            height: 55px;
        }
        .fin-wizard--body .table tr th,
        .fin-wizard--body .table tr td {
            border: 0;
        }
        .fin-wizard--body .table tr th {
            padding: 10px !important;
            min-width: 139px;
            max-width: 400px;
            /*width: 139px;*/
        }
        .fin-wizard--body .table tr td {
            text-align: center;
            min-width: 157px;
            max-width: 200px;
            /*width: 157px;*/
        }

        .fin-wizard--body .table .fin-wizard__action {
            font-size: 12px;
            width: 140px;
            height: 48px;
            font-weight: bold;
            white-space: normal;
        }

        .fin-wizard__action {
            font-size: 12px;
            width: 140px;
            height: 48px;
            font-weight: bold;
            white-space: normal;
        }
        .fin-wizard__action--complete {
            background-color: rgb(123,226,124); /* rgb(123,226,124), #4caf50, #388e3c */
        }
        .fin-wizard__action--active {
            background-color: rgb(123,184,226); /* rgb(123,184,226), #03a9f4, #1976d2 */
        }
        .fin-wizard__action--disabled {
            /*background-color: rgb(226,123,123); !* rgb(226,123,123), #f44336, #d32f2f   | #9e9e9e *!*/
        }
        .fin-wizard__action--disabled:hover {
            cursor: not-allowed !important;
        }







        .modal-dialog {
            width: 100%;
            height: 100%;
            margin: 0;
            max-width: 100%;
        }
        .modal-content {
            width: 100%;
            height: 100%;
        }
        .modal-header,
        .modal-footer {
            border: unset;
            background-color: #dcdcdc;
            padding: 10px 20px;
        }
        .modal-body {
            overflow: unset;
        }

        .fin-wizard--status {
            max-width: 1540px;
            margin: 0 auto;
        }

        .fin-wizard--status ul {
            width: 300px;
            margin: 8px auto 0;
            list-style: none;
            font-size: 12px;
            text-align: center;
        }

        .fin-wizard--status ul li {
            display: inline-block;
            padding: 1px 5px;
            width: 68px;
        }

        .fin-wizard--status ul li:nth-child(1) {
            background-color: rgb(123,226,124);
        }
        .fin-wizard--status ul li:nth-child(2) {
            background-color: rgb(123,184,226);
        }
        .fin-wizard--status ul li:nth-child(3) {
            background-color: #F0F0F0;
        }




        .systm_cnfg_lst_dscrption {
            display: block;
            position: relative;
            margin: 20px auto;
            width: 750px;
            padding: 20px;
            background-color: #ececec;
        }
        .systm_cnfg_lst_dscrption h6 {
            position: relative;
            font-size: 15px;
            line-height: 15px;
            margin: 0 0 10px 0;
        }



        .fin-wizard__close {
            position: absolute;
            top: 0;
            right: 0;
            display: none;
        }
        .fin-wizard__close--action {
            width: 50px;
            height: 50px;
            padding: 10px;
            font-size: 45px;
            cursor: pointer;
            line-height: 0;
            border: unset;
            background: transparent;
        }







        /*popup icon*/
        .fin-wizard__action .popup_icon {
            /*position: absolute;top: 6px;right: 9px;width: 18px;height: 18px;*/
            position: absolute;
            top: 6px;
            right: 8px;
            width: 18px;
            height: 18px;
            margin: 0;
            padding: 0;
        }
        .fin-wizard__action .popup_icon i { padding: 0; margin: 0; font-size: 11px; vertical-align: unset; }
        .fin-wizard__action:hover .popup_icon,
        .fin-wizard__action:focus .popup_icon { top: 0; right: -1px; }
    </style>
@stop


@section('content')
    @php
        $sc_welcome_wizard = $systemConfig->sc_welcome_wizard;
        $perActionProgress = 100 / $systemConfig->getTotalWizardActions();
        $completedProgress = $sc_welcome_wizard['total_completed'] * $perActionProgress;
        $activeProgress = $sc_welcome_wizard['total_active'] * $perActionProgress;
        $activeProgressTotal = $activeProgress + $completedProgress;
    @endphp

    <div class="fin-wizard">

        <div class="fin-wizard__logout" style="position: absolute;top: 2px;left: 2px;">
            <a class="btn btn-danger btn-sm" href={{route("logout")}}><i class="fa fa-sign-out" aria-hidden="true"></i> Log Out</a>
        </div>
        <div class="fin-wizard__close" style="display: {{ $sc_welcome_wizard['wizard_completed'] == 1 ? 'block' : 'none' }}">
            <button type="button" class="fin-wizard__close--action" onclick="window.location = '{{ route('home') }}';">&times;</button>
        </div>

        <div class="fin-wizard--head">
            <div class="fin-wizard--progress">
                <div class="progress">
                    <div id="progress-bar-completed" class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar"
                         aria-valuenow="{{ $completedProgress }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $completedProgress }}%">
                    </div>
                    <div id="progress-bar-active" class="progress-bar bg-info progress-bar-striped progress-bar-animated" role="progressbar"
                         aria-valuenow="{{ $activeProgressTotal }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $activeProgress }}%">
                    </div>
                    <span class="progress-text">{{ round($completedProgress, 0) }}% Complete : {{ round($activeProgressTotal, 0) }}% Active</span>
                </div>
            </div>

            <div class="fin-wizard--status">
                <ul>
                    <li>Completed</li>
                    <li>Active</li>
                    <li>Disabled</li>
                </ul>
            </div>
        </div>

        <div class="fin-wizard--body">

            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <th scope="col">General Information</th>
                            <td><button type="button" id="company_info" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'company_info') }}" data-href="{{ route('company_info') }}" data-toggle="modal" data-target="#fin-wizard--modal"><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Company Info</button></td>
                            <td><button type="button" id="reporting_group" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'reporting_group') }}" data-href="{{ route('add_account_group') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['reporting_group'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Reporting Group</button></td>
                            {{-- <td><button type="button" id="product_reporting_group" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'product_reporting_group') }}" data-href="{{ route('product_group') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['product_reporting_group'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Product reporting Group</button></td> --}}
                            <td><button type="button" id="add_modular_group" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'add_modular_group') }}" data-href="{{ route('add_modular_group') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['add_modular_group'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Add Modular Group</button></td>
                            {{-- <td><button type="button" id="warehouse" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'warehouse') }}" data-href="{{ route('add_warehouse') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['warehouse'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Warehouse</button></td> --}}
{{--                            <td><button type="button" id="organization_department" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'organization_department') }}" data-href="javascript:void(0);" {{ $sc_welcome_wizard['organization_department'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-inf></i></div> Organization Depart.</button></td>--}}
                        </tr>
                        <tr>
                            <th scope="col">Employee Registration</th>
                            <td><button type="button" id="parent_account_1" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'parent_account_1') }}" data-href="{{ route('add_third_level_chart_of_account') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['parent_account_1'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Parent Account</button></td>
                            <td><button type="button" id="salary_account" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'salary_account') }}" data-href="{{ route('salary_account_registration') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['salary_account'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Salary Account</button></td>
                            <td><button type="button" id="employee" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'employee') }}" data-href="{{ route('add_employee') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['employee'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Employee</button></td>
                        </tr>
                        {{-- <tr>
                            <th scope="col">Product Registration</th>
                            <td><button type="button" id="group" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'group') }}" data-href="{{ route('add_group') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['group'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Group</button></td>
                            <td><button type="button" id="category" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'category') }}" data-href="{{ route('add_category') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['category'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Category</button></td>
                            <td><button type="button" id="main_unit" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'main_unit') }}" data-href="{{ route('add_main_unit') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['main_unit'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Main Unit</button></td>
                            <td><button type="button" id="unit" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'unit') }}" data-href="{{ route('add_unit') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['unit'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Unit</button></td>
                            <td><button type="button" id="product" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'product') }}" data-href="{{ route('add_product') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['product'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Product</button></td>
                            <td><button type="button" id="product_clubbing" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'product_clubbing') }}" data-href="{{ route('product_clubbing') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['product_clubbing'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Product Clubbing</button></td>
                            <td><button type="button" id="product_packages" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'product_packages') }}" data-href="{{ route('product_packages') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['product_packages'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Product Packages</button></td>
                            <td><button type="button" id="product_recipe" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'product_recipe') }}" data-href="{{ route('product_recipe') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['product_recipe'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Product Recipe</button></td>
                        </tr> --}}
                        <tr>
                            <th scope="col">Service Registration</th>
                            {{-- <td><button type="button" id="service" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'service') }}" data-href="{{ route('add_services') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['service'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Service</button></td> --}}
                        </tr>
                        <tr>
                            <th scope="col">Bank Registration</th>
                            <td><button type="button" id="bank_account" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'bank_account') }}" data-href="{{ route('bank_account_registration') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['bank_account'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Bank Account</button></td>
                            <td><button type="button" id="credit_card_machine" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'credit_card_machine') }}" data-href="{{ route('add_credit_card_machine') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['credit_card_machine'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Credit Card Machine</button></td>
                        </tr>
                        <tr>
                            <th scope="col">Party Registration</th>
                            <td><button type="button" id="region" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'region') }}" data-href="{{ route('add_region') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['region'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Region</button></td>
                            <td><button type="button" id="area" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'area') }}" data-href="{{ route('add_area') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['area'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Area</button></td>
                            <td><button type="button" id="sector" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'sector') }}" data-href="{{ route('add_sector') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['sector'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Sector</button></td>
                            <td><button type="button" id="client_registration" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'client_registration') }}" data-href="{{ route('receivables_account_registration') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['client_registration'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Client Registration</button></td>
                            <td><button type="button" id="supplier_registration" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'supplier_registration') }}" data-href="{{ route('payables_account_registration') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['supplier_registration'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Supplier Registration</button></td>
                        </tr>
                        <tr>
                            <th scope="col">Financial Registration</th>
                            <td><button type="button" id="group_account" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'group_account') }}" data-href="{{ route('add_second_level_chart_of_account') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['group_account'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Group Account</button></td>
                            <td><button type="button" id="parent_account" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'parent_account') }}" data-href="{{ route('add_third_level_chart_of_account') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['parent_account'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Parent Account</button></td>
                            <td><button type="button" id="entry_account" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'entry_account') }}" data-href="{{ route('account_registration') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['entry_account'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Entry Account</button></td>
                            <td><button type="button" id="fixed_account" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'fixed_account') }}" data-href="{{ route('default_account_list') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['fixed_account'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Fixed Account</button></td>
                            <td><button type="button" id="expense_account" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'expense_account') }}" data-href="{{ route('expense_account_registration') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['expense_account'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Expense Account</button></td>
                        </tr>
                        <tr>
                            <th scope="col">Asset Registration</th>
                            <td><button type="button" id="asset_parent_account" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'asset_parent_account') }}" data-href="{{ route('add_third_level_chart_of_account') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['asset_parent_account'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Asset Parent Account</button></td>
                            <td><button type="button" id="expense_group_account" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'expense_group_account') }}" data-href="{{ route('add_second_level_chart_of_account') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['expense_group_account'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Expense Group Account</button></td>
                            <td><button type="button" id="asset_registration" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'asset_registration') }}" data-href="{{ route('fixed_asset') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['asset_registration'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Asset Registration</button></td>
                        </tr>
                        <tr>
                            <th scope="col">Capital Registration</th>
                            <td><button type="button" id="second_head" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'second_head') }}" data-href="{{ route('add_second_level_chart_of_account') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['second_head'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Second Head</button></td>
                            <td><button type="button" id="capital_registration" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'capital_registration') }}" data-href="{{ route('capital_registration') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['capital_registration'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Capital Registration</button></td>
                        </tr>
                        <tr>
                            <th scope="col">Opening</th>
                            <td><button type="button" id="system_date" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'system_date') }}" data-href="{{ route('system_config_show_date') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['system_date'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> System Date</button></td>
                            <td><button type="button" id="opening_invoice_n_voucher_sequence" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'opening_invoice_n_voucher_sequence') }}" data-href="{{ route('opening_invoice_voucher_sequence') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['opening_invoice_n_voucher_sequence'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Opening Invoice & Voucher Sequence</button></td>
                            {{-- <td><button type="button" id="opening_stock" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'opening_stock') }}" data-href="{{ route('product_opening_stock') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['opening_stock'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Opening Stock</button></td> --}}
                            <td><button type="button" id="opening_party_balance" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'opening_party_balance') }}" data-href="{{ route('account_opening_balance') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['opening_party_balance'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Opening Party Balance</button></td>
                            <td><button type="button" id="opening_trail" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'opening_trail') }}" data-href="{{ route('view_account_opening_balance') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['opening_trail'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> Opening Trail</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

        <div class="fin-wizard--foot">
            <div class="modal fade" id="fin-wizard--modal" tabindex="-1" role="dialog" aria-labelledby="fin-wizard--modal--label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="fin-wizard--modal--label">Company Info</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body p-0">
                            <iframe id="fin-wizard--modal--frame" src='about:blank' width="100%" height="100%" style="border:none;"></iframe>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@stop


@section('script')

    <script>
        $(document).ready(function () {

            $('.popup_icon').tooltip();

            $('.fin-wizard__action--disabled').attr('disabled', true);

            var form_heading = '';
            var form_location = '';
            $('.fin-wizard__action').on('click', function (e) {
                e.preventDefault();
                form_heading = $(this).text();
                form_location = $(this).data('href');
            });
            $('#fin-wizard--modal').on('show.bs.modal', function (e) {
                $('#fin-wizard--modal--label').text(form_heading);

                var iframe = $('#' + $(this).attr('id') + ' iframe');
                iframe.attr("src", form_location);
                iframe.on("load", function() {
                    iframe.contents().find("body div.header").remove();
                    iframe.contents().find("body div.left-side-bar").remove();
                    iframe.contents().find("body .main-container div#ftr").remove();
                    iframe.contents().find("body .main-container").css('padding-top', '20px');
                    iframe.contents().find("body #main_col .form_manage").css('margin', '0');
                });
            });
            $('#fin-wizard--modal').on('hide.bs.modal', function (e) {
                var iframe = $('#' + $(this).attr('id') + ' iframe');
                iframe.attr("src", "about:blank");
                iframe = null;

                form_heading = '';
                form_location = '';

                ajaxGetWizardInfo();
            });

            function ajaxGetWizardInfo() {
                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                jQuery.ajax({

                    url: '{{ route('ajax-get-wizard-info') }}',
                    type: 'get',
                    cache: false,
                    dataType: 'json',
                    beforeSend: function () {
                        console.log('ajax report before');
                    },
                    success: function (data) {
                        console.log('response report:', data);
                        if (data['result'] === true)
                        {
                            $.each(data['data']['sc_welcome_wizard'], function (key, value) {

                                if (value == 1) {
                                    $('#'+key).removeClass("fin-wizard__action--active").removeClass("fin-wizard__action--disabled").addClass("fin-wizard__action--complete").attr('disabled', false);
                                } else if (value == 0) {
                                    $('#'+key).removeClass("fin-wizard__action--complete").removeClass("fin-wizard__action--disabled").addClass("fin-wizard__action--active").attr('disabled', false);
                                } else if (value == -1) {
                                    $('#'+key).removeClass("fin-wizard__action--active").removeClass("fin-wizard__action--complete").addClass("fin-wizard__action--disabled").attr('disabled', true);
                                }
                            });

                            var completedProgress = data['data']['sc_welcome_wizard']['total_completed'] * {{ $perActionProgress }};
                            var activeProgress = data['data']['sc_welcome_wizard']['total_active'] * {{ $perActionProgress }};
                            var activeProgressTotal = activeProgress + completedProgress;
                            console.log('completedProgress: '+completedProgress, 'activeProgressTotal: '+activeProgressTotal, 'activeProgress: '+activeProgress);
                            $('.fin-wizard--progress #progress-bar-completed').css('width', completedProgress+'%');
                            $('.fin-wizard--progress #progress-bar-active').css('width', activeProgress+'%');
                            $('.fin-wizard--progress .progress-text').html('').html(completedProgress.toFixed(0) +'% Completed : ' + activeProgressTotal.toFixed(0) + '% Active');

                            if (data['data']['sc_welcome_wizard']['wizard_completed'] == 1)
                            {
                                $('.fin-wizard__close').css('display', 'block');
                            }
                        }
                    },
                    error: function (xhr, textStatus, errorThrown, jqXHR) {
                        console.log(xhr, textStatus, errorThrown, jqXHR);
                    },
                    complete: function () {
                        console.log('ajax report Complete');
                    }
                });
            }

        });



        /*
        var app = $("#companyInfoModalFrame").contents().find("#app").html();
        $("#companyInfoModalFrame").contents().find("body").html('');
        $("#companyInfoModalFrame").contents().find("body").html(
            $('<div id="app">'+ app +'</div>')
        );


        var app = $(this).contents().find("#app").html();
        $(this).contents().find("body").html(
            $('<div id="app">'+ app +'</div>')
        );
        */
    </script>

@stop












