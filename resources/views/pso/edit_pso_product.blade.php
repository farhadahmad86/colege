<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('include/head')

</head>

<body>

@include('include/header')
@include('include.sidebar_shahzaib')

<div class="main-container">
    <div class="pd-ltr-20 customscroll-10-p height-100-p xs-pd-20-10">
        @include('inc._messages')

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-9">


                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit PSO Product</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">

                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white">Edit PSO Product</h4>
                            </div>
                        </div>
                    </div><!-- form header close -->

                    <form name="f1" class="f1" id="f1" action="{{ route('update_pso_product') }}" onsubmit="return validate_form()" method="post" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                        <div class="row">

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">Product Code</label>
                                                    <input type="text" name="pro_code" id="pro_code" class="inputs_up form-control" placeholder="Product Code" value="{{$request->code}}">
                                                    <span id="demo1" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">Product Title</label>
                                                    <input type="text" name="pro_name" id="pro_name" class="inputs_up form-control" placeholder="Product Title" value="{{$request->name}}">

                                                    <span id="demo2" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="">Purchase Price</label>
                                                    <input type="text" name="purchase_price" id="purchase_price" class="inputs_up form-control"
                                                           placeholder="Purchase Rate" onkeypress="return allowOnlyNumber(event);" value="{{empty($request->purchase_rate) ? '':$request->purchase_rate}}">
                                                    <span id="demo3" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="">Sale Price</label>
                                                    <input type="text" name="sale_price" id="purchase_price" class="inputs_up form-control"
                                                           placeholder="Sale Rate" onkeypress="return allowOnlyNumber(event);" value="{{empty($request->sale_rate) ? '':$request->sale_rate}}">
                                                    <span id="demo4" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                        </div>
                                    </div>

                                    <input value="{{$request->pro_id}}" name="pro_id" type="hidden">

                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                        <div class="row">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="">Description</label>
                                                    <textarea name="desc" id="desc" class="inputs_up remarks form-control" placeholder="Description">{{$request->desc}}</textarea>
                                                    <span id="demo4" class="validate_sign"> </span>
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
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                {{--<div class="show_info_div">--}}

                                {{--</div>--}}

                            </div> <!-- right columns ends here -->

                        </div> <!--  main row ends here -->


                    </form>
                </div> <!-- white column form ends here -->


            </div><!-- col end -->
        </div><!-- row end -->


        @include('include/footer')
    </div>
</div>

@include('include/script')

<script type="text/javascript">

    function validate_form() {
        var pro_code = document.getElementById("pro_code").value;
        var pro_name = document.getElementById("pro_name").value;

        var flag_submit = true;
        var focus_once = 0;

        if (pro_code.trim() == "") {
            document.getElementById("demo1").innerHTML = "Required";
            if (focus_once == 0) {
                jQuery("#pro_code").focus();
                focus_once = 1;
            }
            flag_submit = false;
        } else {
            document.getElementById("demo1").innerHTML = "";
        }

        if (pro_name.trim() == "") {
            document.getElementById("demo2").innerHTML = "Required";
            if (focus_once == 0) {
                jQuery("#pro_name").focus();
                focus_once = 1;
            }
            flag_submit = false;
        } else {
            document.getElementById("demo2").innerHTML = "";
        }

        return flag_submit;
    }

    function allowOnlyNumber(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>
</body>
</html>
