
@extends('extend_index')

@section('content')
    <div class="row">
                <div class="container-fluid search-filter form-group form_manage">
                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 tabindex="-1" class="text-white get-heading-text">Create Child Account</h4>
                            </div>
                            <div class="list_btn">
                                <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('third_level_chart_of_account_list') }}" role="button">
                                    <l class="fa fa-list"></l> view list
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

                                <form action="{{ route('submit_third_level_chart_of_account_excel') }}" method="post" enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">
                                                    Select Excel File
                                                </label>
                                                <input tabindex="100" type="file" name="add_parent_account_excel" id="add_parent_account_pattern_excel" class="inputs_up form-control-file form-control height-auto"
                                                       accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                            </div><!-- end input box -->
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                            <a href="{{ url('public/sample/third_level_account/add_parent_account_pattern.xlsx') }}" tabindex="-1" type="reset" class="cancel_button btn btn-sm btn-info">
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



                    <form name="f1" class="f1 mx-auto col-lg-6 col-md-6 col-sm-12 col-xs-12" id="f1" action="{{ route('submit_third_level_chart_of_account') }}" onsubmit="return checkForm()" method="post">
                        @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="row">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.control_account.description')}}</p>
                                                             <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.control_account.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.control_account.example')}}
                                                               <h6>Validation</h6><p>{{config('fields_info.about_form_fields.control_account.validations')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Control Account</label>
                                                    <select tabindex=1 autofocus name="first_head_code" id="first_head_code" class="inputs_up form-control" data-rule-required="true" data-msg-required="Please Enter Control Account">
                                                        <option value="">Select Control Account</option>
                                                        @foreach($first_level_accounts as $first_level_account)
                                                            <option value="{{$first_level_account->coa_code}}" {{ $first_level_account->coa_code == old('first_head_code') ? 'selected="selected"' : '' }}>{{$first_level_account->coa_head_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
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
                                                    </label>
                                                    <select tabindex="2" name="head_code" id="head_code" class="inputs_up form-control"  data-rule-required="true" data-msg-required="Please Enter Parent Account">
                                                        <option value="">Select Parent Account</option>

                                                    </select>
                                                    <span id="demo2" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">
                                                        <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                           data-placement="bottom" data-html="true"
                                                           data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.child_account.description')}}</p>
                                            <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.child_account.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.child_account.example')}}</p>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        Child Account</label>
                                                    <input tabindex="3" type="text" name="account_name" id="account_name" class="inputs_up form-control" data-rule-required="true" data-msg-required="Please Enter Child Account"
                                                           placeholder="Child Account" autocomplete="off" value="{{old('account_name')}}">
                                                    <span id="demo4" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                        <div class="form-group">
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
                                                <textarea tabindex="4" name="remarks" id="remarks" class="inputs_up remarks form-control" placeholder="Remarks" style="height: 167px">{{old('remarks')}}</textarea>
                                            </div><!-- end input box -->
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                        <button tabindex="5" type="reset" name="cancel" id="cancel" class="cancel_button btn btn-sm btn-info">
                                            <i class="fa fa-eraser"></i> Cancel
                                        </button>
                                        <button tabindex="6" type="button" name="save" id="save" class="save_button btn btn-sm btn-success" >
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
            head_code = document.getElementById("head_code"),
            account_name = document.getElementById("account_name"),
            validateInputIdArray = [
                first_head_code.id,
                head_code.id,
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
                    url: "{{route('submit_third_level_chart_of_account')}}",
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    data: {
                        'first_head_code': first_head_code.value,
                        'head_code': head_code.value,
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
                    // error: function () {
                    //     alert('error handling here');
                    // }
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
    <script>

        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        jQuery("#refresh_second_head").click(function () {
            var dropDown = document.getElementById('first_head_code');
            var first_head_code = dropDown.options[dropDown.selectedIndex].value;

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_head",
                data: {first_head_code: first_head_code},
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


        jQuery("#first_head_code").change(function () {

            var dropDown = document.getElementById('first_head_code');
            var first_head_code = dropDown.options[dropDown.selectedIndex].value;

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_head",
                data: {first_head_code: first_head_code},
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

    <script type="text/javascript">

        function validate_form() {


            var first_head_code = document.getElementById("first_head_code").value;
            var head_code = document.getElementById("head_code").value;
            var account_name = document.getElementById("account_name").value;

            var flag_submit = true;
            var focus_once = 0;


            return flag_submit;
        }

    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#first_head_code").select2();
            jQuery("#head_code").select2();
        });
    </script>
    <!-- additionl scripting ednds here-->

@endsection

