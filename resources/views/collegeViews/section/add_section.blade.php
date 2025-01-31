@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Create Section</h4>
                    </div>
                    {{-- <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('section_list') }}"
                            role="button">
                            <l class="fa fa-list"></l>
                            view list
                        </a>
                    </div><!-- list btn --> --}}
                </div>
            </div><!-- form header close -->


            <form name="f1" class="f1" id="f1" action="{{ route('store_section') }}" method="post"
                onsubmit="return checkForm()">
                @csrf
                <div class="row">

                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Class
                            </label>
                            {{-- @foreach ($classes as $class) --}}
                            {{-- <input tabindex="1" type="text" name="class" id="class"
                            class="inputs_up form-control" placeholder="Section Name" autofocus data-rule-required="true"
                            data-msg-required="Please Enter Class Name" autocomplete="off"
                            value="{{ old('class') }}" /> --}}
                            {{-- @endforeach --}}
                            <select tabindex="1" autofocus name="class" class="form-control required" id="class"
                                autofocus data-rule-required="true" data-msg-required="Please Enter Class">
                                <option value="{{ $classes->class_id }}" selected readonly>{{ $classes->class_name }}
                                </option>
                                {{-- @foreach ($classes as $class) --}}
                                {{-- <option value="{{ $class->class_id }}"
                                        {{ $class->class_id == old('degree') ? 'selected' : '' }}>
                                        {{ $class->class_name }}
                                    </option> --}}
                                {{-- @endforeach --}}
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
                            <select tabindex="1" autofocus name="section_name" class="form-control required"
                            id="section_name" autofocus data-rule-required="true"
                            data-msg-required="Please Enter Section">
                            <option value="" selected disabled>Select Section</option>
                            @foreach ($sections as $section)
                                <option value="{{ $section->cs_id }}"
                                    {{ $section->cs_id == old('cs_name') ? 'selected' : '' }}>
                                    {{ $section->cs_name }}
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
                                Class Incharge
                            </label>
                            <select tabindex="1" autofocus name="class_incharge" class="form-control required"
                                id="class_incharge" autofocus data-rule-required="true"
                                data-msg-required="Please Enter Class Incharge">
                                <option value="" selected disabled>Select Incharge</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->user_id }}"
                                        {{ $user->user_id == old('class_incharge') ? 'selected' : '' }}>
                                        {{ $user->user_name }}
                                    </option>
                                @endforeach
                            </select>
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                        {{-- <button tabindex="1" type="reset" name="cancel" id="cancel"
                            class="cancel_button btn btn-sm btn-secondary">
                            <i class="fa fa-eraser"></i> Cancel
                        </button> --}}
                        <button tabindex="1" type="submit" name="save" id="save"
                            class="save_button btn btn-sm btn-success">
                            <i class="fa fa-floppy-o"></i> Save
                        </button>
                    </div>
                </div>

        </div> <!-- left column ends here -->
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            {{-- <div class="show_info_div"> --}}

            {{-- </div> --}}

        </div> <!-- right columns ends here -->

    </div> <!--  main row ends here -->


    </form>
    </div> <!-- white column form ends here -->
    </div><!-- row end -->
@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let cs_name = document.getElementById("cs_name"),
                // class_incharge = document.getElementById("class_incharge"),
                validateInputIdArray = [
                    cs_name.id,
                    // class_incharge.id,
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
            $('#class').select2();
            $('#section_name').select2();
            $('#class_incharge').select2();
        });
    </script>
@endsection
