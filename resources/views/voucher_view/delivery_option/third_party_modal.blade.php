@extends('invoice_view.print_index')

@section('print_cntnt')

    @php
        $company_info = Session::get('company_info');
    @endphp


    <div id="" class="table-responsive">

        <table class="table table-bordered table-sm">
            @if($type === 'grid')
                @include('voucher_view._partials.pdf_header', [$pge_title])
            @endif
        </table>


        <table class="table table-bordered table-sm">
            <thead>
            <tr class="headings vi_tbl_hdng">
                <th scope="col" class="text-center tbl_srl_4">
                    Sr.
                </th>
                <th scope="col" class="text-center tbl_amnt_10">
                    Vehicle No
                </th>
                <th scope="col" class="text-center tbl_amnt_15">
                   Vehicle Type</th>
                <th scope="col" class="text-center tbl_amnt_15">Driver Name
                </th>
                <th scope="col" class="text-center tbl_amnt_15">
                    Mobile No
                </th>
                <th scope="col" class="text-center tbl_amnt_41">
                    Remarks
                </th>
            </tr>
            </thead>

            <tbody>
            @php $i = 01;@endphp
            @foreach( $items as $item )
                <tr class="even pointer">
                    <td class="align_center text-center tbl_srl_4">
                        {{ $i }}
                    </td>
                    <td align="center" class="align_center text-center tbl_amnt_10">
                        {{ $item->tp_vehicle_no }}
                    </td>
                    <td align="center" class="align_center text-center tbl_amnt_15">
                        {{ $item->tp_vehicle_type}}
                    </td>
                    <td align="center" class="align_center text-center tbl_amnt_15">
                        {{ $item->tp_driver_name}}
                    </td>
                    <td align="center" class="align_center text-center tbl_amnt_15">
                        {{ $item->tp_mobile}}
                    </td>
                    <td class="align_right text-left tbl_txt_41">
                        {{ $item->tp_remarks}}
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
