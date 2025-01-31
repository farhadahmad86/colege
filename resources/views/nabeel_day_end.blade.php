
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="shortcut icon" href="#">

    <title>
        Day End Execution Report
    </title>

    <link rel="stylesheet" type="text/css" href="https://pos.jadeedmunshi.com/public/_api/day_end/src/css/day_end.css" />


</head>
<body class="gnrl-mrgn-pdng">

<div class="main_container"><!-- miles planet main container start -->

    <div class="report_container"><!-- miles planet container start -->
@php
    use App\Models\AccountRegisterationModel;
use App\Models\AccountHeadsModel;
@endphp

@extends('extend_index')
@section('content')

    <!-- Trial Balance -->
        <section class="invoice_cntnt_sec"><!-- invoice content section start here -->
            <div class="invoice_cntnt_title_bx">
                <h2 class="gnrl-mrgn-pdng invoice_cntnt_title">
                    Trial Balance <span class="expand-img-span"><img class="expand-img" src="https://pos.jadeedmunshi.com/public/_api/day_end/src/images/expand1.png" alt="Expand"  onclick="toggleExpand(1, this);"/></span>
                </h2>
            </div>
            <table id="trial" class="table day_end_table">
                <thead>
                <tr>
                    <th class="text-center tbl_srl_18">Code</th>
                    <th class="text-center tbl_srl_18">Head</th>
                    <th class="text-center tbl_srl_18">Level</th>
                    <th class="text-center tbl_srl_18">Name</th>
                    <th class="text-center tbl_srl_18">Balance</th>
                </tr>
                </thead>
                <tbody>

        @foreach ($first as $th)

            @php
                $parent = AccountHeadsModel::select('coa_code', 'coa_head_name', 'coa_level')->where('coa_parent',$th->coa_code)->get();
                    $parent_balance = 0;
            @endphp


            <tr data-uid="{{$th->coa_code}}" data-expendId="{{$th->coa_head_name}}" onclick="expendDiv(this)" class="head">
                <th class="text-right tbl_srl_18">{{$th->coa_code}}</th>
                <th class="text-right tbl_srl_18">{{$th->coa_head_name}}</th>
                <th class="text-right tbl_srl_18">{{$th->coa_level}}</th>
                <th class="text-right tbl_srl_18"></th>
                <th class="text-right tbl_srl_18"></th>
            </tr>

            <tr class="setHeight heightZero" id="{{$th->coa_head_name}}">
                <td colspan="5" class="gnrl-mrgn-pdng">
                    <table class="table">

            @foreach ($parent as $pa)
                @php
                    $child = AccountHeadsModel::select('coa_code', 'coa_head_name', 'coa_level')->where('coa_parent',$pa->coa_code)->get();
                        $balance = 0;
                @endphp


                            <tr data-uid="{{$pa->coa_code}}" data-expendId="{{$pa->coa_head_name}}" onclick="expendDiv(this)" class="head">
                                <th class="text-right tbl_srl_18">{{$pa->coa_code}}</th>
                                <th class="text-right tbl_srl_18">{{$pa->coa_head_name}}</th>
                                <th class="text-right tbl_srl_18">{{$pa->coa_level}}</th>
                                <th class="text-right tbl_srl_18"></th>
                                <th class="text-right tbl_srl_18"></th>
                            </tr>

                            <tr class="setHeight heightZero" id="{{$pa->coa_head_name}}">
                                <td colspan="5" class="gnrl-mrgn-pdng">
                                    <table class="table">


                @foreach ($child as $ch)
                    @php
                        $entryQuery = AccountRegisterationModel::select('account_uid', 'account_name',
                           'account_today_opening_type', 'account_today_opening', 'account_today_debit', 'account_today_credit',
                          'account_monthly_opening_type', 'account_monthly_opening', 'account_monthly_debit', 'account_monthly_credit','account_balance')->where('account_parent_code',$ch->coa_code)->get();

                    @endphp
                                            <tr data-uid="{{$ch->coa_code}}" data-expendId="{{$ch->coa_head_name}}" onclick="expendDiv(this)" class="head">
                                                <th class="text-right tbl_srl_18">{{$ch->coa_code}}</th>
                                                <th class="text-right tbl_srl_18">{{$ch->coa_head_name}}</th>
                                                <th class="text-right tbl_srl_18">{{$ch->coa_level}}</th>
                                                <th class="text-right tbl_srl_18"></th>
                                                <th class="text-right tbl_srl_18"></th>
                                            </tr>
                                            <tr class="setHeight heightZero" id="{{$ch->coa_head_name}}">
                                                <td colspan="5" class="gnrl-mrgn-pdng">
                                                    <table class="table">



                    @foreach ($entryQuery as $entry)

                        @php
                         $balance += $entry->account_balance;
                         $parent_balance += $entry->account_balance;
                        @endphp

                                                            <tr data-uid="{{$entry->account_uid}}" data-id="{{$entry->account_uid}}" data-name="{{$entry->account_name}}" class="pointer link day-end-ledger">
                                                                <td class="text-right tbl_srl_18">{{$entry->account_uid}}</td>
                                                                <td class="text-right tbl_srl_18">entry account</td>
                                                                <td class="text-right tbl_srl_18">4</td>
                                                                @if($entry)
                                                                    <td class="text-right tbl_srl_18">{{$entry->account_name}}</td>
                                                                    <td class="text-right tbl_srl_18">{{$entry->account_balance}}</td>
                                                                @else
                                                                    <th class="text-right tbl_srl_18"></th>
                                                                    <th class="text-right tbl_srl_18"></th>
                                                                @endif
                                                            </tr>
                    @endforeach
                                                    </table>
                                                </td>
                                            </tr>

                @endforeach
                <tr>
                    <td class="text-right tbl_srl_18"></td>
                    <td class="text-right tbl_srl_18"></td>
                    <td class="text-right tbl_srl_18"></td>
                    <td class="text-right tbl_srl_18">Child Total</td>
                    <td class="text-right tbl_srl_18">{{$balance}}</td>
                </tr>

                                    </table>
                                </td>
                            </tr>

            @endforeach
            <tr>
                <td class="text-right tbl_srl_18"></td>
                <td class="text-right tbl_srl_18"></td>
                <td class="text-right tbl_srl_18"></td>
                <td class="text-right tbl_srl_18">Parent Total</td>
                <td class="text-right tbl_srl_18">{{$parent_balance}}</td>
            </tr>

                    </table>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
        </section><!-- invoice content section end here -->



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

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://pos.jadeedmunshi.com/public/_api/day_end/src/js/jquery.js" ></script>
        <script src="https://pos.jadeedmunshi.com/public/_api/day_end/src/js/copy.js"></script>

        <div id="snackbar"></div>
</body>
</html>
