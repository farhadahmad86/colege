@extends('_ab.wizard.layout2')


@section('styles_get')
    <style>
        body { background-color: white; }
        .app-content {
            background-color: white;
            padding-top: 70px !important;
            margin-top: 0;
        }


        .fin-wizard {
            position: relative;
            padding: 10px;
            max-width: 1540px;
            margin: 0 auto;
        }
        .fin-wizard--head, .fin-wizard--body {}


        .progress { position: relative; }
        .progress-text {
            position: absolute;
            top: -1px;
            left: 50%;
            color: white;
            font-weight: bold;
            transform: translateX(-50%);
        }

        .fin-wizard--status {}
        .fin-wizard--status ul {
            width: 300px;
            margin: 5px auto;
            list-style: none;
            font-size: 11px;
            text-align: center;
            font-weight: bold;
        }
        .fin-wizard--status ul li {
            display: inline-block;
            padding: 1px 5px;
            min-width: 70px;
        }
        .fin-wizard--status ul li:nth-child(1) { background-color: rgb(123,226,124); }
        .fin-wizard--status ul li:nth-child(2) { background-color: rgb(123,184,226); }
        .fin-wizard--status ul li:nth-child(3) { background-color: #eaeaea; }


        .fin-wizard--body { padding-top: 10px; }
        .table-responsive {}
        .fin-wizard--body .table {}
        .fin-wizard--body .table tr { height: 55px; min-height: 50px; }
        .fin-wizard--body .table tbody tr:nth-child(2n),
        .fin-wizard--body .table tbody tr:nth-child(2n+1) {
            background-color: transparent;
        }
        .fin-wizard--body .table tr th,
        .fin-wizard--body .table tr td {
            border: 0;
        }
        .fin-wizard--body .table tr th {
            padding: 10px !important;
            min-width: 105px;
            max-width: 400px;
            /*width: 139px;*/
        }
        .fin-wizard--body .table tr td {
            text-align: center;
            min-width: 160px;
            max-width: 200px;
            /*width: 157px;*/
        }
        .fin-wizard--body .table .fin-wizard__action {
            font-size: 12px;
            width: 160px;
            height: 48px;
            font-weight: bold;
            white-space: normal;
        }
        .fin-wizard__action--complete { background-color: rgb(123,226,124); /* rgb(123,226,124), #4caf50, #388e3c */ }
        .fin-wizard__action--active { background-color: rgb(123,184,226); /* rgb(123,184,226), #03a9f4, #1976d2 */ }
        .fin-wizard__action--disabled { /*background-color: rgb(226,123,123); !* rgb(226,123,123), #f44336, #d32f2f   | #9e9e9e *!*/ }
        .fin-wizard__action--disabled:hover { cursor: not-allowed !important; }



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



        /* Testing css */
        .fin-wizard__action
        {
            font-size: 9px;
            width: 116px; /* prev: 127px; */
            height: 90px; /* prev: 100px; */
            font-weight: bold;
            white-space: normal;
            background: white;
            border: 2px solid rgb(123,226,124);
            color: green;
        }
        .fin-wizard__action:hover { box-shadow: 0 0 8px 2px rgb(123,226,124); }
        .fin-wizard--body .table tr td { min-width: 116px; padding: 16px; }
        .fin-wizard__action i { font-size: 35px; margin: 0 0 10px 0; }

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
                            <td><button type="button" id="company_info" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'company_info') }}" data-href="{{ route('company_info') }}" data-toggle="modal" data-target="#fin-wizard--modal"><i class="fa fa-building"></i><br>Company Info</button></td>
                            <td><button type="button" id="reporting_group" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'reporting_group') }}" data-href="{{ route('add_account_group') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['reporting_group'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Reporting Group</button></td>
                            <td><button type="button" id="product_reporting_group" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'product_reporting_group') }}" data-href="{{ route('product_group') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['product_reporting_group'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Product reporting Group</button></td>
                            <td><button type="button" id="add_modular_group" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'add_modular_group') }}" data-href="{{ route('add_modular_group') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['add_modular_group'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Add Modular Group</button></td>
                            <td><button type="button" id="warehouse" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'warehouse') }}" data-href="{{ route('add_warehouse') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['warehouse'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Warehouse</button></td>
{{--                            <td><button type="button" id="organization_department" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'organization_department') }}" data-href="javascript:void(0);" {{ $sc_welcome_wizard['organization_department'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Organization Depart.</button></td>--}}
                        </tr>
                        <tr>
                            <th scope="col">Employee Registration</th>
                            <td><button type="button" id="parent_account_1" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'parent_account_1') }}" data-href="{{ route('add_third_level_chart_of_account') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['parent_account_1'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Parent Account</button></td>
                            <td><button type="button" id="salary_account" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'salary_account') }}" data-href="{{ route('salary_account_registration') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['salary_account'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Salary Account</button></td>
                            <td><button type="button" id="employee" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'employee') }}" data-href="{{ route('add_employee') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['employee'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Employee</button></td>
                        </tr>
                        <tr>
                            <th scope="col">Product Registration</th>
                            <td><button type="button" id="group" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'group') }}" data-href="{{ route('add_group') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['group'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Group</button></td>
                            <td><button type="button" id="category" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'category') }}" data-href="{{ route('add_category') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['category'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Category</button></td>
                            <td><button type="button" id="main_unit" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'main_unit') }}" data-href="{{ route('add_main_unit') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['main_unit'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Main Unit</button></td>
                            <td><button type="button" id="unit" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'unit') }}" data-href="{{ route('add_unit') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['unit'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Unit</button></td>
                            <td><button type="button" id="product" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'product') }}" data-href="{{ route('add_product') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['product'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Product</button></td>
                            <td><button type="button" id="product_clubbing" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'product_clubbing') }}" data-href="{{ route('product_clubbing') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['product_clubbing'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Product Clubbing</button></td>
                            <td><button type="button" id="product_packages" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'product_packages') }}" data-href="{{ route('product_packages') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['product_packages'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Product Packages</button></td>
                            <td><button type="button" id="product_recipe" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'product_recipe') }}" data-href="{{ route('product_recipe') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['product_recipe'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Product Recipe</button></td>
                        </tr>
                        <tr>
                            <th scope="col">Service Registration</th>
                            <td><button type="button" id="service" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'service') }}" data-href="{{ route('add_services') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['service'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Service</button></td>
                        </tr>
                        <tr>
                            <th scope="col">Bank Registration</th>
                            <td><button type="button" id="bank_account" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'bank_account') }}" data-href="{{ route('bank_account_registration') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['bank_account'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Bank Account</button></td>
                            <td><button type="button" id="credit_card_machine" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'credit_card_machine') }}" data-href="{{ route('add_credit_card_machine') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['credit_card_machine'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Credit Card Machine</button></td>
                        </tr>
                        <tr>
                            <th scope="col">Party Registration</th>
                            <td><button type="button" id="region" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'region') }}" data-href="{{ route('add_region') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['region'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Region</button></td>
                            <td><button type="button" id="area" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'area') }}" data-href="{{ route('add_area') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['area'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Area</button></td>
                            <td><button type="button" id="sector" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'sector') }}" data-href="{{ route('add_sector') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['sector'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Sector</button></td>
                            <td><button type="button" id="client_registration" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'client_registration') }}" data-href="{{ route('receivables_account_registration') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['client_registration'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Client Registration</button></td>
                            <td><button type="button" id="supplier_registration" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'supplier_registration') }}" data-href="{{ route('payables_account_registration') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['supplier_registration'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Supplier Registration</button></td>
                        </tr>
                        <tr>
                            <th scope="col">Financial Registration</th>
                            <td><button type="button" id="group_account" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'group_account') }}" data-href="{{ route('add_second_level_chart_of_account') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['group_account'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Group Account</button></td>
                            <td><button type="button" id="parent_account" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'parent_account') }}" data-href="{{ route('add_third_level_chart_of_account') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['parent_account'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Parent Account</button></td>
                            <td><button type="button" id="entry_account" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'entry_account') }}" data-href="{{ route('account_registration') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['entry_account'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Entry Account</button></td>
                            <td><button type="button" id="fixed_account" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'fixed_account') }}" data-href="{{ route('default_account_list') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['fixed_account'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Fixed Account</button></td>
                            <td><button type="button" id="expense_account" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'expense_account') }}" data-href="{{ route('expense_account_registration') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['expense_account'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Expense Account</button></td>
                        </tr>
                        <tr>
                            <th scope="col">Asset Registration</th>
                            <td><button type="button" id="asset_parent_account" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'asset_parent_account') }}" data-href="{{ route('add_third_level_chart_of_account') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['asset_parent_account'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Asset Parent Account</button></td>
                            <td><button type="button" id="expense_group_account" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'expense_group_account') }}" data-href="{{ route('add_second_level_chart_of_account') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['expense_group_account'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Expense Group Account</button></td>
                            <td><button type="button" id="asset_registration" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'asset_registration') }}" data-href="{{ route('fixed_asset') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['asset_registration'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Asset Registration</button></td>
                        </tr>
                        <tr>
                            <th scope="col">Capital Registration</th>
                            <td><button type="button" id="second_head" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'second_head') }}" data-href="{{ route('add_second_level_chart_of_account') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['second_head'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Second Head</button></td>
                            <td><button type="button" id="capital_registration" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'capital_registration') }}" data-href="{{ route('capital_registration') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['capital_registration'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Capital Registration</button></td>
                        </tr>
                        <tr>
                            <th scope="col">Opening</th>
                            <td><button type="button" id="system_date" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'system_date') }}" data-href="{{ route('system_config_show_date') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['system_date'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>System Date</button></td>
                            <td><button type="button" id="opening_invoice_n_voucher_sequence" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'opening_invoice_n_voucher_sequence') }}" data-href="javascript:void(0);" {{ $sc_welcome_wizard['opening_invoice_n_voucher_sequence'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Opening Invoice & Voucher Sequence</button></td>
                            <td><button type="button" id="opening_stock" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'opening_stock') }}" data-href="{{ route('product_opening_stock') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['opening_stock'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Opening Stock</button></td>
                            <td><button type="button" id="opening_party_balance" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'opening_party_balance') }}" data-href="{{ route('account_opening_balance') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['opening_party_balance'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Opening Party Balance</button></td>
                            <td><button type="button" id="opening_trail" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'opening_trail') }}" data-href="{{ route('view_account_opening_balance') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['opening_trail'] == -1 ? ' disabled' : '' }}><i class="fa fa-building"></i><br>Opening Trail</button></td>
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












