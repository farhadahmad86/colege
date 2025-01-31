
@extends('extend_index')

@section('content')

    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">



                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Update Pipe Length Calibration</h4>
                        </div>
                    </div>
                </div><!-- form header close -->

                <form name="f1" class="f1" id="f1" action="update_length_calibration" onsubmit="return checkForm()" method="post">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="length_calibration_id" value="{{ $request->length_calibration_id }}">
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
                                                <option value="{{$board_type->bt_id}}" {{ $board_type->bt_id == $request->board_type_id ? 'selected="selected"' : ''
                                                }}>{{$board_type->bt_title}}</option>
                                            @endforeach

                                        </select>
                                        <span id="demo1" class="validate_sign"> </span>
                                    </div><!-- end input box -->

                                </div>

                                <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            Length From <span id="stock" class="validate_sign">(Last Value)</span>
                                        </label>
                                        <input tabindex="1" type="text" name="length_from" id="length_from" class="inputs_up form-control" placeholder="Length From" autofocus
                                               data-rule-required="true" data-msg-required="Please Enter Length From" autocomplete="off" value="{{ $request->length_from }}" onkeypress="return
                                               allow_only_number_and_decimals(this,event);"/>
                                        <span id="demo1" class="validate_sign"> </span>
                                        <span id="val_from" class="validate_sign"> </span>
                                        <input type="hidden" name="last_qty" id="last_qty">
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            Length To
                                        </label>
                                        <input tabindex="1" type="text" name="length_to" id="length_to" class="inputs_up form-control" placeholder="Length To" autofocus
                                               data-rule-required="true" data-msg-required="Please Enter Length To" autocomplete="off" value="{{ $request->length_to }}" onkeypress="return
                                               allow_only_number_and_decimals(this,event);"/>
                                        <span id="demo1" class="validate_sign"> </span>
                                        <span id="val_to" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            Pipe Length Center Support
                                        </label>
                                        <input tabindex="1" type="text" name="pipe_center_support" id="pipe_center_support" class="inputs_up form-control" placeholder="Pipe Length Center Support" autofocus
                                               data-rule-required="true" data-msg-required="Please Enter Pipe Length Center Support" autocomplete="off" value="{{ $request->pipe_center_support }}"
                                               onkeypress="return
                                                allow_only_number_and_decimals(this,event);"/>
                                        <span id="demo1" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                            </div>

                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    <button type="button" name="cancel" id="cancel" class="cancel_button form-control">
                                        <i class="fa fa-eraser"></i> Cancel
                                    </button>
                                    <button type="submit" name="save" id="save" class="save_button form-control"
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

            let board_type = document.getElementById("board_type"),
                last_qty = document.getElementById("last_qty"),
                length_from = document.getElementById("length_from"),
                length_to = document.getElementById("length_to"),
                pipe_center_support = document.getElementById("pipe_center_support"),

                validateInputIdArray = [
                    board_type.id,
                    length_from.id,
                    length_to.id,
                    pipe_center_support.id,
                ];

            let checkVald = validateInventoryInputs(validateInputIdArray);

            if (parseFloat(last_qty.value) < parseFloat(length_from.value) && parseFloat(length_from.value) < parseFloat(length_to.value)) {
                return checkVald;
            } if(parseFloat(last_qty.value) >= parseFloat(length_from.value)) {
                $('#val_from').html(" ");
                jQuery("#length_from").focus();

                $('#val_from').append('Length from not less from Last value! ');
                return false;
            }else if(parseFloat(length_from.value) >= parseFloat(length_to.value)){
                $('#val_from').html(" ");
                $('#val_to').html(" ");
                jQuery("#length_to").focus();

                jQuery("#val_to").append('Length To value not less from width from! ');
                return false;
            }else{
                jQuery("#val_to").append('');
            }
            return false;
            // return validateInventoryInputs(validateInputIdArray);


        }
    </script>
    {{-- end of required input validation --}}
    <script type="text/javascript">

        function form_validation()
        {
            var board_material_name  = document.getElementById("board_material_name").value;
            var remarks  = document.getElementById("remarks").value;

            var flag_submit = true;
            var focus_once = 0;

            if(board_material_name.trim() == "")
            {
                document.getElementById("demo1").innerHTML = "Required";
                if (focus_once == 0) { jQuery("#board_material_name").focus(); focus_once = 1;}
                flag_submit = false;
            }else{
                document.getElementById("demo1").innerHTML = "";
            }

            // if(remarks.trim() == "")
            // {
            //     document.getElementById("demo2").innerHTML = "Required";
            //     if (focus_once == 0) { jQuery("#remarks").focus(); focus_once = 1;}
            //     flag_submit = false;
            // }else{
            //     document.getElementById("demo2").innerHTML = "";
            // }
            return flag_submit;
        }
    </script>
    <script>
        $(document).ready(function () {
            $('#board_type').select2();
            length_update_pipe('{{$request->board_type_id}}');
        });
    </script>
    <script>
        jQuery("#board_type").change(function () {
            var width = $(this).val();
            length_update_pipe(width);
        });

        function length_update_pipe(width) {

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });


            jQuery.ajax({
                url: "length_update_pipe",
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
        }
    </script>
@endsection

