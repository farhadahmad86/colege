@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Create Teacher Load</h4>
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
            <form name="f1" class="f1" id="f1" action="{{ route('store_teacher_load') }}" method="post"
                onsubmit="return checkForm()">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <label class="required">
                                Teacher
                            </label>
                            <select tabindex="42" name="teacher_id" class="form-control" data-rule-required="true"
                                data-msg-required="Please Enter Teacher" id="teacher_id" placeholder="Select Teacher">
                                <option value="">Select Teacher</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->user_id }}"
                                        {{ $teacher->user_id == old('teacher_id') ? 'selected' : '' }}>
                                        {{ $teacher->user_name }}
                                    </option>
                                @endforeach
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
                                autocomplete="off" value="{{ old('appointment_load') }}"/>
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
                                value="{{ old('acctual_load') }}" onkeyup="calculation()" />
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
                                autocomplete="off" value="{{ old('attendance_load') }}" onkeyup="calculation()" />
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <label class="required">
                                <input type="checkbox" id="toggleExtraLoad" name="fixed_amount" checked
                                    value="{{ $fixed_amount->rc_id }}">
                                Extra Load Amount
                            </label>
                            <input tabindex="1" type="text" name="extra_load_amount" id="extra_load_amount"
                                class="inputs_up form-control" placeholder="Extra Load Amount" autofocus
                                data-rule-required="true" data-msg-required="Please Enter Extra Load Amount"
                                autocomplete="off" value="{{ old('extra_load_amount') }}" style="display: none;" />
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>
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
    </script>

    {{-- end of required input validation --}}
    <script>
        // Add an event listener to the checkbox
        document.getElementById('toggleExtraLoad').addEventListener('change', function() {
            var extraLoadInput = document.getElementById('extra_load_amount');
            // Toggle the display of the input field based on checkbox state
            extraLoadInput.style.display = this.checked ? 'none' : 'block';
            // Clear the input value when hiding it
            if (this.checked) {
                extraLoadInput.value = '';
            }
        });

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
