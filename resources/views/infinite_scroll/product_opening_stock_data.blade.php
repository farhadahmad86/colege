@php
    // $segmentSr  = (!empty(app('request')->input('segmentSr'))) ? app('request')->input('segmentSr') : '';
    // $segmentPg  = (!empty(app('request')->input('page'))) ? app('request')->input('page') : '';
    // $sr = (!empty($segmentSr)) ? $segmentSr * $segmentPg - $segmentSr + 1 : 1;
     $sr = 1;
    // $countSeg = (!empty($segmentSr)) ? $segmentSr : 0;
@endphp

@forelse($datas as $product)

    <tr>
        <th scope="row">
            {{$product->pro_id}}
        </th>
        <td>
            {{$product->grp_title}}
        </td>
        <td >
            {{$product->cat_title}}
        </td>
        <td nowrap="">
            {{$product->pro_p_code}}
        </td>
        <td>
            {{$product->pro_title}}
        </td>

        <td nowrap="" class="align_right text-right">
            <span id="p{{$product->pro_id}}" class="validate_sign"> </span>
            <input type="text"
                   class="form-control w-100 border-radius-0 border-0 text-right"
                   value="{{old('p_rate.'.$product->pro_id, $product->pro_purchase_price)}}"
                   name="p_rate[]"
                   id="p_rate{{$product->pro_id}}" data-id="{{$product->pro_id}}"
                   onkeyup="balance_calculation({{$product->pro_id}});"
                   onkeypress="return allow_only_number_and_decimals(this,event);"
                   onfocus="this.select();">

            <input type="hidden" name="id[]" class="form-control"
                   value="{{$product->pro_p_code}}"/>
        </td>
        <td nowrap="" class="align_right text-right">
            <span id="b{{$product->pro_id}}" class="validate_sign"> </span>
            <input type="text"
                   class="form-control w-100 border-radius-0 border-0 text-right"
                   value="{{old('b_rate.'.$product->pro_id, $product->pro_bottom_price)}}"
                   name="b_rate[]"
                   id="b_rate{{$product->pro_id}}" data-id="{{$product->pro_id}}"
                   onkeypress="return allow_only_number_and_decimals(this,event);"
                   onfocus="this.select();">
        </td>
        <td nowrap="" class="align_right text-right">
            <span id="s{{$product->pro_id}}" class="validate_sign"> </span>
            <input type="text"
                   class="form-control w-100 border-radius-0 border-0 text-right"
                   value="{{old('s_rate.'.$product->pro_id, $product->pro_sale_price)}}"
                   name="s_rate[]"
                   id="s_rate{{$product->pro_id}}" data-id="{{$product->pro_id}}"
                   onkeypress="return allow_only_number_and_decimals(this,event);"
                   onfocus="this.select();">
        </td>


        <td nowrap="" class="align_right text-right" hidden>
            <span id="sca{{$product->pro_id}}" class="validate_sign"> </span>
            <input type="text"
                   class="form-control w-100 border-radius-0 border-0 text-right"
                   value="{{$product->unit_scale_size}}"
                   name="scale_size[]"
                   id="scale_size{{$product->pro_id}}" data-id="{{$product->pro_id}}"
                   onkeyup="balance_calculation({{$product->pro_id}})" ; onkeypress="return allow_only_number_and_decimals(this,
                                               event);"
                   onfocus="this
                                               .select();">
        </td>
        @php
            $scale_size = $product->unit_scale_size;
            $product_qty = $product->pro_quantity;
                $pack_qty =(int)($product_qty / $scale_size);

        @endphp
        <td nowrap="" class="align_right text-right">
            <span id="pq{{$product->pro_id}}" class="validate_sign"> </span>
            <input type="text"
                   class="form-control w-100 border-radius-0 border-0 text-right"
                   value="{{$pack_qty}}"
                   name="pack_quantity[]"
                   id="pack_quantity{{$product->pro_id}}" data-id="{{$product->pro_id}}"
                   onkeyup="balance_calculation({{$product->pro_id}})" ; onkeypress="return allow_only_number_and_decimals(this,
                                               event);"
                   onfocus="this
                                               .select();">
        </td>
        @php
            $loose_qty = fmod($product_qty, $scale_size);
        @endphp
        <td nowrap="" class="align_right text-right">
            <span id="lq{{$product->pro_id}}" class="validate_sign"> </span>
            <input type="text"
                   class="form-control w-100 border-radius-0 border-0 text-right"
                   value="{{$loose_qty}}"
                   name="loose_quantity[]"
                   id="loose_quantity{{$product->pro_id}}" data-id="{{$product->pro_id}}"
                   onkeyup="balance_calculation({{$product->pro_id}})" ; onkeypress="return allow_only_number_and_decimals(this,
                                               event);"
                   onfocus="this
                                               .select();">
        </td>

        <td nowrap="" class="align_right text-right" readonly>
            <span id="q{{$product->pro_id}}" class="validate_sign"> </span>
            <input type="text"
                   class="form-control w-100 border-radius-0 border-0 text-right"
                   value="{{old('quantity.'.$product->pro_id, $product->pro_quantity)}}"
                   name="quantity[]"
                   id="quantity{{$product->pro_id}}" data-id="{{$product->pro_id}}"
                   onkeyup="balance_calculation({{$product->pro_id}})" ;
                   onkeypress="return allow_only_number_and_decimals(this,event);"
                   onfocus="this
                                               .select();" readonly>
        </td>

        @php
            $total_amount=$product->pro_purchase_price * $product->pro_quantity;
        @endphp
        <td nowrap="" class="align_right text-right td_total" id="td_total">
            <input type="text"
                   class="form-control w-100 border-radius-0 border-0 text-right total_amount"
                   name="total_amount[]" value="{{$total_amount}}"
                   id="total_amount{{$product->pro_id}}" data-id="{{$product->pro_id}}"
                   onkeypress="return allow_only_number_and_decimals(this,event);"
                   readonly>
        </td>
        @php
            $ip_browser_info= ''.$product->pro_ip_adrs.','.str_replace(' ','-',$product->pro_brwsr_info).'';
        @endphp

    </tr>
    @php
        $sr++;
        //$sr++; (!empty($segmentSr) && $countSeg !== '0') ?  : $countSeg++;
    @endphp
@empty
{{--    <tr>--}}
{{--        <td colspan="12">--}}
{{--            <center><h3 style="color:#554F4F">No Product</h3></center>--}}
{{--        </td>--}}
{{--    </tr>--}}
@endforelse
