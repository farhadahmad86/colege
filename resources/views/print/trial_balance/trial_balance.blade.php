@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')
    {{--    <link rel="stylesheet" type="text/css" href="https://college.jadeedmunshi.com/public/_api/day_end/src/css/day_end.css"/>--}}
    {{--    <style>--}}
    {{--        .invoice_cntnt_sec {--}}
    {{--            padding: 0 !important;--}}
    {{--        }--}}

    {{--        .day_end_header {--}}
    {{--            padding: 0 !important;--}}
    {{--        }--}}
    {{--    </style>--}}
    <header class="day_end_header">
        <div class="day_end_header_con"><!-- header container start -->
            <div class="day_end_header_detail_bx"><!-- header detail box start -->
                <p class="detail_para darkorange">
                    &nbsp;
                </p>
                <p class="detail_para">
                    Date:
                    <span>
                                    {{ date('d-M-y', strtotime(str_replace('/', '-', $from))) }} - {{ date('d-M-y', strtotime(str_replace('/', '-', $to))) }}
                        </span>
                </p>
            </div><!-- header detail box end -->

        </div><!-- header container end -->
        <div class="clear"></div>
    </header><!-- header end here -->

    <section class="invoice_cntnt_sec"><!-- invoice content section start here -->
        <div class="invoice_cntnt_title_bx">
            <h2 class="gnrl-mrgn-pdng invoice_cntnt_title">
                Trial Balance <span class="expand-img-span"><img class="expand-img"
                                                                 src="{{asset('public/_api/day_end/src/images/expand1.png')}}"
                                                                 alt="Expand"
                                                                 onclick="toggleExpand(1, this);"/></span>
            </h2>
        </div>
        <table id="trial" class="table day_end_table">
            <thead class="text-white">
            <tr>
                <th class="text-center tbl_srl_30">Account</th>
                <th class="text-center tbl_srl_18">Opening</th>
                <th class="text-center tbl_srl_18">Debit</th>
                <th class="text-center tbl_srl_18">Credit</th>
                <th class="text-center tbl_srl_18">Balance</th>
            </tr>
            </thead>
            <tbody>
            @php
                $total_opening_balance =$total_debit = $total_credit = 0;

            @endphp
            @foreach ($trialViewList as $entry)
                @php
                    $entry_code = $entry['code'];
                    $entry_name = $entry['name'];
                    $child = $entry['child'];
                    $entry_2_balance = $entry['cr_balance'];
                    $entry_2_type = '';

                @endphp


                <tr data-uid="{{$entry_code}}" data-expendId="{{$entry_name}}" onclick="expendDiv(this)"
                    class="head">
                    @php
                        $total = $entry['opening_balance']+$entry['dr_balance'] - $entry['cr_balance'];
                    @endphp
                    <th class="text-left tbl_txt_30">{{$entry_code}} - {{$entry_name}}</th>
                    <th class="text-right tbl_srl_18">{{number_format($entry['opening_balance'],2)}}</th>
                    <th class="text-right tbl_srl_18">{{number_format($entry['dr_balance'],2)}}</th>
                    <th class="text-right tbl_srl_18">{{number_format($entry['cr_balance'],2)}}</th>
                    @if($total >= 0)
                        <th class="text-right tbl_srl_18">{{ number_format($total,2) }}</th>
                    @else
                        <th class="text-right tbl_srl_18">({{ number_format(abs($total),2) }})</th>
                    @endif
                </tr>

                <tr class="setHeight heightZero" id="{{$entry_name}}">
                    <td colspan="5" class="gnrl-mrgn-pdng">
                        <table class="table">

                            @foreach ($child as $entry_2)
                                @php
                                    $entry_2_code = $entry_2['code'];
                                    $entry_2_name = $entry_2['name'];
                                    $child_2 = $entry_2['child'];

                                    $entry_3_type = '';
                                @endphp

                                <tr data-uid="{{$entry_2_code}}" data-expendId="{{$entry_2_name}}"
                                    onclick="expendDiv(this)" class="head">
                                    @php
                                        $total2 = $entry_2['opening_balance'] + $entry_2['dr_balance'] - $entry_2['cr_balance'];
                                    @endphp
                                    <th class="text-left tbl_txt_30">{{$entry_2_code}}
                                        - {{$entry_2_name}}</th>
                                    <th class="text-right tbl_srl_18">{{number_format($entry_2['opening_balance'],2)}}</th>
                                    <th class="text-right tbl_srl_18">{{number_format($entry_2['dr_balance'],2)}}</th>
                                    <th class="text-right tbl_srl_18">{{$entry_2['cr_balance']}}</th>
                                    @if($total2 >= 0)
                                        <th class="text-right tbl_srl_18">{{ number_format($total2,2) }}</th>
                                    @else
                                        <th class="text-right tbl_srl_18">
                                            ({{ number_format(abs($total2),2) }})
                                        </th>
                                    @endif

                                </tr>

                                <tr class="setHeight heightZero" id="{{$entry_2_name}}">
                                    <td colspan="5" class="gnrl-mrgn-pdng">
                                        <table class="table">

                                            @foreach ($child_2 as $entry_3)
                                                @php
                                                    $entry_3_code = $entry_3['code'];
                                                    $entry_3_name = $entry_3['name'];
                                                    $child_3 = $entry_3['child'];
                                                    $entry_4_balance = $entry_3['cr_balance'];
                                                    $entry_4_type = '';
                                                    $entry_4_opening = $entry_3['cr_balance'];
                                                @endphp

                                                <tr data-uid="{{$entry_3_code}}"
                                                    data-expendId="{{$entry_3_name}}"
                                                    onclick="expendDiv(this)" class="head">
                                                    @php
                                                        $total3 = $entry_3['opening_balance']+  $entry_3['dr_balance'] - $entry_3['cr_balance'];
                                                    @endphp
                                                    <th class="text-left tbl_txt_30">{{$entry_3_code}}
                                                        - {{$entry_3_name}}</th>
                                                    <th class="text-right tbl_srl_18">{{number_format($entry_3['opening_balance'],2)}}</th>
                                                    <th class="text-right tbl_srl_18">{{number_format($entry_3['dr_balance'],2)}}</th>
                                                    <th class="text-right tbl_srl_18">{{number_format($entry_3['cr_balance'],2)}}</th>
                                                    @if($total3 >= 0)
                                                        <th class="text-right tbl_srl_18">{{ number_format($total3,2) }}</th>
                                                    @else
                                                        <th class="text-right tbl_srl_18">
                                                            ({{ number_format(abs($total3),2) }})
                                                        </th>
                                                    @endif
                                                </tr>
                                                <tr class="setHeight heightZero" id="{{$entry_3_name}}">
                                                    <td colspan="5" class="gnrl-mrgn-pdng">
                                                        <table class="table">
                                                            @foreach ($child_3 as $entry_4)

                                                                @php
                                                                    $balance5 = 0;
                                                                        $entry_4_code = $entry_4['code'];
                                                                        $entry_4_name = $entry_4['name'];
                                                                        $total_opening_balance += $entry_4['opening_balance'];
                                                                        $total_debit += $entry_4['dr_balance'];
                                                                        $total_credit += $entry_4['cr_balance'];

                                                                        $total4 = $entry_4['opening_balance']+$entry_4['dr_balance'] - $entry_4['cr_balance'];

                                                                @endphp


                                                                <tr data-uid="{{$entry_4_code}}"
                                                                    data-id="{{$entry_4_code}}"
                                                                    data-name="{{$entry_4_name}}"
                                                                    class="pointer link day-end-ledger">
                                                                    <td class="text-left tbl_txt_30">{{$entry_4_code}}
                                                                        - {{$entry_4_name}}</td>
                                                                    <td class="text-right tbl_srl_18">{{number_format($entry_4['opening_balance'],2)}}</td>
                                                                    <td class="text-right tbl_srl_18">{{number_format($entry_4['dr_balance'],2)}}</td>
                                                                    <td class="text-right tbl_srl_18">{{number_format($entry_4['cr_balance'],2)}}</td>
                                                                    @if($total4 >= 0)
                                                                        <th class="text-right tbl_srl_18">{{ number_format($total4,2) }}</th>
                                                                    @else
                                                                        <th class="text-right tbl_srl_18">
                                                                            ({{ number_format(abs($total4),2) }}
                                                                            )
                                                                        </th>
                                                                    @endif
                                                                </tr>

                                                            @endforeach

                                                        </table>
                                                    </td>
                                                </tr>

                                            @endforeach
                                        </table>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>
            @endforeach
            @php
                $trialDifference = $total_debit - $total_credit;
                $formatted_diff = number_format($trialDifference, 2);
            @endphp
            <tr
                class="pointer link day-end-ledger text-white {{$formatted_diff == 0 ? 'gnrl-bg': 'bg-danger'}}">
                <th class="text-left tbl_txt_30">Total</th>

                <th class="text-right tbl_srl_18">{{number_format($total_opening_balance,2)}}</th>
                <th class="text-right tbl_srl_18">{{number_format($total_debit,2)}}</th>
                <th class="text-right tbl_srl_18 ">{{number_format($total_credit,2)}}</th>
                <th class="text-right tbl_srl_18 ">{{number_format($total_debit - $total_credit ,2)}}</th>
            </tr>
            </tbody>
        </table>
        @if($formatted_diff != 0)
            <p class="alert-well">
                Trial Balance is not equal, Difference amount is:
                <strong> {{number_format($trialDifference, 2)}} </strong> Please contact to your admin to
                adjust this amount. Trial must
                be Equal for Day End procedure!
            </p>
        @endif
    </section><!-- invoice content section end here -->

@endsection

