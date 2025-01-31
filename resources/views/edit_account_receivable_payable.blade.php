@extends('extend_index')

@section('content')
    <style>
        #account_urdu_name {
            direction: rtl;
        }
        .ur {
            font-family: 'Jameel Noori Nastaleeq', 'Noto Naskh Arabic', sans serif;;
        }

    </style>

    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">


            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">


                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
{{--                            <h4 class="text-white get-heading-text">Edit {{$account_type}} Account</h4>--}}
                            <h4 class="text-white get-heading-text">Edit {{$account->account_parent_code == 21010 ? 'Supplier' : 'Client'}} Account</h4>
                        </div>
                    </div>
                </div><!-- form header close -->

                <form name="f1" class="f1" id="f1" action="update_account_receivable_payable" onsubmit="return checkForm()" method="post">
                    @csrf

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <div class="pd-20 bg-white border-radius-4 box-shadow">
                                <div class="tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active text-blue" data-toggle="tab" href="#personal"
                                               role="tab" aria-selected="true">Personal Info</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-blue" data-toggle="tab" href="#business" role="tab"
                                               aria-selected="false">Business Info</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-blue" data-toggle="tab" href="#credentials" role="tab"
                                               aria-selected="false">Credentials</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="personal" role="tabpanel">
                                            <div class="pd-20">
                                                <div class="row">
                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="input_bx">
                                                            <!-- start input box -->
                                                            <label class="">Account Type</label>
                                                            <div class="custom-control custom-radio mb-10 mt-1">
                                                                <input tabindex="-1" type="radio" name="account_type"
                                                                       class="custom-control-input account_type"
                                                                       id="client" value="client" {{$account->account_parent_code == 11013 ? 'checked':'disabled'}} data-rule-required="true"
                                                                       data-msg-required="Please Select Account Type">
                                                                <label class="custom-control-label" for="client">
                                                                    Client
                                                                </label>
                                                            </div>
                                                            <div class="custom-control custom-radio mb-10 mt-1">
                                                                <input tabindex="-1" type="radio" name="account_type"
                                                                       class="custom-control-input account_type"
                                                                       id="supplier" value="supplier" {{$account->account_parent_code == 21010 ? 'checked':'disabled'}} data-rule-required="true"
                                                                       data-msg-required="Please Select Account Type">
                                                                <label class="custom-control-label" for="supplier">
                                                                    Supplier
                                                                </label>
                                                            </div>
                                                            <span id="account_error_msg" class="validate_sign"> </span>
                                                        </div><!-- end input box -->
                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label class="required">
                                                                <a
                                                                    data-container="body" data-toggle="popover" data-trigger="hover"
                                                                    data-placement="bottom" data-html="true"
                                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.region.name.description')}}</p><h6>Benefit</h6><p>{{
config('fields_info.about_form_fields.party_registration.region.name.benefits')}}</p><h6>Example</h6><p>{{
config('fields_info.about_form_fields.party_registration.region.name.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.region.name.validations') }}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                Select Region</label>
                                                            <select class="inputs_up form-control" name="region" id="region" data-rule-required="true" data-msg-required="Please Enter Region Title">
                                                                <option value="">Select Region</option>
                                                                @foreach($regions as $region)
                                                                    <option value="{{$region->reg_id}}" {{ $region->reg_id == $account->account_region_id ? 'selected="selected"' : '' }}>{{$region->reg_title}}</option>
                                                                @endforeach
                                                            </select>
                                                            <span id="demo1" class="validate_sign"> </span>
                                                        </div><!-- end input box -->

                                                    </div>

                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label class="required">
                                                                <a
                                                                    data-container="body" data-toggle="popover" data-trigger="hover"
                                                                    data-placement="bottom" data-html="true"
                                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.area.area_title.description')}}</p><h6>Benefit</h6><p>{{
config('fields_info.about_form_fields.party_registration.area.area_title.benefits')}}</p><h6>Example</h6><p>{{
config('fields_info.about_form_fields.party_registration.area.area_title.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.area.area_title.validations') }}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                Select Area</label>
                                                            <select class="inputs_up form-control" name="area" id="area" style="width: 100%" data-rule-required="true" data-msg-required="Please Enter Area Title">
                                                                <option value="">Select Area</option>

                                                            </select>
                                                            <span id="demo2" class="validate_sign"> </span>
                                                        </div><!-- end input box -->

                                                    </div>

                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label class="required">
                                                                <a
                                                                    data-container="body" data-toggle="popover" data-trigger="hover"
                                                                    data-placement="bottom" data-html="true"
                                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.sector.sector_title.description')}}</p><h6>Benefit</h6><p>{{
config('fields_info.about_form_fields.party_registration.sector.sector_title.benefits')}}</p><h6>Example</h6><p>{{
config('fields_info.about_form_fields.party_registration.sector.sector_title.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.sector.sector_title.validations') }}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                Select Sector</label>
                                                            <select class="inputs_up form-control" name="sector" id="sector" data-rule-required="true" data-msg-required="Please Enter Sector Title" style="width: 100%">
                                                                <option value="">Select Sector</option>

                                                            </select>
                                                            <span id="demo3" class="validate_sign"> </span>
                                                        </div><!-- end input box -->

                                                    </div>

                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label class="required">
                                                                Select town
                                                                <a href="{{ route('add_town') }}" class="add_btn" target="_blank">
                                                                    <l class="fa fa-plus"></l>
                                                                </a>
                                                                <a id="refresh_town" class="add_btn">
                                                                    <l class="fa fa-refresh"></l>
                                                                </a>
                                                            </label>
                                                            <select class="inputs_up form-control" name="town" id="town" data-rule-required="true" data-msg-required="Please Enter Town Title">
                                                                <option value="">Select Town</option>

                                                            </select>
                                                            <span id="demo300" class="validate_sign"> </span>
                                                        </div><!-- end input box -->
                                                    </div>

                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label class="required">
                                                                <a
                                                                    data-container="body" data-toggle="popover" data-trigger="hover"
                                                                    data-placement="bottom" data-html="true"
                                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.account_ledger_access_group.description')}}</p><h6>Benefit</h6><p>{{
config('fields_info.about_form_fields.party_registration.client_registration.account_ledger_access_group.benefits')}}</p><h6>Example</h6><p>{{
config('fields_info.about_form_fields.party_registration.client_registration.account_ledger_access_group.example')}}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                Account Ledger Access Group
                                                            </label>
                                                            <select name="group" id="group" class="inputs_up form-control" data-rule-required="true" data-msg-required="Please Enter Account Ledger Access Group"
                                                                    style="width: 100%">
                                                                <option value="">Select Account Ledger Access Group</option>
                                                                @foreach($groups as $group)
                                                                    <option value="{{$group->ag_id}}" {{ $group->ag_id == $account->account_group_id ? 'selected="selected"' : '' }}>{{$group->ag_title}}</option>
                                                                @endforeach
                                                            </select>
                                                            <span id="demo70" class="validate_sign"> </span>
                                                        </div><!-- end input box -->

                                                    </div>

                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label class="required">
                                                                <a
                                                                    data-container="body" data-toggle="popover" data-trigger="hover"
                                                                    data-placement="bottom" data-html="true"
                                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.customer_title.description')}}</p>
                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.customer_title.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.customer_title.example')}}</p>
                                            <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.customer_title.validations') }}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                Account Title
                                                            </label>
                                                            <input type="text" name="account_name" id="account_name" class="inputs_up form-control"
                                                                   placeholder="Customer Title" value="{{$account->account_name}}" autocomplete="off">

                                                            <input type="hidden" name="account_id" value="{{$account->account_id}}">
                                                            <input type="hidden" name="head_code" value="{{$account->account_parent_code}}">
                                                            <span id="demo5" class="validate_sign"> </span>
                                                        </div><!-- end input box -->
                                                    </div>

                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label class="required">
                                                                <a
                                                                    data-container="body" data-toggle="popover" data-trigger="hover"
                                                                    data-placement="bottom" data-html="true"
                                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.customer_title.description')}}</p>
                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.customer_title.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.customer_title.example')}}</p>
                                            <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.customer_title.validations') }}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                Account Title In Urdu
                                                            </label>
                                                            <input type="text" name="account_urdu_name" id="account_urdu_name" class="inputs_up form-control ur"
                                                                   placeholder="Customer Title In Urdu" value="{{$account->account_urdu_name}}" autocomplete="off">
                                                            <span id="demo5" class="validate_sign"> </span>
                                                        </div><!-- end input box -->
                                                    </div>


                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12 saleman" style="display:none;">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label class="">
                                                                <a
                                                                    data-container="body" data-toggle="popover" data-trigger="hover"
                                                                    data-placement="bottom" data-html="true"
                                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.sale_person.description')}}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                Sale Person
                                                            </label>
                                                            <select name="sale_person" id="sale_person" class="inputs_up form-control">
                                                                <option value="">Select Sale Person</option>
                                                                @foreach($sale_persons as $sale_person)
                                                                    <option value="{{$sale_person->user_id}}" {{ $sale_person->user_id == $account->account_sale_person ? 'selected="selected"' : '' }}>{{$sale_person->user_name}}</option>
                                                                @endforeach
                                                            </select>
                                                            {{--                                    <span id="demo5" class="validate_sign"> </span>--}}
                                                        </div><!-- end input box -->
                                                    </div>

                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12 purchase" style="display: none">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label class="">
                                                                <a
                                                                    data-container="body" data-toggle="popover" data-trigger="hover"
                                                                    data-placement="bottom" data-html="true"
                                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.sale_person.description')}}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                Purchaser
                                                            </label>
                                                            <select tabindex="8" name="purchaser" id="purchaser" class="inputs_up form-control">
                                                                <option value="">Select Purchaser</option>
                                                                @foreach($purchasers as $purchaser)
                                                                    <option
                                                                        value="{{$purchaser->user_id}}" {{ $purchaser->user_id == $account->account_sale_person ? 'selected="selected"' : '' }}>{{$purchaser->user_name}}</option>
                                                                @endforeach
                                                            </select>
                                                            {{--                                    <span id="demo5" class="validate_sign"> </span>--}}
                                                        </div><!-- end input box -->
                                                    </div>

                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label class="">
                                                                <a
                                                                    data-container="body" data-toggle="popover" data-trigger="hover"
                                                                    data-placement="bottom" data-html="true"
                                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p><h6>Benefit</h6><p>{{
config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p><h6>Example</h6><p>{{
config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                Remarks</label>
                                                            <input type="text" name="remarks" id="remarks" class="inputs_up form-control"
                                                                   placeholder="Remarks" value="{{$account->account_remarks}}" autocomplete="off">
                                                            <span id="demo5" class="validate_sign"> </span>
                                                        </div><!-- end input box -->
                                                    </div>

                                                    <div class="form-group col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label>
                                                                <a
                                                                    data-container="body" data-toggle="popover" data-trigger="hover"
                                                                    data-placement="bottom" data-html="true"
                                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.cnic.description')}}</p>
                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.cnic.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.cnic.example')}}</p>
                                            <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.cnic.validations') }}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                CNIC</label>
                                                            <input type="text" name="cnic" id="cnic" class="inputs_up cnic form-control"
                                                                   placeholder="11111-1111111-1" value="{{$account->account_cnic}}"
                                                                   onkeypress="return isNumberWithHyphen(event)" autocomplete="off">
                                                            <span id="demo6" class="validate_sign"> </span>
                                                        </div><!-- end input box -->
                                                    </div>

                                                    <div class="form-group col-lg-3 col-md-4 col-sm-12 col-xs-12" hidden>
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label>Balance</label>
                                                            <input type="number" name="opening_balance" id="opening_balance" class="inputs_up cnic form-control"
                                                                   placeholder="Balance" value="{{$account->account_balance}}" step="any" autocomplete="off" readonly>
                                                            <span id="demo8" class="validate_sign"> </span>
                                                        </div><!-- end input box -->
                                                    </div>

                                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label class="">
                                                                <a
                                                                    data-container="body" data-toggle="popover" data-trigger="hover"
                                                                    data-placement="bottom" data-html="true"
                                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.address.description')}}</p>
                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.address.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.address.example')}}</p>
                                            <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.address.validations') }}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                Address</label>
                                                            <input type="text" name="address" id="address" class="inputs_up form-control" placeholder="Address"
                                                                   value="{{$account->account_address}}" autocomplete="off">
                                                        </div><!-- end input box -->
                                                    </div>



                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label class="required">
                                                                <a
                                                                    data-container="body" data-toggle="popover" data-trigger="hover"
                                                                    data-placement="bottom" data-html="true"
                                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.mobile.description')}}</p>
                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.mobile.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.mobile.example')}}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                Mobile
                                                            </label>
                                                            <input type="text" name="mobile" id="mobile" class="inputs_up form-control" placeholder="Mobile No." data-rule-required="true"
                                                                   data-msg-required="Please Enter Mobile Number"
                                                                   onblur="copy_number(this)" value="{{$account->account_mobile_no}}"
                                                                   onkeypress="return isNumberWithHyphen(event)" autocomplete="off">
                                                            <span id="demo9" class="validate_sign"> </span>
                                                        </div><!-- end input box -->
                                                    </div>

                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label>
                                                                <a
                                                                    data-container="body" data-toggle="popover" data-trigger="hover"
                                                                    data-placement="bottom" data-html="true"
                                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.whatsApp.description')}}</p>
                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.whatsApp.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.whatsApp.example')}}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                WhatsApp</label>
                                                            <input type="text" name="whatsapp" id="whatsapp" class="inputs_up form-control" placeholder="WhatsApp"
                                                                   value="{{$account->account_whatsapp}}" onkeypress="return isNumberWithHyphen(event)" autocomplete="off">
                                                            {{--onkeypress="return isNumber(event)"--}}
                                                            <span id="demo10" class="validate_sign"> </span>
                                                        </div><!-- end input box -->
                                                    </div>



                                                    {{--                            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">--}}
                                                    {{--                                <div class="input_bx"><!-- start input box -->--}}
                                                    {{--                                    <label>Credit Limit</label>--}}
                                                    {{--                                    <input type="text" name="credit_limit" id="credit_limit" class="inputs_up form-control"--}}
                                                    {{--                                           placeholder="Credit Limit" value="{{$account->account_credit_limit}}"--}}
                                                    {{--                                           onkeypress="return isNumberWithHyphen(event)" autocomplete="off">--}}
                                                    {{--                                    <span id="demo15" class="validate_sign"> </span>--}}
                                                    {{--                                </div><!-- end input box -->--}}
                                                    {{--                            </div>--}}

                                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12 saleman" style="display: none">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <div class="row">
                                                                <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                                    <label class="">
                                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                                           data-placement="bottom" data-html="true"
                                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.credit_limit.description')}}</p>">
                                                                            <i class="fa fa-info-circle"></i>
                                                                        </a>
                                                                        Credit Limit</label>
                                                                    <input type="text" name="credit_limit" id="credit_limit"
                                                                           class="inputs_up form-control" value="{{$account->account_credit_limit}}"
                                                                           placeholder="Credit Limit" onkeypress="return allow_only_number_and_decimals(this,event);" {{$account->account_credit_limit_status == 1 ?
                                               "readonly" : ""}}>
                                                                    <span id="demo15" class="validate_sign"> </span>
                                                                </div>
                                                                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                                                    <div class="custom-checkbox">
                                                                        <input type="checkbox" name="unlimited" id="unlimited" value="1"
                                                                               class="custom-control-input company_info_check_box" {{$account->account_credit_limit_status == 1 ? "checked" : ""}}>
                                                                        <label class="custom-control-label chck_pdng"
                                                                               for="unlimited">
                                                                            Unlimited
                                                                        </label>
                                                                    </div>
                                                                    {{--                                        <span id="demo12" class="validate_sign"> </span>--}}
                                                                </div>
                                                            </div>
                                                        </div><!-- end input box -->
                                                    </div>

                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label class="">Discount Type</label>
                                                            <div class="custom-control custom-radio mb-10 mt-1">
                                                                <input type="radio" name="discountType" class="custom-control-input religion" id="discountType1" value="1"  {{ $account->account_discount_type == 1 || $account->account_discount_type == 0 ? 'checked' : '' }}>
                                                                <label class="custom-control-label" for="discountType1">
                                                                    None
                                                                </label>
                                                            </div>
                                                            <div class="custom-control custom-radio mb-10 mt-1">
                                                                <input type="radio" name="discountType" class="custom-control-input religion" id="discountType2" value="2" {{ $account->account_discount_type == 2 ? 'checked' : '' }}>
                                                                <label class="custom-control-label" for="discountType2">
                                                                    Retailer
                                                                </label>
                                                            </div>
                                                            <div class="custom-control custom-radio mb-10 mt-1">
                                                                <input type="radio" name="discountType" class="custom-control-input religion" id="discountType3" value="3" {{ $account->account_discount_type == 3 ? 'checked' : '' }}>
                                                                <label class="custom-control-label" for="discountType3">
                                                                    Wholesaler
                                                                </label>
                                                            </div>
                                                            <div class="custom-control custom-radio mb-10 mt-1">
                                                                <input type="radio" name="discountType" class="custom-control-input religion" id="discountType4" value="4" {{ $account->account_discount_type == 4 ? 'checked' : '' }}>
                                                                <label class="custom-control-label" for="discountType4">
                                                                    Loyalty Card
                                                                </label>
                                                            </div>
                                                            <span id="religion_error_msg" class="validate_sign"> </span>
                                                        </div><!-- end input box -->
                                                    </div>


                                                </div>

                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="business" role="tabpanel">
                                            <div class="pd-20">
                                                <div class="row">

                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label class="">
                                                                <a
                                                                    data-container="body" data-toggle="popover" data-trigger="hover"
                                                                    data-placement="bottom" data-html="true"
                                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.print_name.description')}}</p>
                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.print_name.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.print_name.example')}}</p>
                                            <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.print_name.validations') }}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                Business Name</label>
                                                            <input type="text" name="print_name" id="print_name" class="inputs_up print_name form-control"
                                                                   placeholder="Business Name" value="{{$account->account_print_name}}" autocomplete="off">
                                                        </div><!-- end input box -->
                                                    </div>

                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label>
                                                                <a
                                                                    data-container="body" data-toggle="popover" data-trigger="hover"
                                                                    data-placement="bottom" data-html="true"
                                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.proprietor.description')}}</p>
                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.proprietor.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.proprietor.example')}}</p>
                                            <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.proprietor.validations') }}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                Proprietor</label>
                                                            <input type="text" name="proprietor" id="proprietor" class="inputs_up form-control"
                                                                   placeholder="Proprietor" value="{{$account->account_proprietor}}" autocomplete="off">
                                                        </div><!-- end input box -->
                                                    </div>

                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label>
                                                                <a
                                                                    data-container="body" data-toggle="popover" data-trigger="hover"
                                                                    data-placement="bottom" data-html="true"
                                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.company_code.description')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.company_code.example')}}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                Company Code
                                                            </label>
                                                            <input type="text" name="co_code" id="co_code" class="inputs_up form-control" placeholder="Company Code"
                                                                   value="{{$account->account_company_code}}" autocomplete="off">
                                                        </div><!-- end input box -->
                                                    </div>

                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label>
                                                                <a
                                                                    data-container="body" data-toggle="popover" data-trigger="hover"
                                                                    data-placement="bottom" data-html="true"
                                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.phone.description')}}</p>
                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.phone.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.phone.example')}}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                Phone</label>
                                                            <input type="text" name="phone" id="phone" class="inputs_up form-control" placeholder="Phone"
                                                                   value="{{$account->account_phone}}" onkeypress="return isNumberWithHyphen(event)" autocomplete="off">
                                                            <span id="demo11" class="validate_sign"> </span>
                                                        </div><!-- end input box -->
                                                    </div>

                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label>
                                                                <a
                                                                    data-container="body" data-toggle="popover" data-trigger="hover"
                                                                    data-placement="bottom" data-html="true"
                                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.gst.description')}}</p>
                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.gst.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.gst.example')}}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                GST</label>
                                                            <input type="text" name="gst" id="gst" class="inputs_up form-control number" placeholder="GST"
                                                                   value="{{$account->account_gst}}" onkeypress="return isNumberWithHyphen(event)" autocomplete="off">
                                                            <span id="demo13" class="validate_sign"> </span>
                                                        </div><!-- end input box -->
                                                    </div>

                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label>
                                                                <a
                                                                    data-container="body" data-toggle="popover" data-trigger="hover"
                                                                    data-placement="bottom" data-html="true"
                                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.ntn.description')}}</p>
                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.ntn.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.ntn.example')}}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                NTN</label>
                                                            <input type="text" name="ntn" id="ntn" class="inputs_up form-control number" placeholder="NTN"
                                                                   value="{{$account->account_ntn}}" onkeypress="return isNumberWithHyphen(event)" autocomplete="off">
                                                            <span id="demo14" class="validate_sign"> </span>
                                                        </div><!-- end input box -->
                                                    </div>

                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label>
                                                                <a
                                                                    data-container="body" data-toggle="popover" data-trigger="hover"
                                                                    data-placement="bottom" data-html="true"
                                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.manual_ledger_number.description')}}</p>
                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.manual_ledger_number.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.manual_ledger_number.example')}}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                Manual Ledger Number
                                                            </label>
                                                            <input type="text" name="page_no" id="page_no" class="inputs_up form-control" placeholder="Manual Ledger Number"
                                                                   value="{{$account->account_page_no}}" autocomplete="off">
                                                        </div><!-- end input box -->
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="credentials" role="tabpanel">
                                            <div class="pd-20">
                                                @if($account->account_employee_id == 0)
                                                <div class="row">
                                                    <div class="invoice_row w-100">
                                                        <div class="invoice_col basis_col_10">
                                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                                <div class="input_bx">
                                                                    <div class="custom-control custom-checkbox mb-10 mt-1" style="float: left">
                                                                        <input type="checkbox" name="make_credentials" class="custom-control-input" id="make_credentials" value="1">
                                                                        <label class="custom-control-label" for="make_credentials">Make Credentials</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row credentials_div">

                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label class="required">
                                                                <a data-container="body" data-toggle="popover"
                                                                   data-trigger="hover"
                                                                   data-placement="bottom" data-html="true"
                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.general_registration.employee.username.description')}}</p>
                                            <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.general_registration.employee.username.benefits')}}</p>
                                             <h6>Example</h6><p>{{config('fields_info.about_form_fields.general_registration.employee.username.example')}}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                User Name</label>
                                                            <input tabindex="45" type="text" name="username" id="username" data-rule-required="true" data-msg-required="Please Enter UserName"
                                                                   class="inputs_up form-control"
                                                                   placeholder="User Name" onBlur="check_username()"
                                                                   value="{{old('username')}}">
                                                            <span id="username_error_msg" class="validate_sign"> </span>
                                                        </div><!-- end input box -->
                                                    </div>

                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label class="required">
                                                                <a
                                                                    data-container="body" data-toggle="popover" data-trigger="hover"
                                                                    data-placement="bottom" data-html="true"
                                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.email.description')}}</p>
                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.email.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.email.example')}}</p>">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                                Email</label>
                                                            <input tabindex="46" type="email" name="email" id="email" data-rule-required="true" data-msg-required="Please Enter Email"
                                                                   class="inputs_up form-control"
                                                                   placeholder="Email" onBlur="check_email()"
                                                                   value="{{old('email')}}">
                                                            <span id="email_error_msg" class="validate_sign"> </span>
                                                        </div><!-- end input box -->
                                                    </div>

{{--                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">--}}
{{--                                                        <div class="input_bx"><!-- start input box -->--}}
{{--                                                            <label class="required">--}}
{{--                                                                <a data-container="body" data-toggle="popover"--}}
{{--                                                                   data-trigger="hover"--}}
{{--                                                                   data-placement="bottom" data-html="true"--}}
{{--                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.general_registration.employee.modular_group.description')}}</p>--}}
{{--                                            <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.general_registration.employee.modular_group.benefits')}}</p>">--}}
{{--                                                                    <l class=" fa fa-info-circle"></l>--}}
{{--                                                                </a>--}}
{{--                                                                Modular Group--}}
{{--                                                                <a href="{{ route('add_modular_group') }}"--}}
{{--                                                                   class="add_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom"--}}
{{--                                                                   data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">--}}
{{--                                                                    <i class="fa fa-plus"></i>--}}
{{--                                                                </a>--}}
{{--                                                                <a id="refresh_modular_group" class="add_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom"--}}
{{--                                                                   data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">--}}
{{--                                                                    <l class="fa fa-refresh"></l>--}}
{{--                                                                </a>--}}
{{--                                                            </label>--}}
{{--                                                            <select tabindex="44" name="modular_group" class="inputs_up form-control" data-rule-required="true"--}}
{{--                                                                    data-msg-required="Please Enter Modular Group"--}}
{{--                                                                    id="modular_group">--}}
{{--                                                                <option value="">Select Modular Group</option>--}}
{{--                                                                @foreach($modular_groups as $modular_group)--}}
{{--                                                                    --}}{{--                                                                    <option--}}
{{--                                                                    --}}{{--                                                                        value="{{$modular_group->mg_id}}"{{$modular_group->mg_id == old('modular_group') ? 'selected' : ''}}>{{$modular_group->mg_title}}</option>--}}
{{--                                                                    <option value="{{$modular_group->mg_id}}"> {{$modular_group->mg_title}}</option>--}}

{{--                                                                @endforeach--}}
{{--                                                            </select>--}}
{{--                                                            <span id="modular_group_error_msg"--}}
{{--                                                                  class="validate_sign"> </span>--}}
{{--                                                        </div><!-- end input box -->--}}
{{--                                                    </div>--}}

                                                </div>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    {{--                                        <button type="reset" name="cancel" id="cancel" class="cancel_button form-control">--}}
                                    {{--                                            <i class="fa fa-eraser"></i> Cancel--}}
                                    {{--                                        </button>--}}
                                    <button type="submit" name="save" id="save" class="save_button form-control"
                                    >
                                        <i class="fa fa-floppy-o"></i> Save
                                    </button>
                                </div>
                            </div>

                        </div> <!-- left column ends here -->

                    </div>


                    {{--<div class="form-group row">
                        <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                            <button type="reset" name="cancel" id="cancel" class="cancel_button form-control">
                                <i class="fa fa-eraser"></i> Cancel
                            </button>
                            <button type="submit" name="save" id="save" class="save_button form-control" onclick="return validate_form()">
                                <i class="fa fa-floppy-o"></i> Save
                            </button>
                        </div>

                    </div>--}}


                </form>
            </div>


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')
    <script src="{{asset('public/urdu_text/yauk.min.js')}}"></script>

    <!-- validating on form -->
    <style>
        /* Hide HTML5 Up and Down arrows. */
        input[type="number"]::-webkit-outer-spin-button, input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none !important;
            margin: 0 !important;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>
    {{--    required input validation --}}
    <script type="text/javascript">
        var vusername = false;
        var flag = "true";
        var flag1 = "true";

        function check_username() {
            var focus_once = 0;
            var username = document.getElementById("username").value;

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({

                url: "check_employee_username",
                data: {username: username},
                type: "POST",
                dataType: 'json',

                success: function (data) {
                    console.log(data)
                    if (data == "yes") {
                        flag = "false";
                        document.getElementById("username_error_msg").innerHTML = "Choose Another User Name";
                        // jQuery("#username").focus();

                    } else {

                        if (!validateusername(username)) {
                            document.getElementById("username_error_msg").innerHTML = "Alphanumeric & Min.Length (6)";
                            //					if (focus_once == 0) { jQuery("#username").focus(); focus_once = 1;  }
                            flag = "false";
                        } else {

                            document.getElementById("username_error_msg").innerHTML = "";
                            flag = "true";
                            vusername = true;
                        }

                    }
                },
                error: function (xhr, textStatus, errorThrown) {
                    flag = "false";
                }
            });
            return flag;
        }

        function check_email() {
            var focus_once = 0;
            var email = document.getElementById("email").value;

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({

                url: "check_employee_email",
                data: {email: email},
                type: "POST",
                dataType: 'json',
                success: function (data) {

                    if (data == "yes") {
                        flag1 = "false";

                        document.getElementById("email_error_msg").innerHTML = "Choose Another Email Address";
                        // jQuery("#email").focus();

                    } else {

                        if (!checkemail(email)) {
                            document.getElementById("email_error_msg").innerHTML = "(example@example.com)";
                            //    if (focus_once == 0) { jQuery("#email").focus(); focus_once = 1;  }
                            flag1 = "false";
                        } else {
                            document.getElementById("email_error_msg").innerHTML = "";
                            flag1 = "true";
                            vusername = false;
                        }
                    }
                },

                error: function (xhr, textStatus, errorThrown) {
                    flag1 = "false";
                }

            });
            return flag1;
        }
        function checkForm() {
            let region = document.getElementById("region"),
                area = document.getElementById("area"),
                sector = document.getElementById("sector"),
                town = document.getElementById("town"),
                group = document.getElementById("group"),
                mobile = document.getElementById("mobile"),
                validateInputIdArray = [
                    region.id,
                    area.id,
                    sector.id,
                    town.id,
                    group.id,
                    mobile.id,
                ];
            var check = validateInventoryInputs(validateInputIdArray);
            if(check == true){
                var make_credentials = $("input:checkbox[name=make_credentials]:checked").val();
                if(make_credentials == 1){
                    let username = document.getElementById("username"),
                        email = document.getElementById("email"),
                        // modular_group = document.getElementById("modular_group"),
                        validateInputIdArray = [
                            username.id,
                            email.id,
                            // modular_group.id,
                        ];
                    return validateInventoryInputs(validateInputIdArray);
                }else{
                    return validateInventoryInputs(validateInputIdArray);
                }
            }else{
                return false;
            }
        }
    </script>

    <script>
        jQuery("#make_credentials").change(function () {

            if ($(this).is(':checked')) {
                $(".credentials_div *").prop('disabled', false);
            } else {
                $(".credentials_div *").prop('disabled', true);
            }
        });
    </script>
    {{-- end of required input validation --}}

    <script>
        jQuery(document).ready(function () {
            var account_type = '{!! $account->account_parent_code !!}';
            if(account_type =="11013"){
                // config('')
                $('#head_code').val('11013');
                $('.saleman').css('display','block');
                $('.purchase').css('display','none');
            }else{
                $('#head_code').val('21010');
                $('.purchase').css('display','block');
                $('.saleman').css('display','none');
            }

            var dropDown = document.getElementById('region');
            var reg_id = dropDown.options[dropDown.selectedIndex].value;

            var get_area_id = '{{$account->account_area}}';
            var sector_id = '{{$account->account_sector_id}}';
            var town_id = '{{$account->account_town_id}}';


            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_area",
                data: {reg_id: reg_id, area_id: get_area_id},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#area").html("");
                    jQuery("#area").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });


            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_sector",
                data: {area_id: get_area_id, sector_id: sector_id},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#sector").html("");
                    jQuery("#sector").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_town",
                data: {sector_id: sector_id, town_id: town_id},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#town").html(" ");
                    jQuery("#town").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);
                }
            });

        });

    </script>

    <script>

        $('.number').on('keypress keyup blur keydown', function () {
            var currentInput = $(this).val();
            var fixedInput = currentInput.replace(/[A-Za-z!@#$%^&*()]/g, '');
            $(this).val(fixedInput);
        });

        jQuery("#region").change(function () {

            var dropDown = document.getElementById('region');
            var reg_id = dropDown.options[dropDown.selectedIndex].value;

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_area",
                data: {reg_id: reg_id},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#area").html(" ");
                    jQuery("#area").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);
                }
            });
        });

        jQuery("#area").change(function () {

            var dropDown = document.getElementById('area');
            var area_id = dropDown.options[dropDown.selectedIndex].value;

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_sector",
                data: {area_id: area_id},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#sector").html(" ");
                    jQuery("#sector").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);
                }
            });
        });

        jQuery("#sector").change(function () {

            var dropDown = document.getElementById('sector');
            var sector_id = dropDown.options[dropDown.selectedIndex].value;

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_town",
                data: {sector_id: sector_id},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#town").html(" ");
                    jQuery("#town").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);
                }
            });
        });

    </script>

    <script type="text/javascript">

        function validate_form() {

            var region = document.getElementById("region").value;
            var area = document.getElementById("area").value;
            var sector = document.getElementById("sector").value;
            var account_name = document.getElementById("account_name").value;

            var cnic = document.getElementById("cnic").value;
            // var account_nature = document.getElementById("account_nature").value;
            var opening_balance = document.getElementById("opening_balance").value;
            var mobile = document.getElementById("mobile").value;
            var whatsapp = document.getElementById("whatsapp").value;
            var phone = document.getElementById("phone").value;
            var email = document.getElementById("email").value;
            var ntn = document.getElementById("ntn").value;
            var gst = document.getElementById("gst").value;
            var credit_limit = document.getElementById("credit_limit").value;
            var group = document.getElementById("group").value;

            var flag_submit = true;
            var focus_once = 0;


            if (region.trim() == "") {
                document.getElementById("demo1").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#region").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("demo1").innerHTML = "";
            }

            if (area.trim() == "") {
                document.getElementById("demo2").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#area").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("demo2").innerHTML = "";
            }


            if (sector.trim() == "") {
                document.getElementById("demo3").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#sector").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("demo3").innerHTML = "";
            }

            if (group.trim() == "") {
                document.getElementById("demo70").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#group").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("demo70").innerHTML = "";
            }

            if (account_name.trim() == "") {
                document.getElementById("demo5").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#account_name").focus();
                    focus_once = 1;
                }

                flag_submit = false;
            } else {
                document.getElementById("demo5").innerHTML = "";
            }

            if (cnic.trim() != "") {
                if (!validatecnic(cnic)) {
                    document.getElementById("demo6").innerHTML = "Invalid";
                    if (focus_once == 0) {
                        jQuery("#cnic").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                } else {
                    document.getElementById("demo6").innerHTML = "";
                }
            } else {
                document.getElementById("demo6").innerHTML = "";
            }


            // if (account_nature.trim() == "") {
            //     document.getElementById("demo7").innerHTML = "Required";
            //     if (focus_once == 0) {
            //         jQuery("#account_nature").focus();
            //         focus_once = 1;
            //     }
            //     flag_submit = false;
            // } else {
            //     document.getElementById("demo7").innerHTML = "";
            // }


            if (opening_balance.trim() != "") {
                if (!validatebcode(opening_balance)) {

                    document.getElementById("demo8").innerHTML = "Only Digits";
                    if (focus_once == 0) {
                        jQuery("#opening_balance").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }
            } else {
                document.getElementById("demo8").innerHTML = "";
            }


            if (mobile.trim() != "") {
                if (!validatemobile(mobile)) {
                    document.getElementById("demo9").innerHTML = "Invalid";
                    if (focus_once == 0) {
                        jQuery("#mobile").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                } else {
                    document.getElementById("demo9").innerHTML = "";
                }
            } else {
                document.getElementById("demo9").innerHTML = "";
            }


            if (whatsapp.trim() != "") {
                if (!validatemobile(whatsapp)) {
                    document.getElementById("demo10").innerHTML = "Invalid";
                    if (focus_once == 0) {
                        jQuery("#whatsapp").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                } else {
                    document.getElementById("demo10").innerHTML = "";
                }
            } else {
                document.getElementById("demo10").innerHTML = "";
            }


            if (phone.trim() != "") {
                if (!validatephone(phone)) {
                    document.getElementById("demo11").innerHTML = "Invalid";
                    if (focus_once == 0) {
                        jQuery("#phone").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                } else {
                    document.getElementById("demo11").innerHTML = "";
                }
            } else {
                document.getElementById("demo11").innerHTML = "";
            }


            if (email.trim() != "") {
                if (!checkemail(email)) {
                    document.getElementById("demo12").innerHTML = "Invalid";
                    if (focus_once == 0) {
                        jQuery("#email").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }
            } else {
                document.getElementById("demo12").innerHTML = "";
            }


            if (gst.trim() != "") {
                if (!validate_gst(gst)) {
                    document.getElementById("demo13").innerHTML = "Length 13 Digits";
                    if (focus_once == 0) {
                        jQuery("#gst").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                } else {
                    document.getElementById("demo13").innerHTML = "";
                }
            } else {
                document.getElementById("demo13").innerHTML = "";
            }


            if (ntn.trim() != "") {
                if (!validate_ntn(ntn)) {
                    document.getElementById("demo14").innerHTML = "Length 8 Digits";
                    if (focus_once == 0) {
                        jQuery("#ntn").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                } else {
                    document.getElementById("demo14").innerHTML = "";
                }
            } else {
                document.getElementById("demo14").innerHTML = "";
            }


            if (credit_limit.trim() != "") {
                if (!validatebcode(credit_limit)) {
                    document.getElementById("demo15").innerHTML = "Only Digits";
                    if (focus_once == 0) {
                        jQuery("#credit_limit").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                } else {
                    document.getElementById("demo15").innerHTML = "";
                }
            } else {
                document.getElementById("demo15").innerHTML = "";
            }


            return flag_submit;
        }

    </script>

    <script>
        function validate_ntn(val_ntn) {
            var val_n = /^\d{7}-?\d$/;
            if (val_n.test(val_ntn)) {
                return true;
            } else {
                return false;
            }
        }

        function validate_gst(val_gst) {
            var val_n = /^([0-9]{1}[0-9]{1})-?([0-9]{1}[0-9]{1})-?([0-9]{4}-?[0-9]{3}-?[0-9]{2})+$|^([0-9]{1}[0-9]{1}) ?([0-9]{1}[0-9]{1}) ?([0-9]{4} ?[0-9]{3} ?[0-9]{2})+$/;
            if (val_n.test(val_gst)) {
                return true;
            } else {
                return false;
            }
        }

        function validatebcode(pas) {
            var pass = /^-?[0-9]\d*(\.\d+)?$/;
            if (pass.test(pas)) {
                return true;
            } else {
                return false;
            }
        }

        // validate phone number
        function validatephone(phone_num) {
            var ph = /^\d{3}-?\d{3}-?\d{4}$|^\d{3} ?\d{3} ?\d{4}$/;
            if (ph.test(phone_num)) {
                return true;
            } else {
                return false;
            }
        }

        // validate mobile number
        function validatemobile(phone_num) {
            var ph = /^((\+92)|(0092))-?3\d{2}-?\d{7}$|^03\d{2}-?\d{7}$/;
            if (ph.test(phone_num)) {
                return true;
            } else {
                return false;
            }
        }

        // email checking

        function checkemail(email_address) {
            if (/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email_address)) {
                return true;
            } else {
                return false;
            }
        }

        // validating ID card
        function validatecnic(cnic_num) {


            myRegExp = new RegExp(/^\d{5}-\d{7}-\d$|^\d{13}$/);

            if (myRegExp.test(cnic_num)) {
                //if true
                return true;
            } else {
                //if false
                return false;
            }
        }


    </script>
    <!-- validating on form ended-->

    <!--additional scripting starts here  -->
    <script type="text/javascript">


        // **********************************************************only number enter **********************************************************
        // function isNumber(evt) {
        //     evt = (evt) ? evt : window.event;
        //     var charCode = (evt.which) ? evt.which : evt.keyCode;
        //     if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        //         return false;
        //     }
        //     return true;
        // }
        // **********************************************************Number with plus and hyphen only**********************************************************
        function isNumberWithHyphen(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode == 32 || charCode == 45 || charCode == 43) {
                return true
            } else if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }

        //***********************************************************************copy_number *******************************************************
        //copying whatsapp  mobile number to whatsapp number
        function copy_number(a) {
            var phone = jQuery("#mobile").val();
            var whatsapp = jQuery("#whatsapp").val();
            if (whatsapp == "") {
                jQuery("#whatsapp").val(phone);
            }
        }

        jQuery('#unlimited').change(function () {

            if ($(this).is(':checked')) {
                $("#credit_limit").val('');
                $("#credit_limit").attr('readonly', 'readonly');
            } else {
                $("#credit_limit").removeAttr('readonly');
            }
        });

    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#region").select2();
            jQuery("#area").select2();
            jQuery("#sector").select2();
            jQuery("#group").select2();
            jQuery("#sale_person").select2();
            jQuery("#town").select2();
            jQuery("#purchaser").select2();
            // jQuery("#modular_group").select2();
            $("#make_credentials").trigger("change");
        });
    </script>
    <!-- additionl scripting ednds here-->
    <script>
        $(function() {
            $('#account_urdu_name').setUrduInput();
            $('#account_urdu_name').focus();
        });
    </script>
@endsection

