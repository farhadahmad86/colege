
@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">

        <thead>
        <tr>
            <th scope="col" class="tbl_srl_5">Sr#</th>
            <th scope="col" class="tbl_srl_5">ID</th>
            <th scope="col" class="tbl_txt_40">Province</th>
            <th scope="col" class="tbl_txt_50">City Name</th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr=1;
        @endphp
        @forelse($datas as $city)
            <tr>
                <th scope="ROW" class="edit ">{{$sr}}</tH>
                <td class="edit ">{{$city->city_id}}</td>
                <td class="edit">{{$city->city_prov}}</td>
                <td class="edit">{{$city->city_name}}</td>
            </tr>

            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h3 style="color:#554F4F">No City</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

@endsection

