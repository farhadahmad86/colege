{{--<!DOCTYPE html>--}}
{{--<html>--}}
{{--<head>--}}
{{--    @include('include/head')--}}
{{--</head>--}}
{{--<body>--}}
{{--@include('include/header')--}}
{{--@include('include/sidebar')--}}


{{--<div class="main-container">--}}
{{--    <div class="pd-ltr-20 customscroll-10-p height-100-p xs-pd-20-10">--}}
{{--        @include('inc._messages')--}}
@extends('extend_index')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header"><!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text">Party Wise Sale Aging Report</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <div class="search_form m-0 p-0 {{ ( !empty($search) || !empty($search_to) || !empty($search_from) ) ? '' : '' }}">

                    <form class="highlight prnt_lst_frm" action="{{ route('aging_report_party_wise_sale') }}" name="form1" id="form1" method="post">
                        <div class="row">
                            @csrf
                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        All Column Search
                                    </label>
                                    <input type="search" list="browsers" class="inputs_up form-control" name="search" id="search" placeholder="Search ..." value="{{ isset($search) ? $search : '' }}"
                                           autocomplete="off">
                                    <datalist id="browsers">
                                        @foreach($party as $value)
                                            <option value="{{$value}}">
                                        @endforeach
                                    </datalist>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div> <!-- left column ends here -->

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        Start Date
                                    </label>
                                    <input type="text" name="to" id="to" class="inputs_up form-control datepicker1" autocomplete="off" <?php if(isset($search_to)){?> value="{{$search_to}}"
                                           <?php } ?> placeholder="Start Date ......"/>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>

                            <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                <div class="input_bx"><!-- start input box -->
                                    <label>
                                        End Date
                                    </label>
                                    <input type="text" name="from" id="from" class="inputs_up form-control datepicker1" autocomplete="off" <?php if(isset($search_from)){?> value="{{$search_from}}"
                                           <?php } ?> placeholder="End Date ......"/>
                                    <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-lg-4 text-right">
                            @include('include.clear_search_button')

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
                            <th scope="col" class="tbl_srl_4">
                                Sr#
                            </th>
                            <th scope="col" class="tbl_amnt_6">
                                Date
                            </th>
                            <th scope="col" class="tbl_amnt_10">
                                Invoice #
                            </th>
                            <th scope="col" class="tbl_amnt_4">
                                Days
                            </th>
                            <th scope="col" class="tbl_txt_25">
                                Party Name
                            </th>
                            <th scope="col" class="tbl_txt_28">
                                Remarks
                            </th>
                            <th scope="col" class="tbl_amnt_15">
                                Grand Total
                            </th>
                            <th scope="col" class="tbl_txt_8">
                                Created By
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
                            $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
                            $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
                            $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
                            $ttlPrc = 0;
                        @endphp
                        @forelse($datas as $invoice)

                            <tr>
                                <th scope="row" >
                                    {{$sr}}
                                </th>
                                <td nowrap>
                                    {{date('d-M-y', strtotime(str_replace('/', '-', $invoice->si_day_end_date)))}}
                                </td>
                                <td>
                                    <a class="view" data-transcation_id="{{($invoice->type === "sales_in") ? config('global_variables.SALE_VOUCHER_CODE').$invoice->si_id : config
                                        ('global_variables.SALE_SALE_TAX_VOUCHER_CODE').$invoice->si_id}}" data-toggle="modal" data-target="#myModal" style="cursor:pointer; color: #0099ff;">
                                        {{--                                            {{'SV-'.$invoice->si_id }}--}}

                                        @if($invoice->type === "sales_in")
                                            {{config('global_variables.SALE_VOUCHER_CODE').$invoice->si_id }}
                                        @elseif($invoice->type === "sales_sltx_in")
                                            {{config('global_variables.SALE_SALE_TAX_VOUCHER_CODE').$invoice->si_id }}
                                        @endif
                                    </a>
                                </td>
                                <td>
                                    {{(strtotime($current_date) - strtotime($invoice->si_day_end_date)) / 86400}}
                                </td>
                                <td>
                                    {{$invoice->si_party_name}}
                                </td>
                                <td>
                                    {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $invoice->si_detail_remarks) !!}
                                </td>
                                @php
                                    $ttlPrc = +($invoice->si_grand_total) + +$ttlPrc;
                                @endphp
                                <td class="align_right text-right">
                                    {{$invoice->si_grand_total !=0 ? number_format($invoice->si_grand_total,2):''}}
                                </td>
                                @php
                                    $ip_browser_info= ''.$invoice->si_ip_adrs.','.str_replace(' ','-',$invoice->si_brwsr_info).'';
                                @endphp
                                <td class="usr_prfl" data-usr_prfl="{{ $invoice->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                    {{ $invoice->user_name }}
                                </td>

                            </tr>
                            @php
                                $sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="15">
                                    <center><h3 style="color:#554F4F">No Invoice</h3></center>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                        <tfoot>
                        <tr>
                            <th colspan="6" class="align_right text-right border-0">
                                Page Total:-
                            </th>
                            <td class="align_right text-right border-0">
                                {{ number_format($ttlPrc,2) }}
                            </td>
                        </tr>
                        </tfoot>

                    </table>

                </div>
                <span class="hide_column">{{ $datas->appends(['segmentSr' => $countSeg, 'search'=>$search, 'to'=>$search_to, 'from'=>$search_from ])->links() }}</span>
            </div> <!-- white column form ends here -->
        </div><!-- col end -->

    </div><!-- row end -->
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="width: 1250px; margin-left: -220px;">
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
        var base = '{{ route('aging_report_party_wise_sale') }}',
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
        jQuery("#cancel").click(function () {

            $("#search").val('');
            $("#to").val('');
            $("#from").val('');
        });
    </script>
@stop
