@extends('extend_index')

@section('content')
    <style>
        legend small {
            display: block;
            font-size: 12px;
        }
    </style>
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Custom Voucher</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('custom_voucher_list') }}"
                           role="button">
                            <l class="fa fa-list"></l>
                            view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->

            <form name="f1" class="f1" id="f1" action="{{ route('submit_custom_voucher') }}" method="post"
                  onsubmit="return checkForm()">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Issue Date
                            </label>
                            <input tabindex="6" type="text" name="issue_date" id="issue_date"
                                   class="inputs_up form-control datepicker1" data-rule-required="true"
                                   data-msg-required="Please Enter Issue Date" autocomplete="off"
                                   placeholder="Issue Date ......"/>
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Due Date
                            </label>
                            <input tabindex="6" type="text" name="due_date" id="due_date"
                                   class="inputs_up form-control datepicker1" data-rule-required="true"
                                   data-msg-required="Please Enter Due Date" autocomplete="off"
                                   placeholder="Due Date ......"/>
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Class
                            </label>
                            <select tabindex=42 autofocus name="class" class="form-control" data-rule-required="true"
                                    data-msg-required="Please Enter Class" id="class">
                                <option value="" disabled selected>Select Class</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->class_id }}"
                                        {{ $class->class_id == old('class') ? 'selected' : '' }}>
                                        {{ $class->class_name }}
                                    </option>
                                @endforeach
                            </select>
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Section
                            </label>
                            <select tabindex="2" name="section" class="form-control required" id="section"
                                    data-rule-required="true" data-msg-required="Please Enter Section">
                            </select>
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Components
                            </label>
                            <select tabindex=42 autofocus name="component[]" class="form-control" data-rule-required="true"
                                    data-msg-required="Please Enter Component" id="component" multiple>
                                {{--                                <option value="" disabled>Select Component</option>--}}
                                @foreach ($components as $component)
                                    <option value="{{ $component->sfc_id }}">
                                        {{ $component->sfc_name }} ({{ number_format($component->sfc_amount,2) }})
                                    </option>
                                @endforeach
                            </select>
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>

                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label>
                                Total Students
                            </label>
                            <input tabindex="2" type="hidden" name="total_students"
                                   id="total_students" class="inputs_up form-control" autocomplete="off"
                                   value="" data-rule-required="true"
                                   data-msg-required="Section students must be Greater than 0"
                                   placeholder="">
                            <span id="total_std" class="total_std"
                                  style="margin-left: 50px; color: red; font-size: 40px">
                            </span>

                        </div>
                    </div>
                </div>
                {{--                check box code start--}}
                <div class="row">
                    <div class="col-sm-4">
{{--                        <legend>Students List</legend>--}}
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="checkall1" class="check3"> Check All Students
                            </label>
                        </div>
{{--                        <div class="checkbox">--}}
{{--                            <input type="checkbox" id="checkall1" class="btn btn-link" value="Un/check All">--}}
{{--                            <input type="checkbox"  class="form-check-input" value="Un/check All">--}}
{{--                        </div>--}}
                    </div>
                </div>
                <div class="row" id="checkbox">

                </div>
                {{--                check box code end--}}
                <div class="form-group row">
                    <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                        <button tabindex="1" type="reset" name="cancel" id="cancel"
                                class="cancel_button btn btn-sm btn-secondary">
                            <i class="fa fa-eraser"></i> Cancel
                        </button>
                        <button tabindex="1" type="submit" name="save" id="save"
                                class="save_button btn btn-sm btn-success">
                            <i class="fa fa-floppy-o"></i> Save
                        </button>
                    </div>
                </div>
            </form>
            <span id="show_reg_error" class="text-danger" style="font-size: 18px"></span>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->
@endsection

@section('scripts')

    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let issue_date = document.getElementById("issue_date"),
                due_date = document.getElementById("due_date"),
                class_id = document.getElementById("class"),
                section = document.getElementById("section"),
                component = document.getElementById("component"),
                total_students = document.getElementById("total_students"),
                validateInputIdArray = [
                    issue_date.id,
                    due_date.id,
                    class_id.id,
                    section.id,
                    component.id,
                    total_students.id,
                ];
            let check = validateInventoryInputs(validateInputIdArray);
            if (check == true) {
                jQuery(".pre-loader").fadeToggle("medium");
            }
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    @if (Session::get('already_generated'))
        <script>
            var students = '{{ Session::get('already_generated') }}';
            if (students != '') {
                $('#show_reg_error').html('This Registration number voucher already generated ' + students);
            }

        </script>
    @endif
    {{-- end of required input validation --}}
    <script type="text/javascript">
        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        $(document).ready(function () {
            $('#class').select2();
            $('#section').select2();
            $('#component').select2();
        });

    </script>
    <script>
        $('#class').change(function () {
            var class_id = $(this).val();
            $.ajax({
                url: '/get_groups',
                type: 'get',
                datatype: 'text',
                data: {
                    'class_id': class_id
                },
                success: function (data) {

                    var groups = '<option selected disabled hidden>Choose Groups</option>';
                    var sections = '<option selected disabled hidden>Choose Section</option>';

                    $.each(data.section, function (index, items) {

                        sections +=
                            `<option value="${items.cs_id}"> ${items.cs_name} </option>`;


                    });
                    $('#section').html(sections);
                }
            })
        });


        jQuery("#section").change(function () {
            let section_id = $(this).val();
            let class_id = $('#class').val();


            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_students_for_custom",
                data: {
                    section_id: section_id,
                    class_id: class_id,
                },
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (data) {
                    console.log(data);

                    console.log(data.students.length);
                    jQuery("#total_students_alert").html(" ");
                    jQuery("#total_std").html(" ");
                    jQuery("#total_students").val("");
                    jQuery("#total_std").append(data.students.length);
                    if (data.students.length > 0) {
                        jQuery("#total_students").val(data.students.length);
                    }
                    var checkbox = '';
                    $.each(data.students, function (index, items) {
                        checkbox += `
                    <div class="col-sm-2">
                        <div class="checkbox">
                            <label>
                            <input type="checkbox" name="students[]" class="check1" value="${items.id}"> ${items.full_name}
                        </label>
                        </div>
                    </div>`
                    });
                    $('#checkbox').html(checkbox);

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });
    </script>
    <script>
        // v1
        function checkAll1() {

            var inputs = document.querySelectorAll('.check1');
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].checked = true;
            }

            this.onclick = uncheckAll1;
        }

        function uncheckAll1() {
            var inputs = document.querySelectorAll('.check1');
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].checked = false;
            }

            this.onclick = checkAll1; //function reference to original function
        }

        var el = document.getElementById("checkall1"); //let for ES6 aficionados
        el.onclick = checkAll1; //again, function reference, no ()


    </script>
@endsection
