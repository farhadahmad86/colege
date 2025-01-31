{{--{{$getRaw}}--}}

{{--<table class="table table-bordered table-sm gnrl-mrgn-pdng" id="category_dynamic_table">--}}
{{--    <thead>--}}
{{--    <tr>--}}
{{--        <th class="text-center tbl_srl_4"> Sr.</th>--}}
{{--        <th class="text-center tbl_srl_9"> Code</th>--}}
{{--        <th class="text-center tbl_txt_20"> Title</th>--}}
{{--        <th class="text-center tbl_txt_22"> Product Remarks</th>--}}
{{--        <th class="text-center tbl_srl_6"> UOM</th>--}}
{{--        <th class="text-center tbl_srl_10"> Recipe Consumption</th>--}}
{{--        <th class="text-center tbl_srl_8"> %</th>--}}
{{--        <th class="text-center tbl_srl_10"> Reqd. Production Qty</th>--}}
{{--        <th class="text-center tbl_srl_10"> In Hand Stock</th>--}}
{{--    </tr>--}}
{{--    </thead>--}}

{{--    <tbody id="budgetRawStock">--}}
{{--    <tr>--}}
{{--        <td colspan="10" align="center">--}}
{{--            No Account Added--}}
{{--        </td>--}}
{{--    </tr>--}}
{{--    </tbody>--}}

{{--</table>--}}

@extends('invoice_view.print_index')

@section('print_cntnt')

    {{--    @php--}}
    {{--        $company_info = Session::get('company_info');--}}
    {{--    @endphp--}}


    <div id="" class="table-responsive">


        <table class="table table-bordered table-sm">
            <thead>
            <tr class="headings vi_tbl_hdng">
                <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                    Sr.
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_20">
                    Code
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_txt_25">
                    Title
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_txt_31">
                    Product Remarks
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_10">
                    UOM
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_9">
                    Recipe Consumption
                </th>
{{--                <th scope="col" align="center" class="text-center align_center tbl_amnt_6">--}}
{{--                    %--}}
{{--                </th>--}}
{{--                <th scope="col" align="center" class="text-center align_center tbl_amnt_6">--}}
{{--                    Reqd. Production Qty--}}
{{--                </th>--}}
                <th scope="col" align="center" class="text-center align_center tbl_amnt_6">
                    In Hand Stock
                </th>
            </tr>
            </thead>

            <tbody>
{{--            $grand_total = $ttl_cr=0;--}}
                        @php $i = 01;  @endphp
            @foreach( $getRaw as $item )
                <tr class="even pointer">
                    <td class="align_center text-center tbl_srl_4">
                        {{ $i }}
                    </td>
                    <td align="center" class="align_center text-center tbl_amnt_20">
                        {{ $item->pro_code }}
                    </td>
                    <td class="align_left text-left tbl_txt_25">
                        {!! $item->pro_name !!}
                    </td>
                    <td class="align_left text-left tbl_txt_31">
                        {!! $item->pro_remarks !!}
                    </td>
                    <td class="align_left text-left tbl_txt_10">
                        {!! $item->pro_uom !!}
                    </td>
                    <td class="align_left text-left tbl_txt_10">
                        {!! $item->quantity !!}
                    </td>

                    <td class="align_left text-left tbl_txt_10">
                        {!! $item->pro_available_quantity !!}
                    </td>


                </tr>
                                @php $i++;  @endphp
            @endforeach
            <tr class="border-0">
                <th colspan="5" align="right" class="border-0 pt-0 text-right align_right">
                    Grand Total:
                </th>
                {{--                <td class="text-right align_right border-left-0 border-right-0 border-top-2 border-bottom-3" align="right">--}}
                {{--                    {{ number_format($ttl_dr,2) }}--}}
                {{--                </td>--}}
                <td class="text-right align_right border-left-0 border-right-0 border-top-2 border-bottom-3"
                    align="right">
                    {{--                    {{ number_format($ttl_cr,2) }}--}}
                </td>
            </tr>


            </tbody>


        </table>

                <div class="clearfix"></div>
                @if( $type === 'grid')
                    <div class="itm_vchr_rmrks">
{{--                        <a href="{{ route('expense_items_view_details_pdf_SH',['id'=>$jrnl->pc_id]) }}"--}}
{{--                           class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">--}}
{{--                            Download/Get PDF/Print--}}
{{--                        </a>--}}
                    </div>
                @endif

    </div>
    <div class="input_bx_ftr"></div>

@endsection




