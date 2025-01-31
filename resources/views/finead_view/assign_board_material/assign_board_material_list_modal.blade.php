@extends('invoice_view.print_index')

@section('print_cntnt')

    <div id="" class="table-responsive">

{{--        <table class="table border-0 table-sm p-0 m-0">--}}
{{--            @if($type === 'grid')--}}
{{--                @include('voucher_view._partials.pdf_header', [$invoice_nbr, $invoice_date, $pge_title, $invoice_remarks])--}}
{{--            @endif--}}
{{--        </table>--}}

        <table class="table table-sm">
            <thead>
            <tr class="headings vi_tbl_hdng">
                <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                    Sr.
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_40">
                    Product Name
                </th>
                <th scope="col" align="center" class="text-left align_left tbl_txt_16">
                    Board Type
                </th>
                <th scope="col" align="center" class="text-left align_left tbl_txt_40">
                    Board Material
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
                    <td align="center" class="align_left text-left tbl_amnt_40">
                        {{ $bord_material->pro_title }}
                    </td>
                    <td class="align_left text-left tbl_txt_16">
                        {!! $bord_material->bt_title !!}
                    </td>
                    <td class="align_left text-left tbl_txt_40">
                        {!! $item->pro_title !!}
                    </td>

                </tr>

                @php
                    $i++;
                @endphp

            @endforeach

            </tbody>

        </table>

        <div class="clearfix"></div>
        @if( $type === 'grid')
            <div class="itm_vchr_rmrks">

                <a href="{{ route('assign_board_material_items_view_details_pdf_SH',['id'=>$bord_material->abm_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
                    Download/Get PDF/Print
                </a>
            </div>
        @endif

    </div>
    <div class="input_bx_ftr"></div>

@endsection
