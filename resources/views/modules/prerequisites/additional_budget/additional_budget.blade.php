@extends('extend_index')

@section('content')

    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">


                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 tabindex="-1" class="text-white get-heading-text">Additional Budget</h4>
                        </div>
                        <div class="list_btn">
                            <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('purchase_order_list') }}" role="button">
                                <i class="fa fa-list"></i> view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->


                <div id="invoice_con" class="gnrl-mrgn-pdng invoice_con for_voucher"><!-- invoice container start -->
                    <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate"><!-- invoice box start -->

                        <form name="f1" class="f1" id="f1" action="{{ route('submit_additional_amount') }}"
                              onsubmit="return checkForm()" method="post" autocomplete="off">

                            {{--                        <form name="f1" class="f1" id="f1" action="{{ route('submit_purchase_order') }}" method="post" onsubmit="return checkForm()">--}}
                            @csrf

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
                                                        Company
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <select tabindex="2" name="company"
                                                                class="inputs_up form-control js-example-basic-multiple user-select"
                                                                data-rule-required="true" data-msg-required="Please Enter Party"
                                                                id="company">
                                                            <option value="0">Select Party</option>
                                                            @foreach($companies as $account)
                                                                <option
                                                                    value="{{$account->account_uid}}"
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
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->
                                                        Project
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <select tabindex="2" name="project"
                                                                class="inputs_up form-control js-example-basic-multiple user-select"
                                                                data-rule-required="true" data-msg-required="Please Enter Project"
                                                                id="project">
                                                            <option value="0">Select Project</option>

                                                        </select>

                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->


                                        </div><!-- invoice row end -->

                                        <div class="invoice_row">
                                            <div class="invoice_col basis_col_13"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <label class="invoice_col_ttl"><!-- invoice column title start -->
                                                        Reserve Amount
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
                                                        Additional Amount
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
                                                        Remaining Reserve Amount
                                                    </label><!-- invoice column title end -->
                                                    <div class="invoice_col_txt"><!-- invoice column input start -->
                                                        <h5 class="grandTotalFont" id="remainingTotalAmountView">
                                                            0
                                                        </h5>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                                <span style="color: red" id="cal_remain"></span>
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_10"><!-- invoice column start -->
                                                <div class="invoice_col_bx"><!-- invoice column box start -->
                                                    <label class="invoice_col_ttl"><!-- invoice column title start -->
                                                        Due %
                                                    </label><!-- invoice column title end -->
                                                    <div class="invoice_col_txt"><!-- invoice column input start -->
                                                        <h5 class="grandTotalFont" id="remaining_pec">
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
                                                    <div class=" invoice_col_ttl">
                                                        <!-- invoice column title start -->

                                                        Reserve Total
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input">
                                                        <!-- invoice column input start -->
                                                        <input type="text" name="grand_total"
                                                               class="inputs_up form-control"
                                                               id="grand_total" placeholder="0.00" readonly>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_13" hidden>
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->

                                                        Additional Amount
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

                                            <div class="invoice_col basis_col_13" hidden>
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
                                                        <input type="text" name="remaining_amount"
                                                               class="inputs_up form-control"
                                                               id="remaining_amount"
                                                               placeholder="0.00"
                                                               readonly>

                                                        <input tabindex="4" type="text" name="cal_remaining_amount"
                                                               class="inputs_up form-control"
                                                               id="cal_remaining_amount"
                                                               placeholder="0.00"
                                                               readonly>
                                                    </div><!-- invoice column input end -->
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                            <div class="invoice_col basis_col_13">
                                                <!-- invoice column start -->
                                                <div class="invoice_col_bx">
                                                    <!-- invoice column box start -->
                                                    <div class="required invoice_col_ttl">
                                                        <!-- invoice column title start -->

                                                        Assign Amount
                                                    </div><!-- invoice column title end -->
                                                    <div class="invoice_col_input ">
                                                        <!-- invoice column input start -->
                                                        <div class="invoice_col_short">
                                                            <!-- invoice column short start -->

                                                        </div><!-- invoice column short end -->
                                                        <input type="text" name="additional_amount"
                                                               class="inputs_up form-control"
                                                               id="additional_amount"
                                                               placeholder="0.00"
                                                        >

                                                    </div><!-- invoice column box end -->
                                                </div><!-- invoice column end -->


                                            </div>

                                        </div><!-- invoice content end -->

                                        <div class="invoice_row"><!-- invoice row start -->

                                            <div class="invoice_col basis_col_100"><!-- invoice column start -->
                                                <div class="invoice_col_txt with_cntr_jstfy for_voucher_btns"><!-- invoice column box start -->
                                                    <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                        <button tabindex="21" type="submit" name="save" id="save" class="invoice_frm_btn">
                                                            <i class="fa fa-floppy-o"></i> Save
                                                        </button>
                                                    </div>
                                                </div><!-- invoice column box end -->
                                            </div><!-- invoice column end -->

                                        </div><!-- invoice row end -->
                                    </div><!-- invoice scroll box end -->
                                </div>

                            </div>
                        </form>
                        <

                    </div><!-- invoice box end -->
                </div><!-- invoice container end -->

            </div> <!-- white column form ends here -->

        </div><!-- col end -->


    </div><!-- row end -->




@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let project = document.getElementById("project"),
                company = document.getElementById("company"),
                assign_amount = document.getElementById("assign_amount"),

                validateInputIdArray = [
                    project.id,
                    company.id,
                    assign_amount.id,

                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    {{--    @if (Session::get('cr_id'))--}}
    {{--        <script>--}}
    {{--            jQuery("#table_body").html("");--}}

    {{--            var id = '{{ Session::get("cr_id") }}';--}}
    {{--            $(".modal-body").load('{{ url('cash_receipt_items_view_details/view/') }}/'+id, function () {--}}
    {{--                // jQuery(".pre-loader").fadeToggle("medium");--}}
    {{--                $("#myModal").modal({show:true});--}}
    {{--            });--}}
    {{--        </script>--}}
    {{--    @endif--}}
    <script>
        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                $("#first_add_more").click();
                // event.preventDefault();
                return false;
            }
        });
    </script>
    <script type="text/javascript">

        // Initialize select2
        jQuery("#company").select2();
        jQuery("#party").select2();
    </script>
    {{--///////////////////////// Start Sale Javascript ////////////////////////////////////--}}

    {{--//////////////////////// End Sale Javascript //////////////////////////////////////--}}
    <script>
        jQuery(document).ready(function () {
            // Initialize select2

            jQuery("#project").select2();

            jQuery("#company").select2();

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
                        option += "<option value='" + value.proj_id + "' data-grand_total='" + value.proj_grand_total + "' data-reserve_total='" + value.proj_reserve_amount + "'>" + value
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

        jQuery("#project").change(function () {
            var project = $(this).find(':selected').val();
            var reserved_amount = $('option:selected', this).attr('data-reserve_total');
            $('#grand_total').val(reserved_amount);
            document.getElementById("projectTotalAmountView").innerHTML = reserved_amount;


            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "get_additional_amount",
                data: {project: project},
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (data) {
                    console.log(data);

                    var additional_total = 0;
                    $.each(data.calculations, function (index, value) {
                        additional_total = +additional_total + +value.cal_additional_amount;
                    });


                    jQuery("#remaining_amount").html(" ");
                    jQuery("#consume_amount").html(" ");
                    jQuery("#consume_amount").val(additional_total);
                    var remaining_amount = reserved_amount - additional_total;
                    jQuery("#remaining_amount").val(remaining_amount);
                    jQuery("#cal_remaining_amount").val(remaining_amount);
                    document.getElementById("consumeTotalAmountView").innerHTML = additional_total.toFixed(2);
                    document.getElementById("remainingTotalAmountView").innerHTML = remaining_amount.toFixed(2);
                    var remaining_pec = remaining_amount / reserved_amount * 100;
                    document.getElementById("remaining_pec").innerHTML = remaining_pec.toFixed(2);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });
    </script>

    <script>
        $('#additional_amount').keyup(function () {
            var additional_amount = $(this).val();
            var grand_total = $('#grand_total').val();
            var consume_amount = $('#consume_amount').val();
            var remain_amount = grand_total - consume_amount;
            if (additional_amount >= remain_amount) {
                $('#additional_amount').val('');
            }
        });
    </script>

@endsection

