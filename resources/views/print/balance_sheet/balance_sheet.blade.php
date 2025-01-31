
@extends('print.print_index')

@if( $type !== 'download_excel')
@section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">

        <thead>
        <tr>
            <th scope="col" align="center" class="align_center text-center tbl_txt_70">
                Narration
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_15">
                Cr.
            </th>
            <th scope="col" align="center" class="align_center text-center tbl_amnt_15">
                Dr.
            </th>
        </tr>
        </thead>

        <tbody>

        @if((isset($assets_items) && !empty($assets_items))  && (isset($liabilities_items) && !empty($liabilities_items))  && (isset($equities_items) && !empty($equities_items)))

            <tr>
                <th class="align_left text-left" colspan="3">
                    Assets
                </th>
            </tr>

            @forelse($assets_items as $assets_item)
                <tr>
                    <td class="align_left text-left tbl_txt_70">
                        {{$assets_item->bsi_title}}
                    </td>
                    <td class="align_right text-right tbl_amnt_15"></td>
                    <td class="align_right text-right tbl_amnt_15">
                        {{number_format($assets_item->bsi_amount,2)}}
                    </td>
                </tr>
            @empty
            @endforelse

            <tr>
                <th class="align_left text-left" colspan="2">
                    Total Assets
                </th>
                <th class="align_right text-right tbl_amnt_15">
                    {{ number_format($balance_sheet-> bs_total_assets,2)}}
                </th>
            </tr>

            {{--                            <tr>--}}
            {{--                                <td class="align_left" colspan="3"> </td>--}}
            {{--                            </tr>--}}

            <tr>
                <th class="align_left text-left" colspan="3">Liabilities</th>
            </tr>

            @forelse($liabilities_items as $liabilities_item)
                <tr>
                    <td class="align_left text-left tbl_txt_70">
                        {{$liabilities_item->bsi_title}}
                    </td>
                    <td class="align_right text-right tbl_amnt_15">
                        {{number_format($liabilities_item->bsi_amount,2)}}
                    </td>
                    <td class="align_right text-right tbl_amnt_15"></td>
                </tr>
            @empty
            @endforelse

            <tr>
                <th class="align_left text-left tbl_txt_70" colspan="2">Total Liabilities</th>
                <th class="align_right text-right tbl_amnt_15">
                    {{ number_format($balance_sheet-> bs_total_liabilities,2)}}
                </th>
            </tr>

            {{--                            <tr>--}}
            {{--                                <td class="align_left" colspan="3"> </td>--}}
            {{--                            </tr>--}}

            <tr>
                <th class="align_left text-left" colspan="3">Equity</th>
            </tr>

            @forelse($equities_items as $equities_item)
                <tr>
                    <td class="align_left text-left tbl_txt_70">
                        {{$equities_item->bsi_title}}
                    </td>
                    <td class="align_right text-right tbl_amnt_15">
                        {{number_format($equities_item->bsi_amount,2)}}
                    </td>
                    <td class="align_right text-right tbl_amnt_15"></td>
                </tr>
            @empty
            @endforelse
            <tr>
                <th class="align_left text-left" colspan="2">Total Equity</th>
                <th class="align_right text-right tbl_amnt_15">
                    {{ number_format($balance_sheet-> bs_total_equity,2)}}
                </th>
            </tr>

            <tr>
                <th class="align_left text-left" colspan="2">Total Liability And Equity</th>
                <th class="align_right text-right tbl_amnt_15">
                    {{ number_format($balance_sheet-> bs_liabilities_and_equity,2)}}
                </th>
            </tr>


        @endif

        </tbody>

    </table>

@endsection

