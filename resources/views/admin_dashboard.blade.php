@extends('vali')
@section('style')
@endsection
@section('content')
    <div class="row">

        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="row">

                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 mb-2">
                            <a href="{{route('first_level_chart_of_account')}}" class="btn btn-sm btn-success"
                               data-toggle="tooltip" data-placement="top" title="Chart Of Account Tree"
                               target="_blank">
                                <i class="fa-sharp fa-solid fa-tree"></i> Tree
                            </a>

                            <a href="{{route('chart_of_account_ledger')}}" class="btn btn-sm btn-success"
                               data-toggle="tooltip" data-placement="top" title="Account Ledger" target="_blank">
                                <i class="fa-solid fa-file-invoice-dollar"></i> AL
                            </a>

                            <a href="{{route('parties_account_ledger')}}" class="btn btn-sm btn-success"
                               data-toggle="tooltip" data-placement="top" title="Party Ledger" target="_blank">
                                <i class="fa-solid fa-file-invoice-dollar"></i> PL
                            </a>

                            <a href="{{route('today_report_list')}}" class="btn btn-sm btn-success"
                               data-toggle="tooltip" data-placement="top" title="Activity Report" target="_blank">
                                <i class="fa-solid fa-file-chart-column"></i> TA
                            </a>

                            <a href="{{route('cashbook')}}" class="btn btn-sm btn-success " data-toggle="tooltip"
                               data-placement="top" title="Cashbook" target="_blank">
                                <i class="fa-sharp fa-solid fa-wallet"></i> CB
                            </a>
                            <a href="{{route('account_receivable_list')}}" class="btn btn-sm btn-success "
                               data-toggle="tooltip" data-placement="top" title="Account Receivable" target="_blank">
                                <i class="fa-sharp fa-solid fa-wallet"></i> AR
                            </a>
                            <a href="{{route('account_payable_list')}}" class="btn btn-sm btn-success "
                               data-toggle="tooltip" data-placement="top" title="Account Payable" target="_blank">
                                <i class="fa-sharp fa-solid fa-wallet"></i> AP
                            </a>

                            <a href="{{route('sale_invoice')}}" class="btn btn-sm btn-info" data-toggle="tooltip"
                               data-placement="top" title="Sale Invoice" target="_blank">
                                <i class="fa-sharp fa-solid fa-file-invoice"></i> SI
                            </a>

                            <a href="{{route('purchase_invoice')}}" class="btn btn-sm btn-info" data-toggle="tooltip"
                               data-placement="top" title="Purchase Invoice" target="_blank">
                                <i class="fa-sharp fa-solid fa-file-invoice"></i> PI
                            </a>

                            <a href="{{route('cash_receipt_voucher')}}" class="btn btn-sm btn-primary"
                               data-toggle="tooltip" data-placement="top" title="Account Voucher" target="_blank">
                                <i class="fa fa-solid fa-receipt"></i> CRV
                            </a>

                            <a href="{{route('cash_payment_voucher')}}" class="btn btn-sm btn-primary"
                               data-toggle="tooltip" data-placement="top" title="Account Voucher" target="_blank">
                                <i class="fa fa-solid fa-receipt"></i> CPV
                            </a>

                            <a href="{{route('bank_receipt_voucher')}}" class="btn btn-sm btn-primary"
                               data-toggle="tooltip" data-placement="top" title="Account Voucher" target="_blank">
                                <i class="fa fa-solid fa-receipt"></i> BRV
                            </a>

                            <a href="{{route('bank_payment_voucher')}}" class="btn btn-sm btn-primary"
                               data-toggle="tooltip" data-placement="top" title="Account Voucher" target="_blank">
                                <i class="fa fa-solid fa-receipt"></i> BPV
                            </a>

                            <a href="{{route('journal_voucher')}}" class="btn btn-sm btn-primary" data-toggle="tooltip"
                               data-placement="top" title="Journal Voucher" target="_blank">
                                <i class="fa fa-solid fa-receipt"></i> JV
                            </a>

                            <a href="{{route('force_offline_user')}}" class="btn btn-sm btn-danger"
                               data-toggle="tooltip" data-placement="top" title="Force Offline User" target="_blank">
                                <i class="fa-sharp fa-solid fa-power-off"></i> FO
                            </a>
                            <a href="{{route('start_day_end')}}" class="btn btn-sm btn-danger" data-toggle="tooltip"
                               data-placement="top" title="Day End" target="_blank">
                                <i class="fa-solid fa-hourglass-end"></i> DE
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-lg-2 mb-2">
                            <div class="widget-small danger coloured-icon">
                                <i class="icon fa fa-users fa-3x"></i>
                                <div class="info text-center">
                                    <h4>Financial Days</h4>
                                    <p><b>{{$financial_days}}/365</b></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-2 mb-2">
                            <div class="widget-small primary coloured-icon">
                                <i class="icon fa fa-users fa-3x"></i>
                                <div class="info text-center">
                                    <h4>Employees</h4>
                                    <p><b>{{$employee}}</b></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-2 mb-2">
                            <div class="widget-small info coloured-icon"><i class="icon fa-solid fa-users"></i>
                                <div class="info text-center">
                                    <h4>Users</h4>
                                    <p><b>{{$app_users}}/{{$total_users}}</b></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-2 mb-2">
                            <div class="widget-small primary coloured-icon"><i class="icon fa fa-files-o fa-3x"></i>
                                <div class="info text-center">
                                    <h4>Accounts</h4>
                                    <p><b>{{$total_account}}</b></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-2 mb-2">
                            <a href="{{route('trade_delivery_order_sale_invoice')}}" target="_blank">
                                <div class="widget-small success coloured-icon">
                                    <i class="icon fa-solid fa-truck"></i>
                                    <div class="info text-center">
                                        <h4>Delivery Order</h4>
                                        <p><b>{{$do->count()}}</b></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-12 col-lg-2 mb-2">
                            <a href="{{route('trade_sale_order_sale_invoice')}}" target="_blank">
                                <div class="widget-small purpal coloured-icon">
                                    <i class="icon fa-solid fa-rupee-sign"></i>
                                    <div class="info text-center">

                                        <h4>Sale Order</h4>
                                        <p><b>{{$so->count()}}</b></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-12 col-lg-2 mb-2">
                            <a href="{{route('trade_grn_purchase_invoice')}}" target="_blank">
                                <div class="widget-small lit_purpal coloured-icon">
                                    <i class="icon fa fa-line-chart"></i>
                                    <div class="info text-center">
                                        <h4>GRN</h4>
                                        <p><b>{{$grn->count()}}</b></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-12 col-lg-2 mb-2">
                            <div class="widget-small dark_purpal coloured-icon"><i class="icon fa fa-star fa-3x"></i>
                                <div class="info text-center">
                                    <h4>Total Products</h4>
                                    <p><b>{{$products}}</b></p>
                                </div>
                            </div>
                        </div>
                        {{--                    </div>--}}
                        {{--                </div>--}}
                        {{--                <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">--}}
                        {{--                    <div class="row">--}}
                        {{--                        <div class="col-md-12 col-lg-2 mb-2">--}}
                        {{--                            <div class="widget-small blue coloured-icon">--}}
                        {{--                                <i class="icon fa fa-line-chart"></i>--}}
                        {{--                                <div class="info text-center">--}}
                        {{--                                    <h4>Sale Invoice & Amount</h4>--}}
                        {{--                                    <p><b><i class="fa fa-file-text-o"></i> {{$products}}</b> <b><i class="fa fa-money"></i> {{$products}}</b></p>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        <div class="col-md-12 col-lg-2 mb-2">
                            <a href="{{route('cash_receipt_post_voucher_list')}}" target="_blank">
                                <div class="widget-small blue_lit coloured-icon">
                                    <i class="icon fa-solid fa-sack-dollar"></i>
                                    <div class="info text-center">
                                        <h4>Cash Receipt Park Voucher</h4>
                                        <p><b>{{$cash_receipt}}</b></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-12 col-lg-2 mb-2">
                            <a href="{{route('cash_payment_post_voucher_list')}}" target="_blank">
                                <div class="widget-small green coloured-icon">
                                    <i class="icon fa-solid fa-sack-dollar"></i>
                                    <div class="info text-center">
                                        <h4>Cash Payment Park Voucher</h4>
                                        <p><b>{{$cash_payment}}</b></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-12 col-lg-2 mb-2">
                            <a href="{{route('bank_receipt_post_voucher_list')}}" target="_blank">
                                <div class="widget-small mehdi coloured-icon">
                                    <i class="icon fa-solid fa-building-columns"></i>
                                    <div class="info text-center">
                                        <h4>Bank Receipt Park Voucher</h4>
                                        <p><b>{{$bank_receipt}}</b></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-12 col-lg-2 mb-2">
                            <a href="{{route('bank_payment_post_voucher_list')}}" target="_blank">
                                <div class="widget-small warning coloured-icon">
                                    <i class="icon fa-solid fa-building-columns"></i>
                                    <div class="info text-center">
                                        <h4>Bank Payment Park Voucher</h4>
                                        <p><b>{{$bank_payment}}</b></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-12 col-lg-2 mb-2">
                            <a href="#">
                                <div class="widget-small success coloured-icon">
                                    <i i class="icon fa-solid fa-users"></i>
                                    <div class="info text-center">
                                        <h4>Active Students</h4>
                                        <p><b>{{$active}}</b></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-12 col-lg-2 mb-2">
                            <a href="#">
                                <div class="widget-small info coloured-icon">
                                    <i class="icon fa-solid fa-graduation-cap"></i>
                                    <div class="info text-center">
                                        <h4>Graduate Students</h4>
                                        <p><b>{{$graduate}}</b></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-12 col-lg-2 mb-2">
                            <a href="#">
                                <div class="widget-small danger coloured-icon">
                                    <i class="icon fa-solid fa-users"></i>
                                    <div class="info text-center">
                                        <h4>Stuckoff Students</h4>
                                        <p><b>{{$stuckOff}}</b></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="row">

                <div class="col-lg-8 col-md-12 col-sm-12 mb-2">
                    <div class="bg-white m-0 form_manage"><!-- form manage box start -->
                        <div class="form_header"><!-- form header start -->
                            <div class="clearfix">
                                <div class="pull-left">
                                    <h4 class="text-white get-heading-text">Financial Comparison</h4>
                                </div>
                            </div>
                        </div><!-- form header close -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-9">
                                <div class="bg-white">
                                    <div id="financial_comparison" class="chart"></div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">

                                <div class="chart_bx chart_bx_blk"><!-- chart box start -->

                                    <div class="chart_bx_itm text-right mb-1 clr_december"><!-- chart box item start -->
                                        <div class="chart_bx_itm_ttl">
                                            December
                                        </div>
                                        <div class="chart_bx_itm_cntnt">
                                            Rs.53,118,252/-
                                        </div>
                                    </div><!-- chart box item end -->

                                    <div class="chart_bx_itm text-right mb-1 clr_november"><!-- chart box item start -->
                                        <div class="chart_bx_itm_ttl">
                                            November
                                        </div>
                                        <div class="chart_bx_itm_cntnt">
                                            Rs.29,329,205/-
                                        </div>
                                    </div><!-- chart box item end -->

                                    <div class="chart_bx_itm text-right mb-1 clr_average"><!-- chart box item start -->
                                        <div class="chart_bx_itm_ttl">
                                            Average
                                        </div>
                                        <div class="chart_bx_itm_cntnt">
                                            Rs.41,223,728/-
                                        </div>
                                    </div><!-- chart box item end -->

                                </div><!-- chart box end -->

                                <div class="chart_bx chart_bx_inline"><!-- chart box start -->
                                    <div class="chart_bx_itm brdr_clr_average brdr_lft_5"><!-- chart box item start -->
                                        <div class="chart_bx_itm_cntnt">
                                            Rs.41,223,728/-
                                        </div>
                                        <div class="chart_bx_itm_ttl">
                                            October
                                        </div>
                                    </div><!-- chart box item end -->
                                    <div class="chart_bx_itm brdr_clr_november brdr_lft_5"><!-- chart box item start -->
                                        <div class="chart_bx_itm_cntnt">
                                            Rs.53,118,252/-
                                        </div>
                                        <div class="chart_bx_itm_ttl">
                                            September
                                        </div>
                                    </div><!-- chart box item end -->
                                    <div class="chart_bx_itm brdr_clr_december brdr_lft_5"><!-- chart box item start -->
                                        <div class="chart_bx_itm_cntnt">
                                            Rs.29,329,205/-
                                        </div>
                                        <div class="chart_bx_itm_ttl">
                                            August
                                        </div>
                                    </div><!-- chart box item end -->
                                    <div class="chart_bx_itm brdr_clr_december brdr_lft_5"><!-- chart box item start -->
                                        <div class="chart_bx_itm_cntnt">
                                            Rs.29,329,205/-
                                        </div>
                                        <div class="chart_bx_itm_ttl">
                                            July
                                        </div>
                                    </div><!-- chart box item end -->
                                    <div class="chart_bx_itm brdr_clr_december brdr_lft_5"><!-- chart box item start -->
                                        <div class="chart_bx_itm_cntnt">
                                            Rs.29,329,205/-
                                        </div>
                                        <div class="chart_bx_itm_ttl">
                                            June
                                        </div>
                                    </div><!-- chart box item end -->
                                    <div class="chart_bx_itm brdr_clr_december brdr_lft_5"><!-- chart box item start -->
                                        <div class="chart_bx_itm_cntnt">
                                            Rs.29,329,205/-
                                        </div>
                                        <div class="chart_bx_itm_ttl">
                                            May
                                        </div>
                                    </div><!-- chart box item end -->
                                    <div class="chart_bx_itm brdr_clr_december brdr_lft_5"><!-- chart box item start -->
                                        <div class="chart_bx_itm_cntnt">
                                            Rs.29,329,205/-
                                        </div>
                                        <div class="chart_bx_itm_ttl">
                                            Aprail
                                        </div>
                                    </div><!-- chart box item end -->
                                    <div class="chart_bx_itm brdr_clr_december brdr_lft_5"><!-- chart box item start -->
                                        <div class="chart_bx_itm_cntnt">
                                            Rs.29,329,205/-
                                        </div>
                                        <div class="chart_bx_itm_ttl">
                                            March
                                        </div>
                                    </div><!-- chart box item end -->
                                    <div class="chart_bx_itm brdr_clr_december brdr_lft_5"><!-- chart box item start -->
                                        <div class="chart_bx_itm_cntnt">
                                            Rs.29,329,205/-
                                        </div>
                                        <div class="chart_bx_itm_ttl">
                                            Feburaray
                                        </div>
                                    </div><!-- chart box item end -->
                                    <div class="chart_bx_itm brdr_clr_december brdr_lft_5"><!-- chart box item start -->
                                        <div class="chart_bx_itm_cntnt">
                                            Rs.29,329,205/-
                                        </div>
                                        <div class="chart_bx_itm_ttl">
                                            January
                                        </div>
                                    </div><!-- chart box item end -->
                                </div><!-- chart box end -->

                            </div>
                        </div>

                    </div><!-- form manage box end -->
                </div>

                <div class="col-lg-4 col-md-12 col-sm-12 mb-2">
                    <div class="bg-white m-0 form_manage"><!-- form manage box start -->

                        <div class="form_header"><!-- form header start -->
                            <div class="clearfix">
                                <div class="pull-left">
                                    <h4 class="text-white">Debtors & Creditors Position</h4>
                                </div>
                            </div>
                        </div><!-- form header close -->

                        <div class="bg-white height-100-p">
                            <div id="dbtr_crdtr_pstn" class="chart"></div>
                        </div>

                    </div><!-- form manage box end -->
                </div>

                <div class="col-lg-5 col-md-12 col-sm-12 mb-2">
                    <div class="bg-white m-0 form_manage"><!-- form manage box start -->

                        <div class="form_header"><!-- form header start -->
                            <div class="clearfix">
                                <div class="pull-left">
                                    <h4 class="text-white">Payments Arrangements</h4>
                                </div>
                            </div>
                        </div><!-- form header close -->

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="bg-white">
                                    <div id="payments_arrangements" class="chart"></div>
                                </div>
                            </div>
                        </div>


                    </div><!-- form manage box end -->
                </div>

                <div class="col-lg-7 col-md-12 col-sm-12 mb-2">
                    <div class="bg-white m-0 form_manage"><!-- form manage box start -->

                        <div class="form_header"><!-- form header start -->
                            <div class="clearfix">
                                <div class="pull-left">
                                    <h4 class="text-white">Sales Comparison</h4>
                                </div>
                            </div>
                        </div><!-- form header close -->

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">

                                <div class="chart_bx chart_bx_blk"><!-- chart box start -->

                                    <div class="chart_bx_itm text-left mb-1 clr_december"><!-- chart box item start -->
                                        <div class="chart_bx_itm_ttl">
                                            December
                                        </div>
                                        <div class="chart_bx_itm_cntnt">
                                            Rs.53,118,252/-
                                        </div>
                                    </div><!-- chart box item end -->

                                    <div class="chart_bx_itm text-left mb-1 clr_november"><!-- chart box item start -->
                                        <div class="chart_bx_itm_ttl">
                                            November
                                        </div>
                                        <div class="chart_bx_itm_cntnt">
                                            Rs.29,329,205/-
                                        </div>
                                    </div><!-- chart box item end -->

                                    <div class="chart_bx_itm text-left mb-1 clr_average"><!-- chart box item start -->
                                        <div class="chart_bx_itm_ttl">
                                            Average
                                        </div>
                                        <div class="chart_bx_itm_cntnt">
                                            Rs.41,223,728/-
                                        </div>
                                    </div><!-- chart box item end -->

                                </div><!-- chart box end -->

                                <div class="chart_bx chart_bx_inline"><!-- chart box start -->
                                    <div class="chart_bx_itm brdr_clr_average brdr_lft_5"><!-- chart box item start -->
                                        <div class="chart_bx_itm_cntnt">
                                            Rs.41,223,728/-
                                        </div>
                                        <div class="chart_bx_itm_ttl">
                                            October
                                        </div>
                                    </div><!-- chart box item end -->
                                    <div class="chart_bx_itm brdr_clr_november brdr_lft_5"><!-- chart box item start -->
                                        <div class="chart_bx_itm_cntnt">
                                            Rs.53,118,252/-
                                        </div>
                                        <div class="chart_bx_itm_ttl">
                                            September
                                        </div>
                                    </div><!-- chart box item end -->
                                    <div class="chart_bx_itm brdr_clr_december brdr_lft_5"><!-- chart box item start -->
                                        <div class="chart_bx_itm_cntnt">
                                            Rs.29,329,205/-
                                        </div>
                                        <div class="chart_bx_itm_ttl">
                                            August
                                        </div>
                                    </div><!-- chart box item end -->
                                    <div class="chart_bx_itm brdr_clr_december brdr_lft_5"><!-- chart box item start -->
                                        <div class="chart_bx_itm_cntnt">
                                            Rs.29,329,205/-
                                        </div>
                                        <div class="chart_bx_itm_ttl">
                                            July
                                        </div>
                                    </div><!-- chart box item end -->
                                    <div class="chart_bx_itm brdr_clr_december brdr_lft_5"><!-- chart box item start -->
                                        <div class="chart_bx_itm_cntnt">
                                            Rs.29,329,205/-
                                        </div>
                                        <div class="chart_bx_itm_ttl">
                                            June
                                        </div>
                                    </div><!-- chart box item end -->
                                    <div class="chart_bx_itm brdr_clr_december brdr_lft_5"><!-- chart box item start -->
                                        <div class="chart_bx_itm_cntnt">
                                            Rs.29,329,205/-
                                        </div>
                                        <div class="chart_bx_itm_ttl">
                                            May
                                        </div>
                                    </div><!-- chart box item end -->
                                    <div class="chart_bx_itm brdr_clr_december brdr_lft_5"><!-- chart box item start -->
                                        <div class="chart_bx_itm_cntnt">
                                            Rs.29,329,205/-
                                        </div>
                                        <div class="chart_bx_itm_ttl">
                                            Aprail
                                        </div>
                                    </div><!-- chart box item end -->
                                    <div class="chart_bx_itm brdr_clr_december brdr_lft_5"><!-- chart box item start -->
                                        <div class="chart_bx_itm_cntnt">
                                            Rs.29,329,205/-
                                        </div>
                                        <div class="chart_bx_itm_ttl">
                                            March
                                        </div>
                                    </div><!-- chart box item end -->
                                    <div class="chart_bx_itm brdr_clr_december brdr_lft_5"><!-- chart box item start -->
                                        <div class="chart_bx_itm_cntnt">
                                            Rs.29,329,205/-
                                        </div>
                                        <div class="chart_bx_itm_ttl">
                                            Feburaray
                                        </div>
                                    </div><!-- chart box item end -->
                                    <div class="chart_bx_itm brdr_clr_december brdr_lft_5"><!-- chart box item start -->
                                        <div class="chart_bx_itm_cntnt">
                                            Rs.29,329,205/-
                                        </div>
                                        <div class="chart_bx_itm_ttl">
                                            January
                                        </div>
                                    </div><!-- chart box item end -->
                                </div><!-- chart box end -->

                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-9">
                                <div class="bg-white">
                                    <div id="sales_comparison" class="chart"></div>
                                </div>
                            </div>
                        </div>


                    </div><!-- form manage box end -->
                </div>

                <div class="col-lg-7 col-md-12 col-sm-12 mb-2">
                    <div class="bg-white m-0 form_manage"><!-- form manage box start -->

                        <div class="form_header"><!-- form header start -->
                            <div class="clearfix">
                                <div class="pull-left">
                                    <h4 class="text-white">Revenue vs Expense</h4>
                                </div>
                            </div>
                        </div><!-- form header close -->

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">

                                <div class="chart_bx chart_bx_blk"><!-- chart box start -->

                                    <div class="chart_bx_itm text-center mb-1"><!-- chart box item start -->
                                        <div class="chart_bx_itm_ttl">
                                            Total Revenue
                                        </div>
                                        <div class="chart_bx_itm_cntnt">
                                            Rs.53,118,252/-
                                        </div>
                                    </div><!-- chart box item end -->

                                    <div class="chart_bx_itm text-center mb-1"><!-- chart box item start -->
                                        <div class="chart_bx_itm_ttl">
                                            Total Expense
                                        </div>
                                        <div class="chart_bx_itm_cntnt">
                                            Rs.29,329,205/-
                                        </div>
                                    </div><!-- chart box item end -->

                                </div><!-- chart box end -->

                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-9">
                                <div class="bg-white">
                                    <div id="income_expense_comparison" class="chart"></div>
                                </div>
                            </div>
                        </div>


                    </div><!-- form manage box end -->
                </div>

                <div class="col-lg-5 col-md-12 col-sm-12 mb-2">
                    <div class="bg-white m-0 form_manage"><!-- form manage box start -->

                        <div class="form_header"><!-- form header start -->
                            <div class="clearfix">
                                <div class="pull-left">
                                    <h4 class="text-white">Working Capital Position</h4>
                                </div>
                            </div>
                        </div><!-- form header close -->

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="bg-white">
                                    <div id="wrkng_cpital_psition" class="chart"></div>
                                </div>
                            </div>
                        </div>


                    </div><!-- form manage box end -->
                </div>

                <div class="col-lg-8 col-md-12 col-sm-12 mb-2">
                    <div class="bg-white m-0 form_manage"><!-- form manage box start -->

                        <div class="form_header"><!-- form header start -->
                            <div class="clearfix">
                                <div class="pull-left">
                                    <h4 class="text-white">High Margin Product Sales</h4>
                                </div>
                            </div>
                        </div><!-- form header close -->

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-9">
                                <div class="bg-white">
                                    <div id="high_margin_product" class="chart"></div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">

                                <div class="chart_bx chart_bx_blk"><!-- chart box start -->

                                    <div class="chart_bx_itm text-left mb-1"><!-- chart box item start -->
                                        <div class="chart_bx_itm_cntnt">
                                            121
                                        </div>
                                        <div class="chart_bx_itm_ttl">
                                            Total
                                        </div>
                                    </div><!-- chart box item end -->

                                </div><!-- chart box end -->

                                <div class="chart_bx chart_bx_inline"><!-- chart box start -->
                                    <div class="chart_bx_itm top_pro_brdr_clr_1 brdr_lft_5">
                                        <!-- chart box item start -->
                                        <div class="chart_bx_itm_cntnt">
                                            22
                                        </div>
                                        <div class="chart_bx_itm_ttl">
                                            Panda Lipbalm
                                        </div>
                                    </div><!-- chart box item end -->
                                    <div class="chart_bx_itm top_pro_brdr_clr_2 brdr_lft_5">
                                        <!-- chart box item start -->
                                        <div class="chart_bx_itm_cntnt">
                                            9
                                        </div>
                                        <div class="chart_bx_itm_ttl">
                                            Hair Band
                                        </div>
                                    </div><!-- chart box item end -->
                                    <div class="chart_bx_itm top_pro_brdr_clr_3 brdr_lft_5">
                                        <!-- chart box item start -->
                                        <div class="chart_bx_itm_cntnt">
                                            55
                                        </div>
                                        <div class="chart_bx_itm_ttl">
                                            Tool Set Toya
                                        </div>
                                    </div><!-- chart box item end -->
                                    <div class="chart_bx_itm top_pro_brdr_clr_4 brdr_lft_5">
                                        <!-- chart box item start -->
                                        <div class="chart_bx_itm_cntnt">
                                            35
                                        </div>
                                        <div class="chart_bx_itm_ttl">
                                            Young Artist Set
                                        </div>
                                    </div><!-- chart box item end -->
                                </div><!-- chart box end -->

                            </div>
                        </div>


                    </div><!-- form manage box end -->
                </div>


            </div>
        </div>

    </div><!-- end row -->
@endsection

@section('script')

    <!-- prettier-ignore -->
    <script>(g => {
            var h, a, k, p = "The Google Maps JavaScript API", c = "google", l = "importLibrary", q = "__ib__",
                m = document, b = window;
            b = b[c] || (b[c] = {});
            var d = b.maps || (b.maps = {}), r = new Set, e = new URLSearchParams,
                u = () => h || (h = new Promise(async (f, n) => {
                    await (a = m.createElement("script"));
                    e.set("libraries", [...r] + "");
                    for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
                    e.set("callback", c + ".maps." + q);
                    a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
                    d[q] = f;
                    a.onerror = () => h = n(Error(p + " could not load."));
                    a.nonce = m.querySelector("script[nonce]")?.nonce || "";
                    m.head.append(a)
                }));
            d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n))
        })
        ({key: "AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg", v: "beta"});</script>

    <script>
        let map;

        async function initMap() {
            // The location of Uluru
            const position = {lat: -25.344, lng: 131.031};
            // Request needed libraries.
            //@ts-ignore
            const {Map} = await google.maps.importLibrary("maps");
            const {AdvancedMarkerElement} = await google.maps.importLibrary("marker");

            // The map, centered at Uluru
            map = new Map(document.getElementById("map"), {
                zoom: 4,
                center: position,
                mapId: "DEMO_MAP_ID",
            });

            // The marker, positioned at Uluru
            const marker = new AdvancedMarkerElement({
                map: map,
                position: position,
                title: "Uluru",
            });
        }

        initMap();
    </script>

    <script>
        $(document).ready(function () {
            $('.systm_cnfg_lst_lnk').click(function () {
                $('.systm_cnfg_lst_dscrption').hide();
                $('#' + $(this).attr('data-target')).show();
            });
        });

        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }
    </script>

    <!-- Google analytics script-->
    <script type="text/javascript">
        if (document.location.hostname == 'pratikborsadiya.in') {
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
            ga('create', 'UA-72504830-1', 'auto');
            ga('send', 'pageview');
        }
    </script>



    <script src={{asset("public/src/plugins/jQuery-Knob-master/js/jquery.knob.js")}}></script>
    <script src={{asset("public/src/plugins/highcharts-6.0.7/code/highcharts.js")}}></script>
    <script src="{{ asset('public/vendors/scripts/highcharts-3d.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/vendors/scripts/variable-pie.js') }}" type="text/javascript"></script>

    <script>

        // chart
        Highcharts.chart('sales_comparison', {
            chart: {
                type: 'line',
                height: 250,
            },
            title: {
                text: ''
            },
            colors: ['#ffc87c', '#40E0D0'],
            xAxis: {
                categories: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30'],
                labels: {
                    style: {
                        color: '#000',
                        fontSize: '12px'
                    }
                }
            },
            yAxis: {
                labels: {
                    formatter: function () {
                        return this.value;
                    },
                    style: {
                        color: '#000',
                        fontSize: '12px'
                    }
                },
                title: {
                    text: ''
                },
            },
            credits: {
                enabled: false
            },
            tooltip: {
                crosshairs: true,
                shared: true
            },
            plotOptions: {
                spline: {
                    marker: {
                        radius: 10,
                        lineColor: '#0ba4f0',
                        lineWidth: 1
                    }
                }
            },
            legend: {
                align: 'center',
                x: 0,
                y: 0
            },
            series: [
                {
                    name: 'November',
                    color: '#ffc87c',
                    marker: {
                        symbol: 'circle'
                    },
                    data: [0, 10, 5, 30, 40, 20, 10, 0, 10, 5, 30, 40, 20, 10, 0, 10, 5, 30, 40, 20, 10, 0, 10, 5, 30, 40, 20, 10, 20, 10]
                },
                {
                    name: 'December',
                    color: '#40E0D0',
                    marker: {
                        symbol: 'circle'
                    },
                    data: [40, 20, 10, 40, 15, 15, 20, 40, 20, 87, 40, 15, 15, 20, 40, 20, 10, 40, 15, 15, 20, 40, 20, 10, 40, 15, 15, 20, 15, 20]
                }
            ]
        });

        Highcharts.chart('financial_comparison', {
            chart: {
                height: 250,
            },
            title: {
                text: ''
            },
            colors: ['#ffc87c', '#40E0D0', '#f8ab6a'],
            xAxis: {
                categories: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30']
            },
            credits: {
                enabled: false
            },
            tooltip: {
                crosshairs: true,
                shared: true
            },
            plotOptions: {
                spline: {
                    marker: {
                        radius: 10,
                        lineColor: '#0ba4f0',
                        lineWidth: 1
                    }
                }
            },
            legend: {
                align: 'center',
                x: 0,
                y: 0
            },
            labels: {},
            series: [
                {
                    type: 'column',
                    name: 'November',
                    data: [3002456, 2123458, 178964, 3123586, 424578, 3002456, 2123458, 178964, 3123586, 424578, 3002456, 2123458, 178964, 3123586, 424578, 3002456, 2123458, 178964, 3123586, 424578, 3002456, 2123458, 178964, 3123586, 424578, 3002456, 2123458, 178964, 3123586, 424578]
                },
                {
                    type: 'column',
                    name: 'December',
                    data: [242378, 3243589, 51234, 712358, 612342, 2124567, 242378, 3243589, 512345, 712358, 612342, 2124567, 242378, 3243589, 512345, 712358, 612342, 2124567, 242378, 3243589, 512345, 712358, 612342, 2124567]
                },
                {
                    type: 'spline',
                    name: 'Average',
                    data: [1500000, 2500000, 30000, 150000, 500000, 1500000, 1500000, 2500000, 30000, 150000, 500000, 1500000, 1500000, 2500000, 30000, 150000, 500000, 1500000, 1500000, 2500000, 30000, 150000, 500000, 1500000],
                    marker: {
                        lineWidth: 2,
                        lineColor: Highcharts.getOptions().colors[3],
                        fillColor: 'white'
                    }
                }
            ]
        });

        {{--var labels = {{\Illuminate\Support\Js::from($receivable_labels)}};--}}
        {{--var data = {{\Illuminate\Support\Js::from($receivable_data)}};--}}
        {{--var payable_data = {{\Illuminate\Support\Js::from($payable_data)}};--}}
        {{--console.log(data);--}}
        {{--console.log(payable_data);--}}
        {{--Highcharts.chart('dbtr_crdtr_pstn', {--}}
        {{--    chart: {--}}
        {{--        type: 'bar',--}}
        {{--        height: 250,--}}
        {{--    },--}}
        {{--    title: {--}}
        {{--        text: ''--}}
        {{--    },--}}
        {{--    subtitle: {--}}
        {{--        text: ''--}}
        {{--    },--}}
        {{--    xAxis: {--}}
        {{--        categories: labels,--}}
        {{--        title: {--}}
        {{--            text: null--}}
        {{--        }--}}
        {{--    },--}}
        {{--    yAxis: {--}}
        {{--        min: 0,--}}
        {{--        title: {--}}
        {{--            text: '',--}}
        {{--            align: 'high'--}}
        {{--        },--}}
        {{--        labels: {--}}
        {{--            overflow: 'justify'--}}
        {{--        }--}}
        {{--    },--}}
        {{--    tooltip: {--}}
        {{--        valueSuffix: ' Million'--}}
        {{--    },--}}
        {{--    plotOptions: {--}}
        {{--        bar: {--}}
        {{--            dataLabels: {--}}
        {{--                enabled: true--}}
        {{--            }--}}
        {{--        }--}}
        {{--    },--}}
        {{--    legend: {--}}
        {{--        layout: 'vertical',--}}
        {{--        align: 'right',--}}
        {{--        verticalAlign: 'top',--}}
        {{--        x: -40,--}}
        {{--        y: 80,--}}
        {{--        floating: true,--}}
        {{--        borderWidth: 1,--}}
        {{--        backgroundColor:--}}
        {{--            Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',--}}
        {{--        shadow: true--}}
        {{--    },--}}
        {{--    credits: {--}}
        {{--        enabled: false--}}
        {{--    },--}}
        {{--    series: [--}}

        {{--        {--}}
        {{--            name: 'Creditors',--}}
        {{--            data:--}}

        {{--            [{!! $receivable_data[0] !!},{!! $receivable_data[1] !!}]--}}

        {{--        },--}}
        {{--        {--}}
        {{--            name: 'Debtors',--}}
        {{--            data: [150600, 10]--}}
        {{--        }--}}
        {{--    ]--}}
        {{--});--}}

        Highcharts.chart('high_margin_product', {
            chart: {
                type: 'pie',
                height: 250,
                options3d: {
                    enabled: true,
                    alpha: 45,
                    beta: 0
                }
            },
            title: {
                text: ''
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            colors: ['#5ce191', '#9b92ff', '#66b3ff', '#2ec7c9'],
            subtitle: {
                text: ''
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    innerSize: 100,
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}'
                    },
                    depth: 45
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                type: 'pie',
                name: 'Total Sale',
                data: [
                    ['Panda Lipbalm', 22],
                    ['Young Artist Set', 35],
                    {
                        name: 'Tool Set Toys',
                        y: 55,
                        sliced: true,
                        selected: true
                    },
                    ['Hair Band', 9]
                ]
            }]
        });
        {{--        {{\Illuminate\Support\Js::from($receivable_labels)}};--}}
        {{--        var labels =  {{\Illuminate\Support\Js::from($revenue_labels) }};--}}
        {{--        var revenue_data =  {{\Illuminate\Support\Js::from($revenue_data) }};--}}
        {{--        var expense_data =  {{\Illuminate\Support\Js::from($expense_data) }};--}}
        // console.log(revenue_data);
        // console.log(expense_data);
        {{--Highcharts.chart('income_expense_comparison', {--}}
        {{--    chart: {--}}
        {{--        type: 'areaspline',--}}
        {{--        height: 250,--}}
        {{--    },--}}
        {{--    title: {--}}
        {{--        text: ''--}}
        {{--    },--}}
        {{--    colors: ['#ff5572', '#4ca6ff', '#f8ab6a'],--}}
        {{--    legend: {},--}}
        {{--    xAxis: {--}}
        {{--        categories: labels,--}}
        {{--        plotBands: [{ // visualize the weekend--}}
        {{--            from: 4.5,--}}
        {{--            to: 6.5,--}}
        {{--            color: 'rgba(68, 170, 213, .2)'--}}
        {{--        }]--}}
        {{--    },--}}
        {{--    yAxis: {--}}
        {{--        title: {--}}
        {{--            text: ''--}}
        {{--        }--}}
        {{--    },--}}
        {{--    tooltip: {--}}
        {{--        shared: true,--}}
        {{--        valueSuffix: ' units'--}}
        {{--    },--}}
        {{--    credits: {--}}
        {{--        enabled: false--}}
        {{--    },--}}
        {{--    plotOptions: {--}}
        {{--        areaspline: {--}}
        {{--            fillOpacity: 0.5--}}
        {{--        }--}}
        {{--    },--}}
        {{--    series: [--}}
        {{--        {--}}
        {{--            name: 'Expense',--}}
        {{--            color: '#ff5572',--}}
        {{--            marker: {--}}
        {{--                symbol: 'circle'--}}
        {{--            },--}}
        {{--            data: [{{$revenue_data[0]}}]--}}
        {{--        },--}}
        {{--        {--}}
        {{--            name: 'Revenue',--}}
        {{--            color: '#4ca6ff',--}}
        {{--            marker: {--}}
        {{--                symbol: 'circle'--}}
        {{--            },--}}
        {{--            data: revenue_data--}}
        {{--        },--}}
        {{--    ]--}}
        {{--});--}}
        {{--var labels = {{\Illuminate\Support\Js::from($receivable_labels)}};--}}
        {{--var data = {{\Illuminate\Support\Js::from($receivable_data)}};--}}
        {{--var payable_data = {{\Illuminate\Support\Js::from($payable_data)}};--}}
        // Highcharts.chart('wrkng_cpital_psition', {
        //     chart: {
        //         type: 'line',
        //         height: 250,
        //     },
        //     title: {
        //         text: ''
        //     },
        //     subtitle: {
        //         text: ''
        //     },
        //     xAxis: {
        //         categories: labels
        //     },
        //     yAxis: {
        //         title: {
        //             text: ''
        //         }
        //     },
        //     plotOptions: {
        //         line: {
        //             dataLabels: {
        //                 enabled: true
        //             },
        //             enableMouseTracking: false
        //         }
        //     },
        //     credits: {
        //         enabled: false
        //     },
        //     series: [
        //         {
        //             name: 'Stock Position',
        //             data: [123457, 1235687, 567894, 897689, 764523, 945378, 1234567, 456789, 1234568, 1342579, 1456789, 1534897]
        //         }
        //     ]
        // });

        Highcharts.chart('payments_arrangements', {
            chart: {
                type: 'variablepie',
                height: 250,
            },
            accessibility: {
                description: ''
            },
            title: {
                text: ''
            },
            colors: ['#2ec7c9', '#5ce191', '#f8ab6a'],
            credits: {
                enabled: false
            },
            tooltip: {
                headerFormat: '',
                pointFormat: '<span style="color:{point.color}">\u25CF</span> <b> {point.name}</b><br/>' +
                    '{point.name} Confirmed: <b>{point.x}</b><br/>' +
                    '{point.name} Pending: <b>{point.y}</b><br/>' +
                    '{point.name} Rejected: <b>{point.z}</b><br/>'
            },
            series: [{
                minPointSize: 10,
                innerSize: '20%',
                zMin: 0,
                name: 'Post Dated Cheque',
                data: [
                    {
                        name: 'PDC Issue',
                        x: 58,
                        y: 12,
                        z: 3
                    },
                    {
                        name: 'PDC Received',
                        x: 34,
                        y: 56,
                        z: 7
                    }
                ]
            }]
        });

        function getFullName(item) {
            console.log(item);
            return item;
        }
    </script>
@stop

