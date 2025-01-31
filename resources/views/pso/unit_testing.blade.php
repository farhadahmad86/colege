{{--<!DOCTYPE html>--}}
{{--<html>--}}
{{--<head>--}}
{{--    @include('include/head')--}}
{{--</head>--}}
{{--<body>--}}
{{--@include('include/header')--}}
{{--@include('include/sidebar')--}}

{{--<div class="main-container">--}}
{{--    <div class="pd-ltr-20 customscroll-10-p height-100-p xs-pd-20-10">--}}

{{--        @include('inc._messages')--}}

{{--        <div class="row">--}}
{{--            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-9">--}}


{{--                <div class="page-header">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-md-6 col-sm-12">--}}
{{--                            <!-- <div class="title">--}}
{{--                                <h4>Account Registration</h4>--}}
{{--                            </div> -->--}}
{{--                            <nav aria-label="breadcrumb" role="navigation">--}}
{{--                                <ol class="breadcrumb">--}}
{{--                                    <li class="breadcrumb-item"><a href="index">Home</a></li>--}}
{{--                                    <li class="breadcrumb-item active" aria-current="page">Unit Testing</li>--}}
{{--                                </ol>--}}
{{--                            </nav>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">--}}

{{--                    <div class="form_header"><!-- form header start -->--}}
{{--                        <div class="clearfix">--}}
{{--                            <div class="pull-left">--}}
{{--                                <h4 tabindex="-1" class="text-white">Unit Testing</h4>--}}
{{--                            </div>--}}
{{--                            <div class="list_btn">--}}
{{--                                <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('unit_testing_list') }}" role="button">--}}
{{--                                    <l class="fa fa-list"></l>--}}
{{--                                    view list--}}
{{--                                </a>--}}
{{--                            </div><!-- list btn -->--}}
{{--                        </div>--}}
{{--                    </div><!-- form header close -->--}}

{{--                    <form name="f1" class="f1" id="f1" action="{{ route('submit_unit_testing') }}" onsubmit="return validate_form()" method="post">--}}
{{--                        @csrf--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">--}}
{{--                                <div class="row">--}}


{{--                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">--}}

{{--                                        <div class="row">--}}
{{--                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">--}}
{{--                                                <div class="input_bx"><!-- start input box -->--}}
{{--                                                    <label class="required">--}}
{{--                                                        Nozzle--}}
{{--                                                        <a href="{{ route('add_nozzle') }}" class="add_btn" target="_blank">--}}
{{--                                                            <l class="fa fa-plus"></l>--}}
{{--                                                            Add--}}
{{--                                                        </a>--}}
{{--                                                    </label>--}}
{{--                                                    <select tabindex="1" autofocus name="nozzle" class="inputs_up form-control" id="nozzle" autofocus>--}}
{{--                                                        <option value="">Select Nozzle</option>--}}

{{--                                                        @foreach($nozzles as $nozzle)--}}
{{--                                                            <option value="{{$nozzle->noz_id}}">{{$nozzle->noz_name}}</option>--}}
{{--                                                        @endforeach--}}

{{--                                                    </select>--}}
{{--                                                    <span id="demo1" class="validate_sign"> </span>--}}
{{--                                                </div><!-- end input box -->--}}

{{--                                            </div>--}}

{{--                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">--}}
{{--                                                <div class="input_bx"><!-- start input box -->--}}
{{--                                                    <label class="required">Quantity (L)</label>--}}
{{--                                                    <input tabindex="2" type="text" name="qty" id="qty" class="inputs_up form-control"--}}
{{--                                                           placeholder="Qty" autocomplete="off" onkeypress="return numeric_decimal_only(event);">--}}
{{--                                                    <span id="demo2" class="validate_sign"> </span>--}}
{{--                                                </div><!-- end input box -->--}}
{{--                                            </div>--}}

{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">--}}

{{--                                        <div class="row">--}}
{{--                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">--}}
{{--                                                <div class="input_bx"><!-- start input box -->--}}
{{--                                                    <label class="">Remarks</label>--}}
{{--                                                    <textarea tabindex="3" name="remarks" id="remarks" class="inputs_up remarks form-control" placeholder="Remarks"></textarea>--}}
{{--                                                    <span id="demo3" class="validate_sign"> </span>--}}
{{--                                                </div><!-- end input box -->--}}
{{--                                            </div>--}}

{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <div class="form-group row">--}}
{{--                                    <div class="col-lg-12 col-md-12 col-sm-12 form_controls">--}}
{{--                                        <button tabindex="4" type="reset" name="cancel" id="cancel" class="cancel_button form-control">--}}
{{--                                            <i class="fa fa-eraser"></i> Cancel--}}
{{--                                        </button>--}}
{{--                                        <button tabindex="5" type="submit" name="save" id="save" class="save_button form-control">--}}
{{--                                            <i class="fa fa-floppy-o"></i> Save--}}
{{--                                        </button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                            </div> <!-- left column ends here -->--}}
{{--                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">--}}
{{--                                --}}{{--<div class="show_info_div">--}}

{{--                                --}}{{--</div>--}}

{{--                            </div> <!-- right columns ends here -->--}}

{{--                        </div> <!--  main row ends here -->--}}


{{--                    </form>--}}
{{--                </div> <!-- white column form ends here -->--}}


{{--            </div><!-- col end -->--}}
{{--        </div><!-- row end -->--}}


{{--        @include('include/footer')--}}

{{--    </div>--}}
{{--</div>--}}
{{--@include('include/script')--}}


{{--<script type="text/javascript">--}}

{{--    function numeric_decimal_only(e) {--}}

{{--        return e.charCode === 0 || ((e.charCode >= 48 && e.charCode <= 57) || (e.charCode == 46 && document.getElementById(e.target.id).value.indexOf('.') < 0));--}}
{{--    }--}}

{{--    function validate_form() {--}}
{{--        var nozzle = document.getElementById("nozzle").value;--}}
{{--        var qty = document.getElementById("qty").value;--}}
{{--        var remarks = document.getElementById("remarks").value;--}}

{{--        var flag_submit = true;--}}
{{--        var focus_once = 0;--}}

{{--        if (nozzle.trim() == "") {--}}
{{--            document.getElementById("demo1").innerHTML = "Required";--}}
{{--            if (focus_once == 0) {--}}
{{--                jQuery("#nozzle").focus();--}}
{{--                focus_once = 1;--}}
{{--            }--}}
{{--            flag_submit = false;--}}
{{--        } else {--}}
{{--            document.getElementById("demo1").innerHTML = "";--}}
{{--        }--}}

{{--        if (qty.trim() == "") {--}}
{{--            document.getElementById("demo2").innerHTML = "Required";--}}
{{--            if (focus_once == 0) {--}}
{{--                jQuery("#qty").focus();--}}
{{--                focus_once = 1;--}}
{{--            }--}}
{{--            flag_submit = false;--}}
{{--        } else {--}}
{{--            document.getElementById("demo2").innerHTML = "";--}}
{{--        }--}}


{{--        // if(remarks.trim() == "")--}}
{{--        // {--}}
{{--        //     document.getElementById("demo3").innerHTML = "Required";--}}
{{--        //     if (focus_once == 0) { jQuery("#remarks").focus(); focus_once = 1;}--}}
{{--        //     flag_submit = false;--}}
{{--        // }else{--}}
{{--        //     document.getElementById("demo3").innerHTML = "";--}}
{{--        // }--}}


{{--        return flag_submit;--}}
{{--    }--}}

{{--</script>--}}

{{--<script>--}}
{{--    jQuery(document).ready(function () {--}}
{{--        // Initialize select2--}}
{{--        jQuery("#nozzle").select2();--}}

{{--    });--}}
{{--</script>--}}

{{--</body>--}}
{{--</html>--}}


@extends('extend_index')

@section('content')

    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">



                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Create Unit Testing</h4>
                        </div>
                        <div class="list_btn">
                            <a class="btn list_link add_more_button" href="{{ route('unit_testing_list') }}" role="button">
                                <i class="fa fa-list"></i> view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <form name="f1" class="f1" id="f1" onsubmit="return validateForm(this)" action="{{ route('submit_unit_testing') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                    <div class="row">
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">
                                                    Nozzle Title
                                                    <a href="{{ route('add_nozzle') }}" class="add_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}">
                                                        <l class="fa fa-plus"></l>
                                                    </a>
                                                    <a id="refresh_nozzle" class="add_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}">
                                                        <l class="fa fa-refresh"></l>
                                                    </a>

                                                </label>
                                                <select name="nozzle" class="inputs_up form-control required" id="nozzle" autofocus data-rule-required="true" data-msg-required="Please Enter Nozzle Title">
                                                    <option value="">Select Nozzle</option>

                                                    @foreach($nozzles as $nozzle)
                                                        <option
                                                            value="{{$nozzle->noz_id}}">{{$nozzle->noz_name}}</option>
                                                    @endforeach

                                                </select>
                                                <span id="demo1" class="validate_sign"> </span>
                                            </div><!-- end input box -->

                                        </div>

                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">
                                                    Quantity (L)
                                                </label>
                                                <input type="text" name="qty" id="qty" class="inputs_up form-control"
                                                       placeholder="Qty" autocomplete="off" value="{{ old('qty') }}"  data-rule-required="true" data-msg-required="Please Enter Quantity"
                                                       onkeypress="return numeric_decimal_only(event);">
                                                <span id="demo2" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

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
                                                <textarea name="remarks" id="remarks" class="inputs_up remarks form-control" placeholder="Remarks" style="height: 100px;">{{ old('remarks') }}</textarea>
                                                <span id="demo3" class="validate_sign"> </span>
                                            </div><!-- end input box -->
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    <button type="reset" name="cancel" id="cancel" class="cancel_button form-control">
                                        <i class="fa fa-eraser"></i> Cancel
                                    </button>
                                    <button type="submit" name="save" id="save" class="save_button form-control">
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

<script>

    jQuery("#refresh_nozzle").click(function () {

        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: "refresh_nozzle",
            data: {},
            type: "POST",
            cache: false,
            dataType: 'json',
            success: function (data) {

                jQuery("#nozzle").html(" ");
                jQuery("#nozzle").append(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
                alert(errorThrown);
            }
        });
    });

</script>

    <script>
        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        $(function () {
            $('[data-toggle="popover"]').popover()
        });
    </script>


    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#nozzle").select2();

        });
    </script>

    <script>
        jQuery("#refresh_region").click(function() {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_region",
                data:{},
                type: "POST",
                cache:false,
                dataType: 'json',
                success:function(data){

                    jQuery("#region_name").html(" ");
                    jQuery("#region_name").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
                    alert(errorThrown);}
            });
        });
    </script>

@endsection


