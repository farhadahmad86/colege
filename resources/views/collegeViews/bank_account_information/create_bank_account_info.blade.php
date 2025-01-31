@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Create Bank Information</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('bank_account_info_list') }}"
                            role="button">
                            <l class="fa fa-list"></l>
                            view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->


            <form name="f1" class="f1" id="f1" action="{{ route('submit_bank_account_info') }}"
                method="post" onsubmit="return checkForm()">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Account Title
                            </label>
                            <input tabindex="1" type="text" name="account_title" id="account_title"
                                class="inputs_up form-control" placeholder="Account Title" autofocus
                                data-rule-required="true" data-msg-required="Please Enter Account Title" autocomplete="off"
                                value="{{ old('account_title') }}" />
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Account#
                            </label>
                            <input tabindex="1" type="text" name="account" id="account"
                                class="inputs_up form-control" placeholder="Account" autofocus data-rule-required="true"
                                data-msg-required="Please Enter Account" autocomplete="off" value="{{ old('account') }}" />
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Branch Code
                            </label>

                            <input tabindex="6" type="text" name="branch_code"
                                class="inputs_up text-right form-control" id="branch_code" placeholder="Branch Code"
                                onfocus="this.select();" data-rule-required="true"
                                data-msg-required="Please Enter Branch Code"onkeypress="return allow_only_number_and_decimals(this,event);">
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Bank Name
                            </label>
                            <input tabindex="1" type="text" name="bank_name" id="bank_name"
                                class="inputs_up form-control" placeholder="Bank Name" autofocus data-rule-required="true"
                                data-msg-required="Please Enter Bank Name" autocomplete="off"
                                value="{{ old('bank_name') }}" />
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                        <button tabindex="1" type="reset" name="cancel" id="cancel"
                            class="cancel_button btn btn-sm btn-secondary">
                            <i class="fa fa-eraser"></i> Cancel
                        </button>
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
            let account_title = document.getElementById("account_title"),
                account = document.getElementById("account"),
                branch_code = document.getElementById("branch_code"),
                bank_name = document.getElementById("bank_name"),
                validateInputIdArray = [
                    account_title.id,
                    account.id,
                    branch_code.id,
                    bank_name.id,
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
            $('#dr_account').select2();
            $('#cr_account').select2();
        });
    </script>
@endsection
