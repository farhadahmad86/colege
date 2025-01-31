@extends('extend_index')

@section('content')
    <style>
        .popover-body {
            background-color: white !important;
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"
        integrity="sha512-Tn2m0TIpgVyTzzvmxLNuqbSJH3JP8jm+Cy3hvHrW7ndTDcJ1w5mBiksqDBb8GpE2ksktFvDB/ykZ0mDpsZj20w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" defer="defer"></script>
    <form name="f1" class="f1" id="f1" action="{{ route('store_other_attendance') }}" method="post"
        onsubmit="return checkForm()">
        <div class="row">
            <div id="main_bg" class="container-fluid search-filter form-group form_manage">
                <div class="form_header">
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Other Attendance</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <a class="add_btn list_link add_more_button" href="{{ route('other_attendance_list') }}"
                                role="button">
                                <i class="fa fa-list"></i> view list
                            </a>
                        </div>
                    </div>
                </div>
                <div id="invoice_con">
                    <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx">
                        @csrf
                        <div class="row">
                            <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <div class="custom-control custom-radio mb-10 mt-1">
                                        <input tabindex="1" type="radio" name="attendance_status"
                                            class="custom-control-input attendance_status" id="attendance_status1"
                                            value="1" checked>
                                        <label class="custom-control-label" for="attendance_status1">
                                            Regular
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio mb-10 mt-1">
                                        <input tabindex="2" type="radio" name="attendance_status"
                                            class="custom-control-input attendance_status" id="attendance_status2"
                                            value="2">
                                        <label class="custom-control-label" for="attendance_status2">
                                            Gazetted
                                        </label>
                                    </div>
                                    <span id="marital_error_msg" class="validate_sign"> </span>
                                </div><!-- end input box -->
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <label class="required">
                                        Date
                                    </label>
                                    <input type="text" tabindex="3" name="date" id="date"
                                        class="inputs_up form-control date-picker" placeholder="Enter Date"
                                        data-rule-required="true" data-msg-required="Please Enter Date" autocomplete="off"
                                        value="{{ old('date') }}" />
                                    <span id="demo1" class="validate_sign"> </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <label class="required">
                                        Department
                                    </label>
                                    <select class="form-control form-control-sm" name="dep_id" id="dep_id"
                                        data-rule-required="true" data-msg-required="Please Enter Department">
                                        <option value="0" selected disabled>Select Department</option>
                                        @foreach ($alldepartments as $alldepartment)
                                            <option value="{{ $alldepartment->dep_id }}">
                                                {{ $alldepartment->dep_title }}</option>
                                        @endforeach
                                    </select>
                                    <span id="role_error_msg" class="validate_sign"> </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table start -->
                <div class="pro_tbl_con">
                    <div class="table-responsive" id="printTable">
                        <table class="table table-bordered table-sm mt-3" id="category_dynamic_table">
                            <!-- product table box start -->

                            <thead>
                                <tr>
                                    <th class="text-center tbl_txt_5">Sr#</th>
                                    <th class="text-center tbl_txt_5">Department</th>
                                    <th class="text-center tbl_txt_5">Staff Name</th>
                                    <th class="text-center tbl_txt_5">P</th>
                                    <th class="text-center tbl_txt_5">A</th>
                                    <th class="text-center tbl_txt_5">L</th>
                                    <th class="text-center tbl_txt_5">S.L</th>
                                    <th class="text-center tbl_txt_40">Leave Remarks</th>
                                </tr>
                            </thead>
                            <tbody id="table_body">

                            </tbody>
                        </table>
                    </div>
                    <button tabindex="1" type="submit" name="save" id="save"
                        class="save_button btn btn-sm btn-success"> Save
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.4/dayjs.min.js"
        integrity="sha512-Ot7ArUEhJDU0cwoBNNnWe487kjL5wAOsIYig8llY/l0P2TUFwgsAHVmrZMHsT8NGo+HwkjTJsNErS6QqIkBxDw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" defer="defer"></script>

    <script src="{{ asset('public/js/timepicker-bs4.js') }}" defer="defer"></script>
    {{-- required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let dep_id = document.getElementById("dep_id"),
                date = document.getElementById("date"),
                validateInputIdArray = [
                    dep_id.id,
                    date.id,
                ];
            let check = validateInventoryInputs(validateInputIdArray);

            if (check == true) {
                jQuery(".pre-loader").fadeToggle("medium");
            }
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script>
        $(document).ready(function() {

            $('#dep_id').select2();
        });
    </script>
    <script>
        $('#dep_id').change(function() {
            var dep_id = $(this).val();
            var attendance_status = $('input[name="attendance_status"]:checked').val();
            var date = $('#date').val();
            if (date != '' && dep_id != '') {
                get_employee(dep_id, attendance_status, date);
            } else {
                $('#dep_id').select2('destroy');
                $('#dep_id option[value="' + 0 + '"]').prop('selected', true);
                $('#dep_id').select2();
                Swal.fire({
                    icon: 'error',
                    title: 'Please Select Date First',
                    // text: 'Please Select Month First And Enter Days And Then Select Department!',
                    timer: 5000
                })
            }
        });


        function get_employee(dep_id, attendance_status, date) {
            // $('#dep_id').change(function() {

            jQuery(".pre-loader").fadeToggle("medium");
            console.log(attendance_status, dep_id)


            $.ajax({
                url: '/get_all_employees',
                type: 'get',
                datatype: 'json', // Change datatype to 'json'
                data: {
                    'dep_id': dep_id,
                    'attendance_status': attendance_status,
                    'date': date,
                },
                success: function(data) {

                    console.log(data)
                    if (data.attendance == 0) {
                        var sr = 1;
                        var selectBoxHTML = '';
                        $.each(data.employee, function(index, item) {
                            selectBoxHTML += `<tr>
                        <td>${ sr++ } </td>
                        <td>${item.dep_title } </td>
                        <td><input type="hidden"
                        name="teacher_id[]" id="teacher_id" value="${item.user_id}">${ item.user_name }
                        </td>
                        <td><input type="radio" name="attendance[${index}]" id="P" value="P"
                        checked> </td>
                        <td><input type="radio"
                        name="attendance[${index}]" id="A" value="A">
                        </td>
                        <td><input type="radio"
                        name="attendance[${index}]" id="L" value="L">
                        </td>
                        <td><input type="radio"
                        name="attendance[${index}]" id="S.L" value="S.L">
                        </td>
                        <td><input type="text" name="leave_remarks[]"
                        style="width:100%"></td>
                    </tr>`;
                        });
                        $('#table_body').html(selectBoxHTML);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Attendance of this Department  for this date  is already Marked!',
                            // text: 'Attendance of this Department  for this date  is already Marked!',
                            timer: 5000
                        })

                    }
                }
            });


            jQuery(".pre-loader").fadeToggle("medium");
            // });
        }
        // Rest of your code...
        // $('.attendance_status').change(function() {
        //     // Set the flag to true when attendance status changes
        //     attendanceStatusChanged = true;
        // });
    </script>
    <script>
        $('#date').click(function() {
            // Set the flag to true when date input is clicked
            dateInputClicked = true;
            $('#dep_id').select2('destroy');
            $('#dep_id option[value="' + 0 + '"]').prop('selected', true);
            // Initialize select2 again
            $('#dep_id').select2();
            jQuery("#table_body").html('');
        });
        $('.attendance_status').click(function() {
            // Clear the table_body
            $('#table_body').empty();
            $('#dep_id').select2('destroy');
            $('#dep_id option[value="' + 0 + '"]').prop('selected', true);
            $('#dep_id').select2();
            $('#dep_id').val('');
            $('#date').val('');
            // Initialize select2 again
        });
    </script>
@endsection
