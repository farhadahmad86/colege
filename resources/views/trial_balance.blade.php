@extends('extend_index')

@section('content')
    <link rel="stylesheet" type="text/css" href="{{asset('public/_api/day_end/src/css/day_end.css')}}">
    <style>
        .invoice_cntnt_sec {
            padding: 0 !important;
        }

        .day_end_header {
            padding: 0 !important;
        }

        /* Basic table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ccc;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }


        .table-wrapper {
            overflow-y: auto;
            max-height: 90vh;
        }

        .table-header {
            position: sticky !important;
            z-index: 1;
            top: 0;
        }

    </style>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30 form_manage" id="">
                <div class="form_header">
                    <!-- form header start -->
                    <div class="clearfix">
                        <div class="pull-left">
                            <h4 class="text-white get-heading-text file_name">Trial Balance</h4>
                        </div>
                        <div class="list_btn list_mul">
                            <div class="srch_box_opn_icon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!-- list btn -->
                    </div>
                </div><!-- form header close -->

                <!-- <div class="search_form {{ !empty($search_to) ? '' : 'search_form_hidden' }}"> -->

                <div class="search_form m-0 p-0">
                    <form class="highlight prnt_lst_frm" action="{{ route('trial_balance') }}" name="form1"
                          id="form1" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="row">

                                    <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                Select From Date
                                            </label>
                                            <input type="text" name="from" id="from"
                                                   class="inputs_up form-control date-picker"
                                                   <?php if (isset($from)){ ?> value="{{$from}}"
                                                   <?php } ?> placeholder="Date......" readonly/>
                                            <span id="demo1" class="validate_sign"> </span>
                                        </div>
                                    </div> <!-- left column ends here -->
                                    <div class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                        <div class="input_bx"><!-- start input box -->
                                            <label>
                                                Select To Date
                                            </label>
                                            <input type="text" name="to" id="to"
                                                   class="inputs_up form-control date-picker"
                                                   <?php if (isset($to)){ ?> value="{{$to}}"
                                                   <?php } ?> placeholder="Date......" readonly/>
                                            <span id="demo1" class="validate_sign"> </span>
                                        </div>
                                    </div> <!-- left column ends here -->
                                    <x-year-end-component search="{{$search_year}}"/>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-4 text-right">

                                        @include('include.clear_search_button')
                                        @include('include/print_button')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div><!-- search form end -->
                <hr/>
                {{--                start trial balance--}}
                <header class="day_end_header">
                    <div class="day_end_header_con"><!-- header container start -->
                        <div class="day_end_header_detail_bx"><!-- header detail box start -->
                            <p class="detail_para darkorange">
                                &nbsp;Exe TIme: {{$executionTime}}
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
                                                                             src="{{ asset('public/_api/day_end/src/images/expand1.png') }}"
                                                                             alt="Expand"
                                                                             onclick="toggleExpand(1, this);"/></span>
                        </h2>
                    </div>


                    <div class="table-wrapper">
                        <table id="trial" class="table day_end_table">
                            <thead class="text-white">
                            <tr class="table-header">
                                <th class="text-center tbl_srl_30 text-white">Account</th>
                                <th class="text-center tbl_srl_18 text-white">Opening</th>
                                <th class="text-center tbl_srl_18 text-white">Debit</th>
                                <th class="text-center tbl_srl_18 text-white">Credit</th>
                                <th class="text-center tbl_srl_18 text-white">Balance</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $total_opening_balance =$total_debit = $total_credit = 0;
                            @endphp
                            @foreach ($treeWithTotals as $entry)

                                @php
                                    $entry_code = $entry['code'];
                                    $entry_name = $entry['name'];
                                    $entry_2_balance = $entry['entry_dr_balance'];
                                @endphp


                                <tr data-uid="{{$entry_code}}" data-expendId="{{$entry_name}}" onclick="expendDiv(this)"
                                    class="head">
                                    @php
                                        $total = $entry['opening_balance']+$entry['entry_dr_balance'] - $entry['entry_cr_balance'];
                                    @endphp
                                    <th class="text-left tbl_txt_30">{{$entry_code}} - {{$entry_name}}</th>
                                    <th class="text-right tbl_srl_18">{{number_format($entry['opening_balance'],2)}}</th>
                                    <th class="text-right tbl_srl_18">{{number_format($entry['entry_dr_balance'],2)}}</th>
                                    <th class="text-right tbl_srl_18">{{number_format($entry['entry_cr_balance'],2)}}</th>
                                    @if($total >= 0)
                                        <th class="text-right tbl_srl_18">{{ number_format($total,2) }}</th>
                                    @else
                                        <th class="text-right tbl_srl_18">({{ number_format(abs($total),2) }})</th>
                                    @endif
                                </tr>

                                <tr class="setHeight heightZero" id="{{$entry_name}}">
                                    <td colspan="5" class="gnrl-mrgn-pdng">
                                        <table class="table">

                                            @foreach ($entry['children'] as $secondLevel)
                                                @php
                                                    $entry_2_code = $secondLevel['code'];
                                                    $entry_2_name = $secondLevel['name'];
                                                @endphp

                                                <tr data-uid="{{$entry_2_code}}" data-expendId="{{$entry_2_name}}"
                                                    onclick="expendDiv(this)" class="head">
                                                    @php
                                                        $total2 = $secondLevel['opening_balance'] + $secondLevel['entry_dr_balance'] - $secondLevel['entry_cr_balance'];
                                                    @endphp
                                                    <th class="text-left tbl_txt_30">{{$entry_2_code}}
                                                        - {{$entry_2_name}}</th>
                                                    <th class="text-right tbl_srl_18">{{number_format($secondLevel['opening_balance'],2)}}</th>
                                                    <th class="text-right tbl_srl_18">{{number_format($secondLevel['entry_dr_balance'],2)}}</th>
                                                    <th class="text-right tbl_srl_18">{{$secondLevel['entry_cr_balance']}}</th>
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

                                                            @foreach ($secondLevel['children'] as $thirdLevel)
                                                                @php
                                                                    $thirdLevel_code = $thirdLevel['code'];
                                                                    $thirdLevel_name = $thirdLevel['name'];
                                                                    $entry_4_balance = $thirdLevel['entry_cr_balance'];
                                                                    $entry_4_opening = $thirdLevel['entry_cr_balance'];
                                                                @endphp

                                                                <tr data-uid="{{$thirdLevel_code}}"
                                                                    data-expendId="{{$thirdLevel_name}}"
                                                                    onclick="expendDiv(this)" class="head">
                                                                    @php
                                                                        $total3 = $thirdLevel['opening_balance']+  $thirdLevel['entry_dr_balance'] - $thirdLevel['entry_cr_balance'];
                                                                    @endphp
                                                                    <th class="text-left tbl_txt_30">{{$thirdLevel_code}}
                                                                        - {{$thirdLevel_name}}</th>
                                                                    <th class="text-right tbl_srl_18">{{number_format($thirdLevel['opening_balance'],2)}}</th>
                                                                    <th class="text-right tbl_srl_18">{{number_format($thirdLevel['entry_dr_balance'],2)}}</th>
                                                                    <th class="text-right tbl_srl_18">{{number_format($thirdLevel['entry_cr_balance'],2)}}</th>
                                                                    @if($total3 >= 0)
                                                                        <th class="text-right tbl_srl_18">{{ number_format($total3,2) }}</th>
                                                                    @else
                                                                        <th class="text-right tbl_srl_18">
                                                                            ({{ number_format(abs($total3),2) }})
                                                                        </th>
                                                                    @endif
                                                                </tr>
                                                                <tr class="setHeight heightZero"
                                                                    id="{{$thirdLevel_name}}">
                                                                    <td colspan="5" class="gnrl-mrgn-pdng">
                                                                        <table class="table">
                                                                            @foreach ($thirdLevel['accounts'] as $account)

                                                                                @php
                                                                                    $balance5 = 0;
                                                                                        $account_code = $account['code'];
                                                                                        $account_name = $account['name'];
                                                                                        $total_opening_balance += $account['opening_balance'];
                                                                                        $total_debit += $account['entry_dr_balance'];
                                                                                        $total_credit += $account['entry_cr_balance'];

                                                                                        $total4 = $account['opening_balance']+$account['entry_dr_balance'] - $account['entry_cr_balance'];

                                                                                @endphp


                                                                                <tr data-uid="{{$account_code}}"
                                                                                    data-id="{{$account_code}}"
                                                                                    data-name="{{$account_name}}"
                                                                                    class="pointer link day-end-ledger">
                                                                                    <td class="text-left tbl_txt_30">{{$account_code}}
                                                                                        - {{$account_name}}</td>
                                                                                    <td class="text-right tbl_srl_18">{{number_format($account['opening_balance'],2)}}</td>
                                                                                    <td class="text-right tbl_srl_18">{{number_format($account['entry_dr_balance'],2)}}</td>
                                                                                    <td class="text-right tbl_srl_18">{{number_format($account['entry_cr_balance'],2)}}</td>
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
                    </div>
                    {{--                    @if($formatted_diff != 0)--}}
                    {{--                        <p class="alert-well">--}}
                    {{--                            Trial Balance is not equal, Difference amount is:--}}
                    {{--                            <strong> {{number_format($trialDifference, 2)}} </strong> Please contact to your admin to--}}
                    {{--                            adjust this amount. Trial must--}}
                    {{--                            be Equal for Day End procedure!--}}
                    {{--                        </p>--}}
                    {{--                    @endif--}}
                </section><!-- invoice content section end here -->
                {{--                <span--}}
                {{--                    class="hide_column">{{ $trialViewList->appends([ 'from' => $search_from, 'to' => $search_to])->links() }}</span>--}}
                {{--                end trial balance--}}
            </div> <!-- white column form ends here -->
        </div><!-- col end -->
    </div><!-- row end -->

@endsection

@section('scripts')

    {{--    add code by shahzaib start --}}
    <script type="text/javascript">
        var base = '{{ route('trial_balance') }}',
            url;

        @include('include.print_script_sh')
    </script>
    {{--    add code by shahzaib end --}}

    <script>
        jQuery("#cancel").click(function () {

            $("#to").val('');
        });
    </script>
    <script>
        // JavaScript to handle scroll event and fix header
        window.addEventListener('scroll', function () {
            const table = document.getElementById('trial');
            const header = table.querySelector('thead');
            if (header) {
                header.classList.toggle('fixed-header', window.scrollY > 0);
            }
        });
    </script>
    <script type="text/javascript">

        let getExpendDiv = "";

        function expendDiv(e) {
            getExpendDiv = e.getAttribute("data-expendId");
            let obj = document.getElementById(getExpendDiv);
            if (obj != null) {
                obj.classList.toggle("heightIncrease");
            }
        }

        function expand(e) {
            getExpendDiv = e.getAttribute("data-expendId");
            let obj = document.getElementById(getExpendDiv);
            if (obj != null) {
                obj.classList.add("heightIncrease");
            }
        }

        function collapse(e) {
            getExpendDiv = e.getAttribute("data-expendId");
            let obj = document.getElementById(getExpendDiv);
            if (obj != null) {
                obj.classList.remove("heightIncrease");
            }
        }

        function toggleExpand(id, img) {
            let imgSrc = $(img).attr("src");
            let collapseSrc = "https://college.jadeedmunshi.com/public/_api/day_end/src/images/collapse1.png";
            let expandSrc = "https://college.jadeedmunshi.com/public/_api/day_end/src/images/expand1.png";
            let src = "";
            let expanded = true;
            if (imgSrc.indexOf("collapse1.png") >= 0) {
                src = expandSrc;
                expanded = true;
            } else {
                src = collapseSrc;
                expanded = false;
            }

            $(img).attr("src", src);
            let tableId = "";
            switch (id) {
                case 1:
                    tableId = "#trial";
                    break;
                case 2:
                    tableId = "#cash";
                    break;
                case 3:
                    tableId = "#pnl";
                    break;
                case 4:
                    tableId = "#bs";
                    break;
            }

            if (expanded) {
                $(tableId + " tr[data-expendId]").each(function (key, row) {
                    collapse(row);
                });
            } else {
                $(tableId + " tr[data-expendId]").each(function (key, row) {
                    expand(row);
                });
            }
        }

    </script>
    {{--    <script src="https://college.jadeedmunshi.com/public/_api/day_end/src/js/jquery.js"></script>--}}
    <script src="{{asset('/public/_api/day_end/src/js/copy.js')}}"></script>
    <div id="snackbar"></div>

@endsection

