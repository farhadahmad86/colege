@extends('extend_index')
@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header">
                    <!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Update Subject</h4>
                        </div>
                    </div>
                </div><!-- form header close -->
                <form name="f1" class="f1" id="f1" action="{{ route('update_subject') }}"
                    onsubmit="return checkForm()" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label class="required">
                                            Subject</label>
                                        <input type="text" name="subject_name" id="subject_name"
                                            class="inputs_up form-control" data-rule-required="true"
                                            data-msg-required="Please Enter Subject" placeholder="Subject" autofocus
                                            value="{{ $request->title }}" autocomplete="off" />
                                        <span id="demo1" class="validate_sign"> </span>
                                    </div>
                                    <!-- end input box -->
                                </div>
                                <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                    <div class="input_bx">
                                        <!-- start input box -->
                                        <label class="required">
                                            Teacher
                                        </label>
                                        <select tabindex=42 autofocus name="teacher[]" class="form-control" data-rule-required="true"
                                            data-msg-required="Please Enter Teacher" id="teacher" multiple
                                            placeholder="Select Teacher">
                                            <option value="" disabled>Select Teacher</option>
                                            @foreach ($teachers as $teacher)
                                                @php
                                                    $teacher_id = explode(',', $request->teachers_id);
                                                @endphp
                                                    <option value="{{ $teacher->user_id }}"
                                                        {{ in_array($teacher->user_id, $teacher_id) ? 'selected' : '' }}>
                                                        {{ $teacher->user_name }}
                                                    </option>
                                            @endforeach
                                        </select>
                                        <span id="demo1" class="validate_sign"> </span>
                                    </div>
                                </div>
                                <input value="{{ $request->subject_id }}" type="hidden" name="subject_id">
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                    <button type="submit" name="save" id="save" class="save_button form-control">
                                        <i class="fa fa-floppy-o"></i> Save
                                    </button>
                                </div>
                            </div>
                        </div> <!-- left column ends here -->
                    </div> <!--  main row ends here -->
                </form>
            </div> <!-- white column form ends here -->
        </div><!-- col end -->
    </div><!-- row end -->
@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let subject_name = document.getElementById("subject_name"),
                teacher = document.getElementById("teacher"),
                validateInputIdArray = [
                    subject_name.id,
                    teacher.id,
                ];
            let check = validateInventoryInputs(validateInputIdArray);
            if(check == true){
                jQuery(".pre-loader").fadeToggle("medium");
            }
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script type="text/javascript">
        function form_validation() {
            var subject_name = document.getElementById("subject_name").value;
            // var remarks = document.getElementById("remarks").value;

            var flag_submit = true;
            var focus_once = 0;

            if (subject_name.trim() == "") {
                document.getElementById("demo1").innerHTML = "Required";
                if (focus_once == 0) {
                    jQuery("#subject_name").focus();
                    focus_once = 1;
                }
                flag_submit = false;
            } else {
                document.getElementById("demo1").innerHTML = "";
            }
            return flag_submit;
        }
        $(document).ready(function() {
            $('#teacher').select2();
        });
    </script>
@endsection
