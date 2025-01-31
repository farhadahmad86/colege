@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Edit Fixed Asset Registration</h4>
                        </div>
                        <div class="list_btn">
                            <a class="btn list_link add_more_button" href="{{ route('fixed_asset_list') }}" role="button">
                                <i class="fa fa-list"></i> view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <form action="{{ route('update_fixed_asset') }}" onsubmit="return checkForm()" method="post" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <div class="row">

                                <div class="form-group col-lg-3 col-md-4 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.parent_account.description')}}</p>
                                                                 <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.parent_account.benefits')}}</p>
                                                                <h6>Example</h6><p>{{config('fields_info.about_form_fields.parent_account.example')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Asset Parent Account
                                        </label>

                                        <input type="text" name="head_code" id="head_code" class="inputs_up form-control"
                                               data-rule-required="true" data-msg-required="Please Enter Asset Parent Account"
                                               value="{{$parent_account}}" readonly/>
                                        <span id="head_code_msg" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-4 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            <a
                                                data-container="body" data-toggle="popover" data-trigger="hover"
                                                data-placement="bottom" data-html="true"
                                                data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.client_registration.account_ledger_access_group.description')}}</p><h6>Benefit</h6><p>{{
config('fields_info.about_form_fields.party_registration.client_registration.account_ledger_access_group.benefits')}}</p><h6>Example</h6><p>{{
config('fields_info.about_form_fields.party_registration.client_registration.account_ledger_access_group.example')}}</p">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Account Ledger Access Group
                                        </label>

                                        <input type="text" name="group" id="group" class="inputs_up form-control"
                                               data-rule-required="true" data-msg-required="Please Enter Account Ledger Access Group"
                                               value="{{$group}}" readonly/>
                                        <span id="group_msg" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <input type="hidden" name="fixed_asset" value="{{$fixed_asset->fa_id}}"/>

                                <div class="form-group col-lg-3 col-md-4 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">Asset Name</label>
                                        <input type="text" name="account_name" id="asset_name" class="inputs_up form-control" placeholder="Asset Name"
                                               data-rule-required="true" data-msg-required="Please Enter Asset Name"
                                               value="{{$fixed_asset->fa_account_name}}"/>
                                        <span id="asset_name_msg" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-4 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Asset_Register_#.description')}}</p>
                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Asset_Register_#.benefits')}}</p>
                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Asset_Register_#.example')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Asset Register #</label>
                                        <input type="text" name="asset_registration_no" id="asset_registration_no" class="inputs_up form-control" placeholder="Asset Register #"
                                               value="{{$fixed_asset->fa_register_number}}"/>
                                        <span id="asset_registration_no_msg" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-4 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Importer/Supplier_Detail.description')}}</p>
                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Importer/Supplier_Detail.benefits')}}</p>
                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Importer/Supplier_Detail.example')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Importer/Supplier Detail</label>
                                        <input type="text" name="importer_supplier_detail" id="importer_supplier_detail" class="inputs_up form-control" placeholder="Importer/Supplier Detail"
                                               value="{{$fixed_asset->fa_supplier_details}}"/>
                                        <span id="importer_supplier_detail_msg" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-4 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Asset_Guarantee_Period.description')}}</p>
                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Asset_Guarantee_Period.benefits')}}</p>
                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Asset_Guarantee_Period.example')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Asset Guarantee Period</label>
                                        <input type="text" name="asset_guarantee_period" id="asset_guarantee_period" class="inputs_up form-control" placeholder="Asset Guarantee Period"
                                               value="{{$fixed_asset->fa_guarantee_period}}"/>
                                        <span id="asset_guarantee_period_msg" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-4 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Asset_Specification.description')}}</p>
                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Asset_Specification.benefits')}}</p>
                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Asset_Specification.example')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Asset Specification</label>
                                        <input type="text" name="asset_specification" id="asset_specification" class="inputs_up form-control" placeholder="Asset Specification"
                                               value="{{$fixed_asset->fa_specification}}"/>
                                        <span id="asset_specification_msg" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-4 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Asset_Capacity.description')}}</p>
                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Asset_Capacity.benefits')}}</p>
                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Asset_Capacity.example')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Asset Capacity</label>
                                        <input type="text" name="asset_capacity" id="asset_capacity" class="inputs_up form-control" placeholder="Asset Capacity" value="{{$fixed_asset->fa_capacity}}"/>
                                        <span id="asset_capacity_msg" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-4 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Asset_Size.description')}}</p>
                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Asset_Size.benefits')}}</p>
                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Asset_Size.example')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Asset Size</label>
                                        <input type="text" name="asset_size" id="asset_size" class="inputs_up form-control" placeholder="Asset Size" value="{{$fixed_asset->fa_size}}"/>
                                        <span id="asset_size_msg" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-4 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required weight-600">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Depreciation_Method.description')}}</p>
                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Depreciation_Method.benefits')}}</p>
                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Depreciation_Method.example')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Depreciation Method
                                        </label>
                                        <div class="custom-control custom-radio mb-5 mt-1">
                                            <input type="radio" id="straight_balance" name="method" value="1" class="custom-control-input" {{$fixed_asset->fa_method == 1 ? 'checked': ''}}>
                                            <label class="custom-control-label" for="straight_balance">
                                                Straight Balance
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio mb-5 mt-1">
                                            <input type="radio" id="reducing_balance" name="method" value="2" class="custom-control-input" {{$fixed_asset->fa_method == 2 ? 'checked': ''}}>
                                            <label class="custom-control-label" for="reducing_balance">
                                                Reducing Balance
                                            </label>
                                        </div>
                                        <span id="method_msg" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-4 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required weight-600">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Depreciation/Amortization.description')}}</p>
                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Depreciation/Amortization.benefits')}}</p>
                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Depreciation/Amortization.example')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Depreciation / Amortization
                                        </label>
                                        <div class="custom-control custom-radio mb-5 mt-1">
                                            <input type="radio" id="depreciation" name="account_type" value="1" class="custom-control-input account_type" {{$fixed_asset->fa_dep_amo == 1 ? 'checked': ''}}>
                                            <label class="custom-control-label" for="depreciation">
                                                Depreciation
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio mb-5 mt-1">
                                            <input type="radio" id="amortization" name="account_type" value="2" class="custom-control-input account_type" {{$fixed_asset->fa_dep_amo == 2 ? 'checked': ''}}>
                                            <label class="custom-control-label" for="amortization">
                                                Amortization
                                            </label>
                                        </div>
                                        <span id="account_type_msg" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-4 col-sm-12 hide_expense_account">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Depreciation_Parent_Account.description')}}</p>
                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Depreciation_Parent_Account.benefits')}}</p>
                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Depreciation_Parent_Account.example')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Depreciation Parent Account
                                        </label>

                                        <input type="text" name="expense_group_account" id="expense_group_account" class="inputs_up form-control"
                                               data-rule-required="true" data-msg-required="Please Enter Depreciation Parent Account"
                                               value="{{$group_expense_head->coa_head_name}}"
                                               readonly/>
                                        <span id="expense_group_account_msg" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-4 col-sm-12 hide_expense_account">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Depreciation_Chile_Account.description')}}</p>
                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Depreciation_Chile_Account.benefits')}}</p>
                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Depreciation_Chile_Account.example')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Depreciation Child Account
                                        </label>

                                        <input type="text" name="expense_parent_account" id="expense_parent_account" class="inputs_up form-control"
                                               data-rule-required="true" data-msg-required="Please Enter Depreciation Child Account"
                                               value="{{$group_expense_head->coa_head_name}}" readonly/>
                                        <span id="expense_parent_account_msg" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-4 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Asset_Purchase_Price.description')}}</p>
                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Asset_Purchase_Price.benefits')}}</p>
                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Asset_Purchase_Price.example')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Asset Purchase Price</label>
                                        <input type="text" name="asset_purchase_price" id="asset_purchase_price" class="inputs_up form-control" placeholder="Asset Purchase Price"
                                               data-rule-required="true" data-msg-required="Please Enter Asset Purchase Price"
                                               onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);" value="{{$fixed_asset->fa_price}}"/>
                                        <span id="asset_purchase_price_msg" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-4 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Residule_Value.description')}}</p>
                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Residule_Value.benefits')}}</p>
                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Residule_Value.example')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Residual Value</label>
                                        <input type="text" name="residual_value" id="residual_value" class="inputs_up form-control" placeholder="Residual Value"
                                               data-rule-required="true" data-msg-required="Please Enter Residual Value"
                                               value="{{$fixed_asset->fa_residual_value}}"/>
                                        <span id="residual_value_msg" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-4 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Useful_Life_In_Year(s).description')}}</p>
                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Useful_Life_In_Year(s).benefits')}}</p>
                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Useful_Life_In_Year(s).example')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Useful Life In Year(s)
                                        </label>
                                        <input type="text" name="useful_life" id="useful_life" class="inputs_up form-control" placeholder="Useful Life"
                                               data-rule-required="true" data-msg-required="Please Enter Useful Life In Year"
                                               value="{{$fixed_asset->fa_useful_life_year}}"/>
                                        <span id="useful_life_msg" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-4 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required weight-600">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Execute_Depreciation.description')}}</p>
                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Execute_Depreciation.benefits')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Execute Depreciation
                                        </label>
                                        <div class="custom-control custom-radio mb-5 mt-1">
                                            <input type="radio" id="per_annum" name="depreciation_percentage_radio" value="1"
                                                   class="custom-control-input" {{$fixed_asset->fa_dep_period == 1 ? 'checked': ''}}>
                                            <label class="custom-control-label" for="per_annum">
                                                Per Annum
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio mb-5 mt-1">
                                            <input type="radio" id="per_monthly" name="depreciation_percentage_radio" value="2" class="custom-control-input"
                                                    {{$fixed_asset->fa_dep_period == 2 ? 'checked': ''}}>
                                            <label class="custom-control-label" for="per_monthly">
                                                Per Monthly
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio mb-5 mt-1">
                                            <input type="radio" id="daily_basis" name="depreciation_percentage_radio" value="3" class="custom-control-input"
                                                    {{$fixed_asset->fa_dep_period == 3 ? 'checked': ''}}>
                                            <label class="custom-control-label" for="daily_basis">
                                                Daily Basis
                                            </label>
                                        </div>
                                        <span id="depreciation_percentage_radio_msg" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-4 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Depreciation%Per_Year.description')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Depreciation % Per Year
                                        </label>
                                        <input type="text" name="depreciation_percentage" id="depreciation_percentage" class="inputs_up form-control" placeholder="Depreciation %"
                                               data-rule-required="true" data-msg-required="Please Enter Depreciation % Per Year"
                                               onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);" value="{{$fixed_asset->fa_dep_percentage_year}}"/>
                                        <span id="depreciation_percentage_msg" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-4 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required weight-600">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Posting_Auto/Manual.description')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Posting Auto/Manual
                                        </label>
                                        <div class="custom-control custom-radio mb-5 mt-1">
                                            <input type="radio" id="auto_posting" name="posting_method" value="1" class="custom-control-input" {{$fixed_asset->fa_posting == 1 ? 'checked': ''}}>
                                            <label class="custom-control-label" for="auto_posting">
                                                Auto
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio mb-5 mt-1">
                                            <input type="radio" id="manual_posting" name="posting_method" value="2" class="custom-control-input" {{$fixed_asset->fa_posting == 2 ? 'checked': ''}}>
                                            <label class="custom-control-label" for="manual_posting">
                                                Manual
                                            </label>
                                        </div>
                                        <span id="posting_method_msg" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-4 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.Asset_Registration.Acquisition_Date.description')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Acquisition Date
                                        </label>
                                        <input type="text" name="acquisition_date" id="acquisition_date" class="inputs_up form-control date-picker" placeholder="Acquisition Date"
                                               data-rule-required="true" data-msg-required="Please Enter Acquisition Date"
                                               value="{{ date('d F Y', strtotime($fixed_asset->fa_acquisition_date))}}"/>
                                        <span id="acquisition_date_msg" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-6 col-md-4 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p>
                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p>
                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p>
                                                            <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Remarks</label>
                                        <textarea name="remarks" id="remarks" class="remarks inputs_up form-control" placeholder="Remarks">{{$fixed_asset->fa_remarks}}</textarea>
                                        <span id="remarks_msg" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>


                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    <button type="reset" name="cancel" id="cancel" class="cancel_button form-control">
                                        <i class="fa fa-eraser"></i> Cancel
                                    </button>
                                    <button type="submit" name="save" id="save" class="save_button form-control"
                                    >
                                        <i class="fa fa-floppy-o"></i> Save
                                    </button>
                                </div>
                            </div>

                        </div> <!-- left column ends here -->

                    </div> <!--  main row ends here -->


                </form>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let head_code = document.getElementById("head_code"),
                group = document.getElementById("group"),
                asset_name = document.getElementById("asset_name"),
                expense_group_account = document.getElementById("expense_group_account"),
                expense_parent_account = document.getElementById("expense_parent_account"),
                asset_purchase_price = document.getElementById("asset_purchase_price"),
                residual_value = document.getElementById("residual_value"),
                useful_life = document.getElementById("useful_life"),
                depreciation_percentage = document.getElementById("depreciation_percentage"),
                acquisition_date = document.getElementById("acquisition_date"),
                validateInputIdArray = [
                    head_code.id,
                    group.id,
                    asset_name.id,
                    expense_group_account.id,
                    expense_parent_account.id,
                    asset_purchase_price.id,
                    residual_value.id,
                    useful_life.id,
                    depreciation_percentage.id,
                    acquisition_date.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script>

        jQuery('.account_type').change(function () {

            if ($(".account_type").is(':checked')) {
                if ($(".account_type:checked").val() == 1) {

                    $(".hide_expense_account").show();

                } else {
                    $(".hide_expense_account").hide();
                }
            }
        });


        jQuery(document).ready(function () {
            $(".account_type").trigger("change");
        });


    </script>



    <script type="text/javascript">

        function form_validation() {

            var head_code = $('#head_code').val();
            var group = $('#group').val();
            var asset_name = $('#asset_name').val();
            var asset_purchase_price = $('#asset_purchase_price').val();
            var residual_value = $('#residual_value').val();
            var useful_life = $('#useful_life').val();
            var depreciation_percentage = $('#depreciation_percentage').val();
            var acquisition_date = $('#acquisition_date').val();


            var flag_submit = true;
            var focus_once = 0;

            if (head_code.trim() == "") {
                document.getElementById("head_code_msg").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#head_code").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("head_code_msg").innerHTML = "";
            }

            if (group.trim() == "") {
                document.getElementById("group_msg").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#group").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("group_msg").innerHTML = "";
            }

            if (asset_name.trim() == "") {
                document.getElementById("asset_name_msg").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#asset_name").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("asset_name_msg").innerHTML = "";
            }

            if (asset_purchase_price.trim() == "") {
                document.getElementById("asset_purchase_price_msg").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#asset_purchase_price").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("asset_purchase_price_msg").innerHTML = "";
            }

            if (residual_value.trim() == "") {
                document.getElementById("residual_value_msg").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#residual_value").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("residual_value_msg").innerHTML = "";
            }

            if (useful_life.trim() == "") {
                document.getElementById("useful_life_msg").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#useful_life").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("useful_life_msg").innerHTML = "";
            }

            if (depreciation_percentage.trim() == "") {
                document.getElementById("depreciation_percentage_msg").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#depreciation_percentage").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("depreciation_percentage_msg").innerHTML = "";
            }

            if (acquisition_date.trim() == "") {
                document.getElementById("acquisition_date_msg").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#acquisition_date").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("acquisition_date_msg").innerHTML = "";
            }

            return flag_submit;
        }
    </script>

@endsection

