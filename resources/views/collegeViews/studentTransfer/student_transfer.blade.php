@extends('extend_index')

@section('content')

    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Student Transfer List</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('student_transfer_list') }}"
                           role="button">
                            <i class="fa fa-list"></i> view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h5>Transfer From</h5>
                </div>
            </div>

            <table class="" style="width:100%">
                <thead>
                <th>Registration</th>
                <th>Name</th>
                <th>Class</th>
                <th>Section</th>
                <th>Group</th>
                <th>Branch</th>
                </thead>
                <tbody>
                <td>{{$student->registration_no}}</td>
                <td>{{$student->full_name}}</td>
                <td>{{$student->class_name}}</td>
                <td>{{$student->cs_name}}</td>
                <td>{{$student->ng_name}}</td>
                <td>{{$student->branch_name}}</td>
                </tbody>
            </table>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h5>Transfer To</h5>
                </div>
            </div>
            <form name="f1" class="f1" id="f1" action="{{ route('submit_student_transfer') }}" onsubmit="return checkForm()" method="post">
                @csrf

                <input type="hidden" name="student_id" value="{{$student->id}}">
                <input type="hidden" name="reg_no" value="{{$student->registration_no}}">
                <div class="row">

                    <div class="input_bx form-group col-lg-3 col-md-3 col-sm-12 col-xs-12"><!-- start input box -->
                        <label class="required">
                            Branch
                        </label>
                        <select tabindex=1 autofocus name="branch" class="inputs_up form-control" id="branch" autofocus
                                data-rule-required="true" data-msg-required="Please Enter Branch">
                            <option value="">Branch</option>
                            @foreach($branches as $branch)
                                <option
                                    value="{{$branch->branch_id}}"{{$branch->branch_id == $student->branch_id ? 'selected="selected"' : ''}} >{{$branch->branch_name}}</option>
                            @endforeach
                        </select>
                        <span id="demo1" class="validate_sign"> </span>
                    </div><!-- end input box -->

                    <div class="input_bx form-group col-lg-3 col-md-3 col-sm-12 col-xs-12"><!-- start input box -->
                        <label class="required">
                            Class
                        </label>
                        <select tabindex=1 autofocus name="class" class="inputs_up form-control" id="class"
                                data-rule-required="true" data-msg-required="Please Enter Class">
                            <option value="">Class</option>
                            @foreach($classes as $class)
                                <option
                                    value="{{$class->class_id}}"{{$class->class_id == $student->class_id ? 'selected="selected"' : ''}} >{{$class->class_name}}</option>
                            @endforeach
                        </select>
                        <span id="demo1" class="validate_sign"> </span>
                    </div><!-- end input box -->

                    <div class="input_bx form-group col-lg-3 col-md-3 col-sm-12 col-xs-12"><!-- start input box -->
                        <label class="required">
                            Section
                        </label>
                        <select tabindex=1 name="section" class="inputs_up form-control" id="section"
                                data-rule-required="true" data-msg-required="Please Enter Section">
                            <option value="">Section</option>
                        </select>
                    </div><!-- end input box -->
                    <div class="input_bx form-group col-lg-3 col-md-3 col-sm-12 col-xs-12"><!-- start input box -->
                        <label class="required">
                            Group
                        </label>
                        <select tabindex=1 name="group" class="inputs_up form-control" id="group"
                                data-rule-required="true" data-msg-required="Please Enter Group">
                            <option value="">Group</option>
                        </select>
                    </div><!-- end input box -->

                    <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                        <button tabindex="4" type="reset" name="cancel" id="cancel" class="cancel_button btn btn-sm btn-secondary">
                            <i class="fa fa-eraser"></i> Cancel
                        </button>
                        <button tabindex="5" type="submit" name="save" id="save" class="save_button btn btn-sm btn-success">
                            <i class="fa fa-floppy-o"></i> Save
                        </button>
                    </div>
                </div> <!--  main row ends here -->
            </form>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->

@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let branch = document.getElementById("branch"),
                class_id = document.getElementById("class"),
                section = document.getElementById("section"),
                validateInputIdArray = [
                    branch.id,
                    class_id.id,
                    section.id,
                ];
            var check = validateInventoryInputs(validateInputIdArray);
            if (check == true) {
                jQuery(".pre-loader").fadeToggle("medium");
            }
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#branch").select2();
            jQuery("#class").select2();
            jQuery("#section").select2();
            jQuery("#group").select2();
        });
    </script>
    <script>
        $(document).ready(function() {
            var ng_id = {!! $student->group_id !!};
            var cs_id = {!! $student->section_id !!};
            var branch_id = {!! $student->branch_id !!};
            console.log({!! $student->class_id !!}, cs_id, ng_id);
            get_group_or_section(branch_id,{!! $student->class_id !!}, cs_id, ng_id);
        });
    </script>

    <script>
        $('#branch').change(function () {
            var class_id = $('#class').val();
            var branch_id = $('#branch').val();
            var cs_id = '';
            var ng_id = '';
            get_group_or_section(branch_id,class_id, cs_id, ng_id);
        });

        $('#class').change(function() {
            var class_id = $(this).val();
            var cs_id = '';
            var ng_id = '';
            var branch_id = $('#branch').val();
            get_group_or_section(branch_id,class_id, cs_id, ng_id);
        });

        function get_group_or_section(branch_id,class_id, cs_id, ng_id) {

            $.ajax({
                url: '/get_sections',
                type: 'get',
                datatype: 'text',
                data: {
                    'class_id': class_id,
                    'branch_id': branch_id
                },
                success: function(data) {
                    console.log(data);
                    var groups = '<option value="" selected disabled>Choose Groups</option>';
                    var sections = '<option value="" selected disabled>Choose Section</option>';

                    $.each(data.groups, function(index, items) {

                        groups +=
                            `<option value="${items.ng_id}"  ${items.ng_id == ng_id ? 'selected' : ''  }> ${items.ng_name} </option>`;


                    });
                    $.each(data.section, function(index, items) {
                        sections +=
                            `<option value="${items.cs_id}"  ${items.cs_id == cs_id ? 'selected' : ''  }> ${items.cs_name} </option>`;
                    });
                    $('#group').html(groups);
                    $('#section').html(sections);
                }
            })
        }

    </script>

@endsection


