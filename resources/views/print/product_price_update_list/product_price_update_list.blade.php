
@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">

        <thead>
        <tr>
            <th nowrap="" scope="col" align="center" class="align_center text-center tbl_srl_4">
                Sr#
            </th>
            <th nowrap="" scope="col" align="center" class="align_center text-center tbl_srl_4">
                ID
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_13">
                Group
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_13">
                Category
            </th>
            <th nowrap="" scope="col" align="center" class="align_center text-center tbl_amnt_13">
                Product Code
            </th>
            <th nowrap="" scope="col" align="center" class="align_center text-center tbl_txt_23">
                Product Title
            </th>
            <th nowrap="" scope="col" align="center" class="align_center text-center tbl_amnt_11">
                Purchase Price
            </th>
            <th nowrap="" scope="col" align="center" class="align_center text-center tbl_amnt_11">
                Bottom Price
            </th>
            <th nowrap="" scope="col" align="center" class="align_center text-center tbl_amnt_13">
                Sale Price
            </th>
            {{--                                <th nowrap="" scope="col" align="center" class="align_center text-center tbl_amnt_13">--}}
            {{--                                    Qty--}}
            {{--                                </th>--}}
            <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                Created By
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr = 1;
            $prchsPrc = $slePrc = $avrgPrc = 0;
        @endphp
        @forelse($datas as $index=> $product)

            <tr>
                <td class="align_center text-center tbl_srl_4">
                    {{$sr}}
                </td>
                <td class="align_center text-center tbl_srl_4">
                    {{$product->grp_id}}
                </td>
                <td class="align_center text-center tbl_amnt_13">
                    {{$product->grp_title}}
                </td>
                <td class="align_center text-center tbl_amnt_11">
                    {{$product->cat_title}}
                </td>
                <td nowrap="" class="align_center text-center tbl_amnt_11">
                    {{$product->pro_p_code}}
                </td>
                <td nowrap="" class="align_left text-left tbl_txt_23">
                    {{$product->pro_title}}
                </td>
                <td nowrap="" class="align_right text-right tbl_amnt_13">
                    {{$product->pro_p_code}}
                </td>
                <td nowrap="" class="align_right text-right tbl_amnt_13">
                    {{$product->pro_bottom_price}}
                </td>
                <td nowrap="" class="align_right text-right tbl_amnt_13">
                    {{$product->pro_sale_price}}
                </td>

                {{--                                    <td nowrap="" class="align_right text-right tbl_amnt_13">--}}
                {{--                                        <span id="q{{$index}}" class="validate_sign"> </span>--}}
                {{--                                        <input type="text" class="form-control w-100 border-radius-0 border-0 text-right" value="{{old('quantity.'.$index, $product->pro_quantity)}}" name="quantity[]"--}}
                {{--                                               id="quantity{{$index}}" data-id="{{$index}}" onkeypress="return allow_only_number_and_decimals(this,event);" onfocus="this.select();">--}}
                {{--                                    </td>--}}

                @php
                    $ip_browser_info= ''.$product->pro_ip_adrs.','.str_replace(' ','-',$product->pro_brwsr_info).'';
                @endphp

                <td class="align_left usr_prfl text-left tbl_txt_8" data-usr_prfl="{{ $product->user_id }}" data-user_info="{!! $ip_browser_info !!}"
                    title="Click To See User Detail">
                    {{ $product->user_name }}
                </td>

            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h3 style="color:#554F4F">No Product</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>

{{--        <tr>--}}
{{--            <th align="right" colspan="8" class="align_right text-right border-0">--}}
{{--                Page Total:---}}
{{--            </th>--}}
{{--            <td align="right" class="align_right text-right border-0">--}}
{{--                {{ number_format($prchsPrc,2) }}--}}
{{--            </td>--}}
{{--            <td align="right" class="align_right text-right border-0">--}}
{{--                {{ number_format($slePrc,2) }}--}}
{{--            </td>--}}
{{--            <td align="right" class="align_right text-right border-0">--}}
{{--                {{ number_format($avrgPrc,2) }}--}}
{{--            </td>--}}
{{--        </tr>--}}

    </table>

@endsection

