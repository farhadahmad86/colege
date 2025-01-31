<!DOCTYPE html>
<html lang="ur">
{{-- <script> --}}
{{--    window.print() --}}
{{-- </script> --}}

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

        /* .vertical {
            border-left: 3px solid black;
            height: 95%;
            position:absolute;
            left: 50%;
        } */
    </style>
</head>

<body>
@php

    use App\Http\Controllers\Controller;
@endphp
{{--    @foreach ($fee_vouchers as $fee_voucher)--}}
<?php

$number = $fee_voucher->cv_total_amount;
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
                    @php
                        $company_info = Session::get('company_info');
                    @endphp
                    <div style="margin-top: 4px; margin-left: 3px;">
                        <img style="height: 60px;" src="{{ $company_info->ci_logo }}" alt="Logo city">
                    </div>
                </div>
                <div class="" style="text-align: center; margin-top:10px;">
                    <h3><strong>{{ $fee_voucher->clg_name }}</strong></h3>
                    <h4><strong>{{ $fee_voucher->branch_name }}</strong></h4>
                    <h4><strong>BANK COPY</strong></h4>
                    <h5><strong>(CASH DEPOSIT SLIP)</strong></h5>
                </div>
            </div>
            <div class="row " style="margin-top: 1px">
                <table class="table">
                    <tbody style="border: 1px solid black;">
                    <tr>
                        <th class="th-1"> Issue Date</th>
                        <th class="th-1">
                            {{ date('d-M-y', strtotime(str_replace('/', '-', $fee_voucher->cv_issue_date))) }}
                        </th>
                        <th class="th-1">Due Date</th>
                        <th class="th-1">
                            {{ date('d-M-y', strtotime(str_replace('/', '-', $fee_voucher->cv_due_date))) }}
                        </th>
                    </tr>
                    </tbody>
                </table>
                <h2 class="FID_Title">FID: {{ $fee_voucher->cv_v_no }}</h2>
            </div>
            <p><strong>Account Title: {{$bank_info->bi_account_title}}</strong></p>
            <table style="line-height:0px">
                <tr>
                    <td>
                        <p><strong>Account#:</strong> <strong>{{$bank_info->bi_account_no}}</strong></p>
                    </td>
                    <td style="padding-left: 5px;">
                        <p><strong>Branch Code:</strong><strong>{{$bank_info->bi_branch_code}}</strong></p>
                    </td>
                </tr>
            </table>
            <p><strong>Branch Name: {{$bank_info->bi_bank_name}}</strong></p>
            <div style="line-height:20px">
                <h4 class="name_font">Student Name: {{ $fee_voucher->full_name }}</h4>
                <h4 class="name_font">Father Name: {{ $fee_voucher->father_name }}</h4>
                <p><strong>Admission #: {{ $fee_voucher->registration_no }}</strong></p>
                <p><strong>Class:</strong> {{ $fee_voucher->class_name }} {{ $fee_voucher->cs_name }} </p>
                <div style="width:95%; padding:0 0 3% 0">
                    <table style="line-height: 18px; border: 2px solid;width: 100%;">
                        <thead>
                        <tr>
                            <td><strong>Account</strong></td>
                            <td><strong>RS</strong></td>
                        </tr>
                        </thead>
                        <tbody style="border-top:2px solid;">
                        @foreach ($items as $item)
                            @if ($fee_voucher->cv_id == $item->cvi_voucher_id)
                                <tr>
                                    <td>{!! $item->cvi_component_name !!}</td>
                                    <td>{{ $item->cvi_amount }}</td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                        <tfoot style="border-top:2px solid black; line-height:18px;">
                        <tr>
                            <td><strong>Net Fee:</strong></td>
                            <td><strong>{{ $fee_voucher->cv_total_amount }}</strong></td>
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
                    @php
                        $company_info = Session::get('company_info');
                    @endphp
                    <div style="margin-top: 4px; margin-left: 3px;">
                        <img style="height: 60px;" src="{{ $company_info->ci_logo }}" alt="Logo city">
                    </div>
                </div>
                <div class="" style="text-align: center; margin-top:10px;">
                    <h3><strong>{{ $fee_voucher->clg_name }}</strong></h3>
                    <h4><strong>{{ $fee_voucher->branch_name }}</strong></h4>
                    <h4><strong>STUDENT COPY</strong></h4>
                    <h5><strong>(CASH DEPOSIT SLIP)</strong></h5>
                </div>
            </div>
            <div class="row " style="margin-top: 1px">
                <table class="table">
                    <tbody style="border: 1px solid black;">
                    <tr>
                        <th class="th-1"> Issue Date</th>
                        <th class="th-1">
                            {{ date('d-M-y', strtotime(str_replace('/', '-', $fee_voucher->cv_issue_date))) }}
                        </th>
                        <th class="th-1">Due Date</th>
                        <th class="th-1">
                            {{ date('d-M-y', strtotime(str_replace('/', '-', $fee_voucher->cv_due_date))) }}
                        </th>
                    </tr>
                    </tbody>
                </table>
                <h2 class="FID_Title">FID: {{ $fee_voucher->cv_v_no }}</h2>
            </div>
            <p><strong>Account Title: {{$bank_info->bi_account_title}}</strong></p>
            <table style="line-height:0px">
                <tr>
                    <td>
                        <p><strong>Account#:</strong> <strong>{{$bank_info->bi_account_no}}</strong></p>
                    </td>
                    <td style="padding-left: 5px;">
                        <p><strong>Branch Code:</strong><strong>{{$bank_info->bi_branch_code}}</strong></p>
                    </td>
                </tr>
            </table>
            <p><strong>Branch Name: {{$bank_info->bi_bank_name}}</strong></p>
            <div style="line-height:20px">
                <h4 class="name_font">Student Name: {{ $fee_voucher->full_name }}</h4>
                <h4 class="name_font">Father Name: {{ $fee_voucher->father_name }}</h4>
                <p><strong>Admission #: {{ $fee_voucher->registration_no }}</strong></p>
                <p><strong>Class:</strong> {{ $fee_voucher->class_name }} {{ $fee_voucher->cs_name }}</p>
                <div style="width:95%; padding:0 0 3% 0">
                    <table style="line-height: 18px; border: 2px solid;width: 100%;">
                        <thead>
                        <tr>
                            <td><strong>Account</strong></td>
                            <td><strong>RS</strong></td>
                        </tr>
                        </thead>
                        <tbody style="border-top:2px solid;">
                        @foreach ($items as $item)
                            @if ($fee_voucher->cv_id == $item->cvi_voucher_id)
                                <tr>
                                    <td>{!! $item->cvi_component_name !!}</td>
                                    <td>{{ $item->cvi_amount }}</td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                        <tfoot style="border-top:2px solid black; line-height:18px;">
                        <tr>
                            <td><strong>Net Fee:</strong></td>
                            <td><strong>{{ $fee_voucher->cv_total_amount }}</strong></td>
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
    <!-- Home -->
    @if($fee_voucher->cv_status== 'Pending')
        <iframe style="display: none" id="printf" name="printf"
                src="{{ route('custom_voucher_items_view_details_pdf_SH', ['id' => $fee_voucher->cv_v_no,'reg_no' => $fee_voucher->cv_reg_no,]) }}"
                title="W3Schools Free Online Web Tutorials">Iframe
        </iframe>
        <a href="#" id="printi" onclick="PrintFrame()" class="btn btn-sm btn-info v_print"
           style="float: left;margin-top: 7px;">
            Print
        </a>
    @endif
</div>
{{--    @endforeach--}}
</body>

</html>
<script>
    function PrintFrame() {
        // window.frames["printf"].focus();
        window.frames["printf"].print();
    }
</script>
