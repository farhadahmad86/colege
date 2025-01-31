
@extends('extend_index')

@section('content')

    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text">{{$title}}</h4>
                    </div>
                    <div class="list_btn">
                        @if($expense == 4)
                            <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('expense_account_list') }}" role="button">
                                <i class="fa fa-list"></i> view list
                            </a>
                        @else
                            <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('account_list') }}" role="button">
                                <i class="fa fa-list"></i> view list
                            </a>
                        @endif
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

                        <form action="{{ route('submit_account_excel') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            Select Excel File
                                        </label>
                                        <input tabindex="100" type="file" name="add_other_account_excel" id="add_other_account_excel" class="inputs_up form-control-file form-control height-auto"
                                                accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                    </div><!-- end input box -->
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    <a href="{{ url('public/sample/expense_account/add_expense_account_pattern.xlsx') }}" tabindex="-1" type="reset" class="cancel_button btn btn-sm btn-info">
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

            <form action="{{ route('submit_account') }}" class="mx-auto col-lg-7 col-md-7 col-sm-12 col-xs-12" id="f1" name="f1" class="f1" method="post" onsubmit="return checkForm()">
                @csrf
                <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="required">
                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                    data-placement="bottom" data-html="true"
                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.control_account.description')}}</p>
                                                    <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.control_account.benefits')}}</p>
                                                    <h6>Example</h6><p>{{config('fields_info.about_form_fields.control_account.example')}}</p>
                                                    <h6>Validation</h6><p>{{config('fields_info.about_form_fields.control_account.validations') }}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Control Account</label>
                                            <select tabindex="1" autofocus name="first_head_code" id="first_head_code" data-rule-required="true" data-msg-required="Please Enter Control Account" class="inputs_up form-control" {{ $expense == 4 ? 'disabled' : '' }}>
                                                <option value="">Select Control Account</option>
                                                @foreach($heads as $head)
                                                    <option value="{{$head->coa_code}}" {{ $head->coa_code == $expense ? 'selected="selected"' : '' }} {{ $head->coa_code == old('first_head_code') ? 'selected="selected"' : '' }}>{{$head->coa_head_name}}</option>
                                                @endforeach
                                            </select>
                                            <span id="demo1" class="validate_sign"> </span>
                                        </div><!-- end input box -->
                                    </div>

                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="required">
                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                    data-placement="bottom" data-html="true"
                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.parent_account.description')}}</p>
                                                <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.parent_account.benefits')}}</p>
                                                <h6>Example</h6><p>{{config('fields_info.about_form_fields.parent_account.example')}}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Parent Account
                                                    {{--                                                        <a href="{{ route('add_second_level_chart_of_account') }}" class="add_btn" target="_blank">--}}
                                                    {{--                                                            <i class="fa fa-plus"></i> Add--}}
                                                    {{--                                                        </a>--}}
                                                    {{--                                                        <a id="refresh_second_head" class="add_btn">--}}
                                                    {{--                                                            <l class="fa fa-refresh"></l> Refresh--}}
                                                    {{--                                                        </a>--}}
                                            </label>
                                            <select tabindex="2" name="second_head_code" id="second_head_code" class="inputs_up form-control"  data-rule-required="true" data-msg-required="Please Enter Parent Account">
                                                <option value="">Select Parent Account</option>
                                            </select>
                                            <span id="demo2" class="validate_sign"> </span>
                                        </div><!-- end input box -->
                                    </div>

                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="required">
                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                    data-placement="bottom" data-html="true"
                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.child_account.description')}}</p>
                                                <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.child_account.benefits')}}</p>
                                                <h6>Example</h6><p>{{config('fields_info.about_form_fields.child_account.example')}}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Child Account
                                                <a href="{{ route('add_third_level_chart_of_account') }}" class="add_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                                <a id="refresh_third_head" class="add_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                    <l class="fa fa-refresh"></l>
                                                </a>
                                            </label>
                                            <select tabindex="3" name="head_code" id="head_code" class="inputs_up form-control"  data-rule-required="true" data-msg-required="Please Enter Chlid Account" onchange="check_name()">
                                                <option value="">Select Child Account</option>
                                            </select>
                                            <span id="demo3" class="validate_sign"> </span>
                                        </div><!-- end input box -->
                                    </div>

                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="required">
                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                    data-placement="bottom" data-html="true"
                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.account_registration.reporting_group.account_viewing_group_name.description')}}</p>
                                                    <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.account_registration.reporting_group.account_viewing_group_name.benefits')}}</p>
                                                    <h6>Example</h6><p>{{config('fields_info.about_form_fields.account_registration.reporting_group.account_viewing_group_name.example')}}</p>
                                                    <h6>Validation</h6><p>{{config('fields_info.about_form_fields.account_registration.reporting_group.account_viewing_group_name.validations')}}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Account Ledger Access Group
                                                <a href="{{ route('add_account_group') }}" class="add_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                                <a id="refresh_group" class="add_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                    <l class="fa fa-refresh"></l>
                                                </a>
                                            </label>
                                            <select tabindex="4" name="group" id="group" class="inputs_up form-control"  data-rule-required="true" data-msg-required="Please Enter Account Ledger Access Group">
                                                <option value="">Select Account Ledger Access Group</option>
                                                @foreach($groups as $group)
                                                    <option value="{{$group->ag_id}}" {{ $group->ag_id == old('group') ? 'selected="selected"' : '' }}>{{$group->ag_title}}</option>
                                                @endforeach
                                            </select>
                                            <span id="demo7" class="validate_sign"> </span>
                                        </div><!-- end input box -->
                                    </div>

                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="required">
                                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                    data-placement="bottom" data-html="true"
                                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.account_registration.expense_account.account_legder.description')}}</p>
                                                    <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.account_registration.expense_account.account_legder.benefits')}}</p>
                                                    <h6>Example</h6><p>{{config('fields_info.about_form_fields.account_registration.expense_account.account_legder.example')}}</p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Account Legder</label>
                                            <input tabindex="5" type="text" name="account_name" id="account_name" class="inputs_up form-control" data-rule-required="true" data-msg-required="Please Enter Account Ledger" placeholder="Account Legder" autocomplete="off"
                                                    value="{{old('account_name')}}">
                                            <input type="hidden" name="coa_form" value="1">
                                            <span id="demo4" class="validate_sign"> </span>
                                        </div><!-- end input box -->
                                    </div>


                                    @if($expense == 4)
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" hidden>
                                            <div class="input_bx"><!-- start input box -->
                                                <label>Balance</label>
                                                <input tabindex="-1" type="number" name="opening_balance" id="opening_balance" class="inputs_up cnic form-control" placeholder="Balance" step="any"
                                                        autocomplete="off">
                                                <span id="demo5" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>
                                    @else

                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" id="opening_balance_div" hidden>
                                            <div class="input_bx"><!-- start input box -->
                                                <label>Balance</label>
                                                <input tabindex="-1" type="number" name="opening_balance" id="opening_balance" class="inputs_up cnic form-control" placeholder="Balance" step="any"
                                                        autocomplete="off">
                                                <span id="demo5" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>
                                    @endif


                                    {{--                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">--}}
                                    {{--                                                <div class="input_bx"><!-- start input box -->--}}
                                    {{--                                                    <label>Balance</label>--}}
                                    {{--                                                    <input tabindex="-1" type="number" name="opening_balance" id="opening_balance" class="inputs_up cnic form-control" placeholder="Balance" step="any" autocomplete="off">--}}
                                    {{--                                                    <span id="demo5" class="validate_sign"> </span>--}}
                                    {{--                                                </div><!-- end input box -->--}}
                                    {{--                                            </div>--}}
                                </div>

                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="row">


                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="">
                                                <a
                                                    data-container="body" data-toggle="popover" data-trigger="hover"
                                                    data-placement="bottom" data-html="true" data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p><h6>Benefit</h6><p>{{
                                                        config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p><h6>Example</h6><p>{{
                                                        config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                Remarks</label>
                                            <textarea tabindex="6" name="remarks" id="remarks" style="height: 235px;" class="inputs_up remarks form-control" placeholder="Remarks">{{old('remarks')}}</textarea>
                                            <span id="demo6" class="validate_sign"> </span>
                                        </div><!-- end input box -->
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                <button tabindex="7" type="reset" name="cancel" id="cancel" class="cancel_button btn btn-sm btn-info">
                                    <i class="fa fa-eraser"></i> Cancel
                                </button>
                                <button tabindex="8" type="button" name="save" id="save" class="save_button btn btn-sm btn-success">
                                    <i class="fa fa-floppy-o"></i> Save
                                </button>
                            </div>
                        </div>
            </form>

        </div>
    </div><!-- row end -->

@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let first_head_code = document.getElementById("first_head_code"),
                second_head_code = document.getElementById("second_head_code"),
                head_code = document.getElementById("head_code"),
                group = document.getElementById("group"),
                account_name = document.getElementById("account_name");
            validateInputIdArray = [
                first_head_code.id,
                second_head_code.id,
                head_code.id,
                group.id,
                account_name.id,
            ];
            // return validateInventoryInputs(validateInputIdArray);
            var check = validateInventoryInputs(validateInputIdArray);
            if (check == true) {
                let remarks = document.getElementById("remarks").value;

                jQuery(".pre-loader").fadeToggle("medium");

                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{route('submit_account')}}",
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    data: {
                        'first_head_code': first_head_code.value,
                        'second_head_code': second_head_code.value,
                        'head_code': head_code.value,
                        'group': group.value,
                        'account_name': account_name.value,
                        'remarks': remarks,
                    },

                    success: function (data) {
                        console.log(data);
                        console.log(data.message);
                        if(data.already_exist != null){
                            swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Already Exist Account Name Please Try Another Name',
                                showCancelButton: false,
                                confirmButtonClass: 'btn btn-success',
                                timer: 4000
                            });

                        }else{
                            $('#account_name').val('');
                            $('#remarks').val('');

                            swal.fire({
                                title: 'Successfully Saved'+'  '+data.name,
                                text: false,
                                type: 'success',
                                showCancelButton: false,
                                confirmButtonClass: 'btn btn-success',
                                timer: 4000
                            });
                        }

                        jQuery(".pre-loader").fadeToggle("medium");
                    },
                    error: function error(xhr, textStatus, errorThrown, jqXHR) {
                        console.log(xhr.responseText, textStatus, errorThrown, jqXHR);
                        console.log('ajax company error');
                    },
                    error: function () {
                        alert('error handling here');
                    }
                });
            } else {
                return false;
            }
        }
    </script>
    {{-- end of required input validation --}}
    <script>
        $("#save").click(function () {
            checkForm();
        });
    </script>
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

<script>

    $(window).keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    jQuery("#refresh_second_head").click(function() {
        var dropDown = document.getElementById('first_head_code');
        var first_head_code = dropDown.options[dropDown.selectedIndex].value;
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url: "refresh_second_head",
            data:{first_head_code:first_head_code},
            type: "POST",
            cache:false,
            dataType: 'json',

            success:function(data){

                jQuery("#second_head_code").html(" ");
                jQuery("#second_head_code").append(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
            }
        });
    });

    jQuery("#refresh_third_head").click(function() {
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        var second_head_id = $('#second_head_code option:selected').val();
        jQuery.ajax({
            url: "refresh_third_head",
            data:{},
            type: "POST",
            cache:false,
            dataType: 'json',
            data: {
                second_head_id: second_head_id,
            },
            success:function(data){

                jQuery("#head_code").html(" ");
                jQuery("#head_code").append(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // alert(jqXHR.responseText);
                // alert(errorThrown);
            }
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
</script>
    <script>

        $('.number').on('keypress keyup blur keydown', function () {
            var currentInput = $(this).val();
            var fixedInput = currentInput.replace(/[A-Za-z!@#$%^&*()]/g, '');
            $(this).val(fixedInput);
        });

        jQuery("#first_head_code").change(function () {

            var dropDown = document.getElementById('first_head_code');
            var first_head_code = dropDown.options[dropDown.selectedIndex].value;

            if (first_head_code == 4) {

                $('#opening_balance').val('');
                $('#opening_balance_div').hide();
            }else{
                $('#opening_balance_div').show();
            }

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_account_heads",
                data: {first_head_code: first_head_code},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#second_head_code").html("");
                    jQuery("#second_head_code").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);
                }
            });
        });


        jQuery("#second_head_code").change(function () {

            var dropDown = document.getElementById('second_head_code');
            var second_head_code = dropDown.options[dropDown.selectedIndex].value;

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_account_heads",
                data: {second_head_code: second_head_code},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#head_code").html("");
                    jQuery("#head_code").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);
                }
            });
        });

    </script>

    <script>

        // jQuery("#account_name").blur(function () {
        //
        //     alert(1);
        //     check_name();
        // });
        var check = "true";

        function check_name() {

            var account_name = document.getElementById("account_name").value;
            var head_code = document.getElementById("head_code").value;

            if (account_name != '' && head_code != '') {
                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });

                jQuery.ajax({

                    url: "check_name",
                    data: {
                        account_name: account_name,
                        head_code: head_code
                    },
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {

                        // alert(data);

                        if (data.trim() == "yes") {
                            check = "false";

                            document.getElementById("demo4").innerHTML = "Choose Another Name";
                            jQuery("#account_name").focus();

                        } else {
                            document.getElementById("demo4").innerHTML = "";
                            check = "true";
                            // return check;
                        }
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        check = "false";
                        // return check;
                    }
                });
                return check;
            } else {
                return check;
            }


        }

    </script>

    <script type="text/javascript">

        function validate_form() {


            var first_head_code = document.getElementById("first_head_code").value;
            var second_head_code = document.getElementById("second_head_code").value;
            var head_code = document.getElementById("head_code").value;
            var group = document.getElementById("group").value;
            var account_name = document.getElementById("account_name").value;
            var opening_balance = document.getElementById("opening_balance").value;

            var flag_submit = true;
            var focus_once = 0;


            // if (first_head_code.trim() == "") {
            //     document.getElementById("demo1").innerHTML = "Required";
            //     if (focus_once == 0) {
            //         jQuery("#first_head_code").focus();
            //         focus_once = 1;
            //     }
            //     flag_submit = false;
            // } else {
            //     document.getElementById("demo1").innerHTML = "";
            // }
            //
            // if (second_head_code.trim() == "") {
            //     document.getElementById("demo2").innerHTML = "Required";
            //     if (focus_once == 0) {
            //         jQuery("#second_head_code").focus();
            //         focus_once = 1;
            //     }
            //     flag_submit = false;
            // } else {
            //     document.getElementById("demo2").innerHTML = "";
            // }
            //
            //
            // if (head_code.trim() == "") {
            //     document.getElementById("demo3").innerHTML = "Required";
            //     if (focus_once == 0) {
            //         jQuery("#head_code").focus();
            //         focus_once = 1;
            //     }
            //     flag_submit = false;
            // } else {
            //     document.getElementById("demo3").innerHTML = "";
            // }
            //
            // if (group.trim() == "") {
            //     document.getElementById("demo7").innerHTML = "Required";
            //     if (focus_once == 0) {
            //         jQuery("#group").focus();
            //         focus_once = 1;
            //     }
            //     flag_submit = false;
            // } else {
            //     document.getElementById("demo7").innerHTML = "";
            // }
            //
            // if (account_name.trim() == "") {
            //     document.getElementById("demo4").innerHTML = "Required";
            //     if (focus_once == 0) {
            //         jQuery("#account_name").focus();
            //         focus_once = 1;
            //     }
            //
            //     flag_submit = false;
            // } else {
            //
            //     if (check_name() == 'false') {
            //
            //         // if (focus_once == 0) { jQuery("#account_name").focus(); focus_once = 1;  }
            //         flag_submit = false;
            //     } else {
            //         document.getElementById("demo4").innerHTML = "";
            //     }
            //     // document.getElementById("demo5").innerHTML = "";
            // }

            if (opening_balance.trim() != "") {
                if (!validatebcode(opening_balance)) {

                    document.getElementById("demo5").innerHTML = "Only Digits";
                    if (focus_once == 0) {
                        jQuery("#opening_balance").focus();
                        focus_once = 1;
                    }
                    flag_submit = false;
                }
            } else {
                document.getElementById("demo5").innerHTML = "";
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

    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#first_head_code").select2();
            jQuery("#second_head_code").select2();
            jQuery("#head_code").select2();
            jQuery("#group").select2();


            setTimeout(function () {
                var dropDown = document.getElementById('first_head_code');
                var first_head_code = dropDown.options[dropDown.selectedIndex].value;

                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });

                jQuery.ajax({
                    url: "get_account_heads",
                    data: {first_head_code: first_head_code},
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    success: function (data) {

                        jQuery("#second_head_code").html("");
                        jQuery("#second_head_code").append(data);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // alert(jqXHR.responseText);
                        // alert(errorThrown);
                    }
                });

            }, 300);
        });
    </script>
    <!-- additionl scripting ednds here-->

@endsection

