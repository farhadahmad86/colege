
@extends('print.print_index')

@if( $type !== 'download_excel')
@section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table table-bordered table-sm">

        <thead>
        <tr>
            <th scope="col"  class="tbl_srl_4">
                Sr#
            </th>
            <th scope="col"  class="tbl_txt_20">
                Recipe Name
            </th>
            <th scope="col"  class="tbl_txt_31">
                Remarks
            </th>
            <th scope="col"  class="tbl_txt_20">
                Finished Good
            </th>
            <th scope="col"  class="tbl_amnt_8">
                Qty
            </th>
            <th scope="col"  class="tbl_txt_6">
                UOM
            </th>
            <th scope="col"  class="tbl_txt_10">
                Created By
            </th>
        </tr>
        </thead>

        <tbody>
        @php
            $sr =  1;
        @endphp
        @forelse($datas as $product_recipe)

            <tr>
                <th scope="row" class="edit">
                    {{$sr}}
                </th>
                <td class="edit">
                    {{$product_recipe->pr_name}}
                </td>
                <td class="edit">
                    {{$product_recipe->pr_remarks}}
                </td>
                <td class="edit">
                    {{$product_recipe->pri_product_name}}
                </td>
                <td class="text-right edit ">
                    {{$product_recipe->pri_qty}}
                </td>
                <td class="edit">
                    KG
                </td>

                <td class="usr_prfl">
                    {{ $product_recipe->user_name }}
                </td>


            </tr>
            @php
                $sr++;
            @endphp
        @empty
            <tr>
                <td colspan="11">
                    <center><h3 style="color:#554F4F">No Entry</h3></center>
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>

@endsection

