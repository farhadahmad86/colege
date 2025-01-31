@extends('vali')
@section('style')
@endsection
@section('content')
    {{--    <style> --}}
    {{--        .welcome{ --}}
    {{--            color: rgba(12, 163, 232, 0.79); --}}
    {{--            text-align: center; --}}
    {{--            margin-top: 22%; --}}
    {{--        } --}}
    {{--    </style> --}}
    {{-- <div class="welcome"> --}}

    {{--    <h1>WELCOME  TO  JADEED&nbsp;MUNSHI</h1> --}}
    {{-- </div> --}}
    <div class="row">

        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="row">

                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 mb-2">
                            @if($permissionCount>0)
                                <a href="{{ route('first_level_chart_of_account') }}" class="btn btn-sm btn-success"
                                   data-toggle="tooltip" data-placement="top" title="Chart Of Account Tree"
                                   target="_blank">
                                    <i class="fa-sharp fa-solid fa-tree"></i> Tree
                                </a>
                            @endif
                            <a href="{{ route('chart_of_account_ledger') }}" class="btn btn-sm btn-success"
                               data-toggle="tooltip" data-placement="top" title="Account Ledger" target="_blank">
                                <i class="fa-solid fa-file-invoice-dollar"></i> AL
                            </a>

                            <a href="{{ route('parties_account_ledger') }}" class="btn btn-sm btn-success"
                               data-toggle="tooltip" data-placement="top" title="Party Ledger" target="_blank">
                                <i class="fa-solid fa-file-invoice-dollar"></i> PL
                            </a>

                            <a href="{{ route('today_report_list') }}" class="btn btn-sm btn-success"
                               data-toggle="tooltip"
                               data-placement="top" title="Activity Report" target="_blank">
                                <i class="fa-solid fa-file-chart-column"></i> TA
                            </a>

                            <a href="{{ route('cashbook') }}" class="btn btn-sm btn-success " data-toggle="tooltip"
                               data-placement="top" title="Cashbook" target="_blank">
                                <i class="fa-sharp fa-solid fa-wallet"></i> CB
                            </a>
                            <a href="{{ route('account_receivable_list') }}" class="btn btn-sm btn-success "
                               data-toggle="tooltip" data-placement="top" title="Account Receivable" target="_blank">
                                <i class="fa-sharp fa-solid fa-wallet"></i> AR
                            </a>
                            <a href="{{ route('account_payable_list') }}" class="btn btn-sm btn-success "
                               data-toggle="tooltip" data-placement="top" title="Account Payable" target="_blank">
                                <i class="fa-sharp fa-solid fa-wallet"></i> AP
                            </a>

                            <a href="{{ route('sale_invoice') }}" class="btn btn-sm btn-info" data-toggle="tooltip"
                               data-placement="top" title="Sale Invoice" target="_blank">
                                <i class="fa-sharp fa-solid fa-file-invoice"></i> SI
                            </a>

                            <a href="{{ route('purchase_invoice') }}" class="btn btn-sm btn-info" data-toggle="tooltip"
                               data-placement="top" title="Purchase Invoice" target="_blank">
                                <i class="fa-sharp fa-solid fa-file-invoice"></i> PI
                            </a>

                            <a href="{{ route('cash_receipt_voucher') }}" class="btn btn-sm btn-primary"
                               data-toggle="tooltip" data-placement="top" title="Account Voucher" target="_blank">
                                <i class="fa fa-solid fa-receipt"></i> CRV
                            </a>

                            <a href="{{ route('cash_payment_voucher') }}" class="btn btn-sm btn-primary"
                               data-toggle="tooltip" data-placement="top" title="Account Voucher" target="_blank">
                                <i class="fa fa-solid fa-receipt"></i> CPV
                            </a>

                            <a href="{{ route('bank_receipt_voucher') }}" class="btn btn-sm btn-primary"
                               data-toggle="tooltip" data-placement="top" title="Account Voucher" target="_blank">
                                <i class="fa fa-solid fa-receipt"></i> BRV
                            </a>

                            <a href="{{ route('bank_payment_voucher') }}" class="btn btn-sm btn-primary"
                               data-toggle="tooltip" data-placement="top" title="Account Voucher" target="_blank">
                                <i class="fa fa-solid fa-receipt"></i> BPV
                            </a>

                            <a href="{{ route('journal_voucher') }}" class="btn btn-sm btn-primary"
                               data-toggle="tooltip"
                               data-placement="top" title="Journal Voucher" target="_blank">
                                <i class="fa fa-solid fa-receipt"></i> JV
                            </a>

                            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-info" data-toggle="tooltip"
                               data-placement="top" title="Admin Dashboard" target="_blank">
                                <i class="fa fa-sharp fa-solid fa-bars"></i> AD
                            </a>
                            <a href="{{ route('force_offline_user') }}" class="btn btn-sm btn-danger"
                               data-toggle="tooltip" data-placement="top" title="Force Offline User" target="_blank">
                                <i class="fa-sharp fa-solid fa-power-off"></i> FO
                            </a>
                            <a href="{{ route('start_day_end') }}" class="btn btn-sm btn-danger" data-toggle="tooltip"
                               data-placement="top" title="Day End" target="_blank">
                                <i class="fa-solid fa-hourglass-end"></i> DE
                            </a>
                            <a href="{{ route('class_dashboard') }}" class="btn btn-sm btn-primary"
                               data-toggle="tooltip"
                               data-placement="top" title="Class Dashboard" target="_blank">
                                <i class="fa-solid fa-hourglass-end"></i>CD
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-lg-2 mb-2">
                            <div class="widget-small danger coloured-icon">
                                <i class="icon fa fa-users fa-3x"></i>
                                <div class="info text-center">
                                    <h4>Financial Days</h4>
                                    <p><b>{{ $financial_days }}/365</b></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-2 mb-2">
                            <div class="widget-small primary coloured-icon">
                                <i class="icon fa fa-users fa-3x"></i>
                                <div class="info text-center">
                                    <h4>Employees</h4>
                                    <p><b>{{ $employee }}</b></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-2 mb-2">
                            <div class="widget-small info coloured-icon"><i class="icon fa-solid fa-users"></i>
                                <div class="info text-center">
                                    <h4>Users</h4>
                                    <p><b>{{ $app_users }}/{{ $total_users }}</b></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-2 mb-2">
                            <div class="widget-small primary coloured-icon"><i class="icon fa fa-files-o fa-3x"></i>
                                <div class="info text-center">
                                    <h4>Accounts</h4>
                                    <p><b>{{ $total_account }}</b></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-2 mb-2">
                            <a href="{{ route('trade_delivery_order_sale_invoice') }}" target="_blank">
                                <div class="widget-small success coloured-icon">
                                    <i class="icon fa-solid fa-truck"></i>
                                    <div class="info text-center">
                                        <h4>Delivery Order</h4>
                                        <p><b>{{ $do->count() }}</b></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-12 col-lg-2 mb-2">
                            <a href="{{ route('trade_sale_order_sale_invoice') }}" target="_blank">
                                <div class="widget-small purpal coloured-icon">
                                    <i class="icon fa-solid fa-rupee-sign"></i>
                                    <div class="info text-center">

                                        <h4>Sale Order</h4>
                                        <p><b>{{ $so->count() }}</b></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-12 col-lg-2 mb-2">
                            <a href="{{ route('trade_grn_purchase_invoice') }}" target="_blank">
                                <div class="widget-small lit_purpal coloured-icon">
                                    <i class="icon fa fa-line-chart"></i>
                                    <div class="info text-center">
                                        <h4>GRN</h4>
                                        <p><b>{{ $grn->count() }}</b></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-12 col-lg-2 mb-2">
                            <div class="widget-small dark_purpal coloured-icon"><i class="icon fa fa-star fa-3x"></i>
                                <div class="info text-center">
                                    <h4>Total Products</h4>
                                    <p><b>{{ $products }}</b></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-2 mb-2">
                            <a href="{{ route('cash_receipt_post_voucher_list') }}" target="_blank">
                                <div class="widget-small blue_lit coloured-icon">
                                    <i class="icon fa-solid fa-sack-dollar"></i>
                                    <div class="info text-center">
                                        <h4>Cash Receipt Park Voucher</h4>
                                        <p><b>{{ $cash_receipt }}</b></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-12 col-lg-2 mb-2">
                            <a href="{{ route('cash_payment_post_voucher_list') }}" target="_blank">
                                <div class="widget-small green coloured-icon">
                                    <i class="icon fa-solid fa-sack-dollar"></i>
                                    <div class="info text-center">
                                        <h4>Cash Payment Park Voucher</h4>
                                        <p><b>{{ $cash_payment }}</b></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-12 col-lg-2 mb-2">
                            <a href="{{ route('bank_receipt_post_voucher_list') }}" target="_blank">
                                <div class="widget-small mehdi coloured-icon">
                                    <i class="icon fa-solid fa-building-columns"></i>
                                    <div class="info text-center">
                                        <h4>Bank Receipt Park Voucher</h4>
                                        <p><b>{{ $bank_receipt }}</b></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-12 col-lg-2 mb-2">
                            <a href="{{ route('bank_payment_post_voucher_list') }}" target="_blank">
                                <div class="widget-small warning coloured-icon">
                                    <i class="icon fa-solid fa-building-columns"></i>
                                    <div class="info text-center">
                                        <h4>Bank Payment Park Voucher</h4>
                                        <p><b>{{ $bank_payment }}</b></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12 mb-2">
                            <div class="bg-white m-0 form_manage">
                                <!-- form manage box start -->
                                <div class="form_header">
                                    <!-- form header start -->
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
                        {{-- @for ($i=1; $i<=4; $i++)
                        <div class="col-lg-4 col-md-12 col-sm-12 mb-2">
                            <div class="bg-white m-0 form_manage">
                                <!-- form manage box start -->
                                <div class="form_header">
                                    <!-- form header start -->
                                    <div class="clearfix">
                                        <h4 class="text-white">Classes</h4>
                                    </div>
                                </div><!-- form header close -->
                                <div class="bg-white height-100-p">
                                    <div class="card">
                                        <img src="" class="card-img-top" alt="dummy-image">
                                        <div class="card-body">
                                            <p class="card-text">Some quick example text to build on the card title and
                                                make up the bulk of the card's content.</p>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- form manage box end -->
                        </div>
                        @endfor --}}

                    </div>
                </div>
            </div>
        </div>

    </div><!-- end row -->
@endsection

@section('script')

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


    <script src={{ asset('public/src/plugins/jQuery-Knob-master/js/jquery.knob.js') }}></script>
    <script src={{ asset('public/src/plugins/highcharts-6.0.7/code/highcharts.js') }}></script>
    <script src="{{ asset('public/vendors/scripts/highcharts-3d.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/vendors/scripts/variable-pie.js') }}" type="text/javascript"></script>

    <script>
        var labels = {{ \Illuminate\Support\Js::from($receivable_labels) }};
        Highcharts.chart('dbtr_crdtr_pstn', {
            chart: {
                type: 'bar',
                height: 250,
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: labels,
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: '',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' Million'
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -40,
                y: 80,
                floating: true,
                borderWidth: 1,
                backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
                shadow: true
            },
            credits: {
                enabled: false
            },
            series: [

                {
                    name: 'Creditors',
                    data: [
                        @foreach ($receivable_data as $i => $value)
                            {{ $receivable_data[$i] }},
                        @endforeach
                    ]
                    {{--                            {!! $receivable_data !!} --}}
                },
                {
                    name: 'Debtors',
                    data: [150600, 100000]
                }
            ]
        });
    </script>
@stop
