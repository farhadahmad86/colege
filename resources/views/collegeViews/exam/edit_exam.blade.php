@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Create Exam</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('class_list') }}"
                            role="button">
                            <l class="fa fa-list"></l>
                            view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <form name="f1" class="f1" id="f1" action="{{ route('update_exam') }}" method="post"
                onsubmit="return checkForm()">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Exam Title
                            </label>
                            <input tabindex="1" type="text" name="exam_title" id="exam_title" class="form-control"
                                placeholder="Exam Title" autofocus data-rule-required="true"
                                data-msg-required="Please Enter Exam Title" autocomplete="off"
                                value="{{ $request->title }}" />
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Exam Type
                            </label>
                            <select tabindex="1" autofocus name="exam_type" class="form-control required" id="exam_type"
                                autofocus data-rule-required="true" data-msg-required="Please Enter Exam Type"
                                onchange="creatClass()">
                                <option value="" selected disabled>Select Exam Type</option>
                                <option value="Weekly"{{ $request->exam_type == 'Weekly' ? 'selected' : '' }}>Weekly
                                </option>
                                <option value="Monthly"{{ $request->exam_type == 'Monthly' ? 'selected' : '' }}>Monthly
                                </option>
                                <option value="Sendup"{{ $request->exam_type == 'Sendup' ? 'selected' : '' }}>Sendup
                                </option>
                                <option value="Annual"{{ $request->exam_type == 'Annual' ? 'selected' : '' }}>Annual
                                </option>
                            </select>
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label>
                                Start Date
                            </label>
                            <input tabindex="2" type="text" name="to" id="to"
                                class="inputs_up form-control datepicker1" autocomplete="off"
                                value="{{ $request->start_date }}" placeholder="Start Date ......">
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label>
                                End Date
                            </label>
                            <input tabindex="3" type="text" name="from" id="from"
                                class="inputs_up form-control datepicker1" autocomplete="off"
                                value="{{ $request->start_date }}" placeholder="End Date ......">
                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Classes
                            </label>
                            <select tabindex="1" autofocus name="class[]" class="form-control required" id="class_id"
                                autofocus data-rule-required="true" data-msg-required="Please Enter Degree" multiple>
                                <option value="" disabled>Select Classes</option>
                                @foreach ($classes as $class)
                                    @php
                                        $class_id = explode(',', $request->class_id);
                                    @endphp
                                    <option value="{{ $class->class_id }}"
                                        {{ in_array($class->class_id, $class_id) ? 'selected' : '' }}>
                                        {{ $class->class_name }}
                                    </option>
                                @endforeach
                            </select>
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <input type="hidden" value="{{ $request->exam_id }}" name="exam_id">
                    {{-- <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Description
                            </label>
                            <textarea  type="text" name="description" id="description" class="form-control"
                                placeholder="Description" autofocus data-rule-required="true"
                                data-msg-required="Please Enter Description" autocomplete="off"
                               >{{ old('description') }}</textarea>
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div> --}}
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
            let exam_title = document.getElementById("exam_title"),
                exam_type = document.getElementById("exam_type"),
                to = document.getElementById("to"),
                from = document.getElementById("from"),
                class_id = document.getElementById("class_id"),
                validateInputIdArray = [
                    exam_title.id,
                    exam_type.id,
                    from.id,
                    to.id,
                    // class_incharge_id.id,
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
            $('#exam_type').select2();
            $('#class_id').select2();
        });
    </script>
@endsection
