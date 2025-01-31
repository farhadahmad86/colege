{{--@extends('invoice_view.print_index')--}}

{{--@section('print_cntnt')--}}

{{--    @php--}}
{{--        $company_info = Session::get('company_info');--}}
{{--    @endphp--}}


{{--    <div id="" class="table-responsive" style="z-index: 9;">--}}

{{--        <table class="table table-sm m-0">--}}
{{--            @if($type === 'grid')--}}
{{--                @include('voucher_view._partials.pdf_header', [$invoice_nbr, $invoice_date, $pge_title, $invoice_remarks])--}}
{{--            @endif--}}
{{--        </table>--}}


{{--        <table class="table table-sm">--}}
{{--            <thead>--}}
{{--            <tr class="headings vi_tbl_hdng">--}}
{{--                <th scope="col" align="center" class="text-center align_center tbl_srl_4">--}}
{{--                    Sr.--}}
{{--                </th>--}}
{{--                <th scope="col" align="center" class="text-center align_center tbl_amnt_10">--}}
{{--                    Region--}}
{{--                </th>--}}
{{--                <th scope="col" align="center" class="text-left align_left tbl_txt_25">--}}
{{--                    Zone--}}
{{--                </th>--}}
{{--                <th scope="col" align="center" class="text-left align_left tbl_txt_31">--}}
{{--                    City--}}
{{--                </th>--}}
{{--                <th scope="col" align="center" class="text-center align_center tbl_amnt_10">--}}
{{--                    Grid--}}
{{--                </th>--}}
{{--                <th scope="col" align="center" class="text-center align_center tbl_amnt_10">--}}
{{--                    Franchise--}}
{{--                </th>--}}
{{--                <th scope="col" align="center" class="text-center align_center tbl_amnt_10">--}}
{{--                    Supervisor Name--}}
{{--                </th>--}}
{{--                <th scope="col" align="center" class="text-center align_center tbl_amnt_10">--}}
{{--                    Surveyor Type--}}
{{--                </th>--}}
{{--                <th scope="col" align="center" class="text-center align_center tbl_amnt_10">--}}
{{--                    Surveyor Name--}}
{{--                </th>--}}
{{--                <th scope="col" align="center" class="text-center align_center tbl_amnt_10">--}}
{{--                    Start Date--}}
{{--                </th>--}}
{{--                <th scope="col" align="center" class="text-center align_center tbl_amnt_10">--}}
{{--                    End Date--}}
{{--                </th>--}}

{{--            </tr>--}}
{{--            </thead>--}}

{{--            <tbody>--}}
{{--            @php $i = 1; $vchr_id = ''; @endphp--}}
{{--            @foreach( $items as $item )--}}
{{--                <tr class="even pointer">--}}
{{--                    @php $surveyor_name =''; if ($item->account_name != null){$surveyor_name=$item->account_name;} else{$item->survey;}  @endphp--}}
{{--                    <td class="align_center text-center tbl_srl_4">--}}
{{--                        {{ $i }}--}}
{{--                    </td>--}}
{{--                    <td align="center" class="align_center text-center tbl_amnt_10">--}}
{{--                        {{ $item->region }}--}}
{{--                    </td>--}}
{{--                    <td class="align_left text-left tbl_txt_25">--}}
{{--                        {!! $item->zone !!}--}}
{{--                    </td>--}}
{{--                    <td class="align_left text-left tbl_txt_31">--}}
{{--                        {!! $item->city !!}--}}
{{--                    </td>--}}
{{--                    <td align="right" class="align_right text-right tbl_amnt_10">--}}
{{--                        {!! $item->grid !!}--}}
{{--                    </td>--}}
{{--                    <td align="right" class="align_right text-right tbl_amnt_10">--}}
{{--                        --}}{{--                        {!! $item->franchise_code !!} &bnsp;--}}
{{--                        --}}{{--                        {!! $item->franchise_name !!}--}}
{{--                    </td>--}}
{{--                    <td align="right" class="align_right text-right tbl_amnt_10">--}}
{{--                        {!! $item->supervisor !!}--}}
{{--                    </td>--}}
{{--                    <td align="right" class="align_right text-right tbl_amnt_10">--}}
{{--                        {!! $item->swai_surveyor_type !!}--}}
{{--                    </td>--}}

{{--                    <td align="right" class="align_right text-right tbl_amnt_10">--}}
{{--                        {!! $surveyor_name !!}--}}
{{--                    </td>--}}
{{--                    <td align="right" class="align_right text-right tbl_amnt_10">--}}
{{--                        {!! $item->swai_start_date !!}--}}
{{--                    </td>--}}
{{--                    <td align="right" class="align_right text-right tbl_amnt_10">--}}
{{--                        {!! $item->swai_end_date !!}--}}
{{--                    </td>--}}
{{--                </tr>--}}


{{--                @php--}}
{{--                    $i++;--}}
{{--                @endphp--}}

{{--            @endforeach--}}

{{--            </tbody>--}}

{{--        </table>--}}

{{--        <div class="clearfix"></div>--}}
{{--        @if( $type === 'grid')--}}
{{--            <div class="itm_vchr_rmrks">--}}

{{--                <a href="{{ route('working_area_items_view_details_pdf_SH',['id'=>$csh_rcpt->swa_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">--}}
{{--                    Download/Get PDF/Print--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        @endif--}}

{{--    </div>--}}
{{--    <div class="input_bx_ftr"></div>--}}

{{--@endsection--}}
@extends('invoice_view.print_index')

@section('print_cntnt')

    @php
        $company_info = Session::get('company_info');
    @endphp

    <div id="" class="table-responsive" style="z-index: 9;">


        <table class="table table-sm m-0">

            @if($type === 'grid')
                @include('invoice_view._partials.pdf_header', [$invoice_nbr, $invoice_date, $pge_title])
            @endif

        </table>


        <table class="table invc_vchr_fnt">
            <thead>

            <tr class="headings vi_tbl_hdng">
                <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                    Sr.
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_10">
                    Region
                </th>
                <th scope="col" align="center" class="text-left align_left tbl_txt_10">
                    Zone
                </th>
                <th scope="col" align="center" class="text-left align_left tbl_txt_10">
                    City
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_10">
                    Grid
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_10">
                    Franchise
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_10">
                    Supervisor Name
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_10">
                    Designer Name
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_8">
                    Start Date
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_8">
                    End Date
                </th>
            </tr>

            </thead>

            <tbody>
            @php $i = 1; $vchr_id = ''; @endphp



            @foreach( $items as $item )


                <tr class="even pointer">
{{--                    @php $surveyor_name =''; if ($item->account_name != null){$surveyor_name=$item->account_name;} else{$item->designer;}  @endphp--}}
                    <td class="align_center text-center tbl_srl_4">
                        {{ $i }}
                    </td>
                    <td align="center" class="align_center text-center tbl_amnt_10">
                        {{ $item->region }}
                    </td>
                    <td class="align_left text-left tbl_txt_10">
                        {!! $item->zone !!}
                    </td>
                    <td class="align_left text-left tbl_txt_10">
                        {!! $item->city !!}
                    </td>
                    <td align="right" class="align_right text-right tbl_amnt_10">
                        {!! $item->grid !!}
                    </td>
                    <td align="right" class="align_right text-right tbl_amnt_10">
                        {!! $item->franchise_code !!}
                        {!! $item->franchise_name !!}
                        {{--                        &bnsp;--}}
                    </td>
                    <td align="right" class="align_right text-right tbl_amnt_10">
                        {!! $item->supervisor !!}
                    </td>

                    <td align="right" class="align_right text-right tbl_amnt_10">
                        {!! $item->designer !!}
                    </td>
                    <td align="right" class="align_right text-right tbl_amnt_8">
                        {!! $item->dwai_start_date !!}
                    </td>
                    <td align="right" class="align_right text-right tbl_amnt_8">
                        {!! $item->dwai_end_date !!}
                    </td>
                </tr>
                @php $i++; @endphp
            @endforeach

            </tbody>


        </table>
    </div>

    @if( $type === 'grid')
        <div class="itm_vchr_rmrks">

            <a href="{{ route('designer_working_area_items_view_details_pdf_SH',['id'=>$csh_rcpt->dwa_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
                Download/Get PDF/Print
            </a>
        </div>
        <div class="clearfix"></div>
        <div class="input_bx_ftr"></div>
    @endif

@endsection
