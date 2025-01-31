@extends('extend_index')

@section('content')

    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">

                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Expense Budget</h4>
                        </div>
                        <div class="list_btn">
                            <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('expense_budget_list') }}" role="button">
                                <i class="fa fa-list"></i> view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->


                <div id="invoice_con" class="gnrl-mrgn-pdng invoice_con for_voucher"><!-- invoice container start -->
                    <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate"><!-- invoice box start -->

                        <form id="f1" action="{{ route('submit_expense_budget') }}" method="post" onsubmit="return checkForm()">
                            @csrf

                            <div class="pd-20">
                                <input type="hidden" id="data" data-company-id=""
                                       data-region-id=""
                                       data-region-action="{{ route('api.regions.options') }}"
                                       data-zone-id=""
                                       data-zone-action="{{ route('api.zones.options') }}"
                                >
                                <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl">
                                    <!-- invoice scroll box start -->
                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt">
                                        <!-- invoice content start -->
                                        <div class="invoice_row">
                                            <div class="invoice_col basis_col_20">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->

                                                        Company
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <div class="invoice_col_short">
                                                            <!-- invoice column short start -->


                                                            <a href="{{ route('receivables_account_registration') }}"
                                                               class="col_short_btn"
                                                               target="_blank"
                                                               data-container="body"
                                                               data-toggle="popover"
                                                               data-trigger="hover"
                                                               data-placement="bottom"
                                                               data-html="true"
                                                               data-content="Add Client Button">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            <a href="{{ route('payables_account_registration') }}"
                                                               class="col_short_btn"
                                                               target="_blank"
                                                               data-container="body"
                                                               data-toggle="popover"
                                                               data-trigger="hover"
                                                               data-placement="bottom"
                                                               data-html="true"
                                                               data-content="Add Supplier Button">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            <a onclick="fetchCompanies($('select#company'));"
                                                               class="col_short_btn">
                                                                <l class="fa fa-refresh"></l>
                                                            </a>
                                                        </div><!-- invoice column short end -->
                                                        <select tabindex="10" name="company" id="company"
                                                                data-fetch-url="{{ route('api.companies.options') }}"
                                                                class="inputs_up form-control auto-select company_dropdown" tabindex="3" data-rule-required="true" data-msg-required="Please Enter
                                                                Company Name"
                                                        >
                                                            <option value="" selected disabled>
                                                                Select Company
                                                            </option>
                                                            @foreach ($companies as $company)
                                                                <option
                                                                    value="{{ $company->account_uid }}"
                                                                    data-company-id="{{ $company->account_uid }}">{{ $company->account_name }}</option>
                                                            @endforeach
                                                        </select>

                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_20">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->

                                                        Project
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input ">
                                                        <!-- invoice column input start -->
                                                        <div class="invoice_col_short">
                                                            <!-- invoice column short start -->

                                                        </div><!-- invoice column short end -->
                                                        <select tabindex="1" autofocus
                                                                name="project"
                                                                id="project"
                                                                data-rule-required="true" data-msg-required="Please Choose Project"
                                                                class="inputs_up form-control">
                                                            <option value="" selected disabled>
                                                                Select Project
                                                            </option>
                                                            {{--                                                            @foreach($projects as $project)--}}
                                                            {{--                                                                <option value="{{$project->proj_id}}" data-grand_total="{{ $project->proj_grand_total }}">{{$project->proj_project_name}}</option>--}}
                                                            {{--                                                            @endforeach--}}
                                                        </select>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_20">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->

                                                        Region
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->

                                                        <div class="invoice_col_short">
                                                            <!-- invoice column short start -->
                                                            <a href="{{ route('regions.create') }}"
                                                               class="col_short_btn"
                                                               target="_blank">
                                                                <i class="fa fa-plus"></i>
                                                            </a>

                                                            <a onclick="$('select#company').trigger('change');"
                                                               class="col_short_btn">
                                                                <l class="fa fa-refresh"></l>
                                                            </a>
                                                        </div><!-- invoice column short end -->
                                                        <select tabindex="11" name="region" id="region"
                                                                class="inputs_up form-control"
                                                                tabindex="4" data-rule-required="true" data-msg-required="Please Enter Region Name">
                                                            <option value="" selected disabled>
                                                                Select Company
                                                                First
                                                            </option>
                                                        </select>

                                                    </div><!-- invoice column input end -->
                                                    <input type="hidden" name="region_id" id="region_id">

                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_18">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->

                                                        Region (Zone)
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->


                                                        <div class="invoice_col_short">
                                                            <!-- invoice column short start -->

                                                            <a href="{{ route('zones.create') }}" class="col_short_btn">
                                                                <l class="fa fa-plus"></l>
                                                            </a>
                                                            <a class="col_short_btn" onclick="$('select#region').trigger('change');">
                                                                <l class="fa fa-refresh"></l>
                                                            </a>
                                                        </div><!-- invoice column short end -->
                                                        <select tabindex="3" name="zone" id="zone" class="custom-select"
                                                                data-rule-required="true" data-msg-required="Please Choose Zone"
                                                        >
                                                            <option value="" selected disabled>Select Region First</option>
                                                        </select>

                                                    </div><!-- invoice column input end -->
                                                    <input type="hidden" name="zone_id" id="zone_id">
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_18">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        Product Name
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->

                                                        <div class="invoice_col_short">
                                                            <!-- invoice column short start -->
                                                            <a href="{{ route('add_product') }}"
                                                               target="_blank"
                                                               class="col_short_btn"
                                                               data-container="body"
                                                               data-toggle="popover"
                                                               data-trigger="hover"
                                                               data-placement="bottom" data-html="true"
                                                               data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            <a id="refresh_product_name"
                                                               class="col_short_btn"
                                                               data-container="body"
                                                               data-toggle="popover"
                                                               data-trigger="hover"
                                                               data-placement="bottom" data-html="true"
                                                               data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                <i class="fa fa-refresh"></i>
                                                            </a>
                                                        </div><!-- invoice column short end -->
                                                        <select tabindex="5" name="product_name"
                                                                class="inputs_up form-control"
                                                                id="product_name"
                                                                data-rule-required="true" data-msg-required="Please Enter Product Name">
                                                            <option value="0">Product Name</option>
                                                        </select>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_10"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <label class="invoice_col_ttl"><!-- invoice column title start -->
                                                        Project Total Amount
                                                    </label><!-- invoice column title end -->
                                                    <div class="invoice_col_txt"><!-- invoice column input start -->
                                                        <h5 class="grandTotalFont" id="projectTotalAmountView">
                                                            0
                                                        </h5>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->
                                            -

                                            <div class="invoice_col basis_col_11"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <label class="invoice_col_ttl"><!-- invoice column title start -->
                                                        Consume Amount
                                                    </label><!-- invoice column title end -->
                                                    <div class="invoice_col_txt"><!-- invoice column input start -->
                                                        <h5 class="grandTotalFont" id="consumeTotalAmountView">
                                                            0
                                                        </h5>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->
                                            =
                                            <div class="invoice_col basis_col_11"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <label class="invoice_col_ttl"><!-- invoice column title start -->
                                                        Remaining Amount
                                                    </label><!-- invoice column title end -->
                                                    <div class="invoice_col_txt"><!-- invoice column input start -->
                                                        <h5 class="grandTotalFont" id="remainingTotalAmountView">
                                                            0
                                                        </h5>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                                <span style="color: red" id="cal_remain"></span>
                                            </div><!-- invoice column end -->


                                            <div class="invoice_col basis_col_10" hidden>
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->

                                                        PO Grand Total
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input ">
                                                        <!-- invoice column input start -->
                                                        <div class="invoice_col_short">
                                                            <!-- invoice column short start -->

                                                        </div><!-- invoice column short end -->
                                                        <input tabindex="2" type="text" name="grand_total"
                                                               class="inputs_up form-control"
                                                               id="grand_total"
                                                               placeholder="Grand Total"
                                                               readonly>

                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_10" hidden>
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->

                                                        Consume Amount
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input ">
                                                        <!-- invoice column input start -->
                                                        <div class="invoice_col_short">
                                                            <!-- invoice column short start -->

                                                        </div><!-- invoice column short end -->
                                                        <input tabindex="3" type="text" name="consume_amount"
                                                               class="inputs_up form-control"
                                                               id="consume_amount"
                                                               placeholder="0.00"
                                                               readonly>

                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_10" hidden>
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->

                                                        Remaining Amount
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input ">
                                                        <!-- invoice column input start -->
                                                        <div class="invoice_col_short">
                                                            <!-- invoice column short start -->

                                                        </div><!-- invoice column short end -->
                                                        <input tabindex="4" type="text" name="remaining_amount"
                                                               class="inputs_up form-control"
                                                               id="remaining_amount"
                                                               placeholder="0.00"
                                                               readonly>

                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->
                                        </div>

                                        <div class="invoice_row"><!-- invoice row start -->

                                            <div class="invoice_col basis_col_20">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->

                                                        Service
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <div class="invoice_col_short">
                                                            <!-- invoice column short start -->

                                                        </div><!-- invoice column short end -->
                                                        <select tabindex="5" name="service"
                                                                class="inputs_up form-control"
                                                                id="service">
                                                            <option value="0" selected disabled>Select
                                                                Service
                                                            </option>
                                                            @foreach ($services as $service)
                                                                <option
                                                                    value="{{ $service->ser_id }}">{{ $service->ser_title }}</option>
                                                            @endforeach

                                                        </select>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_20">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover"
                                                           data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.product.product_barcode.description')}}</p>
                                                         <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.product.product_barcode.benefits')}}</p>">
                                                            <l class="fa fa-info-circle"></l>
                                                        </a>
                                                        Type Of Expense
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <div class="invoice_col_short">
                                                            <!-- invoice column short start -->

                                                        </div><!-- invoice column short end -->
                                                        <select tabindex="5" name="type_of_expense"
                                                                class="inputs_up form-control"
                                                                id="type_of_expense">
                                                            <option value="0" selected disabled>Select
                                                                Expense
                                                            </option>
                                                            @foreach ($expenses as $expense)
                                                                <option
                                                                    value="{{ $expense->account_uid }}">{{ $expense->account_name }}</option>
                                                            @endforeach

                                                        </select>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            {{--                                            <div class="invoice_col basis_col_22">--}}
                                            {{--                                                <!-- invoice column start -->--}}
                                            {{--                                                <div class="invoice_col_bx">--}}
                                            {{--                                                    <!-- invoice column box start -->--}}
                                            {{--                                                    <div class="required invoice_col_ttl">--}}
                                            {{--                                                        <!-- invoice column title start -->--}}

                                            {{--                                                        Party--}}
                                            {{--                                                    </div><!-- invoice column title end -->--}}
                                            {{--                                                    <div class="invoice_col_input">--}}
                                            {{--                                                        <!-- invoice column input start -->--}}

                                            {{--                                                        <div class="invoice_col_short">--}}
                                            {{--                                                            <!-- invoice column short start -->--}}

                                            {{--                                                        </div><!-- invoice column short end -->--}}
                                            {{--                                                        <select name="party[]"--}}
                                            {{--                                                                class="inputs_up form-control party"--}}
                                            {{--                                                                multiple--}}
                                            {{--                                                                id="party">--}}
                                            {{--                                                            <option value="0" disabled>Select party--}}
                                            {{--                                                            </option>--}}
                                            {{--                                                            @foreach ($parties as $party)--}}
                                            {{--                                                                <option--}}
                                            {{--                                                                    value="{{ $party->account_uid }}">{{ $party->account_name }}</option>--}}
                                            {{--                                                            @endforeach--}}

                                            {{--                                                        </select>--}}

                                            {{--                                                    </div><!-- invoice column input end -->--}}
                                            {{--                                                </div><!-- invoice column box end -->--}}
                                            {{--                                            </div><!-- invoice column end -->--}}

                                            <div class="invoice_col basis_col_20">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class=" invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a
                                                            data-container="body" data-toggle="popover"
                                                            data-trigger="hover"
                                                            data-placement="bottom" data-html="true"
                                                            data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p><h6>Benefit</h6><p>{{
                                                        config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p><h6>Example</h6><p>{{
                                                        config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                            <l class="fa fa-info-circle"></l>
                                                        </a>
                                                        Remarks
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input tabindex="6" type="text" name="expense_remarks"
                                                               class="inputs_up form-control"
                                                               id="expense_remarks"
                                                               placeholder="Remarks"
                                                               value="{{old('expense_remarks')}}">
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_7">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover"
                                                           data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.qty.description')}}</p>">
                                                            <l class="fa fa-info-circle"></l>
                                                        </a>
                                                        Limit %
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input tabindex="7" type="text" name="limit_pec"
                                                               class="inputs_up text-center form-control"
                                                               value="{{old('limit_pec')}}"
                                                               id="limit_pec" placeholder="Limit_pec"
                                                        >
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_7">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover"
                                                           data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.qty.description')}}</p>">
                                                            <l class="fa fa-info-circle"></l>
                                                        </a>
                                                        Limit
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input tabindex="8" type="text" name="limit"
                                                               class="inputs_up text-center form-control"
                                                               value="{{old('limit')}}" id="limit"
                                                               placeholder="Limit"
                                                        >
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->


                                            {{--                                                            <div class="invoice_col basis_col_11 "><!-- invoice column start -->--}}
                                            {{--                                                                <div class="invoice_col_bx"><!-- invoice column box start -->--}}
                                            {{--                                                                    <div class="required invoice_col_ttl">--}}
                                            {{--                                                                        <!-- invoice column title start -->--}}
                                            {{--                                                                        Rate--}}
                                            {{--                                                                    </div><!-- invoice column title end -->--}}
                                            {{--                                                                    <div class="invoice_col_input"><!-- invoice column input start -->--}}
                                            {{--                                                                        <input tabindex="9" type="text" name="rate"--}}
                                            {{--                                                                               class="inputs_up text-right form-control" id="rate"--}}
                                            {{--                                                                               value="{{old('rate')}}" placeholder="Rate"--}}
                                            {{--                                                                               onfocus="this.select();"--}}
                                            {{--                                                                               onkeypress="return allow_only_number_and_decimals(this,event);">--}}
                                            {{--                                                                    </div><!-- invoice column input end -->--}}
                                            {{--                                                                </div><!-- invoice column box end -->--}}
                                            {{--                                                            </div><!-- invoice column end -->--}}

                                            {{--                                                            <div class="invoice_col basis_col_11 "><!-- invoice column start -->--}}
                                            {{--                                                                <div class="invoice_col_bx"><!-- invoice column box start -->--}}
                                            {{--                                                                    <div class="required invoice_col_ttl">--}}
                                            {{--                                                                        <!-- invoice column title start -->--}}
                                            {{--                                                                        Amount--}}
                                            {{--                                                                    </div><!-- invoice column title end -->--}}
                                            {{--                                                                    <div class="invoice_col_input"><!-- invoice column input start -->--}}
                                            {{--                                                                        <input tabindex="11" type="text" name="amount"--}}
                                            {{--                                                                               class="inputs_up text-right form-control" id="amount"--}}
                                            {{--                                                                               placeholder="Amount" value="{{old('amount')}}" readonly>--}}
                                            {{--                                                                    </div><!-- invoice column input end -->--}}
                                            {{--                                                                </div><!-- invoice column box end -->--}}
                                            {{--                                                            </div><!-- invoice column end -->--}}

                                            <div class="invoice_col basis_col_18">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_txt for_voucher_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="invoice_col_txt with_cntr_jstfy">
                                                        <div
                                                            class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                            <button tabindex="12" id="first_add_more_ex"
                                                                    class="invoice_frm_btn"
                                                                    onclick="add_expense()"
                                                                    type="button">
                                                                <i class="fa fa-plus"></i> Add
                                                            </button>
                                                        </div>
                                                        <div
                                                            class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                            <button tabindex="13" style="display: none;"
                                                                    id="cancel_button"
                                                                    class="invoice_frm_btn"
                                                                    onclick="cancel_all()"
                                                                    type="button">
                                                                <i class="fa fa-times"></i> Cancel
                                                            </button>
                                                        </div>
                                                        <span id="demo201"
                                                              class="validate_sign"> </span>
                                                    </div>
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                        </div><!-- invoice row end -->

                                        <div class="invoice_row"><!-- invoice row start -->

                                            <div class="invoice_col basis_col_100">
                                                <!-- invoice column start -->
                                                <div class="invoice_row"><!-- invoice row start -->

                                                    <div
                                                        class="invoice_col basis_col_100 gnrl-mrgn-pdng">
                                                        <!-- invoice column start -->
                                                        <div class="pro_tbl_con for_voucher_tbl">
                                                            <!-- product table container start -->
                                                            <div class="pro_tbl_bx">
                                                                <!-- product table box start -->
                                                                <table class="table gnrl-mrgn-pdng"
                                                                       id="category_dynamic_table">
                                                                    <thead>
                                                                    <tr>
                                                                        <th class="text-center tbl_srl_9">
                                                                            Expense Type
                                                                        </th>
                                                                        <th class="text-center tbl_srl_9">
                                                                            Service
                                                                        </th>
                                                                        {{--                                                                        <th class="text-center tbl_txt_20">--}}
                                                                        {{--                                                                            Party--}}
                                                                        {{--                                                                        </th>--}}
                                                                        {{--                                                                    <th class="text-center tbl_srl_20">--}}
                                                                        {{--                                                                        Warehouse--}}
                                                                        {{--                                                                    </th>--}}
                                                                        <th tabindex="-1" class="text-center tbl_txt_38">
                                                                            Expense Remarks
                                                                        </th>
                                                                        <th tabindex="-1" class="text-center tbl_srl_6">
                                                                            Limit %
                                                                        </th>
                                                                        <th tabindex="-1" class="text-center tbl_srl_6">
                                                                            Limit
                                                                        </th>
                                                                        {{--                                                                                        <th tabindex="-1" class="text-center tbl_srl_12">--}}
                                                                        {{--                                                                                            Rate--}}
                                                                        {{--                                                                                        </th>--}}
                                                                        {{--                                                                                        <th tabindex="-1" class="text-center tbl_srl_12">--}}
                                                                        {{--                                                                                            Amount--}}
                                                                        {{--                                                                                        </th>--}}
                                                                    </tr>
                                                                    </thead>

                                                                    <tbody id="table_body">
                                                                    <tr>
                                                                        <td tabindex="-1" colspan="10" align="center">
                                                                            No Entry
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>

                                                                    <tfoot>
                                                                    <tr>
                                                                        <th tabindex="-1" colspan="4"
                                                                            class="text-right">
                                                                            Total Items
                                                                        </th>
                                                                        <td tabindex="-1" class="text-center tbl_srl_12">
                                                                            <div
                                                                                class="invoice_col_txt">
                                                                                <!-- invoice column box start -->
                                                                                <div
                                                                                    class="invoice_col_input">
                                                                                    <!-- invoice column input start -->
                                                                                    <input tabindex="-1" type="text"
                                                                                           name="exp_total_items"
                                                                                           class="inputs_up text-right form-control total-items-field"
                                                                                           id="exp_total_items"
                                                                                           placeholder="0.00"
                                                                                           readonly
                                                                                           data-rule-required="true"
                                                                                           data-msg-required="Please Add"/>
                                                                                </div>
                                                                                <!-- invoice column input end -->
                                                                            </div>
                                                                            <!-- invoice column box end -->
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th colspan="4"
                                                                            class="text-right">
                                                                            Total Price
                                                                        </th>
                                                                        <td class="text-center tbl_srl_12">
                                                                            <div
                                                                                class="invoice_col_txt">
                                                                                <!-- invoice column box start -->
                                                                                <div
                                                                                    class="invoice_col_input">
                                                                                    <!-- invoice column input start -->
                                                                                    <input tabindex="-1" type="text"
                                                                                           name="exp_total_price"
                                                                                           class="inputs_up text-right form-control grand-total-field"
                                                                                           id="exp_total_price"
                                                                                           placeholder="0.00"
                                                                                           readonly/>
                                                                                </div>
                                                                                <!-- invoice column input end -->
                                                                            </div>
                                                                            <!-- invoice column box end -->
                                                                        </td>
                                                                    </tr>
                                                                    </tfoot>

                                                                </table>
                                                            </div><!-- product table box end -->
                                                        </div><!-- product table container end -->
                                                    </div><!-- invoice column end -->


                                                </div><!-- invoice row end -->
                                            </div><!-- invoice column end -->

                                        </div><!-- invoice row end -->

                                        {{--                                                        <div class="invoice_row"><!-- invoice row start -->--}}

                                        {{--                                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->--}}
                                        {{--                                                                <div class="invoice_col_txt with_cntr_jstfy for_voucher_btns">--}}
                                        {{--                                                                    <!-- invoice column box start -->--}}
                                        {{--                                                                    <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">--}}
                                        {{--                                                                        <button tabindex="10" type="submit" name="save" id="save" class="invoice_frm_btn"--}}
                                        {{--                                                                            --}}{{--                                                            onclick="return popvalidation()"--}}
                                        {{--                                                                        >--}}
                                        {{--                                                                            <i class="fa fa-floppy-o"></i> Save--}}
                                        {{--                                                                        </button>--}}
                                        {{--                                                                        <span id="demo28" class="validate_sign"></span>--}}
                                        {{--                                                                    </div>--}}
                                        {{--                                                                </div><!-- invoice column box end -->--}}
                                        {{--                                                            </div><!-- invoice column end -->--}}


                                        {{--                                                        </div><!-- invoice row end -->--}}
                                        <div class="invoice_row"><!-- invoice row start -->

                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                <div class="invoice_col_txt with_cntr_jstfy for_voucher_btns"><!-- invoice column box start -->
                                                    <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                        <button type="submit" name="save" id="save" class="invoice_frm_btn">
                                                            <i class="fa fa-floppy-o"></i> Save
                                                        </button>
                                                    </div>
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                        </div><!-- invoice row end -->
                                    </div><!-- invoice content end -->
                                </div><!-- invoice scroll box end -->

                                <input type="hidden" name="expense_array" id="expense_array">
                            </div>

                        </form>

                    </div><!-- invoice box end -->
                </div><!-- invoice container end -->


            </div> <!-- white column form ends here -->

        </div><!-- col end -->


    </div><!-- row end -->


    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Cash Receipt Voucher Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div id="table_body">

                    </div>
                    <div id="hello"></div>

                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form_controls">
                            <button type="button" class="btn btn-default form-control cancel_button" data-dismiss="modal">
                                <i class="fa fa-times"></i> Cancel
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let company = document.getElementById("company"),
                project = document.getElementById("project"),
                zone = document.getElementById("zone"),
                region = document.getElementById("region"),
                product_name = document.getElementById("product_name"),
                exp_total_items = document.getElementById("exp_total_items"),
                validateInputIdArray = [
                    company.id,
                    project.id,
                    zone.id,
                    region.id,
                    product_name.id,
                    exp_total_items.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script>
        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                $("#first_add_more").click();
                // event.preventDefault();
                return false;
            }
        });
    </script>
    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#project").select2();
            jQuery("#company").select2();
            jQuery("#region").select2();
            jQuery("#product_name").select2();
            jQuery("#service").select2();
            jQuery("#zone").select2();
            jQuery("#type_of_expense").select2();
            // jQuery("#party").select2();
        });
    </script>

    {{--    Start expense budget script--}}

    <script>

        // adding packs into table
        var numberofexpenses = 0;
        var counter = 0;
        var expenses = {};
        var global_id_to_edit = 0;
        var edit_expense_value = '';


        function add_expense() {

            var service = document.getElementById("service").value;
            var type_of_expense = document.getElementById("type_of_expense").value;
            // var party = document.getElementById("party").value;

            // var party = $('.party').val();

            // var party_name = $('#party option:selected')
            // .toArray().map(party => party.text);

            var expense_remarks = document.getElementById("expense_remarks").value;
            var limit = document.getElementById("limit").value;
            var limit_pec = document.getElementById("limit_pec").value;


            var flag_submit1 = true;
            var focus_once1 = 0;

            if (type_of_expense == "0") {

                if (focus_once1 == 0) {
                    jQuery("#type_of_expense").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            // if (party == "0") {
            //
            //     if (focus_once1 == 0) {
            //         jQuery("#party").focus();
            //         focus_once1 = 1;
            //     }
            //     flag_submit1 = false;
            // }


            if (limit == 0 || limit == null) {

                if (focus_once1 == 0) {
                    jQuery("#limit").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (limit_pec == 0 || limit_pec == '') {

                if (focus_once1 == 0) {
                    jQuery("#limit_pec").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (flag_submit1) {

                if (global_id_to_edit != 0) {
                    jQuery("#" + global_id_to_edit).remove();

                    delete expenses[global_id_to_edit];
                }

                counter++;

                jQuery("#service").select2("destroy");
                jQuery("#type_of_expense").select2("destroy");
                jQuery("#party").select2("destroy");

                var expense_type = jQuery("#type_of_expense option:selected").text();
                var service_name = jQuery("#service option:selected").text();
                // var party_name = jQuery("#party option:selected").text();


                numberofexpenses = Object.keys(expenses).length;

                if (numberofexpenses == 0) {
                    jQuery("#table_body").html("");
                }


                expenses[counter] = {
                    'service': service,
                    'service_name': service_name,
                    'type_of_expense': type_of_expense,
                    'expense_type': expense_type,
                    // 'party': party,
                    // 'party_name': party_name,
                    'expense_remarks': expense_remarks,
                    'limit': limit,
                    'limit_pec': limit_pec,
                };

                jQuery("#type_of_expense option[value=" + type_of_expense + "]").attr("disabled", "true");
                // jQuery("#party option[value=" + party + "]").attr("disabled", "true");
                numberofexpenses = Object.keys(expenses).length;
                jQuery("#exp_total_items").val(numberofexpenses);

                // <td class="text-left tbl_txt_20">' + party_name + '</td>
                jQuery("#table_body").append(
                    '<tr id=' + counter + ' class="edit_update"><td class="text-center tbl_srl_9">' + service_name + '</td><td class="text-center tbl_srl_9">' + expense_type + '</td><td class="text-left tbl_txt_38">' + expense_remarks + '</td><td class="text-left tbl_txt_6">' + limit_pec + '</td><td class="text-right tbl_srl_6">' + limit + '<div class="edit_update_bx"><a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_expense(' + counter + ')><i class="fa fa-edit"></i></a> <a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_expense(' + counter + ')><i class="fa fa-trash"></i></a></div></td></tr>');


                jQuery('#service option[value="' + 0 + '"]').prop('selected', true);
                jQuery('#type_of_expense option[value="' + 0 + '"]').prop('selected', true);
                // $("#party option:selected").prop("selected", false)
                // jQuery('#party').select2('val', '0');


                jQuery("#limit").val("");
                jQuery("#limit_pec").val("");
                jQuery("#expense_remarks").val("");


                jQuery("#expense_array").val(JSON.stringify(expenses));
                jQuery("#cancel_button").hide();
                jQuery(".table-responsive").show();
                jQuery("#save").show();
                jQuery("#first_add_more_ex").html('<i class="fa fa-plus"></i>  Add');

                jQuery("#total_items").val(numberofexpenses);

                jQuery("#service").select2();
                jQuery("#type_of_expense").select2();
                // jQuery("#party").select2();


                jQuery(".edit_link").show();
                jQuery(".delete_link").show();
                grand_total_calculation_expense();
                calculate_remaining_amount();
            }
        }


        function delete_expense(current_item) {

            jQuery("#" + current_item).remove();
            var temp_expenses = expenses[current_item];

            jQuery("#type_of_expense option[value=" + temp_expenses['type_of_expense'] + "]").attr("disabled", false);
            // jQuery("#party option[value=" + temp_expenses['party'] + "]").attr("disabled", false);

            jQuery("#type_of_expense").select2();
            // jQuery("#party").select2();


            delete expenses[current_item];

            function isEmpty(obj) {

                for (var key in obj) {

                    if (obj.hasOwnProperty(key))
                        return false;
                }
                return true;
            }

            numberofexpenses = Object.keys(expenses).length;
            jQuery("#expense_array").val(JSON.stringify(expenses));
            jQuery("#exp_total_items").val(numberofexpenses);

            // if (isEmpty(expenses)) {
            //     numberofexpenses = 0;
            // }

            grand_total_calculation_expense();
            calculate_remaining_amount();
            // calculate();
            // jQuery("#exp_total_items").val(numberofexpenses);


        }

        function edit_expense(current_item) {

            jQuery("#save").attr("style", "display:none");
            jQuery("#first_add_more_ex").html('<i class="fa fa-plus"></i> update');
            jQuery("#cancel_button").show();


            jQuery(".edit_link").hide();
            jQuery(".delete_link").hide();

            global_id_to_edit = current_item;

            var temp_expenses = expenses[current_item];

            var get_expenses_amount = temp_expenses['limit'];

            edit_expense_value = temp_expenses['type_of_expense'];

            jQuery("#service").select2("destroy");
            jQuery("#type_of_expense").select2("destroy");
            // jQuery("#party").select2("destroy");


            jQuery("#type_of_expense option[value=" + temp_expenses['type_of_expense'] + "]").attr("disabled", false);
            // jQuery("#party option[value=" + temp_expenses['party'] + "]").attr("disabled", false);

            jQuery('#type_of_expense option[value="' + temp_expenses['type_of_expense'] + '"]').prop('selected', true);
            jQuery('#service option[value="' + temp_expenses['service'] + '"]').prop('selected', true);

            // var value = temp_expenses['party'];

            // for (var i = 0; i < value.length; i++) {
            //     jQuery('#party option[value="' + value[i] + '"]').prop('selected', true);
            //     // jQuery("#party").select2();
            // }

            // jQuery('#party option[value="' + temp_expenses['party'] + '"]').prop('selected', true);


            jQuery("#limit").val(temp_expenses['limit']);
            jQuery("#limit_pec").val(temp_expenses['limit_pec']);

            jQuery("#expense_remarks").val(temp_expenses['expense_remarks']);

            jQuery("#service").select2();
            jQuery("#type_of_expense").select2();
            // jQuery("#party").select2();


            jQuery("#cancel_button").attr("style", "display:inline");
            jQuery("#cancel_button").attr("style", "background-color:red !important");
        }

        function cancel_all() {

            // var newvaltohide = jQuery("#product_code").val();

            var newvaltohide = edit_expense_value;

            var temp_expenses = expenses[global_id_to_edit];

            var get_expenses_amount = temp_expenses['limit'];


            jQuery("#type_of_expense option[value=" + newvaltohide + "]").attr("disabled", "true");

            jQuery('#service option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#type_of_expense option[value="' + 0 + '"]').prop('selected', true);

            jQuery("#service").select2("destroy");
            jQuery("#type_of_expense").select2("destroy");

            jQuery("#expense_remarks").val("");
            // jQuery("#quantity").val("");
            jQuery("#limit_pec").val("");
            jQuery("#limit").val("");

            jQuery("#service").select2();
            jQuery("#type_of_expense").select2();

            jQuery("#cancel_button").hide();
            jQuery(".table-responsive").show();
            jQuery("#save").show();
            jQuery("#first_add_more_ex").html('Add');

            global_id_to_edit = 0;


            jQuery(".edit_link").show();
            jQuery(".delete_link").show();

            edit_expense_value = '';
        }
    </script>
    <script>
        function grand_total_calculation_expense() {
            var total_price = 0;

            total_discount = 0;

            jQuery.each(expenses, function (index, value) {
                total_price = +total_price + +value['limit'];
            });

            jQuery("#exp_total_price").val(total_price);
        }
    </script>
    <script>
        jQuery("#project").change(function () {

            var project = $("#project").val();
            $('#product_name option[value="' + project + '"]').prop('selected', true);

            var grand_total = $('option:selected', this).attr('data-expense_total');
            jQuery("#grand_total").val(grand_total);
            document.getElementById("projectTotalAmountView").innerHTML = grand_total;

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_expense_amount",
                data: {project: project},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {
                    // console.log(data.calculated_amount);
                    jQuery("#remaining_amount").html(" ");
                    jQuery("#consume_amount").html(" ");
                    jQuery("#consume_amount").val(data.calculated_amount);

                    var amount = data.calculated_amount;
                    var remaining_amount = grand_total - amount;
                    document.getElementById("consumeTotalAmountView").innerHTML = data.calculated_amount;
                    document.getElementById("remainingTotalAmountView").innerHTML = remaining_amount;
                    jQuery("#remaining_amount").val(remaining_amount);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                }
            });

        });
    </script>
    <script>
        $("#limit_pec").keyup(function () {
            var grand_total = $("#grand_total").val();

            var limit_pec = $("#limit_pec").val();

            var price = (limit_pec * grand_total) / 100;

            $("#limit").val(price);
        });
        $("#limit").keyup(function () {
            var grand_total = $("#grand_total").val();

            var limit = $("#limit").val();

            var percentage = (limit / grand_total) * 100;

            $("#limit_pec").val(percentage.toFixed(2));
        });
    </script>
    {{--    end expense budget script--}}
    <script>
        $('#company').change(function () {
            var company = $(this).val();

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_projects",
                data: {company: company},
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    var option = "<option value='' disabled selected>Select Project</option>";

                    $.each(data.projects, function (index, value) {
                        option += "<option value='" + value.proj_id + "' data-grand_total='" + value.proj_grand_total + "' data-expense_total='" + value.proj_expense_amount + "'>" + value
                            .proj_project_name + "</option>";
                    });

                    jQuery("#project").html(" ");
                    jQuery("#project").append(option);
                    jQuery("#project").select2();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

    </script>
    <script>
        function calculate_remaining_amount() {
            var total_price = $('#exp_total_price').val();
            var consume_amount = $('#consume_amount').val();
            var remaining_amount = $('#remaining_amount').val();

            consume_amount = +consume_amount + +total_price;
            remaining_amount = remaining_amount - total_price;

            document.getElementById("consumeTotalAmountView").innerHTML = consume_amount.toFixed(2);
            document.getElementById("remainingTotalAmountView").innerHTML = remaining_amount.toFixed(2);

        }
        $('#region').change(function () {
            var region = $('option:selected', this).attr('data-region-id');
            $('#region_id').val('');
            $('#region_id').val(region);
        });
    </script>

    <script>
        $('#zone').change(function () {
            var zone = $('#region').find(':selected').attr('data-region-id');

            var region = $('option:selected', this).attr('data-zone-id');
            var project = $('#project').val();

            $('#region_id').val('');
            $('#region_id').val(region);
            $('#zone_id').val('');
            $('#zone_id').val(zone);
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_region_product",
                data: {zone: zone,region: region, project: project},
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    console.log(data.products);

                    var option = "<option value='' disabled selected>Select Product Name</option>";

                    $.each(data.products, function (index, value) {
                        option += "<option value='" + value.pro_p_code + "' data-parent='" + value.pro_p_code + "' data-sale_price='" + value.opi_rate + "' data-tax='" + value.pro_tax + "'data-retailer_dis='" + value.pro_retailer_discount + "' data-whole_saler_dis='" + value.pro_whole_seller_discount + "' data-loyalty_dis='" + value.pro_loyalty_card_discount + "' data-unit='" + value.unit_title + "'>" + value.pro_title + "</option>";
                    });


                    // jQuery("#material_product_code").html(" ");
                    // jQuery("#material_product_code").append(option_code);
                    jQuery("#product_name").html(" ");
                    jQuery("#product_name").append(option);
                    jQuery("#product_name").select2();
                    // jQuery("#material_product_code").select2();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });
    </script>
@endsection
