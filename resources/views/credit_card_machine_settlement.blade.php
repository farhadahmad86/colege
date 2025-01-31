@extends('extend_index')

@section('content')
    <link rel="stylesheet" href="{{ asset('public/css/simple_form.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/add_refresh_btn.css') }}">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 tabindex="-1" class="text-white get-heading-text">Credit Card Machine Settlement</h4>
                        </div>
                        <div class="list_btn">
                            <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('credit_card_machine_settlement_list') }}" role="button">
                                <i class="fa fa-list"></i> view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <form class="highlight" action="{{ route('submit_credit_card_machine_settlement') }}" id="f1" onsubmit="return checkForm()" method="post" autocomplete="off">
                    @csrf
                    <div class="row">
                                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">
                                                    <a tabindex="-1" data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.child_account.description')}}</p>
                                            <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.child_account.benefits')}}</p>
                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.child_account.example')}}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Credit Card Machine
                                                    <a tabindex="-1" href="{{ route('add_credit_card_machine') }}" class="add_btn" target="_blank" data-container="body" data-toggle="popover"
                                                       data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                    <a id="refresh_third_head" class="add_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
                                                       data-content="">
                                                        <l class="fa fa-refresh"></l>
                                                    </a>
                                                </label>
                                                <select tabindex=1 autofocus name="credit_card_machine" id="credit_card_machine" class="inputs_up form-control" data-rule-required="true" data-msg-required="Select Credit Card
                                                Machine">
                                                    <option value="">Select Credit Card Machine</option>
                                                    @foreach($machines as $machine)
                                                        <option value="{{$machine->ccm_id}}">{{$machine->ccm_title}}</option>
                                                    @endforeach
                                                </select>
                                            </div><!-- end input box -->
                                        </div>


                                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
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
                                                    Date</label>
                                                <input tabindex="2" type="text" name="date" id="date" class="inputs_up form-control date-picker" data-rule-required="true"
                                                       data-msg-required="Please Enter Date" placeholder="Settlement Date" value="{{old('date')}}">
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.parent_account.description')}}</p>
                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.parent_account.benefits')}}</p><h6>Example</h6>
                                            <p>{{config('fields_info.about_form_fields.parent_account.example')}}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Time
                                                </label>
                                                <input tabindex="3" type="text" name="time" id="time" class="inputs_up form-control time-picker" data-rule-required="true"
                                                       data-msg-required="Please Select Time" placeholder="Settlement Time" value="{{old('time')}}">
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
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
                                                    Batch #</label>
                                                <input tabindex="4" type="text" name="batch" id="batch" class="inputs_up form-control" data-rule-required="true"
                                                       data-msg-required="Please Enter Batch Number" placeholder="Batch Number" value="{{old('batch')}}" onkeypress="return allowOnlyNumber(event);">
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.parent_account.description')}}</p>
                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.parent_account.benefits')}}</p><h6>Example</h6>
                                            <p>{{config('fields_info.about_form_fields.parent_account.example')}}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Amount
                                                </label>
                                                <input tabindex="5" type="text" name="amount" id="amount" class="inputs_up form-control" data-rule-required="true"
                                                       data-msg-required="Please Enter Amount" placeholder="Settlement Amount" value="{{old('amount')}}" onkeypress="return allow_only_number_and_decimals(this,event);">
                                            </div><!-- end input box -->
                                        </div>




                                    <div class="form-group simple_form col-lg-4 col-md-4 col-sm-12 col-xs-12 simpleForm"><!-- invoice column start -->
                                        <x-posting-reference tabindex="6"/>
                                    </div>
                                    </div>

                                </div>
                                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="">
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p>
                                                        <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p><h6>Example</h6>
                                                        <p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p>
                                                        <h6>Validation</h6>
                                                        <p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Remarks</label>
                                                <textarea tabindex="7" name="remarks" id="remarks" style="height: 108px;" class="inputs_up remarks form-control" placeholder="Remarks">{{old('remarks')}}</textarea>
                                            </div><!-- end input box -->
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    <button tabindex="7" type="reset" name="cancel" id="cancel" class="cancel_button btn btn-sm btn-secondary">
                                        <i class="fa fa-eraser"></i> Cancel
                                    </button>
                                    <button tabindex="8" type="submit" name="save" id="save" class="save_button btn btn-sm btn-success" >
                                        <i class="fa fa-floppy-o"></i> Save
                                    </button>
                                </div>
                            </div> <!--  main row ends here -->

                </form>

            </div>


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')

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
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let credit_card_machine = document.getElementById("credit_card_machine"),
                date = document.getElementById("date"),
                time = document.getElementById("time"),
                batch = document.getElementById("batch"),
                amount = document.getElementById("amount"),
                validateInputIdArray = [
                    credit_card_machine.id,
                    date.id,
                    time.id,
                    batch.id,
                    amount.id,
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


        jQuery("#refresh_third_head").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_credit_card_machine",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#credit_card_machine").html(" ");
                    jQuery("#credit_card_machine").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });

    </script>

    <script type="text/javascript">

        function validate_form() {

            var flag_submit = true;
            var focus_once = 0;

            return flag_submit;
        }

    </script>

    <script>
        jQuery(document).ready(function () {
            // refresh or add botton css
            $('.col_short_btn').addClass("add_btn");
            // Initialize select2
            jQuery("#credit_card_machine").select2();
            jQuery("#posting_reference").select2();

        });
    </script>
    <!-- additionl scripting ednds here-->

@endsection

