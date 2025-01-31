@extends('invoice_view.print_index')

@section('print_cntnt')

    @php
        $company_info = Session::get('company_info');
    @endphp


    <div id="" class="table-responsive">

        <table class="table table-bordered table-sm" id="">
            @if($type === 'grid')
                @include('invoice_view._partials.pdf_header', [$pge_title])
            @endif
        </table>

        <table class="table table-bordered table-sm" id="">
            <thead>
            <tr class="headings vi_tbl_hdng">
                <th scope="col"class="text-center tbl_srl_4">
                    Sr.
                </th>
                <th scope="col"class="text-center tbl_amnt_20">
                    Name
                </th>
                <th scope="col"class="text-center tbl_txt_20">
                    CNIC
                </th>
                <th scope="col"class="text-center tbl_txt_20">
                    Mobile
                </th>
                <th scope="col"class="text-center tbl_amnt_36">
                    Remarks
                </th>
            </tr>
            </thead>

            <tbody>
            @php $i = 01; @endphp
            @foreach( $items as $item )
                <tr class="even pointer">
                    <td class="align_center text-center tbl_srl_4">
                        {{ $i }}
                    </td>
                    <td align="center" class="align_center text-center tbl_amnt_20">
                        {{ $item->sc_name }}
                    </td>
                    <td class="align_right text-left tbl_txt_20">
                        {{ $item->sc_cnic}}
                    </td>
                    <td class="align_right text-left tbl_txt_20">
                        {{$item->sc_mobile}}
                    </td>
                    <td class="align_left text-left tbl_txt_36">
                        {{$item->sc_remarks}}
                    </td>

                </tr>
                @php $i++;  @endphp
            @endforeach

            </tbody>


        </table>

        <div class="clearfix"></div>
        @if( $type === 'grid')
            <div class="itm_vchr_rmrks">

                <a href="{{ route('delivery_option_view_details_pdf_SH',['id'=>$jrnl->do_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
                    Download/Get PDF/Print
                </a>
            </div>
        @endif

    </div>
    <div class="input_bx_ftr"></div>

@endsection
