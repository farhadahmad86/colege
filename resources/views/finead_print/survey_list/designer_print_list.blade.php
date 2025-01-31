
@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">

        <thead>
        {{--        <tr>--}}
        {{--            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_4">--}}
        {{--                <input type="checkbox" name="select-all" id="select-all"/>--}}
        {{--            </th>--}}
        {{--            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_4">--}}
        {{--                Sr#--}}
        {{--            </th>--}}
        {{--            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_6">--}}
        {{--                Zone--}}
        {{--            </th>--}}
        {{--            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_6">--}}
        {{--                Region--}}
        {{--            </th>--}}

        {{--            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_8">--}}
        {{--                City--}}
        {{--            </th>--}}
        {{--            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_txt_10">--}}
        {{--                Grid#--}}
        {{--            </th>--}}
        {{--            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_15">--}}
        {{--                Franchise Id--}}
        {{--            </th>--}}
        {{--            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_txt_6">--}}
        {{--                Shop Name--}}
        {{--            </th>--}}

        {{--            <th scope="col" align="center" class="align_center text-center tbl_txt_5">--}}
        {{--                Retailer Number--}}
        {{--            </th>--}}
        {{--            <th scope="col" align="center" class="align_center text-center tbl_txt_5">--}}
        {{--                Complete Address--}}
        {{--            </th>--}}

        {{--            --}}{{--                            <th scope="col" align="center" class="align_center text-center tbl_txt_15">--}}
        {{--            --}}{{--                                Images After--}}
        {{--            --}}{{--                            </th>--}}


        {{--            --}}{{--                            <th scope="col" align="center" class="align_center text-center tbl_amnt_5">--}}
        {{--            --}}{{--                                Execution--}}
        {{--            --}}{{--                            </th>--}}
        {{--            <th scope="col" align="center" class="text-center align_center tbl_txt_8">--}}
        {{--                Area--}}
        {{--            </th>--}}
        {{--            <th scope="col" align="center" class="text-center align_center tbl_txt_8">--}}
        {{--                Latitude--}}
        {{--            </th>--}}
        {{--            <th scope="col" align="center" class="align_center text-center tbl_amnt_5">--}}
        {{--                Longitude--}}
        {{--            </th>--}}


        {{--            <th scope="col" align="center" class="align_center text-center tbl_amnt_5">--}}
        {{--                BDO Name--}}
        {{--            </th>--}}
        {{--            <th scope="col" align="center" class="align_center text-center tbl_amnt_5">--}}
        {{--                BDO Number--}}
        {{--            </th>--}}
        {{--            <th scope="col" align="center" class="align_center text-center tbl_amnt_5">--}}
        {{--                Left (Inches)--}}
        {{--            </th>--}}
        {{--            <th scope="col" align="center" class="align_center text-center tbl_amnt_5">--}}
        {{--                Front (Inches)--}}
        {{--            </th>--}}
        {{--            <th scope="col" align="center" class="align_center text-center tbl_amnt_5">--}}
        {{--                Right (Inches)--}}
        {{--            </th>--}}
        {{--            <th scope="col" align="center" class="align_center text-center tbl_amnt_5">--}}
        {{--                Height (Inches)--}}
        {{--            </th>--}}
        {{--            <th scope="col" align="center" class="align_center text-center tbl_amnt_5">--}}
        {{--                Angle--}}
        {{--            </th>--}}
        {{--            <th scope="col" align="center" class="align_center text-center tbl_amnt_5">--}}
        {{--                Side--}}
        {{--            </th>--}}
        {{--            <th scope="col" align="center" class="align_center text-center tbl_amnt_5">--}}
        {{--                Skin Qty--}}
        {{--            </th>--}}

        {{--            <th scope="col" align="center" class="align_center text-center tbl_amnt_5">--}}
        {{--                Total SQFT--}}
        {{--            </th>--}}
        {{--            <th scope="col" align="center" class="align_center text-center tbl_amnt_5">--}}
        {{--                Shop SQFT--}}
        {{--            </th>--}}

        {{--        </tr>--}}


        <tr>
            {{--            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_4">--}}
            {{--                <input type="checkbox" name="select-all" id="select-all"/>--}}
            {{--            </th>--}}
            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_4">
                Sr#
            </th>
            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_6">
                Zone
            </th>
            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_6">
                Region
            </th>

            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_8">
                City
            </th>
            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_txt_10">
                Grid
            </th>
            <th tabindex="-1" scope="col" align="center" class="text-center align_center tbl_srl_15">
                Franchise Id
            </th>
            <th tabindex="-1" scope="col" align="center" class="align_center text-center tbl_txt_6">
                Shop Name
            </th>

            <th scope="col" align="center" class="align_center text-center tbl_txt_5">
                Retailer Number
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_txt_5">
                Complete Address
            </th>

                                        <th scope="col" align="center" class="align_center text-center tbl_txt_15">
                                            Images After
                                        </th>


                                        <th scope="col" align="center" class="align_center text-center tbl_amnt_5">
                                            Execution
                                        </th>
                        <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                            Area
                        </th>
                        <th scope="col" align="center" class="text-center align_center tbl_txt_8">
                            Latitude
                        </th>
                        <th scope="col" align="center" class="align_center text-center tbl_amnt_5">
                            Longitude
                        </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_5">
                DBO Name
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_5">
                BDO Number
            </th>



                        <th scope="col" align="center" class="align_center text-center tbl_amnt_5">
                            Left
                        </th>

                        <th scope="col" align="center" class="align_center text-center tbl_amnt_5">
                            Front
                        </th>

                        <th scope="col" align="center" class="align_center text-center tbl_amnt_5">
                            Right
                        </th>


                        <th scope="col" align="center" class="align_center text-center tbl_amnt_5">
                            Height
                        </th>

                        <th scope="col" align="center" class="align_center text-center tbl_amnt_5">
                            Angel
                        </th>

                        <th scope="col" align="center" class="align_center text-center tbl_amnt_5">
                            Side
                        </th>
                                    <th scope="col" align="center" class="align_center text-center tbl_amnt_5">
                                        Width
                                    </th>

                        <th scope="col" align="center" class="align_center text-center tbl_amnt_5">
                            QTY
                        </th>

                        <th scope="col" align="center" class="align_center text-center tbl_amnt_5">
                            Total SQFT
                        </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_5">
                Shop SQFT
            </th>

            <th scope="col" align="center" class="align_center text-center tbl_amnt_5">
                Product Name
            </th>



        </tr>



        </thead>

        <tbody>

        @php
            $sr = 1;
        @endphp
        @forelse($datas as $invoice)

            <tr>
                {{--                <td class="align_center text-center edit tbl_srl_4">--}}
                {{--                    <input type="checkbox" name="checkbox[]" value="{{$invoice->sri_id}}" id="{{$invoice->sri_id}}"/>--}}
                {{--                </td>--}}
                <td class="align_center text-center edit tbl_srl_4">
                    {{$sr}}
                </td>
                <td class="align_center text-center edit tbl_srl_6">
                    {{$invoice->region}}
                </td>
                <td class="align_center text-center edit tbl_srl_6">
                    {{$invoice->zone}}
                </td>
                <td class="align_center text-center edit tbl_srl_6">
                    {{$invoice->city}}
                </td>
                <td class="align_center text-center edit tbl_srl_6">
                    {{$invoice->grid}}
                </td>
                <td class="align_center text-center edit tbl_srl_6">
                    {{$invoice->franchise_code}}
                    {{$invoice->franchise}}
                    {{--                                    {{$invoice->projectName}}--}}
                </td>
                <td class="align_center text-center edit tbl_srl_8">
                    {{$invoice->sr_shop_name}}
                </td>
                <td class="align_center text-center edit tbl_srl_8">
                    {{$invoice->sr_contact}}
                </td>
                <td class="align_center text-center edit tbl_srl_8">
                    {{$invoice->sr_address}}
                </td>


                                <td class="align_center text-center edit tbl_srl_8">
                                    {{$invoice->sri_area}}
                                </td>
                                <td class="align_center text-center edit tbl_srl_8">
                                    {{$invoice->sri_latitude}}
                                </td>

                                <td class="align_center text-center edit tbl_srl_8">
                                    {{$invoice->sri_longitude}}
                                </td>


                <td class="align_left text-left tbl_txt_5">
                    {{$invoice->bdo_name}}
                </td>
                <td class="align_left text-left tbl_txt_5">
                    {{$invoice->bdo_contact}}
                </td>



                                                <td class="align_left text-left tbl_txt_5">
                                                    {{$invoice->sri_image_type}}
                                                </td>
                                                <td class="align_left text-left tbl_txt_5">
                                                    {{$invoice->sri_shop_story}}
                                                </td>


                                @php
                                    $f_length='';
                                    $r_length='';
                                    $l_length='';
                                        if($invoice->sri_image_type == "FRONT"){
                                        $f_length=$invoice->sri_total_length;
                                    }if($invoice->sri_image_type == "RIGHT"){
                                        $r_length=$invoice->sri_total_length;
                                    }if($invoice->sri_image_type == "LEFT"){
                                        $l_length=$invoice->sri_total_length;
                                    }
                                @endphp

                                <td class="align_left text-left tbl_txt_5">
                                    {{$l_length}}
                                </td>

                                <td class="align_left text-left tbl_txt_5">
                                    {{$f_length}}
                                </td>

                                <td class="align_left text-left tbl_txt_5">
                                    {{$r_length}}
                                </td>


                                <td class="align_left text-left tbl_txt_5">
                                    {{$invoice->sri_height}}
                                </td>

                                <td class="align_left text-left tbl_txt_5">
                                    {{$invoice->sri_angle_side}}

                                </td>

                                <td class="align_left text-left tbl_txt_5">
                                    {{$invoice->sri_double_side}}

                                </td>


                                                <td class="align_left text-left tbl_txt_5">
                                                    {{$invoice->sri_total_length}}
                                                </td>
                                <td class="align_left text-left tbl_txt_5">
                                    1
                                </td>


                <td class="align_left text-left tbl_txt_5">
                    {{$invoice->sri_total_sqft}}
                </td>
                <td class="align_left text-left tbl_txt_5">
                    {{$invoice->sr_shop_sqft}}
                </td>

                {{--                @foreach($sh_sqft as $shop_sqft)--}}

                {{--                    @if($shop_sqft->sri_sr_id == $invoice->sr_id)--}}
                {{--                        <td>{{$shop_sqft->shop_sqft}}</td>--}}
                {{--                        --}}{{--                                               --}}
                {{--                    @endif--}}

                {{--                @endforeach--}}


                <td class="align_left text-left tbl_txt_5">
                    {{$invoice->pro_title}}
                </td>



                {{--                <td class="d-none sqft_values">--}}
                {{--                                                            @foreach($imgs[$invoice->sr_id] as $a)--}}
                {{--                    <div class="d-none sqft_l">{{ $invoice->sri_image_type }}</div>--}}
                {{--                    <div class="d-none sqft_f">{{ $invoice->sri_tapa_gauge }}</div>--}}
                {{--                    <div class="d-none sqft_r">{{ $invoice->sri_depth }}</div>--}}
                {{--                    <div class="d-none sqft_h">{{ $invoice->sri_front_left_right_height_feet }}' {{ $invoice->sri_front_left_right_height_Inch }}";</div>--}}
                {{--                    <div class="d-none sqft_q">{{ $invoice->sri_quantity }}</div>--}}
                {{--                                                            @endforeach--}}
                {{--                </td>--}}


            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="15">
                    <center><h3 style="color:#554F4F">No Survey Found</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>

@endsection

