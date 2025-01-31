@extends('extend_index')

@section('content')
    <div class="row">


        <div
            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">


            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">


                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Assign Surveyor Username </h4>
                        </div>
                        <div class="list_btn">
                            <a class="btn list_link add_more_button" href="{{route('assign_username_list')}}" role="button">
                                <l class="fa fa-list"></l>
                                view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <form name="f1" class="f1" id="f1" action="{{route('store')}}" method="post"
                      onsubmit="return checkForm()">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="invoice_row">

                                <div class="invoice_col basis_col_20">
                                    <!-- invoice column start -->
                                    <div class="invoice_col_bx">
                                        <!-- invoice column box start -->
                                        <div class="required invoice_col_ttl">
                                            <!-- invoice column title start -->

                                            Username
                                        </div><!-- invoice column title end -->
                                        <div class="invoice_col_input">
                                            <!-- invoice column input start -->
                                            <div class="invoice_col_short">
                                                <!-- invoice column short start -->

                                            </div><!-- invoice column short end -->
                                            <select tabindex="1" autofocus name="username[]" id="username"
                                                    data-rule-required="true" data-msg-required="Please Enter Name"
                                                    class="inputs_up form-control auto-select" multiple
                                            >
{{--                                                <option value="" selected disabled>--}}
{{--                                                    Select Username--}}
{{--                                                </option>--}}
                                                @foreach ($username as $user)
                                                    <option
                                                        value="{{ $user->srv_id }}">{{ $user->srv_name }}</option>
                                                @endforeach
                                            </select>
                                        </div><!-- invoice column input end -->
                                    </div><!-- invoice column box end -->
                                </div><!-- invoice column end -->


                                <div class="invoice_col basis_col_20"><!-- invoice column start -->
                                    <div class="invoice_col_bx"><!-- invoice column box start -->
                                        <div class=" invoice_col_ttl"><!-- invoice column title start -->
                                            Select Employee / Vendor
                                        </div><!-- invoice column title end -->
                                        <div class="invoice_col_txt inline_radio"><!-- invoice column input start -->
                                            <div class="radio">
                                                <label>
                                                    <input tabindex="2" type="radio" name="surveyor_type" class="invoice_type" id="employee_show" value="employee" checked>
                                                    Employee
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input tabindex="3" type="radio" name="surveyor_type" class="invoice_type" id="vendor" value="vendor">
                                                    Vendors
                                                </label>
                                            </div>
                                        </div><!-- invoice column input end -->
                                    </div><!-- invoice column box end -->
                                </div><!-- invoice column end -->
                                <div class="invoice_col basis_col_20" id="employee_div">
                                    <!-- invoice column start -->
                                    <div class="invoice_col_bx">
                                        <!-- invoice column box start -->
                                        <div class="required invoice_col_ttl">
                                            <!-- invoice column title start -->

                                            Employee
                                        </div><!-- invoice column title end -->
                                        <div class="invoice_col_input">
                                            <!-- invoice column input start -->

                                            <div class="invoice_col_short">
                                                <!-- invoice column short start -->

                                            </div><!-- invoice column short end -->
                                            <select tabindex="4" name="employee"
                                                    id="employee"
                                                    data-rule-required="true" data-msg-required="Please Enter Employee"
                                                    class="inputs_up form-control"
                                            >
                                                <option value="" selected disabled>
                                                    Select Employee
                                                </option>
                                                @foreach($employees as $supervisor)
                                                    <option value="{{ $supervisor->user_id }}">{{ $supervisor->user_name }}  </option>
                                                @endforeach
                                            </select>

                                        </div><!-- invoice column input end -->
                                    </div><!-- invoice column box end -->
                                </div><!-- invoice column end -->

                                <div class="invoice_col basis_col_20" id="supplier_div">
                                    <!-- invoice column start -->
                                    <div class="invoice_col_bx">
                                        <!-- invoice column box start -->
                                        <div class="required invoice_col_ttl">
                                            <!-- invoice column title start -->

                                            Supplier
                                        </div><!-- invoice column title end -->
                                        <div class="invoice_col_input">
                                            <!-- invoice column input start -->

                                            <div class="invoice_col_short">
                                                <!-- invoice column short start -->

                                            </div><!-- invoice column short end -->
                                            <select name="supplier"
                                                    id="supplier"
                                                    class="inputs_up form-control"
                                                    data-rule-required="true" data-msg-required="Please Enter Supplier"
                                            >
                                                <option value="" selected disabled>
                                                    Select Supplier
                                                </option>
                                                @foreach($suppliers as $supplier)
                                                    <option value="{{ $supplier->account_uid }}">{{ $supplier->account_name }}  </option>
                                                @endforeach
                                            </select>

                                        </div><!-- invoice column input end -->
                                    </div><!-- invoice column box end -->
                                </div><!-- invoice column end -->

                            </div>


                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    <button tabindex="5" type="reset" name="cancel" id="cancel" class="cancel_button form-control">
                                        <i class="fa fa-eraser"></i> Cancel
                                    </button>
                                    <button tabindex="6" type="submit" name="save" id="save" class="save_button form-control"
                                        {{--                                            onclick="return form_validation()"--}}
                                    >
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

@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            var type =$("input:radio[name=surveyor_type]:checked").val();

            if(type =='employee'){
                let username = document.getElementById("username"),
                    employee = document.getElementById("employee"),
                    validateInputIdArray = [
                        username.id,
                        employee.id,
                    ];
                return validateInventoryInputs(validateInputIdArray);

            }else{
                let username = document.getElementById("username"),
                    supplier = document.getElementById("supplier"),
                    validateInputIdArray = [
                        username.id,
                        supplier.id,
                    ];
                return validateInventoryInputs(validateInputIdArray);
            }

        }
    </script>
    {{-- end of required input validation --}}
    <script type="text/javascript">

        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });


        $('#employee_show').click(function () {
            $('#employee_div').show();
            $('#supplier_div').hide();
            jQuery("#supplier").select2("destroy");
            jQuery('#supplier option[value="' + "" + '"]').prop('selected', true);
            jQuery("#supplier").select2();

        });
        $('#vendor').click(function () {
            $('#employee_div').hide();
            $('#supplier_div').show();
            jQuery("#employee").select2("destroy");
            jQuery('#employee option[value="' + "" + '"]').prop('selected', true);
            jQuery("#employee").select2();
        });

        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#username").select2();
            jQuery("#employee").select2();
            jQuery("#supplier").select2();
            $('#employee_div').show();
            $('#supplier_div').hide();
        });


        // function form_validation() {
        //     var region_name = document.getElementById("region_name").value;
        //     var remarks = document.getElementById("remarks").value;
        //
        //     var flag_submit = true;
        //     var focus_once = 0;
        //
        //     if (region_name.trim() == "") {
        //         document.getElementById("demo1").innerHTML = "Required";
        //         if (focus_once == 0) {
        //             jQuery("#region_name").focus();
        //             focus_once = 1;
        //         }
        //         flag_submit = false;
        //     } else {
        //         document.getElementById("demo1").innerHTML = "";
        //     }
        //
        //     // if(remarks.trim() == "")
        //     // {
        //     //     document.getElementById("demo2").innerHTML = "Required";
        //     //     if (focus_once == 0) { jQuery("#remarks").focus(); focus_once = 1;}
        //     //     flag_submit = false;
        //     // }else{
        //     //     document.getElementById("demo2").innerHTML = "";
        //     // }
        //     return flag_submit;
        // }

        // // defining flags
        // var isCtrl = false;
        // var isShift = false;
        // var f9 = false;
        // // helpful function that outputs to the container
        // function log(str) {
        //     // $("#container").html($("#container").html() + str + " ");
        //     alert(str);
        //     isCtrl = false;
        //     isShift = false;
        //     f9 = false;
        // };
        // // the magic :)
        // $(document).ready(function() {
        //
        //     log("Ready. Press Ctrl+Shift+F9!");
        //
        //     // action on key up
        //     // $(document).keyup(function(e) {
        //     //
        //     //     if(e.which == 17) {
        //     //         isCtrl = false;
        //     //     }
        //     //     if(e.which == 16) {
        //     //         isShift = false;
        //     //     }
        //     //     if(e.which == 120) {
        //     //         f9 = false;
        //     //     }
        //     //     alert(f9);
        //     //     alert(isCtrl);
        //     //     alert(isShift);
        //     //
        //     // });
        //
        //     // action on key down
        //     $(document).keydown(function(e) {
        //         if (e.ctrlKey){
        //             window.open('http://www.google.com','_blank')
        //         }
        //         // if(e.which == 17) {
        //         //     isCtrl = true;
        //         // }
        //         // if(e.which == 16) {
        //         //     isShift = true;
        //         // }
        //         // if(e.which == 120) {
        //         //     f9 = true;
        //         // }
        //         // if(f9 && isCtrl && isShift) {
        //         //
        //         //     log("------- catching Ctrl+Shift+F9");
        //         // }
        //     });
        //
        // });
        //
        // var num = '45.444545468546354';
        // alert(parseFloat(num).toFixed(2));
    </script>

@endsection


