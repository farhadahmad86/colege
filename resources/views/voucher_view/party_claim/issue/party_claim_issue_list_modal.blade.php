@extends('invoice_view.print_index')

@section('print_cntnt')

    @php
        $company_info = Session::get('company_info');
    @endphp


    <div id="" class="table-responsive">

        <table class="table table-bordered table-sm">
            @if($type === 'grid')
                @include('invoice_view._partials.pdf_header', [$invoice_nbr, $invoice_date, $pge_title])
            @endif
            <tr class="bg-transparent">
                <td colspan="3" class="p-0 border-0">
                    <p class="invoice_para pt-0 mt-0 mb-0">
                        <b> Remarks: </b>
                        {{ $jrnl->pc_remarks }}
                    </p>
                </td>
            </tr>
        </table>

        <table class="table table-bordered table-sm">
            <thead>
            <tr class="headings vi_tbl_hdng">
                <th scope="col" class="text-center tbl_srl_4">
                    Sr.
                </th>
                <th scope="col" class="text-center tbl_amnt_10">
                    Code
                </th>
                <th scope="col" class="text-center tbl_txt_25">
               Product Name
                </th>
                <th scope="col" class="text-center tbl_txt_31">
                    Remarks
                </th>
                <th scope="col" class="text-center tbl_txt_31">
                    Warehouse
                </th>
                <th scope="col" class="text-center tbl_txt_31">
                    Qty
                </th>
                <th scope="col" class="text-center tbl_txt_31">
                    Rate
                </th>
                <th scope="col" class="text-center tbl_txt_31">
                    Amount
                </th>
            </tr>
            </thead>

            <tbody>
            @php $i = 1; $grand_total = $ttl_dr = $ttl_cr = $adv_amnt = $adv_amnt_deduct = $ttl_paid = 0; $vchr_id = ''; @endphp
            @foreach( $items as $item )
                @php
                    $vchr_id = $item->pci_pc_id;
                    $grand_total = +$item->pci_amount + +$grand_total;
                @endphp
                <tr class="even pointer">
                    <td class="align_center text-center tbl_srl_4">
                        {{ $i }}
                    </td>
                    <td align="center" class="align_center text-center tbl_amnt_10">
                        {{ $item->pci_product_code }}
                    </td>
                    <td class="align_left text-left tbl_txt_25">
                        {{ $item->pci_product_name }}
                    </td>
                    <td class="align_left text-left tbl_txt_31">
                        {!! $item->pci_remarks !!}
                    </td>
                    <td class="align_left text-left tbl_txt_31">
                        {!! $item->pci_warehouse_name !!}
                    </td>
                    <td class="align_left text-left tbl_txt_31">
                        {!! $item->pci_qty !!}
                    </td>
                    <td class="align_left text-left tbl_txt_31">
                        {!! $item->pci_rate !!}
                    </td>
                    <td class="align_left text-left tbl_txt_31">
                        {!! $item->pci_amount !!}
                    </td>
                </tr>
            @endforeach
            <tr class="border-0">
                <th colspan="7" align="right" class="border-0 pt-0 text-right align_right">
                    Grand Total:
                </th>
                <td class="text-right align_right border-left-0 border-right-0 border-top-2 border-bottom-3" align="right">
                    {{ number_format($grand_total,2) }}
                </td>
            </tr>

            </tbody>


            <tfoot>
                <style>
                    .fieldset-box fieldset {
                        min-height: 47px;
                        border-color: black;
                    }

                    .fieldset-box fieldset legend {
                        font-weight: 600;
                    }

                    .fieldset-box fieldset span {
                        text-transform: uppercase;
                        line-height: 2;
                        margin-left: 10px;
                    }
                </style>
                <tr class="fieldset-box">
                    <td colspan="5" class="border-0 p-0 chck_pdng">

                        <fieldset style="margin-top: 14px">
                            <legend>In Words</legend>
                            <span>{{ $nbrOfWrds }} ONLY</span>
                        </fieldset>
                    </td>
                    <td class="border-0 p-0 chck_pdng" colspan="3">

                        <fieldset style="margin-top: 12px">
                            <legend>Recipient Sign.</legend>
                            <span>

                                </span>
                        </fieldset>
                    </td>
                </tr>
                </tfoot>

            </table>
            <table class="table table-bordered table-sm invc_vchr_fnt" style="padding-right:100px">
                <tbody>
                <tr>
                    <td class="border-0 p-0">

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
                    </td>
                </tr>
                </tbody>
            </table>

        <div class="clearfix"></div>
        @if( $type === 'grid')
            <div class="itm_vchr_rmrks">

                <a href="{{ route('claim_stock_issue_to_party_items_view_details_pdf_SH',['id'=>$jrnl->pc_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
                    Download/Get PDF/Print
                </a>
            </div>
        @endif

    </div>
    <div class="input_bx_ftr"></div>

@endsection
