{{--@extends('_ab.wizard.layout')--}}
@extends('extend_index')

@section('styles_get')
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" crossorigin="anonymous">
    <style>
        body {
            background-color: white;
        }

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

        .fin-wizard--head, .fin-wizard--body {
        }


        .progress {
            position: relative;
        }

        .progress-text {
            position: absolute;
            top: -1px;
            left: 50%;
            color: white;
            font-weight: bold;
            transform: translateX(-50%);
        }

        .fin-wizard--status {
        }

        .fin-wizard--status ul {
            width: auto;
            margin: 10px auto;
            list-style: none;
            font-size: 11px;
            text-align: center;
            font-weight: bold;
        }

        .fin-wizard--status ul li {
            display: inline-block;
            padding: 1px 5px;
            min-width: 90px;
            margin-bottom: 5px;
        }

        .fin-wizard--status ul li:nth-child(1) {
            background-color: #ffd9d9;
            border: 2px solid #fb0000;
        }

        .fin-wizard--status .required-info {
            width: 5px;
            height: 5px;
            background: red;
            border-radius: 50px;
            display: inline-block;
            margin: 0 2px 2px 0;
        }

        /*.fin-wizard--status ul li:nth-child(2) {
            background-color: rgba(0, 0, 0, 0.35);
            border: 2px solid rgb(0, 0, 0);
        }
        .info {
            width: 5px;
            height: 5px;
            background: black;
            border-radius: 50px;
            display: inline-block;
            margin: 0 2px 2px 0;
        }*/
        .fin-wizard--status ul li:nth-child(2) {
            background-color: rgb(217, 255, 217);
            border: 2px solid #00a700;
        }

        .fin-wizard--status .completed {
            width: 5px;
            height: 5px;
            background: #00c500;
            border-radius: 50px;
            display: inline-block;
            margin: 0 2px 2px 0;
        }

        .fin-wizard--status ul li:nth-child(3) {
            background-color: rgb(196, 231, 255);
            border: 2px solid rgb(0, 135, 255);
        }

        .fin-wizard--status .active {
            width: 5px;
            height: 5px;
            background: blue;
            border-radius: 50px;
            display: inline-block;
            margin: 0 2px 2px 0;
        }

        .fin-wizard--status ul li:nth-child(4) {
            background-color: rgb(222, 222, 222);
            border: 2px solid rgb(122, 122, 122);
        }

        .fin-wizard--status .disabled {
            width: 5px;
            height: 5px;
            background: #7d7d7d;
            border-radius: 50px;
            display: inline-block;
            margin: 0 2px 2px 0;
        }

        /*.fin-wizard--status ul {
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
        .fin-wizard--status ul li:nth-child(3) { background-color: #eaeaea; }*/


        .fin-wizard--body {
            padding-top: 10px;
        }

        .fin-wizard--body--content {
            display: flex;
            flex-direction: column;
        }

        .fin-wizard--body--content--row {
            flex: 1;
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        .fin-wizard--body--content--row--heading {
            display: flex;
            /* width: 190px;
            min-width: 190px; */
            border: 1px solid #00d501;
            border-radius: 5px;
            background-color: #d4fdd4;
            height: 90px;
            align-items: center;
            padding: 0 10px;
            margin-right: 10px;
        }

        .fin-wizard--body--content--row--action {
            padding: 10px;
        }

        .fin-wizard--body--content--row--action .fin-wizard__action {
            font-size: 9px;
            width: 116px; /* prev: 127px; */
            height: 90px; /* prev: 100px; */
            font-weight: bold;
            white-space: normal;
            background: white;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .fin-wizard__action--complete {
            color: green;
            border: 2px solid rgb(123, 226, 124);
            background-color: #e8ffe8 !important;
        }

        .fin-wizard__action--complete:hover {
            box-shadow: 0 0 8px 2px rgb(123, 226, 124) !important;
        }

        .fin-wizard__action--complete::after {
            /*content: '\2714'; !* 0021 exclamation *!*/
            width: 15px;
            height: 15px;
            background: green;
            position: absolute;
            top: -5px;
            right: -5px;
            border-radius: 50%;
            color: white;
            padding: 1px 0;
            font-size: 9px;
        }

        .fin-wizard__action--active {
            color: rgb(0, 135, 255);
            border: 2px solid rgb(123, 184, 226);
            background-color: rgb(231, 244, 255) !important;
        }

        .fin-wizard__action--active:hover {
            box-shadow: 0 0 8px 2px rgb(123, 184, 226) !important;
        }

        .fin-wizard__action--disabled {
            color: black;
            border: 2px solid gray;
            background-color: #d7d5d5 !important;
        }

        .fin-wizard__action--disabled:hover {
            cursor: not-allowed !important;
        }

        .fin-wizard--body--content--row--action i {
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 1;
            margin: 0 !important;
            font-size: 30px !important;
        }

        .fin-wizard--body--content--row--action span {
            flex: 0.5;
        }

        .fin-wizard--body--content--row--action .required-info--action {
            position: absolute;
            top: 2px;
            right: 2px;
            width: 4px;
            height: 4px;
            background: red;
            border-radius: 50px;
        }


        .modal-dialog {
            width: 100%;
            height: 100%;
            margin: 0;
            max-width: 100%;
        }

        .modal-content {
            width: 90%;
            height: 90vh;
            margin: auto;
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
        /*        .fin-wizard__action
                {
                    font-size: 9px;
                    width: 116px; !* prev: 127px; *!
                    height: 90px; !* prev: 100px; *!
                    font-weight: bold;
                    white-space: normal;
                    background: white;
                    border: 2px solid rgb(123,226,124);
                    color: green;
                    display: flex;
                    flex-direction: column;
                }*/
        /*  => Check mark.
        content: '\2714'; // 0021 exclamation
        width: 20px;
        height: 20px;
        background: green;
        position: absolute;
        top: -5px;
        right: -5px;
        border-radius: 50%;
        color: white;
        padding: 1px 0;
        font-size: 12px;
        */

        /*TEmp change to buttons*/
        .fin-wizard--body--content--row--heading {
            height: 50px;
        }

        .fin-wizard--body--content--row--action .fin-wizard__action {
            font-size: 10px;
            width: 130px;
            height: 50px;
        }

        .fin-wizard--body--content--row--action span {
            align-items: center;
            align-self: center;
            display: flex;
            flex: 1;
        }

        /*.fin-wizard--body--content--row--action .required-info--action {
            width: 3px;
            height: 3px;
        }*/


        /*popup icon*/
        .fin-wizard__action .popup_icon {
            /*position: absolute;top: 6px;right: 9px;width: 18px;height: 18px;*/
            position: absolute;
            top: -2px;
            left: -2px;
            width: 15px;
            height: 15px;
            margin: 0;
            padding: 0;
            /*z-index: 1;*/
            display: none;
        }

        .fin-wizard__action .popup_icon i { /*padding: 0; margin: 0; font-size: 11px; vertical-align: unset;*/
            font-size: 10px !important;
            line-height: 15px;
        }

        .fin-wizard__action:hover .popup_icon,
        .fin-wizard__action:focus .popup_icon {
            top: -2px;
            left: -2px;
            display: block;
        }
    </style>
@stop


@section('content')
    @php
        $sc_welcome_wizard = $systemConfig->sc_welcome_wizard;
        $perActionProgress = 100 / $systemConfig->getTotalWizardActions();
        $completedProgress = $sc_welcome_wizard['total_completed'] * $perActionProgress;
        $activeProgress = $sc_welcome_wizard['total_active'] * $perActionProgress;
        $activeProgressTotal = $activeProgress + $completedProgress;
       $user =  \Illuminate\Support\Facades\Auth::user();
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
                    <li><span class="required-info"></span> Required</li>
                    {{--<li><span class="info"></span> Info</li>--}}
                    <li><span class="completed"></span> Completed</li>
                    <li><span class="active"></span> Active</li>
                    <li><span class="disabled"></span> Disabled</li>
                </ul>
            </div>
        </div>

        <div class="fin-wizard--body">

            <div class="fin-wizard--body--content">
                <div class="fin-wizard--body--content--row form-group border-bottom row row-action-main">
                    <div class="form-group col-lg-2 col-md-3 col-sm-12">
                        <div class="fin-wizard--body--content--row--heading">General Information</div>
                    </div>
                    <div class="col-lg-10 col-md-9 col-sm-12">
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="company_info" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'company_info') }}"
                                    data-href="{{ route('company_info') }}" data-toggle="modal" data-target="#fin-wizard--modal"><span class="required-info--action"></span>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Basic"><i
                                        class="fa fa-info-circle"></i></div> {{--<i class="fa fa-building"></i><br>--}} <span> Company Info</span></button>
                        </div>
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="reporting_group" class="btn advance fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'reporting_group') }}"
                                    data-href="{{ route('add_account_group') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['reporting_group'] == -1 ? ' disabled' : '' }}>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Advance"><i class="fas fa-crown"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                <span> Reporting Group</span></button>
                        </div>
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="product_reporting_group"
                                    class="btn advance fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'product_reporting_group') }}"
                                    data-href="{{ route('product_group') }}" data-toggle="modal"
                                    data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['product_reporting_group'] == -1 ? ' disabled' : '' }}>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Advance"><i class="fas fa-crown"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                <span> Product Reporting Group</span></button>
                        </div>
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="add_modular_group" class="btn basic fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'add_role_permission')
                             }}"
                                    data-href="{{ route('add_role_permission') }}" data-toggle="modal"
                                    data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['add_role_permission'] == 1 ? ' complete' : '' }}>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Basic"><i class="fas fa-crown"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                <span> Add Modular Group</span></button>
                        </div>
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="warehouse" class="btn advance fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'warehouse') }}"
                                    data-href="{{ route('add_warehouse') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['warehouse'] == -1 ? ' disabled' : '' }}>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Advance"><i class="fas fa-crown"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                <span>Warehouse</span></button>
                        </div>
                        {{--<div class="fin-wizard--body--content--row--action"><button type="button" id="organization_department" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'organization_department') }}" data-href="javascript:void(0);" {{ $sc_welcome_wizard['organization_department'] == -1 ? ' disabled' : '' }}> <i class="fa fa-building"></i><br> <span>Organization Depart.</ button></td>--}}
                    </div>
                </div>
                <div class="fin-wizard--body--content--row form-group row border-bottom row-action-main">
                    <div class="form-group col-lg-2 col-md-3 col-sm-12">
                        <div class="fin-wizard--body--content--row--heading">Employee Registration</div>
                    </div>
                    <div class="col-lg-10 col-md-9 col-sm-12">
                        @if($systemConfig->sc_all_done === 0 && auth()->user()->user_id == 2 || auth()->user()->user_id == 1)
                            <div class="fin-wizard--body--content--row--action">
                                <button type="button" id="admin_profile" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'admin_profile') }}"
                                        data-href="{{ route('admin_profile', ['employee_id' => 2]) }}" data-toggle="modal"
                                        data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['admin_profile'] == -1 ? ' disabled' : '' }}><span class="required-info--action"></span>
                                    <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i>
                                    </div> {{--<i class="fa fa-building"></i><br>--}} <span>Admin Profile</span></button>
                            </div>
                        @endif
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="department" class="btn advance fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass
                        ($sc_welcome_wizard, 'department') }}" data-href="{{ route('departments.create') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{
                        $sc_welcome_wizard['department'] == -1 ?
                        ' disabled' : '' }}>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Advance"><i class="fas fa-crown"></i></div> {{--<i class="fa
                        fa-building"></i><br>--}} <span>Department </span></button>
                        </div>
                        {{--<div class="fin-wizard--body--content--row--action"><button type="button" id="salary_account" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'salary_account') }}" data-href="{{ route('salary_account_registration') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['salary_account'] == -1 ? ' disabled' : '' }}><div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Description"><i class="fa fa-info-circle"></i></div> --}}{{--<i class="fa fa-building"></i><br>--}}{{-- <span>Salary Account</span> </button></div>--}}
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="employee" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'employee') }}"
                                    data-href="{{ route('add_employee') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['employee'] == -1 ? ' disabled' : '' }}>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Basic"><i class="fa fa-info-circle"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                <span>Employee</span></button>
                        </div>
                    </div>
                </div>
                <div class="fin-wizard--body--content--row form-group row border-bottom row-action-main">
                    <div class="form-group col-lg-2 col-md-3 col-sm-12">
                        <div class="fin-wizard--body--content--row--heading">Product Registration</div>
                    </div>
                    <div class="col-lg-10 col-md-9 col-sm-12">
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="group" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'group') }}"
                                    data-href="{{ route('add_group') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['group'] == -1 ? ' disabled' : '' }}>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Basic"><i class="fa fa-info-circle"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                <span>Group</span></button>
                        </div>
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="category" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'category') }}"
                                    data-href="{{ route('add_category') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['category'] == -1 ? ' disabled' : '' }}>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Basic"><i class="fa fa-info-circle"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                <span>Category</span></button>
                        </div>
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="main_unit" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'main_unit') }}"
                                    data-href="{{ route('add_main_unit') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['main_unit'] == -1 ? ' disabled' : '' }}>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Basic"><i class="fa fa-info-circle"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                <span>Main Unit</span></button>
                        </div>
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="unit" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'unit') }}"
                                    data-href="{{ route('add_unit') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['unit'] == -1 ? ' disabled' : '' }}>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Basic"><i class="fa fa-info-circle"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                <span>Unit</span></button>
                        </div>
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="brand" class="btn advance fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'brand') }}"
                                    data-href="{{ route('add_brand') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['brand'] == -1 ? ' disabled' : '' }}>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Advance"><i class="fas fa-crown"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                <span>Brand</span></button>
                        </div>
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="product" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'product') }}"
                                    data-href="{{ route('add_product') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['product'] == -1 ? ' disabled' : '' }}>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Basic"><i class="fa fa-info-circle"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                <span>Product</span></button>
                        </div>
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="product_clubbing" class="btn advance fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'product_clubbing') }}"
                                    data-href="{{ route('product_clubbing') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['product_clubbing'] == -1 ? ' disabled' : '' }}>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Advance"><i class="fas fa-crown"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                <span>Product Clubbing</span></button>
                        </div>
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="product_packages" class="btn advance fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'product_packages') }}"
                                    data-href="{{ route('product_packages') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['product_packages'] == -1 ? ' disabled' : '' }}>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Advance"><i class="fas fa-crown"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                <span>Product Packages</span></button>
                        </div>
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="product_recipe" class="btn advance fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'product_recipe') }}"
                                    data-href="{{ route('product_recipe') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['product_recipe'] == -1 ? ' disabled' : '' }}>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Advance"><i class="fas fa-crown"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                <span>Product Recipe</span></button>
                        </div>
                    </div>
                </div>
                <div class="fin-wizard--body--content--row form-group row border-bottom row-action-main">
                    <div class="form-group col-lg-2 col-md-3 col-sm-12">
                        <div class="fin-wizard--body--content--row--heading">Service Registration</div>
                    </div>
                    <div class="col-lg-10 col-md-9 col-sm-12">
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="service" class="btn advance fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'service') }}"
                                    data-href="{{ route('add_services') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['service'] == -1 ? ' disabled' : '' }}>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Advance"><i class="fas fa-crown"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                <span>Service</span></button>
                        </div>
                    </div>
                </div>
                <div class="fin-wizard--body--content--row form-group row border-bottom row-action-main">
                    <div class="form-group col-lg-2 col-md-3 col-sm-12">
                        <div class="fin-wizard--body--content--row--heading">Bank Registration</div>
                    </div>
                    <div class="col-lg-10 col-md-9 col-sm-12">
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="bank_account" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'bank_account') }}"
                                    data-href="{{ route('bank_account_registration') }}" data-toggle="modal"
                                    data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['bank_account'] == -1 ? ' disabled' : '' }}>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Basic"><i class="fa fa-info-circle"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                <span>Bank Account</span></button>
                        </div>
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="credit_card_machine" class="btn advance fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'credit_card_machine') }}"
                                    data-href="{{ route('add_credit_card_machine') }}" data-toggle="modal"
                                    data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['credit_card_machine'] == -1 ? ' disabled' : '' }}>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Advance"><i class="fas fa-crown"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                <span>Credit Card Machine</span></button>
                        </div>
                    </div>
                </div>
                <div class="fin-wizard--body--content--row form-group row border-bottom row-action-main">
                    <div class="form-group col-lg-2 col-md-3 col-sm-12">
                        <div class="fin-wizard--body--content--row--heading">Party Registration</div>
                    </div>
                    <div class="col-lg-10 col-md-9 col-sm-12">
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="region" class="btn advance fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'region') }}"
                                    data-href="{{ route('add_region') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['region'] == -1 ? ' disabled' : '' }}>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Advance"><i class="fas fa-crown"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                <span>Region</span></button>
                        </div>
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="area" class="btn advance fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'area') }}"
                                    data-href="{{ route('add_area') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['area'] == -1 ? ' disabled' : '' }}>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Advance"><i class="fas fa-crown"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                <span>Area</span></button>
                        </div>
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="sector" class="btn advance fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'sector') }}"
                                    data-href="{{ route('add_sector') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['sector'] == -1 ? ' disabled' : '' }}>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Advance"><i class="fas fa-crown"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                <span>Sector</span></button>
                        </div>
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="town" class="btn advance fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'town') }}"
                                    data-href="{{ route('add_town') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['town'] == -1 ? ' disabled' : '' }}>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Advance"><i class="fas fa-crown"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                <span>Town</span></button>
                        </div>
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="client_registration" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'client_registration') }}"
                                    data-href="{{ route('receivables_account_registration') }}" data-toggle="modal"
                                    data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['client_registration'] == -1 ? ' disabled' : '' }}>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Basic"><i class="fa fa-info-circle"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                <span>Client/Supplier Registration</span></button>
                        </div>
                        {{--                        <div class="fin-wizard--body--content--row--action">--}}
                        {{--                            <button type="button" id="supplier_registration" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'supplier_registration') }}"--}}
                        {{--                                    data-href="{{ route('payables_account_registration') }}" data-toggle="modal"--}}
                        {{--                                    data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['supplier_registration'] == -1 ? ' disabled' : '' }}>--}}
                        {{--                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Basic"><i class="fa fa-info-circle"></i></div> --}}{{--<i class="fa fa-building"></i><br>--}}
                        {{--                                <span>Supplier Registration</span></button>--}}
                        {{--                        </div>--}}
                    </div>
                </div>
                <div class="fin-wizard--body--content--row form-group row border-bottom row-action-main">
                    <div class="form-group col-lg-2 col-md-3 col-sm-12">
                        <div class="fin-wizard--body--content--row--heading">Financial Registration</div>
                    </div>
                    <div class="col-lg-10 col-md-9 col-sm-12">
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="group_account" class="btn basic fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'group_account') }}"
                                    data-href="{{ route('add_second_level_chart_of_account') }}" data-toggle="modal"
                                    data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['group_account'] == -1 ? ' disabled' : '' }}>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Advance"><i class="fas fa-crown"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                <span>Parent Account</span></button>
                        </div>
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="parent_account" class="btn basic fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'parent_account') }}"
                                    data-href="{{ route('add_third_level_chart_of_account') }}" data-toggle="modal"
                                    data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['parent_account'] == -1 ? ' disabled' : '' }}>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Advance"><i class="fas fa-crown"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                <span>Child Account</span></button>
                        </div>
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="entry_account" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'entry_account') }}"
                                    data-href="{{ route('account_registration') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['entry_account'] == -1 ? ' disabled' : '' }}>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Basic"><i class="fa fa-info-circle"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                <span>Entry Account</span></button>
                        </div>
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="expense_account" class="btn advance fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'expense_account') }}"
                                    data-href="{{ route('expense_account_registration') }}" data-toggle="modal"
                                    data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['expense_account'] == -1 ? ' disabled' : '' }}>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Advance"><i class="fas fa-crown"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                <span>Expense Account</span></button>
                        </div>
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="fixed_account" class="btn advance fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'fixed_account') }}"
                                    data-href="{{ route('default_account_list') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['fixed_account'] == -1 ? ' disabled' : '' }}>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Advance"><i class="fas fa-crown"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                <span>Fixed Account</span></button>
                        </div>
                    </div>
                </div>
                <div class="fin-wizard--body--content--row form-group row border-bottom row-action-main">
                    <div class="form-group col-lg-2 col-md-3 col-sm-12">
                        <div class="fin-wizard--body--content--row--heading">Asset Registration</div>
                    </div>
                    <div class="col-lg-10 col-md-9 col-sm-12">
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="asset_parent_account" class="btn advance fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'asset_parent_account') }}"
                                    data-href="{{ route('add_third_level_chart_of_account') }}" data-toggle="modal"
                                    data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['asset_parent_account'] == -1 ? ' disabled' : '' }}>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Advance"><i class="fas fa-crown"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                <span>Asset Parent Account</span></button>
                        </div>
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="expense_group_account" class="btn advance fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'expense_group_account') }}"
                                    data-href="{{ route('add_second_level_chart_of_account') }}" data-toggle="modal"
                                    data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['expense_group_account'] == -1 ? ' disabled' : '' }}>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Advance"><i class="fas fa-crown"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                <span>Expense Group Account</span></button>
                        </div>
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="asset_registration" class="btn advance fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'asset_registration') }}"
                                    data-href="{{ route('fixed_asset') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['asset_registration'] == -1 ? ' disabled' : '' }}>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Advance"><i class="fas fa-crown"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                <span>Asset Registration</span></button>
                        </div>
                    </div>
                </div>
                <div class="fin-wizard--body--content--row form-group row border-bottom row-action-main">
                    <div class="form-group col-lg-2 col-md-3 col-sm-12">
                        <div class="fin-wizard--body--content--row--heading">Capital Registration</div>
                    </div>
                    <div class="col-lg-10 col-md-9 col-sm-12">
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="second_head" class="btn advance fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'second_head') }}"
                                    data-href="{{ route('add_second_level_chart_of_account') }}" data-toggle="modal"
                                    data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['second_head'] == -1 ? ' disabled' : '' }}>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Advance"><i class="fas fa-crown"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                <span>Second Head</span></button>
                        </div>
                        <div class="fin-wizard--body--content--row--action">
                            <button type="button" id="capital_registration" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'capital_registration') }}"
                                    data-href="{{ route('capital_registration') }}" data-toggle="modal"
                                    data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['capital_registration'] == -1 ? ' disabled' : '' }}><span class="required-info--action"></span>
                                <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Basic"><i class="fa fa-info-circle"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                <span>Capital Registration</span></button>
                        </div>
                    </div>
                </div>
                @php

                    @endphp
                @if($user->user_id == 1 ||$user->user_id == 2 )
                    <div class="fin-wizard--body--content--row form-group row border-bottom row-action-main">
                        <div class="form-group col-lg-2 col-md-3 col-sm-12">
                            <div class="fin-wizard--body--content--row--heading">Day End Config</div>
                        </div>
                        <div class="col-lg-10 col-md-9 col-sm-12">
                            <div class="fin-wizard--body--content--row--action">
                                <button type="button" id="day_end_config" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'day_end_config') }}"
                                        data-href="{{ route('day_end_config') }}" data-toggle="modal" data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['day_end_config'] == -1 ? ' disabled' : '' }}><span
                                        class="required-info--action"></span>
                                    <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Basic"><i class="fa fa-info-circle"></i></div> {{--<i class="fa fa-building"></i><br>--}}
                                    <span>Day End Config</span></button>
                            </div>
                        </div>
                    </div>
                @endif
                @if( $systemConfig->sc_all_done === 0)
                    <div class="fin-wizard--body--content--row form-group row border-bottom row-action-main">
                        <div class="form-group col-lg-2 col-md-3 col-sm-12">
                            <div class="fin-wizard--body--content--row--heading">Opening</div>
                        </div>
                        <div class="col-lg-10 col-md-9 col-sm-12">
                            <div class="fin-wizard--body--content--row--action">
                                <button type="button" id="system_date" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'system_date') }}"
                                        data-href="{{ route('system_config_show_date') }}" data-toggle="modal"
                                        data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['system_date'] == -1 ? ' disabled' : '' }}><span class="required-info--action"></span>
                                    <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Basic"><i class="fa fa-info-circle"></i>
                                    </div> {{--<i class="fa fa-building"></i><br>--}} <span>System Date</span></button>
                            </div>
                            <div class="fin-wizard--body--content--row--action">
                                <button type="button" id="opening_invoice_n_voucher_sequence"
                                        class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'opening_invoice_n_voucher_sequence') }}"
                                        data-href="{{ route('opening_invoice_voucher_sequence') }}" data-toggle="modal"
                                        data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['opening_invoice_n_voucher_sequence'] == -1 ? ' disabled' : '' }}>
                                    <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Basic"><i class="fa fa-info-circle"></i>
                                    </div> {{--<i class="fa fa-building"></i><br>--}} <span>Opening Invoice & Voucher Sequence</span></button>
                            </div>
                            <div class="fin-wizard--body--content--row--action">
                                <button type="button" id="opening_stock" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'opening_stock') }}"
                                        data-href="{{ route('product_opening_stock') }}" data-toggle="modal"
                                        data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['opening_stock'] == -1 ? ' disabled' : '' }}>
                                    <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Basic"><i class="fa fa-info-circle"></i>
                                    </div> {{--<i class="fa fa-building"></i><br>--}} <span>Opening Stock</span></button>
                            </div>
                            <div class="fin-wizard--body--content--row--action">
                                <button type="button" id="opening_party_balance"
                                        class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'opening_party_balance') }}"
                                        data-href="{{ route('account_opening_balance') }}" data-toggle="modal"
                                        data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['opening_party_balance'] == -1 ? ' disabled' : '' }}>
                                    <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Basic"><i class="fa fa-info-circle"></i>
                                    </div> {{--<i class="fa fa-building"></i><br>--}} <span>Opening Party Balance</span></button>
                            </div>
                            <div class="fin-wizard--body--content--row--action">
                                <button type="button" id="opening_trail" class="btn fin-wizard__action {{ $systemConfig->getScWelcomeWizardStatusClass($sc_welcome_wizard, 'opening_trail') }}"
                                        data-href="{{ route('view_account_opening_balance') }}" data-toggle="modal"
                                        data-target="#fin-wizard--modal" {{ $sc_welcome_wizard['opening_trail'] == -1 ? ' disabled' : '' }}>
                                    <div class="popup_icon" data-toggle="tooltip" data-placement="bottom" title="Basic"><i class="fa fa-info-circle"></i>
                                    </div> {{--<i class="fa fa-building"></i><br>--}} <span>Opening Trail</span></button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        </div>

        <div class="fin-wizard--foot">
            <div class="modal fade" id="fin-wizard--modal" tabindex="-1" role="dialog" aria-labelledby="fin-wizard--modal--label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="fin-wizard--modal--label"></h5>
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


@section('scripts')

    <script>
        $(document).ready(function () {

            var software_pack = '{!! $software_pack !!}';

            if (software_pack == 'Basic') {
                $('.advance').prop('disabled', true);
                $('.advance').removeClass("fin-wizard__action--active").removeClass("fin-wizard__action--complete").addClass("fin-wizard__action--disabled").attr('disabled', true);
            }


            $('.popup_icon').tooltip();

            $('.fin-wizard__action--disabled').attr('disabled', true);

            var form_heading = '';
            var form_location = '';
            $('.fin-wizard__action').on('click', function (e) {
                e.preventDefault();
                form_heading = $(this).text();
                form_location = $(this).data('href');
            });
            $('#fin-wizard--modal ').on('show.bs.modal', function (e) {
                $('#fin-wizard--modal--label').text(form_heading);

                var iframe = $('#' + $(this).attr('id') + ' iframe');
                iframe.attr("src", form_location);
                iframe.on("load", function () {
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
                        if (data['result'] === true) {
                            $.each(data['data']['sc_welcome_wizard'], function (key, value) {
                                if (value == 1) {
                                    $('#' + key).removeClass("fin-wizard__action--active").removeClass("fin-wizard__action--disabled").addClass("fin-wizard__action--complete").attr('disabled', false);
                                    if (key == 'admin_profile') {
                                        $('#' + key).parent().remove();
                                    }
                                } else if (value == 0) {
                                    $('#' + key).removeClass("fin-wizard__action--complete").removeClass("fin-wizard__action--disabled").addClass("fin-wizard__action--active").attr('disabled', false);
                                } else if (value == -1) {
                                    $('#' + key).removeClass("fin-wizard__action--active").removeClass("fin-wizard__action--complete").addClass("fin-wizard__action--disabled").attr('disabled', true);
                                }
                            });

                            var completedProgress = data['data']['sc_welcome_wizard']['total_completed'] * {{ $perActionProgress }};
                            var activeProgress = data['data']['sc_welcome_wizard']['total_active'] * {{ $perActionProgress }};
                            var activeProgressTotal = activeProgress + completedProgress;
                            console.log('completedProgress: ' + completedProgress, 'activeProgressTotal: ' + activeProgressTotal, 'activeProgress: ' + activeProgress);
                            $('.fin-wizard--progress #progress-bar-completed').css('width', completedProgress + '%');
                            $('.fin-wizard--progress #progress-bar-active').css('width', activeProgress + '%');
                            $('.fin-wizard--progress .progress-text').html('').html(completedProgress.toFixed(0) + '% Completed : ' + activeProgressTotal.toFixed(0) + '% Active');

                            if (data['data']['sc_welcome_wizard']['wizard_completed'] == 1) {
                                $('.fin-wizard__close').css('display', 'block');
                            }
                        }

                        if (data.software_pack == 'Basic') {
                            $('.advance').prop('disabled', true);
                            $('.advance').removeClass("fin-wizard__action--active").removeClass("fin-wizard__action--complete").addClass("fin-wizard__action--disabled").attr('disabled', true);
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
