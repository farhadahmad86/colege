@extends('extend_index')

@section('content')
    <link rel="stylesheet" href="{{ asset('public/css/simple_form.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/add_refresh_btn.css') }}">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 tabindex="-1" class="text-white get-heading-text">Create Post Dated Cheque Issue</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <a tabindex="-1" class="add_btn add_more_button" href="{{ route('reject_post_dated_cheque_issue_list') }}" role="button" target="_blank" data-toggle="tooltip"
                               data-placement="bottom" title="Rejected Post Dated Cheque Issue">
                                <i class="fa fa-list"></i> view Rejected
                            </a>
                            <a tabindex="-1" class="add_btn add_more_button" href="{{ route('approve_post_dated_cheque_issue_list') }}" role="button" target="_blank" data-toggle="tooltip"
                               data-placement="bottom" title="Confirmed Post Dated Cheque Issue">
                                <i class="fa fa-list"></i> view confirmed
                            </a>
                            <a tabindex="-1" class="add_btn add_more_button" href="{{ route('post_dated_cheque_issue_list') }}" role="button" target="_blank" data-toggle="tooltip"
                               data-placement="bottom" title="Pending Post Dated Cheque Issue">
                                <i class="fa fa-list"></i> view Pending
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <form class="highlight" name="f1" class="f1" id="f1" action="{{ route('submit_post_dated_cheque_issue') }}" onsubmit="return checkForm()" method="post" autocomplete="off">
                    @csrf
                    <div class="row">

                        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">

                            <div class="row">
                                <!-- use account-name-component
                                      make receive to dropdown
                                      here use class bank_voucher for get backend query bank account
                                      body="1" use for the query and get the index 1  bank accounts  -->
                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12 simpleForm"><!-- invoice column -->
                                    <x-account-name-component tabindex="4" name="from" class="bank_voucher" id="from" title="Issue By" href="bank_account_registration" body="1"/>
                                </div>

                                <!-- use account-name-component
                                    make receive by dropdown
                                    here use class payable_receivable for get backend query bank account
                                    body="0" use for the query and get the index 0  payable receivable accounts  -->
                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12 simpleForm"><!-- invoice column -->
                                    <x-account-name-component tabindex="2" name="to" class="payable_receivable" id="to" title="Issue To" href="receivables_account_registration" body="0"/>
                                </div>

                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.bank_voucher.post_dated_cheque_issue.amount.description')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Amount</label>
                                        <input tabindex="3" type="text" name="amount" id="amount" data-rule-required="true" data-msg-required="Please Enter Amount" class="inputs_up form-control"
                                               placeholder="Amount" onkeypress="return isNumberKey(event)"/>
                                        <span id="demo3" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            <a data-container="body" data-toggle="popover" data-trigger="hover"
                                               data-placement="bottom" data-html="true"
                                               data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.bank_voucher.post_dated_cheque_issue.cheque_date.description')}}</p>">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            Cheque Date</label>
                                        <input tabindex="4" type="text" name="cheque_date" id="cheque_date" data-rule-required="true" data-msg-required="Please Enter Cheque Date"
                                               class="inputs_up form-control datepicker2" placeholder="Cheque Date"/>
                                        <span id="demo4" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>

                                <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="input_bx"><!-- start input box -->
                                        <label class="required">
                                            Posting Reference</label>
{{--                                        hammad change tab index--}}
                                        <select tabindex="5" autofocus name="posting_reference" class="inputs_up form-control js-example-basic-multiple"
                                                data-rule-required="true" data-msg-required="Please Choose Posting Reference"
                                                id="posting_reference">
                                            <option value="0">Select Posting Reference</option>
                                            @foreach($posting_references as $posting_reference)
                                                <option value="{{$posting_reference->pr_id}}" {{ $posting_reference->pr_id == 1 ? 'selected':'' }}>{{$posting_reference->pr_name}}</option>
                                            @endforeach
                                        </select>
                                        <span id="demo4" class="validate_sign"> </span>
                                    </div><!-- end input box -->
                                </div>
                            </div>

                        </div>

                        <div class="form-group col-lg-5 col-md-5 col-sm-12 col-xs-12">
                            <div class="input_bx"><!-- start input box -->
                                <label class="">
                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                        data-placement="bottom" data-html="true"
                                        data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p>
                                                    <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p>
                                                    <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p>
                                                    <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                    Remarks</label>
                                <textarea tabindex="5" name="remarks" id="remarks" class="remarks inputs_up form-control" placeholder="Remarks" style="height: 100px;"></textarea>
                                <span id="demo5" class="validate_sign"> </span>
                            </div><!-- end input box -->
                        </div>

                    </div>


                    <div class="form-group row">
                        <div class="col-lg-12 col-md-12 col-sm-12 form_controls">
                            <button tabindex="6" type="reset" name="cancel" id="cancel" class="cancel_button btn btn-sm btn-secondary">
                                <i class="fa fa-eraser"></i> Cancel
                            </button>
                            <button tabindex="7" type="submit" name="save" id="save" class="save_button btn btn-sm btn-success">
                                <i class="fa fa-floppy-o"></i> Save
                            </button>
                        </div>
                    </div>

                </form>
            </div> <!-- white column form ends here -->
        </div><!-- col end -->
    </div><!-- row end -->

@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let from = document.getElementById("from"),
                to = document.getElementById("to"),
                amount = document.getElementById("amount"),
                cheque_date = document.getElementById("cheque_date"),
                posting_reference = document.getElementById("posting_reference"),
                validateInputIdArray = [
                    from.id,
                    to.id,
                    amount.id,
                    cheque_date.id,
                    posting_reference.id,
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


    </script>

    <script type="text/javascript">


        function form_validation() {
            var from = document.getElementById("from").value;
            var to = document.getElementById("to").value;
            var amount = document.getElementById("amount").value;
            var cheque_date = document.getElementById("cheque_date").value;
            var remarks = document.getElementById("remarks").value;

            var flag_submit = true;
            var focus_once = 0;


            return flag_submit;
        }

    </script>

    <script>
        jQuery(document).ready(function () {
            // refresh or add botton css
            $('.col_short_btn').addClass("add_btn");
            // Initialize select2
            jQuery("#to").select2();
            jQuery("#from").select2();
            jQuery("#posting_reference").select2();


            var date = new Date();
            var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

            $('#cheque_date').datepicker({
                minDate: today,
                language: 'en', dateFormat: 'dd-M-yyyy'
            });
        });


        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31
                && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }

        function validaterate(pas) {
            var pass = /^\d*\.?\d*$/;

            if (pass.test(pas)) {
                return true;
            } else {
                return false;
            }
        }
    </script>

    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

@endsection

