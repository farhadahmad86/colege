@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Create Group</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('college_group_list') }}"
                            role="button">
                            <l class="fa fa-list"></l>
                            view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->


            <form name="f1" class="f1" id="f1" action="{{ route('store_college_group') }}" method="post"
                onsubmit="return checkForm()">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Class
                            </label>
                            <select tabindex="1" autofocus name="class_id" class="form-control required" id="class_id"
                                autofocus data-rule-required="true" data-msg-required="Please Enter Class">
                                <option value="">Select Class</option>
                                @foreach ($classes as $classes)
                                    <option value="{{ $classes->class_id }}"
                                        {{ $classes->class_id == old('class_id') ? 'selected' : '' }}>
                                        {{ $classes->class_name }}
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
                            <select tabindex="1" autofocus name="section_id" class="form-control required" id="section_id"
                                autofocus data-rule-required="true" data-msg-required="Please Enter Section">
                            </select>
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Group
                            </label>
                            <select name="group_names" id="group_names" class="inputs_up form-control" data-rule-required="true" data-msg-required="Please Enter Group Name">
                                <option value="">Select Group</option>
                                @foreach($groups as $group)
                                <option value="{{$group->ng_id}}" {{ $group->ng_id == old('group_names') ? 'selected' : '' }}>{{$group->ng_name}}</option>
                                @endforeach
                            </select>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Subject
                            </label>
                            <select tabindex=42 autofocus name="subject[]" class="form-control" data-rule-required="true"
                                data-msg-required="Please Enter Subject" id="subject" multiple
                                placeholder="Select Subjects">
                                <option value="" disabled>Select Subjects</option>
                                @foreach ($subjects as $Subject)
                                    <option value="{{ $Subject->subject_id }}"
                                        {{ $Subject->subject_id == old('subject') ? 'selected' : '' }}>
                                        {{ $Subject->subject_name }}
                                    </option>
                                @endforeach
                            </select>
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
            let class_id = document.getElementById("class_id"),
                section_id = document.getElementById("section_id"),
                group_names = document.getElementById("group_names"),
                subject = document.getElementById("subject"),
                validateInputIdArray = [
                    class_id.id,
                    section_id.id,
                    group_names.id,
                    subject.id,
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
            $('#class_id').select2();
            $('#subject').select2();
            $('#section_id').select2();
            $('#group_names').select2();
        });
        $('#class_id').change(function() {
            var class_id = $(this).children('option:selected').val();
            $.ajax({
                url: '/get_groups',
                type: 'get',
                datatype: 'text',
                data: {
                    'class_id': class_id
                },
                success: function(data) {
                    console.log(data);
                    var sections = '<option selected disabled hidden>Choose Section</option>';
                    $.each(data.section, function(index, items) {

                        sections +=
                            `<option value="${items.cs_id}"> ${items.cs_name} </option>`;


                    });
                    $('#section_id').html(sections);
                }
            })
        });
    </script>
@endsection
