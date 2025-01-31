@extends('invoice_view.print_index')

@section('print_cntnt')

    @php
        $company_info = Session::get('company_info');
    @endphp

    <div id="" class="table-responsive" style="z-index: 9;">


        <table class="table table-bordered table-sm">

            @if($type === 'grid')
                @include('invoice_view._partials.pdf_header', [$invoice_nbr, $invoice_date, $pge_title])
            @endif


            {{--            <tr>--}}
            {{--                <td colspan="{{ ($sim->si_invoice_type === 2 || $sim->si_invoice_type === 3) ? '8' : '6' }}"  class="p-0 border-0">--}}
            {{--                    <table class="table table-bordered table-sm bg-transparent" >--}}

            <tr class="bg-transparent">
                <td class="wdth_50_prcnt p-0 border-0">
                    <h3 class="invoice_sub_hdng mb-0">
                        Billed From
                    </h3>
                    <p class="invoice_para m-0 pt-0">
                        <b> Name: </b>
                        {{(isset($company_info) || !empty($company_info)) ? $company_info->ci_name : 'N/A'}}
                    </p>
                    <p class="invoice_para adrs m-0 pt-0">
                        <b> Adrs: </b>
                        {{(isset($company_info) || !empty($company_info)) ? $company_info->ci_address : 'N/A'}}
                    </p>
                    <p class="invoice_para m-0 pt-0">
                        <b> Mob #: </b>
                        {{(isset($company_info) || !empty($company_info)) ? $company_info->ci_mobile_numer : 'N/A'}}
                    </p>
                    <p class="invoice_para m-0 pt-0">
                        <b> Remarks: </b>
                        {{ $sim->do_remarks }}
                    </p>
                </td>

                <td class="wdth_50_prcnt p-0 border-0">
                    <h3 class="invoice_sub_hdng mb-0 mt-0">
                        Billed To
                    </h3>
                    <p class="invoice_para m-0 pt-0">
                        <b> Name: </b>
                        {{ (isset($sim->do_party_name) && !empty($sim->do_party_name)) ? $sim->do_party_name : 'N/A' }}
                    </p>
                    <p class="invoice_para adrs m-0 pt-0">
                        <b> Adrs: </b>
                        {{ (isset($accnts->account_address) && !empty($accnts->account_address) ? $accnts->account_address : 'N/A') }}
                    </p>
                    <p class="invoice_para m-0 pt-0">
                        <b> Mob #: </b>
                        {{ (isset($accnts->account_mobile_no) && !empty($accnts->account_mobile_no) ? $accnts->account_mobile_no : 'N/A') }}
                    </p>
                    <p class="invoice_para m-0 pt-0 mb-10">
                        <b> NTN #: </b>
                        {{ (isset($accnts->account_ntn) && !empty($accnts->account_ntn) ? $accnts->account_ntn : 'N/A') }}
                    </p>
                </td>
            </tr>

            {{--                    </table>--}}
            {{--                </td>--}}
            {{--            </tr>--}}

        </table>


        <table class="table table-bordered table-sm invc_vchr_fnt">
            <thead>

            <tr class="headings table-bordered vi_tbl_hdng">
                <th scope="col" class="tbl_srl_4 text-center align_center">
                    Sr.
                </th>

                <th scope="col" class="align_left text-left tbl_txt_48">
                    Product Name
                </th>
                {{--                    <th scope="col" class="text-center align_center tbl_amnt_15">--}}
                {{--                        Remarks--}}
                {{--                    </th>--}}
                {{--                <th scope="col" class="text-center align_center tbl_amnt_8">--}}
                {{--                    QTY--}}
                {{--                </th>--}}
                <th scope="col" class="text-center tbl_amnt_12">
                    Pack QTY
                </th>
                <th scope="col" class="text-center tbl_amnt_12">
                    Loose QTY
                </th>

                <th scope="col" class="text-center tbl_amnt_12">
                    Bonus
                </th>
                <th scope="col" class="text-center tbl_amnt_12">
                    UOM
                </th>
                {{--                <th scope="col" class="text-center tbl_amnt_20">--}}
                {{--                    Sale Invoice--}}
                {{--                </th>--}}

            </tr>

            </thead>

            <tbody>
            @php
                $i = 01; $ttl_pack=0; $ttl_loose=0;
            @endphp

            @foreach( $siims as $siim )
                @php
                    $db_qty=$siim->qty;
                 $scale_size=$siim->scale_size;
                 $pack_qty = floor($db_qty/$scale_size);
                 $loose_qty = fmod($db_qty, $scale_size);
                 $ttl_pack=$ttl_pack + $pack_qty;
                 $ttl_loose=$ttl_loose + $loose_qty;
                @endphp
                <tr class="even pointer">

                    <td class="tbl_srl_4 text-center">
                        {{ $i }}
                    </td>
                    <td class="align_left text-left tbl_txt_30">
                        {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $siim->name) !!}
                        @if(!empty($siim->remarks) && isset($siim->remarks))
                            <blockquote>
                                {!! str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br />', $siim->remarks) !!}
                            </blockquote>
                        @endif
                    </td>
                    {{--                    <td class="tbl_amnt_15 text-center">--}}
                    {{--                        {!! $siim->remarks !!}--}}
                    {{--                    </td>--}}
                    {{--                    <td class="tbl_amnt_8 text-center">--}}
                    {{--                        {!! $siim->qty !!}--}}
                    {{--                    </td>--}}
                    <td class="tbl_amnt_8 text-center">
                        {!! $pack_qty !!}
                    </td>
                    <td class="tbl_amnt_8 text-center">
                        {!! $loose_qty !!}
                    </td>
                    <td class="tbl_amnt_8 align_right text-right">
                        {{ $siim->bonus }}
                    </td>
                    <td class="tbl_amnt_8 align_right text-right">
                        {{ $siim->uom }}
                    </td>
                    {{--                    <td class="tbl_amnt_20 text-center">--}}
                    {{--                        DOSI-{!! $siim->status !!}--}}
                    {{--                    </td>--}}


                </tr>
                @php $i++; @endphp
            @endforeach
            <tr>
                <th colspan="2" class="text-right align_right">
                    Total:-
                </th>
                <td class="text-center align_center">
                    {{ number_format($ttl_pack,3) }}
                </td>
                <td class="text-center align_center">
                    {{number_format($ttl_loose,3)}}
                </td>
                <td class="text-center align_center">
                </td>
                <td class="text-center align_center">
                </td>
                {{--                <td class="text-right align_right">--}}
                {{--                    --}}{{--                    {{ number_format($ttlExcluProDis,2) }}--}}
                {{--                </td>--}}


            </tr>


            </tbody>
            <tfoot>

            </tfoot>
        </table>

        <table class="table table-bordered table-sm invc_vchr_fnt" style="padding-right:100px">
            <tbody>
            <tr>
                <td class="border-0 p-0">

                    <div class="sign_bx">
                                <span class="sign_itm">
                                    Prepared By
                                </span>
                    </div>

                    <div class="sign_bx">
                                <span class="sign_itm">
                                    Checked By
                                </span>
                    </div>

                    <div class="sign_bx">
                                <span class="sign_itm">
                                    Accounts Manager
                                </span>
                    </div>

                    <div class="sign_bx">
                                <span class="sign_itm">
                                    Chief Executive
                                </span>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>


    @if( $type === 'grid')

        <div class="itm_vchr_rmrks">
            <a href="{{ route('trade_delivery_challan_items_view_details_pdf_SH',['id'=>$sim->dc_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
                Download
            </a>

            <iframe style="display: none" id="printf" name="printf" src="{{ route('trade_delivery_challan_items_view_details_pdf_SH',['id'=>$sim->dc_id]) }}" title="W3Schools Free Online Web
            Tutorials">Iframe
            </iframe>

            <a href="#" id="printi" onclick="PrintFrame()" class="ml-2 align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
                Print
            </a>

        </div>

        {{--        <div class="itm_vchr_rmrks">--}}

        {{--            <a href="{{ route('delivery_challan_items_view_details_pdf_SH',['id'=>$sim->dc_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">--}}
        {{--                Download/Get PDF/Print--}}
        {{--            </a>--}}
        {{--        </div>--}}

        <div class="clearfix"></div>
        <div class="input_bx_ftr"></div>
    @endif
    <script>
        function PrintFrame() {
            window.frames["printf"].focus();
            window.frames["printf"].print();
        }
    </script>
@endsection
