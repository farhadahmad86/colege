@extends('extend_index')
@section('content')
    <div class="row">
            <div class="container-fluid search-filter form-group form_manage" id="">
                <div class="form_header">
                    <!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Services Invoice List</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->
                <!-- <div class="search_form  {{ !empty($search) || !empty($search_to) || !empty($search_from) ? '' : 'search_form_hidden' }}"> -->
                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('services_invoice_list') }}" name="form1"
                        id="form1" method="post">
                        @csrf
                        <div class="row">
                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input tabindex="1" autofocus type="search" list="browsers"
                                        class="inputs_up form-control" name="search" id="search"
                                        placeholder="Search ..." value="{{ isset($search) ? $search : '' }}"
                                        autocomplete="off">
                                    <datalist id="browsers">
                                        @foreach ($party as $value)
                                            <option value="{{ $value }}">
                                        @endforeach
                                    </datalist>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->
                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label>
                                        Start Date
                                    </label>
                                    <input tabindex="2" type="text" name="to" id="to"
                                        class="inputs_up form-control datepicker1" autocomplete="off" <?php if(isset($search_to)){?>
                                        value="{{ $search_to }}" <?php } ?> placeholder="Start Date ......" />
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>
                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx">
                                    <!-- start input box -->
                                    <label>End Date</label>
                                    <input tabindex="3" type="text" name="from" id="from"
                                        class="inputs_up form-control datepicker1" autocomplete="off" <?php if(isset($search_from)){?>
                                        value="{{ $search_from }}" <?php } ?> placeholder="End Date ......" />
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-lg-4 text-right">

                                @include('include.clear_search_button')
<!-- Call add button component -->
<x-add-button tabindex="9" href="{{ route('services_invoice') }}"/>
                                @include('include/print_button')
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div>
                    </form>
                </div><!-- search form end -->
                <div class="table-responsive" id="printTable">
                    <table class="table table-bordered table-sm" id="fixTable">
                        <thead>
                            <tr>
                                <th tabindex="-1" scope="col" class="tbl_srl_4">
                                    Sr#
                                </th>
                                <th tabindex="-1" scope="col" class="tbl_srl_4">
                                    ID
                                </th>
                                <th tabindex="-1" scope="col" class="tbl_amnt_9">
                                    Date
                                </th>
                                <th scope="col" class="tbl_amnt_6">
                                    Invoice No.
                                </th>
                                {{--                            <th scope="col" >Detail Remarks</th> --}}
                                {{-- <th scope="col" style="width:80px; text-align: center !important" >Party Code</th> --}}
                                <th scope="col" class="tbl_txt_21">
                                    Party Name
                                </th>
                                <th tabindex="-1" scope="col" class="tbl_txt_13">
                                    Remarks
                                </th>
                                <th scope="col" class="tbl_txt_27">
                                    Detail Remarks
                                </th>
                                <th scope="col" class="tbl_amnt_5">
                                    Total Price
                                </th>
                                {{--<th scope="col" >Expense</th> --}}
                                {{--<th scope="col" >Trade Disc%</th> --}}
                                {{--<th scope="col" >Trade Disc</th> --}}
                                {{--<th scope="col" >Value of Supply</th> --}}
                                {{--<th scope="col" >Sale tax</th> --}}
                                {{--<th scope="col" >Special Disc%</th> --}}
                                {{--<th scope="col" >Special Disc</th> --}}
                                {{--<th scope="col" >Grand Total</th> --}}
                                <th scope="col" class="tbl_amnt_5">
                                    Cash Rec
                                </th>
                                <th scope="col" class="tbl_txt_8">
                                    Created By
                                </th>
                                {{--                            <th scope="col" >Remarks</th> --}}
                                {{-- <th scope="col" style="width:80px; text-align: center !important" >Date/Time</th> --}}
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $segmentSr = !empty(app('request')->input('segmentSr')) ? app('request')->input('segmentSr') : '';
                                $segmentPg = !empty(app('request')->input('page')) ? app('request')->input('page') : '';
                                $sr = !empty($segmentSr) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                                $countSeg = !empty($segmentSr) ? $segmentSr : 0;
                                $ttlPrc = $cashPaid = 0;
                            @endphp
                            @forelse($datas as $invoice)
                                <tr>
                                    <th scope="row" class="text-center edit tbl_srl_4">
                                        {{ $sr }}
                                    </th>
                                    <td class="text-center edit tbl_srl_4">
                                        {{ $invoice->sei_id }}
                                    </td>
                                    <td nowrap class="tbl_amnt_9">
                                        {{ date('d-M-y', strtotime(str_replace('/', '-', $invoice->sei_day_end_date))) }}
                                    </td>
                                    <td class="view tbl_amnt_6" data-id="{{ $invoice->sei_id }}">
                                        SEI-{{ $invoice->sei_id }}
                                    </td>
                                    {{--                                    <td class="align_left">{{$invoice->sei_detail_remarks}}</td> --}}
                                    {{-- <td>{{$invoice->sei_party_code}}</td> --}}
                                    <td class="align_left text-left tbl_txt_21">
                                        {{ $invoice->sei_party_name }}
                                    </td>
                                    <td class="align_left text-left tbl_txt_13">
                                        {{ $invoice->sei_remarks }}
                                    </td>
                                    <td class="align_left text-left tbl_txt_27">
                                        {{--                                        {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $invoice->sei_detail_remarks) !!} --}}
                                        {!! str_replace('&oS;', '<br />', $invoice->sei_detail_remarks) !!}
                                    </td>
                                    @php
                                        $ttlPrc = +$invoice->sei_total_price + +$ttlPrc;
                                    @endphp
                                    <td class="align_right text-right tbl_amnt_5">
                                        {{ $invoice->sei_total_price != 0 ? number_format($invoice->sei_total_price, 2) : '' }}
                                    </td>
                                    {{--                            <td class="align_left">{{$invoice->sei_expense !=0 ? number_format($invoice->sei_expense,2):''}}</td> --}}
                                    {{--                            <td class="align_left">{{$invoice->sei_trade_disc_percentage !=0 ? number_format($invoice->sei_trade_disc_percentage,2):''}}</td> --}}
                                    {{--                            <td class="align_left">{{$invoice->sei_trade_disc !=0 ? number_format($invoice->sei_trade_disc,2):''}}</td> --}}
                                    {{--                            <td class="align_left">{{$invoice->sei_value_of_supply !=0 ? number_format($invoice->sei_value_of_supply,2):''}}</td> --}}
                                    {{--                            <td class="align_left">{{$invoice->sei_sales_tax !=0 ? number_format($invoice->sei_sales_tax,2):''}}</td> --}}
                                    {{--                            <td class="align_left">{{$invoice->sei_special_disc_percentage !=0 ? number_format($invoice->sei_special_disc_percentage,2):''}}</td> --}}
                                    {{--                            <td class="align_left">{{$invoice->sei_special_disc !=0 ? number_format($invoice->sei_special_disc,2):''}}</td> --}}
                                    {{--                            <td class="align_left">{{$invoice->sei_grand_total !=0 ? number_format($invoice->sei_grand_total,2):''}}</td> --}}
                                    @php
                                        $cashPaid = +$invoice->sei_cash_received + +$cashPaid;
                                    @endphp
                                    <td class="align_right text-right tbl_amnt_5">
                                        {{ $invoice->sei_cash_received != 0 ? number_format($invoice->sei_cash_received, 2) : '' }}
                                    </td>

                                    @php
                                        $ip_browser_info = '' . $invoice->sei_ip_adrs . ',' . str_replace(' ', '-', $invoice->sei_brwsr_info) . '';
                                    @endphp

                                    <td class="align_left text-left usr_prfl tbl_txt_8"
                                        data-usr_prfl="{{ $invoice->user_id }}" data-user_info="{!! $ip_browser_info !!}"
                                        title="Click To See User Detail">
                                        {{ $invoice->user_name }}
                                    </td>

                                    {{--                            <td class="align_left">{{$invoice->sei_remarks}}</td> --}}
                                    {{-- {{$invoice->sei_remarks == '' ? 'N/A' : $invoice->sei_remarks}} --}}
                                    {{-- <td >{{$invoice->sei_datetime}}</td> --}}

                                </tr>
                                @php
                                    $sr++;
                                    !empty($segmentSr) && $countSeg !== '0' ?: $countSeg++;
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="15">
                                        <center>
                                            <h3 style="color:#554F4F">No Invoice</h3>
                                        </center>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="7" class="align_right text-right border-0">
                                    Page Total:-
                                </th>
                                <td class="align_right text-right border-0">
                                    {{ number_format($ttlPrc, 2) }}
                                </td>
                                <td class="align_right text-right border-0">
                                    {{ number_format($cashPaid, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="row">
    <div class="col-md-3">
        <span>Showing {{$datas->firstItem()}} - {{$datas->lastItem()}} of {{$datas->total()}}</span>
    </div>
    <div class="col-md-9 text-right">
                <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search' => $search, 'to' => $search_to, 'from' => $search_from])->links() }}</span></div></div>
            </div> <!-- white column form ends here -->
    </div><!-- row end -->
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg mdl_wdth">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Services Invoice Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="table_body">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form_controls">
                            <button type="button" class="btn btn-default form-control cancel_button"
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
    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('services_invoice_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        jQuery("#cancel").click(function() {

            $("#search").val('');

            $("#to").val('');
            $("#from").val('');
        });
    </script>

    <script>
        // jQuery("#invoice_no").blur(function () {
        jQuery(".view").click(function() {

            jQuery("#table_body").html("");

            var id = jQuery(this).attr("data-id");
            $(".modal-body").load('{{ url('services_items_view_details/view/') }}' + '/' + id, function() {
                $("#myModal").modal({
                    show: true
                });
            });
            {{-- jQuery.ajaxSetup({ --}}
            {{--    headers: { --}}
            {{--        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') --}}
            {{--    } --}}
            {{-- }); --}}

            {{-- jQuery.ajax({ --}}
            {{--    url: "{{ route('services_items_view_details') }}", --}}
            {{--    data: {id: id}, --}}
            {{--    type: "POST", --}}
            {{--    cache: false, --}}
            {{--    dataType: 'json', --}}
            {{--    success: function (data) { --}}

            {{--        $.each(data, function (index, value) { --}}

            {{--            var qty; --}}
            {{--            var rate; --}}
            {{--            var discount; --}}
            {{--            var saletax; --}}
            {{--            var amount; --}}

            {{--            if(value['seii_qty']==0){ --}}
            {{--                qty=''; --}}
            {{--            }else{ --}}
            {{--                qty=value['seii_qty']; --}}
            {{--            } --}}
            {{--            if(value['seii_rate']==0){ --}}
            {{--                rate=''; --}}
            {{--            }else{ --}}
            {{--                rate=value['seii_rate']; --}}
            {{--            } --}}
            {{--            if(value['seii_discount']==0){ --}}
            {{--                discount=''; --}}
            {{--            }else{ --}}
            {{--                discount=value['seii_discount']; --}}
            {{--            } --}}
            {{--            if(value['seii_saletax']==0){ --}}
            {{--                saletax=''; --}}
            {{--            }else{ --}}
            {{--                saletax=value['seii_saletax']; --}}
            {{--            } --}}
            {{--            if(value['seii_amount']==0){ --}}
            {{--                amount=''; --}}
            {{--            }else{ --}}
            {{--                amount=value['seii_amount']; --}}
            {{--            } --}}

            {{--            jQuery("#table_body").append('<div class="itm_vchr form_manage">' + --}}
            {{--            '<div class="form_header">' + --}}
            {{--            '<h4 class="text-white file_name">' + --}}
            {{--            '<span class="db sml_txt"> Service #: </span>' + --}}
            {{--            '' + value['seii_service_code'] + '' + --}}
            {{--            '</h4>' + --}}
            {{--            '</div>' + --}}
            {{--            '<div class="table-responsive">' + --}}
            {{--            '<table class="table table-bordered">' + --}}
            {{--            '<thead>' + --}}
            {{--            '<tr>' + --}}
            {{--            '<th scope="col"  class="width_2">Service Name</th>' + --}}
            {{--            '<th scope="col"  class="width_5">Rate</th>' + --}}
            {{--            '<th scope="col"  class="width_5 text-right">Quantity</th>' + --}}
            {{--            '</tr>' + --}}
            {{--            '</thead>' + --}}
            {{--            '<tbody>' + --}}
            {{--            '<tr>' + --}}
            {{--            '<td class="align_left"> <div class="max_txt"> ' + value['seii_service_name'] + '</div> </td>' + --}}
            {{--            '<td class="align_left">' + rate + '</td>' + --}}
            {{--            '<td class="align_left text-right">' + qty + '</td>' +'</td>' + --}}
            {{--            '</tr>' + --}}
            {{--            '</tbody>' + --}}
            {{--            '<tfoot class="side-section">'+ --}}
            {{--            '<tr class="border-0">'+ --}}
            {{--            '<td colspan="7" align="right" class="p-0 border-0">'+ --}}
            {{--            '<table class="m-0 p-0 chk_dmnd">'+ --}}
            {{--            '<tfoot>'+ --}}
            {{--            '<tr>'+ --}}
            {{--            '<td class="border-top-0 border-right-0">'+ --}}
            {{--            '<label class="total-items-label text-right">Discounts</label>'+ --}}
            {{--            '</td>'+ --}}
            {{--            '<td class="text-right border-top-0 border-left-0">'+ --}}
            {{--            ((discount != null && discount != "") ? discount : '0.00') + --}}
            {{--            '</td>'+ --}}
            {{--            '</tr>'+ --}}
            {{--            '<tr>'+ --}}
            {{--            '<td colspan="" align="right" class="border-right-0">'+ --}}
            {{--            '<label class="total-items-label text-right">Sale Tax</label>'+ --}}
            {{--            '</td>'+ --}}
            {{--            '<td class="text-right border-left-0" align="right">'+ --}}
            {{--            ((saletax != null && saletax != "") ? saletax : '0.00') + --}}
            {{--            '</td>'+ --}}
            {{--            '</tr>'+ --}}
            {{--            '<tr>'+ --}}
            {{--            '<td colspan="" align="right" class="border-right-0">'+ --}}
            {{--            '<label class="total-items-label text-right">Total Amount</label>'+ --}}
            {{--            '</td>'+ --}}
            {{--            '<td class="text-right border-left-0" align="right">'+ --}}
            {{--            ((amount != null && amount != "") ? amount : '0.00') + --}}
            {{--            '</td>'+ --}}
            {{--            '</tr>'+ --}}
            {{--            '</tfoot>'+ --}}
            {{--            '</table>'+ --}}
            {{--            '</td>'+ --}}
            {{--            '</tr>'+ --}}
            {{--            '</tfoot>'+ --}}
            {{--            '</table>' + --}}
            {{--            '</div>' + --}}
            {{--            '<div class="itm_vchr_rmrks '+((value['seii_remarks'] != null && value['seii_remarks'] != "") ? '' : 'search_form_hidden') +'">' + --}}
            {{--            '<h5 class="title_cus bold"> Remarks: </h5>' + --}}
            {{--            '<p class="m-0 p-0">' + value['seii_remarks'] + '</p>' + --}}
            {{--            '</div>' + --}}
            {{--            '<div class="input_bx_ftr"></div>' + --}}
            {{--            '</div>'); --}}

            {{--        }); --}}
            {{--    }, --}}
            {{--    error: function (jqXHR, textStatus, errorThrown) { --}}
            {{--        // alert(jqXHR.responseText); --}}
            {{--        // alert(errorThrown); --}}
            {{--    } --}}
            {{-- }); --}}
        });
    </script>

    <script>
        jQuery(".edit").click(function() {

            var account_id = jQuery(this).attr("data-id");

            jQuery("#account_id").val(account_id);
            jQuery("#edit").submit();
        });
    </script>
@endsection
