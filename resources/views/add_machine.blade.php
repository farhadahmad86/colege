@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Create Machine</h4>
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


            <form name="f1" class="f1" id="f1" action="{{ route('submit_machine') }}" method="post"
                  onsubmit="return checkForm()">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                User Name
                            </label>
                            <input tabindex="1" type="text" name="user_name" id="user_name"
                                   class="inputs_up form-control" placeholder="Program Name" autofocus
                                   data-rule-required="true" data-msg-required="Please Enter Program Name" autocomplete="off"
                                   value="{{ old('user_name') }}" />
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Email
                            </label>
                            <input tabindex="1" type="email" name="email" id="email"
                                   class="inputs_up form-control" placeholder="Program Name" autofocus
                                   data-rule-required="true" data-msg-required="Please Enter Email" autocomplete="off"
                                   value="{{ old('email') }}" />
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Password
                            </label>
                            <input tabindex="1" type="password" name="password" id="password"
                                   class="inputs_up form-control" placeholder="Enter Password"
                                   data-rule-required="true" data-msg-required="Please Enter Password" autocomplete="off"
                                   value="{{ old('password') }}" />
                            <span id="demo1" class="validate_sign"> </span>
                        </div><!-- end input box -->
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Branch
                            </label>
                            <select tabindex="1" autofocus name="branch" class="form-control required" id="branch"
                                    autofocus data-rule-required="true" data-msg-required="Please Enter Branch">
                                <option value="" selected disabled>Select Branch</option>
                                @foreach ($branches as $bra)
                                    <option value="{{ $bra->branch_id }}"
                                        {{ $bra->branch_id == old('branch') ? 'selected' : '' }}>
                                        {{ $bra->branch_name }}
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
        </div> <!-- left column ends here -->
    </div> <!-- right columns ends here -->
@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let user_name = document.getElementById("user_name"),
            email = document.getElementById("email"),
            password = document.getElementById("password"),
            branch = document.getElementById("branch"),
                validateInputIdArray = [
                    user_name.id,
                    email.id,
                    password.id,
                    branch.id,
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
            $('#branch').select2();
        });
    </script>
@endsection
