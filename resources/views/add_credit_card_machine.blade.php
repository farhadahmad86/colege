
@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Create Credit Card Machine</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('credit_card_machine_list') }}" role="button">
                            <i class="fa fa-list"></i> view list
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
                        <form action="{{ route('submit_credit_card_machine_excel') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            Select Excel File
                                        </label>
                                        <input tabindex="100" type="file" name="add_credit_card_machine_excel" id="add_credit_card_machine_pattern_excel" class="inputs_up form-control-file form-control height-auto"
                                                accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                    </div><!-- end input box -->
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    <a href="{{ url('public/sample/credit_card_machine/add_credit_card_machine_pattern.xlsx') }}" tabindex="-1" type="reset" class="cancel_button btn btn-sm btn-info">
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
            <form name="f1" class="f1 col-lg-6 mx-auto" id="f1" action="{{ route('submit_credit_card_machine') }}" onsubmit="return checkForm()" method="post" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="input_bx form-group col-lg-6 col-md-6 col-sm-12"><!-- start input box -->
                        <label class="required">
                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                data-placement="bottom" data-html="true"
                                data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.general_registration.credit_card_machine.machine_title.description')}}</p>
                                <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.general_registration.credit_card_machine.machine_title.benefits')}}</p>
                                <h6>Example</h6><p>{{config('fields_info.about_form_fields.general_registration.credit_card_machine.machine_title.example')}}</p>">
                                <i class="fa fa-info-circle"></i>
                            </a>
                            Machine Title</label>
                        <input tabindex=1 autofocus type="text" name="name" id="name" class="inputs_up form-control" data-rule-required="true" data-msg-required="Please Enter Machine Title" value="{{old('name')}}" placeholder="Machine Title" autofocus/>
                        <span id="demo1" class="validate_sign"> </span>
                    </div><!-- end input box -->
                    <div class="input_bx form-group col-lg-6 col-md-6 col-sm-12"><!-- start input box -->
                        <label class="required">
                            Bank
                            <a href="{{ route('bank_account_registration') }}" class="add_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                <i class="fa fa-plus"></i>
                            </a>
                            <a id="refresh_bank" class="add_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                <l class="fa fa-refresh"></l>
                            </a>
                        </label>
                        <select tabindex="2" name="bank" class="inputs_up form-control" id="bank" data-rule-required="true" data-msg-required="Please Enter Bank Title">
                            <option value="">Select Bank</option>
                            @foreach($banks as $bank)
                                <option value="{{$bank->account_uid}}"{{$bank->account_uid == old('bank') ? 'selected="selected"' : ''}}>{{$bank->account_name}}</option>
                            @endforeach
                        </select>
                        <span id="demo2" class="validate_sign"> </span>
                    </div><!-- end input box -->
                    <div class="input_bx form-group col-lg-6 col-md-6 col-sm-12"><!-- start input box -->
                        <label class="required">
                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                data-placement="bottom" data-html="true"
                                data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.general_registration.credit_card_machine.percentage.description')}}</p>
                                <h6>Example</h6><p>{{config('fields_info.about_form_fields.general_registration.credit_card_machine.percentage.example')}}</p>">
                                <i class="fa fa-info-circle"></i>
                            </a>
                            Percentage</label>
                        <input tabindex="3" type="text" name="percentage" id="percentage" class="inputs_up form-control" data-rule-required="true" data-msg-required="Please Enter Percentage" value="{{old('percentage')}}" placeholder="Percentage" onkeypress="return isNumberKey(event)"/>
                        <span id="demo3" class="validate_sign"> </span>
                    </div><!-- end input box -->
                    <div class="input_bx form-group col-lg-6 col-md-6 col-sm-12"><!-- start input box -->
                        <label class="required">
                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                data-placement="bottom" data-html="true"
                                data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.general_registration.credit_card_machine.merchant_code.description')}}</p>
                                <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.general_registration.credit_card_machine.merchant_code.benefits')}}</p>
                                <h6>Example</h6><p>{{config('fields_info.about_form_fields.general_registration.credit_card_machine.merchant_code.example')}}</p>">
                                <i class="fa fa-info-circle"></i>
                            </a>
                            Merchant Code</label>
                        <input tabindex="4" type="text" name="merchant_id" id="merchant_id" class="inputs_up form-control" data-rule-required="true" data-msg-required="Please Enter Merchant Code" value="{{old('merchant_id')}}" placeholder="Merchant Code"/>
                        <span id="demo4" class="validate_sign"> </span>
                    </div><!-- end input box -->
                    <div class="input_bx form-group col-lg-12 col-md-12 col-sm-12"><!-- start input box -->
                        <label class="">
                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                data-placement="bottom" data-html="true" data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p><h6>Benefit</h6><p>{{
                                config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p><h6>Example</h6><p>{{
                                config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                <i class="fa fa-info-circle"></i>
                            </a>
                            Remarks</label>
                        <textarea tabindex="5" name="remarks" id="remarks" class="remarks inputs_up form-control" placeholder="Remarks" style="height: 168px">{{old('remarks')}}</textarea>
                        <span id="demo5" class="validate_sign"> </span>
                    </div><!-- end input box -->
                    <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                        <button tabindex="6" type="reset" name="cancel" id="cancel" class="cancel_button btn btn-sm btn-secondary">
                            <i class="fa fa-eraser"></i> Cancel
                        </button>
                        <button tabindex="7" type="submit" name="save" id="save" class="save_button btn btn-sm btn-success">
                            <i class="fa fa-floppy-o"></i> Save
                        </button>
                    </div>
            </form>
        </div> <!-- white column form ends here -->
    </div>

@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let name = document.getElementById("name"),
            bank = document.getElementById("bank"),
            percentage = document.getElementById("percentage"),
            merchant_id = document.getElementById("merchant_id");
            validateInputIdArray = [
                name.id,
                bank.id,
                percentage.id,
                merchant_id.id,
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

        jQuery("#refresh_bank").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_bank",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#bank").html(" ");
                    jQuery("#bank").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                    alert(errorThrown);}
            });
        });
    </script>


    <script type="text/javascript">


        function form_validation()
        {
            var name  = document.getElementById("name").value;
            // var bank  = document.getElementById("bank").value;
            var percentage  = document.getElementById("percentage").value;
            var merchant_id  = document.getElementById("merchant_id").value;
            var remarks  = document.getElementById("remarks").value;

            var flag_submit = true;
            var focus_once = 0;

            return flag_submit;
        }

    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#bank").select2();
        });

        function isNumberKey(evt)
        {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31
                && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }

        function validaterate(pas) {
            var pass = /^\d*\.?\d*$/;

            if (pass.test(pas)) {
                return true;
            }
            else {
                return false;
            }
        }
    </script>

@endsection


