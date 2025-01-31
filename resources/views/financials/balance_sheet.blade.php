<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="shortcut icon" href="#">
    <title>
        Balance Sheet
    </title>
    <link rel="stylesheet" type="text/css" href="https://pos.jadeedmunshi.com/public/_api/day_end/src/css/day_end.css"/>

</head>
<body class="gnrl-mrgn-pdng">

<div class="main_container"><!-- miles planet main container start -->

    <div class="report_container"><!-- miles planet container start -->

        <header class="day_end_header">
            <div class="day_end_header_con"><!-- header container start -->

                <div class="day_end_logo_con"><!-- header logo container start -->
                    <div class="logo_bx gnrl-blk"><!-- header logo box start -->
                        <img src="http://www.pos.jadeedmunshi.com/storage/app//company_logo/50428.png" alt="Softagics"
                             height="50"/>
                    </div><!-- header logo box end -->
                </div><!-- header logo container end -->

                <div class="day_end_title_bx"><!-- header title box start -->
                    <h1>
                        Balance Sheet Report
                    </h1>
                </div><!-- header title box end -->

                <div class="day_end_header_detail_bx"><!-- header detail box start -->
                    <p class="detail_para darkorange">
                        &nbsp;
                    </p>
                    <p class="detail_para">
                        To:
                        <span>
                            {{$search_to}}
                        </span>
                    </p>
                    <p class="detail_para">
                        From:
                        <span>
                            {{$search_from}}
                        </span>
                    </p>
                </div><!-- header detail box end -->

            </div><!-- header container end -->
            <div class="clear"></div>
        </header><!-- header end here -->

        <!-- Trial Balance -->
        <section class="invoice_cntnt_sec"><!-- invoice content section start here -->
            <div class="invoice_cntnt_title_bx">
                <h2 class="gnrl-mrgn-pdng invoice_cntnt_title">
                    Balance Sheet <span class="expand-img-span"><img class="expand-img"
                                                                     src="https://pos.jadeedmunshi.com/public/_api/day_end/src/images/expand1.png"
                                                                     alt="Expand"
                                                                     onclick="toggleExpand(1, this);"/></span>
                </h2>
            </div>
            <table id="trial" class="table day_end_table">
                <thead>
                <tr>
{{--                    <th class="text-center tbl_srl_18">Code</th>--}}
                    <th class="text-center tbl_srl_59">Account</th>
                    <th class="text-center tbl_srl_18">Balance</th>
                    <th class="text-center tbl_srl_18">Total</th>
                </tr>
                </thead>
                <tbody>
                @php
$current_profit=0;@endphp
                @php
                    $lib_equtiy_current_profit=0;@endphp
                @foreach ($trial_view_list as $entry)
                    @php
                        $entry_code = $entry['code'];
                        $entry_name = $entry['name'];
                        $child = $entry['child'];
                        $entry_2_balance = $entry['balance'];
                        $entry_2_type = '';
                        $current_profit = $current_profit + $entry_2_balance;
                    @endphp


                    <tr data-uid="{{$entry_code}}" data-expendId="{{$entry_name}}" onclick="expendDiv(this)"
                        class="head">
{{--                        <th class="text-right tbl_srl_18">{{$entry_code}}</th>--}}
                        <th class="text-left tbl_txt_59">{{$entry_name}}</th>
                        <th class="text-right tbl_srl_18">{{number_format($entry_2_balance,2)}}</th>
                        <th class="text-right tbl_srl_18"></th>
                    </tr>

                    <tr class="setHeight heightZero" id="{{$entry_name}}">
                        <td colspan="5" class="gnrl-mrgn-pdng">
                            <table class="table">

                                @foreach ($child as $entry_2)
                                    @php
                                        $entry_2_code = $entry_2['code'];
                                        $entry_2_name = $entry_2['name'];
                                        $child_2 = $entry_2['child'];
                                        $entry_3_balance = $entry_2['balance'];
                                        $entry_3_type = '';
                                    @endphp

                                    <tr data-uid="{{$entry_2_code}}" data-expendId="{{$entry_2_name}}"
                                        onclick="expendDiv(this)" class="head">
{{--                                        <th class="text-right tbl_srl_18">{{$entry_2_code}}</th>--}}
                                        <th class="text-left tbl_txt_59">{{$entry_2_name}}</th>
                                        <th class="text-right tbl_srl_18">{{number_format($entry_3_balance,2)}}</th>
                                        <th class="text-right tbl_srl_18"></th>
                                    </tr>

                                    <tr class="setHeight heightZero" id="{{$entry_2_name}}">
                                        <td colspan="5" class="gnrl-mrgn-pdng">
                                            <table class="table">

                                                @foreach ($child_2 as $entry_3)
                                                    @php
                                                        $entry_3_code = $entry_3['code'];
                                                        $entry_3_name = $entry_3['name'];
                                                        $child_3 = $entry_3['child'];
                                                        $entry_4_balance = $entry_3['balance'];
                                                        $entry_4_type = '';
                                                        $entry_4_inward = $entry_3['inward'];
                                                        $entry_4_outward = $entry_3['outward'];
                                                        $entry_4_opening = $entry_3['balance'];
                                                    @endphp

                                                    <tr data-uid="{{$entry_3_code}}" data-expendId="{{$entry_3_name}}"
                                                        onclick="expendDiv(this)" class="head">
{{--                                                        <th class="text-right tbl_srl_18">{{$entry_3_code}}</th>--}}
                                                        <th class="text-left tbl_txt_59">{{$entry_3_name}}</th>
                                                        <th class="text-right tbl_srl_18">{{number_format($entry_4_balance,2)}}</th>
                                                        <th class="text-right tbl_srl_18"></th>

                                                    </tr>
                                                    <tr class="setHeight heightZero" id="{{$entry_3_name}}">
                                                        <td colspan="5" class="gnrl-mrgn-pdng">
                                                            <table class="table">
                                                                @foreach ($child_3 as $entry_4)

                                                                    @php
                                                                    $balance5 = 0;
if ($entry_code == 3){
    if($entry_4['inward'] > 0){
        $balance5 = '('.$entry_4['inward'].')';
    }else{
        $balance5 = $entry_4['outward'];
    }

}else if ($entry_code == 4){
    if($entry_4['outward'] > 0){
        $balance5 = '('.$entry_4['outward'].')';
    }else{
        $balance5 = $entry_4['inward'];
    }
}else{
    $balance5 = $entry_4['opening'];
}


                                                                        $entry_4_code = $entry_4['code'];
                                                                        $entry_4_name = $entry_4['name'];
                                                //                        $child_4 = $entry_4['child'];
                                             //   $entry_4_balance =$entry_4_balance + $balance5;
                                                //                        $entry_4_type = '';
                                                //$entry_4_inward += $balance5;
                                                //$entry_4_outward = $entry_4_outward +$balance5;
                                                //$entry_4_opening = $entry_4_opening + $balance5;
                                                                    @endphp


                                                                    <tr data-uid="{{$entry_4_code}}"
                                                                        data-id="{{$entry_4_code}}"
                                                                        data-name="{{$entry_4_name}}"
                                                                        class="pointer link day-end-ledger">
{{--                                                                        <td class="text-right tbl_srl_18">{{$entry_4_code}}</td>--}}
                                                                        <td class="text-left tbl_txt_59">{{$entry_4_name}}</td>
                                                                        <td class="text-right tbl_srl_18">{{number_format($balance5,2)}}</td>
                                                                        <td class="text-right tbl_srl_18"></td>
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
                    @if($entry_code == 1)
                    <tr
                        class="pointer link day-end-ledger">
{{--                        <td class="text-right tbl_srl_18"></td>--}}
                        <th class="text-left tbl_txt_59">Total Assets</th>
                        <th class="text-right tbl_srl_18"></th>
                        <th class="text-right tbl_srl_18 gnrl-bg">{{number_format($entry_2_balance = $entry['balance'],2)}}</th>
                    </tr>
                    @else
                        @php
                            $lib_equtiy_current_profit = $lib_equtiy_current_profit + $entry_2_balance;
                            @endphp
                    @endif
                @endforeach
                <tr
                    class="pointer link day-end-ledger">
{{--                    <td class="text-right tbl_srl_18"></td>--}}
                    <td class="text-left tbl_txt_59">Current Profit</td>

                    <td class="text-right tbl_srl_18">{{number_format($current_profit,2)}}</td>
                    <td class="text-right tbl_srl_18"></td>
                </tr>

                <tr
                    class="pointer link day-end-ledger">
{{--                    <td class="text-right tbl_srl_18"></td>--}}
                    <th class="text-left tbl_txt_59">Total (Liabilities + Equity)</th>

                    <th class="text-right tbl_srl_18"></th>{{$lib_equtiy_current_profit}} + {{$current_profit}}
                    <th class="text-right tbl_srl_18 gnrl-bg">{{number_format($lib_equtiy_current_profit - $current_profit,2)}}</th>
                </tr>
                </tbody>
            </table>
        </section><!-- invoice content section end here -->

        <!-- Footer Generated By -->
        <footer class="day_end_footer"><!-- footer section start here -->
            <div class="day_end_review_bx"><!-- footer container start -->
                <div class="review_title_bx"><!-- footer title box start -->
                    <h1 class="review_title">
                        INFO
                    </h1>
                </div><!-- footer sub title box end -->
                <div class="review_cntnt_bx gnrl-blk gnrl-mrgn-pdng"><!-- header detail box start -->
                    <p class="review_cntnt">
                        Name
                        <span>
                            Super Admin
                        </span>
                    </p>
                    <p class="review_cntnt">
                        Email
                        <span>
                            <a href="mailto:support@digitalmunshi.com">support@digitalmunshi.com</a>
                        </span>
                    </p>
                    <p class="review_cntnt">
                        Cell #
                        <span>
                            <a href="tel:03118798654">03118798654</a>
                        </span>
                    </p>

                    <p class="review_cntnt">
                        Exe Time
                        <span>
                            0.467 second(s)
                        </span>
                    </p>

                </div><!-- header detail box end -->
            </div><!-- footer container end -->

            <div class="sign_bx"><!-- header container start -->
                <div class="sign_title_bx"><!-- header title box start -->
                    <h1 class="sign_title">
                        Authorised Sign
                    </h1>
                </div><!-- header title box end -->
            </div><!-- header container end -->
            <div class="clear"></div>
        </footer><!-- footer section end here -->

        <!-- Footer Note -->
        <div class="note_well_bx">
            <div class="note_well_title_bx">
                <h3 class="note_well_title">
                    Note
                </h3>
            </div>
            <div class="note_well_cntnt">
                If you found anything wrong like calculation error, something missing or any kind of critical error that
                you think is not the part of a normal day end procedure, please contact to admin ASAP (As Soon As
                Possible) or mail us at <a href="mailto:support@jadeedmunshi.com"> support@jadeedmunshi.com </a> and do
                not execute Day End until the issue you found is not resolved. Thank you.
            </div>
        </div>

        <div class="clear"></div>

        {{--    scripts--}}
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
                let collapseSrc = "https://pos.jadeedmunshi.com/public/_api/day_end/src/images/collapse1.png";
                let expandSrc = "https://pos.jadeedmunshi.com/public/_api/day_end/src/images/expand1.png";
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
        <script src="https://pos.jadeedmunshi.com/public/_api/day_end/src/js/jquery.js"></script>
        <script src="https://pos.jadeedmunshi.com/public/_api/day_end/src/js/copy.js"></script>
        <div id="snackbar"></div>
</body>
</html>

