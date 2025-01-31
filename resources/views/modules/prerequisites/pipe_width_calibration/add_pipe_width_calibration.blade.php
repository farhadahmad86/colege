@extends('extend_index')

@section('content')
    <div class="row">


        <div
            class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">


            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">

                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 tabindex="-1" class="text-white get-heading-text">Pipe Width Calibration</h4>
                        </div>
                        <div class="list_btn">
                            <a tabindex="-1" class="btn list_link add_more_button" href="{{route('width_calibration_list')}}" role="button">
                                <l class="fa fa-list"></l>
                                view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->


                <form name="f1" class="f1" id="f1" action="{{route('submit_width_calibration')}}" method="post"
                      onsubmit="return checkForm()">
                    @csrf
                    <div class="row">
                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                            <div class="row">

                                <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">

                                            Board Type

                                        </label>
                                        <select tabindex="1" autofocus name="board_type" class="inputs_up form-control required" id="board_type" autofocus data-rule-required="true"
                                                data-msg-required="Please Enter Board Type Title">
                                            <option value="" selected disabled>Select Board Type</option>

                                            @foreach($board_types as $board_type)
                                                <option value="{{$board_type->bt_id}}" {{ $board_type->bt_id == old('board_type_name') ? 'selected="selected"' : ''
                                                }}>{{$board_type->bt_title}}</option>
                                            @endforeach

                                        </select>
                                        <span id="demo1" class="validate_sign"> </span>
                                    </div><!-- end input box -->

                                </div>

                                <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            Width From <span id="stock" class="validate_sign">(Last Value)</span>
                                        </label>
                                        <input tabindex="1" type="text" name="width_from" id="width_from" class="inputs_up form-control" placeholder="Width From" autofocus
                                               data-rule-required="true" data-msg-required="Please Enter Width From" autocomplete="off" value="{{ old('width_from') }}"
                                               onkeypress="return allow_only_number_and_decimals(this,event);"/>
                                        <span id="demo1" class="validate_sign"> </span>
                                        <span id="val_from" class="validate_sign"> </span>
                                        <input type="hidden" name="last_qty" id="last_qty">
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            Width To
                                        </label>
                                        <input tabindex="1" type="text" name="width_to" id="width_to" onkeydown="check_width_to()" class="inputs_up form-control" placeholder="Width To" autofocus
                                               data-rule-required="true" data-msg-required="Please Enter Width To" autocomplete="off" value="{{ old('width_to') }}"
                                               onkeypress="return allow_only_number_and_decimals(this,event);"/>
                                        <span id="demo1" class="validate_sign"> </span>
                                        <span id="val_to" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            Pipe Center Support
                                        </label>
                                        <input tabindex="1" type="text" name="width_support" id="width_support" class="inputs_up form-control" placeholder="Pipe Center Support" autofocus
                                               data-rule-required="true" data-msg-required="Please Enter Pipe Center Support" autocomplete="off" value="{{ old('width_support') }}"
                                               onkeypress="return allow_only_number_and_decimals(this,event);"/>
                                        <span id="demo1" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                            </div>


                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    <button tabindex="1" type="reset" name="cancel" id="cancel" class="cancel_button form-control">
                                        <i class="fa fa-eraser"></i> Cancel
                                    </button>
                                    <button tabindex="1" type="submit" name="save" id="save" class="save_button form-control"
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

            let board_type = document.getElementById("board_type"),
                last_qty = document.getElementById("last_qty"),
                width_from = document.getElementById("width_from"),
                width_to = document.getElementById("width_to"),
                width_support = document.getElementById("width_support"),

                validateInputIdArray = [
                    board_type.id,
                    width_from.id,
                    width_to.id,
                    width_support.id,
                ];

            let checkVald = validateInventoryInputs(validateInputIdArray);

            if (parseFloat(last_qty.value) < parseFloat(width_from.value) && parseFloat(width_from.value) < parseFloat(width_to.value)) {
                return checkVald;
            } if(parseFloat(last_qty.value) >= parseFloat(width_from.value)) {
                $('#val_from').html(" ");
                jQuery("#width_from").focus();

                $('#val_from').append('Width from not less from Last value! ');
                return false;
            }else if(parseFloat(width_from.value) >= parseFloat(width_to.value)){
                $('#val_from').html(" ");
                $('#val_to').html(" ");
                jQuery("#width_to").focus();

                jQuery("#val_to").append('Width To value not less from width from! ');
                return false;
            }else{
                alertMessageShow(width_from.id, '')
            }
            return false;
            // return validateInventoryInputs(validateInputIdArray);


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

        // alert(parseFloat(num).toFixed(2));
    </script>
    <script>
        $('#board_type').select2();
        jQuery("#refresh_board_type").click(function () {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "refresh_board_type",
                data: {},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    jQuery("#board_type").html(" ");
                    jQuery("#board_type").append(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });
    </script>
    <script>
        jQuery("#board_type").change(function () {

            var width = $(this).val();

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });


            jQuery.ajax({
                url: "width_pipe",
                data: {width: width},
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (data) {
                    console.log(data);

                    if (!Object.keys(data).length == 0) {
                        jQuery("#last_qty").val(data);
                        jQuery("#stock").html("");
                        jQuery("#stock").append('(' + data + ')');
                    } else {
                        jQuery("#last_qty").val(0);
                        jQuery("#stock").html("");
                        jQuery("#stock").append('(0)');
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });
    </script>
@endsection
