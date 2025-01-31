
@extends('extend_index')

@section('content')

    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">


            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="printTable">



                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white file_name get-heading-text">Personal Account Ledger {{' ( '.$account_name.' ) '}}</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

            <!-- <div class="search_form {{ ( !empty($search_to) || !empty($search_from) ) ? '' : 'search_form_hidden' }}"> -->

                <div class="search_form">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                            <form class="prnt_lst_frm" action="{{ route('personal_account_ledger') }}" name="form1" id="form1" method="post" class="accountLedger w-80p d-inline" autocomplete="off">
                                @csrf

                                <div class="row">

                                    <div class="start form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="required">From :</label>
                                            <input tabindex="2" type="text" name="to" id="to" class="inputs_up form-control date-picker" <?php if(isset($search_to)){?> value="{{$search_to}}"
                                                   <?php } ?> placeholder="Start From..."/>
                                            <span id="demo1" class="validate_sign"> </span>
                                        </div><!-- end input box -->
                                    </div>

                                    <div class="end form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label class="required">To :</label>
                                            <input tabindex="3" type="text" name="from" id="from" class="inputs_up form-control date-picker" <?php if(isset($search_from)){?> value="{{$search_from}}"
                                                   <?php } ?> placeholder="End From..."/>
                                            <span id="demo2" class="validate_sign"> </span>
                                        </div><!-- end input box -->
                                    </div>

                                    <div class="col-lg-4 col-md-12 col-sm-12 mt-lg-2">
                                        <div class="form_controls text-center text-lg-left">
                                            <button tabindex="5" type="reset" name="cancel" id="cancel" class="cancel_button form-control">
                                                <i class="fa fa-trash"></i> Clear
                                            </button>
                                            <button tabindex="6" type="submit" name="save" id="save" class="save_button form-control">
                                                <i class="fa fa-search"></i> Search
                                            </button>

                                            @include('include/print_button')
                                        </div>
                                    </div>

                                    <input value="{{$account_name}}" name="account_name" id="account_name" type="hidden">

                                </div>
                            </form>

                        </div>

                    </div>
                </div><!-- search form end -->


                <div class="table-responsive" id="">
                    <table class="table table-sm" id="">

                        <thead>
                        <tr>
                            <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                                Sr.
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_amnt_8">
                                Date
                            </th>
{{--                            <th scope="col" align="center" class="text-center align_center tbl_amnt_9">--}}
{{--                                Voucher No.--}}
{{--                            </th>--}}
                            <th scope="col" align="center" class="text-left tbl_txt_17">
                                Remarks
                            </th>
                            <th scope="col" align="center" class="text-left tbl_txt_23">
                                Detail Remarks
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_amnt_13">
                                Debit
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_amnt_13">
                                Credit
                            </th>
                            <th scope="col" align="center" class="text-center align_center tbl_amnt_13">
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
                                <td class="text-center align_center tbl_srl_4">
                                    {{ $sr }}
                                </td>
                                <td align="center" class="text-center align_center tbl_amnt_8">
                                    {{date('d-M-y', strtotime(str_replace('/', '-', $ledger->bal_day_end_date)))}}
                                </td>
{{--                                <td align="center" class="text-center align_center tbl_amnt_9">--}}
{{--                                    <a class="view" data-transcation_id="{{$ledger->bal_voucher_number}}" data-toggle="modal" data-target="#myModal" style="cursor:pointer; color: #0099ff;">--}}
{{--                                        {{$ledger->bal_voucher_number}}--}}
{{--                                    </a>--}}
{{--                                </td>--}}
                                <td class="align_left text-left tbl_txt_17">
                                    {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br /> <hr />', $ledger->bal_remarks) !!}
                                </td>
                                <td class="align_left text-left tbl_txt_23">
                                    @if($account!=config('global_variables.receivable') && $account!=config('global_variables.payable'))
                                        {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br /> <hr />', $ledger->bal_detail_remarks) !!}
                                        {{--                                            {!! str_replace("&oS;",'<br />', $ledger->bal_detail_remarks) !!}--}}
                                    @elseif($type=='JV' || $type=='CP' || $type=='CRV' || $type=='BP' || $type=='BR')
                                    @else
                                        {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br /> <hr />', $ledger->bal_detail_remarks) !!}
                                        {{--                                            {!! str_replace("&oS;",'<br />', $ledger->bal_detail_remarks) !!}--}}
                                    @endif
                                </td>
                                <td class="align_right text-right tbl_amnt_13">
                                    {{$ledger->bal_dr !=0 ? number_format($ledger->bal_dr,2):''}}
                                </td>
                                <td class="align_right text-right tbl_amnt_13">
                                    {{$ledger->bal_cr !=0 ? number_format($ledger->bal_cr,2):''}}
                                </td>
                                <td class="align_right text-right tbl_amnt_13">
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
                        </tbody>

                        <tfoot>
                        <tr class="border-0">
                            <th colspan="4" align="right" class="border-0 text-right align_right pt-0">
                                Total:
                            </th>
                            <td class="text-right border-left-0" align="right" style="border-top: 2px solid #000;border-bottom: 3px double #000;border-right: 0px solid transparent;">
                                {{ number_format($ttlDr,2) }}
                            </td>
                            <td class="text-right border-left-0" align="right" style="border-top: 2px solid #000;border-bottom: 3px double #000;border-right: 0px solid transparent;">
                                {{ number_format($ttlCr,2) }}
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
        var base = '{{ route('personal_account_ledger') }}',
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

        // jQuery("#account_id").change(function () {
        //
        //     var account_name = jQuery("#account_id option:selected").text();
        //     jQuery("#account_name").val(account_name);
        // });
        //
        // jQuery(document).ready(function () {
        //     // Initialize select2
        //     jQuery("#account_id").select2();
        //     jQuery("#invoice_type").select2();
        // });

    </script>

    <script>
        jQuery("#cancel").click(function () {
            $('#from').val('');
            $('#to').val('');

            // $("#account_id").select2().val(null).trigger("change");
            // $("#account_id > option").removeAttr('selected');
            //
            // $("#invoice_type").select2().val(null).trigger("change");
            // $("#invoice_type > option").removeAttr('selected');

        });
    </script>

@endsection

