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


        <table class="table invc_vchr_fnt">
            <thead>

            <tr class="headings vi_tbl_hdng">
                <th scope="col" align="center" class="text-center align_center tbl_srl_4">
                    Sr.
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_10">
                    Product Name
                </th>
                 <th scope="col" align="center" class="text-center align_center tbl_amnt_8">
                    Board Type
                </th>
                 <th scope="col" align="center" class="text-center align_center tbl_amnt_8">
                    Story
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_7">
                    Length Feet
                </th>
                <th scope="col" align="center" class="text-left align_left tbl_txt_7">
                    Length Inch
                </th>
                <th scope="col" align="center" class="text-left align_left tbl_txt_7">
                    Total Length
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_7">
                    Height Feet
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_7">
                    Height Inch
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_7">
                    Total Height
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_7">
                    Depth
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_7">
                    Tapa Gauge
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_7">
                    Back Sheet Gauge
                </th>
                <th scope="col" align="center" class="text-center align_center tbl_amnt_7">
                    Action
                </th>

            </tr>

            </thead>

            <tbody>
            @php $i = 1; $vchr_id = ''; @endphp



            @foreach( $items as $item )


                <tr class="even pointer">
                    {{--                    @php $surveyor_name =''; if ($item->account_name != null){$surveyor_name=$item->account_name;} else{$item->survey;}  @endphp--}}
                    <td class="align_center text-center tbl_srl_4">
                        {{ $i }}
                    </td>
                    <td align="center" class="align_center text-center tbl_amnt_10">
                        {{ $item->product_name }}
                    </td>
                    <td class="align_left text-left tbl_txt_8">
                        {!! $item->sri_image_type !!}
                    </td>
                    <td class="align_left text-left tbl_txt_8">
                        {!! $item->sri_shop_story !!}
                    </td>
                    <td class="align_left text-left tbl_txt_7">
                        {!! $item->sri_lengthFeet !!}
                    </td>
                    <td align="right" class="align_left text-left tbl_amnt_7">
                        {!! $item->sri_lengthInch !!}
                    </td>
                    <td align="right" class="align_left text-left tbl_amnt_7">
                        {!! $item->sri_total_length !!}
                    </td>
                    <td align="right" class="align_left text-left tbl_amnt_7">
                        {!! $item->sri_front_left_right_height_feet !!}
                    </td>
                    <td align="right" class="align_left text-left tbl_amnt_7">
                        {!! $item->sri_front_left_right_height_Inch !!}
                    </td>
                    <td align="right" class="align_left text-left tbl_amnt_7">
                        {!! $item->sri_height !!}
                    </td>
                    <td align="right" class="align_left text-left tbl_amnt_7">
                        {!! $item->sri_depth !!}
                    </td>
                    <td align="right" class="align_left text-left tbl_amnt_7">
                        {!! $item->sri_tapa_gauge !!}
                    </td>
                    <td align="right" class="align_left text-left tbl_amnt_7">
                        {!! $item->sri_back_sheet_gauge !!}
                    </td>
                    <td class="align_center  text-right hide_column tbl_srl_7">
                        <a href="{{route('delete_batch_item',$item->sri_id)}}" class="delete" onclick="return confirm('Are you sure you want to delete this item?');">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
                @php $i++; @endphp
            @endforeach

            </tbody>


        </table>
    </div>

    @if( $type === 'grid')
        <div class="itm_vchr_rmrks">

            <a href="{{ route('batch_items_view_details_pdf_SH',['id'=>$csh_rcpt->bat_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
                Download/Get PDF/Print
            </a>
        </div>
        <div class="clearfix"></div>
        <div class="input_bx_ftr"></div>
    @endif

@endsection
