@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Create Program</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('program_list') }}"
                            role="button">
                            <l class="fa fa-list"></l>
                            view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->


            <form name="f1" class="f1" id="f1" action="{{ route('store_program') }}" method="post"
                onsubmit="return checkForm()">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Degree
                            </label>
                            <select tabindex="1" autofocus name="degree" class="form-control required" id="degree"
                                autofocus data-rule-required="true" data-msg-required="Please Enter Degree">
                                <option value="" selected disabled>Select Degree</option>
                                @foreach ($degree as $degrees)
                                    <option value="{{ $degrees->degree_id }}"
                                        {{ $degrees->degree_id == old('degree') ? 'selected' : '' }}>
                                        {{ $degrees->degree_name }}
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
                                Program
                            </label>
                            <input tabindex="1" type="text" name="program_name" id="program_name"
                                class="inputs_up form-control" placeholder="Program Name" autofocus
                                data-rule-required="true" data-msg-required="Please Enter Program Name" autocomplete="off"
                                value="{{ old('program_name') }}" />
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
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
        </div> <!-- left column ends here -->
    </div> <!-- right columns ends here -->
@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let program_name = document.getElementById("program_name"),
                validateInputIdArray = [
                    program_name.id,
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
        $(window).keydown(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        $(document).ready(function() {
            $('#degree').select2();
        });
    </script>
@endsection
