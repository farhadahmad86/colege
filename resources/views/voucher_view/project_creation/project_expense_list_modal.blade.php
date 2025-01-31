@extends('invoice_view.print_index')

@section('print_cntnt')

    @php
        $company_info = Session::get('company_info');
    @endphp


    <div id="" class="table-responsive">

        <table class="table table-bordered table-sm">
            @if($type === 'grid')
                @include('voucher_view._partials.pdf_header', [$invoice_nbr, $invoice_date, $pge_title, $invoice_remarks])
            @endif
        </table>


        <table class="table table-bordered table-sm">
            <thead>
            <tr class="headings vi_tbl_hdng">
                <th scope="col"  class="text-center  tbl_srl_4">
                    Sr.
                </th>
                <th scope="col"  class="text-center  tbl_amnt_20">
                    Expense Account
                </th>
                <th scope="col"  class="text-center  tbl_txt_25">
                    Account Party
                </th>
                <th scope="col"  class="text-center  tbl_txt_31">
                    Remarks
                </th>
                <th scope="col"  class="text-center  tbl_amnt_10">
                    Limit %
                </th>
                <th scope="col"  class="text-center  tbl_amnt_9">
                    Limit (Rs.)
                </th>
                <th scope="col"  class="text-center  tbl_amnt_6">
                    Enable
                </th>
            </tr>
            </thead>

            <tbody>
            @php $i = 01; $grand_total = $ttl_cr=0; @endphp
            @foreach( $items as $item )
                <tr class="even pointer">
                    <td class=" text-center tbl_srl_4">
                        {{ $i }}
                    </td>
                    <td  class=" text-center tbl_amnt_20">
                        {{ $item->ebi_expense_name }}
                    </td>
                    <td class="align_left text-left tbl_txt_25">
                        {!! $item->ebi_party_name !!}
                    </td>
                    <td class="align_left text-left tbl_txt_31">
                        {!! $item->ebi_remarks !!}
                    </td>
                    <td class="align_left text-left tbl_txt_10">
                        {!! $item->ebi_limit_per !!}
                    </td>

                    <td align="right" class="align_right text-right tbl_amnt_9">
                        @php

                            $CR = $item->ebi_limit_amount;
                            $ttl_cr = +$ttl_cr + +$CR;
                        @endphp
                        {!! $item->ebi_limit_amount !!}
                    </td>

                    <td class="align_right text-right hide_column tbl_amnt_6">
                        <label class="switch">
                            <input type="checkbox" <?php if ($item->ebi_disabled == 0) {
                                echo 'checked="true"' . ' ' . 'value=' . $item->ebi_disabled;
                            } else {
                                echo 'value=DISABLE';
                            } ?>  class="enable_disable" data-id="{{$item->ebi_id}}"
                                {{ $item->ebi_disabled == 0 ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    </td>

                </tr>
                @php $i++;  @endphp
            @endforeach
            <tr class="border-0">
                <th colspan="5" align="right" class="border-0 pt-0 text-right align_right">
                    Grand Total:
                </th>
{{--                <td class="text-right align_right border-left-0 border-right-0 border-top-2 border-bottom-3" align="right">--}}
{{--                    {{ number_format($ttl_dr,2) }}--}}
{{--                </td>--}}
                <td class="text-right align_right border-left-0 border-right-0 border-top-2 border-bottom-3" align="right">
                    {{ number_format($ttl_cr,2) }}
                </td>
            </tr>


            </tbody>


        </table>

        <div class="clearfix"></div>
        @if( $type === 'grid')
            <div class="itm_vchr_rmrks">
                <a href="{{ route('expense_items_view_details_pdf_SH',['id'=>$jrnl->pc_id]) }}" class="align_right text-center btn btn-sm btn-info" style="float: left;margin-top: 7px;">
                    Download/Get PDF/Print
                </a>
            </div>
        @endif

    </div>
    <div class="input_bx_ftr"></div>
    <script>

        $(document).ready(function () {

            $('.enable_disable').change(function () {
                let status = $(this).prop('checked') === true ? 0 : 1;
                let expId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('enable_disable_project_expense') }}',
                    data: {'status': status, 'exp_id': expId},
                    success: function (data) {
                        console.log(data.message);
                    }
                });
            });
        });
    </script>
@endsection




