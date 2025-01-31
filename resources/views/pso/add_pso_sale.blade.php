<!DOCTYPE html>
<html>
<head>
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
                            <!-- <div class="title">
                                <h4>Account Registration</h4>
                            </div> -->
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Add Sale</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">

                    <div class="form_header"><!-- form header start -->
                        <div class="clearfix">
                            <div class="pull-left">
                                <h4 class="text-white">Add Sale</h4>
                            </div>
                            <div class="list_btn">
                                <a class="btn list_link add_more_button" href="{{ route('pso_sale_list') }}" role="button">
                                    <l class="fa fa-list"></l>
                                    view list
                                </a>
                            </div><!-- list btn -->
                        </div>
                    </div><!-- form header close -->

                    <form name="f1" class="f1" id="f1" action="{{ route('submit_pso_sale') }}" onsubmit="return validate_form()" method="post" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="row">


                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                        <div class="row">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">Employee</label>
                                                    <select name="employee" class="inputs_up form-control" id="employee" autofocus>
                                                        <option value="">Select Employee</option>

                                                        @foreach($employees as $employee)
                                                            <option value="{{$employee->user_id}}">{{$employee->user_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="required">Date/Time</label>
                                                    <input type="text" name="datetime" id="datetime" class="inputs_up form-control datetimepicker"
                                                           placeholder="Date/Time">
                                                    <span id="demo2" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="">Cash Amount</label>
                                                    <input type="text" name="cash_amount" id="cash_amount" class="inputs_up form-control"
                                                           placeholder="Cash Amount" onkeypress="return numeric_decimal_only(event);" onkeyup="calculate_total();">
                                                    <span id="demo3" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="">Credit Amount</label>
                                                    <input type="text" name="credit_amount" id="credit_amount" class="inputs_up form-control"
                                                           placeholder="Credit Amount" onkeypress="return numeric_decimal_only(event);" onkeyup="calculate_total();">
                                                    <span id="demo4" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="">Card Amount</label>
                                                    <input type="text" name="card_amount" id="card_amount" class="inputs_up form-control"
                                                           placeholder="Card Amount" onkeypress="return numeric_decimal_only(event);" onkeyup="calculate_total();">
                                                    <span id="demo5" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                        <div class="row">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx"><!-- start input box -->
                                                    <label class="">Remarks</label>
                                                    <textarea name="remarks" id="remarks" class="inputs_up remarks form-control" placeholder="Remarks"></textarea>
                                                    <span id="demo6" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                            <div class="input_bx"><!-- start input box -->
                                                <label class="required">Total Amount</label>
                                                <input type="text" name="total_amount" id="total_amount" class="inputs_up form-control"
                                                       placeholder="Total Amount" onkeypress="return numeric_decimal_only(event);" readonly>
                                                <span id="demo7" class="validate_sign"> </span>
                                            </div><!-- end input box -->
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
        var employee = document.getElementById("employee").value;
        var datetime = document.getElementById("datetime").value;
        var cash_amount = document.getElementById("cash_amount").value;
        var credit_amount = document.getElementById("credit_amount").value;
        var card_amount = document.getElementById("card_amount").value;
        var total_amount = document.getElementById("total_amount").value;

        var flag_submit = true;
        var focus_once = 0;

        if (employee.trim() == "") {
            document.getElementById("demo1").innerHTML = "Required";
            if (focus_once == 0) {
                jQuery("#employee").focus();
                focus_once = 1;
            }
            flag_submit = false;
        } else {
            document.getElementById("demo1").innerHTML = "";
        }

        if (datetime.trim() == "") {
            document.getElementById("demo2").innerHTML = "Required";
            if (focus_once == 0) {
                jQuery("#datetime").focus();
                focus_once = 1;
            }
            flag_submit = false;
        } else {
            document.getElementById("demo2").innerHTML = "";
        }

        // if (cash_amount.trim() == "") {
        //     document.getElementById("demo3").innerHTML = "Required";
        //     if (focus_once == 0) {
        //         jQuery("#cash_amount").focus();
        //         focus_once = 1;
        //     }
        //     flag_submit = false;
        // } else {
        //     document.getElementById("demo3").innerHTML = "";
        // }


        if (total_amount.trim() == "" || total_amount.trim() == 0) {
            document.getElementById("demo7").innerHTML = "Must be greater than zero.";
            if (focus_once == 0) {
                jQuery("#total_amount").focus();
                focus_once = 1;
            }
            flag_submit = false;
        } else {
            document.getElementById("demo7").innerHTML = "";
        }

        return flag_submit;
    }

    function numeric_decimal_only(e) {
        return e.charCode === 0 || ((e.charCode >= 48 && e.charCode <= 57) || (e.charCode == 46 && document.getElementById("dip").value.indexOf('.') < 0));
    }

    function calculate_total() {

        var cash_amount = jQuery('#cash_amount').val();
        var credit_amount = jQuery('#credit_amount').val();
        var card_amount = jQuery('#card_amount').val();

        var total_amount = +cash_amount + +credit_amount + +card_amount;

        jQuery('#total_amount').val(total_amount);
    }

</script>

<script>
    jQuery(document).ready(function () {
        // Initialize select2
        jQuery("#employee").select2();

    });
</script>

</body>
</html>
