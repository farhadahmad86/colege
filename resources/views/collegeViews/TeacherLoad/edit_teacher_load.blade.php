@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Edit Teacher Load</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('teacher_load_list') }}"
                            role="button">
                            <l class="fa fa-list"></l>
                            view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <form name="f1" class="f1" id="f1" action="{{ route('update_teacher_load') }}" method="post"
                onsubmit="return checkForm()">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Teacher
                            </label>
                            <select tabindex=42 autofocus name="teacher_id" class="form-control" data-rule-required="true"
                                data-msg-required="Please Enter Teacher" id="teacher_id" placeholder="Select Teacher">
                                <option value="" selected>Select Teacher</option>
                                {{-- @foreach ($teachers as $teacher) --}}
                                <option value="{{ $teachers->user_id }}"
                                    {{ $teachers->user_id == $request->title ? 'selected' : '' }}>
                                    {{ $teachers->user_name }}
                                </option>
                                {{-- @endforeach --}}

                            </select>
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <label class="required">
                                Appointment Letter Load
                            </label>
                            <input tabindex="1" type="text" name="appointment_load" id="appointment_load"
                                class="inputs_up form-control" placeholder="Appointment Letter Load" autofocus
                                data-rule-required="true" data-msg-required="Please Enter Appointment Letter Load"
                                autocomplete="off" value="{{ $request->appointment_load }}" onkeyup="calculation()" />
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <label class="required">
                                Acctual Load
                            </label>
                            <input tabindex="1" type="text" name="acctual_load" id="acctual_load"
                                class="inputs_up form-control" placeholder="Acctual Load" autofocus
                                data-rule-required="true" data-msg-required="Please Enter Acctual Load" autocomplete="off"
                                value="{{ $request->acctual_load }}" onkeyup="calculation()" />
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <label class="required">
                                Attendance Load
                            </label>
                            <input tabindex="1" type="text" name="attendance_load" id="attendance_load"
                                class="inputs_up form-control" placeholder="Attendance Load" autofocus
                                data-rule-required="true" data-msg-required="Please Enter Attendance Load"
                                autocomplete="off" value="{{ $request->attendance_load }}" onkeyup="calculation()" />
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <label class="required">
                                <input type="checkbox" id="toggleExtraLoad" name="fixed_amount"
                                    value="{{ $fixed_amount->rc_id }}" {{ $request->rc_id ? 'checked' : '' }}>
                                Extra Load Amount
                            </label>
                            <input tabindex="1" type="text" name="extra_load_amount" id="extra_load_amount"
                                class="inputs_up form-control" placeholder="Extra Load Amount" autofocus
                                data-rule-required="true" data-msg-required="Please Enter Extra Load Amount"
                                autocomplete="off" value="{{ $request->tl_extra_load_amount }}"
                                @if (!$request->rc_id) style="display:none;" @endif />
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>
                    <input type="hidden" name="tl_id" value="{{ $request->tl_id }}">
                </div>
                <div class="form-group row">
                    <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                        <button tabindex="1" type="submit" name="save" id="save"
                            class="save_button btn btn-sm btn-success">
                            <i class="fa fa-floppy-o"></i> Save
                        </button>
                    </div>
                </div>
            </form>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            // Function to toggle the input field based on the checkbox state
            function toggleExtraLoadInput() {
                var extraLoadInput = $('#extra_load_amount');
                var toggleExtraLoad = $('#toggleExtraLoad');
                // var loadInput = $('#acctual_load');
                var loadInput = $('#attendance_load');

                // Toggle the display of the input field based on checkbox state
                extraLoadInput.css('display', toggleExtraLoad.prop('checked') ? 'none' : 'block');

                // Determine which value to set based on checkbox state
                var loadValue, fixedAmountValue, extraLoadAmountValue;

                if (toggleExtraLoad.prop('checked')) {
                    loadValue = loadInput.val();
                    fixedAmountValue = "1";
                    extraLoadAmountValue = null;
                } else {
                    loadValue = loadInput.val();
                    fixedAmountValue = null;
                    extraLoadAmountValue = extraLoadInput.val();
                }

                // Set the values in the form fields
                loadInput.val(loadValue);
                $('#fixed_amount').val(fixedAmountValue);
                extraLoadInput.val(extraLoadAmountValue);
            }

            toggleExtraLoadInput(); // Call the function when the document is ready

            // Attach the function to the change event of the checkbox
            $('#toggleExtraLoad').change(toggleExtraLoadInput);
        });
    </script>

    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let teacher_id = document.getElementById("teacher_id"),
            appointment_load = document.getElementById("appointment_load"),
                acctual_load = document.getElementById("acctual_load"),
                attendance_load = document.getElementById("attendance_load"),
                extra_load_amount = document.getElementById("extra_load_amount"),
                toggleExtraLoad = document.getElementById("toggleExtraLoad"),
                validateInputIdArray = [
                    teacher_id.id,
                    appointment_load.id,
                    acctual_load.id,
                    attendance_load.id,
                ];

            if (!toggleExtraLoad.checked) {
                // Checkbox is unchecked, so we validate the extra_load_amount
                validateInputIdArray.push(extra_load_amount.id);
            }

            let check = validateInventoryInputs(validateInputIdArray);

            if (check == true) {
                jQuery(".pre-loader").fadeToggle("medium");
            }

            return check;
        }

        function calculation() {
            var acctual_load = $('#acctual_load').val();
            var attendance_load = $('#attendance_load').val();
            if (!acctual_load) {
                $('#acctual_load').focus();
                $('#attendance_load').val('');
                alert('Enter the Actual Load First.');

            } else if (parseFloat(attendance_load) < parseFloat(acctual_load)) {
                $('#attendance_load').val('');
                $('#attendance_load').focus();
                alert('The Attendance Load must be greater or equal to the Actual Load.');
            }
        }
    </script>

    {{-- end of required input validation --}}
    <script type="text/javascript">
        $(window).keydown(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        $(document).ready(function() {
            $('#teacher_id').select2();
        });
    </script>
@endsection
