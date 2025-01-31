@extends('invoice_view.print_index')

@section('print_cntnt')

    @php
        $company_info = Session::get('company_info');
    @endphp

    <div id="" class="table-responsive" style="z-index: 9;">


        {{--        <table class="table table-sm m-0">--}}

        {{--            @if($type === 'grid')--}}
        {{--                @include('invoice_view._partials.pdf_header', [$invoice_nbr, $invoice_date, $pge_title])--}}
        {{--            @endif--}}


        {{--            --}}{{--            <tr>--}}
        {{--            --}}{{--                <td colspan="{{ ($sim->si_invoice_type === 2 || $sim->si_invoice_type === 3) ? '8' : '6' }}"  class="p-0 border-0">--}}
        {{--            --}}{{--                    <table class="table p-0 m-0 bg-transparent" >--}}


        <table class="table invc_vchr_fnt">
            <thead>

            <tr class="headings vi_tbl_hdng">
                <th scope="col" align="center" class="tbl_srl_4 text-center align_center">
                    Sr.
                </th>
                <th scope="col" align="center" class="align_left text-left tbl_txt_9">
                    Product Title
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_5">
                    Image Type
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_9">
                    PMC Type
                </th>
                <th class="align_center text-center tbl_amnt_9">
                    Width
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_8">
                    Total Width
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_9">
                    Length
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_8">
                    Total Length
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_8">
                    Quantity
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_8">
                    Latitude
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_9">
                    Longitude
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_9">
                    Area
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_9">
                    UOM
                </th>
            </tr>

            </thead>

            <tbody>

            @php $i=1; @endphp

            @foreach( $siims as $siim )

                <tr class="even pointer">

                    <td class="tbl_srl_4 align_center text-center">
                        {{ $i }}
                    </td>
                    <td class="align_left text-left tbl_txt_9">
                        {!! $siim->pro_title !!}

                    </td>
                    <td class="align_left text-left tbl_txt_5">
                        {!! $siim->sri_image_type !!}

                    </td>
                    <td class="tbl_amnt_9 align_center text-center">
                        {{--                        {!! $siim->sri_pmc_type !!}--}}
                        {!! $siim->board_types !!}
                    </td>
                    <td class="tbl_amnt_9 align_center text-center">
                        {{ $siim->sri_lengthFeet }}.{{ $siim->sri_lengthInch }}
                    </td>
                    <td class="tbl_amnt_8 align_right text-right">
                        {{ $siim->sri_total_length }}
                    </td>
                    <td class="tbl_amnt_9 align_center text-center">
                        {!! $siim->sri_front_left_right_height_feet !!}.
                        {!! $siim->sri_front_left_right_height_Inch !!}
                    </td>
                    <td class="align_right text-right tbl_amnt_8">
                        {{ $siim->sri_height }}
                    </td>
                    <td class="align_center text-center tbl_amnt_8">
                        {!! $siim->sri_quantity !!}
                    </td>
                    <td class="align_right text-right tbl_amnt_8">
                        {{ $siim->sri_latitude }}
                    </td>
                    <td class="tbl_amnt_9 align_right text-right">
                        {!! $siim->sri_longitude !!}
                    </td>
                    <td class="tbl_amnt_9 align_right text-right">
                        {!! $siim->sri_area !!}
                    </td>
                    <td class="tbl_amnt_9 align_right text-right">
                        {!! $siim->sri_output_uom !!}
                    </td>

                </tr>
                @php $i++; @endphp
            @endforeach

            </tbody>

        </table>
    </div>


    {{--    @if( $type === 'grid')--}}
    {{--        <div class="itm_vchr_rmrks">--}}

    {{--            <a href="{{ route('survey_items_view_details_pdf_sh',['id'=>$siim->sri_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">--}}
    {{--                Download/Get PDF/Print--}}
    {{--            </a>--}}
    {{--        </div>--}}

    {{--        <div class="clearfix"></div>--}}
    {{--        <div class="input_bx_ftr"></div>--}}
    {{--    @endif--}}

@endsection
