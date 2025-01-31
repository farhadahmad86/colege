
@extends('print.print_index')

@if( $type !== 'download_excel')
    @section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">
        <thead>
        <tr>
            <th scope="col" align="center">Date</th>
            <th scope="col" align="center">Product Code</th>
            <th scope="col" align="center">Product Name</th>
            <th scope="col" align="center">Quantity</th>
            <th scope="col" align="center">Transfer To</th>
            <th scope="col" align="center">Transfer From</th>
            <th scope="col" align="center">Remarks</th>
        </tr>
        </thead>
        <tbody>
        @php
            $sr=1;
        @endphp
        @forelse($datas as $product)

            <tr>
                <td class="align_left">{{$product->pth_datetime}}</td>
                <td class="align_left">{{$product->pro_p_code}}</td>
                <td class="align_left">{{$product->pro_title}}</td>
                <td class="align_right">{{$product->pth_stock}}</td>
                <td class="align_left">{{$product->to}}</td>
                <td class="align_left">{{$product->from}}</td>
                <td class="align_left">{{$product->pth_remarks}}</td>
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
    </table>

@endsection

