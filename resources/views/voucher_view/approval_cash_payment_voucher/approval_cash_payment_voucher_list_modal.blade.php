
@php
$company_info = Session::get('company_info');
@endphp
<div id="" class="table-responsive" style="display: block;max-width: 100%;min-width: 100%;width:100%;padding: 20px 10px;position: relative;z-index: 9;overflow-y: hidden;">
    <svg viewBox="0 0 500 500" preserveAspectRatio="xMinYMin meet" style="position:absolute;left: 0;bottom: 0;z-index: -1;transform: rotate(180deg);width: 100%;">
        <path d="M0,100 C150,200 350,0 500,100 L500,00 L0,0 Z" style="stroke: none; fill: #dee2e6;"></path>
    </svg>
    <svg viewBox="0 0 500 500" preserveAspectRatio="xMinYMin meet" style="position:absolute;left: 0;top: 0;z-index: -1;">
        <path d="M0,100 C150,200 350,0 500,100 L500,00 L0,0 Z" style="stroke: none; fill: #dee2e6;"></path>
    </svg>

    <table class="table table-bordered table-sm" id="fixTable">
        <thead>
        <tr>
            <td colspan="2" class="p-0 border-0" style="padding: 0;border: 0px solid transparent;">
                <img src="{{(isset($company_info) || !empty($company_info)) ? $company_info->ci_logo : 'No Company Record'}}" alt="Company Logo" width="170" />
            </td>
            <td colspan="2" class="p-0 border-0 text-right" style="text-align: right;padding: 0;border: 0px solid transparent;">
                <h2 style="margin: 0;padding: 0;font-weight: bolder;font-size: 25px;"> Cash Payment Voucher </h2>
                <p style="padding: 0px 5px 0;margin: 0;"> <b> Invoice #: </b>{{ $csh_pymnt->acp_id }} </p>
                <p style="padding: 5px 5px 0;margin: 0;"> <b> Date: </b>{{date('d-M-y', strtotime(str_replace('/', '-', $csh_pymnt->acp_day_end_date)))}} </p>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="border: 0px solid transparent;padding: 0;" class="p-0 border-0">
                <table class="table table-bordered table-sm">
                    <tr>
                        <td colspan="3" style="border: 0px solid transparent; padding: 0;vertical-align: top;" class="p-0 border-0">
                            <h3 style="margin-bottom: 0;padding: 5px;font-size: 14px;font-weight: bolder;background: #a5a5a5;color: #000;margin-top: 30px;"> Voucher From </h3>
                            <p style="padding: 5px 5px 0;margin: 0;"> <b> Name: </b>{{(isset($company_info) || !empty($company_info)) ? $company_info->ci_name : 'No Company Record'}} </p>
                            <p style="padding: 5px 5px 0;margin: 0;min-width: 250px;max-width: 250px;width: 100%;overflow: hidden;-ms-word-break: break-all;word-break: break-all;"> <b> Adrs: </b>{{(isset($company_info) || !empty($company_info)) ? $company_info->ci_address : 'No Company Record'}} </p>
                            <p style="padding: 5px 5px 0;margin: 0 0 30px;"> <b> Mob #: </b>{{(isset($company_info) || !empty($company_info)) ? $company_info->ci_mobile_numer : 'No Company Record'}} </p>
                            {{--                        <p style="padding: 5px 5px 0;margin: 0 0 30px;"> <b> NTN #: </b>{{ $accnts->account_ntn }} </p>--}}
                        </td>
                    </tr>

                </table>
            </td>
        </tr>

        <tr class="headings" style="background: #a5a5a5;color: #000;">
            <th scope="col" class="wdth_5 text-center style="width: 20px;max-width: 20px; min-width: 20px;text-align: center;">Sr.</th>
            <th scope="col" class="wdth_2 text-center style="width: 55px;max-width: 55px; min-width: 55px;text-align: center;">Account No.</th>
            <th scope="col" class="wdth_5 text-left" style="width: 155px;max-width: 155px; min-width: 155px;text-align: left;">Account Name</th>
            <th scope="col" class="wdth_5" style="width: 95px;max-width: 95px; min-width: 95px;text-align: center;">Amount</th>
        </tr>
        </thead>

        <tbody>
        @php $i = 01; $grand_total = 0; @endphp
        @foreach( $items as $item )
        <tr class="even pointer">

            <td class="wdth_5 align_center text-center" style="width: 20px;max-width: 20px; min-width: 20px;text-align: center;"> {{ $i }} </td>
            <td class="align_center text-center" style="width: 55px;max-width: 55px; min-width: 55px;text-align: center;">
                {{ $item->acpi_account_id }}
            </td>
            <td class="wdth_2 align_left text-left" style="width: 355px;max-width: 355px; min-width: 355px;text-align: left;">
                {!! $item->acpi_account_name !!}
            </td>
            <td class="wdth_5 align_right text-right" style="width: 95px;max-width: 95px; min-width: 95px;text-align: right;"> {!! number_format($item->acpi_amount,2) !!} </td>

        </tr>
        @php $i++; $grand_total = +$item->acpi_amount + +$grand_total; @endphp
        @endforeach


        </tbody>
        <tfoot>
        <tr class="border-0">
            <td colspan="4" align="right" class="p-0 border-0" style="border: 0px solid transparent; padding: 0;text-align: right;">
                <table class="table table-bordered table-sm chk_dmnd" style="background-color: transparent;padding: 0;margin: 0;text-align: right;float: right;">
                    <tfoot>
                    <tr>
                        <td align="right" class="border-right-0" style="padding: .1rem .45rem;border-right: 0px solid transparent;border-top: 1px solid #000;border-bottom: 2px double #000;padding: 0;">
                            <label class="total-items-label text-right">Grand Total</label>
                        </td>
                        <td class="text-right border-left-0" align="right" style="padding: .1rem .45rem;text-align: right;border-left: 0px solid transparent;border-top: 1px solid #000;border-bottom: 2px double #000;padding: 0;">
                            {{ number_format($grand_total,2) }}
                        </td>
                    </tr>

                    </tfoot>
                </table>
            </td>
        </tr>
        </tfoot>

    </table>

    <div style="clear:both"></div>
    <div class="itm_vchr_rmrks ">
        <a href="{{ route('cash_payment_items_view_details_pdf_SH',['id'=>$csh_pymnt->acp_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
            Download/Get PDF/Print
        </a>
    </div>

</div>
<div class="input_bx_ftr" style="background-color: rgba(48,90,114,1);color: #fff;padding: 5px 10px;margin: 15px -.45rem -.75rem -.45rem;width: 100%;"></div>
