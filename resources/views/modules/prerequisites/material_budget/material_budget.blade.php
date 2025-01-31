@extends('extend_index')

@section('content')

    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">

                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Material Budget</h4>
                        </div>
                        <div class="list_btn">
                            <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('material_budget_list') }}" role="button">
                                <i class="fa fa-list"></i> view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->


                <div id="invoice_con" class="gnrl-mrgn-pdng invoice_con for_voucher"><!-- invoice container start -->
                    <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate"><!-- invoice box start -->

                        <form id="f1" action="{{ route('submit_material_budget') }}" method="post" onsubmit="return checkForm()">
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

                                        <div class="invoice_row"><!-- invoice row start -->

                                            <div class="invoice_col basis_col_13"><!-- invoice column start -->
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

                                            <div class="invoice_col basis_col_13"><!-- invoice column start -->
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
                                            <div class="invoice_col basis_col_13"><!-- invoice column start -->
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


                                            <div class="invoice_col basis_col_15" hidden>
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

                                            <div class="invoice_col basis_col_15" hidden>
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

                                            <div class="invoice_col basis_col_15" hidden>
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


                                            <!--- Total Quantity Display -->

                                            <div class="invoice_col basis_col_13" style="margin-left: 240px;"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <label class="invoice_col_ttl"><!-- invoice column title start -->
                                                        Total QTY
                                                    </label><!-- invoice column title end -->
                                                    <div class="invoice_col_txt"><!-- invoice column input start -->
                                                        <h5 class="grandTotalFont" id="totalQtyView">
                                                            0
                                                        </h5>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->
                                            -

                                            <div class="invoice_col basis_col_13"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <label class="invoice_col_ttl"><!-- invoice column title start -->
                                                        Consume QTY
                                                    </label><!-- invoice column title end -->
                                                    <div class="invoice_col_txt"><!-- invoice column input start -->
                                                        <h5 class="grandTotalFont" id="consumeTotalQtyView">
                                                            0
                                                        </h5>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->
                                            =
                                            <div class="invoice_col basis_col_13"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <label class="invoice_col_ttl"><!-- invoice column title start -->
                                                        Remaining QTY
                                                    </label><!-- invoice column title end -->
                                                    <div class="invoice_col_txt"><!-- invoice column input start -->
                                                        <h5 class="grandTotalFont" id="remainingTotalQtyView">
                                                            0
                                                        </h5>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                                <span style="color: red" id="cal_remain"></span>
                                            </div><!-- invoice column end -->


                                            <div class="invoice_col basis_col_15" hidden>
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->

                                                        Total QTY
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input ">
                                                        <!-- invoice column input start -->
                                                        <div class="invoice_col_short">
                                                            <!-- invoice column short start -->

                                                        </div><!-- invoice column short end -->
                                                        <input tabindex="2" type="text" name="total_qty"
                                                               class="inputs_up form-control"
                                                               id="total_qty"
                                                               placeholder="Total QTY"
                                                               readonly>

                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_15" hidden>
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->

                                                        Consume QTY
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input ">
                                                        <!-- invoice column input start -->
                                                        <div class="invoice_col_short">
                                                            <!-- invoice column short start -->

                                                        </div><!-- invoice column short end -->
                                                        <input tabindex="3" type="text" name="consume_qty"
                                                               class="inputs_up form-control"
                                                               id="consume_qty"
                                                               placeholder="0.00"
                                                               readonly>

                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_15" hidden>
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->

                                                        Remaining QTY
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input ">
                                                        <!-- invoice column input start -->
                                                        <div class="invoice_col_short">
                                                            <!-- invoice column short start -->

                                                        </div><!-- invoice column short end -->
                                                        <input tabindex="4" type="text" name="remaining_qty"
                                                               class="inputs_up form-control"
                                                               id="remaining_qty"
                                                               placeholder="0.00"
                                                               readonly>

                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                        </div> <!-- invoice column end -->

                                        <div class="invoice_row mt-3"><!-- invoice row start -->

                                            <div class="invoice_col basis_col_15">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->

                                                        Company Title
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input ">
                                                        <!-- invoice column input start -->
                                                        <div class="invoice_col_short">
                                                            <!-- invoice column short start -->

                                                        </div><!-- invoice column short end -->
                                                        <select tabindex="1" autofocus name="company" class="inputs_up form-control"
                                                                id="company" autofocus data-rule-required="true"
                                                                data-msg-required="Please Select Company Title">
                                                            <option value="" selected disabled>Select Company</option>
                                                            @foreach ($companies as $company)
                                                                <option
                                                                    value="{{$company->account_uid}}"
                                                                    {{$company->account_uid == old('product_name') ? 'selected' : ''}} data-company-id="{{$company->account_uid}}"
                                                                >{{$company->account_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_15">
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
                                                                data-rule-required="true" data-msg-required="Please Enter Project Name"
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


                                            <div class="invoice_col basis_col_15">
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

                                                            {{--                                                                <a onclick="$('select#company').trigger('change');"--}}
                                                            {{--                                                                   class="col_short_btn">--}}
                                                            {{--                                                                    <l class="fa fa-refresh"></l>--}}
                                                            {{--                                                                </a>--}}
                                                        </div><!-- invoice column short end -->
                                                        <select tabindex="3" name="region" id="region"
                                                                data-rule-required="true" data-msg-required="Please Choose Region"
                                                                class="inputs_up form-control" data-rule-required="true" data-msg-required="Please Enter Region Name"
                                                        >
                                                            <option value="" selected disabled>
                                                                Select Company
                                                                First
                                                            </option>
                                                        </select>

                                                    </div><!-- invoice column input end -->
                                                    <input type="hidden" name="region_id" id="region_id">
                                                    <input type="hidden" name="zone_id" id="zone_id">
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_10">
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
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_15">
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

                                            <div class="invoice_col basis_col_15">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        Produce Quantity
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->

                                                        <div class="invoice_col_short">
                                                            <!-- invoice column short start -->
                                                        </div><!-- invoice column short end -->
                                                        <input tabindex="8" type="text" name="produce_quantity"
                                                               class="inputs_up text-right form-control"
                                                               id="produce_quantity"
                                                               placeholder="Produce Quantity"
                                                               onfocus="this.select();"
                                                               onkeyup="calculate_remaining_qty();product_amount_calculation();"
                                                               onkeypress="return allowOnlyNumber(event);"/>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_15">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        Rate
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->

                                                        <div class="invoice_col_short">
                                                            <!-- invoice column short start -->
                                                        </div><!-- invoice column short end -->
                                                        <input tabindex="8" type="text" name="rate"
                                                               class="inputs_up text-right form-control"
                                                               id="rate"
                                                               placeholder="Rate"
                                                               onfocus="this.select();"
                                                               onkeypress="return allowOnlyNumber(event);" readonly/>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->



                                            <div class="invoice_col basis_col_15">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        Produce Amount
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->

                                                        <div class="invoice_col_short">
                                                            <!-- invoice column short start -->
                                                        </div><!-- invoice column short end -->
                                                        <input tabindex="8" type="text" name="produce_amount"
                                                               class="inputs_up text-right form-control"
                                                               id="produce_amount"
                                                               placeholder="Produce Amount"
                                                               onfocus="this.select();"
                                                               onkeypress="return allowOnlyNumber(event);" readonly/>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->


                                        </div>


                                        <div class="invoice_row mt-2"><!-- invoice row start -->

                                            <div class="invoice_col basis_col_11">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover"
                                                           data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_packages.Code.description')}}</p>">
                                                            <l class="fa fa-info-circle"></l>
                                                        </a>
                                                        Bar Code
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
                                                            <a id="refresh_product_code"
                                                               class="col_short_btn"
                                                               data-container="body"
                                                               data-toggle="popover"
                                                               data-trigger="hover"
                                                               data-placement="bottom" data-html="true"
                                                               data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                <i class="fa fa-refresh"></i>
                                                            </a>
                                                        </div><!-- invoice column short end -->
                                                        <select name="material_product_code"
                                                                class="inputs_up form-control"
                                                                id="material_product_code">
                                                            <option value="0">Code</option>

                                                            @foreach ($products as $product)
                                                                <option
                                                                    value={{$product->pro_p_code}} data-parent={{$product->pro_p_code}}
                                                                        data-sale_price={{$product->pro_purchase_price}} data-tax={{$product->pro_tax}}
                                                                        data-retailer_dis={{$product->pro_retailer_discount}} data-whole_saler_dis={{$product->pro_whole_seller_discount}} data-loyalty_dis={{$product->pro_loyalty_card_discount}} data-unit={{$product->unit_title}}>{{$product->pro_p_code}}</option>
                                                            @endforeach

                                                        </select>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_22">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover"
                                                           data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_packages.product_name.description')}}</p>">
                                                            <l class="fa fa-info-circle"></l>
                                                        </a>
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
                                                        <select tabindex="5" name="material_product_name"
                                                                class="inputs_up form-control"
                                                                id="material_product_name">
                                                            <option value="0">Product</option>
                                                            @foreach ($products as $product)
                                                                <option
                                                                    value={{$product->pro_p_code}} data-parent={{$product->pro_p_code}} data-sale_price={{$product->pro_purchase_price}}
                                                                        data-tax={{$product->pro_tax}} data-retailer_dis={{$product->pro_retailer_discount}}
                                                                        data-whole_saler_dis={{$product->pro_whole_seller_discount}}
                                                                        data-loyalty_dis={{$product->pro_loyalty_card_discount}}
                                                                        data-unit={{$product->unit_title}}>{{$product->pro_title}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_18">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class=" invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover"
                                                           data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p>
                                                                                                    <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p>
                                                                                                    <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p>
                                                                                                    <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                            <l class="fa fa-info-circle"></l>
                                                        </a>
                                                        Remarks
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input tabindex="6" type="text" name="material_remarks"
                                                               class="inputs_up form-control"
                                                               id="material_remarks"
                                                               placeholder="Remarks"/>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_8" readonly="true">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        UOM
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input tabindex="7" type="text" name="uom_material"
                                                               class="inputs_up text-right form-control"
                                                               id="uom_material"
                                                               placeholder="UOM"
                                                               onfocus="this.select();" readonly="true"
                                                        />
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
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_packages.qty.description')}}</p>">
                                                            <l class="fa fa-info-circle"></l>
                                                        </a>
                                                        Quantity
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input tabindex="8" type="text" name="quantity_material"
                                                               class="inputs_up text-right form-control"
                                                               id="quantity_material"
                                                               placeholder="Qty"
                                                               onfocus="this.select();"
                                                               onkeyup="product_amount_calculation_material();"
                                                               onkeypress="return allowOnlyNumber(event);"/>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_6">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover"
                                                           data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_packages.rate.description')}}</p>">
                                                            <l class="fa fa-info-circle"></l>
                                                        </a>
                                                        Rate
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input tabindex="9" type="text" name="rate_material"
                                                               class="inputs_up text-right form-control"
                                                               id="rate_material"
                                                               placeholder="Rate"
                                                               onkeypress="return allow_only_number_and_decimals(this,event);"
                                                               onkeyup="product_amount_calculation_material();"/>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_10">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        <a data-container="body" data-toggle="popover"
                                                           data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_packages.amount.description')}}</p>">
                                                            <l class="fa fa-info-circle"></l>
                                                        </a>
                                                        Amount
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input tabindex="10" type="text" name="amount_material"
                                                               class="inputs_up text-right form-control"
                                                               id="amount_material"
                                                               placeholder="Amount" readonly>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_11 hidden" hidden>
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        Product Sale Tax
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input type="text"
                                                               name="product_sales_tax_material"
                                                               class="inputs_up text-center form-control"
                                                               id="product_sales_tax_material"
                                                               placeholder="Sale Tax %"
                                                               onkeyup="product_amount_calculation_material();"
                                                               onkeypress="return allow_only_number_and_decimals(this,event);">
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_11 hidden" hidden>
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        Product Discount
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input type="text"
                                                               name="product_discount_material"
                                                               class="inputs_up text-right form-control"
                                                               id="product_discount_material"
                                                               placeholder="Discount"
                                                               onkeyup="product_amount_calculation();"
                                                               onkeypress="return allow_only_number_and_decimals(this,event);">
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_12">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_txt for_voucher_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="invoice_col_txt with_cntr_jstfy">
                                                        <div
                                                            class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                            <button tabindex="11" id="first_add_more_material"
                                                                    class="invoice_frm_btn"
                                                                    onclick="add_material()"
                                                                    type="button">
                                                                <i class="fa fa-plus"></i> Add
                                                            </button>
                                                        </div>
                                                        <div
                                                            class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                            <button style="display: none;"
                                                                    id="cancel_button"
                                                                    class="invoice_frm_btn"
                                                                    onclick="cancel_all()"
                                                                    type="button">
                                                                <i class="fa fa-times"></i> Cancel
                                                            </button>
                                                        </div>
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
                                                        <div class="invoice_col_bx for_tabs">
                                                            <a data-container="body"
                                                               data-toggle="popover"
                                                               data-trigger="hover"
                                                               data-placement="bottom" data-html="true"
                                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_packages.auto_add.description')}}</p>">
                                                                <l class="fa fa-info-circle"></l>
                                                            </a>
                                                            <!-- invoice column box start -->
                                                            <div class="custom-checkbox">
                                                                <input type="checkbox"
                                                                       class="custom-control-input company_info_check_box"
                                                                       id="add_auto_material"
                                                                       name="add_auto_material"
                                                                       value="1" checked>
                                                                <label
                                                                    class="custom-control-label chck_pdng"
                                                                    for="add_auto_material"> Auto
                                                                    Add </label>
                                                            </div>

                                                        </div><!-- invoice column box end -->
                                                    </div><!-- invoice column end -->


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
                                                                            Code
                                                                        </th>
                                                                        <th class="text-center tbl_txt_22">
                                                                            Title
                                                                        </th>
                                                                        <th class="text-center tbl_txt_45">
                                                                            Remarks
                                                                        </th>
                                                                        <th class="text-center tbl_txt_11">
                                                                            UOM
                                                                        </th>
                                                                        <th class="text-center tbl_txt_6">
                                                                            Qty
                                                                        </th>
                                                                        <th class="text-center tbl_txt_6">
                                                                            Rate
                                                                        </th>
                                                                        <th class="text-center tbl_srl_12">
                                                                            Amount
                                                                        </th>
                                                                    </tr>
                                                                    </thead>

                                                                    <tbody id="table_body_material">
                                                                    <tr>
                                                                        <td colspan="10" align="center">
                                                                            No Account Added
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>

                                                                    <tfoot>
                                                                    <tr>
                                                                        <th colspan="3"
                                                                            class="text-right">
                                                                            Total Items
                                                                        </th>
                                                                        <td class="text-center tbl_srl_12">
                                                                            <div
                                                                                class="invoice_col_txt">
                                                                                <!-- invoice column box start -->
                                                                                <div
                                                                                    class="invoice_col_input">
                                                                                    <!-- invoice column input start -->
                                                                                    <input type="text"
                                                                                           name="total_items_material"
                                                                                           class="inputs_up text-right form-control total-items-field"
                                                                                           id="total_items_material"
                                                                                           placeholder="0.00"
                                                                                           minlength="1"
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
                                                                        <th colspan="3"
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
                                                                                    <input type="text"
                                                                                           name="total_price_material"
                                                                                           class="inputs_up text-right form-control"
                                                                                           id="total_price_material"
                                                                                           placeholder="0.00"
                                                                                           minlength="2"
                                                                                           readonly
                                                                                           data-rule-required="true"
                                                                                           data-msg-required="Please Add">
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

                                        <div class="invoice_row"><!-- invoice row start -->

                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                <div class="invoice_col_txt with_cntr_jstfy for_voucher_btns">
                                                    <!-- invoice column box start -->
                                                    <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                        <button tabindex="12" type="submit" name="save" id="save" class="invoice_frm_btn"
                                                                onclick="return popvalidation()"
                                                        >
                                                            <i class="fa fa-floppy-o"></i> Save
                                                        </button>
                                                        <span id="demo21" class="validate_sign"></span>
                                                    </div>
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->


                                        </div><!-- invoice row end -->

                                    </div><!-- invoice content end -->
                                </div><!-- invoice scroll box end -->

                                <input type="hidden" name="materials_val" id="materials_val">

                                <input type="hidden" name="material_array" id="material_array">

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
                region = document.getElementById("region"),
                total_items_material = document.getElementById("total_items_material"),
                validateInputIdArray = [
                    company.id,
                    project.id,
                    region.id,
                    total_items_material.id,
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

    </script>

    <script type="text/javascript">

        // Initialize select2
        jQuery("#company").select2();
        jQuery("#project").select2();
        jQuery("#region").select2();

        jQuery("#material_product_code").select2();
        jQuery("#material_product_name").select2();


    </script>

    {{--   start purchase order script--}}

    <script>
        jQuery(document).ready(function () {
            // Initialize select2

            jQuery("#company").select2();
            jQuery("#zone").select2();
            jQuery("#region").select2();
            jQuery("#material_product_code").select2();
            jQuery("#material_product_name").select2();
            jQuery("#product_name").select2();


            $("#invoice_btn").click();
        });

        window.addEventListener('keydown', function (e) {
            if (e.which == 113) {
                // $('#product_code').select2('open');
            }

            if (e.keyCode == 65 && e.altKey) {
                $("#first_add_more").click();
            }
        });

        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });


    </script>

    {{--    end purchase order script--}}

    {{--    START material budget script--}}
    {{--<script>--}}
    <script>

        function product_amount_calculation_material() {
            var quantity = jQuery("#quantity_material").val();
            var rate = jQuery("#rate_material").val();

            var amount = rate * quantity;

            jQuery("#amount_material").val(amount);
        }

        function grand_total_calculation_material() {
            var total_price = 0;

            total_discount = 0;

            jQuery.each(material, function (index, value) {
                total_price = +total_price + +value[6];
            });

            jQuery("#total_price_material").val(total_price);
        }
    </script>


    <script>
        var check_add = 0;
        jQuery("#material_product_code").change(function () {

            var sale_price = jQuery('option:selected', this).attr('data-sale_price');
            var unit = jQuery('option:selected', this).attr('data-unit');

            jQuery("#rate_material").val(sale_price);

            var pname = jQuery('option:selected', this).val();

            jQuery("#quantity_material").val('1');
            jQuery("#uom_material").val(unit);
            jQuery("#material_product_name").select2("destroy");
            jQuery("#material_product_name").children("option[value^=" + pname + "]");

            jQuery('#material_product_name option[value="' + pname + '"]').prop('selected', true);

            product_amount_calculation_material();

            jQuery("#material_product_name").select2();
            // jQuery("#quantity").focus();

            if ($("#add_auto_material").is(':checked')) {
                $("#first_add_more_material").click();  // checked
                check_add = 1;
                setTimeout(function () {
                    //$('#material_product_code').select2('open');
                }, 100);
            }
        });

    </script>

    <script>
        jQuery("#material_product_name").change(function () {
            var sale_price = jQuery('option:selected', this).attr('data-sale_price');
            var unit = jQuery('option:selected', this).attr('data-unit');
            // jQuery("#product_sales_tax").val(tax);

            var pcode = jQuery('option:selected', this).val();

            if (pcode == 'add_more') {
                window.open('add_product', '_blank');
            }

            jQuery("#quantity_material").val('1');

            jQuery("#material_product_code").select2("destroy");
            jQuery("#material_product_code").children("option[value^=" + pcode + "]");

            jQuery('#material_product_code option[value="' + pcode + '"]').prop('selected', true);


            jQuery("#rate_material").val(sale_price);
            jQuery("#uom_material").val(unit);

            product_amount_calculation_material();

            jQuery("#material_product_code").select2();
            // jQuery("#quantity").focus();

            if ($("#add_auto_material").is(':checked')) {
                $("#first_add_more_material").click();  // checked

                check_add = 1;
                setTimeout(function () {
                    //$('#material_product_code').select2('open');

                }, 100);
            }
        });

    </script>

    <script>
        // adding packs into table
        var numberofmaterial = 0;
        var counter = 0;
        var material = {};
        var global_id_to_edit = 0;
        var total_discount = 0;


        function add_material() {

            var product_code_val = document.getElementById("material_product_code").value;
            var product_name_val = document.getElementById("material_product_name").value;
            var product_remarks = document.getElementById("material_remarks").value;
            var quantity = document.getElementById("quantity_material").value;
            var rate = document.getElementById("rate_material").value;
            var amount = document.getElementById("amount_material").value;

            var flag_submit1 = true;
            var focus_once1 = 0;

            if (product_code_val == "0") {

                if (focus_once1 == 0) {
                    jQuery("#material_product_code").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (product_name_val == "0") {

                if (focus_once1 == 0) {
                    jQuery("#material_product_name").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (quantity == "" || quantity == 0) {

                if (focus_once1 == 0) {
                    jQuery("#quantity_material").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (rate == "") {

                if (focus_once1 == 0) {
                    jQuery("#rate_material").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (amount == "") {

                if (focus_once1 == 0) {
                    jQuery("#amount_material").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (flag_submit1) {

                if (global_id_to_edit != 0) {
                    jQuery("#" + global_id_to_edit).remove();

                    delete material[global_id_to_edit];
                }

                counter++;

                jQuery("#material_product_code").select2("destroy");
                jQuery("#material_product_name").select2("destroy");

                var product_name = jQuery("#material_product_name option:selected").text();
                var selected_code_value = jQuery("#material_product_code option:selected").attr('data-parent');
                var qty = jQuery("#quantity_material").val();
                var selected_product_name = jQuery("#material_product_name").val();
                var selected_remarks = jQuery("#material_remarks").val();
                var selected_rate = jQuery("#rate_material").val();
                var selected_amount = jQuery("#amount_material").val();
                var unit = jQuery("#uom_material").val();

                $.each(material, function (index, entry) {

                    if (entry[1].trim() == selected_code_value.trim()) {

                        // jQuery(".select2-search__field").val('');

                        if (index != 0) {
                            jQuery("#" + index).remove();

                            delete material[index];
                        }
                        counter++;

                        qty = entry[4];

                        qty = +entry[4] + +1;

                        selected_amount = selected_rate * qty;
                    }
                });


                numberofsales = Object.keys(material).length;

                if (numberofsales == 0) {
                    jQuery("#table_body_material").html("");
                }


                material[counter] = [product_code_val, selected_code_value, product_name, selected_remarks, qty, selected_rate, selected_amount, unit];


                // jQuery("#product_code option[value=" + selected_code_value + "]").attr("disabled", "true");
                // jQuery("#product_name option[value=" + selected_code_value + "]").attr("disabled", "true");
                numberofmaterial = Object.keys(material).length;
                var remarks_var = '';
                if (selected_remarks != '') {
                    var remarks_var = '' + selected_remarks + '';
                }

                jQuery("#table_body_material").prepend('<tr id=' + counter + ' class="edit_update"><td class="text-center tbl_srl_9">' + selected_code_value + '</td><td class="text-left tbl_txt_22">' + product_name + '</td><td class="text-left tbl_txt_45">' + remarks_var + '</td><td class="text-right tbl_txt_11">' + unit + '</td><td class="text-right tbl_txt_6">' + qty + '</td><td class="text-right tbl_txt_6">' + selected_rate + '</td><td class="text-right tbl_srl_12">' + selected_amount + '<div class="edit_update_bx"><a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_material(' + counter + ')><i class="fa fa-edit"></i></a><a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_material(' + counter + ')><i class="fa fa-trash"></i></a></div></td></tr>');


                jQuery('#material_product_code option[value="' + '' + '"]').prop('selected', true);
                jQuery('#material_product_name option[value="' + '' + '"]').prop('selected', true);

                jQuery("#uom_material").val("");
                jQuery("#quantity_material").val("");
                jQuery("#material_remarks").val("");
                jQuery("#rate_material").val("");
                jQuery("#amount_material").val("");


                jQuery("#material_array").val(JSON.stringify(material));
                jQuery("#cancel_button").hide();
                jQuery(".table-responsive").show();
                jQuery("#save").show();
                jQuery("#first_add_more_material").html('<i class="fa fa-plus"></i> Add');

                jQuery("#total_items_material").val(numberofmaterial);

                jQuery(".edit_link").show();
                jQuery(".delete_link").show();

                grand_total_calculation_material();

                jQuery("#material_product_code").select2();
                jQuery("#material_product_name").select2();
            }
        }


        function delete_material(current_item) {

            jQuery("#" + current_item).remove();
            var temp_materials = material[current_item];

            delete material[current_item];

            function isEmpty(obj) {

                for (var key in obj) {

                    if (obj.hasOwnProperty(key))
                        return false;
                }
                return true;
            }

            jQuery("#material_array").val(JSON.stringify(material));

            if (isEmpty(material)) {
                numberofsales = 0;
            }

            var number_of_material = Object.keys(material).length;
            jQuery("#total_items_material").val(number_of_material);


            grand_total_calculation_material();


            jQuery("#material_product_name").select2("destroy");
            jQuery("#material_product_name").select2();
            jQuery("#material_product_code").select2("destroy");
            jQuery("#material_product_code").select2();
        }


        function edit_material(current_item) {

            // jQuery(".table-responsive").attr("style", "display:none");
            jQuery("#" + current_item).attr("style", "display:none");
            jQuery("#save").attr("style", "display:none");
            jQuery("#first_add_more_material").html('<i class="fa fa-plus"></i> update');
            jQuery("#cancel_button").show();

            jQuery(".edit_link").hide();
            jQuery(".delete_link").hide();

            global_id_to_edit = current_item;

            var temp_material = material[current_item];

            jQuery("#material_product_code").select2("destroy");
            jQuery("#material_product_name").select2("destroy");

            jQuery("#material_product_code").children("option[value^=" + temp_material[0] + "]").show(); //showing hid unit

            jQuery('#material_product_code option[value="' + temp_material[0] + '"]').prop('selected', true);

            jQuery("#material_product_name").val(temp_material[0]);
            jQuery("#material_remarks").val(temp_material[3]);
            jQuery("#quantity_material").val(temp_material[4]);
            jQuery("#rate_material").val(temp_material[5]);
            jQuery("#amount_material").val(temp_material[6]);
            jQuery("#uom_material").val(temp_material[7]);

            jQuery("#material_product_code").select2();
            jQuery("#material_product_name").select2();

            jQuery("#cancel_button").attr("style", "display:inline");
            jQuery("#cancel_button").attr("style", "background-color:red !important");
        }

        function cancel_all() {

            var newvaltohide = jQuery("#material_product_code").val();

            jQuery("#quantity_material").val("");

            jQuery('#material_product_code option[value="' + '' + '"]').prop('selected', true);
            jQuery('#material_product_name option[value="' + '' + '"]').prop('selected', true);

            jQuery("#material_product_code").select2("destroy");
            jQuery("#material_product_name").select2("destroy");

            jQuery("#material_remarks").val("");
            jQuery("#rate_material").val("");
            // jQuery("#amount").val("");
            jQuery("#uom_material").val("");
            jQuery("#amount_material").val("");

            jQuery("#material_product_code").select2();
            jQuery("#material_product_name").select2();

            jQuery("#cancel_button").hide();

            // jQuery(".table-responsive").show();
            jQuery("#" + global_id_to_edit).show();


            var temp_material = material[global_id_to_edit];

            jQuery("#save").show();

            jQuery("#first_add_more_material").html('<i class="fa fa-plus"></i> Add');
            global_id_to_edit = 0;

            jQuery(".edit_link").show();
            jQuery(".delete_link").show();

        }
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2

            jQuery("#material_product_code").select2();
            jQuery("#material_product_name").select2();
            // setTimeout(function () {
            //     // jQuery("#product_code").focus();
            //     $('#material_product_code').select2('open');
            // }, 100);


            $(window).keydown(function (event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });

        });

        window.addEventListener('keydown', function (e) {
            if (e.which == 113) {
                // $('#material_product_code').select2('open');
            }
            if (e.keyCode == 65 && e.altKey) {
                $("#first_add_more_material").click();
            }
        });
    </script>

    <script>
        $('#view_detail').click(function () {

            var btn_name = jQuery("#view_detail").html();

            if (btn_name.trim() == 'View Detail') {

                jQuery("#view_detail").html('Hide Detail');
            } else {
                jQuery("#view_detail").html('View Detail');
            }
        });

    </script>

    {{--    END material budget script--}}

    <script>
        jQuery("#project").change(function () {
            var project = $(this).find(':selected').val();
            // var grand_total = $('option:selected', this).attr('data-grand_total');
            // $('#grand_total').val(grand_total);
            // document.getElementById("projectTotalAmountView").innerHTML = grand_total;

            // jQuery.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            //     }
            // });
            // jQuery.ajax({
            //     url: "get_company_products",
            //     data: {project: project},
            //     type: "GET",
            //     cache: false,
            //     dataType: 'json',
            //     success: function (data) {
            //         console.log(data.company);
            // console.log(data.products);
            // var option = "<option value='' disabled selected>Select Product</option>";

            // $.each(data.products, function (index, value) {
            //     option += "<option value='" + value.pro_p_code + "' data-parent='" + value.pro_p_code + "' data-sale_price='" + value.pro_sale_price + "' data-tax='" + value.pro_tax + "'data-retailer_dis='" + value.pro_retailer_discount + "' data-whole_saler_dis='" + value.pro_whole_seller_discount + "' data-loyalty_dis='" + value.pro_loyalty_card_discount + "' data-unit='" + value.unit_title + "'>" + value.pro_title + "</option>";
            // });
            //
            // jQuery("#material_product_name").html(" ");
            // jQuery("#material_product_name").append(option);
            // jQuery("#material_product_name").select2();

            // var consume_amount = 0;
            // $.each(data.calculations, function (index, value) {
            //     consume_amount = +value + consume_amount;
            // });
            //
            // jQuery("#remaining_amount").html(" ");
            // jQuery("#consume_amount").html(" ");
            // jQuery("#consume_amount").val(consume_amount);
            // var remaining_amount = grand_total - consume_amount;
            // jQuery("#remaining_amount").val(remaining_amount.toFixed(2));
            // document.getElementById("consumeTotalAmountView").innerHTML = consume_amount;
            // document.getElementById("remainingTotalAmountView").innerHTML = remaining_amount;

            // },
            // error: function (jqXHR, textStatus, errorThrown) {
            //     alert(jqXHR.responseText);
            //     alert(errorThrown);
            // }
            // });
        });
    </script>
    {{--    --}}{{--    end expense budget script--}}
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
                        option += "<option value='" + value.proj_id + "' data-grand_total='" + value.proj_grand_total + "'>" + value.proj_project_name + "</option>";
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
        $('#zone').change(function () {
            var zone = $('#region').find(':selected').attr('data-region-id');

            var region = $('option:selected', this).attr('data-zone-id');
            var project = $('#project').val();

            $('#region_id').val('');
            $('#region_id').val(region);
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
                    var option_code = "<option value='' disabled selected>Select Product Code</option>";
                    var option = "<option value='' disabled selected>Select Product Name</option>";

                    $.each(data.products, function (index, value) {
                        option_code += "<option value='" + value.pro_p_code + "' data-parent='" + value.pro_p_code + "' data-sale_price='" + value.opi_rate + "' data-tax='" + value.pro_tax + "'data-retailer_dis='" + value.pro_retailer_discount + "' data-whole_saler_dis='" + value.pro_whole_seller_discount + "' data-loyalty_dis='" + value.pro_loyalty_card_discount + "' data-unit='" + value.unit_title + "'>" + value.pro_p_code + "</option>";
                    });

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

    <script>
        $('#product_name').change(function () {
            var product = $(this).find(':selected').val();

            var sale_price = jQuery('option:selected', this).attr('data-sale_price');

            jQuery("#produce_quantity").val('');

            jQuery("#rate").val(sale_price);

            product_amount_calculation();

            var zone = $('#zone').find(':selected').attr('data-zone-id');
            var region = $('#region').find(':selected').attr('data-region-id');
            var project = $('#project').val();

            $('#region_id').val('');
            $('#region_id').val(region);
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_product_budget",
                data: {zone: zone,region: region, project: project, product: product},
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    var product_budget = 0;
                    var product_qty = 0;
                    $.each(data.product_budget, function (index, value) {
                        product_budget = +value.opi_amount + product_budget;
                        product_qty = +value.opi_qty + product_qty;
                    });

                    // alert(product_budget);
                    $('#grand_total').val(" ");
                    $('#grand_total').val(product_budget);
                    $('#total_qty').val(" ");
                    $('#total_qty').val(product_qty);
                    document.getElementById("projectTotalAmountView").innerHTML = product_budget;
                    document.getElementById("totalQtyView").innerHTML = product_qty;

                    var consume_amount = 0;
                    $.each(data.calculations, function (index, value) {
                        consume_amount = +value + consume_amount;
                    });

                    var consume_qty = 0;
                    $.each(data.calculations_qty, function (index, value) {
                        consume_qty = +value + consume_qty;
                    });

                    jQuery("#remaining_amount").html(" ");
                    jQuery("#consume_amount").html(" ");
                    jQuery("#consume_amount").val(consume_amount);
                    var remaining_amount = product_budget - consume_amount;
                    jQuery("#remaining_amount").val(remaining_amount.toFixed(2));
                    document.getElementById("consumeTotalAmountView").innerHTML = consume_amount;
                    document.getElementById("remainingTotalAmountView").innerHTML = remaining_amount;

                    jQuery("#remaining_qty").html(" ");
                    jQuery("#consume_qty").html(" ");
                    jQuery("#consume_qty").val(consume_qty);
                    var remaining_qty = product_qty - consume_qty;
                    jQuery("#remaining_qty").val(remaining_qty.toFixed(2));
                    document.getElementById("consumeTotalQtyView").innerHTML = consume_qty;
                    document.getElementById("remainingTotalQtyView").innerHTML = remaining_qty;

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

        function product_amount_calculation() {
            var quantity = jQuery("#produce_quantity").val();
            var rate = jQuery("#rate").val();

            var amount = rate * quantity;

            jQuery("#produce_amount").val(amount);
            calculate_remaining_amount();
        }



    </script>

    <script>
        function calculate_remaining_amount() {
            var total_price = $('#produce_amount').val();
            var consume_amount = $('#consume_amount').val();
            var remaining_amount = $('#remaining_amount').val();

            consume_amount = +consume_amount + +total_price;
            remaining_amount = remaining_amount - total_price;

            document.getElementById("consumeTotalAmountView").innerHTML = consume_amount.toFixed(2);
            document.getElementById("remainingTotalAmountView").innerHTML = remaining_amount.toFixed(2);

        }

    </script>

    <script>
        function calculate_remaining_qty() {
            var total_qty = $('#total_qty').val();
            var consume_qty = $('#consume_qty').val();

            var produce_quantity = $('#produce_quantity').val();
            var remaining_qty = $('#remaining_qty').val();

            consume_qty = +consume_qty + +produce_quantity;
            remaining_qty = remaining_qty - produce_quantity;

            document.getElementById("consumeTotalQtyView").innerHTML = consume_qty.toFixed(2);
            document.getElementById("remainingTotalQtyView").innerHTML = remaining_qty.toFixed(2);

        }

    </script>
@endsection

