@extends('extend_index')

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Account Ledger</h4>
                        </div>
                    </div>
                </div><!-- form header close -->
                <div class="search_form m-0 p-0">

                    <form class="highlight prnt_lst_frm" action="{{ route('parent_account_ledger') }}" name="form1" id="form1" method="post" class="accountLedger w-80p d-inline">
                        @csrf

                        <div class="row">

                            <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="Search ..."
                                           value="{{ isset($search) ? $search : '' }}" autocomplete="off">
                                    <datalist id="browsers">
                                        {{--                                                    @foreach($account_names as $value)--}}
                                        {{--                                                        <option value="{{$value}}">--}}
                                        {{--                                                    @endforeach--}}
                                    </datalist>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->

                            <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 srch_brdr_left">
                                <div class="row">

                                    <div class="start form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="required">Start Date :</label>
                                            <input type="text" name="start_date" id="start_date" class="inputs_up form-control date-picker" autocomplete="off" <?php if(isset
                                            ($start_date)){?> value="{{$start_date}}" <?php } ?> placeholder="Start Date..."/>
                                            {{--                                                    <span id="demo1" class="validate_sign"> </span>--}}
                                        </div><!-- end input box -->
                                    </div>

                                    <div class="start form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="required">End Date :</label>
                                            <input type="text" name="end_date" id="end_date" class="inputs_up form-control date-picker" autocomplete="off" <?php if(isset
                                            ($end_date)){?> value="{{$end_date}}" <?php } ?> placeholder="End Date..."/>
                                            {{--                                                    <span id="demo1" class="validate_sign"> </span>--}}
                                        </div><!-- end input box -->
                                    </div>

                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                Control Account
                                            </label>
                                            <select class="inputs_up form-control" name="account_type" id="account_type">
                                                <option value="">Select Account Type</option>
                                                <option value="1" {{1==$account_type ? 'selected="selected"':''}}>Assets</option>
                                                <option value="2" {{2==$account_type ? 'selected="selected"':''}}>Liability</option>
                                                <option value="3" {{3==$account_type ? 'selected="selected"':''}}>Revenue</option>
                                                <option value="4" {{4==$account_type ? 'selected="selected"':''}}>Expense</option>
                                                <option value="5" {{5==$account_type ? 'selected="selected"':''}}>Capital</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                Group Account
                                            </label>
                                            <select class="inputs_up form-control cstm_clm_srch" name="second_head" id="second_head">
                                                <option value="">Select Group Account</option>
                                                @foreach($second_heads as $second_head)
                                                    <option
                                                        value="{{$second_head->coa_code}}" {{ $second_head->coa_code == $search_second_head ? 'selected="selected"' : '' }}>{{$second_head->coa_head_name}}</option>
                                                @endforeach
                                            </select>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                Parent Account
                                            </label>
                                            <select class="inputs_up form-control cstm_clm_srch" name="third_head" id="third_head">
                                                <option value="">Select Parent Account</option>
                                                @foreach($third_heads as $third_head)
                                                    <option
                                                        value="{{$third_head->coa_code}}" {{ $third_head->coa_code == $search_third_head ? 'selected="selected"' : '' }}>{{$third_head->coa_head_name}}</option>
                                                @endforeach
                                            </select>
                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                        </div>
                                    </div>

                                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 mt-lg-2">
                                        <div class="form_controls text-center text-lg-left">
                                            @include('include.clear_search_button')

                                            @include('include/print_button')


                                            <span id="demo1" class="validate_sign" style="float: right !important"> </span>

                                        </div>
                                    </div>

                                </div><!-- end row -->
                            </div>

                        </div>
                    </form>
                </div><!-- search form end -->


                <div class="table-responsive" id="printTable">
                    <table class="table table-sm" id="">

                        <thead>
                        <tr>
                            <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                                Sr.
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_amnt_7">
                                Date
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_amnt_7">
                                Voucher No.
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_13">
                                Group Account
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_13">
                                Parent Account
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_13">
                                Account Name
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_txt_13">
                                Remarks
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_amnt_15">
                                Debit
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_amnt_15">
                                Credit
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $sr=1;
                            $DR = $ttlDr = $CR = $ttlCr = $bal = $ttlBal = 0;
                        @endphp
                        @forelse($datas as $ledger)

                            @php
                                $DR = $ledger->bal_dr;
                                $CR = $ledger->bal_cr;
                                $bal = $ledger->bal_cr;
                                $ttlDr = +$DR + +$ttlDr;
                                $ttlCr = +$CR + +$ttlCr;
                                $ttlBal = +$bal + +$ttlBal;

                                $account=substr($ledger->bal_account_id,0,5);
                                $type=substr($ledger->bal_voucher_number,0,2);
                            @endphp

                            <tr>
                                <td class="text-center align_center tbl_srl_4">
                                    {{ $sr }}
                                </td>
                                <td align="center" class="text-center align_center tbl_amnt_7">
                                    {{date('d-M-y', strtotime(str_replace('/', '-', $ledger->bal_day_end_date)))}}
                                </td>
                                <td align="center" class="text-center align_center tbl_amnt_7">
                                    <a class="view" data-transcation_id="{{$ledger->bal_voucher_number}}" data-toggle="modal" data-target="#myModal">
                                        {{$ledger->bal_voucher_number}}
                                    </a>
                                </td>

                                <td class="text-left align_left tbl_txt_13">
                                    {{$ledger->grp_acnt_name}}
                                </td>

                                <td class="text-left align_left tbl_txt_13">
                                    {{$ledger->parnt_acnt_name}}
                                </td>

                                <td class="text-left align_left tbl_txt_13">

                                    <form action="{{ route('account_ledger') }}" method="post" target="_blank">
                                        @csrf

                                        <input type="hidden" name="account_name" value="{{$ledger->account_name}}">
                                        <input type="hidden" name="account_id" value="{{$ledger->account_uid}}">
                                        <button type="submit" style="cursor:pointer;color:#0099ff; background: none;border: none">
                                            {{$ledger->account_name}}
                                        </button>
                                    </form>
                                </td>
                                <td class="align_left text-left tbl_txt_13">
                                    {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br /> <hr />', $ledger->bal_remarks) !!}
                                </td>
                                <td class="text-right align_right text-right tbl_amnt_15">
                                    {{$ledger->bal_dr !=0 ? number_format($ledger->bal_dr,2):''}}
                                </td>
                                <td class="text-right align_right text-right tbl_amnt_15">
                                    {{$ledger->bal_cr !=0 ? number_format($ledger->bal_cr,2):''}}
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
                        </tbody>

                        <tr class="border-0">

                            <th colspan="7" align="right" class="border-0 text-right align_right pt-0">
                                Total:
                            </th>
                            <td class="text-right border-left-0" align="right" style="border-top: 2px solid #000;border-bottom: 3px double #000;border-right: 0px solid transparent;">
                                {{ number_format($ttlDr,2) }}
                            </td>
                            <td class="text-right border-left-0" align="right" style="border-top: 2px solid #000;border-bottom: 3px double #000;border-right: 0px solid transparent;">
                                {{ number_format($ttlCr,2) }}
                            </td>
                            {{--                                <td class="text-right border-left-0" align="right" style="border-top: 2px solid #000;border-bottom: 3px double #000;border-right: 0px solid transparent;">--}}
                            {{--                                    {{ number_format($ttlBal,2) }}--}}
                            {{--                                </td>--}}
                        </tr>

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
        var base = '{{ route('parent_account_ledger') }}',
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

    <script>
        $(document).on("click", ".purchase", function () {
            $('#myModal').modal('hide');

            jQuery("#table_body1").html("");

            var id = jQuery(this).attr("data-id");

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.ajax({
                url: "purchase_items_view_details",
                data: {id: id},
                type: "POST",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    $.each(data, function (index, value) {

                        jQuery("#table_body1").append('<tr><td class="align_center">' + value['pii_product_code'] + '</td><td class="align_left">' + value['pii_product_name'] + '</td><td class="align_right">' + value['pii_qty'] + '</td><td class="align_right">' + value['pii_rate'] + '</td><td class="align_right">' + value['pii_discount'] + '</td><td class="align_right">' + value['pii_saletax'] + '</td><td class="align_right">' + value['pii_amount'] + '</td><td class="align_right">' + value['pii_gross_rate'] + '</td><td class="align_right">' + value['pii_expense'] + '</td><td class="align_right">' + value['pii_net_rate'] + '</td><td class="align_left">' + value['pii_remarks'] + '</td></tr>');

                    });
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert(jqXHR.responseText);
                    // alert(errorThrown);
                }
            });
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>

    <script>
        jQuery(document).ready(function () {
            // Initialize select2
            jQuery("#account_type").select2();
            jQuery("#second_head").select2();
            jQuery("#third_head").select2();

        });
    </script>

@endsection

