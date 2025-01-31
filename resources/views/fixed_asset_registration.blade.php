@extends('extend_index')

@section('content')

    <div class="row">
            <div class="container-fluid search-filter form-group form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Fixed Asset Registration</h4>
                        </div>
                        <div class="list_btn">
                            <a class="btn list_link add_more_button" href="{{ route('fixed_asset_list') }}" role="button">
                                <i class="fa fa-list"></i> view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <div class="excel_con gnrl-mrgn-pdng gnrl-blk">
                    <div class="excel_box gnrl-mrgn-pdng gnrl-blk">
                        <div class="excel_box_hdng gnrl-mrgn-pdng gnrl-blk">
                            <h2 class="gnrl-blk gnrl-mrgn-pdng gnrl-font-bold">
                                Upload Excel File
                            </h2>
                        </div>
                        <div class="excel_box_content gnrl-mrgn-pdng gnrl-blk">

                            <form action="{{ route('submit_fixed_asset_excel') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="required">
                                                Select Excel File
                                            </label>
                                            <input tabindex="100" type="file" name="add_fixed_asset_excel" id="add_fixed_asset_pattern_excel" class="inputs_up form-control-file form-control height-auto"
                                                   accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                        </div><!-- end input box -->
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                        <a href="{{ url('public/sample/fixed_asset/add_fixed_asset_pattern.xlsx') }}" tabindex="-1" type="reset" class="cancel_button btn btn-sm btn-info">
                                            Download Sample Pattern
                                        </a>
                                        <button tabindex="101" type="submit" name="save" id="save2" class="save_button btn btn-sm btn-success">
                                            <i class="fa fa-floppy-o"></i> Save
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                <form action="{{ route('submit_fixed_asset') }}" onsubmit="return checkForm()" method="post" autocomplete="off" id="f1">
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
                                            <a href="{{ route('add_third_level_chart_of_account') }}" class="add_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                <l class="fa fa-plus"></l>
                                            </a>
                                            <a id="refresh_asset_parent_account" class="add_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                <l class="fa fa-refresh"></l>
                                            </a>
                                        </label>
                                        <select tabindex=1 autofocus name="head_code" class="inputs_up form-control" id="head_code" data-rule-required="true" data-msg-required="Please Enter Asset Parent Account">
                                            <option value="">Select Asset Parent Account</option>
                                            @foreach($fixed_assets as $fixed_asset)
                                                <option value="{{$fixed_asset->coa_code}}" {{$fixed_asset->coa_code == old('head_code') ? 'selected="selected"' : ''}}>{{$fixed_asset->coa_head_name}}</option>
                                            @endforeach

                                        </select>
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
                                            <a href="{{ route('add_account_group') }}" class="add_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                <l class="fa fa-plus"></l>
                                            </a>
                                            <a id="refresh_group" class="add_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                <l class="fa fa-refresh"></l>
                                            </a>
                                        </label>
                                        <select tabindex="2" name="group" class="inputs_up form-control" id="group" data-rule-required="true" data-msg-required="Please Enter Account Ledger Access Group">
                                            <option value="">Select  Account Ledger Access Group</option>
                                            @foreach($groups as $group)
                                                <option value="{{$group->ag_id}}" {{$group->ag_id  == old('group') ? 'selected="selected"' : ''}}>{{$group->ag_title}}</option>
                                            @endforeach

                                        </select>
                                        <span id="group_msg" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-4 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">Asset Name</label>
                                        <input tabindex="3" type="text" name="account_name" id="asset_name" class="inputs_up form-control" data-rule-required="true" data-msg-required="Please Enter Asset Name" value="{{old('account_name')}}" placeholder="Asset Name"/>
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
                                        <input tabindex="4" type="text" name="asset_registration_no" id="asset_registration_no" value="{{old('asset_registration_no')}}" class="inputs_up form-control" placeholder="Asset Register #"/>
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
                                        <input tabindex="5" type="text" name="importer_supplier_detail" id="importer_supplier_detail" value="{{old('importer_supplier_detail')}}" class="inputs_up form-control" placeholder="Importer/Supplier Detail"/>
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
                                        <input tabindex="6" type="text" name="asset_guarantee_period" id="asset_guarantee_period" value="{{old('asset_guarantee_period')}}" class="inputs_up form-control" placeholder="Asset Guarantee Period"/>
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
                                        <input tabindex="7" type="text" name="asset_specification" id="asset_specification" value="{{old('asset_specification')}}" class="inputs_up form-control" placeholder="Asset Specification"/>
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
                                        <input tabindex="8" type="text" name="asset_capacity" id="asset_capacity" value="{{old('asset_capacity')}}" class="inputs_up form-control" placeholder="Asset Capacity"/>
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
                                        <input tabindex="9" type="text" name="asset_size" id="asset_size" class="inputs_up form-control" placeholder="Asset Size" value="{{old('asset_size')}}"/>
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
                                            <input tabindex="10" type="radio" id="straight_balance" name="method" value="1"{{ old('method')== 1  ? 'checked' : '' }} class="custom-control-input" checked>
                                            <label class="custom-control-label" for="straight_balance">
                                                Straight Balance
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio mb-5 mt-1">
                                            <input tabindex="11" type="radio" id="reducing_balance" name="method" value="2"{{ old('method')== 2  ? 'checked' : '' }} class="custom-control-input">
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
                                            <input tabindex="12" type="radio" id="depreciation" name="account_type" value="1"{{ old('account_type')== 2  ? 'checked' : '' }} class="custom-control-input account_type" checked>
                                            <label class="custom-control-label" for="depreciation">
                                                Depreciation
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio mb-5 mt-1">
                                            <input tabindex="13" type="radio" id="amortization" name="account_type" value="2"{{ old('account_type')== 2  ? 'checked' : '' }} class="custom-control-input account_type" disabled>
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
                                        <select tabindex="14" name="expense_group_account" class="inputs_up form-control" id="expense_group_account" data-rule-required="true" data-msg-required="Please Enter Depreciation Parent Account">
                                            <option value="">Select Parent Account</option>
                                            @foreach($expense_heads as $expense_head)
                                                <option value="{{$expense_head->coa_code}}" {{$expense_head->coa_code  == old('expense_group_account') ? 'selected="selected"' : ''}}>{{$expense_head->coa_head_name}}</option>
                                            @endforeach

                                        </select>
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
                                        <select tabindex="15" name="expense_parent_account" class="inputs_up form-control" id="expense_parent_account"  data-rule-required="true" data-msg-required="Please Enter  Depreciation Child Account">
                                            <option value="">Select Child Account</option>
                                        </select>
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
                                        <input tabindex="16" type="text" name="asset_purchase_price" id="asset_purchase_price" value="{{old('asset_purchase_price')}}" class="inputs_up form-control" placeholder="Asset Purchase Price"  data-rule-required="true" data-msg-required="Please Enter Asset Purchase Price"
                                               onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/>
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
                                        <input tabindex="17" type="text" name="residual_value" id="residual_value" value="{{old('residual_value')}}" onkeypress="return allow_only_number_and_decimals(this,event);"  data-rule-required="true" data-msg-required="Please Enter Residual Value" class="inputs_up form-control" placeholder="Residual Value"/>
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
                                            Useful Life In Year(s)</label>
                                        <input tabindex="18" type="text" name="useful_life" id="useful_life" value="{{old('useful_life')}}" onfocusout="change('out')"  data-rule-required="true" data-msg-required="Please Enter Useful Life In Year" class="inputs_up form-control" placeholder="Useful Life In Year(s)"/>
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
                                            Execute Depreciation</label>
                                        <div class="custom-control custom-radio mb-5 mt-1">
                                            <input tabindex="19" type="radio" id="per_annum" name="depreciation_percentage_radio" value="1"{{ old('depreciation_percentage_radio')== 1  ? 'checked' : '' }} class="custom-control-input" >
                                            <label class="custom-control-label" for="per_annum">
                                                Per Annum
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio mb-5 mt-1">
                                            <input tabindex="20" type="radio" id="per_monthly" name="depreciation_percentage_radio" value="2"{{ old('depreciation_percentage_radio')== 2  ? 'checked' : '' }} class="custom-control-input" checked>
                                            <label class="custom-control-label" for="per_monthly">
                                                Per Monthly
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio mb-5 mt-1">
                                            <input tabindex="21" type="radio" id="daily_basis" name="depreciation_percentage_radio" value="3"{{ old('depreciation_percentage_radio')== 3  ? 'checked' : '' }} class="custom-control-input">
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
                                            Depreciation % Per Year</label>
                                        <input tabindex="22" type="text" name="depreciation_percentage" id="depreciation_percentage" data-rule-required="true" data-msg-required="Please Enter Depreciation % Per Year"  value="{{old('depreciation_percentage')}}" class="inputs_up form-control"  placeholder="Depreciation % Per Year" readonly>
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
                                            Posting Auto/Manual</label>
                                        <div class="custom-control custom-radio mb-5 mt-1">
                                            <input tabindex="23" type="radio" id="auto_posting" name="posting_method" value="1"{{ old('posting_method')== 1  ? 'checked' : '' }} class="custom-control-input" checked>
                                            <label class="custom-control-label" for="auto_posting">
                                                Auto
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio mb-5 mt-1">
                                            <input tabindex="24" type="radio" id="manual_posting" name="posting_method" value="2"{{ old('posting_method')== 2  ? 'checked' : '' }} class="custom-control-input">
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
                                            Acquisition Date</label>
                                        <input tabindex="25" type="text" name="acquisition_date" id="acquisition_date"  data-rule-required="true" data-msg-required="Please Enter Acquisition Date" value="{{old('acquisition_date')}}" class="inputs_up form-control date-picker" placeholder="Acquisition Date"/>
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
                                        <textarea tabindex="26" name="remarks" id="remarks" class="remarks inputs_up form-control" placeholder="Remarks">{{old('remarksFselect')}}</textarea>
                                        <span id="remarks_msg" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    <button tabindex="27" type="reset" name="cancel" id="cancel" class="cancel_button btn btn-sm btn-info">
                                        <i class="fa fa-eraser"></i> Cancel
                                    </button>
                                    <button tabindex="28" type="submit" name="save" id="save" class="save_button btn btn-sm btn-success">
                                        <i class="fa fa-floppy-o"></i> Save
                                    </button>
                                </div>
                            </div>
                        </div> <!-- left column ends here -->
                    </div> <!--  main row ends here -->
                </form>
            </div> <!-- white column form ends here -->
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

        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });


        jQuery("#refresh_asset_parent_account").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_fixed_assets",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#head_code").html(" ");
                    jQuery("#head_code").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                    alert(errorThrown);}
            });
        });

        jQuery("#refresh_group").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_reporting_group",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#group").html(" ");
                    jQuery("#group").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                }
            });
        });

        jQuery("#refresh_expense_heads").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "refresh_expense_head",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#expense_group_account").html(" ");
                    jQuery("#expense_group_account").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                    alert(errorThrown);}
            });
        });

        jQuery("#refresh_expense_parent_account").change(function () {

            var dropDown = document.getElementById('expense_group_account');
            var second_head_code = dropDown.options[dropDown.selectedIndex].value;

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                // url: "refresh_expense_parent_account",
                url: "refresh_second_head",
                data: {second_head_code: second_head_code},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#expense_parent_account").html("");
                    jQuery("#expense_parent_account").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);
                }
            });
        });


    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#head_code").select2();
            jQuery("#group").select2();
            jQuery("#expense_group_account").select2();
            jQuery("#expense_parent_account").select2();


        });

        $('#acquisition_date').datepicker({

            // minDate: new Date()
            minDate: new Date("{!! $dayend_date !!}")
        });

    </script>
    <script type="text/javascript">
      function change(){

        var useful_life = document.getElementById('useful_life').value;
       var percentage =  100 / useful_life;

        console.log(useful_life);
      document.getElementById('depreciation_percentage').value = percentage.toFixed(2);
        // useful_life.value - 100 = document.getElementById('depreciation_percentage').value;

      }


        // function form_validation() {
        //
        //     var head_code = $('#head_code').val();
        //     var group = $('#group').val();
        //     var asset_name = $('#asset_name').val();
        //     var expense_group_account = $('#expense_group_account').val();
        //     var expense_parent_account = $('#expense_parent_account').val();
        //     var asset_purchase_price = $('#asset_purchase_price').val();
        //     var residual_value = $('#residual_value').val();
        //     var useful_life = $('#useful_life').val();
        //     var depreciation_percentage = $('#depreciation_percentage').val();
        //     var acquisition_date = $('#acquisition_date').val();
        //
        //
        //     var flag_submit = true;
        //     var focus_once = 0;
        //
        //     if (head_code.trim() == "") {
        //         document.getElementById("head_code_msg").innerHTML = "Required";
        //         if (focus_once == 0) {
        //             jQuery("#head_code").focus();
        //             focus_once = 1;
        //         }
        //         flag_submit = false;
        //     } else {
        //         document.getElementById("head_code_msg").innerHTML = "";
        //     }
        //
        //     if (group.trim() == "") {
        //         document.getElementById("group_msg").innerHTML = "Required";
        //         if (focus_once == 0) {
        //             jQuery("#group").focus();
        //             focus_once = 1;
        //         }
        //         flag_submit = false;
        //     } else {
        //         document.getElementById("group_msg").innerHTML = "";
        //     }
        //
        //     if (asset_name.trim() == "") {
        //         document.getElementById("asset_name_msg").innerHTML = "Required";
        //         if (focus_once == 0) {
        //             jQuery("#asset_name").focus();
        //             focus_once = 1;
        //         }
        //         flag_submit = false;
        //     } else {
        //         document.getElementById("asset_name_msg").innerHTML = "";
        //     }
        //
        //     if ($(".account_type").is(':checked')) {
        //         if ($(".account_type:checked").val() == 1) {
        //
        //             if (expense_group_account.trim() == "") {
        //                 document.getElementById("expense_group_account_msg").innerHTML = "Required";
        //                 if (focus_once == 0) {
        //                     jQuery("#expense_group_account").focus();
        //                     focus_once = 1;
        //                 }
        //                 flag_submit = false;
        //             } else {
        //                 document.getElementById("expense_group_account_msg").innerHTML = "";
        //             }
        //
        //             if (expense_parent_account.trim() == "") {
        //                 document.getElementById("expense_parent_account_msg").innerHTML = "Required";
        //                 if (focus_once == 0) {
        //                     jQuery("#expense_parent_account").focus();
        //                     focus_once = 1;
        //                 }
        //                 flag_submit = false;
        //             } else {
        //                 document.getElementById("expense_parent_account_msg").innerHTML = "";
        //             }
        //
        //         } else {
        //             document.getElementById("expense_group_account_msg").innerHTML = "";
        //             document.getElementById("expense_parent_account_msg").innerHTML = "";
        //         }
        //     }
        //
        //
        //     if (asset_purchase_price.trim() == "") {
        //         document.getElementById("asset_purchase_price_msg").innerHTML = "Required";
        //         if (focus_once == 0) {
        //             jQuery("#asset_purchase_price").focus();
        //             focus_once = 1;
        //         }
        //         flag_submit = false;
        //     } else {
        //         document.getElementById("asset_purchase_price_msg").innerHTML = "";
        //     }
        //
        //     if (residual_value.trim() == "") {
        //         document.getElementById("residual_value_msg").innerHTML = "Required";
        //         if (focus_once == 0) {
        //             jQuery("#residual_value").focus();
        //             focus_once = 1;
        //         }
        //         flag_submit = false;
        //     } else {
        //         document.getElementById("residual_value_msg").innerHTML = "";
        //     }
        //
        //     if (useful_life.trim() == "") {
        //         document.getElementById("useful_life_msg").innerHTML = "Required";
        //         if (focus_once == 0) {
        //             jQuery("#useful_life").focus();
        //             focus_once = 1;
        //         }
        //         flag_submit = false;
        //     } else {
        //         document.getElementById("useful_life_msg").innerHTML = "";
        //     }
        //
        //     if (depreciation_percentage.trim() == "") {
        //         document.getElementById("depreciation_percentage_msg").innerHTML = "Required";
        //         if (focus_once == 0) {
        //             jQuery("#depreciation_percentage").focus();
        //             focus_once = 1;
        //         }
        //         flag_submit = false;
        //     } else {
        //         document.getElementById("depreciation_percentage_msg").innerHTML = "";
        //     }
        //
        //     if (acquisition_date.trim() == "") {
        //         document.getElementById("acquisition_date_msg").innerHTML = "Required";
        //         if (focus_once == 0) {
        //             jQuery("#acquisition_date").focus();
        //             focus_once = 1;
        //         }
        //         flag_submit = false;
        //     } else {
        //         document.getElementById("acquisition_date_msg").innerHTML = "";
        //     }
        //
        //     return flag_submit;
        // }
    </script>


    <script>



        jQuery("#expense_group_account").change(function () {

            var dropDown = document.getElementById('expense_group_account');
            var second_head_code = dropDown.options[dropDown.selectedIndex].value;

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_head",
                data: {second_head_code: second_head_code},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#expense_parent_account").html("");
                    jQuery("#expense_parent_account").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);
                }
            });
        });


        jQuery('.account_type').change(function () {

            if ($(".account_type").is(':checked')) {
                if ($(".account_type:checked").val() == 1) {

                    $(".hide_expense_account").show();

                } else {
                    $("#expense_group_account").select2().val(null).trigger("change");
                    $("#expense_group_account > option").removeAttr('selected');

                    $(".hide_expense_account").hide();
                }
            }
        });

    </script>

@endsection

