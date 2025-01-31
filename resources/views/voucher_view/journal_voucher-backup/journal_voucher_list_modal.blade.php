
@php
$company_info = Session::get('company_info');
@endphp
<div id="" class="table-responsive">

    <table class="table table-bordered table-sm" style="background-image: url({{ asset('public/vendors/images/invoice_background.png') }}); background-repeat: no-repeat;background-position: left top;-webkit-background-size: 100% auto;background-size: 100% auto;">
        <tr class="bg-transparent">
            <td colspan="3" class="p-0 border-0">
                <img src="{{(isset($company_info) || !empty($company_info)) ? $company_info->ci_logo : 'No Company Record'}}" alt="Company Logo" width="140" />
                <p class="invoice_para adrs m-0">
                    <b> Adrs: </b>
                    {{(isset($company_info) || !empty($company_info)) ? $company_info->ci_address : 'No Company Record'}}
                </p>
                <p class="invoice_para m-0 pt-5">
                    <b> Mob #: </b>
                    {{(isset($company_info) || !empty($company_info)) ? $company_info->ci_mobile_numer : 'No Company Record'}}
                </p>
            </td>
            <td colspan="3" class="p-0 border-0 text-right align_right">
                <h2 class="invoice_hdng">
                    Journal Voucher
                </h2>
                <p class="invoice_para m-0">
                    <b> JV #: </b>
                    {{ $jrnl->jv_id }}
                </p>
                <p class="invoice_para m-0 pt-5">
                    <b> Date: </b>
                    {{date('d-M-y', strtotime(str_replace('/', '-', $jrnl->jv_created_datetime)))}}
                </p>
            </td>
        </tr>
        <tr class="bg-transparent">
            <td colspan="6" class="p-0 border-0">
                <p class="invoice_para pt-5 mt-0 mb-10">
                    <b> Remarks: </b>
                    {{ $jrnl->jv_remarks }}
                </p>
            </td>
        </tr>
    </table>
    <table class="table table-bordered table-sm">
        <thead>

        <tr class="headings vi_tbl_hdng">
            <th scope="col" class="v_wdth_1 text-center">Sr.</th>
            <th scope="col" class="v_wdth_2 text-center">Account No.</th>
            <th scope="col" class="v_wdth_3 text-left">Account Name</th>
            <th scope="col" class="v_wdth_4 text-left">Detail Remarks</th>
            <th scope="col" class="v_wdth_5 text-center">Dr.</th>
            <th scope="col" class="v_wdth_5 text-center">Cr.</th>
        </tr>
        </thead>

        <tbody>
        @php $i = 01; $grand_total = $ttl_dr = $ttl_cr = 0; @endphp
        @foreach( $items as $item )
        <tr class="even pointer">

            <td class="v_wdth_1 align_center text-center">
                {{ $i }}
            </td>

            <td class="v_wdth_2 align_center text-center">
                {{ $item->jvi_account_id }}
            </td>

            <td class="v_wdth_3 align_left text-left">
                {!! $item->jvi_account_name !!}
            </td>

            <td class="v_wdth_4 align_left text-left">
                {!! $item->jvi_remarks !!}
            </td>

            <td class="v_wdth_5 align_right text-right">
                @php
                    $DR_val = ($item->jvi_type === "Dr") ? $item->jvi_amount : "";
                    $DR = ($item->jvi_type === "Dr") ? $DR_val : "0";
                    $ttl_dr = +$ttl_dr + +$DR;
                @endphp
                {{ (!empty($DR_val)) ? number_format($DR_val,2) : '' }}
            </td>

            <td class="v_wdth_5 align_right text-right">
                @php
                    $CR_val = ($item->jvi_type === "Cr") ? $item->jvi_amount : "";
                    $CR = ($item->jvi_type === "Cr") ? $CR_val : "0";
                    $ttl_cr = +$ttl_cr + +$CR;
                @endphp
                {{ (!empty($CR_val)) ? number_format($CR_val,2) : '' }}
            </td>
        </tr>
        @php $i++;  @endphp
        @endforeach


        </tbody>
        <tfoot>
        <tr class="border-0">
            <th colspan="4" align="right" class="border-0 pt-0 text-right align_right">
                Grand Total:
            </th>
            <td class="text-right align_right border-left-0 border-top-2 border-bottom-3" align="right">
                {{ number_format($ttl_dr,2) }}
            </td>
            <td class="text-right align_right border-left-0 border-top-2 border-bottom-3" align="right">
                {{ number_format($ttl_cr,2) }}
            </td>
        </tr>
        <tr>
            <td colspan="6" class="border-0 p-0">
                <div class="wrds_con">
                    <div class="wrds_bx">
                        <span class="wrds_hdng">
                            In Words
                        </span>
                        {{ $nbrOfWrds }} only
                    </div>
                    <div class="wrds_bx wrds_bx_two">
                        <span class="wrds_hdng">
                            Receipient Sign.
                        </span>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="6" class="border-0 p-0">
                <div class="sign_con">

                    <div class="sign_bx">
                        <span class="sign_itm">
                            Prepared By
                        </span>
                    </div>

                    <div class="sign_bx">
                        <span class="sign_itm">
                            Checked By
                        </span>
                    </div>

                    <div class="sign_bx">
                        <span class="sign_itm">
                            Accounts Manager
                        </span>
                    </div>

                    <div class="sign_bx">
                        <span class="sign_itm">
                            Chief Executive
                        </span>
                    </div>

                </div>
            </td>
        </tr>
        </tfoot>

    </table>

    <div class="clearfix"></div>
    <div class="itm_vchr_rmrks">
        <a href="{{ route('journal_voucher_items_view_details_pdf_SH',['id'=>$jrnl->jv_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
            Download/Get PDF/Print
        </a>
    </div>

</div>
<div class="input_bx_ftr"></div>
