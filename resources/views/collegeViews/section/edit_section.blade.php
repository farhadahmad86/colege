@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Update Section</h4>
                    </div>
                    <div class="list_btn">
                        {{-- <a tabindex="-1" class="btn list_link add_more_button"
                            href="{{ route('class_section_list', $classes->class_id]) }}" role="button">
                            <l class="fa fa-list"></l>
                            view list
                        </a> --}}
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->
            <form name="f1" class="f1" id="f1" action="{{ route('update_class_sections') }}" method="post"
                onsubmit="return checkForm()">
                @csrf
                <input type="hidden" value="{{ $request->section_id }}" name="section_id">
                <div class="row">
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Class
                            </label>
                            <select tabindex="1" autofocus name="class_id" class="form-control required" id="class_id"
                                autofocus data-rule-required="true" data-msg-required="Please Enter Class">
                                <option value="{{ $class->class_id }}" selected readonly>{{ $class->class_name }}
                                </option>
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
                                        {{ $section->cs_id == $request->cs_id ? 'selected' : '' }}>
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
                                        {{ $user->user_id == $request->incharge_id ? 'selected' : '' }}>
                                        {{ $user->user_name }}
                                    </option>
                                @endforeach
                            </select>
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="section_id" value="{{ $request->section_id }}">
                <div class="form-group row">
                    <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                        <button tabindex="1" type="submit" name="save" id="save"
                            class="save_button btn btn-sm btn-success">
                            <i class="fa fa-floppy-o"></i> Save
                        </button>
                    </div>
                </div>

            </form>
        </div> <!-- left column ends here -->
    </div> <!--  main row ends here -->
@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let section_name = document.getElementById("section_name"),
                validateInputIdArray = [
                    section_name.id,
                ];
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
