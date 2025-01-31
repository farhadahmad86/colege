@extends('extend_index')

@section('content')
    <style>
        @font-face {
            font-family: Jameel;
            src: url({{asset('public/urdu_font/Jameel.ttf')}});
        }
        .fonti {
            font-family: Jameel;
        }

    </style>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="container-fluid search-filter form-group form_manage" id="printTable">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white file_name get-heading-text">Chart Of Account Ledger {{ ' ( '.$account_name . ' ) ' }}</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

            <!-- <div class="search_form {{ ( !empty($search_to) || !empty($search_from) || !empty($account_id) || !empty($search_by_invoice_type) || !empty($account_name) || !empty($search_branch) ) ? '' : '' }}"> -->

                <div class="search_form m-0 p-0">

                    <form class="highlight prnt_lst_frm" action="{{ route('chart_of_account_ledger') }}" name="form1" id="form1" method="post" class="accountLedger w-80p d-inline" autocomplete="off">
                        @csrf

                        <div class="row">

                            <div class="start form-group col-lg-4 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="required">Account :</label>
                                    <select tabindex="1" autofocus class="inputs_up form-control cstm_clm_srch" name="account_id" id="account_id">
                                        <option value="">Select Account</option>
                                        @foreach($account_lists as $account_list)
                                            <option value="{{$account_list->account_uid}}" {{ $account_list->account_uid == $account_id ? 'selected="selected"' : ''
                                                        }}>{{$account_list->account_uid}} - {{$account_list->account_name}}</option>
                                        @endforeach
                                    </select>
                                </div><!-- end input box -->
                            </div>

                            <div class="start form-group col-lg-1 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="required">To :</label>
                                    <input tabindex="2" type="text" name="to" id="to" class="inputs_up form-control date-picker" <?php if(isset($search_to)){?> value="{{$search_to}}"
                                           <?php } ?> placeholder="Start From..."/>
                                    <span id="demo1" class="validate_sign"> </span>
                                </div><!-- end input box -->
                            </div>

                            <div class="end form-group col-lg-1 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="required">From :</label>
                                    <input tabindex="3" type="text" name="from" id="from" class="inputs_up form-control date-picker" <?php if(isset($search_from)){?> value="{{$search_from}}"
                                           <?php } ?> placeholder="End From..."/>
                                    <span id="demo2" class="validate_sign"> </span>
                                </div><!-- end input box -->
                            </div>

                            <div class="start form-group col-lg-2 col-md-3 col-sm-12 col-xs-12 hidden">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="required">Invoice Type :</label>
                                    <select tabindex="4" class="inputs_up form-control cstm_clm_srch" name="invoice_type" id="invoice_type">
                                        <option value="">Select Invoice Type</option>

                                        <option value="{{config('global_variables.PURCHASE_VOUCHER_CODE')}}" {{ config('global_variables.PURCHASE_VOUCHER_CODE') == $search_by_invoice_type ?
                                                    'selected="selected"' : ''}}> PURCHASE_VOUCHER_CODE
                                        </option>
                                        <option value="{{config('global_variables.PURCHASE_RETURN_VOUCHER_CODE')}}" {{ config('global_variables.PURCHASE_RETURN_VOUCHER_CODE') ==
                                                    $search_by_invoice_type ? 'selected="selected"' : ''}}> PURCHASE_RETURN_VOUCHER_CODE
                                        </option>
                                        <option value="{{config('global_variables.PURCHASE_SALE_TAX_VOUCHER_CODE')}}" {{ config('global_variables.PURCHASE_SALE_TAX_VOUCHER_CODE') ==
                                                    $search_by_invoice_type ? 'selected="selected"' : ''}}> PURCHASE_SALE_TAX_VOUCHER_CODE
                                        </option>
                                        <option
                                            value="{{config('global_variables.PURCHASE_RETURN_SALE_TAX_VOUCHER_CODE')}}" {{ config('global_variables.PURCHASE_RETURN_SALE_TAX_VOUCHER_CODE') == $search_by_invoice_type ? 'selected="selected"' : ' '}}>
                                            PURCHASE_RETURN_SALE_TAX_VOUCHER_CODE
                                        </option>
                                        <option value="{{config('global_variables.SALE_VOUCHER_CODE')}}" {{ config('global_variables.SALE_VOUCHER_CODE') == $search_by_invoice_type ?
                                                    'selected="selected"' : ''}}> SALE_VOUCHER_CODE
                                        </option>
                                        <option value="{{config('global_variables.SALE_RETURN_VOUCHER_CODE')}}" {{ config('global_variables.SALE_RETURN_VOUCHER_CODE') == $search_by_invoice_type ?
                                                     'selected="selected"' : ''}}> SALE_RETURN_VOUCHER_CODE
                                        </option>
                                        <option value="{{config('global_variables.SALE_SALE_TAX_VOUCHER_CODE')}}" {{ config('global_variables.SALE_SALE_TAX_VOUCHER_CODE') ==
                                                    $search_by_invoice_type ? 'selected="selected"' : ''}}> SALE_SALE_TAX_VOUCHER_CODE
                                        </option>
                                        <option value="{{config('global_variables.SALE_RETURN_SALE_TAX_VOUCHER_CODE')}}" {{ config('global_variables.SALE_RETURN_SALE_TAX_VOUCHER_CODE')
                                                    == $search_by_invoice_type ? 'selected="selected"' : ''}}> SALE_RETURN_SALE_TAX_VOUCHER_CODE
                                        </option>
                                        <option value="{{config('global_variables.JOURNAL_VOUCHER_CODE')}}" {{ config('global_variables.JOURNAL_VOUCHER_CODE') == $search_by_invoice_type ?
                                                    'selected="selected"' : ''}}> JOURNAL_VOUCHER_CODE
                                        </option>
                                        <option value="{{config('global_variables.CASH_RECEIPT_VOUCHER_CODE')}}" {{ config('global_variables.CASH_RECEIPT_VOUCHER_CODE') == $search_by_invoice_type
                                                     ? 'selected="selected"' : ''}}> CASH_RECEIPT_VOUCHER_CODE
                                        </option>
                                        <option value="{{config('global_variables.CASH_PAYMENT_VOUCHER_CODE')}}" {{ config('global_variables.CASH_PAYMENT_VOUCHER_CODE') == $search_by_invoice_type
                                                     ? 'selected="selected"' : ''}}> CASH_PAYMENT_VOUCHER_CODE
                                        </option>
                                        <option value="{{config('global_variables.BANK_RECEIPT_VOUCHER_CODE')}}" {{ config('global_variables.BANK_RECEIPT_VOUCHER_CODE') == $search_by_invoice_type
                                                     ? 'selected="selected"' : ''}}> BANK_RECEIPT_VOUCHER_CODE
                                        </option>
                                        <option value="{{config('global_variables.BANK_PAYMENT_VOUCHER_CODE')}}" {{ config('global_variables.BANK_PAYMENT_VOUCHER_CODE') == $search_by_invoice_type
                                                     ? 'selected="selected"' : ''}}> BANK_PAYMENT_VOUCHER_CODE
                                        </option>
                                        <option value="{{config('global_variables.EXPENSE_PAYMENT_VOUCHER_CODE')}}" {{ config('global_variables.EXPENSE_PAYMENT_VOUCHER_CODE') ==
                                                    $search_by_invoice_type ? 'selected="selected"' : ''}}> EXPENSE_PAYMENT_VOUCHER_CODE
                                        </option>
                                        <option value="{{config('global_variables.ADVANCE_SALARY_VOUCHER_CODE')}}" {{ config('global_variables.ADVANCE_SALARY_VOUCHER_CODE') ==
                                                    $search_by_invoice_type ? 'selected="selected"' : ''}}> ADVANCE_SALARY_VOUCHER_CODE
                                        </option>
                                        <option value="{{config('global_variables.SALARY_SLIP_VOUCHER_CODE')}}" {{ config('global_variables.SALARY_SLIP_VOUCHER_CODE') == $search_by_invoice_type ?
                                                     'selected="selected"' : ''}}> SALARY_SLIP_VOUCHER_CODE
                                        </option>
                                        <option value="{{config('global_variables.SALARY_PAYMENT_VOUCHER_CODE')}}" {{ config('global_variables.SALARY_PAYMENT_VOUCHER_CODE') ==
                                                    $search_by_invoice_type ? 'selected="selected"' : ''}}> SALARY_PAYMENT_VOUCHER_CODE
                                        </option>
                                        <option value="{{config('global_variables.SERVICE_VOUCHER_CODE')}}" {{ config('global_variables.SERVICE_VOUCHER_CODE') == $search_by_invoice_type ?
                                                    'selected="selected"' : ''}}> SERVICE_VOUCHER_CODE
                                        </option>
                                        <option value="{{config('global_variables.SERVICE_SALE_TAX_VOUCHER_CODE')}}" {{ config('global_variables.SERVICE_SALE_TAX_VOUCHER_CODE') ==
                                                    $search_by_invoice_type ? 'selected="selected"' : ''}}> SERVICE_SALE_TAX_VOUCHER_CODE
                                        </option>
                                        <option value="{{config('global_variables.PRODUCT_LOSS_VOUCHER_CODE')}}" {{ config('global_variables.PRODUCT_LOSS_VOUCHER_CODE') == $search_by_invoice_type
                                                     ? 'selected="selected"' : ''}}> PRODUCT_LOSS_VOUCHER_CODE
                                        </option>
                                        <option value="{{config('global_variables.PRODUCT_RECOVER_VOUCHER_CODE')}}" {{ config('global_variables.PRODUCT_RECOVER_VOUCHER_CODE') ==
                                                    $search_by_invoice_type ? 'selected="selected"' : ''}}> PRODUCT_RECOVER_VOUCHER_CODE
                                        </option>
                                        <option value="{{config('global_variables.CASH_TRANSFER_CODE')}}" {{ config('global_variables.CASH_TRANSFER_CODE') == $search_by_invoice_type ?
                                                    'selected="selected"' : ''}}> CASH_TRANSFER_CODE
                                        </option>
                                        <option value="{{config('global_variables.POST_DATED_CHEQUE_ISSUE')}}" {{ config('global_variables.POST_DATED_CHEQUE_ISSUE') == $search_by_invoice_type ?
                                                    'selected="selected"' : ''}}> POST_DATED_CHEQUE_ISSUE
                                        </option>
                                        <option value="{{config('global_variables.POST_DATED_CHEQUE_RECEIVED')}}" {{ config('global_variables.POST_DATED_CHEQUE_RECEIVED') ==
                                                    $search_by_invoice_type ? 'selected="selected"' : ''}}> POST_DATED_CHEQUE_RECEIVED
                                        </option>
                                        {{--        <option value="{{config('global_variables.website_path')}}" {{ config('global_variables.website_path') == $search_by_invoice_type ? 'selected="selected"' : ''}}> </option>--}}

                                    </select>
                                </div><!-- end input box -->
                            </div>

                            <div class="end form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label class="required">Campus :</label>
                                    <select tabindex="1" autofocus class="inputs_up form-control cstm_clm_srch" name="branch" id="branch">
                                        <option value="">Select Campus</option>
                                        @foreach($branches as $branch)
                                            <option value="{{$branch->branch_id}}" {{ $branch->branch_id == $search_branch ? 'selected="selected"' : ''
                                                        }}>{{$branch->branch_id}} - {{$branch->branch_name}}</option>
                                        @endforeach
                                    </select>
                                </div><!-- end input box -->
                            </div>
                            <x-year-end-component search="{{$search_year}}"/>
                            <div class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12 text-right mt-4">

                                @include('include.clear_search_button')

                                @include('include/print_button')

                            </div>

                            <input value="{{$account_name}}" name="account_name" id="account_name" type="hidden">

                        </div>
                    </form>

                </div><!-- search form end -->


                <div class="table-responsive" id="">
                    <table class="table table-bordered table-sm" id="">

                        <thead>
                        <tr>
                            <th tabindex="-1" scope="col" class="tbl_srl_4">
                                Sr.
                            </th>
                            <th scope="col" class="tbl_amnt_8">
                                Date
                            </th>
                            <th scope="col" class="tbl_amnt_9">
                                Voucher No.
                            </th>
                            <th scope="col" class="tbl_amnt_9">
                                Campus
                            </th>
                            <th scope="col" class="tbl_txt_17">
                                Remarks
                            </th>
                            <th scope="col" class="tbl_txt_20">
                                Detail Remarks
                            </th>
                            <th scope="col" class="tbl_amnt_10">
                                Debit
                            </th>
                            <th scope="col" class="tbl_amnt_10">
                                Credit
                            </th>
                            <th scope="col" class="tbl_amnt_13">
                                Total Balance
                            </th>

                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $sr = 1;
                            $DR = $ttlDr = $CR = $ttlCr = $bal = $ttlBal = 0;
                        @endphp


                        @forelse($datas as $ledger)

                            @php
                                $DR = $ledger->bal_dr;
                                $CR = $ledger->bal_cr;
                                $bal = $ledger->bal_total;
                                $ttlDr = +$DR + +$ttlDr;
                                $ttlCr = +$CR + +$ttlCr;
                                $ttlBal = $bal;

                                $account=substr($ledger->bal_account_id,0,5);
                                $type=substr($ledger->bal_voucher_number,0,2);
                            @endphp

                            <tr>
                                <th>
                                    {{ $sr }}
                                </th>
                                <td>
                                    {{date('d-M-y', strtotime(str_replace('/', '-', $ledger->bal_day_end_date)))}}
                                </td>
                                <td>
                                    <a class="view" data-transcation_id="{{$ledger->bal_voucher_number}}" data-toggle="modal" data-target="#myModal" style="cursor:pointer; color: #0099ff;">
                                        {{$ledger->bal_voucher_number}}
                                    </a>
                                </td>
                                <td>
                                        {{$ledger->branch_name}}
                                </td>
                                <td class="fonti">
                                    {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br /> <hr />', $ledger->bal_remarks) !!}
                                </td>
                                <td class="fonti">
                                    @if($account!=config('global_variables.receivable') && $account!=config('global_variables.payable'))
                                        {!! str_replace('&oS;', '<br />', $ledger->bal_detail_remarks) !!}
                                    @elseif($type=='JV' || $type=='CP' || $type=='CR' || $type=='BP' || $type=='BR')
                                    @else
                                        {!! str_replace('&oS;', '<br />', $ledger->bal_detail_remarks) !!}
                                        {{--                                            {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br /> <hr />', $ledger->bal_detail_remarks) !!}--}}
                                        {{--                                            {!! $ledger->bal_detail_remarks !!}--}}
                                        {{--                                            {!! str_replace("&oS;",'<br />', $ledger->bal_detail_remarks) !!}--}}
                                    @endif
                                </td>
                                <td class="align_right text-right">
                                    {{$ledger->bal_dr !=0 ? number_format($ledger->bal_dr,2):''}}
                                </td>
                                <td class="align_right text-right">
                                    {{$ledger->bal_cr !=0 ? number_format($ledger->bal_cr,2):''}}
                                </td>
                                <td class="align_right text-right">
                                    {{$ledger->bal_total !=0 ? number_format($ledger->bal_total,2):''}}
                                </td>

                            </tr>
                            @php
                                $sr++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="11">
                                    <center><h3 style="color:#554F4F">No Ledger</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        @if($opening_balance != '')
                            <tr>
                                <th>
                                    {{ $sr }}
                                </th>
                                <td>
                                    {{date('d-M-y', strtotime(str_replace('/', '-', $search_to)))}}
                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                    OPENING_BALANCE
                                </td>

                                <td>

                                </td>
                                <td class="align_right text-right">

                                </td>
                                <td class="align_right text-right">

                                </td>
                                <td class="align_right text-right">
                                    {{$opening_balance}}
                                </td>

                            </tr>
                        @endif
                        </tbody>

                        <tfoot>
                        <tr class="border-0">
                            <th colspan="6" align="right" class="border-0 text-right align_right pt-0">
                                Total:
                            </th>
                            <td class="text-right border-left-0" align="right" style="border-top: 2px solid #000;border-bottom: 3px double #000;border-right: 0px solid transparent;">
                                {{ number_format($ttlDr,2) }}
                            </td>
                            <td class="text-right border-left-0" align="right" style="border-top: 2px solid #000;border-bottom: 3px double #000;border-right: 0px solid transparent;">
                                {{ number_format($ttlCr,2) }}
                            </td>
                            @php
                                $difBal = $ttlDr - $ttlCr;
                            @endphp
                            <td class="text-right border-left-0" align="right" style="border-top: 2px solid #000;border-bottom: 3px double #000;border-right: 0px solid transparent;">
                                {{ number_format($difBal,2)}}
                            </td>
                            {{--                                    <td class="text-right border-left-0" align="right" style="border-top: 2px solid #000;border-bottom: 3px double #000;border-right: 0px solid transparent;">--}}
                            {{--                                        {{ number_format($ttlBal,2) }}--}}
                            {{--                                    </td>--}}
                        </tr>
                        </tfoot>

                    </table>


                </div>
            </div> <!-- white column form ends here -->


        </div><!-- col end -->


    </div><!-- row end -->

    <!-- Modal -->
    <div class="modal fade" id="purchase_modal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="width: 1250px; margin-left: -220px;">
                <div class="modal-header">
                    <h4 class="modal-title text-blue">Items Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col" style="width:50px; text-align: center !important" align="center">Pro #</th>
                                <th scope="col" style="width:80px; text-align: center !important" align="center">Pro-Name</th>
                                <th scope="col" style="width:50px; text-align: center !important" align="center">Qty</th>
                                <th scope="col" style="width:80px; text-align: center !important" align="center">Rate</th>
                                <th scope="col" style="width:80px; text-align: center !important" align="center">Discount</th>
                                <th scope="col" style="width:80px; text-align: center !important" align="center">Sale Tax</th>
                                <th scope="col" style="width:80px; text-align: center !important" align="center">Amount</th>
                                <th scope="col" style="width:80px; text-align: center !important" align="center">G.Rate</th>
                                <th scope="col" style="width:80px; text-align: center !important" align="center">Expense per Pro.</th>
                                <th scope="col" style="width:80px; text-align: center !important" align="center">Net Rate</th>
                                <th scope="col" style="width:80px; text-align: center !important" align="center">Remarks</th>
                            </tr>
                            </thead>
                            <tbody id="table_body1">

                            </tbody>
                        </table>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-lg-2 col-md-2 col-sm-2">
                    </div>
                    <div class="col-lg-6 col-md-6"></div>
                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <button type="button" class="btn btn-default form-control cancel_button" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-blue table-header">Items Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive table-values">
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-lg-2 col-md-2 col-sm-2">
                    </div>
                    <div class="col-lg-6 col-md-6"></div>
                    <div class="col-lg-2 col-md-2 col-sm-2">
                        <button type="button" class="btn btn-default form-control cancel_button" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('chart_of_account_ledger') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        jQuery(".view").click(function () {

            var transcation_id = jQuery(this).attr("data-transcation_id");

            jQuery(".table-header").html("");
            jQuery(".table-values").html("");

            $(".modal-body").load('{{ url('/transaction_view_details_SH/') }}/' + transcation_id, function () {
                $('#myModal').modal({show: true});
            });
        });

    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>

    <script>

        jQuery("#account_id").change(function () {

            var account_name = jQuery("#account_id option:selected").text();
            jQuery("#account_name").val(account_name);
        });

        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#account_id").select2();
            jQuery("#invoice_type").select2();
            jQuery("#branch").select2();
        });

    </script>

    <script>
        jQuery("#cancel").click(function () {

            $("#account_id").select2().val(null).trigger("change");
            $("#account_id > option").removeAttr('selected');

            $("#invoice_type").select2().val(null).trigger("change");
            $("#invoice_type > option").removeAttr('selected');

            $("#branch").select2().val(null).trigger("change");
            $("#branch > option").removeAttr('selected');

            $("#to").val('');
            $("#from").val('');
        });
    </script>

@endsection

