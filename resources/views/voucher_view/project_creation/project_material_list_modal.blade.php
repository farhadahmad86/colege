@extends('invoice_view.print_index')

@section('print_cntnt')

    @php
        $company_info = Session::get('company_info');
    @endphp


    <div id="" class="table-responsive">

        <table class="table table-bordered table-sm">
            @if($type === 'grid')
                @include('voucher_view._partials.pdf_header', [$invoice_nbr, $invoice_date, $pge_title, $invoice_remarks])
            @endif
        </table>


        <table class="table table-bordered table-sm">
            <thead>
            <tr class="headings vi_tbl_hdng">
                <th scope="col" class="text-center tbl_srl_4">
                    Sr.
                </th>
                <th scope="col" class="text-center tbl_amnt_10">
                    Product Name                </th>
                <th scope="col" class="text-center tbl_txt_25">
                    UOM
                </th>

                <th scope="col" class="text-center tbl_amnt_15">
                    QTY
                </th>
                <th scope="col" class="text-center tbl_amnt_15">
                    Rate
                </th>
                <th scope="col" class="text-center tbl_amnt_15">
                    Amount
                </th>
            </tr>
            </thead>

            <tbody>
            @php $i = 01; $grand_total = $ttl_cr=0; @endphp
            @foreach( $items as $item )
                <tr class="even pointer">
                    <td class="align_center text-center tbl_srl_4">
                        {{ $i }}
                    </td>
                    <td align="center" class="align_center text-center tbl_amnt_20">
                        {{ $item->mbi_pro_name }}
                    </td>
                    <td class="align_left text-left tbl_txt_25">
                        {!! $item->mbi_uom !!}
                    </td>

                    <td class="align_left text-left tbl_txt_10">
                        {!! $item->mbi_quantity !!}
                    </td>
                    <td class="align_left text-left tbl_txt_10">
                        {!! $item->mbi_rate !!}
                    </td>

                    <td align="right" class="align_right text-right tbl_amnt_9">
                        @php

                            $CR = $item->mbi_amount;
                            $ttl_cr = +$ttl_cr + +$CR;
                        @endphp
                        {!! $item->mbi_amount !!}
                    </td>

                </tr>
                @php $i++;  @endphp
            @endforeach
            <tr class="border-0">
                <th colspan="5" align="right" class="border-0 pt-0 text-right align_right">
                    Grand Total:
                </th>
                {{--                <td class="text-right align_right border-left-0 border-right-0 border-top-2 border-bottom-3" align="right">--}}
                {{--                    {{ number_format($ttl_dr,2) }}--}}
                {{--                </td>--}}
                <td class="text-right align_right border-left-0 border-right-0 border-top-2 border-bottom-3" align="right">
                    {{ number_format($ttl_cr,2) }}
                </td>
            </tr>


            </tbody>


        </table>

        <div class="clearfix"></div>
        @if( $type === 'grid')
            <div class="itm_vchr_rmrks">
                <a href="{{ route('material_items_view_details_pdf_SH',['id'=>$jrnl->pc_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
                    Download/Get PDF/Print
                </a>
            </div>
        @endif

    </div>
    <div class="input_bx_ftr"></div>

@endsection




