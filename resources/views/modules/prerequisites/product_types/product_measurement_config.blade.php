@extends('extend_index')

@section('content')

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
            class="col-xs-12 col-sm-12 col-md-12  col-lg-12 col-xl-12">


            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">

                <div class="close_info_bx"><!-- info bx start -->
                    <i class="fa fa-expand"></i>
                </div><!-- info bx end -->

                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 tabindex="-1" class="text-white get-heading-text">Advertising Measurement Configuration </h4>
                        </div>
                        <div class="list_btn">
                            <a tabindex="-1" class="btn list_link add_more_button"
                               href="{{ route('product_measurement_config_list') }}" role="button">
                                <i class="fa fa-list"></i> view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <form name="f1" class="f1" id="f1"
                      {{--                      action="{{ route('submit_product_measurement_config') }}"--}}
                      onsubmit="return checkForm()"
                    {{--                      method="post"--}}
                >
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                    <div class="row">

                                        <div class="form-group col-lg-3 col-md-3 col-sm-6">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">
                                                    Company Title
                                                </label>
                                                <select tabindex="1" autofocus name="company" class="inputs_up form-control"
                                                        id="company" autofocus data-rule-required="true"
                                                        data-msg-required="Please Enter Advertising Title">
                                                    <option value="" selected disabled>Select Company</option>
                                                    @foreach ($companies as $company)
                                                        <option
                                                            value="{{$company->account_uid}}" {{$company->account_uid == old('product_name') ? 'selected' : ''}}>{{$company->account_name}}</option>
                                                    @endforeach

                                                </select>
                                                <span id="demo1" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-3 col-md-3 col-sm-6">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">
                                                    Project Title
                                                </label>
                                                <select tabindex="1" autofocus name="project" class="inputs_up form-control"
                                                        id="project" autofocus data-rule-required="true"
                                                        data-msg-required="Please Enter Advertising Title">
                                                    <option value="" selected disabled>Select Project</option>
                                                    {{--                                                    @foreach ($projects as $product)--}}
                                                    {{--                                                        <option--}}
                                                    {{--                                                            value="{{ $product->pro_p_code }}" {{$product->pro_p_code == old('product_name') ? 'selected' : ''}}>{{ $product->pro_title }}</option>--}}
                                                    {{--                                                    @endforeach--}}

                                                </select>
                                                <span id="demo1" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-3 col-md-3 col-sm-6">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">
                                                    Product Title
                                                </label>
                                                <select tabindex="2" autofocus name="product_name" class="inputs_up form-control"
                                                        id="product_name" autofocus data-rule-required="true"
                                                        data-msg-required="Please Enter Advertising Title">
                                                    <option value="" selected disabled>Select Product</option>
                                                    {{--                                                    @foreach ($products as $product)--}}
                                                    {{--                                                        <option--}}
                                                    {{--                                                            value="{{ $product->pro_p_code }}" {{$product->pro_p_code == old('product_name') ? 'selected' : ''}}>{{ $product->pro_title }}</option>--}}
                                                    {{--                                                    @endforeach--}}

                                                </select>
                                                <span id="demo1" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>


                                        <div class="form-group col-lg-2 col-md-2 col-sm-2" hidden>
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">

                                                    {{--                                                    UOM Before Decimal--}}
                                                    UOM Calculation (Feet)
                                                </label>
                                                <select tabindex="2" name="before_decimal" class="inputs_up form-control"
                                                        id="before_decimal" autofocus data-rule-required="true"
                                                        data-msg-required="Please Enter Before Decimal">
                                                    <option value="1" selected>Feet</option>
                                                    {{--                                                    <option value="1" selected>Select Before Decimal Unit</option>--}}
                                                    {{--                                                    @foreach ($units as $unit)--}}
                                                    {{--                                                        <option--}}
                                                    {{--                                                            value="{{ $unit->unit_id }}" {{$unit->unit_id == old('before_decimal') ? 'selected' : ''}}>{{ $unit->unit_title }}</option>--}}
                                                    {{--                                                    @endforeach--}}
                                                </select>
                                                <span id="demo2" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-2 col-md-2 col-sm-2" hidden>
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">

                                                    {{--                                                    UOM After Decimal--}}
                                                    UOM Calculation (Inches)
                                                </label>
                                                <select tabindex="3" name="after_decimal" class="inputs_up form-control"
                                                        id="after_decimal" autofocus data-rule-required="true"
                                                        data-msg-required="Please Enter After Decimal">
                                                    <option value="1">Inches</option>
                                                    {{--                                                    <option value="">Select After Decimal Unit</option>--}}
                                                    {{--                                                    @foreach ($units as $unit)--}}
                                                    {{--                                                        <option--}}
                                                    {{--                                                            value="{{ $unit->unit_id }}" {{$unit->unit_id == old('after_decimal') ? 'selected' : ''}}>{{ $unit->unit_title }}</option>--}}
                                                    {{--                                                    @endforeach--}}

                                                </select>
                                                <span id="demo3" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                        <div class="form-group col-lg-2 col-md-2 col-sm-2" hidden>
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">

                                                    {{--                                                    UOM After Calculation--}}
                                                    UOM Calculation (SQFT)

                                                </label>
                                                <select tabindex="4" name="output_um" class="inputs_up form-control"
                                                        id="output_um" autofocus data-rule-required="true"
                                                        data-msg-required="Please Output Unit of Measurement">
                                                    <option value="1">SQFT</option>
                                                    {{--                                                    <option value="">Select Output Unit of Measurement</option>--}}
                                                    {{--                                                    @foreach ($units as $unit)--}}
                                                    {{--                                                        <option--}}
                                                    {{--                                                            value="{{ $unit->unit_id }}" {{$unit->unit_id == old('output_um') ? 'selected' : ''}}>{{ $unit->unit_title }}</option>--}}
                                                    {{--                                                    @endforeach--}}

                                                </select>
                                                <span id="demo4" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>


                                        <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="">
                                                    <a
                                                        data-container="body" data-toggle="popover" data-trigger="hover"
                                                        data-placement="bottom" data-html="true"
                                                        data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p><h6>Benefit</h6><p>{{
                                                        config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p><h6>Example</h6><p>{{
                                                        config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p><h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                                        <l class="fa fa-info-circle"></l>
                                                    </a>
                                                    Remarks</label>
                                                <input tabindex="5" type="text" name="remarks" id="remarks" value="{{old('remarks')}}"
                                                       class="inputs_up remarks form-control" placeholder="Remarks">
                                                {{--                                                <textarea name="remarks" id="remarks"--}}
                                                {{--                                                          class="inputs_up remarks form-control" placeholder="Remarks"--}}
                                                {{--                                                          style="height: 168px !important;">{{ old('remarks') }}</textarea>--}}
                                                <span id="demo4" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">

                                    <div class="row">
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <div class="custom-control custom-radio mb-10 mt-1">
                                                    <input tabindex="6" type="radio" name="advertising_type"
                                                           class="custom-control-input religion" id="dimensional3"
                                                           value="1" onclick="change_type();"
                                                           checked>
                                                    {{--                                                           {{ old('advertising_type')== 1  ? 'checked' : '' }} checked>--}}
                                                    <label class="custom-control-label" for="dimensional3">
                                                        Front / Left /Right
                                                    </label>
                                                </div>

                                                <span id="demo4" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                            <br>
                                            <div class="row flr-toggle">
                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 gauge_type">
                                                    <label class="">
                                                        Depth</label>
                                                    <input tabindex="7" type="text" name="depth" id="depth" class="inputs_up form-control"
{{--                                                           data-rule-required="true"--}}
{{--                                                           data-msg-required="Please Enter Depth" --}}
                                                           placeholder="Depth"
                                                           onclick="click()">
{{--                                                    <span id="demo4" class="validate_sign"> </span>--}}
                                                    <span id="dep_error" class="validate_sign"> </span>
                                                </div>
                                                <div class="form-group col-lg-4 col-md-4 col-sm-12 gauge_type">
                                                    <label class="">
                                                        Tapa Gauge (KG)</label>
                                                    <input tabindex="8" type="text" name="tapa_gauge" id="tapa_gauge" class="inputs_up form-control"
{{--                                                           data-rule-required="true"--}}
{{--                                                           data-msg-required="Please Enter Tapa Gauge" --}}
                                                           placeholder="Tapa Gauge"
                                                           onclick="click()">
                                                    <span id="tapa_error" class="validate_sign"> </span>
{{--                                                    <span id="demo4" class="validate_sign"> </span>--}}
                                                </div>
                                                <div class="form-group col-lg-5 col-md-5 col-sm-12 gauge_type">
                                                    <label class="">
                                                        Back Sheet Gauge (KG)</label>
                                                    <input tabindex="9" type="text" name="sheet_gauge" id="sheet_gauge" class="inputs_up form-control" placeholder="Back Sheet Gauge"
{{--                                                           data-rule-required="true"--}}
{{--                                                           data-msg-required="Please Enter Back Sheet Gauge" --}}
                                                           onclick="click
                                                    ()">
{{--                                                    <span id="demo4" class="validate_sign"> </span>--}}
                                                    <span id="sheet_error" class="validate_sign"> </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">

                                    <div class="row">
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <div class="custom-control custom-radio mb-10 mt-1">
                                                    <input tabindex="10" type="radio" name="advertising_type"
                                                           class="custom-control-input religion" id="quantity"
                                                           value="2" onclick="change_type();">
                                                    {{--                                                           value="2"{{ old('advertising_type')== 2  ? 'checked' : '' }}>--}}
                                                    <label class="custom-control-label" for="quantity">
                                                        Quantity
                                                    </label>
                                                </div>
                                                {{--                                                <label class="">Quantity</label>--}}

                                            </div><!-- end input box -->
                                        </div>

                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">

                                    <div class="row">
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <div class="custom-control custom-radio mb-10 mt-1">
                                                    <input tabindex="11" type="radio" name="advertising_type"
                                                           class="custom-control-input religion" id="dimensional2"
                                                           {{--                                                           value="3"{{ old('advertising_type')== 3  ? 'checked' : '' }}>--}}
                                                           value="3" onclick="change_type();">
                                                    <label class="custom-control-label" for="dimensional2">
                                                        Height/Width
                                                    </label>
                                                </div>
                                                {{--                                                <label class="">Quantity</label>--}}

                                            </div><!-- end input box -->
                                        </div>

                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">

                                    <div class="row">
                                        <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                            <div class="input_bx" style="padding-bottom: 9px;"><!-- start input box -->

                                                <label>Survey</label>
                                                <div class="row mt-2">

                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="custom-checkbox" style="float: left">
                                                            <input tabindex="12" type="checkbox" name="pre" id="pre"
                                                                   class="custom-control-input company_info_check_box"
                                                                   value="1"
                                                            >
                                                            <label class="custom-control-label chck_pdng" for="pre">
                                                                Pre Survey
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <div class="custom-checkbox" style="float: left">
                                                            <input tabindex="13" type="checkbox" name="post" id="post"
                                                                   class="custom-control-input company_info_check_box"
                                                                   value="1" data-rule-required="true"
                                                                   data-msg-required="Please Check Post Box">
                                                            <label class="custom-control-label chck_pdng" for="post" disabled="true">
                                                                Post Survey
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end input box -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    <button tabindex="14" type="reset" name="cancel" id="cancel" class="cancel_button form-control">
                                        <i class="fa fa-eraser"></i> Cancel
                                    </button>
                                    <button tabindex="15" type="submit" name="save" id="save" class="save_button form-control"
                                        {{--                                            onclick="return validate_form()"--}}
                                    >
                                        <i class="fa fa-floppy-o"></i> Save
                                    </button>
                                </div>
                            </div>

                        </div> <!-- left column ends here -->

                    </div> <!--  main row ends here -->


                </form>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            var type = $("input:radio[name=advertising_type]:checked").val();

            let company = document.getElementById("company"),
                project = document.getElementById("project"),
                product_name = document.getElementById("product_name"),
                post = document.getElementById("post"),

                validateInputIdArray = [
                    company.id,
                    project.id,
                    product_name.id,
                    post.id,
                ];
            var check = validateInventoryInputs(validateInputIdArray);
            // return validateInventoryInputs(validateInputIdArray);
            // depth = document.getElementById("depth"),
            // tapa_gauge = document.getElementById("tapa_gauge"),
            // sheet_gauge = document.getElementById("sheet_gauge");
            // var validateInputIdArray = [];
            if (check == true) {
                // if (type == 1) {
                //     let depth = document.getElementById("depth"),
                //         tapa_gauge = document.getElementById("tapa_gauge"),
                //         sheet_gauge = document.getElementById("sheet_gauge"),
                //         validateInputIdArray = [
                //             company.id,
                //             project.id,
                //             product_name.id,
                //             depth.id,
                //             tapa_gauge.id,
                //             sheet_gauge.id,
                //         ];
                //     var system = validateInventoryInputs(validateInputIdArray);
                // } else {
                    var system = validateInventoryInputs(validateInputIdArray);
                // }
            }
            if (system == true) {
                var validateInputValeArray = {
                    company: company.value,
                    project: project.value,
                    product_name: product_name.value,
                    before_decimal: before_decimal.value,
                    after_decimal: after_decimal.value,
                    output_um: output_um.value,
                    depth: depth.value,
                    tapa_gauge: tapa_gauge.value,
                    sheet_gauge: sheet_gauge.value,
                };
                save(validateInputValeArray);
                return false;
            } else {
                return false;
            }
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

    </script>

    <script>
        // $('#dimensional3').click(function () {
        //     $('#')
        // })
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#company").select2();
            jQuery("#project").select2();
            jQuery("#product_name").select2();
            jQuery("#before_decimal").select2();
            jQuery("#after_decimal").select2();
            jQuery("#output_um").select2();
            $("input[name='advertising_type']").change(function () {
                let advertising_type = $(this).val();
                if (advertising_type == 1) {
                    $('.gauge_type').show();
                } else {
                    $('.gauge_type').hide();
                }
            });
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
                        option += "<option value='" + value.proj_id + "' >" + value.proj_project_name + "</option>";
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
    <script>
        jQuery("#project").change(function () {
            var project = $(this).find(':selected').val();

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "get_company_config_products",
                data: {project: project},
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    var option = "<option value='' disabled selected>Select Product</option>";

                    $.each(data.products, function (index, value) {
                        option += "<option value='" + value.pro_p_code + "' data-parent='" + value.pro_p_code + "' data-sale_price='" + value.pro_sale_price + "' data-tax='" + value.pro_tax + "'data-retailer_dis='" + value.pro_retailer_discount + "' data-whole_saler_dis='" + value.pro_whole_seller_discount + "' data-loyalty_dis='" + value.pro_loyalty_card_discount + "' data-unit='" + value.unit_title + "'>" + value.pro_title + "</option>";
                    });

                    jQuery("#product_name").html(" ");
                    jQuery("#product_name").append(option);
                    jQuery("#product_name").select2()
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });
    </script>

    <script>
        function save(valueArray) {

            var advertising_type = $("input:radio[name=advertising_type]:checked").val();
            var dep = $('#depth').val();
            var tapa = $('#tapa_gauge').val();
            var sheet_gauge = $('#sheet_gauge').val();
            var pre = $('#pre:checked').val();
            var post = $('#post:checked').val();
            var remarks = $('#remarks').val();
            var flag_submit = true;
            var focus_once = 0;
            if (advertising_type == 1) {
                if (dep == "") {
                    if (focus_once == 0) {
                        jQuery("#depth").focus();
                        focus_once = 1;
                        document.getElementById("dep_error").innerHTML = "Required";
                    }
                    flag_submit = false;
                }else{
                    document.getElementById("dep_error").innerHTML = "";
                }if (tapa == "") {
                    if (focus_once == 0) {
                        jQuery("#tapa_gauge").focus();
                        focus_once = 1;
                        document.getElementById("tapa_error").innerHTML = "Required";
                    }
                    flag_submit = false;
                }else{
                    document.getElementById("tapa_error").innerHTML = "";
                }if (sheet_gauge == "") {
                    if (focus_once == 0) {
                        jQuery("#sheet_gauge").focus();
                        focus_once = 1;
                        document.getElementById("sheet_error").innerHTML = "Required";
                    }
                    flag_submit = false;
                }else{
                    document.getElementById("sheet_error").innerHTML = "";
                }

            }if(flag_submit==true){
                $.ajax({
                    type: "POST",
                    url: "submit_product_measurement_config",
                    data: {
                        company: valueArray.company,
                        project: valueArray.project,
                        product_name: valueArray.product_name,
                        before_decimal: valueArray.before_decimal,
                        after_decimal: valueArray.after_decimal,
                        output_um: valueArray.output_um,
                        depth: valueArray.depth,
                        tapa_gauge: valueArray.tapa_gauge,
                        sheet_gauge: valueArray.sheet_gauge,
                        'advertising_type': advertising_type,
                        'pre': pre,
                        'post': post,
                        'remarks': remarks
                    },
                    dataType: "json",
                    success: function (data) {
                        // console.log(data.message);
                        jQuery("#product_name").select2("destroy");
                        jQuery("#product_name option[value=" + valueArray.product_name + "]").attr("disabled", "true");
                        jQuery('#product_name option[value="' + '' + '"]').prop('selected', true);
                        jQuery("#product_name").select2();

                        swal.fire({
                            title: 'Successfully Saved',
                            text: false,
                            type: 'success',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-success',
                            timer: 4000
                        });

                    },
                    error: function () {
                        alert('error handling here');
                    }
                });
            }

        }

    </script>
    <script>
        function change_type() {
            var type = $("input:radio[name=advertising_type]:checked").val();
            if (type == 2 || type == 3) {
                $('#depth').val('');
                $('#tapa_gauge').val('');
                $('#sheet_gauge').val('');
            }

        }
    </script>
@endsection


