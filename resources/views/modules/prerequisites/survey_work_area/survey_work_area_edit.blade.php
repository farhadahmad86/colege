@extends('extend_index')

@section('content')

    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">


                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Edit Survey Working Area</h4>
                        </div>
                        <div class="list_btn">
                            <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('survey_work_area_list') }}" role="button">
                                <i class="fa fa-list"></i> view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->


                <div id="invoice_con" class="gnrl-mrgn-pdng invoice_con for_voucher"><!-- invoice container start -->
                    <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate"><!-- invoice box start -->

                        <form id="f1" action="{{ route('update_survey_work_area') }}" method="post" onsubmit="return checkForm()">
                            @csrf

                            <div class="pd-20">
                                <input type="hidden" id="data"

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

                                                <!-- quantity manage -->

                                                <div class="invoice_col basis_col_13"><!-- invoice column start -->
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
                                                            Used QTY
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
                                                            Due QTY
                                                        </label><!-- invoice column title end -->
                                                        <div class="invoice_col_txt"><!-- invoice column input start -->
                                                            <h5 class="grandTotalFont" id="remainingTotalQtyView">
                                                                0
                                                            </h5>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                    <span style="color: red" id="cal_remain"></span>
                                                </div><!-- invoice column end -->


                                                <div class="invoice_col basis_col_9" hidden>
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class=" invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Total QTY
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->
                                                            <input tabindex="5" type="text" name="total_qty"
                                                                   class="inputs_up form-control"
                                                                   id="total_qty" placeholder="qty" readonly>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_9" hidden>
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class=" invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Used QTY
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->
                                                            <input tabindex="6" type="text" name="consume_qty"
                                                                   class="inputs_up form-control"
                                                                   id="consume_qty" placeholder="qty" readonly>
                                                            <input tabindex="6" type="text" name="used_qty"
                                                                   class="inputs_up form-control"
                                                                   id="used_qty" placeholder="qty" readonly>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_9" hidden>
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class=" invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Due QTY
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->
                                                            <input tabindex="7" type="text" name="remaining_qty"
                                                                   class="inputs_up form-control"
                                                                   id="remaining_qty" placeholder="qty" readonly>
                                                            <input tabindex="7" type="text" name="dues_qty"
                                                                   class="inputs_up form-control"
                                                                   id="dues_qty" placeholder="qty" readonly>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->
                                            </div>  <!-- row end -->

                                            <div class="invoice_row">
                                                <div class="invoice_col basis_col_41">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Order List
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->
                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->


                                                            </div><!-- invoice column short end -->
                                                            <select tabindex="2" name="order_list" id="order_list"
                                                                    data-fetch-url="{{ route('api.companies.options') }}"
                                                                    data-rule-required="true" data-msg-required="Please Choose Order List"
                                                                    class="inputs_up form-control auto-select company_dropdown"
                                                            >
                                                                <option value="" selected disabled>
                                                                    Select Order List
                                                                </option>
                                                                @foreach ($order_lists as $order_list)
                                                                    <option
                                                                        value="{{ $order_list->ol_id }}" {{ $order_list->ol_id == $works->swa_company_id ? 'selected="selected"' : '' }}>{{
                                                                        $order_list->ol_order_title }}</option>
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

                                                            Region
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
                                                            <select tabindex="6" name="zone" id="zone"
                                                                    class="inputs_up form-control @error('zone') is-invalid @enderror"
                                                            >
                                                                <option value="" selected disabled>
                                                                    Select Order List
                                                                    First
                                                                </option>
                                                            </select>

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->


                                                <div class="invoice_col basis_col_15"><!-- invoice column start -->
                                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                                        <div class=" invoice_col_ttl"><!-- invoice column title start -->

                                                            Select Employee / Vendor
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_txt inline_radio"><!-- invoice column input start -->
                                                            <div class="radio">
                                                                <label>
                                                                    <input tabindex="4" type="radio" name="surveyor_type" class="invoice_type" id="employee_show" value="employee" checked>
                                                                    Employee
                                                                </label>
                                                            </div>
                                                            <div class="radio">
                                                                <label>
                                                                    <input tabindex="5" type="radio" name="surveyor_type" class="invoice_type" id="vendor" value="vendor">
                                                                    Vendors
                                                                </label>
                                                            </div>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                            </div>
                                            <div class="invoice_row"><!-- invoice row start -->

                                                <div class="invoice_col basis_col_12">
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

                                                            </div><!-- invoice column short end -->
                                                            <select tabindex="7" name="product_name" id="product_name"
                                                                    class="inputs_up form-control @error('product_name') is-invalid @enderror"
                                                            >
                                                                <option value="" selected disabled>
                                                                    Select Product name
                                                                </option>
                                                            </select>
                                                            <span id="city_error" style="color: red"></span>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_12">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Service Name
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <select tabindex="7" name="service" id="service"
                                                                    class="inputs_up form-control"
                                                            >
                                                                <option value="" selected disabled>
                                                                    Select Service
                                                                </option>
                                                            </select>
                                                            <span id="city_error" style="color: red"></span>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->


                                                <div class="invoice_col basis_col_12">
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
                                                            <select tabindex="7" name="city" id="city"
                                                                    class="inputs_up form-control @error('city') is-invalid @enderror"
                                                            >
                                                                <option value="" selected disabled>
                                                                    Select Zone First
                                                                </option>
                                                            </select>
                                                            <span id="city_error" style="color: red"></span>
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_12">
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
                                                            <select tabindex="8" name="grid" id="grid"
                                                                    class="inputs_up form-control @error('grid') is-invalid @enderror"
                                                            >
                                                                <option value="" selected disabled>
                                                                    Select City First
                                                                </option>
                                                            </select>

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_12">
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
                                                            <select tabindex="9" name="franchiseArea"
                                                                    id="franchiseArea"
                                                                    class="inputs_up form-control @error('franchiseArea') is-invalid @enderror"
                                                            >
                                                                <option value="" selected disabled>
                                                                    Select Grid First
                                                                </option>
                                                            </select>

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->


                                                <div class="invoice_col basis_col_12">
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

                                                            </div><!-- invoice column short end -->
                                                            <select tabindex="10" name="supervisor"
                                                                    id="supervisor"
                                                                    class="inputs_up form-control"
                                                            >
                                                                <option value="" selected disabled>
                                                                    Select Supervisor
                                                                </option>
                                                                @foreach($supervisors as $supervisor)
                                                                    <option value="{{ $supervisor->user_id }}">{{ $supervisor->user_name }}  </option>
                                                                @endforeach
                                                            </select>

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_12" id="employee_div">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Employee
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <select tabindex="11" name="employee"
                                                                    id="employee"
                                                                    class="inputs_up form-control"
                                                            >
                                                                <option value="" selected disabled>
                                                                    Select Employee
                                                                </option>
                                                                @foreach($employees as $supervisor)
                                                                    <option value="{{ $supervisor->user_id }}">{{ $supervisor->user_name }}  </option>
                                                                @endforeach
                                                            </select>

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_12" id="supplier_div">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Supplier
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <select tabindex="12" name="supplier"
                                                                    id="supplier"
                                                                    class="inputs_up form-control"
                                                            >
                                                                <option value="" selected disabled>
                                                                    Select Supplier
                                                                </option>
                                                                @foreach($suppliers as $supplier)
                                                                    <option value="{{ $supplier->account_uid }}">{{ $supplier->account_name }}  </option>
                                                                @endforeach
                                                            </select>

                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_12">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Username
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <select tabindex="12" name="username"
                                                                    id="username"
                                                                    class="inputs_up form-control"
                                                            >
                                                                <option value="" selected disabled>
                                                                    Select Username
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

                                                            QTY
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <input tabindex="13" type="text" name="qty" id="qty" class="inputs_up form-control" placeholder="QTY">
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_10">
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
                                                            <input tabindex="13" type="text" name="rate" id="rate" class="inputs_up form-control" placeholder="0.00">
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_10">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Amount
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <input tabindex="13" type="text" name="amount" id="amount" class="inputs_up form-control" placeholder="0.00">
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_10">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Start Date
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <input tabindex="13" type="text" name="start_date" id="start_date" class="inputs_up form-control datepicker1" autocomplete="off" value=""
                                                                   placeholder="Start
                                                            Date
                                                            ......">
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_10">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            End Date
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <input tabindex="14" type="text" name="end_date" id="end_date" class="inputs_up form-control datepicker1" autocomplete="off" value=""
                                                                   placeholder="End
                                                            Date
                                                             ...
                                                            ...">
                                                        </div><!-- invoice column input end -->
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                                <div class="invoice_col basis_col_10">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->

                                                            Valid For Days
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <input tabindex="14" type="text" name="valid_days" id="valid_days" class="inputs_up form-control"
                                                                   placeholder="Days">
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
                                                                <button tabindex="15" id="first_add_more"
                                                                        class="invoice_frm_btn"
                                                                        onclick="add_working_area()"
                                                                        type="button">
                                                                    <i class="fa fa-plus"></i> Add
                                                                </button>
                                                            </div>
                                                            <div
                                                                class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                                <button tabindex="16" style="display: none;"
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
                                                                    <table class="table gnrl-mrgn-pdng table-responsive" id="category_dynamic_table">
                                                                        <thead>
                                                                        <tr>

                                                                            <th tabindex="-1" class="text-center tbl_txt_8">
                                                                                Product Name
                                                                            </th>
                                                                            <th tabindex="-1" class="text-center tbl_txt_7">
                                                                                Service Name
                                                                            </th>
                                                                            <th tabindex="-1" class="text-center tbl_txt_5">
                                                                                Region
                                                                            </th>
                                                                            <th tabindex="-1" class="text-center tbl_txt_6">
                                                                                City
                                                                            </th>
                                                                            <th tabindex="-1" class="text-center tbl_txt_3">
                                                                                Grid
                                                                            </th>
                                                                            <th tabindex="-1" class="text-center tbl_txt_6">
                                                                                Franchise
                                                                            </th>

                                                                            <th tabindex="-1" class="text-center tbl_txt_6">
                                                                                Surveyor Type
                                                                            </th>
                                                                            <th tabindex="-1" class="text-center tbl_txt_7">
                                                                                Supervisor
                                                                            </th>

                                                                            <th tabindex="-1" class="text-center tbl_txt_6">
                                                                                Surveyor
                                                                            </th>
                                                                            <th tabindex="-1" class="text-center tbl_txt_6">
                                                                                Username
                                                                            </th>
                                                                            <th tabindex="-1" class="text-center tbl_txt_6">
                                                                                QTY
                                                                            </th>
                                                                            <th tabindex="-1" class="text-center tbl_txt_8">
                                                                                Rate
                                                                            </th>
                                                                            <th tabindex="-1" class="text-center tbl_txt_8">
                                                                                Amount
                                                                            </th>

                                                                            <th tabindex="-1" class="text-center tbl_txt_7">
                                                                                Start Date
                                                                            </th>
                                                                            <th tabindex="-1" class="text-center tbl_txt_7">
                                                                                End Date
                                                                            </th>
                                                                            <th tabindex="-1" class="text-center tbl_txt_5">
                                                                                Valid For Days
                                                                            </th>
                                                                        </tr>
                                                                        </thead>

                                                                        <tbody id="table_body">
                                                                        <tr>
                                                                            <td tabindex="-1" colspan="10"
                                                                                align="center">
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
                                                                            <td class="text-center tbl_srl_12">
                                                                                <div
                                                                                    class="invoice_col_txt">
                                                                                    <!-- invoice column box start -->
                                                                                    <div
                                                                                        class="invoice_col_input">
                                                                                        <!-- invoice column input start -->
                                                                                        <input tabindex="-1" type="text"
                                                                                               name="total_items"
                                                                                               class="inputs_up text-right form-control total-items-field"
                                                                                               id="total_items"
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
                                                    <div class="invoice_col_txt with_cntr_jstfy for_voucher_btns"><!-- invoice column box start -->
                                                        <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                            <button tabindex="15" type="submit" name="save" id="save" class="invoice_frm_btn">
                                                                <i class="fa fa-floppy-o"></i> Save
                                                            </button>
                                                        </div>
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                            </div><!-- invoice row end -->
                                        </div><!-- invoice content end -->
                                    </div><!-- invoice scroll box end -->


                                    <input tabindex="-1" type="hidden" name="working_area_array"
                                           id="working_area_array">
                                    <input tabindex="-1" type="text" name="work_id"
                                           id="work_id" value="{{$works->swa_id}}">

                                </div>

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
                            <button tabindex="-1" type="button" class="btn btn-default form-control cancel_button" data-dismiss="modal">
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
            let project = document.getElementById("project"),
                company = document.getElementById("company"),
                region = document.getElementById("region"),
                total_items = document.getElementById("total_items"),
                validateInputIdArray = [
                    project.id,
                    company.id,
                    region.id,
                    total_items.id,
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

        //         jQuery("#project").change(function () {
        //             var project = $(this).find(':selected').val();
        //
        //             jQuery.ajaxSetup({
        //                 headers: {
        //                     'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        //                 }
        //             });
        //
        //             jQuery.ajax({
        //                 url: "get_company",
        //                 data: {project: project},
        //                 type: "GET",
        //                 cache: false,
        //                 dataType: 'json',
        //                 success: function (data) {
        // // console.log(data.get_company);
        //                     jQuery("#company").html(" ");
        //                     jQuery("#company").append(data.get_company);
        //                 },
        //                 error: function (jqXHR, textStatus, errorThrown) {
        //                     alert(jqXHR.responseText);
        //                     alert(errorThrown);
        //                 }
        //             });
        //         });
    </script>
    {{--    start working area script--}}

    <script>

        // adding packs into table
        var numberofarea = 0;
        var counter = 0;
        var areas = {};
        var global_id_to_edit = 0;
        var edit_product_value = '';


        function add_working_area() {

            var remaining_qty = document.getElementById("remaining_qty").value;
            var product_code = document.getElementById("product_name").value;
            var product_name = jQuery("#product_name option:selected").text();

            var service_id = document.getElementById("service").value;
            var service_name = jQuery("#service option:selected").text();


            var zones = document.getElementById("zone").value;
            var zone_value = $('#zone').find(':selected').data('zone-id');
            var city_value = document.getElementById("city").value;
            var grids = document.getElementById("grid").value;
            var grid_value = $('#grid').find(':selected').data('grid-id');
            var franchiseAreas = document.getElementById("franchiseArea").value;
            var franchiseArea_value = $('#franchiseArea').find(':selected').data('franchise-area-id');

            var supervisor_value = document.getElementById("supervisor").value;
            var employee_value = document.getElementById("employee").value;
            var supplier_value = document.getElementById("supplier").value;
            var surveyor_type = $('input[name="surveyor_type"]:checked').val();
            var username_id = document.getElementById("username").value;
            var username = jQuery("#username option:selected").text();

            var qty = document.getElementById("qty").value;
            var rate = document.getElementById("rate").value;
            var amount = document.getElementById("amount").value;
            var start_date = document.getElementById("start_date").value;
            var end_date = document.getElementById("end_date").value;
            var valid_days = document.getElementById("valid_days").value;

            var flag_submit1 = true;
            var focus_once1 = 0;


            if (remaining_qty < 0) {

                if (focus_once1 == 0) {
                    $("#cal_remain").text("Remaining qty not less than 0");
                    // jQuery("#total_price").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (product_code == "") {

                if (focus_once1 == 0) {
                    jQuery("#product_name").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }
            if (service_id == "") {

                if (focus_once1 == 0) {
                    jQuery("#service").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (zones == "" || zone_value == "undefined") {

                if (focus_once1 == 0) {
                    jQuery("#zone").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (city_value == "") {

                if (focus_once1 == 0) {
                    jQuery("#city").focus();
                    jQuery("#city_error").val('Required');
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (grids == "") {

                if (focus_once1 == 0) {
                    jQuery("#grid").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (franchiseAreas == "") {
                if (focus_once1 == 0) {
                    jQuery("#franchiseArea").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (supervisor_value == "") {
                if (focus_once1 == 0) {
                    jQuery("#supervisor").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }
            if (surveyor_type == 'employee') {
                if (employee_value == "") {
                    if (focus_once1 == 0) {
                        jQuery("#employee").focus();
                        focus_once1 = 1;
                    }
                    flag_submit1 = false;
                }
            } else {
                if (supplier_value == "") {
                    if (focus_once1 == 0) {
                        jQuery("#supplier").focus();
                        focus_once1 = 1;
                    }
                    flag_submit1 = false;
                }
            }
            if (username_id == "") {
                if (focus_once1 == 0) {
                    jQuery("#username").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (qty == "") {
                if (focus_once1 == 0) {
                    jQuery("#qty").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }
            if (rate == "") {
                if (focus_once1 == 0) {
                    jQuery("#rate").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }
            if (amount == "" && amount == 0) {
                if (focus_once1 == 0) {
                    jQuery("#amount").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (start_date == "") {
                if (focus_once1 == 0) {
                    jQuery("#start_date").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }
            if (end_date == "") {
                if (focus_once1 == 0) {
                    jQuery("#end_date").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }
            if (valid_days == "") {
                if (focus_once1 == 0) {
                    jQuery("#valid_days").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (flag_submit1) {

                if (global_id_to_edit != 0) {
                    jQuery("#" + global_id_to_edit).remove();

                    delete areas[global_id_to_edit];
                }

                counter++;


                jQuery("#product_name").select2("destroy");
                jQuery("#service").select2("destroy");
                jQuery("#zone").select2("destroy");
                jQuery("#city").select2("destroy");
                jQuery("#grid").select2("destroy");
                jQuery("#franchiseArea").select2("destroy");

                jQuery("#supervisor").select2("destroy");
                jQuery("#employee").select2("destroy");
                jQuery("#supplier").select2("destroy");
                jQuery("#username").select2("destroy");

                var zone = jQuery("#zone option:selected").text();
                var city_value = jQuery("#city option:selected").val();
                var city = jQuery("#city option:selected").text();
                // var grid_value = jQuery("#grid option:selected").val();
                var grid = jQuery("#grid option:selected").text();
                // var franchiseArea_value = jQuery("#franchiseArea option:selected").val();
                var franchiseArea = jQuery("#franchiseArea option:selected").text();

                var supervisor = jQuery("#supervisor option:selected").text();
                var employee = jQuery("#employee option:selected").text();
                var supplier = jQuery("#supplier option:selected").text();


                numberofarea = Object.keys(areas).length;

                if (numberofarea == 0) {
                    jQuery("#table_body").html("");
                }

                areas[counter] = {

                    'product_code': product_code,
                    'product_name': product_name,
                    'service_id': service_id,
                    'service_name': service_name,
                    'zone_value': zone_value,
                    'zone': zone,
                    'city_value': city_value,
                    'city': city,
                    'grid_value': grid_value,
                    'grid': grid,
                    'franchiseArea_value': franchiseArea_value,
                    'franchiseArea': franchiseArea,

                    'supervisor': supervisor,
                    'supervisor_value': supervisor_value,

                    'username_id': username_id,
                    'username': username,
                    'qty': qty,
                    'rate': rate,
                    'amount': amount,
                    'start_date': start_date,
                    'end_date': end_date,
                    'valid_days': valid_days,

                    'surveyor_type': surveyor_type,
                    'employee_value': employee_value,
                    'supplier_value': supplier_value,
                    'supplier': supplier,
                    'employee': employee,

                };

                numberofarea = Object.keys(areas).length;
                jQuery("#total_items").val(numberofarea);
                // <a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_working_area(' + counter + ')><i class="fa fa-edit"></i></a>
                var type = '';
                if (surveyor_type == "employee") {
                    type = employee;
                } else {
                    type = supplier;
                }

                jQuery("#table_body").append(
                    '<tr id=' + counter + ' class="edit_update">' +
                    '<td class="text-left tbl_txt_8">' + product_name + '</td>' +
                    '<td class="text-left tbl_txt_7">' + service_name + '</td>' +
                    '<td class="text-left tbl_txt_5">' + zone + '</td>' +
                    '<td class="text-left tbl_txt_6">' + city + '</td>' +
                    '<td class="text-left tbl_txt_3" >' + grid + '</td>' +
                    '<td class="text-left tbl_txt_6" >' + franchiseArea + '</td>' +
                    '<td class="text-left tbl_txt_6" >' + surveyor_type + '</td>' +
                    '<td class="text-left tbl_txt_7" >' + supervisor + '</td>' +
                    '<td class="text-left tbl_txt_6" >' + type + '</td>' +
                    '<td class="text-left tbl_txt_6" >' + username + '</td>' +
                    '<td class="text-left tbl_txt_6" >' + qty + '</td>' +
                    '<td class="text-left tbl_txt_8" >' + rate + '</td>' +
                    '<td class="text-left tbl_txt_8" >' + amount + '</td>' +
                    '<td class="text-left tbl_txt_7" >' + start_date + '</td>' +
                    '<td class="text-left tbl_txt_7" >' + end_date + '</td>' +
                    '<td class="text-left tbl_txt_5">' + valid_days + '<div class="edit_update_bx"> <a href="#" class="delete_link btn btn-sm btn-danger" ' +
                    'onclick=delete_working_area(' + counter + ')><i class="fa fa-trash"></i></a></div></td></tr>');


                jQuery('#product_name option[value="' + "" + '"]').prop('selected', true);
                jQuery('#service option[value="' + "" + '"]').prop('selected', true);
                jQuery('#username option[value="' + "" + '"]').prop('selected', true);
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


                // jQuery("#quantity").val("");
                // jQuery("#product_remarks").val("");
                jQuery("#start_date").val("");
                jQuery("#end_date").val("");
                jQuery("#qty").val("");
                jQuery("#rate").val("");
                jQuery("#amount").val("");
                jQuery("#valid_days").val("");


                jQuery("#working_area_array").val(JSON.stringify(areas));
                jQuery("#cancel_button").hide();
                jQuery(".table-responsive").show();
                jQuery("#save").show();
                jQuery("#first_add_more").html('<i class="fa fa-plus"></i>  Add');

                jQuery("#total_items").val(numberofarea);

                // jQuery("#company").select2();
                // jQuery("#region").select2();
                jQuery("#product_name").select2();
                jQuery("#service").select2();
                jQuery("#zone").select2();
                jQuery("#city").select2();
                jQuery("#grid").select2();
                jQuery("#franchiseArea").select2();

                jQuery("#supervisor").select2();
                jQuery("#employee").select2();
                jQuery("#supplier").select2();
                jQuery("#username").select2();

                // grand_total_calculation();

                jQuery(".edit_link").show();
                jQuery(".delete_link").show();
            }
        }


        function delete_working_area(current_item) {

            jQuery("#" + current_item).remove();
            var temp_products = areas[current_item];
            console.log(temp_products);

            // jQuery("#product_name option[value=" + temp_products['product_code'] + "]").attr("disabled", false);
            reverse_qty(current_item);
            delete areas[current_item];

            function isEmpty(obj) {

                for (var key in obj) {

                    if (obj.hasOwnProperty(key))
                        return false;
                }
                return true;
            }

            // jQuery("#working_hours_per_day").val(JSON.stringify(areas));
            numberofarea = Object.keys(areas).length;
            jQuery("#working_area_array").val(JSON.stringify(areas));
            jQuery("#total_items").val(numberofarea);


            if (isEmpty(areas)) {
                numberofarea = 0;
            }

        }

        function edit_working_area(current_item) {

            jQuery("#save").attr("style", "display:none");
            jQuery("#first_add_more").html('<i class="fa fa-plus"></i> update');
            jQuery("#cancel_button").show();


            jQuery(".edit_link").hide();
            jQuery(".delete_link").hide();

            global_id_to_edit = current_item;

            var temp_products = areas[current_item];

            edit_product_value = temp_products['company_value'];

            jQuery("#company").select2("destroy");
            jQuery("#product_name").select2("destroy");


            // jQuery('#company option[value="' + temp_products['company_value'] + '"]').prop('selected', true);
            // jQuery('#warehouse option[value="' + temp_products['warehouse'] + '"]').prop('selected', true);


            // jQuery("#region").val(temp_products['region_value']);


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

        jQuery(document).ready(function () {
            // Initialize select2

            jQuery("#order_list").select2();

            jQuery("#zone").select2();
            jQuery("#city").select2();
            jQuery("#grid").select2();
            jQuery("#franchiseArea").select2();

            jQuery("#supervisor").select2();
            jQuery("#employee").select2();
            jQuery("#supplier").select2();
            jQuery("#username").select2();
            jQuery("#service").select2();
            jQuery("#product_name").select2();
            $('#employee_div').show();
            $('#supplier_div').hide();
            {{--var array ={!! $items !!};--}}
            {{--jQuery("#table_body").html("");--}}
            {{--$(array).each(function (counter, value) {--}}
            {{--    var franchiseArea = value.franchise_code + value.franchise_name;--}}
            {{--    areas[counter] = {--}}

            {{--        'product_code': value.swai_pro_code,--}}
            {{--        'product_name': value.swai_pro_name,--}}
            {{--        'service_id': value.swai_service_id,--}}
            {{--        'service_name': value.swai_service_name,--}}
            {{--        'zone_value': value.swai_grid_id,--}}
            {{--        'zone': value.region,--}}
            {{--        'city_value': value.swai_city_id,--}}
            {{--        'city': value.city,--}}
            {{--        'grid_value': value.swai_grid_id,--}}
            {{--        'grid': value.grid,--}}
            {{--        'franchiseArea_value': value.swai_franchise_id,--}}
            {{--        'franchiseArea': value.franchise_name,--}}

            {{--        'supervisor': value.supervisor,--}}
            {{--        'supervisor_value': value.swai_supervisor_id,--}}

            {{--        'username_id': value.swai_username_id,--}}
            {{--        'username': value.username,--}}
            {{--        'qty': value.swai_qty,--}}
            {{--        'rate': value.swai_rate,--}}
            {{--        'amount': value.swai_amount,--}}
            {{--        'start_date': value.swai_start_date,--}}
            {{--        'end_date': value.swai_end_date,--}}
            {{--        'valid_days': value.swai_valid_for_days,--}}

            {{--        'surveyor_type': value.swai_surveyor_type,--}}
            {{--        'employee_value': value.employee_value,--}}
            {{--        'supplier_value': value.supplier_value,--}}
            {{--        'supplier': value.survey,--}}
            {{--        'employee': value.employee,--}}

            {{--    };--}}
            {{--    numberofarea = Object.keys(areas).length;--}}
            {{--    jQuery("#total_items").val(numberofarea);--}}
            {{--  --}}
            {{--    var type = '';--}}
            {{--    if (value.swai_surveyor_type == "employee") {--}}
            {{--        type = value.survey;--}}
            {{--    } else {--}}
            {{--        type = value.account_name;--}}
            {{--    }--}}

            {{--    jQuery("#table_body").append(--}}
            {{--        '<tr id=' + counter + ' class="edit_update">' +--}}
            {{--        '<td class="text-left tbl_txt_8">' + value.swai_pro_name + '</td>' +--}}
            {{--        '<td class="text-left tbl_txt_7">' + value.swai_service_name + '</td>' +--}}
            {{--        '<td class="text-left tbl_txt_5">' + value.region + '</td>' +--}}
            {{--        '<td class="text-left tbl_txt_6">' + value.city + '</td>' +--}}
            {{--        '<td class="text-left tbl_txt_3" >' + value.grid + '</td>' +--}}
            {{--        '<td class="text-left tbl_txt_6" >' + franchiseArea + '</td>' +--}}
            {{--        '<td class="text-left tbl_txt_6" >' + value.swai_surveyor_type + '</td>' +--}}
            {{--        '<td class="text-left tbl_txt_7" >' + value.supervisor + '</td>' +--}}
            {{--        '<td class="text-left tbl_txt_6" >' + type + '</td>' +--}}
            {{--        '<td class="text-left tbl_txt_6" >' + value.username + '</td>' +--}}
            {{--        '<td class="text-left tbl_txt_6" >' + value.swai_qty + '</td>' +--}}
            {{--        '<td class="text-left tbl_txt_8" >' + value.swai_rate + '</td>' +--}}
            {{--        '<td class="text-left tbl_txt_8" >' + value.swai_amount + '</td>' +--}}
            {{--        '<td class="text-left tbl_txt_7" >' + value.swai_start_date + '</td>' +--}}
            {{--        '<td class="text-left tbl_txt_7" >' + value.swai_end_date + '</td>' +--}}
            {{--        '<td class="text-left tbl_txt_5">' + value.swai_valid_for_days + '<div class="edit_update_bx"> <a href="#" class="delete_link btn btn-sm btn-danger" ' +--}}
            {{--        'onclick=delete_working_area(' + counter + ')><i class="fa fa-trash"></i></a></div></td></tr>');--}}

            {{--});--}}

            var order_list_id = {!! $works->swa_company_id !!}
            order_list(order_list_id);
        });

        function reverse_qty(current_item) {

            var temp_products = areas[current_item];
            var qty = temp_products['qty'];

            // var qty = $(this).val();
            var due_qty = $('#dues_qty').val();
            var used_qty = $('#used_qty').val();
            var use_qty = $('#consume_qty').val();
            var remain_qty = $('#remaining_qty').val();
            var total_qty = $('#total_qty').val();
            var rate = $('#rate').val();
            var amount = rate * qty;
            var consume_qty = +use_qty - +qty;
            var remain_qty = +remain_qty + +qty;
            $('#consume_qty').val(consume_qty);
            $('#remaining_qty').val(remain_qty);
            $('#amount').val(amount);

            document.getElementById("consumeTotalQtyView").innerHTML = consume_qty.toFixed(2);
            document.getElementById("remainingTotalQtyView").innerHTML = remain_qty.toFixed(2);
        };
    </script>

    {{--    end working area script--}}

    <script>
        $('#employee_show').click(function () {
            $('#employee_div').show();
            $('#supplier_div').hide();
            jQuery("#supplier").select2("destroy");
            jQuery('#supplier option[value="' + "" + '"]').prop('selected', true);
            jQuery("#supplier").select2();

        });
        $('#vendor').click(function () {
            $('#employee_div').hide();
            $('#supplier_div').show();
            jQuery("#employee").select2("destroy");
            jQuery('#employee option[value="' + "" + '"]').prop('selected', true);
            jQuery("#employee").select2();

        });
    </script>

    <script>
        function order_list(order_list) {
            jQuery.ajax({
                url: "order_list_region",
                data: {order_list: order_list},
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (data) {
                    // console.log(data);
                    // console.log(data.services);
                    var option = "<option value='' disabled selected>Select Region</option>";
                    var option_pro = "<option value='' disabled selected>Select Product</option>";
                    var option_ser = "<option value='' disabled selected>Select Service</option>";

                    $.each(data.regions, function (index, value) {
                        option += "<option value='" + value.id + "' data-zone-id='" + value.id + "'>" + value.name + "</option>";
                    });
                    $.each(data.products, function (index, value) {
                        option_pro += "<option value='" + value.pro_p_code + "' >" + value.pro_title + "</option>";
                    });
                    $.each(data.services, function (index, value) {
                        option_ser += "<option value='" + value.osi_service_code + "' data-qty='" + value.osi_qty + "' data-rate='" + value.osi_rate + "'>" + value.osi_service_name + "</option>";
                    });

                    jQuery("#zone").html(" ");
                    jQuery("#zone").append(option);
                    jQuery("#zone").select2();

                    jQuery("#product_name").html(" ");
                    jQuery("#product_name").append(option_pro);
                    jQuery("#product_name").select2();

                    jQuery("#service").html(" ");
                    jQuery("#service").append(option_ser);
                    jQuery("#service").select2();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        }

        $('#order_list').change(function () {
            var order_list = $(this).val();
            order_list(order_list);
        });

    </script>
    <script>
        $('#employee').change(function () {
            var employee_id = $(this).val();

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_employee_username",
                data: {employee_id: employee_id},
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    var option = "<option value='' disabled selected>Select Username</option>";

                    $.each(data.usernames, function (index, value) {
                        option += "<option value='" + value.srv_id + "' >" + value.srv_name + "</option>";
                    });

                    jQuery("#username").html(" ");
                    jQuery("#username").append(option);
                    jQuery("#username").select2();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });


        $('#supplier').change(function () {
            var supplier_id = $(this).val();

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_supplier_username",
                data: {supplier_id: supplier_id},
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    var option = "<option value='' disabled selected>Select Username</option>";

                    $.each(data.usernames, function (index, value) {
                        option += "<option value='" + value.srv_id + "' >" + value.srv_name + "</option>";
                    });

                    jQuery("#username").html(" ");
                    jQuery("#username").append(option);
                    jQuery("#username").select2();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

    </script>

    <script>
        jQuery("#service").change(function () {

            var order_list = $("#order_list").val();
            var zone = $("#zone").val();
            var zone_id = $("#zone option:selected").attr('data-zone-id');

            var service = $(this).val();
            $('#service option[value="' + service + '"]').prop('selected', true);

            // var parent_code = jQuery("#product_name option:selected").attr('data-parent');
            var name = $("#service option:selected").text();

            var rate = $('option:selected', this).attr('data-rate');
            jQuery("#rate").val(rate);

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_ser_order_qty",
                data: {service: service, order_list: order_list, zone_id: zone_id},
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (data) {
// console.log(data.total_qty);
// console.log(data.total_consume_qty);
                    jQuery("#consume_qty").html(" ");
                    jQuery("#total_qty").html(" ");
                    jQuery("#total_qty").val(data.total_qty);
                    document.getElementById("totalQtyView").innerHTML = data.total_qty;


                    jQuery("#consume_qty").val(data.total_consume_qty);
                    jQuery("#used_qty").val(data.total_consume_qty);
                    var remaining = data.total_qty - data.total_consume_qty;
                    jQuery("#remaining_qty").val(remaining);
                    jQuery("#dues_qty").val(remaining);
                    // jQuery("#rate").val(data.rate);

                    document.getElementById("consumeTotalQtyView").innerHTML = data.total_consume_qty;
                    document.getElementById("remainingTotalQtyView").innerHTML = remaining;
                    calculate_used_qty();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });

        });

    </script>

    <script>
        $('#qty').keyup(function () {
            var qty = $(this).val();
            var due_qty = $('#dues_qty').val();
            var used_qty = $('#used_qty').val();
            var total_qty = $('#total_qty').val();
            var rate = $('#rate').val();
            var amount = rate * qty;
            var consume_qty = +used_qty + +qty;
            var remain_qty = due_qty - qty;
            $('#consume_qty').val(consume_qty);
            $('#remaining_qty').val(remain_qty);
            $('#amount').val(amount);

            document.getElementById("consumeTotalQtyView").innerHTML = consume_qty.toFixed(2);
            document.getElementById("remainingTotalQtyView").innerHTML = remain_qty.toFixed(2);
        });

        jQuery("#rate").keyup(function () {
            var rate = $(this).val();
            var qty = $('#qty').val();
            var amount = rate * qty;
            $('#amount').val(amount);
        });
    </script>

    <script>
        function calculate_used_qty() {

            var service = $('#service').val();
            var get_array = $('#working_area_array').val();
            var total_qty = 0;

            if (get_array != '') {
                var make_array = JSON.parse(get_array);

                // console.log(Object.keys(make_array).length);

                $.each(make_array, function (index, value) {

                    if (value['service_id'] == service) {
                        total_qty = +value['qty'] + +total_qty;
                    }

                });

                var total_quantity = jQuery("#total_qty").val();
                var consume_qty = jQuery("#consume_qty").val();
                var consume_qty = +consume_qty + +total_qty;
                var remaining = total_quantity - consume_qty;
                jQuery("#remaining_qty").val(remaining);
                jQuery("#dues_qty").val(remaining);
                jQuery("#used_qty").val(consume_qty);

                document.getElementById("consumeTotalQtyView").innerHTML = consume_qty;
                document.getElementById("remainingTotalQtyView").innerHTML = remaining;

            }
        }
    </script>
@endsection

