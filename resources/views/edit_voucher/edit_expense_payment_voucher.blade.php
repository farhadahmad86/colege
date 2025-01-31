@extends('extend_index')

@section('content')
    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage">


                <div class="form_header">
                    <!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 tabindex="-1" class="text-white get-heading-text">Edit Expense Payment Voucher</h4>
                        </div>
                        <div class="list_btn">
                            <a class="btn list_link add_more_button" href="{{ route('expense_payment_voucher_list') }}"
                               role="button">
                                <i tabindex="-1" class="fa fa-list"></i> view list
                            </a>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->


                <div id="invoice_con" class="gnrl-mrgn-pdng invoice_con for_voucher">
                    <!-- invoice container start -->
                    <div id="invoice_bx" class="gnrl-mrgn-pdng gnrl-blk invoice_bx show_scale show_rotate">
                        <!-- invoice box start -->

                        <form id="f1" action="{{ route('update_expense_payment_voucher', $voucher->ep_id) }}"
                              method="post" onsubmit="return checkForm()" autocomplete="off">
                            @csrf
                            <div class="gnrl-mrgn-pdng gnrl-blk invoice_bx_scrl">
                                <!-- invoice scroll box start -->
                                <div class="gnrl-mrgn-pdng gnrl-blk invoice_cntnt">
                                    <!-- invoice content start -->

                                    <div class="invoice_row">
                                        <!-- invoice row start -->

                                        <!-- use account-name-component
                                                       make account dropdown
                                                       here use class expense_voucher for get backend query bank account
                                                       body="0" use for the query and get the index 0  expense accounts  -->
                                        <div class="invoice_col basis_col_23">
                                            <!-- invoice column -->
                                            <x-edit-account-component tabindex="1" name="account"
                                                                      class="expense_payment_voucher" id="account"
                                                                      title="Account"
                                                                      href="expense_account_registration" body="0"
                                                                      value="{{ $voucher->ep_account_id }}"/>
                                        </div>

                                        {{--                                        <div class="invoice_col basis_col_23"><!-- invoice column start --> --}}
                                        {{--                                            <div class="invoice_col_bx"><!-- invoice column box start --> --}}
                                        {{--                                                <div class="required invoice_col_ttl"><!-- invoice column title start --> --}}
                                        {{--                                                    <a data-container="body" data-toggle="popover" data-trigger="hover" --}}
                                        {{--                                                       data-placement="bottom" data-html="true" --}}
                                        {{--                                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.expense_voucher.expense_payment_voucher.account.description')}}</p>"> --}}
                                        {{--                                                        <i class="fa fa-info-circle"></i> --}}
                                        {{--                                                    </a> --}}
                                        {{--                                                    Account --}}
                                        {{--                                                </div><!-- invoice column title end --> --}}
                                        {{--                                                <div class="invoice_col_input"><!-- invoice column input start --> --}}
                                        {{--                                                    <div class="invoice_col_short"><!-- invoice column short start --> --}}
                                        {{--                                                        <a href="{{ route('expense_account_registration') }}" class="col_short_btn" target="_blank" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}"> --}}
                                        {{--                                                            <l class="fa fa-plus"></l> --}}
                                        {{--                                                        </a> --}}
                                        {{--                                                        <a id="refresh_expense_account" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}"> --}}
                                        {{--                                                            <l class="fa fa-refresh"></l> --}}
                                        {{--                                                        </a> --}}
                                        {{--                                                    </div><!-- invoice column short end --> --}}
                                        {{--                                                    <select tabindex="1" autofocus name="account" class="inputs_up form-control" id="account" --}}
                                        {{--                                                            data-rule-required="true" data-msg-required="Please Enter Account"> --}}
                                        {{--                                                        <option value="">Select Account</option> --}}
                                        {{--                                                        @foreach ($accounts as $account) --}}
                                        {{--                                                            <option value="{{$account->account_uid}}"> --}}
                                        {{--                                                                {{$account->account_name}} --}}
                                        {{--                                                            </option> --}}
                                        {{--                                                        @endforeach --}}
                                        {{--                                                    </select> --}}
                                        {{--                                                </div><!-- invoice column input end --> --}}
                                        {{--                                            </div><!-- invoice column box end --> --}}
                                        {{--                                        </div><!-- invoice column end --> --}}

                                        <div class="invoice_col basis_col_23">
                                            <!-- invoice column start -->
                                            <x-edit-remarks-component tabindex="2" name="remarks" id="remarks"
                                                                      title="Voucher Remarks"
                                                                      value="{{ $voucher->ep_remarks }}"/>
                                        </div>
                                        <div class="invoice_col basis_col_12">
                                            <!-- invoice column start -->
                                            <x-voucher-status-component value="{{ $voucher->ep_status }}"/>
                                        </div>
                                        {{--                                        <div class="invoice_col basis_col_23"><!-- invoice column start --> --}}
                                        {{--                                            <div class="invoice_col_bx"><!-- invoice column box start --> --}}
                                        {{--                                                <div class=" invoice_col_ttl"><!-- invoice column title start --> --}}
                                        {{--                                                    <a data-container="body" data-toggle="popover" data-trigger="hover" --}}
                                        {{--                                                       data-placement="bottom" data-html="true" --}}
                                        {{--                                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p> --}}
                                        {{--                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p> --}}
                                        {{--                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p> --}}
                                        {{--                                                            <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>"> --}}
                                        {{--                                                        <i class="fa fa-info-circle"></i> --}}
                                        {{--                                                    </a> --}}
                                        {{--                                                    Voucher Remarks --}}
                                        {{--                                                </div><!-- invoice column title end --> --}}
                                        {{--                                                <div class="invoice_col_input"><!-- invoice column input start --> --}}
                                        {{--                                                    <input tabindex="2" type="text" name="remarks" class="inputs_up form-control" id="remarks" placeholder="Remarks"> --}}
                                        {{--                                                </div><!-- invoice column input end --> --}}
                                        {{--                                            </div><!-- invoice column box end --> --}}
                                        {{--                                        </div><!-- invoice column end --> --}}

                                    </div><!-- invoice row end -->

                                    <div class="invoice_row">
                                        <!-- invoice row start -->

                                        <!-- use account-name-component
                                                       make expense account dropdown
                                                       here use class expense_voucher for get backend query bank account
                                                       body="1" use for the query and get the index 1  expense accounts  -->
                                        <div class="invoice_col basis_col_20">
                                            <!-- invoice column -->
                                            <x-account-name-component tabindex="3" name="account_code"
                                                                      class="expense_payment_voucher" id="account_code"
                                                                      title="Account Code"
                                                                      href="expense_account_registration" body="1"/>
                                        </div>


                                        {{--                                        <div class="invoice_col basis_col_12"><!-- invoice column start --> --}}
                                        {{--                                            <div class="invoice_col_bx"><!-- invoice column box start --> --}}
                                        {{--                                                <div class="required invoice_col_ttl"><!-- invoice column title start --> --}}
                                        {{--                                                    <a data-container="body" data-toggle="popover" data-trigger="hover" --}}
                                        {{--                                                       data-placement="bottom" data-html="true" --}}
                                        {{--                                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.expense_voucher.expense_payment_voucher.code.description')}}</p>"> --}}
                                        {{--                                                        <i class="fa fa-info-circle"></i> --}}
                                        {{--                                                    </a> --}}
                                        {{--                                                    Account Code --}}
                                        {{--                                                </div><!-- invoice column title end --> --}}
                                        {{--                                                <div class="invoice_col_input"><!-- invoice column input start --> --}}
                                        {{--                                                    <div class="invoice_col_short"><!-- invoice column short start --> --}}
                                        {{--                                                        <a href="{{ route('expense_account_registration') }}" target="_blank" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}"> --}}
                                        {{--                                                            <i class="fa fa-plus"></i> --}}
                                        {{--                                                        </a> --}}
                                        {{--                                                        <a id="refresh_account_code" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}"> --}}
                                        {{--                                                            <l class="fa fa-refresh"></l> --}}
                                        {{--                                                        </a> --}}
                                        {{--                                                    </div><!-- invoice column short end --> --}}
                                        {{--                                                    <select tabindex="3" name="account_code" class="inputs_up form-control" id="account_code" --}}
                                        {{--                                                            data-rule-required="true" data-msg-required="Please Enter Account Code" --}}
                                        {{--                                                    > --}}
                                        {{--                                                        <option value="0">Account Code</option> --}}
                                        {{--                                                        @foreach ($expense_accounts as $expense_account) --}}
                                        {{--                                                            <option value="{{$expense_account->account_uid}}"> --}}
                                        {{--                                                                {{$expense_account->account_uid}} --}}
                                        {{--                                                            </option> --}}
                                        {{--                                                        @endforeach --}}
                                        {{--                                                    </select> --}}
                                        {{--                                                </div><!-- invoice column input end --> --}}
                                        {{--                                            </div><!-- invoice column box end --> --}}
                                        {{--                                        </div><!-- invoice column end --> --}}

                                        <!-- use account-name-component
                                                       make expense account dropdown
                                                       here use class expense_voucher for get backend query bank account
                                                       body="1" use for the query and get the index 1  expense accounts  -->

                                        <div class="invoice_col basis_col_20">
                                            <!-- invoice column -->
                                            <x-account-name-component tabindex="4" name="account_name"
                                                                      class="expense_payment_voucher" id="account_name"
                                                                      title="Account Title"
                                                                      href="expense_account_registration" body="1"/>
                                        </div>

                                        {{--                                        <div class="invoice_col basis_col_20"><!-- invoice column start --> --}}
                                        {{--                                            <div class="invoice_col_bx"><!-- invoice column box start --> --}}
                                        {{--                                                <div class="required invoice_col_ttl"><!-- invoice column title start --> --}}
                                        {{--                                                    <a data-container="body" data-toggle="popover" data-trigger="hover" --}}
                                        {{--                                                       data-placement="bottom" data-html="true" --}}
                                        {{--                                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.expense_voucher.expense_payment_voucher.account_title.description')}}</p>"> --}}
                                        {{--                                                        <i class="fa fa-info-circle"></i> --}}
                                        {{--                                                    </a> --}}
                                        {{--                                                    Account Title --}}
                                        {{--                                                </div><!-- invoice column title end --> --}}
                                        {{--                                                <div class="invoice_col_input"><!-- invoice column input start --> --}}

                                        {{--                                                    <div class="invoice_col_short"><!-- invoice column short start --> --}}
                                        {{--                                                        <a href="{{ route('expense_account_registration') }}" target="_blank" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.add.description')}}"> --}}
                                        {{--                                                            <i class="fa fa-plus"></i> --}}
                                        {{--                                                        </a> --}}
                                        {{--                                                        <a id="refresh_account_name" class="col_short_btn" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-html="true" data-content="{{config('fields_info.about_form_fields.refresh.description')}}"> --}}
                                        {{--                                                            <l class="fa fa-refresh"></l> --}}
                                        {{--                                                        </a> --}}
                                        {{--                                                    </div><!-- invoice column short end --> --}}
                                        {{--                                                    <select tabindex="4" name="account_name" class="inputs_up form-control" id="account_name" --}}
                                        {{--                                                            data-rule-required="true" data-msg-required="Please Enter Account Title" --}}
                                        {{--                                                    > --}}
                                        {{--                                                        <option value="0">Account Title</option> --}}
                                        {{--                                                        @foreach ($expense_accounts as $expense_account) --}}
                                        {{--                                                            <option value="{{$expense_account->account_uid}}"> --}}
                                        {{--                                                                {{$expense_account->account_name}} --}}
                                        {{--                                                            </option> --}}
                                        {{--                                                        @endforeach --}}
                                        {{--                                                    </select> --}}

                                        {{--                                                </div><!-- invoice column input end --> --}}
                                        {{--                                            </div><!-- invoice column box end --> --}}
                                        {{--                                        </div><!-- invoice column end --> --}}

                                        <div class="invoice_col basis_col_18">
                                            <!-- invoice column start -->
                                            <x-posting-reference tabindex="4"/>
                                        </div>

                                        <!-- use remarks-component
                                                    make Transaction remarks text field -->

                                        <div class="invoice_col basis_col_20">
                                            <!-- invoice column start -->
                                            <x-remarks-component tabindex="5" name="account_remarks"
                                                                 id="account_remarks"
                                                                 title="Transaction Remarks"/>
                                        </div>

                                        {{--                                        <div class="invoice_col basis_col_23"><!-- invoice column start --> --}}
                                        {{--                                            <div class="invoice_col_bx"><!-- invoice column box start --> --}}
                                        {{--                                                <div class=" invoice_col_ttl"><!-- invoice column title start --> --}}
                                        {{--                                                    <a data-container="body" data-toggle="popover" data-trigger="hover" --}}
                                        {{--                                                       data-placement="bottom" data-html="true" --}}
                                        {{--                                                       data-content="<h6>Descriptions</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.description')}}</p> --}}
                                        {{--                                                            <h6>Benefit</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.benefits')}}</p> --}}
                                        {{--                                                            <h6>Example</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.example')}}</p> --}}
                                        {{--                                                            <h6>Validation</h6><p>{{config('fields_info.about_form_fields.party_registration.general_fields.remarks.validations') }}</P>"> --}}
                                        {{--                                                        <i class="fa fa-info-circle"></i> --}}
                                        {{--                                                    </a> --}}
                                        {{--                                                    Transaction Remarks --}}
                                        {{--                                                </div><!-- invoice column title end --> --}}
                                        {{--                                                <div class="invoice_col_input"><!-- invoice column input start --> --}}
                                        {{--                                                    <input tabindex="5" type="text" name="account_remarks" class="inputs_up form-control" id="account_remarks" placeholder="Remarks" /> --}}
                                        {{--                                                </div><!-- invoice column input end --> --}}
                                        {{--                                            </div><!-- invoice column box end --> --}}
                                        {{--                                        </div><!-- invoice column end --> --}}

                                        <div class="invoice_col basis_col_11">
                                            <!-- invoice column start -->
                                            <div class="invoice_col_bx">
                                                <!-- invoice column box start -->
                                                <div class="required invoice_col_ttl">
                                                    <!-- invoice column title start -->
                                                    <a data-container="body" data-toggle="popover" data-trigger="hover"
                                                       data-placement="bottom" data-html="true"
                                                       data-content="<h6>Descriptions</h6><p>{{ config('fields_info.about_form_fields.expense_voucher.expense_payment_voucher.amount.description') }}</p>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    Amount
                                                </div><!-- invoice column title end -->
                                                <div class="invoice_col_input">
                                                    <!-- invoice column input start -->
                                                    <input tabindex="6" type="text" name="amount"
                                                           class="inputs_up text-right form-control" id="amount"
                                                           {{--                                                           data-rule-required="true" data-msg-required="Please Enter Amount" --}} placeholder="Amount"
                                                           min="1"
                                                           onkeypress="return allow_only_number_and_decimals(this,event);"/>
                                                </div><!-- invoice column input end -->
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                        <div class="invoice_col basis_col_8">
                                            <!-- invoice column start -->
                                            <div class="invoice_col_txt for_voucher_col_bx">
                                                <!-- invoice column box start -->
                                                <div class="invoice_col_txt with_cntr_jstfy">
                                                    <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                        <button tabindex="7" id="first_add_more" class="invoice_frm_btn"
                                                                onclick="add_account()" type="button">
                                                            <i class="fa fa-plus"></i> Add
                                                        </button>
                                                    </div>
                                                    <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                        <button tabindex="-1" style="display: none;" id="cancel_button"
                                                                class="invoice_frm_btn" onclick="cancel_all()"
                                                                type="button">
                                                            <i class="fa fa-times"></i> Cancel
                                                        </button>
                                                    </div>
                                                </div>
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->

                                    </div><!-- invoice row end -->

                                    <div class="invoice_row">
                                        <!-- invoice column start -->
                                        <div class="pro_tbl_con for_voucher_tbl col-lg12">
                                            <!-- product table container start -->
                                            <div class="table-responsive pro_tbl_bx">
                                                <!-- product table box start -->
                                                <table tabindex="-1"
                                                       class="table table-bordered table-sm"
                                                       id="category_dynamic_table">
                                                    <thead style="background-color: #33A6D4;color: #fff;">
                                                    <tr>
                                                        <th class="text-center tbl_srl_9">
                                                            Code
                                                        </th>
                                                        <th class="text-center tbl_srl_20">
                                                            Title
                                                        </th>
                                                        <th class="text-center tbl_srl_20">
                                                            Project Reference
                                                        </th>
                                                        <th class="text-center tbl_srl_35">
                                                            Transaction Remarks
                                                        </th>
                                                        <th class="text-center tbl_srl_10">
                                                            Amount
                                                        </th>
                                                        <th class="text-center tbl_srl_6">
                                                            Action
                                                        </th>
                                                    </tr>
                                                    </thead>

                                                    <tbody id="table_body">
                                                    <tr>
                                                        <td tabindex="-1" colspan="10" align="center">
                                                            No Account Added
                                                        </td>
                                                    </tr>
                                                    </tbody>

                                                    <tfoot>
                                                    <tr>
                                                        <th tabindex="-1" colspan="3" class="text-right">
                                                            Total
                                                        </th>
                                                        <td class="text-center tbl_srl_12">
                                                            <div class="invoice_col_txt">
                                                                <!-- invoice column box start -->
                                                                <div class="invoice_col_input">
                                                                    <!-- invoice column input start -->
                                                                    <input tabindex="-1" type="number"
                                                                           name="total_amount"
                                                                           class="inputs_up text-right form-control grand-total-field"
                                                                           id="total_amount" placeholder="0.00" readonly
                                                                           data-rule-required="true"
                                                                           data-msg-required="Please Add">
                                                                    <span id="demo16" class="validate_sign"></span>
                                                                </div><!-- invoice column input end -->
                                                            </div><!-- invoice column box end -->
                                                        </td>
                                                    </tr>
                                                    </tfoot>

                                                </table>
                                            </div><!-- product table box end -->
                                        </div><!-- product table container end -->
                                    </div><!-- invoice column end -->
                                    <div class="invoice_row">
                                        <!-- invoice row start -->

                                        <div class="invoice_col basis_col_100">
                                            <!-- invoice column start -->
                                            <div class="invoice_col_txt with_cntr_jstfy for_voucher_btns">
                                                <!-- invoice column box start -->
                                                <div class="invoice_frm_btn_bx gnrl-mrgn-pdng gnrl-blk">
                                                    <button tabindex="8" type="submit" name="save" id="save"
                                                            class="invoice_frm_btn">
                                                        <i class="fa fa-floppy-o"></i> Save
                                                    </button>
                                                    <span id="demo28" class="validate_sign"></span>
                                                </div>
                                            </div><!-- invoice column box end -->
                                        </div><!-- invoice column end -->


                                    </div><!-- invoice row end -->

                                </div><!-- invoice content end -->
                            </div><!-- invoice scroll box end -->


                            <input tabindex="-1" type="hidden" name="accountsval" id="accountsval">
                            <input tabindex="-1" type="hidden" name="account_name_text" id="account_name_text">

                        </form>

                    </div><!-- invoice box end -->
                </div><!-- invoice container end -->


            </div> <!-- white column form ends here -->

        </div><!-- col end -->


    </div><!-- row end -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Expense Payment Voucher Detail</h4>
                    <button tabindex="-1" type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div id="table_body">

                    </div>
                    <div id="hello"></div>

                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form_controls">
                            <button tabindex="-1" type="button" class="btn btn-default form-control cancel_button"
                                    data-dismiss="modal">
                                <i class="fa fa-times"></i> Cancel
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{--    required input validation --}}
    <script type="text/javascript">
        function checkForm() {
            let account = document.getElementById("account"),
                // account_code = document.getElementById("account_code"),
                // account_name = document.getElementById("account_name"),
                // amount = document.getElementById("amount"),
                total_amount = document.getElementById("total_amount"),
                validateInputIdArray = [
                    account.id,
                    // account_code.id,
                    // account_name.id,
                    // amount.id,
                    total_amount.id,
                ];
            return validateInventoryInputs(validateInputIdArray);
        }
    </script>
    {{-- end of required input validation --}}
    @if (Session::get('ep_id'))
        <script>
            jQuery("#table_body").html("");
            var id = '{{ Session::get('ep_id') }}';
            $(".modal-body").load('{{ url('expense_payment_items_view_details/view/') }}/' + id, function () {
                $("#myModal").modal({
                    show: true
                });
            });
        </script>
    @endif

    <script>
        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                $("#first_add_more").click();
                // event.preventDefault();
                return false;
            }
        });

        // jQuery("#refresh_expense_account").click(function() {
        //
        //     jQuery.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //     jQuery.ajax({
        //         url: "refresh_expense_payment",
        //         data:{},
        //         type: "POST",
        //         cache:false,
        //         dataType: 'json',
        //         success:function(data){
        //
        //             jQuery("#account").html(" ");
        //             jQuery("#account").append(data);
        //         },
        //         error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
        //             alert(errorThrown);}
        //     });
        // });
        //
        // // refesh account code and name
        // jQuery("#refresh_account_code").click(function() {
        //
        //     jQuery.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //
        //     jQuery.ajax({
        //         url: "refresh_expense_account_code",
        //         data:{},
        //         type: "POST",
        //         cache:false,
        //         dataType: 'json',
        //         success:function(data){
        //
        //             console.log(data);
        //
        //             jQuery("#account_code").html(" ");
        //             jQuery("#account_code").append(data);
        //         },
        //         error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
        //             alert(errorThrown);}
        //     });
        // });
        //
        // jQuery("#refresh_account_code").click(function() {
        //
        //     jQuery.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //
        //     jQuery.ajax({
        //         url: "refresh_expense_account_name",
        //         data:{},
        //         type: "POST",
        //         cache:false,
        //         dataType: 'json',
        //         success:function(data){
        //
        //             console.log(data);
        //
        //             jQuery("#account_name").html(" ");
        //             jQuery("#account_name").append(data);
        //         },
        //         error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
        //             alert(errorThrown);}
        //     });
        // });
        //
        // jQuery("#refresh_account_name").click(function() {
        //
        //     jQuery.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //
        //     jQuery.ajax({
        //         url: "refresh_expense_account_code",
        //         data:{},
        //         type: "POST",
        //         cache:false,
        //         dataType: 'json',
        //         success:function(data){
        //
        //             console.log(data);
        //
        //             jQuery("#account_code").html(" ");
        //             jQuery("#account_code").append(data);
        //         },
        //         error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
        //             alert(errorThrown);}
        //     });
        // });
        //
        // jQuery("#refresh_account_name").click(function() {
        //
        //     jQuery.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //
        //     jQuery.ajax({
        //         url: "refresh_expense_account_name",
        //         data:{},
        //         type: "POST",
        //         cache:false,
        //         dataType: 'json',
        //         success:function(data){
        //
        //             console.log(data);
        //
        //             jQuery("#account_name").html(" ");
        //             jQuery("#account_name").append(data);
        //         },
        //         error: function (jqXHR, textStatus, errorThrown) {alert(jqXHR.responseText);
        //             alert(errorThrown);}
        //     });
        // });
    </script>

    <script>
        jQuery("#account").change(function () {
            var account_name_text = jQuery("option:selected", this).text();
            jQuery("#account_name_text").val(account_name_text);
        });
    </script>

    <script>
        jQuery("#account_code").change(function () {

            var account_code = jQuery('option:selected', this).val();

            jQuery("#account_name").select2("destroy");
            jQuery('#account_name option[value="' + account_code + '"]').prop('selected', true);
            jQuery("#account_name").select2();
        });
    </script>

    <script>
        jQuery("#account_name").change(function () {

            var account_name = jQuery('option:selected', this).val();

            jQuery("#account_code").select2("destroy");
            jQuery('#account_code option[value="' + account_name + '"]').prop('selected', true);
            jQuery("#account_code").select2();
        });
    </script>

    <script>
        // adding packs into table
        var numberofaccounts = 0;
        var counter = 0;
        var accounts = {};
        var global_id_to_edit = 0;

        jQuery(document).ready(function () {
            let array = JSON.parse('{!! json_encode($voucher_items) !!}');
            $.each(array, function (index, value) {

                console.log(value);

                var account_code = value.epi_account_id;
                var account_name = value.epi_account_id;
                var account_name_text = value.epi_account_name;
                var amount = value.epi_amount;
                var account_remarks = value.epi_remarks;
                var posting_reference = value.epi_pr_id;
                var posting_reference_text = value.name;


                var flag_submit1 = true;
                var focus_once1 = 0;

                if (account_code == 0) {

                    if (focus_once1 == 0) {
                        jQuery("#account_name").focus();
                        focus_once1 = 1;
                    }
                    flag_submit1 = false;
                }


                if (account_name == 0) {

                    if (focus_once1 == 0) {
                        jQuery("#account_name").focus();
                        focus_once1 = 1;
                    }
                    flag_submit1 = false;
                }
                if (posting_reference == 0) {

                    if (focus_once1 == 0) {
                        jQuery("#posting_reference").focus();
                        focus_once1 = 1;
                    }
                    flag_submit1 = false;
                }


                if (amount == "" || amount == '0') {


                    if (focus_once1 == 0) {
                        jQuery("#amount").focus();
                        focus_once1 = 1;
                    }
                    flag_submit1 = false;
                }


                if (flag_submit1) {

                    if (global_id_to_edit != 0) {
                        jQuery("#" + global_id_to_edit).remove();

                        delete accounts[global_id_to_edit];
                    }

                    counter++;

                    // jQuery("#account_code").select2("destroy");
                    // jQuery("#account_name").select2("destroy");
                    // jQuery("#posting_reference").select2("destroy");

                    var checkedValue = [];


                    if (remarks == '') {
                        remarks = account_name;
                    }
                    numberofaccounts = Object.keys(accounts).length;

                    if (numberofaccounts == 0) {
                        jQuery("#table_body").html("");
                    }

                    accounts[counter] = {
                        'account_code': account_code,
                        'account_name': account_name_text,
                        'account_amount': amount,
                        'account_remarks': account_remarks,
                        'posting_reference': posting_reference,
                        'posting_reference_name': posting_reference_text,
                    };

                    // jQuery("#account_code option[value=" + account_code + "]").attr("disabled", "true");
                    // jQuery("#account_name option[value=" + account_code + "]").attr("disabled", "true");
                    numberofaccounts = Object.keys(accounts).length;
                    var remarks_var = '';
                    if (account_remarks != '') {
                        var remarks_var = '' + account_remarks + '';
                    }


                    jQuery("#table_body").append(
                        `<tr id="${counter}" class="edit_update">
                                <td class="text-center tbl_srl_9">${account_code}</td>
                                <td class="text-left tbl_srl_20">${account_name_text}</td>
                                <td class="text-left tbl_srl_20">${posting_reference_text}</td>
                                <td class="text-left tbl_srl_35">${remarks_var}</td>
                                <td class="text-right tbl_srl_10">${amount}</td>
                                <td class="text-right tbl_srl_6">
                                    <a class="edit_link btn btn-sm btn-success" href="#" onclick="edit_account(${counter})" style="font-size: 0px;padding: 2px;">
                                        <i class="fa fa-edit" style="font-size: 10px;"></i>
                                    </a>
                                    <a href="#" class="delete_link btn btn-sm btn-danger" onclick="delete_account(${counter})" style="font-size: 0px;padding: 2px;">
                                        <i class="fa fa-trash" style="font-size: 10px;"></i>
                                    </a>
                                </td>
                            </tr>`);

                    jQuery('#account_code option[value="' + 0 + '"]').prop('selected', true);
                    jQuery('#account_name option[value="' + 0 + '"]').prop('selected', true);
                    // jQuery('#posting_reference option[value="' + 0 + '"]').prop('selected', true);

                    jQuery("#amount").val("");
                    jQuery("#account_remarks").val("");

                    jQuery("#accountsval").val(JSON.stringify(accounts));
                    jQuery("#cancel_button").hide();
                    jQuery(".table-responsive").show();
                    jQuery("#save").show();
                    jQuery("#first_add_more").html('<i class="fa fa-plus"></i> Add');

                    jQuery("#account_code").select2();
                    jQuery("#account_name").select2();
                    // jQuery("#posting_reference").select2();

                    total_calculation();

                    jQuery(".edit_link").show();
                    jQuery(".delete_link").show();
                }


            });
        });

        function add_account() {

            var account_code = document.getElementById("account_code").value;
            var account_name = document.getElementById("account_name").value;
            var account_name_text = jQuery("#account_name option:selected").text();
            var amount = document.getElementById("amount").value;
            var account_remarks = document.getElementById("account_remarks").value;
            var posting_reference = document.getElementById("posting_reference").value;
            var posting_reference_text = jQuery("#posting_reference option:selected").text();

            var flag_submit1 = true;
            var focus_once1 = 0;

            if (account_code == 0) {

                if (focus_once1 == 0) {
                    jQuery("#account_name").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (account_name == 0) {

                if (focus_once1 == 0) {
                    jQuery("#account_name").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            } else if (posting_reference == 0) {

                if (focus_once1 == 0) {
                    jQuery("#posting_reference").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            } else if (amount == "" || amount == '0') {

                if (focus_once1 == 0) {
                    jQuery("#amount").focus();
                    focus_once1 = 1;
                }
                flag_submit1 = false;
            }


            if (flag_submit1) {

                if (global_id_to_edit != 0) {
                    jQuery("#" + global_id_to_edit).remove();

                    delete accounts[global_id_to_edit];
                }

                counter++;

                jQuery("#account_code").select2("destroy");
                jQuery("#account_name").select2("destroy");
                // jQuery("#posting_reference").select2("destroy");

                var checkedValue = [];


                if (remarks == '') {
                    remarks = account_name;
                }
                numberofaccounts = Object.keys(accounts).length;

                if (numberofaccounts == 0) {
                    jQuery("#table_body").html("");
                }

                accounts[counter] = {
                    'account_code': account_code,
                    'account_name': account_name_text,
                    'account_amount': amount,
                    'account_remarks': account_remarks,
                    'posting_reference': posting_reference,
                    'posting_reference_name': posting_reference_text,
                };

                // jQuery("#account_code option[value=" + account_code + "]").attr("disabled", "true");
                // jQuery("#account_name option[value=" + account_code + "]").attr("disabled", "true");
                numberofaccounts = Object.keys(accounts).length;
                var remarks_var = '';
                if (account_remarks != '') {
                    var remarks_var = '' + account_remarks + '';
                }


                jQuery("#table_body").append(
                    `<tr id="${counter}" class="edit_update">
                                <td class="text-center tbl_srl_9">${account_code}</td>
                                <td class="text-left tbl_srl_20">${account_name_text}</td>
                                <td class="text-left tbl_srl_20">${posting_reference_text}</td>
                                <td class="text-left tbl_srl_35">${remarks_var}</td>
                                <td class="text-right tbl_srl_10">${amount}</td>
                                <td class="text-right tbl_srl_6">
                                    <a class="edit_link btn btn-sm btn-success" href="#" onclick="edit_account(${counter})" style="font-size: 0px;padding: 2px;">
                                        <i class="fa fa-edit" style="font-size: 10px;"></i>
                                    </a>
                                    <a href="#" class="delete_link btn btn-sm btn-danger" onclick="delete_account(${counter})" style="font-size: 0px;padding: 2px;">
                                        <i class="fa fa-trash" style="font-size: 10px;"></i>
                                    </a>
                                </td>
                            </tr>`);

                jQuery('#account_code option[value="' + 0 + '"]').prop('selected', true);
                jQuery('#account_name option[value="' + 0 + '"]').prop('selected', true);
                // jQuery('#posting_reference option[value="' + 0 + '"]').prop('selected', true);

                jQuery("#amount").val("");
                jQuery("#account_remarks").val("");

                jQuery("#accountsval").val(JSON.stringify(accounts));
                jQuery("#cancel_button").hide();
                jQuery(".table-responsive").show();
                jQuery("#save").show();
                jQuery("#first_add_more").html('<i class="fa fa-plus"></i> Add');

                jQuery("#account_code").select2();
                jQuery("#account_name").select2();
                // jQuery("#posting_reference").select2();

                total_calculation();

                jQuery(".edit_link").show();
                jQuery(".delete_link").show();
                jQuery("#account_name").focus();
            }
        }

        function total_calculation() {
            var total_amount = 0;

            jQuery.each(accounts, function (index, value) {
                total_amount = +total_amount + +value['account_amount'];
            });

            jQuery("#total_amount").val(total_amount);
        }


        function delete_account(current_item) {

            jQuery("#" + current_item).remove();
            var temp_accounts = accounts[current_item];
            // jQuery("#account_code option[value=" + temp_accounts['account_code'] + "]").attr("disabled", false);
            // jQuery("#account_name option[value=" + temp_accounts['account_code'] + "]").attr("disabled", false);

            delete accounts[current_item];

            function isEmpty(obj) {

                for (var key in obj) {

                    if (obj.hasOwnProperty(key))
                        return false;
                }
                return true;
            }

            jQuery("#accountsval").val(JSON.stringify(accounts));

            if (isEmpty(accounts)) {
                numberofaccounts = 0;
            }

            total_calculation();

            jQuery("#account_code").select2("destroy");
            jQuery("#account_name").select2("destroy");

            jQuery("#account_code").select2();
            jQuery("#account_name").select2();

        }


        function edit_account(current_item) {

            // jQuery(".table-responsive").attr("style", "display:none");
            jQuery("#" + current_item).attr("style", "display:none");
            jQuery("#save").attr("style", "display:none");
            jQuery("#first_add_more").html('<i class="fa fa-plus"></i> update');
            jQuery("#cancel_button").show();

            jQuery(".edit_link").hide();
            jQuery(".delete_link").hide();

            global_id_to_edit = current_item;

            var temp_accounts = accounts[current_item];

            jQuery("#account_code").select2("destroy");
            jQuery("#account_name").select2("destroy");
            jQuery("#posting_reference").select2("destroy");


            // jQuery("#account_code option[value=" + temp_accounts['account_code'] + "]").attr("disabled", false);
            // jQuery("#account_name option[value=" + temp_accounts['account_code'] + "]").attr("disabled", false);

            jQuery('#account_code option[value="' + temp_accounts['account_code'] + '"]').prop('selected', true);
            jQuery('#account_name option[value="' + temp_accounts['account_code'] + '"]').prop('selected', true);
            jQuery('#posting_reference option[value="' + temp_accounts['posting_reference'] + '"]').prop('selected', true);

            jQuery("#amount").val(temp_accounts['account_amount']);
            jQuery("#account_remarks").val(temp_accounts['account_remarks']);


            jQuery("#account_code").select2();
            jQuery("#account_name").select2();
            jQuery("#posting_reference").select2();

            jQuery("#cancel_button").attr("style", "display:inline");
            jQuery("#cancel_button").attr("style", "background-color:red !important");
        }

        function cancel_all() {

            var newvaltohide = jQuery("#account_code").val();

            // jQuery("#account_code option[value=" + newvaltohide + "]").attr("disabled", "true");
            // jQuery("#account_name option[value=" + newvaltohide + "]").attr("disabled", "true");

            jQuery('#account_code option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#account_name option[value="' + 0 + '"]').prop('selected', true);
            jQuery('#posting_reference option[value="' + 0 + '"]').prop('selected', true);

            jQuery("#account_code").select2("destroy");
            jQuery("#account_name").select2("destroy");
            jQuery("#posting_reference").select2("destroy");

            jQuery("#account_remarks").val("");
            jQuery("#amount").val("");

            jQuery("#account_code").select2();
            jQuery("#account_name").select2();
            jQuery("#posting_reference").select2();

            jQuery("#cancel_button").hide();

            // jQuery(".table-responsive").show();
            jQuery("#" + global_id_to_edit).show();

            jQuery("#save").show();

            jQuery("#first_add_more").html('<i class="fa fa-plus"></i> Add');
            global_id_to_edit = 0;

            jQuery(".edit_link").show();
            jQuery(".delete_link").show();
        }
    </script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#account_code").select2();
            jQuery("#account_name").select2();
            jQuery("#account").select2();
            jQuery("#posting_reference").select2();
        });
    </script>
@endsection
