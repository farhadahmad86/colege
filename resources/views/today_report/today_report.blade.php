@extends('extend_index')

@section('content')
    <style>
        .size {
            font-size: 30px;
            color: #2A88AD;
        }
        /*.table thead th {*/
        /*    background-color: #2A88AD;*/
        /*    color: #000;*/
        /*}*/
    </style>
    <div class="row">
        <div class="container-fluid search-filter form-group form_manage" id="">
            <div class="form_header"><!-- form header start -->
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-white get-heading-text file_name">Day Wise Reporting</h4>
                    </div>
                    <div class="list_btn list_mul">
                        <div class="srch_box_opn_icon">
                            <i class="fa fa-search"></i>
                        </div>
                    </div><!-- list btn -->
                </div>
            </div><!-- form header close -->

        <!-- <div class="search_form {{ ( !empty($search_to) || !empty($search_from) ) ? '' : '' }}"> -->
            <div class="search_form m-0 p-0">
                <form class="highlight prnt_lst_frm" action="{{ route('today_report_list') }}" name="form1" id="form1" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx"><!-- start input box -->
                                <label>
                                    Start Date
                                </label>
                                <input tabindex="5" type="text" name="from" id="from" class="inputs_up form-control datepicker1" autocomplete="off"
                                       <?php if(isset($search_from)){?> value="{{$search_from}}" <?php } ?> placeholder="Start Date ......"/>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div>

                        <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                            <div class="input_bx"><!-- start input box -->
                                <label>
                                    End Date
                                </label>
                                <input tabindex="6" type="text" name="to" id="to" class="inputs_up form-control datepicker1" autocomplete="off"
                                       <?php if(isset($search_to)){?> value="{{$search_to}}" <?php } ?> placeholder="End Date ......"/>
                                <span id="demo1" class="validate_sign" style="float: right !important"> </span>
                            </div>
                        </div>

                        <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 mt-lg-4 text-right">
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
                        <th tabindex="-1" scope="col" class="tbl_srl_4">
                            Sr#
                        </th>
                        <th tabindex="-1" scope="col" class="tbl_srl_8">
                            Transaction ID
                        </th>
                        <th tabindex="-1" scope="col" class="tbl_amnt_9">
                            Date
                        </th>
                        <th tabindex="-1" scope="col" class="tbl_amnt_6">
                            Voucher No.
                        </th>

                        <th tabindex="-1" scope="col" class="tbl_txt_43">
                            Ledger/Account Name
                        </th>

                        <th tabindex="-1" scope="col" class="tbl_amnt_10">
                            DR
                        </th>

                        <th tabindex="-1" scope="col" class="tbl_amnt_10">
                            CR
                        </th>
                        <th tabindex="-1" scope="col" class="tbl_txt_10">
                            Created By
                        </th>

                    </tr>
                    </thead>

                    <tbody>
                    @php
                        //$p=1;
                          $ttlPrc = 0;
                    @endphp
                    {{--                        <tr>--}}
                    {{--                            <th colspan="8" class="border-0 size">--}}
                    {{--                                Purchase--}}
                    {{--                            </th>--}}
                    {{--                        </tr>--}}
                    {{--                        @forelse($allData['datas'] as $invoice)--}}

                    {{--                            <tr>--}}
                    {{--                                <th scope="row">--}}
                    {{--                                    {{$p}}--}}
                    {{--                                </th>--}}
                    {{--                                <th>--}}
                    {{--                                    {{$invoice->pi_id}}--}}
                    {{--                                </th>--}}
                    {{--                                <td nowrap>--}}
                    {{--                                    {{date('d-M-y', strtotime(str_replace('/', '-', $invoice->pi_day_end_date)))}}--}}
                    {{--                                </td>--}}
                    {{--                                <td data-id="{{$invoice->pi_id}}">--}}
                    {{--                                    PI-{{$invoice->pi_id}}--}}
                    {{--                                </td>--}}

                    {{--                                <td>--}}
                    {{--                                    {{$invoice->pi_party_name}}--}}
                    {{--                                </td>--}}

                    {{--                                @php--}}
                    {{--                                    $ttlPrc = +($invoice->pi_total_price) + +$ttlPrc;--}}
                    {{--                                @endphp--}}
                    {{--                                <td class="align_right text-right">--}}
                    {{--                                    {{$invoice->pi_total_price !=0 ? number_format($invoice->pi_total_price,2):''}}--}}
                    {{--                                </td>--}}


                    {{--                                <td class="align_right text-right">--}}

                    {{--                                </td>--}}

                    {{--                                @php--}}
                    {{--                                    $ip_browser_info= ''.$invoice->pi_ip_adrs.','.str_replace(' ','-',$invoice->pi_brwsr_info).'';--}}
                    {{--                                @endphp--}}

                    {{--                                <td class="usr_prfl" data-usr_prfl="{{ $invoice->user_id }}" data-user_info="{!! $ip_browser_info !!}"--}}
                    {{--                                    title="Click To See User Detail">--}}
                    {{--                                    {{$invoice->user_name}}--}}
                    {{--                                </td>--}}

                    {{--                            </tr>--}}
                    {{--                            @php--}}
                    {{--                                $p++; //(!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;--}}
                    {{--                            @endphp--}}
                    {{--                        @empty--}}
                    {{--                            <tr>--}}
                    {{--                                <td colspan="15">--}}
                    {{--                                    <center><h6 style="color:#554F4F">No Purchase Invoice</h6></center>--}}
                    {{--                                </td>--}}
                    {{--                            </tr>--}}
                    {{--                        @endforelse--}}

                    {{--                        <tr>--}}
                    {{--                            <th colspan="5" class="align_right text-right border-0">--}}
                    {{--                                Total:---}}
                    {{--                            </th>--}}
                    {{--                            <td class="align_right text-right border-0">--}}
                    {{--                                {{ number_format($ttlPrc,2) }}--}}
                    {{--                            </td>--}}
                    {{--                            <td class="align_right text-right border-0">--}}
                    {{--                                0.00--}}
                    {{--                            </td>--}}

                    {{--                        </tr>--}}
                    {{--                        <tr>--}}
                    {{--                            <th colspan="8" class="border-0 size">--}}
                    {{--                                Sale--}}
                    {{--                            </th>--}}
                    {{--                        </tr>--}}

                    {{--                        @php--}}
                    {{--                            $s = 1;--}}
                    {{--                            $ttlSale = 0;--}}
                    {{--                        @endphp--}}
                    {{--                        @forelse($allData['datas_sale'] as $invoice)--}}

                    {{--                            <tr>--}}
                    {{--                                <th scope="row">--}}
                    {{--                                    {{$s}}--}}
                    {{--                                </th>--}}
                    {{--                                <th>--}}
                    {{--                                    {{$invoice->si_id}}--}}
                    {{--                                </th>--}}
                    {{--                                <td nowrap>--}}
                    {{--                                    {{date('d-M-y', strtotime(str_replace('/', '-', $invoice->si_day_end_date)))}}--}}
                    {{--                                </td>--}}
                    {{--                                <td data-id="{{$invoice->si_id}}">--}}
                    {{--                                    SI-{{$invoice->si_id}}--}}
                    {{--                                </td>--}}

                    {{--                                <td>--}}
                    {{--                                    {{$invoice->si_party_name}}--}}
                    {{--                                </td>--}}

                    {{--                                @php--}}
                    {{--                                    $ttlSale = +($invoice->si_total_price) + +$ttlSale;--}}
                    {{--                                @endphp--}}
                    {{--                                <td class="align_right text-right">--}}

                    {{--                                </td>--}}

                    {{--                                <td class="align_right text-right">--}}
                    {{--                                    {{$invoice->si_total_price !=0 ? number_format($invoice->si_total_price,2):''}}--}}
                    {{--                                </td>--}}

                    {{--                                @php--}}
                    {{--                                    $ip_browser_info= ''.$invoice->si_ip_adrs.','.str_replace(' ','-',$invoice->si_brwsr_info).'';--}}
                    {{--                                @endphp--}}

                    {{--                                <td class="usr_prfl" data-usr_prfl="{{ $invoice->user_id }}" data-user_info="{!! $ip_browser_info !!}"--}}
                    {{--                                    title="Click To See User Detail">--}}
                    {{--                                    {{$invoice->user_name}}--}}
                    {{--                                </td>--}}

                    {{--                            </tr>--}}
                    {{--                            @php--}}
                    {{--                                $s++; //(!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;--}}
                    {{--                            @endphp--}}
                    {{--                        @empty--}}
                    {{--                            <tr>--}}
                    {{--                                <td colspan="15">--}}
                    {{--                                    <center><h6 style="color:#554F4F">No Sale Invoice</h6></center>--}}
                    {{--                                </td>--}}
                    {{--                            </tr>--}}
                    {{--                        @endforelse--}}

                    {{--                        <tr>--}}
                    {{--                            <th colspan="5" class="align_right text-right border-0">--}}
                    {{--                                Total:---}}
                    {{--                            </th>--}}
                    {{--                            <td class="align_right text-right border-0">--}}
                    {{--                                0.00--}}
                    {{--                            </td>--}}
                    {{--                            <td class="align_right text-right border-0">--}}
                    {{--                                {{ number_format($ttlSale,2) }}--}}
                    {{--                            </td>--}}
                    {{--                        </tr>--}}

                    <tr>
                        <th colspan="8" class="border-0 size">
                            Cash Receipt Voucher
                        </th>

                    </tr>
                    @php
                        $cr = 1;
                        $ttl_amnt = 0;
                    @endphp
                    @forelse($allData['datas_crp'] as $voucher)

                        <tr>
                            <th scope="row">
                                {{$cr}}
                            </th>
                            <th>
                                {{$voucher->cr_id}}
                            </th>
                            <td>
                                {{date('d-M-y', strtotime(str_replace('/', '-', $voucher->cr_day_end_date)))}}
                            </td>
                            <td data-id="{{$voucher->cr_id}}">
                                CRV-{{$voucher->cr_id}}
                            </td>
                            <td>
                                {{$voucher->account_name}}
                            </td>

                            @php $ttl_amnt  = $ttl_amnt + $voucher->cri_amount; @endphp
                            <td class="align_right text-right">
                                {{$voucher->cri_amount !=0 ? number_format($voucher->cri_amount,2):''}}
                            </td>
                            <td class="align_right text-right">

                            </td>

                            @php
                                $ip_browser_info= ''.$voucher->cr_ip_adrs.','.str_replace(' ','-',$voucher->cr_brwsr_info).'';
                            @endphp

                            <td class="usr_prfl" data-usr_prfl="{{ $voucher->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                {{$voucher->user_name}}
                            </td>
                        </tr>
                        @php
                            $cr++; //(!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="11">
                                <center><h6 style="color:#554F4F">No Cash Receipt Voucher</h6></center>
                            </td>
                        </tr>
                    @endforelse

                    <tr>
                        <th colspan="5" class="align_right text-right border-0">
                            Total:-
                        </th>
                        <td class="align_right text-right border-0">
                            {{ number_format($ttl_amnt,2) }}
                        </td>
                        <td class="align_right text-right border-0">
                            0.00
                        </td>

                    </tr>

                    <th colspan="8" class="border-0 size">
                        Cash Payment Voucher
                    </th>

                    @php
                        $cp = 1;
                        $cp_amnt = 0;
                    @endphp
                    @forelse($allData['datas_cp'] as $voucher)

                        <tr>
                            <th scope="row">
                                {{$cp}}
                            </th>
                            <th>
                                {{$voucher->cp_id}}
                            </th>
                            <td>
                                {{date('d-M-y', strtotime(str_replace('/', '-', $voucher->cp_day_end_date)))}}
                            </td>
                            <td data-id="{{$voucher->cp_id}}">
                                CPV-{{$voucher->cp_id}}
                            </td>
                            <td>
                                {{$voucher->account_name}}
                            </td>

                            <td class="align_right text-right">

                            </td>

                            @php $cp_amnt = $cp_amnt + $voucher->cpi_amount; @endphp
                            <td class="align_right text-right">
                                {{$voucher->cpi_amount !=0 ? number_format($voucher->cpi_amount,2):''}}
                            </td>

                            @php
                                $ip_browser_info= ''.$voucher->cp_ip_adrs.','.str_replace(' ','-',$voucher->cp_brwsr_info).'';
                            @endphp

                            <td class="usr_prfl" data-usr_prfl="{{ $voucher->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                {{$voucher->user_name}}
                            </td>

                        </tr>
                        @php
                            $cp++; //(!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="11">
                                <center><h6 style="color:#554F4F">No Cash Payment Voucher</h6></center>
                            </td>
                        </tr>
                    @endforelse

                    <tr>
                        <th colspan="5" class="align_right text-right border-0">
                            Total:-
                        </th>
                        <td class="align_right text-right border-0">
                            0.00
                        </td>
                        <td class="align_right text-right border-0">
                            {{ number_format($cp_amnt,2) }}
                        </td>
                    </tr>

                    <th colspan="8" class="border-0 size">
                        Bank Receipt Voucher
                    </th>

                    @php
                        $br = 1;
                        $brv_ttl_amnt = 0;
                    @endphp
                    @forelse($allData['datas_br'] as $voucher)

                        <tr data-toggle="tooltip" data-placement="top" title="" data-original-title="View Journal Voucher">
                            <th scope="row">
                                {{$br}}
                            </th>
                            <th>
                                {{$voucher->br_id}}
                            </th>
                            <td>
                                {{date('d-M-y', strtotime(str_replace('/', '-', $voucher->br_day_end_date)))}}
                            </td>
                            <td data-id="{{$voucher->br_id}}">
                                BRV-{{$voucher->br_id}}
                            </td>
                            <td>
                                {{$voucher->account_name}}
                            </td>

                            @php $brv_ttl_amnt = $brv_ttl_amnt + $voucher->bri_amount;@endphp
                            <td class="align_right text-right">
                                {{$voucher->bri_amount !=0 ? number_format($voucher->bri_amount,2):''}}
                            </td>
                            <td class="align_right text-right">

                            </td>

                            @php
                                $ip_browser_info= ''.$voucher->br_ip_adrs.','.str_replace(' ','-',$voucher->br_brwsr_info).'';
                            @endphp

                            <td class="usr_prfl" data-usr_prfl="{{ $voucher->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                {{$voucher->user_name}}
                            </td>

                        </tr>
                        @php
                            $br++; //(!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="11">
                                <center><h6 style="color:#554F4F">No Bank Receipt Voucher</h6></center>
                            </td>
                        </tr>
                    @endforelse


                    <tr>
                        <th colspan="5" class="align_right text-right border-0">
                            Total:-
                        </th>
                        <td class="align_right text-right border-0">
                            {{ number_format($brv_ttl_amnt,2) }}
                        </td>
                        <td class="align_right text-right border-0">
                            0.00
                        </td>
                    </tr>
                    <th colspan="8" class="border-0 size">
                        Bank Payment Voucher
                    </th>

                    @php
                        $bp = 1;
                        $bp_ttl_amnt = 0;
                    @endphp
                    @forelse($allData['datas_bp'] as $voucher)

                        <tr data-toggle="tooltip" data-placement="top" title="" data-original-title="View Journal Voucher">
                            <th scope="row">
                                {{$bp}}
                            </th>
                            <th>
                                {{$voucher->bp_id}}
                            </th>
                            <td>
                                {{date('d-M-y', strtotime(str_replace('/', '-', $voucher->bp_day_end_date)))}}
                            </td>
                            <td data-id="{{$voucher->bp_id}}">
                                BPV-{{$voucher->bp_id}}
                            </td>
                            <td>
                                {{$voucher->account_name}}
                            </td>

                            @php $bp_ttl_amnt = $bp_ttl_amnt + $voucher->bpi_amount;@endphp
                            <td class="align_right text-right">

                            </td>
                            <td class="align_right text-right">
                                {{$voucher->bpi_amount !=0 ? number_format($voucher->bpi_amount,2):''}}
                            </td>

                            @php
                                $ip_browser_info= ''.$voucher->bp_ip_adrs.','.str_replace(' ','-',$voucher->bp_brwsr_info).'';
                            @endphp

                            <td class="usr_prfl" data-usr_prfl="{{ $voucher->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                {{$voucher->user_name}}
                            </td>

                        </tr>
                        @php
                            $bp++; //(!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="11">
                                <center><h6 style="color:#554F4F">No Bank Payment Voucher</h6></center>
                            </td>
                        </tr>
                    @endforelse
                    <tr>
                        <th colspan="5" class="align_right text-right border-0">
                            Total:-
                        </th>
                        <td class="align_right text-right border-0">
                            0.00
                        </td>
                        <td class="align_right text-right border-0">
                            {{ number_format($bp_ttl_amnt,2) }}
                        </td>
                    </tr>

                    <th colspan="8" class="border-0 size">
                        Expense Payment Voucher
                    </th>

                    @php
                        $ep = 1;
                        $ep_ttl_amnt = 0;
                    @endphp
                    @forelse($allData['datas_ep'] as $voucher)

                        <tr data-toggle="tooltip" data-placement="top" title="" data-original-title="View Journal Voucher">
                            <th scope="row">
                                {{$ep}}
                            </th>
                            <th scope="row">
                                {{$voucher->ep_id}}
                            </th>
                            <td>
                                {{date('d-M-y', strtotime(str_replace('/', '-', $voucher->ep_day_end_date)))}}
                            </td>
                            <td data-id="{{$voucher->ep_id}}" class="tbl_amnt_6">
                                EPV-{{$voucher->ep_id}}
                            </td>
                            <td>
                                {{$voucher->account_name}}
                            </td>

                            <td class="align_right text-right">

                            </td>
                            @php $ep_ttl_amnt = $ep_ttl_amnt + $voucher->ep_total_amount;  @endphp
                            <td class="align_right text-right">
                                {{$voucher->ep_total_amount !=0 ? number_format($voucher->ep_total_amount,2):''}}
                            </td>

                            @php
                                $ip_browser_info= ''.$voucher->ep_ip_adrs.','.str_replace(' ','-',$voucher->ep_brwsr_info).'';
                            @endphp

                            <td class="usr_prfl" data-usr_prfl="{{ $voucher->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                {{$voucher->user_name}}
                            </td>

                        </tr>
                        @php
                            $ep++; //(!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="11">
                                <center><h6 style="color:#554F4F">No Expense Payment Voucher</h6></center>
                            </td>
                        </tr>
                    @endforelse
                    <tr>
                        <th colspan="5" class="align_right text-right border-0">
                            Total:-
                        </th>
                        <td class="align_right text-right border-0">
                            0.00
                        </td>
                        <td class="align_right text-right border-0">
                            {{ number_format($ep_ttl_amnt,2) }}
                        </td>
                    </tr>

                    <th colspan="8" class="border-0 size">
                        Journal Voucher
                    </th>

                    @php
                        $jv=1;
                        $ttl_dr = $ttl_cr = 0;
                    @endphp
                    @forelse($allData['datas_jv'] as $voucher)

                        <tr data-toggle="tooltip" data-placement="top" title="" data-original-title="View Journal Voucher">
                            <th scope="row">
                                {{$jv}}
                            </th>
                            <th scope="row">
                                {{$voucher->jv_id}}
                            </th>
                            <td>
                                {{date('d-M-y', strtotime(str_replace('/', '-', $voucher->jv_day_end_date)))}}
                            </td>
                            <td data-id="{{$voucher->jv_id}}">
                                JV-{{$voucher->jv_id}}
                            </td>

                            <td>
                                {!! $voucher->account_name !!}
                            </td>
                            <td align="right" class="align_right text-right">
                                @php
                                    $DR_val = ($voucher->jvi_type === "Dr") ? $voucher->jvi_amount : "";
                                    $DR = ($voucher->jvi_type === "Dr") ? $DR_val : "0";
                                    $ttl_dr = +$ttl_dr + +$DR;
                                @endphp
                                {{ (!empty($DR_val)) ? number_format($DR_val,2) : '' }}
                            </td>
                            <td align="right" class="align_right text-right">
                                @php
                                    $CR_val = ($voucher->jvi_type === "Cr") ? $voucher->jvi_amount : "";
                                    $CR = ($voucher->jvi_type === "Cr") ? $CR_val : "0";
                                    $ttl_cr = +$ttl_cr + +$CR;
                                @endphp
                                {{ (!empty($CR_val)) ? number_format($CR_val,2) : '' }}
                            </td>

                            @php
                                $ip_browser_info= ''.$voucher->jv_ip_adrs.','.str_replace(' ','-',$voucher->jv_brwsr_info).'';
                            @endphp

                            <td class="usr_prfl" data-usr_prfl="{{ $voucher->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                {{$voucher->user_name}}
                            </td>
                        </tr>
                        @php
                            $jv++; //(!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="11">
                                <center><h6 style="color:#554F4F">No Journal Voucher</h6></center>
                            </td>
                        </tr>
                    @endforelse
                    <tr>
                        <th colspan="5" class="align_right text-right border-0">
                            Total:-
                        </th>
                        <td class="align_right text-right border-0">
                            {{ number_format($ttl_dr,2) }}
                        </td>
                        <td class="align_right text-right border-0">
                            {{ number_format($ttl_cr,2) }}
                        </td>
                    </tr>


                    <th colspan="8" class="border-0 size">
                        Journal Voucher Reference
                    </th>

                    @php
                        $jvr=1;
                        $ttls_dr = $ttls_cr = 0;
                    @endphp
                    @forelse($allData['datas_jvr'] as $voucher)
                        @php
                            //$ttls_dr = +$voucher->jvr_total_dr + +$ttls_dr;
                            //$ttls_cr = +$voucher->jvr_total_cr + +$ttls_cr;
                        @endphp

                        <tr data-toggle="tooltip" data-placement="top" title="" data-original-title="View Journal Voucher">
                            <th scope="row">
                                {{$jvr}}
                            </th>
                            <th scope="row">
                                {{$voucher->jvr_id}}
                            </th>
                            <td>
                                {{date('d-M-y', strtotime(str_replace('/', '-', $voucher->jvr_day_end_date)))}}
                            </td>
                            <td data-id="{{$voucher->jvr_id}}">
                                JVR-{{$voucher->jvr_id}}
                            </td>

                            <td>
                                {!! $voucher->account_name !!}
                            </td>
                            <td align="right" class="align_right text-right">
                                @php
                                    $DR_val = ($voucher->jvri_type === "Dr") ? $voucher->jvri_amount : "";
                                    $DR = ($voucher->jvri_type === "Dr") ? $DR_val : "0";
                                    $ttls_dr = +$ttls_dr + +$DR;
                                @endphp
                                {{ (!empty($DR_val)) ? number_format($DR_val,2) : '' }}
                            </td>
                            <td align="right" class="align_right text-right">
                                @php
                                    $CR_val = ($voucher->jvri_type === "Cr") ? $voucher->jvri_amount : "";
                                    $CR = ($voucher->jvri_type === "Cr") ? $CR_val : "0";
                                    $ttls_cr = +$ttls_cr + +$CR;
                                @endphp
                                {{ (!empty($CR_val)) ? number_format($CR_val,2) : '' }}
                            </td>

                            @php
                                $ip_browser_info= ''.$voucher->jvr_ip_adrs.','.str_replace(' ','-',$voucher->jvr_brwsr_info).'';
                            @endphp

                            <td class="usr_prfl" data-usr_prfl="{{ $voucher->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                {{$voucher->user_name}}
                            </td>
                        </tr>
                        @php
                            $jvr++; //(!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="11">
                                <center><h6 style="color:#554F4F">No Journal Voucher Reference</h6></center>
                            </td>
                        </tr>
                    @endforelse
                    <tr>
                        <th colspan="5" class="align_right text-right border-0">
                            Total:-
                        </th>
                        <td class="align_right text-right border-0">
                            {{ number_format($ttls_dr,2) }}
                        </td>
                        <td class="align_right text-right border-0">
                            {{ number_format($ttls_cr,2) }}
                        </td>
                    </tr>

                    <th colspan="8" class="border-0 size">
                        Advance Salary Voucher
                    </th>


                    @php
                        $as=1;
                        $ttl_salary_amnt = 0;
                    @endphp
                    @forelse($allData['datas_as'] as $salary)

                        <tr>
                            <th scope="row">
                                {{$as}}
                            </th>
                            <th scope="row">
                                {{$salary->as_id}}
                            </th>
                            <td>
                                {{date('d-M-y', strtotime(str_replace('/', '-', $salary->as_day_end_date)))}}
                            </td>

                            <td>
                                {{'ASV-'.$salary->as_id}}
                            </td>


                            <td>

                                {!! $salary->employee_account !!}
                            </td>
                            @php $ttl_salary_amnt = +$salary->asi_amount + +$ttl_salary_amnt; @endphp

                            <td class="align_right text-right">
                                {{$salary->asi_amount}}
                            </td>
                            <td class="align_right text-right">

                            </td>

                            @php
                                $ip_browser_info= ''.$salary->as_ip_adrs.','.str_replace(' ','-',$salary->as_brwsr_info).'';
                            @endphp

                            <td class="usr_prfl" data-usr_prfl="{{ $salary->user_id }}" data-user_info="{!! $ip_browser_info !!}"
                                title="Click To See User Detail">
                                {{$salary->user_name}}
                            </td>
                        </tr>
                        @php
                            $as++; //(!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="11">
                                <center><h6 style="color:#554F4F">No Advance Salary Entry</h6></center>
                            </td>
                        </tr>
                    @endforelse
                    <tr>
                        <th colspan="5" class="align_right text-right border-0">
                            Total:-
                        </th>
                        <td class="align_right text-right border-0">
                            {{ number_format($ttl_salary_amnt,2) }}
                        </td>
                        <td class="align_right text-right border-0">
                            0.00
                        </td>
                    </tr>

                    <th colspan="8" class="border-0 size">
                        Salary Payment Voucher
                    </th>
                    @php
                        $sp=1;
                            $ttl_pay_amnt = 0;
                    @endphp
                    @forelse($allData['datas_sp'] as $voucher)
                        @php $ttl_pay_amnt = +$voucher->spi_paid_amount + +$ttl_pay_amnt; @endphp

                        <tr data-toggle="tooltip" data-placement="top" title="" data-original-title="View Journal Voucher">
                            <th scope="row">
                                {{$sp}}
                            </th>
                            <th scope="row">
                                {{$voucher->sp_id}}
                            </th>
                            <td>
                                {{date('d-M-y', strtotime(str_replace('/', '-', $voucher->sp_day_end_date)))}}
                            </td>
                            <td>
                                SPV-{{$voucher->sp_id}}
                            </td>

                            <td>
                                <div class="">

                                    {!! str_replace("&oS;",'<br />', $voucher->spi_account_name) !!}
                                </div>
                            </td>
                            <td align="right" class="align_right text-right">
                                {{$voucher->spi_paid_amount !=0 ? number_format($voucher->spi_paid_amount,2):''}}
                            </td>
                            <td align="right" class="align_right text-right">
                            </td>

                            @php
                                $ip_browser_info= ''.$voucher->sp_ip_adrs.','.str_replace(' ','-',$voucher->sp_brwsr_info).'';
                            @endphp

                            <td class="usr_prfl" data-usr_prfl="{{ $voucher->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                {{$voucher->user_name}}
                            </td>
                        </tr>
                        @php
                            $sp++; //(!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="11">
                                <center><h6 style="color:#554F4F">No Salary Payment Voucher</h6></center>
                            </td>
                        </tr>
                    @endforelse
                    <tr>
                        <th colspan="5" class="align_right text-right border-0">
                            Total:-
                        </th>
                        <td class="align_right text-right border-0">
                            {{ number_format($ttl_pay_amnt,2) }}
                        </td>
                        <td class="align_right text-right border-0">
                            0.00
                        </td>
                    </tr>

                    <th colspan="8" class="border-0 size">
                        Salary Slip Voucher
                    </th>

                    @php
                        $ss=1;
                        $ss_ttl_amnt = 0;
                    @endphp
                    @forelse($allData['datas_ss'] as $voucher)

                        <tr>
                            <th scope="row">
                                {{$ss}}
                            </th>
                            <th scope="row">
                                {{$voucher->ss_id}}
                            </th>
                            <td>
                                {{date('d-M-y', strtotime(str_replace('/', '-', $voucher->ss_day_end_date)))}}
                            </td>
                            <td>
                                SSV-{{$voucher->ss_id}}
                            </td>
                            <td>

                                {!! $voucher->ssi_account_name !!}
                            </td>
                            @php $ss_ttl_amnt = +$voucher->ssi_amount + +$ss_ttl_amnt; @endphp

                            <td class="align_right text-right">
                                {{$voucher->ssi_amount !=0 ? number_format($voucher->ssi_amount,2):''}}
                            </td>
                            <td class="align_right text-right">

                            </td>

                            @php
                                $ip_browser_info= ''.$voucher->ss_ip_adrs.','.str_replace(' ','-',$voucher->ss_brwsr_info).'';
                            @endphp

                            <td class="usr_prfl" data-usr_prfl="{{ $voucher->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                {{$voucher->user_name}}
                            </td>

                        </tr>
                        @php
                            $ss++; //(!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="11">
                                <center><h6 style="color:#554F4F">No Salary Slip Voucher</h6></center>
                            </td>
                        </tr>
                    @endforelse
                    <tr>
                        <th colspan="5" class="align_right text-right border-0">
                            Total:-
                        </th>
                        <td class="align_right text-right border-0">
                            {{ number_format($ss_ttl_amnt,2) }}
                        </td>
                        <td class="align_right text-right border-0">
                            0.00
                        </td>
                    </tr>

                    <th colspan="8" class="border-0 size">
                        Bill of Labour Voucher
                    </th>

                    @php
                        $bl=1;
                        $bl_ttl_amnt = 0;
                    @endphp
                    @forelse($allData['datas_bill'] as $voucher)

                        <tr>
                            <th scope="row">
                                {{$bl}}
                            </th>
                            <th scope="row">
                                {{$voucher->bl_id}}
                            </th>
                            <td>
                                {{date('d-M-y', strtotime(str_replace('/', '-', $voucher->bl_day_end_date)))}}
                            </td>
                            <td>
                                BLV-{{$voucher->bl_id}}
                            </td>
                            <td>

                                {!! $voucher->bli_account_name !!}
                            </td>
                            @php $bl_ttl_amnt = +$voucher->bli_amount + +$bl_ttl_amnt; @endphp

                            <td class="align_right text-right">
                                {{$voucher->bli_amount !=0 ? number_format($voucher->bli_amount,2):''}}
                            </td>
                            <td class="align_right text-right">

                            </td>

                            @php
                                $ip_browser_info= ''.$voucher->bl_ip_adrs.','.str_replace(' ','-',$voucher->bl_brwsr_info).'';
                            @endphp

                            <td class="usr_prfl" data-usr_prfl="{{ $voucher->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                {{$voucher->user_name}}
                            </td>

                        </tr>
                        @php
                            $bl++; //(!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="11">
                                <center><h6 style="color:#554F4F">No Bill of Labour Voucher</h6></center>
                            </td>
                        </tr>
                    @endforelse
                    <tr>
                        <th colspan="5" class="align_right text-right border-0">
                            Total:-
                        </th>
                        <td class="align_right text-right border-0">
                            {{ number_format($bl_ttl_amnt,2) }}
                        </td>
                        <td class="align_right text-right border-0">
                            0.00
                        </td>
                    </tr>

                    <th colspan="8" class="border-0 size">
                        Fixed Asset Voucher
                    </th>

                    @php
                        $fav=1;
                        $fav_ttl_amnt = 0;
                    @endphp
                    @forelse($allData['datas_fixed_asset'] as $voucher)

                        <tr>
                            <th scope="row">
                                {{$fav}}
                            </th>
                            <th scope="row">
                                {{$voucher->fav_id}}
                            </th>
                            <td>
                                {{date('d-M-y', strtotime(str_replace('/', '-', $voucher->fav_day_end_date)))}}
                            </td>
                            <td>
                                BLV-{{$voucher->fav_id}}
                            </td>
                            <td>

                                {!! $voucher->favi_account_name !!}
                            </td>
                            @php $fav_ttl_amnt = +$voucher->favi_amount + +$fav_ttl_amnt; @endphp

                            <td class="align_right text-right">
                                {{$voucher->favi_amount !=0 ? number_format($voucher->favi_amount,2):''}}
                            </td>
                            <td class="align_right text-right">

                            </td>

                            @php
                                $ip_browser_info= ''.$voucher->fav_ip_adrs.','.str_replace(' ','-',$voucher->fav_brwsr_info).'';
                            @endphp

                            <td class="usr_prfl" data-usr_prfl="{{ $voucher->user_id }}" data-user_info="{!! $ip_browser_info !!}" title="Click To See User Detail">
                                {{$voucher->user_name}}
                            </td>

                        </tr>
                        @php
                            $fav++; //(!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="11">
                                <center><h6 style="color:#554F4F">No Fixed Asset Voucher</h6></center>
                            </td>
                        </tr>
                    @endforelse
                    <tr>
                        <th colspan="5" class="align_right text-right border-0">
                            Total:-
                        </th>
                        <td class="align_right text-right border-0">
                            {{ number_format($fav_ttl_amnt,2) }}
                        </td>
                        <td class="align_right text-right border-0">
                            0.00
                        </td>
                    </tr>
                    </tbody>

                    @php $total_cr=$ep_ttl_amnt + $bp_ttl_amnt + $cp_amnt + $ttlPrc + $ttl_cr + $ttls_cr;
                            $total_dr=$ttlPrc + $ttl_amnt + $brv_ttl_amnt + $ttl_dr + $ttls_dr + $ttl_salary_amnt + $ttl_pay_amnt + $ss_ttl_amnt;
                    @endphp

                    <tfoot>
                    <tr class="border-0">
                        <th colspan="5" align="right" class="border-0 text-right align_right pt-0">

                        </th>
                        <th class="text-right border-left-0" align="right" style="border-right: 0px solid transparent;">
                            {{ number_format($total_dr,2) }}
                        </th>

                        <th class="text-right border-left-0" align="right" style="border-top: 1px solid #000;border-right: 0px solid transparent;">
                            {{ number_format($total_cr,2) }}
                        </th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div> <!-- white column form ends here -->
    </div><!-- row end -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg mdl_wdth">
            <div class="modal-content base_clr">
                <div class="modal-header">
                    <h4 class="modal-title text-black">Purchase Invoice Detail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div id="table_body">

                    </div>
                    <div id="hello"></div>

                </div>

                <div class="modal-footer">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form_controls">
                            <button type="button" class="btn btn-default form-control cancel_button" data-dismiss="modal">
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
        var base = '{{ route('today_report_list') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    {{--    <script>--}}
    {{--        // jQuery("#invoice_no").blur(function () {--}}
    {{--        jQuery(".view").click(function () {--}}
    {{--            // jQuery(".pre-loader").fadeToggle("medium");--}}
    {{--            jQuery("#table_body").html("");--}}

    {{--            var id = jQuery(this).attr("data-id");--}}
    {{--            $('.modal-body').load('{{url("purchase_items_view_details/view/")}}' + '/' + id, function () {--}}
    {{--                // jQuery(".pre-loader").fadeToggle("medium");--}}
    {{--                $('#myModal').modal({show: true});--}}
    {{--            });--}}

    {{--        });--}}
    {{--    </script>--}}

    <script>
        jQuery("#cancel").click(function () {

            $("#to").val('');
            $("#from").val('');
        });
    </script>
    <script>
        $(document).ready(function () {
            $('table').floatThead({
                position: 'absolute'
            });
        });
    </script>

@endsection
