@extends('voucher_view.print_index')

@section('print_cntnt')

    @php
        $company_info = Session::get('company_info');
    @endphp


    <div id="" class="table-responsive">

        <table class="table border-0 table-sm p-0 m-0">
{{--            @if($type === 'grid')--}}
                @include('voucher_view._partials.pdf_header', [$pge_title])
{{--            @endif--}}
        </table>

        <table class="table table-bordered table-sm">
            <thead>
            <tr class="headings vi_tbl_hdng">
                <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                    Sr.
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_10">
                    Party Name
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_10">
                    PO #
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_15">
                    QTY
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_15">
                    Receiving Date/Time
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_41">
                    Remarks
                </th>
            </tr>
            </thead>

            <tbody>
            @php $i = 01;@endphp
            <tr class="even pointer">
                <th>
                    {{ $i }}
                </th>
                <td>
                    {{ $jrnl->si_party_name }}
                </td>
                <td>
                    {{ $jrnl->si_purchase_order_id }}
                </td>
                <td>
                    {{ $jrnl->si_builty_qty}}
                </td>
                <td>
                    {{date('d-M-Y h:m:s', strtotime($jrnl->si_receiving_datetime))}}
                </td>
                <td>
                    {{ $jrnl->si_remarks}}
                </td>

            </tr>

            </tbody>

        </table>
        <br/>
        <h5>{{$delivery_title}}</h5>
        <br/>
        <table class="table table-bordered table-sm">
            <thead>
            <tr class="headings vi_tbl_hdng">
                <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                    Sr.
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_15">
                    Name
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_15">
                    Slip NO.
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_15">
                    Slip Date
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_15">
                    Booking City
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_21">
                    Remarks
                </th>
            </tr>
            </thead>

            <tbody>
            @php $i = 01;@endphp
            @foreach( $items as $item )
                <tr class="even pointer">
                    <th>
                        {{ $i }}
                    </th>
                    <td>
                        {{ $item->cs_courier_name }}
                    </td>
                    <td>
                        {{ $item->cs_slip}}
                    </td>
                    <td>
                        {{ $item->cs_slip_date}}
                    </td>
                    <td>
                        {{ $item->booking_name}}
                    </td>
                    <td>
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
                <a href="{{ route('stock_inward_view_details_pdf_SH',['id'=>$jrnl->si_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
                    Download/Get PDF/Print
                </a>
            </div>
        @endif

    </div>
    <div class="input_bx_ftr"></div>

@endsection
