@extends('extend_index')

@section('content')
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage">
            <div class="form_header">
                <!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 tabindex="-1" class="text-white get-heading-text">Edit Component</h4>
                    </div>
                    <div class="list_btn">
                        <a tabindex="-1" class="btn list_link add_more_button" href="{{ route('component_list') }}"
                            role="button">
                            <l class="fa fa-list"></l>
                            view list
                        </a>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->


            <form name="f1" class="f1" id="f1" action="{{ route('update_component') }}" method="post"
                onsubmit="return checkForm()">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Component Name
                            </label>
                            <input tabindex="1" type="text" name="component_name" id="component_name"
                                class="inputs_up form-control" placeholder="Component Name" autofocus data-rule-required="true"
                                data-msg-required="Please Enter Component Name" autocomplete="off"
                                value="{{ $request->sfc_name }}" />
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Amount
                            </label>
                            <input tabindex="6" type="text" name="amount" class="inputs_up text-right form-control"
                                id="amount" placeholder="Amount" onfocus="this.select();" value="{{$request->sfc_amount }}"
                                onkeypress="return allow_only_number_and_decimals(this,event);">
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>

                    <div class="form-group col-lg-3 col-md-3 col-sm-12">
                        <div class="input_bx">
                            <!-- start input box -->
                            <label class="required">
                                Dr. Account
                            </label>
                            <select tabindex=42 autofocus name="dr_account" class="form-control" data-rule-required="true"
                            data-msg-required="Please Enter Dr Account" id="dr_account">
                            <option value="" disabled selected >Select Dr Account</option>
                            @foreach ($dr_accounts as $account)
                                <option value="{{ $account->account_uid }}"
                                    {{ $account->account_uid == $request->dr_acc_id  ? 'selected' : '' }}>
                                    {{ $account->account_uid }} - {{ $account->account_name }}
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
                                Cr. Account
                            </label>
                            <select tabindex=42 autofocus name="cr_account" class="form-control" data-rule-required="true"
                                data-msg-required="Please Enter Cr Account" id="cr_account">
                                <option value="" disabled selected >Select Cr Account</option>
                                @foreach ($cr_accounts as $account)
                                <option value="{{ $account->account_uid }}"
                                    {{ $account->account_uid == $request->cr_acc_id ? 'selected' : '' }}>
                                    {{ $account->account_uid }} - {{ $account->account_name }}
                                </option>
                            @endforeach
                            </select>
                            <span id="demo1" class="validate_sign"> </span>
                        </div>
                    </div>
                    <input value="{{ $request->sfc_id }}" type="hidden" name="sfc_id">
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
            let component_name = document.getElementById("component_name"),
                amount = document.getElementById("amount"),
                cr_account = document.getElementById("cr_account"),
                dr_account = document.getElementById("dr_account"),
                validateInputIdArray = [
                    component_name.id,
                    amount.id,
                    cr_account.id,
                    dr_account.id,
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
            $('#dr_account').select2();
            $('#cr_account').select2();
        });

    </script>
@endsection
