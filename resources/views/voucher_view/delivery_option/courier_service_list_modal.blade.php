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
                <th scope="col" class="text-center tbl_srl_4">
                    Sr.
                </th>
                <th scope="col" class="text-center tbl_amnt_15">
                    Name
                </th>
                <th scope="col" class="text-center tbl_amnt_15">
                    Slip NO.
                </th>
                <th scope="col" class="text-center tbl_amnt_15">
                    Slip Date
                </th>
                <th scope="col" class="text-center tbl_amnt_15">
                    Booking City
                </th>
                <th scope="col" class="text-center tbl_amnt_15">
                    Destination City
                </th>
                <th scope="col" class="text-center tbl_amnt_21">
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
                    <td class="align_center text-center tbl_amnt_15">
                        {{ $item->city_name }}
                    </td>
                    <td class="align_center text-center tbl_amnt_15">
                        {{ $item->cs_slip}}
                    </td>
                    <td class="align_center text-center tbl_amnt_15">
                        {{ $item->cs_slip_date}}
                    </td>
                    <td class="align_center text-center tbl_amnt_15">
                        {{ $item->booking_name}}
                    </td>
                    <td class="align_center text-center tbl_amnt_15">
                        {{ $item->destination_name}}
                    </td>
                    <td class="align_right text-left tbl_txt_21">
                        {{ $item->cs_remarks}}
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
