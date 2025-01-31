@extends('extend_index')

@section('content')

    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">


                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Designer Working Area</h4>
                        </div>
                        <div class="list_btn">
                            <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('designer_working_area_list') }}" role="button">
                                <i class="fa fa-list"></i> view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->


                <div id="invoice_con" class="gnrl-mrgn-pdng invoice_con for_voucher"><!-- invoice container start -->
                    <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate"><!-- invoice box start -->

                        <form id="f1" action="{{ route('submit_designer_working_area') }}" method="post" onsubmit="return checkForm()">
                            @csrf

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
                                                                {{--                                                                <a onclick="fetchCompanies($('select#company'));"--}}
                                                                {{--                                                                   class="col_short_btn">--}}
                                                                {{--                                                                    <l class="fa fa-refresh"></l>--}}
                                                                {{--                                                                </a>--}}
                                                            </div><!-- invoice column short end -->
                                                            <select tabindex="2" name="company" id="company"
                                                                    data-fetch-url="{{ route('api.companies.options') }}"
                                                                    data-rule-required="true" data-msg-required="Please Choose Company"
                                                                    class="inputs_up form-control auto-select company_dropdown"
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

                                                <div class="invoice_col basis_col_  20">
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
{{--                                                                @foreach($projects as $project)--}}
{{--                                                                    <option value="{{$project->proj_id}}">{{$project->proj_project_name}}</option>--}}
{{--                                                                @endforeach--}}
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
                                                            <select tabindex="3" name="region" id="region"
                                                                    class="inputs_up form-control"
                                                                    data-rule-required="true" data-msg-required="Please Choose Region"
                                                                    >
                                                                <option value="" selected disabled>
                                                                    Select Company
                                                                    First
                                                                </option>
                                                            </select>

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
                                                            <select tabindex="4" name="zone" id="zone"
                                                                    class="inputs_up form-control @error('zone') is-invalid @enderror"
                                                                    >
                                                                <option value="" selected disabled>
                                                                    Select Region First
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
                                                            <select tabindex="5" name="city" id="city"
                                                                    class="inputs_up form-control @error('city') is-invalid @enderror"
                                                                    >
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
                                                            <select tabindex="6" name="grid" id="grid"
                                                                    class="inputs_up form-control @error('grid') is-invalid @enderror"
                                                                    >
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
                                                            <select tabindex="7" name="franchiseArea"
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

                                                <div class="invoice_col basis_col_10">
                                                    <!-- invoice column start -->
                                                    <div class="invoice_col_bx">
                                                        <!-- invoice column box start -->
                                                        <div class="required invoice_col_ttl">
                                                            <!-- invoice column title start -->
                                                            Designer
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <select tabindex="8" name="designer"
                                                                    id="designer"
                                                                    class="inputs_up form-control"
                                                                    >
                                                                <option value="" selected disabled>
                                                                    Select Designer
                                                                </option>
                                                                @foreach($supervisors_designers as $designer)
                                                                    <option value="{{ $designer->user_id }}">{{ $designer->user_name }}</option>
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

                                                            Supervisor
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <select tabindex="9" name="supervisor"
                                                                    id="supervisor"
                                                                    class="inputs_up form-control"
                                                                    >
                                                                <option value="" selected disabled>
                                                                    Select Supervisor</option>
                                                                @foreach($supervisors_designers as $supervisor)
                                                                    <option value="{{ $supervisor->user_id }}">{{ $supervisor->user_name }}  </option>
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

                                                            Start Date
                                                        </div><!-- invoice column title end -->
                                                        <div class="invoice_col_input">
                                                            <!-- invoice column input start -->

                                                            <div class="invoice_col_short">
                                                                <!-- invoice column short start -->

                                                            </div><!-- invoice column short end -->
                                                            <input tabindex="10" type="text" name="start_date" id="start_date" class="inputs_up form-control datepicker1" autocomplete="off" value=""
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
                                                            <input tabindex="11" type="text" name="end_date" id="end_date" class="inputs_up form-control datepicker1" autocomplete="off" value="" placeholder="End
                                                            Date
                                                             ...
                                                            ...">
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
                                                                <button tabindex="12" id="first_add_more"
                                                                        class="invoice_frm_btn"
                                                                        onclick="add_working_area()"
                                                                        type="button">
                                                                    <i class="fa fa-plus"></i> Add
                                                                </button>
                                                            </div>
                                                            <div
                                                                class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                                <button tabindex="-1" style="display: none;"
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
                                                                    <table tabindex="-1" class="table gnrl-mrgn-pdng"
                                                                           id="category_dynamic_table">
                                                                        <thead>
                                                                        <tr>
                                                                            <th class="text-center tbl_txt_10">
                                                                                Company
                                                                            </th>
                                                                            <th class="text-center tbl_txt_10">
                                                                                Region
                                                                            </th>

                                                                            <th class="text-center tbl_txt_10">
                                                                                Zone
                                                                            </th>
                                                                            <th class="text-center tbl_txt_10">
                                                                                City
                                                                            </th>
                                                                            <th class="text-center tbl_txt_10">
                                                                                Grid
                                                                            </th>
                                                                            <th class="text-center tbl_txt_10">
                                                                                Franchise
                                                                            </th>
                                                                            <th class="text-center tbl_txt_10">
                                                                                Designer
                                                                            </th>
                                                                            <th class="text-center tbl_txt_10">
                                                                                Supervisor
                                                                            </th>
                                                                            <th class="text-center tbl_txt_10">
                                                                                Start Date
                                                                            </th>
                                                                            <th class="text-center tbl_txt_10">
                                                                                End Date
                                                                            </th>
                                                                        </tr>
                                                                        </thead>

                                                                        <tbody id="table_body">
                                                                        <tr>
                                                                            <td colspan="10"
                                                                                align="center">
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
                                                            <button tabindex="13" type="submit" name="save" id="save" class="invoice_frm_btn">
                                                                <i class="fa fa-floppy-o"></i> Save
                                                            </button>
                                                        </div>
                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->

                                            </div><!-- invoice row end -->
                                        </div><!-- invoice content end -->
                                    </div><!-- invoice scroll box end -->


                                    <input type="hidden" name="working_area_array"
                                           id="working_area_array">

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

        // jQuery("#project").change(function() {
        //     var project = $(this).find(':selected').val();
        //
        //     jQuery.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //
        //     jQuery.ajax({
        //         url: "get_company",
        //         data:{project: project},
        //         type: "GET",
        //         cache:false,
        //         dataType: 'json',
        //         success:function(data){
        //             console.log(data);
        //             console.log(data.get_company);
        //             jQuery("#company").html(" ");
        //             jQuery("#company").append(data.get_company);
        //         },
        //         error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
        //             alert(errorThrown);}
        //     });
        // });
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

            var company = document.getElementById("company").value;
            var regions = document.getElementById("region").value;

            var region_value = $('#region').find(':selected').data('region-id');

            var zones = document.getElementById("zone").value;
            var zone_value = $('#zone').find(':selected').data('zone-id');
            var city_value = document.getElementById("city").value;
            var grids = document.getElementById("grid").value;
            var grid_value = $('#grid').find(':selected').data('grid-id');
            var franchiseAreas = document.getElementById("franchiseArea").value;
            var franchiseArea_value = $('#franchiseArea').find(':selected').data('franchise-area-id');

            var designer_value = document.getElementById("designer").value;
            var supervisor_value = document.getElementById("supervisor").value;
            var start_date = document.getElementById("start_date").value;
            var end_date = document.getElementById("end_date").value;

            var flag_submit1 = true;
            var focus_once1 = 0;

            if (company == "") {

                if (focus_once1 == 0) {
                    jQuery("#company").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (regions == "") {

                if (focus_once1 == 0) {
                    jQuery("#region").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }

            if (zones == "") {

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

            if (designer_value == "") {

                if (focus_once1 == 0) {
                    jQuery("#designer").focus();
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
                jQuery("#designer").select2("destroy");
                jQuery("#supervisor").select2("destroy");
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
                var designer = jQuery("#designer option:selected").text();
                var supervisor = jQuery("#supervisor option:selected").text();

                numberofarea = Object.keys(areas).length;

                if (numberofarea == 0) {
                    jQuery("#table_body").html("");
                }

                areas[counter] = {

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
                    'designer': designer,
                    'designer_value': designer_value,
                    'supervisor': supervisor,
                    'supervisor_value': supervisor_value,
                    'start_date': start_date,
                    'end_date': end_date,
                };
                numberofarea = Object.keys(areas).length;
                jQuery("#total_items").val(numberofarea);
                // <a class="edit_link btn btn-sm btn-success" href="#" onclick=edit_working_area(' + counter + ')><i class="fa fa-edit"></i></a>
                jQuery("#table_body").append(
                    '<tr id=' + counter + ' class="edit_update"><td class="text-left tbl_txt_10">' + company + '</td><td class="text-left tbl_txt_10">' + region + '</td><td class="text-left ' +
                    'tbl_txt_10">' + zone + '</td><td class="text-left tbl_txt_10">' + city + '</td><td class="text-left tbl_txt_10" >' + grid + '</td><td class="text-left tbl_txt_10" >' +
                    franchiseArea + '</td><td class="text-left tbl_txt_10" >' + designer + '</td><td class="text-left tbl_txt_10" >' + supervisor + '</td><td class="text-left tbl_txt_10" >' + start_date + '</td><td class="text-left tbl_txt_10">' + end_date + '<div class="edit_update_bx"> <a href="#" ' +
                    'class="delete_link btn btn-sm btn-danger" onclick=delete_working_area(' + counter + ')><i class="fa fa-trash"></i></a></div></td></tr>');

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

                jQuery("#start_date").val("");
                jQuery("#end_date").val("");

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
                jQuery("#designer").select2();
                jQuery("#supervisor").select2();
                // jQuery("#warehouse").select2();

                // grand_total_calculation();

                jQuery(".edit_link").show();
                jQuery(".delete_link").show();
            }
        }


        function delete_working_area(current_item) {

            jQuery("#" + current_item).remove();
            var temp_products = areas[current_item];
            // jQuery("#company option[value=" + temp_products['company'] + "]").attr("disabled", false);
            // jQuery("#product_name option[value=" + temp_products['product_code'] + "]").attr("disabled", false);

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

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#project").select2();
            jQuery("#company").select2();
            jQuery("#region").select2();
            jQuery("#zone").select2();
            jQuery("#city").select2();
            jQuery("#grid").select2();
            jQuery("#franchiseArea").select2();
            jQuery("#designer").select2();
            jQuery("#supervisor").select2();
        });
    </script>

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

@endsection

