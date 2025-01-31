@extends('extend_index')

@section('content')
    <style>
        .modal-lg {
            width: 1405px;
            max-width: 1500px;
        }

        .error-msg {
            font-size: 10px;
            color: red;
            font-weight: bold;
        }
    </style>
    <div class="row">

        @php
            $company_info = Session::get('company_info');
            if(isset($company_info) || !empty($company_info)){
                $win = $company_info->info_bx;
            }else{
                $win = '';
            }

        @endphp
        <div
            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">


            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">

                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Project Creattion</h4>
                        </div>
                        <div class="list_btn">
                            <a class="btn list_link add_more_button" href="{{ route('project_creation_list') }}"
                               role="button">
                                <i class="fa fa-list"></i> view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <form action="{{ route('submit_project_creation') }}" id="f1" onsubmit="return validate_form()"
                      method="post"
                      enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <div class="pd-20 bg-white border-radius-4 box-shadow">


                                <div class="tab">
                                    <ul class="nav nav-tabs customtab" role="tablist">
                                        <li class="nav-item ">
                                            {{--                                            text-blue--}}
                                            <a class="nav-link active" data-toggle="tab" href="#home"
                                               role="tab" aria-selected="true">Purchase Order</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#orderList" role="tab"
                                               aria-selected="false">Order List Item</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#profile" role="tab"
                                               aria-selected="false">Working Area</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#credentials"
                                               role="tab" aria-selected="false">Expense Budget</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#material"
                                               role="tab" aria-selected="false">Material Budget</a>
                                        </li>

{{--                                        <li class="nav-item">--}}
{{--                                            <a class="nav-link" data-toggle="tab" href="#recepie"--}}
{{--                                               role="tab" aria-selected="false">Recipe</a>--}}
{{--                                        </li>--}}

{{--                                        <li class="nav-item">--}}
{{--                                            <a class="nav-link" data-toggle="tab" href="#workOrder"--}}
{{--                                               role="tab" aria-selected="false">Work Order</a>--}}
{{--                                        </li>--}}

                                    </ul>
                                    <div class="tab-content" style="background-color: #eaeef5;">
                                        <div class="tab-pane fade show active" id="home" role="tabpanel">
                                            <div class="pd-20">

                                                <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl">
                                                    <!-- invoice scroll box start -->
                                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt">
                                                        <!-- invoice content start -->

                                                        <div class="invoice_row"><!-- invoice row start -->

                                                            <div class="invoice_col basis_col_24">
                                                                <!-- invoice column start -->
                                                                <div class="invoice_col_bx">
                                                                    <!-- invoice column box start -->
                                                                    <div class="required invoice_col_ttl">
                                                                        <!-- invoice column title start -->
                                                                        Project Name
                                                                    </div><!-- invoice column title end -->
                                                                    <div class="invoice_col_input">
                                                                        <!-- invoice column input start -->
                                                                        <input type="text" name="project_name"
                                                                               class="inputs_up form-control"
                                                                               id="project_name"
                                                                               placeholder="Project Name">
                                                                    </div><!-- invoice column input end -->
                                                                </div><!-- invoice column box end -->
                                                            </div><!-- invoice column end -->

                                                            <div class="invoice_col basis_col_24">
                                                                <!-- invoice column start -->
                                                                <div class="invoice_col_bx">
                                                                    <!-- invoice column box start -->
                                                                    <div class="required invoice_col_ttl">
                                                                        <!-- invoice column title start -->
                                                                        Party
                                                                    </div><!-- invoice column title end -->
                                                                    <div class="invoice_col_input">
                                                                        <!-- invoice column input start -->
                                                                        <select name="account_name"
                                                                                class="inputs_up form-control js-example-basic-multiple user-select"
                                                                                id="account_name">
                                                                            <option value="0">Select Party</option>
                                                                            @foreach($party_accounts as $account)
                                                                                <option
                                                                                    value="{{$account->account_uid}}"
                                                                                    {{--                                                                                    data-limit_status="{{$account->account_credit_limit_status}}"--}}
                                                                                    {{--                                                                                    data-limit="{{$account->account_credit_limit}}"--}}
                                                                                    {{--                                                                                    data-disc_type="{{$account->account_discount_type}}"--}}
                                                                                >
                                                                                    {{$account->account_name}}</option>
                                                                            @endforeach
                                                                        </select>

                                                                    </div><!-- invoice column input end -->
                                                                </div><!-- invoice column box end -->
                                                            </div><!-- invoice column end -->

                                                            <div class="invoice_col basis_col_24">
                                                                <!-- invoice column start -->
                                                                <div class="invoice_col_bx">
                                                                    <!-- invoice column box start -->
                                                                    <div class=" invoice_col_ttl">
                                                                        <!-- invoice column title start -->
                                                                        <a data-container="body" data-toggle="popover"
                                                                           data-trigger="hover"
                                                                           data-placement="bottom" data-html="true"
                                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.party_reference.description')}}</p>
                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.party_reference.benefits')}}</p>">
                                                                            <l class="fa fa-info-circle"></l>
                                                                        </a>
                                                                        Party Reference
                                                                    </div><!-- invoice column title end -->
                                                                    <div class="invoice_col_input">
                                                                        <!-- invoice column input start -->
                                                                        <input type="text" name="customer_name"
                                                                               class="inputs_up form-control"
                                                                               id="customer_name"
                                                                               placeholder="Party Reference">
                                                                    </div><!-- invoice column input end -->
                                                                </div><!-- invoice column box end -->
                                                            </div><!-- invoice column end -->

                                                            <div class="invoice_col basis_col_25_5">
                                                                <!-- invoice column start -->
                                                                <div class="invoice_col_bx">
                                                                    <!-- invoice column box start -->
                                                                    <div class=" invoice_col_ttl">
                                                                        <!-- invoice column title start -->
                                                                        <a
                                                                            data-container="body" data-toggle="popover"
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
                                                                        <input type="text" name="remarks"
                                                                               class="inputs_up form-control"
                                                                               id="remarks" placeholder="Remarks">
                                                                    </div><!-- invoice column input end -->
                                                                </div><!-- invoice column box end -->
                                                            </div><!-- invoice column end -->

                                                        </div><!-- invoice row end -->

                                                        <div class="invoice_row purchase_order"><!-- invoice row start -->

                                                            <div class="invoice_col basis_col_11 hidden" hidden>
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
                                                                        Bar Code
                                                                    </div><!-- invoice column title end -->
                                                                    <div class="invoice_col_input">
                                                                        <!-- invoice column input start -->
                                                                        <div class="invoice_col_short">
                                                                            <!-- invoice column short start -->
                                                                            <a href="{{ route('add_product') }}"
                                                                               target="_blank" class="col_short_btn"
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
                                                                               data-placement="bottom"
                                                                               data-html="true"
                                                                               data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                                <l class="fa fa-refresh"></l>
                                                                            </a>
                                                                        </div><!-- invoice column short end -->
                                                                        <select name="product_code"
                                                                                class="inputs_up form-control"
                                                                                id="product_code">
                                                                            <option value="0">Code</option>
                                                                            @foreach ($products as $product)
                                                                                <option
                                                                                    value={{$product->pro_p_code}} data-parent={{$product->pro_p_code}} data-sale_price={{$product->pro_sale_price}} data-tax={{$product->pro_tax}} data-retailer_dis={{$product->pro_retailer_discount}} data-whole_saler_dis={{$product->pro_whole_seller_discount}} data-loyalty_dis={{$product->pro_loyalty_card_discount}} data-unit={{$product->unit_title}}>{{$product->pro_code}}</option>
                                                                            @endforeach
                                                                            {{--                                                        <option value="0">568741759</option>--}}
                                                                        </select>
                                                                    </div><!-- invoice column input end -->
                                                                </div><!-- invoice column box end -->
                                                            </div><!-- invoice column end -->

                                                            <div class="invoice_col basis_col_25_5">
                                                                <!-- invoice column start -->
                                                                <div class="invoice_col_bx">
                                                                    <!-- invoice column box start -->
                                                                    <div class="required invoice_col_ttl">
                                                                        <!-- invoice column title start -->
                                                                        <a data-container="body" data-toggle="popover"
                                                                           data-trigger="hover"
                                                                           data-placement="bottom" data-html="true"
                                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.product.product_title.description')}}</p>
                                                         <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.product.product_title.benefits')}}</p>">
                                                                            <l class="fa fa-info-circle"></l>
                                                                        </a>
                                                                        Products
                                                                    </div><!-- invoice column title end -->
                                                                    <div class="invoice_col_input">
                                                                        <!-- invoice column input start -->

                                                                        <div class="invoice_col_short">
                                                                            <!-- invoice column short start -->
                                                                            <a href="{{ route('add_product') }}"
                                                                               target="_blank" class="col_short_btn"
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
                                                                               data-placement="bottom"
                                                                               data-html="true"
                                                                               data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                                <l class="fa fa-refresh"></l>
                                                                            </a>
                                                                        </div><!-- invoice column short end -->
                                                                        <select name="product_name"
                                                                                class="inputs_up form-control"
                                                                                id="product_name">
                                                                            <option value="0">Product</option>

                                                                            @foreach ($products as $product)
                                                                                <option
                                                                                    value={{$product->pro_p_code}} data-parent={{$product->pro_p_code}} data-sale_price={{$product->pro_sale_price}} data-tax={{$product->pro_tax}} data-retailer_dis={{$product->pro_retailer_discount}} data-whole_saler_dis={{$product->pro_whole_seller_discount}} data-loyalty_dis={{$product->pro_loyalty_card_discount}} data-unit={{$product->unit_title}}>{{$product->pro_title}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div><!-- invoice column input end -->
                                                                </div><!-- invoice column box end -->
                                                            </div><!-- invoice column end -->

                                                            {{--                                                            <div class="invoice_col"><!-- invoice column start -->--}}
                                                            {{--                                                                <div class="invoice_col_bx"><!-- invoice column box start -->--}}
                                                            {{--                                                                    <div class=" invoice_col_ttl"><!-- invoice column title start -->--}}
                                                            {{--                                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"--}}
                                                            {{--                                                                           data-placement="bottom" data-html="true"--}}
                                                            {{--                                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.new.product_packages.package_name.description')}}</p>--}}
                                                            {{--                                                                            <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.new.product_packages.package_name.benefits')}}</p>--}}
                                                            {{--                                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.new.product_packages.package_name.example')}}</p>">--}}
                                                            {{--                                                                            <l class="fa fa-info-circle"></l>--}}
                                                            {{--                                                                        </a>--}}
                                                            {{--                                                                        Packages--}}
                                                            {{--                                                                    </div><!-- invoice column title end -->--}}
                                                            {{--                                                                    <div class="invoice_col_input"><!-- invoice column input start -->--}}

                                                            {{--                                                                        <div class="invoice_col_short"><!-- invoice column short start -->--}}
                                                            {{--                                                                            <a href="{{ url('product_packages') }}" class="col_short_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover"--}}
                                                            {{--                                                                               data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">--}}
                                                            {{--                                                                                <l class="fa fa-plus"></l>--}}
                                                            {{--                                                                            </a>--}}
                                                            {{--                                                                            <a id="refresh_package" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom"--}}
                                                            {{--                                                                               data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">--}}
                                                            {{--                                                                                <l class="fa fa-refresh"></l>--}}
                                                            {{--                                                                            </a>--}}
                                                            {{--                                                                        </div><!-- invoice column short end -->--}}
                                                            {{--                                                                        <select name="package" class="inputs_up form-control js-example-basic-multiple" id="package">--}}
                                                            {{--                                                                            <option value="0">Select Package</option>--}}
                                                            {{--                                                                            @foreach($packages as $package)--}}
                                                            {{--                                                                                <option value="{{$package->pp_id}}">--}}
                                                            {{--                                                                                    {{$package->pp_name}}--}}
                                                            {{--                                                                                </option>--}}
                                                            {{--                                                                            @endforeach--}}
                                                            {{--                                                                        </select>--}}
                                                            {{--                                                                    </div><!-- invoice column input end -->--}}
                                                            {{--                                                                </div><!-- invoice column box end -->--}}
                                                            {{--                                                            </div><!-- invoice column end -->--}}

                                                            {{--                                                            <div class="invoice_col"><!-- invoice column start -->--}}
                                                            {{--                                                                <div class="invoice_col_bx"><!-- invoice column box start -->--}}
                                                            {{--                                                                    <div class="required invoice_col_ttl"><!-- invoice column title start -->--}}
                                                            {{--                                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"--}}
                                                            {{--                                                                           data-placement="bottom" data-html="true"--}}
                                                            {{--                                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.general_registration.warehouse.warehouse_title.description')}}</p>--}}
                                                            {{--                                                                             <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.general_registration.warehouse.warehouse_title.benefits')}}</p>--}}
                                                            {{--                                                                                 <h6>Example</h6><p>{{config('fields_info.about_form_fields.general_registration.warehouse.warehouse_title.example')}}</p>">--}}
                                                            {{--                                                                            <l class="fa fa-info-circle"></l>--}}
                                                            {{--                                                                        </a>--}}
                                                            {{--                                                                        Warehouse--}}
                                                            {{--                                                                    </div><!-- invoice column title end -->--}}
                                                            {{--                                                                    <div class="invoice_col_input"><!-- invoice column input start -->--}}

                                                            {{--                                                                        <div class="invoice_col_short"><!-- invoice column short start -->--}}
                                                            {{--                                                                            <a href="{{ url('add_warehouse') }}" class="col_short_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover"--}}
                                                            {{--                                                                               data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">--}}
                                                            {{--                                                                                <l class="fa fa-plus"></l>--}}
                                                            {{--                                                                            </a>--}}
                                                            {{--                                                                            <a id="refresh_package" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom"--}}
                                                            {{--                                                                               data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">--}}
                                                            {{--                                                                                <l class="fa fa-refresh"></l>--}}
                                                            {{--                                                                            </a>--}}
                                                            {{--                                                                        </div><!-- invoice column short end -->--}}
                                                            {{--                                                                        <select name="warehouse" class="inputs_up form-control js-example-basic-multiple" id="warehouse">--}}
                                                            {{--                                                                            <option value="0">Select Warehouse</option>--}}
                                                            {{--                                                                            @foreach($warehouses as $warehouse)--}}
                                                            {{--                                                                                <option value="{{$warehouse->wh_id}}" {{$warehouse->wh_id == 1 ? 'selected':''}}>{{$warehouse->wh_title}}</option>--}}
                                                            {{--                                                                            @endforeach--}}
                                                            {{--                                                                        </select>--}}
                                                            {{--                                                                    </div><!-- invoice column input end -->--}}
                                                            {{--                                                                </div><!-- invoice column box end -->--}}
                                                            {{--                                                            </div><!-- invoice column end -->--}}

                                                            <div class="invoice_col basis_col_21">
                                                                <!-- invoice column start -->
                                                                <div class="invoice_col_bx">
                                                                    <!-- invoice column box start -->
                                                                    <div class="required invoice_col_ttl">
                                                                        <!-- invoice column title start -->
                                                                        <a data-container="body" data-toggle="popover"
                                                                           data-trigger="hover"
                                                                           data-placement="bottom" data-html="true"
                                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.service.service_title.description')}}</p>">
                                                                            <l class="fa fa-info-circle"></l>
                                                                        </a>
                                                                        Services
                                                                    </div><!-- invoice column title end -->
                                                                    <div class="invoice_col_input">
                                                                        <!-- invoice column input start -->
                                                                        <div class="invoice_col_short">
                                                                            <!-- invoice column short start -->
                                                                            <a href="{{ url('product_packages') }}"
                                                                               class="col_short_btn" target="_blank"
                                                                               data-container="body"
                                                                               data-toggle="popover"
                                                                               data-trigger="hover"
                                                                               data-placement="bottom" data-html="true"
                                                                               data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                                <l class="fa fa-plus"></l>
                                                                            </a>
                                                                            <a id="refresh_package"
                                                                               class="col_short_btn"
                                                                               data-container="body"
                                                                               data-toggle="popover"
                                                                               data-trigger="hover"
                                                                               data-placement="bottom"
                                                                               data-html="true"
                                                                               data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                                <l class="fa fa-refresh"></l>
                                                                            </a>
                                                                        </div><!-- invoice column short end -->

                                                                        <select name="service_name"
                                                                                class="inputs_up form-control"
                                                                                id="service_name">
                                                                            <option value="0">Select Service</option>
                                                                        </select>
                                                                    </div><!-- invoice column input end -->
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
                                                                        <div class="pro_tbl_con">
                                                                            <!-- product table container start -->
                                                                            <div class="pro_tbl_bx">
                                                                                <!-- product table box start -->
                                                                                <table class="table gnrl-mrgn-pdng"
                                                                                       id="category_dynamic_table">
                                                                                    <thead>
                                                                                    <tr>
                                                                                        <th class="text-center tbl_srl_4">
                                                                                            Sr.
                                                                                        </th>
                                                                                        {{--                                                                                        <th class="text-center tbl_srl_9">--}}
                                                                                        {{--                                                                                            Code--}}
                                                                                        {{--                                                                                        </th>--}}
                                                                                        <th class="text-center tbl_txt_17">
                                                                                            Title
                                                                                        </th>
                                                                                        <th class="text-center tbl_txt_13">
                                                                                            Remarks
                                                                                        </th>
                                                                                        {{--                                                                                        <th class="text-center tbl_txt_13"> Warehouse</th>--}}
                                                                                        <th class="text-center tbl_srl_4">
                                                                                            Qty
                                                                                        </th>
                                                                                        <th class="text-center tbl_srl_4">
                                                                                            UOM
                                                                                        </th>
                                                                                        {{--                                                                                        <th class="text-center tbl_srl_5">Bonus</th>--}}
                                                                                        <th class="text-center tbl_srl_6">
                                                                                            Rate
                                                                                        </th>
                                                                                        <th class="text-center tbl_srl_4">
                                                                                            Dis%
                                                                                        </th>
                                                                                        <th class="text-center tbl_srl_7">
                                                                                            Dis Amount
                                                                                        </th>
                                                                                        <th class="text-center tbl_srl_4">
                                                                                            Tax%
                                                                                        </th>
                                                                                        <th class="text-center tbl_srl_10">
                                                                                            Tax Amount
                                                                                        </th>
                                                                                        <th class="text-center tbl_srl_4">
                                                                                            Inclu
                                                                                        </th>
                                                                                        <th class="text-center tbl_srl_12">
                                                                                            Amount
                                                                                        </th>
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tbody id="table_body">

                                                                                    </tbody>
                                                                                </table>
                                                                            </div><!-- product table box end -->
                                                                        </div><!-- product table container end -->
                                                                    </div><!-- invoice column end -->


                                                                </div><!-- invoice row end -->
                                                            </div><!-- invoice column end -->

                                                            <div class="invoice_col basis_col_18 hidden" hidden>
                                                                <!-- invoice column start -->

                                                                <div class="invoice_row"><!-- invoice row start -->

                                                                    <div class="invoice_col basis_col_100 hidden"
                                                                         hidden>
                                                                        <!-- invoice column start -->
                                                                        <div class="invoice_col_bx">
                                                                            <!-- invoice column box start -->
                                                                            <div class=" invoice_col_ttl">
                                                                                <!-- invoice column title start -->
                                                                                <a data-container="body"
                                                                                   data-toggle="popover"
                                                                                   data-trigger="hover"
                                                                                   data-placement="bottom"
                                                                                   data-html="true"
                                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.invoice_type.description')}}</p>
                                                                                    <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.invoice_type.benefits')}}</p>
                                                                                      <h6>Example</h6><p>{{config('fields_info.about_form_fields.invoice.invoice_type.example')}}</p>">
                                                                                    <l class="fa fa-info-circle"></l>
                                                                                </a>
                                                                                Invoice Type
                                                                            </div><!-- invoice column title end -->
                                                                            <div class="invoice_col_txt">
                                                                                <!-- invoice column input start -->
                                                                                <div class="radio">
                                                                                    <label>

                                                                                        <input type="radio"
                                                                                               name="invoice_type"
                                                                                               class="invoice_type"
                                                                                               id="invoice_type1"
                                                                                               value="1" checked>
                                                                                        Non Tax Invoice
                                                                                    </label>
                                                                                </div>
                                                                                <div class="radio">
                                                                                    <label>
                                                                                        <input type="radio"
                                                                                               name="invoice_type"
                                                                                               class="invoice_type"
                                                                                               id="invoice_type2"
                                                                                               value="2">
                                                                                        Tax Invoice
                                                                                    </label>
                                                                                </div>
                                                                            </div><!-- invoice column input end -->
                                                                        </div><!-- invoice column box end -->
                                                                    </div><!-- invoice column end -->

                                                                    <div class="invoice_col basis_col_100 hidden"
                                                                         hidden>
                                                                        <!-- invoice column start -->
                                                                        <div class="invoice_col_bx">
                                                                            <!-- invoice column box start -->
                                                                            <div class="invoice_col_ttl">
                                                                                <!-- invoice column title start -->
                                                                                <a data-container="body"
                                                                                   data-toggle="popover"
                                                                                   data-trigger="hover"
                                                                                   data-placement="left"
                                                                                   data-html="true"
                                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.round_off_discount.description')}}</p>
                                                                        <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.round_off_discount.benefits')}}</p>
                                                                        <h6>Example</h6><p>{{config('fields_info.about_form_fields.invoice.round_off_discount.example')}}</p>">
                                                                                    <l class="fa fa-info-circle"></l>
                                                                                </a>
                                                                                Round OFF Discount
                                                                            </div><!-- invoice column title end -->
                                                                            <div class="invoice_col_txt">
                                                                                <!-- invoice column input start -->
                                                                                <div class="custom-checkbox float-left">
                                                                                    <input type="checkbox"
                                                                                           name="round_off"
                                                                                           class="custom-control-input company_info_check_box"
                                                                                           id="round_off" value="1"
                                                                                           onchange="grand_total_calculation();">
                                                                                    <label
                                                                                        class="custom-control-label chck_pdng"
                                                                                        for="round_off"> Auto Round
                                                                                        OFF </label>
                                                                                    <input type="hidden"
                                                                                           name="round_off_discount"
                                                                                           id="round_off_discount"/>
                                                                                </div>
                                                                            </div><!-- invoice column input end -->
                                                                        </div><!-- invoice column box end -->


                                                                    </div><!-- invoice column end -->

                                                                    <div class="invoice_col basis_col_100 hidden"
                                                                         hidden>
                                                                        <!-- invoice column start -->
                                                                        <div class="invoice_col_bx">
                                                                            <!-- invoice column box start -->
                                                                            <div class="invoice_col_ttl">
                                                                                <!-- invoice column title start -->
                                                                                <a data-container="body"
                                                                                   data-toggle="popover"
                                                                                   data-trigger="hover"
                                                                                   data-placement="bottom"
                                                                                   data-html="true"
                                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.item_discount(Product_Dis/Service_Dis).description')}}</p>
                                                                        <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.item_discount(Product_Dis/Service_Dis).benefits')}}</p>
                                                                        <h6>Example</h6><p>{{config('fields_info.about_form_fields.invoice.item_discount(Product_Dis/Service_Dis).example')}}</p>">
                                                                                    <l class="fa fa-info-circle"></l>
                                                                                </a>
                                                                                Items Discount
                                                                            </div><!-- invoice column title end -->
                                                                            <div class="invoice_col_txt">
                                                                                <!-- invoice column input start -->
                                                                                <div class="invoice_inline_input_txt">
                                                                                    <!-- invoice inline input text start -->
                                                                                    <label class="inline_input_txt_lbl"
                                                                                           for="total_product_discount">
                                                                                        Product Dis
                                                                                    </label>
                                                                                    <div class="invoice_col_input">
                                                                                        <input type="text"
                                                                                               name="total_product_discount"
                                                                                               class="inputs_up form-control text-right"
                                                                                               id="total_product_discount"
                                                                                               readonly>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- invoice inline input text end -->

                                                                            </div><!-- invoice column input end -->
                                                                        </div><!-- invoice column box end -->


                                                                    </div><!-- invoice column end -->

                                                                    <div class="invoice_col basis_col_100 hidden"
                                                                         hidden>
                                                                        <!-- invoice column start -->
                                                                        <div class="invoice_col_bx">
                                                                            <!-- invoice column box start -->
                                                                            <div class="invoice_col_ttl">
                                                                                <!-- invoice column title start -->
                                                                                <a data-container="body"
                                                                                   data-toggle="popover"
                                                                                   data-trigger="hover"
                                                                                   data-placement="left"
                                                                                   data-html="true"
                                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.product_tax.description')}}</p>
                                                                        <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.product_tax.benefits')}}</p>
                                                                        <h6>Example</h6><p>{{config('fields_info.about_form_fields.invoice.product_tax.example')}}</p>">
                                                                                    <l class="fa fa-info-circle"></l>
                                                                                </a>
                                                                                Product Tax
                                                                            </div><!-- invoice column title end -->
                                                                            <div class="invoice_col_txt">
                                                                                <!-- invoice column input start -->
                                                                                <div class="invoice_inline_input_txt">
                                                                                    <!-- invoice inline input text start -->
                                                                                    <label class="inline_input_txt_lbl"
                                                                                           for="total_inclusive_tax">
                                                                                        Inclusive Tax
                                                                                    </label>
                                                                                    <div class="invoice_col_input">
                                                                                        <input type="text"
                                                                                               name="total_inclusive_tax"
                                                                                               class="inputs_up form-control text-right"
                                                                                               id="total_inclusive_tax"
                                                                                               readonly>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- invoice inline input text end -->
                                                                                <div class="invoice_inline_input_txt">
                                                                                    <!-- invoice inline input text start -->
                                                                                    <label class="inline_input_txt_lbl"
                                                                                           for="total_exclusive_tax">
                                                                                        Exclusive Tax
                                                                                    </label>
                                                                                    <div class="invoice_col_input">
                                                                                        <input type="text"
                                                                                               name="total_exclusive_tax"
                                                                                               class="inputs_up form-control text-right"
                                                                                               id="total_exclusive_tax"
                                                                                               readonly>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- invoice inline input text end -->

                                                                            </div><!-- invoice column input end -->
                                                                        </div><!-- invoice column box end -->


                                                                    </div><!-- invoice column end -->

                                                                </div><!-- invoice row end -->

                                                            </div><!-- invoice column end -->

                                                        </div><!-- invoice row end -->

                                                        <div class="invoice_row"><!-- invoice row start -->

                                                            <div class="invoice_col basis_col_23 hidden" hidden>
                                                                <!-- invoice column start -->
                                                                <div class="invoice_col_bx">
                                                                    <!-- invoice column box start -->
                                                                    <div class="invoice_col_ttl">
                                                                        <!-- invoice column title start -->
                                                                        <a data-container="body" data-toggle="popover"
                                                                           data-trigger="hover"
                                                                           data-placement="bottom" data-html="true"
                                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.Cash_Discount.description')}}</p>
                                                                        <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.Cash_Discount.benefits')}}</p>
                                                                        <h6>Example</h6><p>{{config('fields_info.about_form_fields.invoice.Cash_Discount.example')}}</p>">
                                                                            <l class="fa fa-info-circle"></l>
                                                                        </a>
                                                                        Cash Discount
                                                                    </div><!-- invoice column title end -->
                                                                    <div class="invoice_col_txt">
                                                                        <!-- invoice column input start -->

                                                                        <div class="invoice_inline_input_txt">
                                                                            <!-- invoice inline input text start -->
                                                                            <label class="inline_input_txt_lbl"
                                                                                   for="disc_percentage">
                                                                                Discount %
                                                                            </label>
                                                                            <div class="invoice_col_input">
                                                                                <input type="text"
                                                                                       name="disc_percentage"
                                                                                       class="inputs_up form-control text-right percentage_textbox"
                                                                                       id="disc_percentage"
                                                                                       placeholder="In percentage"
                                                                                       onkeypress="return allow_only_number_and_decimals(this,event);"
                                                                                       onkeyup="grand_total_calculation();"
                                                                                       onfocus="this.select();">
                                                                            </div>
                                                                        </div><!-- invoice inline input text end -->

                                                                        <div class="invoice_inline_input_txt">
                                                                            <!-- invoice inline input text start -->
                                                                            <label class="inline_input_txt_lbl"
                                                                                   for="disc_amount">
                                                                                Discount (Rs.)
                                                                            </label>
                                                                            <div class="invoice_col_input">
                                                                                <input type="text" name="disc_amount"
                                                                                       class="inputs_up form-control text-right"
                                                                                       id="disc_amount"
                                                                                       onkeypress="return allow_only_number_and_decimals(this,event);"
                                                                                       onkeyup="grand_total_calculation_with_disc_amount();"
                                                                                       onfocus="this.select();">
                                                                            </div>
                                                                        </div><!-- invoice inline input text end -->

                                                                        <div class="invoice_inline_input_txt">
                                                                            <!-- invoice inline input text start -->
                                                                            <label class="inline_input_txt_lbl"
                                                                                   for="service_total_exclusive_tax">
                                                                                Total Discount
                                                                            </label>
                                                                            <div class="invoice_col_input">
                                                                                <input type="text" name="total_discount"
                                                                                       class="inputs_up form-control text-right"
                                                                                       id="total_discount" readonly>
                                                                            </div>
                                                                        </div><!-- invoice inline input text end -->

                                                                    </div><!-- invoice column input end -->
                                                                </div><!-- invoice column box end -->
                                                            </div><!-- invoice column end -->

                                                            <div class="invoice_col basis_col_23">
                                                                <!-- invoice column start -->
                                                                <div class="invoice_col_bx">
                                                                    <!-- invoice column box start -->
                                                                    <div class="invoice_col_ttl">
                                                                        <!-- invoice column title start -->
                                                                        <a data-container="body" data-toggle="popover"
                                                                           data-trigger="hover"
                                                                           data-placement="bottom" data-html="true"
                                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.Total(Total_Item/Sub_Total/Total_Taxes).description')}}</p>">
                                                                            <l class="fa fa-info-circle"></l>
                                                                        </a>
                                                                        Total
                                                                    </div><!-- invoice column title end -->
                                                                    <div class="invoice_col_txt">
                                                                        <!-- invoice column input start -->

                                                                        <div class="invoice_inline_input_txt">
                                                                            <!-- invoice inline input text start -->
                                                                            <label class="inline_input_txt_lbl"
                                                                                   for="total_items">
                                                                                Total Items
                                                                            </label>
                                                                            <div class="invoice_col_input">
                                                                                <input type="text" name="total_items"
                                                                                       class="inputs_up form-control text-right total-items-field"
                                                                                       id="total_items" readonly>
                                                                                {{--                                                        <input type="text" name="service_total_items" class="inputs_up form-control text-right total-items-field" id="service_total_items" readonly>--}}
                                                                            </div>
                                                                        </div><!-- invoice inline input text end -->

                                                                        <div class="invoice_inline_input_txt">
                                                                            <!-- invoice inline input text start -->
                                                                            <label class="inline_input_txt_lbl"
                                                                                   for="total_price">
                                                                                Sub Total
                                                                            </label>
                                                                            <div class="invoice_col_input">
                                                                                <input type="text" name="total_price"
                                                                                       class="inputs_up form-control text-right"
                                                                                       id="total_price" readonly>
                                                                                {{--                                                        <input type="text" name="service_total_price" class="inputs_up form-control text-right" id="service_total_price" readonly>--}}
                                                                            </div>
                                                                        </div><!-- invoice inline input text end -->

                                                                        <div class="invoice_inline_input_txt">
                                                                            <!-- invoice inline input text start -->
                                                                            <label class="inline_input_txt_lbl"
                                                                                   for="total_tax">
                                                                                Total Taxes
                                                                            </label>
                                                                            <div class="invoice_col_input">
                                                                                <input type="text" name="total_tax"
                                                                                       class="inputs_up form-control text-right"
                                                                                       id="total_tax" readonly>
                                                                                {{--                                                        <input type="text" name="service_total_tax" class="inputs_up form-control text-right " id="service_total_tax" readonly>--}}
                                                                            </div>
                                                                        </div><!-- invoice inline input text end -->

                                                                    </div><!-- invoice column input end -->
                                                                </div><!-- invoice column box end -->
                                                            </div><!-- invoice column end -->

                                                            <div class="invoice_col basis_col_27">
                                                                <!-- invoice column start -->
                                                                <div class="invoice_row"><!-- invoice row start -->


                                                                    <div class="invoice_col basis_col_100">
                                                                        <!-- invoice column start -->
                                                                        <div class="invoice_col_bx hidden" hidden>
                                                                            <!-- invoice column box start -->
                                                                            <div class=" invoice_col_ttl">
                                                                                <!-- invoice column title start -->
                                                                                <a data-container="body"
                                                                                   data-toggle="popover"
                                                                                   data-trigger="hover"
                                                                                   data-placement="bottom"
                                                                                   data-html="true"
                                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.Discount_Type.description')}}</p>
                                                                                     <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.invoice.Discount_Type.benefits')}}</p>">
                                                                                    <l class="fa fa-info-circle"></l>
                                                                                </a>
                                                                                Discount Type
                                                                            </div><!-- invoice column title end -->
                                                                            <div class="invoice_col_txt">
                                                                                <!-- invoice column input start -->
                                                                                <div
                                                                                    class="invoice_inline_input_txt with_wrap">

                                                                                    <div class="radio">
                                                                                        <label for="discount_type1">
                                                                                            <input type="radio"
                                                                                                   name="discount_type"
                                                                                                   class="discount_type"
                                                                                                   id="discount_type1"
                                                                                                   value="1" checked>
                                                                                            Non
                                                                                        </label>
                                                                                    </div>

                                                                                    <div class="radio">
                                                                                        <label for="discount_type2">
                                                                                            <input type="radio"
                                                                                                   name="discount_type"
                                                                                                   class="discount_type"
                                                                                                   id="discount_type2"
                                                                                                   value="2">
                                                                                            Retailer
                                                                                        </label>
                                                                                    </div>

                                                                                    <div class="radio">
                                                                                        <label for="discount_type3">
                                                                                            <input type="radio"
                                                                                                   name="discount_type"
                                                                                                   class="discount_type"
                                                                                                   id="discount_type3"
                                                                                                   value="3">
                                                                                            Wholesaler
                                                                                        </label>
                                                                                    </div>

                                                                                    <div class="radio">
                                                                                        <label for="discount_type4">
                                                                                            <input type="radio"
                                                                                                   name="discount_type"
                                                                                                   class="discount_type"
                                                                                                   id="discount_type4"
                                                                                                   value="4">
                                                                                            Loyalty Card
                                                                                        </label>
                                                                                    </div>


                                                                                </div>

                                                                            </div><!-- invoice column input end -->
                                                                        </div><!-- invoice column box end -->
                                                                    </div><!-- invoice column end -->

                                                                    <div class="invoice_col basis_col_100">
                                                                        <!-- invoice column start -->
                                                                        <div class="invoice_col_bx">
                                                                            <!-- invoice column box start -->
                                                                            <label class=" invoice_col_ttl">
                                                                                <!-- invoice column title start -->
                                                                                <a data-container="body"
                                                                                   data-toggle="popover"
                                                                                   data-trigger="hover"
                                                                                   data-placement="bottom"
                                                                                   data-html="true"
                                                                                   data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.invoice.grand_total.description')}}</p>">
                                                                                    <l class="fa fa-info-circle"></l>
                                                                                </a>
                                                                                Grand Total
                                                                            </label><!-- invoice column title end -->
                                                                            <div class="invoice_col_txt ghiki">
                                                                                <!-- invoice column input start -->
                                                                                <h5 id="grand_total_text">
                                                                                    {{--                                                                1,450,304,074.17--}}
                                                                                    000,000
                                                                                </h5>

                                                                                <input type="hidden" name="grand_total"
                                                                                       id="grand_total"/>

                                                                            </div><!-- invoice column input end -->
                                                                        </div><!-- invoice column box end -->
                                                                    </div><!-- invoice column end -->


                                                                </div><!-- invoice row end -->
                                                            </div><!-- invoice column end -->

                                                        </div><!-- invoice row end -->

                                                        <div class="invoice_row"><!-- invoice row start -->

                                                            <div class="invoice_col basis_col_100">
                                                                <!-- invoice column start -->
                                                                <div class="invoice_col_txt with_cntr_jstfy">
                                                                    <!-- invoice column box start -->
                                                                    <div
                                                                        class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                                        <button id="clear_discount_btn" type="button"
                                                                                class="invoice_frm_btn">
                                                                            Clear Discount
                                                                        </button>
                                                                    </div>
                                                                    {{--                                                                    <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">--}}
                                                                    {{--                                                                        <button type="submit" class="invoice_frm_btn" onclick="return popvalidation()">--}}
                                                                    {{--                                                                            Save (Ctrl+S)--}}
                                                                    {{--                                                                        </button>--}}
                                                                    {{--                                                                        <span id="check_product_count" class="validate_sign"></span>--}}
                                                                    {{--                                                                    </div>--}}
                                                                    <div
                                                                        class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                                        <button id="all_clear_form" type="button"
                                                                                class="invoice_frm_btn">
                                                                            Clear (Ctrl+X)
                                                                        </button>
                                                                    </div>
                                                                </div><!-- invoice column box end -->
                                                            </div><!-- invoice column end -->


                                                        </div><!-- invoice row end -->

                                                    </div><!-- invoice content end -->
                                                </div><!-- invoice scroll box end -->
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="orderList" role="tabpanel">
                                            <div class="pd-20">
                                                <input type="hidden" id="data" data-company-id=""
                                                       data-region-id=""
                                                       data-region-action="{{ route('api.regions.options') }}"
                                                  >

                                                <div class="row credentials_div">

                                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl">

                                                        <!-- invoice scroll box start -->
                                                        <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt">
                                                            <!-- invoice content start -->
                                                            <div class="invoice_row">
                                                                <div class="invoice_col basis_col_12">
                                                                    <!-- invoice column start -->
                                                                    <div class="invoice_col_bx">
                                                                        <!-- invoice column box start -->
                                                                        <div class="required invoice_col_ttl">
                                                                            <!-- invoice column title start -->

                                                                            Enable/Disable fileds
                                                                        </div><!-- invoice column title end -->
                                                                        <div class="invoice_col_input ">
                                                                            <!-- invoice column input start -->
                                                                            <div class="invoice_col_short">
                                                                                <!-- invoice column short start -->

                                                                            </div><!-- invoice column short end -->
                                                                            <input type="checkbox"
                                                                                   name="order_list_enable"
                                                                                   id="order_list_enable" value="1"
                                                                                   class="inputs_up form-control">

                                                                        </div><!-- invoice column input end -->
                                                                    </div><!-- invoice column box end -->
                                                                </div><!-- invoice column end -->
                                                            </div>
                                                            <div class="invoice_row order_list"><!-- invoice row start -->

                                                                <div class="invoice_col basis_col_15">
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
                                                                            <select name="companys" id="companys"
                                                                                    data-fetch-url="{{ route('api.companies.options') }}"
                                                                                    class="inputs_up form-control auto-select company_dropdown"
                                                                                    required>
                                                                                <option value="" selected disabled>
                                                                                    Select Company
                                                                                </option>
                                                                                @foreach ($parties as $company)
                                                                                    <option
                                                                                        value="{{ $company->account_uid }}"
                                                                                        data-company-id="{{ $company->account_uid }}">{{ $company->account_name }}</option>
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
                                                                            <select name="regions" id="regions"
                                                                                    class="inputs_up form-control"
                                                                                    required>
                                                                                <option value="" selected disabled>
                                                                                    Select Company
                                                                                    First
                                                                                </option>
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

                                                                            </div><!-- invoice column short end -->
                                                                            <select name="product_name_list" id="product_name_list"
                                                                                    class="inputs_up form-control @error('product_name_list') is-invalid @enderror"
                                                                                    required>
                                                                                <option value="0">Product</option>

                                                                                @foreach ($products as $product)
                                                                                    <option
                                                                                        value={{$product->pro_p_code}} data-parent={{$product->pro_p_code}} data-sale_price={{$product->pro_sale_price}} data-tax={{$product->pro_tax}} data-retailer_dis={{$product->pro_retailer_discount}} data-whole_saler_dis={{$product->pro_whole_seller_discount}} data-loyalty_dis={{$product->pro_loyalty_card_discount}} data-unit={{$product->unit_title}}>{{$product->pro_title}}</option>
                                                                                @endforeach
                                                                            </select>


                                                                        </div><!-- invoice column input end -->
                                                                    </div><!-- invoice column box end -->
                                                                </div><!-- invoice column end -->

                                                                <div class="invoice_col basis_col_10">
                                                                    <!-- invoice column start -->
                                                                    <div class="invoice_col_bx">
                                                                        <!-- invoice column box start -->
                                                                        <div class="required invoice_col_ttl">
                                                                            <!-- invoice column title start -->

                                                                            Quantity
                                                                        </div><!-- invoice column title end -->
                                                                        <div class="invoice_col_input">
                                                                            <!-- invoice column input start -->

                                                                            <div class="invoice_col_short">
                                                                                <!-- invoice column short start -->

                                                                            </div><!-- invoice column short end -->
                                                                            <input type="text" name="pro_qty" id="pro_qty" class="inputs_up text-right form-control" placeholder="Quantity" required>

                                                                        </div><!-- invoice column input end -->
                                                                    </div><!-- invoice column box end -->
                                                                </div><!-- invoice column end -->

                                                                <div class="invoice_col basis_col_15">
                                                                    <!-- invoice column start -->
                                                                    <div class="invoice_col_bx">
                                                                        <!-- invoice column box start -->
                                                                        <div class="required invoice_col_ttl">
                                                                            <!-- invoice column title start -->

                                                                            Remarks
                                                                        </div><!-- invoice column title end -->
                                                                        <div class="invoice_col_input">
                                                                            <!-- invoice column input start -->

                                                                            <div class="invoice_col_short">
                                                                                <!-- invoice column short start -->

                                                                            </div><!-- invoice column short end -->
                                                                            <input type="text" name="order_remarks" class="inputs_up form-control" id="order_remarks" placeholder="Remarks" value="">


                                                                        </div><!-- invoice column input end -->
                                                                    </div><!-- invoice column box end -->
                                                                </div><!-- invoice column end -->


                                                                <div class="invoice_col basis_col_10">
                                                                    <!-- invoice column start -->
                                                                    <div class="invoice_col_txt for_voucher_col_bx">
                                                                        <!-- invoice column box start -->
                                                                        <div class="invoice_col_txt with_cntr_jstfy">
                                                                            <div
                                                                                class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                                                <button id="first_add_more"
                                                                                        class="invoice_frm_btn"
                                                                                        onclick="add_order_list()"
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
                                                                                                Company
                                                                                            </th>
                                                                                            <th class="text-center tbl_txt_20">
                                                                                                Region
                                                                                            </th>
                                                                                            {{--                                                                    <th class="text-center tbl_srl_20">--}}
                                                                                            {{--                                                                        Warehouse--}}
                                                                                            {{--                                                                    </th>--}}
                                                                                            <th class="text-center tbl_txt_44">
                                                                                                Zone
                                                                                            </th>
                                                                                            <th class="text-center tbl_srl_6">
                                                                                                City
                                                                                            </th>
                                                                                            <th class="text-center tbl_srl_12">
                                                                                                Grid
                                                                                            </th>
                                                                                            <th class="text-center tbl_srl_12">
                                                                                                Franchise
                                                                                            </th>
                                                                                        </tr>
                                                                                        </thead>

                                                                                        <tbody id="table_body_or">
                                                                                        <tr>
                                                                                            <td colspan="10"
                                                                                                align="center">
                                                                                                No Entry
                                                                                            </td>
                                                                                        </tr>
                                                                                        </tbody>

                                                                                        <tfoot>

                                                                                        </tfoot>

                                                                                    </table>
                                                                                </div><!-- product table box end -->
                                                                            </div><!-- product table container end -->
                                                                        </div><!-- invoice column end -->


                                                                    </div><!-- invoice row end -->
                                                                </div><!-- invoice column end -->

                                                            </div><!-- invoice row end -->

                                                        </div><!-- invoice content end -->
                                                    </div><!-- invoice scroll box end -->


                                                    <input type="hidden" name="working_area_array"
                                                           id="working_area_array">

                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="profile" role="tabpanel">
                                            <div class="pd-20">
                                                <input type="hidden" id="data" data-company-id=""
                                                       data-region-id=""
                                                       data-region-action="{{ route('api.regions.options') }}"
                                                       data-zone-id=""
                                                       data-zone-action="{{ route('api.zones.options') }}"
                                                       data-city-id=""
                                                       data-city-action="{{ route('api.cities.options') }}"
                                                       data-grid-id=""
                                                       data-grid-action="{{ route('api.grids.options') }}"
                                                       data-franchise-area-id=""
                                                       data-franchise-area-action="{{ route('api.franchise-area.options') }}">

                                                <div class="row credentials_div">

                                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl">

                                                        <!-- invoice scroll box start -->
                                                        <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt">
                                                            <!-- invoice content start -->
                                                            <div class="invoice_row">
                                                                <div class="invoice_col basis_col_12">
                                                                    <!-- invoice column start -->
                                                                    <div class="invoice_col_bx">
                                                                        <!-- invoice column box start -->
                                                                        <div class="required invoice_col_ttl">
                                                                            <!-- invoice column title start -->

                                                                            Enable/Disable fileds
                                                                        </div><!-- invoice column title end -->
                                                                        <div class="invoice_col_input ">
                                                                            <!-- invoice column input start -->
                                                                            <div class="invoice_col_short">
                                                                                <!-- invoice column short start -->

                                                                            </div><!-- invoice column short end -->
                                                                            <input type="checkbox"
                                                                                   name="working_area_enable"
                                                                                   id="working_area_enable" value="1"
                                                                                   class="inputs_up form-control">

                                                                        </div><!-- invoice column input end -->
                                                                    </div><!-- invoice column box end -->
                                                                </div><!-- invoice column end -->
                                                            </div>
                                                            <div class="invoice_row working"><!-- invoice row start -->

                                                                <div class="invoice_col basis_col_10">
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
                                                                            <select name="company" id="company"
                                                                                    data-fetch-url="{{ route('api.companies.options') }}"
                                                                                    class="inputs_up form-control auto-select company_dropdown"
                                                                                    required>
                                                                                <option value="" selected disabled>
                                                                                    Select Company
                                                                                </option>
                                                                                @foreach ($parties as $company)
                                                                                    <option
                                                                                        value="{{ $company->account_uid }}"
                                                                                        data-company-id="{{ $company->account_uid }}">{{ $company->account_name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            {{--                                                                            <select name="product_code" class="inputs_up form-control"--}}
                                                                            {{--                                                                                    id="product_code">--}}
                                                                            {{--                                                                                <option value="0">Code</option>--}}

                                                                            {{--                                                                            </select>--}}
                                                                        </div><!-- invoice column input end -->
                                                                    </div><!-- invoice column box end -->
                                                                </div><!-- invoice column end -->

                                                                <div class="invoice_col basis_col_10">
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
                                                                            <select name="region" id="region"
                                                                                    class="inputs_up form-control"
                                                                                    required>
                                                                                <option value="" selected disabled>
                                                                                    Select Company
                                                                                    First
                                                                                </option>
                                                                            </select>

                                                                        </div><!-- invoice column input end -->
                                                                    </div><!-- invoice column box end -->
                                                                </div><!-- invoice column end -->

                                                                <div class="invoice_col basis_col_10">
                                                                    <!-- invoice column start -->
                                                                    <div class="invoice_col_bx">
                                                                        <!-- invoice column box start -->
                                                                        <div class="required invoice_col_ttl">
                                                                            <!-- invoice column title start -->

                                                                            Zone
                                                                        </div><!-- invoice column title end -->
                                                                        <div class="invoice_col_input">
                                                                            <!-- invoice column input start -->

                                                                            <div class="invoice_col_short">
                                                                                <!-- invoice column short start -->
                                                                                <a href="{{ route('zones.create') }}"
                                                                                   class="col_short_btn"
                                                                                   target="_blank">
                                                                                    <i class="fa fa-plus"></i>
                                                                                </a>
                                                                                <a onclick="$('select#region').trigger('change');"
                                                                                   class="col_short_btn">
                                                                                    <l class="fa fa-refresh"></l>
                                                                                </a>
                                                                            </div><!-- invoice column short end -->
                                                                            <select name="zone" id="zone"
                                                                                    class="inputs_up form-control @error('zone') is-invalid @enderror"
                                                                                    required>
                                                                                <option value="" selected disabled>
                                                                                    Select Region First
                                                                                </option>
                                                                            </select>
                                                                            {{--                                                                            <select name="warehouse"--}}
                                                                            {{--                                                                                    class="inputs_up form-control"--}}
                                                                            {{--                                                                                    id="warehouse">--}}
                                                                            {{--                                                                                <option value="0">Warehouse</option>--}}
                                                                            {{--                                                                                @foreach($warehouses as $warehouse)--}}
                                                                            {{--                                                                                    <option--}}
                                                                            {{--                                                                                        value="{{$warehouse->wh_id}}" {{$warehouse->wh_id == 1 ? 'selected':''}}>--}}
                                                                            {{--                                                                                        {{$warehouse->wh_title}}--}}
                                                                            {{--                                                                                    </option>--}}
                                                                            {{--                                                                                @endforeach--}}
                                                                            {{--                                                                            </select>--}}
                                                                        </div><!-- invoice column input end -->
                                                                    </div><!-- invoice column box end -->
                                                                </div><!-- invoice column end -->

                                                                <div class="invoice_col basis_col_10">
                                                                    <!-- invoice column start -->
                                                                    <div class="invoice_col_bx">
                                                                        <!-- invoice column box start -->
                                                                        <div class="required invoice_col_ttl">
                                                                            <!-- invoice column title start -->

                                                                            City
                                                                        </div><!-- invoice column title end -->
                                                                        <div class="invoice_col_input">
                                                                            <!-- invoice column input start -->

                                                                            <div class="invoice_col_short">
                                                                                <!-- invoice column short start -->
                                                                                <a href="{{ route('circles.create') }}"
                                                                                   class="col_short_btn"
                                                                                   target="_blank">
                                                                                    <i class="fa fa-plus"></i>
                                                                                </a>
                                                                                <a onclick="$('select#zone').trigger('change');"
                                                                                   class="col_short_btn">
                                                                                    <l class="fa fa-refresh"></l>
                                                                                </a>
                                                                            </div><!-- invoice column short end -->
                                                                            <select name="city" id="city"
                                                                                    class="inputs_up form-control @error('city') is-invalid @enderror"
                                                                                    required>
                                                                                <option value="" selected disabled>
                                                                                    Select Zone First
                                                                                </option>
                                                                            </select>

                                                                        </div><!-- invoice column input end -->
                                                                    </div><!-- invoice column box end -->
                                                                </div><!-- invoice column end -->

                                                                <div class="invoice_col basis_col_10">
                                                                    <!-- invoice column start -->
                                                                    <div class="invoice_col_bx">
                                                                        <!-- invoice column box start -->
                                                                        <div class="required invoice_col_ttl">
                                                                            <!-- invoice column title start -->

                                                                            Grid
                                                                        </div><!-- invoice column title end -->
                                                                        <div class="invoice_col_input">
                                                                            <!-- invoice column input start -->

                                                                            <div class="invoice_col_short">
                                                                                <!-- invoice column short start -->
                                                                                <a href="{{ route('grids.create') }}"
                                                                                   class="col_short_btn"
                                                                                   target="_blank">
                                                                                    <i class="fa fa-plus"></i>
                                                                                </a>
                                                                                <a onclick="$('select#city').trigger('change');"
                                                                                   class="col_short_btn">
                                                                                    <l class="fa fa-refresh"></l>
                                                                                </a>
                                                                            </div><!-- invoice column short end -->
                                                                            <select name="grid" id="grid"
                                                                                    class="inputs_up form-control @error('grid') is-invalid @enderror"
                                                                                    required>
                                                                                <option value="" selected disabled>
                                                                                    Select City First
                                                                                </option>
                                                                            </select>

                                                                        </div><!-- invoice column input end -->
                                                                    </div><!-- invoice column box end -->
                                                                </div><!-- invoice column end -->

                                                                <div class="invoice_col basis_col_10">
                                                                    <!-- invoice column start -->
                                                                    <div class="invoice_col_bx">
                                                                        <!-- invoice column box start -->
                                                                        <div class="required invoice_col_ttl">
                                                                            <!-- invoice column title start -->

                                                                            Franchise
                                                                        </div><!-- invoice column title end -->
                                                                        <div class="invoice_col_input">
                                                                            <!-- invoice column input start -->

                                                                            <div class="invoice_col_short">
                                                                                <!-- invoice column short start -->
                                                                                <a href="{{ route('franchise-area.create') }}"
                                                                                   class="col_short_btn"
                                                                                   target="_blank">
                                                                                    <i class="fa fa-plus"></i>
                                                                                </a>
                                                                                <a onclick="$('select#grid').trigger('change');"
                                                                                   class="col_short_btn">
                                                                                    <l class="fa fa-refresh"></l>
                                                                                </a>
                                                                            </div><!-- invoice column short end -->
                                                                            <select name="franchiseArea"
                                                                                    id="franchiseArea"
                                                                                    class="inputs_up form-control @error('franchiseArea') is-invalid @enderror"
                                                                                    required>
                                                                                <option value="" selected disabled>
                                                                                    Select Grid First
                                                                                </option>
                                                                            </select>

                                                                        </div><!-- invoice column input end -->
                                                                    </div><!-- invoice column box end -->
                                                                </div><!-- invoice column end -->

                                                                <div class="invoice_col basis_col_10">
                                                                    <!-- invoice column start -->
                                                                    <div class="invoice_col_bx">
                                                                        <!-- invoice column box start -->
                                                                        <div class="required invoice_col_ttl">
                                                                            <!-- invoice column title start -->

                                                                            Survey Person
                                                                        </div><!-- invoice column title end -->
                                                                        <div class="invoice_col_input">
                                                                            <!-- invoice column input start -->

                                                                            <div class="invoice_col_short">
                                                                                <!-- invoice column short start -->
                                                                                <a href="{{ route('circles.create') }}"
                                                                                   class="col_short_btn"
                                                                                   target="_blank">
                                                                                    <i class="fa fa-plus"></i>
                                                                                </a>
                                                                                <a onclick="$('select#grid').trigger('change');"
                                                                                   class="col_short_btn">
                                                                                    <l class="fa fa-refresh"></l>
                                                                                </a>
                                                                            </div><!-- invoice column short end -->
                                                                            <select name="survey_person"
                                                                                    id="survey_person"
                                                                                    class="inputs_up form-control @error('circle') is-invalid @enderror"
                                                                                    required>
                                                                                <option value="" selected disabled>
                                                                                    Select Franchise First
                                                                                </option>
                                                                            </select>

                                                                        </div><!-- invoice column input end -->
                                                                    </div><!-- invoice column box end -->
                                                                </div><!-- invoice column end -->

                                                                <div class="invoice_col basis_col_10">
                                                                    <!-- invoice column start -->
                                                                    <div class="invoice_col_bx">
                                                                        <!-- invoice column box start -->
                                                                        <div class="required invoice_col_ttl">
                                                                            <!-- invoice column title start -->

                                                                            Supervisor
                                                                        </div><!-- invoice column title end -->
                                                                        <div class="invoice_col_input">
                                                                            <!-- invoice column input start -->

                                                                            <div class="invoice_col_short">
                                                                                <!-- invoice column short start -->
                                                                                <a href="{{ route('circles.create') }}"
                                                                                   class="col_short_btn"
                                                                                   target="_blank">
                                                                                    <i class="fa fa-plus"></i>
                                                                                </a>
                                                                                <a onclick="$('select#grid').trigger('change');"
                                                                                   class="col_short_btn">
                                                                                    <l class="fa fa-refresh"></l>
                                                                                </a>
                                                                            </div><!-- invoice column short end -->
                                                                            <select name="supervisor"
                                                                                    id="supervisor"
                                                                                    class="inputs_up form-control @error('circle') is-invalid @enderror"
                                                                                    required>
                                                                                <option value="" selected disabled>
                                                                                    Select Franchise First
                                                                                </option>
                                                                            </select>

                                                                        </div><!-- invoice column input end -->
                                                                    </div><!-- invoice column box end -->
                                                                </div><!-- invoice column end -->


                                                                <div class="invoice_col basis_col_18">
                                                                    <!-- invoice column start -->
                                                                    <div class="invoice_col_txt for_voucher_col_bx">
                                                                        <!-- invoice column box start -->
                                                                        <div class="invoice_col_txt with_cntr_jstfy">
                                                                            <div
                                                                                class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                                                <button id="first_add_more"
                                                                                        class="invoice_frm_btn"
                                                                                        onclick="add_working_area()"
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
                                                                                                Company
                                                                                            </th>
                                                                                            <th class="text-center tbl_txt_20">
                                                                                                Region
                                                                                            </th>
                                                                                            {{--                                                                    <th class="text-center tbl_srl_20">--}}
                                                                                            {{--                                                                        Warehouse--}}
                                                                                            {{--                                                                    </th>--}}
                                                                                            <th class="text-center tbl_txt_44">
                                                                                                Zone
                                                                                            </th>
                                                                                            <th class="text-center tbl_srl_6">
                                                                                                City
                                                                                            </th>
                                                                                            <th class="text-center tbl_srl_12">
                                                                                                Grid
                                                                                            </th>
                                                                                            <th class="text-center tbl_srl_12">
                                                                                                Franchise
                                                                                            </th>
                                                                                        </tr>
                                                                                        </thead>

                                                                                        <tbody id="table_bodys">
                                                                                        <tr>
                                                                                            <td colspan="10"
                                                                                                align="center">
                                                                                                No Entry
                                                                                            </td>
                                                                                        </tr>
                                                                                        </tbody>

                                                                                        <tfoot>

                                                                                        </tfoot>

                                                                                    </table>
                                                                                </div><!-- product table box end -->
                                                                            </div><!-- product table container end -->
                                                                        </div><!-- invoice column end -->


                                                                    </div><!-- invoice row end -->
                                                                </div><!-- invoice column end -->

                                                            </div><!-- invoice row end -->

                                                        </div><!-- invoice content end -->
                                                    </div><!-- invoice scroll box end -->


                                                    <input type="hidden" name="working_area_array"
                                                           id="working_area_array">

                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="credentials" role="tabpanel">
                                            <div class="pd-20">

                                                <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl">
                                                    <!-- invoice scroll box start -->
                                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt">
                                                        <!-- invoice content start -->
                                                        <div class="invoice_row"><!-- invoice row start -->

                                                            <div class="invoice_col basis_col_11">
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
                                                                            {{--                                                                            <a href="{{ route('add_product') }}" class="col_short_btn"--}}
                                                                            {{--                                                                               target="_blank">--}}
                                                                            {{--                                                                                <i class="fa fa-plus"></i>--}}
                                                                            {{--                                                                            </a>--}}
                                                                            {{--                                                                            <a id="refresh_product_code" class="col_short_btn">--}}
                                                                            {{--                                                                                <i class="fa fa-refresh"></i>--}}
                                                                            {{--                                                                            </a>--}}
                                                                        </div><!-- invoice column short end -->
                                                                        <select name="type_of_expense"
                                                                                class="inputs_up form-control"
                                                                                id="type_of_expense">
                                                                            <option value="0" selected disabled>Select
                                                                                Expense
                                                                            </option>
                                                                            @foreach ($expenses as $expense)
                                                                                <option
                                                                                    value="{{ $expense->account_id }}">{{ $expense->account_name }}</option>
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

                                                                        Party
                                                                    </div><!-- invoice column title end -->
                                                                    <div class="invoice_col_input">
                                                                        <!-- invoice column input start -->

                                                                        <div class="invoice_col_short">
                                                                            <!-- invoice column short start -->

                                                                        </div><!-- invoice column short end -->
                                                                        <select name="party[]"
                                                                                class="inputs_up form-control party"
                                                                                multiple
                                                                                id="party">
                                                                            <option value="0" disabled>Select party
                                                                            </option>
                                                                            @foreach ($exp_parties as $party)
                                                                                <option
                                                                                    value="{{ $party->account_uid }}">{{ $party->account_name }}</option>
                                                                            @endforeach

                                                                        </select>

                                                                    </div><!-- invoice column input end -->
                                                                </div><!-- invoice column box end -->
                                                            </div><!-- invoice column end -->

                                                            {{--                                        <div class="invoice_col basis_col_16"><!-- invoice column start -->--}}
                                                            {{--                                            <div class="invoice_col_bx"><!-- invoice column box start -->--}}
                                                            {{--                                                <div class="required invoice_col_ttl"><!-- invoice column title start -->--}}
                                                            {{--                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"--}}
                                                            {{--                                                       data-placement="bottom" data-html="true"--}}
                                                            {{--                                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.general_registration.warehouse.warehouse_title.description')}}</p>--}}
                                                            {{--                                            <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.general_registration.warehouse.warehouse_title.benefits')}}</p>--}}
                                                            {{--                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.general_registration.warehouse.warehouse_title.example')}}</p>">--}}
                                                            {{--                                                        <l class="fa fa-info-circle"></l>--}}
                                                            {{--                                                    </a>--}}
                                                            {{--                                                    Warehouse--}}
                                                            {{--                                                </div><!-- invoice column title end -->--}}
                                                            {{--                                                <div class="invoice_col_input"><!-- invoice column input start -->--}}

                                                            {{--                                                    <div class="invoice_col_short"><!-- invoice column short start -->--}}
                                                            {{--                                                        <a href="{{ route('add_warehouse') }}" class="col_short_btn" target="_blank">--}}
                                                            {{--                                                            <i class="fa fa-plus"></i>--}}
                                                            {{--                                                        </a>--}}
                                                            {{--                                                        <a id="refresh_warehouse" class="col_short_btn">--}}
                                                            {{--                                                            <l class="fa fa-refresh"></l>--}}
                                                            {{--                                                        </a>--}}
                                                            {{--                                                    </div><!-- invoice column short end -->--}}
                                                            {{--                                                    <select name="warehouse" class="inputs_up form-control" id="warehouse">--}}
                                                            {{--                                                        --}}{{--                                                        <option value="0">Warehouse</option>--}}
                                                            {{--                                                        @foreach($warehouses as $warehouse)--}}
                                                            {{--                                                            <option--}}
                                                            {{--                                                                value="{{$warehouse->wh_id}}" {{$warehouse->wh_id == 1 ? 'selected':''}}>--}}
                                                            {{--                                                                {{$warehouse->wh_title}}--}}
                                                            {{--                                                            </option>--}}
                                                            {{--                                                        @endforeach--}}
                                                            {{--                                                    </select>--}}
                                                            {{--                                                </div><!-- invoice column input end -->--}}
                                                            {{--                                            </div><!-- invoice column box end -->--}}
                                                            {{--                                        </div><!-- invoice column end -->--}}

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
                                                                        <input type="text" name="expense_remarks"
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
                                                                        <input type="text" name="limit_pec"
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
                                                                        <input type="text" name="limit"
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
                                                            {{--                                                                        <input type="text" name="rate"--}}
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
                                                            {{--                                                                        <input type="text" name="amount"--}}
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
                                                                            <button id="first_add_more_ex"
                                                                                    class="invoice_frm_btn"
                                                                                    onclick="add_expense()"
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
                                                                                        <th class="text-center tbl_txt_20">
                                                                                            Party
                                                                                        </th>
                                                                                        {{--                                                                    <th class="text-center tbl_srl_20">--}}
                                                                                        {{--                                                                        Warehouse--}}
                                                                                        {{--                                                                    </th>--}}
                                                                                        <th class="text-center tbl_txt_38">
                                                                                            Expense Remarks
                                                                                        </th>
                                                                                        <th class="text-center tbl_srl_6">
                                                                                            Limit %
                                                                                        </th>
                                                                                        <th class="text-center tbl_srl_6">
                                                                                            Limit
                                                                                        </th>
                                                                                        {{--                                                                                        <th class="text-center tbl_srl_12">--}}
                                                                                        {{--                                                                                            Rate--}}
                                                                                        {{--                                                                                        </th>--}}
                                                                                        {{--                                                                                        <th class="text-center tbl_srl_12">--}}
                                                                                        {{--                                                                                            Amount--}}
                                                                                        {{--                                                                                        </th>--}}
                                                                                    </tr>
                                                                                    </thead>

                                                                                    <tbody id="table_body_ex">
                                                                                    <tr>
                                                                                        <td colspan="10" align="center">
                                                                                            No Entry
                                                                                        </td>
                                                                                    </tr>
                                                                                    </tbody>

                                                                                    <tfoot>
                                                                                    <tr>
                                                                                        <th colspan="4"
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
                                                                                                    <input type="text"
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
                                                        {{--                                                                        <button type="submit" name="save" id="save" class="invoice_frm_btn"--}}
                                                        {{--                                                                            --}}{{--                                                            onclick="return popvalidation()"--}}
                                                        {{--                                                                        >--}}
                                                        {{--                                                                            <i class="fa fa-floppy-o"></i> Save--}}
                                                        {{--                                                                        </button>--}}
                                                        {{--                                                                        <span id="demo28" class="validate_sign"></span>--}}
                                                        {{--                                                                    </div>--}}
                                                        {{--                                                                </div><!-- invoice column box end -->--}}
                                                        {{--                                                            </div><!-- invoice column end -->--}}


                                                        {{--                                                        </div><!-- invoice row end -->--}}

                                                    </div><!-- invoice content end -->
                                                </div><!-- invoice scroll box end -->

                                                <input type="hidden" name="expense_array" id="expense_array">
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="material" role="tabpanel">
                                            <div class="pd-20">

                                                <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl">
                                                    <!-- invoice scroll box start -->
                                                    <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt">
                                                        <!-- invoice content start -->

                                                        <div class="invoice_row"><!-- invoice row start -->

                                                            <div class="invoice_col basis_col_11" hidden>
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
                                                                                            data-sale_price={{$product->pro_sale_price}} data-tax={{$product->pro_tax}}
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
                                                                        <select name="material_product_name"
                                                                                class="inputs_up form-control"
                                                                                id="material_product_name">
                                                                            <option value="0">Product</option>
                                                                            @foreach ($products as $product)
                                                                                <option
                                                                                    value={{$product->pro_p_code}} data-parent={{$product->pro_p_code}} data-sale_price={{$product->pro_sale_price}}
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
                                                                        <input type="text" name="material_remarks"
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
                                                                        <input type="text" name="uom_material"
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
                                                                        <input type="text" name="quantity_material"
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
                                                                        <input type="text" name="rate_material"
                                                                               class="inputs_up text-right form-control"
                                                                               id="rate_material"
                                                                               placeholder="Rate"
                                                                               onkeypress="return allow_only_number_and_decimals(this,event);"
                                                                               onkeyup="product_amount_calculation();"/>
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
                                                                        <input type="text" name="amount_material"
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
                                                                            <button id="first_add_more_material"
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
                                                                        <button type="submit" name="save" id="save" class="invoice_frm_btn"
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
                                        </div>

                                        {{--//////////////////////////// Recepie code end --}}

                                        <div class="tab-pane fade" id="workOrder" role="tabpanel">
                                            <div class="pd-20">
                                            </div>

                                        <hr class="mb-3">

                                        <div class="invoice_row ml-3"><!-- invoice row start -->

                                            <div class="invoice_col basis_col_23">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="invoice_col_ttl">
                                                        <!-- invoice column title start -->

                                                        Total OverHead
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_txt">
                                                        <!-- invoice column input start -->

                                                        <div class="invoice_inline_input_txt">
                                                            <!-- invoice inline input text start -->
                                                            <label class="inline_input_txt_lbl"
                                                                   for="total_items">
                                                                Material OverHead
                                                            </label>
                                                            <div class="invoice_col_input">
                                                                <input type="text"
                                                                       class="inputs_up form-control text-right total-items-field"
                                                                       id="grand_total_material_output" readonly>
                                                                {{--                                                        <input type="text" name="service_total_items" class="inputs_up form-control text-right total-items-field" id="service_total_items" readonly>--}}
                                                            </div>
                                                        </div><!-- invoice inline input text end -->

                                                        <div class="invoice_inline_input_txt">
                                                            <!-- invoice inline input text start -->
                                                            <label class="inline_input_txt_lbl"
                                                                   for="total_price">
                                                                Expense OverHead
                                                            </label>
                                                            <div class="invoice_col_input">
                                                                <input type="text"
                                                                       class="inputs_up form-control text-right"
                                                                       id="grand_total_exp_output" readonly>
                                                                {{--                                                        <input type="text" name="service_total_price" class="inputs_up form-control text-right" id="service_total_price" readonly>--}}
                                                            </div>
                                                        </div><!-- invoice inline input text end -->

                                                        <div class="invoice_inline_input_txt">
                                                            <!-- invoice inline input text start -->
                                                            <label class="inline_input_txt_lbl"
                                                                   for="total_tax">
                                                                Total OverHead
                                                            </label>
                                                            <div class="invoice_col_input">
                                                                <input type="text"
                                                                       class="inputs_up form-control text-right total_exp_malt"
                                                                       id="total_exp_malt" readonly>
                                                                {{--                                                        <input type="text" name="service_total_tax" class="inputs_up form-control text-right " id="service_total_tax" readonly>--}}
                                                            </div>
                                                        </div><!-- invoice inline input text end -->

                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->


                                            <div class="invoice_col basis_col_23 ">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="invoice_col_ttl">
                                                        <!-- invoice column title start -->

                                                        Profit/Lose
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_txt">
                                                        <!-- invoice column input start -->

                                                        <div class="invoice_inline_input_txt">
                                                            <!-- invoice inline input text start -->
                                                            <label class="inline_input_txt_lbl"
                                                                   for="disc_percentage">
                                                                Purchase Order
                                                            </label>
                                                            <div class="invoice_col_input">
                                                                <input type="text"
                                                                       class="inputs_up form-control text-right percentage_textbox"
                                                                       id="grand_total_output"
                                                                >
                                                            </div>
                                                        </div><!-- invoice inline input text end -->

                                                        <div class="invoice_inline_input_txt">
                                                            <!-- invoice inline input text start -->
                                                            <label class="inline_input_txt_lbl"
                                                                   for="disc_amount">
                                                                Total OverHead
                                                            </label>
                                                            <div class="invoice_col_input">
                                                                <input type="text"
                                                                       class="inputs_up form-control text-right total_exp_malt"
                                                                       id="total_exp_malt" readonly>
                                                            </div>
                                                        </div><!-- invoice inline input text end -->
                                                        <div class="invoice_inline_input_txt">
                                                            <!-- invoice inline input text start -->
                                                            <label class="inline_input_txt_lbl"
                                                                   for="disc_amount">
                                                                Profit (Rs.)
                                                            </label>
                                                            <div class="invoice_col_input">
                                                                <input type="text"
                                                                       class="inputs_up form-control text-right"
                                                                       id="remaining_output" readonly>
                                                            </div>
                                                        </div><!-- invoice inline input text end -->

                                                        {{--                                                        <div class="invoice_inline_input_txt">--}}
                                                        {{--                                                            <!-- invoice inline input text start -->--}}
                                                        {{--                                                            <label class="inline_input_txt_lbl"--}}
                                                        {{--                                                                   for="service_total_exclusive_tax">--}}
                                                        {{--                                                                Total Discount--}}
                                                        {{--                                                            </label>--}}
                                                        {{--                                                            <div class="invoice_col_input">--}}
                                                        {{--                                                                <input type="text" name="total_discount"--}}
                                                        {{--                                                                       class="inputs_up form-control text-right"--}}
                                                        {{--                                                                       id="total_discount" readonly>--}}
                                                        {{--                                                            </div>--}}
                                                        {{--                                                        </div><!-- invoice inline input text end -->--}}

                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->


                                        </div><!-- invoice row end -->
                                    </div>

                                </div>
                            </div>


                            <div class="form-group row">

                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    {{--                                        <button type="reset" name="cancel" id="cancel" class="cancel_button form-control">--}}
                                    {{--                                            <i class="fa fa-eraser"></i> Cancel--}}
                                    {{--                                        </button>--}}

                                    {{--                                    <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">--}}
                                    {{--                                        <button type="submit" class="invoice_frm_btn" onclick="return popvalidation()">--}}
                                    {{--                                            Save (Ctrl+S)--}}
                                    {{--                                        </button>--}}
                                    {{--                                        <span id="check_product_count" class="validate_sign"></span>--}}
                                    {{--                                    </div>--}}

                                    <button type="submit" name="save" id="save"
                                            class="save_button invoice_frm_btn form-control"
                                            onclick="return popvalidation()">
                                        <i class="fa fa-floppy-o"></i> Save
                                    </button>

                                </div>
                            </div>

                        </div> <!-- left column ends here -->

                    </div> <!--  main row ends here -->
                </form>
            </div> <!-- white column form ends here -->

        </div>


    </div>

@endsection

@section('scripts')

    <script>
        function calculate() {
            var grand_total = $('#grand_total').val();
            var exp_total_price = $('#exp_total_price').val();
            var total_price_material = $('#total_price_material').val();

            $('#grand_total_output').val(grand_total);
            var output = +exp_total_price + +total_price_material;
            $('#grand_total_material_output').val(total_price_material);
            $('#grand_total_exp_output').val(exp_total_price);

            $('.total_exp_malt').val(output);
            var remain = grand_total - output;
            $('#remaining_output').val(remain);
        }
    </script>
    <script>
        jQuery("#working_area_enable").change(function () {

            if ($(this).is(':checked')) {
                $(".working *").prop('disabled', false);
                $(".company_dropdown *").prop('disabled', true);
            } else {
                $(".working *").prop('disabled', true);
                $(".company_dropdown *").prop('disabled', true);
            }
        });

        jQuery("#order_list_enable").change(function () {

            if ($(this).is(':checked')) {
                $(".order_list *").prop('disabled', false);
                $(".company_dropdown *").prop('disabled', true);
            } else {
                $(".order_list *").prop('disabled', true);
                $(".company_dropdown *").prop('disabled', true);
            }
        });

        $("#limit").keyup(function () {
            var grand_total = $("#grand_total").val();

            var limit = $("#limit").val();

            var percentage = (limit / grand_total) * 100;

            $("#limit_pec").val(percentage.toFixed(2));
        });
    </script>
    <script>
        $("#limit_pec").keyup(function () {
            var grand_total = $("#grand_total").val();

            var limit_pec = $("#limit_pec").val();

            var price = (limit_pec * grand_total) / 100;

            $("#limit").val(price);
        });
    </script>
    <script>
        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

    </script>
    <script>
        $(document).ready(function () {
            // jQuery("#working_area_enable").change(function () {

            if ($(this).is(':checked')) {
                $(".working *").prop('disabled', false);
                $(".company_dropdown *").prop('disabled', true);

            } else {
                $(".working *").prop('disabled', true);
                $(".company_dropdown *").prop('disabled', true);
            }
            if ($(this).is(':checked')) {

                $(".order_list *").prop('disabled', false);
                $(".company_dropdown *").prop('disabled', true);
            } else {

                $(".order_list *").prop('disabled', true);
                $(".company_dropdown *").prop('disabled', true);
            }
            $(".company_dropdown *").prop('disabled', true);
            // if ($('#po_enable').val()) {
            //     $(".purchase_order").prop('disabled', false);
            // } else {
            //     $(".purchase_order").prop('disabled', true);
            // }
            // });

            $('.user-select').change(function () {

                var val = $(this).val();

                $(".auto-select").val(val, 'selected').trigger('change');

            });
            get_workorder_recipe();
        });
    </script>
    <script type="text/javascript">

        // Initialize select2
        jQuery("#company").select2();
        jQuery("#region").select2();
        jQuery("#zone").select2();
        jQuery("#city").select2();
        jQuery("#grid").select2();
        jQuery("#franchiseArea").select2();
        jQuery("#circle").select2();
        jQuery("#survey_person").select2();
        jQuery("#supervisor").select2();
        jQuery("#type_of_expense").select2();
        jQuery("#party").select2();
        jQuery("#material_product_code").select2();
        jQuery("#material_product_name").select2();

        jQuery("#companys").select2();
        jQuery("#regions").select2();
        jQuery("#product_name_list").select2();

    </script>

    {{--   start purchase order script--}}


    <script>

        function show_tabs() {

            $('.tab-pane').removeClass('active').removeClass('show');
            $('.nav-link ').removeClass('active').removeClass('show');
            $('.tab-pane').removeClass('active').removeClass('show');
        }

        function popvalidation() {

            var account_name = $("#account_name").val();
            var total_items = $("#total_items").val();

            var grand_total = $("#grand_total").val();
            var total_price_material = $("#total_price_material").val();
            var exp_total_price = $("#exp_total_price").val();
            var total_amount = +exp_total_price + +total_price_material;

            var rowCount = $('#table_body tr.edit_update').length;

            var rowCountWork = $('#table_bodys tr.edit_update').length;
            var rowCountExp = $('#table_body_ex tr.edit_update').length;
            var rowCountMaterial = $('#table_body_material tr.edit_update').length;


            var flag_submit = true;
            var focus_once = 0;

            if (account_name.trim() == "0") {


                if (focus_once == 0) {
                    jQuery("#account_name").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            }

            // if (rowCountMaterial == "0") {
            //
            //     show_tabs();
            //     $('#material').addClass('active').addClass('show');
            //
            //     $('.nav-link').each(function (index) {
            //
            //         if ($(this).attr('href') == '#material') {
            //             $(this).addClass('active').addClass('show');
            //         }
            //     });
            //
            //     Swal.fire({
            //         title: 'Add MATERIAL Items',
            //         icon: 'error',
            //         // showCancelButton: true,
            //         cancelButtonColor: '#d33',
            //         confirmButtonColor: '#3085d6',
            //         confirmButtonText: 'Ok',
            //     });
            //     flag_submit = false;
            // }

            if (rowCountExp == "0") {

                show_tabs();
                $('#credentials').addClass('active').addClass('show');

                $('.nav-link').each(function (index) {

                    if ($(this).attr('href') == '#credentials') {
                        $(this).addClass('active').addClass('show');
                    }
                });

                Swal.fire({
                    title: 'Add EXPENSE Items',
                    icon: 'error',
                    // showCancelButton: true,
                    cancelButtonColor: '#d33',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok',
                });
                flag_submit = false;

            }

            if ($('#working_area_enable').is(':checked')) {


                if (rowCountWork == 0) {

                    show_tabs();
                    $('#profile').addClass('active').addClass('show');

                    $('.nav-link').each(function (index) {

                        if ($(this).attr('href') == '#profile') {
                            $(this).addClass('active').addClass('show');
                        }
                    });

                    Swal.fire({
                        title: 'Add WORKING AREA Items',
                        icon: 'error',
                        // showCancelButton: true,
                        cancelButtonColor: '#d33',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok',
                    });

                    flag_submit = false;

                }
            }

            if (rowCount == 0) {
                if (total_items == 0) {

                    if (product_code == "0") {

                        if (focus_once == 0) {
                            jQuery("#product_code").focus();
                            focus_once = 1;
                        }
                        flag_submit = false;
                    }

                    if (product_name == "0") {
                        if (focus_once == 0) {
                            jQuery("#product_name").focus();
                            focus_once = 1;
                        }
                        flag_submit = false;
                    }
                }

                show_tabs();
                $('#home').addClass('active').addClass('show');

                $('.nav-link').each(function (index) {

                    if ($(this).attr('href') == '#home') {
                        $(this).addClass('active').addClass('show');
                    }
                });

                Swal.fire({
                    title: 'Add PURCHASE ORDER Items',
                    icon: 'error',
                    // showCancelButton: true,
                    cancelButtonColor: '#d33',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok',
                });

                flag_submit = false;

            }

            // if (total_amount > grand_total) {
            //     document.getElementById("message").innerHTML = "Grand Total not Less than Expanse and Material Budget";
            //     flag_submit = false;
            // } else {
            //     document.getElementById("message").innerHTML = "";
            // }

            // if (total_items == 0) {
            //
            //     if (product_code == "0") {
            //
            //         if (focus_once == 0) {
            //             jQuery("#product_code").focus();
            //             focus_once = 1;
            //         }
            //         flag_submit = false;
            //     }
            //
            //     if (product_name == "0") {
            //         if (focus_once == 0) {
            //             jQuery("#product_name").focus();
            //             focus_once = 1;
            //         }
            //         flag_submit = false;
            //     }
            //
            //
            //     // var type_of_expense = document.getElementById("type_of_expense").value;
            //     //     var party = document.getElementById("party").value;
            //     //     var expense_remarks = document.getElementById("expense_remarks").value;
            //     //     var limit = document.getElementById("limit").value;
            //     //     // var rate = document.getElementById("rate").value;
            //     //     // var amount = document.getElementById("amount").value;
            //     //     // var remarks = document.getElementById("remarks").value;
            //     //
            //     //     var flag_submit = true;
            //     //     var focus_once = 0;
            //     //
            //     //     if (remarks.trim() == "") {
            //     //         var isDirty = false;
            //     //         if (focus_once == 0) {
            //     //             jQuery("#remarks").focus();
            //     //             focus_once = 1;
            //     //         }
            //     //         flag_submit = false;
            //     //
            //     //     }
            //     //
            //     //
            //     //     if (numberofexpenses == 0) {
            //     //         var isDirty = false;
            //     //         if (type_of_expense == "0") {
            //     //             if (focus_once == 0) {
            //     //                 jQuery("#type_of_expense").focus();
            //     //                 focus_once = 1;
            //     //             }
            //     //             flag_submit = false;
            //     //         }
            //     //
            //     //
            //     //         if (party == "0") {
            //     //
            //     //             if (focus_once == 0) {
            //     //                 jQuery("#party").focus();
            //     //                 focus_once = 1;
            //     //             }
            //     //             flag_submit = false;
            //     //         }
            //     //
            //     //
            //     //         if (limit == 0) {
            //     //
            //     //             if (focus_once == 0) {
            //     //                 jQuery("#limit").focus();
            //     //                 focus_once = 1;
            //     //             }
            //     //             flag_submit = false;
            //     //         }
            //
            //
            //     document.getElementById("check_product_count").innerHTML = "Add Items";
            //     flag_submit = false;
            // }

            var pro_code;
            var pro_field_id_title;
            var pro_field_id;
            var quantity;
            var rate;

            $('input[name="pro_code[]"]').each(function (pro_index) {
                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                quantity = +jQuery("#quantity" + pro_field_id).val();
                rate = jQuery("#rate" + pro_field_id).val();

                if (quantity < 1 || quantity == "") {
                    if (focus_once == 0) {
                        jQuery("#quantity" + pro_field_id).focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }

                if (rate == "0" || rate == "") {
                    if (focus_once == 0) {
                        jQuery("#rate" + pro_field_id).focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }
            });

            return flag_submit;
        }


    </script>

    {{--//////////////////////////////////////////////////////////////////// Start Sale Javascript //////////////////////////////////////////////////////////////////////////////////////////--}}
    <script>
        // adding sales into table
        var counter = 0;
        var total_discount = 0;

        function product_amount_calculation(id) {

            var quantity = jQuery("#quantity" + id).val();
            var rate = jQuery("#rate" + id).val();
            var product_discount = jQuery("#product_discount" + id).val();
            var product_sales_tax = jQuery("#product_sales_tax" + id).val();

            if (quantity == "") {
                quantity = 0;
            }

            var product_sale_tax_amount;
            var product_rate_after_discount;
            var product_inclusive_rate;
            var product_discount_amount;

            if ($("#inclusive_exclusive" + id).prop("checked") == true) {
                jQuery("#inclusive_exclusive_status_value" + id).val(1);

                product_discount_amount = (((rate / (+product_sales_tax + +100) * 100)) * product_discount / 100) * quantity;

                product_rate_after_discount = rate - (product_discount_amount / quantity);

                product_inclusive_rate = ((rate / (+product_sales_tax + +100)) * 100) - ((rate / (+product_sales_tax + +100)) * 100) * product_discount / 100;

                product_sale_tax_amount = (rate - ((rate / (+product_sales_tax + +100)) * 100)) * quantity;

            } else {
                jQuery("#inclusive_exclusive_status_value" + id).val(0);

                product_discount_amount = (rate * product_discount / 100) * quantity;

                product_rate_after_discount = rate - (product_discount_amount / quantity);

                product_inclusive_rate = product_rate_after_discount;

                product_sale_tax_amount = (product_rate_after_discount * product_sales_tax / 100) * quantity;
            }

            var amount = (quantity * product_inclusive_rate) + product_sale_tax_amount;

            jQuery("#amount" + id).val(amount.toFixed(2));
            jQuery("#product_sale_tax_amount" + id).val(product_sale_tax_amount.toFixed(2));
            jQuery("#product_inclusive_rate" + id).val(product_inclusive_rate.toFixed(2));
            jQuery("#product_discount_amount" + id).val(product_discount_amount.toFixed(2));

            grand_total_calculation();
        }

        function grand_total_calculation() {

            var disc_percentage = jQuery("#disc_percentage").val();

            var total_price = 0;
            var total_product_discount = 0;
            var total_inclusive_sale_tax_amount = 0;
            var total_exclusive_sale_tax_amount = 0;
            var total_sale_tax_amount = 0;
            var grand_total = 0;
            var round_off_discount = 0;
            var disc_percentage_amount = 0;


            var product_quantity;
            var product_rate;
            var product_discount_amount = 0;
            var product_sale_tax_amount = 0;
            var product_amount = 0;

            var pro_code;
            var pro_field_id_title;
            var pro_field_id;

            $('input[name="pro_code[]"]').each(function (pro_index) {
                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456


                product_quantity = jQuery("#quantity" + pro_field_id).val();
                product_rate = jQuery("#rate" + pro_field_id).val();
                product_discount_amount = jQuery("#product_discount_amount" + pro_field_id).val();
                product_sale_tax_amount = jQuery("#product_sale_tax_amount" + pro_field_id).val();
                product_amount = jQuery("#amount" + pro_field_id).val();

                total_price = +total_price + +(product_rate * product_quantity);
                total_product_discount = +total_product_discount + +product_discount_amount;

                if ($("#inclusive_exclusive" + pro_field_id).prop("checked") == true) {

                    total_inclusive_sale_tax_amount = +total_inclusive_sale_tax_amount + +product_sale_tax_amount;

                } else {
                    total_exclusive_sale_tax_amount = +total_exclusive_sale_tax_amount + +product_sale_tax_amount;
                }

                total_sale_tax_amount = +total_sale_tax_amount + +product_sale_tax_amount;

                grand_total = +grand_total + +product_amount;
            });

            disc_percentage_amount = (total_price * disc_percentage) / 100;

            total_discount = +total_product_discount + +disc_percentage_amount;

            grand_total = +(total_price - total_discount) + +total_exclusive_sale_tax_amount;

            var radioValue = $("input[name='round_off']:checked").val();

            if (radioValue == 1) {
                round_off_discount = grand_total - Math.round(grand_total);
            }

            total_discount = +total_discount + +round_off_discount;

            grand_total = grand_total - round_off_discount;

            jQuery("#total_price").val(total_price.toFixed(2));
            jQuery("#total_product_discount").val(total_product_discount.toFixed(2));
            jQuery("#round_off_discount").val(round_off_discount.toFixed(2));
            jQuery("#disc_amount").val(disc_percentage_amount.toFixed(2));
            jQuery("#total_discount").val(total_discount.toFixed(2));
            jQuery("#total_inclusive_tax").val(total_inclusive_sale_tax_amount.toFixed(2));
            jQuery("#total_exclusive_tax").val(total_exclusive_sale_tax_amount.toFixed(2));
            jQuery("#total_tax").val(total_sale_tax_amount.toFixed(2));
            jQuery("#grand_total").val(grand_total.toFixed(2));

            var total_items = $('input[name="pro_code[]"]').length;

            jQuery("#total_items").val(total_items);
            $("#grand_total_text").text(grand_total.toFixed(2));
            calculate();
        }

        function grand_total_calculation_with_disc_amount() {

            var disc_percentage = 0;
            var disc_amount = jQuery("#disc_amount").val();

            var total_price = 0;
            var total_product_discount = 0;
            var total_inclusive_sale_tax_amount = 0;
            var total_exclusive_sale_tax_amount = 0;
            var total_sale_tax_amount = 0;
            var grand_total = 0;
            var round_off_discount = 0;
            var disc_percentage_amount = disc_amount;


            var product_quantity;
            var product_rate;
            var product_discount_amount = 0;
            var product_sale_tax_amount = 0;
            var product_amount = 0;

            var pro_code;
            var pro_field_id_title;
            var pro_field_id;

            $('input[name="pro_code[]"]').each(function (pro_index) {
                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456


                product_quantity = jQuery("#quantity" + pro_field_id).val();
                product_rate = jQuery("#rate" + pro_field_id).val();
                product_discount_amount = jQuery("#product_discount_amount" + pro_field_id).val();
                product_sale_tax_amount = jQuery("#product_sale_tax_amount" + pro_field_id).val();
                product_amount = jQuery("#amount" + pro_field_id).val();

                total_price = +total_price + +(product_rate * product_quantity);
                total_product_discount = +total_product_discount + +product_discount_amount;

                if ($("#inclusive_exclusive" + pro_field_id).prop("checked") == true) {

                    total_inclusive_sale_tax_amount = +total_inclusive_sale_tax_amount + +product_sale_tax_amount;

                } else {
                    total_exclusive_sale_tax_amount = +total_exclusive_sale_tax_amount + +product_sale_tax_amount;
                }

                total_sale_tax_amount = +total_sale_tax_amount + +product_sale_tax_amount;

                grand_total = +grand_total + +product_amount;
            });

            disc_percentage = (disc_amount * 100) / total_price;

            total_discount = +total_product_discount + +disc_percentage_amount;

            grand_total = +(total_price - total_discount) + +total_exclusive_sale_tax_amount;

            var radioValue = $("input[name='round_off']:checked").val();

            if (radioValue == 1) {
                round_off_discount = grand_total - Math.round(grand_total);
            }

            total_discount = +total_discount + +round_off_discount;

            grand_total = grand_total - round_off_discount;

            jQuery("#total_price").val(total_price.toFixed(2));
            jQuery("#total_product_discount").val(total_product_discount.toFixed(2));
            jQuery("#round_off_discount").val(round_off_discount.toFixed(2));
            jQuery("#disc_percentage").val(disc_percentage.toFixed(2));
            jQuery("#total_discount").val(total_discount.toFixed(2));
            jQuery("#total_inclusive_tax").val(total_inclusive_sale_tax_amount.toFixed(2));
            jQuery("#total_exclusive_tax").val(total_exclusive_sale_tax_amount.toFixed(2));
            jQuery("#total_tax").val(total_sale_tax_amount.toFixed(2));
            jQuery("#grand_total").val(grand_total.toFixed(2));

            var total_items = $('input[name="pro_code[]"]').length;

            jQuery("#total_items").val(total_items);
            $("#grand_total_text").text(grand_total.toFixed(2));
        }

        jQuery("#service_name").change(function () {

            counter++;
            add_first_item();
            var parent_code = $(this).val();
            var name = $("#service_name option:selected").text();
            var quantity = 1;
            var unit_measurement = '';
            var bonus_qty = '';
            var rate = 0;
            var inclusive_rate = 0;
            var discount = 0;
            var discount_amount = 0;
            var sales_tax = 0;
            var sale_tax_amount = 0;
            var amount = 0;
            var remarks = '';
            var rate_after_discount = 0;
            var inclusive_exclusive = 0;

            var pro_code;
            var pro_field_id_title;
            var pro_field_id;


            $('input[name="pro_code[]"]').each(function (pro_index) {
                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                if (pro_code == parent_code) {
                    quantity = +jQuery("#quantity" + pro_field_id).val() + +quantity;
                    // bonus_qty = '';
                    rate = jQuery("#rate" + pro_field_id).val();
                    discount = jQuery("#product_discount" + pro_field_id).val();
                    sales_tax = jQuery("#product_sales_tax" + pro_field_id).val();

                    if ($("#inclusive_exclusive" + pro_field_id).prop("checked") == true) {
                        inclusive_exclusive = 1;
                    }
                    delete_sale(pro_field_id);
                }
            });

            // bonus_qty,
            add_sale(parent_code, name, quantity, rate, inclusive_rate, discount, discount_amount, sales_tax, sale_tax_amount, amount, remarks, rate_after_discount, inclusive_exclusive,
                counter, 1, unit_measurement);

            product_amount_calculation(counter);
        });

        jQuery("#product_code").change(function () {

            counter++;
            add_first_item();
            var code = $(this).val();

            // $("#product_name").select2("destroy");
            $('#product_name option[value="' + code + '"]').prop('selected', true);
            // $("#product_name").select2();

            var parent_code = jQuery("#product_code option:selected").attr('data-parent');
            var name = $("#product_name option:selected").text();
            var quantity = 1;
            var unit_measurement = $('option:selected', this).attr('data-unit');
            // var bonus_qty = '';
            var rate = $('option:selected', this).attr('data-sale_price');
            var inclusive_rate = 0;
            var discount = 0;
            var discount_amount = 0;
            var sales_tax = $('option:selected', this).attr('data-tax');
            var sale_tax_amount = 0;
            var amount = 0;
            var remarks = '';
            var rate_after_discount = 0;
            var inclusive_exclusive = 0;

            var pro_code;
            var pro_field_id_title;
            var pro_field_id;


            $('input[name="pro_code[]"]').each(function (pro_index) {
                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                if (pro_code == parent_code) {
                    quantity = +jQuery("#quantity" + pro_field_id).val() + +quantity;
                    // bonus_qty = jQuery("#bonus" + pro_field_id).val();
                    rate = jQuery("#rate" + pro_field_id).val();
                    discount = jQuery("#product_discount" + pro_field_id).val();
                    sales_tax = jQuery("#product_sales_tax" + pro_field_id).val();

                    if ($("#inclusive_exclusive" + pro_field_id).prop("checked") == true) {
                        inclusive_exclusive = 1;
                    }

                    delete_sale(pro_field_id);
                }
            });


            if ($(".invoice_type").is(':checked')) {
                if ($(".invoice_type:checked").val() == 1) {
                    sales_tax = 0;
                }
            }

            if ($(".discount_type").is(':checked')) {
                if ($(".discount_type:checked").val() == 1) {
                    discount = 0;
                } else if ($(".discount_type:checked").val() == 2) {
                    discount = jQuery('#product_name option:selected').attr('data-retailer_dis');
                } else if ($(".discount_type:checked").val() == 3) {
                    discount = jQuery('#product_name option:selected').attr('data-whole_saler_dis');
                } else if ($(".discount_type:checked").val() == 4) {
                    discount = jQuery('#product_name option:selected').attr('data-loyalty_dis');
                }
            }
            // bonus_qty,
            add_sale(parent_code, name, quantity, rate, inclusive_rate, discount, discount_amount, sales_tax, sale_tax_amount, amount, remarks, rate_after_discount, inclusive_exclusive,
                counter, 0, unit_measurement);

            product_amount_calculation(counter);
        });

        jQuery("#product_name").change(function () {
            counter++;
            add_first_item();
            var code = $(this).val();

            // $("#product_code").select2("destroy");
            $('#product_code option[value="' + code + '"]').prop('selected', true);
            // $("#product_code").select2();

            var parent_code = jQuery("#product_name option:selected").attr('data-parent');
            var name = $("#product_name option:selected").text();
            var quantity = 1;
            var unit_measurement = $('option:selected', this).attr('data-unit');
            // var bonus_qty = '';
            var rate = $('option:selected', this).attr('data-sale_price');
            var inclusive_rate = 0;
            var discount = 0;
            var discount_amount = 0;
            var sales_tax = $('option:selected', this).attr('data-tax');
            var sale_tax_amount = 0;
            var amount = 0;
            var remarks = '';
            var rate_after_discount = 0;
            var inclusive_exclusive = 0;

            var pro_code;
            var pro_field_id_title;
            var pro_field_id;


            $('input[name="pro_code[]"]').each(function (pro_index) {

                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                if (pro_code == parent_code) {
                    quantity = +jQuery("#quantity" + pro_field_id).val() + +quantity;
                    // bonus_qty = jQuery("#bonus" + pro_field_id).val();
                    rate = jQuery("#rate" + pro_field_id).val();
                    discount = jQuery("#product_discount" + pro_field_id).val();
                    sales_tax = jQuery("#product_sales_tax" + pro_field_id).val();

                    if ($("#inclusive_exclusive" + pro_field_id).prop("checked") == true) {
                        inclusive_exclusive = 1;
                    }

                    delete_sale(pro_field_id);
                }
            });


            if ($(".invoice_type").is(':checked')) {
                if ($(".invoice_type:checked").val() == 1) {
                    sales_tax = 0;
                }
            }

            if ($(".discount_type").is(':checked')) {
                if ($(".discount_type:checked").val() == 1) {
                    discount = 0;
                } else if ($(".discount_type:checked").val() == 2) {
                    discount = jQuery('#product_name option:selected').attr('data-retailer_dis');
                } else if ($(".discount_type:checked").val() == 3) {
                    discount = jQuery('#product_name option:selected').attr('data-whole_saler_dis');
                } else if ($(".discount_type:checked").val() == 4) {
                    discount = jQuery('#product_name option:selected').attr('data-loyalty_dis');
                }
            }
            // bonus_qty,
            add_sale(parent_code, name, quantity, rate, inclusive_rate, discount, discount_amount, sales_tax, sale_tax_amount, amount, remarks, rate_after_discount, inclusive_exclusive,
                counter, 0, unit_measurement);

            product_amount_calculation(counter);
        });

        jQuery('.discount_type').change(function () {

            if ($(this).is(':checked')) {
                add_first_item();

                var discount = 0;

                var pro_code;
                var pro_field_id_title;
                var pro_field_id;

                $('input[name="pro_code[]"]').each(function (pro_index) {

                    pro_code = $(this).val();
                    pro_field_id_title = $(this).attr('id');
                    pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                    jQuery('#product_code option[value="' + pro_code + '"]').prop('selected', true);

                    if ($(".discount_type").is(':checked')) {
                        if ($(".discount_type:checked").val() == 1) {
                            discount = 0;
                        } else if ($(".discount_type:checked").val() == 2) {
                            discount = jQuery('#product_code option:selected').attr('data-retailer_dis');
                        } else if ($(".discount_type:checked").val() == 3) {
                            discount = jQuery('#product_code option:selected').attr('data-whole_saler_dis');
                        } else if ($(".discount_type:checked").val() == 4) {
                            discount = jQuery('#product_code option:selected').attr('data-loyalty_dis');
                        }
                    }

                    jQuery("#product_discount" + pro_field_id).val(discount);
                    product_amount_calculation(pro_field_id);
                });
                jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
            }
        });

        jQuery("#clear_discount_btn").click(function () {
            var discount = 0;
            var pro_code;
            var pro_field_id_title;
            var pro_field_id;

            $('input[name="pro_code[]"]').each(function (pro_index) {

                pro_code = $(this).val();
                pro_field_id_title = $(this).attr('id');
                pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                jQuery('#product_code option[value="' + pro_code + '"]').prop('selected', true);

                jQuery("#product_discount" + pro_field_id).val(discount);
                product_amount_calculation(pro_field_id);
            });
            jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
        });

        jQuery("#all_clear_form").click(function () {
            jQuery("#table_body").html("");
            grand_total_calculation();
            calculate();
            jQuery("#sale_person").val("0").trigger('change');
            jQuery("#account_name").val("0").trigger('change');
            jQuery("#remarks").val("");

            jQuery("#machine").val("0").trigger('change');
            jQuery("#credit_card_number").val("");
            jQuery("#credit_card_amount").val("");

            jQuery("#customer_name").val("");
            jQuery("#customer_email").val("");
            jQuery("#customer_phone_number").val("");

            jQuery("#cash_received_from_customer").val("");
            jQuery("#invoice_cash_received").val("");
            jQuery("#invoice_cash_return").val("");

            jQuery("#cash_paid").val("");
            jQuery("#credit_card_amount_view").val("");
            jQuery("#cash_return").val("");
        });

        jQuery("#package").change(function () {

            var id = jQuery('option:selected', this).val();

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "{{ route('get_product_packages_details') }}",
                data: {id: id},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    $.each(data, function (index, value) {
                        counter++;

                        var parent_code = value['ppi_product_code'];
                        jQuery('#product_name option[value="' + parent_code + '"]').prop('selected', true);
                        var name = $("#product_name option:selected").text();
                        var quantity = value['ppi_qty'];
                        var unit_measurement = $("#product_name option:selected").attr('data-unit');
                        // var bonus_qty = '';
                        var rate = value['ppi_rate'];
                        var inclusive_rate = 0;
                        var discount = 0;
                        var discount_amount = 0;
                        var sales_tax = 0;
                        var sale_tax_amount = 0;
                        var amount = 0;
                        var remarks = value['ppi_remarks'];
                        var rate_after_discount = 0;
                        var inclusive_exclusive = 0;

                        var pro_code;
                        var pro_field_id_title;
                        var pro_field_id;

                        $('input[name="pro_code[]"]').each(function (pro_index) {
                            pro_code = $(this).val();
                            pro_field_id_title = $(this).attr('id');
                            pro_field_id = pro_field_id_title.match(/\d+/); // 123456

                            if (pro_code == parent_code) {
                                quantity = +jQuery("#quantity" + pro_field_id).val() + +quantity;
                                // bonus_qty = jQuery("#bonus" + pro_field_id).val();
                                rate = jQuery("#rate" + pro_field_id).val();
                                discount = jQuery("#product_discount" + pro_field_id).val();
                                sales_tax = jQuery("#product_sales_tax" + pro_field_id).val();

                                if ($("#inclusive_exclusive" + pro_field_id).prop("checked") == true) {
                                    inclusive_exclusive = 1;
                                }

                                delete_sale(pro_field_id);
                            }
                        });

                        if ($(".invoice_type").is(':checked')) {
                            if ($(".invoice_type:checked").val() == 1) {
                                sales_tax = 0;
                            }
                        }

                        if ($(".discount_type").is(':checked')) {
                            if ($(".discount_type:checked").val() == 1) {
                                discount = 0;
                            } else if ($(".discount_type:checked").val() == 2) {
                                discount = jQuery('#product_name option:selected').attr('data-retailer_dis');
                            } else if ($(".discount_type:checked").val() == 3) {
                                discount = jQuery('#product_name option:selected').attr('data-whole_saler_dis');
                            } else if ($(".discount_type:checked").val() == 4) {
                                discount = jQuery('#product_name option:selected').attr('data-loyalty_dis');
                            }
                        }
                        // bonus_qty,
                        add_sale(parent_code, name, quantity, rate, inclusive_rate, discount, discount_amount, sales_tax, sale_tax_amount, amount, remarks, rate_after_discount,
                            inclusive_exclusive, counter, 0, unit_measurement);

                        product_amount_calculation(counter);

                    });

                    jQuery("#package").select2("destroy");
                    jQuery('#package option[value="' + 0 + '"]').prop('selected', true);
                    jQuery("#package").select2();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);
                }
            });
        });

        function duplicate_warehouse_dropdown(counter) {
            //Clone the DropDownList
            var ddl = $("#warehouse").clone();

            //Set the ID and Name
            ddl.attr("id", "warehouse" + counter);
            ddl.attr("name", "warehouse[]");

            //[OPTIONAL] Copy the selected value
            var selectedValue = $("#warehouse option:selected").val();
            ddl.find("option[value = '" + selectedValue + "']").attr("selected", "selected");

            //Append to the DIV.
            $("#warehouse_div_col" + counter).append(ddl);

            $("#warehouse" + counter).removeClass("js-example-basic-multiple select2-hidden-accessible");
            $("#warehouse" + counter).removeAttr("href");

            // setTimeout(function() {
            //     jQuery("#warehouse" + counter).select2();
            // }, 1000);
        }

        // bonus_qty,
        function add_sale(code, name, quantity, rate, inclusive_rate, discount, discount_amount, sales_tax, sale_tax_amount, amount, remarks, rate_after_discount, inclusive_exclusive,
                          counter, product_or_service_status, unit_measurement) {

            var inclusive_exclusive_status = '';
            // var bonus_qty_status = '';
            if (inclusive_exclusive == 1) {
                inclusive_exclusive_status = 'checked';
            }

            if (product_or_service_status == 1) {
                // bonus_qty_status = 'readonly';
            }


            jQuery("#table_body").append('<tr class="edit_update" id="table_row' + counter + '">' +
                '<td class="text-center tbl_srl_4">' + counter + '</td> ' +
                '<td class="text-center tbl_srl_9" hidden>' +
                '<input type="hidden" name="product_or_service_status[]" id="product_or_service_status' + counter + '" placeholder="Status" ' + 'class="inputs_up_tbl" value="' +
                product_or_service_status + '" readonly/>' +
                '<input type="text" name="pro_code[]" id="pro_code' + counter + '" placeholder="Code" ' + 'class="inputs_up_tbl" value="' + code + '" readonly/>' +
                '</td> ' +
                '<td class="text-left tbl_txt_17">' +
                '<input type="text" name="pro_name[]" id="pro_name' + counter + '" placeholder="Name" ' + 'class="inputs_up_tbl" value="' + name + '" readonly/>' +
                '</td> ' +
                '<td class="text-left tbl_txt_13">' +
                '<input type="text" name="product_remarks[]" id="product_remarks' + counter + '" placeholder="Remarks" ' + 'class="inputs_up_tbl" value="' + remarks + '"/>' +
                '</td>' +
                // '<td class="text-left tbl_txt_13" id="warehouse_div_col' + counter + '">' +
                // '</td>' +
                '<td class="text-center tbl_srl_4">' +
                '<input type="text" name="quantity[]" id="quantity' + counter + '" placeholder="Qty" ' + 'class="inputs_up_tbl" onkeyup="product_amount_calculation(' + counter + ')" value="' +
                quantity + '" onfocus="this.select();" onkeypress="return allowOnlyNumber(event);"/>' +
                '</td>' +
                '<td class="text-center tbl_srl_4">' +
                '<input type="text" name="unit_measurement[]" id="unit_measurement' + counter + '" placeholder="UOM" value="' + unit_measurement + '" readonly/>' +
                '</td>' +
                // '<td class="text-center tbl_srl_5"> ' +
                // '<input type="text" name="bonus[]" id="bonus' + counter + '" placeholder="Bonus" ' + 'class="inputs_up_tbl" onkeyup="product_amount_calculation(' + counter + ')" value="' +
                // bonus_qty + '" onfocus="this.select();" onkeypress="return allowOnlyNumber(event);" ' + bonus_qty_status + '/> ' +
                // '</td> ' +
                '<td class="text-right tbl_srl_6"> ' +
                '<input type="text" name="rate[]" id="rate' + counter + '" ' + 'placeholder="Rate" class="inputs_up_tbl text-right" onkeyup="product_amount_calculation(' + counter + ')" value="' +
                rate + '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/>' +
                '<input type="hidden" name="product_inclusive_rate[]" class="inputs_up ' + 'text-right form-control" id="product_inclusive_rate' + counter + '"  value="' + inclusive_rate + '"> ' +
                '</td> ' +
                '<td class="text-center tbl_srl_4"> ' +
                '<input type="text" name="product_discount[]" id="product_discount' + counter + '" placeholder="Dis%" class="inputs_up_tbl" onkeyup="product_amount_calculation(' + counter + ')" ' +
                'value="' + discount + '" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/> ' +
                '</td> <td class="text-right tbl_srl_7"> ' +
                '<input type="text" name="product_discount_amount[]" id="product_discount_amount' + counter + '" placeholder="Dis Amount" value="' + discount_amount + '" class="inputs_up_tbl text-right" ' +
                'readonly/> ' +
                '</td> <td class="text-center tbl_srl_4"> ' +
                '<input type="text" name="product_sales_tax[]" id="product_sales_tax' + counter + '" placeholder="Tax%" class="inputs_up_tbl" value="' + sales_tax + '" ' +
                'onkeyup="product_amount_calculation(' + counter + ')" onfocus="this.select();" onkeypress="return allow_only_number_and_decimals(this,event);"/> ' +
                '</td> ' +
                '<td class="text-right tbl_srl_10"> ' +
                '<input type="text" name="product_sale_tax_amount[]" id="product_sale_tax_amount' + counter + '" placeholder="Tax Amount" value="' + sale_tax_amount + '" class="inputs_up_tbl text-right" readonly/> ' +
                '</td> ' +
                '<td class="text-center tbl_srl_4"> <input type="checkbox" name="inclusive_exclusive[]" id="inclusive_exclusive' + counter + '" onclick="product_amount_calculation(' + counter + ');' +
                '"' + inclusive_exclusive_status + ' value="1"/> ' +
                '<input type="hidden" name="inclusive_exclusive_status_value[]" id="inclusive_exclusive_status_value' + counter + '"' + 'value="' + inclusive_exclusive + '"/> ' +
                '</td> ' +
                '<td class="text-right tbl_srl_12"> ' +
                '<input type="text" name="amount[]" id="amount' + counter + '" placeholder="Amount" class="inputs_up_tbl text-right" value="' + amount + '" readonly/> ' +
                '<div class="edit_update_bx"> <div class="inc_dec_con">' +
                '<div class="inc_dec_bx for_inc"><i class="fa fa-plus" onclick=increase_quantity(' + counter + ')></i></div>' +
                '<div class="inc_dec_bx for_val">1</div>' +
                '<div class="inc_dec_bx for_dec"><i class="fa fa-minus" onclick=decrease_quantity(' + counter + ')></i></div>' +
                '</div> ' +
                '<a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_sale(' + counter + ')><i class="fa fa-trash"></i> </a> ' +
                '</div> ' +
                '</td> ' +
                '</tr>');


            if (product_or_service_status != 1) {
                duplicate_warehouse_dropdown(counter);
            }

            jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#service_name option[value="' + 0 + '"]').prop('selected', true);

            grand_total_calculation();
            calculate();
            check_invoice_type();
        }

        function delete_sale(current_item) {

            jQuery("#table_row" + current_item).remove();

            grand_total_calculation();
            calculate();
            check_invoice_type();
        }

        function increase_quantity(current_item) {

            var previous_qty = jQuery("#quantity" + current_item).val();
            var new_quantity = 1;
            if (previous_qty >= 0) {
                new_quantity = +previous_qty + +1;
            }

            jQuery("#quantity" + current_item).val(new_quantity);

            product_amount_calculation(current_item);
            calculate();
        }

        function decrease_quantity(current_item) {

            var previous_qty = jQuery("#quantity" + current_item).val();
            var new_quantity = 1;
            if (previous_qty >= 0) {
                new_quantity = previous_qty - 1;
            }

            jQuery("#quantity" + current_item).val(new_quantity);

            product_amount_calculation(current_item);
            calculate();
        }

        function add_first_item() {
            var total_items = $('input[name="pro_code[]"]').length;

            if (total_items <= 0 || total_items == '') {
                jQuery("#table_body").html("");
            }
        }

        function check_invoice_type() {
            var total_items = $("#total_items").val();

            if (total_items == 0 || total_items == "") {
                $('.invoice_type:not(:checked)').attr('disabled', false);
            } else {
                $('.invoice_type:not(:checked)').attr('disabled', true);
            }
        }

        $('#account_name').on('change', function (event) {

            var disc_type = jQuery('option:selected', this).attr('data-disc_type');

            if (disc_type == 0) {
                disc_type = 1;
            }

            $(".discount_type").prop("checked", false);
            $("#discount_type" + disc_type).prop("checked", true);

            $(".discount_type").trigger("change");

            var limit_status = jQuery('option:selected', this).attr("data-limit_status");
            var limit = jQuery('option:selected', this).attr("data-limit");
            var current_credit = 0;
            var remaining_credit = 0,
                BASE_URL = '{{ url('/') }}';

            event.preventDefault();

            if (limit_status == 0) {

                var account_code = $(this).val();

                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });

                jQuery.ajax({
                    url: "{{ route('get_credit_limit') }}",
                    data: {account_code: account_code},
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    success: function (data) {

                        current_credit = data;

                        remaining_credit = limit - current_credit;

                        Swal.fire({
                            html: '<table class="table table-bordered table-sm border-0">' +
                                '<tbody>' +
                                '<tr>' +
                                '<td scope="col" align="center" class="text-left align_left tbl_txt_70 border-0">Credit Limit</td>' +
                                '<td scope="col" align="center" class="text-right align_right tbl_txt_30 border-0">' + limit + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td scope="col" align="center" class="text-left align_left tbl_txt_70 border-0">Current Balance</td>' +
                                '<td scope="col" align="center" class="text-right align_right tbl_txt_30 border-0">' + current_credit + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td scope="col" align="center" class="text-left align_left tbl_txt_70 border-0">Available Remaining Limit</td>' +
                                '<td scope="col" align="center" class="text-right align_right tbl_txt_30 border-0">' + remaining_credit.toFixed(2) + '</td>' +
                                '</tr>' +
                                '</tbody>' +
                                '</table>',
                            title: '',
                            icon: 'info',
                            showCancelButton: false,
                            cancelButtonColor: '#d33',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Close',
                            customClass: {
                                container: 'sweet_containerImportant',
                                popup: 'my-popup-class',
                                title: 'sweet_titleImportant',
                                actions: 'sweet_actionsImportant',
                                confirmButton: 'sweet_confirmbuttonImportant',
                                cancelButton: 'sweet_cancelbuttonImportant',
                            },
                            width: 450,
                            padding: '1em 3em',
                            background: '#fff url(' + BASE_URL + '/public/vendors/images/credit_limit.png) no-repeat left top / auto 200px',
                            backdrop: 'rgba(0,0,123,0.4)'

                        }).then(function (result) {
                        });

                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // alert(jqXHR.responseText);
                        // alert(errorThrown);
                    }
                });
            }

        });
    </script>
    {{--//////////////////////////////////////////////////////////////////// End Sale Javascript /////////////////////////////////////////--}}

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            {{--jQuery("#product_code").append("{!! $pro_code !!}");--}}
            {{--jQuery("#product_name").append("{!! $pro_name !!}");--}}

            {{--jQuery("#material_product_code").append("{!! $pro_code !!}");--}}
            {{--jQuery("#material_product_name").append("{!! $pro_name !!}");--}}

            jQuery("#service_name").append("{!! $service_name !!}");

            jQuery("#service_name").select2();

            jQuery("#product_code").select2();
            jQuery("#product_name").select2();

            jQuery("#material_product_code").select2();
            jQuery("#material_product_name").select2();

            jQuery("#account_name").select2();

            jQuery("#package").select2();

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

    {{--    Start Order List script--}}

    <script>

        // adding packs into table
        var numberoforders = 0;
        var counter = 0;
        var orders = {};
        var global_id_to_edit = 0;
        var edit_order_value = '';


        function add_order_list() {

            var company_id = document.getElementById("companys").value;
            // var party = document.getElementById("party").value;

            var regions = $('.regions').val();

            var regions_name = $('#regions option:selected')
                .toArray().map(party => party.text);

            var order_remarks = document.getElementById("order_remarks").value;
            var pro_qty = document.getElementById("pro_qty").value;
            // var limit_pec = document.getElementById("limit_pec").value;
            // var rate = document.getElementById("rate").value;
            // var amount = document.getElementById("amount").value;


            var flag_submit1 = true;
            var focus_once1 = 0;

            if (company_id == "0") {

                if (focus_once1 == 0) {
                    jQuery("#companys").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (regions == "0") {

                if (focus_once1 == 0) {
                    jQuery("#regions").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (pro_qty == 0 || pro_qty == null) {

                if (focus_once1 == 0) {
                    jQuery("#pro_qty").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (flag_submit1) {

                if (global_id_to_edit != 0) {
                    jQuery("#" + global_id_to_edit).remove();

                    delete orders[global_id_to_edit];
                }

                counter++;

                jQuery("#companys").select2("destroy");
                jQuery("#regions").select2("destroy");
                jQuery("#product_name_list").select2("destroy");

                var company_name = jQuery("#companys option:selected").text();
                // var party_name = jQuery("#party option:selected").text();


                numberoforders = Object.keys(orders).length;

                if (numberoforders == 0) {
                    jQuery("#table_body_or").html("");
                }
                // console.log(company_id,party,limit);

                orders[counter] = {
                    // 'warehouse': warehouse,
                    // 'warehouse_name': warehouse_name,
                    'company_id': company_id,
                    'company_name': company_name,
                    'regions': regions,
                    'regions_name': regions_name,
                    'order_remarks': order_remarks,
                    'pro_qty': pro_qty,

                };

                console.log(orders);
                jQuery("#company_id option[value=" + company_id + "]").attr("disabled", "true");
                // jQuery("#regions option[value=" + regions + "]").attr("disabled", "true");
                numberoforders = Object.keys(orders).length;
                jQuery("#exp_total_items").val(numberoforders);
                // <td class="text-left tbl_srl_20">' + warehouse_name + '</td>
                jQuery("#table_body_ex").append(
                    '<tr id=' + counter + ' class="edit_update"><td class="text-center tbl_srl_9">' + company_name + '</td><td class="text-left tbl_txt_20">' + regions_name + '</td><td ' +
 'class="text-left' +
                    ' ' +
                     'tbl_txt_38">' + order_remarks + '</td><td class="text-right tbl_srl_6">' + pro_qty + '<div class="edit_update_bx"><a ' +
                      'class="edit_link btn btn-sm btn-success" href="#" onclick=edit_order(' + counter + ')><i class="fa fa-edit"></i></a> <a href="#" class="delete_link btn btn-sm btn-danger" ' +
                       'onclick=delete_order(' + counter + ')><i class="fa fa-trash"></i></a></div></td></tr>');

                jQuery('#company_id option[value="' + 0 + '"]').prop('selected', true);
                $("#regions option:selected").prop("selected", false)
                // jQuery('#regions').select2('val', '0');
                // jQuery('#warehouse option[value="' + 1 + '"]').prop('selected', true);

                jQuery("#pro_qty").val("");

                jQuery("#order_remarks").val("");
                // jQuery("#rate").val("");
                // jQuery("#amount").val("");

                jQuery("#order_array").val(JSON.stringify(orders));
                jQuery("#cancel_button").hide();
                jQuery(".table-responsive").show();
                jQuery("#save").show();
                jQuery("#first_add_more_ex").html('<i class="fa fa-plus"></i>  Add');

                jQuery("#total_items").val(numberoforders);

                jQuery("#companys").select2();
                jQuery("#regions").select2();
                // jQuery("#warehouse").select2();

                jQuery(".edit_link").show();
                jQuery(".delete_link").show();

            }
        }


        function delete_order_list(current_item) {

            jQuery("#" + current_item).remove();
            var temp_orders = orders[current_item];

            console.log(temp_orders, temp_orders['company_id']);
            jQuery("#companys option[value=" + temp_orders['company_id'] + "]").attr("disabled", false);
            // jQuery("#regions option[value=" + temp_orders['regions'] + "]").attr("disabled", false);

            jQuery("#companys").select2();
            jQuery("#regions").select2();

            delete orders[current_item];

            function isEmpty(obj) {

                for (var key in obj) {

                    if (obj.hasOwnProperty(key))
                        return false;
                }
                return true;
            }

            jQuery("#order_array").val(JSON.stringify(orders));
            jQuery("#exp_total_items").val(numberoforders);

            if (isEmpty(orders)) {
                numberoforders = 0;
            }


            // jQuery("#total_items").val(numberoforders);


        }

        function edit_order_list(current_item) {

            jQuery("#save").attr("style", "display:none");
            jQuery("#first_add_more_ex").html('<i class="fa fa-plus"></i> update');
            jQuery("#cancel_button").show();


            jQuery(".edit_link").hide();
            jQuery(".delete_link").hide();

            global_id_to_edit = current_item;

            var temp_orders = orders[current_item];

            edit_order_value = temp_orders['company_id'];

            jQuery("#companys").select2("destroy");
            jQuery("#regions").select2("destroy");
            // jQuery("#warehouse").select2("destroy");

            jQuery("#companys option[value=" + temp_orders['company_id'] + "]").attr("disabled", false);
            // jQuery("#regions option[value=" + temp_orders['regions'] + "]").attr("disabled", false);

            jQuery('#companys option[value="' + temp_orders['company_id'] + '"]').prop('selected', true);

            var value = temp_orders['regions'];

            for (var i = 0; i < value.length; i++) {
                jQuery('#regions option[value="' + value[i] + '"]').prop('selected', true);
                jQuery("#regions").select2();
            }

            // jQuery('#regions option[value="' + temp_orders['regions'] + '"]').prop('selected', true);

            //
            // jQuery("#product_name").val(temp_orders['product_code']);
            jQuery("#pro_qty").val(temp_orders['pro_qty']);

            // jQuery("#rate").val(temp_orders['product_rate']);
            // jQuery("#amount").val(temp_orders['product_amount']);
            jQuery("#order_remarks").val(temp_orders['order_remarks']);

            jQuery("#company_id").select2();
            jQuery("#regions").select2();
            //jQuery("#warehouse").select2();

            jQuery("#cancel_button").attr("style", "display:inline");
            jQuery("#cancel_button").attr("style", "background-color:red !important");
        }

        function cancel_all() {

            // var newvaltohide = jQuery("#product_code").val();

            var newvaltohide = edit_order_value;

            jQuery("#product_code option[value=" + newvaltohide + "]").attr("disabled", "true");

            jQuery("#product_name option[value=" + newvaltohide + "]").attr("disabled", "true");
            jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);
            // jQuery('#warehouse option[value="' + 1 + '"]').prop('selected', true);

            jQuery("#product_code").select2("destroy");
            jQuery("#product_name").select2("destroy");
            //jQuery("#warehouse").select2("destroy");

            jQuery("#product_remarks").val("");
            jQuery("#quantity").val("");
            jQuery("#rate").val("");
            jQuery("#amount").val("");

            jQuery("#product_code").select2();
            jQuery("#product_name").select2();
            // jQuery("#warehouse").select2();

            jQuery("#cancel_button").hide();
            jQuery(".table-responsive").show();
            jQuery("#save").show();
            jQuery("#first_add_more_ex").html('Add');

            global_id_to_edit = 0;


            jQuery(".edit_link").show();
            jQuery(".delete_link").show();

            edit_order_value = '';
        }
    </script>
    <script>

        jQuery("#account_name").change(function() {
             var companyId = $(this).find(':selected').val();

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_regions",
                data:{companyId: companyId},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#regions").html(" ");
                    jQuery("#regions").append(data.get_region);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                }
            });
        });

    </script>
    {{--    end Order List script--}}


    {{--    start working area script--}}

    <script>

        // adding packs into table
        var numberofarea = 0;
        var counter = 0;
        var areas = {};
        var global_id_to_edit = 0;
        var edit_product_value = '';


        function add_working_area() {

            var company = document.getElementById("company").value;
            // var region = document.getElementById("region").value;

            var region_value = $('#region').find(':selected').data('region-id');


            // var zone = document.getElementById("zone").value;
            var zone_value = $('#zone').find(':selected').data('zone-id');
            var city_value = document.getElementById("city").value;
            // var grid = document.getElementById("grid").value;
            var grid_value = $('#grid').find(':selected').data('grid-id');
            // var franchiseArea = document.getElementById("franchiseArea").value;
            var franchiseArea_value = $('#franchiseArea').find(':selected').data('franchise-area-id');


            var flag_submit1 = true;
            var focus_once1 = 0;

            if (company == "") {

                if (focus_once1 == 0) {
                    jQuery("#company").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (region_value == "") {

                if (focus_once1 == 0) {
                    jQuery("#region").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (zone_value == "") {

                if (focus_once1 == 0) {
                    jQuery("#zone").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (city_value == "") {

                if (focus_once1 == 0) {
                    jQuery("#city").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (grid_value == "") {

                if (focus_once1 == 0) {
                    jQuery("#grid").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (franchiseArea_value == "") {

                if (focus_once1 == 0) {
                    jQuery("#franchiseArea").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            //
            //
            // if (amount == "") {
            //
            //     if (focus_once1 == 0) {
            //         jQuery("#amount").focus();
            //         focus_once1 = 1;
            //     }
            //     flag_submit1 = false;
            // }


            if (flag_submit1) {

                if (global_id_to_edit != 0) {
                    jQuery("#" + global_id_to_edit).remove();

                    delete areas[global_id_to_edit];
                }

                counter++;

                jQuery("#company").select2("destroy");
                jQuery("#region").select2("destroy");
                jQuery("#zone").select2("destroy");
                jQuery("#city").select2("destroy");
                jQuery("#grid").select2("destroy");
                jQuery("#franchiseArea").select2("destroy");
                // jQuery("#warehouse").select2("destroy");

                // var warehouse = jQuery("#warehouse").val();
                // var warehouse_name = jQuery("#warehouse option:selected").text();
                var company_value = jQuery("#company option:selected").val();
                var company = jQuery("#company option:selected").text();
                // var region = $('#region').find(':selected').data('region-id');
                // var region_value = jQuery("#region option:selected").data('region-id');
                var region = jQuery("#region option:selected").text();
                // var zone_value = jQuery("#zone option:selected").val();
                var zone = jQuery("#zone option:selected").text();
                var city_value = jQuery("#city option:selected").val();
                var city = jQuery("#city option:selected").text();
                // var grid_value = jQuery("#grid option:selected").val();
                var grid = jQuery("#grid option:selected").text();
                // var franchiseArea_value = jQuery("#franchiseArea option:selected").val();
                var franchiseArea = jQuery("#franchiseArea option:selected").text();
                console.log(region_value, zone_value);
                // var qty = jQuery("#quantity").val();
                // // var selected_rate = 0;//jQuery("#rate").val();
                // var selected_rate = jQuery("#rate").val();
                // // var selected_amount = 0;//= jQuery("#amount").val();
                // var selected_amount = jQuery("#amount").val();
                // var selected_remarks = jQuery("#product_remarks").val();

                numberofarea = Object.keys(areas).length;

                if (numberofarea == 0) {
                    jQuery("#table_bodys").html("");
                }

                areas[counter] = {
                    // 'warehouse': warehouse,
                    // 'warehouse_name': warehouse_name,
                    'company_value': company_value,
                    'company': company,
                    'region_value': region_value,
                    'region': region,
                    'zone_value': zone_value,
                    'zone': zone,
                    'city_value': city_value,
                    'city': city,
                    'grid_value': grid_value,
                    'grid': grid,
                    'franchiseArea_value': franchiseArea_value,
                    'franchiseArea': franchiseArea,

                };

                // <a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_working_area(' + counter + ')><i class="fa fa-edit"></i></a>
                jQuery("#table_bodys").append(
                    '<tr id=' + counter + ' class="edit_update"><td class="text-center tbl_srl_9">' + company + '</td><td class="text-left tbl_txt_20">' + region + '</td><td class="text-left tbl_txt_44">' + zone + '</td><td class="text-right tbl_srl_6">' + city + '</td><td class="text-right tbl_srl_12" >' + grid + '</td><td class="text-right tbl_srl_12">' + franchiseArea + '<div class="edit_update_bx"> <a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_working_area(' + counter + ')><i class="fa fa-trash"></i></a></div></td></tr>');

                // jQuery('#company option[value="' + "" + '"]').prop('selected', true);

                // jQuery('#region').html('');
                // jQuery('#zone').html('');
                // jQuery('#city').html('');
                // jQuery('#grid').html('');
                // jQuery('#franchiseArea').html('');
                //
                // jQuery('#region').append('<option value="0" selected disabled>Select Region</option><option value="empty">No Region is Available.</option>');
                // jQuery('#zone').append('<option value="0" selected disabled>Select Zone</option><option value="empty">No Zone is Available.</option>');
                // jQuery('#city').append('<option value="0" selected disabled>Select City</option><option value="empty">No City is Available.</option>');
                // jQuery('#grid').append('<option value="0" selected disabled>Select Grid</option><option value="empty">No Grid is Available.</option>');
                // jQuery('#franchiseArea').append('<option value="0" selected disabled>Select FranchiseArea</option><option value="empty">No FranchiseArea is Available.</option>');
                // jQuery('#company option[value="' + "" + '"]').prop('selected', true);
                // jQuery('#region option[value="' + "" + '"]').prop('selected', true);
                // jQuery('#zone option[value="' + "" + '"]').prop('selected', true);
                // jQuery('#city option[value="' + "" + '"]').prop('selected', true);
                // jQuery('#grid option[value="' + "" + '"]').prop('selected', true);
                // jQuery('#franchiseArea option[value="' + "" + '"]').prop('selected', true);
                // jQuery('#warehouse option[value="' + 1 + '"]').prop('selected', true);

                // jQuery("#quantity").val("");
                // jQuery("#product_remarks").val("");
                // jQuery("#rate").val("");
                // jQuery("#amount").val("");

                jQuery("#working_area_array").val(JSON.stringify(areas));
                jQuery("#cancel_button").hide();
                jQuery(".table-responsive").show();
                jQuery("#save").show();
                jQuery("#first_add_more").html('<i class="fa fa-plus"></i>  Add');

                jQuery("#total_items").val(numberofarea);

                jQuery("#company").select2();
                jQuery("#region").select2();
                jQuery("#zone").select2();
                jQuery("#city").select2();
                jQuery("#grid").select2();
                jQuery("#franchiseArea").select2();
                // jQuery("#warehouse").select2();

                // grand_total_calculation();

                jQuery(".edit_link").show();
                jQuery(".delete_link").show();
            }
        }


        function delete_working_area(current_item) {

            jQuery("#" + current_item).remove();
            var temp_products = areas[current_item];
            jQuery("#company option[value=" + temp_products['company'] + "]").attr("disabled", false);
            jQuery("#product_name option[value=" + temp_products['product_code'] + "]").attr("disabled", false);

            delete areas[current_item];

            function isEmpty(obj) {

                for (var key in obj) {

                    if (obj.hasOwnProperty(key))
                        return false;
                }
                return true;
            }

            jQuery("#working_hours_per_day").val(JSON.stringify(areas));


            if (isEmpty(areas)) {
                numberofarea = 0;
            }
            jQuery("#total_items").val(numberofarea);

            grand_total_calculation();
        }


        function edit_working_area(current_item) {

            jQuery("#save").attr("style", "display:none");
            jQuery("#first_add_more").html('<i class="fa fa-plus"></i> update');
            jQuery("#cancel_button").show();


            jQuery(".edit_link").hide();
            jQuery(".delete_link").hide();

            global_id_to_edit = current_item;

            var temp_products = areas[current_item];

            console.log(temp_products);
            edit_product_value = temp_products['company_value'];

            jQuery("#company").select2("destroy");
            jQuery("#product_name").select2("destroy");
            // jQuery("#warehouse").select2("destroy");

            // jQuery("company option[value=" + temp_products['company_value'] + "]").attr("disabled", false);
            // jQuery("#product_name option[value=" + temp_products['product_code'] + "]").attr("disabled", false);

            jQuery('#company option[value="' + temp_products['company_value'] + '"]').prop('selected', true);
            // jQuery('#warehouse option[value="' + temp_products['warehouse'] + '"]').prop('selected', true);


            jQuery("#region").val(temp_products['region_value']);
            // jQuery("#quantity").val(temp_products['product_qty']);
            // jQuery("#rate").val(temp_products['product_rate']);
            // jQuery("#amount").val(temp_products['product_amount']);
            // jQuery("#product_remarks").val(temp_products['product_remarks']);

            jQuery("#product_code").select2();
            jQuery("#product_name").select2();
            //jQuery("#warehouse").select2();

            jQuery("#cancel_button").attr("style", "display:inline");
            jQuery("#cancel_button").attr("style", "background-color:red !important");
        }

        function cancel_all() {

            // var newvaltohide = jQuery("#product_code").val();

            var newvaltohide = edit_product_value;

            jQuery("#product_code option[value=" + newvaltohide + "]").attr("disabled", "true");

            jQuery("#product_name option[value=" + newvaltohide + "]").attr("disabled", "true");
            jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);
            // jQuery('#warehouse option[value="' + 1 + '"]').prop('selected', true);

            jQuery("#product_code").select2("destroy");
            jQuery("#product_name").select2("destroy");
            //jQuery("#warehouse").select2("destroy");

            // jQuery("#product_remarks").val("");
            // jQuery("#quantity").val("");
            // jQuery("#rate").val("");
            // jQuery("#amount").val("");

            jQuery("#product_code").select2();
            jQuery("#product_name").select2();
            // jQuery("#warehouse").select2();

            jQuery("#cancel_button").hide();
            jQuery(".table-responsive").show();
            jQuery("#save").show();
            jQuery("#first_add_more").html('Add');

            global_id_to_edit = 0;


            jQuery(".edit_link").show();
            jQuery(".delete_link").show();

            edit_product_value = '';
        }
    </script>

    {{--    end working area script--}}
    {{--    Start expense budget script--}}

    <script>

        // adding packs into table
        var numberofexpenses = 0;
        var counter = 0;
        var expenses = {};
        var global_id_to_edit = 0;
        var edit_expense_value = '';


        function add_expense() {

            var type_of_expense = document.getElementById("type_of_expense").value;
            // var party = document.getElementById("party").value;

            var party = $('.party').val();

            var party_name = $('#party option:selected')
                .toArray().map(party => party.text);

            var expense_remarks = document.getElementById("expense_remarks").value;
            var limit = document.getElementById("limit").value;
            var limit_pec = document.getElementById("limit_pec").value;
            // var rate = document.getElementById("rate").value;
            // var amount = document.getElementById("amount").value;


            var flag_submit1 = true;
            var focus_once1 = 0;

            if (type_of_expense == "0") {

                if (focus_once1 == 0) {
                    jQuery("#type_of_expense").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (party == "0") {

                if (focus_once1 == 0) {
                    jQuery("#party").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


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

                jQuery("#type_of_expense").select2("destroy");
                jQuery("#party").select2("destroy");

                var expense_type = jQuery("#type_of_expense option:selected").text();
                // var party_name = jQuery("#party option:selected").text();


                numberofexpenses = Object.keys(expenses).length;

                if (numberofexpenses == 0) {
                    jQuery("#table_body_ex").html("");
                }
                // console.log(type_of_expense,party,limit);

                expenses[counter] = {
                    // 'warehouse': warehouse,
                    // 'warehouse_name': warehouse_name,
                    'type_of_expense': type_of_expense,
                    'expense_type': expense_type,
                    'party': party,
                    'party_name': party_name,
                    'expense_remarks': expense_remarks,
                    'limit': limit,
                    'limit_pec': limit_pec,


                };

                console.log(expenses);
                jQuery("#type_of_expense option[value=" + type_of_expense + "]").attr("disabled", "true");
                // jQuery("#party option[value=" + party + "]").attr("disabled", "true");
                numberofexpenses = Object.keys(expenses).length;
                jQuery("#exp_total_items").val(numberofexpenses);
                // <td class="text-left tbl_srl_20">' + warehouse_name + '</td>
                jQuery("#table_body_ex").append(
                    '<tr id=' + counter + ' class="edit_update"><td class="text-center tbl_srl_9">' + expense_type + '</td><td class="text-left tbl_txt_20">' + party_name + '</td><td class="text-left tbl_txt_38">' + expense_remarks + '</td><td class="text-left tbl_txt_6">' + limit_pec + '</td><td class="text-right tbl_srl_6">' + limit + '<div class="edit_update_bx"><a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_expense(' + counter + ')><i class="fa fa-edit"></i></a> <a href="#" class="delete_link btn btn-sm btn-danger" onclick=delete_expense(' + counter + ')><i class="fa fa-trash"></i></a></div></td></tr>');

                jQuery('#type_of_expense option[value="' + 0 + '"]').prop('selected', true);
                $("#party option:selected").prop("selected", false)
                // jQuery('#party').select2('val', '0');
                // jQuery('#warehouse option[value="' + 1 + '"]').prop('selected', true);

                jQuery("#limit").val("");
                jQuery("#limit_pec").val("");
                jQuery("#expense_remarks").val("");
                // jQuery("#rate").val("");
                // jQuery("#amount").val("");

                jQuery("#expense_array").val(JSON.stringify(expenses));
                jQuery("#cancel_button").hide();
                jQuery(".table-responsive").show();
                jQuery("#save").show();
                jQuery("#first_add_more_ex").html('<i class="fa fa-plus"></i>  Add');

                jQuery("#total_items").val(numberofexpenses);

                jQuery("#type_of_expense").select2();
                jQuery("#party").select2();
                // jQuery("#warehouse").select2();

                jQuery(".edit_link").show();
                jQuery(".delete_link").show();
                grand_total_calculation_expense();
                calculate();
            }
        }


        function delete_expense(current_item) {

            jQuery("#" + current_item).remove();
            var temp_expenses = expenses[current_item];

            console.log(temp_expenses, temp_expenses['type_of_expense']);
            jQuery("#type_of_expense option[value=" + temp_expenses['type_of_expense'] + "]").attr("disabled", false);
            // jQuery("#party option[value=" + temp_expenses['party'] + "]").attr("disabled", false);

            jQuery("#type_of_expense").select2();
            jQuery("#party").select2();

            delete expenses[current_item];

            function isEmpty(obj) {

                for (var key in obj) {

                    if (obj.hasOwnProperty(key))
                        return false;
                }
                return true;
            }

            jQuery("#expense_array").val(JSON.stringify(expenses));
            jQuery("#exp_total_items").val(numberofexpenses);

            if (isEmpty(expenses)) {
                numberofexpenses = 0;
            }

            grand_total_calculation_expense();
            calculate();
            // jQuery("#total_items").val(numberofexpenses);


        }

        function edit_expense(current_item) {

            jQuery("#save").attr("style", "display:none");
            jQuery("#first_add_more_ex").html('<i class="fa fa-plus"></i> update');
            jQuery("#cancel_button").show();


            jQuery(".edit_link").hide();
            jQuery(".delete_link").hide();

            global_id_to_edit = current_item;

            var temp_expenses = expenses[current_item];

            edit_expense_value = temp_expenses['type_of_expense'];

            jQuery("#type_of_expense").select2("destroy");
            jQuery("#party").select2("destroy");
            // jQuery("#warehouse").select2("destroy");

            jQuery("#type_of_expense option[value=" + temp_expenses['type_of_expense'] + "]").attr("disabled", false);
            // jQuery("#party option[value=" + temp_expenses['party'] + "]").attr("disabled", false);

            jQuery('#type_of_expense option[value="' + temp_expenses['type_of_expense'] + '"]').prop('selected', true);

            var value = temp_expenses['party'];

            for (var i = 0; i < value.length; i++) {
                jQuery('#party option[value="' + value[i] + '"]').prop('selected', true);
                jQuery("#party").select2();
            }

            // jQuery('#party option[value="' + temp_expenses['party'] + '"]').prop('selected', true);

            //
            // jQuery("#product_name").val(temp_expenses['product_code']);
            jQuery("#limit").val(temp_expenses['limit']);
            jQuery("#limit_pec").val(temp_expenses['limit_pec']);
            // jQuery("#rate").val(temp_expenses['product_rate']);
            // jQuery("#amount").val(temp_expenses['product_amount']);
            jQuery("#expense_remarks").val(temp_expenses['expense_remarks']);

            jQuery("#type_of_expense").select2();
            jQuery("#party").select2();
            //jQuery("#warehouse").select2();

            jQuery("#cancel_button").attr("style", "display:inline");
            jQuery("#cancel_button").attr("style", "background-color:red !important");
        }

        function cancel_all() {

            // var newvaltohide = jQuery("#product_code").val();

            var newvaltohide = edit_expense_value;

            jQuery("#product_code option[value=" + newvaltohide + "]").attr("disabled", "true");

            jQuery("#product_name option[value=" + newvaltohide + "]").attr("disabled", "true");
            jQuery('#product_code option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#product_name option[value="' + 0 + '"]').prop('selected', true);
            // jQuery('#warehouse option[value="' + 1 + '"]').prop('selected', true);

            jQuery("#product_code").select2("destroy");
            jQuery("#product_name").select2("destroy");
            //jQuery("#warehouse").select2("destroy");

            jQuery("#product_remarks").val("");
            jQuery("#quantity").val("");
            jQuery("#rate").val("");
            jQuery("#amount").val("");

            jQuery("#product_code").select2();
            jQuery("#product_name").select2();
            // jQuery("#warehouse").select2();

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
    {{--    end expense budget script--}}

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

                jQuery('#material_product_code option[value="' + 0 + '"]').prop('selected', true);
                jQuery('#material_product_name option[value="' + 0 + '"]').prop('selected', true);

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
                calculate();

                jQuery("#material_product_code").select2();
                jQuery("#material_product_name").select2();
            }
        }


        function delete_material(current_item) {

            jQuery("#" + current_item).remove();

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
            calculate();


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

            jQuery('#material_product_code option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#material_product_name option[value="' + 0 + '"]').prop('selected', true);

            jQuery("#material_product_code").select2("destroy");
            jQuery("#material_product_name").select2("destroy");

            jQuery("#material_remarks").val("");
            jQuery("#rate_material").val("");
            jQuery("#amount").val("");

            jQuery("#product_code").select2();
            jQuery("#product_name").select2();

            jQuery("#cancel_button").hide();

            // jQuery(".table-responsive").show();
            jQuery("#" + global_id_to_edit).show();

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
            {{--jQuery("#material_product_code").append("{!! $pro_code !!}");--}}
            {{--jQuery("#material_product_name").append("{!! $pro_name !!}");--}}


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

@endsection


