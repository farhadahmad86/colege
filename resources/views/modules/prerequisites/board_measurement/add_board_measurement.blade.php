@extends('extend_index')

@section('content')

    <div class="row">


        <div
            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 border-radius-4 box-shadow mb-30 form_manage">


                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 tabindex="-1" class="text-white get-heading-text">Add Board Measurement</h4>
                        </div>
                        <div class="list_btn">
{{--                            <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('employee_list') }}" role="button">--}}
{{--                                <i class="fa fa-list"></i> view list--}}
{{--                            </a>--}}
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <form action="{{ route('submit_board_measurement') }}" id="f1" onsubmit="return checkForm()" method="post" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <div class="pt-20 bg-white border-radius-4">
                                <div class="tab">
                                    <ul class="nav nav-tabs customtab double_line_tab" role="tablist">
                                        <li class="nav-item">
                                            <a tabindex="1" autofocus class="nav-link active text-blue" data-toggle="tab" href="#cal_with_width" role="tab" aria-selected="true">Pipe Support Calculation With Width</a>
                                        </li>
                                        <li class="nav-item">
                                            <a tabindex="2" class="nav-link text-blue" data-toggle="tab" href="#cal_with_length" role="tab" aria-selected="false">Pipe Support Calculation With Length</a>
                                        </li>
                                        <li class="nav-item">
                                            <a tabindex="3" class="nav-link text-blue" data-toggle="tab" href="#soter" role="tab" aria-selected="false">Angle Inch Soter (Normal)</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="cal_with_width" role="tabpanel">
                                            <div class="pt-20 pb-0">
                                                <div class="row">

                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label class="required">

                                                                Board Type
                                                                <a href="{{ route('departments.create') }}"
                                                                   class="add_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                                                   data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                                    <i class="fa fa-plus"></i>
                                                                </a>
                                                                <a id="refresh_department" class="add_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom"
                                                                   data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                                    <l class="fa fa-refresh"></l>
                                                                </a>
                                                            </label>
                                                            <select tabindex="4" name="board_type" id="board_type" class="inputs_up form-control" data-rule-required="true" data-msg-required="Please
                                                             Select Board Type">
                                                                <option value="">Select Board Type</option>
                                                                @foreach($board_types as $board_type)
                                                                    <option value="{{$board_type->bt_id}}">{{$board_type->bt_board_type}}</option>
                                                                @endforeach
                                                            </select>
                                                            <span id="modular_group_error_msg"
                                                                  class="validate_sign"> </span>
                                                        </div><!-- end input box -->
                                                    </div>

                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label class="">
                                                                Width From</label>
                                                            <input onkeypress="return allow_only_number_and_decimals(this,event);"
                                                                   tabindex="5" type="text" name="width_from" id="width_from" data-rule-required="true" data-msg-required="Please Enter Width From"
                                                                   class="inputs_up form-control"
                                                                   placeholder="Width From">
                                                            <span id="designation_error_msg"
                                                                  class="validate_sign"> </span>
                                                        </div><!-- end input box -->
                                                    </div>

                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label class="">
                                                                Width To</label>
                                                            <input onkeypress="return allow_only_number_and_decimals(this,event);"
                                                                   tabindex="5" type="text" name="width_to" id="width_to" data-rule-required="true" data-msg-required="Please Enter Width To"
                                                                   class="inputs_up form-control"
                                                                   placeholder="Width To">
                                                            <span id="designation_error_msg"
                                                                  class="validate_sign"> </span>
                                                        </div><!-- end input box -->
                                                    </div>

                                                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label class="">
                                                                Pipe Center Support</label>
                                                            <input onkeypress="return allow_only_number_and_decimals(this,event);"
                                                                   tabindex="6" type="text" name="pipe_center_support" id="pipe_center_support" data-rule-required="true" data-msg-required="Please Enter Pipe Center Support"
                                                                   class="inputs_up form-control"
                                                                   placeholder="Pipe Center Support">
                                                            <span id="name_error_msg" class="validate_sign"> </span>
                                                        </div><!-- end input box -->
                                                    </div>

                                                </div>

                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="cal_with_length" role="tabpanel">
                                            <div class="pt-20 pb-0">
                                                <div class="row">

                                                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label class="">
                                                                Length From</label>
                                                            <input onkeypress="return allow_only_number_and_decimals(this,event);"
                                                                   tabindex="5" type="text" name="length_from" id="length_from" data-rule-required="true" data-msg-required="Please Enter Length From"
                                                                   class="inputs_up form-control"
                                                                   placeholder="Length From">
                                                            <span id="designation_error_msg"
                                                                  class="validate_sign"> </span>
                                                        </div><!-- end input box -->
                                                    </div>

                                                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label class="">
                                                                Length To</label>
                                                            <input onkeypress="return allow_only_number_and_decimals(this,event);"
                                                                   tabindex="5" type="text" name="length_to" id="length_to" data-rule-required="true" data-msg-required="Please Enter Length To"
                                                                   class="inputs_up form-control"
                                                                   placeholder="Length From"
                                                                   >
                                                            <span id="designation_error_msg"
                                                                  class="validate_sign"> </span>
                                                        </div><!-- end input box -->
                                                    </div>

                                                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label class="">
                                                                Pipe Center Support For Length</label>
                                                            <input onkeypress="return allow_only_number_and_decimals(this,event);"
                                                                   tabindex="6" type="text" name="pipe_center_support_for_length" id="pipe_center_support_for_length" data-rule-required="true" data-msg-required="Please Enter Pipe Center Support For Length"
                                                                   class="inputs_up form-control"
                                                                   placeholder="Please Enter Pipe Center Support For Length">
                                                            <span id="name_error_msg" class="validate_sign"> </span>
                                                        </div><!-- end input box -->
                                                    </div>

                                                </div>

                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="soter" role="tabpanel">
                                            <div class="pt-20 pb-0">
                                                <div class="row">

                                                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label class="">

                                                                Width From</label>
                                                            <input onkeypress="return allow_only_number_and_decimals(this,event);"
                                                                   tabindex="5" type="text" name="width_from_for_soter" id="width_from_for_soter" data-rule-required="true" data-msg-required="Please Enter Width From"
                                                                   class="inputs_up form-control"
                                                                   placeholder="Width From"
                                                                   >
                                                            <span id="designation_error_msg"
                                                                  class="validate_sign"> </span>
                                                        </div><!-- end input box -->
                                                    </div>

                                                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label class="">

                                                                Width To</label>
                                                            <input onkeypress="return allow_only_number_and_decimals(this,event);"
                                                                   tabindex="5" type="text" name="width_to_for_soter" id="width_to_for_soter" data-rule-required="true" data-msg-required="Please Enter Width From"
                                                                   class="inputs_up form-control"
                                                                   placeholder="Width From"
                                                                   >
                                                            <span id="designation_error_msg"
                                                                  class="validate_sign"> </span>
                                                        </div><!-- end input box -->
                                                    </div>

                                                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <div class="input_bx"><!-- start input box -->
                                                            <label class="">

                                                                Angle Support</label>
                                                            <input onkeypress="return allow_only_number_and_decimals(this,event);"
                                                                   tabindex="6" type="text" name="angle_support" id="angle_support" data-rule-required="true" data-msg-required="Please Enter Angle Support"
                                                                   class="inputs_up form-control"
                                                                   placeholder="Angle Support">
                                                            <span id="name_error_msg" class="validate_sign"> </span>
                                                        </div><!-- end input box -->
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    {{--                                        <button tabindex="-1" type="reset" name="cancel" id="cancel" class="cancel_button form-control">--}}
                                    {{--                                            <i class="fa fa-eraser"></i> Cancel--}}
                                    {{--                                        </button>--}}
                                    <button tabindex="48" type="submit" name="save" id="save" class="save_button form-control mr-5"
                                    >
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
    {{--    required input validation --}}
    <script type="text/javascript">



        function checkForm() {
            let board_type = document.getElementById("user_department_id"),
                // user_type = document.getElementById("user_type"),
                // role = document.getElementById("role"),
                // designation = document.getElementById("designation"),
                // name = document.getElementById("name"),
                // fname = document.getElementById("fname"),
                // mobile = document.getElementById("mobile"),
                // parent_head = document.getElementById("parent_head"),
                // basic_salary = document.getElementById("basic_salary"),
                // hour_per_day = document.getElementById("hour_per_day"),
                // group = document.getElementById("group"),
                // product_reporting_group = document.getElementById("product_reporting_group"),
                // modular_group = document.getElementById("modular_group"),
                // username = document.getElementById("username"),
                // email = document.getElementById("email"),
                // email_confirmation = document.getElementById("email_confirmation"),
                validateInputIdArray = [
                    board_type.id,
                    // user_type.id,
                    // role.id,
                    // designation.id,
                    // name.id,
                    // fname.id,
                    // mobile.id,
                    // parent_head.id,
                    // basic_salary.id,
                    // hour_per_day.id,
                    // group.id,
                    // product_reporting_group.id,
                    // modular_group.id,
                    // username.id,
                    // email.id,
                    // email_confirmation.id,
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

        jQuery("#refresh_department").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_department",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#user_department_id").html(" ");
                    jQuery("#user_department_id").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

    </script>

    <script type="text/javascript">

        jQuery('#board_type').select2();
    </script>

    <script type="text/javascript">

        jQuery("#make_salary_account").change(function () {

            if ($(this).is(':checked')) {
                $(".salary_div *").prop('disabled', false);
            } else {
                $(".salary_div *").prop('disabled', true);
                $('#make_loan_account').prop("checked", false);
            }
        });

        jQuery("#make_credentials").change(function () {

            if ($(this).is(':checked')) {
                $(".credentials_div *").prop('disabled', false);
            } else {
                $(".credentials_div *").prop('disabled', true);
            }
        });

    </script>

@endsection
