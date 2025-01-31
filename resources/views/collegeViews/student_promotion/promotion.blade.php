@extends('extend_index')

@section('content')

    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Class Promotion</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button"
                           href="{{ route('promotion_list') }}"
                           role="button">
                            <i class="fa fa-list"></i> view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h5>Promotion To</h5>
                </div>
            </div>
            <form name="f1" class="f1" id="f1" action="{{ route('submit_class_promotion') }}"
                  onsubmit="return checkForm()" method="post">
                @csrf
                <input type="hidden" name="branch_id" value="{{ Session::get('branch_id') }}" id="branch_id">
                {{--                <input type="hidden" name="reg_no" value="{{$student->registration_no}}">--}}
                <div class="row">
                    <div class="input_bx form-group col-lg-3 col-md-3 col-sm-12 col-xs-12"><!-- start input box -->
                        <label class="required">
                            Class
                        </label>
                        <select tabindex=1 autofocus name="class" class="inputs_up form-control" id="class"
                                data-rule-required="true" data-msg-required="Please Enter Class">
                            <option value="">Class</option>
                            @foreach($classes as $class)
                                <option
                                    value="{{$class->class_id}}">{{$class->class_name}}</option>
                            @endforeach
                        </select>
                        <span id="demo1" class="validate_sign"> </span>
                    </div><!-- end input box -->

                    {{--                    <div class="input_bx form-group col-lg-3 col-md-3 col-sm-12 col-xs-12"><!-- start input box -->--}}
                    {{--                        <label class="required">--}}
                    {{--                            Section--}}
                    {{--                        </label>--}}
                    {{--                        <select tabindex=1 name="section" class="inputs_up form-control" id="section"--}}
                    {{--                                data-rule-required="true" data-msg-required="Please Enter Section">--}}
                    {{--                            <option value="">Section</option>--}}
                    {{--                        </select>--}}
                    {{--                    </div><!-- end input box -->--}}
                    <div class="input_bx form-group col-lg-3 col-md-3 col-sm-12 col-xs-12"><!-- start input box -->
                        <label class="required">
                            Current Group
                        </label>
                        <select tabindex=1 name="group" class="inputs_up form-control" id="group"
                                data-rule-required="true" data-msg-required="Please Enter Group">
                            <option value="">Group</option>
                        </select>
                    </div><!-- end input box -->
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
                </div> <!--  main row ends here -->
                <div class="row">
                    <div class="input_bx form-group col-lg-3 col-md-3 col-sm-12 col-xs-12"><!-- start input box -->
                        <label class="required">
                            Promotion Groups
                        </label>
                        <select tabindex=1 autofocus name="group_id" class="inputs_up form-control" id="group_id"
                                autofocus
                                data-rule-required="true" data-msg-required="Please Enter Promotion Group">
                            <option value="">Select Promotion Group</option>
                            @foreach($groups as $group)
                                <option
                                    value="{{$group->ng_id}}">{{$group->ng_name}}</option>
                            @endforeach
                        </select>
                        <span id="demo1" class="validate_sign"> </span>
                    </div><!-- end input box -->
                    <div class="col-lg-9 col-md-9 col-sm-12 form_controls">
                        <button tabindex="4" type="reset" name="cancel" id="cancel"
                                class="cancel_button btn btn-sm btn-secondary">
                            <i class="fa fa-eraser"></i> Cancel
                        </button>
                        <button tabindex="5" type="submit" name="save" id="save"
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
            let group_id = document.getElementById("group_id"),
                class_id = document.getElementById("class"),
                group = document.getElementById("group");
            validateInputIdArray = [
                class_id.id,
                group.id,
                group_id.id,
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
            jQuery("#group_id").select2();
            jQuery("#group").select2();
        });
        jQuery("#group").change(function () {
            let group = $(this).val();
            let class_id = $('#class').val();


            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "get_students_for_promotion",
                data: {
                    group: group,
                    class_id: class_id,
                },
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    jQuery("#total_std").html(" ");
                    jQuery("#total_students").val("");
                    jQuery("#total_std").append(data.students);
                    if (data.students > 0) {
                        jQuery("#total_students").val(data.students);
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });
    </script>
    {{--    <script>--}}
    {{--        $(document).ready(function() {--}}
    {{--            --}}{{--var ng_id = {!! $student->group_id !!};--}}
    {{--            --}}{{--var cs_id = {!! $student->section_id !!};--}}
    {{--            --}}{{--var branch_id = {!! $student->branch_id !!};--}}
    {{--            console.log({!! $student->class_id !!}, cs_id, ng_id);--}}
    {{--            get_group_or_section(branch_id,{!! $student->class_id !!}, cs_id, ng_id);--}}
    {{--        });--}}
    {{--    </script>--}}

    <script>
        // $('#branch').change(function () {
        //     var class_id = $('#class').val();
        //     var branch_id = $('#branch').val();
        //     var cs_id = '';
        //     var ng_id = '';
        //     get_group_or_section(branch_id,class_id, cs_id, ng_id);
        // });

        $('#class').change(function () {
            var class_id = $(this).val();
            var cs_id = '';
            var ng_id = '';
            var branch_id = $('#branch_id').val();
            get_group_or_section(branch_id, class_id, cs_id, ng_id);
        });

        function get_group_or_section(branch_id, class_id, cs_id, ng_id) {

            $.ajax({
                url: '/get_sections',
                type: 'get',
                datatype: 'text',
                data: {
                    'class_id': class_id,
                    'branch_id': branch_id
                },
                success: function (data) {
                    console.log(data);
                    var groups = '<option value="" selected disabled>Choose Groups</option>';
                    var sections = '<option value="" selected disabled>Choose Section</option>';

                    $.each(data.groups, function (index, items) {

                        groups +=
                            `<option value="${items.ng_id}"  ${items.ng_id == ng_id ? 'selected' : ''}> ${items.ng_name} </option>`;


                    });
                    // $.each(data.section, function(index, items) {
                    //     sections +=
                    //         `<option value="${items.cs_id}"  ${items.cs_id == cs_id ? 'selected' : ''  }> ${items.cs_name} </option>`;
                    // });
                    $('#group').html(groups);
                    // $('#section').html(sections);
                }
            })
        }

    </script>

@endsection


