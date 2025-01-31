@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Edit Assign Attendance</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('assign_coordinator_list') }}"
                            role="button">
                            <l class="fa fa-list"></l>
                            view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->


            <form name="f1" class="f1" id="f1" action="{{ route('update_assign_coordinator') }}"
                method="post" onsubmit="return checkForm()">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Coordinators
                            </label>
                            <select tabindex="1" autofocus name="coordinator_id" class="form-control required"
                                id="coordinator_id" autofocus data-rule-required="true"
                                data-msg-required="Please Select Coordinators">

                                <option value="">Select Coordinators</option>
                                @foreach ($allusers as $user)
                                    <option value="{{ $user->user_id }}"
                                        {{ $user->user_id == $request->title ? 'selected' : '' }}>
                                        {{ $user->user_name }}
                                    </option>
                                @endforeach
                            </select>
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Class
                            </label>
                            <select tabindex=42 autofocus name="class_id" class="form-control" data-rule-required="true"
                                data-msg-required="Please Enter Class" id="class_id"
                                placeholder="Select Class">
                                <option value="" disabled>Select Class</option>
                                @foreach ($allclasses as $allclass)
                                    <option value="{{ $allclass->class_id }}"
                                        {{ $allclass->class_id,  $request->class_id ? 'selected' : '' }}>
                                        {{ $allclass->class_name }}
                                    </option>
                                @endforeach
                            </select>
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Section
                            </label>
                            <select tabindex=42 autofocus name="section_id[]" class="form-control" data-rule-required="true"
                                data-msg-required="Please Enter Section" id="section_id" multiple
                                placeholder="Select Section">
                                <option value="" disabled>Select Section</option>
                                @foreach ($allsections as $allsection)
                                    @php
                                        $sections = explode(',', $request->section_id);
                                    @endphp
                                    <option value="{{ $allsection->cs_id }}"
                                        {{ in_array($allsection->cs_id, $sections) ? 'selected' : '' }}>
                                        {{ $allsection->cs_name }}
                                    </option>
                                @endforeach
                            </select>
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="ac_id" value="{{ $request->ac_id }}">
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
            let coordinator_id = document.getElementById("coordinator_id"),
                dep_id = document.getElementById("dep_id"),
                teacher_id = document.getElementById("teacher_id"),
                section_id = document.getElementById("section_id"),
                validateInputIdArray = [
                    coordinator_id.id,
                    dep_id.id,
                    teacher_id.id,
                    section_id.id,
                ];
            let check = validateInventoryInputs(validateInputIdArray);

            if (check == true) {
                jQuery(".pre-loader").fadeToggle("medium");
            }
            return validateInventoryInputs(validateInputIdArray);
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
            //     $('input[type="radio"]').click(function () {
            //     if ($(this).attr("id") === "annual") {
            //         $('.semester-div').hide();
            //     } else if ($(this).attr("id") === "semester") {
            //         $('.semester-div').show();
            //     }
            // });
            $('#coordinator_id').select2();
            $('#section_id').select2();
            $('#class_id').select2();
            // get_teacher({!! $request->dep_id !!});
        });
        $('#class_id').change(function() {
            var class_id = $(this).val();
            // alert(class_id);
            $.ajax({
                url: '/get_section',
                type: 'get',
                datatype: 'text',
                data: {
                    'class_id': class_id
                },
                success: function(data) {
                    console.log(data);
                    var section = '<option value="">Choose Section</option>';
                    $.each(data, function(index, items) {

                        section +=
                            `<option value="${items.cs_id}"> ${items.cs_name} </option>`;


                    });
                    $('#section_id').html(section);
                }
            })
        });
        // function get_teacher(dep_id) {
        //     var teacher_id = "{!! $request->teacher_id !!}";
        //     var teacherArray = teacher_id.split(",");

        //     $.ajax({
        //         url: '/get_all_teachers',
        //         type: 'get',
        //         datatype: 'json',
        //         data: {
        //             'dep_id': dep_id
        //         },
        //         success: function(data) {
        //             var teacher = '<option value="">Choose teacher</option>';

        //             $.each(data, function(index, items) {
        //                 var selected = teacherArray.includes(items.user_id) ? true : false;
        //                 $(this).attr('selected', selected);
        //                 teacher +=
        //                     `<option value="${items.user_id}" ${selected ? 'selected' : ''}> ${items.user_name} </option>`;
        //             });

        //             $('#teacher_id').html(teacher);

        //             if (teacherArray.length > 0) {
        //                 $('#teacher_id').val(teacherArray);
        //             }
        //         }
        //     });
        // }

        // $('#dep_id').change(function() {
        //     var dep_id = $(this).val();
        //     get_teacher(dep_id);
        // })
    </script>
@endsection
