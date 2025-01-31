@extends('invoice_view.print_index')

@section('print_cntnt')

    @php
        $company_info = Session::get('company_info');
    @endphp


    <div id="" class="table-responsive">

        <table class="table table-bordered table-sm" id="">
            @if($type === 'grid')
                @include('invoice_view._partials.pdf_header', [$invoice_nbr, $invoice_date, $pge_title,$invoice_remarks])
            @endif
            <tr class="bg-transparent">
                <td colspan="3" class="p-0 border-0">
                    <p class="invoice_para pt-0 mt-0 mb-0">
                        <b> Remarks: </b>
                        {{ $expns->ep_remarks }}
                    </p>
                </td>
            </tr>
        </table>

        <table class="table table-bordered table-sm" id="">
            <thead>
            <tr class="headings vi_tbl_hdng">
                <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                    Sr.
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_10">
                    Product Name
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_txt_25">
                    Product UOM
                </th>

                <th scope="col" align="center" class="text-center align_center tbl_amnt_15">
                    QTY
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_15">
                    Rate
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_15">
                    Amount
                </th>
            </tr>
            </thead>

            <tbody>
            @php $i = 1; @endphp
            @foreach( $items as $item )


                <tr class="even pointer">
                    <td class="align_center text-center tbl_srl_4">
                        {{ $i }}
                    </td>
                    <td align="center" class="align_center text-center tbl_amnt_20">
                        {{ $item->mbi_pro_name }}
                    </td>
                    <td class="align_left text-left tbl_txt_25">
                        {{ $item->mbi_uom }}
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

                @php
                    $i++;
                @endphp


            @endforeach


            </tbody>


            <tfoot>


        </table>

        <div class="clearfix"></div>
        @if( $type === 'grid')
            <div class="itm_vchr_rmrks">

                <a href="{{ route('material_items_view_details_pdf_SH',['id'=>$expns->mbi_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
                    Download/Get PDF/Print
                </a>
            </div>
        @endif

    </div>
    <div class="input_bx_ftr"></div>

@endsection
