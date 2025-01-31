@extends('extend_index')
@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="container-fluid search-filter form-group form_manage">
                <div class="form_header">
                    <!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 tabindex="-1" class="text-white get-heading-text">Single Entry</h4>
                        </div>
                    </div>
                </div><!-- form header close -->
                <div class="row">
                    <form name="f1" class="f1" id="f1" onsubmit="return checkForm()"
                          action="{{ route('store_single_entry') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="row">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx">
                                                    <!-- start input box -->
                                                    <label class="required">
                                                        Account
                                                    </label>
                                                    <select tabindex="1" autofocus name="account_uid"
                                                            class="inputs_up form-control required" id="account_uid"
                                                            autofocus data-rule-required="true"
                                                            data-msg-required="Please Enter Region Title">
                                                        <option value="">Select Account</option>
                                                        @foreach ($accounts as $account)
                                                            <option value="{{ $account->account_uid }}"
                                                                {{ old('account_uid') == $account->account_uid ? 'selected="selected"' : '' }}>
                                                                {{ $account->account_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span id="demo1" class="validate_sign"> </span>
                                                </div>
                                                <!-- end input box -->
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <label class="radio-inline text"><input type="radio" value="1" name="debit_credit" checked>Debit</label>
                                                <label class="radio-inline text"><input type="radio" value="2" name="debit_credit">Credit</label>
                                            </div>
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx">
                                                    <!-- start input box -->
                                                    <label class="required">

                                                        Amount</label>
                                                    <input tabindex="6" type="text" name="amount"
                                                           class="inputs_up form-control" id="amount"
                                                           placeholder="Amount" min="1"
                                                           onkeypress="return allow_only_number_and_decimals(this,event);"/>

                                                </div><!-- end input box -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="row">
                                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                                <div class="input_bx">
                                                    <!-- start input box -->
                                                    <label class="">

                                                        Remarks</label>
                                                    <textarea tabindex="3" name="remarks" id="remarks" class="inputs_up remarks form-control" placeholder="Remarks"
                                                              style="height: 100px;">{{ old('remarks') }}</textarea>
                                                    <span id="demo3" class="validate_sign"> </span>
                                                </div><!-- end input box -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                                        <button tabindex="4" type="reset" name="cancel" id="cancel"
                                                class="cancel_button btn btn-sm btn-secondary">
                                            <i class="fa fa-eraser"></i> Cancel
                                        </button>
                                        <button tabindex="5" type="submit" name="save" id="save"
                                                class="save_button btn btn-sm btn-success">
                                            <i class="fa fa-floppy-o"></i> Save
                                        </button>
                                    </div>
                                </div>
                            </div> <!-- left column ends here -->
                        </div> <!--  main row ends here -->
                    </form>
                </div>
            </div>
        </div> <!-- white column form ends here -->
    </div><!-- col end -->

@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        $('#account_uid').select2();

        function checkForm() {
            let account_uid = document.getElementById("account_uid"),
                amount = document.getElementById("amount"),
                validateInputIdArray = [
                    account_uid.id,
                    amount.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    <script>
        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        $(function () {
            $('[data-toggle="popover"]').popover()
        });
    </script>

@endsection
