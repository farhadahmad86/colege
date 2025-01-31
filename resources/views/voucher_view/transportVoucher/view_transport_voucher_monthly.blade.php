<!DOCTYPE html>
<html lang="ur">

<head>
    <style>
        @font-face {
            font-family: 'SourceSansPro';
            font-style: normal;
            font-weight: normal;
        }

        .footer_urdu {
            width: 340px;
        }

        .FID_Title {
            font-family: inherit;
            font-weight: 500;
            line-height: 1.1;
            text-align: center;
            margin-top: 0px;
            margin-bottom: 10px;
            background-color: #AAAAAA !important;
            -webkit-print-color-adjust: exact;
            width: 100%
        }

        p {
            margin: 0 0 3px 0 !important;
        }

        .border {
            border: 1px solid #000 !important;
            padding: 0px;
        / / margin-right: 8 px;
        / / height: 99 vh
        }


        #logo-row {
            top: 13px;
        }


        .th-1 {
            border: 1px solid #333 !important;
            text-align: center;
            font-size: 12px;
            padding: 3px 3px !important;
            white-space: nowrap;
        }


        .col-xs-4 {
            width: 44%;
            float: left;
        }


        h3 {
            margin-top: -17px;
        }

        /* h4 {
            margin-top: -13px;
        } */

        h5 {
            margin-top: -5px;
            margin-bottom: 5px;
        }

        .row {
            margin-right: 0px !important;

        }

        /*.row {*/

        /*    margin-left: 0px !important;*/

        /*}*/

        .hr-line {
            margin-top: 20px !important;
            margin-bottom: 20px !important;
            width: 100% !important;
            border: 1px solid black;

        }

        .v_print {
            margin-left: 2rem;
            text-align: right;
            text-align: center;
        }

        .name_font {
            font-size: 14px;
        }

        @media print {
            img {
                display: block !important;
                visibility: visible !important;
                height: auto !important;
                width: auto !important;
            }
        }

        /* .vertical {
            border-left: 3px solid black;
            height: 95%;
            position:absolute;
            left: 50%;
        } */
    </style>
</head>

<body id="voucherModalBody">
<div class="row" style="">
    <a href="#" id="printi" onclick="printVoucher()" class="btn btn-sm btn-info v_print"
       style="float: left;margin-top: 7px;">
        Print
    </a>
</div>
@php
    $company_info = Session::get('company_info');
@endphp
@foreach ($data['items'] as $transport_voucher)
        <?php

        $number = $transport_voucher->tv_total_amount;
        $locale = 'en_US';
        $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
        $nbrOfWrds = numfmt_format($fmt, $number);
        // twelve thousand three hundred forty-five
        ?>

    <div class="row" style="">
        <div id="home">
            <div class="size col-xs-4" style="margin-top:12px;margin-left: 40px;border-right: 2px solid black;">
                <div class="row" id="logo-row">
                    <div class="" style="float:left;">
                        <div style="margin-top: 4px; margin-left: 3px;">
{{--                            <img style="height: 60px;" src="{{$company_info->ci_logo}}" alt="Logo city">--}}
                            <img style="height: 60px !important;" src="https://www.college.jadeedmunshi.com/storage/app/public/college_logo2////2_College_Logo.jpg" alt="Logo city">
                        </div>
                    </div>
                    <div class="" style="text-align: center; margin-top:10px;">
                        <h5><strong>{{ $company_info->ci_name }}</strong></h5>
                        <h6><strong>{{ $transport_voucher->branch_name }}</strong></h6>
                        <h6><strong>BANK COPY</strong></h6>
                        <h6><strong>(CASH DEPOSIT SLIP)</strong></h6>
                        <h6><strong>{{$transport_voucher->tv_month}}</strong></h6>
                    </div>
                </div>
                <div class="row " style="margin-top: 1px">
                    <table class="table">
                        <tbody style="border: 1px solid black;">
                        <tr>
                            <th class="th-1"> Issue Date</th>
                            <th class="th-1">
                                {{ date('d-M-y', strtotime(str_replace('/', '-', $transport_voucher->tv_issue_date))) }}
                            </th>
                            <th class="th-1">Due Date</th>
                            <th class="th-1">
                                {{ date('d-M-y', strtotime(str_replace('/', '-', $transport_voucher->tv_due_date))) }}
                            </th>
                        </tr>
                        </tbody>

                    </table>
                    <h2 class="FID_Title">FID: {{ $transport_voucher->tv_v_no }}</h2>
                </div>
                <p><strong>Acc Title: {{ $data['bank_info']->bi_account_title }}</strong></p>
                <table style="line-height:0px">
                    <tr>
                        <td>
                            <p><strong>Acc#:</strong> <strong>{{ $data['bank_info']->bi_account_no }}</strong>
                            </p>
                        </td>
                        <td style="padding-left: 50px;">
                            <p><strong>Branch#:</strong><strong>{{ $data['bank_info']->bi_branch_code }}</strong></p>
                        </td>
                    </tr>
                </table>
                <p><strong>Branch Name: {{ $data['bank_info']->bi_bank_name }}</strong></p>
                <div style="line-height:20px">
                    <h4 class="name_font">Student Name: {{ $transport_voucher->full_name }}</h4>
                    <h4 class="name_font">Father Name: {{ $transport_voucher->father_name }}</h4>
                    <p><strong>Admission #: {{ $transport_voucher->registration_no }}</strong></p>
                    <p><strong>Route #: {{ $transport_voucher->tr_title }}</strong></p>
                    <p><strong>Route Name#: {{ $transport_voucher->tr_name }}</strong></p>
                    <p><strong>Route Type #: {{ $transport_voucher->route_type == 1 ? 'Single':'Double' }}</strong></p>
                    <p><strong>Class:</strong> {{ $transport_voucher->class_name }} - {{$transport_voucher->cs_name}}
                    </p>
                    <div style="width:95%; padding:0 0 3% 0">
                        <table style="line-height: 18px; border: 2px solid;width: 100%;">
                            <thead>
                            <tr>
                                <td><strong>Account</strong></td>
                                <td><strong>RS</strong></td>
                            </tr>
                            </thead>
                            <tbody style="border-top:2px solid;">

                            <tr>
                                <td>Transport Fee</td>
                                <td>{{ $transport_voucher->tv_total_amount }}</td>
                            </tr>

                            </tbody>
                            <tfoot style="border-top:2px solid black; line-height:18px;">
                            <tr>
                                <td><strong>Net Fee:</strong></td>
                                <td><strong>{{ $transport_voucher->tv_total_amount }}</strong></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <p style="line-height:10px;"><strong>Rupees: </strong><strong
                            style="text-transform: uppercase;">{{ $nbrOfWrds }} Only /-</strong></p>
                    <p style="line-height:15px;"><strong>Note: After due date, late fee fine @ Rs. 20/ - Per
                            day And duplicate voucher charges Rs 50/- Per Copy</strong></p>
                </div>
                <div class="signature">
                    <p>
                        <span style="font-size: 10px">Depositor Sign:_________________</span>
                        <span style="font-size: 10px">Authorized Sign:_________________</span>
                    </p>
                </div>
            </div>
            {{-- <div class = "vertical"></div> --}}
            <div class="size col-xs-4" style="margin-top:12px;margin-left: 40px;">
                <div class="row" id="logo-row">
                    <div class="" style="float:left;">
                        <div style="margin-top: 4px; margin-left: 3px;">
                            <img style="height: 60px !important;" src="https://www.college.jadeedmunshi.com/storage/app/public/college_logo2////2_College_Logo.jpg" alt="Logo city">
                        </div>
                    </div>
                    <div class="" style="text-align: center; margin-top:10px;">
                        <h5><strong>{{ $company_info->ci_name }}</strong></h5>
                        <h6><strong>{{ $transport_voucher->branch_name }}</strong></h6>
                        <h6><strong>STUDENT COPY</strong></h6>
                        <h6><strong>(CASH DEPOSIT SLIP)</strong></h6>
                        <h6><strong>{{$transport_voucher->tv_month}}</strong></h6>
                    </div>
                </div>
                <div class="row " style="margin-top: 1px">
                    <table class="table">
                        <tbody style="border: 1px solid black;">
                        <tr>
                            <th class="th-1"> Issue Date</th>
                            <th class="th-1">
                                {{ date('d-M-y', strtotime(str_replace('/', '-', $transport_voucher->tv_issue_date))) }}
                            </th>
                            <th class="th-1">Due Date</th>
                            <th class="th-1">
                                {{ date('d-M-y', strtotime(str_replace('/', '-', $transport_voucher->tv_due_date))) }}
                            </th>
                        </tr>
                        </tbody>
                    </table>
                    <h2 class="FID_Title">FID: {{ $transport_voucher->tv_v_no }}</h2>
                </div>
                <p><strong>Acc Title: {{ $data['bank_info']->bi_account_title }}</strong></p>
                <table style="line-height:0px">
                    <tr>
                        <td>
                            <p><strong>Acc#:</strong> <strong>{{ $data['bank_info']->bi_account_no }}</strong>
                            </p>
                        </td>
                        <td style="padding-left: 50px;">
                            <p><strong>Branch#:</strong><strong>{{ $data['bank_info']->bi_branch_code }}</strong></p>
                        </td>
                    </tr>
                </table>
                <p><strong>Branch Name: {{ $data['bank_info']->bi_bank_name }}</strong></p>
                <div style="line-height:20px">
                    <h4 class="name_font">Student Name: {{ $transport_voucher->full_name }}</h4>
                    <h4 class="name_font">Father Name: {{ $transport_voucher->father_name }}</h4>
                    <p><strong>Admission #: {{ $transport_voucher->registration_no }}</strong></p>
                    <p><strong>Route #: {{ $transport_voucher->tr_title }}</strong></p>
                    <p><strong>Route Name#: {{ $transport_voucher->tr_name }}</strong></p>
                    <p><strong>Route Type #: {{ $transport_voucher->route_type == 1 ? 'Single':'Double' }}</strong></p>
                    <p><strong>Class:</strong> {{ $transport_voucher->class_name }} - {{$transport_voucher->cs_name}}
                    </p>
                    <div style="width:95%; padding:0 0 3% 0">
                        <table style="line-height: 18px; border: 2px solid;width: 100%;">
                            <thead>
                            <tr>
                                <td><strong>Account</strong></td>
                                <td><strong>RS</strong></td>
                            </tr>
                            </thead>
                            <tbody style="border-top:2px solid;">

                            <tr>
                                <td>Transport Fee</td>
                                <td>{{ $transport_voucher->tv_total_amount }}</td>
                            </tr>

                            </tbody>
                            <tfoot style="border-top:2px solid black; line-height:18px;">
                            <tr>
                                <td><strong>Net Fee:</strong></td>
                                <td><strong>{{ $transport_voucher->tv_total_amount }}</strong></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <p style="line-height:10px;"><strong>Rupees: </strong><strong
                            style="text-transform: uppercase;">{{ $nbrOfWrds }} Only /-</strong></p>
                    <p style="line-height:15px;"><strong>Note: After due date, late fee fine @ Rs. 20/ - Per
                            day And duplicate voucher charges Rs 50/- Per Copy</strong></p>
                </div>
                <div class="signature">
                    <p>
                        <span style="font-size: 10px">Depositor Sign:_________________</span>
                        <span style="font-size: 10px">Authorized Sign:_________________</span>
                    </p>
                </div>
            </div>
        </div>
        @if (!$loop->last)
            <div style="page-break-after: always;"></div>
        @endif
    </div>
@endforeach
<!-- Home -->

</body>

</html>
{{--<script>--}}
<script>
    function printVoucher() {
        document.getElementById("printi").style.display = "none";
        var printContents = document.getElementById('voucherModalBody').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents; // Restore original content
        location.reload(); // Reload the page to ensure the modal works correctly again

    }
</script>
