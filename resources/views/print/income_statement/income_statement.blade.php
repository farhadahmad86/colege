
@extends('print.print_index')

@if( $type !== 'download_excel')
@section('print_title', $pge_title)
@endif

@section('print_cntnt')

    <table class="table border-0 table-sm">

        @if( $type === 'download_excel')
        <thead>
        <tr>
            <th class="align_left text-left tbl_txt_70"></th>
            <th class="align_right text-right tbl_amnt_15"></th>
            <th class="align_right text-right tbl_amnt_15"></th>
            {{--<th scope="col" style="width:80px; text-align: center !important" align="center">Party</th>--}}
            {{--<th scope="col" style="width:80px; text-align: center !important" align="center">Debit</th>--}}
            {{--<th scope="col" style="width:80px; text-align: center !important" align="center">Credit</th>--}}

        </tr>
        </thead>
        @endif

        <tbody >
        @if(!empty($income_statement) && isset($income_statement))

            <tr>
                <th class="align_left text-left tbl_txt_70">Sales</th>
                <td class="align_right text-right tbl_amnt_15">{{number_format($income_statement->is_sales,2)}}</td>
                <td class="align_right text-right tbl_amnt_15"></td>
            </tr>
            <tr>
                <th class="align_left text-left tbl_txt_70">LESS: Sales Return</th>
                <td class="align_right text-right tbl_amnt_15">
                    {{number_format($income_statement->is_sales_return,2)}}
                </td>
                <td class="align_right text-right tbl_amnt_15"></td>
            </tr>
            <tr>
                <th class="align_left text-left tbl_txt_70">Total Sales</th>
                <td class="align_right text-right tbl_amnt_15"></td>
                <td class="align_right text-right tbl_amnt_15">
                    {{number_format($income_statement->is_total_sales,2)}}
                </td>
            </tr>
            <tr>
                <th colspan="3" class="align_left text-left tbl_txt_70">Cost Of Goods Sold</th>

            </tr>
            <tr>
                <th class="align_left text-left tbl_txt_70">Opening Stock/Inventory</th>
                <td class="align_right text-right tbl_amnt_15">
                    {{number_format($income_statement->is_opening_inventory,2)}}
                </td>
                <td class="align_right text-right tbl_amnt_15"></td>
            </tr>
            <tr>
                <th class="align_left text-left tbl_txt_70">Add: Purchases</th>
                <td class="align_right text-right tbl_amnt_15">
                    {{number_format($income_statement->is_purchase,2)}}
                </td>
                <td class="align_right text-right tbl_amnt_15"></td>
            </tr>
            <tr>
                <th class="align_left text-left tbl_txt_70">LESS: Purchase Return</th>
                <td class="align_right text-right tbl_amnt_15">
                    {{number_format($income_statement->is_purchase_return,2)}}
                </td>
                <td class="align_right text-right tbl_amnt_15"></td>
            </tr>
            <tr>
                <th class="align_left text-left tbl_txt_70">Total Purchase</th>
                <td class="align_right text-right tbl_amnt_15">
                    {{number_format($income_statement->is_total_purchase,2)}}
                </td>
                <td class="align_right text-right tbl_amnt_15"></td>
            </tr>
            <tr>
                <th class="align_left text-left tbl_txt_70">Less: Ending Inventory</th>
                <td class="align_right text-right tbl_amnt_15">
                    {{number_format($income_statement->is_ending_inventory,2)}}
                </td>
                <td class="align_right text-right tbl_amnt_15"></td>
            </tr>
            <tr>
                <th class="align_left text-left tbl_txt_70">Less: Cost Of Goods Sold</th>
                <td class="align_right text-right tbl_amnt_15"></td>
                <td class="align_right text-right tbl_amnt_15">
                    {{number_format($income_statement->is_total_cgs,2)}}
                </td>
            </tr>
            <tr>
                <th class="align_left text-left tbl_txt_70">Gross Revenue One</th>
                <td class="align_right text-right tbl_amnt_15"></td>
                <td class="align_right text-right tbl_amnt_15">
                    {{number_format($income_statement->is_gross_revenue_one,2)}}
                </td>
            </tr>
            <tr>
                <th colspan="3" class="align_left text-left tbl_txt_70">Other Revenues</th>
            </tr>

            @foreach($datas as $account)
                @if($account->isi_type=='REVENUE')

                    <tr>
                        <td class="align_left text-left tbl_txt_70">
                            {{$account->isi_title}}
                        </td>
                        <td class="align_right text-right tbl_amnt_15">
                            {{number_format($account->isi_amount,2)}}
                        </td>
                        <td class="align_right text-right tbl_amnt_15"></td>
                    </tr>

                @endif
            @endforeach
            <tr>
                <th class="align_left text-left tbl_txt_70">Total Other Revenue</th>
                <td class="align_right text-right tbl_amnt_15"></td>
                <td class="align_right text-right tbl_amnt_15">
                    {{number_format($income_statement->is_other_total_revenue,2)}}
                </td>
            </tr>
            <tr>
                <th class="align_left text-left tbl_txt_70">Gross Revenue Two</th>
                <td class="align_right text-right tbl_amnt_15"></td>
                <td class="align_right text-right tbl_amnt_15">
                    {{number_format($income_statement->is_gross_revenue_two,2)}}
                </td>
            </tr>
            <tr>
                <th colspan="3" class="align_left text-left tbl_txt_70">Expenses</th>
            </tr>
            @foreach($datas as $account)
                @if($account->isi_type=='EXPENSE')

                    <tr>
                        <td class="align_left text-left tbl_txt_70">{{$account->isi_title}}</td>
                        <td class="align_right text-right tbl_amnt_15">
                            {{number_format($account->isi_amount,2)}}
                        </td>
                        <td class="align_right text-right tbl_amnt_15"></td>
                    </tr>

                @endif
            @endforeach
            <tr>
                <th class="align_left text-left tbl_txt_70">Total Expenses</th>
                <td class="align_right text-right tbl_amnt_15"></td>
                <td class="align_right text-right tbl_amnt_15">
                    {{number_format($income_statement->is_total_expense,2)}}
                </td>
            </tr>
            <tr>
                <th class="align_left text-left tbl_txt_70 total_value">
                    Total {{$income_statement->is_profit_loss}}
                </th>
                <td class="align_right text-right tbl_amnt_15"></td>
                <td class="align_right text-right tbl_amnt_15 total_value">
                    {{number_format($income_statement->is_profit_loss_amount,2)}}
                </td>
            </tr>

        @else
            <tr>
                <td colspan="8">
                    <center><h3 style="color:#554F4F">No Statement</h3></center>
                </td>
            </tr>
        @endif

        </tbody>

    </table>

@endsection

