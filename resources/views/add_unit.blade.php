@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Create Unit</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('unit_list') }}" role="button">
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

                        <form action="{{ route('submit_unit_excel') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            Select Excel File
                                        </label>
                                        <input tabindex="100" type="file" name="add_create_unit_excel" id="add_create_unit_excel" class="inputs_up form-control-file form-control height-auto"
                                                accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                    </div><!-- end input box -->
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    <a href="{{ url('public/sample/create_unit/add_create_unit_pattern.xlsx') }}" tabindex="-1" type="reset" class="cancel_button btn btn-sm btn-info">
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
            <form name="f1" class="f1 mx-auto col-lg-6" id="f1" action="{{ route('submit_unit') }}" onsubmit="return checkForm()" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="input_bx form-group col-lg-4 col-md-6 col-sm-12"><!-- start input box -->
                                <label class="required">
                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                        data-placement="bottom" data-html="true"
                                        data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.main_unit.title.description')}}</p>
                                        <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.main_unit.title.benefits')}}</p>">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                    Main Unit
                                    <a href="{{ route('add_main_unit') }}" class="add_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover"
                                        data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                    <a id="refresh_mainUnit" class="add_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true"
                                        data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                        <l class="fa fa-refresh"></l>
                                    </a>
                                </label>
                                <select tabindex=1 autofocus name="main_unit" class="inputs_up form-control" id="main_unit" data-rule-required="true"
                                        data-msg-required="Please Enter Main Unit">
                                    <option value="">Select Main Unit</option>
                                    @foreach($main_units as $main_unit)
                                        <option value="{{$main_unit->mu_id}}"{{ $main_unit->mu_id == old('main_unit') ? 'selected="selected"' : '' }}>{{$main_unit->mu_title}}</option>
                                    @endforeach

                                </select>
                                <span id="demo1" class="validate_sign"> </span>
                            </div><!-- end input box -->
                            <div class="input_bx form-group col-lg-4 col-md-6 col-sm-12"><!-- start input box -->
                                <label class="required">
                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                        data-placement="bottom" data-html="true"
                                        data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.unit.unit_title.description')}}</p>
                                        <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.unit.unit_title.benefits')}}</p>">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                    Unit Title</label>
                                <input tabindex="2" type="text" name="unit_name" id="unit_name" class="inputs_up form-control" data-rule-required="true"
                                        data-msg-required="Please Enter Unit Title"
                                        placeholder="Unit Title" value="{{ old('unit_name') }}" autocomplete="off">
                                <span id="demo3" class="validate_sign"> </span>
                            </div><!-- end input box -->
                            <div class="input_bx form-group col-lg-4 col-md-6 col-sm-12">
                                <div class="custom-control custom-checkbox mb-10 mt-4" style="float: left">
                                    <input type="checkbox" name="allowDecimal" class="custom-control-input allowDecimal" id="allowDecimal" value="1">
                                    <label class="custom-control-label" for="allowDecimal">Allow Decimal</label>
                                </div>
                            </div>
                            <div class="input_bx form-group col-lg-6 col-md-12 col-sm-12"><!-- start input box -->
                                <label class="">Symbol</label>
                                <input tabindex="3" type="text" name="symbol" id="symbol" class="inputs_up form-control" data-msg-required="Please Enter Symbol"
                                        value="{{ old('symbol') }}" placeholder="Symbol" autocomplete="off">
                                <span id="demo4" class="validate_sign"> </span>
                            </div> <!-- end input box -->
                            <div class="input_bx form-group col-lg-6 col-md-12 col-sm-12"><!-- start input box -->
                                <label class="required">
                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                        data-placement="bottom" data-html="true"
                                        data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.product_registration.unit.scale_size.description')}}</p>
                                        <h6>Benefits</h6><p>{{config('fields_info.about_form_fields.product_registration.unit.scale_size.benefits')}}</p>">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                    Packing Size</label>
                                <input tabindex="4" type="text" name="scale_size" id="scale_size" class="inputs_up form-control" data-rule-required="true"
                                        data-msg-required="Please Enter Packing Size" value="{{ old('scale_size') }}" placeholder="Packing Size"
                                        onkeypress="return allow_only_number_and_decimals(this,event);" onkeyup="roundFunction()" autocomplete="off">
                                <span id="demo4" class="validate_sign"> </span>
                            </div><!-- end input box -->
                        </div>
                    </div>
                    <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12">
                        <div class="input_bx"><!-- start input box -->
                            <label class="">
                                <a data-container="body" data-toggle="popover" data-trigger="hover"
                                    data-placement="bottom" data-html="true"
                                    data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p><h6>Benefit</h6><p>{{
                                    config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p><h6>Example</h6><p>{{
                                    config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                    <i class="fa fa-info-circle"></i>
                                </a>
                                Remarks</label>
                            <textarea tabindex="5" name="remarks" id="remarks" class="remarks inputs_up form-control" placeholder="Remarks" style="height: 100px"> {{ old('remarks') }}</textarea>
                            <span id="demo5" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                        <button tabindex="6" type="reset" name="cancel" id="cancel" class="cancel_button btn btn-sm btn-info">
                            <i class="fa fa-eraser"></i> Cancel
                        </button>
                        <button tabindex="7" type="button" name="save" id="save" class="save_button btn btn-sm btn-success">
                            <i class="fa fa-floppy-o"></i> Save
                        </button>
                    </div>
                </div>
            </form>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->
@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let main_unit = document.getElementById("main_unit"),
                unit_name = document.getElementById("unit_name"),
                symbol = document.getElementById("symbol"),
                scale_size = document.getElementById("scale_size"),
                validateInputIdArray = [
                    main_unit.id,
                    unit_name.id,
                    symbol.id,
                    scale_size.id,
                ];
            // return validateInventoryInputs(validateInputIdArray);
            var check = validateInventoryInputs(validateInputIdArray);
            if (check == true) {
                remarks = document.getElementById("remarks").value;
                var allowDecimal = $("input:checkbox[name=allowDecimal]:checked").val();
                jQuery(".pre-loader").fadeToggle("medium");

                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{route('submit_unit')}}",
                    type: "POST",
                    cache: false,
                    dataType: 'json',
                    data: {
                        'main_unit': main_unit.value,
                        'unit_name': unit_name.value,
                        'symbol': symbol.value,
                        'scale_size': scale_size.value,
                        'allowDecimal': allowDecimal,
                        'remarks': remarks,
                    },

                    success: function (data) {
                        console.log(data);
                        console.log(data.message);
                        if (data.already_exist != null) {
                            swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Already Exist Unit Name Try Another Name',
                                showCancelButton: false,
                                confirmButtonClass: 'btn btn-success',
                                timer: 4000
                            });

                        } else {
                            $('#unit_name').val('');
                            $('#symbol').val('');
                            $('#scale_size').val('');
                            $('#remarks').val('');
                            $("#allowDecimal").prop( "checked", false );
                            swal.fire({
                                title: 'Successfully Saved' + '  ' + data.name,
                                text: false,
                                type: 'success',
                                showCancelButton: false,
                                confirmButtonClass: 'btn btn-success',
                                timer: 4000
                            });
                        }

                        jQuery(".pre-loader").fadeToggle("medium");
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
    <script>
        $("#save").click(function () {
            checkForm();
        });
    </script>
    {{-- end of required input validation --}}
    <script>

        function roundFunction() {

            if(document.getElementById('allowDecimal').checked){
                // it is checked. Do something
                // alert("checked");
                var scale_size = jQuery("#scale_size").val();
                // nabeel
                scale_size =  Math.round(scale_size);
                jQuery("#scale_size").val(scale_size);
            }else{
                // alert("Not Checked")
            }

        }





        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        jQuery("#refresh_mainUnit").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });


            jQuery.ajax({
                url: "refresh_mainUnit",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {
                    jQuery("#main_unit").html(" ");
                    jQuery("#main_unit").append(data);
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
            var main_unit = document.getElementById("main_unit").value;
            // var category_name  = document.getElementById("category_name").value;
            var unit_name = document.getElementById("unit_name").value;
            var scale_size = document.getElementById("scale_size").value;
            var remarks = document.getElementById("remarks").value;

            var flag_submit = true;
            var focus_once = 0;

            return flag_submit;
        }




    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#main_unit").select2();
            // jQuery("#category_name").select2();

        });
    </script>

@endsection


