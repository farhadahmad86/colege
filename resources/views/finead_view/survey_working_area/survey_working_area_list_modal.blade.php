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
        use Illuminate\Support\Facades\DB;
            $company_info = Session::get('company_info');
    @endphp

    <div id="" class="table-responsive" style="z-index: 9;">


        <table class="table table-sm m-0">

            @if($type === 'grid')
                @include('invoice_view._partials.pdf_header', [$invoice_nbr, $invoice_date, $pge_title])
            @endif

        </table>
        <table class="invc_vchr_fnt" style="font-size:14px;">
            <tr>
                <td scope="col" align="left" class="text-left align_left tbl_txt_100">
                    <b>Project Name :</b> {{$csh_rcpt->project_name}}
                </td>
            </tr>
            <tr>
                <td scope="col" align="left" class="text-left align_left tbl_txt_100">
                    <b>Order List Name :</b> {{$csh_rcpt->order_list_name}}
                </td>
            </tr>
        </table>
        <br>

        <table class="table invc_vchr_fnt">
            <thead>

            <tr class="headings vi_tbl_hdng">
                <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                    Sr.
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_8">
                    Product Name
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_8">
                    Service Name
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_4">
                    Region
                </th>
                <th scope="col" align="center" class="text-center align_left tbl_txt_6">
                    City
                </th>

                <th scope="col" align="center" class="text-center align_center tbl_amnt_6">
                    Franchise
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_6">
                    Supervisor Name
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_6">
                    Surveyor Type
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_6">
                    Surveyor Name
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_6">
                    username
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_6">
                    QTY
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_6">
                    Rate
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_6">
                    Amount
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_6">
                    Start Date
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_6">
                    End Date
                </th>
                @if( $type === 'grid')
                    <th scope="col" align="center" class="text-center align_center tbl_amnt_4">
                        Delete
                    </th>
                @endif
            </tr>

            </thead>

            <tbody>
            @php $i = 1; $vchr_id = ''; @endphp



            @foreach( $items as $item )


                <tr class="even pointer">
                    @php $surveyor_name =''; if ($item->account_name != null){$surveyor_name=$item->account_name;} else{$item->survey;}  @endphp
                    <td class="align_center text-center tbl_srl_4">
                        {{ $i }}
                    </td>
                    <td align="right" class="align_left text-left tbl_amnt_8">
                        {!! $item->product_name !!}
                    </td>
                    <td align="right" class="align_left text-left tbl_amnt_8">
                        {!! $item->service_name !!}
                    </td>
                    <td align="center" class="align_left text-left tbl_amnt_4">
                        {{ $item->region }}
                    </td>

                    <td class="align_left text-left tbl_txt_6">
                        {!! $item->city !!}
                    </td>

                    <td align="right" class="align_left text-left tbl_amnt_6">
                        {!! $item->franchise_code !!}
                        {!! $item->franchise_name !!}
                        {{--                        &bnsp;--}}
                    </td>
                    <td align="right" class="align_left text-left tbl_amnt_6">
                        {!! $item->supervisor !!}
                    </td>
                    <td align="right" class="align_left text-left tbl_amnt_6">
                        {!! $item->swai_surveyor_type !!}
                    </td>
                    @php

                        $suveyor='';
                        if($item->swai_surveyor_type == 'employee'){
                        $suveyor = DB::table('financials_users')->where('user_id',$item->swai_surveyor_id)->pluck('user_name')->first();
                        }else{
                            $suveyor = DB::table('financials_accounts')->where('account_uid',$item->swai_surveyor_id)->pluck('account_name')->first();
                        }
                    @endphp
                    <td align="right" class="align_left text-left tbl_amnt_6">
                        {!! $suveyor !!}
                    </td>
                    <td align="right" class="align_left text-left tbl_amnt_6">
                        {!! $item->username !!}
                    </td>
                    <td align="right" class="align_left text-left tbl_amnt_6">
                        {!! $item->swai_qty !!}
                    </td>
                    <td align="right" class="align_left text-left tbl_amnt_6">
                        {!! $item->swai_rate !!}
                    </td>
                    <td align="right" class="align_left text-left tbl_amnt_6">
                        {!! $item->swai_amount !!}
                    </td>
                    <td align="right" class="align_left text-left tbl_amnt_6">
                        {!! $item->swai_start_date !!}
                    </td>
                    <td align="right" class="align_left text-left tbl_amnt_6">
                        {!! $item->swai_end_date !!}
                    </td>
                    @if( $type === 'grid')
                        <td align="right" class="align_left text-left tbl_amnt_4">
                            <a href="{{ route('survey_work_area_item_delete',$item->swai_id) }}" class="btn btn-sm btn-danger d-inline"><i class="fa fa-trash"></i></a>
                        </td>
                    @endif
                </tr>
                @php $i++; @endphp
            @endforeach

            </tbody>


        </table>
    </div>

    @if( $type === 'grid')
        <div class="itm_vchr_rmrks">

            <a href="{{ route('work_area_items_view_details_pdf_SH',['id'=>$csh_rcpt->swa_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
                Download/Get PDF/Print
            </a>
        </div>
        <div class="clearfix"></div>
        <div class="input_bx_ftr"></div>
    @endif

@endsection
