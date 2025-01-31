
@php
$company_info = Session::get('company_info');
@endphp
<div id="" class="table-responsive">

    <table class="table table-bordered table-sm">
        <thead>
        <tr>
            <td colspan="2" class="p-0 border-0">
                <img src="{{(isset($company_info) || !empty($company_info)) ? $company_info->ci_logo : 'No Company Record'}}" alt="Company Logo" width="170" />
            </td>
            <td colspan="2" class="p-0 border-0 text-right">
                <h2>
                    Bank Payment Voucher
                </h2>
                <p>
                    <b> Invoice #: </b>
                    {{ $bnk_pmnt->bp_id }}
                </p>
                <p>
                    <b> Date: </b>
                    {{date('d-M-y', strtotime(str_replace('/', '-', $bnk_pmnt->bp_day_end_date)))}}
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="p-0 border-0">
                <table class="table table-bordered table-sm">
                    <tr class="bg-transparent">
                        <td colspan="3" class="p-0 border-0">
                            <h3> Voucher From </h3>
                            <p>
                                <b> Name: </b>
                                {{(isset($company_info) || !empty($company_info)) ? $company_info->ci_name : 'No Company Record'}}
                            </p>
                            <p>
                                <b> Adrs: </b>
                                {{(isset($company_info) || !empty($company_info)) ? $company_info->ci_address : 'No Company Record'}}
                            </p>
                            <p>
                                <b> Mob #: </b>
                                {{(isset($company_info) || !empty($company_info)) ? $company_info->ci_mobile_numer : 'No Company Record'}}
                            </p>
                            {{--                        <p style="padding: 5px 5px 0;margin: 0 0 30px;"> <b> NTN #: </b>{{ $accnts->account_ntn }} </p>--}}
                        </td>
                    </tr>

                </table>
            </td>
        </tr>

        <tr class="headings" style="background: #a5a5a5;color: #000;">
            <th scope="col" align="center" class="wdth_5 text-center align_center" >Sr.</th>
            <th scope="col" align="center" class="wdth_2 text-center align_center" >Account No.</th>
            <th scope="col" align="center" class="wdth_5 text-left align_left" >Account Name</th>
            <th scope="col" align="center" class="wdth_5 text-left align_left" >Posting Reference</th>
            <th scope="col" align="center" class="wdth_5 text-center align_center" >Amount</th>
        </tr>
        </thead>

        <tbody>
        @php $i = 01; $grand_total = 0; @endphp
        @foreach( $items as $item )
        <tr class="even pointer">

            <td class="wdth_5 align_center text-center" >
                {{ $i }}
            </td>
            <td class="align_center text-center" >
                {{ $item->bpi_account_id }}
            </td>

            <td class="wdth_2 align_left text-left">
                {!! $item->bpi_account_name !!}
            </td>


            <td class="wdth_2 align_left text-left">
                {!! $item->pr_name !!}
            </td>

            <td class="wdth_5 align_right text-right">
                {!! number_format($item->bpi_amount,2) !!}
            </td>

        </tr>
        @php $i++; $grand_total = +$item->bpi_amount + +$grand_total; @endphp
        @endforeach


        </tbody>
        <tfoot>
        <tr class="border-0">
            <td colspan="4" align="right" class="border-0">
                <table class="table table-bordered table-sm chk_dmnd">
                    <tfoot>
                    <tr>
                        <td align="right" class="border-right-0">
                            <label class="total-items-label text-right">Grand Total</label>
                        </td>
                        <td class="text-right border-left-0" align="right">
                            {{ number_format($grand_total,2) }}
                        </td>
                    </tr>

                    </tfoot>
                </table>
            </td>
        </tr>
        </tfoot>

    </table>

    <div class="clearfix"></div>
    <div class="itm_vchr_rmrks ">
        <a href="{{ route('bank_payment_items_view_details_pdf_SH',['id'=>$bnk_pmnt->bp_id]) }}" class="align_right text-center btn btn-sm btn-info">
            Download/Get PDF/Print
        </a>
    </div>

</div>
<div class="input_bx_ftr"></div>
