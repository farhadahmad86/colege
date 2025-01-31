@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Announcement</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('announcement_list') }}"
                           role="button">
                            <l class="fa fa-list"></l>
                            view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->


            <form name="f1" class="f1" id="f1" action="{{ route('store_announcement') }}" method="post"
                  onsubmit="return checkForm()">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Announcement Title
                            </label>
                            <input tabindex="1" type="text" name="announcement_title" id="announcement_title"
                                   class="inputs_up form-control" placeholder="Announcement Title" autofocus
                                   data-rule-required="true" data-msg-required="Please Enter Announcement Title" autocomplete="off"
                                   value="{{ old('announcement_title') }}" />
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Announcement Description
                            </label>
                            <input tabindex="6" type="text" name="announcement_description" class="inputs_up form-control"
                                   id="announcement_description" placeholder="Announcement Description" data-rule-required="true"
                                   data-msg-required="Please Enter Announcement Description">
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Class Name
                            </label>
                            <select tabindex=42 autofocus name="class_id" class="form-control" data-rule-required="true"
                                    data-msg-required="Please Enter Class Name" id="class_id">
                                <option value="" disabled selected>Select Class Name</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->class_id }}"
                                        {{ $class->class_id == old('class_id') ? 'selected' : '' }}>
                                         {{ $class->class_name }}
                                    </option>
                                @endforeach
                            </select>
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
{{--                    <div class="form-group col-lg-3 col-md-3 col-sm-12">--}}
{{--                        <div class="input_bx">--}}
{{--                            <!-- start input box -->--}}
{{--                            <label>--}}
{{--                                Section Name--}}
{{--                            </label>--}}
{{--                            <select tabindex=42 autofocus name="section_id" class="form-control" data-rule-required="true"--}}
{{--                                    data-msg-required="Please Enter Section Name" id="section_id">--}}
{{--                                <option value="" disabled selected>Select Section Name</option>--}}
{{--                            </select>--}}
{{--                            <span id="demo1" class="validate_sign"> </span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>

                <div class="form-group row">
                    <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                        <button tabindex="1" type="submit"  id="save"
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
            let announcement_title = document.getElementById("announcement_title"),
                announcement_description = document.getElementById("announcement_description"),
                class_id = document.getElementById("class_id"),
                validateInputIdArray = [
                    announcement_title.id,
                    announcement_description.id,
                    class_id.id,
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
            $('#section_id').select2();
        });

        // $('#class_id').change(function () {
        //     var class_id = $(this).val();
        //     $.ajax({
        //         url: '/get_groups',
        //         type: 'get',
        //         datatype: 'text',
        //         data: {
        //             'class_id': class_id
        //         },
        //         success: function (data) {
        //             console.log(data);
        //             var sections = '<option selected disabled >Choose Section</option>';
        //
        //             $.each(data.section, function (index, items) {
        //
        //                 sections +=
        //                     `<option value="${items.cs_id}"> ${items.cs_name} </option>`;
        //
        //
        //             });
        //             $('#section_id').html(sections);
        //         }
        //     })
        // });
    </script>
@endsection
