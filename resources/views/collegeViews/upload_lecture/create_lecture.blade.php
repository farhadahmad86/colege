@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Upload Lecture Link</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('upload_lecture_list') }}"
                           role="button">
                            <l class="fa fa-list"></l>
                            view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->


            <form name="f1" class="f1" id="f1" action="{{ route('store_upload_lecture') }}" method="post"
                  onsubmit="return checkForm()">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Class
                            </label>
                            <select tabindex=2 autofocus name="class" class="form-control" data-rule-required="true"
                                    data-msg-required="Please Enter Class" id="class">
                                <option value="">Select Class</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->class_id }}"
                                        {{ $class->class_id == old('class') ? 'selected' : '' }}>
                                        {{ $class->class_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Group
                            </label>
                            <select tabindex=2 autofocus name="group" class="form-control" data-rule-required="true"
                                    data-msg-required="Please Enter Group" id="group">
                                <option value="" disabled selected>Select Group</option>
{{--                                @foreach ($groups as $group)--}}
{{--                                    <option value="{{ $group->group_id }}"--}}
{{--                                        {{ $group->group_id == old('group') ? 'selected' : '' }}>--}}
{{--                                        {{ $group->group_name }}--}}
{{--                                    </option>--}}
{{--                                @endforeach--}}
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Subject
                            </label>
                            <select tabindex=3 autofocus name="subject" class="form-control" data-rule-required="true"
                                    data-msg-required="Please Enter Subject" id="subject">
                                <option value="" disabled selected>Select Subject</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->subject_id }}"
                                        {{ $subject->subject_id == old('subject') ? 'selected' : '' }}>
                                        {{ $subject->subject_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Title
                            </label>
                            <input tabindex="1" type="text" name="title" id="title" class="inputs_up form-control" placeholder="Title" autofocus data-rule-required="true"
                                   data-msg-required="Please Enter Title" autocomplete="off" value="{{ old('title') }}"/>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Link
                            </label>
                            <input tabindex="1" type="text" name="link" id="link" class="inputs_up form-control" placeholder="Link" autofocus data-rule-required="true"
                                   data-msg-required="Please Enter Link" autocomplete="off" value="{{ old('link') }}"/>
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
            let class_id = document.getElementById("class"),
                group = document.getElementById("group"),
                subject = document.getElementById("subject"),
                title = document.getElementById("title"),
                link = document.getElementById("link"),
                validateInputIdArray = [
                    class_id.id,
                    group.id,
                    subject.id,
                    title.id,
                    link.id,
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
        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        $(document).ready(function () {
            $('#class').select2();
            $('#group').select2();
            $('#subject').select2();
        });
        $("#class").change(function () {
            var class_id = $(this).val();
            $.ajax({
                url: '/get_groups',
                type: 'get',
                datatype: 'text',
                data: {
                    'class_id': class_id
                },
                success: function (data) {
                    console.log(data);
                    var groups = '<option selected disabled >Choose Groups</option>';

                    $.each(data.groups, function (index, items) {
                        groups +=
                            `<option value="${items.ng_id}"> ${items.ng_name} </option>`;
                    });

                    $('#group').html(groups);
                }
            })
        });

    </script>

@endsection
