
@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">

        <thead>
        <tr>
{{--            <th scope="col" align="center" class="text-center align_center tbl_srl_4">--}}
            {{--                                SR #--}}
            {{--                            </th>--}}
            <th scope="col" align="center" class="align_center text-center tbl_txt_10">
                Product Title
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                Warehouse
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                Stock
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                Average Rate
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_6">
                Stock Value
            </th>
        </tr>
        </thead>

        <tbody>
        @forelse($datas as $result)

            <tr>

{{--                <td class="align_center text-center edit tbl_srl_4">--}}
                {{--                                    {{$sr}}--}}
                {{--                                </td>--}}

                {{--                                <td class="align_center text-center edit tbl_amnt_10">--}}
                {{--                                    {{$result->pro_p_code}}--}}
                {{--                                </td>--}}
                <td class="align_left text-left edit tbl_amnt_10">
                    {{$result->pro_title}}
                </td>
                <td class="align_center text-center edit tbl_amnt_6">
                    {{$result->wh_title}}
                </td>
                <td class="align_center text-center edit tbl_amnt_6">
                    {{$result->whs_stock}}
                </td>
                <td class="align_center text-center edit tbl_txt_6">
                    {{$result->pro_average_rate}}
                </td>

                <td class="align_center text-center edit tbl_txt_6">
                    {{number_format($result->whs_stock * $result->pro_average_rate,2)}}
                </td>

            </tr>
        @empty
            <tr>
                <td colspan="11">
                    <center><h3 style="color:#554F4F">No Stock</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>

@endsection

